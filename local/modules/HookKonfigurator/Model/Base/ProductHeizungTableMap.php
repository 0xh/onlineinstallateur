<?php

namespace HookKonfigurator\Model\Map;

use HookKonfigurator\Model\ProductHeizung;
use HookKonfigurator\Model\ProductHeizungQuery;
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
 * This class defines the structure of the 'product_heizung' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class ProductHeizungTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;
    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'HookKonfigurator.Model.Map.ProductHeizungTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'thelia';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'product_heizung';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\HookKonfigurator\\Model\\ProductHeizung';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'HookKonfigurator.Model.ProductHeizung';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 8;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 8;

    /**
     * the column name for the PRODUCT_ID field
     */
    const PRODUCT_ID = 'product_heizung.PRODUCT_ID';

    /**
     * the column name for the GRADE field
     */
    const GRADE = 'product_heizung.GRADE';

    /**
     * the column name for the POWER field
     */
    const POWER = 'product_heizung.POWER';

    /**
     * the column name for the ENERGY_EFFICIENCY field
     */
    const ENERGY_EFFICIENCY = 'product_heizung.ENERGY_EFFICIENCY';

    /**
     * the column name for the PRIORITY field
     */
    const PRIORITY = 'product_heizung.PRIORITY';

    /**
     * the column name for the WARM_WATER field
     */
    const WARM_WATER = 'product_heizung.WARM_WATER';

    /**
     * the column name for the ENERGY_CARRIER field
     */
    const ENERGY_CARRIER = 'product_heizung.ENERGY_CARRIER';

    /**
     * the column name for the STORAGE_CAPACITY field
     */
    const STORAGE_CAPACITY = 'product_heizung.STORAGE_CAPACITY';

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
        self::TYPE_PHPNAME       => array('ProductId', 'Grade', 'Power', 'EnergyEfficiency', 'Priority', 'WarmWater', 'EnergyCarrier', 'StorageCapacity', ),
        self::TYPE_STUDLYPHPNAME => array('productId', 'grade', 'power', 'energyEfficiency', 'priority', 'warmWater', 'energyCarrier', 'storageCapacity', ),
        self::TYPE_COLNAME       => array(ProductHeizungTableMap::PRODUCT_ID, ProductHeizungTableMap::GRADE, ProductHeizungTableMap::POWER, ProductHeizungTableMap::ENERGY_EFFICIENCY, ProductHeizungTableMap::PRIORITY, ProductHeizungTableMap::WARM_WATER, ProductHeizungTableMap::ENERGY_CARRIER, ProductHeizungTableMap::STORAGE_CAPACITY, ),
        self::TYPE_RAW_COLNAME   => array('PRODUCT_ID', 'GRADE', 'POWER', 'ENERGY_EFFICIENCY', 'PRIORITY', 'WARM_WATER', 'ENERGY_CARRIER', 'STORAGE_CAPACITY', ),
        self::TYPE_FIELDNAME     => array('product_id', 'grade', 'power', 'energy_efficiency', 'priority', 'warm_water', 'energy_carrier', 'storage_capacity', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('ProductId' => 0, 'Grade' => 1, 'Power' => 2, 'EnergyEfficiency' => 3, 'Priority' => 4, 'WarmWater' => 5, 'EnergyCarrier' => 6, 'StorageCapacity' => 7, ),
        self::TYPE_STUDLYPHPNAME => array('productId' => 0, 'grade' => 1, 'power' => 2, 'energyEfficiency' => 3, 'priority' => 4, 'warmWater' => 5, 'energyCarrier' => 6, 'storageCapacity' => 7, ),
        self::TYPE_COLNAME       => array(ProductHeizungTableMap::PRODUCT_ID => 0, ProductHeizungTableMap::GRADE => 1, ProductHeizungTableMap::POWER => 2, ProductHeizungTableMap::ENERGY_EFFICIENCY => 3, ProductHeizungTableMap::PRIORITY => 4, ProductHeizungTableMap::WARM_WATER => 5, ProductHeizungTableMap::ENERGY_CARRIER => 6, ProductHeizungTableMap::STORAGE_CAPACITY => 7, ),
        self::TYPE_RAW_COLNAME   => array('PRODUCT_ID' => 0, 'GRADE' => 1, 'POWER' => 2, 'ENERGY_EFFICIENCY' => 3, 'PRIORITY' => 4, 'WARM_WATER' => 5, 'ENERGY_CARRIER' => 6, 'STORAGE_CAPACITY' => 7, ),
        self::TYPE_FIELDNAME     => array('product_id' => 0, 'grade' => 1, 'power' => 2, 'energy_efficiency' => 3, 'priority' => 4, 'warm_water' => 5, 'energy_carrier' => 6, 'storage_capacity' => 7, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, )
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
        $this->setName('product_heizung');
        $this->setPhpName('ProductHeizung');
        $this->setClassName('\\HookKonfigurator\\Model\\ProductHeizung');
        $this->setPackage('HookKonfigurator.Model');
        $this->setUseIdGenerator(false);
        // columns
        $this->addForeignPrimaryKey('PRODUCT_ID', 'ProductId', 'INTEGER' , 'product', 'ID', true, null, null);
        $this->addColumn('GRADE', 'Grade', 'VARCHAR', false, 255, null);
        $this->addColumn('POWER', 'Power', 'INTEGER', false, null, 0);
        $this->addColumn('ENERGY_EFFICIENCY', 'EnergyEfficiency', 'INTEGER', false, null, 0);
        $this->addColumn('PRIORITY', 'Priority', 'INTEGER', false, null, 0);
        $this->addColumn('WARM_WATER', 'WarmWater', 'BOOLEAN', true, 1, false);
        $this->addColumn('ENERGY_CARRIER', 'EnergyCarrier', 'VARCHAR', false, 255, null);
        $this->addColumn('STORAGE_CAPACITY', 'StorageCapacity', 'INTEGER', false, null, 0);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Product', '\\HookKonfigurator\\Model\\Product', RelationMap::MANY_TO_ONE, array('product_id' => 'id', ), 'CASCADE', null);
        $this->addRelation('ProductHeizungMontage', '\\HookKonfigurator\\Model\\ProductHeizungMontage', RelationMap::ONE_TO_ONE, array('product_id' => 'id', ), null, null);
        $this->addRelation('SetProducts', '\\HookKonfigurator\\Model\\SetProducts', RelationMap::ONE_TO_ONE, array('product_id' => 'id', ), 'CASCADE', null);
    } // buildRelations()
    /**
     * Method to invalidate the instance pool of all tables related to product_heizung     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
        // Invalidate objects in ".$this->getClassNameFromBuilder($joinedTableTableMapBuilder)." instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
                SetProductsTableMap::clearInstancePool();
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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('ProductId', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('ProductId', TableMap::TYPE_PHPNAME, $indexType)];
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
                            : self::translateFieldName('ProductId', TableMap::TYPE_PHPNAME, $indexType)
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
        return $withPrefix ? ProductHeizungTableMap::CLASS_DEFAULT : ProductHeizungTableMap::OM_CLASS;
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
     * @return array (ProductHeizung object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = ProductHeizungTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = ProductHeizungTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + ProductHeizungTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = ProductHeizungTableMap::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            ProductHeizungTableMap::addInstanceToPool($obj, $key);
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
            $key = ProductHeizungTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = ProductHeizungTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                ProductHeizungTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(ProductHeizungTableMap::PRODUCT_ID);
            $criteria->addSelectColumn(ProductHeizungTableMap::GRADE);
            $criteria->addSelectColumn(ProductHeizungTableMap::POWER);
            $criteria->addSelectColumn(ProductHeizungTableMap::ENERGY_EFFICIENCY);
            $criteria->addSelectColumn(ProductHeizungTableMap::PRIORITY);
            $criteria->addSelectColumn(ProductHeizungTableMap::WARM_WATER);
            $criteria->addSelectColumn(ProductHeizungTableMap::ENERGY_CARRIER);
            $criteria->addSelectColumn(ProductHeizungTableMap::STORAGE_CAPACITY);
        } else {
            $criteria->addSelectColumn($alias . '.PRODUCT_ID');
            $criteria->addSelectColumn($alias . '.GRADE');
            $criteria->addSelectColumn($alias . '.POWER');
            $criteria->addSelectColumn($alias . '.ENERGY_EFFICIENCY');
            $criteria->addSelectColumn($alias . '.PRIORITY');
            $criteria->addSelectColumn($alias . '.WARM_WATER');
            $criteria->addSelectColumn($alias . '.ENERGY_CARRIER');
            $criteria->addSelectColumn($alias . '.STORAGE_CAPACITY');
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
        return Propel::getServiceContainer()->getDatabaseMap(ProductHeizungTableMap::DATABASE_NAME)->getTable(ProductHeizungTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getServiceContainer()->getDatabaseMap(ProductHeizungTableMap::DATABASE_NAME);
      if (!$dbMap->hasTable(ProductHeizungTableMap::TABLE_NAME)) {
        $dbMap->addTableObject(new ProductHeizungTableMap());
      }
    }

    /**
     * Performs a DELETE on the database, given a ProductHeizung or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ProductHeizung object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(ProductHeizungTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \HookKonfigurator\Model\ProductHeizung) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(ProductHeizungTableMap::DATABASE_NAME);
            $criteria->add(ProductHeizungTableMap::PRODUCT_ID, (array) $values, Criteria::IN);
        }

        $query = ProductHeizungQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) { ProductHeizungTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) { ProductHeizungTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the product_heizung table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return ProductHeizungQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a ProductHeizung or Criteria object.
     *
     * @param mixed               $criteria Criteria or ProductHeizung object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ProductHeizungTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from ProductHeizung object
        }


        // Set the correct dbName
        $query = ProductHeizungQuery::create()->mergeWith($criteria);

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

} // ProductHeizungTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
ProductHeizungTableMap::buildTableMap();
