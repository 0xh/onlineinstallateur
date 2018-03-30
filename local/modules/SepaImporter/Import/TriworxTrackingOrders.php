<?php

namespace SepaImporter\Import;

use Thelia\Core\Event\TheliaEvents;
use Thelia\ImportExport\Import\AbstractImport;
use Thelia\Log\Tlog;
use Thelia\Model\OrderQuery;
use Thelia\Model\CustomerQuery;

class TriworxTrackingOrders extends AbstractImport {

    protected $mandatoryColumns = [
        'LoadingPointName3',
        'PLCColloCodes'
    ];
 
    public function importData(array $data) {
        /** @var EventDispatcherInterface $eventDispatcher */
        $eventDispatcher = $this->getContainer()->get('event_dispatcher');

        $orderRef = $data['LoadingPointName3'];
        $trackingCode = explode(",", $data['PLCColloCodes']);
        $orderTrackingNumber = $trackingCode[0]; 
        
        $order = OrderQuery::create()
        	->findOneByRef($orderRef);
        
       	if ($order!== null) {
            //Tlog::getInstance()->info("FeatAVID" . $data['feature_av_id']);
       		$order->setDeliveryRef($orderTrackingNumber)
       			->save();
           
        }
        
        $customer = CustomerQuery::create()
        				->findOneById($order->getCustomerId());
        
      /* 	$amazonAPI = new AmazonAWSController();
        $infoAmazon = $amazonAPI->getProductInfoFromAmazon($EAN_code); */
    }
    

}
