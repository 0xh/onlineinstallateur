<?php

namespace AmazonIntegration\Model\Base;

use \DateTime;
use \Exception;
use \PDO;
use AmazonIntegration\Model\AmazonFinancialEventGroupQuery as ChildAmazonFinancialEventGroupQuery;
use AmazonIntegration\Model\Map\AmazonFinancialEventGroupTableMap;
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

abstract class AmazonFinancialEventGroup implements ActiveRecordInterface 
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\AmazonIntegration\\Model\\Map\\AmazonFinancialEventGroupTableMap';


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
     * The value for the financialeventgroupid field.
     * @var        string
     */
    protected $financialeventgroupid;

    /**
     * The value for the processingstatus field.
     * @var        string
     */
    protected $processingstatus;

    /**
     * The value for the fundtransferstatus field.
     * @var        string
     */
    protected $fundtransferstatus;

    /**
     * The value for the originaltotal field.
     * Note: this column has a database default value of: '0.00'
     * @var        string
     */
    protected $originaltotal;

    /**
     * The value for the convertedtotal field.
     * Note: this column has a database default value of: '0.00'
     * @var        string
     */
    protected $convertedtotal;

    /**
     * The value for the fundtransferdate field.
     * @var        string
     */
    protected $fundtransferdate;

    /**
     * The value for the traceid field.
     * @var        string
     */
    protected $traceid;

    /**
     * The value for the accounttail field.
     * @var        string
     */
    protected $accounttail;

    /**
     * The value for the beginningbalance field.
     * Note: this column has a database default value of: '0.00'
     * @var        string
     */
    protected $beginningbalance;

    /**
     * The value for the financialeventgroupstart field.
     * @var        string
     */
    protected $financialeventgroupstart;

    /**
     * The value for the financialeventgroupend field.
     * @var        string
     */
    protected $financialeventgroupend;

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
        $this->originaltotal = '0.00';
        $this->convertedtotal = '0.00';
        $this->beginningbalance = '0.00';
    }

    /**
     * Initializes internal state of AmazonIntegration\Model\Base\AmazonFinancialEventGroup object.
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
     * Compares this with another <code>AmazonFinancialEventGroup</code> instance.  If
     * <code>obj</code> is an instance of <code>AmazonFinancialEventGroup</code>, delegates to
     * <code>equals(AmazonFinancialEventGroup)</code>.  Otherwise, returns <code>false</code>.
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
     * @return AmazonFinancialEventGroup The current object, for fluid interface
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
     * @return AmazonFinancialEventGroup The current object, for fluid interface
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
     * Get the [financialeventgroupid] column value.
     * 
     * @return   string
     */
    public function getFinancialEventGroupId()
    {

        return $this->financialeventgroupid;
    }

    /**
     * Get the [processingstatus] column value.
     * 
     * @return   string
     */
    public function getProcessingStatus()
    {

        return $this->processingstatus;
    }

    /**
     * Get the [fundtransferstatus] column value.
     * 
     * @return   string
     */
    public function getFundTransferStatus()
    {

        return $this->fundtransferstatus;
    }

    /**
     * Get the [originaltotal] column value.
     * 
     * @return   string
     */
    public function getOriginalTotal()
    {

        return $this->originaltotal;
    }

    /**
     * Get the [convertedtotal] column value.
     * 
     * @return   string
     */
    public function getConvertedTotal()
    {

        return $this->convertedtotal;
    }

    /**
     * Get the [optionally formatted] temporal [fundtransferdate] column value.
     * 
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw \DateTime object will be returned.
     *
     * @return mixed Formatted date/time value as string or \DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getFundTransferDate($format = NULL)
    {
        if ($format === null) {
            return $this->fundtransferdate;
        } else {
            return $this->fundtransferdate instanceof \DateTime ? $this->fundtransferdate->format($format) : null;
        }
    }

    /**
     * Get the [traceid] column value.
     * 
     * @return   string
     */
    public function getTraceId()
    {

        return $this->traceid;
    }

    /**
     * Get the [accounttail] column value.
     * 
     * @return   string
     */
    public function getAccountTail()
    {

        return $this->accounttail;
    }

    /**
     * Get the [beginningbalance] column value.
     * 
     * @return   string
     */
    public function getBeginningBalance()
    {

        return $this->beginningbalance;
    }

    /**
     * Get the [optionally formatted] temporal [financialeventgroupstart] column value.
     * 
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw \DateTime object will be returned.
     *
     * @return mixed Formatted date/time value as string or \DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getFinancialEventGroupStart($format = NULL)
    {
        if ($format === null) {
            return $this->financialeventgroupstart;
        } else {
            return $this->financialeventgroupstart instanceof \DateTime ? $this->financialeventgroupstart->format($format) : null;
        }
    }

    /**
     * Get the [optionally formatted] temporal [financialeventgroupend] column value.
     * 
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw \DateTime object will be returned.
     *
     * @return mixed Formatted date/time value as string or \DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getFinancialEventGroupEnd($format = NULL)
    {
        if ($format === null) {
            return $this->financialeventgroupend;
        } else {
            return $this->financialeventgroupend instanceof \DateTime ? $this->financialeventgroupend->format($format) : null;
        }
    }

    /**
     * Set the value of [id] column.
     * 
     * @param      int $v new value
     * @return   \AmazonIntegration\Model\AmazonFinancialEventGroup The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[AmazonFinancialEventGroupTableMap::ID] = true;
        }


        return $this;
    } // setId()

    /**
     * Set the value of [financialeventgroupid] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonFinancialEventGroup The current object (for fluent API support)
     */
    public function setFinancialEventGroupId($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->financialeventgroupid !== $v) {
            $this->financialeventgroupid = $v;
            $this->modifiedColumns[AmazonFinancialEventGroupTableMap::FINANCIALEVENTGROUPID] = true;
        }


        return $this;
    } // setFinancialEventGroupId()

    /**
     * Set the value of [processingstatus] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonFinancialEventGroup The current object (for fluent API support)
     */
    public function setProcessingStatus($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->processingstatus !== $v) {
            $this->processingstatus = $v;
            $this->modifiedColumns[AmazonFinancialEventGroupTableMap::PROCESSINGSTATUS] = true;
        }


        return $this;
    } // setProcessingStatus()

    /**
     * Set the value of [fundtransferstatus] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonFinancialEventGroup The current object (for fluent API support)
     */
    public function setFundTransferStatus($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->fundtransferstatus !== $v) {
            $this->fundtransferstatus = $v;
            $this->modifiedColumns[AmazonFinancialEventGroupTableMap::FUNDTRANSFERSTATUS] = true;
        }


        return $this;
    } // setFundTransferStatus()

    /**
     * Set the value of [originaltotal] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonFinancialEventGroup The current object (for fluent API support)
     */
    public function setOriginalTotal($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->originaltotal !== $v) {
            $this->originaltotal = $v;
            $this->modifiedColumns[AmazonFinancialEventGroupTableMap::ORIGINALTOTAL] = true;
        }


        return $this;
    } // setOriginalTotal()

    /**
     * Set the value of [convertedtotal] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonFinancialEventGroup The current object (for fluent API support)
     */
    public function setConvertedTotal($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->convertedtotal !== $v) {
            $this->convertedtotal = $v;
            $this->modifiedColumns[AmazonFinancialEventGroupTableMap::CONVERTEDTOTAL] = true;
        }


        return $this;
    } // setConvertedTotal()

    /**
     * Sets the value of [fundtransferdate] column to a normalized version of the date/time value specified.
     * 
     * @param      mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return   \AmazonIntegration\Model\AmazonFinancialEventGroup The current object (for fluent API support)
     */
    public function setFundTransferDate($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->fundtransferdate !== null || $dt !== null) {
            if ($dt !== $this->fundtransferdate) {
                $this->fundtransferdate = $dt;
                $this->modifiedColumns[AmazonFinancialEventGroupTableMap::FUNDTRANSFERDATE] = true;
            }
        } // if either are not null


        return $this;
    } // setFundTransferDate()

    /**
     * Set the value of [traceid] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonFinancialEventGroup The current object (for fluent API support)
     */
    public function setTraceId($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->traceid !== $v) {
            $this->traceid = $v;
            $this->modifiedColumns[AmazonFinancialEventGroupTableMap::TRACEID] = true;
        }


        return $this;
    } // setTraceId()

    /**
     * Set the value of [accounttail] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonFinancialEventGroup The current object (for fluent API support)
     */
    public function setAccountTail($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->accounttail !== $v) {
            $this->accounttail = $v;
            $this->modifiedColumns[AmazonFinancialEventGroupTableMap::ACCOUNTTAIL] = true;
        }


        return $this;
    } // setAccountTail()

    /**
     * Set the value of [beginningbalance] column.
     * 
     * @param      string $v new value
     * @return   \AmazonIntegration\Model\AmazonFinancialEventGroup The current object (for fluent API support)
     */
    public function setBeginningBalance($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->beginningbalance !== $v) {
            $this->beginningbalance = $v;
            $this->modifiedColumns[AmazonFinancialEventGroupTableMap::BEGINNINGBALANCE] = true;
        }


        return $this;
    } // setBeginningBalance()

    /**
     * Sets the value of [financialeventgroupstart] column to a normalized version of the date/time value specified.
     * 
     * @param      mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return   \AmazonIntegration\Model\AmazonFinancialEventGroup The current object (for fluent API support)
     */
    public function setFinancialEventGroupStart($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->financialeventgroupstart !== null || $dt !== null) {
            if ($dt !== $this->financialeventgroupstart) {
                $this->financialeventgroupstart = $dt;
                $this->modifiedColumns[AmazonFinancialEventGroupTableMap::FINANCIALEVENTGROUPSTART] = true;
            }
        } // if either are not null


        return $this;
    } // setFinancialEventGroupStart()

    /**
     * Sets the value of [financialeventgroupend] column to a normalized version of the date/time value specified.
     * 
     * @param      mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return   \AmazonIntegration\Model\AmazonFinancialEventGroup The current object (for fluent API support)
     */
    public function setFinancialEventGroupEnd($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->financialeventgroupend !== null || $dt !== null) {
            if ($dt !== $this->financialeventgroupend) {
                $this->financialeventgroupend = $dt;
                $this->modifiedColumns[AmazonFinancialEventGroupTableMap::FINANCIALEVENTGROUPEND] = true;
            }
        } // if either are not null


        return $this;
    } // setFinancialEventGroupEnd()

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
            if ($this->originaltotal !== '0.00') {
                return false;
            }

            if ($this->convertedtotal !== '0.00') {
                return false;
            }

            if ($this->beginningbalance !== '0.00') {
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


            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : AmazonFinancialEventGroupTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : AmazonFinancialEventGroupTableMap::translateFieldName('FinancialEventGroupId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->financialeventgroupid = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : AmazonFinancialEventGroupTableMap::translateFieldName('ProcessingStatus', TableMap::TYPE_PHPNAME, $indexType)];
            $this->processingstatus = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : AmazonFinancialEventGroupTableMap::translateFieldName('FundTransferStatus', TableMap::TYPE_PHPNAME, $indexType)];
            $this->fundtransferstatus = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : AmazonFinancialEventGroupTableMap::translateFieldName('OriginalTotal', TableMap::TYPE_PHPNAME, $indexType)];
            $this->originaltotal = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : AmazonFinancialEventGroupTableMap::translateFieldName('ConvertedTotal', TableMap::TYPE_PHPNAME, $indexType)];
            $this->convertedtotal = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : AmazonFinancialEventGroupTableMap::translateFieldName('FundTransferDate', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->fundtransferdate = (null !== $col) ? PropelDateTime::newInstance($col, null, '\DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : AmazonFinancialEventGroupTableMap::translateFieldName('TraceId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->traceid = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : AmazonFinancialEventGroupTableMap::translateFieldName('AccountTail', TableMap::TYPE_PHPNAME, $indexType)];
            $this->accounttail = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : AmazonFinancialEventGroupTableMap::translateFieldName('BeginningBalance', TableMap::TYPE_PHPNAME, $indexType)];
            $this->beginningbalance = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 10 + $startcol : AmazonFinancialEventGroupTableMap::translateFieldName('FinancialEventGroupStart', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->financialeventgroupstart = (null !== $col) ? PropelDateTime::newInstance($col, null, '\DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 11 + $startcol : AmazonFinancialEventGroupTableMap::translateFieldName('FinancialEventGroupEnd', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->financialeventgroupend = (null !== $col) ? PropelDateTime::newInstance($col, null, '\DateTime') : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 12; // 12 = AmazonFinancialEventGroupTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating \AmazonIntegration\Model\AmazonFinancialEventGroup object", 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(AmazonFinancialEventGroupTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildAmazonFinancialEventGroupQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
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
     * @see AmazonFinancialEventGroup::setDeleted()
     * @see AmazonFinancialEventGroup::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(AmazonFinancialEventGroupTableMap::DATABASE_NAME);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = ChildAmazonFinancialEventGroupQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(AmazonFinancialEventGroupTableMap::DATABASE_NAME);
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
                AmazonFinancialEventGroupTableMap::addInstanceToPool($this);
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

        $this->modifiedColumns[AmazonFinancialEventGroupTableMap::ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . AmazonFinancialEventGroupTableMap::ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(AmazonFinancialEventGroupTableMap::ID)) {
            $modifiedColumns[':p' . $index++]  = 'ID';
        }
        if ($this->isColumnModified(AmazonFinancialEventGroupTableMap::FINANCIALEVENTGROUPID)) {
            $modifiedColumns[':p' . $index++]  = 'FINANCIALEVENTGROUPID';
        }
        if ($this->isColumnModified(AmazonFinancialEventGroupTableMap::PROCESSINGSTATUS)) {
            $modifiedColumns[':p' . $index++]  = 'PROCESSINGSTATUS';
        }
        if ($this->isColumnModified(AmazonFinancialEventGroupTableMap::FUNDTRANSFERSTATUS)) {
            $modifiedColumns[':p' . $index++]  = 'FUNDTRANSFERSTATUS';
        }
        if ($this->isColumnModified(AmazonFinancialEventGroupTableMap::ORIGINALTOTAL)) {
            $modifiedColumns[':p' . $index++]  = 'ORIGINALTOTAL';
        }
        if ($this->isColumnModified(AmazonFinancialEventGroupTableMap::CONVERTEDTOTAL)) {
            $modifiedColumns[':p' . $index++]  = 'CONVERTEDTOTAL';
        }
        if ($this->isColumnModified(AmazonFinancialEventGroupTableMap::FUNDTRANSFERDATE)) {
            $modifiedColumns[':p' . $index++]  = 'FUNDTRANSFERDATE';
        }
        if ($this->isColumnModified(AmazonFinancialEventGroupTableMap::TRACEID)) {
            $modifiedColumns[':p' . $index++]  = 'TRACEID';
        }
        if ($this->isColumnModified(AmazonFinancialEventGroupTableMap::ACCOUNTTAIL)) {
            $modifiedColumns[':p' . $index++]  = 'ACCOUNTTAIL';
        }
        if ($this->isColumnModified(AmazonFinancialEventGroupTableMap::BEGINNINGBALANCE)) {
            $modifiedColumns[':p' . $index++]  = 'BEGINNINGBALANCE';
        }
        if ($this->isColumnModified(AmazonFinancialEventGroupTableMap::FINANCIALEVENTGROUPSTART)) {
            $modifiedColumns[':p' . $index++]  = 'FINANCIALEVENTGROUPSTART';
        }
        if ($this->isColumnModified(AmazonFinancialEventGroupTableMap::FINANCIALEVENTGROUPEND)) {
            $modifiedColumns[':p' . $index++]  = 'FINANCIALEVENTGROUPEND';
        }

        $sql = sprintf(
            'INSERT INTO amazon_financial_event_group (%s) VALUES (%s)',
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
                    case 'FINANCIALEVENTGROUPID':                        
                        $stmt->bindValue($identifier, $this->financialeventgroupid, PDO::PARAM_STR);
                        break;
                    case 'PROCESSINGSTATUS':                        
                        $stmt->bindValue($identifier, $this->processingstatus, PDO::PARAM_STR);
                        break;
                    case 'FUNDTRANSFERSTATUS':                        
                        $stmt->bindValue($identifier, $this->fundtransferstatus, PDO::PARAM_STR);
                        break;
                    case 'ORIGINALTOTAL':                        
                        $stmt->bindValue($identifier, $this->originaltotal, PDO::PARAM_STR);
                        break;
                    case 'CONVERTEDTOTAL':                        
                        $stmt->bindValue($identifier, $this->convertedtotal, PDO::PARAM_STR);
                        break;
                    case 'FUNDTRANSFERDATE':                        
                        $stmt->bindValue($identifier, $this->fundtransferdate ? $this->fundtransferdate->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                    case 'TRACEID':                        
                        $stmt->bindValue($identifier, $this->traceid, PDO::PARAM_STR);
                        break;
                    case 'ACCOUNTTAIL':                        
                        $stmt->bindValue($identifier, $this->accounttail, PDO::PARAM_STR);
                        break;
                    case 'BEGINNINGBALANCE':                        
                        $stmt->bindValue($identifier, $this->beginningbalance, PDO::PARAM_STR);
                        break;
                    case 'FINANCIALEVENTGROUPSTART':                        
                        $stmt->bindValue($identifier, $this->financialeventgroupstart ? $this->financialeventgroupstart->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                    case 'FINANCIALEVENTGROUPEND':                        
                        $stmt->bindValue($identifier, $this->financialeventgroupend ? $this->financialeventgroupend->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
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
        $pos = AmazonFinancialEventGroupTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getFinancialEventGroupId();
                break;
            case 2:
                return $this->getProcessingStatus();
                break;
            case 3:
                return $this->getFundTransferStatus();
                break;
            case 4:
                return $this->getOriginalTotal();
                break;
            case 5:
                return $this->getConvertedTotal();
                break;
            case 6:
                return $this->getFundTransferDate();
                break;
            case 7:
                return $this->getTraceId();
                break;
            case 8:
                return $this->getAccountTail();
                break;
            case 9:
                return $this->getBeginningBalance();
                break;
            case 10:
                return $this->getFinancialEventGroupStart();
                break;
            case 11:
                return $this->getFinancialEventGroupEnd();
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
        if (isset($alreadyDumpedObjects['AmazonFinancialEventGroup'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['AmazonFinancialEventGroup'][$this->getPrimaryKey()] = true;
        $keys = AmazonFinancialEventGroupTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getFinancialEventGroupId(),
            $keys[2] => $this->getProcessingStatus(),
            $keys[3] => $this->getFundTransferStatus(),
            $keys[4] => $this->getOriginalTotal(),
            $keys[5] => $this->getConvertedTotal(),
            $keys[6] => $this->getFundTransferDate(),
            $keys[7] => $this->getTraceId(),
            $keys[8] => $this->getAccountTail(),
            $keys[9] => $this->getBeginningBalance(),
            $keys[10] => $this->getFinancialEventGroupStart(),
            $keys[11] => $this->getFinancialEventGroupEnd(),
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
        $pos = AmazonFinancialEventGroupTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

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
                $this->setFinancialEventGroupId($value);
                break;
            case 2:
                $this->setProcessingStatus($value);
                break;
            case 3:
                $this->setFundTransferStatus($value);
                break;
            case 4:
                $this->setOriginalTotal($value);
                break;
            case 5:
                $this->setConvertedTotal($value);
                break;
            case 6:
                $this->setFundTransferDate($value);
                break;
            case 7:
                $this->setTraceId($value);
                break;
            case 8:
                $this->setAccountTail($value);
                break;
            case 9:
                $this->setBeginningBalance($value);
                break;
            case 10:
                $this->setFinancialEventGroupStart($value);
                break;
            case 11:
                $this->setFinancialEventGroupEnd($value);
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
        $keys = AmazonFinancialEventGroupTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setFinancialEventGroupId($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setProcessingStatus($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setFundTransferStatus($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setOriginalTotal($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setConvertedTotal($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setFundTransferDate($arr[$keys[6]]);
        if (array_key_exists($keys[7], $arr)) $this->setTraceId($arr[$keys[7]]);
        if (array_key_exists($keys[8], $arr)) $this->setAccountTail($arr[$keys[8]]);
        if (array_key_exists($keys[9], $arr)) $this->setBeginningBalance($arr[$keys[9]]);
        if (array_key_exists($keys[10], $arr)) $this->setFinancialEventGroupStart($arr[$keys[10]]);
        if (array_key_exists($keys[11], $arr)) $this->setFinancialEventGroupEnd($arr[$keys[11]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(AmazonFinancialEventGroupTableMap::DATABASE_NAME);

        if ($this->isColumnModified(AmazonFinancialEventGroupTableMap::ID)) $criteria->add(AmazonFinancialEventGroupTableMap::ID, $this->id);
        if ($this->isColumnModified(AmazonFinancialEventGroupTableMap::FINANCIALEVENTGROUPID)) $criteria->add(AmazonFinancialEventGroupTableMap::FINANCIALEVENTGROUPID, $this->financialeventgroupid);
        if ($this->isColumnModified(AmazonFinancialEventGroupTableMap::PROCESSINGSTATUS)) $criteria->add(AmazonFinancialEventGroupTableMap::PROCESSINGSTATUS, $this->processingstatus);
        if ($this->isColumnModified(AmazonFinancialEventGroupTableMap::FUNDTRANSFERSTATUS)) $criteria->add(AmazonFinancialEventGroupTableMap::FUNDTRANSFERSTATUS, $this->fundtransferstatus);
        if ($this->isColumnModified(AmazonFinancialEventGroupTableMap::ORIGINALTOTAL)) $criteria->add(AmazonFinancialEventGroupTableMap::ORIGINALTOTAL, $this->originaltotal);
        if ($this->isColumnModified(AmazonFinancialEventGroupTableMap::CONVERTEDTOTAL)) $criteria->add(AmazonFinancialEventGroupTableMap::CONVERTEDTOTAL, $this->convertedtotal);
        if ($this->isColumnModified(AmazonFinancialEventGroupTableMap::FUNDTRANSFERDATE)) $criteria->add(AmazonFinancialEventGroupTableMap::FUNDTRANSFERDATE, $this->fundtransferdate);
        if ($this->isColumnModified(AmazonFinancialEventGroupTableMap::TRACEID)) $criteria->add(AmazonFinancialEventGroupTableMap::TRACEID, $this->traceid);
        if ($this->isColumnModified(AmazonFinancialEventGroupTableMap::ACCOUNTTAIL)) $criteria->add(AmazonFinancialEventGroupTableMap::ACCOUNTTAIL, $this->accounttail);
        if ($this->isColumnModified(AmazonFinancialEventGroupTableMap::BEGINNINGBALANCE)) $criteria->add(AmazonFinancialEventGroupTableMap::BEGINNINGBALANCE, $this->beginningbalance);
        if ($this->isColumnModified(AmazonFinancialEventGroupTableMap::FINANCIALEVENTGROUPSTART)) $criteria->add(AmazonFinancialEventGroupTableMap::FINANCIALEVENTGROUPSTART, $this->financialeventgroupstart);
        if ($this->isColumnModified(AmazonFinancialEventGroupTableMap::FINANCIALEVENTGROUPEND)) $criteria->add(AmazonFinancialEventGroupTableMap::FINANCIALEVENTGROUPEND, $this->financialeventgroupend);

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
        $criteria = new Criteria(AmazonFinancialEventGroupTableMap::DATABASE_NAME);
        $criteria->add(AmazonFinancialEventGroupTableMap::ID, $this->id);

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
     * @param      object $copyObj An object of \AmazonIntegration\Model\AmazonFinancialEventGroup (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setFinancialEventGroupId($this->getFinancialEventGroupId());
        $copyObj->setProcessingStatus($this->getProcessingStatus());
        $copyObj->setFundTransferStatus($this->getFundTransferStatus());
        $copyObj->setOriginalTotal($this->getOriginalTotal());
        $copyObj->setConvertedTotal($this->getConvertedTotal());
        $copyObj->setFundTransferDate($this->getFundTransferDate());
        $copyObj->setTraceId($this->getTraceId());
        $copyObj->setAccountTail($this->getAccountTail());
        $copyObj->setBeginningBalance($this->getBeginningBalance());
        $copyObj->setFinancialEventGroupStart($this->getFinancialEventGroupStart());
        $copyObj->setFinancialEventGroupEnd($this->getFinancialEventGroupEnd());
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
     * @return                 \AmazonIntegration\Model\AmazonFinancialEventGroup Clone of current object.
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
        $this->financialeventgroupid = null;
        $this->processingstatus = null;
        $this->fundtransferstatus = null;
        $this->originaltotal = null;
        $this->convertedtotal = null;
        $this->fundtransferdate = null;
        $this->traceid = null;
        $this->accounttail = null;
        $this->beginningbalance = null;
        $this->financialeventgroupstart = null;
        $this->financialeventgroupend = null;
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
        return (string) $this->exportTo(AmazonFinancialEventGroupTableMap::DEFAULT_STRING_FORMAT);
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
