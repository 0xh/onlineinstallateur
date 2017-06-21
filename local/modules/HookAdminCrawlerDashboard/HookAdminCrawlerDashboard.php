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

namespace HookAdminCrawlerDashboard;

use Thelia\Module\BaseModule;
use Thelia\Install\Database;
use Propel\Runtime\Connection\ConnectionInterface;

class HookAdminCrawlerDashboard extends BaseModule
{
	const DOMAIN_NAME = 'admincrawlerdashboard';
	
	public function preActivation(ConnectionInterface $con = null)
	{
		
		return true;
	}
	
	public function postActivation(ConnectionInterface $con = null){
		if (!self::getConfigValue('is_initialized', false)) {
			$database = new Database($con);
			$database->insertSql(null, [__DIR__ . "/Config/thelia.sql"]);
			self::setConfigValue('is_initialized', true);
		}
	}
	
	public function destroy(ConnectionInterface $con = null, $deleteModuleData = false)
	{
		if($deleteModuleData){
			$database = new Database($con);
			$database->insertSql(null, array(__DIR__ . '/Config/sql/destroy.sql'));
		}
			
	}

	/**
	 * @param string $currentVersion
	 * @param string $newVersion
	 * @param ConnectionInterface $con
	 */
	public function update($currentVersion, $newVersion, ConnectionInterface $con = null)
	{

	}
}
