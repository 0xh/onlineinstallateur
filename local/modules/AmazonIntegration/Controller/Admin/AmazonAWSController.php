<?php
namespace AmazonIntegration\Controller\Admin;

use Thelia\Controller\Admin\BaseAdminController;
use Thelia\Log\Tlog;

require __DIR__ . '/../../Config/config.php';

class AmazonAWSController extends BaseAdminController
{
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
	
	public function getImages($eanCode)
	{
		$log = Tlog::getInstance();

		try{
			$max_time = ini_get("max_execution_time");
			ini_set('max_execution_time', 600);
			
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
			
			$amazonRequest = $this->amazonSign($url,$secretAccessKey);
			
			$sxml = simplexml_load_file($amazonRequest);
			
			$array = json_encode($sxml, TRUE);
			$result = json_decode($array);
			$images = array();
	
			if(isset($result->Items->Item)) {			
				if(isset($result->Items->Item->ItemAttributes->EANList->EANListElement) && !is_array($result->Items->Item->ItemAttributes->EANList->EANListElement)){
					if(is_array($result->Items->Item))
						$item = $result->Items->Item[0];
					else
						$item = $result->Items->Item;
							
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
							
							file_put_contents(__DIR__ . "/../../../../media/images/product/".$file_name, fopen($urlImage, 'r'));
						}
					}
					else {
						$log->debug ( "AMAZON IMAGES - product '.$eanCode.' doesn't have amazon images");
					}
							
				}
				else{
					$log->debug ( "AMAZON IMAGES - EANListElement is an array with more EAN codes for product ".$eanCode);
				}
						
			}
			
			ini_set('max_execution_time', $max_time);
			sleep(10);
			
			return $images;
		}
		catch (\Exception $e) {
			$log->debug ("AMAZON IMAGES - Error images from amazon:".$e->getMessage());
			return $this->getImages($eanCode);
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
}