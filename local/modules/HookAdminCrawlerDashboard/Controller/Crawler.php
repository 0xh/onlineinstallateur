<?php

namespace HookAdminCrawlerDashboard\Controller;

use Thelia\Log\Tlog;
use Thelia\Model\ProductSaleElementsQuery;
use HookAdminCrawlerDashboard\Model\CrawlerProductBaseQuery;
use HookAdminCrawlerDashboard\Model\CrawlerProductBase;
use HookAdminCrawlerDashboard\Model\CrawlerProductListingQuery;
use Propel\Runtime\ActiveQuery\Criteria;
use HookAdminCrawlerDashboard\Model\CrawlerProductListing;

/**
 * Class Crawler
 * @package HookAdminCrawlerDashboard\Controller
 * @author Emanuel Plopu <emanuel.plopu@sepa.at>
 */
class Crawler 
{
	const TAG = "crawler";
	private $cookiefile;
	private $request;
	private $productRequest;
	private $debug = false;
	private $sampleData = false;
	
	private $debugMessage = "";
	private $platformName;
	
	private $baseUrl;
	private $searchPath;
	private $productPath;
	private $sellerPath;
	private $productShopsPath;
	private $hausfabrikProductPath;
	
	private $notFoundMarker;
	private $productResultStartMarker;
	private $productResultEndMarker;
	private $productPositionStartMarker;
	private $productPositionEndMarker;
	private $productPositionOffset;
	private $productPriceStartMarker;
	private $productPriceEndMarker;
	private $productSellerIdStartMarker;
	private $productSellerIdEndMarker;
	private $productExternalLinkStartMarker;
	private $productExternalLinkEndMarker;

	private $productPlatformIdStartMarker;
	private $productPlatformIdEndMarker;
	
	private $hausfabrikOfferMarker;
	private $hausfabrikSellerId;
	
	private $productPageShopStartMarker;
	private $productPageShopEndMarker;
	private $productPagePriceStartMarker;
	private $productPagePriceEndMarker;
	private $productStockStartMarker;
	private $productStockEndMarker;
	
	private $sslCertificate = THELIA_CONF_DIR."key".DS."cacert.pem";
	
