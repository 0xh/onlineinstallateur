<?php

namespace Base;

use \CrawlerProductBase as ChildCrawlerProductBase;
use \CrawlerProductBaseQuery as ChildCrawlerProductBaseQuery;
use \CrawlerProductBaseVersion as ChildCrawlerProductBaseVersion;
use \CrawlerProductBaseVersionQuery as ChildCrawlerProductBaseVersionQuery;
use \CrawlerProductListing as ChildCrawlerProductListing;
use \CrawlerProductListingQuery as ChildCrawlerProductListingQuery;
use \CrawlerProductListingVersionQuery as ChildCrawlerProductListingVersionQuery;
use \DateTime;
use \Exception;
use \PDO;
use Map\CrawlerProductBaseTableMap;
use Map\CrawlerProductBaseVersionTableMap;
use Map\CrawlerProductListingVersionTableMap;
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
use Thelia\Model\Product as ChildProduct;
use Thelia\Model\ProductQuery;
use Thelia\Model\ProductVersionQuery;

abstract class CrawlerProductBase implements ActiveRecordInterface 
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\CrawlerProductBaseTableMap';


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
     * The value for the product_id field.
     * @var        int
     */
    protected $product_id;

    /**
     * The value for the active field.
     * @var        int
     */
    protected $active;

    /**
     * The value for the action_required field.
     * @var        int
     */
    protected $action_required;

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
     * The value for the version_created_by field.
     * @var        string
     */
    protected $version_created_by;

    /**
     * @var        Product
     */
    protected $aProduct;

    /**
     * @var        ObjectCollection|ChildCrawlerProductListing[] Collection to store aggregation of ChildCrawlerProductListing objects.
     */
    protected $collCrawlerProductListings;
    protected $collCrawlerProductListingsPartial;

    /**
     * @var        ObjectCollection|ChildCrawlerProductBaseVersion[] Collection to store aggregation of ChildCrawlerProductBaseVersion objects.
     */
    protected $collCrawlerProductBaseVersions;
    protected $collCrawlerProductBaseVersionsPartial;

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
    protected $crawlerProductListingsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection
     */
    protected $crawlerProductBaseVersionsScheduledForDeletion = null;

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
     * Initializes internal state of Base\CrawlerProductBase object.
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
     * Compares this with another <code>CrawlerProductBase</code> instance.  If
     * <code>obj</code> is an instance of <code>CrawlerProductBase</code>, delegates to
     * <code>equals(CrawlerProductBase)</code>.  Otherwise, returns <code>false</code>.
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
     * @return CrawlerProductBase The current object, for fluid interface
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
     * @return CrawlerProductBase The current object, for fluid interface
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
     * Get the [product_id] column value.
     * 
     * @return   int
     */
    public function getProductId()
    {

        return $this->product_id;
    }

    /**
     * Get the [active] column value.
     * 
     * @return   int
     */
    public function getActive()
    {

        return $this->active;
    }

    /**
     * Get the [action_required] column value.
     * 
     * @return   int
     */
    public function getActionRequired()
    {

        return $this->action_required;
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
     * Get the [version_created_by] column value.
     * 
     * @return   string
     */
    public function getVersionCreatedBy()
    {

        return $this->version_created_by;
    }

    /**
     * Set the value of [id] column.
     * 
     * @param      int $v new value
     * @return   \CrawlerProductBase The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[CrawlerProductBaseTableMap::ID] = true;
        }


        return $this;
    } // setId()

    /**
     * Set the value of [product_id] column.
     * 
     * @param      int $v new value
     * @return   \CrawlerProductBase The current object (for fluent API support)
     */
    public function setProductId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->product_id !== $v) {
            $this->product_id = $v;
            $this->modifiedColumns[CrawlerProductBaseTableMap::PRODUCT_ID] = true;
        }

        if ($this->aProduct !== null && $this->aProduct->getId() !== $v) {
            $this->aProduct = null;
        }


        return $this;
    } // setProductId()

    /**
     * Set the value of [active] column.
     * 
     * @param      int $v new value
     * @return   \CrawlerProductBase The current object (for fluent API support)
     */
    public function setActive($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->active !== $v) {
            $this->active = $v;
            $this->modifiedColumns[CrawlerProductBaseTableMap::ACTIVE] = true;
        }


        return $this;
    } // setActive()

    /**
     * Set the value of [action_required] column.
     * 
     * @param      int $v new value
     * @return   \CrawlerProductBase The current object (for fluent API support)
     */
    public function setActionRequired($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->action_required !== $v) {
            $this->action_required = $v;
            $this->modifiedColumns[CrawlerProductBaseTableMap::ACTION_REQUIRED] = true;
        }


        return $this;
    } // setActionRequired()

    /**
     * Sets the value of [created_at] column to a normalized version of the date/time value specified.
     * 
     * @param      mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return   \CrawlerProductBase The current object (for fluent API support)
     */
    public function setCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->created_at !== null || $dt !== null) {
            if ($dt !== $this->created_at) {
                $this->created_at = $dt;
                $this->modifiedColumns[CrawlerProductBaseTableMap::CREATED_AT] = true;
            }
        } // if either are not null


        return $this;
    } // setCreatedAt()

    /**
     * Sets the value of [updated_at] column to a normalized version of the date/time value specified.
     * 
     * @param      mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return   \CrawlerProductBase The current object (for fluent API support)
     */
    public function setUpdatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->updated_at !== null || $dt !== null) {
            if ($dt !== $this->updated_at) {
                $this->updated_at = $dt;
                $this->modifiedColumns[CrawlerProductBaseTableMap::UPDATED_AT] = true;
            }
        } // if either are not null


        return $this;
    } // setUpdatedAt()

    /**
     * Set the value of [version] column.
     * 
     * @param      int $v new value
     * @return   \CrawlerProductBase The current object (for fluent API support)
     */
    public function setVersion($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->version !== $v) {
            $this->version = $v;
            $this->modifiedColumns[CrawlerProductBaseTableMap::VERSION] = true;
        }


        return $this;
    } // setVersion()

    /**
     * Set the value of [version_created_by] column.
     * 
     * @param      string $v new value
     * @return   \CrawlerProductBase The current object (for fluent API support)
     */
    public function setVersionCreatedBy($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->version_created_by !== $v) {
            $this->version_created_by = $v;
            $this->modifiedColumns[CrawlerProductBaseTableMap::VERSION_CREATED_BY] = true;
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


            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : CrawlerProductBaseTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : CrawlerProductBaseTableMap::translateFieldName('ProductId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->product_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : CrawlerProductBaseTableMap::translateFieldName('Active', TableMap::TYPE_PHPNAME, $indexType)];
            $this->active = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : CrawlerProductBaseTableMap::translateFieldName('ActionRequired', TableMap::TYPE_PHPNAME, $indexType)];
            $this->action_required = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : CrawlerProductBaseTableMap::translateFieldName('CreatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->created_at = (null !== $col) ? PropelDateTime::newInstance($col, null, '\DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : CrawlerProductBaseTableMap::translateFieldName('UpdatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->updated_at = (null !== $col) ? PropelDateTime::newInstance($col, null, '\DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : CrawlerProductBaseTableMap::translateFieldName('Version', TableMap::TYPE_PHPNAME, $indexType)];
            $this->version = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : CrawlerProductBaseTableMap::translateFieldName('VersionCreatedBy', TableMap::TYPE_PHPNAME, $indexType)];
            $this->version_created_by = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 8; // 8 = CrawlerProductBaseTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating \CrawlerProductBase object", 0, $e);
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
        if ($this->aProduct !== null && $this->product_id !== $this->aProduct->getId()) {
            $this->aProduct = null;
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
            $con = Propel::getServiceContainer()->getReadConnection(CrawlerProductBaseTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildCrawlerProductBaseQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aProduct = null;
            $this->collCrawlerProductListings = null;

            $this->collCrawlerProductBaseVersions = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see CrawlerProductBase::setDeleted()
     * @see CrawlerProductBase::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(CrawlerProductBaseTableMap::DATABASE_NAME);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = ChildCrawlerProductBaseQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(CrawlerProductBaseTableMap::DATABASE_NAME);
        }

        $con->beginTransaction();
        $isInsert = $this->isNew();
        try {
            $ret = $this->preSave($con);
            // versionable behavior
            if ($this->isVersioningNecessary()) {
                $this->setVersion($this->isNew() ? 1 : $this->getLastVersionNumber($con) + 1);
                $createVersion = true; // for postSave hook
            }
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
                // timestampable behavior
                if (!$this->isColumnModified(CrawlerProductBaseTableMap::CREATED_AT)) {
                    $this->setCreatedAt(time());
                }
                if (!$this->isColumnModified(CrawlerProductBaseTableMap::UPDATED_AT)) {
                    $this->setUpdatedAt(time());
                }
            } else {
                $ret = $ret && $this->preUpdate($con);
                // timestampable behavior
                if ($this->isModified() && !$this->isColumnModified(CrawlerProductBaseTableMap::UPDATED_AT)) {
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
                CrawlerProductBaseTableMap::addInstanceToPool($this);
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

            if ($this->aProduct !== null) {
                if ($this->aProduct->isModified() || $this->aProduct->isNew()) {
                    $affectedRows += $this->aProduct->save($con);
                }
                $this->setProduct($this->aProduct);
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

            if ($this->crawlerProductListingsScheduledForDeletion !== null) {
                if (!$this->crawlerProductListingsScheduledForDeletion->isEmpty()) {
                    \CrawlerProductListingQuery::create()
                        ->filterByPrimaryKeys($this->crawlerProductListingsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->crawlerProductListingsScheduledForDeletion = null;
                }
            }

                if ($this->collCrawlerProductListings !== null) {
            foreach ($this->collCrawlerProductListings as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->crawlerProductBaseVersionsScheduledForDeletion !== null) {
                if (!$this->crawlerProductBaseVersionsScheduledForDeletion->isEmpty()) {
                    \CrawlerProductBaseVersionQuery::create()
                        ->filterByPrimaryKeys($this->crawlerProductBaseVersionsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->crawlerProductBaseVersionsScheduledForDeletion = null;
                }
            }

                if ($this->collCrawlerProductBaseVersions !== null) {
            foreach ($this->collCrawlerProductBaseVersions as $referrerFK) {
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

        $this->modifiedColumns[CrawlerProductBaseTableMap::ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . CrawlerProductBaseTableMap::ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(CrawlerProductBaseTableMap::ID)) {
            $modifiedColumns[':p' . $index++]  = 'ID';
        }
        if ($this->isColumnModified(CrawlerProductBaseTableMap::PRODUCT_ID)) {
            $modifiedColumns[':p' . $index++]  = 'PRODUCT_ID';
        }
        if ($this->isColumnModified(CrawlerProductBaseTableMap::ACTIVE)) {
            $modifiedColumns[':p' . $index++]  = 'ACTIVE';
        }
        if ($this->isColumnModified(CrawlerProductBaseTableMap::ACTION_REQUIRED)) {
            $modifiedColumns[':p' . $index++]  = 'ACTION_REQUIRED';
        }
        if ($this->isColumnModified(CrawlerProductBaseTableMap::CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'CREATED_AT';
        }
        if ($this->isColumnModified(CrawlerProductBaseTableMap::UPDATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'UPDATED_AT';
        }
        if ($this->isColumnModified(CrawlerProductBaseTableMap::VERSION)) {
            $modifiedColumns[':p' . $index++]  = 'VERSION';
        }
        if ($this->isColumnModified(CrawlerProductBaseTableMap::VERSION_CREATED_BY)) {
            $modifiedColumns[':p' . $index++]  = 'VERSION_CREATED_BY';
        }

        $sql = sprintf(
            'INSERT INTO crawler_product_base (%s) VALUES (%s)',
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
                    case 'PRODUCT_ID':                        
                        $stmt->bindValue($identifier, $this->product_id, PDO::PARAM_INT);
                        break;
                    case 'ACTIVE':                        
                        $stmt->bindValue($identifier, $this->active, PDO::PARAM_INT);
                        break;
                    case 'ACTION_REQUIRED':                        
                        $stmt->bindValue($identifier, $this->action_required, PDO::PARAM_INT);
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
        $pos = CrawlerProductBaseTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getProductId();
                break;
            case 2:
                return $this->getActive();
                break;
            case 3:
                return $this->getActionRequired();
                break;
            case 4:
                return $this->getCreatedAt();
                break;
            case 5:
                return $this->getUpdatedAt();
                break;
            case 6:
                return $this->getVersion();
                break;
            case 7:
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
        if (isset($alreadyDumpedObjects['CrawlerProductBase'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['CrawlerProductBase'][$this->getPrimaryKey()] = true;
        $keys = CrawlerProductBaseTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getProductId(),
            $keys[2] => $this->getActive(),
            $keys[3] => $this->getActionRequired(),
            $keys[4] => $this->getCreatedAt(),
            $keys[5] => $this->getUpdatedAt(),
            $keys[6] => $this->getVersion(),
            $keys[7] => $this->getVersionCreatedBy(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }
        
        if ($includeForeignObjects) {
            if (null !== $this->aProduct) {
                $result['Product'] = $this->aProduct->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collCrawlerProductListings) {
                $result['CrawlerProductListings'] = $this->collCrawlerProductListings->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collCrawlerProductBaseVersions) {
                $result['CrawlerProductBaseVersions'] = $this->collCrawlerProductBaseVersions->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
        $pos = CrawlerProductBaseTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

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
                $this->setProductId($value);
                break;
            case 2:
                $this->setActive($value);
                break;
            case 3:
                $this->setActionRequired($value);
                break;
            case 4:
                $this->setCreatedAt($value);
                break;
            case 5:
                $this->setUpdatedAt($value);
                break;
            case 6:
                $this->setVersion($value);
                break;
            case 7:
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
        $keys = CrawlerProductBaseTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setProductId($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setActive($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setActionRequired($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setCreatedAt($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setUpdatedAt($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setVersion($arr[$keys[6]]);
        if (array_key_exists($keys[7], $arr)) $this->setVersionCreatedBy($arr[$keys[7]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(CrawlerProductBaseTableMap::DATABASE_NAME);

        if ($this->isColumnModified(CrawlerProductBaseTableMap::ID)) $criteria->add(CrawlerProductBaseTableMap::ID, $this->id);
        if ($this->isColumnModified(CrawlerProductBaseTableMap::PRODUCT_ID)) $criteria->add(CrawlerProductBaseTableMap::PRODUCT_ID, $this->product_id);
        if ($this->isColumnModified(CrawlerProductBaseTableMap::ACTIVE)) $criteria->add(CrawlerProductBaseTableMap::ACTIVE, $this->active);
        if ($this->isColumnModified(CrawlerProductBaseTableMap::ACTION_REQUIRED)) $criteria->add(CrawlerProductBaseTableMap::ACTION_REQUIRED, $this->action_required);
        if ($this->isColumnModified(CrawlerProductBaseTableMap::CREATED_AT)) $criteria->add(CrawlerProductBaseTableMap::CREATED_AT, $this->created_at);
        if ($this->isColumnModified(CrawlerProductBaseTableMap::UPDATED_AT)) $criteria->add(CrawlerProductBaseTableMap::UPDATED_AT, $this->updated_at);
        if ($this->isColumnModified(CrawlerProductBaseTableMap::VERSION)) $criteria->add(CrawlerProductBaseTableMap::VERSION, $this->version);
        if ($this->isColumnModified(CrawlerProductBaseTableMap::VERSION_CREATED_BY)) $criteria->add(CrawlerProductBaseTableMap::VERSION_CREATED_BY, $this->version_created_by);

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
        $criteria = new Criteria(CrawlerProductBaseTableMap::DATABASE_NAME);
        $criteria->add(CrawlerProductBaseTableMap::ID, $this->id);

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
     * @param      object $copyObj An object of \CrawlerProductBase (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setProductId($this->getProductId());
        $copyObj->setActive($this->getActive());
        $copyObj->setActionRequired($this->getActionRequired());
        $copyObj->setCreatedAt($this->getCreatedAt());
        $copyObj->setUpdatedAt($this->getUpdatedAt());
        $copyObj->setVersion($this->getVersion());
        $copyObj->setVersionCreatedBy($this->getVersionCreatedBy());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getCrawlerProductListings() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addCrawlerProductListing($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getCrawlerProductBaseVersions() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addCrawlerProductBaseVersion($relObj->copy($deepCopy));
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
     * @return                 \CrawlerProductBase Clone of current object.
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
     * Declares an association between this object and a ChildProduct object.
     *
     * @param                  ChildProduct $v
     * @return                 \CrawlerProductBase The current object (for fluent API support)
     * @throws PropelException
     */
    public function setProduct(ChildProduct $v = null)
    {
        if ($v === null) {
            $this->setProductId(NULL);
        } else {
            $this->setProductId($v->getId());
        }

        $this->aProduct = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildProduct object, it will not be re-added.
        if ($v !== null) {
            $v->addCrawlerProductBase($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildProduct object
     *
     * @param      ConnectionInterface $con Optional Connection object.
     * @return                 ChildProduct The associated ChildProduct object.
     * @throws PropelException
     */
    public function getProduct(ConnectionInterface $con = null)
    {
        if ($this->aProduct === null && ($this->product_id !== null)) {
            $this->aProduct = ProductQuery::create()->findPk($this->product_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aProduct->addCrawlerProductBases($this);
             */
        }

        return $this->aProduct;
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
        if ('CrawlerProductListing' == $relationName) {
            return $this->initCrawlerProductListings();
        }
        if ('CrawlerProductBaseVersion' == $relationName) {
            return $this->initCrawlerProductBaseVersions();
        }
    }

    /**
     * Clears out the collCrawlerProductListings collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addCrawlerProductListings()
     */
    public function clearCrawlerProductListings()
    {
        $this->collCrawlerProductListings = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collCrawlerProductListings collection loaded partially.
     */
    public function resetPartialCrawlerProductListings($v = true)
    {
        $this->collCrawlerProductListingsPartial = $v;
    }

    /**
     * Initializes the collCrawlerProductListings collection.
     *
     * By default this just sets the collCrawlerProductListings collection to an empty array (like clearcollCrawlerProductListings());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initCrawlerProductListings($overrideExisting = true)
    {
        if (null !== $this->collCrawlerProductListings && !$overrideExisting) {
            return;
        }
        $this->collCrawlerProductListings = new ObjectCollection();
        $this->collCrawlerProductListings->setModel('\CrawlerProductListing');
    }

    /**
     * Gets an array of ChildCrawlerProductListing objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildCrawlerProductBase is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return Collection|ChildCrawlerProductListing[] List of ChildCrawlerProductListing objects
     * @throws PropelException
     */
    public function getCrawlerProductListings($criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collCrawlerProductListingsPartial && !$this->isNew();
        if (null === $this->collCrawlerProductListings || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collCrawlerProductListings) {
                // return empty collection
                $this->initCrawlerProductListings();
            } else {
                $collCrawlerProductListings = ChildCrawlerProductListingQuery::create(null, $criteria)
                    ->filterByCrawlerProductBase($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collCrawlerProductListingsPartial && count($collCrawlerProductListings)) {
                        $this->initCrawlerProductListings(false);

                        foreach ($collCrawlerProductListings as $obj) {
                            if (false == $this->collCrawlerProductListings->contains($obj)) {
                                $this->collCrawlerProductListings->append($obj);
                            }
                        }

                        $this->collCrawlerProductListingsPartial = true;
                    }

                    reset($collCrawlerProductListings);

                    return $collCrawlerProductListings;
                }

                if ($partial && $this->collCrawlerProductListings) {
                    foreach ($this->collCrawlerProductListings as $obj) {
                        if ($obj->isNew()) {
                            $collCrawlerProductListings[] = $obj;
                        }
                    }
                }

                $this->collCrawlerProductListings = $collCrawlerProductListings;
                $this->collCrawlerProductListingsPartial = false;
            }
        }

        return $this->collCrawlerProductListings;
    }

    /**
     * Sets a collection of CrawlerProductListing objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $crawlerProductListings A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return   ChildCrawlerProductBase The current object (for fluent API support)
     */
    public function setCrawlerProductListings(Collection $crawlerProductListings, ConnectionInterface $con = null)
    {
        $crawlerProductListingsToDelete = $this->getCrawlerProductListings(new Criteria(), $con)->diff($crawlerProductListings);

        
        $this->crawlerProductListingsScheduledForDeletion = $crawlerProductListingsToDelete;

        foreach ($crawlerProductListingsToDelete as $crawlerProductListingRemoved) {
            $crawlerProductListingRemoved->setCrawlerProductBase(null);
        }

        $this->collCrawlerProductListings = null;
        foreach ($crawlerProductListings as $crawlerProductListing) {
            $this->addCrawlerProductListing($crawlerProductListing);
        }

        $this->collCrawlerProductListings = $crawlerProductListings;
        $this->collCrawlerProductListingsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related CrawlerProductListing objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related CrawlerProductListing objects.
     * @throws PropelException
     */
    public function countCrawlerProductListings(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collCrawlerProductListingsPartial && !$this->isNew();
        if (null === $this->collCrawlerProductListings || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collCrawlerProductListings) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getCrawlerProductListings());
            }

            $query = ChildCrawlerProductListingQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCrawlerProductBase($this)
                ->count($con);
        }

        return count($this->collCrawlerProductListings);
    }

    /**
     * Method called to associate a ChildCrawlerProductListing object to this object
     * through the ChildCrawlerProductListing foreign key attribute.
     *
     * @param    ChildCrawlerProductListing $l ChildCrawlerProductListing
     * @return   \CrawlerProductBase The current object (for fluent API support)
     */
    public function addCrawlerProductListing(ChildCrawlerProductListing $l)
    {
        if ($this->collCrawlerProductListings === null) {
            $this->initCrawlerProductListings();
            $this->collCrawlerProductListingsPartial = true;
        }

        if (!in_array($l, $this->collCrawlerProductListings->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddCrawlerProductListing($l);
        }

        return $this;
    }

    /**
     * @param CrawlerProductListing $crawlerProductListing The crawlerProductListing object to add.
     */
    protected function doAddCrawlerProductListing($crawlerProductListing)
    {
        $this->collCrawlerProductListings[]= $crawlerProductListing;
        $crawlerProductListing->setCrawlerProductBase($this);
    }

    /**
     * @param  CrawlerProductListing $crawlerProductListing The crawlerProductListing object to remove.
     * @return ChildCrawlerProductBase The current object (for fluent API support)
     */
    public function removeCrawlerProductListing($crawlerProductListing)
    {
        if ($this->getCrawlerProductListings()->contains($crawlerProductListing)) {
            $this->collCrawlerProductListings->remove($this->collCrawlerProductListings->search($crawlerProductListing));
            if (null === $this->crawlerProductListingsScheduledForDeletion) {
                $this->crawlerProductListingsScheduledForDeletion = clone $this->collCrawlerProductListings;
                $this->crawlerProductListingsScheduledForDeletion->clear();
            }
            $this->crawlerProductListingsScheduledForDeletion[]= $crawlerProductListing;
            $crawlerProductListing->setCrawlerProductBase(null);
        }

        return $this;
    }

    /**
     * Clears out the collCrawlerProductBaseVersions collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addCrawlerProductBaseVersions()
     */
    public function clearCrawlerProductBaseVersions()
    {
        $this->collCrawlerProductBaseVersions = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collCrawlerProductBaseVersions collection loaded partially.
     */
    public function resetPartialCrawlerProductBaseVersions($v = true)
    {
        $this->collCrawlerProductBaseVersionsPartial = $v;
    }

    /**
     * Initializes the collCrawlerProductBaseVersions collection.
     *
     * By default this just sets the collCrawlerProductBaseVersions collection to an empty array (like clearcollCrawlerProductBaseVersions());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initCrawlerProductBaseVersions($overrideExisting = true)
    {
        if (null !== $this->collCrawlerProductBaseVersions && !$overrideExisting) {
            return;
        }
        $this->collCrawlerProductBaseVersions = new ObjectCollection();
        $this->collCrawlerProductBaseVersions->setModel('\CrawlerProductBaseVersion');
    }

    /**
     * Gets an array of ChildCrawlerProductBaseVersion objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildCrawlerProductBase is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return Collection|ChildCrawlerProductBaseVersion[] List of ChildCrawlerProductBaseVersion objects
     * @throws PropelException
     */
    public function getCrawlerProductBaseVersions($criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collCrawlerProductBaseVersionsPartial && !$this->isNew();
        if (null === $this->collCrawlerProductBaseVersions || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collCrawlerProductBaseVersions) {
                // return empty collection
                $this->initCrawlerProductBaseVersions();
            } else {
                $collCrawlerProductBaseVersions = ChildCrawlerProductBaseVersionQuery::create(null, $criteria)
                    ->filterByCrawlerProductBase($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collCrawlerProductBaseVersionsPartial && count($collCrawlerProductBaseVersions)) {
                        $this->initCrawlerProductBaseVersions(false);

                        foreach ($collCrawlerProductBaseVersions as $obj) {
                            if (false == $this->collCrawlerProductBaseVersions->contains($obj)) {
                                $this->collCrawlerProductBaseVersions->append($obj);
                            }
                        }

                        $this->collCrawlerProductBaseVersionsPartial = true;
                    }

                    reset($collCrawlerProductBaseVersions);

                    return $collCrawlerProductBaseVersions;
                }

                if ($partial && $this->collCrawlerProductBaseVersions) {
                    foreach ($this->collCrawlerProductBaseVersions as $obj) {
                        if ($obj->isNew()) {
                            $collCrawlerProductBaseVersions[] = $obj;
                        }
                    }
                }

                $this->collCrawlerProductBaseVersions = $collCrawlerProductBaseVersions;
                $this->collCrawlerProductBaseVersionsPartial = false;
            }
        }

        return $this->collCrawlerProductBaseVersions;
    }

    /**
     * Sets a collection of CrawlerProductBaseVersion objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $crawlerProductBaseVersions A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return   ChildCrawlerProductBase The current object (for fluent API support)
     */
    public function setCrawlerProductBaseVersions(Collection $crawlerProductBaseVersions, ConnectionInterface $con = null)
    {
        $crawlerProductBaseVersionsToDelete = $this->getCrawlerProductBaseVersions(new Criteria(), $con)->diff($crawlerProductBaseVersions);

        
        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->crawlerProductBaseVersionsScheduledForDeletion = clone $crawlerProductBaseVersionsToDelete;

        foreach ($crawlerProductBaseVersionsToDelete as $crawlerProductBaseVersionRemoved) {
            $crawlerProductBaseVersionRemoved->setCrawlerProductBase(null);
        }

        $this->collCrawlerProductBaseVersions = null;
        foreach ($crawlerProductBaseVersions as $crawlerProductBaseVersion) {
            $this->addCrawlerProductBaseVersion($crawlerProductBaseVersion);
        }

        $this->collCrawlerProductBaseVersions = $crawlerProductBaseVersions;
        $this->collCrawlerProductBaseVersionsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related CrawlerProductBaseVersion objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related CrawlerProductBaseVersion objects.
     * @throws PropelException
     */
    public function countCrawlerProductBaseVersions(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collCrawlerProductBaseVersionsPartial && !$this->isNew();
        if (null === $this->collCrawlerProductBaseVersions || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collCrawlerProductBaseVersions) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getCrawlerProductBaseVersions());
            }

            $query = ChildCrawlerProductBaseVersionQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCrawlerProductBase($this)
                ->count($con);
        }

        return count($this->collCrawlerProductBaseVersions);
    }

    /**
     * Method called to associate a ChildCrawlerProductBaseVersion object to this object
     * through the ChildCrawlerProductBaseVersion foreign key attribute.
     *
     * @param    ChildCrawlerProductBaseVersion $l ChildCrawlerProductBaseVersion
     * @return   \CrawlerProductBase The current object (for fluent API support)
     */
    public function addCrawlerProductBaseVersion(ChildCrawlerProductBaseVersion $l)
    {
        if ($this->collCrawlerProductBaseVersions === null) {
            $this->initCrawlerProductBaseVersions();
            $this->collCrawlerProductBaseVersionsPartial = true;
        }

        if (!in_array($l, $this->collCrawlerProductBaseVersions->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddCrawlerProductBaseVersion($l);
        }

        return $this;
    }

    /**
     * @param CrawlerProductBaseVersion $crawlerProductBaseVersion The crawlerProductBaseVersion object to add.
     */
    protected function doAddCrawlerProductBaseVersion($crawlerProductBaseVersion)
    {
        $this->collCrawlerProductBaseVersions[]= $crawlerProductBaseVersion;
        $crawlerProductBaseVersion->setCrawlerProductBase($this);
    }

    /**
     * @param  CrawlerProductBaseVersion $crawlerProductBaseVersion The crawlerProductBaseVersion object to remove.
     * @return ChildCrawlerProductBase The current object (for fluent API support)
     */
    public function removeCrawlerProductBaseVersion($crawlerProductBaseVersion)
    {
        if ($this->getCrawlerProductBaseVersions()->contains($crawlerProductBaseVersion)) {
            $this->collCrawlerProductBaseVersions->remove($this->collCrawlerProductBaseVersions->search($crawlerProductBaseVersion));
            if (null === $this->crawlerProductBaseVersionsScheduledForDeletion) {
                $this->crawlerProductBaseVersionsScheduledForDeletion = clone $this->collCrawlerProductBaseVersions;
                $this->crawlerProductBaseVersionsScheduledForDeletion->clear();
            }
            $this->crawlerProductBaseVersionsScheduledForDeletion[]= clone $crawlerProductBaseVersion;
            $crawlerProductBaseVersion->setCrawlerProductBase(null);
        }

        return $this;
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->id = null;
        $this->product_id = null;
        $this->active = null;
        $this->action_required = null;
        $this->created_at = null;
        $this->updated_at = null;
        $this->version = null;
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
            if ($this->collCrawlerProductListings) {
                foreach ($this->collCrawlerProductListings as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collCrawlerProductBaseVersions) {
                foreach ($this->collCrawlerProductBaseVersions as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collCrawlerProductListings = null;
        $this->collCrawlerProductBaseVersions = null;
        $this->aProduct = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(CrawlerProductBaseTableMap::DEFAULT_STRING_FORMAT);
    }

    // timestampable behavior
    
    /**
     * Mark the current object so that the update date doesn't get updated during next save
     *
     * @return     ChildCrawlerProductBase The current object (for fluent API support)
     */
    public function keepUpdateDateUnchanged()
    {
        $this->modifiedColumns[CrawlerProductBaseTableMap::UPDATED_AT] = true;
    
        return $this;
    }

    // versionable behavior
    
    /**
     * Enforce a new Version of this object upon next save.
     *
     * @return \CrawlerProductBase
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
    
        if (ChildCrawlerProductBaseQuery::isVersioningEnabled() && ($this->isNew() || $this->isModified()) || $this->isDeleted()) {
            return true;
        }
        if (null !== ($object = $this->getProduct($con)) && $object->isVersioningNecessary($con)) {
            return true;
        }
    
        // to avoid infinite loops, emulate in save
        $this->alreadyInSave = true;
        foreach ($this->getCrawlerProductListings(null, $con) as $relatedObject) {
            if ($relatedObject->isVersioningNecessary($con)) {
                $this->alreadyInSave = false;
    
                return true;
            }
        }
        $this->alreadyInSave = false;
    
    
        return false;
    }
    
    /**
     * Creates a version of the current object and saves it.
     *
     * @param   ConnectionInterface $con the connection to use
     *
     * @return  ChildCrawlerProductBaseVersion A version object
     */
    public function addVersion($con = null)
    {
        $this->enforceVersion = false;
    
        $version = new ChildCrawlerProductBaseVersion();
        $version->setId($this->getId());
        $version->setProductId($this->getProductId());
        $version->setActive($this->getActive());
        $version->setActionRequired($this->getActionRequired());
        $version->setCreatedAt($this->getCreatedAt());
        $version->setUpdatedAt($this->getUpdatedAt());
        $version->setVersion($this->getVersion());
        $version->setVersionCreatedBy($this->getVersionCreatedBy());
        $version->setCrawlerProductBase($this);
        if (($related = $this->getProduct($con)) && $related->getVersion()) {
            $version->setProductIdVersion($related->getVersion());
        }
        if ($relateds = $this->getCrawlerProductListings($con)->toKeyValue('Id', 'Version')) {
            $version->setCrawlerProductListingIds(array_keys($relateds));
            $version->setCrawlerProductListingVersions(array_values($relateds));
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
     * @return  ChildCrawlerProductBase The current object (for fluent API support)
     */
    public function toVersion($versionNumber, $con = null)
    {
        $version = $this->getOneVersion($versionNumber, $con);
        if (!$version) {
            throw new PropelException(sprintf('No ChildCrawlerProductBase object found with version %d', $version));
        }
        $this->populateFromVersion($version, $con);
    
        return $this;
    }
    
    /**
     * Sets the properties of the current object to the value they had at a specific version
     *
     * @param ChildCrawlerProductBaseVersion $version The version object to use
     * @param ConnectionInterface   $con the connection to use
     * @param array                 $loadedObjects objects that been loaded in a chain of populateFromVersion calls on referrer or fk objects.
     *
     * @return ChildCrawlerProductBase The current object (for fluent API support)
     */
    public function populateFromVersion($version, $con = null, &$loadedObjects = array())
    {
        $loadedObjects['ChildCrawlerProductBase'][$version->getId()][$version->getVersion()] = $this;
        $this->setId($version->getId());
        $this->setProductId($version->getProductId());
        $this->setActive($version->getActive());
        $this->setActionRequired($version->getActionRequired());
        $this->setCreatedAt($version->getCreatedAt());
        $this->setUpdatedAt($version->getUpdatedAt());
        $this->setVersion($version->getVersion());
        $this->setVersionCreatedBy($version->getVersionCreatedBy());
        if ($fkValue = $version->getProductId()) {
            if (isset($loadedObjects['ChildProduct']) && isset($loadedObjects['ChildProduct'][$fkValue]) && isset($loadedObjects['ChildProduct'][$fkValue][$version->getProductIdVersion()])) {
                $related = $loadedObjects['ChildProduct'][$fkValue][$version->getProductIdVersion()];
            } else {
                $related = new ChildProduct();
                $relatedVersion = ProductVersionQuery::create()
                    ->filterById($fkValue)
                    ->filterByVersion($version->getProductIdVersion())
                    ->findOne($con);
                $related->populateFromVersion($relatedVersion, $con, $loadedObjects);
                $related->setNew(false);
            }
            $this->setProduct($related);
        }
        if ($fkValues = $version->getCrawlerProductListingIds()) {
            $this->clearCrawlerProductListings();
            $fkVersions = $version->getCrawlerProductListingVersions();
            $query = ChildCrawlerProductListingVersionQuery::create();
            foreach ($fkValues as $key => $value) {
                $c1 = $query->getNewCriterion(CrawlerProductListingVersionTableMap::ID, $value);
                $c2 = $query->getNewCriterion(CrawlerProductListingVersionTableMap::VERSION, $fkVersions[$key]);
                $c1->addAnd($c2);
                $query->addOr($c1);
            }
            foreach ($query->find($con) as $relatedVersion) {
                if (isset($loadedObjects['ChildCrawlerProductListing']) && isset($loadedObjects['ChildCrawlerProductListing'][$relatedVersion->getId()]) && isset($loadedObjects['ChildCrawlerProductListing'][$relatedVersion->getId()][$relatedVersion->getVersion()])) {
                    $related = $loadedObjects['ChildCrawlerProductListing'][$relatedVersion->getId()][$relatedVersion->getVersion()];
                } else {
                    $related = new ChildCrawlerProductListing();
                    $related->populateFromVersion($relatedVersion, $con, $loadedObjects);
                    $related->setNew(false);
                }
                $this->addCrawlerProductListing($related);
                $this->collCrawlerProductListingsPartial = false;
            }
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
        $v = ChildCrawlerProductBaseVersionQuery::create()
            ->filterByCrawlerProductBase($this)
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
     * @return  ChildCrawlerProductBaseVersion A version object
     */
    public function getOneVersion($versionNumber, $con = null)
    {
        return ChildCrawlerProductBaseVersionQuery::create()
            ->filterByCrawlerProductBase($this)
            ->filterByVersion($versionNumber)
            ->findOne($con);
    }
    
    /**
     * Gets all the versions of this object, in incremental order
     *
     * @param   ConnectionInterface $con the connection to use
     *
     * @return  ObjectCollection A list of ChildCrawlerProductBaseVersion objects
     */
    public function getAllVersions($con = null)
    {
        $criteria = new Criteria();
        $criteria->addAscendingOrderByColumn(CrawlerProductBaseVersionTableMap::VERSION);
    
        return $this->getCrawlerProductBaseVersions($criteria, $con);
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
     * @return PropelCollection|array \CrawlerProductBaseVersion[] List of \CrawlerProductBaseVersion objects
     */
    public function getLastVersions($number = 10, $criteria = null, $con = null)
    {
        $criteria = ChildCrawlerProductBaseVersionQuery::create(null, $criteria);
        $criteria->addDescendingOrderByColumn(CrawlerProductBaseVersionTableMap::VERSION);
        $criteria->limit($number);
    
        return $this->getCrawlerProductBaseVersions($criteria, $con);
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
