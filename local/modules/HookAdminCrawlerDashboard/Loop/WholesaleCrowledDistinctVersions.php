<?php
namespace HookAdminCrawlerDashboard\Loop;

use HookAdminCrawlerDashboard\Model\Base\CrawlerProductListingQuery;
use Thelia\Core\Template\Element\LoopResult;
use Thelia\Core\Template\Element\LoopResultRow;
use Thelia\Core\Template\Element\PropelSearchLoopInterface;
use Thelia\Core\Template\Loop\Argument\Argument;
use Thelia\Core\Template\Loop\Argument\ArgumentCollection;
use Thelia\Log\Tlog;
use Thelia\Core\Template\Element\BaseLoop;
use Propel\Runtime\ActiveQuery\Criteria;

class WholesaleCrowledDistinctVersions extends BaseLoop implements PropelSearchLoopInterface {

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

        foreach ($loopResult->getResultDataCollection() as $listing) {           
            $loopResultRow = new LoopResultRow($listing);
            $loopResultRow->set("VERSION_NUMBER", $listing->getVersion());                 
            $loopResult->addRow($loopResultRow);           
        }

        return $loopResult;
    }
    
    public function buildModelCriteria() {

        $query = CrawlerProductListingQuery::create()
               ->groupByVersion();

        return $query;
    }
}