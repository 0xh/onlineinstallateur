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
 * Description of Reuter
 *
 * @author Catana Florin
 */
class Reuter extends BaseAdminController
{

    public function getDataReuter()
    {
        $dataReuter = new WebBrowserController("reuter-log");
        $platform   = "Reuter";

        $dataReuter->init();

        $prodIds = Common::getProductsExternId();

        foreach ($prodIds as $prodId) {

            $searchUrl      = 'https://www.reuter.de/katalogsuche/?q=' . $prodId['extern_id'];
            $resultSelector = '.c-product-tile__link';

            $searchPageResult = $dataReuter->getPage($searchUrl);

            $html           = new SimpleHtmlDomController();
            $html->load($searchPageResult);
            $productResults = $html->find($resultSelector);

            $priceFromReuter = 0;

            foreach ($productResults as $value) {
                $priceFromReuter = $value->parent->attr["qa-data-price"];
                $priceFromReuter = floatval($priceFromReuter);
                break;
            }

            $dataReuter->setLogger()->error("saveInCrawlerProductListing# : " . Common::saveInCrawlerProductListing($prodId["prod_id"], $platform, $priceFromReuter));
        }

        $dataReuter->close();
        die("end");
    }

}
