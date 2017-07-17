<?php

namespace MultipleFullfilmentCenters\Loop;

use MultipleFullfilmentCenters\Handler\LocationStockHandler;
use Thelia\Core\Template\Element\LoopResultRow;
use Thelia\Core\Template\Element\PropelSearchLoopInterface;
use Thelia\Core\Template\Element\BaseLoop;
use Thelia\Core\Template\Element\LoopResult;
use Thelia\Core\Template\Loop\Argument\ArgumentCollection;

use Thelia\Core\Template\Element\ArraySearchLoopInterface;
use Thelia\Core\Template\Loop\Argument\Argument;

class ProductStockFulfilmentCenter extends BaseLoop implements ArraySearchLoopInterface
{
	protected function getArgDefinitions()
	{
		return new ArgumentCollection(
				Argument::createIntTypeArgument("product_id")
				);
	}
	
	public function buildArray()
	{
		//$productId = $this->getProductId();
		$productId = $_GET['product_id'];
		
		$handler = new LocationStockHandler();
		$stockLocation = $handler->getStockLocationsForProduct($productId);
		return $stockLocation;
	}	
	
	/**
	 * @param LoopResult $loopResult
	 *
	 * @return LoopResult
	 */
	public function parseResults(LoopResult $loopResult)
	{
		foreach ($loopResult->getResultDataCollection() as $stockProductFulfilmentCenter) {
			$row = new LoopResultRow();
			$row
			->set("ID", $stockProductFulfilmentCenter['id'])
			->set("CENTERID", $stockProductFulfilmentCenter['fulfilmentCenterId'])
			->set("CENTERNAME",$stockProductFulfilmentCenter['fulfilmentCenterName'])
			->set("PRODUCTID", $stockProductFulfilmentCenter['productId'])
			->set("PRODUCTSTOCK", $stockProductFulfilmentCenter['productStock'])
			->set("INCOMINGSTOCK",$stockProductFulfilmentCenter['incomingStock'])
			->set("OUTGOINGSTOCK", $stockProductFulfilmentCenter['outgoingStock']);
			$loopResult->addRow($row);
		}
		return $loopResult;
	}
}
