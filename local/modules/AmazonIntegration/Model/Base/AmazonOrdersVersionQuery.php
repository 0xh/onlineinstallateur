<?php

namespace AmazonIntegration\Model\Base;

use \Exception;
use \PDO;
use AmazonIntegration\Model\AmazonOrdersVersion as ChildAmazonOrdersVersion;
use AmazonIntegration\Model\AmazonOrdersVersionQuery as ChildAmazonOrdersVersionQuery;
use AmazonIntegration\Model\Map\AmazonOrdersVersionTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'amazon_orders_version' table.
 *
 * 
 *
 * @method     ChildAmazonOrdersVersionQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildAmazonOrdersVersionQuery orderBySellerOrderId($order = Criteria::ASC) Order by the seller_order_id column
 * @method     ChildAmazonOrdersVersionQuery orderByPurchaseDate($order = Criteria::ASC) Order by the purchase_date column
 * @method     ChildAmazonOrdersVersionQuery orderByLastUpdateDate($order = Criteria::ASC) Order by the last_update_date column
 * @method     ChildAmazonOrdersVersionQuery orderByOrderStatus($order = Criteria::ASC) Order by the order_status column
 * @method     ChildAmazonOrdersVersionQuery orderByFulfillmentChannel($order = Criteria::ASC) Order by the fulfillment_channel column
 * @method     ChildAmazonOrdersVersionQuery orderBySalesChannel($order = Criteria::ASC) Order by the sales_channel column
 * @method     ChildAmazonOrdersVersionQuery orderByOrderChannel($order = Criteria::ASC) Order by the order_channel column
 * @method     ChildAmazonOrdersVersionQuery orderByShipServiceLevel($order = Criteria::ASC) Order by the ship_service_level column
 * @method     ChildAmazonOrdersVersionQuery orderByOrderTotalCurrencyCode($order = Criteria::ASC) Order by the order_total_currency_code column
 * @method     ChildAmazonOrdersVersionQuery orderByOrderTotalAmount($order = Criteria::ASC) Order by the order_total_amount column
 * @method     ChildAmazonOrdersVersionQuery orderByNumberOfItemsShipped($order = Criteria::ASC) Order by the number_of_items_shipped column
 * @method     ChildAmazonOrdersVersionQuery orderByNumberOfItemsUnshipped($order = Criteria::ASC) Order by the number_of_items_unshipped column
 * @method     ChildAmazonOrdersVersionQuery orderByPaymentExecutionDetailCurrencyCode($order = Criteria::ASC) Order by the payment_execution_detail_currency_code column
 * @method     ChildAmazonOrdersVersionQuery orderByPaymentExecutionDetailTotalAmount($order = Criteria::ASC) Order by the payment_execution_detail_total_amount column
 * @method     ChildAmazonOrdersVersionQuery orderByPaymentExecutionDetailPaymentMethod($order = Criteria::ASC) Order by the payment_execution_detail_payment_method column
 * @method     ChildAmazonOrdersVersionQuery orderByPaymentMethod($order = Criteria::ASC) Order by the payment_method column
 * @method     ChildAmazonOrdersVersionQuery orderByPaymentMethodDetail($order = Criteria::ASC) Order by the payment_method_detail column
 * @method     ChildAmazonOrdersVersionQuery orderByMarketplaceId($order = Criteria::ASC) Order by the marketplace_id column
 * @method     ChildAmazonOrdersVersionQuery orderByBuyerCounty($order = Criteria::ASC) Order by the buyer_county column
 * @method     ChildAmazonOrdersVersionQuery orderByBuyerTaxInfoCompany($order = Criteria::ASC) Order by the buyer_tax_info_company column
 * @method     ChildAmazonOrdersVersionQuery orderByBuyerTaxInfoTaxingRegion($order = Criteria::ASC) Order by the buyer_tax_info_taxing_region column
 * @method     ChildAmazonOrdersVersionQuery orderByBuyerTaxInfoTaxName($order = Criteria::ASC) Order by the buyer_tax_info_tax_name column
 * @method     ChildAmazonOrdersVersionQuery orderByBuyerTaxInfoTaxValue($order = Criteria::ASC) Order by the buyer_tax_info_tax_value column
 * @method     ChildAmazonOrdersVersionQuery orderByShipmentServiceLevelCategory($order = Criteria::ASC) Order by the shipment_service_level_category column
 * @method     ChildAmazonOrdersVersionQuery orderByShippedByAmazonTfm($order = Criteria::ASC) Order by the shipped_by_amazon_tfm column
 * @method     ChildAmazonOrdersVersionQuery orderByTfmShipmentStatus($order = Criteria::ASC) Order by the tfm_shipment_status column
 * @method     ChildAmazonOrdersVersionQuery orderByCbaDisplayableShippingLabel($order = Criteria::ASC) Order by the cba_displayable_shipping_label column
 * @method     ChildAmazonOrdersVersionQuery orderByOrderType($order = Criteria::ASC) Order by the order_type column
 * @method     ChildAmazonOrdersVersionQuery orderByEarliestShipDate($order = Criteria::ASC) Order by the earliest_ship_date column
 * @method     ChildAmazonOrdersVersionQuery orderByLatestShipDate($order = Criteria::ASC) Order by the latest_ship_date column
 * @method     ChildAmazonOrdersVersionQuery orderByEarliestDeliveryDate($order = Criteria::ASC) Order by the earliest_delivery_date column
 * @method     ChildAmazonOrdersVersionQuery orderByLatestDeliveryDate($order = Criteria::ASC) Order by the latest_delivery_date column
 * @method     ChildAmazonOrdersVersionQuery orderByIsBusinessOrder($order = Criteria::ASC) Order by the is_business_order column
 * @method     ChildAmazonOrdersVersionQuery orderByPurchaseOrderNumber($order = Criteria::ASC) Order by the purchase_order_number column
 * @method     ChildAmazonOrdersVersionQuery orderByIsPrime($order = Criteria::ASC) Order by the is_prime column
 * @method     ChildAmazonOrdersVersionQuery orderByIsPremiumOrder($order = Criteria::ASC) Order by the is_premium_order column
 * @method     ChildAmazonOrdersVersionQuery orderByReplacedOrderId($order = Criteria::ASC) Order by the replaced_order_id column
 * @method     ChildAmazonOrdersVersionQuery orderByIsReplacementOrder($order = Criteria::ASC) Order by the is_replacement_order column
 * @method     ChildAmazonOrdersVersionQuery orderByOrderAddressId($order = Criteria::ASC) Order by the order_address_id column
 * @method     ChildAmazonOrdersVersionQuery orderByCustomerId($order = Criteria::ASC) Order by the customer_id column
 * @method     ChildAmazonOrdersVersionQuery orderByOrderId($order = Criteria::ASC) Order by the order_id column
 * @method     ChildAmazonOrdersVersionQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildAmazonOrdersVersionQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 * @method     ChildAmazonOrdersVersionQuery orderByVersion($order = Criteria::ASC) Order by the version column
 * @method     ChildAmazonOrdersVersionQuery orderByVersionCreatedAt($order = Criteria::ASC) Order by the version_created_at column
 * @method     ChildAmazonOrdersVersionQuery orderByVersionCreatedBy($order = Criteria::ASC) Order by the version_created_by column
 * @method     ChildAmazonOrdersVersionQuery orderByCustomerIdVersion($order = Criteria::ASC) Order by the customer_id_version column
 * @method     ChildAmazonOrdersVersionQuery orderByOrderIdVersion($order = Criteria::ASC) Order by the order_id_version column
 * @method     ChildAmazonOrdersVersionQuery orderByAmazonOrderProductIds($order = Criteria::ASC) Order by the amazon_order_product_ids column
 * @method     ChildAmazonOrdersVersionQuery orderByAmazonOrderProductVersions($order = Criteria::ASC) Order by the amazon_order_product_versions column
 *
 * @method     ChildAmazonOrdersVersionQuery groupById() Group by the id column
 * @method     ChildAmazonOrdersVersionQuery groupBySellerOrderId() Group by the seller_order_id column
 * @method     ChildAmazonOrdersVersionQuery groupByPurchaseDate() Group by the purchase_date column
 * @method     ChildAmazonOrdersVersionQuery groupByLastUpdateDate() Group by the last_update_date column
 * @method     ChildAmazonOrdersVersionQuery groupByOrderStatus() Group by the order_status column
 * @method     ChildAmazonOrdersVersionQuery groupByFulfillmentChannel() Group by the fulfillment_channel column
 * @method     ChildAmazonOrdersVersionQuery groupBySalesChannel() Group by the sales_channel column
 * @method     ChildAmazonOrdersVersionQuery groupByOrderChannel() Group by the order_channel column
 * @method     ChildAmazonOrdersVersionQuery groupByShipServiceLevel() Group by the ship_service_level column
 * @method     ChildAmazonOrdersVersionQuery groupByOrderTotalCurrencyCode() Group by the order_total_currency_code column
 * @method     ChildAmazonOrdersVersionQuery groupByOrderTotalAmount() Group by the order_total_amount column
 * @method     ChildAmazonOrdersVersionQuery groupByNumberOfItemsShipped() Group by the number_of_items_shipped column
 * @method     ChildAmazonOrdersVersionQuery groupByNumberOfItemsUnshipped() Group by the number_of_items_unshipped column
 * @method     ChildAmazonOrdersVersionQuery groupByPaymentExecutionDetailCurrencyCode() Group by the payment_execution_detail_currency_code column
 * @method     ChildAmazonOrdersVersionQuery groupByPaymentExecutionDetailTotalAmount() Group by the payment_execution_detail_total_amount column
 * @method     ChildAmazonOrdersVersionQuery groupByPaymentExecutionDetailPaymentMethod() Group by the payment_execution_detail_payment_method column
 * @method     ChildAmazonOrdersVersionQuery groupByPaymentMethod() Group by the payment_method column
 * @method     ChildAmazonOrdersVersionQuery groupByPaymentMethodDetail() Group by the payment_method_detail column
 * @method     ChildAmazonOrdersVersionQuery groupByMarketplaceId() Group by the marketplace_id column
 * @method     ChildAmazonOrdersVersionQuery groupByBuyerCounty() Group by the buyer_county column
 * @method     ChildAmazonOrdersVersionQuery groupByBuyerTaxInfoCompany() Group by the buyer_tax_info_company column
 * @method     ChildAmazonOrdersVersionQuery groupByBuyerTaxInfoTaxingRegion() Group by the buyer_tax_info_taxing_region column
 * @method     ChildAmazonOrdersVersionQuery groupByBuyerTaxInfoTaxName() Group by the buyer_tax_info_tax_name column
 * @method     ChildAmazonOrdersVersionQuery groupByBuyerTaxInfoTaxValue() Group by the buyer_tax_info_tax_value column
 * @method     ChildAmazonOrdersVersionQuery groupByShipmentServiceLevelCategory() Group by the shipment_service_level_category column
 * @method     ChildAmazonOrdersVersionQuery groupByShippedByAmazonTfm() Group by the shipped_by_amazon_tfm column
 * @method     ChildAmazonOrdersVersionQuery groupByTfmShipmentStatus() Group by the tfm_shipment_status column
 * @method     ChildAmazonOrdersVersionQuery groupByCbaDisplayableShippingLabel() Group by the cba_displayable_shipping_label column
 * @method     ChildAmazonOrdersVersionQuery groupByOrderType() Group by the order_type column
 * @method     ChildAmazonOrdersVersionQuery groupByEarliestShipDate() Group by the earliest_ship_date column
 * @method     ChildAmazonOrdersVersionQuery groupByLatestShipDate() Group by the latest_ship_date column
 * @method     ChildAmazonOrdersVersionQuery groupByEarliestDeliveryDate() Group by the earliest_delivery_date column
 * @method     ChildAmazonOrdersVersionQuery groupByLatestDeliveryDate() Group by the latest_delivery_date column
 * @method     ChildAmazonOrdersVersionQuery groupByIsBusinessOrder() Group by the is_business_order column
 * @method     ChildAmazonOrdersVersionQuery groupByPurchaseOrderNumber() Group by the purchase_order_number column
 * @method     ChildAmazonOrdersVersionQuery groupByIsPrime() Group by the is_prime column
 * @method     ChildAmazonOrdersVersionQuery groupByIsPremiumOrder() Group by the is_premium_order column
 * @method     ChildAmazonOrdersVersionQuery groupByReplacedOrderId() Group by the replaced_order_id column
 * @method     ChildAmazonOrdersVersionQuery groupByIsReplacementOrder() Group by the is_replacement_order column
 * @method     ChildAmazonOrdersVersionQuery groupByOrderAddressId() Group by the order_address_id column
 * @method     ChildAmazonOrdersVersionQuery groupByCustomerId() Group by the customer_id column
 * @method     ChildAmazonOrdersVersionQuery groupByOrderId() Group by the order_id column
 * @method     ChildAmazonOrdersVersionQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildAmazonOrdersVersionQuery groupByUpdatedAt() Group by the updated_at column
 * @method     ChildAmazonOrdersVersionQuery groupByVersion() Group by the version column
 * @method     ChildAmazonOrdersVersionQuery groupByVersionCreatedAt() Group by the version_created_at column
 * @method     ChildAmazonOrdersVersionQuery groupByVersionCreatedBy() Group by the version_created_by column
 * @method     ChildAmazonOrdersVersionQuery groupByCustomerIdVersion() Group by the customer_id_version column
 * @method     ChildAmazonOrdersVersionQuery groupByOrderIdVersion() Group by the order_id_version column
 * @method     ChildAmazonOrdersVersionQuery groupByAmazonOrderProductIds() Group by the amazon_order_product_ids column
 * @method     ChildAmazonOrdersVersionQuery groupByAmazonOrderProductVersions() Group by the amazon_order_product_versions column
 *
 * @method     ChildAmazonOrdersVersionQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildAmazonOrdersVersionQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildAmazonOrdersVersionQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildAmazonOrdersVersionQuery leftJoinAmazonOrders($relationAlias = null) Adds a LEFT JOIN clause to the query using the AmazonOrders relation
 * @method     ChildAmazonOrdersVersionQuery rightJoinAmazonOrders($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AmazonOrders relation
 * @method     ChildAmazonOrdersVersionQuery innerJoinAmazonOrders($relationAlias = null) Adds a INNER JOIN clause to the query using the AmazonOrders relation
 *
 * @method     ChildAmazonOrdersVersion findOne(ConnectionInterface $con = null) Return the first ChildAmazonOrdersVersion matching the query
 * @method     ChildAmazonOrdersVersion findOneOrCreate(ConnectionInterface $con = null) Return the first ChildAmazonOrdersVersion matching the query, or a new ChildAmazonOrdersVersion object populated from the query conditions when no match is found
 *
 * @method     ChildAmazonOrdersVersion findOneById(string $id) Return the first ChildAmazonOrdersVersion filtered by the id column
 * @method     ChildAmazonOrdersVersion findOneBySellerOrderId(string $seller_order_id) Return the first ChildAmazonOrdersVersion filtered by the seller_order_id column
 * @method     ChildAmazonOrdersVersion findOneByPurchaseDate(string $purchase_date) Return the first ChildAmazonOrdersVersion filtered by the purchase_date column
 * @method     ChildAmazonOrdersVersion findOneByLastUpdateDate(string $last_update_date) Return the first ChildAmazonOrdersVersion filtered by the last_update_date column
 * @method     ChildAmazonOrdersVersion findOneByOrderStatus(string $order_status) Return the first ChildAmazonOrdersVersion filtered by the order_status column
 * @method     ChildAmazonOrdersVersion findOneByFulfillmentChannel(string $fulfillment_channel) Return the first ChildAmazonOrdersVersion filtered by the fulfillment_channel column
 * @method     ChildAmazonOrdersVersion findOneBySalesChannel(string $sales_channel) Return the first ChildAmazonOrdersVersion filtered by the sales_channel column
 * @method     ChildAmazonOrdersVersion findOneByOrderChannel(string $order_channel) Return the first ChildAmazonOrdersVersion filtered by the order_channel column
 * @method     ChildAmazonOrdersVersion findOneByShipServiceLevel(string $ship_service_level) Return the first ChildAmazonOrdersVersion filtered by the ship_service_level column
 * @method     ChildAmazonOrdersVersion findOneByOrderTotalCurrencyCode(string $order_total_currency_code) Return the first ChildAmazonOrdersVersion filtered by the order_total_currency_code column
 * @method     ChildAmazonOrdersVersion findOneByOrderTotalAmount(string $order_total_amount) Return the first ChildAmazonOrdersVersion filtered by the order_total_amount column
 * @method     ChildAmazonOrdersVersion findOneByNumberOfItemsShipped(double $number_of_items_shipped) Return the first ChildAmazonOrdersVersion filtered by the number_of_items_shipped column
 * @method     ChildAmazonOrdersVersion findOneByNumberOfItemsUnshipped(double $number_of_items_unshipped) Return the first ChildAmazonOrdersVersion filtered by the number_of_items_unshipped column
 * @method     ChildAmazonOrdersVersion findOneByPaymentExecutionDetailCurrencyCode(string $payment_execution_detail_currency_code) Return the first ChildAmazonOrdersVersion filtered by the payment_execution_detail_currency_code column
 * @method     ChildAmazonOrdersVersion findOneByPaymentExecutionDetailTotalAmount(string $payment_execution_detail_total_amount) Return the first ChildAmazonOrdersVersion filtered by the payment_execution_detail_total_amount column
 * @method     ChildAmazonOrdersVersion findOneByPaymentExecutionDetailPaymentMethod(string $payment_execution_detail_payment_method) Return the first ChildAmazonOrdersVersion filtered by the payment_execution_detail_payment_method column
 * @method     ChildAmazonOrdersVersion findOneByPaymentMethod(string $payment_method) Return the first ChildAmazonOrdersVersion filtered by the payment_method column
 * @method     ChildAmazonOrdersVersion findOneByPaymentMethodDetail(string $payment_method_detail) Return the first ChildAmazonOrdersVersion filtered by the payment_method_detail column
 * @method     ChildAmazonOrdersVersion findOneByMarketplaceId(string $marketplace_id) Return the first ChildAmazonOrdersVersion filtered by the marketplace_id column
 * @method     ChildAmazonOrdersVersion findOneByBuyerCounty(string $buyer_county) Return the first ChildAmazonOrdersVersion filtered by the buyer_county column
 * @method     ChildAmazonOrdersVersion findOneByBuyerTaxInfoCompany(string $buyer_tax_info_company) Return the first ChildAmazonOrdersVersion filtered by the buyer_tax_info_company column
 * @method     ChildAmazonOrdersVersion findOneByBuyerTaxInfoTaxingRegion(string $buyer_tax_info_taxing_region) Return the first ChildAmazonOrdersVersion filtered by the buyer_tax_info_taxing_region column
 * @method     ChildAmazonOrdersVersion findOneByBuyerTaxInfoTaxName(string $buyer_tax_info_tax_name) Return the first ChildAmazonOrdersVersion filtered by the buyer_tax_info_tax_name column
 * @method     ChildAmazonOrdersVersion findOneByBuyerTaxInfoTaxValue(string $buyer_tax_info_tax_value) Return the first ChildAmazonOrdersVersion filtered by the buyer_tax_info_tax_value column
 * @method     ChildAmazonOrdersVersion findOneByShipmentServiceLevelCategory(string $shipment_service_level_category) Return the first ChildAmazonOrdersVersion filtered by the shipment_service_level_category column
 * @method     ChildAmazonOrdersVersion findOneByShippedByAmazonTfm(int $shipped_by_amazon_tfm) Return the first ChildAmazonOrdersVersion filtered by the shipped_by_amazon_tfm column
 * @method     ChildAmazonOrdersVersion findOneByTfmShipmentStatus(string $tfm_shipment_status) Return the first ChildAmazonOrdersVersion filtered by the tfm_shipment_status column
 * @method     ChildAmazonOrdersVersion findOneByCbaDisplayableShippingLabel(string $cba_displayable_shipping_label) Return the first ChildAmazonOrdersVersion filtered by the cba_displayable_shipping_label column
 * @method     ChildAmazonOrdersVersion findOneByOrderType(string $order_type) Return the first ChildAmazonOrdersVersion filtered by the order_type column
 * @method     ChildAmazonOrdersVersion findOneByEarliestShipDate(string $earliest_ship_date) Return the first ChildAmazonOrdersVersion filtered by the earliest_ship_date column
 * @method     ChildAmazonOrdersVersion findOneByLatestShipDate(string $latest_ship_date) Return the first ChildAmazonOrdersVersion filtered by the latest_ship_date column
 * @method     ChildAmazonOrdersVersion findOneByEarliestDeliveryDate(string $earliest_delivery_date) Return the first ChildAmazonOrdersVersion filtered by the earliest_delivery_date column
 * @method     ChildAmazonOrdersVersion findOneByLatestDeliveryDate(string $latest_delivery_date) Return the first ChildAmazonOrdersVersion filtered by the latest_delivery_date column
 * @method     ChildAmazonOrdersVersion findOneByIsBusinessOrder(int $is_business_order) Return the first ChildAmazonOrdersVersion filtered by the is_business_order column
 * @method     ChildAmazonOrdersVersion findOneByPurchaseOrderNumber(string $purchase_order_number) Return the first ChildAmazonOrdersVersion filtered by the purchase_order_number column
 * @method     ChildAmazonOrdersVersion findOneByIsPrime(int $is_prime) Return the first ChildAmazonOrdersVersion filtered by the is_prime column
 * @method     ChildAmazonOrdersVersion findOneByIsPremiumOrder(int $is_premium_order) Return the first ChildAmazonOrdersVersion filtered by the is_premium_order column
 * @method     ChildAmazonOrdersVersion findOneByReplacedOrderId(string $replaced_order_id) Return the first ChildAmazonOrdersVersion filtered by the replaced_order_id column
 * @method     ChildAmazonOrdersVersion findOneByIsReplacementOrder(int $is_replacement_order) Return the first ChildAmazonOrdersVersion filtered by the is_replacement_order column
 * @method     ChildAmazonOrdersVersion findOneByOrderAddressId(int $order_address_id) Return the first ChildAmazonOrdersVersion filtered by the order_address_id column
 * @method     ChildAmazonOrdersVersion findOneByCustomerId(int $customer_id) Return the first ChildAmazonOrdersVersion filtered by the customer_id column
 * @method     ChildAmazonOrdersVersion findOneByOrderId(int $order_id) Return the first ChildAmazonOrdersVersion filtered by the order_id column
 * @method     ChildAmazonOrdersVersion findOneByCreatedAt(string $created_at) Return the first ChildAmazonOrdersVersion filtered by the created_at column
 * @method     ChildAmazonOrdersVersion findOneByUpdatedAt(string $updated_at) Return the first ChildAmazonOrdersVersion filtered by the updated_at column
 * @method     ChildAmazonOrdersVersion findOneByVersion(int $version) Return the first ChildAmazonOrdersVersion filtered by the version column
 * @method     ChildAmazonOrdersVersion findOneByVersionCreatedAt(string $version_created_at) Return the first ChildAmazonOrdersVersion filtered by the version_created_at column
 * @method     ChildAmazonOrdersVersion findOneByVersionCreatedBy(string $version_created_by) Return the first ChildAmazonOrdersVersion filtered by the version_created_by column
 * @method     ChildAmazonOrdersVersion findOneByCustomerIdVersion(int $customer_id_version) Return the first ChildAmazonOrdersVersion filtered by the customer_id_version column
 * @method     ChildAmazonOrdersVersion findOneByOrderIdVersion(int $order_id_version) Return the first ChildAmazonOrdersVersion filtered by the order_id_version column
 * @method     ChildAmazonOrdersVersion findOneByAmazonOrderProductIds(array $amazon_order_product_ids) Return the first ChildAmazonOrdersVersion filtered by the amazon_order_product_ids column
 * @method     ChildAmazonOrdersVersion findOneByAmazonOrderProductVersions(array $amazon_order_product_versions) Return the first ChildAmazonOrdersVersion filtered by the amazon_order_product_versions column
 *
 * @method     array findById(string $id) Return ChildAmazonOrdersVersion objects filtered by the id column
 * @method     array findBySellerOrderId(string $seller_order_id) Return ChildAmazonOrdersVersion objects filtered by the seller_order_id column
 * @method     array findByPurchaseDate(string $purchase_date) Return ChildAmazonOrdersVersion objects filtered by the purchase_date column
 * @method     array findByLastUpdateDate(string $last_update_date) Return ChildAmazonOrdersVersion objects filtered by the last_update_date column
 * @method     array findByOrderStatus(string $order_status) Return ChildAmazonOrdersVersion objects filtered by the order_status column
 * @method     array findByFulfillmentChannel(string $fulfillment_channel) Return ChildAmazonOrdersVersion objects filtered by the fulfillment_channel column
 * @method     array findBySalesChannel(string $sales_channel) Return ChildAmazonOrdersVersion objects filtered by the sales_channel column
 * @method     array findByOrderChannel(string $order_channel) Return ChildAmazonOrdersVersion objects filtered by the order_channel column
 * @method     array findByShipServiceLevel(string $ship_service_level) Return ChildAmazonOrdersVersion objects filtered by the ship_service_level column
 * @method     array findByOrderTotalCurrencyCode(string $order_total_currency_code) Return ChildAmazonOrdersVersion objects filtered by the order_total_currency_code column
 * @method     array findByOrderTotalAmount(string $order_total_amount) Return ChildAmazonOrdersVersion objects filtered by the order_total_amount column
 * @method     array findByNumberOfItemsShipped(double $number_of_items_shipped) Return ChildAmazonOrdersVersion objects filtered by the number_of_items_shipped column
 * @method     array findByNumberOfItemsUnshipped(double $number_of_items_unshipped) Return ChildAmazonOrdersVersion objects filtered by the number_of_items_unshipped column
 * @method     array findByPaymentExecutionDetailCurrencyCode(string $payment_execution_detail_currency_code) Return ChildAmazonOrdersVersion objects filtered by the payment_execution_detail_currency_code column
 * @method     array findByPaymentExecutionDetailTotalAmount(string $payment_execution_detail_total_amount) Return ChildAmazonOrdersVersion objects filtered by the payment_execution_detail_total_amount column
 * @method     array findByPaymentExecutionDetailPaymentMethod(string $payment_execution_detail_payment_method) Return ChildAmazonOrdersVersion objects filtered by the payment_execution_detail_payment_method column
 * @method     array findByPaymentMethod(string $payment_method) Return ChildAmazonOrdersVersion objects filtered by the payment_method column
 * @method     array findByPaymentMethodDetail(string $payment_method_detail) Return ChildAmazonOrdersVersion objects filtered by the payment_method_detail column
 * @method     array findByMarketplaceId(string $marketplace_id) Return ChildAmazonOrdersVersion objects filtered by the marketplace_id column
 * @method     array findByBuyerCounty(string $buyer_county) Return ChildAmazonOrdersVersion objects filtered by the buyer_county column
 * @method     array findByBuyerTaxInfoCompany(string $buyer_tax_info_company) Return ChildAmazonOrdersVersion objects filtered by the buyer_tax_info_company column
 * @method     array findByBuyerTaxInfoTaxingRegion(string $buyer_tax_info_taxing_region) Return ChildAmazonOrdersVersion objects filtered by the buyer_tax_info_taxing_region column
 * @method     array findByBuyerTaxInfoTaxName(string $buyer_tax_info_tax_name) Return ChildAmazonOrdersVersion objects filtered by the buyer_tax_info_tax_name column
 * @method     array findByBuyerTaxInfoTaxValue(string $buyer_tax_info_tax_value) Return ChildAmazonOrdersVersion objects filtered by the buyer_tax_info_tax_value column
 * @method     array findByShipmentServiceLevelCategory(string $shipment_service_level_category) Return ChildAmazonOrdersVersion objects filtered by the shipment_service_level_category column
 * @method     array findByShippedByAmazonTfm(int $shipped_by_amazon_tfm) Return ChildAmazonOrdersVersion objects filtered by the shipped_by_amazon_tfm column
 * @method     array findByTfmShipmentStatus(string $tfm_shipment_status) Return ChildAmazonOrdersVersion objects filtered by the tfm_shipment_status column
 * @method     array findByCbaDisplayableShippingLabel(string $cba_displayable_shipping_label) Return ChildAmazonOrdersVersion objects filtered by the cba_displayable_shipping_label column
 * @method     array findByOrderType(string $order_type) Return ChildAmazonOrdersVersion objects filtered by the order_type column
 * @method     array findByEarliestShipDate(string $earliest_ship_date) Return ChildAmazonOrdersVersion objects filtered by the earliest_ship_date column
 * @method     array findByLatestShipDate(string $latest_ship_date) Return ChildAmazonOrdersVersion objects filtered by the latest_ship_date column
 * @method     array findByEarliestDeliveryDate(string $earliest_delivery_date) Return ChildAmazonOrdersVersion objects filtered by the earliest_delivery_date column
 * @method     array findByLatestDeliveryDate(string $latest_delivery_date) Return ChildAmazonOrdersVersion objects filtered by the latest_delivery_date column
 * @method     array findByIsBusinessOrder(int $is_business_order) Return ChildAmazonOrdersVersion objects filtered by the is_business_order column
 * @method     array findByPurchaseOrderNumber(string $purchase_order_number) Return ChildAmazonOrdersVersion objects filtered by the purchase_order_number column
 * @method     array findByIsPrime(int $is_prime) Return ChildAmazonOrdersVersion objects filtered by the is_prime column
 * @method     array findByIsPremiumOrder(int $is_premium_order) Return ChildAmazonOrdersVersion objects filtered by the is_premium_order column
 * @method     array findByReplacedOrderId(string $replaced_order_id) Return ChildAmazonOrdersVersion objects filtered by the replaced_order_id column
 * @method     array findByIsReplacementOrder(int $is_replacement_order) Return ChildAmazonOrdersVersion objects filtered by the is_replacement_order column
 * @method     array findByOrderAddressId(int $order_address_id) Return ChildAmazonOrdersVersion objects filtered by the order_address_id column
 * @method     array findByCustomerId(int $customer_id) Return ChildAmazonOrdersVersion objects filtered by the customer_id column
 * @method     array findByOrderId(int $order_id) Return ChildAmazonOrdersVersion objects filtered by the order_id column
 * @method     array findByCreatedAt(string $created_at) Return ChildAmazonOrdersVersion objects filtered by the created_at column
 * @method     array findByUpdatedAt(string $updated_at) Return ChildAmazonOrdersVersion objects filtered by the updated_at column
 * @method     array findByVersion(int $version) Return ChildAmazonOrdersVersion objects filtered by the version column
 * @method     array findByVersionCreatedAt(string $version_created_at) Return ChildAmazonOrdersVersion objects filtered by the version_created_at column
 * @method     array findByVersionCreatedBy(string $version_created_by) Return ChildAmazonOrdersVersion objects filtered by the version_created_by column
 * @method     array findByCustomerIdVersion(int $customer_id_version) Return ChildAmazonOrdersVersion objects filtered by the customer_id_version column
 * @method     array findByOrderIdVersion(int $order_id_version) Return ChildAmazonOrdersVersion objects filtered by the order_id_version column
 * @method     array findByAmazonOrderProductIds(array $amazon_order_product_ids) Return ChildAmazonOrdersVersion objects filtered by the amazon_order_product_ids column
 * @method     array findByAmazonOrderProductVersions(array $amazon_order_product_versions) Return ChildAmazonOrdersVersion objects filtered by the amazon_order_product_versions column
 *
 */
abstract class AmazonOrdersVersionQuery extends ModelCriteria
{
    
    /**
     * Initializes internal state of \AmazonIntegration\Model\Base\AmazonOrdersVersionQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'thelia', $modelName = '\\AmazonIntegration\\Model\\AmazonOrdersVersion', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildAmazonOrdersVersionQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildAmazonOrdersVersionQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \AmazonIntegration\Model\AmazonOrdersVersionQuery) {
            return $criteria;
        }
        $query = new \AmazonIntegration\Model\AmazonOrdersVersionQuery();
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
     * $obj = $c->findPk(array(12, 34), $con);
     * </code>
     *
     * @param array[$id, $version] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildAmazonOrdersVersion|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = AmazonOrdersVersionTableMap::getInstanceFromPool(serialize(array((string) $key[0], (string) $key[1]))))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(AmazonOrdersVersionTableMap::DATABASE_NAME);
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
     * @return   ChildAmazonOrdersVersion A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ID, SELLER_ORDER_ID, PURCHASE_DATE, LAST_UPDATE_DATE, ORDER_STATUS, FULFILLMENT_CHANNEL, SALES_CHANNEL, ORDER_CHANNEL, SHIP_SERVICE_LEVEL, ORDER_TOTAL_CURRENCY_CODE, ORDER_TOTAL_AMOUNT, NUMBER_OF_ITEMS_SHIPPED, NUMBER_OF_ITEMS_UNSHIPPED, PAYMENT_EXECUTION_DETAIL_CURRENCY_CODE, PAYMENT_EXECUTION_DETAIL_TOTAL_AMOUNT, PAYMENT_EXECUTION_DETAIL_PAYMENT_METHOD, PAYMENT_METHOD, PAYMENT_METHOD_DETAIL, MARKETPLACE_ID, BUYER_COUNTY, BUYER_TAX_INFO_COMPANY, BUYER_TAX_INFO_TAXING_REGION, BUYER_TAX_INFO_TAX_NAME, BUYER_TAX_INFO_TAX_VALUE, SHIPMENT_SERVICE_LEVEL_CATEGORY, SHIPPED_BY_AMAZON_TFM, TFM_SHIPMENT_STATUS, CBA_DISPLAYABLE_SHIPPING_LABEL, ORDER_TYPE, EARLIEST_SHIP_DATE, LATEST_SHIP_DATE, EARLIEST_DELIVERY_DATE, LATEST_DELIVERY_DATE, IS_BUSINESS_ORDER, PURCHASE_ORDER_NUMBER, IS_PRIME, IS_PREMIUM_ORDER, REPLACED_ORDER_ID, IS_REPLACEMENT_ORDER, ORDER_ADDRESS_ID, CUSTOMER_ID, ORDER_ID, CREATED_AT, UPDATED_AT, VERSION, VERSION_CREATED_AT, VERSION_CREATED_BY, CUSTOMER_ID_VERSION, ORDER_ID_VERSION, AMAZON_ORDER_PRODUCT_IDS, AMAZON_ORDER_PRODUCT_VERSIONS FROM amazon_orders_version WHERE ID = :p0 AND VERSION = :p1';
        try {
            $stmt = $con->prepare($sql);            
            $stmt->bindValue(':p0', $key[0], PDO::PARAM_STR);            
            $stmt->bindValue(':p1', $key[1], PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            $obj = new ChildAmazonOrdersVersion();
            $obj->hydrate($row);
            AmazonOrdersVersionTableMap::addInstanceToPool($obj, serialize(array((string) $key[0], (string) $key[1])));
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
     * @return ChildAmazonOrdersVersion|array|mixed the result, formatted by the current formatter
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
     * $objs = $c->findPks(array(array(12, 56), array(832, 123), array(123, 456)), $con);
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
     * @return ChildAmazonOrdersVersionQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(AmazonOrdersVersionTableMap::ID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(AmazonOrdersVersionTableMap::VERSION, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildAmazonOrdersVersionQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(AmazonOrdersVersionTableMap::ID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(AmazonOrdersVersionTableMap::VERSION, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $this->addOr($cton0);
        }

        return $this;
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
     * @return ChildAmazonOrdersVersionQuery The current query, for fluid interface
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

        return $this->addUsingAlias(AmazonOrdersVersionTableMap::ID, $id, $comparison);
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
     * @return ChildAmazonOrdersVersionQuery The current query, for fluid interface
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

        return $this->addUsingAlias(AmazonOrdersVersionTableMap::SELLER_ORDER_ID, $sellerOrderId, $comparison);
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
     * @return ChildAmazonOrdersVersionQuery The current query, for fluid interface
     */
    public function filterByPurchaseDate($purchaseDate = null, $comparison = null)
    {
        if (is_array($purchaseDate)) {
            $useMinMax = false;
            if (isset($purchaseDate['min'])) {
                $this->addUsingAlias(AmazonOrdersVersionTableMap::PURCHASE_DATE, $purchaseDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($purchaseDate['max'])) {
                $this->addUsingAlias(AmazonOrdersVersionTableMap::PURCHASE_DATE, $purchaseDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AmazonOrdersVersionTableMap::PURCHASE_DATE, $purchaseDate, $comparison);
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
     * @return ChildAmazonOrdersVersionQuery The current query, for fluid interface
     */
    public function filterByLastUpdateDate($lastUpdateDate = null, $comparison = null)
    {
        if (is_array($lastUpdateDate)) {
            $useMinMax = false;
            if (isset($lastUpdateDate['min'])) {
                $this->addUsingAlias(AmazonOrdersVersionTableMap::LAST_UPDATE_DATE, $lastUpdateDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($lastUpdateDate['max'])) {
                $this->addUsingAlias(AmazonOrdersVersionTableMap::LAST_UPDATE_DATE, $lastUpdateDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AmazonOrdersVersionTableMap::LAST_UPDATE_DATE, $lastUpdateDate, $comparison);
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
     * @return ChildAmazonOrdersVersionQuery The current query, for fluid interface
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

        return $this->addUsingAlias(AmazonOrdersVersionTableMap::ORDER_STATUS, $orderStatus, $comparison);
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
     * @return ChildAmazonOrdersVersionQuery The current query, for fluid interface
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

        return $this->addUsingAlias(AmazonOrdersVersionTableMap::FULFILLMENT_CHANNEL, $fulfillmentChannel, $comparison);
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
     * @return ChildAmazonOrdersVersionQuery The current query, for fluid interface
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

        return $this->addUsingAlias(AmazonOrdersVersionTableMap::SALES_CHANNEL, $salesChannel, $comparison);
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
     * @return ChildAmazonOrdersVersionQuery The current query, for fluid interface
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

        return $this->addUsingAlias(AmazonOrdersVersionTableMap::ORDER_CHANNEL, $orderChannel, $comparison);
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
     * @return ChildAmazonOrdersVersionQuery The current query, for fluid interface
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

        return $this->addUsingAlias(AmazonOrdersVersionTableMap::SHIP_SERVICE_LEVEL, $shipServiceLevel, $comparison);
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
     * @return ChildAmazonOrdersVersionQuery The current query, for fluid interface
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

        return $this->addUsingAlias(AmazonOrdersVersionTableMap::ORDER_TOTAL_CURRENCY_CODE, $orderTotalCurrencyCode, $comparison);
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
     * @return ChildAmazonOrdersVersionQuery The current query, for fluid interface
     */
    public function filterByOrderTotalAmount($orderTotalAmount = null, $comparison = null)
    {
        if (is_array($orderTotalAmount)) {
            $useMinMax = false;
            if (isset($orderTotalAmount['min'])) {
                $this->addUsingAlias(AmazonOrdersVersionTableMap::ORDER_TOTAL_AMOUNT, $orderTotalAmount['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($orderTotalAmount['max'])) {
                $this->addUsingAlias(AmazonOrdersVersionTableMap::ORDER_TOTAL_AMOUNT, $orderTotalAmount['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AmazonOrdersVersionTableMap::ORDER_TOTAL_AMOUNT, $orderTotalAmount, $comparison);
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
     * @return ChildAmazonOrdersVersionQuery The current query, for fluid interface
     */
    public function filterByNumberOfItemsShipped($numberOfItemsShipped = null, $comparison = null)
    {
        if (is_array($numberOfItemsShipped)) {
            $useMinMax = false;
            if (isset($numberOfItemsShipped['min'])) {
                $this->addUsingAlias(AmazonOrdersVersionTableMap::NUMBER_OF_ITEMS_SHIPPED, $numberOfItemsShipped['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($numberOfItemsShipped['max'])) {
                $this->addUsingAlias(AmazonOrdersVersionTableMap::NUMBER_OF_ITEMS_SHIPPED, $numberOfItemsShipped['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AmazonOrdersVersionTableMap::NUMBER_OF_ITEMS_SHIPPED, $numberOfItemsShipped, $comparison);
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
     * @return ChildAmazonOrdersVersionQuery The current query, for fluid interface
     */
    public function filterByNumberOfItemsUnshipped($numberOfItemsUnshipped = null, $comparison = null)
    {
        if (is_array($numberOfItemsUnshipped)) {
            $useMinMax = false;
            if (isset($numberOfItemsUnshipped['min'])) {
                $this->addUsingAlias(AmazonOrdersVersionTableMap::NUMBER_OF_ITEMS_UNSHIPPED, $numberOfItemsUnshipped['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($numberOfItemsUnshipped['max'])) {
                $this->addUsingAlias(AmazonOrdersVersionTableMap::NUMBER_OF_ITEMS_UNSHIPPED, $numberOfItemsUnshipped['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AmazonOrdersVersionTableMap::NUMBER_OF_ITEMS_UNSHIPPED, $numberOfItemsUnshipped, $comparison);
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
     * @return ChildAmazonOrdersVersionQuery The current query, for fluid interface
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

        return $this->addUsingAlias(AmazonOrdersVersionTableMap::PAYMENT_EXECUTION_DETAIL_CURRENCY_CODE, $paymentExecutionDetailCurrencyCode, $comparison);
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
     * @return ChildAmazonOrdersVersionQuery The current query, for fluid interface
     */
    public function filterByPaymentExecutionDetailTotalAmount($paymentExecutionDetailTotalAmount = null, $comparison = null)
    {
        if (is_array($paymentExecutionDetailTotalAmount)) {
            $useMinMax = false;
            if (isset($paymentExecutionDetailTotalAmount['min'])) {
                $this->addUsingAlias(AmazonOrdersVersionTableMap::PAYMENT_EXECUTION_DETAIL_TOTAL_AMOUNT, $paymentExecutionDetailTotalAmount['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($paymentExecutionDetailTotalAmount['max'])) {
                $this->addUsingAlias(AmazonOrdersVersionTableMap::PAYMENT_EXECUTION_DETAIL_TOTAL_AMOUNT, $paymentExecutionDetailTotalAmount['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AmazonOrdersVersionTableMap::PAYMENT_EXECUTION_DETAIL_TOTAL_AMOUNT, $paymentExecutionDetailTotalAmount, $comparison);
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
     * @return ChildAmazonOrdersVersionQuery The current query, for fluid interface
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

        return $this->addUsingAlias(AmazonOrdersVersionTableMap::PAYMENT_EXECUTION_DETAIL_PAYMENT_METHOD, $paymentExecutionDetailPaymentMethod, $comparison);
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
     * @return ChildAmazonOrdersVersionQuery The current query, for fluid interface
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

        return $this->addUsingAlias(AmazonOrdersVersionTableMap::PAYMENT_METHOD, $paymentMethod, $comparison);
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
     * @return ChildAmazonOrdersVersionQuery The current query, for fluid interface
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

        return $this->addUsingAlias(AmazonOrdersVersionTableMap::PAYMENT_METHOD_DETAIL, $paymentMethodDetail, $comparison);
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
     * @return ChildAmazonOrdersVersionQuery The current query, for fluid interface
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

        return $this->addUsingAlias(AmazonOrdersVersionTableMap::MARKETPLACE_ID, $marketplaceId, $comparison);
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
     * @return ChildAmazonOrdersVersionQuery The current query, for fluid interface
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

        return $this->addUsingAlias(AmazonOrdersVersionTableMap::BUYER_COUNTY, $buyerCounty, $comparison);
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
     * @return ChildAmazonOrdersVersionQuery The current query, for fluid interface
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

        return $this->addUsingAlias(AmazonOrdersVersionTableMap::BUYER_TAX_INFO_COMPANY, $buyerTaxInfoCompany, $comparison);
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
     * @return ChildAmazonOrdersVersionQuery The current query, for fluid interface
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

        return $this->addUsingAlias(AmazonOrdersVersionTableMap::BUYER_TAX_INFO_TAXING_REGION, $buyerTaxInfoTaxingRegion, $comparison);
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
     * @return ChildAmazonOrdersVersionQuery The current query, for fluid interface
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

        return $this->addUsingAlias(AmazonOrdersVersionTableMap::BUYER_TAX_INFO_TAX_NAME, $buyerTaxInfoTaxName, $comparison);
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
     * @return ChildAmazonOrdersVersionQuery The current query, for fluid interface
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

        return $this->addUsingAlias(AmazonOrdersVersionTableMap::BUYER_TAX_INFO_TAX_VALUE, $buyerTaxInfoTaxValue, $comparison);
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
     * @return ChildAmazonOrdersVersionQuery The current query, for fluid interface
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

        return $this->addUsingAlias(AmazonOrdersVersionTableMap::SHIPMENT_SERVICE_LEVEL_CATEGORY, $shipmentServiceLevelCategory, $comparison);
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
     * @return ChildAmazonOrdersVersionQuery The current query, for fluid interface
     */
    public function filterByShippedByAmazonTfm($shippedByAmazonTfm = null, $comparison = null)
    {
        if (is_array($shippedByAmazonTfm)) {
            $useMinMax = false;
            if (isset($shippedByAmazonTfm['min'])) {
                $this->addUsingAlias(AmazonOrdersVersionTableMap::SHIPPED_BY_AMAZON_TFM, $shippedByAmazonTfm['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($shippedByAmazonTfm['max'])) {
                $this->addUsingAlias(AmazonOrdersVersionTableMap::SHIPPED_BY_AMAZON_TFM, $shippedByAmazonTfm['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AmazonOrdersVersionTableMap::SHIPPED_BY_AMAZON_TFM, $shippedByAmazonTfm, $comparison);
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
     * @return ChildAmazonOrdersVersionQuery The current query, for fluid interface
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

        return $this->addUsingAlias(AmazonOrdersVersionTableMap::TFM_SHIPMENT_STATUS, $tfmShipmentStatus, $comparison);
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
     * @return ChildAmazonOrdersVersionQuery The current query, for fluid interface
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

        return $this->addUsingAlias(AmazonOrdersVersionTableMap::CBA_DISPLAYABLE_SHIPPING_LABEL, $cbaDisplayableShippingLabel, $comparison);
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
     * @return ChildAmazonOrdersVersionQuery The current query, for fluid interface
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

        return $this->addUsingAlias(AmazonOrdersVersionTableMap::ORDER_TYPE, $orderType, $comparison);
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
     * @return ChildAmazonOrdersVersionQuery The current query, for fluid interface
     */
    public function filterByEarliestShipDate($earliestShipDate = null, $comparison = null)
    {
        if (is_array($earliestShipDate)) {
            $useMinMax = false;
            if (isset($earliestShipDate['min'])) {
                $this->addUsingAlias(AmazonOrdersVersionTableMap::EARLIEST_SHIP_DATE, $earliestShipDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($earliestShipDate['max'])) {
                $this->addUsingAlias(AmazonOrdersVersionTableMap::EARLIEST_SHIP_DATE, $earliestShipDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AmazonOrdersVersionTableMap::EARLIEST_SHIP_DATE, $earliestShipDate, $comparison);
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
     * @return ChildAmazonOrdersVersionQuery The current query, for fluid interface
     */
    public function filterByLatestShipDate($latestShipDate = null, $comparison = null)
    {
        if (is_array($latestShipDate)) {
            $useMinMax = false;
            if (isset($latestShipDate['min'])) {
                $this->addUsingAlias(AmazonOrdersVersionTableMap::LATEST_SHIP_DATE, $latestShipDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($latestShipDate['max'])) {
                $this->addUsingAlias(AmazonOrdersVersionTableMap::LATEST_SHIP_DATE, $latestShipDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AmazonOrdersVersionTableMap::LATEST_SHIP_DATE, $latestShipDate, $comparison);
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
     * @return ChildAmazonOrdersVersionQuery The current query, for fluid interface
     */
    public function filterByEarliestDeliveryDate($earliestDeliveryDate = null, $comparison = null)
    {
        if (is_array($earliestDeliveryDate)) {
            $useMinMax = false;
            if (isset($earliestDeliveryDate['min'])) {
                $this->addUsingAlias(AmazonOrdersVersionTableMap::EARLIEST_DELIVERY_DATE, $earliestDeliveryDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($earliestDeliveryDate['max'])) {
                $this->addUsingAlias(AmazonOrdersVersionTableMap::EARLIEST_DELIVERY_DATE, $earliestDeliveryDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AmazonOrdersVersionTableMap::EARLIEST_DELIVERY_DATE, $earliestDeliveryDate, $comparison);
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
     * @return ChildAmazonOrdersVersionQuery The current query, for fluid interface
     */
    public function filterByLatestDeliveryDate($latestDeliveryDate = null, $comparison = null)
    {
        if (is_array($latestDeliveryDate)) {
            $useMinMax = false;
            if (isset($latestDeliveryDate['min'])) {
                $this->addUsingAlias(AmazonOrdersVersionTableMap::LATEST_DELIVERY_DATE, $latestDeliveryDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($latestDeliveryDate['max'])) {
                $this->addUsingAlias(AmazonOrdersVersionTableMap::LATEST_DELIVERY_DATE, $latestDeliveryDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AmazonOrdersVersionTableMap::LATEST_DELIVERY_DATE, $latestDeliveryDate, $comparison);
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
     * @return ChildAmazonOrdersVersionQuery The current query, for fluid interface
     */
    public function filterByIsBusinessOrder($isBusinessOrder = null, $comparison = null)
    {
        if (is_array($isBusinessOrder)) {
            $useMinMax = false;
            if (isset($isBusinessOrder['min'])) {
                $this->addUsingAlias(AmazonOrdersVersionTableMap::IS_BUSINESS_ORDER, $isBusinessOrder['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($isBusinessOrder['max'])) {
                $this->addUsingAlias(AmazonOrdersVersionTableMap::IS_BUSINESS_ORDER, $isBusinessOrder['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AmazonOrdersVersionTableMap::IS_BUSINESS_ORDER, $isBusinessOrder, $comparison);
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
     * @return ChildAmazonOrdersVersionQuery The current query, for fluid interface
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

        return $this->addUsingAlias(AmazonOrdersVersionTableMap::PURCHASE_ORDER_NUMBER, $purchaseOrderNumber, $comparison);
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
     * @return ChildAmazonOrdersVersionQuery The current query, for fluid interface
     */
    public function filterByIsPrime($isPrime = null, $comparison = null)
    {
        if (is_array($isPrime)) {
            $useMinMax = false;
            if (isset($isPrime['min'])) {
                $this->addUsingAlias(AmazonOrdersVersionTableMap::IS_PRIME, $isPrime['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($isPrime['max'])) {
                $this->addUsingAlias(AmazonOrdersVersionTableMap::IS_PRIME, $isPrime['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AmazonOrdersVersionTableMap::IS_PRIME, $isPrime, $comparison);
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
     * @return ChildAmazonOrdersVersionQuery The current query, for fluid interface
     */
    public function filterByIsPremiumOrder($isPremiumOrder = null, $comparison = null)
    {
        if (is_array($isPremiumOrder)) {
            $useMinMax = false;
            if (isset($isPremiumOrder['min'])) {
                $this->addUsingAlias(AmazonOrdersVersionTableMap::IS_PREMIUM_ORDER, $isPremiumOrder['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($isPremiumOrder['max'])) {
                $this->addUsingAlias(AmazonOrdersVersionTableMap::IS_PREMIUM_ORDER, $isPremiumOrder['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AmazonOrdersVersionTableMap::IS_PREMIUM_ORDER, $isPremiumOrder, $comparison);
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
     * @return ChildAmazonOrdersVersionQuery The current query, for fluid interface
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

        return $this->addUsingAlias(AmazonOrdersVersionTableMap::REPLACED_ORDER_ID, $replacedOrderId, $comparison);
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
     * @return ChildAmazonOrdersVersionQuery The current query, for fluid interface
     */
    public function filterByIsReplacementOrder($isReplacementOrder = null, $comparison = null)
    {
        if (is_array($isReplacementOrder)) {
            $useMinMax = false;
            if (isset($isReplacementOrder['min'])) {
                $this->addUsingAlias(AmazonOrdersVersionTableMap::IS_REPLACEMENT_ORDER, $isReplacementOrder['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($isReplacementOrder['max'])) {
                $this->addUsingAlias(AmazonOrdersVersionTableMap::IS_REPLACEMENT_ORDER, $isReplacementOrder['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AmazonOrdersVersionTableMap::IS_REPLACEMENT_ORDER, $isReplacementOrder, $comparison);
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
     * @param     mixed $orderAddressId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonOrdersVersionQuery The current query, for fluid interface
     */
    public function filterByOrderAddressId($orderAddressId = null, $comparison = null)
    {
        if (is_array($orderAddressId)) {
            $useMinMax = false;
            if (isset($orderAddressId['min'])) {
                $this->addUsingAlias(AmazonOrdersVersionTableMap::ORDER_ADDRESS_ID, $orderAddressId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($orderAddressId['max'])) {
                $this->addUsingAlias(AmazonOrdersVersionTableMap::ORDER_ADDRESS_ID, $orderAddressId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AmazonOrdersVersionTableMap::ORDER_ADDRESS_ID, $orderAddressId, $comparison);
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
     * @param     mixed $customerId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonOrdersVersionQuery The current query, for fluid interface
     */
    public function filterByCustomerId($customerId = null, $comparison = null)
    {
        if (is_array($customerId)) {
            $useMinMax = false;
            if (isset($customerId['min'])) {
                $this->addUsingAlias(AmazonOrdersVersionTableMap::CUSTOMER_ID, $customerId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($customerId['max'])) {
                $this->addUsingAlias(AmazonOrdersVersionTableMap::CUSTOMER_ID, $customerId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AmazonOrdersVersionTableMap::CUSTOMER_ID, $customerId, $comparison);
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
     * @param     mixed $orderId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonOrdersVersionQuery The current query, for fluid interface
     */
    public function filterByOrderId($orderId = null, $comparison = null)
    {
        if (is_array($orderId)) {
            $useMinMax = false;
            if (isset($orderId['min'])) {
                $this->addUsingAlias(AmazonOrdersVersionTableMap::ORDER_ID, $orderId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($orderId['max'])) {
                $this->addUsingAlias(AmazonOrdersVersionTableMap::ORDER_ID, $orderId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AmazonOrdersVersionTableMap::ORDER_ID, $orderId, $comparison);
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
     * @return ChildAmazonOrdersVersionQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(AmazonOrdersVersionTableMap::CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(AmazonOrdersVersionTableMap::CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AmazonOrdersVersionTableMap::CREATED_AT, $createdAt, $comparison);
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
     * @return ChildAmazonOrdersVersionQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(AmazonOrdersVersionTableMap::UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(AmazonOrdersVersionTableMap::UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AmazonOrdersVersionTableMap::UPDATED_AT, $updatedAt, $comparison);
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
     * @return ChildAmazonOrdersVersionQuery The current query, for fluid interface
     */
    public function filterByVersion($version = null, $comparison = null)
    {
        if (is_array($version)) {
            $useMinMax = false;
            if (isset($version['min'])) {
                $this->addUsingAlias(AmazonOrdersVersionTableMap::VERSION, $version['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($version['max'])) {
                $this->addUsingAlias(AmazonOrdersVersionTableMap::VERSION, $version['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AmazonOrdersVersionTableMap::VERSION, $version, $comparison);
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
     * @return ChildAmazonOrdersVersionQuery The current query, for fluid interface
     */
    public function filterByVersionCreatedAt($versionCreatedAt = null, $comparison = null)
    {
        if (is_array($versionCreatedAt)) {
            $useMinMax = false;
            if (isset($versionCreatedAt['min'])) {
                $this->addUsingAlias(AmazonOrdersVersionTableMap::VERSION_CREATED_AT, $versionCreatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($versionCreatedAt['max'])) {
                $this->addUsingAlias(AmazonOrdersVersionTableMap::VERSION_CREATED_AT, $versionCreatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AmazonOrdersVersionTableMap::VERSION_CREATED_AT, $versionCreatedAt, $comparison);
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
     * @return ChildAmazonOrdersVersionQuery The current query, for fluid interface
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

        return $this->addUsingAlias(AmazonOrdersVersionTableMap::VERSION_CREATED_BY, $versionCreatedBy, $comparison);
    }

    /**
     * Filter the query on the customer_id_version column
     *
     * Example usage:
     * <code>
     * $query->filterByCustomerIdVersion(1234); // WHERE customer_id_version = 1234
     * $query->filterByCustomerIdVersion(array(12, 34)); // WHERE customer_id_version IN (12, 34)
     * $query->filterByCustomerIdVersion(array('min' => 12)); // WHERE customer_id_version > 12
     * </code>
     *
     * @param     mixed $customerIdVersion The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonOrdersVersionQuery The current query, for fluid interface
     */
    public function filterByCustomerIdVersion($customerIdVersion = null, $comparison = null)
    {
        if (is_array($customerIdVersion)) {
            $useMinMax = false;
            if (isset($customerIdVersion['min'])) {
                $this->addUsingAlias(AmazonOrdersVersionTableMap::CUSTOMER_ID_VERSION, $customerIdVersion['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($customerIdVersion['max'])) {
                $this->addUsingAlias(AmazonOrdersVersionTableMap::CUSTOMER_ID_VERSION, $customerIdVersion['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AmazonOrdersVersionTableMap::CUSTOMER_ID_VERSION, $customerIdVersion, $comparison);
    }

    /**
     * Filter the query on the order_id_version column
     *
     * Example usage:
     * <code>
     * $query->filterByOrderIdVersion(1234); // WHERE order_id_version = 1234
     * $query->filterByOrderIdVersion(array(12, 34)); // WHERE order_id_version IN (12, 34)
     * $query->filterByOrderIdVersion(array('min' => 12)); // WHERE order_id_version > 12
     * </code>
     *
     * @param     mixed $orderIdVersion The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonOrdersVersionQuery The current query, for fluid interface
     */
    public function filterByOrderIdVersion($orderIdVersion = null, $comparison = null)
    {
        if (is_array($orderIdVersion)) {
            $useMinMax = false;
            if (isset($orderIdVersion['min'])) {
                $this->addUsingAlias(AmazonOrdersVersionTableMap::ORDER_ID_VERSION, $orderIdVersion['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($orderIdVersion['max'])) {
                $this->addUsingAlias(AmazonOrdersVersionTableMap::ORDER_ID_VERSION, $orderIdVersion['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AmazonOrdersVersionTableMap::ORDER_ID_VERSION, $orderIdVersion, $comparison);
    }

    /**
     * Filter the query on the amazon_order_product_ids column
     *
     * @param     array $amazonOrderProductIds The values to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonOrdersVersionQuery The current query, for fluid interface
     */
    public function filterByAmazonOrderProductIds($amazonOrderProductIds = null, $comparison = null)
    {
        $key = $this->getAliasedColName(AmazonOrdersVersionTableMap::AMAZON_ORDER_PRODUCT_IDS);
        if (null === $comparison || $comparison == Criteria::CONTAINS_ALL) {
            foreach ($amazonOrderProductIds as $value) {
                $value = '%| ' . $value . ' |%';
                if ($this->containsKey($key)) {
                    $this->addAnd($key, $value, Criteria::LIKE);
                } else {
                    $this->add($key, $value, Criteria::LIKE);
                }
            }

            return $this;
        } elseif ($comparison == Criteria::CONTAINS_SOME) {
            foreach ($amazonOrderProductIds as $value) {
                $value = '%| ' . $value . ' |%';
                if ($this->containsKey($key)) {
                    $this->addOr($key, $value, Criteria::LIKE);
                } else {
                    $this->add($key, $value, Criteria::LIKE);
                }
            }

            return $this;
        } elseif ($comparison == Criteria::CONTAINS_NONE) {
            foreach ($amazonOrderProductIds as $value) {
                $value = '%| ' . $value . ' |%';
                if ($this->containsKey($key)) {
                    $this->addAnd($key, $value, Criteria::NOT_LIKE);
                } else {
                    $this->add($key, $value, Criteria::NOT_LIKE);
                }
            }
            $this->addOr($key, null, Criteria::ISNULL);

            return $this;
        }

        return $this->addUsingAlias(AmazonOrdersVersionTableMap::AMAZON_ORDER_PRODUCT_IDS, $amazonOrderProductIds, $comparison);
    }

    /**
     * Filter the query on the amazon_order_product_ids column
     * @param     mixed $amazonOrderProductIds The value to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::CONTAINS_ALL
     *
     * @return ChildAmazonOrdersVersionQuery The current query, for fluid interface
     */
    public function filterByAmazonOrderProductId($amazonOrderProductIds = null, $comparison = null)
    {
        if (null === $comparison || $comparison == Criteria::CONTAINS_ALL) {
            if (is_scalar($amazonOrderProductIds)) {
                $amazonOrderProductIds = '%| ' . $amazonOrderProductIds . ' |%';
                $comparison = Criteria::LIKE;
            }
        } elseif ($comparison == Criteria::CONTAINS_NONE) {
            $amazonOrderProductIds = '%| ' . $amazonOrderProductIds . ' |%';
            $comparison = Criteria::NOT_LIKE;
            $key = $this->getAliasedColName(AmazonOrdersVersionTableMap::AMAZON_ORDER_PRODUCT_IDS);
            if ($this->containsKey($key)) {
                $this->addAnd($key, $amazonOrderProductIds, $comparison);
            } else {
                $this->addAnd($key, $amazonOrderProductIds, $comparison);
            }
            $this->addOr($key, null, Criteria::ISNULL);

            return $this;
        }

        return $this->addUsingAlias(AmazonOrdersVersionTableMap::AMAZON_ORDER_PRODUCT_IDS, $amazonOrderProductIds, $comparison);
    }

    /**
     * Filter the query on the amazon_order_product_versions column
     *
     * @param     array $amazonOrderProductVersions The values to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonOrdersVersionQuery The current query, for fluid interface
     */
    public function filterByAmazonOrderProductVersions($amazonOrderProductVersions = null, $comparison = null)
    {
        $key = $this->getAliasedColName(AmazonOrdersVersionTableMap::AMAZON_ORDER_PRODUCT_VERSIONS);
        if (null === $comparison || $comparison == Criteria::CONTAINS_ALL) {
            foreach ($amazonOrderProductVersions as $value) {
                $value = '%| ' . $value . ' |%';
                if ($this->containsKey($key)) {
                    $this->addAnd($key, $value, Criteria::LIKE);
                } else {
                    $this->add($key, $value, Criteria::LIKE);
                }
            }

            return $this;
        } elseif ($comparison == Criteria::CONTAINS_SOME) {
            foreach ($amazonOrderProductVersions as $value) {
                $value = '%| ' . $value . ' |%';
                if ($this->containsKey($key)) {
                    $this->addOr($key, $value, Criteria::LIKE);
                } else {
                    $this->add($key, $value, Criteria::LIKE);
                }
            }

            return $this;
        } elseif ($comparison == Criteria::CONTAINS_NONE) {
            foreach ($amazonOrderProductVersions as $value) {
                $value = '%| ' . $value . ' |%';
                if ($this->containsKey($key)) {
                    $this->addAnd($key, $value, Criteria::NOT_LIKE);
                } else {
                    $this->add($key, $value, Criteria::NOT_LIKE);
                }
            }
            $this->addOr($key, null, Criteria::ISNULL);

            return $this;
        }

        return $this->addUsingAlias(AmazonOrdersVersionTableMap::AMAZON_ORDER_PRODUCT_VERSIONS, $amazonOrderProductVersions, $comparison);
    }

    /**
     * Filter the query on the amazon_order_product_versions column
     * @param     mixed $amazonOrderProductVersions The value to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::CONTAINS_ALL
     *
     * @return ChildAmazonOrdersVersionQuery The current query, for fluid interface
     */
    public function filterByAmazonOrderProductVersion($amazonOrderProductVersions = null, $comparison = null)
    {
        if (null === $comparison || $comparison == Criteria::CONTAINS_ALL) {
            if (is_scalar($amazonOrderProductVersions)) {
                $amazonOrderProductVersions = '%| ' . $amazonOrderProductVersions . ' |%';
                $comparison = Criteria::LIKE;
            }
        } elseif ($comparison == Criteria::CONTAINS_NONE) {
            $amazonOrderProductVersions = '%| ' . $amazonOrderProductVersions . ' |%';
            $comparison = Criteria::NOT_LIKE;
            $key = $this->getAliasedColName(AmazonOrdersVersionTableMap::AMAZON_ORDER_PRODUCT_VERSIONS);
            if ($this->containsKey($key)) {
                $this->addAnd($key, $amazonOrderProductVersions, $comparison);
            } else {
                $this->addAnd($key, $amazonOrderProductVersions, $comparison);
            }
            $this->addOr($key, null, Criteria::ISNULL);

            return $this;
        }

        return $this->addUsingAlias(AmazonOrdersVersionTableMap::AMAZON_ORDER_PRODUCT_VERSIONS, $amazonOrderProductVersions, $comparison);
    }

    /**
     * Filter the query by a related \AmazonIntegration\Model\AmazonOrders object
     *
     * @param \AmazonIntegration\Model\AmazonOrders|ObjectCollection $amazonOrders The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonOrdersVersionQuery The current query, for fluid interface
     */
    public function filterByAmazonOrders($amazonOrders, $comparison = null)
    {
        if ($amazonOrders instanceof \AmazonIntegration\Model\AmazonOrders) {
            return $this
                ->addUsingAlias(AmazonOrdersVersionTableMap::ID, $amazonOrders->getId(), $comparison);
        } elseif ($amazonOrders instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AmazonOrdersVersionTableMap::ID, $amazonOrders->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return ChildAmazonOrdersVersionQuery The current query, for fluid interface
     */
    public function joinAmazonOrders($relationAlias = null, $joinType = Criteria::INNER_JOIN)
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
    public function useAmazonOrdersQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinAmazonOrders($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'AmazonOrders', '\AmazonIntegration\Model\AmazonOrdersQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildAmazonOrdersVersion $amazonOrdersVersion Object to remove from the list of results
     *
     * @return ChildAmazonOrdersVersionQuery The current query, for fluid interface
     */
    public function prune($amazonOrdersVersion = null)
    {
        if ($amazonOrdersVersion) {
            $this->addCond('pruneCond0', $this->getAliasedColName(AmazonOrdersVersionTableMap::ID), $amazonOrdersVersion->getId(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(AmazonOrdersVersionTableMap::VERSION), $amazonOrdersVersion->getVersion(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the amazon_orders_version table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(AmazonOrdersVersionTableMap::DATABASE_NAME);
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
            AmazonOrdersVersionTableMap::clearInstancePool();
            AmazonOrdersVersionTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildAmazonOrdersVersion or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildAmazonOrdersVersion object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(AmazonOrdersVersionTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(AmazonOrdersVersionTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            

        AmazonOrdersVersionTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            AmazonOrdersVersionTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

} // AmazonOrdersVersionQuery
