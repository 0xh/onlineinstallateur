<?php

namespace Scraper\Commands;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Thelia\Command\ContainerAwareCommand;
use Thelia\Tools\URL;
use Scraper\Controller\Scrapers\Megabad;
use Scraper\Controller\Scrapers\Reuter;
use Scraper\Controller\Scrapers\Skybad;
use Scraper\Controller\Scrapers\Google;
use Scraper\Controller\Scrapers\Idealo;
use const DS;
use const THELIA_LOCAL_DIR;
use Thelia\Model\ProductQuery;
use Thelia\Model\Map\ProductTableMap;
use Thelia\Model\Product;
use Thelia\Model\ProductSaleElements;
use RevenueDashboard\Model\WholesalePartnerProduct;
use RevenueDashboard\Model\WholesalePartnerProductQuery;

class ScraperListCommand extends ContainerAwareCommand
{

    private $match_threshold = 100;
    private $no_match_count  = 0;
    private $total_parsed    = 0;

    protected function configure()
    {
        $this
         ->setName("scraperListPrice")
         ->setDescription("List based price scraper")
         ->addArgument(
          'platform', InputArgument::REQUIRED, 'Specify paltform - skybad,reuter,megabad')
         ->addArgument(
          'version', InputArgument::REQUIRED, 'Specify import version')
         ->addArgument(
          'startline', InputArgument::REQUIRED, 'Specify list start line number')
         ->addArgument(
          'stopline', InputArgument::REQUIRED, 'Specify list stop line number')
         ->addArgument(
          'firstrun', InputArgument::REQUIRED, 'Specify if the scraper should create products or not')
         ->addArgument(
          'reimport', InputArgument::OPTIONAL, 'Specify if any existing files should be reimported')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $import_type = null;
        $import_file = null;
        $errors      = null;

        $platform  = $input->getArgument('platform');
        $startline = $input->getArgument('startline');
        $stopline  = $input->getArgument('stopline');
        $version   = $input->getArgument('version');
        $firstrun  = $input->getArgument('firstrun');
        $reimport  = $input->getArgument('reimport');

        $URL        = new URL();
        $local_file = "";
        if ($reimport == 0) {
            $local_file = Common::fetchfromFTP("ShtScraper", "Artikelliste.csv");
        } else {
            $local_file = $newFile    = THELIA_LOCAL_DIR . "sepa" . DS . "import" . DS . "ShtScraper" . DS . "Artikelliste.csv";
        }


        $newFile = THELIA_LOCAL_DIR . "sepa" . DS . "import" . DS . "ShtScraper" . DS . "Artikelliste" . date('_m.d.Y_H.i.s') . ".csv";

        if ($local_file != null) {
            echo "copied file from ftp \n";
            $csv_output = $this->formatFileForImport($local_file, $newFile, $startline, $stopline);
        } else {
            echo "Error copying file from ftp \n";
            return;
        }

        $versionFile = THELIA_LOCAL_DIR . "sepa" . DS . "import" . DS . "ShtScraper" . DS . $version . ".csv";

        $arrayProducts = array();
        if (!file_exists($versionFile)) {
            if (($handle = fopen($csv_output, "r+")) !== FALSE) {
                $row          = 0;
                $productQuery = ProductQuery::create();

                while (($data = fgetcsv($handle, 10000, ",")) !== FALSE) {
                    if ($row != 0) {
                        $partnerProductRef = $data[2];
                        $productQuery->clear();
                        $product           = $productQuery->
                         where(ProductTableMap::REF . " like '%" . $partnerProductRef . "%'")
                         ->findOne();
                        if ($product == null && $firstrun == 1) {
                            $product = new Product();
                            $product->setRef("SCRAPER_" . $partnerProductRef); // must be unique
                            $product->setVisible(0);
                            $product->setDefaultCategory("382");
                            $product->setVersionCreatedBy($version);
                            $product->save();
                            echo 'created ' . $product->getRef() . "\n";
                        }

                        if ($firstrun == 1 && count($product->getProductSaleElementss()) > 0) {
                            $pse = $product->getProductSaleElementss()[0];
                            $pse->setEanCode($data[3]);
                            $pse->save();
                        } else {
                            $pse = new ProductSaleElements();
                            $pse->setProduct($product);
                            $pse->setEanCode($data[3]);
                            echo "Pse Created \n";
                        }

                        if ($firstrun == 1) {
                            $findWPP = WholesalePartnerProductQuery::create()->findOneByPartnerProdRef($partnerProductRef);
                            if ($findWPP == null) {
                                $wpp = new WholesalePartnerProduct();
                            } else {
                                $wpp = $findWPP;
                            }
                            $wpp->setPartnerProdRef($partnerProductRef)
                             ->setProductId($product->getId())
                             ->setPartnerId(1)
                             ->setVersionCreatedBy($version)
                             ->setComment($data[0])
                             ->save();
                            echo "New wholesale partner product: " . $wpp->getId() . " KEY " . $data[0] . " \n";
                        }

                        array_push($arrayProducts, array("KEY"         => $data[0],
                         "Logistik_MC" => $data[1],
                         "extern_id"   => $data[2],
                         "EAN"         => $data[3],
                         "Description" => $data[4],
                         "prod_id"     => $product->getId()
                        ));
                        file_put_contents($versionFile, array($data[0] . ",", $data[1] . ",", $data[2] . ",", $data[3] . ",",
                         $data[4] . ",", $product->getId() . PHP_EOL), FILE_APPEND);
                    } else {
                        file_put_contents($versionFile, array("KEY,", "Logistik_MC,", "extern_id,", "EAN,", "Description,",
                         "prod_id" . PHP_EOL), FILE_APPEND);
                    }
                    $row++;
                    if ($this->no_match_count == $this->match_threshold) {
                        $this->total_parsed   = $this->total_parsed + $this->no_match_count;
                        echo ("Loaded " . $this->total_parsed . " products \n");
                        $this->no_match_count = 0;
                    } else {
                        $this->no_match_count++;
                    }
                }
                fclose($handle);
            }
        } else {
            if (($handle = fopen($versionFile, "r+")) !== FALSE) {
                echo "CompleteCSV found " . $versionFile . " \n";
                $row         = 0;
                while (($completeCSV = fgetcsv($handle, 10000, ",")) !== FALSE) {
                    if ($row != 0) {
                        array_push($arrayProducts, array("KEY"         => $completeCSV[0],
                         "Logistik_MC" => $completeCSV[1],
                         "extern_id"   => $completeCSV[2],
                         "EAN"         => $completeCSV[3],
                         "Description" => $completeCSV[4],
                         "prod_id"     => $completeCSV[5]));
                    }
                    $row++;
                }
            }

            $fp = fopen($versionFile, "a+");
            fclose($fp);
        }


        /** @var \Scraper\Controller\Scrapers\PriceScraper */
        $scraperClass = null;

        if ($platform != null) {
            switch ($platform) {
                case "Megabad":
                    $scraperClass = new Megabad();
                    break;
                case "Reuter":
                    $scraperClass = new Reuter();
                    break;
                case "Skybad":
                    $scraperClass = new Skybad();
                    break;
                case "Google":
                    $scraperClass = new Google();
                    break;
                case "Idealo":
                    $scraperClass = new Idealo();
                    break;
                default:
                    echo "Platform " . $platform . " not supported, sample: Reuter \n";
            }
        } else {
            echo "Platform argument not given";
            return;
        }

        if ($scraperClass != null) {
            $scraperClass->getDataFromArray($platform, $arrayProducts, 1, $version);
            echo "End list scraping " . $platform . "\n";
        } else {
            echo 'ScraperList did not run';
        };
    }

    private function formatFileForImport($output, $newFile, $startline, $stopline)
    {
        $fp = fopen($newFile, "a+");
        fclose($fp);

        $row    = 1;
        if (($handle = fopen($output, "r+")) !== FALSE) {

            while (($data = fgetcsv($handle, 10000, ";")) !== FALSE) {
                $num = count($data);
                if ($row == 1) {
                    $data = "KEY,Logistik_MC,Lieferantenartikel,EAN,Bezeichnung" . PHP_EOL;
                    file_put_contents($newFile, $data, FILE_APPEND);
                } else if ($row >= $startline && $row <= $stopline) {
                    $data[0] = $data[0] . ",";
                    $data[1] = $data[1] . ",";
                    $data[2] = $data[2] . ",";
                    $data[3] = $data[3] . ",";
                    $data[4] = $data[4];
                    array_push($data, PHP_EOL);

                    file_put_contents($newFile, $data, FILE_APPEND);
                }
                $row++;
                if ($row % 1000 == 0)
                    if ($row >= $startline && $row <= $stopline)
                        echo "formated " . $row . " lines \n";
                    else
                        echo "skiped " . $row . " lines \n";
            }
            fclose($handle);
        }
        return $newFile;
    }

}
