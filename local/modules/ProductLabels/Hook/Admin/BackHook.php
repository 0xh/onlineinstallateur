<?php
namespace ProductLabels\Hook\Admin;

use ProductLabels\ProductLabels;
use Thelia\Core\Event\Hook\HookRenderBlockEvent;
use Thelia\Core\Event\Hook\HookRenderEvent;
use Thelia\Core\Hook\BaseHook;
use Thelia\Tools\URL;

/**
 * Class BackHook
 * 
 * @package HookScraper\Hook
 */
class BackHook extends BaseHook
{

    
    public function onProductTab(HookRenderBlockEvent $event)
    {
        $event->add(
            [
                'id' => 'labels',
                'title' =>  $this->trans("Labels", [], ProductLabels::DOMAIN_NAME),
                'href' => URL::getInstance()->absoluteUrl('/admin/products/labels/tab/'.$event->getArgument('id')),
                'content' => $this->render('product-labels.html')
            ]
            );
    }
}
