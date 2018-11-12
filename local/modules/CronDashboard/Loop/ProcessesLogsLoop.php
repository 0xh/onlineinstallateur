<?php
namespace CronDashboard\Loop;

use CronDashboard\Model\Base\CronDashboardProcessLogQuery;
use Thelia\Core\Template\Element\LoopResult;
use Thelia\Core\Template\Element\LoopResultRow;
use Thelia\Core\Template\Element\PropelSearchLoopInterface;
use Thelia\Core\Template\Loop\Argument\Argument;
use Thelia\Core\Template\Loop\Argument\ArgumentCollection;
use Thelia\Log\Tlog;
use Thelia\Core\Template\Element\BaseLoop;
use Propel\Runtime\ActiveQuery\Criteria;

class ProcessesLogsLoop extends BaseLoop implements PropelSearchLoopInterface {
	
	/**
     * @return ArgumentCollection
     */
    protected function getArgDefinitions() 
    {
        return new ArgumentCollection(
            Argument::createIntListTypeArgument('id')
        );
    }

     public function parseResults(LoopResult $loopResult) 
     {
        $log = Tlog::getInstance();
        $log->err("listingresults " . $loopResult->getCount());

        foreach ($loopResult->getResultDataCollection() as $listing) {           
            $loopResultRow = new LoopResultRow($listing);
            $loopResultRow->set("ID", $listing->getId())
                    ->set("LINUX_USER", $listing->getLinuxUser())
                    ->set("LINUX_PID", $listing->getLinuxPid())
                    ->set("PROCESS_NAME", $listing->getProcessName())
                    ->set("CPU", $listing->getCpu())                   
                    ->set("MEM", $listing->getMem() )
                    ->set("VSZ", $listing->getVsz() )
                    ->set("TTY", $listing->getTty() )
                    ->set("STAT", $listing->getStat())
                    ->set("START", $listing->getStart())
                    ->set("TIME", $listing->getTime())
                    ->set("COMMAND", $listing->getCommand())
                    ->set("THELIA_USER_NAME", $listing->getTheliaUserName())
                    ->set("THELIA_USER_ID", $listing->getTheliaUserId())
                    ->set("ACTION_TRIGGERED", $listing->getActionTriggered())
                    ->set("TRIGGER_TIME", $listing->getTriggerTime())
                    ->set("CREATED_AT", $listing->getCreatedAt());

            $loopResult->addRow($loopResultRow);           
        }

        return $loopResult;
    }

    public function buildModelCriteria() 
    {
        $query = CronDashboardProcessLogQuery::create()
                ->where(1);

        $id = $this->getId();
        if (null !== $id) {
            $query->filterById($id, Criteria::IN);
        }

        return $query;
    }
}