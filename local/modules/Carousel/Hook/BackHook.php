<?php

/* * ********************************************************************************** */
/*      This file is part of the Thelia package.                                     */
/*                                                                                   */
/*      Copyright (c) OpenStudio                                                     */
/*      email : dev@thelia.net                                                       */
/*      web : http://www.thelia.net                                                  */
/*                                                                                   */
/*      For the full copyright and license information, please view the LICENSE.txt  */
/*      file that was distributed with this source code.                             */
/* * ********************************************************************************** */

namespace Carousel\Hook;

use Carousel\Carousel;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Thelia\Core\Event\Hook\HookRenderBlockEvent;
use Thelia\Core\Event\Hook\HookRenderEvent;
use Thelia\Core\Hook\BaseHook;
use Thelia\Tools\URL;

/**
 * Class BackHook
 * @package Carousel\Hook
 * @author Emmanuel Nurit <enurit@openstudio.fr>
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
//         return RedirectResponse::create(URL::getInstance()->absoluteUrl('/admin/module/carousel/list'));
        $event->add(
         [
          'id'    => 'tools_menu_carousel',
          'class' => '',
          'url'   => URL::getInstance()->absoluteUrl('/admin/module/carousel/list'),
          'title' => $this->trans('Edit your carousel', [], Carousel::DOMAIN_NAME),
         ]
        );
    }

    public function onModuleConfiguration(HookRenderEvent $event)
    {
        $event->add($this->render("module_configuration.html"));
    }

    public function onJsModuleConfig(HookRenderEvent $event)
    {
        $event->add($this->render("js:assets/js/module-configuration.js"));
    }

}
