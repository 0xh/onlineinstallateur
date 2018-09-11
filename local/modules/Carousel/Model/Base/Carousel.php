<?php

namespace Carousel\Model\Base;

use \DateTime;
use \Exception;
use \PDO;
use Carousel\Model\Carousel as ChildCarousel;
use Carousel\Model\CarouselI18n as ChildCarouselI18n;
use Carousel\Model\CarouselI18nQuery as ChildCarouselI18nQuery;
use Carousel\Model\CarouselName as ChildCarouselName;
use Carousel\Model\CarouselNameQuery as ChildCarouselNameQuery;
use Carousel\Model\CarouselNameVersionQuery as ChildCarouselNameVersionQuery;
use Carousel\Model\CarouselQuery as ChildCarouselQuery;
use Carousel\Model\CarouselVersion as ChildCarouselVersion;
use Carousel\Model\CarouselVersionQuery as ChildCarouselVersionQuery;
use Carousel\Model\Map\CarouselTableMap;
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

abstract class Carousel implements ActiveRecordInterface 
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Carousel\\Model\\Map\\CarouselTableMap';


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
     * The value for the carousel_id field.
     * @var        int
     */
    protected $carousel_id;

    /**
     * The value for the visible field.
     * Note: this column has a database default value of: 1
     * @var        int
     */
    protected $visible;

    /**
     * The value for the file field.
     * @var        string
     */
    protected $file;

    /**
     * The value for the position field.
     * @var        int
     */
    protected $position;

    /**
     * The value for the url field.
     * @var        string
     */
    protected $url;

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
     * @var        CarouselName
     */
    protected $aCarouselName;

    /**
     * @var        ObjectCollection|ChildCarouselI18n[] Collection to store aggregation of ChildCarouselI18n objects.
     */
    protected $collCarouselI18ns;
    protected $collCarouselI18nsPartial;

    /**
     * @var        ObjectCollection|ChildCarouselVersion[] Collection to store aggregation of ChildCarouselVersion objects.
     */
    protected $collCarouselVersions;
    protected $collCarouselVersionsPartial;

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
     * @var        array[ChildCarouselI18n]
     */
    protected $currentTranslations;

    // versionable behavior
    
    
    /**
     * @var bool
     */
    protected $enforceVersion = false;
            
    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection
     */
    protected $carouselI18nsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection
     */
    protected $carouselVersionsScheduledForDeletion = null;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see __construct()
     */
    public function applyDefaultValues()
    {
        $this->visible = 1;
        $this->version = 0;
    }

    /**
     * Initializes internal state of Carousel\Model\Base\Carousel object.
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
     * Compares this with another <code>Carousel</code> instance.  If
     * <code>obj</code> is an instance of <code>Carousel</code>, delegates to
     * <code>equals(Carousel)</code>.  Otherwise, returns <code>false</code>.
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
     * @return Carousel The current object, for fluid interface
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
     * @return Carousel The current object, for fluid interface
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
     * Get the [carousel_id] column value.
     * 
     * @return   int
     */
    public function getCarouselId()
    {

        return $this->carousel_id;
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
     * Get the [file] column value.
     * 
     * @return   string
     */
    public function getFile()
    {

        return $this->file;
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
     * Get the [url] column value.
     * 
     * @return   string
     */
    public function getUrl()
    {

        return $this->url;
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
     * @return   \Carousel\Model\Carousel The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[CarouselTableMap::ID] = true;
        }


        return $this;
    } // setId()

    /**
     * Set the value of [carousel_id] column.
     * 
     * @param      int $v new value
     * @return   \Carousel\Model\Carousel The current object (for fluent API support)
     */
    public function setCarouselId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->carousel_id !== $v) {
            $this->carousel_id = $v;
            $this->modifiedColumns[CarouselTableMap::CAROUSEL_ID] = true;
        }

        if ($this->aCarouselName !== null && $this->aCarouselName->getId() !== $v) {
            $this->aCarouselName = null;
        }


        return $this;
    } // setCarouselId()

    /**
     * Set the value of [visible] column.
     * 
     * @param      int $v new value
     * @return   \Carousel\Model\Carousel The current object (for fluent API support)
     */
    public function setVisible($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->visible !== $v) {
            $this->visible = $v;
            $this->modifiedColumns[CarouselTableMap::VISIBLE] = true;
        }


        return $this;
    } // setVisible()

    /**
     * Set the value of [file] column.
     * 
     * @param      string $v new value
     * @return   \Carousel\Model\Carousel The current object (for fluent API support)
     */
    public function setFile($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->file !== $v) {
            $this->file = $v;
            $this->modifiedColumns[CarouselTableMap::FILE] = true;
        }


        return $this;
    } // setFile()

    /**
     * Set the value of [position] column.
     * 
     * @param      int $v new value
     * @return   \Carousel\Model\Carousel The current object (for fluent API support)
     */
    public function setPosition($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->position !== $v) {
            $this->position = $v;
            $this->modifiedColumns[CarouselTableMap::POSITION] = true;
        }


        return $this;
    } // setPosition()

    /**
     * Set the value of [url] column.
     * 
     * @param      string $v new value
     * @return   \Carousel\Model\Carousel The current object (for fluent API support)
     */
    public function setUrl($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->url !== $v) {
            $this->url = $v;
            $this->modifiedColumns[CarouselTableMap::URL] = true;
        }


        return $this;
    } // setUrl()

    /**
     * Sets the value of [created_at] column to a normalized version of the date/time value specified.
     * 
     * @param      mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return   \Carousel\Model\Carousel The current object (for fluent API support)
     */
    public function setCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->created_at !== null || $dt !== null) {
            if ($dt !== $this->created_at) {
                $this->created_at = $dt;
                $this->modifiedColumns[CarouselTableMap::CREATED_AT] = true;
            }
        } // if either are not null


        return $this;
    } // setCreatedAt()

    /**
     * Sets the value of [updated_at] column to a normalized version of the date/time value specified.
     * 
     * @param      mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return   \Carousel\Model\Carousel The current object (for fluent API support)
     */
    public function setUpdatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->updated_at !== null || $dt !== null) {
            if ($dt !== $this->updated_at) {
                $this->updated_at = $dt;
                $this->modifiedColumns[CarouselTableMap::UPDATED_AT] = true;
            }
        } // if either are not null


        return $this;
    } // setUpdatedAt()

    /**
     * Set the value of [version] column.
     * 
     * @param      int $v new value
     * @return   \Carousel\Model\Carousel The current object (for fluent API support)
     */
    public function setVersion($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->version !== $v) {
            $this->version = $v;
            $this->modifiedColumns[CarouselTableMap::VERSION] = true;
        }


        return $this;
    } // setVersion()

    /**
     * Sets the value of [version_created_at] column to a normalized version of the date/time value specified.
     * 
     * @param      mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return   \Carousel\Model\Carousel The current object (for fluent API support)
     */
    public function setVersionCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->version_created_at !== null || $dt !== null) {
            if ($dt !== $this->version_created_at) {
                $this->version_created_at = $dt;
                $this->modifiedColumns[CarouselTableMap::VERSION_CREATED_AT] = true;
            }
        } // if either are not null


        return $this;
    } // setVersionCreatedAt()

    /**
     * Set the value of [version_created_by] column.
     * 
     * @param      string $v new value
     * @return   \Carousel\Model\Carousel The current object (for fluent API support)
     */
    public function setVersionCreatedBy($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->version_created_by !== $v) {
            $this->version_created_by = $v;
            $this->modifiedColumns[CarouselTableMap::VERSION_CREATED_BY] = true;
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
            if ($this->visible !== 1) {
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


            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : CarouselTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : CarouselTableMap::translateFieldName('CarouselId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->carousel_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : CarouselTableMap::translateFieldName('Visible', TableMap::TYPE_PHPNAME, $indexType)];
            $this->visible = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : CarouselTableMap::translateFieldName('File', TableMap::TYPE_PHPNAME, $indexType)];
            $this->file = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : CarouselTableMap::translateFieldName('Position', TableMap::TYPE_PHPNAME, $indexType)];
            $this->position = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : CarouselTableMap::translateFieldName('Url', TableMap::TYPE_PHPNAME, $indexType)];
            $this->url = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : CarouselTableMap::translateFieldName('CreatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->created_at = (null !== $col) ? PropelDateTime::newInstance($col, null, '\DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : CarouselTableMap::translateFieldName('UpdatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->updated_at = (null !== $col) ? PropelDateTime::newInstance($col, null, '\DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : CarouselTableMap::translateFieldName('Version', TableMap::TYPE_PHPNAME, $indexType)];
            $this->version = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : CarouselTableMap::translateFieldName('VersionCreatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->version_created_at = (null !== $col) ? PropelDateTime::newInstance($col, null, '\DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 10 + $startcol : CarouselTableMap::translateFieldName('VersionCreatedBy', TableMap::TYPE_PHPNAME, $indexType)];
            $this->version_created_by = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 11; // 11 = CarouselTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating \Carousel\Model\Carousel object", 0, $e);
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
        if ($this->aCarouselName !== null && $this->carousel_id !== $this->aCarouselName->getId()) {
            $this->aCarouselName = null;
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
            $con = Propel::getServiceContainer()->getReadConnection(CarouselTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildCarouselQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aCarouselName = null;
            $this->collCarouselI18ns = null;

            $this->collCarouselVersions = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Carousel::setDeleted()
     * @see Carousel::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(CarouselTableMap::DATABASE_NAME);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = ChildCarouselQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(CarouselTableMap::DATABASE_NAME);
        }

        $con->beginTransaction();
        $isInsert = $this->isNew();
        try {
            $ret = $this->preSave($con);
            // versionable behavior
            if ($this->isVersioningNecessary()) {
                $this->setVersion($this->isNew() ? 1 : $this->getLastVersionNumber($con) + 1);
                if (!$this->isColumnModified(CarouselTableMap::VERSION_CREATED_AT)) {
                    $this->setVersionCreatedAt(time());
                }
                $createVersion = true; // for postSave hook
            }
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
                // timestampable behavior
                if (!$this->isColumnModified(CarouselTableMap::CREATED_AT)) {
                    $this->setCreatedAt(time());
                }
                if (!$this->isColumnModified(CarouselTableMap::UPDATED_AT)) {
                    $this->setUpdatedAt(time());
                }
            } else {
                $ret = $ret && $this->preUpdate($con);
                // timestampable behavior
                if ($this->isModified() && !$this->isColumnModified(CarouselTableMap::UPDATED_AT)) {
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
                CarouselTableMap::addInstanceToPool($this);
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

            if ($this->aCarouselName !== null) {
                if ($this->aCarouselName->isModified() || $this->aCarouselName->isNew()) {
                    $affectedRows += $this->aCarouselName->save($con);
                }
                $this->setCarouselName($this->aCarouselName);
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

            if ($this->carouselI18nsScheduledForDeletion !== null) {
                if (!$this->carouselI18nsScheduledForDeletion->isEmpty()) {
                    \Carousel\Model\CarouselI18nQuery::create()
                        ->filterByPrimaryKeys($this->carouselI18nsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->carouselI18nsScheduledForDeletion = null;
                }
            }

                if ($this->collCarouselI18ns !== null) {
            foreach ($this->collCarouselI18ns as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->carouselVersionsScheduledForDeletion !== null) {
                if (!$this->carouselVersionsScheduledForDeletion->isEmpty()) {
                    \Carousel\Model\CarouselVersionQuery::create()
                        ->filterByPrimaryKeys($this->carouselVersionsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->carouselVersionsScheduledForDeletion = null;
                }
            }

                if ($this->collCarouselVersions !== null) {
            foreach ($this->collCarouselVersions as $referrerFK) {
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

        $this->modifiedColumns[CarouselTableMap::ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . CarouselTableMap::ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(CarouselTableMap::ID)) {
            $modifiedColumns[':p' . $index++]  = 'ID';
        }
        if ($this->isColumnModified(CarouselTableMap::CAROUSEL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'CAROUSEL_ID';
        }
        if ($this->isColumnModified(CarouselTableMap::VISIBLE)) {
            $modifiedColumns[':p' . $index++]  = 'VISIBLE';
        }
        if ($this->isColumnModified(CarouselTableMap::FILE)) {
            $modifiedColumns[':p' . $index++]  = 'FILE';
        }
        if ($this->isColumnModified(CarouselTableMap::POSITION)) {
            $modifiedColumns[':p' . $index++]  = 'POSITION';
        }
        if ($this->isColumnModified(CarouselTableMap::URL)) {
            $modifiedColumns[':p' . $index++]  = 'URL';
        }
        if ($this->isColumnModified(CarouselTableMap::CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'CREATED_AT';
        }
        if ($this->isColumnModified(CarouselTableMap::UPDATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'UPDATED_AT';
        }
        if ($this->isColumnModified(CarouselTableMap::VERSION)) {
            $modifiedColumns[':p' . $index++]  = 'VERSION';
        }
        if ($this->isColumnModified(CarouselTableMap::VERSION_CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'VERSION_CREATED_AT';
        }
        if ($this->isColumnModified(CarouselTableMap::VERSION_CREATED_BY)) {
            $modifiedColumns[':p' . $index++]  = 'VERSION_CREATED_BY';
        }

        $sql = sprintf(
            'INSERT INTO carousel (%s) VALUES (%s)',
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
                    case 'CAROUSEL_ID':                        
                        $stmt->bindValue($identifier, $this->carousel_id, PDO::PARAM_INT);
                        break;
                    case 'VISIBLE':                        
                        $stmt->bindValue($identifier, $this->visible, PDO::PARAM_INT);
                        break;
                    case 'FILE':                        
                        $stmt->bindValue($identifier, $this->file, PDO::PARAM_STR);
                        break;
                    case 'POSITION':                        
                        $stmt->bindValue($identifier, $this->position, PDO::PARAM_INT);
                        break;
                    case 'URL':                        
                        $stmt->bindValue($identifier, $this->url, PDO::PARAM_STR);
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
        $pos = CarouselTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getCarouselId();
                break;
            case 2:
                return $this->getVisible();
                break;
            case 3:
                return $this->getFile();
                break;
            case 4:
                return $this->getPosition();
                break;
            case 5:
                return $this->getUrl();
                break;
            case 6:
                return $this->getCreatedAt();
                break;
            case 7:
                return $this->getUpdatedAt();
                break;
            case 8:
                return $this->getVersion();
                break;
            case 9:
                return $this->getVersionCreatedAt();
                break;
            case 10:
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
        if (isset($alreadyDumpedObjects['Carousel'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Carousel'][$this->getPrimaryKey()] = true;
        $keys = CarouselTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getCarouselId(),
            $keys[2] => $this->getVisible(),
            $keys[3] => $this->getFile(),
            $keys[4] => $this->getPosition(),
            $keys[5] => $this->getUrl(),
            $keys[6] => $this->getCreatedAt(),
            $keys[7] => $this->getUpdatedAt(),
            $keys[8] => $this->getVersion(),
            $keys[9] => $this->getVersionCreatedAt(),
            $keys[10] => $this->getVersionCreatedBy(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }
        
        if ($includeForeignObjects) {
            if (null !== $this->aCarouselName) {
                $result['CarouselName'] = $this->aCarouselName->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collCarouselI18ns) {
                $result['CarouselI18ns'] = $this->collCarouselI18ns->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collCarouselVersions) {
                $result['CarouselVersions'] = $this->collCarouselVersions->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
        $pos = CarouselTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

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
                $this->setCarouselId($value);
                break;
            case 2:
                $this->setVisible($value);
                break;
            case 3:
                $this->setFile($value);
                break;
            case 4:
                $this->setPosition($value);
                break;
            case 5:
                $this->setUrl($value);
                break;
            case 6:
                $this->setCreatedAt($value);
                break;
            case 7:
                $this->setUpdatedAt($value);
                break;
            case 8:
                $this->setVersion($value);
                break;
            case 9:
                $this->setVersionCreatedAt($value);
                break;
            case 10:
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
        $keys = CarouselTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setCarouselId($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setVisible($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setFile($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setPosition($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setUrl($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setCreatedAt($arr[$keys[6]]);
        if (array_key_exists($keys[7], $arr)) $this->setUpdatedAt($arr[$keys[7]]);
        if (array_key_exists($keys[8], $arr)) $this->setVersion($arr[$keys[8]]);
        if (array_key_exists($keys[9], $arr)) $this->setVersionCreatedAt($arr[$keys[9]]);
        if (array_key_exists($keys[10], $arr)) $this->setVersionCreatedBy($arr[$keys[10]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(CarouselTableMap::DATABASE_NAME);

        if ($this->isColumnModified(CarouselTableMap::ID)) $criteria->add(CarouselTableMap::ID, $this->id);
        if ($this->isColumnModified(CarouselTableMap::CAROUSEL_ID)) $criteria->add(CarouselTableMap::CAROUSEL_ID, $this->carousel_id);
        if ($this->isColumnModified(CarouselTableMap::VISIBLE)) $criteria->add(CarouselTableMap::VISIBLE, $this->visible);
        if ($this->isColumnModified(CarouselTableMap::FILE)) $criteria->add(CarouselTableMap::FILE, $this->file);
        if ($this->isColumnModified(CarouselTableMap::POSITION)) $criteria->add(CarouselTableMap::POSITION, $this->position);
        if ($this->isColumnModified(CarouselTableMap::URL)) $criteria->add(CarouselTableMap::URL, $this->url);
        if ($this->isColumnModified(CarouselTableMap::CREATED_AT)) $criteria->add(CarouselTableMap::CREATED_AT, $this->created_at);
        if ($this->isColumnModified(CarouselTableMap::UPDATED_AT)) $criteria->add(CarouselTableMap::UPDATED_AT, $this->updated_at);
        if ($this->isColumnModified(CarouselTableMap::VERSION)) $criteria->add(CarouselTableMap::VERSION, $this->version);
        if ($this->isColumnModified(CarouselTableMap::VERSION_CREATED_AT)) $criteria->add(CarouselTableMap::VERSION_CREATED_AT, $this->version_created_at);
        if ($this->isColumnModified(CarouselTableMap::VERSION_CREATED_BY)) $criteria->add(CarouselTableMap::VERSION_CREATED_BY, $this->version_created_by);

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
        $criteria = new Criteria(CarouselTableMap::DATABASE_NAME);
        $criteria->add(CarouselTableMap::ID, $this->id);

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
     * @param      object $copyObj An object of \Carousel\Model\Carousel (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setCarouselId($this->getCarouselId());
        $copyObj->setVisible($this->getVisible());
        $copyObj->setFile($this->getFile());
        $copyObj->setPosition($this->getPosition());
        $copyObj->setUrl($this->getUrl());
        $copyObj->setCreatedAt($this->getCreatedAt());
        $copyObj->setUpdatedAt($this->getUpdatedAt());
        $copyObj->setVersion($this->getVersion());
        $copyObj->setVersionCreatedAt($this->getVersionCreatedAt());
        $copyObj->setVersionCreatedBy($this->getVersionCreatedBy());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getCarouselI18ns() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addCarouselI18n($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getCarouselVersions() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addCarouselVersion($relObj->copy($deepCopy));
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
     * @return                 \Carousel\Model\Carousel Clone of current object.
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
     * Declares an association between this object and a ChildCarouselName object.
     *
     * @param                  ChildCarouselName $v
     * @return                 \Carousel\Model\Carousel The current object (for fluent API support)
     * @throws PropelException
     */
    public function setCarouselName(ChildCarouselName $v = null)
    {
        if ($v === null) {
            $this->setCarouselId(NULL);
        } else {
            $this->setCarouselId($v->getId());
        }

        $this->aCarouselName = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildCarouselName object, it will not be re-added.
        if ($v !== null) {
            $v->addCarousel($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildCarouselName object
     *
     * @param      ConnectionInterface $con Optional Connection object.
     * @return                 ChildCarouselName The associated ChildCarouselName object.
     * @throws PropelException
     */
    public function getCarouselName(ConnectionInterface $con = null)
    {
        if ($this->aCarouselName === null && ($this->carousel_id !== null)) {
            $this->aCarouselName = ChildCarouselNameQuery::create()->findPk($this->carousel_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aCarouselName->addCarousels($this);
             */
        }

        return $this->aCarouselName;
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
        if ('CarouselI18n' == $relationName) {
            return $this->initCarouselI18ns();
        }
        if ('CarouselVersion' == $relationName) {
            return $this->initCarouselVersions();
        }
    }

    /**
     * Clears out the collCarouselI18ns collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addCarouselI18ns()
     */
    public function clearCarouselI18ns()
    {
        $this->collCarouselI18ns = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collCarouselI18ns collection loaded partially.
     */
    public function resetPartialCarouselI18ns($v = true)
    {
        $this->collCarouselI18nsPartial = $v;
    }

    /**
     * Initializes the collCarouselI18ns collection.
     *
     * By default this just sets the collCarouselI18ns collection to an empty array (like clearcollCarouselI18ns());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initCarouselI18ns($overrideExisting = true)
    {
        if (null !== $this->collCarouselI18ns && !$overrideExisting) {
            return;
        }
        $this->collCarouselI18ns = new ObjectCollection();
        $this->collCarouselI18ns->setModel('\Carousel\Model\CarouselI18n');
    }

    /**
     * Gets an array of ChildCarouselI18n objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildCarousel is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return Collection|ChildCarouselI18n[] List of ChildCarouselI18n objects
     * @throws PropelException
     */
    public function getCarouselI18ns($criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collCarouselI18nsPartial && !$this->isNew();
        if (null === $this->collCarouselI18ns || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collCarouselI18ns) {
                // return empty collection
                $this->initCarouselI18ns();
            } else {
                $collCarouselI18ns = ChildCarouselI18nQuery::create(null, $criteria)
                    ->filterByCarousel($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collCarouselI18nsPartial && count($collCarouselI18ns)) {
                        $this->initCarouselI18ns(false);

                        foreach ($collCarouselI18ns as $obj) {
                            if (false == $this->collCarouselI18ns->contains($obj)) {
                                $this->collCarouselI18ns->append($obj);
                            }
                        }

                        $this->collCarouselI18nsPartial = true;
                    }

                    reset($collCarouselI18ns);

                    return $collCarouselI18ns;
                }

                if ($partial && $this->collCarouselI18ns) {
                    foreach ($this->collCarouselI18ns as $obj) {
                        if ($obj->isNew()) {
                            $collCarouselI18ns[] = $obj;
                        }
                    }
                }

                $this->collCarouselI18ns = $collCarouselI18ns;
                $this->collCarouselI18nsPartial = false;
            }
        }

        return $this->collCarouselI18ns;
    }

    /**
     * Sets a collection of CarouselI18n objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $carouselI18ns A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return   ChildCarousel The current object (for fluent API support)
     */
    public function setCarouselI18ns(Collection $carouselI18ns, ConnectionInterface $con = null)
    {
        $carouselI18nsToDelete = $this->getCarouselI18ns(new Criteria(), $con)->diff($carouselI18ns);

        
        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->carouselI18nsScheduledForDeletion = clone $carouselI18nsToDelete;

        foreach ($carouselI18nsToDelete as $carouselI18nRemoved) {
            $carouselI18nRemoved->setCarousel(null);
        }

        $this->collCarouselI18ns = null;
        foreach ($carouselI18ns as $carouselI18n) {
            $this->addCarouselI18n($carouselI18n);
        }

        $this->collCarouselI18ns = $carouselI18ns;
        $this->collCarouselI18nsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related CarouselI18n objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related CarouselI18n objects.
     * @throws PropelException
     */
    public function countCarouselI18ns(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collCarouselI18nsPartial && !$this->isNew();
        if (null === $this->collCarouselI18ns || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collCarouselI18ns) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getCarouselI18ns());
            }

            $query = ChildCarouselI18nQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCarousel($this)
                ->count($con);
        }

        return count($this->collCarouselI18ns);
    }

    /**
     * Method called to associate a ChildCarouselI18n object to this object
     * through the ChildCarouselI18n foreign key attribute.
     *
     * @param    ChildCarouselI18n $l ChildCarouselI18n
     * @return   \Carousel\Model\Carousel The current object (for fluent API support)
     */
    public function addCarouselI18n(ChildCarouselI18n $l)
    {
        if ($l && $locale = $l->getLocale()) {
            $this->setLocale($locale);
            $this->currentTranslations[$locale] = $l;
        }
        if ($this->collCarouselI18ns === null) {
            $this->initCarouselI18ns();
            $this->collCarouselI18nsPartial = true;
        }

        if (!in_array($l, $this->collCarouselI18ns->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddCarouselI18n($l);
        }

        return $this;
    }

    /**
     * @param CarouselI18n $carouselI18n The carouselI18n object to add.
     */
    protected function doAddCarouselI18n($carouselI18n)
    {
        $this->collCarouselI18ns[]= $carouselI18n;
        $carouselI18n->setCarousel($this);
    }

    /**
     * @param  CarouselI18n $carouselI18n The carouselI18n object to remove.
     * @return ChildCarousel The current object (for fluent API support)
     */
    public function removeCarouselI18n($carouselI18n)
    {
        if ($this->getCarouselI18ns()->contains($carouselI18n)) {
            $this->collCarouselI18ns->remove($this->collCarouselI18ns->search($carouselI18n));
            if (null === $this->carouselI18nsScheduledForDeletion) {
                $this->carouselI18nsScheduledForDeletion = clone $this->collCarouselI18ns;
                $this->carouselI18nsScheduledForDeletion->clear();
            }
            $this->carouselI18nsScheduledForDeletion[]= clone $carouselI18n;
            $carouselI18n->setCarousel(null);
        }

        return $this;
    }

    /**
     * Clears out the collCarouselVersions collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addCarouselVersions()
     */
    public function clearCarouselVersions()
    {
        $this->collCarouselVersions = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collCarouselVersions collection loaded partially.
     */
    public function resetPartialCarouselVersions($v = true)
    {
        $this->collCarouselVersionsPartial = $v;
    }

    /**
     * Initializes the collCarouselVersions collection.
     *
     * By default this just sets the collCarouselVersions collection to an empty array (like clearcollCarouselVersions());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initCarouselVersions($overrideExisting = true)
    {
        if (null !== $this->collCarouselVersions && !$overrideExisting) {
            return;
        }
        $this->collCarouselVersions = new ObjectCollection();
        $this->collCarouselVersions->setModel('\Carousel\Model\CarouselVersion');
    }

    /**
     * Gets an array of ChildCarouselVersion objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildCarousel is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return Collection|ChildCarouselVersion[] List of ChildCarouselVersion objects
     * @throws PropelException
     */
    public function getCarouselVersions($criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collCarouselVersionsPartial && !$this->isNew();
        if (null === $this->collCarouselVersions || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collCarouselVersions) {
                // return empty collection
                $this->initCarouselVersions();
            } else {
                $collCarouselVersions = ChildCarouselVersionQuery::create(null, $criteria)
                    ->filterByCarousel($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collCarouselVersionsPartial && count($collCarouselVersions)) {
                        $this->initCarouselVersions(false);

                        foreach ($collCarouselVersions as $obj) {
                            if (false == $this->collCarouselVersions->contains($obj)) {
                                $this->collCarouselVersions->append($obj);
                            }
                        }

                        $this->collCarouselVersionsPartial = true;
                    }

                    reset($collCarouselVersions);

                    return $collCarouselVersions;
                }

                if ($partial && $this->collCarouselVersions) {
                    foreach ($this->collCarouselVersions as $obj) {
                        if ($obj->isNew()) {
                            $collCarouselVersions[] = $obj;
                        }
                    }
                }

                $this->collCarouselVersions = $collCarouselVersions;
                $this->collCarouselVersionsPartial = false;
            }
        }

        return $this->collCarouselVersions;
    }

    /**
     * Sets a collection of CarouselVersion objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $carouselVersions A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return   ChildCarousel The current object (for fluent API support)
     */
    public function setCarouselVersions(Collection $carouselVersions, ConnectionInterface $con = null)
    {
        $carouselVersionsToDelete = $this->getCarouselVersions(new Criteria(), $con)->diff($carouselVersions);

        
        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->carouselVersionsScheduledForDeletion = clone $carouselVersionsToDelete;

        foreach ($carouselVersionsToDelete as $carouselVersionRemoved) {
            $carouselVersionRemoved->setCarousel(null);
        }

        $this->collCarouselVersions = null;
        foreach ($carouselVersions as $carouselVersion) {
            $this->addCarouselVersion($carouselVersion);
        }

        $this->collCarouselVersions = $carouselVersions;
        $this->collCarouselVersionsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related CarouselVersion objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related CarouselVersion objects.
     * @throws PropelException
     */
    public function countCarouselVersions(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collCarouselVersionsPartial && !$this->isNew();
        if (null === $this->collCarouselVersions || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collCarouselVersions) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getCarouselVersions());
            }

            $query = ChildCarouselVersionQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCarousel($this)
                ->count($con);
        }

        return count($this->collCarouselVersions);
    }

    /**
     * Method called to associate a ChildCarouselVersion object to this object
     * through the ChildCarouselVersion foreign key attribute.
     *
     * @param    ChildCarouselVersion $l ChildCarouselVersion
     * @return   \Carousel\Model\Carousel The current object (for fluent API support)
     */
    public function addCarouselVersion(ChildCarouselVersion $l)
    {
        if ($this->collCarouselVersions === null) {
            $this->initCarouselVersions();
            $this->collCarouselVersionsPartial = true;
        }

        if (!in_array($l, $this->collCarouselVersions->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddCarouselVersion($l);
        }

        return $this;
    }

    /**
     * @param CarouselVersion $carouselVersion The carouselVersion object to add.
     */
    protected function doAddCarouselVersion($carouselVersion)
    {
        $this->collCarouselVersions[]= $carouselVersion;
        $carouselVersion->setCarousel($this);
    }

    /**
     * @param  CarouselVersion $carouselVersion The carouselVersion object to remove.
     * @return ChildCarousel The current object (for fluent API support)
     */
    public function removeCarouselVersion($carouselVersion)
    {
        if ($this->getCarouselVersions()->contains($carouselVersion)) {
            $this->collCarouselVersions->remove($this->collCarouselVersions->search($carouselVersion));
            if (null === $this->carouselVersionsScheduledForDeletion) {
                $this->carouselVersionsScheduledForDeletion = clone $this->collCarouselVersions;
                $this->carouselVersionsScheduledForDeletion->clear();
            }
            $this->carouselVersionsScheduledForDeletion[]= clone $carouselVersion;
            $carouselVersion->setCarousel(null);
        }

        return $this;
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->id = null;
        $this->carousel_id = null;
        $this->visible = null;
        $this->file = null;
        $this->position = null;
        $this->url = null;
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
            if ($this->collCarouselI18ns) {
                foreach ($this->collCarouselI18ns as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collCarouselVersions) {
                foreach ($this->collCarouselVersions as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        // i18n behavior
        $this->currentLocale = 'en_US';
        $this->currentTranslations = null;

        $this->collCarouselI18ns = null;
        $this->collCarouselVersions = null;
        $this->aCarouselName = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(CarouselTableMap::DEFAULT_STRING_FORMAT);
    }

    // timestampable behavior
    
    /**
     * Mark the current object so that the update date doesn't get updated during next save
     *
     * @return     ChildCarousel The current object (for fluent API support)
     */
    public function keepUpdateDateUnchanged()
    {
        $this->modifiedColumns[CarouselTableMap::UPDATED_AT] = true;
    
        return $this;
    }

    // i18n behavior
    
    /**
     * Sets the locale for translations
     *
     * @param     string $locale Locale to use for the translation, e.g. 'fr_FR'
     *
     * @return    ChildCarousel The current object (for fluent API support)
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
     * @return ChildCarouselI18n */
    public function getTranslation($locale = 'en_US', ConnectionInterface $con = null)
    {
        if (!isset($this->currentTranslations[$locale])) {
            if (null !== $this->collCarouselI18ns) {
                foreach ($this->collCarouselI18ns as $translation) {
                    if ($translation->getLocale() == $locale) {
                        $this->currentTranslations[$locale] = $translation;
    
                        return $translation;
                    }
                }
            }
            if ($this->isNew()) {
                $translation = new ChildCarouselI18n();
                $translation->setLocale($locale);
            } else {
                $translation = ChildCarouselI18nQuery::create()
                    ->filterByPrimaryKey(array($this->getPrimaryKey(), $locale))
                    ->findOneOrCreate($con);
                $this->currentTranslations[$locale] = $translation;
            }
            $this->addCarouselI18n($translation);
        }
    
        return $this->currentTranslations[$locale];
    }
    
    /**
     * Remove the translation for a given locale
     *
     * @param     string $locale Locale to use for the translation, e.g. 'fr_FR'
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return    ChildCarousel The current object (for fluent API support)
     */
    public function removeTranslation($locale = 'en_US', ConnectionInterface $con = null)
    {
        if (!$this->isNew()) {
            ChildCarouselI18nQuery::create()
                ->filterByPrimaryKey(array($this->getPrimaryKey(), $locale))
                ->delete($con);
        }
        if (isset($this->currentTranslations[$locale])) {
            unset($this->currentTranslations[$locale]);
        }
        foreach ($this->collCarouselI18ns as $key => $translation) {
            if ($translation->getLocale() == $locale) {
                unset($this->collCarouselI18ns[$key]);
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
     * @return ChildCarouselI18n */
    public function getCurrentTranslation(ConnectionInterface $con = null)
    {
        return $this->getTranslation($this->getLocale(), $con);
    }
    
    
        /**
         * Get the [alt] column value.
         * 
         * @return   string
         */
        public function getAlt()
        {
        return $this->getCurrentTranslation()->getAlt();
    }
    
    
        /**
         * Set the value of [alt] column.
         * 
         * @param      string $v new value
         * @return   \Carousel\Model\CarouselI18n The current object (for fluent API support)
         */
        public function setAlt($v)
        {    $this->getCurrentTranslation()->setAlt($v);
    
        return $this;
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
         * @return   \Carousel\Model\CarouselI18n The current object (for fluent API support)
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
         * @return   \Carousel\Model\CarouselI18n The current object (for fluent API support)
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
         * @return   \Carousel\Model\CarouselI18n The current object (for fluent API support)
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
         * @return   \Carousel\Model\CarouselI18n The current object (for fluent API support)
         */
        public function setPostscriptum($v)
        {    $this->getCurrentTranslation()->setPostscriptum($v);
    
        return $this;
    }

    // versionable behavior
    
    /**
     * Enforce a new Version of this object upon next save.
     *
     * @return \Carousel\Model\Carousel
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
    
        if (ChildCarouselQuery::isVersioningEnabled() && ($this->isNew() || $this->isModified()) || $this->isDeleted()) {
            return true;
        }
        if (null !== ($object = $this->getCarouselName($con)) && $object->isVersioningNecessary($con)) {
            return true;
        }
    
    
        return false;
    }
    
    /**
     * Creates a version of the current object and saves it.
     *
     * @param   ConnectionInterface $con the connection to use
     *
     * @return  ChildCarouselVersion A version object
     */
    public function addVersion($con = null)
    {
        $this->enforceVersion = false;
    
        $version = new ChildCarouselVersion();
        $version->setId($this->getId());
        $version->setCarouselId($this->getCarouselId());
        $version->setVisible($this->getVisible());
        $version->setFile($this->getFile());
        $version->setPosition($this->getPosition());
        $version->setUrl($this->getUrl());
        $version->setCreatedAt($this->getCreatedAt());
        $version->setUpdatedAt($this->getUpdatedAt());
        $version->setVersion($this->getVersion());
        $version->setVersionCreatedAt($this->getVersionCreatedAt());
        $version->setVersionCreatedBy($this->getVersionCreatedBy());
        $version->setCarousel($this);
        if (($related = $this->getCarouselName($con)) && $related->getVersion()) {
            $version->setCarouselIdVersion($related->getVersion());
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
     * @return  ChildCarousel The current object (for fluent API support)
     */
    public function toVersion($versionNumber, $con = null)
    {
        $version = $this->getOneVersion($versionNumber, $con);
        if (!$version) {
            throw new PropelException(sprintf('No ChildCarousel object found with version %d', $version));
        }
        $this->populateFromVersion($version, $con);
    
        return $this;
    }
    
    /**
     * Sets the properties of the current object to the value they had at a specific version
     *
     * @param ChildCarouselVersion $version The version object to use
     * @param ConnectionInterface   $con the connection to use
     * @param array                 $loadedObjects objects that been loaded in a chain of populateFromVersion calls on referrer or fk objects.
     *
     * @return ChildCarousel The current object (for fluent API support)
     */
    public function populateFromVersion($version, $con = null, &$loadedObjects = array())
    {
        $loadedObjects['ChildCarousel'][$version->getId()][$version->getVersion()] = $this;
        $this->setId($version->getId());
        $this->setCarouselId($version->getCarouselId());
        $this->setVisible($version->getVisible());
        $this->setFile($version->getFile());
        $this->setPosition($version->getPosition());
        $this->setUrl($version->getUrl());
        $this->setCreatedAt($version->getCreatedAt());
        $this->setUpdatedAt($version->getUpdatedAt());
        $this->setVersion($version->getVersion());
        $this->setVersionCreatedAt($version->getVersionCreatedAt());
        $this->setVersionCreatedBy($version->getVersionCreatedBy());
        if ($fkValue = $version->getCarouselId()) {
            if (isset($loadedObjects['ChildCarouselName']) && isset($loadedObjects['ChildCarouselName'][$fkValue]) && isset($loadedObjects['ChildCarouselName'][$fkValue][$version->getCarouselIdVersion()])) {
                $related = $loadedObjects['ChildCarouselName'][$fkValue][$version->getCarouselIdVersion()];
            } else {
                $related = new ChildCarouselName();
                $relatedVersion = ChildCarouselNameVersionQuery::create()
                    ->filterById($fkValue)
                    ->filterByVersion($version->getCarouselIdVersion())
                    ->findOne($con);
                $related->populateFromVersion($relatedVersion, $con, $loadedObjects);
                $related->setNew(false);
            }
            $this->setCarouselName($related);
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
        $v = ChildCarouselVersionQuery::create()
            ->filterByCarousel($this)
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
     * @return  ChildCarouselVersion A version object
     */
    public function getOneVersion($versionNumber, $con = null)
    {
        return ChildCarouselVersionQuery::create()
            ->filterByCarousel($this)
            ->filterByVersion($versionNumber)
            ->findOne($con);
    }
    
    /**
     * Gets all the versions of this object, in incremental order
     *
     * @param   ConnectionInterface $con the connection to use
     *
     * @return  ObjectCollection A list of ChildCarouselVersion objects
     */
    public function getAllVersions($con = null)
    {
        $criteria = new Criteria();
        $criteria->addAscendingOrderByColumn(CarouselVersionTableMap::VERSION);
    
        return $this->getCarouselVersions($criteria, $con);
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
     * @return PropelCollection|array \Carousel\Model\CarouselVersion[] List of \Carousel\Model\CarouselVersion objects
     */
    public function getLastVersions($number = 10, $criteria = null, $con = null)
    {
        $criteria = ChildCarouselVersionQuery::create(null, $criteria);
        $criteria->addDescendingOrderByColumn(CarouselVersionTableMap::VERSION);
        $criteria->limit($number);
    
        return $this->getCarouselVersions($criteria, $con);
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
