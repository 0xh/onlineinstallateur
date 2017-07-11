<?php


namespace MultipleFullfilmentCenters\Controller\Admin;

use MultipleFullfilmentCenters\MultipleFullfilmentCenters;
use MultipleFullfilmentCenters\Model\FulfilmentCenter;
use MultipleFullfilmentCenters\Model\FulfilmentCenterQuery;
use MultipleFullfilmentCenters\Model\FulfilmentCenterProducts;
use MultipleFullfilmentCenters\Model\FulfilmentCenterProductsQuery;
use Thelia\Core\Security\AccessManager;
use Thelia\Core\Security\Resource\AdminResources;
use DeliveryDelay\DeliveryDelay;

class ProductStockController extends MultipleFullfilmentCentersController
{
	public function addProductStock()
	{
		if (null !== $response = $this->checkAuth(array(AdminResources::MODULE), array('MultipleFullfilmentCenters'), AccessManager::UPDATE)) {
			return $response;
		}
		
		$form = $this->createForm("locationstock.form");
		
		try {
			$data = $this->validateForm($form)->getData();
			
			$productStock=  new FulfilmentCenterProducts();
			
			$productStock
			->setFulfilmentCenterId($data["location_stock"])
			->setProductStock($data["product_stock"])
			->setProductId($data["product_id"])
			->save();
			
			return $this->generateSuccessRedirect($form);
		} catch (\Exception $e) {
			$this->setupFormErrorContext(
					$this->getTranslator()->trans("Error on new product location stock : %message", ["message"=>$e->getMessage()], DeliveryDelay::DOMAIN_NAME),
					$e->getMessage(),
					$form
					);
			
			return self::viewAction();
		}
	}
	
	public function updateProductStock()
	{
		if (null !== $response = $this->checkAuth(array(AdminResources::MODULE), array('MultipleFullfilmentCenters'), AccessManager::UPDATE)) {
			return $response;
		}
		
		$form = $this->createForm("locationstock.form");
		
		try {
			$data = $this->validateForm($form)->getData();
			
			$productStock = FulfilmentCenterProductsQuery::create()
			->findOneById($data["id"]);
			
			if (null === $productStock) {
				throw new \Exception($this->getTranslator()->trans("Location stock id doesn't exist"), array(), DeliveryDelay::DOMAIN_NAME);
			}
			
			$productStock
			->setProductStock($data["product_stock"])
			->save();
			
			return $this->generateSuccessRedirect($form);
		} catch (\Exception $e) {
			$this->setupFormErrorContext(
					$this->getTranslator()->trans("Error updating location stock: %message", ["message"=>$e->getMessage()], DeliveryDelay::DOMAIN_NAME),
					$e->getMessage(),
					$form
					);
			
			return self::viewAction();
		}
	}
	
	public function deleteProductStock()
	{
		if (null !== $response = $this->checkAuth(array(AdminResources::MODULE), array('MultipleFullfilmentCenters'), AccessManager::UPDATE)) {
			return $response;
		}
		
		$form = $this->createForm("locationstock.form");
		
		try {
			$data = $this->validateForm($form)->getData();
			
			$productStock= FulfilmentCenterProductsQuery::create()
			->findOneById($data["id"]);
			
			if (null === $productStock) {
				throw new \Exception($this->getTranslator()->trans("Location product stock id doesn't exist"), array(), DeliveryDelay::DOMAIN_NAME);
			}
			
			$productStock->delete();
			
			return $this->generateSuccessRedirect($form);
		} catch (\Exception $e) {
			$this->setupFormErrorContext(
					$this->getTranslator()->trans("Error on location deletion : %message", ["message"=>$e->getMessage()], DeliveryDelay::DOMAIN_NAME),
					$e->getMessage(),
					$form
					);
			
			return self::viewAction();
		}
	}
}
