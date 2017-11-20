<?php
namespace FilterConfigurator\Loop;

use Thelia\Core\Template\Element\BaseLoop;
use Thelia\Core\Template\Element\LoopResult;
use Thelia\Core\Template\Element\LoopResultRow;
use Thelia\Core\Template\Loop\Argument\ArgumentCollection;
use Thelia\Core\Template\Element\ArraySearchLoopInterface;
use Thelia\Core\Template\Loop\Argument\Argument;
use FilterConfigurator\Model\ConfiguratorFeaturesQuery;

class FilterConfiguratorRelation extends BaseLoop implements ArraySearchLoopInterface
{
	protected function getArgDefinitions()
	{
		return new ArgumentCollection(
				Argument::createIntTypeArgument("feature_id"),
				Argument::createAnyTypeArgument("configurator_id")
				);
	}
	
	public function buildArray()
	{
		$configurator = array();
	
		$search = ConfiguratorFeaturesQuery::create()
			->filterByConfiguratorId($this->getConfiguratorId())
			->filterByFeatureId($this->getFeatureId())
			->findOne();

		if($search)
			$configurator[0]["relation"] = $search->getId();
	 	else
	 		$configurator[0]["relation"] = '';
	 	
		return $configurator;
	}
	
	/**
	 * @param LoopResult $loopResult
	 *
	 * @return LoopResult
	 */
	public function parseResults(LoopResult $loopResult)
	{
		foreach ($loopResult->getResultDataCollection() as $configurator) {
		
			$row = new LoopResultRow();
			
			$row->set("RELATION", $configurator["relation"]);
			
			$loopResult->addRow($row);
		}
		return $loopResult;
	}
}
