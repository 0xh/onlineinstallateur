<?php

namespace MultipleFullfilmentCenters\Loop;

use MultipleFullfilmentCenters\Handler\LocationStockHandler;
use Thelia\Core\Template\Element\LoopResultRow;
use Thelia\Core\Template\Element\BaseLoop;
use Thelia\Core\Template\Element\LoopResult;
use Thelia\Core\Template\Loop\Argument\ArgumentCollection;

use Thelia\Core\Template\Element\ArraySearchLoopInterface;
use Thelia\Core\Template\Loop\Argument\Argument;

class OrderPlacedPickUpAddress extends BaseLoop implements ArraySearchLoopInterface
{
	protected function getArgDefinitions()
	{
		return new ArgumentCollection(
				Argument::createIntTypeArgument("orderid")
				);
	}
	
	public function buildArray()
	{
		$locale =$this->getCurrentRequest()->getSession()->getLang()->getLocale();
		
		$handler = new LocationStockHandler();
		$pickUpAddress = $handler->getPickUpAddress($this->getOrderid(), $locale);
		return $pickUpAddress;
	}
	
	/**
	 * @param LoopResult $loopResult
	 *
	 * @return LoopResult
	 */
	public function parseResults(LoopResult $loopResult)
	{
		foreach ($loopResult->getResultDataCollection() as $pickUpAddress) {
			$row = new LoopResultRow();
			$row->set("CENTER_ADDRESS",$pickUpAddress['fulfilmentCenterAddress'])
				->set("PRODUCT_TITLE", $pickUpAddress['productTitle']);
			$loopResult->addRow($row);
		}
		return $loopResult;
	}
}
