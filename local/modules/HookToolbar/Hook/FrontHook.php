<?php
/*************************************************************************************/
/*      This file is part of the Thelia package.                                     */
/*                                                                                   */
/*      Copyright (c) OpenStudio                                                     */
/*      email : dev@thelia.net                                                       */
/*      web : http://www.thelia.net                                                  */
/*                                                                                   */
/*      For the full copyright and license information, please view the LICENSE.txt  */
/*      file that was distributed with this source code.                             */
/*************************************************************************************/

namespace HookToolbar\Hook;

use Thelia\Core\Event\Hook\HookRenderEvent;
use Thelia\Core\Hook\BaseHook;

/**
 * Class FrontHook
 * @package HookToolbar\Hook
 * @author Michaël Espeche <michael.espeche@gmail.com>
 */
class FrontHook extends BaseHook
{
    protected $mode;

    public function __construct($debugMode)
    {
        $this->mode = $debugMode ? 'dev' : 'prod';
    }

    public function onMainBodyTop(HookRenderEvent $event)
    {
        $content = $this->render("main-body-top.html", [ 'mode' => $this->mode ]);
        $event->add($content);
    }

    public function onMainStyleSheet(HookRenderEvent $event)
    {
        $event->add('<script src="https://use.fontawesome.com/fea8382d6c.js"></script>');
    }
} 