<?php

namespace Thelia\Model\Map;

use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;
use Thelia\Model\ModuleConfig;
use Thelia\Model\ModuleConfigQuery;


/**
 * This class defines the structure of the 'module_config' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class ModuleConfigTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;
    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'Thelia.Model.Map.ModuleConfigTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'thelia';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'module_config';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Thelia\\Model\\ModuleConfig';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Thelia.Model.ModuleConfig';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 5;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 5;

    /**
     * the column name for the ID field
     */
    const ID = 'module_config.ID';

    /**
     * the column name for the MODULE_ID field
     */
    const MODULE_ID = 'module_config.MODULE_ID';

    /**
     * the column name for the NAME field
     */
    const NAME = 'module_config.NAME';

    /**
     * the column name for the CREATED_AT field
     */
    const CREATED_AT = 'module_config.CREATED_AT';

    /**
     * the column name for the UPDATED_AT field
     */
    const UPDATED_AT = 'module_config.UPDATED_AT';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    // i18n behavior

    /**
     * The default locale to use for translations.
     *
     * @var string
     */
    const DEFAULT_LOCALE = 'en_US';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('Id', 'ModuleId', 'Name', 'CreatedAt', 'UpdatedAt', ),
        self::TYPE_STUDLYPHPNAME => array('id', 'moduleId', 'name', 'createdAt', 'updatedAt', ),
        self::TYPE_COLNAME       => array(ModuleConfigTableMap::ID, ModuleConfigTableMap::MODULE_ID, ModuleConfigTableMap::NAME, ModuleConfigTableMap::CREATED_AT, ModuleConfigTableMap::UPDATED_AT, ),
        self::TYPE_RAW_COLNAME   => array('ID', 'MODULE_ID', 'NAME', 'CREATED_AT', 'UPDATED_AT', ),
        self::TYPE_FIELDNAME     => array('id', 'module_id', 'name', 'created_at', 'updated_at', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'ModuleId' => 1, 'Name' => 2, 'CreatedAt' => 3, 'UpdatedAt' => 4, ),
        self::TYPE_STUDLYPHPNAME => array('id' => 0, 'moduleId' => 1, 'name' => 2, 'createdAt' => 3, 'updatedAt' => 4, ),
        self::TYPE_COLNAME       => array(ModuleConfigTableMap::ID => 0, ModuleConfigTableMap::MODULE_ID => 1, ModuleConfigTableMap::NAME => 2, ModuleConfigTableMap::CREATED_AT => 3, ModuleConfigTableMap::UPDATED_AT => 4, ),
        self::TYPE_RAW_COLNAME   => array('ID' => 0, 'MODULE_ID' => 1, 'NAME' => 2, 'CREATED_AT' => 3, 'UPDATED_AT' => 4, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'module_id' => 1, 'name' => 2, 'created_at' => 3, 'updated_at' => 4, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, )
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
        $this->setName('module_config');
        $this->setPhpName('ModuleConfig');
        $this->setClassName('\\Thelia\\Model\\ModuleConfig');
        $this->setPackage('Thelia.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('MODULE_ID', 'ModuleId', 'INTEGER', 'module', 'ID', true, null, null);
        $this->addColumn('NAME', 'Name', 'VARCHAR', true, 255, null);
        $this->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('UPDATED_AT', 'UpdatedAt', 'TIMESTAMP', false, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Module', '\\Thelia\\Model\\Module', RelationMap::MANY_TO_ONE, array('module_id' => 'id', ), 'CASCADE', 'RESTRICT');
        $this->addRelation('ModuleConfigI18n', '\\Thelia\\Model\\ModuleConfigI18n', RelationMap::ONE_TO_MANY, array('id' => 'id', ), 'CASCADE', null, 'ModuleConfigI18ns');
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
            'i18n' => array('i18n_table' => '%TABLE%_i18n', 'i18n_phpname' => '%PHPNAME%I18n', 'i18n_columns' => 'value', 'locale_column' => 'locale', 'locale_length' => '5', 'default_locale' => '', 'locale_alias' => '', ),
            'timestampable' => array('create_column' => 'created_at', 'update_column' => 'updated_at', ),
        );
    } // getBehaviors()
    /**
     * Method to invalidate the instance pool of all tables related to module_config     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
        // Invalidate objects in ".$this->getClassNameFromBuilder($joinedTableTableMapBuilder)." instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
                ModuleConfigI18nTableMap::clearInstancePool();
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
        return $withPrefix ? ModuleConfigTableMap::CLASS_DEFAULT : ModuleConfigTableMap::OM_CLASS;
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
     * @return array (ModuleConfig object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = ModuleConfigTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = ModuleConfigTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + ModuleConfigTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = ModuleConfigTableMap::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            ModuleConfigTableMap::addInstanceToPool($obj, $key);
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
            $key = ModuleConfigTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = ModuleConfigTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                ModuleConfigTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(ModuleConfigTableMap::ID);
            $criteria->addSelectColumn(ModuleConfigTableMap::MODULE_ID);
            $criteria->addSelectColumn(ModuleConfigTableMap::NAME);
            $criteria->addSelectColumn(ModuleConfigTableMap::CREATED_AT);
            $criteria->addSelectColumn(ModuleConfigTableMap::UPDATED_AT);
        } else {
            $criteria->addSelectColumn($alias . '.ID');
            $criteria->addSelectColumn($alias . '.MODULE_ID');
            $criteria->addSelectColumn($alias . '.NAME');
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
        return Propel::getServiceContainer()->getDatabaseMap(ModuleConfigTableMap::DATABASE_NAME)->getTable(ModuleConfigTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getServiceContainer()->getDatabaseMap(ModuleConfigTableMap::DATABASE_NAME);
      if (!$dbMap->hasTable(ModuleConfigTableMap::TABLE_NAME)) {
        $dbMap->addTableObject(new ModuleConfigTableMap());
      }
    }

    /**
     * Performs a DELETE on the database, given a ModuleConfig or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ModuleConfig object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(ModuleConfigTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Thelia\Model\ModuleConfig) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(ModuleConfigTableMap::DATABASE_NAME);
            $criteria->add(ModuleConfigTableMap::ID, (array) $values, Criteria::IN);
        }

        $query = ModuleConfigQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) { ModuleConfigTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) { ModuleConfigTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the module_config table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return ModuleConfigQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a ModuleConfig or Criteria object.
     *
     * @param mixed               $criteria Criteria or ModuleConfig object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ModuleConfigTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from ModuleConfig object
        }

        if ($criteria->containsKey(ModuleConfigTableMap::ID) && $criteria->keyContainsValue(ModuleConfigTableMap::ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.ModuleConfigTableMap::ID.')');
        }


        // Set the correct dbName
        $query = ModuleConfigQuery::create()->mergeWith($criteria);

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

} // ModuleConfigTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
ModuleConfigTableMap::buildTableMap();
