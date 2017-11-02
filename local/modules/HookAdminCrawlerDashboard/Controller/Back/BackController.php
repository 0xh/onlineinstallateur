<?php

namespace HookAdminCrawlerDashboard\Controller\Back;

use Doctrine\Common\Cache\FilesystemCache;
use HookAdminCrawlerDashboard\HookAdminCrawlerDashboard;
use Thelia\Controller\Admin\BaseAdminController;
use Thelia\Core\Security\AccessManager;
use Thelia\Model\ConfigQuery;
use Thelia\Model\CustomerQuery;
use Thelia\Model\OrderQuery;
use Thelia\Log\Tlog;
use HookAdminCrawlerDashboard\Controller\Crawler\GeizhalsCrawler;
use HookAdminCrawlerDashboard\Controller\Crawler\AmazonCrawler;
use HookAdminCrawlerDashboard\Controller\Crawler\IdealoCrawler;
use Thelia\Model\ProductSaleElementsQuery;
use Thelia\Model\Map\ProductSaleElementsTableMap;
use Propel\Runtime\ActiveQuery\Criteria;
use Thelia\Model\Map\BrandTableMap;
use Propel\Runtime\ActiveQuery\Join;
use Thelia\Model\Map\ProductTableMap;
use HookAdminCrawlerDashboard\Controller\Crawler\GoogleShoppingCrawler;

/**
 * Class CrawlerController
 * @package HookAdminCrawlerDashboard\Controller
 * @author Emanuel Plopu <emanuel.plopu@sepa.at>
 */
