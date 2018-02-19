<?php

namespace HookKonfigurator\Model\Base;

use \DateTime;
use \Exception;
use \PDO;
use HookKonfigurator\Model\HeizungkonfiguratorImage as ChildHeizungkonfiguratorImage;
use HookKonfigurator\Model\HeizungkonfiguratorImageQuery as ChildHeizungkonfiguratorImageQuery;
use HookKonfigurator\Model\HeizungkonfiguratorUserdaten as ChildHeizungkonfiguratorUserdaten;
use HookKonfigurator\Model\HeizungkonfiguratorUserdatenQuery as ChildHeizungkonfiguratorUserdatenQuery;
use HookKonfigurator\Model\Map\HeizungkonfiguratorUserdatenTableMap;
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

abstract class HeizungkonfiguratorUserdaten implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\HookKonfigurator\\Model\\Map\\HeizungkonfiguratorUserdatenTableMap';


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
     * The value for the brennstoff_momentan field.
     * @var        string
     */
    protected $brennstoff_momentan;

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
     * The value for the personen_anzahl field.
     * @var        int
     */
    protected $personen_anzahl;

    /**
     * The value for the bestehende_geraet_warmwasser field.
     * @var        string
     */
    protected $bestehende_geraet_warmwasser;

    /**
     * The value for the bestehende_geraet_kw field.
     * @var        int
     */
    protected $bestehende_geraet_kw;

    /**
     * The value for the baujahr field.
     * @var        int
     */
    protected $baujahr;

    /**
     * The value for the heizflaeche field.
     * @var        int
     */
    protected $heizflaeche;

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
     * The value for the anmerkungen field.
     * @var        string
     */
    protected $anmerkungen;

    /**
     * The value for the foto_id field.
     * @var        int
     */
    protected $foto_id;

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
     * The value for the etagen field.
     * @var        int
     */
    protected $etagen;

    /**
     * The value for the dach_daemmung field.
     * @var        string
     */
    protected $dach_daemmung;

    /**
     * The value for the abgasfuehrung field.
     * @var        string
     */
    protected $abgasfuehrung;

    /**
     * The value for the waermeabgabe field.
     * @var        string
     */
    protected $waermeabgabe;

    /**
     * The value for the duschwasser field.
     * @var        string
     */
    protected $duschwasser;

    /**
     * The value for the wasserabfluss field.
     * @var        string
     */
    protected $wasserabfluss;

    /**
     * The value for the warmwasserversorgung field.
     * @var        string
     */
    protected $warmwasserversorgung;

    /**
     * The value for the warmwasserversorgung_extra field.
     * @var        string
     */
    protected $warmwasserversorgung_extra;

    /**
     * The value for the warmwasserversorgung_extra_waermepumpe field.
     * @var        string
     */
    protected $warmwasserversorgung_extra_waermepumpe;

    /**
     * @var        ObjectCollection|ChildHeizungkonfiguratorImage[] Collection to store aggregation of ChildHeizungkonfiguratorImage objects.
     */
    protected $collHeizungkonfiguratorImages;
    protected $collHeizungkonfiguratorImagesPartial;

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
    protected $heizungkonfiguratorImagesScheduledForDeletion = null;

    /**
     * Initializes internal state of HookKonfigurator\Model\Base\HeizungkonfiguratorUserdaten object.
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
     * Compares this with another <code>HeizungkonfiguratorUserdaten</code> instance.  If
     * <code>obj</code> is an instance of <code>HeizungkonfiguratorUserdaten</code>, delegates to
     * <code>equals(HeizungkonfiguratorUserdaten)</code>.  Otherwise, returns <code>false</code>.
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
     * @return HeizungkonfiguratorUserdaten The current object, for fluid interface
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
     * @return HeizungkonfiguratorUserdaten The current object, for fluid interface
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
     * Get the [brennstoff_momentan] column value.
     *
     * @return   string
     */
    public function getBrennstoffMomentan()
    {

        return $this->brennstoff_momentan;
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
     * Get the [personen_anzahl] column value.
     *
     * @return   int
     */
    public function getPersonenAnzahl()
    {

        return $this->personen_anzahl;
    }

    /**
     * Get the [bestehende_geraet_warmwasser] column value.
     *
     * @return   string
     */
    public function getBestehendeGeraetWarmwasser()
    {

        return $this->bestehende_geraet_warmwasser;
    }

    /**
     * Get the [bestehende_geraet_kw] column value.
     *
     * @return   int
     */
    public function getBestehendeGeraetKw()
    {

        return $this->bestehende_geraet_kw;
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
     * Get the [heizflaeche] column value.
     *
     * @return   int
     */
    public function getHeizflaeche()
    {

        return $this->heizflaeche;
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
     * Get the [anmerkungen] column value.
     *
     * @return   string
     */
    public function getAnmerkungen()
    {

        return $this->anmerkungen;
    }

    /**
     * Get the [foto_id] column value.
     *
     * @return   int
     */
    public function getFotoId()
    {

        return $this->foto_id;
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
     * Get the [etagen] column value.
     *
     * @return   int
     */
    public function getEtagen()
    {

        return $this->etagen;
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
     * Get the [abgasfuehrung] column value.
     *
     * @return   string
     */
    public function getAbgasfuehrung()
    {

        return $this->abgasfuehrung;
    }

    /**
     * Get the [waermeabgabe] column value.
     *
     * @return   string
     */
    public function getWaermeabgabe()
    {

        return $this->waermeabgabe;
    }

    /**
     * Get the [duschwasser] column value.
     *
     * @return   string
     */
    public function getDuschwasser()
    {

        return $this->duschwasser;
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
     * Get the [warmwasserversorgung] column value.
     *
     * @return   string
     */
    public function getWarmwasserversorgung()
    {

        return $this->warmwasserversorgung;
    }

    /**
     * Get the [warmwasserversorgung_extra] column value.
     *
     * @return   string
     */
    public function getWarmwasserversorgungExtra()
    {

        return $this->warmwasserversorgung_extra;
    }

    /**
     * Get the [warmwasserversorgung_extra_waermepumpe] column value.
     *
     * @return   string
     */
    public function getWarmwasserversorgungExtraWaermepumpe()
    {

        return $this->warmwasserversorgung_extra_waermepumpe;
    }

    /**
     * Set the value of [id] column.
     *
     * @param      int $v new value
     * @return   \HookKonfigurator\Model\HeizungkonfiguratorUserdaten The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[HeizungkonfiguratorUserdatenTableMap::ID] = true;
        }


        return $this;
    } // setId()

    /**
     * Set the value of [user_id] column.
     *
     * @param      int $v new value
     * @return   \HookKonfigurator\Model\HeizungkonfiguratorUserdaten The current object (for fluent API support)
     */
    public function setUserId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->user_id !== $v) {
            $this->user_id = $v;
            $this->modifiedColumns[HeizungkonfiguratorUserdatenTableMap::USER_ID] = true;
        }


        return $this;
    } // setUserId()

    /**
     * Set the value of [brennstoff_momentan] column.
     *
     * @param      string $v new value
     * @return   \HookKonfigurator\Model\HeizungkonfiguratorUserdaten The current object (for fluent API support)
     */
    public function setBrennstoffMomentan($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->brennstoff_momentan !== $v) {
            $this->brennstoff_momentan = $v;
            $this->modifiedColumns[HeizungkonfiguratorUserdatenTableMap::BRENNSTOFF_MOMENTAN] = true;
        }


        return $this;
    } // setBrennstoffMomentan()

    /**
     * Set the value of [brennstoff_zukunft] column.
     *
     * @param      string $v new value
     * @return   \HookKonfigurator\Model\HeizungkonfiguratorUserdaten The current object (for fluent API support)
     */
    public function setBrennstoffZukunft($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->brennstoff_zukunft !== $v) {
            $this->brennstoff_zukunft = $v;
            $this->modifiedColumns[HeizungkonfiguratorUserdatenTableMap::BRENNSTOFF_ZUKUNFT] = true;
        }


        return $this;
    } // setBrennstoffZukunft()

    /**
     * Set the value of [gebaeudeart] column.
     *
     * @param      string $v new value
     * @return   \HookKonfigurator\Model\HeizungkonfiguratorUserdaten The current object (for fluent API support)
     */
    public function setGebaeudeart($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->gebaeudeart !== $v) {
            $this->gebaeudeart = $v;
            $this->modifiedColumns[HeizungkonfiguratorUserdatenTableMap::GEBAEUDEART] = true;
        }


        return $this;
    } // setGebaeudeart()

    /**
     * Set the value of [personen_anzahl] column.
     *
     * @param      int $v new value
     * @return   \HookKonfigurator\Model\HeizungkonfiguratorUserdaten The current object (for fluent API support)
     */
    public function setPersonenAnzahl($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->personen_anzahl !== $v) {
            $this->personen_anzahl = $v;
            $this->modifiedColumns[HeizungkonfiguratorUserdatenTableMap::PERSONEN_ANZAHL] = true;
        }


        return $this;
    } // setPersonenAnzahl()

    /**
     * Set the value of [bestehende_geraet_warmwasser] column.
     *
     * @param      string $v new value
     * @return   \HookKonfigurator\Model\HeizungkonfiguratorUserdaten The current object (for fluent API support)
     */
    public function setBestehendeGeraetWarmwasser($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->bestehende_geraet_warmwasser !== $v) {
            $this->bestehende_geraet_warmwasser = $v;
            $this->modifiedColumns[HeizungkonfiguratorUserdatenTableMap::BESTEHENDE_GERAET_WARMWASSER] = true;
        }


        return $this;
    } // setBestehendeGeraetWarmwasser()

    /**
     * Set the value of [bestehende_geraet_kw] column.
     *
     * @param      int $v new value
     * @return   \HookKonfigurator\Model\HeizungkonfiguratorUserdaten The current object (for fluent API support)
     */
    public function setBestehendeGeraetKw($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->bestehende_geraet_kw !== $v) {
            $this->bestehende_geraet_kw = $v;
            $this->modifiedColumns[HeizungkonfiguratorUserdatenTableMap::BESTEHENDE_GERAET_KW] = true;
        }


        return $this;
    } // setBestehendeGeraetKw()

    /**
     * Set the value of [baujahr] column.
     *
     * @param      int $v new value
     * @return   \HookKonfigurator\Model\HeizungkonfiguratorUserdaten The current object (for fluent API support)
     */
    public function setBaujahr($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->baujahr !== $v) {
            $this->baujahr = $v;
            $this->modifiedColumns[HeizungkonfiguratorUserdatenTableMap::BAUJAHR] = true;
        }


        return $this;
    } // setBaujahr()

    /**
     * Set the value of [heizflaeche] column.
     *
     * @param      int $v new value
     * @return   \HookKonfigurator\Model\HeizungkonfiguratorUserdaten The current object (for fluent API support)
     */
    public function setHeizflaeche($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->heizflaeche !== $v) {
            $this->heizflaeche = $v;
            $this->modifiedColumns[HeizungkonfiguratorUserdatenTableMap::HEIZFLAECHE] = true;
        }


        return $this;
    } // setHeizflaeche()

    /**
     * Set the value of [waermedaemmung] column.
     *
     * @param      string $v new value
     * @return   \HookKonfigurator\Model\HeizungkonfiguratorUserdaten The current object (for fluent API support)
     */
    public function setWaermedaemmung($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->waermedaemmung !== $v) {
            $this->waermedaemmung = $v;
            $this->modifiedColumns[HeizungkonfiguratorUserdatenTableMap::WAERMEDAEMMUNG] = true;
        }


        return $this;
    } // setWaermedaemmung()

    /**
     * Set the value of [verglaste_fenster] column.
     *
     * @param      string $v new value
     * @return   \HookKonfigurator\Model\HeizungkonfiguratorUserdaten The current object (for fluent API support)
     */
    public function setVerglasteFenster($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->verglaste_fenster !== $v) {
            $this->verglaste_fenster = $v;
            $this->modifiedColumns[HeizungkonfiguratorUserdatenTableMap::VERGLASTE_FENSTER] = true;
        }


        return $this;
    } // setVerglasteFenster()

    /**
     * Set the value of [gebaeudelage] column.
     *
     * @param      string $v new value
     * @return   \HookKonfigurator\Model\HeizungkonfiguratorUserdaten The current object (for fluent API support)
     */
    public function setGebaeudelage($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->gebaeudelage !== $v) {
            $this->gebaeudelage = $v;
            $this->modifiedColumns[HeizungkonfiguratorUserdatenTableMap::GEBAEUDELAGE] = true;
        }


        return $this;
    } // setGebaeudelage()

    /**
     * Set the value of [windlage] column.
     *
     * @param      string $v new value
     * @return   \HookKonfigurator\Model\HeizungkonfiguratorUserdaten The current object (for fluent API support)
     */
    public function setWindlage($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->windlage !== $v) {
            $this->windlage = $v;
            $this->modifiedColumns[HeizungkonfiguratorUserdatenTableMap::WINDLAGE] = true;
        }


        return $this;
    } // setWindlage()

    /**
     * Set the value of [anzahl_aussenwaende] column.
     *
     * @param      int $v new value
     * @return   \HookKonfigurator\Model\HeizungkonfiguratorUserdaten The current object (for fluent API support)
     */
    public function setAnzahlAussenwaende($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->anzahl_aussenwaende !== $v) {
            $this->anzahl_aussenwaende = $v;
            $this->modifiedColumns[HeizungkonfiguratorUserdatenTableMap::ANZAHL_AUSSENWAENDE] = true;
        }


        return $this;
    } // setAnzahlAussenwaende()

    /**
     * Set the value of [wohnraumtemperatur] column.
     *
     * @param      int $v new value
     * @return   \HookKonfigurator\Model\HeizungkonfiguratorUserdaten The current object (for fluent API support)
     */
    public function setWohnraumtemperatur($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->wohnraumtemperatur !== $v) {
            $this->wohnraumtemperatur = $v;
            $this->modifiedColumns[HeizungkonfiguratorUserdatenTableMap::WOHNRAUMTEMPERATUR] = true;
        }


        return $this;
    } // setWohnraumtemperatur()

    /**
     * Set the value of [aussentemperatur] column.
     *
     * @param      int $v new value
     * @return   \HookKonfigurator\Model\HeizungkonfiguratorUserdaten The current object (for fluent API support)
     */
    public function setAussentemperatur($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->aussentemperatur !== $v) {
            $this->aussentemperatur = $v;
            $this->modifiedColumns[HeizungkonfiguratorUserdatenTableMap::AUSSENTEMPERATUR] = true;
        }


        return $this;
    } // setAussentemperatur()

    /**
     * Set the value of [anmerkungen] column.
     *
     * @param      string $v new value
     * @return   \HookKonfigurator\Model\HeizungkonfiguratorUserdaten The current object (for fluent API support)
     */
    public function setAnmerkungen($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->anmerkungen !== $v) {
            $this->anmerkungen = $v;
            $this->modifiedColumns[HeizungkonfiguratorUserdatenTableMap::ANMERKUNGEN] = true;
        }


        return $this;
    } // setAnmerkungen()

    /**
     * Set the value of [foto_id] column.
     *
     * @param      int $v new value
     * @return   \HookKonfigurator\Model\HeizungkonfiguratorUserdaten The current object (for fluent API support)
     */
    public function setFotoId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->foto_id !== $v) {
            $this->foto_id = $v;
            $this->modifiedColumns[HeizungkonfiguratorUserdatenTableMap::FOTO_ID] = true;
        }


        return $this;
    } // setFotoId()

    /**
     * Set the value of [version] column.
     *
     * @param      string $v new value
     * @return   \HookKonfigurator\Model\HeizungkonfiguratorUserdaten The current object (for fluent API support)
     */
    public function setVersion($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->version !== $v) {
            $this->version = $v;
            $this->modifiedColumns[HeizungkonfiguratorUserdatenTableMap::VERSION] = true;
        }


        return $this;
    } // setVersion()

    /**
     * Sets the value of [created_at] column to a normalized version of the date/time value specified.
     *
     * @param      mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return   \HookKonfigurator\Model\HeizungkonfiguratorUserdaten The current object (for fluent API support)
     */
    public function setCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->created_at !== null || $dt !== null) {
            if ($dt !== $this->created_at) {
                $this->created_at = $dt;
                $this->modifiedColumns[HeizungkonfiguratorUserdatenTableMap::CREATED_AT] = true;
            }
        } // if either are not null


        return $this;
    } // setCreatedAt()

    /**
     * Set the value of [etagen] column.
     *
     * @param      int $v new value
     * @return   \HookKonfigurator\Model\HeizungkonfiguratorUserdaten The current object (for fluent API support)
     */
    public function setEtagen($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->etagen !== $v) {
            $this->etagen = $v;
            $this->modifiedColumns[HeizungkonfiguratorUserdatenTableMap::ETAGEN] = true;
        }


        return $this;
    } // setEtagen()

    /**
     * Set the value of [dach_daemmung] column.
     *
     * @param      string $v new value
     * @return   \HookKonfigurator\Model\HeizungkonfiguratorUserdaten The current object (for fluent API support)
     */
    public function setDachDaemmung($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->dach_daemmung !== $v) {
            $this->dach_daemmung = $v;
            $this->modifiedColumns[HeizungkonfiguratorUserdatenTableMap::DACH_DAEMMUNG] = true;
        }


        return $this;
    } // setDachDaemmung()

    /**
     * Set the value of [abgasfuehrung] column.
     *
     * @param      string $v new value
     * @return   \HookKonfigurator\Model\HeizungkonfiguratorUserdaten The current object (for fluent API support)
     */
    public function setAbgasfuehrung($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->abgasfuehrung !== $v) {
            $this->abgasfuehrung = $v;
            $this->modifiedColumns[HeizungkonfiguratorUserdatenTableMap::ABGASFUEHRUNG] = true;
        }


        return $this;
    } // setAbgasfuehrung()

    /**
     * Set the value of [waermeabgabe] column.
     *
     * @param      string $v new value
     * @return   \HookKonfigurator\Model\HeizungkonfiguratorUserdaten The current object (for fluent API support)
     */
    public function setWaermeabgabe($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->waermeabgabe !== $v) {
            $this->waermeabgabe = $v;
            $this->modifiedColumns[HeizungkonfiguratorUserdatenTableMap::WAERMEABGABE] = true;
        }


        return $this;
    } // setWaermeabgabe()

    /**
     * Set the value of [duschwasser] column.
     *
     * @param      string $v new value
     * @return   \HookKonfigurator\Model\HeizungkonfiguratorUserdaten The current object (for fluent API support)
     */
    public function setDuschwasser($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->duschwasser !== $v) {
            $this->duschwasser = $v;
            $this->modifiedColumns[HeizungkonfiguratorUserdatenTableMap::DUSCHWASSER] = true;
        }


        return $this;
    } // setDuschwasser()

    /**
     * Set the value of [wasserabfluss] column.
     *
     * @param      string $v new value
     * @return   \HookKonfigurator\Model\HeizungkonfiguratorUserdaten The current object (for fluent API support)
     */
    public function setWasserabfluss($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->wasserabfluss !== $v) {
            $this->wasserabfluss = $v;
            $this->modifiedColumns[HeizungkonfiguratorUserdatenTableMap::WASSERABFLUSS] = true;
        }


        return $this;
    } // setWasserabfluss()

    /**
     * Set the value of [warmwasserversorgung] column.
     *
     * @param      string $v new value
     * @return   \HookKonfigurator\Model\HeizungkonfiguratorUserdaten The current object (for fluent API support)
     */
    public function setWarmwasserversorgung($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->warmwasserversorgung !== $v) {
            $this->warmwasserversorgung = $v;
            $this->modifiedColumns[HeizungkonfiguratorUserdatenTableMap::WARMWASSERVERSORGUNG] = true;
        }


        return $this;
    } // setWarmwasserversorgung()

    /**
     * Set the value of [warmwasserversorgung_extra] column.
     *
     * @param      string $v new value
     * @return   \HookKonfigurator\Model\HeizungkonfiguratorUserdaten The current object (for fluent API support)
     */
    public function setWarmwasserversorgungExtra($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->warmwasserversorgung_extra !== $v) {
            $this->warmwasserversorgung_extra = $v;
            $this->modifiedColumns[HeizungkonfiguratorUserdatenTableMap::WARMWASSERVERSORGUNG_EXTRA] = true;
        }


        return $this;
    } // setWarmwasserversorgungExtra()

    /**
     * Set the value of [warmwasserversorgung_extra_waermepumpe] column.
     *
     * @param      string $v new value
     * @return   \HookKonfigurator\Model\HeizungkonfiguratorUserdaten The current object (for fluent API support)
     */
    public function setWarmwasserversorgungExtraWaermepumpe($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->warmwasserversorgung_extra_waermepumpe !== $v) {
            $this->warmwasserversorgung_extra_waermepumpe = $v;
            $this->modifiedColumns[HeizungkonfiguratorUserdatenTableMap::WARMWASSERVERSORGUNG_EXTRA_WAERMEPUMPE] = true;
        }


        return $this;
    } // setWarmwasserversorgungExtraWaermepumpe()

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


            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : HeizungkonfiguratorUserdatenTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : HeizungkonfiguratorUserdatenTableMap::translateFieldName('UserId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->user_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : HeizungkonfiguratorUserdatenTableMap::translateFieldName('BrennstoffMomentan', TableMap::TYPE_PHPNAME, $indexType)];
            $this->brennstoff_momentan = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : HeizungkonfiguratorUserdatenTableMap::translateFieldName('BrennstoffZukunft', TableMap::TYPE_PHPNAME, $indexType)];
            $this->brennstoff_zukunft = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : HeizungkonfiguratorUserdatenTableMap::translateFieldName('Gebaeudeart', TableMap::TYPE_PHPNAME, $indexType)];
            $this->gebaeudeart = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : HeizungkonfiguratorUserdatenTableMap::translateFieldName('PersonenAnzahl', TableMap::TYPE_PHPNAME, $indexType)];
            $this->personen_anzahl = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : HeizungkonfiguratorUserdatenTableMap::translateFieldName('BestehendeGeraetWarmwasser', TableMap::TYPE_PHPNAME, $indexType)];
            $this->bestehende_geraet_warmwasser = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : HeizungkonfiguratorUserdatenTableMap::translateFieldName('BestehendeGeraetKw', TableMap::TYPE_PHPNAME, $indexType)];
            $this->bestehende_geraet_kw = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : HeizungkonfiguratorUserdatenTableMap::translateFieldName('Baujahr', TableMap::TYPE_PHPNAME, $indexType)];
            $this->baujahr = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : HeizungkonfiguratorUserdatenTableMap::translateFieldName('Heizflaeche', TableMap::TYPE_PHPNAME, $indexType)];
            $this->heizflaeche = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 10 + $startcol : HeizungkonfiguratorUserdatenTableMap::translateFieldName('Waermedaemmung', TableMap::TYPE_PHPNAME, $indexType)];
            $this->waermedaemmung = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 11 + $startcol : HeizungkonfiguratorUserdatenTableMap::translateFieldName('VerglasteFenster', TableMap::TYPE_PHPNAME, $indexType)];
            $this->verglaste_fenster = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 12 + $startcol : HeizungkonfiguratorUserdatenTableMap::translateFieldName('Gebaeudelage', TableMap::TYPE_PHPNAME, $indexType)];
            $this->gebaeudelage = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 13 + $startcol : HeizungkonfiguratorUserdatenTableMap::translateFieldName('Windlage', TableMap::TYPE_PHPNAME, $indexType)];
            $this->windlage = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 14 + $startcol : HeizungkonfiguratorUserdatenTableMap::translateFieldName('AnzahlAussenwaende', TableMap::TYPE_PHPNAME, $indexType)];
            $this->anzahl_aussenwaende = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 15 + $startcol : HeizungkonfiguratorUserdatenTableMap::translateFieldName('Wohnraumtemperatur', TableMap::TYPE_PHPNAME, $indexType)];
            $this->wohnraumtemperatur = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 16 + $startcol : HeizungkonfiguratorUserdatenTableMap::translateFieldName('Aussentemperatur', TableMap::TYPE_PHPNAME, $indexType)];
            $this->aussentemperatur = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 17 + $startcol : HeizungkonfiguratorUserdatenTableMap::translateFieldName('Anmerkungen', TableMap::TYPE_PHPNAME, $indexType)];
            $this->anmerkungen = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 18 + $startcol : HeizungkonfiguratorUserdatenTableMap::translateFieldName('FotoId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->foto_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 19 + $startcol : HeizungkonfiguratorUserdatenTableMap::translateFieldName('Version', TableMap::TYPE_PHPNAME, $indexType)];
            $this->version = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 20 + $startcol : HeizungkonfiguratorUserdatenTableMap::translateFieldName('CreatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->created_at = (null !== $col) ? PropelDateTime::newInstance($col, null, '\DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 21 + $startcol : HeizungkonfiguratorUserdatenTableMap::translateFieldName('Etagen', TableMap::TYPE_PHPNAME, $indexType)];
            $this->etagen = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 22 + $startcol : HeizungkonfiguratorUserdatenTableMap::translateFieldName('DachDaemmung', TableMap::TYPE_PHPNAME, $indexType)];
            $this->dach_daemmung = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 23 + $startcol : HeizungkonfiguratorUserdatenTableMap::translateFieldName('Abgasfuehrung', TableMap::TYPE_PHPNAME, $indexType)];
            $this->abgasfuehrung = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 24 + $startcol : HeizungkonfiguratorUserdatenTableMap::translateFieldName('Waermeabgabe', TableMap::TYPE_PHPNAME, $indexType)];
            $this->waermeabgabe = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 25 + $startcol : HeizungkonfiguratorUserdatenTableMap::translateFieldName('Duschwasser', TableMap::TYPE_PHPNAME, $indexType)];
            $this->duschwasser = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 26 + $startcol : HeizungkonfiguratorUserdatenTableMap::translateFieldName('Wasserabfluss', TableMap::TYPE_PHPNAME, $indexType)];
            $this->wasserabfluss = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 27 + $startcol : HeizungkonfiguratorUserdatenTableMap::translateFieldName('Warmwasserversorgung', TableMap::TYPE_PHPNAME, $indexType)];
            $this->warmwasserversorgung = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 28 + $startcol : HeizungkonfiguratorUserdatenTableMap::translateFieldName('WarmwasserversorgungExtra', TableMap::TYPE_PHPNAME, $indexType)];
            $this->warmwasserversorgung_extra = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 29 + $startcol : HeizungkonfiguratorUserdatenTableMap::translateFieldName('WarmwasserversorgungExtraWaermepumpe', TableMap::TYPE_PHPNAME, $indexType)];
            $this->warmwasserversorgung_extra_waermepumpe = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 30; // 30 = HeizungkonfiguratorUserdatenTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating \HookKonfigurator\Model\HeizungkonfiguratorUserdaten object", 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(HeizungkonfiguratorUserdatenTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildHeizungkonfiguratorUserdatenQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collHeizungkonfiguratorImages = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see HeizungkonfiguratorUserdaten::setDeleted()
     * @see HeizungkonfiguratorUserdaten::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(HeizungkonfiguratorUserdatenTableMap::DATABASE_NAME);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = ChildHeizungkonfiguratorUserdatenQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(HeizungkonfiguratorUserdatenTableMap::DATABASE_NAME);
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
                HeizungkonfiguratorUserdatenTableMap::addInstanceToPool($this);
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

            if ($this->heizungkonfiguratorImagesScheduledForDeletion !== null) {
                if (!$this->heizungkonfiguratorImagesScheduledForDeletion->isEmpty()) {
                    \HookKonfigurator\Model\HeizungkonfiguratorImageQuery::create()
                        ->filterByPrimaryKeys($this->heizungkonfiguratorImagesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->heizungkonfiguratorImagesScheduledForDeletion = null;
                }
            }

                if ($this->collHeizungkonfiguratorImages !== null) {
            foreach ($this->collHeizungkonfiguratorImages as $referrerFK) {
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

        $this->modifiedColumns[HeizungkonfiguratorUserdatenTableMap::ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . HeizungkonfiguratorUserdatenTableMap::ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(HeizungkonfiguratorUserdatenTableMap::ID)) {
            $modifiedColumns[':p' . $index++]  = 'ID';
        }
        if ($this->isColumnModified(HeizungkonfiguratorUserdatenTableMap::USER_ID)) {
            $modifiedColumns[':p' . $index++]  = 'USER_ID';
        }
        if ($this->isColumnModified(HeizungkonfiguratorUserdatenTableMap::BRENNSTOFF_MOMENTAN)) {
            $modifiedColumns[':p' . $index++]  = 'BRENNSTOFF_MOMENTAN';
        }
        if ($this->isColumnModified(HeizungkonfiguratorUserdatenTableMap::BRENNSTOFF_ZUKUNFT)) {
            $modifiedColumns[':p' . $index++]  = 'BRENNSTOFF_ZUKUNFT';
        }
        if ($this->isColumnModified(HeizungkonfiguratorUserdatenTableMap::GEBAEUDEART)) {
            $modifiedColumns[':p' . $index++]  = 'GEBAEUDEART';
        }
        if ($this->isColumnModified(HeizungkonfiguratorUserdatenTableMap::PERSONEN_ANZAHL)) {
            $modifiedColumns[':p' . $index++]  = 'PERSONEN_ANZAHL';
        }
        if ($this->isColumnModified(HeizungkonfiguratorUserdatenTableMap::BESTEHENDE_GERAET_WARMWASSER)) {
            $modifiedColumns[':p' . $index++]  = 'BESTEHENDE_GERAET_WARMWASSER';
        }
        if ($this->isColumnModified(HeizungkonfiguratorUserdatenTableMap::BESTEHENDE_GERAET_KW)) {
            $modifiedColumns[':p' . $index++]  = 'BESTEHENDE_GERAET_KW';
        }
        if ($this->isColumnModified(HeizungkonfiguratorUserdatenTableMap::BAUJAHR)) {
            $modifiedColumns[':p' . $index++]  = 'BAUJAHR';
        }
        if ($this->isColumnModified(HeizungkonfiguratorUserdatenTableMap::HEIZFLAECHE)) {
            $modifiedColumns[':p' . $index++]  = 'HEIZFLAECHE';
        }
        if ($this->isColumnModified(HeizungkonfiguratorUserdatenTableMap::WAERMEDAEMMUNG)) {
            $modifiedColumns[':p' . $index++]  = 'WAERMEDAEMMUNG';
        }
        if ($this->isColumnModified(HeizungkonfiguratorUserdatenTableMap::VERGLASTE_FENSTER)) {
            $modifiedColumns[':p' . $index++]  = 'VERGLASTE_FENSTER';
        }
        if ($this->isColumnModified(HeizungkonfiguratorUserdatenTableMap::GEBAEUDELAGE)) {
            $modifiedColumns[':p' . $index++]  = 'GEBAEUDELAGE';
        }
        if ($this->isColumnModified(HeizungkonfiguratorUserdatenTableMap::WINDLAGE)) {
            $modifiedColumns[':p' . $index++]  = 'WINDLAGE';
        }
        if ($this->isColumnModified(HeizungkonfiguratorUserdatenTableMap::ANZAHL_AUSSENWAENDE)) {
            $modifiedColumns[':p' . $index++]  = 'ANZAHL_AUSSENWAENDE';
        }
        if ($this->isColumnModified(HeizungkonfiguratorUserdatenTableMap::WOHNRAUMTEMPERATUR)) {
            $modifiedColumns[':p' . $index++]  = 'WOHNRAUMTEMPERATUR';
        }
        if ($this->isColumnModified(HeizungkonfiguratorUserdatenTableMap::AUSSENTEMPERATUR)) {
            $modifiedColumns[':p' . $index++]  = 'AUSSENTEMPERATUR';
        }
        if ($this->isColumnModified(HeizungkonfiguratorUserdatenTableMap::ANMERKUNGEN)) {
            $modifiedColumns[':p' . $index++]  = 'ANMERKUNGEN';
        }
        if ($this->isColumnModified(HeizungkonfiguratorUserdatenTableMap::FOTO_ID)) {
            $modifiedColumns[':p' . $index++]  = 'FOTO_ID';
        }
        if ($this->isColumnModified(HeizungkonfiguratorUserdatenTableMap::VERSION)) {
            $modifiedColumns[':p' . $index++]  = 'VERSION';
        }
        if ($this->isColumnModified(HeizungkonfiguratorUserdatenTableMap::CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'CREATED_AT';
        }
        if ($this->isColumnModified(HeizungkonfiguratorUserdatenTableMap::ETAGEN)) {
            $modifiedColumns[':p' . $index++]  = 'ETAGEN';
        }
        if ($this->isColumnModified(HeizungkonfiguratorUserdatenTableMap::DACH_DAEMMUNG)) {
            $modifiedColumns[':p' . $index++]  = 'DACH_DAEMMUNG';
        }
        if ($this->isColumnModified(HeizungkonfiguratorUserdatenTableMap::ABGASFUEHRUNG)) {
            $modifiedColumns[':p' . $index++]  = 'ABGASFUEHRUNG';
        }
        if ($this->isColumnModified(HeizungkonfiguratorUserdatenTableMap::WAERMEABGABE)) {
            $modifiedColumns[':p' . $index++]  = 'WAERMEABGABE';
        }
        if ($this->isColumnModified(HeizungkonfiguratorUserdatenTableMap::DUSCHWASSER)) {
            $modifiedColumns[':p' . $index++]  = 'DUSCHWASSER';
        }
        if ($this->isColumnModified(HeizungkonfiguratorUserdatenTableMap::WASSERABFLUSS)) {
            $modifiedColumns[':p' . $index++]  = 'WASSERABFLUSS';
        }
        if ($this->isColumnModified(HeizungkonfiguratorUserdatenTableMap::WARMWASSERVERSORGUNG)) {
            $modifiedColumns[':p' . $index++]  = 'WARMWASSERVERSORGUNG';
        }
        if ($this->isColumnModified(HeizungkonfiguratorUserdatenTableMap::WARMWASSERVERSORGUNG_EXTRA)) {
            $modifiedColumns[':p' . $index++]  = 'WARMWASSERVERSORGUNG_EXTRA';
        }
        if ($this->isColumnModified(HeizungkonfiguratorUserdatenTableMap::WARMWASSERVERSORGUNG_EXTRA_WAERMEPUMPE)) {
            $modifiedColumns[':p' . $index++]  = 'WARMWASSERVERSORGUNG_EXTRA_WAERMEPUMPE';
        }

        $sql = sprintf(
            'INSERT INTO heizungkonfigurator_userdaten (%s) VALUES (%s)',
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
                    case 'BRENNSTOFF_MOMENTAN':
                        $stmt->bindValue($identifier, $this->brennstoff_momentan, PDO::PARAM_STR);
                        break;
                    case 'BRENNSTOFF_ZUKUNFT':
                        $stmt->bindValue($identifier, $this->brennstoff_zukunft, PDO::PARAM_STR);
                        break;
                    case 'GEBAEUDEART':
                        $stmt->bindValue($identifier, $this->gebaeudeart, PDO::PARAM_STR);
                        break;
                    case 'PERSONEN_ANZAHL':
                        $stmt->bindValue($identifier, $this->personen_anzahl, PDO::PARAM_INT);
                        break;
                    case 'BESTEHENDE_GERAET_WARMWASSER':
                        $stmt->bindValue($identifier, $this->bestehende_geraet_warmwasser, PDO::PARAM_STR);
                        break;
                    case 'BESTEHENDE_GERAET_KW':
                        $stmt->bindValue($identifier, $this->bestehende_geraet_kw, PDO::PARAM_INT);
                        break;
                    case 'BAUJAHR':
                        $stmt->bindValue($identifier, $this->baujahr, PDO::PARAM_INT);
                        break;
                    case 'HEIZFLAECHE':
                        $stmt->bindValue($identifier, $this->heizflaeche, PDO::PARAM_INT);
                        break;
                    case 'WAERMEDAEMMUNG':
                        $stmt->bindValue($identifier, $this->waermedaemmung, PDO::PARAM_STR);
                        break;
                    case 'VERGLASTE_FENSTER':
                        $stmt->bindValue($identifier, $this->verglaste_fenster, PDO::PARAM_STR);
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
                    case 'WOHNRAUMTEMPERATUR':
                        $stmt->bindValue($identifier, $this->wohnraumtemperatur, PDO::PARAM_INT);
                        break;
                    case 'AUSSENTEMPERATUR':
                        $stmt->bindValue($identifier, $this->aussentemperatur, PDO::PARAM_INT);
                        break;
                    case 'ANMERKUNGEN':
                        $stmt->bindValue($identifier, $this->anmerkungen, PDO::PARAM_STR);
                        break;
                    case 'FOTO_ID':
                        $stmt->bindValue($identifier, $this->foto_id, PDO::PARAM_INT);
                        break;
                    case 'VERSION':
                        $stmt->bindValue($identifier, $this->version, PDO::PARAM_STR);
                        break;
                    case 'CREATED_AT':
                        $stmt->bindValue($identifier, $this->created_at ? $this->created_at->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                    case 'ETAGEN':
                        $stmt->bindValue($identifier, $this->etagen, PDO::PARAM_INT);
                        break;
                    case 'DACH_DAEMMUNG':
                        $stmt->bindValue($identifier, $this->dach_daemmung, PDO::PARAM_STR);
                        break;
                    case 'ABGASFUEHRUNG':
                        $stmt->bindValue($identifier, $this->abgasfuehrung, PDO::PARAM_STR);
                        break;
                    case 'WAERMEABGABE':
                        $stmt->bindValue($identifier, $this->waermeabgabe, PDO::PARAM_STR);
                        break;
                    case 'DUSCHWASSER':
                        $stmt->bindValue($identifier, $this->duschwasser, PDO::PARAM_STR);
                        break;
                    case 'WASSERABFLUSS':
                        $stmt->bindValue($identifier, $this->wasserabfluss, PDO::PARAM_STR);
                        break;
                    case 'WARMWASSERVERSORGUNG':
                        $stmt->bindValue($identifier, $this->warmwasserversorgung, PDO::PARAM_STR);
                        break;
                    case 'WARMWASSERVERSORGUNG_EXTRA':
                        $stmt->bindValue($identifier, $this->warmwasserversorgung_extra, PDO::PARAM_STR);
                        break;
                    case 'WARMWASSERVERSORGUNG_EXTRA_WAERMEPUMPE':
                        $stmt->bindValue($identifier, $this->warmwasserversorgung_extra_waermepumpe, PDO::PARAM_STR);
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
        $pos = HeizungkonfiguratorUserdatenTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getBrennstoffMomentan();
                break;
            case 3:
                return $this->getBrennstoffZukunft();
                break;
            case 4:
                return $this->getGebaeudeart();
                break;
            case 5:
                return $this->getPersonenAnzahl();
                break;
            case 6:
                return $this->getBestehendeGeraetWarmwasser();
                break;
            case 7:
                return $this->getBestehendeGeraetKw();
                break;
            case 8:
                return $this->getBaujahr();
                break;
            case 9:
                return $this->getHeizflaeche();
                break;
            case 10:
                return $this->getWaermedaemmung();
                break;
            case 11:
                return $this->getVerglasteFenster();
                break;
            case 12:
                return $this->getGebaeudelage();
                break;
            case 13:
                return $this->getWindlage();
                break;
            case 14:
                return $this->getAnzahlAussenwaende();
                break;
            case 15:
                return $this->getWohnraumtemperatur();
                break;
            case 16:
                return $this->getAussentemperatur();
                break;
            case 17:
                return $this->getAnmerkungen();
                break;
            case 18:
                return $this->getFotoId();
                break;
            case 19:
                return $this->getVersion();
                break;
            case 20:
                return $this->getCreatedAt();
                break;
            case 21:
                return $this->getEtagen();
                break;
            case 22:
                return $this->getDachDaemmung();
                break;
            case 23:
                return $this->getAbgasfuehrung();
                break;
            case 24:
                return $this->getWaermeabgabe();
                break;
            case 25:
                return $this->getDuschwasser();
                break;
            case 26:
                return $this->getWasserabfluss();
                break;
            case 27:
                return $this->getWarmwasserversorgung();
                break;
            case 28:
                return $this->getWarmwasserversorgungExtra();
                break;
            case 29:
                return $this->getWarmwasserversorgungExtraWaermepumpe();
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
        if (isset($alreadyDumpedObjects['HeizungkonfiguratorUserdaten'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['HeizungkonfiguratorUserdaten'][$this->getPrimaryKey()] = true;
        $keys = HeizungkonfiguratorUserdatenTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getUserId(),
            $keys[2] => $this->getBrennstoffMomentan(),
            $keys[3] => $this->getBrennstoffZukunft(),
            $keys[4] => $this->getGebaeudeart(),
            $keys[5] => $this->getPersonenAnzahl(),
            $keys[6] => $this->getBestehendeGeraetWarmwasser(),
            $keys[7] => $this->getBestehendeGeraetKw(),
            $keys[8] => $this->getBaujahr(),
            $keys[9] => $this->getHeizflaeche(),
            $keys[10] => $this->getWaermedaemmung(),
            $keys[11] => $this->getVerglasteFenster(),
            $keys[12] => $this->getGebaeudelage(),
            $keys[13] => $this->getWindlage(),
            $keys[14] => $this->getAnzahlAussenwaende(),
            $keys[15] => $this->getWohnraumtemperatur(),
            $keys[16] => $this->getAussentemperatur(),
            $keys[17] => $this->getAnmerkungen(),
            $keys[18] => $this->getFotoId(),
            $keys[19] => $this->getVersion(),
            $keys[20] => $this->getCreatedAt(),
            $keys[21] => $this->getEtagen(),
            $keys[22] => $this->getDachDaemmung(),
            $keys[23] => $this->getAbgasfuehrung(),
            $keys[24] => $this->getWaermeabgabe(),
            $keys[25] => $this->getDuschwasser(),
            $keys[26] => $this->getWasserabfluss(),
            $keys[27] => $this->getWarmwasserversorgung(),
            $keys[28] => $this->getWarmwasserversorgungExtra(),
            $keys[29] => $this->getWarmwasserversorgungExtraWaermepumpe(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->collHeizungkonfiguratorImages) {
                $result['HeizungkonfiguratorImages'] = $this->collHeizungkonfiguratorImages->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
        $pos = HeizungkonfiguratorUserdatenTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

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
                $this->setBrennstoffMomentan($value);
                break;
            case 3:
                $this->setBrennstoffZukunft($value);
                break;
            case 4:
                $this->setGebaeudeart($value);
                break;
            case 5:
                $this->setPersonenAnzahl($value);
                break;
            case 6:
                $this->setBestehendeGeraetWarmwasser($value);
                break;
            case 7:
                $this->setBestehendeGeraetKw($value);
                break;
            case 8:
                $this->setBaujahr($value);
                break;
            case 9:
                $this->setHeizflaeche($value);
                break;
            case 10:
                $this->setWaermedaemmung($value);
                break;
            case 11:
                $this->setVerglasteFenster($value);
                break;
            case 12:
                $this->setGebaeudelage($value);
                break;
            case 13:
                $this->setWindlage($value);
                break;
            case 14:
                $this->setAnzahlAussenwaende($value);
                break;
            case 15:
                $this->setWohnraumtemperatur($value);
                break;
            case 16:
                $this->setAussentemperatur($value);
                break;
            case 17:
                $this->setAnmerkungen($value);
                break;
            case 18:
                $this->setFotoId($value);
                break;
            case 19:
                $this->setVersion($value);
                break;
            case 20:
                $this->setCreatedAt($value);
                break;
            case 21:
                $this->setEtagen($value);
                break;
            case 22:
                $this->setDachDaemmung($value);
                break;
            case 23:
                $this->setAbgasfuehrung($value);
                break;
            case 24:
                $this->setWaermeabgabe($value);
                break;
            case 25:
                $this->setDuschwasser($value);
                break;
            case 26:
                $this->setWasserabfluss($value);
                break;
            case 27:
                $this->setWarmwasserversorgung($value);
                break;
            case 28:
                $this->setWarmwasserversorgungExtra($value);
                break;
            case 29:
                $this->setWarmwasserversorgungExtraWaermepumpe($value);
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
        $keys = HeizungkonfiguratorUserdatenTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setUserId($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setBrennstoffMomentan($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setBrennstoffZukunft($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setGebaeudeart($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setPersonenAnzahl($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setBestehendeGeraetWarmwasser($arr[$keys[6]]);
        if (array_key_exists($keys[7], $arr)) $this->setBestehendeGeraetKw($arr[$keys[7]]);
        if (array_key_exists($keys[8], $arr)) $this->setBaujahr($arr[$keys[8]]);
        if (array_key_exists($keys[9], $arr)) $this->setHeizflaeche($arr[$keys[9]]);
        if (array_key_exists($keys[10], $arr)) $this->setWaermedaemmung($arr[$keys[10]]);
        if (array_key_exists($keys[11], $arr)) $this->setVerglasteFenster($arr[$keys[11]]);
        if (array_key_exists($keys[12], $arr)) $this->setGebaeudelage($arr[$keys[12]]);
        if (array_key_exists($keys[13], $arr)) $this->setWindlage($arr[$keys[13]]);
        if (array_key_exists($keys[14], $arr)) $this->setAnzahlAussenwaende($arr[$keys[14]]);
        if (array_key_exists($keys[15], $arr)) $this->setWohnraumtemperatur($arr[$keys[15]]);
        if (array_key_exists($keys[16], $arr)) $this->setAussentemperatur($arr[$keys[16]]);
        if (array_key_exists($keys[17], $arr)) $this->setAnmerkungen($arr[$keys[17]]);
        if (array_key_exists($keys[18], $arr)) $this->setFotoId($arr[$keys[18]]);
        if (array_key_exists($keys[19], $arr)) $this->setVersion($arr[$keys[19]]);
        if (array_key_exists($keys[20], $arr)) $this->setCreatedAt($arr[$keys[20]]);
        if (array_key_exists($keys[21], $arr)) $this->setEtagen($arr[$keys[21]]);
        if (array_key_exists($keys[22], $arr)) $this->setDachDaemmung($arr[$keys[22]]);
        if (array_key_exists($keys[23], $arr)) $this->setAbgasfuehrung($arr[$keys[23]]);
        if (array_key_exists($keys[24], $arr)) $this->setWaermeabgabe($arr[$keys[24]]);
        if (array_key_exists($keys[25], $arr)) $this->setDuschwasser($arr[$keys[25]]);
        if (array_key_exists($keys[26], $arr)) $this->setWasserabfluss($arr[$keys[26]]);
        if (array_key_exists($keys[27], $arr)) $this->setWarmwasserversorgung($arr[$keys[27]]);
        if (array_key_exists($keys[28], $arr)) $this->setWarmwasserversorgungExtra($arr[$keys[28]]);
        if (array_key_exists($keys[29], $arr)) $this->setWarmwasserversorgungExtraWaermepumpe($arr[$keys[29]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(HeizungkonfiguratorUserdatenTableMap::DATABASE_NAME);

        if ($this->isColumnModified(HeizungkonfiguratorUserdatenTableMap::ID)) $criteria->add(HeizungkonfiguratorUserdatenTableMap::ID, $this->id);
        if ($this->isColumnModified(HeizungkonfiguratorUserdatenTableMap::USER_ID)) $criteria->add(HeizungkonfiguratorUserdatenTableMap::USER_ID, $this->user_id);
        if ($this->isColumnModified(HeizungkonfiguratorUserdatenTableMap::BRENNSTOFF_MOMENTAN)) $criteria->add(HeizungkonfiguratorUserdatenTableMap::BRENNSTOFF_MOMENTAN, $this->brennstoff_momentan);
        if ($this->isColumnModified(HeizungkonfiguratorUserdatenTableMap::BRENNSTOFF_ZUKUNFT)) $criteria->add(HeizungkonfiguratorUserdatenTableMap::BRENNSTOFF_ZUKUNFT, $this->brennstoff_zukunft);
        if ($this->isColumnModified(HeizungkonfiguratorUserdatenTableMap::GEBAEUDEART)) $criteria->add(HeizungkonfiguratorUserdatenTableMap::GEBAEUDEART, $this->gebaeudeart);
        if ($this->isColumnModified(HeizungkonfiguratorUserdatenTableMap::PERSONEN_ANZAHL)) $criteria->add(HeizungkonfiguratorUserdatenTableMap::PERSONEN_ANZAHL, $this->personen_anzahl);
        if ($this->isColumnModified(HeizungkonfiguratorUserdatenTableMap::BESTEHENDE_GERAET_WARMWASSER)) $criteria->add(HeizungkonfiguratorUserdatenTableMap::BESTEHENDE_GERAET_WARMWASSER, $this->bestehende_geraet_warmwasser);
        if ($this->isColumnModified(HeizungkonfiguratorUserdatenTableMap::BESTEHENDE_GERAET_KW)) $criteria->add(HeizungkonfiguratorUserdatenTableMap::BESTEHENDE_GERAET_KW, $this->bestehende_geraet_kw);
        if ($this->isColumnModified(HeizungkonfiguratorUserdatenTableMap::BAUJAHR)) $criteria->add(HeizungkonfiguratorUserdatenTableMap::BAUJAHR, $this->baujahr);
        if ($this->isColumnModified(HeizungkonfiguratorUserdatenTableMap::HEIZFLAECHE)) $criteria->add(HeizungkonfiguratorUserdatenTableMap::HEIZFLAECHE, $this->heizflaeche);
        if ($this->isColumnModified(HeizungkonfiguratorUserdatenTableMap::WAERMEDAEMMUNG)) $criteria->add(HeizungkonfiguratorUserdatenTableMap::WAERMEDAEMMUNG, $this->waermedaemmung);
        if ($this->isColumnModified(HeizungkonfiguratorUserdatenTableMap::VERGLASTE_FENSTER)) $criteria->add(HeizungkonfiguratorUserdatenTableMap::VERGLASTE_FENSTER, $this->verglaste_fenster);
        if ($this->isColumnModified(HeizungkonfiguratorUserdatenTableMap::GEBAEUDELAGE)) $criteria->add(HeizungkonfiguratorUserdatenTableMap::GEBAEUDELAGE, $this->gebaeudelage);
        if ($this->isColumnModified(HeizungkonfiguratorUserdatenTableMap::WINDLAGE)) $criteria->add(HeizungkonfiguratorUserdatenTableMap::WINDLAGE, $this->windlage);
        if ($this->isColumnModified(HeizungkonfiguratorUserdatenTableMap::ANZAHL_AUSSENWAENDE)) $criteria->add(HeizungkonfiguratorUserdatenTableMap::ANZAHL_AUSSENWAENDE, $this->anzahl_aussenwaende);
        if ($this->isColumnModified(HeizungkonfiguratorUserdatenTableMap::WOHNRAUMTEMPERATUR)) $criteria->add(HeizungkonfiguratorUserdatenTableMap::WOHNRAUMTEMPERATUR, $this->wohnraumtemperatur);
        if ($this->isColumnModified(HeizungkonfiguratorUserdatenTableMap::AUSSENTEMPERATUR)) $criteria->add(HeizungkonfiguratorUserdatenTableMap::AUSSENTEMPERATUR, $this->aussentemperatur);
        if ($this->isColumnModified(HeizungkonfiguratorUserdatenTableMap::ANMERKUNGEN)) $criteria->add(HeizungkonfiguratorUserdatenTableMap::ANMERKUNGEN, $this->anmerkungen);
        if ($this->isColumnModified(HeizungkonfiguratorUserdatenTableMap::FOTO_ID)) $criteria->add(HeizungkonfiguratorUserdatenTableMap::FOTO_ID, $this->foto_id);
        if ($this->isColumnModified(HeizungkonfiguratorUserdatenTableMap::VERSION)) $criteria->add(HeizungkonfiguratorUserdatenTableMap::VERSION, $this->version);
        if ($this->isColumnModified(HeizungkonfiguratorUserdatenTableMap::CREATED_AT)) $criteria->add(HeizungkonfiguratorUserdatenTableMap::CREATED_AT, $this->created_at);
        if ($this->isColumnModified(HeizungkonfiguratorUserdatenTableMap::ETAGEN)) $criteria->add(HeizungkonfiguratorUserdatenTableMap::ETAGEN, $this->etagen);
        if ($this->isColumnModified(HeizungkonfiguratorUserdatenTableMap::DACH_DAEMMUNG)) $criteria->add(HeizungkonfiguratorUserdatenTableMap::DACH_DAEMMUNG, $this->dach_daemmung);
        if ($this->isColumnModified(HeizungkonfiguratorUserdatenTableMap::ABGASFUEHRUNG)) $criteria->add(HeizungkonfiguratorUserdatenTableMap::ABGASFUEHRUNG, $this->abgasfuehrung);
        if ($this->isColumnModified(HeizungkonfiguratorUserdatenTableMap::WAERMEABGABE)) $criteria->add(HeizungkonfiguratorUserdatenTableMap::WAERMEABGABE, $this->waermeabgabe);
        if ($this->isColumnModified(HeizungkonfiguratorUserdatenTableMap::DUSCHWASSER)) $criteria->add(HeizungkonfiguratorUserdatenTableMap::DUSCHWASSER, $this->duschwasser);
        if ($this->isColumnModified(HeizungkonfiguratorUserdatenTableMap::WASSERABFLUSS)) $criteria->add(HeizungkonfiguratorUserdatenTableMap::WASSERABFLUSS, $this->wasserabfluss);
        if ($this->isColumnModified(HeizungkonfiguratorUserdatenTableMap::WARMWASSERVERSORGUNG)) $criteria->add(HeizungkonfiguratorUserdatenTableMap::WARMWASSERVERSORGUNG, $this->warmwasserversorgung);
        if ($this->isColumnModified(HeizungkonfiguratorUserdatenTableMap::WARMWASSERVERSORGUNG_EXTRA)) $criteria->add(HeizungkonfiguratorUserdatenTableMap::WARMWASSERVERSORGUNG_EXTRA, $this->warmwasserversorgung_extra);
        if ($this->isColumnModified(HeizungkonfiguratorUserdatenTableMap::WARMWASSERVERSORGUNG_EXTRA_WAERMEPUMPE)) $criteria->add(HeizungkonfiguratorUserdatenTableMap::WARMWASSERVERSORGUNG_EXTRA_WAERMEPUMPE, $this->warmwasserversorgung_extra_waermepumpe);

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
        $criteria = new Criteria(HeizungkonfiguratorUserdatenTableMap::DATABASE_NAME);
        $criteria->add(HeizungkonfiguratorUserdatenTableMap::ID, $this->id);

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
     * @param      object $copyObj An object of \HookKonfigurator\Model\HeizungkonfiguratorUserdaten (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setUserId($this->getUserId());
        $copyObj->setBrennstoffMomentan($this->getBrennstoffMomentan());
        $copyObj->setBrennstoffZukunft($this->getBrennstoffZukunft());
        $copyObj->setGebaeudeart($this->getGebaeudeart());
        $copyObj->setPersonenAnzahl($this->getPersonenAnzahl());
        $copyObj->setBestehendeGeraetWarmwasser($this->getBestehendeGeraetWarmwasser());
        $copyObj->setBestehendeGeraetKw($this->getBestehendeGeraetKw());
        $copyObj->setBaujahr($this->getBaujahr());
        $copyObj->setHeizflaeche($this->getHeizflaeche());
        $copyObj->setWaermedaemmung($this->getWaermedaemmung());
        $copyObj->setVerglasteFenster($this->getVerglasteFenster());
        $copyObj->setGebaeudelage($this->getGebaeudelage());
        $copyObj->setWindlage($this->getWindlage());
        $copyObj->setAnzahlAussenwaende($this->getAnzahlAussenwaende());
        $copyObj->setWohnraumtemperatur($this->getWohnraumtemperatur());
        $copyObj->setAussentemperatur($this->getAussentemperatur());
        $copyObj->setAnmerkungen($this->getAnmerkungen());
        $copyObj->setFotoId($this->getFotoId());
        $copyObj->setVersion($this->getVersion());
        $copyObj->setCreatedAt($this->getCreatedAt());
        $copyObj->setEtagen($this->getEtagen());
        $copyObj->setDachDaemmung($this->getDachDaemmung());
        $copyObj->setAbgasfuehrung($this->getAbgasfuehrung());
        $copyObj->setWaermeabgabe($this->getWaermeabgabe());
        $copyObj->setDuschwasser($this->getDuschwasser());
        $copyObj->setWasserabfluss($this->getWasserabfluss());
        $copyObj->setWarmwasserversorgung($this->getWarmwasserversorgung());
        $copyObj->setWarmwasserversorgungExtra($this->getWarmwasserversorgungExtra());
        $copyObj->setWarmwasserversorgungExtraWaermepumpe($this->getWarmwasserversorgungExtraWaermepumpe());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getHeizungkonfiguratorImages() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addHeizungkonfiguratorImage($relObj->copy($deepCopy));
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
     * @return                 \HookKonfigurator\Model\HeizungkonfiguratorUserdaten Clone of current object.
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
        if ('HeizungkonfiguratorImage' == $relationName) {
            return $this->initHeizungkonfiguratorImages();
        }
    }

    /**
     * Clears out the collHeizungkonfiguratorImages collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addHeizungkonfiguratorImages()
     */
    public function clearHeizungkonfiguratorImages()
    {
        $this->collHeizungkonfiguratorImages = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collHeizungkonfiguratorImages collection loaded partially.
     */
    public function resetPartialHeizungkonfiguratorImages($v = true)
    {
        $this->collHeizungkonfiguratorImagesPartial = $v;
    }

    /**
     * Initializes the collHeizungkonfiguratorImages collection.
     *
     * By default this just sets the collHeizungkonfiguratorImages collection to an empty array (like clearcollHeizungkonfiguratorImages());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initHeizungkonfiguratorImages($overrideExisting = true)
    {
        if (null !== $this->collHeizungkonfiguratorImages && !$overrideExisting) {
            return;
        }
        $this->collHeizungkonfiguratorImages = new ObjectCollection();
        $this->collHeizungkonfiguratorImages->setModel('\HookKonfigurator\Model\HeizungkonfiguratorImage');
    }

    /**
     * Gets an array of ChildHeizungkonfiguratorImage objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildHeizungkonfiguratorUserdaten is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return Collection|ChildHeizungkonfiguratorImage[] List of ChildHeizungkonfiguratorImage objects
     * @throws PropelException
     */
    public function getHeizungkonfiguratorImages($criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collHeizungkonfiguratorImagesPartial && !$this->isNew();
        if (null === $this->collHeizungkonfiguratorImages || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collHeizungkonfiguratorImages) {
                // return empty collection
                $this->initHeizungkonfiguratorImages();
            } else {
                $collHeizungkonfiguratorImages = ChildHeizungkonfiguratorImageQuery::create(null, $criteria)
                    ->filterByHeizungkonfiguratorUserdaten($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collHeizungkonfiguratorImagesPartial && count($collHeizungkonfiguratorImages)) {
                        $this->initHeizungkonfiguratorImages(false);

                        foreach ($collHeizungkonfiguratorImages as $obj) {
                            if (false == $this->collHeizungkonfiguratorImages->contains($obj)) {
                                $this->collHeizungkonfiguratorImages->append($obj);
                            }
                        }

                        $this->collHeizungkonfiguratorImagesPartial = true;
                    }

                    reset($collHeizungkonfiguratorImages);

                    return $collHeizungkonfiguratorImages;
                }

                if ($partial && $this->collHeizungkonfiguratorImages) {
                    foreach ($this->collHeizungkonfiguratorImages as $obj) {
                        if ($obj->isNew()) {
                            $collHeizungkonfiguratorImages[] = $obj;
                        }
                    }
                }

                $this->collHeizungkonfiguratorImages = $collHeizungkonfiguratorImages;
                $this->collHeizungkonfiguratorImagesPartial = false;
            }
        }

        return $this->collHeizungkonfiguratorImages;
    }

    /**
     * Sets a collection of HeizungkonfiguratorImage objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $heizungkonfiguratorImages A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return   ChildHeizungkonfiguratorUserdaten The current object (for fluent API support)
     */
    public function setHeizungkonfiguratorImages(Collection $heizungkonfiguratorImages, ConnectionInterface $con = null)
    {
        $heizungkonfiguratorImagesToDelete = $this->getHeizungkonfiguratorImages(new Criteria(), $con)->diff($heizungkonfiguratorImages);


        $this->heizungkonfiguratorImagesScheduledForDeletion = $heizungkonfiguratorImagesToDelete;

        foreach ($heizungkonfiguratorImagesToDelete as $heizungkonfiguratorImageRemoved) {
            $heizungkonfiguratorImageRemoved->setHeizungkonfiguratorUserdaten(null);
        }

        $this->collHeizungkonfiguratorImages = null;
        foreach ($heizungkonfiguratorImages as $heizungkonfiguratorImage) {
            $this->addHeizungkonfiguratorImage($heizungkonfiguratorImage);
        }

        $this->collHeizungkonfiguratorImages = $heizungkonfiguratorImages;
        $this->collHeizungkonfiguratorImagesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related HeizungkonfiguratorImage objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related HeizungkonfiguratorImage objects.
     * @throws PropelException
     */
    public function countHeizungkonfiguratorImages(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collHeizungkonfiguratorImagesPartial && !$this->isNew();
        if (null === $this->collHeizungkonfiguratorImages || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collHeizungkonfiguratorImages) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getHeizungkonfiguratorImages());
            }

            $query = ChildHeizungkonfiguratorImageQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByHeizungkonfiguratorUserdaten($this)
                ->count($con);
        }

        return count($this->collHeizungkonfiguratorImages);
    }

    /**
     * Method called to associate a ChildHeizungkonfiguratorImage object to this object
     * through the ChildHeizungkonfiguratorImage foreign key attribute.
     *
     * @param    ChildHeizungkonfiguratorImage $l ChildHeizungkonfiguratorImage
     * @return   \HookKonfigurator\Model\HeizungkonfiguratorUserdaten The current object (for fluent API support)
     */
    public function addHeizungkonfiguratorImage(ChildHeizungkonfiguratorImage $l)
    {
        if ($this->collHeizungkonfiguratorImages === null) {
            $this->initHeizungkonfiguratorImages();
            $this->collHeizungkonfiguratorImagesPartial = true;
        }

        if (!in_array($l, $this->collHeizungkonfiguratorImages->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddHeizungkonfiguratorImage($l);
        }

        return $this;
    }

    /**
     * @param HeizungkonfiguratorImage $heizungkonfiguratorImage The heizungkonfiguratorImage object to add.
     */
    protected function doAddHeizungkonfiguratorImage($heizungkonfiguratorImage)
    {
        $this->collHeizungkonfiguratorImages[]= $heizungkonfiguratorImage;
        $heizungkonfiguratorImage->setHeizungkonfiguratorUserdaten($this);
    }

    /**
     * @param  HeizungkonfiguratorImage $heizungkonfiguratorImage The heizungkonfiguratorImage object to remove.
     * @return ChildHeizungkonfiguratorUserdaten The current object (for fluent API support)
     */
    public function removeHeizungkonfiguratorImage($heizungkonfiguratorImage)
    {
        if ($this->getHeizungkonfiguratorImages()->contains($heizungkonfiguratorImage)) {
            $this->collHeizungkonfiguratorImages->remove($this->collHeizungkonfiguratorImages->search($heizungkonfiguratorImage));
            if (null === $this->heizungkonfiguratorImagesScheduledForDeletion) {
                $this->heizungkonfiguratorImagesScheduledForDeletion = clone $this->collHeizungkonfiguratorImages;
                $this->heizungkonfiguratorImagesScheduledForDeletion->clear();
            }
            $this->heizungkonfiguratorImagesScheduledForDeletion[]= clone $heizungkonfiguratorImage;
            $heizungkonfiguratorImage->setHeizungkonfiguratorUserdaten(null);
        }

        return $this;
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->id = null;
        $this->user_id = null;
        $this->brennstoff_momentan = null;
        $this->brennstoff_zukunft = null;
        $this->gebaeudeart = null;
        $this->personen_anzahl = null;
        $this->bestehende_geraet_warmwasser = null;
        $this->bestehende_geraet_kw = null;
        $this->baujahr = null;
        $this->heizflaeche = null;
        $this->waermedaemmung = null;
        $this->verglaste_fenster = null;
        $this->gebaeudelage = null;
        $this->windlage = null;
        $this->anzahl_aussenwaende = null;
        $this->wohnraumtemperatur = null;
        $this->aussentemperatur = null;
        $this->anmerkungen = null;
        $this->foto_id = null;
        $this->version = null;
        $this->created_at = null;
        $this->etagen = null;
        $this->dach_daemmung = null;
        $this->abgasfuehrung = null;
        $this->waermeabgabe = null;
        $this->duschwasser = null;
        $this->wasserabfluss = null;
        $this->warmwasserversorgung = null;
        $this->warmwasserversorgung_extra = null;
        $this->warmwasserversorgung_extra_waermepumpe = null;
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
            if ($this->collHeizungkonfiguratorImages) {
                foreach ($this->collHeizungkonfiguratorImages as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collHeizungkonfiguratorImages = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(HeizungkonfiguratorUserdatenTableMap::DEFAULT_STRING_FORMAT);
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
