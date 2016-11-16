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
/*************************************************************************************/
namespace BrandProductDisplay\Hook;

use Thelia\Core\Event\Hook\HookRenderEvent;
use \Thelia\Core\Hook\BaseHook;

/**
 * Class AdminHook
 */
class AdminHook extends BaseHook
{


    public function onBrandTabContent(HookRenderEvent $event)
    {
        $event->add($this->render("brand-product-list.html", $event->getArguments()));
    }
}
