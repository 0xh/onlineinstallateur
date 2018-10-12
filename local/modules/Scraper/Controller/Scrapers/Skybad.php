<?php

namespace Scraper\Controller\Scrapers;

use Scraper\Controller\SimpleHtmlDomController;
use Scraper\Controller\WebBrowserController;
use Thelia\Controller\Admin\BaseAdminController;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Skybad
 *
 * @author Catana Florin
 */
class Skybad extends BaseAdminController
{

    public function getDataSkybad()
    {
        $dataSkybad = new WebBrowserController("skybad-log");
        $platform   = "Skybad";

        $dataSkybad->init();

        $prodIds = Common::getProductsExternId();

        foreach ($prodIds as $prodId) {

            $searchUrl      = 'https://www.skybad.de/catalogsearch/result/?q=' . $prodId['extern_id'];
            $resultSelector = '.price';

            $searchPageResult = $dataSkybad->getPage($searchUrl);

            $html           = new SimpleHtmlDomController();
            $html->load($searchPageResult);
            $productResults = $html->find($resultSelector);

            $priceFromSkybad = 0;

            foreach ($productResults as $value) {
                $priceFromSkybad = $value->nodes[0]->_[4];
                $priceFromSkybad = str_replace(".", "", $priceFromSkybad);
                $priceFromSkybad = str_replace(",", ".", $priceFromSkybad);
                $priceFromSkybad = floatval($priceFromSkybad);
                break;
            }

            $dataSkybad->setLogger()->error("saveInCrawlerProductListing# : " . Common::saveInCrawlerProductListing($prodId["prod_id"], $platform, $priceFromSkybad));
        }

        $dataSkybad->close();
        die("end");
    }

}
