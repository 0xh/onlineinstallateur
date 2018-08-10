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

namespace LocalPickup\Hook;

use Thelia\Core\Event\Hook\HookRenderEvent;
use Thelia\Core\Hook\BaseHook;
use Thelia\Log\Tlog;
use LocalPickup\LocalPickup;

/**
 * Class HookManager
 * @package LocalPickup\Hook
 * @author Thomas Arnaud <tarnaud@openstudio.fr>
 */
class HookManager extends BaseHook
{
    public function onModuleConfiguration(HookRenderEvent $event)
    {
        $event->add($this->render("module_configuration.html"));
    }
    
public function onOrderDeliveryMethodHelpBlock(HookRenderEvent $event)       
     {
         Tlog::getInstance()->error("trying to render order-invoice" );
         if(LocalPickup::getModCode() == $event->getArgument("whoisallowed",null)) {
            $event->add($this->render("order-delivery.method.help-block.html")); 
         }
     }
     
public function onOrderDeliveryjavascriptInitialization(HookRenderEvent $event) 
{
   Tlog::getInstance()->error("hookmanager javascript include" );
    $event->add($this->render("order-delivery.javascript-initialization.html"));
}
}