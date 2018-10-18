<?php

namespace FilterConfigurator\Model\Base;

use \DateTime;
use \Exception;
use \PDO;
use FilterConfigurator\Model\FilterConfigurator as ChildFilterConfigurator;
use FilterConfigurator\Model\FilterConfiguratorFeatures as ChildFilterConfiguratorFeatures;
use FilterConfigurator\Model\FilterConfiguratorFeaturesQuery as ChildFilterConfiguratorFeaturesQuery;
use FilterConfigurator\Model\FilterConfiguratorHook as ChildFilterConfiguratorHook;
use FilterConfigurator\Model\FilterConfiguratorHookQuery as ChildFilterConfiguratorHookQuery;
use FilterConfigurator\Model\FilterConfiguratorI18n as ChildFilterConfiguratorI18n;
use FilterConfigurator\Model\FilterConfiguratorI18nQuery as ChildFilterConfiguratorI18nQuery;
use FilterConfigurator\Model\FilterConfiguratorImage as ChildFilterConfiguratorImage;
use FilterConfigurator\Model\FilterConfiguratorImageQuery as ChildFilterConfiguratorImageQuery;
use FilterConfigurator\Model\FilterConfiguratorQuery as ChildFilterConfiguratorQuery;
use FilterConfigurator\Model\Map\FilterConfiguratorTableMap;
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
use Thelia\Model\CategoryQuery;
use Thelia\Model\Category as ChildCategory;

