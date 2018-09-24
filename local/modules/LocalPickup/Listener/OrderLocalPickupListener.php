<?php

namespace LocalPickup\Listener;

use LocalPickup\LocalPickup;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Thelia\Action\BaseAction;
use Thelia\Core\Event\Order\OrderEvent;
use Thelia\Core\Event\TheliaEvents;
use LocalPickup\Model\OrderLocalPickupQuery;
use LocalPickup\Model\FulfilmentCenterProductsQuery;
use Thelia\Model\ProductSaleElementsQuery;
use Thelia\Model\OrderStatusQuery;
use Thelia\Core\Event\Cart\CartEvent;
use Thelia\Model\CartItemQuery;
use Thelia\Log\Tlog;
use Thelia\Core\HttpFoundation\Request;
use LocalPickup\Model\OrderLocalPickupAddressQuery;

/**
 */
class OrderLocalPickupListener extends BaseAction implements EventSubscriberInterface {

    protected $request;

    public function __construct(Request $request) {
        $this->request = $request;
    }

    /**
     * @param  OrderEvent $event
     */
    public function createOrderWithLocalPickup(OrderEvent $event) {
        $order = $event->getOrder();

        // fulfill order_local_pickup with orderId - for products that can be picked up from fulfilment centers
        $cartLocation = OrderLocalPickupAddressQuery::create()
                ->filterByLocalPickupCartId($order->getCartId())
                ->findOne();

        if ($cartLocation) {
            $cartLocation->setOrderId($order->getId())
                    ->save();
        }
        Tlog::getInstance()->error("After function" . $order->getId());
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
    public static function getSubscribedEvents() {
        return array(
            TheliaEvents::ORDER_AFTER_CREATE => array("createOrderWithLocalPickup", 1)
        );
    }

}
