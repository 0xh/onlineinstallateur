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

namespace TabbedProductWidget;

use Thelia\Module\BaseModule;
use Thelia\Core\Template\TemplateDefinition;

class TabbedProductWidget extends BaseModule {

    /** @var string */
    const DOMAIN_NAME = 'tabbedproductwidget';

    public function getHooks() {
        return array(
            array(
                "type" => TemplateDefinition::FRONT_OFFICE,
                "code" => "full_with_before_content",
                "title" => array(
                    "fr_FR" => "Full with hook",
                    "en_US" => "Full with hook",
                ),
                "description" => array(
                    "fr_FR" => "Full with hook",
                    "en_US" => "Full with hook",
                ),
                "chapo" => array(
                    "fr_FR" => "Full with hook",
                    "en_US" => "Full with hook",
                ),
                "block" => false,
                "active" => true
            )
        );
    }
}
