<?php

namespace Scraper\Controller\Scrapers;

use Exception;
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
        try {
            $ref            = $prodId['extern_id'];
            $this->searchUrl      = 'https://www.skybad.de/catalogsearch/result/?q=' . $ref;
            $resultSelector = '.product-item-link';

            $searchPageResult = $webBrowser->getPage($this->searchUrl);

            $html           = new SimpleHtmlDomController();
            $html->load($searchPageResult);
            $productResults = $html->find($resultSelector);

            foreach ($productResults as $value) {
                $link = $value->attr['href'];

                if ($this->searchRefInProductPage($webBrowser, $link, $ref)) {
                    return $this->getProductPrice($webBrowser, $link);
                }
            }

            return -0.02;
        } catch (Exception $ex) {
            $webBrowser->setLogger()->error("ERROR getPriceForProduct:" . $ex->getMessage());
            return -0.04;
        }
    }

    protected function searchProdInList($webBrowser, $prodId)
    {
        try {
            $this->searchUrl = 'https://www.skybad.de/catalogsearch/result/?q=' . $prodId['extern_id'];

            $resultSelector = '.product-item-link';

            $searchPageResult = $webBrowser->getPage($this->searchUrl);

            $html           = new SimpleHtmlDomController();
            $html->load($searchPageResult);
            $productResults = $html->find($resultSelector);

            $existIndex = -0.01;

            foreach ($productResults as $key => $value) {
                $priceFromSkybad = strtoupper(trim($value->nodes[0]->_[4]));

                if (strpos($priceFromSkybad, $prodId["brand"]) !== FALSE) {
                    return $key;
                }
            }

            return $existIndex;
        } catch (Exception $ex) {
            $webBrowser->setLogger()->error("ERROR searchProdInList:" . $ex->getMessage());
            return -0.04;
        }
    }

    protected function searchRefInProductPage($webBrowser, $link, $ref)
    {
        try {
            $this->searchUrl      = $link;
            $resultSelector = '.product-part-number';

            $searchPageResult = $webBrowser->getPage($this->searchUrl);

            $html           = new SimpleHtmlDomController();
            $html->load($searchPageResult);
            $productResults = $html->find($resultSelector);

            $string = $productResults[0]->children[0]->nodes[0]->_[4];
            $string = explode(":", $string);

            if (trim($string[1]) === $ref) {
                return TRUE;
            }

            return FALSE;
        } catch (Exception $ex) {
            $webBrowser->setLogger()->error("ERROR searchRefInProductPage:" . $ex->getMessage());
            return FALSE;
        }
    }

    protected function getProductPrice($webBrowser, $link)
    {
        try {
            $this->searchUrl      = $link;
            $resultSelector = '.price';

            $searchPageResult = $webBrowser->getPage($this->searchUrl);

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

            return -0.01;
        } catch (Exception $ex) {
            $webBrowser->setLogger()->error("ERROR getProductPrice:" . $ex->getMessage());
            return -0.04;
        }
    }

}
