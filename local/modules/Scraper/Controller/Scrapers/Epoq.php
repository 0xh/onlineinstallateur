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
 * Description of Epoq
 *
 * @author Catana Florin
 */
class Epoq extends BaseAdminController
{

    public function getDataEpoq()
    {
        $dataEpoq = new WebBrowserController("epoq-log");
        $platform = "Epoq";

        $dataEpoq->init();

        $prodIds = Common::getProductsExternId();

        foreach ($prodIds as $prodId) {
            $searchUrl = 'https://search.epoq.de/inbound-servletapi/getSearchResult?full&callback=jQuery331038174002391130446_1537445518039&_bIsAjax=1&session-ro=1&tenantId=megabad&sessionId=9e4a1f79729e5aa479a2e546289f169e&orderBy=&order=desc&limit=24&offset=0&locakey=de&style=compact&format=json&nrf=&query=' . $prodId['extern_id'] . '&_=1537445518040';

            $searchPageResult = $dataEpoq->getPage($searchUrl);
            $priceFromEpoq    = 0;

            $searchPageResult = str_replace("jQuery331038174002391130446_1537445518039(", "", $searchPageResult);
            $searchPageResult = rtrim($searchPageResult, ");");
            $searchPageResult = json_decode($searchPageResult, true);
            $priceFromEpoq    = floatval($searchPageResult['result']['findings']["finding"]["match-item"]["g:price"]["$"]);

            $dataEpoq->setLogger()->error("saveInCrawlerProductListing# : " . Common::saveInCrawlerProductListing($prodId["prod_id"], $platform, $priceFromEpoq));
        }

        $dataEpoq->close();
        die("end");
    }

}
