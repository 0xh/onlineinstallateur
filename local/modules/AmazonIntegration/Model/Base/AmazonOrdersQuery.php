<?php

namespace AmazonIntegration\Model\Base;

use \Exception;
use \PDO;
use AmazonIntegration\Model\AmazonOrders as ChildAmazonOrders;
use AmazonIntegration\Model\AmazonOrdersQuery as ChildAmazonOrdersQuery;
use AmazonIntegration\Model\Map\AmazonOrdersTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'amazon_orders' table.
 *
 * 
 *
 * @method     ChildAmazonOrdersQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildAmazonOrdersQuery orderBySellerOrderId($order = Criteria::ASC) Order by the seller_order_id column
 * @method     ChildAmazonOrdersQuery orderByPurchaseDate($order = Criteria::ASC) Order by the purchase_date column
 * @method     ChildAmazonOrdersQuery orderByLastUpdateDate($order = Criteria::ASC) Order by the last_update_date column
 * @method     ChildAmazonOrdersQuery orderByOrderStatus($order = Criteria::ASC) Order by the order_status column
 * @method     ChildAmazonOrdersQuery orderByFulfillmentChannel($order = Criteria::ASC) Order by the fulfillment_channel column
 * @method     ChildAmazonOrdersQuery orderBySalesChannel($order = Criteria::ASC) Order by the sales_channel column
 * @method     ChildAmazonOrdersQuery orderByOrderChannel($order = Criteria::ASC) Order by the order_channel column
 * @method     ChildAmazonOrdersQuery orderByShipServiceLevel($order = Criteria::ASC) Order by the ship_service_level column
 * @method     ChildAmazonOrdersQuery orderByOrderTotalCurrencyCode($order = Criteria::ASC) Order by the order_total_currency_code column
 * @method     ChildAmazonOrdersQuery orderByOrderTotalAmount($order = Criteria::ASC) Order by the order_total_amount column
 * @method     ChildAmazonOrdersQuery orderByNumberOfItemsShipped($order = Criteria::ASC) Order by the number_of_items_shipped column
 * @method     ChildAmazonOrdersQuery orderByNumberOfItemsUnshipped($order = Criteria::ASC) Order by the number_of_items_unshipped column
 * @method     ChildAmazonOrdersQuery orderByPaymentExecutionDetailCurrencyCode($order = Criteria::ASC) Order by the payment_execution_detail_currency_code column
 * @method     ChildAmazonOrdersQuery orderByPaymentExecutionDetailTotalAmount($order = Criteria::ASC) Order by the payment_execution_detail_total_amount column
 * @method     ChildAmazonOrdersQuery orderByPaymentExecutionDetailPaymentMethod($order = Criteria::ASC) Order by the payment_execution_detail_payment_method column
 * @method     ChildAmazonOrdersQuery orderByPaymentMethod($order = Criteria::ASC) Order by the payment_method column
 * @method     ChildAmazonOrdersQuery orderByPaymentMethodDetail($order = Criteria::ASC) Order by the payment_method_detail column
 * @method     ChildAmazonOrdersQuery orderByMarketplaceId($order = Criteria::ASC) Order by the marketplace_id column
 * @method     ChildAmazonOrdersQuery orderByBuyerCounty($order = Criteria::ASC) Order by the buyer_county column
 * @method     ChildAmazonOrdersQuery orderByBuyerTaxInfoCompany($order = Criteria::ASC) Order by the buyer_tax_info_company column
 * @method     ChildAmazonOrdersQuery orderByBuyerTaxInfoTaxingRegion($order = Criteria::ASC) Order by the buyer_tax_info_taxing_region column
 * @method     ChildAmazonOrdersQuery orderByBuyerTaxInfoTaxName($order = Criteria::ASC) Order by the buyer_tax_info_tax_name column
 * @method     ChildAmazonOrdersQuery orderByBuyerTaxInfoTaxValue($order = Criteria::ASC) Order by the buyer_tax_info_tax_value column
 * @method     ChildAmazonOrdersQuery orderByShipmentServiceLevelCategory($order = Criteria::ASC) Order by the shipment_service_level_category column
 * @method     ChildAmazonOrdersQuery orderByShippedByAmazonTfm($order = Criteria::ASC) Order by the shipped_by_amazon_tfm column
 * @method     ChildAmazonOrdersQuery orderByTfmShipmentStatus($order = Criteria::ASC) Order by the tfm_shipment_status column
 * @method     ChildAmazonOrdersQuery orderByCbaDisplayableShippingLabel($order = Criteria::ASC) Order by the cba_displayable_shipping_label column
 * @method     ChildAmazonOrdersQuery orderByOrderType($order = Criteria::ASC) Order by the order_type column
 * @method     ChildAmazonOrdersQuery orderByEarliestShipDate($order = Criteria::ASC) Order by the earliest_ship_date column
 * @method     ChildAmazonOrdersQuery orderByLatestShipDate($order = Criteria::ASC) Order by the latest_ship_date column
 * @method     ChildAmazonOrdersQuery orderByEarliestDeliveryDate($order = Criteria::ASC) Order by the earliest_delivery_date column
 * @method     ChildAmazonOrdersQuery orderByLatestDeliveryDate($order = Criteria::ASC) Order by the latest_delivery_date column
 * @method     ChildAmazonOrdersQuery orderByIsBusinessOrder($order = Criteria::ASC) Order by the is_business_order column
 * @method     ChildAmazonOrdersQuery orderByPurchaseOrderNumber($order = Criteria::ASC) Order by the purchase_order_number column
 * @method     ChildAmazonOrdersQuery orderByIsPrime($order = Criteria::ASC) Order by the is_prime column
 * @method     ChildAmazonOrdersQuery orderByIsPremiumOrder($order = Criteria::ASC) Order by the is_premium_order column
 * @method     ChildAmazonOrdersQuery orderByReplacedOrderId($order = Criteria::ASC) Order by the replaced_order_id column
 * @method     ChildAmazonOrdersQuery orderByIsReplacementOrder($order = Criteria::ASC) Order by the is_replacement_order column
 * @method     ChildAmazonOrdersQuery orderByOrderAddressId($order = Criteria::ASC) Order by the order_address_id column
 * @method     ChildAmazonOrdersQuery orderByCustomerId($order = Criteria::ASC) Order by the customer_id column
 * @method     ChildAmazonOrdersQuery orderByOrderId($order = Criteria::ASC) Order by the order_id column
 * @method     ChildAmazonOrdersQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildAmazonOrdersQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 * @method     ChildAmazonOrdersQuery orderByVersion($order = Criteria::ASC) Order by the version column
 * @method     ChildAmazonOrdersQuery orderByVersionCreatedAt($order = Criteria::ASC) Order by the version_created_at column
 * @method     ChildAmazonOrdersQuery orderByVersionCreatedBy($order = Criteria::ASC) Order by the version_created_by column
 *
 * @method     ChildAmazonOrdersQuery groupById() Group by the id column
 * @method     ChildAmazonOrdersQuery groupBySellerOrderId() Group by the seller_order_id column
 * @method     ChildAmazonOrdersQuery groupByPurchaseDate() Group by the purchase_date column
 * @method     ChildAmazonOrdersQuery groupByLastUpdateDate() Group by the last_update_date column
 * @method     ChildAmazonOrdersQuery groupByOrderStatus() Group by the order_status column
 * @method     ChildAmazonOrdersQuery groupByFulfillmentChannel() Group by the fulfillment_channel column
 * @method     ChildAmazonOrdersQuery groupBySalesChannel() Group by the sales_channel column
 * @method     ChildAmazonOrdersQuery groupByOrderChannel() Group by the order_channel column
 * @method     ChildAmazonOrdersQuery groupByShipServiceLevel() Group by the ship_service_level column
 * @method     ChildAmazonOrdersQuery groupByOrderTotalCurrencyCode() Group by the order_total_currency_code column
 * @method     ChildAmazonOrdersQuery groupByOrderTotalAmount() Group by the order_total_amount column
 * @method     ChildAmazonOrdersQuery groupByNumberOfItemsShipped() Group by the number_of_items_shipped column
 * @method     ChildAmazonOrdersQuery groupByNumberOfItemsUnshipped() Group by the number_of_items_unshipped column
 * @method     ChildAmazonOrdersQuery groupByPaymentExecutionDetailCurrencyCode() Group by the payment_execution_detail_currency_code column
 * @method     ChildAmazonOrdersQuery groupByPaymentExecutionDetailTotalAmount() Group by the payment_execution_detail_total_amount column
 * @method     ChildAmazonOrdersQuery groupByPaymentExecutionDetailPaymentMethod() Group by the payment_execution_detail_payment_method column
 * @method     ChildAmazonOrdersQuery groupByPaymentMethod() Group by the payment_method column
 * @method     ChildAmazonOrdersQuery groupByPaymentMethodDetail() Group by the payment_method_detail column
 * @method     ChildAmazonOrdersQuery groupByMarketplaceId() Group by the marketplace_id column
 * @method     ChildAmazonOrdersQuery groupByBuyerCounty() Group by the buyer_county column
 * @method     ChildAmazonOrdersQuery groupByBuyerTaxInfoCompany() Group by the buyer_tax_info_company column
 * @method     ChildAmazonOrdersQuery groupByBuyerTaxInfoTaxingRegion() Group by the buyer_tax_info_taxing_region column
 * @method     ChildAmazonOrdersQuery groupByBuyerTaxInfoTaxName() Group by the buyer_tax_info_tax_name column
 * @method     ChildAmazonOrdersQuery groupByBuyerTaxInfoTaxValue() Group by the buyer_tax_info_tax_value column
 * @method     ChildAmazonOrdersQuery groupByShipmentServiceLevelCategory() Group by the shipment_service_level_category column
 * @method     ChildAmazonOrdersQuery groupByShippedByAmazonTfm() Group by the shipped_by_amazon_tfm column
 * @method     ChildAmazonOrdersQuery groupByTfmShipmentStatus() Group by the tfm_shipment_status column
 * @method     ChildAmazonOrdersQuery groupByCbaDisplayableShippingLabel() Group by the cba_displayable_shipping_label column
 * @method     ChildAmazonOrdersQuery groupByOrderType() Group by the order_type column
 * @method     ChildAmazonOrdersQuery groupByEarliestShipDate() Group by the earliest_ship_date column
 * @method     ChildAmazonOrdersQuery groupByLatestShipDate() Group by the latest_ship_date column
 * @method     ChildAmazonOrdersQuery groupByEarliestDeliveryDate() Group by the earliest_delivery_date column
 * @method     ChildAmazonOrdersQuery groupByLatestDeliveryDate() Group by the latest_delivery_date column
 * @method     ChildAmazonOrdersQuery groupByIsBusinessOrder() Group by the is_business_order column
 * @method     ChildAmazonOrdersQuery groupByPurchaseOrderNumber() Group by the purchase_order_number column
 * @method     ChildAmazonOrdersQuery groupByIsPrime() Group by the is_prime column
 * @method     ChildAmazonOrdersQuery groupByIsPremiumOrder() Group by the is_premium_order column
 * @method     ChildAmazonOrdersQuery groupByReplacedOrderId() Group by the replaced_order_id column
 * @method     ChildAmazonOrdersQuery groupByIsReplacementOrder() Group by the is_replacement_order column
 * @method     ChildAmazonOrdersQuery groupByOrderAddressId() Group by the order_address_id column
 * @method     ChildAmazonOrdersQuery groupByCustomerId() Group by the customer_id column
 * @method     ChildAmazonOrdersQuery groupByOrderId() Group by the order_id column
 * @method     ChildAmazonOrdersQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildAmazonOrdersQuery groupByUpdatedAt() Group by the updated_at column
 * @method     ChildAmazonOrdersQuery groupByVersion() Group by the version column
 * @method     ChildAmazonOrdersQuery groupByVersionCreatedAt() Group by the version_created_at column
 * @method     ChildAmazonOrdersQuery groupByVersionCreatedBy() Group by the version_created_by column
 *
 * @method     ChildAmazonOrdersQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildAmazonOrdersQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildAmazonOrdersQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildAmazonOrdersQuery leftJoinCustomer($relationAlias = null) Adds a LEFT JOIN clause to the query using the Customer relation
 * @method     ChildAmazonOrdersQuery rightJoinCustomer($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Customer relation
 * @method     ChildAmazonOrdersQuery innerJoinCustomer($relationAlias = null) Adds a INNER JOIN clause to the query using the Customer relation
 *
 * @method     ChildAmazonOrdersQuery leftJoinOrderAddress($relationAlias = null) Adds a LEFT JOIN clause to the query using the OrderAddress relation
 * @method     ChildAmazonOrdersQuery rightJoinOrderAddress($relationAlias = null) Adds a RIGHT JOIN clause to the query using the OrderAddress relation
 * @method     ChildAmazonOrdersQuery innerJoinOrderAddress($relationAlias = null) Adds a INNER JOIN clause to the query using the OrderAddress relation
 *
 * @method     ChildAmazonOrdersQuery leftJoinOrder($relationAlias = null) Adds a LEFT JOIN clause to the query using the Order relation
 * @method     ChildAmazonOrdersQuery rightJoinOrder($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Order relation
 * @method     ChildAmazonOrdersQuery innerJoinOrder($relationAlias = null) Adds a INNER JOIN clause to the query using the Order relation
 *
 * @method     ChildAmazonOrdersQuery leftJoinAmazonOrdersVersion($relationAlias = null) Adds a LEFT JOIN clause to the query using the AmazonOrdersVersion relation
 * @method     ChildAmazonOrdersQuery rightJoinAmazonOrdersVersion($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AmazonOrdersVersion relation
 * @method     ChildAmazonOrdersQuery innerJoinAmazonOrdersVersion($relationAlias = null) Adds a INNER JOIN clause to the query using the AmazonOrdersVersion relation
 *
 * @method     ChildAmazonOrders findOne(ConnectionInterface $con = null) Return the first ChildAmazonOrders matching the query
 * @method     ChildAmazonOrders findOneOrCreate(ConnectionInterface $con = null) Return the first ChildAmazonOrders matching the query, or a new ChildAmazonOrders object populated from the query conditions when no match is found
 *
 * @method     ChildAmazonOrders findOneById(string $id) Return the first ChildAmazonOrders filtered by the id column
 * @method     ChildAmazonOrders findOneBySellerOrderId(string $seller_order_id) Return the first ChildAmazonOrders filtered by the seller_order_id column
 * @method     ChildAmazonOrders findOneByPurchaseDate(string $purchase_date) Return the first ChildAmazonOrders filtered by the purchase_date column
 * @method     ChildAmazonOrders findOneByLastUpdateDate(string $last_update_date) Return the first ChildAmazonOrders filtered by the last_update_date column
 * @method     ChildAmazonOrders findOneByOrderStatus(string $order_status) Return the first ChildAmazonOrders filtered by the order_status column
 * @method     ChildAmazonOrders findOneByFulfillmentChannel(string $fulfillment_channel) Return the first ChildAmazonOrders filtered by the fulfillment_channel column
 * @method     ChildAmazonOrders findOneBySalesChannel(string $sales_channel) Return the first ChildAmazonOrders filtered by the sales_channel column
 * @method     ChildAmazonOrders findOneByOrderChannel(string $order_channel) Return the first ChildAmazonOrders filtered by the order_channel column
 * @method     ChildAmazonOrders findOneByShipServiceLevel(string $ship_service_level) Return the first ChildAmazonOrders filtered by the ship_service_level column
 * @method     ChildAmazonOrders findOneByOrderTotalCurrencyCode(string $order_total_currency_code) Return the first ChildAmazonOrders filtered by the order_total_currency_code column
 * @method     ChildAmazonOrders findOneByOrderTotalAmount(string $order_total_amount) Return the first ChildAmazonOrders filtered by the order_total_amount column
 * @method     ChildAmazonOrders findOneByNumberOfItemsShipped(double $number_of_items_shipped) Return the first ChildAmazonOrders filtered by the number_of_items_shipped column
 * @method     ChildAmazonOrders findOneByNumberOfItemsUnshipped(double $number_of_items_unshipped) Return the first ChildAmazonOrders filtered by the number_of_items_unshipped column
 * @method     ChildAmazonOrders findOneByPaymentExecutionDetailCurrencyCode(string $payment_execution_detail_currency_code) Return the first ChildAmazonOrders filtered by the payment_execution_detail_currency_code column
 * @method     ChildAmazonOrders findOneByPaymentExecutionDetailTotalAmount(string $payment_execution_detail_total_amount) Return the first ChildAmazonOrders filtered by the payment_execution_detail_total_amount column
 * @method     ChildAmazonOrders findOneByPaymentExecutionDetailPaymentMethod(string $payment_execution_detail_payment_method) Return the first ChildAmazonOrders filtered by the payment_execution_detail_payment_method column
 * @method     ChildAmazonOrders findOneByPaymentMethod(string $payment_method) Return the first ChildAmazonOrders filtered by the payment_method column
 * @method     ChildAmazonOrders findOneByPaymentMethodDetail(string $payment_method_detail) Return the first ChildAmazonOrders filtered by the payment_method_detail column
 * @method     ChildAmazonOrders findOneByMarketplaceId(string $marketplace_id) Return the first ChildAmazonOrders filtered by the marketplace_id column
 * @method     ChildAmazonOrders findOneByBuyerCounty(string $buyer_county) Return the first ChildAmazonOrders filtered by the buyer_county column
 * @method     ChildAmazonOrders findOneByBuyerTaxInfoCompany(string $buyer_tax_info_company) Return the first ChildAmazonOrders filtered by the buyer_tax_info_company column
 * @method     ChildAmazonOrders findOneByBuyerTaxInfoTaxingRegion(string $buyer_tax_info_taxing_region) Return the first ChildAmazonOrders filtered by the buyer_tax_info_taxing_region column
 * @method     ChildAmazonOrders findOneByBuyerTaxInfoTaxName(string $buyer_tax_info_tax_name) Return the first ChildAmazonOrders filtered by the buyer_tax_info_tax_name column
 * @method     ChildAmazonOrders findOneByBuyerTaxInfoTaxValue(string $buyer_tax_info_tax_value) Return the first ChildAmazonOrders filtered by the buyer_tax_info_tax_value column
 * @method     ChildAmazonOrders findOneByShipmentServiceLevelCategory(string $shipment_service_level_category) Return the first ChildAmazonOrders filtered by the shipment_service_level_category column
 * @method     ChildAmazonOrders findOneByShippedByAmazonTfm(int $shipped_by_amazon_tfm) Return the first ChildAmazonOrders filtered by the shipped_by_amazon_tfm column
 * @method     ChildAmazonOrders findOneByTfmShipmentStatus(string $tfm_shipment_status) Return the first ChildAmazonOrders filtered by the tfm_shipment_status column
 * @method     ChildAmazonOrders findOneByCbaDisplayableShippingLabel(string $cba_displayable_shipping_label) Return the first ChildAmazonOrders filtered by the cba_displayable_shipping_label column
 * @method     ChildAmazonOrders findOneByOrderType(string $order_type) Return the first ChildAmazonOrders filtered by the order_type column
 * @method     ChildAmazonOrders findOneByEarliestShipDate(string $earliest_ship_date) Return the first ChildAmazonOrders filtered by the earliest_ship_date column
 * @method     ChildAmazonOrders findOneByLatestShipDate(string $latest_ship_date) Return the first ChildAmazonOrders filtered by the latest_ship_date column
 * @method     ChildAmazonOrders findOneByEarliestDeliveryDate(string $earliest_delivery_date) Return the first ChildAmazonOrders filtered by the earliest_delivery_date column
 * @method     ChildAmazonOrders findOneByLatestDeliveryDate(string $latest_delivery_date) Return the first ChildAmazonOrders filtered by the latest_delivery_date column
 * @method     ChildAmazonOrders findOneByIsBusinessOrder(int $is_business_order) Return the first ChildAmazonOrders filtered by the is_business_order column
 * @method     ChildAmazonOrders findOneByPurchaseOrderNumber(string $purchase_order_number) Return the first ChildAmazonOrders filtered by the purchase_order_number column
 * @method     ChildAmazonOrders findOneByIsPrime(int $is_prime) Return the first ChildAmazonOrders filtered by the is_prime column
 * @method     ChildAmazonOrders findOneByIsPremiumOrder(int $is_premium_order) Return the first ChildAmazonOrders filtered by the is_premium_order column
 * @method     ChildAmazonOrders findOneByReplacedOrderId(string $replaced_order_id) Return the first ChildAmazonOrders filtered by the replaced_order_id column
 * @method     ChildAmazonOrders findOneByIsReplacementOrder(int $is_replacement_order) Return the first ChildAmazonOrders filtered by the is_replacement_order column
 * @method     ChildAmazonOrders findOneByOrderAddressId(int $order_address_id) Return the first ChildAmazonOrders filtered by the order_address_id column
 * @method     ChildAmazonOrders findOneByCustomerId(int $customer_id) Return the first ChildAmazonOrders filtered by the customer_id column
 * @method     ChildAmazonOrders findOneByOrderId(int $order_id) Return the first ChildAmazonOrders filtered by the order_id column
 * @method     ChildAmazonOrders findOneByCreatedAt(string $created_at) Return the first ChildAmazonOrders filtered by the created_at column
 * @method     ChildAmazonOrders findOneByUpdatedAt(string $updated_at) Return the first ChildAmazonOrders filtered by the updated_at column
 * @method     ChildAmazonOrders findOneByVersion(int $version) Return the first ChildAmazonOrders filtered by the version column
 * @method     ChildAmazonOrders findOneByVersionCreatedAt(string $version_created_at) Return the first ChildAmazonOrders filtered by the version_created_at column
 * @method     ChildAmazonOrders findOneByVersionCreatedBy(string $version_created_by) Return the first ChildAmazonOrders filtered by the version_created_by column
 *
 * @method     array findById(string $id) Return ChildAmazonOrders objects filtered by the id column
 * @method     array findBySellerOrderId(string $seller_order_id) Return ChildAmazonOrders objects filtered by the seller_order_id column
 * @method     array findByPurchaseDate(string $purchase_date) Return ChildAmazonOrders objects filtered by the purchase_date column
 * @method     array findByLastUpdateDate(string $last_update_date) Return ChildAmazonOrders objects filtered by the last_update_date column
 * @method     array findByOrderStatus(string $order_status) Return ChildAmazonOrders objects filtered by the order_status column
 * @method     array findByFulfillmentChannel(string $fulfillment_channel) Return ChildAmazonOrders objects filtered by the fulfillment_channel column
 * @method     array findBySalesChannel(string $sales_channel) Return ChildAmazonOrders objects filtered by the sales_channel column
 * @method     array findByOrderChannel(string $order_channel) Return ChildAmazonOrders objects filtered by the order_channel column
 * @method     array findByShipServiceLevel(string $ship_service_level) Return ChildAmazonOrders objects filtered by the ship_service_level column
 * @method     array findByOrderTotalCurrencyCode(string $order_total_currency_code) Return ChildAmazonOrders objects filtered by the order_total_currency_code column
 * @method     array findByOrderTotalAmount(string $order_total_amount) Return ChildAmazonOrders objects filtered by the order_total_amount column
 * @method     array findByNumberOfItemsShipped(double $number_of_items_shipped) Return ChildAmazonOrders objects filtered by the number_of_items_shipped column
 * @method     array findByNumberOfItemsUnshipped(double $number_of_items_unshipped) Return ChildAmazonOrders objects filtered by the number_of_items_unshipped column
 * @method     array findByPaymentExecutionDetailCurrencyCode(string $payment_execution_detail_currency_code) Return ChildAmazonOrders objects filtered by the payment_execution_detail_currency_code column
 * @method     array findByPaymentExecutionDetailTotalAmount(string $payment_execution_detail_total_amount) Return ChildAmazonOrders objects filtered by the payment_execution_detail_total_amount column
 * @method     array findByPaymentExecutionDetailPaymentMethod(string $payment_execution_detail_payment_method) Return ChildAmazonOrders objects filtered by the payment_execution_detail_payment_method column
 * @method     array findByPaymentMethod(string $payment_method) Return ChildAmazonOrders objects filtered by the payment_method column
 * @method     array findByPaymentMethodDetail(string $payment_method_detail) Return ChildAmazonOrders objects filtered by the payment_method_detail column
 * @method     array findByMarketplaceId(string $marketplace_id) Return ChildAmazonOrders objects filtered by the marketplace_id column
 * @method     array findByBuyerCounty(string $buyer_county) Return ChildAmazonOrders objects filtered by the buyer_county column
 * @method     array findByBuyerTaxInfoCompany(string $buyer_tax_info_company) Return ChildAmazonOrders objects filtered by the buyer_tax_info_company column
 * @method     array findByBuyerTaxInfoTaxingRegion(string $buyer_tax_info_taxing_region) Return ChildAmazonOrders objects filtered by the buyer_tax_info_taxing_region column
 * @method     array findByBuyerTaxInfoTaxName(string $buyer_tax_info_tax_name) Return ChildAmazonOrders objects filtered by the buyer_tax_info_tax_name column
 * @method     array findByBuyerTaxInfoTaxValue(string $buyer_tax_info_tax_value) Return ChildAmazonOrders objects filtered by the buyer_tax_info_tax_value column
 * @method     array findByShipmentServiceLevelCategory(string $shipment_service_level_category) Return ChildAmazonOrders objects filtered by the shipment_service_level_category column
 * @method     array findByShippedByAmazonTfm(int $shipped_by_amazon_tfm) Return ChildAmazonOrders objects filtered by the shipped_by_amazon_tfm column
 * @method     array findByTfmShipmentStatus(string $tfm_shipment_status) Return ChildAmazonOrders objects filtered by the tfm_shipment_status column
 * @method     array findByCbaDisplayableShippingLabel(string $cba_displayable_shipping_label) Return ChildAmazonOrders objects filtered by the cba_displayable_shipping_label column
 * @method     array findByOrderType(string $order_type) Return ChildAmazonOrders objects filtered by the order_type column
 * @method     array findByEarliestShipDate(string $earliest_ship_date) Return ChildAmazonOrders objects filtered by the earliest_ship_date column
 * @method     array findByLatestShipDate(string $latest_ship_date) Return ChildAmazonOrders objects filtered by the latest_ship_date column
 * @method     array findByEarliestDeliveryDate(string $earliest_delivery_date) Return ChildAmazonOrders objects filtered by the earliest_delivery_date column
 * @method     array findByLatestDeliveryDate(string $latest_delivery_date) Return ChildAmazonOrders objects filtered by the latest_delivery_date column
 * @method     array findByIsBusinessOrder(int $is_business_order) Return ChildAmazonOrders objects filtered by the is_business_order column
 * @method     array findByPurchaseOrderNumber(string $purchase_order_number) Return ChildAmazonOrders objects filtered by the purchase_order_number column
 * @method     array findByIsPrime(int $is_prime) Return ChildAmazonOrders objects filtered by the is_prime column
 * @method     array findByIsPremiumOrder(int $is_premium_order) Return ChildAmazonOrders objects filtered by the is_premium_order column
 * @method     array findByReplacedOrderId(string $replaced_order_id) Return ChildAmazonOrders objects filtered by the replaced_order_id column
 * @method     array findByIsReplacementOrder(int $is_replacement_order) Return ChildAmazonOrders objects filtered by the is_replacement_order column
 * @method     array findByOrderAddressId(int $order_address_id) Return ChildAmazonOrders objects filtered by the order_address_id column
 * @method     array findByCustomerId(int $customer_id) Return ChildAmazonOrders objects filtered by the customer_id column
 * @method     array findByOrderId(int $order_id) Return ChildAmazonOrders objects filtered by the order_id column
 * @method     array findByCreatedAt(string $created_at) Return ChildAmazonOrders objects filtered by the created_at column
 * @method     array findByUpdatedAt(string $updated_at) Return ChildAmazonOrders objects filtered by the updated_at column
 * @method     array findByVersion(int $version) Return ChildAmazonOrders objects filtered by the version column
 * @method     array findByVersionCreatedAt(string $version_created_at) Return ChildAmazonOrders objects filtered by the version_created_at column
 * @method     array findByVersionCreatedBy(string $version_created_by) Return ChildAmazonOrders objects filtered by the version_created_by column
 *
 */
abstract class AmazonOrdersQuery extends ModelCriteria
{
    
    // versionable behavior
    
    /**
     * Whether the versioning is enabled
     */
    static $isVersioningEnabled = true;

    /**
     * Initializes internal state of \AmazonIntegration\Model\Base\AmazonOrdersQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'thelia', $modelName = '\\AmazonIntegration\\Model\\AmazonOrders', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildAmazonOrdersQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildAmazonOrdersQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \AmazonIntegration\Model\AmazonOrdersQuery) {
            return $criteria;
        }
        $query = new \AmazonIntegration\Model\AmazonOrdersQuery();
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
     * @return ChildAmazonOrders|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = AmazonOrdersTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(AmazonOrdersTableMap::DATABASE_NAME);
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
     * @return   ChildAmazonOrders A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ID, SELLER_ORDER_ID, PURCHASE_DATE, LAST_UPDATE_DATE, ORDER_STATUS, FULFILLMENT_CHANNEL, SALES_CHANNEL, ORDER_CHANNEL, SHIP_SERVICE_LEVEL, ORDER_TOTAL_CURRENCY_CODE, ORDER_TOTAL_AMOUNT, NUMBER_OF_ITEMS_SHIPPED, NUMBER_OF_ITEMS_UNSHIPPED, PAYMENT_EXECUTION_DETAIL_CURRENCY_CODE, PAYMENT_EXECUTION_DETAIL_TOTAL_AMOUNT, PAYMENT_EXECUTION_DETAIL_PAYMENT_METHOD, PAYMENT_METHOD, PAYMENT_METHOD_DETAIL, MARKETPLACE_ID, BUYER_COUNTY, BUYER_TAX_INFO_COMPANY, BUYER_TAX_INFO_TAXING_REGION, BUYER_TAX_INFO_TAX_NAME, BUYER_TAX_INFO_TAX_VALUE, SHIPMENT_SERVICE_LEVEL_CATEGORY, SHIPPED_BY_AMAZON_TFM, TFM_SHIPMENT_STATUS, CBA_DISPLAYABLE_SHIPPING_LABEL, ORDER_TYPE, EARLIEST_SHIP_DATE, LATEST_SHIP_DATE, EARLIEST_DELIVERY_DATE, LATEST_DELIVERY_DATE, IS_BUSINESS_ORDER, PURCHASE_ORDER_NUMBER, IS_PRIME, IS_PREMIUM_ORDER, REPLACED_ORDER_ID, IS_REPLACEMENT_ORDER, ORDER_ADDRESS_ID, CUSTOMER_ID, ORDER_ID, CREATED_AT, UPDATED_AT, VERSION, VERSION_CREATED_AT, VERSION_CREATED_BY FROM amazon_orders WHERE ID = :p0';
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
            $obj = new ChildAmazonOrders();
            $obj->hydrate($row);
            AmazonOrdersTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildAmazonOrders|array|mixed the result, formatted by the current formatter
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
     * @return ChildAmazonOrdersQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(AmazonOrdersTableMap::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildAmazonOrdersQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(AmazonOrdersTableMap::ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById('fooValue');   // WHERE id = 'fooValue'
     * $query->filterById('%fooValue%'); // WHERE id LIKE '%fooValue%'
     * </code>
     *
     * @param     string $id The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonOrdersQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($id)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $id)) {
                $id = str_replace('*', '%', $id);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AmazonOrdersTableMap::ID, $id, $comparison);
    }

    /**
     * Filter the query on the seller_order_id column
     *
     * Example usage:
     * <code>
     * $query->filterBySellerOrderId('fooValue');   // WHERE seller_order_id = 'fooValue'
     * $query->filterBySellerOrderId('%fooValue%'); // WHERE seller_order_id LIKE '%fooValue%'
     * </code>
     *
     * @param     string $sellerOrderId The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonOrdersQuery The current query, for fluid interface
     */
    public function filterBySellerOrderId($sellerOrderId = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($sellerOrderId)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $sellerOrderId)) {
                $sellerOrderId = str_replace('*', '%', $sellerOrderId);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AmazonOrdersTableMap::SELLER_ORDER_ID, $sellerOrderId, $comparison);
    }

    /**
     * Filter the query on the purchase_date column
     *
     * Example usage:
     * <code>
     * $query->filterByPurchaseDate('2011-03-14'); // WHERE purchase_date = '2011-03-14'
     * $query->filterByPurchaseDate('now'); // WHERE purchase_date = '2011-03-14'
     * $query->filterByPurchaseDate(array('max' => 'yesterday')); // WHERE purchase_date > '2011-03-13'
     * </code>
     *
     * @param     mixed $purchaseDate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonOrdersQuery The current query, for fluid interface
     */
    public function filterByPurchaseDate($purchaseDate = null, $comparison = null)
    {
        if (is_array($purchaseDate)) {
            $useMinMax = false;
            if (isset($purchaseDate['min'])) {
                $this->addUsingAlias(AmazonOrdersTableMap::PURCHASE_DATE, $purchaseDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($purchaseDate['max'])) {
                $this->addUsingAlias(AmazonOrdersTableMap::PURCHASE_DATE, $purchaseDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AmazonOrdersTableMap::PURCHASE_DATE, $purchaseDate, $comparison);
    }

    /**
     * Filter the query on the last_update_date column
     *
     * Example usage:
     * <code>
     * $query->filterByLastUpdateDate('2011-03-14'); // WHERE last_update_date = '2011-03-14'
     * $query->filterByLastUpdateDate('now'); // WHERE last_update_date = '2011-03-14'
     * $query->filterByLastUpdateDate(array('max' => 'yesterday')); // WHERE last_update_date > '2011-03-13'
     * </code>
     *
     * @param     mixed $lastUpdateDate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonOrdersQuery The current query, for fluid interface
     */
    public function filterByLastUpdateDate($lastUpdateDate = null, $comparison = null)
    {
        if (is_array($lastUpdateDate)) {
            $useMinMax = false;
            if (isset($lastUpdateDate['min'])) {
                $this->addUsingAlias(AmazonOrdersTableMap::LAST_UPDATE_DATE, $lastUpdateDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($lastUpdateDate['max'])) {
                $this->addUsingAlias(AmazonOrdersTableMap::LAST_UPDATE_DATE, $lastUpdateDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AmazonOrdersTableMap::LAST_UPDATE_DATE, $lastUpdateDate, $comparison);
    }

    /**
     * Filter the query on the order_status column
     *
     * Example usage:
     * <code>
     * $query->filterByOrderStatus('fooValue');   // WHERE order_status = 'fooValue'
     * $query->filterByOrderStatus('%fooValue%'); // WHERE order_status LIKE '%fooValue%'
     * </code>
     *
     * @param     string $orderStatus The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonOrdersQuery The current query, for fluid interface
     */
    public function filterByOrderStatus($orderStatus = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($orderStatus)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $orderStatus)) {
                $orderStatus = str_replace('*', '%', $orderStatus);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AmazonOrdersTableMap::ORDER_STATUS, $orderStatus, $comparison);
    }

    /**
     * Filter the query on the fulfillment_channel column
     *
     * Example usage:
     * <code>
     * $query->filterByFulfillmentChannel('fooValue');   // WHERE fulfillment_channel = 'fooValue'
     * $query->filterByFulfillmentChannel('%fooValue%'); // WHERE fulfillment_channel LIKE '%fooValue%'
     * </code>
     *
     * @param     string $fulfillmentChannel The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonOrdersQuery The current query, for fluid interface
     */
    public function filterByFulfillmentChannel($fulfillmentChannel = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($fulfillmentChannel)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $fulfillmentChannel)) {
                $fulfillmentChannel = str_replace('*', '%', $fulfillmentChannel);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AmazonOrdersTableMap::FULFILLMENT_CHANNEL, $fulfillmentChannel, $comparison);
    }

    /**
     * Filter the query on the sales_channel column
     *
     * Example usage:
     * <code>
     * $query->filterBySalesChannel('fooValue');   // WHERE sales_channel = 'fooValue'
     * $query->filterBySalesChannel('%fooValue%'); // WHERE sales_channel LIKE '%fooValue%'
     * </code>
     *
     * @param     string $salesChannel The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonOrdersQuery The current query, for fluid interface
     */
    public function filterBySalesChannel($salesChannel = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($salesChannel)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $salesChannel)) {
                $salesChannel = str_replace('*', '%', $salesChannel);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AmazonOrdersTableMap::SALES_CHANNEL, $salesChannel, $comparison);
    }

    /**
     * Filter the query on the order_channel column
     *
     * Example usage:
     * <code>
     * $query->filterByOrderChannel('fooValue');   // WHERE order_channel = 'fooValue'
     * $query->filterByOrderChannel('%fooValue%'); // WHERE order_channel LIKE '%fooValue%'
     * </code>
     *
     * @param     string $orderChannel The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonOrdersQuery The current query, for fluid interface
     */
    public function filterByOrderChannel($orderChannel = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($orderChannel)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $orderChannel)) {
                $orderChannel = str_replace('*', '%', $orderChannel);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AmazonOrdersTableMap::ORDER_CHANNEL, $orderChannel, $comparison);
    }

    /**
     * Filter the query on the ship_service_level column
     *
     * Example usage:
     * <code>
     * $query->filterByShipServiceLevel('fooValue');   // WHERE ship_service_level = 'fooValue'
     * $query->filterByShipServiceLevel('%fooValue%'); // WHERE ship_service_level LIKE '%fooValue%'
     * </code>
     *
     * @param     string $shipServiceLevel The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonOrdersQuery The current query, for fluid interface
     */
    public function filterByShipServiceLevel($shipServiceLevel = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($shipServiceLevel)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $shipServiceLevel)) {
                $shipServiceLevel = str_replace('*', '%', $shipServiceLevel);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AmazonOrdersTableMap::SHIP_SERVICE_LEVEL, $shipServiceLevel, $comparison);
    }

    /**
     * Filter the query on the order_total_currency_code column
     *
     * Example usage:
     * <code>
     * $query->filterByOrderTotalCurrencyCode('fooValue');   // WHERE order_total_currency_code = 'fooValue'
     * $query->filterByOrderTotalCurrencyCode('%fooValue%'); // WHERE order_total_currency_code LIKE '%fooValue%'
     * </code>
     *
     * @param     string $orderTotalCurrencyCode The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonOrdersQuery The current query, for fluid interface
     */
    public function filterByOrderTotalCurrencyCode($orderTotalCurrencyCode = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($orderTotalCurrencyCode)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $orderTotalCurrencyCode)) {
                $orderTotalCurrencyCode = str_replace('*', '%', $orderTotalCurrencyCode);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AmazonOrdersTableMap::ORDER_TOTAL_CURRENCY_CODE, $orderTotalCurrencyCode, $comparison);
    }

    /**
     * Filter the query on the order_total_amount column
     *
     * Example usage:
     * <code>
     * $query->filterByOrderTotalAmount(1234); // WHERE order_total_amount = 1234
     * $query->filterByOrderTotalAmount(array(12, 34)); // WHERE order_total_amount IN (12, 34)
     * $query->filterByOrderTotalAmount(array('min' => 12)); // WHERE order_total_amount > 12
     * </code>
     *
     * @param     mixed $orderTotalAmount The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonOrdersQuery The current query, for fluid interface
     */
    public function filterByOrderTotalAmount($orderTotalAmount = null, $comparison = null)
    {
        if (is_array($orderTotalAmount)) {
            $useMinMax = false;
            if (isset($orderTotalAmount['min'])) {
                $this->addUsingAlias(AmazonOrdersTableMap::ORDER_TOTAL_AMOUNT, $orderTotalAmount['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($orderTotalAmount['max'])) {
                $this->addUsingAlias(AmazonOrdersTableMap::ORDER_TOTAL_AMOUNT, $orderTotalAmount['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AmazonOrdersTableMap::ORDER_TOTAL_AMOUNT, $orderTotalAmount, $comparison);
    }

    /**
     * Filter the query on the number_of_items_shipped column
     *
     * Example usage:
     * <code>
     * $query->filterByNumberOfItemsShipped(1234); // WHERE number_of_items_shipped = 1234
     * $query->filterByNumberOfItemsShipped(array(12, 34)); // WHERE number_of_items_shipped IN (12, 34)
     * $query->filterByNumberOfItemsShipped(array('min' => 12)); // WHERE number_of_items_shipped > 12
     * </code>
     *
     * @param     mixed $numberOfItemsShipped The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonOrdersQuery The current query, for fluid interface
     */
    public function filterByNumberOfItemsShipped($numberOfItemsShipped = null, $comparison = null)
    {
        if (is_array($numberOfItemsShipped)) {
            $useMinMax = false;
            if (isset($numberOfItemsShipped['min'])) {
                $this->addUsingAlias(AmazonOrdersTableMap::NUMBER_OF_ITEMS_SHIPPED, $numberOfItemsShipped['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($numberOfItemsShipped['max'])) {
                $this->addUsingAlias(AmazonOrdersTableMap::NUMBER_OF_ITEMS_SHIPPED, $numberOfItemsShipped['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AmazonOrdersTableMap::NUMBER_OF_ITEMS_SHIPPED, $numberOfItemsShipped, $comparison);
    }

    /**
     * Filter the query on the number_of_items_unshipped column
     *
     * Example usage:
     * <code>
     * $query->filterByNumberOfItemsUnshipped(1234); // WHERE number_of_items_unshipped = 1234
     * $query->filterByNumberOfItemsUnshipped(array(12, 34)); // WHERE number_of_items_unshipped IN (12, 34)
     * $query->filterByNumberOfItemsUnshipped(array('min' => 12)); // WHERE number_of_items_unshipped > 12
     * </code>
     *
     * @param     mixed $numberOfItemsUnshipped The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonOrdersQuery The current query, for fluid interface
     */
    public function filterByNumberOfItemsUnshipped($numberOfItemsUnshipped = null, $comparison = null)
    {
        if (is_array($numberOfItemsUnshipped)) {
            $useMinMax = false;
            if (isset($numberOfItemsUnshipped['min'])) {
                $this->addUsingAlias(AmazonOrdersTableMap::NUMBER_OF_ITEMS_UNSHIPPED, $numberOfItemsUnshipped['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($numberOfItemsUnshipped['max'])) {
                $this->addUsingAlias(AmazonOrdersTableMap::NUMBER_OF_ITEMS_UNSHIPPED, $numberOfItemsUnshipped['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AmazonOrdersTableMap::NUMBER_OF_ITEMS_UNSHIPPED, $numberOfItemsUnshipped, $comparison);
    }

    /**
     * Filter the query on the payment_execution_detail_currency_code column
     *
     * Example usage:
     * <code>
     * $query->filterByPaymentExecutionDetailCurrencyCode('fooValue');   // WHERE payment_execution_detail_currency_code = 'fooValue'
     * $query->filterByPaymentExecutionDetailCurrencyCode('%fooValue%'); // WHERE payment_execution_detail_currency_code LIKE '%fooValue%'
     * </code>
     *
     * @param     string $paymentExecutionDetailCurrencyCode The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonOrdersQuery The current query, for fluid interface
     */
    public function filterByPaymentExecutionDetailCurrencyCode($paymentExecutionDetailCurrencyCode = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($paymentExecutionDetailCurrencyCode)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $paymentExecutionDetailCurrencyCode)) {
                $paymentExecutionDetailCurrencyCode = str_replace('*', '%', $paymentExecutionDetailCurrencyCode);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AmazonOrdersTableMap::PAYMENT_EXECUTION_DETAIL_CURRENCY_CODE, $paymentExecutionDetailCurrencyCode, $comparison);
    }

    /**
     * Filter the query on the payment_execution_detail_total_amount column
     *
     * Example usage:
     * <code>
     * $query->filterByPaymentExecutionDetailTotalAmount(1234); // WHERE payment_execution_detail_total_amount = 1234
     * $query->filterByPaymentExecutionDetailTotalAmount(array(12, 34)); // WHERE payment_execution_detail_total_amount IN (12, 34)
     * $query->filterByPaymentExecutionDetailTotalAmount(array('min' => 12)); // WHERE payment_execution_detail_total_amount > 12
     * </code>
     *
     * @param     mixed $paymentExecutionDetailTotalAmount The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonOrdersQuery The current query, for fluid interface
     */
    public function filterByPaymentExecutionDetailTotalAmount($paymentExecutionDetailTotalAmount = null, $comparison = null)
    {
        if (is_array($paymentExecutionDetailTotalAmount)) {
            $useMinMax = false;
            if (isset($paymentExecutionDetailTotalAmount['min'])) {
                $this->addUsingAlias(AmazonOrdersTableMap::PAYMENT_EXECUTION_DETAIL_TOTAL_AMOUNT, $paymentExecutionDetailTotalAmount['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($paymentExecutionDetailTotalAmount['max'])) {
                $this->addUsingAlias(AmazonOrdersTableMap::PAYMENT_EXECUTION_DETAIL_TOTAL_AMOUNT, $paymentExecutionDetailTotalAmount['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AmazonOrdersTableMap::PAYMENT_EXECUTION_DETAIL_TOTAL_AMOUNT, $paymentExecutionDetailTotalAmount, $comparison);
    }

    /**
     * Filter the query on the payment_execution_detail_payment_method column
     *
     * Example usage:
     * <code>
     * $query->filterByPaymentExecutionDetailPaymentMethod('fooValue');   // WHERE payment_execution_detail_payment_method = 'fooValue'
     * $query->filterByPaymentExecutionDetailPaymentMethod('%fooValue%'); // WHERE payment_execution_detail_payment_method LIKE '%fooValue%'
     * </code>
     *
     * @param     string $paymentExecutionDetailPaymentMethod The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonOrdersQuery The current query, for fluid interface
     */
    public function filterByPaymentExecutionDetailPaymentMethod($paymentExecutionDetailPaymentMethod = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($paymentExecutionDetailPaymentMethod)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $paymentExecutionDetailPaymentMethod)) {
                $paymentExecutionDetailPaymentMethod = str_replace('*', '%', $paymentExecutionDetailPaymentMethod);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AmazonOrdersTableMap::PAYMENT_EXECUTION_DETAIL_PAYMENT_METHOD, $paymentExecutionDetailPaymentMethod, $comparison);
    }

    /**
     * Filter the query on the payment_method column
     *
     * Example usage:
     * <code>
     * $query->filterByPaymentMethod('fooValue');   // WHERE payment_method = 'fooValue'
     * $query->filterByPaymentMethod('%fooValue%'); // WHERE payment_method LIKE '%fooValue%'
     * </code>
     *
     * @param     string $paymentMethod The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonOrdersQuery The current query, for fluid interface
     */
    public function filterByPaymentMethod($paymentMethod = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($paymentMethod)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $paymentMethod)) {
                $paymentMethod = str_replace('*', '%', $paymentMethod);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AmazonOrdersTableMap::PAYMENT_METHOD, $paymentMethod, $comparison);
    }

    /**
     * Filter the query on the payment_method_detail column
     *
     * Example usage:
     * <code>
     * $query->filterByPaymentMethodDetail('fooValue');   // WHERE payment_method_detail = 'fooValue'
     * $query->filterByPaymentMethodDetail('%fooValue%'); // WHERE payment_method_detail LIKE '%fooValue%'
     * </code>
     *
     * @param     string $paymentMethodDetail The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonOrdersQuery The current query, for fluid interface
     */
    public function filterByPaymentMethodDetail($paymentMethodDetail = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($paymentMethodDetail)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $paymentMethodDetail)) {
                $paymentMethodDetail = str_replace('*', '%', $paymentMethodDetail);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AmazonOrdersTableMap::PAYMENT_METHOD_DETAIL, $paymentMethodDetail, $comparison);
    }

    /**
     * Filter the query on the marketplace_id column
     *
     * Example usage:
     * <code>
     * $query->filterByMarketplaceId('fooValue');   // WHERE marketplace_id = 'fooValue'
     * $query->filterByMarketplaceId('%fooValue%'); // WHERE marketplace_id LIKE '%fooValue%'
     * </code>
     *
     * @param     string $marketplaceId The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonOrdersQuery The current query, for fluid interface
     */
    public function filterByMarketplaceId($marketplaceId = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($marketplaceId)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $marketplaceId)) {
                $marketplaceId = str_replace('*', '%', $marketplaceId);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AmazonOrdersTableMap::MARKETPLACE_ID, $marketplaceId, $comparison);
    }

    /**
     * Filter the query on the buyer_county column
     *
     * Example usage:
     * <code>
     * $query->filterByBuyerCounty('fooValue');   // WHERE buyer_county = 'fooValue'
     * $query->filterByBuyerCounty('%fooValue%'); // WHERE buyer_county LIKE '%fooValue%'
     * </code>
     *
     * @param     string $buyerCounty The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonOrdersQuery The current query, for fluid interface
     */
    public function filterByBuyerCounty($buyerCounty = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($buyerCounty)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $buyerCounty)) {
                $buyerCounty = str_replace('*', '%', $buyerCounty);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AmazonOrdersTableMap::BUYER_COUNTY, $buyerCounty, $comparison);
    }

    /**
     * Filter the query on the buyer_tax_info_company column
     *
     * Example usage:
     * <code>
     * $query->filterByBuyerTaxInfoCompany('fooValue');   // WHERE buyer_tax_info_company = 'fooValue'
     * $query->filterByBuyerTaxInfoCompany('%fooValue%'); // WHERE buyer_tax_info_company LIKE '%fooValue%'
     * </code>
     *
     * @param     string $buyerTaxInfoCompany The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonOrdersQuery The current query, for fluid interface
     */
    public function filterByBuyerTaxInfoCompany($buyerTaxInfoCompany = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($buyerTaxInfoCompany)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $buyerTaxInfoCompany)) {
                $buyerTaxInfoCompany = str_replace('*', '%', $buyerTaxInfoCompany);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AmazonOrdersTableMap::BUYER_TAX_INFO_COMPANY, $buyerTaxInfoCompany, $comparison);
    }

    /**
     * Filter the query on the buyer_tax_info_taxing_region column
     *
     * Example usage:
     * <code>
     * $query->filterByBuyerTaxInfoTaxingRegion('fooValue');   // WHERE buyer_tax_info_taxing_region = 'fooValue'
     * $query->filterByBuyerTaxInfoTaxingRegion('%fooValue%'); // WHERE buyer_tax_info_taxing_region LIKE '%fooValue%'
     * </code>
     *
     * @param     string $buyerTaxInfoTaxingRegion The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonOrdersQuery The current query, for fluid interface
     */
    public function filterByBuyerTaxInfoTaxingRegion($buyerTaxInfoTaxingRegion = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($buyerTaxInfoTaxingRegion)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $buyerTaxInfoTaxingRegion)) {
                $buyerTaxInfoTaxingRegion = str_replace('*', '%', $buyerTaxInfoTaxingRegion);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AmazonOrdersTableMap::BUYER_TAX_INFO_TAXING_REGION, $buyerTaxInfoTaxingRegion, $comparison);
    }

    /**
     * Filter the query on the buyer_tax_info_tax_name column
     *
     * Example usage:
     * <code>
     * $query->filterByBuyerTaxInfoTaxName('fooValue');   // WHERE buyer_tax_info_tax_name = 'fooValue'
     * $query->filterByBuyerTaxInfoTaxName('%fooValue%'); // WHERE buyer_tax_info_tax_name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $buyerTaxInfoTaxName The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonOrdersQuery The current query, for fluid interface
     */
    public function filterByBuyerTaxInfoTaxName($buyerTaxInfoTaxName = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($buyerTaxInfoTaxName)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $buyerTaxInfoTaxName)) {
                $buyerTaxInfoTaxName = str_replace('*', '%', $buyerTaxInfoTaxName);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AmazonOrdersTableMap::BUYER_TAX_INFO_TAX_NAME, $buyerTaxInfoTaxName, $comparison);
    }

    /**
     * Filter the query on the buyer_tax_info_tax_value column
     *
     * Example usage:
     * <code>
     * $query->filterByBuyerTaxInfoTaxValue('fooValue');   // WHERE buyer_tax_info_tax_value = 'fooValue'
     * $query->filterByBuyerTaxInfoTaxValue('%fooValue%'); // WHERE buyer_tax_info_tax_value LIKE '%fooValue%'
     * </code>
     *
     * @param     string $buyerTaxInfoTaxValue The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonOrdersQuery The current query, for fluid interface
     */
    public function filterByBuyerTaxInfoTaxValue($buyerTaxInfoTaxValue = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($buyerTaxInfoTaxValue)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $buyerTaxInfoTaxValue)) {
                $buyerTaxInfoTaxValue = str_replace('*', '%', $buyerTaxInfoTaxValue);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AmazonOrdersTableMap::BUYER_TAX_INFO_TAX_VALUE, $buyerTaxInfoTaxValue, $comparison);
    }

    /**
     * Filter the query on the shipment_service_level_category column
     *
     * Example usage:
     * <code>
     * $query->filterByShipmentServiceLevelCategory('fooValue');   // WHERE shipment_service_level_category = 'fooValue'
     * $query->filterByShipmentServiceLevelCategory('%fooValue%'); // WHERE shipment_service_level_category LIKE '%fooValue%'
     * </code>
     *
     * @param     string $shipmentServiceLevelCategory The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonOrdersQuery The current query, for fluid interface
     */
    public function filterByShipmentServiceLevelCategory($shipmentServiceLevelCategory = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($shipmentServiceLevelCategory)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $shipmentServiceLevelCategory)) {
                $shipmentServiceLevelCategory = str_replace('*', '%', $shipmentServiceLevelCategory);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AmazonOrdersTableMap::SHIPMENT_SERVICE_LEVEL_CATEGORY, $shipmentServiceLevelCategory, $comparison);
    }

    /**
     * Filter the query on the shipped_by_amazon_tfm column
     *
     * Example usage:
     * <code>
     * $query->filterByShippedByAmazonTfm(1234); // WHERE shipped_by_amazon_tfm = 1234
     * $query->filterByShippedByAmazonTfm(array(12, 34)); // WHERE shipped_by_amazon_tfm IN (12, 34)
     * $query->filterByShippedByAmazonTfm(array('min' => 12)); // WHERE shipped_by_amazon_tfm > 12
     * </code>
     *
     * @param     mixed $shippedByAmazonTfm The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonOrdersQuery The current query, for fluid interface
     */
    public function filterByShippedByAmazonTfm($shippedByAmazonTfm = null, $comparison = null)
    {
        if (is_array($shippedByAmazonTfm)) {
            $useMinMax = false;
            if (isset($shippedByAmazonTfm['min'])) {
                $this->addUsingAlias(AmazonOrdersTableMap::SHIPPED_BY_AMAZON_TFM, $shippedByAmazonTfm['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($shippedByAmazonTfm['max'])) {
                $this->addUsingAlias(AmazonOrdersTableMap::SHIPPED_BY_AMAZON_TFM, $shippedByAmazonTfm['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AmazonOrdersTableMap::SHIPPED_BY_AMAZON_TFM, $shippedByAmazonTfm, $comparison);
    }

    /**
     * Filter the query on the tfm_shipment_status column
     *
     * Example usage:
     * <code>
     * $query->filterByTfmShipmentStatus('fooValue');   // WHERE tfm_shipment_status = 'fooValue'
     * $query->filterByTfmShipmentStatus('%fooValue%'); // WHERE tfm_shipment_status LIKE '%fooValue%'
     * </code>
     *
     * @param     string $tfmShipmentStatus The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonOrdersQuery The current query, for fluid interface
     */
    public function filterByTfmShipmentStatus($tfmShipmentStatus = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($tfmShipmentStatus)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $tfmShipmentStatus)) {
                $tfmShipmentStatus = str_replace('*', '%', $tfmShipmentStatus);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AmazonOrdersTableMap::TFM_SHIPMENT_STATUS, $tfmShipmentStatus, $comparison);
    }

    /**
     * Filter the query on the cba_displayable_shipping_label column
     *
     * Example usage:
     * <code>
     * $query->filterByCbaDisplayableShippingLabel('fooValue');   // WHERE cba_displayable_shipping_label = 'fooValue'
     * $query->filterByCbaDisplayableShippingLabel('%fooValue%'); // WHERE cba_displayable_shipping_label LIKE '%fooValue%'
     * </code>
     *
     * @param     string $cbaDisplayableShippingLabel The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonOrdersQuery The current query, for fluid interface
     */
    public function filterByCbaDisplayableShippingLabel($cbaDisplayableShippingLabel = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($cbaDisplayableShippingLabel)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $cbaDisplayableShippingLabel)) {
                $cbaDisplayableShippingLabel = str_replace('*', '%', $cbaDisplayableShippingLabel);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AmazonOrdersTableMap::CBA_DISPLAYABLE_SHIPPING_LABEL, $cbaDisplayableShippingLabel, $comparison);
    }

    /**
     * Filter the query on the order_type column
     *
     * Example usage:
     * <code>
     * $query->filterByOrderType('fooValue');   // WHERE order_type = 'fooValue'
     * $query->filterByOrderType('%fooValue%'); // WHERE order_type LIKE '%fooValue%'
     * </code>
     *
     * @param     string $orderType The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonOrdersQuery The current query, for fluid interface
     */
    public function filterByOrderType($orderType = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($orderType)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $orderType)) {
                $orderType = str_replace('*', '%', $orderType);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AmazonOrdersTableMap::ORDER_TYPE, $orderType, $comparison);
    }

    /**
     * Filter the query on the earliest_ship_date column
     *
     * Example usage:
     * <code>
     * $query->filterByEarliestShipDate('2011-03-14'); // WHERE earliest_ship_date = '2011-03-14'
     * $query->filterByEarliestShipDate('now'); // WHERE earliest_ship_date = '2011-03-14'
     * $query->filterByEarliestShipDate(array('max' => 'yesterday')); // WHERE earliest_ship_date > '2011-03-13'
     * </code>
     *
     * @param     mixed $earliestShipDate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonOrdersQuery The current query, for fluid interface
     */
    public function filterByEarliestShipDate($earliestShipDate = null, $comparison = null)
    {
        if (is_array($earliestShipDate)) {
            $useMinMax = false;
            if (isset($earliestShipDate['min'])) {
                $this->addUsingAlias(AmazonOrdersTableMap::EARLIEST_SHIP_DATE, $earliestShipDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($earliestShipDate['max'])) {
                $this->addUsingAlias(AmazonOrdersTableMap::EARLIEST_SHIP_DATE, $earliestShipDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AmazonOrdersTableMap::EARLIEST_SHIP_DATE, $earliestShipDate, $comparison);
    }

    /**
     * Filter the query on the latest_ship_date column
     *
     * Example usage:
     * <code>
     * $query->filterByLatestShipDate('2011-03-14'); // WHERE latest_ship_date = '2011-03-14'
     * $query->filterByLatestShipDate('now'); // WHERE latest_ship_date = '2011-03-14'
     * $query->filterByLatestShipDate(array('max' => 'yesterday')); // WHERE latest_ship_date > '2011-03-13'
     * </code>
     *
     * @param     mixed $latestShipDate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonOrdersQuery The current query, for fluid interface
     */
    public function filterByLatestShipDate($latestShipDate = null, $comparison = null)
    {
        if (is_array($latestShipDate)) {
            $useMinMax = false;
            if (isset($latestShipDate['min'])) {
                $this->addUsingAlias(AmazonOrdersTableMap::LATEST_SHIP_DATE, $latestShipDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($latestShipDate['max'])) {
                $this->addUsingAlias(AmazonOrdersTableMap::LATEST_SHIP_DATE, $latestShipDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AmazonOrdersTableMap::LATEST_SHIP_DATE, $latestShipDate, $comparison);
    }

    /**
     * Filter the query on the earliest_delivery_date column
     *
     * Example usage:
     * <code>
     * $query->filterByEarliestDeliveryDate('2011-03-14'); // WHERE earliest_delivery_date = '2011-03-14'
     * $query->filterByEarliestDeliveryDate('now'); // WHERE earliest_delivery_date = '2011-03-14'
     * $query->filterByEarliestDeliveryDate(array('max' => 'yesterday')); // WHERE earliest_delivery_date > '2011-03-13'
     * </code>
     *
     * @param     mixed $earliestDeliveryDate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonOrdersQuery The current query, for fluid interface
     */
    public function filterByEarliestDeliveryDate($earliestDeliveryDate = null, $comparison = null)
    {
        if (is_array($earliestDeliveryDate)) {
            $useMinMax = false;
            if (isset($earliestDeliveryDate['min'])) {
                $this->addUsingAlias(AmazonOrdersTableMap::EARLIEST_DELIVERY_DATE, $earliestDeliveryDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($earliestDeliveryDate['max'])) {
                $this->addUsingAlias(AmazonOrdersTableMap::EARLIEST_DELIVERY_DATE, $earliestDeliveryDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AmazonOrdersTableMap::EARLIEST_DELIVERY_DATE, $earliestDeliveryDate, $comparison);
    }

    /**
     * Filter the query on the latest_delivery_date column
     *
     * Example usage:
     * <code>
     * $query->filterByLatestDeliveryDate('2011-03-14'); // WHERE latest_delivery_date = '2011-03-14'
     * $query->filterByLatestDeliveryDate('now'); // WHERE latest_delivery_date = '2011-03-14'
     * $query->filterByLatestDeliveryDate(array('max' => 'yesterday')); // WHERE latest_delivery_date > '2011-03-13'
     * </code>
     *
     * @param     mixed $latestDeliveryDate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonOrdersQuery The current query, for fluid interface
     */
    public function filterByLatestDeliveryDate($latestDeliveryDate = null, $comparison = null)
    {
        if (is_array($latestDeliveryDate)) {
            $useMinMax = false;
            if (isset($latestDeliveryDate['min'])) {
                $this->addUsingAlias(AmazonOrdersTableMap::LATEST_DELIVERY_DATE, $latestDeliveryDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($latestDeliveryDate['max'])) {
                $this->addUsingAlias(AmazonOrdersTableMap::LATEST_DELIVERY_DATE, $latestDeliveryDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AmazonOrdersTableMap::LATEST_DELIVERY_DATE, $latestDeliveryDate, $comparison);
    }

    /**
     * Filter the query on the is_business_order column
     *
     * Example usage:
     * <code>
     * $query->filterByIsBusinessOrder(1234); // WHERE is_business_order = 1234
     * $query->filterByIsBusinessOrder(array(12, 34)); // WHERE is_business_order IN (12, 34)
     * $query->filterByIsBusinessOrder(array('min' => 12)); // WHERE is_business_order > 12
     * </code>
     *
     * @param     mixed $isBusinessOrder The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonOrdersQuery The current query, for fluid interface
     */
    public function filterByIsBusinessOrder($isBusinessOrder = null, $comparison = null)
    {
        if (is_array($isBusinessOrder)) {
            $useMinMax = false;
            if (isset($isBusinessOrder['min'])) {
                $this->addUsingAlias(AmazonOrdersTableMap::IS_BUSINESS_ORDER, $isBusinessOrder['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($isBusinessOrder['max'])) {
                $this->addUsingAlias(AmazonOrdersTableMap::IS_BUSINESS_ORDER, $isBusinessOrder['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AmazonOrdersTableMap::IS_BUSINESS_ORDER, $isBusinessOrder, $comparison);
    }

    /**
     * Filter the query on the purchase_order_number column
     *
     * Example usage:
     * <code>
     * $query->filterByPurchaseOrderNumber('fooValue');   // WHERE purchase_order_number = 'fooValue'
     * $query->filterByPurchaseOrderNumber('%fooValue%'); // WHERE purchase_order_number LIKE '%fooValue%'
     * </code>
     *
     * @param     string $purchaseOrderNumber The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonOrdersQuery The current query, for fluid interface
     */
    public function filterByPurchaseOrderNumber($purchaseOrderNumber = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($purchaseOrderNumber)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $purchaseOrderNumber)) {
                $purchaseOrderNumber = str_replace('*', '%', $purchaseOrderNumber);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AmazonOrdersTableMap::PURCHASE_ORDER_NUMBER, $purchaseOrderNumber, $comparison);
    }

    /**
     * Filter the query on the is_prime column
     *
     * Example usage:
     * <code>
     * $query->filterByIsPrime(1234); // WHERE is_prime = 1234
     * $query->filterByIsPrime(array(12, 34)); // WHERE is_prime IN (12, 34)
     * $query->filterByIsPrime(array('min' => 12)); // WHERE is_prime > 12
     * </code>
     *
     * @param     mixed $isPrime The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonOrdersQuery The current query, for fluid interface
     */
    public function filterByIsPrime($isPrime = null, $comparison = null)
    {
        if (is_array($isPrime)) {
            $useMinMax = false;
            if (isset($isPrime['min'])) {
                $this->addUsingAlias(AmazonOrdersTableMap::IS_PRIME, $isPrime['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($isPrime['max'])) {
                $this->addUsingAlias(AmazonOrdersTableMap::IS_PRIME, $isPrime['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AmazonOrdersTableMap::IS_PRIME, $isPrime, $comparison);
    }

    /**
     * Filter the query on the is_premium_order column
     *
     * Example usage:
     * <code>
     * $query->filterByIsPremiumOrder(1234); // WHERE is_premium_order = 1234
     * $query->filterByIsPremiumOrder(array(12, 34)); // WHERE is_premium_order IN (12, 34)
     * $query->filterByIsPremiumOrder(array('min' => 12)); // WHERE is_premium_order > 12
     * </code>
     *
     * @param     mixed $isPremiumOrder The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonOrdersQuery The current query, for fluid interface
     */
    public function filterByIsPremiumOrder($isPremiumOrder = null, $comparison = null)
    {
        if (is_array($isPremiumOrder)) {
            $useMinMax = false;
            if (isset($isPremiumOrder['min'])) {
                $this->addUsingAlias(AmazonOrdersTableMap::IS_PREMIUM_ORDER, $isPremiumOrder['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($isPremiumOrder['max'])) {
                $this->addUsingAlias(AmazonOrdersTableMap::IS_PREMIUM_ORDER, $isPremiumOrder['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AmazonOrdersTableMap::IS_PREMIUM_ORDER, $isPremiumOrder, $comparison);
    }

    /**
     * Filter the query on the replaced_order_id column
     *
     * Example usage:
     * <code>
     * $query->filterByReplacedOrderId('fooValue');   // WHERE replaced_order_id = 'fooValue'
     * $query->filterByReplacedOrderId('%fooValue%'); // WHERE replaced_order_id LIKE '%fooValue%'
     * </code>
     *
     * @param     string $replacedOrderId The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonOrdersQuery The current query, for fluid interface
     */
    public function filterByReplacedOrderId($replacedOrderId = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($replacedOrderId)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $replacedOrderId)) {
                $replacedOrderId = str_replace('*', '%', $replacedOrderId);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AmazonOrdersTableMap::REPLACED_ORDER_ID, $replacedOrderId, $comparison);
    }

    /**
     * Filter the query on the is_replacement_order column
     *
     * Example usage:
     * <code>
     * $query->filterByIsReplacementOrder(1234); // WHERE is_replacement_order = 1234
     * $query->filterByIsReplacementOrder(array(12, 34)); // WHERE is_replacement_order IN (12, 34)
     * $query->filterByIsReplacementOrder(array('min' => 12)); // WHERE is_replacement_order > 12
     * </code>
     *
     * @param     mixed $isReplacementOrder The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonOrdersQuery The current query, for fluid interface
     */
    public function filterByIsReplacementOrder($isReplacementOrder = null, $comparison = null)
    {
        if (is_array($isReplacementOrder)) {
            $useMinMax = false;
            if (isset($isReplacementOrder['min'])) {
                $this->addUsingAlias(AmazonOrdersTableMap::IS_REPLACEMENT_ORDER, $isReplacementOrder['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($isReplacementOrder['max'])) {
                $this->addUsingAlias(AmazonOrdersTableMap::IS_REPLACEMENT_ORDER, $isReplacementOrder['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AmazonOrdersTableMap::IS_REPLACEMENT_ORDER, $isReplacementOrder, $comparison);
    }

    /**
     * Filter the query on the order_address_id column
     *
     * Example usage:
     * <code>
     * $query->filterByOrderAddressId(1234); // WHERE order_address_id = 1234
     * $query->filterByOrderAddressId(array(12, 34)); // WHERE order_address_id IN (12, 34)
     * $query->filterByOrderAddressId(array('min' => 12)); // WHERE order_address_id > 12
     * </code>
     *
     * @see       filterByOrderAddress()
     *
     * @param     mixed $orderAddressId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonOrdersQuery The current query, for fluid interface
     */
    public function filterByOrderAddressId($orderAddressId = null, $comparison = null)
    {
        if (is_array($orderAddressId)) {
            $useMinMax = false;
            if (isset($orderAddressId['min'])) {
                $this->addUsingAlias(AmazonOrdersTableMap::ORDER_ADDRESS_ID, $orderAddressId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($orderAddressId['max'])) {
                $this->addUsingAlias(AmazonOrdersTableMap::ORDER_ADDRESS_ID, $orderAddressId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AmazonOrdersTableMap::ORDER_ADDRESS_ID, $orderAddressId, $comparison);
    }

    /**
     * Filter the query on the customer_id column
     *
     * Example usage:
     * <code>
     * $query->filterByCustomerId(1234); // WHERE customer_id = 1234
     * $query->filterByCustomerId(array(12, 34)); // WHERE customer_id IN (12, 34)
     * $query->filterByCustomerId(array('min' => 12)); // WHERE customer_id > 12
     * </code>
     *
     * @see       filterByCustomer()
     *
     * @param     mixed $customerId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonOrdersQuery The current query, for fluid interface
     */
    public function filterByCustomerId($customerId = null, $comparison = null)
    {
        if (is_array($customerId)) {
            $useMinMax = false;
            if (isset($customerId['min'])) {
                $this->addUsingAlias(AmazonOrdersTableMap::CUSTOMER_ID, $customerId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($customerId['max'])) {
                $this->addUsingAlias(AmazonOrdersTableMap::CUSTOMER_ID, $customerId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AmazonOrdersTableMap::CUSTOMER_ID, $customerId, $comparison);
    }

    /**
     * Filter the query on the order_id column
     *
     * Example usage:
     * <code>
     * $query->filterByOrderId(1234); // WHERE order_id = 1234
     * $query->filterByOrderId(array(12, 34)); // WHERE order_id IN (12, 34)
     * $query->filterByOrderId(array('min' => 12)); // WHERE order_id > 12
     * </code>
     *
     * @see       filterByOrder()
     *
     * @param     mixed $orderId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonOrdersQuery The current query, for fluid interface
     */
    public function filterByOrderId($orderId = null, $comparison = null)
    {
        if (is_array($orderId)) {
            $useMinMax = false;
            if (isset($orderId['min'])) {
                $this->addUsingAlias(AmazonOrdersTableMap::ORDER_ID, $orderId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($orderId['max'])) {
                $this->addUsingAlias(AmazonOrdersTableMap::ORDER_ID, $orderId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AmazonOrdersTableMap::ORDER_ID, $orderId, $comparison);
    }

    /**
     * Filter the query on the created_at column
     *
     * Example usage:
     * <code>
     * $query->filterByCreatedAt('2011-03-14'); // WHERE created_at = '2011-03-14'
     * $query->filterByCreatedAt('now'); // WHERE created_at = '2011-03-14'
     * $query->filterByCreatedAt(array('max' => 'yesterday')); // WHERE created_at > '2011-03-13'
     * </code>
     *
     * @param     mixed $createdAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonOrdersQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(AmazonOrdersTableMap::CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(AmazonOrdersTableMap::CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AmazonOrdersTableMap::CREATED_AT, $createdAt, $comparison);
    }

    /**
     * Filter the query on the updated_at column
     *
     * Example usage:
     * <code>
     * $query->filterByUpdatedAt('2011-03-14'); // WHERE updated_at = '2011-03-14'
     * $query->filterByUpdatedAt('now'); // WHERE updated_at = '2011-03-14'
     * $query->filterByUpdatedAt(array('max' => 'yesterday')); // WHERE updated_at > '2011-03-13'
     * </code>
     *
     * @param     mixed $updatedAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonOrdersQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(AmazonOrdersTableMap::UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(AmazonOrdersTableMap::UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AmazonOrdersTableMap::UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Filter the query on the version column
     *
     * Example usage:
     * <code>
     * $query->filterByVersion(1234); // WHERE version = 1234
     * $query->filterByVersion(array(12, 34)); // WHERE version IN (12, 34)
     * $query->filterByVersion(array('min' => 12)); // WHERE version > 12
     * </code>
     *
     * @param     mixed $version The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonOrdersQuery The current query, for fluid interface
     */
    public function filterByVersion($version = null, $comparison = null)
    {
        if (is_array($version)) {
            $useMinMax = false;
            if (isset($version['min'])) {
                $this->addUsingAlias(AmazonOrdersTableMap::VERSION, $version['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($version['max'])) {
                $this->addUsingAlias(AmazonOrdersTableMap::VERSION, $version['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AmazonOrdersTableMap::VERSION, $version, $comparison);
    }

    /**
     * Filter the query on the version_created_at column
     *
     * Example usage:
     * <code>
     * $query->filterByVersionCreatedAt('2011-03-14'); // WHERE version_created_at = '2011-03-14'
     * $query->filterByVersionCreatedAt('now'); // WHERE version_created_at = '2011-03-14'
     * $query->filterByVersionCreatedAt(array('max' => 'yesterday')); // WHERE version_created_at > '2011-03-13'
     * </code>
     *
     * @param     mixed $versionCreatedAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonOrdersQuery The current query, for fluid interface
     */
    public function filterByVersionCreatedAt($versionCreatedAt = null, $comparison = null)
    {
        if (is_array($versionCreatedAt)) {
            $useMinMax = false;
            if (isset($versionCreatedAt['min'])) {
                $this->addUsingAlias(AmazonOrdersTableMap::VERSION_CREATED_AT, $versionCreatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($versionCreatedAt['max'])) {
                $this->addUsingAlias(AmazonOrdersTableMap::VERSION_CREATED_AT, $versionCreatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AmazonOrdersTableMap::VERSION_CREATED_AT, $versionCreatedAt, $comparison);
    }

    /**
     * Filter the query on the version_created_by column
     *
     * Example usage:
     * <code>
     * $query->filterByVersionCreatedBy('fooValue');   // WHERE version_created_by = 'fooValue'
     * $query->filterByVersionCreatedBy('%fooValue%'); // WHERE version_created_by LIKE '%fooValue%'
     * </code>
     *
     * @param     string $versionCreatedBy The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonOrdersQuery The current query, for fluid interface
     */
    public function filterByVersionCreatedBy($versionCreatedBy = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($versionCreatedBy)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $versionCreatedBy)) {
                $versionCreatedBy = str_replace('*', '%', $versionCreatedBy);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AmazonOrdersTableMap::VERSION_CREATED_BY, $versionCreatedBy, $comparison);
    }

    /**
     * Filter the query by a related \AmazonIntegration\Model\Customer object
     *
     * @param \AmazonIntegration\Model\Customer|ObjectCollection $customer The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonOrdersQuery The current query, for fluid interface
     */
    public function filterByCustomer($customer, $comparison = null)
    {
        if ($customer instanceof \AmazonIntegration\Model\Customer) {
            return $this
                ->addUsingAlias(AmazonOrdersTableMap::CUSTOMER_ID, $customer->getId(), $comparison);
        } elseif ($customer instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AmazonOrdersTableMap::CUSTOMER_ID, $customer->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByCustomer() only accepts arguments of type \AmazonIntegration\Model\Customer or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Customer relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildAmazonOrdersQuery The current query, for fluid interface
     */
    public function joinCustomer($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Customer');

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
            $this->addJoinObject($join, 'Customer');
        }

        return $this;
    }

    /**
     * Use the Customer relation Customer object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \AmazonIntegration\Model\CustomerQuery A secondary query class using the current class as primary query
     */
    public function useCustomerQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinCustomer($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Customer', '\AmazonIntegration\Model\CustomerQuery');
    }

    /**
     * Filter the query by a related \AmazonIntegration\Model\OrderAddress object
     *
     * @param \AmazonIntegration\Model\OrderAddress|ObjectCollection $orderAddress The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonOrdersQuery The current query, for fluid interface
     */
    public function filterByOrderAddress($orderAddress, $comparison = null)
    {
        if ($orderAddress instanceof \AmazonIntegration\Model\OrderAddress) {
            return $this
                ->addUsingAlias(AmazonOrdersTableMap::ORDER_ADDRESS_ID, $orderAddress->getId(), $comparison);
        } elseif ($orderAddress instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AmazonOrdersTableMap::ORDER_ADDRESS_ID, $orderAddress->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByOrderAddress() only accepts arguments of type \AmazonIntegration\Model\OrderAddress or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the OrderAddress relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildAmazonOrdersQuery The current query, for fluid interface
     */
    public function joinOrderAddress($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('OrderAddress');

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
            $this->addJoinObject($join, 'OrderAddress');
        }

        return $this;
    }

    /**
     * Use the OrderAddress relation OrderAddress object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \AmazonIntegration\Model\OrderAddressQuery A secondary query class using the current class as primary query
     */
    public function useOrderAddressQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinOrderAddress($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'OrderAddress', '\AmazonIntegration\Model\OrderAddressQuery');
    }

    /**
     * Filter the query by a related \AmazonIntegration\Model\Order object
     *
     * @param \AmazonIntegration\Model\Order|ObjectCollection $order The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonOrdersQuery The current query, for fluid interface
     */
    public function filterByOrder($order, $comparison = null)
    {
        if ($order instanceof \AmazonIntegration\Model\Order) {
            return $this
                ->addUsingAlias(AmazonOrdersTableMap::ORDER_ID, $order->getId(), $comparison);
        } elseif ($order instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AmazonOrdersTableMap::ORDER_ID, $order->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByOrder() only accepts arguments of type \AmazonIntegration\Model\Order or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Order relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildAmazonOrdersQuery The current query, for fluid interface
     */
    public function joinOrder($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Order');

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
            $this->addJoinObject($join, 'Order');
        }

        return $this;
    }

    /**
     * Use the Order relation Order object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \AmazonIntegration\Model\OrderQuery A secondary query class using the current class as primary query
     */
    public function useOrderQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinOrder($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Order', '\AmazonIntegration\Model\OrderQuery');
    }

    /**
     * Filter the query by a related \AmazonIntegration\Model\AmazonOrdersVersion object
     *
     * @param \AmazonIntegration\Model\AmazonOrdersVersion|ObjectCollection $amazonOrdersVersion  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonOrdersQuery The current query, for fluid interface
     */
    public function filterByAmazonOrdersVersion($amazonOrdersVersion, $comparison = null)
    {
        if ($amazonOrdersVersion instanceof \AmazonIntegration\Model\AmazonOrdersVersion) {
            return $this
                ->addUsingAlias(AmazonOrdersTableMap::ID, $amazonOrdersVersion->getId(), $comparison);
        } elseif ($amazonOrdersVersion instanceof ObjectCollection) {
            return $this
                ->useAmazonOrdersVersionQuery()
                ->filterByPrimaryKeys($amazonOrdersVersion->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByAmazonOrdersVersion() only accepts arguments of type \AmazonIntegration\Model\AmazonOrdersVersion or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the AmazonOrdersVersion relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildAmazonOrdersQuery The current query, for fluid interface
     */
    public function joinAmazonOrdersVersion($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('AmazonOrdersVersion');

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
            $this->addJoinObject($join, 'AmazonOrdersVersion');
        }

        return $this;
    }

    /**
     * Use the AmazonOrdersVersion relation AmazonOrdersVersion object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \AmazonIntegration\Model\AmazonOrdersVersionQuery A secondary query class using the current class as primary query
     */
    public function useAmazonOrdersVersionQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinAmazonOrdersVersion($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'AmazonOrdersVersion', '\AmazonIntegration\Model\AmazonOrdersVersionQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildAmazonOrders $amazonOrders Object to remove from the list of results
     *
     * @return ChildAmazonOrdersQuery The current query, for fluid interface
     */
    public function prune($amazonOrders = null)
    {
        if ($amazonOrders) {
            $this->addUsingAlias(AmazonOrdersTableMap::ID, $amazonOrders->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the amazon_orders table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(AmazonOrdersTableMap::DATABASE_NAME);
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
            AmazonOrdersTableMap::clearInstancePool();
            AmazonOrdersTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildAmazonOrders or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildAmazonOrders object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(AmazonOrdersTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(AmazonOrdersTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            

        AmazonOrdersTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            AmazonOrdersTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

    // timestampable behavior
    
    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     ChildAmazonOrdersQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(AmazonOrdersTableMap::UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }
    
    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     ChildAmazonOrdersQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(AmazonOrdersTableMap::CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }
    
    /**
     * Order by update date desc
     *
     * @return     ChildAmazonOrdersQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(AmazonOrdersTableMap::UPDATED_AT);
    }
    
    /**
     * Order by update date asc
     *
     * @return     ChildAmazonOrdersQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(AmazonOrdersTableMap::UPDATED_AT);
    }
    
    /**
     * Order by create date desc
     *
     * @return     ChildAmazonOrdersQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(AmazonOrdersTableMap::CREATED_AT);
    }
    
    /**
     * Order by create date asc
     *
     * @return     ChildAmazonOrdersQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(AmazonOrdersTableMap::CREATED_AT);
    }

    // versionable behavior
    
    /**
     * Checks whether versioning is enabled
     *
     * @return boolean
     */
    static public function isVersioningEnabled()
    {
        return self::$isVersioningEnabled;
    }
    
    /**
     * Enables versioning
     */
    static public function enableVersioning()
    {
        self::$isVersioningEnabled = true;
    }
    
    /**
     * Disables versioning
     */
    static public function disableVersioning()
    {
        self::$isVersioningEnabled = false;
    }

} // AmazonOrdersQuery
