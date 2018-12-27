<?php
    
    namespace RevenueDashboard\Listener;
    
    use MultipleFullfilmentCenters\Model\FulfilmentCenterOrderQuery;
    use MultipleFullfilmentCenters\Model\Map\FulfilmentCenterOrderTableMap;
    use MultipleFullfilmentCenters\Model\Map\FulfilmentCenterTableMap;
    use RevenueDashboard\Controller\Admin\OrderProductRevenueController;
    use RevenueDashboard\Model\OrderProductRevenueQuery;
    use RevenueDashboard\Model\OrderRevenue;
    use RevenueDashboard\Model\OrderRevenueQuery;
    use RevenueDashboard\Model\WholesalePartnerProductQuery;
    use RevenueDashboard\RevenueDashboard;
    use Symfony\Component\EventDispatcher\EventSubscriberInterface;
    use Thelia\Action\BaseAction;
    use Thelia\Core\Event\Order\OrderEvent;
    use Thelia\Core\Event\TheliaEvents;
    use Thelia\Core\HttpFoundation\Request;
    use Thelia\Log\Tlog;
    use Thelia\Model\OrderProductQuery;
    use Thelia\Model\OrderQuery;
    use Thelia\Model\ProductQuery;
    use Thelia\Propel\Runtime\Parser\StringParser;

    /**
     * Description of OrderRevenueListener
     *
     * @author Catana Florin
     */
    class OrderRevenueListener extends BaseAction implements EventSubscriberInterface
    {
        
        protected $request;
        
        public function __construct(Request $request)
        {
            $this->request = $request;
        }
        
        /**
         * Returns an array of event names this subscriber wants to listen to.
         *
         * The array keys are event names and the value can be:
         *
         *  * The method name to call (priority defaults to 0)
         *  * An array composed of the method name to call and the priority
         *  * An array of arrays composed of the method names to call and respective
         *    priorities, or 0 if unset
         *
         * For instance:
         *
         *  * array('eventName' => 'methodName')
         *  * array('eventName' => array('methodName', $priority))
         *  * array('eventName' => array(array('methodName1', $priority), array('methodName2'))
         *
         * @return array The event names to listen to
         *
         * @api
         */
        public static function getSubscribedEvents()
        {
            return array(
//                TheliaEvents::ORDER_UPDATE_STATUS => array("updateOrderStatus", 128),
                
                /*
                 * I have disabled this event as it was triggering when the order was updated manually and since we're
                 * doing it automatically now, it's better if it's commented out. I also kept the methods just in case
                 *  it has utility in different places.
                 */
                
                TheliaEvents::ORDER_SEND_CONFIRMATION_EMAIL => array("updateWPPonOrderCreate", 128)
            );
        }
        
        public function updateOrderStatus(OrderEvent $event)
        {
            $completedStatus = 8;
            $newStatus = $event->getStatus();
            $order = $event->getOrder();
            
            if ($completedStatus == $newStatus) {
                $this->updateOrderRevenue($order->getId());
            }
        }
        
        protected function updateOrderRevenue($orderId)
        {
            $orderProdRevenue = OrderProductRevenueQuery::create()
                ->findByOrderId($orderId);
            
            $orderRevenue = OrderRevenueQuery::create()
                ->findByOrderId($orderId);
            
            $paymentProcessorCost = $this->getDeliveryCostMethodPay($orderId);
            $totalPaymentProcessorCost = $paymentProcessorCost["cost_module"] + $paymentProcessorCost["cost_transaction_module"];
            $deliveryCostMethod = $this->getDeliveryCostMethod($orderId);
            
            if ($orderRevenue->getData()) {
                foreach ($orderRevenue as $orderRev) {
                    $orderRev->delete();
                }
            }
            foreach ($orderProdRevenue as $value) {
                $this->addNewOrderRevenue($value, $paymentProcessorCost, $totalPaymentProcessorCost, $deliveryCostMethod);
            }
        }
        
        protected function getDeliveryCostMethodPay($orderId)
        {
            $order = OrderQuery::create()
                ->findOneById($orderId);
            
            $payment_module_id = 0;
            
            if ($order) {
                $payment_module_id = $order->getPaymentModuleId();
            }
            
            return array(
                "cost_module" => RevenueDashboard::getConfigValue('cost_module_' . $payment_module_id),
                "cost_transaction_module" => RevenueDashboard::getConfigValue('cost_transaction_module_' . $payment_module_id)
            );
        }
        
        protected function getDeliveryCostMethod($orderId)
        {
            $center = FulfilmentCenterOrderQuery::create()
                ->addJoin(FulfilmentCenterOrderTableMap::CENTER_ID, FulfilmentCenterTableMap::ID)
                ->withColumn(FulfilmentCenterTableMap::DELIVERY_COST, 'delivery_cost')
                ->withColumn(FulfilmentCenterTableMap::DELIVERY_METHOD, 'delivery_method')
                ->findOneByOrderId($orderId);
            
            if ($center) {
                return array(
                    "delivery_cost" => $center->getVirtualColumn("delivery_cost"),
                    "delivery_method" => $center->getVirtualColumn("delivery_method")
                );
            }
            
            return array(
                "delivery_cost" => RevenueDashboard::getConfigValue('delivery_cost'),
                "delivery_method" => RevenueDashboard::getConfigValue('delivery_method')
            );
        }
        
        protected function addNewOrderRevenue($orderProdRevenue, $paymentProcessorCost, $totalPaymentProcessorCost, $deliveryCostMethod)
        {
            $orderProduct = OrderProductQuery::create()
                ->filterByOrderId($orderProdRevenue->getOrderId())
                ->findOneByProductRef($orderProdRevenue->getProductRef());
            
            $orderQuantity = $orderProduct->getQuantity();
            $sellPrice = $orderProdRevenue->getPrice() * $orderQuantity;
            $purchasePrice = $orderProdRevenue->getPurchasePrice() * $orderQuantity;
            
            $newOrderRevenue = new OrderRevenue();
            $newOrderRevenue->setDeliveryCost($deliveryCostMethod["delivery_cost"]);
            $newOrderRevenue->setOrderId($orderProdRevenue->getOrderId());
            $newOrderRevenue->setDeliveryMethod($deliveryCostMethod["delivery_method"]);
            $newOrderRevenue->setPartnerId($orderProdRevenue->getPartnerId());
            $newOrderRevenue->setPaymentProcessorCost($totalPaymentProcessorCost);
            $newOrderRevenue->setPrice($sellPrice);
            $newOrderRevenue->setPurchasePrice($purchasePrice);
            $totalPurchasePrice = $purchasePrice + $deliveryCostMethod["delivery_cost"] + $totalPaymentProcessorCost;
            
            $newOrderRevenue->setTotalPurchasePrice($totalPurchasePrice);
            $newOrderRevenue->setRevenue($sellPrice - $totalPurchasePrice);
            $newOrderRevenue->save();
        }
        
        /*
         *Listener method call, it gets the Event object from the event, it fetches the Order Id from the event
         *Based on the order id it gets the products from the order_products, gets the required information such as
         *price, quantity, id, etc and sets the individual product entry in order_product_revenue, based on which the
         *total order cost is calculated in the updateNewOrderRevenue method.
         */
        
        public function updateWPPonOrderCreate(OrderEvent $event)
        {
            $orderStatus = $event->getStatus();
            $order = $event->getOrder();
            $order_id = $order->getId();
            
            $oprc = new OrderProductRevenueController();
            
            $order_query = OrderQuery::create()
                ->findOneById($order_id);
            
            $orderProducts = null;
            $orderProductQuery = OrderProductQuery::create();
            $orderProducts = $orderProductQuery->filterByOrderId($order_id)->find();
            
            
            foreach ($orderProducts as $orderProduct) {
                $wholesalePartnerProd = new WholesalePartnerProductQuery();
                
                Tlog::getInstance()->info("In foreach: prod X REF: " . $orderProduct->getProductRef());
                
                $order_query_prodRef = $orderProduct->getProductRef();
                
                $prod_query = ProductQuery::create();
                $prod_id = $prod_query->findOneByRef($order_query_prodRef);
                
                $order_query_price = $orderProduct->getPrice();
                $order_query_partnerId = 1;
                $order_query_prodId = $prod_id->getId();
                
                Tlog::getInstance()->info("In foreach: prod X ID: " . $order_query_prodId);
                
                $order_quantity = $orderProduct->getQuantity();
                
                $wpp_item = $wholesalePartnerProd->findOneByProductId($order_query_prodId);
                
                if ($wpp_item != null) {
                    Tlog::getInstance()->info("In foreach: prod X WPP CHECK: " . $wpp_item->getId());
                    $order_query_purchasePrice = $wpp_item->getPrice();
                    
                    $oprc->updateOrderProductRevenue($order_id, $order_query_prodRef, $order_query_price, $order_query_purchasePrice, $order_query_partnerId, $order_query_prodId);
                    
                }
                
            }
            $this->createNewOrderRevenue($order_id);
        }
        
        /*
         * Updates the order revenue table based on the individual revenue per the product in order_product_revenue.
         * It receives the parent order id in the method call, it gets the general costs (transport+processing)
         * It searches for each individual product from the order, adds up the total costs and then updates the
         * Order Revenue table with the TOTAL cost WITHOUT VAT!
         */
        
        protected function createNewOrderRevenue($orderId)
        {
            $orderRevQuery = OrderRevenueQuery::create();
            $foundExistingOrderRevenue = $orderRevQuery->findOneByOrderId($orderId);
            $foundProductCount = count($foundExistingOrderRevenue);
            
            if ($foundProductCount == 0) {
                $orderProdRevenue = OrderProductRevenueQuery::create()
                    ->findByOrderId($orderId);
                
                $paymentProcessorCost = $this->getDeliveryCostMethodPay($orderId);
                $totalPaymentProcessorCost = $paymentProcessorCost["cost_module"] + $paymentProcessorCost["cost_transaction_module"];
                $deliveryCostMethod = $this->getDeliveryCostMethod($orderId);
                
                $sellPrice = null;
                $purchasePrice = null;
                
                foreach ($orderProdRevenue as $value) {
                    $orderProduct = OrderProductQuery::create()
                        ->filterByOrderId($value->getOrderId())
                        ->findOneByProductRef($value->getProductRef());
                    
                    $orderQuantity = $orderProduct->getQuantity();
                    $sellPrice += $value->getPrice() * $orderQuantity;
                    
                    $purchasePrice += $value->getPurchasePrice() * $orderQuantity;
                }
                
                
                $newOrderRevenue = new OrderRevenue();
                $newOrderRevenue->setDeliveryCost($deliveryCostMethod["delivery_cost"]);
                $newOrderRevenue->setOrderId($orderId);
                $newOrderRevenue->setDeliveryMethod($deliveryCostMethod["delivery_method"]);
                $newOrderRevenue->setPartnerId(1);
                $newOrderRevenue->setPaymentProcessorCost($totalPaymentProcessorCost);
                $newOrderRevenue->setPrice($sellPrice);
                $newOrderRevenue->setPurchasePrice($purchasePrice);
                $totalPurchasePrice = $purchasePrice + $deliveryCostMethod["delivery_cost"] + $totalPaymentProcessorCost;
                
                $newOrderRevenue->setTotalPurchasePrice($totalPurchasePrice);
                $newOrderRevenue->setRevenue($sellPrice - $totalPurchasePrice);
                $newOrderRevenue->save();
                
            }
        }
        
    }
