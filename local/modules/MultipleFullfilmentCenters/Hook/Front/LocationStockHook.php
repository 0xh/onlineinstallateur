<?php


namespace MultipleFullfilmentCenters\Hook\Front;

use Thelia\Core\Event\Hook\HookRenderEvent;
use Thelia\Core\Hook\BaseHook;

class LocationStockHook extends BaseHook
{
	public function locationStockOrderInvoice(HookRenderEvent $event)
	{	
		$product["productId"] = $event->getArgument('product');
		$product["cartId"] = $event->getArgument('cart');
		$product["quantity"] = $event->getArgument('quantity');
		$product["fulfimentCenterId"] = $event->getArgument('center');
		
		$event->add($this->render(
				'product-location-stock.html' ,
				$product 
				));
	}
	
 	public function locationStockOrderPlaced(HookRenderEvent $event)
	{
		$product["orderId"] = $event->getArgument('orderid');
		$event->add($this->render(
				'product-location-order-placed.html',
				$product
				));
	} 
}
