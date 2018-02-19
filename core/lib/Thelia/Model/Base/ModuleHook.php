<?php

namespace Thelia\Model\Base;

use \Exception;
use \PDO;
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
use Thelia\Model\Hook as ChildHook;
use Thelia\Model\HookQuery as ChildHookQuery;
use Thelia\Model\Module as ChildModule;
use Thelia\Model\ModuleHookQuery as ChildModuleHookQuery;
use Thelia\Model\ModuleQuery as ChildModuleQuery;
use Thelia\Model\Map\ModuleHookTableMap;

abstract class ModuleHook implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Thelia\\Model\\Map\\ModuleHookTableMap';


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
     * The value for the module_id field.
     * @var        int
     */
    protected $module_id;

    /**
     * The value for the hook_id field.
     * @var        int
     */
    protected $hook_id;

    /**
     * The value for the classname field.
     * @var        string
     */
    protected $classname;

    /**
     * The value for the method field.
     * @var        string
     */
    protected $method;

    /**
     * The value for the active field.
     * @var        boolean
     */
    protected $active;

    /**
     * The value for the hook_active field.
     * @var        boolean
     */
    protected $hook_active;

    /**
     * The value for the module_active field.
     * @var        boolean
     */
    protected $module_active;

    /**
     * The value for the position field.
     * @var        int
     */
    protected $position;

    /**
     * The value for the templates field.
     * @var        string
     */
    protected $templates;

    /**
     * @var        Module
     */
    protected $aModule;

    /**
     * @var        Hook
     */
    protected $aHook;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * Initializes internal state of Thelia\Model\Base\ModuleHook object.
     */
    public function __construct()
    {
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
     * Compares this with another <code>ModuleHook</code> instance.  If
     * <code>obj</code> is an instance of <code>ModuleHook</code>, delegates to
     * <code>equals(ModuleHook)</code>.  Otherwise, returns <code>false</code>.
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
     * @return ModuleHook The current object, for fluid interface
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
     * @return ModuleHook The current object, for fluid interface
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
     * Get the [module_id] column value.
     *
     * @return   int
     */
    public function getModuleId()
    {

        return $this->module_id;
    }

    /**
     * Get the [hook_id] column value.
     *
     * @return   int
     */
    public function getHookId()
    {

        return $this->hook_id;
    }

    /**
     * Get the [classname] column value.
     *
     * @return   string
     */
    public function getClassname()
    {

        return $this->classname;
    }

    /**
     * Get the [method] column value.
     *
     * @return   string
     */
    public function getMethod()
    {

        return $this->method;
    }

    /**
     * Get the [active] column value.
     *
     * @return   boolean
     */
    public function getActive()
    {

        return $this->active;
    }

    /**
     * Get the [hook_active] column value.
     *
     * @return   boolean
     */
    public function getHookActive()
    {

        return $this->hook_active;
    }

    /**
     * Get the [module_active] column value.
     *
     * @return   boolean
     */
    public function getModuleActive()
    {

        return $this->module_active;
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
     * Get the [templates] column value.
     *
     * @return   string
     */
    public function getTemplates()
    {

        return $this->templates;
    }

    /**
     * Set the value of [id] column.
     *
     * @param      int $v new value
     * @return   \Thelia\Model\ModuleHook The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[ModuleHookTableMap::ID] = true;
        }


        return $this;
    } // setId()

    /**
     * Set the value of [module_id] column.
     *
     * @param      int $v new value
     * @return   \Thelia\Model\ModuleHook The current object (for fluent API support)
     */
    public function setModuleId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->module_id !== $v) {
            $this->module_id = $v;
            $this->modifiedColumns[ModuleHookTableMap::MODULE_ID] = true;
        }

        if ($this->aModule !== null && $this->aModule->getId() !== $v) {
            $this->aModule = null;
        }


        return $this;
    } // setModuleId()

    /**
     * Set the value of [hook_id] column.
     *
     * @param      int $v new value
     * @return   \Thelia\Model\ModuleHook The current object (for fluent API support)
     */
    public function setHookId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->hook_id !== $v) {
            $this->hook_id = $v;
            $this->modifiedColumns[ModuleHookTableMap::HOOK_ID] = true;
        }

        if ($this->aHook !== null && $this->aHook->getId() !== $v) {
            $this->aHook = null;
        }


        return $this;
    } // setHookId()

    /**
     * Set the value of [classname] column.
     *
     * @param      string $v new value
     * @return   \Thelia\Model\ModuleHook The current object (for fluent API support)
     */
    public function setClassname($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->classname !== $v) {
            $this->classname = $v;
            $this->modifiedColumns[ModuleHookTableMap::CLASSNAME] = true;
        }


        return $this;
    } // setClassname()

    /**
     * Set the value of [method] column.
     *
     * @param      string $v new value
     * @return   \Thelia\Model\ModuleHook The current object (for fluent API support)
     */
    public function setMethod($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->method !== $v) {
            $this->method = $v;
            $this->modifiedColumns[ModuleHookTableMap::METHOD] = true;
        }


        return $this;
    } // setMethod()

    /**
     * Sets the value of the [active] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param      boolean|integer|string $v The new value
     * @return   \Thelia\Model\ModuleHook The current object (for fluent API support)
     */
    public function setActive($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->active !== $v) {
            $this->active = $v;
            $this->modifiedColumns[ModuleHookTableMap::ACTIVE] = true;
        }


        return $this;
    } // setActive()

    /**
     * Sets the value of the [hook_active] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param      boolean|integer|string $v The new value
     * @return   \Thelia\Model\ModuleHook The current object (for fluent API support)
     */
    public function setHookActive($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->hook_active !== $v) {
            $this->hook_active = $v;
            $this->modifiedColumns[ModuleHookTableMap::HOOK_ACTIVE] = true;
        }


        return $this;
    } // setHookActive()

    /**
     * Sets the value of the [module_active] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param      boolean|integer|string $v The new value
     * @return   \Thelia\Model\ModuleHook The current object (for fluent API support)
     */
    public function setModuleActive($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->module_active !== $v) {
            $this->module_active = $v;
            $this->modifiedColumns[ModuleHookTableMap::MODULE_ACTIVE] = true;
        }


        return $this;
    } // setModuleActive()

    /**
     * Set the value of [position] column.
     *
     * @param      int $v new value
     * @return   \Thelia\Model\ModuleHook The current object (for fluent API support)
     */
    public function setPosition($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->position !== $v) {
            $this->position = $v;
            $this->modifiedColumns[ModuleHookTableMap::POSITION] = true;
        }


        return $this;
    } // setPosition()

    /**
     * Set the value of [templates] column.
     *
     * @param      string $v new value
     * @return   \Thelia\Model\ModuleHook The current object (for fluent API support)
     */
    public function setTemplates($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->templates !== $v) {
            $this->templates = $v;
            $this->modifiedColumns[ModuleHookTableMap::TEMPLATES] = true;
        }


        return $this;
    } // setTemplates()

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


            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : ModuleHookTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : ModuleHookTableMap::translateFieldName('ModuleId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->module_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : ModuleHookTableMap::translateFieldName('HookId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->hook_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : ModuleHookTableMap::translateFieldName('Classname', TableMap::TYPE_PHPNAME, $indexType)];
            $this->classname = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : ModuleHookTableMap::translateFieldName('Method', TableMap::TYPE_PHPNAME, $indexType)];
            $this->method = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : ModuleHookTableMap::translateFieldName('Active', TableMap::TYPE_PHPNAME, $indexType)];
            $this->active = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : ModuleHookTableMap::translateFieldName('HookActive', TableMap::TYPE_PHPNAME, $indexType)];
            $this->hook_active = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : ModuleHookTableMap::translateFieldName('ModuleActive', TableMap::TYPE_PHPNAME, $indexType)];
            $this->module_active = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : ModuleHookTableMap::translateFieldName('Position', TableMap::TYPE_PHPNAME, $indexType)];
            $this->position = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : ModuleHookTableMap::translateFieldName('Templates', TableMap::TYPE_PHPNAME, $indexType)];
            $this->templates = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 10; // 10 = ModuleHookTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating \Thelia\Model\ModuleHook object", 0, $e);
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
        if ($this->aModule !== null && $this->module_id !== $this->aModule->getId()) {
            $this->aModule = null;
        }
        if ($this->aHook !== null && $this->hook_id !== $this->aHook->getId()) {
            $this->aHook = null;
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
            $con = Propel::getServiceContainer()->getReadConnection(ModuleHookTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildModuleHookQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aModule = null;
            $this->aHook = null;
        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see ModuleHook::setDeleted()
     * @see ModuleHook::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(ModuleHookTableMap::DATABASE_NAME);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = ChildModuleHookQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(ModuleHookTableMap::DATABASE_NAME);
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
                ModuleHookTableMap::addInstanceToPool($this);
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

            if ($this->aModule !== null) {
                if ($this->aModule->isModified() || $this->aModule->isNew()) {
                    $affectedRows += $this->aModule->save($con);
                }
                $this->setModule($this->aModule);
            }

            if ($this->aHook !== null) {
                if ($this->aHook->isModified() || $this->aHook->isNew()) {
                    $affectedRows += $this->aHook->save($con);
                }
                $this->setHook($this->aHook);
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

        $this->modifiedColumns[ModuleHookTableMap::ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . ModuleHookTableMap::ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(ModuleHookTableMap::ID)) {
            $modifiedColumns[':p' . $index++]  = '`ID`';
        }
        if ($this->isColumnModified(ModuleHookTableMap::MODULE_ID)) {
            $modifiedColumns[':p' . $index++]  = '`MODULE_ID`';
        }
        if ($this->isColumnModified(ModuleHookTableMap::HOOK_ID)) {
            $modifiedColumns[':p' . $index++]  = '`HOOK_ID`';
        }
        if ($this->isColumnModified(ModuleHookTableMap::CLASSNAME)) {
            $modifiedColumns[':p' . $index++]  = '`CLASSNAME`';
        }
        if ($this->isColumnModified(ModuleHookTableMap::METHOD)) {
            $modifiedColumns[':p' . $index++]  = '`METHOD`';
        }
        if ($this->isColumnModified(ModuleHookTableMap::ACTIVE)) {
            $modifiedColumns[':p' . $index++]  = '`ACTIVE`';
        }
        if ($this->isColumnModified(ModuleHookTableMap::HOOK_ACTIVE)) {
            $modifiedColumns[':p' . $index++]  = '`HOOK_ACTIVE`';
        }
        if ($this->isColumnModified(ModuleHookTableMap::MODULE_ACTIVE)) {
            $modifiedColumns[':p' . $index++]  = '`MODULE_ACTIVE`';
        }
        if ($this->isColumnModified(ModuleHookTableMap::POSITION)) {
            $modifiedColumns[':p' . $index++]  = '`POSITION`';
        }
        if ($this->isColumnModified(ModuleHookTableMap::TEMPLATES)) {
            $modifiedColumns[':p' . $index++]  = '`TEMPLATES`';
        }

        $sql = sprintf(
            'INSERT INTO `module_hook` (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case '`ID`':
                        $stmt->bindValue($identifier, $this->id, PDO::PARAM_INT);
                        break;
                    case '`MODULE_ID`':
                        $stmt->bindValue($identifier, $this->module_id, PDO::PARAM_INT);
                        break;
                    case '`HOOK_ID`':
                        $stmt->bindValue($identifier, $this->hook_id, PDO::PARAM_INT);
                        break;
                    case '`CLASSNAME`':
                        $stmt->bindValue($identifier, $this->classname, PDO::PARAM_STR);
                        break;
                    case '`METHOD`':
                        $stmt->bindValue($identifier, $this->method, PDO::PARAM_STR);
                        break;
                    case '`ACTIVE`':
                        $stmt->bindValue($identifier, (int) $this->active, PDO::PARAM_INT);
                        break;
                    case '`HOOK_ACTIVE`':
                        $stmt->bindValue($identifier, (int) $this->hook_active, PDO::PARAM_INT);
                        break;
                    case '`MODULE_ACTIVE`':
                        $stmt->bindValue($identifier, (int) $this->module_active, PDO::PARAM_INT);
                        break;
                    case '`POSITION`':
                        $stmt->bindValue($identifier, $this->position, PDO::PARAM_INT);
                        break;
                    case '`TEMPLATES`':
                        $stmt->bindValue($identifier, $this->templates, PDO::PARAM_STR);
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
        $pos = ModuleHookTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getModuleId();
                break;
            case 2:
                return $this->getHookId();
                break;
            case 3:
                return $this->getClassname();
                break;
            case 4:
                return $this->getMethod();
                break;
            case 5:
                return $this->getActive();
                break;
            case 6:
                return $this->getHookActive();
                break;
            case 7:
                return $this->getModuleActive();
                break;
            case 8:
                return $this->getPosition();
                break;
            case 9:
                return $this->getTemplates();
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
        if (isset($alreadyDumpedObjects['ModuleHook'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['ModuleHook'][$this->getPrimaryKey()] = true;
        $keys = ModuleHookTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getModuleId(),
            $keys[2] => $this->getHookId(),
            $keys[3] => $this->getClassname(),
            $keys[4] => $this->getMethod(),
            $keys[5] => $this->getActive(),
            $keys[6] => $this->getHookActive(),
            $keys[7] => $this->getModuleActive(),
            $keys[8] => $this->getPosition(),
            $keys[9] => $this->getTemplates(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aModule) {
                $result['Module'] = $this->aModule->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aHook) {
                $result['Hook'] = $this->aHook->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
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
        $pos = ModuleHookTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

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
                $this->setModuleId($value);
                break;
            case 2:
                $this->setHookId($value);
                break;
            case 3:
                $this->setClassname($value);
                break;
            case 4:
                $this->setMethod($value);
                break;
            case 5:
                $this->setActive($value);
                break;
            case 6:
                $this->setHookActive($value);
                break;
            case 7:
                $this->setModuleActive($value);
                break;
            case 8:
                $this->setPosition($value);
                break;
            case 9:
                $this->setTemplates($value);
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
        $keys = ModuleHookTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setModuleId($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setHookId($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setClassname($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setMethod($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setActive($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setHookActive($arr[$keys[6]]);
        if (array_key_exists($keys[7], $arr)) $this->setModuleActive($arr[$keys[7]]);
        if (array_key_exists($keys[8], $arr)) $this->setPosition($arr[$keys[8]]);
        if (array_key_exists($keys[9], $arr)) $this->setTemplates($arr[$keys[9]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(ModuleHookTableMap::DATABASE_NAME);

        if ($this->isColumnModified(ModuleHookTableMap::ID)) $criteria->add(ModuleHookTableMap::ID, $this->id);
        if ($this->isColumnModified(ModuleHookTableMap::MODULE_ID)) $criteria->add(ModuleHookTableMap::MODULE_ID, $this->module_id);
        if ($this->isColumnModified(ModuleHookTableMap::HOOK_ID)) $criteria->add(ModuleHookTableMap::HOOK_ID, $this->hook_id);
        if ($this->isColumnModified(ModuleHookTableMap::CLASSNAME)) $criteria->add(ModuleHookTableMap::CLASSNAME, $this->classname);
        if ($this->isColumnModified(ModuleHookTableMap::METHOD)) $criteria->add(ModuleHookTableMap::METHOD, $this->method);
        if ($this->isColumnModified(ModuleHookTableMap::ACTIVE)) $criteria->add(ModuleHookTableMap::ACTIVE, $this->active);
        if ($this->isColumnModified(ModuleHookTableMap::HOOK_ACTIVE)) $criteria->add(ModuleHookTableMap::HOOK_ACTIVE, $this->hook_active);
        if ($this->isColumnModified(ModuleHookTableMap::MODULE_ACTIVE)) $criteria->add(ModuleHookTableMap::MODULE_ACTIVE, $this->module_active);
        if ($this->isColumnModified(ModuleHookTableMap::POSITION)) $criteria->add(ModuleHookTableMap::POSITION, $this->position);
        if ($this->isColumnModified(ModuleHookTableMap::TEMPLATES)) $criteria->add(ModuleHookTableMap::TEMPLATES, $this->templates);

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
        $criteria = new Criteria(ModuleHookTableMap::DATABASE_NAME);
        $criteria->add(ModuleHookTableMap::ID, $this->id);

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
     * @param      object $copyObj An object of \Thelia\Model\ModuleHook (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setModuleId($this->getModuleId());
        $copyObj->setHookId($this->getHookId());
        $copyObj->setClassname($this->getClassname());
        $copyObj->setMethod($this->getMethod());
        $copyObj->setActive($this->getActive());
        $copyObj->setHookActive($this->getHookActive());
        $copyObj->setModuleActive($this->getModuleActive());
        $copyObj->setPosition($this->getPosition());
        $copyObj->setTemplates($this->getTemplates());
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
     * @return                 \Thelia\Model\ModuleHook Clone of current object.
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
     * Declares an association between this object and a ChildModule object.
     *
     * @param                  ChildModule $v
     * @return                 \Thelia\Model\ModuleHook The current object (for fluent API support)
     * @throws PropelException
     */
    public function setModule(ChildModule $v = null)
    {
        if ($v === null) {
            $this->setModuleId(NULL);
        } else {
            $this->setModuleId($v->getId());
        }

        $this->aModule = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildModule object, it will not be re-added.
        if ($v !== null) {
            $v->addModuleHook($this);
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
    public function getModule(ConnectionInterface $con = null)
    {
        if ($this->aModule === null && ($this->module_id !== null)) {
            $this->aModule = ChildModuleQuery::create()->findPk($this->module_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aModule->addModuleHooks($this);
             */
        }

        return $this->aModule;
    }

    /**
     * Declares an association between this object and a ChildHook object.
     *
     * @param                  ChildHook $v
     * @return                 \Thelia\Model\ModuleHook The current object (for fluent API support)
     * @throws PropelException
     */
    public function setHook(ChildHook $v = null)
    {
        if ($v === null) {
            $this->setHookId(NULL);
        } else {
            $this->setHookId($v->getId());
        }

        $this->aHook = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildHook object, it will not be re-added.
        if ($v !== null) {
            $v->addModuleHook($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildHook object
     *
     * @param      ConnectionInterface $con Optional Connection object.
     * @return                 ChildHook The associated ChildHook object.
     * @throws PropelException
     */
    public function getHook(ConnectionInterface $con = null)
    {
        if ($this->aHook === null && ($this->hook_id !== null)) {
            $this->aHook = ChildHookQuery::create()->findPk($this->hook_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aHook->addModuleHooks($this);
             */
        }

        return $this->aHook;
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->id = null;
        $this->module_id = null;
        $this->hook_id = null;
        $this->classname = null;
        $this->method = null;
        $this->active = null;
        $this->hook_active = null;
        $this->module_active = null;
        $this->position = null;
        $this->templates = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
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

        $this->aModule = null;
        $this->aHook = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(ModuleHookTableMap::DEFAULT_STRING_FORMAT);
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
