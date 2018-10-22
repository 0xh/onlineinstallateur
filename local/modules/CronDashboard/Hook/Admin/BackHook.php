<?php

namespace CronDashboard\Hook\Admin;

use CronDashboard\CronDashboard;
use Thelia\Core\Event\Hook\HookRenderBlockEvent;
use Thelia\Core\Hook\BaseHook;
use Thelia\Tools\URL;

class BackHook extends BaseHook
{

    public function onMainTopMenuTools(HookRenderBlockEvent $event)
    {
        $event->add(
            [
                'id' => 'tools_menu_cron_dashboard',
                'class' => '',
                'url' => URL::getInstance()->absoluteUrl('/admin/crondashboard'),
                'title' => $this->trans('Cron Dashboard', [], CronDashboard::DOMAIN_NAME)
            ]
        );
    }
}
