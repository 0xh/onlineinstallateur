<?php
namespace FilterConfigurator\Loop;

use FilterConfigurator\Model\Base\ConfiguratorQuery;
use FilterConfigurator\Model\Map\ConfiguratorI18nTableMap;
use FilterConfigurator\Model\Map\ConfiguratorImageTableMap;
use FilterConfigurator\Model\Map\ConfiguratorTableMap;
use Propel\Runtime\ActiveQuery\ModelCriteria;
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
        
        $search = ConfiguratorQuery::create()
            ->addJoin(ConfiguratorTableMap::ID, ConfiguratorImageTableMap::CONFIGURATOR_ID, \Propel\Runtime\ActiveQuery\Criteria::LEFT_JOIN)
            ->addJoin(ConfiguratorTableMap::ID, ConfiguratorI18nTableMap::ID, \Propel\Runtime\ActiveQuery\Criteria::LEFT_JOIN)
            ->withColumn(ConfiguratorImageTableMap::ID, 'id_image' )
            ->withColumn(ConfiguratorI18nTableMap::TITLE, 'title' )
            ->withColumn(ConfiguratorI18nTableMap::DESCRIPTION, 'description' )
            ->where(ConfiguratorTableMap::CATEGORY_ID.' = ?', $catId, \PDO::PARAM_STR)
            ->where(ConfiguratorI18nTableMap::LOCALE.' = ?', $locale, \PDO::PARAM_STR)
            ->where(ConfiguratorImageTableMap::POSITION.' = 1')
            ->where(ConfiguratorImageTableMap::VISIBLE.' = 1');
            
        return $search;
    }
}