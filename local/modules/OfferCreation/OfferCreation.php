<?php
/*************************************************************************************/
/*      This file is part of the Thelia package.                                     */
/*                                                                                   */
/*      Copyright (c) OpenStudio                                                     */
/*      email : dev@thelia.net                                                       */
/*      web : http://www.thelia.net                                                  */
/*                                                                                   */
/*      For the full copyright and license information, please view the LICENSE.txt  */
/*      file that was distributed with this source code.                             */
/*************************************************************************************/

namespace OfferCreation;

use Thelia\Module\BaseModule;
use Propel\Runtime\Connection\ConnectionInterface;
use Thelia\Install\Database;

class OfferCreation extends BaseModule
{
    /** @var string */
    const DOMAIN_NAME = 'offercreation';

    public function postActivation(ConnectionInterface $con = null)
    {
    	$database = new Database($con);
    	$database->insertSql(null, [__DIR__ . "/Config/insert_hooks.sql"]);
    	$database->insertSql(null, [__DIR__ . "/Config/insert_config.sql"]);
    	
    	if (!self::getConfigValue('is_initialized', false)) {
    		$database->insertSql(null, [__DIR__ . "/Config/insert_tables.sql"]);
    		self::setConfigValue('is_initialized', true);
    	}
    }
}
