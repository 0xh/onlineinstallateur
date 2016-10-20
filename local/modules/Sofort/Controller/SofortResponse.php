<?php
/*************************************************************************************/
/*                                                                                   */
/*      Thelia	                                                                     */
/*                                                                                   */
/*      Copyright (c) OpenStudio                                                     */
/*      email : info@thelia.net                                                      */
/*      web : http://www.thelia.net                                                  */
/*                                                                                   */
/*      This program is free software; you can redistribute it and/or modify         */
/*      it under the terms of the GNU General Public License as published by         */
/*      the Free Software Foundation; either version 3 of the License                */
/*                                                                                   */
/*      This program is distributed in the hope that it will be useful,              */
/*      but WITHOUT ANY WARRANTY; without even the implied warranty of               */
/*      MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the                */
/*      GNU General Public License for more details.                                 */
/*                                                                                   */
/*      You should have received a copy of the GNU General Public License            */
/*	    along with this program. If not, see <http://www.gnu.org/licenses/>.         */
/*                                                                                   */
/*************************************************************************************/

namespace Sofort\Controller;

use Sofort\Sofort;
use Thelia\Core\Event\Order\OrderEvent;
use Thelia\Core\Event\TheliaEvents;
use Thelia\Core\HttpKernel\Exception\RedirectException;
use Thelia\Model\OrderQuery;
use Thelia\Model\OrderStatus;
use Thelia\Model\OrderStatusQuery;
use Thelia\Module\BasePaymentModuleController;
use Thelia\Tools\URL;
use Thelia\Log\Tlog;
use Sofort\Core\SofortLibTransactionData;
use Thelia\Model\Order;

/**
 * Class SofortResponse
 * @package Sofort\Controller
 * @author Thelia <info@thelia.net>
 */
class SofortResponse extends BasePaymentModuleController
{
    /* @var Tlog $log */
    protected static $logger;

    public function __construct()
    {
        //$this->logger = new SofortApiLogManager();
    }

    /**
     * @param $order_id
     * @return \Thelia\Core\HttpFoundation\Response
     */
    public function ok($order_id)
    {
    	
    	//$this->getLogger()->error("anisofort response ");

        
        	/*
<?xml version="1.0" encoding="UTF-8" ?>
<status_notification>
<transaction>136500-298540-57C0B1F7-1CA1</transaction>
<time>2016-08-26T23:17:53+02:00</time>
</status_notification>
*/
        	$content = $this->getRequest()->getContent();
        	$transaction_id = "";
        	if($content != null) 
        	//	$this->getLogger()->error("Sofort-ok content is null ");
        	// else 
        	{
        		$transaction_array = explode("transaction",$content);
        		$transaction_id = $transaction_array[2];
        		$transaction_id = substr($transaction_id,1,strlen($transaction_id)-3);
        		$this->getLogger()->error("Sofort valid transaction-id ".$transaction_id);
        	}
        	//if($transaction_id == "")
        		
        		$orderQuery=OrderQuery::create();
        		$order =$orderQuery->findOneById($order_id);
        		
        		$transaction_id = $order->getTransactionRef();
        		$this->getLogger()->error("Sofort valid transaction_id ".$transaction_id);
        		
        		
        	if($transaction_id)	{
            	$order = $this->checkorder($order_id, $transaction_id);
            	
            	/*
            	 * Set order status as paid
            	 */
            	$event = new OrderEvent($order);
            	$event->setStatus(OrderStatusQuery::getPaidStatus()->getId());
            	$this->dispatch(TheliaEvents::ORDER_UPDATE_STATUS, $event);
            	
            	$this->redirectToSuccessPage($order_id);
        	}
        	else 
        	{
        		$this->getLogger()->error("Sofort transaction_id is null, order contains no valid transaction_id");
        	}
            /*
             * $payerid string value returned by sofort
             * $logger SofortApiLogManager used to log transctions with sofort
             */
           // $payerid = $this->getRequest()->get('PayerID');
           

            /*if (! empty($payerid)) {
                /*
                 * $config ConfigInterface Object that contains configuration
                 * $api SofortApiCredentials Class used by the library to store and use 3T login(username, password, signature)
                 * $sandbox bool true if sandbox is enabled
                 *
                $api     = new SofortApiCredentials();
                $sandbox = Sofort::isSandboxMode();
                
                 // Send getExpressCheckout & doExpressCheckout
                 // empty cart
                 
                $getExpressCheckout = new SofortNvpOperationsGetExpressCheckoutDetails(
                    $api,
                    $token
                );

                $request  = new SofortNvpMessageSender($getExpressCheckout, $sandbox);
                $response = SofortApiManager::nvpToArray($request->send());

                $this->logger->logTransaction($response);

                if (isset($response['ACK']) && $response['ACK'] === 'Success' &&
                    isset($response['PAYERID']) && $response['PAYERID'] === $payerid &&
                    isset($response['TOKEN']) && $response['TOKEN'] === $token
                ) {*/
                   /* $doExpressCheckout = new SofortNvpOperationsDoExpressCheckoutPayment(
                        $api,
                        round($order->getTotalAmount(), 2),
                        $order->getCurrency()->getCode(),
                        $payerid,
                        SofortApiManager::PAYMENT_TYPE_SALE,
                        $token,
                        URL::getInstance()->absoluteUrl("/module/sofort/listen")
                    );

                    $request  = new SofortNvpMessageSender($doExpressCheckout, $token);
                    $response = SofortApiManager::nvpToArray($request->send());*/

                   // $this->logger->logTransaction($response);

                    // In case of pending status, log the reason to get usefull information (multi-currency problem, ...)
                    /*if (isset($response['ACK']) && $response['ACK'] === "Success" &&
                        isset($response['PAYMENTINFO_0_PAYMENTSTATUS']) && $response['PAYMENTINFO_0_PAYMENTSTATUS'] === "Pending") {
                        $this->getTranslator()->trans(
                            "Sofort transaction is pending. Reason: %reason",
                            [ 'reason' => $response['PAYMENTINFO_0_PENDINGREASON'] ],
                            Sofort::DOMAIN
                        );
                    }*/

                    /*
                     * In case of success, go to success page
                     * In case of error, show it
                     */
                   /* if (isset($response['ACK']) && $response['ACK'] === "Success"
                        && isset($response['PAYMENTINFO_0_PAYMENTSTATUS']) && $response['PAYMENTINFO_0_PAYMENTSTATUS'] === "Completed"
                        && isset($response['TOKEN']) && $response['TOKEN'] === $token
                    ) {*/
                        
                   /* } else {
                        $message = $this->getTranslator()->trans("Failed to validate your payment", [], Sofort::DOMAIN);
                    }
                } else {
                    $message = $this->getTranslator()->trans("Failed to validate payment parameters", [], Sofort::DOMAIN);
                }
            }/* else {
                $message = $this->getTranslator()->trans("Failed to find PayerID", [], Sofort::DOMAIN);
            }*/
         /*catch (RedirectException $ex) {
            throw $ex;
        } catch (\Exception $ex) {
            $this->logger->getLogger()->error("Error occured while processing express checkout : " . $ex->getMessage());

            $message = $this->getTranslator()->trans(
                "Unexpected error: %mesg",
                [ '%mesg' => $ex->getMessage()],
                Sofort::DOMAIN
            );
        }*/

        $this->redirectToFailurePage($order_id, "failed to verify sofort transaction_id ");
    }

