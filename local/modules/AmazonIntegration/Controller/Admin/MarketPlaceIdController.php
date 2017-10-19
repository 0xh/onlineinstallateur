<?php

namespace AmazonIntegration\Controller\Admin;

use AmazonIntegration\AmazonIntegration;
use MultipleFullfilmentCenters\MultipleFullfilmentCenters;
use MultipleFullfilmentCenters\Model\FulfilmentCenter;
use MultipleFullfilmentCenters\Model\FulfilmentCenterQuery;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Thelia\Controller\Admin\BaseAdminController;
use Thelia\Core\Thelia;
use Thelia\Core\Security\AccessManager;
use Thelia\Core\Security\Resource\AdminResources;
use Thelia\Form\Exception\FormValidationException;
use Thelia\Tools\URL;
use Thelia\Tools\Version\Version;
use Thelia\Model\ModuleConfigQuery;
use Thelia\Model\Map\ModuleConfigTableMap;

class MarketPlaceIdController extends BaseAdminController
{
    public function addMarketPlace()
    {
        if (null !== $response = $this->checkAuth(AdminResources::MODULE, 'AmazonIntegration', AccessManager::UPDATE)) {
            return $response;
        }
        
        $formMarketplace = $this->createForm("amazonintegration.addmarketplaceid.form");
        
        try {
            $form = $this->validateForm($formMarketplace, "POST");
            
            $data = $form->getData();
            
            AmazonIntegration::setConfigValue("MARKETPLACE_".$data["marketplace"], $data["marketplaceid"]);
                
            $this->adminLogAppend("amazonintegration.configuration.message", AccessManager::UPDATE, sprintf("Amazon configuration updated"));
            
            if ($this->getRequest()->get('save_mode') == 'stay') {
                // If we have to stay on the same page, redisplay the configuration page/
                $url = '/admin/module/AmazonIntegration';
            } else {
                // If we have to close the page, go back to the module back-office page.
                $url = '/admin/module/AmazonIntegration';
            }
            
            return $this->generateRedirect(URL::getInstance()->absoluteUrl($url));
        } catch (FormValidationException $ex) {
            $error_msg = $this->createStandardFormValidationErrorMessage($ex);
        } catch (\Exception $ex) {
            $error_msg = $ex->getMessage();
        }
        
        $this->setupFormErrorContext($this->getTranslator()
            ->trans("Amazon Integration configuration", [], AmazonIntegration::DOMAIN_NAME), $error_msg, $formMarketplace, $ex);
        
        // Before 2.2, the errored form is not stored in session
        if (Version::test(Thelia::THELIA_VERSION, '2.2', false, "<")) {
            return $this->render('module-configure', [
                'module_code' => 'AmazonIntegration'
            ]);
        } else {
            return $this->generateRedirect(URL::getInstance()->absoluteUrl('/admin/module/AmazonIntegration'));
        }
        
    }

    public function updateaMarketPlace()
    {
       return $this->addMarketPlace();
    }

    public function deleteMarketPlace()
    {
        if (null !== $response = $this->checkAuth(array(AdminResources::MODULE), array('AmazonIntegration'), AccessManager::UPDATE)) {
            return $response;
        }

        $formMarketplace = $this->createForm("amazonintegration.addmarketplaceid.form");
        $url = '/admin/module/AmazonIntegration';
        
        try {
            $form = $this->validateForm($formMarketplace, "POST");
            
            $data = $form->getData();
        
            $marketPlace = ModuleConfigQuery::create()
                        ->findOneByName("MARKETPLACE_".$data["marketplace"]);
            
            if (null === $marketPlace) {
                throw new \Exception($this->getTranslator()->trans("Marketplace '".$data["marketplace"]."' doesn't exist"), array(), AmazonIntegration::DOMAIN_NAME);
            }
                        
            $marketPlace->delete();
            return $this->generateRedirect(URL::getInstance()->absoluteUrl($url));
        } catch (\Exception $e) {
            
            AmazonIntegrationResponse::logError($e);
            return $this->generateRedirect(URL::getInstance()->absoluteUrl($url));
        }
    }
    
    public static function getConfigValueMarketPlace()
    {
        $marketPlaces = array();
        
        $marketPlace = ModuleConfigQuery::create()
                ->where(ModuleConfigTableMap::NAME." like 'MARKETPLACE_%'");
        
        if (null === $marketPlace) 
        {
            AmazonIntegrationResponse::logError("Marketplaces doesn't exist!");
            return RedirectResponse::create(URL::getInstance()->absoluteUrl('/admin/module/AmazonIntegration'), 302);
        }
        
        foreach ($marketPlace as $market)
        {
            array_push($marketPlaces, $market->getValue());
        }
        
         return $marketPlaces;  
    }
}
