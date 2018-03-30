<?php

namespace SepaImporter\Controller\Admin;

use Thelia\Controller\Admin\BaseAdminController;
use Thelia\Core\HttpFoundation\Response;

class ImporterController extends BaseAdminController {

    function downloadIncorrectProductsCsv() {
    
    	$csv_file = $this->getRequest()->getSession()->get('csvFileName');
    	
    	if(file_exists(THELIA_LOCAL_DIR . "sepa" . DS . "import" . DS . $csv_file)) {
    		return Response::create(@file_get_contents(THELIA_LOCAL_DIR . "sepa" . DS . "import" . DS . $csv_file), 200, array(
	    			'Content-type' => "text/plain",
    				'Content-Disposition' => sprintf("Attachment;filename=".$csv_file)
	    	));
    	}
    	else {  
    		return $this->errorPage($this->getTranslator()->trans("No csv file %filename has been found", ['%filename' => $csv_file]), 403);
    	}
    }

}
