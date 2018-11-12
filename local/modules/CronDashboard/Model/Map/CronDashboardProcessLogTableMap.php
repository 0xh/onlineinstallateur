<?php

namespace CronDashboard\Model\Map;

use CronDashboard\Model\CronDashboardProcessLog;
use CronDashboard\Model\CronDashboardProcessLogQuery;
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
 * This class defines the structure of the 'cron_dashboard_process_log' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class CronDashboardProcessLogTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;
    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'CronDashboard.Model.Map.CronDashboardProcessLogTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'thelia';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'cron_dashboard_process_log';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\CronDashboard\\Model\\CronDashboardProcessLog';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'CronDashboard.Model.CronDashboardProcessLog';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 18;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 18;

    /**
     * the column name for the ID field
     */
    const ID = 'cron_dashboard_process_log.ID';

    /**
     * the column name for the LINUX_USER field
     */
    const LINUX_USER = 'cron_dashboard_process_log.LINUX_USER';

    /**
     * the column name for the LINUX_PID field
     */
    const LINUX_PID = 'cron_dashboard_process_log.LINUX_PID';

    /**
     * the column name for the PROCESS_NAME field
     */
    const PROCESS_NAME = 'cron_dashboard_process_log.PROCESS_NAME';

    /**
     * the column name for the CPU field
     */
    const CPU = 'cron_dashboard_process_log.CPU';

    /**
     * the column name for the MEM field
     */
    const MEM = 'cron_dashboard_process_log.MEM';

    /**
     * the column name for the VSZ field
     */
    const VSZ = 'cron_dashboard_process_log.VSZ';

    /**
     * the column name for the TTY field
     */
    const TTY = 'cron_dashboard_process_log.TTY';

    /**
     * the column name for the STAT field
     */
    const STAT = 'cron_dashboard_process_log.STAT';

    /**
     * the column name for the START field
     */
    const START = 'cron_dashboard_process_log.START';

    /**
     * the column name for the TIME field
     */
    const TIME = 'cron_dashboard_process_log.TIME';

    /**
     * the column name for the COMMAND field
     */
    const COMMAND = 'cron_dashboard_process_log.COMMAND';

    /**
     * the column name for the THELIA_USER_NAME field
     */
    const THELIA_USER_NAME = 'cron_dashboard_process_log.THELIA_USER_NAME';

    /**
     * the column name for the THELIA_USER_ID field
     */
    const THELIA_USER_ID = 'cron_dashboard_process_log.THELIA_USER_ID';

    /**
     * the column name for the ACTION_TRIGGERED field
     */
    const ACTION_TRIGGERED = 'cron_dashboard_process_log.ACTION_TRIGGERED';

    /**
     * the column name for the TRIGGER_TIME field
     */
    const TRIGGER_TIME = 'cron_dashboard_process_log.TRIGGER_TIME';

    /**
     * the column name for the CREATED_AT field
     */
    const CREATED_AT = 'cron_dashboard_process_log.CREATED_AT';

    /**
     * the column name for the UPDATED_AT field
     */
    const UPDATED_AT = 'cron_dashboard_process_log.UPDATED_AT';

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
        self::TYPE_PHPNAME       => array('Id', 'LinuxUser', 'LinuxPid', 'ProcessName', 'Cpu', 'Mem', 'Vsz', 'Tty', 'Stat', 'Start', 'Time', 'Command', 'TheliaUserName', 'TheliaUserId', 'ActionTriggered', 'TriggerTime', 'CreatedAt', 'UpdatedAt', ),
        self::TYPE_STUDLYPHPNAME => array('id', 'linuxUser', 'linuxPid', 'processName', 'cpu', 'mem', 'vsz', 'tty', 'stat', 'start', 'time', 'command', 'theliaUserName', 'theliaUserId', 'actionTriggered', 'triggerTime', 'createdAt', 'updatedAt', ),
        self::TYPE_COLNAME       => array(CronDashboardProcessLogTableMap::ID, CronDashboardProcessLogTableMap::LINUX_USER, CronDashboardProcessLogTableMap::LINUX_PID, CronDashboardProcessLogTableMap::PROCESS_NAME, CronDashboardProcessLogTableMap::CPU, CronDashboardProcessLogTableMap::MEM, CronDashboardProcessLogTableMap::VSZ, CronDashboardProcessLogTableMap::TTY, CronDashboardProcessLogTableMap::STAT, CronDashboardProcessLogTableMap::START, CronDashboardProcessLogTableMap::TIME, CronDashboardProcessLogTableMap::COMMAND, CronDashboardProcessLogTableMap::THELIA_USER_NAME, CronDashboardProcessLogTableMap::THELIA_USER_ID, CronDashboardProcessLogTableMap::ACTION_TRIGGERED, CronDashboardProcessLogTableMap::TRIGGER_TIME, CronDashboardProcessLogTableMap::CREATED_AT, CronDashboardProcessLogTableMap::UPDATED_AT, ),
        self::TYPE_RAW_COLNAME   => array('ID', 'LINUX_USER', 'LINUX_PID', 'PROCESS_NAME', 'CPU', 'MEM', 'VSZ', 'TTY', 'STAT', 'START', 'TIME', 'COMMAND', 'THELIA_USER_NAME', 'THELIA_USER_ID', 'ACTION_TRIGGERED', 'TRIGGER_TIME', 'CREATED_AT', 'UPDATED_AT', ),
        self::TYPE_FIELDNAME     => array('id', 'linux_user', 'linux_PID', 'process_name', 'cpu', 'mem', 'vsz', 'tty', 'stat', 'start', 'time', 'command', 'thelia_user_name', 'thelia_user_id', 'action_triggered', 'trigger_time', 'created_at', 'updated_at', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'LinuxUser' => 1, 'LinuxPid' => 2, 'ProcessName' => 3, 'Cpu' => 4, 'Mem' => 5, 'Vsz' => 6, 'Tty' => 7, 'Stat' => 8, 'Start' => 9, 'Time' => 10, 'Command' => 11, 'TheliaUserName' => 12, 'TheliaUserId' => 13, 'ActionTriggered' => 14, 'TriggerTime' => 15, 'CreatedAt' => 16, 'UpdatedAt' => 17, ),
        self::TYPE_STUDLYPHPNAME => array('id' => 0, 'linuxUser' => 1, 'linuxPid' => 2, 'processName' => 3, 'cpu' => 4, 'mem' => 5, 'vsz' => 6, 'tty' => 7, 'stat' => 8, 'start' => 9, 'time' => 10, 'command' => 11, 'theliaUserName' => 12, 'theliaUserId' => 13, 'actionTriggered' => 14, 'triggerTime' => 15, 'createdAt' => 16, 'updatedAt' => 17, ),
        self::TYPE_COLNAME       => array(CronDashboardProcessLogTableMap::ID => 0, CronDashboardProcessLogTableMap::LINUX_USER => 1, CronDashboardProcessLogTableMap::LINUX_PID => 2, CronDashboardProcessLogTableMap::PROCESS_NAME => 3, CronDashboardProcessLogTableMap::CPU => 4, CronDashboardProcessLogTableMap::MEM => 5, CronDashboardProcessLogTableMap::VSZ => 6, CronDashboardProcessLogTableMap::TTY => 7, CronDashboardProcessLogTableMap::STAT => 8, CronDashboardProcessLogTableMap::START => 9, CronDashboardProcessLogTableMap::TIME => 10, CronDashboardProcessLogTableMap::COMMAND => 11, CronDashboardProcessLogTableMap::THELIA_USER_NAME => 12, CronDashboardProcessLogTableMap::THELIA_USER_ID => 13, CronDashboardProcessLogTableMap::ACTION_TRIGGERED => 14, CronDashboardProcessLogTableMap::TRIGGER_TIME => 15, CronDashboardProcessLogTableMap::CREATED_AT => 16, CronDashboardProcessLogTableMap::UPDATED_AT => 17, ),
        self::TYPE_RAW_COLNAME   => array('ID' => 0, 'LINUX_USER' => 1, 'LINUX_PID' => 2, 'PROCESS_NAME' => 3, 'CPU' => 4, 'MEM' => 5, 'VSZ' => 6, 'TTY' => 7, 'STAT' => 8, 'START' => 9, 'TIME' => 10, 'COMMAND' => 11, 'THELIA_USER_NAME' => 12, 'THELIA_USER_ID' => 13, 'ACTION_TRIGGERED' => 14, 'TRIGGER_TIME' => 15, 'CREATED_AT' => 16, 'UPDATED_AT' => 17, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'linux_user' => 1, 'linux_PID' => 2, 'process_name' => 3, 'cpu' => 4, 'mem' => 5, 'vsz' => 6, 'tty' => 7, 'stat' => 8, 'start' => 9, 'time' => 10, 'command' => 11, 'thelia_user_name' => 12, 'thelia_user_id' => 13, 'action_triggered' => 14, 'trigger_time' => 15, 'created_at' => 16, 'updated_at' => 17, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, )
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
        $this->setName('cron_dashboard_process_log');
        $this->setPhpName('CronDashboardProcessLog');
        $this->setClassName('\\CronDashboard\\Model\\CronDashboardProcessLog');
        $this->setPackage('CronDashboard.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('LINUX_USER', 'LinuxUser', 'VARCHAR', false, 255, null);
        $this->addColumn('LINUX_PID', 'LinuxPid', 'INTEGER', false, null, null);
        $this->addColumn('PROCESS_NAME', 'ProcessName', 'VARCHAR', false, 255, null);
        $this->addColumn('CPU', 'Cpu', 'VARCHAR', false, 25, null);
        $this->addColumn('MEM', 'Mem', 'VARCHAR', false, 25, null);
        $this->addColumn('VSZ', 'Vsz', 'VARCHAR', false, 25, null);
        $this->addColumn('TTY', 'Tty', 'VARCHAR', false, 25, null);
        $this->addColumn('STAT', 'Stat', 'VARCHAR', false, 25, null);
        $this->addColumn('START', 'Start', 'VARCHAR', false, 25, null);
        $this->addColumn('TIME', 'Time', 'VARCHAR', false, 25, null);
        $this->addColumn('COMMAND', 'Command', 'VARCHAR', false, 255, null);
        $this->addColumn('THELIA_USER_NAME', 'TheliaUserName', 'VARCHAR', false, 255, null);
        $this->addColumn('THELIA_USER_ID', 'TheliaUserId', 'INTEGER', false, null, null);
        $this->addColumn('ACTION_TRIGGERED', 'ActionTriggered', 'VARCHAR', false, 25, null);
        $this->addColumn('TRIGGER_TIME', 'TriggerTime', 'TIMESTAMP', false, null, null);
        $this->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('UPDATED_AT', 'UpdatedAt', 'TIMESTAMP', false, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
    } // buildRelations()

    /**
     *
     * Gets the list of behaviors registered for this table
     *
     * @return array Associative array (name => parameters) of behaviors
     */
    public function getBehaviors()
    {
        return array(
            'timestampable' => array('create_column' => 'created_at', 'update_column' => 'updated_at', ),
        );
    } // getBehaviors()

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
        return $withPrefix ? CronDashboardProcessLogTableMap::CLASS_DEFAULT : CronDashboardProcessLogTableMap::OM_CLASS;
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
     * @return array (CronDashboardProcessLog object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = CronDashboardProcessLogTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = CronDashboardProcessLogTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + CronDashboardProcessLogTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = CronDashboardProcessLogTableMap::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            CronDashboardProcessLogTableMap::addInstanceToPool($obj, $key);
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
            $key = CronDashboardProcessLogTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = CronDashboardProcessLogTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                CronDashboardProcessLogTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(CronDashboardProcessLogTableMap::ID);
            $criteria->addSelectColumn(CronDashboardProcessLogTableMap::LINUX_USER);
            $criteria->addSelectColumn(CronDashboardProcessLogTableMap::LINUX_PID);
            $criteria->addSelectColumn(CronDashboardProcessLogTableMap::PROCESS_NAME);
            $criteria->addSelectColumn(CronDashboardProcessLogTableMap::CPU);
            $criteria->addSelectColumn(CronDashboardProcessLogTableMap::MEM);
            $criteria->addSelectColumn(CronDashboardProcessLogTableMap::VSZ);
            $criteria->addSelectColumn(CronDashboardProcessLogTableMap::TTY);
            $criteria->addSelectColumn(CronDashboardProcessLogTableMap::STAT);
            $criteria->addSelectColumn(CronDashboardProcessLogTableMap::START);
            $criteria->addSelectColumn(CronDashboardProcessLogTableMap::TIME);
            $criteria->addSelectColumn(CronDashboardProcessLogTableMap::COMMAND);
            $criteria->addSelectColumn(CronDashboardProcessLogTableMap::THELIA_USER_NAME);
            $criteria->addSelectColumn(CronDashboardProcessLogTableMap::THELIA_USER_ID);
            $criteria->addSelectColumn(CronDashboardProcessLogTableMap::ACTION_TRIGGERED);
            $criteria->addSelectColumn(CronDashboardProcessLogTableMap::TRIGGER_TIME);
            $criteria->addSelectColumn(CronDashboardProcessLogTableMap::CREATED_AT);
            $criteria->addSelectColumn(CronDashboardProcessLogTableMap::UPDATED_AT);
        } else {
            $criteria->addSelectColumn($alias . '.ID');
            $criteria->addSelectColumn($alias . '.LINUX_USER');
            $criteria->addSelectColumn($alias . '.LINUX_PID');
            $criteria->addSelectColumn($alias . '.PROCESS_NAME');
            $criteria->addSelectColumn($alias . '.CPU');
            $criteria->addSelectColumn($alias . '.MEM');
            $criteria->addSelectColumn($alias . '.VSZ');
            $criteria->addSelectColumn($alias . '.TTY');
            $criteria->addSelectColumn($alias . '.STAT');
            $criteria->addSelectColumn($alias . '.START');
            $criteria->addSelectColumn($alias . '.TIME');
            $criteria->addSelectColumn($alias . '.COMMAND');
            $criteria->addSelectColumn($alias . '.THELIA_USER_NAME');
            $criteria->addSelectColumn($alias . '.THELIA_USER_ID');
            $criteria->addSelectColumn($alias . '.ACTION_TRIGGERED');
            $criteria->addSelectColumn($alias . '.TRIGGER_TIME');
            $criteria->addSelectColumn($alias . '.CREATED_AT');
            $criteria->addSelectColumn($alias . '.UPDATED_AT');
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
        return Propel::getServiceContainer()->getDatabaseMap(CronDashboardProcessLogTableMap::DATABASE_NAME)->getTable(CronDashboardProcessLogTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getServiceContainer()->getDatabaseMap(CronDashboardProcessLogTableMap::DATABASE_NAME);
      if (!$dbMap->hasTable(CronDashboardProcessLogTableMap::TABLE_NAME)) {
        $dbMap->addTableObject(new CronDashboardProcessLogTableMap());
      }
    }

    /**
     * Performs a DELETE on the database, given a CronDashboardProcessLog or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or CronDashboardProcessLog object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(CronDashboardProcessLogTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \CronDashboard\Model\CronDashboardProcessLog) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(CronDashboardProcessLogTableMap::DATABASE_NAME);
            $criteria->add(CronDashboardProcessLogTableMap::ID, (array) $values, Criteria::IN);
        }

        $query = CronDashboardProcessLogQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) { CronDashboardProcessLogTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) { CronDashboardProcessLogTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the cron_dashboard_process_log table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return CronDashboardProcessLogQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a CronDashboardProcessLog or Criteria object.
     *
     * @param mixed               $criteria Criteria or CronDashboardProcessLog object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CronDashboardProcessLogTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from CronDashboardProcessLog object
        }

        if ($criteria->containsKey(CronDashboardProcessLogTableMap::ID) && $criteria->keyContainsValue(CronDashboardProcessLogTableMap::ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.CronDashboardProcessLogTableMap::ID.')');
        }


        // Set the correct dbName
        $query = CronDashboardProcessLogQuery::create()->mergeWith($criteria);

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

} // CronDashboardProcessLogTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
CronDashboardProcessLogTableMap::buildTableMap();
