<?php
namespace AmazonIntegration\Controller\Front;

use AmazonIntegration\Model\AmazonOrderProduct;
use AmazonIntegration\Model\AmazonOrders;
use AmazonIntegration\Model\AmazonOrdersQuery;
use AmazonIntegration\Model\ProductAmazonQuery;
use AmazonIntegration\Model\Map\AmazonOrdersTableMap;
use function Composer\Autoload\includeFile;
use Propel\Runtime\Propel;
use Thelia\Controller\Front\BaseFrontController;
use Thelia\Log\Tlog;
use Thelia\Model\CountryQuery;
use Thelia\Model\CurrencyQuery;
use Thelia\Model\Customer;
use Thelia\Model\CustomerQuery;
use Thelia\Model\LangQuery;
use Thelia\Model\Order;
use Thelia\Model\OrderAddress;
use Thelia\Model\OrderAddressQuery;
use Thelia\Model\OrderProduct;
use Thelia\Model\Product;
use Thelia\Model\ProductI18n;
use Thelia\Model\ProductPrice;
use Thelia\Model\ProductQuery;
use Thelia\Model\ProductSaleElements;
use Thelia\Model\ProductSaleElementsQuery;
use Thelia\Tools\I18n;

class AmazonFrontIntegrationContoller extends BaseFrontController
{

	/* @var Tlog $log */
	protected static $logger;
	
    public function blockJs()
    {
        return $this->render("AmazonIntegrationTemplate-js");
    }

    public function viewAction()
    {
        // echo "<pre>";
        // include __DIR__.'/../../Classes/API/src/MarketplaceWebServiceOrders/Samples/GetServiceStatusSample.php';
        
        // include __DIR__.'/../../Classes/API/src/MarketplaceWebServiceOrders/Samples/ListOrdersSample.php';
        
        // include __DIR__.'/../../Classes/API/src/MarketplaceWebServiceOrders/Samples/ListOrdersByNextTokenSample.php';
        $orders = array();
        
        $amazonOrdersQuery = new AmazonOrdersQuery();
        $ords = $amazonOrdersQuery->findById("*");
        
        foreach ($ords as $ord) {
            
            array_push($orders, array(
                'AmazonOrderId' => $ord->getId(),
                'PurchaseDate' => $ord->getPurchaseDate()->format('Y-m-d H:i:s'),
                'OrderStatus' => $ord->getOrderStatus(),
                'OrderTotal' => $ord->getOrderTotalAmount() . " " . $ord->getOrderTotalCurrencyCode(),
                'MarketplaceId' => $ord->getMarketplaceId(),
                'SalesChannel' => $ord->getSalesChannel(),
            ));
            
        }
        
        return $this->render("AmazonIntegrationTemplate", array(
            "orders" => $orders
        ));
    }

    public function saveAsinFromAmazon()
    {
        $productSaleElements = new ProductSaleElementsQuery();
        $eanArray = array();
        
        $prods = $productSaleElements->findByEanCode("*");
        foreach ($prods as $value) {
            if ($value->getEanCode()) {
                array_push($eanArray, array(
                    "eanCode" => $value->getEanCode(),
                    "productId" => $value->getProductId(),
                    "ref" => $value->getRef()
                ));
            }
        }
        
        $max_time = ini_get("max_execution_time");
        ini_set('max_execution_time', 3000);
        
        include __DIR__ . '/../../Classes/API/src/MarketplaceWebServiceOrders/Samples/GetMatchingProductForIdSample.php';
        
        ini_set('max_execution_time', $max_time);
        
        die("Finish insert ASIN from Amazon.");
    }

    public function getServiceForOrdersAction()
    {
        include __DIR__ . '/../../Classes/API/src/MarketplaceWebServiceOrders/Samples/GetServiceStatusSample.php';
        
        echo json_encode($orders);
        die();
    }

    public function getServiceForProductsAction()
    {
        include __DIR__ . '/../../Classes/API/src/MarketplaceWebServiceOrders/Products/MarketplaceWebServiceProducts/Samples/GetServiceStatusSample.php';
        
        echo json_encode($productService);
        die();
    }

