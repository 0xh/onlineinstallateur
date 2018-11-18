<?php

namespace Scraper\Controller\Scrapers;

use Scraper\Controller\SimpleHtmlDomController;


/**
 * Description of Skybad
 *
 * @author Catana Florin
 */
class Skybad extends PriceScraper implements PriceScraperInterface
{
    
    public function getDataSkybad($online,$startid,$stopid)
    {
        $this->getData('skybad',$online,$startid,$stopid);
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
