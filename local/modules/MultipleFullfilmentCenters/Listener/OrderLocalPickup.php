<?php
namespace MultipleFullfilmentCenters\Listener;

use MultipleFullfilmentCenters\MultipleFullfilmentCenters;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Thelia\Action\BaseAction;
use Thelia\Core\Event\Order\OrderEvent;
use Thelia\Core\Event\TheliaEvents;
use MultipleFullfilmentCenters\Model\OrderLocalPickupQuery;
use MultipleFullfilmentCenters\Model\FulfilmentCenterProductsQuery;
use Thelia\Model\ProductSaleElementsQuery;
use Thelia\Model\OrderStatusQuery;
use Thelia\Core\Event\Cart\CartEvent;
use Thelia\Model\CartItemQuery;
use Thelia\Log\Tlog;
use Thelia\Core\HttpFoundation\Request;

/**
 */
class OrderLocalPickup extends BaseAction implements EventSubscriberInterface
{
	protected $request;
	
	public function __construct(Request $request)
	{
		$this->request = $request;
	}	
	
	/**
	 * @param  OrderEvent $event
	 */
	public function createOrderWithFulfilmentCenter(OrderEvent $event)
	{ 
		$order = $event->getPlacedOrder();
		$orderProductList = $order->getOrderProducts();
		
		/** @var OrderProduct  $orderProduct */
		foreach ($orderProductList as $orderProduct) {
			$productId = $orderProduct->getVirtualColumn('product_id');
	
			// fulfill order_local_pickup with orderId - for products that can be picked up from fulfilment centers
			$cartProductLocation = OrderLocalPickupQuery::create()
				->filterByProductId($productId)
				->filterByCartId($order->getCartId())
				->findOne();
			
			if($cartProductLocation) {
				$cartProductLocation->setOrderId($order->getId())
					->save();
				
				if($cartProductLocation->getFulfilmentCenterId() == 3) {
					
					$productLocation = FulfilmentCenterProductsQuery::create()
						->filterByProductId($productId)
						->filterByFulfilmentCenterId(3)
						->findOne();
					
					$productLocation->setReservedStock($productLocation->getReservedStock() + $cartProductLocation->getQuantity())
						->save();
				}
			} 
		}
		
		$this->request->getSession()->remove('buy_format');
	}
	
	// decrease stock for the specific fulfilment center & decrease reserved stock 
	public function updateQuantity(OrderEvent $event) 
	{     
		$paidStatus = OrderStatusQuery::getPaidStatus()->getId();
		$newStatus = $event->getStatus();
		$order = $event->getOrder();
		$orderProductList = $order->getOrderProducts();
		
		if ($paidStatus == $newStatus) { 
			foreach ($orderProductList as $orderProduct) {
				
				$productId = ProductSaleElementsQuery::create()
						->select('product_id')
						->findOneById($orderProduct->getProductSaleElementsId());
				
				$cartProductLocation = OrderLocalPickupQuery::create()
					->filterByProductId($productId)
					->filterByCartId($order->getCartId())
					->findOne();
				
				if($cartProductLocation) {
					
					$productLocation = FulfilmentCenterProductsQuery::create()
						 ->filterByProductId($productId)
						 ->filterByFulfilmentCenterId($cartProductLocation->getFulfilmentCenterId())
						 ->findOne();
					 
					if($productLocation) {
						$newStockLocation = $productLocation->getProductStock() - $orderProduct->getQuantity();
						 
						$productLocation->setProductStock($newStockLocation);
						 
						if($productLocation->getFulfilmentCenterId() == 3) {
							$productLocation->setReservedStock($productLocation->getReservedStock() - $orderProduct->getQuantity());
						}
						
						$productLocation->save();
					 } 
				}
			}
		}
	}
	
	public function getItemLocalPickup($event)
	{
		$cart = $event->getCart();
		
		$productId = CartItemQuery::create()
			->select('product_id')
			->filterByCartId($cart->getId())
			->filterById($event->getCartItemId())
			->findOne();
		
		$productLocalPickup = OrderLocalPickupQuery::create()
			->filterByProductId($productId)
			->filterByCartId($cart->getId())
			->findOne();
		
		return $productLocalPickup;
	}
	
	// update product quantity in OrderLocalPickup tabel
	public function updateQuantityOrderLocalPickup(CartEvent $event)
	{ 
		$productLocalPickup = $this->getItemLocalPickup($event);
		
		if($productLocalPickup)
			$productLocalPickup
				->setQuantity($event->getQuantity())
				->save();
		
	}
	
	// delete product from OrderLocalPickup tabel if it's deleted from cart
	public function deleteItemOrderLocalPickup(CartEvent $event)
	{
		$productLocalPickup = $this->getItemLocalPickup($event);
		
		if($productLocalPickup)
			$productLocalPickup->delete();
	}
	
	// fulfill order_local_pickup with product and pickup center
	public function insertProductPickupLocation(CartEvent $event) 
	{
		Tlog::getInstance()->error('cart event - productid: '.$event->getProduct().'- cartId: '.$event->getCart()->getId().'- quantiy: '.$event->getQuantity());
		
		$cartItem = $this->findCartItem($event);
		
		if($cartItem) {
			Tlog::getInstance()->error('update quantity');
			$this->updateItemIfExists($cartItem, $event);
		}
		else {
			Tlog::getInstance()->error('buy format on product page - '.$this->request->getSession()->get('buy_format'));
			
			if($this->request->getSession()->get('buy_format')== 'reserve' ) {
				
				$cartProductLocation = OrderLocalPickupQuery::create()
					->filterByProductId($event->getProduct())
					->filterByCartId($event->getCart()->getId())
					->findOneOrCreate();
				
				$cartProductLocation->setFulfilmentCenterId(3)
					->setQuantity($event->getQuantity())
					->save(); 
			} 
		}
	}
	
	public function findCartItem(CartEvent $event) {
		
		$productInCart = CartItemQuery::create()
			->filterByCartId($event->getCart()->getId())
			->filterByProductId($event->getProduct())
			->filterByProductSaleElementsId($event->getProductSaleElementsId())
			->findOne();
		
		return $productInCart;
	}
	
	// update stock in order_local_pickup if exists already in cart
	public function updateItemIfExists($cartItem, CartEvent $event)
	{
		$productLocalPickup = OrderLocalPickupQuery::create()
			->filterByProductId($event->getProduct())
			->filterByCartId($event->getCart()->getId())
			->filterByFulfilmentCenterId(3)
			->findOne();
		
		if($productLocalPickup) {
			
			$productLocalPickup 
				->setQuantity($cartItem->getQuantity())
				->save(); 
		}
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
				TheliaEvents::ORDER_PAY =>array("createOrderWithFulfilmentCenter", 128),
				TheliaEvents::ORDER_UPDATE_STATUS=>array("updateQuantity", 128),
				TheliaEvents::CART_UPDATEITEM => array("updateQuantityOrderLocalPickup", 128),
				TheliaEvents::CART_DELETEITEM => array("deleteItemOrderLocalPickup", 256),
				TheliaEvents::CART_ADDITEM => array("insertProductPickupLocation", 128)
		);
	}
}
