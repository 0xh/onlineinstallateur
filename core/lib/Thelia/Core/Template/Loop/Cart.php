<?php
/*************************************************************************************/
/*      This file is part of the Thelia package.                                     */
/*                                                                                   */
/*      Copyright (c) OpenStudio                                                     */
/*      email : dev@thelia.net                                                       */
/*      web : http://www.thelia.net                                                  */
/*                                                                                   */
/*      For the full copyright and license information, please view the LICENSE.txt  */
/*      file that was distributed with this source code.                             */
/*************************************************************************************/

namespace Thelia\Core\Template\Loop;

use Thelia\Core\Template\Element\ArraySearchLoopInterface;
use Thelia\Core\Template\Element\BaseLoop;
use Thelia\Core\Template\Element\LoopResult;
use Thelia\Core\Template\Element\LoopResultRow;
use Thelia\Core\Template\Loop\Argument\Argument;
use Thelia\Core\Template\Loop\Argument\ArgumentCollection;
use Thelia\Model\CartItem as CartItemModel;
use Thelia\Model\ConfigQuery;
use Thelia\Model\Cart as CartModel;
use Thelia\Type;
use Thelia\Model\CategoryQuery;
use Thelia\Log\Tlog;
use MultipleFullfilmentCenters\Model\OrderLocalPickupQuery;

/**
 *
 * Cart Loop
 *
 *
 * Class Cart
 * @package Thelia\Core\Template\Loop
 *
 * {@inheritdoc}
 * @method string[] getOrder()
 */
class Cart extends BaseLoop implements ArraySearchLoopInterface
{
    /**
     *
     * @return \Thelia\Core\Template\Loop\Argument\ArgumentCollection
     */
    protected function getArgDefinitions()
    {
        return new ArgumentCollection(
            new Argument(
                'order',
                new Type\TypeCollection(
                    new Type\EnumListType(array('normal', 'reverse'))
                ),
                'normal'
            )
        );
    }

    public function buildArray()
    {
        /** @var CartModel $cart */
        $cart = $this->getCurrentRequest()->getSession()->getSessionCart($this->getDispatcher());

        if (null === $cart) {
            return array();
        }

        $returnArray = iterator_to_array($cart->getCartItems());
        $orders  = $this->getOrder();

        foreach ($orders as $order) {
            switch ($order) {
                case "reverse":
                    $returnArray = array_reverse($returnArray, false);
                    break;
            }
        }
        return $returnArray;
    }

    public function parseResults(LoopResult $loopResult)
    {
        $taxCountry = $this->container->get('thelia.taxEngine')->getDeliveryCountry();
        $locale = $this->getCurrentRequest()->getSession()->getLang()->getLocale();
        $checkAvailability = ConfigQuery::checkAvailableStock();
        $defaultAvailability = intval(ConfigQuery::read('default-available-stock', 100));
        
        $log = Tlog::getInstance ();


        /** @var CartItemModel $cartItem */
        foreach ($loopResult->getResultDataCollection() as $cartItem) {
        	
        	if(count($cartItem->getSpStartTs())>0)
        	$log->debug ( "-- CartItemLoop ".implode(" ", $cartItem->getSpStartTs()));
        	else
        		$log->debug("-- CartItemLoop appointment is lost");
        	
            $product = $cartItem->getProduct(null, $locale);
            $productSaleElement = $cartItem->getProductSaleElements();

            $loopResultRow = new LoopResultRow();

            $loopResultRow->set("ITEM_ID", $cartItem->getId());
            $loopResultRow->set("TITLE", $product->getTitle());
            $loopResultRow->set("REF", $product->getRef());
            $loopResultRow->set("QUANTITY", $cartItem->getQuantity());
            $loopResultRow->set("PRODUCT_ID", $product->getId());
            $loopResultRow->set("PRODUCT_URL", $product->getUrl($this->getCurrentRequest()->getSession()->getLang()->getLocale()));
            if (!$checkAvailability || $product->getVirtual() === 1) {
                $loopResultRow->set("STOCK", $defaultAvailability);
            } else {
                $loopResultRow->set("STOCK", $productSaleElement->getQuantity());
            }
            $loopResultRow->set("PRICE", $cartItem->getPrice())
                ->set("PROMO_PRICE", $cartItem->getPromoPrice())
                ->set("TAXED_PRICE", round($cartItem->getTaxedPrice($taxCountry),2))
                ->set("PROMO_TAXED_PRICE", round($cartItem->getTaxedPromoPrice($taxCountry),2))
                ->set("IS_PROMO", $cartItem->getPromo() === 1 ? 1 : 0);
            $loopResultRow->set("TOTAL_PRICE", $cartItem->getPrice()*$cartItem->getQuantity())
                ->set("TOTAL_PROMO_PRICE", $cartItem->getPromoPrice()*$cartItem->getQuantity())
                ->set("TOTAL_TAXED_PRICE", round($cartItem->getTotalTaxedPrice($taxCountry),2))
                ->set("TOTAL_PROMO_TAXED_PRICE", round($cartItem->getTotalTaxedPromoPrice($taxCountry),2));
            $loopResultRow->set("PRODUCT_SALE_ELEMENTS_ID", $productSaleElement->getId());
            $loopResultRow->set("PRODUCT_SALE_ELEMENTS_REF", $productSaleElement->getRef());
            $loopResultRow->set("ID", $cartItem->getCartId());
            $loopResultRow->set("DELIVERY_MODULE_ID", $this->getCurrentRequest()->getSession()->getOrder()->getDeliveryModuleId());
            
            // get chosen fulfilment center id
            if($this->getCurrentRequest()->getSession()->getOrder()->getDeliveryModuleId() == '49') {
	            $cartProductLocation = OrderLocalPickupQuery::create()
		            ->filterByProductId($product->getId())
		            ->filterByCartId($cartItem->getCartId())
		            ->findOne();
	            
		        if($cartProductLocation) { 
		        	$loopResultRow->set("FULFILMENT_CENTER_ID", $cartProductLocation->getFulfilmentCenterId());
		        }
            }
            
            //service appointment
            // get a query object or somewhere lower
            //category id
            // 3 priority appointments 
            
            $category = CategoryQuery::create();
            // $category->__toString()
            $resultcat = $category->findById($product->getDefaultCategoryId());
            if(count(resultcat))
            $loopResultRow->set("PRODUCT_PARENT_CATEGORY_ID",$resultcat[0]->getparent());
            
            if(count($cartItem->getSpStartTs())>0)
            $loopResultRow->set("APPOINTMENT_DATE",implode(" ", $cartItem->getSpStartTs()));
            $this->addOutputFields($loopResultRow, $cartItem);
            $loopResult->addRow($loopResultRow);
        }
     
        return $loopResult;
    }

    /**
     * Return the event dispatcher,
     *
     * @return \Symfony\Component\EventDispatcher\EventDispatcher
     */
    public function getDispatcher()
    {
        return $this->dispatcher;
    }
}
