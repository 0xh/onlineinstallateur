<?php

namespace HookAdminCrawlerDashboard\Hook;

use HookAdminCrawlerDashboard\HookAdminCrawlerDashboard;
use Thelia\Core\Event\Hook\HookRenderEvent;
use Thelia\Core\Hook\BaseHook;
use Thelia\Log\Tlog;

/**
 * Class CrawlerDashboardHook
 * @package HookAdminCrawlerDashboard\Hook
 * @author Emanuel Plopu <emanuel.plopu@sepa.at>
 */
class CrawlerDashboardHook extends BaseHook
{

	public function blockCrawlerDashboardJs(HookRenderEvent $event)
    {
        $event->add($this->render('block-crawler-dashboard-js.html'));
    }

    public function blockCrawlerDashboard(HookRenderEvent $event)
    {
        $event->add($this->render('block-crawler-dashboard.html'));
    }

}
