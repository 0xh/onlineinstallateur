<?php

namespace SepaImporter\Import;

use Thelia\ImportExport\Import\AbstractImport;
use BackOffice\Controller\Admin\ExportDataFromMyshtController;
use MultipleFullfilmentCenters\MultipleFullfilmentCenters;
use RevenueDashboard\Model\BrandMatchingPartnersQuery;
use Thelia\Log\Tlog;

class CreateMyshtProductImport extends AbstractImport {

    protected $mandatoryColumns = [
        'Artikel',
        'Lief.Artnr',
        'Frei verw.',
        'Artikelbezeichnung'
    ];
    protected static $logger;

    public function importData(array $data) {
    
       $errors = null;
       $log = $this->getLogger();
       $log->debug("MYSHT PRODUCT IMPORT");
       if($data['Lief.Artnr']) {
       	   $log->debug($data['Lief.Artnr']);
	       $myshtExport = new ExportDataFromMyshtController();
	       $infoProductMysht = $myshtExport->exportMyshtProductsFromFile($data['Lief.Artnr']);
	       
	       if(isset($infoProductMysht['product_not_found'])) {
	       		$log->debug('Product '.$data['Lief.Artnr'].' not found on mysht');
	       		$errors .= 'Product '.$data['Lief.Artnr'].' not found on mysht';
	       }
	       else {
		       $session = $this->container->get('request_stack')->getCurrentRequest()->getSession();
		       
		       if($this->importedRows) { 
		       		if($session->get('csvGenericProductImport')) {
		       			$csv_file_name = $session->get('csvGenericProductImport');
		       		}
		       }
		       else {
		       		$current_date = date("Y-m-d H:i:s");
		       		$csv_file_name = 'genericProductImport_'.md5($current_date).'.csv';
		       		$session->set('csvGenericProductImport', $csv_file_name);
		       }
		
		       $filepath = THELIA_LOCAL_DIR . "sepa" . DS . "import" . DS . $csv_file_name;
		      
		       // mySht format 1.095,60 -> HF format 1095.60
		       $price = str_replace(".", "", $infoProductMysht["resNettoRabatt"]["netto"]);
		       $price = str_replace(",", ".", $price);
		       $price = number_format($price, 2, '.', '');
		       
		       $listen_price = number_format($infoProductMysht["data"][0]["aktpreis"], 2, '.', '');
		       
		       $brandMatching = BrandMatchingPartnersQuery::create()
		       		->findOneByBrandExtern($data['Lief.Bezeichnung']);
		       	
		       if($brandMatching) {
		       		$brandInternId = $brandMatching->getBrandIntern();
		       		$brandCode = $brandMatching->getBrandCode();
		       }
		       else {
		       		$brandInternId = '';
		       		$brandCode = '';
		       }
		       
		       $file_name = '';
		       $imageLocation = THELIA_LOCAL_DIR . "media" . DS . "images" . DS . "importer" . DS . $infoProductMysht["data"][0]["MegabildNr"].'.jpg';
		       if($infoProductMysht["data"][0]["MegabildNr"] && file_exists($imageLocation)) {
		       		$file_name = $infoProductMysht["data"][0]["MegabildNr"].'.jpg';
		       }
		       		
		       $arrayData = array(
		       		"Extern_id" => $data['Lief.Artnr'],
		       		"Ref" => $brandCode.$data['Lief.Artnr'],
		       		"Marke_id" => $brandInternId,
		       		"Kategorie_id" => '179',
		       		"Produkt_titel" => $data['Artikelbezeichnung'],
		       		"Beschreibung" => $data['Artikelbezeichnung'] . " " . $data['Artikelbezeichnung-2'],
		       		"Menge" => $data['Frei verw.'],
		       		"Fulfilment_center" => MultipleFullfilmentCenters::getConfigValue('fulfilment_center_default'),
		       		"EAN_code" => $data['EAN'],
		       		"Bild_file" => $file_name,
		       		"Price" => $price,
		       		"Listen_price" => $listen_price
		       );
		       
		       if(file_exists($filepath)) {
		       		$this->exportToCsv($filepath, $arrayData);
		       		$this->importedRows++;
		       }
		       else {
		       		$this->initCsvFile($filepath);
		       		$this->exportToCsv($filepath, $arrayData);
		       		$this->importedRows++;
		       }
	       }
	       
       }
       else {
		$errors .= 'The product '.$data['Artikel'].' has no Lief Artnr';
       }
       
       return $errors;
    }
    
    function initCsvFile($file) {
    	$fp = fopen($file, 'w');
    	$fields = array("Extern_id","Ref","Marke_id","Kategorie_id","Produkt_titel","Beschreibung","Menge","Fulfilment_center","EAN_code","Bild_file","Price","Listen_price");
    	fputcsv($fp, $fields);
    	fclose($fp);
    }
    
    function exportToCsv($csvFile, $arrayData) {
    	$fp = fopen($csvFile, 'a');
    	fputcsv($fp, $arrayData);
    	fclose($fp);
    }

    public function getLogger() {
    	if (self::$logger == null) {
    		self::$logger = Tlog::getNewInstance();
    		
    		$logFilePath = THELIA_LOG_DIR . DS . "mysht-generic-product-import.txt";
    		
    		self::$logger->setPrefix("#LEVEL: #DATE #HOUR: ");
    		self::$logger->setDestinations("\\Thelia\\Log\\Destination\\TlogDestinationRotatingFile");
    		self::$logger->setConfig("\\Thelia\\Log\\Destination\\TlogDestinationRotatingFile", 0, $logFilePath);
    		self::$logger->setLevel(Tlog::DEBUG);
    	}
    	return self::$logger;
    }
}
