<?php

namespace MultipleFullfilmentCenters\Model\Base;

use \Exception;
use \PDO;
use MultipleFullfilmentCenters\Model\FulfilmentCenter as ChildFulfilmentCenter;
use MultipleFullfilmentCenters\Model\FulfilmentCenterProducts as ChildFulfilmentCenterProducts;
use MultipleFullfilmentCenters\Model\FulfilmentCenterProductsQuery as ChildFulfilmentCenterProductsQuery;
use MultipleFullfilmentCenters\Model\FulfilmentCenterQuery as ChildFulfilmentCenterQuery;
use MultipleFullfilmentCenters\Model\OrderLocalPickup as ChildOrderLocalPickup;
use MultipleFullfilmentCenters\Model\OrderLocalPickupQuery as ChildOrderLocalPickupQuery;
use MultipleFullfilmentCenters\Model\Map\FulfilmentCenterTableMap;
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

abstract class FulfilmentCenter implements ActiveRecordInterface 
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\MultipleFullfilmentCenters\\Model\\Map\\FulfilmentCenterTableMap';


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
     * The value for the address field.
     * @var        string
     */
    protected $address;

    /**
     * The value for the gps_lat field.
     * @var        string
     */
    protected $gps_lat;

    /**
     * The value for the gps_long field.
     * @var        string
     */
    protected $gps_long;

    /**
     * The value for the stock_limit field.
     * @var        int
     */
    protected $stock_limit;

    /**
     * The value for the delivery_cost field.
     * Note: this column has a database default value of: '3.00'
     * @var        string
     */
    protected $delivery_cost;

    /**
     * The value for the delivery_method field.
     * Note: this column has a database default value of: 'triworx'
     * @var        string
     */
    protected $delivery_method;

    /**
     * @var        ObjectCollection|ChildFulfilmentCenterProducts[] Collection to store aggregation of ChildFulfilmentCenterProducts objects.
     */
    protected $collFulfilmentCenterProductss;
    protected $collFulfilmentCenterProductssPartial;

    /**
     * @var        ObjectCollection|ChildOrderLocalPickup[] Collection to store aggregation of ChildOrderLocalPickup objects.
     */
    protected $collOrderLocalPickups;
    protected $collOrderLocalPickupsPartial;

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
    protected $fulfilmentCenterProductssScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection
     */
    protected $orderLocalPickupsScheduledForDeletion = null;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see __construct()
     */
    public function applyDefaultValues()
    {
        $this->delivery_cost = '3.00';
        $this->delivery_method = 'triworx';
    }

    /**
     * Initializes internal state of MultipleFullfilmentCenters\Model\Base\FulfilmentCenter object.
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
     * Compares this with another <code>FulfilmentCenter</code> instance.  If
     * <code>obj</code> is an instance of <code>FulfilmentCenter</code>, delegates to
     * <code>equals(FulfilmentCenter)</code>.  Otherwise, returns <code>false</code>.
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
     * @return FulfilmentCenter The current object, for fluid interface
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
     * @return FulfilmentCenter The current object, for fluid interface
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
     * Get the [address] column value.
     * 
     * @return   string
     */
    public function getAddress()
    {

        return $this->address;
    }

    /**
     * Get the [gps_lat] column value.
     * 
     * @return   string
     */
    public function getGpsLat()
    {

        return $this->gps_lat;
    }

    /**
     * Get the [gps_long] column value.
     * 
     * @return   string
     */
    public function getGpsLong()
    {

        return $this->gps_long;
    }

    /**
     * Get the [stock_limit] column value.
     * 
     * @return   int
     */
    public function getStockLimit()
    {

        return $this->stock_limit;
    }

    /**
     * Get the [delivery_cost] column value.
     * 
     * @return   string
     */
    public function getDeliveryCost()
    {

        return $this->delivery_cost;
    }

    /**
     * Get the [delivery_method] column value.
     * 
     * @return   string
     */
    public function getDeliveryMethod()
    {

        return $this->delivery_method;
    }

    /**
     * Set the value of [id] column.
     * 
     * @param      int $v new value
     * @return   \MultipleFullfilmentCenters\Model\FulfilmentCenter The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[FulfilmentCenterTableMap::ID] = true;
        }


        return $this;
    } // setId()

    /**
     * Set the value of [name] column.
     * 
     * @param      string $v new value
     * @return   \MultipleFullfilmentCenters\Model\FulfilmentCenter The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[FulfilmentCenterTableMap::NAME] = true;
        }


        return $this;
    } // setName()

    /**
     * Set the value of [address] column.
     * 
     * @param      string $v new value
     * @return   \MultipleFullfilmentCenters\Model\FulfilmentCenter The current object (for fluent API support)
     */
    public function setAddress($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->address !== $v) {
            $this->address = $v;
            $this->modifiedColumns[FulfilmentCenterTableMap::ADDRESS] = true;
        }


        return $this;
    } // setAddress()

    /**
     * Set the value of [gps_lat] column.
     * 
     * @param      string $v new value
     * @return   \MultipleFullfilmentCenters\Model\FulfilmentCenter The current object (for fluent API support)
     */
    public function setGpsLat($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->gps_lat !== $v) {
            $this->gps_lat = $v;
            $this->modifiedColumns[FulfilmentCenterTableMap::GPS_LAT] = true;
        }


        return $this;
    } // setGpsLat()

    /**
     * Set the value of [gps_long] column.
     * 
     * @param      string $v new value
     * @return   \MultipleFullfilmentCenters\Model\FulfilmentCenter The current object (for fluent API support)
     */
    public function setGpsLong($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->gps_long !== $v) {
            $this->gps_long = $v;
            $this->modifiedColumns[FulfilmentCenterTableMap::GPS_LONG] = true;
        }


        return $this;
    } // setGpsLong()

    /**
     * Set the value of [stock_limit] column.
     * 
     * @param      int $v new value
     * @return   \MultipleFullfilmentCenters\Model\FulfilmentCenter The current object (for fluent API support)
     */
    public function setStockLimit($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->stock_limit !== $v) {
            $this->stock_limit = $v;
            $this->modifiedColumns[FulfilmentCenterTableMap::STOCK_LIMIT] = true;
        }


        return $this;
    } // setStockLimit()

    /**
     * Set the value of [delivery_cost] column.
     * 
     * @param      string $v new value
     * @return   \MultipleFullfilmentCenters\Model\FulfilmentCenter The current object (for fluent API support)
     */
    public function setDeliveryCost($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->delivery_cost !== $v) {
            $this->delivery_cost = $v;
            $this->modifiedColumns[FulfilmentCenterTableMap::DELIVERY_COST] = true;
        }


        return $this;
    } // setDeliveryCost()

    /**
     * Set the value of [delivery_method] column.
     * 
     * @param      string $v new value
     * @return   \MultipleFullfilmentCenters\Model\FulfilmentCenter The current object (for fluent API support)
     */
    public function setDeliveryMethod($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->delivery_method !== $v) {
            $this->delivery_method = $v;
            $this->modifiedColumns[FulfilmentCenterTableMap::DELIVERY_METHOD] = true;
        }


        return $this;
    } // setDeliveryMethod()

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
            if ($this->delivery_cost !== '3.00') {
                return false;
            }

            if ($this->delivery_method !== 'triworx') {
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


            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : FulfilmentCenterTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : FulfilmentCenterTableMap::translateFieldName('Name', TableMap::TYPE_PHPNAME, $indexType)];
            $this->name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : FulfilmentCenterTableMap::translateFieldName('Address', TableMap::TYPE_PHPNAME, $indexType)];
            $this->address = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : FulfilmentCenterTableMap::translateFieldName('GpsLat', TableMap::TYPE_PHPNAME, $indexType)];
            $this->gps_lat = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : FulfilmentCenterTableMap::translateFieldName('GpsLong', TableMap::TYPE_PHPNAME, $indexType)];
            $this->gps_long = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : FulfilmentCenterTableMap::translateFieldName('StockLimit', TableMap::TYPE_PHPNAME, $indexType)];
            $this->stock_limit = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : FulfilmentCenterTableMap::translateFieldName('DeliveryCost', TableMap::TYPE_PHPNAME, $indexType)];
            $this->delivery_cost = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : FulfilmentCenterTableMap::translateFieldName('DeliveryMethod', TableMap::TYPE_PHPNAME, $indexType)];
            $this->delivery_method = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 8; // 8 = FulfilmentCenterTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating \MultipleFullfilmentCenters\Model\FulfilmentCenter object", 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(FulfilmentCenterTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildFulfilmentCenterQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collFulfilmentCenterProductss = null;

            $this->collOrderLocalPickups = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see FulfilmentCenter::setDeleted()
     * @see FulfilmentCenter::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(FulfilmentCenterTableMap::DATABASE_NAME);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = ChildFulfilmentCenterQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(FulfilmentCenterTableMap::DATABASE_NAME);
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
                FulfilmentCenterTableMap::addInstanceToPool($this);
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

            if ($this->fulfilmentCenterProductssScheduledForDeletion !== null) {
                if (!$this->fulfilmentCenterProductssScheduledForDeletion->isEmpty()) {
                    \MultipleFullfilmentCenters\Model\FulfilmentCenterProductsQuery::create()
                        ->filterByPrimaryKeys($this->fulfilmentCenterProductssScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->fulfilmentCenterProductssScheduledForDeletion = null;
                }
            }

                if ($this->collFulfilmentCenterProductss !== null) {
            foreach ($this->collFulfilmentCenterProductss as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->orderLocalPickupsScheduledForDeletion !== null) {
                if (!$this->orderLocalPickupsScheduledForDeletion->isEmpty()) {
                    \MultipleFullfilmentCenters\Model\OrderLocalPickupQuery::create()
                        ->filterByPrimaryKeys($this->orderLocalPickupsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->orderLocalPickupsScheduledForDeletion = null;
                }
            }

                if ($this->collOrderLocalPickups !== null) {
            foreach ($this->collOrderLocalPickups as $referrerFK) {
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

        $this->modifiedColumns[FulfilmentCenterTableMap::ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . FulfilmentCenterTableMap::ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(FulfilmentCenterTableMap::ID)) {
            $modifiedColumns[':p' . $index++]  = 'ID';
        }
        if ($this->isColumnModified(FulfilmentCenterTableMap::NAME)) {
            $modifiedColumns[':p' . $index++]  = 'NAME';
        }
        if ($this->isColumnModified(FulfilmentCenterTableMap::ADDRESS)) {
            $modifiedColumns[':p' . $index++]  = 'ADDRESS';
        }
        if ($this->isColumnModified(FulfilmentCenterTableMap::GPS_LAT)) {
            $modifiedColumns[':p' . $index++]  = 'GPS_LAT';
        }
        if ($this->isColumnModified(FulfilmentCenterTableMap::GPS_LONG)) {
            $modifiedColumns[':p' . $index++]  = 'GPS_LONG';
        }
        if ($this->isColumnModified(FulfilmentCenterTableMap::STOCK_LIMIT)) {
            $modifiedColumns[':p' . $index++]  = 'STOCK_LIMIT';
        }
        if ($this->isColumnModified(FulfilmentCenterTableMap::DELIVERY_COST)) {
            $modifiedColumns[':p' . $index++]  = 'DELIVERY_COST';
        }
        if ($this->isColumnModified(FulfilmentCenterTableMap::DELIVERY_METHOD)) {
            $modifiedColumns[':p' . $index++]  = 'DELIVERY_METHOD';
        }

        $sql = sprintf(
            'INSERT INTO fulfilment_center (%s) VALUES (%s)',
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
                    case 'ADDRESS':                        
                        $stmt->bindValue($identifier, $this->address, PDO::PARAM_STR);
                        break;
                    case 'GPS_LAT':                        
                        $stmt->bindValue($identifier, $this->gps_lat, PDO::PARAM_STR);
                        break;
                    case 'GPS_LONG':                        
                        $stmt->bindValue($identifier, $this->gps_long, PDO::PARAM_STR);
                        break;
                    case 'STOCK_LIMIT':                        
                        $stmt->bindValue($identifier, $this->stock_limit, PDO::PARAM_INT);
                        break;
                    case 'DELIVERY_COST':                        
                        $stmt->bindValue($identifier, $this->delivery_cost, PDO::PARAM_STR);
                        break;
                    case 'DELIVERY_METHOD':                        
                        $stmt->bindValue($identifier, $this->delivery_method, PDO::PARAM_STR);
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
        $pos = FulfilmentCenterTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getAddress();
                break;
            case 3:
                return $this->getGpsLat();
                break;
            case 4:
                return $this->getGpsLong();
                break;
            case 5:
                return $this->getStockLimit();
                break;
            case 6:
                return $this->getDeliveryCost();
                break;
            case 7:
                return $this->getDeliveryMethod();
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
        if (isset($alreadyDumpedObjects['FulfilmentCenter'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['FulfilmentCenter'][$this->getPrimaryKey()] = true;
        $keys = FulfilmentCenterTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getName(),
            $keys[2] => $this->getAddress(),
            $keys[3] => $this->getGpsLat(),
            $keys[4] => $this->getGpsLong(),
            $keys[5] => $this->getStockLimit(),
            $keys[6] => $this->getDeliveryCost(),
            $keys[7] => $this->getDeliveryMethod(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }
        
        if ($includeForeignObjects) {
            if (null !== $this->collFulfilmentCenterProductss) {
                $result['FulfilmentCenterProductss'] = $this->collFulfilmentCenterProductss->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collOrderLocalPickups) {
                $result['OrderLocalPickups'] = $this->collOrderLocalPickups->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
        $pos = FulfilmentCenterTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

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
                $this->setAddress($value);
                break;
            case 3:
                $this->setGpsLat($value);
                break;
            case 4:
                $this->setGpsLong($value);
                break;
            case 5:
                $this->setStockLimit($value);
                break;
            case 6:
                $this->setDeliveryCost($value);
                break;
            case 7:
                $this->setDeliveryMethod($value);
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
        $keys = FulfilmentCenterTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setName($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setAddress($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setGpsLat($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setGpsLong($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setStockLimit($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setDeliveryCost($arr[$keys[6]]);
        if (array_key_exists($keys[7], $arr)) $this->setDeliveryMethod($arr[$keys[7]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(FulfilmentCenterTableMap::DATABASE_NAME);

        if ($this->isColumnModified(FulfilmentCenterTableMap::ID)) $criteria->add(FulfilmentCenterTableMap::ID, $this->id);
        if ($this->isColumnModified(FulfilmentCenterTableMap::NAME)) $criteria->add(FulfilmentCenterTableMap::NAME, $this->name);
        if ($this->isColumnModified(FulfilmentCenterTableMap::ADDRESS)) $criteria->add(FulfilmentCenterTableMap::ADDRESS, $this->address);
        if ($this->isColumnModified(FulfilmentCenterTableMap::GPS_LAT)) $criteria->add(FulfilmentCenterTableMap::GPS_LAT, $this->gps_lat);
        if ($this->isColumnModified(FulfilmentCenterTableMap::GPS_LONG)) $criteria->add(FulfilmentCenterTableMap::GPS_LONG, $this->gps_long);
        if ($this->isColumnModified(FulfilmentCenterTableMap::STOCK_LIMIT)) $criteria->add(FulfilmentCenterTableMap::STOCK_LIMIT, $this->stock_limit);
        if ($this->isColumnModified(FulfilmentCenterTableMap::DELIVERY_COST)) $criteria->add(FulfilmentCenterTableMap::DELIVERY_COST, $this->delivery_cost);
        if ($this->isColumnModified(FulfilmentCenterTableMap::DELIVERY_METHOD)) $criteria->add(FulfilmentCenterTableMap::DELIVERY_METHOD, $this->delivery_method);

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
        $criteria = new Criteria(FulfilmentCenterTableMap::DATABASE_NAME);
        $criteria->add(FulfilmentCenterTableMap::ID, $this->id);

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
     * @param      object $copyObj An object of \MultipleFullfilmentCenters\Model\FulfilmentCenter (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setName($this->getName());
        $copyObj->setAddress($this->getAddress());
        $copyObj->setGpsLat($this->getGpsLat());
        $copyObj->setGpsLong($this->getGpsLong());
        $copyObj->setStockLimit($this->getStockLimit());
        $copyObj->setDeliveryCost($this->getDeliveryCost());
        $copyObj->setDeliveryMethod($this->getDeliveryMethod());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getFulfilmentCenterProductss() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addFulfilmentCenterProducts($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getOrderLocalPickups() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addOrderLocalPickup($relObj->copy($deepCopy));
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
     * @return                 \MultipleFullfilmentCenters\Model\FulfilmentCenter Clone of current object.
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
        if ('FulfilmentCenterProducts' == $relationName) {
            return $this->initFulfilmentCenterProductss();
        }
        if ('OrderLocalPickup' == $relationName) {
            return $this->initOrderLocalPickups();
        }
    }

    /**
     * Clears out the collFulfilmentCenterProductss collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addFulfilmentCenterProductss()
     */
    public function clearFulfilmentCenterProductss()
    {
        $this->collFulfilmentCenterProductss = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collFulfilmentCenterProductss collection loaded partially.
     */
    public function resetPartialFulfilmentCenterProductss($v = true)
    {
        $this->collFulfilmentCenterProductssPartial = $v;
    }

    /**
     * Initializes the collFulfilmentCenterProductss collection.
     *
     * By default this just sets the collFulfilmentCenterProductss collection to an empty array (like clearcollFulfilmentCenterProductss());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initFulfilmentCenterProductss($overrideExisting = true)
    {
        if (null !== $this->collFulfilmentCenterProductss && !$overrideExisting) {
            return;
        }
        $this->collFulfilmentCenterProductss = new ObjectCollection();
        $this->collFulfilmentCenterProductss->setModel('\MultipleFullfilmentCenters\Model\FulfilmentCenterProducts');
    }

    /**
     * Gets an array of ChildFulfilmentCenterProducts objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildFulfilmentCenter is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return Collection|ChildFulfilmentCenterProducts[] List of ChildFulfilmentCenterProducts objects
     * @throws PropelException
     */
    public function getFulfilmentCenterProductss($criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collFulfilmentCenterProductssPartial && !$this->isNew();
        if (null === $this->collFulfilmentCenterProductss || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collFulfilmentCenterProductss) {
                // return empty collection
                $this->initFulfilmentCenterProductss();
            } else {
                $collFulfilmentCenterProductss = ChildFulfilmentCenterProductsQuery::create(null, $criteria)
                    ->filterByFulfilmentCenter($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collFulfilmentCenterProductssPartial && count($collFulfilmentCenterProductss)) {
                        $this->initFulfilmentCenterProductss(false);

                        foreach ($collFulfilmentCenterProductss as $obj) {
                            if (false == $this->collFulfilmentCenterProductss->contains($obj)) {
                                $this->collFulfilmentCenterProductss->append($obj);
                            }
                        }

                        $this->collFulfilmentCenterProductssPartial = true;
                    }

                    reset($collFulfilmentCenterProductss);

                    return $collFulfilmentCenterProductss;
                }

                if ($partial && $this->collFulfilmentCenterProductss) {
                    foreach ($this->collFulfilmentCenterProductss as $obj) {
                        if ($obj->isNew()) {
                            $collFulfilmentCenterProductss[] = $obj;
                        }
                    }
                }

                $this->collFulfilmentCenterProductss = $collFulfilmentCenterProductss;
                $this->collFulfilmentCenterProductssPartial = false;
            }
        }

        return $this->collFulfilmentCenterProductss;
    }

    /**
     * Sets a collection of FulfilmentCenterProducts objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $fulfilmentCenterProductss A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return   ChildFulfilmentCenter The current object (for fluent API support)
     */
    public function setFulfilmentCenterProductss(Collection $fulfilmentCenterProductss, ConnectionInterface $con = null)
    {
        $fulfilmentCenterProductssToDelete = $this->getFulfilmentCenterProductss(new Criteria(), $con)->diff($fulfilmentCenterProductss);

        
        $this->fulfilmentCenterProductssScheduledForDeletion = $fulfilmentCenterProductssToDelete;

        foreach ($fulfilmentCenterProductssToDelete as $fulfilmentCenterProductsRemoved) {
            $fulfilmentCenterProductsRemoved->setFulfilmentCenter(null);
        }

        $this->collFulfilmentCenterProductss = null;
        foreach ($fulfilmentCenterProductss as $fulfilmentCenterProducts) {
            $this->addFulfilmentCenterProducts($fulfilmentCenterProducts);
        }

        $this->collFulfilmentCenterProductss = $fulfilmentCenterProductss;
        $this->collFulfilmentCenterProductssPartial = false;

        return $this;
    }

    /**
     * Returns the number of related FulfilmentCenterProducts objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related FulfilmentCenterProducts objects.
     * @throws PropelException
     */
    public function countFulfilmentCenterProductss(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collFulfilmentCenterProductssPartial && !$this->isNew();
        if (null === $this->collFulfilmentCenterProductss || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collFulfilmentCenterProductss) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getFulfilmentCenterProductss());
            }

            $query = ChildFulfilmentCenterProductsQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByFulfilmentCenter($this)
                ->count($con);
        }

        return count($this->collFulfilmentCenterProductss);
    }

    /**
     * Method called to associate a ChildFulfilmentCenterProducts object to this object
     * through the ChildFulfilmentCenterProducts foreign key attribute.
     *
     * @param    ChildFulfilmentCenterProducts $l ChildFulfilmentCenterProducts
     * @return   \MultipleFullfilmentCenters\Model\FulfilmentCenter The current object (for fluent API support)
     */
    public function addFulfilmentCenterProducts(ChildFulfilmentCenterProducts $l)
    {
        if ($this->collFulfilmentCenterProductss === null) {
            $this->initFulfilmentCenterProductss();
            $this->collFulfilmentCenterProductssPartial = true;
        }

        if (!in_array($l, $this->collFulfilmentCenterProductss->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddFulfilmentCenterProducts($l);
        }

        return $this;
    }

    /**
     * @param FulfilmentCenterProducts $fulfilmentCenterProducts The fulfilmentCenterProducts object to add.
     */
    protected function doAddFulfilmentCenterProducts($fulfilmentCenterProducts)
    {
        $this->collFulfilmentCenterProductss[]= $fulfilmentCenterProducts;
        $fulfilmentCenterProducts->setFulfilmentCenter($this);
    }

    /**
     * @param  FulfilmentCenterProducts $fulfilmentCenterProducts The fulfilmentCenterProducts object to remove.
     * @return ChildFulfilmentCenter The current object (for fluent API support)
     */
    public function removeFulfilmentCenterProducts($fulfilmentCenterProducts)
    {
        if ($this->getFulfilmentCenterProductss()->contains($fulfilmentCenterProducts)) {
            $this->collFulfilmentCenterProductss->remove($this->collFulfilmentCenterProductss->search($fulfilmentCenterProducts));
            if (null === $this->fulfilmentCenterProductssScheduledForDeletion) {
                $this->fulfilmentCenterProductssScheduledForDeletion = clone $this->collFulfilmentCenterProductss;
                $this->fulfilmentCenterProductssScheduledForDeletion->clear();
            }
            $this->fulfilmentCenterProductssScheduledForDeletion[]= $fulfilmentCenterProducts;
            $fulfilmentCenterProducts->setFulfilmentCenter(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this FulfilmentCenter is new, it will return
     * an empty collection; or if this FulfilmentCenter has previously
     * been saved, it will retrieve related FulfilmentCenterProductss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in FulfilmentCenter.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return Collection|ChildFulfilmentCenterProducts[] List of ChildFulfilmentCenterProducts objects
     */
    public function getFulfilmentCenterProductssJoinProduct($criteria = null, $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildFulfilmentCenterProductsQuery::create(null, $criteria);
        $query->joinWith('Product', $joinBehavior);

        return $this->getFulfilmentCenterProductss($query, $con);
    }

    /**
     * Clears out the collOrderLocalPickups collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addOrderLocalPickups()
     */
    public function clearOrderLocalPickups()
    {
        $this->collOrderLocalPickups = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collOrderLocalPickups collection loaded partially.
     */
    public function resetPartialOrderLocalPickups($v = true)
    {
        $this->collOrderLocalPickupsPartial = $v;
    }

    /**
     * Initializes the collOrderLocalPickups collection.
     *
     * By default this just sets the collOrderLocalPickups collection to an empty array (like clearcollOrderLocalPickups());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initOrderLocalPickups($overrideExisting = true)
    {
        if (null !== $this->collOrderLocalPickups && !$overrideExisting) {
            return;
        }
        $this->collOrderLocalPickups = new ObjectCollection();
        $this->collOrderLocalPickups->setModel('\MultipleFullfilmentCenters\Model\OrderLocalPickup');
    }

    /**
     * Gets an array of ChildOrderLocalPickup objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildFulfilmentCenter is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return Collection|ChildOrderLocalPickup[] List of ChildOrderLocalPickup objects
     * @throws PropelException
     */
    public function getOrderLocalPickups($criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collOrderLocalPickupsPartial && !$this->isNew();
        if (null === $this->collOrderLocalPickups || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collOrderLocalPickups) {
                // return empty collection
                $this->initOrderLocalPickups();
            } else {
                $collOrderLocalPickups = ChildOrderLocalPickupQuery::create(null, $criteria)
                    ->filterByFulfilmentCenter($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collOrderLocalPickupsPartial && count($collOrderLocalPickups)) {
                        $this->initOrderLocalPickups(false);

                        foreach ($collOrderLocalPickups as $obj) {
                            if (false == $this->collOrderLocalPickups->contains($obj)) {
                                $this->collOrderLocalPickups->append($obj);
                            }
                        }

                        $this->collOrderLocalPickupsPartial = true;
                    }

                    reset($collOrderLocalPickups);

                    return $collOrderLocalPickups;
                }

                if ($partial && $this->collOrderLocalPickups) {
                    foreach ($this->collOrderLocalPickups as $obj) {
                        if ($obj->isNew()) {
                            $collOrderLocalPickups[] = $obj;
                        }
                    }
                }

                $this->collOrderLocalPickups = $collOrderLocalPickups;
                $this->collOrderLocalPickupsPartial = false;
            }
        }

        return $this->collOrderLocalPickups;
    }

    /**
     * Sets a collection of OrderLocalPickup objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $orderLocalPickups A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return   ChildFulfilmentCenter The current object (for fluent API support)
     */
    public function setOrderLocalPickups(Collection $orderLocalPickups, ConnectionInterface $con = null)
    {
        $orderLocalPickupsToDelete = $this->getOrderLocalPickups(new Criteria(), $con)->diff($orderLocalPickups);

        
        $this->orderLocalPickupsScheduledForDeletion = $orderLocalPickupsToDelete;

        foreach ($orderLocalPickupsToDelete as $orderLocalPickupRemoved) {
            $orderLocalPickupRemoved->setFulfilmentCenter(null);
        }

        $this->collOrderLocalPickups = null;
        foreach ($orderLocalPickups as $orderLocalPickup) {
            $this->addOrderLocalPickup($orderLocalPickup);
        }

        $this->collOrderLocalPickups = $orderLocalPickups;
        $this->collOrderLocalPickupsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related OrderLocalPickup objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related OrderLocalPickup objects.
     * @throws PropelException
     */
    public function countOrderLocalPickups(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collOrderLocalPickupsPartial && !$this->isNew();
        if (null === $this->collOrderLocalPickups || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collOrderLocalPickups) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getOrderLocalPickups());
            }

            $query = ChildOrderLocalPickupQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByFulfilmentCenter($this)
                ->count($con);
        }

        return count($this->collOrderLocalPickups);
    }

    /**
     * Method called to associate a ChildOrderLocalPickup object to this object
     * through the ChildOrderLocalPickup foreign key attribute.
     *
     * @param    ChildOrderLocalPickup $l ChildOrderLocalPickup
     * @return   \MultipleFullfilmentCenters\Model\FulfilmentCenter The current object (for fluent API support)
     */
    public function addOrderLocalPickup(ChildOrderLocalPickup $l)
    {
        if ($this->collOrderLocalPickups === null) {
            $this->initOrderLocalPickups();
            $this->collOrderLocalPickupsPartial = true;
        }

        if (!in_array($l, $this->collOrderLocalPickups->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddOrderLocalPickup($l);
        }

        return $this;
    }

    /**
     * @param OrderLocalPickup $orderLocalPickup The orderLocalPickup object to add.
     */
    protected function doAddOrderLocalPickup($orderLocalPickup)
    {
        $this->collOrderLocalPickups[]= $orderLocalPickup;
        $orderLocalPickup->setFulfilmentCenter($this);
    }

    /**
     * @param  OrderLocalPickup $orderLocalPickup The orderLocalPickup object to remove.
     * @return ChildFulfilmentCenter The current object (for fluent API support)
     */
    public function removeOrderLocalPickup($orderLocalPickup)
    {
        if ($this->getOrderLocalPickups()->contains($orderLocalPickup)) {
            $this->collOrderLocalPickups->remove($this->collOrderLocalPickups->search($orderLocalPickup));
            if (null === $this->orderLocalPickupsScheduledForDeletion) {
                $this->orderLocalPickupsScheduledForDeletion = clone $this->collOrderLocalPickups;
                $this->orderLocalPickupsScheduledForDeletion->clear();
            }
            $this->orderLocalPickupsScheduledForDeletion[]= clone $orderLocalPickup;
            $orderLocalPickup->setFulfilmentCenter(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this FulfilmentCenter is new, it will return
     * an empty collection; or if this FulfilmentCenter has previously
     * been saved, it will retrieve related OrderLocalPickups from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in FulfilmentCenter.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return Collection|ChildOrderLocalPickup[] List of ChildOrderLocalPickup objects
     */
    public function getOrderLocalPickupsJoinOrder($criteria = null, $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildOrderLocalPickupQuery::create(null, $criteria);
        $query->joinWith('Order', $joinBehavior);

        return $this->getOrderLocalPickups($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this FulfilmentCenter is new, it will return
     * an empty collection; or if this FulfilmentCenter has previously
     * been saved, it will retrieve related OrderLocalPickups from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in FulfilmentCenter.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return Collection|ChildOrderLocalPickup[] List of ChildOrderLocalPickup objects
     */
    public function getOrderLocalPickupsJoinProduct($criteria = null, $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildOrderLocalPickupQuery::create(null, $criteria);
        $query->joinWith('Product', $joinBehavior);

        return $this->getOrderLocalPickups($query, $con);
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->id = null;
        $this->name = null;
        $this->address = null;
        $this->gps_lat = null;
        $this->gps_long = null;
        $this->stock_limit = null;
        $this->delivery_cost = null;
        $this->delivery_method = null;
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
            if ($this->collFulfilmentCenterProductss) {
                foreach ($this->collFulfilmentCenterProductss as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collOrderLocalPickups) {
                foreach ($this->collOrderLocalPickups as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collFulfilmentCenterProductss = null;
        $this->collOrderLocalPickups = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(FulfilmentCenterTableMap::DEFAULT_STRING_FORMAT);
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
