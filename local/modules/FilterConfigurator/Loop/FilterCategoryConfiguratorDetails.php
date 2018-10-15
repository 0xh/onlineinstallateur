<?php
namespace FilterConfigurator\Loop;

use FilterConfigurator\Model\FilterConfiguratorQuery;
use FilterConfigurator\Model\Map\FilterConfiguratorI18nTableMap;
use FilterConfigurator\Model\Map\FilterConfiguratorImageTableMap;
use FilterConfigurator\Model\Map\FilterConfiguratorTableMap;
use Thelia\Core\Template\Element\BaseI18nLoop;
use Thelia\Core\Template\Element\LoopResult;
use Thelia\Core\Template\Element\LoopResultRow;
use Thelia\Core\Template\Element\PropelSearchLoopInterface;
use Thelia\Core\Template\Loop\Argument\Argument;
use Thelia\Core\Template\Loop\Argument\ArgumentCollection;

class FilterCategoryConfiguratorDetails extends BaseI18nLoop implements PropelSearchLoopInterface{
    protected function getArgDefinitions()
    {
        //return new ArgumentCollection();
        return new ArgumentCollection(
            Argument::createIntTypeArgument('category')
            );
    }
    public function parseResults(LoopResult $loopResult)
    {       

        foreach ($loopResult->getResultDataCollection() as $listing) {
            
            $loopResultRow = new LoopResultRow($listing);
            $loopResultRow->set("CONFIGURATOR_DETAILES_ID", $listing->getId())
                ->set("CONFIGURATOR_DETAILS_TITLE", $listing->getVirtualColumn('title'))
                ->set("CONFIGURATOR_DETAILS_DESCRIPTION", $listing->getVirtualColumn('description'))
                ->set("CONFIGURATOR_DETAILS_IMAGE", $listing->getVirtualColumn('id_image'));
            
            $loopResult->addRow($loopResultRow);
        }
        
        return $loopResult;
    }
    
    // get configurator details for current category - frontOffice
    public function buildModelCriteria()
    {
        if(isset($_GET['category_id'])) {
            $catId = $_GET['category_id'];
        }else{
            $catId = $this->getArgValue("category");
        }
        
        $locale =$this->getCurrentRequest()->getSession()->getLang()->getLocale();
        
        $search = FilterConfiguratorQuery::create()
        ->addJoin(FilterConfiguratorTableMap::ID, FilterConfiguratorImageTableMap::CONFIGURATOR_ID, \Propel\Runtime\ActiveQuery\Criteria::LEFT_JOIN)
        ->addJoin(FilterConfiguratorTableMap::ID, FilterConfiguratorI18nTableMap::ID, \Propel\Runtime\ActiveQuery\Criteria::LEFT_JOIN)
        ->withColumn(FilterConfiguratorImageTableMap::ID, 'id_image' )
        ->withColumn(FilterConfiguratorI18nTableMap::TITLE, 'title' )
        ->withColumn(FilterConfiguratorI18nTableMap::DESCRIPTION, 'description' )
        ->where(FilterConfiguratorTableMap::CATEGORY_ID.' = ?', $catId, \PDO::PARAM_STR)
        ->where(FilterConfiguratorI18nTableMap::LOCALE.' = ?', $locale, \PDO::PARAM_STR)
        ->where(FilterConfiguratorImageTableMap::POSITION.' = 1')
        ->where(FilterConfiguratorImageTableMap::VISIBLE.' = 1');
            
        return $search;
    }
}