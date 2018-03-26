<?php
namespace AmazonIntegration\Controller\Admin;

use Thelia\Controller\Admin\BaseAdminController;
use Thelia\Log\Tlog;
use AmazonIntegration\Model\AmazonProductDescTempQuery;

require __DIR__ . '/../../Config/config.php';

class AmazonAWSController extends BaseAdminController
{
	protected static $logger;
	
	// function just for testing
	public function getDescription($productId)
	{
		$secretAccessKey = PRODUCT_ADVERTISING_AWS_SECRET_ACCESS_KEY;
		$url = 'http://webservices.'.PRODUCT_ADVERTISING_AWS_MARKETPLACE.'/onca/xml?'.
				'AWSAccessKeyId='.PRODUCT_ADVERTISING_AWS_ACCESS_KEY_ID.'&'.
				'AssociateTag='.PRODUCT_ADVERTISING_AWS_ASSOCIATE_TAG.'&'.
				'ItemId='.$productId.'&'.
				'IdType=EAN&'.
				'Operation=ItemLookup&'.
				'ResponseGroup=Images,Medium&'.
				'SearchIndex=All&'.
				'Service=AWSECommerceService';
		
		$amazonRequest = $this->amazonSign($url,$secretAccessKey);
		
		print_r($amazonRequest);
		
		$sxml = simplexml_load_file($amazonRequest);
		$array = json_encode($sxml, TRUE);
		$result = json_decode($array);
		
		print_r($result);
		die();
	}
	
	/* DEPRECATED - used for inserting description on existing products - production
	 * 
	 * public function saveDescriptionsFromAmazon() 
	{	
		$log = Tlog::getInstance();
		
		$products = AmazonProductDescTempQuery::create();
		
		if($products) {
			foreach($products as $product) {
				
				$description = $this->getDescriptionFromAmazon($product->getEan());
			
				if($description) {
					$description = mb_convert_encoding ($description,"WINDOWS-1252");
					$updateDesc = AmazonProductDescTempQuery::create()
									->filterByEan($product->getEan())
									->findOne();
								
					if($updateDesc) {
						$updateDesc->setDescription($description)
							->save();
						
						$log->debug (  "AMAZON DESC for ".$product->getEan().'was saved in DB');
					}
				}
			}	
			$log->debug ( "AMAZON DESC - finish getting description");
		}
		else {
			$log->debug ( "AMAZON DESC - no products in amazon_product_desc_temp table");
		}
	}
	
	public function getDescriptionFromAmazon($productId)
	{ 
		$log = Tlog::getInstance();
		$description = '';
				
		try{
			$max_time = ini_get("max_execution_time");
			ini_set('max_execution_time', 600);
			
			$secretAccessKey = PRODUCT_ADVERTISING_AWS_SECRET_ACCESS_KEY;
			$url = 'http://webservices.'.PRODUCT_ADVERTISING_AWS_MARKETPLACE.'/onca/xml?'.
					'AWSAccessKeyId='.PRODUCT_ADVERTISING_AWS_ACCESS_KEY_ID.'&'.
					'AssociateTag='.PRODUCT_ADVERTISING_AWS_ASSOCIATE_TAG.'&'.
					'ItemId='.$productId.'&'.
					'IdType=EAN&'.
					'Operation=ItemLookup&'.
					'ResponseGroup=Medium&'.
					'SearchIndex=All&'.
					'Service=AWSECommerceService';
			
			$amazonRequest = $this->amazonSign($url,$secretAccessKey);
			$log->debug (  "AMAZON DESC request - ".$amazonRequest);
			$sxml = simplexml_load_file($amazonRequest);
			$array = json_encode($sxml, TRUE);
			$result = json_decode($array);
			
			if(isset($result->Items->Item)) {
				
				if(is_array($result->Items->Item)) {
					$item = $result->Items->Item[0];
					$log->debug (  "AMAZON DESC - ".$productId.'is an array of items');
				}
				else
					$item = $result->Items->Item;
			
				if(isset($item->EditorialReviews->EditorialReview->Content)) {
					$description = $item->EditorialReviews->EditorialReview->Content;
				}
				
				$log->debug ( "AMAZON DESC for ".$productId.'is: ');
				$log->debug ( $description);
			}
			
			ini_set('max_execution_time', $max_time);
			
			return $description;
		}
		catch (\Exception $e) {
			$log->debug ("AMAZON DESC - Error desc from amazon:".$e->getMessage());
			return $this->getDescriptionFromAmazon($productId);
		}
	}
	 */
				
