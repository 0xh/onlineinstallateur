<?php


namespace Front\Hook\Front;

use Thelia\Core\Event\Hook\HookRenderEvent;
use Thelia\Core\Hook\BaseHook;
use Thelia\Model\OrderQuery;

class ExistingOrderMessage extends BaseHook
{
	public function viewAction(HookRenderEvent $event)
	{	
		
		$cart = $this->getSession()->getSessionCart();
		$existingOrders = OrderQuery::create()->findOneByCartId($cart->getId());
		
		$params["existing_order"] = '';
		
		if($existingOrders != null) {
			$params["existing_order"] = 1;
		}
		
		$event->add($this->render(
				'existing-order-message.html' ,
				$params
				));
	}
}
