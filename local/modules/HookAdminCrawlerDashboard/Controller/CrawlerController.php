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

    
    private function crawlAmazonProduct($ean_code){
    	$productBaseId;
    	$hf_price;
    	$hf_position;
    	$first_price;
    	$platform_product_id;
    	$link_platform_product_page;
    	$link_hf_product;
    	$link_first_product;

    	$crawler = new AmazonCrawler();
    	
    	$crawler->init(true, false,"Amazon");
    	$crawler->init_crawler();
    	
    	
    	$crawlerProduct = $crawler->saveProductBase($ean_code);
    	Tlog::getInstance()->error("saveproductbase ".$crawlerProduct->__toString());
    	
    	//STEP.1 Search for product
    	$searchResponse = $crawler->searchByEANCode($ean_code);
    	
    	//STEP.2 Find platform id
    	$platformProductId = $crawler->findPlatformID($searchResponse);
    	
    	//STEP.3 Get product page
    	$productPage = $crawler->getProductPage($platformProductId);
    	
    	//STEP.4 Is hausfabrik on the main product page? for yes parse the page; for no get product shops page
    	$hfInProductPage = $crawler->isShopInProductPage($productPage);
    	
    	if($hfInProductPage){
    		$hausfabrikOfferPosition = 1;
    		$hausfabrikOfferStock = $crawler->getOfferStock($productPage);
    		$hausfabrikOfferPrice = $crawler->getProductPagePrice($productPage);
    	}
    	else
    	{
    		$searchResponse = $crawler->getProductShops($platformProductId);
    		// get first product
    		$firstProduct = $crawler->getFirstProduct($searchResponse);
    			
    		//get price of the first product displayed
    		$firstProductPrice = $crawler->getOfferPrice(htmlspecialchars($firstProduct, ENT_QUOTES));
    			
    		//get Hausfabrik offer
    		$hausfabrikOffer = $crawler->getHausfabrikOffer($searchResponse);
    			
    		//get Hausfabrik offer Position
    		$hausfabrikOfferPosition = $crawler->getOfferPosition($hausfabrikOffer);
    			
    		//get Hausfabrik offer Price
    		$hausfabrikOfferPrice= $crawler->getOfferPrice(htmlspecialchars($hausfabrikOffer, ENT_QUOTES));
    	}
    	
    	$crawlerProduct = $crawler->saveProductBase($ean_code);
    	$productBaseId = $crawlerProduct->getId();
    	
    	
    	
    		
    	
    
    }

    public function loadDataAjaxAction()
    {
    	
    	$this->crawlAmazonProduct("123");
    	
    	//$crawler = new GeizhalsCrawler();
    	$crawler = new AmazonCrawler();
    	//$crawler = new IdealoCrawler();
    	//$crawler = new GoogleShoppingCrawler();
    	
    	$crawler->init(true, false,'Amazon');
    	$crawler->init_crawler();
 
    	//Geizhals
    	//$searchResponse = $crawler->searchByEANCode("4005176847981");
    	//Amazon
    	$searchResponse = $crawler->searchByEANCode("4005176314964");//4005176882593  B003TGG2EA
    	//Tlog::getInstance()->error("searchresponseean ".$searchResponse);
    	$platformProductId = $crawler->findPlatformID($searchResponse);
    	//Tlog::getInstance()->error("searchresponseplatformid ".$platformProductId);
    	$productPage = $crawler->getProductPage($platformProductId);
    	
    	$hfInProductPage = $crawler->isShopInProductPage($productPage);
    	//Tlog::getInstance()->error("productpage ".$productPage);
    	
    	if($hfInProductPage){
    		$hausfabrikOfferPosition = 1;
    		$hausfabrikOfferStock = $crawler->getOfferStock($productPage);
    		$hausfabrikOfferPrice = $crawler->getProductPagePrice($productPage);
    		//getProductPageUrl
    		return $this->jsonResponse(json_encode(array('result'=> " productPage stock ".$hausfabrikOfferStock." offerprice ".$hausfabrikOfferPrice.$crawler->getDebugMessage())));
    	}
    	else
    		$searchResponse = $crawler->getProductShops($platformProductId);
    	
    	//Tlog::getInstance()->error("searchresponseplatform ".$productPage);
    	//$productResponse = $crawler->getProductPage("B00OTV6X3E".'?language=en_GB');
    	//Idealo
    	//$searchResponse = $crawler->searchByEANCode("2317555");
    	//Google
    	//$searchResponse = $crawler->searchByEANCode("1393646630934339113"."?prds=scoring:p");
    	
    	if($searchResponse){
    		// get first product
    		$firstProduct = $crawler->getFirstProduct($searchResponse);
    		
    		//get price of the first product displayed
    		$firstProductPrice = $crawler->getOfferPrice(htmlspecialchars($firstProduct, ENT_QUOTES));
    		
    		//get Hausfabrik offer
    		$hausfabrikOffer = $crawler->getHausfabrikOffer($searchResponse);
    		
    		//get Hausfabrik offer Position
    		$hausfabrikOfferPosition = $crawler->getOfferPosition($hausfabrikOffer);
    		
    		//get Hausfabrik offer Price

    		$hausfabrikOfferPrice= $crawler->getOfferPrice(htmlspecialchars($hausfabrikOffer, ENT_QUOTES));
    		
    	} 
    	
    	//Stock
    	/* if($productResponse){ 
    		
    	 $productStock = $crawler->getOfferStock($productResponse);
    	 return $this->jsonResponse(json_encode(array('result'=> "Stock ".$productStock)));
    	}  */
    	
    	return $this->jsonResponse(json_encode(array('result'=> " pos ".$platformProductId." price first ".$firstProductPrice." price HF ".$hausfabrikOfferPrice)));
    }   
    
}
