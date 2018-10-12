<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace RevenueDashboard\Controller\Admin;

use Thelia\Controller\Admin\BaseAdminController;
use Thelia\Model\Map\ProductPriceTableMap;
use Thelia\Model\Map\ProductSaleElementsTableMap;
use Thelia\Model\ProductPriceQuery;
use Thelia\Tools\URL;

/**
 * Description of SellingPricesController
 *
 * @author Catana Florin
 */
class SellingPricesController extends BaseAdminController
{

    public function viewSellingPrices()
    {
        return $this->render("selling-prices");
    }

    public function updatePrice()
    {
        $product = ProductPriceQuery::create()
         ->addJoin(ProductPriceTableMap::PRODUCT_SALE_ELEMENTS_ID, ProductSaleElementsTableMap::ID)
         ->where(ProductSaleElementsTableMap::PRODUCT_ID . " = " . $this->getRequest()->get("update-product-id"))
         ->findOne();

        if ($product) {
            $product->setPrice($this->getRequest()->get("update-product-price"));
            $product->save();
        }

        return $this->generateRedirect(URL::getInstance()->absoluteUrl("/admin/module/revenue-wholesale-selling-prices?product_id=" . $this->getRequest()->get("update-product-id")));
    }

}
