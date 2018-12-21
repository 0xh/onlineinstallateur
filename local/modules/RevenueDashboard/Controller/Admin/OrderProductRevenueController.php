<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace RevenueDashboard\Controller\Admin;

use RevenueDashboard\Model\OrderProductRevenue;
use RevenueDashboard\Model\OrderProductRevenueQuery;
use Thelia\Controller\Admin\BaseAdminController;
use Thelia\Log\Tlog;
use Thelia\Model\ProductQuery;

/**
 * Description of OrderProductRevenueController
 *
 * @author Catana Florin
 */
class OrderProductRevenueController extends BaseAdminController {

    function updateOrderProductRevenue($orderId, $productRef, $price, $purchePrice, $partnerId, $prodId) {
     Tlog::getInstance()->debug("OPRC: in update Order Product Revenue");
        $prod = ProductQuery::create()
                ->findOneById($prodId);
        $productRef = $prod->getRef();
        
        $orderProductRevenue = OrderProductRevenueQuery::create()
                ->filterByOrderId($orderId)
                ->findOneByProductRef($productRef);

        if ($orderProductRevenue) {
            $orderProductRevenue->setPurchasePrice($purchePrice);
            $orderProductRevenue->setPartnerId($partnerId);
            $orderProductRevenue->save();
        } else {
            $this->addNewOrderProductRevenue($orderId, $productRef, $price, $purchePrice, $partnerId, $prodId);
        }
    }

    protected function addNewOrderProductRevenue($orderId, $productRef, $price, $purchePrice, $partnerId, $prodId) {
 Tlog::getInstance()->debug("OPRC: Add New Order Product Reven");
        $orderProductRevenue = new OrderProductRevenue();
        $orderProductRevenue->setOrderId($orderId);
        $orderProductRevenue->setProductRef($productRef);
        $orderProductRevenue->setPrice($price);
        $orderProductRevenue->setPurchasePrice($purchePrice);
        $orderProductRevenue->setPartnerId($partnerId);
        $orderProductRevenue->save();
    }

}
