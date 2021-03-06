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

namespace MultipleFullfilmentCenters;

use Propel\Runtime\Connection\ConnectionInterface;
use Thelia\Core\Template\TemplateDefinition;
use Thelia\Install\Database;
use Thelia\Module\BaseModule;

class MultipleFullfilmentCenters extends BaseModule
{
    /** @var string */
    const DOMAIN_NAME = 'multiplefullfilmentcenters';

    /*
     * You may now override BaseModuleInterface methods, such as:
     * install, destroy, preActivation, postActivation, preDeactivation, postDeactivation
     *
     * Have fun !
     */

    public function postActivation(ConnectionInterface $con = null)
    {        
        $database = new Database($con);
        $database->insertSql(null, [__DIR__ . "/Config/insert_hooks.sql"]);
        
        $database->insertSql(null, [__DIR__ . "/Config/insert_tables.sql"]);
        return TRUE;
    }

    public function getHooks()
    { 
        return array(
            array(
                "type" => TemplateDefinition::FRONT_OFFICE,
                "code" => "product.fulfilment-center",
                "title" => array(
                    "fr_FR" => "Hook Produit DeliveryDelay",
                    "en_US" => "Multiple Fulfilment Center",
                ),
                "description" => array(
                    "fr_FR" => "Hook pour délais de livraison d'un produit",
                    "en_US" => "Hook for multiple fulfilment center",
                ),
                "active" => true
            )
        );
    }
}
