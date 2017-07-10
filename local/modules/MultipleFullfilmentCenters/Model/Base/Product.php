<?php

namespace MultipleFullfilmentCenters\Model\Base;

use \DateTime;
use \Exception;
use \PDO;
use MultipleFullfilmentCenters\Model\FulfilmentCenterProducts as ChildFulfilmentCenterProducts;
use MultipleFullfilmentCenters\Model\FulfilmentCenterProductsQuery as ChildFulfilmentCenterProductsQuery;
use MultipleFullfilmentCenters\Model\Product as ChildProduct;
use MultipleFullfilmentCenters\Model\ProductI18n as ChildProductI18n;
use MultipleFullfilmentCenters\Model\ProductI18nQuery as ChildProductI18nQuery;
use MultipleFullfilmentCenters\Model\ProductQuery as ChildProductQuery;
use MultipleFullfilmentCenters\Model\Map\ProductTableMap;
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

abstract class Product implements ActiveRecordInterface 
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\MultipleFullfilmentCenters\\Model\\Map\\ProductTableMap';


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
     * The value for the tax_rule_id field.
     * @var        int
     */
    protected $tax_rule_id;

    /**
     * The value for the ref field.
     * @var        string
     */
    protected $ref;

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
     * The value for the template_id field.
     * @var        int
     */
    protected $template_id;

    /**
     * The value for the brand_id field.
     * @var        int
     */
    protected $brand_id;

    /**
     * The value for the virtual field.
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $virtual;

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
     * @var        ObjectCollection|ChildFulfilmentCenterProducts[] Collection to store aggregation of ChildFulfilmentCenterProducts objects.
     */
    protected $collFulfilmentCenterProductss;
    protected $collFulfilmentCenterProductssPartial;

    /**
     * @var        ObjectCollection|ChildProductI18n[] Collection to store aggregation of ChildProductI18n objects.
     */
    protected $collProductI18ns;
    protected $collProductI18nsPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    // i18n behavior
    
    /**
     * Current locale
     * @var        string
     */
    protected $currentLocale = 'en_US';
    
    /**
     * Current translation objects
     * @var        array[ChildProductI18n]
     */
    protected $currentTranslations;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection
     */
    protected $fulfilmentCenterProductssScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection
     */
    protected $productI18nsScheduledForDeletion = null;

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
        $this->virtual = 0;
    }

    /**
     * Initializes internal state of MultipleFullfilmentCenters\Model\Base\Product object.
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
     * Compares this with another <code>Product</code> instance.  If
     * <code>obj</code> is an instance of <code>Product</code>, delegates to
     * <code>equals(Product)</code>.  Otherwise, returns <code>false</code>.
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
     * @return Product The current object, for fluid interface
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
     * @return Product The current object, for fluid interface
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
     * Get the [tax_rule_id] column value.
     * 
     * @return   int
     */
    public function getTaxRuleId()
    {

        return $this->tax_rule_id;
    }

    /**
     * Get the [ref] column value.
     * 
     * @return   string
     */
    public function getRef()
    {

        return $this->ref;
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
     * Get the [template_id] column value.
     * 
     * @return   int
     */
    public function getTemplateId()
    {

        return $this->template_id;
    }

    /**
     * Get the [brand_id] column value.
     * 
     * @return   int
     */
    public function getBrandId()
    {

        return $this->brand_id;
    }

    /**
     * Get the [virtual] column value.
     * 
     * @return   int
     */
    public function getVirtual()
    {

        return $this->virtual;
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
     * @return   \MultipleFullfilmentCenters\Model\Product The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[ProductTableMap::ID] = true;
        }


        return $this;
    } // setId()

    /**
     * Set the value of [tax_rule_id] column.
     * 
     * @param      int $v new value
     * @return   \MultipleFullfilmentCenters\Model\Product The current object (for fluent API support)
     */
    public function setTaxRuleId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->tax_rule_id !== $v) {
            $this->tax_rule_id = $v;
            $this->modifiedColumns[ProductTableMap::TAX_RULE_ID] = true;
        }


        return $this;
    } // setTaxRuleId()

    /**
     * Set the value of [ref] column.
     * 
     * @param      string $v new value
     * @return   \MultipleFullfilmentCenters\Model\Product The current object (for fluent API support)
     */
    public function setRef($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->ref !== $v) {
            $this->ref = $v;
            $this->modifiedColumns[ProductTableMap::REF] = true;
        }


        return $this;
    } // setRef()

    /**
     * Set the value of [visible] column.
     * 
     * @param      int $v new value
     * @return   \MultipleFullfilmentCenters\Model\Product The current object (for fluent API support)
     */
    public function setVisible($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->visible !== $v) {
            $this->visible = $v;
            $this->modifiedColumns[ProductTableMap::VISIBLE] = true;
        }


        return $this;
    } // setVisible()

    /**
     * Set the value of [position] column.
     * 
     * @param      int $v new value
     * @return   \MultipleFullfilmentCenters\Model\Product The current object (for fluent API support)
     */
    public function setPosition($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->position !== $v) {
            $this->position = $v;
            $this->modifiedColumns[ProductTableMap::POSITION] = true;
        }


        return $this;
    } // setPosition()

    /**
     * Set the value of [template_id] column.
     * 
     * @param      int $v new value
     * @return   \MultipleFullfilmentCenters\Model\Product The current object (for fluent API support)
     */
    public function setTemplateId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->template_id !== $v) {
            $this->template_id = $v;
            $this->modifiedColumns[ProductTableMap::TEMPLATE_ID] = true;
        }


        return $this;
    } // setTemplateId()

    /**
     * Set the value of [brand_id] column.
     * 
     * @param      int $v new value
     * @return   \MultipleFullfilmentCenters\Model\Product The current object (for fluent API support)
     */
    public function setBrandId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->brand_id !== $v) {
            $this->brand_id = $v;
            $this->modifiedColumns[ProductTableMap::BRAND_ID] = true;
        }


        return $this;
    } // setBrandId()

    /**
     * Set the value of [virtual] column.
     * 
     * @param      int $v new value
     * @return   \MultipleFullfilmentCenters\Model\Product The current object (for fluent API support)
     */
    public function setVirtual($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->virtual !== $v) {
            $this->virtual = $v;
            $this->modifiedColumns[ProductTableMap::VIRTUAL] = true;
        }


        return $this;
    } // setVirtual()

    /**
     * Sets the value of [created_at] column to a normalized version of the date/time value specified.
     * 
     * @param      mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return   \MultipleFullfilmentCenters\Model\Product The current object (for fluent API support)
     */
    public function setCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->created_at !== null || $dt !== null) {
            if ($dt !== $this->created_at) {
                $this->created_at = $dt;
                $this->modifiedColumns[ProductTableMap::CREATED_AT] = true;
            }
        } // if either are not null


        return $this;
    } // setCreatedAt()

    /**
     * Sets the value of [updated_at] column to a normalized version of the date/time value specified.
     * 
     * @param      mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return   \MultipleFullfilmentCenters\Model\Product The current object (for fluent API support)
     */
    public function setUpdatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->updated_at !== null || $dt !== null) {
            if ($dt !== $this->updated_at) {
                $this->updated_at = $dt;
                $this->modifiedColumns[ProductTableMap::UPDATED_AT] = true;
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

            if ($this->virtual !== 0) {
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


            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : ProductTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : ProductTableMap::translateFieldName('TaxRuleId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->tax_rule_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : ProductTableMap::translateFieldName('Ref', TableMap::TYPE_PHPNAME, $indexType)];
            $this->ref = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : ProductTableMap::translateFieldName('Visible', TableMap::TYPE_PHPNAME, $indexType)];
            $this->visible = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : ProductTableMap::translateFieldName('Position', TableMap::TYPE_PHPNAME, $indexType)];
            $this->position = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : ProductTableMap::translateFieldName('TemplateId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->template_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : ProductTableMap::translateFieldName('BrandId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->brand_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : ProductTableMap::translateFieldName('Virtual', TableMap::TYPE_PHPNAME, $indexType)];
            $this->virtual = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : ProductTableMap::translateFieldName('CreatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->created_at = (null !== $col) ? PropelDateTime::newInstance($col, null, '\DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : ProductTableMap::translateFieldName('UpdatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->updated_at = (null !== $col) ? PropelDateTime::newInstance($col, null, '\DateTime') : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 10; // 10 = ProductTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating \MultipleFullfilmentCenters\Model\Product object", 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(ProductTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildProductQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collFulfilmentCenterProductss = null;

            $this->collProductI18ns = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Product::setDeleted()
     * @see Product::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(ProductTableMap::DATABASE_NAME);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = ChildProductQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(ProductTableMap::DATABASE_NAME);
        }

        $con->beginTransaction();
        $isInsert = $this->isNew();
        try {
            $ret = $this->preSave($con);
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
                // timestampable behavior
                if (!$this->isColumnModified(ProductTableMap::CREATED_AT)) {
                    $this->setCreatedAt(time());
                }
                if (!$this->isColumnModified(ProductTableMap::UPDATED_AT)) {
                    $this->setUpdatedAt(time());
                }
            } else {
                $ret = $ret && $this->preUpdate($con);
                // timestampable behavior
                if ($this->isModified() && !$this->isColumnModified(ProductTableMap::UPDATED_AT)) {
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
                ProductTableMap::addInstanceToPool($this);
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

            if ($this->productI18nsScheduledForDeletion !== null) {
                if (!$this->productI18nsScheduledForDeletion->isEmpty()) {
                    \MultipleFullfilmentCenters\Model\ProductI18nQuery::create()
                        ->filterByPrimaryKeys($this->productI18nsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->productI18nsScheduledForDeletion = null;
                }
            }

                if ($this->collProductI18ns !== null) {
            foreach ($this->collProductI18ns as $referrerFK) {
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

        $this->modifiedColumns[ProductTableMap::ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . ProductTableMap::ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(ProductTableMap::ID)) {
            $modifiedColumns[':p' . $index++]  = 'ID';
        }
        if ($this->isColumnModified(ProductTableMap::TAX_RULE_ID)) {
            $modifiedColumns[':p' . $index++]  = 'TAX_RULE_ID';
        }
        if ($this->isColumnModified(ProductTableMap::REF)) {
            $modifiedColumns[':p' . $index++]  = 'REF';
        }
        if ($this->isColumnModified(ProductTableMap::VISIBLE)) {
            $modifiedColumns[':p' . $index++]  = 'VISIBLE';
        }
        if ($this->isColumnModified(ProductTableMap::POSITION)) {
            $modifiedColumns[':p' . $index++]  = 'POSITION';
        }
        if ($this->isColumnModified(ProductTableMap::TEMPLATE_ID)) {
            $modifiedColumns[':p' . $index++]  = 'TEMPLATE_ID';
        }
        if ($this->isColumnModified(ProductTableMap::BRAND_ID)) {
            $modifiedColumns[':p' . $index++]  = 'BRAND_ID';
        }
        if ($this->isColumnModified(ProductTableMap::VIRTUAL)) {
            $modifiedColumns[':p' . $index++]  = 'VIRTUAL';
        }
        if ($this->isColumnModified(ProductTableMap::CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'CREATED_AT';
        }
        if ($this->isColumnModified(ProductTableMap::UPDATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'UPDATED_AT';
        }

        $sql = sprintf(
            'INSERT INTO product (%s) VALUES (%s)',
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
                    case 'TAX_RULE_ID':                        
                        $stmt->bindValue($identifier, $this->tax_rule_id, PDO::PARAM_INT);
                        break;
                    case 'REF':                        
                        $stmt->bindValue($identifier, $this->ref, PDO::PARAM_STR);
                        break;
                    case 'VISIBLE':                        
                        $stmt->bindValue($identifier, $this->visible, PDO::PARAM_INT);
                        break;
                    case 'POSITION':                        
                        $stmt->bindValue($identifier, $this->position, PDO::PARAM_INT);
                        break;
                    case 'TEMPLATE_ID':                        
                        $stmt->bindValue($identifier, $this->template_id, PDO::PARAM_INT);
                        break;
                    case 'BRAND_ID':                        
                        $stmt->bindValue($identifier, $this->brand_id, PDO::PARAM_INT);
                        break;
                    case 'VIRTUAL':                        
                        $stmt->bindValue($identifier, $this->virtual, PDO::PARAM_INT);
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
        $pos = ProductTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getTaxRuleId();
                break;
            case 2:
                return $this->getRef();
                break;
            case 3:
                return $this->getVisible();
                break;
            case 4:
                return $this->getPosition();
                break;
            case 5:
                return $this->getTemplateId();
                break;
            case 6:
                return $this->getBrandId();
                break;
            case 7:
                return $this->getVirtual();
                break;
            case 8:
                return $this->getCreatedAt();
                break;
            case 9:
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
        if (isset($alreadyDumpedObjects['Product'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Product'][$this->getPrimaryKey()] = true;
        $keys = ProductTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getTaxRuleId(),
            $keys[2] => $this->getRef(),
            $keys[3] => $this->getVisible(),
            $keys[4] => $this->getPosition(),
            $keys[5] => $this->getTemplateId(),
            $keys[6] => $this->getBrandId(),
            $keys[7] => $this->getVirtual(),
            $keys[8] => $this->getCreatedAt(),
            $keys[9] => $this->getUpdatedAt(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }
        
        if ($includeForeignObjects) {
            if (null !== $this->collFulfilmentCenterProductss) {
                $result['FulfilmentCenterProductss'] = $this->collFulfilmentCenterProductss->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collProductI18ns) {
                $result['ProductI18ns'] = $this->collProductI18ns->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
        $pos = ProductTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

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
                $this->setTaxRuleId($value);
                break;
            case 2:
                $this->setRef($value);
                break;
            case 3:
                $this->setVisible($value);
                break;
            case 4:
                $this->setPosition($value);
                break;
            case 5:
                $this->setTemplateId($value);
                break;
            case 6:
                $this->setBrandId($value);
                break;
            case 7:
                $this->setVirtual($value);
                break;
            case 8:
                $this->setCreatedAt($value);
                break;
            case 9:
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
        $keys = ProductTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setTaxRuleId($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setRef($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setVisible($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setPosition($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setTemplateId($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setBrandId($arr[$keys[6]]);
        if (array_key_exists($keys[7], $arr)) $this->setVirtual($arr[$keys[7]]);
        if (array_key_exists($keys[8], $arr)) $this->setCreatedAt($arr[$keys[8]]);
        if (array_key_exists($keys[9], $arr)) $this->setUpdatedAt($arr[$keys[9]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(ProductTableMap::DATABASE_NAME);

        if ($this->isColumnModified(ProductTableMap::ID)) $criteria->add(ProductTableMap::ID, $this->id);
        if ($this->isColumnModified(ProductTableMap::TAX_RULE_ID)) $criteria->add(ProductTableMap::TAX_RULE_ID, $this->tax_rule_id);
        if ($this->isColumnModified(ProductTableMap::REF)) $criteria->add(ProductTableMap::REF, $this->ref);
        if ($this->isColumnModified(ProductTableMap::VISIBLE)) $criteria->add(ProductTableMap::VISIBLE, $this->visible);
        if ($this->isColumnModified(ProductTableMap::POSITION)) $criteria->add(ProductTableMap::POSITION, $this->position);
        if ($this->isColumnModified(ProductTableMap::TEMPLATE_ID)) $criteria->add(ProductTableMap::TEMPLATE_ID, $this->template_id);
        if ($this->isColumnModified(ProductTableMap::BRAND_ID)) $criteria->add(ProductTableMap::BRAND_ID, $this->brand_id);
        if ($this->isColumnModified(ProductTableMap::VIRTUAL)) $criteria->add(ProductTableMap::VIRTUAL, $this->virtual);
        if ($this->isColumnModified(ProductTableMap::CREATED_AT)) $criteria->add(ProductTableMap::CREATED_AT, $this->created_at);
        if ($this->isColumnModified(ProductTableMap::UPDATED_AT)) $criteria->add(ProductTableMap::UPDATED_AT, $this->updated_at);

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
        $criteria = new Criteria(ProductTableMap::DATABASE_NAME);
        $criteria->add(ProductTableMap::ID, $this->id);

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
     * @param      object $copyObj An object of \MultipleFullfilmentCenters\Model\Product (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setTaxRuleId($this->getTaxRuleId());
        $copyObj->setRef($this->getRef());
        $copyObj->setVisible($this->getVisible());
        $copyObj->setPosition($this->getPosition());
        $copyObj->setTemplateId($this->getTemplateId());
        $copyObj->setBrandId($this->getBrandId());
        $copyObj->setVirtual($this->getVirtual());
        $copyObj->setCreatedAt($this->getCreatedAt());
        $copyObj->setUpdatedAt($this->getUpdatedAt());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getFulfilmentCenterProductss() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addFulfilmentCenterProducts($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getProductI18ns() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addProductI18n($relObj->copy($deepCopy));
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
     * @return                 \MultipleFullfilmentCenters\Model\Product Clone of current object.
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
        if ('ProductI18n' == $relationName) {
            return $this->initProductI18ns();
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
     * If this ChildProduct is new, it will return
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
                    ->filterByProduct($this)
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
     * @return   ChildProduct The current object (for fluent API support)
     */
    public function setFulfilmentCenterProductss(Collection $fulfilmentCenterProductss, ConnectionInterface $con = null)
    {
        $fulfilmentCenterProductssToDelete = $this->getFulfilmentCenterProductss(new Criteria(), $con)->diff($fulfilmentCenterProductss);

        
        $this->fulfilmentCenterProductssScheduledForDeletion = $fulfilmentCenterProductssToDelete;

        foreach ($fulfilmentCenterProductssToDelete as $fulfilmentCenterProductsRemoved) {
            $fulfilmentCenterProductsRemoved->setProduct(null);
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
                ->filterByProduct($this)
                ->count($con);
        }

        return count($this->collFulfilmentCenterProductss);
    }

    /**
     * Method called to associate a ChildFulfilmentCenterProducts object to this object
     * through the ChildFulfilmentCenterProducts foreign key attribute.
     *
     * @param    ChildFulfilmentCenterProducts $l ChildFulfilmentCenterProducts
     * @return   \MultipleFullfilmentCenters\Model\Product The current object (for fluent API support)
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
        $fulfilmentCenterProducts->setProduct($this);
    }

    /**
     * @param  FulfilmentCenterProducts $fulfilmentCenterProducts The fulfilmentCenterProducts object to remove.
     * @return ChildProduct The current object (for fluent API support)
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
            $fulfilmentCenterProducts->setProduct(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Product is new, it will return
     * an empty collection; or if this Product has previously
     * been saved, it will retrieve related FulfilmentCenterProductss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Product.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return Collection|ChildFulfilmentCenterProducts[] List of ChildFulfilmentCenterProducts objects
     */
    public function getFulfilmentCenterProductssJoinFulfilmentCenter($criteria = null, $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildFulfilmentCenterProductsQuery::create(null, $criteria);
        $query->joinWith('FulfilmentCenter', $joinBehavior);

        return $this->getFulfilmentCenterProductss($query, $con);
    }

    /**
     * Clears out the collProductI18ns collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addProductI18ns()
     */
    public function clearProductI18ns()
    {
        $this->collProductI18ns = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collProductI18ns collection loaded partially.
     */
    public function resetPartialProductI18ns($v = true)
    {
        $this->collProductI18nsPartial = $v;
    }

    /**
     * Initializes the collProductI18ns collection.
     *
     * By default this just sets the collProductI18ns collection to an empty array (like clearcollProductI18ns());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initProductI18ns($overrideExisting = true)
    {
        if (null !== $this->collProductI18ns && !$overrideExisting) {
            return;
        }
        $this->collProductI18ns = new ObjectCollection();
        $this->collProductI18ns->setModel('\MultipleFullfilmentCenters\Model\ProductI18n');
    }

    /**
     * Gets an array of ChildProductI18n objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildProduct is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return Collection|ChildProductI18n[] List of ChildProductI18n objects
     * @throws PropelException
     */
    public function getProductI18ns($criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collProductI18nsPartial && !$this->isNew();
        if (null === $this->collProductI18ns || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collProductI18ns) {
                // return empty collection
                $this->initProductI18ns();
            } else {
                $collProductI18ns = ChildProductI18nQuery::create(null, $criteria)
                    ->filterByProduct($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collProductI18nsPartial && count($collProductI18ns)) {
                        $this->initProductI18ns(false);

                        foreach ($collProductI18ns as $obj) {
                            if (false == $this->collProductI18ns->contains($obj)) {
                                $this->collProductI18ns->append($obj);
                            }
                        }

                        $this->collProductI18nsPartial = true;
                    }

                    reset($collProductI18ns);

                    return $collProductI18ns;
                }

                if ($partial && $this->collProductI18ns) {
                    foreach ($this->collProductI18ns as $obj) {
                        if ($obj->isNew()) {
                            $collProductI18ns[] = $obj;
                        }
                    }
                }

                $this->collProductI18ns = $collProductI18ns;
                $this->collProductI18nsPartial = false;
            }
        }

        return $this->collProductI18ns;
    }

    /**
     * Sets a collection of ProductI18n objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $productI18ns A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return   ChildProduct The current object (for fluent API support)
     */
    public function setProductI18ns(Collection $productI18ns, ConnectionInterface $con = null)
    {
        $productI18nsToDelete = $this->getProductI18ns(new Criteria(), $con)->diff($productI18ns);

        
        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->productI18nsScheduledForDeletion = clone $productI18nsToDelete;

        foreach ($productI18nsToDelete as $productI18nRemoved) {
            $productI18nRemoved->setProduct(null);
        }

        $this->collProductI18ns = null;
        foreach ($productI18ns as $productI18n) {
            $this->addProductI18n($productI18n);
        }

        $this->collProductI18ns = $productI18ns;
        $this->collProductI18nsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related ProductI18n objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related ProductI18n objects.
     * @throws PropelException
     */
    public function countProductI18ns(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collProductI18nsPartial && !$this->isNew();
        if (null === $this->collProductI18ns || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collProductI18ns) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getProductI18ns());
            }

            $query = ChildProductI18nQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByProduct($this)
                ->count($con);
        }

        return count($this->collProductI18ns);
    }

    /**
     * Method called to associate a ChildProductI18n object to this object
     * through the ChildProductI18n foreign key attribute.
     *
     * @param    ChildProductI18n $l ChildProductI18n
     * @return   \MultipleFullfilmentCenters\Model\Product The current object (for fluent API support)
     */
    public function addProductI18n(ChildProductI18n $l)
    {
        if ($l && $locale = $l->getLocale()) {
            $this->setLocale($locale);
            $this->currentTranslations[$locale] = $l;
        }
        if ($this->collProductI18ns === null) {
            $this->initProductI18ns();
            $this->collProductI18nsPartial = true;
        }

        if (!in_array($l, $this->collProductI18ns->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddProductI18n($l);
        }

        return $this;
    }

    /**
     * @param ProductI18n $productI18n The productI18n object to add.
     */
    protected function doAddProductI18n($productI18n)
    {
        $this->collProductI18ns[]= $productI18n;
        $productI18n->setProduct($this);
    }

    /**
     * @param  ProductI18n $productI18n The productI18n object to remove.
     * @return ChildProduct The current object (for fluent API support)
     */
    public function removeProductI18n($productI18n)
    {
        if ($this->getProductI18ns()->contains($productI18n)) {
            $this->collProductI18ns->remove($this->collProductI18ns->search($productI18n));
            if (null === $this->productI18nsScheduledForDeletion) {
                $this->productI18nsScheduledForDeletion = clone $this->collProductI18ns;
                $this->productI18nsScheduledForDeletion->clear();
            }
            $this->productI18nsScheduledForDeletion[]= clone $productI18n;
            $productI18n->setProduct(null);
        }

        return $this;
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->id = null;
        $this->tax_rule_id = null;
        $this->ref = null;
        $this->visible = null;
        $this->position = null;
        $this->template_id = null;
        $this->brand_id = null;
        $this->virtual = null;
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
            if ($this->collFulfilmentCenterProductss) {
                foreach ($this->collFulfilmentCenterProductss as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collProductI18ns) {
                foreach ($this->collProductI18ns as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        // i18n behavior
        $this->currentLocale = 'en_US';
        $this->currentTranslations = null;

        $this->collFulfilmentCenterProductss = null;
        $this->collProductI18ns = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(ProductTableMap::DEFAULT_STRING_FORMAT);
    }

    // timestampable behavior
    
    /**
     * Mark the current object so that the update date doesn't get updated during next save
     *
     * @return     ChildProduct The current object (for fluent API support)
     */
    public function keepUpdateDateUnchanged()
    {
        $this->modifiedColumns[ProductTableMap::UPDATED_AT] = true;
    
        return $this;
    }

    // i18n behavior
    
    /**
     * Sets the locale for translations
     *
     * @param     string $locale Locale to use for the translation, e.g. 'fr_FR'
     *
     * @return    ChildProduct The current object (for fluent API support)
     */
    public function setLocale($locale = 'en_US')
    {
        $this->currentLocale = $locale;
    
        return $this;
    }
    
    /**
     * Gets the locale for translations
     *
     * @return    string $locale Locale to use for the translation, e.g. 'fr_FR'
     */
    public function getLocale()
    {
        return $this->currentLocale;
    }
    
    /**
     * Returns the current translation for a given locale
     *
     * @param     string $locale Locale to use for the translation, e.g. 'fr_FR'
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ChildProductI18n */
    public function getTranslation($locale = 'en_US', ConnectionInterface $con = null)
    {
        if (!isset($this->currentTranslations[$locale])) {
            if (null !== $this->collProductI18ns) {
                foreach ($this->collProductI18ns as $translation) {
                    if ($translation->getLocale() == $locale) {
                        $this->currentTranslations[$locale] = $translation;
    
                        return $translation;
                    }
                }
            }
            if ($this->isNew()) {
                $translation = new ChildProductI18n();
                $translation->setLocale($locale);
            } else {
                $translation = ChildProductI18nQuery::create()
                    ->filterByPrimaryKey(array($this->getPrimaryKey(), $locale))
                    ->findOneOrCreate($con);
                $this->currentTranslations[$locale] = $translation;
            }
            $this->addProductI18n($translation);
        }
    
        return $this->currentTranslations[$locale];
    }
    
    /**
     * Remove the translation for a given locale
     *
     * @param     string $locale Locale to use for the translation, e.g. 'fr_FR'
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return    ChildProduct The current object (for fluent API support)
     */
    public function removeTranslation($locale = 'en_US', ConnectionInterface $con = null)
    {
        if (!$this->isNew()) {
            ChildProductI18nQuery::create()
                ->filterByPrimaryKey(array($this->getPrimaryKey(), $locale))
                ->delete($con);
        }
        if (isset($this->currentTranslations[$locale])) {
            unset($this->currentTranslations[$locale]);
        }
        foreach ($this->collProductI18ns as $key => $translation) {
            if ($translation->getLocale() == $locale) {
                unset($this->collProductI18ns[$key]);
                break;
            }
        }
    
        return $this;
    }
    
    /**
     * Returns the current translation
     *
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ChildProductI18n */
    public function getCurrentTranslation(ConnectionInterface $con = null)
    {
        return $this->getTranslation($this->getLocale(), $con);
    }
    
    
        /**
         * Get the [title] column value.
         * 
         * @return   string
         */
        public function getTitle()
        {
        return $this->getCurrentTranslation()->getTitle();
    }
    
    
        /**
         * Set the value of [title] column.
         * 
         * @param      string $v new value
         * @return   \MultipleFullfilmentCenters\Model\ProductI18n The current object (for fluent API support)
         */
        public function setTitle($v)
        {    $this->getCurrentTranslation()->setTitle($v);
    
        return $this;
    }
    
    
        /**
         * Get the [description] column value.
         * 
         * @return   string
         */
        public function getDescription()
        {
        return $this->getCurrentTranslation()->getDescription();
    }
    
    
        /**
         * Set the value of [description] column.
         * 
         * @param      string $v new value
         * @return   \MultipleFullfilmentCenters\Model\ProductI18n The current object (for fluent API support)
         */
        public function setDescription($v)
        {    $this->getCurrentTranslation()->setDescription($v);
    
        return $this;
    }
    
    
        /**
         * Get the [chapo] column value.
         * 
         * @return   string
         */
        public function getChapo()
        {
        return $this->getCurrentTranslation()->getChapo();
    }
    
    
        /**
         * Set the value of [chapo] column.
         * 
         * @param      string $v new value
         * @return   \MultipleFullfilmentCenters\Model\ProductI18n The current object (for fluent API support)
         */
        public function setChapo($v)
        {    $this->getCurrentTranslation()->setChapo($v);
    
        return $this;
    }
    
    
        /**
         * Get the [postscriptum] column value.
         * 
         * @return   string
         */
        public function getPostscriptum()
        {
        return $this->getCurrentTranslation()->getPostscriptum();
    }
    
    
        /**
         * Set the value of [postscriptum] column.
         * 
         * @param      string $v new value
         * @return   \MultipleFullfilmentCenters\Model\ProductI18n The current object (for fluent API support)
         */
        public function setPostscriptum($v)
        {    $this->getCurrentTranslation()->setPostscriptum($v);
    
        return $this;
    }
    
    
        /**
         * Get the [meta_title] column value.
         * 
         * @return   string
         */
        public function getMetaTitle()
        {
        return $this->getCurrentTranslation()->getMetaTitle();
    }
    
    
        /**
         * Set the value of [meta_title] column.
         * 
         * @param      string $v new value
         * @return   \MultipleFullfilmentCenters\Model\ProductI18n The current object (for fluent API support)
         */
        public function setMetaTitle($v)
        {    $this->getCurrentTranslation()->setMetaTitle($v);
    
        return $this;
    }
    
    
        /**
         * Get the [meta_description] column value.
         * 
         * @return   string
         */
        public function getMetaDescription()
        {
        return $this->getCurrentTranslation()->getMetaDescription();
    }
    
    
        /**
         * Set the value of [meta_description] column.
         * 
         * @param      string $v new value
         * @return   \MultipleFullfilmentCenters\Model\ProductI18n The current object (for fluent API support)
         */
        public function setMetaDescription($v)
        {    $this->getCurrentTranslation()->setMetaDescription($v);
    
        return $this;
    }
    
    
        /**
         * Get the [meta_keywords] column value.
         * 
         * @return   string
         */
        public function getMetaKeywords()
        {
        return $this->getCurrentTranslation()->getMetaKeywords();
    }
    
    
        /**
         * Set the value of [meta_keywords] column.
         * 
         * @param      string $v new value
         * @return   \MultipleFullfilmentCenters\Model\ProductI18n The current object (for fluent API support)
         */
        public function setMetaKeywords($v)
        {    $this->getCurrentTranslation()->setMetaKeywords($v);
    
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
