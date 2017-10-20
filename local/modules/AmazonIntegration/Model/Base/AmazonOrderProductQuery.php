<?php

namespace AmazonIntegration\Model\Base;

use \Exception;
use \PDO;
use AmazonIntegration\Model\AmazonOrderProduct as ChildAmazonOrderProduct;
use AmazonIntegration\Model\AmazonOrderProductQuery as ChildAmazonOrderProductQuery;
use AmazonIntegration\Model\Map\AmazonOrderProductTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;
use Thelia\Model\OrderProduct;

/**
 * Base class that represents a query for the 'amazon_order_product' table.
 *
 * 
 *
 * @method     ChildAmazonOrderProductQuery orderByOrderItemId($order = Criteria::ASC) Order by the order_item_id column
 * @method     ChildAmazonOrderProductQuery orderByAmazonOrderId($order = Criteria::ASC) Order by the amazon_order_id column
 * @method     ChildAmazonOrderProductQuery orderByAsin($order = Criteria::ASC) Order by the asin column
 * @method     ChildAmazonOrderProductQuery orderBySellerSku($order = Criteria::ASC) Order by the seller_sku column
 * @method     ChildAmazonOrderProductQuery orderByTitle($order = Criteria::ASC) Order by the title column
 * @method     ChildAmazonOrderProductQuery orderByQuantityOrdered($order = Criteria::ASC) Order by the quantity_ordered column
 * @method     ChildAmazonOrderProductQuery orderByQuantityShipped($order = Criteria::ASC) Order by the quantity_shipped column
 * @method     ChildAmazonOrderProductQuery orderByPointsGrantedNumber($order = Criteria::ASC) Order by the points_granted_number column
 * @method     ChildAmazonOrderProductQuery orderByPointsGrantedCurrencyCode($order = Criteria::ASC) Order by the points_granted_currency_code column
 * @method     ChildAmazonOrderProductQuery orderByPointsGrantedAmount($order = Criteria::ASC) Order by the points_granted_amount column
 * @method     ChildAmazonOrderProductQuery orderByItemPriceCurrencyCode($order = Criteria::ASC) Order by the item_price_currency_code column
 * @method     ChildAmazonOrderProductQuery orderByItemPriceAmount($order = Criteria::ASC) Order by the item_price_amount column
 * @method     ChildAmazonOrderProductQuery orderByShippingPriceCurrencyCode($order = Criteria::ASC) Order by the shipping_price_currency_code column
 * @method     ChildAmazonOrderProductQuery orderByShippingPriceAmount($order = Criteria::ASC) Order by the shipping_price_amount column
 * @method     ChildAmazonOrderProductQuery orderByGiftWrapPriceCurrencyCode($order = Criteria::ASC) Order by the gift_wrap_price_currency_code column
 * @method     ChildAmazonOrderProductQuery orderByGiftWrapPriceAmount($order = Criteria::ASC) Order by the gift_wrap_price_amount column
 * @method     ChildAmazonOrderProductQuery orderByItemTaxCurrencyCode($order = Criteria::ASC) Order by the item_tax_currency_code column
 * @method     ChildAmazonOrderProductQuery orderByItemTaxAmount($order = Criteria::ASC) Order by the item_tax_amount column
 * @method     ChildAmazonOrderProductQuery orderByShippingTaxCurrencyCode($order = Criteria::ASC) Order by the shipping_tax_currency_code column
 * @method     ChildAmazonOrderProductQuery orderByShippingTaxAmount($order = Criteria::ASC) Order by the shipping_tax_amount column
 * @method     ChildAmazonOrderProductQuery orderByGiftWrapTaxCurrencyCode($order = Criteria::ASC) Order by the gift_wrap_tax_currency_code column
 * @method     ChildAmazonOrderProductQuery orderByGiftWrapTaxAmount($order = Criteria::ASC) Order by the gift_wrap_tax_amount column
 * @method     ChildAmazonOrderProductQuery orderByShippingDiscountCurrencyCode($order = Criteria::ASC) Order by the shipping_discount_currency_code column
 * @method     ChildAmazonOrderProductQuery orderByShippingDiscountAmount($order = Criteria::ASC) Order by the shipping_discount_amount column
 * @method     ChildAmazonOrderProductQuery orderByPromotionDiscountCurrencyCode($order = Criteria::ASC) Order by the promotion_discount_currency_code column
 * @method     ChildAmazonOrderProductQuery orderByPromotionDiscountAmount($order = Criteria::ASC) Order by the promotion_discount_amount column
 * @method     ChildAmazonOrderProductQuery orderByPromotionId($order = Criteria::ASC) Order by the promotion_id column
 * @method     ChildAmazonOrderProductQuery orderByCodFeeCurrencyCode($order = Criteria::ASC) Order by the cod_fee_currency_code column
 * @method     ChildAmazonOrderProductQuery orderByCodFeeAmount($order = Criteria::ASC) Order by the cod_fee_amount column
 * @method     ChildAmazonOrderProductQuery orderByCodFeeDiscountCurrencyCode($order = Criteria::ASC) Order by the cod_fee_discount_currency_code column
 * @method     ChildAmazonOrderProductQuery orderByCodFeeDiscountAmount($order = Criteria::ASC) Order by the cod_fee_discount_amount column
 * @method     ChildAmazonOrderProductQuery orderByGiftMessageText($order = Criteria::ASC) Order by the gift_message_text column
 * @method     ChildAmazonOrderProductQuery orderByGiftWrapLevel($order = Criteria::ASC) Order by the gift_wrap_level column
 * @method     ChildAmazonOrderProductQuery orderByInvoiceRequirement($order = Criteria::ASC) Order by the invoice_requirement column
 * @method     ChildAmazonOrderProductQuery orderByBuyerSelectedInvoiceCategory($order = Criteria::ASC) Order by the buyer_selected_invoice_category column
 * @method     ChildAmazonOrderProductQuery orderByInvoiceTitle($order = Criteria::ASC) Order by the invoice_title column
 * @method     ChildAmazonOrderProductQuery orderByInvoiceInformation($order = Criteria::ASC) Order by the invoice_information column
 * @method     ChildAmazonOrderProductQuery orderByConditionNote($order = Criteria::ASC) Order by the condition_note column
 * @method     ChildAmazonOrderProductQuery orderByConditionId($order = Criteria::ASC) Order by the condition_id column
 * @method     ChildAmazonOrderProductQuery orderByConditionSubtypeId($order = Criteria::ASC) Order by the condition_subtype_id column
 * @method     ChildAmazonOrderProductQuery orderByScheduledDeliveryStartDate($order = Criteria::ASC) Order by the schedule_delivery_start_date column
 * @method     ChildAmazonOrderProductQuery orderByScheduledDeliveryEndDate($order = Criteria::ASC) Order by the schedule_delivery_end_date column
 * @method     ChildAmazonOrderProductQuery orderByPriceDesignation($order = Criteria::ASC) Order by the price_designation column
 * @method     ChildAmazonOrderProductQuery orderByBuyerCustomizedURL($order = Criteria::ASC) Order by the buyer_customized_url column
 * @method     ChildAmazonOrderProductQuery orderByOrderProductId($order = Criteria::ASC) Order by the order_product_id column
 *
 * @method     ChildAmazonOrderProductQuery groupByOrderItemId() Group by the order_item_id column
 * @method     ChildAmazonOrderProductQuery groupByAmazonOrderId() Group by the amazon_order_id column
 * @method     ChildAmazonOrderProductQuery groupByAsin() Group by the asin column
 * @method     ChildAmazonOrderProductQuery groupBySellerSku() Group by the seller_sku column
 * @method     ChildAmazonOrderProductQuery groupByTitle() Group by the title column
 * @method     ChildAmazonOrderProductQuery groupByQuantityOrdered() Group by the quantity_ordered column
 * @method     ChildAmazonOrderProductQuery groupByQuantityShipped() Group by the quantity_shipped column
 * @method     ChildAmazonOrderProductQuery groupByPointsGrantedNumber() Group by the points_granted_number column
 * @method     ChildAmazonOrderProductQuery groupByPointsGrantedCurrencyCode() Group by the points_granted_currency_code column
 * @method     ChildAmazonOrderProductQuery groupByPointsGrantedAmount() Group by the points_granted_amount column
 * @method     ChildAmazonOrderProductQuery groupByItemPriceCurrencyCode() Group by the item_price_currency_code column
 * @method     ChildAmazonOrderProductQuery groupByItemPriceAmount() Group by the item_price_amount column
 * @method     ChildAmazonOrderProductQuery groupByShippingPriceCurrencyCode() Group by the shipping_price_currency_code column
 * @method     ChildAmazonOrderProductQuery groupByShippingPriceAmount() Group by the shipping_price_amount column
 * @method     ChildAmazonOrderProductQuery groupByGiftWrapPriceCurrencyCode() Group by the gift_wrap_price_currency_code column
 * @method     ChildAmazonOrderProductQuery groupByGiftWrapPriceAmount() Group by the gift_wrap_price_amount column
 * @method     ChildAmazonOrderProductQuery groupByItemTaxCurrencyCode() Group by the item_tax_currency_code column
 * @method     ChildAmazonOrderProductQuery groupByItemTaxAmount() Group by the item_tax_amount column
 * @method     ChildAmazonOrderProductQuery groupByShippingTaxCurrencyCode() Group by the shipping_tax_currency_code column
 * @method     ChildAmazonOrderProductQuery groupByShippingTaxAmount() Group by the shipping_tax_amount column
 * @method     ChildAmazonOrderProductQuery groupByGiftWrapTaxCurrencyCode() Group by the gift_wrap_tax_currency_code column
 * @method     ChildAmazonOrderProductQuery groupByGiftWrapTaxAmount() Group by the gift_wrap_tax_amount column
 * @method     ChildAmazonOrderProductQuery groupByShippingDiscountCurrencyCode() Group by the shipping_discount_currency_code column
 * @method     ChildAmazonOrderProductQuery groupByShippingDiscountAmount() Group by the shipping_discount_amount column
 * @method     ChildAmazonOrderProductQuery groupByPromotionDiscountCurrencyCode() Group by the promotion_discount_currency_code column
 * @method     ChildAmazonOrderProductQuery groupByPromotionDiscountAmount() Group by the promotion_discount_amount column
 * @method     ChildAmazonOrderProductQuery groupByPromotionId() Group by the promotion_id column
 * @method     ChildAmazonOrderProductQuery groupByCodFeeCurrencyCode() Group by the cod_fee_currency_code column
 * @method     ChildAmazonOrderProductQuery groupByCodFeeAmount() Group by the cod_fee_amount column
 * @method     ChildAmazonOrderProductQuery groupByCodFeeDiscountCurrencyCode() Group by the cod_fee_discount_currency_code column
 * @method     ChildAmazonOrderProductQuery groupByCodFeeDiscountAmount() Group by the cod_fee_discount_amount column
 * @method     ChildAmazonOrderProductQuery groupByGiftMessageText() Group by the gift_message_text column
 * @method     ChildAmazonOrderProductQuery groupByGiftWrapLevel() Group by the gift_wrap_level column
 * @method     ChildAmazonOrderProductQuery groupByInvoiceRequirement() Group by the invoice_requirement column
 * @method     ChildAmazonOrderProductQuery groupByBuyerSelectedInvoiceCategory() Group by the buyer_selected_invoice_category column
 * @method     ChildAmazonOrderProductQuery groupByInvoiceTitle() Group by the invoice_title column
 * @method     ChildAmazonOrderProductQuery groupByInvoiceInformation() Group by the invoice_information column
 * @method     ChildAmazonOrderProductQuery groupByConditionNote() Group by the condition_note column
 * @method     ChildAmazonOrderProductQuery groupByConditionId() Group by the condition_id column
 * @method     ChildAmazonOrderProductQuery groupByConditionSubtypeId() Group by the condition_subtype_id column
 * @method     ChildAmazonOrderProductQuery groupByScheduledDeliveryStartDate() Group by the schedule_delivery_start_date column
 * @method     ChildAmazonOrderProductQuery groupByScheduledDeliveryEndDate() Group by the schedule_delivery_end_date column
 * @method     ChildAmazonOrderProductQuery groupByPriceDesignation() Group by the price_designation column
 * @method     ChildAmazonOrderProductQuery groupByBuyerCustomizedURL() Group by the buyer_customized_url column
 * @method     ChildAmazonOrderProductQuery groupByOrderProductId() Group by the order_product_id column
 *
 * @method     ChildAmazonOrderProductQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildAmazonOrderProductQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildAmazonOrderProductQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildAmazonOrderProductQuery leftJoinOrderProduct($relationAlias = null) Adds a LEFT JOIN clause to the query using the OrderProduct relation
 * @method     ChildAmazonOrderProductQuery rightJoinOrderProduct($relationAlias = null) Adds a RIGHT JOIN clause to the query using the OrderProduct relation
 * @method     ChildAmazonOrderProductQuery innerJoinOrderProduct($relationAlias = null) Adds a INNER JOIN clause to the query using the OrderProduct relation
 *
 * @method     ChildAmazonOrderProductQuery leftJoinAmazonOrders($relationAlias = null) Adds a LEFT JOIN clause to the query using the AmazonOrders relation
 * @method     ChildAmazonOrderProductQuery rightJoinAmazonOrders($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AmazonOrders relation
 * @method     ChildAmazonOrderProductQuery innerJoinAmazonOrders($relationAlias = null) Adds a INNER JOIN clause to the query using the AmazonOrders relation
 *
 * @method     ChildAmazonOrderProduct findOne(ConnectionInterface $con = null) Return the first ChildAmazonOrderProduct matching the query
 * @method     ChildAmazonOrderProduct findOneOrCreate(ConnectionInterface $con = null) Return the first ChildAmazonOrderProduct matching the query, or a new ChildAmazonOrderProduct object populated from the query conditions when no match is found
 *
 * @method     ChildAmazonOrderProduct findOneByOrderItemId(string $order_item_id) Return the first ChildAmazonOrderProduct filtered by the order_item_id column
 * @method     ChildAmazonOrderProduct findOneByAmazonOrderId(string $amazon_order_id) Return the first ChildAmazonOrderProduct filtered by the amazon_order_id column
 * @method     ChildAmazonOrderProduct findOneByAsin(string $asin) Return the first ChildAmazonOrderProduct filtered by the asin column
 * @method     ChildAmazonOrderProduct findOneBySellerSku(string $seller_sku) Return the first ChildAmazonOrderProduct filtered by the seller_sku column
 * @method     ChildAmazonOrderProduct findOneByTitle(string $title) Return the first ChildAmazonOrderProduct filtered by the title column
 * @method     ChildAmazonOrderProduct findOneByQuantityOrdered(double $quantity_ordered) Return the first ChildAmazonOrderProduct filtered by the quantity_ordered column
 * @method     ChildAmazonOrderProduct findOneByQuantityShipped(double $quantity_shipped) Return the first ChildAmazonOrderProduct filtered by the quantity_shipped column
 * @method     ChildAmazonOrderProduct findOneByPointsGrantedNumber(double $points_granted_number) Return the first ChildAmazonOrderProduct filtered by the points_granted_number column
 * @method     ChildAmazonOrderProduct findOneByPointsGrantedCurrencyCode(string $points_granted_currency_code) Return the first ChildAmazonOrderProduct filtered by the points_granted_currency_code column
 * @method     ChildAmazonOrderProduct findOneByPointsGrantedAmount(string $points_granted_amount) Return the first ChildAmazonOrderProduct filtered by the points_granted_amount column
 * @method     ChildAmazonOrderProduct findOneByItemPriceCurrencyCode(string $item_price_currency_code) Return the first ChildAmazonOrderProduct filtered by the item_price_currency_code column
 * @method     ChildAmazonOrderProduct findOneByItemPriceAmount(string $item_price_amount) Return the first ChildAmazonOrderProduct filtered by the item_price_amount column
 * @method     ChildAmazonOrderProduct findOneByShippingPriceCurrencyCode(string $shipping_price_currency_code) Return the first ChildAmazonOrderProduct filtered by the shipping_price_currency_code column
 * @method     ChildAmazonOrderProduct findOneByShippingPriceAmount(string $shipping_price_amount) Return the first ChildAmazonOrderProduct filtered by the shipping_price_amount column
 * @method     ChildAmazonOrderProduct findOneByGiftWrapPriceCurrencyCode(string $gift_wrap_price_currency_code) Return the first ChildAmazonOrderProduct filtered by the gift_wrap_price_currency_code column
 * @method     ChildAmazonOrderProduct findOneByGiftWrapPriceAmount(string $gift_wrap_price_amount) Return the first ChildAmazonOrderProduct filtered by the gift_wrap_price_amount column
 * @method     ChildAmazonOrderProduct findOneByItemTaxCurrencyCode(string $item_tax_currency_code) Return the first ChildAmazonOrderProduct filtered by the item_tax_currency_code column
 * @method     ChildAmazonOrderProduct findOneByItemTaxAmount(string $item_tax_amount) Return the first ChildAmazonOrderProduct filtered by the item_tax_amount column
 * @method     ChildAmazonOrderProduct findOneByShippingTaxCurrencyCode(string $shipping_tax_currency_code) Return the first ChildAmazonOrderProduct filtered by the shipping_tax_currency_code column
 * @method     ChildAmazonOrderProduct findOneByShippingTaxAmount(string $shipping_tax_amount) Return the first ChildAmazonOrderProduct filtered by the shipping_tax_amount column
 * @method     ChildAmazonOrderProduct findOneByGiftWrapTaxCurrencyCode(string $gift_wrap_tax_currency_code) Return the first ChildAmazonOrderProduct filtered by the gift_wrap_tax_currency_code column
 * @method     ChildAmazonOrderProduct findOneByGiftWrapTaxAmount(string $gift_wrap_tax_amount) Return the first ChildAmazonOrderProduct filtered by the gift_wrap_tax_amount column
 * @method     ChildAmazonOrderProduct findOneByShippingDiscountCurrencyCode(string $shipping_discount_currency_code) Return the first ChildAmazonOrderProduct filtered by the shipping_discount_currency_code column
 * @method     ChildAmazonOrderProduct findOneByShippingDiscountAmount(string $shipping_discount_amount) Return the first ChildAmazonOrderProduct filtered by the shipping_discount_amount column
 * @method     ChildAmazonOrderProduct findOneByPromotionDiscountCurrencyCode(string $promotion_discount_currency_code) Return the first ChildAmazonOrderProduct filtered by the promotion_discount_currency_code column
 * @method     ChildAmazonOrderProduct findOneByPromotionDiscountAmount(string $promotion_discount_amount) Return the first ChildAmazonOrderProduct filtered by the promotion_discount_amount column
 * @method     ChildAmazonOrderProduct findOneByPromotionId(string $promotion_id) Return the first ChildAmazonOrderProduct filtered by the promotion_id column
 * @method     ChildAmazonOrderProduct findOneByCodFeeCurrencyCode(string $cod_fee_currency_code) Return the first ChildAmazonOrderProduct filtered by the cod_fee_currency_code column
 * @method     ChildAmazonOrderProduct findOneByCodFeeAmount(string $cod_fee_amount) Return the first ChildAmazonOrderProduct filtered by the cod_fee_amount column
 * @method     ChildAmazonOrderProduct findOneByCodFeeDiscountCurrencyCode(string $cod_fee_discount_currency_code) Return the first ChildAmazonOrderProduct filtered by the cod_fee_discount_currency_code column
 * @method     ChildAmazonOrderProduct findOneByCodFeeDiscountAmount(string $cod_fee_discount_amount) Return the first ChildAmazonOrderProduct filtered by the cod_fee_discount_amount column
 * @method     ChildAmazonOrderProduct findOneByGiftMessageText(string $gift_message_text) Return the first ChildAmazonOrderProduct filtered by the gift_message_text column
 * @method     ChildAmazonOrderProduct findOneByGiftWrapLevel(string $gift_wrap_level) Return the first ChildAmazonOrderProduct filtered by the gift_wrap_level column
 * @method     ChildAmazonOrderProduct findOneByInvoiceRequirement(string $invoice_requirement) Return the first ChildAmazonOrderProduct filtered by the invoice_requirement column
 * @method     ChildAmazonOrderProduct findOneByBuyerSelectedInvoiceCategory(string $buyer_selected_invoice_category) Return the first ChildAmazonOrderProduct filtered by the buyer_selected_invoice_category column
 * @method     ChildAmazonOrderProduct findOneByInvoiceTitle(string $invoice_title) Return the first ChildAmazonOrderProduct filtered by the invoice_title column
 * @method     ChildAmazonOrderProduct findOneByInvoiceInformation(string $invoice_information) Return the first ChildAmazonOrderProduct filtered by the invoice_information column
 * @method     ChildAmazonOrderProduct findOneByConditionNote(string $condition_note) Return the first ChildAmazonOrderProduct filtered by the condition_note column
 * @method     ChildAmazonOrderProduct findOneByConditionId(string $condition_id) Return the first ChildAmazonOrderProduct filtered by the condition_id column
 * @method     ChildAmazonOrderProduct findOneByConditionSubtypeId(string $condition_subtype_id) Return the first ChildAmazonOrderProduct filtered by the condition_subtype_id column
 * @method     ChildAmazonOrderProduct findOneByScheduledDeliveryStartDate(string $schedule_delivery_start_date) Return the first ChildAmazonOrderProduct filtered by the schedule_delivery_start_date column
 * @method     ChildAmazonOrderProduct findOneByScheduledDeliveryEndDate(string $schedule_delivery_end_date) Return the first ChildAmazonOrderProduct filtered by the schedule_delivery_end_date column
 * @method     ChildAmazonOrderProduct findOneByPriceDesignation(string $price_designation) Return the first ChildAmazonOrderProduct filtered by the price_designation column
 * @method     ChildAmazonOrderProduct findOneByBuyerCustomizedURL(string $buyer_customized_url) Return the first ChildAmazonOrderProduct filtered by the buyer_customized_url column
 * @method     ChildAmazonOrderProduct findOneByOrderProductId(int $order_product_id) Return the first ChildAmazonOrderProduct filtered by the order_product_id column
 *
 * @method     array findByOrderItemId(string $order_item_id) Return ChildAmazonOrderProduct objects filtered by the order_item_id column
 * @method     array findByAmazonOrderId(string $amazon_order_id) Return ChildAmazonOrderProduct objects filtered by the amazon_order_id column
 * @method     array findByAsin(string $asin) Return ChildAmazonOrderProduct objects filtered by the asin column
 * @method     array findBySellerSku(string $seller_sku) Return ChildAmazonOrderProduct objects filtered by the seller_sku column
 * @method     array findByTitle(string $title) Return ChildAmazonOrderProduct objects filtered by the title column
 * @method     array findByQuantityOrdered(double $quantity_ordered) Return ChildAmazonOrderProduct objects filtered by the quantity_ordered column
 * @method     array findByQuantityShipped(double $quantity_shipped) Return ChildAmazonOrderProduct objects filtered by the quantity_shipped column
 * @method     array findByPointsGrantedNumber(double $points_granted_number) Return ChildAmazonOrderProduct objects filtered by the points_granted_number column
 * @method     array findByPointsGrantedCurrencyCode(string $points_granted_currency_code) Return ChildAmazonOrderProduct objects filtered by the points_granted_currency_code column
 * @method     array findByPointsGrantedAmount(string $points_granted_amount) Return ChildAmazonOrderProduct objects filtered by the points_granted_amount column
 * @method     array findByItemPriceCurrencyCode(string $item_price_currency_code) Return ChildAmazonOrderProduct objects filtered by the item_price_currency_code column
 * @method     array findByItemPriceAmount(string $item_price_amount) Return ChildAmazonOrderProduct objects filtered by the item_price_amount column
 * @method     array findByShippingPriceCurrencyCode(string $shipping_price_currency_code) Return ChildAmazonOrderProduct objects filtered by the shipping_price_currency_code column
 * @method     array findByShippingPriceAmount(string $shipping_price_amount) Return ChildAmazonOrderProduct objects filtered by the shipping_price_amount column
 * @method     array findByGiftWrapPriceCurrencyCode(string $gift_wrap_price_currency_code) Return ChildAmazonOrderProduct objects filtered by the gift_wrap_price_currency_code column
 * @method     array findByGiftWrapPriceAmount(string $gift_wrap_price_amount) Return ChildAmazonOrderProduct objects filtered by the gift_wrap_price_amount column
 * @method     array findByItemTaxCurrencyCode(string $item_tax_currency_code) Return ChildAmazonOrderProduct objects filtered by the item_tax_currency_code column
 * @method     array findByItemTaxAmount(string $item_tax_amount) Return ChildAmazonOrderProduct objects filtered by the item_tax_amount column
 * @method     array findByShippingTaxCurrencyCode(string $shipping_tax_currency_code) Return ChildAmazonOrderProduct objects filtered by the shipping_tax_currency_code column
 * @method     array findByShippingTaxAmount(string $shipping_tax_amount) Return ChildAmazonOrderProduct objects filtered by the shipping_tax_amount column
 * @method     array findByGiftWrapTaxCurrencyCode(string $gift_wrap_tax_currency_code) Return ChildAmazonOrderProduct objects filtered by the gift_wrap_tax_currency_code column
 * @method     array findByGiftWrapTaxAmount(string $gift_wrap_tax_amount) Return ChildAmazonOrderProduct objects filtered by the gift_wrap_tax_amount column
 * @method     array findByShippingDiscountCurrencyCode(string $shipping_discount_currency_code) Return ChildAmazonOrderProduct objects filtered by the shipping_discount_currency_code column
 * @method     array findByShippingDiscountAmount(string $shipping_discount_amount) Return ChildAmazonOrderProduct objects filtered by the shipping_discount_amount column
 * @method     array findByPromotionDiscountCurrencyCode(string $promotion_discount_currency_code) Return ChildAmazonOrderProduct objects filtered by the promotion_discount_currency_code column
 * @method     array findByPromotionDiscountAmount(string $promotion_discount_amount) Return ChildAmazonOrderProduct objects filtered by the promotion_discount_amount column
 * @method     array findByPromotionId(string $promotion_id) Return ChildAmazonOrderProduct objects filtered by the promotion_id column
 * @method     array findByCodFeeCurrencyCode(string $cod_fee_currency_code) Return ChildAmazonOrderProduct objects filtered by the cod_fee_currency_code column
 * @method     array findByCodFeeAmount(string $cod_fee_amount) Return ChildAmazonOrderProduct objects filtered by the cod_fee_amount column
 * @method     array findByCodFeeDiscountCurrencyCode(string $cod_fee_discount_currency_code) Return ChildAmazonOrderProduct objects filtered by the cod_fee_discount_currency_code column
 * @method     array findByCodFeeDiscountAmount(string $cod_fee_discount_amount) Return ChildAmazonOrderProduct objects filtered by the cod_fee_discount_amount column
 * @method     array findByGiftMessageText(string $gift_message_text) Return ChildAmazonOrderProduct objects filtered by the gift_message_text column
 * @method     array findByGiftWrapLevel(string $gift_wrap_level) Return ChildAmazonOrderProduct objects filtered by the gift_wrap_level column
 * @method     array findByInvoiceRequirement(string $invoice_requirement) Return ChildAmazonOrderProduct objects filtered by the invoice_requirement column
 * @method     array findByBuyerSelectedInvoiceCategory(string $buyer_selected_invoice_category) Return ChildAmazonOrderProduct objects filtered by the buyer_selected_invoice_category column
 * @method     array findByInvoiceTitle(string $invoice_title) Return ChildAmazonOrderProduct objects filtered by the invoice_title column
 * @method     array findByInvoiceInformation(string $invoice_information) Return ChildAmazonOrderProduct objects filtered by the invoice_information column
 * @method     array findByConditionNote(string $condition_note) Return ChildAmazonOrderProduct objects filtered by the condition_note column
 * @method     array findByConditionId(string $condition_id) Return ChildAmazonOrderProduct objects filtered by the condition_id column
 * @method     array findByConditionSubtypeId(string $condition_subtype_id) Return ChildAmazonOrderProduct objects filtered by the condition_subtype_id column
 * @method     array findByScheduledDeliveryStartDate(string $schedule_delivery_start_date) Return ChildAmazonOrderProduct objects filtered by the schedule_delivery_start_date column
 * @method     array findByScheduledDeliveryEndDate(string $schedule_delivery_end_date) Return ChildAmazonOrderProduct objects filtered by the schedule_delivery_end_date column
 * @method     array findByPriceDesignation(string $price_designation) Return ChildAmazonOrderProduct objects filtered by the price_designation column
 * @method     array findByBuyerCustomizedURL(string $buyer_customized_url) Return ChildAmazonOrderProduct objects filtered by the buyer_customized_url column
 * @method     array findByOrderProductId(int $order_product_id) Return ChildAmazonOrderProduct objects filtered by the order_product_id column
 *
 */
