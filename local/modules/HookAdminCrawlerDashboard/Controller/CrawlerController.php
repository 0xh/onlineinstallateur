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
    	//$crawler = new AmazonCrawler();
    	//$crawler = new IdealoCrawler();
    	$crawler = new GoogleShoppingCrawler();
    	
    	$crawler->init(true, true);
    	$crawler->init_crawler();
 
    	//Geizhals
    	//$searchResponse = $crawler->searchByEANCode("4005176847981");
    	//Amazon
    	//$searchResponse = $crawler->searchByEANCode("4005176882593");//4005176882593  B003TGG2EA
    	//$productResponse = $crawler->getProductPage("B00OTV6X3E".'?language=en_GB');
    	//Idealo
    	//$searchResponse = $crawler->searchByEANCode("2317555");
    	//Google
    	$searchResponse = $crawler->searchByEANCode("1393646630934339113"."?prds=scoring:p");
    	
    
    	if($searchResponse){
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
    	
    	//Stock
    	/* if($productResponse){ 
    		
    	 $productStock = $crawler->getOfferStock($productResponse);
    	 return $this->jsonResponse(json_encode(array('result'=> "Stock ".$productStock)));
    	}  */
    	
    	return $this->jsonResponse(json_encode(array('result'=> " pos ".$hausfabrikOfferPosition." price first ".$firstProductPrice." price HF ".$hausfabrikOfferPrice)));
    }   
    
}
