<?php
use AmazonIntegration\Controller\Admin\AmazonIntegrationResponse;
use AmazonIntegration\Model\AmazonOrdersProducts;
use AmazonIntegration\Model\AmazonOrdersProductsQuery;
use AmazonIntegration\Model\ProductAmazonQuery;

/*******************************************************************************
 * Copyright 2009-2017 Amazon Services. All Rights Reserved.
 * Licensed under the Apache License, Version 2.0 (the "License"); 
 *
 * You may not use this file except in compliance with the License. 
 * You may obtain a copy of the License at: http://aws.amazon.com/apache2.0
 * This file is distributed on an "AS IS" BASIS, WITHOUT WARRANTIES OR 
 * CONDITIONS OF ANY KIND, either express or implied. See the License for the 
 * specific language governing permissions and limitations under the License.
 *******************************************************************************
 * PHP Version 5
 * @category Amazon
 * @package  Marketplace Web Service Orders
 * @version  2013-09-01
 * Library Version: 2017-02-22
 * Generated: Thu Mar 02 12:41:08 UTC 2017
 */

/**
 * List Order Items Sample
 */

require_once('.config.inc.php');
include_once dirname(__FILE__).'\..\Client.php';
include_once  dirname(__FILE__).'\..\Model\ListOrderItemsRequest.php';

/************************************************************************
 * Instantiate Implementation of MarketplaceWebServiceOrders
 *
 * AWS_ACCESS_KEY_ID and AWS_SECRET_ACCESS_KEY constants
 * are defined in the .config.inc.php located in the same
 * directory as this sample
 ***********************************************************************/
// More endpoints are listed in the MWS Developer Guide
// North America:
//$serviceUrl = "https://mws.amazonservices.com/Orders/2013-09-01";
// Europe
$serviceUrl = "https://mws-eu.amazonservices.com/Orders/2013-09-01";
// Japan
//$serviceUrl = "https://mws.amazonservices.jp/Orders/2013-09-01";
// China
//$serviceUrl = "https://mws.amazonservices.com.cn/Orders/2013-09-01";


 $config = array (
   'ServiceURL' => $serviceUrl,
   'ProxyHost' => null,
   'ProxyPort' => -1,
   'ProxyUsername' => null,
   'ProxyPassword' => null,
   'MaxErrorRetry' => 3,
 );

 $service = new MarketplaceWebServiceOrders_Client(
        AWS_ACCESS_KEY_ID,
        AWS_SECRET_ACCESS_KEY,
        APPLICATION_NAME,
        APPLICATION_VERSION,
        $config);

/************************************************************************
 * Uncomment to try out Mock Service that simulates MarketplaceWebServiceOrders
 * responses without calling MarketplaceWebServiceOrders service.
 *
 * Responses are loaded from local XML files. You can tweak XML files to
 * experiment with various outputs during development
 *
 * XML files available under MarketplaceWebServiceOrders/Mock tree
 *
 ***********************************************************************/
 // $service = new MarketplaceWebServiceOrders_Mock();

