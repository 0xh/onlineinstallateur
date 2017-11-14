<?php

namespace FilterConfigurator\Model\Map;

use FilterConfigurator\Model\ConfiguratorFeatures;
use FilterConfigurator\Model\ConfiguratorFeaturesQuery;
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
 * This class defines the structure of the 'configurator_features' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class ConfiguratorFeaturesTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;
    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'FilterConfigurator.Model.Map.ConfiguratorFeaturesTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'thelia';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'configurator_features';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\FilterConfigurator\\Model\\ConfiguratorFeatures';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'FilterConfigurator.Model.ConfiguratorFeatures';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 3;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 3;

    /**
     * the column name for the ID field
     */
    const ID = 'configurator_features.ID';

    /**
     * the column name for the CONFIGURATOR_ID field
     */
    const CONFIGURATOR_ID = 'configurator_features.CONFIGURATOR_ID';

    /**
     * the column name for the FEATURE_ID field
     */
    const FEATURE_ID = 'configurator_features.FEATURE_ID';

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
        self::TYPE_PHPNAME       => array('Id', 'ConfiguratorId', 'FeatureId', ),
        self::TYPE_STUDLYPHPNAME => array('id', 'configuratorId', 'featureId', ),
        self::TYPE_COLNAME       => array(ConfiguratorFeaturesTableMap::ID, ConfiguratorFeaturesTableMap::CONFIGURATOR_ID, ConfiguratorFeaturesTableMap::FEATURE_ID, ),
        self::TYPE_RAW_COLNAME   => array('ID', 'CONFIGURATOR_ID', 'FEATURE_ID', ),
        self::TYPE_FIELDNAME     => array('id', 'configurator_id', 'feature_id', ),
        self::TYPE_NUM           => array(0, 1, 2, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'ConfiguratorId' => 1, 'FeatureId' => 2, ),
        self::TYPE_STUDLYPHPNAME => array('id' => 0, 'configuratorId' => 1, 'featureId' => 2, ),
        self::TYPE_COLNAME       => array(ConfiguratorFeaturesTableMap::ID => 0, ConfiguratorFeaturesTableMap::CONFIGURATOR_ID => 1, ConfiguratorFeaturesTableMap::FEATURE_ID => 2, ),
        self::TYPE_RAW_COLNAME   => array('ID' => 0, 'CONFIGURATOR_ID' => 1, 'FEATURE_ID' => 2, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'configurator_id' => 1, 'feature_id' => 2, ),
        self::TYPE_NUM           => array(0, 1, 2, )
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
        $this->setName('configurator_features');
        $this->setPhpName('ConfiguratorFeatures');
        $this->setClassName('\\FilterConfigurator\\Model\\ConfiguratorFeatures');
        $this->setPackage('FilterConfigurator.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('CONFIGURATOR_ID', 'ConfiguratorId', 'INTEGER', 'configurator', 'ID', false, null, null);
        $this->addForeignKey('FEATURE_ID', 'FeatureId', 'INTEGER', 'feature', 'ID', false, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Configurator', '\\FilterConfigurator\\Model\\Configurator', RelationMap::MANY_TO_ONE, array('configurator_id' => 'id', ), 'CASCADE', null);
        $this->addRelation('Feature', '\\Thelia\\Model\\Feature', RelationMap::MANY_TO_ONE, array('feature_id' => 'id', ), 'CASCADE', null);
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
        return $withPrefix ? ConfiguratorFeaturesTableMap::CLASS_DEFAULT : ConfiguratorFeaturesTableMap::OM_CLASS;
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
     * @return array (ConfiguratorFeatures object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = ConfiguratorFeaturesTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = ConfiguratorFeaturesTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + ConfiguratorFeaturesTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = ConfiguratorFeaturesTableMap::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            ConfiguratorFeaturesTableMap::addInstanceToPool($obj, $key);
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
            $key = ConfiguratorFeaturesTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = ConfiguratorFeaturesTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                ConfiguratorFeaturesTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(ConfiguratorFeaturesTableMap::ID);
            $criteria->addSelectColumn(ConfiguratorFeaturesTableMap::CONFIGURATOR_ID);
            $criteria->addSelectColumn(ConfiguratorFeaturesTableMap::FEATURE_ID);
        } else {
            $criteria->addSelectColumn($alias . '.ID');
            $criteria->addSelectColumn($alias . '.CONFIGURATOR_ID');
            $criteria->addSelectColumn($alias . '.FEATURE_ID');
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
        return Propel::getServiceContainer()->getDatabaseMap(ConfiguratorFeaturesTableMap::DATABASE_NAME)->getTable(ConfiguratorFeaturesTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getServiceContainer()->getDatabaseMap(ConfiguratorFeaturesTableMap::DATABASE_NAME);
      if (!$dbMap->hasTable(ConfiguratorFeaturesTableMap::TABLE_NAME)) {
        $dbMap->addTableObject(new ConfiguratorFeaturesTableMap());
      }
    }

    /**
     * Performs a DELETE on the database, given a ConfiguratorFeatures or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ConfiguratorFeatures object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(ConfiguratorFeaturesTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \FilterConfigurator\Model\ConfiguratorFeatures) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(ConfiguratorFeaturesTableMap::DATABASE_NAME);
            $criteria->add(ConfiguratorFeaturesTableMap::ID, (array) $values, Criteria::IN);
        }

        $query = ConfiguratorFeaturesQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) { ConfiguratorFeaturesTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) { ConfiguratorFeaturesTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the configurator_features table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return ConfiguratorFeaturesQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a ConfiguratorFeatures or Criteria object.
     *
     * @param mixed               $criteria Criteria or ConfiguratorFeatures object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ConfiguratorFeaturesTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from ConfiguratorFeatures object
        }

        if ($criteria->containsKey(ConfiguratorFeaturesTableMap::ID) && $criteria->keyContainsValue(ConfiguratorFeaturesTableMap::ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.ConfiguratorFeaturesTableMap::ID.')');
        }


        // Set the correct dbName
        $query = ConfiguratorFeaturesQuery::create()->mergeWith($criteria);

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

} // ConfiguratorFeaturesTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
ConfiguratorFeaturesTableMap::buildTableMap();
