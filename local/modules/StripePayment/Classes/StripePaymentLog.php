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
    const EMERGENCY = 'EMERGENCY';
    const ALERT     = 'ALERT';
    const CRITICAL  = 'CRITICAL';
    const ERROR     = 'ERROR';
    const WARNING   = 'WARNING';
    const NOTICE    = 'NOTICE';
    const INFO      = 'INFO';
    const DEBUG     = 'DEBUG';
    const LOGCLASS = "\\Thelia\\Log\\Destination\\TlogDestinationRotatingFile";

    /** @var Tlog $log */
    protected $log = null;

    /**
     * Log a message
     *
     * @param string $message  Message
     * @param string $severity EMERGENCY|ALERT|CRITICAL|ERROR|WARNING|NOTICE|INFO|DEBUG
     * @param string $category Category
     */
    public function logText($message, $severity = 'ALERT', $category = 'stripe')
    {
        $this->setTLogStripe();
        $msg = "$category.$severity: $message";
        $this->log->error($msg);
        // Back to previous state
       // $this->getBackToPreviousState();
    }

    /**
     * @return Tlog
     */
    protected function setTLogStripe()
    {
        /*
         * Write Log
         */
        if($this->log == null){
        $this->log = Tlog::getNewInstance();
        $this->log->setPrefix("#LEVEL: #DATE #HOUR: ");
        $this->log->setDestinations(self::LOGCLASS);
        $this->log->setConfig(self::LOGCLASS, 0, THELIA_LOG_DIR . DS .  "log-stripe.txt");
        $this->log->setLevel(Tlog::ERROR);
        }
    }

    protected function getBackToPreviousState()
    {
        $this->log->setDestinations("\\Thelia\\Log\\Destination\\TlogDestinationRotatingFile");
    }
}