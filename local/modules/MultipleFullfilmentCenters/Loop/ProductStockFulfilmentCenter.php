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
				Argument::createIntTypeArgument("id"),
				Argument::createIntTypeArgument("quantity")
				);
	}
	
	public function buildArray()
	{
	 	if($_GET['product_id']) {
			$productId = $_GET['product_id'];
		}
		else {
			$productId = $this->getId();
		} 
		
		if($this->getQuantity()) 
			$quantityCart = $this->getQuantity();
		else 
			// set quantity cart to 1, so LocationStockHandler->getStockLocationsForProduct should retrieve only the locations with stock available
			$quantityCart = '1';
		
		$handler = new LocationStockHandler();
		$stockLocation = $handler->getStockLocationsForProduct($productId, $quantityCart);
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
