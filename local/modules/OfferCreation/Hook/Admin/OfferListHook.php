<?php

namespace OfferCreation\Hook\Admin;

use Thelia\Core\Event\Hook\HookRenderEvent;
use Thelia\Core\Hook\BaseHook;

class OfferListHook extends BaseHook
{
	public function listOffers(HookRenderEvent $event)
	{
		$event->add($this->render(
				'list-offers.html'
				));
	}
}
