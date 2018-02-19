<?php

/*************************************************************************************/
/* This file is part of the Thelia package. */
/* */
/* Copyright (c) OpenStudio */
/* email : dev@thelia.net */
/* web : http://www.thelia.net */
/* */
/* For the full copyright and license information, please view the LICENSE.txt */
/* file that was distributed with this source code. */
/**
 * **********************************************************************************
 */
namespace KlimaKonfigurator\Loop;

use Propel\Runtime\ActiveQuery\Criteria;
use Thelia\Core\Template\Element\BaseI18nLoop;
use Thelia\Core\Template\Element\LoopResult;
use Thelia\Core\Template\Element\LoopResultRow;
use Thelia\Core\Template\Element\PropelSearchLoopInterface;
use Thelia\Core\Template\Element\SearchLoopInterface;
use Thelia\Core\Template\Loop\Argument\Argument;
use Thelia\Core\Template\Loop\Argument\ArgumentCollection;
use Thelia\Log\Tlog;
use Thelia\Model\ProductQuery;
use HookKonfigurator\Model\HfproductsQuery;
use Thelia\Model\Product;
use Thelia\Model\ProductI18n;
use Thelia\Model\ProductImage;
use Thelia\Model\Brand;
use HookKonfigurator\Model\VendorsQuery;
use HookKonfigurator\Model\Vendors;
use HookKonfigurator\Model\Hfproducts;
use Thelia\Model\BrandI18nQuery;
use Thelia\Model\ProductDocument;
use Thelia\Model\ProductDocumentI18n;
use Propel\Runtime\ActiveQuery\Join;
use HookKonfigurator\Model\Map\ProductHeizungTableMap;
use Thelia\Model\Map\ProductTableMap;
use HookKonfigurator\Model\Konfiguratoreinstellung;
use HookKonfigurator\Model\Montage;
use HookKonfigurator\Model\ConstraintsQuery;
use HookKonfigurator\Model\MontageConstraints;
use HookKonfigurator\Model\Constraints;
use HookKonfigurator\Model\Map\ProductHeizungMontageTableMap;
use HookKonfigurator\Model\MontageQuery;
use Thelia\Model\Map\SaleTableMap;
use Thelia\Model\Map\ProductSaleElementsTableMap;
use Thelia\Model\Map\ProductPriceTableMap;
use Thelia\Model\CurrencyQuery;
use KlimaKonfigurator\Model\KlimaKonfiguratorEinstellungen;
use HookKonfigurator\Model\Map\SetProductsTableMap;

/**
 *
 * ProductHeizung loop
 *
 * Class ProductHeizung
 *
 * @package HookKonfigurator\Loop
 * @author Emanuel Plopu <emanuel.plopu@sepa.at>
 */
class KlimaProducts extends BaseI18nLoop implements PropelSearchLoopInterface, SearchLoopInterface {
	protected $timestampable = true;
	protected $versionable = true;
	
	/**
	 *
	 * @return ArgumentCollection
	 */
	protected function getArgDefinitions() {
		return new ArgumentCollection ( 
				Argument::createFloatTypeArgument ( 'setid' ));
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

		return $this->parseSimpleResults ( $loopResult );
	}
	public function parseSimpleResults(LoopResult $loopResult) {
		$log = Tlog::getInstance ();
		$log->debug ( "klimaproducts loop result number " . count ( $loopResult->getResultDataCollection () ) );
		
		/** @var \Thelia\Core\Security\SecurityContext $securityContext */
		$securityContext = $this->container->get ( 'thelia.securityContext' );

		/** @var \Thelia\Model\Product $product */
		foreach ( $loopResult->getResultDataCollection () as $product ) {
			
			$loopResultRow = new LoopResultRow ( $product );
			
            // Find previous and next product, in the default category.
            $default_category_id = $product->getDefaultCategoryId();

            $loopResultRow
                ->set("PRODUCT_SALE_ELEMENT", $product->getVirtualColumn('pse_id'))
                ->set("PSE_COUNT", $product->getVirtualColumn('pse_count'))
                ->set("QUANTITY", $product->getVirtualColumn('quantity'))
            ;
           //   	$log->debug ( "prod ".$product->getId()." pse count ".$product->getVirtualColumn('pse_count')." quantity ".$product->getVirtualColumn('quantity'));
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

		$loopResultRow
		->set ( "ID", $product->getId () )
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
		->set ( "BEST_TAXED_PRICE", $product->getProductSaleElementss () [0]->getProductPrices () [0]->getPrice () )
		//->set ( "CHAPO",  ) // $product->getProductI18ns()[0]->getChapo())
		->set ( "DESCRIPTION", $product->getDescription())
		;
		
		return $loopResultRow;
	}
	
	public function buildModelCriteria() {
		
		// there has to be some better way to convert request parameters into an entity
		//$request = $this->getCurrentRequest();
		$setid = $this->getSetid();
		
		
		$log = Tlog::getInstance ();
		$log->debug(" building modelCriteria for Klima products ".$setid);
		//$this->request->attributes->get('category_id')
		$search = ProductQuery::create ();

		
		$search->innerJoinProductSaleElements('pse');
		$search->addJoinCondition('pse', '`pse`.IS_DEFAULT=1');
		
		$search->innerJoinProductSaleElements('pse_count');
		
		$search->withColumn('`pse`.ID', 'pse_id');
		$search->withColumn('`pse`.QUANTITY', 'quantity');
		$search->withColumn('COUNT(`pse_count`.ID)', 'pse_count');
		
		$search->groupBy(ProductTableMap::ID);
		
		$setProductsJoin = new Join ();
		$setProductsJoin->addExplicitCondition ( ProductTableMap::TABLE_NAME, 'ID', null, SetProductsTableMap::TABLE_NAME, 'PRODUCT_ID', 'sp' );
		$setProductsJoin->setJoinType ( Criteria::LEFT_JOIN );

		$search
		->addJoinObject ( $setProductsJoin, 'KlimaSetProduct' )
		->withColumn ( '`sp`.product_position', 'product_position' )
		->condition ( 'same_product_id', 'product.id = `sp`.product_id' )
		->setJoinCondition ( 'KlimaSetProduct', 'same_product_id' )
		//->condition ( 'set_id_condition', 'power >= ?', $setid, \PDO::PARAM_INT )
		->where ( 'set_id = ?', $setid, \PDO::PARAM_INT )
		->orderBy('product_position'); // power_condition
		
		$search->filterByVisible(1);

		
		return $search;
	}
}
