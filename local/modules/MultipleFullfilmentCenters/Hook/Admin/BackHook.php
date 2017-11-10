<?php
namespace MultipleFullfilmentCenters\Hook\Admin;

use MultipleFullfilmentCenters\MultipleFullfilmentCenters;
use Thelia\Core\Event\Hook\HookRenderBlockEvent;
use Thelia\Core\Hook\BaseHook;
use Thelia\Tools\URL;

/**
 * Class BackHook
 * 
 * @package HookScraper\Hook
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
        $event->add([
            'id' => 'tools_menu_setting_product_quantity',
            'class' => '',
            'url' => URL::getInstance()->absoluteUrl('/admin/module/multiplefulfilmentcenters/setting-products'),
            'title' => $this->trans('Setting the product quantity', [], MultipleFullfilmentCenters::DOMAIN_NAME)
        ]);
    }
}
