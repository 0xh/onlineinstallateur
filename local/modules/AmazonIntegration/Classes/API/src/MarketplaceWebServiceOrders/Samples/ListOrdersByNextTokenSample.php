<?php
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
 * List Orders By Next Token Sample
 */

use AmazonIntegration\Controller\Admin\AmazonIntegrationResponse;

require_once('.config.inc.php');
include dirname(__FILE__) . '\..\Client.php';
include dirname(__FILE__) . '\..\Model\ListOrdersByNextTokenRequest.php';

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
 * sample for List Orders By Next Token Action
 ***********************************************************************/
 // @TODO: set request. Action can be passed as MarketplaceWebServiceOrders_Model_ListOrdersByNextToken
 $request = new MarketplaceWebServiceOrders_Model_ListOrdersByNextTokenRequest();
 $request->setSellerId(MERCHANT_ID);
//  $request->setNextToken("/l+pA75cfV6aJqJYLDm0ZIfVkJJPpovR18oKa2+PBxRUojdU4H46trQzazHyYVyLqBXdLk4iogwM3B3rhUPcuX1wcXGLzn5vxVZ4AgdP/syEwuIPTDe/8SJ0wMvlylZkWQWPqGlbsnM84qdTrqNK40s1amFNc1bQS5QbMbY+t9sS3mf+XbXSubuZIF9n45mtnrZ4AbBdBTeicp5jJPQPcgCy5/GuGI4OLzyB960RsbIZEWUDFvtT53Vzlg78c7g+ELekEBnBWT4TgKH522jP77CXSaG7w7Y24yq9C9KTUX2SDfXXbSzuO0g0xZzuQGAEgh51o+El5IeY9TB3jldv+e+1pNQfgqQUo+qCql/dzWx6kFU5B6HcYN24Matyqu9PCusdgVu5bcIiuP7D5BszEv+hPpAGwSABrToAsYN83sHgkdZPXhcRcONZv5RLJLoN79BUoD2mtfY=");

 if (isset($_SESSION['nxtToken']))
     $request->setNextToken($_SESSION['nxtToken']);
 else 
     $request->setNextToken("/l+pA75cfV6aJqJYLDm0ZIfVkJJPpovR18oKa2+PBxRUojdU4H46trQzazHyYVyLqBXdLk4iogwM3B3rhUPcuX1wcXGLzn5vxVZ4AgdP/syEwuIPTDe/8SJ0wMvlylZkWQWPqGlbsnM84qdTrqNK40s1amFNc1bQS5QbMbY+t9sS3mf+XbXSubuZIF9n45mtnrZ4AbBdBTeicp5jJPQPcgCy5/GuGI4OLzyB960RsbIZEWUDFvtT53Vzlg78c7g+ELekEBnBWT4TgKH522jP77CXSaG7w7Y24yq9C9KTUX2SDfXXbSzuO0g0xZzuQGAEgh51o+El5IeY9TB3jldv+e+1pNQfgqQUo+qCql/dzWx6kFU5B6HcYN24Matyqu9PCusdgVu5bcIiuP7D5BszEv+hPpAGwSABrToAsYN83sHgkdZPXhcRcONZv5RLJLoN79BUoD2mtfY=");
 // object or array of parameters
 $orders = invokeListOrdersByNextToken($service, $request);

/**
  * Get List Orders By Next Token Action Sample
  * Gets competitive pricing and related information for a product identified by
  * the MarketplaceId and ASIN.
  *
  * @param MarketplaceWebServiceOrders_Interface $service instance of MarketplaceWebServiceOrders_Interface
  * @param mixed $request MarketplaceWebServiceOrders_Model_ListOrdersByNextToken or array of parameters
  */

  function invokeListOrdersByNextToken(MarketplaceWebServiceOrders_Interface $service, $request)
  {
      try {
        $response = $service->ListOrdersByNextToken($request);

        $orders = array();
        
        $dom = new DOMDocument();
        $dom->loadXML($response->toXML());
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;
        
        $xml = $dom->saveXML();
        $orderdata = new SimpleXMLElement($xml);
        $array = json_encode($orderdata, TRUE);
        $result = json_decode($array);
        if ($result) {
            
            $_SESSION['nxtToken'] = $result->ListOrdersByNextTokenResult->NextToken;
            
            foreach ($result->ListOrdersByNextTokenResult->Orders->Order as $order) {
                array_push($orders, $order);
            }
        } else {
            AmazonIntegrationResponse::logError('error decoding json');
        }
        
        return $orders;

     } catch (MarketplaceWebServiceOrders_Exception $ex) {
         AmazonIntegrationResponse::logError($ex->getMessage());
     }
 }