abstract class FilterConfigurator implements ActiveRecordInterface 
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\FilterConfigurator\\Model\\Map\\FilterConfiguratorTableMap';


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
     * The value for the category_id field.
     * @var        int
     */
    protected $category_id;

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
     * @var        Category
     */
    protected $aCategory;

    /**
     * @var        ObjectCollection|ChildFilterConfiguratorHook[] Collection to store aggregation of ChildFilterConfiguratorHook objects.
     */
    protected $collFilterConfiguratorHooks;
    protected $collFilterConfiguratorHooksPartial;

    /**
     * @var        ObjectCollection|ChildFilterConfiguratorI18n[] Collection to store aggregation of ChildFilterConfiguratorI18n objects.
     */
    protected $collFilterConfiguratorI18ns;
    protected $collFilterConfiguratorI18nsPartial;

    /**
     * @var        ObjectCollection|ChildFilterConfiguratorImage[] Collection to store aggregation of ChildFilterConfiguratorImage objects.
     */
    protected $collFilterConfiguratorImages;
    protected $collFilterConfiguratorImagesPartial;

    /**
     * @var        ObjectCollection|ChildFilterConfiguratorFeatures[] Collection to store aggregation of ChildFilterConfiguratorFeatures objects.
     */
    protected $collFilterConfiguratorFeaturess;
    protected $collFilterConfiguratorFeaturessPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection
     */
    protected $filterConfiguratorHooksScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection
     */
    protected $filterConfiguratorI18nsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection
     */
    protected $filterConfiguratorImagesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection
     */
    protected $filterConfiguratorFeaturessScheduledForDeletion = null;

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
    }

    /**
     * Initializes internal state of FilterConfigurator\Model\Base\FilterConfigurator object.
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
     * Compares this with another <code>FilterConfigurator</code> instance.  If
     * <code>obj</code> is an instance of <code>FilterConfigurator</code>, delegates to
     * <code>equals(FilterConfigurator)</code>.  Otherwise, returns <code>false</code>.
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
     * @return FilterConfigurator The current object, for fluid interface
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
     * @return FilterConfigurator The current object, for fluid interface
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
     * Get the [category_id] column value.
     * 
     * @return   int
     */
    public function getCategoryId()
    {

        return $this->category_id;
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
     * Set the value of [id] column.
     * 
     * @param      int $v new value
     * @return   \FilterConfigurator\Model\FilterConfigurator The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[FilterConfiguratorTableMap::ID] = true;
        }


        return $this;
    } // setId()

    /**
     * Set the value of [category_id] column.
     * 
     * @param      int $v new value
     * @return   \FilterConfigurator\Model\FilterConfigurator The current object (for fluent API support)
     */
    public function setCategoryId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->category_id !== $v) {
            $this->category_id = $v;
            $this->modifiedColumns[FilterConfiguratorTableMap::CATEGORY_ID] = true;
        }

        if ($this->aCategory !== null && $this->aCategory->getId() !== $v) {
            $this->aCategory = null;
        }


        return $this;
    } // setCategoryId()

    /**
     * Set the value of [visible] column.
     * 
     * @param      int $v new value
     * @return   \FilterConfigurator\Model\FilterConfigurator The current object (for fluent API support)
     */
    public function setVisible($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->visible !== $v) {
            $this->visible = $v;
            $this->modifiedColumns[FilterConfiguratorTableMap::VISIBLE] = true;
        }


        return $this;
    } // setVisible()

    /**
     * Set the value of [position] column.
     * 
     * @param      int $v new value
     * @return   \FilterConfigurator\Model\FilterConfigurator The current object (for fluent API support)
     */
    public function setPosition($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->position !== $v) {
            $this->position = $v;
            $this->modifiedColumns[FilterConfiguratorTableMap::POSITION] = true;
        }


        return $this;
    } // setPosition()

    /**
     * Sets the value of [created_at] column to a normalized version of the date/time value specified.
     * 
     * @param      mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return   \FilterConfigurator\Model\FilterConfigurator The current object (for fluent API support)
     */
    public function setCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->created_at !== null || $dt !== null) {
            if ($dt !== $this->created_at) {
                $this->created_at = $dt;
                $this->modifiedColumns[FilterConfiguratorTableMap::CREATED_AT] = true;
            }
        } // if either are not null


        return $this;
    } // setCreatedAt()

    /**
     * Sets the value of [updated_at] column to a normalized version of the date/time value specified.
     * 
     * @param      mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return   \FilterConfigurator\Model\FilterConfigurator The current object (for fluent API support)
     */
    public function setUpdatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->updated_at !== null || $dt !== null) {
            if ($dt !== $this->updated_at) {
                $this->updated_at = $dt;
                $this->modifiedColumns[FilterConfiguratorTableMap::UPDATED_AT] = true;
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
            if ($this->visible !== 0) {
                return false;
            }

            if ($this->position !== 0) {
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


            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : FilterConfiguratorTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : FilterConfiguratorTableMap::translateFieldName('CategoryId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->category_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : FilterConfiguratorTableMap::translateFieldName('Visible', TableMap::TYPE_PHPNAME, $indexType)];
            $this->visible = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : FilterConfiguratorTableMap::translateFieldName('Position', TableMap::TYPE_PHPNAME, $indexType)];
            $this->position = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : FilterConfiguratorTableMap::translateFieldName('CreatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->created_at = (null !== $col) ? PropelDateTime::newInstance($col, null, '\DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : FilterConfiguratorTableMap::translateFieldName('UpdatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->updated_at = (null !== $col) ? PropelDateTime::newInstance($col, null, '\DateTime') : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 6; // 6 = FilterConfiguratorTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating \FilterConfigurator\Model\FilterConfigurator object", 0, $e);
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
        if ($this->aCategory !== null && $this->category_id !== $this->aCategory->getId()) {
            $this->aCategory = null;
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
            $con = Propel::getServiceContainer()->getReadConnection(FilterConfiguratorTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildFilterConfiguratorQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aCategory = null;
            $this->collFilterConfiguratorHooks = null;

            $this->collFilterConfiguratorI18ns = null;

            $this->collFilterConfiguratorImages = null;

            $this->collFilterConfiguratorFeaturess = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see FilterConfigurator::setDeleted()
     * @see FilterConfigurator::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(FilterConfiguratorTableMap::DATABASE_NAME);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = ChildFilterConfiguratorQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(FilterConfiguratorTableMap::DATABASE_NAME);
        }

        $con->beginTransaction();
        $isInsert = $this->isNew();
        try {
            $ret = $this->preSave($con);
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
                // timestampable behavior
                if (!$this->isColumnModified(FilterConfiguratorTableMap::CREATED_AT)) {
                    $this->setCreatedAt(time());
                }
                if (!$this->isColumnModified(FilterConfiguratorTableMap::UPDATED_AT)) {
                    $this->setUpdatedAt(time());
                }
            } else {
                $ret = $ret && $this->preUpdate($con);
                // timestampable behavior
                if ($this->isModified() && !$this->isColumnModified(FilterConfiguratorTableMap::UPDATED_AT)) {
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
                FilterConfiguratorTableMap::addInstanceToPool($this);
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

            if ($this->aCategory !== null) {
                if ($this->aCategory->isModified() || $this->aCategory->isNew()) {
                    $affectedRows += $this->aCategory->save($con);
                }
                $this->setCategory($this->aCategory);
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

            if ($this->filterConfiguratorHooksScheduledForDeletion !== null) {
                if (!$this->filterConfiguratorHooksScheduledForDeletion->isEmpty()) {
                    \FilterConfigurator\Model\FilterConfiguratorHookQuery::create()
                        ->filterByPrimaryKeys($this->filterConfiguratorHooksScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->filterConfiguratorHooksScheduledForDeletion = null;
                }
            }

                if ($this->collFilterConfiguratorHooks !== null) {
            foreach ($this->collFilterConfiguratorHooks as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->filterConfiguratorI18nsScheduledForDeletion !== null) {
                if (!$this->filterConfiguratorI18nsScheduledForDeletion->isEmpty()) {
                    \FilterConfigurator\Model\FilterConfiguratorI18nQuery::create()
                        ->filterByPrimaryKeys($this->filterConfiguratorI18nsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->filterConfiguratorI18nsScheduledForDeletion = null;
                }
            }

                if ($this->collFilterConfiguratorI18ns !== null) {
            foreach ($this->collFilterConfiguratorI18ns as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->filterConfiguratorImagesScheduledForDeletion !== null) {
                if (!$this->filterConfiguratorImagesScheduledForDeletion->isEmpty()) {
                    \FilterConfigurator\Model\FilterConfiguratorImageQuery::create()
                        ->filterByPrimaryKeys($this->filterConfiguratorImagesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->filterConfiguratorImagesScheduledForDeletion = null;
                }
            }

                if ($this->collFilterConfiguratorImages !== null) {
            foreach ($this->collFilterConfiguratorImages as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->filterConfiguratorFeaturessScheduledForDeletion !== null) {
                if (!$this->filterConfiguratorFeaturessScheduledForDeletion->isEmpty()) {
                    \FilterConfigurator\Model\FilterConfiguratorFeaturesQuery::create()
                        ->filterByPrimaryKeys($this->filterConfiguratorFeaturessScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->filterConfiguratorFeaturessScheduledForDeletion = null;
                }
            }

                if ($this->collFilterConfiguratorFeaturess !== null) {
            foreach ($this->collFilterConfiguratorFeaturess as $referrerFK) {
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

        $this->modifiedColumns[FilterConfiguratorTableMap::ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . FilterConfiguratorTableMap::ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(FilterConfiguratorTableMap::ID)) {
            $modifiedColumns[':p' . $index++]  = 'ID';
        }
        if ($this->isColumnModified(FilterConfiguratorTableMap::CATEGORY_ID)) {
            $modifiedColumns[':p' . $index++]  = 'CATEGORY_ID';
        }
        if ($this->isColumnModified(FilterConfiguratorTableMap::VISIBLE)) {
            $modifiedColumns[':p' . $index++]  = 'VISIBLE';
        }
        if ($this->isColumnModified(FilterConfiguratorTableMap::POSITION)) {
            $modifiedColumns[':p' . $index++]  = 'POSITION';
        }
        if ($this->isColumnModified(FilterConfiguratorTableMap::CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'CREATED_AT';
        }
        if ($this->isColumnModified(FilterConfiguratorTableMap::UPDATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'UPDATED_AT';
        }

        $sql = sprintf(
            'INSERT INTO filterconfigurator_configurator (%s) VALUES (%s)',
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
                    case 'CATEGORY_ID':                        
                        $stmt->bindValue($identifier, $this->category_id, PDO::PARAM_INT);
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
        $pos = FilterConfiguratorTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getCategoryId();
                break;
            case 2:
                return $this->getVisible();
                break;
            case 3:
                return $this->getPosition();
                break;
            case 4:
                return $this->getCreatedAt();
                break;
            case 5:
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
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = TableMap::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {
        if (isset($alreadyDumpedObjects['FilterConfigurator'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['FilterConfigurator'][$this->getPrimaryKey()] = true;
        $keys = FilterConfiguratorTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getCategoryId(),
            $keys[2] => $this->getVisible(),
            $keys[3] => $this->getPosition(),
            $keys[4] => $this->getCreatedAt(),
            $keys[5] => $this->getUpdatedAt(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }
        
        if ($includeForeignObjects) {
            if (null !== $this->aCategory) {
                $result['Category'] = $this->aCategory->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collFilterConfiguratorHooks) {
                $result['FilterConfiguratorHooks'] = $this->collFilterConfiguratorHooks->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collFilterConfiguratorI18ns) {
                $result['FilterConfiguratorI18ns'] = $this->collFilterConfiguratorI18ns->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collFilterConfiguratorImages) {
                $result['FilterConfiguratorImages'] = $this->collFilterConfiguratorImages->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collFilterConfiguratorFeaturess) {
                $result['FilterConfiguratorFeaturess'] = $this->collFilterConfiguratorFeaturess->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
        $pos = FilterConfiguratorTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

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
                $this->setCategoryId($value);
                break;
            case 2:
                $this->setVisible($value);
                break;
            case 3:
                $this->setPosition($value);
                break;
            case 4:
                $this->setCreatedAt($value);
                break;
            case 5:
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
        $keys = FilterConfiguratorTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setCategoryId($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setVisible($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setPosition($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setCreatedAt($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setUpdatedAt($arr[$keys[5]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(FilterConfiguratorTableMap::DATABASE_NAME);

        if ($this->isColumnModified(FilterConfiguratorTableMap::ID)) $criteria->add(FilterConfiguratorTableMap::ID, $this->id);
        if ($this->isColumnModified(FilterConfiguratorTableMap::CATEGORY_ID)) $criteria->add(FilterConfiguratorTableMap::CATEGORY_ID, $this->category_id);
        if ($this->isColumnModified(FilterConfiguratorTableMap::VISIBLE)) $criteria->add(FilterConfiguratorTableMap::VISIBLE, $this->visible);
        if ($this->isColumnModified(FilterConfiguratorTableMap::POSITION)) $criteria->add(FilterConfiguratorTableMap::POSITION, $this->position);
        if ($this->isColumnModified(FilterConfiguratorTableMap::CREATED_AT)) $criteria->add(FilterConfiguratorTableMap::CREATED_AT, $this->created_at);
        if ($this->isColumnModified(FilterConfiguratorTableMap::UPDATED_AT)) $criteria->add(FilterConfiguratorTableMap::UPDATED_AT, $this->updated_at);

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
        $criteria = new Criteria(FilterConfiguratorTableMap::DATABASE_NAME);
        $criteria->add(FilterConfiguratorTableMap::ID, $this->id);

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
     * @param      object $copyObj An object of \FilterConfigurator\Model\FilterConfigurator (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setCategoryId($this->getCategoryId());
        $copyObj->setVisible($this->getVisible());
        $copyObj->setPosition($this->getPosition());
        $copyObj->setCreatedAt($this->getCreatedAt());
        $copyObj->setUpdatedAt($this->getUpdatedAt());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getFilterConfiguratorHooks() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addFilterConfiguratorHook($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getFilterConfiguratorI18ns() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addFilterConfiguratorI18n($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getFilterConfiguratorImages() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addFilterConfiguratorImage($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getFilterConfiguratorFeaturess() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addFilterConfiguratorFeatures($relObj->copy($deepCopy));
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
     * @return                 \FilterConfigurator\Model\FilterConfigurator Clone of current object.
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
     * Declares an association between this object and a ChildCategory object.
     *
     * @param                  ChildCategory $v
     * @return                 \FilterConfigurator\Model\FilterConfigurator The current object (for fluent API support)
     * @throws PropelException
     */
    public function setCategory(ChildCategory $v = null)
    {
        if ($v === null) {
            $this->setCategoryId(NULL);
        } else {
            $this->setCategoryId($v->getId());
        }

        $this->aCategory = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildCategory object, it will not be re-added.
        if ($v !== null) {
            $v->addFilterConfigurator($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildCategory object
     *
     * @param      ConnectionInterface $con Optional Connection object.
     * @return                 ChildCategory The associated ChildCategory object.
     * @throws PropelException
     */
    public function getCategory(ConnectionInterface $con = null)
    {
        if ($this->aCategory === null && ($this->category_id !== null)) {
            $this->aCategory = CategoryQuery::create()->findPk($this->category_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aCategory->addFilterConfigurators($this);
             */
        }

        return $this->aCategory;
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
        if ('FilterConfiguratorHook' == $relationName) {
            return $this->initFilterConfiguratorHooks();
        }
        if ('FilterConfiguratorI18n' == $relationName) {
            return $this->initFilterConfiguratorI18ns();
        }
        if ('FilterConfiguratorImage' == $relationName) {
            return $this->initFilterConfiguratorImages();
        }
        if ('FilterConfiguratorFeatures' == $relationName) {
            return $this->initFilterConfiguratorFeaturess();
        }
    }

    /**
     * Clears out the collFilterConfiguratorHooks collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addFilterConfiguratorHooks()
     */
    public function clearFilterConfiguratorHooks()
    {
        $this->collFilterConfiguratorHooks = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collFilterConfiguratorHooks collection loaded partially.
     */
    public function resetPartialFilterConfiguratorHooks($v = true)
    {
        $this->collFilterConfiguratorHooksPartial = $v;
    }

    /**
     * Initializes the collFilterConfiguratorHooks collection.
     *
     * By default this just sets the collFilterConfiguratorHooks collection to an empty array (like clearcollFilterConfiguratorHooks());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initFilterConfiguratorHooks($overrideExisting = true)
    {
        if (null !== $this->collFilterConfiguratorHooks && !$overrideExisting) {
            return;
        }
        $this->collFilterConfiguratorHooks = new ObjectCollection();
        $this->collFilterConfiguratorHooks->setModel('\FilterConfigurator\Model\FilterConfiguratorHook');
    }

    /**
     * Gets an array of ChildFilterConfiguratorHook objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildFilterConfigurator is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return Collection|ChildFilterConfiguratorHook[] List of ChildFilterConfiguratorHook objects
     * @throws PropelException
     */
    public function getFilterConfiguratorHooks($criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collFilterConfiguratorHooksPartial && !$this->isNew();
        if (null === $this->collFilterConfiguratorHooks || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collFilterConfiguratorHooks) {
                // return empty collection
                $this->initFilterConfiguratorHooks();
            } else {
                $collFilterConfiguratorHooks = ChildFilterConfiguratorHookQuery::create(null, $criteria)
                    ->filterByFilterConfigurator($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collFilterConfiguratorHooksPartial && count($collFilterConfiguratorHooks)) {
                        $this->initFilterConfiguratorHooks(false);

                        foreach ($collFilterConfiguratorHooks as $obj) {
                            if (false == $this->collFilterConfiguratorHooks->contains($obj)) {
                                $this->collFilterConfiguratorHooks->append($obj);
                            }
                        }

                        $this->collFilterConfiguratorHooksPartial = true;
                    }

                    reset($collFilterConfiguratorHooks);

                    return $collFilterConfiguratorHooks;
                }

                if ($partial && $this->collFilterConfiguratorHooks) {
                    foreach ($this->collFilterConfiguratorHooks as $obj) {
                        if ($obj->isNew()) {
                            $collFilterConfiguratorHooks[] = $obj;
                        }
                    }
                }

                $this->collFilterConfiguratorHooks = $collFilterConfiguratorHooks;
                $this->collFilterConfiguratorHooksPartial = false;
            }
        }

        return $this->collFilterConfiguratorHooks;
    }

    /**
     * Sets a collection of FilterConfiguratorHook objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $filterConfiguratorHooks A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return   ChildFilterConfigurator The current object (for fluent API support)
     */
    public function setFilterConfiguratorHooks(Collection $filterConfiguratorHooks, ConnectionInterface $con = null)
    {
        $filterConfiguratorHooksToDelete = $this->getFilterConfiguratorHooks(new Criteria(), $con)->diff($filterConfiguratorHooks);

        
        $this->filterConfiguratorHooksScheduledForDeletion = $filterConfiguratorHooksToDelete;

        foreach ($filterConfiguratorHooksToDelete as $filterConfiguratorHookRemoved) {
            $filterConfiguratorHookRemoved->setFilterConfigurator(null);
        }

        $this->collFilterConfiguratorHooks = null;
        foreach ($filterConfiguratorHooks as $filterConfiguratorHook) {
            $this->addFilterConfiguratorHook($filterConfiguratorHook);
        }

        $this->collFilterConfiguratorHooks = $filterConfiguratorHooks;
        $this->collFilterConfiguratorHooksPartial = false;

        return $this;
    }

    /**
     * Returns the number of related FilterConfiguratorHook objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related FilterConfiguratorHook objects.
     * @throws PropelException
     */
    public function countFilterConfiguratorHooks(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collFilterConfiguratorHooksPartial && !$this->isNew();
        if (null === $this->collFilterConfiguratorHooks || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collFilterConfiguratorHooks) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getFilterConfiguratorHooks());
            }

            $query = ChildFilterConfiguratorHookQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByFilterConfigurator($this)
                ->count($con);
        }

        return count($this->collFilterConfiguratorHooks);
    }

    /**
     * Method called to associate a ChildFilterConfiguratorHook object to this object
     * through the ChildFilterConfiguratorHook foreign key attribute.
     *
     * @param    ChildFilterConfiguratorHook $l ChildFilterConfiguratorHook
     * @return   \FilterConfigurator\Model\FilterConfigurator The current object (for fluent API support)
     */
    public function addFilterConfiguratorHook(ChildFilterConfiguratorHook $l)
    {
        if ($this->collFilterConfiguratorHooks === null) {
            $this->initFilterConfiguratorHooks();
            $this->collFilterConfiguratorHooksPartial = true;
        }

        if (!in_array($l, $this->collFilterConfiguratorHooks->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddFilterConfiguratorHook($l);
        }

        return $this;
    }

    /**
     * @param FilterConfiguratorHook $filterConfiguratorHook The filterConfiguratorHook object to add.
     */
    protected function doAddFilterConfiguratorHook($filterConfiguratorHook)
    {
        $this->collFilterConfiguratorHooks[]= $filterConfiguratorHook;
        $filterConfiguratorHook->setFilterConfigurator($this);
    }

    /**
     * @param  FilterConfiguratorHook $filterConfiguratorHook The filterConfiguratorHook object to remove.
     * @return ChildFilterConfigurator The current object (for fluent API support)
     */
    public function removeFilterConfiguratorHook($filterConfiguratorHook)
    {
        if ($this->getFilterConfiguratorHooks()->contains($filterConfiguratorHook)) {
            $this->collFilterConfiguratorHooks->remove($this->collFilterConfiguratorHooks->search($filterConfiguratorHook));
            if (null === $this->filterConfiguratorHooksScheduledForDeletion) {
                $this->filterConfiguratorHooksScheduledForDeletion = clone $this->collFilterConfiguratorHooks;
                $this->filterConfiguratorHooksScheduledForDeletion->clear();
            }
            $this->filterConfiguratorHooksScheduledForDeletion[]= $filterConfiguratorHook;
            $filterConfiguratorHook->setFilterConfigurator(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this FilterConfigurator is new, it will return
     * an empty collection; or if this FilterConfigurator has previously
     * been saved, it will retrieve related FilterConfiguratorHooks from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in FilterConfigurator.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return Collection|ChildFilterConfiguratorHook[] List of ChildFilterConfiguratorHook objects
     */
    public function getFilterConfiguratorHooksJoinHook($criteria = null, $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildFilterConfiguratorHookQuery::create(null, $criteria);
        $query->joinWith('Hook', $joinBehavior);

        return $this->getFilterConfiguratorHooks($query, $con);
    }

    /**
     * Clears out the collFilterConfiguratorI18ns collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addFilterConfiguratorI18ns()
     */
    public function clearFilterConfiguratorI18ns()
    {
        $this->collFilterConfiguratorI18ns = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collFilterConfiguratorI18ns collection loaded partially.
     */
    public function resetPartialFilterConfiguratorI18ns($v = true)
    {
        $this->collFilterConfiguratorI18nsPartial = $v;
    }

    /**
     * Initializes the collFilterConfiguratorI18ns collection.
     *
     * By default this just sets the collFilterConfiguratorI18ns collection to an empty array (like clearcollFilterConfiguratorI18ns());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initFilterConfiguratorI18ns($overrideExisting = true)
    {
        if (null !== $this->collFilterConfiguratorI18ns && !$overrideExisting) {
            return;
        }
        $this->collFilterConfiguratorI18ns = new ObjectCollection();
        $this->collFilterConfiguratorI18ns->setModel('\FilterConfigurator\Model\FilterConfiguratorI18n');
    }

    /**
     * Gets an array of ChildFilterConfiguratorI18n objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildFilterConfigurator is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return Collection|ChildFilterConfiguratorI18n[] List of ChildFilterConfiguratorI18n objects
     * @throws PropelException
     */
    public function getFilterConfiguratorI18ns($criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collFilterConfiguratorI18nsPartial && !$this->isNew();
        if (null === $this->collFilterConfiguratorI18ns || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collFilterConfiguratorI18ns) {
                // return empty collection
                $this->initFilterConfiguratorI18ns();
            } else {
                $collFilterConfiguratorI18ns = ChildFilterConfiguratorI18nQuery::create(null, $criteria)
                    ->filterByFilterConfigurator($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collFilterConfiguratorI18nsPartial && count($collFilterConfiguratorI18ns)) {
                        $this->initFilterConfiguratorI18ns(false);

                        foreach ($collFilterConfiguratorI18ns as $obj) {
                            if (false == $this->collFilterConfiguratorI18ns->contains($obj)) {
                                $this->collFilterConfiguratorI18ns->append($obj);
                            }
                        }

                        $this->collFilterConfiguratorI18nsPartial = true;
                    }

                    reset($collFilterConfiguratorI18ns);

                    return $collFilterConfiguratorI18ns;
                }

                if ($partial && $this->collFilterConfiguratorI18ns) {
                    foreach ($this->collFilterConfiguratorI18ns as $obj) {
                        if ($obj->isNew()) {
                            $collFilterConfiguratorI18ns[] = $obj;
                        }
                    }
                }

                $this->collFilterConfiguratorI18ns = $collFilterConfiguratorI18ns;
                $this->collFilterConfiguratorI18nsPartial = false;
            }
        }

        return $this->collFilterConfiguratorI18ns;
    }

    /**
     * Sets a collection of FilterConfiguratorI18n objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $filterConfiguratorI18ns A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return   ChildFilterConfigurator The current object (for fluent API support)
     */
    public function setFilterConfiguratorI18ns(Collection $filterConfiguratorI18ns, ConnectionInterface $con = null)
    {
        $filterConfiguratorI18nsToDelete = $this->getFilterConfiguratorI18ns(new Criteria(), $con)->diff($filterConfiguratorI18ns);

        
        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->filterConfiguratorI18nsScheduledForDeletion = clone $filterConfiguratorI18nsToDelete;

        foreach ($filterConfiguratorI18nsToDelete as $filterConfiguratorI18nRemoved) {
            $filterConfiguratorI18nRemoved->setFilterConfigurator(null);
        }

        $this->collFilterConfiguratorI18ns = null;
        foreach ($filterConfiguratorI18ns as $filterConfiguratorI18n) {
            $this->addFilterConfiguratorI18n($filterConfiguratorI18n);
        }

        $this->collFilterConfiguratorI18ns = $filterConfiguratorI18ns;
        $this->collFilterConfiguratorI18nsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related FilterConfiguratorI18n objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related FilterConfiguratorI18n objects.
     * @throws PropelException
     */
    public function countFilterConfiguratorI18ns(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collFilterConfiguratorI18nsPartial && !$this->isNew();
        if (null === $this->collFilterConfiguratorI18ns || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collFilterConfiguratorI18ns) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getFilterConfiguratorI18ns());
            }

            $query = ChildFilterConfiguratorI18nQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByFilterConfigurator($this)
                ->count($con);
        }

        return count($this->collFilterConfiguratorI18ns);
    }

    /**
     * Method called to associate a ChildFilterConfiguratorI18n object to this object
     * through the ChildFilterConfiguratorI18n foreign key attribute.
     *
     * @param    ChildFilterConfiguratorI18n $l ChildFilterConfiguratorI18n
     * @return   \FilterConfigurator\Model\FilterConfigurator The current object (for fluent API support)
     */
    public function addFilterConfiguratorI18n(ChildFilterConfiguratorI18n $l)
    {
        if ($this->collFilterConfiguratorI18ns === null) {
            $this->initFilterConfiguratorI18ns();
            $this->collFilterConfiguratorI18nsPartial = true;
        }

        if (!in_array($l, $this->collFilterConfiguratorI18ns->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddFilterConfiguratorI18n($l);
        }

        return $this;
    }

    /**
     * @param FilterConfiguratorI18n $filterConfiguratorI18n The filterConfiguratorI18n object to add.
     */
    protected function doAddFilterConfiguratorI18n($filterConfiguratorI18n)
    {
        $this->collFilterConfiguratorI18ns[]= $filterConfiguratorI18n;
        $filterConfiguratorI18n->setFilterConfigurator($this);
    }

    /**
     * @param  FilterConfiguratorI18n $filterConfiguratorI18n The filterConfiguratorI18n object to remove.
     * @return ChildFilterConfigurator The current object (for fluent API support)
     */
    public function removeFilterConfiguratorI18n($filterConfiguratorI18n)
    {
        if ($this->getFilterConfiguratorI18ns()->contains($filterConfiguratorI18n)) {
            $this->collFilterConfiguratorI18ns->remove($this->collFilterConfiguratorI18ns->search($filterConfiguratorI18n));
            if (null === $this->filterConfiguratorI18nsScheduledForDeletion) {
                $this->filterConfiguratorI18nsScheduledForDeletion = clone $this->collFilterConfiguratorI18ns;
                $this->filterConfiguratorI18nsScheduledForDeletion->clear();
            }
            $this->filterConfiguratorI18nsScheduledForDeletion[]= clone $filterConfiguratorI18n;
            $filterConfiguratorI18n->setFilterConfigurator(null);
        }

        return $this;
    }

    /**
     * Clears out the collFilterConfiguratorImages collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addFilterConfiguratorImages()
     */
    public function clearFilterConfiguratorImages()
    {
        $this->collFilterConfiguratorImages = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collFilterConfiguratorImages collection loaded partially.
     */
    public function resetPartialFilterConfiguratorImages($v = true)
    {
        $this->collFilterConfiguratorImagesPartial = $v;
    }

    /**
     * Initializes the collFilterConfiguratorImages collection.
     *
     * By default this just sets the collFilterConfiguratorImages collection to an empty array (like clearcollFilterConfiguratorImages());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initFilterConfiguratorImages($overrideExisting = true)
    {
        if (null !== $this->collFilterConfiguratorImages && !$overrideExisting) {
            return;
        }
        $this->collFilterConfiguratorImages = new ObjectCollection();
        $this->collFilterConfiguratorImages->setModel('\FilterConfigurator\Model\FilterConfiguratorImage');
    }

    /**
     * Gets an array of ChildFilterConfiguratorImage objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildFilterConfigurator is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return Collection|ChildFilterConfiguratorImage[] List of ChildFilterConfiguratorImage objects
     * @throws PropelException
     */
    public function getFilterConfiguratorImages($criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collFilterConfiguratorImagesPartial && !$this->isNew();
        if (null === $this->collFilterConfiguratorImages || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collFilterConfiguratorImages) {
                // return empty collection
                $this->initFilterConfiguratorImages();
            } else {
                $collFilterConfiguratorImages = ChildFilterConfiguratorImageQuery::create(null, $criteria)
                    ->filterByFilterConfigurator($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collFilterConfiguratorImagesPartial && count($collFilterConfiguratorImages)) {
                        $this->initFilterConfiguratorImages(false);

                        foreach ($collFilterConfiguratorImages as $obj) {
                            if (false == $this->collFilterConfiguratorImages->contains($obj)) {
                                $this->collFilterConfiguratorImages->append($obj);
                            }
                        }

                        $this->collFilterConfiguratorImagesPartial = true;
                    }

                    reset($collFilterConfiguratorImages);

                    return $collFilterConfiguratorImages;
                }

                if ($partial && $this->collFilterConfiguratorImages) {
                    foreach ($this->collFilterConfiguratorImages as $obj) {
                        if ($obj->isNew()) {
                            $collFilterConfiguratorImages[] = $obj;
                        }
                    }
                }

                $this->collFilterConfiguratorImages = $collFilterConfiguratorImages;
                $this->collFilterConfiguratorImagesPartial = false;
            }
        }

        return $this->collFilterConfiguratorImages;
    }

    /**
     * Sets a collection of FilterConfiguratorImage objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $filterConfiguratorImages A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return   ChildFilterConfigurator The current object (for fluent API support)
     */
    public function setFilterConfiguratorImages(Collection $filterConfiguratorImages, ConnectionInterface $con = null)
    {
        $filterConfiguratorImagesToDelete = $this->getFilterConfiguratorImages(new Criteria(), $con)->diff($filterConfiguratorImages);

        
        $this->filterConfiguratorImagesScheduledForDeletion = $filterConfiguratorImagesToDelete;

        foreach ($filterConfiguratorImagesToDelete as $filterConfiguratorImageRemoved) {
            $filterConfiguratorImageRemoved->setFilterConfigurator(null);
        }

        $this->collFilterConfiguratorImages = null;
        foreach ($filterConfiguratorImages as $filterConfiguratorImage) {
            $this->addFilterConfiguratorImage($filterConfiguratorImage);
        }

        $this->collFilterConfiguratorImages = $filterConfiguratorImages;
        $this->collFilterConfiguratorImagesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related FilterConfiguratorImage objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related FilterConfiguratorImage objects.
     * @throws PropelException
     */
    public function countFilterConfiguratorImages(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collFilterConfiguratorImagesPartial && !$this->isNew();
        if (null === $this->collFilterConfiguratorImages || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collFilterConfiguratorImages) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getFilterConfiguratorImages());
            }

            $query = ChildFilterConfiguratorImageQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByFilterConfigurator($this)
                ->count($con);
        }

        return count($this->collFilterConfiguratorImages);
    }

    /**
     * Method called to associate a ChildFilterConfiguratorImage object to this object
     * through the ChildFilterConfiguratorImage foreign key attribute.
     *
     * @param    ChildFilterConfiguratorImage $l ChildFilterConfiguratorImage
     * @return   \FilterConfigurator\Model\FilterConfigurator The current object (for fluent API support)
     */
    public function addFilterConfiguratorImage(ChildFilterConfiguratorImage $l)
    {
        if ($this->collFilterConfiguratorImages === null) {
            $this->initFilterConfiguratorImages();
            $this->collFilterConfiguratorImagesPartial = true;
        }

        if (!in_array($l, $this->collFilterConfiguratorImages->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddFilterConfiguratorImage($l);
        }

        return $this;
    }

    /**
     * @param FilterConfiguratorImage $filterConfiguratorImage The filterConfiguratorImage object to add.
     */
    protected function doAddFilterConfiguratorImage($filterConfiguratorImage)
    {
        $this->collFilterConfiguratorImages[]= $filterConfiguratorImage;
        $filterConfiguratorImage->setFilterConfigurator($this);
    }

    /**
     * @param  FilterConfiguratorImage $filterConfiguratorImage The filterConfiguratorImage object to remove.
     * @return ChildFilterConfigurator The current object (for fluent API support)
     */
    public function removeFilterConfiguratorImage($filterConfiguratorImage)
    {
        if ($this->getFilterConfiguratorImages()->contains($filterConfiguratorImage)) {
            $this->collFilterConfiguratorImages->remove($this->collFilterConfiguratorImages->search($filterConfiguratorImage));
            if (null === $this->filterConfiguratorImagesScheduledForDeletion) {
                $this->filterConfiguratorImagesScheduledForDeletion = clone $this->collFilterConfiguratorImages;
                $this->filterConfiguratorImagesScheduledForDeletion->clear();
            }
            $this->filterConfiguratorImagesScheduledForDeletion[]= clone $filterConfiguratorImage;
            $filterConfiguratorImage->setFilterConfigurator(null);
        }

        return $this;
    }

    /**
     * Clears out the collFilterConfiguratorFeaturess collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addFilterConfiguratorFeaturess()
     */
    public function clearFilterConfiguratorFeaturess()
    {
        $this->collFilterConfiguratorFeaturess = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collFilterConfiguratorFeaturess collection loaded partially.
     */
    public function resetPartialFilterConfiguratorFeaturess($v = true)
    {
        $this->collFilterConfiguratorFeaturessPartial = $v;
    }

    /**
     * Initializes the collFilterConfiguratorFeaturess collection.
     *
     * By default this just sets the collFilterConfiguratorFeaturess collection to an empty array (like clearcollFilterConfiguratorFeaturess());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initFilterConfiguratorFeaturess($overrideExisting = true)
    {
        if (null !== $this->collFilterConfiguratorFeaturess && !$overrideExisting) {
            return;
        }
        $this->collFilterConfiguratorFeaturess = new ObjectCollection();
        $this->collFilterConfiguratorFeaturess->setModel('\FilterConfigurator\Model\FilterConfiguratorFeatures');
    }

    /**
     * Gets an array of ChildFilterConfiguratorFeatures objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildFilterConfigurator is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return Collection|ChildFilterConfiguratorFeatures[] List of ChildFilterConfiguratorFeatures objects
     * @throws PropelException
     */
    public function getFilterConfiguratorFeaturess($criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collFilterConfiguratorFeaturessPartial && !$this->isNew();
        if (null === $this->collFilterConfiguratorFeaturess || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collFilterConfiguratorFeaturess) {
                // return empty collection
                $this->initFilterConfiguratorFeaturess();
            } else {
                $collFilterConfiguratorFeaturess = ChildFilterConfiguratorFeaturesQuery::create(null, $criteria)
                    ->filterByFilterConfigurator($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collFilterConfiguratorFeaturessPartial && count($collFilterConfiguratorFeaturess)) {
                        $this->initFilterConfiguratorFeaturess(false);

                        foreach ($collFilterConfiguratorFeaturess as $obj) {
                            if (false == $this->collFilterConfiguratorFeaturess->contains($obj)) {
                                $this->collFilterConfiguratorFeaturess->append($obj);
                            }
                        }

                        $this->collFilterConfiguratorFeaturessPartial = true;
                    }

                    reset($collFilterConfiguratorFeaturess);

                    return $collFilterConfiguratorFeaturess;
                }

                if ($partial && $this->collFilterConfiguratorFeaturess) {
                    foreach ($this->collFilterConfiguratorFeaturess as $obj) {
                        if ($obj->isNew()) {
                            $collFilterConfiguratorFeaturess[] = $obj;
                        }
                    }
                }

                $this->collFilterConfiguratorFeaturess = $collFilterConfiguratorFeaturess;
                $this->collFilterConfiguratorFeaturessPartial = false;
            }
        }

        return $this->collFilterConfiguratorFeaturess;
    }

    /**
     * Sets a collection of FilterConfiguratorFeatures objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $filterConfiguratorFeaturess A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return   ChildFilterConfigurator The current object (for fluent API support)
     */
    public function setFilterConfiguratorFeaturess(Collection $filterConfiguratorFeaturess, ConnectionInterface $con = null)
    {
        $filterConfiguratorFeaturessToDelete = $this->getFilterConfiguratorFeaturess(new Criteria(), $con)->diff($filterConfiguratorFeaturess);

        
        $this->filterConfiguratorFeaturessScheduledForDeletion = $filterConfiguratorFeaturessToDelete;

        foreach ($filterConfiguratorFeaturessToDelete as $filterConfiguratorFeaturesRemoved) {
            $filterConfiguratorFeaturesRemoved->setFilterConfigurator(null);
        }

        $this->collFilterConfiguratorFeaturess = null;
        foreach ($filterConfiguratorFeaturess as $filterConfiguratorFeatures) {
            $this->addFilterConfiguratorFeatures($filterConfiguratorFeatures);
        }

        $this->collFilterConfiguratorFeaturess = $filterConfiguratorFeaturess;
        $this->collFilterConfiguratorFeaturessPartial = false;

        return $this;
    }

    /**
     * Returns the number of related FilterConfiguratorFeatures objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related FilterConfiguratorFeatures objects.
     * @throws PropelException
     */
    public function countFilterConfiguratorFeaturess(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collFilterConfiguratorFeaturessPartial && !$this->isNew();
        if (null === $this->collFilterConfiguratorFeaturess || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collFilterConfiguratorFeaturess) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getFilterConfiguratorFeaturess());
            }

            $query = ChildFilterConfiguratorFeaturesQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByFilterConfigurator($this)
                ->count($con);
        }

        return count($this->collFilterConfiguratorFeaturess);
    }

    /**
     * Method called to associate a ChildFilterConfiguratorFeatures object to this object
     * through the ChildFilterConfiguratorFeatures foreign key attribute.
     *
     * @param    ChildFilterConfiguratorFeatures $l ChildFilterConfiguratorFeatures
     * @return   \FilterConfigurator\Model\FilterConfigurator The current object (for fluent API support)
     */
    public function addFilterConfiguratorFeatures(ChildFilterConfiguratorFeatures $l)
    {
        if ($this->collFilterConfiguratorFeaturess === null) {
            $this->initFilterConfiguratorFeaturess();
            $this->collFilterConfiguratorFeaturessPartial = true;
        }

        if (!in_array($l, $this->collFilterConfiguratorFeaturess->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddFilterConfiguratorFeatures($l);
        }

        return $this;
    }

    /**
     * @param FilterConfiguratorFeatures $filterConfiguratorFeatures The filterConfiguratorFeatures object to add.
     */
    protected function doAddFilterConfiguratorFeatures($filterConfiguratorFeatures)
    {
        $this->collFilterConfiguratorFeaturess[]= $filterConfiguratorFeatures;
        $filterConfiguratorFeatures->setFilterConfigurator($this);
    }

    /**
     * @param  FilterConfiguratorFeatures $filterConfiguratorFeatures The filterConfiguratorFeatures object to remove.
     * @return ChildFilterConfigurator The current object (for fluent API support)
     */
    public function removeFilterConfiguratorFeatures($filterConfiguratorFeatures)
    {
        if ($this->getFilterConfiguratorFeaturess()->contains($filterConfiguratorFeatures)) {
            $this->collFilterConfiguratorFeaturess->remove($this->collFilterConfiguratorFeaturess->search($filterConfiguratorFeatures));
            if (null === $this->filterConfiguratorFeaturessScheduledForDeletion) {
                $this->filterConfiguratorFeaturessScheduledForDeletion = clone $this->collFilterConfiguratorFeaturess;
                $this->filterConfiguratorFeaturessScheduledForDeletion->clear();
            }
            $this->filterConfiguratorFeaturessScheduledForDeletion[]= $filterConfiguratorFeatures;
            $filterConfiguratorFeatures->setFilterConfigurator(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this FilterConfigurator is new, it will return
     * an empty collection; or if this FilterConfigurator has previously
     * been saved, it will retrieve related FilterConfiguratorFeaturess from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in FilterConfigurator.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return Collection|ChildFilterConfiguratorFeatures[] List of ChildFilterConfiguratorFeatures objects
     */
    public function getFilterConfiguratorFeaturessJoinFeature($criteria = null, $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildFilterConfiguratorFeaturesQuery::create(null, $criteria);
        $query->joinWith('Feature', $joinBehavior);

        return $this->getFilterConfiguratorFeaturess($query, $con);
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->id = null;
        $this->category_id = null;
        $this->visible = null;
        $this->position = null;
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
            if ($this->collFilterConfiguratorHooks) {
                foreach ($this->collFilterConfiguratorHooks as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collFilterConfiguratorI18ns) {
                foreach ($this->collFilterConfiguratorI18ns as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collFilterConfiguratorImages) {
                foreach ($this->collFilterConfiguratorImages as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collFilterConfiguratorFeaturess) {
                foreach ($this->collFilterConfiguratorFeaturess as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collFilterConfiguratorHooks = null;
        $this->collFilterConfiguratorI18ns = null;
        $this->collFilterConfiguratorImages = null;
        $this->collFilterConfiguratorFeaturess = null;
        $this->aCategory = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(FilterConfiguratorTableMap::DEFAULT_STRING_FORMAT);
    }

    // timestampable behavior
    
    /**
     * Mark the current object so that the update date doesn't get updated during next save
     *
     * @return     ChildFilterConfigurator The current object (for fluent API support)
     */
    public function keepUpdateDateUnchanged()
    {
        $this->modifiedColumns[FilterConfiguratorTableMap::UPDATED_AT] = true;
    
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
