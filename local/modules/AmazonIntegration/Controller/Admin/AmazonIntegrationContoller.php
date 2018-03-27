<?php

namespace AmazonIntegration\Controller\Admin;

use AmazonIntegration\Model\AmazonOrderProduct;
use AmazonIntegration\Model\AmazonOrders;
use AmazonIntegration\Model\AmazonOrdersQuery;
use AmazonIntegration\Model\ProductAmazonQuery;
use AmazonIntegration\Model\Map\AmazonOrdersTableMap;
use function Composer\Autoload\includeFile;
use Propel\Runtime\Propel;
use Thelia\Model\Map\ProductTableMap;
use Thelia\Model\Map\ProductSaleElementsTableMap;
use Thelia\Controller\Admin\BaseAdminController;
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
use AmazonIntegration\Model\ProductAmazon;
use Thelia\Model\ProductCategory;
use Thelia\Model\CategoryI18nQuery;
use Thelia\Model\ProductPrice;
use Thelia\Model\ProductQuery;
use Thelia\Model\ProductSaleElements;
use Thelia\Model\ProductSaleElementsQuery;
use Thelia\Tools\I18n;
use Thelia\Model\AddressQuery;
use Thelia\Model\Address;
use Thelia\Model\OrderProductTax;
use Thelia\Model\OrderQuery;
use AmazonIntegration\Form\GetRankingsForm;
use AmazonIntegration\AmazonIntegration;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Thelia\Tools\URL;
use AmazonIntegration\Model\AmazonProductCategory;
use AmazonIntegration\Model\AmazonProductCategoryQuery;

class AmazonIntegrationContoller extends BaseAdminController {
    /* @var Tlog $log */

    protected static $logger;

    public function blockJs() {
        return $this->render("AmazonIntegrationTemplate-js");
    }

    public function viewAction() {
        return $this->render("AmazonIntegrationTemplate");
    }

    public function saveAsinFromAmazon() {
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
        $idType = 'EAN';
        include __DIR__ . '/../../Classes/API/src/MarketplaceWebServiceOrders/Samples/GetMatchingProductForIdSample.php';


        $max_time = ini_get("max_execution_time");
        ini_set('max_execution_time', 3000);

        // object or array of parameters
        foreach ($eanArray as $value) {
        	
        	$idList->setId(array(
        			$value['eanCode']
        	));
        	
        	$request->setIdList($idList);
        	
        	$result = invokeGetMatchingProductForId($service, $request);
        	
        	if ($result) {
        		if (isset($result->GetMatchingProductForIdResult->Products)) {
        			foreach ($result->GetMatchingProductForIdResult->Products->Product as $prd) {
        				if (isset($prd->Identifiers))
        					$this->addAsinFromAmazon($value['eanCode'], $value['productId'], $value['ref'], $prd->Identifiers->MarketplaceASIN->ASIN);
        					else
        						if (isset($prd->MarketplaceASIN))
        							$this->addAsinFromAmazon($value['eanCode'], $value['productId'], $value['ref'], $prd->MarketplaceASIN->ASIN);
        			}
        		} else
        			$this->addAsinFromAmazon($value['eanCode'], $value['productId'], $value['ref'], "");
        	} else {
        		echo ('error decoding json');
        	}
        	
        	sleep(3);
        }

        ini_set('max_execution_time', $max_time);

        die("Finish insert ASIN from Amazon.");
    }

    public function addAsinFromAmazon($eanCode, $productId, $ref, $asinCode) {
        $prodAmazon = new ProductAmazon();
        $prodAmazon->setEanCode($eanCode);
        $prodAmazon->setProductId($productId);
        $prodAmazon->setRef($ref);
        $prodAmazon->setASIN($asinCode);
        $prodAmazon->save();
        $prodAmazon->clear();
    }

    public function getServiceForOrdersAction() {
        include __DIR__ . '/../../Classes/API/src/MarketplaceWebServiceOrders/Samples/GetServiceStatusSample.php';

        echo json_encode($orders);
        die();
    }

    public function getServiceForProductsAction() {
        include __DIR__ . '/../../Classes/API/src/MarketplaceWebServiceOrders/Products/MarketplaceWebServiceProducts/Samples/GetServiceStatusSample.php';

        echo json_encode($productService);
        die();
    }

