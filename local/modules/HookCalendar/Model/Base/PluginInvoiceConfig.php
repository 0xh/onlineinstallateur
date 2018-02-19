<?php

namespace HookCalendar\Model\Base;

use \Exception;
use \PDO;
use HookCalendar\Model\PluginInvoiceConfigQuery as ChildPluginInvoiceConfigQuery;
use HookCalendar\Model\Map\PluginInvoiceConfigTableMap;
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

abstract class PluginInvoiceConfig implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\HookCalendar\\Model\\Map\\PluginInvoiceConfigTableMap';


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
     * The value for the y_template field.
     * @var        string
     */
    protected $y_template;

    /**
     * The value for the p_accept_payments field.
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $p_accept_payments;

    /**
     * The value for the p_accept_paypal field.
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $p_accept_paypal;

    /**
     * The value for the p_accept_authorize field.
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $p_accept_authorize;

    /**
     * The value for the p_accept_creditcard field.
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $p_accept_creditcard;

    /**
     * The value for the p_accept_cash field.
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $p_accept_cash;

    /**
     * The value for the p_accept_bank field.
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $p_accept_bank;

    /**
     * The value for the p_paypal_address field.
     * @var        string
     */
    protected $p_paypal_address;

    /**
     * The value for the p_authorize_tz field.
     * @var        string
     */
    protected $p_authorize_tz;

    /**
     * The value for the p_authorize_key field.
     * @var        string
     */
    protected $p_authorize_key;

    /**
     * The value for the p_authorize_mid field.
     * @var        string
     */
    protected $p_authorize_mid;

    /**
     * The value for the p_authorize_hash field.
     * @var        string
     */
    protected $p_authorize_hash;

    /**
     * The value for the p_bank_account field.
     * @var        string
     */
    protected $p_bank_account;

    /**
     * The value for the si_include field.
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $si_include;

    /**
     * The value for the si_shipping_address field.
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $si_shipping_address;

    /**
     * The value for the si_company field.
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $si_company;

    /**
     * The value for the si_name field.
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $si_name;

    /**
     * The value for the si_address field.
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $si_address;

    /**
     * The value for the si_street_address field.
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $si_street_address;

    /**
     * The value for the si_city field.
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $si_city;

    /**
     * The value for the si_state field.
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $si_state;

    /**
     * The value for the si_zip field.
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $si_zip;

    /**
     * The value for the si_phone field.
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $si_phone;

    /**
     * The value for the si_fax field.
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $si_fax;

    /**
     * The value for the si_email field.
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $si_email;

    /**
     * The value for the si_url field.
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $si_url;

    /**
     * The value for the si_date field.
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $si_date;

    /**
     * The value for the si_terms field.
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $si_terms;

    /**
     * The value for the si_is_shipped field.
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $si_is_shipped;

    /**
     * The value for the si_shipping field.
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $si_shipping;

    /**
     * The value for the o_booking_url field.
     * @var        string
     */
    protected $o_booking_url;

    /**
     * The value for the o_qty_is_int field.
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $o_qty_is_int;

    /**
     * The value for the o_use_qty_unit_price field.
     * Note: this column has a database default value of: true
     * @var        boolean
     */
    protected $o_use_qty_unit_price;

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
        $this->p_accept_payments = false;
        $this->p_accept_paypal = false;
        $this->p_accept_authorize = false;
        $this->p_accept_creditcard = false;
        $this->p_accept_cash = false;
        $this->p_accept_bank = false;
        $this->si_include = false;
        $this->si_shipping_address = false;
        $this->si_company = false;
        $this->si_name = false;
        $this->si_address = false;
        $this->si_street_address = false;
        $this->si_city = false;
        $this->si_state = false;
        $this->si_zip = false;
        $this->si_phone = false;
        $this->si_fax = false;
        $this->si_email = false;
        $this->si_url = false;
        $this->si_date = false;
        $this->si_terms = false;
        $this->si_is_shipped = false;
        $this->si_shipping = false;
        $this->o_qty_is_int = false;
        $this->o_use_qty_unit_price = true;
    }

    /**
     * Initializes internal state of HookCalendar\Model\Base\PluginInvoiceConfig object.
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
     * Compares this with another <code>PluginInvoiceConfig</code> instance.  If
     * <code>obj</code> is an instance of <code>PluginInvoiceConfig</code>, delegates to
     * <code>equals(PluginInvoiceConfig)</code>.  Otherwise, returns <code>false</code>.
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
     * @return PluginInvoiceConfig The current object, for fluid interface
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
     * @return PluginInvoiceConfig The current object, for fluid interface
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
     * Get the [y_template] column value.
     *
     * @return   string
     */
    public function getYTemplate()
    {

        return $this->y_template;
    }

    /**
     * Get the [p_accept_payments] column value.
     *
     * @return   boolean
     */
    public function getPAcceptPayments()
    {

        return $this->p_accept_payments;
    }

    /**
     * Get the [p_accept_paypal] column value.
     *
     * @return   boolean
     */
    public function getPAcceptPaypal()
    {

        return $this->p_accept_paypal;
    }

    /**
     * Get the [p_accept_authorize] column value.
     *
     * @return   boolean
     */
    public function getPAcceptAuthorize()
    {

        return $this->p_accept_authorize;
    }

    /**
     * Get the [p_accept_creditcard] column value.
     *
     * @return   boolean
     */
    public function getPAcceptCreditcard()
    {

        return $this->p_accept_creditcard;
    }

    /**
     * Get the [p_accept_cash] column value.
     *
     * @return   boolean
     */
    public function getPAcceptCash()
    {

        return $this->p_accept_cash;
    }

    /**
     * Get the [p_accept_bank] column value.
     *
     * @return   boolean
     */
    public function getPAcceptBank()
    {

        return $this->p_accept_bank;
    }

    /**
     * Get the [p_paypal_address] column value.
     *
     * @return   string
     */
    public function getPPaypalAddress()
    {

        return $this->p_paypal_address;
    }

    /**
     * Get the [p_authorize_tz] column value.
     *
     * @return   string
     */
    public function getPAuthorizeTz()
    {

        return $this->p_authorize_tz;
    }

    /**
     * Get the [p_authorize_key] column value.
     *
     * @return   string
     */
    public function getPAuthorizeKey()
    {

        return $this->p_authorize_key;
    }

    /**
     * Get the [p_authorize_mid] column value.
     *
     * @return   string
     */
    public function getPAuthorizeMid()
    {

        return $this->p_authorize_mid;
    }

    /**
     * Get the [p_authorize_hash] column value.
     *
     * @return   string
     */
    public function getPAuthorizeHash()
    {

        return $this->p_authorize_hash;
    }

    /**
     * Get the [p_bank_account] column value.
     *
     * @return   string
     */
    public function getPBankAccount()
    {

        return $this->p_bank_account;
    }

    /**
     * Get the [si_include] column value.
     *
     * @return   boolean
     */
    public function getSiInclude()
    {

        return $this->si_include;
    }

    /**
     * Get the [si_shipping_address] column value.
     *
     * @return   boolean
     */
    public function getSiShippingAddress()
    {

        return $this->si_shipping_address;
    }

    /**
     * Get the [si_company] column value.
     *
     * @return   boolean
     */
    public function getSiCompany()
    {

        return $this->si_company;
    }

    /**
     * Get the [si_name] column value.
     *
     * @return   boolean
     */
    public function getSiName()
    {

        return $this->si_name;
    }

    /**
     * Get the [si_address] column value.
     *
     * @return   boolean
     */
    public function getSiAddress()
    {

        return $this->si_address;
    }

    /**
     * Get the [si_street_address] column value.
     *
     * @return   boolean
     */
    public function getSiStreetAddress()
    {

        return $this->si_street_address;
    }

    /**
     * Get the [si_city] column value.
     *
     * @return   boolean
     */
    public function getSiCity()
    {

        return $this->si_city;
    }

    /**
     * Get the [si_state] column value.
     *
     * @return   boolean
     */
    public function getSiState()
    {

        return $this->si_state;
    }

    /**
     * Get the [si_zip] column value.
     *
     * @return   boolean
     */
    public function getSiZip()
    {

        return $this->si_zip;
    }

    /**
     * Get the [si_phone] column value.
     *
     * @return   boolean
     */
    public function getSiPhone()
    {

        return $this->si_phone;
    }

    /**
     * Get the [si_fax] column value.
     *
     * @return   boolean
     */
    public function getSiFax()
    {

        return $this->si_fax;
    }

    /**
     * Get the [si_email] column value.
     *
     * @return   boolean
     */
    public function getSiEmail()
    {

        return $this->si_email;
    }

    /**
     * Get the [si_url] column value.
     *
     * @return   boolean
     */
    public function getSiUrl()
    {

        return $this->si_url;
    }

    /**
     * Get the [si_date] column value.
     *
     * @return   boolean
     */
    public function getSiDate()
    {

        return $this->si_date;
    }

    /**
     * Get the [si_terms] column value.
     *
     * @return   boolean
     */
    public function getSiTerms()
    {

        return $this->si_terms;
    }

    /**
     * Get the [si_is_shipped] column value.
     *
     * @return   boolean
     */
    public function getSiIsShipped()
    {

        return $this->si_is_shipped;
    }

    /**
     * Get the [si_shipping] column value.
     *
     * @return   boolean
     */
    public function getSiShipping()
    {

        return $this->si_shipping;
    }

    /**
     * Get the [o_booking_url] column value.
     *
     * @return   string
     */
    public function getOBookingUrl()
    {

        return $this->o_booking_url;
    }

    /**
     * Get the [o_qty_is_int] column value.
     *
     * @return   boolean
     */
    public function getOQtyIsInt()
    {

        return $this->o_qty_is_int;
    }

    /**
     * Get the [o_use_qty_unit_price] column value.
     *
     * @return   boolean
     */
    public function getOUseQtyUnitPrice()
    {

        return $this->o_use_qty_unit_price;
    }

    /**
     * Set the value of [id] column.
     *
     * @param      int $v new value
     * @return   \HookCalendar\Model\PluginInvoiceConfig The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[PluginInvoiceConfigTableMap::ID] = true;
        }


        return $this;
    } // setId()

    /**
     * Set the value of [y_logo] column.
     *
     * @param      string $v new value
     * @return   \HookCalendar\Model\PluginInvoiceConfig The current object (for fluent API support)
     */
    public function setYLogo($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->y_logo !== $v) {
            $this->y_logo = $v;
            $this->modifiedColumns[PluginInvoiceConfigTableMap::Y_LOGO] = true;
        }


        return $this;
    } // setYLogo()

    /**
     * Set the value of [y_company] column.
     *
     * @param      string $v new value
     * @return   \HookCalendar\Model\PluginInvoiceConfig The current object (for fluent API support)
     */
    public function setYCompany($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->y_company !== $v) {
            $this->y_company = $v;
            $this->modifiedColumns[PluginInvoiceConfigTableMap::Y_COMPANY] = true;
        }


        return $this;
    } // setYCompany()

    /**
     * Set the value of [y_name] column.
     *
     * @param      string $v new value
     * @return   \HookCalendar\Model\PluginInvoiceConfig The current object (for fluent API support)
     */
    public function setYName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->y_name !== $v) {
            $this->y_name = $v;
            $this->modifiedColumns[PluginInvoiceConfigTableMap::Y_NAME] = true;
        }


        return $this;
    } // setYName()

    /**
     * Set the value of [y_street_address] column.
     *
     * @param      string $v new value
     * @return   \HookCalendar\Model\PluginInvoiceConfig The current object (for fluent API support)
     */
    public function setYStreetAddress($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->y_street_address !== $v) {
            $this->y_street_address = $v;
            $this->modifiedColumns[PluginInvoiceConfigTableMap::Y_STREET_ADDRESS] = true;
        }


        return $this;
    } // setYStreetAddress()

    /**
     * Set the value of [y_country] column.
     *
     * @param      int $v new value
     * @return   \HookCalendar\Model\PluginInvoiceConfig The current object (for fluent API support)
     */
    public function setYCountry($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->y_country !== $v) {
            $this->y_country = $v;
            $this->modifiedColumns[PluginInvoiceConfigTableMap::Y_COUNTRY] = true;
        }


        return $this;
    } // setYCountry()

    /**
     * Set the value of [y_city] column.
     *
     * @param      string $v new value
     * @return   \HookCalendar\Model\PluginInvoiceConfig The current object (for fluent API support)
     */
    public function setYCity($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->y_city !== $v) {
            $this->y_city = $v;
            $this->modifiedColumns[PluginInvoiceConfigTableMap::Y_CITY] = true;
        }


        return $this;
    } // setYCity()

    /**
     * Set the value of [y_state] column.
     *
     * @param      string $v new value
     * @return   \HookCalendar\Model\PluginInvoiceConfig The current object (for fluent API support)
     */
    public function setYState($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->y_state !== $v) {
            $this->y_state = $v;
            $this->modifiedColumns[PluginInvoiceConfigTableMap::Y_STATE] = true;
        }


        return $this;
    } // setYState()

    /**
     * Set the value of [y_zip] column.
     *
     * @param      string $v new value
     * @return   \HookCalendar\Model\PluginInvoiceConfig The current object (for fluent API support)
     */
    public function setYZip($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->y_zip !== $v) {
            $this->y_zip = $v;
            $this->modifiedColumns[PluginInvoiceConfigTableMap::Y_ZIP] = true;
        }


        return $this;
    } // setYZip()

    /**
     * Set the value of [y_phone] column.
     *
     * @param      string $v new value
     * @return   \HookCalendar\Model\PluginInvoiceConfig The current object (for fluent API support)
     */
    public function setYPhone($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->y_phone !== $v) {
            $this->y_phone = $v;
            $this->modifiedColumns[PluginInvoiceConfigTableMap::Y_PHONE] = true;
        }


        return $this;
    } // setYPhone()

    /**
     * Set the value of [y_fax] column.
     *
     * @param      string $v new value
     * @return   \HookCalendar\Model\PluginInvoiceConfig The current object (for fluent API support)
     */
    public function setYFax($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->y_fax !== $v) {
            $this->y_fax = $v;
            $this->modifiedColumns[PluginInvoiceConfigTableMap::Y_FAX] = true;
        }


        return $this;
    } // setYFax()

    /**
     * Set the value of [y_email] column.
     *
     * @param      string $v new value
     * @return   \HookCalendar\Model\PluginInvoiceConfig The current object (for fluent API support)
     */
    public function setYEmail($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->y_email !== $v) {
            $this->y_email = $v;
            $this->modifiedColumns[PluginInvoiceConfigTableMap::Y_EMAIL] = true;
        }


        return $this;
    } // setYEmail()

    /**
     * Set the value of [y_url] column.
     *
     * @param      string $v new value
     * @return   \HookCalendar\Model\PluginInvoiceConfig The current object (for fluent API support)
     */
    public function setYUrl($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->y_url !== $v) {
            $this->y_url = $v;
            $this->modifiedColumns[PluginInvoiceConfigTableMap::Y_URL] = true;
        }


        return $this;
    } // setYUrl()

    /**
     * Set the value of [y_template] column.
     *
     * @param      string $v new value
     * @return   \HookCalendar\Model\PluginInvoiceConfig The current object (for fluent API support)
     */
    public function setYTemplate($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->y_template !== $v) {
            $this->y_template = $v;
            $this->modifiedColumns[PluginInvoiceConfigTableMap::Y_TEMPLATE] = true;
        }


        return $this;
    } // setYTemplate()

    /**
     * Sets the value of the [p_accept_payments] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param      boolean|integer|string $v The new value
     * @return   \HookCalendar\Model\PluginInvoiceConfig The current object (for fluent API support)
     */
    public function setPAcceptPayments($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->p_accept_payments !== $v) {
            $this->p_accept_payments = $v;
            $this->modifiedColumns[PluginInvoiceConfigTableMap::P_ACCEPT_PAYMENTS] = true;
        }


        return $this;
    } // setPAcceptPayments()

    /**
     * Sets the value of the [p_accept_paypal] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param      boolean|integer|string $v The new value
     * @return   \HookCalendar\Model\PluginInvoiceConfig The current object (for fluent API support)
     */
    public function setPAcceptPaypal($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->p_accept_paypal !== $v) {
            $this->p_accept_paypal = $v;
            $this->modifiedColumns[PluginInvoiceConfigTableMap::P_ACCEPT_PAYPAL] = true;
        }


        return $this;
    } // setPAcceptPaypal()

    /**
     * Sets the value of the [p_accept_authorize] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param      boolean|integer|string $v The new value
     * @return   \HookCalendar\Model\PluginInvoiceConfig The current object (for fluent API support)
     */
    public function setPAcceptAuthorize($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->p_accept_authorize !== $v) {
            $this->p_accept_authorize = $v;
            $this->modifiedColumns[PluginInvoiceConfigTableMap::P_ACCEPT_AUTHORIZE] = true;
        }


        return $this;
    } // setPAcceptAuthorize()

    /**
     * Sets the value of the [p_accept_creditcard] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param      boolean|integer|string $v The new value
     * @return   \HookCalendar\Model\PluginInvoiceConfig The current object (for fluent API support)
     */
    public function setPAcceptCreditcard($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->p_accept_creditcard !== $v) {
            $this->p_accept_creditcard = $v;
            $this->modifiedColumns[PluginInvoiceConfigTableMap::P_ACCEPT_CREDITCARD] = true;
        }


        return $this;
    } // setPAcceptCreditcard()

    /**
     * Sets the value of the [p_accept_cash] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param      boolean|integer|string $v The new value
     * @return   \HookCalendar\Model\PluginInvoiceConfig The current object (for fluent API support)
     */
    public function setPAcceptCash($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->p_accept_cash !== $v) {
            $this->p_accept_cash = $v;
            $this->modifiedColumns[PluginInvoiceConfigTableMap::P_ACCEPT_CASH] = true;
        }


        return $this;
    } // setPAcceptCash()

    /**
     * Sets the value of the [p_accept_bank] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param      boolean|integer|string $v The new value
     * @return   \HookCalendar\Model\PluginInvoiceConfig The current object (for fluent API support)
     */
    public function setPAcceptBank($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->p_accept_bank !== $v) {
            $this->p_accept_bank = $v;
            $this->modifiedColumns[PluginInvoiceConfigTableMap::P_ACCEPT_BANK] = true;
        }


        return $this;
    } // setPAcceptBank()

    /**
     * Set the value of [p_paypal_address] column.
     *
     * @param      string $v new value
     * @return   \HookCalendar\Model\PluginInvoiceConfig The current object (for fluent API support)
     */
    public function setPPaypalAddress($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->p_paypal_address !== $v) {
            $this->p_paypal_address = $v;
            $this->modifiedColumns[PluginInvoiceConfigTableMap::P_PAYPAL_ADDRESS] = true;
        }


        return $this;
    } // setPPaypalAddress()

    /**
     * Set the value of [p_authorize_tz] column.
     *
     * @param      string $v new value
     * @return   \HookCalendar\Model\PluginInvoiceConfig The current object (for fluent API support)
     */
    public function setPAuthorizeTz($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->p_authorize_tz !== $v) {
            $this->p_authorize_tz = $v;
            $this->modifiedColumns[PluginInvoiceConfigTableMap::P_AUTHORIZE_TZ] = true;
        }


        return $this;
    } // setPAuthorizeTz()

    /**
     * Set the value of [p_authorize_key] column.
     *
     * @param      string $v new value
     * @return   \HookCalendar\Model\PluginInvoiceConfig The current object (for fluent API support)
     */
    public function setPAuthorizeKey($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->p_authorize_key !== $v) {
            $this->p_authorize_key = $v;
            $this->modifiedColumns[PluginInvoiceConfigTableMap::P_AUTHORIZE_KEY] = true;
        }


        return $this;
    } // setPAuthorizeKey()

    /**
     * Set the value of [p_authorize_mid] column.
     *
     * @param      string $v new value
     * @return   \HookCalendar\Model\PluginInvoiceConfig The current object (for fluent API support)
     */
    public function setPAuthorizeMid($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->p_authorize_mid !== $v) {
            $this->p_authorize_mid = $v;
            $this->modifiedColumns[PluginInvoiceConfigTableMap::P_AUTHORIZE_MID] = true;
        }


        return $this;
    } // setPAuthorizeMid()

    /**
     * Set the value of [p_authorize_hash] column.
     *
     * @param      string $v new value
     * @return   \HookCalendar\Model\PluginInvoiceConfig The current object (for fluent API support)
     */
    public function setPAuthorizeHash($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->p_authorize_hash !== $v) {
            $this->p_authorize_hash = $v;
            $this->modifiedColumns[PluginInvoiceConfigTableMap::P_AUTHORIZE_HASH] = true;
        }


        return $this;
    } // setPAuthorizeHash()

    /**
     * Set the value of [p_bank_account] column.
     *
     * @param      string $v new value
     * @return   \HookCalendar\Model\PluginInvoiceConfig The current object (for fluent API support)
     */
    public function setPBankAccount($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->p_bank_account !== $v) {
            $this->p_bank_account = $v;
            $this->modifiedColumns[PluginInvoiceConfigTableMap::P_BANK_ACCOUNT] = true;
        }


        return $this;
    } // setPBankAccount()

    /**
     * Sets the value of the [si_include] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param      boolean|integer|string $v The new value
     * @return   \HookCalendar\Model\PluginInvoiceConfig The current object (for fluent API support)
     */
    public function setSiInclude($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->si_include !== $v) {
            $this->si_include = $v;
            $this->modifiedColumns[PluginInvoiceConfigTableMap::SI_INCLUDE] = true;
        }


        return $this;
    } // setSiInclude()

    /**
     * Sets the value of the [si_shipping_address] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param      boolean|integer|string $v The new value
     * @return   \HookCalendar\Model\PluginInvoiceConfig The current object (for fluent API support)
     */
    public function setSiShippingAddress($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->si_shipping_address !== $v) {
            $this->si_shipping_address = $v;
            $this->modifiedColumns[PluginInvoiceConfigTableMap::SI_SHIPPING_ADDRESS] = true;
        }


        return $this;
    } // setSiShippingAddress()

    /**
     * Sets the value of the [si_company] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param      boolean|integer|string $v The new value
     * @return   \HookCalendar\Model\PluginInvoiceConfig The current object (for fluent API support)
     */
    public function setSiCompany($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->si_company !== $v) {
            $this->si_company = $v;
            $this->modifiedColumns[PluginInvoiceConfigTableMap::SI_COMPANY] = true;
        }


        return $this;
    } // setSiCompany()

    /**
     * Sets the value of the [si_name] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param      boolean|integer|string $v The new value
     * @return   \HookCalendar\Model\PluginInvoiceConfig The current object (for fluent API support)
     */
    public function setSiName($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->si_name !== $v) {
            $this->si_name = $v;
            $this->modifiedColumns[PluginInvoiceConfigTableMap::SI_NAME] = true;
        }


        return $this;
    } // setSiName()

    /**
     * Sets the value of the [si_address] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param      boolean|integer|string $v The new value
     * @return   \HookCalendar\Model\PluginInvoiceConfig The current object (for fluent API support)
     */
    public function setSiAddress($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->si_address !== $v) {
            $this->si_address = $v;
            $this->modifiedColumns[PluginInvoiceConfigTableMap::SI_ADDRESS] = true;
        }


        return $this;
    } // setSiAddress()

    /**
     * Sets the value of the [si_street_address] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param      boolean|integer|string $v The new value
     * @return   \HookCalendar\Model\PluginInvoiceConfig The current object (for fluent API support)
     */
    public function setSiStreetAddress($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->si_street_address !== $v) {
            $this->si_street_address = $v;
            $this->modifiedColumns[PluginInvoiceConfigTableMap::SI_STREET_ADDRESS] = true;
        }


        return $this;
    } // setSiStreetAddress()

    /**
     * Sets the value of the [si_city] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param      boolean|integer|string $v The new value
     * @return   \HookCalendar\Model\PluginInvoiceConfig The current object (for fluent API support)
     */
    public function setSiCity($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->si_city !== $v) {
            $this->si_city = $v;
            $this->modifiedColumns[PluginInvoiceConfigTableMap::SI_CITY] = true;
        }


        return $this;
    } // setSiCity()

    /**
     * Sets the value of the [si_state] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param      boolean|integer|string $v The new value
     * @return   \HookCalendar\Model\PluginInvoiceConfig The current object (for fluent API support)
     */
    public function setSiState($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->si_state !== $v) {
            $this->si_state = $v;
            $this->modifiedColumns[PluginInvoiceConfigTableMap::SI_STATE] = true;
        }


        return $this;
    } // setSiState()

    /**
     * Sets the value of the [si_zip] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param      boolean|integer|string $v The new value
     * @return   \HookCalendar\Model\PluginInvoiceConfig The current object (for fluent API support)
     */
    public function setSiZip($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->si_zip !== $v) {
            $this->si_zip = $v;
            $this->modifiedColumns[PluginInvoiceConfigTableMap::SI_ZIP] = true;
        }


        return $this;
    } // setSiZip()

    /**
     * Sets the value of the [si_phone] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param      boolean|integer|string $v The new value
     * @return   \HookCalendar\Model\PluginInvoiceConfig The current object (for fluent API support)
     */
    public function setSiPhone($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->si_phone !== $v) {
            $this->si_phone = $v;
            $this->modifiedColumns[PluginInvoiceConfigTableMap::SI_PHONE] = true;
        }


        return $this;
    } // setSiPhone()

    /**
     * Sets the value of the [si_fax] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param      boolean|integer|string $v The new value
     * @return   \HookCalendar\Model\PluginInvoiceConfig The current object (for fluent API support)
     */
    public function setSiFax($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->si_fax !== $v) {
            $this->si_fax = $v;
            $this->modifiedColumns[PluginInvoiceConfigTableMap::SI_FAX] = true;
        }


        return $this;
    } // setSiFax()

    /**
     * Sets the value of the [si_email] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param      boolean|integer|string $v The new value
     * @return   \HookCalendar\Model\PluginInvoiceConfig The current object (for fluent API support)
     */
    public function setSiEmail($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->si_email !== $v) {
            $this->si_email = $v;
            $this->modifiedColumns[PluginInvoiceConfigTableMap::SI_EMAIL] = true;
        }


        return $this;
    } // setSiEmail()

    /**
     * Sets the value of the [si_url] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param      boolean|integer|string $v The new value
     * @return   \HookCalendar\Model\PluginInvoiceConfig The current object (for fluent API support)
     */
    public function setSiUrl($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->si_url !== $v) {
            $this->si_url = $v;
            $this->modifiedColumns[PluginInvoiceConfigTableMap::SI_URL] = true;
        }


        return $this;
    } // setSiUrl()

    /**
     * Sets the value of the [si_date] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param      boolean|integer|string $v The new value
     * @return   \HookCalendar\Model\PluginInvoiceConfig The current object (for fluent API support)
     */
    public function setSiDate($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->si_date !== $v) {
            $this->si_date = $v;
            $this->modifiedColumns[PluginInvoiceConfigTableMap::SI_DATE] = true;
        }


        return $this;
    } // setSiDate()

    /**
     * Sets the value of the [si_terms] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param      boolean|integer|string $v The new value
     * @return   \HookCalendar\Model\PluginInvoiceConfig The current object (for fluent API support)
     */
    public function setSiTerms($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->si_terms !== $v) {
            $this->si_terms = $v;
            $this->modifiedColumns[PluginInvoiceConfigTableMap::SI_TERMS] = true;
        }


        return $this;
    } // setSiTerms()

    /**
     * Sets the value of the [si_is_shipped] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param      boolean|integer|string $v The new value
     * @return   \HookCalendar\Model\PluginInvoiceConfig The current object (for fluent API support)
     */
    public function setSiIsShipped($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->si_is_shipped !== $v) {
            $this->si_is_shipped = $v;
            $this->modifiedColumns[PluginInvoiceConfigTableMap::SI_IS_SHIPPED] = true;
        }


        return $this;
    } // setSiIsShipped()

    /**
     * Sets the value of the [si_shipping] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param      boolean|integer|string $v The new value
     * @return   \HookCalendar\Model\PluginInvoiceConfig The current object (for fluent API support)
     */
    public function setSiShipping($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->si_shipping !== $v) {
            $this->si_shipping = $v;
            $this->modifiedColumns[PluginInvoiceConfigTableMap::SI_SHIPPING] = true;
        }


        return $this;
    } // setSiShipping()

    /**
     * Set the value of [o_booking_url] column.
     *
     * @param      string $v new value
     * @return   \HookCalendar\Model\PluginInvoiceConfig The current object (for fluent API support)
     */
    public function setOBookingUrl($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->o_booking_url !== $v) {
            $this->o_booking_url = $v;
            $this->modifiedColumns[PluginInvoiceConfigTableMap::O_BOOKING_URL] = true;
        }


        return $this;
    } // setOBookingUrl()

    /**
     * Sets the value of the [o_qty_is_int] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param      boolean|integer|string $v The new value
     * @return   \HookCalendar\Model\PluginInvoiceConfig The current object (for fluent API support)
     */
    public function setOQtyIsInt($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->o_qty_is_int !== $v) {
            $this->o_qty_is_int = $v;
            $this->modifiedColumns[PluginInvoiceConfigTableMap::O_QTY_IS_INT] = true;
        }


        return $this;
    } // setOQtyIsInt()

    /**
     * Sets the value of the [o_use_qty_unit_price] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param      boolean|integer|string $v The new value
     * @return   \HookCalendar\Model\PluginInvoiceConfig The current object (for fluent API support)
     */
    public function setOUseQtyUnitPrice($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->o_use_qty_unit_price !== $v) {
            $this->o_use_qty_unit_price = $v;
            $this->modifiedColumns[PluginInvoiceConfigTableMap::O_USE_QTY_UNIT_PRICE] = true;
        }


        return $this;
    } // setOUseQtyUnitPrice()

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
            if ($this->p_accept_payments !== false) {
                return false;
            }

            if ($this->p_accept_paypal !== false) {
                return false;
            }

            if ($this->p_accept_authorize !== false) {
                return false;
            }

            if ($this->p_accept_creditcard !== false) {
                return false;
            }

            if ($this->p_accept_cash !== false) {
                return false;
            }

            if ($this->p_accept_bank !== false) {
                return false;
            }

            if ($this->si_include !== false) {
                return false;
            }

            if ($this->si_shipping_address !== false) {
                return false;
            }

            if ($this->si_company !== false) {
                return false;
            }

            if ($this->si_name !== false) {
                return false;
            }

            if ($this->si_address !== false) {
                return false;
            }

            if ($this->si_street_address !== false) {
                return false;
            }

            if ($this->si_city !== false) {
                return false;
            }

            if ($this->si_state !== false) {
                return false;
            }

            if ($this->si_zip !== false) {
                return false;
            }

            if ($this->si_phone !== false) {
                return false;
            }

            if ($this->si_fax !== false) {
                return false;
            }

            if ($this->si_email !== false) {
                return false;
            }

            if ($this->si_url !== false) {
                return false;
            }

            if ($this->si_date !== false) {
                return false;
            }

            if ($this->si_terms !== false) {
                return false;
            }

            if ($this->si_is_shipped !== false) {
                return false;
            }

            if ($this->si_shipping !== false) {
                return false;
            }

            if ($this->o_qty_is_int !== false) {
                return false;
            }

            if ($this->o_use_qty_unit_price !== true) {
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


            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : PluginInvoiceConfigTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : PluginInvoiceConfigTableMap::translateFieldName('YLogo', TableMap::TYPE_PHPNAME, $indexType)];
            $this->y_logo = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : PluginInvoiceConfigTableMap::translateFieldName('YCompany', TableMap::TYPE_PHPNAME, $indexType)];
            $this->y_company = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : PluginInvoiceConfigTableMap::translateFieldName('YName', TableMap::TYPE_PHPNAME, $indexType)];
            $this->y_name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : PluginInvoiceConfigTableMap::translateFieldName('YStreetAddress', TableMap::TYPE_PHPNAME, $indexType)];
            $this->y_street_address = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : PluginInvoiceConfigTableMap::translateFieldName('YCountry', TableMap::TYPE_PHPNAME, $indexType)];
            $this->y_country = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : PluginInvoiceConfigTableMap::translateFieldName('YCity', TableMap::TYPE_PHPNAME, $indexType)];
            $this->y_city = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : PluginInvoiceConfigTableMap::translateFieldName('YState', TableMap::TYPE_PHPNAME, $indexType)];
            $this->y_state = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : PluginInvoiceConfigTableMap::translateFieldName('YZip', TableMap::TYPE_PHPNAME, $indexType)];
            $this->y_zip = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : PluginInvoiceConfigTableMap::translateFieldName('YPhone', TableMap::TYPE_PHPNAME, $indexType)];
            $this->y_phone = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 10 + $startcol : PluginInvoiceConfigTableMap::translateFieldName('YFax', TableMap::TYPE_PHPNAME, $indexType)];
            $this->y_fax = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 11 + $startcol : PluginInvoiceConfigTableMap::translateFieldName('YEmail', TableMap::TYPE_PHPNAME, $indexType)];
            $this->y_email = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 12 + $startcol : PluginInvoiceConfigTableMap::translateFieldName('YUrl', TableMap::TYPE_PHPNAME, $indexType)];
            $this->y_url = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 13 + $startcol : PluginInvoiceConfigTableMap::translateFieldName('YTemplate', TableMap::TYPE_PHPNAME, $indexType)];
            $this->y_template = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 14 + $startcol : PluginInvoiceConfigTableMap::translateFieldName('PAcceptPayments', TableMap::TYPE_PHPNAME, $indexType)];
            $this->p_accept_payments = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 15 + $startcol : PluginInvoiceConfigTableMap::translateFieldName('PAcceptPaypal', TableMap::TYPE_PHPNAME, $indexType)];
            $this->p_accept_paypal = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 16 + $startcol : PluginInvoiceConfigTableMap::translateFieldName('PAcceptAuthorize', TableMap::TYPE_PHPNAME, $indexType)];
            $this->p_accept_authorize = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 17 + $startcol : PluginInvoiceConfigTableMap::translateFieldName('PAcceptCreditcard', TableMap::TYPE_PHPNAME, $indexType)];
            $this->p_accept_creditcard = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 18 + $startcol : PluginInvoiceConfigTableMap::translateFieldName('PAcceptCash', TableMap::TYPE_PHPNAME, $indexType)];
            $this->p_accept_cash = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 19 + $startcol : PluginInvoiceConfigTableMap::translateFieldName('PAcceptBank', TableMap::TYPE_PHPNAME, $indexType)];
            $this->p_accept_bank = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 20 + $startcol : PluginInvoiceConfigTableMap::translateFieldName('PPaypalAddress', TableMap::TYPE_PHPNAME, $indexType)];
            $this->p_paypal_address = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 21 + $startcol : PluginInvoiceConfigTableMap::translateFieldName('PAuthorizeTz', TableMap::TYPE_PHPNAME, $indexType)];
            $this->p_authorize_tz = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 22 + $startcol : PluginInvoiceConfigTableMap::translateFieldName('PAuthorizeKey', TableMap::TYPE_PHPNAME, $indexType)];
            $this->p_authorize_key = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 23 + $startcol : PluginInvoiceConfigTableMap::translateFieldName('PAuthorizeMid', TableMap::TYPE_PHPNAME, $indexType)];
            $this->p_authorize_mid = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 24 + $startcol : PluginInvoiceConfigTableMap::translateFieldName('PAuthorizeHash', TableMap::TYPE_PHPNAME, $indexType)];
            $this->p_authorize_hash = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 25 + $startcol : PluginInvoiceConfigTableMap::translateFieldName('PBankAccount', TableMap::TYPE_PHPNAME, $indexType)];
            $this->p_bank_account = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 26 + $startcol : PluginInvoiceConfigTableMap::translateFieldName('SiInclude', TableMap::TYPE_PHPNAME, $indexType)];
            $this->si_include = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 27 + $startcol : PluginInvoiceConfigTableMap::translateFieldName('SiShippingAddress', TableMap::TYPE_PHPNAME, $indexType)];
            $this->si_shipping_address = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 28 + $startcol : PluginInvoiceConfigTableMap::translateFieldName('SiCompany', TableMap::TYPE_PHPNAME, $indexType)];
            $this->si_company = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 29 + $startcol : PluginInvoiceConfigTableMap::translateFieldName('SiName', TableMap::TYPE_PHPNAME, $indexType)];
            $this->si_name = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 30 + $startcol : PluginInvoiceConfigTableMap::translateFieldName('SiAddress', TableMap::TYPE_PHPNAME, $indexType)];
            $this->si_address = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 31 + $startcol : PluginInvoiceConfigTableMap::translateFieldName('SiStreetAddress', TableMap::TYPE_PHPNAME, $indexType)];
            $this->si_street_address = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 32 + $startcol : PluginInvoiceConfigTableMap::translateFieldName('SiCity', TableMap::TYPE_PHPNAME, $indexType)];
            $this->si_city = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 33 + $startcol : PluginInvoiceConfigTableMap::translateFieldName('SiState', TableMap::TYPE_PHPNAME, $indexType)];
            $this->si_state = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 34 + $startcol : PluginInvoiceConfigTableMap::translateFieldName('SiZip', TableMap::TYPE_PHPNAME, $indexType)];
            $this->si_zip = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 35 + $startcol : PluginInvoiceConfigTableMap::translateFieldName('SiPhone', TableMap::TYPE_PHPNAME, $indexType)];
            $this->si_phone = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 36 + $startcol : PluginInvoiceConfigTableMap::translateFieldName('SiFax', TableMap::TYPE_PHPNAME, $indexType)];
            $this->si_fax = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 37 + $startcol : PluginInvoiceConfigTableMap::translateFieldName('SiEmail', TableMap::TYPE_PHPNAME, $indexType)];
            $this->si_email = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 38 + $startcol : PluginInvoiceConfigTableMap::translateFieldName('SiUrl', TableMap::TYPE_PHPNAME, $indexType)];
            $this->si_url = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 39 + $startcol : PluginInvoiceConfigTableMap::translateFieldName('SiDate', TableMap::TYPE_PHPNAME, $indexType)];
            $this->si_date = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 40 + $startcol : PluginInvoiceConfigTableMap::translateFieldName('SiTerms', TableMap::TYPE_PHPNAME, $indexType)];
            $this->si_terms = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 41 + $startcol : PluginInvoiceConfigTableMap::translateFieldName('SiIsShipped', TableMap::TYPE_PHPNAME, $indexType)];
            $this->si_is_shipped = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 42 + $startcol : PluginInvoiceConfigTableMap::translateFieldName('SiShipping', TableMap::TYPE_PHPNAME, $indexType)];
            $this->si_shipping = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 43 + $startcol : PluginInvoiceConfigTableMap::translateFieldName('OBookingUrl', TableMap::TYPE_PHPNAME, $indexType)];
            $this->o_booking_url = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 44 + $startcol : PluginInvoiceConfigTableMap::translateFieldName('OQtyIsInt', TableMap::TYPE_PHPNAME, $indexType)];
            $this->o_qty_is_int = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 45 + $startcol : PluginInvoiceConfigTableMap::translateFieldName('OUseQtyUnitPrice', TableMap::TYPE_PHPNAME, $indexType)];
            $this->o_use_qty_unit_price = (null !== $col) ? (boolean) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 46; // 46 = PluginInvoiceConfigTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating \HookCalendar\Model\PluginInvoiceConfig object", 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(PluginInvoiceConfigTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildPluginInvoiceConfigQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
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
     * @see PluginInvoiceConfig::setDeleted()
     * @see PluginInvoiceConfig::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(PluginInvoiceConfigTableMap::DATABASE_NAME);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = ChildPluginInvoiceConfigQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(PluginInvoiceConfigTableMap::DATABASE_NAME);
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
                PluginInvoiceConfigTableMap::addInstanceToPool($this);
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

        $this->modifiedColumns[PluginInvoiceConfigTableMap::ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . PluginInvoiceConfigTableMap::ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(PluginInvoiceConfigTableMap::ID)) {
            $modifiedColumns[':p' . $index++]  = 'ID';
        }
        if ($this->isColumnModified(PluginInvoiceConfigTableMap::Y_LOGO)) {
            $modifiedColumns[':p' . $index++]  = 'Y_LOGO';
        }
        if ($this->isColumnModified(PluginInvoiceConfigTableMap::Y_COMPANY)) {
            $modifiedColumns[':p' . $index++]  = 'Y_COMPANY';
        }
        if ($this->isColumnModified(PluginInvoiceConfigTableMap::Y_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'Y_NAME';
        }
        if ($this->isColumnModified(PluginInvoiceConfigTableMap::Y_STREET_ADDRESS)) {
            $modifiedColumns[':p' . $index++]  = 'Y_STREET_ADDRESS';
        }
        if ($this->isColumnModified(PluginInvoiceConfigTableMap::Y_COUNTRY)) {
            $modifiedColumns[':p' . $index++]  = 'Y_COUNTRY';
        }
        if ($this->isColumnModified(PluginInvoiceConfigTableMap::Y_CITY)) {
            $modifiedColumns[':p' . $index++]  = 'Y_CITY';
        }
        if ($this->isColumnModified(PluginInvoiceConfigTableMap::Y_STATE)) {
            $modifiedColumns[':p' . $index++]  = 'Y_STATE';
        }
        if ($this->isColumnModified(PluginInvoiceConfigTableMap::Y_ZIP)) {
            $modifiedColumns[':p' . $index++]  = 'Y_ZIP';
        }
        if ($this->isColumnModified(PluginInvoiceConfigTableMap::Y_PHONE)) {
            $modifiedColumns[':p' . $index++]  = 'Y_PHONE';
        }
        if ($this->isColumnModified(PluginInvoiceConfigTableMap::Y_FAX)) {
            $modifiedColumns[':p' . $index++]  = 'Y_FAX';
        }
        if ($this->isColumnModified(PluginInvoiceConfigTableMap::Y_EMAIL)) {
            $modifiedColumns[':p' . $index++]  = 'Y_EMAIL';
        }
        if ($this->isColumnModified(PluginInvoiceConfigTableMap::Y_URL)) {
            $modifiedColumns[':p' . $index++]  = 'Y_URL';
        }
        if ($this->isColumnModified(PluginInvoiceConfigTableMap::Y_TEMPLATE)) {
            $modifiedColumns[':p' . $index++]  = 'Y_TEMPLATE';
        }
        if ($this->isColumnModified(PluginInvoiceConfigTableMap::P_ACCEPT_PAYMENTS)) {
            $modifiedColumns[':p' . $index++]  = 'P_ACCEPT_PAYMENTS';
        }
        if ($this->isColumnModified(PluginInvoiceConfigTableMap::P_ACCEPT_PAYPAL)) {
            $modifiedColumns[':p' . $index++]  = 'P_ACCEPT_PAYPAL';
        }
        if ($this->isColumnModified(PluginInvoiceConfigTableMap::P_ACCEPT_AUTHORIZE)) {
            $modifiedColumns[':p' . $index++]  = 'P_ACCEPT_AUTHORIZE';
        }
        if ($this->isColumnModified(PluginInvoiceConfigTableMap::P_ACCEPT_CREDITCARD)) {
            $modifiedColumns[':p' . $index++]  = 'P_ACCEPT_CREDITCARD';
        }
        if ($this->isColumnModified(PluginInvoiceConfigTableMap::P_ACCEPT_CASH)) {
            $modifiedColumns[':p' . $index++]  = 'P_ACCEPT_CASH';
        }
        if ($this->isColumnModified(PluginInvoiceConfigTableMap::P_ACCEPT_BANK)) {
            $modifiedColumns[':p' . $index++]  = 'P_ACCEPT_BANK';
        }
        if ($this->isColumnModified(PluginInvoiceConfigTableMap::P_PAYPAL_ADDRESS)) {
            $modifiedColumns[':p' . $index++]  = 'P_PAYPAL_ADDRESS';
        }
        if ($this->isColumnModified(PluginInvoiceConfigTableMap::P_AUTHORIZE_TZ)) {
            $modifiedColumns[':p' . $index++]  = 'P_AUTHORIZE_TZ';
        }
        if ($this->isColumnModified(PluginInvoiceConfigTableMap::P_AUTHORIZE_KEY)) {
            $modifiedColumns[':p' . $index++]  = 'P_AUTHORIZE_KEY';
        }
        if ($this->isColumnModified(PluginInvoiceConfigTableMap::P_AUTHORIZE_MID)) {
            $modifiedColumns[':p' . $index++]  = 'P_AUTHORIZE_MID';
        }
        if ($this->isColumnModified(PluginInvoiceConfigTableMap::P_AUTHORIZE_HASH)) {
            $modifiedColumns[':p' . $index++]  = 'P_AUTHORIZE_HASH';
        }
        if ($this->isColumnModified(PluginInvoiceConfigTableMap::P_BANK_ACCOUNT)) {
            $modifiedColumns[':p' . $index++]  = 'P_BANK_ACCOUNT';
        }
        if ($this->isColumnModified(PluginInvoiceConfigTableMap::SI_INCLUDE)) {
            $modifiedColumns[':p' . $index++]  = 'SI_INCLUDE';
        }
        if ($this->isColumnModified(PluginInvoiceConfigTableMap::SI_SHIPPING_ADDRESS)) {
            $modifiedColumns[':p' . $index++]  = 'SI_SHIPPING_ADDRESS';
        }
        if ($this->isColumnModified(PluginInvoiceConfigTableMap::SI_COMPANY)) {
            $modifiedColumns[':p' . $index++]  = 'SI_COMPANY';
        }
        if ($this->isColumnModified(PluginInvoiceConfigTableMap::SI_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'SI_NAME';
        }
        if ($this->isColumnModified(PluginInvoiceConfigTableMap::SI_ADDRESS)) {
            $modifiedColumns[':p' . $index++]  = 'SI_ADDRESS';
        }
        if ($this->isColumnModified(PluginInvoiceConfigTableMap::SI_STREET_ADDRESS)) {
            $modifiedColumns[':p' . $index++]  = 'SI_STREET_ADDRESS';
        }
        if ($this->isColumnModified(PluginInvoiceConfigTableMap::SI_CITY)) {
            $modifiedColumns[':p' . $index++]  = 'SI_CITY';
        }
        if ($this->isColumnModified(PluginInvoiceConfigTableMap::SI_STATE)) {
            $modifiedColumns[':p' . $index++]  = 'SI_STATE';
        }
        if ($this->isColumnModified(PluginInvoiceConfigTableMap::SI_ZIP)) {
            $modifiedColumns[':p' . $index++]  = 'SI_ZIP';
        }
        if ($this->isColumnModified(PluginInvoiceConfigTableMap::SI_PHONE)) {
            $modifiedColumns[':p' . $index++]  = 'SI_PHONE';
        }
        if ($this->isColumnModified(PluginInvoiceConfigTableMap::SI_FAX)) {
            $modifiedColumns[':p' . $index++]  = 'SI_FAX';
        }
        if ($this->isColumnModified(PluginInvoiceConfigTableMap::SI_EMAIL)) {
            $modifiedColumns[':p' . $index++]  = 'SI_EMAIL';
        }
        if ($this->isColumnModified(PluginInvoiceConfigTableMap::SI_URL)) {
            $modifiedColumns[':p' . $index++]  = 'SI_URL';
        }
        if ($this->isColumnModified(PluginInvoiceConfigTableMap::SI_DATE)) {
            $modifiedColumns[':p' . $index++]  = 'SI_DATE';
        }
        if ($this->isColumnModified(PluginInvoiceConfigTableMap::SI_TERMS)) {
            $modifiedColumns[':p' . $index++]  = 'SI_TERMS';
        }
        if ($this->isColumnModified(PluginInvoiceConfigTableMap::SI_IS_SHIPPED)) {
            $modifiedColumns[':p' . $index++]  = 'SI_IS_SHIPPED';
        }
        if ($this->isColumnModified(PluginInvoiceConfigTableMap::SI_SHIPPING)) {
            $modifiedColumns[':p' . $index++]  = 'SI_SHIPPING';
        }
        if ($this->isColumnModified(PluginInvoiceConfigTableMap::O_BOOKING_URL)) {
            $modifiedColumns[':p' . $index++]  = 'O_BOOKING_URL';
        }
        if ($this->isColumnModified(PluginInvoiceConfigTableMap::O_QTY_IS_INT)) {
            $modifiedColumns[':p' . $index++]  = 'O_QTY_IS_INT';
        }
        if ($this->isColumnModified(PluginInvoiceConfigTableMap::O_USE_QTY_UNIT_PRICE)) {
            $modifiedColumns[':p' . $index++]  = 'O_USE_QTY_UNIT_PRICE';
        }

        $sql = sprintf(
            'INSERT INTO plugin_invoice_config (%s) VALUES (%s)',
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
                    case 'Y_TEMPLATE':
                        $stmt->bindValue($identifier, $this->y_template, PDO::PARAM_STR);
                        break;
                    case 'P_ACCEPT_PAYMENTS':
                        $stmt->bindValue($identifier, (int) $this->p_accept_payments, PDO::PARAM_INT);
                        break;
                    case 'P_ACCEPT_PAYPAL':
                        $stmt->bindValue($identifier, (int) $this->p_accept_paypal, PDO::PARAM_INT);
                        break;
                    case 'P_ACCEPT_AUTHORIZE':
                        $stmt->bindValue($identifier, (int) $this->p_accept_authorize, PDO::PARAM_INT);
                        break;
                    case 'P_ACCEPT_CREDITCARD':
                        $stmt->bindValue($identifier, (int) $this->p_accept_creditcard, PDO::PARAM_INT);
                        break;
                    case 'P_ACCEPT_CASH':
                        $stmt->bindValue($identifier, (int) $this->p_accept_cash, PDO::PARAM_INT);
                        break;
                    case 'P_ACCEPT_BANK':
                        $stmt->bindValue($identifier, (int) $this->p_accept_bank, PDO::PARAM_INT);
                        break;
                    case 'P_PAYPAL_ADDRESS':
                        $stmt->bindValue($identifier, $this->p_paypal_address, PDO::PARAM_STR);
                        break;
                    case 'P_AUTHORIZE_TZ':
                        $stmt->bindValue($identifier, $this->p_authorize_tz, PDO::PARAM_STR);
                        break;
                    case 'P_AUTHORIZE_KEY':
                        $stmt->bindValue($identifier, $this->p_authorize_key, PDO::PARAM_STR);
                        break;
                    case 'P_AUTHORIZE_MID':
                        $stmt->bindValue($identifier, $this->p_authorize_mid, PDO::PARAM_STR);
                        break;
                    case 'P_AUTHORIZE_HASH':
                        $stmt->bindValue($identifier, $this->p_authorize_hash, PDO::PARAM_STR);
                        break;
                    case 'P_BANK_ACCOUNT':
                        $stmt->bindValue($identifier, $this->p_bank_account, PDO::PARAM_STR);
                        break;
                    case 'SI_INCLUDE':
                        $stmt->bindValue($identifier, (int) $this->si_include, PDO::PARAM_INT);
                        break;
                    case 'SI_SHIPPING_ADDRESS':
                        $stmt->bindValue($identifier, (int) $this->si_shipping_address, PDO::PARAM_INT);
                        break;
                    case 'SI_COMPANY':
                        $stmt->bindValue($identifier, (int) $this->si_company, PDO::PARAM_INT);
                        break;
                    case 'SI_NAME':
                        $stmt->bindValue($identifier, (int) $this->si_name, PDO::PARAM_INT);
                        break;
                    case 'SI_ADDRESS':
                        $stmt->bindValue($identifier, (int) $this->si_address, PDO::PARAM_INT);
                        break;
                    case 'SI_STREET_ADDRESS':
                        $stmt->bindValue($identifier, (int) $this->si_street_address, PDO::PARAM_INT);
                        break;
                    case 'SI_CITY':
                        $stmt->bindValue($identifier, (int) $this->si_city, PDO::PARAM_INT);
                        break;
                    case 'SI_STATE':
                        $stmt->bindValue($identifier, (int) $this->si_state, PDO::PARAM_INT);
                        break;
                    case 'SI_ZIP':
                        $stmt->bindValue($identifier, (int) $this->si_zip, PDO::PARAM_INT);
                        break;
                    case 'SI_PHONE':
                        $stmt->bindValue($identifier, (int) $this->si_phone, PDO::PARAM_INT);
                        break;
                    case 'SI_FAX':
                        $stmt->bindValue($identifier, (int) $this->si_fax, PDO::PARAM_INT);
                        break;
                    case 'SI_EMAIL':
                        $stmt->bindValue($identifier, (int) $this->si_email, PDO::PARAM_INT);
                        break;
                    case 'SI_URL':
                        $stmt->bindValue($identifier, (int) $this->si_url, PDO::PARAM_INT);
                        break;
                    case 'SI_DATE':
                        $stmt->bindValue($identifier, (int) $this->si_date, PDO::PARAM_INT);
                        break;
                    case 'SI_TERMS':
                        $stmt->bindValue($identifier, (int) $this->si_terms, PDO::PARAM_INT);
                        break;
                    case 'SI_IS_SHIPPED':
                        $stmt->bindValue($identifier, (int) $this->si_is_shipped, PDO::PARAM_INT);
                        break;
                    case 'SI_SHIPPING':
                        $stmt->bindValue($identifier, (int) $this->si_shipping, PDO::PARAM_INT);
                        break;
                    case 'O_BOOKING_URL':
                        $stmt->bindValue($identifier, $this->o_booking_url, PDO::PARAM_STR);
                        break;
                    case 'O_QTY_IS_INT':
                        $stmt->bindValue($identifier, (int) $this->o_qty_is_int, PDO::PARAM_INT);
                        break;
                    case 'O_USE_QTY_UNIT_PRICE':
                        $stmt->bindValue($identifier, (int) $this->o_use_qty_unit_price, PDO::PARAM_INT);
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
        $pos = PluginInvoiceConfigTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getYLogo();
                break;
            case 2:
                return $this->getYCompany();
                break;
            case 3:
                return $this->getYName();
                break;
            case 4:
                return $this->getYStreetAddress();
                break;
            case 5:
                return $this->getYCountry();
                break;
            case 6:
                return $this->getYCity();
                break;
            case 7:
                return $this->getYState();
                break;
            case 8:
                return $this->getYZip();
                break;
            case 9:
                return $this->getYPhone();
                break;
            case 10:
                return $this->getYFax();
                break;
            case 11:
                return $this->getYEmail();
                break;
            case 12:
                return $this->getYUrl();
                break;
            case 13:
                return $this->getYTemplate();
                break;
            case 14:
                return $this->getPAcceptPayments();
                break;
            case 15:
                return $this->getPAcceptPaypal();
                break;
            case 16:
                return $this->getPAcceptAuthorize();
                break;
            case 17:
                return $this->getPAcceptCreditcard();
                break;
            case 18:
                return $this->getPAcceptCash();
                break;
            case 19:
                return $this->getPAcceptBank();
                break;
            case 20:
                return $this->getPPaypalAddress();
                break;
            case 21:
                return $this->getPAuthorizeTz();
                break;
            case 22:
                return $this->getPAuthorizeKey();
                break;
            case 23:
                return $this->getPAuthorizeMid();
                break;
            case 24:
                return $this->getPAuthorizeHash();
                break;
            case 25:
                return $this->getPBankAccount();
                break;
            case 26:
                return $this->getSiInclude();
                break;
            case 27:
                return $this->getSiShippingAddress();
                break;
            case 28:
                return $this->getSiCompany();
                break;
            case 29:
                return $this->getSiName();
                break;
            case 30:
                return $this->getSiAddress();
                break;
            case 31:
                return $this->getSiStreetAddress();
                break;
            case 32:
                return $this->getSiCity();
                break;
            case 33:
                return $this->getSiState();
                break;
            case 34:
                return $this->getSiZip();
                break;
            case 35:
                return $this->getSiPhone();
                break;
            case 36:
                return $this->getSiFax();
                break;
            case 37:
                return $this->getSiEmail();
                break;
            case 38:
                return $this->getSiUrl();
                break;
            case 39:
                return $this->getSiDate();
                break;
            case 40:
                return $this->getSiTerms();
                break;
            case 41:
                return $this->getSiIsShipped();
                break;
            case 42:
                return $this->getSiShipping();
                break;
            case 43:
                return $this->getOBookingUrl();
                break;
            case 44:
                return $this->getOQtyIsInt();
                break;
            case 45:
                return $this->getOUseQtyUnitPrice();
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
        if (isset($alreadyDumpedObjects['PluginInvoiceConfig'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['PluginInvoiceConfig'][$this->getPrimaryKey()] = true;
        $keys = PluginInvoiceConfigTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getYLogo(),
            $keys[2] => $this->getYCompany(),
            $keys[3] => $this->getYName(),
            $keys[4] => $this->getYStreetAddress(),
            $keys[5] => $this->getYCountry(),
            $keys[6] => $this->getYCity(),
            $keys[7] => $this->getYState(),
            $keys[8] => $this->getYZip(),
            $keys[9] => $this->getYPhone(),
            $keys[10] => $this->getYFax(),
            $keys[11] => $this->getYEmail(),
            $keys[12] => $this->getYUrl(),
            $keys[13] => $this->getYTemplate(),
            $keys[14] => $this->getPAcceptPayments(),
            $keys[15] => $this->getPAcceptPaypal(),
            $keys[16] => $this->getPAcceptAuthorize(),
            $keys[17] => $this->getPAcceptCreditcard(),
            $keys[18] => $this->getPAcceptCash(),
            $keys[19] => $this->getPAcceptBank(),
            $keys[20] => $this->getPPaypalAddress(),
            $keys[21] => $this->getPAuthorizeTz(),
            $keys[22] => $this->getPAuthorizeKey(),
            $keys[23] => $this->getPAuthorizeMid(),
            $keys[24] => $this->getPAuthorizeHash(),
            $keys[25] => $this->getPBankAccount(),
            $keys[26] => $this->getSiInclude(),
            $keys[27] => $this->getSiShippingAddress(),
            $keys[28] => $this->getSiCompany(),
            $keys[29] => $this->getSiName(),
            $keys[30] => $this->getSiAddress(),
            $keys[31] => $this->getSiStreetAddress(),
            $keys[32] => $this->getSiCity(),
            $keys[33] => $this->getSiState(),
            $keys[34] => $this->getSiZip(),
            $keys[35] => $this->getSiPhone(),
            $keys[36] => $this->getSiFax(),
            $keys[37] => $this->getSiEmail(),
            $keys[38] => $this->getSiUrl(),
            $keys[39] => $this->getSiDate(),
            $keys[40] => $this->getSiTerms(),
            $keys[41] => $this->getSiIsShipped(),
            $keys[42] => $this->getSiShipping(),
            $keys[43] => $this->getOBookingUrl(),
            $keys[44] => $this->getOQtyIsInt(),
            $keys[45] => $this->getOUseQtyUnitPrice(),
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
        $pos = PluginInvoiceConfigTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

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
                $this->setYLogo($value);
                break;
            case 2:
                $this->setYCompany($value);
                break;
            case 3:
                $this->setYName($value);
                break;
            case 4:
                $this->setYStreetAddress($value);
                break;
            case 5:
                $this->setYCountry($value);
                break;
            case 6:
                $this->setYCity($value);
                break;
            case 7:
                $this->setYState($value);
                break;
            case 8:
                $this->setYZip($value);
                break;
            case 9:
                $this->setYPhone($value);
                break;
            case 10:
                $this->setYFax($value);
                break;
            case 11:
                $this->setYEmail($value);
                break;
            case 12:
                $this->setYUrl($value);
                break;
            case 13:
                $this->setYTemplate($value);
                break;
            case 14:
                $this->setPAcceptPayments($value);
                break;
            case 15:
                $this->setPAcceptPaypal($value);
                break;
            case 16:
                $this->setPAcceptAuthorize($value);
                break;
            case 17:
                $this->setPAcceptCreditcard($value);
                break;
            case 18:
                $this->setPAcceptCash($value);
                break;
            case 19:
                $this->setPAcceptBank($value);
                break;
            case 20:
                $this->setPPaypalAddress($value);
                break;
            case 21:
                $this->setPAuthorizeTz($value);
                break;
            case 22:
                $this->setPAuthorizeKey($value);
                break;
            case 23:
                $this->setPAuthorizeMid($value);
                break;
            case 24:
                $this->setPAuthorizeHash($value);
                break;
            case 25:
                $this->setPBankAccount($value);
                break;
            case 26:
                $this->setSiInclude($value);
                break;
            case 27:
                $this->setSiShippingAddress($value);
                break;
            case 28:
                $this->setSiCompany($value);
                break;
            case 29:
                $this->setSiName($value);
                break;
            case 30:
                $this->setSiAddress($value);
                break;
            case 31:
                $this->setSiStreetAddress($value);
                break;
            case 32:
                $this->setSiCity($value);
                break;
            case 33:
                $this->setSiState($value);
                break;
            case 34:
                $this->setSiZip($value);
                break;
            case 35:
                $this->setSiPhone($value);
                break;
            case 36:
                $this->setSiFax($value);
                break;
            case 37:
                $this->setSiEmail($value);
                break;
            case 38:
                $this->setSiUrl($value);
                break;
            case 39:
                $this->setSiDate($value);
                break;
            case 40:
                $this->setSiTerms($value);
                break;
            case 41:
                $this->setSiIsShipped($value);
                break;
            case 42:
                $this->setSiShipping($value);
                break;
            case 43:
                $this->setOBookingUrl($value);
                break;
            case 44:
                $this->setOQtyIsInt($value);
                break;
            case 45:
                $this->setOUseQtyUnitPrice($value);
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
        $keys = PluginInvoiceConfigTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setYLogo($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setYCompany($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setYName($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setYStreetAddress($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setYCountry($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setYCity($arr[$keys[6]]);
        if (array_key_exists($keys[7], $arr)) $this->setYState($arr[$keys[7]]);
        if (array_key_exists($keys[8], $arr)) $this->setYZip($arr[$keys[8]]);
        if (array_key_exists($keys[9], $arr)) $this->setYPhone($arr[$keys[9]]);
        if (array_key_exists($keys[10], $arr)) $this->setYFax($arr[$keys[10]]);
        if (array_key_exists($keys[11], $arr)) $this->setYEmail($arr[$keys[11]]);
        if (array_key_exists($keys[12], $arr)) $this->setYUrl($arr[$keys[12]]);
        if (array_key_exists($keys[13], $arr)) $this->setYTemplate($arr[$keys[13]]);
        if (array_key_exists($keys[14], $arr)) $this->setPAcceptPayments($arr[$keys[14]]);
        if (array_key_exists($keys[15], $arr)) $this->setPAcceptPaypal($arr[$keys[15]]);
        if (array_key_exists($keys[16], $arr)) $this->setPAcceptAuthorize($arr[$keys[16]]);
        if (array_key_exists($keys[17], $arr)) $this->setPAcceptCreditcard($arr[$keys[17]]);
        if (array_key_exists($keys[18], $arr)) $this->setPAcceptCash($arr[$keys[18]]);
        if (array_key_exists($keys[19], $arr)) $this->setPAcceptBank($arr[$keys[19]]);
        if (array_key_exists($keys[20], $arr)) $this->setPPaypalAddress($arr[$keys[20]]);
        if (array_key_exists($keys[21], $arr)) $this->setPAuthorizeTz($arr[$keys[21]]);
        if (array_key_exists($keys[22], $arr)) $this->setPAuthorizeKey($arr[$keys[22]]);
        if (array_key_exists($keys[23], $arr)) $this->setPAuthorizeMid($arr[$keys[23]]);
        if (array_key_exists($keys[24], $arr)) $this->setPAuthorizeHash($arr[$keys[24]]);
        if (array_key_exists($keys[25], $arr)) $this->setPBankAccount($arr[$keys[25]]);
        if (array_key_exists($keys[26], $arr)) $this->setSiInclude($arr[$keys[26]]);
        if (array_key_exists($keys[27], $arr)) $this->setSiShippingAddress($arr[$keys[27]]);
        if (array_key_exists($keys[28], $arr)) $this->setSiCompany($arr[$keys[28]]);
        if (array_key_exists($keys[29], $arr)) $this->setSiName($arr[$keys[29]]);
        if (array_key_exists($keys[30], $arr)) $this->setSiAddress($arr[$keys[30]]);
        if (array_key_exists($keys[31], $arr)) $this->setSiStreetAddress($arr[$keys[31]]);
        if (array_key_exists($keys[32], $arr)) $this->setSiCity($arr[$keys[32]]);
        if (array_key_exists($keys[33], $arr)) $this->setSiState($arr[$keys[33]]);
        if (array_key_exists($keys[34], $arr)) $this->setSiZip($arr[$keys[34]]);
        if (array_key_exists($keys[35], $arr)) $this->setSiPhone($arr[$keys[35]]);
        if (array_key_exists($keys[36], $arr)) $this->setSiFax($arr[$keys[36]]);
        if (array_key_exists($keys[37], $arr)) $this->setSiEmail($arr[$keys[37]]);
        if (array_key_exists($keys[38], $arr)) $this->setSiUrl($arr[$keys[38]]);
        if (array_key_exists($keys[39], $arr)) $this->setSiDate($arr[$keys[39]]);
        if (array_key_exists($keys[40], $arr)) $this->setSiTerms($arr[$keys[40]]);
        if (array_key_exists($keys[41], $arr)) $this->setSiIsShipped($arr[$keys[41]]);
        if (array_key_exists($keys[42], $arr)) $this->setSiShipping($arr[$keys[42]]);
        if (array_key_exists($keys[43], $arr)) $this->setOBookingUrl($arr[$keys[43]]);
        if (array_key_exists($keys[44], $arr)) $this->setOQtyIsInt($arr[$keys[44]]);
        if (array_key_exists($keys[45], $arr)) $this->setOUseQtyUnitPrice($arr[$keys[45]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(PluginInvoiceConfigTableMap::DATABASE_NAME);

        if ($this->isColumnModified(PluginInvoiceConfigTableMap::ID)) $criteria->add(PluginInvoiceConfigTableMap::ID, $this->id);
        if ($this->isColumnModified(PluginInvoiceConfigTableMap::Y_LOGO)) $criteria->add(PluginInvoiceConfigTableMap::Y_LOGO, $this->y_logo);
        if ($this->isColumnModified(PluginInvoiceConfigTableMap::Y_COMPANY)) $criteria->add(PluginInvoiceConfigTableMap::Y_COMPANY, $this->y_company);
        if ($this->isColumnModified(PluginInvoiceConfigTableMap::Y_NAME)) $criteria->add(PluginInvoiceConfigTableMap::Y_NAME, $this->y_name);
        if ($this->isColumnModified(PluginInvoiceConfigTableMap::Y_STREET_ADDRESS)) $criteria->add(PluginInvoiceConfigTableMap::Y_STREET_ADDRESS, $this->y_street_address);
        if ($this->isColumnModified(PluginInvoiceConfigTableMap::Y_COUNTRY)) $criteria->add(PluginInvoiceConfigTableMap::Y_COUNTRY, $this->y_country);
        if ($this->isColumnModified(PluginInvoiceConfigTableMap::Y_CITY)) $criteria->add(PluginInvoiceConfigTableMap::Y_CITY, $this->y_city);
        if ($this->isColumnModified(PluginInvoiceConfigTableMap::Y_STATE)) $criteria->add(PluginInvoiceConfigTableMap::Y_STATE, $this->y_state);
        if ($this->isColumnModified(PluginInvoiceConfigTableMap::Y_ZIP)) $criteria->add(PluginInvoiceConfigTableMap::Y_ZIP, $this->y_zip);
        if ($this->isColumnModified(PluginInvoiceConfigTableMap::Y_PHONE)) $criteria->add(PluginInvoiceConfigTableMap::Y_PHONE, $this->y_phone);
        if ($this->isColumnModified(PluginInvoiceConfigTableMap::Y_FAX)) $criteria->add(PluginInvoiceConfigTableMap::Y_FAX, $this->y_fax);
        if ($this->isColumnModified(PluginInvoiceConfigTableMap::Y_EMAIL)) $criteria->add(PluginInvoiceConfigTableMap::Y_EMAIL, $this->y_email);
        if ($this->isColumnModified(PluginInvoiceConfigTableMap::Y_URL)) $criteria->add(PluginInvoiceConfigTableMap::Y_URL, $this->y_url);
        if ($this->isColumnModified(PluginInvoiceConfigTableMap::Y_TEMPLATE)) $criteria->add(PluginInvoiceConfigTableMap::Y_TEMPLATE, $this->y_template);
        if ($this->isColumnModified(PluginInvoiceConfigTableMap::P_ACCEPT_PAYMENTS)) $criteria->add(PluginInvoiceConfigTableMap::P_ACCEPT_PAYMENTS, $this->p_accept_payments);
        if ($this->isColumnModified(PluginInvoiceConfigTableMap::P_ACCEPT_PAYPAL)) $criteria->add(PluginInvoiceConfigTableMap::P_ACCEPT_PAYPAL, $this->p_accept_paypal);
        if ($this->isColumnModified(PluginInvoiceConfigTableMap::P_ACCEPT_AUTHORIZE)) $criteria->add(PluginInvoiceConfigTableMap::P_ACCEPT_AUTHORIZE, $this->p_accept_authorize);
        if ($this->isColumnModified(PluginInvoiceConfigTableMap::P_ACCEPT_CREDITCARD)) $criteria->add(PluginInvoiceConfigTableMap::P_ACCEPT_CREDITCARD, $this->p_accept_creditcard);
        if ($this->isColumnModified(PluginInvoiceConfigTableMap::P_ACCEPT_CASH)) $criteria->add(PluginInvoiceConfigTableMap::P_ACCEPT_CASH, $this->p_accept_cash);
        if ($this->isColumnModified(PluginInvoiceConfigTableMap::P_ACCEPT_BANK)) $criteria->add(PluginInvoiceConfigTableMap::P_ACCEPT_BANK, $this->p_accept_bank);
        if ($this->isColumnModified(PluginInvoiceConfigTableMap::P_PAYPAL_ADDRESS)) $criteria->add(PluginInvoiceConfigTableMap::P_PAYPAL_ADDRESS, $this->p_paypal_address);
        if ($this->isColumnModified(PluginInvoiceConfigTableMap::P_AUTHORIZE_TZ)) $criteria->add(PluginInvoiceConfigTableMap::P_AUTHORIZE_TZ, $this->p_authorize_tz);
        if ($this->isColumnModified(PluginInvoiceConfigTableMap::P_AUTHORIZE_KEY)) $criteria->add(PluginInvoiceConfigTableMap::P_AUTHORIZE_KEY, $this->p_authorize_key);
        if ($this->isColumnModified(PluginInvoiceConfigTableMap::P_AUTHORIZE_MID)) $criteria->add(PluginInvoiceConfigTableMap::P_AUTHORIZE_MID, $this->p_authorize_mid);
        if ($this->isColumnModified(PluginInvoiceConfigTableMap::P_AUTHORIZE_HASH)) $criteria->add(PluginInvoiceConfigTableMap::P_AUTHORIZE_HASH, $this->p_authorize_hash);
        if ($this->isColumnModified(PluginInvoiceConfigTableMap::P_BANK_ACCOUNT)) $criteria->add(PluginInvoiceConfigTableMap::P_BANK_ACCOUNT, $this->p_bank_account);
        if ($this->isColumnModified(PluginInvoiceConfigTableMap::SI_INCLUDE)) $criteria->add(PluginInvoiceConfigTableMap::SI_INCLUDE, $this->si_include);
        if ($this->isColumnModified(PluginInvoiceConfigTableMap::SI_SHIPPING_ADDRESS)) $criteria->add(PluginInvoiceConfigTableMap::SI_SHIPPING_ADDRESS, $this->si_shipping_address);
        if ($this->isColumnModified(PluginInvoiceConfigTableMap::SI_COMPANY)) $criteria->add(PluginInvoiceConfigTableMap::SI_COMPANY, $this->si_company);
        if ($this->isColumnModified(PluginInvoiceConfigTableMap::SI_NAME)) $criteria->add(PluginInvoiceConfigTableMap::SI_NAME, $this->si_name);
        if ($this->isColumnModified(PluginInvoiceConfigTableMap::SI_ADDRESS)) $criteria->add(PluginInvoiceConfigTableMap::SI_ADDRESS, $this->si_address);
        if ($this->isColumnModified(PluginInvoiceConfigTableMap::SI_STREET_ADDRESS)) $criteria->add(PluginInvoiceConfigTableMap::SI_STREET_ADDRESS, $this->si_street_address);
        if ($this->isColumnModified(PluginInvoiceConfigTableMap::SI_CITY)) $criteria->add(PluginInvoiceConfigTableMap::SI_CITY, $this->si_city);
        if ($this->isColumnModified(PluginInvoiceConfigTableMap::SI_STATE)) $criteria->add(PluginInvoiceConfigTableMap::SI_STATE, $this->si_state);
        if ($this->isColumnModified(PluginInvoiceConfigTableMap::SI_ZIP)) $criteria->add(PluginInvoiceConfigTableMap::SI_ZIP, $this->si_zip);
        if ($this->isColumnModified(PluginInvoiceConfigTableMap::SI_PHONE)) $criteria->add(PluginInvoiceConfigTableMap::SI_PHONE, $this->si_phone);
        if ($this->isColumnModified(PluginInvoiceConfigTableMap::SI_FAX)) $criteria->add(PluginInvoiceConfigTableMap::SI_FAX, $this->si_fax);
        if ($this->isColumnModified(PluginInvoiceConfigTableMap::SI_EMAIL)) $criteria->add(PluginInvoiceConfigTableMap::SI_EMAIL, $this->si_email);
        if ($this->isColumnModified(PluginInvoiceConfigTableMap::SI_URL)) $criteria->add(PluginInvoiceConfigTableMap::SI_URL, $this->si_url);
        if ($this->isColumnModified(PluginInvoiceConfigTableMap::SI_DATE)) $criteria->add(PluginInvoiceConfigTableMap::SI_DATE, $this->si_date);
        if ($this->isColumnModified(PluginInvoiceConfigTableMap::SI_TERMS)) $criteria->add(PluginInvoiceConfigTableMap::SI_TERMS, $this->si_terms);
        if ($this->isColumnModified(PluginInvoiceConfigTableMap::SI_IS_SHIPPED)) $criteria->add(PluginInvoiceConfigTableMap::SI_IS_SHIPPED, $this->si_is_shipped);
        if ($this->isColumnModified(PluginInvoiceConfigTableMap::SI_SHIPPING)) $criteria->add(PluginInvoiceConfigTableMap::SI_SHIPPING, $this->si_shipping);
        if ($this->isColumnModified(PluginInvoiceConfigTableMap::O_BOOKING_URL)) $criteria->add(PluginInvoiceConfigTableMap::O_BOOKING_URL, $this->o_booking_url);
        if ($this->isColumnModified(PluginInvoiceConfigTableMap::O_QTY_IS_INT)) $criteria->add(PluginInvoiceConfigTableMap::O_QTY_IS_INT, $this->o_qty_is_int);
        if ($this->isColumnModified(PluginInvoiceConfigTableMap::O_USE_QTY_UNIT_PRICE)) $criteria->add(PluginInvoiceConfigTableMap::O_USE_QTY_UNIT_PRICE, $this->o_use_qty_unit_price);

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
        $criteria = new Criteria(PluginInvoiceConfigTableMap::DATABASE_NAME);
        $criteria->add(PluginInvoiceConfigTableMap::ID, $this->id);

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
     * @param      object $copyObj An object of \HookCalendar\Model\PluginInvoiceConfig (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
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
        $copyObj->setYTemplate($this->getYTemplate());
        $copyObj->setPAcceptPayments($this->getPAcceptPayments());
        $copyObj->setPAcceptPaypal($this->getPAcceptPaypal());
        $copyObj->setPAcceptAuthorize($this->getPAcceptAuthorize());
        $copyObj->setPAcceptCreditcard($this->getPAcceptCreditcard());
        $copyObj->setPAcceptCash($this->getPAcceptCash());
        $copyObj->setPAcceptBank($this->getPAcceptBank());
        $copyObj->setPPaypalAddress($this->getPPaypalAddress());
        $copyObj->setPAuthorizeTz($this->getPAuthorizeTz());
        $copyObj->setPAuthorizeKey($this->getPAuthorizeKey());
        $copyObj->setPAuthorizeMid($this->getPAuthorizeMid());
        $copyObj->setPAuthorizeHash($this->getPAuthorizeHash());
        $copyObj->setPBankAccount($this->getPBankAccount());
        $copyObj->setSiInclude($this->getSiInclude());
        $copyObj->setSiShippingAddress($this->getSiShippingAddress());
        $copyObj->setSiCompany($this->getSiCompany());
        $copyObj->setSiName($this->getSiName());
        $copyObj->setSiAddress($this->getSiAddress());
        $copyObj->setSiStreetAddress($this->getSiStreetAddress());
        $copyObj->setSiCity($this->getSiCity());
        $copyObj->setSiState($this->getSiState());
        $copyObj->setSiZip($this->getSiZip());
        $copyObj->setSiPhone($this->getSiPhone());
        $copyObj->setSiFax($this->getSiFax());
        $copyObj->setSiEmail($this->getSiEmail());
        $copyObj->setSiUrl($this->getSiUrl());
        $copyObj->setSiDate($this->getSiDate());
        $copyObj->setSiTerms($this->getSiTerms());
        $copyObj->setSiIsShipped($this->getSiIsShipped());
        $copyObj->setSiShipping($this->getSiShipping());
        $copyObj->setOBookingUrl($this->getOBookingUrl());
        $copyObj->setOQtyIsInt($this->getOQtyIsInt());
        $copyObj->setOUseQtyUnitPrice($this->getOUseQtyUnitPrice());
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
     * @return                 \HookCalendar\Model\PluginInvoiceConfig Clone of current object.
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
        $this->y_template = null;
        $this->p_accept_payments = null;
        $this->p_accept_paypal = null;
        $this->p_accept_authorize = null;
        $this->p_accept_creditcard = null;
        $this->p_accept_cash = null;
        $this->p_accept_bank = null;
        $this->p_paypal_address = null;
        $this->p_authorize_tz = null;
        $this->p_authorize_key = null;
        $this->p_authorize_mid = null;
        $this->p_authorize_hash = null;
        $this->p_bank_account = null;
        $this->si_include = null;
        $this->si_shipping_address = null;
        $this->si_company = null;
        $this->si_name = null;
        $this->si_address = null;
        $this->si_street_address = null;
        $this->si_city = null;
        $this->si_state = null;
        $this->si_zip = null;
        $this->si_phone = null;
        $this->si_fax = null;
        $this->si_email = null;
        $this->si_url = null;
        $this->si_date = null;
        $this->si_terms = null;
        $this->si_is_shipped = null;
        $this->si_shipping = null;
        $this->o_booking_url = null;
        $this->o_qty_is_int = null;
        $this->o_use_qty_unit_price = null;
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
        return (string) $this->exportTo(PluginInvoiceConfigTableMap::DEFAULT_STRING_FORMAT);
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
