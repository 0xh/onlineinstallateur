<?php

namespace Scraper\Controller\Scrapers;

use Scraper\Controller\SimpleHtmlDomController;
use Scraper\Controller\WebBrowserController;
use Thelia\Controller\Admin\BaseAdminController;
use Exception;

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
    public function getDataReuter($online,$startid,$stopid)
    {
        $this->getData('reuter',$online,$startid,$stopid);
        die('end-reuter');
    }
    
    public function getPriceForProduct($webBrowser, $prodId)
    {
        $searchUrl      = 'https://www.reuter.de/katalogsuche/?q=' . $prodId['extern_id'];
        $resultSelector = '.c-product-tile__link';

        $searchPageResult = $webBrowser->getPage($searchUrl);

        $html           = new SimpleHtmlDomController();
        $html->load($searchPageResult);
        $productResults = $html->find($resultSelector);

        $priceFromReuter = 0;

        foreach ($productResults as $value) {
            try{
            $priceFromReuter = $value->parent->attr["qa-data-price"];
            $priceFromReuter = floatval($priceFromReuter);
            }
            catch (Exception $e) {
            }
            break;
        }
        return $priceFromReuter;
    }

}
