<?php
namespace FilterConfigurator\Loop;

use Propel\Runtime\ActiveQuery\ModelCriteria;
use Thelia\Core\Template\Element\BaseI18nLoop;
use Thelia\Core\Template\Element\LoopResult;
use Thelia\Core\Template\Element\LoopResultRow;
use Thelia\Core\Template\Element\PropelSearchLoopInterface;
use Thelia\Core\Template\Loop\Argument\Argument;
use Thelia\Core\Template\Loop\Argument\ArgumentCollection;
use Thelia\Model\FeatureQuery;
use Thelia\Model\Map\FeatureTableMap;
use Thelia\Model\Map\FeatureI18nTableMap;
use Thelia\Model\Map\FeatureAvTableMap;
use Thelia\Model\Map\FeatureAvI18nTableMap;
use Thelia\Model\FeatureAv;
use Thelia\Model\Base\FeatureAvQuery;

class FilterFeaturesValue extends BaseI18nLoop implements PropelSearchLoopInterface{
    protected function getArgDefinitions()
    {
        //return new ArgumentCollection();
        return new ArgumentCollection(
            Argument::createIntTypeArgument('feature_id')
            );
    }
    public function parseResults(LoopResult $loopResult)
    {   
        /* foreach ($loopResult->getResultDataCollection() as $listing) {
            
            $loopResultRow = new LoopResultRow($listing);
            $loopResultRow->set("C_FEATURE_SIMPLE_VALUE", $listing->getVirtualColumn('val'));
            
            $loopResult->addRow($loopResultRow);
        }
         */

        foreach ($loopResult->getResultDataCollection() as $listing) {
            
            $loopResultRow = new LoopResultRow( $listing );
            
            /* $loopResultRow->set('FEAT_ID', $listing->getVirtualColumn('Feat_ID'))
                          ->set('FI18N_TITLE', $listing->getVirtualColumn('Fi18n_TITLE'))
                          ->set('FeatureAvTID', $listing->getVirtualColumn('FeatureAvTableID'))
                          ->set('FeatureAvI18nTID', $listing->getVirtualColumn('FeatureAvI18nTableID'))
                          ->set('AAA',$listing->getVirtualColumn('aaa')); */
            //\var_dump($listing);
            $loopResultRow->set('FEAT_AV_ID', $listing->getVirtualColumn('FeatureAvID'))
                          ->set(FEAT_AV_I18n_TITLE,$listing->getVirtualColumn('FeatureAvI18nTITLE'))
                          ->set(FEAT_AV_I18n_DESCRIPTION,$listing->getVirtualColumn('FeatureAvI18nDescription'));
                         
            $loopResult->addRow($loopResultRow);
            
        }
        
        return $loopResult;
    }
    
    // get features values for current feature id - frontOffice
    public function buildModelCriteria()
    {
        if(isset($_GET['feature_id'])) {
            $feature_id = $_GET['feature_id'];
        }else{
            $feature_id = $this->getArgValue("feature_id");
        }
        $locale =$this->getCurrentRequest()->getSession()->getLang()->getLocale();
        
        /* $search = FeatureQuery::create()
            ->addJoin(FeatureTableMap::ID, FeatureI18nTableMap::ID, \Propel\Runtime\ActiveQuery\Criteria::LEFT_JOIN)
            ->addJoin(FeatureTableMap::ID, FeatureAvTableMap::FEATURE_ID, \Propel\Runtime\ActiveQuery\Criteria::LEFT_JOIN)
            ->addJoin(FeatureAvTableMap::ID, FeatureAvI18nTableMap::ID, \Propel\Runtime\ActiveQuery\Criteria::LEFT_JOIN)
            ->withColumn(FeatureAvI18nTableMap::TITLE,'val')
            ->where(FeatureTableMap::ID.' = ?', $feature_id, \PDO::PARAM_STR)
            ->where(FeatureI18nTableMap::LOCALE.' = ?', 'de_DE', \PDO::PARAM_STR)
            ->where(FeatureAvI18nTableMap::LOCALE.' = ?', 'de_DE', \PDO::PARAM_STR); */
    
    /*     $search = FeatureQuery::create()
            ->addJoin(FeatureTableMap::ID, FeatureI18nTableMap::ID, \Propel\Runtime\ActiveQuery\Criteria::LEFT_JOIN)
            ->addJoin(FeatureTableMap::ID, FeatureAvTableMap::FEATURE_ID, \Propel\Runtime\ActiveQuery\Criteria::LEFT_JOIN)
            ->addJoin(FeatureAvTableMap::ID, FeatureAvI18nTableMap::ID, \Propel\Runtime\ActiveQuery\Criteria::LEFT_JOIN)
            ->withColumn(FeatureTableMap::ID,'Feat_ID')
            ->withColumn(FeatureI18nTableMap::TITLE,'Fi18n_TITLE')
            ->withColumn(FeatureAvTableMap::ID,'FeatureAvTableID')
            ->withColumn(FeatureAvI18nTableMap::ID,'FeatureAvI18nTableID')
            ->withColumn(FeatureAvI18nTableMap::TITLE,'aaa')            
            ->where(FeatureTableMap::ID.' = ?', $feature_id, \PDO::PARAM_STR)
            ->where(FeatureI18nTableMap::LOCALE.' = ?', 'de_DE', \PDO::PARAM_STR); */
    
        /* $search = FeatureQuery::create()
            ->withColumn(FeatureTableMap::ID,'Feat_ID')
            ->where(FeatureTableMap::ID.' = ?', $feature_id, \PDO::PARAM_STR)
            ->addJoin(FeatureTableMap::ID, FeatureAvTableMap::FEATURE_ID, \Propel\Runtime\ActiveQuery\Criteria::JOIN)
            ->withColumn(FeatureAvTableMap::ID,'Feat_AV_ID')
            ->addJoin(FeatureAvTableMap::FEATURE_ID, FeatureAvI18nTableMap::ID, \Propel\Runtime\ActiveQuery\Criteria::JOIN)
            ->withColumn(FeatureAvI18nTableMap::TITLE,'Feat_AVI18n_TITLE'); */
            //->where(FeatureI18nTableMap::LOCALE.' = ?', 'de_DE', \PDO::PARAM_STR);
            
        
        $search = FeatureAvQuery::create()
            ->setFormatter(ModelCriteria::FORMAT_ON_DEMAND)
            ->where(FeatureAvTableMap::FEATURE_ID.' = ?', $feature_id, \PDO::PARAM_STR)
            ->withColumn(FeatureAvTableMap::ID, 'FeatureAvID')
            ->addJoin(FeatureAvTableMap::ID, FeatureAvI18nTableMap::ID, \Propel\Runtime\ActiveQuery\Criteria::JOIN)
            ->withColumn(FeatureAvI18nTableMap::TITLE, 'FeatureAvI18nTITLE')
            ->withColumn(FeatureAvI18nTableMap::DESCRIPTION, 'FeatureAvI18nDescription')
            ->where(FeatureAvI18nTableMap::LOCALE.' = ?', 'de_DE', \PDO::PARAM_STR);
            
        return $search;
    }

}
