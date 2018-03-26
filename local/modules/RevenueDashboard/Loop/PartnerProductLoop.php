<?php

namespace RevenueDashboard\Loop;

use RevenueDashboard\Model\Map\WholesalePartnerProductTableMap;
use RevenueDashboard\Model\Map\WholesalePartnerTableMap;
use RevenueDashboard\Model\WholesalePartnerProductQuery;
use Thelia\Core\Template\Element\BaseI18nLoop;
use Thelia\Core\Template\Element\LoopResult;
use Thelia\Core\Template\Element\LoopResultRow;
use Thelia\Core\Template\Element\PropelSearchLoopInterface;
use Thelia\Core\Template\Loop\Argument\ArgumentCollection;
use Thelia\Log\Tlog;

/**
 * PartnerProductLoop
 *
 * Class PartnerProductLoop
 */
class PartnerProductLoop extends BaseI18nLoop implements PropelSearchLoopInterface {

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
        /** @var \RevenueDashboard\Model\PartnerProductLoop $listing */
        foreach ($loopResult->getResultDataCollection() as $listing) {
            $loopResultRow = new LoopResultRow($listing);
            $loopResultRow->set("id", $listing->getId())
                    ->set("product_id", $listing->getProductId())
                    ->set("partnerName", $listing->getVirtualColumn("partnerName"))
                    ->set("partner_id", $listing->getVirtualColumn("partnerId"))
                    ->set("price", $listing->getPrice())
                    ->set("package_size", $listing->getPackageSize())
                    ->set("delivery_cost", $listing->getDeliveryCost())
                    ->set("discount", $listing->getDiscount())
                    ->set("discount_description", $listing->getDiscountDescription())
                    ->set("profile_website", $listing->getProfileWebsite())
                    ->set("position", $listing->getPosition())
                    ->set("department", $listing->getDepartment())
                    ->set("comment", $listing->getComment())
                    ->set("valid_until", $listing->getValidUntil() ? $listing->getValidUntil()->format('Y-m-d H:i:s') : date("Y-m-d H:i:s"));

            $loopResult->addRow($loopResultRow);
        }

        return $loopResult;
    }

    public function buildModelCriteria() {

        $query = WholesalePartnerProductQuery::create()
                ->addJoin(WholesalePartnerProductTableMap::PARTNER_ID, WholesalePartnerTableMap::ID)
                ->withColumn(WholesalePartnerTableMap::NAME, 'partnerName' )
                ->withColumn(WholesalePartnerTableMap::ID, 'partnerId' );
        return $query;
    }

}
