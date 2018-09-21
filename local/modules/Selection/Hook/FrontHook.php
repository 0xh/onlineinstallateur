<?php

namespace Selection\Hook;

use Thelia\Core\Event\Hook\HookRenderEvent;
use Thelia\Core\Hook\BaseHook;

/* * *
 * Class FrontHook
 * @package Selection\Hook
 * @author Maxime Bruchet <mbruchet@openstudio.fr>
 */

class FrontHook extends BaseHook {

    public function onMainCss(HookRenderEvent $event) {
        $event->add($this->addCSS('assets/dist/css/selection.css'));
    }

}
