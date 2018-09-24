<?php

namespace LocalPickup\Controller\Admin;

use Exception;
use LocalPickup\LocalPickup;
use LocalPickup\Model\LocalPickupQuery;
use Thelia\Core\Security\AccessManager;
use Thelia\Core\Security\Resource\AdminResources;
use Thelia\Tools\URL;

class LocalPickUpLocationsStockController extends LocalPickupController {

    public function addLocationStock() {
        if (null !== $response = $this->checkAuth(array(AdminResources::MODULE), array('LocalPickup'), AccessManager::UPDATE)) {
            return $response;
        }

        $form = $this->createForm("add_local_pickup_location_form");

        try {
            $data = $this->validateForm($form)->getData();

            $locationStock = new \LocalPickup\Model\LocalPickup();

            $locationStock
                    ->setAddress($data["address"])
                    ->setGpsLat($data["gps_lat"])
                    ->setGpsLong($data["gps_long"])
                    ->setHint($data["hint"])
                    ->save();
            
            return $this->generateRedirect(URL::getInstance()->absoluteUrl("/admin/module/LocalPickup"));
            
        } catch (Exception $e) {
            $this->setupFormErrorContext(
                    $this->getTranslator()->trans("Error on new location : %message", ["message" => $e->getMessage()], LocalPickup::DOMAIN_NAME), $e->getMessage(), $form
            );

            return self::viewAction();
        }
    }

    public function updateLocationStock() {
        if (null !== $response = $this->checkAuth(array(AdminResources::MODULE), array('LocalPickup'), AccessManager::UPDATE)) {
            return $response;
        }

        $form = $this->createForm("add_local_pickup_location_form");

        try {
            $data = $this->validateForm($form)->getData();

            $locationStock = LocalPickupQuery::create()
                    ->findOneById($data["id"]);

            if (null === $locationStock) {
                throw new Exception($this->getTranslator()->trans("Location id doesn't exist"), array(), LocalPickup::DOMAIN_NAME);
            }

            $locationStock
                    ->setAddress($data["address"])
                    ->setGpsLat($data["gps_lat"])
                    ->setGpsLong($data["gps_long"])
                    ->setHint($data["hint"])
                    ->save();

            return $this->generateSuccessRedirect($form);
        } catch (Exception $e) {
            $this->setupFormErrorContext(
                    $this->getTranslator()->trans("Error updating location : %message", ["message" => $e->getMessage()], LocalPickup::DOMAIN_NAME), $e->getMessage(), $form
            );

            return self::viewAction();
        }
    }

    public function deleteLocationStock() {
        if (null !== $response = $this->checkAuth(array(AdminResources::MODULE), array('LocalPickup'), AccessManager::UPDATE)) {
            return $response;
        }

        $form = $this->createForm("add_local_pickup_location_form");

        try {
            $data = $this->validateForm($form)->getData();

            $locationStock = LocalPickupQuery::create()
                    ->findOneById($data["id"]);

            if (null === $locationStock) {
                throw new Exception($this->getTranslator()->trans("Location id doesn't exist"), array(), LocalPickup::DOMAIN_NAME);
            }

            $locationStock->delete();

            return $this->generateSuccessRedirect($form);
        } catch (Exception $e) {
            $this->setupFormErrorContext(
                    $this->getTranslator()->trans("Error on location deletion : %message", ["message" => $e->getMessage()], LocalPickup::DOMAIN_NAME), $e->getMessage(), $form
            );

            return self::viewAction();
        }
    }
    
//    public function addLocationsConfig()
//    {
//    	if (null !== $response = $this->checkAuth(array(AdminResources::MODULE), array('LocalPickup'), AccessManager::UPDATE)) {
//    		return $response;
//    	}
//    	
//    	$form = $this->createForm("centers.config.form");
//    	
//    	try {
//    		$data = $this->validateForm($form)->getData();
//    		
//    		MultipleFullfilmentCenters::setConfigValue('fulfilment_center_default', $data['fulfilment_center_default']);
//    		MultipleFullfilmentCenters::setConfigValue('fulfilment_center_reserve', $data['fulfilment_center_reserve']);
//    		
//    		return $this->generateSuccessRedirect($form);
//    	} catch (\Exception $e) {
//    		$this->setupFormErrorContext(
//    				$this->getTranslator()->trans("Error on saving in module config : %message", ["message"=>$e->getMessage()], MultipleFullfilmentCenters::DOMAIN_NAME),
//    				$e->getMessage(),
//    				$form
//    				);
//    		
//    		return self::viewAction();
//    	}
//    }
}
