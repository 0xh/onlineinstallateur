<?php

namespace HookConfigurator\Model\Map;

use HookConfigurator\Model\ConfiguratorHook;
use HookConfigurator\Model\ConfiguratorHookQuery;
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
 * This class defines the structure of the 'configurator_hook' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class ConfiguratorHookTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;
    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'HookConfigurator.Model.Map.ConfiguratorHookTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'thelia';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'configurator_hook';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\HookConfigurator\\Model\\ConfiguratorHook';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'HookConfigurator.Model.ConfiguratorHook';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 4;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 4;

    /**
     * the column name for the ID field
     */
    const ID = 'configurator_hook.ID';

    /**
     * the column name for the CONFIGURATOR_ID field
     */
    const CONFIGURATOR_ID = 'configurator_hook.CONFIGURATOR_ID';

    /**
     * the column name for the HOOK_ID field
     */
    const HOOK_ID = 'configurator_hook.HOOK_ID';

    /**
     * the column name for the HOOK_CODE field
     */
    const HOOK_CODE = 'configurator_hook.HOOK_CODE';

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
        self::TYPE_PHPNAME       => array('Id', 'ConfiguratorId', 'HookId', 'HookCode', ),
        self::TYPE_STUDLYPHPNAME => array('id', 'configuratorId', 'hookId', 'hookCode', ),
        self::TYPE_COLNAME       => array(ConfiguratorHookTableMap::ID, ConfiguratorHookTableMap::CONFIGURATOR_ID, ConfiguratorHookTableMap::HOOK_ID, ConfiguratorHookTableMap::HOOK_CODE, ),
        self::TYPE_RAW_COLNAME   => array('ID', 'CONFIGURATOR_ID', 'HOOK_ID', 'HOOK_CODE', ),
        self::TYPE_FIELDNAME     => array('id', 'configurator_id', 'hook_id', 'hook_code', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'ConfiguratorId' => 1, 'HookId' => 2, 'HookCode' => 3, ),
        self::TYPE_STUDLYPHPNAME => array('id' => 0, 'configuratorId' => 1, 'hookId' => 2, 'hookCode' => 3, ),
        self::TYPE_COLNAME       => array(ConfiguratorHookTableMap::ID => 0, ConfiguratorHookTableMap::CONFIGURATOR_ID => 1, ConfiguratorHookTableMap::HOOK_ID => 2, ConfiguratorHookTableMap::HOOK_CODE => 3, ),
        self::TYPE_RAW_COLNAME   => array('ID' => 0, 'CONFIGURATOR_ID' => 1, 'HOOK_ID' => 2, 'HOOK_CODE' => 3, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'configurator_id' => 1, 'hook_id' => 2, 'hook_code' => 3, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, )
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
        $this->setName('configurator_hook');
        $this->setPhpName('ConfiguratorHook');
        $this->setClassName('\\HookConfigurator\\Model\\ConfiguratorHook');
        $this->setPackage('HookConfigurator.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('CONFIGURATOR_ID', 'ConfiguratorId', 'INTEGER', 'configurator', 'ID', false, null, null);
        $this->addForeignKey('HOOK_ID', 'HookId', 'INTEGER', 'hook', 'ID', false, null, null);
        $this->addColumn('HOOK_CODE', 'HookCode', 'VARCHAR', false, 255, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Configurator', '\\HookConfigurator\\Model\\Configurator', RelationMap::MANY_TO_ONE, array('configurator_id' => 'id', ), 'CASCADE', 'RESTRICT');
        $this->addRelation('Hook', '\\Thelia\\Model\\Hook', RelationMap::MANY_TO_ONE, array('hook_id' => 'id', ), 'CASCADE', 'RESTRICT');
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
        return $withPrefix ? ConfiguratorHookTableMap::CLASS_DEFAULT : ConfiguratorHookTableMap::OM_CLASS;
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
     * @return array (ConfiguratorHook object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = ConfiguratorHookTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = ConfiguratorHookTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + ConfiguratorHookTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = ConfiguratorHookTableMap::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            ConfiguratorHookTableMap::addInstanceToPool($obj, $key);
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
            $key = ConfiguratorHookTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = ConfiguratorHookTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                ConfiguratorHookTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(ConfiguratorHookTableMap::ID);
            $criteria->addSelectColumn(ConfiguratorHookTableMap::CONFIGURATOR_ID);
            $criteria->addSelectColumn(ConfiguratorHookTableMap::HOOK_ID);
            $criteria->addSelectColumn(ConfiguratorHookTableMap::HOOK_CODE);
        } else {
            $criteria->addSelectColumn($alias . '.ID');
            $criteria->addSelectColumn($alias . '.CONFIGURATOR_ID');
            $criteria->addSelectColumn($alias . '.HOOK_ID');
            $criteria->addSelectColumn($alias . '.HOOK_CODE');
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
        return Propel::getServiceContainer()->getDatabaseMap(ConfiguratorHookTableMap::DATABASE_NAME)->getTable(ConfiguratorHookTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getServiceContainer()->getDatabaseMap(ConfiguratorHookTableMap::DATABASE_NAME);
      if (!$dbMap->hasTable(ConfiguratorHookTableMap::TABLE_NAME)) {
        $dbMap->addTableObject(new ConfiguratorHookTableMap());
      }
    }

    /**
     * Performs a DELETE on the database, given a ConfiguratorHook or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ConfiguratorHook object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(ConfiguratorHookTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \HookConfigurator\Model\ConfiguratorHook) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(ConfiguratorHookTableMap::DATABASE_NAME);
            $criteria->add(ConfiguratorHookTableMap::ID, (array) $values, Criteria::IN);
        }

        $query = ConfiguratorHookQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) { ConfiguratorHookTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) { ConfiguratorHookTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the configurator_hook table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return ConfiguratorHookQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a ConfiguratorHook or Criteria object.
     *
     * @param mixed               $criteria Criteria or ConfiguratorHook object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ConfiguratorHookTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from ConfiguratorHook object
        }

        if ($criteria->containsKey(ConfiguratorHookTableMap::ID) && $criteria->keyContainsValue(ConfiguratorHookTableMap::ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.ConfiguratorHookTableMap::ID.')');
        }


        // Set the correct dbName
        $query = ConfiguratorHookQuery::create()->mergeWith($criteria);

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

} // ConfiguratorHookTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
ConfiguratorHookTableMap::buildTableMap();
