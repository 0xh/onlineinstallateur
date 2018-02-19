<?php

namespace HookServices\Hook;

use Thelia\Core\Event\Hook\HookRenderEvent;
use Thelia\Core\Hook\BaseHook;
use Thelia\Log\Tlog;


class Front extends BaseHook{

    public function onMainHeadBottom(HookRenderEvent $event)
    {
         $content = $this->addCSS("assets/css/services.css");
         //$event->add($this->mark($this->addCSS("assets/css/styles.css")));
         $event->add($content);
		//$content = $this->addJS('asssets/js/script.js');
		//$event->add($content);
	}
		
    public function onServicesjsBottom(HookRenderEvent $event)
    {

    	//$event->add($this->addJS("assets/js/demo.js"));
        //$event->add($this->addJS("assets/js/deps.js"));

    }
     public function onRegisterAfterJavascriptInclude(HookRenderEvent $event)
    {

    	$event->add($this->addJS("assets/js/demo.js"));
        $event->add($this->addJS("assets/js/deps.js"));

    }
    
}
