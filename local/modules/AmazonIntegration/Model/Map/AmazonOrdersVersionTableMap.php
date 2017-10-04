<?php

namespace AmazonIntegration\Model\Map;

use AmazonIntegration\Model\AmazonOrdersVersion;
use AmazonIntegration\Model\AmazonOrdersVersionQuery;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;


/**
 * This class defines the structure of the 'amazon_orders_version' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class AmazonOrdersVersionTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;
    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'AmazonIntegration.Model.Map.AmazonOrdersVersionTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'thelia';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'amazon_orders_version';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\AmazonIntegration\\Model\\AmazonOrdersVersion';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'AmazonIntegration.Model.AmazonOrdersVersion';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 47;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 47;

    /**
     * the column name for the ID field
     */
    const ID = 'amazon_orders_version.ID';

    /**
     * the column name for the SELLER_ORDER_ID field
     */
    const SELLER_ORDER_ID = 'amazon_orders_version.SELLER_ORDER_ID';

    /**
     * the column name for the PURCHASE_DATE field
     */
    const PURCHASE_DATE = 'amazon_orders_version.PURCHASE_DATE';

    /**
     * the column name for the LAST_UPDATE_DATE field
     */
    const LAST_UPDATE_DATE = 'amazon_orders_version.LAST_UPDATE_DATE';

    /**
     * the column name for the ORDER_STATUS field
     */
    const ORDER_STATUS = 'amazon_orders_version.ORDER_STATUS';

    /**
     * the column name for the FULFILLMENT_CHANNEL field
     */
    const FULFILLMENT_CHANNEL = 'amazon_orders_version.FULFILLMENT_CHANNEL';

    /**
     * the column name for the SALES_CHANNEL field
     */
    const SALES_CHANNEL = 'amazon_orders_version.SALES_CHANNEL';

    /**
     * the column name for the ORDER_CHANNEL field
     */
    const ORDER_CHANNEL = 'amazon_orders_version.ORDER_CHANNEL';

    /**
     * the column name for the SHIP_SERVICE_LEVEL field
     */
    const SHIP_SERVICE_LEVEL = 'amazon_orders_version.SHIP_SERVICE_LEVEL';

    /**
     * the column name for the ORDER_TOTAL_CURRENCY_CODE field
     */
    const ORDER_TOTAL_CURRENCY_CODE = 'amazon_orders_version.ORDER_TOTAL_CURRENCY_CODE';

    /**
     * the column name for the ORDER_TOTAL_AMOUNT field
     */
    const ORDER_TOTAL_AMOUNT = 'amazon_orders_version.ORDER_TOTAL_AMOUNT';

    /**
     * the column name for the NUMBER_OF_ITEMS_SHIPPED field
     */
    const NUMBER_OF_ITEMS_SHIPPED = 'amazon_orders_version.NUMBER_OF_ITEMS_SHIPPED';

    /**
     * the column name for the NUMBER_OF_ITEMS_UNSHIPPED field
     */
    const NUMBER_OF_ITEMS_UNSHIPPED = 'amazon_orders_version.NUMBER_OF_ITEMS_UNSHIPPED';

    /**
     * the column name for the PAYMENT_EXECUTION_DETAIL_CURRENCY_CODE field
     */
    const PAYMENT_EXECUTION_DETAIL_CURRENCY_CODE = 'amazon_orders_version.PAYMENT_EXECUTION_DETAIL_CURRENCY_CODE';

    /**
     * the column name for the PAYMENT_EXECUTION_DETAIL_TOTAL_AMOUNT field
     */
    const PAYMENT_EXECUTION_DETAIL_TOTAL_AMOUNT = 'amazon_orders_version.PAYMENT_EXECUTION_DETAIL_TOTAL_AMOUNT';

    /**
     * the column name for the PAYMENT_EXECUTION_DETAIL_PAYMENT_METHOD field
     */
    const PAYMENT_EXECUTION_DETAIL_PAYMENT_METHOD = 'amazon_orders_version.PAYMENT_EXECUTION_DETAIL_PAYMENT_METHOD';

    /**
     * the column name for the PAYMENT_METHOD field
     */
    const PAYMENT_METHOD = 'amazon_orders_version.PAYMENT_METHOD';

    /**
     * the column name for the PAYMENT_METHOD_DETAIL field
     */
    const PAYMENT_METHOD_DETAIL = 'amazon_orders_version.PAYMENT_METHOD_DETAIL';

    /**
     * the column name for the MARKETPLACE_ID field
     */
    const MARKETPLACE_ID = 'amazon_orders_version.MARKETPLACE_ID';

    /**
     * the column name for the BUYER_COUNTY field
     */
    const BUYER_COUNTY = 'amazon_orders_version.BUYER_COUNTY';

    /**
     * the column name for the BUYER_TAX_INFO_COMPANY field
     */
    const BUYER_TAX_INFO_COMPANY = 'amazon_orders_version.BUYER_TAX_INFO_COMPANY';

    /**
     * the column name for the BUYER_TAX_INFO_TAXING_REGION field
     */
    const BUYER_TAX_INFO_TAXING_REGION = 'amazon_orders_version.BUYER_TAX_INFO_TAXING_REGION';

    /**
     * the column name for the BUYER_TAX_INFO_TAX_NAME field
     */
    const BUYER_TAX_INFO_TAX_NAME = 'amazon_orders_version.BUYER_TAX_INFO_TAX_NAME';

    /**
     * the column name for the BUYER_TAX_INFO_TAX_VALUE field
     */
    const BUYER_TAX_INFO_TAX_VALUE = 'amazon_orders_version.BUYER_TAX_INFO_TAX_VALUE';

    /**
     * the column name for the SHIPMENT_SERVICE_LEVEL_CATEGORY field
     */
    const SHIPMENT_SERVICE_LEVEL_CATEGORY = 'amazon_orders_version.SHIPMENT_SERVICE_LEVEL_CATEGORY';

    /**
     * the column name for the SHIPPED_BY_AMAZON_TFM field
     */
    const SHIPPED_BY_AMAZON_TFM = 'amazon_orders_version.SHIPPED_BY_AMAZON_TFM';

    /**
     * the column name for the TFM_SHIPMENT_STATUS field
     */
    const TFM_SHIPMENT_STATUS = 'amazon_orders_version.TFM_SHIPMENT_STATUS';

    /**
     * the column name for the CBA_DISPLAYABLE_SHIPPING_LABEL field
     */
    const CBA_DISPLAYABLE_SHIPPING_LABEL = 'amazon_orders_version.CBA_DISPLAYABLE_SHIPPING_LABEL';

    /**
     * the column name for the ORDER_TYPE field
     */
    const ORDER_TYPE = 'amazon_orders_version.ORDER_TYPE';

    /**
     * the column name for the EARLIEST_SHIP_DATE field
     */
    const EARLIEST_SHIP_DATE = 'amazon_orders_version.EARLIEST_SHIP_DATE';

    /**
     * the column name for the LATEST_SHIP_DATE field
     */
    const LATEST_SHIP_DATE = 'amazon_orders_version.LATEST_SHIP_DATE';

    /**
     * the column name for the EARLIEST_DELIVERY_DATE field
     */
    const EARLIEST_DELIVERY_DATE = 'amazon_orders_version.EARLIEST_DELIVERY_DATE';

    /**
     * the column name for the LATEST_DELIVERY_DATE field
     */
    const LATEST_DELIVERY_DATE = 'amazon_orders_version.LATEST_DELIVERY_DATE';

    /**
     * the column name for the IS_BUSINESS_ORDER field
     */
    const IS_BUSINESS_ORDER = 'amazon_orders_version.IS_BUSINESS_ORDER';

    /**
     * the column name for the PURCHASE_ORDER_NUMBER field
     */
    const PURCHASE_ORDER_NUMBER = 'amazon_orders_version.PURCHASE_ORDER_NUMBER';

    /**
     * the column name for the IS_PRIME field
     */
    const IS_PRIME = 'amazon_orders_version.IS_PRIME';

    /**
     * the column name for the IS_PREMIUM_ORDER field
     */
    const IS_PREMIUM_ORDER = 'amazon_orders_version.IS_PREMIUM_ORDER';

    /**
     * the column name for the REPLACED_ORDER_ID field
     */
    const REPLACED_ORDER_ID = 'amazon_orders_version.REPLACED_ORDER_ID';

    /**
     * the column name for the IS_REPLACEMENT_ORDER field
     */
    const IS_REPLACEMENT_ORDER = 'amazon_orders_version.IS_REPLACEMENT_ORDER';

    /**
     * the column name for the ORDER_ADDRESS_ID field
     */
    const ORDER_ADDRESS_ID = 'amazon_orders_version.ORDER_ADDRESS_ID';

    /**
     * the column name for the CUSTOMER_ID field
     */
    const CUSTOMER_ID = 'amazon_orders_version.CUSTOMER_ID';

    /**
     * the column name for the ORDER_ID field
     */
    const ORDER_ID = 'amazon_orders_version.ORDER_ID';

    /**
     * the column name for the CREATED_AT field
     */
    const CREATED_AT = 'amazon_orders_version.CREATED_AT';

    /**
     * the column name for the UPDATED_AT field
     */
    const UPDATED_AT = 'amazon_orders_version.UPDATED_AT';

    /**
     * the column name for the VERSION field
     */
    const VERSION = 'amazon_orders_version.VERSION';

    /**
     * the column name for the VERSION_CREATED_AT field
     */
    const VERSION_CREATED_AT = 'amazon_orders_version.VERSION_CREATED_AT';

    /**
     * the column name for the VERSION_CREATED_BY field
     */
    const VERSION_CREATED_BY = 'amazon_orders_version.VERSION_CREATED_BY';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('Id', 'SellerOrderId', 'PurchaseDate', 'LastUpdateDate', 'OrderStatus', 'FulfillmentChannel', 'SalesChannel', 'OrderChannel', 'ShipServiceLevel', 'OrderTotalCurrencyCode', 'OrderTotalAmount', 'NumberOfItemsShipped', 'NumberOfItemsUnshipped', 'PaymentExecutionDetailCurrencyCode', 'PaymentExecutionDetailTotalAmount', 'PaymentExecutionDetailPaymentMethod', 'PaymentMethod', 'PaymentMethodDetail', 'MarketplaceId', 'BuyerCounty', 'BuyerTaxInfoCompany', 'BuyerTaxInfoTaxingRegion', 'BuyerTaxInfoTaxName', 'BuyerTaxInfoTaxValue', 'ShipmentServiceLevelCategory', 'ShippedByAmazonTfm', 'TfmShipmentStatus', 'CbaDisplayableShippingLabel', 'OrderType', 'EarliestShipDate', 'LatestShipDate', 'EarliestDeliveryDate', 'LatestDeliveryDate', 'IsBusinessOrder', 'PurchaseOrderNumber', 'IsPrime', 'IsPremiumOrder', 'ReplacedOrderId', 'IsReplacementOrder', 'OrderAddressId', 'CustomerId', 'OrderId', 'CreatedAt', 'UpdatedAt', 'Version', 'VersionCreatedAt', 'VersionCreatedBy', ),
        self::TYPE_STUDLYPHPNAME => array('id', 'sellerOrderId', 'purchaseDate', 'lastUpdateDate', 'orderStatus', 'fulfillmentChannel', 'salesChannel', 'orderChannel', 'shipServiceLevel', 'orderTotalCurrencyCode', 'orderTotalAmount', 'numberOfItemsShipped', 'numberOfItemsUnshipped', 'paymentExecutionDetailCurrencyCode', 'paymentExecutionDetailTotalAmount', 'paymentExecutionDetailPaymentMethod', 'paymentMethod', 'paymentMethodDetail', 'marketplaceId', 'buyerCounty', 'buyerTaxInfoCompany', 'buyerTaxInfoTaxingRegion', 'buyerTaxInfoTaxName', 'buyerTaxInfoTaxValue', 'shipmentServiceLevelCategory', 'shippedByAmazonTfm', 'tfmShipmentStatus', 'cbaDisplayableShippingLabel', 'orderType', 'earliestShipDate', 'latestShipDate', 'earliestDeliveryDate', 'latestDeliveryDate', 'isBusinessOrder', 'purchaseOrderNumber', 'isPrime', 'isPremiumOrder', 'replacedOrderId', 'isReplacementOrder', 'orderAddressId', 'customerId', 'orderId', 'createdAt', 'updatedAt', 'version', 'versionCreatedAt', 'versionCreatedBy', ),
        self::TYPE_COLNAME       => array(AmazonOrdersVersionTableMap::ID, AmazonOrdersVersionTableMap::SELLER_ORDER_ID, AmazonOrdersVersionTableMap::PURCHASE_DATE, AmazonOrdersVersionTableMap::LAST_UPDATE_DATE, AmazonOrdersVersionTableMap::ORDER_STATUS, AmazonOrdersVersionTableMap::FULFILLMENT_CHANNEL, AmazonOrdersVersionTableMap::SALES_CHANNEL, AmazonOrdersVersionTableMap::ORDER_CHANNEL, AmazonOrdersVersionTableMap::SHIP_SERVICE_LEVEL, AmazonOrdersVersionTableMap::ORDER_TOTAL_CURRENCY_CODE, AmazonOrdersVersionTableMap::ORDER_TOTAL_AMOUNT, AmazonOrdersVersionTableMap::NUMBER_OF_ITEMS_SHIPPED, AmazonOrdersVersionTableMap::NUMBER_OF_ITEMS_UNSHIPPED, AmazonOrdersVersionTableMap::PAYMENT_EXECUTION_DETAIL_CURRENCY_CODE, AmazonOrdersVersionTableMap::PAYMENT_EXECUTION_DETAIL_TOTAL_AMOUNT, AmazonOrdersVersionTableMap::PAYMENT_EXECUTION_DETAIL_PAYMENT_METHOD, AmazonOrdersVersionTableMap::PAYMENT_METHOD, AmazonOrdersVersionTableMap::PAYMENT_METHOD_DETAIL, AmazonOrdersVersionTableMap::MARKETPLACE_ID, AmazonOrdersVersionTableMap::BUYER_COUNTY, AmazonOrdersVersionTableMap::BUYER_TAX_INFO_COMPANY, AmazonOrdersVersionTableMap::BUYER_TAX_INFO_TAXING_REGION, AmazonOrdersVersionTableMap::BUYER_TAX_INFO_TAX_NAME, AmazonOrdersVersionTableMap::BUYER_TAX_INFO_TAX_VALUE, AmazonOrdersVersionTableMap::SHIPMENT_SERVICE_LEVEL_CATEGORY, AmazonOrdersVersionTableMap::SHIPPED_BY_AMAZON_TFM, AmazonOrdersVersionTableMap::TFM_SHIPMENT_STATUS, AmazonOrdersVersionTableMap::CBA_DISPLAYABLE_SHIPPING_LABEL, AmazonOrdersVersionTableMap::ORDER_TYPE, AmazonOrdersVersionTableMap::EARLIEST_SHIP_DATE, AmazonOrdersVersionTableMap::LATEST_SHIP_DATE, AmazonOrdersVersionTableMap::EARLIEST_DELIVERY_DATE, AmazonOrdersVersionTableMap::LATEST_DELIVERY_DATE, AmazonOrdersVersionTableMap::IS_BUSINESS_ORDER, AmazonOrdersVersionTableMap::PURCHASE_ORDER_NUMBER, AmazonOrdersVersionTableMap::IS_PRIME, AmazonOrdersVersionTableMap::IS_PREMIUM_ORDER, AmazonOrdersVersionTableMap::REPLACED_ORDER_ID, AmazonOrdersVersionTableMap::IS_REPLACEMENT_ORDER, AmazonOrdersVersionTableMap::ORDER_ADDRESS_ID, AmazonOrdersVersionTableMap::CUSTOMER_ID, AmazonOrdersVersionTableMap::ORDER_ID, AmazonOrdersVersionTableMap::CREATED_AT, AmazonOrdersVersionTableMap::UPDATED_AT, AmazonOrdersVersionTableMap::VERSION, AmazonOrdersVersionTableMap::VERSION_CREATED_AT, AmazonOrdersVersionTableMap::VERSION_CREATED_BY, ),
        self::TYPE_RAW_COLNAME   => array('ID', 'SELLER_ORDER_ID', 'PURCHASE_DATE', 'LAST_UPDATE_DATE', 'ORDER_STATUS', 'FULFILLMENT_CHANNEL', 'SALES_CHANNEL', 'ORDER_CHANNEL', 'SHIP_SERVICE_LEVEL', 'ORDER_TOTAL_CURRENCY_CODE', 'ORDER_TOTAL_AMOUNT', 'NUMBER_OF_ITEMS_SHIPPED', 'NUMBER_OF_ITEMS_UNSHIPPED', 'PAYMENT_EXECUTION_DETAIL_CURRENCY_CODE', 'PAYMENT_EXECUTION_DETAIL_TOTAL_AMOUNT', 'PAYMENT_EXECUTION_DETAIL_PAYMENT_METHOD', 'PAYMENT_METHOD', 'PAYMENT_METHOD_DETAIL', 'MARKETPLACE_ID', 'BUYER_COUNTY', 'BUYER_TAX_INFO_COMPANY', 'BUYER_TAX_INFO_TAXING_REGION', 'BUYER_TAX_INFO_TAX_NAME', 'BUYER_TAX_INFO_TAX_VALUE', 'SHIPMENT_SERVICE_LEVEL_CATEGORY', 'SHIPPED_BY_AMAZON_TFM', 'TFM_SHIPMENT_STATUS', 'CBA_DISPLAYABLE_SHIPPING_LABEL', 'ORDER_TYPE', 'EARLIEST_SHIP_DATE', 'LATEST_SHIP_DATE', 'EARLIEST_DELIVERY_DATE', 'LATEST_DELIVERY_DATE', 'IS_BUSINESS_ORDER', 'PURCHASE_ORDER_NUMBER', 'IS_PRIME', 'IS_PREMIUM_ORDER', 'REPLACED_ORDER_ID', 'IS_REPLACEMENT_ORDER', 'ORDER_ADDRESS_ID', 'CUSTOMER_ID', 'ORDER_ID', 'CREATED_AT', 'UPDATED_AT', 'VERSION', 'VERSION_CREATED_AT', 'VERSION_CREATED_BY', ),
        self::TYPE_FIELDNAME     => array('id', 'seller_order_id', 'purchase_date', 'last_update_date', 'order_status', 'fulfillment_channel', 'sales_channel', 'order_channel', 'ship_service_level', 'order_total_currency_code', 'order_total_amount', 'number_of_items_shipped', 'number_of_items_unshipped', 'payment_execution_detail_currency_code', 'payment_execution_detail_total_amount', 'payment_execution_detail_payment_method', 'payment_method', 'payment_method_detail', 'marketplace_id', 'buyer_county', 'buyer_tax_info_company', 'buyer_tax_info_taxing_region', 'buyer_tax_info_tax_name', 'buyer_tax_info_tax_value', 'shipment_service_level_category', 'shipped_by_amazon_tfm', 'tfm_shipment_status', 'cba_displayable_shipping_label', 'order_type', 'earliest_ship_date', 'latest_ship_date', 'earliest_delivery_date', 'latest_delivery_date', 'is_business_order', 'purchase_order_number', 'is_prime', 'is_premium_order', 'replaced_order_id', 'is_replacement_order', 'order_address_id', 'customer_id', 'order_id', 'created_at', 'updated_at', 'version', 'version_created_at', 'version_created_by', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'SellerOrderId' => 1, 'PurchaseDate' => 2, 'LastUpdateDate' => 3, 'OrderStatus' => 4, 'FulfillmentChannel' => 5, 'SalesChannel' => 6, 'OrderChannel' => 7, 'ShipServiceLevel' => 8, 'OrderTotalCurrencyCode' => 9, 'OrderTotalAmount' => 10, 'NumberOfItemsShipped' => 11, 'NumberOfItemsUnshipped' => 12, 'PaymentExecutionDetailCurrencyCode' => 13, 'PaymentExecutionDetailTotalAmount' => 14, 'PaymentExecutionDetailPaymentMethod' => 15, 'PaymentMethod' => 16, 'PaymentMethodDetail' => 17, 'MarketplaceId' => 18, 'BuyerCounty' => 19, 'BuyerTaxInfoCompany' => 20, 'BuyerTaxInfoTaxingRegion' => 21, 'BuyerTaxInfoTaxName' => 22, 'BuyerTaxInfoTaxValue' => 23, 'ShipmentServiceLevelCategory' => 24, 'ShippedByAmazonTfm' => 25, 'TfmShipmentStatus' => 26, 'CbaDisplayableShippingLabel' => 27, 'OrderType' => 28, 'EarliestShipDate' => 29, 'LatestShipDate' => 30, 'EarliestDeliveryDate' => 31, 'LatestDeliveryDate' => 32, 'IsBusinessOrder' => 33, 'PurchaseOrderNumber' => 34, 'IsPrime' => 35, 'IsPremiumOrder' => 36, 'ReplacedOrderId' => 37, 'IsReplacementOrder' => 38, 'OrderAddressId' => 39, 'CustomerId' => 40, 'OrderId' => 41, 'CreatedAt' => 42, 'UpdatedAt' => 43, 'Version' => 44, 'VersionCreatedAt' => 45, 'VersionCreatedBy' => 46, ),
        self::TYPE_STUDLYPHPNAME => array('id' => 0, 'sellerOrderId' => 1, 'purchaseDate' => 2, 'lastUpdateDate' => 3, 'orderStatus' => 4, 'fulfillmentChannel' => 5, 'salesChannel' => 6, 'orderChannel' => 7, 'shipServiceLevel' => 8, 'orderTotalCurrencyCode' => 9, 'orderTotalAmount' => 10, 'numberOfItemsShipped' => 11, 'numberOfItemsUnshipped' => 12, 'paymentExecutionDetailCurrencyCode' => 13, 'paymentExecutionDetailTotalAmount' => 14, 'paymentExecutionDetailPaymentMethod' => 15, 'paymentMethod' => 16, 'paymentMethodDetail' => 17, 'marketplaceId' => 18, 'buyerCounty' => 19, 'buyerTaxInfoCompany' => 20, 'buyerTaxInfoTaxingRegion' => 21, 'buyerTaxInfoTaxName' => 22, 'buyerTaxInfoTaxValue' => 23, 'shipmentServiceLevelCategory' => 24, 'shippedByAmazonTfm' => 25, 'tfmShipmentStatus' => 26, 'cbaDisplayableShippingLabel' => 27, 'orderType' => 28, 'earliestShipDate' => 29, 'latestShipDate' => 30, 'earliestDeliveryDate' => 31, 'latestDeliveryDate' => 32, 'isBusinessOrder' => 33, 'purchaseOrderNumber' => 34, 'isPrime' => 35, 'isPremiumOrder' => 36, 'replacedOrderId' => 37, 'isReplacementOrder' => 38, 'orderAddressId' => 39, 'customerId' => 40, 'orderId' => 41, 'createdAt' => 42, 'updatedAt' => 43, 'version' => 44, 'versionCreatedAt' => 45, 'versionCreatedBy' => 46, ),
        self::TYPE_COLNAME       => array(AmazonOrdersVersionTableMap::ID => 0, AmazonOrdersVersionTableMap::SELLER_ORDER_ID => 1, AmazonOrdersVersionTableMap::PURCHASE_DATE => 2, AmazonOrdersVersionTableMap::LAST_UPDATE_DATE => 3, AmazonOrdersVersionTableMap::ORDER_STATUS => 4, AmazonOrdersVersionTableMap::FULFILLMENT_CHANNEL => 5, AmazonOrdersVersionTableMap::SALES_CHANNEL => 6, AmazonOrdersVersionTableMap::ORDER_CHANNEL => 7, AmazonOrdersVersionTableMap::SHIP_SERVICE_LEVEL => 8, AmazonOrdersVersionTableMap::ORDER_TOTAL_CURRENCY_CODE => 9, AmazonOrdersVersionTableMap::ORDER_TOTAL_AMOUNT => 10, AmazonOrdersVersionTableMap::NUMBER_OF_ITEMS_SHIPPED => 11, AmazonOrdersVersionTableMap::NUMBER_OF_ITEMS_UNSHIPPED => 12, AmazonOrdersVersionTableMap::PAYMENT_EXECUTION_DETAIL_CURRENCY_CODE => 13, AmazonOrdersVersionTableMap::PAYMENT_EXECUTION_DETAIL_TOTAL_AMOUNT => 14, AmazonOrdersVersionTableMap::PAYMENT_EXECUTION_DETAIL_PAYMENT_METHOD => 15, AmazonOrdersVersionTableMap::PAYMENT_METHOD => 16, AmazonOrdersVersionTableMap::PAYMENT_METHOD_DETAIL => 17, AmazonOrdersVersionTableMap::MARKETPLACE_ID => 18, AmazonOrdersVersionTableMap::BUYER_COUNTY => 19, AmazonOrdersVersionTableMap::BUYER_TAX_INFO_COMPANY => 20, AmazonOrdersVersionTableMap::BUYER_TAX_INFO_TAXING_REGION => 21, AmazonOrdersVersionTableMap::BUYER_TAX_INFO_TAX_NAME => 22, AmazonOrdersVersionTableMap::BUYER_TAX_INFO_TAX_VALUE => 23, AmazonOrdersVersionTableMap::SHIPMENT_SERVICE_LEVEL_CATEGORY => 24, AmazonOrdersVersionTableMap::SHIPPED_BY_AMAZON_TFM => 25, AmazonOrdersVersionTableMap::TFM_SHIPMENT_STATUS => 26, AmazonOrdersVersionTableMap::CBA_DISPLAYABLE_SHIPPING_LABEL => 27, AmazonOrdersVersionTableMap::ORDER_TYPE => 28, AmazonOrdersVersionTableMap::EARLIEST_SHIP_DATE => 29, AmazonOrdersVersionTableMap::LATEST_SHIP_DATE => 30, AmazonOrdersVersionTableMap::EARLIEST_DELIVERY_DATE => 31, AmazonOrdersVersionTableMap::LATEST_DELIVERY_DATE => 32, AmazonOrdersVersionTableMap::IS_BUSINESS_ORDER => 33, AmazonOrdersVersionTableMap::PURCHASE_ORDER_NUMBER => 34, AmazonOrdersVersionTableMap::IS_PRIME => 35, AmazonOrdersVersionTableMap::IS_PREMIUM_ORDER => 36, AmazonOrdersVersionTableMap::REPLACED_ORDER_ID => 37, AmazonOrdersVersionTableMap::IS_REPLACEMENT_ORDER => 38, AmazonOrdersVersionTableMap::ORDER_ADDRESS_ID => 39, AmazonOrdersVersionTableMap::CUSTOMER_ID => 40, AmazonOrdersVersionTableMap::ORDER_ID => 41, AmazonOrdersVersionTableMap::CREATED_AT => 42, AmazonOrdersVersionTableMap::UPDATED_AT => 43, AmazonOrdersVersionTableMap::VERSION => 44, AmazonOrdersVersionTableMap::VERSION_CREATED_AT => 45, AmazonOrdersVersionTableMap::VERSION_CREATED_BY => 46, ),
        self::TYPE_RAW_COLNAME   => array('ID' => 0, 'SELLER_ORDER_ID' => 1, 'PURCHASE_DATE' => 2, 'LAST_UPDATE_DATE' => 3, 'ORDER_STATUS' => 4, 'FULFILLMENT_CHANNEL' => 5, 'SALES_CHANNEL' => 6, 'ORDER_CHANNEL' => 7, 'SHIP_SERVICE_LEVEL' => 8, 'ORDER_TOTAL_CURRENCY_CODE' => 9, 'ORDER_TOTAL_AMOUNT' => 10, 'NUMBER_OF_ITEMS_SHIPPED' => 11, 'NUMBER_OF_ITEMS_UNSHIPPED' => 12, 'PAYMENT_EXECUTION_DETAIL_CURRENCY_CODE' => 13, 'PAYMENT_EXECUTION_DETAIL_TOTAL_AMOUNT' => 14, 'PAYMENT_EXECUTION_DETAIL_PAYMENT_METHOD' => 15, 'PAYMENT_METHOD' => 16, 'PAYMENT_METHOD_DETAIL' => 17, 'MARKETPLACE_ID' => 18, 'BUYER_COUNTY' => 19, 'BUYER_TAX_INFO_COMPANY' => 20, 'BUYER_TAX_INFO_TAXING_REGION' => 21, 'BUYER_TAX_INFO_TAX_NAME' => 22, 'BUYER_TAX_INFO_TAX_VALUE' => 23, 'SHIPMENT_SERVICE_LEVEL_CATEGORY' => 24, 'SHIPPED_BY_AMAZON_TFM' => 25, 'TFM_SHIPMENT_STATUS' => 26, 'CBA_DISPLAYABLE_SHIPPING_LABEL' => 27, 'ORDER_TYPE' => 28, 'EARLIEST_SHIP_DATE' => 29, 'LATEST_SHIP_DATE' => 30, 'EARLIEST_DELIVERY_DATE' => 31, 'LATEST_DELIVERY_DATE' => 32, 'IS_BUSINESS_ORDER' => 33, 'PURCHASE_ORDER_NUMBER' => 34, 'IS_PRIME' => 35, 'IS_PREMIUM_ORDER' => 36, 'REPLACED_ORDER_ID' => 37, 'IS_REPLACEMENT_ORDER' => 38, 'ORDER_ADDRESS_ID' => 39, 'CUSTOMER_ID' => 40, 'ORDER_ID' => 41, 'CREATED_AT' => 42, 'UPDATED_AT' => 43, 'VERSION' => 44, 'VERSION_CREATED_AT' => 45, 'VERSION_CREATED_BY' => 46, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'seller_order_id' => 1, 'purchase_date' => 2, 'last_update_date' => 3, 'order_status' => 4, 'fulfillment_channel' => 5, 'sales_channel' => 6, 'order_channel' => 7, 'ship_service_level' => 8, 'order_total_currency_code' => 9, 'order_total_amount' => 10, 'number_of_items_shipped' => 11, 'number_of_items_unshipped' => 12, 'payment_execution_detail_currency_code' => 13, 'payment_execution_detail_total_amount' => 14, 'payment_execution_detail_payment_method' => 15, 'payment_method' => 16, 'payment_method_detail' => 17, 'marketplace_id' => 18, 'buyer_county' => 19, 'buyer_tax_info_company' => 20, 'buyer_tax_info_taxing_region' => 21, 'buyer_tax_info_tax_name' => 22, 'buyer_tax_info_tax_value' => 23, 'shipment_service_level_category' => 24, 'shipped_by_amazon_tfm' => 25, 'tfm_shipment_status' => 26, 'cba_displayable_shipping_label' => 27, 'order_type' => 28, 'earliest_ship_date' => 29, 'latest_ship_date' => 30, 'earliest_delivery_date' => 31, 'latest_delivery_date' => 32, 'is_business_order' => 33, 'purchase_order_number' => 34, 'is_prime' => 35, 'is_premium_order' => 36, 'replaced_order_id' => 37, 'is_replacement_order' => 38, 'order_address_id' => 39, 'customer_id' => 40, 'order_id' => 41, 'created_at' => 42, 'updated_at' => 43, 'version' => 44, 'version_created_at' => 45, 'version_created_by' => 46, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, )
    );

    /**
     * Initialize the table attributes and columns
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('amazon_orders_version');
        $this->setPhpName('AmazonOrdersVersion');
        $this->setClassName('\\AmazonIntegration\\Model\\AmazonOrdersVersion');
        $this->setPackage('AmazonIntegration.Model');
        $this->setUseIdGenerator(false);
        // columns
        $this->addForeignPrimaryKey('ID', 'Id', 'VARCHAR' , 'amazon_orders', 'ID', true, 45, null);
        $this->addColumn('SELLER_ORDER_ID', 'SellerOrderId', 'VARCHAR', false, 45, null);
        $this->addColumn('PURCHASE_DATE', 'PurchaseDate', 'TIMESTAMP', false, null, null);
        $this->addColumn('LAST_UPDATE_DATE', 'LastUpdateDate', 'TIMESTAMP', false, null, null);
        $this->addColumn('ORDER_STATUS', 'OrderStatus', 'VARCHAR', false, 45, null);
        $this->addColumn('FULFILLMENT_CHANNEL', 'FulfillmentChannel', 'VARCHAR', false, 45, null);
        $this->addColumn('SALES_CHANNEL', 'SalesChannel', 'VARCHAR', false, 45, null);
        $this->addColumn('ORDER_CHANNEL', 'OrderChannel', 'VARCHAR', false, 45, null);
        $this->addColumn('SHIP_SERVICE_LEVEL', 'ShipServiceLevel', 'VARCHAR', false, 45, null);
        $this->addColumn('ORDER_TOTAL_CURRENCY_CODE', 'OrderTotalCurrencyCode', 'VARCHAR', false, 45, null);
        $this->addColumn('ORDER_TOTAL_AMOUNT', 'OrderTotalAmount', 'DECIMAL', true, 16, 0);
        $this->addColumn('NUMBER_OF_ITEMS_SHIPPED', 'NumberOfItemsShipped', 'FLOAT', false, null, null);
        $this->addColumn('NUMBER_OF_ITEMS_UNSHIPPED', 'NumberOfItemsUnshipped', 'FLOAT', false, null, null);
        $this->addColumn('PAYMENT_EXECUTION_DETAIL_CURRENCY_CODE', 'PaymentExecutionDetailCurrencyCode', 'VARCHAR', false, 45, null);
        $this->addColumn('PAYMENT_EXECUTION_DETAIL_TOTAL_AMOUNT', 'PaymentExecutionDetailTotalAmount', 'DECIMAL', true, 16, 0);
        $this->addColumn('PAYMENT_EXECUTION_DETAIL_PAYMENT_METHOD', 'PaymentExecutionDetailPaymentMethod', 'VARCHAR', false, 45, null);
        $this->addColumn('PAYMENT_METHOD', 'PaymentMethod', 'VARCHAR', false, 45, null);
        $this->addColumn('PAYMENT_METHOD_DETAIL', 'PaymentMethodDetail', 'VARCHAR', false, 45, null);
        $this->addColumn('MARKETPLACE_ID', 'MarketplaceId', 'VARCHAR', false, 45, null);
        $this->addColumn('BUYER_COUNTY', 'BuyerCounty', 'VARCHAR', false, 45, null);
        $this->addColumn('BUYER_TAX_INFO_COMPANY', 'BuyerTaxInfoCompany', 'VARCHAR', false, 45, null);
        $this->addColumn('BUYER_TAX_INFO_TAXING_REGION', 'BuyerTaxInfoTaxingRegion', 'VARCHAR', false, 45, null);
        $this->addColumn('BUYER_TAX_INFO_TAX_NAME', 'BuyerTaxInfoTaxName', 'VARCHAR', false, 45, null);
        $this->addColumn('BUYER_TAX_INFO_TAX_VALUE', 'BuyerTaxInfoTaxValue', 'VARCHAR', false, 45, null);
        $this->addColumn('SHIPMENT_SERVICE_LEVEL_CATEGORY', 'ShipmentServiceLevelCategory', 'VARCHAR', false, 45, null);
        $this->addColumn('SHIPPED_BY_AMAZON_TFM', 'ShippedByAmazonTfm', 'TINYINT', true, null, 0);
        $this->addColumn('TFM_SHIPMENT_STATUS', 'TfmShipmentStatus', 'VARCHAR', false, 45, null);
        $this->addColumn('CBA_DISPLAYABLE_SHIPPING_LABEL', 'CbaDisplayableShippingLabel', 'VARCHAR', false, 45, null);
        $this->addColumn('ORDER_TYPE', 'OrderType', 'VARCHAR', false, 45, null);
        $this->addColumn('EARLIEST_SHIP_DATE', 'EarliestShipDate', 'TIMESTAMP', false, null, null);
        $this->addColumn('LATEST_SHIP_DATE', 'LatestShipDate', 'TIMESTAMP', false, null, null);
        $this->addColumn('EARLIEST_DELIVERY_DATE', 'EarliestDeliveryDate', 'TIMESTAMP', false, null, null);
        $this->addColumn('LATEST_DELIVERY_DATE', 'LatestDeliveryDate', 'TIMESTAMP', false, null, null);
        $this->addColumn('IS_BUSINESS_ORDER', 'IsBusinessOrder', 'TINYINT', true, null, 0);
        $this->addColumn('PURCHASE_ORDER_NUMBER', 'PurchaseOrderNumber', 'VARCHAR', false, 45, null);
        $this->addColumn('IS_PRIME', 'IsPrime', 'TINYINT', true, null, 0);
        $this->addColumn('IS_PREMIUM_ORDER', 'IsPremiumOrder', 'TINYINT', true, null, 0);
        $this->addColumn('REPLACED_ORDER_ID', 'ReplacedOrderId', 'VARCHAR', false, 45, null);
        $this->addColumn('IS_REPLACEMENT_ORDER', 'IsReplacementOrder', 'TINYINT', true, null, 0);
        $this->addColumn('ORDER_ADDRESS_ID', 'OrderAddressId', 'INTEGER', false, null, null);
        $this->addColumn('CUSTOMER_ID', 'CustomerId', 'INTEGER', false, null, null);
        $this->addColumn('ORDER_ID', 'OrderId', 'INTEGER', false, null, null);
        $this->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('UPDATED_AT', 'UpdatedAt', 'TIMESTAMP', false, null, null);
        $this->addPrimaryKey('VERSION', 'Version', 'INTEGER', true, null, 0);
        $this->addColumn('VERSION_CREATED_AT', 'VersionCreatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('VERSION_CREATED_BY', 'VersionCreatedBy', 'VARCHAR', false, 100, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('AmazonOrders', '\\AmazonIntegration\\Model\\AmazonOrders', RelationMap::MANY_TO_ONE, array('id' => 'id', ), 'CASCADE', null);
    } // buildRelations()

    /**
     * Adds an object to the instance pool.
     *
     * Propel keeps cached copies of objects in an instance pool when they are retrieved
     * from the database. In some cases you may need to explicitly add objects
     * to the cache in order to ensure that the same objects are always returned by find*()
     * and findPk*() calls.
     *
     * @param \AmazonIntegration\Model\AmazonOrdersVersion $obj A \AmazonIntegration\Model\AmazonOrdersVersion object.
     * @param string $key             (optional) key to use for instance map (for performance boost if key was already calculated externally).
     */
    public static function addInstanceToPool($obj, $key = null)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if (null === $key) {
                $key = serialize(array((string) $obj->getId(), (string) $obj->getVersion()));
            } // if key === null
            self::$instances[$key] = $obj;
        }
    }

    /**
     * Removes an object from the instance pool.
     *
     * Propel keeps cached copies of objects in an instance pool when they are retrieved
     * from the database.  In some cases -- especially when you override doDelete
     * methods in your stub classes -- you may need to explicitly remove objects
     * from the cache in order to prevent returning objects that no longer exist.
     *
     * @param mixed $value A \AmazonIntegration\Model\AmazonOrdersVersion object or a primary key value.
     */
    public static function removeInstanceFromPool($value)
    {
        if (Propel::isInstancePoolingEnabled() && null !== $value) {
            if (is_object($value) && $value instanceof \AmazonIntegration\Model\AmazonOrdersVersion) {
                $key = serialize(array((string) $value->getId(), (string) $value->getVersion()));

            } elseif (is_array($value) && count($value) === 2) {
                // assume we've been passed a primary key";
                $key = serialize(array((string) $value[0], (string) $value[1]));
            } elseif ($value instanceof Criteria) {
                self::$instances = [];

                return;
            } else {
                $e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or \AmazonIntegration\Model\AmazonOrdersVersion object; got " . (is_object($value) ? get_class($value) . ' object.' : var_export($value, true)));
                throw $e;
            }

            unset(self::$instances[$key]);
        }
    }

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     */
    public static function getPrimaryKeyHashFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        // If the PK cannot be derived from the row, return NULL.
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] === null && $row[TableMap::TYPE_NUM == $indexType ? 44 + $offset : static::translateFieldName('Version', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return serialize(array((string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)], (string) $row[TableMap::TYPE_NUM == $indexType ? 44 + $offset : static::translateFieldName('Version', TableMap::TYPE_PHPNAME, $indexType)]));
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {

            return $pks;
    }
    
    /**
     * The class that the tableMap will make instances of.
     *
     * If $withPrefix is true, the returned path
     * uses a dot-path notation which is translated into a path
     * relative to a location on the PHP include_path.
     * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
     *
     * @param boolean $withPrefix Whether or not to return the path with the class name
     * @return string path.to.ClassName
     */
    public static function getOMClass($withPrefix = true)
    {
        return $withPrefix ? AmazonOrdersVersionTableMap::CLASS_DEFAULT : AmazonOrdersVersionTableMap::OM_CLASS;
    }

    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param array  $row       row returned by DataFetcher->fetch().
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                 One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     * @return array (AmazonOrdersVersion object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = AmazonOrdersVersionTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = AmazonOrdersVersionTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + AmazonOrdersVersionTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = AmazonOrdersVersionTableMap::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            AmazonOrdersVersionTableMap::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @param DataFetcherInterface $dataFetcher
     * @return array
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function populateObjects(DataFetcherInterface $dataFetcher)
    {
        $results = array();
    
        // set the class once to avoid overhead in the loop
        $cls = static::getOMClass(false);
        // populate the object(s)
        while ($row = $dataFetcher->fetch()) {
            $key = AmazonOrdersVersionTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = AmazonOrdersVersionTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                AmazonOrdersVersionTableMap::addInstanceToPool($obj, $key);
            } // if key exists
        }

        return $results;
    }
    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param Criteria $criteria object containing the columns to add.
     * @param string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(AmazonOrdersVersionTableMap::ID);
            $criteria->addSelectColumn(AmazonOrdersVersionTableMap::SELLER_ORDER_ID);
            $criteria->addSelectColumn(AmazonOrdersVersionTableMap::PURCHASE_DATE);
            $criteria->addSelectColumn(AmazonOrdersVersionTableMap::LAST_UPDATE_DATE);
            $criteria->addSelectColumn(AmazonOrdersVersionTableMap::ORDER_STATUS);
            $criteria->addSelectColumn(AmazonOrdersVersionTableMap::FULFILLMENT_CHANNEL);
            $criteria->addSelectColumn(AmazonOrdersVersionTableMap::SALES_CHANNEL);
            $criteria->addSelectColumn(AmazonOrdersVersionTableMap::ORDER_CHANNEL);
            $criteria->addSelectColumn(AmazonOrdersVersionTableMap::SHIP_SERVICE_LEVEL);
            $criteria->addSelectColumn(AmazonOrdersVersionTableMap::ORDER_TOTAL_CURRENCY_CODE);
            $criteria->addSelectColumn(AmazonOrdersVersionTableMap::ORDER_TOTAL_AMOUNT);
            $criteria->addSelectColumn(AmazonOrdersVersionTableMap::NUMBER_OF_ITEMS_SHIPPED);
            $criteria->addSelectColumn(AmazonOrdersVersionTableMap::NUMBER_OF_ITEMS_UNSHIPPED);
            $criteria->addSelectColumn(AmazonOrdersVersionTableMap::PAYMENT_EXECUTION_DETAIL_CURRENCY_CODE);
            $criteria->addSelectColumn(AmazonOrdersVersionTableMap::PAYMENT_EXECUTION_DETAIL_TOTAL_AMOUNT);
            $criteria->addSelectColumn(AmazonOrdersVersionTableMap::PAYMENT_EXECUTION_DETAIL_PAYMENT_METHOD);
            $criteria->addSelectColumn(AmazonOrdersVersionTableMap::PAYMENT_METHOD);
            $criteria->addSelectColumn(AmazonOrdersVersionTableMap::PAYMENT_METHOD_DETAIL);
            $criteria->addSelectColumn(AmazonOrdersVersionTableMap::MARKETPLACE_ID);
            $criteria->addSelectColumn(AmazonOrdersVersionTableMap::BUYER_COUNTY);
            $criteria->addSelectColumn(AmazonOrdersVersionTableMap::BUYER_TAX_INFO_COMPANY);
            $criteria->addSelectColumn(AmazonOrdersVersionTableMap::BUYER_TAX_INFO_TAXING_REGION);
            $criteria->addSelectColumn(AmazonOrdersVersionTableMap::BUYER_TAX_INFO_TAX_NAME);
            $criteria->addSelectColumn(AmazonOrdersVersionTableMap::BUYER_TAX_INFO_TAX_VALUE);
            $criteria->addSelectColumn(AmazonOrdersVersionTableMap::SHIPMENT_SERVICE_LEVEL_CATEGORY);
            $criteria->addSelectColumn(AmazonOrdersVersionTableMap::SHIPPED_BY_AMAZON_TFM);
            $criteria->addSelectColumn(AmazonOrdersVersionTableMap::TFM_SHIPMENT_STATUS);
            $criteria->addSelectColumn(AmazonOrdersVersionTableMap::CBA_DISPLAYABLE_SHIPPING_LABEL);
            $criteria->addSelectColumn(AmazonOrdersVersionTableMap::ORDER_TYPE);
            $criteria->addSelectColumn(AmazonOrdersVersionTableMap::EARLIEST_SHIP_DATE);
            $criteria->addSelectColumn(AmazonOrdersVersionTableMap::LATEST_SHIP_DATE);
            $criteria->addSelectColumn(AmazonOrdersVersionTableMap::EARLIEST_DELIVERY_DATE);
            $criteria->addSelectColumn(AmazonOrdersVersionTableMap::LATEST_DELIVERY_DATE);
            $criteria->addSelectColumn(AmazonOrdersVersionTableMap::IS_BUSINESS_ORDER);
            $criteria->addSelectColumn(AmazonOrdersVersionTableMap::PURCHASE_ORDER_NUMBER);
            $criteria->addSelectColumn(AmazonOrdersVersionTableMap::IS_PRIME);
            $criteria->addSelectColumn(AmazonOrdersVersionTableMap::IS_PREMIUM_ORDER);
            $criteria->addSelectColumn(AmazonOrdersVersionTableMap::REPLACED_ORDER_ID);
            $criteria->addSelectColumn(AmazonOrdersVersionTableMap::IS_REPLACEMENT_ORDER);
            $criteria->addSelectColumn(AmazonOrdersVersionTableMap::ORDER_ADDRESS_ID);
            $criteria->addSelectColumn(AmazonOrdersVersionTableMap::CUSTOMER_ID);
            $criteria->addSelectColumn(AmazonOrdersVersionTableMap::ORDER_ID);
            $criteria->addSelectColumn(AmazonOrdersVersionTableMap::CREATED_AT);
            $criteria->addSelectColumn(AmazonOrdersVersionTableMap::UPDATED_AT);
            $criteria->addSelectColumn(AmazonOrdersVersionTableMap::VERSION);
            $criteria->addSelectColumn(AmazonOrdersVersionTableMap::VERSION_CREATED_AT);
            $criteria->addSelectColumn(AmazonOrdersVersionTableMap::VERSION_CREATED_BY);
        } else {
            $criteria->addSelectColumn($alias . '.ID');
            $criteria->addSelectColumn($alias . '.SELLER_ORDER_ID');
            $criteria->addSelectColumn($alias . '.PURCHASE_DATE');
            $criteria->addSelectColumn($alias . '.LAST_UPDATE_DATE');
            $criteria->addSelectColumn($alias . '.ORDER_STATUS');
            $criteria->addSelectColumn($alias . '.FULFILLMENT_CHANNEL');
            $criteria->addSelectColumn($alias . '.SALES_CHANNEL');
            $criteria->addSelectColumn($alias . '.ORDER_CHANNEL');
            $criteria->addSelectColumn($alias . '.SHIP_SERVICE_LEVEL');
            $criteria->addSelectColumn($alias . '.ORDER_TOTAL_CURRENCY_CODE');
            $criteria->addSelectColumn($alias . '.ORDER_TOTAL_AMOUNT');
            $criteria->addSelectColumn($alias . '.NUMBER_OF_ITEMS_SHIPPED');
            $criteria->addSelectColumn($alias . '.NUMBER_OF_ITEMS_UNSHIPPED');
            $criteria->addSelectColumn($alias . '.PAYMENT_EXECUTION_DETAIL_CURRENCY_CODE');
            $criteria->addSelectColumn($alias . '.PAYMENT_EXECUTION_DETAIL_TOTAL_AMOUNT');
            $criteria->addSelectColumn($alias . '.PAYMENT_EXECUTION_DETAIL_PAYMENT_METHOD');
            $criteria->addSelectColumn($alias . '.PAYMENT_METHOD');
            $criteria->addSelectColumn($alias . '.PAYMENT_METHOD_DETAIL');
            $criteria->addSelectColumn($alias . '.MARKETPLACE_ID');
            $criteria->addSelectColumn($alias . '.BUYER_COUNTY');
            $criteria->addSelectColumn($alias . '.BUYER_TAX_INFO_COMPANY');
            $criteria->addSelectColumn($alias . '.BUYER_TAX_INFO_TAXING_REGION');
            $criteria->addSelectColumn($alias . '.BUYER_TAX_INFO_TAX_NAME');
            $criteria->addSelectColumn($alias . '.BUYER_TAX_INFO_TAX_VALUE');
            $criteria->addSelectColumn($alias . '.SHIPMENT_SERVICE_LEVEL_CATEGORY');
            $criteria->addSelectColumn($alias . '.SHIPPED_BY_AMAZON_TFM');
            $criteria->addSelectColumn($alias . '.TFM_SHIPMENT_STATUS');
            $criteria->addSelectColumn($alias . '.CBA_DISPLAYABLE_SHIPPING_LABEL');
            $criteria->addSelectColumn($alias . '.ORDER_TYPE');
            $criteria->addSelectColumn($alias . '.EARLIEST_SHIP_DATE');
            $criteria->addSelectColumn($alias . '.LATEST_SHIP_DATE');
            $criteria->addSelectColumn($alias . '.EARLIEST_DELIVERY_DATE');
            $criteria->addSelectColumn($alias . '.LATEST_DELIVERY_DATE');
            $criteria->addSelectColumn($alias . '.IS_BUSINESS_ORDER');
            $criteria->addSelectColumn($alias . '.PURCHASE_ORDER_NUMBER');
            $criteria->addSelectColumn($alias . '.IS_PRIME');
            $criteria->addSelectColumn($alias . '.IS_PREMIUM_ORDER');
            $criteria->addSelectColumn($alias . '.REPLACED_ORDER_ID');
            $criteria->addSelectColumn($alias . '.IS_REPLACEMENT_ORDER');
            $criteria->addSelectColumn($alias . '.ORDER_ADDRESS_ID');
            $criteria->addSelectColumn($alias . '.CUSTOMER_ID');
            $criteria->addSelectColumn($alias . '.ORDER_ID');
            $criteria->addSelectColumn($alias . '.CREATED_AT');
            $criteria->addSelectColumn($alias . '.UPDATED_AT');
            $criteria->addSelectColumn($alias . '.VERSION');
            $criteria->addSelectColumn($alias . '.VERSION_CREATED_AT');
            $criteria->addSelectColumn($alias . '.VERSION_CREATED_BY');
        }
    }

    /**
     * Returns the TableMap related to this object.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getServiceContainer()->getDatabaseMap(AmazonOrdersVersionTableMap::DATABASE_NAME)->getTable(AmazonOrdersVersionTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getServiceContainer()->getDatabaseMap(AmazonOrdersVersionTableMap::DATABASE_NAME);
      if (!$dbMap->hasTable(AmazonOrdersVersionTableMap::TABLE_NAME)) {
        $dbMap->addTableObject(new AmazonOrdersVersionTableMap());
      }
    }

    /**
     * Performs a DELETE on the database, given a AmazonOrdersVersion or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or AmazonOrdersVersion object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(AmazonOrdersVersionTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \AmazonIntegration\Model\AmazonOrdersVersion) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(AmazonOrdersVersionTableMap::DATABASE_NAME);
            // primary key is composite; we therefore, expect
            // the primary key passed to be an array of pkey values
            if (count($values) == count($values, COUNT_RECURSIVE)) {
                // array is not multi-dimensional
                $values = array($values);
            }
            foreach ($values as $value) {
                $criterion = $criteria->getNewCriterion(AmazonOrdersVersionTableMap::ID, $value[0]);
                $criterion->addAnd($criteria->getNewCriterion(AmazonOrdersVersionTableMap::VERSION, $value[1]));
                $criteria->addOr($criterion);
            }
        }

        $query = AmazonOrdersVersionQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) { AmazonOrdersVersionTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) { AmazonOrdersVersionTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the amazon_orders_version table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return AmazonOrdersVersionQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a AmazonOrdersVersion or Criteria object.
     *
     * @param mixed               $criteria Criteria or AmazonOrdersVersion object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(AmazonOrdersVersionTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from AmazonOrdersVersion object
        }


        // Set the correct dbName
        $query = AmazonOrdersVersionQuery::create()->mergeWith($criteria);

        try {
            // use transaction because $criteria could contain info
            // for more than one table (I guess, conceivably)
            $con->beginTransaction();
            $pk = $query->doInsert($con);
            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $pk;
    }

} // AmazonOrdersVersionTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
AmazonOrdersVersionTableMap::buildTableMap();
