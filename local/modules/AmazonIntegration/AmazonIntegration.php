<?php
/*************************************************************************************/
/* This file is part of the Thelia package. */
/* */
/* Copyright (c) OpenStudio */
/* email : dev@thelia.net */
/* web : http://www.thelia.net */
/* */
/* For the full copyright and license information, please view the LICENSE.txt */
/* file that was distributed with this source code. */
/**
 * **********************************************************************************
 */
namespace AmazonIntegration;

use Thelia\Module\BaseModule;
use Propel\Runtime\Connection\ConnectionInterface;
use Thelia\Install\Database;

class AmazonIntegration extends BaseModule
{

    /** @var string */
    const DOMAIN_NAME = 'amazonintegration';

    public function preActivation(ConnectionInterface $con = null)
    {
        $database = new Database($con);
        $database->insertSql(null, [
            __DIR__ . "/Config/thelia.sql"
        ]);
        return true;
    }
}
