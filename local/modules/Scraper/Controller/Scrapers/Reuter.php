<?php

namespace Scraper\Controller\Scrapers;

use Exception;
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
        try {
            if (!$this->isProductOnline($webBrowser, $prodId)) {
                return -0.02;
            }

            $ref       = $prodId['extern_id'];
            $searchUrl = 'https://www.reuter.de/katalogsuche/?q=' . $ref;

            $resultSelector = '.c-product-tile__link';

            $searchPageResult = $webBrowser->getPage($searchUrl);

            $html = new SimpleHtmlDomController();
            $html->load($searchPageResult);

            $productResults = $html->find($resultSelector);

            foreach ($productResults as $value) {
                $link = $value->attr['href'];

                if ($this->searchRefInProductPage($webBrowser, $link, $ref)) {
                    return $this->getProductPrice($webBrowser, $link);
                }
            }

            return -0.01;
        } catch (Exception $ex) {
            $webBrowser->setLogger()->error("ERROR getPriceForProduct:" . $ex->getMessage());
            return -0.04;
        }
    }

    protected function isProductOnline($webBrowser, $prodId)
    {
        try {
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
        } catch (Exception $ex) {
            $webBrowser->setLogger()->error("ERROR isProductOnline:" . $ex->getMessage());
            return FALSE;
        }
    }

    protected function searchRefInProductPage($webBrowser, $link, $ref)
    {
        try {
            $searchUrl      = 'https://www.reuter.de' . $link;
            $resultSelector = '.c-definition-list__value';

            $searchPageResult = $webBrowser->getPage($searchUrl);

            $html           = new SimpleHtmlDomController();
            $html->load($searchPageResult);
            $productResults = $html->find($resultSelector);

            if (trim($productResults[0]->nodes[0]->_[4]) === $ref) {
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
            $searchUrl      = 'https://www.reuter.de' . $link;
            $resultSelector = '.c-price-block__price-price';

            $searchPageResult = $webBrowser->getPage($searchUrl);

            $html           = new SimpleHtmlDomController();
            $html->load($searchPageResult);
            $productResults = $html->find($resultSelector);

            if (isset($productResults) && isset($productResults[0])) {
                $value = $productResults[0];
            } else {
                $value = $this->getProductPrice3rd($webBrowser, $link);

                if (!$value) {
                    return -0.03;
                } else {
                    return $value;
                }
            }

            if (isset($value->nodes[0]) && isset($value->children[0]) && isset($value->children[0]->nodes[0])) {
                $priceFromReuter = $value->nodes[0]->_[4] . $value->children[0]->nodes[0]->_[4];
                $priceFromReuter = str_replace(".", "", $priceFromReuter);
                $priceFromReuter = str_replace(",", ".", $priceFromReuter);
                $priceFromReuter = floatval($priceFromReuter);

                return $priceFromReuter;
            }

            return -0.01;
        } catch (Exception $ex) {
            $webBrowser->setLogger()->error("ERROR getProductPrice:" . $ex->getMessage());
            return -0.04;
        }
    }

    protected function getProductPrice3rd($webBrowser, $link)
    {
        try {
            $searchUrl      = 'https://www.reuter.de' . $link;
            $resultSelector = '.c-price-block__price';

            $searchPageResult = $webBrowser->getPage($searchUrl);

            $html           = new SimpleHtmlDomController();
            $html->load($searchPageResult);
            $productResults = $html->find($resultSelector);

            if (isset($productResults) && isset($productResults[0])) {
                $value = $productResults[0];
            } else {
                return FALSE;
            }

            if (isset($value->nodes[0])) {
                $priceFromReuter = $value->nodes[0]->_[4];
                $priceFromReuter = str_replace(".", "", $priceFromReuter);
                $priceFromReuter = str_replace(",", ".", $priceFromReuter);
                $priceFromReuter = floatval($priceFromReuter);

                return $priceFromReuter;
            }

            return -0.01;
        } catch (Exception $ex) {
            $webBrowser->setLogger()->error("ERROR getProductPrice3rd:" . $ex->getMessage());
            return -0.04;
        }
    }

}
