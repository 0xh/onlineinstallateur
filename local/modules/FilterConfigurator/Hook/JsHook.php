<?php
namespace FilterConfigurator\Hook;

use FilterConfigurator\FilterConfigurator;
use Thelia\Core\Event\Hook\HookRenderEvent;
use Thelia\Core\Hook\BaseHook;

class JsHook extends BaseHook
{
	
	public function onMainJs(HookRenderEvent $event)
	{
		$event->add($this->addCSS('assets/css/fastselect.min.css'));
		$event->add($this->addJS('assets/js/fastsearch.js'));
		$event->add($this->addJS('assets/js/fastselect.js')); 
		
	}
	
}
