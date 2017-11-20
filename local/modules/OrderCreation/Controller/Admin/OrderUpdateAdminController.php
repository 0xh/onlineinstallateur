<?php 
namespace OrderCreation\Controller\Admin;

use Thelia\Controller\Admin\BaseAdminController;
use OrderCreation\OrderCreation;
use Thelia\Model\OrderProductQuery;
use Thelia\Model\OrderProductTaxQuery;

class OrderUpdateAdminController extends BaseAdminController
{
	public function updateOrderProduct()
    { 
    	
    	$form = $this->createForm("admin.order.edit.form");
    	
    	$message = null;
    	
    	try {
    		
    		$data = $this->validateForm($form)->getData();
    		
    		$orderProduct = OrderProductQuery::create()
    			->filterById($data['order_product_id'])
    			->findOne();
    		
    		$orderProductTax = OrderProductTaxQuery::create()
    			->filterByOrderProductId($data['order_product_id'])
    			->findOne();
    		
    		if($orderProduct) {
    			
    			if($orderProduct->getWasInPromo())
    				$orderProduct->setPromoPrice($data['product_price']);
    			else
    				$orderProduct->setPrice($data['product_price']);
    			
    			$orderProduct->setTitle($data['product_title']);
    			$orderProduct->setQuantity($data['product_quantity']);
    			
    			
    			if($orderProductTax) {
    				if($orderProduct->getWasInPromo())
    					$orderProductTax->setPromoAmount(0.2 * $data['product_price']);
    				else
    					$orderProductTax->setAmount(0.2 * $data['product_price']);
    			}
    		}
    		$orderProduct->save();
    		$orderProductTax->save();
    		
    	} catch (\Exception $e) {
    		$message = $e->getMessage();
    	}
    	
    	$params = array();
    	
    	if ($message) {
    		$params["update_order_product_error_message"] = $message;
    	}
    	
    	return $this->generateRedirectFromRoute(
    			"admin.order.update.view",
    			$params,
    			[ 'order_id' => $data['order_id']]
    			);
    }
    
    public function deleteOrderProduct()
    {    	
    	$message = null;
    	
    	try {
    		
    		OrderProductTaxQuery::create()
    			->filterByOrderProductId($_POST['order_product_id'])
	    		->delete();
    		
    		OrderProductQuery::create()
    			->filterById($_POST['order_product_id'])
	    		->delete();
    		
    	} catch (\Exception $e) {
    		$message = $e->getMessage();
    	}
    	
    	$params = array();
    	
    	if ($message) {
    		$params["delete_order_product_error_message"] = $message;
    	}
    	
    	return $this->generateRedirectFromRoute(
    			"admin.order.update.view",
    			$params,
    			[ 'order_id' => $_POST['order_id']]
    			);
    }
}