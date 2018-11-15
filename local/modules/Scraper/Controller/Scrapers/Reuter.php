<?php

namespace Scraper\Controller\Scrapers;

use Scraper\Config\ScraperConst;
use Scraper\Controller\SimpleHtmlDomController;

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
class Reuter extends PriceScraper implements PriceScraperInterface
{

    public function getDataReuter($online, $startid, $stopid)
    {
        $this->getData(ScraperConst::SCRAPER_REUTER, $online, $startid, $stopid);
        die('end-reuter');
    }

    public function getPriceForProduct($webBrowser, $prodId)
    {
        if (!$this->isProductOnline($webBrowser, $prodId)) {
            return -1;
        }

        $searchUrl      = 'https://www.reuter.de/katalogsuche/?q=' . $prodId['extern_id'];
        $resultSelector = '.c-product-tile__link';

        $searchPageResult = $webBrowser->getPage($searchUrl);

        $html           = new SimpleHtmlDomController();
        $html->load($searchPageResult);
        $productResults = $html->find($resultSelector);

        $priceFromReuter = 0;

        foreach ($productResults as $value) {
            $priceFromReuter = $value->parent->attr["qa-data-price"];
            $priceFromReuter = floatval($priceFromReuter);
            break;
        }

        return $priceFromReuter;
    }

    protected function isProductOnline($webBrowser, $prodId)
    {
        $searchUrl      = 'https://www.reuter.de/katalogsuche/?q=' . $prodId['extern_id'];
        $resultSelector = '.text-line-through';

        $searchPageResult = $webBrowser->getPage($searchUrl);

        $html           = new SimpleHtmlDomController();
        $html->load($searchPageResult);
        $productResults = $html->find($resultSelector);

        if ($productResults) {
            return FALSE;
        }
        return TRUE;
    }

}
