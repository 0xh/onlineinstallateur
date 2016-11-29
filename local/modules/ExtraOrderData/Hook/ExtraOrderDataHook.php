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


namespace ExtraOrderData\Hook;

use ExtraOrderData\ExtraOrderData;
use Thelia\Core\Event\Hook\HookRenderEvent;
use Thelia\Core\Hook\BaseHook;
use Thelia\Model\MetaData;
use Thelia\Model\MetaDataQuery;

/**
 * Class ExtraOrderDataHook
 * @package ExtraOrderData\Hook
 * @author Julien Chanséaume <jchanseaume@openstudio.fr>
 */
class ExtraOrderDataHook extends BaseHook
{
    public function onOrderTabContent(HookRenderEvent $event)
    {
        $data = MetaDataQuery::getVal(ExtraOrderData::META_KEY, MetaData::ORDER_KEY, $event->getArgument('id'));

        if (null !== $data) {
            $event->add(
                $this->render(
                    'order-tab-content.html',
                    [
                        'data' => $data
                    ]
                )
            );
        }
    }
}
