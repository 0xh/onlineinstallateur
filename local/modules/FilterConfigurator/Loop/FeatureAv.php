<?php


namespace FilterConfigurator\Loop;


use Thelia\Core\Template\Element\LoopResultRow;
use Thelia\Core\Template\Element\PropelSearchLoopInterface;
use Thelia\Core\Template\Element\BaseLoop;
use Thelia\Core\Template\Element\LoopResult;
use Thelia\Core\Template\Loop\Argument\ArgumentCollection;
use Thelia\Core\Template\Loop\Argument\Argument;
use Thelia\Model\FeatureAvI18nQuery;

class FeatureAv extends BaseLoop implements PropelSearchLoopInterface
{
	protected function getArgDefinitions()
	{
		return new ArgumentCollection(
				Argument::createIntTypeArgument('feature_av_id'),
				Argument::createAnyTypeArgument('locale')
				);
	}
	
	
	public function buildModelCriteria()
	{
		$feature_av_id = $this->getFeatureAvId();
		$locale = $this->getLocale();
		
		$search = FeatureAvI18nQuery::create()
			->filterByLocale($locale)
			->filterById($feature_av_id);
		
		return $search;
	}

	/**
	 * @param LoopResult $loopResult
	 *
	 * @return LoopResult
	 */
	public function parseResults(LoopResult $loopResult)
	{ 
		$loopResultRow= new LoopResultRow();
		
		if($loopResult->getResultDataCollection()->getData()) {
			foreach ($loopResult->getResultDataCollection() as $featureAv) {
				
				$loopResultRow
					->set("ID", $featureAv->getId())
					->set("FEATURE_AV_TITLE", $featureAv->getTitle())
					->set("FEATURE_AV_DESC", $featureAv->getDescription())
					->set("FEATURE_AV_CHAPO", $featureAv->getChapo())
					->set("FEATURE_AV_POSTSCRIPTUM", $featureAv->getPostscriptum());
			}
		}
	 	else {
	 		$loopResultRow
	 			->set("ID", $this->getFeatureAvId())
		 		->set("FEATURE_AV_TITLE", '')
		 		->set("FEATURE_AV_DESC", '')
		 		->set("FEATURE_AV_CHAPO",'')
		 		->set("FEATURE_AV_POSTSCRIPTUM", '');
		} 
		
		$loopResult->addRow($loopResultRow);
		
		return $loopResult;
	}
}
