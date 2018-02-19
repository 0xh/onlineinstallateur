<?php
namespace HookHomepage\Loop;

use Thelia\Core\Template\Element\BaseI18nLoop;
use Thelia\Core\Template\Element\PropelSearchLoopInterface;
use Thelia\Model\ProductQuery;
use Thelia\Core\Template\Loop\OrderProduct;
use Thelia\Model\OrderProductQuery;
use Thelia\Core\Template\Loop\Product;
use Propel\Runtime\ActiveQuery\Join;
use Thelia\Model\Map\ProductTableMap;
use Thelia\Model\Map\OrderProductTableMap;
use Propel\Runtime\ActiveQuery\Criteria;

class BestsellerLoop extends Product implements PropelSearchLoopInterface{
	
	/**
	 * {@inheritDoc}
	 * @see \Thelia\Core\Template\Element\PropelSearchLoopInterface::buildModelCriteria()
	 */
	public function buildModelCriteria() {
		
		//$query = OrderProductQuery::create()
		//->cou

//		select only visible products that where sold - order status id - from order_product grouped by product_ref desc
//      product 

		/** @var \Thelia\Model\ProductQuery $query */
		$query = parent::buildModelCriteria();
		
		$productOrderJoin = new Join();
		$productOrderJoin->addExplicitCondition(ProductTableMap::TABLE_NAME,'REF',null, OrderProductTableMap::TABLE_NAME,'PRODUCT_REF','po');
		$productOrderJoin->setJoinType(Criteria::LEFT_JOIN);
		
		$query->addJoinObject($productOrderJoin,'ProductInOrder')
		->withColumn('SUM(`po`.quantity)','TOTAL_PRODUCT')
->clearOrderByColumns()
		//->groupBy('REF')
		->orderBy('TOTAL_PRODUCT',Criteria::DESC)
		//->where('SUM(`po`.quantity)', Criteria::ISNOTNULL)
		;
		
		return $query;
	}

}