<?php
/*************************************************************************************/
/* */
/* Thelia */
/* */
/* Copyright (c) OpenStudio */
/* email : info@thelia.net */
/* web : http://www.thelia.net */
/* */
/* This program is free software; you can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 3 of the License */
/* */
/* This program is distributed in the hope that it will be useful, */
/* but WITHOUT ANY WARRANTY; without even the implied warranty of */
/* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the */
/* GNU General Public License for more details. */
/* */
/* You should have received a copy of the GNU General Public License */
/* along with this program. If not, see <http://www.gnu.org/licenses/>. */
/* */
/**
 * **********************************************************************************
 */
namespace AmazonIntegration\Controller\Admin;

use AmazonIntegration\AmazonIntegration;
use Thelia\Controller\Admin\BaseAdminController;
use Thelia\Core\Thelia;
use Thelia\Core\Security\AccessManager;
use Thelia\Core\Security\Resource\AdminResources;
use Thelia\Form\Exception\FormValidationException;
use Thelia\Tools\URL;
use Thelia\Tools\Version\Version;

/**
 * Class ConfigureAmazonIntegration
 * 
 * @package AmazonIntegration\Controller
 * @author Thelia <info@thelia.net>
 */
class ConfigurationController extends BaseAdminController
{

    /*
     * Checks AmazonIntegration.configure || AmazonIntegration.configure.sandbox form and save config into json file
     */
    public function configure()
    {
        if (null !== $response = $this->checkAuth(AdminResources::MODULE, 'AmazonIntegration', AccessManager::UPDATE)) {
            return $response;
        }
        
        $configurationForm = $this->createForm('amazonintegration.form.configure');
        
        try {
            $form = $this->validateForm($configurationForm, "POST");
            
            // Get the form field values
            $data = $form->getData();
            
            foreach ($data as $name => $value) {
                if (is_array($value)) {
                    $value = implode(';', $value);
                }
                
                AmazonIntegration::setConfigValue($name, $value);
            }
            
            $this->adminLogAppend("amazonintegration.configuration.message", AccessManager::UPDATE, sprintf("Amazon configuration updated"));
            
            if ($this->getRequest()->get('save_mode') == 'stay') {
                // If we have to stay on the same page, redisplay the configuration page/
                $url = '/admin/module/AmazonIntegration';
            } else {
                // If we have to close the page, go back to the module back-office page.
                $url = '/admin/modules';
            }
            
            return $this->generateRedirect(URL::getInstance()->absoluteUrl($url));
        } catch (FormValidationException $ex) {
            $error_msg = $this->createStandardFormValidationErrorMessage($ex);
        } catch (\Exception $ex) {
            $error_msg = $ex->getMessage();
        }
        
        $this->setupFormErrorContext($this->getTranslator()
            ->trans("Amazon Integration configuration", [], AmazonIntegration::DOMAIN_NAME), $error_msg, $configurationForm, $ex);

        // Before 2.2, the errored form is not stored in session
        if (Version::test(Thelia::THELIA_VERSION, '2.2', false, "<")) {
            return $this->render('module-configure', [ 'module_code' => 'Sofort' ]);
        } else {
            return $this->generateRedirect(URL::getInstance()->absoluteUrl('/admin/module/AmazonIntegration'));
        }
        
        return $this->render('module-configure', [
            'module_code' => 'AmazonIntegration'
        ]);
    }
}
