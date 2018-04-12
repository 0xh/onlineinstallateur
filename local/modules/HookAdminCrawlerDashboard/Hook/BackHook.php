<?php
namespace HookAdminCrawlerDashboard\Hook;

use HookAdminCrawlerDashboard\HookAdminCrawlerDashboard;
use Thelia\Core\Event\Hook\HookRenderBlockEvent;
use Thelia\Core\Hook\BaseHook;
use Thelia\Tools\URL;

/**
 * Class BackHook
 * @package HookScraper\Hook
 * @author Emmanuel Plopu <emanuel.plopu@sepa.at>
 */
class BackHook extends BaseHook
{

    /**
     * Add a new entry in the admin tools menu
     *
     * should add to event a fragment with fields : id,class,url,title
     *
     * @param HookRenderBlockEvent $event
     */
    public function onMainTopMenuTools(HookRenderBlockEvent $event)
    {
        $event->add(
            [
                'id' => 'tools_menu_hookcrawler',
                'class' => '',
                'url' => URL::getInstance()->absoluteUrl('/admin/module/HookAdminCrawlerDashboard'),
            	'title' => $this->trans('Crawler', [], HookAdminCrawlerDashboard::DOMAIN_NAME)
            ]
        );
    }
}
