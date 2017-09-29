<?php


namespace OfferCreation\Controller\Admin;

use Thelia\Controller\Admin\BaseAdminController;
use Thelia\Core\Security\AccessManager;
use Thelia\Core\Security\Resource\AdminResources;

class OfferCreationController extends BaseAdminController
{
	public function editOffer($offer_id)
	{
		if (null !== $response = $this->checkAuth(array(AdminResources::MODULE), array('OfferCreation'), AccessManager::VIEW)) {
			return $response;
		}
		
		return $this->render("edit-offer", array(
				"offer_id" => $offer_id
		));
	}
	
	
	public function updateStatus($order_id = null)
	{ 
		print_r('offer id: '.$this->getRequest()->get("offer_id").'<br>');
		print_r('status id: '.$this->getRequest()->request->get("status_id").'<br>');
		die('----');
		/* if (null !== $response = $this->checkAuth(AdminResources::ORDER, array(), AccessManager::UPDATE)) {
			return $response;
		}
		
		$message = null;
		
		try {
			if ($order_id === null) {
				$order_id = $this->getRequest()->get("order_id");
			}
			
			$order = OrderQuery::create()->findPk($order_id);
			
			$statusId = $this->getRequest()->request->get("status_id");
			$status = OrderStatusQuery::create()->findPk($statusId);
			
			if (null === $order) {
				throw new \InvalidArgumentException("The order you want to update status does not exist");
			}
			if (null === $status) {
				throw new \InvalidArgumentException("The status you want to set to the order does not exist");
			}
			
			$event = new OrderEvent($order);
			$event->setStatus($statusId);
			
			$this->dispatch(TheliaEvents::ORDER_UPDATE_STATUS, $event);
		} catch (\Exception $e) {
			$message = $e->getMessage();
		}
		
		$params = array();
		
		if ($message) {
			$params["update_status_error_message"] = $message;
		}
		
		$browsedPage = $this->getRequest()->get("order_page");
		$currentStatus = $this->getRequest()->get("status");
		
		if ($browsedPage) {
			$params["order_page"] = $browsedPage;
			
			if (null !== $currentStatus) {
				$params["status"] = $currentStatus;
			}
			
			$response = $this->generateRedirectFromRoute("admin.order.list", $params);
		} else {
			$params["tab"] = $this->getRequest()->get("tab", 'cart');
			
			$response = $this->generateRedirectFromRoute("admin.order.update.view", $params, [ 'order_id' => $order_id ]);
		}
		
		return $response; */
	}
}
