<?php

namespace FilterConfigurator\Model\Base;

use \DateTime;
use \Exception;
use \PDO;
use FilterConfigurator\Model\Configurator as ChildConfigurator;
use FilterConfigurator\Model\ConfiguratorFeatures as ChildConfiguratorFeatures;
use FilterConfigurator\Model\ConfiguratorFeaturesQuery as ChildConfiguratorFeaturesQuery;
use FilterConfigurator\Model\ConfiguratorI18n as ChildConfiguratorI18n;
use FilterConfigurator\Model\ConfiguratorI18nQuery as ChildConfiguratorI18nQuery;
use FilterConfigurator\Model\ConfiguratorImage as ChildConfiguratorImage;
use FilterConfigurator\Model\ConfiguratorImageQuery as ChildConfiguratorImageQuery;
use FilterConfigurator\Model\ConfiguratorQuery as ChildConfiguratorQuery;
use FilterConfigurator\Model\ConfiguratorVersion as ChildConfiguratorVersion;
use FilterConfigurator\Model\ConfiguratorVersionQuery as ChildConfiguratorVersionQuery;
use FilterConfigurator\Model\Map\ConfiguratorTableMap;
use FilterConfigurator\Model\Map\ConfiguratorVersionTableMap;
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

abstract class Configurator implements ActiveRecordInterface 
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\FilterConfigurator\\Model\\Map\\ConfiguratorTableMap';


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
     * The value for the visible field.
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $visible;

    /**
     * The value for the position field.
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $position;

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
     * @var        ObjectCollection|ChildConfiguratorI18n[] Collection to store aggregation of ChildConfiguratorI18n objects.
     */
    protected $collConfiguratorI18ns;
    protected $collConfiguratorI18nsPartial;

    /**
     * @var        ObjectCollection|ChildConfiguratorImage[] Collection to store aggregation of ChildConfiguratorImage objects.
     */
    protected $collConfiguratorImages;
    protected $collConfiguratorImagesPartial;

    /**
     * @var        ObjectCollection|ChildConfiguratorFeatures[] Collection to store aggregation of ChildConfiguratorFeatures objects.
     */
    protected $collConfiguratorFeaturess;
    protected $collConfiguratorFeaturessPartial;

    /**
     * @var        ObjectCollection|ChildConfiguratorVersion[] Collection to store aggregation of ChildConfiguratorVersion objects.
     */
    protected $collConfiguratorVersions;
    protected $collConfiguratorVersionsPartial;

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
    protected $configuratorI18nsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection
     */
    protected $configuratorImagesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection
     */
    protected $configuratorFeaturessScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection
     */
    protected $configuratorVersionsScheduledForDeletion = null;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see __construct()
     */
    public function applyDefaultValues()
    {
        $this->visible = 0;
        $this->position = 0;
        $this->version = 0;
    }

    /**
     * Initializes internal state of FilterConfigurator\Model\Base\Configurator object.
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
     * Compares this with another <code>Configurator</code> instance.  If
     * <code>obj</code> is an instance of <code>Configurator</code>, delegates to
     * <code>equals(Configurator)</code>.  Otherwise, returns <code>false</code>.
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
     * @return Configurator The current object, for fluid interface
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
     * @return Configurator The current object, for fluid interface
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
     * Get the [visible] column value.
     * 
     * @return   int
     */
    public function getVisible()
    {

        return $this->visible;
    }

    /**
     * Get the [position] column value.
     * 
     * @return   int
     */
    public function getPosition()
    {

        return $this->position;
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
     * @return   \FilterConfigurator\Model\Configurator The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[ConfiguratorTableMap::ID] = true;
        }


        return $this;
    } // setId()

    /**
     * Set the value of [visible] column.
     * 
     * @param      int $v new value
     * @return   \FilterConfigurator\Model\Configurator The current object (for fluent API support)
     */
    public function setVisible($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->visible !== $v) {
            $this->visible = $v;
            $this->modifiedColumns[ConfiguratorTableMap::VISIBLE] = true;
        }


        return $this;
    } // setVisible()

    /**
     * Set the value of [position] column.
     * 
     * @param      int $v new value
     * @return   \FilterConfigurator\Model\Configurator The current object (for fluent API support)
     */
    public function setPosition($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->position !== $v) {
            $this->position = $v;
            $this->modifiedColumns[ConfiguratorTableMap::POSITION] = true;
        }


        return $this;
    } // setPosition()

    /**
     * Sets the value of [created_at] column to a normalized version of the date/time value specified.
     * 
     * @param      mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return   \FilterConfigurator\Model\Configurator The current object (for fluent API support)
     */
    public function setCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->created_at !== null || $dt !== null) {
            if ($dt !== $this->created_at) {
                $this->created_at = $dt;
                $this->modifiedColumns[ConfiguratorTableMap::CREATED_AT] = true;
            }
        } // if either are not null


        return $this;
    } // setCreatedAt()

    /**
     * Sets the value of [updated_at] column to a normalized version of the date/time value specified.
     * 
     * @param      mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return   \FilterConfigurator\Model\Configurator The current object (for fluent API support)
     */
    public function setUpdatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->updated_at !== null || $dt !== null) {
            if ($dt !== $this->updated_at) {
                $this->updated_at = $dt;
                $this->modifiedColumns[ConfiguratorTableMap::UPDATED_AT] = true;
            }
        } // if either are not null


        return $this;
    } // setUpdatedAt()

    /**
     * Set the value of [version] column.
     * 
     * @param      int $v new value
     * @return   \FilterConfigurator\Model\Configurator The current object (for fluent API support)
     */
    public function setVersion($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->version !== $v) {
            $this->version = $v;
            $this->modifiedColumns[ConfiguratorTableMap::VERSION] = true;
        }


        return $this;
    } // setVersion()

    /**
     * Sets the value of [version_created_at] column to a normalized version of the date/time value specified.
     * 
     * @param      mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return   \FilterConfigurator\Model\Configurator The current object (for fluent API support)
     */
    public function setVersionCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->version_created_at !== null || $dt !== null) {
            if ($dt !== $this->version_created_at) {
                $this->version_created_at = $dt;
                $this->modifiedColumns[ConfiguratorTableMap::VERSION_CREATED_AT] = true;
            }
        } // if either are not null


        return $this;
    } // setVersionCreatedAt()

    /**
     * Set the value of [version_created_by] column.
     * 
     * @param      string $v new value
     * @return   \FilterConfigurator\Model\Configurator The current object (for fluent API support)
     */
    public function setVersionCreatedBy($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->version_created_by !== $v) {
            $this->version_created_by = $v;
            $this->modifiedColumns[ConfiguratorTableMap::VERSION_CREATED_BY] = true;
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
            if ($this->visible !== 0) {
                return false;
            }

            if ($this->position !== 0) {
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


            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : ConfiguratorTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : ConfiguratorTableMap::translateFieldName('Visible', TableMap::TYPE_PHPNAME, $indexType)];
            $this->visible = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : ConfiguratorTableMap::translateFieldName('Position', TableMap::TYPE_PHPNAME, $indexType)];
            $this->position = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : ConfiguratorTableMap::translateFieldName('CreatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->created_at = (null !== $col) ? PropelDateTime::newInstance($col, null, '\DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : ConfiguratorTableMap::translateFieldName('UpdatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->updated_at = (null !== $col) ? PropelDateTime::newInstance($col, null, '\DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : ConfiguratorTableMap::translateFieldName('Version', TableMap::TYPE_PHPNAME, $indexType)];
            $this->version = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : ConfiguratorTableMap::translateFieldName('VersionCreatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->version_created_at = (null !== $col) ? PropelDateTime::newInstance($col, null, '\DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : ConfiguratorTableMap::translateFieldName('VersionCreatedBy', TableMap::TYPE_PHPNAME, $indexType)];
            $this->version_created_by = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 8; // 8 = ConfiguratorTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating \FilterConfigurator\Model\Configurator object", 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(ConfiguratorTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildConfiguratorQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collConfiguratorI18ns = null;

            $this->collConfiguratorImages = null;

            $this->collConfiguratorFeaturess = null;

            $this->collConfiguratorVersions = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Configurator::setDeleted()
     * @see Configurator::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(ConfiguratorTableMap::DATABASE_NAME);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = ChildConfiguratorQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(ConfiguratorTableMap::DATABASE_NAME);
        }

        $con->beginTransaction();
        $isInsert = $this->isNew();
        try {
            $ret = $this->preSave($con);
            // versionable behavior
            if ($this->isVersioningNecessary()) {
                $this->setVersion($this->isNew() ? 1 : $this->getLastVersionNumber($con) + 1);
                if (!$this->isColumnModified(ConfiguratorTableMap::VERSION_CREATED_AT)) {
                    $this->setVersionCreatedAt(time());
                }
                $createVersion = true; // for postSave hook
            }
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
                // timestampable behavior
                if (!$this->isColumnModified(ConfiguratorTableMap::CREATED_AT)) {
                    $this->setCreatedAt(time());
                }
                if (!$this->isColumnModified(ConfiguratorTableMap::UPDATED_AT)) {
                    $this->setUpdatedAt(time());
                }
            } else {
                $ret = $ret && $this->preUpdate($con);
                // timestampable behavior
                if ($this->isModified() && !$this->isColumnModified(ConfiguratorTableMap::UPDATED_AT)) {
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
                ConfiguratorTableMap::addInstanceToPool($this);
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

            if ($this->configuratorI18nsScheduledForDeletion !== null) {
                if (!$this->configuratorI18nsScheduledForDeletion->isEmpty()) {
                    \FilterConfigurator\Model\ConfiguratorI18nQuery::create()
                        ->filterByPrimaryKeys($this->configuratorI18nsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->configuratorI18nsScheduledForDeletion = null;
                }
            }

                if ($this->collConfiguratorI18ns !== null) {
            foreach ($this->collConfiguratorI18ns as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->configuratorImagesScheduledForDeletion !== null) {
                if (!$this->configuratorImagesScheduledForDeletion->isEmpty()) {
                    \FilterConfigurator\Model\ConfiguratorImageQuery::create()
                        ->filterByPrimaryKeys($this->configuratorImagesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->configuratorImagesScheduledForDeletion = null;
                }
            }

                if ($this->collConfiguratorImages !== null) {
            foreach ($this->collConfiguratorImages as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->configuratorFeaturessScheduledForDeletion !== null) {
                if (!$this->configuratorFeaturessScheduledForDeletion->isEmpty()) {
                    \FilterConfigurator\Model\ConfiguratorFeaturesQuery::create()
                        ->filterByPrimaryKeys($this->configuratorFeaturessScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->configuratorFeaturessScheduledForDeletion = null;
                }
            }

                if ($this->collConfiguratorFeaturess !== null) {
            foreach ($this->collConfiguratorFeaturess as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->configuratorVersionsScheduledForDeletion !== null) {
                if (!$this->configuratorVersionsScheduledForDeletion->isEmpty()) {
                    \FilterConfigurator\Model\ConfiguratorVersionQuery::create()
                        ->filterByPrimaryKeys($this->configuratorVersionsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->configuratorVersionsScheduledForDeletion = null;
                }
            }

                if ($this->collConfiguratorVersions !== null) {
            foreach ($this->collConfiguratorVersions as $referrerFK) {
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

        $this->modifiedColumns[ConfiguratorTableMap::ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . ConfiguratorTableMap::ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(ConfiguratorTableMap::ID)) {
            $modifiedColumns[':p' . $index++]  = 'ID';
        }
        if ($this->isColumnModified(ConfiguratorTableMap::VISIBLE)) {
            $modifiedColumns[':p' . $index++]  = 'VISIBLE';
        }
        if ($this->isColumnModified(ConfiguratorTableMap::POSITION)) {
            $modifiedColumns[':p' . $index++]  = 'POSITION';
        }
        if ($this->isColumnModified(ConfiguratorTableMap::CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'CREATED_AT';
        }
        if ($this->isColumnModified(ConfiguratorTableMap::UPDATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'UPDATED_AT';
        }
        if ($this->isColumnModified(ConfiguratorTableMap::VERSION)) {
            $modifiedColumns[':p' . $index++]  = 'VERSION';
        }
        if ($this->isColumnModified(ConfiguratorTableMap::VERSION_CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'VERSION_CREATED_AT';
        }
        if ($this->isColumnModified(ConfiguratorTableMap::VERSION_CREATED_BY)) {
            $modifiedColumns[':p' . $index++]  = 'VERSION_CREATED_BY';
        }

        $sql = sprintf(
            'INSERT INTO configurator (%s) VALUES (%s)',
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
                    case 'VISIBLE':                        
                        $stmt->bindValue($identifier, $this->visible, PDO::PARAM_INT);
                        break;
                    case 'POSITION':                        
                        $stmt->bindValue($identifier, $this->position, PDO::PARAM_INT);
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
        $pos = ConfiguratorTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getVisible();
                break;
            case 2:
                return $this->getPosition();
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
        if (isset($alreadyDumpedObjects['Configurator'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Configurator'][$this->getPrimaryKey()] = true;
        $keys = ConfiguratorTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getVisible(),
            $keys[2] => $this->getPosition(),
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
            if (null !== $this->collConfiguratorI18ns) {
                $result['ConfiguratorI18ns'] = $this->collConfiguratorI18ns->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collConfiguratorImages) {
                $result['ConfiguratorImages'] = $this->collConfiguratorImages->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collConfiguratorFeaturess) {
                $result['ConfiguratorFeaturess'] = $this->collConfiguratorFeaturess->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collConfiguratorVersions) {
                $result['ConfiguratorVersions'] = $this->collConfiguratorVersions->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
        $pos = ConfiguratorTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

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
                $this->setVisible($value);
                break;
            case 2:
                $this->setPosition($value);
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
        $keys = ConfiguratorTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setVisible($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setPosition($arr[$keys[2]]);
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
        $criteria = new Criteria(ConfiguratorTableMap::DATABASE_NAME);

        if ($this->isColumnModified(ConfiguratorTableMap::ID)) $criteria->add(ConfiguratorTableMap::ID, $this->id);
        if ($this->isColumnModified(ConfiguratorTableMap::VISIBLE)) $criteria->add(ConfiguratorTableMap::VISIBLE, $this->visible);
        if ($this->isColumnModified(ConfiguratorTableMap::POSITION)) $criteria->add(ConfiguratorTableMap::POSITION, $this->position);
        if ($this->isColumnModified(ConfiguratorTableMap::CREATED_AT)) $criteria->add(ConfiguratorTableMap::CREATED_AT, $this->created_at);
        if ($this->isColumnModified(ConfiguratorTableMap::UPDATED_AT)) $criteria->add(ConfiguratorTableMap::UPDATED_AT, $this->updated_at);
        if ($this->isColumnModified(ConfiguratorTableMap::VERSION)) $criteria->add(ConfiguratorTableMap::VERSION, $this->version);
        if ($this->isColumnModified(ConfiguratorTableMap::VERSION_CREATED_AT)) $criteria->add(ConfiguratorTableMap::VERSION_CREATED_AT, $this->version_created_at);
        if ($this->isColumnModified(ConfiguratorTableMap::VERSION_CREATED_BY)) $criteria->add(ConfiguratorTableMap::VERSION_CREATED_BY, $this->version_created_by);

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
        $criteria = new Criteria(ConfiguratorTableMap::DATABASE_NAME);
        $criteria->add(ConfiguratorTableMap::ID, $this->id);

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
     * @param      object $copyObj An object of \FilterConfigurator\Model\Configurator (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setVisible($this->getVisible());
        $copyObj->setPosition($this->getPosition());
        $copyObj->setCreatedAt($this->getCreatedAt());
        $copyObj->setUpdatedAt($this->getUpdatedAt());
        $copyObj->setVersion($this->getVersion());
        $copyObj->setVersionCreatedAt($this->getVersionCreatedAt());
        $copyObj->setVersionCreatedBy($this->getVersionCreatedBy());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getConfiguratorI18ns() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addConfiguratorI18n($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getConfiguratorImages() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addConfiguratorImage($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getConfiguratorFeaturess() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addConfiguratorFeatures($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getConfiguratorVersions() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addConfiguratorVersion($relObj->copy($deepCopy));
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
     * @return                 \FilterConfigurator\Model\Configurator Clone of current object.
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
        if ('ConfiguratorI18n' == $relationName) {
            return $this->initConfiguratorI18ns();
        }
        if ('ConfiguratorImage' == $relationName) {
            return $this->initConfiguratorImages();
        }
        if ('ConfiguratorFeatures' == $relationName) {
            return $this->initConfiguratorFeaturess();
        }
        if ('ConfiguratorVersion' == $relationName) {
            return $this->initConfiguratorVersions();
        }
    }

    /**
     * Clears out the collConfiguratorI18ns collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addConfiguratorI18ns()
     */
    public function clearConfiguratorI18ns()
    {
        $this->collConfiguratorI18ns = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collConfiguratorI18ns collection loaded partially.
     */
    public function resetPartialConfiguratorI18ns($v = true)
    {
        $this->collConfiguratorI18nsPartial = $v;
    }

    /**
     * Initializes the collConfiguratorI18ns collection.
     *
     * By default this just sets the collConfiguratorI18ns collection to an empty array (like clearcollConfiguratorI18ns());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initConfiguratorI18ns($overrideExisting = true)
    {
        if (null !== $this->collConfiguratorI18ns && !$overrideExisting) {
            return;
        }
        $this->collConfiguratorI18ns = new ObjectCollection();
        $this->collConfiguratorI18ns->setModel('\FilterConfigurator\Model\ConfiguratorI18n');
    }

    /**
     * Gets an array of ChildConfiguratorI18n objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildConfigurator is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return Collection|ChildConfiguratorI18n[] List of ChildConfiguratorI18n objects
     * @throws PropelException
     */
    public function getConfiguratorI18ns($criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collConfiguratorI18nsPartial && !$this->isNew();
        if (null === $this->collConfiguratorI18ns || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collConfiguratorI18ns) {
                // return empty collection
                $this->initConfiguratorI18ns();
            } else {
                $collConfiguratorI18ns = ChildConfiguratorI18nQuery::create(null, $criteria)
                    ->filterByConfigurator($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collConfiguratorI18nsPartial && count($collConfiguratorI18ns)) {
                        $this->initConfiguratorI18ns(false);

                        foreach ($collConfiguratorI18ns as $obj) {
                            if (false == $this->collConfiguratorI18ns->contains($obj)) {
                                $this->collConfiguratorI18ns->append($obj);
                            }
                        }

                        $this->collConfiguratorI18nsPartial = true;
                    }

                    reset($collConfiguratorI18ns);

                    return $collConfiguratorI18ns;
                }

                if ($partial && $this->collConfiguratorI18ns) {
                    foreach ($this->collConfiguratorI18ns as $obj) {
                        if ($obj->isNew()) {
                            $collConfiguratorI18ns[] = $obj;
                        }
                    }
                }

                $this->collConfiguratorI18ns = $collConfiguratorI18ns;
                $this->collConfiguratorI18nsPartial = false;
            }
        }

        return $this->collConfiguratorI18ns;
    }

    /**
     * Sets a collection of ConfiguratorI18n objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $configuratorI18ns A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return   ChildConfigurator The current object (for fluent API support)
     */
    public function setConfiguratorI18ns(Collection $configuratorI18ns, ConnectionInterface $con = null)
    {
        $configuratorI18nsToDelete = $this->getConfiguratorI18ns(new Criteria(), $con)->diff($configuratorI18ns);

        
        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->configuratorI18nsScheduledForDeletion = clone $configuratorI18nsToDelete;

        foreach ($configuratorI18nsToDelete as $configuratorI18nRemoved) {
            $configuratorI18nRemoved->setConfigurator(null);
        }

        $this->collConfiguratorI18ns = null;
        foreach ($configuratorI18ns as $configuratorI18n) {
            $this->addConfiguratorI18n($configuratorI18n);
        }

        $this->collConfiguratorI18ns = $configuratorI18ns;
        $this->collConfiguratorI18nsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related ConfiguratorI18n objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related ConfiguratorI18n objects.
     * @throws PropelException
     */
    public function countConfiguratorI18ns(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collConfiguratorI18nsPartial && !$this->isNew();
        if (null === $this->collConfiguratorI18ns || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collConfiguratorI18ns) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getConfiguratorI18ns());
            }

            $query = ChildConfiguratorI18nQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByConfigurator($this)
                ->count($con);
        }

        return count($this->collConfiguratorI18ns);
    }

    /**
     * Method called to associate a ChildConfiguratorI18n object to this object
     * through the ChildConfiguratorI18n foreign key attribute.
     *
     * @param    ChildConfiguratorI18n $l ChildConfiguratorI18n
     * @return   \FilterConfigurator\Model\Configurator The current object (for fluent API support)
     */
    public function addConfiguratorI18n(ChildConfiguratorI18n $l)
    {
        if ($this->collConfiguratorI18ns === null) {
            $this->initConfiguratorI18ns();
            $this->collConfiguratorI18nsPartial = true;
        }

        if (!in_array($l, $this->collConfiguratorI18ns->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddConfiguratorI18n($l);
        }

        return $this;
    }

    /**
     * @param ConfiguratorI18n $configuratorI18n The configuratorI18n object to add.
     */
    protected function doAddConfiguratorI18n($configuratorI18n)
    {
        $this->collConfiguratorI18ns[]= $configuratorI18n;
        $configuratorI18n->setConfigurator($this);
    }

    /**
     * @param  ConfiguratorI18n $configuratorI18n The configuratorI18n object to remove.
     * @return ChildConfigurator The current object (for fluent API support)
     */
    public function removeConfiguratorI18n($configuratorI18n)
    {
        if ($this->getConfiguratorI18ns()->contains($configuratorI18n)) {
            $this->collConfiguratorI18ns->remove($this->collConfiguratorI18ns->search($configuratorI18n));
            if (null === $this->configuratorI18nsScheduledForDeletion) {
                $this->configuratorI18nsScheduledForDeletion = clone $this->collConfiguratorI18ns;
                $this->configuratorI18nsScheduledForDeletion->clear();
            }
            $this->configuratorI18nsScheduledForDeletion[]= clone $configuratorI18n;
            $configuratorI18n->setConfigurator(null);
        }

        return $this;
    }

    /**
     * Clears out the collConfiguratorImages collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addConfiguratorImages()
     */
    public function clearConfiguratorImages()
    {
        $this->collConfiguratorImages = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collConfiguratorImages collection loaded partially.
     */
    public function resetPartialConfiguratorImages($v = true)
    {
        $this->collConfiguratorImagesPartial = $v;
    }

    /**
     * Initializes the collConfiguratorImages collection.
     *
     * By default this just sets the collConfiguratorImages collection to an empty array (like clearcollConfiguratorImages());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initConfiguratorImages($overrideExisting = true)
    {
        if (null !== $this->collConfiguratorImages && !$overrideExisting) {
            return;
        }
        $this->collConfiguratorImages = new ObjectCollection();
        $this->collConfiguratorImages->setModel('\FilterConfigurator\Model\ConfiguratorImage');
    }

    /**
     * Gets an array of ChildConfiguratorImage objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildConfigurator is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return Collection|ChildConfiguratorImage[] List of ChildConfiguratorImage objects
     * @throws PropelException
     */
    public function getConfiguratorImages($criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collConfiguratorImagesPartial && !$this->isNew();
        if (null === $this->collConfiguratorImages || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collConfiguratorImages) {
                // return empty collection
                $this->initConfiguratorImages();
            } else {
                $collConfiguratorImages = ChildConfiguratorImageQuery::create(null, $criteria)
                    ->filterByConfigurator($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collConfiguratorImagesPartial && count($collConfiguratorImages)) {
                        $this->initConfiguratorImages(false);

                        foreach ($collConfiguratorImages as $obj) {
                            if (false == $this->collConfiguratorImages->contains($obj)) {
                                $this->collConfiguratorImages->append($obj);
                            }
                        }

                        $this->collConfiguratorImagesPartial = true;
                    }

                    reset($collConfiguratorImages);

                    return $collConfiguratorImages;
                }

                if ($partial && $this->collConfiguratorImages) {
                    foreach ($this->collConfiguratorImages as $obj) {
                        if ($obj->isNew()) {
                            $collConfiguratorImages[] = $obj;
                        }
                    }
                }

                $this->collConfiguratorImages = $collConfiguratorImages;
                $this->collConfiguratorImagesPartial = false;
            }
        }

        return $this->collConfiguratorImages;
    }

    /**
     * Sets a collection of ConfiguratorImage objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $configuratorImages A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return   ChildConfigurator The current object (for fluent API support)
     */
    public function setConfiguratorImages(Collection $configuratorImages, ConnectionInterface $con = null)
    {
        $configuratorImagesToDelete = $this->getConfiguratorImages(new Criteria(), $con)->diff($configuratorImages);

        
        $this->configuratorImagesScheduledForDeletion = $configuratorImagesToDelete;

        foreach ($configuratorImagesToDelete as $configuratorImageRemoved) {
            $configuratorImageRemoved->setConfigurator(null);
        }

        $this->collConfiguratorImages = null;
        foreach ($configuratorImages as $configuratorImage) {
            $this->addConfiguratorImage($configuratorImage);
        }

        $this->collConfiguratorImages = $configuratorImages;
        $this->collConfiguratorImagesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related ConfiguratorImage objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related ConfiguratorImage objects.
     * @throws PropelException
     */
    public function countConfiguratorImages(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collConfiguratorImagesPartial && !$this->isNew();
        if (null === $this->collConfiguratorImages || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collConfiguratorImages) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getConfiguratorImages());
            }

            $query = ChildConfiguratorImageQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByConfigurator($this)
                ->count($con);
        }

        return count($this->collConfiguratorImages);
    }

    /**
     * Method called to associate a ChildConfiguratorImage object to this object
     * through the ChildConfiguratorImage foreign key attribute.
     *
     * @param    ChildConfiguratorImage $l ChildConfiguratorImage
     * @return   \FilterConfigurator\Model\Configurator The current object (for fluent API support)
     */
    public function addConfiguratorImage(ChildConfiguratorImage $l)
    {
        if ($this->collConfiguratorImages === null) {
            $this->initConfiguratorImages();
            $this->collConfiguratorImagesPartial = true;
        }

        if (!in_array($l, $this->collConfiguratorImages->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddConfiguratorImage($l);
        }

        return $this;
    }

    /**
     * @param ConfiguratorImage $configuratorImage The configuratorImage object to add.
     */
    protected function doAddConfiguratorImage($configuratorImage)
    {
        $this->collConfiguratorImages[]= $configuratorImage;
        $configuratorImage->setConfigurator($this);
    }

    /**
     * @param  ConfiguratorImage $configuratorImage The configuratorImage object to remove.
     * @return ChildConfigurator The current object (for fluent API support)
     */
    public function removeConfiguratorImage($configuratorImage)
    {
        if ($this->getConfiguratorImages()->contains($configuratorImage)) {
            $this->collConfiguratorImages->remove($this->collConfiguratorImages->search($configuratorImage));
            if (null === $this->configuratorImagesScheduledForDeletion) {
                $this->configuratorImagesScheduledForDeletion = clone $this->collConfiguratorImages;
                $this->configuratorImagesScheduledForDeletion->clear();
            }
            $this->configuratorImagesScheduledForDeletion[]= clone $configuratorImage;
            $configuratorImage->setConfigurator(null);
        }

        return $this;
    }

    /**
     * Clears out the collConfiguratorFeaturess collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addConfiguratorFeaturess()
     */
    public function clearConfiguratorFeaturess()
    {
        $this->collConfiguratorFeaturess = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collConfiguratorFeaturess collection loaded partially.
     */
    public function resetPartialConfiguratorFeaturess($v = true)
    {
        $this->collConfiguratorFeaturessPartial = $v;
    }

    /**
     * Initializes the collConfiguratorFeaturess collection.
     *
     * By default this just sets the collConfiguratorFeaturess collection to an empty array (like clearcollConfiguratorFeaturess());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initConfiguratorFeaturess($overrideExisting = true)
    {
        if (null !== $this->collConfiguratorFeaturess && !$overrideExisting) {
            return;
        }
        $this->collConfiguratorFeaturess = new ObjectCollection();
        $this->collConfiguratorFeaturess->setModel('\FilterConfigurator\Model\ConfiguratorFeatures');
    }

    /**
     * Gets an array of ChildConfiguratorFeatures objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildConfigurator is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return Collection|ChildConfiguratorFeatures[] List of ChildConfiguratorFeatures objects
     * @throws PropelException
     */
    public function getConfiguratorFeaturess($criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collConfiguratorFeaturessPartial && !$this->isNew();
        if (null === $this->collConfiguratorFeaturess || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collConfiguratorFeaturess) {
                // return empty collection
                $this->initConfiguratorFeaturess();
            } else {
                $collConfiguratorFeaturess = ChildConfiguratorFeaturesQuery::create(null, $criteria)
                    ->filterByConfigurator($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collConfiguratorFeaturessPartial && count($collConfiguratorFeaturess)) {
                        $this->initConfiguratorFeaturess(false);

                        foreach ($collConfiguratorFeaturess as $obj) {
                            if (false == $this->collConfiguratorFeaturess->contains($obj)) {
                                $this->collConfiguratorFeaturess->append($obj);
                            }
                        }

                        $this->collConfiguratorFeaturessPartial = true;
                    }

                    reset($collConfiguratorFeaturess);

                    return $collConfiguratorFeaturess;
                }

                if ($partial && $this->collConfiguratorFeaturess) {
                    foreach ($this->collConfiguratorFeaturess as $obj) {
                        if ($obj->isNew()) {
                            $collConfiguratorFeaturess[] = $obj;
                        }
                    }
                }

                $this->collConfiguratorFeaturess = $collConfiguratorFeaturess;
                $this->collConfiguratorFeaturessPartial = false;
            }
        }

        return $this->collConfiguratorFeaturess;
    }

    /**
     * Sets a collection of ConfiguratorFeatures objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $configuratorFeaturess A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return   ChildConfigurator The current object (for fluent API support)
     */
    public function setConfiguratorFeaturess(Collection $configuratorFeaturess, ConnectionInterface $con = null)
    {
        $configuratorFeaturessToDelete = $this->getConfiguratorFeaturess(new Criteria(), $con)->diff($configuratorFeaturess);

        
        $this->configuratorFeaturessScheduledForDeletion = $configuratorFeaturessToDelete;

        foreach ($configuratorFeaturessToDelete as $configuratorFeaturesRemoved) {
            $configuratorFeaturesRemoved->setConfigurator(null);
        }

        $this->collConfiguratorFeaturess = null;
        foreach ($configuratorFeaturess as $configuratorFeatures) {
            $this->addConfiguratorFeatures($configuratorFeatures);
        }

        $this->collConfiguratorFeaturess = $configuratorFeaturess;
        $this->collConfiguratorFeaturessPartial = false;

        return $this;
    }

    /**
     * Returns the number of related ConfiguratorFeatures objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related ConfiguratorFeatures objects.
     * @throws PropelException
     */
    public function countConfiguratorFeaturess(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collConfiguratorFeaturessPartial && !$this->isNew();
        if (null === $this->collConfiguratorFeaturess || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collConfiguratorFeaturess) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getConfiguratorFeaturess());
            }

            $query = ChildConfiguratorFeaturesQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByConfigurator($this)
                ->count($con);
        }

        return count($this->collConfiguratorFeaturess);
    }

    /**
     * Method called to associate a ChildConfiguratorFeatures object to this object
     * through the ChildConfiguratorFeatures foreign key attribute.
     *
     * @param    ChildConfiguratorFeatures $l ChildConfiguratorFeatures
     * @return   \FilterConfigurator\Model\Configurator The current object (for fluent API support)
     */
    public function addConfiguratorFeatures(ChildConfiguratorFeatures $l)
    {
        if ($this->collConfiguratorFeaturess === null) {
            $this->initConfiguratorFeaturess();
            $this->collConfiguratorFeaturessPartial = true;
        }

        if (!in_array($l, $this->collConfiguratorFeaturess->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddConfiguratorFeatures($l);
        }

        return $this;
    }

    /**
     * @param ConfiguratorFeatures $configuratorFeatures The configuratorFeatures object to add.
     */
    protected function doAddConfiguratorFeatures($configuratorFeatures)
    {
        $this->collConfiguratorFeaturess[]= $configuratorFeatures;
        $configuratorFeatures->setConfigurator($this);
    }

    /**
     * @param  ConfiguratorFeatures $configuratorFeatures The configuratorFeatures object to remove.
     * @return ChildConfigurator The current object (for fluent API support)
     */
    public function removeConfiguratorFeatures($configuratorFeatures)
    {
        if ($this->getConfiguratorFeaturess()->contains($configuratorFeatures)) {
            $this->collConfiguratorFeaturess->remove($this->collConfiguratorFeaturess->search($configuratorFeatures));
            if (null === $this->configuratorFeaturessScheduledForDeletion) {
                $this->configuratorFeaturessScheduledForDeletion = clone $this->collConfiguratorFeaturess;
                $this->configuratorFeaturessScheduledForDeletion->clear();
            }
            $this->configuratorFeaturessScheduledForDeletion[]= $configuratorFeatures;
            $configuratorFeatures->setConfigurator(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Configurator is new, it will return
     * an empty collection; or if this Configurator has previously
     * been saved, it will retrieve related ConfiguratorFeaturess from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Configurator.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return Collection|ChildConfiguratorFeatures[] List of ChildConfiguratorFeatures objects
     */
    public function getConfiguratorFeaturessJoinFeature($criteria = null, $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildConfiguratorFeaturesQuery::create(null, $criteria);
        $query->joinWith('Feature', $joinBehavior);

        return $this->getConfiguratorFeaturess($query, $con);
    }

    /**
     * Clears out the collConfiguratorVersions collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addConfiguratorVersions()
     */
    public function clearConfiguratorVersions()
    {
        $this->collConfiguratorVersions = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collConfiguratorVersions collection loaded partially.
     */
    public function resetPartialConfiguratorVersions($v = true)
    {
        $this->collConfiguratorVersionsPartial = $v;
    }

    /**
     * Initializes the collConfiguratorVersions collection.
     *
     * By default this just sets the collConfiguratorVersions collection to an empty array (like clearcollConfiguratorVersions());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initConfiguratorVersions($overrideExisting = true)
    {
        if (null !== $this->collConfiguratorVersions && !$overrideExisting) {
            return;
        }
        $this->collConfiguratorVersions = new ObjectCollection();
        $this->collConfiguratorVersions->setModel('\FilterConfigurator\Model\ConfiguratorVersion');
    }

    /**
     * Gets an array of ChildConfiguratorVersion objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildConfigurator is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return Collection|ChildConfiguratorVersion[] List of ChildConfiguratorVersion objects
     * @throws PropelException
     */
    public function getConfiguratorVersions($criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collConfiguratorVersionsPartial && !$this->isNew();
        if (null === $this->collConfiguratorVersions || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collConfiguratorVersions) {
                // return empty collection
                $this->initConfiguratorVersions();
            } else {
                $collConfiguratorVersions = ChildConfiguratorVersionQuery::create(null, $criteria)
                    ->filterByConfigurator($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collConfiguratorVersionsPartial && count($collConfiguratorVersions)) {
                        $this->initConfiguratorVersions(false);

                        foreach ($collConfiguratorVersions as $obj) {
                            if (false == $this->collConfiguratorVersions->contains($obj)) {
                                $this->collConfiguratorVersions->append($obj);
                            }
                        }

                        $this->collConfiguratorVersionsPartial = true;
                    }

                    reset($collConfiguratorVersions);

                    return $collConfiguratorVersions;
                }

                if ($partial && $this->collConfiguratorVersions) {
                    foreach ($this->collConfiguratorVersions as $obj) {
                        if ($obj->isNew()) {
                            $collConfiguratorVersions[] = $obj;
                        }
                    }
                }

                $this->collConfiguratorVersions = $collConfiguratorVersions;
                $this->collConfiguratorVersionsPartial = false;
            }
        }

        return $this->collConfiguratorVersions;
    }

    /**
     * Sets a collection of ConfiguratorVersion objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $configuratorVersions A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return   ChildConfigurator The current object (for fluent API support)
     */
    public function setConfiguratorVersions(Collection $configuratorVersions, ConnectionInterface $con = null)
    {
        $configuratorVersionsToDelete = $this->getConfiguratorVersions(new Criteria(), $con)->diff($configuratorVersions);

        
        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->configuratorVersionsScheduledForDeletion = clone $configuratorVersionsToDelete;

        foreach ($configuratorVersionsToDelete as $configuratorVersionRemoved) {
            $configuratorVersionRemoved->setConfigurator(null);
        }

        $this->collConfiguratorVersions = null;
        foreach ($configuratorVersions as $configuratorVersion) {
            $this->addConfiguratorVersion($configuratorVersion);
        }

        $this->collConfiguratorVersions = $configuratorVersions;
        $this->collConfiguratorVersionsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related ConfiguratorVersion objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related ConfiguratorVersion objects.
     * @throws PropelException
     */
    public function countConfiguratorVersions(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collConfiguratorVersionsPartial && !$this->isNew();
        if (null === $this->collConfiguratorVersions || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collConfiguratorVersions) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getConfiguratorVersions());
            }

            $query = ChildConfiguratorVersionQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByConfigurator($this)
                ->count($con);
        }

        return count($this->collConfiguratorVersions);
    }

    /**
     * Method called to associate a ChildConfiguratorVersion object to this object
     * through the ChildConfiguratorVersion foreign key attribute.
     *
     * @param    ChildConfiguratorVersion $l ChildConfiguratorVersion
     * @return   \FilterConfigurator\Model\Configurator The current object (for fluent API support)
     */
    public function addConfiguratorVersion(ChildConfiguratorVersion $l)
    {
        if ($this->collConfiguratorVersions === null) {
            $this->initConfiguratorVersions();
            $this->collConfiguratorVersionsPartial = true;
        }

        if (!in_array($l, $this->collConfiguratorVersions->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddConfiguratorVersion($l);
        }

        return $this;
    }

    /**
     * @param ConfiguratorVersion $configuratorVersion The configuratorVersion object to add.
     */
    protected function doAddConfiguratorVersion($configuratorVersion)
    {
        $this->collConfiguratorVersions[]= $configuratorVersion;
        $configuratorVersion->setConfigurator($this);
    }

    /**
     * @param  ConfiguratorVersion $configuratorVersion The configuratorVersion object to remove.
     * @return ChildConfigurator The current object (for fluent API support)
     */
    public function removeConfiguratorVersion($configuratorVersion)
    {
        if ($this->getConfiguratorVersions()->contains($configuratorVersion)) {
            $this->collConfiguratorVersions->remove($this->collConfiguratorVersions->search($configuratorVersion));
            if (null === $this->configuratorVersionsScheduledForDeletion) {
                $this->configuratorVersionsScheduledForDeletion = clone $this->collConfiguratorVersions;
                $this->configuratorVersionsScheduledForDeletion->clear();
            }
            $this->configuratorVersionsScheduledForDeletion[]= clone $configuratorVersion;
            $configuratorVersion->setConfigurator(null);
        }

        return $this;
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->id = null;
        $this->visible = null;
        $this->position = null;
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
            if ($this->collConfiguratorI18ns) {
                foreach ($this->collConfiguratorI18ns as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collConfiguratorImages) {
                foreach ($this->collConfiguratorImages as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collConfiguratorFeaturess) {
                foreach ($this->collConfiguratorFeaturess as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collConfiguratorVersions) {
                foreach ($this->collConfiguratorVersions as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collConfiguratorI18ns = null;
        $this->collConfiguratorImages = null;
        $this->collConfiguratorFeaturess = null;
        $this->collConfiguratorVersions = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(ConfiguratorTableMap::DEFAULT_STRING_FORMAT);
    }

    // timestampable behavior
    
    /**
     * Mark the current object so that the update date doesn't get updated during next save
     *
     * @return     ChildConfigurator The current object (for fluent API support)
     */
    public function keepUpdateDateUnchanged()
    {
        $this->modifiedColumns[ConfiguratorTableMap::UPDATED_AT] = true;
    
        return $this;
    }

    // versionable behavior
    
    /**
     * Enforce a new Version of this object upon next save.
     *
     * @return \FilterConfigurator\Model\Configurator
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
    
        if (ChildConfiguratorQuery::isVersioningEnabled() && ($this->isNew() || $this->isModified()) || $this->isDeleted()) {
            return true;
        }
    
        return false;
    }
    
    /**
     * Creates a version of the current object and saves it.
     *
     * @param   ConnectionInterface $con the connection to use
     *
     * @return  ChildConfiguratorVersion A version object
     */
    public function addVersion($con = null)
    {
        $this->enforceVersion = false;
    
        $version = new ChildConfiguratorVersion();
        $version->setId($this->getId());
        $version->setVisible($this->getVisible());
        $version->setPosition($this->getPosition());
        $version->setCreatedAt($this->getCreatedAt());
        $version->setUpdatedAt($this->getUpdatedAt());
        $version->setVersion($this->getVersion());
        $version->setVersionCreatedAt($this->getVersionCreatedAt());
        $version->setVersionCreatedBy($this->getVersionCreatedBy());
        $version->setConfigurator($this);
        $version->save($con);
    
        return $version;
    }
    
    /**
     * Sets the properties of the current object to the value they had at a specific version
     *
     * @param   integer $versionNumber The version number to read
     * @param   ConnectionInterface $con The connection to use
     *
     * @return  ChildConfigurator The current object (for fluent API support)
     */
    public function toVersion($versionNumber, $con = null)
    {
        $version = $this->getOneVersion($versionNumber, $con);
        if (!$version) {
            throw new PropelException(sprintf('No ChildConfigurator object found with version %d', $version));
        }
        $this->populateFromVersion($version, $con);
    
        return $this;
    }
    
    /**
     * Sets the properties of the current object to the value they had at a specific version
     *
     * @param ChildConfiguratorVersion $version The version object to use
     * @param ConnectionInterface   $con the connection to use
     * @param array                 $loadedObjects objects that been loaded in a chain of populateFromVersion calls on referrer or fk objects.
     *
     * @return ChildConfigurator The current object (for fluent API support)
     */
    public function populateFromVersion($version, $con = null, &$loadedObjects = array())
    {
        $loadedObjects['ChildConfigurator'][$version->getId()][$version->getVersion()] = $this;
        $this->setId($version->getId());
        $this->setVisible($version->getVisible());
        $this->setPosition($version->getPosition());
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
        $v = ChildConfiguratorVersionQuery::create()
            ->filterByConfigurator($this)
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
     * @return  ChildConfiguratorVersion A version object
     */
    public function getOneVersion($versionNumber, $con = null)
    {
        return ChildConfiguratorVersionQuery::create()
            ->filterByConfigurator($this)
            ->filterByVersion($versionNumber)
            ->findOne($con);
    }
    
    /**
     * Gets all the versions of this object, in incremental order
     *
     * @param   ConnectionInterface $con the connection to use
     *
     * @return  ObjectCollection A list of ChildConfiguratorVersion objects
     */
    public function getAllVersions($con = null)
    {
        $criteria = new Criteria();
        $criteria->addAscendingOrderByColumn(ConfiguratorVersionTableMap::VERSION);
    
        return $this->getConfiguratorVersions($criteria, $con);
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
     * @return PropelCollection|array \FilterConfigurator\Model\ConfiguratorVersion[] List of \FilterConfigurator\Model\ConfiguratorVersion objects
     */
    public function getLastVersions($number = 10, $criteria = null, $con = null)
    {
        $criteria = ChildConfiguratorVersionQuery::create(null, $criteria);
        $criteria->addDescendingOrderByColumn(ConfiguratorVersionTableMap::VERSION);
        $criteria->limit($number);
    
        return $this->getConfiguratorVersions($criteria, $con);
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
