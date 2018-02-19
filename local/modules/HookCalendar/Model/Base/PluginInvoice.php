<?php

namespace HookCalendar\Model\Base;

use \DateTime;
use \Exception;
use \PDO;
use HookCalendar\Model\PluginInvoiceQuery as ChildPluginInvoiceQuery;
use HookCalendar\Model\Map\PluginInvoiceTableMap;
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

abstract class PluginInvoice implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\HookCalendar\\Model\\Map\\PluginInvoiceTableMap';


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
     * The value for the uuid field.
     * @var        string
     */
    protected $uuid;

    /**
     * The value for the order_id field.
     * @var        string
     */
    protected $order_id;

    /**
     * The value for the foreign_id field.
     * @var        int
     */
    protected $foreign_id;

    /**
     * The value for the issue_date field.
     * @var        string
     */
    protected $issue_date;

    /**
     * The value for the due_date field.
     * @var        string
     */
    protected $due_date;

    /**
     * The value for the created field.
     * @var        string
     */
    protected $created;

    /**
     * The value for the modified field.
     * @var        string
     */
    protected $modified;

    /**
     * The value for the status field.
     * @var        string
     */
    protected $status;

    /**
     * The value for the payment_method field.
     * @var        string
     */
    protected $payment_method;

    /**
     * The value for the cc_type field.
     * @var        resource
     */
    protected $cc_type;

    /**
     * The value for the cc_num field.
     * @var        resource
     */
    protected $cc_num;

    /**
     * The value for the cc_exp_month field.
     * @var        resource
     */
    protected $cc_exp_month;

    /**
     * The value for the cc_exp_year field.
     * @var        resource
     */
    protected $cc_exp_year;

    /**
     * The value for the cc_code field.
     * @var        resource
     */
    protected $cc_code;

    /**
     * The value for the txn_id field.
     * @var        string
     */
    protected $txn_id;

    /**
     * The value for the processed_on field.
     * @var        string
     */
    protected $processed_on;

    /**
     * The value for the subtotal field.
     * @var        string
     */
    protected $subtotal;

    /**
     * The value for the discount field.
     * @var        string
     */
    protected $discount;

    /**
     * The value for the tax field.
     * @var        string
     */
    protected $tax;

    /**
     * The value for the shipping field.
     * @var        string
     */
    protected $shipping;

    /**
     * The value for the total field.
     * @var        string
     */
    protected $total;

    /**
     * The value for the paid_deposit field.
     * @var        string
     */
    protected $paid_deposit;

    /**
     * The value for the amount_due field.
     * @var        string
     */
    protected $amount_due;

    /**
     * The value for the currency field.
     * @var        string
     */
    protected $currency;

    /**
     * The value for the notes field.
     * @var        string
     */
    protected $notes;

    /**
     * The value for the y_logo field.
     * @var        string
     */
    protected $y_logo;

    /**
     * The value for the y_company field.
     * @var        string
     */
    protected $y_company;

    /**
     * The value for the y_name field.
     * @var        string
     */
    protected $y_name;

    /**
     * The value for the y_street_address field.
     * @var        string
     */
    protected $y_street_address;

    /**
     * The value for the y_country field.
     * @var        int
     */
    protected $y_country;

    /**
     * The value for the y_city field.
     * @var        string
     */
    protected $y_city;

    /**
     * The value for the y_state field.
     * @var        string
     */
    protected $y_state;

    /**
     * The value for the y_zip field.
     * @var        string
     */
    protected $y_zip;

    /**
     * The value for the y_phone field.
     * @var        string
     */
    protected $y_phone;

    /**
     * The value for the y_fax field.
     * @var        string
     */
    protected $y_fax;

    /**
     * The value for the y_email field.
     * @var        string
     */
    protected $y_email;

    /**
     * The value for the y_url field.
     * @var        string
     */
    protected $y_url;

    /**
     * The value for the b_billing_address field.
     * @var        string
     */
    protected $b_billing_address;

    /**
     * The value for the b_company field.
     * @var        string
     */
    protected $b_company;

    /**
     * The value for the b_name field.
     * @var        string
     */
    protected $b_name;

    /**
     * The value for the b_address field.
     * @var        string
     */
    protected $b_address;

    /**
     * The value for the b_street_address field.
     * @var        string
     */
    protected $b_street_address;

    /**
     * The value for the b_country field.
     * @var        int
     */
    protected $b_country;

    /**
     * The value for the b_city field.
     * @var        string
     */
    protected $b_city;

    /**
     * The value for the b_state field.
     * @var        string
     */
    protected $b_state;

    /**
     * The value for the b_zip field.
     * @var        string
     */
    protected $b_zip;

    /**
     * The value for the b_phone field.
     * @var        string
     */
    protected $b_phone;

    /**
     * The value for the b_fax field.
     * @var        string
     */
    protected $b_fax;

    /**
     * The value for the b_email field.
     * @var        string
     */
    protected $b_email;

    /**
     * The value for the b_url field.
     * @var        string
     */
    protected $b_url;

    /**
     * The value for the s_shipping_address field.
     * @var        string
     */
    protected $s_shipping_address;

    /**
     * The value for the s_company field.
     * @var        string
     */
    protected $s_company;

    /**
     * The value for the s_name field.
     * @var        string
     */
    protected $s_name;

    /**
     * The value for the s_address field.
     * @var        string
     */
    protected $s_address;

    /**
     * The value for the s_street_address field.
     * @var        string
     */
    protected $s_street_address;

    /**
     * The value for the s_country field.
     * @var        int
     */
    protected $s_country;

    /**
     * The value for the s_city field.
     * @var        string
     */
    protected $s_city;

    /**
     * The value for the s_state field.
     * @var        string
     */
    protected $s_state;

    /**
     * The value for the s_zip field.
     * @var        string
     */
    protected $s_zip;

    /**
     * The value for the s_phone field.
     * @var        string
     */
    protected $s_phone;

    /**
     * The value for the s_fax field.
     * @var        string
     */
    protected $s_fax;

    /**
     * The value for the s_email field.
     * @var        string
     */
    protected $s_email;

    /**
     * The value for the s_url field.
     * @var        string
     */
    protected $s_url;

    /**
     * The value for the s_date field.
     * @var        string
     */
    protected $s_date;

    /**
     * The value for the s_terms field.
     * @var        string
     */
    protected $s_terms;

    /**
     * The value for the s_is_shipped field.
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $s_is_shipped;

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
        $this->s_is_shipped = false;
    }

    /**
     * Initializes internal state of HookCalendar\Model\Base\PluginInvoice object.
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
     * Compares this with another <code>PluginInvoice</code> instance.  If
     * <code>obj</code> is an instance of <code>PluginInvoice</code>, delegates to
     * <code>equals(PluginInvoice)</code>.  Otherwise, returns <code>false</code>.
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
     * @return PluginInvoice The current object, for fluid interface
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
     * @return PluginInvoice The current object, for fluid interface
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
     * Get the [uuid] column value.
     *
     * @return   string
     */
    public function getUuid()
    {

        return $this->uuid;
    }

    /**
     * Get the [order_id] column value.
     *
     * @return   string
     */
    public function getOrderId()
    {

        return $this->order_id;
    }

    /**
     * Get the [foreign_id] column value.
     *
     * @return   int
     */
    public function getForeignId()
    {

        return $this->foreign_id;
    }

    /**
     * Get the [optionally formatted] temporal [issue_date] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw \DateTime object will be returned.
     *
     * @return mixed Formatted date/time value as string or \DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getIssueDate($format = NULL)
    {
        if ($format === null) {
            return $this->issue_date;
        } else {
            return $this->issue_date instanceof \DateTime ? $this->issue_date->format($format) : null;
        }
    }

    /**
     * Get the [optionally formatted] temporal [due_date] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw \DateTime object will be returned.
     *
     * @return mixed Formatted date/time value as string or \DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getDueDate($format = NULL)
    {
        if ($format === null) {
            return $this->due_date;
        } else {
            return $this->due_date instanceof \DateTime ? $this->due_date->format($format) : null;
        }
    }

    /**
     * Get the [optionally formatted] temporal [created] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw \DateTime object will be returned.
     *
     * @return mixed Formatted date/time value as string or \DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getCreated($format = NULL)
    {
        if ($format === null) {
            return $this->created;
        } else {
            return $this->created instanceof \DateTime ? $this->created->format($format) : null;
        }
    }

    /**
     * Get the [optionally formatted] temporal [modified] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw \DateTime object will be returned.
     *
     * @return mixed Formatted date/time value as string or \DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getModified($format = NULL)
    {
        if ($format === null) {
            return $this->modified;
        } else {
            return $this->modified instanceof \DateTime ? $this->modified->format($format) : null;
        }
    }

    /**
     * Get the [status] column value.
     *
     * @return   string
     */
    public function getStatus()
    {

        return $this->status;
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
     * Get the [cc_type] column value.
     *
     * @return   resource
     */
    public function getCcType()
    {

        return $this->cc_type;
    }

    /**
     * Get the [cc_num] column value.
     *
     * @return   resource
     */
    public function getCcNum()
    {

        return $this->cc_num;
    }

    /**
     * Get the [cc_exp_month] column value.
     *
     * @return   resource
     */
    public function getCcExpMonth()
    {

        return $this->cc_exp_month;
    }

    /**
     * Get the [cc_exp_year] column value.
     *
     * @return   resource
     */
    public function getCcExpYear()
    {

        return $this->cc_exp_year;
    }

    /**
     * Get the [cc_code] column value.
     *
     * @return   resource
     */
    public function getCcCode()
    {

        return $this->cc_code;
    }

    /**
     * Get the [txn_id] column value.
     *
     * @return   string
     */
    public function getTxnId()
    {

        return $this->txn_id;
    }

    /**
     * Get the [optionally formatted] temporal [processed_on] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw \DateTime object will be returned.
     *
     * @return mixed Formatted date/time value as string or \DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getProcessedOn($format = NULL)
    {
        if ($format === null) {
            return $this->processed_on;
        } else {
            return $this->processed_on instanceof \DateTime ? $this->processed_on->format($format) : null;
        }
    }

    /**
     * Get the [subtotal] column value.
     *
     * @return   string
     */
    public function getSubtotal()
    {

        return $this->subtotal;
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
     * Get the [tax] column value.
     *
     * @return   string
     */
    public function getTax()
    {

        return $this->tax;
    }

    /**
     * Get the [shipping] column value.
     *
     * @return   string
     */
    public function getShipping()
    {

        return $this->shipping;
    }

    /**
     * Get the [total] column value.
     *
     * @return   string
     */
    public function getTotal()
    {

        return $this->total;
    }

    /**
     * Get the [paid_deposit] column value.
     *
     * @return   string
     */
    public function getPaidDeposit()
    {

        return $this->paid_deposit;
    }

    /**
     * Get the [amount_due] column value.
     *
     * @return   string
     */
    public function getAmountDue()
    {

        return $this->amount_due;
    }

    /**
     * Get the [currency] column value.
     *
     * @return   string
     */
    public function getCurrency()
    {

        return $this->currency;
    }

    /**
     * Get the [notes] column value.
     *
     * @return   string
     */
    public function getNotes()
    {

        return $this->notes;
    }

    /**
     * Get the [y_logo] column value.
     *
     * @return   string
     */
    public function getYLogo()
    {

        return $this->y_logo;
    }

    /**
     * Get the [y_company] column value.
     *
     * @return   string
     */
    public function getYCompany()
    {

        return $this->y_company;
    }

    /**
     * Get the [y_name] column value.
     *
     * @return   string
     */
    public function getYName()
    {

        return $this->y_name;
    }

    /**
     * Get the [y_street_address] column value.
     *
     * @return   string
     */
    public function getYStreetAddress()
    {

        return $this->y_street_address;
    }

    /**
     * Get the [y_country] column value.
     *
     * @return   int
     */
    public function getYCountry()
    {

        return $this->y_country;
    }

    /**
     * Get the [y_city] column value.
     *
     * @return   string
     */
    public function getYCity()
    {

        return $this->y_city;
    }

    /**
     * Get the [y_state] column value.
     *
     * @return   string
     */
    public function getYState()
    {

        return $this->y_state;
    }

    /**
     * Get the [y_zip] column value.
     *
     * @return   string
     */
    public function getYZip()
    {

        return $this->y_zip;
    }

    /**
     * Get the [y_phone] column value.
     *
     * @return   string
     */
    public function getYPhone()
    {

        return $this->y_phone;
    }

    /**
     * Get the [y_fax] column value.
     *
     * @return   string
     */
    public function getYFax()
    {

        return $this->y_fax;
    }

    /**
     * Get the [y_email] column value.
     *
     * @return   string
     */
    public function getYEmail()
    {

        return $this->y_email;
    }

    /**
     * Get the [y_url] column value.
     *
     * @return   string
     */
    public function getYUrl()
    {

        return $this->y_url;
    }

    /**
     * Get the [b_billing_address] column value.
     *
     * @return   string
     */
    public function getBBillingAddress()
    {

        return $this->b_billing_address;
    }

    /**
     * Get the [b_company] column value.
     *
     * @return   string
     */
    public function getBCompany()
    {

        return $this->b_company;
    }

    /**
     * Get the [b_name] column value.
     *
     * @return   string
     */
    public function getBName()
    {

        return $this->b_name;
    }

    /**
     * Get the [b_address] column value.
     *
     * @return   string
     */
    public function getBAddress()
    {

        return $this->b_address;
    }

    /**
     * Get the [b_street_address] column value.
     *
     * @return   string
     */
    public function getBStreetAddress()
    {

        return $this->b_street_address;
    }

    /**
     * Get the [b_country] column value.
     *
     * @return   int
     */
    public function getBCountry()
    {

        return $this->b_country;
    }

    /**
     * Get the [b_city] column value.
     *
     * @return   string
     */
    public function getBCity()
    {

        return $this->b_city;
    }

    /**
     * Get the [b_state] column value.
     *
     * @return   string
     */
    public function getBState()
    {

        return $this->b_state;
    }

    /**
     * Get the [b_zip] column value.
     *
     * @return   string
     */
    public function getBZip()
    {

        return $this->b_zip;
    }

    /**
     * Get the [b_phone] column value.
     *
     * @return   string
     */
    public function getBPhone()
    {

        return $this->b_phone;
    }

    /**
     * Get the [b_fax] column value.
     *
     * @return   string
     */
    public function getBFax()
    {

        return $this->b_fax;
    }

    /**
     * Get the [b_email] column value.
     *
     * @return   string
     */
    public function getBEmail()
    {

        return $this->b_email;
    }

    /**
     * Get the [b_url] column value.
     *
     * @return   string
     */
    public function getBUrl()
    {

        return $this->b_url;
    }

    /**
     * Get the [s_shipping_address] column value.
     *
     * @return   string
     */
    public function getSShippingAddress()
    {

        return $this->s_shipping_address;
    }

    /**
     * Get the [s_company] column value.
     *
     * @return   string
     */
    public function getSCompany()
    {

        return $this->s_company;
    }

    /**
     * Get the [s_name] column value.
     *
     * @return   string
     */
    public function getSName()
    {

        return $this->s_name;
    }

    /**
     * Get the [s_address] column value.
     *
     * @return   string
     */
    public function getSAddress()
    {

        return $this->s_address;
    }

    /**
     * Get the [s_street_address] column value.
     *
     * @return   string
     */
    public function getSStreetAddress()
    {

        return $this->s_street_address;
    }

    /**
     * Get the [s_country] column value.
     *
     * @return   int
     */
    public function getSCountry()
    {

        return $this->s_country;
    }

    /**
     * Get the [s_city] column value.
     *
     * @return   string
     */
    public function getSCity()
    {

        return $this->s_city;
    }

    /**
     * Get the [s_state] column value.
     *
     * @return   string
     */
    public function getSState()
    {

        return $this->s_state;
    }

    /**
     * Get the [s_zip] column value.
     *
     * @return   string
     */
    public function getSZip()
    {

        return $this->s_zip;
    }

    /**
     * Get the [s_phone] column value.
     *
     * @return   string
     */
    public function getSPhone()
    {

        return $this->s_phone;
    }

    /**
     * Get the [s_fax] column value.
     *
     * @return   string
     */
    public function getSFax()
    {

        return $this->s_fax;
    }

    /**
     * Get the [s_email] column value.
     *
     * @return   string
     */
    public function getSEmail()
    {

        return $this->s_email;
    }

    /**
     * Get the [s_url] column value.
     *
     * @return   string
     */
    public function getSUrl()
    {

        return $this->s_url;
    }

    /**
     * Get the [optionally formatted] temporal [s_date] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw \DateTime object will be returned.
     *
     * @return mixed Formatted date/time value as string or \DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getSDate($format = NULL)
    {
        if ($format === null) {
            return $this->s_date;
        } else {
            return $this->s_date instanceof \DateTime ? $this->s_date->format($format) : null;
        }
    }

    /**
     * Get the [s_terms] column value.
     *
     * @return   string
     */
    public function getSTerms()
    {

        return $this->s_terms;
    }

    /**
     * Get the [s_is_shipped] column value.
     *
     * @return   boolean
     */
    public function getSIsShipped()
    {

        return $this->s_is_shipped;
    }

    /**
     * Set the value of [id] column.
     *
     * @param      int $v new value
     * @return   \HookCalendar\Model\PluginInvoice The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[PluginInvoiceTableMap::ID] = true;
        }


        return $this;
    } // setId()

    /**
     * Set the value of [uuid] column.
     *
     * @param      string $v new value
     * @return   \HookCalendar\Model\PluginInvoice The current object (for fluent API support)
     */
    public function setUuid($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->uuid !== $v) {
            $this->uuid = $v;
            $this->modifiedColumns[PluginInvoiceTableMap::UUID] = true;
        }


        return $this;
    } // setUuid()

    /**
     * Set the value of [order_id] column.
     *
     * @param      string $v new value
     * @return   \HookCalendar\Model\PluginInvoice The current object (for fluent API support)
     */
    public function setOrderId($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->order_id !== $v) {
            $this->order_id = $v;
            $this->modifiedColumns[PluginInvoiceTableMap::ORDER_ID] = true;
        }


        return $this;
    } // setOrderId()

    /**
     * Set the value of [foreign_id] column.
     *
     * @param      int $v new value
     * @return   \HookCalendar\Model\PluginInvoice The current object (for fluent API support)
     */
    public function setForeignId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->foreign_id !== $v) {
            $this->foreign_id = $v;
            $this->modifiedColumns[PluginInvoiceTableMap::FOREIGN_ID] = true;
        }


        return $this;
    } // setForeignId()

    /**
     * Sets the value of [issue_date] column to a normalized version of the date/time value specified.
     *
     * @param      mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return   \HookCalendar\Model\PluginInvoice The current object (for fluent API support)
     */
    public function setIssueDate($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->issue_date !== null || $dt !== null) {
            if ($dt !== $this->issue_date) {
                $this->issue_date = $dt;
                $this->modifiedColumns[PluginInvoiceTableMap::ISSUE_DATE] = true;
            }
        } // if either are not null


        return $this;
    } // setIssueDate()

    /**
     * Sets the value of [due_date] column to a normalized version of the date/time value specified.
     *
     * @param      mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return   \HookCalendar\Model\PluginInvoice The current object (for fluent API support)
     */
    public function setDueDate($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->due_date !== null || $dt !== null) {
            if ($dt !== $this->due_date) {
                $this->due_date = $dt;
                $this->modifiedColumns[PluginInvoiceTableMap::DUE_DATE] = true;
            }
        } // if either are not null


        return $this;
    } // setDueDate()

    /**
     * Sets the value of [created] column to a normalized version of the date/time value specified.
     *
     * @param      mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return   \HookCalendar\Model\PluginInvoice The current object (for fluent API support)
     */
    public function setCreated($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->created !== null || $dt !== null) {
            if ($dt !== $this->created) {
                $this->created = $dt;
                $this->modifiedColumns[PluginInvoiceTableMap::CREATED] = true;
            }
        } // if either are not null


        return $this;
    } // setCreated()

    /**
     * Sets the value of [modified] column to a normalized version of the date/time value specified.
     *
     * @param      mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return   \HookCalendar\Model\PluginInvoice The current object (for fluent API support)
     */
    public function setModified($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->modified !== null || $dt !== null) {
            if ($dt !== $this->modified) {
                $this->modified = $dt;
                $this->modifiedColumns[PluginInvoiceTableMap::MODIFIED] = true;
            }
        } // if either are not null


        return $this;
    } // setModified()

    /**
     * Set the value of [status] column.
     *
     * @param      string $v new value
     * @return   \HookCalendar\Model\PluginInvoice The current object (for fluent API support)
     */
    public function setStatus($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->status !== $v) {
            $this->status = $v;
            $this->modifiedColumns[PluginInvoiceTableMap::STATUS] = true;
        }


        return $this;
    } // setStatus()

    /**
     * Set the value of [payment_method] column.
     *
     * @param      string $v new value
     * @return   \HookCalendar\Model\PluginInvoice The current object (for fluent API support)
     */
    public function setPaymentMethod($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->payment_method !== $v) {
            $this->payment_method = $v;
            $this->modifiedColumns[PluginInvoiceTableMap::PAYMENT_METHOD] = true;
        }


        return $this;
    } // setPaymentMethod()

    /**
     * Set the value of [cc_type] column.
     *
     * @param      resource $v new value
     * @return   \HookCalendar\Model\PluginInvoice The current object (for fluent API support)
     */
    public function setCcType($v)
    {
        // Because BLOB columns are streams in PDO we have to assume that they are
        // always modified when a new value is passed in.  For example, the contents
        // of the stream itself may have changed externally.
        if (!is_resource($v) && $v !== null) {
            $this->cc_type = fopen('php://memory', 'r+');
            fwrite($this->cc_type, $v);
            rewind($this->cc_type);
        } else { // it's already a stream
            $this->cc_type = $v;
        }
        $this->modifiedColumns[PluginInvoiceTableMap::CC_TYPE] = true;


        return $this;
    } // setCcType()

    /**
     * Set the value of [cc_num] column.
     *
     * @param      resource $v new value
     * @return   \HookCalendar\Model\PluginInvoice The current object (for fluent API support)
     */
    public function setCcNum($v)
    {
        // Because BLOB columns are streams in PDO we have to assume that they are
        // always modified when a new value is passed in.  For example, the contents
        // of the stream itself may have changed externally.
        if (!is_resource($v) && $v !== null) {
            $this->cc_num = fopen('php://memory', 'r+');
            fwrite($this->cc_num, $v);
            rewind($this->cc_num);
        } else { // it's already a stream
            $this->cc_num = $v;
        }
        $this->modifiedColumns[PluginInvoiceTableMap::CC_NUM] = true;


        return $this;
    } // setCcNum()

    /**
     * Set the value of [cc_exp_month] column.
     *
     * @param      resource $v new value
     * @return   \HookCalendar\Model\PluginInvoice The current object (for fluent API support)
     */
    public function setCcExpMonth($v)
    {
        // Because BLOB columns are streams in PDO we have to assume that they are
        // always modified when a new value is passed in.  For example, the contents
        // of the stream itself may have changed externally.
        if (!is_resource($v) && $v !== null) {
            $this->cc_exp_month = fopen('php://memory', 'r+');
            fwrite($this->cc_exp_month, $v);
            rewind($this->cc_exp_month);
        } else { // it's already a stream
            $this->cc_exp_month = $v;
        }
        $this->modifiedColumns[PluginInvoiceTableMap::CC_EXP_MONTH] = true;


        return $this;
    } // setCcExpMonth()

    /**
     * Set the value of [cc_exp_year] column.
     *
     * @param      resource $v new value
     * @return   \HookCalendar\Model\PluginInvoice The current object (for fluent API support)
     */
    public function setCcExpYear($v)
    {
        // Because BLOB columns are streams in PDO we have to assume that they are
        // always modified when a new value is passed in.  For example, the contents
        // of the stream itself may have changed externally.
        if (!is_resource($v) && $v !== null) {
            $this->cc_exp_year = fopen('php://memory', 'r+');
            fwrite($this->cc_exp_year, $v);
            rewind($this->cc_exp_year);
        } else { // it's already a stream
            $this->cc_exp_year = $v;
        }
        $this->modifiedColumns[PluginInvoiceTableMap::CC_EXP_YEAR] = true;


        return $this;
    } // setCcExpYear()

    /**
     * Set the value of [cc_code] column.
     *
     * @param      resource $v new value
     * @return   \HookCalendar\Model\PluginInvoice The current object (for fluent API support)
     */
    public function setCcCode($v)
    {
        // Because BLOB columns are streams in PDO we have to assume that they are
        // always modified when a new value is passed in.  For example, the contents
        // of the stream itself may have changed externally.
        if (!is_resource($v) && $v !== null) {
            $this->cc_code = fopen('php://memory', 'r+');
            fwrite($this->cc_code, $v);
            rewind($this->cc_code);
        } else { // it's already a stream
            $this->cc_code = $v;
        }
        $this->modifiedColumns[PluginInvoiceTableMap::CC_CODE] = true;


        return $this;
    } // setCcCode()

    /**
     * Set the value of [txn_id] column.
     *
     * @param      string $v new value
     * @return   \HookCalendar\Model\PluginInvoice The current object (for fluent API support)
     */
    public function setTxnId($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->txn_id !== $v) {
            $this->txn_id = $v;
            $this->modifiedColumns[PluginInvoiceTableMap::TXN_ID] = true;
        }


        return $this;
    } // setTxnId()

    /**
     * Sets the value of [processed_on] column to a normalized version of the date/time value specified.
     *
     * @param      mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return   \HookCalendar\Model\PluginInvoice The current object (for fluent API support)
     */
    public function setProcessedOn($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->processed_on !== null || $dt !== null) {
            if ($dt !== $this->processed_on) {
                $this->processed_on = $dt;
                $this->modifiedColumns[PluginInvoiceTableMap::PROCESSED_ON] = true;
            }
        } // if either are not null


        return $this;
    } // setProcessedOn()

    /**
     * Set the value of [subtotal] column.
     *
     * @param      string $v new value
     * @return   \HookCalendar\Model\PluginInvoice The current object (for fluent API support)
     */
    public function setSubtotal($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->subtotal !== $v) {
            $this->subtotal = $v;
            $this->modifiedColumns[PluginInvoiceTableMap::SUBTOTAL] = true;
        }


        return $this;
    } // setSubtotal()

    /**
     * Set the value of [discount] column.
     *
     * @param      string $v new value
     * @return   \HookCalendar\Model\PluginInvoice The current object (for fluent API support)
     */
    public function setDiscount($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->discount !== $v) {
            $this->discount = $v;
            $this->modifiedColumns[PluginInvoiceTableMap::DISCOUNT] = true;
        }


        return $this;
    } // setDiscount()

    /**
     * Set the value of [tax] column.
     *
     * @param      string $v new value
     * @return   \HookCalendar\Model\PluginInvoice The current object (for fluent API support)
     */
    public function setTax($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->tax !== $v) {
            $this->tax = $v;
            $this->modifiedColumns[PluginInvoiceTableMap::TAX] = true;
        }


        return $this;
    } // setTax()

    /**
     * Set the value of [shipping] column.
     *
     * @param      string $v new value
     * @return   \HookCalendar\Model\PluginInvoice The current object (for fluent API support)
     */
    public function setShipping($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->shipping !== $v) {
            $this->shipping = $v;
            $this->modifiedColumns[PluginInvoiceTableMap::SHIPPING] = true;
        }


        return $this;
    } // setShipping()

    /**
     * Set the value of [total] column.
     *
     * @param      string $v new value
     * @return   \HookCalendar\Model\PluginInvoice The current object (for fluent API support)
     */
    public function setTotal($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->total !== $v) {
            $this->total = $v;
            $this->modifiedColumns[PluginInvoiceTableMap::TOTAL] = true;
        }


        return $this;
    } // setTotal()

    /**
     * Set the value of [paid_deposit] column.
     *
     * @param      string $v new value
     * @return   \HookCalendar\Model\PluginInvoice The current object (for fluent API support)
     */
    public function setPaidDeposit($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->paid_deposit !== $v) {
            $this->paid_deposit = $v;
            $this->modifiedColumns[PluginInvoiceTableMap::PAID_DEPOSIT] = true;
        }


        return $this;
    } // setPaidDeposit()

    /**
     * Set the value of [amount_due] column.
     *
     * @param      string $v new value
     * @return   \HookCalendar\Model\PluginInvoice The current object (for fluent API support)
     */
    public function setAmountDue($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->amount_due !== $v) {
            $this->amount_due = $v;
            $this->modifiedColumns[PluginInvoiceTableMap::AMOUNT_DUE] = true;
        }


        return $this;
    } // setAmountDue()

    /**
     * Set the value of [currency] column.
     *
     * @param      string $v new value
     * @return   \HookCalendar\Model\PluginInvoice The current object (for fluent API support)
     */
    public function setCurrency($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->currency !== $v) {
            $this->currency = $v;
            $this->modifiedColumns[PluginInvoiceTableMap::CURRENCY] = true;
        }


        return $this;
    } // setCurrency()

    /**
     * Set the value of [notes] column.
     *
     * @param      string $v new value
     * @return   \HookCalendar\Model\PluginInvoice The current object (for fluent API support)
     */
    public function setNotes($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->notes !== $v) {
            $this->notes = $v;
            $this->modifiedColumns[PluginInvoiceTableMap::NOTES] = true;
        }


        return $this;
    } // setNotes()

    /**
     * Set the value of [y_logo] column.
     *
     * @param      string $v new value
     * @return   \HookCalendar\Model\PluginInvoice The current object (for fluent API support)
     */
    public function setYLogo($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->y_logo !== $v) {
            $this->y_logo = $v;
            $this->modifiedColumns[PluginInvoiceTableMap::Y_LOGO] = true;
        }


        return $this;
    } // setYLogo()

    /**
     * Set the value of [y_company] column.
     *
     * @param      string $v new value
     * @return   \HookCalendar\Model\PluginInvoice The current object (for fluent API support)
     */
    public function setYCompany($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->y_company !== $v) {
            $this->y_company = $v;
            $this->modifiedColumns[PluginInvoiceTableMap::Y_COMPANY] = true;
        }


        return $this;
    } // setYCompany()

    /**
     * Set the value of [y_name] column.
     *
     * @param      string $v new value
     * @return   \HookCalendar\Model\PluginInvoice The current object (for fluent API support)
     */
    public function setYName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->y_name !== $v) {
            $this->y_name = $v;
            $this->modifiedColumns[PluginInvoiceTableMap::Y_NAME] = true;
        }


        return $this;
    } // setYName()

    /**
     * Set the value of [y_street_address] column.
     *
     * @param      string $v new value
     * @return   \HookCalendar\Model\PluginInvoice The current object (for fluent API support)
     */
    public function setYStreetAddress($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->y_street_address !== $v) {
            $this->y_street_address = $v;
            $this->modifiedColumns[PluginInvoiceTableMap::Y_STREET_ADDRESS] = true;
        }


        return $this;
    } // setYStreetAddress()

    /**
     * Set the value of [y_country] column.
     *
     * @param      int $v new value
     * @return   \HookCalendar\Model\PluginInvoice The current object (for fluent API support)
     */
    public function setYCountry($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->y_country !== $v) {
            $this->y_country = $v;
            $this->modifiedColumns[PluginInvoiceTableMap::Y_COUNTRY] = true;
        }


        return $this;
    } // setYCountry()

    /**
     * Set the value of [y_city] column.
     *
     * @param      string $v new value
     * @return   \HookCalendar\Model\PluginInvoice The current object (for fluent API support)
     */
    public function setYCity($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->y_city !== $v) {
            $this->y_city = $v;
            $this->modifiedColumns[PluginInvoiceTableMap::Y_CITY] = true;
        }


        return $this;
    } // setYCity()

    /**
     * Set the value of [y_state] column.
     *
     * @param      string $v new value
     * @return   \HookCalendar\Model\PluginInvoice The current object (for fluent API support)
     */
    public function setYState($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->y_state !== $v) {
            $this->y_state = $v;
            $this->modifiedColumns[PluginInvoiceTableMap::Y_STATE] = true;
        }


        return $this;
    } // setYState()

    /**
     * Set the value of [y_zip] column.
     *
     * @param      string $v new value
     * @return   \HookCalendar\Model\PluginInvoice The current object (for fluent API support)
     */
    public function setYZip($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->y_zip !== $v) {
            $this->y_zip = $v;
            $this->modifiedColumns[PluginInvoiceTableMap::Y_ZIP] = true;
        }


        return $this;
    } // setYZip()

    /**
     * Set the value of [y_phone] column.
     *
     * @param      string $v new value
     * @return   \HookCalendar\Model\PluginInvoice The current object (for fluent API support)
     */
    public function setYPhone($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->y_phone !== $v) {
            $this->y_phone = $v;
            $this->modifiedColumns[PluginInvoiceTableMap::Y_PHONE] = true;
        }


        return $this;
    } // setYPhone()

    /**
     * Set the value of [y_fax] column.
     *
     * @param      string $v new value
     * @return   \HookCalendar\Model\PluginInvoice The current object (for fluent API support)
     */
    public function setYFax($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->y_fax !== $v) {
            $this->y_fax = $v;
            $this->modifiedColumns[PluginInvoiceTableMap::Y_FAX] = true;
        }


        return $this;
    } // setYFax()

    /**
     * Set the value of [y_email] column.
     *
     * @param      string $v new value
     * @return   \HookCalendar\Model\PluginInvoice The current object (for fluent API support)
     */
    public function setYEmail($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->y_email !== $v) {
            $this->y_email = $v;
            $this->modifiedColumns[PluginInvoiceTableMap::Y_EMAIL] = true;
        }


        return $this;
    } // setYEmail()

    /**
     * Set the value of [y_url] column.
     *
     * @param      string $v new value
     * @return   \HookCalendar\Model\PluginInvoice The current object (for fluent API support)
     */
    public function setYUrl($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->y_url !== $v) {
            $this->y_url = $v;
            $this->modifiedColumns[PluginInvoiceTableMap::Y_URL] = true;
        }


        return $this;
    } // setYUrl()

    /**
     * Set the value of [b_billing_address] column.
     *
     * @param      string $v new value
     * @return   \HookCalendar\Model\PluginInvoice The current object (for fluent API support)
     */
    public function setBBillingAddress($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->b_billing_address !== $v) {
            $this->b_billing_address = $v;
            $this->modifiedColumns[PluginInvoiceTableMap::B_BILLING_ADDRESS] = true;
        }


        return $this;
    } // setBBillingAddress()

    /**
     * Set the value of [b_company] column.
     *
     * @param      string $v new value
     * @return   \HookCalendar\Model\PluginInvoice The current object (for fluent API support)
     */
    public function setBCompany($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->b_company !== $v) {
            $this->b_company = $v;
            $this->modifiedColumns[PluginInvoiceTableMap::B_COMPANY] = true;
        }


        return $this;
    } // setBCompany()

    /**
     * Set the value of [b_name] column.
     *
     * @param      string $v new value
     * @return   \HookCalendar\Model\PluginInvoice The current object (for fluent API support)
     */
    public function setBName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->b_name !== $v) {
            $this->b_name = $v;
            $this->modifiedColumns[PluginInvoiceTableMap::B_NAME] = true;
        }


        return $this;
    } // setBName()

    /**
     * Set the value of [b_address] column.
     *
     * @param      string $v new value
     * @return   \HookCalendar\Model\PluginInvoice The current object (for fluent API support)
     */
    public function setBAddress($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->b_address !== $v) {
            $this->b_address = $v;
            $this->modifiedColumns[PluginInvoiceTableMap::B_ADDRESS] = true;
        }


        return $this;
    } // setBAddress()

    /**
     * Set the value of [b_street_address] column.
     *
     * @param      string $v new value
     * @return   \HookCalendar\Model\PluginInvoice The current object (for fluent API support)
     */
    public function setBStreetAddress($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->b_street_address !== $v) {
            $this->b_street_address = $v;
            $this->modifiedColumns[PluginInvoiceTableMap::B_STREET_ADDRESS] = true;
        }


        return $this;
    } // setBStreetAddress()

    /**
     * Set the value of [b_country] column.
     *
     * @param      int $v new value
     * @return   \HookCalendar\Model\PluginInvoice The current object (for fluent API support)
     */
    public function setBCountry($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->b_country !== $v) {
            $this->b_country = $v;
            $this->modifiedColumns[PluginInvoiceTableMap::B_COUNTRY] = true;
        }


        return $this;
    } // setBCountry()

    /**
     * Set the value of [b_city] column.
     *
     * @param      string $v new value
     * @return   \HookCalendar\Model\PluginInvoice The current object (for fluent API support)
     */
    public function setBCity($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->b_city !== $v) {
            $this->b_city = $v;
            $this->modifiedColumns[PluginInvoiceTableMap::B_CITY] = true;
        }


        return $this;
    } // setBCity()

    /**
     * Set the value of [b_state] column.
     *
     * @param      string $v new value
     * @return   \HookCalendar\Model\PluginInvoice The current object (for fluent API support)
     */
    public function setBState($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->b_state !== $v) {
            $this->b_state = $v;
            $this->modifiedColumns[PluginInvoiceTableMap::B_STATE] = true;
        }


        return $this;
    } // setBState()

    /**
     * Set the value of [b_zip] column.
     *
     * @param      string $v new value
     * @return   \HookCalendar\Model\PluginInvoice The current object (for fluent API support)
     */
    public function setBZip($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->b_zip !== $v) {
            $this->b_zip = $v;
            $this->modifiedColumns[PluginInvoiceTableMap::B_ZIP] = true;
        }


        return $this;
    } // setBZip()

    /**
     * Set the value of [b_phone] column.
     *
     * @param      string $v new value
     * @return   \HookCalendar\Model\PluginInvoice The current object (for fluent API support)
     */
    public function setBPhone($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->b_phone !== $v) {
            $this->b_phone = $v;
            $this->modifiedColumns[PluginInvoiceTableMap::B_PHONE] = true;
        }


        return $this;
    } // setBPhone()

    /**
     * Set the value of [b_fax] column.
     *
     * @param      string $v new value
     * @return   \HookCalendar\Model\PluginInvoice The current object (for fluent API support)
     */
    public function setBFax($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->b_fax !== $v) {
            $this->b_fax = $v;
            $this->modifiedColumns[PluginInvoiceTableMap::B_FAX] = true;
        }


        return $this;
    } // setBFax()

    /**
     * Set the value of [b_email] column.
     *
     * @param      string $v new value
     * @return   \HookCalendar\Model\PluginInvoice The current object (for fluent API support)
     */
    public function setBEmail($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->b_email !== $v) {
            $this->b_email = $v;
            $this->modifiedColumns[PluginInvoiceTableMap::B_EMAIL] = true;
        }


        return $this;
    } // setBEmail()

    /**
     * Set the value of [b_url] column.
     *
     * @param      string $v new value
     * @return   \HookCalendar\Model\PluginInvoice The current object (for fluent API support)
     */
    public function setBUrl($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->b_url !== $v) {
            $this->b_url = $v;
            $this->modifiedColumns[PluginInvoiceTableMap::B_URL] = true;
        }


        return $this;
    } // setBUrl()

    /**
     * Set the value of [s_shipping_address] column.
     *
     * @param      string $v new value
     * @return   \HookCalendar\Model\PluginInvoice The current object (for fluent API support)
     */
    public function setSShippingAddress($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->s_shipping_address !== $v) {
            $this->s_shipping_address = $v;
            $this->modifiedColumns[PluginInvoiceTableMap::S_SHIPPING_ADDRESS] = true;
        }


        return $this;
    } // setSShippingAddress()

    /**
     * Set the value of [s_company] column.
     *
     * @param      string $v new value
     * @return   \HookCalendar\Model\PluginInvoice The current object (for fluent API support)
     */
    public function setSCompany($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->s_company !== $v) {
            $this->s_company = $v;
            $this->modifiedColumns[PluginInvoiceTableMap::S_COMPANY] = true;
        }


        return $this;
    } // setSCompany()

    /**
     * Set the value of [s_name] column.
     *
     * @param      string $v new value
     * @return   \HookCalendar\Model\PluginInvoice The current object (for fluent API support)
     */
    public function setSName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->s_name !== $v) {
            $this->s_name = $v;
            $this->modifiedColumns[PluginInvoiceTableMap::S_NAME] = true;
        }


        return $this;
    } // setSName()

    /**
     * Set the value of [s_address] column.
     *
     * @param      string $v new value
     * @return   \HookCalendar\Model\PluginInvoice The current object (for fluent API support)
     */
    public function setSAddress($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->s_address !== $v) {
            $this->s_address = $v;
            $this->modifiedColumns[PluginInvoiceTableMap::S_ADDRESS] = true;
        }


        return $this;
    } // setSAddress()

    /**
     * Set the value of [s_street_address] column.
     *
     * @param      string $v new value
     * @return   \HookCalendar\Model\PluginInvoice The current object (for fluent API support)
     */
    public function setSStreetAddress($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->s_street_address !== $v) {
            $this->s_street_address = $v;
            $this->modifiedColumns[PluginInvoiceTableMap::S_STREET_ADDRESS] = true;
        }


        return $this;
    } // setSStreetAddress()

    /**
     * Set the value of [s_country] column.
     *
     * @param      int $v new value
     * @return   \HookCalendar\Model\PluginInvoice The current object (for fluent API support)
     */
    public function setSCountry($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->s_country !== $v) {
            $this->s_country = $v;
            $this->modifiedColumns[PluginInvoiceTableMap::S_COUNTRY] = true;
        }


        return $this;
    } // setSCountry()

    /**
     * Set the value of [s_city] column.
     *
     * @param      string $v new value
     * @return   \HookCalendar\Model\PluginInvoice The current object (for fluent API support)
     */
    public function setSCity($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->s_city !== $v) {
            $this->s_city = $v;
            $this->modifiedColumns[PluginInvoiceTableMap::S_CITY] = true;
        }


        return $this;
    } // setSCity()

    /**
     * Set the value of [s_state] column.
     *
     * @param      string $v new value
     * @return   \HookCalendar\Model\PluginInvoice The current object (for fluent API support)
     */
    public function setSState($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->s_state !== $v) {
            $this->s_state = $v;
            $this->modifiedColumns[PluginInvoiceTableMap::S_STATE] = true;
        }


        return $this;
    } // setSState()

    /**
     * Set the value of [s_zip] column.
     *
     * @param      string $v new value
     * @return   \HookCalendar\Model\PluginInvoice The current object (for fluent API support)
     */
    public function setSZip($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->s_zip !== $v) {
            $this->s_zip = $v;
            $this->modifiedColumns[PluginInvoiceTableMap::S_ZIP] = true;
        }


        return $this;
    } // setSZip()

    /**
     * Set the value of [s_phone] column.
     *
     * @param      string $v new value
     * @return   \HookCalendar\Model\PluginInvoice The current object (for fluent API support)
     */
    public function setSPhone($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->s_phone !== $v) {
            $this->s_phone = $v;
            $this->modifiedColumns[PluginInvoiceTableMap::S_PHONE] = true;
        }


        return $this;
    } // setSPhone()

    /**
     * Set the value of [s_fax] column.
     *
     * @param      string $v new value
     * @return   \HookCalendar\Model\PluginInvoice The current object (for fluent API support)
     */
    public function setSFax($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->s_fax !== $v) {
            $this->s_fax = $v;
            $this->modifiedColumns[PluginInvoiceTableMap::S_FAX] = true;
        }


        return $this;
    } // setSFax()

    /**
     * Set the value of [s_email] column.
     *
     * @param      string $v new value
     * @return   \HookCalendar\Model\PluginInvoice The current object (for fluent API support)
     */
    public function setSEmail($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->s_email !== $v) {
            $this->s_email = $v;
            $this->modifiedColumns[PluginInvoiceTableMap::S_EMAIL] = true;
        }


        return $this;
    } // setSEmail()

    /**
     * Set the value of [s_url] column.
     *
     * @param      string $v new value
     * @return   \HookCalendar\Model\PluginInvoice The current object (for fluent API support)
     */
    public function setSUrl($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->s_url !== $v) {
            $this->s_url = $v;
            $this->modifiedColumns[PluginInvoiceTableMap::S_URL] = true;
        }


        return $this;
    } // setSUrl()

    /**
     * Sets the value of [s_date] column to a normalized version of the date/time value specified.
     *
     * @param      mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return   \HookCalendar\Model\PluginInvoice The current object (for fluent API support)
     */
    public function setSDate($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->s_date !== null || $dt !== null) {
            if ($dt !== $this->s_date) {
                $this->s_date = $dt;
                $this->modifiedColumns[PluginInvoiceTableMap::S_DATE] = true;
            }
        } // if either are not null


        return $this;
    } // setSDate()

    /**
     * Set the value of [s_terms] column.
     *
     * @param      string $v new value
     * @return   \HookCalendar\Model\PluginInvoice The current object (for fluent API support)
     */
    public function setSTerms($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->s_terms !== $v) {
            $this->s_terms = $v;
            $this->modifiedColumns[PluginInvoiceTableMap::S_TERMS] = true;
        }


        return $this;
    } // setSTerms()

    /**
     * Sets the value of the [s_is_shipped] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param      boolean|integer|string $v The new value
     * @return   \HookCalendar\Model\PluginInvoice The current object (for fluent API support)
     */
    public function setSIsShipped($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->s_is_shipped !== $v) {
            $this->s_is_shipped = $v;
            $this->modifiedColumns[PluginInvoiceTableMap::S_IS_SHIPPED] = true;
        }


        return $this;
    } // setSIsShipped()

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
            if ($this->s_is_shipped !== false) {
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


            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : PluginInvoiceTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : PluginInvoiceTableMap::translateFieldName('Uuid', TableMap::TYPE_PHPNAME, $indexType)];
            $this->uuid = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : PluginInvoiceTableMap::translateFieldName('OrderId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->order_id = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : PluginInvoiceTableMap::translateFieldName('ForeignId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->foreign_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : PluginInvoiceTableMap::translateFieldName('IssueDate', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00') {
                $col = null;
            }
            $this->issue_date = (null !== $col) ? PropelDateTime::newInstance($col, null, '\DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : PluginInvoiceTableMap::translateFieldName('DueDate', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00') {
                $col = null;
            }
            $this->due_date = (null !== $col) ? PropelDateTime::newInstance($col, null, '\DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : PluginInvoiceTableMap::translateFieldName('Created', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->created = (null !== $col) ? PropelDateTime::newInstance($col, null, '\DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : PluginInvoiceTableMap::translateFieldName('Modified', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->modified = (null !== $col) ? PropelDateTime::newInstance($col, null, '\DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : PluginInvoiceTableMap::translateFieldName('Status', TableMap::TYPE_PHPNAME, $indexType)];
            $this->status = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : PluginInvoiceTableMap::translateFieldName('PaymentMethod', TableMap::TYPE_PHPNAME, $indexType)];
            $this->payment_method = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 10 + $startcol : PluginInvoiceTableMap::translateFieldName('CcType', TableMap::TYPE_PHPNAME, $indexType)];
            if (null !== $col) {
                $this->cc_type = fopen('php://memory', 'r+');
                fwrite($this->cc_type, $col);
                rewind($this->cc_type);
            } else {
                $this->cc_type = null;
            }

            $col = $row[TableMap::TYPE_NUM == $indexType ? 11 + $startcol : PluginInvoiceTableMap::translateFieldName('CcNum', TableMap::TYPE_PHPNAME, $indexType)];
            if (null !== $col) {
                $this->cc_num = fopen('php://memory', 'r+');
                fwrite($this->cc_num, $col);
                rewind($this->cc_num);
            } else {
                $this->cc_num = null;
            }

            $col = $row[TableMap::TYPE_NUM == $indexType ? 12 + $startcol : PluginInvoiceTableMap::translateFieldName('CcExpMonth', TableMap::TYPE_PHPNAME, $indexType)];
            if (null !== $col) {
                $this->cc_exp_month = fopen('php://memory', 'r+');
                fwrite($this->cc_exp_month, $col);
                rewind($this->cc_exp_month);
            } else {
                $this->cc_exp_month = null;
            }

            $col = $row[TableMap::TYPE_NUM == $indexType ? 13 + $startcol : PluginInvoiceTableMap::translateFieldName('CcExpYear', TableMap::TYPE_PHPNAME, $indexType)];
            if (null !== $col) {
                $this->cc_exp_year = fopen('php://memory', 'r+');
                fwrite($this->cc_exp_year, $col);
                rewind($this->cc_exp_year);
            } else {
                $this->cc_exp_year = null;
            }

            $col = $row[TableMap::TYPE_NUM == $indexType ? 14 + $startcol : PluginInvoiceTableMap::translateFieldName('CcCode', TableMap::TYPE_PHPNAME, $indexType)];
            if (null !== $col) {
                $this->cc_code = fopen('php://memory', 'r+');
                fwrite($this->cc_code, $col);
                rewind($this->cc_code);
            } else {
                $this->cc_code = null;
            }

            $col = $row[TableMap::TYPE_NUM == $indexType ? 15 + $startcol : PluginInvoiceTableMap::translateFieldName('TxnId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->txn_id = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 16 + $startcol : PluginInvoiceTableMap::translateFieldName('ProcessedOn', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->processed_on = (null !== $col) ? PropelDateTime::newInstance($col, null, '\DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 17 + $startcol : PluginInvoiceTableMap::translateFieldName('Subtotal', TableMap::TYPE_PHPNAME, $indexType)];
            $this->subtotal = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 18 + $startcol : PluginInvoiceTableMap::translateFieldName('Discount', TableMap::TYPE_PHPNAME, $indexType)];
            $this->discount = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 19 + $startcol : PluginInvoiceTableMap::translateFieldName('Tax', TableMap::TYPE_PHPNAME, $indexType)];
            $this->tax = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 20 + $startcol : PluginInvoiceTableMap::translateFieldName('Shipping', TableMap::TYPE_PHPNAME, $indexType)];
            $this->shipping = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 21 + $startcol : PluginInvoiceTableMap::translateFieldName('Total', TableMap::TYPE_PHPNAME, $indexType)];
            $this->total = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 22 + $startcol : PluginInvoiceTableMap::translateFieldName('PaidDeposit', TableMap::TYPE_PHPNAME, $indexType)];
            $this->paid_deposit = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 23 + $startcol : PluginInvoiceTableMap::translateFieldName('AmountDue', TableMap::TYPE_PHPNAME, $indexType)];
            $this->amount_due = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 24 + $startcol : PluginInvoiceTableMap::translateFieldName('Currency', TableMap::TYPE_PHPNAME, $indexType)];
            $this->currency = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 25 + $startcol : PluginInvoiceTableMap::translateFieldName('Notes', TableMap::TYPE_PHPNAME, $indexType)];
            $this->notes = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 26 + $startcol : PluginInvoiceTableMap::translateFieldName('YLogo', TableMap::TYPE_PHPNAME, $indexType)];
            $this->y_logo = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 27 + $startcol : PluginInvoiceTableMap::translateFieldName('YCompany', TableMap::TYPE_PHPNAME, $indexType)];
            $this->y_company = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 28 + $startcol : PluginInvoiceTableMap::translateFieldName('YName', TableMap::TYPE_PHPNAME, $indexType)];
            $this->y_name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 29 + $startcol : PluginInvoiceTableMap::translateFieldName('YStreetAddress', TableMap::TYPE_PHPNAME, $indexType)];
            $this->y_street_address = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 30 + $startcol : PluginInvoiceTableMap::translateFieldName('YCountry', TableMap::TYPE_PHPNAME, $indexType)];
            $this->y_country = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 31 + $startcol : PluginInvoiceTableMap::translateFieldName('YCity', TableMap::TYPE_PHPNAME, $indexType)];
            $this->y_city = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 32 + $startcol : PluginInvoiceTableMap::translateFieldName('YState', TableMap::TYPE_PHPNAME, $indexType)];
            $this->y_state = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 33 + $startcol : PluginInvoiceTableMap::translateFieldName('YZip', TableMap::TYPE_PHPNAME, $indexType)];
            $this->y_zip = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 34 + $startcol : PluginInvoiceTableMap::translateFieldName('YPhone', TableMap::TYPE_PHPNAME, $indexType)];
            $this->y_phone = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 35 + $startcol : PluginInvoiceTableMap::translateFieldName('YFax', TableMap::TYPE_PHPNAME, $indexType)];
            $this->y_fax = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 36 + $startcol : PluginInvoiceTableMap::translateFieldName('YEmail', TableMap::TYPE_PHPNAME, $indexType)];
            $this->y_email = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 37 + $startcol : PluginInvoiceTableMap::translateFieldName('YUrl', TableMap::TYPE_PHPNAME, $indexType)];
            $this->y_url = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 38 + $startcol : PluginInvoiceTableMap::translateFieldName('BBillingAddress', TableMap::TYPE_PHPNAME, $indexType)];
            $this->b_billing_address = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 39 + $startcol : PluginInvoiceTableMap::translateFieldName('BCompany', TableMap::TYPE_PHPNAME, $indexType)];
            $this->b_company = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 40 + $startcol : PluginInvoiceTableMap::translateFieldName('BName', TableMap::TYPE_PHPNAME, $indexType)];
            $this->b_name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 41 + $startcol : PluginInvoiceTableMap::translateFieldName('BAddress', TableMap::TYPE_PHPNAME, $indexType)];
            $this->b_address = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 42 + $startcol : PluginInvoiceTableMap::translateFieldName('BStreetAddress', TableMap::TYPE_PHPNAME, $indexType)];
            $this->b_street_address = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 43 + $startcol : PluginInvoiceTableMap::translateFieldName('BCountry', TableMap::TYPE_PHPNAME, $indexType)];
            $this->b_country = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 44 + $startcol : PluginInvoiceTableMap::translateFieldName('BCity', TableMap::TYPE_PHPNAME, $indexType)];
            $this->b_city = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 45 + $startcol : PluginInvoiceTableMap::translateFieldName('BState', TableMap::TYPE_PHPNAME, $indexType)];
            $this->b_state = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 46 + $startcol : PluginInvoiceTableMap::translateFieldName('BZip', TableMap::TYPE_PHPNAME, $indexType)];
            $this->b_zip = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 47 + $startcol : PluginInvoiceTableMap::translateFieldName('BPhone', TableMap::TYPE_PHPNAME, $indexType)];
            $this->b_phone = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 48 + $startcol : PluginInvoiceTableMap::translateFieldName('BFax', TableMap::TYPE_PHPNAME, $indexType)];
            $this->b_fax = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 49 + $startcol : PluginInvoiceTableMap::translateFieldName('BEmail', TableMap::TYPE_PHPNAME, $indexType)];
            $this->b_email = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 50 + $startcol : PluginInvoiceTableMap::translateFieldName('BUrl', TableMap::TYPE_PHPNAME, $indexType)];
            $this->b_url = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 51 + $startcol : PluginInvoiceTableMap::translateFieldName('SShippingAddress', TableMap::TYPE_PHPNAME, $indexType)];
            $this->s_shipping_address = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 52 + $startcol : PluginInvoiceTableMap::translateFieldName('SCompany', TableMap::TYPE_PHPNAME, $indexType)];
            $this->s_company = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 53 + $startcol : PluginInvoiceTableMap::translateFieldName('SName', TableMap::TYPE_PHPNAME, $indexType)];
            $this->s_name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 54 + $startcol : PluginInvoiceTableMap::translateFieldName('SAddress', TableMap::TYPE_PHPNAME, $indexType)];
            $this->s_address = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 55 + $startcol : PluginInvoiceTableMap::translateFieldName('SStreetAddress', TableMap::TYPE_PHPNAME, $indexType)];
            $this->s_street_address = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 56 + $startcol : PluginInvoiceTableMap::translateFieldName('SCountry', TableMap::TYPE_PHPNAME, $indexType)];
            $this->s_country = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 57 + $startcol : PluginInvoiceTableMap::translateFieldName('SCity', TableMap::TYPE_PHPNAME, $indexType)];
            $this->s_city = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 58 + $startcol : PluginInvoiceTableMap::translateFieldName('SState', TableMap::TYPE_PHPNAME, $indexType)];
            $this->s_state = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 59 + $startcol : PluginInvoiceTableMap::translateFieldName('SZip', TableMap::TYPE_PHPNAME, $indexType)];
            $this->s_zip = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 60 + $startcol : PluginInvoiceTableMap::translateFieldName('SPhone', TableMap::TYPE_PHPNAME, $indexType)];
            $this->s_phone = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 61 + $startcol : PluginInvoiceTableMap::translateFieldName('SFax', TableMap::TYPE_PHPNAME, $indexType)];
            $this->s_fax = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 62 + $startcol : PluginInvoiceTableMap::translateFieldName('SEmail', TableMap::TYPE_PHPNAME, $indexType)];
            $this->s_email = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 63 + $startcol : PluginInvoiceTableMap::translateFieldName('SUrl', TableMap::TYPE_PHPNAME, $indexType)];
            $this->s_url = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 64 + $startcol : PluginInvoiceTableMap::translateFieldName('SDate', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00') {
                $col = null;
            }
            $this->s_date = (null !== $col) ? PropelDateTime::newInstance($col, null, '\DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 65 + $startcol : PluginInvoiceTableMap::translateFieldName('STerms', TableMap::TYPE_PHPNAME, $indexType)];
            $this->s_terms = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 66 + $startcol : PluginInvoiceTableMap::translateFieldName('SIsShipped', TableMap::TYPE_PHPNAME, $indexType)];
            $this->s_is_shipped = (null !== $col) ? (boolean) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 67; // 67 = PluginInvoiceTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating \HookCalendar\Model\PluginInvoice object", 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(PluginInvoiceTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildPluginInvoiceQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see PluginInvoice::setDeleted()
     * @see PluginInvoice::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(PluginInvoiceTableMap::DATABASE_NAME);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = ChildPluginInvoiceQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(PluginInvoiceTableMap::DATABASE_NAME);
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
                PluginInvoiceTableMap::addInstanceToPool($this);
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

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                } else {
                    $this->doUpdate($con);
                }
                $affectedRows += 1;
                // Rewind the cc_type LOB column, since PDO does not rewind after inserting value.
                if ($this->cc_type !== null && is_resource($this->cc_type)) {
                    rewind($this->cc_type);
                }

                // Rewind the cc_num LOB column, since PDO does not rewind after inserting value.
                if ($this->cc_num !== null && is_resource($this->cc_num)) {
                    rewind($this->cc_num);
                }

                // Rewind the cc_exp_month LOB column, since PDO does not rewind after inserting value.
                if ($this->cc_exp_month !== null && is_resource($this->cc_exp_month)) {
                    rewind($this->cc_exp_month);
                }

                // Rewind the cc_exp_year LOB column, since PDO does not rewind after inserting value.
                if ($this->cc_exp_year !== null && is_resource($this->cc_exp_year)) {
                    rewind($this->cc_exp_year);
                }

                // Rewind the cc_code LOB column, since PDO does not rewind after inserting value.
                if ($this->cc_code !== null && is_resource($this->cc_code)) {
                    rewind($this->cc_code);
                }

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

        $this->modifiedColumns[PluginInvoiceTableMap::ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . PluginInvoiceTableMap::ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(PluginInvoiceTableMap::ID)) {
            $modifiedColumns[':p' . $index++]  = 'ID';
        }
        if ($this->isColumnModified(PluginInvoiceTableMap::UUID)) {
            $modifiedColumns[':p' . $index++]  = 'UUID';
        }
        if ($this->isColumnModified(PluginInvoiceTableMap::ORDER_ID)) {
            $modifiedColumns[':p' . $index++]  = 'ORDER_ID';
        }
        if ($this->isColumnModified(PluginInvoiceTableMap::FOREIGN_ID)) {
            $modifiedColumns[':p' . $index++]  = 'FOREIGN_ID';
        }
        if ($this->isColumnModified(PluginInvoiceTableMap::ISSUE_DATE)) {
            $modifiedColumns[':p' . $index++]  = 'ISSUE_DATE';
        }
        if ($this->isColumnModified(PluginInvoiceTableMap::DUE_DATE)) {
            $modifiedColumns[':p' . $index++]  = 'DUE_DATE';
        }
        if ($this->isColumnModified(PluginInvoiceTableMap::CREATED)) {
            $modifiedColumns[':p' . $index++]  = 'CREATED';
        }
        if ($this->isColumnModified(PluginInvoiceTableMap::MODIFIED)) {
            $modifiedColumns[':p' . $index++]  = 'MODIFIED';
        }
        if ($this->isColumnModified(PluginInvoiceTableMap::STATUS)) {
            $modifiedColumns[':p' . $index++]  = 'STATUS';
        }
        if ($this->isColumnModified(PluginInvoiceTableMap::PAYMENT_METHOD)) {
            $modifiedColumns[':p' . $index++]  = 'PAYMENT_METHOD';
        }
        if ($this->isColumnModified(PluginInvoiceTableMap::CC_TYPE)) {
            $modifiedColumns[':p' . $index++]  = 'CC_TYPE';
        }
        if ($this->isColumnModified(PluginInvoiceTableMap::CC_NUM)) {
            $modifiedColumns[':p' . $index++]  = 'CC_NUM';
        }
        if ($this->isColumnModified(PluginInvoiceTableMap::CC_EXP_MONTH)) {
            $modifiedColumns[':p' . $index++]  = 'CC_EXP_MONTH';
        }
        if ($this->isColumnModified(PluginInvoiceTableMap::CC_EXP_YEAR)) {
            $modifiedColumns[':p' . $index++]  = 'CC_EXP_YEAR';
        }
        if ($this->isColumnModified(PluginInvoiceTableMap::CC_CODE)) {
            $modifiedColumns[':p' . $index++]  = 'CC_CODE';
        }
        if ($this->isColumnModified(PluginInvoiceTableMap::TXN_ID)) {
            $modifiedColumns[':p' . $index++]  = 'TXN_ID';
        }
        if ($this->isColumnModified(PluginInvoiceTableMap::PROCESSED_ON)) {
            $modifiedColumns[':p' . $index++]  = 'PROCESSED_ON';
        }
        if ($this->isColumnModified(PluginInvoiceTableMap::SUBTOTAL)) {
            $modifiedColumns[':p' . $index++]  = 'SUBTOTAL';
        }
        if ($this->isColumnModified(PluginInvoiceTableMap::DISCOUNT)) {
            $modifiedColumns[':p' . $index++]  = 'DISCOUNT';
        }
        if ($this->isColumnModified(PluginInvoiceTableMap::TAX)) {
            $modifiedColumns[':p' . $index++]  = 'TAX';
        }
        if ($this->isColumnModified(PluginInvoiceTableMap::SHIPPING)) {
            $modifiedColumns[':p' . $index++]  = 'SHIPPING';
        }
        if ($this->isColumnModified(PluginInvoiceTableMap::TOTAL)) {
            $modifiedColumns[':p' . $index++]  = 'TOTAL';
        }
        if ($this->isColumnModified(PluginInvoiceTableMap::PAID_DEPOSIT)) {
            $modifiedColumns[':p' . $index++]  = 'PAID_DEPOSIT';
        }
        if ($this->isColumnModified(PluginInvoiceTableMap::AMOUNT_DUE)) {
            $modifiedColumns[':p' . $index++]  = 'AMOUNT_DUE';
        }
        if ($this->isColumnModified(PluginInvoiceTableMap::CURRENCY)) {
            $modifiedColumns[':p' . $index++]  = 'CURRENCY';
        }
        if ($this->isColumnModified(PluginInvoiceTableMap::NOTES)) {
            $modifiedColumns[':p' . $index++]  = 'NOTES';
        }
        if ($this->isColumnModified(PluginInvoiceTableMap::Y_LOGO)) {
            $modifiedColumns[':p' . $index++]  = 'Y_LOGO';
        }
        if ($this->isColumnModified(PluginInvoiceTableMap::Y_COMPANY)) {
            $modifiedColumns[':p' . $index++]  = 'Y_COMPANY';
        }
        if ($this->isColumnModified(PluginInvoiceTableMap::Y_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'Y_NAME';
        }
        if ($this->isColumnModified(PluginInvoiceTableMap::Y_STREET_ADDRESS)) {
            $modifiedColumns[':p' . $index++]  = 'Y_STREET_ADDRESS';
        }
        if ($this->isColumnModified(PluginInvoiceTableMap::Y_COUNTRY)) {
            $modifiedColumns[':p' . $index++]  = 'Y_COUNTRY';
        }
        if ($this->isColumnModified(PluginInvoiceTableMap::Y_CITY)) {
            $modifiedColumns[':p' . $index++]  = 'Y_CITY';
        }
        if ($this->isColumnModified(PluginInvoiceTableMap::Y_STATE)) {
            $modifiedColumns[':p' . $index++]  = 'Y_STATE';
        }
        if ($this->isColumnModified(PluginInvoiceTableMap::Y_ZIP)) {
            $modifiedColumns[':p' . $index++]  = 'Y_ZIP';
        }
        if ($this->isColumnModified(PluginInvoiceTableMap::Y_PHONE)) {
            $modifiedColumns[':p' . $index++]  = 'Y_PHONE';
        }
        if ($this->isColumnModified(PluginInvoiceTableMap::Y_FAX)) {
            $modifiedColumns[':p' . $index++]  = 'Y_FAX';
        }
        if ($this->isColumnModified(PluginInvoiceTableMap::Y_EMAIL)) {
            $modifiedColumns[':p' . $index++]  = 'Y_EMAIL';
        }
        if ($this->isColumnModified(PluginInvoiceTableMap::Y_URL)) {
            $modifiedColumns[':p' . $index++]  = 'Y_URL';
        }
        if ($this->isColumnModified(PluginInvoiceTableMap::B_BILLING_ADDRESS)) {
            $modifiedColumns[':p' . $index++]  = 'B_BILLING_ADDRESS';
        }
        if ($this->isColumnModified(PluginInvoiceTableMap::B_COMPANY)) {
            $modifiedColumns[':p' . $index++]  = 'B_COMPANY';
        }
        if ($this->isColumnModified(PluginInvoiceTableMap::B_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'B_NAME';
        }
        if ($this->isColumnModified(PluginInvoiceTableMap::B_ADDRESS)) {
            $modifiedColumns[':p' . $index++]  = 'B_ADDRESS';
        }
        if ($this->isColumnModified(PluginInvoiceTableMap::B_STREET_ADDRESS)) {
            $modifiedColumns[':p' . $index++]  = 'B_STREET_ADDRESS';
        }
        if ($this->isColumnModified(PluginInvoiceTableMap::B_COUNTRY)) {
            $modifiedColumns[':p' . $index++]  = 'B_COUNTRY';
        }
        if ($this->isColumnModified(PluginInvoiceTableMap::B_CITY)) {
            $modifiedColumns[':p' . $index++]  = 'B_CITY';
        }
        if ($this->isColumnModified(PluginInvoiceTableMap::B_STATE)) {
            $modifiedColumns[':p' . $index++]  = 'B_STATE';
        }
        if ($this->isColumnModified(PluginInvoiceTableMap::B_ZIP)) {
            $modifiedColumns[':p' . $index++]  = 'B_ZIP';
        }
        if ($this->isColumnModified(PluginInvoiceTableMap::B_PHONE)) {
            $modifiedColumns[':p' . $index++]  = 'B_PHONE';
        }
        if ($this->isColumnModified(PluginInvoiceTableMap::B_FAX)) {
            $modifiedColumns[':p' . $index++]  = 'B_FAX';
        }
        if ($this->isColumnModified(PluginInvoiceTableMap::B_EMAIL)) {
            $modifiedColumns[':p' . $index++]  = 'B_EMAIL';
        }
        if ($this->isColumnModified(PluginInvoiceTableMap::B_URL)) {
            $modifiedColumns[':p' . $index++]  = 'B_URL';
        }
        if ($this->isColumnModified(PluginInvoiceTableMap::S_SHIPPING_ADDRESS)) {
            $modifiedColumns[':p' . $index++]  = 'S_SHIPPING_ADDRESS';
        }
        if ($this->isColumnModified(PluginInvoiceTableMap::S_COMPANY)) {
            $modifiedColumns[':p' . $index++]  = 'S_COMPANY';
        }
        if ($this->isColumnModified(PluginInvoiceTableMap::S_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'S_NAME';
        }
        if ($this->isColumnModified(PluginInvoiceTableMap::S_ADDRESS)) {
            $modifiedColumns[':p' . $index++]  = 'S_ADDRESS';
        }
        if ($this->isColumnModified(PluginInvoiceTableMap::S_STREET_ADDRESS)) {
            $modifiedColumns[':p' . $index++]  = 'S_STREET_ADDRESS';
        }
        if ($this->isColumnModified(PluginInvoiceTableMap::S_COUNTRY)) {
            $modifiedColumns[':p' . $index++]  = 'S_COUNTRY';
        }
        if ($this->isColumnModified(PluginInvoiceTableMap::S_CITY)) {
            $modifiedColumns[':p' . $index++]  = 'S_CITY';
        }
        if ($this->isColumnModified(PluginInvoiceTableMap::S_STATE)) {
            $modifiedColumns[':p' . $index++]  = 'S_STATE';
        }
        if ($this->isColumnModified(PluginInvoiceTableMap::S_ZIP)) {
            $modifiedColumns[':p' . $index++]  = 'S_ZIP';
        }
        if ($this->isColumnModified(PluginInvoiceTableMap::S_PHONE)) {
            $modifiedColumns[':p' . $index++]  = 'S_PHONE';
        }
        if ($this->isColumnModified(PluginInvoiceTableMap::S_FAX)) {
            $modifiedColumns[':p' . $index++]  = 'S_FAX';
        }
        if ($this->isColumnModified(PluginInvoiceTableMap::S_EMAIL)) {
            $modifiedColumns[':p' . $index++]  = 'S_EMAIL';
        }
        if ($this->isColumnModified(PluginInvoiceTableMap::S_URL)) {
            $modifiedColumns[':p' . $index++]  = 'S_URL';
        }
        if ($this->isColumnModified(PluginInvoiceTableMap::S_DATE)) {
            $modifiedColumns[':p' . $index++]  = 'S_DATE';
        }
        if ($this->isColumnModified(PluginInvoiceTableMap::S_TERMS)) {
            $modifiedColumns[':p' . $index++]  = 'S_TERMS';
        }
        if ($this->isColumnModified(PluginInvoiceTableMap::S_IS_SHIPPED)) {
            $modifiedColumns[':p' . $index++]  = 'S_IS_SHIPPED';
        }

        $sql = sprintf(
            'INSERT INTO plugin_invoice (%s) VALUES (%s)',
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
                    case 'UUID':
                        $stmt->bindValue($identifier, $this->uuid, PDO::PARAM_STR);
                        break;
                    case 'ORDER_ID':
                        $stmt->bindValue($identifier, $this->order_id, PDO::PARAM_STR);
                        break;
                    case 'FOREIGN_ID':
                        $stmt->bindValue($identifier, $this->foreign_id, PDO::PARAM_INT);
                        break;
                    case 'ISSUE_DATE':
                        $stmt->bindValue($identifier, $this->issue_date ? $this->issue_date->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                    case 'DUE_DATE':
                        $stmt->bindValue($identifier, $this->due_date ? $this->due_date->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                    case 'CREATED':
                        $stmt->bindValue($identifier, $this->created ? $this->created->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                    case 'MODIFIED':
                        $stmt->bindValue($identifier, $this->modified ? $this->modified->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                    case 'STATUS':
                        $stmt->bindValue($identifier, $this->status, PDO::PARAM_STR);
                        break;
                    case 'PAYMENT_METHOD':
                        $stmt->bindValue($identifier, $this->payment_method, PDO::PARAM_STR);
                        break;
                    case 'CC_TYPE':
                        if (is_resource($this->cc_type)) {
                            rewind($this->cc_type);
                        }
                        $stmt->bindValue($identifier, $this->cc_type, PDO::PARAM_LOB);
                        break;
                    case 'CC_NUM':
                        if (is_resource($this->cc_num)) {
                            rewind($this->cc_num);
                        }
                        $stmt->bindValue($identifier, $this->cc_num, PDO::PARAM_LOB);
                        break;
                    case 'CC_EXP_MONTH':
                        if (is_resource($this->cc_exp_month)) {
                            rewind($this->cc_exp_month);
                        }
                        $stmt->bindValue($identifier, $this->cc_exp_month, PDO::PARAM_LOB);
                        break;
                    case 'CC_EXP_YEAR':
                        if (is_resource($this->cc_exp_year)) {
                            rewind($this->cc_exp_year);
                        }
                        $stmt->bindValue($identifier, $this->cc_exp_year, PDO::PARAM_LOB);
                        break;
                    case 'CC_CODE':
                        if (is_resource($this->cc_code)) {
                            rewind($this->cc_code);
                        }
                        $stmt->bindValue($identifier, $this->cc_code, PDO::PARAM_LOB);
                        break;
                    case 'TXN_ID':
                        $stmt->bindValue($identifier, $this->txn_id, PDO::PARAM_STR);
                        break;
                    case 'PROCESSED_ON':
                        $stmt->bindValue($identifier, $this->processed_on ? $this->processed_on->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                    case 'SUBTOTAL':
                        $stmt->bindValue($identifier, $this->subtotal, PDO::PARAM_STR);
                        break;
                    case 'DISCOUNT':
                        $stmt->bindValue($identifier, $this->discount, PDO::PARAM_STR);
                        break;
                    case 'TAX':
                        $stmt->bindValue($identifier, $this->tax, PDO::PARAM_STR);
                        break;
                    case 'SHIPPING':
                        $stmt->bindValue($identifier, $this->shipping, PDO::PARAM_STR);
                        break;
                    case 'TOTAL':
                        $stmt->bindValue($identifier, $this->total, PDO::PARAM_STR);
                        break;
                    case 'PAID_DEPOSIT':
                        $stmt->bindValue($identifier, $this->paid_deposit, PDO::PARAM_STR);
                        break;
                    case 'AMOUNT_DUE':
                        $stmt->bindValue($identifier, $this->amount_due, PDO::PARAM_STR);
                        break;
                    case 'CURRENCY':
                        $stmt->bindValue($identifier, $this->currency, PDO::PARAM_STR);
                        break;
                    case 'NOTES':
                        $stmt->bindValue($identifier, $this->notes, PDO::PARAM_STR);
                        break;
                    case 'Y_LOGO':
                        $stmt->bindValue($identifier, $this->y_logo, PDO::PARAM_STR);
                        break;
                    case 'Y_COMPANY':
                        $stmt->bindValue($identifier, $this->y_company, PDO::PARAM_STR);
                        break;
                    case 'Y_NAME':
                        $stmt->bindValue($identifier, $this->y_name, PDO::PARAM_STR);
                        break;
                    case 'Y_STREET_ADDRESS':
                        $stmt->bindValue($identifier, $this->y_street_address, PDO::PARAM_STR);
                        break;
                    case 'Y_COUNTRY':
                        $stmt->bindValue($identifier, $this->y_country, PDO::PARAM_INT);
                        break;
                    case 'Y_CITY':
                        $stmt->bindValue($identifier, $this->y_city, PDO::PARAM_STR);
                        break;
                    case 'Y_STATE':
                        $stmt->bindValue($identifier, $this->y_state, PDO::PARAM_STR);
                        break;
                    case 'Y_ZIP':
                        $stmt->bindValue($identifier, $this->y_zip, PDO::PARAM_STR);
                        break;
                    case 'Y_PHONE':
                        $stmt->bindValue($identifier, $this->y_phone, PDO::PARAM_STR);
                        break;
                    case 'Y_FAX':
                        $stmt->bindValue($identifier, $this->y_fax, PDO::PARAM_STR);
                        break;
                    case 'Y_EMAIL':
                        $stmt->bindValue($identifier, $this->y_email, PDO::PARAM_STR);
                        break;
                    case 'Y_URL':
                        $stmt->bindValue($identifier, $this->y_url, PDO::PARAM_STR);
                        break;
                    case 'B_BILLING_ADDRESS':
                        $stmt->bindValue($identifier, $this->b_billing_address, PDO::PARAM_STR);
                        break;
                    case 'B_COMPANY':
                        $stmt->bindValue($identifier, $this->b_company, PDO::PARAM_STR);
                        break;
                    case 'B_NAME':
                        $stmt->bindValue($identifier, $this->b_name, PDO::PARAM_STR);
                        break;
                    case 'B_ADDRESS':
                        $stmt->bindValue($identifier, $this->b_address, PDO::PARAM_STR);
                        break;
                    case 'B_STREET_ADDRESS':
                        $stmt->bindValue($identifier, $this->b_street_address, PDO::PARAM_STR);
                        break;
                    case 'B_COUNTRY':
                        $stmt->bindValue($identifier, $this->b_country, PDO::PARAM_INT);
                        break;
                    case 'B_CITY':
                        $stmt->bindValue($identifier, $this->b_city, PDO::PARAM_STR);
                        break;
                    case 'B_STATE':
                        $stmt->bindValue($identifier, $this->b_state, PDO::PARAM_STR);
                        break;
                    case 'B_ZIP':
                        $stmt->bindValue($identifier, $this->b_zip, PDO::PARAM_STR);
                        break;
                    case 'B_PHONE':
                        $stmt->bindValue($identifier, $this->b_phone, PDO::PARAM_STR);
                        break;
                    case 'B_FAX':
                        $stmt->bindValue($identifier, $this->b_fax, PDO::PARAM_STR);
                        break;
                    case 'B_EMAIL':
                        $stmt->bindValue($identifier, $this->b_email, PDO::PARAM_STR);
                        break;
                    case 'B_URL':
                        $stmt->bindValue($identifier, $this->b_url, PDO::PARAM_STR);
                        break;
                    case 'S_SHIPPING_ADDRESS':
                        $stmt->bindValue($identifier, $this->s_shipping_address, PDO::PARAM_STR);
                        break;
                    case 'S_COMPANY':
                        $stmt->bindValue($identifier, $this->s_company, PDO::PARAM_STR);
                        break;
                    case 'S_NAME':
                        $stmt->bindValue($identifier, $this->s_name, PDO::PARAM_STR);
                        break;
                    case 'S_ADDRESS':
                        $stmt->bindValue($identifier, $this->s_address, PDO::PARAM_STR);
                        break;
                    case 'S_STREET_ADDRESS':
                        $stmt->bindValue($identifier, $this->s_street_address, PDO::PARAM_STR);
                        break;
                    case 'S_COUNTRY':
                        $stmt->bindValue($identifier, $this->s_country, PDO::PARAM_INT);
                        break;
                    case 'S_CITY':
                        $stmt->bindValue($identifier, $this->s_city, PDO::PARAM_STR);
                        break;
                    case 'S_STATE':
                        $stmt->bindValue($identifier, $this->s_state, PDO::PARAM_STR);
                        break;
                    case 'S_ZIP':
                        $stmt->bindValue($identifier, $this->s_zip, PDO::PARAM_STR);
                        break;
                    case 'S_PHONE':
                        $stmt->bindValue($identifier, $this->s_phone, PDO::PARAM_STR);
                        break;
                    case 'S_FAX':
                        $stmt->bindValue($identifier, $this->s_fax, PDO::PARAM_STR);
                        break;
                    case 'S_EMAIL':
                        $stmt->bindValue($identifier, $this->s_email, PDO::PARAM_STR);
                        break;
                    case 'S_URL':
                        $stmt->bindValue($identifier, $this->s_url, PDO::PARAM_STR);
                        break;
                    case 'S_DATE':
                        $stmt->bindValue($identifier, $this->s_date ? $this->s_date->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                    case 'S_TERMS':
                        $stmt->bindValue($identifier, $this->s_terms, PDO::PARAM_STR);
                        break;
                    case 'S_IS_SHIPPED':
                        $stmt->bindValue($identifier, (int) $this->s_is_shipped, PDO::PARAM_INT);
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
        $pos = PluginInvoiceTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getUuid();
                break;
            case 2:
                return $this->getOrderId();
                break;
            case 3:
                return $this->getForeignId();
                break;
            case 4:
                return $this->getIssueDate();
                break;
            case 5:
                return $this->getDueDate();
                break;
            case 6:
                return $this->getCreated();
                break;
            case 7:
                return $this->getModified();
                break;
            case 8:
                return $this->getStatus();
                break;
            case 9:
                return $this->getPaymentMethod();
                break;
            case 10:
                return $this->getCcType();
                break;
            case 11:
                return $this->getCcNum();
                break;
            case 12:
                return $this->getCcExpMonth();
                break;
            case 13:
                return $this->getCcExpYear();
                break;
            case 14:
                return $this->getCcCode();
                break;
            case 15:
                return $this->getTxnId();
                break;
            case 16:
                return $this->getProcessedOn();
                break;
            case 17:
                return $this->getSubtotal();
                break;
            case 18:
                return $this->getDiscount();
                break;
            case 19:
                return $this->getTax();
                break;
            case 20:
                return $this->getShipping();
                break;
            case 21:
                return $this->getTotal();
                break;
            case 22:
                return $this->getPaidDeposit();
                break;
            case 23:
                return $this->getAmountDue();
                break;
            case 24:
                return $this->getCurrency();
                break;
            case 25:
                return $this->getNotes();
                break;
            case 26:
                return $this->getYLogo();
                break;
            case 27:
                return $this->getYCompany();
                break;
            case 28:
                return $this->getYName();
                break;
            case 29:
                return $this->getYStreetAddress();
                break;
            case 30:
                return $this->getYCountry();
                break;
            case 31:
                return $this->getYCity();
                break;
            case 32:
                return $this->getYState();
                break;
            case 33:
                return $this->getYZip();
                break;
            case 34:
                return $this->getYPhone();
                break;
            case 35:
                return $this->getYFax();
                break;
            case 36:
                return $this->getYEmail();
                break;
            case 37:
                return $this->getYUrl();
                break;
            case 38:
                return $this->getBBillingAddress();
                break;
            case 39:
                return $this->getBCompany();
                break;
            case 40:
                return $this->getBName();
                break;
            case 41:
                return $this->getBAddress();
                break;
            case 42:
                return $this->getBStreetAddress();
                break;
            case 43:
                return $this->getBCountry();
                break;
            case 44:
                return $this->getBCity();
                break;
            case 45:
                return $this->getBState();
                break;
            case 46:
                return $this->getBZip();
                break;
            case 47:
                return $this->getBPhone();
                break;
            case 48:
                return $this->getBFax();
                break;
            case 49:
                return $this->getBEmail();
                break;
            case 50:
                return $this->getBUrl();
                break;
            case 51:
                return $this->getSShippingAddress();
                break;
            case 52:
                return $this->getSCompany();
                break;
            case 53:
                return $this->getSName();
                break;
            case 54:
                return $this->getSAddress();
                break;
            case 55:
                return $this->getSStreetAddress();
                break;
            case 56:
                return $this->getSCountry();
                break;
            case 57:
                return $this->getSCity();
                break;
            case 58:
                return $this->getSState();
                break;
            case 59:
                return $this->getSZip();
                break;
            case 60:
                return $this->getSPhone();
                break;
            case 61:
                return $this->getSFax();
                break;
            case 62:
                return $this->getSEmail();
                break;
            case 63:
                return $this->getSUrl();
                break;
            case 64:
                return $this->getSDate();
                break;
            case 65:
                return $this->getSTerms();
                break;
            case 66:
                return $this->getSIsShipped();
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
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = TableMap::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array())
    {
        if (isset($alreadyDumpedObjects['PluginInvoice'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['PluginInvoice'][$this->getPrimaryKey()] = true;
        $keys = PluginInvoiceTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getUuid(),
            $keys[2] => $this->getOrderId(),
            $keys[3] => $this->getForeignId(),
            $keys[4] => $this->getIssueDate(),
            $keys[5] => $this->getDueDate(),
            $keys[6] => $this->getCreated(),
            $keys[7] => $this->getModified(),
            $keys[8] => $this->getStatus(),
            $keys[9] => $this->getPaymentMethod(),
            $keys[10] => $this->getCcType(),
            $keys[11] => $this->getCcNum(),
            $keys[12] => $this->getCcExpMonth(),
            $keys[13] => $this->getCcExpYear(),
            $keys[14] => $this->getCcCode(),
            $keys[15] => $this->getTxnId(),
            $keys[16] => $this->getProcessedOn(),
            $keys[17] => $this->getSubtotal(),
            $keys[18] => $this->getDiscount(),
            $keys[19] => $this->getTax(),
            $keys[20] => $this->getShipping(),
            $keys[21] => $this->getTotal(),
            $keys[22] => $this->getPaidDeposit(),
            $keys[23] => $this->getAmountDue(),
            $keys[24] => $this->getCurrency(),
            $keys[25] => $this->getNotes(),
            $keys[26] => $this->getYLogo(),
            $keys[27] => $this->getYCompany(),
            $keys[28] => $this->getYName(),
            $keys[29] => $this->getYStreetAddress(),
            $keys[30] => $this->getYCountry(),
            $keys[31] => $this->getYCity(),
            $keys[32] => $this->getYState(),
            $keys[33] => $this->getYZip(),
            $keys[34] => $this->getYPhone(),
            $keys[35] => $this->getYFax(),
            $keys[36] => $this->getYEmail(),
            $keys[37] => $this->getYUrl(),
            $keys[38] => $this->getBBillingAddress(),
            $keys[39] => $this->getBCompany(),
            $keys[40] => $this->getBName(),
            $keys[41] => $this->getBAddress(),
            $keys[42] => $this->getBStreetAddress(),
            $keys[43] => $this->getBCountry(),
            $keys[44] => $this->getBCity(),
            $keys[45] => $this->getBState(),
            $keys[46] => $this->getBZip(),
            $keys[47] => $this->getBPhone(),
            $keys[48] => $this->getBFax(),
            $keys[49] => $this->getBEmail(),
            $keys[50] => $this->getBUrl(),
            $keys[51] => $this->getSShippingAddress(),
            $keys[52] => $this->getSCompany(),
            $keys[53] => $this->getSName(),
            $keys[54] => $this->getSAddress(),
            $keys[55] => $this->getSStreetAddress(),
            $keys[56] => $this->getSCountry(),
            $keys[57] => $this->getSCity(),
            $keys[58] => $this->getSState(),
            $keys[59] => $this->getSZip(),
            $keys[60] => $this->getSPhone(),
            $keys[61] => $this->getSFax(),
            $keys[62] => $this->getSEmail(),
            $keys[63] => $this->getSUrl(),
            $keys[64] => $this->getSDate(),
            $keys[65] => $this->getSTerms(),
            $keys[66] => $this->getSIsShipped(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
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
        $pos = PluginInvoiceTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

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
                $this->setUuid($value);
                break;
            case 2:
                $this->setOrderId($value);
                break;
            case 3:
                $this->setForeignId($value);
                break;
            case 4:
                $this->setIssueDate($value);
                break;
            case 5:
                $this->setDueDate($value);
                break;
            case 6:
                $this->setCreated($value);
                break;
            case 7:
                $this->setModified($value);
                break;
            case 8:
                $this->setStatus($value);
                break;
            case 9:
                $this->setPaymentMethod($value);
                break;
            case 10:
                $this->setCcType($value);
                break;
            case 11:
                $this->setCcNum($value);
                break;
            case 12:
                $this->setCcExpMonth($value);
                break;
            case 13:
                $this->setCcExpYear($value);
                break;
            case 14:
                $this->setCcCode($value);
                break;
            case 15:
                $this->setTxnId($value);
                break;
            case 16:
                $this->setProcessedOn($value);
                break;
            case 17:
                $this->setSubtotal($value);
                break;
            case 18:
                $this->setDiscount($value);
                break;
            case 19:
                $this->setTax($value);
                break;
            case 20:
                $this->setShipping($value);
                break;
            case 21:
                $this->setTotal($value);
                break;
            case 22:
                $this->setPaidDeposit($value);
                break;
            case 23:
                $this->setAmountDue($value);
                break;
            case 24:
                $this->setCurrency($value);
                break;
            case 25:
                $this->setNotes($value);
                break;
            case 26:
                $this->setYLogo($value);
                break;
            case 27:
                $this->setYCompany($value);
                break;
            case 28:
                $this->setYName($value);
                break;
            case 29:
                $this->setYStreetAddress($value);
                break;
            case 30:
                $this->setYCountry($value);
                break;
            case 31:
                $this->setYCity($value);
                break;
            case 32:
                $this->setYState($value);
                break;
            case 33:
                $this->setYZip($value);
                break;
            case 34:
                $this->setYPhone($value);
                break;
            case 35:
                $this->setYFax($value);
                break;
            case 36:
                $this->setYEmail($value);
                break;
            case 37:
                $this->setYUrl($value);
                break;
            case 38:
                $this->setBBillingAddress($value);
                break;
            case 39:
                $this->setBCompany($value);
                break;
            case 40:
                $this->setBName($value);
                break;
            case 41:
                $this->setBAddress($value);
                break;
            case 42:
                $this->setBStreetAddress($value);
                break;
            case 43:
                $this->setBCountry($value);
                break;
            case 44:
                $this->setBCity($value);
                break;
            case 45:
                $this->setBState($value);
                break;
            case 46:
                $this->setBZip($value);
                break;
            case 47:
                $this->setBPhone($value);
                break;
            case 48:
                $this->setBFax($value);
                break;
            case 49:
                $this->setBEmail($value);
                break;
            case 50:
                $this->setBUrl($value);
                break;
            case 51:
                $this->setSShippingAddress($value);
                break;
            case 52:
                $this->setSCompany($value);
                break;
            case 53:
                $this->setSName($value);
                break;
            case 54:
                $this->setSAddress($value);
                break;
            case 55:
                $this->setSStreetAddress($value);
                break;
            case 56:
                $this->setSCountry($value);
                break;
            case 57:
                $this->setSCity($value);
                break;
            case 58:
                $this->setSState($value);
                break;
            case 59:
                $this->setSZip($value);
                break;
            case 60:
                $this->setSPhone($value);
                break;
            case 61:
                $this->setSFax($value);
                break;
            case 62:
                $this->setSEmail($value);
                break;
            case 63:
                $this->setSUrl($value);
                break;
            case 64:
                $this->setSDate($value);
                break;
            case 65:
                $this->setSTerms($value);
                break;
            case 66:
                $this->setSIsShipped($value);
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
        $keys = PluginInvoiceTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setUuid($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setOrderId($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setForeignId($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setIssueDate($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setDueDate($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setCreated($arr[$keys[6]]);
        if (array_key_exists($keys[7], $arr)) $this->setModified($arr[$keys[7]]);
        if (array_key_exists($keys[8], $arr)) $this->setStatus($arr[$keys[8]]);
        if (array_key_exists($keys[9], $arr)) $this->setPaymentMethod($arr[$keys[9]]);
        if (array_key_exists($keys[10], $arr)) $this->setCcType($arr[$keys[10]]);
        if (array_key_exists($keys[11], $arr)) $this->setCcNum($arr[$keys[11]]);
        if (array_key_exists($keys[12], $arr)) $this->setCcExpMonth($arr[$keys[12]]);
        if (array_key_exists($keys[13], $arr)) $this->setCcExpYear($arr[$keys[13]]);
        if (array_key_exists($keys[14], $arr)) $this->setCcCode($arr[$keys[14]]);
        if (array_key_exists($keys[15], $arr)) $this->setTxnId($arr[$keys[15]]);
        if (array_key_exists($keys[16], $arr)) $this->setProcessedOn($arr[$keys[16]]);
        if (array_key_exists($keys[17], $arr)) $this->setSubtotal($arr[$keys[17]]);
        if (array_key_exists($keys[18], $arr)) $this->setDiscount($arr[$keys[18]]);
        if (array_key_exists($keys[19], $arr)) $this->setTax($arr[$keys[19]]);
        if (array_key_exists($keys[20], $arr)) $this->setShipping($arr[$keys[20]]);
        if (array_key_exists($keys[21], $arr)) $this->setTotal($arr[$keys[21]]);
        if (array_key_exists($keys[22], $arr)) $this->setPaidDeposit($arr[$keys[22]]);
        if (array_key_exists($keys[23], $arr)) $this->setAmountDue($arr[$keys[23]]);
        if (array_key_exists($keys[24], $arr)) $this->setCurrency($arr[$keys[24]]);
        if (array_key_exists($keys[25], $arr)) $this->setNotes($arr[$keys[25]]);
        if (array_key_exists($keys[26], $arr)) $this->setYLogo($arr[$keys[26]]);
        if (array_key_exists($keys[27], $arr)) $this->setYCompany($arr[$keys[27]]);
        if (array_key_exists($keys[28], $arr)) $this->setYName($arr[$keys[28]]);
        if (array_key_exists($keys[29], $arr)) $this->setYStreetAddress($arr[$keys[29]]);
        if (array_key_exists($keys[30], $arr)) $this->setYCountry($arr[$keys[30]]);
        if (array_key_exists($keys[31], $arr)) $this->setYCity($arr[$keys[31]]);
        if (array_key_exists($keys[32], $arr)) $this->setYState($arr[$keys[32]]);
        if (array_key_exists($keys[33], $arr)) $this->setYZip($arr[$keys[33]]);
        if (array_key_exists($keys[34], $arr)) $this->setYPhone($arr[$keys[34]]);
        if (array_key_exists($keys[35], $arr)) $this->setYFax($arr[$keys[35]]);
        if (array_key_exists($keys[36], $arr)) $this->setYEmail($arr[$keys[36]]);
        if (array_key_exists($keys[37], $arr)) $this->setYUrl($arr[$keys[37]]);
        if (array_key_exists($keys[38], $arr)) $this->setBBillingAddress($arr[$keys[38]]);
        if (array_key_exists($keys[39], $arr)) $this->setBCompany($arr[$keys[39]]);
        if (array_key_exists($keys[40], $arr)) $this->setBName($arr[$keys[40]]);
        if (array_key_exists($keys[41], $arr)) $this->setBAddress($arr[$keys[41]]);
        if (array_key_exists($keys[42], $arr)) $this->setBStreetAddress($arr[$keys[42]]);
        if (array_key_exists($keys[43], $arr)) $this->setBCountry($arr[$keys[43]]);
        if (array_key_exists($keys[44], $arr)) $this->setBCity($arr[$keys[44]]);
        if (array_key_exists($keys[45], $arr)) $this->setBState($arr[$keys[45]]);
        if (array_key_exists($keys[46], $arr)) $this->setBZip($arr[$keys[46]]);
        if (array_key_exists($keys[47], $arr)) $this->setBPhone($arr[$keys[47]]);
        if (array_key_exists($keys[48], $arr)) $this->setBFax($arr[$keys[48]]);
        if (array_key_exists($keys[49], $arr)) $this->setBEmail($arr[$keys[49]]);
        if (array_key_exists($keys[50], $arr)) $this->setBUrl($arr[$keys[50]]);
        if (array_key_exists($keys[51], $arr)) $this->setSShippingAddress($arr[$keys[51]]);
        if (array_key_exists($keys[52], $arr)) $this->setSCompany($arr[$keys[52]]);
        if (array_key_exists($keys[53], $arr)) $this->setSName($arr[$keys[53]]);
        if (array_key_exists($keys[54], $arr)) $this->setSAddress($arr[$keys[54]]);
        if (array_key_exists($keys[55], $arr)) $this->setSStreetAddress($arr[$keys[55]]);
        if (array_key_exists($keys[56], $arr)) $this->setSCountry($arr[$keys[56]]);
        if (array_key_exists($keys[57], $arr)) $this->setSCity($arr[$keys[57]]);
        if (array_key_exists($keys[58], $arr)) $this->setSState($arr[$keys[58]]);
        if (array_key_exists($keys[59], $arr)) $this->setSZip($arr[$keys[59]]);
        if (array_key_exists($keys[60], $arr)) $this->setSPhone($arr[$keys[60]]);
        if (array_key_exists($keys[61], $arr)) $this->setSFax($arr[$keys[61]]);
        if (array_key_exists($keys[62], $arr)) $this->setSEmail($arr[$keys[62]]);
        if (array_key_exists($keys[63], $arr)) $this->setSUrl($arr[$keys[63]]);
        if (array_key_exists($keys[64], $arr)) $this->setSDate($arr[$keys[64]]);
        if (array_key_exists($keys[65], $arr)) $this->setSTerms($arr[$keys[65]]);
        if (array_key_exists($keys[66], $arr)) $this->setSIsShipped($arr[$keys[66]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(PluginInvoiceTableMap::DATABASE_NAME);

        if ($this->isColumnModified(PluginInvoiceTableMap::ID)) $criteria->add(PluginInvoiceTableMap::ID, $this->id);
        if ($this->isColumnModified(PluginInvoiceTableMap::UUID)) $criteria->add(PluginInvoiceTableMap::UUID, $this->uuid);
        if ($this->isColumnModified(PluginInvoiceTableMap::ORDER_ID)) $criteria->add(PluginInvoiceTableMap::ORDER_ID, $this->order_id);
        if ($this->isColumnModified(PluginInvoiceTableMap::FOREIGN_ID)) $criteria->add(PluginInvoiceTableMap::FOREIGN_ID, $this->foreign_id);
        if ($this->isColumnModified(PluginInvoiceTableMap::ISSUE_DATE)) $criteria->add(PluginInvoiceTableMap::ISSUE_DATE, $this->issue_date);
        if ($this->isColumnModified(PluginInvoiceTableMap::DUE_DATE)) $criteria->add(PluginInvoiceTableMap::DUE_DATE, $this->due_date);
        if ($this->isColumnModified(PluginInvoiceTableMap::CREATED)) $criteria->add(PluginInvoiceTableMap::CREATED, $this->created);
        if ($this->isColumnModified(PluginInvoiceTableMap::MODIFIED)) $criteria->add(PluginInvoiceTableMap::MODIFIED, $this->modified);
        if ($this->isColumnModified(PluginInvoiceTableMap::STATUS)) $criteria->add(PluginInvoiceTableMap::STATUS, $this->status);
        if ($this->isColumnModified(PluginInvoiceTableMap::PAYMENT_METHOD)) $criteria->add(PluginInvoiceTableMap::PAYMENT_METHOD, $this->payment_method);
        if ($this->isColumnModified(PluginInvoiceTableMap::CC_TYPE)) $criteria->add(PluginInvoiceTableMap::CC_TYPE, $this->cc_type);
        if ($this->isColumnModified(PluginInvoiceTableMap::CC_NUM)) $criteria->add(PluginInvoiceTableMap::CC_NUM, $this->cc_num);
        if ($this->isColumnModified(PluginInvoiceTableMap::CC_EXP_MONTH)) $criteria->add(PluginInvoiceTableMap::CC_EXP_MONTH, $this->cc_exp_month);
        if ($this->isColumnModified(PluginInvoiceTableMap::CC_EXP_YEAR)) $criteria->add(PluginInvoiceTableMap::CC_EXP_YEAR, $this->cc_exp_year);
        if ($this->isColumnModified(PluginInvoiceTableMap::CC_CODE)) $criteria->add(PluginInvoiceTableMap::CC_CODE, $this->cc_code);
        if ($this->isColumnModified(PluginInvoiceTableMap::TXN_ID)) $criteria->add(PluginInvoiceTableMap::TXN_ID, $this->txn_id);
        if ($this->isColumnModified(PluginInvoiceTableMap::PROCESSED_ON)) $criteria->add(PluginInvoiceTableMap::PROCESSED_ON, $this->processed_on);
        if ($this->isColumnModified(PluginInvoiceTableMap::SUBTOTAL)) $criteria->add(PluginInvoiceTableMap::SUBTOTAL, $this->subtotal);
        if ($this->isColumnModified(PluginInvoiceTableMap::DISCOUNT)) $criteria->add(PluginInvoiceTableMap::DISCOUNT, $this->discount);
        if ($this->isColumnModified(PluginInvoiceTableMap::TAX)) $criteria->add(PluginInvoiceTableMap::TAX, $this->tax);
        if ($this->isColumnModified(PluginInvoiceTableMap::SHIPPING)) $criteria->add(PluginInvoiceTableMap::SHIPPING, $this->shipping);
        if ($this->isColumnModified(PluginInvoiceTableMap::TOTAL)) $criteria->add(PluginInvoiceTableMap::TOTAL, $this->total);
        if ($this->isColumnModified(PluginInvoiceTableMap::PAID_DEPOSIT)) $criteria->add(PluginInvoiceTableMap::PAID_DEPOSIT, $this->paid_deposit);
        if ($this->isColumnModified(PluginInvoiceTableMap::AMOUNT_DUE)) $criteria->add(PluginInvoiceTableMap::AMOUNT_DUE, $this->amount_due);
        if ($this->isColumnModified(PluginInvoiceTableMap::CURRENCY)) $criteria->add(PluginInvoiceTableMap::CURRENCY, $this->currency);
        if ($this->isColumnModified(PluginInvoiceTableMap::NOTES)) $criteria->add(PluginInvoiceTableMap::NOTES, $this->notes);
        if ($this->isColumnModified(PluginInvoiceTableMap::Y_LOGO)) $criteria->add(PluginInvoiceTableMap::Y_LOGO, $this->y_logo);
        if ($this->isColumnModified(PluginInvoiceTableMap::Y_COMPANY)) $criteria->add(PluginInvoiceTableMap::Y_COMPANY, $this->y_company);
        if ($this->isColumnModified(PluginInvoiceTableMap::Y_NAME)) $criteria->add(PluginInvoiceTableMap::Y_NAME, $this->y_name);
        if ($this->isColumnModified(PluginInvoiceTableMap::Y_STREET_ADDRESS)) $criteria->add(PluginInvoiceTableMap::Y_STREET_ADDRESS, $this->y_street_address);
        if ($this->isColumnModified(PluginInvoiceTableMap::Y_COUNTRY)) $criteria->add(PluginInvoiceTableMap::Y_COUNTRY, $this->y_country);
        if ($this->isColumnModified(PluginInvoiceTableMap::Y_CITY)) $criteria->add(PluginInvoiceTableMap::Y_CITY, $this->y_city);
        if ($this->isColumnModified(PluginInvoiceTableMap::Y_STATE)) $criteria->add(PluginInvoiceTableMap::Y_STATE, $this->y_state);
        if ($this->isColumnModified(PluginInvoiceTableMap::Y_ZIP)) $criteria->add(PluginInvoiceTableMap::Y_ZIP, $this->y_zip);
        if ($this->isColumnModified(PluginInvoiceTableMap::Y_PHONE)) $criteria->add(PluginInvoiceTableMap::Y_PHONE, $this->y_phone);
        if ($this->isColumnModified(PluginInvoiceTableMap::Y_FAX)) $criteria->add(PluginInvoiceTableMap::Y_FAX, $this->y_fax);
        if ($this->isColumnModified(PluginInvoiceTableMap::Y_EMAIL)) $criteria->add(PluginInvoiceTableMap::Y_EMAIL, $this->y_email);
        if ($this->isColumnModified(PluginInvoiceTableMap::Y_URL)) $criteria->add(PluginInvoiceTableMap::Y_URL, $this->y_url);
        if ($this->isColumnModified(PluginInvoiceTableMap::B_BILLING_ADDRESS)) $criteria->add(PluginInvoiceTableMap::B_BILLING_ADDRESS, $this->b_billing_address);
        if ($this->isColumnModified(PluginInvoiceTableMap::B_COMPANY)) $criteria->add(PluginInvoiceTableMap::B_COMPANY, $this->b_company);
        if ($this->isColumnModified(PluginInvoiceTableMap::B_NAME)) $criteria->add(PluginInvoiceTableMap::B_NAME, $this->b_name);
        if ($this->isColumnModified(PluginInvoiceTableMap::B_ADDRESS)) $criteria->add(PluginInvoiceTableMap::B_ADDRESS, $this->b_address);
        if ($this->isColumnModified(PluginInvoiceTableMap::B_STREET_ADDRESS)) $criteria->add(PluginInvoiceTableMap::B_STREET_ADDRESS, $this->b_street_address);
        if ($this->isColumnModified(PluginInvoiceTableMap::B_COUNTRY)) $criteria->add(PluginInvoiceTableMap::B_COUNTRY, $this->b_country);
        if ($this->isColumnModified(PluginInvoiceTableMap::B_CITY)) $criteria->add(PluginInvoiceTableMap::B_CITY, $this->b_city);
        if ($this->isColumnModified(PluginInvoiceTableMap::B_STATE)) $criteria->add(PluginInvoiceTableMap::B_STATE, $this->b_state);
        if ($this->isColumnModified(PluginInvoiceTableMap::B_ZIP)) $criteria->add(PluginInvoiceTableMap::B_ZIP, $this->b_zip);
        if ($this->isColumnModified(PluginInvoiceTableMap::B_PHONE)) $criteria->add(PluginInvoiceTableMap::B_PHONE, $this->b_phone);
        if ($this->isColumnModified(PluginInvoiceTableMap::B_FAX)) $criteria->add(PluginInvoiceTableMap::B_FAX, $this->b_fax);
        if ($this->isColumnModified(PluginInvoiceTableMap::B_EMAIL)) $criteria->add(PluginInvoiceTableMap::B_EMAIL, $this->b_email);
        if ($this->isColumnModified(PluginInvoiceTableMap::B_URL)) $criteria->add(PluginInvoiceTableMap::B_URL, $this->b_url);
        if ($this->isColumnModified(PluginInvoiceTableMap::S_SHIPPING_ADDRESS)) $criteria->add(PluginInvoiceTableMap::S_SHIPPING_ADDRESS, $this->s_shipping_address);
        if ($this->isColumnModified(PluginInvoiceTableMap::S_COMPANY)) $criteria->add(PluginInvoiceTableMap::S_COMPANY, $this->s_company);
        if ($this->isColumnModified(PluginInvoiceTableMap::S_NAME)) $criteria->add(PluginInvoiceTableMap::S_NAME, $this->s_name);
        if ($this->isColumnModified(PluginInvoiceTableMap::S_ADDRESS)) $criteria->add(PluginInvoiceTableMap::S_ADDRESS, $this->s_address);
        if ($this->isColumnModified(PluginInvoiceTableMap::S_STREET_ADDRESS)) $criteria->add(PluginInvoiceTableMap::S_STREET_ADDRESS, $this->s_street_address);
        if ($this->isColumnModified(PluginInvoiceTableMap::S_COUNTRY)) $criteria->add(PluginInvoiceTableMap::S_COUNTRY, $this->s_country);
        if ($this->isColumnModified(PluginInvoiceTableMap::S_CITY)) $criteria->add(PluginInvoiceTableMap::S_CITY, $this->s_city);
        if ($this->isColumnModified(PluginInvoiceTableMap::S_STATE)) $criteria->add(PluginInvoiceTableMap::S_STATE, $this->s_state);
        if ($this->isColumnModified(PluginInvoiceTableMap::S_ZIP)) $criteria->add(PluginInvoiceTableMap::S_ZIP, $this->s_zip);
        if ($this->isColumnModified(PluginInvoiceTableMap::S_PHONE)) $criteria->add(PluginInvoiceTableMap::S_PHONE, $this->s_phone);
        if ($this->isColumnModified(PluginInvoiceTableMap::S_FAX)) $criteria->add(PluginInvoiceTableMap::S_FAX, $this->s_fax);
        if ($this->isColumnModified(PluginInvoiceTableMap::S_EMAIL)) $criteria->add(PluginInvoiceTableMap::S_EMAIL, $this->s_email);
        if ($this->isColumnModified(PluginInvoiceTableMap::S_URL)) $criteria->add(PluginInvoiceTableMap::S_URL, $this->s_url);
        if ($this->isColumnModified(PluginInvoiceTableMap::S_DATE)) $criteria->add(PluginInvoiceTableMap::S_DATE, $this->s_date);
        if ($this->isColumnModified(PluginInvoiceTableMap::S_TERMS)) $criteria->add(PluginInvoiceTableMap::S_TERMS, $this->s_terms);
        if ($this->isColumnModified(PluginInvoiceTableMap::S_IS_SHIPPED)) $criteria->add(PluginInvoiceTableMap::S_IS_SHIPPED, $this->s_is_shipped);

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
        $criteria = new Criteria(PluginInvoiceTableMap::DATABASE_NAME);
        $criteria->add(PluginInvoiceTableMap::ID, $this->id);

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
     * @param      object $copyObj An object of \HookCalendar\Model\PluginInvoice (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setUuid($this->getUuid());
        $copyObj->setOrderId($this->getOrderId());
        $copyObj->setForeignId($this->getForeignId());
        $copyObj->setIssueDate($this->getIssueDate());
        $copyObj->setDueDate($this->getDueDate());
        $copyObj->setCreated($this->getCreated());
        $copyObj->setModified($this->getModified());
        $copyObj->setStatus($this->getStatus());
        $copyObj->setPaymentMethod($this->getPaymentMethod());
        $copyObj->setCcType($this->getCcType());
        $copyObj->setCcNum($this->getCcNum());
        $copyObj->setCcExpMonth($this->getCcExpMonth());
        $copyObj->setCcExpYear($this->getCcExpYear());
        $copyObj->setCcCode($this->getCcCode());
        $copyObj->setTxnId($this->getTxnId());
        $copyObj->setProcessedOn($this->getProcessedOn());
        $copyObj->setSubtotal($this->getSubtotal());
        $copyObj->setDiscount($this->getDiscount());
        $copyObj->setTax($this->getTax());
        $copyObj->setShipping($this->getShipping());
        $copyObj->setTotal($this->getTotal());
        $copyObj->setPaidDeposit($this->getPaidDeposit());
        $copyObj->setAmountDue($this->getAmountDue());
        $copyObj->setCurrency($this->getCurrency());
        $copyObj->setNotes($this->getNotes());
        $copyObj->setYLogo($this->getYLogo());
        $copyObj->setYCompany($this->getYCompany());
        $copyObj->setYName($this->getYName());
        $copyObj->setYStreetAddress($this->getYStreetAddress());
        $copyObj->setYCountry($this->getYCountry());
        $copyObj->setYCity($this->getYCity());
        $copyObj->setYState($this->getYState());
        $copyObj->setYZip($this->getYZip());
        $copyObj->setYPhone($this->getYPhone());
        $copyObj->setYFax($this->getYFax());
        $copyObj->setYEmail($this->getYEmail());
        $copyObj->setYUrl($this->getYUrl());
        $copyObj->setBBillingAddress($this->getBBillingAddress());
        $copyObj->setBCompany($this->getBCompany());
        $copyObj->setBName($this->getBName());
        $copyObj->setBAddress($this->getBAddress());
        $copyObj->setBStreetAddress($this->getBStreetAddress());
        $copyObj->setBCountry($this->getBCountry());
        $copyObj->setBCity($this->getBCity());
        $copyObj->setBState($this->getBState());
        $copyObj->setBZip($this->getBZip());
        $copyObj->setBPhone($this->getBPhone());
        $copyObj->setBFax($this->getBFax());
        $copyObj->setBEmail($this->getBEmail());
        $copyObj->setBUrl($this->getBUrl());
        $copyObj->setSShippingAddress($this->getSShippingAddress());
        $copyObj->setSCompany($this->getSCompany());
        $copyObj->setSName($this->getSName());
        $copyObj->setSAddress($this->getSAddress());
        $copyObj->setSStreetAddress($this->getSStreetAddress());
        $copyObj->setSCountry($this->getSCountry());
        $copyObj->setSCity($this->getSCity());
        $copyObj->setSState($this->getSState());
        $copyObj->setSZip($this->getSZip());
        $copyObj->setSPhone($this->getSPhone());
        $copyObj->setSFax($this->getSFax());
        $copyObj->setSEmail($this->getSEmail());
        $copyObj->setSUrl($this->getSUrl());
        $copyObj->setSDate($this->getSDate());
        $copyObj->setSTerms($this->getSTerms());
        $copyObj->setSIsShipped($this->getSIsShipped());
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
     * @return                 \HookCalendar\Model\PluginInvoice Clone of current object.
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
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->id = null;
        $this->uuid = null;
        $this->order_id = null;
        $this->foreign_id = null;
        $this->issue_date = null;
        $this->due_date = null;
        $this->created = null;
        $this->modified = null;
        $this->status = null;
        $this->payment_method = null;
        $this->cc_type = null;
        $this->cc_num = null;
        $this->cc_exp_month = null;
        $this->cc_exp_year = null;
        $this->cc_code = null;
        $this->txn_id = null;
        $this->processed_on = null;
        $this->subtotal = null;
        $this->discount = null;
        $this->tax = null;
        $this->shipping = null;
        $this->total = null;
        $this->paid_deposit = null;
        $this->amount_due = null;
        $this->currency = null;
        $this->notes = null;
        $this->y_logo = null;
        $this->y_company = null;
        $this->y_name = null;
        $this->y_street_address = null;
        $this->y_country = null;
        $this->y_city = null;
        $this->y_state = null;
        $this->y_zip = null;
        $this->y_phone = null;
        $this->y_fax = null;
        $this->y_email = null;
        $this->y_url = null;
        $this->b_billing_address = null;
        $this->b_company = null;
        $this->b_name = null;
        $this->b_address = null;
        $this->b_street_address = null;
        $this->b_country = null;
        $this->b_city = null;
        $this->b_state = null;
        $this->b_zip = null;
        $this->b_phone = null;
        $this->b_fax = null;
        $this->b_email = null;
        $this->b_url = null;
        $this->s_shipping_address = null;
        $this->s_company = null;
        $this->s_name = null;
        $this->s_address = null;
        $this->s_street_address = null;
        $this->s_country = null;
        $this->s_city = null;
        $this->s_state = null;
        $this->s_zip = null;
        $this->s_phone = null;
        $this->s_fax = null;
        $this->s_email = null;
        $this->s_url = null;
        $this->s_date = null;
        $this->s_terms = null;
        $this->s_is_shipped = null;
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

    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(PluginInvoiceTableMap::DEFAULT_STRING_FORMAT);
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
