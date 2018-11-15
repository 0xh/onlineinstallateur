<?php

namespace Scraper\Controller\Scrapers;

use Scraper\Controller\WebBrowserController;
use Thelia\Controller\Admin\BaseAdminController;

class PriceScraper extends BaseAdminController implements PriceScraperInterface
{

    public function getData($platform, $online, $startid, $stopid, $outputConsole = 0)
    {
        $webBrowser = new WebBrowserController($platform . "-log");
        $webBrowser->init();
        $prodIds    = Common::getProductsExternId($online, $startid, $stopid);
        foreach ($prodIds as $prodId) {
            $max_time = ini_get("max_execution_time");
            ini_set('max_execution_time', 3000);
            //each subclass must implement this
            $price    = $this->getPriceForProduct($webBrowser, $prodId);
            if ($outputConsole)
                echo "PriceScraper " . $prodId["prod_id"] . " " . $platform . " " . $price . " \n";
            $webBrowser->setLogger()->error("saveInCrawlerProductListing# : " . Common::saveInCrawlerProductListing($prodId["prod_id"], $platform, $price));
            $webBrowser->setLogger()->error("PriceScraper Prod_id:" . $prodId["prod_id"] . " Platform:" . $platform . " Price:" . $price);
            ini_set('max_execution_time', $max_time);
        }

        $webBrowser->close();
    }

    public function getPriceForProduct($webBrowser, $prodId)
    {
        trigger_error("Scraper is not implementing the required methods");
    }

}
