<?php

namespace RevenueDashboard\Loop;

use Propel\Runtime\ActiveQuery\ModelCriteria;
use RevenueDashboard\Model\Map\WholesalePartnerProductTableMap;
use Thelia\Core\Template\Element\BaseI18nLoop;
use Thelia\Core\Template\Element\LoopResult;
use Thelia\Core\Template\Element\LoopResultRow;
use Thelia\Core\Template\Element\PropelSearchLoopInterface;
use Thelia\Core\Template\Loop\Argument\ArgumentCollection;
use Thelia\Log\Tlog;
use Thelia\Model\Map\OrderProductTableMap;
use Thelia\Model\Map\ProductTableMap;
use Thelia\Model\ProductQuery;

/**
 * RevenueDashboardLoop
 *
 * Class RevenueDashboardLoop
 */
class RevenueDashboardLoop extends BaseI18nLoop implements PropelSearchLoopInterface {

    /**
     *
     * @return ArgumentCollection
     */
    protected function getArgDefinitions() {
        return new ArgumentCollection();
    }

    public function parseResults(LoopResult $loopResult) {
        $log = Tlog::getInstance();
        $log->err("listingresults " . $loopResult->getCount());
        /** @var \RevenueDashboard\Model\RevenueDashboardLoop $listing */
        foreach ($loopResult->getResultDataCollection() as $listing) {
            $loopResultRow = new LoopResultRow($listing);
            $loopResultRow->set("prod_id", $listing->getVirtualColumn("prod_id"))
                    ->set("order_id", $listing->getVirtualColumn("order_id"))
                    ->set("was_in_promo", $listing->getVirtualColumn("was_in_promo"))
                    ->set("quantity", $listing->getVirtualColumn("quantity"))
                    ->set("price", $listing->getVirtualColumn("price"))
                    ->set("purchase_price", $listing->getVirtualColumn("purchase_price"));
                    
            $loopResult->addRow($loopResultRow);
        }

        return $loopResult;
    }

    public function buildModelCriteria() {

         $query = ProductQuery::create()
                ->setFormatter(ModelCriteria::FORMAT_ON_DEMAND)
                ->orderBy(ProductTableMap::ID)
                ->addJoin(ProductTableMap::ID, WholesalePartnerProductTableMap::PRODUCT_ID)
                ->addJoin(ProductTableMap::REF, OrderProductTableMap::PRODUCT_REF)
                ->withColumn(OrderProductTableMap::ORDER_ID, 'order_id')
                ->withColumn(OrderProductTableMap::WAS_IN_PROMO, 'was_in_promo')
                ->withColumn(OrderProductTableMap::QUANTITY, 'quantity')
                ->withColumn(OrderProductTableMap::PRICE, 'price')
                ->withColumn(WholesalePartnerProductTableMap::PRICE, 'purchase_price')
                ->withColumn(ProductTableMap::ID , 'prod_id');
        return $query;
    }

}
