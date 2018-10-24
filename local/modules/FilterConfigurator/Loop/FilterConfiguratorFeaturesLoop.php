<?php

namespace FilterConfigurator\Loop;

use FilterConfigurator\Model\FilterConfiguratorFeaturesQuery;
use FilterConfigurator\Model\Map\FilterConfiguratorFeaturesTableMap;
use FilterConfigurator\Model\Map\FilterConfiguratorTableMap;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Exception\PropelException;
use Thelia\Core\Template\Element\BaseI18nLoop;
use Thelia\Core\Template\Element\LoopResult;
use Thelia\Core\Template\Element\LoopResultRow;
use Thelia\Core\Template\Element\PropelSearchLoopInterface;
use Thelia\Core\Template\Loop\Argument\Argument;
use Thelia\Core\Template\Loop\Argument\ArgumentCollection;
use Thelia\Model\Map\FeatureI18nTableMap;
use Thelia\Model\Map\FeatureTableMap;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FilterConfiguratorFeaturesLoop
 *
 * @author Catana Florin
 */
class FilterConfiguratorFeaturesLoop extends BaseI18nLoop implements PropelSearchLoopInterface
{

    public $countable     = true;
    public $timestampable = false;
    public $versionable   = false;

    /*     * *
     * @return ArgumentCollection
     */

    protected function getArgDefinitions()
    {
        return new ArgumentCollection(
         Argument::createIntListTypeArgument('id')
        );
    }

    /**
     * @return ModelCriteria|PageBuilderQuery
     * @throws PropelException
     */
    public function buildModelCriteria()
    {

        $configuratorFeatures = FilterConfiguratorFeaturesQuery::create()
         ->setFormatter(ModelCriteria::FORMAT_ON_DEMAND)
         ->addJoin(FilterConfiguratorFeaturesTableMap::FEATURE_ID, FeatureTableMap::ID)
         ->addJoin(FeatureTableMap::ID, FeatureI18nTableMap::ID)
         ->addJoin(FilterConfiguratorFeaturesTableMap::CONFIGURATOR_ID, FilterConfiguratorTableMap::ID)
         ->withColumn(FeatureI18nTableMap::TITLE, 'title')
         ->withColumn(FilterConfiguratorTableMap::CATEGORY_ID, 'prod_category_id')
         ->filterByConfiguratorId($this->getId())
         ->where(FeatureI18nTableMap::LOCALE . "='" . $this->getCurrentRequest()->getSession()->getLang()->getLocale() . "'");

        return $configuratorFeatures;
    }

    /**
     * @param LoopResult $loopResult
     *
     * @return LoopResult
     */
    public function parseResults(LoopResult $loopResult)
    {
        foreach ($loopResult->getResultDataCollection() as $configuratorFeatures) {

            /** @var PageBuilder $pageBuilder */
            $loopResultRow = new LoopResultRow($configuratorFeatures);

            $loopResultRow
             ->set("ID", $configuratorFeatures->getId())
             ->set("TITLE", $configuratorFeatures->getVirtualColumn('title'))
             ->set("PROD_CATEGORY_id", $configuratorFeatures->getVirtualColumn('prod_category_id'));

            $loopResult->addRow($loopResultRow);
        }
        return $loopResult;
    }

}
