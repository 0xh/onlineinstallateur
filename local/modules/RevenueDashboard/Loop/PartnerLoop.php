<?php

namespace RevenueDashboard\Loop;

use RevenueDashboard\Model\Base\WholesalePartnerQuery;
use Thelia\Core\Template\Element\BaseI18nLoop;
use Thelia\Core\Template\Element\LoopResult;
use Thelia\Core\Template\Element\LoopResultRow;
use Thelia\Core\Template\Element\PropelSearchLoopInterface;
use Thelia\Core\Template\Loop\Argument\ArgumentCollection;
use Thelia\Log\Tlog;

/**
 * PartnerLoop
 *
 * Class PartnerLoop
 */
class PartnerLoop extends BaseI18nLoop implements PropelSearchLoopInterface {

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
        /** @var \RevenueDashboard\Model\PartnerLoop $listing */
        foreach ($loopResult->getResultDataCollection() as $listing) {
            $loopResultRow = new LoopResultRow($listing);
            $loopResultRow->set("id", $listing->getId())
                    ->set("partnerName", $listing->getName())
                    ->set("description", $listing->getDescription())
                    ->set("comment", $listing->getComment())
                    ->set("priority", $listing->getPriority())
                    ->set("address", $listing->getAddress())
                    ->set("deposit_address", $listing->getDepositAddress())
                    ->set("contact_person", $listing->getContactPerson())
                    ->set("contact_person_explode", explode(";", $listing->getContactPerson()))
                    ->set("delivery_types", $listing->getDeliveryTypes())
                    ->set("return_policy", $listing->getReturnPolicy());

            $loopResult->addRow($loopResultRow);
        }

        return $loopResult;
    }

    public function buildModelCriteria() {

        $query = WholesalePartnerQuery::create()
                ->where(1);

        return $query;
    }

}
