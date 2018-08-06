<?php

namespace LocalPickup\Model\Map;

use LocalPickup\Model\LocalPickup;
use LocalPickup\Model\LocalPickupQuery;
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
 * This class defines the structure of the 'local_pickup' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class LocalPickupTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;
    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'LocalPickup.Model.Map.LocalPickupTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'thelia';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'local_pickup';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\LocalPickup\\Model\\LocalPickup';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'LocalPickup.Model.LocalPickup';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 7;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 7;

    /**
     * the column name for the ID field
     */
    const ID = 'local_pickup.ID';

    /**
     * the column name for the ADDRESS field
     */
    const ADDRESS = 'local_pickup.ADDRESS';

    /**
     * the column name for the GPS_LAT field
     */
    const GPS_LAT = 'local_pickup.GPS_LAT';

    /**
     * the column name for the GPS_LONG field
     */
    const GPS_LONG = 'local_pickup.GPS_LONG';

    /**
     * the column name for the HINT field
     */
    const HINT = 'local_pickup.HINT';

    /**
     * the column name for the CREATED_AT field
     */
    const CREATED_AT = 'local_pickup.CREATED_AT';

    /**
     * the column name for the UPDATED_AT field
     */
    const UPDATED_AT = 'local_pickup.UPDATED_AT';

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
        self::TYPE_PHPNAME       => array('Id', 'Address', 'GpsLat', 'GpsLong', 'hint', 'CreatedAt', 'UpdatedAt', ),
        self::TYPE_STUDLYPHPNAME => array('id', 'address', 'gpsLat', 'gpsLong', 'hint', 'createdAt', 'updatedAt', ),
        self::TYPE_COLNAME       => array(LocalPickupTableMap::ID, LocalPickupTableMap::ADDRESS, LocalPickupTableMap::GPS_LAT, LocalPickupTableMap::GPS_LONG, LocalPickupTableMap::HINT, LocalPickupTableMap::CREATED_AT, LocalPickupTableMap::UPDATED_AT, ),
        self::TYPE_RAW_COLNAME   => array('ID', 'ADDRESS', 'GPS_LAT', 'GPS_LONG', 'HINT', 'CREATED_AT', 'UPDATED_AT', ),
        self::TYPE_FIELDNAME     => array('id', 'address', 'gps_lat', 'gps_long', 'hint', 'created_at', 'updated_at', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'Address' => 1, 'GpsLat' => 2, 'GpsLong' => 3, 'hint' => 4, 'CreatedAt' => 5, 'UpdatedAt' => 6, ),
        self::TYPE_STUDLYPHPNAME => array('id' => 0, 'address' => 1, 'gpsLat' => 2, 'gpsLong' => 3, 'hint' => 4, 'createdAt' => 5, 'updatedAt' => 6, ),
        self::TYPE_COLNAME       => array(LocalPickupTableMap::ID => 0, LocalPickupTableMap::ADDRESS => 1, LocalPickupTableMap::GPS_LAT => 2, LocalPickupTableMap::GPS_LONG => 3, LocalPickupTableMap::HINT => 4, LocalPickupTableMap::CREATED_AT => 5, LocalPickupTableMap::UPDATED_AT => 6, ),
        self::TYPE_RAW_COLNAME   => array('ID' => 0, 'ADDRESS' => 1, 'GPS_LAT' => 2, 'GPS_LONG' => 3, 'HINT' => 4, 'CREATED_AT' => 5, 'UPDATED_AT' => 6, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'address' => 1, 'gps_lat' => 2, 'gps_long' => 3, 'hint' => 4, 'created_at' => 5, 'updated_at' => 6, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, )
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
        $this->setName('local_pickup');
        $this->setPhpName('LocalPickup');
        $this->setClassName('\\LocalPickup\\Model\\LocalPickup');
        $this->setPackage('LocalPickup.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('ADDRESS', 'Address', 'VARCHAR', false, 255, null);
        $this->addColumn('GPS_LAT', 'GpsLat', 'DECIMAL', false, 18, null);
        $this->addColumn('GPS_LONG', 'GpsLong', 'DECIMAL', false, 18, null);
        $this->addColumn('HINT', 'hint', 'CLOB', false, null, null);
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
        return $withPrefix ? LocalPickupTableMap::CLASS_DEFAULT : LocalPickupTableMap::OM_CLASS;
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
     * @return array (LocalPickup object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = LocalPickupTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = LocalPickupTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + LocalPickupTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = LocalPickupTableMap::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            LocalPickupTableMap::addInstanceToPool($obj, $key);
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
            $key = LocalPickupTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = LocalPickupTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                LocalPickupTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(LocalPickupTableMap::ID);
            $criteria->addSelectColumn(LocalPickupTableMap::ADDRESS);
            $criteria->addSelectColumn(LocalPickupTableMap::GPS_LAT);
            $criteria->addSelectColumn(LocalPickupTableMap::GPS_LONG);
            $criteria->addSelectColumn(LocalPickupTableMap::HINT);
            $criteria->addSelectColumn(LocalPickupTableMap::CREATED_AT);
            $criteria->addSelectColumn(LocalPickupTableMap::UPDATED_AT);
        } else {
            $criteria->addSelectColumn($alias . '.ID');
            $criteria->addSelectColumn($alias . '.ADDRESS');
            $criteria->addSelectColumn($alias . '.GPS_LAT');
            $criteria->addSelectColumn($alias . '.GPS_LONG');
            $criteria->addSelectColumn($alias . '.HINT');
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
        return Propel::getServiceContainer()->getDatabaseMap(LocalPickupTableMap::DATABASE_NAME)->getTable(LocalPickupTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getServiceContainer()->getDatabaseMap(LocalPickupTableMap::DATABASE_NAME);
      if (!$dbMap->hasTable(LocalPickupTableMap::TABLE_NAME)) {
        $dbMap->addTableObject(new LocalPickupTableMap());
      }
    }

    /**
     * Performs a DELETE on the database, given a LocalPickup or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or LocalPickup object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(LocalPickupTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \LocalPickup\Model\LocalPickup) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(LocalPickupTableMap::DATABASE_NAME);
            $criteria->add(LocalPickupTableMap::ID, (array) $values, Criteria::IN);
        }

        $query = LocalPickupQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) { LocalPickupTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) { LocalPickupTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the local_pickup table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return LocalPickupQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a LocalPickup or Criteria object.
     *
     * @param mixed               $criteria Criteria or LocalPickup object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(LocalPickupTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from LocalPickup object
        }

        if ($criteria->containsKey(LocalPickupTableMap::ID) && $criteria->keyContainsValue(LocalPickupTableMap::ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.LocalPickupTableMap::ID.')');
        }


        // Set the correct dbName
        $query = LocalPickupQuery::create()->mergeWith($criteria);

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

} // LocalPickupTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
LocalPickupTableMap::buildTableMap();
