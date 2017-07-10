<?php


namespace MultipleFullfilmentCenters\Hook\Front;

use MultipleFullfilmentCenters\Handler\LocationStockHandler;
use Thelia\Core\Event\Hook\HookRenderEvent;
use Thelia\Core\Hook\BaseHook;

class LocationStockHook extends BaseHook
{
    public function onProductDeliveryDelay(HookRenderEvent $event)
    {
        $productId = $event->getArgument('product');

        $handler = new LocationStockHandler();
        $delivery = $handler->getDelayForProduct($productId);

        $event->add($this->render(
            'delivery-delay/product-delivery-delay.html',
            $delivery
        ));
    }

    public function onProductDetailsBottom(HookRenderEvent $event)
    {
       $this->onProductDeliveryDelay($event) ;
    }
}
