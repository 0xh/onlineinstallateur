<?php

namespace OfferCreation\Model;

use OfferCreation\Model\Base\Offer as BaseOffer;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\Connection\ConnectionInterface;
use Thelia\Model\Tools\ModelEventDispatcherTrait;
use Thelia\Log\Tlog;

use OfferCreation\Model\Map\OfferProductTaxTableMap;
use Thelia\Model\OrderStatusQuery;
use Thelia\Model\OrderStatus;


class Offer extends BaseOffer
{
		use ModelEventDispatcherTrait;
		
		/** @var int|null  */
		protected $choosenDeliveryAddress = null;
		/** @var int|null  */
		protected $choosenInvoiceAddress = null;
		
		protected $disableVersioning = false;
		
		/**
		 * @param int $choosenDeliveryAddress the choosen delivery address ID
		 * @return $this
		 */
		public function setChoosenDeliveryAddress($choosenDeliveryAddress)
		{
			$this->choosenDeliveryAddress = $choosenDeliveryAddress;
			
			return $this;
		}
		
		/**
		 * @param boolean $disableVersioning
		 * @return $this
		 */
		public function setDisableVersioning($disableVersioning)
		{
			$this->disableVersioning = (bool) $disableVersioning;
			
			return $this;
		}
		
		public function isVersioningDisable()
		{
			return $this->disableVersioning;
		}
		
		public function isVersioningNecessary($con = null)
		{
			if ($this->isVersioningDisable()) {
				return false;
			} else {
				return parent::isVersioningNecessary($con);
			}
		}
		
		/**
		 * @return int|null the choosen delivery address ID
		 */
		public function getChoosenDeliveryAddress()
		{
			return $this->choosenDeliveryAddress;
		}
		
		/**
		 * @param int  $choosenInvoiceAddress the choosen invoice address
		 * @return $this
		 */
		public function setChoosenInvoiceAddress($choosenInvoiceAddress)
		{
			$this->choosenInvoiceAddress = $choosenInvoiceAddress;
			
			return $this;
		}
		
		/**
		 * @return int|null the choosen invoice address ID
		 */
		public function getChoosenInvoiceAddress()
		{
			return $this->choosenInvoiceAddress;
		}
		
		public function preSave(ConnectionInterface $con = null)
		{
		 	if (null === $this->getInvoiceDate()) {
				$this
				->setInvoiceDate(time());
			}
			 
			return parent::preSave($con);
		}
		
		/**
		 * {@inheritDoc}
		 */
		public function preInsert(ConnectionInterface $con = null)
		{
			//$this->dispatchEvent(TheliaEvents::ORDER_BEFORE_CREATE, new OrderEvent($this));
			
			return true;
		}
		
		/**
		 * {@inheritDoc}
		 */
		public function postInsert(ConnectionInterface $con = null)
		{
			$this->setRef($this->generateRef())
			->setDisableVersioning(true)
			->save($con);
		}
		
		public function generateRef()
		{
			return sprintf('OFR%s', str_pad($this->getId(), 12, 0, STR_PAD_LEFT));
		}
		
		/**
		 * Compute this order amount.
		 *
		 * The order amount is only available once the order is persisted in database.
		 * During invoice process, use all cart methods instead of order methods (the order doest not exists at this moment)
		 *
		 * @param  float|int $tax             (output only) returns the tax amount for this order
		 * @param  bool      $includePostage  if true, the postage cost is included to the total
		 * @param  bool      $includeDiscount if true, the discount will be included to the total
		 * @return float
		 */
		public function getTotalAmount(&$tax = 0, $includePostage = true, $includeDiscount = true)
		{
			$amount = 0;
			$tax = 0;
			
			/* browse all products */
			foreach ($this->getOfferProducts() as $orderProduct) {
				$taxAmountQuery = OfferProductTaxQuery::create();
				
				if ($orderProduct->getWasInPromo() == 1) {
					$taxAmountQuery->withColumn('SUM(' . OfferProductTaxTableMap::PROMO_AMOUNT . ')', 'total_tax');
				} else {
					$taxAmountQuery->withColumn('SUM(' . OfferProductTaxTableMap::AMOUNT . ')', 'total_tax');
				}
				
				$taxAmount = $taxAmountQuery->filterByOfferProductId($orderProduct->getId(), Criteria::EQUAL)
				->findOne();
				$price = ($orderProduct->getWasInPromo() == 1 ? $orderProduct->getPromoPrice() : $orderProduct->getPrice());
				$amount += round($price ,2)* $orderProduct->getQuantity();
				$tax += round($taxAmount->getVirtualColumn('total_tax') ,2)* $orderProduct->getQuantity();
			}
			
			$total = $amount + $tax;
			Tlog::getInstance()->error("totalamount ".$total);
			// @todo : manage discount : free postage ?
			if (true === $includeDiscount) {
				$total -= $this->getDiscount();
				
				if ($total<0) {
					$total = 0;
				} else {
					$total = round($total, 2);
				}
			}
			
			if (false !== $includePostage) {
				$total += $this->getPostage();
				$tax += $this->getPostageTax();
			}
			
			return $total;
		}
		
		/**
		 * Compute this order weight.
		 *
		 * The order weight is only available once the order is persisted in database.
		 * During invoice process, use all cart methods instead of order methods (the order doest not exists at this moment)
		 *
		 * @return float
		 */
		public function getWeight()
		{
			$weight = 0;
			
			/* browse all products */
			foreach ($this->getOfferProducts() as $orderProduct) {
				$weight += $orderProduct->getQuantity() * (double)$orderProduct->getWeight();
			}
			
			return $weight;
		}
		
		/**
		 * Return the postage without tax
		 * @return float|int
		 */
		public function getUntaxedPostage()
		{
			if (0 < $this->getPostageTax()) {
				$untaxedPostage =  round($this->getPostage() - $this->getPostageTax(), 2);
			} else {
				$untaxedPostage = $this->getPostage();
			}
			
			return $untaxedPostage;
		}
		
		/**
		 * Check if the current order contains at less 1 virtual product with a file to download
		 *
		 * @return bool true if this order have at less 1 file to download, false otherwise.
		 */
		public function hasVirtualProduct()
		{
			$virtualProductCount = OfferProductQuery::create()
			->filterByOfferId($this->getId())
			->filterByVirtual(1, Criteria::EQUAL)
			->count()
			;
			
			return ($virtualProductCount !== 0);
		}
		
	
	}
	
