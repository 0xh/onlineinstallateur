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
class Google extends PriceScraper implements PriceScraperInterface
{
    public function getDataMegabad($online,$startid,$stopid)
    {
        $this->getData('Google',$online,$startid,$stopid);
        die('end-google');
    }
    
    public function getPriceForProduct($webBrowser, $prodId)
    {
        $searchUrl = 'https://www.google.com/search?hl=en-AT&tbm=shop&ei=QE_sW52MGcqlsAHzxbKAAw&q=' . $prodId['extern_id'] . '&oq=' . $prodId['extern_id'];

            $searchPageResult = $webBrowser->getPage($searchUrl);
            $resultSelector = '.A8OWCb';
            
            $html           = new SimpleHtmlDomController();
            $html->load($searchPageResult);

            $productResults = $html->find($resultSelector);
            $priceFromGoogle = 0;
            
            foreach ($productResults as $value) {
                $priceSplit = explode('&#8364;',$value);
                
                if(count($priceSplit) > 1){
                    $priceFromGoogle = explode('</b>',$priceSplit[1]);
                    $priceFromGoogle = str_replace(',', '.',$priceFromGoogle[0]);
                }
                break;
            }
            return $priceFromGoogle;
    }

}
