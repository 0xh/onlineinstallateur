<?php
namespace AmazonIntegration\Controller\Admin;

use AmazonIntegration\Model\AmazonOrders;
use AmazonIntegration\Model\Map\AmazonOrdersTableMap;
use function Composer\Autoload\includeFile;
use Propel\Runtime\Propel;
use Thelia\Controller\Admin\BaseAdminController;
use Thelia\Model\Customer;
use Thelia\Model\OrderAddress;
use AmazonIntegration\Model\AmazonOrdersQuery;
use Thelia\Model\CustomerQuery;
use Thelia\Model\CountryQuery;
use Thelia\Model\OrderAddressQuery;
use Thelia\Model\ProductSaleElementsQuery;

class AmazonIntegrationContoller extends BaseAdminController
{

    public function blockJs()
    {
        return $this->render("AmazonIntegrationTemplate-js");
    }

    public function viewAction()
    {
        // echo "<pre>";
        // include __DIR__.'\..\..\Classes\API\src\MarketplaceWebServiceOrders\Samples\GetServiceStatusSample.php';
        
        // include __DIR__.'\..\..\Classes\API\src\MarketplaceWebServiceOrders\Samples\ListOrdersSample.php';
        
        // include __DIR__.'\..\..\Classes\API\src\MarketplaceWebServiceOrders\Samples\ListOrdersByNextTokenSample.php';
        $orders = array();
        
        return $this->render("AmazonIntegrationTemplate", array(
            "orders" => $orders
        ));
    }

    public function addProductsForOrdersByAmazon()
    {
        $amazonOrdersQuery = new AmazonOrdersQuery();
        $prods = $amazonOrdersQuery->findById("*");
        
        $amazonOrdersArray = array();
        
        foreach ($prods as $value) {
            array_push($amazonOrdersArray, $value->getId());
        }
        // $amazonOrdersArray2 = array();
        // foreach ($amazonOrdersArray as $key => $value)
        // {
        // echo $key." - ".$value."\n";
        // if ($key > 645)
        // array_push($amazonOrdersArray2, $value);
        // }
        // $amazonOrdersArray = $amazonOrdersArray2;
        
        // echo "<pre>";
        // var_dump($amazonOrdersArray);
        
        // die;
        
        $max_time = ini_get("max_execution_time");
        ini_set('max_execution_time', 6000);
        
        include __DIR__ . '\..\..\Classes\API\src\MarketplaceWebServiceOrders\Samples\ListOrderItemsSample.php';
        
        ini_set('max_execution_time', $max_time);
        
        die("Finish insert Products foreach Orders by Amazon.");
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
        // unset($_SESSION['nxtToken']);
        // die;
        $_SESSION['finishedToGetOrders'] = false;
        
        if (! isset($_SESSION['nxtToken'])) {
            include __DIR__ . '\..\..\Classes\API\src\MarketplaceWebServiceOrders\Samples\ListOrdersSample.php';
        } else
            include __DIR__ . '\..\..\Classes\API\src\MarketplaceWebServiceOrders\Samples\ListOrdersByNextTokenSample.php';
        
        $con = Propel::getConnection(AmazonOrdersTableMap::DATABASE_NAME);
        $con->beginTransaction();
        
        if ($orders) {
            foreach ($orders as $i => $order) {
                
                /*
                 * Verify (by email) if customer exists in customer thelia table
                 * if exists -> get the customer Id
                 * if not -> create a new customer
                 *
                 * amazonCanceled customer - default customer user for all canceled orders from amazon
                 */
                if (isset($order->BuyerEmail)) {
                    $buyerEmail = $order->BuyerEmail;
                } else {
                    $buyerEmail = 'amazoncanceled@hausfabrik.at';
                }
                
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
                }
                
                /*
                 * Check if amazon order exists in amazon_orders table
                 * if doesn't exist
                 * -> insert shipping address
                 * -> insert order
                 */
                
                $checkAmazonOrder = AmazonOrdersQuery::create()->filterById($order->AmazonOrderId)->findOne();
                
                if ($checkAmazonOrder) {
                    if ($checkAmazonOrder->getOrderStatus() !== $order->OrderStatus) {
                        $checkAmazonOrder->setOrderStatus($order->OrderStatus)->save($con);
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
                    
                    $orderId = '36';
                    
                    // Insert order from amazon to amazon_orders table
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
                }
            }
            
            $con->commit();
        }
        
        if ($_SESSION['finishedToGetOrders'])
            die("Finished to get orders.");
        
        die(' customer, order address and amazon Order');
    }
}
