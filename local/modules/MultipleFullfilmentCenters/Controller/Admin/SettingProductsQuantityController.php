<?php

namespace MultipleFullfilmentCenters\Controller\Admin;

use Thelia\Controller\Admin\BaseAdminController;
use MultipleFullfilmentCenters\Model\FulfilmentCenterProducts;
use MultipleFullfilmentCenters\Model\FulfilmentCenterProductsQuery;
use MultipleFullfilmentCenters\Model\Map\FulfilmentCenterProductsTableMap;
use Thelia\Model\ProductSaleElementsQuery;

class SettingProductsQuantityController extends BaseAdminController
{
    public function viewAction()
	{
	    return $this->render("product-quantity/SettingProductsQuantityTemplate");
	}
	
	public function blockJs()
	{
	    return $this->render("product-quantity/SettingProductsQuantityJs");
	}

	public function updateQuantityFullfilmentCenters()
	{
	    $idToUpdateQuantity = $_GET['list_prods_to_update_quantity'] ? $this->getIdToUpdateQuantity($_GET['list_prods_to_update_quantity']) : array();
	    $fulfilmentCenterId = $_GET['change_fulfilment_center_val'];
	    $fulfilmentCenterQuantity = $_GET['change_fulfilment_center_qunatity_val'];
	    $isInFulfilmentCenter = $_GET['is_in_fulfilment_center_val'];
	    
	    foreach ($idToUpdateQuantity as $id)
	    {
	        $this->updateProdQuantity($id, $_GET['quantity_'.$id], $fulfilmentCenterId);
	    }

	    return $this->generateRedirect("/admin/module/multiplefulfilmentcenters/setting-products?change_fulfilment_center=" 
	        . $fulfilmentCenterId . "&change_fulfilment_center_qunatity=" . $fulfilmentCenterQuantity 
	        . "&is_in_fulfilment_center=" . $isInFulfilmentCenter, 303);
	}
	
	protected function updateProdQuantity($idProd, $quantity, $fulfilmentCenterId)
	{
	    $prod = FulfilmentCenterProductsQuery::create()
        	    ->where(FulfilmentCenterProductsTableMap::PRODUCT_ID.' = ?', $idProd, \PDO::PARAM_STR)
        	    ->where(FulfilmentCenterProductsTableMap::FULFILMENT_CENTER_ID.' = ?', $fulfilmentCenterId, \PDO::PARAM_STR)
                ->findOne();
	    if ($prod)
	    {
	        $prod->setProductStock($quantity);
	        $prod->save();
	    }       
	    else 
	    {
	        $this->insertProdQuantity($idProd, $quantity, $fulfilmentCenterId);
	    }
	    
	    $this->updateEntireStock($idProd);
	}
	
	protected function updateEntireStock($product_id) {
		
		$entireProductStock = FulfilmentCenterProductsQuery::create()
			->findByProductId($product_id);
		
		$total = 0;
		if($entireProductStock)
			foreach ($entireProductStock as $i => $value) {
				$total += $value->getProductStock();
			}
		
		$productFinalStock =  ProductSaleElementsQuery::create()
			->findOneByProductId($product_id);
		
		$productFinalStock
			->setQuantity($total)
			->save();
	}
	
	protected function insertProdQuantity($idProd, $quantity, $fulfilmentCenterId)
	{
	    $prod = new FulfilmentCenterProducts();
	    $prod->setFulfilmentCenterId($fulfilmentCenterId);
	    $prod->setProductId($idProd);
	    $prod->setProductStock($quantity);
	    $prod->save();	    
	}
	
	protected function getIdToUpdateQuantity($string)
	{
	    return explode(",", $string);
	}
}
