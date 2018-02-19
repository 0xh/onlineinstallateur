<?php
namespace OfferCreation\Loop;

use OfferCreation\Model\OfferQuery;
use Thelia\Core\Template\Element\LoopResultRow;
use Thelia\Core\Template\Element\PropelSearchLoopInterface;
use Thelia\Core\Template\Element\BaseLoop;
use Thelia\Core\Template\Element\LoopResult;
use Thelia\Core\Template\Loop\Argument\ArgumentCollection;
use Thelia\Core\Template\Loop\Argument\Argument;
use Propel\Runtime\ActiveQuery\Criteria;
use Thelia\Core\Template\Element\SearchLoopInterface;
use Thelia\Type\TypeCollection;
use Thelia\Type;
use Thelia\Model\CustomerQuery;
use Thelia\Model\OrderAddressQuery;
use Thelia\Model\Map\OrderAddressTableMap;
use Thelia\Model\Map\CustomerTableMap;

class OfferDetail extends BaseLoop implements SearchLoopInterface, PropelSearchLoopInterface
{
	protected $countable = true;
	protected $timestampable = true;
	protected $versionable = false;
	
	protected function getArgDefinitions()
	{		
		return new ArgumentCollection(
				Argument::createIntListTypeArgument('id'),
				Argument::createBooleanTypeArgument('with_prev_next_info', false),
				new Argument(
						'customer',
						new TypeCollection(
								new Type\IntType(),
								new Type\EnumType(array('current', '*'))
								),
						'current'
						),
				new Argument(
						'status',
						new TypeCollection(
								new Type\IntListType(),
								new Type\EnumType(array('*'))
								)
						),
				Argument::createIntListTypeArgument('exclude_status'),
				new Argument(
						'status_code',
						new TypeCollection(
								new Type\AnyListType(),
								new Type\EnumType(array('*'))
								)
						),
				Argument::createAnyListTypeArgument('exclude_status_code'),
				new Argument(
						'order',
						new TypeCollection(
								new Type\EnumListType(
										array(
												'id', 'id-reverse',
												'reference', 'reference-reverse',
												'create-date', 'create-date-reverse',
												'company', 'company-reverse',
												'customer-name', 'customer-name-reverse',
												'status', 'status-reverse'
										)
										)
								),
						'create-date-reverse'
						)
				);
	}
	
	public function getSearchIn()
	{
		return array(
				'ref',
				'invoice_ref',
				'delivery_ref',
				'transaction_ref',
				'customer_ref',
				'customer_firstname',
				'customer_lastname',
				'customer_email',
		);
	}
	
	/**
	 * @param OfferQuery $search
	 * @param $searchTerm
	 * @param $searchIn
	 * @param $searchCriteria
	 */
	public function doSearch(&$search, $searchTerm, $searchIn, $searchCriteria)
	{
		$search->_and();
		foreach ($searchIn as $index => $searchInElement) {
			if ($index > 0) {
				$search->_or();
			}
			switch ($searchInElement) {
				case 'ref':
					$search->filterByRef($searchTerm, $searchCriteria);
					break;
				case 'invoice_ref':
					$search->filterByInvoiceRef($searchTerm, $searchCriteria);
					break;
				case 'delivery_ref':
					$search->filterByDeliveryRef($searchTerm, $searchCriteria);
					break;
				case 'transaction_ref':
					$search->filterByTransactionRef($searchTerm, $searchCriteria);
					break;
				case 'customer_ref':
					$search->filterByCustomer(
					CustomerQuery::create()->filterByRef($searchTerm, $searchCriteria)->find()
					);
					break;
				case 'customer_firstname':
					$search->filterByOrderAddressRelatedByInvoiceOrderAddressId(
					OrderAddressQuery::create()->filterByFirstname($searchTerm, $searchCriteria)->find()
					);
					break;
				case 'customer_lastname':
					$search->filterByOrderAddressRelatedByInvoiceOrderAddressId(
					OrderAddressQuery::create()->filterByLastname($searchTerm, $searchCriteria)->find()
					);
					break;
				case 'customer_email':
					$search->filterByCustomer(
					CustomerQuery::create()->filterByEmail($searchTerm, $searchCriteria)->find()
					);
					break;
			}
		}
	}
	
