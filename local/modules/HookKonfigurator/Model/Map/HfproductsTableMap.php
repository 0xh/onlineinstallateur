<?php

namespace HookKonfigurator\Model\Map;

use HookKonfigurator\Model\Hfproducts;
use HookKonfigurator\Model\HfproductsQuery;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;

/**
 * This class defines the structure of the 'hfproducts' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class HfproductsTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;
    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'HookKonfigurator.Model.Map.HfproductsTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'thelia';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'hfproducts';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\HookKonfigurator\\Model\\Hfproducts';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'HookKonfigurator.Model.Hfproducts';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 56;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 56;

    /**
     * the column name for the ID field
     */
    const ID = 'hfproducts.ID';

    /**
     * the column name for the VENDOR_ID field
     */
    const VENDOR_ID = 'hfproducts.VENDOR_ID';

    /**
     * the column name for the NAME field
     */
    const NAME = 'hfproducts.NAME';

    /**
     * the column name for the OAG_NAME field
     */
    const OAG_NAME = 'hfproducts.OAG_NAME';

    /**
     * the column name for the TYPE_ID field
     */
    const TYPE_ID = 'hfproducts.TYPE_ID';

    /**
     * the column name for the PRODUCT_NUMBER field
     */
    const PRODUCT_NUMBER = 'hfproducts.PRODUCT_NUMBER';

    /**
     * the column name for the GRADE field
     */
    const GRADE = 'hfproducts.GRADE';

    /**
     * the column name for the BUILD_YEAR_FROM field
     */
    const BUILD_YEAR_FROM = 'hfproducts.BUILD_YEAR_FROM';

    /**
     * the column name for the BUILD_YEAR_TO field
     */
    const BUILD_YEAR_TO = 'hfproducts.BUILD_YEAR_TO';

    /**
     * the column name for the CREATEDAT field
     */
    const CREATEDAT = 'hfproducts.CREATEDAT';

    /**
     * the column name for the UPDATEDAT field
     */
    const UPDATEDAT = 'hfproducts.UPDATEDAT';

    /**
     * the column name for the SHT_PRODUCT field
     */
    const SHT_PRODUCT = 'hfproducts.SHT_PRODUCT';

    /**
     * the column name for the SHT_ID field
     */
    const SHT_ID = 'hfproducts.SHT_ID';

    /**
     * the column name for the SHT_CATEGORY field
     */
    const SHT_CATEGORY = 'hfproducts.SHT_CATEGORY';

    /**
     * the column name for the SHT_TEXT1 field
     */
    const SHT_TEXT1 = 'hfproducts.SHT_TEXT1';

    /**
     * the column name for the SHT_TEXT2 field
     */
    const SHT_TEXT2 = 'hfproducts.SHT_TEXT2';

    /**
     * the column name for the OAG_PRODUCT field
     */
    const OAG_PRODUCT = 'hfproducts.OAG_PRODUCT';

    /**
     * the column name for the OAG_ID field
     */
    const OAG_ID = 'hfproducts.OAG_ID';

    /**
     * the column name for the OAG_CATEGORY field
     */
    const OAG_CATEGORY = 'hfproducts.OAG_CATEGORY';

    /**
     * the column name for the OAG_TEXT1 field
     */
    const OAG_TEXT1 = 'hfproducts.OAG_TEXT1';

    /**
     * the column name for the OAG_TEXT2 field
     */
    const OAG_TEXT2 = 'hfproducts.OAG_TEXT2';

    /**
     * the column name for the MEGABILD_ID field
     */
    const MEGABILD_ID = 'hfproducts.MEGABILD_ID';

    /**
     * the column name for the IMAGE field
     */
    const IMAGE = 'hfproducts.IMAGE';

    /**
     * the column name for the SPECIFICATION_NAME field
     */
    const SPECIFICATION_NAME = 'hfproducts.SPECIFICATION_NAME';

    /**
     * the column name for the LABEL_NAME field
     */
    const LABEL_NAME = 'hfproducts.LABEL_NAME';

    /**
     * the column name for the WATER_HEATER_ENERGY_CLASS field
     */
    const WATER_HEATER_ENERGY_CLASS = 'hfproducts.WATER_HEATER_ENERGY_CLASS';

    /**
     * the column name for the WATER_HEATER_ENERGY_EFFICIENCY field
     */
    const WATER_HEATER_ENERGY_EFFICIENCY = 'hfproducts.WATER_HEATER_ENERGY_EFFICIENCY';

    /**
     * the column name for the WATER_HEATER_ENERGY_GRADE field
     */
    const WATER_HEATER_ENERGY_GRADE = 'hfproducts.WATER_HEATER_ENERGY_GRADE';

    /**
     * the column name for the SPACE_HEATER_EFFICIENCY field
     */
    const SPACE_HEATER_EFFICIENCY = 'hfproducts.SPACE_HEATER_EFFICIENCY';

    /**
     * the column name for the SPACE_HEATER_POWER field
     */
    const SPACE_HEATER_POWER = 'hfproducts.SPACE_HEATER_POWER';

    /**
     * the column name for the SPACE_HEATER_TYPE field
     */
    const SPACE_HEATER_TYPE = 'hfproducts.SPACE_HEATER_TYPE';

    /**
     * the column name for the SPACE_HEATER_LOW_TEMPERATURE_HEAT_PUMP field
     */
    const SPACE_HEATER_LOW_TEMPERATURE_HEAT_PUMP = 'hfproducts.SPACE_HEATER_LOW_TEMPERATURE_HEAT_PUMP';

    /**
     * the column name for the SPACE_HEATER_COLDER_EFFICIENCY field
     */
    const SPACE_HEATER_COLDER_EFFICIENCY = 'hfproducts.SPACE_HEATER_COLDER_EFFICIENCY';

    /**
     * the column name for the SPACE_HEATER_WARMER_EFFICIENCY field
     */
    const SPACE_HEATER_WARMER_EFFICIENCY = 'hfproducts.SPACE_HEATER_WARMER_EFFICIENCY';

    /**
     * the column name for the SPACE_HEATER_LOW_TEMPERATURE_GRADE field
     */
    const SPACE_HEATER_LOW_TEMPERATURE_GRADE = 'hfproducts.SPACE_HEATER_LOW_TEMPERATURE_GRADE';

    /**
     * the column name for the SPACE_HEATER_LOW_TEMPERATURE_EFFICIENCY field
     */
    const SPACE_HEATER_LOW_TEMPERATURE_EFFICIENCY = 'hfproducts.SPACE_HEATER_LOW_TEMPERATURE_EFFICIENCY';

    /**
     * the column name for the SPACE_HEATER_LOW_TEMPERATURE_COLDER_EFFICIENCY field
     */
    const SPACE_HEATER_LOW_TEMPERATURE_COLDER_EFFICIENCY = 'hfproducts.SPACE_HEATER_LOW_TEMPERATURE_COLDER_EFFICIENCY';

    /**
     * the column name for the SPACE_HEATER_LOW_TEMPERATURE_WARMER_EFFICIENCY field
     */
    const SPACE_HEATER_LOW_TEMPERATURE_WARMER_EFFICIENCY = 'hfproducts.SPACE_HEATER_LOW_TEMPERATURE_WARMER_EFFICIENCY';

    /**
     * the column name for the SPACE_HEATER_LOW_TEMPERATURE_SUPPLEMENTARY_POWER field
     */
    const SPACE_HEATER_LOW_TEMPERATURE_SUPPLEMENTARY_POWER = 'hfproducts.SPACE_HEATER_LOW_TEMPERATURE_SUPPLEMENTARY_POWER';

    /**
     * the column name for the SPACE_HEATER_LOW_TEMPERATURE_POWER field
     */
    const SPACE_HEATER_LOW_TEMPERATURE_POWER = 'hfproducts.SPACE_HEATER_LOW_TEMPERATURE_POWER';

    /**
     * the column name for the SOLAR_EFFICIENCY field
     */
    const SOLAR_EFFICIENCY = 'hfproducts.SOLAR_EFFICIENCY';

    /**
     * the column name for the SOLAR_SIZE field
     */
    const SOLAR_SIZE = 'hfproducts.SOLAR_SIZE';

    /**
     * the column name for the SOLAR_PUMP_POWER field
     */
    const SOLAR_PUMP_POWER = 'hfproducts.SOLAR_PUMP_POWER';

    /**
     * the column name for the STORAGE_TYPE field
     */
    const STORAGE_TYPE = 'hfproducts.STORAGE_TYPE';

    /**
     * the column name for the STORAGE_VOLUME field
     */
    const STORAGE_VOLUME = 'hfproducts.STORAGE_VOLUME';

    /**
     * the column name for the STORAGE_NON_SOLAR_VOLUME field
     */
    const STORAGE_NON_SOLAR_VOLUME = 'hfproducts.STORAGE_NON_SOLAR_VOLUME';

    /**
     * the column name for the STORAGE_WARMTH_LOSS field
     */
    const STORAGE_WARMTH_LOSS = 'hfproducts.STORAGE_WARMTH_LOSS';

    /**
     * the column name for the COMBINATION_HEATER_SPACE_HEATER_GRADE field
     */
    const COMBINATION_HEATER_SPACE_HEATER_GRADE = 'hfproducts.COMBINATION_HEATER_SPACE_HEATER_GRADE';

    /**
     * the column name for the COMBINATION_HEATER_WATER_HEATER_GRADE field
     */
    const COMBINATION_HEATER_WATER_HEATER_GRADE = 'hfproducts.COMBINATION_HEATER_WATER_HEATER_GRADE';

    /**
     * the column name for the COMBINED_EFFICIENCY field
     */
    const COMBINED_EFFICIENCY = 'hfproducts.COMBINED_EFFICIENCY';

    /**
     * the column name for the COMBINED_MAIN_HEATER_TYPE_ID field
     */
    const COMBINED_MAIN_HEATER_TYPE_ID = 'hfproducts.COMBINED_MAIN_HEATER_TYPE_ID';

    /**
     * the column name for the TEMPERATURE_CONTROL_STANDBY_WARMTH_LOSS field
     */
    const TEMPERATURE_CONTROL_STANDBY_WARMTH_LOSS = 'hfproducts.TEMPERATURE_CONTROL_STANDBY_WARMTH_LOSS';

    /**
     * the column name for the TEMPERATURE_CONTROL_TYPE field
     */
    const TEMPERATURE_CONTROL_TYPE = 'hfproducts.TEMPERATURE_CONTROL_TYPE';

    /**
     * the column name for the SUPPLEMENTARY_POWER field
     */
    const SUPPLEMENTARY_POWER = 'hfproducts.SUPPLEMENTARY_POWER';

    /**
     * the column name for the MONTAGE_ID field
     */
    const MONTAGE_ID = 'hfproducts.MONTAGE_ID';

    /**
     * the column name for the PRICE field
     */
    const PRICE = 'hfproducts.PRICE';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('Id', 'VendorId', 'Name', 'OagName', 'TypeId', 'ProductNumber', 'Grade', 'BuildYearFrom', 'BuildYearTo', 'Createdat', 'Updatedat', 'ShtProduct', 'ShtId', 'ShtCategory', 'ShtText1', 'ShtText2', 'OagProduct', 'OagId', 'OagCategory', 'OagText1', 'OagText2', 'MegabildId', 'Image', 'SpecificationName', 'LabelName', 'WaterHeaterEnergyClass', 'WaterHeaterEnergyEfficiency', 'WaterHeaterEnergyGrade', 'SpaceHeaterEfficiency', 'SpaceHeaterPower', 'SpaceHeaterType', 'SpaceHeaterLowTemperatureHeatPump', 'SpaceHeaterColderEfficiency', 'SpaceHeaterWarmerEfficiency', 'SpaceHeaterLowTemperatureGrade', 'SpaceHeaterLowTemperatureEfficiency', 'SpaceHeaterLowTemperatureColderEfficiency', 'SpaceHeaterLowTemperatureWarmerEfficiency', 'SpaceHeaterLowTemperatureSupplementaryPower', 'SpaceHeaterLowTemperaturePower', 'SolarEfficiency', 'SolarSize', 'SolarPumpPower', 'StorageType', 'StorageVolume', 'StorageNonSolarVolume', 'StorageWarmthLoss', 'CombinationHeaterSpaceHeaterGrade', 'CombinationHeaterWaterHeaterGrade', 'CombinedEfficiency', 'CombinedMainHeaterTypeId', 'TemperatureControlStandbyWarmthLoss', 'TemperatureControlType', 'SupplementaryPower', 'MontageId', 'Price', ),
        self::TYPE_STUDLYPHPNAME => array('id', 'vendorId', 'name', 'oagName', 'typeId', 'productNumber', 'grade', 'buildYearFrom', 'buildYearTo', 'createdat', 'updatedat', 'shtProduct', 'shtId', 'shtCategory', 'shtText1', 'shtText2', 'oagProduct', 'oagId', 'oagCategory', 'oagText1', 'oagText2', 'megabildId', 'image', 'specificationName', 'labelName', 'waterHeaterEnergyClass', 'waterHeaterEnergyEfficiency', 'waterHeaterEnergyGrade', 'spaceHeaterEfficiency', 'spaceHeaterPower', 'spaceHeaterType', 'spaceHeaterLowTemperatureHeatPump', 'spaceHeaterColderEfficiency', 'spaceHeaterWarmerEfficiency', 'spaceHeaterLowTemperatureGrade', 'spaceHeaterLowTemperatureEfficiency', 'spaceHeaterLowTemperatureColderEfficiency', 'spaceHeaterLowTemperatureWarmerEfficiency', 'spaceHeaterLowTemperatureSupplementaryPower', 'spaceHeaterLowTemperaturePower', 'solarEfficiency', 'solarSize', 'solarPumpPower', 'storageType', 'storageVolume', 'storageNonSolarVolume', 'storageWarmthLoss', 'combinationHeaterSpaceHeaterGrade', 'combinationHeaterWaterHeaterGrade', 'combinedEfficiency', 'combinedMainHeaterTypeId', 'temperatureControlStandbyWarmthLoss', 'temperatureControlType', 'supplementaryPower', 'montageId', 'price', ),
        self::TYPE_COLNAME       => array(HfproductsTableMap::ID, HfproductsTableMap::VENDOR_ID, HfproductsTableMap::NAME, HfproductsTableMap::OAG_NAME, HfproductsTableMap::TYPE_ID, HfproductsTableMap::PRODUCT_NUMBER, HfproductsTableMap::GRADE, HfproductsTableMap::BUILD_YEAR_FROM, HfproductsTableMap::BUILD_YEAR_TO, HfproductsTableMap::CREATEDAT, HfproductsTableMap::UPDATEDAT, HfproductsTableMap::SHT_PRODUCT, HfproductsTableMap::SHT_ID, HfproductsTableMap::SHT_CATEGORY, HfproductsTableMap::SHT_TEXT1, HfproductsTableMap::SHT_TEXT2, HfproductsTableMap::OAG_PRODUCT, HfproductsTableMap::OAG_ID, HfproductsTableMap::OAG_CATEGORY, HfproductsTableMap::OAG_TEXT1, HfproductsTableMap::OAG_TEXT2, HfproductsTableMap::MEGABILD_ID, HfproductsTableMap::IMAGE, HfproductsTableMap::SPECIFICATION_NAME, HfproductsTableMap::LABEL_NAME, HfproductsTableMap::WATER_HEATER_ENERGY_CLASS, HfproductsTableMap::WATER_HEATER_ENERGY_EFFICIENCY, HfproductsTableMap::WATER_HEATER_ENERGY_GRADE, HfproductsTableMap::SPACE_HEATER_EFFICIENCY, HfproductsTableMap::SPACE_HEATER_POWER, HfproductsTableMap::SPACE_HEATER_TYPE, HfproductsTableMap::SPACE_HEATER_LOW_TEMPERATURE_HEAT_PUMP, HfproductsTableMap::SPACE_HEATER_COLDER_EFFICIENCY, HfproductsTableMap::SPACE_HEATER_WARMER_EFFICIENCY, HfproductsTableMap::SPACE_HEATER_LOW_TEMPERATURE_GRADE, HfproductsTableMap::SPACE_HEATER_LOW_TEMPERATURE_EFFICIENCY, HfproductsTableMap::SPACE_HEATER_LOW_TEMPERATURE_COLDER_EFFICIENCY, HfproductsTableMap::SPACE_HEATER_LOW_TEMPERATURE_WARMER_EFFICIENCY, HfproductsTableMap::SPACE_HEATER_LOW_TEMPERATURE_SUPPLEMENTARY_POWER, HfproductsTableMap::SPACE_HEATER_LOW_TEMPERATURE_POWER, HfproductsTableMap::SOLAR_EFFICIENCY, HfproductsTableMap::SOLAR_SIZE, HfproductsTableMap::SOLAR_PUMP_POWER, HfproductsTableMap::STORAGE_TYPE, HfproductsTableMap::STORAGE_VOLUME, HfproductsTableMap::STORAGE_NON_SOLAR_VOLUME, HfproductsTableMap::STORAGE_WARMTH_LOSS, HfproductsTableMap::COMBINATION_HEATER_SPACE_HEATER_GRADE, HfproductsTableMap::COMBINATION_HEATER_WATER_HEATER_GRADE, HfproductsTableMap::COMBINED_EFFICIENCY, HfproductsTableMap::COMBINED_MAIN_HEATER_TYPE_ID, HfproductsTableMap::TEMPERATURE_CONTROL_STANDBY_WARMTH_LOSS, HfproductsTableMap::TEMPERATURE_CONTROL_TYPE, HfproductsTableMap::SUPPLEMENTARY_POWER, HfproductsTableMap::MONTAGE_ID, HfproductsTableMap::PRICE, ),
        self::TYPE_RAW_COLNAME   => array('ID', 'VENDOR_ID', 'NAME', 'OAG_NAME', 'TYPE_ID', 'PRODUCT_NUMBER', 'GRADE', 'BUILD_YEAR_FROM', 'BUILD_YEAR_TO', 'CREATEDAT', 'UPDATEDAT', 'SHT_PRODUCT', 'SHT_ID', 'SHT_CATEGORY', 'SHT_TEXT1', 'SHT_TEXT2', 'OAG_PRODUCT', 'OAG_ID', 'OAG_CATEGORY', 'OAG_TEXT1', 'OAG_TEXT2', 'MEGABILD_ID', 'IMAGE', 'SPECIFICATION_NAME', 'LABEL_NAME', 'WATER_HEATER_ENERGY_CLASS', 'WATER_HEATER_ENERGY_EFFICIENCY', 'WATER_HEATER_ENERGY_GRADE', 'SPACE_HEATER_EFFICIENCY', 'SPACE_HEATER_POWER', 'SPACE_HEATER_TYPE', 'SPACE_HEATER_LOW_TEMPERATURE_HEAT_PUMP', 'SPACE_HEATER_COLDER_EFFICIENCY', 'SPACE_HEATER_WARMER_EFFICIENCY', 'SPACE_HEATER_LOW_TEMPERATURE_GRADE', 'SPACE_HEATER_LOW_TEMPERATURE_EFFICIENCY', 'SPACE_HEATER_LOW_TEMPERATURE_COLDER_EFFICIENCY', 'SPACE_HEATER_LOW_TEMPERATURE_WARMER_EFFICIENCY', 'SPACE_HEATER_LOW_TEMPERATURE_SUPPLEMENTARY_POWER', 'SPACE_HEATER_LOW_TEMPERATURE_POWER', 'SOLAR_EFFICIENCY', 'SOLAR_SIZE', 'SOLAR_PUMP_POWER', 'STORAGE_TYPE', 'STORAGE_VOLUME', 'STORAGE_NON_SOLAR_VOLUME', 'STORAGE_WARMTH_LOSS', 'COMBINATION_HEATER_SPACE_HEATER_GRADE', 'COMBINATION_HEATER_WATER_HEATER_GRADE', 'COMBINED_EFFICIENCY', 'COMBINED_MAIN_HEATER_TYPE_ID', 'TEMPERATURE_CONTROL_STANDBY_WARMTH_LOSS', 'TEMPERATURE_CONTROL_TYPE', 'SUPPLEMENTARY_POWER', 'MONTAGE_ID', 'PRICE', ),
        self::TYPE_FIELDNAME     => array('id', 'vendor_id', 'name', 'oag_name', 'type_id', 'product_number', 'grade', 'build_year_from', 'build_year_to', 'createdAt', 'updatedAt', 'sht_product', 'sht_id', 'sht_category', 'sht_text1', 'sht_text2', 'oag_product', 'oag_id', 'oag_category', 'oag_text1', 'oag_text2', 'megabild_id', 'image', 'specification_name', 'label_name', 'water_heater_energy_class', 'water_heater_energy_efficiency', 'water_heater_energy_grade', 'space_heater_efficiency', 'space_heater_power', 'space_heater_type', 'space_heater_low_temperature_heat_pump', 'space_heater_colder_efficiency', 'space_heater_warmer_efficiency', 'space_heater_low_temperature_grade', 'space_heater_low_temperature_efficiency', 'space_heater_low_temperature_colder_efficiency', 'space_heater_low_temperature_warmer_efficiency', 'space_heater_low_temperature_supplementary_power', 'space_heater_low_temperature_power', 'solar_efficiency', 'solar_size', 'solar_pump_power', 'storage_type', 'storage_volume', 'storage_non_solar_volume', 'storage_warmth_loss', 'combination_heater_space_heater_grade', 'combination_heater_water_heater_grade', 'combined_efficiency', 'combined_main_heater_type_id', 'temperature_control_standby_warmth_loss', 'temperature_control_type', 'supplementary_power', 'montage_id', 'price', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'VendorId' => 1, 'Name' => 2, 'OagName' => 3, 'TypeId' => 4, 'ProductNumber' => 5, 'Grade' => 6, 'BuildYearFrom' => 7, 'BuildYearTo' => 8, 'Createdat' => 9, 'Updatedat' => 10, 'ShtProduct' => 11, 'ShtId' => 12, 'ShtCategory' => 13, 'ShtText1' => 14, 'ShtText2' => 15, 'OagProduct' => 16, 'OagId' => 17, 'OagCategory' => 18, 'OagText1' => 19, 'OagText2' => 20, 'MegabildId' => 21, 'Image' => 22, 'SpecificationName' => 23, 'LabelName' => 24, 'WaterHeaterEnergyClass' => 25, 'WaterHeaterEnergyEfficiency' => 26, 'WaterHeaterEnergyGrade' => 27, 'SpaceHeaterEfficiency' => 28, 'SpaceHeaterPower' => 29, 'SpaceHeaterType' => 30, 'SpaceHeaterLowTemperatureHeatPump' => 31, 'SpaceHeaterColderEfficiency' => 32, 'SpaceHeaterWarmerEfficiency' => 33, 'SpaceHeaterLowTemperatureGrade' => 34, 'SpaceHeaterLowTemperatureEfficiency' => 35, 'SpaceHeaterLowTemperatureColderEfficiency' => 36, 'SpaceHeaterLowTemperatureWarmerEfficiency' => 37, 'SpaceHeaterLowTemperatureSupplementaryPower' => 38, 'SpaceHeaterLowTemperaturePower' => 39, 'SolarEfficiency' => 40, 'SolarSize' => 41, 'SolarPumpPower' => 42, 'StorageType' => 43, 'StorageVolume' => 44, 'StorageNonSolarVolume' => 45, 'StorageWarmthLoss' => 46, 'CombinationHeaterSpaceHeaterGrade' => 47, 'CombinationHeaterWaterHeaterGrade' => 48, 'CombinedEfficiency' => 49, 'CombinedMainHeaterTypeId' => 50, 'TemperatureControlStandbyWarmthLoss' => 51, 'TemperatureControlType' => 52, 'SupplementaryPower' => 53, 'MontageId' => 54, 'Price' => 55, ),
        self::TYPE_STUDLYPHPNAME => array('id' => 0, 'vendorId' => 1, 'name' => 2, 'oagName' => 3, 'typeId' => 4, 'productNumber' => 5, 'grade' => 6, 'buildYearFrom' => 7, 'buildYearTo' => 8, 'createdat' => 9, 'updatedat' => 10, 'shtProduct' => 11, 'shtId' => 12, 'shtCategory' => 13, 'shtText1' => 14, 'shtText2' => 15, 'oagProduct' => 16, 'oagId' => 17, 'oagCategory' => 18, 'oagText1' => 19, 'oagText2' => 20, 'megabildId' => 21, 'image' => 22, 'specificationName' => 23, 'labelName' => 24, 'waterHeaterEnergyClass' => 25, 'waterHeaterEnergyEfficiency' => 26, 'waterHeaterEnergyGrade' => 27, 'spaceHeaterEfficiency' => 28, 'spaceHeaterPower' => 29, 'spaceHeaterType' => 30, 'spaceHeaterLowTemperatureHeatPump' => 31, 'spaceHeaterColderEfficiency' => 32, 'spaceHeaterWarmerEfficiency' => 33, 'spaceHeaterLowTemperatureGrade' => 34, 'spaceHeaterLowTemperatureEfficiency' => 35, 'spaceHeaterLowTemperatureColderEfficiency' => 36, 'spaceHeaterLowTemperatureWarmerEfficiency' => 37, 'spaceHeaterLowTemperatureSupplementaryPower' => 38, 'spaceHeaterLowTemperaturePower' => 39, 'solarEfficiency' => 40, 'solarSize' => 41, 'solarPumpPower' => 42, 'storageType' => 43, 'storageVolume' => 44, 'storageNonSolarVolume' => 45, 'storageWarmthLoss' => 46, 'combinationHeaterSpaceHeaterGrade' => 47, 'combinationHeaterWaterHeaterGrade' => 48, 'combinedEfficiency' => 49, 'combinedMainHeaterTypeId' => 50, 'temperatureControlStandbyWarmthLoss' => 51, 'temperatureControlType' => 52, 'supplementaryPower' => 53, 'montageId' => 54, 'price' => 55, ),
        self::TYPE_COLNAME       => array(HfproductsTableMap::ID => 0, HfproductsTableMap::VENDOR_ID => 1, HfproductsTableMap::NAME => 2, HfproductsTableMap::OAG_NAME => 3, HfproductsTableMap::TYPE_ID => 4, HfproductsTableMap::PRODUCT_NUMBER => 5, HfproductsTableMap::GRADE => 6, HfproductsTableMap::BUILD_YEAR_FROM => 7, HfproductsTableMap::BUILD_YEAR_TO => 8, HfproductsTableMap::CREATEDAT => 9, HfproductsTableMap::UPDATEDAT => 10, HfproductsTableMap::SHT_PRODUCT => 11, HfproductsTableMap::SHT_ID => 12, HfproductsTableMap::SHT_CATEGORY => 13, HfproductsTableMap::SHT_TEXT1 => 14, HfproductsTableMap::SHT_TEXT2 => 15, HfproductsTableMap::OAG_PRODUCT => 16, HfproductsTableMap::OAG_ID => 17, HfproductsTableMap::OAG_CATEGORY => 18, HfproductsTableMap::OAG_TEXT1 => 19, HfproductsTableMap::OAG_TEXT2 => 20, HfproductsTableMap::MEGABILD_ID => 21, HfproductsTableMap::IMAGE => 22, HfproductsTableMap::SPECIFICATION_NAME => 23, HfproductsTableMap::LABEL_NAME => 24, HfproductsTableMap::WATER_HEATER_ENERGY_CLASS => 25, HfproductsTableMap::WATER_HEATER_ENERGY_EFFICIENCY => 26, HfproductsTableMap::WATER_HEATER_ENERGY_GRADE => 27, HfproductsTableMap::SPACE_HEATER_EFFICIENCY => 28, HfproductsTableMap::SPACE_HEATER_POWER => 29, HfproductsTableMap::SPACE_HEATER_TYPE => 30, HfproductsTableMap::SPACE_HEATER_LOW_TEMPERATURE_HEAT_PUMP => 31, HfproductsTableMap::SPACE_HEATER_COLDER_EFFICIENCY => 32, HfproductsTableMap::SPACE_HEATER_WARMER_EFFICIENCY => 33, HfproductsTableMap::SPACE_HEATER_LOW_TEMPERATURE_GRADE => 34, HfproductsTableMap::SPACE_HEATER_LOW_TEMPERATURE_EFFICIENCY => 35, HfproductsTableMap::SPACE_HEATER_LOW_TEMPERATURE_COLDER_EFFICIENCY => 36, HfproductsTableMap::SPACE_HEATER_LOW_TEMPERATURE_WARMER_EFFICIENCY => 37, HfproductsTableMap::SPACE_HEATER_LOW_TEMPERATURE_SUPPLEMENTARY_POWER => 38, HfproductsTableMap::SPACE_HEATER_LOW_TEMPERATURE_POWER => 39, HfproductsTableMap::SOLAR_EFFICIENCY => 40, HfproductsTableMap::SOLAR_SIZE => 41, HfproductsTableMap::SOLAR_PUMP_POWER => 42, HfproductsTableMap::STORAGE_TYPE => 43, HfproductsTableMap::STORAGE_VOLUME => 44, HfproductsTableMap::STORAGE_NON_SOLAR_VOLUME => 45, HfproductsTableMap::STORAGE_WARMTH_LOSS => 46, HfproductsTableMap::COMBINATION_HEATER_SPACE_HEATER_GRADE => 47, HfproductsTableMap::COMBINATION_HEATER_WATER_HEATER_GRADE => 48, HfproductsTableMap::COMBINED_EFFICIENCY => 49, HfproductsTableMap::COMBINED_MAIN_HEATER_TYPE_ID => 50, HfproductsTableMap::TEMPERATURE_CONTROL_STANDBY_WARMTH_LOSS => 51, HfproductsTableMap::TEMPERATURE_CONTROL_TYPE => 52, HfproductsTableMap::SUPPLEMENTARY_POWER => 53, HfproductsTableMap::MONTAGE_ID => 54, HfproductsTableMap::PRICE => 55, ),
        self::TYPE_RAW_COLNAME   => array('ID' => 0, 'VENDOR_ID' => 1, 'NAME' => 2, 'OAG_NAME' => 3, 'TYPE_ID' => 4, 'PRODUCT_NUMBER' => 5, 'GRADE' => 6, 'BUILD_YEAR_FROM' => 7, 'BUILD_YEAR_TO' => 8, 'CREATEDAT' => 9, 'UPDATEDAT' => 10, 'SHT_PRODUCT' => 11, 'SHT_ID' => 12, 'SHT_CATEGORY' => 13, 'SHT_TEXT1' => 14, 'SHT_TEXT2' => 15, 'OAG_PRODUCT' => 16, 'OAG_ID' => 17, 'OAG_CATEGORY' => 18, 'OAG_TEXT1' => 19, 'OAG_TEXT2' => 20, 'MEGABILD_ID' => 21, 'IMAGE' => 22, 'SPECIFICATION_NAME' => 23, 'LABEL_NAME' => 24, 'WATER_HEATER_ENERGY_CLASS' => 25, 'WATER_HEATER_ENERGY_EFFICIENCY' => 26, 'WATER_HEATER_ENERGY_GRADE' => 27, 'SPACE_HEATER_EFFICIENCY' => 28, 'SPACE_HEATER_POWER' => 29, 'SPACE_HEATER_TYPE' => 30, 'SPACE_HEATER_LOW_TEMPERATURE_HEAT_PUMP' => 31, 'SPACE_HEATER_COLDER_EFFICIENCY' => 32, 'SPACE_HEATER_WARMER_EFFICIENCY' => 33, 'SPACE_HEATER_LOW_TEMPERATURE_GRADE' => 34, 'SPACE_HEATER_LOW_TEMPERATURE_EFFICIENCY' => 35, 'SPACE_HEATER_LOW_TEMPERATURE_COLDER_EFFICIENCY' => 36, 'SPACE_HEATER_LOW_TEMPERATURE_WARMER_EFFICIENCY' => 37, 'SPACE_HEATER_LOW_TEMPERATURE_SUPPLEMENTARY_POWER' => 38, 'SPACE_HEATER_LOW_TEMPERATURE_POWER' => 39, 'SOLAR_EFFICIENCY' => 40, 'SOLAR_SIZE' => 41, 'SOLAR_PUMP_POWER' => 42, 'STORAGE_TYPE' => 43, 'STORAGE_VOLUME' => 44, 'STORAGE_NON_SOLAR_VOLUME' => 45, 'STORAGE_WARMTH_LOSS' => 46, 'COMBINATION_HEATER_SPACE_HEATER_GRADE' => 47, 'COMBINATION_HEATER_WATER_HEATER_GRADE' => 48, 'COMBINED_EFFICIENCY' => 49, 'COMBINED_MAIN_HEATER_TYPE_ID' => 50, 'TEMPERATURE_CONTROL_STANDBY_WARMTH_LOSS' => 51, 'TEMPERATURE_CONTROL_TYPE' => 52, 'SUPPLEMENTARY_POWER' => 53, 'MONTAGE_ID' => 54, 'PRICE' => 55, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'vendor_id' => 1, 'name' => 2, 'oag_name' => 3, 'type_id' => 4, 'product_number' => 5, 'grade' => 6, 'build_year_from' => 7, 'build_year_to' => 8, 'createdAt' => 9, 'updatedAt' => 10, 'sht_product' => 11, 'sht_id' => 12, 'sht_category' => 13, 'sht_text1' => 14, 'sht_text2' => 15, 'oag_product' => 16, 'oag_id' => 17, 'oag_category' => 18, 'oag_text1' => 19, 'oag_text2' => 20, 'megabild_id' => 21, 'image' => 22, 'specification_name' => 23, 'label_name' => 24, 'water_heater_energy_class' => 25, 'water_heater_energy_efficiency' => 26, 'water_heater_energy_grade' => 27, 'space_heater_efficiency' => 28, 'space_heater_power' => 29, 'space_heater_type' => 30, 'space_heater_low_temperature_heat_pump' => 31, 'space_heater_colder_efficiency' => 32, 'space_heater_warmer_efficiency' => 33, 'space_heater_low_temperature_grade' => 34, 'space_heater_low_temperature_efficiency' => 35, 'space_heater_low_temperature_colder_efficiency' => 36, 'space_heater_low_temperature_warmer_efficiency' => 37, 'space_heater_low_temperature_supplementary_power' => 38, 'space_heater_low_temperature_power' => 39, 'solar_efficiency' => 40, 'solar_size' => 41, 'solar_pump_power' => 42, 'storage_type' => 43, 'storage_volume' => 44, 'storage_non_solar_volume' => 45, 'storage_warmth_loss' => 46, 'combination_heater_space_heater_grade' => 47, 'combination_heater_water_heater_grade' => 48, 'combined_efficiency' => 49, 'combined_main_heater_type_id' => 50, 'temperature_control_standby_warmth_loss' => 51, 'temperature_control_type' => 52, 'supplementary_power' => 53, 'montage_id' => 54, 'price' => 55, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, )
    );

    /**
     * Initialize the table attributes and columns
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('hfproducts');
        $this->setPhpName('Hfproducts');
        $this->setClassName('\\HookKonfigurator\\Model\\Hfproducts');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('VENDOR_ID', 'VendorId', 'INTEGER', true, null, null);
        $this->addColumn('NAME', 'Name', 'VARCHAR', true, 255, null);
        $this->addColumn('OAG_NAME', 'OagName', 'VARCHAR', false, 255, null);
        $this->addColumn('TYPE_ID', 'TypeId', 'INTEGER', false, null, null);
        $this->addColumn('PRODUCT_NUMBER', 'ProductNumber', 'VARCHAR', false, 255, null);
        $this->addColumn('GRADE', 'Grade', 'VARCHAR', false, 255, null);
        $this->addColumn('BUILD_YEAR_FROM', 'BuildYearFrom', 'INTEGER', false, null, null);
        $this->addColumn('BUILD_YEAR_TO', 'BuildYearTo', 'INTEGER', false, null, null);
        $this->addColumn('CREATEDAT', 'Createdat', 'TIMESTAMP', true, null, null);
        $this->addColumn('UPDATEDAT', 'Updatedat', 'TIMESTAMP', true, null, null);
        $this->addColumn('SHT_PRODUCT', 'ShtProduct', 'BOOLEAN', true, 1, false);
        $this->addColumn('SHT_ID', 'ShtId', 'VARCHAR', false, 255, null);
        $this->addColumn('SHT_CATEGORY', 'ShtCategory', 'INTEGER', false, null, null);
        $this->addColumn('SHT_TEXT1', 'ShtText1', 'VARCHAR', false, 255, null);
        $this->addColumn('SHT_TEXT2', 'ShtText2', 'VARCHAR', false, 255, null);
        $this->addColumn('OAG_PRODUCT', 'OagProduct', 'BOOLEAN', true, 1, false);
        $this->addColumn('OAG_ID', 'OagId', 'VARCHAR', false, 255, null);
        $this->addColumn('OAG_CATEGORY', 'OagCategory', 'INTEGER', false, null, null);
        $this->addColumn('OAG_TEXT1', 'OagText1', 'VARCHAR', false, 255, null);
        $this->addColumn('OAG_TEXT2', 'OagText2', 'VARCHAR', false, 255, null);
        $this->addColumn('MEGABILD_ID', 'MegabildId', 'INTEGER', false, null, null);
        $this->addColumn('IMAGE', 'Image', 'VARCHAR', false, 255, null);
        $this->addColumn('SPECIFICATION_NAME', 'SpecificationName', 'VARCHAR', false, 255, null);
        $this->addColumn('LABEL_NAME', 'LabelName', 'VARCHAR', false, 255, null);
        $this->addColumn('WATER_HEATER_ENERGY_CLASS', 'WaterHeaterEnergyClass', 'VARCHAR', false, 255, null);
        $this->addColumn('WATER_HEATER_ENERGY_EFFICIENCY', 'WaterHeaterEnergyEfficiency', 'INTEGER', false, null, null);
        $this->addColumn('WATER_HEATER_ENERGY_GRADE', 'WaterHeaterEnergyGrade', 'VARCHAR', false, 255, null);
        $this->addColumn('SPACE_HEATER_EFFICIENCY', 'SpaceHeaterEfficiency', 'INTEGER', false, null, null);
        $this->addColumn('SPACE_HEATER_POWER', 'SpaceHeaterPower', 'INTEGER', false, null, null);
        $this->addColumn('SPACE_HEATER_TYPE', 'SpaceHeaterType', 'VARCHAR', false, 255, null);
        $this->addColumn('SPACE_HEATER_LOW_TEMPERATURE_HEAT_PUMP', 'SpaceHeaterLowTemperatureHeatPump', 'BOOLEAN', false, 1, null);
        $this->addColumn('SPACE_HEATER_COLDER_EFFICIENCY', 'SpaceHeaterColderEfficiency', 'INTEGER', false, null, null);
        $this->addColumn('SPACE_HEATER_WARMER_EFFICIENCY', 'SpaceHeaterWarmerEfficiency', 'INTEGER', false, null, null);
        $this->addColumn('SPACE_HEATER_LOW_TEMPERATURE_GRADE', 'SpaceHeaterLowTemperatureGrade', 'VARCHAR', false, 255, null);
        $this->addColumn('SPACE_HEATER_LOW_TEMPERATURE_EFFICIENCY', 'SpaceHeaterLowTemperatureEfficiency', 'INTEGER', false, null, null);
        $this->addColumn('SPACE_HEATER_LOW_TEMPERATURE_COLDER_EFFICIENCY', 'SpaceHeaterLowTemperatureColderEfficiency', 'INTEGER', false, null, null);
        $this->addColumn('SPACE_HEATER_LOW_TEMPERATURE_WARMER_EFFICIENCY', 'SpaceHeaterLowTemperatureWarmerEfficiency', 'INTEGER', false, null, null);
        $this->addColumn('SPACE_HEATER_LOW_TEMPERATURE_SUPPLEMENTARY_POWER', 'SpaceHeaterLowTemperatureSupplementaryPower', 'INTEGER', false, null, null);
        $this->addColumn('SPACE_HEATER_LOW_TEMPERATURE_POWER', 'SpaceHeaterLowTemperaturePower', 'INTEGER', false, null, null);
        $this->addColumn('SOLAR_EFFICIENCY', 'SolarEfficiency', 'DECIMAL', false, 4, null);
        $this->addColumn('SOLAR_SIZE', 'SolarSize', 'DECIMAL', false, 5, null);
        $this->addColumn('SOLAR_PUMP_POWER', 'SolarPumpPower', 'INTEGER', false, null, null);
        $this->addColumn('STORAGE_TYPE', 'StorageType', 'VARCHAR', false, 255, null);
        $this->addColumn('STORAGE_VOLUME', 'StorageVolume', 'DECIMAL', false, 6, null);
        $this->addColumn('STORAGE_NON_SOLAR_VOLUME', 'StorageNonSolarVolume', 'DECIMAL', false, 5, null);
        $this->addColumn('STORAGE_WARMTH_LOSS', 'StorageWarmthLoss', 'INTEGER', false, null, null);
        $this->addColumn('COMBINATION_HEATER_SPACE_HEATER_GRADE', 'CombinationHeaterSpaceHeaterGrade', 'VARCHAR', false, 255, null);
        $this->addColumn('COMBINATION_HEATER_WATER_HEATER_GRADE', 'CombinationHeaterWaterHeaterGrade', 'VARCHAR', false, 255, null);
        $this->addColumn('COMBINED_EFFICIENCY', 'CombinedEfficiency', 'INTEGER', false, null, null);
        $this->addColumn('COMBINED_MAIN_HEATER_TYPE_ID', 'CombinedMainHeaterTypeId', 'INTEGER', false, null, null);
        $this->addColumn('TEMPERATURE_CONTROL_STANDBY_WARMTH_LOSS', 'TemperatureControlStandbyWarmthLoss', 'DECIMAL', false, 5, null);
        $this->addColumn('TEMPERATURE_CONTROL_TYPE', 'TemperatureControlType', 'VARCHAR', false, 255, null);
        $this->addColumn('SUPPLEMENTARY_POWER', 'SupplementaryPower', 'INTEGER', false, null, null);
        $this->addColumn('MONTAGE_ID', 'MontageId', 'INTEGER', false, null, null);
        $this->addColumn('PRICE', 'Price', 'DECIMAL', false, 6, 0);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
    } // buildRelations()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     */
    public static function getPrimaryKeyHashFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        // If the PK cannot be derived from the row, return NULL.
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {

            return (int) $row[
                            $indexType == TableMap::TYPE_NUM
                            ? 0 + $offset
                            : self::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)
                        ];
    }

    /**
     * The class that the tableMap will make instances of.
     *
     * If $withPrefix is true, the returned path
     * uses a dot-path notation which is translated into a path
     * relative to a location on the PHP include_path.
     * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
     *
     * @param boolean $withPrefix Whether or not to return the path with the class name
     * @return string path.to.ClassName
     */
    public static function getOMClass($withPrefix = true)
    {
        return $withPrefix ? HfproductsTableMap::CLASS_DEFAULT : HfproductsTableMap::OM_CLASS;
    }

    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param array  $row       row returned by DataFetcher->fetch().
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                 One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     * @return array (Hfproducts object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = HfproductsTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = HfproductsTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + HfproductsTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = HfproductsTableMap::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            HfproductsTableMap::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @param DataFetcherInterface $dataFetcher
     * @return array
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function populateObjects(DataFetcherInterface $dataFetcher)
    {
        $results = array();

        // set the class once to avoid overhead in the loop
        $cls = static::getOMClass(false);
        // populate the object(s)
        while ($row = $dataFetcher->fetch()) {
            $key = HfproductsTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = HfproductsTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                HfproductsTableMap::addInstanceToPool($obj, $key);
            } // if key exists
        }

        return $results;
    }
    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param Criteria $criteria object containing the columns to add.
     * @param string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(HfproductsTableMap::ID);
            $criteria->addSelectColumn(HfproductsTableMap::VENDOR_ID);
            $criteria->addSelectColumn(HfproductsTableMap::NAME);
            $criteria->addSelectColumn(HfproductsTableMap::OAG_NAME);
            $criteria->addSelectColumn(HfproductsTableMap::TYPE_ID);
            $criteria->addSelectColumn(HfproductsTableMap::PRODUCT_NUMBER);
            $criteria->addSelectColumn(HfproductsTableMap::GRADE);
            $criteria->addSelectColumn(HfproductsTableMap::BUILD_YEAR_FROM);
            $criteria->addSelectColumn(HfproductsTableMap::BUILD_YEAR_TO);
            $criteria->addSelectColumn(HfproductsTableMap::CREATEDAT);
            $criteria->addSelectColumn(HfproductsTableMap::UPDATEDAT);
            $criteria->addSelectColumn(HfproductsTableMap::SHT_PRODUCT);
            $criteria->addSelectColumn(HfproductsTableMap::SHT_ID);
            $criteria->addSelectColumn(HfproductsTableMap::SHT_CATEGORY);
            $criteria->addSelectColumn(HfproductsTableMap::SHT_TEXT1);
            $criteria->addSelectColumn(HfproductsTableMap::SHT_TEXT2);
            $criteria->addSelectColumn(HfproductsTableMap::OAG_PRODUCT);
            $criteria->addSelectColumn(HfproductsTableMap::OAG_ID);
            $criteria->addSelectColumn(HfproductsTableMap::OAG_CATEGORY);
            $criteria->addSelectColumn(HfproductsTableMap::OAG_TEXT1);
            $criteria->addSelectColumn(HfproductsTableMap::OAG_TEXT2);
            $criteria->addSelectColumn(HfproductsTableMap::MEGABILD_ID);
            $criteria->addSelectColumn(HfproductsTableMap::IMAGE);
            $criteria->addSelectColumn(HfproductsTableMap::SPECIFICATION_NAME);
            $criteria->addSelectColumn(HfproductsTableMap::LABEL_NAME);
            $criteria->addSelectColumn(HfproductsTableMap::WATER_HEATER_ENERGY_CLASS);
            $criteria->addSelectColumn(HfproductsTableMap::WATER_HEATER_ENERGY_EFFICIENCY);
            $criteria->addSelectColumn(HfproductsTableMap::WATER_HEATER_ENERGY_GRADE);
            $criteria->addSelectColumn(HfproductsTableMap::SPACE_HEATER_EFFICIENCY);
            $criteria->addSelectColumn(HfproductsTableMap::SPACE_HEATER_POWER);
            $criteria->addSelectColumn(HfproductsTableMap::SPACE_HEATER_TYPE);
            $criteria->addSelectColumn(HfproductsTableMap::SPACE_HEATER_LOW_TEMPERATURE_HEAT_PUMP);
            $criteria->addSelectColumn(HfproductsTableMap::SPACE_HEATER_COLDER_EFFICIENCY);
            $criteria->addSelectColumn(HfproductsTableMap::SPACE_HEATER_WARMER_EFFICIENCY);
            $criteria->addSelectColumn(HfproductsTableMap::SPACE_HEATER_LOW_TEMPERATURE_GRADE);
            $criteria->addSelectColumn(HfproductsTableMap::SPACE_HEATER_LOW_TEMPERATURE_EFFICIENCY);
            $criteria->addSelectColumn(HfproductsTableMap::SPACE_HEATER_LOW_TEMPERATURE_COLDER_EFFICIENCY);
            $criteria->addSelectColumn(HfproductsTableMap::SPACE_HEATER_LOW_TEMPERATURE_WARMER_EFFICIENCY);
            $criteria->addSelectColumn(HfproductsTableMap::SPACE_HEATER_LOW_TEMPERATURE_SUPPLEMENTARY_POWER);
            $criteria->addSelectColumn(HfproductsTableMap::SPACE_HEATER_LOW_TEMPERATURE_POWER);
            $criteria->addSelectColumn(HfproductsTableMap::SOLAR_EFFICIENCY);
            $criteria->addSelectColumn(HfproductsTableMap::SOLAR_SIZE);
            $criteria->addSelectColumn(HfproductsTableMap::SOLAR_PUMP_POWER);
            $criteria->addSelectColumn(HfproductsTableMap::STORAGE_TYPE);
            $criteria->addSelectColumn(HfproductsTableMap::STORAGE_VOLUME);
            $criteria->addSelectColumn(HfproductsTableMap::STORAGE_NON_SOLAR_VOLUME);
            $criteria->addSelectColumn(HfproductsTableMap::STORAGE_WARMTH_LOSS);
            $criteria->addSelectColumn(HfproductsTableMap::COMBINATION_HEATER_SPACE_HEATER_GRADE);
            $criteria->addSelectColumn(HfproductsTableMap::COMBINATION_HEATER_WATER_HEATER_GRADE);
            $criteria->addSelectColumn(HfproductsTableMap::COMBINED_EFFICIENCY);
            $criteria->addSelectColumn(HfproductsTableMap::COMBINED_MAIN_HEATER_TYPE_ID);
            $criteria->addSelectColumn(HfproductsTableMap::TEMPERATURE_CONTROL_STANDBY_WARMTH_LOSS);
            $criteria->addSelectColumn(HfproductsTableMap::TEMPERATURE_CONTROL_TYPE);
            $criteria->addSelectColumn(HfproductsTableMap::SUPPLEMENTARY_POWER);
            $criteria->addSelectColumn(HfproductsTableMap::MONTAGE_ID);
            $criteria->addSelectColumn(HfproductsTableMap::PRICE);
        } else {
            $criteria->addSelectColumn($alias . '.ID');
            $criteria->addSelectColumn($alias . '.VENDOR_ID');
            $criteria->addSelectColumn($alias . '.NAME');
            $criteria->addSelectColumn($alias . '.OAG_NAME');
            $criteria->addSelectColumn($alias . '.TYPE_ID');
            $criteria->addSelectColumn($alias . '.PRODUCT_NUMBER');
            $criteria->addSelectColumn($alias . '.GRADE');
            $criteria->addSelectColumn($alias . '.BUILD_YEAR_FROM');
            $criteria->addSelectColumn($alias . '.BUILD_YEAR_TO');
            $criteria->addSelectColumn($alias . '.CREATEDAT');
            $criteria->addSelectColumn($alias . '.UPDATEDAT');
            $criteria->addSelectColumn($alias . '.SHT_PRODUCT');
            $criteria->addSelectColumn($alias . '.SHT_ID');
            $criteria->addSelectColumn($alias . '.SHT_CATEGORY');
            $criteria->addSelectColumn($alias . '.SHT_TEXT1');
            $criteria->addSelectColumn($alias . '.SHT_TEXT2');
            $criteria->addSelectColumn($alias . '.OAG_PRODUCT');
            $criteria->addSelectColumn($alias . '.OAG_ID');
            $criteria->addSelectColumn($alias . '.OAG_CATEGORY');
            $criteria->addSelectColumn($alias . '.OAG_TEXT1');
            $criteria->addSelectColumn($alias . '.OAG_TEXT2');
            $criteria->addSelectColumn($alias . '.MEGABILD_ID');
            $criteria->addSelectColumn($alias . '.IMAGE');
            $criteria->addSelectColumn($alias . '.SPECIFICATION_NAME');
            $criteria->addSelectColumn($alias . '.LABEL_NAME');
            $criteria->addSelectColumn($alias . '.WATER_HEATER_ENERGY_CLASS');
            $criteria->addSelectColumn($alias . '.WATER_HEATER_ENERGY_EFFICIENCY');
            $criteria->addSelectColumn($alias . '.WATER_HEATER_ENERGY_GRADE');
            $criteria->addSelectColumn($alias . '.SPACE_HEATER_EFFICIENCY');
            $criteria->addSelectColumn($alias . '.SPACE_HEATER_POWER');
            $criteria->addSelectColumn($alias . '.SPACE_HEATER_TYPE');
            $criteria->addSelectColumn($alias . '.SPACE_HEATER_LOW_TEMPERATURE_HEAT_PUMP');
            $criteria->addSelectColumn($alias . '.SPACE_HEATER_COLDER_EFFICIENCY');
            $criteria->addSelectColumn($alias . '.SPACE_HEATER_WARMER_EFFICIENCY');
            $criteria->addSelectColumn($alias . '.SPACE_HEATER_LOW_TEMPERATURE_GRADE');
            $criteria->addSelectColumn($alias . '.SPACE_HEATER_LOW_TEMPERATURE_EFFICIENCY');
            $criteria->addSelectColumn($alias . '.SPACE_HEATER_LOW_TEMPERATURE_COLDER_EFFICIENCY');
            $criteria->addSelectColumn($alias . '.SPACE_HEATER_LOW_TEMPERATURE_WARMER_EFFICIENCY');
            $criteria->addSelectColumn($alias . '.SPACE_HEATER_LOW_TEMPERATURE_SUPPLEMENTARY_POWER');
            $criteria->addSelectColumn($alias . '.SPACE_HEATER_LOW_TEMPERATURE_POWER');
            $criteria->addSelectColumn($alias . '.SOLAR_EFFICIENCY');
            $criteria->addSelectColumn($alias . '.SOLAR_SIZE');
            $criteria->addSelectColumn($alias . '.SOLAR_PUMP_POWER');
            $criteria->addSelectColumn($alias . '.STORAGE_TYPE');
            $criteria->addSelectColumn($alias . '.STORAGE_VOLUME');
            $criteria->addSelectColumn($alias . '.STORAGE_NON_SOLAR_VOLUME');
            $criteria->addSelectColumn($alias . '.STORAGE_WARMTH_LOSS');
            $criteria->addSelectColumn($alias . '.COMBINATION_HEATER_SPACE_HEATER_GRADE');
            $criteria->addSelectColumn($alias . '.COMBINATION_HEATER_WATER_HEATER_GRADE');
            $criteria->addSelectColumn($alias . '.COMBINED_EFFICIENCY');
            $criteria->addSelectColumn($alias . '.COMBINED_MAIN_HEATER_TYPE_ID');
            $criteria->addSelectColumn($alias . '.TEMPERATURE_CONTROL_STANDBY_WARMTH_LOSS');
            $criteria->addSelectColumn($alias . '.TEMPERATURE_CONTROL_TYPE');
            $criteria->addSelectColumn($alias . '.SUPPLEMENTARY_POWER');
            $criteria->addSelectColumn($alias . '.MONTAGE_ID');
            $criteria->addSelectColumn($alias . '.PRICE');
        }
    }

    /**
     * Returns the TableMap related to this object.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getServiceContainer()->getDatabaseMap(HfproductsTableMap::DATABASE_NAME)->getTable(HfproductsTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getServiceContainer()->getDatabaseMap(HfproductsTableMap::DATABASE_NAME);
      if (!$dbMap->hasTable(HfproductsTableMap::TABLE_NAME)) {
        $dbMap->addTableObject(new HfproductsTableMap());
      }
    }

    /**
     * Performs a DELETE on the database, given a Hfproducts or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Hfproducts object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(HfproductsTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Hfproducts) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(HfproductsTableMap::DATABASE_NAME);
            $criteria->add(HfproductsTableMap::ID, (array) $values, Criteria::IN);
        }

        $query = HfproductsQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) { HfproductsTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) { HfproductsTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the hfproducts table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return HfproductsQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Hfproducts or Criteria object.
     *
     * @param mixed               $criteria Criteria or Hfproducts object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(HfproductsTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Hfproducts object
        }

        if ($criteria->containsKey(HfproductsTableMap::ID) && $criteria->keyContainsValue(HfproductsTableMap::ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.HfproductsTableMap::ID.')');
        }


        // Set the correct dbName
        $query = HfproductsQuery::create()->mergeWith($criteria);

        try {
            // use transaction because $criteria could contain info
            // for more than one table (I guess, conceivably)
            $con->beginTransaction();
            $pk = $query->doInsert($con);
            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $pk;
    }

} // HfproductsTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
HfproductsTableMap::buildTableMap();
