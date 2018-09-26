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

namespace FullWidthBlock;

use Thelia\Core\Template\TemplateDefinition;
use Thelia\Module\BaseModule;

class FullWidthBlock extends BaseModule
{
    /** @var string */
    const DOMAIN_NAME = 'fullwidthblock';

    
    public function getHooks() {
        return array(
            array(
                "type" => TemplateDefinition::FRONT_OFFICE,
                "code" => "full_with_block.layout_tpl",
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
            ),
            array(
                "type" => TemplateDefinition::FRONT_OFFICE,
                "code" => "full_with_block.home",
                "title" => array(
                    "fr_FR" => "Full with hook for home",
                    "en_US" => "Full with hook for home",
                ),
                "description" => array(
                    "fr_FR" => "Full with hook for home",
                    "en_US" => "Full with hook for home",
                ),
                "chapo" => array(
                    "fr_FR" => "Full with hook for home",
                    "en_US" => "Full with hook for home",
                ),
                "block" => false,
                "active" => true
            ),
            array(
                "type" => TemplateDefinition::FRONT_OFFICE,
                "code" => "full_with_block.category",
                "title" => array(
                    "fr_FR" => "Full with hook for category",
                    "en_US" => "Full with hook for category",
                ),
                "description" => array(
                    "fr_FR" => "Full with hook for category",
                    "en_US" => "Full with hook for category",
                ),
                "chapo" => array(
                    "fr_FR" => "Full with hook for category",
                    "en_US" => "Full with hook for category",
                ),
                "block" => false,
                "active" => true
            ),
            array(
                "type" => TemplateDefinition::FRONT_OFFICE,
                "code" => "full_with_block.product",
                "title" => array(
                    "fr_FR" => "Full with hook for product",
                    "en_US" => "Full with hook for product",
                ),
                "description" => array(
                    "fr_FR" => "Full with hook for product",
                    "en_US" => "Full with hook for product",
                ),
                "chapo" => array(
                    "fr_FR" => "Full with hook for product",
                    "en_US" => "Full with hook for product",
                ),
                "block" => false,
                "active" => true
            ),
            array(
                "type" => TemplateDefinition::FRONT_OFFICE,
                "code" => "full_with_block.category.inspiration",
                "title" => array(
                    "fr_FR" => "Full with hook for product",
                    "en_US" => "Full with hook for product",
                ),
                "description" => array(
                    "fr_FR" => "Full with hook for product",
                    "en_US" => "Full with hook for product",
                ),
                "chapo" => array(
                    "fr_FR" => "Full with hook for product",
                    "en_US" => "Full with hook for product",
                ),
                "block" => false,
                "active" => true
            ),
            array(
                "type" => TemplateDefinition::FRONT_OFFICE,
                "code" => "full_with_block.configurator.inspiration",
                "title" => array(
                    "fr_FR" => "Full with hook for product",
                    "en_US" => "Full with hook for product",
                ),
                "description" => array(
                    "fr_FR" => "Full with hook for product",
                    "en_US" => "Full with hook for product",
                ),
                "chapo" => array(
                    "fr_FR" => "Full with hook for product",
                    "en_US" => "Full with hook for product",
                ),
                "block" => false,
                "active" => true
            ),
            array(
                "type" => TemplateDefinition::FRONT_OFFICE,
                "code" => "full_with_block.inspiration.page",
                "title" => array(
                    "fr_FR" => "Full with hook for product",
                    "en_US" => "Full with hook for product",
                ),
                "description" => array(
                    "fr_FR" => "Full with hook for product",
                    "en_US" => "Full with hook for product",
                ),
                "chapo" => array(
                    "fr_FR" => "Full with hook for product",
                    "en_US" => "Full with hook for product",
                ),
                "block" => false,
                "active" => true
            ),
            array(
                "type" => TemplateDefinition::FRONT_OFFICE,
                "code" => "full_with_block",
                "title" => array(
                    "fr_FR" => "Full with block",
                    "en_US" => "Full with block",
                ),
                "description" => array(
                    "fr_FR" => "Full with block",
                    "en_US" => "Full with block",
                ),
                "chapo" => array(
                    "fr_FR" => "Full with block",
                    "en_US" => "Full with block",
                ),
                "block" => true,
                "active" => true
            )
        );
    }
}
