<?php
namespace Scraper\Commands;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Thelia\Command\ContainerAwareCommand;
use Scraper\Controller\Scrapers\Megabad;
use Scraper\Controller\Scrapers\Reuter;
use Scraper\Controller\Scrapers\Skybad;
use Scraper\Controller\Scrapers\Google;
use Scraper\Controller\Scrapers\Idealo;
use const DS;
use const THELIA_LOCAL_DIR;

class ScraperCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
         ->setName("scraperPrice")
         ->setDescription("Price scraper")
         ->addArgument(
          'platform', InputArgument::REQUIRED, 'Specify paltform - skybad,reuter,megabad')
        ->addArgument(
            'online', InputArgument::REQUIRED, 'Specify if only online products are to be scraped')
        ->addArgument(
            'startid', InputArgument::REQUIRED, 'Specify product start id')
        ->addArgument(
            'stopid', InputArgument::REQUIRED, 'Specify product stop id')
        ;
    }
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $import_type = null;
        $import_file = null;
        $errors      = null;
        
        $platform = $input->getArgument('platform');
        $online = $input->getArgument('online');
        $startid = $input->getArgument('startid');
        $stopid = $input->getArgument('stopid');
        
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
                    echo "Platform ".$platform." not supported, sample: Reuter";
            }
        } else {
            echo "Platform argument not given";
            return;
        }
        if( $scraperClass != null) {
            $scraperClass->getData($platform, $online, $startid, $stopid,1);
            echo "End scraping ".$platform;
        }   
        else {
            echo 'Scraper did not run';
        };
        
    }
}