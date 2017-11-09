<?php
namespace MultipleFullfilmentCenters\Loop;

use MultipleFullfilmentCenters\Model\Map\FulfilmentCenterProductsTableMap;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Thelia\Core\Template\Element\BaseI18nLoop;
use Thelia\Core\Template\Element\LoopResult;
use Thelia\Core\Template\Element\LoopResultRow;
use Thelia\Core\Template\Element\PropelSearchLoopInterface;
use Thelia\Core\Template\Loop\Argument\ArgumentCollection;
use Thelia\Log\Tlog;
use Thelia\Model\ProductQuery;
use Thelia\Model\Map\ProductI18nTableMap;
use Thelia\Model\Map\ProductTableMap;

/**
 * SettingProductsQuantityLoop
 *
 * Class SettingProductsQuantityLoop
 */
class SettingProductsQuantityLoop extends BaseI18nLoop implements PropelSearchLoopInterface
{
    /**
     *
     * @return ArgumentCollection
     */
    protected function getArgDefinitions()
    {
        return new ArgumentCollection();
    }

    public function parseResults(LoopResult $loopResult)
    {
        $log = Tlog::getInstance();
        $log->err("listingresults " . $loopResult->getCount());
        /** @var \MultipleFullfilmentCenters\Model\SettingProductsQuantityLoop $listing */
        
        foreach ($loopResult->getResultDataCollection() as $listing) {
            $loopResultRow = new LoopResultRow($listing);
            $loopResultRow->set("id", $listing->getId())
                ->set("ref", $listing->getRef())                
                ->set("title", $listing->getVirtualColumn('title'))
                ->set("quantity", $listing->getVirtualColumn('PRODUCT_STOCK'));
            
            $loopResult->addRow($loopResultRow); 
        }
        
        return $loopResult;
    }

    public function buildModelCriteria()
    {

        $changeFulfilmentCenter = (isset($_GET["change_fulfilment_center"])) ? $_GET["change_fulfilment_center"] : -1;
        
        $searchById = isset($_GET["search_by_id"]) ? $_GET["search_by_id"] : false;
        $searchByRef = isset($_GET["search_by_ref"]) ? $_GET["search_by_ref"] : false;
        $searchByTitle = isset($_GET["search_by_title"]) ? $_GET["search_by_title"] : false;

        $query = ProductQuery::create()
                ->setFormatter(ModelCriteria::FORMAT_ON_DEMAND)
                ->addJoin(ProductTableMap::ID, ProductI18nTableMap::ID, \Propel\Runtime\ActiveQuery\Criteria::LEFT_JOIN)
                ->addMultipleJoin(array(
                    array(ProductTableMap::ID, FulfilmentCenterProductsTableMap::PRODUCT_ID),
                    array(FulfilmentCenterProductsTableMap::FULFILMENT_CENTER_ID, $changeFulfilmentCenter))
                    , \Propel\Runtime\ActiveQuery\Criteria::LEFT_JOIN
                )
                ->withColumn(FulfilmentCenterProductsTableMap::PRODUCT_STOCK, 'PRODUCT_STOCK' )
                ->withColumn(FulfilmentCenterProductsTableMap::FULFILMENT_CENTER_ID, 'FULFILMENT_CENTER_ID' )
                ->withColumn(ProductI18nTableMap::TITLE, 'title' );
                
        if ($changeFulfilmentCenter == -1)
        {
            if (!$searchById && !$searchByRef && !$searchByTitle)
                $query = $query->where(FulfilmentCenterProductsTableMap::FULFILMENT_CENTER_ID." = '". 
                    $changeFulfilmentCenter ."'");
        }
                
        if ($searchById)
            $query = $this->searchByID($searchById, $query);
        
        if ($searchByRef)
            $query = $this->searchByRef($searchByRef, $query);
        
        if ($searchByTitle)
            $query = $this->searchByTitle($searchByTitle, $query);
        
        $query = $query->where(ProductI18nTableMap::LOCALE.' = ?', 'de_DE', \PDO::PARAM_STR);
        $query = $query->groupById();
        
        $query = $query->orderById(); 
        
        return $query;
    }
    
    protected function searchById($searchById, $query){
        $query = $query->where(ProductTableMap::ID.' = ?', $searchById, \PDO::PARAM_STR);
        return $query;
    }
    
    protected function searchByRef($searchByRef, $query){
        $query = $query->where(ProductTableMap::REF.' = ?', $searchByRef, \PDO::PARAM_STR);
        return $query;
    }
    
    protected function searchByTitle($searchByTitle, $query){
        $query = $query->where(ProductI18nTableMap::TITLE.' = ?', $searchByTitle, \PDO::PARAM_STR);
        return $query;
    }
}
