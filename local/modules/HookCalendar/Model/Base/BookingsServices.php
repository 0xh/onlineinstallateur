<?php

namespace HookCalendar\Model\Base;

use \DateTime;
use \Exception;
use \PDO;
use HookCalendar\Model\BookingsServicesQuery as ChildBookingsServicesQuery;
use HookCalendar\Model\Map\BookingsServicesTableMap;
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

abstract class BookingsServices implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\HookCalendar\\Model\\Map\\BookingsServicesTableMap';


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
     * The value for the tmp_hash field.
     * @var        string
     */
    protected $tmp_hash;

    /**
     * The value for the booking_id field.
     * @var        int
     */
    protected $booking_id;

    /**
     * The value for the customer_id field.
     * @var        int
     */
    protected $customer_id;

    /**
     * The value for the cart_item_id field.
     * @var        int
     */
    protected $cart_item_id;

    /**
     * The value for the service_id field.
     * @var        int
     */
    protected $service_id;

    /**
     * The value for the employee_id field.
     * @var        int
     */
    protected $employee_id;

    /**
     * The value for the date field.
     * @var        string
     */
    protected $date;

    /**
     * The value for the start field.
     * @var        string
     */
    protected $start;

    /**
     * The value for the start_ts field.
     * @var        int
     */
    protected $start_ts;

    /**
     * The value for the stop_ts field.
     * @var        int
     */
    protected $stop_ts;

    /**
     * The value for the reminder_email field.
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $reminder_email;

    /**
     * The value for the reminder_sms field.
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $reminder_sms;

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
        $this->reminder_email = false;
        $this->reminder_sms = false;
    }

    /**
     * Initializes internal state of HookCalendar\Model\Base\BookingsServices object.
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
     * Compares this with another <code>BookingsServices</code> instance.  If
     * <code>obj</code> is an instance of <code>BookingsServices</code>, delegates to
     * <code>equals(BookingsServices)</code>.  Otherwise, returns <code>false</code>.
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
     * @return BookingsServices The current object, for fluid interface
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
     * @return BookingsServices The current object, for fluid interface
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
     * Get the [tmp_hash] column value.
     *
     * @return   string
     */
    public function getTmpHash()
    {

        return $this->tmp_hash;
    }

    /**
     * Get the [booking_id] column value.
     *
     * @return   int
     */
    public function getBookingId()
    {

        return $this->booking_id;
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
     * Get the [cart_item_id] column value.
     *
     * @return   int
     */
    public function getCartItemId()
    {

        return $this->cart_item_id;
    }

    /**
     * Get the [service_id] column value.
     *
     * @return   int
     */
    public function getServiceId()
    {

        return $this->service_id;
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
     * Get the [optionally formatted] temporal [date] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw \DateTime object will be returned.
     *
     * @return mixed Formatted date/time value as string or \DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getDate($format = NULL)
    {
        if ($format === null) {
            return $this->date;
        } else {
            return $this->date instanceof \DateTime ? $this->date->format($format) : null;
        }
    }

    /**
     * Get the [optionally formatted] temporal [start] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw \DateTime object will be returned.
     *
     * @return mixed Formatted date/time value as string or \DateTime object (if format is NULL), NULL if column is NULL
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getStart($format = NULL)
    {
        if ($format === null) {
            return $this->start;
        } else {
            return $this->start instanceof \DateTime ? $this->start->format($format) : null;
        }
    }

    /**
     * Get the [start_ts] column value.
     *
     * @return   int
     */
    public function getStartTs()
    {

        return $this->start_ts;
    }

    /**
     * Get the [stop_ts] column value.
     *
     * @return   int
     */
    public function getStopTs()
    {

        return $this->stop_ts;
    }

    /**
     * Get the [reminder_email] column value.
     *
     * @return   boolean
     */
    public function getReminderEmail()
    {

        return $this->reminder_email;
    }

    /**
     * Get the [reminder_sms] column value.
     *
     * @return   boolean
     */
    public function getReminderSms()
    {

        return $this->reminder_sms;
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
     * Set the value of [id] column.
     *
     * @param      int $v new value
     * @return   \HookCalendar\Model\BookingsServices The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[BookingsServicesTableMap::ID] = true;
        }


        return $this;
    } // setId()

    /**
     * Set the value of [tmp_hash] column.
     *
     * @param      string $v new value
     * @return   \HookCalendar\Model\BookingsServices The current object (for fluent API support)
     */
    public function setTmpHash($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->tmp_hash !== $v) {
            $this->tmp_hash = $v;
            $this->modifiedColumns[BookingsServicesTableMap::TMP_HASH] = true;
        }


        return $this;
    } // setTmpHash()

    /**
     * Set the value of [booking_id] column.
     *
     * @param      int $v new value
     * @return   \HookCalendar\Model\BookingsServices The current object (for fluent API support)
     */
    public function setBookingId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->booking_id !== $v) {
            $this->booking_id = $v;
            $this->modifiedColumns[BookingsServicesTableMap::BOOKING_ID] = true;
        }


        return $this;
    } // setBookingId()

    /**
     * Set the value of [customer_id] column.
     *
     * @param      int $v new value
     * @return   \HookCalendar\Model\BookingsServices The current object (for fluent API support)
     */
    public function setCustomerId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->customer_id !== $v) {
            $this->customer_id = $v;
            $this->modifiedColumns[BookingsServicesTableMap::CUSTOMER_ID] = true;
        }


        return $this;
    } // setCustomerId()

    /**
     * Set the value of [cart_item_id] column.
     *
     * @param      int $v new value
     * @return   \HookCalendar\Model\BookingsServices The current object (for fluent API support)
     */
    public function setCartItemId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->cart_item_id !== $v) {
            $this->cart_item_id = $v;
            $this->modifiedColumns[BookingsServicesTableMap::CART_ITEM_ID] = true;
        }


        return $this;
    } // setCartItemId()

    /**
     * Set the value of [service_id] column.
     *
     * @param      int $v new value
     * @return   \HookCalendar\Model\BookingsServices The current object (for fluent API support)
     */
    public function setServiceId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->service_id !== $v) {
            $this->service_id = $v;
            $this->modifiedColumns[BookingsServicesTableMap::SERVICE_ID] = true;
        }


        return $this;
    } // setServiceId()

    /**
     * Set the value of [employee_id] column.
     *
     * @param      int $v new value
     * @return   \HookCalendar\Model\BookingsServices The current object (for fluent API support)
     */
    public function setEmployeeId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->employee_id !== $v) {
            $this->employee_id = $v;
            $this->modifiedColumns[BookingsServicesTableMap::EMPLOYEE_ID] = true;
        }


        return $this;
    } // setEmployeeId()

    /**
     * Sets the value of [date] column to a normalized version of the date/time value specified.
     *
     * @param      mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return   \HookCalendar\Model\BookingsServices The current object (for fluent API support)
     */
    public function setDate($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->date !== null || $dt !== null) {
            if ($dt !== $this->date) {
                $this->date = $dt;
                $this->modifiedColumns[BookingsServicesTableMap::DATE] = true;
            }
        } // if either are not null


        return $this;
    } // setDate()

    /**
     * Sets the value of [start] column to a normalized version of the date/time value specified.
     *
     * @param      mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return   \HookCalendar\Model\BookingsServices The current object (for fluent API support)
     */
    public function setStart($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->start !== null || $dt !== null) {
            if ($dt !== $this->start) {
                $this->start = $dt;
                $this->modifiedColumns[BookingsServicesTableMap::START] = true;
            }
        } // if either are not null


        return $this;
    } // setStart()

    /**
     * Set the value of [start_ts] column.
     *
     * @param      int $v new value
     * @return   \HookCalendar\Model\BookingsServices The current object (for fluent API support)
     */
    public function setStartTs($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->start_ts !== $v) {
            $this->start_ts = $v;
            $this->modifiedColumns[BookingsServicesTableMap::START_TS] = true;
        }


        return $this;
    } // setStartTs()

    /**
     * Set the value of [stop_ts] column.
     *
     * @param      int $v new value
     * @return   \HookCalendar\Model\BookingsServices The current object (for fluent API support)
     */
    public function setStopTs($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->stop_ts !== $v) {
            $this->stop_ts = $v;
            $this->modifiedColumns[BookingsServicesTableMap::STOP_TS] = true;
        }


        return $this;
    } // setStopTs()

    /**
     * Sets the value of the [reminder_email] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param      boolean|integer|string $v The new value
     * @return   \HookCalendar\Model\BookingsServices The current object (for fluent API support)
     */
    public function setReminderEmail($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->reminder_email !== $v) {
            $this->reminder_email = $v;
            $this->modifiedColumns[BookingsServicesTableMap::REMINDER_EMAIL] = true;
        }


        return $this;
    } // setReminderEmail()

    /**
     * Sets the value of the [reminder_sms] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param      boolean|integer|string $v The new value
     * @return   \HookCalendar\Model\BookingsServices The current object (for fluent API support)
     */
    public function setReminderSms($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->reminder_sms !== $v) {
            $this->reminder_sms = $v;
            $this->modifiedColumns[BookingsServicesTableMap::REMINDER_SMS] = true;
        }


        return $this;
    } // setReminderSms()

    /**
     * Sets the value of [created_at] column to a normalized version of the date/time value specified.
     *
     * @param      mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return   \HookCalendar\Model\BookingsServices The current object (for fluent API support)
     */
    public function setCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->created_at !== null || $dt !== null) {
            if ($dt !== $this->created_at) {
                $this->created_at = $dt;
                $this->modifiedColumns[BookingsServicesTableMap::CREATED_AT] = true;
            }
        } // if either are not null


        return $this;
    } // setCreatedAt()

    /**
     * Sets the value of [updated_at] column to a normalized version of the date/time value specified.
     *
     * @param      mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return   \HookCalendar\Model\BookingsServices The current object (for fluent API support)
     */
    public function setUpdatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->updated_at !== null || $dt !== null) {
            if ($dt !== $this->updated_at) {
                $this->updated_at = $dt;
                $this->modifiedColumns[BookingsServicesTableMap::UPDATED_AT] = true;
            }
        } // if either are not null


        return $this;
    } // setUpdatedAt()

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
            if ($this->reminder_email !== false) {
                return false;
            }

            if ($this->reminder_sms !== false) {
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


            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : BookingsServicesTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : BookingsServicesTableMap::translateFieldName('TmpHash', TableMap::TYPE_PHPNAME, $indexType)];
            $this->tmp_hash = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : BookingsServicesTableMap::translateFieldName('BookingId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->booking_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : BookingsServicesTableMap::translateFieldName('CustomerId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->customer_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : BookingsServicesTableMap::translateFieldName('CartItemId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->cart_item_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : BookingsServicesTableMap::translateFieldName('ServiceId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->service_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : BookingsServicesTableMap::translateFieldName('EmployeeId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->employee_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : BookingsServicesTableMap::translateFieldName('Date', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00') {
                $col = null;
            }
            $this->date = (null !== $col) ? PropelDateTime::newInstance($col, null, '\DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : BookingsServicesTableMap::translateFieldName('Start', TableMap::TYPE_PHPNAME, $indexType)];
            $this->start = (null !== $col) ? PropelDateTime::newInstance($col, null, '\DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : BookingsServicesTableMap::translateFieldName('StartTs', TableMap::TYPE_PHPNAME, $indexType)];
            $this->start_ts = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 10 + $startcol : BookingsServicesTableMap::translateFieldName('StopTs', TableMap::TYPE_PHPNAME, $indexType)];
            $this->stop_ts = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 11 + $startcol : BookingsServicesTableMap::translateFieldName('ReminderEmail', TableMap::TYPE_PHPNAME, $indexType)];
            $this->reminder_email = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 12 + $startcol : BookingsServicesTableMap::translateFieldName('ReminderSms', TableMap::TYPE_PHPNAME, $indexType)];
            $this->reminder_sms = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 13 + $startcol : BookingsServicesTableMap::translateFieldName('CreatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->created_at = (null !== $col) ? PropelDateTime::newInstance($col, null, '\DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 14 + $startcol : BookingsServicesTableMap::translateFieldName('UpdatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->updated_at = (null !== $col) ? PropelDateTime::newInstance($col, null, '\DateTime') : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 15; // 15 = BookingsServicesTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating \HookCalendar\Model\BookingsServices object", 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(BookingsServicesTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildBookingsServicesQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
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
     * @see BookingsServices::setDeleted()
     * @see BookingsServices::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(BookingsServicesTableMap::DATABASE_NAME);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = ChildBookingsServicesQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(BookingsServicesTableMap::DATABASE_NAME);
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
                BookingsServicesTableMap::addInstanceToPool($this);
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

        $this->modifiedColumns[BookingsServicesTableMap::ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . BookingsServicesTableMap::ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(BookingsServicesTableMap::ID)) {
            $modifiedColumns[':p' . $index++]  = 'ID';
        }
        if ($this->isColumnModified(BookingsServicesTableMap::TMP_HASH)) {
            $modifiedColumns[':p' . $index++]  = 'TMP_HASH';
        }
        if ($this->isColumnModified(BookingsServicesTableMap::BOOKING_ID)) {
            $modifiedColumns[':p' . $index++]  = 'BOOKING_ID';
        }
        if ($this->isColumnModified(BookingsServicesTableMap::CUSTOMER_ID)) {
            $modifiedColumns[':p' . $index++]  = 'CUSTOMER_ID';
        }
        if ($this->isColumnModified(BookingsServicesTableMap::CART_ITEM_ID)) {
            $modifiedColumns[':p' . $index++]  = 'CART_ITEM_ID';
        }
        if ($this->isColumnModified(BookingsServicesTableMap::SERVICE_ID)) {
            $modifiedColumns[':p' . $index++]  = 'SERVICE_ID';
        }
        if ($this->isColumnModified(BookingsServicesTableMap::EMPLOYEE_ID)) {
            $modifiedColumns[':p' . $index++]  = 'EMPLOYEE_ID';
        }
        if ($this->isColumnModified(BookingsServicesTableMap::DATE)) {
            $modifiedColumns[':p' . $index++]  = 'DATE';
        }
        if ($this->isColumnModified(BookingsServicesTableMap::START)) {
            $modifiedColumns[':p' . $index++]  = 'START';
        }
        if ($this->isColumnModified(BookingsServicesTableMap::START_TS)) {
            $modifiedColumns[':p' . $index++]  = 'START_TS';
        }
        if ($this->isColumnModified(BookingsServicesTableMap::STOP_TS)) {
            $modifiedColumns[':p' . $index++]  = 'STOP_TS';
        }
        if ($this->isColumnModified(BookingsServicesTableMap::REMINDER_EMAIL)) {
            $modifiedColumns[':p' . $index++]  = 'REMINDER_EMAIL';
        }
        if ($this->isColumnModified(BookingsServicesTableMap::REMINDER_SMS)) {
            $modifiedColumns[':p' . $index++]  = 'REMINDER_SMS';
        }
        if ($this->isColumnModified(BookingsServicesTableMap::CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'CREATED_AT';
        }
        if ($this->isColumnModified(BookingsServicesTableMap::UPDATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'UPDATED_AT';
        }

        $sql = sprintf(
            'INSERT INTO bookings_services (%s) VALUES (%s)',
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
                    case 'TMP_HASH':
                        $stmt->bindValue($identifier, $this->tmp_hash, PDO::PARAM_STR);
                        break;
                    case 'BOOKING_ID':
                        $stmt->bindValue($identifier, $this->booking_id, PDO::PARAM_INT);
                        break;
                    case 'CUSTOMER_ID':
                        $stmt->bindValue($identifier, $this->customer_id, PDO::PARAM_INT);
                        break;
                    case 'CART_ITEM_ID':
                        $stmt->bindValue($identifier, $this->cart_item_id, PDO::PARAM_INT);
                        break;
                    case 'SERVICE_ID':
                        $stmt->bindValue($identifier, $this->service_id, PDO::PARAM_INT);
                        break;
                    case 'EMPLOYEE_ID':
                        $stmt->bindValue($identifier, $this->employee_id, PDO::PARAM_INT);
                        break;
                    case 'DATE':
                        $stmt->bindValue($identifier, $this->date ? $this->date->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                    case 'START':
                        $stmt->bindValue($identifier, $this->start ? $this->start->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                    case 'START_TS':
                        $stmt->bindValue($identifier, $this->start_ts, PDO::PARAM_INT);
                        break;
                    case 'STOP_TS':
                        $stmt->bindValue($identifier, $this->stop_ts, PDO::PARAM_INT);
                        break;
                    case 'REMINDER_EMAIL':
                        $stmt->bindValue($identifier, (int) $this->reminder_email, PDO::PARAM_INT);
                        break;
                    case 'REMINDER_SMS':
                        $stmt->bindValue($identifier, (int) $this->reminder_sms, PDO::PARAM_INT);
                        break;
                    case 'CREATED_AT':
                        $stmt->bindValue($identifier, $this->created_at ? $this->created_at->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                    case 'UPDATED_AT':
                        $stmt->bindValue($identifier, $this->updated_at ? $this->updated_at->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
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
        $pos = BookingsServicesTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getTmpHash();
                break;
            case 2:
                return $this->getBookingId();
                break;
            case 3:
                return $this->getCustomerId();
                break;
            case 4:
                return $this->getCartItemId();
                break;
            case 5:
                return $this->getServiceId();
                break;
            case 6:
                return $this->getEmployeeId();
                break;
            case 7:
                return $this->getDate();
                break;
            case 8:
                return $this->getStart();
                break;
            case 9:
                return $this->getStartTs();
                break;
            case 10:
                return $this->getStopTs();
                break;
            case 11:
                return $this->getReminderEmail();
                break;
            case 12:
                return $this->getReminderSms();
                break;
            case 13:
                return $this->getCreatedAt();
                break;
            case 14:
                return $this->getUpdatedAt();
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
        if (isset($alreadyDumpedObjects['BookingsServices'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['BookingsServices'][$this->getPrimaryKey()] = true;
        $keys = BookingsServicesTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getTmpHash(),
            $keys[2] => $this->getBookingId(),
            $keys[3] => $this->getCustomerId(),
            $keys[4] => $this->getCartItemId(),
            $keys[5] => $this->getServiceId(),
            $keys[6] => $this->getEmployeeId(),
            $keys[7] => $this->getDate(),
            $keys[8] => $this->getStart(),
            $keys[9] => $this->getStartTs(),
            $keys[10] => $this->getStopTs(),
            $keys[11] => $this->getReminderEmail(),
            $keys[12] => $this->getReminderSms(),
            $keys[13] => $this->getCreatedAt(),
            $keys[14] => $this->getUpdatedAt(),
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
        $pos = BookingsServicesTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

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
                $this->setTmpHash($value);
                break;
            case 2:
                $this->setBookingId($value);
                break;
            case 3:
                $this->setCustomerId($value);
                break;
            case 4:
                $this->setCartItemId($value);
                break;
            case 5:
                $this->setServiceId($value);
                break;
            case 6:
                $this->setEmployeeId($value);
                break;
            case 7:
                $this->setDate($value);
                break;
            case 8:
                $this->setStart($value);
                break;
            case 9:
                $this->setStartTs($value);
                break;
            case 10:
                $this->setStopTs($value);
                break;
            case 11:
                $this->setReminderEmail($value);
                break;
            case 12:
                $this->setReminderSms($value);
                break;
            case 13:
                $this->setCreatedAt($value);
                break;
            case 14:
                $this->setUpdatedAt($value);
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
        $keys = BookingsServicesTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setTmpHash($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setBookingId($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setCustomerId($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setCartItemId($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setServiceId($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setEmployeeId($arr[$keys[6]]);
        if (array_key_exists($keys[7], $arr)) $this->setDate($arr[$keys[7]]);
        if (array_key_exists($keys[8], $arr)) $this->setStart($arr[$keys[8]]);
        if (array_key_exists($keys[9], $arr)) $this->setStartTs($arr[$keys[9]]);
        if (array_key_exists($keys[10], $arr)) $this->setStopTs($arr[$keys[10]]);
        if (array_key_exists($keys[11], $arr)) $this->setReminderEmail($arr[$keys[11]]);
        if (array_key_exists($keys[12], $arr)) $this->setReminderSms($arr[$keys[12]]);
        if (array_key_exists($keys[13], $arr)) $this->setCreatedAt($arr[$keys[13]]);
        if (array_key_exists($keys[14], $arr)) $this->setUpdatedAt($arr[$keys[14]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(BookingsServicesTableMap::DATABASE_NAME);

        if ($this->isColumnModified(BookingsServicesTableMap::ID)) $criteria->add(BookingsServicesTableMap::ID, $this->id);
        if ($this->isColumnModified(BookingsServicesTableMap::TMP_HASH)) $criteria->add(BookingsServicesTableMap::TMP_HASH, $this->tmp_hash);
        if ($this->isColumnModified(BookingsServicesTableMap::BOOKING_ID)) $criteria->add(BookingsServicesTableMap::BOOKING_ID, $this->booking_id);
        if ($this->isColumnModified(BookingsServicesTableMap::CUSTOMER_ID)) $criteria->add(BookingsServicesTableMap::CUSTOMER_ID, $this->customer_id);
        if ($this->isColumnModified(BookingsServicesTableMap::CART_ITEM_ID)) $criteria->add(BookingsServicesTableMap::CART_ITEM_ID, $this->cart_item_id);
        if ($this->isColumnModified(BookingsServicesTableMap::SERVICE_ID)) $criteria->add(BookingsServicesTableMap::SERVICE_ID, $this->service_id);
        if ($this->isColumnModified(BookingsServicesTableMap::EMPLOYEE_ID)) $criteria->add(BookingsServicesTableMap::EMPLOYEE_ID, $this->employee_id);
        if ($this->isColumnModified(BookingsServicesTableMap::DATE)) $criteria->add(BookingsServicesTableMap::DATE, $this->date);
        if ($this->isColumnModified(BookingsServicesTableMap::START)) $criteria->add(BookingsServicesTableMap::START, $this->start);
        if ($this->isColumnModified(BookingsServicesTableMap::START_TS)) $criteria->add(BookingsServicesTableMap::START_TS, $this->start_ts);
        if ($this->isColumnModified(BookingsServicesTableMap::STOP_TS)) $criteria->add(BookingsServicesTableMap::STOP_TS, $this->stop_ts);
        if ($this->isColumnModified(BookingsServicesTableMap::REMINDER_EMAIL)) $criteria->add(BookingsServicesTableMap::REMINDER_EMAIL, $this->reminder_email);
        if ($this->isColumnModified(BookingsServicesTableMap::REMINDER_SMS)) $criteria->add(BookingsServicesTableMap::REMINDER_SMS, $this->reminder_sms);
        if ($this->isColumnModified(BookingsServicesTableMap::CREATED_AT)) $criteria->add(BookingsServicesTableMap::CREATED_AT, $this->created_at);
        if ($this->isColumnModified(BookingsServicesTableMap::UPDATED_AT)) $criteria->add(BookingsServicesTableMap::UPDATED_AT, $this->updated_at);

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
        $criteria = new Criteria(BookingsServicesTableMap::DATABASE_NAME);
        $criteria->add(BookingsServicesTableMap::ID, $this->id);

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
     * @param      object $copyObj An object of \HookCalendar\Model\BookingsServices (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setTmpHash($this->getTmpHash());
        $copyObj->setBookingId($this->getBookingId());
        $copyObj->setCustomerId($this->getCustomerId());
        $copyObj->setCartItemId($this->getCartItemId());
        $copyObj->setServiceId($this->getServiceId());
        $copyObj->setEmployeeId($this->getEmployeeId());
        $copyObj->setDate($this->getDate());
        $copyObj->setStart($this->getStart());
        $copyObj->setStartTs($this->getStartTs());
        $copyObj->setStopTs($this->getStopTs());
        $copyObj->setReminderEmail($this->getReminderEmail());
        $copyObj->setReminderSms($this->getReminderSms());
        $copyObj->setCreatedAt($this->getCreatedAt());
        $copyObj->setUpdatedAt($this->getUpdatedAt());
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
     * @return                 \HookCalendar\Model\BookingsServices Clone of current object.
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
        $this->tmp_hash = null;
        $this->booking_id = null;
        $this->customer_id = null;
        $this->cart_item_id = null;
        $this->service_id = null;
        $this->employee_id = null;
        $this->date = null;
        $this->start = null;
        $this->start_ts = null;
        $this->stop_ts = null;
        $this->reminder_email = null;
        $this->reminder_sms = null;
        $this->created_at = null;
        $this->updated_at = null;
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
        return (string) $this->exportTo(BookingsServicesTableMap::DEFAULT_STRING_FORMAT);
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
