<?php

namespace CronDashboard\Model\Base;

use \DateTime;
use \Exception;
use \PDO;
use CronDashboard\Model\CronDashboardProcessLog as ChildCronDashboardProcessLog;
use CronDashboard\Model\CronDashboardProcessLogQuery as ChildCronDashboardProcessLogQuery;
use CronDashboard\Model\Map\CronDashboardProcessLogTableMap;
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

abstract class CronDashboardProcessLog implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\CronDashboard\\Model\\Map\\CronDashboardProcessLogTableMap';


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
     * The value for the linux_user field.
     * @var        string
     */
    protected $linux_user;

    /**
     * The value for the linux_pid field.
     * @var        int
     */
    protected $linux_pid;

    /**
     * The value for the process_name field.
     * @var        string
     */
    protected $process_name;

    /**
     * The value for the cpu field.
     * @var        string
     */
    protected $cpu;

    /**
     * The value for the mem field.
     * @var        string
     */
    protected $mem;

    /**
     * The value for the vsz field.
     * @var        string
     */
    protected $vsz;

    /**
     * The value for the tty field.
     * @var        string
     */
    protected $tty;

    /**
     * The value for the stat field.
     * @var        string
     */
    protected $stat;

    /**
     * The value for the start field.
     * @var        string
     */
    protected $start;

    /**
     * The value for the time field.
     * @var        string
     */
    protected $time;

    /**
     * The value for the command field.
     * @var        string
     */
    protected $command;

    /**
     * The value for the thelia_user_name field.
     * @var        string
     */
    protected $thelia_user_name;

    /**
     * The value for the thelia_user_id field.
     * @var        int
     */
    protected $thelia_user_id;

    /**
     * The value for the action_triggered field.
     * @var        string
     */
    protected $action_triggered;

    /**
     * The value for the trigger_time field.
     * @var        string
     */
    protected $trigger_time;

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
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * Initializes internal state of CronDashboard\Model\Base\CronDashboardProcessLog object.
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
     * Compares this with another <code>CronDashboardProcessLog</code> instance.  If
     * <code>obj</code> is an instance of <code>CronDashboardProcessLog</code>, delegates to
     * <code>equals(CronDashboardProcessLog)</code>.  Otherwise, returns <code>false</code>.
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
     * @return CronDashboardProcessLog The current object, for fluid interface
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
     * @return CronDashboardProcessLog The current object, for fluid interface
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
     * Get the [linux_user] column value.
     *
     * @return   string
     */
    public function getLinuxUser()
    {

        return $this->linux_user;
    }

    /**
     * Get the [linux_pid] column value.
     *
     * @return   int
     */
    public function getLinuxPid()
    {

        return $this->linux_pid;
    }

    /**
     * Get the [process_name] column value.
     *
     * @return   string
     */
    public function getProcessName()
    {

        return $this->process_name;
    }

    /**
     * Get the [cpu] column value.
     *
     * @return   string
     */
    public function getCpu()
    {

        return $this->cpu;
    }

    /**
     * Get the [mem] column value.
     *
     * @return   string
     */
    public function getMem()
    {

        return $this->mem;
    }

    /**
     * Get the [vsz] column value.
     *
     * @return   string
     */
    public function getVsz()
    {

        return $this->vsz;
    }

    /**
     * Get the [tty] column value.
     *
     * @return   string
     */
    public function getTty()
    {

        return $this->tty;
    }

    /**
     * Get the [stat] column value.
     *
     * @return   string
     */
    public function getStat()
    {

        return $this->stat;
    }

    /**
     * Get the [start] column value.
     *
     * @return   string
     */
    public function getStart()
    {

        return $this->start;
    }

    /**
     * Get the [time] column value.
     *
     * @return   string
     */
    public function getTime()
    {

        return $this->time;
    }

    /**
     * Get the [command] column value.
     *
     * @return   string
     */
    public function getCommand()
    {

        return $this->command;
    }

    /**
     * Get the [thelia_user_name] column value.
     *
     * @return   string
     */
    public function getTheliaUserName()
    {

        return $this->thelia_user_name;
    }

    /**
     * Get the [thelia_user_id] column value.
     *
     * @return   int
     */
    public function getTheliaUserId()
    {

        return $this->thelia_user_id;
    }

    /**
     * Get the [action_triggered] column value.
     *
     * @return   string
     */
    public function getActionTriggered()
    {

        return $this->action_triggered;
    }

    /**
     * Get the [optionally formatted] temporal [trigger_time] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw \DateTime object will be returned.
     *
     * @return mixed Formatted date/time value as string or \DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getTriggerTime($format = NULL)
    {
        if ($format === null) {
            return $this->trigger_time;
        } else {
            return $this->trigger_time instanceof \DateTime ? $this->trigger_time->format($format) : null;
        }
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
     * @return   \CronDashboard\Model\CronDashboardProcessLog The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[CronDashboardProcessLogTableMap::ID] = true;
        }


        return $this;
    } // setId()

    /**
     * Set the value of [linux_user] column.
     *
     * @param      string $v new value
     * @return   \CronDashboard\Model\CronDashboardProcessLog The current object (for fluent API support)
     */
    public function setLinuxUser($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->linux_user !== $v) {
            $this->linux_user = $v;
            $this->modifiedColumns[CronDashboardProcessLogTableMap::LINUX_USER] = true;
        }


        return $this;
    } // setLinuxUser()

    /**
     * Set the value of [linux_pid] column.
     *
     * @param      int $v new value
     * @return   \CronDashboard\Model\CronDashboardProcessLog The current object (for fluent API support)
     */
    public function setLinuxPid($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->linux_pid !== $v) {
            $this->linux_pid = $v;
            $this->modifiedColumns[CronDashboardProcessLogTableMap::LINUX_PID] = true;
        }


        return $this;
    } // setLinuxPid()

    /**
     * Set the value of [process_name] column.
     *
     * @param      string $v new value
     * @return   \CronDashboard\Model\CronDashboardProcessLog The current object (for fluent API support)
     */
    public function setProcessName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->process_name !== $v) {
            $this->process_name = $v;
            $this->modifiedColumns[CronDashboardProcessLogTableMap::PROCESS_NAME] = true;
        }


        return $this;
    } // setProcessName()

    /**
     * Set the value of [cpu] column.
     *
     * @param      string $v new value
     * @return   \CronDashboard\Model\CronDashboardProcessLog The current object (for fluent API support)
     */
    public function setCpu($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->cpu !== $v) {
            $this->cpu = $v;
            $this->modifiedColumns[CronDashboardProcessLogTableMap::CPU] = true;
        }


        return $this;
    } // setCpu()

    /**
     * Set the value of [mem] column.
     *
     * @param      string $v new value
     * @return   \CronDashboard\Model\CronDashboardProcessLog The current object (for fluent API support)
     */
    public function setMem($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->mem !== $v) {
            $this->mem = $v;
            $this->modifiedColumns[CronDashboardProcessLogTableMap::MEM] = true;
        }


        return $this;
    } // setMem()

    /**
     * Set the value of [vsz] column.
     *
     * @param      string $v new value
     * @return   \CronDashboard\Model\CronDashboardProcessLog The current object (for fluent API support)
     */
    public function setVsz($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->vsz !== $v) {
            $this->vsz = $v;
            $this->modifiedColumns[CronDashboardProcessLogTableMap::VSZ] = true;
        }


        return $this;
    } // setVsz()

    /**
     * Set the value of [tty] column.
     *
     * @param      string $v new value
     * @return   \CronDashboard\Model\CronDashboardProcessLog The current object (for fluent API support)
     */
    public function setTty($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->tty !== $v) {
            $this->tty = $v;
            $this->modifiedColumns[CronDashboardProcessLogTableMap::TTY] = true;
        }


        return $this;
    } // setTty()

    /**
     * Set the value of [stat] column.
     *
     * @param      string $v new value
     * @return   \CronDashboard\Model\CronDashboardProcessLog The current object (for fluent API support)
     */
    public function setStat($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->stat !== $v) {
            $this->stat = $v;
            $this->modifiedColumns[CronDashboardProcessLogTableMap::STAT] = true;
        }


        return $this;
    } // setStat()

    /**
     * Set the value of [start] column.
     *
     * @param      string $v new value
     * @return   \CronDashboard\Model\CronDashboardProcessLog The current object (for fluent API support)
     */
    public function setStart($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->start !== $v) {
            $this->start = $v;
            $this->modifiedColumns[CronDashboardProcessLogTableMap::START] = true;
        }


        return $this;
    } // setStart()

    /**
     * Set the value of [time] column.
     *
     * @param      string $v new value
     * @return   \CronDashboard\Model\CronDashboardProcessLog The current object (for fluent API support)
     */
    public function setTime($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->time !== $v) {
            $this->time = $v;
            $this->modifiedColumns[CronDashboardProcessLogTableMap::TIME] = true;
        }


        return $this;
    } // setTime()

    /**
     * Set the value of [command] column.
     *
     * @param      string $v new value
     * @return   \CronDashboard\Model\CronDashboardProcessLog The current object (for fluent API support)
     */
    public function setCommand($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->command !== $v) {
            $this->command = $v;
            $this->modifiedColumns[CronDashboardProcessLogTableMap::COMMAND] = true;
        }


        return $this;
    } // setCommand()

    /**
     * Set the value of [thelia_user_name] column.
     *
     * @param      string $v new value
     * @return   \CronDashboard\Model\CronDashboardProcessLog The current object (for fluent API support)
     */
    public function setTheliaUserName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->thelia_user_name !== $v) {
            $this->thelia_user_name = $v;
            $this->modifiedColumns[CronDashboardProcessLogTableMap::THELIA_USER_NAME] = true;
        }


        return $this;
    } // setTheliaUserName()

    /**
     * Set the value of [thelia_user_id] column.
     *
     * @param      int $v new value
     * @return   \CronDashboard\Model\CronDashboardProcessLog The current object (for fluent API support)
     */
    public function setTheliaUserId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->thelia_user_id !== $v) {
            $this->thelia_user_id = $v;
            $this->modifiedColumns[CronDashboardProcessLogTableMap::THELIA_USER_ID] = true;
        }


        return $this;
    } // setTheliaUserId()

    /**
     * Set the value of [action_triggered] column.
     *
     * @param      string $v new value
     * @return   \CronDashboard\Model\CronDashboardProcessLog The current object (for fluent API support)
     */
    public function setActionTriggered($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->action_triggered !== $v) {
            $this->action_triggered = $v;
            $this->modifiedColumns[CronDashboardProcessLogTableMap::ACTION_TRIGGERED] = true;
        }


        return $this;
    } // setActionTriggered()

    /**
     * Sets the value of [trigger_time] column to a normalized version of the date/time value specified.
     *
     * @param      mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return   \CronDashboard\Model\CronDashboardProcessLog The current object (for fluent API support)
     */
    public function setTriggerTime($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->trigger_time !== null || $dt !== null) {
            if ($dt !== $this->trigger_time) {
                $this->trigger_time = $dt;
                $this->modifiedColumns[CronDashboardProcessLogTableMap::TRIGGER_TIME] = true;
            }
        } // if either are not null


        return $this;
    } // setTriggerTime()

    /**
     * Sets the value of [created_at] column to a normalized version of the date/time value specified.
     *
     * @param      mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return   \CronDashboard\Model\CronDashboardProcessLog The current object (for fluent API support)
     */
    public function setCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->created_at !== null || $dt !== null) {
            if ($dt !== $this->created_at) {
                $this->created_at = $dt;
                $this->modifiedColumns[CronDashboardProcessLogTableMap::CREATED_AT] = true;
            }
        } // if either are not null


        return $this;
    } // setCreatedAt()

    /**
     * Sets the value of [updated_at] column to a normalized version of the date/time value specified.
     *
     * @param      mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return   \CronDashboard\Model\CronDashboardProcessLog The current object (for fluent API support)
     */
    public function setUpdatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->updated_at !== null || $dt !== null) {
            if ($dt !== $this->updated_at) {
                $this->updated_at = $dt;
                $this->modifiedColumns[CronDashboardProcessLogTableMap::UPDATED_AT] = true;
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


            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : CronDashboardProcessLogTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : CronDashboardProcessLogTableMap::translateFieldName('LinuxUser', TableMap::TYPE_PHPNAME, $indexType)];
            $this->linux_user = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : CronDashboardProcessLogTableMap::translateFieldName('LinuxPid', TableMap::TYPE_PHPNAME, $indexType)];
            $this->linux_pid = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : CronDashboardProcessLogTableMap::translateFieldName('ProcessName', TableMap::TYPE_PHPNAME, $indexType)];
            $this->process_name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : CronDashboardProcessLogTableMap::translateFieldName('Cpu', TableMap::TYPE_PHPNAME, $indexType)];
            $this->cpu = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : CronDashboardProcessLogTableMap::translateFieldName('Mem', TableMap::TYPE_PHPNAME, $indexType)];
            $this->mem = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : CronDashboardProcessLogTableMap::translateFieldName('Vsz', TableMap::TYPE_PHPNAME, $indexType)];
            $this->vsz = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : CronDashboardProcessLogTableMap::translateFieldName('Tty', TableMap::TYPE_PHPNAME, $indexType)];
            $this->tty = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : CronDashboardProcessLogTableMap::translateFieldName('Stat', TableMap::TYPE_PHPNAME, $indexType)];
            $this->stat = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : CronDashboardProcessLogTableMap::translateFieldName('Start', TableMap::TYPE_PHPNAME, $indexType)];
            $this->start = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 10 + $startcol : CronDashboardProcessLogTableMap::translateFieldName('Time', TableMap::TYPE_PHPNAME, $indexType)];
            $this->time = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 11 + $startcol : CronDashboardProcessLogTableMap::translateFieldName('Command', TableMap::TYPE_PHPNAME, $indexType)];
            $this->command = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 12 + $startcol : CronDashboardProcessLogTableMap::translateFieldName('TheliaUserName', TableMap::TYPE_PHPNAME, $indexType)];
            $this->thelia_user_name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 13 + $startcol : CronDashboardProcessLogTableMap::translateFieldName('TheliaUserId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->thelia_user_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 14 + $startcol : CronDashboardProcessLogTableMap::translateFieldName('ActionTriggered', TableMap::TYPE_PHPNAME, $indexType)];
            $this->action_triggered = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 15 + $startcol : CronDashboardProcessLogTableMap::translateFieldName('TriggerTime', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->trigger_time = (null !== $col) ? PropelDateTime::newInstance($col, null, '\DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 16 + $startcol : CronDashboardProcessLogTableMap::translateFieldName('CreatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->created_at = (null !== $col) ? PropelDateTime::newInstance($col, null, '\DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 17 + $startcol : CronDashboardProcessLogTableMap::translateFieldName('UpdatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->updated_at = (null !== $col) ? PropelDateTime::newInstance($col, null, '\DateTime') : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 18; // 18 = CronDashboardProcessLogTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating \CronDashboard\Model\CronDashboardProcessLog object", 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(CronDashboardProcessLogTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildCronDashboardProcessLogQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
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
     * @see CronDashboardProcessLog::setDeleted()
     * @see CronDashboardProcessLog::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(CronDashboardProcessLogTableMap::DATABASE_NAME);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = ChildCronDashboardProcessLogQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(CronDashboardProcessLogTableMap::DATABASE_NAME);
        }

        $con->beginTransaction();
        $isInsert = $this->isNew();
        try {
            $ret = $this->preSave($con);
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
                // timestampable behavior
                if (!$this->isColumnModified(CronDashboardProcessLogTableMap::CREATED_AT)) {
                    $this->setCreatedAt(time());
                }
                if (!$this->isColumnModified(CronDashboardProcessLogTableMap::UPDATED_AT)) {
                    $this->setUpdatedAt(time());
                }
            } else {
                $ret = $ret && $this->preUpdate($con);
                // timestampable behavior
                if ($this->isModified() && !$this->isColumnModified(CronDashboardProcessLogTableMap::UPDATED_AT)) {
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
                CronDashboardProcessLogTableMap::addInstanceToPool($this);
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

        $this->modifiedColumns[CronDashboardProcessLogTableMap::ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . CronDashboardProcessLogTableMap::ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(CronDashboardProcessLogTableMap::ID)) {
            $modifiedColumns[':p' . $index++]  = 'ID';
        }
        if ($this->isColumnModified(CronDashboardProcessLogTableMap::LINUX_USER)) {
            $modifiedColumns[':p' . $index++]  = 'LINUX_USER';
        }
        if ($this->isColumnModified(CronDashboardProcessLogTableMap::LINUX_PID)) {
            $modifiedColumns[':p' . $index++]  = 'LINUX_PID';
        }
        if ($this->isColumnModified(CronDashboardProcessLogTableMap::PROCESS_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'PROCESS_NAME';
        }
        if ($this->isColumnModified(CronDashboardProcessLogTableMap::CPU)) {
            $modifiedColumns[':p' . $index++]  = 'CPU';
        }
        if ($this->isColumnModified(CronDashboardProcessLogTableMap::MEM)) {
            $modifiedColumns[':p' . $index++]  = 'MEM';
        }
        if ($this->isColumnModified(CronDashboardProcessLogTableMap::VSZ)) {
            $modifiedColumns[':p' . $index++]  = 'VSZ';
        }
        if ($this->isColumnModified(CronDashboardProcessLogTableMap::TTY)) {
            $modifiedColumns[':p' . $index++]  = 'TTY';
        }
        if ($this->isColumnModified(CronDashboardProcessLogTableMap::STAT)) {
            $modifiedColumns[':p' . $index++]  = 'STAT';
        }
        if ($this->isColumnModified(CronDashboardProcessLogTableMap::START)) {
            $modifiedColumns[':p' . $index++]  = 'START';
        }
        if ($this->isColumnModified(CronDashboardProcessLogTableMap::TIME)) {
            $modifiedColumns[':p' . $index++]  = 'TIME';
        }
        if ($this->isColumnModified(CronDashboardProcessLogTableMap::COMMAND)) {
            $modifiedColumns[':p' . $index++]  = 'COMMAND';
        }
        if ($this->isColumnModified(CronDashboardProcessLogTableMap::THELIA_USER_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'THELIA_USER_NAME';
        }
        if ($this->isColumnModified(CronDashboardProcessLogTableMap::THELIA_USER_ID)) {
            $modifiedColumns[':p' . $index++]  = 'THELIA_USER_ID';
        }
        if ($this->isColumnModified(CronDashboardProcessLogTableMap::ACTION_TRIGGERED)) {
            $modifiedColumns[':p' . $index++]  = 'ACTION_TRIGGERED';
        }
        if ($this->isColumnModified(CronDashboardProcessLogTableMap::TRIGGER_TIME)) {
            $modifiedColumns[':p' . $index++]  = 'TRIGGER_TIME';
        }
        if ($this->isColumnModified(CronDashboardProcessLogTableMap::CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'CREATED_AT';
        }
        if ($this->isColumnModified(CronDashboardProcessLogTableMap::UPDATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'UPDATED_AT';
        }

        $sql = sprintf(
            'INSERT INTO cron_dashboard_process_log (%s) VALUES (%s)',
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
                    case 'LINUX_USER':
                        $stmt->bindValue($identifier, $this->linux_user, PDO::PARAM_STR);
                        break;
                    case 'LINUX_PID':
                        $stmt->bindValue($identifier, $this->linux_pid, PDO::PARAM_INT);
                        break;
                    case 'PROCESS_NAME':
                        $stmt->bindValue($identifier, $this->process_name, PDO::PARAM_STR);
                        break;
                    case 'CPU':
                        $stmt->bindValue($identifier, $this->cpu, PDO::PARAM_STR);
                        break;
                    case 'MEM':
                        $stmt->bindValue($identifier, $this->mem, PDO::PARAM_STR);
                        break;
                    case 'VSZ':
                        $stmt->bindValue($identifier, $this->vsz, PDO::PARAM_STR);
                        break;
                    case 'TTY':
                        $stmt->bindValue($identifier, $this->tty, PDO::PARAM_STR);
                        break;
                    case 'STAT':
                        $stmt->bindValue($identifier, $this->stat, PDO::PARAM_STR);
                        break;
                    case 'START':
                        $stmt->bindValue($identifier, $this->start, PDO::PARAM_STR);
                        break;
                    case 'TIME':
                        $stmt->bindValue($identifier, $this->time, PDO::PARAM_STR);
                        break;
                    case 'COMMAND':
                        $stmt->bindValue($identifier, $this->command, PDO::PARAM_STR);
                        break;
                    case 'THELIA_USER_NAME':
                        $stmt->bindValue($identifier, $this->thelia_user_name, PDO::PARAM_STR);
                        break;
                    case 'THELIA_USER_ID':
                        $stmt->bindValue($identifier, $this->thelia_user_id, PDO::PARAM_INT);
                        break;
                    case 'ACTION_TRIGGERED':
                        $stmt->bindValue($identifier, $this->action_triggered, PDO::PARAM_STR);
                        break;
                    case 'TRIGGER_TIME':
                        $stmt->bindValue($identifier, $this->trigger_time ? $this->trigger_time->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
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
        $pos = CronDashboardProcessLogTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getLinuxUser();
                break;
            case 2:
                return $this->getLinuxPid();
                break;
            case 3:
                return $this->getProcessName();
                break;
            case 4:
                return $this->getCpu();
                break;
            case 5:
                return $this->getMem();
                break;
            case 6:
                return $this->getVsz();
                break;
            case 7:
                return $this->getTty();
                break;
            case 8:
                return $this->getStat();
                break;
            case 9:
                return $this->getStart();
                break;
            case 10:
                return $this->getTime();
                break;
            case 11:
                return $this->getCommand();
                break;
            case 12:
                return $this->getTheliaUserName();
                break;
            case 13:
                return $this->getTheliaUserId();
                break;
            case 14:
                return $this->getActionTriggered();
                break;
            case 15:
                return $this->getTriggerTime();
                break;
            case 16:
                return $this->getCreatedAt();
                break;
            case 17:
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
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = TableMap::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array())
    {
        if (isset($alreadyDumpedObjects['CronDashboardProcessLog'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['CronDashboardProcessLog'][$this->getPrimaryKey()] = true;
        $keys = CronDashboardProcessLogTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getLinuxUser(),
            $keys[2] => $this->getLinuxPid(),
            $keys[3] => $this->getProcessName(),
            $keys[4] => $this->getCpu(),
            $keys[5] => $this->getMem(),
            $keys[6] => $this->getVsz(),
            $keys[7] => $this->getTty(),
            $keys[8] => $this->getStat(),
            $keys[9] => $this->getStart(),
            $keys[10] => $this->getTime(),
            $keys[11] => $this->getCommand(),
            $keys[12] => $this->getTheliaUserName(),
            $keys[13] => $this->getTheliaUserId(),
            $keys[14] => $this->getActionTriggered(),
            $keys[15] => $this->getTriggerTime(),
            $keys[16] => $this->getCreatedAt(),
            $keys[17] => $this->getUpdatedAt(),
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
        $pos = CronDashboardProcessLogTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

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
                $this->setLinuxUser($value);
                break;
            case 2:
                $this->setLinuxPid($value);
                break;
            case 3:
                $this->setProcessName($value);
                break;
            case 4:
                $this->setCpu($value);
                break;
            case 5:
                $this->setMem($value);
                break;
            case 6:
                $this->setVsz($value);
                break;
            case 7:
                $this->setTty($value);
                break;
            case 8:
                $this->setStat($value);
                break;
            case 9:
                $this->setStart($value);
                break;
            case 10:
                $this->setTime($value);
                break;
            case 11:
                $this->setCommand($value);
                break;
            case 12:
                $this->setTheliaUserName($value);
                break;
            case 13:
                $this->setTheliaUserId($value);
                break;
            case 14:
                $this->setActionTriggered($value);
                break;
            case 15:
                $this->setTriggerTime($value);
                break;
            case 16:
                $this->setCreatedAt($value);
                break;
            case 17:
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
        $keys = CronDashboardProcessLogTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setLinuxUser($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setLinuxPid($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setProcessName($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setCpu($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setMem($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setVsz($arr[$keys[6]]);
        if (array_key_exists($keys[7], $arr)) $this->setTty($arr[$keys[7]]);
        if (array_key_exists($keys[8], $arr)) $this->setStat($arr[$keys[8]]);
        if (array_key_exists($keys[9], $arr)) $this->setStart($arr[$keys[9]]);
        if (array_key_exists($keys[10], $arr)) $this->setTime($arr[$keys[10]]);
        if (array_key_exists($keys[11], $arr)) $this->setCommand($arr[$keys[11]]);
        if (array_key_exists($keys[12], $arr)) $this->setTheliaUserName($arr[$keys[12]]);
        if (array_key_exists($keys[13], $arr)) $this->setTheliaUserId($arr[$keys[13]]);
        if (array_key_exists($keys[14], $arr)) $this->setActionTriggered($arr[$keys[14]]);
        if (array_key_exists($keys[15], $arr)) $this->setTriggerTime($arr[$keys[15]]);
        if (array_key_exists($keys[16], $arr)) $this->setCreatedAt($arr[$keys[16]]);
        if (array_key_exists($keys[17], $arr)) $this->setUpdatedAt($arr[$keys[17]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(CronDashboardProcessLogTableMap::DATABASE_NAME);

        if ($this->isColumnModified(CronDashboardProcessLogTableMap::ID)) $criteria->add(CronDashboardProcessLogTableMap::ID, $this->id);
        if ($this->isColumnModified(CronDashboardProcessLogTableMap::LINUX_USER)) $criteria->add(CronDashboardProcessLogTableMap::LINUX_USER, $this->linux_user);
        if ($this->isColumnModified(CronDashboardProcessLogTableMap::LINUX_PID)) $criteria->add(CronDashboardProcessLogTableMap::LINUX_PID, $this->linux_pid);
        if ($this->isColumnModified(CronDashboardProcessLogTableMap::PROCESS_NAME)) $criteria->add(CronDashboardProcessLogTableMap::PROCESS_NAME, $this->process_name);
        if ($this->isColumnModified(CronDashboardProcessLogTableMap::CPU)) $criteria->add(CronDashboardProcessLogTableMap::CPU, $this->cpu);
        if ($this->isColumnModified(CronDashboardProcessLogTableMap::MEM)) $criteria->add(CronDashboardProcessLogTableMap::MEM, $this->mem);
        if ($this->isColumnModified(CronDashboardProcessLogTableMap::VSZ)) $criteria->add(CronDashboardProcessLogTableMap::VSZ, $this->vsz);
        if ($this->isColumnModified(CronDashboardProcessLogTableMap::TTY)) $criteria->add(CronDashboardProcessLogTableMap::TTY, $this->tty);
        if ($this->isColumnModified(CronDashboardProcessLogTableMap::STAT)) $criteria->add(CronDashboardProcessLogTableMap::STAT, $this->stat);
        if ($this->isColumnModified(CronDashboardProcessLogTableMap::START)) $criteria->add(CronDashboardProcessLogTableMap::START, $this->start);
        if ($this->isColumnModified(CronDashboardProcessLogTableMap::TIME)) $criteria->add(CronDashboardProcessLogTableMap::TIME, $this->time);
        if ($this->isColumnModified(CronDashboardProcessLogTableMap::COMMAND)) $criteria->add(CronDashboardProcessLogTableMap::COMMAND, $this->command);
        if ($this->isColumnModified(CronDashboardProcessLogTableMap::THELIA_USER_NAME)) $criteria->add(CronDashboardProcessLogTableMap::THELIA_USER_NAME, $this->thelia_user_name);
        if ($this->isColumnModified(CronDashboardProcessLogTableMap::THELIA_USER_ID)) $criteria->add(CronDashboardProcessLogTableMap::THELIA_USER_ID, $this->thelia_user_id);
        if ($this->isColumnModified(CronDashboardProcessLogTableMap::ACTION_TRIGGERED)) $criteria->add(CronDashboardProcessLogTableMap::ACTION_TRIGGERED, $this->action_triggered);
        if ($this->isColumnModified(CronDashboardProcessLogTableMap::TRIGGER_TIME)) $criteria->add(CronDashboardProcessLogTableMap::TRIGGER_TIME, $this->trigger_time);
        if ($this->isColumnModified(CronDashboardProcessLogTableMap::CREATED_AT)) $criteria->add(CronDashboardProcessLogTableMap::CREATED_AT, $this->created_at);
        if ($this->isColumnModified(CronDashboardProcessLogTableMap::UPDATED_AT)) $criteria->add(CronDashboardProcessLogTableMap::UPDATED_AT, $this->updated_at);

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
        $criteria = new Criteria(CronDashboardProcessLogTableMap::DATABASE_NAME);
        $criteria->add(CronDashboardProcessLogTableMap::ID, $this->id);

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
     * @param      object $copyObj An object of \CronDashboard\Model\CronDashboardProcessLog (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setLinuxUser($this->getLinuxUser());
        $copyObj->setLinuxPid($this->getLinuxPid());
        $copyObj->setProcessName($this->getProcessName());
        $copyObj->setCpu($this->getCpu());
        $copyObj->setMem($this->getMem());
        $copyObj->setVsz($this->getVsz());
        $copyObj->setTty($this->getTty());
        $copyObj->setStat($this->getStat());
        $copyObj->setStart($this->getStart());
        $copyObj->setTime($this->getTime());
        $copyObj->setCommand($this->getCommand());
        $copyObj->setTheliaUserName($this->getTheliaUserName());
        $copyObj->setTheliaUserId($this->getTheliaUserId());
        $copyObj->setActionTriggered($this->getActionTriggered());
        $copyObj->setTriggerTime($this->getTriggerTime());
        $copyObj->setCreatedAt($this->getCreatedAt());
        $copyObj->setUpdatedAt($this->getUpdatedAt());
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
     * @return                 \CronDashboard\Model\CronDashboardProcessLog Clone of current object.
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
        $this->linux_user = null;
        $this->linux_pid = null;
        $this->process_name = null;
        $this->cpu = null;
        $this->mem = null;
        $this->vsz = null;
        $this->tty = null;
        $this->stat = null;
        $this->start = null;
        $this->time = null;
        $this->command = null;
        $this->thelia_user_name = null;
        $this->thelia_user_id = null;
        $this->action_triggered = null;
        $this->trigger_time = null;
        $this->created_at = null;
        $this->updated_at = null;
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

    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(CronDashboardProcessLogTableMap::DEFAULT_STRING_FORMAT);
    }

    // timestampable behavior

    /**
     * Mark the current object so that the update date doesn't get updated during next save
     *
     * @return     ChildCronDashboardProcessLog The current object (for fluent API support)
     */
    public function keepUpdateDateUnchanged()
    {
        $this->modifiedColumns[CronDashboardProcessLogTableMap::UPDATED_AT] = true;

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
