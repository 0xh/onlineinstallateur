<?php

namespace BackOffice\Controller\Admin;

use Thelia\Controller\Admin\BaseAdminController;
use Thelia\Model\ConfigQuery;

class ConfigurationController extends BaseAdminController
{	
    public function viewAction()
    {
    	$email = ConfigQuery::read('office_email');
    
        return $this->render('config-email',
		        		array(
		        				"office_email" => $email
		        		));
    }

    public function saveAction()
    {
        $error_msg = $ex = false;
        $response = null;
        $form = $this->createForm("email.office");
        
        try {
        	$data = $this->validateForm($form)->getData();
        	
            // Update office email
            foreach ($data as $name => $value) {
            	if (! $form->isTemplateDefinedHiddenFieldName($name)) {
                    ConfigQuery::write($name, $value, false);
                }
            }

            $response = $this->generateSuccessRedirect($form);
        } catch (\Exception $ex) {
            $error_msg = $ex->getMessage();
        }

        if (false !== $error_msg) {
            $this->setupFormErrorContext(
                $this->getTranslator()->trans("Store configuration failed."),
                $error_msg,
                $form,
                $ex
            );

            $response = $this->viewAction();
        }

        return $response;
    }
}
