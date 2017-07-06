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
use Thelia\Model\Map\OrderTableMap;

class BestsellerLoop extends Product implements PropelSearchLoopInterface{
	
	/**
	 * {@inheritDoc}
	 * @see \Thelia\Core\Template\Element\PropelSearchLoopInterface::buildModelCriteria()
	 */
	public function buildModelCriteria() {

		/** @var \Thelia\Model\ProductQuery $query */
		$query = parent::buildModelCriteria();
		
		$productOrderJoin = new Join();
		$productOrderJoin->addExplicitCondition(ProductTableMap::TABLE_NAME,'REF',null, OrderProductTableMap::TABLE_NAME,'PRODUCT_REF','po');
		$productOrderJoin->setJoinType(Criteria::LEFT_JOIN);
		
		$orderProductOrderJoin = new Join();
		$orderProductOrderJoin->addExplicitCondition('po','ORDER_ID',null, OrderTableMap::TABLE_NAME,'ID','opo');
		$orderProductOrderJoin->setJoinType(Criteria::LEFT_JOIN);

		$query
		->addJoinObject($productOrderJoin,'ProductInOrder')
		->withColumn('SUM(`po`.quantity)','TOTAL_PRODUCT')
		->addJoinObject($orderProductOrderJoin,'OrderStatus')
		->withColumn('`opo`.status_id','STATUS')
		
		->clearOrderByColumns()
		->orderBy('TOTAL_PRODUCT',Criteria::DESC)
		;
		
		return $query;
	}

}