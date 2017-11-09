<?php
namespace AmazonIntegration\Loop;

use AmazonIntegration\Model\AmazonProductsHfQuery;
use AmazonIntegration\Model\Map\AmazonProductsHfTableMap;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Thelia\Core\Template\Element\BaseI18nLoop;
use Thelia\Core\Template\Element\LoopResult;
use Thelia\Core\Template\Element\LoopResultRow;
use Thelia\Core\Template\Element\PropelSearchLoopInterface;
use Thelia\Core\Template\Loop\Argument\ArgumentCollection;
use Thelia\Log\Tlog;
use Thelia\Model\ProductQuery;
use Thelia\Model\Map\BrandI18nTableMap;
use Thelia\Model\Map\ProductI18nTableMap;
use Thelia\Model\Map\ProductPriceTableMap;
use Thelia\Model\Map\ProductSaleElementsTableMap;
use Thelia\Model\Map\ProductTableMap;

/**
 * AmazonProductsLoop
 *
 * Class AmazonProductsLoop
 */
class AmazonProductsLoop extends BaseI18nLoop implements PropelSearchLoopInterface
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
        /** @var \AmazonIntegration\Model\AmazonProductsLoop $listing */
        
        foreach ($loopResult->getResultDataCollection() as $listing) {
            $loopResultRow = new LoopResultRow($listing);
            $loopResultRow->set("id", $listing->getId())
                ->set("ref", $listing->getRef())                
                ->set("title", $listing->getVirtualColumn('title'))
                ->set("quantity", $listing->getVirtualColumn('quantity'))
                ->set("MARKETPLACE_LOCALE", $listing->getVirtualColumn('MARKETPLACE_LOCALE'))
                ->set("ean_code", $listing->getVirtualColumn('ean_code'))
                ->set("currency", $listing->getVirtualColumn('currency'))
                ->set("brand_title", $listing->getVirtualColumn('brand_title'))
                ->set("price",$listing->getVirtualColumn('price'));
            
            $loopResult->addRow($loopResultRow); 
        }
        
        return $loopResult;
    }

    public function buildModelCriteria()
    {
//         $sort = (isset($_GET["sort"]) && $_GET["sort"] == "asc") ? Criteria::ASC : Criteria::DESC;
        
        $positionBrand = isset($_GET["position_brand"]) ? $_GET["position_brand"] : 'all';
        $positionMarketplace = isset($_GET["position_marketplace"]) ? $_GET["position_marketplace"] : 'all';
        $positionSentAmazon = isset($_GET["position_sent_amazon"]) ? $_GET["position_sent_amazon"] : 'all';

        $searchById = isset($_GET["search_by_id"]) ? $_GET["search_by_id"] : false;
        $searchByRef = isset($_GET["search_by_ref"]) ? $_GET["search_by_ref"] : false;
        $searchByEan = isset($_GET["search_by_ean"]) ? $_GET["search_by_ean"] : false;
        $searchByTitle = isset($_GET["search_by_title"]) ? $_GET["search_by_title"] : false;

        $query = ProductQuery::create()
                ->setFormatter(ModelCriteria::FORMAT_ON_DEMAND)
                ->addJoin(ProductTableMap::ID, ProductI18nTableMap::ID, \Propel\Runtime\ActiveQuery\Criteria::LEFT_JOIN)
                ->addJoin(ProductTableMap::ID, ProductSaleElementsTableMap::PRODUCT_ID, \Propel\Runtime\ActiveQuery\Criteria::LEFT_JOIN)
                ->addJoin(ProductTableMap::BRAND_ID, BrandI18nTableMap::ID, \Propel\Runtime\ActiveQuery\Criteria::LEFT_JOIN)
                ->addJoin(ProductSaleElementsTableMap::ID, ProductPriceTableMap::PRODUCT_SALE_ELEMENTS_ID, \Propel\Runtime\ActiveQuery\Criteria::INNER_JOIN)
                ->setDistinct()
                ->addJoin(ProductTableMap::ID, AmazonProductsHfTableMap::PRODUCT_ID, \Propel\Runtime\ActiveQuery\Criteria::LEFT_JOIN)
                ->withColumn(AmazonProductsHfTableMap::MARKETPLACE_LOCALE, 'MARKETPLACE_LOCALE' )
                ->withColumn(AmazonProductsHfTableMap::PRICE, 'price' )
                ->withColumn(ProductI18nTableMap::TITLE, 'title' )
                ->withColumn(AmazonProductsHfTableMap::QUANTITY, 'quantity' )
                ->withColumn(AmazonProductsHfTableMap::CURRENCY, 'currency' )
                ->withColumn(ProductSaleElementsTableMap::EAN_CODE, 'ean_code' )
                ->withColumn(BrandI18nTableMap::TITLE, 'brand_title' )
                ->where(BrandI18nTableMap::LOCALE.' = ?', 'de_DE', \PDO::PARAM_STR)
                ->where(ProductI18nTableMap::LOCALE.' = ?', 'de_DE', \PDO::PARAM_STR);
        
        if ($positionBrand != "all")
            $query = $query->where(BrandI18nTableMap::ID.' = ?', $positionBrand, \PDO::PARAM_STR);

        if ($positionMarketplace != "all")
        {
            if ($positionSentAmazon == "no")
            {
                $query = $query->addOr(AmazonProductsHfTableMap::MARKETPLACE_ID, $positionMarketplace);
            }
            else if ($positionSentAmazon == "yes")
            {
                $query = $query->where(AmazonProductsHfTableMap::MARKETPLACE_ID.' = ?', $positionMarketplace, \PDO::PARAM_STR);
            }
        }
        
        if ($positionSentAmazon != "all")
        {
            if ($positionSentAmazon == "yes")
            {
                if ($positionMarketplace != "all")   
                    $query = $query->where(AmazonProductsHfTableMap::MARKETPLACE_ID.' = ?', $positionMarketplace, \PDO::PARAM_STR);
                else 
                    $query = $query->where(AmazonProductsHfTableMap::MARKETPLACE_LOCALE.' is not NULL');
            }
            else
            {
                if ($positionSentAmazon == "no" && $positionMarketplace != "all")
                    $query = $query->where(ProductTableMap::ID.' not in '. $this->getProdcutsIdByMarketplaceId($positionMarketplace));
                else
                    $query = $query->where(AmazonProductsHfTableMap::MARKETPLACE_LOCALE.' is NULL');
            }
        }
        
        $_SESSION['position_brand'] = $positionBrand;
        $_SESSION['position_marketplace'] = $positionMarketplace;
        $_SESSION['position_sent_amazon'] = $positionSentAmazon;
        
        if ($searchById)
            $query = $this->searchByID($searchById, $query);
        
        if ($searchByRef)
            $query = $this->searchByRef($searchByRef, $query);
        
        if ($searchByEan)
            $query = $this->searchByEan($searchByEan, $query);
        
        if ($searchByTitle)
            $query = $this->searchByTitle($searchByTitle, $query);

        $query = $query->orderById(); 
        return $query;
    }
    
    protected function getProdcutsIdByMarketplaceId($marketplaceId)
    {
        $query = AmazonProductsHfQuery::create()
                ->where(AmazonProductsHfTableMap::MARKETPLACE_ID.' = ?', $marketplaceId, \PDO::PARAM_STR)
                ->find();
        
        $prodsId = '(';
        foreach ($query as $res)
            if ($res->getProductId())
            {
                $prodsId .= $res->getProductId();
                $prodsId .= ', ';
            }
        $prodsId .= ' 0)';
        
        return $prodsId;
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
}
