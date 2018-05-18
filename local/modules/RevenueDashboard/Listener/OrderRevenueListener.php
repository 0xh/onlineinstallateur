<?php

namespace RevenueDashboard\Listener;

use MultipleFullfilmentCenters\Model\FulfilmentCenterOrderQuery;
use MultipleFullfilmentCenters\Model\Map\FulfilmentCenterOrderTableMap;
use MultipleFullfilmentCenters\Model\Map\FulfilmentCenterTableMap;
use RevenueDashboard\Model\OrderProductRevenueQuery;
use RevenueDashboard\Model\OrderRevenue;
use RevenueDashboard\Model\OrderRevenueQuery;
use RevenueDashboard\RevenueDashboard;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Thelia\Action\BaseAction;
use Thelia\Core\Event\Order\OrderEvent;
use Thelia\Core\Event\TheliaEvents;
use Thelia\Core\HttpFoundation\Request;
use Thelia\Model\OrderQuery;
use Thelia\Core\Template\Loop\OrderProduct;
use Thelia\Model\OrderProductQuery;

/**
 * Description of OrderRevenueListener
 *
 * @author Catana Florin
 */
class OrderRevenueListener extends BaseAction implements EventSubscriberInterface {

    protected $request;
    protected $totalProdForOrder;

    public function __construct(Request $request) {
        $this->request = $request;
    }

    protected function updateOrderRevenue($orderId) {
        $orderProdRevenue = OrderProductRevenueQuery::create()
                ->findByOrderId($orderId);

        $orderRevenue = OrderRevenueQuery::create()
                ->findByOrderId($orderId);

        $paymentProcessorCost = $this->getDeliveryCostMethodPay($orderId);
        $totalPaymentProcessorCost = $paymentProcessorCost["cost_module"] + $paymentProcessorCost["cost_transaction_module"];
        $deliveryCostMethod = $this->getDeliveryCostMethod($orderId);

        if ($orderRevenue->getData()) {
            foreach ($orderRevenue as $orderRev) {
                $orderRev->delete();
            }
        }

        $this->totalProdForOrder = 0;
        foreach ($orderProdRevenue as $value) {
            $orderProduct = OrderProductQuery::create()
                    ->filterByOrderId($value->getOrderId())
                    ->findOneByProductRef($value->getProductRef());

            $orderQuantity = $orderProduct->getQuantity();
            $this->totalProdForOrder += $orderQuantity;
        }

        foreach ($orderProdRevenue as $value) {
            $this->addNewOrderRevenue($value, $paymentProcessorCost, $totalPaymentProcessorCost, $deliveryCostMethod);
        }
    }

    protected function addNewOrderRevenue($orderProdRevenue, $paymentProcessorCost, $totalPaymentProcessorCost, $deliveryCostMethod) {
        $orderProduct = OrderProductQuery::create()
                ->filterByOrderId($orderProdRevenue->getOrderId())
                ->findOneByProductRef($orderProdRevenue->getProductRef());

        $orderQuantity = $orderProduct->getQuantity();
        $sellPrice = $orderProdRevenue->getPrice();
        $purchasePrice = $orderProdRevenue->getPurchasePrice();

        $newOrderRevenue = new OrderRevenue();
        $newOrderRevenue->setDeliveryCost($deliveryCostMethod["delivery_cost"]);
        $newOrderRevenue->setOrderId($orderProdRevenue->getOrderId());
        $newOrderRevenue->setDeliveryMethod($deliveryCostMethod["delivery_method"]);
        $newOrderRevenue->setPartnerId($orderProdRevenue->getPartnerId());
        $newOrderRevenue->setPaymentProcessorCost($totalPaymentProcessorCost);
        $newOrderRevenue->setPrice($sellPrice);
        $newOrderRevenue->setQuantity($orderQuantity);
        $newOrderRevenue->setPurchasePrice($purchasePrice);

        $costOrder = ($deliveryCostMethod["delivery_cost"] + $totalPaymentProcessorCost) / $this->totalProdForOrder;

        $totalPurchasePrice = $purchasePrice + $costOrder;

        $newOrderRevenue->setTotalPurchasePrice($totalPurchasePrice);
        $newOrderRevenue->setRevenue(($sellPrice - $totalPurchasePrice) * $orderQuantity);
        $newOrderRevenue->save();
    }

    protected function getDeliveryCostMethod($orderId) {
        $center = FulfilmentCenterOrderQuery::create()
                ->addJoin(FulfilmentCenterOrderTableMap::CENTER_ID, FulfilmentCenterTableMap::ID)
                ->withColumn(FulfilmentCenterTableMap::DELIVERY_COST, 'delivery_cost')
                ->withColumn(FulfilmentCenterTableMap::DELIVERY_METHOD, 'delivery_method')
                ->findOneByOrderId($orderId);

        if ($center) {
            return array(
                "delivery_cost" => $center->getVirtualColumn("delivery_cost"),
                "delivery_method" => $center->getVirtualColumn("delivery_method")
            );
        }

        return array(
            "delivery_cost" => RevenueDashboard::getConfigValue('delivery_cost'),
            "delivery_method" => RevenueDashboard::getConfigValue('delivery_method')
        );
    }

    protected function getDeliveryCostMethodPay($orderId) {
        $order = OrderQuery::create()
                ->findOneById($orderId);

        $payment_module_id = 0;

        if ($order) {
            $payment_module_id = $order->getPaymentModuleId();
        }

        return array(
            "cost_module" => RevenueDashboard::getConfigValue('cost_module_' . $payment_module_id),
            "cost_transaction_module" => RevenueDashboard::getConfigValue('cost_transaction_module_' . $payment_module_id)
        );
    }

    public function updateOrderStatus(OrderEvent $event) {
        $completedStatus = 8;
        $newStatus = $event->getStatus();
        $order = $event->getOrder();

        if ($completedStatus == $newStatus) {
            $this->updateOrderRevenue($order->getId());
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
    public static function getSubscribedEvents() {
        return array(
            TheliaEvents::ORDER_UPDATE_STATUS => array("updateOrderStatus", 128)
        );
    }

}