	public function getProductInfoFromAmazon($eanCode)
	{
		$log = Tlog::getInstance();
		$log->debug ( "AMAZON IMAGES - before try/catch");
		$productInfo = array( 'images' => array(),
						'description' => '',
						'color'  => '',
						'width'  => '',
						'height' => '',
						'length' => '',
						'weight' => ''
 				);
		try{
			
			$secretAccessKey = PRODUCT_ADVERTISING_AWS_SECRET_ACCESS_KEY;
			$url = 'http://webservices.'.PRODUCT_ADVERTISING_AWS_MARKETPLACE.'/onca/xml?'.
					'AWSAccessKeyId='.PRODUCT_ADVERTISING_AWS_ACCESS_KEY_ID.'&'.
					'AssociateTag='.PRODUCT_ADVERTISING_AWS_ASSOCIATE_TAG.'&'.
					'ItemId='.$eanCode.'&'.
					'IdType=EAN&'.
					'Operation=ItemLookup&'.
					'ResponseGroup=Images,Medium&'.
					'SearchIndex=All&'.
					'Service=AWSECommerceService';
			
			$log->debug ( "AMAZON IMAGES - in try/catch - before request");
			$amazonRequest = $this->amazonSign($url,$secretAccessKey);
			$log->debug ( "AMAZON IMAGES - in try/catch - after request & before simplexml_load_file");
			$sxml = simplexml_load_file($amazonRequest);
			$log->debug ( "AMAZON IMAGES - in try/catch - after simplexml_load_file");
			$array = json_encode($sxml, TRUE);
			$result = json_decode($array);
			$images = array();
			
			$log->debug ( "AMAZON IMAGES - in try/catch");
			
			if(isset($result->Items->Item)) {			
				if(isset($result->Items->Item->ItemAttributes->EANList->EANListElement) && !is_array($result->Items->Item->ItemAttributes->EANList->EANListElement)){
					if(is_array($result->Items->Item))
						$item = $result->Items->Item[0];
					else
						$item = $result->Items->Item;
					
					// images from AMAZON
					if(isset($item->ImageSets->ImageSet)) {
						 $log->debug ( "AMAZON IMAGES - This product has images. Amazon url for product ".$eanCode.": ".$item->DetailPageURL);
								
						if(isset($item->ItemAttributes->Brand))
							$brand = $item->ItemAttributes->Brand;
						elseif (isset($item->ItemAttributes->Manufacturer))
							$brand = $item->ItemAttributes->Manufacturer;
						elseif (isset($item->ItemAttributes->Publisher))
							$brand = $item->ItemAttributes->Publisher;
						else
							$brand = '';
								
						if($brand) {
							$sub = strtoupper(substr($brand,0,3));
							
							if(isset($item->ItemAttributes->PartNumber))
								$productRef = $sub.$item->ItemAttributes->PartNumber;
							else
								$productRef = $sub.$eanCode;
						}
						else {
							if(isset($item->ItemAttributes->PartNumber))
								$productRef = $item->ItemAttributes->PartNumber;
							else
								$productRef = $eanCode;
						}
								
						//more images
						if(is_array($item->ImageSets->ImageSet)) {
							$i = 0;
							foreach($item->ImageSets->ImageSet as $image) {
								
								$urlImage = $image->LargeImage->URL;
								$file_name = $productRef.'_'.$i.'.jpg';
								$images[$i] = array(
										'file_name' => $file_name,
										'title' => isset($item->ItemAttributes->Title) ? $item->ItemAttributes->Title : ''
								);
								$i++;
								
								Tlog::getInstance()->info("AMAZON IMAGES - url image ".$urlImage);
								Tlog::getInstance()->info("AMAZON IMAGES - file name ".$file_name);
								Tlog::getInstance()->info("AMAZON IMAGES - one image - hf ".__DIR__ . "/../../../../media/images/product/".$file_name);
								file_put_contents(__DIR__ . "/../../../../media/images/product/".$file_name, fopen($urlImage, 'r'));
								
							}
							
						}
						//one image
						else {
							$urlImage = $item->ImageSets->ImageSet->LargeImage->URL;
							$file_name = $productRef.'.jpg';
							$images[0] = array(
									'file_name' => $file_name,
									'title' => isset($item->ItemAttributes->Title) ? $item->ItemAttributes->Title : ''
							);
							Tlog::getInstance()->info("AMAZON IMAGES - one image - url image".$urlImage);
							Tlog::getInstance()->info("AMAZON IMAGES - one image - file name".$file_name);
							Tlog::getInstance()->info("AMAZON IMAGES - one image - hf ".__DIR__ . "/../../../../media/images/product/".$file_name);
							file_put_contents(__DIR__ . "/../../../../media/images/product/".$file_name, fopen($urlImage, 'r'));
						}
						
						$productInfo['images'] = $images;
					}
					else {
						$log->debug ( "AMAZON IMAGES - product '.$eanCode.' doesn't have amazon images");
					}
					
					// description from AMAZON
					if(isset($item->EditorialReviews->EditorialReview->Content)) {
						
						$description = $item->EditorialReviews->EditorialReview->Content;
						$description = mb_convert_encoding ($description,"WINDOWS-1252");
						$productInfo['description'] = $description;
					}	
					
					// attributes (color, height, length, width & weight) from AMAZON
					if(isset($item->ItemAttributes->Color)) {
						
						$color = $result->Items->Item->ItemAttributes->Color;
						$color= mb_convert_encoding ($color,"WINDOWS-1252");
						$productInfo['color'] = $color;
					}
					
					if(isset($item->ItemAttributes->ItemDimensions->Height)) {
						if($item->ItemAttributes->ItemDimensions->Height != 0) {
					
							$dimension = strlen($item->ItemAttributes->ItemDimensions->Height);
							$splitDimension = str_split($item->ItemAttributes->ItemDimensions->Height, $dimension-2);
							$dimension = $splitDimension[0].'.'.$splitDimension[1];
							$dimension = $dimension * 25.4;
							
							$productInfo['height'] = round($dimension).' mm';
							$log->debug ( "AMAZON - item ".$eanCode." have height ". $productInfo['height']);
						}
					}
					else {
						$log->debug ( "AMAZON - item ".$eanCode."doesn't have height");
					}
					
					if(isset($item->ItemAttributes->ItemDimensions->Length)) {
						if($item->ItemAttributes->ItemDimensions->Length != 0) {
							
							$dimension = strlen($item->ItemAttributes->ItemDimensions->Length);
							$splitDimension = str_split($item->ItemAttributes->ItemDimensions->Length, $dimension-2);
							$dimension = $splitDimension[0].'.'.$splitDimension[1];
							$dimension = $dimension * 25.4;
							
							$productInfo['length'] = round($dimension).' mm';
							$log->debug ( "AMAZON - item ".$eanCode." have Length ". $productInfo['length']);
						}
					}
					else {
						$log->debug ( "AMAZON - item ".$eanCode."doesn't have Length");
					}
				
					if(isset($item->ItemAttributes->ItemDimensions->Weight)) {
						if($item->ItemAttributes->ItemDimensions->Weight != 0) {
							
							$dimension = strlen($item->ItemAttributes->ItemDimensions->Weight);
							$splitDimension = str_split($item->ItemAttributes->ItemDimensions->Weight, $dimension-2);
							$dimension = $splitDimension[0].'.'.$splitDimension[1];
							$dimension = $dimension * 453.59237;
							$dimension =  round($dimension)/1000;
							
							$productInfo['weight'] = round($dimension); 
							$log->debug ( "AMAZON - item ".$eanCode." have Weight ". $productInfo['weight']);
						}
					}
					else {
						$log->debug ( "AMAZON - item ".$eanCode."doesn't have Weight");
					}
					
					if(isset($item->ItemAttributes->ItemDimensions->Width)) {
						if($item->ItemAttributes->ItemDimensions->Width != 0) {
							
							$dimension = strlen($item->ItemAttributes->ItemDimensions->Width);
							$splitDimension = str_split($item->ItemAttributes->ItemDimensions->Width, $dimension-2);
							$dimension = $splitDimension[0].'.'.$splitDimension[1];
							$dimension = $dimension * 25.4;
							
							$productInfo['width'] = round($dimension).' mm';
							$log->debug ( "AMAZON - item ".$eanCode." have Width ". $productInfo['width']);
						}
					}
					else {
						$log->debug ( "AMAZON - item ".$eanCode."doesn't have Width");
					}
							
				}
				else{
					$log->debug ( "AMAZON IMAGES - EANListElement is an array with more EAN codes for product ".$eanCode);
				}
						
			} else{
				$log->debug ( "AMAZON IMAGES - doesn't have items/item - ".$eanCode);
			}
			
			//sleep(10);
			
			return $productInfo;
		}
		catch (\Exception $e) {
			$log->debug ("AMAZON IMAGES - Error images from amazon:".$e->getMessage());
			sleep(1);
			return $this->getProductInfoFromAmazon($eanCode);
		}
	}
	
