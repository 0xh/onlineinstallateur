<?php

namespace MultipleFullfilmentCenters\Handler;

use MultipleFullfilmentCenters\MultipleFullfilmentCenters;
use MultipleFullfilmentCenters\Model\FulfilmentCenterProductsQuery;
use MultipleFullfilmentCenters\Model\Map\FulfilmentCenterTableMap;
use MultipleFullfilmentCenters\Model\OrderLocalPickupQuery;
use MultipleFullfilmentCenters\Model\Map\OrderLocalPickupTableMap;
use Thelia\Model\ProductI18nQuery;

class LocationStockHandler {

    /**
     * @param $productId, $quantityCart
     * @return array
     */
    public function getStockLocationsForProduct($productId, $quantityCart, $hideVirtualCenter, $centerId, $reserved) {
        $stock = FulfilmentCenterProductsQuery::create()
                ->addSelfSelectColumns()
                ->useFulfilmentCenterQuery()
                ->withColumn(FulfilmentCenterTableMap::NAME, 'CenterName')
                ->endUse()
                ->filterByProductId($productId);


        if ($centerId) {
            $stock->where('`fulfilment_center_products`.FULFILMENT_CENTER_ID = ' . $centerId);
        }

        if ($hideVirtualCenter) {
            $stock
                    ->where('`fulfilment_center_products`.PRODUCT_STOCK >= ' . $quantityCart)
                    ->where('`fulfilment_center_products`.FULFILMENT_CENTER_ID != ' . MultipleFullfilmentCenters::getConfigValue('fulfilment_center_default'))
                    ->find();
        } else {
            $stock->find();
        }

        foreach ($stock as $i => $value) {

            if ($reserved) {
                if ($value->getReservedStock() + $quantityCart <= $value->getProductStock()) {
                    $stockProduct[$i]["id"] = $value->getId();
                    $stockProduct[$i]["fulfilmentCenterId"] = $value->getFulfilmentCenterId();
                    $stockProduct[$i]["productId"] = $value->getProductId();
                    $stockProduct[$i]["productStock"] = $value->getProductStock();
                    $stockProduct[$i]["incomingStock"] = $value->getIncomingStock();
                    $stockProduct[$i]["outgoingStock"] = $value->getOutgoingStock();
                    $stockProduct[$i]["reservedStock"] = $value->getReservedStock();
                    $stockProduct[$i]["fulfilmentCenterName"] = $value->getVirtualColumn('CenterName');
                }
            } else {
                $stockProduct[$i]["id"] = $value->getId();
                $stockProduct[$i]["fulfilmentCenterId"] = $value->getFulfilmentCenterId();
                $stockProduct[$i]["productId"] = $value->getProductId();
                $stockProduct[$i]["productStock"] = $value->getProductStock();
                $stockProduct[$i]["incomingStock"] = $value->getIncomingStock();
                $stockProduct[$i]["outgoingStock"] = $value->getOutgoingStock();
                $stockProduct[$i]["reservedStock"] = $value->getReservedStock();
                $stockProduct[$i]["fulfilmentCenterName"] = $value->getVirtualColumn('CenterName');
            }
        }
        return $stockProduct;
    }

    /**
     * @param $orderId, $locale 
     * @return array
     */
    public function getPickUpAddress($orderId, $locale) {
        $pickUpAddress = OrderLocalPickupQuery::create()
                ->addSelfSelectColumns()
                ->useFulfilmentCenterQuery()
                ->withColumn(FulfilmentCenterTableMap::ADDRESS, 'CenterAddress')
                ->endUse()
                ->filterByOrderId($orderId)
                ->where(OrderLocalPickupTableMap::FULFILMENT_CENTER_ID . " > ?", 1, \PDO::PARAM_INT)
                ->find();

        foreach ($pickUpAddress as $i => $value) {
            $productTitle = ProductI18nQuery::create()
                    ->select('title')
                    ->filterById($value->getProductId())
                    ->filterByLocale($locale)
                    ->findOne();

            $pickUpProductAddress[$i]["productTitle"] = $productTitle;
            $pickUpProductAddress[$i]["fulfilmentCenterAddress"] = $value->getVirtualColumn('CenterAddress');
        }

        return $pickUpProductAddress;
    }

}
