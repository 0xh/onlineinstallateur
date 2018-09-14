<?php
/*************************************************************************************/
/*      This file is part of the Thelia package.                                     */
/*                                                                                   */
/*      Copyright (c) OpenStudio                                                     */
/*      email : dev@thelia.net                                                       */
/*      web : http://www.thelia.net                                                  */
/*                                                                                   */
/*      For the full copyright and license information, please view the LICENSE.txt  */
/*      file that was distributed with this source code.                             */
/*************************************************************************************/

namespace Selection\Loop;

use Propel\Runtime\ActiveQuery\Criteria;
use Selection\Model\Map\SelectionFeaturesTableMap;
use Selection\Model\SelectionFeaturesQuery;
use Thelia\Core\Template\Element\BaseI18nLoop;
use Thelia\Core\Template\Element\LoopResult;
use Thelia\Core\Template\Element\LoopResultRow;
use Thelia\Core\Template\Element\PropelSearchLoopInterface;
use Thelia\Core\Template\Loop\Argument\Argument;
use Thelia\Core\Template\Loop\Argument\ArgumentCollection;
use Thelia\Model\FeatureAv;
use Thelia\Model\Map\FeatureAvI18nTableMap;
use Thelia\Type;
use Thelia\Type\TypeCollection;

/**
 * FeatureAvailability loop
 *
 *
 * Class FeatureAvailability
 * @package Thelia\Core\Template\Loop
 * @author Etienne Roudeix <eroudeix@openstudio.fr>
 *
 * {@inheritdoc}
 * @method int[] getId()
 * @method int[] getFeature()
 * @method int[] getExclude()
 * @method string[] getOrder()
 */
class SelectionFeatureAvailabilityValues extends BaseI18nLoop implements PropelSearchLoopInterface
{
    protected $timestampable = true;

    /**
     * @return ArgumentCollection
     */
    protected function getArgDefinitions()
    {
        return new ArgumentCollection(
            Argument::createIntListTypeArgument('id'),
            Argument::createIntListTypeArgument('selection_id'),
            Argument::createIntListTypeArgument('feature_id'),
            Argument::createIntListTypeArgument('feature_av_id'),
            Argument::createIntListTypeArgument('freetext_values'),
            new Argument(
                'order',
                new TypeCollection(
                    new Type\EnumListType(array('alpha', 'alpha-reverse', 'manual', 'manual_reverse'))
                ),
                'manual'
            )
        );
    }

    public function buildModelCriteria()
    {
        
        
        $search = SelectionFeaturesQuery::create()
                  ->withColumn(FeatureAvI18nTableMap::ID, "f_id")
                  ->withColumn(FeatureAvI18nTableMap::TITLE, "fv_title")
                  ->withColumn(FeatureAvI18nTableMap::LOCALE, "fv_LOCALE")                  
                  ->addJoin(FeatureAvI18nTableMap::ID, SelectionFeaturesTableMap::FEATURE_AV_ID)                  
                  ->addCond('cond1', FeatureAvI18nTableMap::LOCALE,$this->getCurrentRequest()->getSession()->getLang()->getLocale(), Criteria::EQUAL)
                  ->addCond('cond2', FeatureAvI18nTableMap::ID, SelectionFeaturesTableMap::FEATURE_ID, Criteria::LESS_EQUAL)
                  ->where(array('cond1', 'cond2'), 'and');
        
   
             
        return $search;
    }

    public function parseResults(LoopResult $loopResult)
    {
        
        /** @var FeatureAv $featureAv */
        foreach ($loopResult->getResultDataCollection() as $featureAv) {
            
            $loopResultRow = new LoopResultRow($featureAv);
            $loopResultRow->set("FV_ID", $featureAv->getId())
                ->set("LOCALE", $this->getCurrentRequest()->getSession()->getLang()->getLocale())
                ->set("FEATURE_ID", $featureAv->getFeatureId())
                ->set("FEATURE_AV_ID", $featureAv->getFeatureAvId())
                ->set("POSITION", $featureAv->getPosition())
                ->set("FREETEXT_VALUE", $featureAv->getFreetextValue());
            $this->addOutputFields($loopResultRow, $featureAv);

            $loopResult->addRow($loopResultRow);
        }

        return $loopResult;
    }
}
