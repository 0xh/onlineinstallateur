<?php
namespace FilterConfigurator\Hook\Front;

use FilterConfigurator\FilterConfigurator;
use Thelia\Core\Event\Hook\HookRenderEvent;
use Thelia\Core\Hook\BaseHook;

class FrontHook extends BaseHook
{
	
	public function configuratorDescription(HookRenderEvent $event)
	{
		$params["category_id"] = $event->getArgument('category_id');
		
		$event->add($this->render(
				'configurator-details.html',
				$params
				));
	}
	
	public function configuratorFilters(HookRenderEvent $event)
	{
		$params["category_id"] = $event->getArgument('category_id');
		$params["categories"] = $event->getArgument('categories');
		
		$event->add($this->render(
				'configurator-filters.html',
				$params
				));
	}
	
}