    public function saveAmazonOrders() {
        $_SESSION['ordersWithTotalZero'] = false;

        $arrDate = array();
        if (isset($_GET["dateCreatedAfter"]) && $_GET["dateCreatedAfter"] != "") {
            $arrDate["dateCreatedAfter"] = $_GET["dateCreatedAfter"];
        } else {
            $arrDate["dateCreatedAfter"] = false;
        }

        if (isset($_GET["dateLastUpdatedAfter"]) && $_GET["dateLastUpdatedAfter"] != "") {
            $arrDate["dateLastUpdatedAfter"] = $_GET["dateLastUpdatedAfter"];
        } else {
            $arrDate["dateLastUpdatedAfter"] = false;
        }

        $this->getLogger()->error("import started");

        include __DIR__ . '/../../Classes/API/src/MarketplaceWebServiceOrders/Samples/ListOrderItemsSample.php';

        $_SESSION['finishedToGetOrders'] = false;
        unset($_SESSION['nxtToken']);

        while ($_SESSION['finishedToGetOrders'] == false && $_SESSION['ordersWithTotalZero'] == false) {
            if (!isset($_SESSION['nxtToken'])) {
                include_once __DIR__ . '/../../Classes/API/src/MarketplaceWebServiceOrders/Samples/ListOrdersSample.php';
                $orders = invokeListOrders($service, $request);
            } else {
                include_once __DIR__ . '/../../Classes/API/src/MarketplaceWebServiceOrders/Samples/ListOrdersByNextTokenSample.php';

                if (isset($_SESSION['nxtToken']))
                    $request->setNextToken($_SESSION['nxtToken']);

                $orders = invokeListOrdersByNextToken($service, $request);
            }

            $con = Propel::getConnection(AmazonOrdersTableMap::DATABASE_NAME);
            $con->beginTransaction();

            $max_time = ini_get("max_execution_time");
            ini_set('max_execution_time', 15000);

            if ($orders) {
                foreach ($orders as $i => $order) {
                	
                	if($order->OrderStatus == 'Pending' || $order->OrderStatus == 'Unshipped') {
                		//$_SESSION['ordersWithTotalZero'] = true;
                		break;
                	}
                	$this->getLogger()->error("amazonOrderId ".isset($order->AmazonOrderId) ? $order->AmazonOrderId : 'noOrderId');
                	
                	if (isset($order->ShippingAddress->CountryCode)) {
                		$countryId = CountryQuery::create()->select('id')
                		->filterByIsoalpha2($order->ShippingAddress->CountryCode)
                		->findOne();
                	} else {
                		$countryId = '13';
                	}
                	
                	// Insert new customers from Amazon or get the id
                	$customerId = $this->createCustomer($order, $con, $countryId);

                    /*
                     * Check if amazon order exists in amazon_orders table
                     * if doesn't exist insert the new order in 
                     * - shipping address in order_address
                     * - order
                     * - all info from amazon in amazon_orders
                     * - order_product
                     * - all info from amazon in amazon_order_product
                     * - if product doesn't exist insert it in 
                     * 		- product
                     * 		- product_price
                     * 		- product_sale_elements
                     * 		- product_i18n
                     * 		- product_category
                     */

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

                    $checkAmazonOrder = AmazonOrdersQuery::create()->filterById($order->AmazonOrderId)->findOne();
                    if ($checkAmazonOrder) {

                        if ($checkAmazonOrder->getOrderStatus() !== $order->OrderStatus ||
                                $checkAmazonOrder->getShipServiceLevel() !== $order->ShipServiceLevel) {

                            $checkAmazonOrder->setShipServiceLevel($order->ShipServiceLevel);
                            if (isset($order->OrderTotal)) {
                                $checkAmazonOrder->setOrderTotalCurrencyCode($order->OrderTotal->CurrencyCode);
                                $checkAmazonOrder->setOrderTotalAmount($order->OrderTotal->Amount);
                            }
                            $checkAmazonOrder->setOrderStatus($order->OrderStatus);
                            $checkAmazonOrder->save($con);

                            $updateOrderStatus = OrderQuery::create()
                                    ->filterById($checkAmazonOrder->getOrderId())
                                    ->findOne();
                            if ($updateOrderStatus)
                                $updateOrderStatus->setStatusId($statusId)->save($con);
                        }
                    } elseif ($statusId != '5') {
                        // Insert delivery address in order_address table
                        $orderAddressId = $this->createOrderAddress($order, $con, $countryId);

                        // Insert order from amazon in order table
                        $arrCreateOrder = $this->createOrder($order, $customerId, $orderAddressId, $con, $statusId);

                        $lang = $arrCreateOrder['lang'];
                        $newOrder = $arrCreateOrder['order'];
                        $orderId = $newOrder->getId();
                        $marketplace = $arrCreateOrder['marketplace'];

                        // Insert order from amazon to amazon_orders table
                        $this->createAmazonOrders($order, $orderAddressId, $customerId, $orderId, $con);

                        // Get products for each order from amazon
                        $amazonOrderId = $order->AmazonOrderId;
                        // $amazonOrderId = '305-3292380-9658727';

                        $productsOrderItem = invokeListOrderItems($service, $amazonOrderId);

                        sleep(4);

                        if (isset($order->FulfillmentChannel))
                            $fulfillmentChannel = $order->FulfillmentChannel;
                        else
                            $fulfillmentChannel = 'MFN';

                        $totalPostage = 0;

                        if (isset($productsOrderItem->OrderItem)) {
                            $orderProduct = $productsOrderItem->OrderItem;
                            // More items for an order
                            if (is_array($orderProduct)) {
                                $orderProducts = $orderProduct;
                                foreach ($orderProducts as $orderProduct) {

                                    if (isset($orderProduct->ShippingPrice->Amount))
                                        $totalPostage += $orderProduct->ShippingPrice->Amount;

                                    $this->insertOrderProduct($orderProduct, $lang, $con, $newOrder->getId(), $amazonOrderId, $marketplace, $fulfillmentChannel);
                                }
                            }
                            else {
                                if (isset($orderProduct->ShippingPrice->Amount))
                                    $totalPostage = $orderProduct->ShippingPrice->Amount;

                                $this->insertOrderProduct($orderProduct, $lang, $con, $newOrder->getId(), $amazonOrderId, $marketplace, $fulfillmentChannel);
                            }
                        }

                        if ($fulfillmentChannel == 'AFN') {
                            $taxPostage = round(($totalPostage / 1.19) * 0.19, 2);
                        } else {
                            $taxPostage = round(($totalPostage / 1.2) * 0.2, 2);
                        }

                        $newOrder->setPostage($totalPostage)
                                ->setPostageTax($taxPostage)
                                ->save($con);
                    }
                }

                if ($_SESSION['ordersWithTotalZero'] == false) {
                    $con->commit();
                }
            }

            ini_set('max_execution_time', $max_time);
        }

        if ($_SESSION['ordersWithTotalZero']) {
            AmazonIntegrationResponse::logError("Amazon imported stopped at amazon order id " . $order->AmazonOrderId . " because has the status " . $order->OrderStatus);
            unset($_SESSION['nxtToken']);
            die("Amazon imported stopped at amazon order id " . $order->AmazonOrderId . " because has the status " . $order->OrderStatus);
        }

        if ($_SESSION['finishedToGetOrders']) {
            AmazonIntegrationResponse::logError("Finished to get orders.");
            unset($_SESSION['nxtToken']);
            die("Finished to get orders.");
        }

        AmazonIntegrationResponse::logError(' customer, order address and amazon Order');
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
                ->setIsDefault(1)
                ->save($con);

        if (isset($orderProduct->ItemPrice->Amount) && isset($orderProduct->QuantityOrdered)) {
            if ($orderProduct->QuantityOrdered > 0)
                $unitPrice = $orderProduct->ItemPrice->Amount / $orderProduct->QuantityOrdered;
            else
                $unitPrice = 1;
        } else
            $unitPrice = 1;

        $productPrice = new ProductPrice();
        $productPrice
                ->setProductSaleElementsId($pse->getId())
                ->setPrice($unitPrice)
                ->setFromDefaultCurrency(0)
                ->setCurrencyId(1)
                ->save($con);

        if (isset($lang))
            $langLocale = $lang->getLocale();
        else
            $langLocale = "de_DE";
        $productI18n = new ProductI18n();
        $productI18n
                ->setId($newProduct->getId())
                ->setLocale($langLocale)
                ->setTitle(isset($orderProduct->Title) ? $orderProduct->Title : '')
                ->save($con);

        // insert in product_category 
        $categoryId = CategoryI18nQuery::create()
                ->select('id')
                ->filterByTitle('From Amazon')
                ->findOne();

        $productCategory = new ProductCategory();
        $productCategory
                ->setProductId($newProduct->getId())
                ->setCategoryId(isset($categoryId) ? $categoryId : 1)
                ->setDefaultCategory(1)
                ->setPosition(1)
                ->save($con);

        return $newProduct->getId();
    }

