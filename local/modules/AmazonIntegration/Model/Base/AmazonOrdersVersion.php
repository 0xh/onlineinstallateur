<?php

namespace AmazonIntegration\Model\Base;

use \DateTime;
use \Exception;
use \PDO;
use AmazonIntegration\Model\AmazonOrders as ChildAmazonOrders;
use AmazonIntegration\Model\AmazonOrdersQuery as ChildAmazonOrdersQuery;
use AmazonIntegration\Model\AmazonOrdersVersionQuery as ChildAmazonOrdersVersionQuery;
use AmazonIntegration\Model\Map\AmazonOrdersVersionTableMap;
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

abstract class AmazonOrdersVersion implements ActiveRecordInterface 
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\AmazonIntegration\\Model\\Map\\AmazonOrdersVersionTableMap';


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
     * The value for the id field.
     * @var        string
     */
    protected $id;

    /**
     * The value for the seller_order_id field.
     * @var        string
     */
    protected $seller_order_id;

    /**
     * The value for the purchase_date field.
     * @var        string
     */
    protected $purchase_date;

    /**
     * The value for the last_update_date field.
     * @var        string
     */
    protected $last_update_date;

    /**
     * The value for the order_status field.
     * @var        string
     */
    protected $order_status;

    /**
     * The value for the fulfillment_channel field.
     * @var        string
     */
    protected $fulfillment_channel;

    /**
     * The value for the sales_channel field.
     * @var        string
     */
    protected $sales_channel;

    /**
     * The value for the order_channel field.
     * @var        string
     */
    protected $order_channel;

    /**
     * The value for the ship_service_level field.
     * @var        string
     */
    protected $ship_service_level;

    /**
     * The value for the order_total_currency_code field.
     * @var        string
     */
    protected $order_total_currency_code;

    /**
     * The value for the order_total_amount field.
     * Note: this column has a database default value of: '0.00'
     * @var        string
     */
    protected $order_total_amount;

    /**
     * The value for the number_of_items_shipped field.
     * @var        double
     */
    protected $number_of_items_shipped;

    /**
     * The value for the number_of_items_unshipped field.
     * @var        double
     */
    protected $number_of_items_unshipped;

    /**
     * The value for the payment_execution_detail_currency_code field.
     * @var        string
     */
    protected $payment_execution_detail_currency_code;

    /**
     * The value for the payment_execution_detail_total_amount field.
     * Note: this column has a database default value of: '0.00'
     * @var        string
     */
    protected $payment_execution_detail_total_amount;

    /**
     * The value for the payment_execution_detail_payment_method field.
     * @var        string
     */
    protected $payment_execution_detail_payment_method;

    /**
     * The value for the payment_method field.
     * @var        string
     */
    protected $payment_method;

    /**
     * The value for the payment_method_detail field.
     * @var        string
     */
    protected $payment_method_detail;

    /**
     * The value for the marketplace_id field.
     * @var        string
     */
    protected $marketplace_id;

    /**
     * The value for the buyer_county field.
     * @var        string
     */
    protected $buyer_county;

    /**
     * The value for the buyer_tax_info_company field.
     * @var        string
     */
    protected $buyer_tax_info_company;

    /**
     * The value for the buyer_tax_info_taxing_region field.
     * @var        string
     */
    protected $buyer_tax_info_taxing_region;

    /**
     * The value for the buyer_tax_info_tax_name field.
     * @var        string
     */
    protected $buyer_tax_info_tax_name;

    /**
     * The value for the buyer_tax_info_tax_value field.
     * @var        string
     */
    protected $buyer_tax_info_tax_value;

    /**
     * The value for the shipment_service_level_category field.
     * @var        string
     */
    protected $shipment_service_level_category;

    /**
     * The value for the shipped_by_amazon_tfm field.
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $shipped_by_amazon_tfm;

    /**
     * The value for the tfm_shipment_status field.
     * @var        string
     */
    protected $tfm_shipment_status;

    /**
     * The value for the cba_displayable_shipping_label field.
     * @var        string
     */
    protected $cba_displayable_shipping_label;

    /**
     * The value for the order_type field.
     * @var        string
     */
    protected $order_type;

    /**
     * The value for the earliest_ship_date field.
     * @var        string
     */
    protected $earliest_ship_date;

    /**
     * The value for the latest_ship_date field.
     * @var        string
     */
    protected $latest_ship_date;

    /**
     * The value for the earliest_delivery_date field.
     * @var        string
     */
    protected $earliest_delivery_date;

    /**
     * The value for the latest_delivery_date field.
     * @var        string
     */
    protected $latest_delivery_date;

    /**
     * The value for the is_business_order field.
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $is_business_order;

    /**
     * The value for the purchase_order_number field.
     * @var        string
     */
    protected $purchase_order_number;

    /**
     * The value for the is_prime field.
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $is_prime;

    /**
     * The value for the is_premium_order field.
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $is_premium_order;

    /**
     * The value for the replaced_order_id field.
     * @var        string
     */
    protected $replaced_order_id;

    /**
     * The value for the is_replacement_order field.
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $is_replacement_order;

    /**
     * The value for the order_address_id field.
     * @var        int
     */
    protected $order_address_id;

    /**
     * The value for the customer_id field.
     * @var        int
     */
    protected $customer_id;

    /**
     * The value for the order_id field.
     * @var        int
     */
    protected $order_id;

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
     * The value for the customer_id_version field.
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $customer_id_version;

    /**
     * The value for the order_id_version field.
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $order_id_version;

    /**
     * @var        AmazonOrders
     */
    protected $aAmazonOrders;

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
        $this->order_total_amount = '0.00';
        $this->payment_execution_detail_total_amount = '0.00';
        $this->shipped_by_amazon_tfm = 0;
        $this->is_business_order = 0;
        $this->is_prime = 0;
        $this->is_premium_order = 0;
        $this->is_replacement_order = 0;
        $this->version = 0;
        $this->customer_id_version = 0;
        $this->order_id_version = 0;
    }

    /**
     * Initializes internal state of AmazonIntegration\Model\Base\AmazonOrdersVersion object.
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
     * Compares this with another <code>AmazonOrdersVersion</code> instance.  If
     * <code>obj</code> is an instance of <code>AmazonOrdersVersion</code>, delegates to
     * <code>equals(AmazonOrdersVersion)</code>.  Otherwise, returns <code>false</code>.
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
     * @return AmazonOrdersVersion The current object, for fluid interface
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
     * @return AmazonOrdersVersion The current object, for fluid interface
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
     * Get the [id] column value.
     * 
     * @return   string
     */
    public function getId()
    {

        return $this->id;
    }

    /**
     * Get the [seller_order_id] column value.
     * 
     * @return   string
     */
    public function getSellerOrderId()
    {

        return $this->seller_order_id;
    }

    /**
     * Get the [optionally formatted] temporal [purchase_date] column value.
     * 
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw \DateTime object will be returned.
     *
     * @return mixed Formatted date/time value as string or \DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getPurchaseDate($format = NULL)
    {
        if ($format === null) {
            return $this->purchase_date;
        } else {
            return $this->purchase_date instanceof \DateTime ? $this->purchase_date->format($format) : null;
        }
    }

    /**
     * Get the [optionally formatted] temporal [last_update_date] column value.
     * 
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw \DateTime object will be returned.
     *
     * @return mixed Formatted date/time value as string or \DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getLastUpdateDate($format = NULL)
    {
        if ($format === null) {
            return $this->last_update_date;
        } else {
            return $this->last_update_date instanceof \DateTime ? $this->last_update_date->format($format) : null;
        }
    }

    /**
     * Get the [order_status] column value.
     * 
     * @return   string
     */
    public function getOrderStatus()
    {

        return $this->order_status;
    }

    /**
     * Get the [fulfillment_channel] column value.
     * 
     * @return   string
     */
    public function getFulfillmentChannel()
    {

        return $this->fulfillment_channel;
    }

    /**
     * Get the [sales_channel] column value.
     * 
     * @return   string
     */
    public function getSalesChannel()
    {

        return $this->sales_channel;
    }

    /**
     * Get the [order_channel] column value.
     * 
     * @return   string
     */
    public function getOrderChannel()
    {

        return $this->order_channel;
    }

    /**
     * Get the [ship_service_level] column value.
     * 
     * @return   string
     */
    public function getShipServiceLevel()
    {

        return $this->ship_service_level;
    }

    /**
     * Get the [order_total_currency_code] column value.
     * 
     * @return   string
     */
    public function getOrderTotalCurrencyCode()
    {

        return $this->order_total_currency_code;
    }

    /**
     * Get the [order_total_amount] column value.
     * 
     * @return   string
     */
    public function getOrderTotalAmount()
    {

        return $this->order_total_amount;
    }

    /**
     * Get the [number_of_items_shipped] column value.
     * 
     * @return   double
     */
    public function getNumberOfItemsShipped()
    {

        return $this->number_of_items_shipped;
    }

    /**
     * Get the [number_of_items_unshipped] column value.
     * 
     * @return   double
     */
    public function getNumberOfItemsUnshipped()
    {

        return $this->number_of_items_unshipped;
    }

    /**
     * Get the [payment_execution_detail_currency_code] column value.
     * 
     * @return   string
     */
    public function getPaymentExecutionDetailCurrencyCode()
    {

        return $this->payment_execution_detail_currency_code;
    }

    /**
     * Get the [payment_execution_detail_total_amount] column value.
     * 
     * @return   string
     */
    public function getPaymentExecutionDetailTotalAmount()
    {

        return $this->payment_execution_detail_total_amount;
    }

    /**
     * Get the [payment_execution_detail_payment_method] column value.
     * 
     * @return   string
     */
    public function getPaymentExecutionDetailPaymentMethod()
    {

        return $this->payment_execution_detail_payment_method;
    }

    /**
     * Get the [payment_method] column value.
     * 
     * @return   string
     */
    public function getPaymentMethod()
    {

        return $this->payment_method;
    }

    /**
     * Get the [payment_method_detail] column value.
     * 
     * @return   string
     */
    public function getPaymentMethodDetail()
    {

        return $this->payment_method_detail;
    }

    /**
     * Get the [marketplace_id] column value.
     * 
     * @return   string
     */
    public function getMarketplaceId()
    {

        return $this->marketplace_id;
    }

    /**
     * Get the [buyer_county] column value.
     * 
     * @return   string
     */
    public function getBuyerCounty()
    {

        return $this->buyer_county;
    }

    /**
     * Get the [buyer_tax_info_company] column value.
     * 
     * @return   string
     */
    public function getBuyerTaxInfoCompany()
    {

        return $this->buyer_tax_info_company;
    }

    /**
     * Get the [buyer_tax_info_taxing_region] column value.
     * 
     * @return   string
     */
    public function getBuyerTaxInfoTaxingRegion()
    {

        return $this->buyer_tax_info_taxing_region;
    }

    /**
     * Get the [buyer_tax_info_tax_name] column value.
     * 
     * @return   string
     */
    public function getBuyerTaxInfoTaxName()
    {

        return $this->buyer_tax_info_tax_name;
    }

    /**
     * Get the [buyer_tax_info_tax_value] column value.
     * 
     * @return   string
     */
    public function getBuyerTaxInfoTaxValue()
    {

        return $this->buyer_tax_info_tax_value;
    }

    /**
     * Get the [shipment_service_level_category] column value.
     * 
     * @return   string
     */
    public function getShipmentServiceLevelCategory()
    {

        return $this->shipment_service_level_category;
    }

    /**
     * Get the [shipped_by_amazon_tfm] column value.
     * 
     * @return   int
     */
    public function getShippedByAmazonTfm()
    {

        return $this->shipped_by_amazon_tfm;
    }

    /**
     * Get the [tfm_shipment_status] column value.
     * 
     * @return   string
     */
    public function getTfmShipmentStatus()
    {

        return $this->tfm_shipment_status;
    }

    /**
     * Get the [cba_displayable_shipping_label] column value.
     * 
     * @return   string
     */
    public function getCbaDisplayableShippingLabel()
    {

        return $this->cba_displayable_shipping_label;
    }

    /**
     * Get the [order_type] column value.
     * 
     * @return   string
     */
    public function getOrderType()
    {

        return $this->order_type;
    }

    /**
     * Get the [optionally formatted] temporal [earliest_ship_date] column value.
     * 
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw \DateTime object will be returned.
     *
     * @return mixed Formatted date/time value as string or \DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getEarliestShipDate($format = NULL)
    {
        if ($format === null) {
            return $this->earliest_ship_date;
        } else {
            return $this->earliest_ship_date instanceof \DateTime ? $this->earliest_ship_date->format($format) : null;
        }
    }

    /**
     * Get the [optionally formatted] temporal [latest_ship_date] column value.
     * 
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw \DateTime object will be returned.
     *
     * @return mixed Formatted date/time value as string or \DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getLatestShipDate($format = NULL)
    {
        if ($format === null) {
            return $this->latest_ship_date;
        } else {
            return $this->latest_ship_date instanceof \DateTime ? $this->latest_ship_date->format($format) : null;
        }
    }

    /**
     * Get the [optionally formatted] temporal [earliest_delivery_date] column value.
     * 
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw \DateTime object will be returned.
     *
     * @return mixed Formatted date/time value as string or \DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getEarliestDeliveryDate($format = NULL)
    {
        if ($format === null) {
            return $this->earliest_delivery_date;
        } else {
            return $this->earliest_delivery_date instanceof \DateTime ? $this->earliest_delivery_date->format($format) : null;
        }
    }

    /**
     * Get the [optionally formatted] temporal [latest_delivery_date] column value.
     * 
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw \DateTime object will be returned.
     *
     * @return mixed Formatted date/time value as string or \DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getLatestDeliveryDate($format = NULL)
    {
        if ($format === null) {
            return $this->latest_delivery_date;
        } else {
            return $this->latest_delivery_date instanceof \DateTime ? $this->latest_delivery_date->format($format) : null;
        }
    }

    /**
     * Get the [is_business_order] column value.
     * 
     * @return   int
     */
    public function getIsBusinessOrder()
    {

        return $this->is_business_order;
    }

    /**
     * Get the [purchase_order_number] column value.
     * 
     * @return   string
     */
    public function getPurchaseOrderNumber()
    {

        return $this->purchase_order_number;
    }

    /**
     * Get the [is_prime] column value.
     * 
     * @return   int
     */
    public function getIsPrime()
    {

        return $this->is_prime;
    }

    /**
     * Get the [is_premium_order] column value.
     * 
     * @return   int
     */
    public function getIsPremiumOrder()
    {

        return $this->is_premium_order;
    }

    /**
     * Get the [replaced_order_id] column value.
     * 
     * @return   string
     */
    public function getReplacedOrderId()
    {

        return $this->replaced_order_id;
    }

    /**
     * Get the [is_replacement_order] column value.
     * 
     * @return   int
     */
    public function getIsReplacementOrder()
    {

        return $this->is_replacement_order;
    }

    /**
     * Get the [order_address_id] column value.
     * 
     * @return   int
     */
    public function getOrderAddressId()
    {

        return $this->order_address_id;
    }

    /**
     * Get the [customer_id] column value.
     * 
     * @return   int
     */
    public function getCustomerId()
    {

        return $this->customer_id;
    }

    /**
     * Get the [order_id] column value.
     * 
     * @return   int
     */
    public function getOrderId()
    {

        return $this->order_id;
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
     * Get the [customer_id_version] column value.
     * 
     * @return   int
     */
    public function getCustomerIdVersion()
    {

        return $this->customer_id_version;
    }

    /**
     * Get the [order_id_version] column value.
     * 
     * @return   int
     */
    public function getOrderIdVersion()
    {

        return $this->order_id_version;
    }

    /**
     * Set the value of [id] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonOrdersVersion The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[AmazonOrdersVersionTableMap::ID] = true;
        }

        if ($this->aAmazonOrders !== null && $this->aAmazonOrders->getId() !== $v) {
            $this->aAmazonOrders = null;
        }


        return $this;
    } // setId()

    /**
     * Set the value of [seller_order_id] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonOrdersVersion The current object (for fluent API support)
     */
    public function setSellerOrderId($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->seller_order_id !== $v) {
            $this->seller_order_id = $v;
            $this->modifiedColumns[AmazonOrdersVersionTableMap::SELLER_ORDER_ID] = true;
        }


        return $this;
    } // setSellerOrderId()

    /**
     * Sets the value of [purchase_date] column to a normalized version of the date/time value specified.
     * 
     * @param      mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return   \AmazonIntegration\Model\AmazonOrdersVersion The current object (for fluent API support)
     */
    public function setPurchaseDate($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->purchase_date !== null || $dt !== null) {
            if ($dt !== $this->purchase_date) {
                $this->purchase_date = $dt;
                $this->modifiedColumns[AmazonOrdersVersionTableMap::PURCHASE_DATE] = true;
            }
        } // if either are not null


        return $this;
    } // setPurchaseDate()

    /**
     * Sets the value of [last_update_date] column to a normalized version of the date/time value specified.
     * 
     * @param      mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return   \AmazonIntegration\Model\AmazonOrdersVersion The current object (for fluent API support)
     */
    public function setLastUpdateDate($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->last_update_date !== null || $dt !== null) {
            if ($dt !== $this->last_update_date) {
                $this->last_update_date = $dt;
                $this->modifiedColumns[AmazonOrdersVersionTableMap::LAST_UPDATE_DATE] = true;
            }
        } // if either are not null


        return $this;
    } // setLastUpdateDate()

    /**
     * Set the value of [order_status] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonOrdersVersion The current object (for fluent API support)
     */
    public function setOrderStatus($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->order_status !== $v) {
            $this->order_status = $v;
            $this->modifiedColumns[AmazonOrdersVersionTableMap::ORDER_STATUS] = true;
        }


        return $this;
    } // setOrderStatus()

    /**
     * Set the value of [fulfillment_channel] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonOrdersVersion The current object (for fluent API support)
     */
    public function setFulfillmentChannel($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->fulfillment_channel !== $v) {
            $this->fulfillment_channel = $v;
            $this->modifiedColumns[AmazonOrdersVersionTableMap::FULFILLMENT_CHANNEL] = true;
        }


        return $this;
    } // setFulfillmentChannel()

    /**
     * Set the value of [sales_channel] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonOrdersVersion The current object (for fluent API support)
     */
    public function setSalesChannel($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->sales_channel !== $v) {
            $this->sales_channel = $v;
            $this->modifiedColumns[AmazonOrdersVersionTableMap::SALES_CHANNEL] = true;
        }


        return $this;
    } // setSalesChannel()

    /**
     * Set the value of [order_channel] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonOrdersVersion The current object (for fluent API support)
     */
    public function setOrderChannel($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->order_channel !== $v) {
            $this->order_channel = $v;
            $this->modifiedColumns[AmazonOrdersVersionTableMap::ORDER_CHANNEL] = true;
        }


        return $this;
    } // setOrderChannel()

    /**
     * Set the value of [ship_service_level] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonOrdersVersion The current object (for fluent API support)
     */
    public function setShipServiceLevel($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->ship_service_level !== $v) {
            $this->ship_service_level = $v;
            $this->modifiedColumns[AmazonOrdersVersionTableMap::SHIP_SERVICE_LEVEL] = true;
        }


        return $this;
    } // setShipServiceLevel()

    /**
     * Set the value of [order_total_currency_code] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonOrdersVersion The current object (for fluent API support)
     */
    public function setOrderTotalCurrencyCode($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->order_total_currency_code !== $v) {
            $this->order_total_currency_code = $v;
            $this->modifiedColumns[AmazonOrdersVersionTableMap::ORDER_TOTAL_CURRENCY_CODE] = true;
        }


        return $this;
    } // setOrderTotalCurrencyCode()

    /**
     * Set the value of [order_total_amount] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonOrdersVersion The current object (for fluent API support)
     */
    public function setOrderTotalAmount($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->order_total_amount !== $v) {
            $this->order_total_amount = $v;
            $this->modifiedColumns[AmazonOrdersVersionTableMap::ORDER_TOTAL_AMOUNT] = true;
        }


        return $this;
    } // setOrderTotalAmount()

    /**
     * Set the value of [number_of_items_shipped] column.
     * 
     * @param      double $v new value
     * @return   \AmazonIntegration\Model\AmazonOrdersVersion The current object (for fluent API support)
     */
    public function setNumberOfItemsShipped($v)
    {
        if ($v !== null) {
            $v = (double) $v;
        }

        if ($this->number_of_items_shipped !== $v) {
            $this->number_of_items_shipped = $v;
            $this->modifiedColumns[AmazonOrdersVersionTableMap::NUMBER_OF_ITEMS_SHIPPED] = true;
        }


        return $this;
    } // setNumberOfItemsShipped()

    /**
     * Set the value of [number_of_items_unshipped] column.
     * 
     * @param      double $v new value
     * @return   \AmazonIntegration\Model\AmazonOrdersVersion The current object (for fluent API support)
     */
    public function setNumberOfItemsUnshipped($v)
    {
        if ($v !== null) {
            $v = (double) $v;
        }

        if ($this->number_of_items_unshipped !== $v) {
            $this->number_of_items_unshipped = $v;
            $this->modifiedColumns[AmazonOrdersVersionTableMap::NUMBER_OF_ITEMS_UNSHIPPED] = true;
        }


        return $this;
    } // setNumberOfItemsUnshipped()

    /**
     * Set the value of [payment_execution_detail_currency_code] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonOrdersVersion The current object (for fluent API support)
     */
    public function setPaymentExecutionDetailCurrencyCode($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->payment_execution_detail_currency_code !== $v) {
            $this->payment_execution_detail_currency_code = $v;
            $this->modifiedColumns[AmazonOrdersVersionTableMap::PAYMENT_EXECUTION_DETAIL_CURRENCY_CODE] = true;
        }


        return $this;
    } // setPaymentExecutionDetailCurrencyCode()

    /**
     * Set the value of [payment_execution_detail_total_amount] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonOrdersVersion The current object (for fluent API support)
     */
    public function setPaymentExecutionDetailTotalAmount($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->payment_execution_detail_total_amount !== $v) {
            $this->payment_execution_detail_total_amount = $v;
            $this->modifiedColumns[AmazonOrdersVersionTableMap::PAYMENT_EXECUTION_DETAIL_TOTAL_AMOUNT] = true;
        }


        return $this;
    } // setPaymentExecutionDetailTotalAmount()

    /**
     * Set the value of [payment_execution_detail_payment_method] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonOrdersVersion The current object (for fluent API support)
     */
    public function setPaymentExecutionDetailPaymentMethod($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->payment_execution_detail_payment_method !== $v) {
            $this->payment_execution_detail_payment_method = $v;
            $this->modifiedColumns[AmazonOrdersVersionTableMap::PAYMENT_EXECUTION_DETAIL_PAYMENT_METHOD] = true;
        }


        return $this;
    } // setPaymentExecutionDetailPaymentMethod()

    /**
     * Set the value of [payment_method] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonOrdersVersion The current object (for fluent API support)
     */
    public function setPaymentMethod($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->payment_method !== $v) {
            $this->payment_method = $v;
            $this->modifiedColumns[AmazonOrdersVersionTableMap::PAYMENT_METHOD] = true;
        }


        return $this;
    } // setPaymentMethod()

    /**
     * Set the value of [payment_method_detail] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonOrdersVersion The current object (for fluent API support)
     */
    public function setPaymentMethodDetail($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->payment_method_detail !== $v) {
            $this->payment_method_detail = $v;
            $this->modifiedColumns[AmazonOrdersVersionTableMap::PAYMENT_METHOD_DETAIL] = true;
        }


        return $this;
    } // setPaymentMethodDetail()

    /**
     * Set the value of [marketplace_id] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonOrdersVersion The current object (for fluent API support)
     */
    public function setMarketplaceId($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->marketplace_id !== $v) {
            $this->marketplace_id = $v;
            $this->modifiedColumns[AmazonOrdersVersionTableMap::MARKETPLACE_ID] = true;
        }


        return $this;
    } // setMarketplaceId()

    /**
     * Set the value of [buyer_county] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonOrdersVersion The current object (for fluent API support)
     */
    public function setBuyerCounty($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->buyer_county !== $v) {
            $this->buyer_county = $v;
            $this->modifiedColumns[AmazonOrdersVersionTableMap::BUYER_COUNTY] = true;
        }


        return $this;
    } // setBuyerCounty()

    /**
     * Set the value of [buyer_tax_info_company] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonOrdersVersion The current object (for fluent API support)
     */
    public function setBuyerTaxInfoCompany($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->buyer_tax_info_company !== $v) {
            $this->buyer_tax_info_company = $v;
            $this->modifiedColumns[AmazonOrdersVersionTableMap::BUYER_TAX_INFO_COMPANY] = true;
        }


        return $this;
    } // setBuyerTaxInfoCompany()

    /**
     * Set the value of [buyer_tax_info_taxing_region] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonOrdersVersion The current object (for fluent API support)
     */
    public function setBuyerTaxInfoTaxingRegion($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->buyer_tax_info_taxing_region !== $v) {
            $this->buyer_tax_info_taxing_region = $v;
            $this->modifiedColumns[AmazonOrdersVersionTableMap::BUYER_TAX_INFO_TAXING_REGION] = true;
        }


        return $this;
    } // setBuyerTaxInfoTaxingRegion()

    /**
     * Set the value of [buyer_tax_info_tax_name] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonOrdersVersion The current object (for fluent API support)
     */
    public function setBuyerTaxInfoTaxName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->buyer_tax_info_tax_name !== $v) {
            $this->buyer_tax_info_tax_name = $v;
            $this->modifiedColumns[AmazonOrdersVersionTableMap::BUYER_TAX_INFO_TAX_NAME] = true;
        }


        return $this;
    } // setBuyerTaxInfoTaxName()

    /**
     * Set the value of [buyer_tax_info_tax_value] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonOrdersVersion The current object (for fluent API support)
     */
    public function setBuyerTaxInfoTaxValue($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->buyer_tax_info_tax_value !== $v) {
            $this->buyer_tax_info_tax_value = $v;
            $this->modifiedColumns[AmazonOrdersVersionTableMap::BUYER_TAX_INFO_TAX_VALUE] = true;
        }


        return $this;
    } // setBuyerTaxInfoTaxValue()

    /**
     * Set the value of [shipment_service_level_category] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonOrdersVersion The current object (for fluent API support)
     */
    public function setShipmentServiceLevelCategory($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->shipment_service_level_category !== $v) {
            $this->shipment_service_level_category = $v;
            $this->modifiedColumns[AmazonOrdersVersionTableMap::SHIPMENT_SERVICE_LEVEL_CATEGORY] = true;
        }


        return $this;
    } // setShipmentServiceLevelCategory()

    /**
     * Set the value of [shipped_by_amazon_tfm] column.
     * 
     * @param      int $v new value
     * @return   \AmazonIntegration\Model\AmazonOrdersVersion The current object (for fluent API support)
     */
    public function setShippedByAmazonTfm($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->shipped_by_amazon_tfm !== $v) {
            $this->shipped_by_amazon_tfm = $v;
            $this->modifiedColumns[AmazonOrdersVersionTableMap::SHIPPED_BY_AMAZON_TFM] = true;
        }


        return $this;
    } // setShippedByAmazonTfm()

    /**
     * Set the value of [tfm_shipment_status] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonOrdersVersion The current object (for fluent API support)
     */
    public function setTfmShipmentStatus($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->tfm_shipment_status !== $v) {
            $this->tfm_shipment_status = $v;
            $this->modifiedColumns[AmazonOrdersVersionTableMap::TFM_SHIPMENT_STATUS] = true;
        }


        return $this;
    } // setTfmShipmentStatus()

    /**
     * Set the value of [cba_displayable_shipping_label] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonOrdersVersion The current object (for fluent API support)
     */
    public function setCbaDisplayableShippingLabel($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->cba_displayable_shipping_label !== $v) {
            $this->cba_displayable_shipping_label = $v;
            $this->modifiedColumns[AmazonOrdersVersionTableMap::CBA_DISPLAYABLE_SHIPPING_LABEL] = true;
        }


        return $this;
    } // setCbaDisplayableShippingLabel()

    /**
     * Set the value of [order_type] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonOrdersVersion The current object (for fluent API support)
     */
    public function setOrderType($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->order_type !== $v) {
            $this->order_type = $v;
            $this->modifiedColumns[AmazonOrdersVersionTableMap::ORDER_TYPE] = true;
        }


        return $this;
    } // setOrderType()

    /**
     * Sets the value of [earliest_ship_date] column to a normalized version of the date/time value specified.
     * 
     * @param      mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return   \AmazonIntegration\Model\AmazonOrdersVersion The current object (for fluent API support)
     */
    public function setEarliestShipDate($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->earliest_ship_date !== null || $dt !== null) {
            if ($dt !== $this->earliest_ship_date) {
                $this->earliest_ship_date = $dt;
                $this->modifiedColumns[AmazonOrdersVersionTableMap::EARLIEST_SHIP_DATE] = true;
            }
        } // if either are not null


        return $this;
    } // setEarliestShipDate()

    /**
     * Sets the value of [latest_ship_date] column to a normalized version of the date/time value specified.
     * 
     * @param      mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return   \AmazonIntegration\Model\AmazonOrdersVersion The current object (for fluent API support)
     */
    public function setLatestShipDate($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->latest_ship_date !== null || $dt !== null) {
            if ($dt !== $this->latest_ship_date) {
                $this->latest_ship_date = $dt;
                $this->modifiedColumns[AmazonOrdersVersionTableMap::LATEST_SHIP_DATE] = true;
            }
        } // if either are not null


        return $this;
    } // setLatestShipDate()

    /**
     * Sets the value of [earliest_delivery_date] column to a normalized version of the date/time value specified.
     * 
     * @param      mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return   \AmazonIntegration\Model\AmazonOrdersVersion The current object (for fluent API support)
     */
    public function setEarliestDeliveryDate($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->earliest_delivery_date !== null || $dt !== null) {
            if ($dt !== $this->earliest_delivery_date) {
                $this->earliest_delivery_date = $dt;
                $this->modifiedColumns[AmazonOrdersVersionTableMap::EARLIEST_DELIVERY_DATE] = true;
            }
        } // if either are not null


        return $this;
    } // setEarliestDeliveryDate()

    /**
     * Sets the value of [latest_delivery_date] column to a normalized version of the date/time value specified.
     * 
     * @param      mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return   \AmazonIntegration\Model\AmazonOrdersVersion The current object (for fluent API support)
     */
    public function setLatestDeliveryDate($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->latest_delivery_date !== null || $dt !== null) {
            if ($dt !== $this->latest_delivery_date) {
                $this->latest_delivery_date = $dt;
                $this->modifiedColumns[AmazonOrdersVersionTableMap::LATEST_DELIVERY_DATE] = true;
            }
        } // if either are not null


        return $this;
    } // setLatestDeliveryDate()

    /**
     * Set the value of [is_business_order] column.
     * 
     * @param      int $v new value
     * @return   \AmazonIntegration\Model\AmazonOrdersVersion The current object (for fluent API support)
     */
    public function setIsBusinessOrder($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->is_business_order !== $v) {
            $this->is_business_order = $v;
            $this->modifiedColumns[AmazonOrdersVersionTableMap::IS_BUSINESS_ORDER] = true;
        }


        return $this;
    } // setIsBusinessOrder()

    /**
     * Set the value of [purchase_order_number] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonOrdersVersion The current object (for fluent API support)
     */
    public function setPurchaseOrderNumber($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->purchase_order_number !== $v) {
            $this->purchase_order_number = $v;
            $this->modifiedColumns[AmazonOrdersVersionTableMap::PURCHASE_ORDER_NUMBER] = true;
        }


        return $this;
    } // setPurchaseOrderNumber()

    /**
     * Set the value of [is_prime] column.
     * 
     * @param      int $v new value
     * @return   \AmazonIntegration\Model\AmazonOrdersVersion The current object (for fluent API support)
     */
    public function setIsPrime($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->is_prime !== $v) {
            $this->is_prime = $v;
            $this->modifiedColumns[AmazonOrdersVersionTableMap::IS_PRIME] = true;
        }


        return $this;
    } // setIsPrime()

    /**
     * Set the value of [is_premium_order] column.
     * 
     * @param      int $v new value
     * @return   \AmazonIntegration\Model\AmazonOrdersVersion The current object (for fluent API support)
     */
    public function setIsPremiumOrder($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->is_premium_order !== $v) {
            $this->is_premium_order = $v;
            $this->modifiedColumns[AmazonOrdersVersionTableMap::IS_PREMIUM_ORDER] = true;
        }


        return $this;
    } // setIsPremiumOrder()

    /**
     * Set the value of [replaced_order_id] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonOrdersVersion The current object (for fluent API support)
     */
    public function setReplacedOrderId($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->replaced_order_id !== $v) {
            $this->replaced_order_id = $v;
            $this->modifiedColumns[AmazonOrdersVersionTableMap::REPLACED_ORDER_ID] = true;
        }


        return $this;
    } // setReplacedOrderId()

    /**
     * Set the value of [is_replacement_order] column.
     * 
     * @param      int $v new value
     * @return   \AmazonIntegration\Model\AmazonOrdersVersion The current object (for fluent API support)
     */
    public function setIsReplacementOrder($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->is_replacement_order !== $v) {
            $this->is_replacement_order = $v;
            $this->modifiedColumns[AmazonOrdersVersionTableMap::IS_REPLACEMENT_ORDER] = true;
        }


        return $this;
    } // setIsReplacementOrder()

    /**
     * Set the value of [order_address_id] column.
     * 
     * @param      int $v new value
     * @return   \AmazonIntegration\Model\AmazonOrdersVersion The current object (for fluent API support)
     */
    public function setOrderAddressId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->order_address_id !== $v) {
            $this->order_address_id = $v;
            $this->modifiedColumns[AmazonOrdersVersionTableMap::ORDER_ADDRESS_ID] = true;
        }


        return $this;
    } // setOrderAddressId()

    /**
     * Set the value of [customer_id] column.
     * 
     * @param      int $v new value
     * @return   \AmazonIntegration\Model\AmazonOrdersVersion The current object (for fluent API support)
     */
    public function setCustomerId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->customer_id !== $v) {
            $this->customer_id = $v;
            $this->modifiedColumns[AmazonOrdersVersionTableMap::CUSTOMER_ID] = true;
        }


        return $this;
    } // setCustomerId()

    /**
     * Set the value of [order_id] column.
     * 
     * @param      int $v new value
     * @return   \AmazonIntegration\Model\AmazonOrdersVersion The current object (for fluent API support)
     */
    public function setOrderId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->order_id !== $v) {
            $this->order_id = $v;
            $this->modifiedColumns[AmazonOrdersVersionTableMap::ORDER_ID] = true;
        }


        return $this;
    } // setOrderId()

    /**
     * Sets the value of [created_at] column to a normalized version of the date/time value specified.
     * 
     * @param      mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return   \AmazonIntegration\Model\AmazonOrdersVersion The current object (for fluent API support)
     */
    public function setCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->created_at !== null || $dt !== null) {
            if ($dt !== $this->created_at) {
                $this->created_at = $dt;
                $this->modifiedColumns[AmazonOrdersVersionTableMap::CREATED_AT] = true;
            }
        } // if either are not null


        return $this;
    } // setCreatedAt()

    /**
     * Sets the value of [updated_at] column to a normalized version of the date/time value specified.
     * 
     * @param      mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return   \AmazonIntegration\Model\AmazonOrdersVersion The current object (for fluent API support)
     */
    public function setUpdatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->updated_at !== null || $dt !== null) {
            if ($dt !== $this->updated_at) {
                $this->updated_at = $dt;
                $this->modifiedColumns[AmazonOrdersVersionTableMap::UPDATED_AT] = true;
            }
        } // if either are not null


        return $this;
    } // setUpdatedAt()

    /**
     * Set the value of [version] column.
     * 
     * @param      int $v new value
     * @return   \AmazonIntegration\Model\AmazonOrdersVersion The current object (for fluent API support)
     */
    public function setVersion($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->version !== $v) {
            $this->version = $v;
            $this->modifiedColumns[AmazonOrdersVersionTableMap::VERSION] = true;
        }


        return $this;
    } // setVersion()

    /**
     * Sets the value of [version_created_at] column to a normalized version of the date/time value specified.
     * 
     * @param      mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return   \AmazonIntegration\Model\AmazonOrdersVersion The current object (for fluent API support)
     */
    public function setVersionCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->version_created_at !== null || $dt !== null) {
            if ($dt !== $this->version_created_at) {
                $this->version_created_at = $dt;
                $this->modifiedColumns[AmazonOrdersVersionTableMap::VERSION_CREATED_AT] = true;
            }
        } // if either are not null


        return $this;
    } // setVersionCreatedAt()

    /**
     * Set the value of [version_created_by] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonOrdersVersion The current object (for fluent API support)
     */
    public function setVersionCreatedBy($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->version_created_by !== $v) {
            $this->version_created_by = $v;
            $this->modifiedColumns[AmazonOrdersVersionTableMap::VERSION_CREATED_BY] = true;
        }


        return $this;
    } // setVersionCreatedBy()

    /**
     * Set the value of [customer_id_version] column.
     * 
     * @param      int $v new value
     * @return   \AmazonIntegration\Model\AmazonOrdersVersion The current object (for fluent API support)
     */
    public function setCustomerIdVersion($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->customer_id_version !== $v) {
            $this->customer_id_version = $v;
            $this->modifiedColumns[AmazonOrdersVersionTableMap::CUSTOMER_ID_VERSION] = true;
        }


        return $this;
    } // setCustomerIdVersion()

    /**
     * Set the value of [order_id_version] column.
     * 
     * @param      int $v new value
     * @return   \AmazonIntegration\Model\AmazonOrdersVersion The current object (for fluent API support)
     */
    public function setOrderIdVersion($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->order_id_version !== $v) {
            $this->order_id_version = $v;
            $this->modifiedColumns[AmazonOrdersVersionTableMap::ORDER_ID_VERSION] = true;
        }


        return $this;
    } // setOrderIdVersion()

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
            if ($this->order_total_amount !== '0.00') {
                return false;
            }

            if ($this->payment_execution_detail_total_amount !== '0.00') {
                return false;
            }

            if ($this->shipped_by_amazon_tfm !== 0) {
                return false;
            }

            if ($this->is_business_order !== 0) {
                return false;
            }

            if ($this->is_prime !== 0) {
                return false;
            }

            if ($this->is_premium_order !== 0) {
                return false;
            }

            if ($this->is_replacement_order !== 0) {
                return false;
            }

            if ($this->version !== 0) {
                return false;
            }

            if ($this->customer_id_version !== 0) {
                return false;
            }

            if ($this->order_id_version !== 0) {
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


            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : AmazonOrdersVersionTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : AmazonOrdersVersionTableMap::translateFieldName('SellerOrderId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->seller_order_id = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : AmazonOrdersVersionTableMap::translateFieldName('PurchaseDate', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->purchase_date = (null !== $col) ? PropelDateTime::newInstance($col, null, '\DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : AmazonOrdersVersionTableMap::translateFieldName('LastUpdateDate', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->last_update_date = (null !== $col) ? PropelDateTime::newInstance($col, null, '\DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : AmazonOrdersVersionTableMap::translateFieldName('OrderStatus', TableMap::TYPE_PHPNAME, $indexType)];
            $this->order_status = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : AmazonOrdersVersionTableMap::translateFieldName('FulfillmentChannel', TableMap::TYPE_PHPNAME, $indexType)];
            $this->fulfillment_channel = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : AmazonOrdersVersionTableMap::translateFieldName('SalesChannel', TableMap::TYPE_PHPNAME, $indexType)];
            $this->sales_channel = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : AmazonOrdersVersionTableMap::translateFieldName('OrderChannel', TableMap::TYPE_PHPNAME, $indexType)];
            $this->order_channel = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : AmazonOrdersVersionTableMap::translateFieldName('ShipServiceLevel', TableMap::TYPE_PHPNAME, $indexType)];
            $this->ship_service_level = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : AmazonOrdersVersionTableMap::translateFieldName('OrderTotalCurrencyCode', TableMap::TYPE_PHPNAME, $indexType)];
            $this->order_total_currency_code = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 10 + $startcol : AmazonOrdersVersionTableMap::translateFieldName('OrderTotalAmount', TableMap::TYPE_PHPNAME, $indexType)];
            $this->order_total_amount = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 11 + $startcol : AmazonOrdersVersionTableMap::translateFieldName('NumberOfItemsShipped', TableMap::TYPE_PHPNAME, $indexType)];
            $this->number_of_items_shipped = (null !== $col) ? (double) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 12 + $startcol : AmazonOrdersVersionTableMap::translateFieldName('NumberOfItemsUnshipped', TableMap::TYPE_PHPNAME, $indexType)];
            $this->number_of_items_unshipped = (null !== $col) ? (double) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 13 + $startcol : AmazonOrdersVersionTableMap::translateFieldName('PaymentExecutionDetailCurrencyCode', TableMap::TYPE_PHPNAME, $indexType)];
            $this->payment_execution_detail_currency_code = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 14 + $startcol : AmazonOrdersVersionTableMap::translateFieldName('PaymentExecutionDetailTotalAmount', TableMap::TYPE_PHPNAME, $indexType)];
            $this->payment_execution_detail_total_amount = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 15 + $startcol : AmazonOrdersVersionTableMap::translateFieldName('PaymentExecutionDetailPaymentMethod', TableMap::TYPE_PHPNAME, $indexType)];
            $this->payment_execution_detail_payment_method = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 16 + $startcol : AmazonOrdersVersionTableMap::translateFieldName('PaymentMethod', TableMap::TYPE_PHPNAME, $indexType)];
            $this->payment_method = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 17 + $startcol : AmazonOrdersVersionTableMap::translateFieldName('PaymentMethodDetail', TableMap::TYPE_PHPNAME, $indexType)];
            $this->payment_method_detail = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 18 + $startcol : AmazonOrdersVersionTableMap::translateFieldName('MarketplaceId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->marketplace_id = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 19 + $startcol : AmazonOrdersVersionTableMap::translateFieldName('BuyerCounty', TableMap::TYPE_PHPNAME, $indexType)];
            $this->buyer_county = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 20 + $startcol : AmazonOrdersVersionTableMap::translateFieldName('BuyerTaxInfoCompany', TableMap::TYPE_PHPNAME, $indexType)];
            $this->buyer_tax_info_company = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 21 + $startcol : AmazonOrdersVersionTableMap::translateFieldName('BuyerTaxInfoTaxingRegion', TableMap::TYPE_PHPNAME, $indexType)];
            $this->buyer_tax_info_taxing_region = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 22 + $startcol : AmazonOrdersVersionTableMap::translateFieldName('BuyerTaxInfoTaxName', TableMap::TYPE_PHPNAME, $indexType)];
            $this->buyer_tax_info_tax_name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 23 + $startcol : AmazonOrdersVersionTableMap::translateFieldName('BuyerTaxInfoTaxValue', TableMap::TYPE_PHPNAME, $indexType)];
            $this->buyer_tax_info_tax_value = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 24 + $startcol : AmazonOrdersVersionTableMap::translateFieldName('ShipmentServiceLevelCategory', TableMap::TYPE_PHPNAME, $indexType)];
            $this->shipment_service_level_category = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 25 + $startcol : AmazonOrdersVersionTableMap::translateFieldName('ShippedByAmazonTfm', TableMap::TYPE_PHPNAME, $indexType)];
            $this->shipped_by_amazon_tfm = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 26 + $startcol : AmazonOrdersVersionTableMap::translateFieldName('TfmShipmentStatus', TableMap::TYPE_PHPNAME, $indexType)];
            $this->tfm_shipment_status = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 27 + $startcol : AmazonOrdersVersionTableMap::translateFieldName('CbaDisplayableShippingLabel', TableMap::TYPE_PHPNAME, $indexType)];
            $this->cba_displayable_shipping_label = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 28 + $startcol : AmazonOrdersVersionTableMap::translateFieldName('OrderType', TableMap::TYPE_PHPNAME, $indexType)];
            $this->order_type = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 29 + $startcol : AmazonOrdersVersionTableMap::translateFieldName('EarliestShipDate', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->earliest_ship_date = (null !== $col) ? PropelDateTime::newInstance($col, null, '\DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 30 + $startcol : AmazonOrdersVersionTableMap::translateFieldName('LatestShipDate', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->latest_ship_date = (null !== $col) ? PropelDateTime::newInstance($col, null, '\DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 31 + $startcol : AmazonOrdersVersionTableMap::translateFieldName('EarliestDeliveryDate', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->earliest_delivery_date = (null !== $col) ? PropelDateTime::newInstance($col, null, '\DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 32 + $startcol : AmazonOrdersVersionTableMap::translateFieldName('LatestDeliveryDate', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->latest_delivery_date = (null !== $col) ? PropelDateTime::newInstance($col, null, '\DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 33 + $startcol : AmazonOrdersVersionTableMap::translateFieldName('IsBusinessOrder', TableMap::TYPE_PHPNAME, $indexType)];
            $this->is_business_order = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 34 + $startcol : AmazonOrdersVersionTableMap::translateFieldName('PurchaseOrderNumber', TableMap::TYPE_PHPNAME, $indexType)];
            $this->purchase_order_number = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 35 + $startcol : AmazonOrdersVersionTableMap::translateFieldName('IsPrime', TableMap::TYPE_PHPNAME, $indexType)];
            $this->is_prime = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 36 + $startcol : AmazonOrdersVersionTableMap::translateFieldName('IsPremiumOrder', TableMap::TYPE_PHPNAME, $indexType)];
            $this->is_premium_order = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 37 + $startcol : AmazonOrdersVersionTableMap::translateFieldName('ReplacedOrderId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->replaced_order_id = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 38 + $startcol : AmazonOrdersVersionTableMap::translateFieldName('IsReplacementOrder', TableMap::TYPE_PHPNAME, $indexType)];
            $this->is_replacement_order = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 39 + $startcol : AmazonOrdersVersionTableMap::translateFieldName('OrderAddressId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->order_address_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 40 + $startcol : AmazonOrdersVersionTableMap::translateFieldName('CustomerId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->customer_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 41 + $startcol : AmazonOrdersVersionTableMap::translateFieldName('OrderId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->order_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 42 + $startcol : AmazonOrdersVersionTableMap::translateFieldName('CreatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->created_at = (null !== $col) ? PropelDateTime::newInstance($col, null, '\DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 43 + $startcol : AmazonOrdersVersionTableMap::translateFieldName('UpdatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->updated_at = (null !== $col) ? PropelDateTime::newInstance($col, null, '\DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 44 + $startcol : AmazonOrdersVersionTableMap::translateFieldName('Version', TableMap::TYPE_PHPNAME, $indexType)];
            $this->version = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 45 + $startcol : AmazonOrdersVersionTableMap::translateFieldName('VersionCreatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->version_created_at = (null !== $col) ? PropelDateTime::newInstance($col, null, '\DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 46 + $startcol : AmazonOrdersVersionTableMap::translateFieldName('VersionCreatedBy', TableMap::TYPE_PHPNAME, $indexType)];
            $this->version_created_by = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 47 + $startcol : AmazonOrdersVersionTableMap::translateFieldName('CustomerIdVersion', TableMap::TYPE_PHPNAME, $indexType)];
            $this->customer_id_version = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 48 + $startcol : AmazonOrdersVersionTableMap::translateFieldName('OrderIdVersion', TableMap::TYPE_PHPNAME, $indexType)];
            $this->order_id_version = (null !== $col) ? (int) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 49; // 49 = AmazonOrdersVersionTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating \AmazonIntegration\Model\AmazonOrdersVersion object", 0, $e);
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
        if ($this->aAmazonOrders !== null && $this->id !== $this->aAmazonOrders->getId()) {
            $this->aAmazonOrders = null;
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
            $con = Propel::getServiceContainer()->getReadConnection(AmazonOrdersVersionTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildAmazonOrdersVersionQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aAmazonOrders = null;
        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see AmazonOrdersVersion::setDeleted()
     * @see AmazonOrdersVersion::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(AmazonOrdersVersionTableMap::DATABASE_NAME);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = ChildAmazonOrdersVersionQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(AmazonOrdersVersionTableMap::DATABASE_NAME);
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
                AmazonOrdersVersionTableMap::addInstanceToPool($this);
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
        if ($this->isColumnModified(AmazonOrdersVersionTableMap::ID)) {
            $modifiedColumns[':p' . $index++]  = 'ID';
        }
        if ($this->isColumnModified(AmazonOrdersVersionTableMap::SELLER_ORDER_ID)) {
            $modifiedColumns[':p' . $index++]  = 'SELLER_ORDER_ID';
        }
        if ($this->isColumnModified(AmazonOrdersVersionTableMap::PURCHASE_DATE)) {
            $modifiedColumns[':p' . $index++]  = 'PURCHASE_DATE';
        }
        if ($this->isColumnModified(AmazonOrdersVersionTableMap::LAST_UPDATE_DATE)) {
            $modifiedColumns[':p' . $index++]  = 'LAST_UPDATE_DATE';
        }
        if ($this->isColumnModified(AmazonOrdersVersionTableMap::ORDER_STATUS)) {
            $modifiedColumns[':p' . $index++]  = 'ORDER_STATUS';
        }
        if ($this->isColumnModified(AmazonOrdersVersionTableMap::FULFILLMENT_CHANNEL)) {
            $modifiedColumns[':p' . $index++]  = 'FULFILLMENT_CHANNEL';
        }
        if ($this->isColumnModified(AmazonOrdersVersionTableMap::SALES_CHANNEL)) {
            $modifiedColumns[':p' . $index++]  = 'SALES_CHANNEL';
        }
        if ($this->isColumnModified(AmazonOrdersVersionTableMap::ORDER_CHANNEL)) {
            $modifiedColumns[':p' . $index++]  = 'ORDER_CHANNEL';
        }
        if ($this->isColumnModified(AmazonOrdersVersionTableMap::SHIP_SERVICE_LEVEL)) {
            $modifiedColumns[':p' . $index++]  = 'SHIP_SERVICE_LEVEL';
        }
        if ($this->isColumnModified(AmazonOrdersVersionTableMap::ORDER_TOTAL_CURRENCY_CODE)) {
            $modifiedColumns[':p' . $index++]  = 'ORDER_TOTAL_CURRENCY_CODE';
        }
        if ($this->isColumnModified(AmazonOrdersVersionTableMap::ORDER_TOTAL_AMOUNT)) {
            $modifiedColumns[':p' . $index++]  = 'ORDER_TOTAL_AMOUNT';
        }
        if ($this->isColumnModified(AmazonOrdersVersionTableMap::NUMBER_OF_ITEMS_SHIPPED)) {
            $modifiedColumns[':p' . $index++]  = 'NUMBER_OF_ITEMS_SHIPPED';
        }
        if ($this->isColumnModified(AmazonOrdersVersionTableMap::NUMBER_OF_ITEMS_UNSHIPPED)) {
            $modifiedColumns[':p' . $index++]  = 'NUMBER_OF_ITEMS_UNSHIPPED';
        }
        if ($this->isColumnModified(AmazonOrdersVersionTableMap::PAYMENT_EXECUTION_DETAIL_CURRENCY_CODE)) {
            $modifiedColumns[':p' . $index++]  = 'PAYMENT_EXECUTION_DETAIL_CURRENCY_CODE';
        }
        if ($this->isColumnModified(AmazonOrdersVersionTableMap::PAYMENT_EXECUTION_DETAIL_TOTAL_AMOUNT)) {
            $modifiedColumns[':p' . $index++]  = 'PAYMENT_EXECUTION_DETAIL_TOTAL_AMOUNT';
        }
        if ($this->isColumnModified(AmazonOrdersVersionTableMap::PAYMENT_EXECUTION_DETAIL_PAYMENT_METHOD)) {
            $modifiedColumns[':p' . $index++]  = 'PAYMENT_EXECUTION_DETAIL_PAYMENT_METHOD';
        }
        if ($this->isColumnModified(AmazonOrdersVersionTableMap::PAYMENT_METHOD)) {
            $modifiedColumns[':p' . $index++]  = 'PAYMENT_METHOD';
        }
        if ($this->isColumnModified(AmazonOrdersVersionTableMap::PAYMENT_METHOD_DETAIL)) {
            $modifiedColumns[':p' . $index++]  = 'PAYMENT_METHOD_DETAIL';
        }
        if ($this->isColumnModified(AmazonOrdersVersionTableMap::MARKETPLACE_ID)) {
            $modifiedColumns[':p' . $index++]  = 'MARKETPLACE_ID';
        }
        if ($this->isColumnModified(AmazonOrdersVersionTableMap::BUYER_COUNTY)) {
            $modifiedColumns[':p' . $index++]  = 'BUYER_COUNTY';
        }
        if ($this->isColumnModified(AmazonOrdersVersionTableMap::BUYER_TAX_INFO_COMPANY)) {
            $modifiedColumns[':p' . $index++]  = 'BUYER_TAX_INFO_COMPANY';
        }
        if ($this->isColumnModified(AmazonOrdersVersionTableMap::BUYER_TAX_INFO_TAXING_REGION)) {
            $modifiedColumns[':p' . $index++]  = 'BUYER_TAX_INFO_TAXING_REGION';
        }
        if ($this->isColumnModified(AmazonOrdersVersionTableMap::BUYER_TAX_INFO_TAX_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'BUYER_TAX_INFO_TAX_NAME';
        }
        if ($this->isColumnModified(AmazonOrdersVersionTableMap::BUYER_TAX_INFO_TAX_VALUE)) {
            $modifiedColumns[':p' . $index++]  = 'BUYER_TAX_INFO_TAX_VALUE';
        }
        if ($this->isColumnModified(AmazonOrdersVersionTableMap::SHIPMENT_SERVICE_LEVEL_CATEGORY)) {
            $modifiedColumns[':p' . $index++]  = 'SHIPMENT_SERVICE_LEVEL_CATEGORY';
        }
        if ($this->isColumnModified(AmazonOrdersVersionTableMap::SHIPPED_BY_AMAZON_TFM)) {
            $modifiedColumns[':p' . $index++]  = 'SHIPPED_BY_AMAZON_TFM';
        }
        if ($this->isColumnModified(AmazonOrdersVersionTableMap::TFM_SHIPMENT_STATUS)) {
            $modifiedColumns[':p' . $index++]  = 'TFM_SHIPMENT_STATUS';
        }
        if ($this->isColumnModified(AmazonOrdersVersionTableMap::CBA_DISPLAYABLE_SHIPPING_LABEL)) {
            $modifiedColumns[':p' . $index++]  = 'CBA_DISPLAYABLE_SHIPPING_LABEL';
        }
        if ($this->isColumnModified(AmazonOrdersVersionTableMap::ORDER_TYPE)) {
            $modifiedColumns[':p' . $index++]  = 'ORDER_TYPE';
        }
        if ($this->isColumnModified(AmazonOrdersVersionTableMap::EARLIEST_SHIP_DATE)) {
            $modifiedColumns[':p' . $index++]  = 'EARLIEST_SHIP_DATE';
        }
        if ($this->isColumnModified(AmazonOrdersVersionTableMap::LATEST_SHIP_DATE)) {
            $modifiedColumns[':p' . $index++]  = 'LATEST_SHIP_DATE';
        }
        if ($this->isColumnModified(AmazonOrdersVersionTableMap::EARLIEST_DELIVERY_DATE)) {
            $modifiedColumns[':p' . $index++]  = 'EARLIEST_DELIVERY_DATE';
        }
        if ($this->isColumnModified(AmazonOrdersVersionTableMap::LATEST_DELIVERY_DATE)) {
            $modifiedColumns[':p' . $index++]  = 'LATEST_DELIVERY_DATE';
        }
        if ($this->isColumnModified(AmazonOrdersVersionTableMap::IS_BUSINESS_ORDER)) {
            $modifiedColumns[':p' . $index++]  = 'IS_BUSINESS_ORDER';
        }
        if ($this->isColumnModified(AmazonOrdersVersionTableMap::PURCHASE_ORDER_NUMBER)) {
            $modifiedColumns[':p' . $index++]  = 'PURCHASE_ORDER_NUMBER';
        }
        if ($this->isColumnModified(AmazonOrdersVersionTableMap::IS_PRIME)) {
            $modifiedColumns[':p' . $index++]  = 'IS_PRIME';
        }
        if ($this->isColumnModified(AmazonOrdersVersionTableMap::IS_PREMIUM_ORDER)) {
            $modifiedColumns[':p' . $index++]  = 'IS_PREMIUM_ORDER';
        }
        if ($this->isColumnModified(AmazonOrdersVersionTableMap::REPLACED_ORDER_ID)) {
            $modifiedColumns[':p' . $index++]  = 'REPLACED_ORDER_ID';
        }
        if ($this->isColumnModified(AmazonOrdersVersionTableMap::IS_REPLACEMENT_ORDER)) {
            $modifiedColumns[':p' . $index++]  = 'IS_REPLACEMENT_ORDER';
        }
        if ($this->isColumnModified(AmazonOrdersVersionTableMap::ORDER_ADDRESS_ID)) {
            $modifiedColumns[':p' . $index++]  = 'ORDER_ADDRESS_ID';
        }
        if ($this->isColumnModified(AmazonOrdersVersionTableMap::CUSTOMER_ID)) {
            $modifiedColumns[':p' . $index++]  = 'CUSTOMER_ID';
        }
        if ($this->isColumnModified(AmazonOrdersVersionTableMap::ORDER_ID)) {
            $modifiedColumns[':p' . $index++]  = 'ORDER_ID';
        }
        if ($this->isColumnModified(AmazonOrdersVersionTableMap::CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'CREATED_AT';
        }
        if ($this->isColumnModified(AmazonOrdersVersionTableMap::UPDATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'UPDATED_AT';
        }
        if ($this->isColumnModified(AmazonOrdersVersionTableMap::VERSION)) {
            $modifiedColumns[':p' . $index++]  = 'VERSION';
        }
        if ($this->isColumnModified(AmazonOrdersVersionTableMap::VERSION_CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'VERSION_CREATED_AT';
        }
        if ($this->isColumnModified(AmazonOrdersVersionTableMap::VERSION_CREATED_BY)) {
            $modifiedColumns[':p' . $index++]  = 'VERSION_CREATED_BY';
        }
        if ($this->isColumnModified(AmazonOrdersVersionTableMap::CUSTOMER_ID_VERSION)) {
            $modifiedColumns[':p' . $index++]  = 'CUSTOMER_ID_VERSION';
        }
        if ($this->isColumnModified(AmazonOrdersVersionTableMap::ORDER_ID_VERSION)) {
            $modifiedColumns[':p' . $index++]  = 'ORDER_ID_VERSION';
        }

        $sql = sprintf(
            'INSERT INTO amazon_orders_version (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'ID':                        
                        $stmt->bindValue($identifier, $this->id, PDO::PARAM_STR);
                        break;
                    case 'SELLER_ORDER_ID':                        
                        $stmt->bindValue($identifier, $this->seller_order_id, PDO::PARAM_STR);
                        break;
                    case 'PURCHASE_DATE':                        
                        $stmt->bindValue($identifier, $this->purchase_date ? $this->purchase_date->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                    case 'LAST_UPDATE_DATE':                        
                        $stmt->bindValue($identifier, $this->last_update_date ? $this->last_update_date->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                    case 'ORDER_STATUS':                        
                        $stmt->bindValue($identifier, $this->order_status, PDO::PARAM_STR);
                        break;
                    case 'FULFILLMENT_CHANNEL':                        
                        $stmt->bindValue($identifier, $this->fulfillment_channel, PDO::PARAM_STR);
                        break;
                    case 'SALES_CHANNEL':                        
                        $stmt->bindValue($identifier, $this->sales_channel, PDO::PARAM_STR);
                        break;
                    case 'ORDER_CHANNEL':                        
                        $stmt->bindValue($identifier, $this->order_channel, PDO::PARAM_STR);
                        break;
                    case 'SHIP_SERVICE_LEVEL':                        
                        $stmt->bindValue($identifier, $this->ship_service_level, PDO::PARAM_STR);
                        break;
                    case 'ORDER_TOTAL_CURRENCY_CODE':                        
                        $stmt->bindValue($identifier, $this->order_total_currency_code, PDO::PARAM_STR);
                        break;
                    case 'ORDER_TOTAL_AMOUNT':                        
                        $stmt->bindValue($identifier, $this->order_total_amount, PDO::PARAM_STR);
                        break;
                    case 'NUMBER_OF_ITEMS_SHIPPED':                        
                        $stmt->bindValue($identifier, $this->number_of_items_shipped, PDO::PARAM_STR);
                        break;
                    case 'NUMBER_OF_ITEMS_UNSHIPPED':                        
                        $stmt->bindValue($identifier, $this->number_of_items_unshipped, PDO::PARAM_STR);
                        break;
                    case 'PAYMENT_EXECUTION_DETAIL_CURRENCY_CODE':                        
                        $stmt->bindValue($identifier, $this->payment_execution_detail_currency_code, PDO::PARAM_STR);
                        break;
                    case 'PAYMENT_EXECUTION_DETAIL_TOTAL_AMOUNT':                        
                        $stmt->bindValue($identifier, $this->payment_execution_detail_total_amount, PDO::PARAM_STR);
                        break;
                    case 'PAYMENT_EXECUTION_DETAIL_PAYMENT_METHOD':                        
                        $stmt->bindValue($identifier, $this->payment_execution_detail_payment_method, PDO::PARAM_STR);
                        break;
                    case 'PAYMENT_METHOD':                        
                        $stmt->bindValue($identifier, $this->payment_method, PDO::PARAM_STR);
                        break;
                    case 'PAYMENT_METHOD_DETAIL':                        
                        $stmt->bindValue($identifier, $this->payment_method_detail, PDO::PARAM_STR);
                        break;
                    case 'MARKETPLACE_ID':                        
                        $stmt->bindValue($identifier, $this->marketplace_id, PDO::PARAM_STR);
                        break;
                    case 'BUYER_COUNTY':                        
                        $stmt->bindValue($identifier, $this->buyer_county, PDO::PARAM_STR);
                        break;
                    case 'BUYER_TAX_INFO_COMPANY':                        
                        $stmt->bindValue($identifier, $this->buyer_tax_info_company, PDO::PARAM_STR);
                        break;
                    case 'BUYER_TAX_INFO_TAXING_REGION':                        
                        $stmt->bindValue($identifier, $this->buyer_tax_info_taxing_region, PDO::PARAM_STR);
                        break;
                    case 'BUYER_TAX_INFO_TAX_NAME':                        
                        $stmt->bindValue($identifier, $this->buyer_tax_info_tax_name, PDO::PARAM_STR);
                        break;
                    case 'BUYER_TAX_INFO_TAX_VALUE':                        
                        $stmt->bindValue($identifier, $this->buyer_tax_info_tax_value, PDO::PARAM_STR);
                        break;
                    case 'SHIPMENT_SERVICE_LEVEL_CATEGORY':                        
                        $stmt->bindValue($identifier, $this->shipment_service_level_category, PDO::PARAM_STR);
                        break;
                    case 'SHIPPED_BY_AMAZON_TFM':                        
                        $stmt->bindValue($identifier, $this->shipped_by_amazon_tfm, PDO::PARAM_INT);
                        break;
                    case 'TFM_SHIPMENT_STATUS':                        
                        $stmt->bindValue($identifier, $this->tfm_shipment_status, PDO::PARAM_STR);
                        break;
                    case 'CBA_DISPLAYABLE_SHIPPING_LABEL':                        
                        $stmt->bindValue($identifier, $this->cba_displayable_shipping_label, PDO::PARAM_STR);
                        break;
                    case 'ORDER_TYPE':                        
                        $stmt->bindValue($identifier, $this->order_type, PDO::PARAM_STR);
                        break;
                    case 'EARLIEST_SHIP_DATE':                        
                        $stmt->bindValue($identifier, $this->earliest_ship_date ? $this->earliest_ship_date->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                    case 'LATEST_SHIP_DATE':                        
                        $stmt->bindValue($identifier, $this->latest_ship_date ? $this->latest_ship_date->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                    case 'EARLIEST_DELIVERY_DATE':                        
                        $stmt->bindValue($identifier, $this->earliest_delivery_date ? $this->earliest_delivery_date->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                    case 'LATEST_DELIVERY_DATE':                        
                        $stmt->bindValue($identifier, $this->latest_delivery_date ? $this->latest_delivery_date->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                    case 'IS_BUSINESS_ORDER':                        
                        $stmt->bindValue($identifier, $this->is_business_order, PDO::PARAM_INT);
                        break;
                    case 'PURCHASE_ORDER_NUMBER':                        
                        $stmt->bindValue($identifier, $this->purchase_order_number, PDO::PARAM_STR);
                        break;
                    case 'IS_PRIME':                        
                        $stmt->bindValue($identifier, $this->is_prime, PDO::PARAM_INT);
                        break;
                    case 'IS_PREMIUM_ORDER':                        
                        $stmt->bindValue($identifier, $this->is_premium_order, PDO::PARAM_INT);
                        break;
                    case 'REPLACED_ORDER_ID':                        
                        $stmt->bindValue($identifier, $this->replaced_order_id, PDO::PARAM_STR);
                        break;
                    case 'IS_REPLACEMENT_ORDER':                        
                        $stmt->bindValue($identifier, $this->is_replacement_order, PDO::PARAM_INT);
                        break;
                    case 'ORDER_ADDRESS_ID':                        
                        $stmt->bindValue($identifier, $this->order_address_id, PDO::PARAM_INT);
                        break;
                    case 'CUSTOMER_ID':                        
                        $stmt->bindValue($identifier, $this->customer_id, PDO::PARAM_INT);
                        break;
                    case 'ORDER_ID':                        
                        $stmt->bindValue($identifier, $this->order_id, PDO::PARAM_INT);
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
                    case 'CUSTOMER_ID_VERSION':                        
                        $stmt->bindValue($identifier, $this->customer_id_version, PDO::PARAM_INT);
                        break;
                    case 'ORDER_ID_VERSION':                        
                        $stmt->bindValue($identifier, $this->order_id_version, PDO::PARAM_INT);
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
        $pos = AmazonOrdersVersionTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getId();
                break;
            case 1:
                return $this->getSellerOrderId();
                break;
            case 2:
                return $this->getPurchaseDate();
                break;
            case 3:
                return $this->getLastUpdateDate();
                break;
            case 4:
                return $this->getOrderStatus();
                break;
            case 5:
                return $this->getFulfillmentChannel();
                break;
            case 6:
                return $this->getSalesChannel();
                break;
            case 7:
                return $this->getOrderChannel();
                break;
            case 8:
                return $this->getShipServiceLevel();
                break;
            case 9:
                return $this->getOrderTotalCurrencyCode();
                break;
            case 10:
                return $this->getOrderTotalAmount();
                break;
            case 11:
                return $this->getNumberOfItemsShipped();
                break;
            case 12:
                return $this->getNumberOfItemsUnshipped();
                break;
            case 13:
                return $this->getPaymentExecutionDetailCurrencyCode();
                break;
            case 14:
                return $this->getPaymentExecutionDetailTotalAmount();
                break;
            case 15:
                return $this->getPaymentExecutionDetailPaymentMethod();
                break;
            case 16:
                return $this->getPaymentMethod();
                break;
            case 17:
                return $this->getPaymentMethodDetail();
                break;
            case 18:
                return $this->getMarketplaceId();
                break;
            case 19:
                return $this->getBuyerCounty();
                break;
            case 20:
                return $this->getBuyerTaxInfoCompany();
                break;
            case 21:
                return $this->getBuyerTaxInfoTaxingRegion();
                break;
            case 22:
                return $this->getBuyerTaxInfoTaxName();
                break;
            case 23:
                return $this->getBuyerTaxInfoTaxValue();
                break;
            case 24:
                return $this->getShipmentServiceLevelCategory();
                break;
            case 25:
                return $this->getShippedByAmazonTfm();
                break;
            case 26:
                return $this->getTfmShipmentStatus();
                break;
            case 27:
                return $this->getCbaDisplayableShippingLabel();
                break;
            case 28:
                return $this->getOrderType();
                break;
            case 29:
                return $this->getEarliestShipDate();
                break;
            case 30:
                return $this->getLatestShipDate();
                break;
            case 31:
                return $this->getEarliestDeliveryDate();
                break;
            case 32:
                return $this->getLatestDeliveryDate();
                break;
            case 33:
                return $this->getIsBusinessOrder();
                break;
            case 34:
                return $this->getPurchaseOrderNumber();
                break;
            case 35:
                return $this->getIsPrime();
                break;
            case 36:
                return $this->getIsPremiumOrder();
                break;
            case 37:
                return $this->getReplacedOrderId();
                break;
            case 38:
                return $this->getIsReplacementOrder();
                break;
            case 39:
                return $this->getOrderAddressId();
                break;
            case 40:
                return $this->getCustomerId();
                break;
            case 41:
                return $this->getOrderId();
                break;
            case 42:
                return $this->getCreatedAt();
                break;
            case 43:
                return $this->getUpdatedAt();
                break;
            case 44:
                return $this->getVersion();
                break;
            case 45:
                return $this->getVersionCreatedAt();
                break;
            case 46:
                return $this->getVersionCreatedBy();
                break;
            case 47:
                return $this->getCustomerIdVersion();
                break;
            case 48:
                return $this->getOrderIdVersion();
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
        if (isset($alreadyDumpedObjects['AmazonOrdersVersion'][serialize($this->getPrimaryKey())])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['AmazonOrdersVersion'][serialize($this->getPrimaryKey())] = true;
        $keys = AmazonOrdersVersionTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getSellerOrderId(),
            $keys[2] => $this->getPurchaseDate(),
            $keys[3] => $this->getLastUpdateDate(),
            $keys[4] => $this->getOrderStatus(),
            $keys[5] => $this->getFulfillmentChannel(),
            $keys[6] => $this->getSalesChannel(),
            $keys[7] => $this->getOrderChannel(),
            $keys[8] => $this->getShipServiceLevel(),
            $keys[9] => $this->getOrderTotalCurrencyCode(),
            $keys[10] => $this->getOrderTotalAmount(),
            $keys[11] => $this->getNumberOfItemsShipped(),
            $keys[12] => $this->getNumberOfItemsUnshipped(),
            $keys[13] => $this->getPaymentExecutionDetailCurrencyCode(),
            $keys[14] => $this->getPaymentExecutionDetailTotalAmount(),
            $keys[15] => $this->getPaymentExecutionDetailPaymentMethod(),
            $keys[16] => $this->getPaymentMethod(),
            $keys[17] => $this->getPaymentMethodDetail(),
            $keys[18] => $this->getMarketplaceId(),
            $keys[19] => $this->getBuyerCounty(),
            $keys[20] => $this->getBuyerTaxInfoCompany(),
            $keys[21] => $this->getBuyerTaxInfoTaxingRegion(),
            $keys[22] => $this->getBuyerTaxInfoTaxName(),
            $keys[23] => $this->getBuyerTaxInfoTaxValue(),
            $keys[24] => $this->getShipmentServiceLevelCategory(),
            $keys[25] => $this->getShippedByAmazonTfm(),
            $keys[26] => $this->getTfmShipmentStatus(),
            $keys[27] => $this->getCbaDisplayableShippingLabel(),
            $keys[28] => $this->getOrderType(),
            $keys[29] => $this->getEarliestShipDate(),
            $keys[30] => $this->getLatestShipDate(),
            $keys[31] => $this->getEarliestDeliveryDate(),
            $keys[32] => $this->getLatestDeliveryDate(),
            $keys[33] => $this->getIsBusinessOrder(),
            $keys[34] => $this->getPurchaseOrderNumber(),
            $keys[35] => $this->getIsPrime(),
            $keys[36] => $this->getIsPremiumOrder(),
            $keys[37] => $this->getReplacedOrderId(),
            $keys[38] => $this->getIsReplacementOrder(),
            $keys[39] => $this->getOrderAddressId(),
            $keys[40] => $this->getCustomerId(),
            $keys[41] => $this->getOrderId(),
            $keys[42] => $this->getCreatedAt(),
            $keys[43] => $this->getUpdatedAt(),
            $keys[44] => $this->getVersion(),
            $keys[45] => $this->getVersionCreatedAt(),
            $keys[46] => $this->getVersionCreatedBy(),
            $keys[47] => $this->getCustomerIdVersion(),
            $keys[48] => $this->getOrderIdVersion(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }
        
        if ($includeForeignObjects) {
            if (null !== $this->aAmazonOrders) {
                $result['AmazonOrders'] = $this->aAmazonOrders->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
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
        $pos = AmazonOrdersVersionTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

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
                $this->setId($value);
                break;
            case 1:
                $this->setSellerOrderId($value);
                break;
            case 2:
                $this->setPurchaseDate($value);
                break;
            case 3:
                $this->setLastUpdateDate($value);
                break;
            case 4:
                $this->setOrderStatus($value);
                break;
            case 5:
                $this->setFulfillmentChannel($value);
                break;
            case 6:
                $this->setSalesChannel($value);
                break;
            case 7:
                $this->setOrderChannel($value);
                break;
            case 8:
                $this->setShipServiceLevel($value);
                break;
            case 9:
                $this->setOrderTotalCurrencyCode($value);
                break;
            case 10:
                $this->setOrderTotalAmount($value);
                break;
            case 11:
                $this->setNumberOfItemsShipped($value);
                break;
            case 12:
                $this->setNumberOfItemsUnshipped($value);
                break;
            case 13:
                $this->setPaymentExecutionDetailCurrencyCode($value);
                break;
            case 14:
                $this->setPaymentExecutionDetailTotalAmount($value);
                break;
            case 15:
                $this->setPaymentExecutionDetailPaymentMethod($value);
                break;
            case 16:
                $this->setPaymentMethod($value);
                break;
            case 17:
                $this->setPaymentMethodDetail($value);
                break;
            case 18:
                $this->setMarketplaceId($value);
                break;
            case 19:
                $this->setBuyerCounty($value);
                break;
            case 20:
                $this->setBuyerTaxInfoCompany($value);
                break;
            case 21:
                $this->setBuyerTaxInfoTaxingRegion($value);
                break;
            case 22:
                $this->setBuyerTaxInfoTaxName($value);
                break;
            case 23:
                $this->setBuyerTaxInfoTaxValue($value);
                break;
            case 24:
                $this->setShipmentServiceLevelCategory($value);
                break;
            case 25:
                $this->setShippedByAmazonTfm($value);
                break;
            case 26:
                $this->setTfmShipmentStatus($value);
                break;
            case 27:
                $this->setCbaDisplayableShippingLabel($value);
                break;
            case 28:
                $this->setOrderType($value);
                break;
            case 29:
                $this->setEarliestShipDate($value);
                break;
            case 30:
                $this->setLatestShipDate($value);
                break;
            case 31:
                $this->setEarliestDeliveryDate($value);
                break;
            case 32:
                $this->setLatestDeliveryDate($value);
                break;
            case 33:
                $this->setIsBusinessOrder($value);
                break;
            case 34:
                $this->setPurchaseOrderNumber($value);
                break;
            case 35:
                $this->setIsPrime($value);
                break;
            case 36:
                $this->setIsPremiumOrder($value);
                break;
            case 37:
                $this->setReplacedOrderId($value);
                break;
            case 38:
                $this->setIsReplacementOrder($value);
                break;
            case 39:
                $this->setOrderAddressId($value);
                break;
            case 40:
                $this->setCustomerId($value);
                break;
            case 41:
                $this->setOrderId($value);
                break;
            case 42:
                $this->setCreatedAt($value);
                break;
            case 43:
                $this->setUpdatedAt($value);
                break;
            case 44:
                $this->setVersion($value);
                break;
            case 45:
                $this->setVersionCreatedAt($value);
                break;
            case 46:
                $this->setVersionCreatedBy($value);
                break;
            case 47:
                $this->setCustomerIdVersion($value);
                break;
            case 48:
                $this->setOrderIdVersion($value);
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
        $keys = AmazonOrdersVersionTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setSellerOrderId($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setPurchaseDate($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setLastUpdateDate($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setOrderStatus($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setFulfillmentChannel($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setSalesChannel($arr[$keys[6]]);
        if (array_key_exists($keys[7], $arr)) $this->setOrderChannel($arr[$keys[7]]);
        if (array_key_exists($keys[8], $arr)) $this->setShipServiceLevel($arr[$keys[8]]);
        if (array_key_exists($keys[9], $arr)) $this->setOrderTotalCurrencyCode($arr[$keys[9]]);
        if (array_key_exists($keys[10], $arr)) $this->setOrderTotalAmount($arr[$keys[10]]);
        if (array_key_exists($keys[11], $arr)) $this->setNumberOfItemsShipped($arr[$keys[11]]);
        if (array_key_exists($keys[12], $arr)) $this->setNumberOfItemsUnshipped($arr[$keys[12]]);
        if (array_key_exists($keys[13], $arr)) $this->setPaymentExecutionDetailCurrencyCode($arr[$keys[13]]);
        if (array_key_exists($keys[14], $arr)) $this->setPaymentExecutionDetailTotalAmount($arr[$keys[14]]);
        if (array_key_exists($keys[15], $arr)) $this->setPaymentExecutionDetailPaymentMethod($arr[$keys[15]]);
        if (array_key_exists($keys[16], $arr)) $this->setPaymentMethod($arr[$keys[16]]);
        if (array_key_exists($keys[17], $arr)) $this->setPaymentMethodDetail($arr[$keys[17]]);
        if (array_key_exists($keys[18], $arr)) $this->setMarketplaceId($arr[$keys[18]]);
        if (array_key_exists($keys[19], $arr)) $this->setBuyerCounty($arr[$keys[19]]);
        if (array_key_exists($keys[20], $arr)) $this->setBuyerTaxInfoCompany($arr[$keys[20]]);
        if (array_key_exists($keys[21], $arr)) $this->setBuyerTaxInfoTaxingRegion($arr[$keys[21]]);
        if (array_key_exists($keys[22], $arr)) $this->setBuyerTaxInfoTaxName($arr[$keys[22]]);
        if (array_key_exists($keys[23], $arr)) $this->setBuyerTaxInfoTaxValue($arr[$keys[23]]);
        if (array_key_exists($keys[24], $arr)) $this->setShipmentServiceLevelCategory($arr[$keys[24]]);
        if (array_key_exists($keys[25], $arr)) $this->setShippedByAmazonTfm($arr[$keys[25]]);
        if (array_key_exists($keys[26], $arr)) $this->setTfmShipmentStatus($arr[$keys[26]]);
        if (array_key_exists($keys[27], $arr)) $this->setCbaDisplayableShippingLabel($arr[$keys[27]]);
        if (array_key_exists($keys[28], $arr)) $this->setOrderType($arr[$keys[28]]);
        if (array_key_exists($keys[29], $arr)) $this->setEarliestShipDate($arr[$keys[29]]);
        if (array_key_exists($keys[30], $arr)) $this->setLatestShipDate($arr[$keys[30]]);
        if (array_key_exists($keys[31], $arr)) $this->setEarliestDeliveryDate($arr[$keys[31]]);
        if (array_key_exists($keys[32], $arr)) $this->setLatestDeliveryDate($arr[$keys[32]]);
        if (array_key_exists($keys[33], $arr)) $this->setIsBusinessOrder($arr[$keys[33]]);
        if (array_key_exists($keys[34], $arr)) $this->setPurchaseOrderNumber($arr[$keys[34]]);
        if (array_key_exists($keys[35], $arr)) $this->setIsPrime($arr[$keys[35]]);
        if (array_key_exists($keys[36], $arr)) $this->setIsPremiumOrder($arr[$keys[36]]);
        if (array_key_exists($keys[37], $arr)) $this->setReplacedOrderId($arr[$keys[37]]);
        if (array_key_exists($keys[38], $arr)) $this->setIsReplacementOrder($arr[$keys[38]]);
        if (array_key_exists($keys[39], $arr)) $this->setOrderAddressId($arr[$keys[39]]);
        if (array_key_exists($keys[40], $arr)) $this->setCustomerId($arr[$keys[40]]);
        if (array_key_exists($keys[41], $arr)) $this->setOrderId($arr[$keys[41]]);
        if (array_key_exists($keys[42], $arr)) $this->setCreatedAt($arr[$keys[42]]);
        if (array_key_exists($keys[43], $arr)) $this->setUpdatedAt($arr[$keys[43]]);
        if (array_key_exists($keys[44], $arr)) $this->setVersion($arr[$keys[44]]);
        if (array_key_exists($keys[45], $arr)) $this->setVersionCreatedAt($arr[$keys[45]]);
        if (array_key_exists($keys[46], $arr)) $this->setVersionCreatedBy($arr[$keys[46]]);
        if (array_key_exists($keys[47], $arr)) $this->setCustomerIdVersion($arr[$keys[47]]);
        if (array_key_exists($keys[48], $arr)) $this->setOrderIdVersion($arr[$keys[48]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(AmazonOrdersVersionTableMap::DATABASE_NAME);

        if ($this->isColumnModified(AmazonOrdersVersionTableMap::ID)) $criteria->add(AmazonOrdersVersionTableMap::ID, $this->id);
        if ($this->isColumnModified(AmazonOrdersVersionTableMap::SELLER_ORDER_ID)) $criteria->add(AmazonOrdersVersionTableMap::SELLER_ORDER_ID, $this->seller_order_id);
        if ($this->isColumnModified(AmazonOrdersVersionTableMap::PURCHASE_DATE)) $criteria->add(AmazonOrdersVersionTableMap::PURCHASE_DATE, $this->purchase_date);
        if ($this->isColumnModified(AmazonOrdersVersionTableMap::LAST_UPDATE_DATE)) $criteria->add(AmazonOrdersVersionTableMap::LAST_UPDATE_DATE, $this->last_update_date);
        if ($this->isColumnModified(AmazonOrdersVersionTableMap::ORDER_STATUS)) $criteria->add(AmazonOrdersVersionTableMap::ORDER_STATUS, $this->order_status);
        if ($this->isColumnModified(AmazonOrdersVersionTableMap::FULFILLMENT_CHANNEL)) $criteria->add(AmazonOrdersVersionTableMap::FULFILLMENT_CHANNEL, $this->fulfillment_channel);
        if ($this->isColumnModified(AmazonOrdersVersionTableMap::SALES_CHANNEL)) $criteria->add(AmazonOrdersVersionTableMap::SALES_CHANNEL, $this->sales_channel);
        if ($this->isColumnModified(AmazonOrdersVersionTableMap::ORDER_CHANNEL)) $criteria->add(AmazonOrdersVersionTableMap::ORDER_CHANNEL, $this->order_channel);
        if ($this->isColumnModified(AmazonOrdersVersionTableMap::SHIP_SERVICE_LEVEL)) $criteria->add(AmazonOrdersVersionTableMap::SHIP_SERVICE_LEVEL, $this->ship_service_level);
        if ($this->isColumnModified(AmazonOrdersVersionTableMap::ORDER_TOTAL_CURRENCY_CODE)) $criteria->add(AmazonOrdersVersionTableMap::ORDER_TOTAL_CURRENCY_CODE, $this->order_total_currency_code);
        if ($this->isColumnModified(AmazonOrdersVersionTableMap::ORDER_TOTAL_AMOUNT)) $criteria->add(AmazonOrdersVersionTableMap::ORDER_TOTAL_AMOUNT, $this->order_total_amount);
        if ($this->isColumnModified(AmazonOrdersVersionTableMap::NUMBER_OF_ITEMS_SHIPPED)) $criteria->add(AmazonOrdersVersionTableMap::NUMBER_OF_ITEMS_SHIPPED, $this->number_of_items_shipped);
        if ($this->isColumnModified(AmazonOrdersVersionTableMap::NUMBER_OF_ITEMS_UNSHIPPED)) $criteria->add(AmazonOrdersVersionTableMap::NUMBER_OF_ITEMS_UNSHIPPED, $this->number_of_items_unshipped);
        if ($this->isColumnModified(AmazonOrdersVersionTableMap::PAYMENT_EXECUTION_DETAIL_CURRENCY_CODE)) $criteria->add(AmazonOrdersVersionTableMap::PAYMENT_EXECUTION_DETAIL_CURRENCY_CODE, $this->payment_execution_detail_currency_code);
        if ($this->isColumnModified(AmazonOrdersVersionTableMap::PAYMENT_EXECUTION_DETAIL_TOTAL_AMOUNT)) $criteria->add(AmazonOrdersVersionTableMap::PAYMENT_EXECUTION_DETAIL_TOTAL_AMOUNT, $this->payment_execution_detail_total_amount);
        if ($this->isColumnModified(AmazonOrdersVersionTableMap::PAYMENT_EXECUTION_DETAIL_PAYMENT_METHOD)) $criteria->add(AmazonOrdersVersionTableMap::PAYMENT_EXECUTION_DETAIL_PAYMENT_METHOD, $this->payment_execution_detail_payment_method);
        if ($this->isColumnModified(AmazonOrdersVersionTableMap::PAYMENT_METHOD)) $criteria->add(AmazonOrdersVersionTableMap::PAYMENT_METHOD, $this->payment_method);
        if ($this->isColumnModified(AmazonOrdersVersionTableMap::PAYMENT_METHOD_DETAIL)) $criteria->add(AmazonOrdersVersionTableMap::PAYMENT_METHOD_DETAIL, $this->payment_method_detail);
        if ($this->isColumnModified(AmazonOrdersVersionTableMap::MARKETPLACE_ID)) $criteria->add(AmazonOrdersVersionTableMap::MARKETPLACE_ID, $this->marketplace_id);
        if ($this->isColumnModified(AmazonOrdersVersionTableMap::BUYER_COUNTY)) $criteria->add(AmazonOrdersVersionTableMap::BUYER_COUNTY, $this->buyer_county);
        if ($this->isColumnModified(AmazonOrdersVersionTableMap::BUYER_TAX_INFO_COMPANY)) $criteria->add(AmazonOrdersVersionTableMap::BUYER_TAX_INFO_COMPANY, $this->buyer_tax_info_company);
        if ($this->isColumnModified(AmazonOrdersVersionTableMap::BUYER_TAX_INFO_TAXING_REGION)) $criteria->add(AmazonOrdersVersionTableMap::BUYER_TAX_INFO_TAXING_REGION, $this->buyer_tax_info_taxing_region);
        if ($this->isColumnModified(AmazonOrdersVersionTableMap::BUYER_TAX_INFO_TAX_NAME)) $criteria->add(AmazonOrdersVersionTableMap::BUYER_TAX_INFO_TAX_NAME, $this->buyer_tax_info_tax_name);
        if ($this->isColumnModified(AmazonOrdersVersionTableMap::BUYER_TAX_INFO_TAX_VALUE)) $criteria->add(AmazonOrdersVersionTableMap::BUYER_TAX_INFO_TAX_VALUE, $this->buyer_tax_info_tax_value);
        if ($this->isColumnModified(AmazonOrdersVersionTableMap::SHIPMENT_SERVICE_LEVEL_CATEGORY)) $criteria->add(AmazonOrdersVersionTableMap::SHIPMENT_SERVICE_LEVEL_CATEGORY, $this->shipment_service_level_category);
        if ($this->isColumnModified(AmazonOrdersVersionTableMap::SHIPPED_BY_AMAZON_TFM)) $criteria->add(AmazonOrdersVersionTableMap::SHIPPED_BY_AMAZON_TFM, $this->shipped_by_amazon_tfm);
        if ($this->isColumnModified(AmazonOrdersVersionTableMap::TFM_SHIPMENT_STATUS)) $criteria->add(AmazonOrdersVersionTableMap::TFM_SHIPMENT_STATUS, $this->tfm_shipment_status);
        if ($this->isColumnModified(AmazonOrdersVersionTableMap::CBA_DISPLAYABLE_SHIPPING_LABEL)) $criteria->add(AmazonOrdersVersionTableMap::CBA_DISPLAYABLE_SHIPPING_LABEL, $this->cba_displayable_shipping_label);
        if ($this->isColumnModified(AmazonOrdersVersionTableMap::ORDER_TYPE)) $criteria->add(AmazonOrdersVersionTableMap::ORDER_TYPE, $this->order_type);
        if ($this->isColumnModified(AmazonOrdersVersionTableMap::EARLIEST_SHIP_DATE)) $criteria->add(AmazonOrdersVersionTableMap::EARLIEST_SHIP_DATE, $this->earliest_ship_date);
        if ($this->isColumnModified(AmazonOrdersVersionTableMap::LATEST_SHIP_DATE)) $criteria->add(AmazonOrdersVersionTableMap::LATEST_SHIP_DATE, $this->latest_ship_date);
        if ($this->isColumnModified(AmazonOrdersVersionTableMap::EARLIEST_DELIVERY_DATE)) $criteria->add(AmazonOrdersVersionTableMap::EARLIEST_DELIVERY_DATE, $this->earliest_delivery_date);
        if ($this->isColumnModified(AmazonOrdersVersionTableMap::LATEST_DELIVERY_DATE)) $criteria->add(AmazonOrdersVersionTableMap::LATEST_DELIVERY_DATE, $this->latest_delivery_date);
        if ($this->isColumnModified(AmazonOrdersVersionTableMap::IS_BUSINESS_ORDER)) $criteria->add(AmazonOrdersVersionTableMap::IS_BUSINESS_ORDER, $this->is_business_order);
        if ($this->isColumnModified(AmazonOrdersVersionTableMap::PURCHASE_ORDER_NUMBER)) $criteria->add(AmazonOrdersVersionTableMap::PURCHASE_ORDER_NUMBER, $this->purchase_order_number);
        if ($this->isColumnModified(AmazonOrdersVersionTableMap::IS_PRIME)) $criteria->add(AmazonOrdersVersionTableMap::IS_PRIME, $this->is_prime);
        if ($this->isColumnModified(AmazonOrdersVersionTableMap::IS_PREMIUM_ORDER)) $criteria->add(AmazonOrdersVersionTableMap::IS_PREMIUM_ORDER, $this->is_premium_order);
        if ($this->isColumnModified(AmazonOrdersVersionTableMap::REPLACED_ORDER_ID)) $criteria->add(AmazonOrdersVersionTableMap::REPLACED_ORDER_ID, $this->replaced_order_id);
        if ($this->isColumnModified(AmazonOrdersVersionTableMap::IS_REPLACEMENT_ORDER)) $criteria->add(AmazonOrdersVersionTableMap::IS_REPLACEMENT_ORDER, $this->is_replacement_order);
        if ($this->isColumnModified(AmazonOrdersVersionTableMap::ORDER_ADDRESS_ID)) $criteria->add(AmazonOrdersVersionTableMap::ORDER_ADDRESS_ID, $this->order_address_id);
        if ($this->isColumnModified(AmazonOrdersVersionTableMap::CUSTOMER_ID)) $criteria->add(AmazonOrdersVersionTableMap::CUSTOMER_ID, $this->customer_id);
        if ($this->isColumnModified(AmazonOrdersVersionTableMap::ORDER_ID)) $criteria->add(AmazonOrdersVersionTableMap::ORDER_ID, $this->order_id);
        if ($this->isColumnModified(AmazonOrdersVersionTableMap::CREATED_AT)) $criteria->add(AmazonOrdersVersionTableMap::CREATED_AT, $this->created_at);
        if ($this->isColumnModified(AmazonOrdersVersionTableMap::UPDATED_AT)) $criteria->add(AmazonOrdersVersionTableMap::UPDATED_AT, $this->updated_at);
        if ($this->isColumnModified(AmazonOrdersVersionTableMap::VERSION)) $criteria->add(AmazonOrdersVersionTableMap::VERSION, $this->version);
        if ($this->isColumnModified(AmazonOrdersVersionTableMap::VERSION_CREATED_AT)) $criteria->add(AmazonOrdersVersionTableMap::VERSION_CREATED_AT, $this->version_created_at);
        if ($this->isColumnModified(AmazonOrdersVersionTableMap::VERSION_CREATED_BY)) $criteria->add(AmazonOrdersVersionTableMap::VERSION_CREATED_BY, $this->version_created_by);
        if ($this->isColumnModified(AmazonOrdersVersionTableMap::CUSTOMER_ID_VERSION)) $criteria->add(AmazonOrdersVersionTableMap::CUSTOMER_ID_VERSION, $this->customer_id_version);
        if ($this->isColumnModified(AmazonOrdersVersionTableMap::ORDER_ID_VERSION)) $criteria->add(AmazonOrdersVersionTableMap::ORDER_ID_VERSION, $this->order_id_version);

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
        $criteria = new Criteria(AmazonOrdersVersionTableMap::DATABASE_NAME);
        $criteria->add(AmazonOrdersVersionTableMap::ID, $this->id);
        $criteria->add(AmazonOrdersVersionTableMap::VERSION, $this->version);

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
        $pks[0] = $this->getId();
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
        $this->setId($keys[0]);
        $this->setVersion($keys[1]);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {

        return (null === $this->getId()) && (null === $this->getVersion());
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \AmazonIntegration\Model\AmazonOrdersVersion (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setId($this->getId());
        $copyObj->setSellerOrderId($this->getSellerOrderId());
        $copyObj->setPurchaseDate($this->getPurchaseDate());
        $copyObj->setLastUpdateDate($this->getLastUpdateDate());
        $copyObj->setOrderStatus($this->getOrderStatus());
        $copyObj->setFulfillmentChannel($this->getFulfillmentChannel());
        $copyObj->setSalesChannel($this->getSalesChannel());
        $copyObj->setOrderChannel($this->getOrderChannel());
        $copyObj->setShipServiceLevel($this->getShipServiceLevel());
        $copyObj->setOrderTotalCurrencyCode($this->getOrderTotalCurrencyCode());
        $copyObj->setOrderTotalAmount($this->getOrderTotalAmount());
        $copyObj->setNumberOfItemsShipped($this->getNumberOfItemsShipped());
        $copyObj->setNumberOfItemsUnshipped($this->getNumberOfItemsUnshipped());
        $copyObj->setPaymentExecutionDetailCurrencyCode($this->getPaymentExecutionDetailCurrencyCode());
        $copyObj->setPaymentExecutionDetailTotalAmount($this->getPaymentExecutionDetailTotalAmount());
        $copyObj->setPaymentExecutionDetailPaymentMethod($this->getPaymentExecutionDetailPaymentMethod());
        $copyObj->setPaymentMethod($this->getPaymentMethod());
        $copyObj->setPaymentMethodDetail($this->getPaymentMethodDetail());
        $copyObj->setMarketplaceId($this->getMarketplaceId());
        $copyObj->setBuyerCounty($this->getBuyerCounty());
        $copyObj->setBuyerTaxInfoCompany($this->getBuyerTaxInfoCompany());
        $copyObj->setBuyerTaxInfoTaxingRegion($this->getBuyerTaxInfoTaxingRegion());
        $copyObj->setBuyerTaxInfoTaxName($this->getBuyerTaxInfoTaxName());
        $copyObj->setBuyerTaxInfoTaxValue($this->getBuyerTaxInfoTaxValue());
        $copyObj->setShipmentServiceLevelCategory($this->getShipmentServiceLevelCategory());
        $copyObj->setShippedByAmazonTfm($this->getShippedByAmazonTfm());
        $copyObj->setTfmShipmentStatus($this->getTfmShipmentStatus());
        $copyObj->setCbaDisplayableShippingLabel($this->getCbaDisplayableShippingLabel());
        $copyObj->setOrderType($this->getOrderType());
        $copyObj->setEarliestShipDate($this->getEarliestShipDate());
        $copyObj->setLatestShipDate($this->getLatestShipDate());
        $copyObj->setEarliestDeliveryDate($this->getEarliestDeliveryDate());
        $copyObj->setLatestDeliveryDate($this->getLatestDeliveryDate());
        $copyObj->setIsBusinessOrder($this->getIsBusinessOrder());
        $copyObj->setPurchaseOrderNumber($this->getPurchaseOrderNumber());
        $copyObj->setIsPrime($this->getIsPrime());
        $copyObj->setIsPremiumOrder($this->getIsPremiumOrder());
        $copyObj->setReplacedOrderId($this->getReplacedOrderId());
        $copyObj->setIsReplacementOrder($this->getIsReplacementOrder());
        $copyObj->setOrderAddressId($this->getOrderAddressId());
        $copyObj->setCustomerId($this->getCustomerId());
        $copyObj->setOrderId($this->getOrderId());
        $copyObj->setCreatedAt($this->getCreatedAt());
        $copyObj->setUpdatedAt($this->getUpdatedAt());
        $copyObj->setVersion($this->getVersion());
        $copyObj->setVersionCreatedAt($this->getVersionCreatedAt());
        $copyObj->setVersionCreatedBy($this->getVersionCreatedBy());
        $copyObj->setCustomerIdVersion($this->getCustomerIdVersion());
        $copyObj->setOrderIdVersion($this->getOrderIdVersion());
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
     * @return                 \AmazonIntegration\Model\AmazonOrdersVersion Clone of current object.
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
     * Declares an association between this object and a ChildAmazonOrders object.
     *
     * @param                  ChildAmazonOrders $v
     * @return                 \AmazonIntegration\Model\AmazonOrdersVersion The current object (for fluent API support)
     * @throws PropelException
     */
    public function setAmazonOrders(ChildAmazonOrders $v = null)
    {
        if ($v === null) {
            $this->setId(NULL);
        } else {
            $this->setId($v->getId());
        }

        $this->aAmazonOrders = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildAmazonOrders object, it will not be re-added.
        if ($v !== null) {
            $v->addAmazonOrdersVersion($this);
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
        if ($this->aAmazonOrders === null && (($this->id !== "" && $this->id !== null))) {
            $this->aAmazonOrders = ChildAmazonOrdersQuery::create()->findPk($this->id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aAmazonOrders->addAmazonOrdersVersions($this);
             */
        }

        return $this->aAmazonOrders;
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->id = null;
        $this->seller_order_id = null;
        $this->purchase_date = null;
        $this->last_update_date = null;
        $this->order_status = null;
        $this->fulfillment_channel = null;
        $this->sales_channel = null;
        $this->order_channel = null;
        $this->ship_service_level = null;
        $this->order_total_currency_code = null;
        $this->order_total_amount = null;
        $this->number_of_items_shipped = null;
        $this->number_of_items_unshipped = null;
        $this->payment_execution_detail_currency_code = null;
        $this->payment_execution_detail_total_amount = null;
        $this->payment_execution_detail_payment_method = null;
        $this->payment_method = null;
        $this->payment_method_detail = null;
        $this->marketplace_id = null;
        $this->buyer_county = null;
        $this->buyer_tax_info_company = null;
        $this->buyer_tax_info_taxing_region = null;
        $this->buyer_tax_info_tax_name = null;
        $this->buyer_tax_info_tax_value = null;
        $this->shipment_service_level_category = null;
        $this->shipped_by_amazon_tfm = null;
        $this->tfm_shipment_status = null;
        $this->cba_displayable_shipping_label = null;
        $this->order_type = null;
        $this->earliest_ship_date = null;
        $this->latest_ship_date = null;
        $this->earliest_delivery_date = null;
        $this->latest_delivery_date = null;
        $this->is_business_order = null;
        $this->purchase_order_number = null;
        $this->is_prime = null;
        $this->is_premium_order = null;
        $this->replaced_order_id = null;
        $this->is_replacement_order = null;
        $this->order_address_id = null;
        $this->customer_id = null;
        $this->order_id = null;
        $this->created_at = null;
        $this->updated_at = null;
        $this->version = null;
        $this->version_created_at = null;
        $this->version_created_by = null;
        $this->customer_id_version = null;
        $this->order_id_version = null;
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

        $this->aAmazonOrders = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(AmazonOrdersVersionTableMap::DEFAULT_STRING_FORMAT);
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
