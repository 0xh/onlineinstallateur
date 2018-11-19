<?php

namespace Scraper\Controller\Scrapers;

use Scraper\Config\ScraperConst;
use Scraper\Controller\SimpleHtmlDomController;

/**
 * Description of Skybad
 *
 * @author Catana Florin
 */
class Skybad extends PriceScraper implements PriceScraperInterface
{

    public function getDataSkybad($online, $startid, $stopid)
    {
        $this->getData(ScraperConst::SCRAPER_SKYBAD, $online, $startid, $stopid);
        die('end-skybad');
    }

    public function getPriceForProduct($webBrowser, $prodId)
    {
        $ref            = $prodId['extern_id'];
        $searchUrl      = 'https://www.skybad.de/catalogsearch/result/?q=' . $ref;
        $resultSelector = '.product-item-link';

        $searchPageResult = $webBrowser->getPage($searchUrl);

        $html           = new SimpleHtmlDomController();
        $html->load($searchPageResult);
        $productResults = $html->find($resultSelector);

        foreach ($productResults as $value) {
            $link = $value->attr['href'];

            if ($this->searchRefInProductPage($webBrowser, $link, $ref)) {
                return $this->getProductPrice($webBrowser, $link);
            }
        }

        return -2;
    }

    protected function searchProdInList($webBrowser, $prodId)
    {
        $searchUrl = 'https://www.skybad.de/catalogsearch/result/?q=' . $prodId['extern_id'];

        $resultSelector = '.product-item-link';

        $searchPageResult = $webBrowser->getPage($searchUrl);

        $html           = new SimpleHtmlDomController();
        $html->load($searchPageResult);
        $productResults = $html->find($resultSelector);

        $existIndex = -1;

        foreach ($productResults as $key => $value) {
            $priceFromSkybad = strtoupper(trim($value->nodes[0]->_[4]));

            if (strpos($priceFromSkybad, $prodId["brand"]) !== FALSE) {
                return $key;
            }
        }

        return $existIndex;
    }

    protected function searchRefInProductPage($webBrowser, $link, $ref)
    {
        $searchUrl      = $link;
        $resultSelector = '.product-part-number';

        $searchPageResult = $webBrowser->getPage($searchUrl);

        $html           = new SimpleHtmlDomController();
        $html->load($searchPageResult);
        $productResults = $html->find($resultSelector);

        $string = $productResults[0]->children[0]->nodes[0]->_[4];
        $string = explode(":", $string);

        if (trim($string[1]) === $ref) {
            return TRUE;
        }
        return FALSE;
    }

    protected function getProductPrice($webBrowser, $link)
    {
        $searchUrl      = $link;
        $resultSelector = '.price';

        $searchPageResult = $webBrowser->getPage($searchUrl);

        $html           = new SimpleHtmlDomController();
        $html->load($searchPageResult);
        $productResults = $html->find($resultSelector);
        $value          = $productResults[0];

        if (isset($value->nodes[0])) {
            $priceFromSkybad = $value->nodes[0]->_[4];
            $priceFromSkybad = str_replace(".", "", $priceFromSkybad);
            $priceFromSkybad = str_replace(",", ".", $priceFromSkybad);
            $priceFromSkybad = floatval($priceFromSkybad);

            return $priceFromSkybad;
        }

        return -1;
    }

}
