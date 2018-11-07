<?php

namespace Scraper\Controller\Scrapers;

use Scraper\Controller\SimpleHtmlDomController;
use Thelia\Log\Tlog;


/**
 * Description of Skybad
 *
 * @author Catana Florin
 */
class Skybad extends PriceScraper
{
    
    public function getDataSkybad($online)
    {
        $this->getData('skybad',$online);
        die('end-skybad');
    }
    
    public function getPriceForProduct($webBrowser, $prodId)
    {
        $searchUrl      = 'https://www.skybad.de/catalogsearch/result/?q=' . $prodId['extern_id'];
        $resultSelector = '.price';
        
        $searchPageResult = $webBrowser->getPage($searchUrl);
        
        $html           = new SimpleHtmlDomController();
        $html->load($searchPageResult);
        $productResults = $html->find($resultSelector);
        
        $priceFromSkybad = 0;
        
        foreach ($productResults as $value) {
            $priceFromSkybad = $value->nodes[0]->_[4];
            $priceFromSkybad = str_replace(".", "", $priceFromSkybad);
            $priceFromSkybad = str_replace(",", ".", $priceFromSkybad);
            $priceFromSkybad = floatval($priceFromSkybad);
        }
        return $priceFromSkybad;
    }

}
