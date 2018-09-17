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

namespace HookConfigurator;

use Exception;
use Propel\Runtime\Connection\ConnectionInterface;
use Thelia\Core\Template\TemplateDefinition;
use Thelia\Core\Translation\Translator;
use Thelia\Install\Database;
use Thelia\Module\BaseModule;

class HookConfigurator extends BaseModule {

    /** @var string */
    const DOMAIN_NAME = 'hookconfigurator';

    public function postActivation(ConnectionInterface $con = null) {


        $directory = "media/thumbs/configurator/";
        $this->createDirectory($directory);

        $directory = "configurator/";
        $this->createDirectory($directory);

        $database = new Database($con);
        $database->insertSql(null, [
            __DIR__ . "/Config/thelia.sql"
        ]);
        $database->insertSql(null, [
            __DIR__ . "/Config/configurator_hook.sql"
        ]);
        return true;
    }

    protected function createDirectory($directory) {
        if (!file_exists($directory)) {
            if (!mkdir($directory, 0777)) {
                throw new Exception(
                Translator::getInstance()->trans("Can\'t create directory: " . $directory)
                );
            }
            exit;
        }
    }

    public function getHooks() {
        return array(
            array(
                "type" => TemplateDefinition::FRONT_OFFICE,
                "code" => "configurator.questions",
                "title" => array(
                    "fr_FR" => "configurator.questions",
                    "en_US" => "configurator.questions",
                    "de_DE" => "configurator.questions",
                ),
                "description" => array(
                    "fr_FR" => "configurator.questions",
                    "en_US" => "configurator.questions",
                    "de_DE" => "configurator.questions",
                ),
                "active" => true
            ),
            array(
                "type" => TemplateDefinition::FRONT_OFFICE,
                "code" => "configurator.results",
                "title" => array(
                    "en_US" => "Configurator Results hook",
                    "de_DE" => "Konfigurator Ergebnisse hook",
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
