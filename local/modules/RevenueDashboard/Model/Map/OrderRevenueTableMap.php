<?php

namespace RevenueDashboard\Model\Map;

use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;
use RevenueDashboard\Model\OrderRevenue;
use RevenueDashboard\Model\OrderRevenueQuery;


/**
 * This class defines the structure of the 'order_revenue' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class OrderRevenueTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;
    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'RevenueDashboard.Model.Map.OrderRevenueTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'thelia';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'order_revenue';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\RevenueDashboard\\Model\\OrderRevenue';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'RevenueDashboard.Model.OrderRevenue';

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
    const ID = 'order_revenue.ID';

    /**
     * the column name for the ORDER_ID field
     */
    const ORDER_ID = 'order_revenue.ORDER_ID';

    /**
     * the column name for the DELIVERY_COST field
     */
    const DELIVERY_COST = 'order_revenue.DELIVERY_COST';

    /**
     * the column name for the DELIVERY_METHOD field
     */
    const DELIVERY_METHOD = 'order_revenue.DELIVERY_METHOD';

    /**
     * the column name for the PARTNER_ID field
     */
    const PARTNER_ID = 'order_revenue.PARTNER_ID';

    /**
     * the column name for the PAYMENT_PROCESSOR_COST field
     */
    const PAYMENT_PROCESSOR_COST = 'order_revenue.PAYMENT_PROCESSOR_COST';

    /**
     * the column name for the PRICE field
     */
    const PRICE = 'order_revenue.PRICE';

    /**
     * the column name for the PURCHASE_PRICE field
     */
    const PURCHASE_PRICE = 'order_revenue.PURCHASE_PRICE';

    /**
     * the column name for the TOTAL_PURCHASE_PRICE field
     */
    const TOTAL_PURCHASE_PRICE = 'order_revenue.TOTAL_PURCHASE_PRICE';

    /**
     * the column name for the REVENUE field
     */
    const REVENUE = 'order_revenue.REVENUE';

    /**
     * the column name for the COMMENT field
     */
    const COMMENT = 'order_revenue.COMMENT';

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
        self::TYPE_PHPNAME       => array('Id', 'OrderId', 'DeliveryCost', 'DeliveryMethod', 'PartnerId', 'PaymentProcessorCost', 'Price', 'PurchasePrice', 'TotalPurchasePrice', 'Revenue', 'Comment', ),
        self::TYPE_STUDLYPHPNAME => array('id', 'orderId', 'deliveryCost', 'deliveryMethod', 'partnerId', 'paymentProcessorCost', 'price', 'purchasePrice', 'totalPurchasePrice', 'revenue', 'comment', ),
        self::TYPE_COLNAME       => array(OrderRevenueTableMap::ID, OrderRevenueTableMap::ORDER_ID, OrderRevenueTableMap::DELIVERY_COST, OrderRevenueTableMap::DELIVERY_METHOD, OrderRevenueTableMap::PARTNER_ID, OrderRevenueTableMap::PAYMENT_PROCESSOR_COST, OrderRevenueTableMap::PRICE, OrderRevenueTableMap::PURCHASE_PRICE, OrderRevenueTableMap::TOTAL_PURCHASE_PRICE, OrderRevenueTableMap::REVENUE, OrderRevenueTableMap::COMMENT, ),
        self::TYPE_RAW_COLNAME   => array('ID', 'ORDER_ID', 'DELIVERY_COST', 'DELIVERY_METHOD', 'PARTNER_ID', 'PAYMENT_PROCESSOR_COST', 'PRICE', 'PURCHASE_PRICE', 'TOTAL_PURCHASE_PRICE', 'REVENUE', 'COMMENT', ),
        self::TYPE_FIELDNAME     => array('id', 'order_id', 'delivery_cost', 'delivery_method', 'partner_id', 'payment_processor_cost', 'price', 'purchase_price', 'total_purchase_price', 'revenue', 'comment', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'OrderId' => 1, 'DeliveryCost' => 2, 'DeliveryMethod' => 3, 'PartnerId' => 4, 'PaymentProcessorCost' => 5, 'Price' => 6, 'PurchasePrice' => 7, 'TotalPurchasePrice' => 8, 'Revenue' => 9, 'Comment' => 10, ),
        self::TYPE_STUDLYPHPNAME => array('id' => 0, 'orderId' => 1, 'deliveryCost' => 2, 'deliveryMethod' => 3, 'partnerId' => 4, 'paymentProcessorCost' => 5, 'price' => 6, 'purchasePrice' => 7, 'totalPurchasePrice' => 8, 'revenue' => 9, 'comment' => 10, ),
        self::TYPE_COLNAME       => array(OrderRevenueTableMap::ID => 0, OrderRevenueTableMap::ORDER_ID => 1, OrderRevenueTableMap::DELIVERY_COST => 2, OrderRevenueTableMap::DELIVERY_METHOD => 3, OrderRevenueTableMap::PARTNER_ID => 4, OrderRevenueTableMap::PAYMENT_PROCESSOR_COST => 5, OrderRevenueTableMap::PRICE => 6, OrderRevenueTableMap::PURCHASE_PRICE => 7, OrderRevenueTableMap::TOTAL_PURCHASE_PRICE => 8, OrderRevenueTableMap::REVENUE => 9, OrderRevenueTableMap::COMMENT => 10, ),
        self::TYPE_RAW_COLNAME   => array('ID' => 0, 'ORDER_ID' => 1, 'DELIVERY_COST' => 2, 'DELIVERY_METHOD' => 3, 'PARTNER_ID' => 4, 'PAYMENT_PROCESSOR_COST' => 5, 'PRICE' => 6, 'PURCHASE_PRICE' => 7, 'TOTAL_PURCHASE_PRICE' => 8, 'REVENUE' => 9, 'COMMENT' => 10, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'order_id' => 1, 'delivery_cost' => 2, 'delivery_method' => 3, 'partner_id' => 4, 'payment_processor_cost' => 5, 'price' => 6, 'purchase_price' => 7, 'total_purchase_price' => 8, 'revenue' => 9, 'comment' => 10, ),
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
        $this->setName('order_revenue');
        $this->setPhpName('OrderRevenue');
        $this->setClassName('\\RevenueDashboard\\Model\\OrderRevenue');
        $this->setPackage('RevenueDashboard.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('ORDER_ID', 'OrderId', 'INTEGER', 'order', 'ID', false, null, null);
        $this->addColumn('DELIVERY_COST', 'DeliveryCost', 'DECIMAL', false, 16, 0);
        $this->addColumn('DELIVERY_METHOD', 'DeliveryMethod', 'VARCHAR', false, 255, null);
        $this->addColumn('PARTNER_ID', 'PartnerId', 'INTEGER', false, null, null);
        $this->addColumn('PAYMENT_PROCESSOR_COST', 'PaymentProcessorCost', 'DECIMAL', false, 16, 0);
        $this->addColumn('PRICE', 'Price', 'DECIMAL', false, 16, 0);
        $this->addColumn('PURCHASE_PRICE', 'PurchasePrice', 'DECIMAL', false, 16, 0);
        $this->addColumn('TOTAL_PURCHASE_PRICE', 'TotalPurchasePrice', 'DECIMAL', false, 16, 0);
        $this->addColumn('REVENUE', 'Revenue', 'DECIMAL', false, 16, 0);
        $this->addColumn('COMMENT', 'Comment', 'VARCHAR', false, 255, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Order', '\\Thelia\\Model\\Order', RelationMap::MANY_TO_ONE, array('order_id' => 'id', ), 'CASCADE', null);
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
        return $withPrefix ? OrderRevenueTableMap::CLASS_DEFAULT : OrderRevenueTableMap::OM_CLASS;
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
     * @return array (OrderRevenue object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = OrderRevenueTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = OrderRevenueTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + OrderRevenueTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = OrderRevenueTableMap::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            OrderRevenueTableMap::addInstanceToPool($obj, $key);
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
            $key = OrderRevenueTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = OrderRevenueTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                OrderRevenueTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(OrderRevenueTableMap::ID);
            $criteria->addSelectColumn(OrderRevenueTableMap::ORDER_ID);
            $criteria->addSelectColumn(OrderRevenueTableMap::DELIVERY_COST);
            $criteria->addSelectColumn(OrderRevenueTableMap::DELIVERY_METHOD);
            $criteria->addSelectColumn(OrderRevenueTableMap::PARTNER_ID);
            $criteria->addSelectColumn(OrderRevenueTableMap::PAYMENT_PROCESSOR_COST);
            $criteria->addSelectColumn(OrderRevenueTableMap::PRICE);
            $criteria->addSelectColumn(OrderRevenueTableMap::PURCHASE_PRICE);
            $criteria->addSelectColumn(OrderRevenueTableMap::TOTAL_PURCHASE_PRICE);
            $criteria->addSelectColumn(OrderRevenueTableMap::REVENUE);
            $criteria->addSelectColumn(OrderRevenueTableMap::COMMENT);
        } else {
            $criteria->addSelectColumn($alias . '.ID');
            $criteria->addSelectColumn($alias . '.ORDER_ID');
            $criteria->addSelectColumn($alias . '.DELIVERY_COST');
            $criteria->addSelectColumn($alias . '.DELIVERY_METHOD');
            $criteria->addSelectColumn($alias . '.PARTNER_ID');
            $criteria->addSelectColumn($alias . '.PAYMENT_PROCESSOR_COST');
            $criteria->addSelectColumn($alias . '.PRICE');
            $criteria->addSelectColumn($alias . '.PURCHASE_PRICE');
            $criteria->addSelectColumn($alias . '.TOTAL_PURCHASE_PRICE');
            $criteria->addSelectColumn($alias . '.REVENUE');
            $criteria->addSelectColumn($alias . '.COMMENT');
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
        return Propel::getServiceContainer()->getDatabaseMap(OrderRevenueTableMap::DATABASE_NAME)->getTable(OrderRevenueTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getServiceContainer()->getDatabaseMap(OrderRevenueTableMap::DATABASE_NAME);
      if (!$dbMap->hasTable(OrderRevenueTableMap::TABLE_NAME)) {
        $dbMap->addTableObject(new OrderRevenueTableMap());
      }
    }

    /**
     * Performs a DELETE on the database, given a OrderRevenue or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or OrderRevenue object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(OrderRevenueTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \RevenueDashboard\Model\OrderRevenue) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(OrderRevenueTableMap::DATABASE_NAME);
            $criteria->add(OrderRevenueTableMap::ID, (array) $values, Criteria::IN);
        }

        $query = OrderRevenueQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) { OrderRevenueTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) { OrderRevenueTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the order_revenue table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return OrderRevenueQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a OrderRevenue or Criteria object.
     *
     * @param mixed               $criteria Criteria or OrderRevenue object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(OrderRevenueTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from OrderRevenue object
        }

        if ($criteria->containsKey(OrderRevenueTableMap::ID) && $criteria->keyContainsValue(OrderRevenueTableMap::ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.OrderRevenueTableMap::ID.')');
        }


        // Set the correct dbName
        $query = OrderRevenueQuery::create()->mergeWith($criteria);

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

} // OrderRevenueTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
OrderRevenueTableMap::buildTableMap();
