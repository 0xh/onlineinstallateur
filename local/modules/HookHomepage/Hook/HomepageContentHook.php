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

namespace HookHomepage\Hook;
use Thelia\Core\Event\Hook\HookRenderEvent;
use Thelia\Core\Hook\BaseHook;


/**
 * Class HomepageContentHook
 * @package HookHomepage\Hook
 * @author Ani Jalavyan  <ani.jalavyan@sepa.at>
 */
class HomepageContentHook extends BaseHook
{

    public function onHomeBody(HookRenderEvent $event)
    {
        $event->add(
            $this->render('homepageContent.html')
        );
    }
} 