<?php

namespace CronDashboard\Hook\Admin;

use CronDashboard\CronDashboard;
use Thelia\Core\Event\Hook\HookRenderBlockEvent;
use Thelia\Core\Hook\BaseHook;
use Thelia\Tools\URL;
use Thelia\Core\Event\Hook\HookRenderEvent;
use CronDashboard\Controller\CronDashboardProcessController;
use CronDashboard\Classes\Process;
use Thelia\Model\ModuleConfig;
use Thelia\Model\ModuleConfigQuery;

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

    public function onContentTabContentLogs(HookRenderEvent $event)
    {
        $event->add($this->render(
            'processes_logs.html'
        ));
    }

    public function onModuleConfigure(HookRenderEvent $event) {       

         if (null !== $params = ModuleConfigQuery::create()->findByModuleId(CronDashboard::getModuleId())) {
            /** @var ModuleConfig $param */
            foreach ($params as $param) {
                $vars[$param->getName()] = $param->getValue();
            }
        }

        $event->add(
                $this->render('module-configuration.html', $vars)
        );
    }
}