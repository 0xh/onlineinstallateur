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

/**
 * Class CrawlerProductloop
 * @package HookAdminCrawlerDashboard\Loop
 * @author emanuel plopu <emanuel.plopu>
 */
class CrawlerProductLoop extends Product
{
	
	
	/**
	 * @inheritdoc
	 */
	protected function getArgDefinitions()
	{
		return new ArgumentCollection(
				Argument::createBooleanTypeArgument('active'),
				Argument::createBooleanTypeArgument('action_required')
				);
	}
	
	/**
	 * @param LoopResult $loopResult
	 *
	 * @return LoopResult
	 */
	public function parseResults(LoopResult $loopResult)
	{
		/** @var \HookAdminCrawlerDashboard/Model/CrawlerProductBase $product_base */
		foreach ($loopResult->getResultDataCollection() as $product_base) {
			$loopResultRow = new LoopResultRow($product_base);

			
			$loopResultRow
			->set('active', "true")

			;
			
			$loopResult->addRow($loopResultRow);
		}
		
		return $loopResult;
	}
	
	/**
	 * this method returns a Propel ModelCriteria
	 *
	 * @return \Propel\Runtime\ActiveQuery\ModelCriteria
	 */
	/*
	public function buildModelCriteria()
	{
		$search = CarouselQuery::create();
		
		$this->configureI18nProcessing($search, [ 'ALT', 'TITLE', 'CHAPO', 'DESCRIPTION', 'POSTSCRIPTUM' ]);
		
		$orders  = $this->getOrder();
		
		// Results ordering
		foreach ($orders as $order) {
			switch ($order) {
				case "alpha":
					$search->addAscendingOrderByColumn('i18n_TITLE');
					break;
				case "alpha-reverse":
					$search->addDescendingOrderByColumn('i18n_TITLE');
					break;
				case "manual-reverse":
					$search->orderByPosition(Criteria::DESC);
					break;
				case "manual":
					$search->orderByPosition(Criteria::ASC);
					break;
				case "random":
					$search->clearOrderByColumns();
					$search->addAscendingOrderByColumn('RAND()');
					break(2);
					break;
			}
		}
		
		return $search;
	}*/
}
