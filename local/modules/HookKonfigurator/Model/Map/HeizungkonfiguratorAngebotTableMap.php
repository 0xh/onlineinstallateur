<?php

namespace HookKonfigurator\Model\Map;

use HookKonfigurator\Model\HeizungkonfiguratorAngebot;
use HookKonfigurator\Model\HeizungkonfiguratorAngebotQuery;
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
 * This class defines the structure of the 'heizungkonfigurator_angebot' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class HeizungkonfiguratorAngebotTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;
    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'HookKonfigurator.Model.Map.HeizungkonfiguratorAngebotTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'thelia';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'heizungkonfigurator_angebot';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\HookKonfigurator\\Model\\HeizungkonfiguratorAngebot';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'HookKonfigurator.Model.HeizungkonfiguratorAngebot';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 27;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 27;

    /**
     * the column name for the ID field
     */
    const ID = 'heizungkonfigurator_angebot.ID';

    /**
     * the column name for the USER_ID field
     */
    const USER_ID = 'heizungkonfigurator_angebot.USER_ID';

    /**
     * the column name for the PLAN_HEIZUNG field
     */
    const PLAN_HEIZUNG = 'heizungkonfigurator_angebot.PLAN_HEIZUNG';

    /**
     * the column name for the BRENNSTOFF_ZUKUNFT field
     */
    const BRENNSTOFF_ZUKUNFT = 'heizungkonfigurator_angebot.BRENNSTOFF_ZUKUNFT';

    /**
     * the column name for the GEBAEUDEART field
     */
    const GEBAEUDEART = 'heizungkonfigurator_angebot.GEBAEUDEART';

    /**
     * the column name for the BAUJAHR field
     */
    const BAUJAHR = 'heizungkonfigurator_angebot.BAUJAHR';

    /**
     * the column name for the BUILDING_ETAGEN field
     */
    const BUILDING_ETAGEN = 'heizungkonfigurator_angebot.BUILDING_ETAGEN';

    /**
     * the column name for the FLAECHE field
     */
    const FLAECHE = 'heizungkonfigurator_angebot.FLAECHE';

    /**
     * the column name for the PERSONEN_ANZAHL field
     */
    const PERSONEN_ANZAHL = 'heizungkonfigurator_angebot.PERSONEN_ANZAHL';

    /**
     * the column name for the WOHNRAUMTEMPERATUR field
     */
    const WOHNRAUMTEMPERATUR = 'heizungkonfigurator_angebot.WOHNRAUMTEMPERATUR';

    /**
     * the column name for the AUSSENTEMPERATUR field
     */
    const AUSSENTEMPERATUR = 'heizungkonfigurator_angebot.AUSSENTEMPERATUR';

    /**
     * the column name for the WAERMEDAEMMUNG field
     */
    const WAERMEDAEMMUNG = 'heizungkonfigurator_angebot.WAERMEDAEMMUNG';

    /**
     * the column name for the VERGLASTE_FENSTER field
     */
    const VERGLASTE_FENSTER = 'heizungkonfigurator_angebot.VERGLASTE_FENSTER';

    /**
     * the column name for the DACH_DAEMMUNG field
     */
    const DACH_DAEMMUNG = 'heizungkonfigurator_angebot.DACH_DAEMMUNG';

    /**
     * the column name for the GEBAEUDELAGE field
     */
    const GEBAEUDELAGE = 'heizungkonfigurator_angebot.GEBAEUDELAGE';

    /**
     * the column name for the WINDLAGE field
     */
    const WINDLAGE = 'heizungkonfigurator_angebot.WINDLAGE';

    /**
     * the column name for the ANZAHL_AUSSENWAENDE field
     */
    const ANZAHL_AUSSENWAENDE = 'heizungkonfigurator_angebot.ANZAHL_AUSSENWAENDE';

    /**
     * the column name for the ABGASFUEHRUNG field
     */
    const ABGASFUEHRUNG = 'heizungkonfigurator_angebot.ABGASFUEHRUNG';

    /**
     * the column name for the HEIZUNGSMETHODE field
     */
    const HEIZUNGSMETHODE = 'heizungkonfigurator_angebot.HEIZUNGSMETHODE';

    /**
     * the column name for the WARMWASSERVERSORGUNG field
     */
    const WARMWASSERVERSORGUNG = 'heizungkonfigurator_angebot.WARMWASSERVERSORGUNG';

    /**
     * the column name for the WASSERABFLUSS field
     */
    const WASSERABFLUSS = 'heizungkonfigurator_angebot.WASSERABFLUSS';

    /**
     * the column name for the SOLARANLAGE field
     */
    const SOLARANLAGE = 'heizungkonfigurator_angebot.SOLARANLAGE';

    /**
     * the column name for the SOLARANLAGEEXTRA field
     */
    const SOLARANLAGEEXTRA = 'heizungkonfigurator_angebot.SOLARANLAGEEXTRA';

    /**
     * the column name for the PHOTOVOLTAIK field
     */
    const PHOTOVOLTAIK = 'heizungkonfigurator_angebot.PHOTOVOLTAIK';

    /**
     * the column name for the ANMERKUNGEN field
     */
    const ANMERKUNGEN = 'heizungkonfigurator_angebot.ANMERKUNGEN';

    /**
     * the column name for the VERSION field
     */
    const VERSION = 'heizungkonfigurator_angebot.VERSION';

    /**
     * the column name for the CREATED_AT field
     */
    const CREATED_AT = 'heizungkonfigurator_angebot.CREATED_AT';

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
        self::TYPE_PHPNAME       => array('Id', 'UserId', 'PlanHeizung', 'BrennstoffZukunft', 'Gebaeudeart', 'Baujahr', 'BuildingEtagen', 'Flaeche', 'PersonenAnzahl', 'Wohnraumtemperatur', 'Aussentemperatur', 'Waermedaemmung', 'VerglasteFenster', 'DachDaemmung', 'Gebaeudelage', 'Windlage', 'AnzahlAussenwaende', 'Abgasfuehrung', 'Heizungsmethode', 'Warmwasserversorgung', 'Wasserabfluss', 'Solaranlage', 'Solaranlageextra', 'Photovoltaik', 'Anmerkungen', 'Version', 'CreatedAt', ),
        self::TYPE_STUDLYPHPNAME => array('id', 'userId', 'planHeizung', 'brennstoffZukunft', 'gebaeudeart', 'baujahr', 'buildingEtagen', 'flaeche', 'personenAnzahl', 'wohnraumtemperatur', 'aussentemperatur', 'waermedaemmung', 'verglasteFenster', 'dachDaemmung', 'gebaeudelage', 'windlage', 'anzahlAussenwaende', 'abgasfuehrung', 'heizungsmethode', 'warmwasserversorgung', 'wasserabfluss', 'solaranlage', 'solaranlageextra', 'photovoltaik', 'anmerkungen', 'version', 'createdAt', ),
        self::TYPE_COLNAME       => array(HeizungkonfiguratorAngebotTableMap::ID, HeizungkonfiguratorAngebotTableMap::USER_ID, HeizungkonfiguratorAngebotTableMap::PLAN_HEIZUNG, HeizungkonfiguratorAngebotTableMap::BRENNSTOFF_ZUKUNFT, HeizungkonfiguratorAngebotTableMap::GEBAEUDEART, HeizungkonfiguratorAngebotTableMap::BAUJAHR, HeizungkonfiguratorAngebotTableMap::BUILDING_ETAGEN, HeizungkonfiguratorAngebotTableMap::FLAECHE, HeizungkonfiguratorAngebotTableMap::PERSONEN_ANZAHL, HeizungkonfiguratorAngebotTableMap::WOHNRAUMTEMPERATUR, HeizungkonfiguratorAngebotTableMap::AUSSENTEMPERATUR, HeizungkonfiguratorAngebotTableMap::WAERMEDAEMMUNG, HeizungkonfiguratorAngebotTableMap::VERGLASTE_FENSTER, HeizungkonfiguratorAngebotTableMap::DACH_DAEMMUNG, HeizungkonfiguratorAngebotTableMap::GEBAEUDELAGE, HeizungkonfiguratorAngebotTableMap::WINDLAGE, HeizungkonfiguratorAngebotTableMap::ANZAHL_AUSSENWAENDE, HeizungkonfiguratorAngebotTableMap::ABGASFUEHRUNG, HeizungkonfiguratorAngebotTableMap::HEIZUNGSMETHODE, HeizungkonfiguratorAngebotTableMap::WARMWASSERVERSORGUNG, HeizungkonfiguratorAngebotTableMap::WASSERABFLUSS, HeizungkonfiguratorAngebotTableMap::SOLARANLAGE, HeizungkonfiguratorAngebotTableMap::SOLARANLAGEEXTRA, HeizungkonfiguratorAngebotTableMap::PHOTOVOLTAIK, HeizungkonfiguratorAngebotTableMap::ANMERKUNGEN, HeizungkonfiguratorAngebotTableMap::VERSION, HeizungkonfiguratorAngebotTableMap::CREATED_AT, ),
        self::TYPE_RAW_COLNAME   => array('ID', 'USER_ID', 'PLAN_HEIZUNG', 'BRENNSTOFF_ZUKUNFT', 'GEBAEUDEART', 'BAUJAHR', 'BUILDING_ETAGEN', 'FLAECHE', 'PERSONEN_ANZAHL', 'WOHNRAUMTEMPERATUR', 'AUSSENTEMPERATUR', 'WAERMEDAEMMUNG', 'VERGLASTE_FENSTER', 'DACH_DAEMMUNG', 'GEBAEUDELAGE', 'WINDLAGE', 'ANZAHL_AUSSENWAENDE', 'ABGASFUEHRUNG', 'HEIZUNGSMETHODE', 'WARMWASSERVERSORGUNG', 'WASSERABFLUSS', 'SOLARANLAGE', 'SOLARANLAGEEXTRA', 'PHOTOVOLTAIK', 'ANMERKUNGEN', 'VERSION', 'CREATED_AT', ),
        self::TYPE_FIELDNAME     => array('id', 'user_id', 'plan_heizung', 'brennstoff_zukunft', 'gebaeudeart', 'baujahr', 'building_etagen', 'flaeche', 'personen_anzahl', 'wohnraumtemperatur', 'aussentemperatur', 'waermedaemmung', 'verglaste_fenster', 'dach_daemmung', 'gebaeudelage', 'windlage', 'anzahl_aussenwaende', 'abgasfuehrung', 'heizungsmethode', 'warmwasserversorgung', 'wasserabfluss', 'solaranlage', 'solaranlageextra', 'photovoltaik', 'anmerkungen', 'version', 'created_at', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'UserId' => 1, 'PlanHeizung' => 2, 'BrennstoffZukunft' => 3, 'Gebaeudeart' => 4, 'Baujahr' => 5, 'BuildingEtagen' => 6, 'Flaeche' => 7, 'PersonenAnzahl' => 8, 'Wohnraumtemperatur' => 9, 'Aussentemperatur' => 10, 'Waermedaemmung' => 11, 'VerglasteFenster' => 12, 'DachDaemmung' => 13, 'Gebaeudelage' => 14, 'Windlage' => 15, 'AnzahlAussenwaende' => 16, 'Abgasfuehrung' => 17, 'Heizungsmethode' => 18, 'Warmwasserversorgung' => 19, 'Wasserabfluss' => 20, 'Solaranlage' => 21, 'Solaranlageextra' => 22, 'Photovoltaik' => 23, 'Anmerkungen' => 24, 'Version' => 25, 'CreatedAt' => 26, ),
        self::TYPE_STUDLYPHPNAME => array('id' => 0, 'userId' => 1, 'planHeizung' => 2, 'brennstoffZukunft' => 3, 'gebaeudeart' => 4, 'baujahr' => 5, 'buildingEtagen' => 6, 'flaeche' => 7, 'personenAnzahl' => 8, 'wohnraumtemperatur' => 9, 'aussentemperatur' => 10, 'waermedaemmung' => 11, 'verglasteFenster' => 12, 'dachDaemmung' => 13, 'gebaeudelage' => 14, 'windlage' => 15, 'anzahlAussenwaende' => 16, 'abgasfuehrung' => 17, 'heizungsmethode' => 18, 'warmwasserversorgung' => 19, 'wasserabfluss' => 20, 'solaranlage' => 21, 'solaranlageextra' => 22, 'photovoltaik' => 23, 'anmerkungen' => 24, 'version' => 25, 'createdAt' => 26, ),
        self::TYPE_COLNAME       => array(HeizungkonfiguratorAngebotTableMap::ID => 0, HeizungkonfiguratorAngebotTableMap::USER_ID => 1, HeizungkonfiguratorAngebotTableMap::PLAN_HEIZUNG => 2, HeizungkonfiguratorAngebotTableMap::BRENNSTOFF_ZUKUNFT => 3, HeizungkonfiguratorAngebotTableMap::GEBAEUDEART => 4, HeizungkonfiguratorAngebotTableMap::BAUJAHR => 5, HeizungkonfiguratorAngebotTableMap::BUILDING_ETAGEN => 6, HeizungkonfiguratorAngebotTableMap::FLAECHE => 7, HeizungkonfiguratorAngebotTableMap::PERSONEN_ANZAHL => 8, HeizungkonfiguratorAngebotTableMap::WOHNRAUMTEMPERATUR => 9, HeizungkonfiguratorAngebotTableMap::AUSSENTEMPERATUR => 10, HeizungkonfiguratorAngebotTableMap::WAERMEDAEMMUNG => 11, HeizungkonfiguratorAngebotTableMap::VERGLASTE_FENSTER => 12, HeizungkonfiguratorAngebotTableMap::DACH_DAEMMUNG => 13, HeizungkonfiguratorAngebotTableMap::GEBAEUDELAGE => 14, HeizungkonfiguratorAngebotTableMap::WINDLAGE => 15, HeizungkonfiguratorAngebotTableMap::ANZAHL_AUSSENWAENDE => 16, HeizungkonfiguratorAngebotTableMap::ABGASFUEHRUNG => 17, HeizungkonfiguratorAngebotTableMap::HEIZUNGSMETHODE => 18, HeizungkonfiguratorAngebotTableMap::WARMWASSERVERSORGUNG => 19, HeizungkonfiguratorAngebotTableMap::WASSERABFLUSS => 20, HeizungkonfiguratorAngebotTableMap::SOLARANLAGE => 21, HeizungkonfiguratorAngebotTableMap::SOLARANLAGEEXTRA => 22, HeizungkonfiguratorAngebotTableMap::PHOTOVOLTAIK => 23, HeizungkonfiguratorAngebotTableMap::ANMERKUNGEN => 24, HeizungkonfiguratorAngebotTableMap::VERSION => 25, HeizungkonfiguratorAngebotTableMap::CREATED_AT => 26, ),
        self::TYPE_RAW_COLNAME   => array('ID' => 0, 'USER_ID' => 1, 'PLAN_HEIZUNG' => 2, 'BRENNSTOFF_ZUKUNFT' => 3, 'GEBAEUDEART' => 4, 'BAUJAHR' => 5, 'BUILDING_ETAGEN' => 6, 'FLAECHE' => 7, 'PERSONEN_ANZAHL' => 8, 'WOHNRAUMTEMPERATUR' => 9, 'AUSSENTEMPERATUR' => 10, 'WAERMEDAEMMUNG' => 11, 'VERGLASTE_FENSTER' => 12, 'DACH_DAEMMUNG' => 13, 'GEBAEUDELAGE' => 14, 'WINDLAGE' => 15, 'ANZAHL_AUSSENWAENDE' => 16, 'ABGASFUEHRUNG' => 17, 'HEIZUNGSMETHODE' => 18, 'WARMWASSERVERSORGUNG' => 19, 'WASSERABFLUSS' => 20, 'SOLARANLAGE' => 21, 'SOLARANLAGEEXTRA' => 22, 'PHOTOVOLTAIK' => 23, 'ANMERKUNGEN' => 24, 'VERSION' => 25, 'CREATED_AT' => 26, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'user_id' => 1, 'plan_heizung' => 2, 'brennstoff_zukunft' => 3, 'gebaeudeart' => 4, 'baujahr' => 5, 'building_etagen' => 6, 'flaeche' => 7, 'personen_anzahl' => 8, 'wohnraumtemperatur' => 9, 'aussentemperatur' => 10, 'waermedaemmung' => 11, 'verglaste_fenster' => 12, 'dach_daemmung' => 13, 'gebaeudelage' => 14, 'windlage' => 15, 'anzahl_aussenwaende' => 16, 'abgasfuehrung' => 17, 'heizungsmethode' => 18, 'warmwasserversorgung' => 19, 'wasserabfluss' => 20, 'solaranlage' => 21, 'solaranlageextra' => 22, 'photovoltaik' => 23, 'anmerkungen' => 24, 'version' => 25, 'created_at' => 26, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, )
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
        $this->setName('heizungkonfigurator_angebot');
        $this->setPhpName('HeizungkonfiguratorAngebot');
        $this->setClassName('\\HookKonfigurator\\Model\\HeizungkonfiguratorAngebot');
        $this->setPackage('HookKonfigurator.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('USER_ID', 'UserId', 'INTEGER', true, null, null);
        $this->addColumn('PLAN_HEIZUNG', 'PlanHeizung', 'VARCHAR', true, 255, null);
        $this->addColumn('BRENNSTOFF_ZUKUNFT', 'BrennstoffZukunft', 'VARCHAR', true, 255, null);
        $this->addColumn('GEBAEUDEART', 'Gebaeudeart', 'VARCHAR', true, 255, null);
        $this->addColumn('BAUJAHR', 'Baujahr', 'INTEGER', true, null, null);
        $this->addColumn('BUILDING_ETAGEN', 'BuildingEtagen', 'INTEGER', false, 3, null);
        $this->addColumn('FLAECHE', 'Flaeche', 'INTEGER', true, null, null);
        $this->addColumn('PERSONEN_ANZAHL', 'PersonenAnzahl', 'INTEGER', true, null, null);
        $this->addColumn('WOHNRAUMTEMPERATUR', 'Wohnraumtemperatur', 'INTEGER', true, null, null);
        $this->addColumn('AUSSENTEMPERATUR', 'Aussentemperatur', 'INTEGER', true, null, null);
        $this->addColumn('WAERMEDAEMMUNG', 'Waermedaemmung', 'VARCHAR', true, 255, null);
        $this->addColumn('VERGLASTE_FENSTER', 'VerglasteFenster', 'VARCHAR', true, 255, null);
        $this->addColumn('DACH_DAEMMUNG', 'DachDaemmung', 'VARCHAR', false, 45, null);
        $this->addColumn('GEBAEUDELAGE', 'Gebaeudelage', 'VARCHAR', true, 255, null);
        $this->addColumn('WINDLAGE', 'Windlage', 'VARCHAR', true, 255, null);
        $this->addColumn('ANZAHL_AUSSENWAENDE', 'AnzahlAussenwaende', 'INTEGER', true, null, null);
        $this->addColumn('ABGASFUEHRUNG', 'Abgasfuehrung', 'VARCHAR', false, 255, null);
        $this->addColumn('HEIZUNGSMETHODE', 'Heizungsmethode', 'VARCHAR', true, 255, null);
        $this->addColumn('WARMWASSERVERSORGUNG', 'Warmwasserversorgung', 'VARCHAR', false, 45, null);
        $this->addColumn('WASSERABFLUSS', 'Wasserabfluss', 'VARCHAR', false, 45, null);
        $this->addColumn('SOLARANLAGE', 'Solaranlage', 'VARCHAR', true, 45, null);
        $this->addColumn('SOLARANLAGEEXTRA', 'Solaranlageextra', 'VARCHAR', true, 45, null);
        $this->addColumn('PHOTOVOLTAIK', 'Photovoltaik', 'VARCHAR', true, 45, null);
        $this->addColumn('ANMERKUNGEN', 'Anmerkungen', 'VARCHAR', true, 255, null);
        $this->addColumn('VERSION', 'Version', 'VARCHAR', true, 100, null);
        $this->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', true, null, null);
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
        return $withPrefix ? HeizungkonfiguratorAngebotTableMap::CLASS_DEFAULT : HeizungkonfiguratorAngebotTableMap::OM_CLASS;
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
     * @return array (HeizungkonfiguratorAngebot object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = HeizungkonfiguratorAngebotTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = HeizungkonfiguratorAngebotTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + HeizungkonfiguratorAngebotTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = HeizungkonfiguratorAngebotTableMap::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            HeizungkonfiguratorAngebotTableMap::addInstanceToPool($obj, $key);
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
            $key = HeizungkonfiguratorAngebotTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = HeizungkonfiguratorAngebotTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                HeizungkonfiguratorAngebotTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(HeizungkonfiguratorAngebotTableMap::ID);
            $criteria->addSelectColumn(HeizungkonfiguratorAngebotTableMap::USER_ID);
            $criteria->addSelectColumn(HeizungkonfiguratorAngebotTableMap::PLAN_HEIZUNG);
            $criteria->addSelectColumn(HeizungkonfiguratorAngebotTableMap::BRENNSTOFF_ZUKUNFT);
            $criteria->addSelectColumn(HeizungkonfiguratorAngebotTableMap::GEBAEUDEART);
            $criteria->addSelectColumn(HeizungkonfiguratorAngebotTableMap::BAUJAHR);
            $criteria->addSelectColumn(HeizungkonfiguratorAngebotTableMap::BUILDING_ETAGEN);
            $criteria->addSelectColumn(HeizungkonfiguratorAngebotTableMap::FLAECHE);
            $criteria->addSelectColumn(HeizungkonfiguratorAngebotTableMap::PERSONEN_ANZAHL);
            $criteria->addSelectColumn(HeizungkonfiguratorAngebotTableMap::WOHNRAUMTEMPERATUR);
            $criteria->addSelectColumn(HeizungkonfiguratorAngebotTableMap::AUSSENTEMPERATUR);
            $criteria->addSelectColumn(HeizungkonfiguratorAngebotTableMap::WAERMEDAEMMUNG);
            $criteria->addSelectColumn(HeizungkonfiguratorAngebotTableMap::VERGLASTE_FENSTER);
            $criteria->addSelectColumn(HeizungkonfiguratorAngebotTableMap::DACH_DAEMMUNG);
            $criteria->addSelectColumn(HeizungkonfiguratorAngebotTableMap::GEBAEUDELAGE);
            $criteria->addSelectColumn(HeizungkonfiguratorAngebotTableMap::WINDLAGE);
            $criteria->addSelectColumn(HeizungkonfiguratorAngebotTableMap::ANZAHL_AUSSENWAENDE);
            $criteria->addSelectColumn(HeizungkonfiguratorAngebotTableMap::ABGASFUEHRUNG);
            $criteria->addSelectColumn(HeizungkonfiguratorAngebotTableMap::HEIZUNGSMETHODE);
            $criteria->addSelectColumn(HeizungkonfiguratorAngebotTableMap::WARMWASSERVERSORGUNG);
            $criteria->addSelectColumn(HeizungkonfiguratorAngebotTableMap::WASSERABFLUSS);
            $criteria->addSelectColumn(HeizungkonfiguratorAngebotTableMap::SOLARANLAGE);
            $criteria->addSelectColumn(HeizungkonfiguratorAngebotTableMap::SOLARANLAGEEXTRA);
            $criteria->addSelectColumn(HeizungkonfiguratorAngebotTableMap::PHOTOVOLTAIK);
            $criteria->addSelectColumn(HeizungkonfiguratorAngebotTableMap::ANMERKUNGEN);
            $criteria->addSelectColumn(HeizungkonfiguratorAngebotTableMap::VERSION);
            $criteria->addSelectColumn(HeizungkonfiguratorAngebotTableMap::CREATED_AT);
        } else {
            $criteria->addSelectColumn($alias . '.ID');
            $criteria->addSelectColumn($alias . '.USER_ID');
            $criteria->addSelectColumn($alias . '.PLAN_HEIZUNG');
            $criteria->addSelectColumn($alias . '.BRENNSTOFF_ZUKUNFT');
            $criteria->addSelectColumn($alias . '.GEBAEUDEART');
            $criteria->addSelectColumn($alias . '.BAUJAHR');
            $criteria->addSelectColumn($alias . '.BUILDING_ETAGEN');
            $criteria->addSelectColumn($alias . '.FLAECHE');
            $criteria->addSelectColumn($alias . '.PERSONEN_ANZAHL');
            $criteria->addSelectColumn($alias . '.WOHNRAUMTEMPERATUR');
            $criteria->addSelectColumn($alias . '.AUSSENTEMPERATUR');
            $criteria->addSelectColumn($alias . '.WAERMEDAEMMUNG');
            $criteria->addSelectColumn($alias . '.VERGLASTE_FENSTER');
            $criteria->addSelectColumn($alias . '.DACH_DAEMMUNG');
            $criteria->addSelectColumn($alias . '.GEBAEUDELAGE');
            $criteria->addSelectColumn($alias . '.WINDLAGE');
            $criteria->addSelectColumn($alias . '.ANZAHL_AUSSENWAENDE');
            $criteria->addSelectColumn($alias . '.ABGASFUEHRUNG');
            $criteria->addSelectColumn($alias . '.HEIZUNGSMETHODE');
            $criteria->addSelectColumn($alias . '.WARMWASSERVERSORGUNG');
            $criteria->addSelectColumn($alias . '.WASSERABFLUSS');
            $criteria->addSelectColumn($alias . '.SOLARANLAGE');
            $criteria->addSelectColumn($alias . '.SOLARANLAGEEXTRA');
            $criteria->addSelectColumn($alias . '.PHOTOVOLTAIK');
            $criteria->addSelectColumn($alias . '.ANMERKUNGEN');
            $criteria->addSelectColumn($alias . '.VERSION');
            $criteria->addSelectColumn($alias . '.CREATED_AT');
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
        return Propel::getServiceContainer()->getDatabaseMap(HeizungkonfiguratorAngebotTableMap::DATABASE_NAME)->getTable(HeizungkonfiguratorAngebotTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getServiceContainer()->getDatabaseMap(HeizungkonfiguratorAngebotTableMap::DATABASE_NAME);
      if (!$dbMap->hasTable(HeizungkonfiguratorAngebotTableMap::TABLE_NAME)) {
        $dbMap->addTableObject(new HeizungkonfiguratorAngebotTableMap());
      }
    }

    /**
     * Performs a DELETE on the database, given a HeizungkonfiguratorAngebot or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or HeizungkonfiguratorAngebot object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(HeizungkonfiguratorAngebotTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \HookKonfigurator\Model\HeizungkonfiguratorAngebot) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(HeizungkonfiguratorAngebotTableMap::DATABASE_NAME);
            $criteria->add(HeizungkonfiguratorAngebotTableMap::ID, (array) $values, Criteria::IN);
        }

        $query = HeizungkonfiguratorAngebotQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) { HeizungkonfiguratorAngebotTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) { HeizungkonfiguratorAngebotTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the heizungkonfigurator_angebot table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return HeizungkonfiguratorAngebotQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a HeizungkonfiguratorAngebot or Criteria object.
     *
     * @param mixed               $criteria Criteria or HeizungkonfiguratorAngebot object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(HeizungkonfiguratorAngebotTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from HeizungkonfiguratorAngebot object
        }

        if ($criteria->containsKey(HeizungkonfiguratorAngebotTableMap::ID) && $criteria->keyContainsValue(HeizungkonfiguratorAngebotTableMap::ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.HeizungkonfiguratorAngebotTableMap::ID.')');
        }


        // Set the correct dbName
        $query = HeizungkonfiguratorAngebotQuery::create()->mergeWith($criteria);

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

} // HeizungkonfiguratorAngebotTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
HeizungkonfiguratorAngebotTableMap::buildTableMap();
