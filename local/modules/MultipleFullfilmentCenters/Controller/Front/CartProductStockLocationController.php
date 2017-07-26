<?php


namespace MultipleFullfilmentCenters\Controller\Front;

use MultipleFullfilmentCenters\MultipleFullfilmentCenters;
use MultipleFullfilmentCenters\Controller\Admin\MultipleFullfilmentCentersController;
use MultipleFullfilmentCenters\Model\OrderLocalPickupQuery;

class CartProductStockLocationController extends MultipleFullfilmentCentersController
{
	public function addProductLocation()
	{ 

		// fulfill order_local_pickup with product and pickup center
		$cartProductLocation = OrderLocalPickupQuery::create()
			->filterByProductId($_POST['productId'])
			->filterByCartId($_POST['cartId'])
			->findOneOrCreate();
		
		$cartProductLocation->setFulfilmentCenterId($_POST['locationId'])
			->setQuantity($_POST['quantity'])
			->save();  
	}
}