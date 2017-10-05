<?php

namespace AmazonIntegration\Model\Base;

use \DateTime;
use \Exception;
use \PDO;
use AmazonIntegration\Model\AmazonOrderProduct as ChildAmazonOrderProduct;
use AmazonIntegration\Model\AmazonOrderProductQuery as ChildAmazonOrderProductQuery;
use AmazonIntegration\Model\AmazonOrderProductVersion as ChildAmazonOrderProductVersion;
use AmazonIntegration\Model\AmazonOrderProductVersionQuery as ChildAmazonOrderProductVersionQuery;
use AmazonIntegration\Model\AmazonOrders as ChildAmazonOrders;
use AmazonIntegration\Model\AmazonOrdersQuery as ChildAmazonOrdersQuery;
use AmazonIntegration\Model\AmazonOrdersVersionQuery as ChildAmazonOrdersVersionQuery;
use AmazonIntegration\Model\Map\AmazonOrderProductTableMap;
use AmazonIntegration\Model\Map\AmazonOrderProductVersionTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;
use Propel\Runtime\Util\PropelDateTime;
use Thelia\Model\OrderProduct as ChildOrderProduct;
use Thelia\Model\OrderProductQuery;

abstract class AmazonOrderProduct implements ActiveRecordInterface 
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\AmazonIntegration\\Model\\Map\\AmazonOrderProductTableMap';


    /**
     * attribute to determine if this object has previously been saved.
     * @var boolean
     */
    protected $new = true;

    /**
     * attribute to determine whether this object has been deleted.
     * @var boolean
     */
    protected $deleted = false;

    /**
     * The columns that have been modified in current object.
     * Tracking modified columns allows us to only update modified columns.
     * @var array
     */
    protected $modifiedColumns = array();

    /**
     * The (virtual) columns that are added at runtime
     * The formatters can add supplementary columns based on a resultset
     * @var array
     */
    protected $virtualColumns = array();

    /**
     * The value for the order_item_id field.
     * @var        string
     */
    protected $order_item_id;

    /**
     * The value for the amazon_order_id field.
     * @var        string
     */
    protected $amazon_order_id;

    /**
     * The value for the asin field.
     * @var        string
     */
    protected $asin;

    /**
     * The value for the seller_sku field.
     * @var        string
     */
    protected $seller_sku;

    /**
     * The value for the title field.
     * @var        string
     */
    protected $title;

    /**
     * The value for the quantity_ordered field.
     * @var        double
     */
    protected $quantity_ordered;

    /**
     * The value for the quantity_shipped field.
     * @var        double
     */
    protected $quantity_shipped;

    /**
     * The value for the points_granted_number field.
     * @var        double
     */
    protected $points_granted_number;

    /**
     * The value for the points_granted_currency_code field.
     * @var        string
     */
    protected $points_granted_currency_code;

    /**
     * The value for the points_granted_amount field.
     * @var        string
     */
    protected $points_granted_amount;

    /**
     * The value for the item_price_currency_code field.
     * @var        string
     */
    protected $item_price_currency_code;

    /**
     * The value for the item_price_amount field.
     * @var        string
     */
    protected $item_price_amount;

    /**
     * The value for the shipping_price_currency_code field.
     * @var        string
     */
    protected $shipping_price_currency_code;

    /**
     * The value for the shipping_price_amount field.
     * @var        string
     */
    protected $shipping_price_amount;

    /**
     * The value for the gift_wrap_price_currency_code field.
     * @var        string
     */
    protected $gift_wrap_price_currency_code;

    /**
     * The value for the gift_wrap_price_amount field.
     * @var        string
     */
    protected $gift_wrap_price_amount;

    /**
     * The value for the item_tax_currency_code field.
     * @var        string
     */
    protected $item_tax_currency_code;

    /**
     * The value for the item_tax_amount field.
     * @var        string
     */
    protected $item_tax_amount;

    /**
     * The value for the shipping_tax_currency_code field.
     * @var        string
     */
    protected $shipping_tax_currency_code;

    /**
     * The value for the shipping_tax_amount field.
     * @var        string
     */
    protected $shipping_tax_amount;

    /**
     * The value for the gift_wrap_tax_currency_code field.
     * @var        string
     */
    protected $gift_wrap_tax_currency_code;

    /**
     * The value for the gift_wrap_tax_amount field.
     * @var        string
     */
    protected $gift_wrap_tax_amount;

    /**
     * The value for the shipping_discount_currency_code field.
     * @var        string
     */
    protected $shipping_discount_currency_code;

    /**
     * The value for the shipping_discount_amount field.
     * @var        string
     */
    protected $shipping_discount_amount;

    /**
     * The value for the promotion_discount_currency_code field.
     * @var        string
     */
    protected $promotion_discount_currency_code;

    /**
     * The value for the promotion_discount_amount field.
     * @var        string
     */
    protected $promotion_discount_amount;

    /**
     * The value for the promotion_id field.
     * @var        string
     */
    protected $promotion_id;

    /**
     * The value for the cod_fee_currency_code field.
     * @var        string
     */
    protected $cod_fee_currency_code;

    /**
     * The value for the cod_fee_amount field.
     * @var        string
     */
    protected $cod_fee_amount;

    /**
     * The value for the cod_fee_discount_currency_code field.
     * @var        string
     */
    protected $cod_fee_discount_currency_code;

    /**
     * The value for the cod_fee_discount_amount field.
     * @var        string
     */
    protected $cod_fee_discount_amount;

    /**
     * The value for the gift_message_text field.
     * @var        string
     */
    protected $gift_message_text;

    /**
     * The value for the gift_wrap_level field.
     * @var        string
     */
    protected $gift_wrap_level;

    /**
     * The value for the invoice_requirement field.
     * @var        string
     */
    protected $invoice_requirement;

    /**
     * The value for the buyer_selected_invoice_category field.
     * @var        string
     */
    protected $buyer_selected_invoice_category;

    /**
     * The value for the invoice_title field.
     * @var        string
     */
    protected $invoice_title;

    /**
     * The value for the invoice_information field.
     * @var        string
     */
    protected $invoice_information;

    /**
     * The value for the condition_note field.
     * @var        string
     */
    protected $condition_note;

    /**
     * The value for the condition_id field.
     * @var        string
     */
    protected $condition_id;

    /**
     * The value for the condition_subtype_id field.
     * @var        string
     */
    protected $condition_subtype_id;

    /**
     * The value for the schedule_delivery_start_date field.
     * @var        string
     */
    protected $schedule_delivery_start_date;

    /**
     * The value for the schedule_delivery_end_date field.
     * @var        string
     */
    protected $schedule_delivery_end_date;

    /**
     * The value for the price_designation field.
     * @var        string
     */
    protected $price_designation;

    /**
     * The value for the buyer_customized_url field.
     * @var        string
     */
    protected $buyer_customized_url;

    /**
     * The value for the order_product_id field.
     * @var        int
     */
    protected $order_product_id;

    /**
     * The value for the created_at field.
     * @var        string
     */
    protected $created_at;

    /**
     * The value for the updated_at field.
     * @var        string
     */
    protected $updated_at;

    /**
     * The value for the version field.
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $version;

    /**
     * The value for the version_created_at field.
     * @var        string
     */
    protected $version_created_at;

    /**
     * The value for the version_created_by field.
     * @var        string
     */
    protected $version_created_by;

    /**
     * @var        OrderProduct
     */
    protected $aOrderProduct;

    /**
     * @var        AmazonOrders
     */
    protected $aAmazonOrders;

    /**
     * @var        ObjectCollection|ChildAmazonOrderProductVersion[] Collection to store aggregation of ChildAmazonOrderProductVersion objects.
     */
    protected $collAmazonOrderProductVersions;
    protected $collAmazonOrderProductVersionsPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    // versionable behavior
    
    
    /**
     * @var bool
     */
    protected $enforceVersion = false;
            
    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection
     */
    protected $amazonOrderProductVersionsScheduledForDeletion = null;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see __construct()
     */
    public function applyDefaultValues()
    {
        $this->version = 0;
    }

    /**
     * Initializes internal state of AmazonIntegration\Model\Base\AmazonOrderProduct object.
     * @see applyDefaults()
     */
    public function __construct()
    {
        $this->applyDefaultValues();
    }

    /**
     * Returns whether the object has been modified.
     *
     * @return boolean True if the object has been modified.
     */
    public function isModified()
    {
        return !!$this->modifiedColumns;
    }

    /**
     * Has specified column been modified?
     *
     * @param  string  $col column fully qualified name (TableMap::TYPE_COLNAME), e.g. Book::AUTHOR_ID
     * @return boolean True if $col has been modified.
     */
    public function isColumnModified($col)
    {
        return $this->modifiedColumns && isset($this->modifiedColumns[$col]);
    }

    /**
     * Get the columns that have been modified in this object.
     * @return array A unique list of the modified column names for this object.
     */
    public function getModifiedColumns()
    {
        return $this->modifiedColumns ? array_keys($this->modifiedColumns) : [];
    }

    /**
     * Returns whether the object has ever been saved.  This will
     * be false, if the object was retrieved from storage or was created
     * and then saved.
     *
     * @return boolean true, if the object has never been persisted.
     */
    public function isNew()
    {
        return $this->new;
    }

    /**
     * Setter for the isNew attribute.  This method will be called
     * by Propel-generated children and objects.
     *
     * @param boolean $b the state of the object.
     */
    public function setNew($b)
    {
        $this->new = (Boolean) $b;
    }

    /**
     * Whether this object has been deleted.
     * @return boolean The deleted state of this object.
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * Specify whether this object has been deleted.
     * @param  boolean $b The deleted state of this object.
     * @return void
     */
    public function setDeleted($b)
    {
        $this->deleted = (Boolean) $b;
    }

    /**
     * Sets the modified state for the object to be false.
     * @param  string $col If supplied, only the specified column is reset.
     * @return void
     */
    public function resetModified($col = null)
    {
        if (null !== $col) {
            if (isset($this->modifiedColumns[$col])) {
                unset($this->modifiedColumns[$col]);
            }
        } else {
            $this->modifiedColumns = array();
        }
    }

    /**
     * Compares this with another <code>AmazonOrderProduct</code> instance.  If
     * <code>obj</code> is an instance of <code>AmazonOrderProduct</code>, delegates to
     * <code>equals(AmazonOrderProduct)</code>.  Otherwise, returns <code>false</code>.
     *
     * @param  mixed   $obj The object to compare to.
     * @return boolean Whether equal to the object specified.
     */
    public function equals($obj)
    {
        $thisclazz = get_class($this);
        if (!is_object($obj) || !($obj instanceof $thisclazz)) {
            return false;
        }

        if ($this === $obj) {
            return true;
        }

        if (null === $this->getPrimaryKey()
            || null === $obj->getPrimaryKey())  {
            return false;
        }

        return $this->getPrimaryKey() === $obj->getPrimaryKey();
    }

    /**
     * If the primary key is not null, return the hashcode of the
     * primary key. Otherwise, return the hash code of the object.
     *
     * @return int Hashcode
     */
    public function hashCode()
    {
        if (null !== $this->getPrimaryKey()) {
            return crc32(serialize($this->getPrimaryKey()));
        }

        return crc32(serialize(clone $this));
    }

    /**
     * Get the associative array of the virtual columns in this object
     *
     * @return array
     */
    public function getVirtualColumns()
    {
        return $this->virtualColumns;
    }

    /**
     * Checks the existence of a virtual column in this object
     *
     * @param  string  $name The virtual column name
     * @return boolean
     */
    public function hasVirtualColumn($name)
    {
        return array_key_exists($name, $this->virtualColumns);
    }

    /**
     * Get the value of a virtual column in this object
     *
     * @param  string $name The virtual column name
     * @return mixed
     *
     * @throws PropelException
     */
    public function getVirtualColumn($name)
    {
        if (!$this->hasVirtualColumn($name)) {
            throw new PropelException(sprintf('Cannot get value of inexistent virtual column %s.', $name));
        }

        return $this->virtualColumns[$name];
    }

    /**
     * Set the value of a virtual column in this object
     *
     * @param string $name  The virtual column name
     * @param mixed  $value The value to give to the virtual column
     *
     * @return AmazonOrderProduct The current object, for fluid interface
     */
    public function setVirtualColumn($name, $value)
    {
        $this->virtualColumns[$name] = $value;

        return $this;
    }

    /**
     * Logs a message using Propel::log().
     *
     * @param  string  $msg
     * @param  int     $priority One of the Propel::LOG_* logging levels
     * @return boolean
     */
    protected function log($msg, $priority = Propel::LOG_INFO)
    {
        return Propel::log(get_class($this) . ': ' . $msg, $priority);
    }

    /**
     * Populate the current object from a string, using a given parser format
     * <code>
     * $book = new Book();
     * $book->importFrom('JSON', '{"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param mixed $parser A AbstractParser instance,
     *                       or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param string $data The source data to import from
     *
     * @return AmazonOrderProduct The current object, for fluid interface
     */
    public function importFrom($parser, $data)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        $this->fromArray($parser->toArray($data), TableMap::TYPE_PHPNAME);

        return $this;
    }

    /**
     * Export the current object properties to a string, using a given parser format
     * <code>
     * $book = BookQuery::create()->findPk(9012);
     * echo $book->exportTo('JSON');
     *  => {"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param  mixed   $parser                 A AbstractParser instance, or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param  boolean $includeLazyLoadColumns (optional) Whether to include lazy load(ed) columns. Defaults to TRUE.
     * @return string  The exported data
     */
    public function exportTo($parser, $includeLazyLoadColumns = true)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        return $parser->fromArray($this->toArray(TableMap::TYPE_PHPNAME, $includeLazyLoadColumns, array(), true));
    }

    /**
     * Clean up internal collections prior to serializing
     * Avoids recursive loops that turn into segmentation faults when serializing
     */
    public function __sleep()
    {
        $this->clearAllReferences();

        return array_keys(get_object_vars($this));
    }

    /**
     * Get the [order_item_id] column value.
     * 
     * @return   string
     */
    public function getOrderItemId()
    {

        return $this->order_item_id;
    }

    /**
     * Get the [amazon_order_id] column value.
     * 
     * @return   string
     */
    public function getAmazonOrderId()
    {

        return $this->amazon_order_id;
    }

    /**
     * Get the [asin] column value.
     * 
     * @return   string
     */
    public function getAsin()
    {

        return $this->asin;
    }

    /**
     * Get the [seller_sku] column value.
     * 
     * @return   string
     */
    public function getSellerSku()
    {

        return $this->seller_sku;
    }

    /**
     * Get the [title] column value.
     * 
     * @return   string
     */
    public function getTitle()
    {

        return $this->title;
    }

    /**
     * Get the [quantity_ordered] column value.
     * 
     * @return   double
     */
    public function getQuantityOrdered()
    {

        return $this->quantity_ordered;
    }

    /**
     * Get the [quantity_shipped] column value.
     * 
     * @return   double
     */
    public function getQuantityShipped()
    {

        return $this->quantity_shipped;
    }

    /**
     * Get the [points_granted_number] column value.
     * 
     * @return   double
     */
    public function getPointsGrantedNumber()
    {

        return $this->points_granted_number;
    }

    /**
     * Get the [points_granted_currency_code] column value.
     * 
     * @return   string
     */
    public function getPointsGrantedCurrencyCode()
    {

        return $this->points_granted_currency_code;
    }

    /**
     * Get the [points_granted_amount] column value.
     * 
     * @return   string
     */
    public function getPointsGrantedAmount()
    {

        return $this->points_granted_amount;
    }

    /**
     * Get the [item_price_currency_code] column value.
     * 
     * @return   string
     */
    public function getItemPriceCurrencyCode()
    {

        return $this->item_price_currency_code;
    }

    /**
     * Get the [item_price_amount] column value.
     * 
     * @return   string
     */
    public function getItemPriceAmount()
    {

        return $this->item_price_amount;
    }

    /**
     * Get the [shipping_price_currency_code] column value.
     * 
     * @return   string
     */
    public function getShippingPriceCurrencyCode()
    {

        return $this->shipping_price_currency_code;
    }

    /**
     * Get the [shipping_price_amount] column value.
     * 
     * @return   string
     */
    public function getShippingPriceAmount()
    {

        return $this->shipping_price_amount;
    }

    /**
     * Get the [gift_wrap_price_currency_code] column value.
     * 
     * @return   string
     */
    public function getGiftWrapPriceCurrencyCode()
    {

        return $this->gift_wrap_price_currency_code;
    }

    /**
     * Get the [gift_wrap_price_amount] column value.
     * 
     * @return   string
     */
    public function getGiftWrapPriceAmount()
    {

        return $this->gift_wrap_price_amount;
    }

    /**
     * Get the [item_tax_currency_code] column value.
     * 
     * @return   string
     */
    public function getItemTaxCurrencyCode()
    {

        return $this->item_tax_currency_code;
    }

    /**
     * Get the [item_tax_amount] column value.
     * 
     * @return   string
     */
    public function getItemTaxAmount()
    {

        return $this->item_tax_amount;
    }

    /**
     * Get the [shipping_tax_currency_code] column value.
     * 
     * @return   string
     */
    public function getShippingTaxCurrencyCode()
    {

        return $this->shipping_tax_currency_code;
    }

    /**
     * Get the [shipping_tax_amount] column value.
     * 
     * @return   string
     */
    public function getShippingTaxAmount()
    {

        return $this->shipping_tax_amount;
    }

    /**
     * Get the [gift_wrap_tax_currency_code] column value.
     * 
     * @return   string
     */
    public function getGiftWrapTaxCurrencyCode()
    {

        return $this->gift_wrap_tax_currency_code;
    }

    /**
     * Get the [gift_wrap_tax_amount] column value.
     * 
     * @return   string
     */
    public function getGiftWrapTaxAmount()
    {

        return $this->gift_wrap_tax_amount;
    }

    /**
     * Get the [shipping_discount_currency_code] column value.
     * 
     * @return   string
     */
    public function getShippingDiscountCurrencyCode()
    {

        return $this->shipping_discount_currency_code;
    }

    /**
     * Get the [shipping_discount_amount] column value.
     * 
     * @return   string
     */
    public function getShippingDiscountAmount()
    {

        return $this->shipping_discount_amount;
    }

    /**
     * Get the [promotion_discount_currency_code] column value.
     * 
     * @return   string
     */
    public function getPromotionDiscountCurrencyCode()
    {

        return $this->promotion_discount_currency_code;
    }

    /**
     * Get the [promotion_discount_amount] column value.
     * 
     * @return   string
     */
    public function getPromotionDiscountAmount()
    {

        return $this->promotion_discount_amount;
    }

    /**
     * Get the [promotion_id] column value.
     * 
     * @return   string
     */
    public function getPromotionId()
    {

        return $this->promotion_id;
    }

    /**
     * Get the [cod_fee_currency_code] column value.
     * 
     * @return   string
     */
    public function getCodFeeCurrencyCode()
    {

        return $this->cod_fee_currency_code;
    }

    /**
     * Get the [cod_fee_amount] column value.
     * 
     * @return   string
     */
    public function getCodFeeAmount()
    {

        return $this->cod_fee_amount;
    }

    /**
     * Get the [cod_fee_discount_currency_code] column value.
     * 
     * @return   string
     */
    public function getCodFeeDiscountCurrencyCode()
    {

        return $this->cod_fee_discount_currency_code;
    }

    /**
     * Get the [cod_fee_discount_amount] column value.
     * 
     * @return   string
     */
    public function getCodFeeDiscountAmount()
    {

        return $this->cod_fee_discount_amount;
    }

    /**
     * Get the [gift_message_text] column value.
     * 
     * @return   string
     */
    public function getGiftMessageText()
    {

        return $this->gift_message_text;
    }

    /**
     * Get the [gift_wrap_level] column value.
     * 
     * @return   string
     */
    public function getGiftWrapLevel()
    {

        return $this->gift_wrap_level;
    }

    /**
     * Get the [invoice_requirement] column value.
     * 
     * @return   string
     */
    public function getInvoiceRequirement()
    {

        return $this->invoice_requirement;
    }

    /**
     * Get the [buyer_selected_invoice_category] column value.
     * 
     * @return   string
     */
    public function getBuyerSelectedInvoiceCategory()
    {

        return $this->buyer_selected_invoice_category;
    }

    /**
     * Get the [invoice_title] column value.
     * 
     * @return   string
     */
    public function getInvoiceTitle()
    {

        return $this->invoice_title;
    }

    /**
     * Get the [invoice_information] column value.
     * 
     * @return   string
     */
    public function getInvoiceInformation()
    {

        return $this->invoice_information;
    }

    /**
     * Get the [condition_note] column value.
     * 
     * @return   string
     */
    public function getConditionNote()
    {

        return $this->condition_note;
    }

    /**
     * Get the [condition_id] column value.
     * 
     * @return   string
     */
    public function getConditionId()
    {

        return $this->condition_id;
    }

    /**
     * Get the [condition_subtype_id] column value.
     * 
     * @return   string
     */
    public function getConditionSubtypeId()
    {

        return $this->condition_subtype_id;
    }

    /**
     * Get the [schedule_delivery_start_date] column value.
     * 
     * @return   string
     */
    public function getScheduledDeliveryStartDate()
    {

        return $this->schedule_delivery_start_date;
    }

    /**
     * Get the [schedule_delivery_end_date] column value.
     * 
     * @return   string
     */
    public function getScheduledDeliveryEndDate()
    {

        return $this->schedule_delivery_end_date;
    }

    /**
     * Get the [price_designation] column value.
     * 
     * @return   string
     */
    public function getPriceDesignation()
    {

        return $this->price_designation;
    }

    /**
     * Get the [buyer_customized_url] column value.
     * 
     * @return   string
     */
    public function getBuyerCustomizedURL()
    {

        return $this->buyer_customized_url;
    }

    /**
     * Get the [order_product_id] column value.
     * 
     * @return   int
     */
    public function getOrderProductId()
    {

        return $this->order_product_id;
    }

    /**
     * Get the [optionally formatted] temporal [created_at] column value.
     * 
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw \DateTime object will be returned.
     *
     * @return mixed Formatted date/time value as string or \DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getCreatedAt($format = NULL)
    {
        if ($format === null) {
            return $this->created_at;
        } else {
            return $this->created_at instanceof \DateTime ? $this->created_at->format($format) : null;
        }
    }

    /**
     * Get the [optionally formatted] temporal [updated_at] column value.
     * 
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw \DateTime object will be returned.
     *
     * @return mixed Formatted date/time value as string or \DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getUpdatedAt($format = NULL)
    {
        if ($format === null) {
            return $this->updated_at;
        } else {
            return $this->updated_at instanceof \DateTime ? $this->updated_at->format($format) : null;
        }
    }

    /**
     * Get the [version] column value.
     * 
     * @return   int
     */
    public function getVersion()
    {

        return $this->version;
    }

    /**
     * Get the [optionally formatted] temporal [version_created_at] column value.
     * 
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw \DateTime object will be returned.
     *
     * @return mixed Formatted date/time value as string or \DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getVersionCreatedAt($format = NULL)
    {
        if ($format === null) {
            return $this->version_created_at;
        } else {
            return $this->version_created_at instanceof \DateTime ? $this->version_created_at->format($format) : null;
        }
    }

    /**
     * Get the [version_created_by] column value.
     * 
     * @return   string
     */
    public function getVersionCreatedBy()
    {

        return $this->version_created_by;
    }

    /**
     * Set the value of [order_item_id] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonOrderProduct The current object (for fluent API support)
     */
    public function setOrderItemId($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->order_item_id !== $v) {
            $this->order_item_id = $v;
            $this->modifiedColumns[AmazonOrderProductTableMap::ORDER_ITEM_ID] = true;
        }


        return $this;
    } // setOrderItemId()

    /**
     * Set the value of [amazon_order_id] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonOrderProduct The current object (for fluent API support)
     */
    public function setAmazonOrderId($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->amazon_order_id !== $v) {
            $this->amazon_order_id = $v;
            $this->modifiedColumns[AmazonOrderProductTableMap::AMAZON_ORDER_ID] = true;
        }

        if ($this->aAmazonOrders !== null && $this->aAmazonOrders->getId() !== $v) {
            $this->aAmazonOrders = null;
        }


        return $this;
    } // setAmazonOrderId()

    /**
     * Set the value of [asin] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonOrderProduct The current object (for fluent API support)
     */
    public function setAsin($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->asin !== $v) {
            $this->asin = $v;
            $this->modifiedColumns[AmazonOrderProductTableMap::ASIN] = true;
        }


        return $this;
    } // setAsin()

    /**
     * Set the value of [seller_sku] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonOrderProduct The current object (for fluent API support)
     */
    public function setSellerSku($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->seller_sku !== $v) {
            $this->seller_sku = $v;
            $this->modifiedColumns[AmazonOrderProductTableMap::SELLER_SKU] = true;
        }


        return $this;
    } // setSellerSku()

    /**
     * Set the value of [title] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonOrderProduct The current object (for fluent API support)
     */
    public function setTitle($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->title !== $v) {
            $this->title = $v;
            $this->modifiedColumns[AmazonOrderProductTableMap::TITLE] = true;
        }


        return $this;
    } // setTitle()

    /**
     * Set the value of [quantity_ordered] column.
     * 
     * @param      double $v new value
     * @return   \AmazonIntegration\Model\AmazonOrderProduct The current object (for fluent API support)
     */
    public function setQuantityOrdered($v)
    {
        if ($v !== null) {
            $v = (double) $v;
        }

        if ($this->quantity_ordered !== $v) {
            $this->quantity_ordered = $v;
            $this->modifiedColumns[AmazonOrderProductTableMap::QUANTITY_ORDERED] = true;
        }


        return $this;
    } // setQuantityOrdered()

    /**
     * Set the value of [quantity_shipped] column.
     * 
     * @param      double $v new value
     * @return   \AmazonIntegration\Model\AmazonOrderProduct The current object (for fluent API support)
     */
    public function setQuantityShipped($v)
    {
        if ($v !== null) {
            $v = (double) $v;
        }

        if ($this->quantity_shipped !== $v) {
            $this->quantity_shipped = $v;
            $this->modifiedColumns[AmazonOrderProductTableMap::QUANTITY_SHIPPED] = true;
        }


        return $this;
    } // setQuantityShipped()

    /**
     * Set the value of [points_granted_number] column.
     * 
     * @param      double $v new value
     * @return   \AmazonIntegration\Model\AmazonOrderProduct The current object (for fluent API support)
     */
    public function setPointsGrantedNumber($v)
    {
        if ($v !== null) {
            $v = (double) $v;
        }

        if ($this->points_granted_number !== $v) {
            $this->points_granted_number = $v;
            $this->modifiedColumns[AmazonOrderProductTableMap::POINTS_GRANTED_NUMBER] = true;
        }


        return $this;
    } // setPointsGrantedNumber()

    /**
     * Set the value of [points_granted_currency_code] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonOrderProduct The current object (for fluent API support)
     */
    public function setPointsGrantedCurrencyCode($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->points_granted_currency_code !== $v) {
            $this->points_granted_currency_code = $v;
            $this->modifiedColumns[AmazonOrderProductTableMap::POINTS_GRANTED_CURRENCY_CODE] = true;
        }


        return $this;
    } // setPointsGrantedCurrencyCode()

    /**
     * Set the value of [points_granted_amount] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonOrderProduct The current object (for fluent API support)
     */
    public function setPointsGrantedAmount($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->points_granted_amount !== $v) {
            $this->points_granted_amount = $v;
            $this->modifiedColumns[AmazonOrderProductTableMap::POINTS_GRANTED_AMOUNT] = true;
        }


        return $this;
    } // setPointsGrantedAmount()

    /**
     * Set the value of [item_price_currency_code] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonOrderProduct The current object (for fluent API support)
     */
    public function setItemPriceCurrencyCode($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->item_price_currency_code !== $v) {
            $this->item_price_currency_code = $v;
            $this->modifiedColumns[AmazonOrderProductTableMap::ITEM_PRICE_CURRENCY_CODE] = true;
        }


        return $this;
    } // setItemPriceCurrencyCode()

    /**
     * Set the value of [item_price_amount] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonOrderProduct The current object (for fluent API support)
     */
    public function setItemPriceAmount($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->item_price_amount !== $v) {
            $this->item_price_amount = $v;
            $this->modifiedColumns[AmazonOrderProductTableMap::ITEM_PRICE_AMOUNT] = true;
        }


        return $this;
    } // setItemPriceAmount()

    /**
     * Set the value of [shipping_price_currency_code] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonOrderProduct The current object (for fluent API support)
     */
    public function setShippingPriceCurrencyCode($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->shipping_price_currency_code !== $v) {
            $this->shipping_price_currency_code = $v;
            $this->modifiedColumns[AmazonOrderProductTableMap::SHIPPING_PRICE_CURRENCY_CODE] = true;
        }


        return $this;
    } // setShippingPriceCurrencyCode()

    /**
     * Set the value of [shipping_price_amount] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonOrderProduct The current object (for fluent API support)
     */
    public function setShippingPriceAmount($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->shipping_price_amount !== $v) {
            $this->shipping_price_amount = $v;
            $this->modifiedColumns[AmazonOrderProductTableMap::SHIPPING_PRICE_AMOUNT] = true;
        }


        return $this;
    } // setShippingPriceAmount()

    /**
     * Set the value of [gift_wrap_price_currency_code] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonOrderProduct The current object (for fluent API support)
     */
    public function setGiftWrapPriceCurrencyCode($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->gift_wrap_price_currency_code !== $v) {
            $this->gift_wrap_price_currency_code = $v;
            $this->modifiedColumns[AmazonOrderProductTableMap::GIFT_WRAP_PRICE_CURRENCY_CODE] = true;
        }


        return $this;
    } // setGiftWrapPriceCurrencyCode()

    /**
     * Set the value of [gift_wrap_price_amount] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonOrderProduct The current object (for fluent API support)
     */
    public function setGiftWrapPriceAmount($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->gift_wrap_price_amount !== $v) {
            $this->gift_wrap_price_amount = $v;
            $this->modifiedColumns[AmazonOrderProductTableMap::GIFT_WRAP_PRICE_AMOUNT] = true;
        }


        return $this;
    } // setGiftWrapPriceAmount()

    /**
     * Set the value of [item_tax_currency_code] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonOrderProduct The current object (for fluent API support)
     */
    public function setItemTaxCurrencyCode($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->item_tax_currency_code !== $v) {
            $this->item_tax_currency_code = $v;
            $this->modifiedColumns[AmazonOrderProductTableMap::ITEM_TAX_CURRENCY_CODE] = true;
        }


        return $this;
    } // setItemTaxCurrencyCode()

    /**
     * Set the value of [item_tax_amount] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonOrderProduct The current object (for fluent API support)
     */
    public function setItemTaxAmount($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->item_tax_amount !== $v) {
            $this->item_tax_amount = $v;
            $this->modifiedColumns[AmazonOrderProductTableMap::ITEM_TAX_AMOUNT] = true;
        }


        return $this;
    } // setItemTaxAmount()

    /**
     * Set the value of [shipping_tax_currency_code] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonOrderProduct The current object (for fluent API support)
     */
    public function setShippingTaxCurrencyCode($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->shipping_tax_currency_code !== $v) {
            $this->shipping_tax_currency_code = $v;
            $this->modifiedColumns[AmazonOrderProductTableMap::SHIPPING_TAX_CURRENCY_CODE] = true;
        }


        return $this;
    } // setShippingTaxCurrencyCode()

    /**
     * Set the value of [shipping_tax_amount] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonOrderProduct The current object (for fluent API support)
     */
    public function setShippingTaxAmount($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->shipping_tax_amount !== $v) {
            $this->shipping_tax_amount = $v;
            $this->modifiedColumns[AmazonOrderProductTableMap::SHIPPING_TAX_AMOUNT] = true;
        }


        return $this;
    } // setShippingTaxAmount()

    /**
     * Set the value of [gift_wrap_tax_currency_code] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonOrderProduct The current object (for fluent API support)
     */
    public function setGiftWrapTaxCurrencyCode($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->gift_wrap_tax_currency_code !== $v) {
            $this->gift_wrap_tax_currency_code = $v;
            $this->modifiedColumns[AmazonOrderProductTableMap::GIFT_WRAP_TAX_CURRENCY_CODE] = true;
        }


        return $this;
    } // setGiftWrapTaxCurrencyCode()

    /**
     * Set the value of [gift_wrap_tax_amount] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonOrderProduct The current object (for fluent API support)
     */
    public function setGiftWrapTaxAmount($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->gift_wrap_tax_amount !== $v) {
            $this->gift_wrap_tax_amount = $v;
            $this->modifiedColumns[AmazonOrderProductTableMap::GIFT_WRAP_TAX_AMOUNT] = true;
        }


        return $this;
    } // setGiftWrapTaxAmount()

    /**
     * Set the value of [shipping_discount_currency_code] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonOrderProduct The current object (for fluent API support)
     */
    public function setShippingDiscountCurrencyCode($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->shipping_discount_currency_code !== $v) {
            $this->shipping_discount_currency_code = $v;
            $this->modifiedColumns[AmazonOrderProductTableMap::SHIPPING_DISCOUNT_CURRENCY_CODE] = true;
        }


        return $this;
    } // setShippingDiscountCurrencyCode()

    /**
     * Set the value of [shipping_discount_amount] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonOrderProduct The current object (for fluent API support)
     */
    public function setShippingDiscountAmount($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->shipping_discount_amount !== $v) {
            $this->shipping_discount_amount = $v;
            $this->modifiedColumns[AmazonOrderProductTableMap::SHIPPING_DISCOUNT_AMOUNT] = true;
        }


        return $this;
    } // setShippingDiscountAmount()

    /**
     * Set the value of [promotion_discount_currency_code] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonOrderProduct The current object (for fluent API support)
     */
    public function setPromotionDiscountCurrencyCode($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->promotion_discount_currency_code !== $v) {
            $this->promotion_discount_currency_code = $v;
            $this->modifiedColumns[AmazonOrderProductTableMap::PROMOTION_DISCOUNT_CURRENCY_CODE] = true;
        }


        return $this;
    } // setPromotionDiscountCurrencyCode()

    /**
     * Set the value of [promotion_discount_amount] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonOrderProduct The current object (for fluent API support)
     */
    public function setPromotionDiscountAmount($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->promotion_discount_amount !== $v) {
            $this->promotion_discount_amount = $v;
            $this->modifiedColumns[AmazonOrderProductTableMap::PROMOTION_DISCOUNT_AMOUNT] = true;
        }


        return $this;
    } // setPromotionDiscountAmount()

    /**
     * Set the value of [promotion_id] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonOrderProduct The current object (for fluent API support)
     */
    public function setPromotionId($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->promotion_id !== $v) {
            $this->promotion_id = $v;
            $this->modifiedColumns[AmazonOrderProductTableMap::PROMOTION_ID] = true;
        }


        return $this;
    } // setPromotionId()

    /**
     * Set the value of [cod_fee_currency_code] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonOrderProduct The current object (for fluent API support)
     */
    public function setCodFeeCurrencyCode($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->cod_fee_currency_code !== $v) {
            $this->cod_fee_currency_code = $v;
            $this->modifiedColumns[AmazonOrderProductTableMap::COD_FEE_CURRENCY_CODE] = true;
        }


        return $this;
    } // setCodFeeCurrencyCode()

    /**
     * Set the value of [cod_fee_amount] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonOrderProduct The current object (for fluent API support)
     */
    public function setCodFeeAmount($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->cod_fee_amount !== $v) {
            $this->cod_fee_amount = $v;
            $this->modifiedColumns[AmazonOrderProductTableMap::COD_FEE_AMOUNT] = true;
        }


        return $this;
    } // setCodFeeAmount()

    /**
     * Set the value of [cod_fee_discount_currency_code] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonOrderProduct The current object (for fluent API support)
     */
    public function setCodFeeDiscountCurrencyCode($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->cod_fee_discount_currency_code !== $v) {
            $this->cod_fee_discount_currency_code = $v;
            $this->modifiedColumns[AmazonOrderProductTableMap::COD_FEE_DISCOUNT_CURRENCY_CODE] = true;
        }


        return $this;
    } // setCodFeeDiscountCurrencyCode()

    /**
     * Set the value of [cod_fee_discount_amount] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonOrderProduct The current object (for fluent API support)
     */
    public function setCodFeeDiscountAmount($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->cod_fee_discount_amount !== $v) {
            $this->cod_fee_discount_amount = $v;
            $this->modifiedColumns[AmazonOrderProductTableMap::COD_FEE_DISCOUNT_AMOUNT] = true;
        }


        return $this;
    } // setCodFeeDiscountAmount()

    /**
     * Set the value of [gift_message_text] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonOrderProduct The current object (for fluent API support)
     */
    public function setGiftMessageText($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->gift_message_text !== $v) {
            $this->gift_message_text = $v;
            $this->modifiedColumns[AmazonOrderProductTableMap::GIFT_MESSAGE_TEXT] = true;
        }


        return $this;
    } // setGiftMessageText()

    /**
     * Set the value of [gift_wrap_level] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonOrderProduct The current object (for fluent API support)
     */
    public function setGiftWrapLevel($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->gift_wrap_level !== $v) {
            $this->gift_wrap_level = $v;
            $this->modifiedColumns[AmazonOrderProductTableMap::GIFT_WRAP_LEVEL] = true;
        }


        return $this;
    } // setGiftWrapLevel()

    /**
     * Set the value of [invoice_requirement] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonOrderProduct The current object (for fluent API support)
     */
    public function setInvoiceRequirement($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->invoice_requirement !== $v) {
            $this->invoice_requirement = $v;
            $this->modifiedColumns[AmazonOrderProductTableMap::INVOICE_REQUIREMENT] = true;
        }


        return $this;
    } // setInvoiceRequirement()

    /**
     * Set the value of [buyer_selected_invoice_category] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonOrderProduct The current object (for fluent API support)
     */
    public function setBuyerSelectedInvoiceCategory($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->buyer_selected_invoice_category !== $v) {
            $this->buyer_selected_invoice_category = $v;
            $this->modifiedColumns[AmazonOrderProductTableMap::BUYER_SELECTED_INVOICE_CATEGORY] = true;
        }


        return $this;
    } // setBuyerSelectedInvoiceCategory()

    /**
     * Set the value of [invoice_title] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonOrderProduct The current object (for fluent API support)
     */
    public function setInvoiceTitle($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->invoice_title !== $v) {
            $this->invoice_title = $v;
            $this->modifiedColumns[AmazonOrderProductTableMap::INVOICE_TITLE] = true;
        }


        return $this;
    } // setInvoiceTitle()

    /**
     * Set the value of [invoice_information] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonOrderProduct The current object (for fluent API support)
     */
    public function setInvoiceInformation($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->invoice_information !== $v) {
            $this->invoice_information = $v;
            $this->modifiedColumns[AmazonOrderProductTableMap::INVOICE_INFORMATION] = true;
        }


        return $this;
    } // setInvoiceInformation()

    /**
     * Set the value of [condition_note] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonOrderProduct The current object (for fluent API support)
     */
    public function setConditionNote($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->condition_note !== $v) {
            $this->condition_note = $v;
            $this->modifiedColumns[AmazonOrderProductTableMap::CONDITION_NOTE] = true;
        }


        return $this;
    } // setConditionNote()

    /**
     * Set the value of [condition_id] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonOrderProduct The current object (for fluent API support)
     */
    public function setConditionId($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->condition_id !== $v) {
            $this->condition_id = $v;
            $this->modifiedColumns[AmazonOrderProductTableMap::CONDITION_ID] = true;
        }


        return $this;
    } // setConditionId()

    /**
     * Set the value of [condition_subtype_id] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonOrderProduct The current object (for fluent API support)
     */
    public function setConditionSubtypeId($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->condition_subtype_id !== $v) {
            $this->condition_subtype_id = $v;
            $this->modifiedColumns[AmazonOrderProductTableMap::CONDITION_SUBTYPE_ID] = true;
        }


        return $this;
    } // setConditionSubtypeId()

    /**
     * Set the value of [schedule_delivery_start_date] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonOrderProduct The current object (for fluent API support)
     */
    public function setScheduledDeliveryStartDate($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->schedule_delivery_start_date !== $v) {
            $this->schedule_delivery_start_date = $v;
            $this->modifiedColumns[AmazonOrderProductTableMap::SCHEDULE_DELIVERY_START_DATE] = true;
        }


        return $this;
    } // setScheduledDeliveryStartDate()

    /**
     * Set the value of [schedule_delivery_end_date] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonOrderProduct The current object (for fluent API support)
     */
    public function setScheduledDeliveryEndDate($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->schedule_delivery_end_date !== $v) {
            $this->schedule_delivery_end_date = $v;
            $this->modifiedColumns[AmazonOrderProductTableMap::SCHEDULE_DELIVERY_END_DATE] = true;
        }


        return $this;
    } // setScheduledDeliveryEndDate()

    /**
     * Set the value of [price_designation] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonOrderProduct The current object (for fluent API support)
     */
    public function setPriceDesignation($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->price_designation !== $v) {
            $this->price_designation = $v;
            $this->modifiedColumns[AmazonOrderProductTableMap::PRICE_DESIGNATION] = true;
        }


        return $this;
    } // setPriceDesignation()

    /**
     * Set the value of [buyer_customized_url] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonOrderProduct The current object (for fluent API support)
     */
    public function setBuyerCustomizedURL($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->buyer_customized_url !== $v) {
            $this->buyer_customized_url = $v;
            $this->modifiedColumns[AmazonOrderProductTableMap::BUYER_CUSTOMIZED_URL] = true;
        }


        return $this;
    } // setBuyerCustomizedURL()

    /**
     * Set the value of [order_product_id] column.
     * 
     * @param      int $v new value
     * @return   \AmazonIntegration\Model\AmazonOrderProduct The current object (for fluent API support)
     */
    public function setOrderProductId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->order_product_id !== $v) {
            $this->order_product_id = $v;
            $this->modifiedColumns[AmazonOrderProductTableMap::ORDER_PRODUCT_ID] = true;
        }

        if ($this->aOrderProduct !== null && $this->aOrderProduct->getId() !== $v) {
            $this->aOrderProduct = null;
        }


        return $this;
    } // setOrderProductId()

    /**
     * Sets the value of [created_at] column to a normalized version of the date/time value specified.
     * 
     * @param      mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return   \AmazonIntegration\Model\AmazonOrderProduct The current object (for fluent API support)
     */
    public function setCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->created_at !== null || $dt !== null) {
            if ($dt !== $this->created_at) {
                $this->created_at = $dt;
                $this->modifiedColumns[AmazonOrderProductTableMap::CREATED_AT] = true;
            }
        } // if either are not null


        return $this;
    } // setCreatedAt()

    /**
     * Sets the value of [updated_at] column to a normalized version of the date/time value specified.
     * 
     * @param      mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return   \AmazonIntegration\Model\AmazonOrderProduct The current object (for fluent API support)
     */
    public function setUpdatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->updated_at !== null || $dt !== null) {
            if ($dt !== $this->updated_at) {
                $this->updated_at = $dt;
                $this->modifiedColumns[AmazonOrderProductTableMap::UPDATED_AT] = true;
            }
        } // if either are not null


        return $this;
    } // setUpdatedAt()

    /**
     * Set the value of [version] column.
     * 
     * @param      int $v new value
     * @return   \AmazonIntegration\Model\AmazonOrderProduct The current object (for fluent API support)
     */
    public function setVersion($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->version !== $v) {
            $this->version = $v;
            $this->modifiedColumns[AmazonOrderProductTableMap::VERSION] = true;
        }


        return $this;
    } // setVersion()

    /**
     * Sets the value of [version_created_at] column to a normalized version of the date/time value specified.
     * 
     * @param      mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return   \AmazonIntegration\Model\AmazonOrderProduct The current object (for fluent API support)
     */
    public function setVersionCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->version_created_at !== null || $dt !== null) {
            if ($dt !== $this->version_created_at) {
                $this->version_created_at = $dt;
                $this->modifiedColumns[AmazonOrderProductTableMap::VERSION_CREATED_AT] = true;
            }
        } // if either are not null


        return $this;
    } // setVersionCreatedAt()

    /**
     * Set the value of [version_created_by] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonOrderProduct The current object (for fluent API support)
     */
    public function setVersionCreatedBy($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->version_created_by !== $v) {
            $this->version_created_by = $v;
            $this->modifiedColumns[AmazonOrderProductTableMap::VERSION_CREATED_BY] = true;
        }


        return $this;
    } // setVersionCreatedBy()

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
            if ($this->version !== 0) {
                return false;
            }

        // otherwise, everything was equal, so return TRUE
        return true;
    } // hasOnlyDefaultValues()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array   $row       The row returned by DataFetcher->fetch().
     * @param int     $startcol  0-based offset column which indicates which restultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @param string  $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                  One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                            TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false, $indexType = TableMap::TYPE_NUM)
    {
        try {


            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : AmazonOrderProductTableMap::translateFieldName('OrderItemId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->order_item_id = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : AmazonOrderProductTableMap::translateFieldName('AmazonOrderId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->amazon_order_id = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : AmazonOrderProductTableMap::translateFieldName('Asin', TableMap::TYPE_PHPNAME, $indexType)];
            $this->asin = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : AmazonOrderProductTableMap::translateFieldName('SellerSku', TableMap::TYPE_PHPNAME, $indexType)];
            $this->seller_sku = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : AmazonOrderProductTableMap::translateFieldName('Title', TableMap::TYPE_PHPNAME, $indexType)];
            $this->title = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : AmazonOrderProductTableMap::translateFieldName('QuantityOrdered', TableMap::TYPE_PHPNAME, $indexType)];
            $this->quantity_ordered = (null !== $col) ? (double) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : AmazonOrderProductTableMap::translateFieldName('QuantityShipped', TableMap::TYPE_PHPNAME, $indexType)];
            $this->quantity_shipped = (null !== $col) ? (double) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : AmazonOrderProductTableMap::translateFieldName('PointsGrantedNumber', TableMap::TYPE_PHPNAME, $indexType)];
            $this->points_granted_number = (null !== $col) ? (double) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : AmazonOrderProductTableMap::translateFieldName('PointsGrantedCurrencyCode', TableMap::TYPE_PHPNAME, $indexType)];
            $this->points_granted_currency_code = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : AmazonOrderProductTableMap::translateFieldName('PointsGrantedAmount', TableMap::TYPE_PHPNAME, $indexType)];
            $this->points_granted_amount = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 10 + $startcol : AmazonOrderProductTableMap::translateFieldName('ItemPriceCurrencyCode', TableMap::TYPE_PHPNAME, $indexType)];
            $this->item_price_currency_code = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 11 + $startcol : AmazonOrderProductTableMap::translateFieldName('ItemPriceAmount', TableMap::TYPE_PHPNAME, $indexType)];
            $this->item_price_amount = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 12 + $startcol : AmazonOrderProductTableMap::translateFieldName('ShippingPriceCurrencyCode', TableMap::TYPE_PHPNAME, $indexType)];
            $this->shipping_price_currency_code = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 13 + $startcol : AmazonOrderProductTableMap::translateFieldName('ShippingPriceAmount', TableMap::TYPE_PHPNAME, $indexType)];
            $this->shipping_price_amount = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 14 + $startcol : AmazonOrderProductTableMap::translateFieldName('GiftWrapPriceCurrencyCode', TableMap::TYPE_PHPNAME, $indexType)];
            $this->gift_wrap_price_currency_code = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 15 + $startcol : AmazonOrderProductTableMap::translateFieldName('GiftWrapPriceAmount', TableMap::TYPE_PHPNAME, $indexType)];
            $this->gift_wrap_price_amount = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 16 + $startcol : AmazonOrderProductTableMap::translateFieldName('ItemTaxCurrencyCode', TableMap::TYPE_PHPNAME, $indexType)];
            $this->item_tax_currency_code = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 17 + $startcol : AmazonOrderProductTableMap::translateFieldName('ItemTaxAmount', TableMap::TYPE_PHPNAME, $indexType)];
            $this->item_tax_amount = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 18 + $startcol : AmazonOrderProductTableMap::translateFieldName('ShippingTaxCurrencyCode', TableMap::TYPE_PHPNAME, $indexType)];
            $this->shipping_tax_currency_code = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 19 + $startcol : AmazonOrderProductTableMap::translateFieldName('ShippingTaxAmount', TableMap::TYPE_PHPNAME, $indexType)];
            $this->shipping_tax_amount = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 20 + $startcol : AmazonOrderProductTableMap::translateFieldName('GiftWrapTaxCurrencyCode', TableMap::TYPE_PHPNAME, $indexType)];
            $this->gift_wrap_tax_currency_code = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 21 + $startcol : AmazonOrderProductTableMap::translateFieldName('GiftWrapTaxAmount', TableMap::TYPE_PHPNAME, $indexType)];
            $this->gift_wrap_tax_amount = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 22 + $startcol : AmazonOrderProductTableMap::translateFieldName('ShippingDiscountCurrencyCode', TableMap::TYPE_PHPNAME, $indexType)];
            $this->shipping_discount_currency_code = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 23 + $startcol : AmazonOrderProductTableMap::translateFieldName('ShippingDiscountAmount', TableMap::TYPE_PHPNAME, $indexType)];
            $this->shipping_discount_amount = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 24 + $startcol : AmazonOrderProductTableMap::translateFieldName('PromotionDiscountCurrencyCode', TableMap::TYPE_PHPNAME, $indexType)];
            $this->promotion_discount_currency_code = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 25 + $startcol : AmazonOrderProductTableMap::translateFieldName('PromotionDiscountAmount', TableMap::TYPE_PHPNAME, $indexType)];
            $this->promotion_discount_amount = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 26 + $startcol : AmazonOrderProductTableMap::translateFieldName('PromotionId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->promotion_id = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 27 + $startcol : AmazonOrderProductTableMap::translateFieldName('CodFeeCurrencyCode', TableMap::TYPE_PHPNAME, $indexType)];
            $this->cod_fee_currency_code = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 28 + $startcol : AmazonOrderProductTableMap::translateFieldName('CodFeeAmount', TableMap::TYPE_PHPNAME, $indexType)];
            $this->cod_fee_amount = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 29 + $startcol : AmazonOrderProductTableMap::translateFieldName('CodFeeDiscountCurrencyCode', TableMap::TYPE_PHPNAME, $indexType)];
            $this->cod_fee_discount_currency_code = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 30 + $startcol : AmazonOrderProductTableMap::translateFieldName('CodFeeDiscountAmount', TableMap::TYPE_PHPNAME, $indexType)];
            $this->cod_fee_discount_amount = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 31 + $startcol : AmazonOrderProductTableMap::translateFieldName('GiftMessageText', TableMap::TYPE_PHPNAME, $indexType)];
            $this->gift_message_text = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 32 + $startcol : AmazonOrderProductTableMap::translateFieldName('GiftWrapLevel', TableMap::TYPE_PHPNAME, $indexType)];
            $this->gift_wrap_level = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 33 + $startcol : AmazonOrderProductTableMap::translateFieldName('InvoiceRequirement', TableMap::TYPE_PHPNAME, $indexType)];
            $this->invoice_requirement = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 34 + $startcol : AmazonOrderProductTableMap::translateFieldName('BuyerSelectedInvoiceCategory', TableMap::TYPE_PHPNAME, $indexType)];
            $this->buyer_selected_invoice_category = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 35 + $startcol : AmazonOrderProductTableMap::translateFieldName('InvoiceTitle', TableMap::TYPE_PHPNAME, $indexType)];
            $this->invoice_title = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 36 + $startcol : AmazonOrderProductTableMap::translateFieldName('InvoiceInformation', TableMap::TYPE_PHPNAME, $indexType)];
            $this->invoice_information = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 37 + $startcol : AmazonOrderProductTableMap::translateFieldName('ConditionNote', TableMap::TYPE_PHPNAME, $indexType)];
            $this->condition_note = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 38 + $startcol : AmazonOrderProductTableMap::translateFieldName('ConditionId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->condition_id = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 39 + $startcol : AmazonOrderProductTableMap::translateFieldName('ConditionSubtypeId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->condition_subtype_id = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 40 + $startcol : AmazonOrderProductTableMap::translateFieldName('ScheduledDeliveryStartDate', TableMap::TYPE_PHPNAME, $indexType)];
            $this->schedule_delivery_start_date = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 41 + $startcol : AmazonOrderProductTableMap::translateFieldName('ScheduledDeliveryEndDate', TableMap::TYPE_PHPNAME, $indexType)];
            $this->schedule_delivery_end_date = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 42 + $startcol : AmazonOrderProductTableMap::translateFieldName('PriceDesignation', TableMap::TYPE_PHPNAME, $indexType)];
            $this->price_designation = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 43 + $startcol : AmazonOrderProductTableMap::translateFieldName('BuyerCustomizedURL', TableMap::TYPE_PHPNAME, $indexType)];
            $this->buyer_customized_url = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 44 + $startcol : AmazonOrderProductTableMap::translateFieldName('OrderProductId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->order_product_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 45 + $startcol : AmazonOrderProductTableMap::translateFieldName('CreatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->created_at = (null !== $col) ? PropelDateTime::newInstance($col, null, '\DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 46 + $startcol : AmazonOrderProductTableMap::translateFieldName('UpdatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->updated_at = (null !== $col) ? PropelDateTime::newInstance($col, null, '\DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 47 + $startcol : AmazonOrderProductTableMap::translateFieldName('Version', TableMap::TYPE_PHPNAME, $indexType)];
            $this->version = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 48 + $startcol : AmazonOrderProductTableMap::translateFieldName('VersionCreatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->version_created_at = (null !== $col) ? PropelDateTime::newInstance($col, null, '\DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 49 + $startcol : AmazonOrderProductTableMap::translateFieldName('VersionCreatedBy', TableMap::TYPE_PHPNAME, $indexType)];
            $this->version_created_by = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 50; // 50 = AmazonOrderProductTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating \AmazonIntegration\Model\AmazonOrderProduct object", 0, $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws PropelException
     */
    public function ensureConsistency()
    {
        if ($this->aAmazonOrders !== null && $this->amazon_order_id !== $this->aAmazonOrders->getId()) {
            $this->aAmazonOrders = null;
        }
        if ($this->aOrderProduct !== null && $this->order_product_id !== $this->aOrderProduct->getId()) {
            $this->aOrderProduct = null;
        }
    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param      boolean $deep (optional) Whether to also de-associated any related objects.
     * @param      ConnectionInterface $con (optional) The ConnectionInterface connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(AmazonOrderProductTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildAmazonOrderProductQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aOrderProduct = null;
            $this->aAmazonOrders = null;
            $this->collAmazonOrderProductVersions = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see AmazonOrderProduct::setDeleted()
     * @see AmazonOrderProduct::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(AmazonOrderProductTableMap::DATABASE_NAME);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = ChildAmazonOrderProductQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $con->commit();
                $this->setDeleted(true);
            } else {
                $con->commit();
            }
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see doSave()
     */
    public function save(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(AmazonOrderProductTableMap::DATABASE_NAME);
        }

        $con->beginTransaction();
        $isInsert = $this->isNew();
        try {
            $ret = $this->preSave($con);
            // versionable behavior
            if ($this->isVersioningNecessary()) {
                $this->setVersion($this->isNew() ? 1 : $this->getLastVersionNumber($con) + 1);
                if (!$this->isColumnModified(AmazonOrderProductTableMap::VERSION_CREATED_AT)) {
                    $this->setVersionCreatedAt(time());
                }
                $createVersion = true; // for postSave hook
            }
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
                // timestampable behavior
                if (!$this->isColumnModified(AmazonOrderProductTableMap::CREATED_AT)) {
                    $this->setCreatedAt(time());
                }
                if (!$this->isColumnModified(AmazonOrderProductTableMap::UPDATED_AT)) {
                    $this->setUpdatedAt(time());
                }
            } else {
                $ret = $ret && $this->preUpdate($con);
                // timestampable behavior
                if ($this->isModified() && !$this->isColumnModified(AmazonOrderProductTableMap::UPDATED_AT)) {
                    $this->setUpdatedAt(time());
                }
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                // versionable behavior
                if (isset($createVersion)) {
                    $this->addVersion($con);
                }
                AmazonOrderProductTableMap::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }
            $con->commit();

            return $affectedRows;
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see save()
     */
    protected function doSave(ConnectionInterface $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            // We call the save method on the following object(s) if they
            // were passed to this object by their corresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aOrderProduct !== null) {
                if ($this->aOrderProduct->isModified() || $this->aOrderProduct->isNew()) {
                    $affectedRows += $this->aOrderProduct->save($con);
                }
                $this->setOrderProduct($this->aOrderProduct);
            }

            if ($this->aAmazonOrders !== null) {
                if ($this->aAmazonOrders->isModified() || $this->aAmazonOrders->isNew()) {
                    $affectedRows += $this->aAmazonOrders->save($con);
                }
                $this->setAmazonOrders($this->aAmazonOrders);
            }

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                } else {
                    $this->doUpdate($con);
                }
                $affectedRows += 1;
                $this->resetModified();
            }

            if ($this->amazonOrderProductVersionsScheduledForDeletion !== null) {
                if (!$this->amazonOrderProductVersionsScheduledForDeletion->isEmpty()) {
                    \AmazonIntegration\Model\AmazonOrderProductVersionQuery::create()
                        ->filterByPrimaryKeys($this->amazonOrderProductVersionsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->amazonOrderProductVersionsScheduledForDeletion = null;
                }
            }

                if ($this->collAmazonOrderProductVersions !== null) {
            foreach ($this->collAmazonOrderProductVersions as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @throws PropelException
     * @see doSave()
     */
    protected function doInsert(ConnectionInterface $con)
    {
        $modifiedColumns = array();
        $index = 0;


         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(AmazonOrderProductTableMap::ORDER_ITEM_ID)) {
            $modifiedColumns[':p' . $index++]  = 'ORDER_ITEM_ID';
        }
        if ($this->isColumnModified(AmazonOrderProductTableMap::AMAZON_ORDER_ID)) {
            $modifiedColumns[':p' . $index++]  = 'AMAZON_ORDER_ID';
        }
        if ($this->isColumnModified(AmazonOrderProductTableMap::ASIN)) {
            $modifiedColumns[':p' . $index++]  = 'ASIN';
        }
        if ($this->isColumnModified(AmazonOrderProductTableMap::SELLER_SKU)) {
            $modifiedColumns[':p' . $index++]  = 'SELLER_SKU';
        }
        if ($this->isColumnModified(AmazonOrderProductTableMap::TITLE)) {
            $modifiedColumns[':p' . $index++]  = 'TITLE';
        }
        if ($this->isColumnModified(AmazonOrderProductTableMap::QUANTITY_ORDERED)) {
            $modifiedColumns[':p' . $index++]  = 'QUANTITY_ORDERED';
        }
        if ($this->isColumnModified(AmazonOrderProductTableMap::QUANTITY_SHIPPED)) {
            $modifiedColumns[':p' . $index++]  = 'QUANTITY_SHIPPED';
        }
        if ($this->isColumnModified(AmazonOrderProductTableMap::POINTS_GRANTED_NUMBER)) {
            $modifiedColumns[':p' . $index++]  = 'POINTS_GRANTED_NUMBER';
        }
        if ($this->isColumnModified(AmazonOrderProductTableMap::POINTS_GRANTED_CURRENCY_CODE)) {
            $modifiedColumns[':p' . $index++]  = 'POINTS_GRANTED_CURRENCY_CODE';
        }
        if ($this->isColumnModified(AmazonOrderProductTableMap::POINTS_GRANTED_AMOUNT)) {
            $modifiedColumns[':p' . $index++]  = 'POINTS_GRANTED_AMOUNT';
        }
        if ($this->isColumnModified(AmazonOrderProductTableMap::ITEM_PRICE_CURRENCY_CODE)) {
            $modifiedColumns[':p' . $index++]  = 'ITEM_PRICE_CURRENCY_CODE';
        }
        if ($this->isColumnModified(AmazonOrderProductTableMap::ITEM_PRICE_AMOUNT)) {
            $modifiedColumns[':p' . $index++]  = 'ITEM_PRICE_AMOUNT';
        }
        if ($this->isColumnModified(AmazonOrderProductTableMap::SHIPPING_PRICE_CURRENCY_CODE)) {
            $modifiedColumns[':p' . $index++]  = 'SHIPPING_PRICE_CURRENCY_CODE';
        }
        if ($this->isColumnModified(AmazonOrderProductTableMap::SHIPPING_PRICE_AMOUNT)) {
            $modifiedColumns[':p' . $index++]  = 'SHIPPING_PRICE_AMOUNT';
        }
        if ($this->isColumnModified(AmazonOrderProductTableMap::GIFT_WRAP_PRICE_CURRENCY_CODE)) {
            $modifiedColumns[':p' . $index++]  = 'GIFT_WRAP_PRICE_CURRENCY_CODE';
        }
        if ($this->isColumnModified(AmazonOrderProductTableMap::GIFT_WRAP_PRICE_AMOUNT)) {
            $modifiedColumns[':p' . $index++]  = 'GIFT_WRAP_PRICE_AMOUNT';
        }
        if ($this->isColumnModified(AmazonOrderProductTableMap::ITEM_TAX_CURRENCY_CODE)) {
            $modifiedColumns[':p' . $index++]  = 'ITEM_TAX_CURRENCY_CODE';
        }
        if ($this->isColumnModified(AmazonOrderProductTableMap::ITEM_TAX_AMOUNT)) {
            $modifiedColumns[':p' . $index++]  = 'ITEM_TAX_AMOUNT';
        }
        if ($this->isColumnModified(AmazonOrderProductTableMap::SHIPPING_TAX_CURRENCY_CODE)) {
            $modifiedColumns[':p' . $index++]  = 'SHIPPING_TAX_CURRENCY_CODE';
        }
        if ($this->isColumnModified(AmazonOrderProductTableMap::SHIPPING_TAX_AMOUNT)) {
            $modifiedColumns[':p' . $index++]  = 'SHIPPING_TAX_AMOUNT';
        }
        if ($this->isColumnModified(AmazonOrderProductTableMap::GIFT_WRAP_TAX_CURRENCY_CODE)) {
            $modifiedColumns[':p' . $index++]  = 'GIFT_WRAP_TAX_CURRENCY_CODE';
        }
        if ($this->isColumnModified(AmazonOrderProductTableMap::GIFT_WRAP_TAX_AMOUNT)) {
            $modifiedColumns[':p' . $index++]  = 'GIFT_WRAP_TAX_AMOUNT';
        }
        if ($this->isColumnModified(AmazonOrderProductTableMap::SHIPPING_DISCOUNT_CURRENCY_CODE)) {
            $modifiedColumns[':p' . $index++]  = 'SHIPPING_DISCOUNT_CURRENCY_CODE';
        }
        if ($this->isColumnModified(AmazonOrderProductTableMap::SHIPPING_DISCOUNT_AMOUNT)) {
            $modifiedColumns[':p' . $index++]  = 'SHIPPING_DISCOUNT_AMOUNT';
        }
        if ($this->isColumnModified(AmazonOrderProductTableMap::PROMOTION_DISCOUNT_CURRENCY_CODE)) {
            $modifiedColumns[':p' . $index++]  = 'PROMOTION_DISCOUNT_CURRENCY_CODE';
        }
        if ($this->isColumnModified(AmazonOrderProductTableMap::PROMOTION_DISCOUNT_AMOUNT)) {
            $modifiedColumns[':p' . $index++]  = 'PROMOTION_DISCOUNT_AMOUNT';
        }
        if ($this->isColumnModified(AmazonOrderProductTableMap::PROMOTION_ID)) {
            $modifiedColumns[':p' . $index++]  = 'PROMOTION_ID';
        }
        if ($this->isColumnModified(AmazonOrderProductTableMap::COD_FEE_CURRENCY_CODE)) {
            $modifiedColumns[':p' . $index++]  = 'COD_FEE_CURRENCY_CODE';
        }
        if ($this->isColumnModified(AmazonOrderProductTableMap::COD_FEE_AMOUNT)) {
            $modifiedColumns[':p' . $index++]  = 'COD_FEE_AMOUNT';
        }
        if ($this->isColumnModified(AmazonOrderProductTableMap::COD_FEE_DISCOUNT_CURRENCY_CODE)) {
            $modifiedColumns[':p' . $index++]  = 'COD_FEE_DISCOUNT_CURRENCY_CODE';
        }
        if ($this->isColumnModified(AmazonOrderProductTableMap::COD_FEE_DISCOUNT_AMOUNT)) {
            $modifiedColumns[':p' . $index++]  = 'COD_FEE_DISCOUNT_AMOUNT';
        }
        if ($this->isColumnModified(AmazonOrderProductTableMap::GIFT_MESSAGE_TEXT)) {
            $modifiedColumns[':p' . $index++]  = 'GIFT_MESSAGE_TEXT';
        }
        if ($this->isColumnModified(AmazonOrderProductTableMap::GIFT_WRAP_LEVEL)) {
            $modifiedColumns[':p' . $index++]  = 'GIFT_WRAP_LEVEL';
        }
        if ($this->isColumnModified(AmazonOrderProductTableMap::INVOICE_REQUIREMENT)) {
            $modifiedColumns[':p' . $index++]  = 'INVOICE_REQUIREMENT';
        }
        if ($this->isColumnModified(AmazonOrderProductTableMap::BUYER_SELECTED_INVOICE_CATEGORY)) {
            $modifiedColumns[':p' . $index++]  = 'BUYER_SELECTED_INVOICE_CATEGORY';
        }
        if ($this->isColumnModified(AmazonOrderProductTableMap::INVOICE_TITLE)) {
            $modifiedColumns[':p' . $index++]  = 'INVOICE_TITLE';
        }
        if ($this->isColumnModified(AmazonOrderProductTableMap::INVOICE_INFORMATION)) {
            $modifiedColumns[':p' . $index++]  = 'INVOICE_INFORMATION';
        }
        if ($this->isColumnModified(AmazonOrderProductTableMap::CONDITION_NOTE)) {
            $modifiedColumns[':p' . $index++]  = 'CONDITION_NOTE';
        }
        if ($this->isColumnModified(AmazonOrderProductTableMap::CONDITION_ID)) {
            $modifiedColumns[':p' . $index++]  = 'CONDITION_ID';
        }
        if ($this->isColumnModified(AmazonOrderProductTableMap::CONDITION_SUBTYPE_ID)) {
            $modifiedColumns[':p' . $index++]  = 'CONDITION_SUBTYPE_ID';
        }
        if ($this->isColumnModified(AmazonOrderProductTableMap::SCHEDULE_DELIVERY_START_DATE)) {
            $modifiedColumns[':p' . $index++]  = 'SCHEDULE_DELIVERY_START_DATE';
        }
        if ($this->isColumnModified(AmazonOrderProductTableMap::SCHEDULE_DELIVERY_END_DATE)) {
            $modifiedColumns[':p' . $index++]  = 'SCHEDULE_DELIVERY_END_DATE';
        }
        if ($this->isColumnModified(AmazonOrderProductTableMap::PRICE_DESIGNATION)) {
            $modifiedColumns[':p' . $index++]  = 'PRICE_DESIGNATION';
        }
        if ($this->isColumnModified(AmazonOrderProductTableMap::BUYER_CUSTOMIZED_URL)) {
            $modifiedColumns[':p' . $index++]  = 'BUYER_CUSTOMIZED_URL';
        }
        if ($this->isColumnModified(AmazonOrderProductTableMap::ORDER_PRODUCT_ID)) {
            $modifiedColumns[':p' . $index++]  = 'ORDER_PRODUCT_ID';
        }
        if ($this->isColumnModified(AmazonOrderProductTableMap::CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'CREATED_AT';
        }
        if ($this->isColumnModified(AmazonOrderProductTableMap::UPDATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'UPDATED_AT';
        }
        if ($this->isColumnModified(AmazonOrderProductTableMap::VERSION)) {
            $modifiedColumns[':p' . $index++]  = 'VERSION';
        }
        if ($this->isColumnModified(AmazonOrderProductTableMap::VERSION_CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'VERSION_CREATED_AT';
        }
        if ($this->isColumnModified(AmazonOrderProductTableMap::VERSION_CREATED_BY)) {
            $modifiedColumns[':p' . $index++]  = 'VERSION_CREATED_BY';
        }

        $sql = sprintf(
            'INSERT INTO amazon_order_product (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'ORDER_ITEM_ID':                        
                        $stmt->bindValue($identifier, $this->order_item_id, PDO::PARAM_STR);
                        break;
                    case 'AMAZON_ORDER_ID':                        
                        $stmt->bindValue($identifier, $this->amazon_order_id, PDO::PARAM_STR);
                        break;
                    case 'ASIN':                        
                        $stmt->bindValue($identifier, $this->asin, PDO::PARAM_STR);
                        break;
                    case 'SELLER_SKU':                        
                        $stmt->bindValue($identifier, $this->seller_sku, PDO::PARAM_STR);
                        break;
                    case 'TITLE':                        
                        $stmt->bindValue($identifier, $this->title, PDO::PARAM_STR);
                        break;
                    case 'QUANTITY_ORDERED':                        
                        $stmt->bindValue($identifier, $this->quantity_ordered, PDO::PARAM_STR);
                        break;
                    case 'QUANTITY_SHIPPED':                        
                        $stmt->bindValue($identifier, $this->quantity_shipped, PDO::PARAM_STR);
                        break;
                    case 'POINTS_GRANTED_NUMBER':                        
                        $stmt->bindValue($identifier, $this->points_granted_number, PDO::PARAM_STR);
                        break;
                    case 'POINTS_GRANTED_CURRENCY_CODE':                        
                        $stmt->bindValue($identifier, $this->points_granted_currency_code, PDO::PARAM_STR);
                        break;
                    case 'POINTS_GRANTED_AMOUNT':                        
                        $stmt->bindValue($identifier, $this->points_granted_amount, PDO::PARAM_STR);
                        break;
                    case 'ITEM_PRICE_CURRENCY_CODE':                        
                        $stmt->bindValue($identifier, $this->item_price_currency_code, PDO::PARAM_STR);
                        break;
                    case 'ITEM_PRICE_AMOUNT':                        
                        $stmt->bindValue($identifier, $this->item_price_amount, PDO::PARAM_STR);
                        break;
                    case 'SHIPPING_PRICE_CURRENCY_CODE':                        
                        $stmt->bindValue($identifier, $this->shipping_price_currency_code, PDO::PARAM_STR);
                        break;
                    case 'SHIPPING_PRICE_AMOUNT':                        
                        $stmt->bindValue($identifier, $this->shipping_price_amount, PDO::PARAM_STR);
                        break;
                    case 'GIFT_WRAP_PRICE_CURRENCY_CODE':                        
                        $stmt->bindValue($identifier, $this->gift_wrap_price_currency_code, PDO::PARAM_STR);
                        break;
                    case 'GIFT_WRAP_PRICE_AMOUNT':                        
                        $stmt->bindValue($identifier, $this->gift_wrap_price_amount, PDO::PARAM_STR);
                        break;
                    case 'ITEM_TAX_CURRENCY_CODE':                        
                        $stmt->bindValue($identifier, $this->item_tax_currency_code, PDO::PARAM_STR);
                        break;
                    case 'ITEM_TAX_AMOUNT':                        
                        $stmt->bindValue($identifier, $this->item_tax_amount, PDO::PARAM_STR);
                        break;
                    case 'SHIPPING_TAX_CURRENCY_CODE':                        
                        $stmt->bindValue($identifier, $this->shipping_tax_currency_code, PDO::PARAM_STR);
                        break;
                    case 'SHIPPING_TAX_AMOUNT':                        
                        $stmt->bindValue($identifier, $this->shipping_tax_amount, PDO::PARAM_STR);
                        break;
                    case 'GIFT_WRAP_TAX_CURRENCY_CODE':                        
                        $stmt->bindValue($identifier, $this->gift_wrap_tax_currency_code, PDO::PARAM_STR);
                        break;
                    case 'GIFT_WRAP_TAX_AMOUNT':                        
                        $stmt->bindValue($identifier, $this->gift_wrap_tax_amount, PDO::PARAM_STR);
                        break;
                    case 'SHIPPING_DISCOUNT_CURRENCY_CODE':                        
                        $stmt->bindValue($identifier, $this->shipping_discount_currency_code, PDO::PARAM_STR);
                        break;
                    case 'SHIPPING_DISCOUNT_AMOUNT':                        
                        $stmt->bindValue($identifier, $this->shipping_discount_amount, PDO::PARAM_STR);
                        break;
                    case 'PROMOTION_DISCOUNT_CURRENCY_CODE':                        
                        $stmt->bindValue($identifier, $this->promotion_discount_currency_code, PDO::PARAM_STR);
                        break;
                    case 'PROMOTION_DISCOUNT_AMOUNT':                        
                        $stmt->bindValue($identifier, $this->promotion_discount_amount, PDO::PARAM_STR);
                        break;
                    case 'PROMOTION_ID':                        
                        $stmt->bindValue($identifier, $this->promotion_id, PDO::PARAM_STR);
                        break;
                    case 'COD_FEE_CURRENCY_CODE':                        
                        $stmt->bindValue($identifier, $this->cod_fee_currency_code, PDO::PARAM_STR);
                        break;
                    case 'COD_FEE_AMOUNT':                        
                        $stmt->bindValue($identifier, $this->cod_fee_amount, PDO::PARAM_STR);
                        break;
                    case 'COD_FEE_DISCOUNT_CURRENCY_CODE':                        
                        $stmt->bindValue($identifier, $this->cod_fee_discount_currency_code, PDO::PARAM_STR);
                        break;
                    case 'COD_FEE_DISCOUNT_AMOUNT':                        
                        $stmt->bindValue($identifier, $this->cod_fee_discount_amount, PDO::PARAM_STR);
                        break;
                    case 'GIFT_MESSAGE_TEXT':                        
                        $stmt->bindValue($identifier, $this->gift_message_text, PDO::PARAM_STR);
                        break;
                    case 'GIFT_WRAP_LEVEL':                        
                        $stmt->bindValue($identifier, $this->gift_wrap_level, PDO::PARAM_STR);
                        break;
                    case 'INVOICE_REQUIREMENT':                        
                        $stmt->bindValue($identifier, $this->invoice_requirement, PDO::PARAM_STR);
                        break;
                    case 'BUYER_SELECTED_INVOICE_CATEGORY':                        
                        $stmt->bindValue($identifier, $this->buyer_selected_invoice_category, PDO::PARAM_STR);
                        break;
                    case 'INVOICE_TITLE':                        
                        $stmt->bindValue($identifier, $this->invoice_title, PDO::PARAM_STR);
                        break;
                    case 'INVOICE_INFORMATION':                        
                        $stmt->bindValue($identifier, $this->invoice_information, PDO::PARAM_STR);
                        break;
                    case 'CONDITION_NOTE':                        
                        $stmt->bindValue($identifier, $this->condition_note, PDO::PARAM_STR);
                        break;
                    case 'CONDITION_ID':                        
                        $stmt->bindValue($identifier, $this->condition_id, PDO::PARAM_STR);
                        break;
                    case 'CONDITION_SUBTYPE_ID':                        
                        $stmt->bindValue($identifier, $this->condition_subtype_id, PDO::PARAM_STR);
                        break;
                    case 'SCHEDULE_DELIVERY_START_DATE':                        
                        $stmt->bindValue($identifier, $this->schedule_delivery_start_date, PDO::PARAM_STR);
                        break;
                    case 'SCHEDULE_DELIVERY_END_DATE':                        
                        $stmt->bindValue($identifier, $this->schedule_delivery_end_date, PDO::PARAM_STR);
                        break;
                    case 'PRICE_DESIGNATION':                        
                        $stmt->bindValue($identifier, $this->price_designation, PDO::PARAM_STR);
                        break;
                    case 'BUYER_CUSTOMIZED_URL':                        
                        $stmt->bindValue($identifier, $this->buyer_customized_url, PDO::PARAM_STR);
                        break;
                    case 'ORDER_PRODUCT_ID':                        
                        $stmt->bindValue($identifier, $this->order_product_id, PDO::PARAM_INT);
                        break;
                    case 'CREATED_AT':                        
                        $stmt->bindValue($identifier, $this->created_at ? $this->created_at->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                    case 'UPDATED_AT':                        
                        $stmt->bindValue($identifier, $this->updated_at ? $this->updated_at->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                    case 'VERSION':                        
                        $stmt->bindValue($identifier, $this->version, PDO::PARAM_INT);
                        break;
                    case 'VERSION_CREATED_AT':                        
                        $stmt->bindValue($identifier, $this->version_created_at ? $this->version_created_at->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                    case 'VERSION_CREATED_BY':                        
                        $stmt->bindValue($identifier, $this->version_created_by, PDO::PARAM_STR);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @return Integer Number of updated rows
     * @see doSave()
     */
    protected function doUpdate(ConnectionInterface $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();

        return $selectCriteria->doUpdate($valuesCriteria, $con);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param      string $name name
     * @param      string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return mixed Value of field.
     */
    public function getByName($name, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = AmazonOrderProductTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param      int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getOrderItemId();
                break;
            case 1:
                return $this->getAmazonOrderId();
                break;
            case 2:
                return $this->getAsin();
                break;
            case 3:
                return $this->getSellerSku();
                break;
            case 4:
                return $this->getTitle();
                break;
            case 5:
                return $this->getQuantityOrdered();
                break;
            case 6:
                return $this->getQuantityShipped();
                break;
            case 7:
                return $this->getPointsGrantedNumber();
                break;
            case 8:
                return $this->getPointsGrantedCurrencyCode();
                break;
            case 9:
                return $this->getPointsGrantedAmount();
                break;
            case 10:
                return $this->getItemPriceCurrencyCode();
                break;
            case 11:
                return $this->getItemPriceAmount();
                break;
            case 12:
                return $this->getShippingPriceCurrencyCode();
                break;
            case 13:
                return $this->getShippingPriceAmount();
                break;
            case 14:
                return $this->getGiftWrapPriceCurrencyCode();
                break;
            case 15:
                return $this->getGiftWrapPriceAmount();
                break;
            case 16:
                return $this->getItemTaxCurrencyCode();
                break;
            case 17:
                return $this->getItemTaxAmount();
                break;
            case 18:
                return $this->getShippingTaxCurrencyCode();
                break;
            case 19:
                return $this->getShippingTaxAmount();
                break;
            case 20:
                return $this->getGiftWrapTaxCurrencyCode();
                break;
            case 21:
                return $this->getGiftWrapTaxAmount();
                break;
            case 22:
                return $this->getShippingDiscountCurrencyCode();
                break;
            case 23:
                return $this->getShippingDiscountAmount();
                break;
            case 24:
                return $this->getPromotionDiscountCurrencyCode();
                break;
            case 25:
                return $this->getPromotionDiscountAmount();
                break;
            case 26:
                return $this->getPromotionId();
                break;
            case 27:
                return $this->getCodFeeCurrencyCode();
                break;
            case 28:
                return $this->getCodFeeAmount();
                break;
            case 29:
                return $this->getCodFeeDiscountCurrencyCode();
                break;
            case 30:
                return $this->getCodFeeDiscountAmount();
                break;
            case 31:
                return $this->getGiftMessageText();
                break;
            case 32:
                return $this->getGiftWrapLevel();
                break;
            case 33:
                return $this->getInvoiceRequirement();
                break;
            case 34:
                return $this->getBuyerSelectedInvoiceCategory();
                break;
            case 35:
                return $this->getInvoiceTitle();
                break;
            case 36:
                return $this->getInvoiceInformation();
                break;
            case 37:
                return $this->getConditionNote();
                break;
            case 38:
                return $this->getConditionId();
                break;
            case 39:
                return $this->getConditionSubtypeId();
                break;
            case 40:
                return $this->getScheduledDeliveryStartDate();
                break;
            case 41:
                return $this->getScheduledDeliveryEndDate();
                break;
            case 42:
                return $this->getPriceDesignation();
                break;
            case 43:
                return $this->getBuyerCustomizedURL();
                break;
            case 44:
                return $this->getOrderProductId();
                break;
            case 45:
                return $this->getCreatedAt();
                break;
            case 46:
                return $this->getUpdatedAt();
                break;
            case 47:
                return $this->getVersion();
                break;
            case 48:
                return $this->getVersionCreatedAt();
                break;
            case 49:
                return $this->getVersionCreatedBy();
                break;
            default:
                return null;
                break;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param     string  $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME,
     *                    TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                    Defaults to TableMap::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to TRUE.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = TableMap::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {
        if (isset($alreadyDumpedObjects['AmazonOrderProduct'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['AmazonOrderProduct'][$this->getPrimaryKey()] = true;
        $keys = AmazonOrderProductTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getOrderItemId(),
            $keys[1] => $this->getAmazonOrderId(),
            $keys[2] => $this->getAsin(),
            $keys[3] => $this->getSellerSku(),
            $keys[4] => $this->getTitle(),
            $keys[5] => $this->getQuantityOrdered(),
            $keys[6] => $this->getQuantityShipped(),
            $keys[7] => $this->getPointsGrantedNumber(),
            $keys[8] => $this->getPointsGrantedCurrencyCode(),
            $keys[9] => $this->getPointsGrantedAmount(),
            $keys[10] => $this->getItemPriceCurrencyCode(),
            $keys[11] => $this->getItemPriceAmount(),
            $keys[12] => $this->getShippingPriceCurrencyCode(),
            $keys[13] => $this->getShippingPriceAmount(),
            $keys[14] => $this->getGiftWrapPriceCurrencyCode(),
            $keys[15] => $this->getGiftWrapPriceAmount(),
            $keys[16] => $this->getItemTaxCurrencyCode(),
            $keys[17] => $this->getItemTaxAmount(),
            $keys[18] => $this->getShippingTaxCurrencyCode(),
            $keys[19] => $this->getShippingTaxAmount(),
            $keys[20] => $this->getGiftWrapTaxCurrencyCode(),
            $keys[21] => $this->getGiftWrapTaxAmount(),
            $keys[22] => $this->getShippingDiscountCurrencyCode(),
            $keys[23] => $this->getShippingDiscountAmount(),
            $keys[24] => $this->getPromotionDiscountCurrencyCode(),
            $keys[25] => $this->getPromotionDiscountAmount(),
            $keys[26] => $this->getPromotionId(),
            $keys[27] => $this->getCodFeeCurrencyCode(),
            $keys[28] => $this->getCodFeeAmount(),
            $keys[29] => $this->getCodFeeDiscountCurrencyCode(),
            $keys[30] => $this->getCodFeeDiscountAmount(),
            $keys[31] => $this->getGiftMessageText(),
            $keys[32] => $this->getGiftWrapLevel(),
            $keys[33] => $this->getInvoiceRequirement(),
            $keys[34] => $this->getBuyerSelectedInvoiceCategory(),
            $keys[35] => $this->getInvoiceTitle(),
            $keys[36] => $this->getInvoiceInformation(),
            $keys[37] => $this->getConditionNote(),
            $keys[38] => $this->getConditionId(),
            $keys[39] => $this->getConditionSubtypeId(),
            $keys[40] => $this->getScheduledDeliveryStartDate(),
            $keys[41] => $this->getScheduledDeliveryEndDate(),
            $keys[42] => $this->getPriceDesignation(),
            $keys[43] => $this->getBuyerCustomizedURL(),
            $keys[44] => $this->getOrderProductId(),
            $keys[45] => $this->getCreatedAt(),
            $keys[46] => $this->getUpdatedAt(),
            $keys[47] => $this->getVersion(),
            $keys[48] => $this->getVersionCreatedAt(),
            $keys[49] => $this->getVersionCreatedBy(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }
        
        if ($includeForeignObjects) {
            if (null !== $this->aOrderProduct) {
                $result['OrderProduct'] = $this->aOrderProduct->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aAmazonOrders) {
                $result['AmazonOrders'] = $this->aAmazonOrders->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collAmazonOrderProductVersions) {
                $result['AmazonOrderProductVersions'] = $this->collAmazonOrderProductVersions->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param      string $name
     * @param      mixed  $value field value
     * @param      string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return void
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = AmazonOrderProductTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param      int $pos position in xml schema
     * @param      mixed $value field value
     * @return void
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setOrderItemId($value);
                break;
            case 1:
                $this->setAmazonOrderId($value);
                break;
            case 2:
                $this->setAsin($value);
                break;
            case 3:
                $this->setSellerSku($value);
                break;
            case 4:
                $this->setTitle($value);
                break;
            case 5:
                $this->setQuantityOrdered($value);
                break;
            case 6:
                $this->setQuantityShipped($value);
                break;
            case 7:
                $this->setPointsGrantedNumber($value);
                break;
            case 8:
                $this->setPointsGrantedCurrencyCode($value);
                break;
            case 9:
                $this->setPointsGrantedAmount($value);
                break;
            case 10:
                $this->setItemPriceCurrencyCode($value);
                break;
            case 11:
                $this->setItemPriceAmount($value);
                break;
            case 12:
                $this->setShippingPriceCurrencyCode($value);
                break;
            case 13:
                $this->setShippingPriceAmount($value);
                break;
            case 14:
                $this->setGiftWrapPriceCurrencyCode($value);
                break;
            case 15:
                $this->setGiftWrapPriceAmount($value);
                break;
            case 16:
                $this->setItemTaxCurrencyCode($value);
                break;
            case 17:
                $this->setItemTaxAmount($value);
                break;
            case 18:
                $this->setShippingTaxCurrencyCode($value);
                break;
            case 19:
                $this->setShippingTaxAmount($value);
                break;
            case 20:
                $this->setGiftWrapTaxCurrencyCode($value);
                break;
            case 21:
                $this->setGiftWrapTaxAmount($value);
                break;
            case 22:
                $this->setShippingDiscountCurrencyCode($value);
                break;
            case 23:
                $this->setShippingDiscountAmount($value);
                break;
            case 24:
                $this->setPromotionDiscountCurrencyCode($value);
                break;
            case 25:
                $this->setPromotionDiscountAmount($value);
                break;
            case 26:
                $this->setPromotionId($value);
                break;
            case 27:
                $this->setCodFeeCurrencyCode($value);
                break;
            case 28:
                $this->setCodFeeAmount($value);
                break;
            case 29:
                $this->setCodFeeDiscountCurrencyCode($value);
                break;
            case 30:
                $this->setCodFeeDiscountAmount($value);
                break;
            case 31:
                $this->setGiftMessageText($value);
                break;
            case 32:
                $this->setGiftWrapLevel($value);
                break;
            case 33:
                $this->setInvoiceRequirement($value);
                break;
            case 34:
                $this->setBuyerSelectedInvoiceCategory($value);
                break;
            case 35:
                $this->setInvoiceTitle($value);
                break;
            case 36:
                $this->setInvoiceInformation($value);
                break;
            case 37:
                $this->setConditionNote($value);
                break;
            case 38:
                $this->setConditionId($value);
                break;
            case 39:
                $this->setConditionSubtypeId($value);
                break;
            case 40:
                $this->setScheduledDeliveryStartDate($value);
                break;
            case 41:
                $this->setScheduledDeliveryEndDate($value);
                break;
            case 42:
                $this->setPriceDesignation($value);
                break;
            case 43:
                $this->setBuyerCustomizedURL($value);
                break;
            case 44:
                $this->setOrderProductId($value);
                break;
            case 45:
                $this->setCreatedAt($value);
                break;
            case 46:
                $this->setUpdatedAt($value);
                break;
            case 47:
                $this->setVersion($value);
                break;
            case 48:
                $this->setVersionCreatedAt($value);
                break;
            case 49:
                $this->setVersionCreatedBy($value);
                break;
        } // switch()
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param      array  $arr     An array to populate the object from.
     * @param      string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = TableMap::TYPE_PHPNAME)
    {
        $keys = AmazonOrderProductTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setOrderItemId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setAmazonOrderId($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setAsin($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setSellerSku($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setTitle($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setQuantityOrdered($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setQuantityShipped($arr[$keys[6]]);
        if (array_key_exists($keys[7], $arr)) $this->setPointsGrantedNumber($arr[$keys[7]]);
        if (array_key_exists($keys[8], $arr)) $this->setPointsGrantedCurrencyCode($arr[$keys[8]]);
        if (array_key_exists($keys[9], $arr)) $this->setPointsGrantedAmount($arr[$keys[9]]);
        if (array_key_exists($keys[10], $arr)) $this->setItemPriceCurrencyCode($arr[$keys[10]]);
        if (array_key_exists($keys[11], $arr)) $this->setItemPriceAmount($arr[$keys[11]]);
        if (array_key_exists($keys[12], $arr)) $this->setShippingPriceCurrencyCode($arr[$keys[12]]);
        if (array_key_exists($keys[13], $arr)) $this->setShippingPriceAmount($arr[$keys[13]]);
        if (array_key_exists($keys[14], $arr)) $this->setGiftWrapPriceCurrencyCode($arr[$keys[14]]);
        if (array_key_exists($keys[15], $arr)) $this->setGiftWrapPriceAmount($arr[$keys[15]]);
        if (array_key_exists($keys[16], $arr)) $this->setItemTaxCurrencyCode($arr[$keys[16]]);
        if (array_key_exists($keys[17], $arr)) $this->setItemTaxAmount($arr[$keys[17]]);
        if (array_key_exists($keys[18], $arr)) $this->setShippingTaxCurrencyCode($arr[$keys[18]]);
        if (array_key_exists($keys[19], $arr)) $this->setShippingTaxAmount($arr[$keys[19]]);
        if (array_key_exists($keys[20], $arr)) $this->setGiftWrapTaxCurrencyCode($arr[$keys[20]]);
        if (array_key_exists($keys[21], $arr)) $this->setGiftWrapTaxAmount($arr[$keys[21]]);
        if (array_key_exists($keys[22], $arr)) $this->setShippingDiscountCurrencyCode($arr[$keys[22]]);
        if (array_key_exists($keys[23], $arr)) $this->setShippingDiscountAmount($arr[$keys[23]]);
        if (array_key_exists($keys[24], $arr)) $this->setPromotionDiscountCurrencyCode($arr[$keys[24]]);
        if (array_key_exists($keys[25], $arr)) $this->setPromotionDiscountAmount($arr[$keys[25]]);
        if (array_key_exists($keys[26], $arr)) $this->setPromotionId($arr[$keys[26]]);
        if (array_key_exists($keys[27], $arr)) $this->setCodFeeCurrencyCode($arr[$keys[27]]);
        if (array_key_exists($keys[28], $arr)) $this->setCodFeeAmount($arr[$keys[28]]);
        if (array_key_exists($keys[29], $arr)) $this->setCodFeeDiscountCurrencyCode($arr[$keys[29]]);
        if (array_key_exists($keys[30], $arr)) $this->setCodFeeDiscountAmount($arr[$keys[30]]);
        if (array_key_exists($keys[31], $arr)) $this->setGiftMessageText($arr[$keys[31]]);
        if (array_key_exists($keys[32], $arr)) $this->setGiftWrapLevel($arr[$keys[32]]);
        if (array_key_exists($keys[33], $arr)) $this->setInvoiceRequirement($arr[$keys[33]]);
        if (array_key_exists($keys[34], $arr)) $this->setBuyerSelectedInvoiceCategory($arr[$keys[34]]);
        if (array_key_exists($keys[35], $arr)) $this->setInvoiceTitle($arr[$keys[35]]);
        if (array_key_exists($keys[36], $arr)) $this->setInvoiceInformation($arr[$keys[36]]);
        if (array_key_exists($keys[37], $arr)) $this->setConditionNote($arr[$keys[37]]);
        if (array_key_exists($keys[38], $arr)) $this->setConditionId($arr[$keys[38]]);
        if (array_key_exists($keys[39], $arr)) $this->setConditionSubtypeId($arr[$keys[39]]);
        if (array_key_exists($keys[40], $arr)) $this->setScheduledDeliveryStartDate($arr[$keys[40]]);
        if (array_key_exists($keys[41], $arr)) $this->setScheduledDeliveryEndDate($arr[$keys[41]]);
        if (array_key_exists($keys[42], $arr)) $this->setPriceDesignation($arr[$keys[42]]);
        if (array_key_exists($keys[43], $arr)) $this->setBuyerCustomizedURL($arr[$keys[43]]);
        if (array_key_exists($keys[44], $arr)) $this->setOrderProductId($arr[$keys[44]]);
        if (array_key_exists($keys[45], $arr)) $this->setCreatedAt($arr[$keys[45]]);
        if (array_key_exists($keys[46], $arr)) $this->setUpdatedAt($arr[$keys[46]]);
        if (array_key_exists($keys[47], $arr)) $this->setVersion($arr[$keys[47]]);
        if (array_key_exists($keys[48], $arr)) $this->setVersionCreatedAt($arr[$keys[48]]);
        if (array_key_exists($keys[49], $arr)) $this->setVersionCreatedBy($arr[$keys[49]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(AmazonOrderProductTableMap::DATABASE_NAME);

        if ($this->isColumnModified(AmazonOrderProductTableMap::ORDER_ITEM_ID)) $criteria->add(AmazonOrderProductTableMap::ORDER_ITEM_ID, $this->order_item_id);
        if ($this->isColumnModified(AmazonOrderProductTableMap::AMAZON_ORDER_ID)) $criteria->add(AmazonOrderProductTableMap::AMAZON_ORDER_ID, $this->amazon_order_id);
        if ($this->isColumnModified(AmazonOrderProductTableMap::ASIN)) $criteria->add(AmazonOrderProductTableMap::ASIN, $this->asin);
        if ($this->isColumnModified(AmazonOrderProductTableMap::SELLER_SKU)) $criteria->add(AmazonOrderProductTableMap::SELLER_SKU, $this->seller_sku);
        if ($this->isColumnModified(AmazonOrderProductTableMap::TITLE)) $criteria->add(AmazonOrderProductTableMap::TITLE, $this->title);
        if ($this->isColumnModified(AmazonOrderProductTableMap::QUANTITY_ORDERED)) $criteria->add(AmazonOrderProductTableMap::QUANTITY_ORDERED, $this->quantity_ordered);
        if ($this->isColumnModified(AmazonOrderProductTableMap::QUANTITY_SHIPPED)) $criteria->add(AmazonOrderProductTableMap::QUANTITY_SHIPPED, $this->quantity_shipped);
        if ($this->isColumnModified(AmazonOrderProductTableMap::POINTS_GRANTED_NUMBER)) $criteria->add(AmazonOrderProductTableMap::POINTS_GRANTED_NUMBER, $this->points_granted_number);
        if ($this->isColumnModified(AmazonOrderProductTableMap::POINTS_GRANTED_CURRENCY_CODE)) $criteria->add(AmazonOrderProductTableMap::POINTS_GRANTED_CURRENCY_CODE, $this->points_granted_currency_code);
        if ($this->isColumnModified(AmazonOrderProductTableMap::POINTS_GRANTED_AMOUNT)) $criteria->add(AmazonOrderProductTableMap::POINTS_GRANTED_AMOUNT, $this->points_granted_amount);
        if ($this->isColumnModified(AmazonOrderProductTableMap::ITEM_PRICE_CURRENCY_CODE)) $criteria->add(AmazonOrderProductTableMap::ITEM_PRICE_CURRENCY_CODE, $this->item_price_currency_code);
        if ($this->isColumnModified(AmazonOrderProductTableMap::ITEM_PRICE_AMOUNT)) $criteria->add(AmazonOrderProductTableMap::ITEM_PRICE_AMOUNT, $this->item_price_amount);
        if ($this->isColumnModified(AmazonOrderProductTableMap::SHIPPING_PRICE_CURRENCY_CODE)) $criteria->add(AmazonOrderProductTableMap::SHIPPING_PRICE_CURRENCY_CODE, $this->shipping_price_currency_code);
        if ($this->isColumnModified(AmazonOrderProductTableMap::SHIPPING_PRICE_AMOUNT)) $criteria->add(AmazonOrderProductTableMap::SHIPPING_PRICE_AMOUNT, $this->shipping_price_amount);
        if ($this->isColumnModified(AmazonOrderProductTableMap::GIFT_WRAP_PRICE_CURRENCY_CODE)) $criteria->add(AmazonOrderProductTableMap::GIFT_WRAP_PRICE_CURRENCY_CODE, $this->gift_wrap_price_currency_code);
        if ($this->isColumnModified(AmazonOrderProductTableMap::GIFT_WRAP_PRICE_AMOUNT)) $criteria->add(AmazonOrderProductTableMap::GIFT_WRAP_PRICE_AMOUNT, $this->gift_wrap_price_amount);
        if ($this->isColumnModified(AmazonOrderProductTableMap::ITEM_TAX_CURRENCY_CODE)) $criteria->add(AmazonOrderProductTableMap::ITEM_TAX_CURRENCY_CODE, $this->item_tax_currency_code);
        if ($this->isColumnModified(AmazonOrderProductTableMap::ITEM_TAX_AMOUNT)) $criteria->add(AmazonOrderProductTableMap::ITEM_TAX_AMOUNT, $this->item_tax_amount);
        if ($this->isColumnModified(AmazonOrderProductTableMap::SHIPPING_TAX_CURRENCY_CODE)) $criteria->add(AmazonOrderProductTableMap::SHIPPING_TAX_CURRENCY_CODE, $this->shipping_tax_currency_code);
        if ($this->isColumnModified(AmazonOrderProductTableMap::SHIPPING_TAX_AMOUNT)) $criteria->add(AmazonOrderProductTableMap::SHIPPING_TAX_AMOUNT, $this->shipping_tax_amount);
        if ($this->isColumnModified(AmazonOrderProductTableMap::GIFT_WRAP_TAX_CURRENCY_CODE)) $criteria->add(AmazonOrderProductTableMap::GIFT_WRAP_TAX_CURRENCY_CODE, $this->gift_wrap_tax_currency_code);
        if ($this->isColumnModified(AmazonOrderProductTableMap::GIFT_WRAP_TAX_AMOUNT)) $criteria->add(AmazonOrderProductTableMap::GIFT_WRAP_TAX_AMOUNT, $this->gift_wrap_tax_amount);
        if ($this->isColumnModified(AmazonOrderProductTableMap::SHIPPING_DISCOUNT_CURRENCY_CODE)) $criteria->add(AmazonOrderProductTableMap::SHIPPING_DISCOUNT_CURRENCY_CODE, $this->shipping_discount_currency_code);
        if ($this->isColumnModified(AmazonOrderProductTableMap::SHIPPING_DISCOUNT_AMOUNT)) $criteria->add(AmazonOrderProductTableMap::SHIPPING_DISCOUNT_AMOUNT, $this->shipping_discount_amount);
        if ($this->isColumnModified(AmazonOrderProductTableMap::PROMOTION_DISCOUNT_CURRENCY_CODE)) $criteria->add(AmazonOrderProductTableMap::PROMOTION_DISCOUNT_CURRENCY_CODE, $this->promotion_discount_currency_code);
        if ($this->isColumnModified(AmazonOrderProductTableMap::PROMOTION_DISCOUNT_AMOUNT)) $criteria->add(AmazonOrderProductTableMap::PROMOTION_DISCOUNT_AMOUNT, $this->promotion_discount_amount);
        if ($this->isColumnModified(AmazonOrderProductTableMap::PROMOTION_ID)) $criteria->add(AmazonOrderProductTableMap::PROMOTION_ID, $this->promotion_id);
        if ($this->isColumnModified(AmazonOrderProductTableMap::COD_FEE_CURRENCY_CODE)) $criteria->add(AmazonOrderProductTableMap::COD_FEE_CURRENCY_CODE, $this->cod_fee_currency_code);
        if ($this->isColumnModified(AmazonOrderProductTableMap::COD_FEE_AMOUNT)) $criteria->add(AmazonOrderProductTableMap::COD_FEE_AMOUNT, $this->cod_fee_amount);
        if ($this->isColumnModified(AmazonOrderProductTableMap::COD_FEE_DISCOUNT_CURRENCY_CODE)) $criteria->add(AmazonOrderProductTableMap::COD_FEE_DISCOUNT_CURRENCY_CODE, $this->cod_fee_discount_currency_code);
        if ($this->isColumnModified(AmazonOrderProductTableMap::COD_FEE_DISCOUNT_AMOUNT)) $criteria->add(AmazonOrderProductTableMap::COD_FEE_DISCOUNT_AMOUNT, $this->cod_fee_discount_amount);
        if ($this->isColumnModified(AmazonOrderProductTableMap::GIFT_MESSAGE_TEXT)) $criteria->add(AmazonOrderProductTableMap::GIFT_MESSAGE_TEXT, $this->gift_message_text);
        if ($this->isColumnModified(AmazonOrderProductTableMap::GIFT_WRAP_LEVEL)) $criteria->add(AmazonOrderProductTableMap::GIFT_WRAP_LEVEL, $this->gift_wrap_level);
        if ($this->isColumnModified(AmazonOrderProductTableMap::INVOICE_REQUIREMENT)) $criteria->add(AmazonOrderProductTableMap::INVOICE_REQUIREMENT, $this->invoice_requirement);
        if ($this->isColumnModified(AmazonOrderProductTableMap::BUYER_SELECTED_INVOICE_CATEGORY)) $criteria->add(AmazonOrderProductTableMap::BUYER_SELECTED_INVOICE_CATEGORY, $this->buyer_selected_invoice_category);
        if ($this->isColumnModified(AmazonOrderProductTableMap::INVOICE_TITLE)) $criteria->add(AmazonOrderProductTableMap::INVOICE_TITLE, $this->invoice_title);
        if ($this->isColumnModified(AmazonOrderProductTableMap::INVOICE_INFORMATION)) $criteria->add(AmazonOrderProductTableMap::INVOICE_INFORMATION, $this->invoice_information);
        if ($this->isColumnModified(AmazonOrderProductTableMap::CONDITION_NOTE)) $criteria->add(AmazonOrderProductTableMap::CONDITION_NOTE, $this->condition_note);
        if ($this->isColumnModified(AmazonOrderProductTableMap::CONDITION_ID)) $criteria->add(AmazonOrderProductTableMap::CONDITION_ID, $this->condition_id);
        if ($this->isColumnModified(AmazonOrderProductTableMap::CONDITION_SUBTYPE_ID)) $criteria->add(AmazonOrderProductTableMap::CONDITION_SUBTYPE_ID, $this->condition_subtype_id);
        if ($this->isColumnModified(AmazonOrderProductTableMap::SCHEDULE_DELIVERY_START_DATE)) $criteria->add(AmazonOrderProductTableMap::SCHEDULE_DELIVERY_START_DATE, $this->schedule_delivery_start_date);
        if ($this->isColumnModified(AmazonOrderProductTableMap::SCHEDULE_DELIVERY_END_DATE)) $criteria->add(AmazonOrderProductTableMap::SCHEDULE_DELIVERY_END_DATE, $this->schedule_delivery_end_date);
        if ($this->isColumnModified(AmazonOrderProductTableMap::PRICE_DESIGNATION)) $criteria->add(AmazonOrderProductTableMap::PRICE_DESIGNATION, $this->price_designation);
        if ($this->isColumnModified(AmazonOrderProductTableMap::BUYER_CUSTOMIZED_URL)) $criteria->add(AmazonOrderProductTableMap::BUYER_CUSTOMIZED_URL, $this->buyer_customized_url);
        if ($this->isColumnModified(AmazonOrderProductTableMap::ORDER_PRODUCT_ID)) $criteria->add(AmazonOrderProductTableMap::ORDER_PRODUCT_ID, $this->order_product_id);
        if ($this->isColumnModified(AmazonOrderProductTableMap::CREATED_AT)) $criteria->add(AmazonOrderProductTableMap::CREATED_AT, $this->created_at);
        if ($this->isColumnModified(AmazonOrderProductTableMap::UPDATED_AT)) $criteria->add(AmazonOrderProductTableMap::UPDATED_AT, $this->updated_at);
        if ($this->isColumnModified(AmazonOrderProductTableMap::VERSION)) $criteria->add(AmazonOrderProductTableMap::VERSION, $this->version);
        if ($this->isColumnModified(AmazonOrderProductTableMap::VERSION_CREATED_AT)) $criteria->add(AmazonOrderProductTableMap::VERSION_CREATED_AT, $this->version_created_at);
        if ($this->isColumnModified(AmazonOrderProductTableMap::VERSION_CREATED_BY)) $criteria->add(AmazonOrderProductTableMap::VERSION_CREATED_BY, $this->version_created_by);

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = new Criteria(AmazonOrderProductTableMap::DATABASE_NAME);
        $criteria->add(AmazonOrderProductTableMap::ORDER_ITEM_ID, $this->order_item_id);

        return $criteria;
    }

    /**
     * Returns the primary key for this object (row).
     * @return   string
     */
    public function getPrimaryKey()
    {
        return $this->getOrderItemId();
    }

    /**
     * Generic method to set the primary key (order_item_id column).
     *
     * @param       string $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setOrderItemId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {

        return null === $this->getOrderItemId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \AmazonIntegration\Model\AmazonOrderProduct (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setOrderItemId($this->getOrderItemId());
        $copyObj->setAmazonOrderId($this->getAmazonOrderId());
        $copyObj->setAsin($this->getAsin());
        $copyObj->setSellerSku($this->getSellerSku());
        $copyObj->setTitle($this->getTitle());
        $copyObj->setQuantityOrdered($this->getQuantityOrdered());
        $copyObj->setQuantityShipped($this->getQuantityShipped());
        $copyObj->setPointsGrantedNumber($this->getPointsGrantedNumber());
        $copyObj->setPointsGrantedCurrencyCode($this->getPointsGrantedCurrencyCode());
        $copyObj->setPointsGrantedAmount($this->getPointsGrantedAmount());
        $copyObj->setItemPriceCurrencyCode($this->getItemPriceCurrencyCode());
        $copyObj->setItemPriceAmount($this->getItemPriceAmount());
        $copyObj->setShippingPriceCurrencyCode($this->getShippingPriceCurrencyCode());
        $copyObj->setShippingPriceAmount($this->getShippingPriceAmount());
        $copyObj->setGiftWrapPriceCurrencyCode($this->getGiftWrapPriceCurrencyCode());
        $copyObj->setGiftWrapPriceAmount($this->getGiftWrapPriceAmount());
        $copyObj->setItemTaxCurrencyCode($this->getItemTaxCurrencyCode());
        $copyObj->setItemTaxAmount($this->getItemTaxAmount());
        $copyObj->setShippingTaxCurrencyCode($this->getShippingTaxCurrencyCode());
        $copyObj->setShippingTaxAmount($this->getShippingTaxAmount());
        $copyObj->setGiftWrapTaxCurrencyCode($this->getGiftWrapTaxCurrencyCode());
        $copyObj->setGiftWrapTaxAmount($this->getGiftWrapTaxAmount());
        $copyObj->setShippingDiscountCurrencyCode($this->getShippingDiscountCurrencyCode());
        $copyObj->setShippingDiscountAmount($this->getShippingDiscountAmount());
        $copyObj->setPromotionDiscountCurrencyCode($this->getPromotionDiscountCurrencyCode());
        $copyObj->setPromotionDiscountAmount($this->getPromotionDiscountAmount());
        $copyObj->setPromotionId($this->getPromotionId());
        $copyObj->setCodFeeCurrencyCode($this->getCodFeeCurrencyCode());
        $copyObj->setCodFeeAmount($this->getCodFeeAmount());
        $copyObj->setCodFeeDiscountCurrencyCode($this->getCodFeeDiscountCurrencyCode());
        $copyObj->setCodFeeDiscountAmount($this->getCodFeeDiscountAmount());
        $copyObj->setGiftMessageText($this->getGiftMessageText());
        $copyObj->setGiftWrapLevel($this->getGiftWrapLevel());
        $copyObj->setInvoiceRequirement($this->getInvoiceRequirement());
        $copyObj->setBuyerSelectedInvoiceCategory($this->getBuyerSelectedInvoiceCategory());
        $copyObj->setInvoiceTitle($this->getInvoiceTitle());
        $copyObj->setInvoiceInformation($this->getInvoiceInformation());
        $copyObj->setConditionNote($this->getConditionNote());
        $copyObj->setConditionId($this->getConditionId());
        $copyObj->setConditionSubtypeId($this->getConditionSubtypeId());
        $copyObj->setScheduledDeliveryStartDate($this->getScheduledDeliveryStartDate());
        $copyObj->setScheduledDeliveryEndDate($this->getScheduledDeliveryEndDate());
        $copyObj->setPriceDesignation($this->getPriceDesignation());
        $copyObj->setBuyerCustomizedURL($this->getBuyerCustomizedURL());
        $copyObj->setOrderProductId($this->getOrderProductId());
        $copyObj->setCreatedAt($this->getCreatedAt());
        $copyObj->setUpdatedAt($this->getUpdatedAt());
        $copyObj->setVersion($this->getVersion());
        $copyObj->setVersionCreatedAt($this->getVersionCreatedAt());
        $copyObj->setVersionCreatedBy($this->getVersionCreatedBy());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getAmazonOrderProductVersions() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addAmazonOrderProductVersion($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return                 \AmazonIntegration\Model\AmazonOrderProduct Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }

    /**
     * Declares an association between this object and a ChildOrderProduct object.
     *
     * @param                  ChildOrderProduct $v
     * @return                 \AmazonIntegration\Model\AmazonOrderProduct The current object (for fluent API support)
     * @throws PropelException
     */
    public function setOrderProduct(ChildOrderProduct $v = null)
    {
        if ($v === null) {
            $this->setOrderProductId(NULL);
        } else {
            $this->setOrderProductId($v->getId());
        }

        $this->aOrderProduct = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildOrderProduct object, it will not be re-added.
        if ($v !== null) {
            $v->addAmazonOrderProduct($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildOrderProduct object
     *
     * @param      ConnectionInterface $con Optional Connection object.
     * @return                 ChildOrderProduct The associated ChildOrderProduct object.
     * @throws PropelException
     */
    public function getOrderProduct(ConnectionInterface $con = null)
    {
        if ($this->aOrderProduct === null && ($this->order_product_id !== null)) {
            $this->aOrderProduct = OrderProductQuery::create()->findPk($this->order_product_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aOrderProduct->addAmazonOrderProducts($this);
             */
        }

        return $this->aOrderProduct;
    }

    /**
     * Declares an association between this object and a ChildAmazonOrders object.
     *
     * @param                  ChildAmazonOrders $v
     * @return                 \AmazonIntegration\Model\AmazonOrderProduct The current object (for fluent API support)
     * @throws PropelException
     */
    public function setAmazonOrders(ChildAmazonOrders $v = null)
    {
        if ($v === null) {
            $this->setAmazonOrderId(NULL);
        } else {
            $this->setAmazonOrderId($v->getId());
        }

        $this->aAmazonOrders = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildAmazonOrders object, it will not be re-added.
        if ($v !== null) {
            $v->addAmazonOrderProduct($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildAmazonOrders object
     *
     * @param      ConnectionInterface $con Optional Connection object.
     * @return                 ChildAmazonOrders The associated ChildAmazonOrders object.
     * @throws PropelException
     */
    public function getAmazonOrders(ConnectionInterface $con = null)
    {
        if ($this->aAmazonOrders === null && (($this->amazon_order_id !== "" && $this->amazon_order_id !== null))) {
            $this->aAmazonOrders = ChildAmazonOrdersQuery::create()->findPk($this->amazon_order_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aAmazonOrders->addAmazonOrderProducts($this);
             */
        }

        return $this->aAmazonOrders;
    }


    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param      string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('AmazonOrderProductVersion' == $relationName) {
            return $this->initAmazonOrderProductVersions();
        }
    }

    /**
     * Clears out the collAmazonOrderProductVersions collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addAmazonOrderProductVersions()
     */
    public function clearAmazonOrderProductVersions()
    {
        $this->collAmazonOrderProductVersions = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collAmazonOrderProductVersions collection loaded partially.
     */
    public function resetPartialAmazonOrderProductVersions($v = true)
    {
        $this->collAmazonOrderProductVersionsPartial = $v;
    }

    /**
     * Initializes the collAmazonOrderProductVersions collection.
     *
     * By default this just sets the collAmazonOrderProductVersions collection to an empty array (like clearcollAmazonOrderProductVersions());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initAmazonOrderProductVersions($overrideExisting = true)
    {
        if (null !== $this->collAmazonOrderProductVersions && !$overrideExisting) {
            return;
        }
        $this->collAmazonOrderProductVersions = new ObjectCollection();
        $this->collAmazonOrderProductVersions->setModel('\AmazonIntegration\Model\AmazonOrderProductVersion');
    }

    /**
     * Gets an array of ChildAmazonOrderProductVersion objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildAmazonOrderProduct is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return Collection|ChildAmazonOrderProductVersion[] List of ChildAmazonOrderProductVersion objects
     * @throws PropelException
     */
    public function getAmazonOrderProductVersions($criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collAmazonOrderProductVersionsPartial && !$this->isNew();
        if (null === $this->collAmazonOrderProductVersions || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collAmazonOrderProductVersions) {
                // return empty collection
                $this->initAmazonOrderProductVersions();
            } else {
                $collAmazonOrderProductVersions = ChildAmazonOrderProductVersionQuery::create(null, $criteria)
                    ->filterByAmazonOrderProduct($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collAmazonOrderProductVersionsPartial && count($collAmazonOrderProductVersions)) {
                        $this->initAmazonOrderProductVersions(false);

                        foreach ($collAmazonOrderProductVersions as $obj) {
                            if (false == $this->collAmazonOrderProductVersions->contains($obj)) {
                                $this->collAmazonOrderProductVersions->append($obj);
                            }
                        }

                        $this->collAmazonOrderProductVersionsPartial = true;
                    }

                    reset($collAmazonOrderProductVersions);

                    return $collAmazonOrderProductVersions;
                }

                if ($partial && $this->collAmazonOrderProductVersions) {
                    foreach ($this->collAmazonOrderProductVersions as $obj) {
                        if ($obj->isNew()) {
                            $collAmazonOrderProductVersions[] = $obj;
                        }
                    }
                }

                $this->collAmazonOrderProductVersions = $collAmazonOrderProductVersions;
                $this->collAmazonOrderProductVersionsPartial = false;
            }
        }

        return $this->collAmazonOrderProductVersions;
    }

    /**
     * Sets a collection of AmazonOrderProductVersion objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $amazonOrderProductVersions A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return   ChildAmazonOrderProduct The current object (for fluent API support)
     */
    public function setAmazonOrderProductVersions(Collection $amazonOrderProductVersions, ConnectionInterface $con = null)
    {
        $amazonOrderProductVersionsToDelete = $this->getAmazonOrderProductVersions(new Criteria(), $con)->diff($amazonOrderProductVersions);

        
        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->amazonOrderProductVersionsScheduledForDeletion = clone $amazonOrderProductVersionsToDelete;

        foreach ($amazonOrderProductVersionsToDelete as $amazonOrderProductVersionRemoved) {
            $amazonOrderProductVersionRemoved->setAmazonOrderProduct(null);
        }

        $this->collAmazonOrderProductVersions = null;
        foreach ($amazonOrderProductVersions as $amazonOrderProductVersion) {
            $this->addAmazonOrderProductVersion($amazonOrderProductVersion);
        }

        $this->collAmazonOrderProductVersions = $amazonOrderProductVersions;
        $this->collAmazonOrderProductVersionsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related AmazonOrderProductVersion objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related AmazonOrderProductVersion objects.
     * @throws PropelException
     */
    public function countAmazonOrderProductVersions(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collAmazonOrderProductVersionsPartial && !$this->isNew();
        if (null === $this->collAmazonOrderProductVersions || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collAmazonOrderProductVersions) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getAmazonOrderProductVersions());
            }

            $query = ChildAmazonOrderProductVersionQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByAmazonOrderProduct($this)
                ->count($con);
        }

        return count($this->collAmazonOrderProductVersions);
    }

    /**
     * Method called to associate a ChildAmazonOrderProductVersion object to this object
     * through the ChildAmazonOrderProductVersion foreign key attribute.
     *
     * @param    ChildAmazonOrderProductVersion $l ChildAmazonOrderProductVersion
     * @return   \AmazonIntegration\Model\AmazonOrderProduct The current object (for fluent API support)
     */
    public function addAmazonOrderProductVersion(ChildAmazonOrderProductVersion $l)
    {
        if ($this->collAmazonOrderProductVersions === null) {
            $this->initAmazonOrderProductVersions();
            $this->collAmazonOrderProductVersionsPartial = true;
        }

        if (!in_array($l, $this->collAmazonOrderProductVersions->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddAmazonOrderProductVersion($l);
        }

        return $this;
    }

    /**
     * @param AmazonOrderProductVersion $amazonOrderProductVersion The amazonOrderProductVersion object to add.
     */
    protected function doAddAmazonOrderProductVersion($amazonOrderProductVersion)
    {
        $this->collAmazonOrderProductVersions[]= $amazonOrderProductVersion;
        $amazonOrderProductVersion->setAmazonOrderProduct($this);
    }

    /**
     * @param  AmazonOrderProductVersion $amazonOrderProductVersion The amazonOrderProductVersion object to remove.
     * @return ChildAmazonOrderProduct The current object (for fluent API support)
     */
    public function removeAmazonOrderProductVersion($amazonOrderProductVersion)
    {
        if ($this->getAmazonOrderProductVersions()->contains($amazonOrderProductVersion)) {
            $this->collAmazonOrderProductVersions->remove($this->collAmazonOrderProductVersions->search($amazonOrderProductVersion));
            if (null === $this->amazonOrderProductVersionsScheduledForDeletion) {
                $this->amazonOrderProductVersionsScheduledForDeletion = clone $this->collAmazonOrderProductVersions;
                $this->amazonOrderProductVersionsScheduledForDeletion->clear();
            }
            $this->amazonOrderProductVersionsScheduledForDeletion[]= clone $amazonOrderProductVersion;
            $amazonOrderProductVersion->setAmazonOrderProduct(null);
        }

        return $this;
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->order_item_id = null;
        $this->amazon_order_id = null;
        $this->asin = null;
        $this->seller_sku = null;
        $this->title = null;
        $this->quantity_ordered = null;
        $this->quantity_shipped = null;
        $this->points_granted_number = null;
        $this->points_granted_currency_code = null;
        $this->points_granted_amount = null;
        $this->item_price_currency_code = null;
        $this->item_price_amount = null;
        $this->shipping_price_currency_code = null;
        $this->shipping_price_amount = null;
        $this->gift_wrap_price_currency_code = null;
        $this->gift_wrap_price_amount = null;
        $this->item_tax_currency_code = null;
        $this->item_tax_amount = null;
        $this->shipping_tax_currency_code = null;
        $this->shipping_tax_amount = null;
        $this->gift_wrap_tax_currency_code = null;
        $this->gift_wrap_tax_amount = null;
        $this->shipping_discount_currency_code = null;
        $this->shipping_discount_amount = null;
        $this->promotion_discount_currency_code = null;
        $this->promotion_discount_amount = null;
        $this->promotion_id = null;
        $this->cod_fee_currency_code = null;
        $this->cod_fee_amount = null;
        $this->cod_fee_discount_currency_code = null;
        $this->cod_fee_discount_amount = null;
        $this->gift_message_text = null;
        $this->gift_wrap_level = null;
        $this->invoice_requirement = null;
        $this->buyer_selected_invoice_category = null;
        $this->invoice_title = null;
        $this->invoice_information = null;
        $this->condition_note = null;
        $this->condition_id = null;
        $this->condition_subtype_id = null;
        $this->schedule_delivery_start_date = null;
        $this->schedule_delivery_end_date = null;
        $this->price_designation = null;
        $this->buyer_customized_url = null;
        $this->order_product_id = null;
        $this->created_at = null;
        $this->updated_at = null;
        $this->version = null;
        $this->version_created_at = null;
        $this->version_created_by = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->applyDefaultValues();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references to other model objects or collections of model objects.
     *
     * This method is a user-space workaround for PHP's inability to garbage collect
     * objects with circular references (even in PHP 5.3). This is currently necessary
     * when using Propel in certain daemon or large-volume/high-memory operations.
     *
     * @param      boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep) {
            if ($this->collAmazonOrderProductVersions) {
                foreach ($this->collAmazonOrderProductVersions as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collAmazonOrderProductVersions = null;
        $this->aOrderProduct = null;
        $this->aAmazonOrders = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(AmazonOrderProductTableMap::DEFAULT_STRING_FORMAT);
    }

    // timestampable behavior
    
    /**
     * Mark the current object so that the update date doesn't get updated during next save
     *
     * @return     ChildAmazonOrderProduct The current object (for fluent API support)
     */
    public function keepUpdateDateUnchanged()
    {
        $this->modifiedColumns[AmazonOrderProductTableMap::UPDATED_AT] = true;
    
        return $this;
    }

    // versionable behavior
    
    /**
     * Enforce a new Version of this object upon next save.
     *
     * @return \AmazonIntegration\Model\AmazonOrderProduct
     */
    public function enforceVersioning()
    {
        $this->enforceVersion = true;
    
        return $this;
    }
            
    /**
     * Checks whether the current state must be recorded as a version
     *
     * @return  boolean
     */
    public function isVersioningNecessary($con = null)
    {
        if ($this->alreadyInSave) {
            return false;
        }
    
        if ($this->enforceVersion) {
            return true;
        }
    
        if (ChildAmazonOrderProductQuery::isVersioningEnabled() && ($this->isNew() || $this->isModified()) || $this->isDeleted()) {
            return true;
        }
        if (null !== ($object = $this->getAmazonOrders($con)) && $object->isVersioningNecessary($con)) {
            return true;
        }
    
    
        return false;
    }
    
    /**
     * Creates a version of the current object and saves it.
     *
     * @param   ConnectionInterface $con the connection to use
     *
     * @return  ChildAmazonOrderProductVersion A version object
     */
    public function addVersion($con = null)
    {
        $this->enforceVersion = false;
    
        $version = new ChildAmazonOrderProductVersion();
        $version->setOrderItemId($this->getOrderItemId());
        $version->setAmazonOrderId($this->getAmazonOrderId());
        $version->setAsin($this->getAsin());
        $version->setSellerSku($this->getSellerSku());
        $version->setTitle($this->getTitle());
        $version->setQuantityOrdered($this->getQuantityOrdered());
        $version->setQuantityShipped($this->getQuantityShipped());
        $version->setPointsGrantedNumber($this->getPointsGrantedNumber());
        $version->setPointsGrantedCurrencyCode($this->getPointsGrantedCurrencyCode());
        $version->setPointsGrantedAmount($this->getPointsGrantedAmount());
        $version->setItemPriceCurrencyCode($this->getItemPriceCurrencyCode());
        $version->setItemPriceAmount($this->getItemPriceAmount());
        $version->setShippingPriceCurrencyCode($this->getShippingPriceCurrencyCode());
        $version->setShippingPriceAmount($this->getShippingPriceAmount());
        $version->setGiftWrapPriceCurrencyCode($this->getGiftWrapPriceCurrencyCode());
        $version->setGiftWrapPriceAmount($this->getGiftWrapPriceAmount());
        $version->setItemTaxCurrencyCode($this->getItemTaxCurrencyCode());
        $version->setItemTaxAmount($this->getItemTaxAmount());
        $version->setShippingTaxCurrencyCode($this->getShippingTaxCurrencyCode());
        $version->setShippingTaxAmount($this->getShippingTaxAmount());
        $version->setGiftWrapTaxCurrencyCode($this->getGiftWrapTaxCurrencyCode());
        $version->setGiftWrapTaxAmount($this->getGiftWrapTaxAmount());
        $version->setShippingDiscountCurrencyCode($this->getShippingDiscountCurrencyCode());
        $version->setShippingDiscountAmount($this->getShippingDiscountAmount());
        $version->setPromotionDiscountCurrencyCode($this->getPromotionDiscountCurrencyCode());
        $version->setPromotionDiscountAmount($this->getPromotionDiscountAmount());
        $version->setPromotionId($this->getPromotionId());
        $version->setCodFeeCurrencyCode($this->getCodFeeCurrencyCode());
        $version->setCodFeeAmount($this->getCodFeeAmount());
        $version->setCodFeeDiscountCurrencyCode($this->getCodFeeDiscountCurrencyCode());
        $version->setCodFeeDiscountAmount($this->getCodFeeDiscountAmount());
        $version->setGiftMessageText($this->getGiftMessageText());
        $version->setGiftWrapLevel($this->getGiftWrapLevel());
        $version->setInvoiceRequirement($this->getInvoiceRequirement());
        $version->setBuyerSelectedInvoiceCategory($this->getBuyerSelectedInvoiceCategory());
        $version->setInvoiceTitle($this->getInvoiceTitle());
        $version->setInvoiceInformation($this->getInvoiceInformation());
        $version->setConditionNote($this->getConditionNote());
        $version->setConditionId($this->getConditionId());
        $version->setConditionSubtypeId($this->getConditionSubtypeId());
        $version->setScheduledDeliveryStartDate($this->getScheduledDeliveryStartDate());
        $version->setScheduledDeliveryEndDate($this->getScheduledDeliveryEndDate());
        $version->setPriceDesignation($this->getPriceDesignation());
        $version->setBuyerCustomizedURL($this->getBuyerCustomizedURL());
        $version->setOrderProductId($this->getOrderProductId());
        $version->setCreatedAt($this->getCreatedAt());
        $version->setUpdatedAt($this->getUpdatedAt());
        $version->setVersion($this->getVersion());
        $version->setVersionCreatedAt($this->getVersionCreatedAt());
        $version->setVersionCreatedBy($this->getVersionCreatedBy());
        $version->setAmazonOrderProduct($this);
        if (($related = $this->getAmazonOrders($con)) && $related->getVersion()) {
            $version->setAmazonOrderIdVersion($related->getVersion());
        }
        $version->save($con);
    
        return $version;
    }
    
    /**
     * Sets the properties of the current object to the value they had at a specific version
     *
     * @param   integer $versionNumber The version number to read
     * @param   ConnectionInterface $con The connection to use
     *
     * @return  ChildAmazonOrderProduct The current object (for fluent API support)
     */
    public function toVersion($versionNumber, $con = null)
    {
        $version = $this->getOneVersion($versionNumber, $con);
        if (!$version) {
            throw new PropelException(sprintf('No ChildAmazonOrderProduct object found with version %d', $version));
        }
        $this->populateFromVersion($version, $con);
    
        return $this;
    }
    
    /**
     * Sets the properties of the current object to the value they had at a specific version
     *
     * @param ChildAmazonOrderProductVersion $version The version object to use
     * @param ConnectionInterface   $con the connection to use
     * @param array                 $loadedObjects objects that been loaded in a chain of populateFromVersion calls on referrer or fk objects.
     *
     * @return ChildAmazonOrderProduct The current object (for fluent API support)
     */
    public function populateFromVersion($version, $con = null, &$loadedObjects = array())
    {
        $loadedObjects['ChildAmazonOrderProduct'][$version->getOrderItemId()][$version->getVersion()] = $this;
        $this->setOrderItemId($version->getOrderItemId());
        $this->setAmazonOrderId($version->getAmazonOrderId());
        $this->setAsin($version->getAsin());
        $this->setSellerSku($version->getSellerSku());
        $this->setTitle($version->getTitle());
        $this->setQuantityOrdered($version->getQuantityOrdered());
        $this->setQuantityShipped($version->getQuantityShipped());
        $this->setPointsGrantedNumber($version->getPointsGrantedNumber());
        $this->setPointsGrantedCurrencyCode($version->getPointsGrantedCurrencyCode());
        $this->setPointsGrantedAmount($version->getPointsGrantedAmount());
        $this->setItemPriceCurrencyCode($version->getItemPriceCurrencyCode());
        $this->setItemPriceAmount($version->getItemPriceAmount());
        $this->setShippingPriceCurrencyCode($version->getShippingPriceCurrencyCode());
        $this->setShippingPriceAmount($version->getShippingPriceAmount());
        $this->setGiftWrapPriceCurrencyCode($version->getGiftWrapPriceCurrencyCode());
        $this->setGiftWrapPriceAmount($version->getGiftWrapPriceAmount());
        $this->setItemTaxCurrencyCode($version->getItemTaxCurrencyCode());
        $this->setItemTaxAmount($version->getItemTaxAmount());
        $this->setShippingTaxCurrencyCode($version->getShippingTaxCurrencyCode());
        $this->setShippingTaxAmount($version->getShippingTaxAmount());
        $this->setGiftWrapTaxCurrencyCode($version->getGiftWrapTaxCurrencyCode());
        $this->setGiftWrapTaxAmount($version->getGiftWrapTaxAmount());
        $this->setShippingDiscountCurrencyCode($version->getShippingDiscountCurrencyCode());
        $this->setShippingDiscountAmount($version->getShippingDiscountAmount());
        $this->setPromotionDiscountCurrencyCode($version->getPromotionDiscountCurrencyCode());
        $this->setPromotionDiscountAmount($version->getPromotionDiscountAmount());
        $this->setPromotionId($version->getPromotionId());
        $this->setCodFeeCurrencyCode($version->getCodFeeCurrencyCode());
        $this->setCodFeeAmount($version->getCodFeeAmount());
        $this->setCodFeeDiscountCurrencyCode($version->getCodFeeDiscountCurrencyCode());
        $this->setCodFeeDiscountAmount($version->getCodFeeDiscountAmount());
        $this->setGiftMessageText($version->getGiftMessageText());
        $this->setGiftWrapLevel($version->getGiftWrapLevel());
        $this->setInvoiceRequirement($version->getInvoiceRequirement());
        $this->setBuyerSelectedInvoiceCategory($version->getBuyerSelectedInvoiceCategory());
        $this->setInvoiceTitle($version->getInvoiceTitle());
        $this->setInvoiceInformation($version->getInvoiceInformation());
        $this->setConditionNote($version->getConditionNote());
        $this->setConditionId($version->getConditionId());
        $this->setConditionSubtypeId($version->getConditionSubtypeId());
        $this->setScheduledDeliveryStartDate($version->getScheduledDeliveryStartDate());
        $this->setScheduledDeliveryEndDate($version->getScheduledDeliveryEndDate());
        $this->setPriceDesignation($version->getPriceDesignation());
        $this->setBuyerCustomizedURL($version->getBuyerCustomizedURL());
        $this->setOrderProductId($version->getOrderProductId());
        $this->setCreatedAt($version->getCreatedAt());
        $this->setUpdatedAt($version->getUpdatedAt());
        $this->setVersion($version->getVersion());
        $this->setVersionCreatedAt($version->getVersionCreatedAt());
        $this->setVersionCreatedBy($version->getVersionCreatedBy());
        if ($fkValue = $version->getAmazonOrderId()) {
            if (isset($loadedObjects['ChildAmazonOrders']) && isset($loadedObjects['ChildAmazonOrders'][$fkValue]) && isset($loadedObjects['ChildAmazonOrders'][$fkValue][$version->getAmazonOrderIdVersion()])) {
                $related = $loadedObjects['ChildAmazonOrders'][$fkValue][$version->getAmazonOrderIdVersion()];
            } else {
                $related = new ChildAmazonOrders();
                $relatedVersion = ChildAmazonOrdersVersionQuery::create()
                    ->filterById($fkValue)
                    ->filterByVersion($version->getAmazonOrderIdVersion())
                    ->findOne($con);
                $related->populateFromVersion($relatedVersion, $con, $loadedObjects);
                $related->setNew(false);
            }
            $this->setAmazonOrders($related);
        }
    
        return $this;
    }
    
    /**
     * Gets the latest persisted version number for the current object
     *
     * @param   ConnectionInterface $con the connection to use
     *
     * @return  integer
     */
    public function getLastVersionNumber($con = null)
    {
        $v = ChildAmazonOrderProductVersionQuery::create()
            ->filterByAmazonOrderProduct($this)
            ->orderByVersion('desc')
            ->findOne($con);
        if (!$v) {
            return 0;
        }
    
        return $v->getVersion();
    }
    
    /**
     * Checks whether the current object is the latest one
     *
     * @param   ConnectionInterface $con the connection to use
     *
     * @return  Boolean
     */
    public function isLastVersion($con = null)
    {
        return $this->getLastVersionNumber($con) == $this->getVersion();
    }
    
    /**
     * Retrieves a version object for this entity and a version number
     *
     * @param   integer $versionNumber The version number to read
     * @param   ConnectionInterface $con the connection to use
     *
     * @return  ChildAmazonOrderProductVersion A version object
     */
    public function getOneVersion($versionNumber, $con = null)
    {
        return ChildAmazonOrderProductVersionQuery::create()
            ->filterByAmazonOrderProduct($this)
            ->filterByVersion($versionNumber)
            ->findOne($con);
    }
    
    /**
     * Gets all the versions of this object, in incremental order
     *
     * @param   ConnectionInterface $con the connection to use
     *
     * @return  ObjectCollection A list of ChildAmazonOrderProductVersion objects
     */
    public function getAllVersions($con = null)
    {
        $criteria = new Criteria();
        $criteria->addAscendingOrderByColumn(AmazonOrderProductVersionTableMap::VERSION);
    
        return $this->getAmazonOrderProductVersions($criteria, $con);
    }
    
    /**
     * Compares the current object with another of its version.
     * <code>
     * print_r($book->compareVersion(1));
     * => array(
     *   '1' => array('Title' => 'Book title at version 1'),
     *   '2' => array('Title' => 'Book title at version 2')
     * );
     * </code>
     *
     * @param   integer             $versionNumber
     * @param   string              $keys Main key used for the result diff (versions|columns)
     * @param   ConnectionInterface $con the connection to use
     * @param   array               $ignoredColumns  The columns to exclude from the diff.
     *
     * @return  array A list of differences
     */
    public function compareVersion($versionNumber, $keys = 'columns', $con = null, $ignoredColumns = array())
    {
        $fromVersion = $this->toArray();
        $toVersion = $this->getOneVersion($versionNumber, $con)->toArray();
    
        return $this->computeDiff($fromVersion, $toVersion, $keys, $ignoredColumns);
    }
    
    /**
     * Compares two versions of the current object.
     * <code>
     * print_r($book->compareVersions(1, 2));
     * => array(
     *   '1' => array('Title' => 'Book title at version 1'),
     *   '2' => array('Title' => 'Book title at version 2')
     * );
     * </code>
     *
     * @param   integer             $fromVersionNumber
     * @param   integer             $toVersionNumber
     * @param   string              $keys Main key used for the result diff (versions|columns)
     * @param   ConnectionInterface $con the connection to use
     * @param   array               $ignoredColumns  The columns to exclude from the diff.
     *
     * @return  array A list of differences
     */
    public function compareVersions($fromVersionNumber, $toVersionNumber, $keys = 'columns', $con = null, $ignoredColumns = array())
    {
        $fromVersion = $this->getOneVersion($fromVersionNumber, $con)->toArray();
        $toVersion = $this->getOneVersion($toVersionNumber, $con)->toArray();
    
        return $this->computeDiff($fromVersion, $toVersion, $keys, $ignoredColumns);
    }
    
    /**
     * Computes the diff between two versions.
     * <code>
     * print_r($book->computeDiff(1, 2));
     * => array(
     *   '1' => array('Title' => 'Book title at version 1'),
     *   '2' => array('Title' => 'Book title at version 2')
     * );
     * </code>
     *
     * @param   array     $fromVersion     An array representing the original version.
     * @param   array     $toVersion       An array representing the destination version.
     * @param   string    $keys            Main key used for the result diff (versions|columns).
     * @param   array     $ignoredColumns  The columns to exclude from the diff.
     *
     * @return  array A list of differences
     */
    protected function computeDiff($fromVersion, $toVersion, $keys = 'columns', $ignoredColumns = array())
    {
        $fromVersionNumber = $fromVersion['Version'];
        $toVersionNumber = $toVersion['Version'];
        $ignoredColumns = array_merge(array(
            'Version',
            'VersionCreatedAt',
            'VersionCreatedBy',
        ), $ignoredColumns);
        $diff = array();
        foreach ($fromVersion as $key => $value) {
            if (in_array($key, $ignoredColumns)) {
                continue;
            }
            if ($toVersion[$key] != $value) {
                switch ($keys) {
                    case 'versions':
                        $diff[$fromVersionNumber][$key] = $value;
                        $diff[$toVersionNumber][$key] = $toVersion[$key];
                        break;
                    default:
                        $diff[$key] = array(
                            $fromVersionNumber => $value,
                            $toVersionNumber => $toVersion[$key],
                        );
                        break;
                }
            }
        }
    
        return $diff;
    }
    /**
     * retrieve the last $number versions.
     *
     * @param Integer $number the number of record to return.
     * @return PropelCollection|array \AmazonIntegration\Model\AmazonOrderProductVersion[] List of \AmazonIntegration\Model\AmazonOrderProductVersion objects
     */
    public function getLastVersions($number = 10, $criteria = null, $con = null)
    {
        $criteria = ChildAmazonOrderProductVersionQuery::create(null, $criteria);
        $criteria->addDescendingOrderByColumn(AmazonOrderProductVersionTableMap::VERSION);
        $criteria->limit($number);
    
        return $this->getAmazonOrderProductVersions($criteria, $con);
    }
    /**
     * Code to be run before persisting the object
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preSave(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after persisting the object
     * @param ConnectionInterface $con
     */
    public function postSave(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before inserting to database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preInsert(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after inserting to database
     * @param ConnectionInterface $con
     */
    public function postInsert(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before updating the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preUpdate(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after updating the object in database
     * @param ConnectionInterface $con
     */
    public function postUpdate(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before deleting the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preDelete(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after deleting the object in database
     * @param ConnectionInterface $con
     */
    public function postDelete(ConnectionInterface $con = null)
    {

    }


    /**
     * Derived method to catches calls to undefined methods.
     *
     * Provides magic import/export method support (fromXML()/toXML(), fromYAML()/toYAML(), etc.).
     * Allows to define default __call() behavior if you overwrite __call()
     *
     * @param string $name
     * @param mixed  $params
     *
     * @return array|string
     */
    public function __call($name, $params)
    {
        if (0 === strpos($name, 'get')) {
            $virtualColumn = substr($name, 3);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }

            $virtualColumn = lcfirst($virtualColumn);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }
        }

        if (0 === strpos($name, 'from')) {
            $format = substr($name, 4);

            return $this->importFrom($format, reset($params));
        }

        if (0 === strpos($name, 'to')) {
            $format = substr($name, 2);
            $includeLazyLoadColumns = isset($params[0]) ? $params[0] : true;

            return $this->exportTo($format, $includeLazyLoadColumns);
        }

        throw new BadMethodCallException(sprintf('Call to undefined method: %s.', $name));
    }

}
