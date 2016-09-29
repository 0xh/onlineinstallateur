<?php

namespace HookKonfigurator\Loop;

use Thelia\Core\Template\Element\BaseI18nLoop;
use Thelia\Core\Template\Element\LoopResult;
use Thelia\Core\Template\Element\LoopResultRow;
use Thelia\Core\Template\Element\PropelSearchLoopInterface;
use Thelia\Core\Template\Element\SearchLoopInterface;
use Thelia\Core\Template\Loop\Argument\Argument;
use Thelia\Core\Template\Loop\Argument\ArgumentCollection;
use Thelia\Log\Tlog;
use Thelia\Model\ProductQuery;
use Thelia\Model\Product;
use Thelia\Model\Map\ProductTableMap;
use HookKonfigurator\Model\ProductHeizungMontageQuery;

/**
 *
 * Services loop
 *
 * Class ProductHeizung
 *
 * @package HookKonfigurator\Loop
 * @author Emanuel Plopu <emanuel.plopu@sepa.at>
 */
class Service extends BaseI18nLoop implements PropelSearchLoopInterface, SearchLoopInterface {
	protected $timestampable = true;
	protected $versionable = true;
	
	/**
	 *
	 * @return ArgumentCollection
	 */
	protected function getArgDefinitions() {
		return new ArgumentCollection ( 
				Argument::createFloatTypeArgument ( 'power' ),
				Argument::createIntTypeArgument('product_id'));
	}
	public function getSearchIn() {
		return [ 
				"ref",
				"title" 
		];
	}
	
	/**
	 *
	 * @param ProductQuery $search        	
	 * @param
	 *        	$searchTerm
	 * @param
	 *        	$searchIn
	 * @param
	 *        	$searchCriteria
	 */
	public function doSearch(&$search, $searchTerm, $searchIn, $searchCriteria) {
		$search->_and ();
		foreach ( $searchIn as $index => $searchInElement ) {
			if ($index > 0) {
				$search->_or ();
			}
			switch ($searchInElement) {
				case "ref" :
					$search->filterByRef ( $searchTerm, $searchCriteria );
					break;
				case "title" :
					$search->where ( "CASE WHEN NOT ISNULL(`requested_locale_i18n`.ID) THEN `requested_locale_i18n`.`TITLE` ELSE `default_locale_i18n`.`TITLE` END " . $searchCriteria . " ?", $searchTerm, \PDO::PARAM_STR );
					break;
			}
		}
	}
	
	public function parseResults(LoopResult $loopResult) {
		// $complex = $this->getComplex();
		
		// if (true === $complex) {
		// return $this->parseComplexResults($loopResult);
		// } else {
		// return $loopResult;
		return $this->parseSimpleResults ( $loopResult );
		// }
	}
	public function parseSimpleResults(LoopResult $loopResult) {
		$log = Tlog::getInstance ();
		$log->debug ( "serviceloop result number " . count ( $loopResult->getResultDataCollection () ) );
		
		/** @var \Thelia\Core\Security\SecurityContext $securityContext */
		$securityContext = $this->container->get ( 'thelia.securityContext' );
		
		$taxCountry = $this->container->get('thelia.taxEngine')->getDeliveryCountry();
		
		
		$i = 1;
		/** @var \Thelia\Model\Product $product */
		foreach ( $loopResult->getResultDataCollection () as $product ) {
			//$log->debug ( "serviceloop product " . $product->__toString() );
			$loopResultRow = new LoopResultRow ( $product );
			
			//$log->debug ( "serviceloop pse_id " . $product->getVirtualColumn('pse_id')." product_id ".$product->getId() );
			$price = $product->getProductSaleElementss () [0]->getProductPrices () [0]->getPrice ();
			
			if ($securityContext->hasCustomerUser() && $securityContext->getCustomerUser()->getDiscount() > 0) {
				$price = $price * (1-($securityContext->getCustomerUser()->getDiscount()/100));
			}
			
			try {
				$taxedPrice = $product->getTaxedPrice(
						$taxCountry,
						$price
						);
			} catch (TaxEngineException $e) {
				$taxedPrice = null;
			}
			$loopResultRow
			->set("LOCALE", "de_DE")
			->set("SERVICE_SALE_ELEMENT", $product->getVirtualColumn('pse_id'))
			->set("SERVICE_PSE_COUNT", $product->getVirtualColumn('pse_count'))
			->set("SERVICE_QUANTITY", $product->getVirtualColumn('quantity'))
			->set("SERVICE_PRICE", $price)
			->set("SERVICE_PRICE_TAX", $taxedPrice - $price)
			->set("SERVICE_TAXED_PRICE", $taxedPrice)
			->set("SERVICE_BEST_TAXED_PRICE",  $taxedPrice)
			->set("RESULT_NUMBER", $i)
			;
			
			$i++;
			$this->addOutputFields ( $loopResultRow, $product );
			
			$loopResult->addRow ( $this->associateValues ( $loopResultRow, $product, $default_category_id ) );
		}
		
		return $loopResult;
	}
	
