<?php
namespace FilterConfigurator\Loop;

use Propel\Runtime\ActiveQuery\ModelCriteria;
use Thelia\Core\Template\Element\BaseI18nLoop;
use Thelia\Core\Template\Element\LoopResult;
use Thelia\Core\Template\Element\LoopResultRow;
use Thelia\Core\Template\Element\PropelSearchLoopInterface;
use Thelia\Core\Template\Loop\Argument\Argument;
use Thelia\Core\Template\Loop\Argument\ArgumentCollection;
use Thelia\Model\Map\FeatureAvTableMap;
use Thelia\Model\Map\FeatureAvI18nTableMap;
use Thelia\Model\Base\FeatureAvQuery;

class FilterFeaturesValue extends BaseI18nLoop implements PropelSearchLoopInterface{
    protected function getArgDefinitions()
    {
        return new ArgumentCollection(
            Argument::createIntTypeArgument('feature_id')
            );
    }
    public function parseResults(LoopResult $loopResult)
    {   

        foreach ($loopResult->getResultDataCollection() as $listing) {
            
            $loopResultRow = new LoopResultRow( $listing );

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
