<?php

namespace MultipleFullfilmentCenters\Model\Map;

use MultipleFullfilmentCenters\Model\OrderLocalPickup;
use MultipleFullfilmentCenters\Model\OrderLocalPickupQuery;
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
 * This class defines the structure of the 'order_local_pickup' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class OrderLocalPickupTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;
    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'MultipleFullfilmentCenters.Model.Map.OrderLocalPickupTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'thelia';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'order_local_pickup';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\MultipleFullfilmentCenters\\Model\\OrderLocalPickup';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'MultipleFullfilmentCenters.Model.OrderLocalPickup';

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
     * the column name for the ORDER_ID field
     */
    const ORDER_ID = 'order_local_pickup.ORDER_ID';

    /**
     * the column name for the CART_ID field
     */
    const CART_ID = 'order_local_pickup.CART_ID';

    /**
     * the column name for the PRODUCT_ID field
     */
    const PRODUCT_ID = 'order_local_pickup.PRODUCT_ID';

    /**
     * the column name for the FULFILMENT_CENTER_ID field
     */
    const FULFILMENT_CENTER_ID = 'order_local_pickup.FULFILMENT_CENTER_ID';

    /**
     * the column name for the QUANTITY field
     */
    const QUANTITY = 'order_local_pickup.QUANTITY';

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
        self::TYPE_PHPNAME       => array('OrderId', 'CartId', 'ProductId', 'FulfilmentCenterId', 'Quantity', ),
        self::TYPE_STUDLYPHPNAME => array('orderId', 'cartId', 'productId', 'fulfilmentCenterId', 'quantity', ),
        self::TYPE_COLNAME       => array(OrderLocalPickupTableMap::ORDER_ID, OrderLocalPickupTableMap::CART_ID, OrderLocalPickupTableMap::PRODUCT_ID, OrderLocalPickupTableMap::FULFILMENT_CENTER_ID, OrderLocalPickupTableMap::QUANTITY, ),
        self::TYPE_RAW_COLNAME   => array('ORDER_ID', 'CART_ID', 'PRODUCT_ID', 'FULFILMENT_CENTER_ID', 'QUANTITY', ),
        self::TYPE_FIELDNAME     => array('order_id', 'cart_id', 'product_id', 'fulfilment_center_id', 'quantity', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('OrderId' => 0, 'CartId' => 1, 'ProductId' => 2, 'FulfilmentCenterId' => 3, 'Quantity' => 4, ),
        self::TYPE_STUDLYPHPNAME => array('orderId' => 0, 'cartId' => 1, 'productId' => 2, 'fulfilmentCenterId' => 3, 'quantity' => 4, ),
        self::TYPE_COLNAME       => array(OrderLocalPickupTableMap::ORDER_ID => 0, OrderLocalPickupTableMap::CART_ID => 1, OrderLocalPickupTableMap::PRODUCT_ID => 2, OrderLocalPickupTableMap::FULFILMENT_CENTER_ID => 3, OrderLocalPickupTableMap::QUANTITY => 4, ),
        self::TYPE_RAW_COLNAME   => array('ORDER_ID' => 0, 'CART_ID' => 1, 'PRODUCT_ID' => 2, 'FULFILMENT_CENTER_ID' => 3, 'QUANTITY' => 4, ),
        self::TYPE_FIELDNAME     => array('order_id' => 0, 'cart_id' => 1, 'product_id' => 2, 'fulfilment_center_id' => 3, 'quantity' => 4, ),
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
        $this->setName('order_local_pickup');
        $this->setPhpName('OrderLocalPickup');
        $this->setClassName('\\MultipleFullfilmentCenters\\Model\\OrderLocalPickup');
        $this->setPackage('MultipleFullfilmentCenters.Model');
        $this->setUseIdGenerator(false);
        // columns
        $this->addForeignKey('ORDER_ID', 'OrderId', 'INTEGER', 'order', 'ID', false, null, null);
        $this->addPrimaryKey('CART_ID', 'CartId', 'INTEGER', true, null, null);
        $this->addForeignPrimaryKey('PRODUCT_ID', 'ProductId', 'INTEGER' , 'product', 'ID', true, null, null);
        $this->addForeignKey('FULFILMENT_CENTER_ID', 'FulfilmentCenterId', 'INTEGER', 'fulfilment_center', 'ID', true, null, null);
        $this->addColumn('QUANTITY', 'Quantity', 'INTEGER', true, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('FulfilmentCenter', '\\MultipleFullfilmentCenters\\Model\\FulfilmentCenter', RelationMap::MANY_TO_ONE, array('fulfilment_center_id' => 'id', ), 'CASCADE', null);
        $this->addRelation('Order', '\\MultipleFullfilmentCenters\\Model\\Order', RelationMap::MANY_TO_ONE, array('order_id' => 'id', ), 'CASCADE', null);
        $this->addRelation('Product', '\\MultipleFullfilmentCenters\\Model\\Product', RelationMap::MANY_TO_ONE, array('product_id' => 'id', ), 'CASCADE', null);
    } // buildRelations()

    /**
     * Adds an object to the instance pool.
     *
     * Propel keeps cached copies of objects in an instance pool when they are retrieved
     * from the database. In some cases you may need to explicitly add objects
     * to the cache in order to ensure that the same objects are always returned by find*()
     * and findPk*() calls.
     *
     * @param \MultipleFullfilmentCenters\Model\OrderLocalPickup $obj A \MultipleFullfilmentCenters\Model\OrderLocalPickup object.
     * @param string $key             (optional) key to use for instance map (for performance boost if key was already calculated externally).
     */
    public static function addInstanceToPool($obj, $key = null)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if (null === $key) {
                $key = serialize(array((string) $obj->getCartId(), (string) $obj->getProductId()));
            } // if key === null
            self::$instances[$key] = $obj;
        }
    }

    /**
     * Removes an object from the instance pool.
     *
     * Propel keeps cached copies of objects in an instance pool when they are retrieved
     * from the database.  In some cases -- especially when you override doDelete
     * methods in your stub classes -- you may need to explicitly remove objects
     * from the cache in order to prevent returning objects that no longer exist.
     *
     * @param mixed $value A \MultipleFullfilmentCenters\Model\OrderLocalPickup object or a primary key value.
     */
    public static function removeInstanceFromPool($value)
    {
        if (Propel::isInstancePoolingEnabled() && null !== $value) {
            if (is_object($value) && $value instanceof \MultipleFullfilmentCenters\Model\OrderLocalPickup) {
                $key = serialize(array((string) $value->getCartId(), (string) $value->getProductId()));

            } elseif (is_array($value) && count($value) === 2) {
                // assume we've been passed a primary key";
                $key = serialize(array((string) $value[0], (string) $value[1]));
            } elseif ($value instanceof Criteria) {
                self::$instances = [];

                return;
            } else {
                $e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or \MultipleFullfilmentCenters\Model\OrderLocalPickup object; got " . (is_object($value) ? get_class($value) . ' object.' : var_export($value, true)));
                throw $e;
            }

            unset(self::$instances[$key]);
        }
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
        if ($row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('CartId', TableMap::TYPE_PHPNAME, $indexType)] === null && $row[TableMap::TYPE_NUM == $indexType ? 2 + $offset : static::translateFieldName('ProductId', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return serialize(array((string) $row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('CartId', TableMap::TYPE_PHPNAME, $indexType)], (string) $row[TableMap::TYPE_NUM == $indexType ? 2 + $offset : static::translateFieldName('ProductId', TableMap::TYPE_PHPNAME, $indexType)]));
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

            return $pks;
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
        return $withPrefix ? OrderLocalPickupTableMap::CLASS_DEFAULT : OrderLocalPickupTableMap::OM_CLASS;
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
     * @return array (OrderLocalPickup object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = OrderLocalPickupTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = OrderLocalPickupTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + OrderLocalPickupTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = OrderLocalPickupTableMap::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            OrderLocalPickupTableMap::addInstanceToPool($obj, $key);
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
            $key = OrderLocalPickupTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = OrderLocalPickupTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                OrderLocalPickupTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(OrderLocalPickupTableMap::ORDER_ID);
            $criteria->addSelectColumn(OrderLocalPickupTableMap::CART_ID);
            $criteria->addSelectColumn(OrderLocalPickupTableMap::PRODUCT_ID);
            $criteria->addSelectColumn(OrderLocalPickupTableMap::FULFILMENT_CENTER_ID);
            $criteria->addSelectColumn(OrderLocalPickupTableMap::QUANTITY);
        } else {
            $criteria->addSelectColumn($alias . '.ORDER_ID');
            $criteria->addSelectColumn($alias . '.CART_ID');
            $criteria->addSelectColumn($alias . '.PRODUCT_ID');
            $criteria->addSelectColumn($alias . '.FULFILMENT_CENTER_ID');
            $criteria->addSelectColumn($alias . '.QUANTITY');
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
        return Propel::getServiceContainer()->getDatabaseMap(OrderLocalPickupTableMap::DATABASE_NAME)->getTable(OrderLocalPickupTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getServiceContainer()->getDatabaseMap(OrderLocalPickupTableMap::DATABASE_NAME);
      if (!$dbMap->hasTable(OrderLocalPickupTableMap::TABLE_NAME)) {
        $dbMap->addTableObject(new OrderLocalPickupTableMap());
      }
    }

    /**
     * Performs a DELETE on the database, given a OrderLocalPickup or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or OrderLocalPickup object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(OrderLocalPickupTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \MultipleFullfilmentCenters\Model\OrderLocalPickup) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(OrderLocalPickupTableMap::DATABASE_NAME);
            // primary key is composite; we therefore, expect
            // the primary key passed to be an array of pkey values
            if (count($values) == count($values, COUNT_RECURSIVE)) {
                // array is not multi-dimensional
                $values = array($values);
            }
            foreach ($values as $value) {
                $criterion = $criteria->getNewCriterion(OrderLocalPickupTableMap::CART_ID, $value[0]);
                $criterion->addAnd($criteria->getNewCriterion(OrderLocalPickupTableMap::PRODUCT_ID, $value[1]));
                $criteria->addOr($criterion);
            }
        }

        $query = OrderLocalPickupQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) { OrderLocalPickupTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) { OrderLocalPickupTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the order_local_pickup table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return OrderLocalPickupQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a OrderLocalPickup or Criteria object.
     *
     * @param mixed               $criteria Criteria or OrderLocalPickup object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(OrderLocalPickupTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from OrderLocalPickup object
        }


        // Set the correct dbName
        $query = OrderLocalPickupQuery::create()->mergeWith($criteria);

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

} // OrderLocalPickupTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
OrderLocalPickupTableMap::buildTableMap();
