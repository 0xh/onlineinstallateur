<?php

namespace OrderCredit\Controller\Admin;

use OrderCredit\Model\OrderCredit;
use Propel\Runtime\Propel;
use Thelia\Controller\Admin\BaseAdminController;
use Thelia\Core\Security\AccessManager;
use Thelia\Core\Security\Resource\AdminResources;
use Thelia\Model\Map\OrderTableMap;
use Thelia\Model\Order;
use Thelia\Model\OrderProduct;
use Thelia\Model\OrderProductQuery;
use Thelia\Model\OrderProductTax;
use Thelia\Model\OrderProductTaxQuery;
use Thelia\Model\OrderQuery;
use Thelia\Model\OrderStatusQuery;

class OrderCreditAdminController extends BaseAdminController
{

    public function create($orderId)
    {
        if (null !== $response = $this->checkAuth(array(AdminResources::MODULE), array('OrderCredit'), AccessManager::VIEW)) {
            return $response;
        }

        $con = Propel::getConnection(OrderTableMap::DATABASE_NAME);
        $con->beginTransaction();

        $existingOrder     = OrderQuery::create()->findOneById($orderId);
        $orderStatusCredit = OrderStatusQuery::create()->findOneByCode("credit");
        /** @var Order */
        $lastCreditOrder   = OrderQuery::create()
          ->where(OrderTableMap::STATUS_ID . ' = ?', $orderStatusCredit->getId())
          ->orderBy(OrderTableMap::ID, 'desc')->limit(1)->find();

        $lastCreditRef       = $lastCreditOrder->getFirst()->getRef();
        $lastCreditRefString = str_replace('GUT', '', $lastCreditRef);
        $newCreditRefString  = 'GUT';
        $newCreditRef        = intval($lastCreditRefString);
        $lastCreditRefString = str_replace($newCreditRef, '', $lastCreditRefString);

        // $lastCreditRefString
        for ($i = 0; $i < strlen($lastCreditRefString); $i++) {
            $newCreditRefString .= '0';
        }

        $newCreditRefString .= $newCreditRef + 1;

        $creditOrder   = $this->saveOrder($existingOrder, $newCreditRefString, $orderStatusCredit, $con);
        $creditOrderId = $creditOrder->getId();

        $orderProductsExisting = OrderProductQuery::create()->findByOrderId($orderId);
        foreach ($orderProductsExisting as $orderProductExisting) {
            $newOrderProduct = $this->saveOrderProduct($orderProductExisting, $creditOrderId, $con);
            $this->saveOrderProductTax($orderProductExisting, $newOrderProduct, $con);
        }

        $orderCredit = $this->saveOrderCredit($existingOrder, $creditOrder, $con);

        $con->commit();

        return $this->render("order.tab-content.credit", array('order_id' => $creditOrderId, 'order_ref' => $orderCredit->getOrderRef()));
    }

    protected function saveOrderCredit($existingOrder, $creditOrder, $con)
    {
        $orderCredit = new OrderCredit();
        $orderCredit->setOrderId($existingOrder->getId());
        $orderCredit->setOrderRef($existingOrder->getRef());
        $orderCredit->setOrderCreditRef($creditOrder->getRef());
        $orderCredit->setOrderCreditId($creditOrder->getId());

        $orderCredit->save($con);

        return $orderCredit;
    }

    protected function saveOrderProductTax($orderProductExisting, $newOrderProduct, $con)
    {
        $orderProductTaxExisting = OrderProductTaxQuery::create()->findOneByOrderProductId($orderProductExisting->getId());
        $newOrderProductTax      = new OrderProductTax();
        $newOrderProductTax->setOrderProductId($newOrderProduct->getId());
        $newOrderProductTax->setTitle($orderProductTaxExisting->getTitle());
        $newOrderProductTax->setAmount($orderProductTaxExisting->getAmount());
        $newOrderProductTax->setPromoAmount($orderProductTaxExisting->getPromoAmount());
        $newOrderProductTax->setCreatedAt(date("Y-m-d H:i:s"));
        $newOrderProductTax->setUpdatedAt(date("Y-m-d H:i:s"));

        $newOrderProductTax->save($con);
    }

