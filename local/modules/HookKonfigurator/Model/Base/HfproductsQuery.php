<?php

namespace HookKonfigurator\Model\Base;

use \Exception;
use \PDO;
use HookKonfigurator\Model\Hfproducts as ChildHfproducts;
use HookKonfigurator\Model\HfproductsQuery as ChildHfproductsQuery;
use HookKonfigurator\Model\Map\HfproductsTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'hfproducts' table.
 *
 *
 *
 * @method     ChildHfproductsQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildHfproductsQuery orderByVendorId($order = Criteria::ASC) Order by the vendor_id column
 * @method     ChildHfproductsQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method     ChildHfproductsQuery orderByOagName($order = Criteria::ASC) Order by the oag_name column
 * @method     ChildHfproductsQuery orderByTypeId($order = Criteria::ASC) Order by the type_id column
 * @method     ChildHfproductsQuery orderByProductNumber($order = Criteria::ASC) Order by the product_number column
 * @method     ChildHfproductsQuery orderByGrade($order = Criteria::ASC) Order by the grade column
 * @method     ChildHfproductsQuery orderByBuildYearFrom($order = Criteria::ASC) Order by the build_year_from column
 * @method     ChildHfproductsQuery orderByBuildYearTo($order = Criteria::ASC) Order by the build_year_to column
 * @method     ChildHfproductsQuery orderByCreatedat($order = Criteria::ASC) Order by the createdAt column
 * @method     ChildHfproductsQuery orderByUpdatedat($order = Criteria::ASC) Order by the updatedAt column
 * @method     ChildHfproductsQuery orderByShtProduct($order = Criteria::ASC) Order by the sht_product column
 * @method     ChildHfproductsQuery orderByShtId($order = Criteria::ASC) Order by the sht_id column
 * @method     ChildHfproductsQuery orderByShtCategory($order = Criteria::ASC) Order by the sht_category column
 * @method     ChildHfproductsQuery orderByShtText1($order = Criteria::ASC) Order by the sht_text1 column
 * @method     ChildHfproductsQuery orderByShtText2($order = Criteria::ASC) Order by the sht_text2 column
 * @method     ChildHfproductsQuery orderByOagProduct($order = Criteria::ASC) Order by the oag_product column
 * @method     ChildHfproductsQuery orderByOagId($order = Criteria::ASC) Order by the oag_id column
 * @method     ChildHfproductsQuery orderByOagCategory($order = Criteria::ASC) Order by the oag_category column
 * @method     ChildHfproductsQuery orderByOagText1($order = Criteria::ASC) Order by the oag_text1 column
 * @method     ChildHfproductsQuery orderByOagText2($order = Criteria::ASC) Order by the oag_text2 column
 * @method     ChildHfproductsQuery orderByMegabildId($order = Criteria::ASC) Order by the megabild_id column
 * @method     ChildHfproductsQuery orderByImage($order = Criteria::ASC) Order by the image column
 * @method     ChildHfproductsQuery orderBySpecificationName($order = Criteria::ASC) Order by the specification_name column
 * @method     ChildHfproductsQuery orderByLabelName($order = Criteria::ASC) Order by the label_name column
 * @method     ChildHfproductsQuery orderByWaterHeaterEnergyClass($order = Criteria::ASC) Order by the water_heater_energy_class column
 * @method     ChildHfproductsQuery orderByWaterHeaterEnergyEfficiency($order = Criteria::ASC) Order by the water_heater_energy_efficiency column
 * @method     ChildHfproductsQuery orderByWaterHeaterEnergyGrade($order = Criteria::ASC) Order by the water_heater_energy_grade column
 * @method     ChildHfproductsQuery orderBySpaceHeaterEfficiency($order = Criteria::ASC) Order by the space_heater_efficiency column
 * @method     ChildHfproductsQuery orderBySpaceHeaterPower($order = Criteria::ASC) Order by the space_heater_power column
 * @method     ChildHfproductsQuery orderBySpaceHeaterType($order = Criteria::ASC) Order by the space_heater_type column
 * @method     ChildHfproductsQuery orderBySpaceHeaterLowTemperatureHeatPump($order = Criteria::ASC) Order by the space_heater_low_temperature_heat_pump column
 * @method     ChildHfproductsQuery orderBySpaceHeaterColderEfficiency($order = Criteria::ASC) Order by the space_heater_colder_efficiency column
 * @method     ChildHfproductsQuery orderBySpaceHeaterWarmerEfficiency($order = Criteria::ASC) Order by the space_heater_warmer_efficiency column
 * @method     ChildHfproductsQuery orderBySpaceHeaterLowTemperatureGrade($order = Criteria::ASC) Order by the space_heater_low_temperature_grade column
 * @method     ChildHfproductsQuery orderBySpaceHeaterLowTemperatureEfficiency($order = Criteria::ASC) Order by the space_heater_low_temperature_efficiency column
 * @method     ChildHfproductsQuery orderBySpaceHeaterLowTemperatureColderEfficiency($order = Criteria::ASC) Order by the space_heater_low_temperature_colder_efficiency column
 * @method     ChildHfproductsQuery orderBySpaceHeaterLowTemperatureWarmerEfficiency($order = Criteria::ASC) Order by the space_heater_low_temperature_warmer_efficiency column
 * @method     ChildHfproductsQuery orderBySpaceHeaterLowTemperatureSupplementaryPower($order = Criteria::ASC) Order by the space_heater_low_temperature_supplementary_power column
 * @method     ChildHfproductsQuery orderBySpaceHeaterLowTemperaturePower($order = Criteria::ASC) Order by the space_heater_low_temperature_power column
 * @method     ChildHfproductsQuery orderBySolarEfficiency($order = Criteria::ASC) Order by the solar_efficiency column
 * @method     ChildHfproductsQuery orderBySolarSize($order = Criteria::ASC) Order by the solar_size column
 * @method     ChildHfproductsQuery orderBySolarPumpPower($order = Criteria::ASC) Order by the solar_pump_power column
 * @method     ChildHfproductsQuery orderByStorageType($order = Criteria::ASC) Order by the storage_type column
 * @method     ChildHfproductsQuery orderByStorageVolume($order = Criteria::ASC) Order by the storage_volume column
 * @method     ChildHfproductsQuery orderByStorageNonSolarVolume($order = Criteria::ASC) Order by the storage_non_solar_volume column
 * @method     ChildHfproductsQuery orderByStorageWarmthLoss($order = Criteria::ASC) Order by the storage_warmth_loss column
 * @method     ChildHfproductsQuery orderByCombinationHeaterSpaceHeaterGrade($order = Criteria::ASC) Order by the combination_heater_space_heater_grade column
 * @method     ChildHfproductsQuery orderByCombinationHeaterWaterHeaterGrade($order = Criteria::ASC) Order by the combination_heater_water_heater_grade column
 * @method     ChildHfproductsQuery orderByCombinedEfficiency($order = Criteria::ASC) Order by the combined_efficiency column
 * @method     ChildHfproductsQuery orderByCombinedMainHeaterTypeId($order = Criteria::ASC) Order by the combined_main_heater_type_id column
 * @method     ChildHfproductsQuery orderByTemperatureControlStandbyWarmthLoss($order = Criteria::ASC) Order by the temperature_control_standby_warmth_loss column
 * @method     ChildHfproductsQuery orderByTemperatureControlType($order = Criteria::ASC) Order by the temperature_control_type column
 * @method     ChildHfproductsQuery orderBySupplementaryPower($order = Criteria::ASC) Order by the supplementary_power column
 * @method     ChildHfproductsQuery orderByMontageId($order = Criteria::ASC) Order by the montage_id column
 * @method     ChildHfproductsQuery orderByPrice($order = Criteria::ASC) Order by the price column
 *
 * @method     ChildHfproductsQuery groupById() Group by the id column
 * @method     ChildHfproductsQuery groupByVendorId() Group by the vendor_id column
 * @method     ChildHfproductsQuery groupByName() Group by the name column
 * @method     ChildHfproductsQuery groupByOagName() Group by the oag_name column
 * @method     ChildHfproductsQuery groupByTypeId() Group by the type_id column
 * @method     ChildHfproductsQuery groupByProductNumber() Group by the product_number column
 * @method     ChildHfproductsQuery groupByGrade() Group by the grade column
 * @method     ChildHfproductsQuery groupByBuildYearFrom() Group by the build_year_from column
 * @method     ChildHfproductsQuery groupByBuildYearTo() Group by the build_year_to column
 * @method     ChildHfproductsQuery groupByCreatedat() Group by the createdAt column
 * @method     ChildHfproductsQuery groupByUpdatedat() Group by the updatedAt column
 * @method     ChildHfproductsQuery groupByShtProduct() Group by the sht_product column
 * @method     ChildHfproductsQuery groupByShtId() Group by the sht_id column
 * @method     ChildHfproductsQuery groupByShtCategory() Group by the sht_category column
 * @method     ChildHfproductsQuery groupByShtText1() Group by the sht_text1 column
 * @method     ChildHfproductsQuery groupByShtText2() Group by the sht_text2 column
 * @method     ChildHfproductsQuery groupByOagProduct() Group by the oag_product column
 * @method     ChildHfproductsQuery groupByOagId() Group by the oag_id column
 * @method     ChildHfproductsQuery groupByOagCategory() Group by the oag_category column
 * @method     ChildHfproductsQuery groupByOagText1() Group by the oag_text1 column
 * @method     ChildHfproductsQuery groupByOagText2() Group by the oag_text2 column
 * @method     ChildHfproductsQuery groupByMegabildId() Group by the megabild_id column
 * @method     ChildHfproductsQuery groupByImage() Group by the image column
 * @method     ChildHfproductsQuery groupBySpecificationName() Group by the specification_name column
 * @method     ChildHfproductsQuery groupByLabelName() Group by the label_name column
 * @method     ChildHfproductsQuery groupByWaterHeaterEnergyClass() Group by the water_heater_energy_class column
 * @method     ChildHfproductsQuery groupByWaterHeaterEnergyEfficiency() Group by the water_heater_energy_efficiency column
 * @method     ChildHfproductsQuery groupByWaterHeaterEnergyGrade() Group by the water_heater_energy_grade column
 * @method     ChildHfproductsQuery groupBySpaceHeaterEfficiency() Group by the space_heater_efficiency column
 * @method     ChildHfproductsQuery groupBySpaceHeaterPower() Group by the space_heater_power column
 * @method     ChildHfproductsQuery groupBySpaceHeaterType() Group by the space_heater_type column
 * @method     ChildHfproductsQuery groupBySpaceHeaterLowTemperatureHeatPump() Group by the space_heater_low_temperature_heat_pump column
 * @method     ChildHfproductsQuery groupBySpaceHeaterColderEfficiency() Group by the space_heater_colder_efficiency column
 * @method     ChildHfproductsQuery groupBySpaceHeaterWarmerEfficiency() Group by the space_heater_warmer_efficiency column
 * @method     ChildHfproductsQuery groupBySpaceHeaterLowTemperatureGrade() Group by the space_heater_low_temperature_grade column
 * @method     ChildHfproductsQuery groupBySpaceHeaterLowTemperatureEfficiency() Group by the space_heater_low_temperature_efficiency column
 * @method     ChildHfproductsQuery groupBySpaceHeaterLowTemperatureColderEfficiency() Group by the space_heater_low_temperature_colder_efficiency column
 * @method     ChildHfproductsQuery groupBySpaceHeaterLowTemperatureWarmerEfficiency() Group by the space_heater_low_temperature_warmer_efficiency column
 * @method     ChildHfproductsQuery groupBySpaceHeaterLowTemperatureSupplementaryPower() Group by the space_heater_low_temperature_supplementary_power column
 * @method     ChildHfproductsQuery groupBySpaceHeaterLowTemperaturePower() Group by the space_heater_low_temperature_power column
 * @method     ChildHfproductsQuery groupBySolarEfficiency() Group by the solar_efficiency column
 * @method     ChildHfproductsQuery groupBySolarSize() Group by the solar_size column
 * @method     ChildHfproductsQuery groupBySolarPumpPower() Group by the solar_pump_power column
 * @method     ChildHfproductsQuery groupByStorageType() Group by the storage_type column
 * @method     ChildHfproductsQuery groupByStorageVolume() Group by the storage_volume column
 * @method     ChildHfproductsQuery groupByStorageNonSolarVolume() Group by the storage_non_solar_volume column
 * @method     ChildHfproductsQuery groupByStorageWarmthLoss() Group by the storage_warmth_loss column
 * @method     ChildHfproductsQuery groupByCombinationHeaterSpaceHeaterGrade() Group by the combination_heater_space_heater_grade column
 * @method     ChildHfproductsQuery groupByCombinationHeaterWaterHeaterGrade() Group by the combination_heater_water_heater_grade column
 * @method     ChildHfproductsQuery groupByCombinedEfficiency() Group by the combined_efficiency column
 * @method     ChildHfproductsQuery groupByCombinedMainHeaterTypeId() Group by the combined_main_heater_type_id column
 * @method     ChildHfproductsQuery groupByTemperatureControlStandbyWarmthLoss() Group by the temperature_control_standby_warmth_loss column
 * @method     ChildHfproductsQuery groupByTemperatureControlType() Group by the temperature_control_type column
 * @method     ChildHfproductsQuery groupBySupplementaryPower() Group by the supplementary_power column
 * @method     ChildHfproductsQuery groupByMontageId() Group by the montage_id column
 * @method     ChildHfproductsQuery groupByPrice() Group by the price column
 *
 * @method     ChildHfproductsQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildHfproductsQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildHfproductsQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildHfproducts findOne(ConnectionInterface $con = null) Return the first ChildHfproducts matching the query
 * @method     ChildHfproducts findOneOrCreate(ConnectionInterface $con = null) Return the first ChildHfproducts matching the query, or a new ChildHfproducts object populated from the query conditions when no match is found
 *
 * @method     ChildHfproducts findOneById(int $id) Return the first ChildHfproducts filtered by the id column
 * @method     ChildHfproducts findOneByVendorId(int $vendor_id) Return the first ChildHfproducts filtered by the vendor_id column
 * @method     ChildHfproducts findOneByName(string $name) Return the first ChildHfproducts filtered by the name column
 * @method     ChildHfproducts findOneByOagName(string $oag_name) Return the first ChildHfproducts filtered by the oag_name column
 * @method     ChildHfproducts findOneByTypeId(int $type_id) Return the first ChildHfproducts filtered by the type_id column
 * @method     ChildHfproducts findOneByProductNumber(string $product_number) Return the first ChildHfproducts filtered by the product_number column
 * @method     ChildHfproducts findOneByGrade(string $grade) Return the first ChildHfproducts filtered by the grade column
 * @method     ChildHfproducts findOneByBuildYearFrom(int $build_year_from) Return the first ChildHfproducts filtered by the build_year_from column
 * @method     ChildHfproducts findOneByBuildYearTo(int $build_year_to) Return the first ChildHfproducts filtered by the build_year_to column
 * @method     ChildHfproducts findOneByCreatedat(string $createdAt) Return the first ChildHfproducts filtered by the createdAt column
 * @method     ChildHfproducts findOneByUpdatedat(string $updatedAt) Return the first ChildHfproducts filtered by the updatedAt column
 * @method     ChildHfproducts findOneByShtProduct(boolean $sht_product) Return the first ChildHfproducts filtered by the sht_product column
 * @method     ChildHfproducts findOneByShtId(string $sht_id) Return the first ChildHfproducts filtered by the sht_id column
 * @method     ChildHfproducts findOneByShtCategory(int $sht_category) Return the first ChildHfproducts filtered by the sht_category column
 * @method     ChildHfproducts findOneByShtText1(string $sht_text1) Return the first ChildHfproducts filtered by the sht_text1 column
 * @method     ChildHfproducts findOneByShtText2(string $sht_text2) Return the first ChildHfproducts filtered by the sht_text2 column
 * @method     ChildHfproducts findOneByOagProduct(boolean $oag_product) Return the first ChildHfproducts filtered by the oag_product column
 * @method     ChildHfproducts findOneByOagId(string $oag_id) Return the first ChildHfproducts filtered by the oag_id column
 * @method     ChildHfproducts findOneByOagCategory(int $oag_category) Return the first ChildHfproducts filtered by the oag_category column
 * @method     ChildHfproducts findOneByOagText1(string $oag_text1) Return the first ChildHfproducts filtered by the oag_text1 column
 * @method     ChildHfproducts findOneByOagText2(string $oag_text2) Return the first ChildHfproducts filtered by the oag_text2 column
 * @method     ChildHfproducts findOneByMegabildId(int $megabild_id) Return the first ChildHfproducts filtered by the megabild_id column
 * @method     ChildHfproducts findOneByImage(string $image) Return the first ChildHfproducts filtered by the image column
 * @method     ChildHfproducts findOneBySpecificationName(string $specification_name) Return the first ChildHfproducts filtered by the specification_name column
 * @method     ChildHfproducts findOneByLabelName(string $label_name) Return the first ChildHfproducts filtered by the label_name column
 * @method     ChildHfproducts findOneByWaterHeaterEnergyClass(string $water_heater_energy_class) Return the first ChildHfproducts filtered by the water_heater_energy_class column
 * @method     ChildHfproducts findOneByWaterHeaterEnergyEfficiency(int $water_heater_energy_efficiency) Return the first ChildHfproducts filtered by the water_heater_energy_efficiency column
 * @method     ChildHfproducts findOneByWaterHeaterEnergyGrade(string $water_heater_energy_grade) Return the first ChildHfproducts filtered by the water_heater_energy_grade column
 * @method     ChildHfproducts findOneBySpaceHeaterEfficiency(int $space_heater_efficiency) Return the first ChildHfproducts filtered by the space_heater_efficiency column
 * @method     ChildHfproducts findOneBySpaceHeaterPower(int $space_heater_power) Return the first ChildHfproducts filtered by the space_heater_power column
 * @method     ChildHfproducts findOneBySpaceHeaterType(string $space_heater_type) Return the first ChildHfproducts filtered by the space_heater_type column
 * @method     ChildHfproducts findOneBySpaceHeaterLowTemperatureHeatPump(boolean $space_heater_low_temperature_heat_pump) Return the first ChildHfproducts filtered by the space_heater_low_temperature_heat_pump column
 * @method     ChildHfproducts findOneBySpaceHeaterColderEfficiency(int $space_heater_colder_efficiency) Return the first ChildHfproducts filtered by the space_heater_colder_efficiency column
 * @method     ChildHfproducts findOneBySpaceHeaterWarmerEfficiency(int $space_heater_warmer_efficiency) Return the first ChildHfproducts filtered by the space_heater_warmer_efficiency column
 * @method     ChildHfproducts findOneBySpaceHeaterLowTemperatureGrade(string $space_heater_low_temperature_grade) Return the first ChildHfproducts filtered by the space_heater_low_temperature_grade column
 * @method     ChildHfproducts findOneBySpaceHeaterLowTemperatureEfficiency(int $space_heater_low_temperature_efficiency) Return the first ChildHfproducts filtered by the space_heater_low_temperature_efficiency column
 * @method     ChildHfproducts findOneBySpaceHeaterLowTemperatureColderEfficiency(int $space_heater_low_temperature_colder_efficiency) Return the first ChildHfproducts filtered by the space_heater_low_temperature_colder_efficiency column
 * @method     ChildHfproducts findOneBySpaceHeaterLowTemperatureWarmerEfficiency(int $space_heater_low_temperature_warmer_efficiency) Return the first ChildHfproducts filtered by the space_heater_low_temperature_warmer_efficiency column
 * @method     ChildHfproducts findOneBySpaceHeaterLowTemperatureSupplementaryPower(int $space_heater_low_temperature_supplementary_power) Return the first ChildHfproducts filtered by the space_heater_low_temperature_supplementary_power column
 * @method     ChildHfproducts findOneBySpaceHeaterLowTemperaturePower(int $space_heater_low_temperature_power) Return the first ChildHfproducts filtered by the space_heater_low_temperature_power column
 * @method     ChildHfproducts findOneBySolarEfficiency(string $solar_efficiency) Return the first ChildHfproducts filtered by the solar_efficiency column
 * @method     ChildHfproducts findOneBySolarSize(string $solar_size) Return the first ChildHfproducts filtered by the solar_size column
 * @method     ChildHfproducts findOneBySolarPumpPower(int $solar_pump_power) Return the first ChildHfproducts filtered by the solar_pump_power column
 * @method     ChildHfproducts findOneByStorageType(string $storage_type) Return the first ChildHfproducts filtered by the storage_type column
 * @method     ChildHfproducts findOneByStorageVolume(string $storage_volume) Return the first ChildHfproducts filtered by the storage_volume column
 * @method     ChildHfproducts findOneByStorageNonSolarVolume(string $storage_non_solar_volume) Return the first ChildHfproducts filtered by the storage_non_solar_volume column
 * @method     ChildHfproducts findOneByStorageWarmthLoss(int $storage_warmth_loss) Return the first ChildHfproducts filtered by the storage_warmth_loss column
 * @method     ChildHfproducts findOneByCombinationHeaterSpaceHeaterGrade(string $combination_heater_space_heater_grade) Return the first ChildHfproducts filtered by the combination_heater_space_heater_grade column
 * @method     ChildHfproducts findOneByCombinationHeaterWaterHeaterGrade(string $combination_heater_water_heater_grade) Return the first ChildHfproducts filtered by the combination_heater_water_heater_grade column
 * @method     ChildHfproducts findOneByCombinedEfficiency(int $combined_efficiency) Return the first ChildHfproducts filtered by the combined_efficiency column
 * @method     ChildHfproducts findOneByCombinedMainHeaterTypeId(int $combined_main_heater_type_id) Return the first ChildHfproducts filtered by the combined_main_heater_type_id column
 * @method     ChildHfproducts findOneByTemperatureControlStandbyWarmthLoss(string $temperature_control_standby_warmth_loss) Return the first ChildHfproducts filtered by the temperature_control_standby_warmth_loss column
 * @method     ChildHfproducts findOneByTemperatureControlType(string $temperature_control_type) Return the first ChildHfproducts filtered by the temperature_control_type column
 * @method     ChildHfproducts findOneBySupplementaryPower(int $supplementary_power) Return the first ChildHfproducts filtered by the supplementary_power column
 * @method     ChildHfproducts findOneByMontageId(int $montage_id) Return the first ChildHfproducts filtered by the montage_id column
 * @method     ChildHfproducts findOneByPrice(string $price) Return the first ChildHfproducts filtered by the price column
 *
 * @method     array findById(int $id) Return ChildHfproducts objects filtered by the id column
 * @method     array findByVendorId(int $vendor_id) Return ChildHfproducts objects filtered by the vendor_id column
 * @method     array findByName(string $name) Return ChildHfproducts objects filtered by the name column
 * @method     array findByOagName(string $oag_name) Return ChildHfproducts objects filtered by the oag_name column
 * @method     array findByTypeId(int $type_id) Return ChildHfproducts objects filtered by the type_id column
 * @method     array findByProductNumber(string $product_number) Return ChildHfproducts objects filtered by the product_number column
 * @method     array findByGrade(string $grade) Return ChildHfproducts objects filtered by the grade column
 * @method     array findByBuildYearFrom(int $build_year_from) Return ChildHfproducts objects filtered by the build_year_from column
 * @method     array findByBuildYearTo(int $build_year_to) Return ChildHfproducts objects filtered by the build_year_to column
 * @method     array findByCreatedat(string $createdAt) Return ChildHfproducts objects filtered by the createdAt column
 * @method     array findByUpdatedat(string $updatedAt) Return ChildHfproducts objects filtered by the updatedAt column
 * @method     array findByShtProduct(boolean $sht_product) Return ChildHfproducts objects filtered by the sht_product column
 * @method     array findByShtId(string $sht_id) Return ChildHfproducts objects filtered by the sht_id column
 * @method     array findByShtCategory(int $sht_category) Return ChildHfproducts objects filtered by the sht_category column
 * @method     array findByShtText1(string $sht_text1) Return ChildHfproducts objects filtered by the sht_text1 column
 * @method     array findByShtText2(string $sht_text2) Return ChildHfproducts objects filtered by the sht_text2 column
 * @method     array findByOagProduct(boolean $oag_product) Return ChildHfproducts objects filtered by the oag_product column
 * @method     array findByOagId(string $oag_id) Return ChildHfproducts objects filtered by the oag_id column
 * @method     array findByOagCategory(int $oag_category) Return ChildHfproducts objects filtered by the oag_category column
 * @method     array findByOagText1(string $oag_text1) Return ChildHfproducts objects filtered by the oag_text1 column
 * @method     array findByOagText2(string $oag_text2) Return ChildHfproducts objects filtered by the oag_text2 column
 * @method     array findByMegabildId(int $megabild_id) Return ChildHfproducts objects filtered by the megabild_id column
 * @method     array findByImage(string $image) Return ChildHfproducts objects filtered by the image column
 * @method     array findBySpecificationName(string $specification_name) Return ChildHfproducts objects filtered by the specification_name column
 * @method     array findByLabelName(string $label_name) Return ChildHfproducts objects filtered by the label_name column
 * @method     array findByWaterHeaterEnergyClass(string $water_heater_energy_class) Return ChildHfproducts objects filtered by the water_heater_energy_class column
 * @method     array findByWaterHeaterEnergyEfficiency(int $water_heater_energy_efficiency) Return ChildHfproducts objects filtered by the water_heater_energy_efficiency column
 * @method     array findByWaterHeaterEnergyGrade(string $water_heater_energy_grade) Return ChildHfproducts objects filtered by the water_heater_energy_grade column
 * @method     array findBySpaceHeaterEfficiency(int $space_heater_efficiency) Return ChildHfproducts objects filtered by the space_heater_efficiency column
 * @method     array findBySpaceHeaterPower(int $space_heater_power) Return ChildHfproducts objects filtered by the space_heater_power column
 * @method     array findBySpaceHeaterType(string $space_heater_type) Return ChildHfproducts objects filtered by the space_heater_type column
 * @method     array findBySpaceHeaterLowTemperatureHeatPump(boolean $space_heater_low_temperature_heat_pump) Return ChildHfproducts objects filtered by the space_heater_low_temperature_heat_pump column
 * @method     array findBySpaceHeaterColderEfficiency(int $space_heater_colder_efficiency) Return ChildHfproducts objects filtered by the space_heater_colder_efficiency column
 * @method     array findBySpaceHeaterWarmerEfficiency(int $space_heater_warmer_efficiency) Return ChildHfproducts objects filtered by the space_heater_warmer_efficiency column
 * @method     array findBySpaceHeaterLowTemperatureGrade(string $space_heater_low_temperature_grade) Return ChildHfproducts objects filtered by the space_heater_low_temperature_grade column
 * @method     array findBySpaceHeaterLowTemperatureEfficiency(int $space_heater_low_temperature_efficiency) Return ChildHfproducts objects filtered by the space_heater_low_temperature_efficiency column
 * @method     array findBySpaceHeaterLowTemperatureColderEfficiency(int $space_heater_low_temperature_colder_efficiency) Return ChildHfproducts objects filtered by the space_heater_low_temperature_colder_efficiency column
 * @method     array findBySpaceHeaterLowTemperatureWarmerEfficiency(int $space_heater_low_temperature_warmer_efficiency) Return ChildHfproducts objects filtered by the space_heater_low_temperature_warmer_efficiency column
 * @method     array findBySpaceHeaterLowTemperatureSupplementaryPower(int $space_heater_low_temperature_supplementary_power) Return ChildHfproducts objects filtered by the space_heater_low_temperature_supplementary_power column
 * @method     array findBySpaceHeaterLowTemperaturePower(int $space_heater_low_temperature_power) Return ChildHfproducts objects filtered by the space_heater_low_temperature_power column
 * @method     array findBySolarEfficiency(string $solar_efficiency) Return ChildHfproducts objects filtered by the solar_efficiency column
 * @method     array findBySolarSize(string $solar_size) Return ChildHfproducts objects filtered by the solar_size column
 * @method     array findBySolarPumpPower(int $solar_pump_power) Return ChildHfproducts objects filtered by the solar_pump_power column
 * @method     array findByStorageType(string $storage_type) Return ChildHfproducts objects filtered by the storage_type column
 * @method     array findByStorageVolume(string $storage_volume) Return ChildHfproducts objects filtered by the storage_volume column
 * @method     array findByStorageNonSolarVolume(string $storage_non_solar_volume) Return ChildHfproducts objects filtered by the storage_non_solar_volume column
 * @method     array findByStorageWarmthLoss(int $storage_warmth_loss) Return ChildHfproducts objects filtered by the storage_warmth_loss column
 * @method     array findByCombinationHeaterSpaceHeaterGrade(string $combination_heater_space_heater_grade) Return ChildHfproducts objects filtered by the combination_heater_space_heater_grade column
 * @method     array findByCombinationHeaterWaterHeaterGrade(string $combination_heater_water_heater_grade) Return ChildHfproducts objects filtered by the combination_heater_water_heater_grade column
 * @method     array findByCombinedEfficiency(int $combined_efficiency) Return ChildHfproducts objects filtered by the combined_efficiency column
 * @method     array findByCombinedMainHeaterTypeId(int $combined_main_heater_type_id) Return ChildHfproducts objects filtered by the combined_main_heater_type_id column
 * @method     array findByTemperatureControlStandbyWarmthLoss(string $temperature_control_standby_warmth_loss) Return ChildHfproducts objects filtered by the temperature_control_standby_warmth_loss column
 * @method     array findByTemperatureControlType(string $temperature_control_type) Return ChildHfproducts objects filtered by the temperature_control_type column
 * @method     array findBySupplementaryPower(int $supplementary_power) Return ChildHfproducts objects filtered by the supplementary_power column
 * @method     array findByMontageId(int $montage_id) Return ChildHfproducts objects filtered by the montage_id column
 * @method     array findByPrice(string $price) Return ChildHfproducts objects filtered by the price column
 *
 */
