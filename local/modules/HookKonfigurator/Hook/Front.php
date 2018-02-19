<?php

namespace HookKonfigurator\Hook;

use Thelia\Core\Event\Hook\HookRenderEvent;
use Thelia\Core\Hook\BaseHook;

class Front extends BaseHook{

    public function onMainHeadBottom(HookRenderEvent $event)
    {
        $content = $this->addCSS('assets/css/styles.css');
        $event->add($content);
		//$content = $this->addJS('asssets/js/script.js');
		//$event->add($content);
		}

    public function onKonfiguratorSuggestions(HookRenderEvent $event)
    {
        $content = $this->render('konfigurator-suggestions.html',array(
                "brennstoff_zukunft"        => $this->getRequest()->request->get('konfigurator')['brennstoff_zukunft']));
        $event->add($content);
    }
    public function onMainNavbarPrimary(HookRenderEvent $event)
    {
    	$content = $this->render('main-navbar-primary.html');
    	$event->add($content);
    }
    
}
