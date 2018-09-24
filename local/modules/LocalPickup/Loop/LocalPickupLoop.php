<?php

namespace LocalPickup\Loop;

use LocalPickup\Model\LocalPickup as LocalPickupModel;
use LocalPickup\Model\LocalPickupQuery;
use Thelia\Core\Template\Element\BaseI18nLoop;
use Thelia\Core\Template\Element\LoopResult;
use Thelia\Core\Template\Element\LoopResultRow;
use Thelia\Core\Template\Element\PropelSearchLoopInterface;
use Thelia\Core\Template\Loop\Argument\ArgumentCollection;

class LocalPickupLoop extends BaseI18nLoop implements PropelSearchLoopInterface {
    public $countable = true;
    public $timestampable = false;
    public $versionable = false;
    
    protected function getArgDefinitions() {
        return new ArgumentCollection();
    }

    public function buildModelCriteria() {
        return LocalPickupQuery::create();
    }

    /**
     * @param LoopResult $loopResult
     *
     * @return LoopResult
     */
    public function parseResults(LoopResult $loopResult) {
        /** @var LocalPickupModel $localPickupModel */
        foreach ($loopResult->getResultDataCollection() as $localPickupModel) {
            $row = new LoopResultRow($localPickupModel);
            $row
                    ->set("ID", $localPickupModel->getId())
                    ->set("ADDRESS", $localPickupModel->getAddress())
                    ->set("GPSLAT", (float) $localPickupModel->getGpsLat())
                    ->set("GPSLONG", (float) $localPickupModel->getGpsLong())
                    ->set("HINT", $localPickupModel->getHint());
            $loopResult->addRow($row);
        }
        return $loopResult;
    }

}

// SELECT statement [SELECT local_pickup.ID, local_pickup.ADDRESS, local_pickup.GPS_LAT, local_pickup.GPS_LONG, local_pickup.HINT, 
// local_pickup.CREATED_AT, local_pickup.UPDATED_AT FROM `local_pickup` LIMIT 9223372036854775807]
