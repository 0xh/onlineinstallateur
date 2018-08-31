<?php


namespace LocalPickup\Controller\Front;

use LocalPickup\LocalPickup;
use Thelia\Controller\Front\BaseFrontController;
use LocalPickup\Model\OrderLocalPickupQuery;
use Thelia\Action\BaseAction;
use Thelia\Core\Event\Order\OrderEvent;
use Thelia\Core\Event\TheliaEvents;
use Thelia\Model\ProductSaleElementsQuery;
use Thelia\Model\OrderStatusQuery;
use Thelia\Core\Event\Cart\CartEvent;
use Thelia\Model\CartItemQuery;
use Thelia\Log\Tlog;
use Thelia\Core\HttpFoundation\Request;
use LocalPickup\Model\OrderLocalPickupAddressQuery;

class LocalPickupFrontController extends BaseFrontController
{
    
	// fulfill order_local_pickup with product and pickup center
	public function addProductLocation()
	{ 
           $cartId=$_POST['cartId'];
           $locationId=$_POST['locationId'];
//            Tlog::getInstance()->error("CARTPRODUCTADI ".$_POST['cartId']." ".$_POST['locationId']);
            
                $cartProductLocation = OrderLocalPickupAddressQuery::create()
                        ->filterByLocalPickupCartId($cartId)
                        ->findOneOrCreate();
		
		$cartProductLocation->setLocalPickupId($locationId)
			->save();  
            exit;
	}
}