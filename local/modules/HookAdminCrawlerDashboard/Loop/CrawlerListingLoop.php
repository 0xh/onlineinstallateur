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

/**
 *
 * CrawlerProductListing loop
 *
 * Class CrawlerListingLoop
 *
 * @package HookAdminCrawlerDashboard\Loop
 * @author Emanuel Plopu <emanuel.plopu@sepa.at>
 */
class CrawlerProductLoop extends BaseI18nLoop implements PropelSearchLoopInterface{
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
		
		/** @var \HookAdminCrawlerDashboard\Model\CrawlerProductListing $listing */
		foreach ( $loopResult->getResultDataCollection () as $product ) {
			
			$loopResultRow = new LoopResultRow ( $product );
			
			
			$loopResultRow
			->set("PRODUCT_SALE_ELEMENT", $product->getVirtualColumn('pse_id'))
			->set("PSE_COUNT", $product->getVirtualColumn('pse_count'))
			->set("QUANTITY", $product->getVirtualColumn('quantity'))
			->set("PRICE", $price)
			->set("PRICE_TAX", $taxedPrice - $price)
			->set("TAXED_PRICE", $taxedPrice)
			->set("BEST_TAXED_PRICE",  $taxedPrice)
			;
			$this->addOutputFields ( $loopResultRow, $product );
			
			$loopResult->addRow ( $this->associateValues ( $loopResultRow, $product ) );
		}
		
		return $loopResult;
	}
	
	/**
	 *
	 * @param LoopResultRow $loopResultRow
	 *        	the current result row
	 * @param \HookAdminCrawlerDashboard\Model\CrawlerProductListing $listing
	 * @return mixed
	 */
	private function associateValues($loopResultRow, $listing) {
		
		$loopResultRow
		->set ( "ID", $listing->getId() )
		->set ( "REF", $product->getRef () )
		->set ( "LOCALE", "de_DE" )
		->set ( "URL", $product->getUrl ( "de_DE" ) )
		->set ( "POSITION", $product->getPosition () )
		->set ( "VIRTUAL", $product->getVirtual () ? "1" : "0" )
		->set ( "VISIBLE", $product->getVisible () ? "1" : "0" )
		->set ( "TEMPLATE", $product->getTemplateId () )
		->set ( "DEFAULT_CATEGORY", $default_category_id )
		->set ( "TAX_RULE_ID", $product->getTaxRuleId () )
		->set ( "BRAND_ID", $product->getBrandId () ?: 0 )
		->set ( "TITLE", $product->getTitle () )// $product->getTitle())
		->set ( "DESCRIPTION", $product->getDescription())
		->set ( "POWER", $product->getVirtualColumn ( 'power' ) )
		->set ( "GRADE", $product->getVirtualColumn ( 'grade' ))
		->set ( "WARMWATER", $product->getVirtualColumn ( 'warm_water' )? "Yes" : "No")
		->set ( "MONTAGE", 250)//$product->getVirtualColumn('montage_id'))
		->set ( "MONTAGETEXT", "asdas")//$montage->__toString())
		;
		
		return $loopResultRow;
	}


	public function buildModelCriteria() {

			$log = Tlog::getInstance ();
			
			$product_base_id = $this->getProductBaseId();
			$query = \CrawlerProductListingQuery::create();
			
			$query->where(CrawlerProductListingTableMap::PRODUCT_BASE_ID.' =?', $product_base_id, \PDO::PARAM_INT);
			
			return $query;
	}
}
