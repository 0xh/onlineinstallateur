<?php

namespace SepaImporter\Import;

use Thelia\Core\Event\TheliaEvents;
use Thelia\ImportExport\Import\AbstractImport;
use Thelia\Log\Tlog;
use Thelia\Model\OrderQuery;
use Thelia\Mailer\MailerFactory;
use Thelia\Model\CustomerQuery;

class TriworxTrackingOrders extends AbstractImport {

    protected $mandatoryColumns = [
        'order_id',
        'order_tracking_number'
    ];
    
    /** @var MailerFactory  */
    protected $mailer;
    
    public function __construct(MailerFactory $mailer)
    {
    	$this->mailer = $mailer;
    }

    public function importData(array $data) {
        /** @var EventDispatcherInterface $eventDispatcher */
        $eventDispatcher = $this->getContainer()->get('event_dispatcher');

       /*  $orderId = $data['order_id'];
        $orderTrackingNumber = $data['order_tracking_number']; */
        
        $orderId = '6042';
        $orderTrackingNumber = '23456';
        
        $order = OrderQuery::create()
        		->findOneById($orderId);
        
       	if ($order!== null) {
            //Tlog::getInstance()->info("FeatAVID" . $data['feature_av_id']);
       		$order->setDeliveryRef($orderTrackingNumber)
       			->save();
           
            //$eventDispatcher->dispatch(TheliaEvents::PRODUCT_FEATURE_UPDATE_VALUE, $productfeatureupdate);
        }
        
        $customer = CustomerQuery::create()
        				->findOneById($order->getCustomerId());
        
        $this->sendEmailPickupStatusOrder($customer);
    }
    
    public function sendEmailPickupStatusOrder($customer)
    {
    	
    	$this->mailer->sendEmailToCustomer(
    			'pickup_order',
    			$customer,
    			[
    					'order_id' => '6042',
    					'order_ref' => 'ORD000000001932'
    			]
    			);
    }

}