abstract class HfproductsQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \Base\HfproductsQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'thelia', $modelName = '\\HookKonfigurator\\Model\\Hfproducts', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildHfproductsQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildHfproductsQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \HookKonfigurator\Model\HfproductsQuery) {
            return $criteria;
        }
        $query = new \HookKonfigurator\Model\HfproductsQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildHfproducts|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = HfproductsTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(HfproductsTableMap::DATABASE_NAME);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return   ChildHfproducts A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ID, VENDOR_ID, NAME, OAG_NAME, TYPE_ID, PRODUCT_NUMBER, GRADE, BUILD_YEAR_FROM, BUILD_YEAR_TO, CREATEDAT, UPDATEDAT, SHT_PRODUCT, SHT_ID, SHT_CATEGORY, SHT_TEXT1, SHT_TEXT2, OAG_PRODUCT, OAG_ID, OAG_CATEGORY, OAG_TEXT1, OAG_TEXT2, MEGABILD_ID, IMAGE, SPECIFICATION_NAME, LABEL_NAME, WATER_HEATER_ENERGY_CLASS, WATER_HEATER_ENERGY_EFFICIENCY, WATER_HEATER_ENERGY_GRADE, SPACE_HEATER_EFFICIENCY, SPACE_HEATER_POWER, SPACE_HEATER_TYPE, SPACE_HEATER_LOW_TEMPERATURE_HEAT_PUMP, SPACE_HEATER_COLDER_EFFICIENCY, SPACE_HEATER_WARMER_EFFICIENCY, SPACE_HEATER_LOW_TEMPERATURE_GRADE, SPACE_HEATER_LOW_TEMPERATURE_EFFICIENCY, SPACE_HEATER_LOW_TEMPERATURE_COLDER_EFFICIENCY, SPACE_HEATER_LOW_TEMPERATURE_WARMER_EFFICIENCY, SPACE_HEATER_LOW_TEMPERATURE_SUPPLEMENTARY_POWER, SPACE_HEATER_LOW_TEMPERATURE_POWER, SOLAR_EFFICIENCY, SOLAR_SIZE, SOLAR_PUMP_POWER, STORAGE_TYPE, STORAGE_VOLUME, STORAGE_NON_SOLAR_VOLUME, STORAGE_WARMTH_LOSS, COMBINATION_HEATER_SPACE_HEATER_GRADE, COMBINATION_HEATER_WATER_HEATER_GRADE, COMBINED_EFFICIENCY, COMBINED_MAIN_HEATER_TYPE_ID, TEMPERATURE_CONTROL_STANDBY_WARMTH_LOSS, TEMPERATURE_CONTROL_TYPE, SUPPLEMENTARY_POWER, MONTAGE_ID, PRICE FROM hfproducts WHERE ID = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            $obj = new ChildHfproducts();
            $obj->hydrate($row);
            HfproductsTableMap::addInstanceToPool($obj, (string) $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildHfproducts|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return ChildHfproductsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(HfproductsTableMap::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildHfproductsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(HfproductsTableMap::ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id > 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildHfproductsQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(HfproductsTableMap::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(HfproductsTableMap::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(HfproductsTableMap::ID, $id, $comparison);
    }

    /**
     * Filter the query on the vendor_id column
     *
     * Example usage:
     * <code>
     * $query->filterByVendorId(1234); // WHERE vendor_id = 1234
     * $query->filterByVendorId(array(12, 34)); // WHERE vendor_id IN (12, 34)
     * $query->filterByVendorId(array('min' => 12)); // WHERE vendor_id > 12
     * </code>
     *
     * @param     mixed $vendorId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildHfproductsQuery The current query, for fluid interface
     */
    public function filterByVendorId($vendorId = null, $comparison = null)
    {
        if (is_array($vendorId)) {
            $useMinMax = false;
            if (isset($vendorId['min'])) {
                $this->addUsingAlias(HfproductsTableMap::VENDOR_ID, $vendorId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($vendorId['max'])) {
                $this->addUsingAlias(HfproductsTableMap::VENDOR_ID, $vendorId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(HfproductsTableMap::VENDOR_ID, $vendorId, $comparison);
    }

    /**
     * Filter the query on the name column
     *
     * Example usage:
     * <code>
     * $query->filterByName('fooValue');   // WHERE name = 'fooValue'
     * $query->filterByName('%fooValue%'); // WHERE name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $name The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildHfproductsQuery The current query, for fluid interface
     */
    public function filterByName($name = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $name)) {
                $name = str_replace('*', '%', $name);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(HfproductsTableMap::NAME, $name, $comparison);
    }

    /**
     * Filter the query on the oag_name column
     *
     * Example usage:
     * <code>
     * $query->filterByOagName('fooValue');   // WHERE oag_name = 'fooValue'
     * $query->filterByOagName('%fooValue%'); // WHERE oag_name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $oagName The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildHfproductsQuery The current query, for fluid interface
     */
    public function filterByOagName($oagName = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($oagName)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $oagName)) {
                $oagName = str_replace('*', '%', $oagName);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(HfproductsTableMap::OAG_NAME, $oagName, $comparison);
    }

    /**
     * Filter the query on the type_id column
     *
     * Example usage:
     * <code>
     * $query->filterByTypeId(1234); // WHERE type_id = 1234
     * $query->filterByTypeId(array(12, 34)); // WHERE type_id IN (12, 34)
     * $query->filterByTypeId(array('min' => 12)); // WHERE type_id > 12
     * </code>
     *
     * @param     mixed $typeId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildHfproductsQuery The current query, for fluid interface
     */
    public function filterByTypeId($typeId = null, $comparison = null)
    {
        if (is_array($typeId)) {
            $useMinMax = false;
            if (isset($typeId['min'])) {
                $this->addUsingAlias(HfproductsTableMap::TYPE_ID, $typeId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($typeId['max'])) {
                $this->addUsingAlias(HfproductsTableMap::TYPE_ID, $typeId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(HfproductsTableMap::TYPE_ID, $typeId, $comparison);
    }

    /**
     * Filter the query on the product_number column
     *
     * Example usage:
     * <code>
     * $query->filterByProductNumber('fooValue');   // WHERE product_number = 'fooValue'
     * $query->filterByProductNumber('%fooValue%'); // WHERE product_number LIKE '%fooValue%'
     * </code>
     *
     * @param     string $productNumber The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildHfproductsQuery The current query, for fluid interface
     */
    public function filterByProductNumber($productNumber = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($productNumber)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $productNumber)) {
                $productNumber = str_replace('*', '%', $productNumber);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(HfproductsTableMap::PRODUCT_NUMBER, $productNumber, $comparison);
    }

    /**
     * Filter the query on the grade column
     *
     * Example usage:
     * <code>
     * $query->filterByGrade('fooValue');   // WHERE grade = 'fooValue'
     * $query->filterByGrade('%fooValue%'); // WHERE grade LIKE '%fooValue%'
     * </code>
     *
     * @param     string $grade The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildHfproductsQuery The current query, for fluid interface
     */
	 
		public function getProductByPower($min,$max)
    {
        $sql = 'SELECT * from hfproducts WHERE SPACE_HEATER_POWER >=:p0 AND SPACE_HEATER_POWER <=:p1';
		
		$con = Propel::getServiceContainer()->getReadConnection(HfproductsTableMap::DATABASE_NAME);
		
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0',$min, PDO::PARAM_INT);
			$stmt->bindValue(':p1',$max, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            $obj = new ChildHfproducts();
            $obj->hydrate($row);
            HfproductsTableMap::addInstanceToPool($obj, (string) $obj->getId());
        }
        $stmt->closeCursor();

        return $obj;
    } 
	 
	 
    public function filterByGrade($grade = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($grade)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $grade)) {
                $grade = str_replace('*', '%', $grade);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(HfproductsTableMap::GRADE, $grade, $comparison);
    }

    /**
     * Filter the query on the build_year_from column
     *
     * Example usage:
     * <code>
     * $query->filterByBuildYearFrom(1234); // WHERE build_year_from = 1234
     * $query->filterByBuildYearFrom(array(12, 34)); // WHERE build_year_from IN (12, 34)
     * $query->filterByBuildYearFrom(array('min' => 12)); // WHERE build_year_from > 12
     * </code>
     *
     * @param     mixed $buildYearFrom The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildHfproductsQuery The current query, for fluid interface
     */
    public function filterByBuildYearFrom($buildYearFrom = null, $comparison = null)
    {
        if (is_array($buildYearFrom)) {
            $useMinMax = false;
            if (isset($buildYearFrom['min'])) {
                $this->addUsingAlias(HfproductsTableMap::BUILD_YEAR_FROM, $buildYearFrom['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($buildYearFrom['max'])) {
                $this->addUsingAlias(HfproductsTableMap::BUILD_YEAR_FROM, $buildYearFrom['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(HfproductsTableMap::BUILD_YEAR_FROM, $buildYearFrom, $comparison);
    }

    /**
     * Filter the query on the build_year_to column
     *
     * Example usage:
     * <code>
     * $query->filterByBuildYearTo(1234); // WHERE build_year_to = 1234
     * $query->filterByBuildYearTo(array(12, 34)); // WHERE build_year_to IN (12, 34)
     * $query->filterByBuildYearTo(array('min' => 12)); // WHERE build_year_to > 12
     * </code>
     *
     * @param     mixed $buildYearTo The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildHfproductsQuery The current query, for fluid interface
     */
    public function filterByBuildYearTo($buildYearTo = null, $comparison = null)
    {
        if (is_array($buildYearTo)) {
            $useMinMax = false;
            if (isset($buildYearTo['min'])) {
                $this->addUsingAlias(HfproductsTableMap::BUILD_YEAR_TO, $buildYearTo['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($buildYearTo['max'])) {
                $this->addUsingAlias(HfproductsTableMap::BUILD_YEAR_TO, $buildYearTo['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(HfproductsTableMap::BUILD_YEAR_TO, $buildYearTo, $comparison);
    }

    /**
     * Filter the query on the createdAt column
     *
     * Example usage:
     * <code>
     * $query->filterByCreatedat('2011-03-14'); // WHERE createdAt = '2011-03-14'
     * $query->filterByCreatedat('now'); // WHERE createdAt = '2011-03-14'
     * $query->filterByCreatedat(array('max' => 'yesterday')); // WHERE createdAt > '2011-03-13'
     * </code>
     *
     * @param     mixed $createdat The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildHfproductsQuery The current query, for fluid interface
     */
    public function filterByCreatedat($createdat = null, $comparison = null)
    {
        if (is_array($createdat)) {
            $useMinMax = false;
            if (isset($createdat['min'])) {
                $this->addUsingAlias(HfproductsTableMap::CREATEDAT, $createdat['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdat['max'])) {
                $this->addUsingAlias(HfproductsTableMap::CREATEDAT, $createdat['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(HfproductsTableMap::CREATEDAT, $createdat, $comparison);
    }

    /**
     * Filter the query on the updatedAt column
     *
     * Example usage:
     * <code>
     * $query->filterByUpdatedat('2011-03-14'); // WHERE updatedAt = '2011-03-14'
     * $query->filterByUpdatedat('now'); // WHERE updatedAt = '2011-03-14'
     * $query->filterByUpdatedat(array('max' => 'yesterday')); // WHERE updatedAt > '2011-03-13'
     * </code>
     *
     * @param     mixed $updatedat The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildHfproductsQuery The current query, for fluid interface
     */
    public function filterByUpdatedat($updatedat = null, $comparison = null)
    {
        if (is_array($updatedat)) {
            $useMinMax = false;
            if (isset($updatedat['min'])) {
                $this->addUsingAlias(HfproductsTableMap::UPDATEDAT, $updatedat['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedat['max'])) {
                $this->addUsingAlias(HfproductsTableMap::UPDATEDAT, $updatedat['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(HfproductsTableMap::UPDATEDAT, $updatedat, $comparison);
    }

    /**
     * Filter the query on the sht_product column
     *
     * Example usage:
     * <code>
     * $query->filterByShtProduct(true); // WHERE sht_product = true
     * $query->filterByShtProduct('yes'); // WHERE sht_product = true
     * </code>
     *
     * @param     boolean|string $shtProduct The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildHfproductsQuery The current query, for fluid interface
     */
    public function filterByShtProduct($shtProduct = null, $comparison = null)
    {
        if (is_string($shtProduct)) {
            $sht_product = in_array(strtolower($shtProduct), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(HfproductsTableMap::SHT_PRODUCT, $shtProduct, $comparison);
    }

    /**
     * Filter the query on the sht_id column
     *
     * Example usage:
     * <code>
     * $query->filterByShtId('fooValue');   // WHERE sht_id = 'fooValue'
     * $query->filterByShtId('%fooValue%'); // WHERE sht_id LIKE '%fooValue%'
     * </code>
     *
     * @param     string $shtId The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildHfproductsQuery The current query, for fluid interface
     */
    public function filterByShtId($shtId = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($shtId)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $shtId)) {
                $shtId = str_replace('*', '%', $shtId);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(HfproductsTableMap::SHT_ID, $shtId, $comparison);
    }

    /**
     * Filter the query on the sht_category column
     *
     * Example usage:
     * <code>
     * $query->filterByShtCategory(1234); // WHERE sht_category = 1234
     * $query->filterByShtCategory(array(12, 34)); // WHERE sht_category IN (12, 34)
     * $query->filterByShtCategory(array('min' => 12)); // WHERE sht_category > 12
     * </code>
     *
     * @param     mixed $shtCategory The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildHfproductsQuery The current query, for fluid interface
     */
    public function filterByShtCategory($shtCategory = null, $comparison = null)
    {
        if (is_array($shtCategory)) {
            $useMinMax = false;
            if (isset($shtCategory['min'])) {
                $this->addUsingAlias(HfproductsTableMap::SHT_CATEGORY, $shtCategory['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($shtCategory['max'])) {
                $this->addUsingAlias(HfproductsTableMap::SHT_CATEGORY, $shtCategory['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(HfproductsTableMap::SHT_CATEGORY, $shtCategory, $comparison);
    }

    /**
     * Filter the query on the sht_text1 column
     *
     * Example usage:
     * <code>
     * $query->filterByShtText1('fooValue');   // WHERE sht_text1 = 'fooValue'
     * $query->filterByShtText1('%fooValue%'); // WHERE sht_text1 LIKE '%fooValue%'
     * </code>
     *
     * @param     string $shtText1 The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildHfproductsQuery The current query, for fluid interface
     */
    public function filterByShtText1($shtText1 = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($shtText1)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $shtText1)) {
                $shtText1 = str_replace('*', '%', $shtText1);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(HfproductsTableMap::SHT_TEXT1, $shtText1, $comparison);
    }

    /**
     * Filter the query on the sht_text2 column
     *
     * Example usage:
     * <code>
     * $query->filterByShtText2('fooValue');   // WHERE sht_text2 = 'fooValue'
     * $query->filterByShtText2('%fooValue%'); // WHERE sht_text2 LIKE '%fooValue%'
     * </code>
     *
     * @param     string $shtText2 The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildHfproductsQuery The current query, for fluid interface
     */
    public function filterByShtText2($shtText2 = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($shtText2)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $shtText2)) {
                $shtText2 = str_replace('*', '%', $shtText2);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(HfproductsTableMap::SHT_TEXT2, $shtText2, $comparison);
    }

    /**
     * Filter the query on the oag_product column
     *
     * Example usage:
     * <code>
     * $query->filterByOagProduct(true); // WHERE oag_product = true
     * $query->filterByOagProduct('yes'); // WHERE oag_product = true
     * </code>
     *
     * @param     boolean|string $oagProduct The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildHfproductsQuery The current query, for fluid interface
     */
    public function filterByOagProduct($oagProduct = null, $comparison = null)
    {
        if (is_string($oagProduct)) {
            $oag_product = in_array(strtolower($oagProduct), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(HfproductsTableMap::OAG_PRODUCT, $oagProduct, $comparison);
    }

    /**
     * Filter the query on the oag_id column
     *
     * Example usage:
     * <code>
     * $query->filterByOagId('fooValue');   // WHERE oag_id = 'fooValue'
     * $query->filterByOagId('%fooValue%'); // WHERE oag_id LIKE '%fooValue%'
     * </code>
     *
     * @param     string $oagId The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildHfproductsQuery The current query, for fluid interface
     */
    public function filterByOagId($oagId = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($oagId)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $oagId)) {
                $oagId = str_replace('*', '%', $oagId);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(HfproductsTableMap::OAG_ID, $oagId, $comparison);
    }

    /**
     * Filter the query on the oag_category column
     *
     * Example usage:
     * <code>
     * $query->filterByOagCategory(1234); // WHERE oag_category = 1234
     * $query->filterByOagCategory(array(12, 34)); // WHERE oag_category IN (12, 34)
     * $query->filterByOagCategory(array('min' => 12)); // WHERE oag_category > 12
     * </code>
     *
     * @param     mixed $oagCategory The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildHfproductsQuery The current query, for fluid interface
     */
    public function filterByOagCategory($oagCategory = null, $comparison = null)
    {
        if (is_array($oagCategory)) {
            $useMinMax = false;
            if (isset($oagCategory['min'])) {
                $this->addUsingAlias(HfproductsTableMap::OAG_CATEGORY, $oagCategory['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($oagCategory['max'])) {
                $this->addUsingAlias(HfproductsTableMap::OAG_CATEGORY, $oagCategory['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(HfproductsTableMap::OAG_CATEGORY, $oagCategory, $comparison);
    }

    /**
     * Filter the query on the oag_text1 column
     *
     * Example usage:
     * <code>
     * $query->filterByOagText1('fooValue');   // WHERE oag_text1 = 'fooValue'
     * $query->filterByOagText1('%fooValue%'); // WHERE oag_text1 LIKE '%fooValue%'
     * </code>
     *
     * @param     string $oagText1 The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildHfproductsQuery The current query, for fluid interface
     */
    public function filterByOagText1($oagText1 = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($oagText1)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $oagText1)) {
                $oagText1 = str_replace('*', '%', $oagText1);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(HfproductsTableMap::OAG_TEXT1, $oagText1, $comparison);
    }

    /**
     * Filter the query on the oag_text2 column
     *
     * Example usage:
     * <code>
     * $query->filterByOagText2('fooValue');   // WHERE oag_text2 = 'fooValue'
     * $query->filterByOagText2('%fooValue%'); // WHERE oag_text2 LIKE '%fooValue%'
     * </code>
     *
     * @param     string $oagText2 The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildHfproductsQuery The current query, for fluid interface
     */
    public function filterByOagText2($oagText2 = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($oagText2)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $oagText2)) {
                $oagText2 = str_replace('*', '%', $oagText2);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(HfproductsTableMap::OAG_TEXT2, $oagText2, $comparison);
    }

    /**
     * Filter the query on the megabild_id column
     *
     * Example usage:
     * <code>
     * $query->filterByMegabildId(1234); // WHERE megabild_id = 1234
     * $query->filterByMegabildId(array(12, 34)); // WHERE megabild_id IN (12, 34)
     * $query->filterByMegabildId(array('min' => 12)); // WHERE megabild_id > 12
     * </code>
     *
     * @param     mixed $megabildId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildHfproductsQuery The current query, for fluid interface
     */
    public function filterByMegabildId($megabildId = null, $comparison = null)
    {
        if (is_array($megabildId)) {
            $useMinMax = false;
            if (isset($megabildId['min'])) {
                $this->addUsingAlias(HfproductsTableMap::MEGABILD_ID, $megabildId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($megabildId['max'])) {
                $this->addUsingAlias(HfproductsTableMap::MEGABILD_ID, $megabildId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(HfproductsTableMap::MEGABILD_ID, $megabildId, $comparison);
    }

    /**
     * Filter the query on the image column
     *
     * Example usage:
     * <code>
     * $query->filterByImage('fooValue');   // WHERE image = 'fooValue'
     * $query->filterByImage('%fooValue%'); // WHERE image LIKE '%fooValue%'
     * </code>
     *
     * @param     string $image The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildHfproductsQuery The current query, for fluid interface
     */
    public function filterByImage($image = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($image)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $image)) {
                $image = str_replace('*', '%', $image);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(HfproductsTableMap::IMAGE, $image, $comparison);
    }

    /**
     * Filter the query on the specification_name column
     *
     * Example usage:
     * <code>
     * $query->filterBySpecificationName('fooValue');   // WHERE specification_name = 'fooValue'
     * $query->filterBySpecificationName('%fooValue%'); // WHERE specification_name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $specificationName The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildHfproductsQuery The current query, for fluid interface
     */
    public function filterBySpecificationName($specificationName = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($specificationName)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $specificationName)) {
                $specificationName = str_replace('*', '%', $specificationName);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(HfproductsTableMap::SPECIFICATION_NAME, $specificationName, $comparison);
    }

    /**
     * Filter the query on the label_name column
     *
     * Example usage:
     * <code>
     * $query->filterByLabelName('fooValue');   // WHERE label_name = 'fooValue'
     * $query->filterByLabelName('%fooValue%'); // WHERE label_name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $labelName The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildHfproductsQuery The current query, for fluid interface
     */
    public function filterByLabelName($labelName = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($labelName)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $labelName)) {
                $labelName = str_replace('*', '%', $labelName);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(HfproductsTableMap::LABEL_NAME, $labelName, $comparison);
    }

    /**
     * Filter the query on the water_heater_energy_class column
     *
     * Example usage:
     * <code>
     * $query->filterByWaterHeaterEnergyClass('fooValue');   // WHERE water_heater_energy_class = 'fooValue'
     * $query->filterByWaterHeaterEnergyClass('%fooValue%'); // WHERE water_heater_energy_class LIKE '%fooValue%'
     * </code>
     *
     * @param     string $waterHeaterEnergyClass The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildHfproductsQuery The current query, for fluid interface
     */
    public function filterByWaterHeaterEnergyClass($waterHeaterEnergyClass = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($waterHeaterEnergyClass)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $waterHeaterEnergyClass)) {
                $waterHeaterEnergyClass = str_replace('*', '%', $waterHeaterEnergyClass);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(HfproductsTableMap::WATER_HEATER_ENERGY_CLASS, $waterHeaterEnergyClass, $comparison);
    }

    /**
     * Filter the query on the water_heater_energy_efficiency column
     *
     * Example usage:
     * <code>
     * $query->filterByWaterHeaterEnergyEfficiency(1234); // WHERE water_heater_energy_efficiency = 1234
     * $query->filterByWaterHeaterEnergyEfficiency(array(12, 34)); // WHERE water_heater_energy_efficiency IN (12, 34)
     * $query->filterByWaterHeaterEnergyEfficiency(array('min' => 12)); // WHERE water_heater_energy_efficiency > 12
     * </code>
     *
     * @param     mixed $waterHeaterEnergyEfficiency The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildHfproductsQuery The current query, for fluid interface
     */
    public function filterByWaterHeaterEnergyEfficiency($waterHeaterEnergyEfficiency = null, $comparison = null)
    {
        if (is_array($waterHeaterEnergyEfficiency)) {
            $useMinMax = false;
            if (isset($waterHeaterEnergyEfficiency['min'])) {
                $this->addUsingAlias(HfproductsTableMap::WATER_HEATER_ENERGY_EFFICIENCY, $waterHeaterEnergyEfficiency['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($waterHeaterEnergyEfficiency['max'])) {
                $this->addUsingAlias(HfproductsTableMap::WATER_HEATER_ENERGY_EFFICIENCY, $waterHeaterEnergyEfficiency['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(HfproductsTableMap::WATER_HEATER_ENERGY_EFFICIENCY, $waterHeaterEnergyEfficiency, $comparison);
    }

    /**
     * Filter the query on the water_heater_energy_grade column
     *
     * Example usage:
     * <code>
     * $query->filterByWaterHeaterEnergyGrade('fooValue');   // WHERE water_heater_energy_grade = 'fooValue'
     * $query->filterByWaterHeaterEnergyGrade('%fooValue%'); // WHERE water_heater_energy_grade LIKE '%fooValue%'
     * </code>
     *
     * @param     string $waterHeaterEnergyGrade The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildHfproductsQuery The current query, for fluid interface
     */
    public function filterByWaterHeaterEnergyGrade($waterHeaterEnergyGrade = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($waterHeaterEnergyGrade)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $waterHeaterEnergyGrade)) {
                $waterHeaterEnergyGrade = str_replace('*', '%', $waterHeaterEnergyGrade);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(HfproductsTableMap::WATER_HEATER_ENERGY_GRADE, $waterHeaterEnergyGrade, $comparison);
    }

    /**
     * Filter the query on the space_heater_efficiency column
     *
     * Example usage:
     * <code>
     * $query->filterBySpaceHeaterEfficiency(1234); // WHERE space_heater_efficiency = 1234
     * $query->filterBySpaceHeaterEfficiency(array(12, 34)); // WHERE space_heater_efficiency IN (12, 34)
     * $query->filterBySpaceHeaterEfficiency(array('min' => 12)); // WHERE space_heater_efficiency > 12
     * </code>
     *
     * @param     mixed $spaceHeaterEfficiency The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildHfproductsQuery The current query, for fluid interface
     */
    public function filterBySpaceHeaterEfficiency($spaceHeaterEfficiency = null, $comparison = null)
    {
        if (is_array($spaceHeaterEfficiency)) {
            $useMinMax = false;
            if (isset($spaceHeaterEfficiency['min'])) {
                $this->addUsingAlias(HfproductsTableMap::SPACE_HEATER_EFFICIENCY, $spaceHeaterEfficiency['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($spaceHeaterEfficiency['max'])) {
                $this->addUsingAlias(HfproductsTableMap::SPACE_HEATER_EFFICIENCY, $spaceHeaterEfficiency['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(HfproductsTableMap::SPACE_HEATER_EFFICIENCY, $spaceHeaterEfficiency, $comparison);
    }

    /**
     * Filter the query on the space_heater_power column
     *
     * Example usage:
     * <code>
     * $query->filterBySpaceHeaterPower(1234); // WHERE space_heater_power = 1234
     * $query->filterBySpaceHeaterPower(array(12, 34)); // WHERE space_heater_power IN (12, 34)
     * $query->filterBySpaceHeaterPower(array('min' => 12)); // WHERE space_heater_power > 12
     * </code>
     *
     * @param     mixed $spaceHeaterPower The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildHfproductsQuery The current query, for fluid interface
     */
    public function filterBySpaceHeaterPower($spaceHeaterPower = null, $comparison = null)
    {
        if (is_array($spaceHeaterPower)) {
            $useMinMax = false;
            if (isset($spaceHeaterPower['min'])) {
                $this->addUsingAlias(HfproductsTableMap::SPACE_HEATER_POWER, $spaceHeaterPower['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($spaceHeaterPower['max'])) {
                $this->addUsingAlias(HfproductsTableMap::SPACE_HEATER_POWER, $spaceHeaterPower['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(HfproductsTableMap::SPACE_HEATER_POWER, $spaceHeaterPower, $comparison);
    }

    /**
     * Filter the query on the space_heater_type column
     *
     * Example usage:
     * <code>
     * $query->filterBySpaceHeaterType('fooValue');   // WHERE space_heater_type = 'fooValue'
     * $query->filterBySpaceHeaterType('%fooValue%'); // WHERE space_heater_type LIKE '%fooValue%'
     * </code>
     *
     * @param     string $spaceHeaterType The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildHfproductsQuery The current query, for fluid interface
     */
    public function filterBySpaceHeaterType($spaceHeaterType = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($spaceHeaterType)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $spaceHeaterType)) {
                $spaceHeaterType = str_replace('*', '%', $spaceHeaterType);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(HfproductsTableMap::SPACE_HEATER_TYPE, $spaceHeaterType, $comparison);
    }

    /**
     * Filter the query on the space_heater_low_temperature_heat_pump column
     *
     * Example usage:
     * <code>
     * $query->filterBySpaceHeaterLowTemperatureHeatPump(true); // WHERE space_heater_low_temperature_heat_pump = true
     * $query->filterBySpaceHeaterLowTemperatureHeatPump('yes'); // WHERE space_heater_low_temperature_heat_pump = true
     * </code>
     *
     * @param     boolean|string $spaceHeaterLowTemperatureHeatPump The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildHfproductsQuery The current query, for fluid interface
     */
    public function filterBySpaceHeaterLowTemperatureHeatPump($spaceHeaterLowTemperatureHeatPump = null, $comparison = null)
    {
        if (is_string($spaceHeaterLowTemperatureHeatPump)) {
            $space_heater_low_temperature_heat_pump = in_array(strtolower($spaceHeaterLowTemperatureHeatPump), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(HfproductsTableMap::SPACE_HEATER_LOW_TEMPERATURE_HEAT_PUMP, $spaceHeaterLowTemperatureHeatPump, $comparison);
    }

    /**
     * Filter the query on the space_heater_colder_efficiency column
     *
     * Example usage:
     * <code>
     * $query->filterBySpaceHeaterColderEfficiency(1234); // WHERE space_heater_colder_efficiency = 1234
     * $query->filterBySpaceHeaterColderEfficiency(array(12, 34)); // WHERE space_heater_colder_efficiency IN (12, 34)
     * $query->filterBySpaceHeaterColderEfficiency(array('min' => 12)); // WHERE space_heater_colder_efficiency > 12
     * </code>
     *
     * @param     mixed $spaceHeaterColderEfficiency The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildHfproductsQuery The current query, for fluid interface
     */
    public function filterBySpaceHeaterColderEfficiency($spaceHeaterColderEfficiency = null, $comparison = null)
    {
        if (is_array($spaceHeaterColderEfficiency)) {
            $useMinMax = false;
            if (isset($spaceHeaterColderEfficiency['min'])) {
                $this->addUsingAlias(HfproductsTableMap::SPACE_HEATER_COLDER_EFFICIENCY, $spaceHeaterColderEfficiency['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($spaceHeaterColderEfficiency['max'])) {
                $this->addUsingAlias(HfproductsTableMap::SPACE_HEATER_COLDER_EFFICIENCY, $spaceHeaterColderEfficiency['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(HfproductsTableMap::SPACE_HEATER_COLDER_EFFICIENCY, $spaceHeaterColderEfficiency, $comparison);
    }

    /**
     * Filter the query on the space_heater_warmer_efficiency column
     *
     * Example usage:
     * <code>
     * $query->filterBySpaceHeaterWarmerEfficiency(1234); // WHERE space_heater_warmer_efficiency = 1234
     * $query->filterBySpaceHeaterWarmerEfficiency(array(12, 34)); // WHERE space_heater_warmer_efficiency IN (12, 34)
     * $query->filterBySpaceHeaterWarmerEfficiency(array('min' => 12)); // WHERE space_heater_warmer_efficiency > 12
     * </code>
     *
     * @param     mixed $spaceHeaterWarmerEfficiency The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildHfproductsQuery The current query, for fluid interface
     */
    public function filterBySpaceHeaterWarmerEfficiency($spaceHeaterWarmerEfficiency = null, $comparison = null)
    {
        if (is_array($spaceHeaterWarmerEfficiency)) {
            $useMinMax = false;
            if (isset($spaceHeaterWarmerEfficiency['min'])) {
                $this->addUsingAlias(HfproductsTableMap::SPACE_HEATER_WARMER_EFFICIENCY, $spaceHeaterWarmerEfficiency['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($spaceHeaterWarmerEfficiency['max'])) {
                $this->addUsingAlias(HfproductsTableMap::SPACE_HEATER_WARMER_EFFICIENCY, $spaceHeaterWarmerEfficiency['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(HfproductsTableMap::SPACE_HEATER_WARMER_EFFICIENCY, $spaceHeaterWarmerEfficiency, $comparison);
    }

    /**
     * Filter the query on the space_heater_low_temperature_grade column
     *
     * Example usage:
     * <code>
     * $query->filterBySpaceHeaterLowTemperatureGrade('fooValue');   // WHERE space_heater_low_temperature_grade = 'fooValue'
     * $query->filterBySpaceHeaterLowTemperatureGrade('%fooValue%'); // WHERE space_heater_low_temperature_grade LIKE '%fooValue%'
     * </code>
     *
     * @param     string $spaceHeaterLowTemperatureGrade The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildHfproductsQuery The current query, for fluid interface
     */
    public function filterBySpaceHeaterLowTemperatureGrade($spaceHeaterLowTemperatureGrade = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($spaceHeaterLowTemperatureGrade)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $spaceHeaterLowTemperatureGrade)) {
                $spaceHeaterLowTemperatureGrade = str_replace('*', '%', $spaceHeaterLowTemperatureGrade);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(HfproductsTableMap::SPACE_HEATER_LOW_TEMPERATURE_GRADE, $spaceHeaterLowTemperatureGrade, $comparison);
    }

    /**
     * Filter the query on the space_heater_low_temperature_efficiency column
     *
     * Example usage:
     * <code>
     * $query->filterBySpaceHeaterLowTemperatureEfficiency(1234); // WHERE space_heater_low_temperature_efficiency = 1234
     * $query->filterBySpaceHeaterLowTemperatureEfficiency(array(12, 34)); // WHERE space_heater_low_temperature_efficiency IN (12, 34)
     * $query->filterBySpaceHeaterLowTemperatureEfficiency(array('min' => 12)); // WHERE space_heater_low_temperature_efficiency > 12
     * </code>
     *
     * @param     mixed $spaceHeaterLowTemperatureEfficiency The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildHfproductsQuery The current query, for fluid interface
     */
    public function filterBySpaceHeaterLowTemperatureEfficiency($spaceHeaterLowTemperatureEfficiency = null, $comparison = null)
    {
        if (is_array($spaceHeaterLowTemperatureEfficiency)) {
            $useMinMax = false;
            if (isset($spaceHeaterLowTemperatureEfficiency['min'])) {
                $this->addUsingAlias(HfproductsTableMap::SPACE_HEATER_LOW_TEMPERATURE_EFFICIENCY, $spaceHeaterLowTemperatureEfficiency['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($spaceHeaterLowTemperatureEfficiency['max'])) {
                $this->addUsingAlias(HfproductsTableMap::SPACE_HEATER_LOW_TEMPERATURE_EFFICIENCY, $spaceHeaterLowTemperatureEfficiency['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(HfproductsTableMap::SPACE_HEATER_LOW_TEMPERATURE_EFFICIENCY, $spaceHeaterLowTemperatureEfficiency, $comparison);
    }

    /**
     * Filter the query on the space_heater_low_temperature_colder_efficiency column
     *
     * Example usage:
     * <code>
     * $query->filterBySpaceHeaterLowTemperatureColderEfficiency(1234); // WHERE space_heater_low_temperature_colder_efficiency = 1234
     * $query->filterBySpaceHeaterLowTemperatureColderEfficiency(array(12, 34)); // WHERE space_heater_low_temperature_colder_efficiency IN (12, 34)
     * $query->filterBySpaceHeaterLowTemperatureColderEfficiency(array('min' => 12)); // WHERE space_heater_low_temperature_colder_efficiency > 12
     * </code>
     *
     * @param     mixed $spaceHeaterLowTemperatureColderEfficiency The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildHfproductsQuery The current query, for fluid interface
     */
    public function filterBySpaceHeaterLowTemperatureColderEfficiency($spaceHeaterLowTemperatureColderEfficiency = null, $comparison = null)
    {
        if (is_array($spaceHeaterLowTemperatureColderEfficiency)) {
            $useMinMax = false;
            if (isset($spaceHeaterLowTemperatureColderEfficiency['min'])) {
                $this->addUsingAlias(HfproductsTableMap::SPACE_HEATER_LOW_TEMPERATURE_COLDER_EFFICIENCY, $spaceHeaterLowTemperatureColderEfficiency['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($spaceHeaterLowTemperatureColderEfficiency['max'])) {
                $this->addUsingAlias(HfproductsTableMap::SPACE_HEATER_LOW_TEMPERATURE_COLDER_EFFICIENCY, $spaceHeaterLowTemperatureColderEfficiency['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(HfproductsTableMap::SPACE_HEATER_LOW_TEMPERATURE_COLDER_EFFICIENCY, $spaceHeaterLowTemperatureColderEfficiency, $comparison);
    }

    /**
     * Filter the query on the space_heater_low_temperature_warmer_efficiency column
     *
     * Example usage:
     * <code>
     * $query->filterBySpaceHeaterLowTemperatureWarmerEfficiency(1234); // WHERE space_heater_low_temperature_warmer_efficiency = 1234
     * $query->filterBySpaceHeaterLowTemperatureWarmerEfficiency(array(12, 34)); // WHERE space_heater_low_temperature_warmer_efficiency IN (12, 34)
     * $query->filterBySpaceHeaterLowTemperatureWarmerEfficiency(array('min' => 12)); // WHERE space_heater_low_temperature_warmer_efficiency > 12
     * </code>
     *
     * @param     mixed $spaceHeaterLowTemperatureWarmerEfficiency The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildHfproductsQuery The current query, for fluid interface
     */
    public function filterBySpaceHeaterLowTemperatureWarmerEfficiency($spaceHeaterLowTemperatureWarmerEfficiency = null, $comparison = null)
    {
        if (is_array($spaceHeaterLowTemperatureWarmerEfficiency)) {
            $useMinMax = false;
            if (isset($spaceHeaterLowTemperatureWarmerEfficiency['min'])) {
                $this->addUsingAlias(HfproductsTableMap::SPACE_HEATER_LOW_TEMPERATURE_WARMER_EFFICIENCY, $spaceHeaterLowTemperatureWarmerEfficiency['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($spaceHeaterLowTemperatureWarmerEfficiency['max'])) {
                $this->addUsingAlias(HfproductsTableMap::SPACE_HEATER_LOW_TEMPERATURE_WARMER_EFFICIENCY, $spaceHeaterLowTemperatureWarmerEfficiency['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(HfproductsTableMap::SPACE_HEATER_LOW_TEMPERATURE_WARMER_EFFICIENCY, $spaceHeaterLowTemperatureWarmerEfficiency, $comparison);
    }

    /**
     * Filter the query on the space_heater_low_temperature_supplementary_power column
     *
     * Example usage:
     * <code>
     * $query->filterBySpaceHeaterLowTemperatureSupplementaryPower(1234); // WHERE space_heater_low_temperature_supplementary_power = 1234
     * $query->filterBySpaceHeaterLowTemperatureSupplementaryPower(array(12, 34)); // WHERE space_heater_low_temperature_supplementary_power IN (12, 34)
     * $query->filterBySpaceHeaterLowTemperatureSupplementaryPower(array('min' => 12)); // WHERE space_heater_low_temperature_supplementary_power > 12
     * </code>
     *
     * @param     mixed $spaceHeaterLowTemperatureSupplementaryPower The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildHfproductsQuery The current query, for fluid interface
     */
    public function filterBySpaceHeaterLowTemperatureSupplementaryPower($spaceHeaterLowTemperatureSupplementaryPower = null, $comparison = null)
    {
        if (is_array($spaceHeaterLowTemperatureSupplementaryPower)) {
            $useMinMax = false;
            if (isset($spaceHeaterLowTemperatureSupplementaryPower['min'])) {
                $this->addUsingAlias(HfproductsTableMap::SPACE_HEATER_LOW_TEMPERATURE_SUPPLEMENTARY_POWER, $spaceHeaterLowTemperatureSupplementaryPower['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($spaceHeaterLowTemperatureSupplementaryPower['max'])) {
                $this->addUsingAlias(HfproductsTableMap::SPACE_HEATER_LOW_TEMPERATURE_SUPPLEMENTARY_POWER, $spaceHeaterLowTemperatureSupplementaryPower['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(HfproductsTableMap::SPACE_HEATER_LOW_TEMPERATURE_SUPPLEMENTARY_POWER, $spaceHeaterLowTemperatureSupplementaryPower, $comparison);
    }

    /**
     * Filter the query on the space_heater_low_temperature_power column
     *
     * Example usage:
     * <code>
     * $query->filterBySpaceHeaterLowTemperaturePower(1234); // WHERE space_heater_low_temperature_power = 1234
     * $query->filterBySpaceHeaterLowTemperaturePower(array(12, 34)); // WHERE space_heater_low_temperature_power IN (12, 34)
     * $query->filterBySpaceHeaterLowTemperaturePower(array('min' => 12)); // WHERE space_heater_low_temperature_power > 12
     * </code>
     *
     * @param     mixed $spaceHeaterLowTemperaturePower The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildHfproductsQuery The current query, for fluid interface
     */
    public function filterBySpaceHeaterLowTemperaturePower($spaceHeaterLowTemperaturePower = null, $comparison = null)
    {
        if (is_array($spaceHeaterLowTemperaturePower)) {
            $useMinMax = false;
            if (isset($spaceHeaterLowTemperaturePower['min'])) {
                $this->addUsingAlias(HfproductsTableMap::SPACE_HEATER_LOW_TEMPERATURE_POWER, $spaceHeaterLowTemperaturePower['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($spaceHeaterLowTemperaturePower['max'])) {
                $this->addUsingAlias(HfproductsTableMap::SPACE_HEATER_LOW_TEMPERATURE_POWER, $spaceHeaterLowTemperaturePower['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(HfproductsTableMap::SPACE_HEATER_LOW_TEMPERATURE_POWER, $spaceHeaterLowTemperaturePower, $comparison);
    }

    /**
     * Filter the query on the solar_efficiency column
     *
     * Example usage:
     * <code>
     * $query->filterBySolarEfficiency(1234); // WHERE solar_efficiency = 1234
     * $query->filterBySolarEfficiency(array(12, 34)); // WHERE solar_efficiency IN (12, 34)
     * $query->filterBySolarEfficiency(array('min' => 12)); // WHERE solar_efficiency > 12
     * </code>
     *
     * @param     mixed $solarEfficiency The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildHfproductsQuery The current query, for fluid interface
     */
    public function filterBySolarEfficiency($solarEfficiency = null, $comparison = null)
    {
        if (is_array($solarEfficiency)) {
            $useMinMax = false;
            if (isset($solarEfficiency['min'])) {
                $this->addUsingAlias(HfproductsTableMap::SOLAR_EFFICIENCY, $solarEfficiency['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($solarEfficiency['max'])) {
                $this->addUsingAlias(HfproductsTableMap::SOLAR_EFFICIENCY, $solarEfficiency['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(HfproductsTableMap::SOLAR_EFFICIENCY, $solarEfficiency, $comparison);
    }

    /**
     * Filter the query on the solar_size column
     *
     * Example usage:
     * <code>
     * $query->filterBySolarSize(1234); // WHERE solar_size = 1234
     * $query->filterBySolarSize(array(12, 34)); // WHERE solar_size IN (12, 34)
     * $query->filterBySolarSize(array('min' => 12)); // WHERE solar_size > 12
     * </code>
     *
     * @param     mixed $solarSize The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildHfproductsQuery The current query, for fluid interface
     */
    public function filterBySolarSize($solarSize = null, $comparison = null)
    {
        if (is_array($solarSize)) {
            $useMinMax = false;
            if (isset($solarSize['min'])) {
                $this->addUsingAlias(HfproductsTableMap::SOLAR_SIZE, $solarSize['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($solarSize['max'])) {
                $this->addUsingAlias(HfproductsTableMap::SOLAR_SIZE, $solarSize['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(HfproductsTableMap::SOLAR_SIZE, $solarSize, $comparison);
    }

    /**
     * Filter the query on the solar_pump_power column
     *
     * Example usage:
     * <code>
     * $query->filterBySolarPumpPower(1234); // WHERE solar_pump_power = 1234
     * $query->filterBySolarPumpPower(array(12, 34)); // WHERE solar_pump_power IN (12, 34)
     * $query->filterBySolarPumpPower(array('min' => 12)); // WHERE solar_pump_power > 12
     * </code>
     *
     * @param     mixed $solarPumpPower The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildHfproductsQuery The current query, for fluid interface
     */
    public function filterBySolarPumpPower($solarPumpPower = null, $comparison = null)
    {
        if (is_array($solarPumpPower)) {
            $useMinMax = false;
            if (isset($solarPumpPower['min'])) {
                $this->addUsingAlias(HfproductsTableMap::SOLAR_PUMP_POWER, $solarPumpPower['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($solarPumpPower['max'])) {
                $this->addUsingAlias(HfproductsTableMap::SOLAR_PUMP_POWER, $solarPumpPower['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(HfproductsTableMap::SOLAR_PUMP_POWER, $solarPumpPower, $comparison);
    }

    /**
     * Filter the query on the storage_type column
     *
     * Example usage:
     * <code>
     * $query->filterByStorageType('fooValue');   // WHERE storage_type = 'fooValue'
     * $query->filterByStorageType('%fooValue%'); // WHERE storage_type LIKE '%fooValue%'
     * </code>
     *
     * @param     string $storageType The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildHfproductsQuery The current query, for fluid interface
     */
    public function filterByStorageType($storageType = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($storageType)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $storageType)) {
                $storageType = str_replace('*', '%', $storageType);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(HfproductsTableMap::STORAGE_TYPE, $storageType, $comparison);
    }

    /**
     * Filter the query on the storage_volume column
     *
     * Example usage:
     * <code>
     * $query->filterByStorageVolume(1234); // WHERE storage_volume = 1234
     * $query->filterByStorageVolume(array(12, 34)); // WHERE storage_volume IN (12, 34)
     * $query->filterByStorageVolume(array('min' => 12)); // WHERE storage_volume > 12
     * </code>
     *
     * @param     mixed $storageVolume The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildHfproductsQuery The current query, for fluid interface
     */
    public function filterByStorageVolume($storageVolume = null, $comparison = null)
    {
        if (is_array($storageVolume)) {
            $useMinMax = false;
            if (isset($storageVolume['min'])) {
                $this->addUsingAlias(HfproductsTableMap::STORAGE_VOLUME, $storageVolume['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($storageVolume['max'])) {
                $this->addUsingAlias(HfproductsTableMap::STORAGE_VOLUME, $storageVolume['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(HfproductsTableMap::STORAGE_VOLUME, $storageVolume, $comparison);
    }

    /**
     * Filter the query on the storage_non_solar_volume column
     *
     * Example usage:
     * <code>
     * $query->filterByStorageNonSolarVolume(1234); // WHERE storage_non_solar_volume = 1234
     * $query->filterByStorageNonSolarVolume(array(12, 34)); // WHERE storage_non_solar_volume IN (12, 34)
     * $query->filterByStorageNonSolarVolume(array('min' => 12)); // WHERE storage_non_solar_volume > 12
     * </code>
     *
     * @param     mixed $storageNonSolarVolume The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildHfproductsQuery The current query, for fluid interface
     */
    public function filterByStorageNonSolarVolume($storageNonSolarVolume = null, $comparison = null)
    {
        if (is_array($storageNonSolarVolume)) {
            $useMinMax = false;
            if (isset($storageNonSolarVolume['min'])) {
                $this->addUsingAlias(HfproductsTableMap::STORAGE_NON_SOLAR_VOLUME, $storageNonSolarVolume['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($storageNonSolarVolume['max'])) {
                $this->addUsingAlias(HfproductsTableMap::STORAGE_NON_SOLAR_VOLUME, $storageNonSolarVolume['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(HfproductsTableMap::STORAGE_NON_SOLAR_VOLUME, $storageNonSolarVolume, $comparison);
    }

    /**
     * Filter the query on the storage_warmth_loss column
     *
     * Example usage:
     * <code>
     * $query->filterByStorageWarmthLoss(1234); // WHERE storage_warmth_loss = 1234
     * $query->filterByStorageWarmthLoss(array(12, 34)); // WHERE storage_warmth_loss IN (12, 34)
     * $query->filterByStorageWarmthLoss(array('min' => 12)); // WHERE storage_warmth_loss > 12
     * </code>
     *
     * @param     mixed $storageWarmthLoss The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildHfproductsQuery The current query, for fluid interface
     */
    public function filterByStorageWarmthLoss($storageWarmthLoss = null, $comparison = null)
    {
        if (is_array($storageWarmthLoss)) {
            $useMinMax = false;
            if (isset($storageWarmthLoss['min'])) {
                $this->addUsingAlias(HfproductsTableMap::STORAGE_WARMTH_LOSS, $storageWarmthLoss['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($storageWarmthLoss['max'])) {
                $this->addUsingAlias(HfproductsTableMap::STORAGE_WARMTH_LOSS, $storageWarmthLoss['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(HfproductsTableMap::STORAGE_WARMTH_LOSS, $storageWarmthLoss, $comparison);
    }

    /**
     * Filter the query on the combination_heater_space_heater_grade column
     *
     * Example usage:
     * <code>
     * $query->filterByCombinationHeaterSpaceHeaterGrade('fooValue');   // WHERE combination_heater_space_heater_grade = 'fooValue'
     * $query->filterByCombinationHeaterSpaceHeaterGrade('%fooValue%'); // WHERE combination_heater_space_heater_grade LIKE '%fooValue%'
     * </code>
     *
     * @param     string $combinationHeaterSpaceHeaterGrade The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildHfproductsQuery The current query, for fluid interface
     */
    public function filterByCombinationHeaterSpaceHeaterGrade($combinationHeaterSpaceHeaterGrade = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($combinationHeaterSpaceHeaterGrade)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $combinationHeaterSpaceHeaterGrade)) {
                $combinationHeaterSpaceHeaterGrade = str_replace('*', '%', $combinationHeaterSpaceHeaterGrade);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(HfproductsTableMap::COMBINATION_HEATER_SPACE_HEATER_GRADE, $combinationHeaterSpaceHeaterGrade, $comparison);
    }

    /**
     * Filter the query on the combination_heater_water_heater_grade column
     *
     * Example usage:
     * <code>
     * $query->filterByCombinationHeaterWaterHeaterGrade('fooValue');   // WHERE combination_heater_water_heater_grade = 'fooValue'
     * $query->filterByCombinationHeaterWaterHeaterGrade('%fooValue%'); // WHERE combination_heater_water_heater_grade LIKE '%fooValue%'
     * </code>
     *
     * @param     string $combinationHeaterWaterHeaterGrade The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildHfproductsQuery The current query, for fluid interface
     */
    public function filterByCombinationHeaterWaterHeaterGrade($combinationHeaterWaterHeaterGrade = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($combinationHeaterWaterHeaterGrade)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $combinationHeaterWaterHeaterGrade)) {
                $combinationHeaterWaterHeaterGrade = str_replace('*', '%', $combinationHeaterWaterHeaterGrade);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(HfproductsTableMap::COMBINATION_HEATER_WATER_HEATER_GRADE, $combinationHeaterWaterHeaterGrade, $comparison);
    }

    /**
     * Filter the query on the combined_efficiency column
     *
     * Example usage:
     * <code>
     * $query->filterByCombinedEfficiency(1234); // WHERE combined_efficiency = 1234
     * $query->filterByCombinedEfficiency(array(12, 34)); // WHERE combined_efficiency IN (12, 34)
     * $query->filterByCombinedEfficiency(array('min' => 12)); // WHERE combined_efficiency > 12
     * </code>
     *
     * @param     mixed $combinedEfficiency The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildHfproductsQuery The current query, for fluid interface
     */
    public function filterByCombinedEfficiency($combinedEfficiency = null, $comparison = null)
    {
        if (is_array($combinedEfficiency)) {
            $useMinMax = false;
            if (isset($combinedEfficiency['min'])) {
                $this->addUsingAlias(HfproductsTableMap::COMBINED_EFFICIENCY, $combinedEfficiency['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($combinedEfficiency['max'])) {
                $this->addUsingAlias(HfproductsTableMap::COMBINED_EFFICIENCY, $combinedEfficiency['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(HfproductsTableMap::COMBINED_EFFICIENCY, $combinedEfficiency, $comparison);
    }

    /**
     * Filter the query on the combined_main_heater_type_id column
     *
     * Example usage:
     * <code>
     * $query->filterByCombinedMainHeaterTypeId(1234); // WHERE combined_main_heater_type_id = 1234
     * $query->filterByCombinedMainHeaterTypeId(array(12, 34)); // WHERE combined_main_heater_type_id IN (12, 34)
     * $query->filterByCombinedMainHeaterTypeId(array('min' => 12)); // WHERE combined_main_heater_type_id > 12
     * </code>
     *
     * @param     mixed $combinedMainHeaterTypeId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildHfproductsQuery The current query, for fluid interface
     */
    public function filterByCombinedMainHeaterTypeId($combinedMainHeaterTypeId = null, $comparison = null)
    {
        if (is_array($combinedMainHeaterTypeId)) {
            $useMinMax = false;
            if (isset($combinedMainHeaterTypeId['min'])) {
                $this->addUsingAlias(HfproductsTableMap::COMBINED_MAIN_HEATER_TYPE_ID, $combinedMainHeaterTypeId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($combinedMainHeaterTypeId['max'])) {
                $this->addUsingAlias(HfproductsTableMap::COMBINED_MAIN_HEATER_TYPE_ID, $combinedMainHeaterTypeId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(HfproductsTableMap::COMBINED_MAIN_HEATER_TYPE_ID, $combinedMainHeaterTypeId, $comparison);
    }

    /**
     * Filter the query on the temperature_control_standby_warmth_loss column
     *
     * Example usage:
     * <code>
     * $query->filterByTemperatureControlStandbyWarmthLoss(1234); // WHERE temperature_control_standby_warmth_loss = 1234
     * $query->filterByTemperatureControlStandbyWarmthLoss(array(12, 34)); // WHERE temperature_control_standby_warmth_loss IN (12, 34)
     * $query->filterByTemperatureControlStandbyWarmthLoss(array('min' => 12)); // WHERE temperature_control_standby_warmth_loss > 12
     * </code>
     *
     * @param     mixed $temperatureControlStandbyWarmthLoss The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildHfproductsQuery The current query, for fluid interface
     */
    public function filterByTemperatureControlStandbyWarmthLoss($temperatureControlStandbyWarmthLoss = null, $comparison = null)
    {
        if (is_array($temperatureControlStandbyWarmthLoss)) {
            $useMinMax = false;
            if (isset($temperatureControlStandbyWarmthLoss['min'])) {
                $this->addUsingAlias(HfproductsTableMap::TEMPERATURE_CONTROL_STANDBY_WARMTH_LOSS, $temperatureControlStandbyWarmthLoss['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($temperatureControlStandbyWarmthLoss['max'])) {
                $this->addUsingAlias(HfproductsTableMap::TEMPERATURE_CONTROL_STANDBY_WARMTH_LOSS, $temperatureControlStandbyWarmthLoss['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(HfproductsTableMap::TEMPERATURE_CONTROL_STANDBY_WARMTH_LOSS, $temperatureControlStandbyWarmthLoss, $comparison);
    }

    /**
     * Filter the query on the temperature_control_type column
     *
     * Example usage:
     * <code>
     * $query->filterByTemperatureControlType('fooValue');   // WHERE temperature_control_type = 'fooValue'
     * $query->filterByTemperatureControlType('%fooValue%'); // WHERE temperature_control_type LIKE '%fooValue%'
     * </code>
     *
     * @param     string $temperatureControlType The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildHfproductsQuery The current query, for fluid interface
     */
    public function filterByTemperatureControlType($temperatureControlType = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($temperatureControlType)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $temperatureControlType)) {
                $temperatureControlType = str_replace('*', '%', $temperatureControlType);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(HfproductsTableMap::TEMPERATURE_CONTROL_TYPE, $temperatureControlType, $comparison);
    }

    /**
     * Filter the query on the supplementary_power column
     *
     * Example usage:
     * <code>
     * $query->filterBySupplementaryPower(1234); // WHERE supplementary_power = 1234
     * $query->filterBySupplementaryPower(array(12, 34)); // WHERE supplementary_power IN (12, 34)
     * $query->filterBySupplementaryPower(array('min' => 12)); // WHERE supplementary_power > 12
     * </code>
     *
     * @param     mixed $supplementaryPower The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildHfproductsQuery The current query, for fluid interface
     */
    public function filterBySupplementaryPower($supplementaryPower = null, $comparison = null)
    {
        if (is_array($supplementaryPower)) {
            $useMinMax = false;
            if (isset($supplementaryPower['min'])) {
                $this->addUsingAlias(HfproductsTableMap::SUPPLEMENTARY_POWER, $supplementaryPower['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($supplementaryPower['max'])) {
                $this->addUsingAlias(HfproductsTableMap::SUPPLEMENTARY_POWER, $supplementaryPower['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(HfproductsTableMap::SUPPLEMENTARY_POWER, $supplementaryPower, $comparison);
    }

    /**
     * Filter the query on the montage_id column
     *
     * Example usage:
     * <code>
     * $query->filterByMontageId(1234); // WHERE montage_id = 1234
     * $query->filterByMontageId(array(12, 34)); // WHERE montage_id IN (12, 34)
     * $query->filterByMontageId(array('min' => 12)); // WHERE montage_id > 12
     * </code>
     *
     * @param     mixed $montageId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildHfproductsQuery The current query, for fluid interface
     */
    public function filterByMontageId($montageId = null, $comparison = null)
    {
        if (is_array($montageId)) {
            $useMinMax = false;
            if (isset($montageId['min'])) {
                $this->addUsingAlias(HfproductsTableMap::MONTAGE_ID, $montageId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($montageId['max'])) {
                $this->addUsingAlias(HfproductsTableMap::MONTAGE_ID, $montageId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(HfproductsTableMap::MONTAGE_ID, $montageId, $comparison);
    }

    /**
     * Filter the query on the price column
     *
     * Example usage:
     * <code>
     * $query->filterByPrice(1234); // WHERE price = 1234
     * $query->filterByPrice(array(12, 34)); // WHERE price IN (12, 34)
     * $query->filterByPrice(array('min' => 12)); // WHERE price > 12
     * </code>
     *
     * @param     mixed $price The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildHfproductsQuery The current query, for fluid interface
     */
    public function filterByPrice($price = null, $comparison = null)
    {
        if (is_array($price)) {
            $useMinMax = false;
            if (isset($price['min'])) {
                $this->addUsingAlias(HfproductsTableMap::PRICE, $price['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($price['max'])) {
                $this->addUsingAlias(HfproductsTableMap::PRICE, $price['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(HfproductsTableMap::PRICE, $price, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildHfproducts $hfproducts Object to remove from the list of results
     *
     * @return ChildHfproductsQuery The current query, for fluid interface
     */
    public function prune($hfproducts = null)
    {
        if ($hfproducts) {
            $this->addUsingAlias(HfproductsTableMap::ID, $hfproducts->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the hfproducts table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(HfproductsTableMap::DATABASE_NAME);
        }
        $affectedRows = 0; // initialize var to track total num of affected rows
        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            HfproductsTableMap::clearInstancePool();
            HfproductsTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildHfproducts or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildHfproducts object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
     public function delete(ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(HfproductsTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(HfproductsTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();


        HfproductsTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            HfproductsTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

} // HfproductsQuery
