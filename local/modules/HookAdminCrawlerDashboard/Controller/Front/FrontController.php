<?php

namespace HookAdminCrawlerDashboard\Controller\Front;

use Doctrine\Common\Cache\FilesystemCache;
use HookAdminCrawlerDashboard\HookAdminCrawlerDashboard;
use Thelia\Controller\Front\BaseFrontController;
use Thelia\Core\Security\AccessManager;
use Thelia\Model\ConfigQuery;
use Thelia\Model\CustomerQuery;
use Thelia\Model\OrderQuery;
use Thelia\Log\Tlog;
use HookAdminCrawlerDashboard\Controller\Crawler\GeizhalsCrawler;
use HookAdminCrawlerDashboard\Controller\Crawler\AmazonCrawler;
use HookAdminCrawlerDashboard\Controller\Crawler\IdealoCrawler;
use HookAdminCrawlerDashboard\Controller\Crawler\GoogleShoppingCrawler;
use Thelia\Model\ProductSaleElementsQuery;
use Thelia\Model\Map\ProductSaleElementsTableMap;
use Propel\Runtime\ActiveQuery\Criteria;
use Thelia\Model\Map\BrandTableMap;
use Propel\Runtime\ActiveQuery\Join;
use Thelia\Model\Map\ProductTableMap;

/**
 * Class FrontController
 * @package HookAdminCrawlerDashboard\Controller\Front
 * @author Emanuel Plopu <emanuel.plopu@sepa.at>
 */
class FrontController extends BaseFrontController
{

    /* @var Tlog $log */
    protected static $logger;
    private function crawlAmazonProduct_ausverkaufliste($ean_code){
    	
    	$crawler = new AmazonCrawler();
    	
    	$crawler->init(false, false);
    	$crawler->init_crawler();
    	
    	//STEP.1 Search for product
    	$searchResponse = $crawler->searchByEANCode($ean_code);
    	
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
    		/*
    		 Tlog::getInstance()->error($ean_code.",".$productBaseId
    		 .",".$hausfabrikOfferPrice.",".$hausfabrikOfferPosition
    		 .",".$hausfabrikOfferStock.",".$firstProductPrice
    		 .",".$platformProductId.",".$linkPlatformProductPage.",".$hausfabrikProductLink.",".$firstProductLink);*/
    		
    		return $linkPlatformProductPage.",".$firstProductPrice;
    		return $ean_code.",".$productBaseId
    		.",".$hausfabrikOfferPrice.",".$hausfabrikOfferPosition
    		.",".$hausfabrikOfferStock.",".$firstProductPrice
    		.",".$platformProductId.",".$linkPlatformProductPage.",".$hausfabrikProductLink.",".$firstProductLink;
    		
    		return $this->jsonResponse(json_encode(array('result'=> "</br> product ".$ean_code."</br> baseId ".$productBaseId
    				."</br> hf price ".$hausfabrikOfferPrice."</br> hf position ".$hausfabrikOfferPosition
    				."</br> hf stock ".$hausfabrikOfferStock."</br> first price ".$firstProductPrice
    				."</br> platform id ".$platformProductId."</br> productpage ".$linkPlatformProductPage."</br> hausfabrik ".$hausfabrikProductLink."</br> first ".$firstProductLink)));
    		
    }
    
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

