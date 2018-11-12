<?php
namespace CronDashboard\Controller;

use CronDashboard\CronDashboard;
use Propel\Runtime\Exception\PropelException;
use Thelia\Controller\Admin\BaseAdminController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use CronDashboard\Form\CronDashboardModuleConfigure;
use Thelia\Core\Security\AccessManager;
use Thelia\Core\Security\Resource\AdminResources;
use Thelia\Tools\URL;

class CronDashboardConfigurationController extends BaseAdminController {
	
	public function configure() 
	{ /*die( CronDashboard::getConfigValue('process_name' ) );*/
        if (null !== $response = $this->checkAuth(AdminResources::MODULE, 'CronDashboard', AccessManager::UPDATE)) {
            return $response;
        }

		$configurationForm = $this->createForm('admin.crondashboard.form.configure');

		try{
			$form = $this->validateForm($configurationForm, "POST");
			$data = $form->getData();
			
			if( isset($data["process_name"]) && $data["process_name"] !== NULL)
			{
				CronDashboard::setConfigValue('process_name', $data["process_name"] );
			} 
			
			if( isset($data["server_location"]) && $data["server_location"] !== NULL)
			{
				CronDashboard::setConfigValue('server_location', $data["server_location"] );
			}

			return $this->generateRedirect('/admin/module/CronDashboard');

		} catch (FormValidationException $ex) {
            $error_msg = $this->createStandardFormValidationErrorMessage($ex);
            $this->setupFormErrorContext($this->getTranslator()
                        ->trans("CronDashboard configuration", [], CronDashboard::DOMAIN_NAME), $error_msg, $configurationForm, $ex);
        } catch (\Exception $ex) {
            $error_msg = $ex->getMessage();
            $this->setupFormErrorContext($this->getTranslator()
                        ->trans("CronDashboard configuration", [], CronDashboard::DOMAIN_NAME), $error_msg, $configurationForm, $ex);
        }
		
        return $this->generateRedirect('/admin/module/CronDashboard');
    }
}