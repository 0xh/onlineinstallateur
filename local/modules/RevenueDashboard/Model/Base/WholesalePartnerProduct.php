<?php

namespace RevenueDashboard\Model\Base;

use \DateTime;
use \Exception;
use \PDO;
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
use RevenueDashboard\Model\WholesalePartnerProduct as ChildWholesalePartnerProduct;
use RevenueDashboard\Model\WholesalePartnerProductQuery as ChildWholesalePartnerProductQuery;
use RevenueDashboard\Model\WholesalePartnerProductVersion as ChildWholesalePartnerProductVersion;
use RevenueDashboard\Model\WholesalePartnerProductVersionQuery as ChildWholesalePartnerProductVersionQuery;
use RevenueDashboard\Model\Map\WholesalePartnerProductTableMap;
use RevenueDashboard\Model\Map\WholesalePartnerProductVersionTableMap;
use Thelia\Model\Product as ChildProduct;
use Thelia\Model\ProductQuery;
use Thelia\Model\ProductVersionQuery;

abstract class WholesalePartnerProduct implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\RevenueDashboard\\Model\\Map\\WholesalePartnerProductTableMap';


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
     * The value for the partner_id field.
     * @var        int
     */
    protected $partner_id;

    /**
     * The value for the product_id field.
     * @var        int
     */
    protected $product_id;

    /**
     * The value for the partner_product_ref field.
     * @var        string
     */
    protected $partner_product_ref;

    /**
     * The value for the price field.
     * Note: this column has a database default value of: '0.00'
     * @var        string
     */
    protected $price;

    /**
     * The value for the package_size field.
     * @var        int
     */
    protected $package_size;

    /**
     * The value for the delivery_cost field.
     * Note: this column has a database default value of: '0.00'
     * @var        string
     */
    protected $delivery_cost;

    /**
     * The value for the discount field.
     * Note: this column has a database default value of: '0.00'
     * @var        string
     */
    protected $discount;

    /**
     * The value for the discount_description field.
     * @var        string
     */
    protected $discount_description;

    /**
     * The value for the profile_website field.
     * @var        string
     */
    protected $profile_website;

    /**
     * The value for the position field.
     * @var        string
     */
    protected $position;

    /**
     * The value for the department field.
     * @var        string
     */
    protected $department;

    /**
     * The value for the comment field.
     * @var        string
     */
    protected $comment;

    /**
     * The value for the valid_until field.
     * @var        string
     */
    protected $valid_until;

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
     * @var        ObjectCollection|ChildWholesalePartnerProductVersion[] Collection to store aggregation of ChildWholesalePartnerProductVersion objects.
     */
    protected $collWholesalePartnerProductVersions;
    protected $collWholesalePartnerProductVersionsPartial;

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
    protected $wholesalePartnerProductVersionsScheduledForDeletion = null;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see __construct()
     */
    public function applyDefaultValues()
    {
        $this->price = '0.00';
        $this->delivery_cost = '0.00';
        $this->discount = '0.00';
        $this->version = 0;
    }

    /**
     * Initializes internal state of RevenueDashboard\Model\Base\WholesalePartnerProduct object.
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
     * Compares this with another <code>WholesalePartnerProduct</code> instance.  If
     * <code>obj</code> is an instance of <code>WholesalePartnerProduct</code>, delegates to
     * <code>equals(WholesalePartnerProduct)</code>.  Otherwise, returns <code>false</code>.
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
     * @return WholesalePartnerProduct The current object, for fluid interface
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
     * @return WholesalePartnerProduct The current object, for fluid interface
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
     * Get the [partner_id] column value.
     *
     * @return   int
     */
    public function getPartnerId()
    {

        return $this->partner_id;
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
     * Get the [partner_product_ref] column value.
     *
     * @return   string
     */
    public function getPartnerProdRef()
    {

        return $this->partner_product_ref;
    }

    /**
     * Get the [price] column value.
     *
     * @return   string
     */
    public function getPrice()
    {

        return $this->price;
    }

    /**
     * Get the [package_size] column value.
     *
     * @return   int
     */
    public function getPackageSize()
    {

        return $this->package_size;
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
     * Get the [discount] column value.
     *
     * @return   string
     */
    public function getDiscount()
    {

        return $this->discount;
    }

    /**
     * Get the [discount_description] column value.
     *
     * @return   string
     */
    public function getDiscountDescription()
    {

        return $this->discount_description;
    }

    /**
     * Get the [profile_website] column value.
     *
     * @return   string
     */
    public function getProfileWebsite()
    {

        return $this->profile_website;
    }

    /**
     * Get the [position] column value.
     *
     * @return   string
     */
    public function getPosition()
    {

        return $this->position;
    }

    /**
     * Get the [department] column value.
     *
     * @return   string
     */
    public function getDepartment()
    {

        return $this->department;
    }

    /**
     * Get the [comment] column value.
     *
     * @return   string
     */
    public function getComment()
    {

        return $this->comment;
    }

    /**
     * Get the [optionally formatted] temporal [valid_until] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw \DateTime object will be returned.
     *
     * @return mixed Formatted date/time value as string or \DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getValidUntil($format = NULL)
    {
        if ($format === null) {
            return $this->valid_until;
        } else {
            return $this->valid_until instanceof \DateTime ? $this->valid_until->format($format) : null;
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
     * @return   \RevenueDashboard\Model\WholesalePartnerProduct The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[WholesalePartnerProductTableMap::ID] = true;
        }


        return $this;
    } // setId()

    /**
     * Set the value of [partner_id] column.
     *
     * @param      int $v new value
     * @return   \RevenueDashboard\Model\WholesalePartnerProduct The current object (for fluent API support)
     */
    public function setPartnerId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->partner_id !== $v) {
            $this->partner_id = $v;
            $this->modifiedColumns[WholesalePartnerProductTableMap::PARTNER_ID] = true;
        }


        return $this;
    } // setPartnerId()

    /**
     * Set the value of [product_id] column.
     *
     * @param      int $v new value
     * @return   \RevenueDashboard\Model\WholesalePartnerProduct The current object (for fluent API support)
     */
    public function setProductId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->product_id !== $v) {
            $this->product_id = $v;
            $this->modifiedColumns[WholesalePartnerProductTableMap::PRODUCT_ID] = true;
        }

        if ($this->aProduct !== null && $this->aProduct->getId() !== $v) {
            $this->aProduct = null;
        }


        return $this;
    } // setProductId()

    /**
     * Set the value of [partner_product_ref] column.
     *
     * @param      string $v new value
     * @return   \RevenueDashboard\Model\WholesalePartnerProduct The current object (for fluent API support)
     */
    public function setPartnerProdRef($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->partner_product_ref !== $v) {
            $this->partner_product_ref = $v;
            $this->modifiedColumns[WholesalePartnerProductTableMap::PARTNER_PRODUCT_REF] = true;
        }


        return $this;
    } // setPartnerProdRef()

    /**
     * Set the value of [price] column.
     *
     * @param      string $v new value
     * @return   \RevenueDashboard\Model\WholesalePartnerProduct The current object (for fluent API support)
     */
    public function setPrice($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->price !== $v) {
            $this->price = $v;
            $this->modifiedColumns[WholesalePartnerProductTableMap::PRICE] = true;
        }


        return $this;
    } // setPrice()

    /**
     * Set the value of [package_size] column.
     *
     * @param      int $v new value
     * @return   \RevenueDashboard\Model\WholesalePartnerProduct The current object (for fluent API support)
     */
    public function setPackageSize($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->package_size !== $v) {
            $this->package_size = $v;
            $this->modifiedColumns[WholesalePartnerProductTableMap::PACKAGE_SIZE] = true;
        }


        return $this;
    } // setPackageSize()

    /**
     * Set the value of [delivery_cost] column.
     *
     * @param      string $v new value
     * @return   \RevenueDashboard\Model\WholesalePartnerProduct The current object (for fluent API support)
     */
    public function setDeliveryCost($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->delivery_cost !== $v) {
            $this->delivery_cost = $v;
            $this->modifiedColumns[WholesalePartnerProductTableMap::DELIVERY_COST] = true;
        }


        return $this;
    } // setDeliveryCost()

    /**
     * Set the value of [discount] column.
     *
     * @param      string $v new value
     * @return   \RevenueDashboard\Model\WholesalePartnerProduct The current object (for fluent API support)
     */
    public function setDiscount($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->discount !== $v) {
            $this->discount = $v;
            $this->modifiedColumns[WholesalePartnerProductTableMap::DISCOUNT] = true;
        }


        return $this;
    } // setDiscount()

    /**
     * Set the value of [discount_description] column.
     *
     * @param      string $v new value
     * @return   \RevenueDashboard\Model\WholesalePartnerProduct The current object (for fluent API support)
     */
    public function setDiscountDescription($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->discount_description !== $v) {
            $this->discount_description = $v;
            $this->modifiedColumns[WholesalePartnerProductTableMap::DISCOUNT_DESCRIPTION] = true;
        }


        return $this;
    } // setDiscountDescription()

    /**
     * Set the value of [profile_website] column.
     *
     * @param      string $v new value
     * @return   \RevenueDashboard\Model\WholesalePartnerProduct The current object (for fluent API support)
     */
    public function setProfileWebsite($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->profile_website !== $v) {
            $this->profile_website = $v;
            $this->modifiedColumns[WholesalePartnerProductTableMap::PROFILE_WEBSITE] = true;
        }


        return $this;
    } // setProfileWebsite()

    /**
     * Set the value of [position] column.
     *
     * @param      string $v new value
     * @return   \RevenueDashboard\Model\WholesalePartnerProduct The current object (for fluent API support)
     */
    public function setPosition($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->position !== $v) {
            $this->position = $v;
            $this->modifiedColumns[WholesalePartnerProductTableMap::POSITION] = true;
        }


        return $this;
    } // setPosition()

    /**
     * Set the value of [department] column.
     *
     * @param      string $v new value
     * @return   \RevenueDashboard\Model\WholesalePartnerProduct The current object (for fluent API support)
     */
    public function setDepartment($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->department !== $v) {
            $this->department = $v;
            $this->modifiedColumns[WholesalePartnerProductTableMap::DEPARTMENT] = true;
        }


        return $this;
    } // setDepartment()

    /**
     * Set the value of [comment] column.
     *
     * @param      string $v new value
     * @return   \RevenueDashboard\Model\WholesalePartnerProduct The current object (for fluent API support)
     */
    public function setComment($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->comment !== $v) {
            $this->comment = $v;
            $this->modifiedColumns[WholesalePartnerProductTableMap::COMMENT] = true;
        }


        return $this;
    } // setComment()

    /**
     * Sets the value of [valid_until] column to a normalized version of the date/time value specified.
     *
     * @param      mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return   \RevenueDashboard\Model\WholesalePartnerProduct The current object (for fluent API support)
     */
    public function setValidUntil($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->valid_until !== null || $dt !== null) {
            if ($dt !== $this->valid_until) {
                $this->valid_until = $dt;
                $this->modifiedColumns[WholesalePartnerProductTableMap::VALID_UNTIL] = true;
            }
        } // if either are not null


        return $this;
    } // setValidUntil()

    /**
     * Set the value of [version] column.
     *
     * @param      int $v new value
     * @return   \RevenueDashboard\Model\WholesalePartnerProduct The current object (for fluent API support)
     */
    public function setVersion($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->version !== $v) {
            $this->version = $v;
            $this->modifiedColumns[WholesalePartnerProductTableMap::VERSION] = true;
        }


        return $this;
    } // setVersion()

    /**
     * Set the value of [version_created_by] column.
     *
     * @param      string $v new value
     * @return   \RevenueDashboard\Model\WholesalePartnerProduct The current object (for fluent API support)
     */
    public function setVersionCreatedBy($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->version_created_by !== $v) {
            $this->version_created_by = $v;
            $this->modifiedColumns[WholesalePartnerProductTableMap::VERSION_CREATED_BY] = true;
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
            if ($this->price !== '0.00') {
                return false;
            }

            if ($this->delivery_cost !== '0.00') {
                return false;
            }

            if ($this->discount !== '0.00') {
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


            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : WholesalePartnerProductTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : WholesalePartnerProductTableMap::translateFieldName('PartnerId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->partner_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : WholesalePartnerProductTableMap::translateFieldName('ProductId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->product_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : WholesalePartnerProductTableMap::translateFieldName('PartnerProdRef', TableMap::TYPE_PHPNAME, $indexType)];
            $this->partner_product_ref = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : WholesalePartnerProductTableMap::translateFieldName('Price', TableMap::TYPE_PHPNAME, $indexType)];
            $this->price = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : WholesalePartnerProductTableMap::translateFieldName('PackageSize', TableMap::TYPE_PHPNAME, $indexType)];
            $this->package_size = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : WholesalePartnerProductTableMap::translateFieldName('DeliveryCost', TableMap::TYPE_PHPNAME, $indexType)];
            $this->delivery_cost = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : WholesalePartnerProductTableMap::translateFieldName('Discount', TableMap::TYPE_PHPNAME, $indexType)];
            $this->discount = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : WholesalePartnerProductTableMap::translateFieldName('DiscountDescription', TableMap::TYPE_PHPNAME, $indexType)];
            $this->discount_description = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : WholesalePartnerProductTableMap::translateFieldName('ProfileWebsite', TableMap::TYPE_PHPNAME, $indexType)];
            $this->profile_website = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 10 + $startcol : WholesalePartnerProductTableMap::translateFieldName('Position', TableMap::TYPE_PHPNAME, $indexType)];
            $this->position = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 11 + $startcol : WholesalePartnerProductTableMap::translateFieldName('Department', TableMap::TYPE_PHPNAME, $indexType)];
            $this->department = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 12 + $startcol : WholesalePartnerProductTableMap::translateFieldName('Comment', TableMap::TYPE_PHPNAME, $indexType)];
            $this->comment = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 13 + $startcol : WholesalePartnerProductTableMap::translateFieldName('ValidUntil', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->valid_until = (null !== $col) ? PropelDateTime::newInstance($col, null, '\DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 14 + $startcol : WholesalePartnerProductTableMap::translateFieldName('Version', TableMap::TYPE_PHPNAME, $indexType)];
            $this->version = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 15 + $startcol : WholesalePartnerProductTableMap::translateFieldName('VersionCreatedBy', TableMap::TYPE_PHPNAME, $indexType)];
            $this->version_created_by = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 16; // 16 = WholesalePartnerProductTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating \RevenueDashboard\Model\WholesalePartnerProduct object", 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(WholesalePartnerProductTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildWholesalePartnerProductQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aProduct = null;
            $this->collWholesalePartnerProductVersions = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see WholesalePartnerProduct::setDeleted()
     * @see WholesalePartnerProduct::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(WholesalePartnerProductTableMap::DATABASE_NAME);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = ChildWholesalePartnerProductQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(WholesalePartnerProductTableMap::DATABASE_NAME);
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
                // versionable behavior
                if (isset($createVersion)) {
                    $this->addVersion($con);
                }
                WholesalePartnerProductTableMap::addInstanceToPool($this);
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

            if ($this->wholesalePartnerProductVersionsScheduledForDeletion !== null) {
                if (!$this->wholesalePartnerProductVersionsScheduledForDeletion->isEmpty()) {
                    \RevenueDashboard\Model\WholesalePartnerProductVersionQuery::create()
                        ->filterByPrimaryKeys($this->wholesalePartnerProductVersionsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->wholesalePartnerProductVersionsScheduledForDeletion = null;
                }
            }

                if ($this->collWholesalePartnerProductVersions !== null) {
            foreach ($this->collWholesalePartnerProductVersions as $referrerFK) {
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

        $this->modifiedColumns[WholesalePartnerProductTableMap::ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . WholesalePartnerProductTableMap::ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(WholesalePartnerProductTableMap::ID)) {
            $modifiedColumns[':p' . $index++]  = 'ID';
        }
        if ($this->isColumnModified(WholesalePartnerProductTableMap::PARTNER_ID)) {
            $modifiedColumns[':p' . $index++]  = 'PARTNER_ID';
        }
        if ($this->isColumnModified(WholesalePartnerProductTableMap::PRODUCT_ID)) {
            $modifiedColumns[':p' . $index++]  = 'PRODUCT_ID';
        }
        if ($this->isColumnModified(WholesalePartnerProductTableMap::PARTNER_PRODUCT_REF)) {
            $modifiedColumns[':p' . $index++]  = 'PARTNER_PRODUCT_REF';
        }
        if ($this->isColumnModified(WholesalePartnerProductTableMap::PRICE)) {
            $modifiedColumns[':p' . $index++]  = 'PRICE';
        }
        if ($this->isColumnModified(WholesalePartnerProductTableMap::PACKAGE_SIZE)) {
            $modifiedColumns[':p' . $index++]  = 'PACKAGE_SIZE';
        }
        if ($this->isColumnModified(WholesalePartnerProductTableMap::DELIVERY_COST)) {
            $modifiedColumns[':p' . $index++]  = 'DELIVERY_COST';
        }
        if ($this->isColumnModified(WholesalePartnerProductTableMap::DISCOUNT)) {
            $modifiedColumns[':p' . $index++]  = 'DISCOUNT';
        }
        if ($this->isColumnModified(WholesalePartnerProductTableMap::DISCOUNT_DESCRIPTION)) {
            $modifiedColumns[':p' . $index++]  = 'DISCOUNT_DESCRIPTION';
        }
        if ($this->isColumnModified(WholesalePartnerProductTableMap::PROFILE_WEBSITE)) {
            $modifiedColumns[':p' . $index++]  = 'PROFILE_WEBSITE';
        }
        if ($this->isColumnModified(WholesalePartnerProductTableMap::POSITION)) {
            $modifiedColumns[':p' . $index++]  = 'POSITION';
        }
        if ($this->isColumnModified(WholesalePartnerProductTableMap::DEPARTMENT)) {
            $modifiedColumns[':p' . $index++]  = 'DEPARTMENT';
        }
        if ($this->isColumnModified(WholesalePartnerProductTableMap::COMMENT)) {
            $modifiedColumns[':p' . $index++]  = 'COMMENT';
        }
        if ($this->isColumnModified(WholesalePartnerProductTableMap::VALID_UNTIL)) {
            $modifiedColumns[':p' . $index++]  = 'VALID_UNTIL';
        }
        if ($this->isColumnModified(WholesalePartnerProductTableMap::VERSION)) {
            $modifiedColumns[':p' . $index++]  = 'VERSION';
        }
        if ($this->isColumnModified(WholesalePartnerProductTableMap::VERSION_CREATED_BY)) {
            $modifiedColumns[':p' . $index++]  = 'VERSION_CREATED_BY';
        }

        $sql = sprintf(
            'INSERT INTO wholesale_partner_product (%s) VALUES (%s)',
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
                    case 'PARTNER_ID':
                        $stmt->bindValue($identifier, $this->partner_id, PDO::PARAM_INT);
                        break;
                    case 'PRODUCT_ID':
                        $stmt->bindValue($identifier, $this->product_id, PDO::PARAM_INT);
                        break;
                    case 'PARTNER_PRODUCT_REF':
                        $stmt->bindValue($identifier, $this->partner_product_ref, PDO::PARAM_STR);
                        break;
                    case 'PRICE':
                        $stmt->bindValue($identifier, $this->price, PDO::PARAM_STR);
                        break;
                    case 'PACKAGE_SIZE':
                        $stmt->bindValue($identifier, $this->package_size, PDO::PARAM_INT);
                        break;
                    case 'DELIVERY_COST':
                        $stmt->bindValue($identifier, $this->delivery_cost, PDO::PARAM_STR);
                        break;
                    case 'DISCOUNT':
                        $stmt->bindValue($identifier, $this->discount, PDO::PARAM_STR);
                        break;
                    case 'DISCOUNT_DESCRIPTION':
                        $stmt->bindValue($identifier, $this->discount_description, PDO::PARAM_STR);
                        break;
                    case 'PROFILE_WEBSITE':
                        $stmt->bindValue($identifier, $this->profile_website, PDO::PARAM_STR);
                        break;
                    case 'POSITION':
                        $stmt->bindValue($identifier, $this->position, PDO::PARAM_STR);
                        break;
                    case 'DEPARTMENT':
                        $stmt->bindValue($identifier, $this->department, PDO::PARAM_STR);
                        break;
                    case 'COMMENT':
                        $stmt->bindValue($identifier, $this->comment, PDO::PARAM_STR);
                        break;
                    case 'VALID_UNTIL':
                        $stmt->bindValue($identifier, $this->valid_until ? $this->valid_until->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
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
        $pos = WholesalePartnerProductTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getPartnerId();
                break;
            case 2:
                return $this->getProductId();
                break;
            case 3:
                return $this->getPartnerProdRef();
                break;
            case 4:
                return $this->getPrice();
                break;
            case 5:
                return $this->getPackageSize();
                break;
            case 6:
                return $this->getDeliveryCost();
                break;
            case 7:
                return $this->getDiscount();
                break;
            case 8:
                return $this->getDiscountDescription();
                break;
            case 9:
                return $this->getProfileWebsite();
                break;
            case 10:
                return $this->getPosition();
                break;
            case 11:
                return $this->getDepartment();
                break;
            case 12:
                return $this->getComment();
                break;
            case 13:
                return $this->getValidUntil();
                break;
            case 14:
                return $this->getVersion();
                break;
            case 15:
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
        if (isset($alreadyDumpedObjects['WholesalePartnerProduct'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['WholesalePartnerProduct'][$this->getPrimaryKey()] = true;
        $keys = WholesalePartnerProductTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getPartnerId(),
            $keys[2] => $this->getProductId(),
            $keys[3] => $this->getPartnerProdRef(),
            $keys[4] => $this->getPrice(),
            $keys[5] => $this->getPackageSize(),
            $keys[6] => $this->getDeliveryCost(),
            $keys[7] => $this->getDiscount(),
            $keys[8] => $this->getDiscountDescription(),
            $keys[9] => $this->getProfileWebsite(),
            $keys[10] => $this->getPosition(),
            $keys[11] => $this->getDepartment(),
            $keys[12] => $this->getComment(),
            $keys[13] => $this->getValidUntil(),
            $keys[14] => $this->getVersion(),
            $keys[15] => $this->getVersionCreatedBy(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aProduct) {
                $result['Product'] = $this->aProduct->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collWholesalePartnerProductVersions) {
                $result['WholesalePartnerProductVersions'] = $this->collWholesalePartnerProductVersions->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
        $pos = WholesalePartnerProductTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

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
                $this->setPartnerId($value);
                break;
            case 2:
                $this->setProductId($value);
                break;
            case 3:
                $this->setPartnerProdRef($value);
                break;
            case 4:
                $this->setPrice($value);
                break;
            case 5:
                $this->setPackageSize($value);
                break;
            case 6:
                $this->setDeliveryCost($value);
                break;
            case 7:
                $this->setDiscount($value);
                break;
            case 8:
                $this->setDiscountDescription($value);
                break;
            case 9:
                $this->setProfileWebsite($value);
                break;
            case 10:
                $this->setPosition($value);
                break;
            case 11:
                $this->setDepartment($value);
                break;
            case 12:
                $this->setComment($value);
                break;
            case 13:
                $this->setValidUntil($value);
                break;
            case 14:
                $this->setVersion($value);
                break;
            case 15:
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
        $keys = WholesalePartnerProductTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setPartnerId($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setProductId($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setPartnerProdRef($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setPrice($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setPackageSize($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setDeliveryCost($arr[$keys[6]]);
        if (array_key_exists($keys[7], $arr)) $this->setDiscount($arr[$keys[7]]);
        if (array_key_exists($keys[8], $arr)) $this->setDiscountDescription($arr[$keys[8]]);
        if (array_key_exists($keys[9], $arr)) $this->setProfileWebsite($arr[$keys[9]]);
        if (array_key_exists($keys[10], $arr)) $this->setPosition($arr[$keys[10]]);
        if (array_key_exists($keys[11], $arr)) $this->setDepartment($arr[$keys[11]]);
        if (array_key_exists($keys[12], $arr)) $this->setComment($arr[$keys[12]]);
        if (array_key_exists($keys[13], $arr)) $this->setValidUntil($arr[$keys[13]]);
        if (array_key_exists($keys[14], $arr)) $this->setVersion($arr[$keys[14]]);
        if (array_key_exists($keys[15], $arr)) $this->setVersionCreatedBy($arr[$keys[15]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(WholesalePartnerProductTableMap::DATABASE_NAME);

        if ($this->isColumnModified(WholesalePartnerProductTableMap::ID)) $criteria->add(WholesalePartnerProductTableMap::ID, $this->id);
        if ($this->isColumnModified(WholesalePartnerProductTableMap::PARTNER_ID)) $criteria->add(WholesalePartnerProductTableMap::PARTNER_ID, $this->partner_id);
        if ($this->isColumnModified(WholesalePartnerProductTableMap::PRODUCT_ID)) $criteria->add(WholesalePartnerProductTableMap::PRODUCT_ID, $this->product_id);
        if ($this->isColumnModified(WholesalePartnerProductTableMap::PARTNER_PRODUCT_REF)) $criteria->add(WholesalePartnerProductTableMap::PARTNER_PRODUCT_REF, $this->partner_product_ref);
        if ($this->isColumnModified(WholesalePartnerProductTableMap::PRICE)) $criteria->add(WholesalePartnerProductTableMap::PRICE, $this->price);
        if ($this->isColumnModified(WholesalePartnerProductTableMap::PACKAGE_SIZE)) $criteria->add(WholesalePartnerProductTableMap::PACKAGE_SIZE, $this->package_size);
        if ($this->isColumnModified(WholesalePartnerProductTableMap::DELIVERY_COST)) $criteria->add(WholesalePartnerProductTableMap::DELIVERY_COST, $this->delivery_cost);
        if ($this->isColumnModified(WholesalePartnerProductTableMap::DISCOUNT)) $criteria->add(WholesalePartnerProductTableMap::DISCOUNT, $this->discount);
        if ($this->isColumnModified(WholesalePartnerProductTableMap::DISCOUNT_DESCRIPTION)) $criteria->add(WholesalePartnerProductTableMap::DISCOUNT_DESCRIPTION, $this->discount_description);
        if ($this->isColumnModified(WholesalePartnerProductTableMap::PROFILE_WEBSITE)) $criteria->add(WholesalePartnerProductTableMap::PROFILE_WEBSITE, $this->profile_website);
        if ($this->isColumnModified(WholesalePartnerProductTableMap::POSITION)) $criteria->add(WholesalePartnerProductTableMap::POSITION, $this->position);
        if ($this->isColumnModified(WholesalePartnerProductTableMap::DEPARTMENT)) $criteria->add(WholesalePartnerProductTableMap::DEPARTMENT, $this->department);
        if ($this->isColumnModified(WholesalePartnerProductTableMap::COMMENT)) $criteria->add(WholesalePartnerProductTableMap::COMMENT, $this->comment);
        if ($this->isColumnModified(WholesalePartnerProductTableMap::VALID_UNTIL)) $criteria->add(WholesalePartnerProductTableMap::VALID_UNTIL, $this->valid_until);
        if ($this->isColumnModified(WholesalePartnerProductTableMap::VERSION)) $criteria->add(WholesalePartnerProductTableMap::VERSION, $this->version);
        if ($this->isColumnModified(WholesalePartnerProductTableMap::VERSION_CREATED_BY)) $criteria->add(WholesalePartnerProductTableMap::VERSION_CREATED_BY, $this->version_created_by);

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
        $criteria = new Criteria(WholesalePartnerProductTableMap::DATABASE_NAME);
        $criteria->add(WholesalePartnerProductTableMap::ID, $this->id);

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
     * @param      object $copyObj An object of \RevenueDashboard\Model\WholesalePartnerProduct (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setPartnerId($this->getPartnerId());
        $copyObj->setProductId($this->getProductId());
        $copyObj->setPartnerProdRef($this->getPartnerProdRef());
        $copyObj->setPrice($this->getPrice());
        $copyObj->setPackageSize($this->getPackageSize());
        $copyObj->setDeliveryCost($this->getDeliveryCost());
        $copyObj->setDiscount($this->getDiscount());
        $copyObj->setDiscountDescription($this->getDiscountDescription());
        $copyObj->setProfileWebsite($this->getProfileWebsite());
        $copyObj->setPosition($this->getPosition());
        $copyObj->setDepartment($this->getDepartment());
        $copyObj->setComment($this->getComment());
        $copyObj->setValidUntil($this->getValidUntil());
        $copyObj->setVersion($this->getVersion());
        $copyObj->setVersionCreatedBy($this->getVersionCreatedBy());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getWholesalePartnerProductVersions() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addWholesalePartnerProductVersion($relObj->copy($deepCopy));
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
     * @return                 \RevenueDashboard\Model\WholesalePartnerProduct Clone of current object.
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
     * @return                 \RevenueDashboard\Model\WholesalePartnerProduct The current object (for fluent API support)
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
            $v->addWholesalePartnerProduct($this);
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
                $this->aProduct->addWholesalePartnerProducts($this);
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
        if ('WholesalePartnerProductVersion' == $relationName) {
            return $this->initWholesalePartnerProductVersions();
        }
    }

    /**
     * Clears out the collWholesalePartnerProductVersions collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addWholesalePartnerProductVersions()
     */
    public function clearWholesalePartnerProductVersions()
    {
        $this->collWholesalePartnerProductVersions = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collWholesalePartnerProductVersions collection loaded partially.
     */
    public function resetPartialWholesalePartnerProductVersions($v = true)
    {
        $this->collWholesalePartnerProductVersionsPartial = $v;
    }

    /**
     * Initializes the collWholesalePartnerProductVersions collection.
     *
     * By default this just sets the collWholesalePartnerProductVersions collection to an empty array (like clearcollWholesalePartnerProductVersions());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initWholesalePartnerProductVersions($overrideExisting = true)
    {
        if (null !== $this->collWholesalePartnerProductVersions && !$overrideExisting) {
            return;
        }
        $this->collWholesalePartnerProductVersions = new ObjectCollection();
        $this->collWholesalePartnerProductVersions->setModel('\RevenueDashboard\Model\WholesalePartnerProductVersion');
    }

    /**
     * Gets an array of ChildWholesalePartnerProductVersion objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildWholesalePartnerProduct is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return Collection|ChildWholesalePartnerProductVersion[] List of ChildWholesalePartnerProductVersion objects
     * @throws PropelException
     */
    public function getWholesalePartnerProductVersions($criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collWholesalePartnerProductVersionsPartial && !$this->isNew();
        if (null === $this->collWholesalePartnerProductVersions || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collWholesalePartnerProductVersions) {
                // return empty collection
                $this->initWholesalePartnerProductVersions();
            } else {
                $collWholesalePartnerProductVersions = ChildWholesalePartnerProductVersionQuery::create(null, $criteria)
                    ->filterByWholesalePartnerProduct($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collWholesalePartnerProductVersionsPartial && count($collWholesalePartnerProductVersions)) {
                        $this->initWholesalePartnerProductVersions(false);

                        foreach ($collWholesalePartnerProductVersions as $obj) {
                            if (false == $this->collWholesalePartnerProductVersions->contains($obj)) {
                                $this->collWholesalePartnerProductVersions->append($obj);
                            }
                        }

                        $this->collWholesalePartnerProductVersionsPartial = true;
                    }

                    reset($collWholesalePartnerProductVersions);

                    return $collWholesalePartnerProductVersions;
                }

                if ($partial && $this->collWholesalePartnerProductVersions) {
                    foreach ($this->collWholesalePartnerProductVersions as $obj) {
                        if ($obj->isNew()) {
                            $collWholesalePartnerProductVersions[] = $obj;
                        }
                    }
                }

                $this->collWholesalePartnerProductVersions = $collWholesalePartnerProductVersions;
                $this->collWholesalePartnerProductVersionsPartial = false;
            }
        }

        return $this->collWholesalePartnerProductVersions;
    }

    /**
     * Sets a collection of WholesalePartnerProductVersion objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $wholesalePartnerProductVersions A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return   ChildWholesalePartnerProduct The current object (for fluent API support)
     */
    public function setWholesalePartnerProductVersions(Collection $wholesalePartnerProductVersions, ConnectionInterface $con = null)
    {
        $wholesalePartnerProductVersionsToDelete = $this->getWholesalePartnerProductVersions(new Criteria(), $con)->diff($wholesalePartnerProductVersions);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->wholesalePartnerProductVersionsScheduledForDeletion = clone $wholesalePartnerProductVersionsToDelete;

        foreach ($wholesalePartnerProductVersionsToDelete as $wholesalePartnerProductVersionRemoved) {
            $wholesalePartnerProductVersionRemoved->setWholesalePartnerProduct(null);
        }

        $this->collWholesalePartnerProductVersions = null;
        foreach ($wholesalePartnerProductVersions as $wholesalePartnerProductVersion) {
            $this->addWholesalePartnerProductVersion($wholesalePartnerProductVersion);
        }

        $this->collWholesalePartnerProductVersions = $wholesalePartnerProductVersions;
        $this->collWholesalePartnerProductVersionsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related WholesalePartnerProductVersion objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related WholesalePartnerProductVersion objects.
     * @throws PropelException
     */
    public function countWholesalePartnerProductVersions(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collWholesalePartnerProductVersionsPartial && !$this->isNew();
        if (null === $this->collWholesalePartnerProductVersions || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collWholesalePartnerProductVersions) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getWholesalePartnerProductVersions());
            }

            $query = ChildWholesalePartnerProductVersionQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByWholesalePartnerProduct($this)
                ->count($con);
        }

        return count($this->collWholesalePartnerProductVersions);
    }

    /**
     * Method called to associate a ChildWholesalePartnerProductVersion object to this object
     * through the ChildWholesalePartnerProductVersion foreign key attribute.
     *
     * @param    ChildWholesalePartnerProductVersion $l ChildWholesalePartnerProductVersion
     * @return   \RevenueDashboard\Model\WholesalePartnerProduct The current object (for fluent API support)
     */
    public function addWholesalePartnerProductVersion(ChildWholesalePartnerProductVersion $l)
    {
        if ($this->collWholesalePartnerProductVersions === null) {
            $this->initWholesalePartnerProductVersions();
            $this->collWholesalePartnerProductVersionsPartial = true;
        }

        if (!in_array($l, $this->collWholesalePartnerProductVersions->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddWholesalePartnerProductVersion($l);
        }

        return $this;
    }

    /**
     * @param WholesalePartnerProductVersion $wholesalePartnerProductVersion The wholesalePartnerProductVersion object to add.
     */
    protected function doAddWholesalePartnerProductVersion($wholesalePartnerProductVersion)
    {
        $this->collWholesalePartnerProductVersions[]= $wholesalePartnerProductVersion;
        $wholesalePartnerProductVersion->setWholesalePartnerProduct($this);
    }

    /**
     * @param  WholesalePartnerProductVersion $wholesalePartnerProductVersion The wholesalePartnerProductVersion object to remove.
     * @return ChildWholesalePartnerProduct The current object (for fluent API support)
     */
    public function removeWholesalePartnerProductVersion($wholesalePartnerProductVersion)
    {
        if ($this->getWholesalePartnerProductVersions()->contains($wholesalePartnerProductVersion)) {
            $this->collWholesalePartnerProductVersions->remove($this->collWholesalePartnerProductVersions->search($wholesalePartnerProductVersion));
            if (null === $this->wholesalePartnerProductVersionsScheduledForDeletion) {
                $this->wholesalePartnerProductVersionsScheduledForDeletion = clone $this->collWholesalePartnerProductVersions;
                $this->wholesalePartnerProductVersionsScheduledForDeletion->clear();
            }
            $this->wholesalePartnerProductVersionsScheduledForDeletion[]= clone $wholesalePartnerProductVersion;
            $wholesalePartnerProductVersion->setWholesalePartnerProduct(null);
        }

        return $this;
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->id = null;
        $this->partner_id = null;
        $this->product_id = null;
        $this->partner_product_ref = null;
        $this->price = null;
        $this->package_size = null;
        $this->delivery_cost = null;
        $this->discount = null;
        $this->discount_description = null;
        $this->profile_website = null;
        $this->position = null;
        $this->department = null;
        $this->comment = null;
        $this->valid_until = null;
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
            if ($this->collWholesalePartnerProductVersions) {
                foreach ($this->collWholesalePartnerProductVersions as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collWholesalePartnerProductVersions = null;
        $this->aProduct = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(WholesalePartnerProductTableMap::DEFAULT_STRING_FORMAT);
    }

    // versionable behavior

    /**
     * Enforce a new Version of this object upon next save.
     *
     * @return \RevenueDashboard\Model\WholesalePartnerProduct
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

        if (ChildWholesalePartnerProductQuery::isVersioningEnabled() && ($this->isNew() || $this->isModified()) || $this->isDeleted()) {
            return true;
        }
        if (null !== ($object = $this->getProduct($con)) && $object->isVersioningNecessary($con)) {
            return true;
        }


        return false;
    }

    /**
     * Creates a version of the current object and saves it.
     *
     * @param   ConnectionInterface $con the connection to use
     *
     * @return  ChildWholesalePartnerProductVersion A version object
     */
    public function addVersion($con = null)
    {
        $this->enforceVersion = false;

        $version = new ChildWholesalePartnerProductVersion();
        $version->setId($this->getId());
        $version->setPartnerId($this->getPartnerId());
        $version->setProductId($this->getProductId());
        $version->setPartnerProdRef($this->getPartnerProdRef());
        $version->setPrice($this->getPrice());
        $version->setPackageSize($this->getPackageSize());
        $version->setDeliveryCost($this->getDeliveryCost());
        $version->setDiscount($this->getDiscount());
        $version->setDiscountDescription($this->getDiscountDescription());
        $version->setProfileWebsite($this->getProfileWebsite());
        $version->setPosition($this->getPosition());
        $version->setDepartment($this->getDepartment());
        $version->setComment($this->getComment());
        $version->setValidUntil($this->getValidUntil());
        $version->setVersion($this->getVersion());
        $version->setVersionCreatedBy($this->getVersionCreatedBy());
        $version->setWholesalePartnerProduct($this);
        if (($related = $this->getProduct($con)) && $related->getVersion()) {
            $version->setProductIdVersion($related->getVersion());
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
     * @return  ChildWholesalePartnerProduct The current object (for fluent API support)
     */
    public function toVersion($versionNumber, $con = null)
    {
        $version = $this->getOneVersion($versionNumber, $con);
        if (!$version) {
            throw new PropelException(sprintf('No ChildWholesalePartnerProduct object found with version %d', $version));
        }
        $this->populateFromVersion($version, $con);

        return $this;
    }

    /**
     * Sets the properties of the current object to the value they had at a specific version
     *
     * @param ChildWholesalePartnerProductVersion $version The version object to use
     * @param ConnectionInterface   $con the connection to use
     * @param array                 $loadedObjects objects that been loaded in a chain of populateFromVersion calls on referrer or fk objects.
     *
     * @return ChildWholesalePartnerProduct The current object (for fluent API support)
     */
    public function populateFromVersion($version, $con = null, &$loadedObjects = array())
    {
        $loadedObjects['ChildWholesalePartnerProduct'][$version->getId()][$version->getVersion()] = $this;
        $this->setId($version->getId());
        $this->setPartnerId($version->getPartnerId());
        $this->setProductId($version->getProductId());
        $this->setPartnerProdRef($version->getPartnerProdRef());
        $this->setPrice($version->getPrice());
        $this->setPackageSize($version->getPackageSize());
        $this->setDeliveryCost($version->getDeliveryCost());
        $this->setDiscount($version->getDiscount());
        $this->setDiscountDescription($version->getDiscountDescription());
        $this->setProfileWebsite($version->getProfileWebsite());
        $this->setPosition($version->getPosition());
        $this->setDepartment($version->getDepartment());
        $this->setComment($version->getComment());
        $this->setValidUntil($version->getValidUntil());
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
        $v = ChildWholesalePartnerProductVersionQuery::create()
            ->filterByWholesalePartnerProduct($this)
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
     * @return  ChildWholesalePartnerProductVersion A version object
     */
    public function getOneVersion($versionNumber, $con = null)
    {
        return ChildWholesalePartnerProductVersionQuery::create()
            ->filterByWholesalePartnerProduct($this)
            ->filterByVersion($versionNumber)
            ->findOne($con);
    }

    /**
     * Gets all the versions of this object, in incremental order
     *
     * @param   ConnectionInterface $con the connection to use
     *
     * @return  ObjectCollection A list of ChildWholesalePartnerProductVersion objects
     */
    public function getAllVersions($con = null)
    {
        $criteria = new Criteria();
        $criteria->addAscendingOrderByColumn(WholesalePartnerProductVersionTableMap::VERSION);

        return $this->getWholesalePartnerProductVersions($criteria, $con);
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
     * @return PropelCollection|array \RevenueDashboard\Model\WholesalePartnerProductVersion[] List of \RevenueDashboard\Model\WholesalePartnerProductVersion objects
     */
    public function getLastVersions($number = 10, $criteria = null, $con = null)
    {
        $criteria = ChildWholesalePartnerProductVersionQuery::create(null, $criteria);
        $criteria->addDescendingOrderByColumn(WholesalePartnerProductVersionTableMap::VERSION);
        $criteria->limit($number);

        return $this->getWholesalePartnerProductVersions($criteria, $con);
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
