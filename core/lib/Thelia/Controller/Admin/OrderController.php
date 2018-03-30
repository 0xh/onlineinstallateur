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

namespace Thelia\Controller\Admin;

use MultipleFullfilmentCenters\Model\FulfilmentCenterOrderQuery;
use MultipleFullfilmentCenters\Model\FulfilmentCenterQuery;
use MultipleFullfilmentCenters\Model\Map\FulfilmentCenterOrderTableMap;
use MultipleFullfilmentCenters\Model\Map\FulfilmentCenterTableMap;
use RevenueDashboard\Model\OrderProductRevenueQuery;
use RevenueDashboard\Model\OrderRevenue;
use RevenueDashboard\Model\OrderRevenueQuery;
use RevenueDashboard\RevenueDashboard;
use Thelia\Core\Event\Order\OrderAddressEvent;
use Thelia\Core\Event\Order\OrderEvent;
use Thelia\Core\Event\TheliaEvents;
use Thelia\Core\Security\AccessManager;
use Thelia\Core\Security\Resource\AdminResources;
use Thelia\Form\OrderUpdateAddress;
use Thelia\Model\ConfigQuery;
use Thelia\Model\ModuleQuery;
use Thelia\Model\OrderAddressQuery;
use Thelia\Model\OrderQuery;
use Thelia\Model\OrderStatusQuery;

/**
 * Class OrderController
 * @package Thelia\Controller\Admin
 * @author Manuel Raynaud <manu@raynaud.io>
 */
class OrderController extends BaseAdminController {

    public function indexAction() {
        if (null !== $response = $this->checkAuth(AdminResources::ORDER, array(), AccessManager::VIEW)) {
            return $response;
        }
        return $this->render("orders", array(
                    "display_order" => 20,
                    "orders_order" => $this->getListOrderFromSession("orders", "orders_order", "create-date-reverse")
        ));
    }

    public function viewAction($order_id) {
        return $this->render("order-edit", array(
                    "order_id" => $order_id
        ));
    }

    public function updateStatus($order_id = null) {
        if (null !== $response = $this->checkAuth(AdminResources::ORDER, array(), AccessManager::UPDATE)) {
            return $response;
        }

        $message = null;

        try {
            if ($order_id === null) {
                $order_id = $this->getRequest()->get("order_id");
            }

            $order = OrderQuery::create()->findPk($order_id);

            $statusId = $this->getRequest()->request->get("status_id");
            $status = OrderStatusQuery::create()->findPk($statusId);

            if (null === $order) {
                throw new \InvalidArgumentException("The order you want to update status does not exist");
            }
            if (null === $status) {
                throw new \InvalidArgumentException("The status you want to set to the order does not exist");
            }

            $event = new OrderEvent($order);
            $event->setStatus($statusId);

            $this->dispatch(TheliaEvents::ORDER_UPDATE_STATUS, $event);

            if ($this->getActiveModule()) {
                if ($statusId == 8) {
                    $this->updateOrderRevenue($order_id);
                }
            }
        } catch (\Exception $e) {
            $message = $e->getMessage();
        }

        $params = array();

        if ($message) {
            $params["update_status_error_message"] = $message;
        }

        $browsedPage = $this->getRequest()->get("order_page");
        $currentStatus = $this->getRequest()->get("status");

        if ($browsedPage) {
            $params["order_page"] = $browsedPage;

            if (null !== $currentStatus) {
                $params["status"] = $currentStatus;
            }

            $response = $this->generateRedirectFromRoute("admin.order.list", $params);
        } else {
            $params["tab"] = $this->getRequest()->get("tab", 'cart');

            $response = $this->generateRedirectFromRoute("admin.order.update.view", $params, ['order_id' => $order_id]);
        }

        return $response;
    }

    public function updateDeliveryRef($order_id) {
        if (null !== $response = $this->checkAuth(AdminResources::ORDER, array(), AccessManager::UPDATE)) {
            return $response;
        }

        $message = null;

        try {
            $order = OrderQuery::create()->findPk($order_id);

            $deliveryRef = $this->getRequest()->get("delivery_ref");

            if (null === $order) {
                throw new \InvalidArgumentException("The order you want to update status does not exist");
            }

            $event = new OrderEvent($order);
            $event->setDeliveryRef($deliveryRef);

            $this->dispatch(TheliaEvents::ORDER_UPDATE_DELIVERY_REF, $event);
        } catch (\Exception $e) {
            $message = $e->getMessage();
        }

        $params = array();

        if ($message) {
            $params["update_status_error_message"] = $message;
        }

        $params["tab"] = $this->getRequest()->get("tab", 'bill');

        return $this->generateRedirectFromRoute(
                        "admin.order.update.view", $params, ['order_id' => $order_id]
        );
    }

