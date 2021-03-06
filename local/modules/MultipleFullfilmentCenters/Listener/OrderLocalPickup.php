<?php

namespace MultipleFullfilmentCenters\Listener;

use MultipleFullfilmentCenters\MultipleFullfilmentCenters;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Thelia\Action\BaseAction;
use Thelia\Core\Event\Order\OrderEvent;
use Thelia\Core\Event\TheliaEvents;
use MultipleFullfilmentCenters\Model\OrderLocalPickupQuery;
use MultipleFullfilmentCenters\Model\FulfilmentCenterProductsQuery;
use Thelia\Model\ProductSaleElementsQuery;
use Thelia\Model\OrderStatusQuery;
use Thelia\Core\Event\Cart\CartEvent;
use Thelia\Model\CartItemQuery;
use Thelia\Log\Tlog;
use Thelia\Core\HttpFoundation\Request;

/**
 */
class OrderLocalPickup extends BaseAction implements EventSubscriberInterface {

    protected $request;

    public function __construct(Request $request) {
        $this->request = $request;
    }

    /**
     * @param  OrderEvent $event
     */
    public function createOrderWithFulfilmentCenter(OrderEvent $event) {
        $order = $event->getPlacedOrder();
        $orderProductList = $order->getOrderProducts();

        /** @var OrderProduct  $orderProduct */
        foreach ($orderProductList as $orderProduct) {

            if ($orderProduct->getVirtualColumns()) {
                $productId = $orderProduct->getVirtualColumn('product_id');
            } else {
                $prod = \Thelia\Model\ProductQuery::create()->findOneByRef($orderProduct->getProductRef());
                $productId = $prod->getId();
            }

            // fulfill order_local_pickup with orderId - for products that can be picked up from fulfilment centers
            $cartProductLocation = OrderLocalPickupQuery::create()
                    ->filterByProductId($productId)
                    ->filterByCartId($order->getCartId())
                    ->findOne();

            if ($cartProductLocation) {
                $cartProductLocation->setOrderId($order->getId())
                        ->save();

                if ($cartProductLocation->getFulfilmentCenterId() == MultipleFullfilmentCenters::getConfigValue('fulfilment_center_reserve')) {

                    $productLocation = FulfilmentCenterProductsQuery::create()
                            ->filterByProductId($productId)
                            ->filterByFulfilmentCenterId(MultipleFullfilmentCenters::getConfigValue('fulfilment_center_reserve'))
                            ->findOne();

                    $productLocation->setReservedStock($productLocation->getReservedStock() + $cartProductLocation->getQuantity())
                            ->save();
                }
            }
        }
    }

    // decrease stock for the specific fulfilment center & decrease reserved stock 
    public function updateQuantity(OrderEvent $event) {
        $paidStatus = OrderStatusQuery::getPaidStatus()->getId();
        $newStatus = $event->getStatus();
        $order = $event->getOrder();
        $orderProductList = $order->getOrderProducts();

        if ($paidStatus == $newStatus) {
            foreach ($orderProductList as $orderProduct) {

                $productId = ProductSaleElementsQuery::create()
                        ->select('product_id')
                        ->findOneById($orderProduct->getProductSaleElementsId());

                $cartProductLocation = OrderLocalPickupQuery::create()
                        ->filterByProductId($productId)
                        ->filterByCartId($order->getCartId())
                        ->findOne();

                if ($cartProductLocation) {

                    $productLocation = FulfilmentCenterProductsQuery::create()
                            ->filterByProductId($productId)
                            ->filterByFulfilmentCenterId($cartProductLocation->getFulfilmentCenterId())
                            ->findOne();

                    if ($productLocation) {
                        $newStockLocation = $productLocation->getProductStock() - $orderProduct->getQuantity();

                        $productLocation->setProductStock($newStockLocation);

                        if ($productLocation->getFulfilmentCenterId() == MultipleFullfilmentCenters::getConfigValue('fulfilment_center_reserve')) {
                            $productLocation->setReservedStock($productLocation->getReservedStock() - $orderProduct->getQuantity());
                        }

                        $fulfilmentCenterOrder = new \MultipleFullfilmentCenters\Model\FulfilmentCenterOrder();
                        $fulfilmentCenterOrder->setCenterId($productLocation->getFulfilmentCenterId());
                        $fulfilmentCenterOrder->setOrderId($order->getId());
                        $fulfilmentCenterOrder->save();

                        $productLocation->save();
                    }
                }
            }
        }
    }

