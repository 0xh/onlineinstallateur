<?php   
namespace FilterConfigurator\Loop;

use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Thelia\Core\Template\Element\BaseI18nLoop;
use Thelia\Core\Template\Element\LoopResult;
use Thelia\Core\Template\Element\LoopResultRow;
use Thelia\Core\Template\Element\PropelSearchLoopInterface;
use Thelia\Core\Template\Loop\Argument\Argument;
use Thelia\Core\Template\Loop\Argument\ArgumentCollection;
use FilterConfigurator\Model\ConfiguratorQuery;
use FilterConfigurator\Model\Map\ConfiguratorTableMap;
use FilterConfigurator\Model\ConfiguratorI18n;
use FilterConfigurator\Model\Map\ConfiguratorI18nTableMap;
use FilterConfigurator\Model\Map\ConfiguratorFeaturesTableMap;
use FilterConfigurator\Model\Map\ConfiguratorImageTableMap;
use Thelia\Model\Map\FeatureI18nTableMap;
use Thelia\Model\Map\FeatureAvI18nTableMap;

class FilterCategoryConfigurator extends BaseI18nLoop implements PropelSearchLoopInterface{
    protected function getArgDefinitions()
    {
        //return new ArgumentCollection();
        return new ArgumentCollection(
            Argument::createIntListTypeArgument('category', 1)
          );
    }

    public function parseResults(LoopResult $loopResult)
    {        
        foreach ($loopResult->getResultDataCollection() as $listing) {
            
            $loopResultRow = new LoopResultRow($listing);
              $loopResultRow->set("IDCAT", $listing->getCategoryID())
                     ->set("CONFIGURATOR_ID", $listing->getId())
                     ->set("CONFIGURATOR_TITLE", $listing->getVirtualColumn('title'))
                     ->set("CONFIGURATOR_IMAGE", $listing->getVirtualColumn('file'))
                     ->set("CONFIGURATOR_DESCRIPTION", $listing->getVirtualColumn('description'))
                     ->set("C_FEATURE_ID", $listing->getVirtualColumn('feature_id'))
                     ->set("C_FEATURE_TITLE", $listing->getVirtualColumn('feature_title'))
                     ->set("C_FEATURE_VALUE", $listing->getVirtualColumn('feature_value'));

            $loopResult->addRow($loopResultRow);
        }
        
        return $loopResult;
    }
    
    // get features for current category - frontOffice
    public function buildModelCriteria()
    {
        if(isset($_GET['category_id'])) {
            $catId = $_GET['category_id'];
        }else{
            $catId = $this->getArgValue("category")[0];
        }
        
        $locale =$this->getCurrentRequest()->getSession()->getLang()->getLocale();
        
        $search = ConfiguratorQuery::create()
            ->setFormatter(ModelCriteria::FORMAT_ON_DEMAND)
            ->addJoin(ConfiguratorTableMap::ID, ConfiguratorImageTableMap::CONFIGURATOR_ID, \Propel\Runtime\ActiveQuery\Criteria::LEFT_JOIN)
            ->addJoin(ConfiguratorTableMap::ID, ConfiguratorI18nTableMap::ID, \Propel\Runtime\ActiveQuery\Criteria::LEFT_JOIN)
            ->addJoin(ConfiguratorTableMap::ID, ConfiguratorFeaturesTableMap::CONFIGURATOR_ID, \Propel\Runtime\ActiveQuery\Criteria::LEFT_JOIN)
            ->addJoin(ConfiguratorFeaturesTableMap::FEATURE_ID, FeatureI18nTableMap::ID, \Propel\Runtime\ActiveQuery\Criteria::LEFT_JOIN)
            ->addJoin(ConfiguratorFeaturesTableMap::FEATURE_ID, FeatureAvI18nTableMap::ID, \Propel\Runtime\ActiveQuery\Criteria::LEFT_JOIN)
            ->withColumn(ConfiguratorImageTableMap::FILE, 'file' )
            ->withColumn(ConfiguratorI18nTableMap::TITLE, 'title' )
            ->withColumn(ConfiguratorI18nTableMap::DESCRIPTION, 'description' )
            ->withColumn(ConfiguratorFeaturesTableMap::FEATURE_ID, 'feature_id' )
            ->withColumn(FeatureI18nTableMap::TITLE,'feature_title')
            ->withColumn(FeatureAvI18nTableMap::TITLE,'feature_value')
            ->where(ConfiguratorI18nTableMap::LOCALE.' = ?', $locale, \PDO::PARAM_STR)
            ->where(FeatureI18nTableMap::LOCALE.' = ?', 'de_DE', \PDO::PARAM_STR)
            ->where(FeatureAvI18nTableMap::LOCALE.' = ?', 'de_DE', \PDO::PARAM_STR)
            ->where(ConfiguratorTableMap::CATEGORY_ID.' = ?', $catId, \PDO::PARAM_STR)
            ->where(ConfiguratorImageTableMap::POSITION.'= 1');
                
        return $search;
    }
    
}

