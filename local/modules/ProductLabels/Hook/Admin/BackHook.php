<?php
namespace ProductLabels\Hook\Admin;

use ProductLabels\ProductLabels;
use Thelia\Core\Event\Hook\HookRenderBlockEvent;
use Thelia\Core\Event\Hook\HookRenderEvent;
use Thelia\Core\Hook\BaseHook;
use Thelia\Tools\URL;

/**
 * Class BackHook
 * 
 * @package HookScraper\Hook
 */
class BackHook extends BaseHook
{

    
    public function onProductTabContent(HookRenderBlockEvent $event)
    {
        $event->add($this->render(
            'product-labels.html'
        ));
    }
}
