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

    public function getDataMegabad($online, $startid, $stopid)
    {
        $this->getData('Google', $online, $startid, $stopid);
        die('end-google');
    }

    public function getPriceForProduct($webBrowser, $prodId)
    {
        $this->searchUrl  = 'https://www.google.com/search?hl=en-AT&tbm=shop&ei=u07tW46wLYn8swH4tKfwDw&q=' . $prodId['extern_id'] . '&oq=' . $prodId['extern_id'] . "&&google_abuse=GOOGLE_ABUSE_EXEMPTION%3DID%3Dcb291b447a63f85b:TM%3D1542375897:C%3Dr:IP%3D83.65.230.26-:S%3DAPGng0sHabjvYH0CBjPgNbP6W9y_oGsBbw%3B+path%3D/%3B+domain%3Dgoogle.com%3B+expires%3DFri,+16-Nov-2018+16:44:57+GMT";
        $searchPageResult = $webBrowser->getPage($this->searchUrl);
        $resultSelector   = ".A8OWCb";
        $notFound         = "did not match any documents";
        $this->savePageToFile('Google', 'Search', $prodId, $searchPageResult);
        $html             = new SimpleHtmlDomController();
        $html->load($searchPageResult);

        $productResults = $html->find($resultSelector);

        $priceFromGoogle = 0;

        foreach ($productResults as $value) {
            $priceSplit = explode('&#8364;', $value);

            if (count($priceSplit) > 1) {
                $priceFromGoogle = explode('</b>', $priceSplit[1]);
                $priceFromGoogle = str_replace(',', '.', $priceFromGoogle[0]);
            }
            break;
        }

        if ($priceFromGoogle == 0) {
            if (strpos($searchPageResult, $notFound) !== FALSE)
                $priceFromGoogle = -1;
        }
        sleep(1);
        return $priceFromGoogle;
    }

}
