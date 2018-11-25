<?php

namespace AmazonIntegration\Commands;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Thelia\Command\ContainerAwareCommand;
use Thelia\Model\Product;
use Thelia\Model\ProductQuery;
use Thelia\Model\Map\ProductTableMap;
use Thelia\Tools\URL;
use AmazonIntegration\Controller\Admin\AmazonIntegrationContoller;
use Thelia\Model\ProductSaleElements;

class AmazonIntegrationRankingListCommand extends ContainerAwareCommand
{

    private $match_threshold = 100;
    private $no_match_count  = 0;
    private $total_parsed    = 0;

    protected function configure()
    {
        $this
         ->setName("amazonRankingList")
         ->setDescription("AmazonIntegration Ranking and Price")
         ->addArgument(
          'version', InputArgument::REQUIRED, 'Specify import version')
         ->addArgument(
          'startline', InputArgument::REQUIRED, 'Specify list start line number')
         ->addArgument(
          'stopline', InputArgument::REQUIRED, 'Specify list stop line number')
         ->addArgument(
          'createproducts', InputArgument::REQUIRED, 'Specify if amazon ranking should create products or not')
         ->addArgument(
          'reimport', InputArgument::OPTIONAL, 'Specify if any existing files should be reimported')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $startline      = $input->getArgument('startline');
        $stopline       = $input->getArgument('stopline');
        $version        = $input->getArgument('version');
        $createProducts = $input->getArgument('createproducts');
        $reimport       = $input->getArgument('reimport');

        $URL        = new URL();
        $local_file = "";
        if ($reimport == 0) {
            $local_file = $this->fetchfromFTP("AmazonRanking", "Artikelliste.csv");
        } else {
            $local_file = THELIA_LOCAL_DIR . "sepa" . DS . "import" . DS . "AmazonRanking" . DS . "Artikelliste.csv";
        }

        $newFile = THELIA_LOCAL_DIR . "sepa" . DS . "import" . DS . "AmazonRanking" . DS . "Artikelliste" . date('_m.d.Y_H.i.s') . ".csv";

        if ($local_file != null) {
            echo "copied file from ftp \n";
            $csv_output = $this->formatFileForImport($local_file, $newFile, $startline, $stopline);
        } else {
            echo "Error copying file from ftp \n";
            return;
        }

        $versionFile = THELIA_LOCAL_DIR . "sepa" . DS . "import" . DS . "AmazonRanking" . DS . $version . ".csv";

        $arrayProducts = array();
        if (!file_exists($versionFile)) {
            if (($handle = fopen($csv_output, "r+")) !== FALSE) {
                $row          = 0;
                $productQuery = ProductQuery::create();
                while (($data         = fgetcsv($handle, 10000, ",")) !== FALSE) {
                    if ($row != 0) {
                        $productQuery->clear();
                        $product = $productQuery->
                         where(ProductTableMap::REF . " like '%" . $data[2] . "%'")
                         ->findOne();
                        if ($createProducts == 1 && $product == null) {
                            $product = new Product();
                            $product->setRef("SCRAPER_" . $data[2]); // must be unique
                            $product->setVisible(0);
                            $product->setDefaultCategory("382");
                            $product->setVersionCreatedBy($version);
                            $product->save();
                            echo "created " . $product->getRef() . "\n";
                        }
                        if ($createProducts == 1 && count($product->getProductSaleElementss()) > 0) {
                            $pse = $product->getProductSaleElementss()[0];
                            $pse->setEanCode($data[3]);
                            $pse->save();
                            echo "PSE Updated \n";
                        } else {
                            $pse = new ProductSaleElements();
                            $pse->setProduct($product);
                            $pse->setEanCode($data[3]);
                            echo "Pse Created \n";
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

        /** @var AmazonIntegrationContoller */
        $amazonIntegration = new AmazonIntegrationContoller();
        $amazonIntegration->getAmazonRankingEAN($arrayProducts);

        echo "End AmazonIntegration \n";
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

    public static function fetchfromFTP($local_folder, $filename)
    {
        $server_file = $filename;
        $local_file  = THELIA_LOCAL_DIR . "sepa" . DS . "import" . DS . $local_folder . DS . $server_file;

        $ftp_user   = "mmai1018";
        $ftp_pass   = "PreiCra!2018";
        $ftp_server = "ftp.sht-net.at";
        $ftp_conn   = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
        $login      = ftp_login($ftp_conn, $ftp_user, $ftp_pass);
        ftp_pasv($ftp_conn, true) or die("Cannot switch to passive mode");
        echo "Connected to FTP \n";
        ftp_chdir($ftp_conn, "/preiscrawler");
        if (ftp_get($ftp_conn, $local_file, $server_file, FTP_ASCII)) {
            echo "Successfully written to $local_file. \n";
        } else {
            echo "Error downloading $server_file.";
        }
        ftp_close($ftp_conn);


        return $local_file;
    }

}
