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
use Thelia\Model\Map\OrderTableMap;
use Thelia\Model\Map\ProductTableMap;
use Thelia\Model\ProductQuery;

/**
 * RevenueOrdersLoop
 *
 * Class RevenueOrdersLoop
 */
class RevenueOrdersLoop extends BaseI18nLoop implements PropelSearchLoopInterface {

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
        /** @var \RevenueDashboard\Model\RevenueOrdersLoop $listing */

        foreach ($loopResult->getResultDataCollection() as $listing) {
            $loopResultRow = new LoopResultRow($listing);
            $loopResultRow->set("id", $listing->getId())
                    ->set("order_id", $listing->getOrderId())
                    ->set("delivery_cost", $listing->getDeliveryCost())
                    ->set("delivery_method", $listing->getDeliveryMethod())
                    ->set("partner_id", $listing->getPartnerId())
                    ->set("payment_processor_cost", $listing->getPaymentProcessorCost())
                    ->set("price", $listing->getVirtualColumn("total"))
                    ->set("qunatity", $listing->getQuantity())
                    ->set("purchase_price", $listing->getPurchasePrice())
                    ->set("total_purchase_price", $listing->getTotalPurchasePrice())
                    ->set("revenue", $listing->getVirtualColumn("total_revenue"));

            $loopResult->addRow($loopResultRow);
        }

        return $loopResult;
    }

    public function buildModelCriteria() {

        $datepickerStartDate = $this->request->get("datepickerStartDate") ? $this->request->get("datepickerStartDate") : date('2001-01-01');
        $datepickerEndDate = $this->request->get("datepickerEndDate") ? $this->request->get("datepickerEndDate") : date('Y-m-d', strtotime("+1 day"));

        $query = OrderRevenueQuery::create()
                ->groupByOrderId()
                ->addJoin(OrderRevenueTableMap::ORDER_ID, OrderTableMap::ID)
                ->withColumn('SUM(order_revenue.price * order_revenue.quantity)', 'total')
                ->withColumn('SUM(order_revenue.revenue)', 'total_revenue')
                ->where(OrderTableMap::UPDATED_AT . " >= '$datepickerStartDate' AND " . OrderTableMap::UPDATED_AT . " <= '$datepickerEndDate' ")
                ->orderBy(OrderRevenueTableMap::ID, Criteria::DESC);

        return $query;
    }

}