	public function buildModelCriteria()
	{
		$search = OfferQuery::create();
		
		$id = $this->getId();
		
		if (null !== $id) {
			$search->filterById($id, Criteria::IN);
		}
		
		$orderers = $this->getOrder();
		
		foreach ($orderers as $orderer) {
			switch ($orderer) {
				case 'id':
					$search->orderById(Criteria::ASC);
					break;
				case 'id-reverse':
					$search->orderById(Criteria::DESC);
					break;
				case 'reference':
					$search->orderByRef(Criteria::ASC);
					break;
				case 'reference-reverse':
					$search->orderByRef(Criteria::DESC);
					break;
				case 'create-date':
					$search->orderByCreatedAt(Criteria::ASC);
					break;
				case 'create-date-reverse':
					$search->orderByCreatedAt(Criteria::DESC);
					break;
				case 'status':
					$search->orderByStatusId(Criteria::ASC);
					break;
				case 'status-reverse':
					$search->orderByStatusId(Criteria::DESC);
					break;
				case 'company':
					$search
					->joinOrderAddressRelatedByDeliveryOrderAddressId()
					->withColumn(OrderAddressTableMap::COMPANY, 'company')
					->orderBy('company', Criteria::ASC);
					break;
				case 'company-reverse':
					$search
					->joinOrderAddressRelatedByDeliveryOrderAddressId()
					->withColumn(OrderAddressTableMap::COMPANY, 'company')
					->orderBy('company', Criteria::DESC);
					break;
				case 'customer-name':
					$search
					->joinCustomer()
					->withColumn(CustomerTableMap::FIRSTNAME, 'firstname')
					->withColumn(CustomerTableMap::LASTNAME, 'lastname')
					->orderBy('lastname', Criteria::ASC)
					->orderBy('firstname', Criteria::ASC);
					break;
				case 'customer-name-reverse':
					$search
					->joinCustomer()
					->withColumn(CustomerTableMap::FIRSTNAME, 'firstname')
					->withColumn(CustomerTableMap::LASTNAME, 'lastname')
					->orderBy('lastname', Criteria::DESC)
					->orderBy('firstname', Criteria::DESC);
					break;
			}
		}
	
		return $search;
	}
	
	/**
	 * @param LoopResult $loopResult
	 *
	 * @return LoopResult
	 */
	public function parseResults(LoopResult $loopResult)
	{		
		/** @var OfferModel $offer */
		foreach ($loopResult->getResultDataCollection() as $offer) {
			$tax = 0;
			$amount = $offer->getTotalAmount($tax);
			$hasVirtualDownload = $offer->hasVirtualProduct();
			
			
			$loopResultRow = new LoopResultRow($offer);
			$loopResultRow
			->set("ID", $offer->getId())
			->set("REF", $offer->getRef())
			->set("CREATE_OFFER", $offer->getCreatedAt()->getTimestamp())
			->set("CUSTOMER", $offer->getCustomerId())
			->set("STATUS", $offer->getStatusId())
			->set('DELIVERY_ADDRESS', $offer->getDeliveryOrderAddressId())
			->set('INVOICE_ADDRESS', $offer->getInvoiceOrderAddressId())
			->set('INVOICE_DATE', $offer->getInvoiceDate())
			->set('CURRENCY', $offer->getCurrencyId())
			->set('CURRENCY_RATE', $offer->getCurrencyRate())
			->set('TRANSACTION_REF', $offer->getTransactionRef())
			->set('DELIVERY_REF', $offer->getDeliveryRef())
			->set('INVOICE_REF', $offer->getInvoiceRef())
			->set('VIRTUAL', $hasVirtualDownload)
			->set('POSTAGE', $offer->getPostage())
			->set('POSTAGE_TAX', $offer->getPostageTax())
			->set('POSTAGE_UNTAXED', $offer->getUntaxedPostage())
			->set('POSTAGE_TAX_RULE_TITLE', $offer->getPostageTaxRuleTitle())
			->set('PAYMENT_MODULE', $offer->getPaymentModuleId())
			->set('DELIVERY_MODULE', $offer->getDeliveryModuleId())
			->set('STATUS_CODE', $offer->getOrderStatus()->getCode())
			->set('LANG', $offer->getLangId())
			->set('DISCOUNT', $offer->getDiscount())
			->set('TOTAL_TAX', $tax)
			->set('TOTAL_AMOUNT', $amount - $tax)
			->set('TOTAL_TAXED_AMOUNT', $amount)
			->set('WEIGHT', $offer->getWeight());
	
			
			if ($this->getWithPrevNextInfo()) {
				// Find previous and next category
				$previousQuery = OfferQuery::create()
				->filterById($offer->getId(), Criteria::LESS_THAN)
				->filterByStatusId($offer->getStatusId(), Criteria::EQUAL);
				
				$previous = $previousQuery
				->orderById(Criteria::DESC)
				->findOne();
				
				$nextQuery = OfferQuery::create()
				->filterById($offer->getId(), Criteria::GREATER_THAN)
				->filterByStatusId($offer->getStatusId(), Criteria::EQUAL);
				
				$next = $nextQuery
				->orderById(Criteria::ASC)
				->findOne();
				
				$loopResultRow
				->set("HAS_PREVIOUS", $previous != null ? 1 : 0)
				->set("HAS_NEXT", $next != null ? 1 : 0)
				->set("PREVIOUS", $previous != null ? $previous->getId() : -1)
				->set("NEXT", $next != null ? $next->getId() : -1);
			}
			
			$this->addOutputFields($loopResultRow, $offer);
			
			$loopResult->addRow($loopResultRow);
		}
		
		return $loopResult;
	}
}