/************************************************************************
 * Setup request parameters and uncomment invoke to try out
 * sample for List Order Items Action
 ***********************************************************************/
 // @TODO: set request. Action can be passed as MarketplaceWebServiceOrders_Model_ListOrderItems

 $request = new MarketplaceWebServiceOrders_Model_ListOrderItemsRequest();
 $request->setSellerId(MERCHANT_ID);


 $request->setAmazonOrderId($amazonOrderId);
 /**
  * Get List Order Items Action Sample
  * Gets competitive pricing and related information for a product identified by
  * the MarketplaceId and ASIN.
  *
  * @param MarketplaceWebServiceOrders_Interface $service instance of MarketplaceWebServiceOrders_Interface
  * @param mixed $request MarketplaceWebServiceOrders_Model_ListOrderItems or array of parameters
  */
 if(!function_exists('invokeListOrderItems')) { 
 function invokeListOrderItems(MarketplaceWebServiceOrders_Interface $service, $request)
 {
 	try {
 		$response = $service->ListOrderItems($request);
 		
 		$dom = new DOMDocument();
 		$dom->loadXML($response->toXML());
 		$dom->preserveWhiteSpace = false;
 		$dom->formatOutput = true;
 		
 		$xml = $dom->saveXML();
 	
 		$orderdata = new SimpleXMLElement($xml);
 		
 		//print_r($orderdata);
 		$array = json_encode($orderdata, TRUE);
 		$result = json_decode($array);
 		
 		if ($result) {
 			$orderProducts = $result->ListOrderItemsResult->OrderItems;
 			//print_r($orderProducts);
 			return $orderProducts;
 			//var_dump($orderProducts->ASIN);
 			// die;
 		} else {
 			echo ('error decoding json');
 		}
 		
 		return array();
 		
 	} catch (MarketplaceWebServiceOrders_Exception $ex) {
 		echo("Caught Exception: " . $ex->getMessage() . "\n");
 		echo("Response Status Code: " . $ex->getStatusCode() . "\n");
 		echo("Error Code: " . $ex->getErrorCode() . "\n");
 		echo("Error Type: " . $ex->getErrorType() . "\n");
 		echo("Request ID: " . $ex->getRequestId() . "\n");
 		echo("XML: " . $ex->getXML() . "\n");
 		echo("ResponseHeaderMetadata: " . $ex->getResponseHeaderMetadata() . "\n");
 	}
 }
 }
 
 
 if(!function_exists('addProductsForOrdersAmazon')) { 
 function addProductsForOrdersAmazon($ASIN, $amazonOrderId)
 {
 	$ifExist = false;
 	$eanCode = "";
 	$productId = "";
 	
 	$amazonOrdersProductsQuery = new AmazonOrdersProductsQuery();
 	$result = $amazonOrdersProductsQuery->findByAmazonOrderId($amazonOrderId);
 	
 	foreach ($result as $res)
 	{
 		if ($res->getProductId())
 		{
 			$ifExist = true;
 			break;
 		}
 	}
 	
 	if (!$ifExist)
 	{
 		$productAmazon = new ProductAmazonQuery();
 		$prods = $productAmazon->findByASIN($ASIN);
 		
 		$ifExistAsin = false;
 		foreach ($prods as $res)
 		{
 			if ($res->getASIN())
 			{
 				$ifExistAsin = true;
 				$eanCode = $res->getEanCode();
 				$productId = $res->getProductId();
 				break;
 			}
 		}
 		
 		if ($ifExistAsin){
 			$amazonOrdersProducts = new AmazonOrdersProducts();
 			$amazonOrdersProducts->setAmazonOrderId($amazonOrderId);
 			$amazonOrdersProducts->setASIN($ASIN);
 			$amazonOrdersProducts->setEanCode($eanCode);
 			$amazonOrdersProducts->setProductId($productId);
 			$amazonOrdersProducts->save();
 		}
 		else
 			AmazonIntegrationResponse::logError('ASIN = '. $ASIN . ' not exist in Thelia.');
 			
 	}
 	
 }
 
}
//  $request->setAmazonOrderId("302-8891523-9856327");
 // object or array of parameters
 			
 //foreach ($amazonOrdersArray as $amazonOrderId) {
     
    
//      $request->setAmazonOrderId("305-4424625-0181155");
     $productsOrderItem = invokeListOrderItems($service, $request);

     foreach ($productsOrderItem as $prd)
     {
         if (isset($prd->ASIN)){
             addProductsForOrdersAmazon($prd->ASIN, $amazonOrderId);
         }
         else {
             foreach ($prd as $pr){
                 if (isset($pr->ASIN))
                    addProductsForOrdersAmazon($pr->ASIN, $amazonOrderId);
             }
         }
     }
     sleep(2);
 //}
 