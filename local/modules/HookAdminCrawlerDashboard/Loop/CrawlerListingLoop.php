<?php
namespace HookAdminCrawlerDashboard\Loop;

use Propel\Runtime\ActiveQuery\Criteria;
use Thelia\Core\Template\Element\BaseI18nLoop;
use Thelia\Core\Template\Element\LoopResult;
use Thelia\Core\Template\Element\LoopResultRow;
use Thelia\Core\Template\Element\PropelSearchLoopInterface;
use Thelia\Core\Template\Loop\Argument\Argument;
use Thelia\Core\Template\Loop\Argument\ArgumentCollection;
use Thelia\Log\Tlog;
use Thelia\Model\ProductQuery;
use Thelia\Model\Product;
use Propel\Runtime\ActiveQuery\Join;
use HookKonfigurator\Model\Map\ProductHeizungTableMap;
use Thelia\Model\Map\ProductTableMap;
use HookAdminCrawlerDashboard\Model\CrawlerProductListing;
use HookAdminCrawlerDashboard\Model\Map\CrawlerProductListingTableMap;
use HookAdminCrawlerDashboard\Model\CrawlerProductListingQuery;

/**
 *
 * CrawlerProductListing loop
 *
 * Class CrawlerListingLoop
 *
 * @package HookAdminCrawlerDashboard\Loop
 * @author Emanuel Plopu <emanuel.plopu@sepa.at>
 */
class CrawlerListingLoop extends BaseI18nLoop implements PropelSearchLoopInterface{
	protected $timestampable = true;
	protected $versionable = true;
	
	/**
	 *
	 * @return ArgumentCollection
	 */
	protected function getArgDefinitions() {
		return new ArgumentCollection (
				Argument::createIntTypeArgument('product_base_id'));
	}
	
	public function parseResults(LoopResult $loopResult) {
		$log = Tlog::getInstance ();
		$log->err("listingresults ".$loopResult->getCount());
		/** @var \HookAdminCrawlerDashboard\Model\CrawlerProductListing $listing */
		foreach ( $loopResult->getResultDataCollection () as $listing ) {
			
			$loopResultRow = new LoopResultRow ( $listing );
			
			$log->err("listingresults ".$listing->getPlatform());
			$loopResultRow
			->set("ID", $listing->getId())
			->set("PRODUCT_BASE_ID", $listing->getProductBaseId())
			->set("HF_POSITION", $listing->getHfPosition())
			->set("HF_PRICE", $listing->getHfPrice())
			->set("HF_PRODUCT_STOCK", $listing->getHfProductStock())
			->set("HF_PRODUCT_STOCK_ORDER", $listing->getHfProductStockOrder())
			->set("LINK_HF_PRODUCT", $listing->getLinkHfProduct())
			->set("FIRST_POSITION", $listing->getFirstPosition())
			->set("FIRST_PRICE", $listing->getFirstPrice())
			->set("PLATFORM", $listing->getPlatform())
			->set("PLATFORM_PRODUCT_ID", $listing->getPlatformProductId())
			->set("LINK_PLATFORM_PRODUCT_PAGE", $listing->getLinkPlatformProductPage())
			->set("LINK_FIRST_PRODUCT", $listing->getLinkFirstProduct())
			;
			//$this->addOutputFields ( $loopResultRow, $product );
			
			$loopResult->addRow ( $loopResultRow );
		}
		
		return $loopResult;
	}
	
	public function buildModelCriteria() {

			$log = Tlog::getInstance ();
			
			$product_base_id = $this->getProductBaseId();
			$query = CrawlerProductListingQuery::create();
			
			$log->err("crawlerlisting ".$product_base_id);
			
			$query->where(CrawlerProductListingTableMap::PRODUCT_BASE_ID.' =?', $product_base_id, \PDO::PARAM_INT);
			
			return $query;
	}
}