    /*
     * @param $order_id int
     * @return \Thelia\Core\HttpFoundation\Response
     */
    public function cancel($order_id)
    {
        $transaction_id = null;
        
        $content = $this->getRequest()->getContent();
        if($content == null)
        	$this->getLogger()->error("Sofort-cancel content is null ");
        	else {
        		$transaction_array = explode("transaction",$content);
        		$transaction_id = $transaction_array[2];
        		$transaction_id = substr($transaction_id,1,strlen($transaction_id)-3);
        		$this->getLogger()->error("Sofort-cancel transaction-id ".$transaction_id);
        	}

        try {
            $order = $this->checkorder($order_id, $transaction_id);

            
            $this->getLogger()->error("User canceled payment of order ".$order->getRef());

            $event = new OrderEvent($order);
            $event->setStatus(OrderStatusQuery::create()->findOneByCode(OrderStatus::CODE_CANCELED)->getId());
            $this->dispatch(TheliaEvents::ORDER_UPDATE_STATUS, $event);

            $message = $this->getTranslator()->trans("You canceled your payment", [], Sofort::DOMAIN);
        } catch (\Exception $ex) {
            $this->getLogger()->error("Error occured while canceling order: " . $ex->getMessage());

            $message = $this->getTranslator()->trans(
                "Unexpected error: %mesg",
                [ '%mesg' => $ex->getMessage()],
                Sofort::DOMAIN
            );
        }

        $this->redirectToFailurePage($order_id, $message);
    }
    
    public function pending($order_id)
    {
    	$content = $this->getRequest()->getContent();
    	$transaction_id = "";
    	if($content == null)
    		$this->getLogger()->error("Sofort-pending content is null");
    		else {
    			$transaction_array = explode("transaction",$content);
    			$transaction_id = $transaction_array[1];
    			$transaction_id = substr($transaction_id,1,strlen($transaction_id)-3);
    		}
    	$this->getLogger()->error("Sofort-pending ". $order_id." request ".$this->getRequest()->getContent());
    	
    	if($transaction_id){
    		//get order object
    		$orderQuery=OrderQuery::create();
    		$order =$orderQuery->findOneById($order_id);
    		if($order){
    			$order->setTransactionRef($transaction_id);
    			$order->save();
    		}	
    	}
    	 
    	$this->getLogger()->error("Sofort-pending transaction_id ".$transaction_id." order_id ".$order->getId());
    }
    public function loss($order_id)
    {
    	$this->getLogger()->error("Sofort-loss ". $order_id." request ".implode(" ",$this->getRequest()->request->all()));
    }
    public function received($order_id)
    {
    	$this->getLogger()->error("Sofort-received ". $order_id." request ".implode(" ",$this->getRequest()->request->all()));
    }
    public function refunded($order_id)
    {
    	$this->getLogger()->error("Sofort-refunded ". $order_id." request ".implode(" ",$this->getRequest()->request->all()));
    }
    public function untraceable($order_id)
    {
    	$this->getLogger()->error("Sofort-untraceable ". $order_id." request ".implode(" ",$this->getRequest()->request->all()));
    }
    

