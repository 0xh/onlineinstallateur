<?php
namespace BackOffice\Hook\Admin;

use BackOffice\BackOffice;
use Thelia\Core\Event\Hook\HookRenderBlockEvent;
use Thelia\Core\Event\Hook\HookRenderEvent;
use Thelia\Core\Hook\BaseHook;
use Thelia\Tools\URL;

/**
 * Class BackHook
 * 
 * @package HookScraper\Hook
 */
class BackOfficeHook extends BaseHook
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
            'id' => 'tools_menu_export_pdf_orders',
            'class' => '',
            'url' => URL::getInstance()->absoluteUrl('/admin/export-order-pdf'),
            'title' => $this->trans('Export pdf orders', [], BackOffice::DOMAIN_NAME)
        ]);
        $event->add([
            'id' => 'tools_menu_export_data_mysht',
            'class' => '',
            'url' => URL::getInstance()->absoluteUrl('/admin/export-data-mysht'),
            'title' => $this->trans('Export from Mysht', [], BackOffice::DOMAIN_NAME)
        ]);
    }
}
