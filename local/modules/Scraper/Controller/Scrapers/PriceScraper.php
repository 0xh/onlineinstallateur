<?php

namespace Scraper\Controller\Scrapers;

use Scraper\Controller\WebBrowserController;
use Thelia\Controller\Admin\BaseAdminController;

class PriceScraper extends BaseAdminController
{

    public function getData($platform)
    {
        $webBrowser = new WebBrowserController($platform . "-log");
        $webBrowser->init();
        $prodIds    = Common::getProductsExternId();
        foreach ($prodIds as $prodId) {
            $max_time = ini_get("max_execution_time");
            ini_set('max_execution_time', 3000);
            //each subclass must implement this
            $price    = $this->getPriceForProduct($webBrowser, $prodId);
            $webBrowser->setLogger()->error("saveInCrawlerProductListing# : " . Common::saveInCrawlerProductListing($prodId["prod_id"], $platform, $price));
            ini_set('max_execution_time', $max_time);
        }

        $webBrowser->close();
    }

}
