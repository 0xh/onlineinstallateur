<?php

namespace Scraper\Controller\Scrapers;

use Exception;
use Scraper\Config\ScraperConst;

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
class Megabad extends PriceScraper implements PriceScraperInterface
{

    public function getDataMegabad($online, $startid, $stopid)
    {
        $this->getData(ScraperConst::SCRAPER_MEGABAD, $online, $startid, $stopid);
        die('end-megabad');
    }

    public function getPriceForProduct($webBrowser, $prodId)
    {
        $searchUrl = 'https://search.epoq.de/inbound-servletapi/getSearchResult?full&callback=jQuery331038174002391130446_1537445518039&_bIsAjax=1&session-ro=1&tenantId=megabad&sessionId=9e4a1f79729e5aa479a2e546289f169e&orderBy=&order=desc&limit=24&offset=0&locakey=de&style=compact&format=json&nrf=&query=' . $prodId['extern_id'] . '&_=1537445518040';

        $searchPageResult = $webBrowser->getPage($searchUrl);
        $priceFromMegabad = -1;

        $searchPageResult = str_replace("jQuery331038174002391130446_1537445518039(", "", $searchPageResult);
        $searchPageResult = rtrim($searchPageResult, ");");
        $searchPageResult = json_decode($searchPageResult, true);
        try {
            $priceFromMegabad = floatval($searchPageResult['result']['findings']["finding"]["match-item"]["g:price"]["$"]);
        } catch (Exception $e) {
            
        }

        return $priceFromMegabad;
    }

}
