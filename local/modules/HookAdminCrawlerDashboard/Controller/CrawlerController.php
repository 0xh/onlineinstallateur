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
use Thelia\Model\ProductSaleElementsQuery;
use Thelia\Model\Map\ProductSaleElementsTableMap;
use Propel\Runtime\ActiveQuery\Criteria;
use Thelia\Model\Map\BrandTableMap;
use Propel\Runtime\ActiveQuery\Join;
use Thelia\Model\Map\ProductTableMap;

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
    	
    	$crawler = new AmazonCrawler();
    	
    	$crawler->init(false, false);
    	$crawler->init_crawler();
    	
    	//STEP.1 Search for product
    	$searchResponse = $crawler->searchByEANCode($ean_code);
    	
    	//STEP.2 Find platform id
    	$platformProductId = $crawler->findPlatformID($searchResponse);
    	
    	//STEP.3 Get product page
    	$productPage = $crawler->getProductPage($platformProductId);
    	
    	//STEP.4 Is hausfabrik on the main product page? for yes parse the page; for no get product shops page
    	$hfInProductPage = $crawler->isShopInProductPage($productPage);
    	
    	$firstProductPrice = 0;
    	$firstProductLink = "";
    	$hausfabrikProductLink = "";
    	$hausfabrikOfferStock = 0;
    	
    	if($hfInProductPage){
    		$hausfabrikOfferPosition = 1;
    		$hausfabrikOfferStock = $crawler->getOfferStock($productPage);
    		$hausfabrikOfferPrice = $crawler->getProductPagePrice($productPage);
    		$hausfabrikProductLink = $crawler->getHausfabrikProductLink($platformProductId);
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
    		
    		$hausfabrikProductLink = $crawler->getProductLinkForOffer($platformProductId, $hausfabrikOffer);
    			
    		//get Hausfabrik offer Price
    		$hausfabrikOfferPrice= $crawler->getOfferPrice(htmlspecialchars($hausfabrikOffer, ENT_QUOTES));
    		
    		$firstProductLink = $crawler->getProductLinkForOffer($platformProductId, $firstProduct);
    		
    	}
    	
    	//STEP.5 get CRAWLER_PRODUCT_BASE object from db
    	$crawlerProduct = $crawler->getProductBase($ean_code);
    	
    	//STEP.6 save CRAWLER_PRODUCT_LISTING object to db
    	if($crawlerProduct != null){	
    		$productBaseId = $crawlerProduct->getId();
    		
    		$linkPlatformProductPage = $crawler->getProductPageUrl($platformProductId);
    		
    		//TODO link first product : find seller id from page => A3M3A89MAL04LF for hausfabrik and with
    		// the asin => B016ZPONB0 https://www.amazon.de/dp/B016ZPONB0/?m=A3M3A89MAL04LF
    		$crawler->saveProductListing($productBaseId, $hausfabrikOfferPrice, $hausfabrikOfferPosition, $hausfabrikOfferStock, $firstProductPrice,
    				$platformProductId, $linkPlatformProductPage, $hausfabrikProductLink, $firstProductLink);	
    	}
    	
    	Tlog::getInstance()->error($ean_code.",".$productBaseId
    			.",".$hausfabrikOfferPrice.",".$hausfabrikOfferPosition
    			.",".$hausfabrikOfferStock.",".$firstProductPrice
    			.",".$platformProductId.",".$linkPlatformProductPage.",".$hausfabrikProductLink.",".$firstProductLink);
    	return $ean_code.",".$productBaseId
    	.",".$hausfabrikOfferPrice.",".$hausfabrikOfferPosition
    	.",".$hausfabrikOfferStock.",".$firstProductPrice
    	.",".$platformProductId.",".$linkPlatformProductPage.",".$hausfabrikProductLink.",".$firstProductLink;
    	/*
    	return $this->jsonResponse(json_encode(array('result'=> "</br> product ".$ean_code."</br> baseId ".$productBaseId
    			."</br> hf price ".$hausfabrikOfferPrice."</br> hf position ".$hausfabrikOfferPosition
    			."</br> hf stock ".$hausfabrikOfferStock."</br> first price ".$firstProductPrice
    			."</br> platform id ".$platformProductId."</br> productpage ".$linkPlatformProductPage."</br> hausfabrik ".$hausfabrikProductLink."</br> first ".$firstProductLink)));
    */
    }
    
    private function crawlGoogleShoppingProduct($ean_code){
    	$productBaseId;
    	$hf_price;
    	$hf_position;
    	$first_price;
    	$platform_product_id;
    	$link_platform_product_page;
    	$link_hf_product;
    	$link_first_product;
    	
    	$crawler = new GoogleShoppingCrawler();
    	
    	$crawler->init(true, false);
    	$crawler->init_crawler();
    	
    	//STEP.1 Search for product
    	$searchResponse = $crawler->searchByEANCode($ean_code);
    	
    	//STEP.2 Find platform id
    	$platformProductId = $crawler->findPlatformID($searchResponse);
    	
    	//STEP.3 Get product page & shops page
    	$productPage = $crawler->getProductPage($platformProductId);
    	
    	$firstProductPrice = "";
    	$firstProductLink = "";
    	$hausfabrikProductLink = "";
    	
    	// get first product
    	$firstProduct = $crawler->getFirstProduct($productPage);
    		
    	//get price of the first product displayed
    	$firstProductPrice = $crawler->getOfferPrice(htmlspecialchars($firstProduct, ENT_QUOTES));
    		
    	//get Hausfabrik offer
    	$hausfabrikOffer = $crawler->getHausfabrikOffer($productPage);
    		
    	//get Hausfabrik offer Position
    	$hausfabrikOfferPosition = $crawler->getOfferPosition($hausfabrikOffer);
    		
    	//get Hausfabrik external link
    	$hausfabrikProductLink = $crawler->getExternalProductLinkForOffer($hausfabrikOffer);
    		
    	//get Hausfabrik offer Price
    	$hausfabrikOfferPrice= $crawler->getOfferPrice(htmlspecialchars($hausfabrikOffer, ENT_QUOTES));
    		
    	//get first product external link
    	$firstProductLink = $crawler->getExternalProductLinkForOffer($firstProduct);
    	
    	$crawlerProduct = $crawler->getProductBase($ean_code);
    	
    	if($crawlerProduct != null){
    		$productBaseId = $crawlerProduct->getId();
    		
    		$linkPlatformProductPage = $crawler->getProductPageUrl($platformProductId);
    		
    		$crawler->saveProductListing($productBaseId, $hausfabrikOfferPrice, $hausfabrikOfferPosition, $firstProductPrice, $platformProductId, $linkPlatformProductPage, $linkHausfabrikProduct, $firstProductLink);
    	}
    	
    	return $this->jsonResponse(json_encode(array('result'=> "</br> product ".$ean_code."</br> baseId ".$productBaseId
    			."</br> hf price ".$hausfabrikOfferPrice."</br> hf position ".$hausfabrikOfferPosition."</br> first price ".$firstProductPrice
    			."</br> first position ".$platformProductId."</br> productpage ".$linkPlatformProductPage."</br> hausfabrik ".$hausfabrikProductLink."</br> first ".$firstProductLink)));
    }

    public function loadDataAjaxAction()
    {
    	
    	$pseQuery = ProductSaleElementsQuery::create();
    	$pseQuery
    		->useProductQuery()
    		->filterByBrandId(93)
    		->filterByVisible(1)
    		->endUse()
    		;
    	$pseResults = $pseQuery->where('`product_sale_elements`.EAN_CODE ',Criteria::ISNOTNULL)
    	
    //	->limit(3)
    	->find();
    	
    	$final = "\n";
    	/** @var \Thelia\Model\ProductSaleElements $pseResult */
    	foreach( $pseResults as $pseResult){
    	set_time_limit(0);
    	$final.= $this->crawlAmazonProduct($pseResult->getEanCode())."\n";
    	sleep(rand(1,5));
    	}
    	Tlog::getInstance()->error($final);

    	//return $this->crawlAmazonProduct("4005176314964");
    	//return $this->crawlGoogleShoppingProduct("4005176809996");
    	
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
