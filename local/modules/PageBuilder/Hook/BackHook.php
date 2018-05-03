<?php

namespace PageBuilder\Hook;

use PageBuilder\PageBuilder;
use Thelia\Core\Event\Hook\HookRenderBlockEvent;
use Thelia\Core\Hook\BaseHook;
use Thelia\Tools\URL;

/***
 * Class BackHook
 * @package PageBuilder\Hook
 * @author Maxime Bruchet <mbruchet@openstudio.fr>
 */
class BackHook extends BaseHook
{
    /***
     * Hook PageBuilder module to the sidebar in tools menu
     *
     * @param HookRenderBlockEvent $event
     */
    public function onMainTopMenuTools(HookRenderBlockEvent $event)
    {
        $event->add(
            [
                'id' => 'tools_menu_page_builder',
                'class' => '',
                'url' => URL::getInstance()->absoluteUrl('/admin/PageBuilder'),
                'title' => $this->trans('PageBuilder', [], PageBuilder::DOMAIN_NAME)
            ]
        );
    }
}
