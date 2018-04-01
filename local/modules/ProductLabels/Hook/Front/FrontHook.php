<?php

namespace ProductLabels\Hook\Front;

use Thelia\Core\Event\Hook\HookRenderEvent;
use Thelia\Core\Hook\BaseHook;

class FrontHook extends BaseHook
{

    public function onAfterJavascriptInclude(HookRenderEvent $event)
    {
        $event->add($this->addJS('assets/js/quagga.js'));

    }

}