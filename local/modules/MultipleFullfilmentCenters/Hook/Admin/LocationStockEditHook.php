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
    
    public function orderLocationAddress(HookRenderEvent $event)
    {
    	$product["orderId"] = $event->getArgument('orderid');
    	$event->add($this->render(
    			'location-stock/product-location-address.html',
    			$product
    			));
    } 
    
    public function orderLocationAddressPdf(HookRenderEvent $event)
    {
    	$product["orderId"] = $event->getArgument('orderid');
    	$event->add($this->render(
    			'product-location-address.html',
    			$product
    			));
    } 
    
    public function orderLocationAddressEmail(HookRenderEvent $event)
    {
    	$product["orderId"] = $event->getArgument('orderid');
    	$event->add($this->render(
    			'product-location-address.html',
    			$product
    			));
    } 
}
