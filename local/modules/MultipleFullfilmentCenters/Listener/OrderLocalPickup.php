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

/**
 */
class OrderLocalPickup extends BaseAction implements EventSubscriberInterface
{
	/**
	 * @param  OrderEvent $event
	 */
	public function createOrderWithFulfilmentCenter(OrderEvent $event)
	{ 
		$order = $event->getPlacedOrder();
		$orderProductList = $order->getOrderProducts();
		
		// fulfill order_local_pickup with orderId - for products that can be picked up from fulfilment centers
		/** @var OrderProduct  $orderProduct */
		foreach ($orderProductList as $orderProduct) {
			$productId = $orderProduct->getVirtualColumn('product_id');
			$cartProductLocation = OrderLocalPickupQuery::create()
				->filterByProductId($productId)
				->filterByCartId($order->getCartId())
				->findOne();
			
			if($cartProductLocation) {
				$cartProductLocation->setOrderId($order->getId())
					->save();
			} 
		}
	}
	
	// decrease stock for the specific fulfilment center
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
						 
						 $productLocation->setProductStock($newStockLocation)
						 	->save();
					 } 
				}
			}
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
				TheliaEvents::ORDER_UPDATE_STATUS=>array("updateQuantity", 128)
		);
	}
}
