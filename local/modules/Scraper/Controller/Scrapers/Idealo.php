<?php

namespace Scraper\Controller\Scrapers;

use Scraper\Controller\SimpleHtmlDomController;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 *
 * @author Emanuel Plopu
 */
class Idealo extends PriceScraper implements PriceScraperInterface
{

    public function getDataMegabad($online, $startid, $stopid)
    {
        $this->getData('Idealo', $online, $startid, $stopid);
        die('end-idealo');
    }

    public function getPriceForProduct($webBrowser, $prodId)
    {
        $this->searchUrl  = 'https://www.idealo.at/preisvergleich/ProductCategory/18926.html?q=' . $prodId['extern_id'];
        echo $this->searchUrl . "\n";
        $searchPageResult = $webBrowser->getPage($this->searchUrl);
        $resultSelector   = '.price-currencySymbol price-currencySymbol--before';
        $webBrowser->setLogger()->error("idealo " . $searchPageResult);
        $html             = new SimpleHtmlDomController();
        $html->load($searchPageResult);
        echo $searchPageResult;
        $productResults   = $html->find($resultSelector);
        $priceFromIdealo  = 0;

        foreach ($productResults as $value) {
            echo "idealo " . $value;
        }
        return $priceFromIdealo;
    }

}
