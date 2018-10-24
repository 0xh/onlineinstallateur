<?php

namespace Carousel\Model\Base;

use \DateTime;
use \Exception;
use \PDO;
use Carousel\Model\Carousel as ChildCarousel;
use Carousel\Model\CarouselHook as ChildCarouselHook;
use Carousel\Model\CarouselHookQuery as ChildCarouselHookQuery;
use Carousel\Model\CarouselName as ChildCarouselName;
use Carousel\Model\CarouselNameQuery as ChildCarouselNameQuery;
use Carousel\Model\CarouselNameVersion as ChildCarouselNameVersion;
use Carousel\Model\CarouselNameVersionQuery as ChildCarouselNameVersionQuery;
use Carousel\Model\CarouselQuery as ChildCarouselQuery;
use Carousel\Model\CarouselVersionQuery as ChildCarouselVersionQuery;
use Carousel\Model\Map\CarouselNameTableMap;
use Carousel\Model\Map\CarouselNameVersionTableMap;
use Carousel\Model\Map\CarouselVersionTableMap;
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

abstract class CarouselName implements ActiveRecordInterface 
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Carousel\\Model\\Map\\CarouselNameTableMap';


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
     * The value for the name field.
     * @var        string
     */
    protected $name;

    /**
     * The value for the template field.
     * @var        string
     */
    protected $template;

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
     * @var        ObjectCollection|ChildCarousel[] Collection to store aggregation of ChildCarousel objects.
     */
    protected $collCarousels;
    protected $collCarouselsPartial;

    /**
     * @var        ObjectCollection|ChildCarouselHook[] Collection to store aggregation of ChildCarouselHook objects.
     */
    protected $collCarouselHooks;
    protected $collCarouselHooksPartial;

    /**
     * @var        ObjectCollection|ChildCarouselNameVersion[] Collection to store aggregation of ChildCarouselNameVersion objects.
     */
    protected $collCarouselNameVersions;
    protected $collCarouselNameVersionsPartial;

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
    protected $carouselsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection
     */
    protected $carouselHooksScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection
     */
    protected $carouselNameVersionsScheduledForDeletion = null;

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
     * Initializes internal state of Carousel\Model\Base\CarouselName object.
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
     * Compares this with another <code>CarouselName</code> instance.  If
     * <code>obj</code> is an instance of <code>CarouselName</code>, delegates to
     * <code>equals(CarouselName)</code>.  Otherwise, returns <code>false</code>.
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
     * @return CarouselName The current object, for fluid interface
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
     * @return CarouselName The current object, for fluid interface
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
     * Get the [name] column value.
     * 
     * @return   string
     */
    public function getName()
    {

        return $this->name;
    }

    /**
     * Get the [template] column value.
     * 
     * @return   string
     */
    public function getTemplate()
    {

        return $this->template;
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
     * Set the value of [id] column.
     * 
     * @param      int $v new value
     * @return   \Carousel\Model\CarouselName The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[CarouselNameTableMap::ID] = true;
        }


        return $this;
    } // setId()

    /**
     * Set the value of [name] column.
     * 
     * @param      string $v new value
     * @return   \Carousel\Model\CarouselName The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[CarouselNameTableMap::NAME] = true;
        }


        return $this;
    } // setName()

    /**
     * Set the value of [template] column.
     * 
     * @param      string $v new value
     * @return   \Carousel\Model\CarouselName The current object (for fluent API support)
     */
    public function setTemplate($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->template !== $v) {
            $this->template = $v;
            $this->modifiedColumns[CarouselNameTableMap::TEMPLATE] = true;
        }


        return $this;
    } // setTemplate()

    /**
     * Sets the value of [created_at] column to a normalized version of the date/time value specified.
     * 
     * @param      mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return   \Carousel\Model\CarouselName The current object (for fluent API support)
     */
    public function setCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->created_at !== null || $dt !== null) {
            if ($dt !== $this->created_at) {
                $this->created_at = $dt;
                $this->modifiedColumns[CarouselNameTableMap::CREATED_AT] = true;
            }
        } // if either are not null


        return $this;
    } // setCreatedAt()

    /**
     * Sets the value of [updated_at] column to a normalized version of the date/time value specified.
     * 
     * @param      mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return   \Carousel\Model\CarouselName The current object (for fluent API support)
     */
    public function setUpdatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->updated_at !== null || $dt !== null) {
            if ($dt !== $this->updated_at) {
                $this->updated_at = $dt;
                $this->modifiedColumns[CarouselNameTableMap::UPDATED_AT] = true;
            }
        } // if either are not null


        return $this;
    } // setUpdatedAt()

    /**
     * Set the value of [version] column.
     * 
     * @param      int $v new value
     * @return   \Carousel\Model\CarouselName The current object (for fluent API support)
     */
    public function setVersion($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->version !== $v) {
            $this->version = $v;
            $this->modifiedColumns[CarouselNameTableMap::VERSION] = true;
        }


        return $this;
    } // setVersion()

    /**
     * Sets the value of [version_created_at] column to a normalized version of the date/time value specified.
     * 
     * @param      mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return   \Carousel\Model\CarouselName The current object (for fluent API support)
     */
    public function setVersionCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->version_created_at !== null || $dt !== null) {
            if ($dt !== $this->version_created_at) {
                $this->version_created_at = $dt;
                $this->modifiedColumns[CarouselNameTableMap::VERSION_CREATED_AT] = true;
            }
        } // if either are not null


        return $this;
    } // setVersionCreatedAt()

    /**
     * Set the value of [version_created_by] column.
     * 
     * @param      string $v new value
     * @return   \Carousel\Model\CarouselName The current object (for fluent API support)
     */
    public function setVersionCreatedBy($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->version_created_by !== $v) {
            $this->version_created_by = $v;
            $this->modifiedColumns[CarouselNameTableMap::VERSION_CREATED_BY] = true;
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


            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : CarouselNameTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : CarouselNameTableMap::translateFieldName('Name', TableMap::TYPE_PHPNAME, $indexType)];
            $this->name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : CarouselNameTableMap::translateFieldName('Template', TableMap::TYPE_PHPNAME, $indexType)];
            $this->template = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : CarouselNameTableMap::translateFieldName('CreatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->created_at = (null !== $col) ? PropelDateTime::newInstance($col, null, '\DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : CarouselNameTableMap::translateFieldName('UpdatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->updated_at = (null !== $col) ? PropelDateTime::newInstance($col, null, '\DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : CarouselNameTableMap::translateFieldName('Version', TableMap::TYPE_PHPNAME, $indexType)];
            $this->version = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : CarouselNameTableMap::translateFieldName('VersionCreatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->version_created_at = (null !== $col) ? PropelDateTime::newInstance($col, null, '\DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : CarouselNameTableMap::translateFieldName('VersionCreatedBy', TableMap::TYPE_PHPNAME, $indexType)];
            $this->version_created_by = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 8; // 8 = CarouselNameTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating \Carousel\Model\CarouselName object", 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(CarouselNameTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildCarouselNameQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collCarousels = null;

            $this->collCarouselHooks = null;

            $this->collCarouselNameVersions = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see CarouselName::setDeleted()
     * @see CarouselName::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(CarouselNameTableMap::DATABASE_NAME);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = ChildCarouselNameQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(CarouselNameTableMap::DATABASE_NAME);
        }

        $con->beginTransaction();
        $isInsert = $this->isNew();
        try {
            $ret = $this->preSave($con);
            // versionable behavior
            if ($this->isVersioningNecessary()) {
                $this->setVersion($this->isNew() ? 1 : $this->getLastVersionNumber($con) + 1);
                if (!$this->isColumnModified(CarouselNameTableMap::VERSION_CREATED_AT)) {
                    $this->setVersionCreatedAt(time());
                }
                $createVersion = true; // for postSave hook
            }
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
                // timestampable behavior
                if (!$this->isColumnModified(CarouselNameTableMap::CREATED_AT)) {
                    $this->setCreatedAt(time());
                }
                if (!$this->isColumnModified(CarouselNameTableMap::UPDATED_AT)) {
                    $this->setUpdatedAt(time());
                }
            } else {
                $ret = $ret && $this->preUpdate($con);
                // timestampable behavior
                if ($this->isModified() && !$this->isColumnModified(CarouselNameTableMap::UPDATED_AT)) {
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
                CarouselNameTableMap::addInstanceToPool($this);
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

            if ($this->carouselsScheduledForDeletion !== null) {
                if (!$this->carouselsScheduledForDeletion->isEmpty()) {
                    \Carousel\Model\CarouselQuery::create()
                        ->filterByPrimaryKeys($this->carouselsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->carouselsScheduledForDeletion = null;
                }
            }

                if ($this->collCarousels !== null) {
            foreach ($this->collCarousels as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->carouselHooksScheduledForDeletion !== null) {
                if (!$this->carouselHooksScheduledForDeletion->isEmpty()) {
                    \Carousel\Model\CarouselHookQuery::create()
                        ->filterByPrimaryKeys($this->carouselHooksScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->carouselHooksScheduledForDeletion = null;
                }
            }

                if ($this->collCarouselHooks !== null) {
            foreach ($this->collCarouselHooks as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->carouselNameVersionsScheduledForDeletion !== null) {
                if (!$this->carouselNameVersionsScheduledForDeletion->isEmpty()) {
                    \Carousel\Model\CarouselNameVersionQuery::create()
                        ->filterByPrimaryKeys($this->carouselNameVersionsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->carouselNameVersionsScheduledForDeletion = null;
                }
            }

                if ($this->collCarouselNameVersions !== null) {
            foreach ($this->collCarouselNameVersions as $referrerFK) {
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

        $this->modifiedColumns[CarouselNameTableMap::ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . CarouselNameTableMap::ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(CarouselNameTableMap::ID)) {
            $modifiedColumns[':p' . $index++]  = 'ID';
        }
        if ($this->isColumnModified(CarouselNameTableMap::NAME)) {
            $modifiedColumns[':p' . $index++]  = 'NAME';
        }
        if ($this->isColumnModified(CarouselNameTableMap::TEMPLATE)) {
            $modifiedColumns[':p' . $index++]  = 'TEMPLATE';
        }
        if ($this->isColumnModified(CarouselNameTableMap::CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'CREATED_AT';
        }
        if ($this->isColumnModified(CarouselNameTableMap::UPDATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'UPDATED_AT';
        }
        if ($this->isColumnModified(CarouselNameTableMap::VERSION)) {
            $modifiedColumns[':p' . $index++]  = 'VERSION';
        }
        if ($this->isColumnModified(CarouselNameTableMap::VERSION_CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'VERSION_CREATED_AT';
        }
        if ($this->isColumnModified(CarouselNameTableMap::VERSION_CREATED_BY)) {
            $modifiedColumns[':p' . $index++]  = 'VERSION_CREATED_BY';
        }

        $sql = sprintf(
            'INSERT INTO carousel_name (%s) VALUES (%s)',
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
                    case 'NAME':                        
                        $stmt->bindValue($identifier, $this->name, PDO::PARAM_STR);
                        break;
                    case 'TEMPLATE':                        
                        $stmt->bindValue($identifier, $this->template, PDO::PARAM_STR);
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
        $pos = CarouselNameTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getName();
                break;
            case 2:
                return $this->getTemplate();
                break;
            case 3:
                return $this->getCreatedAt();
                break;
            case 4:
                return $this->getUpdatedAt();
                break;
            case 5:
                return $this->getVersion();
                break;
            case 6:
                return $this->getVersionCreatedAt();
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
        if (isset($alreadyDumpedObjects['CarouselName'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['CarouselName'][$this->getPrimaryKey()] = true;
        $keys = CarouselNameTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getName(),
            $keys[2] => $this->getTemplate(),
            $keys[3] => $this->getCreatedAt(),
            $keys[4] => $this->getUpdatedAt(),
            $keys[5] => $this->getVersion(),
            $keys[6] => $this->getVersionCreatedAt(),
            $keys[7] => $this->getVersionCreatedBy(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }
        
        if ($includeForeignObjects) {
            if (null !== $this->collCarousels) {
                $result['Carousels'] = $this->collCarousels->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collCarouselHooks) {
                $result['CarouselHooks'] = $this->collCarouselHooks->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collCarouselNameVersions) {
                $result['CarouselNameVersions'] = $this->collCarouselNameVersions->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
        $pos = CarouselNameTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

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
                $this->setName($value);
                break;
            case 2:
                $this->setTemplate($value);
                break;
            case 3:
                $this->setCreatedAt($value);
                break;
            case 4:
                $this->setUpdatedAt($value);
                break;
            case 5:
                $this->setVersion($value);
                break;
            case 6:
                $this->setVersionCreatedAt($value);
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
        $keys = CarouselNameTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setName($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setTemplate($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setCreatedAt($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setUpdatedAt($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setVersion($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setVersionCreatedAt($arr[$keys[6]]);
        if (array_key_exists($keys[7], $arr)) $this->setVersionCreatedBy($arr[$keys[7]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(CarouselNameTableMap::DATABASE_NAME);

        if ($this->isColumnModified(CarouselNameTableMap::ID)) $criteria->add(CarouselNameTableMap::ID, $this->id);
        if ($this->isColumnModified(CarouselNameTableMap::NAME)) $criteria->add(CarouselNameTableMap::NAME, $this->name);
        if ($this->isColumnModified(CarouselNameTableMap::TEMPLATE)) $criteria->add(CarouselNameTableMap::TEMPLATE, $this->template);
        if ($this->isColumnModified(CarouselNameTableMap::CREATED_AT)) $criteria->add(CarouselNameTableMap::CREATED_AT, $this->created_at);
        if ($this->isColumnModified(CarouselNameTableMap::UPDATED_AT)) $criteria->add(CarouselNameTableMap::UPDATED_AT, $this->updated_at);
        if ($this->isColumnModified(CarouselNameTableMap::VERSION)) $criteria->add(CarouselNameTableMap::VERSION, $this->version);
        if ($this->isColumnModified(CarouselNameTableMap::VERSION_CREATED_AT)) $criteria->add(CarouselNameTableMap::VERSION_CREATED_AT, $this->version_created_at);
        if ($this->isColumnModified(CarouselNameTableMap::VERSION_CREATED_BY)) $criteria->add(CarouselNameTableMap::VERSION_CREATED_BY, $this->version_created_by);

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
        $criteria = new Criteria(CarouselNameTableMap::DATABASE_NAME);
        $criteria->add(CarouselNameTableMap::ID, $this->id);

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
     * @param      object $copyObj An object of \Carousel\Model\CarouselName (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setName($this->getName());
        $copyObj->setTemplate($this->getTemplate());
        $copyObj->setCreatedAt($this->getCreatedAt());
        $copyObj->setUpdatedAt($this->getUpdatedAt());
        $copyObj->setVersion($this->getVersion());
        $copyObj->setVersionCreatedAt($this->getVersionCreatedAt());
        $copyObj->setVersionCreatedBy($this->getVersionCreatedBy());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getCarousels() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addCarousel($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getCarouselHooks() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addCarouselHook($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getCarouselNameVersions() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addCarouselNameVersion($relObj->copy($deepCopy));
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
     * @return                 \Carousel\Model\CarouselName Clone of current object.
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
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param      string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('Carousel' == $relationName) {
            return $this->initCarousels();
        }
        if ('CarouselHook' == $relationName) {
            return $this->initCarouselHooks();
        }
        if ('CarouselNameVersion' == $relationName) {
            return $this->initCarouselNameVersions();
        }
    }

    /**
     * Clears out the collCarousels collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addCarousels()
     */
    public function clearCarousels()
    {
        $this->collCarousels = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collCarousels collection loaded partially.
     */
    public function resetPartialCarousels($v = true)
    {
        $this->collCarouselsPartial = $v;
    }

    /**
     * Initializes the collCarousels collection.
     *
     * By default this just sets the collCarousels collection to an empty array (like clearcollCarousels());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initCarousels($overrideExisting = true)
    {
        if (null !== $this->collCarousels && !$overrideExisting) {
            return;
        }
        $this->collCarousels = new ObjectCollection();
        $this->collCarousels->setModel('\Carousel\Model\Carousel');
    }

    /**
     * Gets an array of ChildCarousel objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildCarouselName is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return Collection|ChildCarousel[] List of ChildCarousel objects
     * @throws PropelException
     */
    public function getCarousels($criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collCarouselsPartial && !$this->isNew();
        if (null === $this->collCarousels || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collCarousels) {
                // return empty collection
                $this->initCarousels();
            } else {
                $collCarousels = ChildCarouselQuery::create(null, $criteria)
                    ->filterByCarouselName($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collCarouselsPartial && count($collCarousels)) {
                        $this->initCarousels(false);

                        foreach ($collCarousels as $obj) {
                            if (false == $this->collCarousels->contains($obj)) {
                                $this->collCarousels->append($obj);
                            }
                        }

                        $this->collCarouselsPartial = true;
                    }

                    reset($collCarousels);

                    return $collCarousels;
                }

                if ($partial && $this->collCarousels) {
                    foreach ($this->collCarousels as $obj) {
                        if ($obj->isNew()) {
                            $collCarousels[] = $obj;
                        }
                    }
                }

                $this->collCarousels = $collCarousels;
                $this->collCarouselsPartial = false;
            }
        }

        return $this->collCarousels;
    }

    /**
     * Sets a collection of Carousel objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $carousels A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return   ChildCarouselName The current object (for fluent API support)
     */
    public function setCarousels(Collection $carousels, ConnectionInterface $con = null)
    {
        $carouselsToDelete = $this->getCarousels(new Criteria(), $con)->diff($carousels);

        
        $this->carouselsScheduledForDeletion = $carouselsToDelete;

        foreach ($carouselsToDelete as $carouselRemoved) {
            $carouselRemoved->setCarouselName(null);
        }

        $this->collCarousels = null;
        foreach ($carousels as $carousel) {
            $this->addCarousel($carousel);
        }

        $this->collCarousels = $carousels;
        $this->collCarouselsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Carousel objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Carousel objects.
     * @throws PropelException
     */
    public function countCarousels(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collCarouselsPartial && !$this->isNew();
        if (null === $this->collCarousels || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collCarousels) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getCarousels());
            }

            $query = ChildCarouselQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCarouselName($this)
                ->count($con);
        }

        return count($this->collCarousels);
    }

    /**
     * Method called to associate a ChildCarousel object to this object
     * through the ChildCarousel foreign key attribute.
     *
     * @param    ChildCarousel $l ChildCarousel
     * @return   \Carousel\Model\CarouselName The current object (for fluent API support)
     */
    public function addCarousel(ChildCarousel $l)
    {
        if ($this->collCarousels === null) {
            $this->initCarousels();
            $this->collCarouselsPartial = true;
        }

        if (!in_array($l, $this->collCarousels->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddCarousel($l);
        }

        return $this;
    }

    /**
     * @param Carousel $carousel The carousel object to add.
     */
    protected function doAddCarousel($carousel)
    {
        $this->collCarousels[]= $carousel;
        $carousel->setCarouselName($this);
    }

    /**
     * @param  Carousel $carousel The carousel object to remove.
     * @return ChildCarouselName The current object (for fluent API support)
     */
    public function removeCarousel($carousel)
    {
        if ($this->getCarousels()->contains($carousel)) {
            $this->collCarousels->remove($this->collCarousels->search($carousel));
            if (null === $this->carouselsScheduledForDeletion) {
                $this->carouselsScheduledForDeletion = clone $this->collCarousels;
                $this->carouselsScheduledForDeletion->clear();
            }
            $this->carouselsScheduledForDeletion[]= clone $carousel;
            $carousel->setCarouselName(null);
        }

        return $this;
    }

    /**
     * Clears out the collCarouselHooks collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addCarouselHooks()
     */
    public function clearCarouselHooks()
    {
        $this->collCarouselHooks = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collCarouselHooks collection loaded partially.
     */
    public function resetPartialCarouselHooks($v = true)
    {
        $this->collCarouselHooksPartial = $v;
    }

    /**
     * Initializes the collCarouselHooks collection.
     *
     * By default this just sets the collCarouselHooks collection to an empty array (like clearcollCarouselHooks());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initCarouselHooks($overrideExisting = true)
    {
        if (null !== $this->collCarouselHooks && !$overrideExisting) {
            return;
        }
        $this->collCarouselHooks = new ObjectCollection();
        $this->collCarouselHooks->setModel('\Carousel\Model\CarouselHook');
    }

    /**
     * Gets an array of ChildCarouselHook objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildCarouselName is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return Collection|ChildCarouselHook[] List of ChildCarouselHook objects
     * @throws PropelException
     */
    public function getCarouselHooks($criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collCarouselHooksPartial && !$this->isNew();
        if (null === $this->collCarouselHooks || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collCarouselHooks) {
                // return empty collection
                $this->initCarouselHooks();
            } else {
                $collCarouselHooks = ChildCarouselHookQuery::create(null, $criteria)
                    ->filterByCarouselName($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collCarouselHooksPartial && count($collCarouselHooks)) {
                        $this->initCarouselHooks(false);

                        foreach ($collCarouselHooks as $obj) {
                            if (false == $this->collCarouselHooks->contains($obj)) {
                                $this->collCarouselHooks->append($obj);
                            }
                        }

                        $this->collCarouselHooksPartial = true;
                    }

                    reset($collCarouselHooks);

                    return $collCarouselHooks;
                }

                if ($partial && $this->collCarouselHooks) {
                    foreach ($this->collCarouselHooks as $obj) {
                        if ($obj->isNew()) {
                            $collCarouselHooks[] = $obj;
                        }
                    }
                }

                $this->collCarouselHooks = $collCarouselHooks;
                $this->collCarouselHooksPartial = false;
            }
        }

        return $this->collCarouselHooks;
    }

    /**
     * Sets a collection of CarouselHook objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $carouselHooks A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return   ChildCarouselName The current object (for fluent API support)
     */
    public function setCarouselHooks(Collection $carouselHooks, ConnectionInterface $con = null)
    {
        $carouselHooksToDelete = $this->getCarouselHooks(new Criteria(), $con)->diff($carouselHooks);

        
        $this->carouselHooksScheduledForDeletion = $carouselHooksToDelete;

        foreach ($carouselHooksToDelete as $carouselHookRemoved) {
            $carouselHookRemoved->setCarouselName(null);
        }

        $this->collCarouselHooks = null;
        foreach ($carouselHooks as $carouselHook) {
            $this->addCarouselHook($carouselHook);
        }

        $this->collCarouselHooks = $carouselHooks;
        $this->collCarouselHooksPartial = false;

        return $this;
    }

    /**
     * Returns the number of related CarouselHook objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related CarouselHook objects.
     * @throws PropelException
     */
    public function countCarouselHooks(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collCarouselHooksPartial && !$this->isNew();
        if (null === $this->collCarouselHooks || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collCarouselHooks) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getCarouselHooks());
            }

            $query = ChildCarouselHookQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCarouselName($this)
                ->count($con);
        }

        return count($this->collCarouselHooks);
    }

    /**
     * Method called to associate a ChildCarouselHook object to this object
     * through the ChildCarouselHook foreign key attribute.
     *
     * @param    ChildCarouselHook $l ChildCarouselHook
     * @return   \Carousel\Model\CarouselName The current object (for fluent API support)
     */
    public function addCarouselHook(ChildCarouselHook $l)
    {
        if ($this->collCarouselHooks === null) {
            $this->initCarouselHooks();
            $this->collCarouselHooksPartial = true;
        }

        if (!in_array($l, $this->collCarouselHooks->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddCarouselHook($l);
        }

        return $this;
    }

    /**
     * @param CarouselHook $carouselHook The carouselHook object to add.
     */
    protected function doAddCarouselHook($carouselHook)
    {
        $this->collCarouselHooks[]= $carouselHook;
        $carouselHook->setCarouselName($this);
    }

    /**
     * @param  CarouselHook $carouselHook The carouselHook object to remove.
     * @return ChildCarouselName The current object (for fluent API support)
     */
    public function removeCarouselHook($carouselHook)
    {
        if ($this->getCarouselHooks()->contains($carouselHook)) {
            $this->collCarouselHooks->remove($this->collCarouselHooks->search($carouselHook));
            if (null === $this->carouselHooksScheduledForDeletion) {
                $this->carouselHooksScheduledForDeletion = clone $this->collCarouselHooks;
                $this->carouselHooksScheduledForDeletion->clear();
            }
            $this->carouselHooksScheduledForDeletion[]= $carouselHook;
            $carouselHook->setCarouselName(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this CarouselName is new, it will return
     * an empty collection; or if this CarouselName has previously
     * been saved, it will retrieve related CarouselHooks from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in CarouselName.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return Collection|ChildCarouselHook[] List of ChildCarouselHook objects
     */
    public function getCarouselHooksJoinHook($criteria = null, $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildCarouselHookQuery::create(null, $criteria);
        $query->joinWith('Hook', $joinBehavior);

        return $this->getCarouselHooks($query, $con);
    }

    /**
     * Clears out the collCarouselNameVersions collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addCarouselNameVersions()
     */
    public function clearCarouselNameVersions()
    {
        $this->collCarouselNameVersions = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collCarouselNameVersions collection loaded partially.
     */
    public function resetPartialCarouselNameVersions($v = true)
    {
        $this->collCarouselNameVersionsPartial = $v;
    }

    /**
     * Initializes the collCarouselNameVersions collection.
     *
     * By default this just sets the collCarouselNameVersions collection to an empty array (like clearcollCarouselNameVersions());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initCarouselNameVersions($overrideExisting = true)
    {
        if (null !== $this->collCarouselNameVersions && !$overrideExisting) {
            return;
        }
        $this->collCarouselNameVersions = new ObjectCollection();
        $this->collCarouselNameVersions->setModel('\Carousel\Model\CarouselNameVersion');
    }

    /**
     * Gets an array of ChildCarouselNameVersion objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildCarouselName is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return Collection|ChildCarouselNameVersion[] List of ChildCarouselNameVersion objects
     * @throws PropelException
     */
    public function getCarouselNameVersions($criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collCarouselNameVersionsPartial && !$this->isNew();
        if (null === $this->collCarouselNameVersions || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collCarouselNameVersions) {
                // return empty collection
                $this->initCarouselNameVersions();
            } else {
                $collCarouselNameVersions = ChildCarouselNameVersionQuery::create(null, $criteria)
                    ->filterByCarouselName($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collCarouselNameVersionsPartial && count($collCarouselNameVersions)) {
                        $this->initCarouselNameVersions(false);

                        foreach ($collCarouselNameVersions as $obj) {
                            if (false == $this->collCarouselNameVersions->contains($obj)) {
                                $this->collCarouselNameVersions->append($obj);
                            }
                        }

                        $this->collCarouselNameVersionsPartial = true;
                    }

                    reset($collCarouselNameVersions);

                    return $collCarouselNameVersions;
                }

                if ($partial && $this->collCarouselNameVersions) {
                    foreach ($this->collCarouselNameVersions as $obj) {
                        if ($obj->isNew()) {
                            $collCarouselNameVersions[] = $obj;
                        }
                    }
                }

                $this->collCarouselNameVersions = $collCarouselNameVersions;
                $this->collCarouselNameVersionsPartial = false;
            }
        }

        return $this->collCarouselNameVersions;
    }

    /**
     * Sets a collection of CarouselNameVersion objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $carouselNameVersions A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return   ChildCarouselName The current object (for fluent API support)
     */
    public function setCarouselNameVersions(Collection $carouselNameVersions, ConnectionInterface $con = null)
    {
        $carouselNameVersionsToDelete = $this->getCarouselNameVersions(new Criteria(), $con)->diff($carouselNameVersions);

        
        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->carouselNameVersionsScheduledForDeletion = clone $carouselNameVersionsToDelete;

        foreach ($carouselNameVersionsToDelete as $carouselNameVersionRemoved) {
            $carouselNameVersionRemoved->setCarouselName(null);
        }

        $this->collCarouselNameVersions = null;
        foreach ($carouselNameVersions as $carouselNameVersion) {
            $this->addCarouselNameVersion($carouselNameVersion);
        }

        $this->collCarouselNameVersions = $carouselNameVersions;
        $this->collCarouselNameVersionsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related CarouselNameVersion objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related CarouselNameVersion objects.
     * @throws PropelException
     */
    public function countCarouselNameVersions(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collCarouselNameVersionsPartial && !$this->isNew();
        if (null === $this->collCarouselNameVersions || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collCarouselNameVersions) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getCarouselNameVersions());
            }

            $query = ChildCarouselNameVersionQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCarouselName($this)
                ->count($con);
        }

        return count($this->collCarouselNameVersions);
    }

    /**
     * Method called to associate a ChildCarouselNameVersion object to this object
     * through the ChildCarouselNameVersion foreign key attribute.
     *
     * @param    ChildCarouselNameVersion $l ChildCarouselNameVersion
     * @return   \Carousel\Model\CarouselName The current object (for fluent API support)
     */
    public function addCarouselNameVersion(ChildCarouselNameVersion $l)
    {
        if ($this->collCarouselNameVersions === null) {
            $this->initCarouselNameVersions();
            $this->collCarouselNameVersionsPartial = true;
        }

        if (!in_array($l, $this->collCarouselNameVersions->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddCarouselNameVersion($l);
        }

        return $this;
    }

    /**
     * @param CarouselNameVersion $carouselNameVersion The carouselNameVersion object to add.
     */
    protected function doAddCarouselNameVersion($carouselNameVersion)
    {
        $this->collCarouselNameVersions[]= $carouselNameVersion;
        $carouselNameVersion->setCarouselName($this);
    }

    /**
     * @param  CarouselNameVersion $carouselNameVersion The carouselNameVersion object to remove.
     * @return ChildCarouselName The current object (for fluent API support)
     */
    public function removeCarouselNameVersion($carouselNameVersion)
    {
        if ($this->getCarouselNameVersions()->contains($carouselNameVersion)) {
            $this->collCarouselNameVersions->remove($this->collCarouselNameVersions->search($carouselNameVersion));
            if (null === $this->carouselNameVersionsScheduledForDeletion) {
                $this->carouselNameVersionsScheduledForDeletion = clone $this->collCarouselNameVersions;
                $this->carouselNameVersionsScheduledForDeletion->clear();
            }
            $this->carouselNameVersionsScheduledForDeletion[]= clone $carouselNameVersion;
            $carouselNameVersion->setCarouselName(null);
        }

        return $this;
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->id = null;
        $this->name = null;
        $this->template = null;
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
            if ($this->collCarousels) {
                foreach ($this->collCarousels as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collCarouselHooks) {
                foreach ($this->collCarouselHooks as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collCarouselNameVersions) {
                foreach ($this->collCarouselNameVersions as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collCarousels = null;
        $this->collCarouselHooks = null;
        $this->collCarouselNameVersions = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(CarouselNameTableMap::DEFAULT_STRING_FORMAT);
    }

    // versionable behavior
    
    /**
     * Enforce a new Version of this object upon next save.
     *
     * @return \Carousel\Model\CarouselName
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
    
        if (ChildCarouselNameQuery::isVersioningEnabled() && ($this->isNew() || $this->isModified()) || $this->isDeleted()) {
            return true;
        }
        // to avoid infinite loops, emulate in save
        $this->alreadyInSave = true;
        foreach ($this->getCarousels(null, $con) as $relatedObject) {
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
     * @return  ChildCarouselNameVersion A version object
     */
    public function addVersion($con = null)
    {
        $this->enforceVersion = false;
    
        $version = new ChildCarouselNameVersion();
        $version->setId($this->getId());
        $version->setName($this->getName());
        $version->setTemplate($this->getTemplate());
        $version->setCreatedAt($this->getCreatedAt());
        $version->setUpdatedAt($this->getUpdatedAt());
        $version->setVersion($this->getVersion());
        $version->setVersionCreatedAt($this->getVersionCreatedAt());
        $version->setVersionCreatedBy($this->getVersionCreatedBy());
        $version->setCarouselName($this);
        if ($relateds = $this->getCarousels($con)->toKeyValue('Id', 'Version')) {
            $version->setCarouselIds(array_keys($relateds));
            $version->setCarouselVersions(array_values($relateds));
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
     * @return  ChildCarouselName The current object (for fluent API support)
     */
    public function toVersion($versionNumber, $con = null)
    {
        $version = $this->getOneVersion($versionNumber, $con);
        if (!$version) {
            throw new PropelException(sprintf('No ChildCarouselName object found with version %d', $version));
        }
        $this->populateFromVersion($version, $con);
    
        return $this;
    }
    
    /**
     * Sets the properties of the current object to the value they had at a specific version
     *
     * @param ChildCarouselNameVersion $version The version object to use
     * @param ConnectionInterface   $con the connection to use
     * @param array                 $loadedObjects objects that been loaded in a chain of populateFromVersion calls on referrer or fk objects.
     *
     * @return ChildCarouselName The current object (for fluent API support)
     */
    public function populateFromVersion($version, $con = null, &$loadedObjects = array())
    {
        $loadedObjects['ChildCarouselName'][$version->getId()][$version->getVersion()] = $this;
        $this->setId($version->getId());
        $this->setName($version->getName());
        $this->setTemplate($version->getTemplate());
        $this->setCreatedAt($version->getCreatedAt());
        $this->setUpdatedAt($version->getUpdatedAt());
        $this->setVersion($version->getVersion());
        $this->setVersionCreatedAt($version->getVersionCreatedAt());
        $this->setVersionCreatedBy($version->getVersionCreatedBy());
        if ($fkValues = $version->getCarouselIds()) {
            $this->clearCarousels();
            $fkVersions = $version->getCarouselVersions();
            $query = ChildCarouselVersionQuery::create();
            foreach ($fkValues as $key => $value) {
                $c1 = $query->getNewCriterion(CarouselVersionTableMap::ID, $value);
                $c2 = $query->getNewCriterion(CarouselVersionTableMap::VERSION, $fkVersions[$key]);
                $c1->addAnd($c2);
                $query->addOr($c1);
            }
            foreach ($query->find($con) as $relatedVersion) {
                if (isset($loadedObjects['ChildCarousel']) && isset($loadedObjects['ChildCarousel'][$relatedVersion->getId()]) && isset($loadedObjects['ChildCarousel'][$relatedVersion->getId()][$relatedVersion->getVersion()])) {
                    $related = $loadedObjects['ChildCarousel'][$relatedVersion->getId()][$relatedVersion->getVersion()];
                } else {
                    $related = new ChildCarousel();
                    $related->populateFromVersion($relatedVersion, $con, $loadedObjects);
                    $related->setNew(false);
                }
                $this->addCarousel($related);
                $this->collCarouselsPartial = false;
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
        $v = ChildCarouselNameVersionQuery::create()
            ->filterByCarouselName($this)
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
     * @return  ChildCarouselNameVersion A version object
     */
    public function getOneVersion($versionNumber, $con = null)
    {
        return ChildCarouselNameVersionQuery::create()
            ->filterByCarouselName($this)
            ->filterByVersion($versionNumber)
            ->findOne($con);
    }
    
    /**
     * Gets all the versions of this object, in incremental order
     *
     * @param   ConnectionInterface $con the connection to use
     *
     * @return  ObjectCollection A list of ChildCarouselNameVersion objects
     */
    public function getAllVersions($con = null)
    {
        $criteria = new Criteria();
        $criteria->addAscendingOrderByColumn(CarouselNameVersionTableMap::VERSION);
    
        return $this->getCarouselNameVersions($criteria, $con);
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
     * @return PropelCollection|array \Carousel\Model\CarouselNameVersion[] List of \Carousel\Model\CarouselNameVersion objects
     */
    public function getLastVersions($number = 10, $criteria = null, $con = null)
    {
        $criteria = ChildCarouselNameVersionQuery::create(null, $criteria);
        $criteria->addDescendingOrderByColumn(CarouselNameVersionTableMap::VERSION);
        $criteria->limit($number);
    
        return $this->getCarouselNameVersions($criteria, $con);
    }
    // timestampable behavior
    
    /**
     * Mark the current object so that the update date doesn't get updated during next save
     *
     * @return     ChildCarouselName The current object (for fluent API support)
     */
    public function keepUpdateDateUnchanged()
    {
        $this->modifiedColumns[CarouselNameTableMap::UPDATED_AT] = true;
    
        return $this;
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
