<?php

namespace FilterConfigurator\Loop;

use FilterConfigurator\Model\FilterConfiguratorHookQuery;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Exception\PropelException;
use Thelia\Core\Template\Element\BaseI18nLoop;
use Thelia\Core\Template\Element\LoopResult;
use Thelia\Core\Template\Element\LoopResultRow;
use Thelia\Core\Template\Element\PropelSearchLoopInterface;
use Thelia\Core\Template\Loop\Argument\ArgumentCollection;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FilterConfiguratorHookLoop
 *
 * @author Catana Florin
 */
class FilterConfiguratorHookLoop extends BaseI18nLoop implements PropelSearchLoopInterface {

    public $countable = true;
    public $timestampable = false;
    public $versionable = false;

    /*     * *
     * @return ArgumentCollection
     */

    protected function getArgDefinitions() {
        return new ArgumentCollection();
    }

    /**
     * @return ModelCriteria|PageBuilderQuery
     * @throws PropelException
     */
    public function buildModelCriteria() {

        $configuratorList = FilterConfiguratorHookQuery::create();

        return $configuratorList;
    }

    /**
     * @param LoopResult $loopResult
     *
     * @return LoopResult
     */
    public function parseResults(LoopResult $loopResult) {
        foreach ($loopResult->getResultDataCollection() as $configurator) {

            /** @var PageBuilder $pageBuilder */
            $loopResultRow = new LoopResultRow($configurator);

            $loopResultRow
                    ->set("id", $configurator->getId())
                    ->set("hook_code", $configurator->getHookCode())
                    ->set("hook_id", $configurator->getHookId())
                    ->set("filter_configurator_id", $configurator->getFilterConfiguratorId());

            $loopResult->addRow($loopResultRow);
        }

        return $loopResult;
    }

}
