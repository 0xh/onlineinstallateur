<?php
namespace CronDashboard\Loop;

use CronDashboard\Model\Base\CronJobsQuery;
use Thelia\Core\Template\Element\LoopResult;
use Thelia\Core\Template\Element\LoopResultRow;
use Thelia\Core\Template\Element\PropelSearchLoopInterface;
use Thelia\Core\Template\Loop\Argument\Argument;
use Thelia\Core\Template\Loop\Argument\ArgumentCollection;
use Thelia\Log\Tlog;
use Thelia\Core\Template\Element\BaseLoop;
use Propel\Runtime\ActiveQuery\Criteria;

class CronjobLoop extends BaseLoop implements PropelSearchLoopInterface {

    /**
     *
     * @return ArgumentCollection
     */
    protected function getArgDefinitions() {
        return new ArgumentCollection(
            Argument::createIntListTypeArgument('id')
        );
    }

    public function parseResults(LoopResult $loopResult) {
        $log = Tlog::getInstance();
        $log->err("listingresults " . $loopResult->getCount());

        foreach ($loopResult->getResultDataCollection() as $listing) {
            /*var_dump( $listing->getRunflag() );
            die();*/
            $loopResultRow = new LoopResultRow($listing);
            $loopResultRow->set("id", $listing->getId())
                    ->set("TITLE", $listing->getTitle())
                    ->set("COMMAND", $listing->getCommand())
                    ->set("POSITION", $listing->getPosition())
                    ->set("SCHEDULE", $listing->getSchedule())
                    ->set("NEXTRUN", $listing->getNextrun() )
                    ->set("LASTTRUN", $listing->getLastrun() )
                    ->set("RUNFLAG", $listing->getRunflag() )
                    ->set("CREATE_DATE", $listing->getCreatedAt())
                    ->set("UPDATE_DATE", $listing->getUpdatedAt());

            $loopResult->addRow($loopResultRow);           
        }

        return $loopResult;
    }

    public function buildModelCriteria() {

        $query = CronJobsQuery::create()
                ->where(1);

        $id = $this->getId();
        if (null !== $id) {
            $query->filterById($id, Criteria::IN);
        }

        return $query;
    }

}
