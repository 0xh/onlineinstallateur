<?php


namespace MultipleFullfilmentCenters\Loop;

use MultipleFullfilmentCenters\Model\FulfilmentCenterQuery;
use Thelia\Core\Template\Element\LoopResultRow;
use Thelia\Core\Template\Element\PropelSearchLoopInterface;
use Thelia\Core\Template\Element\BaseLoop;
use Thelia\Core\Template\Element\LoopResult;
use MultipleFullfilmentCenters\Model\FulfilmentCenter as FulfilmentCenterModel;
use Thelia\Core\Template\Loop\Argument\ArgumentCollection;

class FulfilmentCenter extends BaseLoop implements PropelSearchLoopInterface
{
	protected function getArgDefinitions()
	{
		return new ArgumentCollection();
	}
	
	
	public function buildModelCriteria()
	{
		return FulfilmentCenterQuery::create();
	}
	
	
	/**
	 * @param LoopResult $loopResult
	 *
	 * @return LoopResult
	 */
	public function parseResults(LoopResult $loopResult)
	{
		/** @var FulfilmentCenterModel $fulfilmentCenter */
		foreach ($loopResult->getResultDataCollection() as $fulfilmentCenter) {
			$row = new LoopResultRow($fulfilmentCenter);
			$row
			->set("ID", $fulfilmentCenter->getId())
			->set("NAME", $fulfilmentCenter->getName())
			->set("ADDRESS", $fulfilmentCenter->getAddress())
			->set("delivery_cost", $fulfilmentCenter->getDeliveryCost())
			->set("delivery_method", $fulfilmentCenter->getDeliveryMethod())
			->set("GPSLAT", (float)$fulfilmentCenter->getGpsLat())
			->set("GPSLONG", (float)$fulfilmentCenter->getGpsLong())
			->set("STOCKLIMIT", $fulfilmentCenter->getStockLimit());
			$loopResult->addRow($row);
		}
		return $loopResult;
	}
}
