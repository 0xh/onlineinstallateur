<?php

namespace HookAdminCrawlerDashboard\Model\Base;

use \DateTime;
use \Exception;
use \PDO;
use HookAdminCrawlerDashboard\Model\CrawlerProductListing as ChildCrawlerProductListing;
use HookAdminCrawlerDashboard\Model\CrawlerProductListingQuery as ChildCrawlerProductListingQuery;
use HookAdminCrawlerDashboard\Model\CrawlerProductListingVersionQuery as ChildCrawlerProductListingVersionQuery;
use HookAdminCrawlerDashboard\Model\Map\CrawlerProductListingVersionTableMap;
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
use Propel\Runtime\Util\PropelDateTime;

abstract class CrawlerProductListingVersion implements ActiveRecordInterface 
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\HookAdminCrawlerDashboard\\Model\\Map\\CrawlerProductListingVersionTableMap';


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
     * The value for the product_base_id field.
     * @var        int
     */
    protected $product_base_id;

    /**
     * The value for the hf_position field.
     * @var        int
     */
    protected $hf_position;

    /**
     * The value for the hf_price field.
     * Note: this column has a database default value of: '0.000000'
     * @var        string
     */
    protected $hf_price;

    /**
     * The value for the first_position field.
     * @var        int
     */
    protected $first_position;

    /**
     * The value for the first_price field.
     * Note: this column has a database default value of: '0.000000'
     * @var        string
     */
    protected $first_price;

    /**
     * The value for the platform field.
     * @var        string
     */
    protected $platform;

    /**
     * The value for the link_platform_product_page field.
     * @var        string
     */
    protected $link_platform_product_page;

    /**
     * The value for the link_hf_product field.
     * @var        string
     */
    protected $link_hf_product;

    /**
     * The value for the link_first_product field.
     * @var        string
     */
    protected $link_first_product;

    /**
     * The value for the platform_product_id field.
     * @var        string
     */
    protected $platform_product_id;

    /**
     * The value for the hf_product_stock field.
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $hf_product_stock;

    /**
     * The value for the hf_product_stock_order field.
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $hf_product_stock_order;

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
     * The value for the product_base_id_version field.
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $product_base_id_version;

    /**
     * @var        CrawlerProductListing
     */
    protected $aCrawlerProductListing;

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
        $this->hf_price = '0.000000';
        $this->first_price = '0.000000';
        $this->hf_product_stock = 0;
        $this->hf_product_stock_order = 0;
        $this->version = 0;
        $this->product_base_id_version = 0;
    }

    /**
     * Initializes internal state of HookAdminCrawlerDashboard\Model\Base\CrawlerProductListingVersion object.
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
     * Compares this with another <code>CrawlerProductListingVersion</code> instance.  If
     * <code>obj</code> is an instance of <code>CrawlerProductListingVersion</code>, delegates to
     * <code>equals(CrawlerProductListingVersion)</code>.  Otherwise, returns <code>false</code>.
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
     * @return CrawlerProductListingVersion The current object, for fluid interface
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
     * @return CrawlerProductListingVersion The current object, for fluid interface
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
     * Get the [product_base_id] column value.
     * 
     * @return   int
     */
    public function getProductBaseId()
    {

        return $this->product_base_id;
    }

    /**
     * Get the [hf_position] column value.
     * 
     * @return   int
     */
    public function getHfPosition()
    {

        return $this->hf_position;
    }

    /**
     * Get the [hf_price] column value.
     * 
     * @return   string
     */
    public function getHfPrice()
    {

        return $this->hf_price;
    }

    /**
     * Get the [first_position] column value.
     * 
     * @return   int
     */
    public function getFirstPosition()
    {

        return $this->first_position;
    }

    /**
     * Get the [first_price] column value.
     * 
     * @return   string
     */
    public function getFirstPrice()
    {

        return $this->first_price;
    }

    /**
     * Get the [platform] column value.
     * 
     * @return   string
     */
    public function getPlatform()
    {

        return $this->platform;
    }

    /**
     * Get the [link_platform_product_page] column value.
     * 
     * @return   string
     */
    public function getLinkPlatformProductPage()
    {

        return $this->link_platform_product_page;
    }

    /**
     * Get the [link_hf_product] column value.
     * 
     * @return   string
     */
    public function getLinkHfProduct()
    {

        return $this->link_hf_product;
    }

    /**
     * Get the [link_first_product] column value.
     * 
     * @return   string
     */
    public function getLinkFirstProduct()
    {

        return $this->link_first_product;
    }

    /**
     * Get the [platform_product_id] column value.
     * 
     * @return   string
     */
    public function getPlatformProductId()
    {

        return $this->platform_product_id;
    }

    /**
     * Get the [hf_product_stock] column value.
     * 
     * @return   int
     */
    public function getHfProductStock()
    {

        return $this->hf_product_stock;
    }

    /**
     * Get the [hf_product_stock_order] column value.
     * 
     * @return   int
     */
    public function getHfProductStockOrder()
    {

        return $this->hf_product_stock_order;
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
     * Get the [product_base_id_version] column value.
     * 
     * @return   int
     */
    public function getProductBaseIdVersion()
    {

        return $this->product_base_id_version;
    }

    /**
     * Set the value of [id] column.
     * 
     * @param      int $v new value
     * @return   \HookAdminCrawlerDashboard\Model\CrawlerProductListingVersion The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[CrawlerProductListingVersionTableMap::ID] = true;
        }

        if ($this->aCrawlerProductListing !== null && $this->aCrawlerProductListing->getId() !== $v) {
            $this->aCrawlerProductListing = null;
        }


        return $this;
    } // setId()

    /**
     * Set the value of [product_base_id] column.
     * 
     * @param      int $v new value
     * @return   \HookAdminCrawlerDashboard\Model\CrawlerProductListingVersion The current object (for fluent API support)
     */
    public function setProductBaseId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->product_base_id !== $v) {
            $this->product_base_id = $v;
            $this->modifiedColumns[CrawlerProductListingVersionTableMap::PRODUCT_BASE_ID] = true;
        }


        return $this;
    } // setProductBaseId()

    /**
     * Set the value of [hf_position] column.
     * 
     * @param      int $v new value
     * @return   \HookAdminCrawlerDashboard\Model\CrawlerProductListingVersion The current object (for fluent API support)
     */
    public function setHfPosition($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->hf_position !== $v) {
            $this->hf_position = $v;
            $this->modifiedColumns[CrawlerProductListingVersionTableMap::HF_POSITION] = true;
        }


        return $this;
    } // setHfPosition()

    /**
     * Set the value of [hf_price] column.
     * 
     * @param      string $v new value
     * @return   \HookAdminCrawlerDashboard\Model\CrawlerProductListingVersion The current object (for fluent API support)
     */
    public function setHfPrice($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->hf_price !== $v) {
            $this->hf_price = $v;
            $this->modifiedColumns[CrawlerProductListingVersionTableMap::HF_PRICE] = true;
        }


        return $this;
    } // setHfPrice()

    /**
     * Set the value of [first_position] column.
     * 
     * @param      int $v new value
     * @return   \HookAdminCrawlerDashboard\Model\CrawlerProductListingVersion The current object (for fluent API support)
     */
    public function setFirstPosition($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->first_position !== $v) {
            $this->first_position = $v;
            $this->modifiedColumns[CrawlerProductListingVersionTableMap::FIRST_POSITION] = true;
        }


        return $this;
    } // setFirstPosition()

    /**
     * Set the value of [first_price] column.
     * 
     * @param      string $v new value
     * @return   \HookAdminCrawlerDashboard\Model\CrawlerProductListingVersion The current object (for fluent API support)
     */
    public function setFirstPrice($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->first_price !== $v) {
            $this->first_price = $v;
            $this->modifiedColumns[CrawlerProductListingVersionTableMap::FIRST_PRICE] = true;
        }


        return $this;
    } // setFirstPrice()

    /**
     * Set the value of [platform] column.
     * 
     * @param      string $v new value
     * @return   \HookAdminCrawlerDashboard\Model\CrawlerProductListingVersion The current object (for fluent API support)
     */
    public function setPlatform($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->platform !== $v) {
            $this->platform = $v;
            $this->modifiedColumns[CrawlerProductListingVersionTableMap::PLATFORM] = true;
        }


        return $this;
    } // setPlatform()

    /**
     * Set the value of [link_platform_product_page] column.
     * 
     * @param      string $v new value
     * @return   \HookAdminCrawlerDashboard\Model\CrawlerProductListingVersion The current object (for fluent API support)
     */
    public function setLinkPlatformProductPage($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->link_platform_product_page !== $v) {
            $this->link_platform_product_page = $v;
            $this->modifiedColumns[CrawlerProductListingVersionTableMap::LINK_PLATFORM_PRODUCT_PAGE] = true;
        }


        return $this;
    } // setLinkPlatformProductPage()

    /**
     * Set the value of [link_hf_product] column.
     * 
     * @param      string $v new value
     * @return   \HookAdminCrawlerDashboard\Model\CrawlerProductListingVersion The current object (for fluent API support)
     */
    public function setLinkHfProduct($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->link_hf_product !== $v) {
            $this->link_hf_product = $v;
            $this->modifiedColumns[CrawlerProductListingVersionTableMap::LINK_HF_PRODUCT] = true;
        }


        return $this;
    } // setLinkHfProduct()

    /**
     * Set the value of [link_first_product] column.
     * 
     * @param      string $v new value
     * @return   \HookAdminCrawlerDashboard\Model\CrawlerProductListingVersion The current object (for fluent API support)
     */
    public function setLinkFirstProduct($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->link_first_product !== $v) {
            $this->link_first_product = $v;
            $this->modifiedColumns[CrawlerProductListingVersionTableMap::LINK_FIRST_PRODUCT] = true;
        }


        return $this;
    } // setLinkFirstProduct()

    /**
     * Set the value of [platform_product_id] column.
     * 
     * @param      string $v new value
     * @return   \HookAdminCrawlerDashboard\Model\CrawlerProductListingVersion The current object (for fluent API support)
     */
    public function setPlatformProductId($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->platform_product_id !== $v) {
            $this->platform_product_id = $v;
            $this->modifiedColumns[CrawlerProductListingVersionTableMap::PLATFORM_PRODUCT_ID] = true;
        }


        return $this;
    } // setPlatformProductId()

    /**
     * Set the value of [hf_product_stock] column.
     * 
     * @param      int $v new value
     * @return   \HookAdminCrawlerDashboard\Model\CrawlerProductListingVersion The current object (for fluent API support)
     */
    public function setHfProductStock($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->hf_product_stock !== $v) {
            $this->hf_product_stock = $v;
            $this->modifiedColumns[CrawlerProductListingVersionTableMap::HF_PRODUCT_STOCK] = true;
        }


        return $this;
    } // setHfProductStock()

    /**
     * Set the value of [hf_product_stock_order] column.
     * 
     * @param      int $v new value
     * @return   \HookAdminCrawlerDashboard\Model\CrawlerProductListingVersion The current object (for fluent API support)
     */
    public function setHfProductStockOrder($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->hf_product_stock_order !== $v) {
            $this->hf_product_stock_order = $v;
            $this->modifiedColumns[CrawlerProductListingVersionTableMap::HF_PRODUCT_STOCK_ORDER] = true;
        }


        return $this;
    } // setHfProductStockOrder()

    /**
     * Sets the value of [created_at] column to a normalized version of the date/time value specified.
     * 
     * @param      mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return   \HookAdminCrawlerDashboard\Model\CrawlerProductListingVersion The current object (for fluent API support)
     */
    public function setCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->created_at !== null || $dt !== null) {
            if ($dt !== $this->created_at) {
                $this->created_at = $dt;
                $this->modifiedColumns[CrawlerProductListingVersionTableMap::CREATED_AT] = true;
            }
        } // if either are not null


        return $this;
    } // setCreatedAt()

    /**
     * Sets the value of [updated_at] column to a normalized version of the date/time value specified.
     * 
     * @param      mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return   \HookAdminCrawlerDashboard\Model\CrawlerProductListingVersion The current object (for fluent API support)
     */
    public function setUpdatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->updated_at !== null || $dt !== null) {
            if ($dt !== $this->updated_at) {
                $this->updated_at = $dt;
                $this->modifiedColumns[CrawlerProductListingVersionTableMap::UPDATED_AT] = true;
            }
        } // if either are not null


        return $this;
    } // setUpdatedAt()

    /**
     * Set the value of [version] column.
     * 
     * @param      int $v new value
     * @return   \HookAdminCrawlerDashboard\Model\CrawlerProductListingVersion The current object (for fluent API support)
     */
    public function setVersion($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->version !== $v) {
            $this->version = $v;
            $this->modifiedColumns[CrawlerProductListingVersionTableMap::VERSION] = true;
        }


        return $this;
    } // setVersion()

    /**
     * Sets the value of [version_created_at] column to a normalized version of the date/time value specified.
     * 
     * @param      mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return   \HookAdminCrawlerDashboard\Model\CrawlerProductListingVersion The current object (for fluent API support)
     */
    public function setVersionCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->version_created_at !== null || $dt !== null) {
            if ($dt !== $this->version_created_at) {
                $this->version_created_at = $dt;
                $this->modifiedColumns[CrawlerProductListingVersionTableMap::VERSION_CREATED_AT] = true;
            }
        } // if either are not null


        return $this;
    } // setVersionCreatedAt()

    /**
     * Set the value of [version_created_by] column.
     * 
     * @param      string $v new value
     * @return   \HookAdminCrawlerDashboard\Model\CrawlerProductListingVersion The current object (for fluent API support)
     */
    public function setVersionCreatedBy($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->version_created_by !== $v) {
            $this->version_created_by = $v;
            $this->modifiedColumns[CrawlerProductListingVersionTableMap::VERSION_CREATED_BY] = true;
        }


        return $this;
    } // setVersionCreatedBy()

    /**
     * Set the value of [product_base_id_version] column.
     * 
     * @param      int $v new value
     * @return   \HookAdminCrawlerDashboard\Model\CrawlerProductListingVersion The current object (for fluent API support)
     */
    public function setProductBaseIdVersion($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->product_base_id_version !== $v) {
            $this->product_base_id_version = $v;
            $this->modifiedColumns[CrawlerProductListingVersionTableMap::PRODUCT_BASE_ID_VERSION] = true;
        }


        return $this;
    } // setProductBaseIdVersion()

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
            if ($this->hf_price !== '0.000000') {
                return false;
            }

            if ($this->first_price !== '0.000000') {
                return false;
            }

            if ($this->hf_product_stock !== 0) {
                return false;
            }

            if ($this->hf_product_stock_order !== 0) {
                return false;
            }

            if ($this->version !== 0) {
                return false;
            }

            if ($this->product_base_id_version !== 0) {
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


            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : CrawlerProductListingVersionTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : CrawlerProductListingVersionTableMap::translateFieldName('ProductBaseId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->product_base_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : CrawlerProductListingVersionTableMap::translateFieldName('HfPosition', TableMap::TYPE_PHPNAME, $indexType)];
            $this->hf_position = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : CrawlerProductListingVersionTableMap::translateFieldName('HfPrice', TableMap::TYPE_PHPNAME, $indexType)];
            $this->hf_price = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : CrawlerProductListingVersionTableMap::translateFieldName('FirstPosition', TableMap::TYPE_PHPNAME, $indexType)];
            $this->first_position = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : CrawlerProductListingVersionTableMap::translateFieldName('FirstPrice', TableMap::TYPE_PHPNAME, $indexType)];
            $this->first_price = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : CrawlerProductListingVersionTableMap::translateFieldName('Platform', TableMap::TYPE_PHPNAME, $indexType)];
            $this->platform = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : CrawlerProductListingVersionTableMap::translateFieldName('LinkPlatformProductPage', TableMap::TYPE_PHPNAME, $indexType)];
            $this->link_platform_product_page = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : CrawlerProductListingVersionTableMap::translateFieldName('LinkHfProduct', TableMap::TYPE_PHPNAME, $indexType)];
            $this->link_hf_product = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : CrawlerProductListingVersionTableMap::translateFieldName('LinkFirstProduct', TableMap::TYPE_PHPNAME, $indexType)];
            $this->link_first_product = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 10 + $startcol : CrawlerProductListingVersionTableMap::translateFieldName('PlatformProductId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->platform_product_id = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 11 + $startcol : CrawlerProductListingVersionTableMap::translateFieldName('HfProductStock', TableMap::TYPE_PHPNAME, $indexType)];
            $this->hf_product_stock = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 12 + $startcol : CrawlerProductListingVersionTableMap::translateFieldName('HfProductStockOrder', TableMap::TYPE_PHPNAME, $indexType)];
            $this->hf_product_stock_order = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 13 + $startcol : CrawlerProductListingVersionTableMap::translateFieldName('CreatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->created_at = (null !== $col) ? PropelDateTime::newInstance($col, null, '\DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 14 + $startcol : CrawlerProductListingVersionTableMap::translateFieldName('UpdatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->updated_at = (null !== $col) ? PropelDateTime::newInstance($col, null, '\DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 15 + $startcol : CrawlerProductListingVersionTableMap::translateFieldName('Version', TableMap::TYPE_PHPNAME, $indexType)];
            $this->version = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 16 + $startcol : CrawlerProductListingVersionTableMap::translateFieldName('VersionCreatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->version_created_at = (null !== $col) ? PropelDateTime::newInstance($col, null, '\DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 17 + $startcol : CrawlerProductListingVersionTableMap::translateFieldName('VersionCreatedBy', TableMap::TYPE_PHPNAME, $indexType)];
            $this->version_created_by = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 18 + $startcol : CrawlerProductListingVersionTableMap::translateFieldName('ProductBaseIdVersion', TableMap::TYPE_PHPNAME, $indexType)];
            $this->product_base_id_version = (null !== $col) ? (int) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 19; // 19 = CrawlerProductListingVersionTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating \HookAdminCrawlerDashboard\Model\CrawlerProductListingVersion object", 0, $e);
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
        if ($this->aCrawlerProductListing !== null && $this->id !== $this->aCrawlerProductListing->getId()) {
            $this->aCrawlerProductListing = null;
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
            $con = Propel::getServiceContainer()->getReadConnection(CrawlerProductListingVersionTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildCrawlerProductListingVersionQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aCrawlerProductListing = null;
        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see CrawlerProductListingVersion::setDeleted()
     * @see CrawlerProductListingVersion::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(CrawlerProductListingVersionTableMap::DATABASE_NAME);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = ChildCrawlerProductListingVersionQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(CrawlerProductListingVersionTableMap::DATABASE_NAME);
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
                CrawlerProductListingVersionTableMap::addInstanceToPool($this);
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

            if ($this->aCrawlerProductListing !== null) {
                if ($this->aCrawlerProductListing->isModified() || $this->aCrawlerProductListing->isNew()) {
                    $affectedRows += $this->aCrawlerProductListing->save($con);
                }
                $this->setCrawlerProductListing($this->aCrawlerProductListing);
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


         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(CrawlerProductListingVersionTableMap::ID)) {
            $modifiedColumns[':p' . $index++]  = 'ID';
        }
        if ($this->isColumnModified(CrawlerProductListingVersionTableMap::PRODUCT_BASE_ID)) {
            $modifiedColumns[':p' . $index++]  = 'PRODUCT_BASE_ID';
        }
        if ($this->isColumnModified(CrawlerProductListingVersionTableMap::HF_POSITION)) {
            $modifiedColumns[':p' . $index++]  = 'HF_POSITION';
        }
        if ($this->isColumnModified(CrawlerProductListingVersionTableMap::HF_PRICE)) {
            $modifiedColumns[':p' . $index++]  = 'HF_PRICE';
        }
        if ($this->isColumnModified(CrawlerProductListingVersionTableMap::FIRST_POSITION)) {
            $modifiedColumns[':p' . $index++]  = 'FIRST_POSITION';
        }
        if ($this->isColumnModified(CrawlerProductListingVersionTableMap::FIRST_PRICE)) {
            $modifiedColumns[':p' . $index++]  = 'FIRST_PRICE';
        }
        if ($this->isColumnModified(CrawlerProductListingVersionTableMap::PLATFORM)) {
            $modifiedColumns[':p' . $index++]  = 'PLATFORM';
        }
        if ($this->isColumnModified(CrawlerProductListingVersionTableMap::LINK_PLATFORM_PRODUCT_PAGE)) {
            $modifiedColumns[':p' . $index++]  = 'LINK_PLATFORM_PRODUCT_PAGE';
        }
        if ($this->isColumnModified(CrawlerProductListingVersionTableMap::LINK_HF_PRODUCT)) {
            $modifiedColumns[':p' . $index++]  = 'LINK_HF_PRODUCT';
        }
        if ($this->isColumnModified(CrawlerProductListingVersionTableMap::LINK_FIRST_PRODUCT)) {
            $modifiedColumns[':p' . $index++]  = 'LINK_FIRST_PRODUCT';
        }
        if ($this->isColumnModified(CrawlerProductListingVersionTableMap::PLATFORM_PRODUCT_ID)) {
            $modifiedColumns[':p' . $index++]  = 'PLATFORM_PRODUCT_ID';
        }
        if ($this->isColumnModified(CrawlerProductListingVersionTableMap::HF_PRODUCT_STOCK)) {
            $modifiedColumns[':p' . $index++]  = 'HF_PRODUCT_STOCK';
        }
        if ($this->isColumnModified(CrawlerProductListingVersionTableMap::HF_PRODUCT_STOCK_ORDER)) {
            $modifiedColumns[':p' . $index++]  = 'HF_PRODUCT_STOCK_ORDER';
        }
        if ($this->isColumnModified(CrawlerProductListingVersionTableMap::CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'CREATED_AT';
        }
        if ($this->isColumnModified(CrawlerProductListingVersionTableMap::UPDATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'UPDATED_AT';
        }
        if ($this->isColumnModified(CrawlerProductListingVersionTableMap::VERSION)) {
            $modifiedColumns[':p' . $index++]  = 'VERSION';
        }
        if ($this->isColumnModified(CrawlerProductListingVersionTableMap::VERSION_CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'VERSION_CREATED_AT';
        }
        if ($this->isColumnModified(CrawlerProductListingVersionTableMap::VERSION_CREATED_BY)) {
            $modifiedColumns[':p' . $index++]  = 'VERSION_CREATED_BY';
        }
        if ($this->isColumnModified(CrawlerProductListingVersionTableMap::PRODUCT_BASE_ID_VERSION)) {
            $modifiedColumns[':p' . $index++]  = 'PRODUCT_BASE_ID_VERSION';
        }

        $sql = sprintf(
            'INSERT INTO crawler_product_listing_version (%s) VALUES (%s)',
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
                    case 'PRODUCT_BASE_ID':                        
                        $stmt->bindValue($identifier, $this->product_base_id, PDO::PARAM_INT);
                        break;
                    case 'HF_POSITION':                        
                        $stmt->bindValue($identifier, $this->hf_position, PDO::PARAM_INT);
                        break;
                    case 'HF_PRICE':                        
                        $stmt->bindValue($identifier, $this->hf_price, PDO::PARAM_STR);
                        break;
                    case 'FIRST_POSITION':                        
                        $stmt->bindValue($identifier, $this->first_position, PDO::PARAM_INT);
                        break;
                    case 'FIRST_PRICE':                        
                        $stmt->bindValue($identifier, $this->first_price, PDO::PARAM_STR);
                        break;
                    case 'PLATFORM':                        
                        $stmt->bindValue($identifier, $this->platform, PDO::PARAM_STR);
                        break;
                    case 'LINK_PLATFORM_PRODUCT_PAGE':                        
                        $stmt->bindValue($identifier, $this->link_platform_product_page, PDO::PARAM_STR);
                        break;
                    case 'LINK_HF_PRODUCT':                        
                        $stmt->bindValue($identifier, $this->link_hf_product, PDO::PARAM_STR);
                        break;
                    case 'LINK_FIRST_PRODUCT':                        
                        $stmt->bindValue($identifier, $this->link_first_product, PDO::PARAM_STR);
                        break;
                    case 'PLATFORM_PRODUCT_ID':                        
                        $stmt->bindValue($identifier, $this->platform_product_id, PDO::PARAM_STR);
                        break;
                    case 'HF_PRODUCT_STOCK':                        
                        $stmt->bindValue($identifier, $this->hf_product_stock, PDO::PARAM_INT);
                        break;
                    case 'HF_PRODUCT_STOCK_ORDER':                        
                        $stmt->bindValue($identifier, $this->hf_product_stock_order, PDO::PARAM_INT);
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
                    case 'PRODUCT_BASE_ID_VERSION':                        
                        $stmt->bindValue($identifier, $this->product_base_id_version, PDO::PARAM_INT);
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
        $pos = CrawlerProductListingVersionTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getProductBaseId();
                break;
            case 2:
                return $this->getHfPosition();
                break;
            case 3:
                return $this->getHfPrice();
                break;
            case 4:
                return $this->getFirstPosition();
                break;
            case 5:
                return $this->getFirstPrice();
                break;
            case 6:
                return $this->getPlatform();
                break;
            case 7:
                return $this->getLinkPlatformProductPage();
                break;
            case 8:
                return $this->getLinkHfProduct();
                break;
            case 9:
                return $this->getLinkFirstProduct();
                break;
            case 10:
                return $this->getPlatformProductId();
                break;
            case 11:
                return $this->getHfProductStock();
                break;
            case 12:
                return $this->getHfProductStockOrder();
                break;
            case 13:
                return $this->getCreatedAt();
                break;
            case 14:
                return $this->getUpdatedAt();
                break;
            case 15:
                return $this->getVersion();
                break;
            case 16:
                return $this->getVersionCreatedAt();
                break;
            case 17:
                return $this->getVersionCreatedBy();
                break;
            case 18:
                return $this->getProductBaseIdVersion();
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
        if (isset($alreadyDumpedObjects['CrawlerProductListingVersion'][serialize($this->getPrimaryKey())])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['CrawlerProductListingVersion'][serialize($this->getPrimaryKey())] = true;
        $keys = CrawlerProductListingVersionTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getProductBaseId(),
            $keys[2] => $this->getHfPosition(),
            $keys[3] => $this->getHfPrice(),
            $keys[4] => $this->getFirstPosition(),
            $keys[5] => $this->getFirstPrice(),
            $keys[6] => $this->getPlatform(),
            $keys[7] => $this->getLinkPlatformProductPage(),
            $keys[8] => $this->getLinkHfProduct(),
            $keys[9] => $this->getLinkFirstProduct(),
            $keys[10] => $this->getPlatformProductId(),
            $keys[11] => $this->getHfProductStock(),
            $keys[12] => $this->getHfProductStockOrder(),
            $keys[13] => $this->getCreatedAt(),
            $keys[14] => $this->getUpdatedAt(),
            $keys[15] => $this->getVersion(),
            $keys[16] => $this->getVersionCreatedAt(),
            $keys[17] => $this->getVersionCreatedBy(),
            $keys[18] => $this->getProductBaseIdVersion(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }
        
        if ($includeForeignObjects) {
            if (null !== $this->aCrawlerProductListing) {
                $result['CrawlerProductListing'] = $this->aCrawlerProductListing->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
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
        $pos = CrawlerProductListingVersionTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

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
                $this->setProductBaseId($value);
                break;
            case 2:
                $this->setHfPosition($value);
                break;
            case 3:
                $this->setHfPrice($value);
                break;
            case 4:
                $this->setFirstPosition($value);
                break;
            case 5:
                $this->setFirstPrice($value);
                break;
            case 6:
                $this->setPlatform($value);
                break;
            case 7:
                $this->setLinkPlatformProductPage($value);
                break;
            case 8:
                $this->setLinkHfProduct($value);
                break;
            case 9:
                $this->setLinkFirstProduct($value);
                break;
            case 10:
                $this->setPlatformProductId($value);
                break;
            case 11:
                $this->setHfProductStock($value);
                break;
            case 12:
                $this->setHfProductStockOrder($value);
                break;
            case 13:
                $this->setCreatedAt($value);
                break;
            case 14:
                $this->setUpdatedAt($value);
                break;
            case 15:
                $this->setVersion($value);
                break;
            case 16:
                $this->setVersionCreatedAt($value);
                break;
            case 17:
                $this->setVersionCreatedBy($value);
                break;
            case 18:
                $this->setProductBaseIdVersion($value);
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
        $keys = CrawlerProductListingVersionTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setProductBaseId($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setHfPosition($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setHfPrice($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setFirstPosition($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setFirstPrice($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setPlatform($arr[$keys[6]]);
        if (array_key_exists($keys[7], $arr)) $this->setLinkPlatformProductPage($arr[$keys[7]]);
        if (array_key_exists($keys[8], $arr)) $this->setLinkHfProduct($arr[$keys[8]]);
        if (array_key_exists($keys[9], $arr)) $this->setLinkFirstProduct($arr[$keys[9]]);
        if (array_key_exists($keys[10], $arr)) $this->setPlatformProductId($arr[$keys[10]]);
        if (array_key_exists($keys[11], $arr)) $this->setHfProductStock($arr[$keys[11]]);
        if (array_key_exists($keys[12], $arr)) $this->setHfProductStockOrder($arr[$keys[12]]);
        if (array_key_exists($keys[13], $arr)) $this->setCreatedAt($arr[$keys[13]]);
        if (array_key_exists($keys[14], $arr)) $this->setUpdatedAt($arr[$keys[14]]);
        if (array_key_exists($keys[15], $arr)) $this->setVersion($arr[$keys[15]]);
        if (array_key_exists($keys[16], $arr)) $this->setVersionCreatedAt($arr[$keys[16]]);
        if (array_key_exists($keys[17], $arr)) $this->setVersionCreatedBy($arr[$keys[17]]);
        if (array_key_exists($keys[18], $arr)) $this->setProductBaseIdVersion($arr[$keys[18]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(CrawlerProductListingVersionTableMap::DATABASE_NAME);

        if ($this->isColumnModified(CrawlerProductListingVersionTableMap::ID)) $criteria->add(CrawlerProductListingVersionTableMap::ID, $this->id);
        if ($this->isColumnModified(CrawlerProductListingVersionTableMap::PRODUCT_BASE_ID)) $criteria->add(CrawlerProductListingVersionTableMap::PRODUCT_BASE_ID, $this->product_base_id);
        if ($this->isColumnModified(CrawlerProductListingVersionTableMap::HF_POSITION)) $criteria->add(CrawlerProductListingVersionTableMap::HF_POSITION, $this->hf_position);
        if ($this->isColumnModified(CrawlerProductListingVersionTableMap::HF_PRICE)) $criteria->add(CrawlerProductListingVersionTableMap::HF_PRICE, $this->hf_price);
        if ($this->isColumnModified(CrawlerProductListingVersionTableMap::FIRST_POSITION)) $criteria->add(CrawlerProductListingVersionTableMap::FIRST_POSITION, $this->first_position);
        if ($this->isColumnModified(CrawlerProductListingVersionTableMap::FIRST_PRICE)) $criteria->add(CrawlerProductListingVersionTableMap::FIRST_PRICE, $this->first_price);
        if ($this->isColumnModified(CrawlerProductListingVersionTableMap::PLATFORM)) $criteria->add(CrawlerProductListingVersionTableMap::PLATFORM, $this->platform);
        if ($this->isColumnModified(CrawlerProductListingVersionTableMap::LINK_PLATFORM_PRODUCT_PAGE)) $criteria->add(CrawlerProductListingVersionTableMap::LINK_PLATFORM_PRODUCT_PAGE, $this->link_platform_product_page);
        if ($this->isColumnModified(CrawlerProductListingVersionTableMap::LINK_HF_PRODUCT)) $criteria->add(CrawlerProductListingVersionTableMap::LINK_HF_PRODUCT, $this->link_hf_product);
        if ($this->isColumnModified(CrawlerProductListingVersionTableMap::LINK_FIRST_PRODUCT)) $criteria->add(CrawlerProductListingVersionTableMap::LINK_FIRST_PRODUCT, $this->link_first_product);
        if ($this->isColumnModified(CrawlerProductListingVersionTableMap::PLATFORM_PRODUCT_ID)) $criteria->add(CrawlerProductListingVersionTableMap::PLATFORM_PRODUCT_ID, $this->platform_product_id);
        if ($this->isColumnModified(CrawlerProductListingVersionTableMap::HF_PRODUCT_STOCK)) $criteria->add(CrawlerProductListingVersionTableMap::HF_PRODUCT_STOCK, $this->hf_product_stock);
        if ($this->isColumnModified(CrawlerProductListingVersionTableMap::HF_PRODUCT_STOCK_ORDER)) $criteria->add(CrawlerProductListingVersionTableMap::HF_PRODUCT_STOCK_ORDER, $this->hf_product_stock_order);
        if ($this->isColumnModified(CrawlerProductListingVersionTableMap::CREATED_AT)) $criteria->add(CrawlerProductListingVersionTableMap::CREATED_AT, $this->created_at);
        if ($this->isColumnModified(CrawlerProductListingVersionTableMap::UPDATED_AT)) $criteria->add(CrawlerProductListingVersionTableMap::UPDATED_AT, $this->updated_at);
        if ($this->isColumnModified(CrawlerProductListingVersionTableMap::VERSION)) $criteria->add(CrawlerProductListingVersionTableMap::VERSION, $this->version);
        if ($this->isColumnModified(CrawlerProductListingVersionTableMap::VERSION_CREATED_AT)) $criteria->add(CrawlerProductListingVersionTableMap::VERSION_CREATED_AT, $this->version_created_at);
        if ($this->isColumnModified(CrawlerProductListingVersionTableMap::VERSION_CREATED_BY)) $criteria->add(CrawlerProductListingVersionTableMap::VERSION_CREATED_BY, $this->version_created_by);
        if ($this->isColumnModified(CrawlerProductListingVersionTableMap::PRODUCT_BASE_ID_VERSION)) $criteria->add(CrawlerProductListingVersionTableMap::PRODUCT_BASE_ID_VERSION, $this->product_base_id_version);

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
        $criteria = new Criteria(CrawlerProductListingVersionTableMap::DATABASE_NAME);
        $criteria->add(CrawlerProductListingVersionTableMap::ID, $this->id);
        $criteria->add(CrawlerProductListingVersionTableMap::VERSION, $this->version);

        return $criteria;
    }

    /**
     * Returns the composite primary key for this object.
     * The array elements will be in same order as specified in XML.
     * @return array
     */
    public function getPrimaryKey()
    {
        $pks = array();
        $pks[0] = $this->getId();
        $pks[1] = $this->getVersion();

        return $pks;
    }

    /**
     * Set the [composite] primary key.
     *
     * @param      array $keys The elements of the composite key (order must match the order in XML file).
     * @return void
     */
    public function setPrimaryKey($keys)
    {
        $this->setId($keys[0]);
        $this->setVersion($keys[1]);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {

        return (null === $this->getId()) && (null === $this->getVersion());
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \HookAdminCrawlerDashboard\Model\CrawlerProductListingVersion (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setId($this->getId());
        $copyObj->setProductBaseId($this->getProductBaseId());
        $copyObj->setHfPosition($this->getHfPosition());
        $copyObj->setHfPrice($this->getHfPrice());
        $copyObj->setFirstPosition($this->getFirstPosition());
        $copyObj->setFirstPrice($this->getFirstPrice());
        $copyObj->setPlatform($this->getPlatform());
        $copyObj->setLinkPlatformProductPage($this->getLinkPlatformProductPage());
        $copyObj->setLinkHfProduct($this->getLinkHfProduct());
        $copyObj->setLinkFirstProduct($this->getLinkFirstProduct());
        $copyObj->setPlatformProductId($this->getPlatformProductId());
        $copyObj->setHfProductStock($this->getHfProductStock());
        $copyObj->setHfProductStockOrder($this->getHfProductStockOrder());
        $copyObj->setCreatedAt($this->getCreatedAt());
        $copyObj->setUpdatedAt($this->getUpdatedAt());
        $copyObj->setVersion($this->getVersion());
        $copyObj->setVersionCreatedAt($this->getVersionCreatedAt());
        $copyObj->setVersionCreatedBy($this->getVersionCreatedBy());
        $copyObj->setProductBaseIdVersion($this->getProductBaseIdVersion());
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
     * @return                 \HookAdminCrawlerDashboard\Model\CrawlerProductListingVersion Clone of current object.
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
     * Declares an association between this object and a ChildCrawlerProductListing object.
     *
     * @param                  ChildCrawlerProductListing $v
     * @return                 \HookAdminCrawlerDashboard\Model\CrawlerProductListingVersion The current object (for fluent API support)
     * @throws PropelException
     */
    public function setCrawlerProductListing(ChildCrawlerProductListing $v = null)
    {
        if ($v === null) {
            $this->setId(NULL);
        } else {
            $this->setId($v->getId());
        }

        $this->aCrawlerProductListing = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildCrawlerProductListing object, it will not be re-added.
        if ($v !== null) {
            $v->addCrawlerProductListingVersion($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildCrawlerProductListing object
     *
     * @param      ConnectionInterface $con Optional Connection object.
     * @return                 ChildCrawlerProductListing The associated ChildCrawlerProductListing object.
     * @throws PropelException
     */
    public function getCrawlerProductListing(ConnectionInterface $con = null)
    {
        if ($this->aCrawlerProductListing === null && ($this->id !== null)) {
            $this->aCrawlerProductListing = ChildCrawlerProductListingQuery::create()->findPk($this->id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aCrawlerProductListing->addCrawlerProductListingVersions($this);
             */
        }

        return $this->aCrawlerProductListing;
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->id = null;
        $this->product_base_id = null;
        $this->hf_position = null;
        $this->hf_price = null;
        $this->first_position = null;
        $this->first_price = null;
        $this->platform = null;
        $this->link_platform_product_page = null;
        $this->link_hf_product = null;
        $this->link_first_product = null;
        $this->platform_product_id = null;
        $this->hf_product_stock = null;
        $this->hf_product_stock_order = null;
        $this->created_at = null;
        $this->updated_at = null;
        $this->version = null;
        $this->version_created_at = null;
        $this->version_created_by = null;
        $this->product_base_id_version = null;
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
        } // if ($deep)

        $this->aCrawlerProductListing = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(CrawlerProductListingVersionTableMap::DEFAULT_STRING_FORMAT);
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
