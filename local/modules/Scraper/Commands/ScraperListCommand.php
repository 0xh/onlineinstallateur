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
use Scraper\Controller\Scrapers\Common;
use Thelia\Model\ProductQuery;
use Thelia\Model\Map\ProductTableMap;
use Thelia\Model\Product;

class ScraperListCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
         ->setName("scraperListPrice")
         ->setDescription("List based price scraper")
         ->addArgument(
          'platform', InputArgument::REQUIRED, 'Specify paltform - skybad,reuter,megabad')
         ->addArgument(
          'version', InputArgument::REQUIRED, 'Specify list stop line number')
        ->addArgument(
            'startline', InputArgument::REQUIRED, 'Specify list start line number')
        ->addArgument(
            'stopline', InputArgument::REQUIRED, 'Specify list stop line number')
        ;
    }
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $import_type = null;
        $import_file = null;
        $errors      = null;
        
        $platform = $input->getArgument('platform');
        $startline = $input->getArgument('startline');
        $stopline = $input->getArgument('stopline');
        $version = $input->getArgument('version');
        
        $URL = new URL();
        $local_file = $newFile = THELIA_LOCAL_DIR . "sepa" . DS . "import" . DS . "ShtScraper" . DS . "Artikelliste.csv";
        //$local_file = Common::fetchfromFTP("ShtScraper","Artikelliste.csv");
        
        $newFile = THELIA_LOCAL_DIR . "sepa" . DS . "import" . DS . "ShtScraper" . DS . "Artikelliste" . date('_m.d.Y_H.i.s') . ".csv";
        
        if ($local_file != null) {
            echo "copied file from ftp \n";
            $csv_output = $this->formatFileForImport($local_file, $newFile, $startline, $stopline);
        } else {
            echo "Error copying file from ftp \n";
            return;
        }
        
        $arrayProducts = array();
        if (($handle = fopen($csv_output, "r+")) !== FALSE) {
            $row = 0;
            $productQuery = ProductQuery::create();
            while (($data = fgetcsv($handle, 10000, ",")) !== FALSE) {
                if($row != 0) {
                    $productQuery->clear();
                    $product = $productQuery->
                    where(ProductTableMap::REF . " like '%" . $data[2] ."%'")
                    ->findOne();
                    if($product == null)
                    {
                        $product = new Product();
                        $product->setRef("SCRAPER_".$data[2]); // must be unique
                        $product->setVisible(0);
                        $product->setDefaultCategory("379");
                        $product->setVersionCreatedBy("scraper.15.11");
                        $product->save();
                        echo 'created '.$product->getRef()."\n";
                    }
                    array_push($arrayProducts, array("extern_id" => $data[2], "prod_id" => $product->getId()));
                }
                $row++;
            }
            fclose($handle);
        }
        
        
        /** @var \Scraper\Controller\Scrapers\PriceScraper */
        $scraperClass = null;
        
        if($platform != null){
            switch($platform) {
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
                    echo "Platform ".$platform." not supported, sample: Reuter \n";
            }
        } else {
            echo "Platform argument not given";
            return;
        }
        
        if( $scraperClass != null) {
            $scraperClass->getDataFromArray($platform, $arrayProducts, 1, $version);
            echo "End list scraping ".$platform;
        }   
        else {
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
                    $data = "KEY,Logistik_MC,Lieferantenartikel,EAN,Bezeichnung".PHP_EOL;
                    file_put_contents($newFile, $data, FILE_APPEND);
                } else if($row >= $startline && $row <= $stopline){
                    $data[0] = $data[0] . ",";
                    $data[1] = $data[1] . ",";
                    $data[2] = $data[2] . ",";
                    $data[3] = $data[3] . ",";
                    $data[4] = $data[4];
                    array_push($data, PHP_EOL);
                    
                    file_put_contents($newFile, $data, FILE_APPEND);
                }
                $row++;
                if($row % 1000 == 0 )
                    if($row >= $startline && $row <= $stopline)
                        echo "formated ".$row." lines \n";
                        else
                            echo "skiped ".$row." lines \n";
            }
            fclose($handle);
        }
        return $newFile;
    }
}