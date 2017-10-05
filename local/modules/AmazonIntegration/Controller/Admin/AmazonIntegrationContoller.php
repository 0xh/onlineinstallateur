<?php
namespace AmazonIntegration\Controller\Admin;

use AmazonIntegration\Model\AmazonOrders;
use AmazonIntegration\Model\Map\AmazonOrdersTableMap;
use function Composer\Autoload\includeFile;
use Propel\Runtime\Propel;
use Thelia\Controller\Admin\BaseAdminController;
use Thelia\Model\Customer;
use Thelia\Model\OrderAddress;
use Thelia\Model\ProductSaleElementsQuery;

class AmazonIntegrationContoller extends BaseAdminController
{

    public function blockJs()
    {
        return $this->render("AmazonIntegrationTemplate-js");
    }

    public function viewAction()
    {
//         echo "<pre>";
        // include __DIR__.'\..\..\Classes\API\src\MarketplaceWebServiceOrders\Samples\GetServiceStatusSample.php';
        
//         include __DIR__.'\..\..\Classes\API\src\MarketplaceWebServiceOrders\Samples\ListOrdersSample.php';
        
        // include __DIR__.'\..\..\Classes\API\src\MarketplaceWebServiceOrders\Samples\ListOrdersByNextTokenSample.php';
        
        
//         die("GATA");
        
//         include __DIR__.'\..\..\Classes\API\src\MarketplaceWebServiceOrders\Samples\ListOrderItemsSample.php';

        $orders = array();
        
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
                array_push($eanArray, array("eanCode" => $value->getEanCode(), "productId" => $value->getProductId(), "ref" => $value->getRef()));
            }
        }
        
        $max_time = ini_get("max_execution_time");
        ini_set('max_execution_time', 3000);
        
        include __DIR__ . '\..\..\Classes\API\src\MarketplaceWebServiceOrders\Samples\GetMatchingProductForIdSample.php';
        
        ini_set('max_execution_time', $max_time);
        
        die("Finish insert ASIN from Amazon.");        
    }

    public function serviceAction()
    {
        include __DIR__ . '\..\..\Classes\API\src\MarketplaceWebServiceOrders\Samples\GetServiceStatusSample.php';
        
        echo json_encode($orders);
        die();
    }
    
    public function saveAmazonOrders()
    {  
    	include __DIR__.'\..\..\Classes\API\src\MarketplaceWebServiceOrders\Samples\ListOrdersSample.php';
    	
	    $con = Propel::getConnection(
	    		AmazonOrdersTableMap::DATABASE_NAME
	    		);
    
   	 	$con->beginTransaction();
    
    	foreach($orders as $i => $order) {
    		
    		// INSERT CUSTOMER
    		if(isset($order->BuyerName)) {
    			$name = preg_split('/\s+/',  $order->BuyerName);
    			$firstName = $name[0];
    			if(isset($name[1])) {
	    			if(isset($name[2]))
	    				$lastName = $name[1].' '.$name[2];
	    			else 
	    				$lastName = $name[1];
    			}
    		}
    		else {
    			$firstName = '';
    			$lastName = '';
    		}
    		
    		$customer = new Customer();
    		
    		$customer 
    			->setTitleId('1')
    			->setFirstname($firstName)
    			->setLastname($lastName)
    			->setEmail(isset($order->BuyerEmail) ? $order->BuyerEmail : 'notAmazonEmail')
    		;
    		$customer->save($con);
    		
    		// INSERT ORDER ADDRESS 
    		if(isset($order->ShippingAddress->Name)) {
    			$name = preg_split('/\s+/',  $order->ShippingAddress->Name);
    			$firstName = $name[0];
    			if(isset($name[1])) {
    				if(isset($name[2]))
    					$lastName = $name[1].' '.$name[2];
    					else
    						$lastName = $name[1];
    			}
    		}
    		else {
    			$firstName = '';
    			$lastName = '';
    		}
    		
  			$orderAddress = new OrderAddress();
    		$orderAddress 
    			->setFirstName($firstName)
    			->setLastname($lastName)
    			->setAddress1( isset($order->ShippingAddress->AddressLine2) ? $order->ShippingAddress->AddressLine2 : '')
    			->setCity( isset($order->ShippingAddress->City) ? $order->ShippingAddress->City : '')
    			->setZipcode( isset($order->ShippingAddress->PostalCode) ? $order->ShippingAddress->PostalCode : '')
    			->setCountryId('13')
    		;
    		$orderAddress->save($con);
    			
    		// INSERT ORDER FROM AMAZON
    	 	$customerId = $customer->getId(); //'6'; 
    		$orderId = '1406';
    		$orderAddressId = $orderAddress->getId(); //'2819';
    		
	    	$amazonOrder = new AmazonOrders();
	    	$amazonOrder
	    		->setId( isset($order->AmazonOrderId) ? $order->AmazonOrderId : '')
	    		->setSellerOrderId( isset($order->SellerOrderId) ? $order->SellerOrderId : '')
	    		->setPurchaseDate( isset($order->PurchaseDate) ? $order->PurchaseDate: '')
	    		->setLastUpdateDate( isset($order->LastUpdateDate) ? $order->LastUpdateDate : '')
	    		->setOrderStatus( isset($order->OrderStatus) ? $order->OrderStatus: '')
	    		->setFulfillmentChannel( isset($order->FulfillmentChannel) ? $order->FulfillmentChannel : '')
	    		->setSalesChannel( isset($order->SalesChannel) ? $order->SalesChannel : '')
	    		->setOrderChannel( isset($order->OrderChannel) ? $order->OrderChannel : '')
	    		->setShipServiceLevel( isset($order->ShipServiceLevel) ? $order->ShipServiceLevel : '')
	    		->setOrderTotalCurrencyCode( isset($order->OrderTotal->CurrencyCode) ? $order->OrderTotal->CurrencyCode : '')
	    		->setOrderTotalAmount( isset($order->OrderTotal->Amount) ? $order->OrderTotal->Amount : '')
	    		->setNumberOfItemsShipped( isset($order->NumberOfItemsShipped) ? $order->NumberOfItemsShipped : '')
	    		->setNumberOfItemsUnshipped( isset($order->NumberOfItemsUnshipped) ? $order->NumberOfItemsUnshipped : '')
	    		->setPaymentExecutionDetailCurrencyCode( isset($order->PaymentExecutionDetail->PaymentExecutionDetailItem->Payment->CurrencyCode) ? $order->PaymentExecutionDetail->PaymentExecutionDetailItem->Payment->CurrencyCode : '')
	    		->setPaymentExecutionDetailTotalAmount( isset($order->PaymentExecutionDetail->PaymentExecutionDetailItem->Payment->Amount) ? $order->PaymentExecutionDetail->PaymentExecutionDetailItem->Payment->Amount : '')
	    		->setPaymentExecutionDetailPaymentMethod( isset($order->PaymentExecutionDetail->PaymentExecutionDetailItem->PaymentMethod) ? $order->PaymentExecutionDetail->PaymentExecutionDetailItem->PaymentMethod : '') 		
	    		->setPaymentMethod( isset($order->PaymentMethod) ? $order->PaymentMethod : '')
	    		->setPaymentMethodDetail( isset($order->PaymentMethodDetails->PaymentMethodDetail) ? $order->PaymentMethodDetails->PaymentMethodDetail : '')
	    		->setMarketplaceId( isset($order->MarketplaceId) ? $order->MarketplaceId : '')
	    		->setBuyerCounty( isset($order->BuyerCounty) ? $order->BuyerCounty : '')
	    		->setBuyerTaxInfoCompany( isset($order->BuyerTaxInfo->CompanyLegalName) ? $order->BuyerTaxInfo->CompanyLegalName : '')
	    		->setBuyerTaxInfoTaxingRegion( isset($order->BuyerTaxInfo->TaxingRegion) ? $order->BuyerTaxInfo->TaxingRegion : '')
	    		->setBuyerTaxInfoTaxName( isset($order->BuyerTaxInfo->TaxClassifications->TaxClassification->Name) ? $order->BuyerTaxInfo->TaxClassifications->TaxClassification->Name : '')
	    		->setBuyerTaxInfoTaxValue( isset($order->BuyerTaxInfo->TaxClassifications->TaxClassification->Value) ? $order->BuyerTaxInfo->TaxClassifications->TaxClassification->Value : '')
	    		->setShipmentServiceLevelCategory( isset($order->ShipmentServiceLevelCategory) ? $order->ShipmentServiceLevelCategory : '')
	    		->setShippedByAmazonTfm( isset($order->ShippedByAmazonTFM) && ($order->ShippedByAmazonTFM == true) ? 1 : 0)
	    		->setTfmShipmentStatus( isset($order->TFMShipmentStatus) ? $order->TFMShipmentStatus : '')
	    		->setCbaDisplayableShippingLabel( isset($order->CbaDisplayableShippingLabel) ? $order->CbaDisplayableShippingLabel : '')
	    		->setOrderType( isset($order->OrderType) ? $order->OrderType : '')
	    		->setEarliestShipDate( isset($order->EarliestShipDate) ? $order->EarliestShipDate : '')
	    		->setLatestShipDate( isset($order->LatestShipDate) ? $order->LatestShipDate : '')
	    		->setEarliestDeliveryDate( isset($order->EarliestDeliveryDate) ? $order->EarliestDeliveryDate : '')
	    		->setLatestDeliveryDate( isset($order->LatestDeliveryDate) ? $order->LatestDeliveryDate : '')
	    		->setIsBusinessOrder( isset($order->IsBusinessOrder) && $order->IsBusinessOrder == true ? 1 : 0)
	    		->setPurchaseOrderNumber( isset($order->PurchaseOrderNumber) ? $order->PurchaseOrderNumber : '')
	    		->setIsPrime( isset($order->IsPrime) && $order->IsPrime == true ? 1 : 0)
	    		->setIsPremiumOrder( isset($order->IsPremiumOrder) && $order->IsPremiumOrder == true ? 1 : 0)
	    		->setReplacedOrderId( isset($order->ReplacedOrderId) ? $order->ReplacedOrderId : '')
	    		->setIsReplacementOrder( isset($order->IsReplacementOrder) && $order->IsReplacementOrder == true ? 1 : 0)
	    		->setOrderAddressId($orderAddressId)
	    		->setCustomerId($customerId)
	    		->setOrderId($orderId)
	    	;
    	
	    	$amazonOrder->save($con);  
    	}
    	
    	
    	$con->commit();
    	die(' customer, order address and amazon Order');
    }
}
