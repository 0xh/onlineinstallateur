<?php

namespace HookAdminCrawlerDashboard\Controller;

use Thelia\Log\Tlog;

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
	
	private $baseUrl;
	private $searchPath;
	private $productPath;
	private $notFoundMarker;
	private $productResultStartMarker;
	private $productResultEndMarker;
	private $productPositionStartMarker;
	private $productPositionEndMarker;
	private $productPositionOffset;
	private $productPriceStartMarker;
	private $productPriceEndMarker;
	private $productStockStartMarker;
	private $productStockEndMarker;
	private $hausfabrikOfferMarker;
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
	
	public function setProductStockmarker($start, $end){
		$this->productStockStartMarker = $start;
		$this->productStockEndMarker = $end;
	}
	
	public function setSSLCertificateFile($certificate){
		$this->sslCertificate = $certificate;
	}
	
	public function setHausfabrikOfferMarker($marker){
		$this->hausfabrikOfferMarker = $marker;
	}
	
	public function init($debugMode, $sampleData){
		$this->debug = $debugMode;
		$this->sampleData = $sampleData;
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
				Tlog::getInstance()->error("crawlerresponse ".$this->getRequest());
			}	
		}
		return $this->getRequest();
	}
	
	public function findPlatformID($search_response){
		
	}
	
	public function getMainProduct($request){//shop product in the main page
		
	}
	
	public function getShopsForProduct($request){
		
	}
	
	public function getFirstProduct($request){
		//Tlog::getInstance()->error(sprintf(self::TAG.' message "%s"',$this->productResultStartMarker));

		$removeBeforePart = explode($this->productResultStartMarker, $request);
		
		$removeAfterPart = explode($this->productResultEndMarker, $removeBeforePart[1]);
		//,'error'=>curl_error ( $ch1 )
		return $removeAfterPart[0];
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
   	$removeAfterPart = explode($this->productPositionEndMarker, $removeBeforePart[1]);
   	
   	return ($removeAfterPart[0]+$this->productPositionOffset);
   }
   
   public function getOfferPrice($productOffer){
   	$removeBeforePart = explode($this->productPriceStartMarker, $productOffer);
   	$removeAfterPart = explode($this->productPriceEndMarker, $removeBeforePart[1]);
   	
   	return $removeAfterPart[0];
   }
   
   public function setProductLink($productPath){
   	$this->productPath = $productPath;
   }
   
   public function setProductRequest($request){
   	$this->productRequest = $request;
   }
   
   public function getProductRequest(){
   	return $this->productRequest;
   }
   
   public function getProductPage($code){
   	if(!$this->sampleData){
   		$url = $this->baseUrl.$this->productPath.$code;
   		$channel = curl_init($url);
   		$channel = $this->setChannelOptions($channel);
   		$this->setProductRequest(curl_exec($channel));
   	}
   	
   	return $this->getProductRequest();
   }
   
   public function getOfferStock($productOffer){
   	$removeBeforePart = explode($this->productStockStartMarker, $productOffer);
   	$removeAfterPart = explode($this->productStockEndMarker, $removeBeforePart[1]);
   	
   	return $removeAfterPart[0];
   }

	
}