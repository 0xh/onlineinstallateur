<?php

/* * ********************************************************************************** */
/*      This file is part of the GoogleTagManager package.                           */
/*                                                                                   */
/*      Copyright (c) OpenStudio                                                     */
/*      email : dev@thelia.net                                                       */
/*      web : http://www.thelia.net                                                  */
/*                                                                                   */
/*      For the full copyright and license information, please view the LICENSE.txt  */
/*      file that was distributed with this source code.                             */
/* * ********************************************************************************** */

namespace GoogleTagManager;

use Thelia\Module\BaseModule;
use Thelia\Core\Template\TemplateDefinition;

class GoogleTagManager extends BaseModule {

    /** @var string */
    const DOMAIN_NAME = 'googletagmanager';

    public function getHooks() {
        return array(
            array(
                "type" => TemplateDefinition::FRONT_OFFICE,
                "code" => "order-placed.javascript-datalayer",
                "title" => array(
                    "fr_FR" => "order-placed.javascript-datalayer",
                    "en_US" => "order-placed.javascript-datalayer",
                    "de_DE" => "order-placed.javascript-datalayer",
                ),
                "description" => array(
                    "fr_FR" => "order-placed.javascript-datalayer",
                    "en_US" => "order-placed.javascript-datalayer",
                    "de_DE" => "order-placed.javascript-datalayer",
                ),
                "active" => true
            )
        );
    }

}
