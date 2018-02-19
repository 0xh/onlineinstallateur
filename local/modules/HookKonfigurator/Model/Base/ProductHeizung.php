<?php

namespace HookKonfigurator\Model\Base;

use \Exception;
use \PDO;
use HookKonfigurator\Model\Product as ChildProduct;
use HookKonfigurator\Model\ProductHeizungMontage as ChildProductHeizungMontage;
use HookKonfigurator\Model\ProductHeizungMontageQuery as ChildProductHeizungMontageQuery;
use HookKonfigurator\Model\ProductHeizungQuery as ChildProductHeizungQuery;
use HookKonfigurator\Model\ProductQuery as ChildProductQuery;
use HookKonfigurator\Model\SetProducts as ChildSetProducts;
use HookKonfigurator\Model\SetProductsQuery as ChildSetProductsQuery;
use HookKonfigurator\Model\Map\ProductHeizungTableMap;
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

abstract class ProductHeizung implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\HookKonfigurator\\Model\\Map\\ProductHeizungTableMap';


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
     * The value for the product_id field.
     * @var        int
     */
    protected $product_id;

    /**
     * The value for the grade field.
     * @var        string
     */
    protected $grade;

    /**
     * The value for the power field.
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $power;

    /**
     * The value for the energy_efficiency field.
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $energy_efficiency;

    /**
     * The value for the priority field.
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $priority;

    /**
     * The value for the warm_water field.
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $warm_water;

    /**
     * The value for the energy_carrier field.
     * @var        string
     */
    protected $energy_carrier;

    /**
     * The value for the storage_capacity field.
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $storage_capacity;

    /**
     * @var        Product
     */
    protected $aProduct;

    /**
     * @var        ChildProductHeizungMontage one-to-one related ChildProductHeizungMontage object
     */
    protected $singleProductHeizungMontage;

    /**
     * @var        ChildSetProducts one-to-one related ChildSetProducts object
     */
    protected $singleSetProducts;

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
        $this->power = 0;
        $this->energy_efficiency = 0;
        $this->priority = 0;
        $this->warm_water = false;
        $this->storage_capacity = 0;
    }

    /**
     * Initializes internal state of HookKonfigurator\Model\Base\ProductHeizung object.
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
     * Compares this with another <code>ProductHeizung</code> instance.  If
     * <code>obj</code> is an instance of <code>ProductHeizung</code>, delegates to
     * <code>equals(ProductHeizung)</code>.  Otherwise, returns <code>false</code>.
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
     * @return ProductHeizung The current object, for fluid interface
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
     * @return ProductHeizung The current object, for fluid interface
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
     * Get the [product_id] column value.
     *
     * @return   int
     */
    public function getProductId()
    {

        return $this->product_id;
    }

    /**
     * Get the [grade] column value.
     *
     * @return   string
     */
    public function getGrade()
    {

        return $this->grade;
    }

    /**
     * Get the [power] column value.
     *
     * @return   int
     */
    public function getPower()
    {

        return $this->power;
    }

    /**
     * Get the [energy_efficiency] column value.
     *
     * @return   int
     */
    public function getEnergyEfficiency()
    {

        return $this->energy_efficiency;
    }

    /**
     * Get the [priority] column value.
     *
     * @return   int
     */
    public function getPriority()
    {

        return $this->priority;
    }

    /**
     * Get the [warm_water] column value.
     *
     * @return   boolean
     */
    public function getWarmWater()
    {

        return $this->warm_water;
    }

    /**
     * Get the [energy_carrier] column value.
     *
     * @return   string
     */
    public function getEnergyCarrier()
    {

        return $this->energy_carrier;
    }

    /**
     * Get the [storage_capacity] column value.
     *
     * @return   int
     */
    public function getStorageCapacity()
    {

        return $this->storage_capacity;
    }

    /**
     * Set the value of [product_id] column.
     *
     * @param      int $v new value
     * @return   \HookKonfigurator\Model\ProductHeizung The current object (for fluent API support)
     */
    public function setProductId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->product_id !== $v) {
            $this->product_id = $v;
            $this->modifiedColumns[ProductHeizungTableMap::PRODUCT_ID] = true;
        }

        if ($this->aProduct !== null && $this->aProduct->getId() !== $v) {
            $this->aProduct = null;
        }


        return $this;
    } // setProductId()

    /**
     * Set the value of [grade] column.
     *
     * @param      string $v new value
     * @return   \HookKonfigurator\Model\ProductHeizung The current object (for fluent API support)
     */
    public function setGrade($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->grade !== $v) {
            $this->grade = $v;
            $this->modifiedColumns[ProductHeizungTableMap::GRADE] = true;
        }


        return $this;
    } // setGrade()

    /**
     * Set the value of [power] column.
     *
     * @param      int $v new value
     * @return   \HookKonfigurator\Model\ProductHeizung The current object (for fluent API support)
     */
    public function setPower($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->power !== $v) {
            $this->power = $v;
            $this->modifiedColumns[ProductHeizungTableMap::POWER] = true;
        }


        return $this;
    } // setPower()

    /**
     * Set the value of [energy_efficiency] column.
     *
     * @param      int $v new value
     * @return   \HookKonfigurator\Model\ProductHeizung The current object (for fluent API support)
     */
    public function setEnergyEfficiency($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->energy_efficiency !== $v) {
            $this->energy_efficiency = $v;
            $this->modifiedColumns[ProductHeizungTableMap::ENERGY_EFFICIENCY] = true;
        }


        return $this;
    } // setEnergyEfficiency()

    /**
     * Set the value of [priority] column.
     *
     * @param      int $v new value
     * @return   \HookKonfigurator\Model\ProductHeizung The current object (for fluent API support)
     */
    public function setPriority($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->priority !== $v) {
            $this->priority = $v;
            $this->modifiedColumns[ProductHeizungTableMap::PRIORITY] = true;
        }


        return $this;
    } // setPriority()

    /**
     * Sets the value of the [warm_water] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param      boolean|integer|string $v The new value
     * @return   \HookKonfigurator\Model\ProductHeizung The current object (for fluent API support)
     */
    public function setWarmWater($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->warm_water !== $v) {
            $this->warm_water = $v;
            $this->modifiedColumns[ProductHeizungTableMap::WARM_WATER] = true;
        }


        return $this;
    } // setWarmWater()

    /**
     * Set the value of [energy_carrier] column.
     *
     * @param      string $v new value
     * @return   \HookKonfigurator\Model\ProductHeizung The current object (for fluent API support)
     */
    public function setEnergyCarrier($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->energy_carrier !== $v) {
            $this->energy_carrier = $v;
            $this->modifiedColumns[ProductHeizungTableMap::ENERGY_CARRIER] = true;
        }


        return $this;
    } // setEnergyCarrier()

    /**
     * Set the value of [storage_capacity] column.
     *
     * @param      int $v new value
     * @return   \HookKonfigurator\Model\ProductHeizung The current object (for fluent API support)
     */
    public function setStorageCapacity($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->storage_capacity !== $v) {
            $this->storage_capacity = $v;
            $this->modifiedColumns[ProductHeizungTableMap::STORAGE_CAPACITY] = true;
        }


        return $this;
    } // setStorageCapacity()

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
            if ($this->power !== 0) {
                return false;
            }

            if ($this->energy_efficiency !== 0) {
                return false;
            }

            if ($this->priority !== 0) {
                return false;
            }

            if ($this->warm_water !== false) {
                return false;
            }

            if ($this->storage_capacity !== 0) {
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


            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : ProductHeizungTableMap::translateFieldName('ProductId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->product_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : ProductHeizungTableMap::translateFieldName('Grade', TableMap::TYPE_PHPNAME, $indexType)];
            $this->grade = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : ProductHeizungTableMap::translateFieldName('Power', TableMap::TYPE_PHPNAME, $indexType)];
            $this->power = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : ProductHeizungTableMap::translateFieldName('EnergyEfficiency', TableMap::TYPE_PHPNAME, $indexType)];
            $this->energy_efficiency = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : ProductHeizungTableMap::translateFieldName('Priority', TableMap::TYPE_PHPNAME, $indexType)];
            $this->priority = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : ProductHeizungTableMap::translateFieldName('WarmWater', TableMap::TYPE_PHPNAME, $indexType)];
            $this->warm_water = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : ProductHeizungTableMap::translateFieldName('EnergyCarrier', TableMap::TYPE_PHPNAME, $indexType)];
            $this->energy_carrier = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : ProductHeizungTableMap::translateFieldName('StorageCapacity', TableMap::TYPE_PHPNAME, $indexType)];
            $this->storage_capacity = (null !== $col) ? (int) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 8; // 8 = ProductHeizungTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating \HookKonfigurator\Model\ProductHeizung object", 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(ProductHeizungTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildProductHeizungQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aProduct = null;
            $this->singleProductHeizungMontage = null;

            $this->singleSetProducts = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see ProductHeizung::setDeleted()
     * @see ProductHeizung::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(ProductHeizungTableMap::DATABASE_NAME);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = ChildProductHeizungQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(ProductHeizungTableMap::DATABASE_NAME);
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
                ProductHeizungTableMap::addInstanceToPool($this);
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

            if ($this->singleProductHeizungMontage !== null) {
                if (!$this->singleProductHeizungMontage->isDeleted() && ($this->singleProductHeizungMontage->isNew() || $this->singleProductHeizungMontage->isModified())) {
                    $affectedRows += $this->singleProductHeizungMontage->save($con);
                }
            }

            if ($this->singleSetProducts !== null) {
                if (!$this->singleSetProducts->isDeleted() && ($this->singleSetProducts->isNew() || $this->singleSetProducts->isModified())) {
                    $affectedRows += $this->singleSetProducts->save($con);
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


         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(ProductHeizungTableMap::PRODUCT_ID)) {
            $modifiedColumns[':p' . $index++]  = 'PRODUCT_ID';
        }
        if ($this->isColumnModified(ProductHeizungTableMap::GRADE)) {
            $modifiedColumns[':p' . $index++]  = 'GRADE';
        }
        if ($this->isColumnModified(ProductHeizungTableMap::POWER)) {
            $modifiedColumns[':p' . $index++]  = 'POWER';
        }
        if ($this->isColumnModified(ProductHeizungTableMap::ENERGY_EFFICIENCY)) {
            $modifiedColumns[':p' . $index++]  = 'ENERGY_EFFICIENCY';
        }
        if ($this->isColumnModified(ProductHeizungTableMap::PRIORITY)) {
            $modifiedColumns[':p' . $index++]  = 'PRIORITY';
        }
        if ($this->isColumnModified(ProductHeizungTableMap::WARM_WATER)) {
            $modifiedColumns[':p' . $index++]  = 'WARM_WATER';
        }
        if ($this->isColumnModified(ProductHeizungTableMap::ENERGY_CARRIER)) {
            $modifiedColumns[':p' . $index++]  = 'ENERGY_CARRIER';
        }
        if ($this->isColumnModified(ProductHeizungTableMap::STORAGE_CAPACITY)) {
            $modifiedColumns[':p' . $index++]  = 'STORAGE_CAPACITY';
        }

        $sql = sprintf(
            'INSERT INTO product_heizung (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'PRODUCT_ID':
                        $stmt->bindValue($identifier, $this->product_id, PDO::PARAM_INT);
                        break;
                    case 'GRADE':
                        $stmt->bindValue($identifier, $this->grade, PDO::PARAM_STR);
                        break;
                    case 'POWER':
                        $stmt->bindValue($identifier, $this->power, PDO::PARAM_INT);
                        break;
                    case 'ENERGY_EFFICIENCY':
                        $stmt->bindValue($identifier, $this->energy_efficiency, PDO::PARAM_INT);
                        break;
                    case 'PRIORITY':
                        $stmt->bindValue($identifier, $this->priority, PDO::PARAM_INT);
                        break;
                    case 'WARM_WATER':
                        $stmt->bindValue($identifier, (int) $this->warm_water, PDO::PARAM_INT);
                        break;
                    case 'ENERGY_CARRIER':
                        $stmt->bindValue($identifier, $this->energy_carrier, PDO::PARAM_STR);
                        break;
                    case 'STORAGE_CAPACITY':
                        $stmt->bindValue($identifier, $this->storage_capacity, PDO::PARAM_INT);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

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
        $pos = ProductHeizungTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getProductId();
                break;
            case 1:
                return $this->getGrade();
                break;
            case 2:
                return $this->getPower();
                break;
            case 3:
                return $this->getEnergyEfficiency();
                break;
            case 4:
                return $this->getPriority();
                break;
            case 5:
                return $this->getWarmWater();
                break;
            case 6:
                return $this->getEnergyCarrier();
                break;
            case 7:
                return $this->getStorageCapacity();
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
        if (isset($alreadyDumpedObjects['ProductHeizung'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['ProductHeizung'][$this->getPrimaryKey()] = true;
        $keys = ProductHeizungTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getProductId(),
            $keys[1] => $this->getGrade(),
            $keys[2] => $this->getPower(),
            $keys[3] => $this->getEnergyEfficiency(),
            $keys[4] => $this->getPriority(),
            $keys[5] => $this->getWarmWater(),
            $keys[6] => $this->getEnergyCarrier(),
            $keys[7] => $this->getStorageCapacity(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aProduct) {
                $result['Product'] = $this->aProduct->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->singleProductHeizungMontage) {
                $result['ProductHeizungMontage'] = $this->singleProductHeizungMontage->toArray($keyType, $includeLazyLoadColumns, $alreadyDumpedObjects, true);
            }
            if (null !== $this->singleSetProducts) {
                $result['SetProducts'] = $this->singleSetProducts->toArray($keyType, $includeLazyLoadColumns, $alreadyDumpedObjects, true);
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
        $pos = ProductHeizungTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

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
                $this->setProductId($value);
                break;
            case 1:
                $this->setGrade($value);
                break;
            case 2:
                $this->setPower($value);
                break;
            case 3:
                $this->setEnergyEfficiency($value);
                break;
            case 4:
                $this->setPriority($value);
                break;
            case 5:
                $this->setWarmWater($value);
                break;
            case 6:
                $this->setEnergyCarrier($value);
                break;
            case 7:
                $this->setStorageCapacity($value);
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
        $keys = ProductHeizungTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setProductId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setGrade($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setPower($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setEnergyEfficiency($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setPriority($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setWarmWater($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setEnergyCarrier($arr[$keys[6]]);
        if (array_key_exists($keys[7], $arr)) $this->setStorageCapacity($arr[$keys[7]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(ProductHeizungTableMap::DATABASE_NAME);

        if ($this->isColumnModified(ProductHeizungTableMap::PRODUCT_ID)) $criteria->add(ProductHeizungTableMap::PRODUCT_ID, $this->product_id);
        if ($this->isColumnModified(ProductHeizungTableMap::GRADE)) $criteria->add(ProductHeizungTableMap::GRADE, $this->grade);
        if ($this->isColumnModified(ProductHeizungTableMap::POWER)) $criteria->add(ProductHeizungTableMap::POWER, $this->power);
        if ($this->isColumnModified(ProductHeizungTableMap::ENERGY_EFFICIENCY)) $criteria->add(ProductHeizungTableMap::ENERGY_EFFICIENCY, $this->energy_efficiency);
        if ($this->isColumnModified(ProductHeizungTableMap::PRIORITY)) $criteria->add(ProductHeizungTableMap::PRIORITY, $this->priority);
        if ($this->isColumnModified(ProductHeizungTableMap::WARM_WATER)) $criteria->add(ProductHeizungTableMap::WARM_WATER, $this->warm_water);
        if ($this->isColumnModified(ProductHeizungTableMap::ENERGY_CARRIER)) $criteria->add(ProductHeizungTableMap::ENERGY_CARRIER, $this->energy_carrier);
        if ($this->isColumnModified(ProductHeizungTableMap::STORAGE_CAPACITY)) $criteria->add(ProductHeizungTableMap::STORAGE_CAPACITY, $this->storage_capacity);

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
        $criteria = new Criteria(ProductHeizungTableMap::DATABASE_NAME);
        $criteria->add(ProductHeizungTableMap::PRODUCT_ID, $this->product_id);

        return $criteria;
    }

    /**
     * Returns the primary key for this object (row).
     * @return   int
     */
    public function getPrimaryKey()
    {
        return $this->getProductId();
    }

    /**
     * Generic method to set the primary key (product_id column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setProductId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {

        return null === $this->getProductId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \HookKonfigurator\Model\ProductHeizung (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setProductId($this->getProductId());
        $copyObj->setGrade($this->getGrade());
        $copyObj->setPower($this->getPower());
        $copyObj->setEnergyEfficiency($this->getEnergyEfficiency());
        $copyObj->setPriority($this->getPriority());
        $copyObj->setWarmWater($this->getWarmWater());
        $copyObj->setEnergyCarrier($this->getEnergyCarrier());
        $copyObj->setStorageCapacity($this->getStorageCapacity());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            $relObj = $this->getProductHeizungMontage();
            if ($relObj) {
                $copyObj->setProductHeizungMontage($relObj->copy($deepCopy));
            }

            $relObj = $this->getSetProducts();
            if ($relObj) {
                $copyObj->setSetProducts($relObj->copy($deepCopy));
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
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
     * @return                 \HookKonfigurator\Model\ProductHeizung Clone of current object.
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
     * @return                 \HookKonfigurator\Model\ProductHeizung The current object (for fluent API support)
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

        // Add binding for other direction of this 1:1 relationship.
        if ($v !== null) {
            $v->setProductHeizung($this);
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
            $this->aProduct = ChildProductQuery::create()->findPk($this->product_id, $con);
            // Because this foreign key represents a one-to-one relationship, we will create a bi-directional association.
            $this->aProduct->setProductHeizung($this);
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
    }

    /**
     * Gets a single ChildProductHeizungMontage object, which is related to this object by a one-to-one relationship.
     *
     * @param      ConnectionInterface $con optional connection object
     * @return                 ChildProductHeizungMontage
     * @throws PropelException
     */
    public function getProductHeizungMontage(ConnectionInterface $con = null)
    {

        if ($this->singleProductHeizungMontage === null && !$this->isNew()) {
            $this->singleProductHeizungMontage = ChildProductHeizungMontageQuery::create()->findPk($this->getPrimaryKey(), $con);
        }

        return $this->singleProductHeizungMontage;
    }

    /**
     * Sets a single ChildProductHeizungMontage object as related to this object by a one-to-one relationship.
     *
     * @param                  ChildProductHeizungMontage $v ChildProductHeizungMontage
     * @return                 \HookKonfigurator\Model\ProductHeizung The current object (for fluent API support)
     * @throws PropelException
     */
    public function setProductHeizungMontage(ChildProductHeizungMontage $v = null)
    {
        $this->singleProductHeizungMontage = $v;

        // Make sure that that the passed-in ChildProductHeizungMontage isn't already associated with this object
        if ($v !== null && $v->getProductHeizung(null, false) === null) {
            $v->setProductHeizung($this);
        }

        return $this;
    }

    /**
     * Gets a single ChildSetProducts object, which is related to this object by a one-to-one relationship.
     *
     * @param      ConnectionInterface $con optional connection object
     * @return                 ChildSetProducts
     * @throws PropelException
     */
    public function getSetProducts(ConnectionInterface $con = null)
    {

        if ($this->singleSetProducts === null && !$this->isNew()) {
            $this->singleSetProducts = ChildSetProductsQuery::create()->findPk($this->getPrimaryKey(), $con);
        }

        return $this->singleSetProducts;
    }

    /**
     * Sets a single ChildSetProducts object as related to this object by a one-to-one relationship.
     *
     * @param                  ChildSetProducts $v ChildSetProducts
     * @return                 \HookKonfigurator\Model\ProductHeizung The current object (for fluent API support)
     * @throws PropelException
     */
    public function setSetProducts(ChildSetProducts $v = null)
    {
        $this->singleSetProducts = $v;

        // Make sure that that the passed-in ChildSetProducts isn't already associated with this object
        if ($v !== null && $v->getProductHeizung(null, false) === null) {
            $v->setProductHeizung($this);
        }

        return $this;
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->product_id = null;
        $this->grade = null;
        $this->power = null;
        $this->energy_efficiency = null;
        $this->priority = null;
        $this->warm_water = null;
        $this->energy_carrier = null;
        $this->storage_capacity = null;
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
            if ($this->singleProductHeizungMontage) {
                $this->singleProductHeizungMontage->clearAllReferences($deep);
            }
            if ($this->singleSetProducts) {
                $this->singleSetProducts->clearAllReferences($deep);
            }
        } // if ($deep)

        $this->singleProductHeizungMontage = null;
        $this->singleSetProducts = null;
        $this->aProduct = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(ProductHeizungTableMap::DEFAULT_STRING_FORMAT);
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