    protected function saveOrderProduct($orderProductExisting, $creditOrderId, $con)
    {
        $newOrderProduct = new OrderProduct();
        $newOrderProduct->setOrderId($creditOrderId);
        $newOrderProduct->setProductRef($orderProductExisting->getProductRef());
        $newOrderProduct->setProductSaleElementsRef($orderProductExisting->getProductSaleElementsRef());
        $newOrderProduct->setProductSaleElementsId($orderProductExisting->getProductSaleElementsId());
        $newOrderProduct->setTitle($orderProductExisting->getTitle());
        $newOrderProduct->setChapo($orderProductExisting->getChapo());
        $newOrderProduct->setDescription($orderProductExisting->getDescription());
        $newOrderProduct->setQuantity($orderProductExisting->getQuantity());
        $newOrderProduct->setPrice($orderProductExisting->getPrice());
        $newOrderProduct->setPromoPrice($orderProductExisting->getPromoPrice());
        $newOrderProduct->setWasNew($orderProductExisting->getWasNew());
        $newOrderProduct->setWasInPromo($orderProductExisting->getWasInPromo());
        $newOrderProduct->setWeight($orderProductExisting->getWeight());
        $newOrderProduct->setEanCode($orderProductExisting->getEanCode());
        $newOrderProduct->setTaxRuleTitle($orderProductExisting->getTaxRuleTitle());
        $newOrderProduct->setVirtual($orderProductExisting->getVirtual());
        $newOrderProduct->setCreatedAt(date("Y-m-d H:i:s"));
        $newOrderProduct->setUpdatedAt(date("Y-m-d H:i:s"));

        $newOrderProduct->save($con);

        return $newOrderProduct;
    }

    protected function saveOrder($existingOrder, $newCreditRefString, $orderStatusCredit, $con)
    {
        $creditOrder = new Order();
        $creditOrder
         ->setCustomer($existingOrder->getCustomer())
         ->setInvoiceOrderAddressId($existingOrder->getInvoiceOrderAddressId())
         ->setDeliveryOrderAddressId($existingOrder->getDeliveryOrderAddressId())
         ->setInvoiceDate(date("Y-m-d H:i:s"))
         ->setCurrencyId($existingOrder->getCurrencyId())
         ->setCurrencyRate($existingOrder->getCurrencyRate())
         ->setTransactionRef($existingOrder->getTransactionRef())
         ->setDeliveryRef($existingOrder->getDeliveryRef())
         ->setInvoiceRef($existingOrder->getInvoiceRef())
         ->setDiscount($existingOrder->getDiscount())
         ->setPostage($existingOrder->getPostage())
         ->setPostageTax($existingOrder->getPostageTax())
         ->setPostageTaxRuleTitle($existingOrder->getPostageTaxRuleTitle())
         ->setPaymentModuleId($existingOrder->getPaymentModuleId())
         ->setDeliveryModuleId($existingOrder->getDeliveryModuleId())
         ->setStatusId($orderStatusCredit->getId())
         ->setLangId($existingOrder->getLangId())
         ->setCartId($existingOrder->getCartId())
         ->setUpdatedAt(date("Y-m-d H:i:s"))
         ->save($con);

        $creditOrder->setRef($newCreditRefString)->save($con);

        return $creditOrder;
    }

    public function generateCreditPdf($order_id)
    {
        if (null !== $response = $this->checkAuth(AdminResources::ORDER, array(), AccessManager::UPDATE)) {
            return $response;
        }
        return $this->generateBackOfficeOrderPdf($order_id, 'credit');
    }

    private function generateBackOfficeOrderPdf($order_id, $fileName)
    {
        if (null === $response = $this->generateOrderPdf($order_id, $fileName, true, true, 0)) {
            return $this->generateRedirectFromRoute(
              "admin.order.update.view", [], ['order_id' => $order_id]
            );
        }

        return $response;
    }

}