    public function updateAddress($order_id) {
        if (null !== $response = $this->checkAuth(AdminResources::ORDER, array(), AccessManager::UPDATE)) {
            return $response;
        }

        $message = null;

        $orderUpdateAddress = new OrderUpdateAddress($this->getRequest());

        try {
            $order = OrderQuery::create()->findPk($order_id);

            if (null === $order) {
                throw new \InvalidArgumentException("The order you want to update does not exist");
            }

            $form = $this->validateForm($orderUpdateAddress, "post");

            $orderAddress = OrderAddressQuery::create()->findPk($form->get("id")->getData());

            if ($orderAddress->getId() !== $order->getInvoiceOrderAddressId() && $orderAddress->getId() !== $order->getDeliveryOrderAddressId()) {
                throw new \InvalidArgumentException("The order address you want to update does not belong to the current order not exist");
            }

            $event = new OrderAddressEvent(
                    $form->get("title")->getData(), $form->get("firstname")->getData(), $form->get("lastname")->getData(), $form->get("address1")->getData(), $form->get("address2")->getData(), $form->get("address3")->getData(), $form->get("zipcode")->getData(), $form->get("city")->getData(), $form->get("country")->getData(), $form->get("phone")->getData(), $form->get("company")->getData(), $form->get("cellphone")->getData(), $form->get("state")->getData()
            );
            $event->setOrderAddress($orderAddress);
            $event->setOrder($order);

            $this->dispatch(TheliaEvents::ORDER_UPDATE_ADDRESS, $event);
        } catch (\Exception $e) {
            $message = $e->getMessage();
        }

        $params = array();

        if ($message) {
            $params["update_status_error_message"] = $message;
        }

        $params["tab"] = $this->getRequest()->get("tab", 'bill');

        return $this->generateRedirectFromRoute(
                        "admin.order.update.view", $params, ['order_id' => $order_id]
        );
    }

    public function generateInvoicePdf($order_id, $browser) {
        if (null !== $response = $this->checkAuth(AdminResources::ORDER, array(), AccessManager::UPDATE)) {
            return $response;
        }
        return $this->generateBackOfficeOrderPdf($order_id, ConfigQuery::read('pdf_invoice_file', 'invoice'), $browser);
    }

    public function generateDeliveryPdf($order_id, $browser) {
        if (null !== $response = $this->checkAuth(AdminResources::ORDER, array(), AccessManager::UPDATE)) {
            return $response;
        }
        return $this->generateBackOfficeOrderPdf($order_id, ConfigQuery::read('pdf_delivery_file', 'delivery'), $browser);
    }

    private function generateBackOfficeOrderPdf($order_id, $fileName, $browser) {
        if (null === $response = $this->generateOrderPdf($order_id, $fileName, true, true, $browser)) {
            return $this->generateRedirectFromRoute(
                            "admin.order.update.view", [], ['order_id' => $order_id]
            );
        }

        return $response;
    }

    protected function getActiveModule($moduleName = "RevenueDashboard") {
        $module = ModuleQuery::create()->filterByCode($moduleName)->findOne();

        if ($module != NULL) {
            return $module->getActivate();
        }

        return 0;
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
        foreach ($orderProdRevenue as $value) {
            $this->addNewOrderRevenue($value, $paymentProcessorCost, $totalPaymentProcessorCost, $deliveryCostMethod);
        }
    }

    protected function addNewOrderRevenue($orderProdRevenue, $paymentProcessorCost, $totalPaymentProcessorCost, $deliveryCostMethod) {
        $newOrderRevenue = new OrderRevenue();
        $newOrderRevenue->setDeliveryCost($deliveryCostMethod["delivery_cost"]);
        $newOrderRevenue->setOrderId($orderProdRevenue->getOrderId());
        $newOrderRevenue->setDeliveryMethod($deliveryCostMethod["delivery_method"]);
        $newOrderRevenue->setPartnerId($orderProdRevenue->getPartnerId());
        $newOrderRevenue->setPaymentProcessorCost($totalPaymentProcessorCost);
        $newOrderRevenue->setPrice($orderProdRevenue->getPrice());
        $newOrderRevenue->setPurchasePrice($orderProdRevenue->getPurchasePrice());
        $totalPurchasePrice = $orderProdRevenue->getPurchasePrice() + $deliveryCostMethod["delivery_cost"] + $totalPaymentProcessorCost;

        $newOrderRevenue->setTotalPurchasePrice($totalPurchasePrice);
        $newOrderRevenue->setRevenue($orderProdRevenue->getPrice() - $totalPurchasePrice);
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

}
