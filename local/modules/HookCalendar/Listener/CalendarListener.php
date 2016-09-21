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
use HookCalendar\Model\BookingsServices;
use Thelia\Model\CartItemQuery;

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
    	
    	$log->debug("-- bookingservice_order_id |".$event->getOrder()->getCartId()."|");
    	
    	$cart_id = $event->getOrder()->getCartId();
    	
    	$cart_items = CartItemQuery::create()->findByCartId($cart_id);
    	
    	$bookingsServicesQuery = BookingsServicesQuery::create();
    	
    	foreach($cart_items as $cart_item){
    		$log->debug("-- bookingservice cartItem ".$cart_item->getId());
    		$bookingsServicesQuery->clear();
    		$bookingService = $bookingsServicesQuery->findOneByCartItemId($cart_item->getId());
    		if($bookingService != null){
    		//	$bookingService = new BookingsServices();
    			$bookingService->setOrderId($event->getOrder()->getId());
    			$bookingService->save();
    			$log->debug("-- bookingservice ".$bookingService->getId()." updated with orderId |".$event->getOrder()->getId()."|");
    		}		
    	}
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            TheliaEvents::ORDER_BEFORE_PAYMENT => [
                'addOrderToBookingServices', 128
            ]
        ];
    }
}
