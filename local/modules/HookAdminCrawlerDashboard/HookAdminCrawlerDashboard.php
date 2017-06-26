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
use HookAdminCrawlerDashboard\Model\CrawlerProductBaseQuery;
use Thelia\Log\Tlog;
class HookAdminCrawlerDashboard extends BaseModule
{
	const DOMAIN_NAME = 'admincrawlerdashboard';
	
	public function preActivation(ConnectionInterface $con = null)
	{
		//Tlog::getInstance()->error("pretactivation ".self::getConfigValue('is_initialized', false));
		return true;
	}
	
	public function postActivation(ConnectionInterface $con = null){
		//Tlog::getInstance()->error("postactivation ".self::getConfigValue('is_initialized', false));
		if (!self::getConfigValue('is_initialized', false)) {
			$database = new Database($con);
			
			$database->insertSql(null, [__DIR__ .DS."Config".DS."thelia.sql"]);//this drops the tables if they exist and creates them back
			$isTableEmpty = CrawlerProductBaseQuery::create()->count();
			if($isTableEmpty == 0)
				$database->insertSql(null, [__DIR__ .DS."Config".DS."load_tables.sql"]);//copy all 
			Tlog::getInstance()->error("tablehas ".$isTableEmpty);
			$isTableEmpty = CrawlerProductBaseQuery::create()->count();
			Tlog::getInstance()->error("tablehas ".$isTableEmpty);
			self::setConfigValue('is_initialized', true);
		}
	}
	
	public function postDeactivation(ConnectionInterface $con = null){
		self::setConfigValue('is_initialized', false);//TODO remove after dev
	}
	
	public function destroy(ConnectionInterface $con = null, $deleteModuleData = false)
	{
		if($deleteModuleData){
			$database = new Database($con);
			$database->insertSql(null, array(__DIR__ .DS."Config".DS."sql".DS."drop_crawler_tables.sql"));
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
