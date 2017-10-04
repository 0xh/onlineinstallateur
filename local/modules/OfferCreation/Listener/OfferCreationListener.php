<?php
namespace OfferCreation\Listener;

use OfferCreation\OfferCreation;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Thelia\Action\BaseAction;
use Thelia\Core\Event\Order\OrderEvent;
use Thelia\Core\Event\TheliaEvents;
use Thelia\Core\Event\Order\OrderManualEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Thelia\Model\Order as ModelOrder;
use Thelia\Model\Cart as CartModel;
use Thelia\Model\Currency as CurrencyModel;
use Thelia\Model\Lang as LangModel;
use Thelia\Core\Security\User\UserInterface;
use Propel\Runtime\Propel;
use Thelia\Model\OrderAddressQuery;
use Thelia\Model\AddressQuery;
use Thelia\Model\OrderAddress;
use OfferCreation\Model\Offer;
use Thelia\Core\HttpFoundation\Request;
use OfferCreation\Model\Map\OfferTableMap;
use Thelia\Tools\I18n;
use Thelia\Core\Event\Product\VirtualProductOrderHandleEvent;
use Thelia\Model\ConfigQuery;
use Thelia\Exception\TheliaProcessException;
use OfferCreation\Model\OfferProduct;
use OfferCreation\Model\OfferProductTax;
use Thelia\Tools\URL;

/**
 */
class OfferCreationListener extends BaseAction implements EventSubscriberInterface
{
	protected $request;
	
	public function __construct(Request $request)
	{
		$this->request = $request;
	}	
	
	/**
	 * Create manual order from backOffice
	 * 
	 * @param  OrderEvent $event
	 */
	public function createManualOffer(OrderManualEvent $event, $eventName, EventDispatcherInterface $dispatcher)
	{  	
		$orderStatusId = $event->getOrder()->getStatusId();
				
		if($orderStatusId == 9) {
		
			$this->createOffer(
				$dispatcher,
				$event->getOrder(),
				$event->getCurrency(),
				$event->getLang(),
				$event->getCart(),
				$event->getCustomer(),
				$event->getUseOrderDefinedAddresses()	
			);
			
			$url = '/admin/customer/update?customer_id='.$event->getCustomer()->getId();
			
			exit(header("Location: ".$url));
		}
		else {
			return;
		} 		
	}	
	