	public function runCronJob_ausverkaufliste(){
		    	Tlog::getInstance()->error("crawling amazon for prices ");
    	$final = "\n";
    	
    	$pseResults =array(
    	"Afriso Euro Index 20053",
    	"Afriso Euro Index 20283",
    	"Afriso Euro Index 28000",
    	"Austria Email A03621",
    	"Austria Email A03622",
    	"Austria Email A03623",
    	"Austria Email A03624",
    	"Austria Email A03625",
    	"Austria Email A03627",
    			"Austria Email A86002",
    			"Austria Email A80310*",
    			"Austria Email A42836",
    			"Austria Email A29310",
    			"Austria Email A43237",
    			"Austria Email A23430",
    			"Austria Email A90726",
    			"Austria Email A90727",
    			"Austria Email A90729",
    			"Austria Email A24838",
    			"Austria Email A13838",
    			"Austria Email A13839",
    			"Austria Email A13835",
    			"Austria Email A13836",
    			"Austria Email CSOTSP10",
    			"Austria Email CSOTSP5",
    			"Austria Email CSUTSP10",
    			"Austria Email CSUTSP5",
    			"Austria Email A 138 08",
    			"Austria Email A26663/A25009",
    			"Austria Email A26093/A26007",
    			"Austria Email A42221",
    			"Austria Email A42229",
    			"Austria Email A38113",
    			"Austria Email A11134",
    			"Austria Email SMSP500.1PL",
    			"Austria Email A03432",
    			"Austria Email A03436",
    			"Austria Email A24843",
    			"Alape ALAPE",
    			"Alape ALAPE",
    			"Alape 5052000000",
    			"Alape 8306 000 978",
    			"Alape 3500000000",
    			"Aistleitner Winfried 279 MC 1/2",
    			"Aistleitner Winfried 279/I 1",
    			"Aistleitner Winfried 693 1/2",
    			"Aistleitner Winfried 294 G 1",
    			"Armacell TL-28/9-DG",
    			"Armacell PRO-AX-20X016",
    			"Armacell PRO-AX-20X018",
    			"Armacell PRO-AX-20X022",
    			"Armacell PRO-AX-20X025",
    			"Armacell PRO-AX-25X028",
    			"Armacell PRO-AX-25X032",
    			"Armacell PRO-AX-25X040",
    			"Armacell PRO-AX-25X042",
    			"Armacell SO-SDN16-CU15",
    			"Armacell SO-SDN16-E1/2",
    			"Armacell SO-SDN20-E3/4",
    			"Armacell SO-SDN20-I1",
    			"Armacell SO-SDN25-I1",
    			"Armacell SO-SDN16-CU18",
    			"Armacell SO-SDN20-CU18",
    			"Armacell SO-SDN20-CU22",
    			"Armacell SO-SDN16-DN16",
    			"Armacell SD-CF-80X60",
    			"Armacell SOR-350",
    			"Armacell SF-FM-006",
    			"Armacell SF-FM-010",
    			"Armacell SF-CTM-006",
    			"Armacell SF-CTM-010",
    			"Armacell SF-CTM-012",
    			"Armacell SF-CTM-016",
    			"Armacell SD-CP-110X75",
    			"Armacell SF-FZ-019",
    			"Artelinea ARTE LINEA",
    			"Artelinea ARTE LINEA",
    			"Artelinea BTML120.DX.TIFFANY.EXT",
    			"Artelinea TFD01 B: 75 H 80",
    			"Artelinea ARTE LINEA",
    			"Artelinea RM2FS54",
    			"Artweger 6751WH",
    			"Artweger L132WSEK",
    			"Artweger T2W101WSE",
    			"Artweger T2W201WS",
    			"Artweger HL4188LBEKALB",
    			"Artweger ARTWEGER-ERSATZTEILE",
    			"Artweger TLOHD2",
    			"Artweger ARTWEGER",
    			"Artweger E466NXEK",
    			"Artweger ARTWEGER",
    			"Artweger ARTWEGER",
    			"Artweger 7H820H MH EK 3 K",
    			"Artweger .",
    			"Artweger .",
    			"Artweger .",
    			"Artweger T822F MH EK B VC",
    			"Artweger 883351",
    			"Artweger ARTT5188108JCEK(J)B",
    			"Artweger T2ZT00HGEKJVC",
    			"Artweger L947WSEKJWS",
    			"Artweger L967WSEKJWS",
    			"Artweger L567WSEKJWS",
    			"Artweger L357WSEKJWS",
    			"Artweger ARTWEGER",
    			"Artweger ARTWEGER",
    			"Artweger LR67HGEK",
    			"Artweger G95DWSEK",
    			"Artweger T3257VCEKAVC",
    			"Artweger T415FVCEKJAVC",
    			"Artweger G144WSEKJ",
    			"Artweger 6445NXDD",
    			"Artweger C8C7SGEKJVC",
    			"Artweger L9M2WSEKVC",
    			"Artweger T416FMHEKJAVC",
    			"Artweger TE05FMHEKJAVC",
    			"Artweger TL8187MNEKJMN",
    			"Artweger W001VC",
    			"Artweger 7WH02",
    			"Artweger H1T2F159MHEKS",
    			"Artweger H1T2F259MHEKS",
    			"Ari 120710100-10",
    			"Ari 220140080191",
    			"Alpha Assembly Solutions 58232",
    			"Alpha Assembly Solutions 59916",
    			"Afg Arbonia Forster Riesa ZB02570001",
    			"Afg Arbonia Forster Riesa ZE01270002",
    			"Afg Arbonia Forster Riesa ZB02360001",
    			"Afg Arbonia Forster Riesa BTM180L AF",
    			"Atusa Deutschland 13021003",
    			"Atusa Deutschland 1021008",
    			"Atusa Deutschland 2021008",
    			"Atusa Deutschland 30021004",
    			"Atusa Deutschland 4105007",
    			"Atusa Deutschland 9225003",
    			"BWT Austria 882110",
    			"BWT Austria 883223",
    			"BWT Austria 883207",
    			"BWT Austria 860011",
    			"BWT Austria 860039",
    			"BWT Austria 860044",
    			"BWT Austria 860006",
    			"BWT Austria 80632",
    			"BWT Austria 82300",
    			"BWT Austria 93155",
    			"BWT Austria 810190",
    			"BWT Austria 810374",
    			"BWT Austria 810397",
    			"BWT Austria 810398",
    			"BWT Austria 810399",
    			"BWT Austria 810400",
    			"BWT Austria 830012",
    			"BWT Austria 830046",
    			"BWT Austria 830996",
    			"BWT Austria 820153",
    			"BWT Austria 874105",
    			"BWT Austria JUDO 8010034",
    			"BWT Austria 981005",
    			"BWT Austria 883079",
    			"BWT Austria 24012",
    			"BWT Austria 840343",
    			"BWT Austria 840349",
    			"BWT Austria 880053",
    			"Bertrams 120205",
    			"Bertrams 20210",
    			"Bertrams 20216",
    			"Bertrams 20219",
    			"Bertrams 100307",
    			"Bertrams 100107",
    			"Bertrams 100205",
    			"Bertrams 22506",
    			"Bertrams 21419",
    			"Bertrams 101607",
    			"Bertrams 101405",
    			"Bertrams 100210",
    			"Bertrams 100110",
    			"Bertrams 120109",
    			"Bertrams 21819",
    			"Bertrams 120212",
    			"Bertrams 121812",
    			"Bertrams 20310",
    			"Bertrams 120107",
    			"Bertrams 20207",
    			"Bertrams 129051",
    			"Buerkert-Contromatic 221867",
    			"Bonetti VK310001",
    			"Bette 2740-000",
    			"Bette 5836-000",
    			"Bette 5851-000",
    			"Bette 8857-000",
    			"Bette B50-1045",
    			"Bette B50-1049",
    			"Bette B50-1053",
    			"Bette B50-1055",
    			"Bette B50-1062",
    			"Bette B50-1064",
    			"Bette B50-1078",
    			"Bette B50-3035",
    			"Bette B50-3050",
    			"Bette B50-3066",
    			"Bette B572-901",
    			"Bette B608-901",
    			"Bette BETTE",
    			"Bette BETTE",
    			"Bette BETTE",
    			"Bette BETTE",
    			"Bette BETTE",
    			"Bette BETTE-MOD5830",
    			"Bette BETTE",
    			"Bette B574-400",
    			"Bette 5956",
    			"Bette 5952",
    			"Bette 5520",
    			"Bette 3390 IN WEIß MIT ANTIR",
    			"Bette B574-000 IN WEIß",
    			"Bette BETTE",
    			"Bette A046.GLASUR PLUS",
    			"Bette BETTE",
    			"Bette 3384+000AE",
    			"Bette B52-3049",
    			"Walraven 2134090092",
    			"Walraven 2154108110",
    			"Walraven 2181430",
    			"Walraven 2181440",
    			"Walraven 2189901",
    			"Walraven 3108079",
    			"Walraven 33148133",
    			"Walraven 6263808",
    			"Walraven 670600",
    			"Walraven 3188090",
    			"Walraven 6642110",
    			"Walraven 3408150",
    			"Walraven 3413063",
    			"Walraven 3362080",
    			"Walraven 4115400",
    			"Walraven 44009",
    			"Walraven 3362141",
    			"Walraven 6099013",
    			"Walraven 6099015",
    			"Walraven 6099810",
    			"Walraven 6099999",
    			"Walraven 6183805",
    			"Walraven 3188110",
    			"Walraven 7405300",
    			"Walraven 6103860",
    			"Walraven 33078036",
    			"Walraven 6505001",
    			"Walraven 3913220",
    			"Walraven 3913228",
    			"BSH-Hausgeraete WS12T440",
    			"Beulco 100477",
    			"Beulco 123483",
    			"Beulco 123537",
    			"Beulco 123063",
    			"Beulco 123254",
    			"Beulco 123681",
    			"Beulco 265428",
    			"Bernhardt's G. Soehne 6350",
    			"Bernhardt's G. Soehne 6360",
    			"Bernhardt's G. Soehne 6361",
    			"Bernhardt's G. Soehne 7584",
    			"Bammer Handels .",
    			"Bammer Handels .",
    			"Bammer Handels SSKFGTN032",
    			"Bosch Robert 0601882M03",
    			"Bosch Robert 060164C800",
    			"Berner Gesellschaft m.b.H 51900",
    			"ACO DUSCHRINNE 62MM",
    			"ACO 661896",
    			"ACO 661879",
    			"ACO 662501",
    			"ACO 662504",
    			"ACO 1179292",
    			"ACO 661906",
    			"ACO 620397",
    			"ACO 620402",
    			"ACO 620394",
    			"ACO 622616",
    			"ACO 9010.81.10",
    			"ACO 9010.81.20",
    			"ACO 675177",
    			"ACO 621350",
    			"ACO 621351",
    			"ACO 621380",
    			"ACO 621317",
    			"ACO 621308",
    			"ACO 621322",
    			"ACO 621304",
    			"ACO 621430",
    			"ACO 679945",
    			"ACO 622826",
    			"ACO 622827",
    			"ACO 622820",
    			"ACO 622821",
    			"ACO 622822",
    			"ACO 622816",
    			"ACO 622817",
    			"ACO 622818",
    			"ACO 622834",
    			"ACO 622838",
    			"ACO 622840",
    			"ACO 622841",
    			"ACO 622842",
    			"ACO 622284",
    			"ACO 622550",
    			"ACO 624154",
    			"ACO 624370",
    			"ACO 624365",
    			"ACO 624366",
    			"ACO 624882",
    			"ACO 624730",
    			"Blanco Austria Kuechen 520451",
    			"Blanco Austria Kuechen 515782",
    			"Blanco Austria Kuechen 518877",
    			"Blanco Austria Kuechen 514627",
    			"Christoefl Ernst 2001-075",
    			"Henkel Central Eastern 1541274",
    			"Henkel Central Eastern 1759669",
    			"Henkel Central Eastern 1617424",
    			"Henkel Central Eastern 1759667",
    			"Henkel Central Eastern 885821",
    			"Conform Badmöbel CSNMW60",
    			"Conform Badmöbel TE2 MET 1002 L 441",
    			"Conform Badmöbel .",
    			"Conform Badmöbel CONFORM",
    			"Conform Badmöbel CONFORM",
    			"Conform Badmöbel CONFORM",
    			"Conform Badmöbel CONFORM",
    			"Conform Badmöbel CONFORM",
    			"Conform Badmöbel CONFORM",
    			"Conform Badmöbel HS 3503 R",
    			"Conform Badmöbel HS3501L,JEDOCH 2-TÜRIG",
    			"Conform Badmöbel 12231/2",
    			"Conform Badmöbel SIS 90 LEU 748",
    			"Conform Badmöbel MW 90 M",
    			"Conform Badmöbel MW 90 L",
    			"Conform Badmöbel WU 88 R 748",
    			"Conform Badmöbel FÜßE ZU 4803 NACH M",
    			"Conform Badmöbel AN OS 251 748",
    			"Conform Badmöbel AN HS 302 748",
    			"Conform Badmöbel AN SPS 1202 LB 755",
    			"Conform Badmöbel AN SPS 1202 LB 748",
    			"Conform Badmöbel AN WU 582 T 748",
    			"Conform Badmöbel AN WU 581 A 748",
    			"Conform Badmöbel AN WU 601 A 410",
    			"Conform Badmöbel AN WU 902 L 748",
    			"Conform Badmöbel AN WU 1202 L 2B 748",
    			"Conform Badmöbel AN WU 1204 L 2B 748",
    			"Conform Badmöbel CR HAL 751 A 5087",
    			"Conform Badmöbel CD WU 611 A 10",
    			"CWS-boco 4205000",
    			"CWS-boco 4630000",
    			"CWS-boco 5502",
    			"CWS-boco 6031",
    			"CWS-boco 710",
    			"CWS-boco 9850090",
    			"CWS-boco 751000",
    			"CWS-boco 761077",
    			"CWS-boco 781020",
    			"CWS-boco 4604000",
    			"Csernohorszky E. 90501",
    			"Clage 1500-15003",
    			"Duscholux 699900100",
    			"Duscholux 663654003001",
    			"Duscholux 699330010078",
    			"Duscholux 376500120751062",
    			"Duscholux 389341820551070",
    			"Duscholux DUSCHOLUX",
    			"Duscholux DUSCHOLUX",
    			"Duscholux 274424090070551",
    			"Duscholux 271439090070551",
    			"Duscholux 396.42XX20.551.062",
    			"Duscholux 396.43XX20.551.062",
    			"Duscholux 341.427025.062.551 = 3",
    			"Duscholux 239,120021,062,751",
    			"Duscholux 293521190",
    			"Duscholux 420.121424 062 551",
    			"Duscholux 420.207023 062 551",
    			"Duscholux 660773102",
    			"Duscholux DUSCHOLUX",
    			"Duscholux DUSCHOLUX",
    			"Duscholux 271627090130070",
    			"Duscholux 699001010001",
    			"Duscholux 620201",
    			"Duscholux DUSCHOLUX",
    			"Duscholux DUSCHOLUX",
    			"Duscholux 319147091",
    			"Duscholux 697946504001",
    			"Duscholux 420181452070551",
    			"Duscholux 291204090751070",
    			"Duscholux 699000004001",
    			"Metusan 320412",
    			"Metusan 121806",
    			"Metusan 250320",
    			"Metusan S6/3530-2012",
    			"Pressalit A/S 982000-B47999",
    			"De Dietrich 88017851",
    			"De Dietrich 84887528",
    			"De Dietrich 84887682",
    			"De Dietrich 89997024",
    			"Dornbracht 415020520090",
    			"Dornbracht 10060970-00",
    			"Dornbracht 10200970-00",
    			"Dornbracht 12801970-00",
    			"Dornbracht 13420979-00",
    			"Dornbracht 13801730-00",
    			"Dornbracht 13801892-00",
    			"Dornbracht 17500892-00",
    			"Dornbracht 20000892-00",
    			"Dornbracht 20715782-00",
    			"Dornbracht 22513892-00",
    			"Dornbracht 22901979-00",
    			"Dornbracht 25133892-00",
    			"Dornbracht 26402730-00",
    			"Dornbracht 26403710-00",
    			"Dornbracht 26403892-00",
    			"Dornbracht 26403955-00",
    			"Dornbracht 27714970-00",
    			"Dornbracht 27719970-00",
    			"Dornbracht 27805625-00",
    			"Dornbracht 27806625-00",
    			"Dornbracht 27808730-00",
    			"Dornbracht 27818979-00",
    			"Dornbracht 28050955-00",
    			"Dornbracht 28450955-00",
    			"Dornbracht 28549970-00",
    			"Dornbracht 28579969-00",
    			"Dornbracht 29140979-00",
    			"Dornbracht 30010892-00",
    			"Dornbracht 32800680-00",
    			"Dornbracht 32815625-00",
    			"Dornbracht 32843680-00",
    			"Dornbracht 33200960-00",
    			"Dornbracht 33233625-00",
    			"Dornbracht 33300625-00",
    			"Dornbracht 33300960-00",
    			"Dornbracht 33500730-00",
    			"Dornbracht 33500985-00",
    			"Dornbracht 33501625-00",
    			"Dornbracht 33525885-00",
    			"Dornbracht 33525960-00",
    			"Dornbracht 33526670-00",
    			"Dornbracht 33534960-00",
    			"Dornbracht 33537670-00",
    			"Dornbracht 33870790-00",
    			"Dornbracht 33870791-00",
    			"Dornbracht 34420970-09",
    			"Dornbracht 3500897090",
    			"Dornbracht 3531597090",
    			"Dornbracht 3541697090",
    			"Dornbracht 3542697090",
    			"Dornbracht 3543697090",
    			"Dornbracht 3580797090",
    			"Dornbracht 3580897090",
    			"Dornbracht 3594697090",
    			"Dornbracht 36015960-00",
    			"Dornbracht 36020670-00",
    			"Dornbracht 36115730-00",
    			"Dornbracht 36115782-00",
    			"Dornbracht 36246970-00",
    			"Dornbracht 36310732-00",
    			"Dornbracht 36310780-00",
    			"Dornbracht 36310960-00",
    			"Dornbracht 36425670-00",
    			"Dornbracht 36426970-00",
    			"Dornbracht 36810782-00",
    			"Dornbracht 36812782-00",
    			"Dornbracht 36812885-00",
    			"Dornbracht 36826782-00",
    			"Dornbracht 41100979-85",
    			"Dornbracht 83211892-00",
    			"Dornbracht 83251220-00",
    			"Dornbracht 83500780-00",
    			"Dornbracht 83590892-00",
    			"Dornbracht 83900979-06",
    			"Dornbracht 9015050300090",
    			"Dornbracht 04282219800-00/211305",
    			"Dornbracht 83404730-00",
    			"Dornbracht 3562197090 1/2",
    			"Dornbracht 3569597090",
    			"Dornbracht 3508597090",
    			"Dornbracht 83500670-00",
    			"Dornbracht DORNBRACHT",
    			"Dornbracht DORNBRACHT",
    			"Dornbracht 424042870000",
    			"Dornbracht 9030300140090",
    			"Dornbracht 33 600 935-00",
    			"Dornbracht 04121107301-00",
    			"Dornbracht 093120049-00",
    			"Dornbracht 3569697090",
    			"Dornbracht 33300935-00",
    			"Dornbracht 04240418900-00",
    			"Dornbracht 27805935-00",
    			"Dornbracht 28450935-00",
    			"Dornbracht 3508697090",
    			"Dornbracht 3594797090",
    			"Dornbracht 36425969-00",
    			"Dornbracht 36425970-00",
    			"Dornbracht 3502197090",
    			"Dornbracht 26403979-00",
    			"Dornbracht 36325980-00",
    			"Dornbracht 36337980-00",
    			"Dornbracht 36425710-00",
    			"Dornbracht 13801935-00",
    			"Dornbracht 26403965-00",
    			"Dornbracht 36020955-00",
    			"Dornbracht 36020965-00",
    			"Dornbracht 36120955-00",
    			"Dornbracht 36120960-00",
    			"Dornbracht 36425960-00",
    			"Dornbracht 36812965-00",
    			"Dornbracht 33300965-00",
    			"Dornbracht 28745979-00",
    			"Dornbracht 13425979-00",
    			"Dornbracht 27755972-00",
    			"Dornbracht 28013979-00",
    			"Dornbracht 33501782-06",
    			"Dornbracht 36020979-00",
    			"Dornbracht 33534965-00",
    			"Dornbracht 36416960-00",
    			"Dornbracht 36812935-00",
    			"Dornbracht 421340810090",
    			"Dornbracht 33301670-00",
    			"Dornbracht 9015010050090",
    			"Dornbracht 9141001090",
    			"Dueker Fried.Wilh. & 663904",
    			"Dansani A/S 537808103",
    			"Dansani A/S 90076",
    			"Dansani A/S N160131",
    			"Dansani A/S NM-10133",
    			"Dansani A/S SP-3721-E",
    			"Dansani A/S SP-3787-E",
    			"Dansani A/S SP-3760-E",
    			"Dansani A/S DMS-2411",
    			"Dansani A/S MMM-1699G",
    			"Dansani A/S SP-5212-E",
    			"Danfoss 013G0037",
    			"Danfoss 013G2730",
    			"Danfoss 013G4120",
    			"Danfoss 013G4185",
    			"Danfoss 013G7711",
    			"Danfoss 144B2390",
    			"Danfoss 144B2394",
    			"Danfoss 144H0936",
    			"Danfoss 014G0051",
    			"Danfoss 014G0281",
    			"Danfoss 192H0188",
    			"Danfoss 193B1436",
    			"Danfoss 030F6014",
    			"Danfoss 030F6916",
    			"Danfoss 030H6914",
    			"Danfoss 003L1035",
    			"Danfoss 003L6008",
    			"Danfoss 003L7612",
    			"Danfoss 003Z0233",
    			"Danfoss 003Z0235",
    			"Danfoss 087N6451",
    			"Danfoss 088L0402",
    			"Danfoss 088L0406",
    			"Danfoss 088L1200",
    			"Danfoss 088L5370",
    			"Danfoss 088U0214",
    			"Danfoss 088U0221",
    			"Danfoss 013G2990 (ALT 003G295",
    			"Danfoss 086V8890",
    			"Danfoss DANFOSS",
    			"Danfoss 003Z0773",
    			"Danfoss 19116920",
    			"Danfoss 082G5408",
    			"Danfoss 082G5409",
    			"Danfoss 003G1029",
    			"Danfoss 082G3438",
    			"Danfoss #",
    			"Danfoss #",
    			"Duravit 50200000",
    			"Duravit 50280000",
    			"Duravit 60590000",
    			"Duravit 66300000",
    			"Duravit 1900900001",
    			"Duravit 243090000",
    			"Duravit 302560000",
    			"Duravit 312600000",
    			"Duravit 329100000",
    			"Duravit 334520000",
    			"Duravit 369700000",
    			"Duravit 454100027",
    			"Duravit 702250000",
    			"Duravit 765650000",
    			"Duravit 7904000001",
    			"Duravit 8233600001",
    			"Duravit 2201090000",
    			"Duravit 2319550000",
    			"Duravit 2527090000",
    			"Duravit 2529090000",
    			"Duravit 2536090000",
    			"Duravit 42000900A1",
    			"Duravit 42250900A1",
    			"Duravit 45270900A1",
    			"Duravit 45520900A1",
    			"Duravit 700135000000000",
    			"Duravit 700136000000000",
    			"Duravit 700338000000000",
    			"Duravit 790125000000000",
    			"Duravit 790126000000000",
    			"Duravit 790150000000000",
    			"Duravit 790226000001000",
    			"Duravit 790228000001000",
    			"Duravit 790290000001000",
    			"Duravit 791203000001000",
    			"Duravit KT663804949",
    			"Duravit XL1137R2222",
    			"Duravit DURAVIT 005060",
    			"Duravit X-LARGE-1400MM",
    			"Duravit 067C/83 OHNE AUSSCHNIT",
    			"Duravit 067C/83 OHNE AUSSCHNIT",
    			"Duravit 067C/83 OHNE AUSSCHNIT",
    			"Duravit 067C/83 OHNE AUSSCHNIT",
    			"Duravit DURAVIT",
    			"Duravit 7230",
    			"Duravit XL 063C 62",
    			"Duravit .",
    			"Duravit LM9708",
    			"Duravit XL 6209 L 53 53",
    			"Duravit OT8272.18",
    			"Duravit OT9902",
    			"Duravit OT828C.18",
    			"Duravit 74201000",
    			"Duravit DS 6381 18",
    			"Duravit 954393",
    			"Duravit 61631000",
    			"Duravit 006581 00 00",
    			"Duravit DS6481 FARBE M18 WEIß",
    			"Duravit 2534090000",
    			"Duravit 720094000000001",
    			"Duravit 791217000001000",
    			"Duravit 7053600092",
    			"Duravit 374620000",
    			"Duravit 2808300000",
    			"Duravit 713500009",
    			"Duravit 790158000000000",
    			"Duravit 858310000",
    			"Duravit 2332120000",
    			"Duravit 2332850000",
    			"Duravit 2561090000",
    			"Duravit 716450000",
    			"Duravit 20310000",
    			"Duravit 20390000",
    			"Duravit 2529092000",
    			"Duravit 45700900A1",
    			"Duravit 034812 00 002",
    			"Duka OCEK2900190SILA10",
    			"Duka PLGTW2L900195CSHA10P",
    			"Duka PLGW2900195CSHA10P",
    			"Duka PLMUPT800190SILKA1",
    			"Duka PLCUPT800190SILA10",
    			"Duka PLCUS900190WEIA10",
    			"Duka O-GBP1750150A10SHL",
    			"Duka CUPT1000190SILA10",
    			"Duka FW31400140SILA3",
    			"Duka FX31600140SHLA3",
    			"Duka MUSP800165SILKA1",
    			"Duka PLCRST3L1200195SILA10",
    			"Duka 1/4297/1",
    			"Duka #",
    			"Doyma & Co 188000010040",
    			"Den Braven Sealants 70227",
    			"Eder Anton 50921",
    			"Eder Anton 52451",
    			"Eder Anton 50502",
    			"Eder Anton 50505",
    			"Eder Anton 11100",
    			"Eder Anton 50802",
    			"Eder Anton 50924",
    			"Elektra Bregenz 7990105000",
    			"Erne Fittings 176",
    			"Erne Fittings 41273",
    			"Erne Fittings 103603",
    			"Bosch Robert 7719000837",
    			"Bosch Robert 7738110515",
    			"Bosch Robert 7719002507",
    			"Bosch Robert JUNKERS",
    			"Bosch Robert 7736900117*",
    			"Bosch Robert 87181070870",
    			"Bosch Robert 7719001283",
    			"Bosch Robert 7719001480",
    			"Bosch Robert 7719002188",
    			"Bosch Robert 7719002858",
    			"Bosch Robert 7719002887",
    			"Bosch Robert 7719003697",
    			"Bosch Robert 7719003698",
    			"Bosch Robert 7736995000",
    			"Bosch Robert 87074020180",
    			"Bosch Robert 87085040050",
    			"Bosch Robert 7719001208",
    			"Bosch Robert 87154066590",
    			"Bosch Robert 7736501472",
    			"Bosch Robert 7702330998",
    			"Bosch Robert 7701331661",
    			"Bosch Robert 7712231469",
    			"Bosch Robert 7736900117",
    			"Bosch Robert 7736900118",
    			"Bosch Robert 7736900119",
    			"Bosch Robert 7716010477",
    			"Eka Edelstahlkamine 2400180B30",
    			"Eka Edelstahlkamine 2400130F90",
    			"Emco Bad 002-1050",
    			"Emco Bad 177500100",
    			"Emco Bad 425000140",
    			"Emco Bad 428000106",
    			"Ewe Wilhelm 3829625",
    			"Eurotronic Technology 700100101",
    			"Eurotronic Technology 700100303",
    			"Easy Sanitary Solutions BV EDM1700-30",
    			"Easy Sanitary Solutions BV WLGW700",
    			"Fertinger RF1B-5/4VZ",
    			"Fertinger RF1B-6/4VZ",
    			"Fertinger RF1B-2 VZ",
    			"Fertinger RF3L-130-M16",
    			"Fertinger RF",
    			"Fertinger B117-01-MS",
    			"Fertinger WGK060-SONDER ABLAUF",
    			"Fertinger RF1170-10",
    			"Fertinger RF-RV12-1/2-R",
    			"Fertinger RF3L-120-M16",
    			"Fertinger RF23-GAS",
    			"Fertinger RF-B1169-2",
    			"Fertinger RF272",
    			"Fertinger RF170-0",
    			"Fertinger RF3D-M16-100",
    			"Fertinger RF13-1/2VZ",
    			"Fertinger RF-B70-2",
    			"Fertinger RF107B-10-1000",
    			"Fertinger RF1092R-1",
    			"Fertinger RF19Z-40X53-G",
    			"Fertinger RF-ELV-751-300",
    			"Frankstahl DKRED139X76",
    			"Franke 2030025078",
    			"Franke 7612210015151",
    			"Franke 7612210006678",
    			"Franke FAID676",
    			"Franke 7612982001314",
    			"Franke FAID681",
    			"Franke FRANKE",
    			"Franke 7912979002225",
    			"Franke XINX672",
    			"Franke 7612982080562",
    			"Franke Z534706000",
    			"Franke Z500476",
    			"Franke K.38.93.00.931.34",
    			"Franke 12191042000",
    			"Franke 13191041000",
    			"Franke 20194580000",
    			"Franke 26191620000",
    			"Franke 2000101213",
    			"Franke 2000101214",
    			"Franke 26000620000",
    			"Franke 21194480000",
    			"Franke 2030007208",
    			"Franke 2000105120",
    			"Franke 2000102693",
    			"Franke 2000100867",
    			"Franke K244221000C86",
    			"Franke Z530340000",
    			"Franke 1150315624",
    			"Froeling 68113",
    			"ALIAXIS Utilities & Industry 612649",
    			"ALIAXIS Utilities & Industry 800328",
    			"ALIAXIS Utilities & Industry 612029",
    			"ALIAXIS Utilities & Industry 698637",
    			"ALIAXIS Utilities & Industry 554062",
    			"ALIAXIS Utilities & Industry 800314",
    			"ALIAXIS Utilities & Industry 698508",
    			"ALIAXIS Utilities & Industry 800316",
    			"ALIAXIS Utilities & Industry 800324",
    			"Friatec 328101",
    			"Brinko-Werkzeugfabrik 105-1/10",
    			"Brinko-Werkzeugfabrik 1365",
    			"Brinko-Werkzeugfabrik 1728/146",
    			"Brinko-Werkzeugfabrik 345210",
    			"Brinko-Werkzeugfabrik 4260",
    			"Brinko-Werkzeugfabrik 4200",
    			"Brinko-Werkzeugfabrik 1374/460X16",
    			"Brinko-Werkzeugfabrik 4280",
    			"Brinko-Werkzeugfabrik 690/250",
    			"Brinko-Werkzeugfabrik 4086",
    			"Brinko-Werkzeugfabrik 795/250",
    			"Brinko-Werkzeugfabrik 4096",
    			"Brinko-Werkzeugfabrik 720/1",
    			"Brinko-Werkzeugfabrik 1374/110X6",
    			"Brinko-Werkzeugfabrik 4073/20",
    			"Brinko-Werkzeugfabrik 793948",
    			"Brinko-Werkzeugfabrik 4398",
    			"Brinko-Werkzeugfabrik 4399",
    			"Brinko-Werkzeugfabrik 4262",
    			"Brinko-Werkzeugfabrik 4261",
    			"Brinko-Werkzeugfabrik 526/9825",
    			"Brinko-Werkzeugfabrik 526/29036",
    			"Brinko-Werkzeugfabrik 526/20048",
    			"Brinko-Werkzeugfabrik 526/29048",
    			"Brinko-Werkzeugfabrik 526/18078",
    			"Brinko-Werkzeugfabrik 526/36578",
    			"Brinko-Werkzeugfabrik 526/45078",
    			"Brinko-Werkzeugfabrik 526/54078",
    			"Brinko-Werkzeugfabrik 2036",
    			"Brinko-Werkzeugfabrik 625-14/50",
    			"Brinko-Werkzeugfabrik 4230",
    			"Brinko-Werkzeugfabrik 1374/460X18",
    			"Brinko-Werkzeugfabrik 4210",
    			"Brinko-Werkzeugfabrik 4201",
    			"Brinko-Werkzeugfabrik 65746",
    			"Brinko-Werkzeugfabrik 7510",
    			"Brinko-Werkzeugfabrik 1374/460X12",
    			"Brinko-Werkzeugfabrik 12/250",
    			"Brinko-Werkzeugfabrik 6210/230",
    			"Brinko-Werkzeugfabrik 6210/178",
    			"Brinko-Werkzeugfabrik 6210/115",
    			"Brinko-Werkzeugfabrik 228310",
    			"Brinko-Werkzeugfabrik 2999",
    			"Brinko-Werkzeugfabrik 569688",
    			"Brinko-Werkzeugfabrik 1374/210X18",
    			"Brinko-Werkzeugfabrik 666/1",
    			"Brinko-Werkzeugfabrik 567102",
    			"Brinko-Werkzeugfabrik 567832",
    			"Brinko-Werkzeugfabrik 567893",
    			"Brinko-Werkzeugfabrik 623836",
    			"Brinko-Werkzeugfabrik 2991",
    			"Brinko-Werkzeugfabrik 6200/178",
    			"Brinko-Werkzeugfabrik 1374/210X16",
    			"Fischer Georg Fittings 770120209",
    			"Fischer Georg Fittings 770121209",
    			"Fischer Georg Fittings 770129136",
    			"Fischer Georg Fittings 770130111",
    			"Fischer Georg Fittings 770129232",
    			"Fischer Georg Fittings 770133104",
    			"Fischer Georg Fittings 770134104",
    			"Fischer Georg Fittings 770180208",
    			"Fischer Georg Fittings 770001112",
    			"Fischer Georg Fittings 770001201",
    			"Fischer Georg Fittings 770241153",
    			"Fischer Georg Fittings 770245138",
    			"Fischer Georg Fittings 770245121",
    			"Fischer Georg Fittings 770271109",
    			"Fischer Georg Fittings 770281104",
    			"Fischer Georg Fittings 770291106",
    			"Fischer Georg Fittings 770002112",
    			"Fischer Georg Fittings 770308204",
    			"Fischer Georg Fittings 770330111",
    			"Fischer Georg Fittings 770003205",
    			"Fischer Georg Fittings 770041203",
    			"Fischer Georg Fittings 770041210",
    			"Fischer Georg Fittings 770526126",
    			"Fischer Georg Fittings 770596206",
    			"Fischer Georg Fittings 770599205",
    			"Fischer Georg Fittings 770092116",
    			"Fischer Georg Fittings 770096104",
    			"Fischer Georg Fittings 770098104",
    			"Fischer Georg Fittings 775102062",
    			"Fischer Georg Fittings 775990004",
    			"Fischer Georg Fittings 770970338",
    			"Franke Deutschland 1150373942",
    			"Franke Deutschland 1150373790",
    			"Franke Deutschland 1030013947",
    			"Franke Deutschland FRANKE",
    			"Franke Deutschland FRANKE",
    			"Franke Deutschland 1120013868",
    			"Franke Deutschland FRANKE",
    			"Franke Deutschland FRANKE",
    			"Franke Deutschland 7612982073236",
    			"Franke Deutschland 1120008398",
    			"Franke Deutschland 1010024026",
    			"Franke Deutschland 1150184257",
    			"Franke Deutschland 1140016516",
    			"Franke Deutschland 1030011582",
    			"Franke Deutschland 1030011568BL",
    			"Franke Deutschland 1330017190",
    			"Franke Deutschland MTX220",
    			"Grohe Vorausdispobestellung 0529100M",
    			"Grohe Vorausdispobestellung 6706000",
    			"Grohe Vorausdispobestellung 6707000",
    			"Grohe Vorausdispobestellung 13927000",
    			"Grohe Vorausdispobestellung 1411400M",
    			"Grohe Vorausdispobestellung 19507002",
    			"Grohe Vorausdispobestellung 25450001",
    			"Grohe Vorausdispobestellung 27271000",
    			"Grohe Vorausdispobestellung 27753000",
    			"Grohe Vorausdispobestellung 27755000",
    			"Grohe Vorausdispobestellung 28497000",
    			"Grohe Vorausdispobestellung 28576000",
    			"Grohe Vorausdispobestellung 28621000",
    			"Grohe Vorausdispobestellung 28690000",
    			"Grohe Vorausdispobestellung 28724000",
    			"Grohe Vorausdispobestellung 28831001",
    			"Grohe Vorausdispobestellung 28963000",
    			"Grohe Vorausdispobestellung 28982000",
    			"Grohe Vorausdispobestellung 28993000",
    			"Grohe Vorausdispobestellung 31375000",
    			"Grohe Vorausdispobestellung 32208001",
    			"Grohe Vorausdispobestellung 3224010E",
    			"Grohe Vorausdispobestellung 32762000",
    			"Grohe Vorausdispobestellung 32955000",
    			"Grohe Vorausdispobestellung 33849000",
    			"Grohe Vorausdispobestellung 33865000",
    			"Grohe Vorausdispobestellung 37791SH0",
    			"Grohe Vorausdispobestellung 3855800M",
    			"Grohe Vorausdispobestellung 43715000",
    			"Grohe Vorausdispobestellung 45188000",
    			"Grohe Vorausdispobestellung 46022000",
    			"Grohe Vorausdispobestellung 47456000",
    			"Grohe Vorausdispobestellung 33558003",
    			"Gebe FZE2255",
    			"Gebe GEBA404D00",
    			"Gebe GEBA808B12",
    			"Gebe 906404",
    			"Gebe G905966",
    			"Geberit 111808001",
    			"Geberit 111878001",
    			"Geberit 111891001",
    			"Geberit 115260111",
    			"Geberit 115863001",
    			"Geberit 116012111",
    			"Geberit 116016001",
    			"Geberit 116125211",
    			"Geberit 146170111",
    			"Geberit 147022001",
    			"Geberit 150755111",
    			"Geberit 154003001",
    			"Geberit 154102001",
    			"Geberit 154105001",
    			"Geberit 154106001",
    			"Geberit 154131001",
    			"Geberit 154350001",
    			"Geberit 154351001",
    			"Geberit 154353001",
    			"Geberit 154363001",
    			"Geberit 215430111",
    			"Geberit 240343001",
    			"Geberit 240457001",
    			"Geberit 240469211",
    			"Geberit 240616001",
    			"Geberit 241912111",
    			"Geberit 305812261",
    			"Geberit 306812261",
    			"Geberit 307078141",
    			"Geberit 308058141",
    			"Geberit 312150141",
    			"Geberit 312300141",
    			"Geberit 315124141",
    			"Geberit 348306001",
    			"Geberit 358831001",
    			"Geberit 359003001",
    			"Geberit 359636001",
    			"Geberit 359639001",
    			"Geberit 363841002",
    			"Geberit 367385161",
    			"Geberit 367674001",
    			"Geberit 369385161",
    			"Geberit 370015161",
    			"Geberit 370030161",
    			"Geberit 370146161",
    			"Geberit 370195161",
    			"Geberit 371146161",
    			"Geberit 371700161",
    			"Geberit 390295141",
    			"Geberit 390495141",
    			"Geberit 390499261",
    			"Geberit 390650141",
    			"Geberit 390696141",
    			"Geberit 405012001",
    			"Geberit 606596005",
    			"Geberit 612362225",
    			"Geberit 616201001",
    			"Geberit 650273001",
    			"Geberit 650513221",
    			"Geberit 650514221",
    			"Geberit 650515221",
    			"Geberit 650652001",
    			"Geberit 650682001",
    			"Geberit 650920001",
    			"Geberit 651272001",
    			"Geberit 651289001",
    			"Geberit 651293001",
    			"Geberit 652483001",
    			"Geberit 652563001",
    			"Geberit 652583001",
    			"Geberit 653422001",
    			"Geberit 653423001",
    			"Geberit 653432001",
    			"Geberit 653433001",
    			"Geberit 653443001",
    			"Geberit 653444001",
    			"Geberit 653454001",
    			"Geberit 653455001",
    			"Geberit 653462001",
    			"Geberit 653472001",
    			"Geberit 653483001",
    			"Geberit 653484001",
    			"Geberit 653485001",
    			"Geberit 115770115",
    			"Geberit 115081SJ1",
    			"Geberit 115081SQ1",
    			"Geberit 115084FW1",
    			"Geberit 115084SJ1",
    			"Geberit 115084SQ1",
    			"Geberit 115085KM1",
    			"Geberit 115240KH1",
    			"Geberit 115260211",
    			"Geberit 115792GH1",
    			"Geberit 115802111",
    			"Geberit 115906SN1",
    			"Geberit 118007CG1",
    			"Geberit 150425461",
    			"Geberit 359447002",
    			"Geberit 651275001",
    			"Geberit 651276001",
    			"Geberit HU-111113",
    			"Geberit HU-131051",
    			"Geberit HU140150",
    			"Geberit HU-150151",
    			"Geberit HU-160021",
    			"Geberit HU-UR3020.6-10G",
    			"Geberit 359.125.00.1",
    			"Geberit HUTER",
    			"Geberit 290510990000",
    			"Geberit HUTER",
    			"Geberit HUTER",
    			"Geberit 115.883.KH.1",
    			"Geberit GEBERIT",
    			"Geberit 90453",
    			"Geberit 90454",
    			"Geberit 90455",
    			"Geberit HUWC1028G",
    			"Geberit 691398001*",
    			"Geberit 150.675.21.1",
    			"Geberit 115135211",
    			"Geberit 115620001",
    			"Geberit 115882KM1",
    			"Geberit 115883KJ1",
    			"Geberit 21344",
    			"Geberit 115883KH1",
    			"Geberit 131022SJ5",
    			"Geberit 33741",
    			"Geberit 33750",
    			"Geberit 371776",
    			"Geberit 19411",
    			"Geberit 21308",
    			"Geberit 21601",
    			"Geberit 21603",
    			"Geberit 21605",
    			"Geberit 21608",
    			"Geberit 22111",
    			"Geberit 23709",
    			"Geberit 25051",
    			"Geberit 25300",
    			"Geberit 29101",
    			"Geberit 30805",
    			"Geberit 31229",
    			"Geberit 31249",
    			"Geberit 31250",
    			"Geberit 32346",
    			"Geberit 32711",
    			"Geberit 33709",
    			"Geberit 34037",
    			"Geberit 34081",
    			"Geberit 34085",
    			"Geberit 34096",
    			"Geberit 34099",
    			"Geberit 34109",
    			"Geberit 34158",
    			"Geberit 34181",
    			"Geberit 34250",
    			"Geberit 34260",
    			"Geberit 34406",
    			"Geberit 34443",
    			"Geberit 34540",
    			"Geberit 34546",
    			"Geberit 34601",
    			"Geberit 34616",
    			"Geberit 36119",
    			"Geberit 36128",
    			"Geberit 36176",
    			"Geberit 52313",
    			"Geberit 52656",
    			"Geberit 60402",
    			"Geberit 60863",
    			"Geberit 60954",
    			"Geberit 61197",
    			"Geberit 61932",
    			"Geberit 63865",
    			"Geberit 63866",
    			"Geberit 65541",
    			"Geberit 90096",
    			"Geberit 90343",
    			"Geberit 91073",
    			"Geberit 94922",
    			"Geberit MAPRESS 33739",
    			"Klinger Gebetsroither 2434013",
    			"Klinger Gebetsroither IB 29434 C4400",
    			"Klinger Gebetsroither KLINGER",
    			"Klinger Gebetsroither KLINGER",
    			"Klinger Gebetsroither 380108125",
    			"Klinger Gebetsroither 23RW120",
    			"Grohe 23218000",
    			"Grohe 27319000",
    			"Grohe 31318000",
    			"Grohe 31319000",
    			"Grohe 32284000",
    			"Grohe 32286000",
    			"Grohe 32287000",
    			"Grohe 32288000",
    			"Grohe 33935000",
    			"Grohe 34232000",
    			"Grohe 19479000",
    			"Grohe 19507001",
    			"Grohe 19576001",
    			"Grohe 20205000",
    			"Grohe 2338220E",
    			"Grohe 23425000",
    			"Grohe 23430000",
    			"Grohe 23431000",
    			"Grohe 27184000",
    			"Grohe 27345000",
    			"Grohe 27628000",
    			"Grohe 27663000",
    			"Grohe 27667000",
    			"Grohe 27669000",
    			"Grohe 27672000",
    			"Grohe 27674000",
    			"Grohe 27731000",
    			"Grohe 27733000",
    			"Grohe 27735000",
    			"Grohe 27737000",
    			"Grohe 27801000",
    			"Grohe 28034LS0",
    			"Grohe 28346000",
    			"Grohe 28763000",
    			"Grohe 28794000",
    			"Grohe 28944001",
    			"Grohe 30079000",
    			"Grohe 30156000",
    			"Grohe 32107000",
    			"Grohe 32240001",
    			"Grohe 32732000",
    			"Grohe 32871000",
    			"Grohe 33265001",
    			"Grohe 33300001",
    			"Grohe 33312001",
    			"Grohe 33390001",
    			"Grohe 33565001",
    			"Grohe 33590001",
    			"Grohe 33977001",
    			"Grohe 34019000",
    			"Grohe 34023000",
    			"Grohe 34205000",
    			"Grohe 34254000",
    			"Grohe 36264000",
    			"Grohe 36273000",
    			"Grohe 37037000",
    			"Grohe 38643000",
    			"Grohe 38672SD0",
    			"Grohe 38844SH0",
    			"Grohe 38858SH0",
    			"Grohe 45354000",
    			"Grohe 46078000",
    			"Grohe 47658000",
    			"Grohe 0315400M",
    			"Grohe 33281000",
    			"Grohe GROHE",
    			"Grohe 33532",
    			"Grohe GROHE",
    			"Grohe 36412000",
    			"Grohe GROHE",
    			"Grohe 45995",
    			"Grohe 45784",
    			"Grohe 28918",
    			"Grohe 45291 IG",
    			"Grohe 46 346 000",
    			"Grohe PLATINUM II 15080",
    			"Grohe 33155001",
    			"Grohe 28151AG0",
    			"Grohe 31317000",
    			"Grohe 27786001",
    			"Grohe 19549LS2",
    			"Grohe 32482002",
    			"Grohe 31395000",
    			"Grohe 23262000",
    			"Grohe 23591001",
    			"Grohe G36325001",
    			"Grötz & CO GesmbH HPLHSP80",
    			"Grötz & CO GesmbH HPLHSP150",
    			"Fischer Georg 161017082",
    			"Fischer Georg 161017085",
    			"Fischer Georg 161017106",
    			"Fischer Georg 161050032",
    			"Fischer Georg 161561007",
    			"Fischer Georg 167546408",
    			"Fischer Georg 167546417",
    			"Fischer Georg 167546449",
    			"Fischer Georg 167546809",
    			"Fischer Georg 167561088",
    			"Fischer Georg 167567007",
    			"Fischer Georg 193133067",
    			"Fischer Georg 700647671",
    			"Fischer Georg 700649935",
    			"Fischer Georg 720910707",
    			"Fischer Georg 721250105",
    			"Fischer Georg 721250114",
    			"Fischer Georg 721500106",
    			"Fischer Georg 721530713",
    			"Fischer Georg 721550511",
    			"Fischer Georg 721740107",
    			"Fischer Georg 721900912",
    			"Fischer Georg 721911909",
    			"Fischer Georg 727158514",
    			"Fischer Georg 727798787",
    			"Fischer Georg 727968933",
    			"Fischer Georg 738001114",
    			"Fischer Georg 753154214",
    			"Fischer Georg 753911817",
    			"Fischer Georg 753911820",
    			"Fischer Georg 762101001",
    			"Fischer Georg 762101028",
    			"Fischer Georg 762101095",
    			"Fischer Georg 762101065",
    			"Fischer Georg 753908685",
    			"Fischer Georg 3400940",
    			"Fischer Georg 8325640",
    			"Fischer Georg 709355616",
    			"Fischer Georg 709355620",
    			"Fischer Georg 198350006",
    			"Grundfos 98888317",
    			"Grundfos 98888319",
    			"Grundfos 96010981",
    			"Grundfos 96516725",
    			"Grundfos 96498728",
    			"Grundfos 691",
    			"Grundfos 96236335",
    			"Grundfos 97778321",
    			"Grundfos 97778322",
    			"Grundfos 00ID7803",
    			"Grundfos 00ID7942",
    			"Grundfos 003W5049",
    			"Grundfos 96160876",
    			"Grundfos 96040636",
    			"Grundfos GRUNDFOS",
    			"Grundfos GRUNDFOS",
    			"Grundfos 96405955",
    			"Grundfos GRUNDFOS",
    			"Grundfos 98699058",
    			"Grundfos 957115",
    			"Grundfos 96405915",
    			"Grundfos 07101K13",
    			"Grundfos GRUNDFOS",
    			"Grundfos GRUNDFOS",
    			"Grundfos GRUNDFOS",
    			"Grundfos 95047507",
    			"Grundfos 012H1300",
    			"Grundfos 97924454",
    			"Grundfos 97924469",
    			"Grundfos 97924505",
    			"Goetze KG 618T20",
    			"Goetze KG 618T25",
    			"Goetze KG 352BHL40FL/FL40/65",
    			"Gradl Bruno Peter 50RS",
    			"Gradl Bruno Peter 50MD",
    			"Gradl Bruno Peter 50AM",
    			"Gradl Bruno Peter 000CFSBED",
    			"Gradl Bruno Peter 000MFILT004",
    			"Gradl Bruno Peter 100ULAE",
    			"Gradl Bruno Peter 150STMIX",
    			"Gradl Bruno Peter 150STVIX",
    			"Gradl Bruno Peter 150QAZ903WIX100",
    			"Gradl Bruno Peter 100QWI90B3WIX",
    			"Gradl Bruno Peter 150QWI90B3WIX",
    			"Gradl Bruno Peter 151QWI90B3WIX",
    			"Gradl Bruno Peter 150QWI90S3WIX",
    			"Gradl Bruno Peter 000CFDBED",
    			"Gorenje Austria W6222",
    			"Hansgrohe 14040000",
    			"Hansgrohe 14240000",
    			"Hansgrohe 14244000",
    			"Hansgrohe 14245000",
    			"Hansgrohe 14246000",
    			"Hansgrohe 14260000",
    			"Hansgrohe 14440000",
    			"Hansgrohe 14450000",
    			"Hansgrohe 14640000",
    			"Hansgrohe 27156000",
    			"Hansgrohe 27324002",
    			"Hansgrohe 31728000",
    			"Hansgrohe 10750180",
    			"Hansgrohe 13145000",
    			"Hansgrohe 13235000",
    			"Hansgrohe 13245000",
    			"Hansgrohe 13596000",
    			"Hansgrohe 14210000",
    			"Hansgrohe 14270000",
    			"Hansgrohe 14465000",
    			"Hansgrohe 14470000",
    			"Hansgrohe 14475000",
    			"Hansgrohe 14615000",
    			"Hansgrohe 14670000",
    			"Hansgrohe 14675000",
    			"Hansgrohe 14837000",
    			"Hansgrohe 15720000",
    			"Hansgrohe 16502820",
    			"Hansgrohe 17700000",
    			"Hansgrohe 17920000",
    			"Hansgrohe 17965090",
    			"Hansgrohe 18440000",
    			"Hansgrohe 18655000",
    			"Hansgrohe 18770000",
    			"Hansgrohe 26443000",
    			"Hansgrohe 26464000",
    			"Hansgrohe 26528000",
    			"Hansgrohe 27053000",
    			"Hansgrohe 27054000",
    			"Hansgrohe 27055000",
    			"Hansgrohe 27076000",
    			"Hansgrohe 27122000",
    			"Hansgrohe 27142000",
    			"Hansgrohe 27143000",
    			"Hansgrohe 27160000",
    			"Hansgrohe 27166000",
    			"Hansgrohe 27373000",
    			"Hansgrohe 27423000",
    			"Hansgrohe 27572000",
    			"Hansgrohe 27573000",
    			"Hansgrohe 27611000",
    			"Hansgrohe 27751000",
    			"Hansgrohe 27843000",
    			"Hansgrohe 27875000",
    			"Hansgrohe 27880000",
    			"Hansgrohe 27881000",
    			"Hansgrohe 27888000",
    			"Hansgrohe 27895000",
    			"Hansgrohe 27898000",
    			"Hansgrohe 27941800",
    			"Hansgrohe 27989000",
    			"Hansgrohe 28100000",
    			"Hansgrohe 28272450",
    			"Hansgrohe 28442000",
    			"Hansgrohe 28470180",
    			"Hansgrohe 28502000",
    			"Hansgrohe 28505800",
    			"Hansgrohe 28507000",
    			"Hansgrohe 28518000",
    			"Hansgrohe 28519000",
    			"Hansgrohe 28539000",
    			"Hansgrohe 28545000",
    			"Hansgrohe 31070000",
    			"Hansgrohe 31072000",
    			"Hansgrohe 31270000",
    			"Hansgrohe 31446000",
    			"Hansgrohe 31451000",
    			"Hansgrohe 31456000",
    			"Hansgrohe 31470000",
    			"Hansgrohe 31475000",
    			"Hansgrohe 31616000",
    			"Hansgrohe 31622000",
    			"Hansgrohe 31670000",
    			"Hansgrohe 31675000",
    			"Hansgrohe 31701000",
    			"Hansgrohe 31742000",
    			"Hansgrohe 31743000",
    			"Hansgrohe 31744000",
    			"Hansgrohe 31760000",
    			"Hansgrohe 31762000",
    			"Hansgrohe 31952000",
    			"Hansgrohe 32035000",
    			"Hansgrohe 32052000",
    			"Hansgrohe 32080000",
    			"Hansgrohe 32220000",
    			"Hansgrohe 34455000",
    			"Hansgrohe 34635000",
    			"Hansgrohe 35113800",
    			"Hansgrohe 35512800",
    			"Hansgrohe 35884800",
    			"Hansgrohe 35970800",
    			"Hansgrohe 39156000",
    			"Hansgrohe 39411000",
    			"Hansgrohe 40506000",
    			"Hansgrohe 40877180",
    			"Hansgrohe 41337810",
    			"Hansgrohe 41419810",
    			"Hansgrohe 41430810",
    			"Hansgrohe 41435810",
    			"Hansgrohe 41456810",
    			"Hansgrohe 41501000",
    			"Hansgrohe 41508000",
    			"Hansgrohe 41556000",
    			"Hansgrohe 42065820",
    			"Hansgrohe 42066000",
    			"Hansgrohe 58127090",
    			"Hansgrohe 58146180",
    			"Hansgrohe 96072000",
    			"Hansgrohe 96318000",
    			"Hansgrohe 96441000",
    			"Hansgrohe 97336000",
    			"Hansgrohe 99993000. 28631",
    			"Hansgrohe HANSGROHE",
    			"Hansgrohe HANS GROHE 10418",
    			"Hansgrohe 86101774",
    			"Hansgrohe HANSGROHE",
    			"Hansgrohe HANSGROHE",
    			"Hansgrohe 13964",
    			"Hansgrohe 13952",
    			"Hansgrohe 28675",
    			"Hansgrohe 13270000",
    			"Hansgrohe 28306000",
    			"Hansgrohe 27306000",
    			"Hansgrohe 27315000",
    			"Hansgrohe ART:357262",
    			"Hansgrohe 60065180",
    			"Hansgrohe 60066000",
    			"Hansgrohe 45723",
    			"Hansgrohe 34445000",
    			"Hansgrohe 39442000",
    			"Hansgrohe 94121000",
    			"Hansgrohe 27552002",
    			"Hansgrohe 27556002",
    			"Hansgrohe 28486180",
    			"Hansgrohe 28164002",
    			"Hansgrohe 27182002",
    			"Hansgrohe 27274002",
    			"Hansgrohe 27306002",
    			"Hansgrohe 27584002",
    			"Hansgrohe 27586002",
    			"Hansgrohe 28132002",
    			"Hansgrohe 27841820",
    			"Hansgrohe 42401000",
    			"Hansgrohe 14041000",
    			"Hansgrohe 15345000",
    			"Hansgrohe 31706000",
    			"Hansgrohe 14080800",
    			"Hansgrohe 27206000",
    			"Hansgrohe 27207000",
    			"Hansgrohe 14150000",
    			"Hansgrohe 14816000",
    			"Hansgrohe 31121000",
    			"Hansgrohe 26540402",
    			"Hansgrohe 27335402",
    			"Hansgrohe 95645000",
    			"Hansgrohe 95686000",
    			"Hansgrohe 39436000",
    			"Hansgrohe 27328002",
    			"Hansgrohe 26657400",
    			"Hansgrohe 71171000",
    			"Hansgrohe 36705000",
    			"Hansgrohe HG97581",
    			"Hansgrohe 26486 000",
    			"Gebo 01.150.04.05",
    			"Gebo 01.180.02.01",
    			"Gebo 01.161.48.08",
    			"Gebo 01.220.02.09",
    			"Gebo 01.220.04.09",
    			"Gebo 04.620.60.28",
    			"Gebo 04.620.60.35",
    			"Gebo 04.620.60.42",
    			"Gebo 04.620.60.54",
    			"Gebo 51.01.055058.06",
    			"Gebo 51.01.069073.06",
    			"Gebo 51.01.074080.06",
    			"Gebo 01.220.01.09",
    			"Gebo 01.252.28.09",
    			"Gebo 02.150.00.0120",
    			"Gebo 02.150.01.0120",
    			"Gebo 02.150.01.0225",
    			"Gebo 02.150.01.03318",
    			"Gebo 01.150.04.00",
    			"Gebo 01.220.04.08",
    			"Gebo 04.620.60.10",
    			"Gebo 04.620.60.12",
    			"Gebo 04.620.60.14",
    			"Gebo 04.620.60.16",
    			"Gebo 04.620.60.64",
    			"Gebo 04.620.60.70",
    			"Gebo 01.180.00.01",
    			"Gebo 01.180.00.02",
    			"Gebo 01.180.01.01",
    			"Gebo 01.180.01.02",
    			"Gebo 01.180.01.03",
    			"Gebo 01.180.01.04",
    			"Gebo 01.180.01.05",
    			"Gebo 01.180.01.06",
    			"Gebo 29620011",
    			"Gebo 230421",
    			"Gebo 02.220.00.108",
    			"Gebo 02.220.01.108",
    			"Gebo 01.220.00.09",
    			"Gebo 02.220.01.07825",
    			"Gebo 01.220.00.09",
    			"GMS Bautechnik S12500",
    			"GMS Bautechnik AL1080",
    			"GMS Bautechnik M00010",
    			"Glas Kiedl 1200X800X6MM LT. 66",
    			"Glas Kiedl 500X400X6MM VSG KANTEN",
    			"Glas Kiedl 600X400X6MM VSG KANTEN",
    			"Glas Kiedl VSG",
    			"Glas Kiedl SP6045",
    			"Glas Kiedl MG6060P",
    			"Hawle E. Armaturenwerke 5007926",
    			"Hawle E. Armaturenwerke 5008694",
    			"Hawle E. Armaturenwerke 5001828",
    			"Hawle E. Armaturenwerke 5005433",
    			"Hawle E. Armaturenwerke 5005437",
    			"Hawle E. Armaturenwerke 5005452",
    			"Hawle E. Armaturenwerke 5005348",
    			"Hawle E. Armaturenwerke 5005351",
    			"Hawle E. Armaturenwerke 5005356",
    			"Hawle E. Armaturenwerke 5005829",
    			"Hawle E. Armaturenwerke 5005570",
    			"Hawle E. Armaturenwerke 5005573",
    			"Hawle E. Armaturenwerke 5005564",
    			"Hawle E. Armaturenwerke 5005980",
    			"Hawle E. Armaturenwerke 5005983",
    			"Hawle E. Armaturenwerke 5005985",
    			"Hawle E. Armaturenwerke 5005905",
    			"Hawle E. Armaturenwerke 5006048",
    			"Hawle E. Armaturenwerke 5005918",
    			"Hawle E. Armaturenwerke 5005966",
    			"Hawle E. Armaturenwerke 5005976",
    			"Hawle E. Armaturenwerke 5006143",
    			"Hawle E. Armaturenwerke 5005271",
    			"Hawle E. Armaturenwerke 5005279",
    			"Hawle E. Armaturenwerke 5008517",
    			"Hawle E. Armaturenwerke 5013138",
    			"Hawle E. Armaturenwerke 5013109",
    			"Hawle E. Armaturenwerke HEKR02491500",
    			"Hawle E. Armaturenwerke 5014016",
    			"Hawle E. Armaturenwerke HELR00371500",
    			"Hawle E. Armaturenwerke AB000027",
    			"Hawle E. Armaturenwerke 5004843",
    			"Hawle E. Armaturenwerke HAWLE GA000039000011",
    			"Hawle E. Armaturenwerke 5004960",
    			"Hawle E. Armaturenwerke 5004964",
    			"Hawle E. Armaturenwerke 5004856",
    			"Hawle E. Armaturenwerke EL100056",
    			"Herz 1303100",
    			"Herz 1346602",
    			"Herz S372614",
    			"Herz 3F79906",
    			"Herz 1400121",
    			"Herz 1400264",
    			"Herz 1400713",
    			"Herz 1400714",
    			"Herz 1400716",
    			"Herz 2401118",
    			"Herz 1401711",
    			"Herz 1401721",
    			"Herz 1411102",
    			"Herz 1411103",
    			"Herz 1411313",
    			"Herz 1411507",
    			"Herz 1411517",
    			"Herz 1411518",
    			"Herz 1411758",
    			"Herz 1411765",
    			"Herz 1412568",
    			"Herz 1412574",
    			"Herz 2412606",
    			"Herz 1421506",
    			"Herz 1421511",
    			"Herz 2421501",
    			"Herz 2421502",
    			"Herz 2421512",
    			"Herz 2421534",
    			"Herz 1421848",
    			"Herz 1421850",
    			"Herz 2431514",
    			"Herz 1552411",
    			"Herz 1609818",
    			"Herz 1620602",
    			"Herz 1624053",
    			"Herz 1627401",
    			"Herz 1627402",
    			"Herz 1638715",
    			"Herz 1639009",
    			"Herz 1640302",
    			"Herz 1668000",
    			"Herz 1682481",
    			"Herz 1682482",
    			"Herz 1720100",
    			"Herz 1720200",
    			"Herz 1743018",
    			"Herz 1752467",
    			"Herz 1755203",
    			"Herz 1770823",
    			"Herz 1772466",
    			"Herz 1772469",
    			"Herz 1772865",
    			"Herz 1774291",
    			"Herz 1776017",
    			"Herz 1776362",
    			"Herz 1776380",
    			"Herz 1776531",
    			"Herz 1776851",
    			"Herz 1778391",
    			"Herz 1779123",
    			"Herz 1779300",
    			"Herz 1779301",
    			"Herz 1779324",
    			"Herz 1779604",
    			"Herz S792414",
    			"Herz 1795944",
    			"Herz 1844502",
    			"Herz 1923941",
    			"Herz 1986140",
    			"Herz HERZ",
    			"Herz HERZ",
    			"Herz HERZ",
    			"Herz HERZ",
    			"Herz HERZ",
    			"Herz HERZ",
    			"Herz HERZ",
    			"Herz 4217.19",
    			"Herz 1770840",
    			"Herz 3C20030KL",
    			"Herz 2638752",
    			"Herz 2 2100 12",
    			"Herz 18251 03",
    			"Herz HERZ 16388.04",
    			"Herz 1825101",
    			"Herz 1825103",
    			"Herz 2421782",
    			"Herz 1319283*",
    			"Herz 1319284*",
    			"Herz 1319285*",
    			"Herz 1411723",
    			"Herz 1619812",
    			"Herz 1742016",
    			"Herz 2412662",
    			"Herz 1515101",
    			"Herz 1768821",
    			"Herz 2028420",
    			"Herz 2652001",
    			"Herz V762312",
    			"Herz V762412",
    			"Herz 1220621",
    			"Herz 1220622",
    			"Herz 1220623",
    			"Herz 1220625",
    			"Herz T201053",
    			"Herz T201074",
    			"Herz T201075",
    			"Herz T201088",
    			"Herz T201090",
    			"Herz 2027700",
    			"Herz 2027709",
    			"Herz 1 7728 11",
    			"Herz S379144",
    			"Herz S923914",
    			"HL Hutterer & Lechner 01028D",
    			"HL Hutterer & Lechner 050.1E",
    			"HL Hutterer & Lechner 0531.0E",
    			"HL Hutterer & Lechner 50WF.0/70",
    			"HL Hutterer & Lechner 523N-150X130",
    			"HL Hutterer & Lechner 136",
    			"HL Hutterer & Lechner 100B/40",
    			"HL Hutterer & Lechner SB126/40",
    			"Hoertnagl & Soehne 4109",
    			"Hoertnagl & Soehne 7020064",
    			"Hoertnagl & Soehne 7080156",
    			"Hoertnagl & Soehne 16590002",
    			"Hoertnagl & Soehne 16600004",
    			"Hoertnagl & Soehne 16600006",
    			"Hoertnagl & Soehne 16620007",
    			"HIG Handel m. Industriegütern BCG SPEZIAL",
    			"HIG Handel m. Industriegütern .",
    			"Hamberger Sanitary HFJ4",
    			"Hamberger Sanitary HFD5",
    			"Hamberger Sanitary HF94PUREW",
    			"Hamberger Sanitary HF94PURES",
    			"Hamberger Sanitary N2C703C3202W",
    			"Hamberger Sanitary 532544",
    			"Hamberger Sanitary 532547",
    			"Hamberger Sanitary 532546",
    			"Hamberger Sanitary 532550",
    			"Hamberger Sanitary 532548",
    			"Hamberger Sanitary 404146",
    			"Hummel 2890843401",
    			"Hummel 2864121201",
    			"Austroflex Rohr-Isoliersysteme 125EWR020-50",
    			"Austroflex Rohr-Isoliersysteme 125EWR025-50",
    			"Austroflex Rohr-Isoliersysteme 108DSM001",
    			"Austroflex Rohr-Isoliersysteme 0043PRV010048",
    			"Austroflex Rohr-Isoliersysteme 0043PRV010060",
    			"Austroflex Rohr-Isoliersysteme 0043PRV010042",
    			"Austroflex Rohr-Isoliersysteme 0043PRV010018",
    			"Austroflex Rohr-Isoliersysteme 030VLA418010",
    			"Austroflex Rohr-Isoliersysteme 050STAB20015",
    			"Austroflex Rohr-Isoliersysteme 050STAB20048",
    			"Honeywell-Austria AF20",
    			"Honeywell-Austria ATP924G1002",
    			"Honeywell-Austria DR20GMLA",
    			"Honeywell-Austria S245B-34ZA5.0",
    			"Honeywell-Austria SG160S-1AB",
    			"Honeywell-Austria T700120",
    			"Honeywell-Austria BRAUKMANN-SCHWIMMER",
    			"Honeywell-Austria X6630D1007",
    			"Honeywell-Austria CENTRA",
    			"Honeywell-Austria SDC3-40WC",
    			"Honeywell-Austria SDW20",
    			"Honeywell-Austria 45900445-013B",
    			"Honeywell-Austria VTL320DA15",
    			"Honeywell-Austria VTL320EA15",
    			"Honeywell-Austria V4250A008",
    			"Honeywell-Austria BV10S-A",
    			"Honeywell-Austria R295-1C",
    			"Honeywell-Austria 900476",
    			"Honeywell-Austria ZPFL1",
    			"Otto Haas KG 74391",
    			"Otto Haas KG 72728",
    			"Otto Haas KG 7380",
    			"Otto Haas KG 3909",
    			"Otto Haas KG 7805",
    			"Otto Haas KG 5252",
    			"Hansa 1102283",
    			"Hansa 1152273",
    			"Hansa 1152283",
    			"Hansa 2950100",
    			"Hansa 4110200",
    			"Hansa 762010096",
    			"Hansa 2300100",
    			"Hansa 41109041",
    			"Hansa 43670100",
    			"Hansa 44050000",
    			"Hansa 442010092",
    			"Hansa 44420100",
    			"Hansa 44610100",
    			"Hansa 44630100",
    			"Hansa 44670110",
    			"Hansa 44680110",
    			"Hansa 44680120",
    			"Hansa 44780110",
    			"Hansa 44780130",
    			"Hansa 44780220",
    			"Hansa 44800000",
    			"Hansa 44810000",
    			"Hansa 45042203",
    			"Hansa 45112103",
    			"Hansa 45120103",
    			"Hansa 45869040",
    			"Hansa 47099042",
    			"Hansa 49092203",
    			"Hansa 51032173",
    			"Hansa 51152101",
    			"Hansa 51240900",
    			"Hansa 51270900",
    			"Hansa 51290900",
    			"Hansa 51320900",
    			"Hansa 51330900",
    			"Hansa 5180200",
    			"Hansa 51860173",
    			"Hansa 51950100",
    			"Hansa 52600103",
    			"Hansa 52610103",
    			"Hansa 52682203",
    			"Hansa 52682207",
    			"Hansa 54320900",
    			"Hansa 55530900",
    			"Hansa 55540900",
    			"Hansa 5589000592",
    			"Hansa 5617010078",
    			"Hansa 57629003",
    			"Hansa 57719173",
    			"Hansa 57799083",
    			"Hansa 58162101",
    			"Hansa 58442101",
    			"Hansa 59902724",
    			"Hansa 59904929",
    			"Hansa 5990589590",
    			"Hansa 59906763",
    			"Hansa 59910919",
    			"Hansa 59910941",
    			"Hansa 59911048",
    			"Hansa 59911290",
    			"Hansa 59911470",
    			"Hansa 59911754",
    			"Hansa 59911968",
    			"Hansa 59912282",
    			"Hansa 59912354",
    			"Hansa 59912610",
    			"Hansa 59912620",
    			"Hansa 59913078",
    			"Hansa 59913738",
    			"Hansa 59913749",
    			"Hansa 59913871",
    			"Hansa 64442220",
    			"Hansa 6724",
    			"Hansa 8040290",
    			"Hansa 80619073",
    			"Hansa 81109573",
    			"Hansa 81109583",
    			"Hansa 82619073",
    			"Hansa 82619077",
    			"Hansa 83869573",
    			"Hansa 83869583",
    			"Hansa 83879503",
    			"Hansa 83879513",
    			"Hansa 85279103",
    			"Hansa 87629003",
    			"Hansa 87729003",
    			"Hansa 87739003",
    			"Hansa 88609045",
    			"Hansa 9670101",
    			"Hansa HANSA",
    			"Hansa ORAS 8500F",
    			"Hansa ORAS 8500F",
    			"Hansa ORAS 8500F",
    			"Hansa 73112183",
    			"Hansa 73269183",
    			"Hansa 2000100",
    			"Hansa 2350100",
    			"Hansa 8080190",
    			"Hansa .",
    			"Hansa 44780213",
    			"Hansa 59914066",
    			"Hoesch Design .",
    			"Hewi Wilke Heinrich 100.09.10040",
    			"Hewi Wilke Heinrich 100.21.20040",
    			"Hewi Wilke Heinrich 100.30.10040",
    			"Hewi Wilke Heinrich 100.30.21040",
    			"Hewi Wilke Heinrich 100.33.11040",
    			"Hewi Wilke Heinrich 100.33.12040",
    			"Hewi Wilke Heinrich 100.36.10040",
    			"Hewi Wilke Heinrich 100.51.30041",
    			"Hewi Wilke Heinrich 100.90.01040",
    			"Hewi Wilke Heinrich 100.90.02040",
    			"Hewi Wilke Heinrich 162.00.10040",
    			"Hewi Wilke Heinrich 162.03.100540",
    			"Hewi Wilke Heinrich 162.09.10040",
    			"Hewi Wilke Heinrich 162.21.20040",
    			"Hewi Wilke Heinrich 162.30.10040",
    			"Hewi Wilke Heinrich 162.90.01040",
    			"Hewi Wilke Heinrich 477.02.100 99",
    			"Hewi Wilke Heinrich 477.02.200 95",
    			"Hewi Wilke Heinrich 477.02.200 99",
    			"Hewi Wilke Heinrich 477.05.20012 99",
    			"Hewi Wilke Heinrich 477.21.150 99",
    			"Hewi Wilke Heinrich 800.03.10041",
    			"Hewi Wilke Heinrich 800.03.20041",
    			"Hewi Wilke Heinrich 800.03.30041",
    			"Hewi Wilke Heinrich 800.06.01045",
    			"Hewi Wilke Heinrich 800.20.10045",
    			"Hewi Wilke Heinrich 800.21.10040",
    			"Hewi Wilke Heinrich 800.21.30040",
    			"Hewi Wilke Heinrich 800.30.12040",
    			"Hewi Wilke Heinrich 800.33.11040",
    			"Hewi Wilke Heinrich 800.33.12040",
    			"Hewi Wilke Heinrich 800.51.30041",
    			"Hewi Wilke Heinrich 800.90.01040",
    			"Hewi Wilke Heinrich 800.90.02040",
    			"Hewi Wilke Heinrich 801.22.130 33",
    			"Hewi Wilke Heinrich 801.36.160 50",
    			"Hewi Wilke Heinrich 801.50.300 13",
    			"Hewi Wilke Heinrich 801.51.920R 33",
    			"Hewi Wilke Heinrich 801.52.10001 99",
    			"Hewi Wilke Heinrich 801.52.10030 30",
    			"Hewi Wilke Heinrich 801.90.010 13",
    			"Hewi Wilke Heinrich 802.34.V0323",
    			"Hewi Wilke Heinrich 805.06.500 99",
    			"Hewi Wilke Heinrich 805.50.210",
    			"Hewi Wilke Heinrich 950.11.100",
    			"Hewi Wilke Heinrich 950.11.500",
    			"Hewi Wilke Heinrich 950.50.10040 98",
    			"Hewi Wilke Heinrich 950.50.61140",
    			"Hewi Wilke Heinrich BM11.3",
    			"Hewi Wilke Heinrich 802.50.08097",
    			"Hewi Wilke Heinrich 8012140999",
    			"Hewi Wilke Heinrich 801.34.4S 98",
    			"Hewi Wilke Heinrich 950.50.01190 90",
    			"Hewi Wilke Heinrich 801.22.1S 99",
    			"Hewi Wilke Heinrich 801.52.100 20",
    			"Hewi Wilke Heinrich 162.06.11040",
    			"Hewi Wilke Heinrich 6180 16",
    			"Hewi Wilke Heinrich 802.50.0190 16",
    			"Hewi Wilke Heinrich 477.03.500 73",
    			"Hueppe HÜPPE",
    			"Hueppe HÜPPE",
    			"Ideal-Standard A2327AA",
    			"Ideal-Standard A2339AA",
    			"Ideal-Standard A2363NU",
    			"Ideal-Standard A2682AA",
    			"Ideal-Standard A3201AA",
    			"Ideal-Standard A5018AA",
    			"Ideal-Standard A5801AA",
    			"Ideal-Standard A6115AA",
    			"Ideal-Standard A962681NU",
    			"Ideal-Standard B0406AA",
    			"Ideal-Standard B0412AA",
    			"Ideal-Standard B0703AA",
    			"Ideal-Standard B1382AA",
    			"Ideal-Standard B3696AA",
    			"Ideal-Standard B3748AA",
    			"Ideal-Standard B5184AA",
    			"Ideal-Standard B8057AA",
    			"Ideal-Standard B8066AA",
    			"Ideal-Standard B8069AA",
    			"Ideal-Standard B8079AA",
    			"Ideal-Standard B8084AA",
    			"Ideal-Standard B9506AA",
    			"Ideal-Standard B960863NU",
    			"Ideal-Standard B9919AA",
    			"Ideal-Standard B9920AA",
    			"Ideal-Standard B9933AA",
    			"Ideal-Standard B9936AA",
    			"Ideal-Standard B8900AA",
    			"Ideal-Standard B8906AA",
    			"Ideal-Standard B8904AA",
    			"Ideal-Standard B8903AA",
    			"Ideal-Standard B8912AA",
    			"Ideal-Standard B8910AA",
    			"Ideal-Standard B8902AA",
    			"Ideal-Standard J3225",
    			"Ideal-Standard B960676AA",
    			"Ideal-Standard A963414AA",
    			"Ideal-Standard A963417AA",
    			"Ideal-Standard A5159AA",
    			"Ideal-Standard K727567",
    			"Ideal-Standard K504801",
    			"Ideal-Standard B5188AA",
    			"Ideal-Standard A3661AA",
    			"Ideal-Standard A962991AA",
    			"Ideal-Standard B7199AA",
    			"Ideal-Standard B6935AA",
    			"Ideal-Standard A3641NU",
    			"Ideal-Standard N1147AA",
    			"Ideal-Standard K653801",
    			"Ideal-Standard K654601",
    			"Ideal-Standard K652001",
    			"Ideal-Standard K651201",
    			"Ideal-Standard K655401",
    			"Ideal-Standard K654701",
    			"Ideal-Standard H2363A9",
    			"Ideal-Standard H2379AA",
    			"Ideal-Standard K2215EG",
    			"Ideal-Standard B8193AA",
    			"Ideal-Standard K511801",
    			"Ideal-Standard B4664AA",
    			"Ideal-Standard A3689AA",
    			"Ideal-Standard B8204AA",
    			"Ideal-Standard B8208AA",
    			"Ideal-Standard B8207AA",
    			"Ideal-Standard K676501",
    			"Ideal-Standard B7209AA",
    			"Ideal-Standard B960178AA",
    			"Ideal-Standard A860355NU",
    			"Ideal-Standard A960718AA",
    			"Ideal-Standard A960719AA",
    			"Ideal-Standard B4276AA",
    			"Ideal-Standard B8042AA",
    			"Ideal-Standard K710867",
    			"Ideal-Standard K728467",
    			"Ideal-Standard H2133H3",
    			"Ideal-Standard K653901*",
    			"Ideal-Standard B9001AA",
    			"Ideal-Standard B9003AA",
    			"Ideal-Standard B9006AA",
    			"Ideal-Standard B9006AA",
    			"Ideal-Standard B9007AA",
    			"Ideal-Standard B9008AA",
    			"Ideal-Standard B9009AA",
    			"Ideal-Standard E811301",
    			"Ideal-Standard A4959AA",
    			"Ideal-Standard B9255AA",
    			"Ideal-Standard B9245AA",
    			"Ideal-Standard B9246AA",
    			"Ideal-Standard B9247AA",
    			"Ideal-Standard A964523NU",
    			"Ideal-Standard J3291AA",
    			"Ideal-Standard K193701",
    			"Ideal-Standard K5188YK",
    			"Ideal-Standard N1381AA",
    			"Ideal-Standard T962701",
    			"Ideal-Standard T962901",
    			"Ideal-Standard T963601",
    			"Ideal-Standard T963701",
    			"Ideal-Standard A9181AA",
    			"Ideal-Standard E812701",
    			"Ideal-Standard A5949AA",
    			"Ideal-Standard A5950AA",
    			"Ideal-Standard A5954AA",
    			"Ideal-Standard B0191AA",
    			"Ideal-Standard B0193AA",
    			"Ideal-Standard B0197AA",
    			"Ideal-Standard B0203AA",
    			"Ideal-Standard E504101",
    			"Ideal-Standard A6449AA",
    			"Ideal-Standard B0687AA",
    			"Ideal-Standard E548201",
    			"Ideal-Standard E567101",
    			"Ideal-Standard J2431MA",
    			"Ideal-Standard A2367NU",
    			"Ideal-Standard K312201",
    			"Ideal-Standard K624501",
    			"Ideal-Standard K936067",
    			"Ideal-Standard A6339AA",
    			"Ideal-Standard K 7257 67",
    			"Ideal-Standard A9161AA",
    			"Ideal-Standard R340301",
    			"Ideal-Standard T055901",
    			"Ideal-Standard T7800WG",
    			"Ideal-Standard V340401",
    			"IMT 10808",
    			"IMT 54205 DN 25",
    			"poresta systems Gmb 17039866",
    			"poresta systems Gmb 17012944",
    			"poresta systems Gmb 17053900",
    			"poresta systems Gmb 17156090",
    			"poresta systems Gmb PORESTA",
    			"poresta systems Gmb PORESTA",
    			"poresta systems Gmb PORESTA",
    			"poresta systems Gmb 17038301",
    			"poresta systems Gmb PORESTA",
    			"poresta systems Gmb PORESTA",
    			"poresta systems Gmb 18800025",
    			"poresta systems Gmb 17012556",
    			"poresta systems Gmb 17012559",
    			"poresta systems Gmb 17012568",
    			"poresta systems Gmb 17044801",
    			"poresta systems Gmb 17013336",
    			"poresta systems Gmb 17013338",
    			"poresta systems Gmb 17029405",
    			"poresta systems Gmb 17704107",
    			"poresta systems Gmb 17704249",
    			"poresta systems Gmb 18200077",
    			"poresta systems Gmb 18200062",
    			"Jako 5001310000",
    			"Jako 1210017000",
    			"Jako 1171135000",
    			"Jako 4300106000",
    			"Jako FIG42",
    			"Jako 1171017000",
    			"Jako 1821116010",
    			"Jako 2395833580",
    			"Jako 8612200150",
    			"Jako 8614200150",
    			"Joerger Armaturen-u.Acce- 109.13.350.020",
    			"Joerger Armaturen-u.Acce- 64940160",
    			"Joerger Armaturen-u.Acce- 64920212000",
    			"Joerger Armaturen-u.Acce- 627.10.334.000",
    			"Joerger Armaturen-u.Acce- 64940355",
    			"Joerger Armaturen-u.Acce- 64940140/40150+40160+4",
    			"Joerger Armaturen-u.Acce- 634.10.333 040",
    			"Jacuzzi Europe F068",
    			"Jacuzzi Europe M025",
    			"Judo Wasseraufbereitung 8010034",
    			"Ke Kelit 82100DB0",
    			"Ke Kelit 82110BBB",
    			"Ke Kelit 82110DBD",
    			"Ke Kelit 82110EBE",
    			"Ke Kelit KELOX-WINDOX",
    			"Ke Kelit 54630LGL",
    			"Ke Kelit 56019D00",
    			"Ke Kelit 56103FF0",
    			"Ke Kelit 9004400*",
    			"Ke Kelit 56079",
    			"Ke Kelit 3000002N",
    			"Ke Kelit 9845270",
    			"Ke Kelit 1511000",
    			"Ke Kelit 2590000",
    			"Ke Kelit 2730170",
    			"Ke Kelit 2505500",
    			"Ke Kelit 2575000",
    			"Ke Kelit 2655000",
    			"Ke Kelit 2654500",
    			"Ke Kelit 2754500",
    			"Ke Kelit 2554500",
    			"Ke Kelit 2514500",
    			"Ke Kelit 2515000",
    			"Ke Kelit 2542500",
    			"Ke Kelit 6351300",
    			"Ke Kelit 2535601",
    			"Ke Kelit 9141400",
    			"Ke Kelit 9331230",
    			"Ke Kelit 9331320",
    			"Ke Kelit 9351450",
    			"Ke Kelit 9361560",
    			"Ke Kelit 9361550",
    			"Ke Kelit 9323220",
    			"Ke Kelit 9353250",
    			"Ke Kelit 9042300",
    			"Ke Kelit 9052300",
    			"Ke Kelit 9042400",
    			"Ke Kelit 9072500",
    			"Ke Kelit 9555400",
    			"Ke Kelit 9053300",
    			"Ke Kelit 9152300",
    			"Ke Kelit 9009100",
    			"Ke Kelit 9009150",
    			"Ke Kelit 6103670",
    			"Ke Kelit 6404220",
    			"Ke Kelit 73155DD2",
    			"Ke Kelit 71100CC0",
    			"Ke Kelit 71100CB0",
    			"Ke Kelit 71153BB2",
    			"Ke Kelit 71254B2B",
    			"Ke Kelit 71253B02",
    			"Ke Kelit 71261B02",
    			"Ke Kelit 71262B02",
    			"Ke Kelit 7012030",
    			"Ke Kelit 72100EE0",
    			"Ke Kelit 72110FEF",
    			"Ke Kelit 72110FEE",
    			"Ke Kelit 72110GFG",
    			"Ke Kelit 72240D04",
    			"Ke Kelit 72216D04",
    			"Ke Kelit 72250D04",
    			"Ke Kelit 72610IFI",
    			"Ke Kelit 72733HH0",
    			"Ke Kelit 72780000",
    			"Ke Kelit 72784",
    			"Ke Kelit 727850000",
    			"Ke Kelit 727880000",
    			"Ke Kelit 72790ED0",
    			"Ke Kelit 55001J00",
    			"Ke Kelit 55002P00",
    			"Ke Kelit 55008I00",
    			"Ke Kelit 55100LL0",
    			"Ke Kelit 55503PP0",
    			"Ke Kelit 55218F05",
    			"Ke Kelit 55114LJL",
    			"Ke Kelit 55510PKP",
    			"Ke Kelit 55118FEE",
    			"Ke Kelit 55118FFE",
    			"Ke Kelit 55116LI0",
    			"Ke Kelit 55116LJ0",
    			"Ke Kelit 55116LK0",
    			"Ke Kelit 5520200",
    			"Ke Kelit 7604160",
    			"Kellner & Kunz 183430000500",
    			"Kellner & Kunz 1831440000500",
    			"Kellner & Kunz 1831450000500",
    			"Kellner & Kunz 18315100000200",
    			"Kellner & Kunz 1831540000200",
    			"Kellner & Kunz 1831550000200",
    			"Kellner & Kunz 1831570000200",
    			"Kellner & Kunz 98255711010025",
    			"Kellner & Kunz 982557165025",
    			"Kellner & Kunz 982557167025",
    			"Kellner & Kunz 009520120/32220",
    			"Kellner & Kunz 32216000200",
    			"Kellner & Kunz 146430000200",
    			"Kellner & Kunz 146440000200",
    			"Kellner & Kunz 146450000200",
    			"Kellner & Kunz 9825975700050",
    			"Kellner & Kunz 9825975800050",
    			"Kellner & Kunz 146650000200",
    			"Kellner & Kunz 146660000100",
    			"Kellner & Kunz 9825976300050",
    			"Kellner & Kunz 146670000100",
    			"Kellner & Kunz 31710000500",
    			"Kellner & Kunz 31712000200",
    			"Kellner & Kunz 31716000200",
    			"Kellner & Kunz 781690",
    			"Kellner & Kunz 78205500025",
    			"Kellner & Kunz 1761430000500",
    			"Kellner & Kunz 1761440000500",
    			"Kellner & Kunz 1761450000500",
    			"Kellner & Kunz 1761460000250",
    			"Kellner & Kunz 1761470000250",
    			"Kellner & Kunz 17615100000100",
    			"Kellner & Kunz 1761550000250",
    			"Kellner & Kunz 1761560000250",
    			"Kellner & Kunz 1761570000200",
    			"Kellner & Kunz 999900000000310905",
    			"Kludi STMS12505",
    			"Kludi STMS15005",
    			"Kludi STMS17505",
    			"Kludi STMS20005",
    			"Kludi STMSK12505",
    			"Kludi STMSK15005",
    			"Kludi STMSK17505",
    			"Kludi STMSK20005",
    			"Kludi 81011005-00",
    			"Kludi 210620508-80",
    			"Kludi 20013.08",
    			"Kludi 6702305-70",
    			"Kludi EMK0005-123000100",
    			"Kludi EMK0005-125500100",
    			"Kludi EMK0005-126000160",
    			"Kludi 370330560",
    			"Kludi 92305945-00",
    			"Kludi 300200519",
    			"Kludi 7538119",
    			"Kludi 512180520",
    			"Kludi 6774091-00",
    			"Kludi 1042205-00",
    			"Kludi 120500100",
    			"Kludi 1584605-00",
    			"Kludi 2152000-00",
    			"Kludi 2162000-00",
    			"Kludi 2765205",
    			"Kludi 316560508",
    			"Kludi 321260575",
    			"Kludi 326550575",
    			"Kludi 337950562",
    			"Kludi 339049662",
    			"Kludi 35158",
    			"Kludi 384460575",
    			"Kludi 386190575",
    			"Kludi 386500576",
    			"Kludi 386600575",
    			"Kludi 389210581",
    			"Kludi 389700575",
    			"Kludi 399040562",
    			"Kludi 514410520",
    			"Kludi 5205005-00",
    			"Kludi 525150575",
    			"Kludi 526500575",
    			"Kludi 532980575",
    			"Kludi 541440575",
    			"Kludi 541440520",
    			"Kludi 544230538",
    			"Kludi 5450405",
    			"Kludi 548250520",
    			"Kludi 551430575",
    			"Kludi 558200505",
    			"Kludi 558250505",
    			"Kludi 5619105-40",
    			"Kludi 568599140",
    			"Kludi 5697105",
    			"Kludi 5697405",
    			"Kludi 56W0543",
    			"Kludi 5705605-00",
    			"Kludi 5714005-00",
    			"Kludi 5755105-00",
    			"Kludi 6115000-00",
    			"Kludi 6115100-00",
    			"Kludi 6212005-00",
    			"Kludi 6214105-00",
    			"Kludi 6220005-00",
    			"Kludi 6225005-00",
    			"Kludi 6235405-00",
    			"Kludi 6520005N-00",
    			"Kludi 6533105N-00",
    			"Kludi 6550005N-00",
    			"Kludi 6553105N-00",
    			"Kludi 6554105N-00",
    			"Kludi 6560005-00",
    			"Kludi 6709505-00",
    			"Kludi 6803005-00",
    			"Kludi 6809005-00",
    			"Kludi 6819005-00",
    			"Kludi 7095600-00",
    			"Kludi 7162005-00",
    			"Kludi 7400500-00",
    			"Kludi 7412900-00",
    			"Kludi 7435600-00",
    			"Kludi 7450305-00",
    			"Kludi 7470105-00",
    			"Kludi 7506305-00",
    			"Kludi 7532005-00",
    			"Kludi 7558605-00",
    			"Kludi 7559205-00",
    			"Kludi 7688205-00",
    			"Kludi 7688505-00",
    			"Kludi 7805705-00",
    			"Kludi 82048005-00",
    			"Kludi 88066",
    			"Kludi 88075",
    			"Kludi 88077",
    			"Kludi 92321500-00",
    			"Krammer Prod. 821",
    			"Krammer Prod. 851225",
    			"KSB 42085986",
    			"KSB 48868065",
    			"KSB 48868073",
    			"KSB 1009771",
    			"KSB 1056709",
    			"KSB 18072644",
    			"KSB 18060163",
    			"KSB 48909163",
    			"KSB 29134756",
    			"KSB 470 90 845",
    			"Geberit 121680000",
    			"Geberit 121900000",
    			"Geberit 122100000",
    			"Geberit 122175000",
    			"Geberit 122180000",
    			"Geberit 124280000",
    			"Geberit 128665000",
    			"Geberit 201011000",
    			"Geberit 201500000",
    			"Geberit 203245000",
    			"Geberit 208550000",
    			"Geberit 211500000",
    			"Geberit 212000000",
    			"Geberit 223055000",
    			"Geberit 233010000",
    			"Geberit 233040000",
    			"Geberit 273040000",
    			"Geberit 274036000",
    			"Geberit 290520000",
    			"Geberit 296500000",
    			"Geberit 326060000",
    			"Geberit 514150000",
    			"Geberit 521070000",
    			"Geberit 554005000",
    			"Geberit 572000000",
    			"Geberit 572050000",
    			"Geberit 576300000",
    			"Geberit 840000000",
    			"Geberit 840037000",
    			"Geberit 840053000",
    			"Geberit 840491000",
    			"Geberit 840961000",
    			"Geberit 840990000",
    			"Geberit 122175600",
    			"Geberit 203050600",
    			"Geberit 221555600",
    			"Geberit 272150600",
    			"Geberit 4050000",
    			"Geberit K521270",
    			"Geberit 841375",
    			"Geberit 869603",
    			"Geberit 510040",
    			"Geberit 521145000",
    			"Geberit 521202000",
    			"Geberit 252066000",
    			"Geberit 33010",
    			"Geberit 33011",
    			"Geberit 31255-000",
    			"Geberit 121620600",
    			"Geberit 653002000",
    			"Geberit 222257000",
    			"Geberit 657380000",
    			"Geberit 832015000",
    			"Geberit 121640000",
    			"Geberit 235170000",
    			"Geberit 516070000",
    			"Geberit 573348000",
    			"Geberit 652490000",
    			"Geberit Y816040000",
    			"Geberit 860245000",
    			"Geberit 234000000",
    			"Geberit 597204000",
    			"Geberit 860240000",
    			"Geberit 599081000",
    			"Geberit 276145000",
    			"Geberit 276350000",
    			"Geberit 862265000",
    			"Geberit 862040000",
    			"Geberit 862132000",
    			"Geberit Y862340000",
    			"Geberit 862360000",
    			"Geberit 657340",
    			"Keuco KEUCO-BLEIKRISTALGLAS",
    			"Keuco 14939171000",
    			"Keuco 1493901100",
    			"Keuco KEUCO",
    			"Keuco KEUCO",
    			"Keuco KEUCO",
    			"Keuco KEUCO-LEUCHTENGLAS",
    			"Keuco 2055009000",
    			"Keuco 16069010000",
    			"Keuco 43301010600",
    			"Keuco 43301010800",
    			"Keuco 43310019400",
    			"Keuco 43310019600",
    			"Keuco 43321010000",
    			"Keuco 43341010000",
    			"Keuco 43342010000",
    			"Keuco 43343010000",
    			"Keuco 43344010000",
    			"Keuco 43350019000",
    			"Keuco 43353019000",
    			"Keuco 43360010000",
    			"Keuco 43350009000",
    			"Keuco 43353009000",
    			"Keuco 43355009000",
    			"Keuco 43364009000",
    			"Keuco 10007010100",
    			"Keuco 1264004000",
    			"Keuco 32140310700",
    			"Keuco 51185010900",
    			"Keuco 1656008000",
    			"Keuco 601010800",
    			"Keuco 864004000",
    			"Keuco 1853009000",
    			"Keuco 2701010400",
    			"Keuco 2701010600",
    			"Keuco 2715010000",
    			"Keuco 4550019000",
    			"Keuco 4560010000",
    			"Keuco 4563010000",
    			"Keuco 4564019000",
    			"Keuco 4996010000",
    			"Keuco 7773002000",
    			"Keuco 10091010000",
    			"Keuco 11610009600",
    			"Keuco 12602171301",
    			"Keuco 13801171301",
    			"Keuco 14941010400",
    			"Keuco 14941170600",
    			"Keuco 16064009000",
    			"Keuco 1718010000",
    			"Keuco 1750019000",
    			"Keuco 1760010000",
    			"Keuco 1764010100",
    			"Keuco 18020170000",
    			"Keuco 1860010000",
    			"Keuco 1862010000",
    			"Keuco 1908710000",
    			"Keuco 24003171301",
    			"Keuco 24005171301",
    			"Keuco 30007010000",
    			"Keuco 30050019000",
    			"Keuco 30310212101",
    			"Keuco 30310219101",
    			"Keuco 30311212101",
    			"Keuco 30331212102",
    			"Keuco 31361110000",
    			"Keuco 31650010000",
    			"Keuco 32301010600",
    			"Keuco 34020140001",
    			"Keuco 34020519000",
    			"Keuco 34908011101",
    			"Keuco 34908011102",
    			"Keuco 3707010000",
    			"Keuco 40067013000",
    			"Keuco 50100000012",
    			"Keuco 51120010100",
    			"Keuco 53083010400",
    			"Keuco 54991010000",
    			"Keuco 56080010100",
    			"heizungsbedarf wrann e.U. 199-101-078",
    			"Kemper 1210157000015",
    			"Kemper Z2101 574 00 015",
    			"Kemper 620003200",
    			"Kemper 620004000",
    			"Kemper 4711003200",
    			"Klomfar Elfriede ALAPE--WT--AUFSATZBECK",
    			"Klomfar Elfriede 2004 000 000",
    			"Kaldewei Franz 499300010717",
    			"Kaldewei Franz 133400013579",
    			"Kaldewei Franz 687675730000",
    			"Kaldewei Franz 689720080999",
    			"Kaldewei Franz 687749000001",
    			"Kaldewei Franz 133300010001",
    			"Kaldewei Franz 447200010231",
    			"Kaldewei Franz 430248040001",
    			"Kaldewei Franz 430300010199",
    			"Burgbad BURG/KAMA",
    			"Burgbad BURG",
    			"Burgbad BURG",
    			"Burgbad BURG",
    			"Burgbad BURG",
    			"Burgbad BURG",
    			"Burgbad BURG",
    			"Burgbad BURG",
    			"Burgbad BURG",
    			"Burgbad BURG",
    			"Burgbad BURG",
    			"Burgbad BURG",
    			"Burgbad BURG",
    			"Burgbad BURG",
    			"Burgbad BURG",
    			"Burgbad 948846",
    			"Burgbad AP4680.K0090",
    			"Burgbad MS0350",
    			"Burgbad HS3537R-467-K0059-071",
    			"Burgbad WTU9500-467-K0059-071",
    			"Burgbad BURG",
    			"Burgbad SEDS121-C0001 MWAV121",
    			"Burgbad HSBC060-F0442-K0090-P9",
    			"Burgbad UH ...3025 L",
    			"Burgbad UH ...3055 R",
    			"Burgbad APAB160",
    			"Burgbad MWAA180.C0001",
    			"Burgbad SPFP140-L-K0060/F0971",
    			"Burgbad BURG",
    			"Burgbad PL 001 IN 4000 H1340X",
    			"Burgbad MWAO141",
    			"Burgbad PRISP08F0038",
    			"Burgbad PRIUT30F0038",
    			"Burgbad PRIUS30F0038",
    			"Burgbad PRIMWU60BLF0038",
    			"Burgbad PRIHM30F0170",
    			"Burgbad PRI0030F0170",
    			"Burgbad PRIUH30F0170",
    			"Burgbad PRISP08F0170",
    			"Burgbad PRIUT30F0170",
    			"Burgbad PRIUS30F0170",
    			"Burgbad PRIMWU60BLF0170",
    			"Burgbad BURGKAMA",
    			"Burgbad SEYX.122.F2010.K0439.G",
    			"Burgbad AP0450 T45",
    			"Burgbad TN300015072",
    			"Burgbad WBU6020F0038",
    			"Burgbad WUHS117F0038",
    			"Burgbad WUHS117F0170",
    			"Burgbad HSBF040LF0804",
    			"Burgbad SIAR105F0804",
    			"Burgbad UHBD040LF0804",
    			"Burgbad UHBD040RF0804",
    			"Burgbad SPAN070F0806",
    			"Burgbad SPAN105LF0804",
    			"Burgbad SPAN120F0804",
    			"Burgbad SPAN120F0806",
    			"Burgbad SPAN140F0806",
    			"Burgbad SPAN140F0809",
    			"Burgbad SECX070F0806",
    			"Burgbad SECX070F0809",
    			"Burgbad SECX120F0804",
    			"Burgbad SECX120F0809",
    			"Burgbad SECY140F0806",
    			"Burgbad SECY140F0809",
    			"Burgbad WUHR075F0804",
    			"Burgbad WUHR120F0804",
    			"Burgbad UHBD040LF1084",
    			"Burgbad SPAN120F1084",
    			"Burgbad SECX070F1083",
    			"Burgbad SECX100F0804",
    			"Burgbad SECX100F0806",
    			"Burgbad SECX100F0809",
    			"Burgbad SECX100F0805",
    			"Burgbad HSDE040LF0804",
    			"Burgbad HSDE040RF1084",
    			"Burgbad HSDE040RF0804",
    			"Burgbad SPAN100F0804",
    			"Burgbad HSDF035LF1345",
    			"Burgbad HSDF035LF1346",
    			"Burgbad HSDF035LF1347",
    			"Burgbad HSDF035RF1345",
    			"Burgbad HSDF035RF1346",
    			"Burgbad HSDF035RF1347",
    			"Burgbad UHBY035LF1345",
    			"Burgbad UHBY035LF1347",
    			"Burgbad UHBY035RF1345",
    			"Burgbad UHBY035RF1346",
    			"Burgbad UHBY035RF1347",
    			"Burgbad SPGO060F1346",
    			"Burgbad SPGO060F1347",
    			"Burgbad SPGO090F1345",
    			"Burgbad SPGO090F1346",
    			"Burgbad SPGO090F1347",
    			"Burgbad SPGO120F1345",
    			"Burgbad SPGO120F1346",
    			"Burgbad SPGO120F1347",
    			"Burgbad SEPS063F1345",
    			"Burgbad SEPS063F1346",
    			"Burgbad SEPS063F1347",
    			"Burgbad SEPS093F1345",
    			"Burgbad SEPS093F1347",
    			"Burgbad SEPS123F1346",
    			"Burgbad SEPS123F1347",
    			"Burgbad WUUN100F0804",
    			"Burgbad WUUN125F0804",
    			"Burgbad WUWA125F0804",
    			"Burgbad SEZP072F0804",
    			"Burgbad SEZP102F0804",
    			"Burgbad SEZP102F2035",
    			"Burgbad SEZP122F0804",
    			"Burgbad SEZP122F1084",
    			"Burgbad SEZP142F0804",
    			"Burgbad SEZQ065F2011",
    			"Burgbad SPFO060F2816",
    			"Burgbad SFHH43",
    			"Burgbad WVHZ055F2815",
    			"Burgbad ACA G150",
    			"Klepp & Co 28001.010.2",
    			"KUHFUSS DELABIE 1103200",
    			"KUHFUSS DELABIE 510580",
    			"KUHFUSS DELABIE 2912",
    			"KUHFUSS DELABIE 234006A",
    			"KUHFUSS DELABIE 510567",
    			"KUHFUSS DELABIE 4043S",
    			"Kampmann 196000030059",
    			"Kampmann 34223111111300",
    			"Kermi CATWD090182PK",
    			"Kermi CASTD080182RK",
    			"Kermi CASTD080182PK",
    			"Kermi CASTD08018VRK",
    			"Kermi CATWD090182RK",
    			"Kermi CAKTD09018VPK",
    			"Kermi CAKTD080182PK",
    			"Kermi CAED2090182PK",
    			"Kermi CATWD08018VRK",
    			"Kermi CASTD090182RK",
    			"Kermi CATWD09018VRK",
    			"Kermi CASTD08018VPK",
    			"Kermi CATWD09018VPK",
    			"Kermi CASTD090182PK",
    			"Kermi CAF4009018VPK",
    			"Kermi CAED2080182PK",
    			"Kermi CATWD080182RK",
    			"Kermi ZDSSVSSFI",
    			"Kermi KERMI",
    			"Kermi XB WIW18020 VPK",
    			"Kermi KERMI-BADHEIZKÖRPER",
    			"Kermi UNV10180045.X.K RAL 9",
    			"Kermi BAA5X050000XK",
    			"Kermi BZD52000000UK",
    			"Kermi BA A6X 040000XK",
    			"Kermi BC D4X 030000UK",
    			"Kermi BAEUM140100XK",
    			"Kermi ZDKPWAUN21852K",
    			"Kermi N2STD1801621K",
    			"Kermi CASTD100182PK",
    			"Kermi CAKTD10018VPK",
    			"Kermi CAP48080182PK",
    			"Kermi CAP53090182PK",
    			"Kermi CASTD100182RK",
    			"Kermi KNV320072402R1K",
    			"Kermi ZBAHHCW0CHR",
    			"Kermi I2EF2100202PK",
    			"Kermi I2ED2100201AK",
    			"Kermi CAED2075182PK",
    			"Kermi CAED2075182RK",
    			"Kermi CAKTD100018VRK",
    			"Kermi CAKTD075018VRK",
    			"Kermi CAKTD080018VRK",
    			"Kermi CASTD09518VRK",
    			"Kermi CASTD09518VPK",
    			"Kermi CATWD09518VRK",
    			"Kermi CATWD07518VPK",
    			"Kermi LMN101300602LXG",
    			"Kermi CAED210018VPK",
    			"Kermi KERMI",
    			"Kermi KERMI",
    			"Kermi C2N10100045WKXK",
    			"Kermi ATT10V2220VPK",
    			"Kermi ATTWD10020VAK",
    			"Kermi V2TS2080141PK",
    			"Kermi CAPTD10018VRK",
    			"Kermi CAPTD10018VPK",
    			"Kermi CAPTD100182PK",
    			"Kermi CAPTD07518VRK",
    			"Kermi CAPTD07518VPK",
    			"Kermi CAPTD08018VRK",
    			"Kermi CAPTD080182PK",
    			"Kermi CAPTD090182RK",
    			"Kermi CAPTD09518VPK",
    			"Kermi CAST2120182PK",
    			"Kermi CASTW10018VPK",
    			"Kermi CASTW07518VPK",
    			"Kermi CASTW080182PK",
    			"Kermi CASTW09018VPK",
    			"Kermi CASTW090182PK",
    			"Kermi CASTW09518VPK",
    			"Kermi AXSWL09020VPK",
    			"Kermi AXTWR09020VPK",
    			"Kermi CAC2D08018VPK",
    			"Kermi ZDSSVSTCA185VK",
    			"Kermi BZSE3000000XK",
    			"Kermi BAEUD120090XK",
    			"Kermi BCEXM100100XK",
    			"Kermi ZC00850001",
    			"Kermi UNV101200602X2G*",
    			"Kermi UNV10120060ZXZG*",
    			"Kermi UNV10150060ZXZG*",
    			"Kermi UNV101500602X2G*",
    			"Kermi UNV101800602X2G*",
    			"Kermi RA1WL080201AK",
    			"Kermi RATWD080201AK",
    			"Kermi 2534773",
    			"Kessel 45600.87",
    			"Kessel 73150",
    			"Kolpa d.d. 999380",
    			"Kolpa d.d. 999030",
    			"Kolpa d.d. 998010",
    			"Kolpa d.d. .",
    			"Kolpa d.d. .",
    			"Kuhbier Lubrication + 405002",
    			"Parker Hannifin 66980402",
    			"Parker Hannifin RR01L300",
    			"Palme Duschabtrennungen PALME",
    			"Palme Duschabtrennungen PALME",
    			"Palme Duschabtrennungen PALME",
    			"Palme Duschabtrennungen ASTS60/29//K1",
    			"Palme Duschabtrennungen ATVS140 K7.29.",
    			"Palme Duschabtrennungen ASV120 K7.29.",
    			"Palme Duschabtrennungen BSTV160H129ESG",
    			"Palme Duschabtrennungen CRS100S2-29 CENIT CHRO",
    			"Palme Duschabtrennungen DLE3790A19-20",
    			"Palme Duschabtrennungen DLE3790B19-20",
    			"Palme Duschabtrennungen AVWOK15 L 29 K1 MILCHG",
    			"Palme Duschabtrennungen AVBF212",
    			"Palme Duschabtrennungen DAE270A1920",
    			"Palme Duschabtrennungen DAE270B1920",
    			"Palme Duschabtrennungen 100636",
    			"Palme Duschabtrennungen DXBB211L20H1",
    			"Palme Duschabtrennungen VTNV70/H1/21L",
    			"Palme Duschabtrennungen ASV120/H1/20L",
    			"Palme Duschabtrennungen ATVS90/H1/20R",
    			"Palme Duschabtrennungen P3RV100Z/H1/29L",
    			"Palme Duschabtrennungen EUS80.K1.29",
    			"Palme Duschabtrennungen EUS100.K1.29",
    			"Palme Duschabtrennungen EDEP100A.K1.29",
    			"Palme Duschabtrennungen EDEP80B.K1.29",
    			"Palme Duschabtrennungen EDEP90B.K1.29",
    			"Palme Duschabtrennungen EDEP100B.K1.29",
    			"Palme Duschabtrennungen ERP210N.K1.29",
    			"Palme Duschabtrennungen ERP390NL.K1.29",
    			"Palme Duschabtrennungen ERP310NL.K1.29",
    			"Palme Duschabtrennungen ERP310NR.K1.29",
    			"Palme Duschabtrennungen ERP410N.K1.29",
    			"Palme Duschabtrennungen EFDSS80R.K1.29",
    			"Palme Duschabtrennungen AVBF212/H1/29L",
    			"Palme Duschabtrennungen SNXLC",
    			"Palme Duschabtrennungen 104402",
    			"Lorowerk K.H. Vahlbrauk 01301.040X",
    			"Lorowerk K.H. Vahlbrauk 00911.040X",
    			"Lovato 41351070",
    			"Lovato 49017051",
    			"Lovato 41350540",
    			"Lovato 49140101",
    			"Lovato 49240502",
    			"Lovato 40970904",
    			"Lovato 41350530",
    			"Magra 210.K02",
    			"Magra 210.K03",
    			"Magra 210.K04",
    			"Metallwerk Moellersdorf PG40902212GAS",
    			"Metallwerk Moellersdorf PG40902234GAS",
    			"Metallwerk Moellersdorf 40981212",
    			"Metallwerk Moellersdorf 4243838",
    			"Metallwerk Moellersdorf 42433564",
    			"Metallwerk Moellersdorf PG42431812GAS",
    			"Metallwerk Moellersdorf PG42431834GAS",
    			"Metallwerk Moellersdorf PG42701834GAS",
    			"Metallwerk Moellersdorf 433015",
    			"Metallwerk Moellersdorf 433035",
    			"Metallwerk Moellersdorf 43301812",
    			"Metallwerk Moellersdorf 43401834",
    			"Metallwerk Moellersdorf 43411212",
    			"Metallwerk Moellersdorf 43413554",
    			"Metallwerk Moellersdorf 44711038",
    			"Metallwerk Moellersdorf 44712212",
    			"Metallwerk Moellersdorf PG44711812GAS",
    			"Metallwerk Moellersdorf PG44712234GAS",
    			"Metallwerk Moellersdorf 504010",
    			"Metallwerk Moellersdorf PG504028GAS",
    			"Metallwerk Moellersdorf 504110",
    			"Metallwerk Moellersdorf 508618",
    			"Metallwerk Moellersdorf 508622",
    			"Metallwerk Moellersdorf 5130151212",
    			"Metallwerk Moellersdorf 5130151512",
    			"Metallwerk Moellersdorf 5130151812",
    			"Metallwerk Moellersdorf 5130181018",
    			"Metallwerk Moellersdorf 5130181512",
    			"Metallwerk Moellersdorf 5130221515",
    			"Metallwerk Moellersdorf 5130221815",
    			"Metallwerk Moellersdorf 5130222822",
    			"Metallwerk Moellersdorf 5130282218",
    			"Metallwerk Moellersdorf 5130282815",
    			"Metallwerk Moellersdorf PG513018GAS",
    			"Metallwerk Moellersdorf PG513022GAS",
    			"Metallwerk Moellersdorf PG5130221822GAS",
    			"Metallwerk Moellersdorf PG513028GAS",
    			"Metallwerk Moellersdorf PG5130282228GAS",
    			"Metallwerk Moellersdorf 52402815",
    			"Metallwerk Moellersdorf 524086",
    			"Metallwerk Moellersdorf 5243108",
    			"Metallwerk Moellersdorf 52432815",
    			"Metallwerk Moellersdorf 52432818",
    			"Metallwerk Moellersdorf PG52432215GAS",
    			"Metallwerk Moellersdorf PG52433528GAS",
    			"Metallwerk Moellersdorf PG530118GAS",
    			"Metallwerk Moellersdorf PG530128GAS",
    			"Metallwerk Moellersdorf SAB12",
    			"Metallwerk Moellersdorf SAB18",
    			"Metallwerk Moellersdorf SAB22",
    			"Metallwerk Moellersdorf CG151",
    			"Metallwerk Moellersdorf CG181",
    			"Metallwerk Moellersdorf CG3515",
    			"Metallwerk Moellersdorf CGET2228",
    			"Metallwerk Moellersdorf FLANSCH28",
    			"Metallwerk Moellersdorf 43402234",
    			"Metallwerk Moellersdorf .",
    			"Metallwerk Moellersdorf 4280281",
    			"Metallwerk Moellersdorf 500118*",
    			"Metallwerk Moellersdorf 504028*",
    			"Metallwerk Moellersdorf 504115*",
    			"Metallwerk Moellersdorf 509028*",
    			"Metallwerk Moellersdorf 5130181518*",
    			"Metallwerk Moellersdorf 52431512*",
    			"Metallwerk Moellersdorf 42432212*",
    			"Metallwerk Moellersdorf 5130282818",
    			"Metallwerk Moellersdorf 42701612",
    			"Metallwerk Moellersdorf CGER2228",
    			"Metallwerk Moellersdorf 5130182818",
    			"Metallwerk Moellersdorf 5130182215",
    			"Metallwerk Moellersdorf 5130281515",
    			"Metallwerk Moellersdorf 42703534",
    			"Metallwerk Moellersdorf 5130351835",
    			"Metallwerk Moellersdorf 4021012",
    			"Metallwerk Moellersdorf H628",
    			"Metallwerk Moellersdorf 5130763576",
    			"Metallwerk Moellersdorf 43411534",
    			"Metallwerk Moellersdorf 40902834",
    			"Metallwerk Moellersdorf 40921014",
    			"Metallwerk Moellersdorf 61722122",
    			"Metallwerk Moellersdorf 500154",
    			"Metallwerk Moellersdorf 4309254",
    			"Metallwerk Moellersdorf 431302",
    			"Metallwerk Moellersdorf 432406454",
    			"MKW Kunststofftechnik B51A-0201",
    			"MKW Kunststofftechnik CF09-0101",
    			"MKW Kunststofftechnik D311-0001",
    			"MKW Kunststofftechnik E110-0000",
    			"MKW Kunststofftechnik I120-0000",
    			"MKW Kunststofftechnik R100-0000",
    			"Glass 1989 S.R.L CSBW180WP2",
    			"Meibes 1276065",
    			"Meibes 66301.2",
    			"Meibes 1270072",
    			"Meibes 43.66123.1",
    			"Meibes 46205",
    			"Meibes 58100",
    			"Meibes 58110",
    			"Meibes 58120",
    			"Meibes 66258831",
    			"Meibes 66457.3",
    			"Meibes 66548.12 WI",
    			"Meibes 90250.043 FL",
    			"Meibes 90250.932 FL",
    			"Meibes 66258694",
    			"Meibes 45841EA",
    			"Meibes 10270.61",
    			"Meibes 66811.33WI",
    			"Meibes .",
    			"Meibes 45401.2",
    			"Meibes 45402.2",
    			"Meibes 16335.61",
    			"Meibes 66362.22",
    			"Meibes 66362.23",
    			"Meibes 66813 EWI",
    			"Meibes 66833 EWI",
    			"Meibes 26103.2",
    			"Meibes 66356.86",
    			"Meibes 66131EACMD",
    			"Meibes MEIBES",
    			"MHS 10112",
    			"MHS 16376",
    			"MHS 101070",
    			"MHS 00231KE00000E0",
    			"MHS 18316",
    			"MHS 19252",
    			"MHS BL660000000000",
    			"MHS 24642KE000000S",
    			"MHS 301070",
    			"MHS 401070",
    			"MHS BWDURO50KE/BH",
    			"MHS 18594",
    			"MHS 16722",
    			"MHS PR000000000000",
    			"MHS 13562KE0000000",
    			"MHS WT211000000000",
    			"MHS 11273",
    			"MHS 17621",
    			"MHS WTU-ME/BR350/DN20",
    			"MHS #",
    			"Mascot 06109-010-18",
    			"Mascot 06109-010-18",
    			"Mascot 06169-010-18",
    			"Mascot 05279-010-18",
    			"Mascot 05279-010-18",
    			"Mascot 05279-010-18",
    			"Mascot 50449-893-09",
    			"Mascot 50449-893-09",
    			"Mascot 10179-154-010",
    			"Mascot 10179-154-010",
    			"Mascot 10169-154-010",
    			"Mascot 10109-154-010",
    			"Mascot 10109-154-010",
    			"Muellner 306600",
    			"Loy Juergen 465050",
    			"Loy Juergen WP151-1MATT GESCHLIFFE",
    			"Loy Juergen 731050",
    			"Loy Juergen WP113",
    			"Loy Juergen AC221",
    			"Loy Juergen 0487 040",
    			"Loy Juergen 2950050",
    			"Loy Juergen 2954041",
    			"Loy Juergen 841320",
    			"Loy Juergen ART.-NR.: 923606",
    			"Loy Juergen 300473",
    			"Loy Juergen 300871",
    			"Loy Juergen 464050",
    			"Loy Juergen 447750",
    			"Loy Juergen 4479319",
    			"Loy Juergen 925020",
    			"Novasfer 840 1",
    			"Novasfer 80909015",
    			"Novasfer 10109294",
    			"Novasfer 10209086",
    			"Novasfer 10409072",
    			"Novasfer 10409073",
    			"Novasfer 10409071",
    			"Novasfer 10409074",
    			"N u. F Handels .",
    			"N u. F Handels .",
    			"N u. F Handels .",
    			"N u. F Handels .",
    			"Magontec 20305613",
    			"Neoperl Austria 16730198",
    			"Neoperl Austria 16813198",
    			"Neoperl Austria 16417598",
    			"Neoperl Austria 2734194",
    			"Neoperl Austria 2629894",
    			"Neoperl Austria .",
    			"Neoperl Austria PR.5083.50",
    			"Neoperl Austria SH220096",
    			"Neoperl Austria SH220396",
    			"Neoperl Austria SH235096",
    			"Neoperl Austria SH235196",
    			"Neoperl Austria SH235396",
    			"Neoperl Austria SH236096",
    			"Neoperl Austria SH236196",
    			"Neoperl Austria SH236396",
    			"Neoperl Austria 10961498",
    			"Neoperl Austria 10962698",
    			"Neoperl Austria 1081094",
    			"Neoperl Austria 2725297",
    			"Neoperl Austria 5991297",
    			"Novellini 1B78",
    			"Novellini LUNESVF68LINKS/1KZU SC",
    			"Novellini LUNES2PV166/1K ZUSEITE",
    			"Novellini STARV168F",
    			"Novellini YOUNGGF96-1-A",
    			"Novellini CORAL2PF120S-1K",
    			"Novellini Y22GS97LD-K1",
    			"Novellini Y22GS117LS-1K",
    			"Novellini Y2 1B 87 1K",
    			"Novellini R80COR-TR",
    			"Novellini ROSEA118L D 1 K",
    			"Novellini ROSEA138L S 1 K",
    			"Novellini ROSE2P156 S 1 K",
    			"Novellini L99L1075",
    			"Novellini LIGR90BASICSHT",
    			"Novellini LIGQA90PLUSSHT",
    			"Novellini LIG2140SPLUSSHT",
    			"Novellini STARA72L-16F",
    			"Novellini ELISW80FF-1K",
    			"Novellini EASYT-K",
    			"Novellini JAZZ2-1B",
    			"Novellini LUNESF78-1K",
    			"Novellini YOUNGF75-1K",
    			"Novellini CU160704A-30",
    			"Novellini MEDGF90T1D",
    			"Laufen Austria 8100370000001",
    			"Laufen Austria 8107030001041",
    			"Laufen Austria 8119350000001",
    			"Laufen Austria 8119510001561",
    			"Laufen Austria 8129560001041",
    			"Laufen Austria 8149674001041",
    			"Laufen Austria 8150632000001",
    			"Laufen Austria 8168030001041",
    			"Laufen Austria 8169570001091",
    			"Laufen Austria 8169580001091",
    			"Laufen Austria 8174330001091",
    			"Laufen Austria 8174340001091",
    			"Laufen Austria 8174360001091",
    			"Laufen Austria 8184310001041",
    			"Laufen Austria 8184320001041",
    			"Laufen Austria 8184380001041",
    			"Laufen Austria 8189520001561",
    			"Laufen Austria 8189534001041",
    			"Laufen Austria 8206800000001",
    			"Laufen Austria 8209524000001",
    			"Laufen Austria 2251000000401",
    			"Laufen Austria 2346710000000",
    			"Laufen Austria 2946815610001",
    			"Laufen Austria 2951200000001",
    			"Laufen Austria 2959850000001",
    			"Laufen Austria 2959860000001",
    			"Laufen Austria 3117580041301",
    			"Laufen Austria 3119510041111",
    			"Laufen Austria 3219570044001",
    			"Laufen Austria 3317570044001",
    			"Laufen Austria 3319570044001",
    			"Laufen Austria 3339570044001",
    			"Laufen Austria 3619820043711",
    			"Laufen Austria 3619830043711",
    			"Laufen Austria 3629800001301",
    			"Laufen Austria 3699800042011",
    			"Laufen Austria 8400500000001",
    			"Laufen Austria 8401000000001",
    			"Laufen Austria 4011110754641",
    			"Laufen Austria 4020210754641",
    			"Laufen Austria 4052120755191",
    			"Laufen Austria 4052220755191",
    			"Laufen Austria 4150010305441",
    			"Laufen Austria 8420650004111",
    			"Laufen Austria 4475729000071",
    			"Laufen Austria 4705010705001",
    			"Laufen Austria 4719510705001",
    			"Laufen Austria 4725010705001",
    			"Laufen Austria 4739510705001",
    			"Laufen Austria 4749510705001",
    			"Laufen Austria 4769510705001",
    			"Laufen Austria 4799510705001",
    			"Laufen Austria 4799520705001",
    			"Laufen Austria 4830320959991",
    			"Laufen Austria 4834210964641",
    			"Laufen Austria 8114334001121",
    			"Laufen Austria 8169620001041",
    			"Laufen Austria 3818040040001",
    			"Laufen Austria 8209594000001",
    			"Laufen Austria 8609614641041",
    			"Laufen Austria 8609624641041",
    			"Laufen Austria 8609634631041",
    			"Laufen Austria 8609634641041",
    			"Laufen Austria 8609634801041",
    			"Laufen Austria 8609644231041",
    			"Laufen Austria 8609644641041",
    			"Laufen Austria 8609654641041",
    			"Laufen Austria 8609654801041",
    			"Laufen Austria 8609664231041",
    			"Laufen Austria 8609664641041",
    			"Laufen Austria 8609664801041",
    			"Laufen Austria 8939563000001",
    			"Laufen Austria 8949150040001",
    			"Laufen Austria .",
    			"Laufen Austria 1039.1",
    			"Laufen Austria 1039.2",
    			"Laufen Austria 34151A000",
    			"Laufen Austria 342519000",
    			"Laufen Austria LAUFEN",
    			"Laufen Austria LAUFEN",
    			"Laufen Austria 1743.4 MIT ZUSÄTZLICHE",
    			"Laufen Austria LAUFEN 9497.4",
    			"Laufen Austria 38868.2",
    			"Laufen Austria 1095.1.109.400",
    			"Laufen Austria 81496500000001000",
    			"Laufen Austria 29512.0",
    			"Laufen Austria LAUFEN",
    			"Laufen Austria 8741.24",
    			"Laufen Austria 8744.24",
    			"Laufen Austria 7.2B11.8.200.5",
    			"Laufen Austria 8.2115.7.000.000.1",
    			"Laufen Austria 8.2310.9.000.249.1",
    			"Laufen Austria 8.2022.8.000.000.1",
    			"Laufen Austria 8.1301.1.000.104.1",
    			"Laufen Austria LAUFEN",
    			"Laufen Austria 2340475",
    			"Laufen Austria 4202340805351",
    			"Laufen Austria 7.2214.6.500.B",
    			"Laufen Austria 7.2B12.8.200.5",
    			"Laufen Austria 7.2377.6.500.B",
    			"Laufen Austria 7.3278.8.100.0",
    			"Laufen Austria 8.2071.1.000.000.1",
    			"Laufen Austria 8.3171.1.000.304.1",
    			"Laufen Austria 2944620000001",
    			"Laufen Austria 8.2061.1.000.000.1",
    			"Laufen Austria 8159702001041",
    			"Laufen Austria 4373520305441",
    			"Laufen Austria 4629429944201",
    			"Laufen Austria 72B1082210",
    			"Laufen Austria 7.3258.8.300.0",
    			"Laufen Austria 7.3278.8.200.0",
    			"Laufen Austria 7.3376.2.100.0",
    			"Laufen Austria 7.3276.2.400.0",
    			"Laufen Austria 7.3276.2.200.0",
    			"Laufen Austria 7.3276.2.300.0",
    			"Laufen Austria 7.3466.2.700.0",
    			"Laufen Austria 7.3416.2.000.0",
    			"Laufen Austria 7.8016.2.200.4",
    			"Laufen Austria 7.8066.2.000.4",
    			"Laufen Austria 7.3576.2.500.0",
    			"Laufen Austria 7.3576.2.400.0",
    			"Laufen Austria 4769310708221",
    			"Laufen Austria 7.3276.2.100.0",
    			"Laufen Austria 7525774800",
    			"Laufen Austria 7525774700",
    			"Laufen Austria 7.2B23.8.921.0",
    			"Laufen Austria 7.2B18.8.121.1",
    			"Laufen Austria 7.3536.2.E00.0",
    			"Laufen Austria 3.4171.1.004.001.1",
    			"Laufen Austria 3.3071.6.004.000.1",
    			"Laufen Austria 3.2071.6.004.000.1",
    			"Laufen Austria 3.7171.0.004.020.1",
    			"Laufen Austria 7.3278.8.200.H",
    			"Laufen Austria ROC325883HL",
    			"Laufen Austria ROC325883HR",
    			"Laufen Austria 4.5011.1.172.300.1",
    			"Laufen Austria 4.5011.2.172.300.1",
    			"Laufen Austria 4.5011.4.172.300.1",
    			"Laufen Austria 4.5011.5.172.300.1",
    			"Laufen Austria 4.5011.6.172.300.1",
    			"Laufen Austria 4.5014.1.172.300.1",
    			"Laufen Austria 4.5570.5.173.144.1",
    			"Laufen Austria 4.5571.5.173.144.1",
    			"Laufen Austria 4.5572.5.173.144.1",
    			"Laufen Austria 4.5573.5.173.144.1",
    			"Laufen Austria 4.9213.1.172.300.1",
    			"Laufen Austria 4.9213.2.172.300.1",
    			"Laufen Austria 4.9214.1.172.300.1",
    			"Laufen Austria 4.9214.2.172.300.1",
    			"Laufen Austria 8.6095.0.000.000.1",
    			"Laufen Austria 8609520000001",
    			"Laufen Austria 8609530000001",
    			"Laufen Austria 8.2153.8.000.000.1",
    			"Laufen Austria 8134390001551",
    			"Laufen Austria 8173020001091",
    			"Laufen Austria 8709760000001",
    			"Laufen Austria 8989650000001",
    			"Laufen Austria 8603770000001",
    			"Laufen Austria LHBSET",
    			"Laufen Austria 8.6095.3.000.000.1",
    			"Laufen Austria 8.6095.2.000.000.1",
    			"Laufen Austria 40128.2 075 464 1",
    			"Oventrop 1184004",
    			"Oventrop 1163052",
    			"Oventrop 1011475",
    			"Oventrop 4205606",
    			"Oventrop 4205608",
    			"Oventrop 1012575",
    			"Oetscher JA0296021/32",
    			"Oetscher JA0296021/32",
    			"Oetscher JA0296021/32",
    			"Oetscher JA0296021/32",
    			"Oetscher JA0296021/32",
    			"Oetscher JA0296021/32",
    			"Oetscher LH0296021/32",
    			"Oetscher LH0296021/32",
    			"Oetscher LH0296021/32",
    			"Oetscher LH0296021/32",
    			"Oetscher LH0296021/32",
    			"Oetscher LH0295021/32",
    			"Oetscher BH04",
    			"Oetscher BH04",
    			"Oetscher BH04",
    			"Oetscher GI01",
    			"Oetscher GI01",
    			"Oetscher GI01",
    			"Oetscher GI01",
    			"Oetscher GI01",
    			"Ochsner OCHSNER",
    			"Ochsner 916012E",
    			"Ochsner OCHSNER",
    			"Ochsner OCHSNER",
    			"Ochsner 290376",
    			"Ochsner 915616",
    			"Ochsner 920037",
    			"Ochsner 922038",
    			"Ochsner 274700",
    			"Ochsner 928048",
    			"Ochsner 918255",
    			"Ochsner 290349",
    			"Ochsner 918270",
    			"Ochsner 918190",
    			"Ochsner 290341",
    			"Ochsner 130261",
    			"Ochsner 290538",
    			"Ochsner 110233",
    			"Ochsner 281580",
    			"Ochsner 284549",
    			"Ochsner 920575",
    			"Ochsner 920581",
    			"Ochsner 920589",
    			"Ochsner 929935",
    			"Ochsner 110236",
    			"OMP spa 232.8406 NP",
    			"Oras 6507C7981015 4204893 6",
    			"Oras 8587",
    			"OEG Oel-u. Gasfeuerungs 112101210",
    			"Poloplast 2997",
    			"Poloplast 2818",
    			"Poloplast 2822",
    			"Poloplast 2272",
    			"Poloplast 2944",
    			"Poloplast 2987",
    			"Poloplast 2906",
    			"Poloplast 2907",
    			"Poloplast 2908",
    			"Poloplast 2339",
    			"Poloplast 3040",
    			"Poloplast 2991",
    			"Poloplast 2454",
    			"Poloplast 2456",
    			"Poloplast 2252",
    			"Poloplast 2528",
    			"Poloplast 2912",
    			"Poloplast 2394",
    			"Poloplast 1713",
    			"Poloplast 1727",
    			"Poloplast 1734",
    			"Poloplast 2910",
    			"Poloplast 70186",
    			"Poloplast 15112",
    			"Poloplast 71209",
    			"Poloplast 71744",
    			"Poloplast 15049",
    			"Poloplast PKDA100.75.67",
    			"Poloplast KAEP12DM400",
    			"Poloplast 15016",
    			"Poloplast 71400",
    			"Poloplast 74060",
    			"Poloplast 74084",
    			"Poloplast 14851",
    			"Poloplast 14855",
    			"Poloplast 71747",
    			"Poloplast 71042*",
    			"Poloplast 72004*",
    			"Poloplast 00100H",
    			"Poloplast 74574",
    			"Poloplast 70501",
    			"Poloplast 15117",
    			"Poloplast 00103H",
    			"Poloplast 15050",
    			"Poloplast 71628",
    			"Poloplast 71210",
    			"Poloplast 15111",
    			"Poloplast 71749",
    			"Poloplast 71009",
    			"Poloplast 71109",
    			"Poloplast 15118",
    			"Poloplast 5405",
    			"Poloplast 5502",
    			"Poloplast 5503",
    			"Poloplast 102836",
    			"Poloplast 102248",
    			"Polypex 20410",
    			"Polypex 23921",
    			"Polypex 14521",
    			"Polypex 48121",
    			"Polypex 49121",
    			"Polypex 33401",
    			"Polypex 69300",
    			"Polypex 79921",
    			"Polypex 84300",
    			"Mepa-Pauli und Menden 718840",
    			"Mepa-Pauli und Menden 718840",
    			"Mepa-Pauli und Menden 549512",
    			"Mepa-Pauli und Menden 718255",
    			"Mepa-Pauli und Menden 718406",
    			"Mepa-Pauli und Menden 718651",
    			"Provex 0003SG31OE",
    			"Provex 3020SD05OE",
    			"Provex 4056SG05OE",
    			"Provex 6003 CR-L-05",
    			"Provex 6003 CR-R-05",
    			"Provex 0007 CW 05L",
    			"Provex 0013 CT R GL 05",
    			"Provex 0005WE05GL",
    			"Provex 0065ZH31PM",
    			"Pichler J. 10CTVK100",
    			"Pichler J. 11MOK0102",
    			"Pichler J. 11SL3010031506",
    			"Pichler J. 11SR0125056",
    			"Pichler J. 11ALFR250",
    			"Pichler J. 11B040090",
    			"Pichler J. 11NP0400",
    			"Pichler J. 11MF0400",
    			"Pichler J. 11PS200080",
    			"Pichler J. .",
    			"Pichler J. 08LG180ABDECK285",
    			"Pichler J. 08SN1001",
    			"Pichler J. 08SN1002",
    			"Pichler J. 11RCU250200",
    			"Pichler J. 11PS200100",
    			"Paw 36073",
    			"Ebner Friedrich 7040-040.00",
    			"Ebner Friedrich 7040-063.00",
    			"Ebner Friedrich 7930-063.32",
    			"Ebner Friedrich 09310-050.06P",
    			"puteus 40022-E",
    			"puteus 42424-E",
    			"puteus 20113-E",
    			"puteus 40402-E",
    			"puteus 40403-E",
    			"puteus 41313-E",
    			"puteus 42393-E",
    			"puteus 42394-E",
    			"puteus 42900-E",
    			"puteus 40904-E",
    			"puteus 41802-E",
    			"puteus 20222-E",
    			"puteus 42401-E",
    			"puteus 42404-E",
    			"puteus 42451-E",
    			"puteus 24013-E",
    			"Rti Industries 46TEW01390042EE",
    			"Rti Industries 46TEW01390048EE",
    			"Richter Manfred 61120",
    			"Richter Manfred 228001",
    			"Richter Manfred 610065",
    			"Richter Manfred AA4004-80-02",
    			"Richter Manfred PV-MA25",
    			"Richter Manfred 411211332",
    			"Richter Manfred 411-211-032",
    			"Rems 175104",
    			"Rems 164115 R",
    			"Rems 170020",
    			"Rems 175110 R220",
    			"Rems 291310 R",
    			"Red-Ring 17264",
    			"Rehau 11391011002",
    			"Rehau 11397411002",
    			"Rehau 11371551001",
    			"Rehau 11370941001",
    			"Rehau 169063",
    			"Rehau 11230921001",
    			"Rehau 13923010001 / 13392301",
    			"Rehau REHAU",
    			"Rehau REHAU",
    			"Rehau 11234541001*",
    			"Rehau 11215241002",
    			"Rehau 12392431001",
    			"Rehau 126223900",
    			"Rehau 240857001",
    			"Rehau 12676811002",
    			"Rehau 11205241100",
    			"Rehau 11379951001",
    			"Rehau 11237131950",
    			"Rehau 11227931950",
    			"Rehau 11384811405",
    			"Rehau 11384911405",
    			"Rehau 12446111001",
    			"Rehau 12468991001",
    			"Rehau 11396011402",
    			"Rehau 11397511002",
    			"Rehau 11691301001",
    			"Rehau 11378731001",
    			"Rehau 12607401002",
    			"Rehau 13202761001",
    			"Rehau 11222131950",
    			"Rehau 11200361900",
    			"Rehau 11225931950",
    			"Rehau 11314981025",
    			"Rehau 11314991025",
    			"Rehau 11361401005",
    			"Rehau 11361601120",
    			"Rehau 137023001",
    			"Rehau 11370651001",
    			"Rehau 11371961050",
    			"Rehau 11373451001",
    			"Rehau 138481005",
    			"Rehau 138961002",
    			"Rehau 139872001",
    			"Rehau 11398821001",
    			"Rehau 139982001",
    			"Rehau 200296001",
    			"Rehau 12028071001",
    			"Rehau 12177571001",
    			"Rehau 12288801001",
    			"Rehau 240051003",
    			"Rehau 240061003",
    			"Rehau 240071003",
    			"Rehau 240111003",
    			"Rehau 12491371001",
    			"Rehau 257326002",
    			"Rehau 259405002",
    			"Rehau 12594591002",
    			"Rehau 12611031001",
    			"Rehau 12663121001",
    			"Rehau 266332001",
    			"Rehau 266342001",
    			"Rehau 12664621001",
    			"Rehau 12871961001",
    			"Rehau 12893181900",
    			"Rehau 12893361900",
    			"Rehau 13392301001",
    			"Rehau 13422301001",
    			"Rehau 13661411001",
    			"Rehau 11233041001",
    			"Rehau 11237141001",
    			"Rehau 11237241001",
    			"Reiter Werkzeuge T20313-BT450S",
    			"Reiter Werkzeuge T68080",
    			"Roth Werke 1135000199",
    			"Roth Werke 1115001223",
    			"Roth Werke 1135001505",
    			"Roth Werke 1135001576",
    			"Roth Werke 1135007708",
    			"Roth Werke 1135002393",
    			"Roth Werke 1135001250",
    			"Roth Werke 1135001256",
    			"Roth Werke 1135001604",
    			"Roth Werke 1115005496",
    			"Roth Werke 1115005494",
    			"Roth Werke 1115005490",
    			"Roth Werke 1135001253",
    			"Roth Werke 1115005497",
    			"Roth Werke 1135001257",
    			"Roth Werke 1135001254",
    			"Roth Werke 1135001252",
    			"Roth Werke 1135001260",
    			"Roth Werke 1115005492",
    			"Roth Werke 1135001291",
    			"Roth Werke 1135001292",
    			"Roth Werke 1115005505",
    			"Roth Werke 1115005506",
    			"Roth Werke 1135001237",
    			"Roth Werke 1135001271",
    			"Roth Werke 1135001244",
    			"Roth Werke 1135001246",
    			"Roth Werke 1115005482",
    			"Roth Werke 1135001240",
    			"Roth Werke 1135001243",
    			"Roth Werke 1135001492",
    			"Roth Werke 1135000514",
    			"Roth Werke 1115005399",
    			"Roth Werke 1135000517",
    			"Roth Werke 1135000520",
    			"Roth Werke 1135002611",
    			"Roth Werke 1135003292",
    			"Roth Werke 1135000364",
    			"Roth Werke RW1135006110",
    			"Roth Werke 1150008808",
    			"Roth Werke 1150006872",
    			"Roth Werke 1110000768",
    			"Roth Werke 1110000793",
    			"Roth Werke 1135003403",
    			"Roth Werke 1115008143",
    			"Roth Werke 1115008152",
    			"Roth Werke 1135005198",
    			"Roth Werke 1135005189",
    			"Roth Werke 1150008825",
    			"Roth Werke 1135006227",
    			"Roth Werke 1135006031",
    			"Roth Werke 1135007053",
    			"Raccorderie Metalliche SPA 530102093",
    			"Raccorderie Metalliche SPA 245308184",
    			"Raccorderie Metalliche SPA 529308300",
    			"Raccorderie Metalliche SPA 10020119",
    			"Raccorderie Metalliche SPA 700101002",
    			"Raccorderie Metalliche SPA 700445000",
    			"Raccorderie Metalliche SPA 241308143",
    			"Raccorderie Metalliche SPA 529308100",
    			"Raccorderie Metalliche SPA 529308200",
    			"Raccorderie Metalliche SPA 529100150",
    			"Raccorderie Metalliche SPA 529100200",
    			"Raccorderie Metalliche SPA 529100250",
    			"Haas & Sohn Ofentechnik 1111131310000",
    			"Rothenberger 1000000328",
    			"Rothenberger 854185",
    			"Rothenberger 854186",
    			"Rothenberger 15411",
    			"Rothenberger 015321X",
    			"Rothenberger 070017D",
    			"Rothenberger 35931",
    			"Rothenberger 70011",
    			"Reumueller Erwin TEWA 55115",
    			"ROOS & ROOS & Co. KG 001730 SL EDELSTAHL MA",
    			"Riho CZ a.s. AS021110",
    			"Zetes Austria K104N110X300",
    			"Zetes Austria 105391",
    			"Sanotechnik B8080C",
    			"Sanotechnik B8080CS",
    			"Sanotechnik B1010C",
    			"Sanotechnik B1010CS",
    			"Sanotechnik B80CS",
    			"Sanotechnik B80CS",
    			"Sanotechnik B90CS",
    			"Sanotechnik B90CS",
    			"Sanotechnik B10C",
    			"Sanotechnik B10C",
    			"Sanotechnik B10CS",
    			"Sanotechnik B10CS",
    			"Teka Austria SWIAG",
    			"Teka Austria 40180100",
    			"Teka Austria Q857S",
    			"Teka Austria PRIFMABG",
    			"Teka Austria PRIFNBID",
    			"Teka Austria PRIFNSPTND",
    			"Teka Austria PRIFNSTW",
    			"Teka Austria PRIFNVUB",
    			"Teka Austria PRIFNVUW",
    			"Teka Austria AC091",
    			"Teka Austria SP710EH",
    			"Teka Austria 755G",
    			"Teka Austria 1.25/10",
    			"Teka Austria 103M/10",
    			"Teka Austria 13812",
    			"Teka Austria 502M/10",
    			"Teka Austria S557G",
    			"Teka Austria S561",
    			"Teka Austria S574",
    			"Teka Austria 53.231.12",
    			"Teka Austria 53.101.12",
    			"Teka Austria S557S",
    			"Teka Austria MTP457S",
    			"Teka Austria MF157SH",
    			"Teka Austria 23.939.12.00",
    			"Teka Austria 001B",
    			"Teka Austria 257AS/MET",
    			"Teka Austria 330",
    			"Teka Austria 762G",
    			"Teka Austria 55.231.02.00",
    			"Teka Austria 55.121.02.00",
    			"Teka Austria C301",
    			"Teka Austria 32.342.02.00",
    			"Teka Austria 32.231.02.00",
    			"Teka Austria 32.121.02.00",
    			"Teka Austria D820",
    			"Teka Austria DP357G",
    			"Teka Austria 23.622.02.00",
    			"Teka Austria G139",
    			"Teka Austria G144",
    			"Teka Austria G2110",
    			"Teka Austria G2802",
    			"Teka Austria G3519",
    			"Teka Austria 50.913.02.00",
    			"Teka Austria 10.201.00",
    			"Teka Austria 38.121.02",
    			"Teka Austria 13.187.00",
    			"Teka Austria S557G",
    			"Teka Austria U62C",
    			"Teka Austria U67C/5",
    			"Teka Austria U68C",
    			"Teka Austria 79.002.72.00",
    			"Sfa Sanibroy D2540C",
    			"Sfa Sanibroy 001A",
    			"Sfa Sanibroy SANIBESTP",
    			"Sfa Sanibroy 1",
    			"Sfa Sanibroy .",
    			"Sfa Sanibroy .",
    			"Sfa Sanibroy SANICUBICCLASSIC",
    			"Sfa Sanibroy 0029WP",
    			"Sfa Sanibroy 16",
    			"Sfa Sanibroy SANITAUCH",
    			"Sfa Sanibroy 8",
    			"Domo-Sanifer 12503",
    			"Domo-Sanifer 12003",
    			"Domo-Sanifer 50370165",
    			"Domo-Sanifer B001-41-00",
    			"Domo-Sanifer 12202",
    			"Domo-Sanifer 10002",
    			"Domo-Sanifer 10005",
    			"Domo-Sanifer 14808",
    			"Schmiedl Gustav GS0211",
    			"Schmiedl Gustav GS1084-0700",
    			"Schmiedl Gustav GS0013-250P",
    			"Schmiedl Gustav GS0013-090P",
    			"Schmiedl Gustav GS0602RAM",
    			"Schmiedl Gustav GS717262",
    			"Schmiedl Gustav GS717312NV",
    			"Schmiedl Gustav GS79022PS",
    			"Schmiedl Gustav U1R50-137",
    			"Schmiedl Gustav GS1302U2",
    			"Schmiedl Gustav GS1306U2",
    			"Schmiedl Gustav GS0030 CHROM",
    			"Schmiedl Gustav GS0026-0600 CHROM",
    			"Schmiedl Gustav GS04914WA1",
    			"Schmiedl Gustav 0",
    			"Schmiedl Gustav 0",
    			"Stiebel Eltron 73007",
    			"Schell .",
    			"Schell 487070699",
    			"Schell 14290699",
    			"Schell 22380699",
    			"Schell 34410399",
    			"Schell 39950399",
    			"Schell 270150699",
    			"Schell 285040699",
    			"Struktur .",
    			"Struktur 117080",
    			"Seppelfricke 1623",
    			"Seppelfricke 536077",
    			"Seppelfricke SEPPELFRICKE",
    			"Seppelfricke SEP1614.71",
    			"Seppelfricke 4512",
    			"Seppelfricke 6613",
    			"Seppelfricke 8224.68",
    			"Schaecke Elektrogross- 2382997",
    			"Schaecke Elektrogross- 2531690",
    			"Schaecke Elektrogross- 2417243",
    			"Schaecke Elektrogross- 73903",
    			"Schaecke Elektrogross- 2788314",
    			"Schaecke Elektrogross- 80756",
    			"Schaecke Elektrogross- 139289",
    			"Schaecke Elektrogross- 262285",
    			"Siblik CDY89122",
    			"Sanitaertechnik Eisenberg 03.527.00..0001",
    			"Sanitaertechnik Eisenberg 03.528.00..0001",
    			"Sanitaertechnik Eisenberg 03.585.00..0001",
    			"Sanitaertechnik Eisenberg 03.524.00..0003",
    			"Sanitaertechnik Eisenberg 03.415.00..0002",
    			"Sanitaertechnik Eisenberg 03.525.00..0003",
    			"Sanitaertechnik Eisenberg 03.532.00..0002",
    			"Sanitaertechnik Eisenberg 34.035.00..0020",
    			"Sanitaertechnik Eisenberg 34.045.00..0006",
    			"Sanitaertechnik Eisenberg 31.204.00..0000",
    			"Siemens LANDIS & STAEFA",
    			"Siemens SQL36E50F04",
    			"Siemens REA23/101",
    			"Siemens RVP300-A",
    			"Siemens BPZ:WFK30.E130",
    			"Siemens FKM0075",
    			"Siemens LOA24.171B27",
    			"Siemens RAB21",
    			"Siemens S55200-V117",
    			"Springer 334200T",
    			"Springer 31004038T",
    			"Springer 30804034T",
    			"SAM C0772600010",
    			"SAM C0772529010",
    			"SAM C0771817903",
    			"SAM C0771200010",
    			"SAM 4003035010",
    			"SAM 357 8120 010",
    			"SAM 357 8064 010",
    			"SAM 357 8086 010",
    			"SAM 357 8012 010",
    			"SAM 357 8003 010",
    			"SAM 357 8156 010",
    			"SAM 357 8198 010",
    			"SAM 357 8016 010",
    			"SAM 357 8118 010",
    			"SAM 2862200010",
    			"SAM 32620010",
    			"SAM 2822360010",
    			"SAM 2822200010",
    			"SAM 2821205010",
    			"SAM 2821303900",
    			"SAM 2821200010",
    			"SAM 282190010",
    			"SAM 2822350010",
    			"SAM 2822520010",
    			"SAM 2823805010",
    			"SAM 2821800900",
    			"SAM 2822101010",
    			"SAM 380 8466 010",
    			"SAM 380 8410 000",
    			"SAM 380 8467 010",
    			"SAM 2861793010",
    			"SAM 3128103010COM",
    			"SAM 3128199010COM",
    			"SAM 1621200010",
    			"SAM 1623802010",
    			"SAM 3998573010",
    			"SAM SAM WISCHER 1044041010",
    			"SAM 3318193010",
    			"SAM 3318199010",
    			"SAM 3318813010",
    			"SAM 3318424010",
    			"SAM 2651000010",
    			"SAM 2651101900",
    			"SAM 2651200010",
    			"SAM 2651205010",
    			"SAM 2651300900",
    			"SAM 2651800900",
    			"SAM 2653801010",
    			"SAM 2651901010",
    			"SAM 2652101010",
    			"SAM 2652203010",
    			"SAM 2652206010",
    			"SAM 2652211010",
    			"SAM 2652212010",
    			"SAM 2652404010",
    			"SAM 2652520010",
    			"SAM 2652530010",
    			"SAM 2652601010",
    			"SAM 3998572010",
    			"SAM 3998828010",
    			"SAM 3998950010",
    			"SAM 3008139000",
    			"SAM 3008661000",
    			"SAM 3008662010",
    			"SAM 3998944010",
    			"SAM 3008192000",
    			"SAM 3048057010",
    			"SAM 2642601010",
    			"SAM 2642360010",
    			"SAM 2642200010",
    			"SAM 2642203010",
    			"SAM 2641205010",
    			"SAM 2641303900",
    			"SAM 2641200010",
    			"SAM 2642000010",
    			"SAM 2642000010",
    			"SAM 2642352010",
    			"SAM 2641900010",
    			"SAM 2642350010",
    			"SAM 2642520010",
    			"SAM 2642530010",
    			"SAM 2641800900",
    			"SAM 2643808010",
    			"SAM 2642101010",
    			"SAM 5503528010",
    			"SAM 3998848000",
    			"SAM 3998493010",
    			"SAM 32041010",
    			"SAM 3008696010",
    			"SAM 3178244010",
    			"SAM 3178199010",
    			"SAM 3178050010",
    			"SAM 3048717010",
    			"SAM 3048199010",
    			"SAM 3048193010",
    			"SAM 3048212010",
    			"SAM 2642601010",
    			"SAM 3048033010",
    			"SAM 3008034000",
    			"SAM 3208696010",
    			"SAM 3208244010",
    			"SAM 3208216010",
    			"SAM 3208044010",
    			"SAM 2642020010",
    			"SAM 3008031000",
    			"SAM 3898034010",
    			"SAM 31400010",
    			"SAM 32001010",
    			"SAM 32021010",
    			"SAM 32045010",
    			"SAM 32301010",
    			"SAM 32600010",
    			"SAM 32630010",
    			"SAM 33130010",
    			"SAM 33140010",
    			"SAM 41903010",
    			"SAM 43120010",
    			"SAM 52103010",
    			"SAM 71320900",
    			"SAM 72520010",
    			"SAM 771000010",
    			"SAM 771100903",
    			"SAM 771101903",
    			"SAM 771200010",
    			"SAM 771317903",
    			"SAM 771817903",
    			"SAM 772101010",
    			"SAM 772300010",
    			"SAM 772520010",
    			"SAM 772531010",
    			"SAM 1002880010",
    			"SAM 1352000025",
    			"SAM 1381130900",
    			"SAM 1381304900",
    			"SAM 1382605010",
    			"SAM 1701315903",
    			"SAM 1702520010",
    			"SAM 1702601010",
    			"SAM 1803803010",
    			"SAM 3008661000",
    			"SAM 3008813010",
    			"SAM 3078057010",
    			"SAM 3328199010",
    			"SAM 3398418010",
    			"SAM 3398424010",
    			"SAM 3488200010",
    			"SAM 3998944010",
    			"SAM 4003001010",
    			"SAM 5503924010",
    			"Steininger Franz 925G450-650",
    			"Stelrad Caradon B.V. R509205",
    			"Stelrad Caradon B.V. R509206",
    			"Stelrad Caradon B.V. 291051104",
    			"Stelrad Caradon B.V. T1651",
    			"Stelrad Caradon B.V. T1654",
    			"Stelrad Caradon B.V. 214062218",
    			"Stelrad Caradon B.V. 214062209",
    			"Stelrad Caradon B.V. 214093306",
    			"Stelrad Caradon B.V. R57050511",
    			"Stelrad Caradon B.V. T1602",
    			"Stelrad Caradon B.V. T1603",
    			"Stelrad Caradon B.V. T1604",
    			"Stelrad Caradon B.V. T1605",
    			"Pipelife Austria PE100A110-16/6",
    			"IMI 980024500",
    			"IMI 288100500",
    			"IMI 0573-50.000",
    			"IMI SANIMEISTER",
    			"IMI 3151116",
    			"IMI TA",
    			"IMI TA",
    			"IMI TA",
    			"IMI 194600500",
    			"IMI 50007720",
    			"IMI 11111015200",
    			"IMI 30100102",
    			"IMI 131315351",
    			"IMI 130116351",
    			"IMI 4281074",
    			"IMI 7121004",
    			"IMI 7101012",
    			"IMI 7892120",
    			"IMI 7892125",
    			"IMI 7892132",
    			"IMI 7891120",
    			"IMI 7891122",
    			"IMI 200424300",
    			"IMI 5372030",
    			"IMI 7882065",
    			"IMI 1110460",
    			"IMI 44756975",
    			"IMI 50861112",
    			"IMI 52265340",
    			"IMI 52757031",
    			"IMI 52795125",
    			"IMI 53363620",
    			"IMI 53500340",
    			"IMI 618925",
    			"IMI 65143065",
    			"IMI 480004000",
    			"IMI 3399102",
    			"IMI 52796240",
    			"IMI 1023141TA",
    			"IMI 1023145TA",
    			"IMI 52164010",
    			"IMI 30304111000",
    			"IMI 934005800",
    			"IMI 200100325",
    			"IMI 95001117",
    			"IMI 933981800",
    			"IMI 933982800",
    			"IMI 7882080",
    			"IMI 0541-500000",
    			"IMI 11111015100",
    			"IMI 50683005",
    			"IMI 52132100",
    			"IMI 52721820",
    			"IMI 52759020",
    			"IMI 52759025",
    			"IMI 52759050",
    			"IMI 52761040",
    			"IMI 58500625",
    			"IMI 60816040",
    			"IMI 80021265",
    			"IMI 80030250",
    			"Tgv 922051",
    			"Tgv 922811",
    			"Tgv 923328",
    			"Tgv 922869",
    			"Tgv 512175",
    			"Tgv 202038",
    			"Tgv 202041",
    			"Tgv 236262",
    			"Tgv 231251",
    			"Tgv 202032",
    			"Tgv 202062",
    			"Tgv 202072",
    			"Tgv 231401",
    			"Tgv 231485",
    			"Tgv 243085",
    			"Tgv 243235",
    			"Tgv 243214",
    			"Tgv 243222",
    			"Tgv 243421",
    			"Tgv 243415",
    			"Tgv 243145",
    			"Tgv 243146",
    			"Tgv 243355",
    			"Tgv 232356",
    			"Tgv 900101",
    			"Tgv 900111",
    			"Tgv 900112",
    			"Tgv 900122",
    			"Tgv 202063",
    			"Tgv 243135",
    			"Tgv 231488",
    			"Tgv 231489",
    			"Tgv 231632",
    			"Technische Alternative 01/UVR61-3",
    			"Technische Alternative 01/KFKTY",
    			"Technische Alternative 01/RAS-PLUS",
    			"Teuco 0902---------",
    			"Teuco 0903--------",
    			"Teuco K025",
    			"Tenne Export - Import PRISMA",
    			"Thomas Robert Metall- u. 793206-S",
    			"Thomas Robert Metall- u. 787100",
    			"Thomas Robert Metall- u. 787421",
    			"Thomas Robert Metall- u. 793200",
    			"Thomas Robert Metall- u. 795357",
    			"Pentair Thermal Management 1244-002607",
    			"Pentair Thermal Management 001013-000",
    			"T4 Systems Umwelttechnik 29919",
    			"Tomek Elektronics 111170351100",
    			"Tomek Elektronics 191590190900",
    			"Unex Heatexchanger VER22",
    			"Unex Heatexchanger VER20",
    			"Unex Heatexchanger HISO324-20-S1",
    			"Unex Heatexchanger HISOU310-10",
    			"Unex Heatexchanger HISOU310-30",
    			"Unex Heatexchanger HISOU311-10",
    			"Unex Heatexchanger HISOU311-20",
    			"Unex Heatexchanger HISOU311-24",
    			"Unex Heatexchanger HISOU311-30",
    			"Unex Heatexchanger HISOU311-34",
    			"Unex Heatexchanger HISOU311-40",
    			"Unex Heatexchanger HISOU311-44",
    			"Unex Heatexchanger HISOU311-60",
    			"Unex Heatexchanger HISOU320-10",
    			"Unex Heatexchanger HISOU320-20",
    			"Unex Heatexchanger HISOU320-24",
    			"Unex Heatexchanger HISOU320-44",
    			"Unex Heatexchanger HISOU320-60",
    			"Unex Heatexchanger HISOU320-90",
    			"Unex Heatexchanger PB24-24-S1",
    			"Unex Heatexchanger PB24-30-S1",
    			"Unex Heatexchanger PB24-40-S1",
    			"Unex Heatexchanger PB4-20",
    			"Unex Heatexchanger PB4-30",
    			"Unex Heatexchanger PBU10-10",
    			"Unex Heatexchanger PBU11-10",
    			"Unex Heatexchanger PBU11-20",
    			"Unex Heatexchanger PBU11-24",
    			"Unex Heatexchanger PBU11-30",
    			"Unex Heatexchanger PBU11-34",
    			"Unex Heatexchanger PBU11-60",
    			"Unex Heatexchanger PBU20-20",
    			"Unex Heatexchanger PBU20-24",
    			"Unex Heatexchanger PBU20-40",
    			"Unex Heatexchanger PBU20-44",
    			"Unex Heatexchanger PB24-10-S1",
    			"Unex Heatexchanger HISOU310-24",
    			"Unex Heatexchanger EHSISOU20-40",
    			"Unex Heatexchanger WH-SOLAR02",
    			"Unex Heatexchanger HISO304-20",
    			"Vaillant 20064750",
    			"Vaillant 10007264",
    			"Vaillant 012772*",
    			"Vaillant 20178885",
    			"Vaillant VAILLANT",
    			"Vaillant 310232",
    			"Vaillant 306782",
    			"Vaillant 20028510",
    			"Vaillant 78283",
    			"Vaillant 10002520",
    			"Vaillant 2618764",
    			"Vaillant 20042748",
    			"Vaillant 20102173",
    			"Vaillant 20202765",
    			"Vaillant 20137361",
    			"Vaillant 20180827",
    			"Vaillant 20180883",
    			"Vaillant 20171202",
    			"Vaillant 20178885",
    			"Vaillant 101153",
    			"Vaillant 10013278",
    			"Vaillant 10013279",
    			"Vaillant 10014992",
    			"Vaillant 10016525",
    			"Vaillant 10016526",
    			"Vaillant 10016527",
    			"Vaillant 20018427",
    			"Vaillant 20021595",
    			"Vaillant 20037988",
    			"Vaillant 20038522",
    			"Vaillant 20061331",
    			"Vaillant 20098731",
    			"Vaillant 20099765",
    			"Vaillant 20106354",
    			"Vaillant 20106364",
    			"Vaillant 20106366",
    			"Vaillant 20110504",
    			"Vaillant 20124932",
    			"Vaillant 20128491",
    			"Vaillant 20144927",
    			"Vaillant 20146366",
    			"Vaillant 20153782",
    			"Vaillant 20161227",
    			"Vaillant 20174076",
    			"Vaillant 20174483",
    			"Vaillant 20175271",
    			"Vaillant 20176525",
    			"Vaillant 20188186",
    			"Vaillant 20197910",
    			"Vaillant 5118700",
    			"Vaillant 5119200",
    			"Vaillant 5119600",
    			"Vaillant 5121500",
    			"Vaillant 5121800",
    			"Vaillant 5121900",
    			"Vaillant 5126600",
    			"Vaillant 5169100",
    			"Vaillant 5169500",
    			"Vaillant 5172500",
    			"Vaillant 5211100",
    			"Vaillant 5232200",
    			"Vaillant 5232700",
    			"Vaillant 5236900",
    			"Vaillant 5247900",
    			"Vaillant 5290800",
    			"Vaillant 5292000",
    			"Vaillant 5349600",
    			"Vaillant 5410600",
    			"Vaillant 5419000",
    			"Vaillant 5424500",
    			"Vaillant 5428500",
    			"Vaillant 5453200",
    			"Vaillant 5467800",
    			"Vaillant 5485000",
    			"Vaillant 5490500",
    			"Vaillant 5491800",
    			"Vaillant 5495400",
    			"Vaillant 5499400",
    			"Vaillant 5600400",
    			"Vaillant 5602200",
    			"Vaillant 5602400",
    			"Vaillant 5602800",
    			"Vaillant 5617500",
    			"Vaillant 5636800",
    			"Vaillant 5647500",
    			"Vaillant 5704400",
    			"Vaillant 5706300",
    			"Vaillant 5711500",
    			"Vaillant 5715400",
    			"Vaillant 5719500",
    			"Vaillant 5720900",
    			"Vaillant 5721000",
    			"Vaillant 5722500",
    			"Vaillant 5722700",
    			"Vaillant 5722900",
    			"Vaillant 5723000",
    			"Vaillant 5726900",
    			"Vaillant 5727500",
    			"Vaillant 5728800",
    			"Vaillant 5743100",
    			"Vaillant 5743300",
    			"Vaillant 5743600",
    			"Vaillant 5743700",
    			"Vaillant 5744700",
    			"Vaillant 5744900",
    			"Vaillant 5745500",
    			"Vaillant 5901700",
    			"Vaillant 2000801948",
    			"Vaillant 2000801950",
    			"Vaillant A00540029",
    			"Vaillant A2032300",
    			"Vaillant H010005333",
    			"Vaillant H020003708",
    			"Vaillant H035003719",
    			"Vaillant H040006125",
    			"Vaillant H049003733",
    			"Vaillant S1008500",
    			"Vaillant S1018000",
    			"Vaillant S1020900",
    			"Vaillant S1035600",
    			"Vaillant S1036400",
    			"Vaillant S1043700",
    			"Vaillant S1051500",
    			"Vaillant S1053700",
    			"Vaillant S1065400",
    			"Vaillant S1069300",
    			"Vaillant S1073600",
    			"Vaillant S5261700",
    			"Vaillant S5461100",
    			"Vaillant 10003196",
    			"Vaillant 10005400",
    			"Vaillant 10009069",
    			"Vaillant 10009071",
    			"Vaillant 10009351",
    			"Vaillant 10012790",
    			"Vaillant 10018602",
    			"Vaillant 10019258",
    			"Vaillant 10019259",
    			"Vaillant 20014989",
    			"Vaillant 20015812",
    			"Vaillant 20023158",
    			"Vaillant 20025744",
    			"Vaillant 20030736",
    			"Vaillant 20030739",
    			"Vaillant 20032532",
    			"Vaillant 20042749",
    			"Vaillant 20050412",
    			"Vaillant 20059599",
    			"Vaillant 20060570",
    			"Vaillant 20064426",
    			"Vaillant 20065939",
    			"Vaillant 20067273",
    			"Vaillant 20068101",
    			"Vaillant 20075214",
    			"Vaillant 20075217",
    			"Vaillant 20087826",
    			"Vaillant 20093781",
    			"Vaillant 20099734",
    			"Vaillant 20108134",
    			"Vaillant 20112794",
    			"Vaillant 20112795",
    			"Vaillant 20114786",
    			"Vaillant 20115491",
    			"Vaillant 20137768",
    			"Vaillant 20140541",
    			"Vaillant 20160628",
    			"Vaillant 20165478",
    			"Vaillant 20175095",
    			"Vaillant 20175893",
    			"Vaillant 20191788",
    			"Vaillant 20212715",
    			"Vaillant 20212717",
    			"Vaillant 12950",
    			"Vaillant 40550",
    			"Vaillant 40898",
    			"Vaillant 82222",
    			"Vaillant 84059",
    			"Vaillant 89115",
    			"Vaillant 90564",
    			"Vaillant 90752",
    			"Vaillant 101122",
    			"Vaillant 114276",
    			"Vaillant 130363",
    			"Vaillant 140350",
    			"Vaillant 219622",
    			"Vaillant 251410",
    			"Vaillant 282537",
    			"Vaillant 282564",
    			"Vaillant 300867",
    			"Vaillant 302097",
    			"Vaillant 304818",
    			"Vaillant 304825",
    			"Vaillant 305950",
    			"Vaillant 306245",
    			"Vaillant 306708",
    			"Vaillant 306710",
    			"Vaillant 306711",
    			"Vaillant 307567",
    			"Vaillant 307578",
    			"Vaillant 310230",
    			"Vaillant 9139",
    			"Vaillant 9336",
    			"Vaillant 961249",
    			"Vaillant 981160",
    			"Vaillant 981306",
    			"XYLEM Water Solutions Austria VOGEL",
    			"XYLEM Water Solutions Austria 707934520S",
    			"XYLEM Water Solutions Austria MX14-1",
    			"XYLEM Water Solutions Austria 707310400XXXXO",
    			"XYLEM Water Solutions Austria 107271020",
    			"XYLEM Water Solutions Austria VOGEL",
    			"XYLEM Water Solutions Austria VOGEL",
    			"Rettig Austria F1E100600720000",
    			"Rettig Austria F1H110600401000",
    			"Rettig Austria F1E210601401000",
    			"Rettig Austria F1E210601601000",
    			"Rettig Austria F1E210600801000",
    			"Rettig Austria F1E220900401000",
    			"Rettig Austria F1H220501401000",
    			"Rettig Austria AZ1EH030B0001050",
    			"Rettig Austria F3KA111006000A00",
    			"Rettig Austria F37A018005000A00",
    			"Rettig Austria F37A018006000A00",
    			"Rettig Austria FVBGH26ZA",
    			"Rettig Austria D952-1023",
    			"Rettig Austria VONO",
    			"Rettig Austria VONO",
    			"Rettig Austria 1E111DC00",
    			"Rettig Austria CB1001000015000",
    			"Rettig Austria BROTHEFB20000A0",
    			"Rettig Austria F5TA018005000A00",
    			"Rettig Austria F5UE018006000A00",
    			"Rettig Austria BROTHETWITE2GAR9016",
    			"Rettig Austria Z0BS000F2001000",
    			"Rettig Austria Z0MS000C6001000",
    			"Rettig Austria F55E018006000000",
    			"Rettig Austria Z1TP00VV00010T0",
    			"Rettig Austria CF0010001011300",
    			"Rettig Austria CF1000010011300",
    			"Rettig Austria BROTHECE20000A0",
    			"Rettig Austria BGATOOL161700A0",
    			"Rettig Austria BRTOOLFB50111A0",
    			"Rettig Austria BHD4350084144A0",
    			"Rettig Austria BROTHEFB17000A0",
    			"Rettig Austria AX3RWOWEFNH01A0",
    			"Rettig Austria BIACLI1203DS0A0",
    			"Rettig Austria BVCFS07A63070A0",
    			"Rettig Austria F9015015516",
    			"Rettig Austria F9023030020",
    			"Rettig Austria F9023030008",
    			"Rettig Austria Z0MV000E0001000",
    			"Rettig Austria Z0MT000E3001000",
    			"Rettig Austria Z0BS000R2001000",
    			"Rettig Austria Z0BS000F2001000",
    			"Rettig Austria Z0VE00AD0001000",
    			"Viega 131050",
    			"Viega 101893",
    			"Viega 103224",
    			"Viega 120573",
    			"Viega VIEGA",
    			"Viega 102869",
    			"Viega 589530",
    			"Viega 103927",
    			"Viega 104917",
    			"Viega 103361",
    			"Viega 101718",
    			"Viega 111069",
    			"Viega 264321",
    			"Viega 271329",
    			"Villeroy & Boch 72080001",
    			"Villeroy & Boch 76821001",
    			"Villeroy & Boch 99610000",
    			"Villeroy & Boch 51336101",
    			"Villeroy & Boch 51428001",
    			"Villeroy & Boch 5142A001",
    			"Villeroy & Boch 5142A0R1",
    			"Villeroy & Boch 524400R1",
    			"Villeroy & Boch 533341R1",
    			"Villeroy & Boch 540000R2",
    			"Villeroy & Boch 560010R1",
    			"Villeroy & Boch 562810R1",
    			"Villeroy & Boch 613113R1",
    			"Villeroy & Boch 61366001",
    			"Villeroy & Boch 66001001",
    			"Villeroy & Boch 660010R1",
    			"Villeroy & Boch 7113F001",
    			"Villeroy & Boch 71196101",
    			"Villeroy & Boch 71226001",
    			"Villeroy & Boch 717580R1",
    			"Villeroy & Boch 73024L01",
    			"Villeroy & Boch 73154501",
    			"Villeroy & Boch 7315F0R1",
    			"Villeroy & Boch 76170101",
    			"Villeroy & Boch 7K221001",
    			"Villeroy & Boch 76231001",
    			"Villeroy & Boch 9955Q101",
    			"Villeroy & Boch 9M17S1R1",
    			"Villeroy & Boch 9M52S101",
    			"Villeroy & Boch 614300R1",
    			"Villeroy & Boch VB",
    			"Villeroy & Boch VB",
    			"Villeroy & Boch VB",
    			"Villeroy & Boch VB",
    			"Villeroy & Boch VB-WC SITZ",
    			"Villeroy & Boch VB",
    			"Villeroy & Boch 92240261",
    			"Villeroy & Boch U90950461",
    			"Villeroy & Boch VB",
    			"Villeroy & Boch VB",
    			"Villeroy & Boch VB",
    			"Villeroy & Boch 6714 1F R1",
    			"Villeroy & Boch 6790 00 R1",
    			"Villeroy & Boch 71046R01",
    			"Villeroy & Boch 85481000",
    			"Villeroy & Boch 923600LE",
    			"Villeroy & Boch 61365501",
    			"Villeroy & Boch 73093701",
    			"Villeroy & Boch 61613001",
    			"Villeroy & Boch 97510000",
    			"Villeroy & Boch 854570BM",
    			"Villeroy & Boch 56791001",
    			"Villeroy & Boch VB",
    			"Villeroy & Boch 9950.61 MAGNUM",
    			"Villeroy & Boch VB",
    			"Villeroy & Boch 8244.00 61",
    			"Villeroy & Boch VB",
    			"Villeroy & Boch VB",
    			"Villeroy & Boch LEUCHTMITTEL FÜR VBA33",
    			"Villeroy & Boch 9745 BM",
    			"Villeroy & Boch A695 00 FQ",
    			"Villeroy & Boch A816 00 PN FARBE:TERRA",
    			"Villeroy & Boch B124 L0 FQ",
    			"Villeroy & Boch B122 L0 FQ",
    			"Villeroy & Boch A926OZE1",
    			"Villeroy & Boch 514400R1",
    			"Villeroy & Boch 51540101",
    			"Villeroy & Boch 616310R1",
    			"Villeroy & Boch 9721AGBM",
    			"Villeroy & Boch UBA180SUB7V-01",
    			"Villeroy & Boch A373A000",
    			"Villeroy & Boch 411060R1",
    			"Villeroy & Boch 41625001",
    			"Villeroy & Boch 41626001",
    			"Villeroy & Boch A3733700",
    			"Villeroy & Boch 41766001",
    			"Villeroy & Boch 412761R1",
    			"Villeroy & Boch 5607R001",
    			"Villeroy & Boch 5607R0R1",
    			"Villeroy & Boch 7G061001",
    			"Villeroy & Boch 76031001",
    			"Villeroy & Boch 87470000",
    			"VitrA Bad 5662B003-0973",
    			"VitrA Bad 5663B003-0001",
    			"VitrA Bad 74-003-409",
    			"VitrA Bad 5165B003-0290",
    			"VitrA Bad 6663-XXX-0201",
    			"VitrA Bad 5091L003-1028",
    			"Ista 14110",
    			"Ista 59156",
    			"Ista 18662",
    			"Ista 31802",
    			"Ista 18392",
    			"Ista 14404",
    			"Ista 16095",
    			"Valpres 70500005",
    			"Valbia 82SR0018",
    			"Voss Edelstahlhandel 20401060320",
    			"Vola T34/16",
    			"Vola RB1/16",
    			"Vola VOLA",
    			"Vola VOLA",
    			"Vola VOLA",
    			"Vola VOLA",
    			"Vola VOLA",
    			"Vola VOLA",
    			"Vola VOLA",
    			"Vola VOLA",
    			"Vola BK3-16",
    			"Vola FS2 CHROM",
    			"Vola T1M/200-40",
    			"Vola 2500-40-02",
    			"Vola SC3-40-02",
    			"Vola VR1254+10",
    			"Vola KV1 27",
    			"Werit Vertriebsgesellschaft mb 96862004",
    			"Werit Vertriebsgesellschaft mb 144-9547000K",
    			"Simplex & Systeme G F10369",
    			"Simplex & Systeme G F11170*",
    			"Simplex & Systeme G 55103.05",
    			"Simplex & Systeme G F11171",
    			"Simplex & Systeme G 20400182",
    			"Simplex & Systeme G 6331G542",
    			"Simplex & Systeme G F10046",
    			"Simplex & Systeme G F70045",
    			"Simplex & Systeme G F70061",
    			"Simplex & Systeme G F70075",
    			"Simplex & Systeme G F55010",
    			"Simplex & Systeme G F71075",
    			"Simplex & Systeme G F10011",
    			"Simplex & Systeme G F10013",
    			"Simplex & Systeme G F10570",
    			"Simplex & Systeme G F10572",
    			"Simplex & Systeme G F10574",
    			"Simplex & Systeme G F10575",
    			"Simplex & Systeme G F10577",
    			"Wolf 8601870",
    			"Wavin Kunststoff-Rohrsysteme RSHCEUD1034",
    			"Wavin Kunststoff-Rohrsysteme RSHCZ16W2",
    			"Steyr-Werner 3200467",
    			"Wilo Pumpen 2511904",
    			"Wilo Pumpen 2109810",
    			"Wilo Pumpen WILO",
    			"Wilo Pumpen WILO",
    			"Wilo Pumpen 112163899",
    			"Wilo Pumpen 4440091",
    			"Wilo Pumpen 112046992",
    			"Wilo Pumpen 112047092",
    			"Wilo Pumpen 2090449",
    			"Wilo Pumpen 2069362",
    			"Wilo Pumpen 4094624",
    			"Wilo Pumpen 2004593",
    			"Wilo Pumpen 2011011",
    			"Wilo Pumpen 2136307",
    			"Wilo Pumpen 4215504",
    			"Wilo Pumpen 4104127",
    			"Wilo Pumpen 2097810",
    			"Wilo Pumpen 2097808",
    			"Wilo Pumpen 4090292",
    			"Wilo Pumpen 2046664",
    			"Wilo Pumpen 2120654",
    			"Wilo Pumpen 4104125",
    			"Wilo Pumpen 4090808",
    			"Wilo Pumpen 110624298",
    			"Wilo Pumpen 110851098",
    			"Wilo Pumpen 2060166",
    			"Wilo Pumpen 4440091",
    			"Wilo Pumpen 2120668",
    			"Flamco 12106",
    			"Flamco 12105",
    			"Flamco 12315",
    			"Flamco 10-338",
    			"Flamco 10-338-1",
    			"WimTec 123 395",
    			"WimTec 109818",
    			"WimTec 109788",
    			"WimTec 113419",
    			"WimTec 118780",
    			"WimTec 120271",
    			"WimTec 120288",
    			"WimTec 113907",
    			"WimTec 125061",
    			"WimTec 100204",
    			"WimTec 101850",
    			"WimTec 102093",
    			"WimTec 102826",
    			"WimTec 103052",
    			"WimTec 104417",
    			"WimTec 104424",
    			"WimTec 104486",
    			"WimTec 105162",
    			"WimTec 106190",
    			"WimTec 106862",
    			"WimTec 108798",
    			"WimTec 108859",
    			"WimTec 108866",
    			"WimTec 112269",
    			"WimTec 112337",
    			"WimTec 114584",
    			"WimTec 114614",
    			"WimTec 114737",
    			"WimTec 116021",
    			"WimTec 117745",
    			"WimTec 118681",
    			"WimTec 118698",
    			"WimTec 118889",
    			"WimTec 119008",
    			"WimTec 231496",
    			"WimTec 231564",
    			"WimTec 231908",
    			"WimTec 400175",
    			"WimTec 490107",
    			"Zrunek Gummiwaren 85-16-0039",
    			"Zehnder Group Deutschland SUBO-150-060",
    			"Zehnder Group Deutschland ZEHNDER-HANDTUCHHALTER",
    			"Zehnder Group Deutschland 775421",
    			"Zehnder Group Deutschland -",
    			"Zehnder Group Deutschland -",
    			"Zehnder Group Deutschland 819080",
    			"Zehnder Group Deutschland 832200",
    			"Zehnder Group Deutschland 870100",
    			"Zehnder Group Deutschland 871100",
    			"Zehnder Group Deutschland ZZ100245B100000",
    			"Ideal-Standard K725467",
    			"Ideal-Standard/Comfort K682901",
    			"Ideal-Standard/Comfort K682801",
    			"Ideal-Standard/Comfort K748001",
    			"Ideal-Standard/Comfort K748501",
    			"Oeag #",
    			"Oeag /",
    			"Oeag #",
    			"St Steeltrade Edelstahlhandel 311S212T",
    			"Airfit 50014 SK",
    			"Airfit 50225AS",
    			"Airfit 90003UZ",
    			"Alpha Bad EGOWTUGLF/EG = EICHE G",
    			"Schiedel 103686",
    			"Schiedel 105977",
    			"Schiedel 101782",
    			"Schiedel 106580",
    			"Schiedel 106538",
    			"Schiedel 105938",
    			"Schiedel 106496",
    			"Schiedel 106600",
    			"Schiedel 106221",
    			"Schiedel 106207",
    			"Schiedel 106437",
    			"Schiedel 101868",
    			"Esbe 13023700",
    			"Esbe 13040100",
    			"Esbe 16103800",
    			"Esbe 16103900",
    			"Esbe 16104000",
    			"Esbe 16104100",
    			"Esbe 17006940",
    			"Esbe 4390225612",
    			"Esbe 12602200",
    			"Esbe 66000400",
    			"Esbe 11602500",
    			"Esbe 11640500",
    			"Esbe 11620800",
    			"Esbe ESBE",
    			"Esbe ESBE",
    			"Esbe 11.60.12.00",
    			"Esbe 4390225012",
    			"Esbe 1390080512",
    			"Esbe 57000500",
    			"Esbe 43120200",
    			"Esbe 43120300",
    			"Esbe 43121200",
    			"Esbe 43121300",
    			"Eichler Flow Technology 1001600",
    			"Nikles Inter 3405/CF",
    			"Nikles Inter 48005/10CF",
    			"Nikles Inter BP400T05/CF",
    			"Nikles Inter B1505/CF",
    			"Nikles Inter S11.303.303.175.02.SL",
    			"NPI Sanitary Components 4080042",
    			"NPI Sanitary Components 4080046",
    			"HBH Wellness .",
    			"Mabo Steuerungselemente 101717",
    			"Busch + Kunz (Konsilager) 2221042033K",
    			"Busch + Kunz (Konsilager) 2211108060K",
    			"Busch + Kunz (Konsilager) 2212060042KHBW",
    			"Busch + Kunz (Konsilager) 2211076048K",
    			"Busch + Kunz (Konsilager) 1201033021H",
    			"Busch + Kunz (Konsilager) 1201048048H",
    			"Busch + Kunz (Konsilager) 1204060048HEN",
    			"Busch + Kunz (Konsilager) 1201076076H",
    			"Promiro s.r.o. 64163355",
    			"Heiz- und Sanitärtechnik SD90047",
    			"Heiz- und Sanitärtechnik YW9007",
    			"Heiz- und Sanitärtechnik YLY5009",
    			"Heiz- und Sanitärtechnik HAST-01",
    			"Heiz- und Sanitärtechnik SD90046",
    			"Giacomini R173X003",
    			"Giacomini R88IY003",
    			"Giacomini R88IY002",
    			"Crassus CRA10081",
    			"Indura A/S 881006",
    			"Indura A/S 625025",
    			"Galatea - R100/80W",
    			"BWT water+more 814413",
    			"Sonax 348100",
    			"Sonax 1334410",
    			"Inda SRL RV014A030",
    			"Inda SRL A04200CR",
    			"Inda SRL A05140CR",
    			"Inda SRL A33160CR",
    			"Inda SRL A38250CR",
    			"Inda SRL A4618CCR",
    			"Inda SRL A4618FCR",
    			"Dyson Austria 964691-01",
    			"Air Fire Tech Brandschutzsyste 2109161",
    			"Air Fire Tech Brandschutzsyste 9503063",
    			"Air Fire Tech Brandschutzsyste 1109100",
    			"Sasserath Hans 0315.15.000",
    			"Sasserath Hans 0323.15.906",
    			"Sasserath Hans 6628.00.919",
    			"Saint Gobain PAM 156912",
    			"Saint Gobain PAM SAINT GOBAIN",
    			"Saint Gobain PAM 156550",
    			"Saint Gobain PAM 155255",
    			"Saint Gobain PAM 155293",
    			"Saint Gobain PAM 155236",
    			"Saint Gobain PAM 155251",
    			"Saint Gobain PAM 157112",
    			"Reflex Austria 8253320",
    			"Reflex Austria 9251000",
    			"Reflex Austria 9251500",
    			"Reflex Austria 7363600",
    			"Reflex Austria 6940100",
    			"Reflex Austria 6811205",
    			"Zierath Günther ZIERATH",
    			"Schmidt Adolf 600378",
    			"Schmidt Adolf 450133",
    			"Schmidt Adolf 470636",
    			"Schmidt Adolf 887076",
    			"Schmidt Adolf 351126",
    			"Schmidt Adolf 180016",
    			"Schmidt Adolf 350006",
    			"Schmidt Adolf 351041",
    			"Schmidt Adolf 351089",
    			"Idrotherm 2000 01199*",
    			"Hot and Cold 2830.07.00",
    			"Hot and Cold 14110620",
    			"Hot and Cold 14200620",
    			"Hot and Cold 19761702",
    			"Hot and Cold 4752502",
    			"Hot and Cold 0189.04.10",
    			"Hot and Cold 0189.07.10",
    			"Hot and Cold 0189.05.10",
    			"Karasto Armaturenfabrik Oehler 860706",
    			"Karasto Armaturenfabrik Oehler 860713",
    			"Karasto Armaturenfabrik Oehler 860716",
    			"Karasto Armaturenfabrik Oehler 860711",
    			"E.C.E. 278-25",
    			"E.C.E. 6330-1515",
    			"E.C.E. STH2015",
    			"Fränkische Rohrwerke 78318016",
    			"Fränkische Rohrwerke 78318140",
    			"Steinberg 100 1010",
    			"Steinberg 100 1601",
    			"Steinberg 100 1687",
    			"Steinberg 100 1691",
    			"Steinberg 100 7900",
    			"Steinberg 120 1571",
    			"Steinberg 230 1670",
    			"Riposol 48245",
    			"TECE 660004660",
    			"TECE 650002660",
    			"GOK Regler u. 01 115 00",
    			"GOK Regler u. 04 436 00",
    			"GOK Regler u. 05 014 00",
    			"GOK Regler u. 07 150 00",
    			"GOK Regler u. 07 151 00",
    			"GOK Regler u. 07 152 00",
    			"GOK Regler u. 07 153 00",
    			"GOK Regler u. 07 190 10",
    			"GOK Regler u. 07 191 10",
    			"GOK Regler u. 07 192 10",
    			"GOK Regler u. 07 193 10",
    			"GOK Regler u. 07 701 00",
    			"GOK Regler u. 07 702 00",
    			"GOK Regler u. 07 703 00",
    			"GOK Regler u. 07 704 00",
    			"GOK Regler u. 07 707 00",
    			"GOK Regler u. 07 708 00",
    			"GOK Regler u. 07 709 00",
    			"GOK Regler u. 07 710 00",
    			"GOK Regler u. 07 780 00",
    			"GOK Regler u. 07 789 00",
    			"GOK Regler u. 07 791 00",
    			"GOK Regler u. 07 792 00",
    			"GOK Regler u. 07 793 00",
    			"GOK Regler u. 07 794 00",
    			"GOK Regler u. 07 795 00",
    			"GOK Regler u. 07 797 00",
    			"GOK Regler u. 07 798 00",
    			"GOK Regler u. 07 799 00",
    			"GOK Regler u. 08 092 00",
    			"GOK Regler u. 08 093 00",
    			"GOK Regler u. 08 095 00",
    			"GOK Regler u. 13 062 05",
    			"GOK Regler u. 13 063 05",
    			"GOK Regler u. 13 066 05",
    			"GOK Regler u. 13 067 05",
    			"radius-kelit 3090120",
    			"radius-kelit 38200502",
    			"radius-kelit 3820054",
    			"radius-kelit 3820042",
    			"radius-kelit 3820063",
    			"radius-kelit 3820038",
    			"radius-kelit 30301911",
    			"radius-kelit 3020525L",
    			"radius-kelit 3020535L",
    			"Watts 10001506",
    			"Watts 10001506",
    			"Watts 10017510",
    			"Watts 30090001",
    			"Watts 10004277",
    			"Watts 10004279",
    			"Watts 10004280",
    			"Watts 10004954",
    			"Watts 10004190",
    			"Watts 10004315",
    			"Watts 2040336",
    			"Watts 10030719",
    			"Watts 10002002",
    			"Watts 10010162",
    			"Watts 10009432",
    			"Watts 10009433",
    			"Watts 10017945",
    			"Watts 10015771",
    			"Watts 10015773",
    			"Watts 10015774",
    			"Watts 10015775",
    			"Watts 10002811",
    			"Watts 10002812",
    			"Watts 10002813",
    			"Watts 10028000",
    			"Watts 10028005",
    			"Watts 10028007",
    			"Watts 10028079",
    			"Steinbacher 104296-001",
    			"Steinbacher 104364-001",
    			"Steinbacher 104280-001",
    			"Steinbacher 104287-001",
    			"Steinbacher 103724-001",
    			"Steinbacher 103593-001",
    			"Herzbach 19.913800.1.09",
    			"Herzbach 10.145215.1.01",
    			"Herzbach 11.620224.1.01",
    			"Herzbach 11.646300.1.01",
    			"Herzbach 10.145321.1.01",
    			"Herzbach 10.145310.1.01",
    			"Herzbach 11.100100.1.09",
    			"Herzbach 14950860101",
    			"Herzbach 11.210500.1.09",
    			"Herzbach 11.725205.1.09",
    			"Herzbach 14.953100.1.01",
    			"Poloplast 4573",
    			"Poloplast 4090",
    			"Poloplast 4132",
    			"Poloplast 4415",
    			"Poloplast 3080",
    			"Poloplast 3077",
    			"Poloplast 8170",
    			"Poloplast 6271",
    			"Poloplast 6597",
    			"Poloplast 1184",
    			"NIOB FLUID s.r.o. 30010-053X1.5-24",
    			"Stögerer Christian e.U. 537861",
    			"Stögerer Christian e.U. 538428",
    			"WBF Wiedermann Brandschutz- 200310",
    			"WBF Wiedermann Brandschutz- 200510",
    			"WBF Wiedermann Brandschutz- 200310",
    			"WBF Wiedermann Brandschutz- 200309",
    			"Büsch spol. s.r.o. H13SV1711",
    			"EXMAR 708.1141.860.20",
    			"ChemRes 121035/12",
    			"WEMEFA Horst Christopeit 10-870",
    			"PLASTITALIA GE9P090C",
    			"PLASTITALIA GE4P090C.PF",
    			"Teufl Christian 618 721 060",
    			"Teufl Christian 618 721 064",
    			"Teufl Christian 618 723 150",
    			"Tricoflex SAS 80150000",
    			"Alfred Kirchmayr 61002",
    			"Alfred Kirchmayr 61004",
    			" 411563",
    			" TLI FT208/15",
    			" TLI FT208/20",
    			" TLI FT208/10",
    			" TLI MM092 1",
    			" TLI MM090 1",
    			" TLI 6042.32.0",
    			" TLI MM092 1/2",
    			" TLI MM090 1/2",
    			" TLI MM092 3/4",
    			" TLI MM090 3/4",
    			" TLI MM092 3/8",
    			" GA 400634",
    			" GA 400644",
    			" TLI MM270 1",
    			" TLI MM270 1/2",
    			" TLI MM270 3/4",
    			" TLI MM270 5/4",
    			" 400605",
    			" TLI MM240 5/4X1",
    			" TLI FT290/25",
    			" TLI FT207/15",
    			" TLI FT207/20",
    			" TLI FT207/10",
    			" SVS MM130 1",
    			" TLI MM130 1/2",
    			" TLI MM130 1X3/4 FFF",
    			" 400656",
    			" TLI MM130 3/4",
    			" TLI MM130 3/4X1/2FFF",
    			" 400654",
    			" TLIGP00112",
    			" SVS FP001 2",
    			" TLIGP00134",
    			" SVS FP001 5/4",
    			" TLIFC0021",
    			" TLIGP0021",
    			" TLIGP00212",
    			" SVS FP002 2",
    			" TLIFC00234",
    			" TLIGP00234",
    			" SVS FP002 5/4",
    			" TLIGP00264",
    			" TLIFC00212",
    			" TLI FC280 1",
    			" TLIGP2801",
    			" TLI FC280 1/2",
    			" SVS FP280 1/2",
    			" TLI FC280 2",
    			" TLIGP2802",
    			" TLIGP28025",
    			" TLIGP2803",
    			" TLI FC280 3/4",
    			" TLIGP28034",
    			" TLIFC28038",
    			" TLIGP28038",
    			" TLI FC280 5/4",
    			" TLIGP28054",
    			" TLI FC280 6/4",
    			" TLIGP28064",
    			" TLIGP245112",
    			" TLIGP245134",
    			" TLIGP2451238",
    			" SVSFC2451238",
    			" SVSFC245112",
    			" TLI FC245 1X3/4",
    			" TLIGP245254",
    			" TLIGP245254",
    			" TLIFC24521",
    			" TLIFC245254",
    			" TLIFC245264",
    			" TLIGP2453412",
    			" TLI FC245 3/4X1/2",
    			" TLIGP245541",
    			" TLIGP2455434",
    			" SVS FC245 5/4X1",
    			" SVSFC2455434",
    			" TLIGP245641",
    			" TLIGP2456454",
    			" SVSFC245641",
    			" SVSFC2456454",
    			" SVSFP5311",
    			" SVSFP53112",
    			" SVSFP53134",
    			" SVS FC330 1",
    			" TLIGP3301",
    			" SVSFC33012",
    			" TLIGP33012",
    			" TLIFC3302",
    			" TLIGP3302",
    			" SVSFC33034",
    			" TLIGP33034",
    			" SVSFC33054",
    			" TLIGP33054",
    			" SVSFC33064",
    			" TLIGP33064",
    			" SVS FC331 1",
    			" TLIGP3311",
    			" SVSFC33112",
    			" TLIGP33112",
    			" SVSFC3312",
    			" TLIGP3312",
    			" SVSFC33134",
    			" TLIGP33134",
    			" SVSFC33154",
    			" TLIGP33154",
    			" SVSFC33164",
    			" TLIGP33164",
    			" TLI FC090 1",
    			" TLIGP0901",
    			" TLIGP090R112",
    			" TLIGP090R134",
    			" TLI FC090 1/2",
    			" TLIGP09012",
    			" TLIFC090R112",
    			" TLIFC090R134",
    			" TLIFC0902",
    			" TLIGP0902",
    			" TLIGP0903",
    			" TLI FC090 3/4",
    			" TLIGP09034",
    			" TLIFP090R3412",
    			" TLIFC090R3412",
    			" TLIFC09038",
    			" TLIGP09038",
    			" TLI FC090 5/4",
    			" TLIGP09054",
    			" TLIFC090R541",
    			" TLI FC090 6/4",
    			" TLIGP09064",
    			" TLI FC092 1",
    			" TLIGP09038",
    			" TLI FC092 1/2",
    			" TLIGP09212",
    			" TLIFP09214",
    			" SVS FC092 2",
    			" TLIGP0922",
    			" TLI FC092 3/4",
    			" TLIGP09234",
    			" SVS FC092 3/8",
    			" TLIGP09238",
    			" TLI FC092 5/4",
    			" TLIGP09254",
    			" TLI FC092 6/4",
    			" TLIGP09264",
    			" TLIFC0951",
    			" TLIFP0951",
    			" TLIFP09512",
    			" TLIFC09534",
    			" TLIFP09534",
    			" TLIFC0971",
    			" TLIFP0971",
    			" TLIFC09712",
    			" TLIFP09712",
    			" TLIFC09734",
    			" TLIFP09734",
    			" TLI FP301 1/2",
    			" TLI FP301 3/4",
    			" SVS FP301 6/4",
    			" TLIGP18034",
    			" SVS FC270 1",
    			" TLIGP2701",
    			" TLI FC270 1/2",
    			" TLIGP27012",
    			" SVS FP270 1/4",
    			" TLIFC2702",
    			" TLIGP2702",
    			" TLI FC270 3/4",
    			" TLIGP27034",
    			" SVS FC270 3/8",
    			" SVS FP270 3/8",
    			" TLI FC270 5/4",
    			" TLIGP27054",
    			" TLIFC27064",
    			" TLIGP27064",
    			" TLIGP240134",
    			" TLIGP2401238",
    			" SVSFC2401238",
    			" SVSFC240112",
    			" TLIGP240112",
    			" SVS FC240 1X3/4",
    			" TLIGP240264",
    			" SVS FC240 2X1",
    			" SVSFC240254",
    			" SVSFC240264",
    			" TLIGP2403412",
    			" SVSFC2403412",
    			" TLI FC290 1",
    			" TLIGP2901",
    			" TLI FC290 1/2",
    			" TLIGP29012",
    			" TLIGP29025",
    			" SVS FC290 2",
    			" TLIGP2902",
    			" TLI FC290 3/4",
    			" TLIGP29034",
    			" TLIFC29038",
    			" TLI FP290 3/8",
    			" TLIFC29054",
    			" TLIGP29054",
    			" SVS FC290 6/4",
    			" TLIGP29064",
    			" TLIGP241112",
    			" TLIGP241134",
    			" TLIFP2411214",
    			" TLIFP2411218GC",
    			" TLIGP2411238",
    			" TLIFC2411214",
    			" TLIFC2411238",
    			" TLI FC241 1X1/2",
    			" TLI FC241 1X3/4",
    			" TLIGP24121",
    			" TLIGP241212",
    			" TLIGP241234",
    			" TLIGP241254",
    			" TLIGP241264",
    			" TLIGP241252",
    			" TLIFC241252",
    			" TLIFC24121",
    			" SVSFC241212",
    			" SVSFC241234",
    			" TLI FC130R541",
    			" TLIFC130R5434",
    			" TLIFC13064",
    			" TLIGP13064",
    			" TLIGP130R641",
    			" TLIGP130R6412",
    			" TLIFC130R6412",
    			" TLIFC130R641",
    			" TLIFC3001",
    			" TLIGP3001",
    			" TLIFC30012",
    			" TLIGP30012",
    			" TLIFC3002",
    			" TLIGP3002",
    			" TLIFC30034",
    			" TLIGP30034",
    			" TLIFC30054",
    			" TLIGP30054",
    			" TLIFC30064",
    			" TLIGP30064",
    			" SVS G12020",
    			" TLIFP12134",
    			" SVSFC24032",
    			" TLIGP240541",
    			" TLIGP2405434",
    			" SVSFC240541",
    			" SVSFC2405412",
    			" SVSFC2405434",
    			" TLIGP240641",
    			" TLIGP2406454",
    			" SVSFC240641",
    			" SVSFC2406412",
    			" SVSFC2406434",
    			" SVSFC2406454",
    			" SVSFC241254",
    			" SVSFC241264",
    			" TLIGP24132",
    			" TLIGP2413412",
    			" TLIFP2413438",
    			" TLI FC241 3/4X1/2",
    			" TLIGP241541",
    			" TLIGP2415412",
    			" TLIGP2415434",
    			" SVS FC241 5/4X1",
    			" SVSFC2415412",
    			" SVSFC2415434",
    			" TLIGP241641",
    			" TLIGP2416412",
    			" TLIGP2416434",
    			" TLIGP2416454",
    			" TLI FC241 6/4X1",
    			" SVSFC2416412",
    			" SVSFC2416434",
    			" 7771877",
    			" TLI FC130 1",
    			" TLIGP1301",
    			" SVS FP130 1X1/2",
    			" TLIGP130R134",
    			" TLI FC130 1/2",
    			" TLIGP13012",
    			" TLIFP13014",
    			" SVS FC130 1X3/4",
    			" TLIGP1302",
    			" TLIGP130R21",
    			" TLIGP130R212",
    			" TLIGP130R254",
    			" TLI FC130 3/4",
    			" TLIGP13034",
    			" TLIGP130R3412",
    			" SVSFC130R3412",
    			" TLIGP13038",
    			" TLIGP13054",
    			" SVSFC13054",
    			" TLIGP130R541",
    			" TLIGP130R5412",
    			" TLIGP130R5434",
    			" SVSFC130R5412",
    			" GR 95047562",
    			" GR 95047564",
    			" HE 1574650",
    			" HE 1651043",
    			" HE 1651045",
    			" HCRW1",
    			" HCRW2",
    			" HC54",
    			" HC55",
    			" T12C5935",
    			" HCWC-CON4",
    			" HCWC-CON1E/ HC380-F",
    			" HC36",
    			" HC13-LI",
    			" ALC APS1",
    			" SA102000",
    			" SA102010",
    			" HC250F",
    			" HC251-CP",
    			" HC31SFSX",
    			" HCWC17-110",
    			" ALC APV0003",
    			" ALC APV3344",
    			" HC15B",
    			" HC15",
    			" HC17",
    			" HC160-SS",
    			" HCUP40",
    			" HCUP50",
    			" ALC APV0800",
    			" HC23",
    			" 937243",
    			" HC252570B",
    			" HC2750LCPN",
    			" HC2734LCPN",
    			" AT7N30",
    			" ALC APV1321",
    			" ALCAPV2311",
    			" HC740FUN",
    			" ALC AGV1",
    			" HC47",
    			" HC50",
    			" VP40T",
    			" 5505240",
    			" HC14WM50",
    			" HC2P",
    			" HC37WCCON5",
    			" HC40E",
    			" HC4PF32SPS",
    			" HC4PFSSPS",
    			" HC1LJ",
    			" HC1LWM",
    			" HC740",
    			" HC7",
    			" HL 20",
    			" ABBEY6072",
    			" ALC APS3",
    			" HCWMEXTA",
    			" HC30",
    			" ALCAIZ1",
    			" HC22",
    			" ALC A432",
    			" TLI 0107020000 064",
    			" TLI 0107020000 054",
    			" TLI 0107020000 061",
    			" TLI 0107020000 067",
    			" TLI 0107020000 066",
    			" TLI 0107020000 063",
    			" TLI 0107020000 053",
    			" TLI 0107020000 052",
    			" TLI 0107020000 049",
    			" TLI 0107020000 087",
    			" TLI 0107020000 074",
    			" TLI 0107020000 060",
    			" TLI 0107020000 059",
    			" TLI 0107020000 056",
    			" TLI 0107020000 070",
    			" TLI 0107020000 071",
    			" TLI 0107020000 021",
    			" TLI 0107020000 019",
    			" TLI 0107020000 020",
    			" TLI 0107020000 022",
    			" ALCA45E",
    			" ALC A4000",
    			" ALC A431",
    			" NMCIPTCCB050500",
    			" NMCIPTCCB050700",
    			" NMCIPTCCB051000",
    			" NMCIPCCCB060221",
    			" NMCIPCCCB060351",
    			" NMCIPCCCB060181",
    			" NMCIPCCCB060281",
    			" NMCIPCCCB060151",
    			" KON18000100",
    			" KON 21010080",
    			" KON 21010100",
    			" KON 21010120",
    			" KON 21010140",
    			" KON21006060",
    			" KON 21008100",
    			" KON 21008120",
    			" KON 21008140",
    			" KON 21008050",
    			" KON 21008060",
    			" KON 21008080",
    			" KON23010100",
    			" KON23010080",
    			" KON23008100",
    			" KON23008040",
    			" KON23008060",
    			" KON23008080",
    			" TLI 22101000",
    			" TLI 22081000",
    			" KON 31400010",
    			" KON 31400012",
    			" KON31400016",
    			" KON31400006",
    			" KON 31400008",
    			" KON 24101730",
    			" KON 24081324",
    			" TLI 14800022",
    			" KON 14800028",
    			" KON24061018",
    			" KON24121936",
    			" TLI 22121000",
    			" KON81081010",
    			" KON13002023",
    			" KON13002530",
    			" TLI 32271820",
    			" KON25001008",
    			" KON 80512010",
    			" KON 80512008",
    			" KON31300010",
    			" KON31300012",
    			" KON31300006",
    			" KON31300008",
    			" KON 32283030",
    			" KON32283050",
    			" KON 12159168",
    			" KON 12006064",
    			" KON 12007278",
    			" KON 12008792",
    			" KON 12102116",
    			" KON 12121127",
    			" KON 12095103",
    			" KON13101106",
    			" KON13001719",
    			" KON13003138",
    			" KON13004046",
    			" KON 11001719",
    			" KON 11002023",
    			" KON 11002530",
    			" KON 11003138",
    			" KON 11004046",
    			" KON 11004853",
    			" KON21601054",
    			" KON21600854",
    			" KON13208018",
    			" KON13208022",
    			" KON13208028",
    			" KON13208015",
    			"BRAY und Antriebe 230250-110YZ387 + 010200-21150007",
    			"ARMAL 58-790-895REI-033",
    			"ARMAL 58-920-090REI-033",
    			"ARMAL 56-200-400REI-033",
    			"ARMAL 58-150-390REI-033",
    			"DUSAR 32428-024",
    			"DUSAR 91240-001",
    			"DUSAR 91214-001",
    			"DUSAR 91210-001",
    			"DUSAR 91212-001",
    			"DUSAR 30211-027",
    			"DUSAR 30212-027",
    			"DUSAR 30253-027",
    			"DUSAR 30254-027",
    			"DUSAR 30260-027",
    			"DUSAR 30258-027",
    			"DUSAR 32858-025",
    			"DUSAR 31444-024",
    			"DUSAR 32435-024",
    			"DUSAR 39042-092",
    			"DUSAR 92801-001",
    			"DUSAR 27279-027",
    			"DUSAR 27283-027",
    			"DUSAR 90940-999",
    			"Boagaz Vertriebsgesellschaft m M-0032966-V",
    			"Boagaz Vertriebsgesellschaft m M-0031860-V",
    			"Boagaz Vertriebsgesellschaft m M-0031870-V",
    			"Boagaz Vertriebsgesellschaft m M-0031878-V",
    			"Boagaz Vertriebsgesellschaft m M-0031881-V",
    			"Boagaz Vertriebsgesellschaft m M-0031882-V",
    			"Boagaz Vertriebsgesellschaft m M-0036370-V",
    			"Boagaz Vertriebsgesellschaft m M-0031959-V",
    			"Boagaz Vertriebsgesellschaft m M-0031958-V",
    			"Boagaz Vertriebsgesellschaft m M-0031861-V",
    			"Boagaz Vertriebsgesellschaft m M-0031863-V",
    			"Boagaz Vertriebsgesellschaft m M-0040526-V",
    			"Boagaz Vertriebsgesellschaft m M-0038296-V",
    			"Boagaz Vertriebsgesellschaft m M-0038297-V",
    			"Boagaz Vertriebsgesellschaft m M-0038298-V",
    			"Boagaz Vertriebsgesellschaft m M-0038299-V",
    			"Boagaz Vertriebsgesellschaft m M-0041435-V",
    			"Boagaz Vertriebsgesellschaft m M-0041145-V",
    			"Boagaz Vertriebsgesellschaft m M-0041493-V",
    			"Boagaz Vertriebsgesellschaft m M-0041495-V",
    			"Boagaz Vertriebsgesellschaft m K-0037000-V",
    			"Boagaz Vertriebsgesellschaft m M-0031962-V",
    			"Boagaz Vertriebsgesellschaft m M-0031964-V",
    			"Boagaz Vertriebsgesellschaft m M-0032967-V",
    			"Boagaz Vertriebsgesellschaft m M-0042757-V",
    			"Boagaz Vertriebsgesellschaft m M-0031871-V",
    			"Boagaz Vertriebsgesellschaft m M-0031872-V",
    			"Boagaz Vertriebsgesellschaft m M-0042410-V",
    			"Boagaz Vertriebsgesellschaft m M-0042411-V",
    			"Boagaz Vertriebsgesellschaft m M-0042745-V",
    			"Boagaz Vertriebsgesellschaft m M-0042754-V",
    			"Boagaz Vertriebsgesellschaft m M-0030001-V",
    			"Boagaz Vertriebsgesellschaft m M-0038300-V",
    			"Boagaz Vertriebsgesellschaft m M-0038301-V",
    			"DUSAR 27247-027",
    			"DUSAR 27246-027",
    			"DUSAR 38701-024",
    			"DUSAR 36021-001",
    			"DUSAR 36040-098",
    			"iWater Wassertechnikg & C 10202",
    			"iWater Wassertechnikg & C 10288",
    			"iWater Wassertechnikg & C 72315",
    			"iWater Wassertechnikg & C 72316",
    			"iWater Wassertechnikg & C 72182+72184",
    			"iWater Wassertechnikg & C CL91023",
    			"iWater Wassertechnikg & C CL91025",
    			"ABA-BEUL GES.MBH. 15066.006.2",
    			"ABA-BEUL GES.MBH. 15066.003.2",
    			"ABA-BEUL GES.MBH. 15065.003.2",
    			"ALLIBERT DIVISION HABITAT M17987.11",
    			"ALLIBERT DIVISION HABITAT ALLIBERT",
    			"ALLIBERT DIVISION HABITAT 37424",
    			"ALLIBERT DIVISION HABITAT M14416.11",
    			"ALLIBERT DIVISION HABITAT M14437.11",
    			"ALLIBERT DIVISION HABITAT M14590.11",
    			"ALLIBERT DIVISION HABITAT M14591.11",
    			"ALLIBERT DIVISION HABITAT M14621.04",
    			"ALLIBERT DIVISION HABITAT M14622.04",
    			"ALLIBERT DIVISION HABITAT M14623.03",
    			"ALLIBERT DIVISION HABITAT M14623.04",
    			"ALLIBERT DIVISION HABITAT M14628.11",
    			"ALLIBERT DIVISION HABITAT M14631.11",
    			"ALLIBERT DIVISION HABITAT M14634.04",
    			"ALLIBERT DIVISION HABITAT M14635.F2",
    			"ALLIBERT DIVISION HABITAT M14636.F2",
    			"ALLIBERT DIVISION HABITAT M14638.F1",
    			"ALLIBERT DIVISION HABITAT M14638.F2",
    			"ALLIBERT DIVISION HABITAT M14650.00",
    			"ALLIBERT DIVISION HABITAT M14651.G2",
    			"ALLIBERT DIVISION HABITAT M14653.G2",
    			"ALLIBERT DIVISION HABITAT M14667.43",
    			"ALLIBERT DIVISION HABITAT M14668.G1",
    			"ALLIBERT DIVISION HABITAT M14671.G2",
    			"ALLIBERT DIVISION HABITAT M14672.43",
    			"ALLIBERT DIVISION HABITAT M17970.11",
    			"ALLIBERT DIVISION HABITAT M17987.11",
    			"ALLIBERT DIVISION HABITAT M35178.11",
    			"ALLIBERT DIVISION HABITAT M14646.C1",
    			"ALLIBERT DIVISION HABITAT M30924.CH",
    			"ALLIBERT DIVISION HABITAT M30921.11",
    			"ALLIBERT DIVISION HABITAT M30964.CE",
    			"ALLIBERT DIVISION HABITAT M30928.CH",
    			"ALLIBERT DIVISION HABITAT M30929.CH",
    			"ALLIBERT DIVISION HABITAT M30923.11",
    			"ALLIBERT DIVISION HABITAT M30960.CE",
    			"ALLIBERT DIVISION HABITAT M30965.CE",
    			"ALLIBERT DIVISION HABITAT M30973.11",
    			"ALLIBERT DIVISION HABITAT M14668.BE",
    			"ALLIBERT DIVISION HABITAT M14651.BE",
    			"ALLIBERT DIVISION HABITAT M14652.BE",
    			"ALLIBERT DIVISION HABITAT M14654.BE",
    			"ALLIBERT DIVISION HABITAT M14595.W1",
    			"ALLIBERT DIVISION HABITAT M14596.W1",
    			"ALLIBERT DIVISION HABITAT M17977.11",
    			"ALLIBERT DIVISION HABITAT M1921441",
    			"ALLIBERT DIVISION HABITAT M1921341",
    			"ALLIBERT DIVISION HABITAT M1921541",
    			"ALLIBERT DIVISION HABITAT M1921241",
    			"ALLIBERT DIVISION HABITAT M1921141",
    			"ALLIBERT DIVISION HABITAT M14207.11",
    			"Elite Sanitär Rotter & Rotter 409",
    			"Elite Sanitär Rotter & Rotter 46",
    			"BISK 283",
    			"BISK 90302",
    			"BISK 39",
    			"BISK 15200",
    			"BISK 7",
    			"BISK 42",
    			"BISK 43",
    			"BISK 46",
    			"BISK 48",
    			"BISK 56",
    			"BISK 15320",
    			"BISK 15400",
    			"BISK 15420",
    			"BISK 15520",
    			"BISK 15720",
    			"BISK 16300",
    			"BISK 26312",
    			"BISK 26412",
    			"BISK 26512",
    			"BISK 26612",
    			"BISK 27312",
    			"BISK 40242",
    			"BISK 40254",
    			"BISK 40342",
    			"BISK 40354",
    			"BISK 40442",
    			"BISK 40454",
    			"BISK 40542",
    			"BISK 40554",
    			"BISK 40742",
    			"BISK 40754",
    			"BISK 71551",
    			"BISK 71526",
    			"BISK 71525",
    			"BISK 71675",
    			"BISK 71726",
    			"BISK 71725",
    			"BISK 71651",
    			"BISK 71650",
    			"BISK 71451",
    			"BISK 71625",
    			"BISK 71626",
    			"BISK 71426",
    			"BISK 71425",
    			"BISK 226",
    			"BISK 227",
    			"BISK 216",
    			"BISK 214",
    			"BISK 213",
    			"BISK 218",
    			"BISK 211",
    			"BISK 228",
    			"BISK 222",
    			"BISK 72130",
    			"BISK 15600",
    			"BISK 8",
    			"BISK 9",
    			"BISK 730",
    			"BISK 720",
    			"BISK 725",
    			"BISK 740",
    			"BISK 745",
    			"BISK 750",
    			"BISK 755",
    			"BISK 765",
    			"BISK 770",
    			"BISK 71925",
    			"BISK 85",
    			"BISK 122",
    			"BISK 79701",
    			"BISK 79715",
    			"BISK 79713",
    			"BISK 79714",
    			"BISK 79707",
    			"BISK 79709",
    			"BISK 79710",
    			"BISK 79711",
    			"BISK 79703",
    			"BISK 79706",
    			"BISK 79717",
    			"BISK 72088",
    			"BISK 324",
    			"BISK 507",
    			"BISK 181",
    			"BISK 278",
    			"BISK 305",
    			"BISK 300",
    			"BISK 1458",
    			"BISK 1459",
    			"BISK 356",
    			"BISK 349",
    			"BISK 1177",
    			"BISK 1176",
    			"BISK 1183",
    			"BISK 1182",
    			"BISK 1175",
    			"BISK 1174",
    			"BISK 1173",
    			"BISK 1180",
    			"BISK 1181",
    			"BISK 1178",
    			"FABRICA CERAMIKA 18351002",
    			"FABRICA CERAMIKA 18361002",
    			"JACUZZI FRANCE OLBIASGL",
    			"JACUZZI FRANCE 3323",
    			"JACUZZI FRANCE VOLGA2SNL",
    			"JACUZZI FRANCE THEOS2SCAP",
    			"JACUZZI FRANCE ESPM9SA",
    			"JACUZZI FRANCE SCHUERZE",
    			"JACUZZI FRANCE SCHUERZE",
    			"JACUZZI FRANCE EPU2SGAB",
    			"JACUZZI FRANCE ESPMBMPA",
    			"JACUZZI FRANCE PPF8SCL",
    			"JACUZZI FRANCE PPF9SCL",
    			"JACUZZI FRANCE PASSIOPORSCTAP",
    			"JACUZZI FRANCE NPB1SCAP",
    			"JACUZZI FRANCE EARI1T102",
    			"JACUZZI FRANCE PICTGALABD",
    			"JACUZZI FRANCE PICTGALABG",
    			"JACUZZI FRANCE PICTLOVABD",
    			"JACUZZI FRANCE PICTLOVABG",
    			"JACUZZI FRANCE PICTNUEABD",
    			"JACUZZI FRANCE PICTNUEABG",
    			"JACUZZI FRANCE EALM2SCTABG",
    			"JACUZZI FRANCE EALM2SCTABD",
    			"ECO Edletzberger 40160176",
    			"ECO Edletzberger 7111017",
    			"ECO Edletzberger 6910001",
    			"EURASPIEGEL HANDELSGMBH 400026",
    			"EH-TRADING HANDELS PR1000",
    			"EH-TRADING HANDELS ISO300",
    			"EH-TRADING HANDELS ISO1500",
    			"EH-TRADING HANDELS ISO2000",
    			"EH-TRADING HANDELS 434186",
    			"EH-TRADING HANDELS 404183",
    			"INDA AUSTRIA (FRISO) A0467NCR",
    			"INDA AUSTRIA (FRISO) A4618CCR",
    			"INDA AUSTRIA (FRISO) AV4280CR",
    			"INDA AUSTRIA (FRISO) AV051ACR",
    			"INDA AUSTRIA (FRISO) A51150CR",
    			"INDA AUSTRIA (FRISO) A0494CCR",
    			"INDA AUSTRIA (FRISO) A38270CR",
    			"GEO-TEC 14002011",
    			"GEO-TEC 13100302",
    			"LINEABETA 5544.29",
    			"LINEABETA 5276.81",
    			"LINEABETA 52801.09",
    			"LINEABETA 52801.29",
    			"LINEABETA 52802.09",
    			"LINEABETA SHT-52806.29",
    			"LINEABETA 52818.29",
    			"LINEABETA 52826.29",
    			"LINEABETA 52836.29",
    			"LINEABETA 7005.60",
    			"LINEABETA 665811.29.30",
    			"INTEND 537824",
    			"INTEND 516606",
    			"INTEND 514008",
    			"INTEND 125581",
    			"INTEND 507174",
    			"INTEND .",
    			"INTEND BLANCO",
    			"INTEND 538301",
    			"IP ART:359425",
    			"IP HF 703/50",
    			"IDEAL STANDARD JADO",
    			"IDEAL STANDARD JADO",
    			"IDEAL STANDARD JADO",
    			"IDEAL STANDARD JADO",
    			"IDEAL STANDARD JADO",
    			"IDEAL STANDARD F1334AA",
    			"IDEAL STANDARD F1357AA",
    			"MOBIHEAT MHLE20",
    			"MAXXXCOMFORT H00005",
    			"MAXXXCOMFORT H12850",
    			"KROBATH AXP70061",
    			"UPONOR 4780120",
    			"UPONOR 4782733",
    			"UPONOR 4782782",
    			"UPONOR 4782761",
    			"UPONOR 4782765",
    			"UPONOR 4783247",
    			"UPONOR 4783051",
    			"UPONOR 4786020",
    			"UPONOR 4784104",
    			"UPONOR VELTA",
    			"UPONOR 1005376",
    			"UPONOR VELTA",
    			"UPONOR VELTA",
    			"UPONOR 4780733",
    			"UPONOR 1046565",
    			"UPONOR 1046565",
    			"UPONOR 4560022",
    			"UPONOR 4782793",
    			"UPONOR 4783345",
    			"UPONOR 1000136",
    			"UPONOR 4762743",
    			"UPONOR 4160030",
    			"UPONOR 4281012",
    			"UPONOR 4782798",
    			"UPONOR 4782663",
    			"UPONOR 1000081",
    			"UPONOR 1000111",
    			"UPONOR 1000131",
    			"UPONOR 4261225",
    			"UPONOR 1013398",
    			"UPONOR 1013401",
    			"UPONOR 1013453",
    			"UPONOR 1013455",
    			"UPONOR 1013147",
    			"UPONOR 1013140",
    			"UPONOR 1014621",
    			"UPONOR 1015011",
    			"UPONOR 1015033",
    			"UPONOR 1015057",
    			"UPONOR 1015131",
    			"UPONOR 1015142",
    			"UPONOR 1015245",
    			"UPONOR 1014607",
    			"UPONOR 1007081",
    			"UPONOR 1015190",
    			"UPONOR 1015208",
    			"UPONOR 1015168",
    			"UPONOR 1010416",
    			"UPONOR 1010412",
    			"UPONOR 1015435",
    			"UPONOR 1015469",
    			"UPONOR 1015519",
    			"UPONOR 1015665",
    			"UPONOR 1015418",
    			"UPONOR 1015401",
    			"UPONOR 1015395",
    			"UPONOR 1015397",
    			"UPONOR 1015539",
    			"UPONOR 1014070",
    			"UPONOR 1006638",
    			"UPONOR 1015808",
    			"UPONOR 1013734",
    			"UPONOR 1013794",
    			"UPONOR 1007084",
    			"UPONOR 1007085",
    			"UPONOR 1007087",
    			"UPONOR 1007088",
    			"UPONOR 1015768",
    			"UPONOR 1012967",
    			"UPONOR 1012969",
    			"UPONOR 1000087",
    			"UPONOR 1000540",
    			"UPONOR 1007179",
    			"UPONOR 1013063",
    			"UPONOR 1013070",
    			"UPONOR 1005048",
    			"UPONOR 1005107",
    			"UPONOR 1005152",
    			"UPONOR 1005190",
    			"UPONOR 1005215",
    			"UPONOR 1005217",
    			"UPONOR 1005220",
    			"UPONOR 1005224",
    			"UPONOR 1005238",
    			"UPONOR 1005241",
    			"UPONOR 1005248",
    			"UPONOR 1005285",
    			"UPONOR 1005317",
    			"UPONOR 1005325",
    			"UPONOR 1005330",
    			"UPONOR 1005331",
    			"UPONOR 1005364",
    			"UPONOR 1005367",
    			"UPONOR 1005484",
    			"UPONOR 1005582",
    			"UPONOR 1005584",
    			"UPONOR 1005585",
    			"UPONOR 1006050",
    			"UPONOR 1006330",
    			"UPONOR 1006336",
    			"UPONOR 1006339",
    			"UPONOR 1006360",
    			"UPONOR 1013051",
    			"UPONOR 1018238",
    			"UPONOR 1018308",
    			"UPONOR 1030631",
    			"UPONOR 4911014",
    			"UPONOR 1005921",
    			"UPONOR 1029127",
    			"UPONOR 1029139",
    			"UPONOR 1029143",
    			"UPONOR 1029146",
    			"UPONOR 1042981",
    			"UPONOR 1045481",
    			"UPONOR 1006323*",
    			"UPONOR 1047002",
    			"UPONOR 1046750",
    			"UPONOR 1046751",
    			"UPONOR 1046477",
    			"UPONOR 1046478",
    			"UPONOR 1046904",
    			"UPONOR 1046909",
    			"UPONOR 1046912",
    			"UPONOR 1046924",
    			"UPONOR 1046925",
    			"UPONOR 1046937",
    			"UPONOR 1048319",
    			"UPONOR 1048291",
    			"UPONOR 1016700",
    			"UPONOR 1030134",
    			"UPONOR 1030135",
    			"UPONOR 1045813",
    			"UPONOR 1045816",
    			"UPONOR 1001327",
    			"UPONOR 1005236",
    			"UPONOR 1006632",
    			"UPONOR 1042922",
    			"UPONOR 1058662",
    			"UPONOR 1048566",
    			"UPONOR 1048567",
    			"UPONOR 1048569",
    			"UPONOR 1048570",
    			"UPONOR 1048571",
    			"UPONOR 1048581",
    			"UPONOR 1048584",
    			"UPONOR 1048548",
    			"UPONOR 1048549",
    			"UPONOR 1048600",
    			"UPONOR 1048591",
    			"UPONOR 1048551",
    			"UPONOR 1048552",
    			"UPONOR 1048554",
    			"UPONOR 1048557",
    			"UPONOR 1048556",
    			"UPONOR 1048577",
    			"UPONOR 1048542",
    			"UPONOR 1048543",
    			"UPONOR 1048544",
    			"UPONOR 1048545",
    			"UPONOR 1048546",
    			"UPONOR 1048603",
    			"UPONOR 1048596",
    			"UPONOR 1048597",
    			"UPONOR 1048606",
    			"UPONOR 1057847",
    			"UPONOR 1058304",
    			"UPONOR 1058425",
    			"UPONOR 1059402",
    			"UPONOR 1060097",
    			"UPONOR 1001229",
    			"UPONOR 1062889",
    			"UPONOR 1063381",
    			"UPONOR 1063324",
    			"UPONOR 1063781",
    			"UPONOR 1063112",
    			"UPONOR 1063292",
    			"UPONOR 4170001",
    			"UPONOR 1065296",
    			"UPONOR 1083610",
    			"UPONOR 1083646",
    			"UPONOR 1071652",
    			"UPONOR 1071685",
    			"UPONOR 1071646",
    			"UPONOR 1059577",
    			"UPONOR 1086614",
    			"UPONOR 1022632",
    			"LUXOR INTERCHEM 860",
    			"BayWa r.e Solar Energy Systems 214089B",
    			"BayWa r.e Solar Energy Systems 210043B",
    			"Mepa -Pauli und Menden 716935",
    			"Mepa -Pauli und Menden 150224",
    			"Mepa -Pauli und Menden 150214",
    			"MDC NV BCV-001",
    			"MDC NV KLE-001",
    			"MOBILTESINO S1511",
    			"MOBILTESINO B1563",
    			"MOBILTESINO MOBILTESINO S.R.L.",
    			"Neher LWS600-1200/2100",
    			"Neher LFTWS600-1200/2100",
    			"Neher NNE28018BA",
    			"Neher .",
    			"Neher .",
    			"Neher .",
    			"Neher .",
    			"Neher .",
    			"Neher .",
    			"Neher .",
    			"Neher .",
    			"Neher .",
    			"Neher .",
    			"Neher .",
    			"Neher .",
    			"Neher .",
    			"Neher .",
    			"PREIS 10068",
    			"PREIS 10083",
    			"PREIS 18242",
    			"PREIS 19973",
    			"PREIS 18407",
    			"PREIS 19999",
    			"PREIS 19992",
    			"PREIS 19994",
    			"PREIS 19996",
    			"PREIS 21859",
    			"PREIS 18244",
    			"PREIS 18245",
    			"PREIS 11304",
    			"PREIS 22139",
    			"PREIS 12984",
    			"PREIS 20905",
    			"PREIS 24349",
    			"PREIS 10045",
    			"RUSCH FRIEDRICH GMBH. 7027B",
    			"RUSCH FRIEDRICH GMBH. 7007A+7022",
    			"RUSCH FRIEDRICH GMBH. 7023A",
    			"RUSCH FRIEDRICH GMBH. 7025A",
    			"RUSCH FRIEDRICH GMBH. 7024",
    			"RUSCH FRIEDRICH GMBH. 7001C",
    			"RUSCH FRIEDRICH GMBH. 7020A",
    			"SANI ACRYLIC 11075020137101",
    			"SANI ACRYLIC 11075030279101",
    			"SANI ACRYLIC 11075030245101",
    			"MB 60530120",
    			"MB 60705024",
    			"ÖKOSOLAR PV 403923",
    			"Dummy .",
    			"Dummy .",
    			"Dummy DOMO SANIFER",
    			"Dummy EA 180DB",
    			"Dummy ISAKL 125",
    			"Dummy ISOBO 45125",
    			"Dummy ISOBO 90125",
    			"Dummy ISORO 125",
    			"Dummy PANASONIC",
    			"Dummy BÄDERPARADIES",
    			"Dummy PRISMA",
    			"Dummy SANIMEISTER",
    			"Dummy WANNINGER",
    			"Dummy BÄDERPARADIES",
    			"Dummy PRISMA",
    			"Dummy SANIMEISTER",
    			"Dummy PRISMA",
    			"Dummy PRISMA",
    			"Dummy WANNINGER",
    			"Dummy SANIMEISTER",
    			"Dummy PASSION",
    			"MS SCHWARZ 35VS6464",
    			"SEBALD .",
    			"SEBALD .",
    			"SEBALD .",
    			"SEBALD .",
    			"SEBALD .",
    			"SOLER & PALAU 18AKB75-30",
    			"SOLER & PALAU 26FKDÜ60200",
    			"SOLER & PALAU 01MFR-355/400F5",
    			"SOLER & PALAU 05CD2100160",
    			"ROSSWEINER 1278601",
    			"SANIPA BADEINRICHTUNG MO2304FL/R",
    			"SANIPA BADEINRICHTUNG MO3134F",
    			"Beiler & Pretner 195349841",
    			"Beiler & Pretner 195349844",
    			"Beiler & Pretner 1953499843",
    			"Beiler & Pretner 1953499846",
    			"VALVULAS ARCO S.L. 1STAR",
    			"PLUGGIT FI530",
    			"PLUGGIT RS150-200",
    			"PLUGGIT YS150-150-150",
    			"PLUGGIT BO090-200",
    			"PLUGGIT BS090-200",
    			"PLUGGIT SL180",
    			"PLUGGIT IPP180",
    			"PLUGGIT IPPBO180-45",
    			"PLUGGIT IPPV180",
    			"PLUGGIT EA150K",
    			"PLUGGIT EVWS3",
    			"PLUGGIT BO080-150",
    			"PLUGGIT WH180",
    			"PLUGGIT TS180",
    			"PLUGGIT RS185",
    			"PLUGGIT VS080",
    			"PLUGGIT VS150",
    			"PLUGGIT SWT180",
    			"PLUGGIT GTCBO",
    			"PLUGGIT GTCTS",
    			"PLUGGIT GTCKK",
    			"PLUGGIT SD180-P",
    			"PLUGGIT APFS1",
    			"PLUGGIT APFG4-180",
    			"PLUGGIT APFB1",
    			"PLUGGIT RHPK150",
    			"PLUGGIT RKO150",
    			"PLUGGIT TS150-150-150",
    			"PLUGGIT YS200-150-150",
    			"PLUGGIT PPE",
    			"PLUGGIT PPD",
    			"PLUGGIT SD100D",
    			"PLUGGIT BR150",
    			"PLUGGIT PGR75",
    			"PLUGGIT AP460",
    			"PLUGGIT AD160",
    			"PLUGGIT APSB460",
    			"PLUGGIT APHR190",
    			"PLUGGIT APHR310",
    			"PLUGGIT APVN460",
    			"PLUGGIT ESTT150",
    			"PLUGGIT PL201",
    			"PLUGGIT IPPS125",
    			"PLUGGIT APFF",
    			"PLUGGIT APFG4F7-460",
    			"PLUGGIT EK75",
    			"PLUGGIT PL136",
    			"Panasonic ACXA73C03210R",
    			"Panasonic ACXA73C06260R",
    			"Panasonic WH-SXC12F9E8",
    			"Panasonic WH-SDC07F3E5",
    			"Panasonic WH-UD07FE5",
    			"Panasonic WH-SDC09F3E8",
    			"Panasonic WH-SDC12F9E8",
    			"Panasonic WH-SDC16F9E8",
    			"Panasonic WH-UD16FE8",
    			"Panasonic WH-SHF09F3E8",
    			"Panasonic WH-UH09FE8",
    			"Panasonic WH-SHF12F9E8",
    			"Panasonic WH-UH12FE8",
    			"Panasonic PAW-HPM1",
    			"Panasonic PAW-HPMINT-F",
    			"Panasonic PAW-HPMAH1",
    			"Panasonic PAW-HPMB1",
    			"Panasonic PAW-HPMDHW",
    			"Panasonic PAW-HPMR4",
    			"Panasonic PAW-LANCABLE",
    			"Panasonic PAW-FILTER",
    			"Panasonic WH-UD09FE5",
    			"Panasonic WH-SDC09F3E5",
    			"Panasonic CS-MRE12PKE",
    			"Panasonic PAW-DHWM300ZC",
    			"Panasonic PAW-HPMED",
    			"Panasonic CU-TZ9SKE",
    			"Panasonic CS-TZ12SKEW",
    			"Panasonic CU-TZ12SKE",
    			"Panasonic CU-Z9SKE",
    			"Panasonic CU-Z12SKE",
    			"Panasonic CU-Z15SKE",
    			"Panasonic CU-Z18SKE",
    			"Panasonic CS-MTZ7SKE",
    			"OSTACO 2231238000",
    			"PROFI TRADE Handels 172005",
    			"PROFI TRADE Handels 172009",
    			"PROFI TRADE Handels 172109",
    			"PROFI TRADE Handels 172211",
    			"PROFI TRADE Handels 172305",
    			"PROFI TRADE Handels 172311",
    			"PROFI TRADE Handels 173109",
    			"PROFI TRADE Handels 172409",
    			"PROFI TRADE Handels 172605",
    			"PROFI TRADE Handels 172611",
    			"PROFI TRADE Handels 172705",
    			"PROFI TRADE Handels 172805",
    			"PROFI TRADE Handels 172809",
    			"PROFI TRADE Handels 172811",
    			"PROFI TRADE Handels 173305",
    			"PROFI TRADE Handels 173307",
    			"PROFI TRADE Handels 173311",
    			"PROFI TRADE Handels 100506",
    			"PROFI TRADE Handels 100514",
    			"PROFI TRADE Handels 100530",
    			"PROFI TRADE Handels 100609",
    			"PROFI TRADE Handels 100612",
    			"PROFI TRADE Handels 100709",
    			"PROFI TRADE Handels 100712",
    			"PROFI TRADE Handels 101508",
    			"PROFI TRADE Handels 101511",
    			"PROFI TRADE Handels 100808",
    			"PROFI TRADE Handels 100816",
    			"PROFI TRADE Handels 100908",
    			"PROFI TRADE Handels 100912",
    			"PROFI TRADE Handels 101108",
    			"PROFI TRADE Handels 101112",
    			"PROFI TRADE Handels 101151",
    			"PROFI TRADE Handels 101308",
    			"PROFI TRADE Handels 101311",
    			"PROFI TRADE Handels 105114",
    			"PROFI TRADE Handels 10722002V",
    			"PROFI TRADE Handels 175843",
    			"PROFI TRADE Handels 176125",
    			"PROFIBOX 44120105001",
    			"PROFIBOX 5220205000",
    			"PROFIBOX PBWTAS2.M.20.RM.U",
    			"PROFIBOX 5120205000",
    			"PROFIBOX 3120205000",
    			"PROFIBOX PBWC.M.20.ME",
    			"PROFIBOX PBFW.M.K.ME.OUS",
    			"PROFIBOX PBST.T.20.VR.U",
    			"PROFIBOX PBWDU.M.20.ME",
    			"PROFIBOX PBWDU.T.20.KO5",
    			"PROFIBOX .",
    			"PROFIBOX 6220034000",
    			"PROFIBOX 010010T20RA---7",
    			"PROFIBOX 001000M20HEUM37",
    			"PROFIBOX 003001M20HEUM37",
    			"PROFIBOX 005006M20HEU--7",
    			"PROFIBOX 006001M20HEUM37",
    			"PROFIBOX 001000T20KEONG7",
    			"PROFIBOX 001000T16KEUPE5",
    			"PROFIBOX 002001T16RAOPP7",
    			"PROFIBOX 005001T16RAU--7 = 5001",
    			"PROFIBOX 001000T16PROPP7",
    			"PROFIBOX 004001T16PRUPP7",
    			"PROFIBOX 005001T16KEU--7",
    			"PROFIBOX 006001T20MEURP7",
    			"PROFIBOX 14100207000",
    			"PROFIBOX 14200204000",
    			"PROFIBOX 004006M20KEOP37",
    			"PROFIBOX 7120104000",
    			"PROFIBOX 7120107000",
    			"PROFIBOX 7220107000",
    			"PROFIBOX 005001M20KEO--7",
    			"PROFIBOX 005001M20MEO--7",
    			"PROFIBOX 005001T20KEO--7",
    			"PROFIBOX 005001T20MEO--7",
    			"PROFIBOX 005001T20SSO--7",
    			"PROFIBOX 001000M16MEUPE7",
    			"PROFIBOX 001000M20KEOPP7",
    			"PROFIBOX 001000T20KEOPE7",
    			"PROFIBOX 001000T20MEONG7",
    			"PROFIBOX 001000M20MLONG7",
    			"PROFIBOX 001000T20MLONG7",
    			"PROFIBOX 001000T20RAOHT7",
    			"PROFIBOX 004001M20MLONG7",
    			"PROFIBOX 004001T20MLONG7",
    			"PROFIBOX 004001T20RAOM37",
    			"PROFIBOX 004005T20SSOTP7",
    			"PROFIBOX 005004M20MLO--7",
    			"PROFIBOX 005004T20MLO--7",
    			"PROFIBOX 005004T20RAO--7",
    			"PROFIBOX 7120105000",
    			"PROFIBOX 7120106000",
    			"PROFIBOX 7220106000",
    			"PROFIBOX 7220101000",
    			"PROFIBOX 17220204000",
    			"PROFIBOX 17120207000",
    			"PROFIBOX 3120107001",
    			"PROFIBOX 1120107001",
    			"PROFIBOX 008001T20KO---5",
    			"PROFIBOX 9200014000",
    			"PROFIBOX 9200212000",
    			"PROFIBOX 001000M20MEUNG7",
    			"PROFIBOX 002001T20KEUHT7",
    			"PROFIBOX 004004T20KEUHT7",
    			"PROFIBOX 001000T20MLUNG7",
    			"PROFIBOX 005001T20KEU--7",
    			"PROFIBOX 007001T20SM---5",
    			"PROFIBOX 5120104001",
    			"PROFIBOX 003001T20KEUNG7",
    			"PROFIBOX 004001T20KOOPE5",
    			"PROFIBOX 001000T20KOORP7",
    			"PROFIBOX 7216104000",
    			"PROFIBOX 06120007001B",
    			"PROFIBOX 06120007001D",
    			"Strawa Wärmetechnik 51-205207",
    			"SENTINEL PERFORMANCE SOLUTIONS SYSCHECK-DE",
    			"SANIKU SANITAIRES SA 90870-027",
    			"SANIKU SANITAIRES SA 27278-0277",
    			"Gasokol 1000266665",
    			"HAWEI-Systeme e.U. 04.10.0001.1",
    			"HAWEI-Systeme e.U. 04.46.0019.1",
    			"HAWEI-Systeme e.U. MTU2-1999",
    			"Sanwinn Schweiz 505000",
    			"AWT Anlagenschutz- und CP1-03-00742-01",
    			"AWT Anlagenschutz- und F00090",
    			"AWT Anlagenschutz- und F00092",
    			"AWT Anlagenschutz- und CP1-03-02378",
    			"AWT Anlagenschutz- und CP1-03-02379",
    			"AWT Anlagenschutz- und CP1-03-02380",
    			"AWT Anlagenschutz- und CP1-03-02566",
    			"AWT Anlagenschutz- und CP1-03-00990-DE",
    			"AWT Anlagenschutz- und CP1-03-01045",
    			"Donau Well 139620",
    			"Commercial Salgar S.A.U. 21131",
    			"Commercial Salgar S.A.U. 20085",
    			"Commercial Salgar S.A.U. 20090",
    			"Commercial Salgar S.A.U. 20682",
    			"Commercial Salgar S.A.U. 20714",
    			"Commercial Salgar S.A.U. 20719",
    			"nmc Deutschland 9904004",
    			"nmc Deutschland 44007016",
    			"LINUM Europe LAC-798",
    			"LINUM Europe LAC-536",
    			"LINUM Europe RDP20-TO",
    			"BRANGS UND HEINRICH RK1806CL",
    			"HANSA (KWC) 10051043000",
    			"HANSA (KWC) 20192172000",
    			"HANSA (KWC) 21194600000",
    			"HANSA (KWC) Z.535.025",
    			"HANSA (KWC) 20192503000",
    			"GLYNWED 189405",
    			"GLYNWED 189414",
    			"PRESSALIT CARE A/S R2065",
    			"VILLEROY & BOCH 82000061",
    			"VILLEROY & BOCH 82000061",
    			"VILLEROY & BOCH 90950061",
    			" VIEGA ER9");
    	
    	
    	
    	
    	
    	
    	
    	$final = "";
    	/** @var \Thelia\Model\ProductSaleElements $pseResult */
    	foreach( $pseResults as $pseResult){
    	set_time_limit(0);
    	//$final = $final.$pseResult;
    	$final= "||| ".$pseResult." ".$this->crawlAmazonProduct(str_replace (" ", "+", $pseResult));
    	Tlog::getInstance()->error($final);
    	//$final.= $this->crawlGoogleShoppingProduct($pseResult->getEanCode())."\n";
    	//$final.= $this->crawlGeizhalsProduct($pseResult->getEanCode())."\n";
    	//$final.= $this->crawlIdealoProduct($pseResult->getEanCode())."\n";
    	//usleep(250000)sleep(rand(100,500));
    	}
    	//Tlog::getInstance()->error($final);

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
	
	
    public function runCronJob(){
    	$pseQuery = ProductSaleElementsQuery::create();
    	$pseQuery
    	->useProductQuery()
    	->filterByVisible(1)
    	->endUse()
    	;
    	$pseResults = $pseQuery->where('`product_sale_elements`.EAN_CODE ',Criteria::ISNOTNULL)
    	
    	->find();
    	$this->getLogger()->error("starting crawl-job for amazon");
    	
    	$final = "";
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
    	return $this->jsonResponse(json_encode(array('result'=> $this->crawlIdealoProduct("4005176306907"))));
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
    	//Tlog::getInstance()->error($final);

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
    
    public function fromJira() {
        /** @var Request $request */
        $request = $this->getRequest();
        $jiraUser = $request->query->get("jirauser", "");
        $this->getLogger()->error("jirauser is ".$jiraUser);
    }
}
