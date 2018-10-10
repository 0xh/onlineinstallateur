<?php

namespace RevenueDashboard\Loop;

use HookAdminCrawlerDashboard\Model\CrawlerProductListingQuery;
use HookAdminCrawlerDashboard\Model\Map\CrawlerProductBaseTableMap;
use HookAdminCrawlerDashboard\Model\Map\CrawlerProductListingTableMap;
use RevenueDashboard\Model\Map\WholesalePartnerProductTableMap;
use Thelia\Core\Template\Element\BaseI18nLoop;
use Thelia\Core\Template\Element\LoopResult;
use Thelia\Core\Template\Element\LoopResultRow;
use Thelia\Core\Template\Element\PropelSearchLoopInterface;
use Thelia\Core\Template\Loop\Argument\ArgumentCollection;
use Thelia\Model\Map\ProductI18nTableMap;
use Thelia\Model\Map\ProductTableMap;

/**
 * SellingPricesLoop
 *
 * Class SellingPricesLoop
 */
class SellingPricesLoop extends BaseI18nLoop implements PropelSearchLoopInterface
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
        /** @var \RevenueDashboard\Model\SellingPricesLoop $listing */
        foreach ($loopResult->getResultDataCollection() as $listing) {
            $loopResultRow = new LoopResultRow($listing);
            $loopResultRow->set("id", $listing->getId())
             ->set("product_id", $listing->getVirtualColumn("PRODUCT_ID"))
             ->set("purchase_price", $listing->getVirtualColumn("purchase_price"))
             ->set("sale_prices", $listing->getFirstPrice())
             ->set("platform", $listing->getPlatform())
             ->set("delivery_cost", $listing->getVirtualColumn("delivery_cost"))
             ->set("title", $listing->getVirtualColumn("TITLE"));

            $loopResult->addRow($loopResultRow);
        }

        return $loopResult;
    }

    public function buildModelCriteria()
    {
        $query = CrawlerProductListingQuery::create()
         ->addJoin(CrawlerProductListingTableMap::PRODUCT_BASE_ID, CrawlerProductBaseTableMap::ID)
         ->addJoin(CrawlerProductBaseTableMap::PRODUCT_ID, ProductTableMap::ID)
         ->addJoin(ProductTableMap::ID, ProductI18nTableMap::ID)
         ->addJoin(CrawlerProductBaseTableMap::PRODUCT_ID, WholesalePartnerProductTableMap::PRODUCT_ID)
         ->withColumn(WholesalePartnerProductTableMap::PRICE, 'purchase_price')
         ->withColumn(WholesalePartnerProductTableMap::DELIVERY_COST, 'delivery_cost')
         ->withColumn(CrawlerProductBaseTableMap::PRODUCT_ID, 'PRODUCT_ID')
         ->withColumn(ProductI18nTableMap::TITLE, 'TITLE')
//         ->where(CrawlerProductListingTableMap::FIRST_PRICE . ">-1")
         ->where(ProductI18nTableMap::LOCALE . "='" . $this->getCurrentRequest()->getSession()->getLang()->getLocale() . "'");

        return $query;
    }

}
