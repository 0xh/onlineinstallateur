<?php

namespace FilterConfigurator\Hook\Admin;

use FilterConfigurator\FilterConfigurator;
use Thelia\Core\Event\Hook\HookRenderBlockEvent;
use Thelia\Core\Hook\BaseHook;
use Thelia\Tools\URL;

class HookManager extends BaseHook {

    public function onMainTopMenuTools(HookRenderBlockEvent $event) {
        $event->add([
            'id' => 'tools_menu_hook_filter_configurator',
            'class' => '',
            'url' => URL::getInstance()->absoluteUrl('/admin/module/FilterConfigurator'),
            'title' => $this->trans('Filter configurator', [], FilterConfigurator::DOMAIN_NAME)
        ]);
    }

}
