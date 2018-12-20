<?php

namespace Scraper\Hook;

use Scraper\Scraper;
use Thelia\Core\Event\Hook\HookRenderBlockEvent;
use Thelia\Core\Event\Hook\HookRenderEvent;
use Thelia\Core\Hook\BaseHook;
use Thelia\Tools\URL;

/**
 * Class BackHook
 * @package Scraper\Hook
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
          'id'    => 'tools_menu_scraper',
          'class' => '',
          'url'   => URL::getInstance()->absoluteUrl('/admin/module/Scraper'),
          'title' => $this->trans('WebScraper', [], Scraper::DOMAIN_NAME)
         ]
        );
    }

    public function onModuleConfiguration(HookRenderEvent $event)
    {
        $event->add($this->render("scraper.html"));
    }

    public function onModuleConfigJs(HookRenderEvent $event)
    {
        $event->add($this->addJS('assets/js/module-configuration.js'));
    }

}
