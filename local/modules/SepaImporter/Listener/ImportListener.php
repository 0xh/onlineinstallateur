<?php

namespace SepaImporter\Listener;
use SepaImporter\SepaImporter;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Thelia\Action\BaseAction;
use Thelia\Mailer\MailerFactory;
use SepaImporter\Event\ImportEvent;
use Thelia\Model\OrderQuery;
use Thelia\Model\CustomerQuery;
use Thelia\Log\Tlog;
use Thelia\Core\Event\TheliaEvents;
use Thelia\Core\Event\Order\OrderEvent;

class ImportListener extends BaseAction implements EventSubscriberInterface 
{
   /** @var MailerFactory  */
    protected $mailer;
    const SEND_MAIL_IMPORTER = "importer.send.email.action";
    
    public function __construct(MailerFactory $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * Send email to the customer with the order tracking informations when the tracking number is saved from Triworx import
     * 
     * @param  ImportEvent $event
     */
    public function sendEmailTrackingOrder(ImportEvent $event) 
    {
    	$order = OrderQuery::create()
    				->findOneById($event->getOrderId());
    	
    	if($order) {
    		$this->sendEmail($order);
    	}
    }
    
    /**
     * Send email to the customer with the order tracking informations when the tracking number is saved from BackOffice
     *
     * @param  OrderEvent $event
     */
    public function sendEmailTrackingOrderBackOffice(OrderEvent $event)
    {
	    $order = OrderQuery::create()
	    			->findOneById($event->getOrder()->getId());
	    
	    if($order) {
	    	$this->sendEmail($order);
	    }
    }
    
    public function sendEmail($order) {
    	
    	$customer = CustomerQuery::create()
    					->findOneById($order->getCustomerId());
    	
    	if($customer) {
    		Tlog::getInstance()->info("Update order delivery ref - customer id: ".$order->getCustomerId());
    		
    		$this->mailer->sendEmailToCustomer(
    				'customer_traking_order',
    				$customer,
    				[
    						'order_id' => $order->getId(),
    						'order_ref' => $order->getRef()
    				]
    				);
    	}
    	else {
    		Tlog::getInstance()->info("Update order delivery ref - customer id: ".$order->getCustomerId().' was not found in database');
    	}
    }

    public static function getSubscribedEvents() 
    {
        return array(
        		self::SEND_MAIL_IMPORTER => array('sendEmailTrackingOrder', 128),
        		TheliaEvents::ORDER_UPDATE_DELIVERY_REF => array('sendEmailTrackingOrderBackOffice', 128)
        );
    } 

}
