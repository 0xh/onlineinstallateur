<?php

namespace CronDashboard\Hook\Admin;

use CronDashboard\CronDashboard;
use Thelia\Core\Event\Hook\HookRenderBlockEvent;
use Thelia\Core\Hook\BaseHook;
use Thelia\Tools\URL;
use Thelia\Core\Event\Hook\HookRenderEvent;
use CronDashboard\Controller\CronDashboardProcessController;
use CronDashboard\Classes\Process;

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

    public function onContentTabContent(HookRenderEvent $event)
    {
        $event->add($this->render(
            'processes.html', array("arrProcesses" => CronDashboardProcessController::getProcessLists() )
        ));
    }
}
