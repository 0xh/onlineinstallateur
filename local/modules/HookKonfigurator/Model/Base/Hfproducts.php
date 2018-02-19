<?php

namespace HookKonfigurator\Model\Base;

use HookKonfigurator\Model\HfproductsQuery as ChildHfproductsQuery;
use \DateTime;
use \Exception;
use \PDO;
use HookKonfigurator\Model\Map\HfproductsTableMap;
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

abstract class Hfproducts implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = 'HookKonfigurator\\Model\\Map\\HfproductsTableMap';


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
     * The value for the vendor_id field.
     * @var        int
     */
    protected $vendor_id;

    /**
     * The value for the name field.
     * @var        string
     */
    protected $name;

    /**
     * The value for the oag_name field.
     * @var        string
     */
    protected $oag_name;

    /**
     * The value for the type_id field.
     * @var        int
     */
    protected $type_id;

    /**
     * The value for the product_number field.
     * @var        string
     */
    protected $product_number;

    /**
     * The value for the grade field.
     * @var        string
     */
    protected $grade;

    /**
     * The value for the build_year_from field.
     * @var        int
     */
    protected $build_year_from;

    /**
     * The value for the build_year_to field.
     * @var        int
     */
    protected $build_year_to;

    /**
     * The value for the createdat field.
     * @var        string
     */
    protected $createdat;

    /**
     * The value for the updatedat field.
     * @var        string
     */
    protected $updatedat;

    /**
     * The value for the sht_product field.
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $sht_product;

    /**
     * The value for the sht_id field.
     * @var        string
     */
    protected $sht_id;

    /**
     * The value for the sht_category field.
     * @var        int
     */
    protected $sht_category;

    /**
     * The value for the sht_text1 field.
     * @var        string
     */
    protected $sht_text1;

    /**
     * The value for the sht_text2 field.
     * @var        string
     */
    protected $sht_text2;

    /**
     * The value for the oag_product field.
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $oag_product;

    /**
     * The value for the oag_id field.
     * @var        string
     */
    protected $oag_id;

    /**
     * The value for the oag_category field.
     * @var        int
     */
    protected $oag_category;

    /**
     * The value for the oag_text1 field.
     * @var        string
     */
    protected $oag_text1;

    /**
     * The value for the oag_text2 field.
     * @var        string
     */
    protected $oag_text2;

    /**
     * The value for the megabild_id field.
     * @var        int
     */
    protected $megabild_id;

    /**
     * The value for the image field.
     * @var        string
     */
    protected $image;

    /**
     * The value for the specification_name field.
     * @var        string
     */
    protected $specification_name;

    /**
     * The value for the label_name field.
     * @var        string
     */
    protected $label_name;

    /**
     * The value for the water_heater_energy_class field.
     * @var        string
     */
    protected $water_heater_energy_class;

    /**
     * The value for the water_heater_energy_efficiency field.
     * @var        int
     */
    protected $water_heater_energy_efficiency;

    /**
     * The value for the water_heater_energy_grade field.
     * @var        string
     */
    protected $water_heater_energy_grade;

    /**
     * The value for the space_heater_efficiency field.
     * @var        int
     */
    protected $space_heater_efficiency;

    /**
     * The value for the space_heater_power field.
     * @var        int
     */
    protected $space_heater_power;

    /**
     * The value for the space_heater_type field.
     * @var        string
     */
    protected $space_heater_type;

    /**
     * The value for the space_heater_low_temperature_heat_pump field.
     * @var        boolean
     */
    protected $space_heater_low_temperature_heat_pump;

    /**
     * The value for the space_heater_colder_efficiency field.
     * @var        int
     */
    protected $space_heater_colder_efficiency;

    /**
     * The value for the space_heater_warmer_efficiency field.
     * @var        int
     */
    protected $space_heater_warmer_efficiency;

    /**
     * The value for the space_heater_low_temperature_grade field.
     * @var        string
     */
    protected $space_heater_low_temperature_grade;

    /**
     * The value for the space_heater_low_temperature_efficiency field.
     * @var        int
     */
    protected $space_heater_low_temperature_efficiency;

    /**
     * The value for the space_heater_low_temperature_colder_efficiency field.
     * @var        int
     */
    protected $space_heater_low_temperature_colder_efficiency;

    /**
     * The value for the space_heater_low_temperature_warmer_efficiency field.
     * @var        int
     */
    protected $space_heater_low_temperature_warmer_efficiency;

    /**
     * The value for the space_heater_low_temperature_supplementary_power field.
     * @var        int
     */
    protected $space_heater_low_temperature_supplementary_power;

    /**
     * The value for the space_heater_low_temperature_power field.
     * @var        int
     */
    protected $space_heater_low_temperature_power;

    /**
     * The value for the solar_efficiency field.
     * @var        string
     */
    protected $solar_efficiency;

    /**
     * The value for the solar_size field.
     * @var        string
     */
    protected $solar_size;

    /**
     * The value for the solar_pump_power field.
     * @var        int
     */
    protected $solar_pump_power;

    /**
     * The value for the storage_type field.
     * @var        string
     */
    protected $storage_type;

    /**
     * The value for the storage_volume field.
     * @var        string
     */
    protected $storage_volume;

    /**
     * The value for the storage_non_solar_volume field.
     * @var        string
     */
    protected $storage_non_solar_volume;

    /**
     * The value for the storage_warmth_loss field.
     * @var        int
     */
    protected $storage_warmth_loss;

    /**
     * The value for the combination_heater_space_heater_grade field.
     * @var        string
     */
    protected $combination_heater_space_heater_grade;

    /**
     * The value for the combination_heater_water_heater_grade field.
     * @var        string
     */
    protected $combination_heater_water_heater_grade;

    /**
     * The value for the combined_efficiency field.
     * @var        int
     */
    protected $combined_efficiency;

    /**
     * The value for the combined_main_heater_type_id field.
     * @var        int
     */
    protected $combined_main_heater_type_id;

    /**
     * The value for the temperature_control_standby_warmth_loss field.
     * @var        string
     */
    protected $temperature_control_standby_warmth_loss;

    /**
     * The value for the temperature_control_type field.
     * @var        string
     */
    protected $temperature_control_type;

    /**
     * The value for the supplementary_power field.
     * @var        int
     */
    protected $supplementary_power;

    /**
     * The value for the montage_id field.
     * @var        int
     */
    protected $montage_id;

    /**
     * The value for the price field.
     * Note: this column has a database default value of: '0.00'
     * @var        string
     */
    protected $price;

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
        $this->sht_product = false;
        $this->oag_product = false;
        $this->price = '0.00';
    }

    /**
     * Initializes internal state of Base\Hfproducts object.
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
     * Compares this with another <code>Hfproducts</code> instance.  If
     * <code>obj</code> is an instance of <code>Hfproducts</code>, delegates to
     * <code>equals(Hfproducts)</code>.  Otherwise, returns <code>false</code>.
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
     * @return Hfproducts The current object, for fluid interface
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
     * @return Hfproducts The current object, for fluid interface
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
     * Get the [vendor_id] column value.
     *
     * @return   int
     */
    public function getVendorId()
    {

        return $this->vendor_id;
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
     * Get the [oag_name] column value.
     *
     * @return   string
     */
    public function getOagName()
    {

        return $this->oag_name;
    }

    /**
     * Get the [type_id] column value.
     *
     * @return   int
     */
    public function getTypeId()
    {

        return $this->type_id;
    }

    /**
     * Get the [product_number] column value.
     *
     * @return   string
     */
    public function getProductNumber()
    {

        return $this->product_number;
    }

    /**
     * Get the [grade] column value.
     *
     * @return   string
     */
    public function getGrade()
    {

        return $this->grade;
    }

    /**
     * Get the [build_year_from] column value.
     *
     * @return   int
     */
    public function getBuildYearFrom()
    {

        return $this->build_year_from;
    }

    /**
     * Get the [build_year_to] column value.
     *
     * @return   int
     */
    public function getBuildYearTo()
    {

        return $this->build_year_to;
    }

    /**
     * Get the [optionally formatted] temporal [createdat] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw \DateTime object will be returned.
     *
     * @return mixed Formatted date/time value as string or \DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getCreatedat($format = NULL)
    {
        if ($format === null) {
            return $this->createdat;
        } else {
            return $this->createdat instanceof \DateTime ? $this->createdat->format($format) : null;
        }
    }

    /**
     * Get the [optionally formatted] temporal [updatedat] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw \DateTime object will be returned.
     *
     * @return mixed Formatted date/time value as string or \DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getUpdatedat($format = NULL)
    {
        if ($format === null) {
            return $this->updatedat;
        } else {
            return $this->updatedat instanceof \DateTime ? $this->updatedat->format($format) : null;
        }
    }

    /**
     * Get the [sht_product] column value.
     *
     * @return   boolean
     */
    public function getShtProduct()
    {

        return $this->sht_product;
    }

    /**
     * Get the [sht_id] column value.
     *
     * @return   string
     */
    public function getShtId()
    {

        return $this->sht_id;
    }

    /**
     * Get the [sht_category] column value.
     *
     * @return   int
     */
    public function getShtCategory()
    {

        return $this->sht_category;
    }

    /**
     * Get the [sht_text1] column value.
     *
     * @return   string
     */
    public function getShtText1()
    {

        return $this->sht_text1;
    }

    /**
     * Get the [sht_text2] column value.
     *
     * @return   string
     */
    public function getShtText2()
    {

        return $this->sht_text2;
    }

    /**
     * Get the [oag_product] column value.
     *
     * @return   boolean
     */
    public function getOagProduct()
    {

        return $this->oag_product;
    }

    /**
     * Get the [oag_id] column value.
     *
     * @return   string
     */
    public function getOagId()
    {

        return $this->oag_id;
    }

    /**
     * Get the [oag_category] column value.
     *
     * @return   int
     */
    public function getOagCategory()
    {

        return $this->oag_category;
    }

    /**
     * Get the [oag_text1] column value.
     *
     * @return   string
     */
    public function getOagText1()
    {

        return $this->oag_text1;
    }

    /**
     * Get the [oag_text2] column value.
     *
     * @return   string
     */
    public function getOagText2()
    {

        return $this->oag_text2;
    }

    /**
     * Get the [megabild_id] column value.
     *
     * @return   int
     */
    public function getMegabildId()
    {

        return $this->megabild_id;
    }

    /**
     * Get the [image] column value.
     *
     * @return   string
     */
    public function getImage()
    {

        return $this->image;
    }

    /**
     * Get the [specification_name] column value.
     *
     * @return   string
     */
    public function getSpecificationName()
    {

        return $this->specification_name;
    }

    /**
     * Get the [label_name] column value.
     *
     * @return   string
     */
    public function getLabelName()
    {

        return $this->label_name;
    }

    /**
     * Get the [water_heater_energy_class] column value.
     *
     * @return   string
     */
    public function getWaterHeaterEnergyClass()
    {

        return $this->water_heater_energy_class;
    }

    /**
     * Get the [water_heater_energy_efficiency] column value.
     *
     * @return   int
     */
    public function getWaterHeaterEnergyEfficiency()
    {

        return $this->water_heater_energy_efficiency;
    }

    /**
     * Get the [water_heater_energy_grade] column value.
     *
     * @return   string
     */
    public function getWaterHeaterEnergyGrade()
    {

        return $this->water_heater_energy_grade;
    }

    /**
     * Get the [space_heater_efficiency] column value.
     *
     * @return   int
     */
    public function getSpaceHeaterEfficiency()
    {

        return $this->space_heater_efficiency;
    }

    /**
     * Get the [space_heater_power] column value.
     *
     * @return   int
     */
    public function getSpaceHeaterPower()
    {

        return $this->space_heater_power;
    }

    /**
     * Get the [space_heater_type] column value.
     *
     * @return   string
     */
    public function getSpaceHeaterType()
    {

        return $this->space_heater_type;
    }

    /**
     * Get the [space_heater_low_temperature_heat_pump] column value.
     *
     * @return   boolean
     */
    public function getSpaceHeaterLowTemperatureHeatPump()
    {

        return $this->space_heater_low_temperature_heat_pump;
    }

    /**
     * Get the [space_heater_colder_efficiency] column value.
     *
     * @return   int
     */
    public function getSpaceHeaterColderEfficiency()
    {

        return $this->space_heater_colder_efficiency;
    }

    /**
     * Get the [space_heater_warmer_efficiency] column value.
     *
     * @return   int
     */
    public function getSpaceHeaterWarmerEfficiency()
    {

        return $this->space_heater_warmer_efficiency;
    }

    /**
     * Get the [space_heater_low_temperature_grade] column value.
     *
     * @return   string
     */
    public function getSpaceHeaterLowTemperatureGrade()
    {

        return $this->space_heater_low_temperature_grade;
    }

    /**
     * Get the [space_heater_low_temperature_efficiency] column value.
     *
     * @return   int
     */
    public function getSpaceHeaterLowTemperatureEfficiency()
    {

        return $this->space_heater_low_temperature_efficiency;
    }

    /**
     * Get the [space_heater_low_temperature_colder_efficiency] column value.
     *
     * @return   int
     */
    public function getSpaceHeaterLowTemperatureColderEfficiency()
    {

        return $this->space_heater_low_temperature_colder_efficiency;
    }

    /**
     * Get the [space_heater_low_temperature_warmer_efficiency] column value.
     *
     * @return   int
     */
    public function getSpaceHeaterLowTemperatureWarmerEfficiency()
    {

        return $this->space_heater_low_temperature_warmer_efficiency;
    }

    /**
     * Get the [space_heater_low_temperature_supplementary_power] column value.
     *
     * @return   int
     */
    public function getSpaceHeaterLowTemperatureSupplementaryPower()
    {

        return $this->space_heater_low_temperature_supplementary_power;
    }

    /**
     * Get the [space_heater_low_temperature_power] column value.
     *
     * @return   int
     */
    public function getSpaceHeaterLowTemperaturePower()
    {

        return $this->space_heater_low_temperature_power;
    }

    /**
     * Get the [solar_efficiency] column value.
     *
     * @return   string
     */
    public function getSolarEfficiency()
    {

        return $this->solar_efficiency;
    }

    /**
     * Get the [solar_size] column value.
     *
     * @return   string
     */
    public function getSolarSize()
    {

        return $this->solar_size;
    }

    /**
     * Get the [solar_pump_power] column value.
     *
     * @return   int
     */
    public function getSolarPumpPower()
    {

        return $this->solar_pump_power;
    }

    /**
     * Get the [storage_type] column value.
     *
     * @return   string
     */
    public function getStorageType()
    {

        return $this->storage_type;
    }

    /**
     * Get the [storage_volume] column value.
     *
     * @return   string
     */
    public function getStorageVolume()
    {

        return $this->storage_volume;
    }

    /**
     * Get the [storage_non_solar_volume] column value.
     *
     * @return   string
     */
    public function getStorageNonSolarVolume()
    {

        return $this->storage_non_solar_volume;
    }

    /**
     * Get the [storage_warmth_loss] column value.
     *
     * @return   int
     */
    public function getStorageWarmthLoss()
    {

        return $this->storage_warmth_loss;
    }

    /**
     * Get the [combination_heater_space_heater_grade] column value.
     *
     * @return   string
     */
    public function getCombinationHeaterSpaceHeaterGrade()
    {

        return $this->combination_heater_space_heater_grade;
    }

    /**
     * Get the [combination_heater_water_heater_grade] column value.
     *
     * @return   string
     */
    public function getCombinationHeaterWaterHeaterGrade()
    {

        return $this->combination_heater_water_heater_grade;
    }

    /**
     * Get the [combined_efficiency] column value.
     *
     * @return   int
     */
    public function getCombinedEfficiency()
    {

        return $this->combined_efficiency;
    }

    /**
     * Get the [combined_main_heater_type_id] column value.
     *
     * @return   int
     */
    public function getCombinedMainHeaterTypeId()
    {

        return $this->combined_main_heater_type_id;
    }

    /**
     * Get the [temperature_control_standby_warmth_loss] column value.
     *
     * @return   string
     */
    public function getTemperatureControlStandbyWarmthLoss()
    {

        return $this->temperature_control_standby_warmth_loss;
    }

    /**
     * Get the [temperature_control_type] column value.
     *
     * @return   string
     */
    public function getTemperatureControlType()
    {

        return $this->temperature_control_type;
    }

    /**
     * Get the [supplementary_power] column value.
     *
     * @return   int
     */
    public function getSupplementaryPower()
    {

        return $this->supplementary_power;
    }

    /**
     * Get the [montage_id] column value.
     *
     * @return   int
     */
    public function getMontageId()
    {

        return $this->montage_id;
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
     * Set the value of [id] column.
     *
     * @param      int $v new value
     * @return   \Hfproducts The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[HfproductsTableMap::ID] = true;
        }


        return $this;
    } // setId()

    /**
     * Set the value of [vendor_id] column.
     *
     * @param      int $v new value
     * @return   \Hfproducts The current object (for fluent API support)
     */
    public function setVendorId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->vendor_id !== $v) {
            $this->vendor_id = $v;
            $this->modifiedColumns[HfproductsTableMap::VENDOR_ID] = true;
        }


        return $this;
    } // setVendorId()

    /**
     * Set the value of [name] column.
     *
     * @param      string $v new value
     * @return   \Hfproducts The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[HfproductsTableMap::NAME] = true;
        }


        return $this;
    } // setName()

    /**
     * Set the value of [oag_name] column.
     *
     * @param      string $v new value
     * @return   \Hfproducts The current object (for fluent API support)
     */
    public function setOagName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->oag_name !== $v) {
            $this->oag_name = $v;
            $this->modifiedColumns[HfproductsTableMap::OAG_NAME] = true;
        }


        return $this;
    } // setOagName()

    /**
     * Set the value of [type_id] column.
     *
     * @param      int $v new value
     * @return   \Hfproducts The current object (for fluent API support)
     */
    public function setTypeId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->type_id !== $v) {
            $this->type_id = $v;
            $this->modifiedColumns[HfproductsTableMap::TYPE_ID] = true;
        }


        return $this;
    } // setTypeId()

    /**
     * Set the value of [product_number] column.
     *
     * @param      string $v new value
     * @return   \Hfproducts The current object (for fluent API support)
     */
    public function setProductNumber($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->product_number !== $v) {
            $this->product_number = $v;
            $this->modifiedColumns[HfproductsTableMap::PRODUCT_NUMBER] = true;
        }


        return $this;
    } // setProductNumber()

    /**
     * Set the value of [grade] column.
     *
     * @param      string $v new value
     * @return   \Hfproducts The current object (for fluent API support)
     */
    public function setGrade($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->grade !== $v) {
            $this->grade = $v;
            $this->modifiedColumns[HfproductsTableMap::GRADE] = true;
        }


        return $this;
    } // setGrade()

    /**
     * Set the value of [build_year_from] column.
     *
     * @param      int $v new value
     * @return   \Hfproducts The current object (for fluent API support)
     */
    public function setBuildYearFrom($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->build_year_from !== $v) {
            $this->build_year_from = $v;
            $this->modifiedColumns[HfproductsTableMap::BUILD_YEAR_FROM] = true;
        }


        return $this;
    } // setBuildYearFrom()

    /**
     * Set the value of [build_year_to] column.
     *
     * @param      int $v new value
     * @return   \Hfproducts The current object (for fluent API support)
     */
    public function setBuildYearTo($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->build_year_to !== $v) {
            $this->build_year_to = $v;
            $this->modifiedColumns[HfproductsTableMap::BUILD_YEAR_TO] = true;
        }


        return $this;
    } // setBuildYearTo()

    /**
     * Sets the value of [createdat] column to a normalized version of the date/time value specified.
     *
     * @param      mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return   \Hfproducts The current object (for fluent API support)
     */
    public function setCreatedat($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->createdat !== null || $dt !== null) {
            if ($dt !== $this->createdat) {
                $this->createdat = $dt;
                $this->modifiedColumns[HfproductsTableMap::CREATEDAT] = true;
            }
        } // if either are not null


        return $this;
    } // setCreatedat()

    /**
     * Sets the value of [updatedat] column to a normalized version of the date/time value specified.
     *
     * @param      mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return   \Hfproducts The current object (for fluent API support)
     */
    public function setUpdatedat($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->updatedat !== null || $dt !== null) {
            if ($dt !== $this->updatedat) {
                $this->updatedat = $dt;
                $this->modifiedColumns[HfproductsTableMap::UPDATEDAT] = true;
            }
        } // if either are not null


        return $this;
    } // setUpdatedat()

    /**
     * Sets the value of the [sht_product] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param      boolean|integer|string $v The new value
     * @return   \Hfproducts The current object (for fluent API support)
     */
    public function setShtProduct($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->sht_product !== $v) {
            $this->sht_product = $v;
            $this->modifiedColumns[HfproductsTableMap::SHT_PRODUCT] = true;
        }


        return $this;
    } // setShtProduct()

    /**
     * Set the value of [sht_id] column.
     *
     * @param      string $v new value
     * @return   \Hfproducts The current object (for fluent API support)
     */
    public function setShtId($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->sht_id !== $v) {
            $this->sht_id = $v;
            $this->modifiedColumns[HfproductsTableMap::SHT_ID] = true;
        }


        return $this;
    } // setShtId()

    /**
     * Set the value of [sht_category] column.
     *
     * @param      int $v new value
     * @return   \Hfproducts The current object (for fluent API support)
     */
    public function setShtCategory($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->sht_category !== $v) {
            $this->sht_category = $v;
            $this->modifiedColumns[HfproductsTableMap::SHT_CATEGORY] = true;
        }


        return $this;
    } // setShtCategory()

    /**
     * Set the value of [sht_text1] column.
     *
     * @param      string $v new value
     * @return   \Hfproducts The current object (for fluent API support)
     */
    public function setShtText1($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->sht_text1 !== $v) {
            $this->sht_text1 = $v;
            $this->modifiedColumns[HfproductsTableMap::SHT_TEXT1] = true;
        }


        return $this;
    } // setShtText1()

    /**
     * Set the value of [sht_text2] column.
     *
     * @param      string $v new value
     * @return   \Hfproducts The current object (for fluent API support)
     */
    public function setShtText2($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->sht_text2 !== $v) {
            $this->sht_text2 = $v;
            $this->modifiedColumns[HfproductsTableMap::SHT_TEXT2] = true;
        }


        return $this;
    } // setShtText2()

    /**
     * Sets the value of the [oag_product] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param      boolean|integer|string $v The new value
     * @return   \Hfproducts The current object (for fluent API support)
     */
    public function setOagProduct($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->oag_product !== $v) {
            $this->oag_product = $v;
            $this->modifiedColumns[HfproductsTableMap::OAG_PRODUCT] = true;
        }


        return $this;
    } // setOagProduct()

    /**
     * Set the value of [oag_id] column.
     *
     * @param      string $v new value
     * @return   \Hfproducts The current object (for fluent API support)
     */
    public function setOagId($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->oag_id !== $v) {
            $this->oag_id = $v;
            $this->modifiedColumns[HfproductsTableMap::OAG_ID] = true;
        }


        return $this;
    } // setOagId()

    /**
     * Set the value of [oag_category] column.
     *
     * @param      int $v new value
     * @return   \Hfproducts The current object (for fluent API support)
     */
    public function setOagCategory($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->oag_category !== $v) {
            $this->oag_category = $v;
            $this->modifiedColumns[HfproductsTableMap::OAG_CATEGORY] = true;
        }


        return $this;
    } // setOagCategory()

    /**
     * Set the value of [oag_text1] column.
     *
     * @param      string $v new value
     * @return   \Hfproducts The current object (for fluent API support)
     */
    public function setOagText1($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->oag_text1 !== $v) {
            $this->oag_text1 = $v;
            $this->modifiedColumns[HfproductsTableMap::OAG_TEXT1] = true;
        }


        return $this;
    } // setOagText1()

    /**
     * Set the value of [oag_text2] column.
     *
     * @param      string $v new value
     * @return   \Hfproducts The current object (for fluent API support)
     */
    public function setOagText2($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->oag_text2 !== $v) {
            $this->oag_text2 = $v;
            $this->modifiedColumns[HfproductsTableMap::OAG_TEXT2] = true;
        }


        return $this;
    } // setOagText2()

    /**
     * Set the value of [megabild_id] column.
     *
     * @param      int $v new value
     * @return   \Hfproducts The current object (for fluent API support)
     */
    public function setMegabildId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->megabild_id !== $v) {
            $this->megabild_id = $v;
            $this->modifiedColumns[HfproductsTableMap::MEGABILD_ID] = true;
        }


        return $this;
    } // setMegabildId()

    /**
     * Set the value of [image] column.
     *
     * @param      string $v new value
     * @return   \Hfproducts The current object (for fluent API support)
     */
    public function setImage($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->image !== $v) {
            $this->image = $v;
            $this->modifiedColumns[HfproductsTableMap::IMAGE] = true;
        }


        return $this;
    } // setImage()

    /**
     * Set the value of [specification_name] column.
     *
     * @param      string $v new value
     * @return   \Hfproducts The current object (for fluent API support)
     */
    public function setSpecificationName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->specification_name !== $v) {
            $this->specification_name = $v;
            $this->modifiedColumns[HfproductsTableMap::SPECIFICATION_NAME] = true;
        }


        return $this;
    } // setSpecificationName()

    /**
     * Set the value of [label_name] column.
     *
     * @param      string $v new value
     * @return   \Hfproducts The current object (for fluent API support)
     */
    public function setLabelName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->label_name !== $v) {
            $this->label_name = $v;
            $this->modifiedColumns[HfproductsTableMap::LABEL_NAME] = true;
        }


        return $this;
    } // setLabelName()

    /**
     * Set the value of [water_heater_energy_class] column.
     *
     * @param      string $v new value
     * @return   \Hfproducts The current object (for fluent API support)
     */
    public function setWaterHeaterEnergyClass($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->water_heater_energy_class !== $v) {
            $this->water_heater_energy_class = $v;
            $this->modifiedColumns[HfproductsTableMap::WATER_HEATER_ENERGY_CLASS] = true;
        }


        return $this;
    } // setWaterHeaterEnergyClass()

    /**
     * Set the value of [water_heater_energy_efficiency] column.
     *
     * @param      int $v new value
     * @return   \Hfproducts The current object (for fluent API support)
     */
    public function setWaterHeaterEnergyEfficiency($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->water_heater_energy_efficiency !== $v) {
            $this->water_heater_energy_efficiency = $v;
            $this->modifiedColumns[HfproductsTableMap::WATER_HEATER_ENERGY_EFFICIENCY] = true;
        }


        return $this;
    } // setWaterHeaterEnergyEfficiency()

    /**
     * Set the value of [water_heater_energy_grade] column.
     *
     * @param      string $v new value
     * @return   \Hfproducts The current object (for fluent API support)
     */
    public function setWaterHeaterEnergyGrade($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->water_heater_energy_grade !== $v) {
            $this->water_heater_energy_grade = $v;
            $this->modifiedColumns[HfproductsTableMap::WATER_HEATER_ENERGY_GRADE] = true;
        }


        return $this;
    } // setWaterHeaterEnergyGrade()

    /**
     * Set the value of [space_heater_efficiency] column.
     *
     * @param      int $v new value
     * @return   \Hfproducts The current object (for fluent API support)
     */
    public function setSpaceHeaterEfficiency($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->space_heater_efficiency !== $v) {
            $this->space_heater_efficiency = $v;
            $this->modifiedColumns[HfproductsTableMap::SPACE_HEATER_EFFICIENCY] = true;
        }


        return $this;
    } // setSpaceHeaterEfficiency()

    /**
     * Set the value of [space_heater_power] column.
     *
     * @param      int $v new value
     * @return   \Hfproducts The current object (for fluent API support)
     */
    public function setSpaceHeaterPower($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->space_heater_power !== $v) {
            $this->space_heater_power = $v;
            $this->modifiedColumns[HfproductsTableMap::SPACE_HEATER_POWER] = true;
        }


        return $this;
    } // setSpaceHeaterPower()

    /**
     * Set the value of [space_heater_type] column.
     *
     * @param      string $v new value
     * @return   \Hfproducts The current object (for fluent API support)
     */
    public function setSpaceHeaterType($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->space_heater_type !== $v) {
            $this->space_heater_type = $v;
            $this->modifiedColumns[HfproductsTableMap::SPACE_HEATER_TYPE] = true;
        }


        return $this;
    } // setSpaceHeaterType()

    /**
     * Sets the value of the [space_heater_low_temperature_heat_pump] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param      boolean|integer|string $v The new value
     * @return   \Hfproducts The current object (for fluent API support)
     */
    public function setSpaceHeaterLowTemperatureHeatPump($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->space_heater_low_temperature_heat_pump !== $v) {
            $this->space_heater_low_temperature_heat_pump = $v;
            $this->modifiedColumns[HfproductsTableMap::SPACE_HEATER_LOW_TEMPERATURE_HEAT_PUMP] = true;
        }


        return $this;
    } // setSpaceHeaterLowTemperatureHeatPump()

    /**
     * Set the value of [space_heater_colder_efficiency] column.
     *
     * @param      int $v new value
     * @return   \Hfproducts The current object (for fluent API support)
     */
    public function setSpaceHeaterColderEfficiency($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->space_heater_colder_efficiency !== $v) {
            $this->space_heater_colder_efficiency = $v;
            $this->modifiedColumns[HfproductsTableMap::SPACE_HEATER_COLDER_EFFICIENCY] = true;
        }


        return $this;
    } // setSpaceHeaterColderEfficiency()

    /**
     * Set the value of [space_heater_warmer_efficiency] column.
     *
     * @param      int $v new value
     * @return   \Hfproducts The current object (for fluent API support)
     */
    public function setSpaceHeaterWarmerEfficiency($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->space_heater_warmer_efficiency !== $v) {
            $this->space_heater_warmer_efficiency = $v;
            $this->modifiedColumns[HfproductsTableMap::SPACE_HEATER_WARMER_EFFICIENCY] = true;
        }


        return $this;
    } // setSpaceHeaterWarmerEfficiency()

    /**
     * Set the value of [space_heater_low_temperature_grade] column.
     *
     * @param      string $v new value
     * @return   \Hfproducts The current object (for fluent API support)
     */
    public function setSpaceHeaterLowTemperatureGrade($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->space_heater_low_temperature_grade !== $v) {
            $this->space_heater_low_temperature_grade = $v;
            $this->modifiedColumns[HfproductsTableMap::SPACE_HEATER_LOW_TEMPERATURE_GRADE] = true;
        }


        return $this;
    } // setSpaceHeaterLowTemperatureGrade()

    /**
     * Set the value of [space_heater_low_temperature_efficiency] column.
     *
     * @param      int $v new value
     * @return   \Hfproducts The current object (for fluent API support)
     */
    public function setSpaceHeaterLowTemperatureEfficiency($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->space_heater_low_temperature_efficiency !== $v) {
            $this->space_heater_low_temperature_efficiency = $v;
            $this->modifiedColumns[HfproductsTableMap::SPACE_HEATER_LOW_TEMPERATURE_EFFICIENCY] = true;
        }


        return $this;
    } // setSpaceHeaterLowTemperatureEfficiency()

    /**
     * Set the value of [space_heater_low_temperature_colder_efficiency] column.
     *
     * @param      int $v new value
     * @return   \Hfproducts The current object (for fluent API support)
     */
    public function setSpaceHeaterLowTemperatureColderEfficiency($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->space_heater_low_temperature_colder_efficiency !== $v) {
            $this->space_heater_low_temperature_colder_efficiency = $v;
            $this->modifiedColumns[HfproductsTableMap::SPACE_HEATER_LOW_TEMPERATURE_COLDER_EFFICIENCY] = true;
        }


        return $this;
    } // setSpaceHeaterLowTemperatureColderEfficiency()

    /**
     * Set the value of [space_heater_low_temperature_warmer_efficiency] column.
     *
     * @param      int $v new value
     * @return   \Hfproducts The current object (for fluent API support)
     */
    public function setSpaceHeaterLowTemperatureWarmerEfficiency($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->space_heater_low_temperature_warmer_efficiency !== $v) {
            $this->space_heater_low_temperature_warmer_efficiency = $v;
            $this->modifiedColumns[HfproductsTableMap::SPACE_HEATER_LOW_TEMPERATURE_WARMER_EFFICIENCY] = true;
        }


        return $this;
    } // setSpaceHeaterLowTemperatureWarmerEfficiency()

    /**
     * Set the value of [space_heater_low_temperature_supplementary_power] column.
     *
     * @param      int $v new value
     * @return   \Hfproducts The current object (for fluent API support)
     */
    public function setSpaceHeaterLowTemperatureSupplementaryPower($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->space_heater_low_temperature_supplementary_power !== $v) {
            $this->space_heater_low_temperature_supplementary_power = $v;
            $this->modifiedColumns[HfproductsTableMap::SPACE_HEATER_LOW_TEMPERATURE_SUPPLEMENTARY_POWER] = true;
        }


        return $this;
    } // setSpaceHeaterLowTemperatureSupplementaryPower()

    /**
     * Set the value of [space_heater_low_temperature_power] column.
     *
     * @param      int $v new value
     * @return   \Hfproducts The current object (for fluent API support)
     */
    public function setSpaceHeaterLowTemperaturePower($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->space_heater_low_temperature_power !== $v) {
            $this->space_heater_low_temperature_power = $v;
            $this->modifiedColumns[HfproductsTableMap::SPACE_HEATER_LOW_TEMPERATURE_POWER] = true;
        }


        return $this;
    } // setSpaceHeaterLowTemperaturePower()

    /**
     * Set the value of [solar_efficiency] column.
     *
     * @param      string $v new value
     * @return   \Hfproducts The current object (for fluent API support)
     */
    public function setSolarEfficiency($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->solar_efficiency !== $v) {
            $this->solar_efficiency = $v;
            $this->modifiedColumns[HfproductsTableMap::SOLAR_EFFICIENCY] = true;
        }


        return $this;
    } // setSolarEfficiency()

    /**
     * Set the value of [solar_size] column.
     *
     * @param      string $v new value
     * @return   \Hfproducts The current object (for fluent API support)
     */
    public function setSolarSize($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->solar_size !== $v) {
            $this->solar_size = $v;
            $this->modifiedColumns[HfproductsTableMap::SOLAR_SIZE] = true;
        }


        return $this;
    } // setSolarSize()

    /**
     * Set the value of [solar_pump_power] column.
     *
     * @param      int $v new value
     * @return   \Hfproducts The current object (for fluent API support)
     */
    public function setSolarPumpPower($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->solar_pump_power !== $v) {
            $this->solar_pump_power = $v;
            $this->modifiedColumns[HfproductsTableMap::SOLAR_PUMP_POWER] = true;
        }


        return $this;
    } // setSolarPumpPower()

    /**
     * Set the value of [storage_type] column.
     *
     * @param      string $v new value
     * @return   \Hfproducts The current object (for fluent API support)
     */
    public function setStorageType($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->storage_type !== $v) {
            $this->storage_type = $v;
            $this->modifiedColumns[HfproductsTableMap::STORAGE_TYPE] = true;
        }


        return $this;
    } // setStorageType()

    /**
     * Set the value of [storage_volume] column.
     *
     * @param      string $v new value
     * @return   \Hfproducts The current object (for fluent API support)
     */
    public function setStorageVolume($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->storage_volume !== $v) {
            $this->storage_volume = $v;
            $this->modifiedColumns[HfproductsTableMap::STORAGE_VOLUME] = true;
        }


        return $this;
    } // setStorageVolume()

    /**
     * Set the value of [storage_non_solar_volume] column.
     *
     * @param      string $v new value
     * @return   \Hfproducts The current object (for fluent API support)
     */
    public function setStorageNonSolarVolume($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->storage_non_solar_volume !== $v) {
            $this->storage_non_solar_volume = $v;
            $this->modifiedColumns[HfproductsTableMap::STORAGE_NON_SOLAR_VOLUME] = true;
        }


        return $this;
    } // setStorageNonSolarVolume()

    /**
     * Set the value of [storage_warmth_loss] column.
     *
     * @param      int $v new value
     * @return   \Hfproducts The current object (for fluent API support)
     */
    public function setStorageWarmthLoss($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->storage_warmth_loss !== $v) {
            $this->storage_warmth_loss = $v;
            $this->modifiedColumns[HfproductsTableMap::STORAGE_WARMTH_LOSS] = true;
        }


        return $this;
    } // setStorageWarmthLoss()

    /**
     * Set the value of [combination_heater_space_heater_grade] column.
     *
     * @param      string $v new value
     * @return   \Hfproducts The current object (for fluent API support)
     */
    public function setCombinationHeaterSpaceHeaterGrade($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->combination_heater_space_heater_grade !== $v) {
            $this->combination_heater_space_heater_grade = $v;
            $this->modifiedColumns[HfproductsTableMap::COMBINATION_HEATER_SPACE_HEATER_GRADE] = true;
        }


        return $this;
    } // setCombinationHeaterSpaceHeaterGrade()

    /**
     * Set the value of [combination_heater_water_heater_grade] column.
     *
     * @param      string $v new value
     * @return   \Hfproducts The current object (for fluent API support)
     */
    public function setCombinationHeaterWaterHeaterGrade($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->combination_heater_water_heater_grade !== $v) {
            $this->combination_heater_water_heater_grade = $v;
            $this->modifiedColumns[HfproductsTableMap::COMBINATION_HEATER_WATER_HEATER_GRADE] = true;
        }


        return $this;
    } // setCombinationHeaterWaterHeaterGrade()

    /**
     * Set the value of [combined_efficiency] column.
     *
     * @param      int $v new value
     * @return   \Hfproducts The current object (for fluent API support)
     */
    public function setCombinedEfficiency($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->combined_efficiency !== $v) {
            $this->combined_efficiency = $v;
            $this->modifiedColumns[HfproductsTableMap::COMBINED_EFFICIENCY] = true;
        }


        return $this;
    } // setCombinedEfficiency()

    /**
     * Set the value of [combined_main_heater_type_id] column.
     *
     * @param      int $v new value
     * @return   \Hfproducts The current object (for fluent API support)
     */
    public function setCombinedMainHeaterTypeId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->combined_main_heater_type_id !== $v) {
            $this->combined_main_heater_type_id = $v;
            $this->modifiedColumns[HfproductsTableMap::COMBINED_MAIN_HEATER_TYPE_ID] = true;
        }


        return $this;
    } // setCombinedMainHeaterTypeId()

    /**
     * Set the value of [temperature_control_standby_warmth_loss] column.
     *
     * @param      string $v new value
     * @return   \Hfproducts The current object (for fluent API support)
     */
    public function setTemperatureControlStandbyWarmthLoss($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->temperature_control_standby_warmth_loss !== $v) {
            $this->temperature_control_standby_warmth_loss = $v;
            $this->modifiedColumns[HfproductsTableMap::TEMPERATURE_CONTROL_STANDBY_WARMTH_LOSS] = true;
        }


        return $this;
    } // setTemperatureControlStandbyWarmthLoss()

    /**
     * Set the value of [temperature_control_type] column.
     *
     * @param      string $v new value
     * @return   \Hfproducts The current object (for fluent API support)
     */
    public function setTemperatureControlType($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->temperature_control_type !== $v) {
            $this->temperature_control_type = $v;
            $this->modifiedColumns[HfproductsTableMap::TEMPERATURE_CONTROL_TYPE] = true;
        }


        return $this;
    } // setTemperatureControlType()

    /**
     * Set the value of [supplementary_power] column.
     *
     * @param      int $v new value
     * @return   \Hfproducts The current object (for fluent API support)
     */
    public function setSupplementaryPower($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->supplementary_power !== $v) {
            $this->supplementary_power = $v;
            $this->modifiedColumns[HfproductsTableMap::SUPPLEMENTARY_POWER] = true;
        }


        return $this;
    } // setSupplementaryPower()

    /**
     * Set the value of [montage_id] column.
     *
     * @param      int $v new value
     * @return   \Hfproducts The current object (for fluent API support)
     */
    public function setMontageId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->montage_id !== $v) {
            $this->montage_id = $v;
            $this->modifiedColumns[HfproductsTableMap::MONTAGE_ID] = true;
        }


        return $this;
    } // setMontageId()

    /**
     * Set the value of [price] column.
     *
     * @param      string $v new value
     * @return   \Hfproducts The current object (for fluent API support)
     */
    public function setPrice($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->price !== $v) {
            $this->price = $v;
            $this->modifiedColumns[HfproductsTableMap::PRICE] = true;
        }


        return $this;
    } // setPrice()

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
            if ($this->sht_product !== false) {
                return false;
            }

            if ($this->oag_product !== false) {
                return false;
            }

            if ($this->price !== '0.00') {
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


            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : HfproductsTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : HfproductsTableMap::translateFieldName('VendorId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->vendor_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : HfproductsTableMap::translateFieldName('Name', TableMap::TYPE_PHPNAME, $indexType)];
            $this->name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : HfproductsTableMap::translateFieldName('OagName', TableMap::TYPE_PHPNAME, $indexType)];
            $this->oag_name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : HfproductsTableMap::translateFieldName('TypeId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->type_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : HfproductsTableMap::translateFieldName('ProductNumber', TableMap::TYPE_PHPNAME, $indexType)];
            $this->product_number = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : HfproductsTableMap::translateFieldName('Grade', TableMap::TYPE_PHPNAME, $indexType)];
            $this->grade = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : HfproductsTableMap::translateFieldName('BuildYearFrom', TableMap::TYPE_PHPNAME, $indexType)];
            $this->build_year_from = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : HfproductsTableMap::translateFieldName('BuildYearTo', TableMap::TYPE_PHPNAME, $indexType)];
            $this->build_year_to = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : HfproductsTableMap::translateFieldName('Createdat', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->createdat = (null !== $col) ? PropelDateTime::newInstance($col, null, '\DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 10 + $startcol : HfproductsTableMap::translateFieldName('Updatedat', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->updatedat = (null !== $col) ? PropelDateTime::newInstance($col, null, '\DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 11 + $startcol : HfproductsTableMap::translateFieldName('ShtProduct', TableMap::TYPE_PHPNAME, $indexType)];
            $this->sht_product = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 12 + $startcol : HfproductsTableMap::translateFieldName('ShtId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->sht_id = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 13 + $startcol : HfproductsTableMap::translateFieldName('ShtCategory', TableMap::TYPE_PHPNAME, $indexType)];
            $this->sht_category = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 14 + $startcol : HfproductsTableMap::translateFieldName('ShtText1', TableMap::TYPE_PHPNAME, $indexType)];
            $this->sht_text1 = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 15 + $startcol : HfproductsTableMap::translateFieldName('ShtText2', TableMap::TYPE_PHPNAME, $indexType)];
            $this->sht_text2 = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 16 + $startcol : HfproductsTableMap::translateFieldName('OagProduct', TableMap::TYPE_PHPNAME, $indexType)];
            $this->oag_product = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 17 + $startcol : HfproductsTableMap::translateFieldName('OagId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->oag_id = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 18 + $startcol : HfproductsTableMap::translateFieldName('OagCategory', TableMap::TYPE_PHPNAME, $indexType)];
            $this->oag_category = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 19 + $startcol : HfproductsTableMap::translateFieldName('OagText1', TableMap::TYPE_PHPNAME, $indexType)];
            $this->oag_text1 = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 20 + $startcol : HfproductsTableMap::translateFieldName('OagText2', TableMap::TYPE_PHPNAME, $indexType)];
            $this->oag_text2 = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 21 + $startcol : HfproductsTableMap::translateFieldName('MegabildId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->megabild_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 22 + $startcol : HfproductsTableMap::translateFieldName('Image', TableMap::TYPE_PHPNAME, $indexType)];
            $this->image = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 23 + $startcol : HfproductsTableMap::translateFieldName('SpecificationName', TableMap::TYPE_PHPNAME, $indexType)];
            $this->specification_name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 24 + $startcol : HfproductsTableMap::translateFieldName('LabelName', TableMap::TYPE_PHPNAME, $indexType)];
            $this->label_name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 25 + $startcol : HfproductsTableMap::translateFieldName('WaterHeaterEnergyClass', TableMap::TYPE_PHPNAME, $indexType)];
            $this->water_heater_energy_class = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 26 + $startcol : HfproductsTableMap::translateFieldName('WaterHeaterEnergyEfficiency', TableMap::TYPE_PHPNAME, $indexType)];
            $this->water_heater_energy_efficiency = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 27 + $startcol : HfproductsTableMap::translateFieldName('WaterHeaterEnergyGrade', TableMap::TYPE_PHPNAME, $indexType)];
            $this->water_heater_energy_grade = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 28 + $startcol : HfproductsTableMap::translateFieldName('SpaceHeaterEfficiency', TableMap::TYPE_PHPNAME, $indexType)];
            $this->space_heater_efficiency = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 29 + $startcol : HfproductsTableMap::translateFieldName('SpaceHeaterPower', TableMap::TYPE_PHPNAME, $indexType)];
            $this->space_heater_power = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 30 + $startcol : HfproductsTableMap::translateFieldName('SpaceHeaterType', TableMap::TYPE_PHPNAME, $indexType)];
            $this->space_heater_type = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 31 + $startcol : HfproductsTableMap::translateFieldName('SpaceHeaterLowTemperatureHeatPump', TableMap::TYPE_PHPNAME, $indexType)];
            $this->space_heater_low_temperature_heat_pump = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 32 + $startcol : HfproductsTableMap::translateFieldName('SpaceHeaterColderEfficiency', TableMap::TYPE_PHPNAME, $indexType)];
            $this->space_heater_colder_efficiency = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 33 + $startcol : HfproductsTableMap::translateFieldName('SpaceHeaterWarmerEfficiency', TableMap::TYPE_PHPNAME, $indexType)];
            $this->space_heater_warmer_efficiency = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 34 + $startcol : HfproductsTableMap::translateFieldName('SpaceHeaterLowTemperatureGrade', TableMap::TYPE_PHPNAME, $indexType)];
            $this->space_heater_low_temperature_grade = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 35 + $startcol : HfproductsTableMap::translateFieldName('SpaceHeaterLowTemperatureEfficiency', TableMap::TYPE_PHPNAME, $indexType)];
            $this->space_heater_low_temperature_efficiency = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 36 + $startcol : HfproductsTableMap::translateFieldName('SpaceHeaterLowTemperatureColderEfficiency', TableMap::TYPE_PHPNAME, $indexType)];
            $this->space_heater_low_temperature_colder_efficiency = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 37 + $startcol : HfproductsTableMap::translateFieldName('SpaceHeaterLowTemperatureWarmerEfficiency', TableMap::TYPE_PHPNAME, $indexType)];
            $this->space_heater_low_temperature_warmer_efficiency = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 38 + $startcol : HfproductsTableMap::translateFieldName('SpaceHeaterLowTemperatureSupplementaryPower', TableMap::TYPE_PHPNAME, $indexType)];
            $this->space_heater_low_temperature_supplementary_power = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 39 + $startcol : HfproductsTableMap::translateFieldName('SpaceHeaterLowTemperaturePower', TableMap::TYPE_PHPNAME, $indexType)];
            $this->space_heater_low_temperature_power = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 40 + $startcol : HfproductsTableMap::translateFieldName('SolarEfficiency', TableMap::TYPE_PHPNAME, $indexType)];
            $this->solar_efficiency = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 41 + $startcol : HfproductsTableMap::translateFieldName('SolarSize', TableMap::TYPE_PHPNAME, $indexType)];
            $this->solar_size = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 42 + $startcol : HfproductsTableMap::translateFieldName('SolarPumpPower', TableMap::TYPE_PHPNAME, $indexType)];
            $this->solar_pump_power = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 43 + $startcol : HfproductsTableMap::translateFieldName('StorageType', TableMap::TYPE_PHPNAME, $indexType)];
            $this->storage_type = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 44 + $startcol : HfproductsTableMap::translateFieldName('StorageVolume', TableMap::TYPE_PHPNAME, $indexType)];
            $this->storage_volume = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 45 + $startcol : HfproductsTableMap::translateFieldName('StorageNonSolarVolume', TableMap::TYPE_PHPNAME, $indexType)];
            $this->storage_non_solar_volume = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 46 + $startcol : HfproductsTableMap::translateFieldName('StorageWarmthLoss', TableMap::TYPE_PHPNAME, $indexType)];
            $this->storage_warmth_loss = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 47 + $startcol : HfproductsTableMap::translateFieldName('CombinationHeaterSpaceHeaterGrade', TableMap::TYPE_PHPNAME, $indexType)];
            $this->combination_heater_space_heater_grade = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 48 + $startcol : HfproductsTableMap::translateFieldName('CombinationHeaterWaterHeaterGrade', TableMap::TYPE_PHPNAME, $indexType)];
            $this->combination_heater_water_heater_grade = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 49 + $startcol : HfproductsTableMap::translateFieldName('CombinedEfficiency', TableMap::TYPE_PHPNAME, $indexType)];
            $this->combined_efficiency = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 50 + $startcol : HfproductsTableMap::translateFieldName('CombinedMainHeaterTypeId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->combined_main_heater_type_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 51 + $startcol : HfproductsTableMap::translateFieldName('TemperatureControlStandbyWarmthLoss', TableMap::TYPE_PHPNAME, $indexType)];
            $this->temperature_control_standby_warmth_loss = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 52 + $startcol : HfproductsTableMap::translateFieldName('TemperatureControlType', TableMap::TYPE_PHPNAME, $indexType)];
            $this->temperature_control_type = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 53 + $startcol : HfproductsTableMap::translateFieldName('SupplementaryPower', TableMap::TYPE_PHPNAME, $indexType)];
            $this->supplementary_power = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 54 + $startcol : HfproductsTableMap::translateFieldName('MontageId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->montage_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 55 + $startcol : HfproductsTableMap::translateFieldName('Price', TableMap::TYPE_PHPNAME, $indexType)];
            $this->price = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 56; // 56 = HfproductsTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating \Hfproducts object", 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(HfproductsTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildHfproductsQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
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
     * @see Hfproducts::setDeleted()
     * @see Hfproducts::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(HfproductsTableMap::DATABASE_NAME);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = ChildHfproductsQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(HfproductsTableMap::DATABASE_NAME);
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
                HfproductsTableMap::addInstanceToPool($this);
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

        $this->modifiedColumns[HfproductsTableMap::ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . HfproductsTableMap::ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(HfproductsTableMap::ID)) {
            $modifiedColumns[':p' . $index++]  = 'ID';
        }
        if ($this->isColumnModified(HfproductsTableMap::VENDOR_ID)) {
            $modifiedColumns[':p' . $index++]  = 'VENDOR_ID';
        }
        if ($this->isColumnModified(HfproductsTableMap::NAME)) {
            $modifiedColumns[':p' . $index++]  = 'NAME';
        }
        if ($this->isColumnModified(HfproductsTableMap::OAG_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'OAG_NAME';
        }
        if ($this->isColumnModified(HfproductsTableMap::TYPE_ID)) {
            $modifiedColumns[':p' . $index++]  = 'TYPE_ID';
        }
        if ($this->isColumnModified(HfproductsTableMap::PRODUCT_NUMBER)) {
            $modifiedColumns[':p' . $index++]  = 'PRODUCT_NUMBER';
        }
        if ($this->isColumnModified(HfproductsTableMap::GRADE)) {
            $modifiedColumns[':p' . $index++]  = 'GRADE';
        }
        if ($this->isColumnModified(HfproductsTableMap::BUILD_YEAR_FROM)) {
            $modifiedColumns[':p' . $index++]  = 'BUILD_YEAR_FROM';
        }
        if ($this->isColumnModified(HfproductsTableMap::BUILD_YEAR_TO)) {
            $modifiedColumns[':p' . $index++]  = 'BUILD_YEAR_TO';
        }
        if ($this->isColumnModified(HfproductsTableMap::CREATEDAT)) {
            $modifiedColumns[':p' . $index++]  = 'CREATEDAT';
        }
        if ($this->isColumnModified(HfproductsTableMap::UPDATEDAT)) {
            $modifiedColumns[':p' . $index++]  = 'UPDATEDAT';
        }
        if ($this->isColumnModified(HfproductsTableMap::SHT_PRODUCT)) {
            $modifiedColumns[':p' . $index++]  = 'SHT_PRODUCT';
        }
        if ($this->isColumnModified(HfproductsTableMap::SHT_ID)) {
            $modifiedColumns[':p' . $index++]  = 'SHT_ID';
        }
        if ($this->isColumnModified(HfproductsTableMap::SHT_CATEGORY)) {
            $modifiedColumns[':p' . $index++]  = 'SHT_CATEGORY';
        }
        if ($this->isColumnModified(HfproductsTableMap::SHT_TEXT1)) {
            $modifiedColumns[':p' . $index++]  = 'SHT_TEXT1';
        }
        if ($this->isColumnModified(HfproductsTableMap::SHT_TEXT2)) {
            $modifiedColumns[':p' . $index++]  = 'SHT_TEXT2';
        }
        if ($this->isColumnModified(HfproductsTableMap::OAG_PRODUCT)) {
            $modifiedColumns[':p' . $index++]  = 'OAG_PRODUCT';
        }
        if ($this->isColumnModified(HfproductsTableMap::OAG_ID)) {
            $modifiedColumns[':p' . $index++]  = 'OAG_ID';
        }
        if ($this->isColumnModified(HfproductsTableMap::OAG_CATEGORY)) {
            $modifiedColumns[':p' . $index++]  = 'OAG_CATEGORY';
        }
        if ($this->isColumnModified(HfproductsTableMap::OAG_TEXT1)) {
            $modifiedColumns[':p' . $index++]  = 'OAG_TEXT1';
        }
        if ($this->isColumnModified(HfproductsTableMap::OAG_TEXT2)) {
            $modifiedColumns[':p' . $index++]  = 'OAG_TEXT2';
        }
        if ($this->isColumnModified(HfproductsTableMap::MEGABILD_ID)) {
            $modifiedColumns[':p' . $index++]  = 'MEGABILD_ID';
        }
        if ($this->isColumnModified(HfproductsTableMap::IMAGE)) {
            $modifiedColumns[':p' . $index++]  = 'IMAGE';
        }
        if ($this->isColumnModified(HfproductsTableMap::SPECIFICATION_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'SPECIFICATION_NAME';
        }
        if ($this->isColumnModified(HfproductsTableMap::LABEL_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'LABEL_NAME';
        }
        if ($this->isColumnModified(HfproductsTableMap::WATER_HEATER_ENERGY_CLASS)) {
            $modifiedColumns[':p' . $index++]  = 'WATER_HEATER_ENERGY_CLASS';
        }
        if ($this->isColumnModified(HfproductsTableMap::WATER_HEATER_ENERGY_EFFICIENCY)) {
            $modifiedColumns[':p' . $index++]  = 'WATER_HEATER_ENERGY_EFFICIENCY';
        }
        if ($this->isColumnModified(HfproductsTableMap::WATER_HEATER_ENERGY_GRADE)) {
            $modifiedColumns[':p' . $index++]  = 'WATER_HEATER_ENERGY_GRADE';
        }
        if ($this->isColumnModified(HfproductsTableMap::SPACE_HEATER_EFFICIENCY)) {
            $modifiedColumns[':p' . $index++]  = 'SPACE_HEATER_EFFICIENCY';
        }
        if ($this->isColumnModified(HfproductsTableMap::SPACE_HEATER_POWER)) {
            $modifiedColumns[':p' . $index++]  = 'SPACE_HEATER_POWER';
        }
        if ($this->isColumnModified(HfproductsTableMap::SPACE_HEATER_TYPE)) {
            $modifiedColumns[':p' . $index++]  = 'SPACE_HEATER_TYPE';
        }
        if ($this->isColumnModified(HfproductsTableMap::SPACE_HEATER_LOW_TEMPERATURE_HEAT_PUMP)) {
            $modifiedColumns[':p' . $index++]  = 'SPACE_HEATER_LOW_TEMPERATURE_HEAT_PUMP';
        }
        if ($this->isColumnModified(HfproductsTableMap::SPACE_HEATER_COLDER_EFFICIENCY)) {
            $modifiedColumns[':p' . $index++]  = 'SPACE_HEATER_COLDER_EFFICIENCY';
        }
        if ($this->isColumnModified(HfproductsTableMap::SPACE_HEATER_WARMER_EFFICIENCY)) {
            $modifiedColumns[':p' . $index++]  = 'SPACE_HEATER_WARMER_EFFICIENCY';
        }
        if ($this->isColumnModified(HfproductsTableMap::SPACE_HEATER_LOW_TEMPERATURE_GRADE)) {
            $modifiedColumns[':p' . $index++]  = 'SPACE_HEATER_LOW_TEMPERATURE_GRADE';
        }
        if ($this->isColumnModified(HfproductsTableMap::SPACE_HEATER_LOW_TEMPERATURE_EFFICIENCY)) {
            $modifiedColumns[':p' . $index++]  = 'SPACE_HEATER_LOW_TEMPERATURE_EFFICIENCY';
        }
        if ($this->isColumnModified(HfproductsTableMap::SPACE_HEATER_LOW_TEMPERATURE_COLDER_EFFICIENCY)) {
            $modifiedColumns[':p' . $index++]  = 'SPACE_HEATER_LOW_TEMPERATURE_COLDER_EFFICIENCY';
        }
        if ($this->isColumnModified(HfproductsTableMap::SPACE_HEATER_LOW_TEMPERATURE_WARMER_EFFICIENCY)) {
            $modifiedColumns[':p' . $index++]  = 'SPACE_HEATER_LOW_TEMPERATURE_WARMER_EFFICIENCY';
        }
        if ($this->isColumnModified(HfproductsTableMap::SPACE_HEATER_LOW_TEMPERATURE_SUPPLEMENTARY_POWER)) {
            $modifiedColumns[':p' . $index++]  = 'SPACE_HEATER_LOW_TEMPERATURE_SUPPLEMENTARY_POWER';
        }
        if ($this->isColumnModified(HfproductsTableMap::SPACE_HEATER_LOW_TEMPERATURE_POWER)) {
            $modifiedColumns[':p' . $index++]  = 'SPACE_HEATER_LOW_TEMPERATURE_POWER';
        }
        if ($this->isColumnModified(HfproductsTableMap::SOLAR_EFFICIENCY)) {
            $modifiedColumns[':p' . $index++]  = 'SOLAR_EFFICIENCY';
        }
        if ($this->isColumnModified(HfproductsTableMap::SOLAR_SIZE)) {
            $modifiedColumns[':p' . $index++]  = 'SOLAR_SIZE';
        }
        if ($this->isColumnModified(HfproductsTableMap::SOLAR_PUMP_POWER)) {
            $modifiedColumns[':p' . $index++]  = 'SOLAR_PUMP_POWER';
        }
        if ($this->isColumnModified(HfproductsTableMap::STORAGE_TYPE)) {
            $modifiedColumns[':p' . $index++]  = 'STORAGE_TYPE';
        }
        if ($this->isColumnModified(HfproductsTableMap::STORAGE_VOLUME)) {
            $modifiedColumns[':p' . $index++]  = 'STORAGE_VOLUME';
        }
        if ($this->isColumnModified(HfproductsTableMap::STORAGE_NON_SOLAR_VOLUME)) {
            $modifiedColumns[':p' . $index++]  = 'STORAGE_NON_SOLAR_VOLUME';
        }
        if ($this->isColumnModified(HfproductsTableMap::STORAGE_WARMTH_LOSS)) {
            $modifiedColumns[':p' . $index++]  = 'STORAGE_WARMTH_LOSS';
        }
        if ($this->isColumnModified(HfproductsTableMap::COMBINATION_HEATER_SPACE_HEATER_GRADE)) {
            $modifiedColumns[':p' . $index++]  = 'COMBINATION_HEATER_SPACE_HEATER_GRADE';
        }
        if ($this->isColumnModified(HfproductsTableMap::COMBINATION_HEATER_WATER_HEATER_GRADE)) {
            $modifiedColumns[':p' . $index++]  = 'COMBINATION_HEATER_WATER_HEATER_GRADE';
        }
        if ($this->isColumnModified(HfproductsTableMap::COMBINED_EFFICIENCY)) {
            $modifiedColumns[':p' . $index++]  = 'COMBINED_EFFICIENCY';
        }
        if ($this->isColumnModified(HfproductsTableMap::COMBINED_MAIN_HEATER_TYPE_ID)) {
            $modifiedColumns[':p' . $index++]  = 'COMBINED_MAIN_HEATER_TYPE_ID';
        }
        if ($this->isColumnModified(HfproductsTableMap::TEMPERATURE_CONTROL_STANDBY_WARMTH_LOSS)) {
            $modifiedColumns[':p' . $index++]  = 'TEMPERATURE_CONTROL_STANDBY_WARMTH_LOSS';
        }
        if ($this->isColumnModified(HfproductsTableMap::TEMPERATURE_CONTROL_TYPE)) {
            $modifiedColumns[':p' . $index++]  = 'TEMPERATURE_CONTROL_TYPE';
        }
        if ($this->isColumnModified(HfproductsTableMap::SUPPLEMENTARY_POWER)) {
            $modifiedColumns[':p' . $index++]  = 'SUPPLEMENTARY_POWER';
        }
        if ($this->isColumnModified(HfproductsTableMap::MONTAGE_ID)) {
            $modifiedColumns[':p' . $index++]  = 'MONTAGE_ID';
        }
        if ($this->isColumnModified(HfproductsTableMap::PRICE)) {
            $modifiedColumns[':p' . $index++]  = 'PRICE';
        }

        $sql = sprintf(
            'INSERT INTO hfproducts (%s) VALUES (%s)',
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
                    case 'VENDOR_ID':
                        $stmt->bindValue($identifier, $this->vendor_id, PDO::PARAM_INT);
                        break;
                    case 'NAME':
                        $stmt->bindValue($identifier, $this->name, PDO::PARAM_STR);
                        break;
                    case 'OAG_NAME':
                        $stmt->bindValue($identifier, $this->oag_name, PDO::PARAM_STR);
                        break;
                    case 'TYPE_ID':
                        $stmt->bindValue($identifier, $this->type_id, PDO::PARAM_INT);
                        break;
                    case 'PRODUCT_NUMBER':
                        $stmt->bindValue($identifier, $this->product_number, PDO::PARAM_STR);
                        break;
                    case 'GRADE':
                        $stmt->bindValue($identifier, $this->grade, PDO::PARAM_STR);
                        break;
                    case 'BUILD_YEAR_FROM':
                        $stmt->bindValue($identifier, $this->build_year_from, PDO::PARAM_INT);
                        break;
                    case 'BUILD_YEAR_TO':
                        $stmt->bindValue($identifier, $this->build_year_to, PDO::PARAM_INT);
                        break;
                    case 'CREATEDAT':
                        $stmt->bindValue($identifier, $this->createdat ? $this->createdat->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                    case 'UPDATEDAT':
                        $stmt->bindValue($identifier, $this->updatedat ? $this->updatedat->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                    case 'SHT_PRODUCT':
                        $stmt->bindValue($identifier, (int) $this->sht_product, PDO::PARAM_INT);
                        break;
                    case 'SHT_ID':
                        $stmt->bindValue($identifier, $this->sht_id, PDO::PARAM_STR);
                        break;
                    case 'SHT_CATEGORY':
                        $stmt->bindValue($identifier, $this->sht_category, PDO::PARAM_INT);
                        break;
                    case 'SHT_TEXT1':
                        $stmt->bindValue($identifier, $this->sht_text1, PDO::PARAM_STR);
                        break;
                    case 'SHT_TEXT2':
                        $stmt->bindValue($identifier, $this->sht_text2, PDO::PARAM_STR);
                        break;
                    case 'OAG_PRODUCT':
                        $stmt->bindValue($identifier, (int) $this->oag_product, PDO::PARAM_INT);
                        break;
                    case 'OAG_ID':
                        $stmt->bindValue($identifier, $this->oag_id, PDO::PARAM_STR);
                        break;
                    case 'OAG_CATEGORY':
                        $stmt->bindValue($identifier, $this->oag_category, PDO::PARAM_INT);
                        break;
                    case 'OAG_TEXT1':
                        $stmt->bindValue($identifier, $this->oag_text1, PDO::PARAM_STR);
                        break;
                    case 'OAG_TEXT2':
                        $stmt->bindValue($identifier, $this->oag_text2, PDO::PARAM_STR);
                        break;
                    case 'MEGABILD_ID':
                        $stmt->bindValue($identifier, $this->megabild_id, PDO::PARAM_INT);
                        break;
                    case 'IMAGE':
                        $stmt->bindValue($identifier, $this->image, PDO::PARAM_STR);
                        break;
                    case 'SPECIFICATION_NAME':
                        $stmt->bindValue($identifier, $this->specification_name, PDO::PARAM_STR);
                        break;
                    case 'LABEL_NAME':
                        $stmt->bindValue($identifier, $this->label_name, PDO::PARAM_STR);
                        break;
                    case 'WATER_HEATER_ENERGY_CLASS':
                        $stmt->bindValue($identifier, $this->water_heater_energy_class, PDO::PARAM_STR);
                        break;
                    case 'WATER_HEATER_ENERGY_EFFICIENCY':
                        $stmt->bindValue($identifier, $this->water_heater_energy_efficiency, PDO::PARAM_INT);
                        break;
                    case 'WATER_HEATER_ENERGY_GRADE':
                        $stmt->bindValue($identifier, $this->water_heater_energy_grade, PDO::PARAM_STR);
                        break;
                    case 'SPACE_HEATER_EFFICIENCY':
                        $stmt->bindValue($identifier, $this->space_heater_efficiency, PDO::PARAM_INT);
                        break;
                    case 'SPACE_HEATER_POWER':
                        $stmt->bindValue($identifier, $this->space_heater_power, PDO::PARAM_INT);
                        break;
                    case 'SPACE_HEATER_TYPE':
                        $stmt->bindValue($identifier, $this->space_heater_type, PDO::PARAM_STR);
                        break;
                    case 'SPACE_HEATER_LOW_TEMPERATURE_HEAT_PUMP':
                        $stmt->bindValue($identifier, (int) $this->space_heater_low_temperature_heat_pump, PDO::PARAM_INT);
                        break;
                    case 'SPACE_HEATER_COLDER_EFFICIENCY':
                        $stmt->bindValue($identifier, $this->space_heater_colder_efficiency, PDO::PARAM_INT);
                        break;
                    case 'SPACE_HEATER_WARMER_EFFICIENCY':
                        $stmt->bindValue($identifier, $this->space_heater_warmer_efficiency, PDO::PARAM_INT);
                        break;
                    case 'SPACE_HEATER_LOW_TEMPERATURE_GRADE':
                        $stmt->bindValue($identifier, $this->space_heater_low_temperature_grade, PDO::PARAM_STR);
                        break;
                    case 'SPACE_HEATER_LOW_TEMPERATURE_EFFICIENCY':
                        $stmt->bindValue($identifier, $this->space_heater_low_temperature_efficiency, PDO::PARAM_INT);
                        break;
                    case 'SPACE_HEATER_LOW_TEMPERATURE_COLDER_EFFICIENCY':
                        $stmt->bindValue($identifier, $this->space_heater_low_temperature_colder_efficiency, PDO::PARAM_INT);
                        break;
                    case 'SPACE_HEATER_LOW_TEMPERATURE_WARMER_EFFICIENCY':
                        $stmt->bindValue($identifier, $this->space_heater_low_temperature_warmer_efficiency, PDO::PARAM_INT);
                        break;
                    case 'SPACE_HEATER_LOW_TEMPERATURE_SUPPLEMENTARY_POWER':
                        $stmt->bindValue($identifier, $this->space_heater_low_temperature_supplementary_power, PDO::PARAM_INT);
                        break;
                    case 'SPACE_HEATER_LOW_TEMPERATURE_POWER':
                        $stmt->bindValue($identifier, $this->space_heater_low_temperature_power, PDO::PARAM_INT);
                        break;
                    case 'SOLAR_EFFICIENCY':
                        $stmt->bindValue($identifier, $this->solar_efficiency, PDO::PARAM_STR);
                        break;
                    case 'SOLAR_SIZE':
                        $stmt->bindValue($identifier, $this->solar_size, PDO::PARAM_STR);
                        break;
                    case 'SOLAR_PUMP_POWER':
                        $stmt->bindValue($identifier, $this->solar_pump_power, PDO::PARAM_INT);
                        break;
                    case 'STORAGE_TYPE':
                        $stmt->bindValue($identifier, $this->storage_type, PDO::PARAM_STR);
                        break;
                    case 'STORAGE_VOLUME':
                        $stmt->bindValue($identifier, $this->storage_volume, PDO::PARAM_STR);
                        break;
                    case 'STORAGE_NON_SOLAR_VOLUME':
                        $stmt->bindValue($identifier, $this->storage_non_solar_volume, PDO::PARAM_STR);
                        break;
                    case 'STORAGE_WARMTH_LOSS':
                        $stmt->bindValue($identifier, $this->storage_warmth_loss, PDO::PARAM_INT);
                        break;
                    case 'COMBINATION_HEATER_SPACE_HEATER_GRADE':
                        $stmt->bindValue($identifier, $this->combination_heater_space_heater_grade, PDO::PARAM_STR);
                        break;
                    case 'COMBINATION_HEATER_WATER_HEATER_GRADE':
                        $stmt->bindValue($identifier, $this->combination_heater_water_heater_grade, PDO::PARAM_STR);
                        break;
                    case 'COMBINED_EFFICIENCY':
                        $stmt->bindValue($identifier, $this->combined_efficiency, PDO::PARAM_INT);
                        break;
                    case 'COMBINED_MAIN_HEATER_TYPE_ID':
                        $stmt->bindValue($identifier, $this->combined_main_heater_type_id, PDO::PARAM_INT);
                        break;
                    case 'TEMPERATURE_CONTROL_STANDBY_WARMTH_LOSS':
                        $stmt->bindValue($identifier, $this->temperature_control_standby_warmth_loss, PDO::PARAM_STR);
                        break;
                    case 'TEMPERATURE_CONTROL_TYPE':
                        $stmt->bindValue($identifier, $this->temperature_control_type, PDO::PARAM_STR);
                        break;
                    case 'SUPPLEMENTARY_POWER':
                        $stmt->bindValue($identifier, $this->supplementary_power, PDO::PARAM_INT);
                        break;
                    case 'MONTAGE_ID':
                        $stmt->bindValue($identifier, $this->montage_id, PDO::PARAM_INT);
                        break;
                    case 'PRICE':
                        $stmt->bindValue($identifier, $this->price, PDO::PARAM_STR);
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
        $pos = HfproductsTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getVendorId();
                break;
            case 2:
                return $this->getName();
                break;
            case 3:
                return $this->getOagName();
                break;
            case 4:
                return $this->getTypeId();
                break;
            case 5:
                return $this->getProductNumber();
                break;
            case 6:
                return $this->getGrade();
                break;
            case 7:
                return $this->getBuildYearFrom();
                break;
            case 8:
                return $this->getBuildYearTo();
                break;
            case 9:
                return $this->getCreatedat();
                break;
            case 10:
                return $this->getUpdatedat();
                break;
            case 11:
                return $this->getShtProduct();
                break;
            case 12:
                return $this->getShtId();
                break;
            case 13:
                return $this->getShtCategory();
                break;
            case 14:
                return $this->getShtText1();
                break;
            case 15:
                return $this->getShtText2();
                break;
            case 16:
                return $this->getOagProduct();
                break;
            case 17:
                return $this->getOagId();
                break;
            case 18:
                return $this->getOagCategory();
                break;
            case 19:
                return $this->getOagText1();
                break;
            case 20:
                return $this->getOagText2();
                break;
            case 21:
                return $this->getMegabildId();
                break;
            case 22:
                return $this->getImage();
                break;
            case 23:
                return $this->getSpecificationName();
                break;
            case 24:
                return $this->getLabelName();
                break;
            case 25:
                return $this->getWaterHeaterEnergyClass();
                break;
            case 26:
                return $this->getWaterHeaterEnergyEfficiency();
                break;
            case 27:
                return $this->getWaterHeaterEnergyGrade();
                break;
            case 28:
                return $this->getSpaceHeaterEfficiency();
                break;
            case 29:
                return $this->getSpaceHeaterPower();
                break;
            case 30:
                return $this->getSpaceHeaterType();
                break;
            case 31:
                return $this->getSpaceHeaterLowTemperatureHeatPump();
                break;
            case 32:
                return $this->getSpaceHeaterColderEfficiency();
                break;
            case 33:
                return $this->getSpaceHeaterWarmerEfficiency();
                break;
            case 34:
                return $this->getSpaceHeaterLowTemperatureGrade();
                break;
            case 35:
                return $this->getSpaceHeaterLowTemperatureEfficiency();
                break;
            case 36:
                return $this->getSpaceHeaterLowTemperatureColderEfficiency();
                break;
            case 37:
                return $this->getSpaceHeaterLowTemperatureWarmerEfficiency();
                break;
            case 38:
                return $this->getSpaceHeaterLowTemperatureSupplementaryPower();
                break;
            case 39:
                return $this->getSpaceHeaterLowTemperaturePower();
                break;
            case 40:
                return $this->getSolarEfficiency();
                break;
            case 41:
                return $this->getSolarSize();
                break;
            case 42:
                return $this->getSolarPumpPower();
                break;
            case 43:
                return $this->getStorageType();
                break;
            case 44:
                return $this->getStorageVolume();
                break;
            case 45:
                return $this->getStorageNonSolarVolume();
                break;
            case 46:
                return $this->getStorageWarmthLoss();
                break;
            case 47:
                return $this->getCombinationHeaterSpaceHeaterGrade();
                break;
            case 48:
                return $this->getCombinationHeaterWaterHeaterGrade();
                break;
            case 49:
                return $this->getCombinedEfficiency();
                break;
            case 50:
                return $this->getCombinedMainHeaterTypeId();
                break;
            case 51:
                return $this->getTemperatureControlStandbyWarmthLoss();
                break;
            case 52:
                return $this->getTemperatureControlType();
                break;
            case 53:
                return $this->getSupplementaryPower();
                break;
            case 54:
                return $this->getMontageId();
                break;
            case 55:
                return $this->getPrice();
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
        if (isset($alreadyDumpedObjects['Hfproducts'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Hfproducts'][$this->getPrimaryKey()] = true;
        $keys = HfproductsTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getVendorId(),
            $keys[2] => $this->getName(),
            $keys[3] => $this->getOagName(),
            $keys[4] => $this->getTypeId(),
            $keys[5] => $this->getProductNumber(),
            $keys[6] => $this->getGrade(),
            $keys[7] => $this->getBuildYearFrom(),
            $keys[8] => $this->getBuildYearTo(),
            $keys[9] => $this->getCreatedat(),
            $keys[10] => $this->getUpdatedat(),
            $keys[11] => $this->getShtProduct(),
            $keys[12] => $this->getShtId(),
            $keys[13] => $this->getShtCategory(),
            $keys[14] => $this->getShtText1(),
            $keys[15] => $this->getShtText2(),
            $keys[16] => $this->getOagProduct(),
            $keys[17] => $this->getOagId(),
            $keys[18] => $this->getOagCategory(),
            $keys[19] => $this->getOagText1(),
            $keys[20] => $this->getOagText2(),
            $keys[21] => $this->getMegabildId(),
            $keys[22] => $this->getImage(),
            $keys[23] => $this->getSpecificationName(),
            $keys[24] => $this->getLabelName(),
            $keys[25] => $this->getWaterHeaterEnergyClass(),
            $keys[26] => $this->getWaterHeaterEnergyEfficiency(),
            $keys[27] => $this->getWaterHeaterEnergyGrade(),
            $keys[28] => $this->getSpaceHeaterEfficiency(),
            $keys[29] => $this->getSpaceHeaterPower(),
            $keys[30] => $this->getSpaceHeaterType(),
            $keys[31] => $this->getSpaceHeaterLowTemperatureHeatPump(),
            $keys[32] => $this->getSpaceHeaterColderEfficiency(),
            $keys[33] => $this->getSpaceHeaterWarmerEfficiency(),
            $keys[34] => $this->getSpaceHeaterLowTemperatureGrade(),
            $keys[35] => $this->getSpaceHeaterLowTemperatureEfficiency(),
            $keys[36] => $this->getSpaceHeaterLowTemperatureColderEfficiency(),
            $keys[37] => $this->getSpaceHeaterLowTemperatureWarmerEfficiency(),
            $keys[38] => $this->getSpaceHeaterLowTemperatureSupplementaryPower(),
            $keys[39] => $this->getSpaceHeaterLowTemperaturePower(),
            $keys[40] => $this->getSolarEfficiency(),
            $keys[41] => $this->getSolarSize(),
            $keys[42] => $this->getSolarPumpPower(),
            $keys[43] => $this->getStorageType(),
            $keys[44] => $this->getStorageVolume(),
            $keys[45] => $this->getStorageNonSolarVolume(),
            $keys[46] => $this->getStorageWarmthLoss(),
            $keys[47] => $this->getCombinationHeaterSpaceHeaterGrade(),
            $keys[48] => $this->getCombinationHeaterWaterHeaterGrade(),
            $keys[49] => $this->getCombinedEfficiency(),
            $keys[50] => $this->getCombinedMainHeaterTypeId(),
            $keys[51] => $this->getTemperatureControlStandbyWarmthLoss(),
            $keys[52] => $this->getTemperatureControlType(),
            $keys[53] => $this->getSupplementaryPower(),
            $keys[54] => $this->getMontageId(),
            $keys[55] => $this->getPrice(),
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
        $pos = HfproductsTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

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
                $this->setVendorId($value);
                break;
            case 2:
                $this->setName($value);
                break;
            case 3:
                $this->setOagName($value);
                break;
            case 4:
                $this->setTypeId($value);
                break;
            case 5:
                $this->setProductNumber($value);
                break;
            case 6:
                $this->setGrade($value);
                break;
            case 7:
                $this->setBuildYearFrom($value);
                break;
            case 8:
                $this->setBuildYearTo($value);
                break;
            case 9:
                $this->setCreatedat($value);
                break;
            case 10:
                $this->setUpdatedat($value);
                break;
            case 11:
                $this->setShtProduct($value);
                break;
            case 12:
                $this->setShtId($value);
                break;
            case 13:
                $this->setShtCategory($value);
                break;
            case 14:
                $this->setShtText1($value);
                break;
            case 15:
                $this->setShtText2($value);
                break;
            case 16:
                $this->setOagProduct($value);
                break;
            case 17:
                $this->setOagId($value);
                break;
            case 18:
                $this->setOagCategory($value);
                break;
            case 19:
                $this->setOagText1($value);
                break;
            case 20:
                $this->setOagText2($value);
                break;
            case 21:
                $this->setMegabildId($value);
                break;
            case 22:
                $this->setImage($value);
                break;
            case 23:
                $this->setSpecificationName($value);
                break;
            case 24:
                $this->setLabelName($value);
                break;
            case 25:
                $this->setWaterHeaterEnergyClass($value);
                break;
            case 26:
                $this->setWaterHeaterEnergyEfficiency($value);
                break;
            case 27:
                $this->setWaterHeaterEnergyGrade($value);
                break;
            case 28:
                $this->setSpaceHeaterEfficiency($value);
                break;
            case 29:
                $this->setSpaceHeaterPower($value);
                break;
            case 30:
                $this->setSpaceHeaterType($value);
                break;
            case 31:
                $this->setSpaceHeaterLowTemperatureHeatPump($value);
                break;
            case 32:
                $this->setSpaceHeaterColderEfficiency($value);
                break;
            case 33:
                $this->setSpaceHeaterWarmerEfficiency($value);
                break;
            case 34:
                $this->setSpaceHeaterLowTemperatureGrade($value);
                break;
            case 35:
                $this->setSpaceHeaterLowTemperatureEfficiency($value);
                break;
            case 36:
                $this->setSpaceHeaterLowTemperatureColderEfficiency($value);
                break;
            case 37:
                $this->setSpaceHeaterLowTemperatureWarmerEfficiency($value);
                break;
            case 38:
                $this->setSpaceHeaterLowTemperatureSupplementaryPower($value);
                break;
            case 39:
                $this->setSpaceHeaterLowTemperaturePower($value);
                break;
            case 40:
                $this->setSolarEfficiency($value);
                break;
            case 41:
                $this->setSolarSize($value);
                break;
            case 42:
                $this->setSolarPumpPower($value);
                break;
            case 43:
                $this->setStorageType($value);
                break;
            case 44:
                $this->setStorageVolume($value);
                break;
            case 45:
                $this->setStorageNonSolarVolume($value);
                break;
            case 46:
                $this->setStorageWarmthLoss($value);
                break;
            case 47:
                $this->setCombinationHeaterSpaceHeaterGrade($value);
                break;
            case 48:
                $this->setCombinationHeaterWaterHeaterGrade($value);
                break;
            case 49:
                $this->setCombinedEfficiency($value);
                break;
            case 50:
                $this->setCombinedMainHeaterTypeId($value);
                break;
            case 51:
                $this->setTemperatureControlStandbyWarmthLoss($value);
                break;
            case 52:
                $this->setTemperatureControlType($value);
                break;
            case 53:
                $this->setSupplementaryPower($value);
                break;
            case 54:
                $this->setMontageId($value);
                break;
            case 55:
                $this->setPrice($value);
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
        $keys = HfproductsTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setVendorId($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setName($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setOagName($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setTypeId($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setProductNumber($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setGrade($arr[$keys[6]]);
        if (array_key_exists($keys[7], $arr)) $this->setBuildYearFrom($arr[$keys[7]]);
        if (array_key_exists($keys[8], $arr)) $this->setBuildYearTo($arr[$keys[8]]);
        if (array_key_exists($keys[9], $arr)) $this->setCreatedat($arr[$keys[9]]);
        if (array_key_exists($keys[10], $arr)) $this->setUpdatedat($arr[$keys[10]]);
        if (array_key_exists($keys[11], $arr)) $this->setShtProduct($arr[$keys[11]]);
        if (array_key_exists($keys[12], $arr)) $this->setShtId($arr[$keys[12]]);
        if (array_key_exists($keys[13], $arr)) $this->setShtCategory($arr[$keys[13]]);
        if (array_key_exists($keys[14], $arr)) $this->setShtText1($arr[$keys[14]]);
        if (array_key_exists($keys[15], $arr)) $this->setShtText2($arr[$keys[15]]);
        if (array_key_exists($keys[16], $arr)) $this->setOagProduct($arr[$keys[16]]);
        if (array_key_exists($keys[17], $arr)) $this->setOagId($arr[$keys[17]]);
        if (array_key_exists($keys[18], $arr)) $this->setOagCategory($arr[$keys[18]]);
        if (array_key_exists($keys[19], $arr)) $this->setOagText1($arr[$keys[19]]);
        if (array_key_exists($keys[20], $arr)) $this->setOagText2($arr[$keys[20]]);
        if (array_key_exists($keys[21], $arr)) $this->setMegabildId($arr[$keys[21]]);
        if (array_key_exists($keys[22], $arr)) $this->setImage($arr[$keys[22]]);
        if (array_key_exists($keys[23], $arr)) $this->setSpecificationName($arr[$keys[23]]);
        if (array_key_exists($keys[24], $arr)) $this->setLabelName($arr[$keys[24]]);
        if (array_key_exists($keys[25], $arr)) $this->setWaterHeaterEnergyClass($arr[$keys[25]]);
        if (array_key_exists($keys[26], $arr)) $this->setWaterHeaterEnergyEfficiency($arr[$keys[26]]);
        if (array_key_exists($keys[27], $arr)) $this->setWaterHeaterEnergyGrade($arr[$keys[27]]);
        if (array_key_exists($keys[28], $arr)) $this->setSpaceHeaterEfficiency($arr[$keys[28]]);
        if (array_key_exists($keys[29], $arr)) $this->setSpaceHeaterPower($arr[$keys[29]]);
        if (array_key_exists($keys[30], $arr)) $this->setSpaceHeaterType($arr[$keys[30]]);
        if (array_key_exists($keys[31], $arr)) $this->setSpaceHeaterLowTemperatureHeatPump($arr[$keys[31]]);
        if (array_key_exists($keys[32], $arr)) $this->setSpaceHeaterColderEfficiency($arr[$keys[32]]);
        if (array_key_exists($keys[33], $arr)) $this->setSpaceHeaterWarmerEfficiency($arr[$keys[33]]);
        if (array_key_exists($keys[34], $arr)) $this->setSpaceHeaterLowTemperatureGrade($arr[$keys[34]]);
        if (array_key_exists($keys[35], $arr)) $this->setSpaceHeaterLowTemperatureEfficiency($arr[$keys[35]]);
        if (array_key_exists($keys[36], $arr)) $this->setSpaceHeaterLowTemperatureColderEfficiency($arr[$keys[36]]);
        if (array_key_exists($keys[37], $arr)) $this->setSpaceHeaterLowTemperatureWarmerEfficiency($arr[$keys[37]]);
        if (array_key_exists($keys[38], $arr)) $this->setSpaceHeaterLowTemperatureSupplementaryPower($arr[$keys[38]]);
        if (array_key_exists($keys[39], $arr)) $this->setSpaceHeaterLowTemperaturePower($arr[$keys[39]]);
        if (array_key_exists($keys[40], $arr)) $this->setSolarEfficiency($arr[$keys[40]]);
        if (array_key_exists($keys[41], $arr)) $this->setSolarSize($arr[$keys[41]]);
        if (array_key_exists($keys[42], $arr)) $this->setSolarPumpPower($arr[$keys[42]]);
        if (array_key_exists($keys[43], $arr)) $this->setStorageType($arr[$keys[43]]);
        if (array_key_exists($keys[44], $arr)) $this->setStorageVolume($arr[$keys[44]]);
        if (array_key_exists($keys[45], $arr)) $this->setStorageNonSolarVolume($arr[$keys[45]]);
        if (array_key_exists($keys[46], $arr)) $this->setStorageWarmthLoss($arr[$keys[46]]);
        if (array_key_exists($keys[47], $arr)) $this->setCombinationHeaterSpaceHeaterGrade($arr[$keys[47]]);
        if (array_key_exists($keys[48], $arr)) $this->setCombinationHeaterWaterHeaterGrade($arr[$keys[48]]);
        if (array_key_exists($keys[49], $arr)) $this->setCombinedEfficiency($arr[$keys[49]]);
        if (array_key_exists($keys[50], $arr)) $this->setCombinedMainHeaterTypeId($arr[$keys[50]]);
        if (array_key_exists($keys[51], $arr)) $this->setTemperatureControlStandbyWarmthLoss($arr[$keys[51]]);
        if (array_key_exists($keys[52], $arr)) $this->setTemperatureControlType($arr[$keys[52]]);
        if (array_key_exists($keys[53], $arr)) $this->setSupplementaryPower($arr[$keys[53]]);
        if (array_key_exists($keys[54], $arr)) $this->setMontageId($arr[$keys[54]]);
        if (array_key_exists($keys[55], $arr)) $this->setPrice($arr[$keys[55]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(HfproductsTableMap::DATABASE_NAME);

        if ($this->isColumnModified(HfproductsTableMap::ID)) $criteria->add(HfproductsTableMap::ID, $this->id);
        if ($this->isColumnModified(HfproductsTableMap::VENDOR_ID)) $criteria->add(HfproductsTableMap::VENDOR_ID, $this->vendor_id);
        if ($this->isColumnModified(HfproductsTableMap::NAME)) $criteria->add(HfproductsTableMap::NAME, $this->name);
        if ($this->isColumnModified(HfproductsTableMap::OAG_NAME)) $criteria->add(HfproductsTableMap::OAG_NAME, $this->oag_name);
        if ($this->isColumnModified(HfproductsTableMap::TYPE_ID)) $criteria->add(HfproductsTableMap::TYPE_ID, $this->type_id);
        if ($this->isColumnModified(HfproductsTableMap::PRODUCT_NUMBER)) $criteria->add(HfproductsTableMap::PRODUCT_NUMBER, $this->product_number);
        if ($this->isColumnModified(HfproductsTableMap::GRADE)) $criteria->add(HfproductsTableMap::GRADE, $this->grade);
        if ($this->isColumnModified(HfproductsTableMap::BUILD_YEAR_FROM)) $criteria->add(HfproductsTableMap::BUILD_YEAR_FROM, $this->build_year_from);
        if ($this->isColumnModified(HfproductsTableMap::BUILD_YEAR_TO)) $criteria->add(HfproductsTableMap::BUILD_YEAR_TO, $this->build_year_to);
        if ($this->isColumnModified(HfproductsTableMap::CREATEDAT)) $criteria->add(HfproductsTableMap::CREATEDAT, $this->createdat);
        if ($this->isColumnModified(HfproductsTableMap::UPDATEDAT)) $criteria->add(HfproductsTableMap::UPDATEDAT, $this->updatedat);
        if ($this->isColumnModified(HfproductsTableMap::SHT_PRODUCT)) $criteria->add(HfproductsTableMap::SHT_PRODUCT, $this->sht_product);
        if ($this->isColumnModified(HfproductsTableMap::SHT_ID)) $criteria->add(HfproductsTableMap::SHT_ID, $this->sht_id);
        if ($this->isColumnModified(HfproductsTableMap::SHT_CATEGORY)) $criteria->add(HfproductsTableMap::SHT_CATEGORY, $this->sht_category);
        if ($this->isColumnModified(HfproductsTableMap::SHT_TEXT1)) $criteria->add(HfproductsTableMap::SHT_TEXT1, $this->sht_text1);
        if ($this->isColumnModified(HfproductsTableMap::SHT_TEXT2)) $criteria->add(HfproductsTableMap::SHT_TEXT2, $this->sht_text2);
        if ($this->isColumnModified(HfproductsTableMap::OAG_PRODUCT)) $criteria->add(HfproductsTableMap::OAG_PRODUCT, $this->oag_product);
        if ($this->isColumnModified(HfproductsTableMap::OAG_ID)) $criteria->add(HfproductsTableMap::OAG_ID, $this->oag_id);
        if ($this->isColumnModified(HfproductsTableMap::OAG_CATEGORY)) $criteria->add(HfproductsTableMap::OAG_CATEGORY, $this->oag_category);
        if ($this->isColumnModified(HfproductsTableMap::OAG_TEXT1)) $criteria->add(HfproductsTableMap::OAG_TEXT1, $this->oag_text1);
        if ($this->isColumnModified(HfproductsTableMap::OAG_TEXT2)) $criteria->add(HfproductsTableMap::OAG_TEXT2, $this->oag_text2);
        if ($this->isColumnModified(HfproductsTableMap::MEGABILD_ID)) $criteria->add(HfproductsTableMap::MEGABILD_ID, $this->megabild_id);
        if ($this->isColumnModified(HfproductsTableMap::IMAGE)) $criteria->add(HfproductsTableMap::IMAGE, $this->image);
        if ($this->isColumnModified(HfproductsTableMap::SPECIFICATION_NAME)) $criteria->add(HfproductsTableMap::SPECIFICATION_NAME, $this->specification_name);
        if ($this->isColumnModified(HfproductsTableMap::LABEL_NAME)) $criteria->add(HfproductsTableMap::LABEL_NAME, $this->label_name);
        if ($this->isColumnModified(HfproductsTableMap::WATER_HEATER_ENERGY_CLASS)) $criteria->add(HfproductsTableMap::WATER_HEATER_ENERGY_CLASS, $this->water_heater_energy_class);
        if ($this->isColumnModified(HfproductsTableMap::WATER_HEATER_ENERGY_EFFICIENCY)) $criteria->add(HfproductsTableMap::WATER_HEATER_ENERGY_EFFICIENCY, $this->water_heater_energy_efficiency);
        if ($this->isColumnModified(HfproductsTableMap::WATER_HEATER_ENERGY_GRADE)) $criteria->add(HfproductsTableMap::WATER_HEATER_ENERGY_GRADE, $this->water_heater_energy_grade);
        if ($this->isColumnModified(HfproductsTableMap::SPACE_HEATER_EFFICIENCY)) $criteria->add(HfproductsTableMap::SPACE_HEATER_EFFICIENCY, $this->space_heater_efficiency);
        if ($this->isColumnModified(HfproductsTableMap::SPACE_HEATER_POWER)) $criteria->add(HfproductsTableMap::SPACE_HEATER_POWER, $this->space_heater_power);
        if ($this->isColumnModified(HfproductsTableMap::SPACE_HEATER_TYPE)) $criteria->add(HfproductsTableMap::SPACE_HEATER_TYPE, $this->space_heater_type);
        if ($this->isColumnModified(HfproductsTableMap::SPACE_HEATER_LOW_TEMPERATURE_HEAT_PUMP)) $criteria->add(HfproductsTableMap::SPACE_HEATER_LOW_TEMPERATURE_HEAT_PUMP, $this->space_heater_low_temperature_heat_pump);
        if ($this->isColumnModified(HfproductsTableMap::SPACE_HEATER_COLDER_EFFICIENCY)) $criteria->add(HfproductsTableMap::SPACE_HEATER_COLDER_EFFICIENCY, $this->space_heater_colder_efficiency);
        if ($this->isColumnModified(HfproductsTableMap::SPACE_HEATER_WARMER_EFFICIENCY)) $criteria->add(HfproductsTableMap::SPACE_HEATER_WARMER_EFFICIENCY, $this->space_heater_warmer_efficiency);
        if ($this->isColumnModified(HfproductsTableMap::SPACE_HEATER_LOW_TEMPERATURE_GRADE)) $criteria->add(HfproductsTableMap::SPACE_HEATER_LOW_TEMPERATURE_GRADE, $this->space_heater_low_temperature_grade);
        if ($this->isColumnModified(HfproductsTableMap::SPACE_HEATER_LOW_TEMPERATURE_EFFICIENCY)) $criteria->add(HfproductsTableMap::SPACE_HEATER_LOW_TEMPERATURE_EFFICIENCY, $this->space_heater_low_temperature_efficiency);
        if ($this->isColumnModified(HfproductsTableMap::SPACE_HEATER_LOW_TEMPERATURE_COLDER_EFFICIENCY)) $criteria->add(HfproductsTableMap::SPACE_HEATER_LOW_TEMPERATURE_COLDER_EFFICIENCY, $this->space_heater_low_temperature_colder_efficiency);
        if ($this->isColumnModified(HfproductsTableMap::SPACE_HEATER_LOW_TEMPERATURE_WARMER_EFFICIENCY)) $criteria->add(HfproductsTableMap::SPACE_HEATER_LOW_TEMPERATURE_WARMER_EFFICIENCY, $this->space_heater_low_temperature_warmer_efficiency);
        if ($this->isColumnModified(HfproductsTableMap::SPACE_HEATER_LOW_TEMPERATURE_SUPPLEMENTARY_POWER)) $criteria->add(HfproductsTableMap::SPACE_HEATER_LOW_TEMPERATURE_SUPPLEMENTARY_POWER, $this->space_heater_low_temperature_supplementary_power);
        if ($this->isColumnModified(HfproductsTableMap::SPACE_HEATER_LOW_TEMPERATURE_POWER)) $criteria->add(HfproductsTableMap::SPACE_HEATER_LOW_TEMPERATURE_POWER, $this->space_heater_low_temperature_power);
        if ($this->isColumnModified(HfproductsTableMap::SOLAR_EFFICIENCY)) $criteria->add(HfproductsTableMap::SOLAR_EFFICIENCY, $this->solar_efficiency);
        if ($this->isColumnModified(HfproductsTableMap::SOLAR_SIZE)) $criteria->add(HfproductsTableMap::SOLAR_SIZE, $this->solar_size);
        if ($this->isColumnModified(HfproductsTableMap::SOLAR_PUMP_POWER)) $criteria->add(HfproductsTableMap::SOLAR_PUMP_POWER, $this->solar_pump_power);
        if ($this->isColumnModified(HfproductsTableMap::STORAGE_TYPE)) $criteria->add(HfproductsTableMap::STORAGE_TYPE, $this->storage_type);
        if ($this->isColumnModified(HfproductsTableMap::STORAGE_VOLUME)) $criteria->add(HfproductsTableMap::STORAGE_VOLUME, $this->storage_volume);
        if ($this->isColumnModified(HfproductsTableMap::STORAGE_NON_SOLAR_VOLUME)) $criteria->add(HfproductsTableMap::STORAGE_NON_SOLAR_VOLUME, $this->storage_non_solar_volume);
        if ($this->isColumnModified(HfproductsTableMap::STORAGE_WARMTH_LOSS)) $criteria->add(HfproductsTableMap::STORAGE_WARMTH_LOSS, $this->storage_warmth_loss);
        if ($this->isColumnModified(HfproductsTableMap::COMBINATION_HEATER_SPACE_HEATER_GRADE)) $criteria->add(HfproductsTableMap::COMBINATION_HEATER_SPACE_HEATER_GRADE, $this->combination_heater_space_heater_grade);
        if ($this->isColumnModified(HfproductsTableMap::COMBINATION_HEATER_WATER_HEATER_GRADE)) $criteria->add(HfproductsTableMap::COMBINATION_HEATER_WATER_HEATER_GRADE, $this->combination_heater_water_heater_grade);
        if ($this->isColumnModified(HfproductsTableMap::COMBINED_EFFICIENCY)) $criteria->add(HfproductsTableMap::COMBINED_EFFICIENCY, $this->combined_efficiency);
        if ($this->isColumnModified(HfproductsTableMap::COMBINED_MAIN_HEATER_TYPE_ID)) $criteria->add(HfproductsTableMap::COMBINED_MAIN_HEATER_TYPE_ID, $this->combined_main_heater_type_id);
        if ($this->isColumnModified(HfproductsTableMap::TEMPERATURE_CONTROL_STANDBY_WARMTH_LOSS)) $criteria->add(HfproductsTableMap::TEMPERATURE_CONTROL_STANDBY_WARMTH_LOSS, $this->temperature_control_standby_warmth_loss);
        if ($this->isColumnModified(HfproductsTableMap::TEMPERATURE_CONTROL_TYPE)) $criteria->add(HfproductsTableMap::TEMPERATURE_CONTROL_TYPE, $this->temperature_control_type);
        if ($this->isColumnModified(HfproductsTableMap::SUPPLEMENTARY_POWER)) $criteria->add(HfproductsTableMap::SUPPLEMENTARY_POWER, $this->supplementary_power);
        if ($this->isColumnModified(HfproductsTableMap::MONTAGE_ID)) $criteria->add(HfproductsTableMap::MONTAGE_ID, $this->montage_id);
        if ($this->isColumnModified(HfproductsTableMap::PRICE)) $criteria->add(HfproductsTableMap::PRICE, $this->price);

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
        $criteria = new Criteria(HfproductsTableMap::DATABASE_NAME);
        $criteria->add(HfproductsTableMap::ID, $this->id);

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
     * @param      object $copyObj An object of \Hfproducts (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setVendorId($this->getVendorId());
        $copyObj->setName($this->getName());
        $copyObj->setOagName($this->getOagName());
        $copyObj->setTypeId($this->getTypeId());
        $copyObj->setProductNumber($this->getProductNumber());
        $copyObj->setGrade($this->getGrade());
        $copyObj->setBuildYearFrom($this->getBuildYearFrom());
        $copyObj->setBuildYearTo($this->getBuildYearTo());
        $copyObj->setCreatedat($this->getCreatedat());
        $copyObj->setUpdatedat($this->getUpdatedat());
        $copyObj->setShtProduct($this->getShtProduct());
        $copyObj->setShtId($this->getShtId());
        $copyObj->setShtCategory($this->getShtCategory());
        $copyObj->setShtText1($this->getShtText1());
        $copyObj->setShtText2($this->getShtText2());
        $copyObj->setOagProduct($this->getOagProduct());
        $copyObj->setOagId($this->getOagId());
        $copyObj->setOagCategory($this->getOagCategory());
        $copyObj->setOagText1($this->getOagText1());
        $copyObj->setOagText2($this->getOagText2());
        $copyObj->setMegabildId($this->getMegabildId());
        $copyObj->setImage($this->getImage());
        $copyObj->setSpecificationName($this->getSpecificationName());
        $copyObj->setLabelName($this->getLabelName());
        $copyObj->setWaterHeaterEnergyClass($this->getWaterHeaterEnergyClass());
        $copyObj->setWaterHeaterEnergyEfficiency($this->getWaterHeaterEnergyEfficiency());
        $copyObj->setWaterHeaterEnergyGrade($this->getWaterHeaterEnergyGrade());
        $copyObj->setSpaceHeaterEfficiency($this->getSpaceHeaterEfficiency());
        $copyObj->setSpaceHeaterPower($this->getSpaceHeaterPower());
        $copyObj->setSpaceHeaterType($this->getSpaceHeaterType());
        $copyObj->setSpaceHeaterLowTemperatureHeatPump($this->getSpaceHeaterLowTemperatureHeatPump());
        $copyObj->setSpaceHeaterColderEfficiency($this->getSpaceHeaterColderEfficiency());
        $copyObj->setSpaceHeaterWarmerEfficiency($this->getSpaceHeaterWarmerEfficiency());
        $copyObj->setSpaceHeaterLowTemperatureGrade($this->getSpaceHeaterLowTemperatureGrade());
        $copyObj->setSpaceHeaterLowTemperatureEfficiency($this->getSpaceHeaterLowTemperatureEfficiency());
        $copyObj->setSpaceHeaterLowTemperatureColderEfficiency($this->getSpaceHeaterLowTemperatureColderEfficiency());
        $copyObj->setSpaceHeaterLowTemperatureWarmerEfficiency($this->getSpaceHeaterLowTemperatureWarmerEfficiency());
        $copyObj->setSpaceHeaterLowTemperatureSupplementaryPower($this->getSpaceHeaterLowTemperatureSupplementaryPower());
        $copyObj->setSpaceHeaterLowTemperaturePower($this->getSpaceHeaterLowTemperaturePower());
        $copyObj->setSolarEfficiency($this->getSolarEfficiency());
        $copyObj->setSolarSize($this->getSolarSize());
        $copyObj->setSolarPumpPower($this->getSolarPumpPower());
        $copyObj->setStorageType($this->getStorageType());
        $copyObj->setStorageVolume($this->getStorageVolume());
        $copyObj->setStorageNonSolarVolume($this->getStorageNonSolarVolume());
        $copyObj->setStorageWarmthLoss($this->getStorageWarmthLoss());
        $copyObj->setCombinationHeaterSpaceHeaterGrade($this->getCombinationHeaterSpaceHeaterGrade());
        $copyObj->setCombinationHeaterWaterHeaterGrade($this->getCombinationHeaterWaterHeaterGrade());
        $copyObj->setCombinedEfficiency($this->getCombinedEfficiency());
        $copyObj->setCombinedMainHeaterTypeId($this->getCombinedMainHeaterTypeId());
        $copyObj->setTemperatureControlStandbyWarmthLoss($this->getTemperatureControlStandbyWarmthLoss());
        $copyObj->setTemperatureControlType($this->getTemperatureControlType());
        $copyObj->setSupplementaryPower($this->getSupplementaryPower());
        $copyObj->setMontageId($this->getMontageId());
        $copyObj->setPrice($this->getPrice());
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
     * @return                 \Hfproducts Clone of current object.
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
        $this->vendor_id = null;
        $this->name = null;
        $this->oag_name = null;
        $this->type_id = null;
        $this->product_number = null;
        $this->grade = null;
        $this->build_year_from = null;
        $this->build_year_to = null;
        $this->createdat = null;
        $this->updatedat = null;
        $this->sht_product = null;
        $this->sht_id = null;
        $this->sht_category = null;
        $this->sht_text1 = null;
        $this->sht_text2 = null;
        $this->oag_product = null;
        $this->oag_id = null;
        $this->oag_category = null;
        $this->oag_text1 = null;
        $this->oag_text2 = null;
        $this->megabild_id = null;
        $this->image = null;
        $this->specification_name = null;
        $this->label_name = null;
        $this->water_heater_energy_class = null;
        $this->water_heater_energy_efficiency = null;
        $this->water_heater_energy_grade = null;
        $this->space_heater_efficiency = null;
        $this->space_heater_power = null;
        $this->space_heater_type = null;
        $this->space_heater_low_temperature_heat_pump = null;
        $this->space_heater_colder_efficiency = null;
        $this->space_heater_warmer_efficiency = null;
        $this->space_heater_low_temperature_grade = null;
        $this->space_heater_low_temperature_efficiency = null;
        $this->space_heater_low_temperature_colder_efficiency = null;
        $this->space_heater_low_temperature_warmer_efficiency = null;
        $this->space_heater_low_temperature_supplementary_power = null;
        $this->space_heater_low_temperature_power = null;
        $this->solar_efficiency = null;
        $this->solar_size = null;
        $this->solar_pump_power = null;
        $this->storage_type = null;
        $this->storage_volume = null;
        $this->storage_non_solar_volume = null;
        $this->storage_warmth_loss = null;
        $this->combination_heater_space_heater_grade = null;
        $this->combination_heater_water_heater_grade = null;
        $this->combined_efficiency = null;
        $this->combined_main_heater_type_id = null;
        $this->temperature_control_standby_warmth_loss = null;
        $this->temperature_control_type = null;
        $this->supplementary_power = null;
        $this->montage_id = null;
        $this->price = null;
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
        return (string) $this->exportTo(HfproductsTableMap::DEFAULT_STRING_FORMAT);
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
