<?php

namespace AmazonIntegration\Model\Base;

use \DateTime;
use \Exception;
use \PDO;
use AmazonIntegration\Model\AmazonOrderProduct as ChildAmazonOrderProduct;
use AmazonIntegration\Model\AmazonOrderProductQuery as ChildAmazonOrderProductQuery;
use AmazonIntegration\Model\AmazonOrderProductVersionQuery as ChildAmazonOrderProductVersionQuery;
use AmazonIntegration\Model\Map\AmazonOrderProductVersionTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;
use Propel\Runtime\Util\PropelDateTime;

abstract class AmazonOrderProductVersion implements ActiveRecordInterface 
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\AmazonIntegration\\Model\\Map\\AmazonOrderProductVersionTableMap';


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
     * The value for the amazon_order_id_version field.
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $amazon_order_id_version;

    /**
     * @var        AmazonOrderProduct
     */
    protected $aAmazonOrderProduct;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see __construct()
     */
    public function applyDefaultValues()
    {
        $this->version = 0;
        $this->amazon_order_id_version = 0;
    }

    /**
     * Initializes internal state of AmazonIntegration\Model\Base\AmazonOrderProductVersion object.
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
     * Compares this with another <code>AmazonOrderProductVersion</code> instance.  If
     * <code>obj</code> is an instance of <code>AmazonOrderProductVersion</code>, delegates to
     * <code>equals(AmazonOrderProductVersion)</code>.  Otherwise, returns <code>false</code>.
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
     * @return AmazonOrderProductVersion The current object, for fluid interface
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
     * @return AmazonOrderProductVersion The current object, for fluid interface
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
     * Get the [amazon_order_id_version] column value.
     * 
     * @return   int
     */
    public function getAmazonOrderIdVersion()
    {

        return $this->amazon_order_id_version;
    }

    /**
     * Set the value of [order_item_id] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonOrderProductVersion The current object (for fluent API support)
     */
    public function setOrderItemId($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->order_item_id !== $v) {
            $this->order_item_id = $v;
            $this->modifiedColumns[AmazonOrderProductVersionTableMap::ORDER_ITEM_ID] = true;
        }

        if ($this->aAmazonOrderProduct !== null && $this->aAmazonOrderProduct->getOrderItemId() !== $v) {
            $this->aAmazonOrderProduct = null;
        }


        return $this;
    } // setOrderItemId()

    /**
     * Set the value of [amazon_order_id] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonOrderProductVersion The current object (for fluent API support)
     */
    public function setAmazonOrderId($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->amazon_order_id !== $v) {
            $this->amazon_order_id = $v;
            $this->modifiedColumns[AmazonOrderProductVersionTableMap::AMAZON_ORDER_ID] = true;
        }


        return $this;
    } // setAmazonOrderId()

    /**
     * Set the value of [asin] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonOrderProductVersion The current object (for fluent API support)
     */
    public function setAsin($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->asin !== $v) {
            $this->asin = $v;
            $this->modifiedColumns[AmazonOrderProductVersionTableMap::ASIN] = true;
        }


        return $this;
    } // setAsin()

    /**
     * Set the value of [seller_sku] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonOrderProductVersion The current object (for fluent API support)
     */
    public function setSellerSku($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->seller_sku !== $v) {
            $this->seller_sku = $v;
            $this->modifiedColumns[AmazonOrderProductVersionTableMap::SELLER_SKU] = true;
        }


        return $this;
    } // setSellerSku()

    /**
     * Set the value of [title] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonOrderProductVersion The current object (for fluent API support)
     */
    public function setTitle($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->title !== $v) {
            $this->title = $v;
            $this->modifiedColumns[AmazonOrderProductVersionTableMap::TITLE] = true;
        }


        return $this;
    } // setTitle()

    /**
     * Set the value of [quantity_ordered] column.
     * 
     * @param      double $v new value
     * @return   \AmazonIntegration\Model\AmazonOrderProductVersion The current object (for fluent API support)
     */
    public function setQuantityOrdered($v)
    {
        if ($v !== null) {
            $v = (double) $v;
        }

        if ($this->quantity_ordered !== $v) {
            $this->quantity_ordered = $v;
            $this->modifiedColumns[AmazonOrderProductVersionTableMap::QUANTITY_ORDERED] = true;
        }


        return $this;
    } // setQuantityOrdered()

    /**
     * Set the value of [quantity_shipped] column.
     * 
     * @param      double $v new value
     * @return   \AmazonIntegration\Model\AmazonOrderProductVersion The current object (for fluent API support)
     */
    public function setQuantityShipped($v)
    {
        if ($v !== null) {
            $v = (double) $v;
        }

        if ($this->quantity_shipped !== $v) {
            $this->quantity_shipped = $v;
            $this->modifiedColumns[AmazonOrderProductVersionTableMap::QUANTITY_SHIPPED] = true;
        }


        return $this;
    } // setQuantityShipped()

    /**
     * Set the value of [points_granted_number] column.
     * 
     * @param      double $v new value
     * @return   \AmazonIntegration\Model\AmazonOrderProductVersion The current object (for fluent API support)
     */
    public function setPointsGrantedNumber($v)
    {
        if ($v !== null) {
            $v = (double) $v;
        }

        if ($this->points_granted_number !== $v) {
            $this->points_granted_number = $v;
            $this->modifiedColumns[AmazonOrderProductVersionTableMap::POINTS_GRANTED_NUMBER] = true;
        }


        return $this;
    } // setPointsGrantedNumber()

    /**
     * Set the value of [points_granted_currency_code] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonOrderProductVersion The current object (for fluent API support)
     */
    public function setPointsGrantedCurrencyCode($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->points_granted_currency_code !== $v) {
            $this->points_granted_currency_code = $v;
            $this->modifiedColumns[AmazonOrderProductVersionTableMap::POINTS_GRANTED_CURRENCY_CODE] = true;
        }


        return $this;
    } // setPointsGrantedCurrencyCode()

    /**
     * Set the value of [points_granted_amount] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonOrderProductVersion The current object (for fluent API support)
     */
    public function setPointsGrantedAmount($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->points_granted_amount !== $v) {
            $this->points_granted_amount = $v;
            $this->modifiedColumns[AmazonOrderProductVersionTableMap::POINTS_GRANTED_AMOUNT] = true;
        }


        return $this;
    } // setPointsGrantedAmount()

    /**
     * Set the value of [item_price_currency_code] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonOrderProductVersion The current object (for fluent API support)
     */
    public function setItemPriceCurrencyCode($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->item_price_currency_code !== $v) {
            $this->item_price_currency_code = $v;
            $this->modifiedColumns[AmazonOrderProductVersionTableMap::ITEM_PRICE_CURRENCY_CODE] = true;
        }


        return $this;
    } // setItemPriceCurrencyCode()

    /**
     * Set the value of [item_price_amount] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonOrderProductVersion The current object (for fluent API support)
     */
    public function setItemPriceAmount($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->item_price_amount !== $v) {
            $this->item_price_amount = $v;
            $this->modifiedColumns[AmazonOrderProductVersionTableMap::ITEM_PRICE_AMOUNT] = true;
        }


        return $this;
    } // setItemPriceAmount()

    /**
     * Set the value of [shipping_price_currency_code] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonOrderProductVersion The current object (for fluent API support)
     */
    public function setShippingPriceCurrencyCode($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->shipping_price_currency_code !== $v) {
            $this->shipping_price_currency_code = $v;
            $this->modifiedColumns[AmazonOrderProductVersionTableMap::SHIPPING_PRICE_CURRENCY_CODE] = true;
        }


        return $this;
    } // setShippingPriceCurrencyCode()

    /**
     * Set the value of [shipping_price_amount] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonOrderProductVersion The current object (for fluent API support)
     */
    public function setShippingPriceAmount($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->shipping_price_amount !== $v) {
            $this->shipping_price_amount = $v;
            $this->modifiedColumns[AmazonOrderProductVersionTableMap::SHIPPING_PRICE_AMOUNT] = true;
        }


        return $this;
    } // setShippingPriceAmount()

    /**
     * Set the value of [gift_wrap_price_currency_code] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonOrderProductVersion The current object (for fluent API support)
     */
    public function setGiftWrapPriceCurrencyCode($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->gift_wrap_price_currency_code !== $v) {
            $this->gift_wrap_price_currency_code = $v;
            $this->modifiedColumns[AmazonOrderProductVersionTableMap::GIFT_WRAP_PRICE_CURRENCY_CODE] = true;
        }


        return $this;
    } // setGiftWrapPriceCurrencyCode()

    /**
     * Set the value of [gift_wrap_price_amount] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonOrderProductVersion The current object (for fluent API support)
     */
    public function setGiftWrapPriceAmount($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->gift_wrap_price_amount !== $v) {
            $this->gift_wrap_price_amount = $v;
            $this->modifiedColumns[AmazonOrderProductVersionTableMap::GIFT_WRAP_PRICE_AMOUNT] = true;
        }


        return $this;
    } // setGiftWrapPriceAmount()

    /**
     * Set the value of [item_tax_currency_code] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonOrderProductVersion The current object (for fluent API support)
     */
    public function setItemTaxCurrencyCode($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->item_tax_currency_code !== $v) {
            $this->item_tax_currency_code = $v;
            $this->modifiedColumns[AmazonOrderProductVersionTableMap::ITEM_TAX_CURRENCY_CODE] = true;
        }


        return $this;
    } // setItemTaxCurrencyCode()

    /**
     * Set the value of [item_tax_amount] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonOrderProductVersion The current object (for fluent API support)
     */
    public function setItemTaxAmount($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->item_tax_amount !== $v) {
            $this->item_tax_amount = $v;
            $this->modifiedColumns[AmazonOrderProductVersionTableMap::ITEM_TAX_AMOUNT] = true;
        }


        return $this;
    } // setItemTaxAmount()

    /**
     * Set the value of [shipping_tax_currency_code] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonOrderProductVersion The current object (for fluent API support)
     */
    public function setShippingTaxCurrencyCode($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->shipping_tax_currency_code !== $v) {
            $this->shipping_tax_currency_code = $v;
            $this->modifiedColumns[AmazonOrderProductVersionTableMap::SHIPPING_TAX_CURRENCY_CODE] = true;
        }


        return $this;
    } // setShippingTaxCurrencyCode()

    /**
     * Set the value of [shipping_tax_amount] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonOrderProductVersion The current object (for fluent API support)
     */
    public function setShippingTaxAmount($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->shipping_tax_amount !== $v) {
            $this->shipping_tax_amount = $v;
            $this->modifiedColumns[AmazonOrderProductVersionTableMap::SHIPPING_TAX_AMOUNT] = true;
        }


        return $this;
    } // setShippingTaxAmount()

    /**
     * Set the value of [gift_wrap_tax_currency_code] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonOrderProductVersion The current object (for fluent API support)
     */
    public function setGiftWrapTaxCurrencyCode($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->gift_wrap_tax_currency_code !== $v) {
            $this->gift_wrap_tax_currency_code = $v;
            $this->modifiedColumns[AmazonOrderProductVersionTableMap::GIFT_WRAP_TAX_CURRENCY_CODE] = true;
        }


        return $this;
    } // setGiftWrapTaxCurrencyCode()

    /**
     * Set the value of [gift_wrap_tax_amount] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonOrderProductVersion The current object (for fluent API support)
     */
    public function setGiftWrapTaxAmount($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->gift_wrap_tax_amount !== $v) {
            $this->gift_wrap_tax_amount = $v;
            $this->modifiedColumns[AmazonOrderProductVersionTableMap::GIFT_WRAP_TAX_AMOUNT] = true;
        }


        return $this;
    } // setGiftWrapTaxAmount()

    /**
     * Set the value of [shipping_discount_currency_code] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonOrderProductVersion The current object (for fluent API support)
     */
    public function setShippingDiscountCurrencyCode($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->shipping_discount_currency_code !== $v) {
            $this->shipping_discount_currency_code = $v;
            $this->modifiedColumns[AmazonOrderProductVersionTableMap::SHIPPING_DISCOUNT_CURRENCY_CODE] = true;
        }


        return $this;
    } // setShippingDiscountCurrencyCode()

    /**
     * Set the value of [shipping_discount_amount] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonOrderProductVersion The current object (for fluent API support)
     */
    public function setShippingDiscountAmount($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->shipping_discount_amount !== $v) {
            $this->shipping_discount_amount = $v;
            $this->modifiedColumns[AmazonOrderProductVersionTableMap::SHIPPING_DISCOUNT_AMOUNT] = true;
        }


        return $this;
    } // setShippingDiscountAmount()

    /**
     * Set the value of [promotion_discount_currency_code] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonOrderProductVersion The current object (for fluent API support)
     */
    public function setPromotionDiscountCurrencyCode($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->promotion_discount_currency_code !== $v) {
            $this->promotion_discount_currency_code = $v;
            $this->modifiedColumns[AmazonOrderProductVersionTableMap::PROMOTION_DISCOUNT_CURRENCY_CODE] = true;
        }


        return $this;
    } // setPromotionDiscountCurrencyCode()

    /**
     * Set the value of [promotion_discount_amount] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonOrderProductVersion The current object (for fluent API support)
     */
    public function setPromotionDiscountAmount($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->promotion_discount_amount !== $v) {
            $this->promotion_discount_amount = $v;
            $this->modifiedColumns[AmazonOrderProductVersionTableMap::PROMOTION_DISCOUNT_AMOUNT] = true;
        }


        return $this;
    } // setPromotionDiscountAmount()

    /**
     * Set the value of [promotion_id] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonOrderProductVersion The current object (for fluent API support)
     */
    public function setPromotionId($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->promotion_id !== $v) {
            $this->promotion_id = $v;
            $this->modifiedColumns[AmazonOrderProductVersionTableMap::PROMOTION_ID] = true;
        }


        return $this;
    } // setPromotionId()

    /**
     * Set the value of [cod_fee_currency_code] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonOrderProductVersion The current object (for fluent API support)
     */
    public function setCodFeeCurrencyCode($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->cod_fee_currency_code !== $v) {
            $this->cod_fee_currency_code = $v;
            $this->modifiedColumns[AmazonOrderProductVersionTableMap::COD_FEE_CURRENCY_CODE] = true;
        }


        return $this;
    } // setCodFeeCurrencyCode()

    /**
     * Set the value of [cod_fee_amount] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonOrderProductVersion The current object (for fluent API support)
     */
    public function setCodFeeAmount($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->cod_fee_amount !== $v) {
            $this->cod_fee_amount = $v;
            $this->modifiedColumns[AmazonOrderProductVersionTableMap::COD_FEE_AMOUNT] = true;
        }


        return $this;
    } // setCodFeeAmount()

    /**
     * Set the value of [cod_fee_discount_currency_code] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonOrderProductVersion The current object (for fluent API support)
     */
    public function setCodFeeDiscountCurrencyCode($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->cod_fee_discount_currency_code !== $v) {
            $this->cod_fee_discount_currency_code = $v;
            $this->modifiedColumns[AmazonOrderProductVersionTableMap::COD_FEE_DISCOUNT_CURRENCY_CODE] = true;
        }


        return $this;
    } // setCodFeeDiscountCurrencyCode()

    /**
     * Set the value of [cod_fee_discount_amount] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonOrderProductVersion The current object (for fluent API support)
     */
    public function setCodFeeDiscountAmount($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->cod_fee_discount_amount !== $v) {
            $this->cod_fee_discount_amount = $v;
            $this->modifiedColumns[AmazonOrderProductVersionTableMap::COD_FEE_DISCOUNT_AMOUNT] = true;
        }


        return $this;
    } // setCodFeeDiscountAmount()

    /**
     * Set the value of [gift_message_text] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonOrderProductVersion The current object (for fluent API support)
     */
    public function setGiftMessageText($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->gift_message_text !== $v) {
            $this->gift_message_text = $v;
            $this->modifiedColumns[AmazonOrderProductVersionTableMap::GIFT_MESSAGE_TEXT] = true;
        }


        return $this;
    } // setGiftMessageText()

    /**
     * Set the value of [gift_wrap_level] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonOrderProductVersion The current object (for fluent API support)
     */
    public function setGiftWrapLevel($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->gift_wrap_level !== $v) {
            $this->gift_wrap_level = $v;
            $this->modifiedColumns[AmazonOrderProductVersionTableMap::GIFT_WRAP_LEVEL] = true;
        }


        return $this;
    } // setGiftWrapLevel()

    /**
     * Set the value of [invoice_requirement] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonOrderProductVersion The current object (for fluent API support)
     */
    public function setInvoiceRequirement($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->invoice_requirement !== $v) {
            $this->invoice_requirement = $v;
            $this->modifiedColumns[AmazonOrderProductVersionTableMap::INVOICE_REQUIREMENT] = true;
        }


        return $this;
    } // setInvoiceRequirement()

    /**
     * Set the value of [buyer_selected_invoice_category] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonOrderProductVersion The current object (for fluent API support)
     */
    public function setBuyerSelectedInvoiceCategory($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->buyer_selected_invoice_category !== $v) {
            $this->buyer_selected_invoice_category = $v;
            $this->modifiedColumns[AmazonOrderProductVersionTableMap::BUYER_SELECTED_INVOICE_CATEGORY] = true;
        }


        return $this;
    } // setBuyerSelectedInvoiceCategory()

    /**
     * Set the value of [invoice_title] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonOrderProductVersion The current object (for fluent API support)
     */
    public function setInvoiceTitle($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->invoice_title !== $v) {
            $this->invoice_title = $v;
            $this->modifiedColumns[AmazonOrderProductVersionTableMap::INVOICE_TITLE] = true;
        }


        return $this;
    } // setInvoiceTitle()

    /**
     * Set the value of [invoice_information] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonOrderProductVersion The current object (for fluent API support)
     */
    public function setInvoiceInformation($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->invoice_information !== $v) {
            $this->invoice_information = $v;
            $this->modifiedColumns[AmazonOrderProductVersionTableMap::INVOICE_INFORMATION] = true;
        }


        return $this;
    } // setInvoiceInformation()

    /**
     * Set the value of [condition_note] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonOrderProductVersion The current object (for fluent API support)
     */
    public function setConditionNote($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->condition_note !== $v) {
            $this->condition_note = $v;
            $this->modifiedColumns[AmazonOrderProductVersionTableMap::CONDITION_NOTE] = true;
        }


        return $this;
    } // setConditionNote()

    /**
     * Set the value of [condition_id] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonOrderProductVersion The current object (for fluent API support)
     */
    public function setConditionId($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->condition_id !== $v) {
            $this->condition_id = $v;
            $this->modifiedColumns[AmazonOrderProductVersionTableMap::CONDITION_ID] = true;
        }


        return $this;
    } // setConditionId()

    /**
     * Set the value of [condition_subtype_id] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonOrderProductVersion The current object (for fluent API support)
     */
    public function setConditionSubtypeId($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->condition_subtype_id !== $v) {
            $this->condition_subtype_id = $v;
            $this->modifiedColumns[AmazonOrderProductVersionTableMap::CONDITION_SUBTYPE_ID] = true;
        }


        return $this;
    } // setConditionSubtypeId()

    /**
     * Set the value of [schedule_delivery_start_date] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonOrderProductVersion The current object (for fluent API support)
     */
    public function setScheduledDeliveryStartDate($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->schedule_delivery_start_date !== $v) {
            $this->schedule_delivery_start_date = $v;
            $this->modifiedColumns[AmazonOrderProductVersionTableMap::SCHEDULE_DELIVERY_START_DATE] = true;
        }


        return $this;
    } // setScheduledDeliveryStartDate()

    /**
     * Set the value of [schedule_delivery_end_date] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonOrderProductVersion The current object (for fluent API support)
     */
    public function setScheduledDeliveryEndDate($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->schedule_delivery_end_date !== $v) {
            $this->schedule_delivery_end_date = $v;
            $this->modifiedColumns[AmazonOrderProductVersionTableMap::SCHEDULE_DELIVERY_END_DATE] = true;
        }


        return $this;
    } // setScheduledDeliveryEndDate()

    /**
     * Set the value of [price_designation] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonOrderProductVersion The current object (for fluent API support)
     */
    public function setPriceDesignation($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->price_designation !== $v) {
            $this->price_designation = $v;
            $this->modifiedColumns[AmazonOrderProductVersionTableMap::PRICE_DESIGNATION] = true;
        }


        return $this;
    } // setPriceDesignation()

    /**
     * Set the value of [buyer_customized_url] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonOrderProductVersion The current object (for fluent API support)
     */
    public function setBuyerCustomizedURL($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->buyer_customized_url !== $v) {
            $this->buyer_customized_url = $v;
            $this->modifiedColumns[AmazonOrderProductVersionTableMap::BUYER_CUSTOMIZED_URL] = true;
        }


        return $this;
    } // setBuyerCustomizedURL()

    /**
     * Set the value of [order_product_id] column.
     * 
     * @param      int $v new value
     * @return   \AmazonIntegration\Model\AmazonOrderProductVersion The current object (for fluent API support)
     */
    public function setOrderProductId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->order_product_id !== $v) {
            $this->order_product_id = $v;
            $this->modifiedColumns[AmazonOrderProductVersionTableMap::ORDER_PRODUCT_ID] = true;
        }


        return $this;
    } // setOrderProductId()

    /**
     * Sets the value of [created_at] column to a normalized version of the date/time value specified.
     * 
     * @param      mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return   \AmazonIntegration\Model\AmazonOrderProductVersion The current object (for fluent API support)
     */
    public function setCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->created_at !== null || $dt !== null) {
            if ($dt !== $this->created_at) {
                $this->created_at = $dt;
                $this->modifiedColumns[AmazonOrderProductVersionTableMap::CREATED_AT] = true;
            }
        } // if either are not null


        return $this;
    } // setCreatedAt()

    /**
     * Sets the value of [updated_at] column to a normalized version of the date/time value specified.
     * 
     * @param      mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return   \AmazonIntegration\Model\AmazonOrderProductVersion The current object (for fluent API support)
     */
    public function setUpdatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->updated_at !== null || $dt !== null) {
            if ($dt !== $this->updated_at) {
                $this->updated_at = $dt;
                $this->modifiedColumns[AmazonOrderProductVersionTableMap::UPDATED_AT] = true;
            }
        } // if either are not null


        return $this;
    } // setUpdatedAt()

    /**
     * Set the value of [version] column.
     * 
     * @param      int $v new value
     * @return   \AmazonIntegration\Model\AmazonOrderProductVersion The current object (for fluent API support)
     */
    public function setVersion($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->version !== $v) {
            $this->version = $v;
            $this->modifiedColumns[AmazonOrderProductVersionTableMap::VERSION] = true;
        }


        return $this;
    } // setVersion()

    /**
     * Sets the value of [version_created_at] column to a normalized version of the date/time value specified.
     * 
     * @param      mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return   \AmazonIntegration\Model\AmazonOrderProductVersion The current object (for fluent API support)
     */
    public function setVersionCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->version_created_at !== null || $dt !== null) {
            if ($dt !== $this->version_created_at) {
                $this->version_created_at = $dt;
                $this->modifiedColumns[AmazonOrderProductVersionTableMap::VERSION_CREATED_AT] = true;
            }
        } // if either are not null


        return $this;
    } // setVersionCreatedAt()

    /**
     * Set the value of [version_created_by] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonOrderProductVersion The current object (for fluent API support)
     */
    public function setVersionCreatedBy($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->version_created_by !== $v) {
            $this->version_created_by = $v;
            $this->modifiedColumns[AmazonOrderProductVersionTableMap::VERSION_CREATED_BY] = true;
        }


        return $this;
    } // setVersionCreatedBy()

    /**
     * Set the value of [amazon_order_id_version] column.
     * 
     * @param      int $v new value
     * @return   \AmazonIntegration\Model\AmazonOrderProductVersion The current object (for fluent API support)
     */
    public function setAmazonOrderIdVersion($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->amazon_order_id_version !== $v) {
            $this->amazon_order_id_version = $v;
            $this->modifiedColumns[AmazonOrderProductVersionTableMap::AMAZON_ORDER_ID_VERSION] = true;
        }


        return $this;
    } // setAmazonOrderIdVersion()

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

            if ($this->amazon_order_id_version !== 0) {
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


            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : AmazonOrderProductVersionTableMap::translateFieldName('OrderItemId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->order_item_id = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : AmazonOrderProductVersionTableMap::translateFieldName('AmazonOrderId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->amazon_order_id = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : AmazonOrderProductVersionTableMap::translateFieldName('Asin', TableMap::TYPE_PHPNAME, $indexType)];
            $this->asin = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : AmazonOrderProductVersionTableMap::translateFieldName('SellerSku', TableMap::TYPE_PHPNAME, $indexType)];
            $this->seller_sku = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : AmazonOrderProductVersionTableMap::translateFieldName('Title', TableMap::TYPE_PHPNAME, $indexType)];
            $this->title = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : AmazonOrderProductVersionTableMap::translateFieldName('QuantityOrdered', TableMap::TYPE_PHPNAME, $indexType)];
            $this->quantity_ordered = (null !== $col) ? (double) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : AmazonOrderProductVersionTableMap::translateFieldName('QuantityShipped', TableMap::TYPE_PHPNAME, $indexType)];
            $this->quantity_shipped = (null !== $col) ? (double) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : AmazonOrderProductVersionTableMap::translateFieldName('PointsGrantedNumber', TableMap::TYPE_PHPNAME, $indexType)];
            $this->points_granted_number = (null !== $col) ? (double) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : AmazonOrderProductVersionTableMap::translateFieldName('PointsGrantedCurrencyCode', TableMap::TYPE_PHPNAME, $indexType)];
            $this->points_granted_currency_code = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : AmazonOrderProductVersionTableMap::translateFieldName('PointsGrantedAmount', TableMap::TYPE_PHPNAME, $indexType)];
            $this->points_granted_amount = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 10 + $startcol : AmazonOrderProductVersionTableMap::translateFieldName('ItemPriceCurrencyCode', TableMap::TYPE_PHPNAME, $indexType)];
            $this->item_price_currency_code = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 11 + $startcol : AmazonOrderProductVersionTableMap::translateFieldName('ItemPriceAmount', TableMap::TYPE_PHPNAME, $indexType)];
            $this->item_price_amount = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 12 + $startcol : AmazonOrderProductVersionTableMap::translateFieldName('ShippingPriceCurrencyCode', TableMap::TYPE_PHPNAME, $indexType)];
            $this->shipping_price_currency_code = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 13 + $startcol : AmazonOrderProductVersionTableMap::translateFieldName('ShippingPriceAmount', TableMap::TYPE_PHPNAME, $indexType)];
            $this->shipping_price_amount = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 14 + $startcol : AmazonOrderProductVersionTableMap::translateFieldName('GiftWrapPriceCurrencyCode', TableMap::TYPE_PHPNAME, $indexType)];
            $this->gift_wrap_price_currency_code = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 15 + $startcol : AmazonOrderProductVersionTableMap::translateFieldName('GiftWrapPriceAmount', TableMap::TYPE_PHPNAME, $indexType)];
            $this->gift_wrap_price_amount = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 16 + $startcol : AmazonOrderProductVersionTableMap::translateFieldName('ItemTaxCurrencyCode', TableMap::TYPE_PHPNAME, $indexType)];
            $this->item_tax_currency_code = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 17 + $startcol : AmazonOrderProductVersionTableMap::translateFieldName('ItemTaxAmount', TableMap::TYPE_PHPNAME, $indexType)];
            $this->item_tax_amount = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 18 + $startcol : AmazonOrderProductVersionTableMap::translateFieldName('ShippingTaxCurrencyCode', TableMap::TYPE_PHPNAME, $indexType)];
            $this->shipping_tax_currency_code = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 19 + $startcol : AmazonOrderProductVersionTableMap::translateFieldName('ShippingTaxAmount', TableMap::TYPE_PHPNAME, $indexType)];
            $this->shipping_tax_amount = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 20 + $startcol : AmazonOrderProductVersionTableMap::translateFieldName('GiftWrapTaxCurrencyCode', TableMap::TYPE_PHPNAME, $indexType)];
            $this->gift_wrap_tax_currency_code = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 21 + $startcol : AmazonOrderProductVersionTableMap::translateFieldName('GiftWrapTaxAmount', TableMap::TYPE_PHPNAME, $indexType)];
            $this->gift_wrap_tax_amount = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 22 + $startcol : AmazonOrderProductVersionTableMap::translateFieldName('ShippingDiscountCurrencyCode', TableMap::TYPE_PHPNAME, $indexType)];
            $this->shipping_discount_currency_code = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 23 + $startcol : AmazonOrderProductVersionTableMap::translateFieldName('ShippingDiscountAmount', TableMap::TYPE_PHPNAME, $indexType)];
            $this->shipping_discount_amount = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 24 + $startcol : AmazonOrderProductVersionTableMap::translateFieldName('PromotionDiscountCurrencyCode', TableMap::TYPE_PHPNAME, $indexType)];
            $this->promotion_discount_currency_code = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 25 + $startcol : AmazonOrderProductVersionTableMap::translateFieldName('PromotionDiscountAmount', TableMap::TYPE_PHPNAME, $indexType)];
            $this->promotion_discount_amount = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 26 + $startcol : AmazonOrderProductVersionTableMap::translateFieldName('PromotionId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->promotion_id = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 27 + $startcol : AmazonOrderProductVersionTableMap::translateFieldName('CodFeeCurrencyCode', TableMap::TYPE_PHPNAME, $indexType)];
            $this->cod_fee_currency_code = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 28 + $startcol : AmazonOrderProductVersionTableMap::translateFieldName('CodFeeAmount', TableMap::TYPE_PHPNAME, $indexType)];
            $this->cod_fee_amount = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 29 + $startcol : AmazonOrderProductVersionTableMap::translateFieldName('CodFeeDiscountCurrencyCode', TableMap::TYPE_PHPNAME, $indexType)];
            $this->cod_fee_discount_currency_code = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 30 + $startcol : AmazonOrderProductVersionTableMap::translateFieldName('CodFeeDiscountAmount', TableMap::TYPE_PHPNAME, $indexType)];
            $this->cod_fee_discount_amount = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 31 + $startcol : AmazonOrderProductVersionTableMap::translateFieldName('GiftMessageText', TableMap::TYPE_PHPNAME, $indexType)];
            $this->gift_message_text = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 32 + $startcol : AmazonOrderProductVersionTableMap::translateFieldName('GiftWrapLevel', TableMap::TYPE_PHPNAME, $indexType)];
            $this->gift_wrap_level = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 33 + $startcol : AmazonOrderProductVersionTableMap::translateFieldName('InvoiceRequirement', TableMap::TYPE_PHPNAME, $indexType)];
            $this->invoice_requirement = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 34 + $startcol : AmazonOrderProductVersionTableMap::translateFieldName('BuyerSelectedInvoiceCategory', TableMap::TYPE_PHPNAME, $indexType)];
            $this->buyer_selected_invoice_category = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 35 + $startcol : AmazonOrderProductVersionTableMap::translateFieldName('InvoiceTitle', TableMap::TYPE_PHPNAME, $indexType)];
            $this->invoice_title = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 36 + $startcol : AmazonOrderProductVersionTableMap::translateFieldName('InvoiceInformation', TableMap::TYPE_PHPNAME, $indexType)];
            $this->invoice_information = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 37 + $startcol : AmazonOrderProductVersionTableMap::translateFieldName('ConditionNote', TableMap::TYPE_PHPNAME, $indexType)];
            $this->condition_note = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 38 + $startcol : AmazonOrderProductVersionTableMap::translateFieldName('ConditionId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->condition_id = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 39 + $startcol : AmazonOrderProductVersionTableMap::translateFieldName('ConditionSubtypeId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->condition_subtype_id = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 40 + $startcol : AmazonOrderProductVersionTableMap::translateFieldName('ScheduledDeliveryStartDate', TableMap::TYPE_PHPNAME, $indexType)];
            $this->schedule_delivery_start_date = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 41 + $startcol : AmazonOrderProductVersionTableMap::translateFieldName('ScheduledDeliveryEndDate', TableMap::TYPE_PHPNAME, $indexType)];
            $this->schedule_delivery_end_date = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 42 + $startcol : AmazonOrderProductVersionTableMap::translateFieldName('PriceDesignation', TableMap::TYPE_PHPNAME, $indexType)];
            $this->price_designation = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 43 + $startcol : AmazonOrderProductVersionTableMap::translateFieldName('BuyerCustomizedURL', TableMap::TYPE_PHPNAME, $indexType)];
            $this->buyer_customized_url = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 44 + $startcol : AmazonOrderProductVersionTableMap::translateFieldName('OrderProductId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->order_product_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 45 + $startcol : AmazonOrderProductVersionTableMap::translateFieldName('CreatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->created_at = (null !== $col) ? PropelDateTime::newInstance($col, null, '\DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 46 + $startcol : AmazonOrderProductVersionTableMap::translateFieldName('UpdatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->updated_at = (null !== $col) ? PropelDateTime::newInstance($col, null, '\DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 47 + $startcol : AmazonOrderProductVersionTableMap::translateFieldName('Version', TableMap::TYPE_PHPNAME, $indexType)];
            $this->version = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 48 + $startcol : AmazonOrderProductVersionTableMap::translateFieldName('VersionCreatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->version_created_at = (null !== $col) ? PropelDateTime::newInstance($col, null, '\DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 49 + $startcol : AmazonOrderProductVersionTableMap::translateFieldName('VersionCreatedBy', TableMap::TYPE_PHPNAME, $indexType)];
            $this->version_created_by = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 50 + $startcol : AmazonOrderProductVersionTableMap::translateFieldName('AmazonOrderIdVersion', TableMap::TYPE_PHPNAME, $indexType)];
            $this->amazon_order_id_version = (null !== $col) ? (int) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 51; // 51 = AmazonOrderProductVersionTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating \AmazonIntegration\Model\AmazonOrderProductVersion object", 0, $e);
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
        if ($this->aAmazonOrderProduct !== null && $this->order_item_id !== $this->aAmazonOrderProduct->getOrderItemId()) {
            $this->aAmazonOrderProduct = null;
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
            $con = Propel::getServiceContainer()->getReadConnection(AmazonOrderProductVersionTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildAmazonOrderProductVersionQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aAmazonOrderProduct = null;
        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see AmazonOrderProductVersion::setDeleted()
     * @see AmazonOrderProductVersion::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(AmazonOrderProductVersionTableMap::DATABASE_NAME);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = ChildAmazonOrderProductVersionQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(AmazonOrderProductVersionTableMap::DATABASE_NAME);
        }

        $con->beginTransaction();
        $isInsert = $this->isNew();
        try {
            $ret = $this->preSave($con);
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
            } else {
                $ret = $ret && $this->preUpdate($con);
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                AmazonOrderProductVersionTableMap::addInstanceToPool($this);
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

            if ($this->aAmazonOrderProduct !== null) {
                if ($this->aAmazonOrderProduct->isModified() || $this->aAmazonOrderProduct->isNew()) {
                    $affectedRows += $this->aAmazonOrderProduct->save($con);
                }
                $this->setAmazonOrderProduct($this->aAmazonOrderProduct);
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
        if ($this->isColumnModified(AmazonOrderProductVersionTableMap::ORDER_ITEM_ID)) {
            $modifiedColumns[':p' . $index++]  = 'ORDER_ITEM_ID';
        }
        if ($this->isColumnModified(AmazonOrderProductVersionTableMap::AMAZON_ORDER_ID)) {
            $modifiedColumns[':p' . $index++]  = 'AMAZON_ORDER_ID';
        }
        if ($this->isColumnModified(AmazonOrderProductVersionTableMap::ASIN)) {
            $modifiedColumns[':p' . $index++]  = 'ASIN';
        }
        if ($this->isColumnModified(AmazonOrderProductVersionTableMap::SELLER_SKU)) {
            $modifiedColumns[':p' . $index++]  = 'SELLER_SKU';
        }
        if ($this->isColumnModified(AmazonOrderProductVersionTableMap::TITLE)) {
            $modifiedColumns[':p' . $index++]  = 'TITLE';
        }
        if ($this->isColumnModified(AmazonOrderProductVersionTableMap::QUANTITY_ORDERED)) {
            $modifiedColumns[':p' . $index++]  = 'QUANTITY_ORDERED';
        }
        if ($this->isColumnModified(AmazonOrderProductVersionTableMap::QUANTITY_SHIPPED)) {
            $modifiedColumns[':p' . $index++]  = 'QUANTITY_SHIPPED';
        }
        if ($this->isColumnModified(AmazonOrderProductVersionTableMap::POINTS_GRANTED_NUMBER)) {
            $modifiedColumns[':p' . $index++]  = 'POINTS_GRANTED_NUMBER';
        }
        if ($this->isColumnModified(AmazonOrderProductVersionTableMap::POINTS_GRANTED_CURRENCY_CODE)) {
            $modifiedColumns[':p' . $index++]  = 'POINTS_GRANTED_CURRENCY_CODE';
        }
        if ($this->isColumnModified(AmazonOrderProductVersionTableMap::POINTS_GRANTED_AMOUNT)) {
            $modifiedColumns[':p' . $index++]  = 'POINTS_GRANTED_AMOUNT';
        }
        if ($this->isColumnModified(AmazonOrderProductVersionTableMap::ITEM_PRICE_CURRENCY_CODE)) {
            $modifiedColumns[':p' . $index++]  = 'ITEM_PRICE_CURRENCY_CODE';
        }
        if ($this->isColumnModified(AmazonOrderProductVersionTableMap::ITEM_PRICE_AMOUNT)) {
            $modifiedColumns[':p' . $index++]  = 'ITEM_PRICE_AMOUNT';
        }
        if ($this->isColumnModified(AmazonOrderProductVersionTableMap::SHIPPING_PRICE_CURRENCY_CODE)) {
            $modifiedColumns[':p' . $index++]  = 'SHIPPING_PRICE_CURRENCY_CODE';
        }
        if ($this->isColumnModified(AmazonOrderProductVersionTableMap::SHIPPING_PRICE_AMOUNT)) {
            $modifiedColumns[':p' . $index++]  = 'SHIPPING_PRICE_AMOUNT';
        }
        if ($this->isColumnModified(AmazonOrderProductVersionTableMap::GIFT_WRAP_PRICE_CURRENCY_CODE)) {
            $modifiedColumns[':p' . $index++]  = 'GIFT_WRAP_PRICE_CURRENCY_CODE';
        }
        if ($this->isColumnModified(AmazonOrderProductVersionTableMap::GIFT_WRAP_PRICE_AMOUNT)) {
            $modifiedColumns[':p' . $index++]  = 'GIFT_WRAP_PRICE_AMOUNT';
        }
        if ($this->isColumnModified(AmazonOrderProductVersionTableMap::ITEM_TAX_CURRENCY_CODE)) {
            $modifiedColumns[':p' . $index++]  = 'ITEM_TAX_CURRENCY_CODE';
        }
        if ($this->isColumnModified(AmazonOrderProductVersionTableMap::ITEM_TAX_AMOUNT)) {
            $modifiedColumns[':p' . $index++]  = 'ITEM_TAX_AMOUNT';
        }
        if ($this->isColumnModified(AmazonOrderProductVersionTableMap::SHIPPING_TAX_CURRENCY_CODE)) {
            $modifiedColumns[':p' . $index++]  = 'SHIPPING_TAX_CURRENCY_CODE';
        }
        if ($this->isColumnModified(AmazonOrderProductVersionTableMap::SHIPPING_TAX_AMOUNT)) {
            $modifiedColumns[':p' . $index++]  = 'SHIPPING_TAX_AMOUNT';
        }
        if ($this->isColumnModified(AmazonOrderProductVersionTableMap::GIFT_WRAP_TAX_CURRENCY_CODE)) {
            $modifiedColumns[':p' . $index++]  = 'GIFT_WRAP_TAX_CURRENCY_CODE';
        }
        if ($this->isColumnModified(AmazonOrderProductVersionTableMap::GIFT_WRAP_TAX_AMOUNT)) {
            $modifiedColumns[':p' . $index++]  = 'GIFT_WRAP_TAX_AMOUNT';
        }
        if ($this->isColumnModified(AmazonOrderProductVersionTableMap::SHIPPING_DISCOUNT_CURRENCY_CODE)) {
            $modifiedColumns[':p' . $index++]  = 'SHIPPING_DISCOUNT_CURRENCY_CODE';
        }
        if ($this->isColumnModified(AmazonOrderProductVersionTableMap::SHIPPING_DISCOUNT_AMOUNT)) {
            $modifiedColumns[':p' . $index++]  = 'SHIPPING_DISCOUNT_AMOUNT';
        }
        if ($this->isColumnModified(AmazonOrderProductVersionTableMap::PROMOTION_DISCOUNT_CURRENCY_CODE)) {
            $modifiedColumns[':p' . $index++]  = 'PROMOTION_DISCOUNT_CURRENCY_CODE';
        }
        if ($this->isColumnModified(AmazonOrderProductVersionTableMap::PROMOTION_DISCOUNT_AMOUNT)) {
            $modifiedColumns[':p' . $index++]  = 'PROMOTION_DISCOUNT_AMOUNT';
        }
        if ($this->isColumnModified(AmazonOrderProductVersionTableMap::PROMOTION_ID)) {
            $modifiedColumns[':p' . $index++]  = 'PROMOTION_ID';
        }
        if ($this->isColumnModified(AmazonOrderProductVersionTableMap::COD_FEE_CURRENCY_CODE)) {
            $modifiedColumns[':p' . $index++]  = 'COD_FEE_CURRENCY_CODE';
        }
        if ($this->isColumnModified(AmazonOrderProductVersionTableMap::COD_FEE_AMOUNT)) {
            $modifiedColumns[':p' . $index++]  = 'COD_FEE_AMOUNT';
        }
        if ($this->isColumnModified(AmazonOrderProductVersionTableMap::COD_FEE_DISCOUNT_CURRENCY_CODE)) {
            $modifiedColumns[':p' . $index++]  = 'COD_FEE_DISCOUNT_CURRENCY_CODE';
        }
        if ($this->isColumnModified(AmazonOrderProductVersionTableMap::COD_FEE_DISCOUNT_AMOUNT)) {
            $modifiedColumns[':p' . $index++]  = 'COD_FEE_DISCOUNT_AMOUNT';
        }
        if ($this->isColumnModified(AmazonOrderProductVersionTableMap::GIFT_MESSAGE_TEXT)) {
            $modifiedColumns[':p' . $index++]  = 'GIFT_MESSAGE_TEXT';
        }
        if ($this->isColumnModified(AmazonOrderProductVersionTableMap::GIFT_WRAP_LEVEL)) {
            $modifiedColumns[':p' . $index++]  = 'GIFT_WRAP_LEVEL';
        }
        if ($this->isColumnModified(AmazonOrderProductVersionTableMap::INVOICE_REQUIREMENT)) {
            $modifiedColumns[':p' . $index++]  = 'INVOICE_REQUIREMENT';
        }
        if ($this->isColumnModified(AmazonOrderProductVersionTableMap::BUYER_SELECTED_INVOICE_CATEGORY)) {
            $modifiedColumns[':p' . $index++]  = 'BUYER_SELECTED_INVOICE_CATEGORY';
        }
        if ($this->isColumnModified(AmazonOrderProductVersionTableMap::INVOICE_TITLE)) {
            $modifiedColumns[':p' . $index++]  = 'INVOICE_TITLE';
        }
        if ($this->isColumnModified(AmazonOrderProductVersionTableMap::INVOICE_INFORMATION)) {
            $modifiedColumns[':p' . $index++]  = 'INVOICE_INFORMATION';
        }
        if ($this->isColumnModified(AmazonOrderProductVersionTableMap::CONDITION_NOTE)) {
            $modifiedColumns[':p' . $index++]  = 'CONDITION_NOTE';
        }
        if ($this->isColumnModified(AmazonOrderProductVersionTableMap::CONDITION_ID)) {
            $modifiedColumns[':p' . $index++]  = 'CONDITION_ID';
        }
        if ($this->isColumnModified(AmazonOrderProductVersionTableMap::CONDITION_SUBTYPE_ID)) {
            $modifiedColumns[':p' . $index++]  = 'CONDITION_SUBTYPE_ID';
        }
        if ($this->isColumnModified(AmazonOrderProductVersionTableMap::SCHEDULE_DELIVERY_START_DATE)) {
            $modifiedColumns[':p' . $index++]  = 'SCHEDULE_DELIVERY_START_DATE';
        }
        if ($this->isColumnModified(AmazonOrderProductVersionTableMap::SCHEDULE_DELIVERY_END_DATE)) {
            $modifiedColumns[':p' . $index++]  = 'SCHEDULE_DELIVERY_END_DATE';
        }
        if ($this->isColumnModified(AmazonOrderProductVersionTableMap::PRICE_DESIGNATION)) {
            $modifiedColumns[':p' . $index++]  = 'PRICE_DESIGNATION';
        }
        if ($this->isColumnModified(AmazonOrderProductVersionTableMap::BUYER_CUSTOMIZED_URL)) {
            $modifiedColumns[':p' . $index++]  = 'BUYER_CUSTOMIZED_URL';
        }
        if ($this->isColumnModified(AmazonOrderProductVersionTableMap::ORDER_PRODUCT_ID)) {
            $modifiedColumns[':p' . $index++]  = 'ORDER_PRODUCT_ID';
        }
        if ($this->isColumnModified(AmazonOrderProductVersionTableMap::CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'CREATED_AT';
        }
        if ($this->isColumnModified(AmazonOrderProductVersionTableMap::UPDATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'UPDATED_AT';
        }
        if ($this->isColumnModified(AmazonOrderProductVersionTableMap::VERSION)) {
            $modifiedColumns[':p' . $index++]  = 'VERSION';
        }
        if ($this->isColumnModified(AmazonOrderProductVersionTableMap::VERSION_CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'VERSION_CREATED_AT';
        }
        if ($this->isColumnModified(AmazonOrderProductVersionTableMap::VERSION_CREATED_BY)) {
            $modifiedColumns[':p' . $index++]  = 'VERSION_CREATED_BY';
        }
        if ($this->isColumnModified(AmazonOrderProductVersionTableMap::AMAZON_ORDER_ID_VERSION)) {
            $modifiedColumns[':p' . $index++]  = 'AMAZON_ORDER_ID_VERSION';
        }

        $sql = sprintf(
            'INSERT INTO amazon_order_product_version (%s) VALUES (%s)',
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
                    case 'AMAZON_ORDER_ID_VERSION':                        
                        $stmt->bindValue($identifier, $this->amazon_order_id_version, PDO::PARAM_INT);
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
        $pos = AmazonOrderProductVersionTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
            case 50:
                return $this->getAmazonOrderIdVersion();
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
        if (isset($alreadyDumpedObjects['AmazonOrderProductVersion'][serialize($this->getPrimaryKey())])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['AmazonOrderProductVersion'][serialize($this->getPrimaryKey())] = true;
        $keys = AmazonOrderProductVersionTableMap::getFieldNames($keyType);
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
            $keys[50] => $this->getAmazonOrderIdVersion(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }
        
        if ($includeForeignObjects) {
            if (null !== $this->aAmazonOrderProduct) {
                $result['AmazonOrderProduct'] = $this->aAmazonOrderProduct->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
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
        $pos = AmazonOrderProductVersionTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

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
            case 50:
                $this->setAmazonOrderIdVersion($value);
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
        $keys = AmazonOrderProductVersionTableMap::getFieldNames($keyType);

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
        if (array_key_exists($keys[50], $arr)) $this->setAmazonOrderIdVersion($arr[$keys[50]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(AmazonOrderProductVersionTableMap::DATABASE_NAME);

        if ($this->isColumnModified(AmazonOrderProductVersionTableMap::ORDER_ITEM_ID)) $criteria->add(AmazonOrderProductVersionTableMap::ORDER_ITEM_ID, $this->order_item_id);
        if ($this->isColumnModified(AmazonOrderProductVersionTableMap::AMAZON_ORDER_ID)) $criteria->add(AmazonOrderProductVersionTableMap::AMAZON_ORDER_ID, $this->amazon_order_id);
        if ($this->isColumnModified(AmazonOrderProductVersionTableMap::ASIN)) $criteria->add(AmazonOrderProductVersionTableMap::ASIN, $this->asin);
        if ($this->isColumnModified(AmazonOrderProductVersionTableMap::SELLER_SKU)) $criteria->add(AmazonOrderProductVersionTableMap::SELLER_SKU, $this->seller_sku);
        if ($this->isColumnModified(AmazonOrderProductVersionTableMap::TITLE)) $criteria->add(AmazonOrderProductVersionTableMap::TITLE, $this->title);
        if ($this->isColumnModified(AmazonOrderProductVersionTableMap::QUANTITY_ORDERED)) $criteria->add(AmazonOrderProductVersionTableMap::QUANTITY_ORDERED, $this->quantity_ordered);
        if ($this->isColumnModified(AmazonOrderProductVersionTableMap::QUANTITY_SHIPPED)) $criteria->add(AmazonOrderProductVersionTableMap::QUANTITY_SHIPPED, $this->quantity_shipped);
        if ($this->isColumnModified(AmazonOrderProductVersionTableMap::POINTS_GRANTED_NUMBER)) $criteria->add(AmazonOrderProductVersionTableMap::POINTS_GRANTED_NUMBER, $this->points_granted_number);
        if ($this->isColumnModified(AmazonOrderProductVersionTableMap::POINTS_GRANTED_CURRENCY_CODE)) $criteria->add(AmazonOrderProductVersionTableMap::POINTS_GRANTED_CURRENCY_CODE, $this->points_granted_currency_code);
        if ($this->isColumnModified(AmazonOrderProductVersionTableMap::POINTS_GRANTED_AMOUNT)) $criteria->add(AmazonOrderProductVersionTableMap::POINTS_GRANTED_AMOUNT, $this->points_granted_amount);
        if ($this->isColumnModified(AmazonOrderProductVersionTableMap::ITEM_PRICE_CURRENCY_CODE)) $criteria->add(AmazonOrderProductVersionTableMap::ITEM_PRICE_CURRENCY_CODE, $this->item_price_currency_code);
        if ($this->isColumnModified(AmazonOrderProductVersionTableMap::ITEM_PRICE_AMOUNT)) $criteria->add(AmazonOrderProductVersionTableMap::ITEM_PRICE_AMOUNT, $this->item_price_amount);
        if ($this->isColumnModified(AmazonOrderProductVersionTableMap::SHIPPING_PRICE_CURRENCY_CODE)) $criteria->add(AmazonOrderProductVersionTableMap::SHIPPING_PRICE_CURRENCY_CODE, $this->shipping_price_currency_code);
        if ($this->isColumnModified(AmazonOrderProductVersionTableMap::SHIPPING_PRICE_AMOUNT)) $criteria->add(AmazonOrderProductVersionTableMap::SHIPPING_PRICE_AMOUNT, $this->shipping_price_amount);
        if ($this->isColumnModified(AmazonOrderProductVersionTableMap::GIFT_WRAP_PRICE_CURRENCY_CODE)) $criteria->add(AmazonOrderProductVersionTableMap::GIFT_WRAP_PRICE_CURRENCY_CODE, $this->gift_wrap_price_currency_code);
        if ($this->isColumnModified(AmazonOrderProductVersionTableMap::GIFT_WRAP_PRICE_AMOUNT)) $criteria->add(AmazonOrderProductVersionTableMap::GIFT_WRAP_PRICE_AMOUNT, $this->gift_wrap_price_amount);
        if ($this->isColumnModified(AmazonOrderProductVersionTableMap::ITEM_TAX_CURRENCY_CODE)) $criteria->add(AmazonOrderProductVersionTableMap::ITEM_TAX_CURRENCY_CODE, $this->item_tax_currency_code);
        if ($this->isColumnModified(AmazonOrderProductVersionTableMap::ITEM_TAX_AMOUNT)) $criteria->add(AmazonOrderProductVersionTableMap::ITEM_TAX_AMOUNT, $this->item_tax_amount);
        if ($this->isColumnModified(AmazonOrderProductVersionTableMap::SHIPPING_TAX_CURRENCY_CODE)) $criteria->add(AmazonOrderProductVersionTableMap::SHIPPING_TAX_CURRENCY_CODE, $this->shipping_tax_currency_code);
        if ($this->isColumnModified(AmazonOrderProductVersionTableMap::SHIPPING_TAX_AMOUNT)) $criteria->add(AmazonOrderProductVersionTableMap::SHIPPING_TAX_AMOUNT, $this->shipping_tax_amount);
        if ($this->isColumnModified(AmazonOrderProductVersionTableMap::GIFT_WRAP_TAX_CURRENCY_CODE)) $criteria->add(AmazonOrderProductVersionTableMap::GIFT_WRAP_TAX_CURRENCY_CODE, $this->gift_wrap_tax_currency_code);
        if ($this->isColumnModified(AmazonOrderProductVersionTableMap::GIFT_WRAP_TAX_AMOUNT)) $criteria->add(AmazonOrderProductVersionTableMap::GIFT_WRAP_TAX_AMOUNT, $this->gift_wrap_tax_amount);
        if ($this->isColumnModified(AmazonOrderProductVersionTableMap::SHIPPING_DISCOUNT_CURRENCY_CODE)) $criteria->add(AmazonOrderProductVersionTableMap::SHIPPING_DISCOUNT_CURRENCY_CODE, $this->shipping_discount_currency_code);
        if ($this->isColumnModified(AmazonOrderProductVersionTableMap::SHIPPING_DISCOUNT_AMOUNT)) $criteria->add(AmazonOrderProductVersionTableMap::SHIPPING_DISCOUNT_AMOUNT, $this->shipping_discount_amount);
        if ($this->isColumnModified(AmazonOrderProductVersionTableMap::PROMOTION_DISCOUNT_CURRENCY_CODE)) $criteria->add(AmazonOrderProductVersionTableMap::PROMOTION_DISCOUNT_CURRENCY_CODE, $this->promotion_discount_currency_code);
        if ($this->isColumnModified(AmazonOrderProductVersionTableMap::PROMOTION_DISCOUNT_AMOUNT)) $criteria->add(AmazonOrderProductVersionTableMap::PROMOTION_DISCOUNT_AMOUNT, $this->promotion_discount_amount);
        if ($this->isColumnModified(AmazonOrderProductVersionTableMap::PROMOTION_ID)) $criteria->add(AmazonOrderProductVersionTableMap::PROMOTION_ID, $this->promotion_id);
        if ($this->isColumnModified(AmazonOrderProductVersionTableMap::COD_FEE_CURRENCY_CODE)) $criteria->add(AmazonOrderProductVersionTableMap::COD_FEE_CURRENCY_CODE, $this->cod_fee_currency_code);
        if ($this->isColumnModified(AmazonOrderProductVersionTableMap::COD_FEE_AMOUNT)) $criteria->add(AmazonOrderProductVersionTableMap::COD_FEE_AMOUNT, $this->cod_fee_amount);
        if ($this->isColumnModified(AmazonOrderProductVersionTableMap::COD_FEE_DISCOUNT_CURRENCY_CODE)) $criteria->add(AmazonOrderProductVersionTableMap::COD_FEE_DISCOUNT_CURRENCY_CODE, $this->cod_fee_discount_currency_code);
        if ($this->isColumnModified(AmazonOrderProductVersionTableMap::COD_FEE_DISCOUNT_AMOUNT)) $criteria->add(AmazonOrderProductVersionTableMap::COD_FEE_DISCOUNT_AMOUNT, $this->cod_fee_discount_amount);
        if ($this->isColumnModified(AmazonOrderProductVersionTableMap::GIFT_MESSAGE_TEXT)) $criteria->add(AmazonOrderProductVersionTableMap::GIFT_MESSAGE_TEXT, $this->gift_message_text);
        if ($this->isColumnModified(AmazonOrderProductVersionTableMap::GIFT_WRAP_LEVEL)) $criteria->add(AmazonOrderProductVersionTableMap::GIFT_WRAP_LEVEL, $this->gift_wrap_level);
        if ($this->isColumnModified(AmazonOrderProductVersionTableMap::INVOICE_REQUIREMENT)) $criteria->add(AmazonOrderProductVersionTableMap::INVOICE_REQUIREMENT, $this->invoice_requirement);
        if ($this->isColumnModified(AmazonOrderProductVersionTableMap::BUYER_SELECTED_INVOICE_CATEGORY)) $criteria->add(AmazonOrderProductVersionTableMap::BUYER_SELECTED_INVOICE_CATEGORY, $this->buyer_selected_invoice_category);
        if ($this->isColumnModified(AmazonOrderProductVersionTableMap::INVOICE_TITLE)) $criteria->add(AmazonOrderProductVersionTableMap::INVOICE_TITLE, $this->invoice_title);
        if ($this->isColumnModified(AmazonOrderProductVersionTableMap::INVOICE_INFORMATION)) $criteria->add(AmazonOrderProductVersionTableMap::INVOICE_INFORMATION, $this->invoice_information);
        if ($this->isColumnModified(AmazonOrderProductVersionTableMap::CONDITION_NOTE)) $criteria->add(AmazonOrderProductVersionTableMap::CONDITION_NOTE, $this->condition_note);
        if ($this->isColumnModified(AmazonOrderProductVersionTableMap::CONDITION_ID)) $criteria->add(AmazonOrderProductVersionTableMap::CONDITION_ID, $this->condition_id);
        if ($this->isColumnModified(AmazonOrderProductVersionTableMap::CONDITION_SUBTYPE_ID)) $criteria->add(AmazonOrderProductVersionTableMap::CONDITION_SUBTYPE_ID, $this->condition_subtype_id);
        if ($this->isColumnModified(AmazonOrderProductVersionTableMap::SCHEDULE_DELIVERY_START_DATE)) $criteria->add(AmazonOrderProductVersionTableMap::SCHEDULE_DELIVERY_START_DATE, $this->schedule_delivery_start_date);
        if ($this->isColumnModified(AmazonOrderProductVersionTableMap::SCHEDULE_DELIVERY_END_DATE)) $criteria->add(AmazonOrderProductVersionTableMap::SCHEDULE_DELIVERY_END_DATE, $this->schedule_delivery_end_date);
        if ($this->isColumnModified(AmazonOrderProductVersionTableMap::PRICE_DESIGNATION)) $criteria->add(AmazonOrderProductVersionTableMap::PRICE_DESIGNATION, $this->price_designation);
        if ($this->isColumnModified(AmazonOrderProductVersionTableMap::BUYER_CUSTOMIZED_URL)) $criteria->add(AmazonOrderProductVersionTableMap::BUYER_CUSTOMIZED_URL, $this->buyer_customized_url);
        if ($this->isColumnModified(AmazonOrderProductVersionTableMap::ORDER_PRODUCT_ID)) $criteria->add(AmazonOrderProductVersionTableMap::ORDER_PRODUCT_ID, $this->order_product_id);
        if ($this->isColumnModified(AmazonOrderProductVersionTableMap::CREATED_AT)) $criteria->add(AmazonOrderProductVersionTableMap::CREATED_AT, $this->created_at);
        if ($this->isColumnModified(AmazonOrderProductVersionTableMap::UPDATED_AT)) $criteria->add(AmazonOrderProductVersionTableMap::UPDATED_AT, $this->updated_at);
        if ($this->isColumnModified(AmazonOrderProductVersionTableMap::VERSION)) $criteria->add(AmazonOrderProductVersionTableMap::VERSION, $this->version);
        if ($this->isColumnModified(AmazonOrderProductVersionTableMap::VERSION_CREATED_AT)) $criteria->add(AmazonOrderProductVersionTableMap::VERSION_CREATED_AT, $this->version_created_at);
        if ($this->isColumnModified(AmazonOrderProductVersionTableMap::VERSION_CREATED_BY)) $criteria->add(AmazonOrderProductVersionTableMap::VERSION_CREATED_BY, $this->version_created_by);
        if ($this->isColumnModified(AmazonOrderProductVersionTableMap::AMAZON_ORDER_ID_VERSION)) $criteria->add(AmazonOrderProductVersionTableMap::AMAZON_ORDER_ID_VERSION, $this->amazon_order_id_version);

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
        $criteria = new Criteria(AmazonOrderProductVersionTableMap::DATABASE_NAME);
        $criteria->add(AmazonOrderProductVersionTableMap::ORDER_ITEM_ID, $this->order_item_id);
        $criteria->add(AmazonOrderProductVersionTableMap::VERSION, $this->version);

        return $criteria;
    }

    /**
     * Returns the composite primary key for this object.
     * The array elements will be in same order as specified in XML.
     * @return array
     */
    public function getPrimaryKey()
    {
        $pks = array();
        $pks[0] = $this->getOrderItemId();
        $pks[1] = $this->getVersion();

        return $pks;
    }

    /**
     * Set the [composite] primary key.
     *
     * @param      array $keys The elements of the composite key (order must match the order in XML file).
     * @return void
     */
    public function setPrimaryKey($keys)
    {
        $this->setOrderItemId($keys[0]);
        $this->setVersion($keys[1]);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {

        return (null === $this->getOrderItemId()) && (null === $this->getVersion());
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \AmazonIntegration\Model\AmazonOrderProductVersion (or compatible) type.
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
        $copyObj->setAmazonOrderIdVersion($this->getAmazonOrderIdVersion());
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
     * @return                 \AmazonIntegration\Model\AmazonOrderProductVersion Clone of current object.
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
     * Declares an association between this object and a ChildAmazonOrderProduct object.
     *
     * @param                  ChildAmazonOrderProduct $v
     * @return                 \AmazonIntegration\Model\AmazonOrderProductVersion The current object (for fluent API support)
     * @throws PropelException
     */
    public function setAmazonOrderProduct(ChildAmazonOrderProduct $v = null)
    {
        if ($v === null) {
            $this->setOrderItemId(NULL);
        } else {
            $this->setOrderItemId($v->getOrderItemId());
        }

        $this->aAmazonOrderProduct = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildAmazonOrderProduct object, it will not be re-added.
        if ($v !== null) {
            $v->addAmazonOrderProductVersion($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildAmazonOrderProduct object
     *
     * @param      ConnectionInterface $con Optional Connection object.
     * @return                 ChildAmazonOrderProduct The associated ChildAmazonOrderProduct object.
     * @throws PropelException
     */
    public function getAmazonOrderProduct(ConnectionInterface $con = null)
    {
        if ($this->aAmazonOrderProduct === null && (($this->order_item_id !== "" && $this->order_item_id !== null))) {
            $this->aAmazonOrderProduct = ChildAmazonOrderProductQuery::create()->findPk($this->order_item_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aAmazonOrderProduct->addAmazonOrderProductVersions($this);
             */
        }

        return $this->aAmazonOrderProduct;
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
        $this->amazon_order_id_version = null;
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
        } // if ($deep)

        $this->aAmazonOrderProduct = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(AmazonOrderProductVersionTableMap::DEFAULT_STRING_FORMAT);
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
