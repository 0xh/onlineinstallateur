<?php

namespace RevenueDashboard\Loop;

use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use RevenueDashboard\Model\Map\OrderRevenueTableMap;
use RevenueDashboard\Model\Map\WholesalePartnerProductTableMap;
use RevenueDashboard\Model\OrderRevenueQuery;
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
            $loopResultRow->set("id", $listing->getId())
                    ->set("order_id", $listing->getOrderId())
                    ->set("delivery_cost", $listing->getDeliveryCost())
                    ->set("delivery_method", $listing->getDeliveryMethod())
                    ->set("partner_id", $listing->getPartnerId())
                    ->set("payment_processor_cost", $listing->getPaymentProcessorCost())
                    ->set("price", $listing->getPrice())
                    ->set("purchase_price", $listing->getPurchasePrice())
                    ->set("total_purchase_price", $listing->getTotalPurchasePrice())
                    ->set("revenue", $listing->getRevenue());
                    
            $loopResult->addRow($loopResultRow);
        }

        return $loopResult;
    }

    public function buildModelCriteria() {

         $query = OrderRevenueQuery::create()
                ->setFormatter(ModelCriteria::FORMAT_ON_DEMAND)
                ->orderBy(OrderRevenueTableMap::ID, Criteria::DESC);
        return $query;
    }

}
