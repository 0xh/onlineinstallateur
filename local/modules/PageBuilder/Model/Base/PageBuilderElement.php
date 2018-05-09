<?php

namespace PageBuilder\Model\Base;

use \DateTime;
use \Exception;
use \PDO;
use PageBuilder\Model\PageBuilder as ChildPageBuilder;
use PageBuilder\Model\PageBuilderElement as ChildPageBuilderElement;
use PageBuilder\Model\PageBuilderElementI18n as ChildPageBuilderElementI18n;
use PageBuilder\Model\PageBuilderElementI18nQuery as ChildPageBuilderElementI18nQuery;
use PageBuilder\Model\PageBuilderElementQuery as ChildPageBuilderElementQuery;
use PageBuilder\Model\PageBuilderElementVersion as ChildPageBuilderElementVersion;
use PageBuilder\Model\PageBuilderElementVersionQuery as ChildPageBuilderElementVersionQuery;
use PageBuilder\Model\PageBuilderQuery as ChildPageBuilderQuery;
use PageBuilder\Model\Map\PageBuilderElementTableMap;
use PageBuilder\Model\Map\PageBuilderElementVersionTableMap;
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

abstract class PageBuilderElement implements ActiveRecordInterface 
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\PageBuilder\\Model\\Map\\PageBuilderElementTableMap';


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
     * The value for the page_builder_id field.
     * @var        int
     */
    protected $page_builder_id;

    /**
     * The value for the visible field.
     * @var        int
     */
    protected $visible;

    /**
     * The value for the position field.
     * @var        int
     */
    protected $position;

    /**
     * The value for the template_name field.
     * @var        string
     */
    protected $template_name;

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
     * @var        PageBuilder
     */
    protected $aPageBuilder;

    /**
     * @var        ObjectCollection|ChildPageBuilderElementI18n[] Collection to store aggregation of ChildPageBuilderElementI18n objects.
     */
    protected $collPageBuilderElementI18ns;
    protected $collPageBuilderElementI18nsPartial;

    /**
     * @var        ObjectCollection|ChildPageBuilderElementVersion[] Collection to store aggregation of ChildPageBuilderElementVersion objects.
     */
    protected $collPageBuilderElementVersions;
    protected $collPageBuilderElementVersionsPartial;

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
     * @var        array[ChildPageBuilderElementI18n]
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
    protected $pageBuilderElementI18nsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection
     */
    protected $pageBuilderElementVersionsScheduledForDeletion = null;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see __construct()
     */
    public function applyDefaultValues()
    {
        $this->version = 0;
    }

    /**
     * Initializes internal state of PageBuilder\Model\Base\PageBuilderElement object.
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
     * Compares this with another <code>PageBuilderElement</code> instance.  If
     * <code>obj</code> is an instance of <code>PageBuilderElement</code>, delegates to
     * <code>equals(PageBuilderElement)</code>.  Otherwise, returns <code>false</code>.
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
     * @return PageBuilderElement The current object, for fluid interface
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
     * @return PageBuilderElement The current object, for fluid interface
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
     * Get the [page_builder_id] column value.
     * 
     * @return   int
     */
    public function getPageBuilderId()
    {

        return $this->page_builder_id;
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
     * Get the [template_name] column value.
     * 
     * @return   string
     */
    public function getTemplateName()
    {

        return $this->template_name;
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
     * @return   \PageBuilder\Model\PageBuilderElement The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[PageBuilderElementTableMap::ID] = true;
        }


        return $this;
    } // setId()

    /**
     * Set the value of [page_builder_id] column.
     * 
     * @param      int $v new value
     * @return   \PageBuilder\Model\PageBuilderElement The current object (for fluent API support)
     */
    public function setPageBuilderId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->page_builder_id !== $v) {
            $this->page_builder_id = $v;
            $this->modifiedColumns[PageBuilderElementTableMap::PAGE_BUILDER_ID] = true;
        }

        if ($this->aPageBuilder !== null && $this->aPageBuilder->getId() !== $v) {
            $this->aPageBuilder = null;
        }


        return $this;
    } // setPageBuilderId()

    /**
     * Set the value of [visible] column.
     * 
     * @param      int $v new value
     * @return   \PageBuilder\Model\PageBuilderElement The current object (for fluent API support)
     */
    public function setVisible($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->visible !== $v) {
            $this->visible = $v;
            $this->modifiedColumns[PageBuilderElementTableMap::VISIBLE] = true;
        }


        return $this;
    } // setVisible()

    /**
     * Set the value of [position] column.
     * 
     * @param      int $v new value
     * @return   \PageBuilder\Model\PageBuilderElement The current object (for fluent API support)
     */
    public function setPosition($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->position !== $v) {
            $this->position = $v;
            $this->modifiedColumns[PageBuilderElementTableMap::POSITION] = true;
        }


        return $this;
    } // setPosition()

    /**
     * Set the value of [template_name] column.
     * 
     * @param      string $v new value
     * @return   \PageBuilder\Model\PageBuilderElement The current object (for fluent API support)
     */
    public function setTemplateName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->template_name !== $v) {
            $this->template_name = $v;
            $this->modifiedColumns[PageBuilderElementTableMap::TEMPLATE_NAME] = true;
        }


        return $this;
    } // setTemplateName()

    /**
     * Sets the value of [created_at] column to a normalized version of the date/time value specified.
     * 
     * @param      mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return   \PageBuilder\Model\PageBuilderElement The current object (for fluent API support)
     */
    public function setCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->created_at !== null || $dt !== null) {
            if ($dt !== $this->created_at) {
                $this->created_at = $dt;
                $this->modifiedColumns[PageBuilderElementTableMap::CREATED_AT] = true;
            }
        } // if either are not null


        return $this;
    } // setCreatedAt()

    /**
     * Sets the value of [updated_at] column to a normalized version of the date/time value specified.
     * 
     * @param      mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return   \PageBuilder\Model\PageBuilderElement The current object (for fluent API support)
     */
    public function setUpdatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->updated_at !== null || $dt !== null) {
            if ($dt !== $this->updated_at) {
                $this->updated_at = $dt;
                $this->modifiedColumns[PageBuilderElementTableMap::UPDATED_AT] = true;
            }
        } // if either are not null


        return $this;
    } // setUpdatedAt()

    /**
     * Set the value of [version] column.
     * 
     * @param      int $v new value
     * @return   \PageBuilder\Model\PageBuilderElement The current object (for fluent API support)
     */
    public function setVersion($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->version !== $v) {
            $this->version = $v;
            $this->modifiedColumns[PageBuilderElementTableMap::VERSION] = true;
        }


        return $this;
    } // setVersion()

    /**
     * Sets the value of [version_created_at] column to a normalized version of the date/time value specified.
     * 
     * @param      mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return   \PageBuilder\Model\PageBuilderElement The current object (for fluent API support)
     */
    public function setVersionCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->version_created_at !== null || $dt !== null) {
            if ($dt !== $this->version_created_at) {
                $this->version_created_at = $dt;
                $this->modifiedColumns[PageBuilderElementTableMap::VERSION_CREATED_AT] = true;
            }
        } // if either are not null


        return $this;
    } // setVersionCreatedAt()

    /**
     * Set the value of [version_created_by] column.
     * 
     * @param      string $v new value
     * @return   \PageBuilder\Model\PageBuilderElement The current object (for fluent API support)
     */
    public function setVersionCreatedBy($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->version_created_by !== $v) {
            $this->version_created_by = $v;
            $this->modifiedColumns[PageBuilderElementTableMap::VERSION_CREATED_BY] = true;
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


            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : PageBuilderElementTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : PageBuilderElementTableMap::translateFieldName('PageBuilderId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->page_builder_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : PageBuilderElementTableMap::translateFieldName('Visible', TableMap::TYPE_PHPNAME, $indexType)];
            $this->visible = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : PageBuilderElementTableMap::translateFieldName('Position', TableMap::TYPE_PHPNAME, $indexType)];
            $this->position = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : PageBuilderElementTableMap::translateFieldName('TemplateName', TableMap::TYPE_PHPNAME, $indexType)];
            $this->template_name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : PageBuilderElementTableMap::translateFieldName('CreatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->created_at = (null !== $col) ? PropelDateTime::newInstance($col, null, '\DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : PageBuilderElementTableMap::translateFieldName('UpdatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->updated_at = (null !== $col) ? PropelDateTime::newInstance($col, null, '\DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : PageBuilderElementTableMap::translateFieldName('Version', TableMap::TYPE_PHPNAME, $indexType)];
            $this->version = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : PageBuilderElementTableMap::translateFieldName('VersionCreatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->version_created_at = (null !== $col) ? PropelDateTime::newInstance($col, null, '\DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : PageBuilderElementTableMap::translateFieldName('VersionCreatedBy', TableMap::TYPE_PHPNAME, $indexType)];
            $this->version_created_by = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 10; // 10 = PageBuilderElementTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating \PageBuilder\Model\PageBuilderElement object", 0, $e);
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
        if ($this->aPageBuilder !== null && $this->page_builder_id !== $this->aPageBuilder->getId()) {
            $this->aPageBuilder = null;
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
            $con = Propel::getServiceContainer()->getReadConnection(PageBuilderElementTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildPageBuilderElementQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aPageBuilder = null;
            $this->collPageBuilderElementI18ns = null;

            $this->collPageBuilderElementVersions = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see PageBuilderElement::setDeleted()
     * @see PageBuilderElement::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(PageBuilderElementTableMap::DATABASE_NAME);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = ChildPageBuilderElementQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(PageBuilderElementTableMap::DATABASE_NAME);
        }

        $con->beginTransaction();
        $isInsert = $this->isNew();
        try {
            $ret = $this->preSave($con);
            // versionable behavior
            if ($this->isVersioningNecessary()) {
                $this->setVersion($this->isNew() ? 1 : $this->getLastVersionNumber($con) + 1);
                if (!$this->isColumnModified(PageBuilderElementTableMap::VERSION_CREATED_AT)) {
                    $this->setVersionCreatedAt(time());
                }
                $createVersion = true; // for postSave hook
            }
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
                // timestampable behavior
                if (!$this->isColumnModified(PageBuilderElementTableMap::CREATED_AT)) {
                    $this->setCreatedAt(time());
                }
                if (!$this->isColumnModified(PageBuilderElementTableMap::UPDATED_AT)) {
                    $this->setUpdatedAt(time());
                }
            } else {
                $ret = $ret && $this->preUpdate($con);
                // timestampable behavior
                if ($this->isModified() && !$this->isColumnModified(PageBuilderElementTableMap::UPDATED_AT)) {
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
                PageBuilderElementTableMap::addInstanceToPool($this);
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

            if ($this->aPageBuilder !== null) {
                if ($this->aPageBuilder->isModified() || $this->aPageBuilder->isNew()) {
                    $affectedRows += $this->aPageBuilder->save($con);
                }
                $this->setPageBuilder($this->aPageBuilder);
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

            if ($this->pageBuilderElementI18nsScheduledForDeletion !== null) {
                if (!$this->pageBuilderElementI18nsScheduledForDeletion->isEmpty()) {
                    \PageBuilder\Model\PageBuilderElementI18nQuery::create()
                        ->filterByPrimaryKeys($this->pageBuilderElementI18nsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->pageBuilderElementI18nsScheduledForDeletion = null;
                }
            }

                if ($this->collPageBuilderElementI18ns !== null) {
            foreach ($this->collPageBuilderElementI18ns as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->pageBuilderElementVersionsScheduledForDeletion !== null) {
                if (!$this->pageBuilderElementVersionsScheduledForDeletion->isEmpty()) {
                    \PageBuilder\Model\PageBuilderElementVersionQuery::create()
                        ->filterByPrimaryKeys($this->pageBuilderElementVersionsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->pageBuilderElementVersionsScheduledForDeletion = null;
                }
            }

                if ($this->collPageBuilderElementVersions !== null) {
            foreach ($this->collPageBuilderElementVersions as $referrerFK) {
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

        $this->modifiedColumns[PageBuilderElementTableMap::ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . PageBuilderElementTableMap::ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(PageBuilderElementTableMap::ID)) {
            $modifiedColumns[':p' . $index++]  = 'ID';
        }
        if ($this->isColumnModified(PageBuilderElementTableMap::PAGE_BUILDER_ID)) {
            $modifiedColumns[':p' . $index++]  = 'PAGE_BUILDER_ID';
        }
        if ($this->isColumnModified(PageBuilderElementTableMap::VISIBLE)) {
            $modifiedColumns[':p' . $index++]  = 'VISIBLE';
        }
        if ($this->isColumnModified(PageBuilderElementTableMap::POSITION)) {
            $modifiedColumns[':p' . $index++]  = 'POSITION';
        }
        if ($this->isColumnModified(PageBuilderElementTableMap::TEMPLATE_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'TEMPLATE_NAME';
        }
        if ($this->isColumnModified(PageBuilderElementTableMap::CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'CREATED_AT';
        }
        if ($this->isColumnModified(PageBuilderElementTableMap::UPDATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'UPDATED_AT';
        }
        if ($this->isColumnModified(PageBuilderElementTableMap::VERSION)) {
            $modifiedColumns[':p' . $index++]  = 'VERSION';
        }
        if ($this->isColumnModified(PageBuilderElementTableMap::VERSION_CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'VERSION_CREATED_AT';
        }
        if ($this->isColumnModified(PageBuilderElementTableMap::VERSION_CREATED_BY)) {
            $modifiedColumns[':p' . $index++]  = 'VERSION_CREATED_BY';
        }

        $sql = sprintf(
            'INSERT INTO page_builder_element (%s) VALUES (%s)',
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
                    case 'PAGE_BUILDER_ID':                        
                        $stmt->bindValue($identifier, $this->page_builder_id, PDO::PARAM_INT);
                        break;
                    case 'VISIBLE':                        
                        $stmt->bindValue($identifier, $this->visible, PDO::PARAM_INT);
                        break;
                    case 'POSITION':                        
                        $stmt->bindValue($identifier, $this->position, PDO::PARAM_INT);
                        break;
                    case 'TEMPLATE_NAME':                        
                        $stmt->bindValue($identifier, $this->template_name, PDO::PARAM_STR);
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
        $pos = PageBuilderElementTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getPageBuilderId();
                break;
            case 2:
                return $this->getVisible();
                break;
            case 3:
                return $this->getPosition();
                break;
            case 4:
                return $this->getTemplateName();
                break;
            case 5:
                return $this->getCreatedAt();
                break;
            case 6:
                return $this->getUpdatedAt();
                break;
            case 7:
                return $this->getVersion();
                break;
            case 8:
                return $this->getVersionCreatedAt();
                break;
            case 9:
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
        if (isset($alreadyDumpedObjects['PageBuilderElement'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['PageBuilderElement'][$this->getPrimaryKey()] = true;
        $keys = PageBuilderElementTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getPageBuilderId(),
            $keys[2] => $this->getVisible(),
            $keys[3] => $this->getPosition(),
            $keys[4] => $this->getTemplateName(),
            $keys[5] => $this->getCreatedAt(),
            $keys[6] => $this->getUpdatedAt(),
            $keys[7] => $this->getVersion(),
            $keys[8] => $this->getVersionCreatedAt(),
            $keys[9] => $this->getVersionCreatedBy(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }
        
        if ($includeForeignObjects) {
            if (null !== $this->aPageBuilder) {
                $result['PageBuilder'] = $this->aPageBuilder->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collPageBuilderElementI18ns) {
                $result['PageBuilderElementI18ns'] = $this->collPageBuilderElementI18ns->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collPageBuilderElementVersions) {
                $result['PageBuilderElementVersions'] = $this->collPageBuilderElementVersions->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
        $pos = PageBuilderElementTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

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
                $this->setPageBuilderId($value);
                break;
            case 2:
                $this->setVisible($value);
                break;
            case 3:
                $this->setPosition($value);
                break;
            case 4:
                $this->setTemplateName($value);
                break;
            case 5:
                $this->setCreatedAt($value);
                break;
            case 6:
                $this->setUpdatedAt($value);
                break;
            case 7:
                $this->setVersion($value);
                break;
            case 8:
                $this->setVersionCreatedAt($value);
                break;
            case 9:
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
        $keys = PageBuilderElementTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setPageBuilderId($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setVisible($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setPosition($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setTemplateName($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setCreatedAt($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setUpdatedAt($arr[$keys[6]]);
        if (array_key_exists($keys[7], $arr)) $this->setVersion($arr[$keys[7]]);
        if (array_key_exists($keys[8], $arr)) $this->setVersionCreatedAt($arr[$keys[8]]);
        if (array_key_exists($keys[9], $arr)) $this->setVersionCreatedBy($arr[$keys[9]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(PageBuilderElementTableMap::DATABASE_NAME);

        if ($this->isColumnModified(PageBuilderElementTableMap::ID)) $criteria->add(PageBuilderElementTableMap::ID, $this->id);
        if ($this->isColumnModified(PageBuilderElementTableMap::PAGE_BUILDER_ID)) $criteria->add(PageBuilderElementTableMap::PAGE_BUILDER_ID, $this->page_builder_id);
        if ($this->isColumnModified(PageBuilderElementTableMap::VISIBLE)) $criteria->add(PageBuilderElementTableMap::VISIBLE, $this->visible);
        if ($this->isColumnModified(PageBuilderElementTableMap::POSITION)) $criteria->add(PageBuilderElementTableMap::POSITION, $this->position);
        if ($this->isColumnModified(PageBuilderElementTableMap::TEMPLATE_NAME)) $criteria->add(PageBuilderElementTableMap::TEMPLATE_NAME, $this->template_name);
        if ($this->isColumnModified(PageBuilderElementTableMap::CREATED_AT)) $criteria->add(PageBuilderElementTableMap::CREATED_AT, $this->created_at);
        if ($this->isColumnModified(PageBuilderElementTableMap::UPDATED_AT)) $criteria->add(PageBuilderElementTableMap::UPDATED_AT, $this->updated_at);
        if ($this->isColumnModified(PageBuilderElementTableMap::VERSION)) $criteria->add(PageBuilderElementTableMap::VERSION, $this->version);
        if ($this->isColumnModified(PageBuilderElementTableMap::VERSION_CREATED_AT)) $criteria->add(PageBuilderElementTableMap::VERSION_CREATED_AT, $this->version_created_at);
        if ($this->isColumnModified(PageBuilderElementTableMap::VERSION_CREATED_BY)) $criteria->add(PageBuilderElementTableMap::VERSION_CREATED_BY, $this->version_created_by);

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
        $criteria = new Criteria(PageBuilderElementTableMap::DATABASE_NAME);
        $criteria->add(PageBuilderElementTableMap::ID, $this->id);

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
     * @param      object $copyObj An object of \PageBuilder\Model\PageBuilderElement (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setPageBuilderId($this->getPageBuilderId());
        $copyObj->setVisible($this->getVisible());
        $copyObj->setPosition($this->getPosition());
        $copyObj->setTemplateName($this->getTemplateName());
        $copyObj->setCreatedAt($this->getCreatedAt());
        $copyObj->setUpdatedAt($this->getUpdatedAt());
        $copyObj->setVersion($this->getVersion());
        $copyObj->setVersionCreatedAt($this->getVersionCreatedAt());
        $copyObj->setVersionCreatedBy($this->getVersionCreatedBy());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getPageBuilderElementI18ns() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPageBuilderElementI18n($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getPageBuilderElementVersions() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPageBuilderElementVersion($relObj->copy($deepCopy));
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
     * @return                 \PageBuilder\Model\PageBuilderElement Clone of current object.
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
     * Declares an association between this object and a ChildPageBuilder object.
     *
     * @param                  ChildPageBuilder $v
     * @return                 \PageBuilder\Model\PageBuilderElement The current object (for fluent API support)
     * @throws PropelException
     */
    public function setPageBuilder(ChildPageBuilder $v = null)
    {
        if ($v === null) {
            $this->setPageBuilderId(NULL);
        } else {
            $this->setPageBuilderId($v->getId());
        }

        $this->aPageBuilder = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildPageBuilder object, it will not be re-added.
        if ($v !== null) {
            $v->addPageBuilderElement($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildPageBuilder object
     *
     * @param      ConnectionInterface $con Optional Connection object.
     * @return                 ChildPageBuilder The associated ChildPageBuilder object.
     * @throws PropelException
     */
    public function getPageBuilder(ConnectionInterface $con = null)
    {
        if ($this->aPageBuilder === null && ($this->page_builder_id !== null)) {
            $this->aPageBuilder = ChildPageBuilderQuery::create()->findPk($this->page_builder_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aPageBuilder->addPageBuilderElements($this);
             */
        }

        return $this->aPageBuilder;
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
        if ('PageBuilderElementI18n' == $relationName) {
            return $this->initPageBuilderElementI18ns();
        }
        if ('PageBuilderElementVersion' == $relationName) {
            return $this->initPageBuilderElementVersions();
        }
    }

    /**
     * Clears out the collPageBuilderElementI18ns collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addPageBuilderElementI18ns()
     */
    public function clearPageBuilderElementI18ns()
    {
        $this->collPageBuilderElementI18ns = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collPageBuilderElementI18ns collection loaded partially.
     */
    public function resetPartialPageBuilderElementI18ns($v = true)
    {
        $this->collPageBuilderElementI18nsPartial = $v;
    }

    /**
     * Initializes the collPageBuilderElementI18ns collection.
     *
     * By default this just sets the collPageBuilderElementI18ns collection to an empty array (like clearcollPageBuilderElementI18ns());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initPageBuilderElementI18ns($overrideExisting = true)
    {
        if (null !== $this->collPageBuilderElementI18ns && !$overrideExisting) {
            return;
        }
        $this->collPageBuilderElementI18ns = new ObjectCollection();
        $this->collPageBuilderElementI18ns->setModel('\PageBuilder\Model\PageBuilderElementI18n');
    }

    /**
     * Gets an array of ChildPageBuilderElementI18n objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPageBuilderElement is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return Collection|ChildPageBuilderElementI18n[] List of ChildPageBuilderElementI18n objects
     * @throws PropelException
     */
    public function getPageBuilderElementI18ns($criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collPageBuilderElementI18nsPartial && !$this->isNew();
        if (null === $this->collPageBuilderElementI18ns || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collPageBuilderElementI18ns) {
                // return empty collection
                $this->initPageBuilderElementI18ns();
            } else {
                $collPageBuilderElementI18ns = ChildPageBuilderElementI18nQuery::create(null, $criteria)
                    ->filterByPageBuilderElement($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collPageBuilderElementI18nsPartial && count($collPageBuilderElementI18ns)) {
                        $this->initPageBuilderElementI18ns(false);

                        foreach ($collPageBuilderElementI18ns as $obj) {
                            if (false == $this->collPageBuilderElementI18ns->contains($obj)) {
                                $this->collPageBuilderElementI18ns->append($obj);
                            }
                        }

                        $this->collPageBuilderElementI18nsPartial = true;
                    }

                    reset($collPageBuilderElementI18ns);

                    return $collPageBuilderElementI18ns;
                }

                if ($partial && $this->collPageBuilderElementI18ns) {
                    foreach ($this->collPageBuilderElementI18ns as $obj) {
                        if ($obj->isNew()) {
                            $collPageBuilderElementI18ns[] = $obj;
                        }
                    }
                }

                $this->collPageBuilderElementI18ns = $collPageBuilderElementI18ns;
                $this->collPageBuilderElementI18nsPartial = false;
            }
        }

        return $this->collPageBuilderElementI18ns;
    }

    /**
     * Sets a collection of PageBuilderElementI18n objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $pageBuilderElementI18ns A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return   ChildPageBuilderElement The current object (for fluent API support)
     */
    public function setPageBuilderElementI18ns(Collection $pageBuilderElementI18ns, ConnectionInterface $con = null)
    {
        $pageBuilderElementI18nsToDelete = $this->getPageBuilderElementI18ns(new Criteria(), $con)->diff($pageBuilderElementI18ns);

        
        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->pageBuilderElementI18nsScheduledForDeletion = clone $pageBuilderElementI18nsToDelete;

        foreach ($pageBuilderElementI18nsToDelete as $pageBuilderElementI18nRemoved) {
            $pageBuilderElementI18nRemoved->setPageBuilderElement(null);
        }

        $this->collPageBuilderElementI18ns = null;
        foreach ($pageBuilderElementI18ns as $pageBuilderElementI18n) {
            $this->addPageBuilderElementI18n($pageBuilderElementI18n);
        }

        $this->collPageBuilderElementI18ns = $pageBuilderElementI18ns;
        $this->collPageBuilderElementI18nsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related PageBuilderElementI18n objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related PageBuilderElementI18n objects.
     * @throws PropelException
     */
    public function countPageBuilderElementI18ns(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collPageBuilderElementI18nsPartial && !$this->isNew();
        if (null === $this->collPageBuilderElementI18ns || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collPageBuilderElementI18ns) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getPageBuilderElementI18ns());
            }

            $query = ChildPageBuilderElementI18nQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByPageBuilderElement($this)
                ->count($con);
        }

        return count($this->collPageBuilderElementI18ns);
    }

    /**
     * Method called to associate a ChildPageBuilderElementI18n object to this object
     * through the ChildPageBuilderElementI18n foreign key attribute.
     *
     * @param    ChildPageBuilderElementI18n $l ChildPageBuilderElementI18n
     * @return   \PageBuilder\Model\PageBuilderElement The current object (for fluent API support)
     */
    public function addPageBuilderElementI18n(ChildPageBuilderElementI18n $l)
    {
        if ($l && $locale = $l->getLocale()) {
            $this->setLocale($locale);
            $this->currentTranslations[$locale] = $l;
        }
        if ($this->collPageBuilderElementI18ns === null) {
            $this->initPageBuilderElementI18ns();
            $this->collPageBuilderElementI18nsPartial = true;
        }

        if (!in_array($l, $this->collPageBuilderElementI18ns->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddPageBuilderElementI18n($l);
        }

        return $this;
    }

    /**
     * @param PageBuilderElementI18n $pageBuilderElementI18n The pageBuilderElementI18n object to add.
     */
    protected function doAddPageBuilderElementI18n($pageBuilderElementI18n)
    {
        $this->collPageBuilderElementI18ns[]= $pageBuilderElementI18n;
        $pageBuilderElementI18n->setPageBuilderElement($this);
    }

    /**
     * @param  PageBuilderElementI18n $pageBuilderElementI18n The pageBuilderElementI18n object to remove.
     * @return ChildPageBuilderElement The current object (for fluent API support)
     */
    public function removePageBuilderElementI18n($pageBuilderElementI18n)
    {
        if ($this->getPageBuilderElementI18ns()->contains($pageBuilderElementI18n)) {
            $this->collPageBuilderElementI18ns->remove($this->collPageBuilderElementI18ns->search($pageBuilderElementI18n));
            if (null === $this->pageBuilderElementI18nsScheduledForDeletion) {
                $this->pageBuilderElementI18nsScheduledForDeletion = clone $this->collPageBuilderElementI18ns;
                $this->pageBuilderElementI18nsScheduledForDeletion->clear();
            }
            $this->pageBuilderElementI18nsScheduledForDeletion[]= clone $pageBuilderElementI18n;
            $pageBuilderElementI18n->setPageBuilderElement(null);
        }

        return $this;
    }

    /**
     * Clears out the collPageBuilderElementVersions collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addPageBuilderElementVersions()
     */
    public function clearPageBuilderElementVersions()
    {
        $this->collPageBuilderElementVersions = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collPageBuilderElementVersions collection loaded partially.
     */
    public function resetPartialPageBuilderElementVersions($v = true)
    {
        $this->collPageBuilderElementVersionsPartial = $v;
    }

    /**
     * Initializes the collPageBuilderElementVersions collection.
     *
     * By default this just sets the collPageBuilderElementVersions collection to an empty array (like clearcollPageBuilderElementVersions());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initPageBuilderElementVersions($overrideExisting = true)
    {
        if (null !== $this->collPageBuilderElementVersions && !$overrideExisting) {
            return;
        }
        $this->collPageBuilderElementVersions = new ObjectCollection();
        $this->collPageBuilderElementVersions->setModel('\PageBuilder\Model\PageBuilderElementVersion');
    }

    /**
     * Gets an array of ChildPageBuilderElementVersion objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPageBuilderElement is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return Collection|ChildPageBuilderElementVersion[] List of ChildPageBuilderElementVersion objects
     * @throws PropelException
     */
    public function getPageBuilderElementVersions($criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collPageBuilderElementVersionsPartial && !$this->isNew();
        if (null === $this->collPageBuilderElementVersions || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collPageBuilderElementVersions) {
                // return empty collection
                $this->initPageBuilderElementVersions();
            } else {
                $collPageBuilderElementVersions = ChildPageBuilderElementVersionQuery::create(null, $criteria)
                    ->filterByPageBuilderElement($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collPageBuilderElementVersionsPartial && count($collPageBuilderElementVersions)) {
                        $this->initPageBuilderElementVersions(false);

                        foreach ($collPageBuilderElementVersions as $obj) {
                            if (false == $this->collPageBuilderElementVersions->contains($obj)) {
                                $this->collPageBuilderElementVersions->append($obj);
                            }
                        }

                        $this->collPageBuilderElementVersionsPartial = true;
                    }

                    reset($collPageBuilderElementVersions);

                    return $collPageBuilderElementVersions;
                }

                if ($partial && $this->collPageBuilderElementVersions) {
                    foreach ($this->collPageBuilderElementVersions as $obj) {
                        if ($obj->isNew()) {
                            $collPageBuilderElementVersions[] = $obj;
                        }
                    }
                }

                $this->collPageBuilderElementVersions = $collPageBuilderElementVersions;
                $this->collPageBuilderElementVersionsPartial = false;
            }
        }

        return $this->collPageBuilderElementVersions;
    }

    /**
     * Sets a collection of PageBuilderElementVersion objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $pageBuilderElementVersions A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return   ChildPageBuilderElement The current object (for fluent API support)
     */
    public function setPageBuilderElementVersions(Collection $pageBuilderElementVersions, ConnectionInterface $con = null)
    {
        $pageBuilderElementVersionsToDelete = $this->getPageBuilderElementVersions(new Criteria(), $con)->diff($pageBuilderElementVersions);

        
        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->pageBuilderElementVersionsScheduledForDeletion = clone $pageBuilderElementVersionsToDelete;

        foreach ($pageBuilderElementVersionsToDelete as $pageBuilderElementVersionRemoved) {
            $pageBuilderElementVersionRemoved->setPageBuilderElement(null);
        }

        $this->collPageBuilderElementVersions = null;
        foreach ($pageBuilderElementVersions as $pageBuilderElementVersion) {
            $this->addPageBuilderElementVersion($pageBuilderElementVersion);
        }

        $this->collPageBuilderElementVersions = $pageBuilderElementVersions;
        $this->collPageBuilderElementVersionsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related PageBuilderElementVersion objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related PageBuilderElementVersion objects.
     * @throws PropelException
     */
    public function countPageBuilderElementVersions(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collPageBuilderElementVersionsPartial && !$this->isNew();
        if (null === $this->collPageBuilderElementVersions || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collPageBuilderElementVersions) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getPageBuilderElementVersions());
            }

            $query = ChildPageBuilderElementVersionQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByPageBuilderElement($this)
                ->count($con);
        }

        return count($this->collPageBuilderElementVersions);
    }

    /**
     * Method called to associate a ChildPageBuilderElementVersion object to this object
     * through the ChildPageBuilderElementVersion foreign key attribute.
     *
     * @param    ChildPageBuilderElementVersion $l ChildPageBuilderElementVersion
     * @return   \PageBuilder\Model\PageBuilderElement The current object (for fluent API support)
     */
    public function addPageBuilderElementVersion(ChildPageBuilderElementVersion $l)
    {
        if ($this->collPageBuilderElementVersions === null) {
            $this->initPageBuilderElementVersions();
            $this->collPageBuilderElementVersionsPartial = true;
        }

        if (!in_array($l, $this->collPageBuilderElementVersions->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddPageBuilderElementVersion($l);
        }

        return $this;
    }

    /**
     * @param PageBuilderElementVersion $pageBuilderElementVersion The pageBuilderElementVersion object to add.
     */
    protected function doAddPageBuilderElementVersion($pageBuilderElementVersion)
    {
        $this->collPageBuilderElementVersions[]= $pageBuilderElementVersion;
        $pageBuilderElementVersion->setPageBuilderElement($this);
    }

    /**
     * @param  PageBuilderElementVersion $pageBuilderElementVersion The pageBuilderElementVersion object to remove.
     * @return ChildPageBuilderElement The current object (for fluent API support)
     */
    public function removePageBuilderElementVersion($pageBuilderElementVersion)
    {
        if ($this->getPageBuilderElementVersions()->contains($pageBuilderElementVersion)) {
            $this->collPageBuilderElementVersions->remove($this->collPageBuilderElementVersions->search($pageBuilderElementVersion));
            if (null === $this->pageBuilderElementVersionsScheduledForDeletion) {
                $this->pageBuilderElementVersionsScheduledForDeletion = clone $this->collPageBuilderElementVersions;
                $this->pageBuilderElementVersionsScheduledForDeletion->clear();
            }
            $this->pageBuilderElementVersionsScheduledForDeletion[]= clone $pageBuilderElementVersion;
            $pageBuilderElementVersion->setPageBuilderElement(null);
        }

        return $this;
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->id = null;
        $this->page_builder_id = null;
        $this->visible = null;
        $this->position = null;
        $this->template_name = null;
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
            if ($this->collPageBuilderElementI18ns) {
                foreach ($this->collPageBuilderElementI18ns as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collPageBuilderElementVersions) {
                foreach ($this->collPageBuilderElementVersions as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        // i18n behavior
        $this->currentLocale = 'en_US';
        $this->currentTranslations = null;

        $this->collPageBuilderElementI18ns = null;
        $this->collPageBuilderElementVersions = null;
        $this->aPageBuilder = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(PageBuilderElementTableMap::DEFAULT_STRING_FORMAT);
    }

    // timestampable behavior
    
    /**
     * Mark the current object so that the update date doesn't get updated during next save
     *
     * @return     ChildPageBuilderElement The current object (for fluent API support)
     */
    public function keepUpdateDateUnchanged()
    {
        $this->modifiedColumns[PageBuilderElementTableMap::UPDATED_AT] = true;
    
        return $this;
    }

    // i18n behavior
    
    /**
     * Sets the locale for translations
     *
     * @param     string $locale Locale to use for the translation, e.g. 'fr_FR'
     *
     * @return    ChildPageBuilderElement The current object (for fluent API support)
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
     * @return ChildPageBuilderElementI18n */
    public function getTranslation($locale = 'en_US', ConnectionInterface $con = null)
    {
        if (!isset($this->currentTranslations[$locale])) {
            if (null !== $this->collPageBuilderElementI18ns) {
                foreach ($this->collPageBuilderElementI18ns as $translation) {
                    if ($translation->getLocale() == $locale) {
                        $this->currentTranslations[$locale] = $translation;
    
                        return $translation;
                    }
                }
            }
            if ($this->isNew()) {
                $translation = new ChildPageBuilderElementI18n();
                $translation->setLocale($locale);
            } else {
                $translation = ChildPageBuilderElementI18nQuery::create()
                    ->filterByPrimaryKey(array($this->getPrimaryKey(), $locale))
                    ->findOneOrCreate($con);
                $this->currentTranslations[$locale] = $translation;
            }
            $this->addPageBuilderElementI18n($translation);
        }
    
        return $this->currentTranslations[$locale];
    }
    
    /**
     * Remove the translation for a given locale
     *
     * @param     string $locale Locale to use for the translation, e.g. 'fr_FR'
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return    ChildPageBuilderElement The current object (for fluent API support)
     */
    public function removeTranslation($locale = 'en_US', ConnectionInterface $con = null)
    {
        if (!$this->isNew()) {
            ChildPageBuilderElementI18nQuery::create()
                ->filterByPrimaryKey(array($this->getPrimaryKey(), $locale))
                ->delete($con);
        }
        if (isset($this->currentTranslations[$locale])) {
            unset($this->currentTranslations[$locale]);
        }
        foreach ($this->collPageBuilderElementI18ns as $key => $translation) {
            if ($translation->getLocale() == $locale) {
                unset($this->collPageBuilderElementI18ns[$key]);
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
     * @return ChildPageBuilderElementI18n */
    public function getCurrentTranslation(ConnectionInterface $con = null)
    {
        return $this->getTranslation($this->getLocale(), $con);
    }
    
    
        /**
         * Get the [variables] column value.
         * 
         * @return   string
         */
        public function getVariables()
        {
        return $this->getCurrentTranslation()->getVariables();
    }
    
    
        /**
         * Set the value of [variables] column.
         * 
         * @param      string $v new value
         * @return   \PageBuilder\Model\PageBuilderElementI18n The current object (for fluent API support)
         */
        public function setVariables($v)
        {    $this->getCurrentTranslation()->setVariables($v);
    
        return $this;
    }

    // versionable behavior
    
    /**
     * Enforce a new Version of this object upon next save.
     *
     * @return \PageBuilder\Model\PageBuilderElement
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
    
        if (ChildPageBuilderElementQuery::isVersioningEnabled() && ($this->isNew() || $this->isModified()) || $this->isDeleted()) {
            return true;
        }
    
        return false;
    }
    
    /**
     * Creates a version of the current object and saves it.
     *
     * @param   ConnectionInterface $con the connection to use
     *
     * @return  ChildPageBuilderElementVersion A version object
     */
    public function addVersion($con = null)
    {
        $this->enforceVersion = false;
    
        $version = new ChildPageBuilderElementVersion();
        $version->setId($this->getId());
        $version->setPageBuilderId($this->getPageBuilderId());
        $version->setVisible($this->getVisible());
        $version->setPosition($this->getPosition());
        $version->setTemplateName($this->getTemplateName());
        $version->setCreatedAt($this->getCreatedAt());
        $version->setUpdatedAt($this->getUpdatedAt());
        $version->setVersion($this->getVersion());
        $version->setVersionCreatedAt($this->getVersionCreatedAt());
        $version->setVersionCreatedBy($this->getVersionCreatedBy());
        $version->setPageBuilderElement($this);
        $version->save($con);
    
        return $version;
    }
    
    /**
     * Sets the properties of the current object to the value they had at a specific version
     *
     * @param   integer $versionNumber The version number to read
     * @param   ConnectionInterface $con The connection to use
     *
     * @return  ChildPageBuilderElement The current object (for fluent API support)
     */
    public function toVersion($versionNumber, $con = null)
    {
        $version = $this->getOneVersion($versionNumber, $con);
        if (!$version) {
            throw new PropelException(sprintf('No ChildPageBuilderElement object found with version %d', $version));
        }
        $this->populateFromVersion($version, $con);
    
        return $this;
    }
    
    /**
     * Sets the properties of the current object to the value they had at a specific version
     *
     * @param ChildPageBuilderElementVersion $version The version object to use
     * @param ConnectionInterface   $con the connection to use
     * @param array                 $loadedObjects objects that been loaded in a chain of populateFromVersion calls on referrer or fk objects.
     *
     * @return ChildPageBuilderElement The current object (for fluent API support)
     */
    public function populateFromVersion($version, $con = null, &$loadedObjects = array())
    {
        $loadedObjects['ChildPageBuilderElement'][$version->getId()][$version->getVersion()] = $this;
        $this->setId($version->getId());
        $this->setPageBuilderId($version->getPageBuilderId());
        $this->setVisible($version->getVisible());
        $this->setPosition($version->getPosition());
        $this->setTemplateName($version->getTemplateName());
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
        $v = ChildPageBuilderElementVersionQuery::create()
            ->filterByPageBuilderElement($this)
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
     * @return  ChildPageBuilderElementVersion A version object
     */
    public function getOneVersion($versionNumber, $con = null)
    {
        return ChildPageBuilderElementVersionQuery::create()
            ->filterByPageBuilderElement($this)
            ->filterByVersion($versionNumber)
            ->findOne($con);
    }
    
    /**
     * Gets all the versions of this object, in incremental order
     *
     * @param   ConnectionInterface $con the connection to use
     *
     * @return  ObjectCollection A list of ChildPageBuilderElementVersion objects
     */
    public function getAllVersions($con = null)
    {
        $criteria = new Criteria();
        $criteria->addAscendingOrderByColumn(PageBuilderElementVersionTableMap::VERSION);
    
        return $this->getPageBuilderElementVersions($criteria, $con);
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
     * @return PropelCollection|array \PageBuilder\Model\PageBuilderElementVersion[] List of \PageBuilder\Model\PageBuilderElementVersion objects
     */
    public function getLastVersions($number = 10, $criteria = null, $con = null)
    {
        $criteria = ChildPageBuilderElementVersionQuery::create(null, $criteria);
        $criteria->addDescendingOrderByColumn(PageBuilderElementVersionTableMap::VERSION);
        $criteria->limit($number);
    
        return $this->getPageBuilderElementVersions($criteria, $con);
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
