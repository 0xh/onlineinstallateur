<?php

namespace Front\Controller;

use Front\Front;
use Symfony\Component\HttpFoundation\Request;
use Thelia\Controller\Front\BaseFrontController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Thelia\Core\Event\TheliaEvents;
use Thelia\Model\AddressQuery;
use Thelia\Core\Event\Order\OrderEvent;
use Thelia\Model\OrderPostage;
use Thelia\Core\Event\Cart\CartEvent;
use Thelia\Form\Definition\FrontForm;
use Thelia\Log\Tlog;

class KlimaKonfiguratorController extends BaseFrontController {
	
	public function suggestionsAction(Request $request) {

		//TODO sequence diagramm with the operations starting from konfigurator form and ending to the response products
		if ($request->isXmlHttpRequest ()) {
			$view = $request->get ( 'ajax-view', "includes/klimakonfigurator-suggestions" );
			$request->attributes->set ( '_view', $view );
		}
		else 
		{	
		return new JsonResponse ( array ('klimastuff' => 'more klimastuff') ); // $productsQuerry->__toString()
		}
	}
	
	public function addKlimaSet(Request $request){

		$cartAdd = $this->getAddCartForm($request);
		
		$message = null;
		
		try {
			$form = $this->validateForm($cartAdd);
		
			$cartEvent = $this->getCartEvent();
				
			$cartEvent->bindForm($form);
		
			$log = Tlog::getInstance ();
				
			$this->getDispatcher()->dispatch(TheliaEvents::CART_ADDITEM, $cartEvent);
		
			$this->afterModifyCart();
			
			//add klima set products
			$set_product_ids = $request->request->get('set_product');
			if($set_product_ids != null){
				$set_product_sale_ids = $request->request->get('set_product_sale_elements_id');
				$quantities = $request->request->get('set_quantity');
				$nr_set_products = count($set_product_ids);
				if($nr_set_products > 0)
					for ($i = 1; $i<=$nr_set_products; $i++){
						if($set_product_ids[$i]){
							//$log->debug ( "-- service_appointment ".$set_product_ids[$i]." ".(new JsonResponse($request->request->all()))." ");
							//$sp_start_ts	." ".implode(" ",$sp_end_ts)." ".implode(" ",$sp_date));
							$this->addSetProductToCart($set_product_ids[$i], $set_product_sale_ids[$i],$quantities[$i],$request);
						}
				};
			}			
			
				if ($this->getRequest()->isXmlHttpRequest()) {
					$this->changeViewForAjax();
				} elseif (null !== $response = $this->generateSuccessRedirect($cartAdd)) {
					return $response;
				}
		
		} catch (PropelException $e) {
			Tlog::getInstance()->error(sprintf("Failed to add item to cart with message : %s", $e->getMessage()));
			$message = $this->getTranslator()->trans(
					"Failed to add this article to your cart, please try again",
					[],
					Front::MESSAGE_DOMAIN
					);
		} catch (FormValidationException $e) {
			$message = $e->getMessage();
		}
		
		if ($message) {
			$cartAdd->setErrorMessage($message);
			$this->getParserContext()->addForm($cartAdd);
		}		
		
		
	}
	
	protected function addSetProductToCart($id,$product_sale_id,$quantity,Request $request){
		$log = Tlog::getInstance ();
		$log->debug ( "-- addsetproduct " );
	
		$message = null;
	
		try {
			$cartEvent = $this->getCartEvent();
			$cartEvent->setProduct($id);
			$cartEvent->setAppend(1);
			$cartEvent->setProductSaleElementsId($product_sale_id);
			$cartEvent->setQuantity($quantity);
							
			$this->getDispatcher()->dispatch(TheliaEvents::CART_ADDITEM, $cartEvent);

			$this->afterModifyCart();
	
			if ($this->getRequest()->isXmlHttpRequest()) {
				$this->changeViewForAjax();
			}
	
		} catch (PropelException $e) {
			Tlog::getInstance()->error(sprintf("Failed to add item to cart with message : %s", $e->getMessage()));
			$message = $this->getTranslator()->trans(
					"Failed to add this article to your cart, please try again",
					[],
					Front::MESSAGE_DOMAIN
					);
		} catch (FormValidationException $e) {
			$message = $e->getMessage();
		}
	
		if ($message) {
			$cartAdd->setErrorMessage($message);
			$this->getParserContext()->addForm($cartAdd);
		}
	}	

	protected function changeViewForAjax()
	{
		// If Ajax Request
		if ($this->getRequest()->isXmlHttpRequest()) {
			$request = $this->getRequest();
	
			$view = $request->get('ajax-view', "includes/mini-cart");//konfigurator
			//$log = Tlog::getInstance();
			//$log->debug("carcontroller ".implode(" ", $request->attributes->all()));
			$request->attributes->set('_view', $view);
		}
	}
	
	/**
	 * @return \Thelia\Core\Event\Cart\CartEvent
	 */
	protected function getCartEvent()
	{
		$cart = $this->getSession()->getSessionCart($this->getDispatcher());
	
		return new CartEvent($cart);
	}
	
	/**
	 * Find the good way to construct the cart form
	 *
	 * @param  Request $request
	 * @return CartAdd
	 */
	private function getAddCartForm(Request $request)
	{
		if ($request->isMethod("post")) {
			$cartAdd = $this->createForm(FrontForm::CART_ADD);
		} else {
			$cartAdd = $this->createForm(
					FrontForm::CART_ADD,
					"form",
					array(),
					array(
							'csrf_protection'   => false,
					),
					$this->container
					);
		}
	
		return $cartAdd;
	}
	
	protected function afterModifyCart()
	{
		/* recalculate postage amount */
		$order = $this->getSession()->getOrder();
		if (null !== $order) {
			$deliveryModule = $order->getModuleRelatedByDeliveryModuleId();
			$deliveryAddress = AddressQuery::create()->findPk($order->getChoosenDeliveryAddress());
	
			if (null !== $deliveryModule && null !== $deliveryAddress) {
				$moduleInstance = $deliveryModule->getDeliveryModuleInstance($this->container);
	
				$orderEvent = new OrderEvent($order);
	
				try {
					$postage = OrderPostage::loadFromPostage(
							$moduleInstance->getPostage($deliveryAddress->getCountry())
							);
	
					$orderEvent->setPostage($postage->getAmount());
					$orderEvent->setPostageTax($postage->getAmountTax());
					$orderEvent->setPostageTaxRuleTitle($postage->getTaxRuleTitle());
	
					$this->getDispatcher()->dispatch(TheliaEvents::ORDER_SET_POSTAGE, $orderEvent);
				} catch (DeliveryException $ex) {
					// The postage has been chosen, but changes in the cart causes an exception.
					// Reset the postage data in the order
					$orderEvent->setDeliveryModule(0);
	
					$this->getDispatcher()->dispatch(TheliaEvents::ORDER_SET_DELIVERY_MODULE, $orderEvent);
				}
			}
		}
	}

}
