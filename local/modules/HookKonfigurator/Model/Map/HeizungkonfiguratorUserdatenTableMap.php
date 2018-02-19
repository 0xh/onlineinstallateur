<?php

namespace HookKonfigurator\Model\Map;

use HookKonfigurator\Model\HeizungkonfiguratorUserdaten;
use HookKonfigurator\Model\HeizungkonfiguratorUserdatenQuery;
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
 * This class defines the structure of the 'heizungkonfigurator_userdaten' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class HeizungkonfiguratorUserdatenTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;
    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'HookKonfigurator.Model.Map.HeizungkonfiguratorUserdatenTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'thelia';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'heizungkonfigurator_userdaten';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\HookKonfigurator\\Model\\HeizungkonfiguratorUserdaten';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'HookKonfigurator.Model.HeizungkonfiguratorUserdaten';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 30;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 30;

    /**
     * the column name for the ID field
     */
    const ID = 'heizungkonfigurator_userdaten.ID';

    /**
     * the column name for the USER_ID field
     */
    const USER_ID = 'heizungkonfigurator_userdaten.USER_ID';

    /**
     * the column name for the BRENNSTOFF_MOMENTAN field
     */
    const BRENNSTOFF_MOMENTAN = 'heizungkonfigurator_userdaten.BRENNSTOFF_MOMENTAN';

    /**
     * the column name for the BRENNSTOFF_ZUKUNFT field
     */
    const BRENNSTOFF_ZUKUNFT = 'heizungkonfigurator_userdaten.BRENNSTOFF_ZUKUNFT';

    /**
     * the column name for the GEBAEUDEART field
     */
    const GEBAEUDEART = 'heizungkonfigurator_userdaten.GEBAEUDEART';

    /**
     * the column name for the PERSONEN_ANZAHL field
     */
    const PERSONEN_ANZAHL = 'heizungkonfigurator_userdaten.PERSONEN_ANZAHL';

    /**
     * the column name for the BESTEHENDE_GERAET_WARMWASSER field
     */
    const BESTEHENDE_GERAET_WARMWASSER = 'heizungkonfigurator_userdaten.BESTEHENDE_GERAET_WARMWASSER';

    /**
     * the column name for the BESTEHENDE_GERAET_KW field
     */
    const BESTEHENDE_GERAET_KW = 'heizungkonfigurator_userdaten.BESTEHENDE_GERAET_KW';

    /**
     * the column name for the BAUJAHR field
     */
    const BAUJAHR = 'heizungkonfigurator_userdaten.BAUJAHR';

    /**
     * the column name for the HEIZFLAECHE field
     */
    const HEIZFLAECHE = 'heizungkonfigurator_userdaten.HEIZFLAECHE';

    /**
     * the column name for the WAERMEDAEMMUNG field
     */
    const WAERMEDAEMMUNG = 'heizungkonfigurator_userdaten.WAERMEDAEMMUNG';

    /**
     * the column name for the VERGLASTE_FENSTER field
     */
    const VERGLASTE_FENSTER = 'heizungkonfigurator_userdaten.VERGLASTE_FENSTER';

    /**
     * the column name for the GEBAEUDELAGE field
     */
    const GEBAEUDELAGE = 'heizungkonfigurator_userdaten.GEBAEUDELAGE';

    /**
     * the column name for the WINDLAGE field
     */
    const WINDLAGE = 'heizungkonfigurator_userdaten.WINDLAGE';

    /**
     * the column name for the ANZAHL_AUSSENWAENDE field
     */
    const ANZAHL_AUSSENWAENDE = 'heizungkonfigurator_userdaten.ANZAHL_AUSSENWAENDE';

    /**
     * the column name for the WOHNRAUMTEMPERATUR field
     */
    const WOHNRAUMTEMPERATUR = 'heizungkonfigurator_userdaten.WOHNRAUMTEMPERATUR';

    /**
     * the column name for the AUSSENTEMPERATUR field
     */
    const AUSSENTEMPERATUR = 'heizungkonfigurator_userdaten.AUSSENTEMPERATUR';

    /**
     * the column name for the ANMERKUNGEN field
     */
    const ANMERKUNGEN = 'heizungkonfigurator_userdaten.ANMERKUNGEN';

    /**
     * the column name for the FOTO_ID field
     */
    const FOTO_ID = 'heizungkonfigurator_userdaten.FOTO_ID';

    /**
     * the column name for the VERSION field
     */
    const VERSION = 'heizungkonfigurator_userdaten.VERSION';

    /**
     * the column name for the CREATED_AT field
     */
    const CREATED_AT = 'heizungkonfigurator_userdaten.CREATED_AT';

    /**
     * the column name for the ETAGEN field
     */
    const ETAGEN = 'heizungkonfigurator_userdaten.ETAGEN';

    /**
     * the column name for the DACH_DAEMMUNG field
     */
    const DACH_DAEMMUNG = 'heizungkonfigurator_userdaten.DACH_DAEMMUNG';

    /**
     * the column name for the ABGASFUEHRUNG field
     */
    const ABGASFUEHRUNG = 'heizungkonfigurator_userdaten.ABGASFUEHRUNG';

    /**
     * the column name for the WAERMEABGABE field
     */
    const WAERMEABGABE = 'heizungkonfigurator_userdaten.WAERMEABGABE';

    /**
     * the column name for the DUSCHWASSER field
     */
    const DUSCHWASSER = 'heizungkonfigurator_userdaten.DUSCHWASSER';

    /**
     * the column name for the WASSERABFLUSS field
     */
    const WASSERABFLUSS = 'heizungkonfigurator_userdaten.WASSERABFLUSS';

    /**
     * the column name for the WARMWASSERVERSORGUNG field
     */
    const WARMWASSERVERSORGUNG = 'heizungkonfigurator_userdaten.WARMWASSERVERSORGUNG';

    /**
     * the column name for the WARMWASSERVERSORGUNG_EXTRA field
     */
    const WARMWASSERVERSORGUNG_EXTRA = 'heizungkonfigurator_userdaten.WARMWASSERVERSORGUNG_EXTRA';

    /**
     * the column name for the WARMWASSERVERSORGUNG_EXTRA_WAERMEPUMPE field
     */
    const WARMWASSERVERSORGUNG_EXTRA_WAERMEPUMPE = 'heizungkonfigurator_userdaten.WARMWASSERVERSORGUNG_EXTRA_WAERMEPUMPE';

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
        self::TYPE_PHPNAME       => array('Id', 'UserId', 'BrennstoffMomentan', 'BrennstoffZukunft', 'Gebaeudeart', 'PersonenAnzahl', 'BestehendeGeraetWarmwasser', 'BestehendeGeraetKw', 'Baujahr', 'Heizflaeche', 'Waermedaemmung', 'VerglasteFenster', 'Gebaeudelage', 'Windlage', 'AnzahlAussenwaende', 'Wohnraumtemperatur', 'Aussentemperatur', 'Anmerkungen', 'FotoId', 'Version', 'CreatedAt', 'Etagen', 'DachDaemmung', 'Abgasfuehrung', 'Waermeabgabe', 'Duschwasser', 'Wasserabfluss', 'Warmwasserversorgung', 'WarmwasserversorgungExtra', 'WarmwasserversorgungExtraWaermepumpe', ),
        self::TYPE_STUDLYPHPNAME => array('id', 'userId', 'brennstoffMomentan', 'brennstoffZukunft', 'gebaeudeart', 'personenAnzahl', 'bestehendeGeraetWarmwasser', 'bestehendeGeraetKw', 'baujahr', 'heizflaeche', 'waermedaemmung', 'verglasteFenster', 'gebaeudelage', 'windlage', 'anzahlAussenwaende', 'wohnraumtemperatur', 'aussentemperatur', 'anmerkungen', 'fotoId', 'version', 'createdAt', 'etagen', 'dachDaemmung', 'abgasfuehrung', 'waermeabgabe', 'duschwasser', 'wasserabfluss', 'warmwasserversorgung', 'warmwasserversorgungExtra', 'warmwasserversorgungExtraWaermepumpe', ),
        self::TYPE_COLNAME       => array(HeizungkonfiguratorUserdatenTableMap::ID, HeizungkonfiguratorUserdatenTableMap::USER_ID, HeizungkonfiguratorUserdatenTableMap::BRENNSTOFF_MOMENTAN, HeizungkonfiguratorUserdatenTableMap::BRENNSTOFF_ZUKUNFT, HeizungkonfiguratorUserdatenTableMap::GEBAEUDEART, HeizungkonfiguratorUserdatenTableMap::PERSONEN_ANZAHL, HeizungkonfiguratorUserdatenTableMap::BESTEHENDE_GERAET_WARMWASSER, HeizungkonfiguratorUserdatenTableMap::BESTEHENDE_GERAET_KW, HeizungkonfiguratorUserdatenTableMap::BAUJAHR, HeizungkonfiguratorUserdatenTableMap::HEIZFLAECHE, HeizungkonfiguratorUserdatenTableMap::WAERMEDAEMMUNG, HeizungkonfiguratorUserdatenTableMap::VERGLASTE_FENSTER, HeizungkonfiguratorUserdatenTableMap::GEBAEUDELAGE, HeizungkonfiguratorUserdatenTableMap::WINDLAGE, HeizungkonfiguratorUserdatenTableMap::ANZAHL_AUSSENWAENDE, HeizungkonfiguratorUserdatenTableMap::WOHNRAUMTEMPERATUR, HeizungkonfiguratorUserdatenTableMap::AUSSENTEMPERATUR, HeizungkonfiguratorUserdatenTableMap::ANMERKUNGEN, HeizungkonfiguratorUserdatenTableMap::FOTO_ID, HeizungkonfiguratorUserdatenTableMap::VERSION, HeizungkonfiguratorUserdatenTableMap::CREATED_AT, HeizungkonfiguratorUserdatenTableMap::ETAGEN, HeizungkonfiguratorUserdatenTableMap::DACH_DAEMMUNG, HeizungkonfiguratorUserdatenTableMap::ABGASFUEHRUNG, HeizungkonfiguratorUserdatenTableMap::WAERMEABGABE, HeizungkonfiguratorUserdatenTableMap::DUSCHWASSER, HeizungkonfiguratorUserdatenTableMap::WASSERABFLUSS, HeizungkonfiguratorUserdatenTableMap::WARMWASSERVERSORGUNG, HeizungkonfiguratorUserdatenTableMap::WARMWASSERVERSORGUNG_EXTRA, HeizungkonfiguratorUserdatenTableMap::WARMWASSERVERSORGUNG_EXTRA_WAERMEPUMPE, ),
        self::TYPE_RAW_COLNAME   => array('ID', 'USER_ID', 'BRENNSTOFF_MOMENTAN', 'BRENNSTOFF_ZUKUNFT', 'GEBAEUDEART', 'PERSONEN_ANZAHL', 'BESTEHENDE_GERAET_WARMWASSER', 'BESTEHENDE_GERAET_KW', 'BAUJAHR', 'HEIZFLAECHE', 'WAERMEDAEMMUNG', 'VERGLASTE_FENSTER', 'GEBAEUDELAGE', 'WINDLAGE', 'ANZAHL_AUSSENWAENDE', 'WOHNRAUMTEMPERATUR', 'AUSSENTEMPERATUR', 'ANMERKUNGEN', 'FOTO_ID', 'VERSION', 'CREATED_AT', 'ETAGEN', 'DACH_DAEMMUNG', 'ABGASFUEHRUNG', 'WAERMEABGABE', 'DUSCHWASSER', 'WASSERABFLUSS', 'WARMWASSERVERSORGUNG', 'WARMWASSERVERSORGUNG_EXTRA', 'WARMWASSERVERSORGUNG_EXTRA_WAERMEPUMPE', ),
        self::TYPE_FIELDNAME     => array('id', 'user_id', 'brennstoff_momentan', 'brennstoff_zukunft', 'gebaeudeart', 'personen_anzahl', 'bestehende_geraet_warmwasser', 'bestehende_geraet_kw', 'baujahr', 'heizflaeche', 'waermedaemmung', 'verglaste_fenster', 'gebaeudelage', 'windlage', 'anzahl_aussenwaende', 'wohnraumtemperatur', 'aussentemperatur', 'anmerkungen', 'foto_id', 'version', 'created_at', 'etagen', 'dach_daemmung', 'abgasfuehrung', 'waermeabgabe', 'duschwasser', 'wasserabfluss', 'warmwasserversorgung', 'warmwasserversorgung_extra', 'warmwasserversorgung_extra_waermepumpe', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'UserId' => 1, 'BrennstoffMomentan' => 2, 'BrennstoffZukunft' => 3, 'Gebaeudeart' => 4, 'PersonenAnzahl' => 5, 'BestehendeGeraetWarmwasser' => 6, 'BestehendeGeraetKw' => 7, 'Baujahr' => 8, 'Heizflaeche' => 9, 'Waermedaemmung' => 10, 'VerglasteFenster' => 11, 'Gebaeudelage' => 12, 'Windlage' => 13, 'AnzahlAussenwaende' => 14, 'Wohnraumtemperatur' => 15, 'Aussentemperatur' => 16, 'Anmerkungen' => 17, 'FotoId' => 18, 'Version' => 19, 'CreatedAt' => 20, 'Etagen' => 21, 'DachDaemmung' => 22, 'Abgasfuehrung' => 23, 'Waermeabgabe' => 24, 'Duschwasser' => 25, 'Wasserabfluss' => 26, 'Warmwasserversorgung' => 27, 'WarmwasserversorgungExtra' => 28, 'WarmwasserversorgungExtraWaermepumpe' => 29, ),
        self::TYPE_STUDLYPHPNAME => array('id' => 0, 'userId' => 1, 'brennstoffMomentan' => 2, 'brennstoffZukunft' => 3, 'gebaeudeart' => 4, 'personenAnzahl' => 5, 'bestehendeGeraetWarmwasser' => 6, 'bestehendeGeraetKw' => 7, 'baujahr' => 8, 'heizflaeche' => 9, 'waermedaemmung' => 10, 'verglasteFenster' => 11, 'gebaeudelage' => 12, 'windlage' => 13, 'anzahlAussenwaende' => 14, 'wohnraumtemperatur' => 15, 'aussentemperatur' => 16, 'anmerkungen' => 17, 'fotoId' => 18, 'version' => 19, 'createdAt' => 20, 'etagen' => 21, 'dachDaemmung' => 22, 'abgasfuehrung' => 23, 'waermeabgabe' => 24, 'duschwasser' => 25, 'wasserabfluss' => 26, 'warmwasserversorgung' => 27, 'warmwasserversorgungExtra' => 28, 'warmwasserversorgungExtraWaermepumpe' => 29, ),
        self::TYPE_COLNAME       => array(HeizungkonfiguratorUserdatenTableMap::ID => 0, HeizungkonfiguratorUserdatenTableMap::USER_ID => 1, HeizungkonfiguratorUserdatenTableMap::BRENNSTOFF_MOMENTAN => 2, HeizungkonfiguratorUserdatenTableMap::BRENNSTOFF_ZUKUNFT => 3, HeizungkonfiguratorUserdatenTableMap::GEBAEUDEART => 4, HeizungkonfiguratorUserdatenTableMap::PERSONEN_ANZAHL => 5, HeizungkonfiguratorUserdatenTableMap::BESTEHENDE_GERAET_WARMWASSER => 6, HeizungkonfiguratorUserdatenTableMap::BESTEHENDE_GERAET_KW => 7, HeizungkonfiguratorUserdatenTableMap::BAUJAHR => 8, HeizungkonfiguratorUserdatenTableMap::HEIZFLAECHE => 9, HeizungkonfiguratorUserdatenTableMap::WAERMEDAEMMUNG => 10, HeizungkonfiguratorUserdatenTableMap::VERGLASTE_FENSTER => 11, HeizungkonfiguratorUserdatenTableMap::GEBAEUDELAGE => 12, HeizungkonfiguratorUserdatenTableMap::WINDLAGE => 13, HeizungkonfiguratorUserdatenTableMap::ANZAHL_AUSSENWAENDE => 14, HeizungkonfiguratorUserdatenTableMap::WOHNRAUMTEMPERATUR => 15, HeizungkonfiguratorUserdatenTableMap::AUSSENTEMPERATUR => 16, HeizungkonfiguratorUserdatenTableMap::ANMERKUNGEN => 17, HeizungkonfiguratorUserdatenTableMap::FOTO_ID => 18, HeizungkonfiguratorUserdatenTableMap::VERSION => 19, HeizungkonfiguratorUserdatenTableMap::CREATED_AT => 20, HeizungkonfiguratorUserdatenTableMap::ETAGEN => 21, HeizungkonfiguratorUserdatenTableMap::DACH_DAEMMUNG => 22, HeizungkonfiguratorUserdatenTableMap::ABGASFUEHRUNG => 23, HeizungkonfiguratorUserdatenTableMap::WAERMEABGABE => 24, HeizungkonfiguratorUserdatenTableMap::DUSCHWASSER => 25, HeizungkonfiguratorUserdatenTableMap::WASSERABFLUSS => 26, HeizungkonfiguratorUserdatenTableMap::WARMWASSERVERSORGUNG => 27, HeizungkonfiguratorUserdatenTableMap::WARMWASSERVERSORGUNG_EXTRA => 28, HeizungkonfiguratorUserdatenTableMap::WARMWASSERVERSORGUNG_EXTRA_WAERMEPUMPE => 29, ),
        self::TYPE_RAW_COLNAME   => array('ID' => 0, 'USER_ID' => 1, 'BRENNSTOFF_MOMENTAN' => 2, 'BRENNSTOFF_ZUKUNFT' => 3, 'GEBAEUDEART' => 4, 'PERSONEN_ANZAHL' => 5, 'BESTEHENDE_GERAET_WARMWASSER' => 6, 'BESTEHENDE_GERAET_KW' => 7, 'BAUJAHR' => 8, 'HEIZFLAECHE' => 9, 'WAERMEDAEMMUNG' => 10, 'VERGLASTE_FENSTER' => 11, 'GEBAEUDELAGE' => 12, 'WINDLAGE' => 13, 'ANZAHL_AUSSENWAENDE' => 14, 'WOHNRAUMTEMPERATUR' => 15, 'AUSSENTEMPERATUR' => 16, 'ANMERKUNGEN' => 17, 'FOTO_ID' => 18, 'VERSION' => 19, 'CREATED_AT' => 20, 'ETAGEN' => 21, 'DACH_DAEMMUNG' => 22, 'ABGASFUEHRUNG' => 23, 'WAERMEABGABE' => 24, 'DUSCHWASSER' => 25, 'WASSERABFLUSS' => 26, 'WARMWASSERVERSORGUNG' => 27, 'WARMWASSERVERSORGUNG_EXTRA' => 28, 'WARMWASSERVERSORGUNG_EXTRA_WAERMEPUMPE' => 29, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'user_id' => 1, 'brennstoff_momentan' => 2, 'brennstoff_zukunft' => 3, 'gebaeudeart' => 4, 'personen_anzahl' => 5, 'bestehende_geraet_warmwasser' => 6, 'bestehende_geraet_kw' => 7, 'baujahr' => 8, 'heizflaeche' => 9, 'waermedaemmung' => 10, 'verglaste_fenster' => 11, 'gebaeudelage' => 12, 'windlage' => 13, 'anzahl_aussenwaende' => 14, 'wohnraumtemperatur' => 15, 'aussentemperatur' => 16, 'anmerkungen' => 17, 'foto_id' => 18, 'version' => 19, 'created_at' => 20, 'etagen' => 21, 'dach_daemmung' => 22, 'abgasfuehrung' => 23, 'waermeabgabe' => 24, 'duschwasser' => 25, 'wasserabfluss' => 26, 'warmwasserversorgung' => 27, 'warmwasserversorgung_extra' => 28, 'warmwasserversorgung_extra_waermepumpe' => 29, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, )
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
        $this->setName('heizungkonfigurator_userdaten');
        $this->setPhpName('HeizungkonfiguratorUserdaten');
        $this->setClassName('\\HookKonfigurator\\Model\\HeizungkonfiguratorUserdaten');
        $this->setPackage('HookKonfigurator.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('USER_ID', 'UserId', 'INTEGER', true, null, null);
        $this->addColumn('BRENNSTOFF_MOMENTAN', 'BrennstoffMomentan', 'VARCHAR', true, 255, null);
        $this->addColumn('BRENNSTOFF_ZUKUNFT', 'BrennstoffZukunft', 'VARCHAR', true, 255, null);
        $this->addColumn('GEBAEUDEART', 'Gebaeudeart', 'VARCHAR', true, 255, null);
        $this->addColumn('PERSONEN_ANZAHL', 'PersonenAnzahl', 'INTEGER', true, null, null);
        $this->addColumn('BESTEHENDE_GERAET_WARMWASSER', 'BestehendeGeraetWarmwasser', 'VARCHAR', true, 255, null);
        $this->addColumn('BESTEHENDE_GERAET_KW', 'BestehendeGeraetKw', 'INTEGER', true, null, null);
        $this->addColumn('BAUJAHR', 'Baujahr', 'INTEGER', true, null, null);
        $this->addColumn('HEIZFLAECHE', 'Heizflaeche', 'INTEGER', true, null, null);
        $this->addColumn('WAERMEDAEMMUNG', 'Waermedaemmung', 'VARCHAR', true, 255, null);
        $this->addColumn('VERGLASTE_FENSTER', 'VerglasteFenster', 'VARCHAR', true, 255, null);
        $this->addColumn('GEBAEUDELAGE', 'Gebaeudelage', 'VARCHAR', true, 255, null);
        $this->addColumn('WINDLAGE', 'Windlage', 'VARCHAR', true, 255, null);
        $this->addColumn('ANZAHL_AUSSENWAENDE', 'AnzahlAussenwaende', 'INTEGER', true, null, null);
        $this->addColumn('WOHNRAUMTEMPERATUR', 'Wohnraumtemperatur', 'INTEGER', true, null, null);
        $this->addColumn('AUSSENTEMPERATUR', 'Aussentemperatur', 'INTEGER', true, null, null);
        $this->addColumn('ANMERKUNGEN', 'Anmerkungen', 'VARCHAR', true, 255, null);
        $this->addColumn('FOTO_ID', 'FotoId', 'INTEGER', true, null, null);
        $this->addColumn('VERSION', 'Version', 'VARCHAR', true, 100, null);
        $this->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', true, null, null);
        $this->addColumn('ETAGEN', 'Etagen', 'INTEGER', false, 3, null);
        $this->addColumn('DACH_DAEMMUNG', 'DachDaemmung', 'VARCHAR', false, 45, null);
        $this->addColumn('ABGASFUEHRUNG', 'Abgasfuehrung', 'VARCHAR', false, 255, null);
        $this->addColumn('WAERMEABGABE', 'Waermeabgabe', 'VARCHAR', false, 255, null);
        $this->addColumn('DUSCHWASSER', 'Duschwasser', 'VARCHAR', false, 45, null);
        $this->addColumn('WASSERABFLUSS', 'Wasserabfluss', 'VARCHAR', false, 45, null);
        $this->addColumn('WARMWASSERVERSORGUNG', 'Warmwasserversorgung', 'VARCHAR', false, 45, null);
        $this->addColumn('WARMWASSERVERSORGUNG_EXTRA', 'WarmwasserversorgungExtra', 'VARCHAR', false, 45, null);
        $this->addColumn('WARMWASSERVERSORGUNG_EXTRA_WAERMEPUMPE', 'WarmwasserversorgungExtraWaermepumpe', 'VARCHAR', false, 45, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('HeizungkonfiguratorImage', '\\HookKonfigurator\\Model\\HeizungkonfiguratorImage', RelationMap::ONE_TO_MANY, array('id' => 'heizunkskonfigurator_id', ), 'CASCADE', null, 'HeizungkonfiguratorImages');
    } // buildRelations()
    /**
     * Method to invalidate the instance pool of all tables related to heizungkonfigurator_userdaten     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
        // Invalidate objects in ".$this->getClassNameFromBuilder($joinedTableTableMapBuilder)." instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
                HeizungkonfiguratorImageTableMap::clearInstancePool();
            }

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
        return $withPrefix ? HeizungkonfiguratorUserdatenTableMap::CLASS_DEFAULT : HeizungkonfiguratorUserdatenTableMap::OM_CLASS;
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
     * @return array (HeizungkonfiguratorUserdaten object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = HeizungkonfiguratorUserdatenTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = HeizungkonfiguratorUserdatenTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + HeizungkonfiguratorUserdatenTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = HeizungkonfiguratorUserdatenTableMap::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            HeizungkonfiguratorUserdatenTableMap::addInstanceToPool($obj, $key);
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
            $key = HeizungkonfiguratorUserdatenTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = HeizungkonfiguratorUserdatenTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                HeizungkonfiguratorUserdatenTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(HeizungkonfiguratorUserdatenTableMap::ID);
            $criteria->addSelectColumn(HeizungkonfiguratorUserdatenTableMap::USER_ID);
            $criteria->addSelectColumn(HeizungkonfiguratorUserdatenTableMap::BRENNSTOFF_MOMENTAN);
            $criteria->addSelectColumn(HeizungkonfiguratorUserdatenTableMap::BRENNSTOFF_ZUKUNFT);
            $criteria->addSelectColumn(HeizungkonfiguratorUserdatenTableMap::GEBAEUDEART);
            $criteria->addSelectColumn(HeizungkonfiguratorUserdatenTableMap::PERSONEN_ANZAHL);
            $criteria->addSelectColumn(HeizungkonfiguratorUserdatenTableMap::BESTEHENDE_GERAET_WARMWASSER);
            $criteria->addSelectColumn(HeizungkonfiguratorUserdatenTableMap::BESTEHENDE_GERAET_KW);
            $criteria->addSelectColumn(HeizungkonfiguratorUserdatenTableMap::BAUJAHR);
            $criteria->addSelectColumn(HeizungkonfiguratorUserdatenTableMap::HEIZFLAECHE);
            $criteria->addSelectColumn(HeizungkonfiguratorUserdatenTableMap::WAERMEDAEMMUNG);
            $criteria->addSelectColumn(HeizungkonfiguratorUserdatenTableMap::VERGLASTE_FENSTER);
            $criteria->addSelectColumn(HeizungkonfiguratorUserdatenTableMap::GEBAEUDELAGE);
            $criteria->addSelectColumn(HeizungkonfiguratorUserdatenTableMap::WINDLAGE);
            $criteria->addSelectColumn(HeizungkonfiguratorUserdatenTableMap::ANZAHL_AUSSENWAENDE);
            $criteria->addSelectColumn(HeizungkonfiguratorUserdatenTableMap::WOHNRAUMTEMPERATUR);
            $criteria->addSelectColumn(HeizungkonfiguratorUserdatenTableMap::AUSSENTEMPERATUR);
            $criteria->addSelectColumn(HeizungkonfiguratorUserdatenTableMap::ANMERKUNGEN);
            $criteria->addSelectColumn(HeizungkonfiguratorUserdatenTableMap::FOTO_ID);
            $criteria->addSelectColumn(HeizungkonfiguratorUserdatenTableMap::VERSION);
            $criteria->addSelectColumn(HeizungkonfiguratorUserdatenTableMap::CREATED_AT);
            $criteria->addSelectColumn(HeizungkonfiguratorUserdatenTableMap::ETAGEN);
            $criteria->addSelectColumn(HeizungkonfiguratorUserdatenTableMap::DACH_DAEMMUNG);
            $criteria->addSelectColumn(HeizungkonfiguratorUserdatenTableMap::ABGASFUEHRUNG);
            $criteria->addSelectColumn(HeizungkonfiguratorUserdatenTableMap::WAERMEABGABE);
            $criteria->addSelectColumn(HeizungkonfiguratorUserdatenTableMap::DUSCHWASSER);
            $criteria->addSelectColumn(HeizungkonfiguratorUserdatenTableMap::WASSERABFLUSS);
            $criteria->addSelectColumn(HeizungkonfiguratorUserdatenTableMap::WARMWASSERVERSORGUNG);
            $criteria->addSelectColumn(HeizungkonfiguratorUserdatenTableMap::WARMWASSERVERSORGUNG_EXTRA);
            $criteria->addSelectColumn(HeizungkonfiguratorUserdatenTableMap::WARMWASSERVERSORGUNG_EXTRA_WAERMEPUMPE);
        } else {
            $criteria->addSelectColumn($alias . '.ID');
            $criteria->addSelectColumn($alias . '.USER_ID');
            $criteria->addSelectColumn($alias . '.BRENNSTOFF_MOMENTAN');
            $criteria->addSelectColumn($alias . '.BRENNSTOFF_ZUKUNFT');
            $criteria->addSelectColumn($alias . '.GEBAEUDEART');
            $criteria->addSelectColumn($alias . '.PERSONEN_ANZAHL');
            $criteria->addSelectColumn($alias . '.BESTEHENDE_GERAET_WARMWASSER');
            $criteria->addSelectColumn($alias . '.BESTEHENDE_GERAET_KW');
            $criteria->addSelectColumn($alias . '.BAUJAHR');
            $criteria->addSelectColumn($alias . '.HEIZFLAECHE');
            $criteria->addSelectColumn($alias . '.WAERMEDAEMMUNG');
            $criteria->addSelectColumn($alias . '.VERGLASTE_FENSTER');
            $criteria->addSelectColumn($alias . '.GEBAEUDELAGE');
            $criteria->addSelectColumn($alias . '.WINDLAGE');
            $criteria->addSelectColumn($alias . '.ANZAHL_AUSSENWAENDE');
            $criteria->addSelectColumn($alias . '.WOHNRAUMTEMPERATUR');
            $criteria->addSelectColumn($alias . '.AUSSENTEMPERATUR');
            $criteria->addSelectColumn($alias . '.ANMERKUNGEN');
            $criteria->addSelectColumn($alias . '.FOTO_ID');
            $criteria->addSelectColumn($alias . '.VERSION');
            $criteria->addSelectColumn($alias . '.CREATED_AT');
            $criteria->addSelectColumn($alias . '.ETAGEN');
            $criteria->addSelectColumn($alias . '.DACH_DAEMMUNG');
            $criteria->addSelectColumn($alias . '.ABGASFUEHRUNG');
            $criteria->addSelectColumn($alias . '.WAERMEABGABE');
            $criteria->addSelectColumn($alias . '.DUSCHWASSER');
            $criteria->addSelectColumn($alias . '.WASSERABFLUSS');
            $criteria->addSelectColumn($alias . '.WARMWASSERVERSORGUNG');
            $criteria->addSelectColumn($alias . '.WARMWASSERVERSORGUNG_EXTRA');
            $criteria->addSelectColumn($alias . '.WARMWASSERVERSORGUNG_EXTRA_WAERMEPUMPE');
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
        return Propel::getServiceContainer()->getDatabaseMap(HeizungkonfiguratorUserdatenTableMap::DATABASE_NAME)->getTable(HeizungkonfiguratorUserdatenTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getServiceContainer()->getDatabaseMap(HeizungkonfiguratorUserdatenTableMap::DATABASE_NAME);
      if (!$dbMap->hasTable(HeizungkonfiguratorUserdatenTableMap::TABLE_NAME)) {
        $dbMap->addTableObject(new HeizungkonfiguratorUserdatenTableMap());
      }
    }

    /**
     * Performs a DELETE on the database, given a HeizungkonfiguratorUserdaten or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or HeizungkonfiguratorUserdaten object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(HeizungkonfiguratorUserdatenTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \HookKonfigurator\Model\HeizungkonfiguratorUserdaten) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(HeizungkonfiguratorUserdatenTableMap::DATABASE_NAME);
            $criteria->add(HeizungkonfiguratorUserdatenTableMap::ID, (array) $values, Criteria::IN);
        }

        $query = HeizungkonfiguratorUserdatenQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) { HeizungkonfiguratorUserdatenTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) { HeizungkonfiguratorUserdatenTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the heizungkonfigurator_userdaten table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return HeizungkonfiguratorUserdatenQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a HeizungkonfiguratorUserdaten or Criteria object.
     *
     * @param mixed               $criteria Criteria or HeizungkonfiguratorUserdaten object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(HeizungkonfiguratorUserdatenTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from HeizungkonfiguratorUserdaten object
        }

        if ($criteria->containsKey(HeizungkonfiguratorUserdatenTableMap::ID) && $criteria->keyContainsValue(HeizungkonfiguratorUserdatenTableMap::ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.HeizungkonfiguratorUserdatenTableMap::ID.')');
        }


        // Set the correct dbName
        $query = HeizungkonfiguratorUserdatenQuery::create()->mergeWith($criteria);

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

} // HeizungkonfiguratorUserdatenTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
HeizungkonfiguratorUserdatenTableMap::buildTableMap();
