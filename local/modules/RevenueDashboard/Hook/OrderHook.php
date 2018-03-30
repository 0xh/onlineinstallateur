<?php

namespace RevenueDashboard\Hook;

use Propel\Runtime\ActiveQuery\Criteria;
use RevenueDashboard\Model\Map\OrderProductRevenueTableMap;
use RevenueDashboard\Model\Map\OrderRevenueTableMap;
use RevenueDashboard\Model\Map\WholesalePartnerProductTableMap;
use RevenueDashboard\Model\Map\WholesalePartnerTableMap;
use RevenueDashboard\Model\WholesalePartnerProductQuery;
use Thelia\Core\Event\Hook\HookRenderEvent;
use Thelia\Core\Hook\BaseHook;
use Thelia\Model\Map\ProductTableMap;

/**
 * Class OrderHook
 * 
 * @package RevenueDashboard\Hook
 */
class OrderHook extends BaseHook {

    public function onModuleConfigure(HookRenderEvent $event) {

        $orderId = $event->getArgument('order_id');
        $prodId = $event->getArgument('order_product_id');
        $price = number_format($event->getArgument('price'), 2, '.', '');

        $arrPartner = $this->getPriceForPartner($prodId);
        $event->add(
                $this->render('order-hook.html', array("arrPartner" => $arrPartner, "prodId" => $prodId,
                    "partner_selected" => $arrPartner[0]["partner_selected"], "service_price" => $arrPartner[0]["service_price"],"orderId" => $orderId, "price" => $price))
        );
    }

    private function getPriceForPartner($prodId) {

        $prod = WholesalePartnerProductQuery::create()
                ->addJoin(WholesalePartnerProductTableMap::PRODUCT_ID, ProductTableMap::ID)
                ->addJoin(WholesalePartnerProductTableMap::PARTNER_ID, WholesalePartnerTableMap::ID)
                ->addJoin(ProductTableMap::REF, OrderProductRevenueTableMap::PRODUCT_REF, Criteria::LEFT_JOIN)
                ->withColumn(WholesalePartnerTableMap::ID, 'partner_id')
                ->withColumn(WholesalePartnerTableMap::NAME, 'partner_name')
                ->withColumn(ProductTableMap::REF, 'ref')
                ->withColumn(ProductTableMap::ID, 'prod_id')
                ->withColumn(OrderProductRevenueTableMap::PARTNER_ID, 'partner_selected')
                ->withColumn(OrderProductRevenueTableMap::PURCHASE_PRICE, 'service_price')
                ->withColumn(WholesalePartnerProductTableMap::DISCOUNT, 'discount')
                ->findByProductId($prodId);

        $arrPartner = array();

        foreach ($prod as $value) {
            array_push($arrPartner, array(
                "partner_id" => $value->getVirtualColumn("partner_id"),
                "partner_name" => $value->getVirtualColumn("partner_name"),
                "prod_ref" => $value->getVirtualColumn("ref"),
                "prod_id" => $value->getVirtualColumn("prod_id"),
                "partner_selected" => $value->getVirtualColumn("partner_selected"),
                "service_price" => $value->getVirtualColumn("service_price"),
                "discount" => $value->getVirtualColumn("discount"),
                "purchase_price" => $value->getPrice() - ($value->getPrice() * $value->getVirtualColumn("discount") / 100)
            ));
        }

        return $arrPartner;
    }

}
