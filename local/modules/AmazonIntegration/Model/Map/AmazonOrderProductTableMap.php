<?php

namespace AmazonIntegration\Model\Map;

use AmazonIntegration\Model\AmazonOrderProduct;
use AmazonIntegration\Model\AmazonOrderProductQuery;
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
 * This class defines the structure of the 'amazon_order_product' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class AmazonOrderProductTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;
    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'AmazonIntegration.Model.Map.AmazonOrderProductTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'thelia';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'amazon_order_product';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\AmazonIntegration\\Model\\AmazonOrderProduct';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'AmazonIntegration.Model.AmazonOrderProduct';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 50;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 50;

    /**
     * the column name for the ORDER_ITEM_ID field
     */
    const ORDER_ITEM_ID = 'amazon_order_product.ORDER_ITEM_ID';

    /**
     * the column name for the AMAZON_ORDER_ID field
     */
    const AMAZON_ORDER_ID = 'amazon_order_product.AMAZON_ORDER_ID';

    /**
     * the column name for the ASIN field
     */
    const ASIN = 'amazon_order_product.ASIN';

    /**
     * the column name for the SELLER_SKU field
     */
    const SELLER_SKU = 'amazon_order_product.SELLER_SKU';

    /**
     * the column name for the TITLE field
     */
    const TITLE = 'amazon_order_product.TITLE';

    /**
     * the column name for the QUANTITY_ORDERED field
     */
    const QUANTITY_ORDERED = 'amazon_order_product.QUANTITY_ORDERED';

    /**
     * the column name for the QUANTITY_SHIPPED field
     */
    const QUANTITY_SHIPPED = 'amazon_order_product.QUANTITY_SHIPPED';

    /**
     * the column name for the POINTS_GRANTED_NUMBER field
     */
    const POINTS_GRANTED_NUMBER = 'amazon_order_product.POINTS_GRANTED_NUMBER';

    /**
     * the column name for the POINTS_GRANTED_CURRENCY_CODE field
     */
    const POINTS_GRANTED_CURRENCY_CODE = 'amazon_order_product.POINTS_GRANTED_CURRENCY_CODE';

    /**
     * the column name for the POINTS_GRANTED_AMOUNT field
     */
    const POINTS_GRANTED_AMOUNT = 'amazon_order_product.POINTS_GRANTED_AMOUNT';

    /**
     * the column name for the ITEM_PRICE_CURRENCY_CODE field
     */
    const ITEM_PRICE_CURRENCY_CODE = 'amazon_order_product.ITEM_PRICE_CURRENCY_CODE';

    /**
     * the column name for the ITEM_PRICE_AMOUNT field
     */
    const ITEM_PRICE_AMOUNT = 'amazon_order_product.ITEM_PRICE_AMOUNT';

    /**
     * the column name for the SHIPPING_PRICE_CURRENCY_CODE field
     */
    const SHIPPING_PRICE_CURRENCY_CODE = 'amazon_order_product.SHIPPING_PRICE_CURRENCY_CODE';

    /**
     * the column name for the SHIPPING_PRICE_AMOUNT field
     */
    const SHIPPING_PRICE_AMOUNT = 'amazon_order_product.SHIPPING_PRICE_AMOUNT';

    /**
     * the column name for the GIFT_WRAP_PRICE_CURRENCY_CODE field
     */
    const GIFT_WRAP_PRICE_CURRENCY_CODE = 'amazon_order_product.GIFT_WRAP_PRICE_CURRENCY_CODE';

    /**
     * the column name for the GIFT_WRAP_PRICE_AMOUNT field
     */
    const GIFT_WRAP_PRICE_AMOUNT = 'amazon_order_product.GIFT_WRAP_PRICE_AMOUNT';

    /**
     * the column name for the ITEM_TAX_CURRENCY_CODE field
     */
    const ITEM_TAX_CURRENCY_CODE = 'amazon_order_product.ITEM_TAX_CURRENCY_CODE';

    /**
     * the column name for the ITEM_TAX_AMOUNT field
     */
    const ITEM_TAX_AMOUNT = 'amazon_order_product.ITEM_TAX_AMOUNT';

    /**
     * the column name for the SHIPPING_TAX_CURRENCY_CODE field
     */
    const SHIPPING_TAX_CURRENCY_CODE = 'amazon_order_product.SHIPPING_TAX_CURRENCY_CODE';

    /**
     * the column name for the SHIPPING_TAX_AMOUNT field
     */
    const SHIPPING_TAX_AMOUNT = 'amazon_order_product.SHIPPING_TAX_AMOUNT';

    /**
     * the column name for the GIFT_WRAP_TAX_CURRENCY_CODE field
     */
    const GIFT_WRAP_TAX_CURRENCY_CODE = 'amazon_order_product.GIFT_WRAP_TAX_CURRENCY_CODE';

    /**
     * the column name for the GIFT_WRAP_TAX_AMOUNT field
     */
    const GIFT_WRAP_TAX_AMOUNT = 'amazon_order_product.GIFT_WRAP_TAX_AMOUNT';

    /**
     * the column name for the SHIPPING_DISCOUNT_CURRENCY_CODE field
     */
    const SHIPPING_DISCOUNT_CURRENCY_CODE = 'amazon_order_product.SHIPPING_DISCOUNT_CURRENCY_CODE';

    /**
     * the column name for the SHIPPING_DISCOUNT_AMOUNT field
     */
    const SHIPPING_DISCOUNT_AMOUNT = 'amazon_order_product.SHIPPING_DISCOUNT_AMOUNT';

    /**
     * the column name for the PROMOTION_DISCOUNT_CURRENCY_CODE field
     */
    const PROMOTION_DISCOUNT_CURRENCY_CODE = 'amazon_order_product.PROMOTION_DISCOUNT_CURRENCY_CODE';

    /**
     * the column name for the PROMOTION_DISCOUNT_AMOUNT field
     */
    const PROMOTION_DISCOUNT_AMOUNT = 'amazon_order_product.PROMOTION_DISCOUNT_AMOUNT';

    /**
     * the column name for the PROMOTION_ID field
     */
    const PROMOTION_ID = 'amazon_order_product.PROMOTION_ID';

    /**
     * the column name for the COD_FEE_CURRENCY_CODE field
     */
    const COD_FEE_CURRENCY_CODE = 'amazon_order_product.COD_FEE_CURRENCY_CODE';

    /**
     * the column name for the COD_FEE_AMOUNT field
     */
    const COD_FEE_AMOUNT = 'amazon_order_product.COD_FEE_AMOUNT';

    /**
     * the column name for the COD_FEE_DISCOUNT_CURRENCY_CODE field
     */
    const COD_FEE_DISCOUNT_CURRENCY_CODE = 'amazon_order_product.COD_FEE_DISCOUNT_CURRENCY_CODE';

    /**
     * the column name for the COD_FEE_DISCOUNT_AMOUNT field
     */
    const COD_FEE_DISCOUNT_AMOUNT = 'amazon_order_product.COD_FEE_DISCOUNT_AMOUNT';

    /**
     * the column name for the GIFT_MESSAGE_TEXT field
     */
    const GIFT_MESSAGE_TEXT = 'amazon_order_product.GIFT_MESSAGE_TEXT';

    /**
     * the column name for the GIFT_WRAP_LEVEL field
     */
    const GIFT_WRAP_LEVEL = 'amazon_order_product.GIFT_WRAP_LEVEL';

    /**
     * the column name for the INVOICE_REQUIREMENT field
     */
    const INVOICE_REQUIREMENT = 'amazon_order_product.INVOICE_REQUIREMENT';

    /**
     * the column name for the BUYER_SELECTED_INVOICE_CATEGORY field
     */
    const BUYER_SELECTED_INVOICE_CATEGORY = 'amazon_order_product.BUYER_SELECTED_INVOICE_CATEGORY';

    /**
     * the column name for the INVOICE_TITLE field
     */
    const INVOICE_TITLE = 'amazon_order_product.INVOICE_TITLE';

    /**
     * the column name for the INVOICE_INFORMATION field
     */
    const INVOICE_INFORMATION = 'amazon_order_product.INVOICE_INFORMATION';

    /**
     * the column name for the CONDITION_NOTE field
     */
    const CONDITION_NOTE = 'amazon_order_product.CONDITION_NOTE';

    /**
     * the column name for the CONDITION_ID field
     */
    const CONDITION_ID = 'amazon_order_product.CONDITION_ID';

    /**
     * the column name for the CONDITION_SUBTYPE_ID field
     */
    const CONDITION_SUBTYPE_ID = 'amazon_order_product.CONDITION_SUBTYPE_ID';

    /**
     * the column name for the SCHEDULE_DELIVERY_START_DATE field
     */
    const SCHEDULE_DELIVERY_START_DATE = 'amazon_order_product.SCHEDULE_DELIVERY_START_DATE';

    /**
     * the column name for the SCHEDULE_DELIVERY_END_DATE field
     */
    const SCHEDULE_DELIVERY_END_DATE = 'amazon_order_product.SCHEDULE_DELIVERY_END_DATE';

    /**
     * the column name for the PRICE_DESIGNATION field
     */
    const PRICE_DESIGNATION = 'amazon_order_product.PRICE_DESIGNATION';

    /**
     * the column name for the BUYER_CUSTOMIZED_URL field
     */
    const BUYER_CUSTOMIZED_URL = 'amazon_order_product.BUYER_CUSTOMIZED_URL';

    /**
     * the column name for the ORDER_PRODUCT_ID field
     */
    const ORDER_PRODUCT_ID = 'amazon_order_product.ORDER_PRODUCT_ID';

    /**
     * the column name for the CREATED_AT field
     */
    const CREATED_AT = 'amazon_order_product.CREATED_AT';

    /**
     * the column name for the UPDATED_AT field
     */
    const UPDATED_AT = 'amazon_order_product.UPDATED_AT';

    /**
     * the column name for the VERSION field
     */
    const VERSION = 'amazon_order_product.VERSION';

    /**
     * the column name for the VERSION_CREATED_AT field
     */
    const VERSION_CREATED_AT = 'amazon_order_product.VERSION_CREATED_AT';

    /**
     * the column name for the VERSION_CREATED_BY field
     */
    const VERSION_CREATED_BY = 'amazon_order_product.VERSION_CREATED_BY';

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
        self::TYPE_PHPNAME       => array('OrderItemId', 'AmazonOrderId', 'Asin', 'SellerSku', 'Title', 'QuantityOrdered', 'QuantityShipped', 'PointsGrantedNumber', 'PointsGrantedCurrencyCode', 'PointsGrantedAmount', 'ItemPriceCurrencyCode', 'ItemPriceAmount', 'ShippingPriceCurrencyCode', 'ShippingPriceAmount', 'GiftWrapPriceCurrencyCode', 'GiftWrapPriceAmount', 'ItemTaxCurrencyCode', 'ItemTaxAmount', 'ShippingTaxCurrencyCode', 'ShippingTaxAmount', 'GiftWrapTaxCurrencyCode', 'GiftWrapTaxAmount', 'ShippingDiscountCurrencyCode', 'ShippingDiscountAmount', 'PromotionDiscountCurrencyCode', 'PromotionDiscountAmount', 'PromotionId', 'CodFeeCurrencyCode', 'CodFeeAmount', 'CodFeeDiscountCurrencyCode', 'CodFeeDiscountAmount', 'GiftMessageText', 'GiftWrapLevel', 'InvoiceRequirement', 'BuyerSelectedInvoiceCategory', 'InvoiceTitle', 'InvoiceInformation', 'ConditionNote', 'ConditionId', 'ConditionSubtypeId', 'ScheduledDeliveryStartDate', 'ScheduledDeliveryEndDate', 'PriceDesignation', 'BuyerCustomizedURL', 'OrderProductId', 'CreatedAt', 'UpdatedAt', 'Version', 'VersionCreatedAt', 'VersionCreatedBy', ),
        self::TYPE_STUDLYPHPNAME => array('orderItemId', 'amazonOrderId', 'asin', 'sellerSku', 'title', 'quantityOrdered', 'quantityShipped', 'pointsGrantedNumber', 'pointsGrantedCurrencyCode', 'pointsGrantedAmount', 'itemPriceCurrencyCode', 'itemPriceAmount', 'shippingPriceCurrencyCode', 'shippingPriceAmount', 'giftWrapPriceCurrencyCode', 'giftWrapPriceAmount', 'itemTaxCurrencyCode', 'itemTaxAmount', 'shippingTaxCurrencyCode', 'shippingTaxAmount', 'giftWrapTaxCurrencyCode', 'giftWrapTaxAmount', 'shippingDiscountCurrencyCode', 'shippingDiscountAmount', 'promotionDiscountCurrencyCode', 'promotionDiscountAmount', 'promotionId', 'codFeeCurrencyCode', 'codFeeAmount', 'codFeeDiscountCurrencyCode', 'codFeeDiscountAmount', 'giftMessageText', 'giftWrapLevel', 'invoiceRequirement', 'buyerSelectedInvoiceCategory', 'invoiceTitle', 'invoiceInformation', 'conditionNote', 'conditionId', 'conditionSubtypeId', 'scheduledDeliveryStartDate', 'scheduledDeliveryEndDate', 'priceDesignation', 'buyerCustomizedURL', 'orderProductId', 'createdAt', 'updatedAt', 'version', 'versionCreatedAt', 'versionCreatedBy', ),
        self::TYPE_COLNAME       => array(AmazonOrderProductTableMap::ORDER_ITEM_ID, AmazonOrderProductTableMap::AMAZON_ORDER_ID, AmazonOrderProductTableMap::ASIN, AmazonOrderProductTableMap::SELLER_SKU, AmazonOrderProductTableMap::TITLE, AmazonOrderProductTableMap::QUANTITY_ORDERED, AmazonOrderProductTableMap::QUANTITY_SHIPPED, AmazonOrderProductTableMap::POINTS_GRANTED_NUMBER, AmazonOrderProductTableMap::POINTS_GRANTED_CURRENCY_CODE, AmazonOrderProductTableMap::POINTS_GRANTED_AMOUNT, AmazonOrderProductTableMap::ITEM_PRICE_CURRENCY_CODE, AmazonOrderProductTableMap::ITEM_PRICE_AMOUNT, AmazonOrderProductTableMap::SHIPPING_PRICE_CURRENCY_CODE, AmazonOrderProductTableMap::SHIPPING_PRICE_AMOUNT, AmazonOrderProductTableMap::GIFT_WRAP_PRICE_CURRENCY_CODE, AmazonOrderProductTableMap::GIFT_WRAP_PRICE_AMOUNT, AmazonOrderProductTableMap::ITEM_TAX_CURRENCY_CODE, AmazonOrderProductTableMap::ITEM_TAX_AMOUNT, AmazonOrderProductTableMap::SHIPPING_TAX_CURRENCY_CODE, AmazonOrderProductTableMap::SHIPPING_TAX_AMOUNT, AmazonOrderProductTableMap::GIFT_WRAP_TAX_CURRENCY_CODE, AmazonOrderProductTableMap::GIFT_WRAP_TAX_AMOUNT, AmazonOrderProductTableMap::SHIPPING_DISCOUNT_CURRENCY_CODE, AmazonOrderProductTableMap::SHIPPING_DISCOUNT_AMOUNT, AmazonOrderProductTableMap::PROMOTION_DISCOUNT_CURRENCY_CODE, AmazonOrderProductTableMap::PROMOTION_DISCOUNT_AMOUNT, AmazonOrderProductTableMap::PROMOTION_ID, AmazonOrderProductTableMap::COD_FEE_CURRENCY_CODE, AmazonOrderProductTableMap::COD_FEE_AMOUNT, AmazonOrderProductTableMap::COD_FEE_DISCOUNT_CURRENCY_CODE, AmazonOrderProductTableMap::COD_FEE_DISCOUNT_AMOUNT, AmazonOrderProductTableMap::GIFT_MESSAGE_TEXT, AmazonOrderProductTableMap::GIFT_WRAP_LEVEL, AmazonOrderProductTableMap::INVOICE_REQUIREMENT, AmazonOrderProductTableMap::BUYER_SELECTED_INVOICE_CATEGORY, AmazonOrderProductTableMap::INVOICE_TITLE, AmazonOrderProductTableMap::INVOICE_INFORMATION, AmazonOrderProductTableMap::CONDITION_NOTE, AmazonOrderProductTableMap::CONDITION_ID, AmazonOrderProductTableMap::CONDITION_SUBTYPE_ID, AmazonOrderProductTableMap::SCHEDULE_DELIVERY_START_DATE, AmazonOrderProductTableMap::SCHEDULE_DELIVERY_END_DATE, AmazonOrderProductTableMap::PRICE_DESIGNATION, AmazonOrderProductTableMap::BUYER_CUSTOMIZED_URL, AmazonOrderProductTableMap::ORDER_PRODUCT_ID, AmazonOrderProductTableMap::CREATED_AT, AmazonOrderProductTableMap::UPDATED_AT, AmazonOrderProductTableMap::VERSION, AmazonOrderProductTableMap::VERSION_CREATED_AT, AmazonOrderProductTableMap::VERSION_CREATED_BY, ),
        self::TYPE_RAW_COLNAME   => array('ORDER_ITEM_ID', 'AMAZON_ORDER_ID', 'ASIN', 'SELLER_SKU', 'TITLE', 'QUANTITY_ORDERED', 'QUANTITY_SHIPPED', 'POINTS_GRANTED_NUMBER', 'POINTS_GRANTED_CURRENCY_CODE', 'POINTS_GRANTED_AMOUNT', 'ITEM_PRICE_CURRENCY_CODE', 'ITEM_PRICE_AMOUNT', 'SHIPPING_PRICE_CURRENCY_CODE', 'SHIPPING_PRICE_AMOUNT', 'GIFT_WRAP_PRICE_CURRENCY_CODE', 'GIFT_WRAP_PRICE_AMOUNT', 'ITEM_TAX_CURRENCY_CODE', 'ITEM_TAX_AMOUNT', 'SHIPPING_TAX_CURRENCY_CODE', 'SHIPPING_TAX_AMOUNT', 'GIFT_WRAP_TAX_CURRENCY_CODE', 'GIFT_WRAP_TAX_AMOUNT', 'SHIPPING_DISCOUNT_CURRENCY_CODE', 'SHIPPING_DISCOUNT_AMOUNT', 'PROMOTION_DISCOUNT_CURRENCY_CODE', 'PROMOTION_DISCOUNT_AMOUNT', 'PROMOTION_ID', 'COD_FEE_CURRENCY_CODE', 'COD_FEE_AMOUNT', 'COD_FEE_DISCOUNT_CURRENCY_CODE', 'COD_FEE_DISCOUNT_AMOUNT', 'GIFT_MESSAGE_TEXT', 'GIFT_WRAP_LEVEL', 'INVOICE_REQUIREMENT', 'BUYER_SELECTED_INVOICE_CATEGORY', 'INVOICE_TITLE', 'INVOICE_INFORMATION', 'CONDITION_NOTE', 'CONDITION_ID', 'CONDITION_SUBTYPE_ID', 'SCHEDULE_DELIVERY_START_DATE', 'SCHEDULE_DELIVERY_END_DATE', 'PRICE_DESIGNATION', 'BUYER_CUSTOMIZED_URL', 'ORDER_PRODUCT_ID', 'CREATED_AT', 'UPDATED_AT', 'VERSION', 'VERSION_CREATED_AT', 'VERSION_CREATED_BY', ),
        self::TYPE_FIELDNAME     => array('order_item_id', 'amazon_order_id', 'asin', 'seller_sku', 'title', 'quantity_ordered', 'quantity_shipped', 'points_granted_number', 'points_granted_currency_code', 'points_granted_amount', 'item_price_currency_code', 'item_price_amount', 'shipping_price_currency_code', 'shipping_price_amount', 'gift_wrap_price_currency_code', 'gift_wrap_price_amount', 'item_tax_currency_code', 'item_tax_amount', 'shipping_tax_currency_code', 'shipping_tax_amount', 'gift_wrap_tax_currency_code', 'gift_wrap_tax_amount', 'shipping_discount_currency_code', 'shipping_discount_amount', 'promotion_discount_currency_code', 'promotion_discount_amount', 'promotion_id', 'cod_fee_currency_code', 'cod_fee_amount', 'cod_fee_discount_currency_code', 'cod_fee_discount_amount', 'gift_message_text', 'gift_wrap_level', 'invoice_requirement', 'buyer_selected_invoice_category', 'invoice_title', 'invoice_information', 'condition_note', 'condition_id', 'condition_subtype_id', 'schedule_delivery_start_date', 'schedule_delivery_end_date', 'price_designation', 'buyer_customized_url', 'order_product_id', 'created_at', 'updated_at', 'version', 'version_created_at', 'version_created_by', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('OrderItemId' => 0, 'AmazonOrderId' => 1, 'Asin' => 2, 'SellerSku' => 3, 'Title' => 4, 'QuantityOrdered' => 5, 'QuantityShipped' => 6, 'PointsGrantedNumber' => 7, 'PointsGrantedCurrencyCode' => 8, 'PointsGrantedAmount' => 9, 'ItemPriceCurrencyCode' => 10, 'ItemPriceAmount' => 11, 'ShippingPriceCurrencyCode' => 12, 'ShippingPriceAmount' => 13, 'GiftWrapPriceCurrencyCode' => 14, 'GiftWrapPriceAmount' => 15, 'ItemTaxCurrencyCode' => 16, 'ItemTaxAmount' => 17, 'ShippingTaxCurrencyCode' => 18, 'ShippingTaxAmount' => 19, 'GiftWrapTaxCurrencyCode' => 20, 'GiftWrapTaxAmount' => 21, 'ShippingDiscountCurrencyCode' => 22, 'ShippingDiscountAmount' => 23, 'PromotionDiscountCurrencyCode' => 24, 'PromotionDiscountAmount' => 25, 'PromotionId' => 26, 'CodFeeCurrencyCode' => 27, 'CodFeeAmount' => 28, 'CodFeeDiscountCurrencyCode' => 29, 'CodFeeDiscountAmount' => 30, 'GiftMessageText' => 31, 'GiftWrapLevel' => 32, 'InvoiceRequirement' => 33, 'BuyerSelectedInvoiceCategory' => 34, 'InvoiceTitle' => 35, 'InvoiceInformation' => 36, 'ConditionNote' => 37, 'ConditionId' => 38, 'ConditionSubtypeId' => 39, 'ScheduledDeliveryStartDate' => 40, 'ScheduledDeliveryEndDate' => 41, 'PriceDesignation' => 42, 'BuyerCustomizedURL' => 43, 'OrderProductId' => 44, 'CreatedAt' => 45, 'UpdatedAt' => 46, 'Version' => 47, 'VersionCreatedAt' => 48, 'VersionCreatedBy' => 49, ),
        self::TYPE_STUDLYPHPNAME => array('orderItemId' => 0, 'amazonOrderId' => 1, 'asin' => 2, 'sellerSku' => 3, 'title' => 4, 'quantityOrdered' => 5, 'quantityShipped' => 6, 'pointsGrantedNumber' => 7, 'pointsGrantedCurrencyCode' => 8, 'pointsGrantedAmount' => 9, 'itemPriceCurrencyCode' => 10, 'itemPriceAmount' => 11, 'shippingPriceCurrencyCode' => 12, 'shippingPriceAmount' => 13, 'giftWrapPriceCurrencyCode' => 14, 'giftWrapPriceAmount' => 15, 'itemTaxCurrencyCode' => 16, 'itemTaxAmount' => 17, 'shippingTaxCurrencyCode' => 18, 'shippingTaxAmount' => 19, 'giftWrapTaxCurrencyCode' => 20, 'giftWrapTaxAmount' => 21, 'shippingDiscountCurrencyCode' => 22, 'shippingDiscountAmount' => 23, 'promotionDiscountCurrencyCode' => 24, 'promotionDiscountAmount' => 25, 'promotionId' => 26, 'codFeeCurrencyCode' => 27, 'codFeeAmount' => 28, 'codFeeDiscountCurrencyCode' => 29, 'codFeeDiscountAmount' => 30, 'giftMessageText' => 31, 'giftWrapLevel' => 32, 'invoiceRequirement' => 33, 'buyerSelectedInvoiceCategory' => 34, 'invoiceTitle' => 35, 'invoiceInformation' => 36, 'conditionNote' => 37, 'conditionId' => 38, 'conditionSubtypeId' => 39, 'scheduledDeliveryStartDate' => 40, 'scheduledDeliveryEndDate' => 41, 'priceDesignation' => 42, 'buyerCustomizedURL' => 43, 'orderProductId' => 44, 'createdAt' => 45, 'updatedAt' => 46, 'version' => 47, 'versionCreatedAt' => 48, 'versionCreatedBy' => 49, ),
        self::TYPE_COLNAME       => array(AmazonOrderProductTableMap::ORDER_ITEM_ID => 0, AmazonOrderProductTableMap::AMAZON_ORDER_ID => 1, AmazonOrderProductTableMap::ASIN => 2, AmazonOrderProductTableMap::SELLER_SKU => 3, AmazonOrderProductTableMap::TITLE => 4, AmazonOrderProductTableMap::QUANTITY_ORDERED => 5, AmazonOrderProductTableMap::QUANTITY_SHIPPED => 6, AmazonOrderProductTableMap::POINTS_GRANTED_NUMBER => 7, AmazonOrderProductTableMap::POINTS_GRANTED_CURRENCY_CODE => 8, AmazonOrderProductTableMap::POINTS_GRANTED_AMOUNT => 9, AmazonOrderProductTableMap::ITEM_PRICE_CURRENCY_CODE => 10, AmazonOrderProductTableMap::ITEM_PRICE_AMOUNT => 11, AmazonOrderProductTableMap::SHIPPING_PRICE_CURRENCY_CODE => 12, AmazonOrderProductTableMap::SHIPPING_PRICE_AMOUNT => 13, AmazonOrderProductTableMap::GIFT_WRAP_PRICE_CURRENCY_CODE => 14, AmazonOrderProductTableMap::GIFT_WRAP_PRICE_AMOUNT => 15, AmazonOrderProductTableMap::ITEM_TAX_CURRENCY_CODE => 16, AmazonOrderProductTableMap::ITEM_TAX_AMOUNT => 17, AmazonOrderProductTableMap::SHIPPING_TAX_CURRENCY_CODE => 18, AmazonOrderProductTableMap::SHIPPING_TAX_AMOUNT => 19, AmazonOrderProductTableMap::GIFT_WRAP_TAX_CURRENCY_CODE => 20, AmazonOrderProductTableMap::GIFT_WRAP_TAX_AMOUNT => 21, AmazonOrderProductTableMap::SHIPPING_DISCOUNT_CURRENCY_CODE => 22, AmazonOrderProductTableMap::SHIPPING_DISCOUNT_AMOUNT => 23, AmazonOrderProductTableMap::PROMOTION_DISCOUNT_CURRENCY_CODE => 24, AmazonOrderProductTableMap::PROMOTION_DISCOUNT_AMOUNT => 25, AmazonOrderProductTableMap::PROMOTION_ID => 26, AmazonOrderProductTableMap::COD_FEE_CURRENCY_CODE => 27, AmazonOrderProductTableMap::COD_FEE_AMOUNT => 28, AmazonOrderProductTableMap::COD_FEE_DISCOUNT_CURRENCY_CODE => 29, AmazonOrderProductTableMap::COD_FEE_DISCOUNT_AMOUNT => 30, AmazonOrderProductTableMap::GIFT_MESSAGE_TEXT => 31, AmazonOrderProductTableMap::GIFT_WRAP_LEVEL => 32, AmazonOrderProductTableMap::INVOICE_REQUIREMENT => 33, AmazonOrderProductTableMap::BUYER_SELECTED_INVOICE_CATEGORY => 34, AmazonOrderProductTableMap::INVOICE_TITLE => 35, AmazonOrderProductTableMap::INVOICE_INFORMATION => 36, AmazonOrderProductTableMap::CONDITION_NOTE => 37, AmazonOrderProductTableMap::CONDITION_ID => 38, AmazonOrderProductTableMap::CONDITION_SUBTYPE_ID => 39, AmazonOrderProductTableMap::SCHEDULE_DELIVERY_START_DATE => 40, AmazonOrderProductTableMap::SCHEDULE_DELIVERY_END_DATE => 41, AmazonOrderProductTableMap::PRICE_DESIGNATION => 42, AmazonOrderProductTableMap::BUYER_CUSTOMIZED_URL => 43, AmazonOrderProductTableMap::ORDER_PRODUCT_ID => 44, AmazonOrderProductTableMap::CREATED_AT => 45, AmazonOrderProductTableMap::UPDATED_AT => 46, AmazonOrderProductTableMap::VERSION => 47, AmazonOrderProductTableMap::VERSION_CREATED_AT => 48, AmazonOrderProductTableMap::VERSION_CREATED_BY => 49, ),
        self::TYPE_RAW_COLNAME   => array('ORDER_ITEM_ID' => 0, 'AMAZON_ORDER_ID' => 1, 'ASIN' => 2, 'SELLER_SKU' => 3, 'TITLE' => 4, 'QUANTITY_ORDERED' => 5, 'QUANTITY_SHIPPED' => 6, 'POINTS_GRANTED_NUMBER' => 7, 'POINTS_GRANTED_CURRENCY_CODE' => 8, 'POINTS_GRANTED_AMOUNT' => 9, 'ITEM_PRICE_CURRENCY_CODE' => 10, 'ITEM_PRICE_AMOUNT' => 11, 'SHIPPING_PRICE_CURRENCY_CODE' => 12, 'SHIPPING_PRICE_AMOUNT' => 13, 'GIFT_WRAP_PRICE_CURRENCY_CODE' => 14, 'GIFT_WRAP_PRICE_AMOUNT' => 15, 'ITEM_TAX_CURRENCY_CODE' => 16, 'ITEM_TAX_AMOUNT' => 17, 'SHIPPING_TAX_CURRENCY_CODE' => 18, 'SHIPPING_TAX_AMOUNT' => 19, 'GIFT_WRAP_TAX_CURRENCY_CODE' => 20, 'GIFT_WRAP_TAX_AMOUNT' => 21, 'SHIPPING_DISCOUNT_CURRENCY_CODE' => 22, 'SHIPPING_DISCOUNT_AMOUNT' => 23, 'PROMOTION_DISCOUNT_CURRENCY_CODE' => 24, 'PROMOTION_DISCOUNT_AMOUNT' => 25, 'PROMOTION_ID' => 26, 'COD_FEE_CURRENCY_CODE' => 27, 'COD_FEE_AMOUNT' => 28, 'COD_FEE_DISCOUNT_CURRENCY_CODE' => 29, 'COD_FEE_DISCOUNT_AMOUNT' => 30, 'GIFT_MESSAGE_TEXT' => 31, 'GIFT_WRAP_LEVEL' => 32, 'INVOICE_REQUIREMENT' => 33, 'BUYER_SELECTED_INVOICE_CATEGORY' => 34, 'INVOICE_TITLE' => 35, 'INVOICE_INFORMATION' => 36, 'CONDITION_NOTE' => 37, 'CONDITION_ID' => 38, 'CONDITION_SUBTYPE_ID' => 39, 'SCHEDULE_DELIVERY_START_DATE' => 40, 'SCHEDULE_DELIVERY_END_DATE' => 41, 'PRICE_DESIGNATION' => 42, 'BUYER_CUSTOMIZED_URL' => 43, 'ORDER_PRODUCT_ID' => 44, 'CREATED_AT' => 45, 'UPDATED_AT' => 46, 'VERSION' => 47, 'VERSION_CREATED_AT' => 48, 'VERSION_CREATED_BY' => 49, ),
        self::TYPE_FIELDNAME     => array('order_item_id' => 0, 'amazon_order_id' => 1, 'asin' => 2, 'seller_sku' => 3, 'title' => 4, 'quantity_ordered' => 5, 'quantity_shipped' => 6, 'points_granted_number' => 7, 'points_granted_currency_code' => 8, 'points_granted_amount' => 9, 'item_price_currency_code' => 10, 'item_price_amount' => 11, 'shipping_price_currency_code' => 12, 'shipping_price_amount' => 13, 'gift_wrap_price_currency_code' => 14, 'gift_wrap_price_amount' => 15, 'item_tax_currency_code' => 16, 'item_tax_amount' => 17, 'shipping_tax_currency_code' => 18, 'shipping_tax_amount' => 19, 'gift_wrap_tax_currency_code' => 20, 'gift_wrap_tax_amount' => 21, 'shipping_discount_currency_code' => 22, 'shipping_discount_amount' => 23, 'promotion_discount_currency_code' => 24, 'promotion_discount_amount' => 25, 'promotion_id' => 26, 'cod_fee_currency_code' => 27, 'cod_fee_amount' => 28, 'cod_fee_discount_currency_code' => 29, 'cod_fee_discount_amount' => 30, 'gift_message_text' => 31, 'gift_wrap_level' => 32, 'invoice_requirement' => 33, 'buyer_selected_invoice_category' => 34, 'invoice_title' => 35, 'invoice_information' => 36, 'condition_note' => 37, 'condition_id' => 38, 'condition_subtype_id' => 39, 'schedule_delivery_start_date' => 40, 'schedule_delivery_end_date' => 41, 'price_designation' => 42, 'buyer_customized_url' => 43, 'order_product_id' => 44, 'created_at' => 45, 'updated_at' => 46, 'version' => 47, 'version_created_at' => 48, 'version_created_by' => 49, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, )
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
        $this->setName('amazon_order_product');
        $this->setPhpName('AmazonOrderProduct');
        $this->setClassName('\\AmazonIntegration\\Model\\AmazonOrderProduct');
        $this->setPackage('AmazonIntegration.Model');
        $this->setUseIdGenerator(false);
        // columns
        $this->addPrimaryKey('ORDER_ITEM_ID', 'OrderItemId', 'VARCHAR', true, 45, null);
        $this->addForeignKey('AMAZON_ORDER_ID', 'AmazonOrderId', 'VARCHAR', 'amazon_orders', 'ID', false, 45, null);
        $this->addColumn('ASIN', 'Asin', 'VARCHAR', false, 45, null);
        $this->addColumn('SELLER_SKU', 'SellerSku', 'VARCHAR', false, 45, null);
        $this->addColumn('TITLE', 'Title', 'VARCHAR', false, 45, null);
        $this->addColumn('QUANTITY_ORDERED', 'QuantityOrdered', 'FLOAT', false, null, null);
        $this->addColumn('QUANTITY_SHIPPED', 'QuantityShipped', 'FLOAT', false, null, null);
        $this->addColumn('POINTS_GRANTED_NUMBER', 'PointsGrantedNumber', 'FLOAT', false, null, null);
        $this->addColumn('POINTS_GRANTED_CURRENCY_CODE', 'PointsGrantedCurrencyCode', 'VARCHAR', false, 45, null);
        $this->addColumn('POINTS_GRANTED_AMOUNT', 'PointsGrantedAmount', 'VARCHAR', false, 45, null);
        $this->addColumn('ITEM_PRICE_CURRENCY_CODE', 'ItemPriceCurrencyCode', 'VARCHAR', false, 45, null);
        $this->addColumn('ITEM_PRICE_AMOUNT', 'ItemPriceAmount', 'VARCHAR', false, 45, null);
        $this->addColumn('SHIPPING_PRICE_CURRENCY_CODE', 'ShippingPriceCurrencyCode', 'VARCHAR', false, 45, null);
        $this->addColumn('SHIPPING_PRICE_AMOUNT', 'ShippingPriceAmount', 'VARCHAR', false, 45, null);
        $this->addColumn('GIFT_WRAP_PRICE_CURRENCY_CODE', 'GiftWrapPriceCurrencyCode', 'VARCHAR', false, 45, null);
        $this->addColumn('GIFT_WRAP_PRICE_AMOUNT', 'GiftWrapPriceAmount', 'VARCHAR', false, 45, null);
        $this->addColumn('ITEM_TAX_CURRENCY_CODE', 'ItemTaxCurrencyCode', 'VARCHAR', false, 45, null);
        $this->addColumn('ITEM_TAX_AMOUNT', 'ItemTaxAmount', 'VARCHAR', false, 45, null);
        $this->addColumn('SHIPPING_TAX_CURRENCY_CODE', 'ShippingTaxCurrencyCode', 'VARCHAR', false, 45, null);
        $this->addColumn('SHIPPING_TAX_AMOUNT', 'ShippingTaxAmount', 'VARCHAR', false, 45, null);
        $this->addColumn('GIFT_WRAP_TAX_CURRENCY_CODE', 'GiftWrapTaxCurrencyCode', 'VARCHAR', false, 45, null);
        $this->addColumn('GIFT_WRAP_TAX_AMOUNT', 'GiftWrapTaxAmount', 'VARCHAR', false, 45, null);
        $this->addColumn('SHIPPING_DISCOUNT_CURRENCY_CODE', 'ShippingDiscountCurrencyCode', 'VARCHAR', false, 45, null);
        $this->addColumn('SHIPPING_DISCOUNT_AMOUNT', 'ShippingDiscountAmount', 'VARCHAR', false, 45, null);
        $this->addColumn('PROMOTION_DISCOUNT_CURRENCY_CODE', 'PromotionDiscountCurrencyCode', 'VARCHAR', false, 45, null);
        $this->addColumn('PROMOTION_DISCOUNT_AMOUNT', 'PromotionDiscountAmount', 'VARCHAR', false, 45, null);
        $this->addColumn('PROMOTION_ID', 'PromotionId', 'VARCHAR', false, 45, null);
        $this->addColumn('COD_FEE_CURRENCY_CODE', 'CodFeeCurrencyCode', 'VARCHAR', false, 45, null);
        $this->addColumn('COD_FEE_AMOUNT', 'CodFeeAmount', 'VARCHAR', false, 45, null);
        $this->addColumn('COD_FEE_DISCOUNT_CURRENCY_CODE', 'CodFeeDiscountCurrencyCode', 'VARCHAR', false, 45, null);
        $this->addColumn('COD_FEE_DISCOUNT_AMOUNT', 'CodFeeDiscountAmount', 'VARCHAR', false, 45, null);
        $this->addColumn('GIFT_MESSAGE_TEXT', 'GiftMessageText', 'VARCHAR', false, 45, null);
        $this->addColumn('GIFT_WRAP_LEVEL', 'GiftWrapLevel', 'VARCHAR', false, 45, null);
        $this->addColumn('INVOICE_REQUIREMENT', 'InvoiceRequirement', 'VARCHAR', false, 45, null);
        $this->addColumn('BUYER_SELECTED_INVOICE_CATEGORY', 'BuyerSelectedInvoiceCategory', 'VARCHAR', false, 45, null);
        $this->addColumn('INVOICE_TITLE', 'InvoiceTitle', 'VARCHAR', false, 45, null);
        $this->addColumn('INVOICE_INFORMATION', 'InvoiceInformation', 'VARCHAR', false, 45, null);
        $this->addColumn('CONDITION_NOTE', 'ConditionNote', 'VARCHAR', false, 45, null);
        $this->addColumn('CONDITION_ID', 'ConditionId', 'VARCHAR', false, 45, null);
        $this->addColumn('CONDITION_SUBTYPE_ID', 'ConditionSubtypeId', 'VARCHAR', false, 45, null);
        $this->addColumn('SCHEDULE_DELIVERY_START_DATE', 'ScheduledDeliveryStartDate', 'VARCHAR', false, 45, null);
        $this->addColumn('SCHEDULE_DELIVERY_END_DATE', 'ScheduledDeliveryEndDate', 'VARCHAR', false, 45, null);
        $this->addColumn('PRICE_DESIGNATION', 'PriceDesignation', 'VARCHAR', false, 45, null);
        $this->addColumn('BUYER_CUSTOMIZED_URL', 'BuyerCustomizedURL', 'VARCHAR', false, 45, null);
        $this->addForeignKey('ORDER_PRODUCT_ID', 'OrderProductId', 'INTEGER', 'order_product', 'ID', false, null, null);
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
        $this->addRelation('OrderProduct', '\\Thelia\\Model\\OrderProduct', RelationMap::MANY_TO_ONE, array('order_product_id' => 'id', ), 'CASCADE', null);
        $this->addRelation('AmazonOrders', '\\AmazonIntegration\\Model\\AmazonOrders', RelationMap::MANY_TO_ONE, array('amazon_order_id' => 'id', ), 'CASCADE', null);
        $this->addRelation('AmazonOrderProductVersion', '\\AmazonIntegration\\Model\\AmazonOrderProductVersion', RelationMap::ONE_TO_MANY, array('order_item_id' => 'order_item_id', ), 'CASCADE', null, 'AmazonOrderProductVersions');
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
     * Method to invalidate the instance pool of all tables related to amazon_order_product     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
        // Invalidate objects in ".$this->getClassNameFromBuilder($joinedTableTableMapBuilder)." instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
                AmazonOrderProductVersionTableMap::clearInstancePool();
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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('OrderItemId', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('OrderItemId', TableMap::TYPE_PHPNAME, $indexType)];
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
                            : self::translateFieldName('OrderItemId', TableMap::TYPE_PHPNAME, $indexType)
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
        return $withPrefix ? AmazonOrderProductTableMap::CLASS_DEFAULT : AmazonOrderProductTableMap::OM_CLASS;
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
     * @return array (AmazonOrderProduct object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = AmazonOrderProductTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = AmazonOrderProductTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + AmazonOrderProductTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = AmazonOrderProductTableMap::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            AmazonOrderProductTableMap::addInstanceToPool($obj, $key);
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
            $key = AmazonOrderProductTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = AmazonOrderProductTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                AmazonOrderProductTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(AmazonOrderProductTableMap::ORDER_ITEM_ID);
            $criteria->addSelectColumn(AmazonOrderProductTableMap::AMAZON_ORDER_ID);
            $criteria->addSelectColumn(AmazonOrderProductTableMap::ASIN);
            $criteria->addSelectColumn(AmazonOrderProductTableMap::SELLER_SKU);
            $criteria->addSelectColumn(AmazonOrderProductTableMap::TITLE);
            $criteria->addSelectColumn(AmazonOrderProductTableMap::QUANTITY_ORDERED);
            $criteria->addSelectColumn(AmazonOrderProductTableMap::QUANTITY_SHIPPED);
            $criteria->addSelectColumn(AmazonOrderProductTableMap::POINTS_GRANTED_NUMBER);
            $criteria->addSelectColumn(AmazonOrderProductTableMap::POINTS_GRANTED_CURRENCY_CODE);
            $criteria->addSelectColumn(AmazonOrderProductTableMap::POINTS_GRANTED_AMOUNT);
            $criteria->addSelectColumn(AmazonOrderProductTableMap::ITEM_PRICE_CURRENCY_CODE);
            $criteria->addSelectColumn(AmazonOrderProductTableMap::ITEM_PRICE_AMOUNT);
            $criteria->addSelectColumn(AmazonOrderProductTableMap::SHIPPING_PRICE_CURRENCY_CODE);
            $criteria->addSelectColumn(AmazonOrderProductTableMap::SHIPPING_PRICE_AMOUNT);
            $criteria->addSelectColumn(AmazonOrderProductTableMap::GIFT_WRAP_PRICE_CURRENCY_CODE);
            $criteria->addSelectColumn(AmazonOrderProductTableMap::GIFT_WRAP_PRICE_AMOUNT);
            $criteria->addSelectColumn(AmazonOrderProductTableMap::ITEM_TAX_CURRENCY_CODE);
            $criteria->addSelectColumn(AmazonOrderProductTableMap::ITEM_TAX_AMOUNT);
            $criteria->addSelectColumn(AmazonOrderProductTableMap::SHIPPING_TAX_CURRENCY_CODE);
            $criteria->addSelectColumn(AmazonOrderProductTableMap::SHIPPING_TAX_AMOUNT);
            $criteria->addSelectColumn(AmazonOrderProductTableMap::GIFT_WRAP_TAX_CURRENCY_CODE);
            $criteria->addSelectColumn(AmazonOrderProductTableMap::GIFT_WRAP_TAX_AMOUNT);
            $criteria->addSelectColumn(AmazonOrderProductTableMap::SHIPPING_DISCOUNT_CURRENCY_CODE);
            $criteria->addSelectColumn(AmazonOrderProductTableMap::SHIPPING_DISCOUNT_AMOUNT);
            $criteria->addSelectColumn(AmazonOrderProductTableMap::PROMOTION_DISCOUNT_CURRENCY_CODE);
            $criteria->addSelectColumn(AmazonOrderProductTableMap::PROMOTION_DISCOUNT_AMOUNT);
            $criteria->addSelectColumn(AmazonOrderProductTableMap::PROMOTION_ID);
            $criteria->addSelectColumn(AmazonOrderProductTableMap::COD_FEE_CURRENCY_CODE);
            $criteria->addSelectColumn(AmazonOrderProductTableMap::COD_FEE_AMOUNT);
            $criteria->addSelectColumn(AmazonOrderProductTableMap::COD_FEE_DISCOUNT_CURRENCY_CODE);
            $criteria->addSelectColumn(AmazonOrderProductTableMap::COD_FEE_DISCOUNT_AMOUNT);
            $criteria->addSelectColumn(AmazonOrderProductTableMap::GIFT_MESSAGE_TEXT);
            $criteria->addSelectColumn(AmazonOrderProductTableMap::GIFT_WRAP_LEVEL);
            $criteria->addSelectColumn(AmazonOrderProductTableMap::INVOICE_REQUIREMENT);
            $criteria->addSelectColumn(AmazonOrderProductTableMap::BUYER_SELECTED_INVOICE_CATEGORY);
            $criteria->addSelectColumn(AmazonOrderProductTableMap::INVOICE_TITLE);
            $criteria->addSelectColumn(AmazonOrderProductTableMap::INVOICE_INFORMATION);
            $criteria->addSelectColumn(AmazonOrderProductTableMap::CONDITION_NOTE);
            $criteria->addSelectColumn(AmazonOrderProductTableMap::CONDITION_ID);
            $criteria->addSelectColumn(AmazonOrderProductTableMap::CONDITION_SUBTYPE_ID);
            $criteria->addSelectColumn(AmazonOrderProductTableMap::SCHEDULE_DELIVERY_START_DATE);
            $criteria->addSelectColumn(AmazonOrderProductTableMap::SCHEDULE_DELIVERY_END_DATE);
            $criteria->addSelectColumn(AmazonOrderProductTableMap::PRICE_DESIGNATION);
            $criteria->addSelectColumn(AmazonOrderProductTableMap::BUYER_CUSTOMIZED_URL);
            $criteria->addSelectColumn(AmazonOrderProductTableMap::ORDER_PRODUCT_ID);
            $criteria->addSelectColumn(AmazonOrderProductTableMap::CREATED_AT);
            $criteria->addSelectColumn(AmazonOrderProductTableMap::UPDATED_AT);
            $criteria->addSelectColumn(AmazonOrderProductTableMap::VERSION);
            $criteria->addSelectColumn(AmazonOrderProductTableMap::VERSION_CREATED_AT);
            $criteria->addSelectColumn(AmazonOrderProductTableMap::VERSION_CREATED_BY);
        } else {
            $criteria->addSelectColumn($alias . '.ORDER_ITEM_ID');
            $criteria->addSelectColumn($alias . '.AMAZON_ORDER_ID');
            $criteria->addSelectColumn($alias . '.ASIN');
            $criteria->addSelectColumn($alias . '.SELLER_SKU');
            $criteria->addSelectColumn($alias . '.TITLE');
            $criteria->addSelectColumn($alias . '.QUANTITY_ORDERED');
            $criteria->addSelectColumn($alias . '.QUANTITY_SHIPPED');
            $criteria->addSelectColumn($alias . '.POINTS_GRANTED_NUMBER');
            $criteria->addSelectColumn($alias . '.POINTS_GRANTED_CURRENCY_CODE');
            $criteria->addSelectColumn($alias . '.POINTS_GRANTED_AMOUNT');
            $criteria->addSelectColumn($alias . '.ITEM_PRICE_CURRENCY_CODE');
            $criteria->addSelectColumn($alias . '.ITEM_PRICE_AMOUNT');
            $criteria->addSelectColumn($alias . '.SHIPPING_PRICE_CURRENCY_CODE');
            $criteria->addSelectColumn($alias . '.SHIPPING_PRICE_AMOUNT');
            $criteria->addSelectColumn($alias . '.GIFT_WRAP_PRICE_CURRENCY_CODE');
            $criteria->addSelectColumn($alias . '.GIFT_WRAP_PRICE_AMOUNT');
            $criteria->addSelectColumn($alias . '.ITEM_TAX_CURRENCY_CODE');
            $criteria->addSelectColumn($alias . '.ITEM_TAX_AMOUNT');
            $criteria->addSelectColumn($alias . '.SHIPPING_TAX_CURRENCY_CODE');
            $criteria->addSelectColumn($alias . '.SHIPPING_TAX_AMOUNT');
            $criteria->addSelectColumn($alias . '.GIFT_WRAP_TAX_CURRENCY_CODE');
            $criteria->addSelectColumn($alias . '.GIFT_WRAP_TAX_AMOUNT');
            $criteria->addSelectColumn($alias . '.SHIPPING_DISCOUNT_CURRENCY_CODE');
            $criteria->addSelectColumn($alias . '.SHIPPING_DISCOUNT_AMOUNT');
            $criteria->addSelectColumn($alias . '.PROMOTION_DISCOUNT_CURRENCY_CODE');
            $criteria->addSelectColumn($alias . '.PROMOTION_DISCOUNT_AMOUNT');
            $criteria->addSelectColumn($alias . '.PROMOTION_ID');
            $criteria->addSelectColumn($alias . '.COD_FEE_CURRENCY_CODE');
            $criteria->addSelectColumn($alias . '.COD_FEE_AMOUNT');
            $criteria->addSelectColumn($alias . '.COD_FEE_DISCOUNT_CURRENCY_CODE');
            $criteria->addSelectColumn($alias . '.COD_FEE_DISCOUNT_AMOUNT');
            $criteria->addSelectColumn($alias . '.GIFT_MESSAGE_TEXT');
            $criteria->addSelectColumn($alias . '.GIFT_WRAP_LEVEL');
            $criteria->addSelectColumn($alias . '.INVOICE_REQUIREMENT');
            $criteria->addSelectColumn($alias . '.BUYER_SELECTED_INVOICE_CATEGORY');
            $criteria->addSelectColumn($alias . '.INVOICE_TITLE');
            $criteria->addSelectColumn($alias . '.INVOICE_INFORMATION');
            $criteria->addSelectColumn($alias . '.CONDITION_NOTE');
            $criteria->addSelectColumn($alias . '.CONDITION_ID');
            $criteria->addSelectColumn($alias . '.CONDITION_SUBTYPE_ID');
            $criteria->addSelectColumn($alias . '.SCHEDULE_DELIVERY_START_DATE');
            $criteria->addSelectColumn($alias . '.SCHEDULE_DELIVERY_END_DATE');
            $criteria->addSelectColumn($alias . '.PRICE_DESIGNATION');
            $criteria->addSelectColumn($alias . '.BUYER_CUSTOMIZED_URL');
            $criteria->addSelectColumn($alias . '.ORDER_PRODUCT_ID');
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
        return Propel::getServiceContainer()->getDatabaseMap(AmazonOrderProductTableMap::DATABASE_NAME)->getTable(AmazonOrderProductTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getServiceContainer()->getDatabaseMap(AmazonOrderProductTableMap::DATABASE_NAME);
      if (!$dbMap->hasTable(AmazonOrderProductTableMap::TABLE_NAME)) {
        $dbMap->addTableObject(new AmazonOrderProductTableMap());
      }
    }

    /**
     * Performs a DELETE on the database, given a AmazonOrderProduct or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or AmazonOrderProduct object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(AmazonOrderProductTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \AmazonIntegration\Model\AmazonOrderProduct) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(AmazonOrderProductTableMap::DATABASE_NAME);
            $criteria->add(AmazonOrderProductTableMap::ORDER_ITEM_ID, (array) $values, Criteria::IN);
        }

        $query = AmazonOrderProductQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) { AmazonOrderProductTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) { AmazonOrderProductTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the amazon_order_product table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return AmazonOrderProductQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a AmazonOrderProduct or Criteria object.
     *
     * @param mixed               $criteria Criteria or AmazonOrderProduct object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(AmazonOrderProductTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from AmazonOrderProduct object
        }


        // Set the correct dbName
        $query = AmazonOrderProductQuery::create()->mergeWith($criteria);

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

} // AmazonOrderProductTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
AmazonOrderProductTableMap::buildTableMap();
