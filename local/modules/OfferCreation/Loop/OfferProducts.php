<?php
/*************************************************************************************/
/*      This file is part of the Thelia package.                                     */
/*                                                                                   */
/*      Copyright (c) OpenStudio                                                     */
/*      email : dev@thelia.net                                                       */
/*      web : http://www.thelia.net                                                  */
/*                                                                                   */
/*      For the full copyright and license information, please view the LICENSE.txt  */
/*      file that was distributed with this source code.                             */
/*************************************************************************************/

namespace OfferCreation\Loop;

use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\Join;
use Thelia\Core\Template\Element\BaseLoop;
use Thelia\Core\Template\Element\LoopResult;
use Thelia\Core\Template\Element\LoopResultRow;
use Thelia\Core\Template\Element\PropelSearchLoopInterface;
use Thelia\Core\Template\Loop\Argument\ArgumentCollection;
use Thelia\Core\Template\Loop\Argument\Argument;
use Thelia\Model\Map\ProductSaleElementsTableMap;
use Thelia\Type\BooleanOrBothType;
use OfferCreation\Model\OfferProductQuery;
use OfferCreation\Model\Map\OfferProductTableMap;

/**
 *
 * OrderProduct loop
 *
 * Class OrderProduct
 * @package Thelia\Core\Template\Loop
 * @author Etienne Roudeix <eroudeix@openstudio.fr>
 *
 * {@inheritdoc}
 * @method int getOrder()
 * @method int[] getId()
 * @method bool|string getVirtual()
 */
class OfferProducts extends BaseLoop implements PropelSearchLoopInterface
{
	protected $timestampable = true;
	
	/**
	 * @return ArgumentCollection
	 */
	protected function getArgDefinitions()
	{
		return new ArgumentCollection(
				Argument::createIntTypeArgument('offer', null, true),
				Argument::createIntListTypeArgument('id'),
				Argument::createBooleanOrBothTypeArgument('virtual', BooleanOrBothType::ANY)
				);
	}
	
	public function buildModelCriteria()
	{
		$search = OfferProductQuery::create();
		
		$search->joinOfferProductTax('opt', Criteria::LEFT_JOIN)
		->withColumn('SUM(`opt`.AMOUNT)', 'TOTAL_TAX')
		->withColumn('SUM(`opt`.PROMO_AMOUNT)', 'TOTAL_PROMO_TAX')
		->groupById();
		
		
		// new join to get the product id if it exists
		$pseJoin = new Join(
				OfferProductTableMap::PRODUCT_SALE_ELEMENTS_ID,
				ProductSaleElementsTableMap::ID,
				Criteria::LEFT_JOIN
				);
		$search
		->addJoinObject($pseJoin)
		->addAsColumn(
				"product_id",
				ProductSaleElementsTableMap::PRODUCT_ID
				)
				;
		
		$offer = $this->getOffer();
		
		$search->filterByOfferId($offer, Criteria::EQUAL);
		
		$virtual = $this->getVirtual();
		if ($virtual !== BooleanOrBothType::ANY) {
			if ($virtual) {
				$search
				->filterByVirtual(1, Criteria::EQUAL)
				->filterByVirtualDocument(null, Criteria::NOT_EQUAL);
			} else {
				$search
				->filterByVirtual(0);
			}
		}
		
		if (null !== $this->getId()) {
			$search->filterById($this->getId(), Criteria::IN);
		}
		
		$search->orderById(Criteria::ASC);
		
		return $search;
	}
	
	public function parseResults(LoopResult $loopResult)
	{
		/** @var OfferCreation\Model\OfferProducts $offerProduct */
		foreach ($loopResult->getResultDataCollection() as $offerProduct) {
			$loopResultRow = new LoopResultRow($offerProduct);
			
			$taxedPrice = $offerProduct->getPrice() + $offerProduct->getVirtualColumn('TOTAL_TAX');
			$taxedPromoPrice = $offerProduct->getPromoPrice() + $offerProduct->getVirtualColumn('TOTAL_PROMO_TAX');
			
			$totalPrice = $offerProduct->getPrice()*$offerProduct->getQuantity();
			$totalPromoPrice = $offerProduct->getPromoPrice()*$offerProduct->getQuantity();
			
			$loopResultRow->set("ID", $offerProduct->getId())
			->set("REF", $offerProduct->getProductRef())
			->set("PRODUCT_ID", $offerProduct->getVirtualColumn('product_id'))
			->set("PRODUCT_SALE_ELEMENTS_ID", $offerProduct->getProductSaleElementsId())
			->set("PRODUCT_SALE_ELEMENTS_REF", $offerProduct->getProductSaleElementsRef())
			->set("WAS_NEW", $offerProduct->getWasNew() === 1 ? 1 : 0)
			->set("WAS_IN_PROMO", $offerProduct->getWasInPromo() === 1 ? 1 : 0)
			->set("WEIGHT", $offerProduct->getWeight())
			->set("TITLE", $offerProduct->getTitle())
			->set("CHAPO", $offerProduct->getChapo())
			->set("DESCRIPTION", $offerProduct->getDescription())
			->set("POSTSCRIPTUM", $offerProduct->getPostscriptum())
			->set("VIRTUAL", $offerProduct->getVirtual())
			->set("VIRTUAL_DOCUMENT", $offerProduct->getVirtualDocument())
			->set("QUANTITY", $offerProduct->getQuantity())
			->set("PRICE", $offerProduct->getPrice())
			->set("PRICE_TAX", $offerProduct->getVirtualColumn('TOTAL_TAX'))
			->set("TAXED_PRICE", $taxedPrice)
			->set("PROMO_PRICE", $offerProduct->getPromoPrice())
			->set("PROMO_PRICE_TAX", $offerProduct->getVirtualColumn('TOTAL_PROMO_TAX'))
			->set("TAXED_PROMO_PRICE", $taxedPromoPrice)
			->set("TOTAL_PRICE", $totalPrice)
			->set("TOTAL_TAXED_PRICE", $totalPrice + ($offerProduct->getVirtualColumn('TOTAL_TAX')*$offerProduct->getQuantity()))
			->set("TOTAL_PROMO_PRICE", $totalPromoPrice)
			->set("TOTAL_TAXED_PROMO_PRICE", $totalPromoPrice + ($offerProduct->getVirtualColumn('TOTAL_PROMO_TAX')*$offerProduct->getQuantity()))
			->set("TAX_RULE_TITLE", $offerProduct->getTaxRuleTitle())
			->set("TAX_RULE_DESCRIPTION", $offerProduct->getTaxRuledescription())
			->set("PARENT", $offerProduct->getParent())
			->set("EAN_CODE", $offerProduct->getEanCode())
			;
			$this->addOutputFields($loopResultRow, $offerProduct);
			
			$loopResult->addRow($loopResultRow);
		}
		
		return $loopResult;
	}
}
