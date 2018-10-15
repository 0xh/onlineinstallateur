<?php

namespace HookConfigurator\Loop;

use HookConfigurator\Model\ConfiguratorElementsQuery;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Exception\PropelException;
use Thelia\Core\Template\Element\BaseI18nLoop;
use Thelia\Core\Template\Element\LoopResult;
use Thelia\Core\Template\Element\LoopResultRow;
use Thelia\Core\Template\Element\PropelSearchLoopInterface;
use Thelia\Core\Template\Loop\Argument\Argument;
use Thelia\Core\Template\Loop\Argument\ArgumentCollection;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ConfiguratorPageElementsLoop
 *
 * @author Catana Florin
 */
class ConfiguratorPageElementsLoop extends BaseI18nLoop implements PropelSearchLoopInterface {

    public $countable = true;
    public $timestampable = false;
    public $versionable = false;

    /*     * *
     * @return ArgumentCollection
     */

    protected function getArgDefinitions() {
        return new ArgumentCollection(
                Argument::createIntTypeArgument("id")
        );
    }

    /**
     * @return ModelCriteria|PageBuilderQuery
     * @throws PropelException
     */
    public function buildModelCriteria() {

        $configuratorList = ConfiguratorElementsQuery::create()
                ->filterByConfiguratorId($this->getId());

        return $configuratorList;
    }

    /**
     * @param LoopResult $loopResult
     *
     * @return LoopResult
     */
    public function parseResults(LoopResult $loopResult) {

        foreach ($loopResult->getResultDataCollection() as $configuratorPage) {

            /** @var PageBuilder $pageBuilder */
            $loopResultRow = new LoopResultRow($configuratorPage);

            $loopResultRow
                    ->set("id", $configuratorPage->getId())
                    ->set("configurator_id", $configuratorPage->getConfiguratorId())
                    ->set("visible", $configuratorPage->getVisible())
                    ->set("question", $configuratorPage->getQuestion())
                    ->set("typeElement", $configuratorPage->getType())
                    ->set("parameters", $configuratorPage->getParameters());

            $loopResult->addRow($loopResultRow);
        }
        return $loopResult;
    }

}
