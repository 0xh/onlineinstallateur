<?php
namespace OfferCreation\Loop;


use Thelia\Core\Template\Element\LoopResultRow;
use Thelia\Core\Template\Element\BaseLoop;
use Thelia\Core\Template\Element\LoopResult;
use Thelia\Core\Template\Loop\Argument\ArgumentCollection;
use Thelia\Core\Template\Loop\Argument\Argument;
use OfferCreation\Model\OfferProductQuery;
use Thelia\Core\Template\Element\ArraySearchLoopInterface;

class OfferAmount extends BaseLoop  implements ArraySearchLoopInterface
{
	protected function getArgDefinitions()
	{
		return new ArgumentCollection(
				Argument::createIntTypeArgument("id")
				);
	}
	
	
	public function buildArray()
	{ 
		$productPrice = OfferProductQuery::create()
			->select('price')
			->filterByOfferId($this->getId());
			
		$total = 0;
		foreach ($productPrice as  $value) {
			$total+= $value;
		}
		
		$amount[] = $total;
		return $amount;
	}
	
	
	
	/**
	 * @param LoopResult $loopResult
	 *
	 * @return LoopResult
	 */
	public function parseResults(LoopResult $loopResult)
	{
		//print_r($loopResult);
		/** @var  */
		foreach ($loopResult->getResultDataCollection() as $offer) {
			$row = new LoopResultRow($offer);
		
			$row->set("OFFER_AMOUNT", $offer);
			
			$loopResult->addRow($row);
		}
		return $loopResult;
	}
}
