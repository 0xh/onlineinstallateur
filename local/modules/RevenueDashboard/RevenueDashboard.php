<?php

/* * ********************************************************************************** */
/*      This file is part of the Thelia package.                                     */
/*                                                                                   */
/*      Copyright (c) OpenStudio                                                     */
/*      email : dev@thelia.net                                                       */
/*      web : http://www.thelia.net                                                  */
/*                                                                                   */
/*      For the full copyright and license information, please view the LICENSE.txt  */
/*      file that was distributed with this source code.                             */
/* * ********************************************************************************** */

namespace RevenueDashboard;

use Propel\Runtime\Connection\ConnectionInterface;
use Thelia\Install\Database;
use Thelia\Module\BaseModule;

class RevenueDashboard extends BaseModule
{

    /** @var string */
    const DOMAIN_NAME = 'revenuedashboard';

    /*
     * You may now override BaseModuleInterface methods, such as:
     * install, destroy, preActivation, postActivation, preDeactivation, postDeactivation
     *
     * Have fun !
     */

    public function postActivation(ConnectionInterface $con = null)
    {

        $database = new Database($con);

//        if (!self::getConfigValue('is_initialized', false)) {
        $database->insertSql(null, [__DIR__ . "/Config/thelia.sql"]);
//            self::setConfigValue('is_initialized', true);
//        }

        $database->insertSql(null, [
         __DIR__ . "/Config/hook.sql"
        ]);
        return true;
    }

    public function preDeactivation(ConnectionInterface $con = null)
    {
        $database = new Database($con);
        $database->insertSql(null, [
         __DIR__ . "/Config/deleteTable.sql"
        ]);
        return true;
    }

}
