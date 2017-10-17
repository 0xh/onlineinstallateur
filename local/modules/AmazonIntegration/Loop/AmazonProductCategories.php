<?php

namespace AmazonIntegration\Loop;

use AmazonIntegration\Handler\AmazonProductCategoryHandler;
use Thelia\Core\Template\Element\LoopResultRow;
use Thelia\Core\Template\Element\BaseLoop;
use Thelia\Core\Template\Element\LoopResult;
use Thelia\Core\Template\Loop\Argument\ArgumentCollection;

use Thelia\Core\Template\Element\ArraySearchLoopInterface;
use Thelia\Core\Template\Loop\Argument\Argument;


class AmazonProductCategories extends BaseLoop implements ArraySearchLoopInterface
{
	protected function getArgDefinitions()
	{
		return new ArgumentCollection(
				Argument::createAnyTypeArgument("category")
				);
	}
	
	public function buildArray()
	{
		$handler = new AmazonProductCategoryHandler();
		$categories[] = $handler->getProductCategories($this->getCategory());
		
		return $categories;
	}
	
	/**
	 * @param LoopResult $loopResult
	 *
	 * @return LoopResult
	 */
	public function parseResults(LoopResult $loopResult)
	{
		foreach ($loopResult->getResultDataCollection() as $categoryHierarchy) {
			$row = new LoopResultRow();
			
			$row->set("ID",$categoryHierarchy);
			$loopResult->addRow($row);
		} 
		
		return $loopResult;
	}
}
