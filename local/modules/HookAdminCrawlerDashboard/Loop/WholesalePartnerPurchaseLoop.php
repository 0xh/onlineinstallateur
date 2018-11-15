<?php

namespace HookAdminCrawlerDashboard\Loop;

use RevenueDashboard\Model\WholesalePartnerProductQuery;
use Thelia\Core\Template\Element\LoopResult;
use Thelia\Core\Template\Element\LoopResultRow;
use Thelia\Core\Template\Element\PropelSearchLoopInterface;
use Thelia\Core\Template\Loop\Argument\Argument;
use Thelia\Core\Template\Loop\Argument\ArgumentCollection;
use Thelia\Log\Tlog;
use Thelia\Core\Template\Element\BaseLoop;
use Propel\Runtime\ActiveQuery\Criteria;

class WholesalePartnerPurchaseLoop extends BaseLoop implements PropelSearchLoopInterface {

    /**
     *
     * @return ArgumentCollection
     */
    protected function getArgDefinitions() {
        return new ArgumentCollection(
                Argument::createIntTypeArgument('product_id'), 
                Argument::createIntTypeArgument('partner_id')
        );
    }

    public function parseResults(LoopResult $loopResult) {
        $log = Tlog::getInstance();
        $log->err("listingresults " . $loopResult->getCount());

            foreach ($loopResult->getResultDataCollection() as $listing) {
                $loopResultRow = new LoopResultRow($listing);
                $loopResultRow->set("ID", $listing->getId())
                    ->set("PARTNERID", $listing->getPartnerId())
                    ->set("PRODUCTID", $listing->getProductId())
                    ->set("PRICE", $listing->getPrice());
                $loopResult->addRow($loopResultRow);
            }
        
        return $loopResult; 
    }

    public function buildModelCriteria() {

        $query = WholesalePartnerProductQuery::create();

        $product_id = $this->getProductId();
        $partner_id = $this->getPartnerId();
        
        if (null !== $product_id)
        {
            $query->filterByProductId($product_id, Criteria::IN);
        }
        
        if (null !== $partner_id)
        {
            $query->filterByPartnerId($partner_id, Criteria::IN);
        }

        return $query;
    }

}
