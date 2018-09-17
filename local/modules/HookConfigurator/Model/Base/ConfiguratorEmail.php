<?php

namespace HookConfigurator\Model\Base;

use \Exception;
use \PDO;
use HookConfigurator\Model\ConfiguratorEmailQuery as ChildConfiguratorEmailQuery;
use HookConfigurator\Model\Map\ConfiguratorEmailTableMap;
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

abstract class ConfiguratorEmail implements ActiveRecordInterface 
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\HookConfigurator\\Model\\Map\\ConfiguratorEmailTableMap';


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
     * The value for the with_search_result field.
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $with_search_result;

    /**
     * The value for the id_category_search field.
     * Note: this column has a database default value of: 1
     * @var        int
     */
    protected $id_category_search;

    /**
     * The value for the visible_form_contact field.
     * Note: this column has a database default value of: 1
     * @var        int
     */
    protected $visible_form_contact;

    /**
     * The value for the required_vorname field.
     * Note: this column has a database default value of: 1
     * @var        int
     */
    protected $required_vorname;

    /**
     * The value for the visible_vorname field.
     * Note: this column has a database default value of: 1
     * @var        int
     */
    protected $visible_vorname;

    /**
     * The value for the required_nachname field.
     * Note: this column has a database default value of: 1
     * @var        int
     */
    protected $required_nachname;

    /**
     * The value for the visible_nachname field.
     * Note: this column has a database default value of: 1
     * @var        int
     */
    protected $visible_nachname;

    /**
     * The value for the required_str field.
     * Note: this column has a database default value of: 1
     * @var        int
     */
    protected $required_str;

    /**
     * The value for the visible_str field.
     * Note: this column has a database default value of: 1
     * @var        int
     */
    protected $visible_str;

    /**
     * The value for the required_plz field.
     * Note: this column has a database default value of: 1
     * @var        int
     */
    protected $required_plz;

    /**
     * The value for the visible_plz field.
     * Note: this column has a database default value of: 1
     * @var        int
     */
    protected $visible_plz;

    /**
     * The value for the required_ort field.
     * Note: this column has a database default value of: 1
     * @var        int
     */
    protected $required_ort;

    /**
     * The value for the visible_ort field.
     * Note: this column has a database default value of: 1
     * @var        int
     */
    protected $visible_ort;

    /**
     * The value for the required_telefon field.
     * Note: this column has a database default value of: 1
     * @var        int
     */
    protected $required_telefon;

    /**
     * The value for the visible_telefon field.
     * Note: this column has a database default value of: 1
     * @var        int
     */
    protected $visible_telefon;

    /**
     * The value for the required_email field.
     * Note: this column has a database default value of: 1
     * @var        int
     */
    protected $required_email;

    /**
     * The value for the visible_email field.
     * Note: this column has a database default value of: 1
     * @var        int
     */
    protected $visible_email;

    /**
     * The value for the required_terms field.
     * Note: this column has a database default value of: 1
     * @var        int
     */
    protected $required_terms;

    /**
     * The value for the visible_terms field.
     * Note: this column has a database default value of: 1
     * @var        int
     */
    protected $visible_terms;

    /**
     * The value for the required_send field.
     * Note: this column has a database default value of: 1
     * @var        int
     */
    protected $required_send;

    /**
     * The value for the visible_send field.
     * Note: this column has a database default value of: 1
     * @var        int
     */
    protected $visible_send;

    /**
     * The value for the send_email field.
     * Note: this column has a database default value of: 1
     * @var        int
     */
    protected $send_email;

    /**
     * The value for the template_email_name_customer field.
     * @var        string
     */
    protected $template_email_name_customer;

    /**
     * The value for the template_email_name_admin field.
     * @var        string
     */
    protected $template_email_name_admin;

    /**
     * The value for the template_redirect_search field.
     * @var        string
     */
    protected $template_redirect_search;

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
        $this->with_search_result = 0;
        $this->id_category_search = 1;
        $this->visible_form_contact = 1;
        $this->required_vorname = 1;
        $this->visible_vorname = 1;
        $this->required_nachname = 1;
        $this->visible_nachname = 1;
        $this->required_str = 1;
        $this->visible_str = 1;
        $this->required_plz = 1;
        $this->visible_plz = 1;
        $this->required_ort = 1;
        $this->visible_ort = 1;
        $this->required_telefon = 1;
        $this->visible_telefon = 1;
        $this->required_email = 1;
        $this->visible_email = 1;
        $this->required_terms = 1;
        $this->visible_terms = 1;
        $this->required_send = 1;
        $this->visible_send = 1;
        $this->send_email = 1;
    }

    /**
     * Initializes internal state of HookConfigurator\Model\Base\ConfiguratorEmail object.
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
     * Compares this with another <code>ConfiguratorEmail</code> instance.  If
     * <code>obj</code> is an instance of <code>ConfiguratorEmail</code>, delegates to
     * <code>equals(ConfiguratorEmail)</code>.  Otherwise, returns <code>false</code>.
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
     * @return ConfiguratorEmail The current object, for fluid interface
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
     * @return ConfiguratorEmail The current object, for fluid interface
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
     * Get the [with_search_result] column value.
     * 
     * @return   int
     */
    public function getWithSearchResult()
    {

        return $this->with_search_result;
    }

    /**
     * Get the [id_category_search] column value.
     * 
     * @return   int
     */
    public function getIdCategorySearch()
    {

        return $this->id_category_search;
    }

    /**
     * Get the [visible_form_contact] column value.
     * 
     * @return   int
     */
    public function getVisibleFormContact()
    {

        return $this->visible_form_contact;
    }

    /**
     * Get the [required_vorname] column value.
     * 
     * @return   int
     */
    public function getRequiredVorname()
    {

        return $this->required_vorname;
    }

    /**
     * Get the [visible_vorname] column value.
     * 
     * @return   int
     */
    public function getVisibleVorname()
    {

        return $this->visible_vorname;
    }

    /**
     * Get the [required_nachname] column value.
     * 
     * @return   int
     */
    public function getRequiredNachname()
    {

        return $this->required_nachname;
    }

    /**
     * Get the [visible_nachname] column value.
     * 
     * @return   int
     */
    public function getVisibleNachname()
    {

        return $this->visible_nachname;
    }

    /**
     * Get the [required_str] column value.
     * 
     * @return   int
     */
    public function getRequiredStr()
    {

        return $this->required_str;
    }

    /**
     * Get the [visible_str] column value.
     * 
     * @return   int
     */
    public function getVisibleStr()
    {

        return $this->visible_str;
    }

    /**
     * Get the [required_plz] column value.
     * 
     * @return   int
     */
    public function getRequiredPlz()
    {

        return $this->required_plz;
    }

    /**
     * Get the [visible_plz] column value.
     * 
     * @return   int
     */
    public function getVisiblePlz()
    {

        return $this->visible_plz;
    }

    /**
     * Get the [required_ort] column value.
     * 
     * @return   int
     */
    public function getRequiredOrt()
    {

        return $this->required_ort;
    }

    /**
     * Get the [visible_ort] column value.
     * 
     * @return   int
     */
    public function getVisibleOrt()
    {

        return $this->visible_ort;
    }

    /**
     * Get the [required_telefon] column value.
     * 
     * @return   int
     */
    public function getRequiredTelefon()
    {

        return $this->required_telefon;
    }

    /**
     * Get the [visible_telefon] column value.
     * 
     * @return   int
     */
    public function getVisibleTelefon()
    {

        return $this->visible_telefon;
    }

    /**
     * Get the [required_email] column value.
     * 
     * @return   int
     */
    public function getRequiredEmail()
    {

        return $this->required_email;
    }

    /**
     * Get the [visible_email] column value.
     * 
     * @return   int
     */
    public function getVisibleEmail()
    {

        return $this->visible_email;
    }

    /**
     * Get the [required_terms] column value.
     * 
     * @return   int
     */
    public function getRequiredTerms()
    {

        return $this->required_terms;
    }

    /**
     * Get the [visible_terms] column value.
     * 
     * @return   int
     */
    public function getVisibleTerms()
    {

        return $this->visible_terms;
    }

    /**
     * Get the [required_send] column value.
     * 
     * @return   int
     */
    public function getRequiredSend()
    {

        return $this->required_send;
    }

    /**
     * Get the [visible_send] column value.
     * 
     * @return   int
     */
    public function getVisibleSend()
    {

        return $this->visible_send;
    }

    /**
     * Get the [send_email] column value.
     * 
     * @return   int
     */
    public function getSendEmail()
    {

        return $this->send_email;
    }

    /**
     * Get the [template_email_name_customer] column value.
     * 
     * @return   string
     */
    public function getTemplateEmailNameCustomer()
    {

        return $this->template_email_name_customer;
    }

    /**
     * Get the [template_email_name_admin] column value.
     * 
     * @return   string
     */
    public function getTemplateEmailNameAdmin()
    {

        return $this->template_email_name_admin;
    }

    /**
     * Get the [template_redirect_search] column value.
     * 
     * @return   string
     */
    public function getTemplateRedirectSearch()
    {

        return $this->template_redirect_search;
    }

    /**
     * Set the value of [id] column.
     * 
     * @param      int $v new value
     * @return   \HookConfigurator\Model\ConfiguratorEmail The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[ConfiguratorEmailTableMap::ID] = true;
        }


        return $this;
    } // setId()

    /**
     * Set the value of [with_search_result] column.
     * 
     * @param      int $v new value
     * @return   \HookConfigurator\Model\ConfiguratorEmail The current object (for fluent API support)
     */
    public function setWithSearchResult($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->with_search_result !== $v) {
            $this->with_search_result = $v;
            $this->modifiedColumns[ConfiguratorEmailTableMap::WITH_SEARCH_RESULT] = true;
        }


        return $this;
    } // setWithSearchResult()

    /**
     * Set the value of [id_category_search] column.
     * 
     * @param      int $v new value
     * @return   \HookConfigurator\Model\ConfiguratorEmail The current object (for fluent API support)
     */
    public function setIdCategorySearch($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id_category_search !== $v) {
            $this->id_category_search = $v;
            $this->modifiedColumns[ConfiguratorEmailTableMap::ID_CATEGORY_SEARCH] = true;
        }


        return $this;
    } // setIdCategorySearch()

    /**
     * Set the value of [visible_form_contact] column.
     * 
     * @param      int $v new value
     * @return   \HookConfigurator\Model\ConfiguratorEmail The current object (for fluent API support)
     */
    public function setVisibleFormContact($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->visible_form_contact !== $v) {
            $this->visible_form_contact = $v;
            $this->modifiedColumns[ConfiguratorEmailTableMap::VISIBLE_FORM_CONTACT] = true;
        }


        return $this;
    } // setVisibleFormContact()

    /**
     * Set the value of [required_vorname] column.
     * 
     * @param      int $v new value
     * @return   \HookConfigurator\Model\ConfiguratorEmail The current object (for fluent API support)
     */
    public function setRequiredVorname($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->required_vorname !== $v) {
            $this->required_vorname = $v;
            $this->modifiedColumns[ConfiguratorEmailTableMap::REQUIRED_VORNAME] = true;
        }


        return $this;
    } // setRequiredVorname()

    /**
     * Set the value of [visible_vorname] column.
     * 
     * @param      int $v new value
     * @return   \HookConfigurator\Model\ConfiguratorEmail The current object (for fluent API support)
     */
    public function setVisibleVorname($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->visible_vorname !== $v) {
            $this->visible_vorname = $v;
            $this->modifiedColumns[ConfiguratorEmailTableMap::VISIBLE_VORNAME] = true;
        }


        return $this;
    } // setVisibleVorname()

    /**
     * Set the value of [required_nachname] column.
     * 
     * @param      int $v new value
     * @return   \HookConfigurator\Model\ConfiguratorEmail The current object (for fluent API support)
     */
    public function setRequiredNachname($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->required_nachname !== $v) {
            $this->required_nachname = $v;
            $this->modifiedColumns[ConfiguratorEmailTableMap::REQUIRED_NACHNAME] = true;
        }


        return $this;
    } // setRequiredNachname()

    /**
     * Set the value of [visible_nachname] column.
     * 
     * @param      int $v new value
     * @return   \HookConfigurator\Model\ConfiguratorEmail The current object (for fluent API support)
     */
    public function setVisibleNachname($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->visible_nachname !== $v) {
            $this->visible_nachname = $v;
            $this->modifiedColumns[ConfiguratorEmailTableMap::VISIBLE_NACHNAME] = true;
        }


        return $this;
    } // setVisibleNachname()

    /**
     * Set the value of [required_str] column.
     * 
     * @param      int $v new value
     * @return   \HookConfigurator\Model\ConfiguratorEmail The current object (for fluent API support)
     */
    public function setRequiredStr($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->required_str !== $v) {
            $this->required_str = $v;
            $this->modifiedColumns[ConfiguratorEmailTableMap::REQUIRED_STR] = true;
        }


        return $this;
    } // setRequiredStr()

    /**
     * Set the value of [visible_str] column.
     * 
     * @param      int $v new value
     * @return   \HookConfigurator\Model\ConfiguratorEmail The current object (for fluent API support)
     */
    public function setVisibleStr($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->visible_str !== $v) {
            $this->visible_str = $v;
            $this->modifiedColumns[ConfiguratorEmailTableMap::VISIBLE_STR] = true;
        }


        return $this;
    } // setVisibleStr()

    /**
     * Set the value of [required_plz] column.
     * 
     * @param      int $v new value
     * @return   \HookConfigurator\Model\ConfiguratorEmail The current object (for fluent API support)
     */
    public function setRequiredPlz($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->required_plz !== $v) {
            $this->required_plz = $v;
            $this->modifiedColumns[ConfiguratorEmailTableMap::REQUIRED_PLZ] = true;
        }


        return $this;
    } // setRequiredPlz()

    /**
     * Set the value of [visible_plz] column.
     * 
     * @param      int $v new value
     * @return   \HookConfigurator\Model\ConfiguratorEmail The current object (for fluent API support)
     */
    public function setVisiblePlz($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->visible_plz !== $v) {
            $this->visible_plz = $v;
            $this->modifiedColumns[ConfiguratorEmailTableMap::VISIBLE_PLZ] = true;
        }


        return $this;
    } // setVisiblePlz()

    /**
     * Set the value of [required_ort] column.
     * 
     * @param      int $v new value
     * @return   \HookConfigurator\Model\ConfiguratorEmail The current object (for fluent API support)
     */
    public function setRequiredOrt($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->required_ort !== $v) {
            $this->required_ort = $v;
            $this->modifiedColumns[ConfiguratorEmailTableMap::REQUIRED_ORT] = true;
        }


        return $this;
    } // setRequiredOrt()

    /**
     * Set the value of [visible_ort] column.
     * 
     * @param      int $v new value
     * @return   \HookConfigurator\Model\ConfiguratorEmail The current object (for fluent API support)
     */
    public function setVisibleOrt($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->visible_ort !== $v) {
            $this->visible_ort = $v;
            $this->modifiedColumns[ConfiguratorEmailTableMap::VISIBLE_ORT] = true;
        }


        return $this;
    } // setVisibleOrt()

    /**
     * Set the value of [required_telefon] column.
     * 
     * @param      int $v new value
     * @return   \HookConfigurator\Model\ConfiguratorEmail The current object (for fluent API support)
     */
    public function setRequiredTelefon($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->required_telefon !== $v) {
            $this->required_telefon = $v;
            $this->modifiedColumns[ConfiguratorEmailTableMap::REQUIRED_TELEFON] = true;
        }


        return $this;
    } // setRequiredTelefon()

    /**
     * Set the value of [visible_telefon] column.
     * 
     * @param      int $v new value
     * @return   \HookConfigurator\Model\ConfiguratorEmail The current object (for fluent API support)
     */
    public function setVisibleTelefon($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->visible_telefon !== $v) {
            $this->visible_telefon = $v;
            $this->modifiedColumns[ConfiguratorEmailTableMap::VISIBLE_TELEFON] = true;
        }


        return $this;
    } // setVisibleTelefon()

    /**
     * Set the value of [required_email] column.
     * 
     * @param      int $v new value
     * @return   \HookConfigurator\Model\ConfiguratorEmail The current object (for fluent API support)
     */
    public function setRequiredEmail($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->required_email !== $v) {
            $this->required_email = $v;
            $this->modifiedColumns[ConfiguratorEmailTableMap::REQUIRED_EMAIL] = true;
        }


        return $this;
    } // setRequiredEmail()

    /**
     * Set the value of [visible_email] column.
     * 
     * @param      int $v new value
     * @return   \HookConfigurator\Model\ConfiguratorEmail The current object (for fluent API support)
     */
    public function setVisibleEmail($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->visible_email !== $v) {
            $this->visible_email = $v;
            $this->modifiedColumns[ConfiguratorEmailTableMap::VISIBLE_EMAIL] = true;
        }


        return $this;
    } // setVisibleEmail()

    /**
     * Set the value of [required_terms] column.
     * 
     * @param      int $v new value
     * @return   \HookConfigurator\Model\ConfiguratorEmail The current object (for fluent API support)
     */
    public function setRequiredTerms($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->required_terms !== $v) {
            $this->required_terms = $v;
            $this->modifiedColumns[ConfiguratorEmailTableMap::REQUIRED_TERMS] = true;
        }


        return $this;
    } // setRequiredTerms()

    /**
     * Set the value of [visible_terms] column.
     * 
     * @param      int $v new value
     * @return   \HookConfigurator\Model\ConfiguratorEmail The current object (for fluent API support)
     */
    public function setVisibleTerms($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->visible_terms !== $v) {
            $this->visible_terms = $v;
            $this->modifiedColumns[ConfiguratorEmailTableMap::VISIBLE_TERMS] = true;
        }


        return $this;
    } // setVisibleTerms()

    /**
     * Set the value of [required_send] column.
     * 
     * @param      int $v new value
     * @return   \HookConfigurator\Model\ConfiguratorEmail The current object (for fluent API support)
     */
    public function setRequiredSend($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->required_send !== $v) {
            $this->required_send = $v;
            $this->modifiedColumns[ConfiguratorEmailTableMap::REQUIRED_SEND] = true;
        }


        return $this;
    } // setRequiredSend()

    /**
     * Set the value of [visible_send] column.
     * 
     * @param      int $v new value
     * @return   \HookConfigurator\Model\ConfiguratorEmail The current object (for fluent API support)
     */
    public function setVisibleSend($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->visible_send !== $v) {
            $this->visible_send = $v;
            $this->modifiedColumns[ConfiguratorEmailTableMap::VISIBLE_SEND] = true;
        }


        return $this;
    } // setVisibleSend()

    /**
     * Set the value of [send_email] column.
     * 
     * @param      int $v new value
     * @return   \HookConfigurator\Model\ConfiguratorEmail The current object (for fluent API support)
     */
    public function setSendEmail($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->send_email !== $v) {
            $this->send_email = $v;
            $this->modifiedColumns[ConfiguratorEmailTableMap::SEND_EMAIL] = true;
        }


        return $this;
    } // setSendEmail()

    /**
     * Set the value of [template_email_name_customer] column.
     * 
     * @param      string $v new value
     * @return   \HookConfigurator\Model\ConfiguratorEmail The current object (for fluent API support)
     */
    public function setTemplateEmailNameCustomer($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->template_email_name_customer !== $v) {
            $this->template_email_name_customer = $v;
            $this->modifiedColumns[ConfiguratorEmailTableMap::TEMPLATE_EMAIL_NAME_CUSTOMER] = true;
        }


        return $this;
    } // setTemplateEmailNameCustomer()

    /**
     * Set the value of [template_email_name_admin] column.
     * 
     * @param      string $v new value
     * @return   \HookConfigurator\Model\ConfiguratorEmail The current object (for fluent API support)
     */
    public function setTemplateEmailNameAdmin($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->template_email_name_admin !== $v) {
            $this->template_email_name_admin = $v;
            $this->modifiedColumns[ConfiguratorEmailTableMap::TEMPLATE_EMAIL_NAME_ADMIN] = true;
        }


        return $this;
    } // setTemplateEmailNameAdmin()

    /**
     * Set the value of [template_redirect_search] column.
     * 
     * @param      string $v new value
     * @return   \HookConfigurator\Model\ConfiguratorEmail The current object (for fluent API support)
     */
    public function setTemplateRedirectSearch($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->template_redirect_search !== $v) {
            $this->template_redirect_search = $v;
            $this->modifiedColumns[ConfiguratorEmailTableMap::TEMPLATE_REDIRECT_SEARCH] = true;
        }


        return $this;
    } // setTemplateRedirectSearch()

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
            if ($this->with_search_result !== 0) {
                return false;
            }

            if ($this->id_category_search !== 1) {
                return false;
            }

            if ($this->visible_form_contact !== 1) {
                return false;
            }

            if ($this->required_vorname !== 1) {
                return false;
            }

            if ($this->visible_vorname !== 1) {
                return false;
            }

            if ($this->required_nachname !== 1) {
                return false;
            }

            if ($this->visible_nachname !== 1) {
                return false;
            }

            if ($this->required_str !== 1) {
                return false;
            }

            if ($this->visible_str !== 1) {
                return false;
            }

            if ($this->required_plz !== 1) {
                return false;
            }

            if ($this->visible_plz !== 1) {
                return false;
            }

            if ($this->required_ort !== 1) {
                return false;
            }

            if ($this->visible_ort !== 1) {
                return false;
            }

            if ($this->required_telefon !== 1) {
                return false;
            }

            if ($this->visible_telefon !== 1) {
                return false;
            }

            if ($this->required_email !== 1) {
                return false;
            }

            if ($this->visible_email !== 1) {
                return false;
            }

            if ($this->required_terms !== 1) {
                return false;
            }

            if ($this->visible_terms !== 1) {
                return false;
            }

            if ($this->required_send !== 1) {
                return false;
            }

            if ($this->visible_send !== 1) {
                return false;
            }

            if ($this->send_email !== 1) {
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


            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : ConfiguratorEmailTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : ConfiguratorEmailTableMap::translateFieldName('WithSearchResult', TableMap::TYPE_PHPNAME, $indexType)];
            $this->with_search_result = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : ConfiguratorEmailTableMap::translateFieldName('IdCategorySearch', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id_category_search = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : ConfiguratorEmailTableMap::translateFieldName('VisibleFormContact', TableMap::TYPE_PHPNAME, $indexType)];
            $this->visible_form_contact = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : ConfiguratorEmailTableMap::translateFieldName('RequiredVorname', TableMap::TYPE_PHPNAME, $indexType)];
            $this->required_vorname = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : ConfiguratorEmailTableMap::translateFieldName('VisibleVorname', TableMap::TYPE_PHPNAME, $indexType)];
            $this->visible_vorname = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : ConfiguratorEmailTableMap::translateFieldName('RequiredNachname', TableMap::TYPE_PHPNAME, $indexType)];
            $this->required_nachname = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : ConfiguratorEmailTableMap::translateFieldName('VisibleNachname', TableMap::TYPE_PHPNAME, $indexType)];
            $this->visible_nachname = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : ConfiguratorEmailTableMap::translateFieldName('RequiredStr', TableMap::TYPE_PHPNAME, $indexType)];
            $this->required_str = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : ConfiguratorEmailTableMap::translateFieldName('VisibleStr', TableMap::TYPE_PHPNAME, $indexType)];
            $this->visible_str = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 10 + $startcol : ConfiguratorEmailTableMap::translateFieldName('RequiredPlz', TableMap::TYPE_PHPNAME, $indexType)];
            $this->required_plz = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 11 + $startcol : ConfiguratorEmailTableMap::translateFieldName('VisiblePlz', TableMap::TYPE_PHPNAME, $indexType)];
            $this->visible_plz = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 12 + $startcol : ConfiguratorEmailTableMap::translateFieldName('RequiredOrt', TableMap::TYPE_PHPNAME, $indexType)];
            $this->required_ort = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 13 + $startcol : ConfiguratorEmailTableMap::translateFieldName('VisibleOrt', TableMap::TYPE_PHPNAME, $indexType)];
            $this->visible_ort = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 14 + $startcol : ConfiguratorEmailTableMap::translateFieldName('RequiredTelefon', TableMap::TYPE_PHPNAME, $indexType)];
            $this->required_telefon = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 15 + $startcol : ConfiguratorEmailTableMap::translateFieldName('VisibleTelefon', TableMap::TYPE_PHPNAME, $indexType)];
            $this->visible_telefon = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 16 + $startcol : ConfiguratorEmailTableMap::translateFieldName('RequiredEmail', TableMap::TYPE_PHPNAME, $indexType)];
            $this->required_email = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 17 + $startcol : ConfiguratorEmailTableMap::translateFieldName('VisibleEmail', TableMap::TYPE_PHPNAME, $indexType)];
            $this->visible_email = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 18 + $startcol : ConfiguratorEmailTableMap::translateFieldName('RequiredTerms', TableMap::TYPE_PHPNAME, $indexType)];
            $this->required_terms = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 19 + $startcol : ConfiguratorEmailTableMap::translateFieldName('VisibleTerms', TableMap::TYPE_PHPNAME, $indexType)];
            $this->visible_terms = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 20 + $startcol : ConfiguratorEmailTableMap::translateFieldName('RequiredSend', TableMap::TYPE_PHPNAME, $indexType)];
            $this->required_send = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 21 + $startcol : ConfiguratorEmailTableMap::translateFieldName('VisibleSend', TableMap::TYPE_PHPNAME, $indexType)];
            $this->visible_send = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 22 + $startcol : ConfiguratorEmailTableMap::translateFieldName('SendEmail', TableMap::TYPE_PHPNAME, $indexType)];
            $this->send_email = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 23 + $startcol : ConfiguratorEmailTableMap::translateFieldName('TemplateEmailNameCustomer', TableMap::TYPE_PHPNAME, $indexType)];
            $this->template_email_name_customer = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 24 + $startcol : ConfiguratorEmailTableMap::translateFieldName('TemplateEmailNameAdmin', TableMap::TYPE_PHPNAME, $indexType)];
            $this->template_email_name_admin = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 25 + $startcol : ConfiguratorEmailTableMap::translateFieldName('TemplateRedirectSearch', TableMap::TYPE_PHPNAME, $indexType)];
            $this->template_redirect_search = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 26; // 26 = ConfiguratorEmailTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating \HookConfigurator\Model\ConfiguratorEmail object", 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(ConfiguratorEmailTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildConfiguratorEmailQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see ConfiguratorEmail::setDeleted()
     * @see ConfiguratorEmail::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(ConfiguratorEmailTableMap::DATABASE_NAME);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = ChildConfiguratorEmailQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(ConfiguratorEmailTableMap::DATABASE_NAME);
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
                ConfiguratorEmailTableMap::addInstanceToPool($this);
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

        $this->modifiedColumns[ConfiguratorEmailTableMap::ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . ConfiguratorEmailTableMap::ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(ConfiguratorEmailTableMap::ID)) {
            $modifiedColumns[':p' . $index++]  = 'ID';
        }
        if ($this->isColumnModified(ConfiguratorEmailTableMap::WITH_SEARCH_RESULT)) {
            $modifiedColumns[':p' . $index++]  = 'WITH_SEARCH_RESULT';
        }
        if ($this->isColumnModified(ConfiguratorEmailTableMap::ID_CATEGORY_SEARCH)) {
            $modifiedColumns[':p' . $index++]  = 'ID_CATEGORY_SEARCH';
        }
        if ($this->isColumnModified(ConfiguratorEmailTableMap::VISIBLE_FORM_CONTACT)) {
            $modifiedColumns[':p' . $index++]  = 'VISIBLE_FORM_CONTACT';
        }
        if ($this->isColumnModified(ConfiguratorEmailTableMap::REQUIRED_VORNAME)) {
            $modifiedColumns[':p' . $index++]  = 'REQUIRED_VORNAME';
        }
        if ($this->isColumnModified(ConfiguratorEmailTableMap::VISIBLE_VORNAME)) {
            $modifiedColumns[':p' . $index++]  = 'VISIBLE_VORNAME';
        }
        if ($this->isColumnModified(ConfiguratorEmailTableMap::REQUIRED_NACHNAME)) {
            $modifiedColumns[':p' . $index++]  = 'REQUIRED_NACHNAME';
        }
        if ($this->isColumnModified(ConfiguratorEmailTableMap::VISIBLE_NACHNAME)) {
            $modifiedColumns[':p' . $index++]  = 'VISIBLE_NACHNAME';
        }
        if ($this->isColumnModified(ConfiguratorEmailTableMap::REQUIRED_STR)) {
            $modifiedColumns[':p' . $index++]  = 'REQUIRED_STR';
        }
        if ($this->isColumnModified(ConfiguratorEmailTableMap::VISIBLE_STR)) {
            $modifiedColumns[':p' . $index++]  = 'VISIBLE_STR';
        }
        if ($this->isColumnModified(ConfiguratorEmailTableMap::REQUIRED_PLZ)) {
            $modifiedColumns[':p' . $index++]  = 'REQUIRED_PLZ';
        }
        if ($this->isColumnModified(ConfiguratorEmailTableMap::VISIBLE_PLZ)) {
            $modifiedColumns[':p' . $index++]  = 'VISIBLE_PLZ';
        }
        if ($this->isColumnModified(ConfiguratorEmailTableMap::REQUIRED_ORT)) {
            $modifiedColumns[':p' . $index++]  = 'REQUIRED_ORT';
        }
        if ($this->isColumnModified(ConfiguratorEmailTableMap::VISIBLE_ORT)) {
            $modifiedColumns[':p' . $index++]  = 'VISIBLE_ORT';
        }
        if ($this->isColumnModified(ConfiguratorEmailTableMap::REQUIRED_TELEFON)) {
            $modifiedColumns[':p' . $index++]  = 'REQUIRED_TELEFON';
        }
        if ($this->isColumnModified(ConfiguratorEmailTableMap::VISIBLE_TELEFON)) {
            $modifiedColumns[':p' . $index++]  = 'VISIBLE_TELEFON';
        }
        if ($this->isColumnModified(ConfiguratorEmailTableMap::REQUIRED_EMAIL)) {
            $modifiedColumns[':p' . $index++]  = 'REQUIRED_EMAIL';
        }
        if ($this->isColumnModified(ConfiguratorEmailTableMap::VISIBLE_EMAIL)) {
            $modifiedColumns[':p' . $index++]  = 'VISIBLE_EMAIL';
        }
        if ($this->isColumnModified(ConfiguratorEmailTableMap::REQUIRED_TERMS)) {
            $modifiedColumns[':p' . $index++]  = 'REQUIRED_TERMS';
        }
        if ($this->isColumnModified(ConfiguratorEmailTableMap::VISIBLE_TERMS)) {
            $modifiedColumns[':p' . $index++]  = 'VISIBLE_TERMS';
        }
        if ($this->isColumnModified(ConfiguratorEmailTableMap::REQUIRED_SEND)) {
            $modifiedColumns[':p' . $index++]  = 'REQUIRED_SEND';
        }
        if ($this->isColumnModified(ConfiguratorEmailTableMap::VISIBLE_SEND)) {
            $modifiedColumns[':p' . $index++]  = 'VISIBLE_SEND';
        }
        if ($this->isColumnModified(ConfiguratorEmailTableMap::SEND_EMAIL)) {
            $modifiedColumns[':p' . $index++]  = 'SEND_EMAIL';
        }
        if ($this->isColumnModified(ConfiguratorEmailTableMap::TEMPLATE_EMAIL_NAME_CUSTOMER)) {
            $modifiedColumns[':p' . $index++]  = 'TEMPLATE_EMAIL_NAME_CUSTOMER';
        }
        if ($this->isColumnModified(ConfiguratorEmailTableMap::TEMPLATE_EMAIL_NAME_ADMIN)) {
            $modifiedColumns[':p' . $index++]  = 'TEMPLATE_EMAIL_NAME_ADMIN';
        }
        if ($this->isColumnModified(ConfiguratorEmailTableMap::TEMPLATE_REDIRECT_SEARCH)) {
            $modifiedColumns[':p' . $index++]  = 'TEMPLATE_REDIRECT_SEARCH';
        }

        $sql = sprintf(
            'INSERT INTO configurator_email (%s) VALUES (%s)',
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
                    case 'WITH_SEARCH_RESULT':                        
                        $stmt->bindValue($identifier, $this->with_search_result, PDO::PARAM_INT);
                        break;
                    case 'ID_CATEGORY_SEARCH':                        
                        $stmt->bindValue($identifier, $this->id_category_search, PDO::PARAM_INT);
                        break;
                    case 'VISIBLE_FORM_CONTACT':                        
                        $stmt->bindValue($identifier, $this->visible_form_contact, PDO::PARAM_INT);
                        break;
                    case 'REQUIRED_VORNAME':                        
                        $stmt->bindValue($identifier, $this->required_vorname, PDO::PARAM_INT);
                        break;
                    case 'VISIBLE_VORNAME':                        
                        $stmt->bindValue($identifier, $this->visible_vorname, PDO::PARAM_INT);
                        break;
                    case 'REQUIRED_NACHNAME':                        
                        $stmt->bindValue($identifier, $this->required_nachname, PDO::PARAM_INT);
                        break;
                    case 'VISIBLE_NACHNAME':                        
                        $stmt->bindValue($identifier, $this->visible_nachname, PDO::PARAM_INT);
                        break;
                    case 'REQUIRED_STR':                        
                        $stmt->bindValue($identifier, $this->required_str, PDO::PARAM_INT);
                        break;
                    case 'VISIBLE_STR':                        
                        $stmt->bindValue($identifier, $this->visible_str, PDO::PARAM_INT);
                        break;
                    case 'REQUIRED_PLZ':                        
                        $stmt->bindValue($identifier, $this->required_plz, PDO::PARAM_INT);
                        break;
                    case 'VISIBLE_PLZ':                        
                        $stmt->bindValue($identifier, $this->visible_plz, PDO::PARAM_INT);
                        break;
                    case 'REQUIRED_ORT':                        
                        $stmt->bindValue($identifier, $this->required_ort, PDO::PARAM_INT);
                        break;
                    case 'VISIBLE_ORT':                        
                        $stmt->bindValue($identifier, $this->visible_ort, PDO::PARAM_INT);
                        break;
                    case 'REQUIRED_TELEFON':                        
                        $stmt->bindValue($identifier, $this->required_telefon, PDO::PARAM_INT);
                        break;
                    case 'VISIBLE_TELEFON':                        
                        $stmt->bindValue($identifier, $this->visible_telefon, PDO::PARAM_INT);
                        break;
                    case 'REQUIRED_EMAIL':                        
                        $stmt->bindValue($identifier, $this->required_email, PDO::PARAM_INT);
                        break;
                    case 'VISIBLE_EMAIL':                        
                        $stmt->bindValue($identifier, $this->visible_email, PDO::PARAM_INT);
                        break;
                    case 'REQUIRED_TERMS':                        
                        $stmt->bindValue($identifier, $this->required_terms, PDO::PARAM_INT);
                        break;
                    case 'VISIBLE_TERMS':                        
                        $stmt->bindValue($identifier, $this->visible_terms, PDO::PARAM_INT);
                        break;
                    case 'REQUIRED_SEND':                        
                        $stmt->bindValue($identifier, $this->required_send, PDO::PARAM_INT);
                        break;
                    case 'VISIBLE_SEND':                        
                        $stmt->bindValue($identifier, $this->visible_send, PDO::PARAM_INT);
                        break;
                    case 'SEND_EMAIL':                        
                        $stmt->bindValue($identifier, $this->send_email, PDO::PARAM_INT);
                        break;
                    case 'TEMPLATE_EMAIL_NAME_CUSTOMER':                        
                        $stmt->bindValue($identifier, $this->template_email_name_customer, PDO::PARAM_STR);
                        break;
                    case 'TEMPLATE_EMAIL_NAME_ADMIN':                        
                        $stmt->bindValue($identifier, $this->template_email_name_admin, PDO::PARAM_STR);
                        break;
                    case 'TEMPLATE_REDIRECT_SEARCH':                        
                        $stmt->bindValue($identifier, $this->template_redirect_search, PDO::PARAM_STR);
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
        $pos = ConfiguratorEmailTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getWithSearchResult();
                break;
            case 2:
                return $this->getIdCategorySearch();
                break;
            case 3:
                return $this->getVisibleFormContact();
                break;
            case 4:
                return $this->getRequiredVorname();
                break;
            case 5:
                return $this->getVisibleVorname();
                break;
            case 6:
                return $this->getRequiredNachname();
                break;
            case 7:
                return $this->getVisibleNachname();
                break;
            case 8:
                return $this->getRequiredStr();
                break;
            case 9:
                return $this->getVisibleStr();
                break;
            case 10:
                return $this->getRequiredPlz();
                break;
            case 11:
                return $this->getVisiblePlz();
                break;
            case 12:
                return $this->getRequiredOrt();
                break;
            case 13:
                return $this->getVisibleOrt();
                break;
            case 14:
                return $this->getRequiredTelefon();
                break;
            case 15:
                return $this->getVisibleTelefon();
                break;
            case 16:
                return $this->getRequiredEmail();
                break;
            case 17:
                return $this->getVisibleEmail();
                break;
            case 18:
                return $this->getRequiredTerms();
                break;
            case 19:
                return $this->getVisibleTerms();
                break;
            case 20:
                return $this->getRequiredSend();
                break;
            case 21:
                return $this->getVisibleSend();
                break;
            case 22:
                return $this->getSendEmail();
                break;
            case 23:
                return $this->getTemplateEmailNameCustomer();
                break;
            case 24:
                return $this->getTemplateEmailNameAdmin();
                break;
            case 25:
                return $this->getTemplateRedirectSearch();
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
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = TableMap::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array())
    {
        if (isset($alreadyDumpedObjects['ConfiguratorEmail'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['ConfiguratorEmail'][$this->getPrimaryKey()] = true;
        $keys = ConfiguratorEmailTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getWithSearchResult(),
            $keys[2] => $this->getIdCategorySearch(),
            $keys[3] => $this->getVisibleFormContact(),
            $keys[4] => $this->getRequiredVorname(),
            $keys[5] => $this->getVisibleVorname(),
            $keys[6] => $this->getRequiredNachname(),
            $keys[7] => $this->getVisibleNachname(),
            $keys[8] => $this->getRequiredStr(),
            $keys[9] => $this->getVisibleStr(),
            $keys[10] => $this->getRequiredPlz(),
            $keys[11] => $this->getVisiblePlz(),
            $keys[12] => $this->getRequiredOrt(),
            $keys[13] => $this->getVisibleOrt(),
            $keys[14] => $this->getRequiredTelefon(),
            $keys[15] => $this->getVisibleTelefon(),
            $keys[16] => $this->getRequiredEmail(),
            $keys[17] => $this->getVisibleEmail(),
            $keys[18] => $this->getRequiredTerms(),
            $keys[19] => $this->getVisibleTerms(),
            $keys[20] => $this->getRequiredSend(),
            $keys[21] => $this->getVisibleSend(),
            $keys[22] => $this->getSendEmail(),
            $keys[23] => $this->getTemplateEmailNameCustomer(),
            $keys[24] => $this->getTemplateEmailNameAdmin(),
            $keys[25] => $this->getTemplateRedirectSearch(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
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
        $pos = ConfiguratorEmailTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

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
                $this->setWithSearchResult($value);
                break;
            case 2:
                $this->setIdCategorySearch($value);
                break;
            case 3:
                $this->setVisibleFormContact($value);
                break;
            case 4:
                $this->setRequiredVorname($value);
                break;
            case 5:
                $this->setVisibleVorname($value);
                break;
            case 6:
                $this->setRequiredNachname($value);
                break;
            case 7:
                $this->setVisibleNachname($value);
                break;
            case 8:
                $this->setRequiredStr($value);
                break;
            case 9:
                $this->setVisibleStr($value);
                break;
            case 10:
                $this->setRequiredPlz($value);
                break;
            case 11:
                $this->setVisiblePlz($value);
                break;
            case 12:
                $this->setRequiredOrt($value);
                break;
            case 13:
                $this->setVisibleOrt($value);
                break;
            case 14:
                $this->setRequiredTelefon($value);
                break;
            case 15:
                $this->setVisibleTelefon($value);
                break;
            case 16:
                $this->setRequiredEmail($value);
                break;
            case 17:
                $this->setVisibleEmail($value);
                break;
            case 18:
                $this->setRequiredTerms($value);
                break;
            case 19:
                $this->setVisibleTerms($value);
                break;
            case 20:
                $this->setRequiredSend($value);
                break;
            case 21:
                $this->setVisibleSend($value);
                break;
            case 22:
                $this->setSendEmail($value);
                break;
            case 23:
                $this->setTemplateEmailNameCustomer($value);
                break;
            case 24:
                $this->setTemplateEmailNameAdmin($value);
                break;
            case 25:
                $this->setTemplateRedirectSearch($value);
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
        $keys = ConfiguratorEmailTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setWithSearchResult($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setIdCategorySearch($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setVisibleFormContact($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setRequiredVorname($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setVisibleVorname($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setRequiredNachname($arr[$keys[6]]);
        if (array_key_exists($keys[7], $arr)) $this->setVisibleNachname($arr[$keys[7]]);
        if (array_key_exists($keys[8], $arr)) $this->setRequiredStr($arr[$keys[8]]);
        if (array_key_exists($keys[9], $arr)) $this->setVisibleStr($arr[$keys[9]]);
        if (array_key_exists($keys[10], $arr)) $this->setRequiredPlz($arr[$keys[10]]);
        if (array_key_exists($keys[11], $arr)) $this->setVisiblePlz($arr[$keys[11]]);
        if (array_key_exists($keys[12], $arr)) $this->setRequiredOrt($arr[$keys[12]]);
        if (array_key_exists($keys[13], $arr)) $this->setVisibleOrt($arr[$keys[13]]);
        if (array_key_exists($keys[14], $arr)) $this->setRequiredTelefon($arr[$keys[14]]);
        if (array_key_exists($keys[15], $arr)) $this->setVisibleTelefon($arr[$keys[15]]);
        if (array_key_exists($keys[16], $arr)) $this->setRequiredEmail($arr[$keys[16]]);
        if (array_key_exists($keys[17], $arr)) $this->setVisibleEmail($arr[$keys[17]]);
        if (array_key_exists($keys[18], $arr)) $this->setRequiredTerms($arr[$keys[18]]);
        if (array_key_exists($keys[19], $arr)) $this->setVisibleTerms($arr[$keys[19]]);
        if (array_key_exists($keys[20], $arr)) $this->setRequiredSend($arr[$keys[20]]);
        if (array_key_exists($keys[21], $arr)) $this->setVisibleSend($arr[$keys[21]]);
        if (array_key_exists($keys[22], $arr)) $this->setSendEmail($arr[$keys[22]]);
        if (array_key_exists($keys[23], $arr)) $this->setTemplateEmailNameCustomer($arr[$keys[23]]);
        if (array_key_exists($keys[24], $arr)) $this->setTemplateEmailNameAdmin($arr[$keys[24]]);
        if (array_key_exists($keys[25], $arr)) $this->setTemplateRedirectSearch($arr[$keys[25]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(ConfiguratorEmailTableMap::DATABASE_NAME);

        if ($this->isColumnModified(ConfiguratorEmailTableMap::ID)) $criteria->add(ConfiguratorEmailTableMap::ID, $this->id);
        if ($this->isColumnModified(ConfiguratorEmailTableMap::WITH_SEARCH_RESULT)) $criteria->add(ConfiguratorEmailTableMap::WITH_SEARCH_RESULT, $this->with_search_result);
        if ($this->isColumnModified(ConfiguratorEmailTableMap::ID_CATEGORY_SEARCH)) $criteria->add(ConfiguratorEmailTableMap::ID_CATEGORY_SEARCH, $this->id_category_search);
        if ($this->isColumnModified(ConfiguratorEmailTableMap::VISIBLE_FORM_CONTACT)) $criteria->add(ConfiguratorEmailTableMap::VISIBLE_FORM_CONTACT, $this->visible_form_contact);
        if ($this->isColumnModified(ConfiguratorEmailTableMap::REQUIRED_VORNAME)) $criteria->add(ConfiguratorEmailTableMap::REQUIRED_VORNAME, $this->required_vorname);
        if ($this->isColumnModified(ConfiguratorEmailTableMap::VISIBLE_VORNAME)) $criteria->add(ConfiguratorEmailTableMap::VISIBLE_VORNAME, $this->visible_vorname);
        if ($this->isColumnModified(ConfiguratorEmailTableMap::REQUIRED_NACHNAME)) $criteria->add(ConfiguratorEmailTableMap::REQUIRED_NACHNAME, $this->required_nachname);
        if ($this->isColumnModified(ConfiguratorEmailTableMap::VISIBLE_NACHNAME)) $criteria->add(ConfiguratorEmailTableMap::VISIBLE_NACHNAME, $this->visible_nachname);
        if ($this->isColumnModified(ConfiguratorEmailTableMap::REQUIRED_STR)) $criteria->add(ConfiguratorEmailTableMap::REQUIRED_STR, $this->required_str);
        if ($this->isColumnModified(ConfiguratorEmailTableMap::VISIBLE_STR)) $criteria->add(ConfiguratorEmailTableMap::VISIBLE_STR, $this->visible_str);
        if ($this->isColumnModified(ConfiguratorEmailTableMap::REQUIRED_PLZ)) $criteria->add(ConfiguratorEmailTableMap::REQUIRED_PLZ, $this->required_plz);
        if ($this->isColumnModified(ConfiguratorEmailTableMap::VISIBLE_PLZ)) $criteria->add(ConfiguratorEmailTableMap::VISIBLE_PLZ, $this->visible_plz);
        if ($this->isColumnModified(ConfiguratorEmailTableMap::REQUIRED_ORT)) $criteria->add(ConfiguratorEmailTableMap::REQUIRED_ORT, $this->required_ort);
        if ($this->isColumnModified(ConfiguratorEmailTableMap::VISIBLE_ORT)) $criteria->add(ConfiguratorEmailTableMap::VISIBLE_ORT, $this->visible_ort);
        if ($this->isColumnModified(ConfiguratorEmailTableMap::REQUIRED_TELEFON)) $criteria->add(ConfiguratorEmailTableMap::REQUIRED_TELEFON, $this->required_telefon);
        if ($this->isColumnModified(ConfiguratorEmailTableMap::VISIBLE_TELEFON)) $criteria->add(ConfiguratorEmailTableMap::VISIBLE_TELEFON, $this->visible_telefon);
        if ($this->isColumnModified(ConfiguratorEmailTableMap::REQUIRED_EMAIL)) $criteria->add(ConfiguratorEmailTableMap::REQUIRED_EMAIL, $this->required_email);
        if ($this->isColumnModified(ConfiguratorEmailTableMap::VISIBLE_EMAIL)) $criteria->add(ConfiguratorEmailTableMap::VISIBLE_EMAIL, $this->visible_email);
        if ($this->isColumnModified(ConfiguratorEmailTableMap::REQUIRED_TERMS)) $criteria->add(ConfiguratorEmailTableMap::REQUIRED_TERMS, $this->required_terms);
        if ($this->isColumnModified(ConfiguratorEmailTableMap::VISIBLE_TERMS)) $criteria->add(ConfiguratorEmailTableMap::VISIBLE_TERMS, $this->visible_terms);
        if ($this->isColumnModified(ConfiguratorEmailTableMap::REQUIRED_SEND)) $criteria->add(ConfiguratorEmailTableMap::REQUIRED_SEND, $this->required_send);
        if ($this->isColumnModified(ConfiguratorEmailTableMap::VISIBLE_SEND)) $criteria->add(ConfiguratorEmailTableMap::VISIBLE_SEND, $this->visible_send);
        if ($this->isColumnModified(ConfiguratorEmailTableMap::SEND_EMAIL)) $criteria->add(ConfiguratorEmailTableMap::SEND_EMAIL, $this->send_email);
        if ($this->isColumnModified(ConfiguratorEmailTableMap::TEMPLATE_EMAIL_NAME_CUSTOMER)) $criteria->add(ConfiguratorEmailTableMap::TEMPLATE_EMAIL_NAME_CUSTOMER, $this->template_email_name_customer);
        if ($this->isColumnModified(ConfiguratorEmailTableMap::TEMPLATE_EMAIL_NAME_ADMIN)) $criteria->add(ConfiguratorEmailTableMap::TEMPLATE_EMAIL_NAME_ADMIN, $this->template_email_name_admin);
        if ($this->isColumnModified(ConfiguratorEmailTableMap::TEMPLATE_REDIRECT_SEARCH)) $criteria->add(ConfiguratorEmailTableMap::TEMPLATE_REDIRECT_SEARCH, $this->template_redirect_search);

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
        $criteria = new Criteria(ConfiguratorEmailTableMap::DATABASE_NAME);
        $criteria->add(ConfiguratorEmailTableMap::ID, $this->id);

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
     * @param      object $copyObj An object of \HookConfigurator\Model\ConfiguratorEmail (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setWithSearchResult($this->getWithSearchResult());
        $copyObj->setIdCategorySearch($this->getIdCategorySearch());
        $copyObj->setVisibleFormContact($this->getVisibleFormContact());
        $copyObj->setRequiredVorname($this->getRequiredVorname());
        $copyObj->setVisibleVorname($this->getVisibleVorname());
        $copyObj->setRequiredNachname($this->getRequiredNachname());
        $copyObj->setVisibleNachname($this->getVisibleNachname());
        $copyObj->setRequiredStr($this->getRequiredStr());
        $copyObj->setVisibleStr($this->getVisibleStr());
        $copyObj->setRequiredPlz($this->getRequiredPlz());
        $copyObj->setVisiblePlz($this->getVisiblePlz());
        $copyObj->setRequiredOrt($this->getRequiredOrt());
        $copyObj->setVisibleOrt($this->getVisibleOrt());
        $copyObj->setRequiredTelefon($this->getRequiredTelefon());
        $copyObj->setVisibleTelefon($this->getVisibleTelefon());
        $copyObj->setRequiredEmail($this->getRequiredEmail());
        $copyObj->setVisibleEmail($this->getVisibleEmail());
        $copyObj->setRequiredTerms($this->getRequiredTerms());
        $copyObj->setVisibleTerms($this->getVisibleTerms());
        $copyObj->setRequiredSend($this->getRequiredSend());
        $copyObj->setVisibleSend($this->getVisibleSend());
        $copyObj->setSendEmail($this->getSendEmail());
        $copyObj->setTemplateEmailNameCustomer($this->getTemplateEmailNameCustomer());
        $copyObj->setTemplateEmailNameAdmin($this->getTemplateEmailNameAdmin());
        $copyObj->setTemplateRedirectSearch($this->getTemplateRedirectSearch());
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
     * @return                 \HookConfigurator\Model\ConfiguratorEmail Clone of current object.
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
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->id = null;
        $this->with_search_result = null;
        $this->id_category_search = null;
        $this->visible_form_contact = null;
        $this->required_vorname = null;
        $this->visible_vorname = null;
        $this->required_nachname = null;
        $this->visible_nachname = null;
        $this->required_str = null;
        $this->visible_str = null;
        $this->required_plz = null;
        $this->visible_plz = null;
        $this->required_ort = null;
        $this->visible_ort = null;
        $this->required_telefon = null;
        $this->visible_telefon = null;
        $this->required_email = null;
        $this->visible_email = null;
        $this->required_terms = null;
        $this->visible_terms = null;
        $this->required_send = null;
        $this->visible_send = null;
        $this->send_email = null;
        $this->template_email_name_customer = null;
        $this->template_email_name_admin = null;
        $this->template_redirect_search = null;
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

    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(ConfiguratorEmailTableMap::DEFAULT_STRING_FORMAT);
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
