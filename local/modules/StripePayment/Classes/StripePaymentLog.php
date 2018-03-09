<?php

namespace StripePayment\Classes;

use Thelia\Log\Tlog;

/**
 * Class StripePaymentLog
 * @package StripePayment\Classes
 * @author Etienne Perriere - OpenStudio <eperriere@openstudio.fr>
 */
class StripePaymentLog
{
    /* @var Tlog $log */
    protected static $logger;
    
    public function logText($message)
    {
        self::setLogger()->error($message);
    }
    
    public function setLogger()
    {
        if (self::$logger == null) {
            self::$logger = Tlog::getNewInstance();
            
            $logFilePath = THELIA_LOG_DIR . DS . "log-stripe.txt";
            
            self::$logger->setPrefix("#LEVEL: #DATE #HOUR: ");
            self::$logger->setDestinations("\\Thelia\\Log\\Destination\\TlogDestinationRotatingFile");
            self::$logger->setConfig("\\Thelia\\Log\\Destination\\TlogDestinationRotatingFile", 0, $logFilePath);
            self::$logger->setLevel(Tlog::ERROR);
        }
        return self::$logger;
    }

    public static function getLogFilePath()
    {
        return THELIA_LOG_DIR . DS . "log-stripe.txt";
    }
    
}