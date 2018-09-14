<?php

namespace Selection\Loop;

use Propel\Runtime\ActiveQuery\ModelCriteria;
use Selection\Model\Map\SelectionFeaturesTableMap;
use Thelia\Core\Template\Element\BaseI18nLoop;
use Thelia\Core\Template\Element\LoopResult;
use Thelia\Core\Template\Element\LoopResultRow;
use Thelia\Core\Template\Element\PropelSearchLoopInterface;
use Thelia\Core\Template\Loop\Argument\Argument;
use Thelia\Core\Template\Loop\Argument\ArgumentCollection;
use Thelia\Model\FeatureProduct;
use Thelia\Model\FeatureQuery;
use Thelia\Model\Map\FeatureAvI18nTableMap;
use Thelia\Model\Map\FeatureAvTableMap;
use Thelia\Model\Map\FeatureTableMap;
use Thelia\Type;
use Thelia\Type\TypeCollection;

/**
 *
 * {@inheritdoc}
 * @method int[] getId()
 * @method int[] getFeature()
 * @method int[] getExclude()
 * @method string[] getOrder()
 */
class SelectionFeatureAvailabilityAll extends BaseI18nLoop implements PropelSearchLoopInterface
    {

    protected $timestampable = true;

    /**
     * @return ArgumentCollection
     */
    protected function getArgDefinitions()
        {
        return new ArgumentCollection(
          Argument::createIntTypeArgument('feature', null, true),
          Argument::createIntTypeArgument('selection_id', null, true),
          Argument::createIntListTypeArgument('feature_availability'), Argument::createAnyListTypeArgument('free_text'),
          new Argument(
          'order',
          new TypeCollection(
          new Type\EnumListType(array(
            'alpha',
            'alpha_reverse',
            'manual',
            'manual_reverse'))
          ), 'manual'
          ), Argument::createBooleanTypeArgument('force_return', true)
        );
        }

    public function buildModelCriteria()
        {
        $search = FeatureQuery::create()
          ->setFormatter(ModelCriteria::FORMAT_ON_DEMAND)
          ->addJoin(FeatureTableMap::ID, FeatureAvTableMap::FEATURE_ID)
          ->addJoin(FeatureAvTableMap::ID, FeatureAvI18nTableMap::ID)
          ->addJoin(FeatureTableMap::ID, SelectionFeaturesTableMap::FEATURE_ID)
          ->withColumn(FeatureTableMap::ID, "f_id")
          ->withColumn(FeatureAvI18nTableMap::TITLE, "fv_title")
          ->withColumn(FeatureAvI18nTableMap::LOCALE, "fv_LOCALE")
          ->withColumn(SelectionFeaturesTableMap::FEATURE_AV_ID, "f_av_id")
          ->where(FeatureAvI18nTableMap::LOCALE . '=' . '"de_DE" '
          . 'AND ' . SelectionFeaturesTableMap::SELECTION_ID . ' = ' . $this->getSelectionId()
          . ' AND ' . SelectionFeaturesTableMap::FEATURE_ID . ' = ' . $this->getFeature());

        return $search;
        }

    public function parseResults( LoopResult $loopResult )
        {
        /** @var FeatureProduct $featureValue */
        foreach ($loopResult->getResultDataCollection() as
          $featureValue) {

            $loopResultRow = new LoopResultRow($featureValue);

            $loopResultRow
              ->set("FID", $featureValue->getId())
              ->set("FTITLE", $featureValue->getVirtualColumn('fv_title'))
              ->set("F_AV_ID", $featureValue->getVirtualColumn('f_av_id'))
            ;
            $this->addOutputFields($loopResultRow, $featureValue);

            $loopResult->addRow($loopResultRow);
        }

        return $loopResult;
        }

    }
