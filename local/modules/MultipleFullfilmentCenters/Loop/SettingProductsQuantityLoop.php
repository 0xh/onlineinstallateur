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
use Thelia\Model\Map\ProductSaleElementsTableMap;
use Thelia\Model\Map\ProductTableMap;
use MultipleFullfilmentCenters\Model\Map\FulfilmentCenterTableMap;
use Propel\Runtime\ActiveQuery\Criteria;
use MultipleFullfilmentCenters\Model\FulfilmentCenterProductsQuery;

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
                ->set("ean_code", $listing->getVirtualColumn('ean_code'))
                ->set("fulfilment_center_name", $listing->getVirtualColumn('fulfilment_center_name'))
                ->set("quantity", $listing->getVirtualColumn('PRODUCT_STOCK'));
            
            $loopResult->addRow($loopResultRow); 
        }
        
        return $loopResult;
    }

    public function buildModelCriteria()
    {

        $changeFulfilmentCenter = (isset($_GET["fulfilment_center"])) ? $_GET["fulfilment_center"] : -1;
        $changeFulfilmentCenterQuantity = (isset($_GET["change_fulfilment_center_qunatity"])) ? $_GET["change_fulfilment_center_qunatity"] : -1;
        $isInFulfilmentCenter = (isset($_GET["is_in_fulfilment_center"])) ? $_GET["is_in_fulfilment_center"] : -1;
        
        $searchById = isset($_GET["search_by_id"]) ? $_GET["search_by_id"] : false;
        $searchByRef = isset($_GET["search_by_ref"]) ? $_GET["search_by_ref"] : false;
        $searchByEan = isset($_GET["search_by_ean"]) ? $_GET["search_by_ean"] : false;
        $searchByTitle = isset($_GET["search_by_title"]) ? $_GET["search_by_title"] : false;
        
        $query = ProductQuery::create()
                ->setFormatter(ModelCriteria::FORMAT_ON_DEMAND)
                ->addJoin(ProductTableMap::ID, ProductI18nTableMap::ID, \Propel\Runtime\ActiveQuery\Criteria::LEFT_JOIN)
                ->addJoin(ProductTableMap::ID, ProductSaleElementsTableMap::PRODUCT_ID, \Propel\Runtime\ActiveQuery\Criteria::LEFT_JOIN)
                ->withColumn(FulfilmentCenterProductsTableMap::PRODUCT_STOCK, 'PRODUCT_STOCK' )
                ->withColumn(FulfilmentCenterProductsTableMap::FULFILMENT_CENTER_ID, 'FULFILMENT_CENTER_ID' )
                ->withColumn(ProductSaleElementsTableMap::EAN_CODE, 'ean_code' )
                ->withColumn(ProductI18nTableMap::TITLE, 'title' );
                
        if ($changeFulfilmentCenter == -1)
        {
            if ($changeFulfilmentCenterQuantity == -1)
                $query = $query->addJoin(ProductTableMap::ID, FulfilmentCenterProductsTableMap::PRODUCT_ID, \Propel\Runtime\ActiveQuery\Criteria::LEFT_JOIN);
            else 
                $query = $query->addMultipleJoin(array(
                    array(ProductTableMap::ID, FulfilmentCenterProductsTableMap::PRODUCT_ID),
                    array(FulfilmentCenterProductsTableMap::PRODUCT_STOCK, $changeFulfilmentCenterQuantity, Criteria::LESS_EQUAL)),
                    \Propel\Runtime\ActiveQuery\Criteria::INNER_JOIN
                );
        }
        else 
        {

            if ($changeFulfilmentCenterQuantity > -1)
                $query = $query->addMultipleJoin(array(
                        array(ProductTableMap::ID, FulfilmentCenterProductsTableMap::PRODUCT_ID),
                        array(FulfilmentCenterProductsTableMap::FULFILMENT_CENTER_ID, $changeFulfilmentCenter),
                        array(FulfilmentCenterProductsTableMap::PRODUCT_STOCK, $changeFulfilmentCenterQuantity, Criteria::LESS_EQUAL))
                        , \Propel\Runtime\ActiveQuery\Criteria::INNER_JOIN
                    );
            else
                $query = $query->addMultipleJoin(array(
                        array(ProductTableMap::ID, FulfilmentCenterProductsTableMap::PRODUCT_ID),
                        array(FulfilmentCenterProductsTableMap::FULFILMENT_CENTER_ID, $changeFulfilmentCenter))
                        , \Propel\Runtime\ActiveQuery\Criteria::LEFT_JOIN
                    );
        }
        
        if ($searchById)
            $query = $query->where(ProductTableMap::ID.' = ?', $searchById, \PDO::PARAM_STR);
        
        if ($searchByRef)
            $query = $query->where(ProductTableMap::REF.' = ?', $searchByRef, \PDO::PARAM_STR);

        if ($searchByEan)
            $query = $query->where(ProductSaleElementsTableMap::EAN_CODE.' = ?', $searchByEan, \PDO::PARAM_STR);
        
        if ($searchByTitle)
            $query = $query->where(ProductI18nTableMap::TITLE.' = ?', $searchByTitle, \PDO::PARAM_STR);
        
        $query = $query->addJoin(FulfilmentCenterProductsTableMap::FULFILMENT_CENTER_ID, FulfilmentCenterTableMap::ID, \Propel\Runtime\ActiveQuery\Criteria::LEFT_JOIN)
                    ->withColumn(FulfilmentCenterTableMap::NAME, 'fulfilment_center_name' );
            
        $query = $query->where(ProductI18nTableMap::LOCALE.' = ?', 'de_DE', \PDO::PARAM_STR);
        
        $idProds = $this->getProdId($changeFulfilmentCenter);
        if ($isInFulfilmentCenter == 1)
        {
            $query = $query->where(ProductTableMap::ID . ' in ' . $idProds . '');
        }
        elseif ($isInFulfilmentCenter == 2)
        {
            $query = $query->where(ProductTableMap::ID . ' not in ' . $idProds );
        }
        
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
    
    protected function searchByEan($searchByEan, $query){
        $query = $query->where(ProductSaleElementsTableMap::EAN_CODE.' = ?', $searchByEan, \PDO::PARAM_STR);
        return $query;
    }
    
    protected function searchByTitle($searchByTitle, $query){
        $query = $query->where(ProductI18nTableMap::TITLE.' = ?', $searchByTitle, \PDO::PARAM_STR);
        return $query;
    }
    
    protected function getProdId($changeFulfilmentCenter){
        
        $query = FulfilmentCenterProductsQuery::create()
        ->where(FulfilmentCenterProductsTableMap::FULFILMENT_CENTER_ID.' = ?', $changeFulfilmentCenter, \PDO::PARAM_STR)
                ->find();
        $ids = "(";
        foreach ($query as $q)
        {
            $ids .= $q->getProductId();
            $ids .= ",";
        }
        $ids .= "0)";
        
        return $ids;
    }
}
