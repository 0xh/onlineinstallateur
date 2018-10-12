<?php
namespace FilterConfigurator\Loop;

use Thelia\Core\Template\Element\BaseLoop;
use Thelia\Core\Template\Element\LoopResult;
use Thelia\Core\Template\Element\LoopResultRow;
use Thelia\Core\Template\Element\PropelSearchLoopInterface;
use Thelia\Core\Template\Loop\Argument\ArgumentCollection;
use Thelia\Core\Template\Loop\Argument\Argument;
use FilterConfigurator\Model\FilterConfiguratorQuery;
use FilterConfigurator\Model\Map\FilterConfiguratorI18nTableMap;
use FilterConfigurator\Model\Map\FilterConfiguratorTableMap;
use Propel\Runtime\ActiveQuery\Criteria;

class ProductFilterConfigurator extends BaseLoop implements PropelSearchLoopInterface{
    
    protected function getArgDefinitions()
    {
    	return new ArgumentCollection(	
    			Argument::createAnyTypeArgument("locale"));
    }

    /**
     *
     * return Thelia\Core\Template\Element\LoopResult
     * 
     */
    public function parseResults(LoopResult $loopResult)
    {
        foreach ($loopResult->getResultDataCollection() as $listing) {
             $loopResultRow = new LoopResultRow($listing);
             $loopResultRow->set("CONFIGURATOR_ID", $listing->getId())
                           ->set("TITLE", $listing->getVirtualColumn('TITLE'))
                           ->set("POSITION",$listing->getPosition())
                           ->set("CATEGORY", $listing->getCategoryId());
             
             $loopResult->addRow($loopResultRow);
        }
        
        return $loopResult;
    }

    //  list the filter configurators
    public function buildModelCriteria()
    {
        $search = FilterConfiguratorQuery::create()
        ->addJoin(FilterConfiguratorTableMap::ID, FilterConfiguratorI18nTableMap::ID, \Propel\Runtime\ActiveQuery\Criteria::LEFT_JOIN)
        ->withColumn(FilterConfiguratorI18nTableMap::TITLE, 'TITLE' )
        ->where(FilterConfiguratorI18nTableMap::LOCALE.Criteria::EQUAL.'"'.$this->getLocale().'"');
            
        return $search;
    }
}

