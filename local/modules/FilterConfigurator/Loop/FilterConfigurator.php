<?php
namespace FilterConfigurator\Loop;

use Thelia\Core\Template\Element\BaseLoop;
use Thelia\Core\Template\Element\LoopResult;
use Thelia\Core\Template\Element\LoopResultRow;
use Thelia\Core\Template\Loop\Argument\ArgumentCollection;
use Thelia\Core\Template\Element\ArraySearchLoopInterface;
use Thelia\Core\Template\Loop\Argument\Argument;
use FilterConfigurator\Model\FilterConfiguratorI18nQuery;
use FilterConfigurator\Model\FilterConfiguratorQuery;

class FilterConfigurator extends BaseLoop implements ArraySearchLoopInterface
{
	protected function getArgDefinitions()
	{
		return new ArgumentCollection(
				Argument::createIntTypeArgument("id"),
				Argument::createAnyTypeArgument("locale")
				);
	}
	
	public function buildArray()
	{
		$configurator = array();
	
		$search = FilterConfiguratorI18nQuery::create()
			->filterById($this->getId())
			->filterByLocale($this->getLocale())
			->findOneOrCreate();
        
	 	$configurator[0]["id"] = $search->getId();
	 	$configurator[0]["title"] = $search->getTitle();
	 	$configurator[0]["decription"] = $search->getDescription();
	 	$configurator[0]["chapo"] = $search->getChapo();
	 	
	 	$search2 = FilterConfiguratorQuery::create()
	 	     ->filterbyId($this->getId())
	 	     ->findOneOrCreate();
	 	
	 	$search2->getCategoryId();

	 	$configurator[0]["category"] = $search2->getCategoryId();
	 
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
			
			$row->set("ID", $configurator["id"])
				->set("TITLE", $configurator["title"])
				->set("CHAPO", $configurator["chapo"])
				->set("DESCRIPTION", $configurator["decription"])
				->set("POSITION",$configurator["position"])
				->set("CATEGORY",$configurator["category"]);
			
			$loopResult->addRow($row);
		}
		return $loopResult;
	}
}