    public function createCustomer($order, $con, $countryId) {

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

        if ($checkCustomerId) {
            $customerId = $checkCustomerId;
        } else {

            $customer = new Customer();

            $customer->setTitleId(1)
                    ->setFirstname($firstName)
                    ->setLastname($lastName)
                    ->setEmail($buyerEmail);
            $customer->save($con);

            $customerId = $customer->getId();
        }

        $checkCustomerAddress = AddressQuery::create()->select('id')
                ->filterByCustomerId($customerId)
                ->findOne();

        if (!$checkCustomerAddress && $order->OrderStatus != 'Canceled') {
            $customerAddress = new Address();

            if (isset($order->ShippingAddress->AddressLine2))
                $address = $order->ShippingAddress->AddressLine2;
            else
                $address = '';

            $customerAddress->setLabel('Hauptadresse')
                    ->setCustomerId($customerId)
                    ->setTitleId(1)
                    ->setCompany(isset($order->BuyerTaxInfo->CompanyLegalName) ? $order->BuyerTaxInfo->CompanyLegalName : '')
                    ->setFirstname($firstName)
                    ->setLastname($lastName)
                    ->setAddress1($address)
                    ->setCity(isset($order->ShippingAddress->City) ? $order->ShippingAddress->City : '')
                    ->setZipcode(isset($order->ShippingAddress->PostalCode) ? $order->ShippingAddress->PostalCode : '')
                    ->setCountryId($countryId)
                    ->setIsDefault(1)
            ;
            $customerAddress->save($con);
        }

        return $customerId;
    }

