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
use Propel\Runtime\ActiveQuery\Join;
use Thelia\Model\Map\ProductCategoryTableMap;
use HookKonfigurator\Model\Map\SetsTableMap;
use HookKonfigurator\Model\Sets;
use KlimaKonfigurator\Model\KlimaKonfiguratorEinstellungen;
use Thelia\Model\Map\ProductTableMap;

/**
 *
 * KlimaSets loop
 *
 * Class KlimaSets
 *
 * @package KlimaKonfigurator\Loop
 * @author Emanuel Plopu <emanuel.plopu@sepa.at>
 */
class KlimaSets extends BaseI18nLoop implements PropelSearchLoopInterface, SearchLoopInterface {
	
	/**
	 *
	 * @return ArgumentCollection
	 */
	protected function getArgDefinitions() {
		return new ArgumentCollection ( 
				Argument::createFloatTypeArgument ( 'power' ),
				Argument::createIntTypeArgument("category"));
	}
	public function getSearchIn() {
		return ["ref","title"];
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
		$log->debug ( "klima set loop result number " . count ( $loopResult->getResultDataCollection () ) );
		
		/** @var \Thelia\Core\Security\SecurityContext $securityContext */
		$securityContext = $this->container->get ( 'thelia.securityContext' );

		/** @var \Thelia\Model\Product $product */
		foreach ( $loopResult->getResultDataCollection () as $set ) {
			
			$loopResultRow = new LoopResultRow ( $set );
			

            $loopResultRow
               // ->set("SET_PRODUCT_SALE_ELEMENT", $set->getVirtualColumn('pse_id'))
               // ->set("SET_PSE_COUNT", $set->getVirtualColumn('pse_count'))
               // ->set("SET_QUANTITY", $set->getVirtualColumn('quantity'))
            ;
           //   	$log->debug ( "prod ".$product->getId()." pse count ".$product->getVirtualColumn('pse_count')." quantity ".$product->getVirtualColumn('quantity'));
			
			$this->addOutputFields ( $loopResultRow, $set);
			$associatedValues = $this->associateValues ( $loopResultRow, $set );
			$loopResult->addRow ( $associatedValues );
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
	private function associateValues($loopResultRow, $set) {

	//	$set = new Sets();
		
		
		$loopResultRow
		//product
		->set ( "REF", $set->getRef () )
		->set ( "LOCALE", $this->locale )
		->set ( "URL", $set->getUrl ( $this->locale ) )
		->set ( "POSITION", $set->getPosition () )
		->set ( "SET_VIRTUAL", $set->getVirtual () ? "1" : "0" )
		->set ( "VISIBLE", $set->getVisible () ? "1" : "0" )
		->set ( "TEMPLATE", $set->getTemplateId () )
		->set ( "TAX_RULE_ID", $set->getTaxRuleId () )
		->set ( "BRAND_ID", $set->getBrandId () ?: 0 )
		->set ( "TITLE", $set->getTitle () )// $product->getTitle())
		->set ( "SET_BEST_TAXED_PRICE", $set->getVirtualColumn('efficiency'))//$set->getProduct()->getProductSaleElementss () [0]->getProductPrices () [0]->getPrice () *1.2)
		//sets
		->set ( "SET_ID", $set->getId() )
		->set ( "PRIORITY", $set->getVirtualColumn('priority'))
		->set ( "EFFICIENCY", $set->getVirtualColumn('efficiency') )
		->set ( "POWER", $set->getVirtualColumn('power') )
		->set ( "COMPOSED_IMAGE", $set->getVirtualColumn('composed_image') )
		->set ( "STORAGE", $set->getVirtualColumn('storage') )
		;
		return $loopResultRow;
	}
	
	public function buildModelCriteria() {
		
		$set_category = 25;//$this->getCategory();
		
		$request = $this->request;
		$konfigurator = new KlimaKonfiguratorEinstellungen();
		$konfigurator->populateKonfiguratorFromRequest ( $request );
		$klimabedarf = $konfigurator->calculateKlimaBedarfMultipleRooms();
		header ( 'klimabedarf:' . $klimabedarf/1000 );
		
		//$klimabedarf = $this->getPower();
		$log = Tlog::getInstance ();
		$log->debug(" building modelCriteria for Klima sets category:".$set_category." gesamte klimabedarf ".$klimabedarf." ");

		//1 suche nach passende innengeräte für jede raum
		
		// suche nach passende sets bassierend auf KW 

		$search = ProductQuery::create();
		
		//join pse
		$search->innerJoinProductSaleElements('pse');
		$search->addJoinCondition('pse', '`pse`.IS_DEFAULT=1');
		
		$search->innerJoinProductSaleElements('pse_count');
		
		$search->withColumn('`pse`.ID', 'pse_id');
		$search->withColumn('`pse`.QUANTITY', 'quantity');
		$search->withColumn('COUNT(`pse_count`.ID)', 'pse_count');
		
		$search->groupBy(ProductTableMap::ID);	
		
		//join with sets
		$setsJoin = new Join ();
		$setsJoin->addExplicitCondition ( ProductTableMap::TABLE_NAME, 'ID', null, SetsTableMap::TABLE_NAME, 'PRODUCT_ID', 's' );
		$setsJoin->setJoinType ( Criteria::LEFT_JOIN );
		
		$search
		->addJoinObject ( $setsJoin, 'SetsJoin' )
		->withColumn ( '`s`.product_id', 'set_id' )
		->withColumn ( '`s`.priority', 'priority' )
		->withColumn ( '`s`.efficiency', 'efficiency' )
		->withColumn ( '`s`.power', 'power' )
		->withColumn ( '`s`.composed_image', 'composed_image' )
		->withColumn ( '`s`.storage', 'storage' )
		->condition ( 'prod_set_id', 'product.id = `s`.product_id' )
		->setJoinCondition ( 'SetsJoin', 'prod_set_id' );
		
		//join with categories
	/*	$categoryJoin = new Join ();
		$categoryJoin->addExplicitCondition ( ProductTableMap::TABLE_NAME, 'ID', null, ProductCategoryTableMap::TABLE_NAME, 'PRODUCT_ID', 'pc' );
		$categoryJoin->setJoinType ( Criteria::LEFT_JOIN );
		
		$search
		->addJoinObject ( $categoryJoin, 'ProductCategory' )
		->withColumn ( '`pc`.category_id', 'category_id' )
		->condition ( 'prod_cat_id', 'product.id = `pc`.product_id' )
		->setJoinCondition ( 'ProductCategory', 'prod_cat_id' );		
*/
		
		$search
		->condition ( 'power_larger_then', 'power >= ?', $klimabedarf, \PDO::PARAM_INT )
		//->condition ( 'power_smaller_then', 'power <= ?', $klimabedarf + 1500, \PDO::PARAM_INT )
		//->where ( 'set_id = ?', 1866, \PDO::PARAM_INT );
		//->condition ( 'klima_category', 'category_id = ?', $set_category, \PDO::PARAM_INT )
		->where ( array ('power_larger_then' ), Criteria::LOGICAL_AND );//,'power_smaller_then'

		return $search;
	}
}