    public function getItemLocalPickupForCart(CartEvent $event) {
        $cart = $event->getCart();

        $productId = CartItemQuery::create()
                ->select('product_id')
                ->filterByCartId($cart->getId())
                ->filterById($event->getCartItemId())
                ->findOne();

        $productLocalPickup = OrderLocalPickupQuery::create()
                ->filterByProductId($productId)
                ->filterByCartId($event->getCart()->getId())
                ->findOne();

        return $productLocalPickup;
    }

    // update product quantity in OrderLocalPickup tabel
    public function updateQuantityOrderLocalPickup(CartEvent $event) {
        $productLocalPickup = $this->getItemLocalPickupForCart($event);

        if ($productLocalPickup) {
            $productLocalPickup
                    ->setQuantity($event->getQuantity())
                    ->save();
        }
    }

    // delete product from OrderLocalPickup tabel if it's deleted from cart
    public function deleteItemOrderLocalPickup(CartEvent $event) {
        $productLocalPickup = $this->getItemLocalPickupForCart($event);

        if ($productLocalPickup)
            $productLocalPickup->delete();
    }

    public function getItemLocalPickupForProductPage($cartItem, $fulfilment_center) {
        $productLocalPickup = OrderLocalPickupQuery::create()
                ->filterByProductId($cartItem->getProductId())
                ->filterByCartId($cartItem->getCartId())
                ->filterByFulfilmentCenterId(MultipleFullfilmentCenters::getConfigValue('fulfilment_center_reserve'))
                ->findOne();

        return $productLocalPickup;
    }

    // fulfill order_local_pickup with product and pickup center
    public function insertProductPickupLocation(CartEvent $event) {
        Tlog::getInstance()->error('cart event - productid: ' . $event->getProduct() . '- cartId: ' . $event->getCart()->getId() . '- quantiy: ' . $event->getQuantity());

        $cartItem = $this->findCartItem($event);
        $itemLocalPickup = $this->getItemLocalPickupForProductPage($cartItem, MultipleFullfilmentCenters::getConfigValue('fulfilment_center_reserve'));

        if ($itemLocalPickup) {
            Tlog::getInstance()->error('update quantity');
            $itemLocalPickup->setQuantity($cartItem->getQuantity())
                    ->save();
        } else {
            Tlog::getInstance()->error('buy format on product page - ' . $this->request->getSession()->get('buy_format'));

            if ($this->request->getSession()->get('buy_format') == 'reserve') {

                $cartProductLocation = OrderLocalPickupQuery::create()
                        ->filterByProductId($event->getProduct())
                        ->filterByCartId($event->getCart()->getId())
                        ->findOneOrCreate();

                $cartProductLocation->setFulfilmentCenterId(MultipleFullfilmentCenters::getConfigValue('fulfilment_center_reserve'))
                        ->setQuantity($event->getQuantity())
                        ->save();

                $this->request->getSession()->remove('buy_format');
            }
        }
    }

    public function findCartItem(CartEvent $event) {

        $productInCart = CartItemQuery::create()
                ->filterByCartId($event->getCart()->getId())
                ->filterByProductId($event->getProduct())
                ->filterByProductSaleElementsId($event->getProductSaleElementsId())
                ->findOne();

        return $productInCart;
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
            TheliaEvents::ORDER_PAY => array("createOrderWithFulfilmentCenter", 128),
            TheliaEvents::ORDER_UPDATE_STATUS => array("updateQuantity", 128),
            TheliaEvents::CART_UPDATEITEM => array("updateQuantityOrderLocalPickup", 128),
            TheliaEvents::CART_DELETEITEM => array("deleteItemOrderLocalPickup", 256),
            TheliaEvents::CART_ADDITEM => array("insertProductPickupLocation", 128)
        );
    }

}