    public function saveAmazonOrders()
    {
    	$this->getLogger()->error("import started");
    	
    	include __DIR__ . '/../../Classes/API/src/MarketplaceWebServiceOrders/Samples/ListOrderItemsSample.php';

        $_SESSION['finishedToGetOrders'] = false;
        
        if (! isset($_SESSION['nxtToken'])) {
            include __DIR__ . '/../../Classes/API/src/MarketplaceWebServiceOrders/Samples/ListOrdersSample.php';
          } else
            include __DIR__ . '/../../Classes/API/src/MarketplaceWebServiceOrders/Samples/ListOrdersByNextTokenSample.php';
        
        $con = Propel::getConnection(AmazonOrdersTableMap::DATABASE_NAME);
        
       
        $max_time = ini_get("max_execution_time");
        ini_set('max_execution_time', 20000);
            
        if ($orders) {
            foreach ($orders as $i => $order) {
            	$con->beginTransaction();
            	
            	
                
                 //Verify (by email) if customer exists in customer thelia table
                 // if exists -> get the customer Id
                 // if not -> create a new customer
                 //amazonCanceled customer - default customer user for all canceled orders from amazon
                 
                if (isset($order->BuyerEmail)) {
                    $buyerEmail = $order->BuyerEmail;
                } else {
                    $buyerEmail = 'amazoncanceled@hausfabrik.at';
                }
                
                $this->getLogger()->error("amazonOrderId ".isset($order->AmazonOrderId) ? $order->AmazonOrderId : 'noOrderId'.
                		" canceled ".(isset($order->BuyerEmail) ? " no " : " yes "));
                
                $checkCustomerId = CustomerQuery::create()->select('id')
                    ->filterByEmail($buyerEmail)
                    ->findOne();
                
                if ($checkCustomerId) {
                    $customerId = $checkCustomerId;
                } else {
                    if (isset($order->BuyerName)) {
                        $name = preg_split('/\s+/', $order->BuyerName);
                        $firstName = $name[0];
                        if (isset($name[1])) {
                            if (isset($name[2]))
                                $lastName = $name[1] . ' ' . $name[2];
                            else
                                $lastName = $name[1];
                        } else {
                            $lastName = '';
                        }
                    } else if ($buyerEmail == 'amazoncanceled@hausfabrik.at') {
                        $firstName = 'canceled';
                        $lastName = 'canceled';
                    } else {
                        $firstName = '';
                        $lastName = '';
                    }
                    
                    $customer = new Customer();
                    
                    $customer->setTitleId('1')
                        ->setFirstname($firstName)
                        ->setLastname($lastName)
                        ->setEmail($buyerEmail);
                    $customer->save($con);
                    
                    $customerId = $customer->getId();
                    
                    $this->getLogger()->error(" create customer ".$customerId." : ".isset($order->BuyerName) ? $order->BuyerName : " canceled ");
                }
                
                
                //  Check if amazon order exists in amazon_orders table
                //  if doesn't exist
                //  -> insert shipping address
                //  -> insert order
                 
                
                $checkAmazonOrder = AmazonOrdersQuery::create()->filterById($order->AmazonOrderId)->findOne();
                
                if ($checkAmazonOrder) {
                    if ($checkAmazonOrder->getOrderStatus() !== $order->OrderStatus) {
                        $checkAmazonOrder->setOrderStatus($order->OrderStatus)->save($con);
                        $this->getLogger()->error(" update status ".$order->OrderStatus);
                    }
                } else {
                    // check if exist canceled destination order address - unique for all canceled orders
                    $checkOrderAddress = OrderAddressQuery::create()->select('id')
                        ->filterByAddress1('canceled destination')
                        ->findOne();
                    
                    if ($order->OrderStatus == 'Canceled' && $checkOrderAddress) {
                        $orderAddressId = $checkOrderAddress;
                    } else {
                        // Insert shipping address from amazon to order address thelia
                        if (isset($order->ShippingAddress->Name)) {
                            $name = preg_split('/\s+/', $order->ShippingAddress->Name);
                            $firstName = $name[0];
                            if (isset($name[1])) {
                                if (isset($name[2]))
                                    $lastName = $name[1] . ' ' . $name[2];
                                else
                                    $lastName = $name[1];
                            } else {
                                $lastName = '';
                            }
                        } else if ($order->OrderStatus == 'Canceled') {
                            $firstName = 'canceled';
                            $lastName = 'canceled';
                        } else {
                            $firstName = '';
                            $lastName = '';
                        }
                        
                        if (isset($order->ShippingAddress->AddressLine2))
                            $address = $order->ShippingAddress->AddressLine2;
                        else if ($order->OrderStatus == 'Canceled')
                            $address = 'canceled destination';
                        else
                            $address = '';
                        
                        if (isset($order->ShippingAddress->CountryCode)) {
                            $countryId = CountryQuery::create()->select('id')
                                ->filterByIsoalpha2($order->ShippingAddress->CountryCode)
                                ->findOne();
                        } else {
                            $countryId = '13';
                        }
                        
                        $orderAddress = new OrderAddress();
                        $orderAddress->setCustomerTitleId('1')
                            ->setFirstName($firstName)
                            ->setLastname($lastName)
                            ->setAddress1($address)
                            ->setCity(isset($order->ShippingAddress->City) ? $order->ShippingAddress->City : '')
                            ->setZipcode(isset($order->ShippingAddress->PostalCode) ? $order->ShippingAddress->PostalCode : '')
                            ->setCountryId($countryId);
                        $orderAddress->save($con);
                        
                        $orderAddressId = $orderAddress->getId();
                    }
                    
                    // order table
	                    switch ($order->OrderStatus) {
	                    	case 'Canceled':
	                    		$statusId = '5';
	                    		break;
	                    	case 'Pending':
	                    		$statusId = '1';
	                    		break;
	                    	case 'Unshipped':
	                    		$statusId = '3';
	                    		break;
	                    	case 'Shipped':
	                    		$statusId = '4';
	                    		break;
	                    	default:
	                    		$statusId = '1';
	                    		break;
	                    }
	                    
	                    $salesChannelId = explode(".", $order->SalesChannel);
	                    $marketplaceCode = $salesChannelId[count($salesChannelId)-1];//co.uk
	                    
	                    
	                    $lang = LangQuery::create()
	                    ->filterByCode($marketplaceCode)
	                    ->findOne();
	                    
	                    if($lang)
	                    	$langId = $lang->getId();
                    	else
                    	{
                    		$lang = LangQuery::create()
                    		->filterByCode("en")
                    		->findOne();
                    		$langId = $lang->getId();
                    	}
                    		
                    		
                    	if(isset($order->OrderTotal->CurrencyCode))	{
	                    	$currency = CurrencyQuery::create()
	                    		->filterByCode($order->OrderTotal->CurrencyCode)
	                    		->findOne();
	                    		
	                    	if($currency) {
	                    		$currencyId = $currency->getId();
	                    		$currencyRate = $currency->getRate();
	                    	}
	                    	else{
	                    		$currencyId = '1';
	                    		$currencyRate = '1';
	                    	}
                    	}
                    	else {
                    		$currencyId = '1';
                    		$currencyRate = '1';
                    	}
                    	
                    	$marketplace = strtoupper($marketplaceCode);
                    	$this->getRequest()->getSession()->set(
                    			"marketplace",
                    			$marketplace
                    			);
                    	
                    	/** @var \Thelia\Model\Order $newOrder*/
                    	$newOrder = new Order();
                    	$newOrder
                    		->setCustomerId($customerId)
                    		->setCurrencyId($currencyId)
                    		->setCurrencyRate($currencyRate)
                    		->setStatusId($statusId)
                    		->setLangId($langId)
                    		->setPaymentModuleId('41')
                    		->setDeliveryOrderAddressId($orderAddressId)
                    		->setInvoiceOrderAddressId($orderAddressId)
                    		->setDeliveryModuleId('2')
                    		->setPostage('')
                    		->setPostageTax('')
                    		->setInvoiceDate($order->PurchaseDate)
                    		->setDispatcher($this->getDispatcher())
                    		;
                    			
                    	$newOrder->save($con);
                    	$this->getLogger()->error(" order ".$newOrder->__toString());
           
                    $orderId = $newOrder->getId();
                    
                    // Insert order from amazon to amazon_orders table
                    /** @var \AmazonOrders $amazonOrder*/
                    $amazonOrder = new AmazonOrders();
                    $amazonOrder->setId(isset($order->AmazonOrderId) ? $order->AmazonOrderId : '')
                        ->setSellerOrderId(isset($order->SellerOrderId) ? $order->SellerOrderId : '')
                        ->setPurchaseDate(isset($order->PurchaseDate) ? $order->PurchaseDate : '')
                        ->setLastUpdateDate(isset($order->LastUpdateDate) ? $order->LastUpdateDate : '')
                        ->setOrderStatus(isset($order->OrderStatus) ? $order->OrderStatus : '')
                        ->setFulfillmentChannel(isset($order->FulfillmentChannel) ? $order->FulfillmentChannel : '')
                        ->setSalesChannel(isset($order->SalesChannel) ? $order->SalesChannel : '')
                        ->setOrderChannel(isset($order->OrderChannel) ? $order->OrderChannel : '')
                        ->setShipServiceLevel(isset($order->ShipServiceLevel) ? $order->ShipServiceLevel : '')
                        ->setOrderTotalCurrencyCode(isset($order->OrderTotal->CurrencyCode) ? $order->OrderTotal->CurrencyCode : '')
                        ->setOrderTotalAmount(isset($order->OrderTotal->Amount) ? $order->OrderTotal->Amount : '')
                        ->setNumberOfItemsShipped(isset($order->NumberOfItemsShipped) ? $order->NumberOfItemsShipped : '')
                        ->setNumberOfItemsUnshipped(isset($order->NumberOfItemsUnshipped) ? $order->NumberOfItemsUnshipped : '')
                        ->setPaymentExecutionDetailCurrencyCode(isset($order->PaymentExecutionDetail->PaymentExecutionDetailItem->Payment->CurrencyCode) ? $order->PaymentExecutionDetail->PaymentExecutionDetailItem->Payment->CurrencyCode : '')
                        ->setPaymentExecutionDetailTotalAmount(isset($order->PaymentExecutionDetail->PaymentExecutionDetailItem->Payment->Amount) ? $order->PaymentExecutionDetail->PaymentExecutionDetailItem->Payment->Amount : '')
                        ->setPaymentExecutionDetailPaymentMethod(isset($order->PaymentExecutionDetail->PaymentExecutionDetailItem->PaymentMethod) ? $order->PaymentExecutionDetail->PaymentExecutionDetailItem->PaymentMethod : '')
                        ->setPaymentMethod(isset($order->PaymentMethod) ? $order->PaymentMethod : '')
                        ->setPaymentMethodDetail(isset($order->PaymentMethodDetails->PaymentMethodDetail) ? $order->PaymentMethodDetails->PaymentMethodDetail : '')
                        ->setMarketplaceId(isset($order->MarketplaceId) ? $order->MarketplaceId : '')
                        ->setBuyerCounty(isset($order->BuyerCounty) ? $order->BuyerCounty : '')
                        ->setBuyerTaxInfoCompany(isset($order->BuyerTaxInfo->CompanyLegalName) ? $order->BuyerTaxInfo->CompanyLegalName : '')
                        ->setBuyerTaxInfoTaxingRegion(isset($order->BuyerTaxInfo->TaxingRegion) ? $order->BuyerTaxInfo->TaxingRegion : '')
                        ->setBuyerTaxInfoTaxName(isset($order->BuyerTaxInfo->TaxClassifications->TaxClassification->Name) ? $order->BuyerTaxInfo->TaxClassifications->TaxClassification->Name : '')
                        ->setBuyerTaxInfoTaxValue(isset($order->BuyerTaxInfo->TaxClassifications->TaxClassification->Value) ? $order->BuyerTaxInfo->TaxClassifications->TaxClassification->Value : '')
                        ->setShipmentServiceLevelCategory(isset($order->ShipmentServiceLevelCategory) ? $order->ShipmentServiceLevelCategory : '')
                        ->setShippedByAmazonTfm(isset($order->ShippedByAmazonTFM) && ($order->ShippedByAmazonTFM == true) ? 1 : 0)
                        ->setTfmShipmentStatus(isset($order->TFMShipmentStatus) ? $order->TFMShipmentStatus : '')
                        ->setCbaDisplayableShippingLabel(isset($order->CbaDisplayableShippingLabel) ? $order->CbaDisplayableShippingLabel : '')
                        ->setOrderType(isset($order->OrderType) ? $order->OrderType : '')
                        ->setEarliestShipDate(isset($order->EarliestShipDate) ? $order->EarliestShipDate : '')
                        ->setLatestShipDate(isset($order->LatestShipDate) ? $order->LatestShipDate : '')
                        ->setEarliestDeliveryDate(isset($order->EarliestDeliveryDate) ? $order->EarliestDeliveryDate : '')
                        ->setLatestDeliveryDate(isset($order->LatestDeliveryDate) ? $order->LatestDeliveryDate : '')
                        ->setIsBusinessOrder(isset($order->IsBusinessOrder) && $order->IsBusinessOrder == true ? 1 : 0)
                        ->setPurchaseOrderNumber(isset($order->PurchaseOrderNumber) ? $order->PurchaseOrderNumber : '')
                        ->setIsPrime(isset($order->IsPrime) && $order->IsPrime == true ? 1 : 0)
                        ->setIsPremiumOrder(isset($order->IsPremiumOrder) && $order->IsPremiumOrder == true ? 1 : 0)
                        ->setReplacedOrderId(isset($order->ReplacedOrderId) ? $order->ReplacedOrderId : '')
                        ->setIsReplacementOrder(isset($order->IsReplacementOrder) && $order->IsReplacementOrder == true ? 1 : 0)
                        ->setOrderAddressId($orderAddressId)
                        ->setCustomerId($customerId)
                        ->setOrderId($orderId);
                    
                    $amazonOrder->save($con);
                    
                  //  $this->getLogger()->error(" amazonOrder ".$amazonOrder->__toString());
                   
                    // get products for each order from amazon
                    $amazonOrderId = $order->AmazonOrderId;
                   // $amazonOrderId = '305-3292380-9658727';

                    $productsOrderItem = invokeListOrderItems($service, $amazonOrderId);

                    sleep(2); 
                  
                   
                    $totalPostage = 0;
            
                    if(isset($productsOrderItem->OrderItem)) {
	                    $orderProduct = $productsOrderItem->OrderItem;
	                    if(is_array($orderProduct)){ 
	                    	$orderProducts = $orderProduct;
	                    	foreach($orderProducts as $orderProduct){
	                    		
	                    		if(isset($orderProduct->ShippingPrice->Amount))
	                    			$totalPostage += $orderProduct->ShippingPrice->Amount;
	                    		else 
	                    			$totalPostage += 0;
	                    		
	                    		$productId = ProductAmazonQuery::create()
	                    			->select('product_id')
	                    			->filterByASIN($orderProduct->ASIN)
	                    			->findOne();
	                    		
	                    		if(!$productId){
	                    			if(isset($orderProduct->SellerSKU))
		                    			$productId = ProductQuery::create()
			                    			->select('id')
			                    			->filterByRef($orderProduct->SellerSKU)
			                    			->findOne();
	                    			
			                    	if(!$productId)
	                    				$productId = $this->saveProducts($orderProduct, $lang, $con);
			                    	
	                    			$productUpdateAsin = ProductAmazonQuery::create()
	                    				->filterByProductId($productId)
	                    				->findOne();
	                    			
	                    			if($productUpdateAsin)
		                    			$productUpdateAsin->setASIN($orderProduct->ASIN)
		                    				->save($con);
	                    		}
	                    		$productSaleElement = ProductSaleElementsQuery::create()
	                    		->filterByProductId($productId)
	                    		->findOne();
	                    		
	                    		$product = ProductQuery::create()
	                    		->filterById($productId)
	                    		->findOne();
	                    		
	                    		/* get translation */
	                    		/** @var ProductI18n $productI18n */
	                    		$productI18n = I18n::forceI18nRetrieving($lang->getLocale(), 'Product', $product->getId());
	                    		
	                    		/* get tax */
	                    		/** @var TaxRuleI18n $taxRuleI18n */
	                    		$taxRuleI18n = I18n::forceI18nRetrieving($lang->getLocale(), 'TaxRule', $product->getTaxRuleId());
	                    		
	                 
	                    		$newOrderProduct = new OrderProduct();
	                    		$newOrderProduct
	                    		->setOrderId($newOrder->getId())
	                    		->setProductRef($product->getRef())
	                    		->setProductSaleElementsRef($productSaleElement->getRef())
	                    		->setProductSaleElementsId($productSaleElement->getId())
	                    		->setTitle($productI18n->getTitle())
	                    		->setChapo($productI18n->getChapo())
	                    		->setDescription($productI18n->getDescription())
	                    		->setPostscriptum($productI18n->getPostscriptum())
	                    		->setVirtual('')
	                    		->setVirtualDocument('')
	                    		->setQuantity( isset($orderProduct->QuantityShipped) ? $orderProduct->QuantityShipped : '')
	                    		->setPrice( isset($orderProduct->ItemPrice->Amount) ? $orderProduct->ItemPrice->Amount : '')
	                    		->setPromoPrice( isset($orderProduct->ItemPrice->Amount) ? $orderProduct->ItemPrice->Amount : '')
	                    		->setWasNew('')
	                    		->setWasInPromo('')
	                    		->setWeight($productSaleElement->getWeight())
	                    		->setTaxRuleTitle($taxRuleI18n->getTitle())
	                    		->setTaxRuleDescription($taxRuleI18n->getDescription())
	                    		->setEanCode($productSaleElement->getEanCode())
	                    		->save($con);
	                    		
	                    		
	                    		// Insert products from amazon to amazon_orders_product table
	                    		$orderProductId = $newOrderProduct->getId();
	                    		
	                    		/** @var \AmazonOrderProduct $amazonOrderProduct*/
	                    		$amazonOrderProduct = new AmazonOrderProduct();
	                    		$amazonOrderProduct
	                    		->setOrderItemId( isset($orderProduct->OrderItemId) ? $orderProduct->OrderItemId: '')
	                    		->setAmazonOrderId($amazonOrderId)
	                    		->setAsin( isset($orderProduct->ASIN) ? $orderProduct->ASIN : '')
	                    		->setSellerSku( isset($orderProduct->SellerSKU) ? $orderProduct->SellerSKU : '')
	                    		->setTitle( isset($orderProduct->Title) ? $orderProduct->Title : '')
	                    		->setQuantityOrdered( isset($orderProduct->QuantityOrdered) ? $orderProduct->QuantityOrdered : '')
	                    		->setQuantityShipped( isset($orderProduct->QuantityShipped) ? $orderProduct->QuantityShipped : '')
	                    		->setPointsGrantedNumber( isset($orderProduct->PointsGranted->PointsNumber) ? $orderProduct->PointsGranted->PointsNumber : '')
	                    		->setPointsGrantedCurrencyCode( isset($orderProduct->PointsGranted->PointsMonetaryValue->CurrencyCode) ? $orderProduct->PointsGranted->PointsMonetaryValue->CurrencyCode : '')
	                    		->setPointsGrantedAmount( isset($orderProduct->PointsGranted->PointsMonetaryValue->Amount) ? $orderProduct->PointsGranted->PointsMonetaryValue->Amount : '')
	                    		->setItemPriceCurrencyCode( isset($orderProduct->ItemPrice->CurrencyCode) ? $orderProduct->ItemPrice->CurrencyCode : '')
	                    		->setItemPriceAmount( isset($orderProduct->ItemPrice->Amount) ? $orderProduct->ItemPrice->Amount : '')
	                    		->setShippingPriceCurrencyCode( isset($orderProduct->ShippingPrice->CurrencyCode) ? $orderProduct->ShippingPrice->CurrencyCode : '')
	                    		->setShippingPriceAmount( isset($orderProduct->ShippingPrice->Amount) ? $orderProduct->ShippingPrice->Amount : '')
	                    		->setGiftWrapPriceCurrencyCode( isset($orderProduct->GiftWrapPrice->CurrencyCode) ? $orderProduct->GiftWrapPrice->CurrencyCode : '')
	                    		->setGiftWrapPriceAmount( isset($orderProduct->GiftWrapPrice->Amount) ? $orderProduct->GiftWrapPrice->Amount : '')
	                    		->setItemTaxCurrencyCode( isset($orderProduct->ItemTax->CurrencyCode) ? $orderProduct->ItemTax->CurrencyCode : '')
	                    		->setItemTaxAmount( isset($orderProduct->ItemTax->Amount) ? $orderProduct->ItemTax->Amount : '')
	                    		->setShippingTaxCurrencyCode( isset($orderProduct->ShippingTax->CurrencyCode) ? $orderProduct->ShippingTax->CurrencyCode : '')
	                    		->setShippingTaxAmount( isset($orderProduct->ShippingTax->Amount) ? $orderProduct->ShippingTax->Amount : '')
	                    		->setGiftWrapTaxCurrencyCode( isset($orderProduct->GiftWrapTax->CurrencyCode) ? $orderProduct->GiftWrapTax->CurrencyCode : '')
	                    		->setGiftWrapTaxAmount( isset($orderProduct->GiftWrapTax->Amount) ? $orderProduct->GiftWrapTax->Amount : '')
	                    		->setShippingDiscountCurrencyCode( isset($orderProduct->ShippingDiscount->CurrencyCode) ? $orderProduct->ShippingDiscount->CurrencyCode : '')
	                    		->setShippingDiscountAmount( isset($orderProduct->ShippingDiscount->Amount) ? $orderProduct->ShippingDiscount->Amount : '')
	                    		->setPromotionDiscountCurrencyCode( isset($orderProduct->PromotionDiscount->CurrencyCode) ? $orderProduct->PromotionDiscount->CurrencyCode : '')
	                    		->setPromotionDiscountAmount( isset($orderProduct->PromotionDiscount->Amount) ? $orderProduct->PromotionDiscount->Amount : '')
	                    		->setPromotionId( isset($orderProduct->PromotionIds->PromotionId) ? $orderProduct->PromotionIds->PromotionId : '')
	                    		->setCodFeeCurrencyCode( isset($orderProduct->CODFee->CurrencyCode) ? $orderProduct->CODFee->CurrencyCode : '')
	                    		->setCodFeeAmount( isset($orderProduct->CODFee->Amount) ? $orderProduct->CODFee->Amount : '')
	                    		->setCodFeeDiscountCurrencyCode( isset($orderProduct->CODFeeDiscount->CurrencyCode) ? $orderProduct->CODFeeDiscount->CurrencyCode : '')
	                    		->setCodFeeDiscountAmount( isset($orderProduct->CODFeeDiscount->Amount) ? $orderProduct->CODFeeDiscount->Amount : '')
	                    		->setGiftMessageText( isset($orderProduct->GiftMessageText) ? $orderProduct->GiftMessageText : '')
	                    		->setGiftWrapLevel( isset($orderProduct->GiftWrapLevel) ? $$orderProduct->GiftWrapLevel : '')
	                    		->setInvoiceRequirement( isset($orderProduct->InvoiceData->InvoiceRequirement) ?  $orderProduct->InvoiceData->InvoiceRequirement : '')
	                    		->setBuyerSelectedInvoiceCategory( isset($orderProduct->InvoiceData->BuyerSelectedInvoiceCategory) ? $orderProduct->InvoiceData->BuyerSelectedInvoiceCategory : '')
	                    		->setInvoiceTitle( isset($orderProduct->InvoiceData->InvoiceTitle) ? $orderProduct->InvoiceData->InvoiceTitle : '')
	                    		->setInvoiceInformation( isset($orderProduct->InvoiceData->InvoiceInformation) ? $orderProduct->InvoiceData->InvoiceInformation : '')
	                    		->setConditionNote( isset($orderProduct->ConditionNote) ? $orderProduct->ConditionNote: '')
	                    		->setConditionId( isset($orderProduct->ConditionId) ? $orderProduct->ConditionId : '')
	                    		->setConditionSubtypeId( isset($orderProduct->ConditionSubtypeId) ? $orderProduct->ConditionSubtypeId : '')
	                    		->setScheduledDeliveryStartDate( isset($orderProduct->ScheduledDeliveryStartDate) ? $orderProduct->ScheduledDeliveryStartDate : '')
	                    		->setScheduledDeliveryEndDate( isset($orderProduct->ScheduledDeliveryEndDate) ? $orderProduct->ScheduledDeliveryEndDate : '')
	                    		->setPriceDesignation( isset($orderProduct->PriceDesignation) ? $orderProduct->PriceDesignation : '')
	                    		->setBuyerCustomizedURL( isset($orderProduct->BuyerCustomizedInfo->CustomizedURL) ? $orderProduct->BuyerCustomizedInfo->CustomizedURL : '')
	                    		->setOrderProductId($orderProductId)
	                    		->setAmazonOrderId($amazonOrderId)
	                    		;
	                    		
	                    		$amazonOrderProduct->save($con);
	                    		
	                    		$this->getLogger()->error(" amazonOrderProduct ".(isset($orderProduct->OrderItemId) ? $orderProduct->OrderItemId: ''));
	                    		
	                    	}
	                    }// if more products in an order
	                    
	                    //only one product 
	                    else {                  
	                    	
	                    	if(isset($orderProduct->ShippingPrice->Amount))
	                    		$totalPostage = $orderProduct->ShippingPrice->Amount;
	                    	
	                    	$productId = ProductAmazonQuery::create()
	                    		->select('product_id')
	                    		->filterByASIN($orderProduct->ASIN)
	                    		->findOne();
	                    	
	                    	if(!$productId){ 
	                    		if(isset($orderProduct->SellerSKU)) {
	                    			$productId = ProductQuery::create()
		                    			->select('id')
		                    			->filterByRef($orderProduct->SellerSKU)
		                    			->findOne();
		                    		
	                    		}	
	                    		
                    			if(!$productId)
                    				$productId = $this->saveProducts($orderProduct, $lang, $con);
                    				
                    			$productUpdateAsin = ProductAmazonQuery::create()
                    				->filterByProductId($productId)
                    				->findOne();
                    				
                    			if($productUpdateAsin)
	                    			$productUpdateAsin->setASIN($orderProduct->ASIN)
	                    				->save($con);
	                    	}
	                    
		                    $productSaleElement = ProductSaleElementsQuery::create()
			                    ->filterByProductId($productId)
			                    ->findOne();
		                  
		                    $product = ProductQuery::create()
			                    ->filterById($productId)
			                    ->findOne();
		                    
		                    /* get translation */
		                    /** @var ProductI18n $productI18n */
		                    $productI18n = I18n::forceI18nRetrieving($lang->getLocale(), 'Product', $product->getId());
		                    
		                    /* get tax */
		                    /** @var TaxRuleI18n $taxRuleI18n */
		                    $taxRuleI18n = I18n::forceI18nRetrieving($lang->getLocale(), 'TaxRule', $product->getTaxRuleId());
		                    
		                 
		                   // print_r($newOrder->getId());
		                    /** @var \OrderProduct $newOrderProduct*/
		                    $newOrderProduct = new OrderProduct();
		                    $newOrderProduct
			                    ->setOrderId($newOrder->getId())
			                    ->setProductRef($product->getRef())
			                    ->setProductSaleElementsRef($productSaleElement->getRef())
			                    ->setProductSaleElementsId($productSaleElement->getId())
			                    ->setTitle($productI18n->getTitle())
			                    ->setChapo($productI18n->getChapo())
			                    ->setDescription($productI18n->getDescription())
			                    ->setPostscriptum($productI18n->getPostscriptum())
			                    ->setVirtual('')
			                    ->setVirtualDocument('')
			                    ->setQuantity( isset($orderProduct->QuantityShipped) ? $orderProduct->QuantityShipped : '')
			                    ->setPrice( isset($orderProduct->ItemPrice->Amount) ? $orderProduct->ItemPrice->Amount : '') 
			                    ->setPromoPrice( isset($orderProduct->ItemPrice->Amount) ? $orderProduct->ItemPrice->Amount : '')
			                    ->setWasNew('')
			                    ->setWasInPromo('')
			                    ->setWeight($productSaleElement->getWeight())
			                    ->setTaxRuleTitle($taxRuleI18n->getTitle())
			                    ->setTaxRuleDescription($taxRuleI18n->getDescription())
			                    ->setEanCode($productSaleElement->getEanCode())
			                    ->save($con);
		                    
			                    $this->getLogger()->error(" orderProduct ".$product->getRef());
			                  
		                    // Insert products from amazon to amazon_orders_product table
			                $orderProductId = $newOrderProduct->getId();
			               
			                /** @var \AmazonOrderProduct $amazonOrderProduct*/
		                    $amazonOrderProduct = new AmazonOrderProduct();
		                    $amazonOrderProduct
			                    ->setOrderItemId( isset($orderProduct->OrderItemId) ? $orderProduct->OrderItemId: '')
			                    ->setAmazonOrderId($amazonOrderId)
			                    ->setAsin( isset($orderProduct->ASIN) ? $orderProduct->ASIN : '')
			                    ->setSellerSku( isset($orderProduct->SellerSKU) ? $orderProduct->SellerSKU : '')
			                    ->setOrderItemId( isset($orderProduct->OrderItemId) ? $orderProduct->OrderItemId : '')
			                    ->setTitle( isset($orderProduct->Title) ? $orderProduct->Title : '')
			                    ->setQuantityOrdered( isset($orderProduct->QuantityOrdered) ? $orderProduct->QuantityOrdered : '')
			                    ->setQuantityShipped( isset($orderProduct->QuantityShipped) ? $orderProduct->QuantityShipped : '')
			                    ->setPointsGrantedNumber( isset($orderProduct->PointsGranted->PointsNumber) ? $orderProduct->PointsGranted->PointsNumber : '')
			                    ->setPointsGrantedCurrencyCode( isset($orderProduct->PointsGranted->PointsMonetaryValue->CurrencyCode) ? $orderProduct->PointsGranted->PointsMonetaryValue->CurrencyCode : '')
			                    ->setPointsGrantedAmount( isset($orderProduct->PointsGranted->PointsMonetaryValue->Amount) ? $orderProduct->PointsGranted->PointsMonetaryValue->Amount : '')
			                    ->setItemPriceCurrencyCode( isset($orderProduct->ItemPrice->CurrencyCode) ? $orderProduct->ItemPrice->CurrencyCode : '')
			                    ->setItemPriceAmount( isset($orderProduct->ItemPrice->Amount) ? $orderProduct->ItemPrice->Amount : '')
			                    ->setShippingPriceCurrencyCode( isset($orderProduct->ShippingPrice->CurrencyCode) ? $orderProduct->ShippingPrice->CurrencyCode : '')
			                    ->setShippingPriceAmount( isset($orderProduct->ShippingPrice->Amount) ? $orderProduct->ShippingPrice->Amount : '')
			                    ->setGiftWrapPriceCurrencyCode( isset($orderProduct->GiftWrapPrice->CurrencyCode) ? $orderProduct->GiftWrapPrice->CurrencyCode : '')
			                    ->setGiftWrapPriceAmount( isset($orderProduct->GiftWrapPrice->Amount) ? $orderProduct->GiftWrapPrice->Amount : '')
			                    ->setItemTaxCurrencyCode( isset($orderProduct->ItemTax->CurrencyCode) ? $orderProduct->ItemTax->CurrencyCode : '')
			                    ->setItemTaxAmount( isset($orderProduct->ItemTax->Amount) ? $orderProduct->ItemTax->Amount : '')
			                    ->setShippingTaxCurrencyCode( isset($orderProduct->ShippingTax->CurrencyCode) ? $orderProduct->ShippingTax->CurrencyCode : '')
			                    ->setShippingTaxAmount( isset($orderProduct->ShippingTax->Amount) ? $orderProduct->ShippingTax->Amount : '')
			                    ->setGiftWrapTaxCurrencyCode( isset($orderProduct->GiftWrapTax->CurrencyCode) ? $orderProduct->GiftWrapTax->CurrencyCode : '')
			                    ->setGiftWrapTaxAmount( isset($orderProduct->GiftWrapTax->Amount) ? $orderProduct->GiftWrapTax->Amount : '')
			                    ->setShippingDiscountCurrencyCode( isset($orderProduct->ShippingDiscount->CurrencyCode) ? $orderProduct->ShippingDiscount->CurrencyCode : '')
			                    ->setShippingDiscountAmount( isset($orderProduct->ShippingDiscount->Amount) ? $orderProduct->ShippingDiscount->Amount : '')
			                    ->setPromotionDiscountCurrencyCode( isset($orderProduct->PromotionDiscount->CurrencyCode) ? $orderProduct->PromotionDiscount->CurrencyCode : '')
			                    ->setPromotionDiscountAmount( isset($orderProduct->PromotionDiscount->Amount) ? $orderProduct->PromotionDiscount->Amount : '')
			                    ->setPromotionId( isset($orderProduct->PromotionIds->PromotionId) ? $orderProduct->PromotionIds->PromotionId : '')
			                    ->setCodFeeCurrencyCode( isset($orderProduct->CODFee->CurrencyCode) ? $orderProduct->CODFee->CurrencyCode : '')
			                    ->setCodFeeAmount( isset($orderProduct->CODFee->Amount) ? $orderProduct->CODFee->Amount : '')
			                    ->setCodFeeDiscountCurrencyCode( isset($orderProduct->CODFeeDiscount->CurrencyCode) ? $orderProduct->CODFeeDiscount->CurrencyCode : '')
			                    ->setCodFeeDiscountAmount( isset($orderProduct->CODFeeDiscount->Amount) ? $orderProduct->CODFeeDiscount->Amount : '')
			                    ->setGiftMessageText( isset($orderProduct->GiftMessageText) ? $orderProduct->GiftMessageText : '')
			                    ->setGiftWrapLevel( isset($orderProduct->GiftWrapLevel) ? $$orderProduct->GiftWrapLevel : '')
			                    ->setInvoiceRequirement( isset($orderProduct->InvoiceData->InvoiceRequirement) ?  $orderProduct->InvoiceData->InvoiceRequirement : '')
			                    ->setBuyerSelectedInvoiceCategory( isset($orderProduct->InvoiceData->BuyerSelectedInvoiceCategory) ? $orderProduct->InvoiceData->BuyerSelectedInvoiceCategory : '')
			                    ->setInvoiceTitle( isset($orderProduct->InvoiceData->InvoiceTitle) ? $orderProduct->InvoiceData->InvoiceTitle : '')
			                    ->setInvoiceInformation( isset($orderProduct->InvoiceData->InvoiceInformation) ? $orderProduct->InvoiceData->InvoiceInformation : '')
			                    ->setConditionNote( isset($orderProduct->ConditionNote) ? $orderProduct->ConditionNote: '')
			                    ->setConditionId( isset($orderProduct->ConditionId) ? $orderProduct->ConditionId : '')
			                    ->setConditionSubtypeId( isset($orderProduct->ConditionSubtypeId) ? $orderProduct->ConditionSubtypeId : '')
			                    ->setScheduledDeliveryStartDate( isset($orderProduct->ScheduledDeliveryStartDate) ? $orderProduct->ScheduledDeliveryStartDate : '')
			                    ->setScheduledDeliveryEndDate( isset($orderProduct->ScheduledDeliveryEndDate) ? $orderProduct->ScheduledDeliveryEndDate : '')
			                    ->setPriceDesignation( isset($orderProduct->PriceDesignation) ? $orderProduct->PriceDesignation : '')
			                    ->setBuyerCustomizedURL( isset($orderProduct->BuyerCustomizedInfo->CustomizedURL) ? $orderProduct->BuyerCustomizedInfo->CustomizedURL : '')
			                    ->setOrderProductId($orderProductId)
			                    ->setAmazonOrderId($amazonOrderId)
			                    ;
		                    
		                    $amazonOrderProduct->save($con);
		                    
		                    $this->getLogger()->error(" amazonOrderProduct ".isset($orderProduct->OrderItemId) ? $orderProduct->OrderItemId: '');
	                    }
                    }
                    $newOrder->setPostage($totalPostage)
                    	->save($con);
                 
                }// end order creation
               
                $con->commit(); 
            }//end foreach
            
            
          //  die();
         
        }
        
        ini_set('max_execution_time', $max_time);
        if ($_SESSION['finishedToGetOrders'])
            die("Finished to get orders.");
         
        die(' customer, order address and amazon Order');
    }
    
