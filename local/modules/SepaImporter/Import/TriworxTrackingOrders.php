<?php

namespace SepaImporter\Import;

use Thelia\ImportExport\Import\AbstractImport;
use Thelia\Log\Tlog;
use Thelia\Model\OrderQuery;
use SepaImporter\Listener\ImportListener;
use SepaImporter\Event\ImportEvent;

class TriworxTrackingOrders extends AbstractImport {

    protected $mandatoryColumns = [
        'LoadingPointName3',
        'PLCColloCodes'
    ];
 
    public function importData(array $data) {
    	/** @var EventDispatcherInterface $eventDispatcher */
    	$eventDispatcher = $this->getContainer()->get('event_dispatcher');
    	
    	$error = null;
        $event = new ImportEvent();
        
        $orderRef = $data['LoadingPointName3'];
        $trackingCode = explode(",", $data['PLCColloCodes']);
        $orderTrackingNumber = $trackingCode[0]; 
        
        $order = OrderQuery::create()->findOneByRef($orderRef);
        
       	if ($order !== null) {
       		Tlog::getInstance()->info("Triworx Import - order ref ".$orderRef.', tracking code '.$orderTrackingNumber);
       		
       		$order->setDeliveryRef($orderTrackingNumber)->save();
       		Tlog::getInstance()->info("Triworx Import - tracking number saved in database");
       		
       		$this->importedRows++;
       		
       		$event->setOrderId($order->getId());
       		$eventDispatcher->dispatch(ImportListener::SEND_MAIL_IMPORTER, $event);
        }
		else {
			Tlog::getInstance()->info('Triworx Import - The order '.$orderRef.' was not found in database.');
			$error .= 'The order '.$orderRef.' was not found in database.';
		}
			
        
        return $error;
    }
}
