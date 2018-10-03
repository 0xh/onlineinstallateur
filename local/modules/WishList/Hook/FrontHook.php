<?php
namespace WishList\Hook;

use WishList\WishList;
use Thelia\Core\Event\Hook\HookRenderBlockEvent;
use Thelia\Core\Event\Hook\HookRenderEvent;
use Thelia\Core\Hook\BaseHook;
use Thelia\Tools\URL;



/**
 * Description of ConfigurationHook
 *
 * @author admin
 */
class FrontHook extends BaseHook{
    
//    public function onMiniWhishList(HookRenderEvent $event)
//    {
//        $event->add(
//            $this->render('mini-wish-list.html')
//        );
//        
//    }
//    
//    public function onWhishButton(HookRenderEvent $event)
//    {
//        $event->add(
//            $this->render('wish-button.html')
//        );
//        
//    }
    
    public function onMainCss(HookRenderEvent $event)
    {
        $event->add($this->addCSS('assets/css/wishlist.css'));
    }
    
}
