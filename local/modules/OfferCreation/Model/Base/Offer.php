<?php

namespace OfferCreation\Model\Base;

use \DateTime;
use \Exception;
use \PDO;
use Thelia\Model\Admin as ChildAdmin;
use Thelia\Model\AdminQuery as ChildAdminQuery;
use Thelia\Model\Currency as ChildCurrency;
use Thelia\Model\CurrencyQuery as ChildCurrencyQuery;
use Thelia\Model\Customer as ChildCustomer;
use Thelia\Model\CustomerQuery as ChildCustomerQuery;
use Thelia\Model\Lang as ChildLang;
use Thelia\Model\LangQuery as ChildLangQuery;
use Thelia\Model\Module as ChildModule;
use Thelia\Model\ModuleQuery as ChildModuleQuery;
use OfferCreation\Model\Offer as ChildOffer;
use OfferCreation\Model\OfferChat as ChildOfferChat;
use OfferCreation\Model\OfferChatQuery as ChildOfferChatQuery;
use OfferCreation\Model\OfferProduct as ChildOfferProduct;
use OfferCreation\Model\OfferProductQuery as ChildOfferProductQuery;
use OfferCreation\Model\OfferQuery as ChildOfferQuery;
use OfferCreation\Model\OfferVersion as ChildOfferVersion;
use OfferCreation\Model\OfferVersionQuery as ChildOfferVersionQuery;
use Thelia\Model\Order as ChildOrder;
use Thelia\Model\OrderAddress as ChildOrderAddress;
use Thelia\Model\OrderAddressQuery as ChildOrderAddressQuery;
use Thelia\Model\OrderQuery as ChildOrderQuery;
use Thelia\Model\OrderStatus as ChildOrderStatus;
use Thelia\Model\OrderStatusQuery as ChildOrderStatusQuery; 
use OfferCreation\Model\Map\OfferTableMap;
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
use OfferCreation\Model\Map\OfferVersionTableMap;

