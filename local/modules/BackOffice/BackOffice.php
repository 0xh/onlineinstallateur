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

namespace BackOffice;

use Thelia\Module\BaseModule;
use Thelia\Install\Database;
use Propel\Runtime\Connection\ConnectionInterface;

class BackOffice extends BaseModule
{
    /** @var string */
    const DOMAIN_NAME = 'backoffice';

    public function postActivation(ConnectionInterface $con = null)
    {
    	$database = new Database($con);
    	
    	if (!self::getConfigValue('is_initialized', false)) {
    		$database->insertSql(null, [__DIR__ . "/Config/insert_email_message.sql"]);
    		self::setConfigValue('is_initialized', true);
    	}
    }
}
