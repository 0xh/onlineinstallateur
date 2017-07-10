<?php

namespace MultipleFullfilmentCenters\Controller\Admin;

use MultipleFullfilmentCenters\MultipleFullfilmentCenters;
use MultipleFullfilmentCenters\Model\ProductDelayQuery;
use Thelia\Core\HttpFoundation\JsonResponse;
use Thelia\Core\Security\AccessManager;
use Thelia\Core\Security\Resource\AdminResources;
use DeliveryDelay\DeliveryDelay;

class ConfigurationController extends MultipleFullfilmentCentersController
{
    public function setGlobalConfig()
    {
        if (null !== $response = $this->checkAuth(array(AdminResources::MODULE), array('MultipleFullfilmentCenters'), AccessManager::UPDATE)) {
            return $response;
        }

        $form = $this->createForm("locationstock.form");

        try {
            $data = $this->validateForm($form)->getData();

            // Configs
            MultipleFullfilmentCenters::setConfigValue("delivery_min", $data["delivery_min"]);
            MultipleFullfilmentCenters::setConfigValue("delivery_max", $data["delivery_max"]);
            MultipleFullfilmentCenters::setConfigValue("restock_min", $data["restock_min"]);
            MultipleFullfilmentCenters::setConfigValue("restock_max", $data["restock_max"]);

            // Exclude weekend ?
            $excludeWeekend = $data["exclude_weekend"] === "on" ? 1 :0 ;
            MultipleFullfilmentCenters::setConfigValue("exclude_weekend", $excludeWeekend);

            // Exclude easter day ?
            $excludeEasterDay = $data["exclude_easter_day"] === "on" ? 1 :0 ;
            MultipleFullfilmentCenters::setConfigValue("exclude_easter_day", $excludeEasterDay);

            // Exclude easter day based holidays ?
            $excludeEasterHolidays = $data["exclude_easter_day_based_holidays"] === "on" ? 1 :0 ;
            MultipleFullfilmentCenters::setConfigValue("exclude_easter_day_based_holidays", $excludeEasterHolidays);

            return $this->generateSuccessRedirect($form);

        } catch (\Exception $e) {
            $this->setupFormErrorContext(
                $this->getTranslator()->trans("Error on delivery delay configuration : %message", ["message"=>$e->getMessage()], DeliveryDelay::DOMAIN_NAME),
                $e->getMessage(),
                $form
            );

            return self::viewAction();
        }
    }

    public function setProductConfig($product_id)
    {
        if (null !== $response = $this->checkAuth(array(AdminResources::MODULE), array('MultipleFullfilmentCenters'), AccessManager::UPDATE)) {
            return $response;
        }

        $form = $this->createForm("locationstock.form");

        try {
            $data = $this->validateForm($form)->getData();

            $productDelay = ProductDelayQuery::create()
                ->filterByProductId($product_id)
                ->findOneOrCreate();

            $productDelay->setDeliveryDelayMin($data["delivery_min"])
                ->setDeliveryDelayMax($data["delivery_max"])
                ->setRestockDelayMin($data["restock_min"])
                ->setRestockDelayMax($data["restock_max"])
                ->setDeliveryDateStart($data["delivery_date_start"])
                ->setDeliveryType($data["delivery_type"])
                ->save();

            return new JsonResponse($this->getTranslator()->trans("Delivery delay product configuration updated with success!", [], DeliveryDelay::DOMAIN_NAME));
        } catch (\Exception $e) {

            $message = $this->getTranslator()->trans("Error on delivery delay product configuration : %message", ["%message"=>$e->getMessage()], DeliveryDelay::DOMAIN_NAME);
            $form->setErrorMessage($message);

            $this->getParserContext()
                ->addForm($form)
                ->setGeneralError($message)
            ;

            return new JsonResponse($message, 500);
        }
    }
}
