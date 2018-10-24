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

namespace FilterConfigurator;

use Propel\Runtime\Connection\ConnectionInterface;
use Thelia\Core\Template\TemplateDefinition;
use Thelia\Install\Database;
use Thelia\Module\BaseModule;

class FilterConfigurator extends BaseModule
{

    /** @var string */
    const DOMAIN_NAME = 'filterconfigurator';

    public function postActivation(ConnectionInterface $con = null)
    {
        $database = new Database($con);

        if (!$this->getConfigValue('is_initialized', false)) {
            $database->insertSql(null, array(__DIR__ . "/Config/thelia.sql"));

            $this->setConfigValue('is_initialized', true);
        }

        return true;
    }

    public function getHooks()
    {
        return array(
         array(
          "type"        => TemplateDefinition::FRONT_OFFICE,
          "code"        => "configurator.filters.selection",
          "title"       => array(
           "fr_FR" => "configurator.filters.selection",
           "en_US" => "configurator.filters.selection",
           "de_DE" => "configurator.filters.selection",
          ),
          "description" => array(
           "fr_FR" => "configurator.filters.selection",
           "en_US" => "configurator.filters.selection",
           "de_DE" => "configurator.filters.selection",
          ),
          "active"      => true
         ),
         array(
          "type"        => TemplateDefinition::FRONT_OFFICE,
          "code"        => "configurator.filters",
          "title"       => array(
           "fr_FR" => "configurator.filters",
           "en_US" => "configurator.filters",
           "de_DE" => "configurator.filters",
          ),
          "description" => array(
           "fr_FR" => "configurator.filters",
           "en_US" => "configurator.filters",
           "de_DE" => "configurator.filters",
          ),
          "active"      => true
         ),
        );
    }

}
