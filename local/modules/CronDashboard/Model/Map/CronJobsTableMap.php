<?php

namespace CronDashboard\Model\Map;

use CronDashboard\Model\CronJobs;
use CronDashboard\Model\CronJobsQuery;
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
 * This class defines the structure of the 'cron_jobs' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class CronJobsTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;
    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'CronDashboard.Model.Map.CronJobsTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'thelia';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'cron_jobs';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\CronDashboard\\Model\\CronJobs';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'CronDashboard.Model.CronJobs';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 11;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 11;

    /**
     * the column name for the ID field
     */
    const ID = 'cron_jobs.ID';

    /**
     * the column name for the VISIBLE field
     */
    const VISIBLE = 'cron_jobs.VISIBLE';

    /**
     * the column name for the TITLE field
     */
    const TITLE = 'cron_jobs.TITLE';

    /**
     * the column name for the COMMAND field
     */
    const COMMAND = 'cron_jobs.COMMAND';

    /**
     * the column name for the SCHEDULE field
     */
    const SCHEDULE = 'cron_jobs.SCHEDULE';

    /**
     * the column name for the RUNFLAG field
     */
    const RUNFLAG = 'cron_jobs.RUNFLAG';

    /**
     * the column name for the LASTRUN field
     */
    const LASTRUN = 'cron_jobs.LASTRUN';

    /**
     * the column name for the NEXTRUN field
     */
    const NEXTRUN = 'cron_jobs.NEXTRUN';

    /**
     * the column name for the POSITION field
     */
    const POSITION = 'cron_jobs.POSITION';

    /**
     * the column name for the CREATED_AT field
     */
    const CREATED_AT = 'cron_jobs.CREATED_AT';

    /**
     * the column name for the UPDATED_AT field
     */
    const UPDATED_AT = 'cron_jobs.UPDATED_AT';

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
        self::TYPE_PHPNAME       => array('Id', 'Visible', 'Title', 'Command', 'Schedule', 'Runflag', 'Lastrun', 'Nextrun', 'Position', 'CreatedAt', 'UpdatedAt', ),
        self::TYPE_STUDLYPHPNAME => array('id', 'visible', 'title', 'command', 'schedule', 'runflag', 'lastrun', 'nextrun', 'position', 'createdAt', 'updatedAt', ),
        self::TYPE_COLNAME       => array(CronJobsTableMap::ID, CronJobsTableMap::VISIBLE, CronJobsTableMap::TITLE, CronJobsTableMap::COMMAND, CronJobsTableMap::SCHEDULE, CronJobsTableMap::RUNFLAG, CronJobsTableMap::LASTRUN, CronJobsTableMap::NEXTRUN, CronJobsTableMap::POSITION, CronJobsTableMap::CREATED_AT, CronJobsTableMap::UPDATED_AT, ),
        self::TYPE_RAW_COLNAME   => array('ID', 'VISIBLE', 'TITLE', 'COMMAND', 'SCHEDULE', 'RUNFLAG', 'LASTRUN', 'NEXTRUN', 'POSITION', 'CREATED_AT', 'UPDATED_AT', ),
        self::TYPE_FIELDNAME     => array('id', 'visible', 'title', 'command', 'schedule', 'runflag', 'lastrun', 'nextrun', 'position', 'created_at', 'updated_at', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'Visible' => 1, 'Title' => 2, 'Command' => 3, 'Schedule' => 4, 'Runflag' => 5, 'Lastrun' => 6, 'Nextrun' => 7, 'Position' => 8, 'CreatedAt' => 9, 'UpdatedAt' => 10, ),
        self::TYPE_STUDLYPHPNAME => array('id' => 0, 'visible' => 1, 'title' => 2, 'command' => 3, 'schedule' => 4, 'runflag' => 5, 'lastrun' => 6, 'nextrun' => 7, 'position' => 8, 'createdAt' => 9, 'updatedAt' => 10, ),
        self::TYPE_COLNAME       => array(CronJobsTableMap::ID => 0, CronJobsTableMap::VISIBLE => 1, CronJobsTableMap::TITLE => 2, CronJobsTableMap::COMMAND => 3, CronJobsTableMap::SCHEDULE => 4, CronJobsTableMap::RUNFLAG => 5, CronJobsTableMap::LASTRUN => 6, CronJobsTableMap::NEXTRUN => 7, CronJobsTableMap::POSITION => 8, CronJobsTableMap::CREATED_AT => 9, CronJobsTableMap::UPDATED_AT => 10, ),
        self::TYPE_RAW_COLNAME   => array('ID' => 0, 'VISIBLE' => 1, 'TITLE' => 2, 'COMMAND' => 3, 'SCHEDULE' => 4, 'RUNFLAG' => 5, 'LASTRUN' => 6, 'NEXTRUN' => 7, 'POSITION' => 8, 'CREATED_AT' => 9, 'UPDATED_AT' => 10, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'visible' => 1, 'title' => 2, 'command' => 3, 'schedule' => 4, 'runflag' => 5, 'lastrun' => 6, 'nextrun' => 7, 'position' => 8, 'created_at' => 9, 'updated_at' => 10, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, )
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
        $this->setName('cron_jobs');
        $this->setPhpName('CronJobs');
        $this->setClassName('\\CronDashboard\\Model\\CronJobs');
        $this->setPackage('CronDashboard.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('VISIBLE', 'Visible', 'TINYINT', true, null, null);
        $this->addColumn('TITLE', 'Title', 'VARCHAR', false, 255, null);
        $this->addColumn('COMMAND', 'Command', 'LONGVARCHAR', false, null, null);
        $this->addColumn('SCHEDULE', 'Schedule', 'LONGVARCHAR', false, null, null);
        $this->addColumn('RUNFLAG', 'Runflag', 'TINYINT', false, null, null);
        $this->addColumn('LASTRUN', 'Lastrun', 'TIMESTAMP', false, null, null);
        $this->addColumn('NEXTRUN', 'Nextrun', 'TIMESTAMP', false, null, null);
        $this->addColumn('POSITION', 'Position', 'INTEGER', false, null, null);
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
        return $withPrefix ? CronJobsTableMap::CLASS_DEFAULT : CronJobsTableMap::OM_CLASS;
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
     * @return array (CronJobs object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = CronJobsTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = CronJobsTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + CronJobsTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = CronJobsTableMap::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            CronJobsTableMap::addInstanceToPool($obj, $key);
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
            $key = CronJobsTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = CronJobsTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                CronJobsTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(CronJobsTableMap::ID);
            $criteria->addSelectColumn(CronJobsTableMap::VISIBLE);
            $criteria->addSelectColumn(CronJobsTableMap::TITLE);
            $criteria->addSelectColumn(CronJobsTableMap::COMMAND);
            $criteria->addSelectColumn(CronJobsTableMap::SCHEDULE);
            $criteria->addSelectColumn(CronJobsTableMap::RUNFLAG);
            $criteria->addSelectColumn(CronJobsTableMap::LASTRUN);
            $criteria->addSelectColumn(CronJobsTableMap::NEXTRUN);
            $criteria->addSelectColumn(CronJobsTableMap::POSITION);
            $criteria->addSelectColumn(CronJobsTableMap::CREATED_AT);
            $criteria->addSelectColumn(CronJobsTableMap::UPDATED_AT);
        } else {
            $criteria->addSelectColumn($alias . '.ID');
            $criteria->addSelectColumn($alias . '.VISIBLE');
            $criteria->addSelectColumn($alias . '.TITLE');
            $criteria->addSelectColumn($alias . '.COMMAND');
            $criteria->addSelectColumn($alias . '.SCHEDULE');
            $criteria->addSelectColumn($alias . '.RUNFLAG');
            $criteria->addSelectColumn($alias . '.LASTRUN');
            $criteria->addSelectColumn($alias . '.NEXTRUN');
            $criteria->addSelectColumn($alias . '.POSITION');
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
        return Propel::getServiceContainer()->getDatabaseMap(CronJobsTableMap::DATABASE_NAME)->getTable(CronJobsTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getServiceContainer()->getDatabaseMap(CronJobsTableMap::DATABASE_NAME);
      if (!$dbMap->hasTable(CronJobsTableMap::TABLE_NAME)) {
        $dbMap->addTableObject(new CronJobsTableMap());
      }
    }

    /**
     * Performs a DELETE on the database, given a CronJobs or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or CronJobs object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(CronJobsTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \CronDashboard\Model\CronJobs) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(CronJobsTableMap::DATABASE_NAME);
            $criteria->add(CronJobsTableMap::ID, (array) $values, Criteria::IN);
        }

        $query = CronJobsQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) { CronJobsTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) { CronJobsTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the cron_jobs table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return CronJobsQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a CronJobs or Criteria object.
     *
     * @param mixed               $criteria Criteria or CronJobs object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CronJobsTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from CronJobs object
        }

        if ($criteria->containsKey(CronJobsTableMap::ID) && $criteria->keyContainsValue(CronJobsTableMap::ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.CronJobsTableMap::ID.')');
        }


        // Set the correct dbName
        $query = CronJobsQuery::create()->mergeWith($criteria);

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

} // CronJobsTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
CronJobsTableMap::buildTableMap();
