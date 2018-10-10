<?php


namespace OrderCredit\Controller\Admin;

use Thelia\Controller\Admin\BaseAdminController;
use Thelia\Core\Security\AccessManager;
use Thelia\Core\Security\Resource\AdminResources;
use Thelia\Model\OrderQuery;
use Thelia\Model\Order;
use Thelia\Model\OrderStatusQuery;
use Thelia\Model\Map\OrderTableMap;

class OrderCreditAdminController extends BaseAdminController
{
    public function create($orderId)
    {
        if (null !== $response = $this->checkAuth(array(AdminResources::MODULE), array('OrderCredit'), AccessManager::VIEW)) {
            return $response;
        }
        
        $existingOrder = OrderQuery::create()->findOneById($orderId);
        $orderStatusCredit = OrderStatusQuery::create()->findOneByCode("credit");
        /** @var Order */
        $lastCreditOrder = OrderQuery::create()
        ->where(OrderTableMap::STATUS_ID.' = ?', $orderStatusCredit->getId())
        ->orderBy(OrderTableMap::ID,'desc')->limit(1)->find();
        $lastCreditRef = $lastCreditOrder->getFirst()->getRef();
        $lastCreditRefString = str_replace('GUT', '', $lastCreditRef);
        $newCreditRefString = 'GUT';
        $newCreditRef =intval($lastCreditRefString);
       // $lastCreditRefString
        for ($i = 0; $i< strlen($lastCreditRefString);$i++)
            $newCreditRefString .= '0';
            $newCreditRefString.= $newCreditRef+1;
        
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
        ->save();
        $creditOrder->setRef($newCreditRefString)->save();
        
       
        die(var_dump($creditOrder->getId()));
        
        

        return $this->render("order.tab-content.credit",array('order_id'=>$orderId));
    }

}
