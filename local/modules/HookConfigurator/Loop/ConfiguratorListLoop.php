<?php
namespace HookConfigurator\Loop;

use HookConfigurator\Model\ConfiguratorQuery;
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
 * Description of ConfiguratorListLoop
 *
 * @author Catana Florin
 */
class ConfiguratorListLoop extends BaseI18nLoop implements PropelSearchLoopInterface {

    public $countable = true;
    public $timestampable = false;
    public $versionable = false;

    /*     * *
     * @return ArgumentCollection
     */

    protected function getArgDefinitions() {
        return new ArgumentCollection(
                Argument::createIntListTypeArgument('id'), Argument::createBooleanOrBothTypeArgument('visible', true), Argument::createAnyTypeArgument('title'), Argument::createIntListTypeArgument('position'), Argument::createIntListTypeArgument('exclude')
        );
    }

    /**
     * @return ModelCriteria|PageBuilderQuery
     * @throws PropelException
     */
    public function buildModelCriteria() {

        $configuratorList = ConfiguratorQuery::create()
                ->orderById();

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
                    ->set("name", $configurator->getName())
                    ->set("parameters", $configurator->getParameters());
            
            $loopResult->addRow($loopResultRow);
        }
        return $loopResult;
    }

}
