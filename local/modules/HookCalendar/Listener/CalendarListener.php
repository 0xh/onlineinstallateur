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

namespace HookCalendar\Listener;

use HookCalendar\HookCalendar;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Thelia\Core\Event\TheliaEvents;
use Thelia\Core\Event\Order\OrderEvent;
use Thelia\Log\Tlog;
use HookCalendar\Model\BookingsServicesQuery;
use Thelia\Model\CartItemQuery;
use Thelia\Core\Event\Cart\CartItemDuplicationItem;

/**
 * Class AreaDeletedListener
 * @package AreaDeletedListener\EventListener
 * @author Thomas Arnaud <tarnaud@openstudio.fr>
 */
class CalendarListener implements EventSubscriberInterface
{
    /**
     * @param AreaDeleteEvent $event
     */
    public function addOrderToBookingServices(OrderEvent $event)
    {
    	$log = Tlog::getInstance ();
    	
    	$log->error("-- bookingservice_order_id |".$event->getOrder()->getCartId()."|");
    	
    	$cart_id = $event->getOrder()->getCartId();
    	
    	$cart_items = CartItemQuery::create()->findByCartId($cart_id);
    	
    	$bookingsServicesQuery = BookingsServicesQuery::create();
    	
    	foreach($cart_items as $cart_item){
    		$log->error("-- bookingservice cartItem ".$cart_item->getId());
    		$bookingsServicesQuery->clear();
    		$bookingService = $bookingsServicesQuery->findOneByCartItemId($cart_item->getId());
    		if($bookingService != null){
    		//	$bookingService = new BookingsServices();
    			$bookingService->setOrderId($event->getOrder()->getId());
    			$bookingService->save();
    			$log->error("-- bookingservice ".$bookingService->getId()." updated with orderId |".$event->getOrder()->getId()."|");
    		}
    		else
    			$log->error("-- bookingservice booking not found for ".$cart_item->getId());
    			
    	}
    }
    
    public static function restoreOrderIdInBookingService(CartItemDuplicationItem $event){
    	$originalCartItem = $event->getOldItem();
    	$dublicatedCartItem = $event->getNewItem();
    	$log = Tlog::getInstance ();
    	
    	$log->error("bookingservice old item  |".$originalCartItem->getId()."| new item ".$dublicatedCartItem->getId());
    	$bookingService = BookingsServicesQuery::create()->findOneByCartItemId($originalCartItem->getId());
    	
    	if($bookingService != null){
    		$bookingService->setCartItemId($dublicatedCartItem->getId());
    		$bookingService->save();
    		$log->error("bookingservice updated id from  |".$originalCartItem->getId()."| to ".$dublicatedCartItem->getId());
    	}
    	
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
        		TheliaEvents::ORDER_AFTER_CREATE => array("addOrderToBookingServices", 128),
        		TheliaEvents::CART_ITEM_DUPLICATE => array("restoreOrderIdInBookingService", 128)
        		);
    }
}
