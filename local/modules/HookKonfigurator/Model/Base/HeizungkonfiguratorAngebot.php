<?php

namespace HookKonfigurator\Model\Base;

use \DateTime;
use \Exception;
use \PDO;
use HookKonfigurator\Model\HeizungkonfiguratorAngebotQuery as ChildHeizungkonfiguratorAngebotQuery;
use HookKonfigurator\Model\Map\HeizungkonfiguratorAngebotTableMap;
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

abstract class HeizungkonfiguratorAngebot implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\HookKonfigurator\\Model\\Map\\HeizungkonfiguratorAngebotTableMap';


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
     * The value for the user_id field.
     * @var        int
     */
    protected $user_id;

    /**
     * The value for the plan_heizung field.
     * @var        string
     */
    protected $plan_heizung;

    /**
     * The value for the brennstoff_zukunft field.
     * @var        string
     */
    protected $brennstoff_zukunft;

    /**
     * The value for the gebaeudeart field.
     * @var        string
     */
    protected $gebaeudeart;

    /**
     * The value for the baujahr field.
     * @var        int
     */
    protected $baujahr;

    /**
     * The value for the building_etagen field.
     * @var        int
     */
    protected $building_etagen;

    /**
     * The value for the flaeche field.
     * @var        int
     */
    protected $flaeche;

    /**
     * The value for the personen_anzahl field.
     * @var        int
     */
    protected $personen_anzahl;

    /**
     * The value for the wohnraumtemperatur field.
     * @var        int
     */
    protected $wohnraumtemperatur;

    /**
     * The value for the aussentemperatur field.
     * @var        int
     */
    protected $aussentemperatur;

    /**
     * The value for the waermedaemmung field.
     * @var        string
     */
    protected $waermedaemmung;

    /**
     * The value for the verglaste_fenster field.
     * @var        string
     */
    protected $verglaste_fenster;

    /**
     * The value for the dach_daemmung field.
     * @var        string
     */
    protected $dach_daemmung;

    /**
     * The value for the gebaeudelage field.
     * @var        string
     */
    protected $gebaeudelage;

    /**
     * The value for the windlage field.
     * @var        string
     */
    protected $windlage;

    /**
     * The value for the anzahl_aussenwaende field.
     * @var        int
     */
    protected $anzahl_aussenwaende;

    /**
     * The value for the abgasfuehrung field.
     * @var        string
     */
    protected $abgasfuehrung;

    /**
     * The value for the heizungsmethode field.
     * @var        string
     */
    protected $heizungsmethode;

    /**
     * The value for the warmwasserversorgung field.
     * @var        string
     */
    protected $warmwasserversorgung;

    /**
     * The value for the wasserabfluss field.
     * @var        string
     */
    protected $wasserabfluss;

    /**
     * The value for the solaranlage field.
     * @var        string
     */
    protected $solaranlage;

    /**
     * The value for the solaranlageextra field.
     * @var        string
     */
    protected $solaranlageextra;

    /**
     * The value for the photovoltaik field.
     * @var        string
     */
    protected $photovoltaik;

    /**
     * The value for the anmerkungen field.
     * @var        string
     */
    protected $anmerkungen;

    /**
     * The value for the version field.
     * @var        string
     */
    protected $version;

    /**
     * The value for the created_at field.
     * @var        string
     */
    protected $created_at;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * Initializes internal state of HookKonfigurator\Model\Base\HeizungkonfiguratorAngebot object.
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
     * Compares this with another <code>HeizungkonfiguratorAngebot</code> instance.  If
     * <code>obj</code> is an instance of <code>HeizungkonfiguratorAngebot</code>, delegates to
     * <code>equals(HeizungkonfiguratorAngebot)</code>.  Otherwise, returns <code>false</code>.
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
     * @return HeizungkonfiguratorAngebot The current object, for fluid interface
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
     * @return HeizungkonfiguratorAngebot The current object, for fluid interface
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
     * Get the [user_id] column value.
     *
     * @return   int
     */
    public function getUserId()
    {

        return $this->user_id;
    }

    /**
     * Get the [plan_heizung] column value.
     *
     * @return   string
     */
    public function getPlanHeizung()
    {

        return $this->plan_heizung;
    }

    /**
     * Get the [brennstoff_zukunft] column value.
     *
     * @return   string
     */
    public function getBrennstoffZukunft()
    {

        return $this->brennstoff_zukunft;
    }

    /**
     * Get the [gebaeudeart] column value.
     *
     * @return   string
     */
    public function getGebaeudeart()
    {

        return $this->gebaeudeart;
    }

    /**
     * Get the [baujahr] column value.
     *
     * @return   int
     */
    public function getBaujahr()
    {

        return $this->baujahr;
    }

    /**
     * Get the [building_etagen] column value.
     *
     * @return   int
     */
    public function getBuildingEtagen()
    {

        return $this->building_etagen;
    }

    /**
     * Get the [flaeche] column value.
     *
     * @return   int
     */
    public function getFlaeche()
    {

        return $this->flaeche;
    }

    /**
     * Get the [personen_anzahl] column value.
     *
     * @return   int
     */
    public function getPersonenAnzahl()
    {

        return $this->personen_anzahl;
    }

    /**
     * Get the [wohnraumtemperatur] column value.
     *
     * @return   int
     */
    public function getWohnraumtemperatur()
    {

        return $this->wohnraumtemperatur;
    }

    /**
     * Get the [aussentemperatur] column value.
     *
     * @return   int
     */
    public function getAussentemperatur()
    {

        return $this->aussentemperatur;
    }

    /**
     * Get the [waermedaemmung] column value.
     *
     * @return   string
     */
    public function getWaermedaemmung()
    {

        return $this->waermedaemmung;
    }

    /**
     * Get the [verglaste_fenster] column value.
     *
     * @return   string
     */
    public function getVerglasteFenster()
    {

        return $this->verglaste_fenster;
    }

    /**
     * Get the [dach_daemmung] column value.
     *
     * @return   string
     */
    public function getDachDaemmung()
    {

        return $this->dach_daemmung;
    }

    /**
     * Get the [gebaeudelage] column value.
     *
     * @return   string
     */
    public function getGebaeudelage()
    {

        return $this->gebaeudelage;
    }

    /**
     * Get the [windlage] column value.
     *
     * @return   string
     */
    public function getWindlage()
    {

        return $this->windlage;
    }

    /**
     * Get the [anzahl_aussenwaende] column value.
     *
     * @return   int
     */
    public function getAnzahlAussenwaende()
    {

        return $this->anzahl_aussenwaende;
    }

    /**
     * Get the [abgasfuehrung] column value.
     *
     * @return   string
     */
    public function getAbgasfuehrung()
    {

        return $this->abgasfuehrung;
    }

    /**
     * Get the [heizungsmethode] column value.
     *
     * @return   string
     */
    public function getHeizungsmethode()
    {

        return $this->heizungsmethode;
    }

    /**
     * Get the [warmwasserversorgung] column value.
     *
     * @return   string
     */
    public function getWarmwasserversorgung()
    {

        return $this->warmwasserversorgung;
    }

    /**
     * Get the [wasserabfluss] column value.
     *
     * @return   string
     */
    public function getWasserabfluss()
    {

        return $this->wasserabfluss;
    }

    /**
     * Get the [solaranlage] column value.
     *
     * @return   string
     */
    public function getSolaranlage()
    {

        return $this->solaranlage;
    }

    /**
     * Get the [solaranlageextra] column value.
     *
     * @return   string
     */
    public function getSolaranlageextra()
    {

        return $this->solaranlageextra;
    }

    /**
     * Get the [photovoltaik] column value.
     *
     * @return   string
     */
    public function getPhotovoltaik()
    {

        return $this->photovoltaik;
    }

    /**
     * Get the [anmerkungen] column value.
     *
     * @return   string
     */
    public function getAnmerkungen()
    {

        return $this->anmerkungen;
    }

    /**
     * Get the [version] column value.
     *
     * @return   string
     */
    public function getVersion()
    {

        return $this->version;
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
     * Set the value of [id] column.
     *
     * @param      int $v new value
     * @return   \HookKonfigurator\Model\HeizungkonfiguratorAngebot The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[HeizungkonfiguratorAngebotTableMap::ID] = true;
        }


        return $this;
    } // setId()

    /**
     * Set the value of [user_id] column.
     *
     * @param      int $v new value
     * @return   \HookKonfigurator\Model\HeizungkonfiguratorAngebot The current object (for fluent API support)
     */
    public function setUserId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->user_id !== $v) {
            $this->user_id = $v;
            $this->modifiedColumns[HeizungkonfiguratorAngebotTableMap::USER_ID] = true;
        }


        return $this;
    } // setUserId()

    /**
     * Set the value of [plan_heizung] column.
     *
     * @param      string $v new value
     * @return   \HookKonfigurator\Model\HeizungkonfiguratorAngebot The current object (for fluent API support)
     */
    public function setPlanHeizung($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->plan_heizung !== $v) {
            $this->plan_heizung = $v;
            $this->modifiedColumns[HeizungkonfiguratorAngebotTableMap::PLAN_HEIZUNG] = true;
        }


        return $this;
    } // setPlanHeizung()

    /**
     * Set the value of [brennstoff_zukunft] column.
     *
     * @param      string $v new value
     * @return   \HookKonfigurator\Model\HeizungkonfiguratorAngebot The current object (for fluent API support)
     */
    public function setBrennstoffZukunft($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->brennstoff_zukunft !== $v) {
            $this->brennstoff_zukunft = $v;
            $this->modifiedColumns[HeizungkonfiguratorAngebotTableMap::BRENNSTOFF_ZUKUNFT] = true;
        }


        return $this;
    } // setBrennstoffZukunft()

    /**
     * Set the value of [gebaeudeart] column.
     *
     * @param      string $v new value
     * @return   \HookKonfigurator\Model\HeizungkonfiguratorAngebot The current object (for fluent API support)
     */
    public function setGebaeudeart($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->gebaeudeart !== $v) {
            $this->gebaeudeart = $v;
            $this->modifiedColumns[HeizungkonfiguratorAngebotTableMap::GEBAEUDEART] = true;
        }


        return $this;
    } // setGebaeudeart()

    /**
     * Set the value of [baujahr] column.
     *
     * @param      int $v new value
     * @return   \HookKonfigurator\Model\HeizungkonfiguratorAngebot The current object (for fluent API support)
     */
    public function setBaujahr($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->baujahr !== $v) {
            $this->baujahr = $v;
            $this->modifiedColumns[HeizungkonfiguratorAngebotTableMap::BAUJAHR] = true;
        }


        return $this;
    } // setBaujahr()

    /**
     * Set the value of [building_etagen] column.
     *
     * @param      int $v new value
     * @return   \HookKonfigurator\Model\HeizungkonfiguratorAngebot The current object (for fluent API support)
     */
    public function setBuildingEtagen($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->building_etagen !== $v) {
            $this->building_etagen = $v;
            $this->modifiedColumns[HeizungkonfiguratorAngebotTableMap::BUILDING_ETAGEN] = true;
        }


        return $this;
    } // setBuildingEtagen()

    /**
     * Set the value of [flaeche] column.
     *
     * @param      int $v new value
     * @return   \HookKonfigurator\Model\HeizungkonfiguratorAngebot The current object (for fluent API support)
     */
    public function setFlaeche($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->flaeche !== $v) {
            $this->flaeche = $v;
            $this->modifiedColumns[HeizungkonfiguratorAngebotTableMap::FLAECHE] = true;
        }


        return $this;
    } // setFlaeche()

    /**
     * Set the value of [personen_anzahl] column.
     *
     * @param      int $v new value
     * @return   \HookKonfigurator\Model\HeizungkonfiguratorAngebot The current object (for fluent API support)
     */
    public function setPersonenAnzahl($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->personen_anzahl !== $v) {
            $this->personen_anzahl = $v;
            $this->modifiedColumns[HeizungkonfiguratorAngebotTableMap::PERSONEN_ANZAHL] = true;
        }


        return $this;
    } // setPersonenAnzahl()

    /**
     * Set the value of [wohnraumtemperatur] column.
     *
     * @param      int $v new value
     * @return   \HookKonfigurator\Model\HeizungkonfiguratorAngebot The current object (for fluent API support)
     */
    public function setWohnraumtemperatur($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->wohnraumtemperatur !== $v) {
            $this->wohnraumtemperatur = $v;
            $this->modifiedColumns[HeizungkonfiguratorAngebotTableMap::WOHNRAUMTEMPERATUR] = true;
        }


        return $this;
    } // setWohnraumtemperatur()

    /**
     * Set the value of [aussentemperatur] column.
     *
     * @param      int $v new value
     * @return   \HookKonfigurator\Model\HeizungkonfiguratorAngebot The current object (for fluent API support)
     */
    public function setAussentemperatur($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->aussentemperatur !== $v) {
            $this->aussentemperatur = $v;
            $this->modifiedColumns[HeizungkonfiguratorAngebotTableMap::AUSSENTEMPERATUR] = true;
        }


        return $this;
    } // setAussentemperatur()

    /**
     * Set the value of [waermedaemmung] column.
     *
     * @param      string $v new value
     * @return   \HookKonfigurator\Model\HeizungkonfiguratorAngebot The current object (for fluent API support)
     */
    public function setWaermedaemmung($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->waermedaemmung !== $v) {
            $this->waermedaemmung = $v;
            $this->modifiedColumns[HeizungkonfiguratorAngebotTableMap::WAERMEDAEMMUNG] = true;
        }


        return $this;
    } // setWaermedaemmung()

    /**
     * Set the value of [verglaste_fenster] column.
     *
     * @param      string $v new value
     * @return   \HookKonfigurator\Model\HeizungkonfiguratorAngebot The current object (for fluent API support)
     */
    public function setVerglasteFenster($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->verglaste_fenster !== $v) {
            $this->verglaste_fenster = $v;
            $this->modifiedColumns[HeizungkonfiguratorAngebotTableMap::VERGLASTE_FENSTER] = true;
        }


        return $this;
    } // setVerglasteFenster()

    /**
     * Set the value of [dach_daemmung] column.
     *
     * @param      string $v new value
     * @return   \HookKonfigurator\Model\HeizungkonfiguratorAngebot The current object (for fluent API support)
     */
    public function setDachDaemmung($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->dach_daemmung !== $v) {
            $this->dach_daemmung = $v;
            $this->modifiedColumns[HeizungkonfiguratorAngebotTableMap::DACH_DAEMMUNG] = true;
        }


        return $this;
    } // setDachDaemmung()

    /**
     * Set the value of [gebaeudelage] column.
     *
     * @param      string $v new value
     * @return   \HookKonfigurator\Model\HeizungkonfiguratorAngebot The current object (for fluent API support)
     */
    public function setGebaeudelage($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->gebaeudelage !== $v) {
            $this->gebaeudelage = $v;
            $this->modifiedColumns[HeizungkonfiguratorAngebotTableMap::GEBAEUDELAGE] = true;
        }


        return $this;
    } // setGebaeudelage()

    /**
     * Set the value of [windlage] column.
     *
     * @param      string $v new value
     * @return   \HookKonfigurator\Model\HeizungkonfiguratorAngebot The current object (for fluent API support)
     */
    public function setWindlage($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->windlage !== $v) {
            $this->windlage = $v;
            $this->modifiedColumns[HeizungkonfiguratorAngebotTableMap::WINDLAGE] = true;
        }


        return $this;
    } // setWindlage()

    /**
     * Set the value of [anzahl_aussenwaende] column.
     *
     * @param      int $v new value
     * @return   \HookKonfigurator\Model\HeizungkonfiguratorAngebot The current object (for fluent API support)
     */
    public function setAnzahlAussenwaende($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->anzahl_aussenwaende !== $v) {
            $this->anzahl_aussenwaende = $v;
            $this->modifiedColumns[HeizungkonfiguratorAngebotTableMap::ANZAHL_AUSSENWAENDE] = true;
        }


        return $this;
    } // setAnzahlAussenwaende()

    /**
     * Set the value of [abgasfuehrung] column.
     *
     * @param      string $v new value
     * @return   \HookKonfigurator\Model\HeizungkonfiguratorAngebot The current object (for fluent API support)
     */
    public function setAbgasfuehrung($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->abgasfuehrung !== $v) {
            $this->abgasfuehrung = $v;
            $this->modifiedColumns[HeizungkonfiguratorAngebotTableMap::ABGASFUEHRUNG] = true;
        }


        return $this;
    } // setAbgasfuehrung()

    /**
     * Set the value of [heizungsmethode] column.
     *
     * @param      string $v new value
     * @return   \HookKonfigurator\Model\HeizungkonfiguratorAngebot The current object (for fluent API support)
     */
    public function setHeizungsmethode($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->heizungsmethode !== $v) {
            $this->heizungsmethode = $v;
            $this->modifiedColumns[HeizungkonfiguratorAngebotTableMap::HEIZUNGSMETHODE] = true;
        }


        return $this;
    } // setHeizungsmethode()

    /**
     * Set the value of [warmwasserversorgung] column.
     *
     * @param      string $v new value
     * @return   \HookKonfigurator\Model\HeizungkonfiguratorAngebot The current object (for fluent API support)
     */
    public function setWarmwasserversorgung($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->warmwasserversorgung !== $v) {
            $this->warmwasserversorgung = $v;
            $this->modifiedColumns[HeizungkonfiguratorAngebotTableMap::WARMWASSERVERSORGUNG] = true;
        }


        return $this;
    } // setWarmwasserversorgung()

    /**
     * Set the value of [wasserabfluss] column.
     *
     * @param      string $v new value
     * @return   \HookKonfigurator\Model\HeizungkonfiguratorAngebot The current object (for fluent API support)
     */
    public function setWasserabfluss($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->wasserabfluss !== $v) {
            $this->wasserabfluss = $v;
            $this->modifiedColumns[HeizungkonfiguratorAngebotTableMap::WASSERABFLUSS] = true;
        }


        return $this;
    } // setWasserabfluss()

    /**
     * Set the value of [solaranlage] column.
     *
     * @param      string $v new value
     * @return   \HookKonfigurator\Model\HeizungkonfiguratorAngebot The current object (for fluent API support)
     */
    public function setSolaranlage($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->solaranlage !== $v) {
            $this->solaranlage = $v;
            $this->modifiedColumns[HeizungkonfiguratorAngebotTableMap::SOLARANLAGE] = true;
        }


        return $this;
    } // setSolaranlage()

    /**
     * Set the value of [solaranlageextra] column.
     *
     * @param      string $v new value
     * @return   \HookKonfigurator\Model\HeizungkonfiguratorAngebot The current object (for fluent API support)
     */
    public function setSolaranlageextra($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->solaranlageextra !== $v) {
            $this->solaranlageextra = $v;
            $this->modifiedColumns[HeizungkonfiguratorAngebotTableMap::SOLARANLAGEEXTRA] = true;
        }


        return $this;
    } // setSolaranlageextra()

    /**
     * Set the value of [photovoltaik] column.
     *
     * @param      string $v new value
     * @return   \HookKonfigurator\Model\HeizungkonfiguratorAngebot The current object (for fluent API support)
     */
    public function setPhotovoltaik($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->photovoltaik !== $v) {
            $this->photovoltaik = $v;
            $this->modifiedColumns[HeizungkonfiguratorAngebotTableMap::PHOTOVOLTAIK] = true;
        }


        return $this;
    } // setPhotovoltaik()

    /**
     * Set the value of [anmerkungen] column.
     *
     * @param      string $v new value
     * @return   \HookKonfigurator\Model\HeizungkonfiguratorAngebot The current object (for fluent API support)
     */
    public function setAnmerkungen($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->anmerkungen !== $v) {
            $this->anmerkungen = $v;
            $this->modifiedColumns[HeizungkonfiguratorAngebotTableMap::ANMERKUNGEN] = true;
        }


        return $this;
    } // setAnmerkungen()

    /**
     * Set the value of [version] column.
     *
     * @param      string $v new value
     * @return   \HookKonfigurator\Model\HeizungkonfiguratorAngebot The current object (for fluent API support)
     */
    public function setVersion($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->version !== $v) {
            $this->version = $v;
            $this->modifiedColumns[HeizungkonfiguratorAngebotTableMap::VERSION] = true;
        }


        return $this;
    } // setVersion()

    /**
     * Sets the value of [created_at] column to a normalized version of the date/time value specified.
     *
     * @param      mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return   \HookKonfigurator\Model\HeizungkonfiguratorAngebot The current object (for fluent API support)
     */
    public function setCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->created_at !== null || $dt !== null) {
            if ($dt !== $this->created_at) {
                $this->created_at = $dt;
                $this->modifiedColumns[HeizungkonfiguratorAngebotTableMap::CREATED_AT] = true;
            }
        } // if either are not null


        return $this;
    } // setCreatedAt()

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


            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : HeizungkonfiguratorAngebotTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : HeizungkonfiguratorAngebotTableMap::translateFieldName('UserId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->user_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : HeizungkonfiguratorAngebotTableMap::translateFieldName('PlanHeizung', TableMap::TYPE_PHPNAME, $indexType)];
            $this->plan_heizung = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : HeizungkonfiguratorAngebotTableMap::translateFieldName('BrennstoffZukunft', TableMap::TYPE_PHPNAME, $indexType)];
            $this->brennstoff_zukunft = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : HeizungkonfiguratorAngebotTableMap::translateFieldName('Gebaeudeart', TableMap::TYPE_PHPNAME, $indexType)];
            $this->gebaeudeart = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : HeizungkonfiguratorAngebotTableMap::translateFieldName('Baujahr', TableMap::TYPE_PHPNAME, $indexType)];
            $this->baujahr = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : HeizungkonfiguratorAngebotTableMap::translateFieldName('BuildingEtagen', TableMap::TYPE_PHPNAME, $indexType)];
            $this->building_etagen = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : HeizungkonfiguratorAngebotTableMap::translateFieldName('Flaeche', TableMap::TYPE_PHPNAME, $indexType)];
            $this->flaeche = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : HeizungkonfiguratorAngebotTableMap::translateFieldName('PersonenAnzahl', TableMap::TYPE_PHPNAME, $indexType)];
            $this->personen_anzahl = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : HeizungkonfiguratorAngebotTableMap::translateFieldName('Wohnraumtemperatur', TableMap::TYPE_PHPNAME, $indexType)];
            $this->wohnraumtemperatur = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 10 + $startcol : HeizungkonfiguratorAngebotTableMap::translateFieldName('Aussentemperatur', TableMap::TYPE_PHPNAME, $indexType)];
            $this->aussentemperatur = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 11 + $startcol : HeizungkonfiguratorAngebotTableMap::translateFieldName('Waermedaemmung', TableMap::TYPE_PHPNAME, $indexType)];
            $this->waermedaemmung = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 12 + $startcol : HeizungkonfiguratorAngebotTableMap::translateFieldName('VerglasteFenster', TableMap::TYPE_PHPNAME, $indexType)];
            $this->verglaste_fenster = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 13 + $startcol : HeizungkonfiguratorAngebotTableMap::translateFieldName('DachDaemmung', TableMap::TYPE_PHPNAME, $indexType)];
            $this->dach_daemmung = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 14 + $startcol : HeizungkonfiguratorAngebotTableMap::translateFieldName('Gebaeudelage', TableMap::TYPE_PHPNAME, $indexType)];
            $this->gebaeudelage = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 15 + $startcol : HeizungkonfiguratorAngebotTableMap::translateFieldName('Windlage', TableMap::TYPE_PHPNAME, $indexType)];
            $this->windlage = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 16 + $startcol : HeizungkonfiguratorAngebotTableMap::translateFieldName('AnzahlAussenwaende', TableMap::TYPE_PHPNAME, $indexType)];
            $this->anzahl_aussenwaende = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 17 + $startcol : HeizungkonfiguratorAngebotTableMap::translateFieldName('Abgasfuehrung', TableMap::TYPE_PHPNAME, $indexType)];
            $this->abgasfuehrung = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 18 + $startcol : HeizungkonfiguratorAngebotTableMap::translateFieldName('Heizungsmethode', TableMap::TYPE_PHPNAME, $indexType)];
            $this->heizungsmethode = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 19 + $startcol : HeizungkonfiguratorAngebotTableMap::translateFieldName('Warmwasserversorgung', TableMap::TYPE_PHPNAME, $indexType)];
            $this->warmwasserversorgung = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 20 + $startcol : HeizungkonfiguratorAngebotTableMap::translateFieldName('Wasserabfluss', TableMap::TYPE_PHPNAME, $indexType)];
            $this->wasserabfluss = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 21 + $startcol : HeizungkonfiguratorAngebotTableMap::translateFieldName('Solaranlage', TableMap::TYPE_PHPNAME, $indexType)];
            $this->solaranlage = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 22 + $startcol : HeizungkonfiguratorAngebotTableMap::translateFieldName('Solaranlageextra', TableMap::TYPE_PHPNAME, $indexType)];
            $this->solaranlageextra = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 23 + $startcol : HeizungkonfiguratorAngebotTableMap::translateFieldName('Photovoltaik', TableMap::TYPE_PHPNAME, $indexType)];
            $this->photovoltaik = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 24 + $startcol : HeizungkonfiguratorAngebotTableMap::translateFieldName('Anmerkungen', TableMap::TYPE_PHPNAME, $indexType)];
            $this->anmerkungen = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 25 + $startcol : HeizungkonfiguratorAngebotTableMap::translateFieldName('Version', TableMap::TYPE_PHPNAME, $indexType)];
            $this->version = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 26 + $startcol : HeizungkonfiguratorAngebotTableMap::translateFieldName('CreatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->created_at = (null !== $col) ? PropelDateTime::newInstance($col, null, '\DateTime') : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 27; // 27 = HeizungkonfiguratorAngebotTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating \HookKonfigurator\Model\HeizungkonfiguratorAngebot object", 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(HeizungkonfiguratorAngebotTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildHeizungkonfiguratorAngebotQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
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
     * @see HeizungkonfiguratorAngebot::setDeleted()
     * @see HeizungkonfiguratorAngebot::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(HeizungkonfiguratorAngebotTableMap::DATABASE_NAME);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = ChildHeizungkonfiguratorAngebotQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(HeizungkonfiguratorAngebotTableMap::DATABASE_NAME);
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
                HeizungkonfiguratorAngebotTableMap::addInstanceToPool($this);
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

        $this->modifiedColumns[HeizungkonfiguratorAngebotTableMap::ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . HeizungkonfiguratorAngebotTableMap::ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(HeizungkonfiguratorAngebotTableMap::ID)) {
            $modifiedColumns[':p' . $index++]  = 'ID';
        }
        if ($this->isColumnModified(HeizungkonfiguratorAngebotTableMap::USER_ID)) {
            $modifiedColumns[':p' . $index++]  = 'USER_ID';
        }
        if ($this->isColumnModified(HeizungkonfiguratorAngebotTableMap::PLAN_HEIZUNG)) {
            $modifiedColumns[':p' . $index++]  = 'PLAN_HEIZUNG';
        }
        if ($this->isColumnModified(HeizungkonfiguratorAngebotTableMap::BRENNSTOFF_ZUKUNFT)) {
            $modifiedColumns[':p' . $index++]  = 'BRENNSTOFF_ZUKUNFT';
        }
        if ($this->isColumnModified(HeizungkonfiguratorAngebotTableMap::GEBAEUDEART)) {
            $modifiedColumns[':p' . $index++]  = 'GEBAEUDEART';
        }
        if ($this->isColumnModified(HeizungkonfiguratorAngebotTableMap::BAUJAHR)) {
            $modifiedColumns[':p' . $index++]  = 'BAUJAHR';
        }
        if ($this->isColumnModified(HeizungkonfiguratorAngebotTableMap::BUILDING_ETAGEN)) {
            $modifiedColumns[':p' . $index++]  = 'BUILDING_ETAGEN';
        }
        if ($this->isColumnModified(HeizungkonfiguratorAngebotTableMap::FLAECHE)) {
            $modifiedColumns[':p' . $index++]  = 'FLAECHE';
        }
        if ($this->isColumnModified(HeizungkonfiguratorAngebotTableMap::PERSONEN_ANZAHL)) {
            $modifiedColumns[':p' . $index++]  = 'PERSONEN_ANZAHL';
        }
        if ($this->isColumnModified(HeizungkonfiguratorAngebotTableMap::WOHNRAUMTEMPERATUR)) {
            $modifiedColumns[':p' . $index++]  = 'WOHNRAUMTEMPERATUR';
        }
        if ($this->isColumnModified(HeizungkonfiguratorAngebotTableMap::AUSSENTEMPERATUR)) {
            $modifiedColumns[':p' . $index++]  = 'AUSSENTEMPERATUR';
        }
        if ($this->isColumnModified(HeizungkonfiguratorAngebotTableMap::WAERMEDAEMMUNG)) {
            $modifiedColumns[':p' . $index++]  = 'WAERMEDAEMMUNG';
        }
        if ($this->isColumnModified(HeizungkonfiguratorAngebotTableMap::VERGLASTE_FENSTER)) {
            $modifiedColumns[':p' . $index++]  = 'VERGLASTE_FENSTER';
        }
        if ($this->isColumnModified(HeizungkonfiguratorAngebotTableMap::DACH_DAEMMUNG)) {
            $modifiedColumns[':p' . $index++]  = 'DACH_DAEMMUNG';
        }
        if ($this->isColumnModified(HeizungkonfiguratorAngebotTableMap::GEBAEUDELAGE)) {
            $modifiedColumns[':p' . $index++]  = 'GEBAEUDELAGE';
        }
        if ($this->isColumnModified(HeizungkonfiguratorAngebotTableMap::WINDLAGE)) {
            $modifiedColumns[':p' . $index++]  = 'WINDLAGE';
        }
        if ($this->isColumnModified(HeizungkonfiguratorAngebotTableMap::ANZAHL_AUSSENWAENDE)) {
            $modifiedColumns[':p' . $index++]  = 'ANZAHL_AUSSENWAENDE';
        }
        if ($this->isColumnModified(HeizungkonfiguratorAngebotTableMap::ABGASFUEHRUNG)) {
            $modifiedColumns[':p' . $index++]  = 'ABGASFUEHRUNG';
        }
        if ($this->isColumnModified(HeizungkonfiguratorAngebotTableMap::HEIZUNGSMETHODE)) {
            $modifiedColumns[':p' . $index++]  = 'HEIZUNGSMETHODE';
        }
        if ($this->isColumnModified(HeizungkonfiguratorAngebotTableMap::WARMWASSERVERSORGUNG)) {
            $modifiedColumns[':p' . $index++]  = 'WARMWASSERVERSORGUNG';
        }
        if ($this->isColumnModified(HeizungkonfiguratorAngebotTableMap::WASSERABFLUSS)) {
            $modifiedColumns[':p' . $index++]  = 'WASSERABFLUSS';
        }
        if ($this->isColumnModified(HeizungkonfiguratorAngebotTableMap::SOLARANLAGE)) {
            $modifiedColumns[':p' . $index++]  = 'SOLARANLAGE';
        }
        if ($this->isColumnModified(HeizungkonfiguratorAngebotTableMap::SOLARANLAGEEXTRA)) {
            $modifiedColumns[':p' . $index++]  = 'SOLARANLAGEEXTRA';
        }
        if ($this->isColumnModified(HeizungkonfiguratorAngebotTableMap::PHOTOVOLTAIK)) {
            $modifiedColumns[':p' . $index++]  = 'PHOTOVOLTAIK';
        }
        if ($this->isColumnModified(HeizungkonfiguratorAngebotTableMap::ANMERKUNGEN)) {
            $modifiedColumns[':p' . $index++]  = 'ANMERKUNGEN';
        }
        if ($this->isColumnModified(HeizungkonfiguratorAngebotTableMap::VERSION)) {
            $modifiedColumns[':p' . $index++]  = 'VERSION';
        }
        if ($this->isColumnModified(HeizungkonfiguratorAngebotTableMap::CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'CREATED_AT';
        }

        $sql = sprintf(
            'INSERT INTO heizungkonfigurator_angebot (%s) VALUES (%s)',
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
                    case 'USER_ID':
                        $stmt->bindValue($identifier, $this->user_id, PDO::PARAM_INT);
                        break;
                    case 'PLAN_HEIZUNG':
                        $stmt->bindValue($identifier, $this->plan_heizung, PDO::PARAM_STR);
                        break;
                    case 'BRENNSTOFF_ZUKUNFT':
                        $stmt->bindValue($identifier, $this->brennstoff_zukunft, PDO::PARAM_STR);
                        break;
                    case 'GEBAEUDEART':
                        $stmt->bindValue($identifier, $this->gebaeudeart, PDO::PARAM_STR);
                        break;
                    case 'BAUJAHR':
                        $stmt->bindValue($identifier, $this->baujahr, PDO::PARAM_INT);
                        break;
                    case 'BUILDING_ETAGEN':
                        $stmt->bindValue($identifier, $this->building_etagen, PDO::PARAM_INT);
                        break;
                    case 'FLAECHE':
                        $stmt->bindValue($identifier, $this->flaeche, PDO::PARAM_INT);
                        break;
                    case 'PERSONEN_ANZAHL':
                        $stmt->bindValue($identifier, $this->personen_anzahl, PDO::PARAM_INT);
                        break;
                    case 'WOHNRAUMTEMPERATUR':
                        $stmt->bindValue($identifier, $this->wohnraumtemperatur, PDO::PARAM_INT);
                        break;
                    case 'AUSSENTEMPERATUR':
                        $stmt->bindValue($identifier, $this->aussentemperatur, PDO::PARAM_INT);
                        break;
                    case 'WAERMEDAEMMUNG':
                        $stmt->bindValue($identifier, $this->waermedaemmung, PDO::PARAM_STR);
                        break;
                    case 'VERGLASTE_FENSTER':
                        $stmt->bindValue($identifier, $this->verglaste_fenster, PDO::PARAM_STR);
                        break;
                    case 'DACH_DAEMMUNG':
                        $stmt->bindValue($identifier, $this->dach_daemmung, PDO::PARAM_STR);
                        break;
                    case 'GEBAEUDELAGE':
                        $stmt->bindValue($identifier, $this->gebaeudelage, PDO::PARAM_STR);
                        break;
                    case 'WINDLAGE':
                        $stmt->bindValue($identifier, $this->windlage, PDO::PARAM_STR);
                        break;
                    case 'ANZAHL_AUSSENWAENDE':
                        $stmt->bindValue($identifier, $this->anzahl_aussenwaende, PDO::PARAM_INT);
                        break;
                    case 'ABGASFUEHRUNG':
                        $stmt->bindValue($identifier, $this->abgasfuehrung, PDO::PARAM_STR);
                        break;
                    case 'HEIZUNGSMETHODE':
                        $stmt->bindValue($identifier, $this->heizungsmethode, PDO::PARAM_STR);
                        break;
                    case 'WARMWASSERVERSORGUNG':
                        $stmt->bindValue($identifier, $this->warmwasserversorgung, PDO::PARAM_STR);
                        break;
                    case 'WASSERABFLUSS':
                        $stmt->bindValue($identifier, $this->wasserabfluss, PDO::PARAM_STR);
                        break;
                    case 'SOLARANLAGE':
                        $stmt->bindValue($identifier, $this->solaranlage, PDO::PARAM_STR);
                        break;
                    case 'SOLARANLAGEEXTRA':
                        $stmt->bindValue($identifier, $this->solaranlageextra, PDO::PARAM_STR);
                        break;
                    case 'PHOTOVOLTAIK':
                        $stmt->bindValue($identifier, $this->photovoltaik, PDO::PARAM_STR);
                        break;
                    case 'ANMERKUNGEN':
                        $stmt->bindValue($identifier, $this->anmerkungen, PDO::PARAM_STR);
                        break;
                    case 'VERSION':
                        $stmt->bindValue($identifier, $this->version, PDO::PARAM_STR);
                        break;
                    case 'CREATED_AT':
                        $stmt->bindValue($identifier, $this->created_at ? $this->created_at->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
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
        $pos = HeizungkonfiguratorAngebotTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getUserId();
                break;
            case 2:
                return $this->getPlanHeizung();
                break;
            case 3:
                return $this->getBrennstoffZukunft();
                break;
            case 4:
                return $this->getGebaeudeart();
                break;
            case 5:
                return $this->getBaujahr();
                break;
            case 6:
                return $this->getBuildingEtagen();
                break;
            case 7:
                return $this->getFlaeche();
                break;
            case 8:
                return $this->getPersonenAnzahl();
                break;
            case 9:
                return $this->getWohnraumtemperatur();
                break;
            case 10:
                return $this->getAussentemperatur();
                break;
            case 11:
                return $this->getWaermedaemmung();
                break;
            case 12:
                return $this->getVerglasteFenster();
                break;
            case 13:
                return $this->getDachDaemmung();
                break;
            case 14:
                return $this->getGebaeudelage();
                break;
            case 15:
                return $this->getWindlage();
                break;
            case 16:
                return $this->getAnzahlAussenwaende();
                break;
            case 17:
                return $this->getAbgasfuehrung();
                break;
            case 18:
                return $this->getHeizungsmethode();
                break;
            case 19:
                return $this->getWarmwasserversorgung();
                break;
            case 20:
                return $this->getWasserabfluss();
                break;
            case 21:
                return $this->getSolaranlage();
                break;
            case 22:
                return $this->getSolaranlageextra();
                break;
            case 23:
                return $this->getPhotovoltaik();
                break;
            case 24:
                return $this->getAnmerkungen();
                break;
            case 25:
                return $this->getVersion();
                break;
            case 26:
                return $this->getCreatedAt();
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
        if (isset($alreadyDumpedObjects['HeizungkonfiguratorAngebot'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['HeizungkonfiguratorAngebot'][$this->getPrimaryKey()] = true;
        $keys = HeizungkonfiguratorAngebotTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getUserId(),
            $keys[2] => $this->getPlanHeizung(),
            $keys[3] => $this->getBrennstoffZukunft(),
            $keys[4] => $this->getGebaeudeart(),
            $keys[5] => $this->getBaujahr(),
            $keys[6] => $this->getBuildingEtagen(),
            $keys[7] => $this->getFlaeche(),
            $keys[8] => $this->getPersonenAnzahl(),
            $keys[9] => $this->getWohnraumtemperatur(),
            $keys[10] => $this->getAussentemperatur(),
            $keys[11] => $this->getWaermedaemmung(),
            $keys[12] => $this->getVerglasteFenster(),
            $keys[13] => $this->getDachDaemmung(),
            $keys[14] => $this->getGebaeudelage(),
            $keys[15] => $this->getWindlage(),
            $keys[16] => $this->getAnzahlAussenwaende(),
            $keys[17] => $this->getAbgasfuehrung(),
            $keys[18] => $this->getHeizungsmethode(),
            $keys[19] => $this->getWarmwasserversorgung(),
            $keys[20] => $this->getWasserabfluss(),
            $keys[21] => $this->getSolaranlage(),
            $keys[22] => $this->getSolaranlageextra(),
            $keys[23] => $this->getPhotovoltaik(),
            $keys[24] => $this->getAnmerkungen(),
            $keys[25] => $this->getVersion(),
            $keys[26] => $this->getCreatedAt(),
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
        $pos = HeizungkonfiguratorAngebotTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

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
                $this->setUserId($value);
                break;
            case 2:
                $this->setPlanHeizung($value);
                break;
            case 3:
                $this->setBrennstoffZukunft($value);
                break;
            case 4:
                $this->setGebaeudeart($value);
                break;
            case 5:
                $this->setBaujahr($value);
                break;
            case 6:
                $this->setBuildingEtagen($value);
                break;
            case 7:
                $this->setFlaeche($value);
                break;
            case 8:
                $this->setPersonenAnzahl($value);
                break;
            case 9:
                $this->setWohnraumtemperatur($value);
                break;
            case 10:
                $this->setAussentemperatur($value);
                break;
            case 11:
                $this->setWaermedaemmung($value);
                break;
            case 12:
                $this->setVerglasteFenster($value);
                break;
            case 13:
                $this->setDachDaemmung($value);
                break;
            case 14:
                $this->setGebaeudelage($value);
                break;
            case 15:
                $this->setWindlage($value);
                break;
            case 16:
                $this->setAnzahlAussenwaende($value);
                break;
            case 17:
                $this->setAbgasfuehrung($value);
                break;
            case 18:
                $this->setHeizungsmethode($value);
                break;
            case 19:
                $this->setWarmwasserversorgung($value);
                break;
            case 20:
                $this->setWasserabfluss($value);
                break;
            case 21:
                $this->setSolaranlage($value);
                break;
            case 22:
                $this->setSolaranlageextra($value);
                break;
            case 23:
                $this->setPhotovoltaik($value);
                break;
            case 24:
                $this->setAnmerkungen($value);
                break;
            case 25:
                $this->setVersion($value);
                break;
            case 26:
                $this->setCreatedAt($value);
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
        $keys = HeizungkonfiguratorAngebotTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setUserId($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setPlanHeizung($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setBrennstoffZukunft($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setGebaeudeart($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setBaujahr($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setBuildingEtagen($arr[$keys[6]]);
        if (array_key_exists($keys[7], $arr)) $this->setFlaeche($arr[$keys[7]]);
        if (array_key_exists($keys[8], $arr)) $this->setPersonenAnzahl($arr[$keys[8]]);
        if (array_key_exists($keys[9], $arr)) $this->setWohnraumtemperatur($arr[$keys[9]]);
        if (array_key_exists($keys[10], $arr)) $this->setAussentemperatur($arr[$keys[10]]);
        if (array_key_exists($keys[11], $arr)) $this->setWaermedaemmung($arr[$keys[11]]);
        if (array_key_exists($keys[12], $arr)) $this->setVerglasteFenster($arr[$keys[12]]);
        if (array_key_exists($keys[13], $arr)) $this->setDachDaemmung($arr[$keys[13]]);
        if (array_key_exists($keys[14], $arr)) $this->setGebaeudelage($arr[$keys[14]]);
        if (array_key_exists($keys[15], $arr)) $this->setWindlage($arr[$keys[15]]);
        if (array_key_exists($keys[16], $arr)) $this->setAnzahlAussenwaende($arr[$keys[16]]);
        if (array_key_exists($keys[17], $arr)) $this->setAbgasfuehrung($arr[$keys[17]]);
        if (array_key_exists($keys[18], $arr)) $this->setHeizungsmethode($arr[$keys[18]]);
        if (array_key_exists($keys[19], $arr)) $this->setWarmwasserversorgung($arr[$keys[19]]);
        if (array_key_exists($keys[20], $arr)) $this->setWasserabfluss($arr[$keys[20]]);
        if (array_key_exists($keys[21], $arr)) $this->setSolaranlage($arr[$keys[21]]);
        if (array_key_exists($keys[22], $arr)) $this->setSolaranlageextra($arr[$keys[22]]);
        if (array_key_exists($keys[23], $arr)) $this->setPhotovoltaik($arr[$keys[23]]);
        if (array_key_exists($keys[24], $arr)) $this->setAnmerkungen($arr[$keys[24]]);
        if (array_key_exists($keys[25], $arr)) $this->setVersion($arr[$keys[25]]);
        if (array_key_exists($keys[26], $arr)) $this->setCreatedAt($arr[$keys[26]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(HeizungkonfiguratorAngebotTableMap::DATABASE_NAME);

        if ($this->isColumnModified(HeizungkonfiguratorAngebotTableMap::ID)) $criteria->add(HeizungkonfiguratorAngebotTableMap::ID, $this->id);
        if ($this->isColumnModified(HeizungkonfiguratorAngebotTableMap::USER_ID)) $criteria->add(HeizungkonfiguratorAngebotTableMap::USER_ID, $this->user_id);
        if ($this->isColumnModified(HeizungkonfiguratorAngebotTableMap::PLAN_HEIZUNG)) $criteria->add(HeizungkonfiguratorAngebotTableMap::PLAN_HEIZUNG, $this->plan_heizung);
        if ($this->isColumnModified(HeizungkonfiguratorAngebotTableMap::BRENNSTOFF_ZUKUNFT)) $criteria->add(HeizungkonfiguratorAngebotTableMap::BRENNSTOFF_ZUKUNFT, $this->brennstoff_zukunft);
        if ($this->isColumnModified(HeizungkonfiguratorAngebotTableMap::GEBAEUDEART)) $criteria->add(HeizungkonfiguratorAngebotTableMap::GEBAEUDEART, $this->gebaeudeart);
        if ($this->isColumnModified(HeizungkonfiguratorAngebotTableMap::BAUJAHR)) $criteria->add(HeizungkonfiguratorAngebotTableMap::BAUJAHR, $this->baujahr);
        if ($this->isColumnModified(HeizungkonfiguratorAngebotTableMap::BUILDING_ETAGEN)) $criteria->add(HeizungkonfiguratorAngebotTableMap::BUILDING_ETAGEN, $this->building_etagen);
        if ($this->isColumnModified(HeizungkonfiguratorAngebotTableMap::FLAECHE)) $criteria->add(HeizungkonfiguratorAngebotTableMap::FLAECHE, $this->flaeche);
        if ($this->isColumnModified(HeizungkonfiguratorAngebotTableMap::PERSONEN_ANZAHL)) $criteria->add(HeizungkonfiguratorAngebotTableMap::PERSONEN_ANZAHL, $this->personen_anzahl);
        if ($this->isColumnModified(HeizungkonfiguratorAngebotTableMap::WOHNRAUMTEMPERATUR)) $criteria->add(HeizungkonfiguratorAngebotTableMap::WOHNRAUMTEMPERATUR, $this->wohnraumtemperatur);
        if ($this->isColumnModified(HeizungkonfiguratorAngebotTableMap::AUSSENTEMPERATUR)) $criteria->add(HeizungkonfiguratorAngebotTableMap::AUSSENTEMPERATUR, $this->aussentemperatur);
        if ($this->isColumnModified(HeizungkonfiguratorAngebotTableMap::WAERMEDAEMMUNG)) $criteria->add(HeizungkonfiguratorAngebotTableMap::WAERMEDAEMMUNG, $this->waermedaemmung);
        if ($this->isColumnModified(HeizungkonfiguratorAngebotTableMap::VERGLASTE_FENSTER)) $criteria->add(HeizungkonfiguratorAngebotTableMap::VERGLASTE_FENSTER, $this->verglaste_fenster);
        if ($this->isColumnModified(HeizungkonfiguratorAngebotTableMap::DACH_DAEMMUNG)) $criteria->add(HeizungkonfiguratorAngebotTableMap::DACH_DAEMMUNG, $this->dach_daemmung);
        if ($this->isColumnModified(HeizungkonfiguratorAngebotTableMap::GEBAEUDELAGE)) $criteria->add(HeizungkonfiguratorAngebotTableMap::GEBAEUDELAGE, $this->gebaeudelage);
        if ($this->isColumnModified(HeizungkonfiguratorAngebotTableMap::WINDLAGE)) $criteria->add(HeizungkonfiguratorAngebotTableMap::WINDLAGE, $this->windlage);
        if ($this->isColumnModified(HeizungkonfiguratorAngebotTableMap::ANZAHL_AUSSENWAENDE)) $criteria->add(HeizungkonfiguratorAngebotTableMap::ANZAHL_AUSSENWAENDE, $this->anzahl_aussenwaende);
        if ($this->isColumnModified(HeizungkonfiguratorAngebotTableMap::ABGASFUEHRUNG)) $criteria->add(HeizungkonfiguratorAngebotTableMap::ABGASFUEHRUNG, $this->abgasfuehrung);
        if ($this->isColumnModified(HeizungkonfiguratorAngebotTableMap::HEIZUNGSMETHODE)) $criteria->add(HeizungkonfiguratorAngebotTableMap::HEIZUNGSMETHODE, $this->heizungsmethode);
        if ($this->isColumnModified(HeizungkonfiguratorAngebotTableMap::WARMWASSERVERSORGUNG)) $criteria->add(HeizungkonfiguratorAngebotTableMap::WARMWASSERVERSORGUNG, $this->warmwasserversorgung);
        if ($this->isColumnModified(HeizungkonfiguratorAngebotTableMap::WASSERABFLUSS)) $criteria->add(HeizungkonfiguratorAngebotTableMap::WASSERABFLUSS, $this->wasserabfluss);
        if ($this->isColumnModified(HeizungkonfiguratorAngebotTableMap::SOLARANLAGE)) $criteria->add(HeizungkonfiguratorAngebotTableMap::SOLARANLAGE, $this->solaranlage);
        if ($this->isColumnModified(HeizungkonfiguratorAngebotTableMap::SOLARANLAGEEXTRA)) $criteria->add(HeizungkonfiguratorAngebotTableMap::SOLARANLAGEEXTRA, $this->solaranlageextra);
        if ($this->isColumnModified(HeizungkonfiguratorAngebotTableMap::PHOTOVOLTAIK)) $criteria->add(HeizungkonfiguratorAngebotTableMap::PHOTOVOLTAIK, $this->photovoltaik);
        if ($this->isColumnModified(HeizungkonfiguratorAngebotTableMap::ANMERKUNGEN)) $criteria->add(HeizungkonfiguratorAngebotTableMap::ANMERKUNGEN, $this->anmerkungen);
        if ($this->isColumnModified(HeizungkonfiguratorAngebotTableMap::VERSION)) $criteria->add(HeizungkonfiguratorAngebotTableMap::VERSION, $this->version);
        if ($this->isColumnModified(HeizungkonfiguratorAngebotTableMap::CREATED_AT)) $criteria->add(HeizungkonfiguratorAngebotTableMap::CREATED_AT, $this->created_at);

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
        $criteria = new Criteria(HeizungkonfiguratorAngebotTableMap::DATABASE_NAME);
        $criteria->add(HeizungkonfiguratorAngebotTableMap::ID, $this->id);

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
     * @param      object $copyObj An object of \HookKonfigurator\Model\HeizungkonfiguratorAngebot (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setUserId($this->getUserId());
        $copyObj->setPlanHeizung($this->getPlanHeizung());
        $copyObj->setBrennstoffZukunft($this->getBrennstoffZukunft());
        $copyObj->setGebaeudeart($this->getGebaeudeart());
        $copyObj->setBaujahr($this->getBaujahr());
        $copyObj->setBuildingEtagen($this->getBuildingEtagen());
        $copyObj->setFlaeche($this->getFlaeche());
        $copyObj->setPersonenAnzahl($this->getPersonenAnzahl());
        $copyObj->setWohnraumtemperatur($this->getWohnraumtemperatur());
        $copyObj->setAussentemperatur($this->getAussentemperatur());
        $copyObj->setWaermedaemmung($this->getWaermedaemmung());
        $copyObj->setVerglasteFenster($this->getVerglasteFenster());
        $copyObj->setDachDaemmung($this->getDachDaemmung());
        $copyObj->setGebaeudelage($this->getGebaeudelage());
        $copyObj->setWindlage($this->getWindlage());
        $copyObj->setAnzahlAussenwaende($this->getAnzahlAussenwaende());
        $copyObj->setAbgasfuehrung($this->getAbgasfuehrung());
        $copyObj->setHeizungsmethode($this->getHeizungsmethode());
        $copyObj->setWarmwasserversorgung($this->getWarmwasserversorgung());
        $copyObj->setWasserabfluss($this->getWasserabfluss());
        $copyObj->setSolaranlage($this->getSolaranlage());
        $copyObj->setSolaranlageextra($this->getSolaranlageextra());
        $copyObj->setPhotovoltaik($this->getPhotovoltaik());
        $copyObj->setAnmerkungen($this->getAnmerkungen());
        $copyObj->setVersion($this->getVersion());
        $copyObj->setCreatedAt($this->getCreatedAt());
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
     * @return                 \HookKonfigurator\Model\HeizungkonfiguratorAngebot Clone of current object.
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
        $this->user_id = null;
        $this->plan_heizung = null;
        $this->brennstoff_zukunft = null;
        $this->gebaeudeart = null;
        $this->baujahr = null;
        $this->building_etagen = null;
        $this->flaeche = null;
        $this->personen_anzahl = null;
        $this->wohnraumtemperatur = null;
        $this->aussentemperatur = null;
        $this->waermedaemmung = null;
        $this->verglaste_fenster = null;
        $this->dach_daemmung = null;
        $this->gebaeudelage = null;
        $this->windlage = null;
        $this->anzahl_aussenwaende = null;
        $this->abgasfuehrung = null;
        $this->heizungsmethode = null;
        $this->warmwasserversorgung = null;
        $this->wasserabfluss = null;
        $this->solaranlage = null;
        $this->solaranlageextra = null;
        $this->photovoltaik = null;
        $this->anmerkungen = null;
        $this->version = null;
        $this->created_at = null;
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
        return (string) $this->exportTo(HeizungkonfiguratorAngebotTableMap::DEFAULT_STRING_FORMAT);
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
