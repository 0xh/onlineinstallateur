<?php

namespace MultipleFullfilmentCenters\Model\Map;

use MultipleFullfilmentCenters\Model\FulfilmentCenterProducts;
use MultipleFullfilmentCenters\Model\FulfilmentCenterProductsQuery;
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
 * This class defines the structure of the 'fulfilment_center_products' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class FulfilmentCenterProductsTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;
    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'MultipleFullfilmentCenters.Model.Map.FulfilmentCenterProductsTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'thelia';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'fulfilment_center_products';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\MultipleFullfilmentCenters\\Model\\FulfilmentCenterProducts';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'MultipleFullfilmentCenters.Model.FulfilmentCenterProducts';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 6;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 6;

    /**
     * the column name for the ID field
     */
    const ID = 'fulfilment_center_products.ID';

    /**
     * the column name for the FULFILMENT_CENTER_ID field
     */
    const FULFILMENT_CENTER_ID = 'fulfilment_center_products.FULFILMENT_CENTER_ID';

    /**
     * the column name for the PRODUCT_ID field
     */
    const PRODUCT_ID = 'fulfilment_center_products.PRODUCT_ID';

    /**
     * the column name for the PRODUCT_STOCK field
     */
    const PRODUCT_STOCK = 'fulfilment_center_products.PRODUCT_STOCK';

    /**
     * the column name for the INCOMING_STOCK field
     */
    const INCOMING_STOCK = 'fulfilment_center_products.INCOMING_STOCK';

    /**
     * the column name for the OUTGOING_STOCK field
     */
    const OUTGOING_STOCK = 'fulfilment_center_products.OUTGOING_STOCK';

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
        self::TYPE_PHPNAME       => array('Id', 'FulfilmentCenterId', 'ProductId', 'ProductStock', 'IncomingStock', 'OutgoingStock', ),
        self::TYPE_STUDLYPHPNAME => array('id', 'fulfilmentCenterId', 'productId', 'productStock', 'incomingStock', 'outgoingStock', ),
        self::TYPE_COLNAME       => array(FulfilmentCenterProductsTableMap::ID, FulfilmentCenterProductsTableMap::FULFILMENT_CENTER_ID, FulfilmentCenterProductsTableMap::PRODUCT_ID, FulfilmentCenterProductsTableMap::PRODUCT_STOCK, FulfilmentCenterProductsTableMap::INCOMING_STOCK, FulfilmentCenterProductsTableMap::OUTGOING_STOCK, ),
        self::TYPE_RAW_COLNAME   => array('ID', 'FULFILMENT_CENTER_ID', 'PRODUCT_ID', 'PRODUCT_STOCK', 'INCOMING_STOCK', 'OUTGOING_STOCK', ),
        self::TYPE_FIELDNAME     => array('id', 'fulfilment_center_id', 'product_id', 'product_stock', 'incoming_stock', 'outgoing_stock', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'FulfilmentCenterId' => 1, 'ProductId' => 2, 'ProductStock' => 3, 'IncomingStock' => 4, 'OutgoingStock' => 5, ),
        self::TYPE_STUDLYPHPNAME => array('id' => 0, 'fulfilmentCenterId' => 1, 'productId' => 2, 'productStock' => 3, 'incomingStock' => 4, 'outgoingStock' => 5, ),
        self::TYPE_COLNAME       => array(FulfilmentCenterProductsTableMap::ID => 0, FulfilmentCenterProductsTableMap::FULFILMENT_CENTER_ID => 1, FulfilmentCenterProductsTableMap::PRODUCT_ID => 2, FulfilmentCenterProductsTableMap::PRODUCT_STOCK => 3, FulfilmentCenterProductsTableMap::INCOMING_STOCK => 4, FulfilmentCenterProductsTableMap::OUTGOING_STOCK => 5, ),
        self::TYPE_RAW_COLNAME   => array('ID' => 0, 'FULFILMENT_CENTER_ID' => 1, 'PRODUCT_ID' => 2, 'PRODUCT_STOCK' => 3, 'INCOMING_STOCK' => 4, 'OUTGOING_STOCK' => 5, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'fulfilment_center_id' => 1, 'product_id' => 2, 'product_stock' => 3, 'incoming_stock' => 4, 'outgoing_stock' => 5, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, )
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
        $this->setName('fulfilment_center_products');
        $this->setPhpName('FulfilmentCenterProducts');
        $this->setClassName('\\MultipleFullfilmentCenters\\Model\\FulfilmentCenterProducts');
        $this->setPackage('MultipleFullfilmentCenters.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('FULFILMENT_CENTER_ID', 'FulfilmentCenterId', 'INTEGER', 'fulfilment_center', 'ID', false, null, null);
        $this->addForeignKey('PRODUCT_ID', 'ProductId', 'INTEGER', 'product', 'ID', false, null, null);
        $this->addColumn('PRODUCT_STOCK', 'ProductStock', 'INTEGER', false, null, null);
        $this->addColumn('INCOMING_STOCK', 'IncomingStock', 'INTEGER', false, null, null);
        $this->addColumn('OUTGOING_STOCK', 'OutgoingStock', 'INTEGER', false, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('FulfilmentCenter', '\\MultipleFullfilmentCenters\\Model\\FulfilmentCenter', RelationMap::MANY_TO_ONE, array('fulfilment_center_id' => 'id', ), 'CASCADE', 'CASCADE');
        $this->addRelation('Product', '\\Thelia\\Model\\Product', RelationMap::MANY_TO_ONE, array('product_id' => 'id', ), 'CASCADE', 'CASCADE');
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
        return $withPrefix ? FulfilmentCenterProductsTableMap::CLASS_DEFAULT : FulfilmentCenterProductsTableMap::OM_CLASS;
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
     * @return array (FulfilmentCenterProducts object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = FulfilmentCenterProductsTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = FulfilmentCenterProductsTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + FulfilmentCenterProductsTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = FulfilmentCenterProductsTableMap::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            FulfilmentCenterProductsTableMap::addInstanceToPool($obj, $key);
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
            $key = FulfilmentCenterProductsTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = FulfilmentCenterProductsTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                FulfilmentCenterProductsTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(FulfilmentCenterProductsTableMap::ID);
            $criteria->addSelectColumn(FulfilmentCenterProductsTableMap::FULFILMENT_CENTER_ID);
            $criteria->addSelectColumn(FulfilmentCenterProductsTableMap::PRODUCT_ID);
            $criteria->addSelectColumn(FulfilmentCenterProductsTableMap::PRODUCT_STOCK);
            $criteria->addSelectColumn(FulfilmentCenterProductsTableMap::INCOMING_STOCK);
            $criteria->addSelectColumn(FulfilmentCenterProductsTableMap::OUTGOING_STOCK);
        } else {
            $criteria->addSelectColumn($alias . '.ID');
            $criteria->addSelectColumn($alias . '.FULFILMENT_CENTER_ID');
            $criteria->addSelectColumn($alias . '.PRODUCT_ID');
            $criteria->addSelectColumn($alias . '.PRODUCT_STOCK');
            $criteria->addSelectColumn($alias . '.INCOMING_STOCK');
            $criteria->addSelectColumn($alias . '.OUTGOING_STOCK');
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
        return Propel::getServiceContainer()->getDatabaseMap(FulfilmentCenterProductsTableMap::DATABASE_NAME)->getTable(FulfilmentCenterProductsTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getServiceContainer()->getDatabaseMap(FulfilmentCenterProductsTableMap::DATABASE_NAME);
      if (!$dbMap->hasTable(FulfilmentCenterProductsTableMap::TABLE_NAME)) {
        $dbMap->addTableObject(new FulfilmentCenterProductsTableMap());
      }
    }

    /**
     * Performs a DELETE on the database, given a FulfilmentCenterProducts or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or FulfilmentCenterProducts object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(FulfilmentCenterProductsTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \MultipleFullfilmentCenters\Model\FulfilmentCenterProducts) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(FulfilmentCenterProductsTableMap::DATABASE_NAME);
            $criteria->add(FulfilmentCenterProductsTableMap::ID, (array) $values, Criteria::IN);
        }

        $query = FulfilmentCenterProductsQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) { FulfilmentCenterProductsTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) { FulfilmentCenterProductsTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the fulfilment_center_products table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return FulfilmentCenterProductsQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a FulfilmentCenterProducts or Criteria object.
     *
     * @param mixed               $criteria Criteria or FulfilmentCenterProducts object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(FulfilmentCenterProductsTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from FulfilmentCenterProducts object
        }

        if ($criteria->containsKey(FulfilmentCenterProductsTableMap::ID) && $criteria->keyContainsValue(FulfilmentCenterProductsTableMap::ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.FulfilmentCenterProductsTableMap::ID.')');
        }


        // Set the correct dbName
        $query = FulfilmentCenterProductsQuery::create()->mergeWith($criteria);

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

} // FulfilmentCenterProductsTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
FulfilmentCenterProductsTableMap::buildTableMap();