	private $userAgents = array(1 => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_3) AppleWebKit/601.4.4 (KHTML, like Gecko) Version/9.0.3 Safari/601.4.4',
			2 => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2767.4 Safari/537.36',
			3 => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36',
			4 => 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:40.0) Gecko/20100101 Firefox/40.1',
			5 => 'Mozilla/5.0 (Windows NT 6.3; rv:36.0) Gecko/20100101 Firefox/36.0',
			6 => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10; rv:33.0) Gecko/20100101 Firefox/33.0',
			7 => 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2228.0 Safari/537.36',
			8 => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2227.1 Safari/537.36',
			9 => 'Opera/9.80 (X11; Linux i686; Ubuntu/14.10) Presto/2.12.388 Version/12.16',
			10 => 'Opera/12.80 (Windows NT 5.1; U; en) Presto/2.10.289 Version/12.02',
			11 => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_3) AppleWebKit/537.75.14 (KHTML, like Gecko) Version/7.0.3 Safari/7046A194A',
			12 => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_6_8) AppleWebKit/537.13+ (KHTML, like Gecko) Version/5.1.7 Safari/534.57.2'
	);
	
	/** @var \Thelia\Model\ProductSaleElementsQuery $productSaleElementQuery */
	private $productSaleElemetQuery;
	
	/** @var \HookAdminCrawlerDashboard\Model\CrawlerProductBaseQuery $crawlerProductBaseQuery */
	private $crawlerProductBaseQuery;
	
	/** @var \HookAdminCrawlerDashboard\Model\CrawlerProductListingQuery $crawlerProductListingQuery */
	private $crawlerProductListingQuery;
	
	public function setServiceLinks($baseUrl, $searchPath){
		$this->baseUrl = $baseUrl;
		$this->searchPath = $searchPath;
	}
	
	public function setProductResultMarker($start, $end){
		$this->productResultStartMarker = $start;
		$this->productResultEndMarker = $end;
	}
	
	public function setPriceResultMarker($start, $end){
		$this->productPriceStartMarker = $start;
		$this->productPriceEndMarker = $end;
	}
	
	public function setPositionResultMarker($start, $end, $offset){
		$this->productPositionStartMarker = $start;
		$this->productPositionEndMarker = $end;
		$this->productPositionOffset = $offset;
	}
	
	public function setProductStockMarker($start, $end){
		$this->productStockStartMarker = $start;
		$this->productStockEndMarker = $end;
	}
	
	public function setProductPageShopMarker($start, $end){
		$this->productPageShopStartMarker = $start;
		$this->productPageShopEndMarker = $end;
	}
	
	public function setProductPagePriceMarker($start, $end){
		$this->productPagePriceStartMarker = $start;
		$this->productPagePriceEndMarker = $end;
	}
	
	public function setProductPlatformIdMarker($start, $end){
		$this->productPlatformIdStartMarker = $start;
		$this->productPlatformIdEndMarker = $end;
	}
	
	public function setProductSellerIdMarker($start, $end){
		$this->productSellerIdStartMarker = $start;
		$this->productSellerIdEndMarker = $end;
	}
	
	public function setProductExternalLinkMarker($start, $end){
		$this->productExternalLinkStartMarker = $start;
		$this->productExternalLinkEndMarker = $end;
	}
	
	public function setSSLCertificateFile($certificate){
		$this->sslCertificate = $certificate;
	}
	
	public function setHausfabrikOfferMarker($marker){
		$this->hausfabrikOfferMarker = $marker;
	}
	
	public function setHausfabrikSellerId($sellerId){
		$this->hausfabrikSellerId = $sellerId;
	}
	
	public function getHausfabrikSellerId(){
		return $this->hausfabrikSellerId;
	}
	
	public function setHausfabrikProductPageUrl($url){
		$this->hausfabrikProductPath = $url;
	}
	
	public function getHausfabrikProductPageUrl(){
		return $this->hausfabrikProductPath;
	}
	
	public function init($debugMode, $sampleData){
		$this->debug = $debugMode;
		$this->sampleData = $sampleData;
	}
	
	public function setPlatformName($platformName){
		$this->platformName = $platformName;
	}
	
	private function setChannelOptions($channel){
		curl_setopt( $channel, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $channel, CURLOPT_AUTOREFERER, true );
		curl_setopt( $channel, CURLOPT_FOLLOWLOCATION, true );
		curl_setopt( $channel, CURLOPT_COOKIEJAR, $this->cookiefile);
		curl_setopt( $channel, CURLOPT_COOKIEFILE, $this->cookiefile);
		curl_setopt( $channel, CURLOPT_USERAGENT, $this->userAgents[rand(1,12)]);
		curl_setopt( $channel, CURLOPT_CAINFO, THELIA_CONF_DIR."key".DS."cacert.pem");
		return $channel;
	}
	
	public function setRequest($request){
		$this->request = $request;
	}
	
	public function getRequest(){
		return $this->request;
	}
	
	public function searchByEANCode($ean_code){
		if(!$this->sampleData){
			$url = $this->baseUrl.$this->searchPath.$ean_code;
			$channel = curl_init($url);
			$channel = $this->setChannelOptions($channel);
			$this->setRequest(curl_exec($channel));
			if($this->debug){
				Tlog::getInstance()->error("crawlerurl ".$url);
				$this->debugMessage .="search_url ".$url;
			}	
		}
		return $this->getRequest();
	}
	
	public function findPlatformID($searchResponse){
		$removeBeforePart = explode($this->productPlatformIdStartMarker, $searchResponse);
		$removeAfterPart = explode($this->productPlatformIdEndMarker, $removeBeforePart[1]);
		
		return $removeAfterPart[0];
	}

	
	public function getFirstProduct($request){
		$removeBeforePart = explode($this->productResultStartMarker, $request);
		$removeAfterPart = explode($this->productResultEndMarker, $removeBeforePart[1]);

		return $removeAfterPart[0];
	}
	
	public function getOfferSellerId($request){
		return $this->scrapeText($request, $this->productSellerIdStartMarker, $this->productSellerIdEndMarker, "noSellerId");
	}
	
	private function scrapeText($text,$start,$end,$notFound){
		$removeBeforePart = explode($start, $text);
		if(count($removeBeforePart) > 1)
			$removeAfterPart = explode($end, $removeBeforePart[1]);
		else return $notFound;
		
		return $removeAfterPart[0];
	}
	
	public function getProductLinkForOffer($platformProductId, $offer){
		$sellerId = $this->getOfferSellerId($offer);
		return $this->baseUrl.$this->productPath.$platformProductId.$this->sellerPath.$sellerId;
	}
	

	public function getHausfabrikProductLink($platformProductId){
		return $this->baseUrl.$this->productPath.$platformProductId.$this->sellerPath.$this->hausfabrikSellerId;
	}
	
	public function getExternalProductLinkForOffer($offer){
		$removeBeforePart = explode($this->productExternalLinkStartMarker, $offer);
		$removeAfterPart = explode($this->productExternalLinkEndMarker, $removeBeforePart[1]);
		
		return rtrim($this->baseUrl,"/").$removeAfterPart[0];
	}
	
   public function getHausfabrikOffer($response){
   	
   	//count number of offers
   	$offersList = explode($this->productResultStartMarker,$response);
   	$numberOfOffers = count($offersList);
   	
   	if($numberOfOffers > 0)
   		for($i= 0;$i < $numberOfOffers; $i++){
   			if (strpos($offersList[$i], $this->hausfabrikOfferMarker) !== false)
   				return $offersList[$i];
   	}
   	return false;
   }
   
   public function getOfferPosition($productOffer){
   	$removeBeforePart = explode($this->productPositionStartMarker, $productOffer);
   	if(count($removeBeforePart) > 1)
   		$removeAfterPart = explode($this->productPositionEndMarker, $removeBeforePart[1]);
   	else return -1;
   	
   	return ($removeAfterPart[0]+$this->productPositionOffset);
   }
   
   public function getOfferPrice($request){
   	return $this->scrapeText($request, $this->productPriceStartMarker, $this->productPriceEndMarker, -1);
   }
   
   public function setProductPath($productPath){
   	$this->productPath = $productPath;
   }
   
   public function setProductShopsLink($productShopsPath){
   	$this->productShopsPath = $productShopsPath;
   }
   
   public function setSellerPath($sellerPath){
   	$this->sellerPath = $sellerPath;
   }
   
   public function setProductRequest($request){
   	$this->productRequest = $request;
   }
   
   public function getProductRequest(){
   	return $this->productRequest;
   }
   
   public function getProductPage($code){
   	if(!$this->sampleData){
   		$url = $this->getProductPageUrl($code);
   		$channel = curl_init($url);
   		$channel = $this->setChannelOptions($channel);
   		$this->setProductRequest(curl_exec($channel));
   		if($this->debug){
   			Tlog::getInstance()->error("productpageurl ".$url);
   			$this->debugMessage .="productpageurl ".$url;
   		}
   	}
   	
   	return $this->getProductRequest();
   }
   
   public function getProductShops($platformId){
   	if(!$this->sampleData){
   		$url = $this->getProductShopsUrl($platformId);
   		$channel = curl_init($url);
   		$channel = $this->setChannelOptions($channel);
   		$this->setProductRequest(curl_exec($channel));
   		if($this->debug){
   			Tlog::getInstance()->error("productshopspageurl ".$url);
   			$this->debugMessage .="productshopspageurl ".$url;
   		}
   	}
   	
   	return $this->getProductRequest();
   }
   
   public function getProductPageUrl($platformId){
   	return $this->baseUrl.$this->productPath.$platformId;
   }
   
   public function getProductShopsUrl($platformId){
   	return $this->baseUrl.$this->productShopsPath.$platformId;
   }
   
   public function isShopInProductPage($productPage){
   	$removeBeforePart = explode($this->productPageShopStartMarker, $productPage);
   	//Tlog::getInstance()->error(" starterMarker ".$this->productPageShopStartMarker);
   	
   	if(count($removeBeforePart)>1){
   		
   		$removeAfterPart = explode($this->productPageShopEndMarker, $removeBeforePart[1]);
   		$removeAfterPart[0] = trim($removeAfterPart[0]);
   		
   		//Tlog::getInstance()->error(" shopinproduct ".$this->productPageShopStartMarker." ".$removeAfterPart[0]);
   		
   		if(strpos($removeAfterPart[0],$this->hausfabrikOfferMarker) !== false)
   			return true;
   	}
   	return false;
   }
   
   public function getProductPagePrice($productPage){
   	$removeBeforePart = explode($this->productPagePriceStartMarker, $productPage);
   	$removeAfterPart = explode($this->productPagePriceEndMarker, $removeBeforePart[1]);
   	
   	return $removeAfterPart[0];
   }
   
   
   public function getOfferStock($productOffer){
   	$removeBeforePart = explode($this->productStockStartMarker, $productOffer);
   	$removeAfterPart = explode($this->productStockEndMarker, $removeBeforePart[1]);
   	
   	return $this->removeHtml($removeAfterPart[0]);
   }
   
   public function removeHtml($text){
   	$removeBeforePart = explode('">', $text);
   	$removeAfterPart = explode("</", $removeBeforePart[1]);
   	
   	return trim($removeAfterPart[0]);
   }
   
   public function getDebugMessage(){
   	return $this->debugMessage;
   }

   public function getProductBase($eanCode){
   	if($this->productSaleElemetQuery == null)
   		$this->productSaleElemetQuery = ProductSaleElementsQuery::create();
   	else
   		$this->productSaleElemetQuery->clear();
   		
   	if($this->crawlerProductBaseQuery == null)
   		$this->crawlerProductBaseQuery = CrawlerProductBaseQuery::create();
   	else
   		$this->crawlerProductBaseQuery->clear();
   				
   	//exists already?
   	/** @var \Thelia\Model\ProductSaleElements $product */
   	$product = $this->productSaleElemetQuery->findOneByEanCode($eanCode);
   	
   	if($product != null)
   	{
   		$productId = $product->getProductId();
   		if($this->debug)
   			Tlog::getInstance()->error("for ".$eanCode." found product-id ".$productId);
   	}
   	//else return error
   	
   	if($productId != null){
   		$crawlerProduct = $this->crawlerProductBaseQuery->findOneByProductId($productId);
   		//if($crawlerProduct)
   		//	Tlog::getInstance()->error("for ".$productId." found crawlerProductBase ".$crawlerProduct->__toString());
   	}
   	
   	if($crawlerProduct == null){
   		$crawlerProduct = new CrawlerProductBase();
   		$crawlerProduct->setActive(1);
   		$crawlerProduct->setProductId($productId);
   		$crawlerProduct->setActionRequired(0);
   		$crawlerProduct->save();
   		//Tlog::getInstance()->error($crawlerProduct->__toString());
   	}
   	
   	return $crawlerProduct;
   }
   
   public function saveProductListing($productBaseId, $hf_price, $hf_position, $hf_stock, $first_price, $platform_product_id, $link_platform_product_page, $link_hf_product, $link_first_product){
   
   	if($this->crawlerProductListingQuery == null)
   		$this->crawlerProductListingQuery = CrawlerProductListingQuery::create();
   	else
   		$this->crawlerProductListingQuery->clear();
   	
   	//exists already?
   	$this->crawlerProductListingQuery
   	->condition ( 'product_base_id', 'product_base_id = ?', $productBaseId, \PDO::PARAM_INT )
   	->condition ( 'platform', 'platform = ?', $this->platformName, \PDO::PARAM_STR )
   	->where ( array ('product_base_id','platform' ), Criteria::LOGICAL_AND )
    ;
   	
   	$crawlerProductListing = $this->crawlerProductListingQuery->findOne();
   	
   	if($crawlerProductListing == null)
   		$crawlerProductListing = new CrawlerProductListing();
   	
   	$crawlerProductListing->setProductBaseId($productBaseId);
   	$crawlerProductListing->setHfPrice($hf_price);
   	$crawlerProductListing->setHfPosition($hf_position);
   	$crawlerProductListing->setHfProductStock($hf_stock);
   	$crawlerProductListing->setFirstPosition(1);
   	$crawlerProductListing->setFirstPrice($first_price);
   	$crawlerProductListing->setPlatform($this->platformName);
   	$crawlerProductListing->setPlatformProductId($platform_product_id);
   	$crawlerProductListing->setLinkPlatformProductPage($link_platform_product_page);
   	$crawlerProductListing->setLinkHfProduct($link_hf_product);
   	$crawlerProductListing->setLinkFirstProduct($link_first_product);
   	$crawlerProductListing->save();
   	
   	return $crawlerProductListing;
   }
   
 
}