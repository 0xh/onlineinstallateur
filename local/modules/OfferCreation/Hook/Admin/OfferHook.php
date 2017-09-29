<?php


namespace OfferCreation\Hook\Admin;

use Thelia\Core\Event\Hook\HookRenderEvent;
use Thelia\Core\Hook\BaseHook;


class OfferHook extends BaseHook
{
	public function employeeNotice(HookRenderEvent $event)
	{
		$event->add($this->render(
				'employee-note.html'
				));
	}
	
	public function customProductPrice(HookRenderEvent $event)
	{
		$product['price'] = $event->getArgument('price');
		$event->add($this->render(
				'product-price.html',
				$product
				));
	}
}