abstract class AmazonOrderProductQuery extends ModelCriteria
{
    
    /**
     * Initializes internal state of \AmazonIntegration\Model\Base\AmazonOrderProductQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'thelia', $modelName = '\\AmazonIntegration\\Model\\AmazonOrderProduct', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildAmazonOrderProductQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildAmazonOrderProductQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \AmazonIntegration\Model\AmazonOrderProductQuery) {
            return $criteria;
        }
        $query = new \AmazonIntegration\Model\AmazonOrderProductQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildAmazonOrderProduct|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = AmazonOrderProductTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(AmazonOrderProductTableMap::DATABASE_NAME);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return   ChildAmazonOrderProduct A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ORDER_ITEM_ID, AMAZON_ORDER_ID, ASIN, SELLER_SKU, TITLE, QUANTITY_ORDERED, QUANTITY_SHIPPED, POINTS_GRANTED_NUMBER, POINTS_GRANTED_CURRENCY_CODE, POINTS_GRANTED_AMOUNT, ITEM_PRICE_CURRENCY_CODE, ITEM_PRICE_AMOUNT, SHIPPING_PRICE_CURRENCY_CODE, SHIPPING_PRICE_AMOUNT, GIFT_WRAP_PRICE_CURRENCY_CODE, GIFT_WRAP_PRICE_AMOUNT, ITEM_TAX_CURRENCY_CODE, ITEM_TAX_AMOUNT, SHIPPING_TAX_CURRENCY_CODE, SHIPPING_TAX_AMOUNT, GIFT_WRAP_TAX_CURRENCY_CODE, GIFT_WRAP_TAX_AMOUNT, SHIPPING_DISCOUNT_CURRENCY_CODE, SHIPPING_DISCOUNT_AMOUNT, PROMOTION_DISCOUNT_CURRENCY_CODE, PROMOTION_DISCOUNT_AMOUNT, PROMOTION_ID, COD_FEE_CURRENCY_CODE, COD_FEE_AMOUNT, COD_FEE_DISCOUNT_CURRENCY_CODE, COD_FEE_DISCOUNT_AMOUNT, GIFT_MESSAGE_TEXT, GIFT_WRAP_LEVEL, INVOICE_REQUIREMENT, BUYER_SELECTED_INVOICE_CATEGORY, INVOICE_TITLE, INVOICE_INFORMATION, CONDITION_NOTE, CONDITION_ID, CONDITION_SUBTYPE_ID, SCHEDULE_DELIVERY_START_DATE, SCHEDULE_DELIVERY_END_DATE, PRICE_DESIGNATION, BUYER_CUSTOMIZED_URL, ORDER_PRODUCT_ID FROM amazon_order_product WHERE ORDER_ITEM_ID = :p0';
        try {
            $stmt = $con->prepare($sql);            
            $stmt->bindValue(':p0', $key, PDO::PARAM_STR);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            $obj = new ChildAmazonOrderProduct();
            $obj->hydrate($row);
            AmazonOrderProductTableMap::addInstanceToPool($obj, (string) $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildAmazonOrderProduct|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return ChildAmazonOrderProductQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(AmazonOrderProductTableMap::ORDER_ITEM_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildAmazonOrderProductQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(AmazonOrderProductTableMap::ORDER_ITEM_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the order_item_id column
     *
     * Example usage:
     * <code>
     * $query->filterByOrderItemId('fooValue');   // WHERE order_item_id = 'fooValue'
     * $query->filterByOrderItemId('%fooValue%'); // WHERE order_item_id LIKE '%fooValue%'
     * </code>
     *
     * @param     string $orderItemId The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonOrderProductQuery The current query, for fluid interface
     */
    public function filterByOrderItemId($orderItemId = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($orderItemId)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $orderItemId)) {
                $orderItemId = str_replace('*', '%', $orderItemId);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AmazonOrderProductTableMap::ORDER_ITEM_ID, $orderItemId, $comparison);
    }

    /**
     * Filter the query on the amazon_order_id column
     *
     * Example usage:
     * <code>
     * $query->filterByAmazonOrderId('fooValue');   // WHERE amazon_order_id = 'fooValue'
     * $query->filterByAmazonOrderId('%fooValue%'); // WHERE amazon_order_id LIKE '%fooValue%'
     * </code>
     *
     * @param     string $amazonOrderId The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonOrderProductQuery The current query, for fluid interface
     */
    public function filterByAmazonOrderId($amazonOrderId = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($amazonOrderId)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $amazonOrderId)) {
                $amazonOrderId = str_replace('*', '%', $amazonOrderId);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AmazonOrderProductTableMap::AMAZON_ORDER_ID, $amazonOrderId, $comparison);
    }

    /**
     * Filter the query on the asin column
     *
     * Example usage:
     * <code>
     * $query->filterByAsin('fooValue');   // WHERE asin = 'fooValue'
     * $query->filterByAsin('%fooValue%'); // WHERE asin LIKE '%fooValue%'
     * </code>
     *
     * @param     string $asin The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonOrderProductQuery The current query, for fluid interface
     */
    public function filterByAsin($asin = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($asin)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $asin)) {
                $asin = str_replace('*', '%', $asin);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AmazonOrderProductTableMap::ASIN, $asin, $comparison);
    }

    /**
     * Filter the query on the seller_sku column
     *
     * Example usage:
     * <code>
     * $query->filterBySellerSku('fooValue');   // WHERE seller_sku = 'fooValue'
     * $query->filterBySellerSku('%fooValue%'); // WHERE seller_sku LIKE '%fooValue%'
     * </code>
     *
     * @param     string $sellerSku The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonOrderProductQuery The current query, for fluid interface
     */
    public function filterBySellerSku($sellerSku = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($sellerSku)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $sellerSku)) {
                $sellerSku = str_replace('*', '%', $sellerSku);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AmazonOrderProductTableMap::SELLER_SKU, $sellerSku, $comparison);
    }

    /**
     * Filter the query on the title column
     *
     * Example usage:
     * <code>
     * $query->filterByTitle('fooValue');   // WHERE title = 'fooValue'
     * $query->filterByTitle('%fooValue%'); // WHERE title LIKE '%fooValue%'
     * </code>
     *
     * @param     string $title The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonOrderProductQuery The current query, for fluid interface
     */
    public function filterByTitle($title = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($title)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $title)) {
                $title = str_replace('*', '%', $title);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AmazonOrderProductTableMap::TITLE, $title, $comparison);
    }

    /**
     * Filter the query on the quantity_ordered column
     *
     * Example usage:
     * <code>
     * $query->filterByQuantityOrdered(1234); // WHERE quantity_ordered = 1234
     * $query->filterByQuantityOrdered(array(12, 34)); // WHERE quantity_ordered IN (12, 34)
     * $query->filterByQuantityOrdered(array('min' => 12)); // WHERE quantity_ordered > 12
     * </code>
     *
     * @param     mixed $quantityOrdered The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonOrderProductQuery The current query, for fluid interface
     */
    public function filterByQuantityOrdered($quantityOrdered = null, $comparison = null)
    {
        if (is_array($quantityOrdered)) {
            $useMinMax = false;
            if (isset($quantityOrdered['min'])) {
                $this->addUsingAlias(AmazonOrderProductTableMap::QUANTITY_ORDERED, $quantityOrdered['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($quantityOrdered['max'])) {
                $this->addUsingAlias(AmazonOrderProductTableMap::QUANTITY_ORDERED, $quantityOrdered['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AmazonOrderProductTableMap::QUANTITY_ORDERED, $quantityOrdered, $comparison);
    }

    /**
     * Filter the query on the quantity_shipped column
     *
     * Example usage:
     * <code>
     * $query->filterByQuantityShipped(1234); // WHERE quantity_shipped = 1234
     * $query->filterByQuantityShipped(array(12, 34)); // WHERE quantity_shipped IN (12, 34)
     * $query->filterByQuantityShipped(array('min' => 12)); // WHERE quantity_shipped > 12
     * </code>
     *
     * @param     mixed $quantityShipped The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonOrderProductQuery The current query, for fluid interface
     */
    public function filterByQuantityShipped($quantityShipped = null, $comparison = null)
    {
        if (is_array($quantityShipped)) {
            $useMinMax = false;
            if (isset($quantityShipped['min'])) {
                $this->addUsingAlias(AmazonOrderProductTableMap::QUANTITY_SHIPPED, $quantityShipped['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($quantityShipped['max'])) {
                $this->addUsingAlias(AmazonOrderProductTableMap::QUANTITY_SHIPPED, $quantityShipped['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AmazonOrderProductTableMap::QUANTITY_SHIPPED, $quantityShipped, $comparison);
    }

    /**
     * Filter the query on the points_granted_number column
     *
     * Example usage:
     * <code>
     * $query->filterByPointsGrantedNumber(1234); // WHERE points_granted_number = 1234
     * $query->filterByPointsGrantedNumber(array(12, 34)); // WHERE points_granted_number IN (12, 34)
     * $query->filterByPointsGrantedNumber(array('min' => 12)); // WHERE points_granted_number > 12
     * </code>
     *
     * @param     mixed $pointsGrantedNumber The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonOrderProductQuery The current query, for fluid interface
     */
    public function filterByPointsGrantedNumber($pointsGrantedNumber = null, $comparison = null)
    {
        if (is_array($pointsGrantedNumber)) {
            $useMinMax = false;
            if (isset($pointsGrantedNumber['min'])) {
                $this->addUsingAlias(AmazonOrderProductTableMap::POINTS_GRANTED_NUMBER, $pointsGrantedNumber['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($pointsGrantedNumber['max'])) {
                $this->addUsingAlias(AmazonOrderProductTableMap::POINTS_GRANTED_NUMBER, $pointsGrantedNumber['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AmazonOrderProductTableMap::POINTS_GRANTED_NUMBER, $pointsGrantedNumber, $comparison);
    }

    /**
     * Filter the query on the points_granted_currency_code column
     *
     * Example usage:
     * <code>
     * $query->filterByPointsGrantedCurrencyCode('fooValue');   // WHERE points_granted_currency_code = 'fooValue'
     * $query->filterByPointsGrantedCurrencyCode('%fooValue%'); // WHERE points_granted_currency_code LIKE '%fooValue%'
     * </code>
     *
     * @param     string $pointsGrantedCurrencyCode The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonOrderProductQuery The current query, for fluid interface
     */
    public function filterByPointsGrantedCurrencyCode($pointsGrantedCurrencyCode = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($pointsGrantedCurrencyCode)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $pointsGrantedCurrencyCode)) {
                $pointsGrantedCurrencyCode = str_replace('*', '%', $pointsGrantedCurrencyCode);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AmazonOrderProductTableMap::POINTS_GRANTED_CURRENCY_CODE, $pointsGrantedCurrencyCode, $comparison);
    }

    /**
     * Filter the query on the points_granted_amount column
     *
     * Example usage:
     * <code>
     * $query->filterByPointsGrantedAmount('fooValue');   // WHERE points_granted_amount = 'fooValue'
     * $query->filterByPointsGrantedAmount('%fooValue%'); // WHERE points_granted_amount LIKE '%fooValue%'
     * </code>
     *
     * @param     string $pointsGrantedAmount The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonOrderProductQuery The current query, for fluid interface
     */
    public function filterByPointsGrantedAmount($pointsGrantedAmount = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($pointsGrantedAmount)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $pointsGrantedAmount)) {
                $pointsGrantedAmount = str_replace('*', '%', $pointsGrantedAmount);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AmazonOrderProductTableMap::POINTS_GRANTED_AMOUNT, $pointsGrantedAmount, $comparison);
    }

    /**
     * Filter the query on the item_price_currency_code column
     *
     * Example usage:
     * <code>
     * $query->filterByItemPriceCurrencyCode('fooValue');   // WHERE item_price_currency_code = 'fooValue'
     * $query->filterByItemPriceCurrencyCode('%fooValue%'); // WHERE item_price_currency_code LIKE '%fooValue%'
     * </code>
     *
     * @param     string $itemPriceCurrencyCode The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonOrderProductQuery The current query, for fluid interface
     */
    public function filterByItemPriceCurrencyCode($itemPriceCurrencyCode = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($itemPriceCurrencyCode)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $itemPriceCurrencyCode)) {
                $itemPriceCurrencyCode = str_replace('*', '%', $itemPriceCurrencyCode);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AmazonOrderProductTableMap::ITEM_PRICE_CURRENCY_CODE, $itemPriceCurrencyCode, $comparison);
    }

    /**
     * Filter the query on the item_price_amount column
     *
     * Example usage:
     * <code>
     * $query->filterByItemPriceAmount('fooValue');   // WHERE item_price_amount = 'fooValue'
     * $query->filterByItemPriceAmount('%fooValue%'); // WHERE item_price_amount LIKE '%fooValue%'
     * </code>
     *
     * @param     string $itemPriceAmount The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonOrderProductQuery The current query, for fluid interface
     */
    public function filterByItemPriceAmount($itemPriceAmount = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($itemPriceAmount)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $itemPriceAmount)) {
                $itemPriceAmount = str_replace('*', '%', $itemPriceAmount);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AmazonOrderProductTableMap::ITEM_PRICE_AMOUNT, $itemPriceAmount, $comparison);
    }

    /**
     * Filter the query on the shipping_price_currency_code column
     *
     * Example usage:
     * <code>
     * $query->filterByShippingPriceCurrencyCode('fooValue');   // WHERE shipping_price_currency_code = 'fooValue'
     * $query->filterByShippingPriceCurrencyCode('%fooValue%'); // WHERE shipping_price_currency_code LIKE '%fooValue%'
     * </code>
     *
     * @param     string $shippingPriceCurrencyCode The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonOrderProductQuery The current query, for fluid interface
     */
    public function filterByShippingPriceCurrencyCode($shippingPriceCurrencyCode = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($shippingPriceCurrencyCode)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $shippingPriceCurrencyCode)) {
                $shippingPriceCurrencyCode = str_replace('*', '%', $shippingPriceCurrencyCode);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AmazonOrderProductTableMap::SHIPPING_PRICE_CURRENCY_CODE, $shippingPriceCurrencyCode, $comparison);
    }

    /**
     * Filter the query on the shipping_price_amount column
     *
     * Example usage:
     * <code>
     * $query->filterByShippingPriceAmount('fooValue');   // WHERE shipping_price_amount = 'fooValue'
     * $query->filterByShippingPriceAmount('%fooValue%'); // WHERE shipping_price_amount LIKE '%fooValue%'
     * </code>
     *
     * @param     string $shippingPriceAmount The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonOrderProductQuery The current query, for fluid interface
     */
    public function filterByShippingPriceAmount($shippingPriceAmount = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($shippingPriceAmount)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $shippingPriceAmount)) {
                $shippingPriceAmount = str_replace('*', '%', $shippingPriceAmount);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AmazonOrderProductTableMap::SHIPPING_PRICE_AMOUNT, $shippingPriceAmount, $comparison);
    }

    /**
     * Filter the query on the gift_wrap_price_currency_code column
     *
     * Example usage:
     * <code>
     * $query->filterByGiftWrapPriceCurrencyCode('fooValue');   // WHERE gift_wrap_price_currency_code = 'fooValue'
     * $query->filterByGiftWrapPriceCurrencyCode('%fooValue%'); // WHERE gift_wrap_price_currency_code LIKE '%fooValue%'
     * </code>
     *
     * @param     string $giftWrapPriceCurrencyCode The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonOrderProductQuery The current query, for fluid interface
     */
    public function filterByGiftWrapPriceCurrencyCode($giftWrapPriceCurrencyCode = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($giftWrapPriceCurrencyCode)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $giftWrapPriceCurrencyCode)) {
                $giftWrapPriceCurrencyCode = str_replace('*', '%', $giftWrapPriceCurrencyCode);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AmazonOrderProductTableMap::GIFT_WRAP_PRICE_CURRENCY_CODE, $giftWrapPriceCurrencyCode, $comparison);
    }

    /**
     * Filter the query on the gift_wrap_price_amount column
     *
     * Example usage:
     * <code>
     * $query->filterByGiftWrapPriceAmount('fooValue');   // WHERE gift_wrap_price_amount = 'fooValue'
     * $query->filterByGiftWrapPriceAmount('%fooValue%'); // WHERE gift_wrap_price_amount LIKE '%fooValue%'
     * </code>
     *
     * @param     string $giftWrapPriceAmount The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonOrderProductQuery The current query, for fluid interface
     */
    public function filterByGiftWrapPriceAmount($giftWrapPriceAmount = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($giftWrapPriceAmount)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $giftWrapPriceAmount)) {
                $giftWrapPriceAmount = str_replace('*', '%', $giftWrapPriceAmount);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AmazonOrderProductTableMap::GIFT_WRAP_PRICE_AMOUNT, $giftWrapPriceAmount, $comparison);
    }

    /**
     * Filter the query on the item_tax_currency_code column
     *
     * Example usage:
     * <code>
     * $query->filterByItemTaxCurrencyCode('fooValue');   // WHERE item_tax_currency_code = 'fooValue'
     * $query->filterByItemTaxCurrencyCode('%fooValue%'); // WHERE item_tax_currency_code LIKE '%fooValue%'
     * </code>
     *
     * @param     string $itemTaxCurrencyCode The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonOrderProductQuery The current query, for fluid interface
     */
    public function filterByItemTaxCurrencyCode($itemTaxCurrencyCode = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($itemTaxCurrencyCode)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $itemTaxCurrencyCode)) {
                $itemTaxCurrencyCode = str_replace('*', '%', $itemTaxCurrencyCode);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AmazonOrderProductTableMap::ITEM_TAX_CURRENCY_CODE, $itemTaxCurrencyCode, $comparison);
    }

    /**
     * Filter the query on the item_tax_amount column
     *
     * Example usage:
     * <code>
     * $query->filterByItemTaxAmount('fooValue');   // WHERE item_tax_amount = 'fooValue'
     * $query->filterByItemTaxAmount('%fooValue%'); // WHERE item_tax_amount LIKE '%fooValue%'
     * </code>
     *
     * @param     string $itemTaxAmount The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonOrderProductQuery The current query, for fluid interface
     */
    public function filterByItemTaxAmount($itemTaxAmount = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($itemTaxAmount)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $itemTaxAmount)) {
                $itemTaxAmount = str_replace('*', '%', $itemTaxAmount);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AmazonOrderProductTableMap::ITEM_TAX_AMOUNT, $itemTaxAmount, $comparison);
    }

    /**
     * Filter the query on the shipping_tax_currency_code column
     *
     * Example usage:
     * <code>
     * $query->filterByShippingTaxCurrencyCode('fooValue');   // WHERE shipping_tax_currency_code = 'fooValue'
     * $query->filterByShippingTaxCurrencyCode('%fooValue%'); // WHERE shipping_tax_currency_code LIKE '%fooValue%'
     * </code>
     *
     * @param     string $shippingTaxCurrencyCode The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonOrderProductQuery The current query, for fluid interface
     */
    public function filterByShippingTaxCurrencyCode($shippingTaxCurrencyCode = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($shippingTaxCurrencyCode)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $shippingTaxCurrencyCode)) {
                $shippingTaxCurrencyCode = str_replace('*', '%', $shippingTaxCurrencyCode);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AmazonOrderProductTableMap::SHIPPING_TAX_CURRENCY_CODE, $shippingTaxCurrencyCode, $comparison);
    }

    /**
     * Filter the query on the shipping_tax_amount column
     *
     * Example usage:
     * <code>
     * $query->filterByShippingTaxAmount('fooValue');   // WHERE shipping_tax_amount = 'fooValue'
     * $query->filterByShippingTaxAmount('%fooValue%'); // WHERE shipping_tax_amount LIKE '%fooValue%'
     * </code>
     *
     * @param     string $shippingTaxAmount The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonOrderProductQuery The current query, for fluid interface
     */
    public function filterByShippingTaxAmount($shippingTaxAmount = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($shippingTaxAmount)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $shippingTaxAmount)) {
                $shippingTaxAmount = str_replace('*', '%', $shippingTaxAmount);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AmazonOrderProductTableMap::SHIPPING_TAX_AMOUNT, $shippingTaxAmount, $comparison);
    }

    /**
     * Filter the query on the gift_wrap_tax_currency_code column
     *
     * Example usage:
     * <code>
     * $query->filterByGiftWrapTaxCurrencyCode('fooValue');   // WHERE gift_wrap_tax_currency_code = 'fooValue'
     * $query->filterByGiftWrapTaxCurrencyCode('%fooValue%'); // WHERE gift_wrap_tax_currency_code LIKE '%fooValue%'
     * </code>
     *
     * @param     string $giftWrapTaxCurrencyCode The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonOrderProductQuery The current query, for fluid interface
     */
    public function filterByGiftWrapTaxCurrencyCode($giftWrapTaxCurrencyCode = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($giftWrapTaxCurrencyCode)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $giftWrapTaxCurrencyCode)) {
                $giftWrapTaxCurrencyCode = str_replace('*', '%', $giftWrapTaxCurrencyCode);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AmazonOrderProductTableMap::GIFT_WRAP_TAX_CURRENCY_CODE, $giftWrapTaxCurrencyCode, $comparison);
    }

    /**
     * Filter the query on the gift_wrap_tax_amount column
     *
     * Example usage:
     * <code>
     * $query->filterByGiftWrapTaxAmount('fooValue');   // WHERE gift_wrap_tax_amount = 'fooValue'
     * $query->filterByGiftWrapTaxAmount('%fooValue%'); // WHERE gift_wrap_tax_amount LIKE '%fooValue%'
     * </code>
     *
     * @param     string $giftWrapTaxAmount The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonOrderProductQuery The current query, for fluid interface
     */
    public function filterByGiftWrapTaxAmount($giftWrapTaxAmount = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($giftWrapTaxAmount)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $giftWrapTaxAmount)) {
                $giftWrapTaxAmount = str_replace('*', '%', $giftWrapTaxAmount);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AmazonOrderProductTableMap::GIFT_WRAP_TAX_AMOUNT, $giftWrapTaxAmount, $comparison);
    }

    /**
     * Filter the query on the shipping_discount_currency_code column
     *
     * Example usage:
     * <code>
     * $query->filterByShippingDiscountCurrencyCode('fooValue');   // WHERE shipping_discount_currency_code = 'fooValue'
     * $query->filterByShippingDiscountCurrencyCode('%fooValue%'); // WHERE shipping_discount_currency_code LIKE '%fooValue%'
     * </code>
     *
     * @param     string $shippingDiscountCurrencyCode The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonOrderProductQuery The current query, for fluid interface
     */
    public function filterByShippingDiscountCurrencyCode($shippingDiscountCurrencyCode = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($shippingDiscountCurrencyCode)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $shippingDiscountCurrencyCode)) {
                $shippingDiscountCurrencyCode = str_replace('*', '%', $shippingDiscountCurrencyCode);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AmazonOrderProductTableMap::SHIPPING_DISCOUNT_CURRENCY_CODE, $shippingDiscountCurrencyCode, $comparison);
    }

    /**
     * Filter the query on the shipping_discount_amount column
     *
     * Example usage:
     * <code>
     * $query->filterByShippingDiscountAmount('fooValue');   // WHERE shipping_discount_amount = 'fooValue'
     * $query->filterByShippingDiscountAmount('%fooValue%'); // WHERE shipping_discount_amount LIKE '%fooValue%'
     * </code>
     *
     * @param     string $shippingDiscountAmount The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonOrderProductQuery The current query, for fluid interface
     */
    public function filterByShippingDiscountAmount($shippingDiscountAmount = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($shippingDiscountAmount)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $shippingDiscountAmount)) {
                $shippingDiscountAmount = str_replace('*', '%', $shippingDiscountAmount);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AmazonOrderProductTableMap::SHIPPING_DISCOUNT_AMOUNT, $shippingDiscountAmount, $comparison);
    }

    /**
     * Filter the query on the promotion_discount_currency_code column
     *
     * Example usage:
     * <code>
     * $query->filterByPromotionDiscountCurrencyCode('fooValue');   // WHERE promotion_discount_currency_code = 'fooValue'
     * $query->filterByPromotionDiscountCurrencyCode('%fooValue%'); // WHERE promotion_discount_currency_code LIKE '%fooValue%'
     * </code>
     *
     * @param     string $promotionDiscountCurrencyCode The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonOrderProductQuery The current query, for fluid interface
     */
    public function filterByPromotionDiscountCurrencyCode($promotionDiscountCurrencyCode = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($promotionDiscountCurrencyCode)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $promotionDiscountCurrencyCode)) {
                $promotionDiscountCurrencyCode = str_replace('*', '%', $promotionDiscountCurrencyCode);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AmazonOrderProductTableMap::PROMOTION_DISCOUNT_CURRENCY_CODE, $promotionDiscountCurrencyCode, $comparison);
    }

    /**
     * Filter the query on the promotion_discount_amount column
     *
     * Example usage:
     * <code>
     * $query->filterByPromotionDiscountAmount('fooValue');   // WHERE promotion_discount_amount = 'fooValue'
     * $query->filterByPromotionDiscountAmount('%fooValue%'); // WHERE promotion_discount_amount LIKE '%fooValue%'
     * </code>
     *
     * @param     string $promotionDiscountAmount The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonOrderProductQuery The current query, for fluid interface
     */
    public function filterByPromotionDiscountAmount($promotionDiscountAmount = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($promotionDiscountAmount)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $promotionDiscountAmount)) {
                $promotionDiscountAmount = str_replace('*', '%', $promotionDiscountAmount);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AmazonOrderProductTableMap::PROMOTION_DISCOUNT_AMOUNT, $promotionDiscountAmount, $comparison);
    }

    /**
     * Filter the query on the promotion_id column
     *
     * Example usage:
     * <code>
     * $query->filterByPromotionId('fooValue');   // WHERE promotion_id = 'fooValue'
     * $query->filterByPromotionId('%fooValue%'); // WHERE promotion_id LIKE '%fooValue%'
     * </code>
     *
     * @param     string $promotionId The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonOrderProductQuery The current query, for fluid interface
     */
    public function filterByPromotionId($promotionId = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($promotionId)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $promotionId)) {
                $promotionId = str_replace('*', '%', $promotionId);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AmazonOrderProductTableMap::PROMOTION_ID, $promotionId, $comparison);
    }

    /**
     * Filter the query on the cod_fee_currency_code column
     *
     * Example usage:
     * <code>
     * $query->filterByCodFeeCurrencyCode('fooValue');   // WHERE cod_fee_currency_code = 'fooValue'
     * $query->filterByCodFeeCurrencyCode('%fooValue%'); // WHERE cod_fee_currency_code LIKE '%fooValue%'
     * </code>
     *
     * @param     string $codFeeCurrencyCode The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonOrderProductQuery The current query, for fluid interface
     */
    public function filterByCodFeeCurrencyCode($codFeeCurrencyCode = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($codFeeCurrencyCode)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $codFeeCurrencyCode)) {
                $codFeeCurrencyCode = str_replace('*', '%', $codFeeCurrencyCode);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AmazonOrderProductTableMap::COD_FEE_CURRENCY_CODE, $codFeeCurrencyCode, $comparison);
    }

    /**
     * Filter the query on the cod_fee_amount column
     *
     * Example usage:
     * <code>
     * $query->filterByCodFeeAmount('fooValue');   // WHERE cod_fee_amount = 'fooValue'
     * $query->filterByCodFeeAmount('%fooValue%'); // WHERE cod_fee_amount LIKE '%fooValue%'
     * </code>
     *
     * @param     string $codFeeAmount The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonOrderProductQuery The current query, for fluid interface
     */
    public function filterByCodFeeAmount($codFeeAmount = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($codFeeAmount)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $codFeeAmount)) {
                $codFeeAmount = str_replace('*', '%', $codFeeAmount);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AmazonOrderProductTableMap::COD_FEE_AMOUNT, $codFeeAmount, $comparison);
    }

    /**
     * Filter the query on the cod_fee_discount_currency_code column
     *
     * Example usage:
     * <code>
     * $query->filterByCodFeeDiscountCurrencyCode('fooValue');   // WHERE cod_fee_discount_currency_code = 'fooValue'
     * $query->filterByCodFeeDiscountCurrencyCode('%fooValue%'); // WHERE cod_fee_discount_currency_code LIKE '%fooValue%'
     * </code>
     *
     * @param     string $codFeeDiscountCurrencyCode The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonOrderProductQuery The current query, for fluid interface
     */
    public function filterByCodFeeDiscountCurrencyCode($codFeeDiscountCurrencyCode = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($codFeeDiscountCurrencyCode)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $codFeeDiscountCurrencyCode)) {
                $codFeeDiscountCurrencyCode = str_replace('*', '%', $codFeeDiscountCurrencyCode);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AmazonOrderProductTableMap::COD_FEE_DISCOUNT_CURRENCY_CODE, $codFeeDiscountCurrencyCode, $comparison);
    }

    /**
     * Filter the query on the cod_fee_discount_amount column
     *
     * Example usage:
     * <code>
     * $query->filterByCodFeeDiscountAmount('fooValue');   // WHERE cod_fee_discount_amount = 'fooValue'
     * $query->filterByCodFeeDiscountAmount('%fooValue%'); // WHERE cod_fee_discount_amount LIKE '%fooValue%'
     * </code>
     *
     * @param     string $codFeeDiscountAmount The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonOrderProductQuery The current query, for fluid interface
     */
    public function filterByCodFeeDiscountAmount($codFeeDiscountAmount = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($codFeeDiscountAmount)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $codFeeDiscountAmount)) {
                $codFeeDiscountAmount = str_replace('*', '%', $codFeeDiscountAmount);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AmazonOrderProductTableMap::COD_FEE_DISCOUNT_AMOUNT, $codFeeDiscountAmount, $comparison);
    }

    /**
     * Filter the query on the gift_message_text column
     *
     * Example usage:
     * <code>
     * $query->filterByGiftMessageText('fooValue');   // WHERE gift_message_text = 'fooValue'
     * $query->filterByGiftMessageText('%fooValue%'); // WHERE gift_message_text LIKE '%fooValue%'
     * </code>
     *
     * @param     string $giftMessageText The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonOrderProductQuery The current query, for fluid interface
     */
    public function filterByGiftMessageText($giftMessageText = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($giftMessageText)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $giftMessageText)) {
                $giftMessageText = str_replace('*', '%', $giftMessageText);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AmazonOrderProductTableMap::GIFT_MESSAGE_TEXT, $giftMessageText, $comparison);
    }

    /**
     * Filter the query on the gift_wrap_level column
     *
     * Example usage:
     * <code>
     * $query->filterByGiftWrapLevel('fooValue');   // WHERE gift_wrap_level = 'fooValue'
     * $query->filterByGiftWrapLevel('%fooValue%'); // WHERE gift_wrap_level LIKE '%fooValue%'
     * </code>
     *
     * @param     string $giftWrapLevel The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonOrderProductQuery The current query, for fluid interface
     */
    public function filterByGiftWrapLevel($giftWrapLevel = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($giftWrapLevel)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $giftWrapLevel)) {
                $giftWrapLevel = str_replace('*', '%', $giftWrapLevel);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AmazonOrderProductTableMap::GIFT_WRAP_LEVEL, $giftWrapLevel, $comparison);
    }

    /**
     * Filter the query on the invoice_requirement column
     *
     * Example usage:
     * <code>
     * $query->filterByInvoiceRequirement('fooValue');   // WHERE invoice_requirement = 'fooValue'
     * $query->filterByInvoiceRequirement('%fooValue%'); // WHERE invoice_requirement LIKE '%fooValue%'
     * </code>
     *
     * @param     string $invoiceRequirement The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonOrderProductQuery The current query, for fluid interface
     */
    public function filterByInvoiceRequirement($invoiceRequirement = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($invoiceRequirement)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $invoiceRequirement)) {
                $invoiceRequirement = str_replace('*', '%', $invoiceRequirement);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AmazonOrderProductTableMap::INVOICE_REQUIREMENT, $invoiceRequirement, $comparison);
    }

    /**
     * Filter the query on the buyer_selected_invoice_category column
     *
     * Example usage:
     * <code>
     * $query->filterByBuyerSelectedInvoiceCategory('fooValue');   // WHERE buyer_selected_invoice_category = 'fooValue'
     * $query->filterByBuyerSelectedInvoiceCategory('%fooValue%'); // WHERE buyer_selected_invoice_category LIKE '%fooValue%'
     * </code>
     *
     * @param     string $buyerSelectedInvoiceCategory The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonOrderProductQuery The current query, for fluid interface
     */
    public function filterByBuyerSelectedInvoiceCategory($buyerSelectedInvoiceCategory = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($buyerSelectedInvoiceCategory)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $buyerSelectedInvoiceCategory)) {
                $buyerSelectedInvoiceCategory = str_replace('*', '%', $buyerSelectedInvoiceCategory);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AmazonOrderProductTableMap::BUYER_SELECTED_INVOICE_CATEGORY, $buyerSelectedInvoiceCategory, $comparison);
    }

    /**
     * Filter the query on the invoice_title column
     *
     * Example usage:
     * <code>
     * $query->filterByInvoiceTitle('fooValue');   // WHERE invoice_title = 'fooValue'
     * $query->filterByInvoiceTitle('%fooValue%'); // WHERE invoice_title LIKE '%fooValue%'
     * </code>
     *
     * @param     string $invoiceTitle The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonOrderProductQuery The current query, for fluid interface
     */
    public function filterByInvoiceTitle($invoiceTitle = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($invoiceTitle)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $invoiceTitle)) {
                $invoiceTitle = str_replace('*', '%', $invoiceTitle);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AmazonOrderProductTableMap::INVOICE_TITLE, $invoiceTitle, $comparison);
    }

    /**
     * Filter the query on the invoice_information column
     *
     * Example usage:
     * <code>
     * $query->filterByInvoiceInformation('fooValue');   // WHERE invoice_information = 'fooValue'
     * $query->filterByInvoiceInformation('%fooValue%'); // WHERE invoice_information LIKE '%fooValue%'
     * </code>
     *
     * @param     string $invoiceInformation The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonOrderProductQuery The current query, for fluid interface
     */
    public function filterByInvoiceInformation($invoiceInformation = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($invoiceInformation)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $invoiceInformation)) {
                $invoiceInformation = str_replace('*', '%', $invoiceInformation);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AmazonOrderProductTableMap::INVOICE_INFORMATION, $invoiceInformation, $comparison);
    }

    /**
     * Filter the query on the condition_note column
     *
     * Example usage:
     * <code>
     * $query->filterByConditionNote('fooValue');   // WHERE condition_note = 'fooValue'
     * $query->filterByConditionNote('%fooValue%'); // WHERE condition_note LIKE '%fooValue%'
     * </code>
     *
     * @param     string $conditionNote The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonOrderProductQuery The current query, for fluid interface
     */
    public function filterByConditionNote($conditionNote = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($conditionNote)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $conditionNote)) {
                $conditionNote = str_replace('*', '%', $conditionNote);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AmazonOrderProductTableMap::CONDITION_NOTE, $conditionNote, $comparison);
    }

    /**
     * Filter the query on the condition_id column
     *
     * Example usage:
     * <code>
     * $query->filterByConditionId('fooValue');   // WHERE condition_id = 'fooValue'
     * $query->filterByConditionId('%fooValue%'); // WHERE condition_id LIKE '%fooValue%'
     * </code>
     *
     * @param     string $conditionId The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonOrderProductQuery The current query, for fluid interface
     */
    public function filterByConditionId($conditionId = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($conditionId)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $conditionId)) {
                $conditionId = str_replace('*', '%', $conditionId);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AmazonOrderProductTableMap::CONDITION_ID, $conditionId, $comparison);
    }

    /**
     * Filter the query on the condition_subtype_id column
     *
     * Example usage:
     * <code>
     * $query->filterByConditionSubtypeId('fooValue');   // WHERE condition_subtype_id = 'fooValue'
     * $query->filterByConditionSubtypeId('%fooValue%'); // WHERE condition_subtype_id LIKE '%fooValue%'
     * </code>
     *
     * @param     string $conditionSubtypeId The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonOrderProductQuery The current query, for fluid interface
     */
    public function filterByConditionSubtypeId($conditionSubtypeId = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($conditionSubtypeId)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $conditionSubtypeId)) {
                $conditionSubtypeId = str_replace('*', '%', $conditionSubtypeId);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AmazonOrderProductTableMap::CONDITION_SUBTYPE_ID, $conditionSubtypeId, $comparison);
    }

    /**
     * Filter the query on the schedule_delivery_start_date column
     *
     * Example usage:
     * <code>
     * $query->filterByScheduledDeliveryStartDate('fooValue');   // WHERE schedule_delivery_start_date = 'fooValue'
     * $query->filterByScheduledDeliveryStartDate('%fooValue%'); // WHERE schedule_delivery_start_date LIKE '%fooValue%'
     * </code>
     *
     * @param     string $scheduledDeliveryStartDate The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonOrderProductQuery The current query, for fluid interface
     */
    public function filterByScheduledDeliveryStartDate($scheduledDeliveryStartDate = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($scheduledDeliveryStartDate)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $scheduledDeliveryStartDate)) {
                $scheduledDeliveryStartDate = str_replace('*', '%', $scheduledDeliveryStartDate);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AmazonOrderProductTableMap::SCHEDULE_DELIVERY_START_DATE, $scheduledDeliveryStartDate, $comparison);
    }

    /**
     * Filter the query on the schedule_delivery_end_date column
     *
     * Example usage:
     * <code>
     * $query->filterByScheduledDeliveryEndDate('fooValue');   // WHERE schedule_delivery_end_date = 'fooValue'
     * $query->filterByScheduledDeliveryEndDate('%fooValue%'); // WHERE schedule_delivery_end_date LIKE '%fooValue%'
     * </code>
     *
     * @param     string $scheduledDeliveryEndDate The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonOrderProductQuery The current query, for fluid interface
     */
    public function filterByScheduledDeliveryEndDate($scheduledDeliveryEndDate = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($scheduledDeliveryEndDate)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $scheduledDeliveryEndDate)) {
                $scheduledDeliveryEndDate = str_replace('*', '%', $scheduledDeliveryEndDate);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AmazonOrderProductTableMap::SCHEDULE_DELIVERY_END_DATE, $scheduledDeliveryEndDate, $comparison);
    }

    /**
     * Filter the query on the price_designation column
     *
     * Example usage:
     * <code>
     * $query->filterByPriceDesignation('fooValue');   // WHERE price_designation = 'fooValue'
     * $query->filterByPriceDesignation('%fooValue%'); // WHERE price_designation LIKE '%fooValue%'
     * </code>
     *
     * @param     string $priceDesignation The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonOrderProductQuery The current query, for fluid interface
     */
    public function filterByPriceDesignation($priceDesignation = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($priceDesignation)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $priceDesignation)) {
                $priceDesignation = str_replace('*', '%', $priceDesignation);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AmazonOrderProductTableMap::PRICE_DESIGNATION, $priceDesignation, $comparison);
    }

    /**
     * Filter the query on the buyer_customized_url column
     *
     * Example usage:
     * <code>
     * $query->filterByBuyerCustomizedURL('fooValue');   // WHERE buyer_customized_url = 'fooValue'
     * $query->filterByBuyerCustomizedURL('%fooValue%'); // WHERE buyer_customized_url LIKE '%fooValue%'
     * </code>
     *
     * @param     string $buyerCustomizedURL The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonOrderProductQuery The current query, for fluid interface
     */
    public function filterByBuyerCustomizedURL($buyerCustomizedURL = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($buyerCustomizedURL)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $buyerCustomizedURL)) {
                $buyerCustomizedURL = str_replace('*', '%', $buyerCustomizedURL);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AmazonOrderProductTableMap::BUYER_CUSTOMIZED_URL, $buyerCustomizedURL, $comparison);
    }

    /**
     * Filter the query on the order_product_id column
     *
     * Example usage:
     * <code>
     * $query->filterByOrderProductId(1234); // WHERE order_product_id = 1234
     * $query->filterByOrderProductId(array(12, 34)); // WHERE order_product_id IN (12, 34)
     * $query->filterByOrderProductId(array('min' => 12)); // WHERE order_product_id > 12
     * </code>
     *
     * @see       filterByOrderProduct()
     *
     * @param     mixed $orderProductId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonOrderProductQuery The current query, for fluid interface
     */
    public function filterByOrderProductId($orderProductId = null, $comparison = null)
    {
        if (is_array($orderProductId)) {
            $useMinMax = false;
            if (isset($orderProductId['min'])) {
                $this->addUsingAlias(AmazonOrderProductTableMap::ORDER_PRODUCT_ID, $orderProductId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($orderProductId['max'])) {
                $this->addUsingAlias(AmazonOrderProductTableMap::ORDER_PRODUCT_ID, $orderProductId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AmazonOrderProductTableMap::ORDER_PRODUCT_ID, $orderProductId, $comparison);
    }

    /**
     * Filter the query by a related \Thelia\Model\OrderProduct object
     *
     * @param \Thelia\Model\OrderProduct|ObjectCollection $orderProduct The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonOrderProductQuery The current query, for fluid interface
     */
    public function filterByOrderProduct($orderProduct, $comparison = null)
    {
        if ($orderProduct instanceof \Thelia\Model\OrderProduct) {
            return $this
                ->addUsingAlias(AmazonOrderProductTableMap::ORDER_PRODUCT_ID, $orderProduct->getId(), $comparison);
        } elseif ($orderProduct instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AmazonOrderProductTableMap::ORDER_PRODUCT_ID, $orderProduct->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByOrderProduct() only accepts arguments of type \Thelia\Model\OrderProduct or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the OrderProduct relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildAmazonOrderProductQuery The current query, for fluid interface
     */
    public function joinOrderProduct($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('OrderProduct');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'OrderProduct');
        }

        return $this;
    }

    /**
     * Use the OrderProduct relation OrderProduct object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Thelia\Model\OrderProductQuery A secondary query class using the current class as primary query
     */
    public function useOrderProductQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinOrderProduct($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'OrderProduct', '\Thelia\Model\OrderProductQuery');
    }

    /**
     * Filter the query by a related \AmazonIntegration\Model\AmazonOrders object
     *
     * @param \AmazonIntegration\Model\AmazonOrders|ObjectCollection $amazonOrders The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonOrderProductQuery The current query, for fluid interface
     */
    public function filterByAmazonOrders($amazonOrders, $comparison = null)
    {
        if ($amazonOrders instanceof \AmazonIntegration\Model\AmazonOrders) {
            return $this
                ->addUsingAlias(AmazonOrderProductTableMap::AMAZON_ORDER_ID, $amazonOrders->getId(), $comparison);
        } elseif ($amazonOrders instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AmazonOrderProductTableMap::AMAZON_ORDER_ID, $amazonOrders->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByAmazonOrders() only accepts arguments of type \AmazonIntegration\Model\AmazonOrders or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the AmazonOrders relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildAmazonOrderProductQuery The current query, for fluid interface
     */
    public function joinAmazonOrders($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('AmazonOrders');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'AmazonOrders');
        }

        return $this;
    }

    /**
     * Use the AmazonOrders relation AmazonOrders object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \AmazonIntegration\Model\AmazonOrdersQuery A secondary query class using the current class as primary query
     */
    public function useAmazonOrdersQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinAmazonOrders($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'AmazonOrders', '\AmazonIntegration\Model\AmazonOrdersQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildAmazonOrderProduct $amazonOrderProduct Object to remove from the list of results
     *
     * @return ChildAmazonOrderProductQuery The current query, for fluid interface
     */
    public function prune($amazonOrderProduct = null)
    {
        if ($amazonOrderProduct) {
            $this->addUsingAlias(AmazonOrderProductTableMap::ORDER_ITEM_ID, $amazonOrderProduct->getOrderItemId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the amazon_order_product table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(AmazonOrderProductTableMap::DATABASE_NAME);
        }
        $affectedRows = 0; // initialize var to track total num of affected rows
        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            AmazonOrderProductTableMap::clearInstancePool();
            AmazonOrderProductTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildAmazonOrderProduct or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildAmazonOrderProduct object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
     public function delete(ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(AmazonOrderProductTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(AmazonOrderProductTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            

        AmazonOrderProductTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            AmazonOrderProductTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

} // AmazonOrderProductQuery
