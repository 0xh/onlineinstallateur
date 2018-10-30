<?php

namespace SepaImporter\Import;

use MultipleFullfilmentCenters\Model\FulfilmentCenterProductsQuery;
use Thelia\ImportExport\Import\AbstractImport;
use Thelia\Log\Tlog;
use Thelia\Model\ProductQuery;
use Thelia\Model\ProductSaleElementsQuery;

class UpdateStockFromTriworxInRealCenter extends AbstractImport {

    protected $mandatoryColumns = [
        'Artikelnummer', //ref
        'Bestand' //stock
    ];
    protected $importedRows = 0;
    protected static $logger;

    public function importData(array $data) {
    	
        $ref = $data["Artikelnummer"];
        $stock = (int)$data["Bestand"]; 
        $fulfilmentCenterId = 2;
       
        $log = $this->getLogger();
        
        $productQuery = ProductQuery::create()->findOneByRef($ref);
        
        if ($productQuery) {
        	$log->debug("Product with ref ".$ref." was found in database, with id ".$productQuery->getId());
        	
        	$idProd = $productQuery->getId();
        	
        	$fulfilmentCenter = FulfilmentCenterProductsQuery::create()
        							->filterByFulfilmentCenterId($fulfilmentCenterId)
        							->filterByProductId($idProd)
        							->findOneOrCreate();
        	
        	$fulfilmentCenter->setProductStock($stock)->save();
        	$this->importedRows++;
        	$log->debug("Product with REF ".$ref." and id ".$idProd." has stock ".$stock.", in fulfilment center id " . $fulfilmentCenterId);
        	
        	$allCentersForProduct = FulfilmentCenterProductsQuery::create()
							        	->withColumn('SUM(product_stock)', 'totalStock')
							        	->filterByProductId($idProd)
        								->findOne();
        								
        	if ($allCentersForProduct) {
        		
        		$productSaleElement = ProductSaleElementsQuery::create()->findOneByRef($ref);
        		
        		if($productSaleElement) {
        			
        			$oldStock = $productSaleElement->getQuantity();
        			$productSaleElement->setQuantity($allCentersForProduct->getVirtualColumn('totalStock'))->save();
	        		$log->debug("Stock for REF = ".$ref." in pse table was ".$oldStock." and now is: ".$stock);
        		}
        	} 
        	else {
        		$log->debug("Product with ref ".$ref." was not found in fulfilment center products table");
        	}
        }
        else {
        	$log->debug("Product with ref ".$ref." was not found in database");
        }

        parent::setImportedRows($this->importedRows);
    }

    public function getLogger() {
    	if (self::$logger == null) {
    		self::$logger = Tlog::getNewInstance();
    		
    		$logFilePath = THELIA_LOG_DIR . DS . "log-update-stock-triworx-in-real-center.txt";
    		
    		self::$logger->setPrefix("#LEVEL: #DATE #HOUR: ");
    		self::$logger->setDestinations("\\Thelia\\Log\\Destination\\TlogDestinationRotatingFile");
    		self::$logger->setConfig("\\Thelia\\Log\\Destination\\TlogDestinationRotatingFile", 0, $logFilePath);
    		self::$logger->setLevel(Tlog::DEBUG);
    	}
    	return self::$logger;
    }
}
