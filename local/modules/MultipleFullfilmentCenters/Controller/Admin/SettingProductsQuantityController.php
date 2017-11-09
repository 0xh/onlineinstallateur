<?php

namespace MultipleFullfilmentCenters\Controller\Admin;

use Thelia\Controller\Admin\BaseAdminController;
use MultipleFullfilmentCenters\Model\FulfilmentCenterProducts;
use MultipleFullfilmentCenters\Model\FulfilmentCenterProductsQuery;
use MultipleFullfilmentCenters\Model\Map\FulfilmentCenterProductsTableMap;

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
	    
	    foreach ($idToUpdateQuantity as $id)
	    {
	        $this->updateProdQuantity($id, $_GET['quantity_'.$id], $fulfilmentCenterId);
	    }
	    
	    return $this->generateRedirect("/admin/module/multiplefulfilmentcenters/setting-products?change_fulfilment_center=" . $fulfilmentCenterId, 303);
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
