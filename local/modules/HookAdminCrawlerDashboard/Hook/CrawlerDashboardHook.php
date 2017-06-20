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
    	Tlog::getInstance()->err("gotherecrawler");
        $event->add($this->render('block-crawler-dashboard-js.html'));
    }

    public function blockCrawlerDashboard(HookRenderEvent $event)
    {
  /* 	Tlog::getInstance()->err("gotherecrawler");
        $content = trim($this->render("block-crawler-dashboard.html"));
        if (!empty($content)) {
            $event->add([
                "id" => "block-crawler-dashboard",
                "title" => $this->trans("Sales statistics", [], HookAdminCrawlerDashboard::DOMAIN_NAME),
                "content" => $content
            ]);
        }*/
        $event->add($this->render('block-crawler-dashboard.html'));
    }

}
