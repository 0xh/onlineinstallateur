<?php


namespace OfferCreation\Controller\Admin;

use Thelia\Controller\Admin\BaseAdminController;
use Thelia\Core\Security\AccessManager;
use Thelia\Core\Security\Resource\AdminResources;
use Thelia\Core\Event\TheliaEvents;
use Thelia\Model\OrderStatusQuery;
use OfferCreation\Model\OfferQuery;
use Thelia\Model\Order;
use Propel\Runtime\Propel;
use Thelia\Model\OrderProduct;
use OfferCreation\Model\OfferProductQuery;
use Thelia\Model\Map\OrderProductTableMap;
use OfferCreation\Model\OfferProductTax;
use Thelia\Model\OrderProductTax;
use OfferCreation\Model\OfferProductTaxQuery;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Thelia\Tools\URL;
use Thelia\Form\OrderUpdateAddress;
use Thelia\Model\OrderAddressQuery;
use Thelia\Core\Event\Order\OrderAddressEvent;
use Thelia\Model\ConfigQuery;
use Thelia\Core\Event\PdfEvent;
use Thelia\Log\Tlog;
use Thelia\Exception\TheliaProcessException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
	
	
	public function updateStatus($offer_id = null)
	{ 
		if (null !== $response = $this->checkAuth(array(AdminResources::MODULE), array('OfferCreation'), AccessManager::UPDATE)) {
			return $response;
		}
		
		$message = null;
		
		$con = Propel::getConnection(
				OrderProductTableMap::DATABASE_NAME
				);
		
		$con->beginTransaction();
		
		try { 
			if ($offer_id === null) {
				$offer_id = $this->getRequest()->get("offer_id");
			}
			
			$offer = OfferQuery::create()->filterById($offer_id)->findOne();
			
			$statusId = $this->getRequest()->request->get("status_id");
			$status = OrderStatusQuery::create()->filterById($statusId);
		
			if (null === $offer) {
				throw new \InvalidArgumentException("The offer you want to update status does not exist");
			}
			if (null === $status) {
				throw new \InvalidArgumentException("The status you want to set to the offer does not exist");
			}
			
			
			$order = new Order();
			$order
				->setCustomerId($offer->getCustomerId())
				->setCurrencyId($offer->getCurrencyId())
				->setCurrencyRate($offer->getCurrencyRate())
				->setStatusId($statusId)
				->setLangId($offer->getLangId())
				->setChoosenDeliveryAddress($offer->getChoosenDeliveryAddress())
				->setChoosenInvoiceAddress($offer->getChoosenInvoiceAddress())
				->setPaymentModuleId($offer->getPaymentModuleId())
				->setDeliveryOrderAddressId($offer->getDeliveryOrderAddressId())
				->setInvoiceOrderAddressId($offer->getInvoiceOrderAddressId())
				->setDeliveryModuleId($offer->getDeliveryModuleId())
				->setDiscount($offer->getDiscount())
				->setCartId($offer->getCartId())
				->setPostage($offer->getPostage())
				->setPostageTax($offer->getPostageTax())
				->setPostageTaxRuleTitle($offer->getPostageTaxRuleTitle())
				->setInvoiceDate($offer->getInvoiceDate())
				->setDispatcher($this->getDispatcher())
				;
			
			$order->save($con);
			
			$offerProducts = OfferProductQuery::create()->filterByOfferId($offer_id);
			
			if($offerProducts) {
				foreach($offerProducts as $offerProduct) {
					
					$orderProduct = new OrderProduct();
					$orderProduct
						->setOrderId($order->getId())
						->setProductRef($offerProduct->getProductRef())
						->setProductSaleElementsRef($offerProduct->getProductSaleElementsRef())
						->setProductSaleElementsId($offerProduct->getProductSaleElementsId())
						->setTitle($offerProduct->getTitle())
						->setChapo($offerProduct->getChapo())
						->setDescription($offerProduct->getDescription())
						->setPostscriptum($offerProduct->getPostscriptum())
						->setVirtual($offerProduct->getVirtual())
						->setVirtualDocument($offerProduct->getVirtualDocument())
						->setQuantity($offerProduct->getQuantity())
						->setPrice($offerProduct->getPrice())
						->setPromoPrice($offerProduct->getPromoPrice())
						->setWasNew($offerProduct->getWasNew())
						->setWasInPromo($offerProduct->getWasInPromo())
						->setWeight($offerProduct->getWeight())
						->setTaxRuleTitle($offerProduct->getTaxRuleTitle())
						->setTaxRuleDescription($offerProduct->getTaxRuleDescription())
						->setEanCode($offerProduct->getEanCode())
						->save($con);
					
						$offerProductsTax = OfferProductTaxQuery::create()->filterByOfferProductId($offerProduct->getId());
					
						foreach($offerProductsTax as $offerProductTax) {
							
							$taxDetailOrder = new OrderProductTax();
							
							$taxDetailOrder->setOrderProductId($orderProduct->getId())
							->setTitle($offerProductTax->getTitle())
							->setDescription($offerProductTax->getDescription())
							->setAmount($offerProductTax->getAmount())
							->setPromoAmount($offerProductTax->getPromoAmount())
							->save($con);
						}
				}
			}
			
			// insert orderId and orderRef in offer table
			$offer->setOrderId($order->getId())
				->setOrderRef($order->getRef())
				->setStatusId($statusId)
				->save($con);
				
		} catch (\Exception $e) {
			$message = $e->getMessage();
		}
		
		$params = array();
	 
		if ($message) {
			$params["update_status_error_message"] = $message;
		}
		 
		$con->commit();
		
		$params["tab"] = $this->getRequest()->get("tab", 'cart');
		
		return RedirectResponse::create(
				URL::getInstance()->absoluteUrl(
						'/admin/offer/update/'.$offer_id, $params
						)
				);
	}
	
	public function updateAddress($offer_id)
	{		
		if (null !== $response = $this->checkAuth(array(AdminResources::MODULE), array('OfferCreation'), AccessManager::UPDATE)) {
			return $response;
		}
		
		$message = null;
	
		$orderUpdateAddress = new OrderUpdateAddress($this->getRequest());
	
		try { 
			$offer = OfferQuery::create()->filterById($offer_id)->findOne();
			
			if (null === $offer) {
				throw new \InvalidArgumentException("The offer you want to update does not exist");
			}
			
			$form = $this->validateForm($orderUpdateAddress, "post");
			
			$orderAddress = OrderAddressQuery::create()->findPk($form->get("id")->getData());

			if ($orderAddress->getId() !== $offer->getInvoiceOrderAddressId() && $orderAddress->getId() !== $offer->getDeliveryOrderAddressId()) {
				throw new \InvalidArgumentException("The offer address you want to update does not belong to the current offer not exist");
			}
			
			$event = new OrderAddressEvent(
					$form->get("title")->getData(),
					$form->get("firstname")->getData(),
					$form->get("lastname")->getData(),
					$form->get("address1")->getData(),
					$form->get("address2")->getData(),
					$form->get("address3")->getData(),
					$form->get("zipcode")->getData(),
					$form->get("city")->getData(),
					$form->get("country")->getData(),
					$form->get("phone")->getData(),
					$form->get("company")->getData(),
					$form->get("cellphone")->getData(),
					$form->get("state")->getData()
					);
			$event->setOrderAddress($orderAddress);
			
			$this->dispatch(TheliaEvents::ORDER_UPDATE_ADDRESS, $event);
		} catch (\Exception $e) {
			$message = $e->getMessage();
		}
		
		$params = array();
		
		if ($message) {
			$params["update_status_error_message"] = $message;
		}
		
		$params["tab"] = $this->getRequest()->get("tab", 'bill');
		
		return RedirectResponse::create(
				URL::getInstance()->absoluteUrl(
						'/admin/offer/update/'.$offer_id, $params
						)
				);
	}
	
	public function updateDeliveryRef($offer_id)
	{
		if (null !== $response = $this->checkAuth(array(AdminResources::MODULE), array('OfferCreation'), AccessManager::UPDATE)) {
			return $response;
		}
		
		$message = null;
		
		try {
			$offer = OfferQuery::create()->filterById($offer_id)->findOne();
			
			$deliveryRef = $this->getRequest()->get("delivery_ref");
			
			if (null === $offer) {
				throw new \InvalidArgumentException("The offer you want to update status does not exist");
			}
			
			$offer->setDeliveryRef($deliveryRef)->save();
			
		} catch (\Exception $e) {
			$message = $e->getMessage();
		}
		
		$params = array();
		
		if ($message) {
			$params["update_status_error_message"] = $message;
		}
		
		$params["tab"] = $this->getRequest()->get("tab", 'bill');
		
		return RedirectResponse::create(
				URL::getInstance()->absoluteUrl(
						'/admin/offer/update/'.$offer_id, $params
						)
				);
	}
	
	public function generateInvoicePdf($offer_id, $browser)
	{
		if (null !== $response = $this->checkAuth(array(AdminResources::MODULE), array('OfferCreation'), AccessManager::UPDATE)) {
			return $response;
		}
		return $this->generateBackOfficeOrderPdf($offer_id, ConfigQuery::read('pdf_invoice_file_offer', 'invoiceoffer'), $browser);
	}
	
	public function generateDeliveryPdf($offer_id, $browser)
	{
		if (null !== $response = $this->checkAuth(array(AdminResources::MODULE), array('OfferCreation'), AccessManager::UPDATE)) {
			return $response;
		}
		return $this->generateBackOfficeOrderPdf($offer_id, ConfigQuery::read('pdf_delivery_file_offer', 'deliveryoffer'), $browser);
	}
	
	private function generateBackOfficeOrderPdf($offer_id, $fileName, $browser)
	{
		if (null === $response = $this->generateOrderPdf($offer_id, $fileName, true, true, $browser)) {
			return RedirectResponse::create(
					URL::getInstance()->absoluteUrl(
							'/admin/offer/update/'.$offer_id
							)
					);
		}
		
		return $response;
	}
	
	/**
	 * @param int $offer_id
	 * @param string $fileName
	 * @param bool $checkOrderStatus
	 * @param bool $checkAdminUser
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	protected function generateOrderPdf($offer_id, $fileName, $checkOrderStatus = true, $checkAdminUser = true, $browser = false)
	{
		$offer = OfferQuery::create()->filterById($offer_id)->findOne();
		
		// check if the order has the paid status
		if ($checkAdminUser && !$this->getSecurityContext()->hasAdminUser()) {
			if ($checkOrderStatus && !$offer->isPaid(false)) {
				throw new NotFoundHttpException();
			}
		}
		
		$html = $this->renderRaw(
				$fileName,
				array(
						'offer_id' => $offer_id
				),
				$this->getTemplateHelper()->getActivePdfTemplate()
				);

		try {
			$pdfEvent = new PdfEvent($html);
			
			$this->dispatch(TheliaEvents::GENERATE_PDF, $pdfEvent);
			
			if ($pdfEvent->hasPdf()) {
				return $this->pdfResponse($pdfEvent->getPdf(), $offer->getRef(), 200, $browser);
			}
		} catch (\Exception $e) {
			Tlog::getInstance()->error(
					sprintf(
							'error during generating invoice pdf for offer id : %d with message "%s"',
							$offer_id,
							$e->getMessage()
							)
					);
		}
		
		throw new TheliaProcessException(
				$this->getTranslator()->trans(
						"We're sorry, this PDF invoice is not available at the moment."
						)
				);
	}
}