    public function createOrderAddress($order, $con, $countryId) {

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

        return $orderAddressId;
    }

    public function createOrder($order, $customerId, $orderAddressId, $con, $statusId) {

        $salesChannelId = explode(".", $order->SalesChannel);

        $lang = LangQuery::create()
                ->filterByCode($salesChannelId[1])
                ->findOne();

        if ($lang)
            $langId = $lang->getId();
        else
            $langId = '1';

        $currencyId = '1';
        $currencyRate = '1';

        if (isset($order->OrderTotal->CurrencyCode)) {
            $currency = CurrencyQuery::create()
                    ->filterByCode($order->OrderTotal->CurrencyCode)
                    ->findOne();

            if ($currency) {
                $currencyId = $currency->getId();
                $currencyRate = $currency->getRate();
            }
        }

        $marketplace = strtoupper($salesChannelId[1]);

        $this->getRequest()->getSession()->set(
                "marketplace", $marketplace
        );

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
                ->setVersionCreatedBy('amazonimporter.1')
                ->setDispatcher($this->getDispatcher())
        ;

        $newOrder->save($con);

        return array(
            'lang' => $lang,
            'order' => $newOrder,
            'marketplace' => $marketplace
        );
    }

    public function createAmazonOrders($order, $orderAddressId, $customerId, $orderId, $con) {

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

    public function insertOrderProduct($orderProduct, $lang, $con, $orderId, $amazonOrderId, $marketplace, $fulfillmentChannel) {

        $productId = ProductAmazonQuery::create()
                ->select('product_id')
                ->filterByASIN($orderProduct->ASIN)
                ->findOne();

        if (!$productId) {
            if (isset($orderProduct->SellerSKU)) {
                $productId = ProductQuery::create()
                        ->select('id')
                        ->filterByRef($orderProduct->SellerSKU)
                        ->findOne();
            }

            if (!$productId)
                $productId = $this->saveProducts($orderProduct, $lang, $con);

            $productUpdateAsin = ProductAmazonQuery::create()
                    ->filterByProductId($productId)
                    ->findOne();

            if ($productUpdateAsin)
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
        if (isset($lang))
            $langLocale = $lang->getLocale();
        else
            $langLocale = "de_DE";

        $productI18n = I18n::forceI18nRetrieving($langLocale, 'Product', $product->getId());

        /* get tax */
        /** @var TaxRuleI18n $taxRuleI18n */
        $taxRuleI18n = I18n::forceI18nRetrieving($langLocale, 'TaxRule', $product->getTaxRuleId());

        if (isset($orderProduct->ItemPrice->Amount) && isset($orderProduct->QuantityOrdered)) {
            if ($orderProduct->QuantityOrdered > 0)
                $unitPrice = $orderProduct->ItemPrice->Amount / $orderProduct->QuantityOrdered;
            else
                $unitPrice = 1;
        }
        else {
            $unitPrice = 1;
        }

        if ($fulfillmentChannel == 'AFN') {
            $tax = round(($unitPrice / 1.19) * 0.19, 2);
            $priceWithoutTax = $unitPrice - $tax;
            $taxTitle = '19%  VAT';
        } else {
            $tax = round(($unitPrice / 1.2) * 0.2, 2);
            $priceWithoutTax = $unitPrice - $tax;
            $taxTitle = '20%  VAT';
        }

        $newOrderProduct = new OrderProduct();
        $newOrderProduct
                ->setOrderId($orderId)
                ->setProductRef($product->getRef())
                ->setProductSaleElementsRef($productSaleElement->getRef())
                ->setProductSaleElementsId($productSaleElement->getId())
                ->setTitle($productI18n->getTitle())
                ->setChapo($productI18n->getChapo())
                ->setDescription($productI18n->getDescription())
                ->setPostscriptum($productI18n->getPostscriptum())
                ->setVirtual('')
                ->setVirtualDocument('')
                ->setQuantity(isset($orderProduct->QuantityShipped) ? $orderProduct->QuantityShipped : '')
                ->setPrice($priceWithoutTax)
                ->setPromoPrice($priceWithoutTax)
                ->setWasNew('')
                ->setWasInPromo('')
                ->setWeight($productSaleElement->getWeight())
                ->setTaxRuleTitle($taxTitle)
                ->setTaxRuleDescription('')
                ->setEanCode($productSaleElement->getEanCode())
                ->save($con);

        $orderProductId = $newOrderProduct->getId();

        // Insert product in order_product_tax
        $orderProductTax = new OrderProductTax();
        $orderProductTax
                ->setOrderProductId($orderProductId)
                ->setTitle($taxTitle)
                ->setAmount($tax)
                ->setPromoAmount($tax)
                ->save($con);

        // Insert products from amazon to amazon_orders_product table
        $amazonOrderProduct = new AmazonOrderProduct();
        $amazonOrderProduct
                ->setOrderItemId(isset($orderProduct->OrderItemId) ? $orderProduct->OrderItemId : '')
                ->setAmazonOrderId($amazonOrderId)
                ->setAsin(isset($orderProduct->ASIN) ? $orderProduct->ASIN : '')
                ->setSellerSku(isset($orderProduct->SellerSKU) ? $orderProduct->SellerSKU : '')
                ->setOrderItemId(isset($orderProduct->OrderItemId) ? $orderProduct->OrderItemId : '')
                ->setTitle(isset($orderProduct->Title) ? $orderProduct->Title : '')
                ->setQuantityOrdered(isset($orderProduct->QuantityOrdered) ? $orderProduct->QuantityOrdered : '')
                ->setQuantityShipped(isset($orderProduct->QuantityShipped) ? $orderProduct->QuantityShipped : '')
                ->setPointsGrantedNumber(isset($orderProduct->PointsGranted->PointsNumber) ? $orderProduct->PointsGranted->PointsNumber : '')
                ->setPointsGrantedCurrencyCode(isset($orderProduct->PointsGranted->PointsMonetaryValue->CurrencyCode) ? $orderProduct->PointsGranted->PointsMonetaryValue->CurrencyCode : '')
                ->setPointsGrantedAmount(isset($orderProduct->PointsGranted->PointsMonetaryValue->Amount) ? $orderProduct->PointsGranted->PointsMonetaryValue->Amount : '')
                ->setItemPriceCurrencyCode(isset($orderProduct->ItemPrice->CurrencyCode) ? $orderProduct->ItemPrice->CurrencyCode : '')
                ->setItemPriceAmount(isset($orderProduct->ItemPrice->Amount) ? $orderProduct->ItemPrice->Amount : '')
                ->setShippingPriceCurrencyCode(isset($orderProduct->ShippingPrice->CurrencyCode) ? $orderProduct->ShippingPrice->CurrencyCode : '')
                ->setShippingPriceAmount(isset($orderProduct->ShippingPrice->Amount) ? $orderProduct->ShippingPrice->Amount : '')
                ->setGiftWrapPriceCurrencyCode(isset($orderProduct->GiftWrapPrice->CurrencyCode) ? $orderProduct->GiftWrapPrice->CurrencyCode : '')
                ->setGiftWrapPriceAmount(isset($orderProduct->GiftWrapPrice->Amount) ? $orderProduct->GiftWrapPrice->Amount : '')
                ->setItemTaxCurrencyCode(isset($orderProduct->ItemTax->CurrencyCode) ? $orderProduct->ItemTax->CurrencyCode : '')
                ->setItemTaxAmount(isset($orderProduct->ItemTax->Amount) ? $orderProduct->ItemTax->Amount : '')
                ->setShippingTaxCurrencyCode(isset($orderProduct->ShippingTax->CurrencyCode) ? $orderProduct->ShippingTax->CurrencyCode : '')
                ->setShippingTaxAmount(isset($orderProduct->ShippingTax->Amount) ? $orderProduct->ShippingTax->Amount : '')
                ->setGiftWrapTaxCurrencyCode(isset($orderProduct->GiftWrapTax->CurrencyCode) ? $orderProduct->GiftWrapTax->CurrencyCode : '')
                ->setGiftWrapTaxAmount(isset($orderProduct->GiftWrapTax->Amount) ? $orderProduct->GiftWrapTax->Amount : '')
                ->setShippingDiscountCurrencyCode(isset($orderProduct->ShippingDiscount->CurrencyCode) ? $orderProduct->ShippingDiscount->CurrencyCode : '')
                ->setShippingDiscountAmount(isset($orderProduct->ShippingDiscount->Amount) ? $orderProduct->ShippingDiscount->Amount : '')
                ->setPromotionDiscountCurrencyCode(isset($orderProduct->PromotionDiscount->CurrencyCode) ? $orderProduct->PromotionDiscount->CurrencyCode : '')
                ->setPromotionDiscountAmount(isset($orderProduct->PromotionDiscount->Amount) ? $orderProduct->PromotionDiscount->Amount : '')
                ->setPromotionId(isset($orderProduct->PromotionIds->PromotionId) ? $orderProduct->PromotionIds->PromotionId : '')
                ->setCodFeeCurrencyCode(isset($orderProduct->CODFee->CurrencyCode) ? $orderProduct->CODFee->CurrencyCode : '')
                ->setCodFeeAmount(isset($orderProduct->CODFee->Amount) ? $orderProduct->CODFee->Amount : '')
                ->setCodFeeDiscountCurrencyCode(isset($orderProduct->CODFeeDiscount->CurrencyCode) ? $orderProduct->CODFeeDiscount->CurrencyCode : '')
                ->setCodFeeDiscountAmount(isset($orderProduct->CODFeeDiscount->Amount) ? $orderProduct->CODFeeDiscount->Amount : '')
                ->setGiftMessageText(isset($orderProduct->GiftMessageText) ? $orderProduct->GiftMessageText : '')
                ->setGiftWrapLevel(isset($orderProduct->GiftWrapLevel) ? $$orderProduct->GiftWrapLevel : '')
                ->setInvoiceRequirement(isset($orderProduct->InvoiceData->InvoiceRequirement) ? $orderProduct->InvoiceData->InvoiceRequirement : '')
                ->setBuyerSelectedInvoiceCategory(isset($orderProduct->InvoiceData->BuyerSelectedInvoiceCategory) ? $orderProduct->InvoiceData->BuyerSelectedInvoiceCategory : '')
                ->setInvoiceTitle(isset($orderProduct->InvoiceData->InvoiceTitle) ? $orderProduct->InvoiceData->InvoiceTitle : '')
                ->setInvoiceInformation(isset($orderProduct->InvoiceData->InvoiceInformation) ? $orderProduct->InvoiceData->InvoiceInformation : '')
                ->setConditionNote(isset($orderProduct->ConditionNote) ? $orderProduct->ConditionNote : '')
                ->setConditionId(isset($orderProduct->ConditionId) ? $orderProduct->ConditionId : '')
                ->setConditionSubtypeId(isset($orderProduct->ConditionSubtypeId) ? $orderProduct->ConditionSubtypeId : '')
                ->setScheduledDeliveryStartDate(isset($orderProduct->ScheduledDeliveryStartDate) ? $orderProduct->ScheduledDeliveryStartDate : '')
                ->setScheduledDeliveryEndDate(isset($orderProduct->ScheduledDeliveryEndDate) ? $orderProduct->ScheduledDeliveryEndDate : '')
                ->setPriceDesignation(isset($orderProduct->PriceDesignation) ? $orderProduct->PriceDesignation : '')
                ->setBuyerCustomizedURL(isset($orderProduct->BuyerCustomizedInfo->CustomizedURL) ? $orderProduct->BuyerCustomizedInfo->CustomizedURL : '')
                ->setOrderProductId($orderProductId)
                ->setAmazonOrderId($amazonOrderId)
        ;

        $amazonOrderProduct->save($con);
    }

    public function getLogger() {
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

    public function getAllProductsForRanking() {
        $products = ProductSaleElementsQuery::create()
                ->addJoin(ProductSaleElementsTableMap::PRODUCT_ID, ProductTableMap::ID)
                ->where(ProductSaleElementsTableMap::EAN_CODE . " is not NULL and " . ProductSaleElementsTableMap::EAN_CODE . " <> ''")
                ->where(ProductTableMap::VISIBLE . " = 1 ");

        $allProdOnline = "";
        foreach ($products as $product) {
            if (strlen($product->getRef()) < 13)
                $allProdOnline .= $product->getEanCode(). " ";
        }
        $allProdOnline = rtrim($allProdOnline);
        $this->saveRankingProducts($allProdOnline);
        
        $params = array();
        $params["tab"] = $this->getRequest()->get("tab", 'amazon-feeds');
        
        return RedirectResponse::create(
        		URL::getInstance()->absoluteUrl(
        				'/admin/module/amazonintegration/', $params
        				)
        		);
    }

    public function saveRankingProducts($allProdOnline = null) {
        if (!$allProdOnline) {
        	$this->getLogger()->error("AMAZON - get ean from input ");
            $form = $this->createForm("amazonintegration.rankings.form");
        } else {
        	$this->getLogger()->error("AMAZON - get ean from hausfabrik database");
            $form = null;
        }

        try {
            if (!$allProdOnline) {
                $data = $this->validateForm($form)->getData();
                $reference = $data['reference'];
            } else {
                $reference = $allProdOnline;
            }

            $refArray = explode(' ', $reference);
            
            $idType = 'EAN';

            include __DIR__ . '/../../Classes/API/src/MarketplaceWebServiceOrders/Samples/GetMatchingProductForIdSample.php';

            $max_time = ini_get("max_execution_time");
            ini_set('max_execution_time', 3000);
            
            // object or array of parameters
            foreach ($refArray as $ref) {
            	$this->getLogger()->error("AMAZON - get informations for ean - ". $ref);

                $idList->setId(array($ref));
                $request->setIdList($idList);
                
                $this->getLogger()->error($request);
                $result = invokeGetMatchingProductForId($service, $request);

                if ($result) {
                	$this->getLogger()->error("AMAZON - is result for ean - ". $ref);
                    include __DIR__ . '/../../Classes/API/src/MarketplaceWebServiceOrders/Products/MarketplaceWebServiceProducts/Samples/GetProductCategoriesForASINSample.php';
                    if (isset($result->GetMatchingProductForIdResult->Products)) {
                        foreach ($result->GetMatchingProductForIdResult->Products as $prd) {
                        	$this->getLogger()->error("AMAZON - result product for ean - ". $ref);
                        	$this->getLogger()->error($prd);
                        	
                        	if(is_array($prd)) {
                        		$prd = $prd[0];
                        	}
                        	
                            if ($idType == 'SellerSKU') {
                                $pse = ProductSaleElementsQuery::create()
                                        ->filterByRef($ref)
                                        ->findOne();
                                if ($pse) {
                                    $eanCode = $pse->getEanCode();
                                    $productId = $pse->getProductId();
                                } else {
                                    $eanCode = '';
                                    $productId = '';
                                }
                            } elseif ($idType == 'EAN') {
                                $pse = ProductSaleElementsQuery::create()
                                        ->filterByEanCode($ref)
                                        ->findOne();

                                if ($pse) {
                                    $productId = $pse->getProductId();
                                } else {
                                    $productId = '';
                                }

                                $eanCode = $ref;
                            }

                            if (isset($prd->Identifiers)) {
                                $asin = $prd->Identifiers->MarketplaceASIN->ASIN;
                            } else {
                                if (isset($prd->MarketplaceASIN))
                                    $asin = $prd->MarketplaceASIN->ASIN;
                                else
                                    $asin = '';
                            }
                            $this->getLogger()->error("AMAZON asin - ".$asin.' for ean '.$ref);
                            // get price from amazon
                            $amazonAPI = new AmazonAWSController;
                            $priceAmazon = $amazonAPI->getLowestPrice($eanCode);
                            $this->getLogger()->error("AMAZON - lowest price - ". $priceAmazon['lowestPrice']);
                            $this->getLogger()->error("AMAZON - list price - ". $priceAmazon['listPrice']);

                            if (isset($prd->SalesRankings->SalesRank)) {
                            	$this->getLogger()->error("AMAZON - '.$ref.' has salesRank");
                                if (is_array($prd->SalesRankings->SalesRank)) {
                                    foreach ($prd->SalesRankings->SalesRank as $ranks) {
                                        $this->saveRanking($eanCode, $productId, $ref, $asin, $ranks->Rank, $ranks->ProductCategoryId, $priceAmazon);
                                    }
                                }
                              
                                $requestCat->setASIN($asin);
                                $productCategories = invokeGetProductCategoriesForASIN($service, $requestCat);
                                
                                if ($productCategories) {
                                	$this->getLogger()->error("AMAZON - product categories");
                                	$this->getLogger()->error($productCategories);
                                    if (is_array($productCategories->GetProductCategoriesForASINResult->Self)) {
                                    	$this->getLogger()->error('AMAZON - productCategories is an array');
                                        foreach ($productCategories->GetProductCategoriesForASINResult->Self as $prodCat) {
                                        	$this->getLogger()->error('AMAZON - product category');
                                        	$this->getLogger()->error($prodCat);
                                        	
                                            $this->saveProductCategories($prodCat);
                                        }
                                    } else {
                                    	$this->getLogger()->error('AMAZON - productCategories is an object');
                                        $this->saveProductCategories($productCategories->GetProductCategoriesForASINResult->Self);
                                    }
                                }                                
                            }
                            else {
                                $this->saveRanking($eanCode, $productId, $ref, $asin, '', '', $priceAmazon);
                                $this->getLogger()->error($ref . " doesn't have SalesRankings");
                            }
                        }
                    } else {
                        $this->getLogger()->error($ref . " is an invalid EAN for the marketplace ");
                    }
                } else {
                    echo ('error decoding json');
                }
                
                sleep(3);
            }

            ini_set('max_execution_time', $max_time);
            $params = array();
            $params["tab"] = $this->getRequest()->get("tab", 'amazon-feeds');

            return RedirectResponse::create(
                            URL::getInstance()->absoluteUrl(
                                    '/admin/module/amazonintegration/', $params
                            )
            );
        } catch (\Exception $e) {
            $this->setupFormErrorContext(
                    $this->getTranslator()->trans("Error on insert ref : %message", ["message" => $e->getMessage()], AmazonIntegration::DOMAIN_NAME), $e->getMessage(), $form
            );

            return self::viewAction();
        }

    }

    public function saveRanking($eanCode, $productId, $ref, $asin, $rank, $productCat, $priceAmazon) {
        $prodAmazon = new ProductAmazon();
        $prodAmazon->setEanCode($eanCode)
                ->setProductId($productId)
                ->setRef($ref)
                ->setASIN($asin)
                ->setRanking($rank)
                ->setAmazonCategoryId($productCat)
                ->setLowestPrice($priceAmazon['lowestPrice'])
                ->setListPrice($priceAmazon['listPrice'])
                ->save();
    }

    public function saveProductCategories($productCategories) {
        if (isset($productCategories->ProductCategoryId)) {
        	$this->getLogger()->error('Amazon categories - product category id - '.$productCategories->ProductCategoryId);
            $checkProductCategory = AmazonProductCategoryQuery::create()
                    ->filterByCategoryId($productCategories->ProductCategoryId)
                    ->findOne();

            if (!$checkProductCategory) {
            	$this->getLogger()->error('Amazon categories - product category id is not in database - '.$productCategories->ProductCategoryId);
                if (isset($productCategories->Parent)) {
                    $parentId = $productCategories->Parent->ProductCategoryId;
                } else {
                    $parentId = 0;
                }
                   
                $prodCat = $productCategories->ProductCategoryId;
                $prodCatName = $productCategories->ProductCategoryName;
                    
                    $this->getLogger()->error('Amazon categories - parent id: '.$parentId);
                    $this->getLogger()->error('Amazon categories - prod cat id '.$prodCat);
                    $this->getLogger()->error('Amazon categories - prod cat name '.$prodCatName);
                    
                $prodCategoryAmazon = new AmazonProductCategory();                
                $prodCategoryAmazon->setCategoryId($prodCat)
                        ->setParentId($parentId)
                        ->setName($prodCatName)
                		->save();
                
                $this->getLogger()->error($prodCategoryAmazon);
                
                if (isset($productCategories->Parent)) {
                    $this->saveProductCategories($productCategories->Parent);
                }
            }
            else {
            	$this->getLogger()->error('the category '.$productCategories->ProductCategoryId. ' already exists in DB');
            }
        }
    }

}
