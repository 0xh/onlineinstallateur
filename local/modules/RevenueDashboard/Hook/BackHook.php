<?php

namespace RevenueDashboard\Hook;

use RevenueDashboard\RevenueDashboard;
use Thelia\Core\Event\Hook\HookRenderBlockEvent;
use Thelia\Core\Event\Hook\HookRenderEvent;
use Thelia\Core\Hook\BaseHook;
use Thelia\Tools\URL;

/**
 * Class BackHook
 * 
 * @package HookScraper\Hook
 */
class BackHook extends BaseHook {

    /**
     * Add a new entry in the admin tools menu
     *
     * should add to event a fragment with fields : id,class,url,title
     *
     * @param HookRenderBlockEvent $event
     */
    public function onMainTopMenuTools(HookRenderBlockEvent $event) {
        $event->add([
            'id' => 'tools_menu_hook_revenue_dashboard',
            'class' => '',
            'url' => URL::getInstance()->absoluteUrl('/admin/module/revenuedashboard'),
            'title' => $this->trans('Revenue Dashboard', [], RevenueDashboard::DOMAIN_NAME)
        ]);
    }

    public function onMainJs(HookRenderEvent $event)
    {
        $event->add($this->addJS('assets/js/typeahead.bundle.js'));
    }
    
//    public function onMainCss(HookRenderEvent $event)
//    {
//        $event->add($this->addCSS('assets/css/amazonintegration.css'));
//        $event->add($this->addCSS('assets/css/jquery-ui.css'));
//    }
}