class BackController extends BaseAdminController
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

    /* @var Tlog $log */
    protected static $logger;
    
    private function crawlAmazonProduct($ean_code){
    	
    	$crawler = new AmazonCrawler();
    	
    	$crawler->setLogger($this->getLogger());
    	$crawler->init(false, false);
    	$crawler->init_crawler();
    	
    	//STEP.1 Search for product
    	$searchResponse = $crawler->searchByEANCode($ean_code);
    	//$this->getLogger()->error("amazon ".$searchResponse);
    	//STEP.2 Find platform id
    	$platformProductId = $crawler->findPlatformID($searchResponse);
    	if($platformProductId == null)
    		return "not found"; 
    	
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
    	
    	$this->getLogger()->error($ean_code.",".$productBaseId
    			.",".$hausfabrikOfferPrice.",".$hausfabrikOfferPosition
    			.",".$hausfabrikOfferStock.",".$firstProductPrice
    			.",".$platformProductId.",".$linkPlatformProductPage.",".$hausfabrikProductLink.",".$firstProductLink);
    	//return $linkPlatformProductPage;
    	return $ean_code.",".$productBaseId
    	.",".$hausfabrikOfferPrice.",".$hausfabrikOfferPosition
    	.",".$hausfabrikOfferStock.",".$firstProductPrice
    	.",".$platformProductId.",".$linkPlatformProductPage.",".$hausfabrikProductLink.",".$firstProductLink;
    	
    	return $this->jsonResponse(json_encode(array('result'=> "</br> product ".$ean_code."</br> baseId ".$productBaseId
    			."</br> hf price ".$hausfabrikOfferPrice."</br> hf position ".$hausfabrikOfferPosition
    			."</br> hf stock ".$hausfabrikOfferStock."</br> first price ".$firstProductPrice
    			."</br> platform id ".$platformProductId."</br> productpage ".$linkPlatformProductPage."</br> hausfabrik ".$hausfabrikProductLink."</br> first ".$firstProductLink)));
    
    }
    
    private function crawlGoogleShoppingProduct($ean_code){
    	
    	$crawler = new GoogleShoppingCrawler();
    	
    	$crawler->setLogger($this->getLogger());
    	$crawler->init(false, false);
    	$crawler->init_crawler();
    	
    	//STEP.1 Search for product
    	$searchResponse = $crawler->searchByEANCode($ean_code);
    	//$this->getLogger()->error("google ".$searchResponse);
    	//STEP.2 Find platform id
    	$platformProductId = $crawler->findPlatformID($searchResponse).'?prds=scoring:p';
    	
    	//STEP.3 Get product page & shops page
    	$productPage = $crawler->getProductPage($platformProductId);
    	
    	$firstProductPrice = "";
    	$firstProductLink = "";

    	$hausfabrikProductLink= "";
    	$hausfabrikOfferStock = -1;

    	
    	// get first product
    	$firstProduct = $crawler->getFirstProduct($productPage);
    		
    	//get price of the first product displayed
    	$firstProductPrice = $crawler->getOfferPrice(htmlspecialchars($firstProduct, ENT_QUOTES));
    		
    	//get Hausfabrik offer
    	//Tlog::getInstance()->error("getofferl ".$productPage);
    	$hausfabrikOffer = $crawler->getHausfabrikOffer($productPage);
    		
    	//get Hausfabrik offer Position
    	$hausfabrikOfferPosition = $crawler->getOfferPosition($hausfabrikOffer);
    		
    	//get Hausfabrik external link
    	//Tlog::getInstance()->error("beforeexternal ".$hausfabrikOffer);
    	$hausfabrikProductLink= $crawler->getExternalProductLinkForOffer($hausfabrikOffer);

    		
    	//get Hausfabrik offer Price
    	$hausfabrikOfferPrice= $crawler->getOfferPrice(htmlspecialchars($hausfabrikOffer, ENT_QUOTES));
    		
    	//get first product external link
    	$firstProductLink = $crawler->getExternalProductLinkForOffer($firstProduct);
    	
    	$crawlerProduct = $crawler->getProductBase($ean_code);
    	
    	if($crawlerProduct != null){
    		$productBaseId = $crawlerProduct->getId();
    		
    		$linkPlatformProductPage = $crawler->getProductPageUrl($platformProductId);

    		$crawler->saveProductListing($productBaseId, $hausfabrikOfferPrice, $hausfabrikOfferPosition, $hausfabrikOfferStock, $firstProductPrice, $platformProductId, $linkPlatformProductPage, $hausfabrikProductLink, $firstProductLink);

    	}
    	
    	return $ean_code.",".$productBaseId
    	.",".$hausfabrikOfferPrice.",".$hausfabrikOfferPosition
    	.",".$hausfabrikOfferStock.",".$firstProductPrice
    	.",".$platformProductId.",".$linkPlatformProductPage.",".$linkPlatformProductPage.",".$firstProductLink;
    	
    	return $this->jsonResponse(json_encode(array('result'=> "</br> product ".$ean_code."</br> baseId ".$productBaseId
    			."</br> hf price ".$hausfabrikOfferPrice."</br> hf position ".$hausfabrikOfferPosition."</br> first price ".$firstProductPrice
    			."</br> first position ".$platformProductId."</br> productpage ".$linkPlatformProductPage."</br> hausfabrik ".$hausfabrikProductLink."</br> first ".$firstProductLink)));
    }
    
    private function crawlGeizhalsProduct($ean_code){
    	
    	$crawler = new GeizhalsCrawler();
    	
    	$crawler->setLogger($this->getLogger());
    	$crawler->init(false, false);
    	$crawler->init_crawler();
    	
    	//STEP.1 Search for product
    	$searchResponse = $crawler->searchByEANCode($ean_code);
    	
    	//STEP.2 Find platform id
    	$platformProductId = $crawler->findPlatformID($searchResponse);
    	
    	$firstProductPrice = "";
    	$firstProductLink = "";
    	$hausfabrikProductLink = "";
    	$hausfabrikOfferStock = -1;
    	
    	// get first product
    	$firstProduct = $crawler->getFirstProduct($searchResponse);
    	
    	//get price of the first product displayed
    	$firstProductPrice = $crawler->getOfferPrice(htmlspecialchars($firstProduct, ENT_QUOTES));
    	
    	//get Hausfabrik offer
    	$hausfabrikOffer = $crawler->getHausfabrikOffer($searchResponse);
    	
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
    		
    		$crawler->saveProductListing($productBaseId, $hausfabrikOfferPrice, $hausfabrikOfferPosition, $hausfabrikOfferStock, $firstProductPrice,
    				$platformProductId, $linkPlatformProductPage, $hausfabrikProductLink, $firstProductLink);
    	}
    	
    	return $ean_code.",".$productBaseId
    	.",".$hausfabrikOfferPrice.",".$hausfabrikOfferPosition
    	.",".$hausfabrikOfferStock.",".$firstProductPrice
    	.",".$platformProductId.",".$linkPlatformProductPage.",".$linkPlatformProductPage.",".$firstProductLink;
    	
    	return $this->jsonResponse(json_encode(array('result'=> "</br> product ".$ean_code."</br> baseId ".$productBaseId
    			."</br> hf price ".$hausfabrikOfferPrice."</br> hf position ".$hausfabrikOfferPosition."</br> first price ".$firstProductPrice
    			."</br> first position ".$platformProductId."</br> productpage ".$linkPlatformProductPage."</br> hausfabrik ".$hausfabrikProductLink."</br> first ".$firstProductLink)));
    }
    
    private function crawlIdealoProduct($ean_code){
    	
    	$crawler = new IdealoCrawler();
    	
    	$crawler->setLogger($this->getLogger());
    	$crawler->init(true, false);
    	$crawler->init_crawler();
    	
    	//STEP.1 Search for product
    	$searchResponse = $crawler->searchByEANCode($ean_code);
    	
    	//STEP.2 Find platform id
    	$platformProductId = $crawler->findPlatformID($searchResponse);
    	
    	//STEP.3 Get product page
    	$productPage = $crawler->getProductPage($platformProductId);
    	
    	//STEP.4 Get prices and positions
    	$firstProductPrice = 0;
    	$firstProductLink = "";
    	$hausfabrikProductLink = "";
    	$hausfabrikOfferStock = -1;
    	
    	// get first product
    	$firstProduct = $crawler->getFirstProduct($productPage);
    		
    	//get price of the first product displayed
    	$firstProductPrice = $crawler->getOfferPrice(htmlspecialchars($firstProduct, ENT_QUOTES));
    		
    	//get Hausfabrik offer
    	$hausfabrikOffer = $crawler->getHausfabrikOffer($productPage);
    		
    	//get Hausfabrik offer Position
    	$hausfabrikOfferPosition = $crawler->getOfferPosition($hausfabrikOffer);
    	
    	$hausfabrikProductLink = $crawler->getExternalProductLinkForOffer($hausfabrikOffer);
    		
    	//get Hausfabrik offer Price
    	$hausfabrikOfferPrice= $crawler->getOfferPrice(htmlspecialchars($hausfabrikOffer, ENT_QUOTES));
    		
    	$firstProductLink = $crawler->getExternalProductLinkForOffer($firstProduct);
    	
    	//STEP.5 get CRAWLER_PRODUCT_BASE object from db
    	$crawlerProduct = $crawler->getProductBase($ean_code);
    	
    	//STEP.6 save CRAWLER_PRODUCT_LISTING object to db
    	if($crawlerProduct != null){
    		$productBaseId = $crawlerProduct->getId();
    		
    		$linkPlatformProductPage = $crawler->getProductPageUrl($platformProductId);
    		
    		$crawler->saveProductListing($productBaseId, $hausfabrikOfferPrice, $hausfabrikOfferPosition, $hausfabrikOfferStock, $firstProductPrice,
    				$platformProductId, $linkPlatformProductPage, $hausfabrikProductLink, $firstProductLink);
    	}
    	
    	$this->getLogger()->error($ean_code.",".$productBaseId
    			.",".$hausfabrikOfferPrice.",".$hausfabrikOfferPosition
    			.",".$hausfabrikOfferStock.",".$firstProductPrice
    			.",".$platformProductId.",".$linkPlatformProductPage.",".$hausfabrikProductLink.",".$firstProductLink);
    	return $ean_code.",".$productBaseId
    	.",".$hausfabrikOfferPrice.",".$hausfabrikOfferPosition
    	.",".$hausfabrikOfferStock.",".$firstProductPrice
    	.",".$platformProductId.",".$linkPlatformProductPage.",".$hausfabrikProductLink.",".$firstProductLink;
    	
    	return $this->jsonResponse(json_encode(array('result'=> "</br> product ".$ean_code."</br> baseId ".$productBaseId
    			."</br> hf price ".$hausfabrikOfferPrice."</br> hf position ".$hausfabrikOfferPosition
    			."</br> hf stock ".$hausfabrikOfferStock."</br> first price ".$firstProductPrice
    			."</br> platform id ".$platformProductId."</br> productpage ".$linkPlatformProductPage."</br> hausfabrik ".$hausfabrikProductLink."</br> first ".$firstProductLink)));
    	
    }

    public function runCronJob(){
    	$pseQuery = ProductSaleElementsQuery::create();
    	$pseQuery
    	->useProductQuery()
    	->filterByBrandId(93)
    	->filterByVisible(1)
    	->endUse()
    	;
    	$pseResults = $pseQuery->where('`product_sale_elements`.EAN_CODE ',Criteria::ISNOTNULL)
    	
    	->limit(5)
    	->find();
    	$this->getLogger()->error("starting crawl-job for amazon");
    	
    	$final = "";
    	foreach( $pseResults as $pseResult){
    		set_time_limit(0);
    		$final.= $this->crawlAmazonProduct($pseResult->getEanCode())."\n";
    		//$final= "||| ".$pseResult." ".$this->crawlAmazonProduct(str_replace (" ", "+", $pseResult));
    		//Tlog::getInstance()->error($final);
    		$final.= $this->crawlGoogleShoppingProduct($pseResult->getEanCode())."\n";
    		//$final.= $this->crawlGeizhalsProduct($pseResult->getEanCode())."\n";
    		//$final.= $this->crawlIdealoProduct($pseResult->getEanCode())."\n";
    		//usleep(250000)sleep(rand(100,500));
    	}
    	$this->getLogger()->error($final);
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
    	
    	->limit(5)
    	->find();
    	$this->getLogger()->error("starting crawl-job for ");
    	$final = "\n";
    	
    	
    	$final = "";
    	/** @var \Thelia\Model\ProductSaleElements $pseResult */
    	foreach( $pseResults as $pseResult){
    	set_time_limit(0);
    	$final.= $this->crawlAmazonProduct($pseResult->getEanCode())."\n";
    	//$final= "||| ".$pseResult." ".$this->crawlAmazonProduct(str_replace (" ", "+", $pseResult));
    	//Tlog::getInstance()->error($final);
    	$final.= $this->crawlGoogleShoppingProduct($pseResult->getEanCode())."\n";
    	$final.= $this->crawlGeizhalsProduct($pseResult->getEanCode())."\n";
    	//$final.= $this->crawlIdealoProduct($pseResult->getEanCode())."\n";
    	//usleep(250000)sleep(rand(100,500));
    	}
    	$this->getLogger()->error($final);

    	//return $this->crawlAmazonProduct("4005176314964");
    	//return $this->crawlGoogleShoppingProduct("4005176809996");
    	
    	//$crawler = new GeizhalsCrawler();
    	//$crawler = new AmazonCrawler();
    	//$crawler = new IdealoCrawler();
    	//$crawler = new GoogleShoppingCrawler();
    	
    	//return $this->jsonResponse(json_encode(array('result'=> $this->crawlGoogleShoppingProduct("4005176886294"))));
    	//return $this->jsonResponse(json_encode(array('result'=> $this->crawlGeizhalsProduct("4005176843204"))));
    	return $this->jsonResponse(json_encode(array('result'=> $this->crawlIdealoProduct("4005176306907"))));
    }   
    
    public function getLogger()
    {
    	if (self::$logger == null) {
    		self::$logger = Tlog::getNewInstance();
    		
    		$logFilePath = THELIA_LOG_DIR . DS . "log-crawler.txt";
    		
    		self::$logger->setPrefix("#LEVEL: #DATE #HOUR: ");
    		self::$logger->setDestinations("\\Thelia\\Log\\Destination\\TlogDestinationRotatingFile");
    		self::$logger->setConfig("\\Thelia\\Log\\Destination\\TlogDestinationRotatingFile", 0, $logFilePath);
    		self::$logger->setLevel(Tlog::ERROR);
    	}
    	return self::$logger;
    }
}
