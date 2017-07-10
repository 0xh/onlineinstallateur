<?php


namespace MultipleFullfilmentCenters\Controller\Admin;

use MultipleFullfilmentCenters\MultipleFullfilmentCenters;
use MultipleFullfilmentCenters\Model\FulfilmentCenter;
use MultipleFullfilmentCenters\Model\FulfilmentCenterQuery;
use Thelia\Core\Security\AccessManager;
use Thelia\Core\Security\Resource\AdminResources;
use DeliveryDelay\DeliveryDelay;

class LocationStockController extends MultipleFullfilmentCentersController
{
	public function addLocationStock()
    {
        if (null !== $response = $this->checkAuth(array(AdminResources::MODULE), array('MultipleFullfilmentCenters'), AccessManager::UPDATE)) {
            return $response;
        }

        $form = $this->createForm("addlocation.form");

        try {
            $data = $this->validateForm($form)->getData();

            $locationStock=  new FulfilmentCenter();

            $locationStock
            	->setName($data["name"])
            	->setAddress($data["address"])
            	->setGpsLat($data["gps_lat"])
            	->setGpsLong($data["gps_long"])
            	->setStockLimit($data["stock_limit"])
            	->save();

            return $this->generateSuccessRedirect($form);
        } catch (\Exception $e) {
            $this->setupFormErrorContext(
                $this->getTranslator()->trans("Error on new location : %message", ["message"=>$e->getMessage()], DeliveryDelay::DOMAIN_NAME),
                $e->getMessage(),
                $form
            );

            return self::viewAction();
        }
    }

    public function updateLocationStock()
    {
        if (null !== $response = $this->checkAuth(array(AdminResources::MODULE), array('MultipleFullfilmentCenters'), AccessManager::UPDATE)) {
            return $response;
        }

        $form = $this->createForm("addlocation.form");

        try {
            $data = $this->validateForm($form)->getData();

            $locationStock = FulfilmentCenterQuery::create()
                ->findOneById($data["id"]);

            if (null === $locationStock) {
                throw new \Exception($this->getTranslator()->trans("Location id doesn't exist"), array(), DeliveryDelay::DOMAIN_NAME);
            }

            $locationStock
                ->setName($data["name"])
                ->setAddress($data["address"])
                ->setGpsLat($data["gps_lat"])
                ->setGpsLong($data["gps_long"])
                ->setStockLimit($data["stock_limit"])
                ->save();

            return $this->generateSuccessRedirect($form);
        } catch (\Exception $e) {
            $this->setupFormErrorContext(
                $this->getTranslator()->trans("Error updating location : %message", ["message"=>$e->getMessage()], DeliveryDelay::DOMAIN_NAME),
                $e->getMessage(),
                $form
            );

            return self::viewAction();
        }
    }

    public function deleteLocationStock()
    {
        if (null !== $response = $this->checkAuth(array(AdminResources::MODULE), array('MultipleFullfilmentCenters'), AccessManager::UPDATE)) {
            return $response;
        }

        $form = $this->createForm("addlocation.form");

        try {
            $data = $this->validateForm($form)->getData();

            $locationStock = FulfilmentCenterQuery::create()
                ->findOneById($data["id"]);

            if (null === $locationStock) {
                throw new \Exception($this->getTranslator()->trans("Location id doesn't exist"), array(), DeliveryDelay::DOMAIN_NAME);
            }

            $locationStock->delete();

            return $this->generateSuccessRedirect($form);
        } catch (\Exception $e) {
            $this->setupFormErrorContext(
                $this->getTranslator()->trans("Error on location deletion : %message", ["message"=>$e->getMessage()], DeliveryDelay::DOMAIN_NAME),
                $e->getMessage(),
                $form
            );

            return self::viewAction();
        }
    }
}
