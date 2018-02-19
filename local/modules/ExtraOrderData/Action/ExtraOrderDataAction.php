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


namespace ExtraOrderData\Action;

use ExtraOrderData\ExtraOrderData;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Thelia\Core\Event\Order\OrderEvent;
use Thelia\Core\Event\TheliaEvents;
use Thelia\Core\HttpFoundation\Request;
use Thelia\Model\MetaData;
use Thelia\Model\MetaDataQuery;

/**
 * Class ExtraOrderDataAction
 * @package ExtraOrderData\Action
 * @author Julien Chanséaume <jchanseaume@openstudio.fr>
 */
class ExtraOrderDataAction implements EventSubscriberInterface
{
    /** @var Request */
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function orderCreate(OrderEvent $event)
    {
        $order = $event->getPlacedOrder();

        if (null !== $order) {
            $data = [
                'REMOTE_ADDR' => $this->request->server->get("REMOTE_ADDR"),
                'HTTP_USER_AGENT' => $this->request->server->get("HTTP_USER_AGENT"),
            ];

            MetaDataQuery::setVal(
                ExtraOrderData::META_KEY,
                MetaData::ORDER_KEY,
                $order->getId(),
                $data
            );

        }

    }
    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     *  * The method name to call (priority defaults to 0)
     *  * An array composed of the method name to call and the priority
     *  * An array of arrays composed of the method names to call and respective
     *    priorities, or 0 if unset
     *
     * For instance:
     *
     *  * array('eventName' => 'methodName')
     *  * array('eventName' => array('methodName', $priority))
     *  * array('eventName' => array(array('methodName1', $priority), array('methodName2'))
     *
     * @return array The event names to listen to
     *
     * @api
     */
    public static function getSubscribedEvents()
    {
        return [
            TheliaEvents::ORDER_PAY => ['orderCreate', 128]
        ];
    }
}