	public function getLowestPrice($eanCode)
	{
		$price = array('lowestPrice' => '',
					   'listPrice' => '');
		
		$this->getLogger()->error( "AMAZON price - getLowestPrice function - ".$eanCode);
		
		try{
			$max_time = ini_get("max_execution_time");
			ini_set('max_execution_time', 100);
			sleep(2);
			
			$secretAccessKey = PRODUCT_ADVERTISING_AWS_SECRET_ACCESS_KEY;
			$url = 'http://webservices.'.PRODUCT_ADVERTISING_AWS_MARKETPLACE.'/onca/xml?'.
					'AWSAccessKeyId='.PRODUCT_ADVERTISING_AWS_ACCESS_KEY_ID.'&'.
					'AssociateTag='.PRODUCT_ADVERTISING_AWS_ASSOCIATE_TAG.'&'.
					'ItemId='.$eanCode.'&'.
					'IdType=EAN&'.
					'Operation=ItemLookup&'.
					'ResponseGroup=Medium&'.
					'SearchIndex=All&'.
					'Service=AWSECommerceService';
			
			$amazonRequest = $this->amazonSign($url,$secretAccessKey);
			
			$this->getLogger()->error( "AMAZON price - amazon request - ".$amazonRequest);
			
			//libxml_use_internal_errors(true);
			$temp = @file_get_contents($amazonRequest);
			
			$this->getLogger()->error('AMAZON price - http_response_header ---- start ----');
			$this->getLogger()->error($http_response_header);
			$this->getLogger()->error('AMAZON price - http_response_header ---- end ----');
			
			if (strpos($http_response_header[0], "200")) {
				$this->getLogger()->error('AMAZON price - success request');
				
				$sxml= simplexml_load_string($temp);
				$array = json_encode($sxml, TRUE);
				$result = json_decode($array);
				$images = array();
				
				$this->getLogger()->error( "AMAZON price - request result for ean code - ".$eanCode);
				$this->getLogger()->error($result);
				
				if(isset($result->Items->Item)) {
					if(isset($result->Items->Item->ItemAttributes->EANList->EANListElement) && is_array($result->Items->Item->ItemAttributes->EANList->EANListElement)){
						$this->getLogger()->error( "AMAZON price - EANListElement is an array with more EAN codes for product ".$eanCode);
					}
					
					if(is_array($result->Items->Item))
						$item = $result->Items->Item[0];
						else
							$item = $result->Items->Item;
							
							if(isset($item->ItemAttributes->ListPrice)) {
								$this->getLogger()->error( "AMAZON price - This product has lowest price. Amazon url for product ".$eanCode.": ".$item->DetailPageURL);
								
								$lowestPrice = 0;
								$listPrice = 0;
								
								if(isset($item->OfferSummary->LowestNewPrice->Amount)) {
									if($item->OfferSummary->LowestNewPrice->Amount > 0) {
										$nrChrLowestPrice = strlen($item->OfferSummary->LowestNewPrice->Amount);
										
										if($nrChrLowestPrice > 2) {
											$splitLowestPrice = str_split($item->OfferSummary->LowestNewPrice->Amount, $nrChrLowestPrice-2);
											$lowestPrice = $splitLowestPrice[0].'.'.$splitLowestPrice[1];
										}
										else {
											$lowestPrice = $item->OfferSummary->LowestNewPrice->Amount;
										}	
									}
								}
								
								if(isset($item->ItemAttributes->ListPrice->Amount)) {
									if($item->ItemAttributes->ListPrice->Amount > 0) {
										$nrChrListPrice = strlen($item->ItemAttributes->ListPrice->Amount);
										
										if($nrChrLowestPrice > 2) {
											$splitListPrice = str_split($item->ItemAttributes->ListPrice->Amount, $nrChrListPrice-2);
											$listPrice = $splitListPrice[0].'.'.$splitListPrice[1];
										}
										else {
											$listPrice = $item->ItemAttributes->ListPrice->Amount;
										}
									}
									
								}
								
								$price = array('lowestPrice' => $lowestPrice,
										'listPrice' => $listPrice);
								
								$this->getLogger()->error("AMAZON price - list price - ".$item->ItemAttributes->ListPrice->FormattedPrice);
								$this->getLogger()->error("AMAZON price - lowest price - ".$item->OfferSummary->LowestNewPrice->FormattedPrice);
							}
							else {
								$this->getLogger()->error( "AMAZON price - This product doesn't have lowest price ".$eanCode);
							}
							
				}
				
				ini_set('max_execution_time', $max_time);
				
				return $price;
			} 
			else {
				sleep(2);
				$this->getLogger()->error("AMAZON price - failed request");
				return $this->getLowestPrice($eanCode);
			} 
		}
		catch (\Exception $e) {
			$this->getLogger()->error("AMAZON price - Error price from amazon:".$e->getMessage());
			return $this->getLowestPrice($eanCode);
		}
	}
	
