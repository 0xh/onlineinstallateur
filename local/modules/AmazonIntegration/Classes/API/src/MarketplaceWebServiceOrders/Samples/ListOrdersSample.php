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
 * List Orders Sample
 */
use AmazonIntegration\Controller\Admin\AmazonIntegrationResponse;
use Symfony\Component\DependencyInjection\SimpleXMLElement;

require_once ('.config.inc.php');
include_once dirname(__FILE__) . '/../Client.php';
include_once dirname(__FILE__) . '/../Model/ListOrdersRequest.php';

/**
 * **********************************************************************
 * Instantiate Implementation of MarketplaceWebServiceOrders
 *
 * AWS_ACCESS_KEY_ID and AWS_SECRET_ACCESS_KEY constants
 * are defined in the .config.inc.php located in the same
 * directory as this sample
 * *********************************************************************
 */
// More endpoints are listed in the MWS Developer Guide
// North America:
// $serviceUrl = "https://mws.amazonservices.com/Orders/2013-09-01";
// Europe
$serviceUrl = "https://mws-eu.amazonservices.com/Orders/2013-09-01";
// Japan
// $serviceUrl = "https://mws.amazonservices.jp/Orders/2013-09-01";
// China
// $serviceUrl = "https://mws.amazonservices.com.cn/Orders/2013-09-01";

$config = array(
    'ServiceURL' => $serviceUrl,
    'ProxyHost' => null,
    'ProxyPort' => - 1,
    'ProxyUsername' => null,
    'ProxyPassword' => null,
    'MaxErrorRetry' => 3
);

$service = new MarketplaceWebServiceOrders_Client(AWS_ACCESS_KEY_ID, AWS_SECRET_ACCESS_KEY, APPLICATION_NAME, APPLICATION_VERSION, $config);

$orders = array();

/**
 * **********************************************************************
 * Uncomment to try out Mock Service that simulates MarketplaceWebServiceOrders
 * responses without calling MarketplaceWebServiceOrders service.
 *
 * Responses are loaded from local XML files. You can tweak XML files to
 * experiment with various outputs during development
 *
 * XML files available under MarketplaceWebServiceOrders/Mock tree
 *
 * *********************************************************************
 */
// $service = new MarketplaceWebServiceOrders_Mock();

/**
 * **********************************************************************
 * Setup request parameters and uncomment invoke to try out
 * sample for List Orders Action
 * *********************************************************************
 */

$fieldsArr = array (
    'SellerId' => array('FieldValue' => null, 'FieldType' => 'string'),
    'MWSAuthToken' => array('FieldValue' => null, 'FieldType' => 'string'),
    'CreatedAfter' => array('FieldValue' => $arrDate["dateCreatedAfter"] ? $arrDate["dateCreatedAfter"] : null, 'FieldType' => 'string'),
    'CreatedBefore' => array('FieldValue' => null, 'FieldType' => 'string'),
    'LastUpdatedAfter' => array('FieldValue' => $arrDate["dateLastUpdatedAfter"] ? $arrDate["dateLastUpdatedAfter"] : null, 'FieldType' => 'string'),
    'LastUpdatedBefore' => array('FieldValue' => null, 'FieldType' => 'string'),
    'OrderStatus' => array('FieldValue' => array(), 'FieldType' => array('string'), 'ListMemberName' => 'Status'),
    'MarketplaceId' => array('FieldValue' => array(), 'FieldType' => array('string'), 'ListMemberName' => 'Id'),
    'FulfillmentChannel' => array('FieldValue' => array(), 'FieldType' => array('string'), 'ListMemberName' => 'Channel'),
    'PaymentMethod' => array('FieldValue' => array(), 'FieldType' => array('string'), 'ListMemberName' => 'Method'),
    'BuyerEmail' => array('FieldValue' => null, 'FieldType' => 'string'),
    'SellerOrderId' => array('FieldValue' => null, 'FieldType' => 'string'),
    'MaxResultsPerPage' => array('FieldValue' => null, 'FieldType' => 'int'),
    'TFMShipmentStatus' => array('FieldValue' => array(), 'FieldType' => array('string'), 'ListMemberName' => 'Status'),
);

// @TODO: set request. Action can be passed as MarketplaceWebServiceOrders_Model_ListOrders
$request = new MarketplaceWebServiceOrders_Model_ListOrdersRequest(null, $fieldsArr);
$request->setSellerId(MERCHANT_ID);
$request->setMarketplaceId(MARKETPLACE_ID);
// $request->isSetMaxResultsPerPage()
// object or array of parameters
$orders = invokeListOrders($service, $request);

/**
 * Get List Orders Action Sample
 * Gets competitive pricing and related information for a product identified by
 * the MarketplaceId and ASIN.
 *
 * @param MarketplaceWebServiceOrders_Interface $service
 *            instance of MarketplaceWebServiceOrders_Interface
 * @param mixed $request
 *            MarketplaceWebServiceOrders_Model_ListOrders or array of parameters
 */
function invokeListOrders(MarketplaceWebServiceOrders_Interface $service, $request)
{
    try {
        $response = $service->ListOrders($request);
        
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
            
            if (isset($result->ListOrdersResult->NextToken))
                $_SESSION['nxtToken'] = $result->ListOrdersResult->NextToken;
            
            foreach ($result->ListOrdersResult->Orders->Order as $order) {
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

