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
use HookAdminCrawlerDashboard\Model\Map\CrawlerProductListingTableMap;

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
					Argument::createBooleanTypeArgument('action_required'),
					Argument::createAnyTypeArgument('platform'),
					Argument::createAnyTypeArgument('position')
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
		$platform = $this->getPlatform();
		$position = $this->getPosition();
		
		$crawlerProductBaseJoin = new Join();
		$crawlerProductBaseJoin->addExplicitCondition(ProductTableMap::TABLE_NAME, 'ID', null, CrawlerProductBaseTableMap::TABLE_NAME, 'PRODUCT_ID','cpb');
		$crawlerProductBaseJoin->setJoinType(Criteria::LEFT_JOIN);
		$query
		->addJoinObject($crawlerProductBaseJoin,'CrawlerProductBase')
		->withColumn ( '`cpb`.active', 'crawler_active' )
		->withColumn ( '`cpb`.action_required', 'crawler_action_required')
		->withColumn ('`cpb`.id', 'product_base_id');
		
		if($platform) {
			$query->addJoin('`cpb`.id', CrawlerProductListingTableMap::PRODUCT_BASE_ID, Criteria::JOIN)
				->withColumn('crawler_product_listing.hf_position', 'hf_position' )
				->where('crawler_product_listing.platform =?', $platform, \PDO::PARAM_BOOL);
			$query->clearOrderByColumns();
			$query->orderBy('hf_position',$position);
		}
		
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
		$productBaseIdArray = array();
		
		//save virtualcolumns to id based array
		/** @var \Thelia\Model\Product $product */
		foreach ($loopResults->getResultDataCollection() as $product) {
			//Tlog::getInstance()->error("gotsomeproducts ".$product->getId()." b ".$product->getVirtualColumn('crawler_active'));
			$productId = $product->getId();
			$activeArray[$productId] = $product->getVirtualColumn('crawler_active');
			$actionRequiredArray[$productId] = $product->getVirtualColumn('crawler_action_required');
			$productBaseIdArray[$productId] = $product->getVirtualColumn('product_base_id');
		}
		
		//set result variables from saved array
		/** @var \Thelia\Core\Template\Element\LoopResultRow $loopResultRow */
		foreach ($results as $loopResultRow) {			
			$productId = $loopResultRow->get('ID');
			//Tlog::getInstance()->error("gotsomeproducts ".$loopResultRow->get('ID')." b ".$activeArray[$productBaseId]);
			$loopResultRow
			->set("CRAWLER_ACTIVE",$activeArray[$productId])
			->set("PRODUCT_ID",$productId)
			->set("CRAWLER_ID", $productBaseIdArray[$productId])
			->set("CRAWLER_ACTION_REQUIRED",$actionRequiredArray[$productId]);
		}
		return $results;
	}
}
