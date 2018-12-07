<?php
namespace AmazonIntegration\Classes\API\src\MarketplaceWebService\Samples;

use MarketplaceWebService_Client;
use MarketplaceWebService_Exception;
use MarketplaceWebService_Interface;
use MarketplaceWebService_Model_SubmitFeedRequest;

include_once ('.config.inc.php');
include_once dirname(__FILE__).'/../Client.php';
include_once dirname(__FILE__).'/../Model/SubmitFeedRequest.php';

class SubmitFeedClass
{
    private $serviceUrl;
    private $config;
    private $service;
    private $marketplaceIdArray;
    private $request;
    
    public function __construct($feed, $feedType, $amazonMarketplaceId, $amazonMarketplaceLocale)
    {
        $this->serviceUrl = $this->setServiceUrl($amazonMarketplaceLocale);
        
        $this->config = array (
            'ServiceURL' => $this->serviceUrl,
            'ProxyHost' => null,
            'ProxyPort' => -1,
            'MaxErrorRetry' => 3,
        );
        
        $this->service = new MarketplaceWebService_Client(
            AWS_ACCESS_KEY_ID,
            AWS_SECRET_ACCESS_KEY,
            $this->config,
            APPLICATION_NAME,
            APPLICATION_VERSION);
        
        // Constructing the MarketplaceId array which will be passed in as the the MarketplaceIdList
        // parameter to the SubmitFeedRequest object.
        $this->marketplaceIdArray = array("Id" => array($amazonMarketplaceId));
        
        $feedHandle = @fopen('php://temp', 'rw+');
        fwrite($feedHandle, $feed);
        rewind($feedHandle);
        $parameters = array (
            'Merchant' => MERCHANT_ID,
            'MarketplaceIdList' => $this->marketplaceIdArray,
            'FeedType' => $feedType,
            'FeedContent' => $feedHandle,
            'PurgeAndReplace' => false,
            'ContentMd5' => base64_encode(md5(stream_get_contents($feedHandle), true)),
            //  'MWSAuthToken' => '<MWS Auth Token>', // Optional
        );
        
        rewind($feedHandle);
        
        $this->request = new MarketplaceWebService_Model_SubmitFeedRequest($parameters);
//         invokeSubmitFeed($this->service, $this->request);
        
//         @fclose($feedHandle);
    }
    
    protected function setServiceUrl($amazonMarketplaceLocale)
    {
        switch ($amazonMarketplaceLocale) {
            case "amazon.de":
                // Germany
                $serviceUrl = "https://mws.amazonservices.de";
                break;
            case "amazon.fr":
                // France
                $serviceUrl = "https://mws.amazonservices.fr";
                break;
            case "amazon.com":
                // United States:
                $serviceUrl = "https://mws.amazonservices.com";
                break;
            case "amazon.co.uk":
                // United Kingdom
                $serviceUrl = "https://mws.amazonservices.co.uk";
                break;
            case "amazon.it":
                // Italy
                $serviceUrl = "https://mws.amazonservices.it";
                break;
            case "amazon.jp":
                // Japan
                $serviceUrl = "https://mws.amazonservices.jp";
                break;
            case "amazon.com.cn":
                // China
                $serviceUrl = "https://mws.amazonservices.com.cn";
                break;
            case "amazon.ca":
                // Canada
                $serviceUrl = "https://mws.amazonservices.ca";
                break;
            case "amazon.in":
                // India
                $serviceUrl = "https://mws.amazonservices.in";
                break;
            default:
                    $serviceUrl = "https://mws.amazonservices.de";
        }
        
        return $serviceUrl;
    }
    
    /**
     * Submit Feed Action Sample
     * Uploads a file for processing together with the necessary
     * metadata to process the file, such as which type of feed it is.
     * PurgeAndReplace if true means that your existing e.g. inventory is
     * wiped out and replace with the contents of this feed - use with
     * caution (the default is false).
     *
     * @param MarketplaceWebService_Interface $service instance of MarketplaceWebService_Interface
     * @param mixed $request MarketplaceWebService_Model_SubmitFeed or array of parameters
     */
//     function invokeSubmitFeed(MarketplaceWebService_Interface $service, $request)
    function invokeSubmitFeed()
    {
        try {
//             $response = $service->submitFeed($request);
            $response = $this->service->submitFeed($this->request);
            
//            echo ("Service Response\n");
//            echo ("=============================================================================\n");
//            
//            echo("        SubmitFeedResponse\n");
//            if ($response->isSetSubmitFeedResult()) {
//                echo("            SubmitFeedResult\n");
//                $submitFeedResult = $response->getSubmitFeedResult();
//                if ($submitFeedResult->isSetFeedSubmissionInfo()) {
//                    echo("                FeedSubmissionInfo\n");
//                    $feedSubmissionInfo = $submitFeedResult->getFeedSubmissionInfo();
//                    if ($feedSubmissionInfo->isSetFeedSubmissionId())
//                    {
//                        echo("                    FeedSubmissionId\n");
//                        echo("                        " . $feedSubmissionInfo->getFeedSubmissionId() . "\n");
//                    }
//                    if ($feedSubmissionInfo->isSetFeedType())
//                    {
//                        echo("                    FeedType\n");
//                        echo("                        " . $feedSubmissionInfo->getFeedType() . "\n");
//                    }
//                    if ($feedSubmissionInfo->isSetSubmittedDate())
//                    {
//                        echo("                    SubmittedDate\n");
//                        echo("                        " . $feedSubmissionInfo->getSubmittedDate()->format(DATE_FORMAT) . "\n");
//                    }
//                    if ($feedSubmissionInfo->isSetFeedProcessingStatus())
//                    {
//                        echo("                    FeedProcessingStatus\n");
//                        echo("                        " . $feedSubmissionInfo->getFeedProcessingStatus() . "\n");
//                    }
//                    if ($feedSubmissionInfo->isSetStartedProcessingDate())
//                    {
//                        echo("                    StartedProcessingDate\n");
//                        echo("                        " . $feedSubmissionInfo->getStartedProcessingDate()->format(DATE_FORMAT) . "\n");
//                    }
//                    if ($feedSubmissionInfo->isSetCompletedProcessingDate())
//                    {
//                        echo("                    CompletedProcessingDate\n");
//                        echo("                        " . $feedSubmissionInfo->getCompletedProcessingDate()->format(DATE_FORMAT) . "\n");
//                    }
//                }
//            }
//            if ($response->isSetResponseMetadata()) {
//                echo("            ResponseMetadata\n");
//                $responseMetadata = $response->getResponseMetadata();
//                if ($responseMetadata->isSetRequestId())
//                {
//                    echo("                RequestId\n");
//                    echo("                    " . $responseMetadata->getRequestId() . "\n");
//                }
//            }
            
            echo("            ResponseHeaderMetadata: " . $response->getResponseHeaderMetadata() . "\n");
        } catch (MarketplaceWebService_Exception $ex) {
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