abstract class Offer implements ActiveRecordInterface 
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\OfferCreation\\Model\\Map\\OfferTableMap';


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
     * @var        int
     */
    protected $id;

    /**
     * The value for the ref field.
     * @var        string
     */
    protected $ref;

    /**
     * The value for the order_id field.
     * @var        int
     */
    protected $order_id;

    /**
     * The value for the order_ref field.
     * @var        string
     */
    protected $order_ref;

    /**
     * The value for the customer_id field.
     * @var        int
     */
    protected $customer_id;

    /**
     * The value for the employee_id field.
     * @var        int
     */
    protected $employee_id;

    /**
     * The value for the invoice_order_address_id field.
     * @var        int
     */
    protected $invoice_order_address_id;

    /**
     * The value for the delivery_order_address_id field.
     * @var        int
     */
    protected $delivery_order_address_id;

    /**
     * The value for the invoice_date field.
     * @var        string
     */
    protected $invoice_date;

    /**
     * The value for the currency_id field.
     * @var        int
     */
    protected $currency_id;

    /**
     * The value for the currency_rate field.
     * @var        double
     */
    protected $currency_rate;

    /**
     * The value for the transaction_ref field.
     * @var        string
     */
    protected $transaction_ref;

    /**
     * The value for the delivery_ref field.
     * @var        string
     */
    protected $delivery_ref;

    /**
     * The value for the invoice_ref field.
     * @var        string
     */
    protected $invoice_ref;

    /**
     * The value for the discount field.
     * Note: this column has a database default value of: '0.000000'
     * @var        string
     */
    protected $discount;

    /**
     * The value for the postage field.
     * Note: this column has a database default value of: '0.000000'
     * @var        string
     */
    protected $postage;

    /**
     * The value for the postage_tax field.
     * Note: this column has a database default value of: '0.000000'
     * @var        string
     */
    protected $postage_tax;

    /**
     * The value for the postage_tax_rule_title field.
     * @var        string
     */
    protected $postage_tax_rule_title;

    /**
     * The value for the payment_module_id field.
     * @var        int
     */
    protected $payment_module_id;

    /**
     * The value for the delivery_module_id field.
     * @var        int
     */
    protected $delivery_module_id;

    /**
     * The value for the status_id field.
     * @var        int
     */
    protected $status_id;

    /**
     * The value for the lang_id field.
     * @var        int
     */
    protected $lang_id;

    /**
     * The value for the cart_id field.
     * @var        int
     */
    protected $cart_id;

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
     * The value for the note_employee field.
     * @var        string
     */
    protected $note_employee;

    /**
     * The value for the chat_id field.
     * @var        int
     */
    protected $chat_id;

    /**
     * @var        OfferChat
     */
    protected $aOfferChat;

    /**
     * @var        Currency
     */
    protected $aCurrency;

    /**
     * @var        Customer
     */
    protected $aCustomer;

    /**
     * @var        Module
     */
    protected $aModuleRelatedByDeliveryModuleId;

    /**
     * @var        OrderAddress
     */
    protected $aOrderAddressRelatedByDeliveryOrderAddressId;

    /**
     * @var        Admin
     */
    protected $aAdmin;

    /**
     * @var        OrderAddress
     */
    protected $aOrderAddressRelatedByInvoiceOrderAddressId;

    /**
     * @var        Lang
     */
    protected $aLang;

    /**
     * @var        Order
     */
    protected $aOrderRelatedByOrderId;

    /**
     * @var        Order
     */
    protected $aOrderRelatedByOrderRef;

    /**
     * @var        Module
     */
    protected $aModuleRelatedByPaymentModuleId;

    /**
     * @var        OrderStatus
     */
    protected $aOrderStatus;

    /**
     * @var        ObjectCollection|ChildOfferProduct[] Collection to store aggregation of ChildOfferProduct objects.
     */
    protected $collOfferProducts;
    protected $collOfferProductsPartial;

    /**
     * @var        ObjectCollection|ChildOfferVersion[] Collection to store aggregation of ChildOfferVersion objects.
     */
    protected $collOfferVersions;
    protected $collOfferVersionsPartial;

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
    protected $offerProductsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection
     */
    protected $offerVersionsScheduledForDeletion = null;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see __construct()
     */
    public function applyDefaultValues()
    {
        $this->discount = '0.000000';
        $this->postage = '0.000000';
        $this->postage_tax = '0.000000';
        $this->version = 0;
    }

    /**
     * Initializes internal state of OfferCreation\Model\Base\Offer object.
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
     * Compares this with another <code>Offer</code> instance.  If
     * <code>obj</code> is an instance of <code>Offer</code>, delegates to
     * <code>equals(Offer)</code>.  Otherwise, returns <code>false</code>.
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
     * @return Offer The current object, for fluid interface
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
     * @return Offer The current object, for fluid interface
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
     * @return   int
     */
    public function getId()
    {

        return $this->id;
    }

    /**
     * Get the [ref] column value.
     * 
     * @return   string
     */
    public function getRef()
    {

        return $this->ref;
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
     * Get the [order_ref] column value.
     * 
     * @return   string
     */
    public function getOrderRef()
    {

        return $this->order_ref;
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
     * Get the [employee_id] column value.
     * 
     * @return   int
     */
    public function getEmployeeId()
    {

        return $this->employee_id;
    }

    /**
     * Get the [invoice_order_address_id] column value.
     * 
     * @return   int
     */
    public function getInvoiceOrderAddressId()
    {

        return $this->invoice_order_address_id;
    }

    /**
     * Get the [delivery_order_address_id] column value.
     * 
     * @return   int
     */
    public function getDeliveryOrderAddressId()
    {

        return $this->delivery_order_address_id;
    }

    /**
     * Get the [optionally formatted] temporal [invoice_date] column value.
     * 
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw \DateTime object will be returned.
     *
     * @return mixed Formatted date/time value as string or \DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getInvoiceDate($format = NULL)
    {
        if ($format === null) {
            return $this->invoice_date;
        } else {
            return $this->invoice_date instanceof \DateTime ? $this->invoice_date->format($format) : null;
        }
    }

    /**
     * Get the [currency_id] column value.
     * 
     * @return   int
     */
    public function getCurrencyId()
    {

        return $this->currency_id;
    }

    /**
     * Get the [currency_rate] column value.
     * 
     * @return   double
     */
    public function getCurrencyRate()
    {

        return $this->currency_rate;
    }

    /**
     * Get the [transaction_ref] column value.
     * 
     * @return   string
     */
    public function getTransactionRef()
    {

        return $this->transaction_ref;
    }

    /**
     * Get the [delivery_ref] column value.
     * 
     * @return   string
     */
    public function getDeliveryRef()
    {

        return $this->delivery_ref;
    }

    /**
     * Get the [invoice_ref] column value.
     * 
     * @return   string
     */
    public function getInvoiceRef()
    {

        return $this->invoice_ref;
    }

    /**
     * Get the [discount] column value.
     * 
     * @return   string
     */
    public function getDiscount()
    {

        return $this->discount;
    }

    /**
     * Get the [postage] column value.
     * 
     * @return   string
     */
    public function getPostage()
    {

        return $this->postage;
    }

    /**
     * Get the [postage_tax] column value.
     * 
     * @return   string
     */
    public function getPostageTax()
    {

        return $this->postage_tax;
    }

    /**
     * Get the [postage_tax_rule_title] column value.
     * 
     * @return   string
     */
    public function getPostageTaxRuleTitle()
    {

        return $this->postage_tax_rule_title;
    }

    /**
     * Get the [payment_module_id] column value.
     * 
     * @return   int
     */
    public function getPaymentModuleId()
    {

        return $this->payment_module_id;
    }

    /**
     * Get the [delivery_module_id] column value.
     * 
     * @return   int
     */
    public function getDeliveryModuleId()
    {

        return $this->delivery_module_id;
    }

    /**
     * Get the [status_id] column value.
     * 
     * @return   int
     */
    public function getStatusId()
    {

        return $this->status_id;
    }

    /**
     * Get the [lang_id] column value.
     * 
     * @return   int
     */
    public function getLangId()
    {

        return $this->lang_id;
    }

    /**
     * Get the [cart_id] column value.
     * 
     * @return   int
     */
    public function getCartId()
    {

        return $this->cart_id;
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
     * Get the [note_employee] column value.
     * 
     * @return   string
     */
    public function getNoteEmployee()
    {

        return $this->note_employee;
    }

    /**
     * Get the [chat_id] column value.
     * 
     * @return   int
     */
    public function getChatId()
    {

        return $this->chat_id;
    }

    /**
     * Set the value of [id] column.
     * 
     * @param      int $v new value
     * @return   \OfferCreation\Model\Offer The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[OfferTableMap::ID] = true;
        }


        return $this;
    } // setId()

    /**
     * Set the value of [ref] column.
     * 
     * @param      string $v new value
     * @return   \OfferCreation\Model\Offer The current object (for fluent API support)
     */
    public function setRef($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->ref !== $v) {
            $this->ref = $v;
            $this->modifiedColumns[OfferTableMap::REF] = true;
        }


        return $this;
    } // setRef()

    /**
     * Set the value of [order_id] column.
     * 
     * @param      int $v new value
     * @return   \OfferCreation\Model\Offer The current object (for fluent API support)
     */
    public function setOrderId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->order_id !== $v) {
            $this->order_id = $v;
            $this->modifiedColumns[OfferTableMap::ORDER_ID] = true;
        }

        if ($this->aOrderRelatedByOrderId !== null && $this->aOrderRelatedByOrderId->getId() !== $v) {
            $this->aOrderRelatedByOrderId = null;
        }


        return $this;
    } // setOrderId()

    /**
     * Set the value of [order_ref] column.
     * 
     * @param      string $v new value
     * @return   \OfferCreation\Model\Offer The current object (for fluent API support)
     */
    public function setOrderRef($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->order_ref !== $v) {
            $this->order_ref = $v;
            $this->modifiedColumns[OfferTableMap::ORDER_REF] = true;
        }

        if ($this->aOrderRelatedByOrderRef !== null && $this->aOrderRelatedByOrderRef->getRef() !== $v) {
            $this->aOrderRelatedByOrderRef = null;
        }


        return $this;
    } // setOrderRef()

    /**
     * Set the value of [customer_id] column.
     * 
     * @param      int $v new value
     * @return   \OfferCreation\Model\Offer The current object (for fluent API support)
     */
    public function setCustomerId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->customer_id !== $v) {
            $this->customer_id = $v;
            $this->modifiedColumns[OfferTableMap::CUSTOMER_ID] = true;
        }

        if ($this->aCustomer !== null && $this->aCustomer->getId() !== $v) {
            $this->aCustomer = null;
        }


        return $this;
    } // setCustomerId()

    /**
     * Set the value of [employee_id] column.
     * 
     * @param      int $v new value
     * @return   \OfferCreation\Model\Offer The current object (for fluent API support)
     */
    public function setEmployeeId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->employee_id !== $v) {
            $this->employee_id = $v;
            $this->modifiedColumns[OfferTableMap::EMPLOYEE_ID] = true;
        }

        if ($this->aAdmin !== null && $this->aAdmin->getId() !== $v) {
            $this->aAdmin = null;
        }


        return $this;
    } // setEmployeeId()

    /**
     * Set the value of [invoice_order_address_id] column.
     * 
     * @param      int $v new value
     * @return   \OfferCreation\Model\Offer The current object (for fluent API support)
     */
    public function setInvoiceOrderAddressId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->invoice_order_address_id !== $v) {
            $this->invoice_order_address_id = $v;
            $this->modifiedColumns[OfferTableMap::INVOICE_ORDER_ADDRESS_ID] = true;
        }

        if ($this->aOrderAddressRelatedByInvoiceOrderAddressId !== null && $this->aOrderAddressRelatedByInvoiceOrderAddressId->getId() !== $v) {
            $this->aOrderAddressRelatedByInvoiceOrderAddressId = null;
        }


        return $this;
    } // setInvoiceOrderAddressId()

    /**
     * Set the value of [delivery_order_address_id] column.
     * 
     * @param      int $v new value
     * @return   \OfferCreation\Model\Offer The current object (for fluent API support)
     */
    public function setDeliveryOrderAddressId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->delivery_order_address_id !== $v) {
            $this->delivery_order_address_id = $v;
            $this->modifiedColumns[OfferTableMap::DELIVERY_ORDER_ADDRESS_ID] = true;
        }

        if ($this->aOrderAddressRelatedByDeliveryOrderAddressId !== null && $this->aOrderAddressRelatedByDeliveryOrderAddressId->getId() !== $v) {
            $this->aOrderAddressRelatedByDeliveryOrderAddressId = null;
        }


        return $this;
    } // setDeliveryOrderAddressId()

    /**
     * Sets the value of [invoice_date] column to a normalized version of the date/time value specified.
     * 
     * @param      mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return   \OfferCreation\Model\Offer The current object (for fluent API support)
     */
    public function setInvoiceDate($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->invoice_date !== null || $dt !== null) {
            if ($dt !== $this->invoice_date) {
                $this->invoice_date = $dt;
                $this->modifiedColumns[OfferTableMap::INVOICE_DATE] = true;
            }
        } // if either are not null


        return $this;
    } // setInvoiceDate()

    /**
     * Set the value of [currency_id] column.
     * 
     * @param      int $v new value
     * @return   \OfferCreation\Model\Offer The current object (for fluent API support)
     */
    public function setCurrencyId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->currency_id !== $v) {
            $this->currency_id = $v;
            $this->modifiedColumns[OfferTableMap::CURRENCY_ID] = true;
        }

        if ($this->aCurrency !== null && $this->aCurrency->getId() !== $v) {
            $this->aCurrency = null;
        }


        return $this;
    } // setCurrencyId()

    /**
     * Set the value of [currency_rate] column.
     * 
     * @param      double $v new value
     * @return   \OfferCreation\Model\Offer The current object (for fluent API support)
     */
    public function setCurrencyRate($v)
    {
        if ($v !== null) {
            $v = (double) $v;
        }

        if ($this->currency_rate !== $v) {
            $this->currency_rate = $v;
            $this->modifiedColumns[OfferTableMap::CURRENCY_RATE] = true;
        }


        return $this;
    } // setCurrencyRate()

    /**
     * Set the value of [transaction_ref] column.
     * 
     * @param      string $v new value
     * @return   \OfferCreation\Model\Offer The current object (for fluent API support)
     */
    public function setTransactionRef($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->transaction_ref !== $v) {
            $this->transaction_ref = $v;
            $this->modifiedColumns[OfferTableMap::TRANSACTION_REF] = true;
        }


        return $this;
    } // setTransactionRef()

    /**
     * Set the value of [delivery_ref] column.
     * 
     * @param      string $v new value
     * @return   \OfferCreation\Model\Offer The current object (for fluent API support)
     */
    public function setDeliveryRef($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->delivery_ref !== $v) {
            $this->delivery_ref = $v;
            $this->modifiedColumns[OfferTableMap::DELIVERY_REF] = true;
        }


        return $this;
    } // setDeliveryRef()

    /**
     * Set the value of [invoice_ref] column.
     * 
     * @param      string $v new value
     * @return   \OfferCreation\Model\Offer The current object (for fluent API support)
     */
    public function setInvoiceRef($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->invoice_ref !== $v) {
            $this->invoice_ref = $v;
            $this->modifiedColumns[OfferTableMap::INVOICE_REF] = true;
        }


        return $this;
    } // setInvoiceRef()

    /**
     * Set the value of [discount] column.
     * 
     * @param      string $v new value
     * @return   \OfferCreation\Model\Offer The current object (for fluent API support)
     */
    public function setDiscount($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->discount !== $v) {
            $this->discount = $v;
            $this->modifiedColumns[OfferTableMap::DISCOUNT] = true;
        }


        return $this;
    } // setDiscount()

    /**
     * Set the value of [postage] column.
     * 
     * @param      string $v new value
     * @return   \OfferCreation\Model\Offer The current object (for fluent API support)
     */
    public function setPostage($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->postage !== $v) {
            $this->postage = $v;
            $this->modifiedColumns[OfferTableMap::POSTAGE] = true;
        }


        return $this;
    } // setPostage()

    /**
     * Set the value of [postage_tax] column.
     * 
     * @param      string $v new value
     * @return   \OfferCreation\Model\Offer The current object (for fluent API support)
     */
    public function setPostageTax($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->postage_tax !== $v) {
            $this->postage_tax = $v;
            $this->modifiedColumns[OfferTableMap::POSTAGE_TAX] = true;
        }


        return $this;
    } // setPostageTax()

    /**
     * Set the value of [postage_tax_rule_title] column.
     * 
     * @param      string $v new value
     * @return   \OfferCreation\Model\Offer The current object (for fluent API support)
     */
    public function setPostageTaxRuleTitle($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->postage_tax_rule_title !== $v) {
            $this->postage_tax_rule_title = $v;
            $this->modifiedColumns[OfferTableMap::POSTAGE_TAX_RULE_TITLE] = true;
        }


        return $this;
    } // setPostageTaxRuleTitle()

    /**
     * Set the value of [payment_module_id] column.
     * 
     * @param      int $v new value
     * @return   \OfferCreation\Model\Offer The current object (for fluent API support)
     */
    public function setPaymentModuleId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->payment_module_id !== $v) {
            $this->payment_module_id = $v;
            $this->modifiedColumns[OfferTableMap::PAYMENT_MODULE_ID] = true;
        }

        if ($this->aModuleRelatedByPaymentModuleId !== null && $this->aModuleRelatedByPaymentModuleId->getId() !== $v) {
            $this->aModuleRelatedByPaymentModuleId = null;
        }


        return $this;
    } // setPaymentModuleId()

    /**
     * Set the value of [delivery_module_id] column.
     * 
     * @param      int $v new value
     * @return   \OfferCreation\Model\Offer The current object (for fluent API support)
     */
    public function setDeliveryModuleId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->delivery_module_id !== $v) {
            $this->delivery_module_id = $v;
            $this->modifiedColumns[OfferTableMap::DELIVERY_MODULE_ID] = true;
        }

        if ($this->aModuleRelatedByDeliveryModuleId !== null && $this->aModuleRelatedByDeliveryModuleId->getId() !== $v) {
            $this->aModuleRelatedByDeliveryModuleId = null;
        }


        return $this;
    } // setDeliveryModuleId()

    /**
     * Set the value of [status_id] column.
     * 
     * @param      int $v new value
     * @return   \OfferCreation\Model\Offer The current object (for fluent API support)
     */
    public function setStatusId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->status_id !== $v) {
            $this->status_id = $v;
            $this->modifiedColumns[OfferTableMap::STATUS_ID] = true;
        }

        if ($this->aOrderStatus !== null && $this->aOrderStatus->getId() !== $v) {
            $this->aOrderStatus = null;
        }

        return $this;
    } // setStatusId()

    /**
     * Set the value of [lang_id] column.
     * 
     * @param      int $v new value
     * @return   \OfferCreation\Model\Offer The current object (for fluent API support)
     */
    public function setLangId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->lang_id !== $v) {
            $this->lang_id = $v;
            $this->modifiedColumns[OfferTableMap::LANG_ID] = true;
        }

        if ($this->aLang !== null && $this->aLang->getId() !== $v) {
            $this->aLang = null;
        }


        return $this;
    } // setLangId()

    /**
     * Set the value of [cart_id] column.
     * 
     * @param      int $v new value
     * @return   \OfferCreation\Model\Offer The current object (for fluent API support)
     */
    public function setCartId($v)
    { 
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->cart_id !== $v) {
            $this->cart_id = $v;
            $this->modifiedColumns[OfferTableMap::CART_ID] = true;
        }


        return $this;
    } // setCartId()

    /**
     * Sets the value of [created_at] column to a normalized version of the date/time value specified.
     * 
     * @param      mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return   \OfferCreation\Model\Offer The current object (for fluent API support)
     */
    public function setCreatedAt($v)
    { 
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->created_at !== null || $dt !== null) {
            if ($dt !== $this->created_at) {
                $this->created_at = $dt;
                $this->modifiedColumns[OfferTableMap::CREATED_AT] = true;
            }
        } // if either are not null


        return $this;
    } // setCreatedAt()

    /**
     * Sets the value of [updated_at] column to a normalized version of the date/time value specified.
     * 
     * @param      mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return   \OfferCreation\Model\Offer The current object (for fluent API support)
     */
    public function setUpdatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->updated_at !== null || $dt !== null) {
            if ($dt !== $this->updated_at) {
                $this->updated_at = $dt;
                $this->modifiedColumns[OfferTableMap::UPDATED_AT] = true;
            }
        } // if either are not null


        return $this;
    } // setUpdatedAt()

    /**
     * Set the value of [version] column.
     * 
     * @param      int $v new value
     * @return   \OfferCreation\Model\Offer The current object (for fluent API support)
     */
    public function setVersion($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->version !== $v) {
            $this->version = $v;
            $this->modifiedColumns[OfferTableMap::VERSION] = true;
        }


        return $this;
    } // setVersion()

    /**
     * Sets the value of [version_created_at] column to a normalized version of the date/time value specified.
     * 
     * @param      mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return   \OfferCreation\Model\Offer The current object (for fluent API support)
     */
    public function setVersionCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->version_created_at !== null || $dt !== null) {
            if ($dt !== $this->version_created_at) {
                $this->version_created_at = $dt;
                $this->modifiedColumns[OfferTableMap::VERSION_CREATED_AT] = true;
            }
        } // if either are not null


        return $this;
    } // setVersionCreatedAt()

    /**
     * Set the value of [version_created_by] column.
     * 
     * @param      string $v new value
     * @return   \OfferCreation\Model\Offer The current object (for fluent API support)
     */
    public function setVersionCreatedBy($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->version_created_by !== $v) {
            $this->version_created_by = $v;
            $this->modifiedColumns[OfferTableMap::VERSION_CREATED_BY] = true;
        }


        return $this;
    } // setVersionCreatedBy()

    /**
     * Set the value of [note_employee] column.
     * 
     * @param      string $v new value
     * @return   \OfferCreation\Model\Offer The current object (for fluent API support)
     */
    public function setNoteEmployee($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->note_employee !== $v) {
            $this->note_employee = $v;
            $this->modifiedColumns[OfferTableMap::NOTE_EMPLOYEE] = true;
        }


        return $this;
    } // setNoteEmployee()

    /**
     * Set the value of [chat_id] column.
     * 
     * @param      int $v new value
     * @return   \OfferCreation\Model\Offer The current object (for fluent API support)
     */
    public function setChatId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->chat_id !== $v) {
            $this->chat_id = $v;
            $this->modifiedColumns[OfferTableMap::CHAT_ID] = true;
        }

        if ($this->aOfferChat !== null && $this->aOfferChat->getId() !== $v) {
            $this->aOfferChat = null;
        }


        return $this;
    } // setChatId()

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
            if ($this->discount !== '0.000000') {
                return false;
            }

            if ($this->postage !== '0.000000') {
                return false;
            }

            if ($this->postage_tax !== '0.000000') {
                return false;
            }

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


            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : OfferTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : OfferTableMap::translateFieldName('Ref', TableMap::TYPE_PHPNAME, $indexType)];
            $this->ref = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : OfferTableMap::translateFieldName('OrderId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->order_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : OfferTableMap::translateFieldName('OrderRef', TableMap::TYPE_PHPNAME, $indexType)];
            $this->order_ref = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : OfferTableMap::translateFieldName('CustomerId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->customer_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : OfferTableMap::translateFieldName('EmployeeId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->employee_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : OfferTableMap::translateFieldName('InvoiceOrderAddressId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->invoice_order_address_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : OfferTableMap::translateFieldName('DeliveryOrderAddressId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->delivery_order_address_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : OfferTableMap::translateFieldName('InvoiceDate', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->invoice_date = (null !== $col) ? PropelDateTime::newInstance($col, null, '\DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : OfferTableMap::translateFieldName('CurrencyId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->currency_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 10 + $startcol : OfferTableMap::translateFieldName('CurrencyRate', TableMap::TYPE_PHPNAME, $indexType)];
            $this->currency_rate = (null !== $col) ? (double) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 11 + $startcol : OfferTableMap::translateFieldName('TransactionRef', TableMap::TYPE_PHPNAME, $indexType)];
            $this->transaction_ref = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 12 + $startcol : OfferTableMap::translateFieldName('DeliveryRef', TableMap::TYPE_PHPNAME, $indexType)];
            $this->delivery_ref = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 13 + $startcol : OfferTableMap::translateFieldName('InvoiceRef', TableMap::TYPE_PHPNAME, $indexType)];
            $this->invoice_ref = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 14 + $startcol : OfferTableMap::translateFieldName('Discount', TableMap::TYPE_PHPNAME, $indexType)];
            $this->discount = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 15 + $startcol : OfferTableMap::translateFieldName('Postage', TableMap::TYPE_PHPNAME, $indexType)];
            $this->postage = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 16 + $startcol : OfferTableMap::translateFieldName('PostageTax', TableMap::TYPE_PHPNAME, $indexType)];
            $this->postage_tax = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 17 + $startcol : OfferTableMap::translateFieldName('PostageTaxRuleTitle', TableMap::TYPE_PHPNAME, $indexType)];
            $this->postage_tax_rule_title = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 18 + $startcol : OfferTableMap::translateFieldName('PaymentModuleId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->payment_module_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 19 + $startcol : OfferTableMap::translateFieldName('DeliveryModuleId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->delivery_module_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 20 + $startcol : OfferTableMap::translateFieldName('StatusId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->status_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 21 + $startcol : OfferTableMap::translateFieldName('LangId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->lang_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 22 + $startcol : OfferTableMap::translateFieldName('CartId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->cart_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 23 + $startcol : OfferTableMap::translateFieldName('CreatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->created_at = (null !== $col) ? PropelDateTime::newInstance($col, null, '\DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 24 + $startcol : OfferTableMap::translateFieldName('UpdatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->updated_at = (null !== $col) ? PropelDateTime::newInstance($col, null, '\DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 25 + $startcol : OfferTableMap::translateFieldName('Version', TableMap::TYPE_PHPNAME, $indexType)];
            $this->version = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 26 + $startcol : OfferTableMap::translateFieldName('VersionCreatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->version_created_at = (null !== $col) ? PropelDateTime::newInstance($col, null, '\DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 27 + $startcol : OfferTableMap::translateFieldName('VersionCreatedBy', TableMap::TYPE_PHPNAME, $indexType)];
            $this->version_created_by = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 28 + $startcol : OfferTableMap::translateFieldName('NoteEmployee', TableMap::TYPE_PHPNAME, $indexType)];
            $this->note_employee = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 29 + $startcol : OfferTableMap::translateFieldName('ChatId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->chat_id = (null !== $col) ? (int) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 30; // 30 = OfferTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating \OfferCreation\Model\Offer object", 0, $e);
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
        if ($this->aOrderRelatedByOrderId !== null && $this->order_id !== $this->aOrderRelatedByOrderId->getId()) {
            $this->aOrderRelatedByOrderId = null;
        }
        if ($this->aOrderRelatedByOrderRef !== null && $this->order_ref !== $this->aOrderRelatedByOrderRef->getRef()) {
            $this->aOrderRelatedByOrderRef = null;
        }
        if ($this->aCustomer !== null && $this->customer_id !== $this->aCustomer->getId()) {
            $this->aCustomer = null;
        }
        if ($this->aAdmin !== null && $this->employee_id !== $this->aAdmin->getId()) {
            $this->aAdmin = null;
        }
        if ($this->aOrderAddressRelatedByInvoiceOrderAddressId !== null && $this->invoice_order_address_id !== $this->aOrderAddressRelatedByInvoiceOrderAddressId->getId()) {
            $this->aOrderAddressRelatedByInvoiceOrderAddressId = null;
        }
        if ($this->aOrderAddressRelatedByDeliveryOrderAddressId !== null && $this->delivery_order_address_id !== $this->aOrderAddressRelatedByDeliveryOrderAddressId->getId()) {
            $this->aOrderAddressRelatedByDeliveryOrderAddressId = null;
        }
        if ($this->aCurrency !== null && $this->currency_id !== $this->aCurrency->getId()) {
            $this->aCurrency = null;
        }
        if ($this->aModuleRelatedByPaymentModuleId !== null && $this->payment_module_id !== $this->aModuleRelatedByPaymentModuleId->getId()) {
            $this->aModuleRelatedByPaymentModuleId = null;
        }
        if ($this->aModuleRelatedByDeliveryModuleId !== null && $this->delivery_module_id !== $this->aModuleRelatedByDeliveryModuleId->getId()) {
            $this->aModuleRelatedByDeliveryModuleId = null;
        }
        if ($this->aOrderStatus !== null && $this->status_id !== $this->aOrderStatus->getId()) {
            $this->aOrderStatus = null;
        }
        if ($this->aLang !== null && $this->lang_id !== $this->aLang->getId()) {
            $this->aLang = null;
        }
        if ($this->aOfferChat !== null && $this->chat_id !== $this->aOfferChat->getId()) {
            $this->aOfferChat = null;
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
            $con = Propel::getServiceContainer()->getReadConnection(OfferTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildOfferQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aOfferChat = null;
            $this->aCurrency = null;
            $this->aCustomer = null;
            $this->aModuleRelatedByDeliveryModuleId = null;
            $this->aOrderAddressRelatedByDeliveryOrderAddressId = null;
            $this->aAdmin = null;
            $this->aOrderAddressRelatedByInvoiceOrderAddressId = null;
            $this->aLang = null;
            $this->aOrderRelatedByOrderId = null;
            $this->aOrderRelatedByOrderRef = null;
            $this->aModuleRelatedByPaymentModuleId = null;
            $this->aOrderStatus = null;
            $this->collOfferProducts = null;

            $this->collOfferVersions = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Offer::setDeleted()
     * @see Offer::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(OfferTableMap::DATABASE_NAME);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = ChildOfferQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(OfferTableMap::DATABASE_NAME);
        }

        $con->beginTransaction();
        $isInsert = $this->isNew();
        try {
        	$ret = $this->preSave($con);
        	// versionable behavior
        	if ($this->isVersioningNecessary()) {
        		$this->setVersion($this->isNew() ? 1 : $this->getLastVersionNumber($con) + 1);
        		if (!$this->isColumnModified(OfferTableMap::VERSION_CREATED_AT)) {
        			$this->setVersionCreatedAt(time());
        		}
        		$createVersion = true; // for postSave hook
        	}
        	if ($isInsert) {
        		$ret = $ret && $this->preInsert($con);
        		// timestampable behavior
        		if (!$this->isColumnModified(OfferTableMap::CREATED_AT)) {
        			$this->setCreatedAt(time());
        		}
        		if (!$this->isColumnModified(OfferTableMap::UPDATED_AT)) {
        			$this->setUpdatedAt(time());
        		}
        	} else {
        		$ret = $ret && $this->preUpdate($con);
        		// timestampable behavior
        		if ($this->isModified() && !$this->isColumnModified(OfferTableMap::UPDATED_AT)) {
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
        		OfferTableMap::addInstanceToPool($this);
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

            if ($this->aOfferChat !== null) {
                if ($this->aOfferChat->isModified() || $this->aOfferChat->isNew()) {
                    $affectedRows += $this->aOfferChat->save($con);
                }
                $this->setOfferChat($this->aOfferChat);
            }

            if ($this->aCurrency !== null) {
                if ($this->aCurrency->isModified() || $this->aCurrency->isNew()) {
                    $affectedRows += $this->aCurrency->save($con);
                }
                $this->setCurrency($this->aCurrency);
            }
            
            if ($this->aCustomer !== null) {
                if ($this->aCustomer->isModified() || $this->aCustomer->isNew()) {
                    $affectedRows += $this->aCustomer->save($con);
                }
                $this->setCustomer($this->aCustomer);
            }
           
            if ($this->aModuleRelatedByDeliveryModuleId !== null) {
                if ($this->aModuleRelatedByDeliveryModuleId->isModified() || $this->aModuleRelatedByDeliveryModuleId->isNew()) {
                    $affectedRows += $this->aModuleRelatedByDeliveryModuleId->save($con);
                }
                $this->setModuleRelatedByDeliveryModuleId($this->aModuleRelatedByDeliveryModuleId);
            }

            if ($this->aOrderAddressRelatedByDeliveryOrderAddressId !== null) {
                if ($this->aOrderAddressRelatedByDeliveryOrderAddressId->isModified() || $this->aOrderAddressRelatedByDeliveryOrderAddressId->isNew()) {
                    $affectedRows += $this->aOrderAddressRelatedByDeliveryOrderAddressId->save($con);
                }
                $this->setOrderAddressRelatedByDeliveryOrderAddressId($this->aOrderAddressRelatedByDeliveryOrderAddressId);
            }

            if ($this->aAdmin !== null) {
                if ($this->aAdmin->isModified() || $this->aAdmin->isNew()) {
                    $affectedRows += $this->aAdmin->save($con);
                }
                $this->setAdmin($this->aAdmin);
            }
          
            if ($this->aOrderAddressRelatedByInvoiceOrderAddressId !== null) {
                if ($this->aOrderAddressRelatedByInvoiceOrderAddressId->isModified() || $this->aOrderAddressRelatedByInvoiceOrderAddressId->isNew()) {
                    $affectedRows += $this->aOrderAddressRelatedByInvoiceOrderAddressId->save($con);
                }
                $this->setOrderAddressRelatedByInvoiceOrderAddressId($this->aOrderAddressRelatedByInvoiceOrderAddressId);
            }
         
            if ($this->aLang !== null) {
                if ($this->aLang->isModified() || $this->aLang->isNew()) {
                    $affectedRows += $this->aLang->save($con);
                }
                $this->setLang($this->aLang);
            }
            
            if ($this->aOrderRelatedByOrderId !== null) {
                if ($this->aOrderRelatedByOrderId->isModified() || $this->aOrderRelatedByOrderId->isNew()) {
                    $affectedRows += $this->aOrderRelatedByOrderId->save($con);
                }
                $this->setOrderRelatedByOrderId($this->aOrderRelatedByOrderId);
            }
     
            if ($this->aOrderRelatedByOrderRef !== null) {
                if ($this->aOrderRelatedByOrderRef->isModified() || $this->aOrderRelatedByOrderRef->isNew()) {
                    $affectedRows += $this->aOrderRelatedByOrderRef->save($con);
                }
                $this->setOrderRelatedByOrderRef($this->aOrderRelatedByOrderRef);
            }
            
            if ($this->aModuleRelatedByPaymentModuleId !== null) {
                if ($this->aModuleRelatedByPaymentModuleId->isModified() || $this->aModuleRelatedByPaymentModuleId->isNew()) {
                    $affectedRows += $this->aModuleRelatedByPaymentModuleId->save($con);
                }
                $this->setModuleRelatedByPaymentModuleId($this->aModuleRelatedByPaymentModuleId);
            }
        
            if ($this->aOrderStatus !== null) {
                if ($this->aOrderStatus->isModified() || $this->aOrderStatus->isNew()) {
                    $affectedRows += $this->aOrderStatus->save($con);
                }
                $this->setOrderStatus($this->aOrderStatus);
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

            if ($this->offerProductsScheduledForDeletion !== null) {
                if (!$this->offerProductsScheduledForDeletion->isEmpty()) {
                    \OfferCreation\Model\OfferProductQuery::create()
                        ->filterByPrimaryKeys($this->offerProductsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->offerProductsScheduledForDeletion = null;
                }
            }

                if ($this->collOfferProducts !== null) {
            foreach ($this->collOfferProducts as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->offerVersionsScheduledForDeletion !== null) {
                if (!$this->offerVersionsScheduledForDeletion->isEmpty()) {
                    \OfferCreation\Model\OfferVersionQuery::create()
                        ->filterByPrimaryKeys($this->offerVersionsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->offerVersionsScheduledForDeletion = null;
                }
            }

                if ($this->collOfferVersions !== null) {
            foreach ($this->collOfferVersions as $referrerFK) {
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

        $this->modifiedColumns[OfferTableMap::ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . OfferTableMap::ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(OfferTableMap::ID)) {
            $modifiedColumns[':p' . $index++]  = 'ID';
        }
        if ($this->isColumnModified(OfferTableMap::REF)) {
            $modifiedColumns[':p' . $index++]  = 'REF';
        }
        if ($this->isColumnModified(OfferTableMap::ORDER_ID)) {
            $modifiedColumns[':p' . $index++]  = 'ORDER_ID';
        }
        if ($this->isColumnModified(OfferTableMap::ORDER_REF)) {
            $modifiedColumns[':p' . $index++]  = 'ORDER_REF';
        }
        if ($this->isColumnModified(OfferTableMap::CUSTOMER_ID)) {
            $modifiedColumns[':p' . $index++]  = 'CUSTOMER_ID';
        }
        if ($this->isColumnModified(OfferTableMap::EMPLOYEE_ID)) {
            $modifiedColumns[':p' . $index++]  = 'EMPLOYEE_ID';
        }
        if ($this->isColumnModified(OfferTableMap::INVOICE_ORDER_ADDRESS_ID)) {
            $modifiedColumns[':p' . $index++]  = 'INVOICE_ORDER_ADDRESS_ID';
        }
        if ($this->isColumnModified(OfferTableMap::DELIVERY_ORDER_ADDRESS_ID)) {
            $modifiedColumns[':p' . $index++]  = 'DELIVERY_ORDER_ADDRESS_ID';
        }
        if ($this->isColumnModified(OfferTableMap::INVOICE_DATE)) {
            $modifiedColumns[':p' . $index++]  = 'INVOICE_DATE';
        }
        if ($this->isColumnModified(OfferTableMap::CURRENCY_ID)) {
            $modifiedColumns[':p' . $index++]  = 'CURRENCY_ID';
        }
        if ($this->isColumnModified(OfferTableMap::CURRENCY_RATE)) {
            $modifiedColumns[':p' . $index++]  = 'CURRENCY_RATE';
        }
        if ($this->isColumnModified(OfferTableMap::TRANSACTION_REF)) {
            $modifiedColumns[':p' . $index++]  = 'TRANSACTION_REF';
        }
        if ($this->isColumnModified(OfferTableMap::DELIVERY_REF)) {
            $modifiedColumns[':p' . $index++]  = 'DELIVERY_REF';
        }
        if ($this->isColumnModified(OfferTableMap::INVOICE_REF)) {
            $modifiedColumns[':p' . $index++]  = 'INVOICE_REF';
        }
        if ($this->isColumnModified(OfferTableMap::DISCOUNT)) {
            $modifiedColumns[':p' . $index++]  = 'DISCOUNT';
        }
        if ($this->isColumnModified(OfferTableMap::POSTAGE)) {
            $modifiedColumns[':p' . $index++]  = 'POSTAGE';
        }
        if ($this->isColumnModified(OfferTableMap::POSTAGE_TAX)) {
            $modifiedColumns[':p' . $index++]  = 'POSTAGE_TAX';
        }
        if ($this->isColumnModified(OfferTableMap::POSTAGE_TAX_RULE_TITLE)) {
            $modifiedColumns[':p' . $index++]  = 'POSTAGE_TAX_RULE_TITLE';
        }
        if ($this->isColumnModified(OfferTableMap::PAYMENT_MODULE_ID)) {
            $modifiedColumns[':p' . $index++]  = 'PAYMENT_MODULE_ID';
        }
        if ($this->isColumnModified(OfferTableMap::DELIVERY_MODULE_ID)) {
            $modifiedColumns[':p' . $index++]  = 'DELIVERY_MODULE_ID';
        }
        if ($this->isColumnModified(OfferTableMap::STATUS_ID)) {
            $modifiedColumns[':p' . $index++]  = 'STATUS_ID';
        }
        if ($this->isColumnModified(OfferTableMap::LANG_ID)) {
            $modifiedColumns[':p' . $index++]  = 'LANG_ID';
        }
        if ($this->isColumnModified(OfferTableMap::CART_ID)) {
            $modifiedColumns[':p' . $index++]  = 'CART_ID';
        }
        if ($this->isColumnModified(OfferTableMap::CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'CREATED_AT';
        }
        if ($this->isColumnModified(OfferTableMap::UPDATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'UPDATED_AT';
        }
        if ($this->isColumnModified(OfferTableMap::VERSION)) {
            $modifiedColumns[':p' . $index++]  = 'VERSION';
        }
        if ($this->isColumnModified(OfferTableMap::VERSION_CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'VERSION_CREATED_AT';
        }
        if ($this->isColumnModified(OfferTableMap::VERSION_CREATED_BY)) {
            $modifiedColumns[':p' . $index++]  = 'VERSION_CREATED_BY';
        }
        if ($this->isColumnModified(OfferTableMap::NOTE_EMPLOYEE)) {
            $modifiedColumns[':p' . $index++]  = 'NOTE_EMPLOYEE';
        }
        if ($this->isColumnModified(OfferTableMap::CHAT_ID)) {
            $modifiedColumns[':p' . $index++]  = 'CHAT_ID';
        }

        $sql = sprintf(
            'INSERT INTO offer (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'ID':                        
                        $stmt->bindValue($identifier, $this->id, PDO::PARAM_INT);
                        break;
                    case 'REF':                        
                        $stmt->bindValue($identifier, $this->ref, PDO::PARAM_STR);
                        break;
                    case 'ORDER_ID':                        
                        $stmt->bindValue($identifier, $this->order_id, PDO::PARAM_INT);
                        break;
                    case 'ORDER_REF':                        
                        $stmt->bindValue($identifier, $this->order_ref, PDO::PARAM_STR);
                        break;
                    case 'CUSTOMER_ID':                        
                        $stmt->bindValue($identifier, $this->customer_id, PDO::PARAM_INT);
                        break;
                    case 'EMPLOYEE_ID':                        
                        $stmt->bindValue($identifier, $this->employee_id, PDO::PARAM_INT);
                        break;
                    case 'INVOICE_ORDER_ADDRESS_ID':                        
                        $stmt->bindValue($identifier, $this->invoice_order_address_id, PDO::PARAM_INT);
                        break;
                    case 'DELIVERY_ORDER_ADDRESS_ID':                        
                        $stmt->bindValue($identifier, $this->delivery_order_address_id, PDO::PARAM_INT);
                        break;
                    case 'INVOICE_DATE':                        
                        $stmt->bindValue($identifier, $this->invoice_date ? $this->invoice_date->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                    case 'CURRENCY_ID':                        
                        $stmt->bindValue($identifier, $this->currency_id, PDO::PARAM_INT);
                        break;
                    case 'CURRENCY_RATE':                        
                        $stmt->bindValue($identifier, $this->currency_rate, PDO::PARAM_STR);
                        break;
                    case 'TRANSACTION_REF':                        
                        $stmt->bindValue($identifier, $this->transaction_ref, PDO::PARAM_STR);
                        break;
                    case 'DELIVERY_REF':                        
                        $stmt->bindValue($identifier, $this->delivery_ref, PDO::PARAM_STR);
                        break;
                    case 'INVOICE_REF':                        
                        $stmt->bindValue($identifier, $this->invoice_ref, PDO::PARAM_STR);
                        break;
                    case 'DISCOUNT':                        
                        $stmt->bindValue($identifier, $this->discount, PDO::PARAM_STR);
                        break;
                    case 'POSTAGE':                        
                        $stmt->bindValue($identifier, $this->postage, PDO::PARAM_STR);
                        break;
                    case 'POSTAGE_TAX':                        
                        $stmt->bindValue($identifier, $this->postage_tax, PDO::PARAM_STR);
                        break;
                    case 'POSTAGE_TAX_RULE_TITLE':                        
                        $stmt->bindValue($identifier, $this->postage_tax_rule_title, PDO::PARAM_STR);
                        break;
                    case 'PAYMENT_MODULE_ID':                        
                        $stmt->bindValue($identifier, $this->payment_module_id, PDO::PARAM_INT);
                        break;
                    case 'DELIVERY_MODULE_ID':                        
                        $stmt->bindValue($identifier, $this->delivery_module_id, PDO::PARAM_INT);
                        break;
                    case 'STATUS_ID':                        
                        $stmt->bindValue($identifier, $this->status_id, PDO::PARAM_INT);
                        break;
                    case 'LANG_ID':                        
                        $stmt->bindValue($identifier, $this->lang_id, PDO::PARAM_INT);
                        break;
                    case 'CART_ID':                        
                        $stmt->bindValue($identifier, $this->cart_id, PDO::PARAM_INT);
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
                    case 'NOTE_EMPLOYEE':                        
                        $stmt->bindValue($identifier, $this->note_employee, PDO::PARAM_STR);
                        break;
                    case 'CHAT_ID':                        
                        $stmt->bindValue($identifier, $this->chat_id, PDO::PARAM_INT);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

        try {
            $pk = $con->lastInsertId();
        } catch (Exception $e) {
            throw new PropelException('Unable to get autoincrement id.', 0, $e);
        }
        $this->setId($pk);

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
        $pos = OfferTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getRef();
                break;
            case 2:
                return $this->getOrderId();
                break;
            case 3:
                return $this->getOrderRef();
                break;
            case 4:
                return $this->getCustomerId();
                break;
            case 5:
                return $this->getEmployeeId();
                break;
            case 6:
                return $this->getInvoiceOrderAddressId();
                break;
            case 7:
                return $this->getDeliveryOrderAddressId();
                break;
            case 8:
                return $this->getInvoiceDate();
                break;
            case 9:
                return $this->getCurrencyId();
                break;
            case 10:
                return $this->getCurrencyRate();
                break;
            case 11:
                return $this->getTransactionRef();
                break;
            case 12:
                return $this->getDeliveryRef();
                break;
            case 13:
                return $this->getInvoiceRef();
                break;
            case 14:
                return $this->getDiscount();
                break;
            case 15:
                return $this->getPostage();
                break;
            case 16:
                return $this->getPostageTax();
                break;
            case 17:
                return $this->getPostageTaxRuleTitle();
                break;
            case 18:
                return $this->getPaymentModuleId();
                break;
            case 19:
                return $this->getDeliveryModuleId();
                break;
            case 20:
                return $this->getStatusId();
                break;
            case 21:
                return $this->getLangId();
                break;
            case 22:
                return $this->getCartId();
                break;
            case 23:
                return $this->getCreatedAt();
                break;
            case 24:
                return $this->getUpdatedAt();
                break;
            case 25:
                return $this->getVersion();
                break;
            case 26:
                return $this->getVersionCreatedAt();
                break;
            case 27:
                return $this->getVersionCreatedBy();
                break;
            case 28:
                return $this->getNoteEmployee();
                break;
            case 29:
                return $this->getChatId();
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
        if (isset($alreadyDumpedObjects['Offer'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Offer'][$this->getPrimaryKey()] = true;
        $keys = OfferTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getRef(),
            $keys[2] => $this->getOrderId(),
            $keys[3] => $this->getOrderRef(),
            $keys[4] => $this->getCustomerId(),
            $keys[5] => $this->getEmployeeId(),
            $keys[6] => $this->getInvoiceOrderAddressId(),
            $keys[7] => $this->getDeliveryOrderAddressId(),
            $keys[8] => $this->getInvoiceDate(),
            $keys[9] => $this->getCurrencyId(),
            $keys[10] => $this->getCurrencyRate(),
            $keys[11] => $this->getTransactionRef(),
            $keys[12] => $this->getDeliveryRef(),
            $keys[13] => $this->getInvoiceRef(),
            $keys[14] => $this->getDiscount(),
            $keys[15] => $this->getPostage(),
            $keys[16] => $this->getPostageTax(),
            $keys[17] => $this->getPostageTaxRuleTitle(),
            $keys[18] => $this->getPaymentModuleId(),
            $keys[19] => $this->getDeliveryModuleId(),
            $keys[20] => $this->getStatusId(),
            $keys[21] => $this->getLangId(),
            $keys[22] => $this->getCartId(),
            $keys[23] => $this->getCreatedAt(),
            $keys[24] => $this->getUpdatedAt(),
            $keys[25] => $this->getVersion(),
            $keys[26] => $this->getVersionCreatedAt(),
            $keys[27] => $this->getVersionCreatedBy(),
            $keys[28] => $this->getNoteEmployee(),
            $keys[29] => $this->getChatId(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }
        
        if ($includeForeignObjects) {
            if (null !== $this->aOfferChat) {
                $result['OfferChat'] = $this->aOfferChat->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aCurrency) {
                $result['Currency'] = $this->aCurrency->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aCustomer) {
                $result['Customer'] = $this->aCustomer->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aModuleRelatedByDeliveryModuleId) {
                $result['ModuleRelatedByDeliveryModuleId'] = $this->aModuleRelatedByDeliveryModuleId->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aOrderAddressRelatedByDeliveryOrderAddressId) {
                $result['OrderAddressRelatedByDeliveryOrderAddressId'] = $this->aOrderAddressRelatedByDeliveryOrderAddressId->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aAdmin) {
                $result['Admin'] = $this->aAdmin->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aOrderAddressRelatedByInvoiceOrderAddressId) {
                $result['OrderAddressRelatedByInvoiceOrderAddressId'] = $this->aOrderAddressRelatedByInvoiceOrderAddressId->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aLang) {
                $result['Lang'] = $this->aLang->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aOrderRelatedByOrderId) {
                $result['OrderRelatedByOrderId'] = $this->aOrderRelatedByOrderId->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aOrderRelatedByOrderRef) {
                $result['OrderRelatedByOrderRef'] = $this->aOrderRelatedByOrderRef->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aModuleRelatedByPaymentModuleId) {
                $result['ModuleRelatedByPaymentModuleId'] = $this->aModuleRelatedByPaymentModuleId->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aOrderStatus) { 
                $result['OrderStatus'] = $this->aOrderStatus->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collOfferProducts) {
                $result['OfferProducts'] = $this->collOfferProducts->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collOfferVersions) {
                $result['OfferVersions'] = $this->collOfferVersions->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
        $pos = OfferTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

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
                $this->setRef($value);
                break;
            case 2:
                $this->setOrderId($value);
                break;
            case 3:
                $this->setOrderRef($value);
                break;
            case 4:
                $this->setCustomerId($value);
                break;
            case 5:
                $this->setEmployeeId($value);
                break;
            case 6:
                $this->setInvoiceOrderAddressId($value);
                break;
            case 7:
                $this->setDeliveryOrderAddressId($value);
                break;
            case 8:
                $this->setInvoiceDate($value);
                break;
            case 9:
                $this->setCurrencyId($value);
                break;
            case 10:
                $this->setCurrencyRate($value);
                break;
            case 11:
                $this->setTransactionRef($value);
                break;
            case 12:
                $this->setDeliveryRef($value);
                break;
            case 13:
                $this->setInvoiceRef($value);
                break;
            case 14:
                $this->setDiscount($value);
                break;
            case 15:
                $this->setPostage($value);
                break;
            case 16:
                $this->setPostageTax($value);
                break;
            case 17:
                $this->setPostageTaxRuleTitle($value);
                break;
            case 18:
                $this->setPaymentModuleId($value);
                break;
            case 19:
                $this->setDeliveryModuleId($value);
                break;
            case 20:
                $this->setStatusId($value);
                break;
            case 21:
                $this->setLangId($value);
                break;
            case 22:
                $this->setCartId($value);
                break;
            case 23:
                $this->setCreatedAt($value);
                break;
            case 24:
                $this->setUpdatedAt($value);
                break;
            case 25:
                $this->setVersion($value);
                break;
            case 26:
                $this->setVersionCreatedAt($value);
                break;
            case 27:
                $this->setVersionCreatedBy($value);
                break;
            case 28:
                $this->setNoteEmployee($value);
                break;
            case 29:
                $this->setChatId($value);
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
        $keys = OfferTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setRef($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setOrderId($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setOrderRef($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setCustomerId($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setEmployeeId($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setInvoiceOrderAddressId($arr[$keys[6]]);
        if (array_key_exists($keys[7], $arr)) $this->setDeliveryOrderAddressId($arr[$keys[7]]);
        if (array_key_exists($keys[8], $arr)) $this->setInvoiceDate($arr[$keys[8]]);
        if (array_key_exists($keys[9], $arr)) $this->setCurrencyId($arr[$keys[9]]);
        if (array_key_exists($keys[10], $arr)) $this->setCurrencyRate($arr[$keys[10]]);
        if (array_key_exists($keys[11], $arr)) $this->setTransactionRef($arr[$keys[11]]);
        if (array_key_exists($keys[12], $arr)) $this->setDeliveryRef($arr[$keys[12]]);
        if (array_key_exists($keys[13], $arr)) $this->setInvoiceRef($arr[$keys[13]]);
        if (array_key_exists($keys[14], $arr)) $this->setDiscount($arr[$keys[14]]);
        if (array_key_exists($keys[15], $arr)) $this->setPostage($arr[$keys[15]]);
        if (array_key_exists($keys[16], $arr)) $this->setPostageTax($arr[$keys[16]]);
        if (array_key_exists($keys[17], $arr)) $this->setPostageTaxRuleTitle($arr[$keys[17]]);
        if (array_key_exists($keys[18], $arr)) $this->setPaymentModuleId($arr[$keys[18]]);
        if (array_key_exists($keys[19], $arr)) $this->setDeliveryModuleId($arr[$keys[19]]);
        if (array_key_exists($keys[20], $arr)) $this->setStatusId($arr[$keys[20]]);
        if (array_key_exists($keys[21], $arr)) $this->setLangId($arr[$keys[21]]);
        if (array_key_exists($keys[22], $arr)) $this->setCartId($arr[$keys[22]]);
        if (array_key_exists($keys[23], $arr)) $this->setCreatedAt($arr[$keys[23]]);
        if (array_key_exists($keys[24], $arr)) $this->setUpdatedAt($arr[$keys[24]]);
        if (array_key_exists($keys[25], $arr)) $this->setVersion($arr[$keys[25]]);
        if (array_key_exists($keys[26], $arr)) $this->setVersionCreatedAt($arr[$keys[26]]);
        if (array_key_exists($keys[27], $arr)) $this->setVersionCreatedBy($arr[$keys[27]]);
        if (array_key_exists($keys[28], $arr)) $this->setNoteEmployee($arr[$keys[28]]);
        if (array_key_exists($keys[29], $arr)) $this->setChatId($arr[$keys[29]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(OfferTableMap::DATABASE_NAME);

        if ($this->isColumnModified(OfferTableMap::ID)) $criteria->add(OfferTableMap::ID, $this->id);
        if ($this->isColumnModified(OfferTableMap::REF)) $criteria->add(OfferTableMap::REF, $this->ref);
        if ($this->isColumnModified(OfferTableMap::ORDER_ID)) $criteria->add(OfferTableMap::ORDER_ID, $this->order_id);
        if ($this->isColumnModified(OfferTableMap::ORDER_REF)) $criteria->add(OfferTableMap::ORDER_REF, $this->order_ref);
        if ($this->isColumnModified(OfferTableMap::CUSTOMER_ID)) $criteria->add(OfferTableMap::CUSTOMER_ID, $this->customer_id);
        if ($this->isColumnModified(OfferTableMap::EMPLOYEE_ID)) $criteria->add(OfferTableMap::EMPLOYEE_ID, $this->employee_id);
        if ($this->isColumnModified(OfferTableMap::INVOICE_ORDER_ADDRESS_ID)) $criteria->add(OfferTableMap::INVOICE_ORDER_ADDRESS_ID, $this->invoice_order_address_id);
        if ($this->isColumnModified(OfferTableMap::DELIVERY_ORDER_ADDRESS_ID)) $criteria->add(OfferTableMap::DELIVERY_ORDER_ADDRESS_ID, $this->delivery_order_address_id);
        if ($this->isColumnModified(OfferTableMap::INVOICE_DATE)) $criteria->add(OfferTableMap::INVOICE_DATE, $this->invoice_date);
        if ($this->isColumnModified(OfferTableMap::CURRENCY_ID)) $criteria->add(OfferTableMap::CURRENCY_ID, $this->currency_id);
        if ($this->isColumnModified(OfferTableMap::CURRENCY_RATE)) $criteria->add(OfferTableMap::CURRENCY_RATE, $this->currency_rate);
        if ($this->isColumnModified(OfferTableMap::TRANSACTION_REF)) $criteria->add(OfferTableMap::TRANSACTION_REF, $this->transaction_ref);
        if ($this->isColumnModified(OfferTableMap::DELIVERY_REF)) $criteria->add(OfferTableMap::DELIVERY_REF, $this->delivery_ref);
        if ($this->isColumnModified(OfferTableMap::INVOICE_REF)) $criteria->add(OfferTableMap::INVOICE_REF, $this->invoice_ref);
        if ($this->isColumnModified(OfferTableMap::DISCOUNT)) $criteria->add(OfferTableMap::DISCOUNT, $this->discount);
        if ($this->isColumnModified(OfferTableMap::POSTAGE)) $criteria->add(OfferTableMap::POSTAGE, $this->postage);
        if ($this->isColumnModified(OfferTableMap::POSTAGE_TAX)) $criteria->add(OfferTableMap::POSTAGE_TAX, $this->postage_tax);
        if ($this->isColumnModified(OfferTableMap::POSTAGE_TAX_RULE_TITLE)) $criteria->add(OfferTableMap::POSTAGE_TAX_RULE_TITLE, $this->postage_tax_rule_title);
        if ($this->isColumnModified(OfferTableMap::PAYMENT_MODULE_ID)) $criteria->add(OfferTableMap::PAYMENT_MODULE_ID, $this->payment_module_id);
        if ($this->isColumnModified(OfferTableMap::DELIVERY_MODULE_ID)) $criteria->add(OfferTableMap::DELIVERY_MODULE_ID, $this->delivery_module_id);
        if ($this->isColumnModified(OfferTableMap::STATUS_ID)) $criteria->add(OfferTableMap::STATUS_ID, $this->status_id);
        if ($this->isColumnModified(OfferTableMap::LANG_ID)) $criteria->add(OfferTableMap::LANG_ID, $this->lang_id);
        if ($this->isColumnModified(OfferTableMap::CART_ID)) $criteria->add(OfferTableMap::CART_ID, $this->cart_id);
        if ($this->isColumnModified(OfferTableMap::CREATED_AT)) $criteria->add(OfferTableMap::CREATED_AT, $this->created_at);
        if ($this->isColumnModified(OfferTableMap::UPDATED_AT)) $criteria->add(OfferTableMap::UPDATED_AT, $this->updated_at);
        if ($this->isColumnModified(OfferTableMap::VERSION)) $criteria->add(OfferTableMap::VERSION, $this->version);
        if ($this->isColumnModified(OfferTableMap::VERSION_CREATED_AT)) $criteria->add(OfferTableMap::VERSION_CREATED_AT, $this->version_created_at);
        if ($this->isColumnModified(OfferTableMap::VERSION_CREATED_BY)) $criteria->add(OfferTableMap::VERSION_CREATED_BY, $this->version_created_by);
        if ($this->isColumnModified(OfferTableMap::NOTE_EMPLOYEE)) $criteria->add(OfferTableMap::NOTE_EMPLOYEE, $this->note_employee);
        if ($this->isColumnModified(OfferTableMap::CHAT_ID)) $criteria->add(OfferTableMap::CHAT_ID, $this->chat_id);

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
        $criteria = new Criteria(OfferTableMap::DATABASE_NAME);
        $criteria->add(OfferTableMap::ID, $this->id);

        return $criteria;
    }

    /**
     * Returns the primary key for this object (row).
     * @return   int
     */
    public function getPrimaryKey()
    {
        return $this->getId();
    }

    /**
     * Generic method to set the primary key (id column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {

        return null === $this->getId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \OfferCreation\Model\Offer (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setRef($this->getRef());
        $copyObj->setOrderId($this->getOrderId());
        $copyObj->setOrderRef($this->getOrderRef());
        $copyObj->setCustomerId($this->getCustomerId());
        $copyObj->setEmployeeId($this->getEmployeeId());
        $copyObj->setInvoiceOrderAddressId($this->getInvoiceOrderAddressId());
        $copyObj->setDeliveryOrderAddressId($this->getDeliveryOrderAddressId());
        $copyObj->setInvoiceDate($this->getInvoiceDate());
        $copyObj->setCurrencyId($this->getCurrencyId());
        $copyObj->setCurrencyRate($this->getCurrencyRate());
        $copyObj->setTransactionRef($this->getTransactionRef());
        $copyObj->setDeliveryRef($this->getDeliveryRef());
        $copyObj->setInvoiceRef($this->getInvoiceRef());
        $copyObj->setDiscount($this->getDiscount());
        $copyObj->setPostage($this->getPostage());
        $copyObj->setPostageTax($this->getPostageTax());
        $copyObj->setPostageTaxRuleTitle($this->getPostageTaxRuleTitle());
        $copyObj->setPaymentModuleId($this->getPaymentModuleId());
        $copyObj->setDeliveryModuleId($this->getDeliveryModuleId());
        $copyObj->setStatusId($this->getStatusId());
        $copyObj->setLangId($this->getLangId());
        $copyObj->setCartId($this->getCartId());
        $copyObj->setCreatedAt($this->getCreatedAt());
        $copyObj->setUpdatedAt($this->getUpdatedAt());
        $copyObj->setVersion($this->getVersion());
        $copyObj->setVersionCreatedAt($this->getVersionCreatedAt());
        $copyObj->setVersionCreatedBy($this->getVersionCreatedBy());
        $copyObj->setNoteEmployee($this->getNoteEmployee());
        $copyObj->setChatId($this->getChatId());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getOfferProducts() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addOfferProduct($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getOfferVersions() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addOfferVersion($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setId(NULL); // this is a auto-increment column, so set to default value
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
     * @return                 \OfferCreation\Model\Offer Clone of current object.
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
     * Declares an association between this object and a ChildOfferChat object.
     *
     * @param                  ChildOfferChat $v
     * @return                 \OfferCreation\Model\Offer The current object (for fluent API support)
     * @throws PropelException
     */
    public function setOfferChat(ChildOfferChat $v = null)
    {
        if ($v === null) {
            $this->setChatId(NULL);
        } else {
            $this->setChatId($v->getId());
        }

        $this->aOfferChat = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildOfferChat object, it will not be re-added.
        if ($v !== null) {
            $v->addOffer($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildOfferChat object
     *
     * @param      ConnectionInterface $con Optional Connection object.
     * @return                 ChildOfferChat The associated ChildOfferChat object.
     * @throws PropelException
     */
    public function getOfferChat(ConnectionInterface $con = null)
    {
        if ($this->aOfferChat === null && ($this->chat_id !== null)) {
            $this->aOfferChat = ChildOfferChatQuery::create()->findPk($this->chat_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aOfferChat->addOffers($this);
             */
        }

        return $this->aOfferChat;
    }

    /**
     * Declares an association between this object and a ChildCurrency object.
     *
     * @param                  ChildCurrency $v
     * @return                 \OfferCreation\Model\Offer The current object (for fluent API support)
     * @throws PropelException
     */
    public function setCurrency(ChildCurrency $v = null)
    {
        if ($v === null) {
            $this->setCurrencyId(NULL);
        } else {
            $this->setCurrencyId($v->getId());
        }

        $this->aCurrency = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildCurrency object, it will not be re-added.
        if ($v !== null) {
            $v->addOffer($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildCurrency object
     *
     * @param      ConnectionInterface $con Optional Connection object.
     * @return                 ChildCurrency The associated ChildCurrency object.
     * @throws PropelException
     */
    public function getCurrency(ConnectionInterface $con = null)
    {
        if ($this->aCurrency === null && ($this->currency_id !== null)) {
            $this->aCurrency = ChildCurrencyQuery::create()->findPk($this->currency_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aCurrency->addOffers($this);
             */
        }

        return $this->aCurrency;
    }

    /**
     * Declares an association between this object and a ChildCustomer object.
     *
     * @param                  ChildCustomer $v
     * @return                 \OfferCreation\Model\Offer The current object (for fluent API support)
     * @throws PropelException
     */
    public function setCustomer(ChildCustomer $v = null)
    {
        if ($v === null) {
            $this->setCustomerId(NULL);
        } else {
            $this->setCustomerId($v->getId());
        }

        $this->aCustomer = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildCustomer object, it will not be re-added.
        if ($v !== null) {
            $v->addOffer($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildCustomer object
     *
     * @param      ConnectionInterface $con Optional Connection object.
     * @return                 ChildCustomer The associated ChildCustomer object.
     * @throws PropelException
     */
    public function getCustomer(ConnectionInterface $con = null)
    {
        if ($this->aCustomer === null && ($this->customer_id !== null)) {
            $this->aCustomer = ChildCustomerQuery::create()->findPk($this->customer_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aCustomer->addOffers($this);
             */
        }

        return $this->aCustomer;
    }

    /**
     * Declares an association between this object and a ChildModule object.
     *
     * @param                  ChildModule $v
     * @return                 \OfferCreation\Model\Offer The current object (for fluent API support)
     * @throws PropelException
     */
    public function setModuleRelatedByDeliveryModuleId(ChildModule $v = null)
    {
        if ($v === null) {
            $this->setDeliveryModuleId(NULL);
        } else {
            $this->setDeliveryModuleId($v->getId());
        }

        $this->aModuleRelatedByDeliveryModuleId = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildModule object, it will not be re-added.
        if ($v !== null) {
            $v->addOfferRelatedByDeliveryModuleId($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildModule object
     *
     * @param      ConnectionInterface $con Optional Connection object.
     * @return                 ChildModule The associated ChildModule object.
     * @throws PropelException
     */
    public function getModuleRelatedByDeliveryModuleId(ConnectionInterface $con = null)
    {
        if ($this->aModuleRelatedByDeliveryModuleId === null && ($this->delivery_module_id !== null)) {
            $this->aModuleRelatedByDeliveryModuleId = ChildModuleQuery::create()->findPk($this->delivery_module_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aModuleRelatedByDeliveryModuleId->addOffersRelatedByDeliveryModuleId($this);
             */
        }

        return $this->aModuleRelatedByDeliveryModuleId;
    }

    /**
     * Declares an association between this object and a ChildOrderAddress object.
     *
     * @param                  ChildOrderAddress $v
     * @return                 \OfferCreation\Model\Offer The current object (for fluent API support)
     * @throws PropelException
     */
    public function setOrderAddressRelatedByDeliveryOrderAddressId(ChildOrderAddress $v = null)
    {
        if ($v === null) {
            $this->setDeliveryOrderAddressId(NULL);
        } else {
            $this->setDeliveryOrderAddressId($v->getId());
        }

        $this->aOrderAddressRelatedByDeliveryOrderAddressId = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildOrderAddress object, it will not be re-added.
        if ($v !== null) {
            $v->addOfferRelatedByDeliveryOrderAddressId($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildOrderAddress object
     *
     * @param      ConnectionInterface $con Optional Connection object.
     * @return                 ChildOrderAddress The associated ChildOrderAddress object.
     * @throws PropelException
     */
    public function getOrderAddressRelatedByDeliveryOrderAddressId(ConnectionInterface $con = null)
    {
        if ($this->aOrderAddressRelatedByDeliveryOrderAddressId === null && ($this->delivery_order_address_id !== null)) {
            $this->aOrderAddressRelatedByDeliveryOrderAddressId = ChildOrderAddressQuery::create()->findPk($this->delivery_order_address_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aOrderAddressRelatedByDeliveryOrderAddressId->addOffersRelatedByDeliveryOrderAddressId($this);
             */
        }

        return $this->aOrderAddressRelatedByDeliveryOrderAddressId;
    }

    /**
     * Declares an association between this object and a ChildAdmin object.
     *
     * @param                  ChildAdmin $v
     * @return                 \OfferCreation\Model\Offer The current object (for fluent API support)
     * @throws PropelException
     */
    public function setAdmin(ChildAdmin $v = null)
    {
        if ($v === null) {
            $this->setEmployeeId(NULL);
        } else {
            $this->setEmployeeId($v->getId());
        }

        $this->aAdmin = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildAdmin object, it will not be re-added.
        if ($v !== null) {
            $v->addOffer($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildAdmin object
     *
     * @param      ConnectionInterface $con Optional Connection object.
     * @return                 ChildAdmin The associated ChildAdmin object.
     * @throws PropelException
     */
    public function getAdmin(ConnectionInterface $con = null)
    {
        if ($this->aAdmin === null && ($this->employee_id !== null)) {
            $this->aAdmin = ChildAdminQuery::create()->findPk($this->employee_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aAdmin->addOffers($this);
             */
        }

        return $this->aAdmin;
    }

    /**
     * Declares an association between this object and a ChildOrderAddress object.
     *
     * @param                  ChildOrderAddress $v
     * @return                 \OfferCreation\Model\Offer The current object (for fluent API support)
     * @throws PropelException
     */
    public function setOrderAddressRelatedByInvoiceOrderAddressId(ChildOrderAddress $v = null)
    {
        if ($v === null) {
            $this->setInvoiceOrderAddressId(NULL);
        } else {
            $this->setInvoiceOrderAddressId($v->getId());
        }

        $this->aOrderAddressRelatedByInvoiceOrderAddressId = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildOrderAddress object, it will not be re-added.
        if ($v !== null) {
            $v->addOfferRelatedByInvoiceOrderAddressId($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildOrderAddress object
     *
     * @param      ConnectionInterface $con Optional Connection object.
     * @return                 ChildOrderAddress The associated ChildOrderAddress object.
     * @throws PropelException
     */
    public function getOrderAddressRelatedByInvoiceOrderAddressId(ConnectionInterface $con = null)
    {
        if ($this->aOrderAddressRelatedByInvoiceOrderAddressId === null && ($this->invoice_order_address_id !== null)) {
            $this->aOrderAddressRelatedByInvoiceOrderAddressId = ChildOrderAddressQuery::create()->findPk($this->invoice_order_address_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aOrderAddressRelatedByInvoiceOrderAddressId->addOffersRelatedByInvoiceOrderAddressId($this);
             */
        }

        return $this->aOrderAddressRelatedByInvoiceOrderAddressId;
    }

    /**
     * Declares an association between this object and a ChildLang object.
     *
     * @param                  ChildLang $v
     * @return                 \OfferCreation\Model\Offer The current object (for fluent API support)
     * @throws PropelException
     */
    public function setLang(ChildLang $v = null)
    {
        if ($v === null) {
            $this->setLangId(NULL);
        } else {
            $this->setLangId($v->getId());
        }

        $this->aLang = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildLang object, it will not be re-added.
        if ($v !== null) {
            $v->addOffer($this);
        }

        return $this;
    }


    /**
     * Get the associated ChildLang object
     *
     * @param      ConnectionInterface $con Optional Connection object.
     * @return                 ChildLang The associated ChildLang object.
     * @throws PropelException
     */
    public function getLang(ConnectionInterface $con = null)
    {
        if ($this->aLang === null && ($this->lang_id !== null)) {
            $this->aLang = ChildLangQuery::create()->findPk($this->lang_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aLang->addOffers($this);
             */
        }

        return $this->aLang;
    }

    /**
     * Declares an association between this object and a ChildOrder object.
     *
     * @param                  ChildOrder $v
     * @return                 \OfferCreation\Model\Offer The current object (for fluent API support)
     * @throws PropelException
     */
    public function setOrderRelatedByOrderId(ChildOrder $v = null)
    {
        if ($v === null) {
            $this->setOrderId(NULL);
        } else {
            $this->setOrderId($v->getId());
        }

        $this->aOrderRelatedByOrderId = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildOrder object, it will not be re-added.
        if ($v !== null) {
            $v->addOfferRelatedByOrderId($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildOrder object
     *
     * @param      ConnectionInterface $con Optional Connection object.
     * @return                 ChildOrder The associated ChildOrder object.
     * @throws PropelException
     */
    public function getOrderRelatedByOrderId(ConnectionInterface $con = null)
    {
        if ($this->aOrderRelatedByOrderId === null && ($this->order_id !== null)) {
            $this->aOrderRelatedByOrderId = ChildOrderQuery::create()->findPk($this->order_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aOrderRelatedByOrderId->addOffersRelatedByOrderId($this);
             */
        }

        return $this->aOrderRelatedByOrderId;
    }

    /**
     * Declares an association between this object and a ChildOrder object.
     *
     * @param                  ChildOrder $v
     * @return                 \OfferCreation\Model\Offer The current object (for fluent API support)
     * @throws PropelException
     */
    public function setOrderRelatedByOrderRef(ChildOrder $v = null)
    {
        if ($v === null) {
            $this->setOrderRef(NULL);
        } else {
            $this->setOrderRef($v->getRef());
        }

        $this->aOrderRelatedByOrderRef = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildOrder object, it will not be re-added.
        if ($v !== null) {
            $v->addOfferRelatedByOrderRef($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildOrder object
     *
     * @param      ConnectionInterface $con Optional Connection object.
     * @return                 ChildOrder The associated ChildOrder object.
     * @throws PropelException
     */
    public function getOrderRelatedByOrderRef(ConnectionInterface $con = null)
    {
        if ($this->aOrderRelatedByOrderRef === null && (($this->order_ref !== "" && $this->order_ref !== null))) {
            $this->aOrderRelatedByOrderRef = ChildOrderQuery::create()
                ->filterByOfferRelatedByOrderRef($this) // here
                ->findOne($con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aOrderRelatedByOrderRef->addOffersRelatedByOrderRef($this);
             */
        }

        return $this->aOrderRelatedByOrderRef;
    }

    /**
     * Declares an association between this object and a ChildModule object.
     *
     * @param                  ChildModule $v
     * @return                 \OfferCreation\Model\Offer The current object (for fluent API support)
     * @throws PropelException
     */
    public function setModuleRelatedByPaymentModuleId(ChildModule $v = null)
    {
        if ($v === null) {
            $this->setPaymentModuleId(NULL);
        } else {
            $this->setPaymentModuleId($v->getId());
        }

        $this->aModuleRelatedByPaymentModuleId = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildModule object, it will not be re-added.
        if ($v !== null) {
            $v->addOfferRelatedByPaymentModuleId($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildModule object
     *
     * @param      ConnectionInterface $con Optional Connection object.
     * @return                 ChildModule The associated ChildModule object.
     * @throws PropelException
     */
    public function getModuleRelatedByPaymentModuleId(ConnectionInterface $con = null)
    {
        if ($this->aModuleRelatedByPaymentModuleId === null && ($this->payment_module_id !== null)) {
            $this->aModuleRelatedByPaymentModuleId = ChildModuleQuery::create()->findPk($this->payment_module_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aModuleRelatedByPaymentModuleId->addOffersRelatedByPaymentModuleId($this);
             */
        }
       
        return $this->aModuleRelatedByPaymentModuleId;
    }

    /**
     * Declares an association between this object and a ChildOrderStatus object.
     *
     * @param                  ChildOrderStatus $v
     * @return                 \OfferCreation\Model\Offer The current object (for fluent API support)
     * @throws PropelException
     */
    public function setOrderStatus(ChildOrderStatus $v = null)
    {
        if ($v === null) {
            $this->setStatusId(NULL);
        } else {
            $this->setStatusId($v->getId());
        }
  
        $this->aOrderStatus = $v;
    
        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildOrderStatus object, it will not be re-added.
        if ($v !== null) { 
        	$v->addOffer($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildOrderStatus object
     *
     * @param      ConnectionInterface $con Optional Connection object.
     * @return                 ChildOrderStatus The associated ChildOrderStatus object.
     * @throws PropelException
     */
    public function getOrderStatus(ConnectionInterface $con = null)
    {  
        if ($this->aOrderStatus === null && ($this->status_id !== null)) {
            $this->aOrderStatus = ChildOrderStatusQuery::create()->findPk($this->status_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aOrderStatus->addOffers($this);
             */
        }
        return $this->aOrderStatus;
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
        if ('OfferProduct' == $relationName) {
            return $this->initOfferProducts();
        }
        if ('OfferVersion' == $relationName) {
            return $this->initOfferVersions();
        }
    }

    /**
     * Clears out the collOfferProducts collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addOfferProducts()
     */
    public function clearOfferProducts()
    {
        $this->collOfferProducts = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collOfferProducts collection loaded partially.
     */
    public function resetPartialOfferProducts($v = true)
    {
        $this->collOfferProductsPartial = $v;
    }

    /**
     * Initializes the collOfferProducts collection.
     *
     * By default this just sets the collOfferProducts collection to an empty array (like clearcollOfferProducts());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initOfferProducts($overrideExisting = true)
    {
        if (null !== $this->collOfferProducts && !$overrideExisting) {
            return;
        }
        $this->collOfferProducts = new ObjectCollection();
        $this->collOfferProducts->setModel('\OfferCreation\Model\OfferProduct');
    }

    /**
     * Gets an array of ChildOfferProduct objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildOffer is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return Collection|ChildOfferProduct[] List of ChildOfferProduct objects
     * @throws PropelException
     */
    public function getOfferProducts($criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collOfferProductsPartial && !$this->isNew();
        if (null === $this->collOfferProducts || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collOfferProducts) {
                // return empty collection
                $this->initOfferProducts();
            } else {
                $collOfferProducts = ChildOfferProductQuery::create(null, $criteria)
                    ->filterByOffer($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collOfferProductsPartial && count($collOfferProducts)) {
                        $this->initOfferProducts(false);

                        foreach ($collOfferProducts as $obj) {
                            if (false == $this->collOfferProducts->contains($obj)) {
                                $this->collOfferProducts->append($obj);
                            }
                        }

                        $this->collOfferProductsPartial = true;
                    }

                    reset($collOfferProducts);

                    return $collOfferProducts;
                }

                if ($partial && $this->collOfferProducts) {
                    foreach ($this->collOfferProducts as $obj) {
                        if ($obj->isNew()) {
                            $collOfferProducts[] = $obj;
                        }
                    }
                }

                $this->collOfferProducts = $collOfferProducts;
                $this->collOfferProductsPartial = false;
            }
        }

        return $this->collOfferProducts;
    }

    /**
     * Sets a collection of OfferProduct objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $offerProducts A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return   ChildOffer The current object (for fluent API support)
     */
    public function setOfferProducts(Collection $offerProducts, ConnectionInterface $con = null)
    {
        $offerProductsToDelete = $this->getOfferProducts(new Criteria(), $con)->diff($offerProducts);

        
        $this->offerProductsScheduledForDeletion = $offerProductsToDelete;

        foreach ($offerProductsToDelete as $offerProductRemoved) {
            $offerProductRemoved->setOffer(null);
        }

        $this->collOfferProducts = null;
        foreach ($offerProducts as $offerProduct) {
            $this->addOfferProduct($offerProduct);
        }

        $this->collOfferProducts = $offerProducts;
        $this->collOfferProductsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related OfferProduct objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related OfferProduct objects.
     * @throws PropelException
     */
    public function countOfferProducts(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collOfferProductsPartial && !$this->isNew();
        if (null === $this->collOfferProducts || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collOfferProducts) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getOfferProducts());
            }

            $query = ChildOfferProductQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByOffer($this)
                ->count($con);
        }

        return count($this->collOfferProducts);
    }

    /**
     * Method called to associate a ChildOfferProduct object to this object
     * through the ChildOfferProduct foreign key attribute.
     *
     * @param    ChildOfferProduct $l ChildOfferProduct
     * @return   \OfferCreation\Model\Offer The current object (for fluent API support)
     */
    public function addOfferProduct(ChildOfferProduct $l)
    {
        if ($this->collOfferProducts === null) {
            $this->initOfferProducts();
            $this->collOfferProductsPartial = true;
        }

        if (!in_array($l, $this->collOfferProducts->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddOfferProduct($l);
        }

        return $this;
    }

    /**
     * @param OfferProduct $offerProduct The offerProduct object to add.
     */
    protected function doAddOfferProduct($offerProduct)
    {
        $this->collOfferProducts[]= $offerProduct;
        $offerProduct->setOffer($this);
    }

    /**
     * @param  OfferProduct $offerProduct The offerProduct object to remove.
     * @return ChildOffer The current object (for fluent API support)
     */
    public function removeOfferProduct($offerProduct)
    {
        if ($this->getOfferProducts()->contains($offerProduct)) {
            $this->collOfferProducts->remove($this->collOfferProducts->search($offerProduct));
            if (null === $this->offerProductsScheduledForDeletion) {
                $this->offerProductsScheduledForDeletion = clone $this->collOfferProducts;
                $this->offerProductsScheduledForDeletion->clear();
            }
            $this->offerProductsScheduledForDeletion[]= clone $offerProduct;
            $offerProduct->setOffer(null);
        }

        return $this;
    }

    /**
     * Clears out the collOfferVersions collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addOfferVersions()
     */
    public function clearOfferVersions()
    {
        $this->collOfferVersions = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collOfferVersions collection loaded partially.
     */
    public function resetPartialOfferVersions($v = true)
    {
        $this->collOfferVersionsPartial = $v;
    }

    /**
     * Initializes the collOfferVersions collection.
     *
     * By default this just sets the collOfferVersions collection to an empty array (like clearcollOfferVersions());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initOfferVersions($overrideExisting = true)
    {
        if (null !== $this->collOfferVersions && !$overrideExisting) {
            return;
        }
        $this->collOfferVersions = new ObjectCollection();
        $this->collOfferVersions->setModel('\OfferCreation\Model\OfferVersion');
    }

    /**
     * Gets an array of ChildOfferVersion objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildOffer is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return Collection|ChildOfferVersion[] List of ChildOfferVersion objects
     * @throws PropelException
     */
    public function getOfferVersions($criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collOfferVersionsPartial && !$this->isNew();
        if (null === $this->collOfferVersions || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collOfferVersions) {
                // return empty collection
                $this->initOfferVersions();
            } else {
                $collOfferVersions = ChildOfferVersionQuery::create(null, $criteria)
                    ->filterByOffer($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collOfferVersionsPartial && count($collOfferVersions)) {
                        $this->initOfferVersions(false);

                        foreach ($collOfferVersions as $obj) {
                            if (false == $this->collOfferVersions->contains($obj)) {
                                $this->collOfferVersions->append($obj);
                            }
                        }

                        $this->collOfferVersionsPartial = true;
                    }

                    reset($collOfferVersions);

                    return $collOfferVersions;
                }

                if ($partial && $this->collOfferVersions) {
                    foreach ($this->collOfferVersions as $obj) {
                        if ($obj->isNew()) {
                            $collOfferVersions[] = $obj;
                        }
                    }
                }

                $this->collOfferVersions = $collOfferVersions;
                $this->collOfferVersionsPartial = false;
            }
        }

        return $this->collOfferVersions;
    }

    /**
     * Sets a collection of OfferVersion objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $offerVersions A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return   ChildOffer The current object (for fluent API support)
     */
    public function setOfferVersions(Collection $offerVersions, ConnectionInterface $con = null)
    {
        $offerVersionsToDelete = $this->getOfferVersions(new Criteria(), $con)->diff($offerVersions);

        
        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->offerVersionsScheduledForDeletion = clone $offerVersionsToDelete;

        foreach ($offerVersionsToDelete as $offerVersionRemoved) {
            $offerVersionRemoved->setOffer(null);
        }

        $this->collOfferVersions = null;
        foreach ($offerVersions as $offerVersion) {
            $this->addOfferVersion($offerVersion);
        }

        $this->collOfferVersions = $offerVersions;
        $this->collOfferVersionsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related OfferVersion objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related OfferVersion objects.
     * @throws PropelException
     */
    public function countOfferVersions(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collOfferVersionsPartial && !$this->isNew();
        if (null === $this->collOfferVersions || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collOfferVersions) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getOfferVersions());
            }

            $query = ChildOfferVersionQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByOffer($this)
                ->count($con);
        }

        return count($this->collOfferVersions);
    }

    /**
     * Method called to associate a ChildOfferVersion object to this object
     * through the ChildOfferVersion foreign key attribute.
     *
     * @param    ChildOfferVersion $l ChildOfferVersion
     * @return   \OfferCreation\Model\Offer The current object (for fluent API support)
     */
    public function addOfferVersion(ChildOfferVersion $l)
    {
        if ($this->collOfferVersions === null) {
            $this->initOfferVersions();
            $this->collOfferVersionsPartial = true;
        }

        if (!in_array($l, $this->collOfferVersions->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddOfferVersion($l);
        }

        return $this;
    }

    /**
     * @param OfferVersion $offerVersion The offerVersion object to add.
     */
    protected function doAddOfferVersion($offerVersion)
    {
        $this->collOfferVersions[]= $offerVersion;
        $offerVersion->setOffer($this);
    }

    /**
     * @param  OfferVersion $offerVersion The offerVersion object to remove.
     * @return ChildOffer The current object (for fluent API support)
     */
    public function removeOfferVersion($offerVersion)
    {
        if ($this->getOfferVersions()->contains($offerVersion)) {
            $this->collOfferVersions->remove($this->collOfferVersions->search($offerVersion));
            if (null === $this->offerVersionsScheduledForDeletion) {
                $this->offerVersionsScheduledForDeletion = clone $this->collOfferVersions;
                $this->offerVersionsScheduledForDeletion->clear();
            }
            $this->offerVersionsScheduledForDeletion[]= clone $offerVersion;
            $offerVersion->setOffer(null);
        }

        return $this;
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->id = null;
        $this->ref = null;
        $this->order_id = null;
        $this->order_ref = null;
        $this->customer_id = null;
        $this->employee_id = null;
        $this->invoice_order_address_id = null;
        $this->delivery_order_address_id = null;
        $this->invoice_date = null;
        $this->currency_id = null;
        $this->currency_rate = null;
        $this->transaction_ref = null;
        $this->delivery_ref = null;
        $this->invoice_ref = null;
        $this->discount = null;
        $this->postage = null;
        $this->postage_tax = null;
        $this->postage_tax_rule_title = null;
        $this->payment_module_id = null;
        $this->delivery_module_id = null;
        $this->status_id = null;
        $this->lang_id = null;
        $this->cart_id = null;
        $this->created_at = null;
        $this->updated_at = null;
        $this->version = null;
        $this->version_created_at = null;
        $this->version_created_by = null;
        $this->note_employee = null;
        $this->chat_id = null;
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
            if ($this->collOfferProducts) {
                foreach ($this->collOfferProducts as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collOfferVersions) {
                foreach ($this->collOfferVersions as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collOfferProducts = null;
        $this->collOfferVersions = null;
        $this->aOfferChat = null;
        $this->aCurrency = null;
        $this->aCustomer = null;
        $this->aModuleRelatedByDeliveryModuleId = null;
        $this->aOrderAddressRelatedByDeliveryOrderAddressId = null;
        $this->aAdmin = null;
        $this->aOrderAddressRelatedByInvoiceOrderAddressId = null;
        $this->aLang = null;
        $this->aOrderRelatedByOrderId = null;
        $this->aOrderRelatedByOrderRef = null;
        $this->aModuleRelatedByPaymentModuleId = null;
        $this->aOrderStatus = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(OfferTableMap::DEFAULT_STRING_FORMAT);
    }

    
    // timestampable behavior
    
    /**
     * Mark the current object so that the update date doesn't get updated during next save
     *
     * @return     ChildOffer The current object (for fluent API support)
     */
    public function keepUpdateDateUnchanged()
    {
    	$this->modifiedColumns[OfferTableMap::UPDATED_AT] = true;
    	
    	return $this;
    }
    // versionable behavior
    
    /**
     * Enforce a new Version of this object upon next save.
     *
     * @return \OfferCreation\Model\Offer
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
    	
    	if (ChildOfferQuery::isVersioningEnabled() && ($this->isNew() || $this->isModified()) || $this->isDeleted()) {
    		return true;
    	}
    	
    	return false;
    }
    
    /**
     * Creates a version of the current object and saves it.
     *
     * @param   ConnectionInterface $con the connection to use
     *
     * @return  ChildOfferVersion A version object
     */
    public function addVersion($con = null)
    {
    	$this->enforceVersion = false;
    	
    	$version = new ChildOfferVersion();
    	$version->setId($this->getId());
    	$version->setRef($this->getRef());
    	$version->setOrderId($this->getOrderId());
    	$version->setOrderRef($this->getOrderRef());
    	$version->setCustomerId($this->getCustomerId());
    	$version->setEmployeeId($this->getEmployeeId());
    	$version->setInvoiceOrderAddressId($this->getInvoiceOrderAddressId());
    	$version->setDeliveryOrderAddressId($this->getDeliveryOrderAddressId());
    	$version->setInvoiceDate($this->getInvoiceDate());
    	$version->setCurrencyId($this->getCurrencyId());
    	$version->setCurrencyRate($this->getCurrencyRate());
    	$version->setTransactionRef($this->getTransactionRef());
    	$version->setDeliveryRef($this->getDeliveryRef());
    	$version->setInvoiceRef($this->getInvoiceRef());
    	$version->setDiscount($this->getDiscount());
    	$version->setPostage($this->getPostage());
    	$version->setPostageTax($this->getPostageTax());
    	$version->setPostageTaxRuleTitle($this->getPostageTaxRuleTitle());
    	$version->setPaymentModuleId($this->getPaymentModuleId());
    	$version->setDeliveryModuleId($this->getDeliveryModuleId());
    	$version->setStatusId($this->getStatusId());
    	$version->setLangId($this->getLangId());
    	$version->setCartId($this->getCartId());
    	$version->setNoteEmployee($this->getNoteEmployee());
    	$version->setChatId($this->getChatId());
    	$version->setCreatedAt($this->getCreatedAt());
    	$version->setUpdatedAt($this->getUpdatedAt());
    	$version->setVersion($this->getVersion());
    	$version->setVersionCreatedAt($this->getVersionCreatedAt());
    	$version->setVersionCreatedBy($this->getVersionCreatedBy());
    	$version->setOffer($this);
    	$version->save($con);
    	
    	return $version;
    }
    
    /**
     * Sets the properties of the current object to the value they had at a specific version
     *
     * @param   integer $versionNumber The version number to read
     * @param   ConnectionInterface $con The connection to use
     *
     * @return  ChildOffer The current object (for fluent API support)
     */
    public function toVersion($versionNumber, $con = null)
    {
    	$version = $this->getOneVersion($versionNumber, $con);
    	if (!$version) {
    		throw new PropelException(sprintf('No ChildOffer object found with version %d', $version));
    	}
    	$this->populateFromVersion($version, $con);
    	
    	return $this;
    }
    
    /**
     * Sets the properties of the current object to the value they had at a specific version
     *
     * @param ChildOfferVersion $version The version object to use
     * @param ConnectionInterface   $con the connection to use
     * @param array                 $loadedObjects objects that been loaded in a chain of populateFromVersion calls on referrer or fk objects.
     *
     * @return ChildOffer The current object (for fluent API support)
     */
    public function populateFromVersion($version, $con = null, &$loadedObjects = array())
    {
    	$loadedObjects['ChildOffer'][$version->getId()][$version->getVersion()] = $this;
    	$this->setId($version->getId());
    	$this->setRef($version->getRef());
    	$this->setOrderId($version->getOrderId());
    	$this->setOrderRef($version->getOrderRef());
    	$this->setCustomerId($version->getCustomerId());
    	$this->setEmployeeId($version->getEmployeeId());
    	$this->setInvoiceOrderAddressId($version->getInvoiceOrderAddressId());
    	$this->setDeliveryOrderAddressId($version->getDeliveryOrderAddressId());
    	$this->setInvoiceDate($version->getInvoiceDate());
    	$this->setCurrencyId($version->getCurrencyId());
    	$this->setCurrencyRate($version->getCurrencyRate());
    	$this->setTransactionRef($version->getTransactionRef());
    	$this->setDeliveryRef($version->getDeliveryRef());
    	$this->setInvoiceRef($version->getInvoiceRef());
    	$this->setDiscount($version->getDiscount());
    	$this->setPostage($version->getPostage());
    	$this->setPostageTax($version->getPostageTax());
    	$this->setPostageTaxRuleTitle($version->getPostageTaxRuleTitle());
    	$this->setPaymentModuleId($version->getPaymentModuleId());
    	$this->setDeliveryModuleId($version->getDeliveryModuleId());
    	$this->setStatusId($version->getStatusId());
    	$this->setLangId($version->getLangId());
    	$this->setCartId($version->getCartId());
    	$this->setNoteEmployee($version->getNoteEmployee());
    	$this->setChatId($version->getChatId());
    	$this->setCreatedAt($version->getCreatedAt());
    	$this->setUpdatedAt($version->getUpdatedAt());
    	$this->setVersion($version->getVersion());
    	$this->setVersionCreatedAt($version->getVersionCreatedAt());
    	$this->setVersionCreatedBy($version->getVersionCreatedBy());
    	
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
    	$v = ChildOfferVersionQuery::create()
    	->filterByOffer($this)
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
     * @return  ChildOfferVersion A version object
     */
    public function getOneVersion($versionNumber, $con = null)
    {
    	return ChildOfferVersionQuery::create()
    	->filterByOffer($this)
    	->filterByVersion($versionNumber)
    	->findOne($con);
    }
    
    /**
     * Gets all the versions of this object, in incremental order
     *
     * @param   ConnectionInterface $con the connection to use
     *
     * @return  ObjectCollection A list of ChildOfferVersion objects
     */
    public function getAllVersions($con = null)
    {
    	$criteria = new Criteria();
    	$criteria->addAscendingOrderByColumn(OfferVersionTableMap::VERSION);
    	
    	return $this->getOfferVersions($criteria, $con);
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
     * @return PropelCollection|array \OfferCreation\Model\OfferVersion[] List of \OfferCreation\Model\OfferVersion objects
     */
    public function getLastVersions($number = 10, $criteria = null, $con = null)
    {
    	$criteria = ChildOfferVersionQuery::create(null, $criteria);
    	$criteria->addDescendingOrderByColumn(OfferVersionTableMap::VERSION);
    	$criteria->limit($number);
    	
    	return $this->getOfferVersions($criteria, $con);
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
