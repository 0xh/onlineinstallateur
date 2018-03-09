<?php


namespace MultipleFullfilmentCenters\Controller\Front;

use MultipleFullfilmentCenters\MultipleFullfilmentCenters;
use MultipleFullfilmentCenters\Controller\Admin\MultipleFullfilmentCentersController;
use MultipleFullfilmentCenters\Model\OrderLocalPickupQuery;

class CartProductStockLocationController extends MultipleFullfilmentCentersController
{
	// fulfill order_local_pickup with product and pickup center
	public function addProductLocation()
	{ 
		$cartProductLocation = OrderLocalPickupQuery::create()
			->filterByProductId($_POST['productId'])
			->filterByCartId($_POST['cartId'])
			->findOneOrCreate();
		
		$cartProductLocation->setFulfilmentCenterId($_POST['locationId'])
			->setQuantity($_POST['quantity'])
			->save();  
	}
	
	// set session with the type of buying: delivery/reserve and pickup. 
	// used to check method delivery
	public function setBuyFormat()
	{
		$this->getRequest()->getSession()->set(
				"buy_format",
				$_POST['buyFormat']
				);
	}
}