<?php


namespace AmazonIntegration\Loop;


use Thelia\Core\Template\Element\LoopResultRow;
use Thelia\Core\Template\Element\PropelSearchLoopInterface;
use Thelia\Core\Template\Element\BaseLoop;
use Thelia\Core\Template\Element\LoopResult;
use Thelia\Core\Template\Loop\Argument\ArgumentCollection;
use AmazonIntegration\Model\ProductAmazonQuery;

class AmazonRankings extends BaseLoop implements PropelSearchLoopInterface
{
	protected function getArgDefinitions()
	{
		return new ArgumentCollection();
	}
	
	public function buildModelCriteria()
	{
		return ProductAmazonQuery::create();
	}
		
	/**
	 * @param LoopResult $loopResult
	 *
	 * @return LoopResult
	 */
	public function parseResults(LoopResult $loopResult)
	{
		foreach ($loopResult->getResultDataCollection() as $product) {
			$row = new LoopResultRow($product);
			$row
			->set("PRODUCT_ID", $product->getProductId())
			->set("REF", $product->getRef())
			->set("ASIN", $product->getAsin())
			->set("RANKING", $product->getRanking())
			->set("LOWEST_PRICE",$product->getLowestPrice())
			->set("LIST_PRICE",$product->getListPrice())
			->set("CATEGORY", $product->getAmazonCategoryId());
			$loopResult->addRow($row);
		}
		
		return $loopResult;
	}
}
