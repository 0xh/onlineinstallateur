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
use HookAdminCrawlerDashboard\Controller\GeizhalsCrawler;
use HookAdminCrawlerDashboard\Controller\AmazonCrawler;
use HookAdminCrawlerDashboard\Controller\IdealoCrawler;

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
    	//$crawler = new GeizhalsCrawler();
    	$crawler = new AmazonCrawler();
    	//$crawler = new IdealoCrawler();
    	//$crawler = new WillhabenCrawler();
    	
    	$crawler->init(true, false);
    	$crawler->init_crawler();
 
    	//Geizhals
    	//$searchResponse = $crawler->searchByEANCode("4005176847981");
    	//Amazon
    	$searchResponse = $crawler->searchByEANCode("4005176882593");//4005176882593  B003TGG2EA
    	//Idealo
    	//$searchResponse = $crawler->searchByEANCode("2317555");
    	
    	if(!$searchResponse){
    		// get first product
    		$firstProduct = $crawler->getFirstProduct($searchResponse);
    		
    		//get price of the first product displayed
    		$firstProductPrice = $crawler->getOfferPrice($firstProduct);
    		
    		//get Hausfabrik offer
    		$hausfabrikOffer = $crawler->getHausfabrikOffer($searchResponse);
    		
    		//get Hausfabrik offer Position
    		$hausfabrikOfferPosition = $crawler->getOfferPosition($hausfabrikOffer);
    		
    		//get Hausfabrik offer Price
    		$hausfabrikOfferPrice = $crawler->getOfferPrice($hausfabrikOffer);
    		
    	}
    	
    	return $this->jsonResponse(json_encode(array('result'=>$searchResponse)));
    	
    	//return $this->jsonResponse(json_encode(array('result'=> " pos ".$hausfabrikOfferPosition." price first ".$firstProductPrice." price HF ".$hausfabrikOfferPrice)));
    }   
    
}
