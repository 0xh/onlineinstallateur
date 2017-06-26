<?php

namespace HookAdminCrawlerDashboard\Loop;

use Thelia\Core\Template\Loop\Argument\ArgumentCollection;
use Thelia\Core\Template\Loop\Argument\Argument;
use Thelia\Type\TypeCollection;
use Thelia\Type\EnumType;
use Thelia\Type\EnumListType;
use Thelia\Core\Template\Loop\Product;
use Thelia\Core\Template\Element\LoopResult;
use Thelia\Core\Template\Element\LoopResultRow;
use Thelia\Core\Template\Element\PropelSearchLoopInterface;
use Propel\Runtime\ActiveQuery\Join;
use Thelia\Model\Map\ProductTableMap;
use Propel\Runtime\ActiveQuery\Criteria;
use Thelia\Log\Tlog;
use HookAdminCrawlerDashboard\Model\Map\CrawlerProductBaseTableMap;

/**
 * Class CrawlerProductloop
 * @package HookAdminCrawlerDashboard\Loop
 * @author emanuel plopu <emanuel.plopu>
 */
class CrawlerProductLoop extends Product implements PropelSearchLoopInterface
{
	
	/**
	 * @inheritdoc
	 */
	protected function getArgDefinitions()
	{
		return parent::getArgDefinitions()->addArguments(
				[
					Argument::createBooleanTypeArgument('active'),
					Argument::createBooleanTypeArgument('action_required')
				]
				);
	}
	
	/**
	 * {@inheritDoc}
	 * @see \Thelia\Core\Template\Element\PropelSearchLoopInterface::buildModelCriteria()
	 */
	public function buildModelCriteria() {
		$query = parent::buildModelCriteria();
		
		//flag that signals if the crawler should process a product or not
		$active = $this->getActive();
		//flag that signals if a product requires some action from the backoffice user/should be presented in the dashboard
		$action_required = $this->getActionRequired();
		
		$crawlerProductBaseJoin = new Join();
		$crawlerProductBaseJoin->addExplicitCondition(ProductTableMap::TABLE_NAME, 'ID', null, CrawlerProductBaseTableMap::TABLE_NAME, 'PRODUCT_ID','cpb');
		$crawlerProductBaseJoin->setJoinType(Criteria::LEFT_JOIN);
		$query
		->addJoinObject($crawlerProductBaseJoin,'CrawlerProductBase')
		->withColumn ( '`cpb`.active', 'crawler_active' )
		->withColumn ( '`cpb`.action_required', 'crawler_action_required');
				
		if($active)
			$query->where('cpb.active =?', $active, \PDO::PARAM_BOOL);

		if($action_required)
			$query->where('cpb.action_required =?', $action_required, \PDO::PARAM_BOOL);
		
		return $query;
	}
	
	/**
	 * @param LoopResult $loopResult
	 *
	 * @return LoopResult
	 */
	public function parseResults(LoopResult $loopResults)
	{
		$results = parent::parseResults($loopResults);
		
		$activeArray = array();
		$actionRequiredArray = array();
		
		//save virtualcolumns to id based array
		/** @var \Thelia\Model\Product $product */
		foreach ($loopResults->getResultDataCollection() as $product) {
			//Tlog::getInstance()->error("gotsomeproducts ".$product->getId()." b ".$product->getVirtualColumn('crawler_active'));
			$productId = $product->getId();
			$activeArray[$productId] = $product->getVirtualColumn('crawler_active');
			$actionRequiredArray[$productId] = $product->getVirtualColumn('crawler_action_required');
		}
		
		//set result variables from saved array
		/** @var \Thelia\Core\Template\Element\LoopResultRow $loopResultRow */
		foreach ($results as $loopResultRow) {			
			$productBaseId = $loopResultRow->get('ID');
			//Tlog::getInstance()->error("gotsomeproducts ".$loopResultRow->get('ID')." b ".$activeArray[$productBaseId]);
			$loopResultRow
			->set("CRAWLER_ACTIVE",$activeArray[$productBaseId])
			->set("CRAWLER_ID",$productBaseId)
			->set("CRAWLER_ACTION_REQUIRED",$actionRequiredArray[$productBaseId]);
		}
		return $results;
	}
}
