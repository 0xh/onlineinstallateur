<?php

namespace AmazonIntegration\Model\Map;

use AmazonIntegration\Model\AmazonOrders;
use AmazonIntegration\Model\AmazonOrdersQuery;
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
 * This class defines the structure of the 'amazon_orders' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class AmazonOrdersTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;
    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'AmazonIntegration.Model.Map.AmazonOrdersTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'thelia';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'amazon_orders';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\AmazonIntegration\\Model\\AmazonOrders';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'AmazonIntegration.Model.AmazonOrders';

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
    const ID = 'amazon_orders.ID';

    /**
     * the column name for the SELLER_ORDER_ID field
     */
    const SELLER_ORDER_ID = 'amazon_orders.SELLER_ORDER_ID';

    /**
     * the column name for the PURCHASE_DATE field
     */
    const PURCHASE_DATE = 'amazon_orders.PURCHASE_DATE';

    /**
     * the column name for the LAST_UPDATE_DATE field
     */
    const LAST_UPDATE_DATE = 'amazon_orders.LAST_UPDATE_DATE';

    /**
     * the column name for the ORDER_STATUS field
     */
    const ORDER_STATUS = 'amazon_orders.ORDER_STATUS';

    /**
     * the column name for the FULFILLMENT_CHANNEL field
     */
    const FULFILLMENT_CHANNEL = 'amazon_orders.FULFILLMENT_CHANNEL';

    /**
     * the column name for the SALES_CHANNEL field
     */
    const SALES_CHANNEL = 'amazon_orders.SALES_CHANNEL';

    /**
     * the column name for the ORDER_CHANNEL field
     */
    const ORDER_CHANNEL = 'amazon_orders.ORDER_CHANNEL';

    /**
     * the column name for the SHIP_SERVICE_LEVEL field
     */
    const SHIP_SERVICE_LEVEL = 'amazon_orders.SHIP_SERVICE_LEVEL';

    /**
     * the column name for the ORDER_TOTAL_CURRENCY_CODE field
     */
    const ORDER_TOTAL_CURRENCY_CODE = 'amazon_orders.ORDER_TOTAL_CURRENCY_CODE';

    /**
     * the column name for the ORDER_TOTAL_AMOUNT field
     */
    const ORDER_TOTAL_AMOUNT = 'amazon_orders.ORDER_TOTAL_AMOUNT';

    /**
     * the column name for the NUMBER_OF_ITEMS_SHIPPED field
     */
    const NUMBER_OF_ITEMS_SHIPPED = 'amazon_orders.NUMBER_OF_ITEMS_SHIPPED';

    /**
     * the column name for the NUMBER_OF_ITEMS_UNSHIPPED field
     */
    const NUMBER_OF_ITEMS_UNSHIPPED = 'amazon_orders.NUMBER_OF_ITEMS_UNSHIPPED';

    /**
     * the column name for the PAYMENT_EXECUTION_DETAIL_CURRENCY_CODE field
     */
    const PAYMENT_EXECUTION_DETAIL_CURRENCY_CODE = 'amazon_orders.PAYMENT_EXECUTION_DETAIL_CURRENCY_CODE';

    /**
     * the column name for the PAYMENT_EXECUTION_DETAIL_TOTAL_AMOUNT field
     */
    const PAYMENT_EXECUTION_DETAIL_TOTAL_AMOUNT = 'amazon_orders.PAYMENT_EXECUTION_DETAIL_TOTAL_AMOUNT';

    /**
     * the column name for the PAYMENT_EXECUTION_DETAIL_PAYMENT_METHOD field
     */
    const PAYMENT_EXECUTION_DETAIL_PAYMENT_METHOD = 'amazon_orders.PAYMENT_EXECUTION_DETAIL_PAYMENT_METHOD';

    /**
     * the column name for the PAYMENT_METHOD field
     */
    const PAYMENT_METHOD = 'amazon_orders.PAYMENT_METHOD';

    /**
     * the column name for the PAYMENT_METHOD_DETAIL field
     */
    const PAYMENT_METHOD_DETAIL = 'amazon_orders.PAYMENT_METHOD_DETAIL';

    /**
     * the column name for the MARKETPLACE_ID field
     */
    const MARKETPLACE_ID = 'amazon_orders.MARKETPLACE_ID';

    /**
     * the column name for the BUYER_COUNTY field
     */
    const BUYER_COUNTY = 'amazon_orders.BUYER_COUNTY';

    /**
     * the column name for the BUYER_TAX_INFO_COMPANY field
     */
    const BUYER_TAX_INFO_COMPANY = 'amazon_orders.BUYER_TAX_INFO_COMPANY';

    /**
     * the column name for the BUYER_TAX_INFO_TAXING_REGION field
     */
    const BUYER_TAX_INFO_TAXING_REGION = 'amazon_orders.BUYER_TAX_INFO_TAXING_REGION';

    /**
     * the column name for the BUYER_TAX_INFO_TAX_NAME field
     */
    const BUYER_TAX_INFO_TAX_NAME = 'amazon_orders.BUYER_TAX_INFO_TAX_NAME';

    /**
     * the column name for the BUYER_TAX_INFO_TAX_VALUE field
     */
    const BUYER_TAX_INFO_TAX_VALUE = 'amazon_orders.BUYER_TAX_INFO_TAX_VALUE';

    /**
     * the column name for the SHIPMENT_SERVICE_LEVEL_CATEGORY field
     */
    const SHIPMENT_SERVICE_LEVEL_CATEGORY = 'amazon_orders.SHIPMENT_SERVICE_LEVEL_CATEGORY';

    /**
     * the column name for the SHIPPED_BY_AMAZON_TFM field
     */
    const SHIPPED_BY_AMAZON_TFM = 'amazon_orders.SHIPPED_BY_AMAZON_TFM';

    /**
     * the column name for the TFM_SHIPMENT_STATUS field
     */
    const TFM_SHIPMENT_STATUS = 'amazon_orders.TFM_SHIPMENT_STATUS';

    /**
     * the column name for the CBA_DISPLAYABLE_SHIPPING_LABEL field
     */
    const CBA_DISPLAYABLE_SHIPPING_LABEL = 'amazon_orders.CBA_DISPLAYABLE_SHIPPING_LABEL';

    /**
     * the column name for the ORDER_TYPE field
     */
    const ORDER_TYPE = 'amazon_orders.ORDER_TYPE';

    /**
     * the column name for the EARLIEST_SHIP_DATE field
     */
    const EARLIEST_SHIP_DATE = 'amazon_orders.EARLIEST_SHIP_DATE';

    /**
     * the column name for the LATEST_SHIP_DATE field
     */
    const LATEST_SHIP_DATE = 'amazon_orders.LATEST_SHIP_DATE';

    /**
     * the column name for the EARLIEST_DELIVERY_DATE field
     */
    const EARLIEST_DELIVERY_DATE = 'amazon_orders.EARLIEST_DELIVERY_DATE';

    /**
     * the column name for the LATEST_DELIVERY_DATE field
     */
    const LATEST_DELIVERY_DATE = 'amazon_orders.LATEST_DELIVERY_DATE';

    /**
     * the column name for the IS_BUSINESS_ORDER field
     */
    const IS_BUSINESS_ORDER = 'amazon_orders.IS_BUSINESS_ORDER';

    /**
     * the column name for the PURCHASE_ORDER_NUMBER field
     */
    const PURCHASE_ORDER_NUMBER = 'amazon_orders.PURCHASE_ORDER_NUMBER';

    /**
     * the column name for the IS_PRIME field
     */
    const IS_PRIME = 'amazon_orders.IS_PRIME';

    /**
     * the column name for the IS_PREMIUM_ORDER field
     */
    const IS_PREMIUM_ORDER = 'amazon_orders.IS_PREMIUM_ORDER';

    /**
     * the column name for the REPLACED_ORDER_ID field
     */
    const REPLACED_ORDER_ID = 'amazon_orders.REPLACED_ORDER_ID';

    /**
     * the column name for the IS_REPLACEMENT_ORDER field
     */
    const IS_REPLACEMENT_ORDER = 'amazon_orders.IS_REPLACEMENT_ORDER';

    /**
     * the column name for the ORDER_ADDRESS_ID field
     */
    const ORDER_ADDRESS_ID = 'amazon_orders.ORDER_ADDRESS_ID';

    /**
     * the column name for the CUSTOMER_ID field
     */
    const CUSTOMER_ID = 'amazon_orders.CUSTOMER_ID';

    /**
     * the column name for the ORDER_ID field
     */
    const ORDER_ID = 'amazon_orders.ORDER_ID';

    /**
     * the column name for the CREATED_AT field
     */
    const CREATED_AT = 'amazon_orders.CREATED_AT';

    /**
     * the column name for the UPDATED_AT field
     */
    const UPDATED_AT = 'amazon_orders.UPDATED_AT';

    /**
     * the column name for the VERSION field
     */
    const VERSION = 'amazon_orders.VERSION';

    /**
     * the column name for the VERSION_CREATED_AT field
     */
    const VERSION_CREATED_AT = 'amazon_orders.VERSION_CREATED_AT';

    /**
     * the column name for the VERSION_CREATED_BY field
     */
    const VERSION_CREATED_BY = 'amazon_orders.VERSION_CREATED_BY';

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
        self::TYPE_COLNAME       => array(AmazonOrdersTableMap::ID, AmazonOrdersTableMap::SELLER_ORDER_ID, AmazonOrdersTableMap::PURCHASE_DATE, AmazonOrdersTableMap::LAST_UPDATE_DATE, AmazonOrdersTableMap::ORDER_STATUS, AmazonOrdersTableMap::FULFILLMENT_CHANNEL, AmazonOrdersTableMap::SALES_CHANNEL, AmazonOrdersTableMap::ORDER_CHANNEL, AmazonOrdersTableMap::SHIP_SERVICE_LEVEL, AmazonOrdersTableMap::ORDER_TOTAL_CURRENCY_CODE, AmazonOrdersTableMap::ORDER_TOTAL_AMOUNT, AmazonOrdersTableMap::NUMBER_OF_ITEMS_SHIPPED, AmazonOrdersTableMap::NUMBER_OF_ITEMS_UNSHIPPED, AmazonOrdersTableMap::PAYMENT_EXECUTION_DETAIL_CURRENCY_CODE, AmazonOrdersTableMap::PAYMENT_EXECUTION_DETAIL_TOTAL_AMOUNT, AmazonOrdersTableMap::PAYMENT_EXECUTION_DETAIL_PAYMENT_METHOD, AmazonOrdersTableMap::PAYMENT_METHOD, AmazonOrdersTableMap::PAYMENT_METHOD_DETAIL, AmazonOrdersTableMap::MARKETPLACE_ID, AmazonOrdersTableMap::BUYER_COUNTY, AmazonOrdersTableMap::BUYER_TAX_INFO_COMPANY, AmazonOrdersTableMap::BUYER_TAX_INFO_TAXING_REGION, AmazonOrdersTableMap::BUYER_TAX_INFO_TAX_NAME, AmazonOrdersTableMap::BUYER_TAX_INFO_TAX_VALUE, AmazonOrdersTableMap::SHIPMENT_SERVICE_LEVEL_CATEGORY, AmazonOrdersTableMap::SHIPPED_BY_AMAZON_TFM, AmazonOrdersTableMap::TFM_SHIPMENT_STATUS, AmazonOrdersTableMap::CBA_DISPLAYABLE_SHIPPING_LABEL, AmazonOrdersTableMap::ORDER_TYPE, AmazonOrdersTableMap::EARLIEST_SHIP_DATE, AmazonOrdersTableMap::LATEST_SHIP_DATE, AmazonOrdersTableMap::EARLIEST_DELIVERY_DATE, AmazonOrdersTableMap::LATEST_DELIVERY_DATE, AmazonOrdersTableMap::IS_BUSINESS_ORDER, AmazonOrdersTableMap::PURCHASE_ORDER_NUMBER, AmazonOrdersTableMap::IS_PRIME, AmazonOrdersTableMap::IS_PREMIUM_ORDER, AmazonOrdersTableMap::REPLACED_ORDER_ID, AmazonOrdersTableMap::IS_REPLACEMENT_ORDER, AmazonOrdersTableMap::ORDER_ADDRESS_ID, AmazonOrdersTableMap::CUSTOMER_ID, AmazonOrdersTableMap::ORDER_ID, AmazonOrdersTableMap::CREATED_AT, AmazonOrdersTableMap::UPDATED_AT, AmazonOrdersTableMap::VERSION, AmazonOrdersTableMap::VERSION_CREATED_AT, AmazonOrdersTableMap::VERSION_CREATED_BY, ),
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
        self::TYPE_COLNAME       => array(AmazonOrdersTableMap::ID => 0, AmazonOrdersTableMap::SELLER_ORDER_ID => 1, AmazonOrdersTableMap::PURCHASE_DATE => 2, AmazonOrdersTableMap::LAST_UPDATE_DATE => 3, AmazonOrdersTableMap::ORDER_STATUS => 4, AmazonOrdersTableMap::FULFILLMENT_CHANNEL => 5, AmazonOrdersTableMap::SALES_CHANNEL => 6, AmazonOrdersTableMap::ORDER_CHANNEL => 7, AmazonOrdersTableMap::SHIP_SERVICE_LEVEL => 8, AmazonOrdersTableMap::ORDER_TOTAL_CURRENCY_CODE => 9, AmazonOrdersTableMap::ORDER_TOTAL_AMOUNT => 10, AmazonOrdersTableMap::NUMBER_OF_ITEMS_SHIPPED => 11, AmazonOrdersTableMap::NUMBER_OF_ITEMS_UNSHIPPED => 12, AmazonOrdersTableMap::PAYMENT_EXECUTION_DETAIL_CURRENCY_CODE => 13, AmazonOrdersTableMap::PAYMENT_EXECUTION_DETAIL_TOTAL_AMOUNT => 14, AmazonOrdersTableMap::PAYMENT_EXECUTION_DETAIL_PAYMENT_METHOD => 15, AmazonOrdersTableMap::PAYMENT_METHOD => 16, AmazonOrdersTableMap::PAYMENT_METHOD_DETAIL => 17, AmazonOrdersTableMap::MARKETPLACE_ID => 18, AmazonOrdersTableMap::BUYER_COUNTY => 19, AmazonOrdersTableMap::BUYER_TAX_INFO_COMPANY => 20, AmazonOrdersTableMap::BUYER_TAX_INFO_TAXING_REGION => 21, AmazonOrdersTableMap::BUYER_TAX_INFO_TAX_NAME => 22, AmazonOrdersTableMap::BUYER_TAX_INFO_TAX_VALUE => 23, AmazonOrdersTableMap::SHIPMENT_SERVICE_LEVEL_CATEGORY => 24, AmazonOrdersTableMap::SHIPPED_BY_AMAZON_TFM => 25, AmazonOrdersTableMap::TFM_SHIPMENT_STATUS => 26, AmazonOrdersTableMap::CBA_DISPLAYABLE_SHIPPING_LABEL => 27, AmazonOrdersTableMap::ORDER_TYPE => 28, AmazonOrdersTableMap::EARLIEST_SHIP_DATE => 29, AmazonOrdersTableMap::LATEST_SHIP_DATE => 30, AmazonOrdersTableMap::EARLIEST_DELIVERY_DATE => 31, AmazonOrdersTableMap::LATEST_DELIVERY_DATE => 32, AmazonOrdersTableMap::IS_BUSINESS_ORDER => 33, AmazonOrdersTableMap::PURCHASE_ORDER_NUMBER => 34, AmazonOrdersTableMap::IS_PRIME => 35, AmazonOrdersTableMap::IS_PREMIUM_ORDER => 36, AmazonOrdersTableMap::REPLACED_ORDER_ID => 37, AmazonOrdersTableMap::IS_REPLACEMENT_ORDER => 38, AmazonOrdersTableMap::ORDER_ADDRESS_ID => 39, AmazonOrdersTableMap::CUSTOMER_ID => 40, AmazonOrdersTableMap::ORDER_ID => 41, AmazonOrdersTableMap::CREATED_AT => 42, AmazonOrdersTableMap::UPDATED_AT => 43, AmazonOrdersTableMap::VERSION => 44, AmazonOrdersTableMap::VERSION_CREATED_AT => 45, AmazonOrdersTableMap::VERSION_CREATED_BY => 46, ),
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
        $this->setName('amazon_orders');
        $this->setPhpName('AmazonOrders');
        $this->setClassName('\\AmazonIntegration\\Model\\AmazonOrders');
        $this->setPackage('AmazonIntegration.Model');
        $this->setUseIdGenerator(false);
        // columns
        $this->addPrimaryKey('ID', 'Id', 'VARCHAR', true, 45, null);
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
        $this->addForeignKey('ORDER_ADDRESS_ID', 'OrderAddressId', 'INTEGER', 'order_address', 'ID', false, null, null);
        $this->addForeignKey('CUSTOMER_ID', 'CustomerId', 'INTEGER', 'customer', 'ID', false, null, null);
        $this->addForeignKey('ORDER_ID', 'OrderId', 'INTEGER', 'order', 'ID', false, null, null);
        $this->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('UPDATED_AT', 'UpdatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('VERSION', 'Version', 'INTEGER', false, null, 0);
        $this->addColumn('VERSION_CREATED_AT', 'VersionCreatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('VERSION_CREATED_BY', 'VersionCreatedBy', 'VARCHAR', false, 100, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Customer', '\\AmazonIntegration\\Model\\Customer', RelationMap::MANY_TO_ONE, array('customer_id' => 'id', ), 'CASCADE', null);
        $this->addRelation('OrderAddress', '\\AmazonIntegration\\Model\\OrderAddress', RelationMap::MANY_TO_ONE, array('order_address_id' => 'id', ), 'CASCADE', null);
        $this->addRelation('Order', '\\AmazonIntegration\\Model\\Order', RelationMap::MANY_TO_ONE, array('order_id' => 'id', ), 'CASCADE', null);
        $this->addRelation('AmazonOrdersVersion', '\\AmazonIntegration\\Model\\AmazonOrdersVersion', RelationMap::ONE_TO_MANY, array('id' => 'id', ), 'CASCADE', null, 'AmazonOrdersVersions');
    } // buildRelations()

    /**
     *
     * Gets the list of behaviors registered for this table
     *
     * @return array Associative array (name => parameters) of behaviors
     */
    public function getBehaviors()
    {
        return array(
            'timestampable' => array('create_column' => 'created_at', 'update_column' => 'updated_at', ),
            'versionable' => array('version_column' => 'version', 'version_table' => '', 'log_created_at' => 'true', 'log_created_by' => 'true', 'log_comment' => 'false', 'version_created_at_column' => 'version_created_at', 'version_created_by_column' => 'version_created_by', 'version_comment_column' => 'version_comment', ),
        );
    } // getBehaviors()
    /**
     * Method to invalidate the instance pool of all tables related to amazon_orders     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
        // Invalidate objects in ".$this->getClassNameFromBuilder($joinedTableTableMapBuilder)." instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
                AmazonOrdersVersionTableMap::clearInstancePool();
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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
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

            return (string) $row[
                            $indexType == TableMap::TYPE_NUM
                            ? 0 + $offset
                            : self::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)
                        ];
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
        return $withPrefix ? AmazonOrdersTableMap::CLASS_DEFAULT : AmazonOrdersTableMap::OM_CLASS;
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
     * @return array (AmazonOrders object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = AmazonOrdersTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = AmazonOrdersTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + AmazonOrdersTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = AmazonOrdersTableMap::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            AmazonOrdersTableMap::addInstanceToPool($obj, $key);
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
            $key = AmazonOrdersTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = AmazonOrdersTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                AmazonOrdersTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(AmazonOrdersTableMap::ID);
            $criteria->addSelectColumn(AmazonOrdersTableMap::SELLER_ORDER_ID);
            $criteria->addSelectColumn(AmazonOrdersTableMap::PURCHASE_DATE);
            $criteria->addSelectColumn(AmazonOrdersTableMap::LAST_UPDATE_DATE);
            $criteria->addSelectColumn(AmazonOrdersTableMap::ORDER_STATUS);
            $criteria->addSelectColumn(AmazonOrdersTableMap::FULFILLMENT_CHANNEL);
            $criteria->addSelectColumn(AmazonOrdersTableMap::SALES_CHANNEL);
            $criteria->addSelectColumn(AmazonOrdersTableMap::ORDER_CHANNEL);
            $criteria->addSelectColumn(AmazonOrdersTableMap::SHIP_SERVICE_LEVEL);
            $criteria->addSelectColumn(AmazonOrdersTableMap::ORDER_TOTAL_CURRENCY_CODE);
            $criteria->addSelectColumn(AmazonOrdersTableMap::ORDER_TOTAL_AMOUNT);
            $criteria->addSelectColumn(AmazonOrdersTableMap::NUMBER_OF_ITEMS_SHIPPED);
            $criteria->addSelectColumn(AmazonOrdersTableMap::NUMBER_OF_ITEMS_UNSHIPPED);
            $criteria->addSelectColumn(AmazonOrdersTableMap::PAYMENT_EXECUTION_DETAIL_CURRENCY_CODE);
            $criteria->addSelectColumn(AmazonOrdersTableMap::PAYMENT_EXECUTION_DETAIL_TOTAL_AMOUNT);
            $criteria->addSelectColumn(AmazonOrdersTableMap::PAYMENT_EXECUTION_DETAIL_PAYMENT_METHOD);
            $criteria->addSelectColumn(AmazonOrdersTableMap::PAYMENT_METHOD);
            $criteria->addSelectColumn(AmazonOrdersTableMap::PAYMENT_METHOD_DETAIL);
            $criteria->addSelectColumn(AmazonOrdersTableMap::MARKETPLACE_ID);
            $criteria->addSelectColumn(AmazonOrdersTableMap::BUYER_COUNTY);
            $criteria->addSelectColumn(AmazonOrdersTableMap::BUYER_TAX_INFO_COMPANY);
            $criteria->addSelectColumn(AmazonOrdersTableMap::BUYER_TAX_INFO_TAXING_REGION);
            $criteria->addSelectColumn(AmazonOrdersTableMap::BUYER_TAX_INFO_TAX_NAME);
            $criteria->addSelectColumn(AmazonOrdersTableMap::BUYER_TAX_INFO_TAX_VALUE);
            $criteria->addSelectColumn(AmazonOrdersTableMap::SHIPMENT_SERVICE_LEVEL_CATEGORY);
            $criteria->addSelectColumn(AmazonOrdersTableMap::SHIPPED_BY_AMAZON_TFM);
            $criteria->addSelectColumn(AmazonOrdersTableMap::TFM_SHIPMENT_STATUS);
            $criteria->addSelectColumn(AmazonOrdersTableMap::CBA_DISPLAYABLE_SHIPPING_LABEL);
            $criteria->addSelectColumn(AmazonOrdersTableMap::ORDER_TYPE);
            $criteria->addSelectColumn(AmazonOrdersTableMap::EARLIEST_SHIP_DATE);
            $criteria->addSelectColumn(AmazonOrdersTableMap::LATEST_SHIP_DATE);
            $criteria->addSelectColumn(AmazonOrdersTableMap::EARLIEST_DELIVERY_DATE);
            $criteria->addSelectColumn(AmazonOrdersTableMap::LATEST_DELIVERY_DATE);
            $criteria->addSelectColumn(AmazonOrdersTableMap::IS_BUSINESS_ORDER);
            $criteria->addSelectColumn(AmazonOrdersTableMap::PURCHASE_ORDER_NUMBER);
            $criteria->addSelectColumn(AmazonOrdersTableMap::IS_PRIME);
            $criteria->addSelectColumn(AmazonOrdersTableMap::IS_PREMIUM_ORDER);
            $criteria->addSelectColumn(AmazonOrdersTableMap::REPLACED_ORDER_ID);
            $criteria->addSelectColumn(AmazonOrdersTableMap::IS_REPLACEMENT_ORDER);
            $criteria->addSelectColumn(AmazonOrdersTableMap::ORDER_ADDRESS_ID);
            $criteria->addSelectColumn(AmazonOrdersTableMap::CUSTOMER_ID);
            $criteria->addSelectColumn(AmazonOrdersTableMap::ORDER_ID);
            $criteria->addSelectColumn(AmazonOrdersTableMap::CREATED_AT);
            $criteria->addSelectColumn(AmazonOrdersTableMap::UPDATED_AT);
            $criteria->addSelectColumn(AmazonOrdersTableMap::VERSION);
            $criteria->addSelectColumn(AmazonOrdersTableMap::VERSION_CREATED_AT);
            $criteria->addSelectColumn(AmazonOrdersTableMap::VERSION_CREATED_BY);
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
        return Propel::getServiceContainer()->getDatabaseMap(AmazonOrdersTableMap::DATABASE_NAME)->getTable(AmazonOrdersTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getServiceContainer()->getDatabaseMap(AmazonOrdersTableMap::DATABASE_NAME);
      if (!$dbMap->hasTable(AmazonOrdersTableMap::TABLE_NAME)) {
        $dbMap->addTableObject(new AmazonOrdersTableMap());
      }
    }

    /**
     * Performs a DELETE on the database, given a AmazonOrders or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or AmazonOrders object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(AmazonOrdersTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \AmazonIntegration\Model\AmazonOrders) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(AmazonOrdersTableMap::DATABASE_NAME);
            $criteria->add(AmazonOrdersTableMap::ID, (array) $values, Criteria::IN);
        }

        $query = AmazonOrdersQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) { AmazonOrdersTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) { AmazonOrdersTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the amazon_orders table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return AmazonOrdersQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a AmazonOrders or Criteria object.
     *
     * @param mixed               $criteria Criteria or AmazonOrders object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(AmazonOrdersTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from AmazonOrders object
        }


        // Set the correct dbName
        $query = AmazonOrdersQuery::create()->mergeWith($criteria);

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

} // AmazonOrdersTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
AmazonOrdersTableMap::buildTableMap();
