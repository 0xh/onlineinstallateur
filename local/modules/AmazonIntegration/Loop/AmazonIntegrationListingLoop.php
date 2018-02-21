<?php
namespace AmazonIntegration\Loop;

use AmazonIntegration\Model\Base\AmazonOrdersQuery;
use AmazonIntegration\Model\Map\AmazonOrdersTableMap;
use PDO;
use Propel\Runtime\ActiveQuery\Criteria;
use Thelia\Core\Template\Element\BaseI18nLoop;
use Thelia\Core\Template\Element\LoopResult;
use Thelia\Core\Template\Element\LoopResultRow;
use Thelia\Core\Template\Element\PropelSearchLoopInterface;
use Thelia\Core\Template\Loop\Argument\ArgumentCollection;
use Thelia\Log\Tlog;

/**
 * AmazonIntegrationListing loop
 *
 * Class AmazonIntegrationListingLoop
 */
class AmazonIntegrationListingLoop extends BaseI18nLoop implements PropelSearchLoopInterface
{

    protected $timestampable = true;

    protected $versionable = true;

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
        /** @var \AmazonIntegration\Model\AmazonIntegrationListing $listing */
        
        foreach ($loopResult->getResultDataCollection() as $listing) {
            
            $loopResultRow = new LoopResultRow($listing);
            $loopResultRow->set("id", $listing->getId())
                ->set("seller_order_id", $listing->getSellerOrderId())
                ->set("purchase_date", strval($listing->getPurchaseDate()
                ->format('Y-m-d H:i:s')))
                ->set("last_update_date", strval($listing->getPurchaseDate()
                ->format('Y-m-d H:i:s')))
                ->set("order_status", $listing->getOrderStatus())
                ->set("sales_channel", $listing->getSalesChannel())
                ->set("ship_service_level", $listing->getShipServiceLevel())
                ->set("order_total_amount", $listing->getOrderTotalAmount())
                ->set("number_of_items_shipped", $listing->getNumberOfItemsUnshipped())
                ->set("order_total_currency_code", $listing->getOrderTotalCurrencyCode());
            
            $loopResult->addRow($loopResultRow);
        }
        
        return $loopResult;
    }

    public function buildModelCriteria()
    {
        $sort = (isset($_GET["sort"]) && $_GET["sort"] == "asc") ? Criteria::ASC : Criteria::DESC;
        
        $orderAmazonId = isset($_GET["search_term"]) ? $_GET["search_term"] : false;

        if ($orderAmazonId)
            $query = $this->sortByAmazonId($orderAmazonId, $sort);
        else 
            $query = AmazonOrdersQuery::create()
                        ->orderByPurchaseDate($sort);

        return $query;
    }
    
    protected function sortByAmazonId($orderAmazonId, $sort){
        $query = AmazonOrdersQuery::create()
            ->where(AmazonOrdersTableMap::ID.' =?', $orderAmazonId, PDO::PARAM_STR)
            ->orderByPurchaseDate($sort);
        
        return $query;
    }
}