	/**
	 *
	 * @param LoopResultRow $loopResultRow
	 *        	the current result row
	 * @param \Thelia\Model\Product $product        	
	 * @param
	 *        	$default_category_id
	 * @return mixed
	 */
	private function associateValues($loopResultRow, $product, $default_category_id) {
		$log = Tlog::getInstance ();
		$loopResultRow
		->set ( "LOCALE", "de_DE" )
		->set ( "SERVICE_ID", $product->getId() )
		->set ( "SERVICE_REF", $product->getRef () )
		->set ( "SERVICE_LOCALE", $this->locale )
		->set ( "SERVICE_URL", $product->getUrl ( "de_DE" ) )
		->set ( "SERVICE_POSITION", $product->getPosition () )
		->set ( "SERVICE_VIRTUAL", $product->getVirtual () ? "1" : "0" )
		->set ( "SERVICE_VISIBLE", $product->getVisible () ? "1" : "0" )
		->set ( "SERVICE_TEMPLATE", $product->getTemplateId () )
		->set ( "SERVICE_DEFAULT_CATEGORY", $default_category_id )
		->set ( "SERVICE_TAX_RULE_ID", $product->getTaxRuleId () )
		->set ( "SERVICE_BRAND_ID", $product->getBrandId () ?: 0 )
		->set ( "SERVICE_TITLE", $product->getTitle () )// $product->getTitle())
	//	->set ( "SERVICE_BEST_TAXED_PRICE", $product->getProductSaleElementss () [0]->getProductPrices () [0]->getPrice ()*1.2 )
		//->set ( "CHAPO",  ) // $product->getProductI18ns()[0]->getChapo())
		->set ( "SERVICE_DESCRIPTION", $product->getDescription())
		;
		
		return $loopResultRow;
	}
	
	public function buildModelCriteria() {
		
		$log = Tlog::getInstance ();
		$log->debug("parametersfromloop ".$this->getProductId());
		
		$search = ProductQuery::create ();
		
		$search->innerJoinProductSaleElements('pse');
		$search->addJoinCondition('pse', '`pse`.IS_DEFAULT=1');
		
		$search->innerJoinProductSaleElements('pse_count');
		
		$search->withColumn('`pse`.ID', 'pse_id');
		$search->withColumn('`pse`.QUANTITY', 'quantity');
		$search->withColumn('COUNT(`pse_count`.ID)', 'pse_count');
		
		$search->groupBy(ProductTableMap::ID);
		
		$productHeizungMontageQuerry = ProductHeizungMontageQuery::create();
		$productHeizungMontageQuerry->select('MONTAGE_ID');
		$montageArrayCollection = $productHeizungMontageQuerry->findByProductHeizungId($this->getProductId());
		
		$search->filterById($montageArrayCollection->toArray(null));

		
		return $search;
	}
}
