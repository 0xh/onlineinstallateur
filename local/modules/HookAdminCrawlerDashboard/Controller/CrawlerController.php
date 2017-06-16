<?php

namespace HookAdminCrawlerDashboard\Controller;

use Doctrine\Common\Cache\FilesystemCache;
use HookAdminCrawlerDashboard\HookAdminCrawlerDashboard;
use Thelia\Controller\Admin\BaseAdminController;
use Thelia\Core\Security\AccessManager;
use Thelia\Model\ConfigQuery;
use Thelia\Model\CustomerQuery;
use Thelia\Model\OrderQuery;
use Thelia\Log\Tlog;

/**
 * Class CrawlerController
 * @package HookAdminCrawlerDashboard\Controller
 * @author Emanuel Plopu <emanuel.plopu@sepa.at>
 */
class CrawlerController extends BaseAdminController
{
    /**
     * Folder name for stats cache
     */
    const STATS_CACHE_DIR = "stats";

    /**
     * Key prefix for stats cache
     */
    const STATS_CACHE_KEY = "stats";

    const RESOURCE_CODE = "admin.crawler";
    


    public function loadDataAjaxAction()
    {
    	$crawler = new Crawler();
    	$crawler->setServiceLinks("https://geizhals.at/", "?fs=");
    	$crawler->setProductResultMarker("offer offer--shortly", "</div>");
    	$crawler->setPriceResultMarker('gh_price">&euro; ', "</span>");
    	$crawler->setHausfabrikOfferMarker("1", "2");
    	
    	$searchResponse = $crawler->searchByEANCode("4005176847981");
    	
    	// get first product
    	$firstProduct = $crawler->getFirstProduct($searchResponse);
    	
    	//get price of the first product displayed
    	$firstProductPrice = $crawler->getProductPrice($firstProduct);
    	
    	//get position of Hausfabrik offer
    	$hausfabrikOfferPosition = $crawler->getHausfabrikOfferPosition($searchResponse);
    	
    	//get display price of Hausfabrik offer
    	
    	//
    	
    	
    	return $this->jsonResponse(json_encode(array('result'=> $firstProductPrice)));
    }
    
    
    
    
}
