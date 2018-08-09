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
//        return LocalPickupShippingQuery::create()->getPrice();
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
                    "fr_FR" => "Order Delivery Help Block",
                    "en_US" => "Order Delivery Help Block",
                    "de_DE" => "Order Delivery Help Block",
                ),
                "description" => array(
                    "fr_FR" => "Hook for displaying help information to order delivery elements",
                    "en_US" => "Hook for displaying help information to order delivery elements",
                    "de_DE" => "Hook for displaying help information to order delivery elements",
                ),
                "active" => true
            )
        );
    }
    

}
