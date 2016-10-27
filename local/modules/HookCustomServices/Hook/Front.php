<?php

namespace HookCustomServices\Hook;

use Thelia\Core\Event\Hook\HookRenderEvent;
use Thelia\Core\Hook\BaseHook;

class Front extends BaseHook{

	public function onMainHeadBottom(HookRenderEvent $event)
	{
		//$content = $this->addCSS('assets/css/dropzone.css');
		$event->add($content);
	}
}