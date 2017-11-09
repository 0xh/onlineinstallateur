<?php
namespace FilterConfigurator\Loop;

use FilterConfigurator\Model\Base\ConfiguratorQuery;
use FilterConfigurator\Model\Map\ConfiguratorI18nTableMap;
use FilterConfigurator\Model\Map\ConfiguratorTableMap;
use Thelia\Core\Template\Element\BaseLoop;
use Thelia\Core\Template\Element\LoopResult;
use Thelia\Core\Template\Element\LoopResultRow;
use Thelia\Core\Template\Element\PropelSearchLoopInterface;
use Thelia\Core\Template\Loop\Argument\ArgumentCollection;



class ProductFilterConfigurator extends BaseLoop implements PropelSearchLoopInterface{
    
    protected function getArgDefinitions()
    {
        return new ArgumentCollection();
    }

    /**
     *
     * return Thelia\Core\Template\Element\LoopResult
     */
    public function parseResults(LoopResult $loopResult)
    {
        foreach ($loopResult->getResultDataCollection() as $listing) {
             $loopResultRow = new LoopResultRow($listing);
             $loopResultRow->set("ID", $listing->getId())
                           ->set("TITLE", $listing->getVirtualColumn('TITLE'))
                           ->set("POSITION",$listing->getPosition()); 
             
             $loopResult->addRow($loopResultRow);
        }
        
        return $loopResult;
    }

    public function buildModelCriteria()
    {
        $search = ConfiguratorQuery::create()
            ->addJoin(ConfiguratorTableMap::ID, ConfiguratorI18nTableMap::ID, \Propel\Runtime\ActiveQuery\Criteria::LEFT_JOIN)
            ->withColumn(ConfiguratorI18nTableMap::TITLE, 'TITLE' );
            
        return $search;
    }
}

