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

namespace CronDashboard;

use Thelia\Module\BaseModule;
use Propel\Runtime\Connection\ConnectionInterface;
use Thelia\Core\Template\TemplateDefinition;
use Thelia\Install\Database;

class CronDashboard extends BaseModule
{
    /** @var string */
    const DOMAIN_NAME = 'crondashboard';

    /*
     * You may now override BaseModuleInterface methods, such as:
     * install, destroy, preActivation, postActivation, preDeactivation, postDeactivation
     *
     * Have fun !
     */
	
	public function postActivation(ConnectionInterface $con = null)
    {
        if (!self::getConfigValue('is_initialized', false)) { 
            $database = new Database($con);
            $database->insertSql(null, [__DIR__ . "/Config/thelia.sql"]);
            self::setConfigValue('is_initialized', true);
        }
    }

    public function getHooks()
    {
        return array(
            array(
                "type" => TemplateDefinition::BACK_OFFICE,
                "code" => "display.processes",
                "title" => array(
                    "en_US" => "Manage processes in backoffice",
                    "de_DE" => "Manage processes in backoffice",
                ),
                "description" => array(
                    "en_US" => "",
                    "de_DE" => "",
                ),
                "chapo" => array(
                    "en_US" => "",
                    "de_DE" => "",
                ),
                "block" => false,
                "active" => true
            ),
            array(
                "type" => TemplateDefinition::BACK_OFFICE,
                "code" => "display.processes_logs",
                "title" => array(
                    "en_US" => "Manage processes logs in backoffice",
                    "de_DE" => "Manage processes logs in backoffice",
                ),
                "description" => array(
                    "en_US" => "",
                    "de_DE" => "",
                ),
                "chapo" => array(
                    "en_US" => "",
                    "de_DE" => "",
                ),
                "block" => false,
                "active" => true
            )
        );
    }
}
