<?php


namespace MultipleFullfilmentCenters\Hook\Admin;

use Thelia\Core\Event\Hook\HookRenderEvent;
use Thelia\Core\Hook\BaseHook;

class LocationStockEditHook extends BaseHook
{
	public function onProductStock(HookRenderEvent $event)
    { 
        $event->add($this->render(
            'location-stock/product/product.html'
        ));
    }

}