    public function saveProducts($orderProduct, $lang, $con) {
    	
    	$newProduct = new Product();
    	$newProduct
    		->setRef($orderProduct->SellerSKU)
    		->setVisible(0)
    		->setVirtual(0)
    		->setTaxRuleId(1)
    		->setVersionCreatedBy('amazon_integration')
    		->save($con);
    	
    	$pse = new ProductSaleElements();
	    $pse
	    	->setProductId($newProduct->getId())
	    	->setRef($orderProduct->SellerSKU)
	    	->setQuantity(0)
	    	->save($con);
	    
	    if(!isset($orderProduct->ItemPrice->Amount))
	    	print_r($orderProduct->SellerSKU.'<br>');
	    
	    $productPrice = new ProductPrice();
	    $productPrice
	    	->setProductSaleElementsId($pse->getId())
	    	->setPrice(isset($orderProduct->ItemPrice->Amount) ? isset($orderProduct->ItemPrice->Amount) : '')
	    	->setFromDefaultCurrency(0)
	    	->setCurrencyId(1)
	    	->save($con);
	    
    	$productI18n = new ProductI18n();
    	$productI18n
    		->setId($newProduct->getId())
	    	->setLocale($lang->getLocale())
	    	->setTitle(isset($orderProduct->Title) ? $orderProduct->Title : '')
	    	->save($con);
    	
	    return $newProduct->getId();
    }
    
    public function getLogger()
    {
    	if (self::$logger == null) {
    		self::$logger = Tlog::getNewInstance();
    		
    		$logFilePath = THELIA_LOG_DIR . DS . "log-amazon-integration.txt";
    		
    		self::$logger->setPrefix("#LEVEL: #DATE #HOUR: ");
    		self::$logger->setDestinations("\\Thelia\\Log\\Destination\\TlogDestinationRotatingFile");
    		self::$logger->setConfig("\\Thelia\\Log\\Destination\\TlogDestinationRotatingFile", 0, $logFilePath);
    		self::$logger->setLevel(Tlog::ERROR);
    	}
    	return self::$logger;
    }
    
}