	/**
	 * @param EventDispatcherInterface $dispatcher
	 * @param ModelOrder $sessionOrder
	 * @param CurrencyModel $currency
	 * @param LangModel $lang
	 * @param CartModel $cart
	 * @param UserInterface $customer
	 * @param bool $useOrderDefinedAddresses if true, the delivery and invoice OrderAddresses will be used instead of creating new OrderAdresses using Order::getChoosenXXXAddress()
	 * @return ModelOrder
	 * @throws \Exception
	 * @throws \Propel\Runtime\Exception\PropelException
	 */
	protected function createOffer(
			EventDispatcherInterface $dispatcher,
			ModelOrder $sessionOrder,
			CurrencyModel $currency,
			LangModel $lang,
			CartModel $cart,
			UserInterface $customer,
			$useOrderDefinedAddresses = false
			) {
				$con = Propel::getConnection(
						OfferTableMap::DATABASE_NAME
						);
				
				$con->beginTransaction();
				$placedOrder = $sessionOrder->copy();
				
				$placedOffer= new Offer();	
				
				// Be sure to create a brand new order, as copy raises the modified flag for all fields
				// and will also copy order reference and id.
				$placedOffer->setId(null)->setRef(null)->setNew(true);
				
				// Dates should be marked as not updated so that Propel will update them.
				$placedOffer->resetModified(OfferTableMap::CREATED_AT);
				$placedOffer->resetModified(OfferTableMap::UPDATED_AT);
				$placedOffer->resetModified(OfferTableMap::VERSION_CREATED_AT);
	
				/* fulfill offer */
				$placedOffer->setCustomerId($customer->getId());
				$placedOffer->setEmployeeId($this->request->getSession()->getAdminUser()->getId());
				$placedOffer->setCurrencyId($currency->getId());
				$placedOffer->setCurrencyRate($currency->getRate());
				$placedOffer->setLangId($lang->getId());
				$placedOffer->setPaymentModuleId($sessionOrder->getPaymentModuleId());
				$placedOffer->setDeliveryModuleId($sessionOrder->getDeliveryModuleId());
				$placedOffer->setNoteEmployee($this->request->getSession()->get('employee_note'));
				$placedOffer->setPostage($sessionOrder->getPostage());
				$placedOffer->setPostageTax($sessionOrder->getPostageTax());
				$placedOffer->setPostageTaxRuleTitle($sessionOrder->getPostageTaxRuleTitle());
				
				if ($useOrderDefinedAddresses) {
					$taxCountry =
						OrderAddressQuery::create()
							->findPk($placedOrder->getDeliveryOrderAddressId())
							->getCountry();
				} else {
					$deliveryAddress = AddressQuery::create()->findPk($sessionOrder->getChoosenDeliveryAddress());
					$invoiceAddress = AddressQuery::create()->findPk($sessionOrder->getChoosenInvoiceAddress());
					
					/* hard save the delivery and invoice addresses */
					$deliveryOrderAddress = new OrderAddress();
					$deliveryOrderAddress
						->setCustomerTitleId($deliveryAddress->getTitleId())
						->setCompany($deliveryAddress->getCompany())
						->setFirstname($deliveryAddress->getFirstname())
						->setLastname($deliveryAddress->getLastname())
						->setAddress1($deliveryAddress->getAddress1())
						->setAddress2($deliveryAddress->getAddress2())
						->setAddress3($deliveryAddress->getAddress3())
						->setZipcode($deliveryAddress->getZipcode())
						->setCity($deliveryAddress->getCity())
						->setPhone($deliveryAddress->getPhone())
						->setCellphone($deliveryAddress->getCellphone())
						->setCountryId($deliveryAddress->getCountryId())
						->setStateId($deliveryAddress->getStateId())
						->save($con);
					
					$invoiceOrderAddress = new OrderAddress();
					$invoiceOrderAddress
						->setCustomerTitleId($invoiceAddress->getTitleId())
						->setCompany($invoiceAddress->getCompany())
						->setFirstname($invoiceAddress->getFirstname())
						->setLastname($invoiceAddress->getLastname())
						->setAddress1($invoiceAddress->getAddress1())
						->setAddress2($invoiceAddress->getAddress2())
						->setAddress3($invoiceAddress->getAddress3())
						->setZipcode($invoiceAddress->getZipcode())
						->setCity($invoiceAddress->getCity())
						->setPhone($invoiceAddress->getPhone())
						->setCellphone($invoiceAddress->getCellphone())
						->setCountryId($invoiceAddress->getCountryId())
						->setStateId($deliveryAddress->getStateId())
						->save($con);
				
					$placedOffer->setDeliveryOrderAddressId($deliveryOrderAddress->getId());
					$placedOffer->setInvoiceOrderAddressId($invoiceOrderAddress->getId());
					
					$taxCountry = $deliveryAddress->getCountry();
				}
				
				$placedOffer->setStatusId(
						$sessionOrder->getStatusId()
						);
				
				$placedOffer->setCartId($cart->getId());
				
				/* memorize discount */
				$placedOffer->setDiscount(
						$cart->getDiscount()
						);
				
				$placedOffer->save($con);
				
				$cartItems = $cart->getCartItems();
				
				/* fulfill offer_products*/
				
				foreach ($cartItems as $cartItem) {
					
					$product = $cartItem->getProduct();
					$pse = $cartItem->getProductSaleElements();
					
					/* get translation */
					/** @var ProductI18n $productI18n */
					$productI18n = I18n::forceI18nRetrieving($lang->getLocale(), 'Product', $product->getId());
					
					// get the virtual document path
					$virtualDocumentEvent = new VirtualProductOrderHandleEvent($placedOrder, $pse->getId());
					// essentially used for virtual product. modules that handles virtual product can
					// allow the use of stock even for virtual products
					$useStock = true;
					$virtual = 0;
					
					// if the product is virtual, dispatch an event to collect information
					if ($product->getVirtual() === 1) {
						$dispatcher->dispatch(TheliaEvents::VIRTUAL_PRODUCT_ORDER_HANDLE, $virtualDocumentEvent);
						$useStock = $virtualDocumentEvent->isUseStock();
						$virtual = $virtualDocumentEvent->isVirtual() ? 1 : 0;
					}
					
					/* check still in stock */
					if ($cartItem->getQuantity() > $pse->getQuantity() 
							&& true === ConfigQuery::checkAvailableStock()
							&& $useStock) {
						throw new TheliaProcessException("Not enough stock", TheliaProcessException::CART_ITEM_NOT_ENOUGH_STOCK, $cartItem);
					}
					
					/* get tax */
					/** @var TaxRuleI18n $taxRuleI18n */
					$taxRuleI18n = I18n::forceI18nRetrieving($lang->getLocale(), 'TaxRule', $product->getTaxRuleId());
			
					/** @var OrderProductTaxCollection $taxDetail */
					$taxDetail = $product->getTaxRule()->getTaxDetail(
							$product,
							$taxCountry,
							$cartItem->getPrice(),
							$cartItem->getPromoPrice(),
							$lang->getLocale()
							);					
					
					$offerProduct = new OfferProduct();
					$offerProduct
						->setOfferId($placedOffer->getId())
						->setProductRef($product->getRef())
						->setProductSaleElementsRef($pse->getRef())
						->setProductSaleElementsId($pse->getId())
						->setTitle($productI18n->getTitle())
						->setChapo($productI18n->getChapo())
						->setDescription($productI18n->getDescription())
						->setPostscriptum($productI18n->getPostscriptum())
						->setVirtual($virtual)
						->setVirtualDocument($virtualDocumentEvent->getPath())
						->setQuantity($cartItem->getQuantity())
						->setPrice($cartItem->getPrice())
						->setPromoPrice($cartItem->getPromoPrice())
						->setWasNew($pse->getNewness())
						->setWasInPromo($cartItem->getPromo())
						->setWeight($pse->getWeight())
						->setTaxRuleTitle($taxRuleI18n->getTitle())
						->setTaxRuleDescription($taxRuleI18n->getDescription())
						->setEanCode($pse->getEanCode())
						->save($con)
						;
							
						/* fulfill offer_product_tax */
						/** @var OrderProductTax $tax */
						 foreach ($taxDetail as $tax) {
						 	/** @var OfferProductTax $taxDetailOffer */
						 	$taxDetailOffer = new OfferProductTax();
						 	
						 	$taxDetailOffer->setOfferProductId($offerProduct->getId())
						 		->setTitle($tax->getTitle())
						 		->setDescription($tax->getDescription())
						 		->setAmount($tax->getAmount())
						 		->setPromoAmount($tax->getPromoAmount())
						 		->save($con);
						} 	
				}
				
				$con->commit();
	
				return $placedOffer;
	}
	
	
	/**
	 * Returns an array of event names this subscriber wants to listen to.
	 *
	 * The array keys are event names and the value can be:
	 *
	 *  * The method name to call (priority defaults to 0)
	 *  * An array composed of the method name to call and the priority
	 *  * An array of arrays composed of the method names to call and respective
	 *    priorities, or 0 if unset
	 *
	 * For instance:
	 *
	 *  * array('eventName' => 'methodName')
	 *  * array('eventName' => array('methodName', $priority))
	 *  * array('eventName' => array(array('methodName1', $priority), array('methodName2'))
	 *
	 * @return array The event names to listen to
	 *
	 * @api
	 */
	public static function getSubscribedEvents()
	{
		return array(
				TheliaEvents::ORDER_CREATE_MANUAL => array("createManualOffer", 256)
		);
	}
}
