<?php

/* * ********************************************************************************** */
/*                                                                                   */
/*      Thelia	                                                                     */
/*                                                                                   */
/*      Copyright (c) OpenStudio                                                     */
/*      email : info@thelia.net                                                      */
/*      web : http://www.thelia.net                                                  */
/*                                                                                   */
/*      This program is free software; you can redistribute it and/or modify         */
/*      it under the terms of the GNU General Public License as published by         */
/*      the Free Software Foundation; either version 3 of the License                */
/*                                                                                   */
/*      This program is distributed in the hope that it will be useful,              */
/*      but WITHOUT ANY WARRANTY; without even the implied warranty of               */
/*      MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the                */
/*      GNU General Public License for more details.                                 */
/*                                                                                   */
/*      You should have received a copy of the GNU General Public License            */
/* 	    along with this program. If not, see <http://www.gnu.org/licenses/>.         */
/*                                                                                   */
/* * ********************************************************************************** */

namespace LocalPickup;

use LocalPickup\Model\LocalPickupShippingQuery;
use Propel\Runtime\Connection\ConnectionInterface;
use Thelia\Install\Database;
use Thelia\Model\Country;
use Thelia\Model\ModuleQuery;
use Thelia\Module\AbstractDeliveryModule;
use Thelia\Model\AreaDeliveryModule;
use Thelia\Model\AreaDeliveryModuleQuery;
use Thelia\Core\Template\TemplateDefinition;

/**
 * Class LocalPickup
 * @package LocalPickup
 * @author Thelia <info@thelia.net>
 */
class LocalPickup extends AbstractDeliveryModule {

    /** @var string */
    const DOMAIN_NAME = 'localpickup';

    /**
     * calculate and return delivery price
     *
     * @param Country $country
     *
     * @return double
     */
    public function getPostage(Country $country) {
        return 0;
    }

    /**
     * @param ConnectionInterface $con
     */
    public function postActivation(ConnectionInterface $con = null) {
        $database = new Database($con);

        $database->insertSql(null, array(__DIR__ . "/Config/thelia.sql"));
    }

    /**
     * @return string
     */
    public function getCode() {
        return "LocalPickup";
    }

    public static function getModCode() {
        return ModuleQuery::create()
                        ->findOneByCode("LocalPickup")->getId();
    }

    /**
     * This method is called by the Delivery  loop, to check if the current module has to be displayed to the customer.
     * Override it to implements your delivery rules/
     *
     * If you return true, the delivery method will de displayed to the customer
     * If you return false, the delivery method will not be displayed
     *
     * @param Country $country the country to deliver to.
     *
     * @return boolean
     */
    public function isValidDelivery(Country $country) {

        $areaDeliveryModules = AreaDeliveryModuleQuery::create()->findByAreaId($country->getAreaId());
        foreach ($areaDeliveryModules as $areaModule) {
            if ($areaModule->getDeliveryModuleId() == ModuleQuery::create()->findOneByCode("LocalPickup")->getId())
                return true;
        }
        return false;
    }

    public function getHooks() {
        return array(
            array(
                "type" => TemplateDefinition::FRONT_OFFICE,
                "code" => "order-delivery.method.help-block",
                "title" => array(
                    "fr_FR" => "Drop-down menu for multiple LocalPickup locations",
                    "en_US" => "Drop-down menu for multiple LocalPickup locations",
                    "de_DE" => "Drop-down menu for multiple LocalPickup locations",
                ),
                "description" => array(
                    "fr_FR" => "Hook for displaying help information to order delivery elements in a drop-down menu for multiple locations",
                    "en_US" => "Hook for displaying help information to order delivery elements in a drop-down menu for multiple locations",
                    "de_DE" => "Hook for displaying help information to order delivery elements in a drop-down menu for multiple locations",
                ),
                "active" => true
            ),
            array(
                "type" => TemplateDefinition::EMAIL,
                "code" => "order-delivery.email-localpickup",
                "title" => array(
                    "fr_FR" => "Order Delivery Local Pickup email template",
                    "en_US" => "Order Delivery Local Pickup email template",
                    "de_DE" => "Order Delivery Local Pickup email template",
                ),
                "description" => array(
                    "fr_FR" => "Hook for defining a Order Delivery Local Pickup email template",
                    "en_US" => "Hook for defining a Order Delivery Local Pickup email template",
                    "de_DE" => "Hook for defining a Order Delivery Local Pickup email template",
                ),
                "active" => true
            ),
            array(
                "type" => TemplateDefinition::PDF,
                "code" => "order-delivery.pdf-localpickup",
                "title" => array(
                    "fr_FR" => "Order Delivery Local Pickup pdf template",
                    "en_US" => "Order Delivery Local Pickup pdf template",
                    "de_DE" => "Order Delivery Local Pickup pdf template",
                ),
                "description" => array(
                    "fr_FR" => "Hook for defining a Order Delivery Local Pickup pdf template",
                    "en_US" => "Hook for defining a Order Delivery Local Pickup pdf template",
                    "de_DE" => "Hook for defining a Order Delivery Local Pickup pdf template",
                ),
                "active" => true
            ),
            array(
                "type" => TemplateDefinition::FRONT_OFFICE,
                "code" => "order-delivery.address-localpickup",
                "title" => array(
                    "fr_FR" => "Local Pickup address template",
                    "en_US" => "Local Pickup address template",
                    "de_DE" => "Local Pickup address template",
                ),
                "description" => array(
                    "fr_FR" => "Hook for defining a Order Delivery Local Pickup address template",
                    "en_US" => "Hook for defining a Order Delivery Local Pickup address template",
                    "de_DE" => "Hook for defining a Order Delivery Local Pickup address template",
                ),
                "active" => true
            ),
            array(
                "type" => TemplateDefinition::BACK_OFFICE,
                "code" => "order-delivery.addressBack-localpickup",
                "title" => array(
                    "fr_FR" => "Local Pickup address template",
                    "en_US" => "Local Pickup address template",
                    "de_DE" => "Local Pickup address template",
                ),
                "description" => array(
                    "fr_FR" => "Hook for defining a Order Delivery Local Pickup address template",
                    "en_US" => "Hook for defining a Order Delivery Local Pickup address template",
                    "de_DE" => "Hook for defining a Order Delivery Local Pickup address template",
                ),
                "active" => true
            )
        );
    }

}
