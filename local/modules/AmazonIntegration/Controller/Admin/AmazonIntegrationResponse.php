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

use Thelia\Log\Tlog;
use Thelia\Module\BasePaymentModuleController;

/**
 * Class AmazonResponse
 * 
 * @package Amazon\Controller
 * @author Thelia <info@thelia.net>
 */
class AmazonIntegrationResponse extends BasePaymentModuleController
{

    /* @var Tlog $log */
    protected static $logger;

    public static function logError($message)
    {
        self::setLogger()->error($message);
    }

    /**
     * Return a module identifier used to calculate the name of the log file,
     * and in the log messages.
     *
     * @return string the module code
     */
    protected function getModuleCode()
    {
        return "AmazonIntegration";
    }

    public function setLogger()
    {
        if (self::$logger == null) {
            self::$logger = Tlog::getNewInstance();
            
            $logFilePath = THELIA_LOG_DIR . DS . "log-amazon-integration.txt";
            
            self::$logger->setPrefix("#LEVEL: #DATE #HOUR: ");
            self::$logger->setDestinations("\\Thelia\\Log\\Destination\\TlogDestinationRotatingFile");
            self::$logger->setConfig("\\Thelia\\Log\\Destination\\TlogDestinationRotatingFile", 0, $logFilePath);
            self::$logger->setLevel(Tlog::ERROR);
        }
        return self::$logger;
    }
}