    /*
     * @param $order_id int
     * @param &$token string|null
     * @throws \Exception
     * @return \Thelia\Model\Order
     */
    public function checkorder($order_id, $transaction_id)
    {
// thelia
        if (null === $order = OrderQuery::create()->findPk($order_id)) {
            throw new \Exception(
                $this->getTranslator()->trans(
                    "Invalid order ID. This order doesn't exists or doesn't belong to you.",
                    [],
                    Sofort::DOMAIN
                )
            );
        }
// sofort
        if($transaction_id){
        $configkey = '136500:298540:ab1acabad886cbea351a5fa4aa085e0d';
        
        $SofortLibTransactionData = new SofortLibTransactionData($configkey);
        
        // If SofortLib_Notification returns a transaction_id:
        $SofortLibTransactionData->addTransaction( $transaction_id);
        
        //$SofortLibTransactionData->addTransaction(array('00907-01222-50F00112-D86E', '00907-01222-50EFFC79-7E33'));
        //$SofortLibTransactionData->addTransaction(array('00907-37660-51D2CD5E-8182'));
        //$SofortLibTransactionData->addTransaction('00907-01222-51ADD8C9-86C8');
        
        // By default without setter Api version 1.0 will be used due to backward compatibility, please
        // set ApiVersion to latest version. Please note that the response might have a different structure and values
        // For more details please see our Api documentation on https://www.sofort.com/integrationCenter-ger-DE/integration/API-SDK/
        $SofortLibTransactionData->setApiVersion('2.0');
        
        //$SofortLibTransactionData->setTime('2012-11-14T18:00+02:00', '2012-12-13T00:00+02:00');
        //$SofortLibTransactionData->setNumber(5, 1);
        
        $SofortLibTransactionData->sendRequest();
        
        
        $output = array();
        $methods = array(
        		'getAmount' => '',
        		'getAmountRefunded' => '',
        		'getCount' => '',
        		'getPaymentMethod' => '',
        		'getConsumerProtection' => '',
        		'getStatus' => '',
        		'getStatusReason' => '',
        		'getStatusModifiedTime' => '',
        		'getLanguageCode' => '',
        		'getCurrency' => '',
        		'getTransaction' => '',
        		'getReason' => array(0,0),
        		'getUserVariable' => 0,
        		'getTime' => '',
        		'getProjectId' => '',
        		'getRecipientHolder' => '',
        		'getRecipientAccountNumber' => '',
        		'getRecipientBankCode' => '',
        		'getRecipientCountryCode' => '',
        		'getRecipientBankName' => '',
        		'getRecipientBic' => '',
        		'getRecipientIban' => '',
        		'getSenderHolder' => '',
        		'getSenderAccountNumber' => '',
        		'getSenderBankCode' => '',
        		'getSenderCountryCode' => '',
        		'getSenderBankName' => '',
        		'getSenderBic' => '',
        		'getSenderIban' => '',
        );
        
        foreach($methods as $method => $params) {
        	if(count($params) == 2) {
        		$output[] = $method . ': ' . $SofortLibTransactionData->$method($params[0], $params[1]);
        	} else if($params !== '') {
        		$output[] = $method . ': ' . $SofortLibTransactionData->$method($params);
        	} else {
        		$output[] = $method . ': ' . $SofortLibTransactionData->$method();
        	}
        }
        
        if($SofortLibTransactionData->isError()) {
        	 $SofortLibTransactionData->getError();
        	 $this->getLogger()->error("Sofort response transaction_data error ".$SofortLibTransactionData->getError());
        	 throw new \Exception(
        	 		$this->getTranslator()->trans(
        	 				"Could not verify sofort transaction. Error: ".$SofortLibTransactionData->getError(),
        	 				[],
        	 				Sofort::DOMAIN
        	 				)
        	 		);
        }
        else 
        	 $this->getLogger()->error("Sofort response transaction successful for id: ".$transaction_id);//." ".implode('<br />', $output));
        
        }
        
        
        return $order;
    }

    /**
     * Return a module identifier used to calculate the name of the log file,
     * and in the log messages.
     *
     * @return string the module code
     */
    protected function getModuleCode()
    {
        return "Sofort";
    }
    

    public function getLogger()
    {
    	if (self::$logger == null) {
    		self::$logger = Tlog::getNewInstance();
    
    		$logFilePath = THELIA_LOG_DIR . DS . "log-sofort-payment.txt";
    
    		self::$logger->setPrefix("#LEVEL: #DATE #HOUR: ");
    		self::$logger->setDestinations("\\Thelia\\Log\\Destination\\TlogDestinationRotatingFile");
    		self::$logger->setConfig("\\Thelia\\Log\\Destination\\TlogDestinationRotatingFile", 0, $logFilePath);
    		self::$logger->setLevel(Tlog::ERROR);
    	}
    	return self::$logger;
    }
}
