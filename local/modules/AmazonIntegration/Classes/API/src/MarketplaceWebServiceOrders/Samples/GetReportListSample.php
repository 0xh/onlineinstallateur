<?php

/**
 *  PHP Version 5
 *
 *  @category    Amazon
 *  @package     MarketplaceWebService
 *  @copyright   Copyright 2009 Amazon Technologies, Inc.
 *  @link        http://aws.amazon.com
 *  @license     http://aws.amazon.com/apache2.0  Apache License, Version 2.0
 *  @version     2009-01-01
 */
/* * ***************************************************************************** 

 *  Marketplace Web Service PHP5 Library
 *  Generated: Thu May 07 13:07:36 PDT 2009
 * 
 */

/**
 * Get Report List  Sample
 */
include_once ('.config.inc.php');
include_once dirname(__DIR__) . '/../MarketplaceWebService/Client.php';
include_once dirname(__DIR__) . '/../MarketplaceWebService/Model/GetReportListRequest.php';
include_once dirname(__DIR__) . '/../MarketplaceWebService/Model/IdList.php';
include_once dirname(__DIR__) . '/../MarketplaceWebService/Model/TypeList.php';

/* * **********************************************************************
 * Uncomment to configure the client instance. Configuration settings
 * are:
 *
 * - MWS endpoint URL
 * - Proxy host and port.
 * - MaxErrorRetry.
 * ********************************************************************* */
// IMPORTANT: Uncomment the approiate line for the country you wish to
// sell in:
// United States:
//$serviceUrl = "https://mws.amazonservices.com";
// United Kingdom
//$serviceUrl = "https://mws.amazonservices.co.uk";
// Germany
//$serviceUrl = "https://mws.amazonservices.de";
// France
//$serviceUrl = "https://mws.amazonservices.fr";
// Italy
//$serviceUrl = "https://mws.amazonservices.it";
// Japan
//$serviceUrl = "https://mws.amazonservices.jp";
// China
//$serviceUrl = "https://mws.amazonservices.com.cn";
// Canada
//$serviceUrl = "https://mws.amazonservices.ca";
// India
//$serviceUrl = "https://mws.amazonservices.in";

$config = array(
 'ServiceURL'    => $serviceUrl,
 'ProxyHost'     => null,
 'ProxyPort'     => -1,
 'MaxErrorRetry' => 3,
);

/* * **********************************************************************
 * Instantiate Implementation of MarketplaceWebService
 * 
 * AWS_ACCESS_KEY_ID and AWS_SECRET_ACCESS_KEY constants 
 * are defined in the .config.inc.php located in the same 
 * directory as this sample
 * ********************************************************************* */
$service = new MarketplaceWebService_Client(
 AWS_ACCESS_KEY_ID, AWS_SECRET_ACCESS_KEY, $config, APPLICATION_NAME, APPLICATION_VERSION);

/* * **********************************************************************
 * Uncomment to try out Mock Service that simulates MarketplaceWebService
 * responses without calling MarketplaceWebService service.
 *
 * Responses are loaded from local XML files. You can tweak XML files to
 * experiment with various outputs during development
 *
 * XML files available under MarketplaceWebService/Mock tree
 *
 * ********************************************************************* */
// $service = new MarketplaceWebService_Mock();

/* * **********************************************************************
 * Setup request parameters and uncomment invoke to try out 
 * sample for Get Report List Action
 * ********************************************************************* */
// @TODO: set request. Action can be passed as MarketplaceWebService_Model_GetReportListRequest
// object or array of parameters
// $parameters = array (
//   'Merchant' => MERCHANT_ID,
//   'AvailableToDate' => new DateTime('now', new DateTimeZone('UTC')),
//   'AvailableFromDate' => new DateTime('-60 months', new DateTimeZone('UTC')),
//   'Acknowledged' => false, 
//   'MWSAuthToken' => '<MWS Auth Token>', // Optional
// );
// 
// $request = new MarketplaceWebService_Model_GetReportListRequest($parameters);

$request = new MarketplaceWebService_Model_GetReportListRequest();
$request->setMerchant(MERCHANT_ID);

$marketplaceIdList = new MarketplaceWebService_Model_IdList();
$marketplaceIdList->setId($reportRequestId);


$request->setReportRequestIdList($marketplaceIdList);
$request->setMarketplace($marketplaceid);

//$typeList = new MarketplaceWebService_Model_TypeList();
//$typeList->setType("_GET_MERCHANT_LISTINGS_ALL_DATA_");
//$request->setReportTypeList($typeList);
//$request->setAvailableToDate(new DateTime('now', new DateTimeZone('UTC')));
//$request->setAvailableFromDate(new DateTime('-100 months', new DateTimeZone('UTC')));
//$request->setAcknowledged(false);
// $request->setMWSAuthToken('<MWS Auth Token>'); // Optional

//$reportId = invokeGetReportList($service, $request);

/**
 * Get Report List Action Sample
 * returns a list of reports; by default the most recent ten reports,
 * regardless of their acknowledgement status
 *   
 * @param MarketplaceWebService_Interface $service instance of MarketplaceWebService_Interface
 * @param mixed $request MarketplaceWebService_Model_GetReportList or array of parameters
 */
function invokeGetReportList(MarketplaceWebService_Interface $service, $request)
{

    try {
        $response = $service->getReportList($request);

        $reportId = 0;
        if ($response->isSetGetReportListResult()) {

            $getReportListResult = $response->getGetReportListResult();
            $reportInfoList      = $getReportListResult->getReportInfoList();

            foreach ($reportInfoList as $reportInfo) {

                if ($reportInfo->isSetReportId()) {
                    $reportId = $reportInfo->getReportId();
                }
            }
        }

        return $reportId;
    } catch (MarketplaceWebService_Exception $ex) {
        
        return -1;
        echo("Caught Exception: " . $ex->getMessage() . "\n");
        echo("Response Status Code: " . $ex->getStatusCode() . "\n");
        echo("Error Code: " . $ex->getErrorCode() . "\n");
        echo("Error Type: " . $ex->getErrorType() . "\n");
        echo("Request ID: " . $ex->getRequestId() . "\n");
        echo("XML: " . $ex->getXML() . "\n");
        echo("ResponseHeaderMetadata: " . $ex->getResponseHeaderMetadata() . "\n");
    }
}

?>
