<?php

namespace Scraper\Controller\Scrapers;

use Scraper\Controller\WebBrowserController;
use Thelia\Controller\Admin\BaseAdminController;

class PriceScraper extends BaseAdminController implements PriceScraperInterface
{

    private $searchUrl;

    public function getData($platform, $online, $startid, $stopid, $outputConsole = 0, $version = "scraper")
    {
        $prodIds = Common::getProductsExternId($online, $startid, $stopid);
        foreach ($prodIds as $prodId) {
            $max_time   = ini_get("max_execution_time");
            ini_set('max_execution_time', 3000);
            $webBrowser = new WebBrowserController($platform);
            $webBrowser->init();
            //each subclass must implement this
            $price      = $this->getPriceForProduct($webBrowser, $prodId);

            if ($outputConsole) {
                echo "PriceScraper " . $prodId["prod_id"] . " " . $prodId['extern_id'] . " " . $platform . " " . $price . " \n";
            }

            $webBrowser->setLogger()->error("saveInCrawlerProductListing# : " . Common::saveInCrawlerProductListing($prodId["prod_id"], $platform, $price, $version));
            $webBrowser->setLogger()->error("PriceScraper Prod_id:" . $prodId["prod_id"] . " Platform:" . $platform . " Price:" . $price);
            $webBrowser->close();
            ini_set('max_execution_time', $max_time);
        }
    }

    public function getDataFromArray($platform, $productArray, $outputConsole = 0, $version = "scraper")
    {
        foreach ($productArray as $prodId) {
            $max_time   = ini_get("max_execution_time");
            ini_set('max_execution_time', 10000);
            $webBrowser = new WebBrowserController($platform);
            $webBrowser->init();
            //each subclass must implement this
            $price      = $this->getPriceForProduct($webBrowser, $prodId);

            if ($outputConsole) {
                echo "PriceScraper " . $prodId["prod_id"] . " " . $prodId['extern_id'] . " " . $platform . " " . $price . " \n";
            }

            $webBrowser->setLogger()->error("saveInCrawlerProductListing# : " . Common::saveInCrawlerProductListing($prodId["prod_id"], $platform, $price, $version));
            $webBrowser->setLogger()->error("PriceScraper Prod_id:" . $prodId["prod_id"] . " Platform:" . $platform . " Price:" . $price);
            $webBrowser->close();
            ini_set('max_execution_time', $max_time);
        }
    }

    public function getPriceForProduct($webBrowser, $prodId)
    {
        trigger_error("Scraper is not implementing the required methods");
    }

    public function savePageToFile($platform, $folder, $product, $content)
    {
        $newFile = THELIA_LOG_DIR . "Scraper" . DS . $platform . DS . $folder . DS . $product["prod_id"] . "_" . str_replace('/', '_', $product['extern_id']) . "_" . date("Y-m-d_H.i.s") . ".html";
        file_put_contents($newFile, $content, FILE_APPEND);
    }

}
