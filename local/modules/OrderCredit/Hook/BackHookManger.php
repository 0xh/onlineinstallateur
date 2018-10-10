<?php
namespace OrderCredit\Hook;

use Thelia\Core\Event\Hook\HookRenderEvent;
use Thelia\Core\Hook\BaseHook;
/**
 * Class BackHookManager
 * @package OrderCredit\Hook\Back
 * @author Emanuel Plopu <emanuel.plopu@sepa.at>
 */
class BackHookManger extends BaseHook
{
    public function onCreateCreditOrderBack(HookRenderEvent $event)
    {
        $event->add($this->render("order.tab-content.html"));
    }
    
    public function onOrderEditJs(HookRenderEvent $event)
    {
        $event->add($this->render("order.tab-content.js.html"));
    }
}