	public function amazonEncode($text)
	{
		$encodedText = "";
		$j = strlen($text);
		for($i=0;$i<$j;$i++)
		{
			$c = substr($text,$i,1);
			if (!preg_match("/[A-Za-z0-9\-_.~]/",$c))
			{
				$encodedText .= sprintf("%%%02X",ord($c));
			}
			else
			{
				$encodedText .= $c;
			}
		}
		return $encodedText;
	}
	
	public function amazonSign($url,$secretAccessKey)
	{
		// 0. Append Timestamp parameter
		$url .= "&Timestamp=".gmdate("Y-m-d\TH:i:s\Z");
		
		// 1a. Sort the UTF-8 query string components by parameter name
		$urlParts = parse_url($url);
		parse_str($urlParts["query"],$queryVars);
		ksort($queryVars);
		
		// 1b. URL encode the parameter name and values
		$encodedVars = array();
		foreach($queryVars as $key => $value)
		{
			$encodedVars[$this->amazonEncode($key)] = $this->amazonEncode($value);
		}
		
		// 1c. 1d. Reconstruct encoded query
		$encodedQueryVars = array();
		foreach($encodedVars as $key => $value)
		{
			$encodedQueryVars[] = $key."=".$value;
		}
		$encodedQuery = implode("&",$encodedQueryVars);
		
		// 2. Create the string to sign
		$stringToSign  = "GET";
		$stringToSign .= "\n".strtolower($urlParts["host"]);
		$stringToSign .= "\n".$urlParts["path"];
		$stringToSign .= "\n".$encodedQuery;
		
		// 3. Calculate an RFC 2104-compliant HMAC with the string you just created,
		//    your Secret Access Key as the key, and SHA256 as the hash algorithm.
		if (function_exists("hash_hmac"))
		{
			$hmac = hash_hmac("sha256",$stringToSign,$secretAccessKey,TRUE);
		}
		elseif(function_exists("mhash"))
		{
			$hmac = mhash(MHASH_SHA256,$stringToSign,$secretAccessKey);
		}
		else
		{
			die("No hash function available!");
		}
		
		// 4. Convert the resulting value to base64
		$hmacBase64 = base64_encode($hmac);
		
		// 5. Use the resulting value as the value of the Signature request parameter
		// (URL encoded as per step 1b)
		$url .= "&Signature=".$this->amazonEncode($hmacBase64);
		
		return $url;
	}
	
	public function getLogger() {
		if (self::$logger == null) {
			self::$logger = Tlog::getNewInstance();
			
			$logFilePath = THELIA_LOG_DIR . DS . "log-amazon-integration.txt";
			
			self::$logger->setPrefix("#LEVEL: #DATE #HOUR: ");
			self::$logger->setDestinations("\\Thelia\\Log\\Destination\\TlogDestinationRotatingFile");
			self::$logger->setConfig("\\Thelia\\Log\\Destination\\TlogDestinationRotatingFile", 0, $logFilePath);
			self::$logger->setLevel(Tlog::ERROR);
		}
		return self::$logger;
	}
}