<?php

namespace FilterConfigurator\Model\Base;

use \DateTime;
use \Exception;
use \PDO;
use FilterConfigurator\Model\Configurator as ChildConfigurator;
use FilterConfigurator\Model\ConfiguratorImage as ChildConfiguratorImage;
use FilterConfigurator\Model\ConfiguratorImageI18n as ChildConfiguratorImageI18n;
use FilterConfigurator\Model\ConfiguratorImageI18nQuery as ChildConfiguratorImageI18nQuery;
use FilterConfigurator\Model\ConfiguratorImageQuery as ChildConfiguratorImageQuery;
use FilterConfigurator\Model\ConfiguratorQuery as ChildConfiguratorQuery;
use FilterConfigurator\Model\Map\ConfiguratorImageTableMap;
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

abstract class ConfiguratorImage implements ActiveRecordInterface 
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\FilterConfigurator\\Model\\Map\\ConfiguratorImageTableMap';


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
     * The value for the configurator_id field.
     * @var        int
     */
    protected $configurator_id;

    /**
     * The value for the file field.
     * @var        string
     */
    protected $file;

    /**
     * The value for the visible field.
     * Note: this column has a database default value of: 1
     * @var        int
     */
    protected $visible;

    /**
     * The value for the position field.
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
     * @var        Configurator
     */
    protected $aConfigurator;

    /**
     * @var        ObjectCollection|ChildConfiguratorImageI18n[] Collection to store aggregation of ChildConfiguratorImageI18n objects.
     */
    protected $collConfiguratorImageI18ns;
    protected $collConfiguratorImageI18nsPartial;

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
    protected $configuratorImageI18nsScheduledForDeletion = null;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see __construct()
     */
    public function applyDefaultValues()
    {
        $this->visible = 1;
    }

    /**
     * Initializes internal state of FilterConfigurator\Model\Base\ConfiguratorImage object.
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
     * Compares this with another <code>ConfiguratorImage</code> instance.  If
     * <code>obj</code> is an instance of <code>ConfiguratorImage</code>, delegates to
     * <code>equals(ConfiguratorImage)</code>.  Otherwise, returns <code>false</code>.
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
     * @return ConfiguratorImage The current object, for fluid interface
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
     * @return ConfiguratorImage The current object, for fluid interface
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
     * Get the [configurator_id] column value.
     * 
     * @return   int
     */
    public function getConfiguratorId()
    {

        return $this->configurator_id;
    }

    /**
     * Get the [file] column value.
     * 
     * @return   string
     */
    public function getFile()
    {

        return $this->file;
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
     * @return   \FilterConfigurator\Model\ConfiguratorImage The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[ConfiguratorImageTableMap::ID] = true;
        }


        return $this;
    } // setId()

    /**
     * Set the value of [configurator_id] column.
     * 
     * @param      int $v new value
     * @return   \FilterConfigurator\Model\ConfiguratorImage The current object (for fluent API support)
     */
    public function setConfiguratorId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->configurator_id !== $v) {
            $this->configurator_id = $v;
            $this->modifiedColumns[ConfiguratorImageTableMap::CONFIGURATOR_ID] = true;
        }

        if ($this->aConfigurator !== null && $this->aConfigurator->getId() !== $v) {
            $this->aConfigurator = null;
        }


        return $this;
    } // setConfiguratorId()

    /**
     * Set the value of [file] column.
     * 
     * @param      string $v new value
     * @return   \FilterConfigurator\Model\ConfiguratorImage The current object (for fluent API support)
     */
    public function setFile($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->file !== $v) {
            $this->file = $v;
            $this->modifiedColumns[ConfiguratorImageTableMap::FILE] = true;
        }


        return $this;
    } // setFile()

    /**
     * Set the value of [visible] column.
     * 
     * @param      int $v new value
     * @return   \FilterConfigurator\Model\ConfiguratorImage The current object (for fluent API support)
     */
    public function setVisible($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->visible !== $v) {
            $this->visible = $v;
            $this->modifiedColumns[ConfiguratorImageTableMap::VISIBLE] = true;
        }


        return $this;
    } // setVisible()

    /**
     * Set the value of [position] column.
     * 
     * @param      int $v new value
     * @return   \FilterConfigurator\Model\ConfiguratorImage The current object (for fluent API support)
     */
    public function setPosition($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->position !== $v) {
            $this->position = $v;
            $this->modifiedColumns[ConfiguratorImageTableMap::POSITION] = true;
        }


        return $this;
    } // setPosition()

    /**
     * Sets the value of [created_at] column to a normalized version of the date/time value specified.
     * 
     * @param      mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return   \FilterConfigurator\Model\ConfiguratorImage The current object (for fluent API support)
     */
    public function setCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->created_at !== null || $dt !== null) {
            if ($dt !== $this->created_at) {
                $this->created_at = $dt;
                $this->modifiedColumns[ConfiguratorImageTableMap::CREATED_AT] = true;
            }
        } // if either are not null


        return $this;
    } // setCreatedAt()

    /**
     * Sets the value of [updated_at] column to a normalized version of the date/time value specified.
     * 
     * @param      mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return   \FilterConfigurator\Model\ConfiguratorImage The current object (for fluent API support)
     */
    public function setUpdatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->updated_at !== null || $dt !== null) {
            if ($dt !== $this->updated_at) {
                $this->updated_at = $dt;
                $this->modifiedColumns[ConfiguratorImageTableMap::UPDATED_AT] = true;
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
            if ($this->visible !== 1) {
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


            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : ConfiguratorImageTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : ConfiguratorImageTableMap::translateFieldName('ConfiguratorId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->configurator_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : ConfiguratorImageTableMap::translateFieldName('File', TableMap::TYPE_PHPNAME, $indexType)];
            $this->file = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : ConfiguratorImageTableMap::translateFieldName('Visible', TableMap::TYPE_PHPNAME, $indexType)];
            $this->visible = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : ConfiguratorImageTableMap::translateFieldName('Position', TableMap::TYPE_PHPNAME, $indexType)];
            $this->position = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : ConfiguratorImageTableMap::translateFieldName('CreatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->created_at = (null !== $col) ? PropelDateTime::newInstance($col, null, '\DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : ConfiguratorImageTableMap::translateFieldName('UpdatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->updated_at = (null !== $col) ? PropelDateTime::newInstance($col, null, '\DateTime') : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 7; // 7 = ConfiguratorImageTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating \FilterConfigurator\Model\ConfiguratorImage object", 0, $e);
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
        if ($this->aConfigurator !== null && $this->configurator_id !== $this->aConfigurator->getId()) {
            $this->aConfigurator = null;
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
            $con = Propel::getServiceContainer()->getReadConnection(ConfiguratorImageTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildConfiguratorImageQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aConfigurator = null;
            $this->collConfiguratorImageI18ns = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see ConfiguratorImage::setDeleted()
     * @see ConfiguratorImage::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(ConfiguratorImageTableMap::DATABASE_NAME);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = ChildConfiguratorImageQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(ConfiguratorImageTableMap::DATABASE_NAME);
        }

        $con->beginTransaction();
        $isInsert = $this->isNew();
        try {
            $ret = $this->preSave($con);
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
                // timestampable behavior
                if (!$this->isColumnModified(ConfiguratorImageTableMap::CREATED_AT)) {
                    $this->setCreatedAt(time());
                }
                if (!$this->isColumnModified(ConfiguratorImageTableMap::UPDATED_AT)) {
                    $this->setUpdatedAt(time());
                }
            } else {
                $ret = $ret && $this->preUpdate($con);
                // timestampable behavior
                if ($this->isModified() && !$this->isColumnModified(ConfiguratorImageTableMap::UPDATED_AT)) {
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
                ConfiguratorImageTableMap::addInstanceToPool($this);
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

            if ($this->aConfigurator !== null) {
                if ($this->aConfigurator->isModified() || $this->aConfigurator->isNew()) {
                    $affectedRows += $this->aConfigurator->save($con);
                }
                $this->setConfigurator($this->aConfigurator);
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

            if ($this->configuratorImageI18nsScheduledForDeletion !== null) {
                if (!$this->configuratorImageI18nsScheduledForDeletion->isEmpty()) {
                    \FilterConfigurator\Model\ConfiguratorImageI18nQuery::create()
                        ->filterByPrimaryKeys($this->configuratorImageI18nsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->configuratorImageI18nsScheduledForDeletion = null;
                }
            }

                if ($this->collConfiguratorImageI18ns !== null) {
            foreach ($this->collConfiguratorImageI18ns as $referrerFK) {
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

        $this->modifiedColumns[ConfiguratorImageTableMap::ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . ConfiguratorImageTableMap::ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(ConfiguratorImageTableMap::ID)) {
            $modifiedColumns[':p' . $index++]  = 'ID';
        }
        if ($this->isColumnModified(ConfiguratorImageTableMap::CONFIGURATOR_ID)) {
            $modifiedColumns[':p' . $index++]  = 'CONFIGURATOR_ID';
        }
        if ($this->isColumnModified(ConfiguratorImageTableMap::FILE)) {
            $modifiedColumns[':p' . $index++]  = 'FILE';
        }
        if ($this->isColumnModified(ConfiguratorImageTableMap::VISIBLE)) {
            $modifiedColumns[':p' . $index++]  = 'VISIBLE';
        }
        if ($this->isColumnModified(ConfiguratorImageTableMap::POSITION)) {
            $modifiedColumns[':p' . $index++]  = 'POSITION';
        }
        if ($this->isColumnModified(ConfiguratorImageTableMap::CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'CREATED_AT';
        }
        if ($this->isColumnModified(ConfiguratorImageTableMap::UPDATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'UPDATED_AT';
        }

        $sql = sprintf(
            'INSERT INTO filterconfigurator_configurator_image (%s) VALUES (%s)',
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
                    case 'CONFIGURATOR_ID':                        
                        $stmt->bindValue($identifier, $this->configurator_id, PDO::PARAM_INT);
                        break;
                    case 'FILE':                        
                        $stmt->bindValue($identifier, $this->file, PDO::PARAM_STR);
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
        $pos = ConfiguratorImageTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getConfiguratorId();
                break;
            case 2:
                return $this->getFile();
                break;
            case 3:
                return $this->getVisible();
                break;
            case 4:
                return $this->getPosition();
                break;
            case 5:
                return $this->getCreatedAt();
                break;
            case 6:
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
        if (isset($alreadyDumpedObjects['ConfiguratorImage'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['ConfiguratorImage'][$this->getPrimaryKey()] = true;
        $keys = ConfiguratorImageTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getConfiguratorId(),
            $keys[2] => $this->getFile(),
            $keys[3] => $this->getVisible(),
            $keys[4] => $this->getPosition(),
            $keys[5] => $this->getCreatedAt(),
            $keys[6] => $this->getUpdatedAt(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }
        
        if ($includeForeignObjects) {
            if (null !== $this->aConfigurator) {
                $result['Configurator'] = $this->aConfigurator->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collConfiguratorImageI18ns) {
                $result['ConfiguratorImageI18ns'] = $this->collConfiguratorImageI18ns->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
        $pos = ConfiguratorImageTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

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
                $this->setConfiguratorId($value);
                break;
            case 2:
                $this->setFile($value);
                break;
            case 3:
                $this->setVisible($value);
                break;
            case 4:
                $this->setPosition($value);
                break;
            case 5:
                $this->setCreatedAt($value);
                break;
            case 6:
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
        $keys = ConfiguratorImageTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setConfiguratorId($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setFile($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setVisible($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setPosition($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setCreatedAt($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setUpdatedAt($arr[$keys[6]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(ConfiguratorImageTableMap::DATABASE_NAME);

        if ($this->isColumnModified(ConfiguratorImageTableMap::ID)) $criteria->add(ConfiguratorImageTableMap::ID, $this->id);
        if ($this->isColumnModified(ConfiguratorImageTableMap::CONFIGURATOR_ID)) $criteria->add(ConfiguratorImageTableMap::CONFIGURATOR_ID, $this->configurator_id);
        if ($this->isColumnModified(ConfiguratorImageTableMap::FILE)) $criteria->add(ConfiguratorImageTableMap::FILE, $this->file);
        if ($this->isColumnModified(ConfiguratorImageTableMap::VISIBLE)) $criteria->add(ConfiguratorImageTableMap::VISIBLE, $this->visible);
        if ($this->isColumnModified(ConfiguratorImageTableMap::POSITION)) $criteria->add(ConfiguratorImageTableMap::POSITION, $this->position);
        if ($this->isColumnModified(ConfiguratorImageTableMap::CREATED_AT)) $criteria->add(ConfiguratorImageTableMap::CREATED_AT, $this->created_at);
        if ($this->isColumnModified(ConfiguratorImageTableMap::UPDATED_AT)) $criteria->add(ConfiguratorImageTableMap::UPDATED_AT, $this->updated_at);

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
        $criteria = new Criteria(ConfiguratorImageTableMap::DATABASE_NAME);
        $criteria->add(ConfiguratorImageTableMap::ID, $this->id);

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
     * @param      object $copyObj An object of \FilterConfigurator\Model\ConfiguratorImage (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setConfiguratorId($this->getConfiguratorId());
        $copyObj->setFile($this->getFile());
        $copyObj->setVisible($this->getVisible());
        $copyObj->setPosition($this->getPosition());
        $copyObj->setCreatedAt($this->getCreatedAt());
        $copyObj->setUpdatedAt($this->getUpdatedAt());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getConfiguratorImageI18ns() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addConfiguratorImageI18n($relObj->copy($deepCopy));
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
     * @return                 \FilterConfigurator\Model\ConfiguratorImage Clone of current object.
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
     * Declares an association between this object and a ChildConfigurator object.
     *
     * @param                  ChildConfigurator $v
     * @return                 \FilterConfigurator\Model\ConfiguratorImage The current object (for fluent API support)
     * @throws PropelException
     */
    public function setConfigurator(ChildConfigurator $v = null)
    {
        if ($v === null) {
            $this->setConfiguratorId(NULL);
        } else {
            $this->setConfiguratorId($v->getId());
        }

        $this->aConfigurator = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildConfigurator object, it will not be re-added.
        if ($v !== null) {
            $v->addConfiguratorImage($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildConfigurator object
     *
     * @param      ConnectionInterface $con Optional Connection object.
     * @return                 ChildConfigurator The associated ChildConfigurator object.
     * @throws PropelException
     */
    public function getConfigurator(ConnectionInterface $con = null)
    {
        if ($this->aConfigurator === null && ($this->configurator_id !== null)) {
            $this->aConfigurator = ChildConfiguratorQuery::create()->findPk($this->configurator_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aConfigurator->addConfiguratorImages($this);
             */
        }

        return $this->aConfigurator;
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
        if ('ConfiguratorImageI18n' == $relationName) {
            return $this->initConfiguratorImageI18ns();
        }
    }

    /**
     * Clears out the collConfiguratorImageI18ns collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addConfiguratorImageI18ns()
     */
    public function clearConfiguratorImageI18ns()
    {
        $this->collConfiguratorImageI18ns = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collConfiguratorImageI18ns collection loaded partially.
     */
    public function resetPartialConfiguratorImageI18ns($v = true)
    {
        $this->collConfiguratorImageI18nsPartial = $v;
    }

    /**
     * Initializes the collConfiguratorImageI18ns collection.
     *
     * By default this just sets the collConfiguratorImageI18ns collection to an empty array (like clearcollConfiguratorImageI18ns());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initConfiguratorImageI18ns($overrideExisting = true)
    {
        if (null !== $this->collConfiguratorImageI18ns && !$overrideExisting) {
            return;
        }
        $this->collConfiguratorImageI18ns = new ObjectCollection();
        $this->collConfiguratorImageI18ns->setModel('\FilterConfigurator\Model\ConfiguratorImageI18n');
    }

    /**
     * Gets an array of ChildConfiguratorImageI18n objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildConfiguratorImage is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return Collection|ChildConfiguratorImageI18n[] List of ChildConfiguratorImageI18n objects
     * @throws PropelException
     */
    public function getConfiguratorImageI18ns($criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collConfiguratorImageI18nsPartial && !$this->isNew();
        if (null === $this->collConfiguratorImageI18ns || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collConfiguratorImageI18ns) {
                // return empty collection
                $this->initConfiguratorImageI18ns();
            } else {
                $collConfiguratorImageI18ns = ChildConfiguratorImageI18nQuery::create(null, $criteria)
                    ->filterByConfiguratorImage($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collConfiguratorImageI18nsPartial && count($collConfiguratorImageI18ns)) {
                        $this->initConfiguratorImageI18ns(false);

                        foreach ($collConfiguratorImageI18ns as $obj) {
                            if (false == $this->collConfiguratorImageI18ns->contains($obj)) {
                                $this->collConfiguratorImageI18ns->append($obj);
                            }
                        }

                        $this->collConfiguratorImageI18nsPartial = true;
                    }

                    reset($collConfiguratorImageI18ns);

                    return $collConfiguratorImageI18ns;
                }

                if ($partial && $this->collConfiguratorImageI18ns) {
                    foreach ($this->collConfiguratorImageI18ns as $obj) {
                        if ($obj->isNew()) {
                            $collConfiguratorImageI18ns[] = $obj;
                        }
                    }
                }

                $this->collConfiguratorImageI18ns = $collConfiguratorImageI18ns;
                $this->collConfiguratorImageI18nsPartial = false;
            }
        }

        return $this->collConfiguratorImageI18ns;
    }

    /**
     * Sets a collection of ConfiguratorImageI18n objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $configuratorImageI18ns A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return   ChildConfiguratorImage The current object (for fluent API support)
     */
    public function setConfiguratorImageI18ns(Collection $configuratorImageI18ns, ConnectionInterface $con = null)
    {
        $configuratorImageI18nsToDelete = $this->getConfiguratorImageI18ns(new Criteria(), $con)->diff($configuratorImageI18ns);

        
        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->configuratorImageI18nsScheduledForDeletion = clone $configuratorImageI18nsToDelete;

        foreach ($configuratorImageI18nsToDelete as $configuratorImageI18nRemoved) {
            $configuratorImageI18nRemoved->setConfiguratorImage(null);
        }

        $this->collConfiguratorImageI18ns = null;
        foreach ($configuratorImageI18ns as $configuratorImageI18n) {
            $this->addConfiguratorImageI18n($configuratorImageI18n);
        }

        $this->collConfiguratorImageI18ns = $configuratorImageI18ns;
        $this->collConfiguratorImageI18nsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related ConfiguratorImageI18n objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related ConfiguratorImageI18n objects.
     * @throws PropelException
     */
    public function countConfiguratorImageI18ns(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collConfiguratorImageI18nsPartial && !$this->isNew();
        if (null === $this->collConfiguratorImageI18ns || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collConfiguratorImageI18ns) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getConfiguratorImageI18ns());
            }

            $query = ChildConfiguratorImageI18nQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByConfiguratorImage($this)
                ->count($con);
        }

        return count($this->collConfiguratorImageI18ns);
    }

    /**
     * Method called to associate a ChildConfiguratorImageI18n object to this object
     * through the ChildConfiguratorImageI18n foreign key attribute.
     *
     * @param    ChildConfiguratorImageI18n $l ChildConfiguratorImageI18n
     * @return   \FilterConfigurator\Model\ConfiguratorImage The current object (for fluent API support)
     */
    public function addConfiguratorImageI18n(ChildConfiguratorImageI18n $l)
    {
        if ($this->collConfiguratorImageI18ns === null) {
            $this->initConfiguratorImageI18ns();
            $this->collConfiguratorImageI18nsPartial = true;
        }

        if (!in_array($l, $this->collConfiguratorImageI18ns->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddConfiguratorImageI18n($l);
        }

        return $this;
    }

    /**
     * @param ConfiguratorImageI18n $configuratorImageI18n The configuratorImageI18n object to add.
     */
    protected function doAddConfiguratorImageI18n($configuratorImageI18n)
    {
        $this->collConfiguratorImageI18ns[]= $configuratorImageI18n;
        $configuratorImageI18n->setConfiguratorImage($this);
    }

    /**
     * @param  ConfiguratorImageI18n $configuratorImageI18n The configuratorImageI18n object to remove.
     * @return ChildConfiguratorImage The current object (for fluent API support)
     */
    public function removeConfiguratorImageI18n($configuratorImageI18n)
    {
        if ($this->getConfiguratorImageI18ns()->contains($configuratorImageI18n)) {
            $this->collConfiguratorImageI18ns->remove($this->collConfiguratorImageI18ns->search($configuratorImageI18n));
            if (null === $this->configuratorImageI18nsScheduledForDeletion) {
                $this->configuratorImageI18nsScheduledForDeletion = clone $this->collConfiguratorImageI18ns;
                $this->configuratorImageI18nsScheduledForDeletion->clear();
            }
            $this->configuratorImageI18nsScheduledForDeletion[]= clone $configuratorImageI18n;
            $configuratorImageI18n->setConfiguratorImage(null);
        }

        return $this;
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->id = null;
        $this->configurator_id = null;
        $this->file = null;
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
            if ($this->collConfiguratorImageI18ns) {
                foreach ($this->collConfiguratorImageI18ns as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collConfiguratorImageI18ns = null;
        $this->aConfigurator = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(ConfiguratorImageTableMap::DEFAULT_STRING_FORMAT);
    }

    // timestampable behavior
    
    /**
     * Mark the current object so that the update date doesn't get updated during next save
     *
     * @return     ChildConfiguratorImage The current object (for fluent API support)
     */
    public function keepUpdateDateUnchanged()
    {
        $this->modifiedColumns[ConfiguratorImageTableMap::UPDATED_AT] = true;
    
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
