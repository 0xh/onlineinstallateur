<?php

namespace RevenueDashboard\Loop;

use Thelia\Core\Template\Element\BaseI18nLoop;
use Thelia\Core\Template\Element\LoopResult;
use Thelia\Core\Template\Element\LoopResultRow;
use Thelia\Core\Template\Element\PropelSearchLoopInterface;
use Thelia\Core\Template\Loop\Argument\ArgumentCollection;
use Thelia\Log\Tlog;
use Thelia\Model\CustomerTitleI18nQuery;
use Thelia\Model\Map\CustomerTitleI18nTableMap;

/**
 * CustomerTitleInLoop
 *
 * Class CustomerTitleInLoop
 */
class CustomerTitleInLoop extends BaseI18nLoop implements PropelSearchLoopInterface {

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
        /** @var \RevenueDashboard\Model\CustomerTitleInLoop $listing */
        foreach ($loopResult->getResultDataCollection() as $listing) {
            $loopResultRow = new LoopResultRow($listing);
            $loopResultRow->set("id", $listing->getId())
                    ->set("long", $listing->getLong());

            $loopResult->addRow($loopResultRow);
        }

        return $loopResult;
    }

    public function buildModelCriteria() {

        $query = CustomerTitleI18nQuery::create()
                ->where(CustomerTitleI18nTableMap::LOCALE . " = 'en_US'" );
        return $query;
    }

}
