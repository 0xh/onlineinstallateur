<?php

namespace HookCalendar\Model\Map;

use HookCalendar\Model\PluginInvoiceItems;
use HookCalendar\Model\PluginInvoiceItemsQuery;
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
 * This class defines the structure of the 'plugin_invoice_items' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class PluginInvoiceItemsTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;
    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'HookCalendar.Model.Map.PluginInvoiceItemsTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'thelia';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'plugin_invoice_items';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\HookCalendar\\Model\\PluginInvoiceItems';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'HookCalendar.Model.PluginInvoiceItems';

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
     * the column name for the ID field
     */
    const ID = 'plugin_invoice_items.ID';

    /**
     * the column name for the INVOICE_ID field
     */
    const INVOICE_ID = 'plugin_invoice_items.INVOICE_ID';

    /**
     * the column name for the TMP field
     */
    const TMP = 'plugin_invoice_items.TMP';

    /**
     * the column name for the NAME field
     */
    const NAME = 'plugin_invoice_items.NAME';

    /**
     * the column name for the DESCRIPTION field
     */
    const DESCRIPTION = 'plugin_invoice_items.DESCRIPTION';

    /**
     * the column name for the QTY field
     */
    const QTY = 'plugin_invoice_items.QTY';

    /**
     * the column name for the UNIT_PRICE field
     */
    const UNIT_PRICE = 'plugin_invoice_items.UNIT_PRICE';

    /**
     * the column name for the AMOUNT field
     */
    const AMOUNT = 'plugin_invoice_items.AMOUNT';

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
        self::TYPE_PHPNAME       => array('Id', 'InvoiceId', 'Tmp', 'Name', 'Description', 'Qty', 'UnitPrice', 'Amount', ),
        self::TYPE_STUDLYPHPNAME => array('id', 'invoiceId', 'tmp', 'name', 'description', 'qty', 'unitPrice', 'amount', ),
        self::TYPE_COLNAME       => array(PluginInvoiceItemsTableMap::ID, PluginInvoiceItemsTableMap::INVOICE_ID, PluginInvoiceItemsTableMap::TMP, PluginInvoiceItemsTableMap::NAME, PluginInvoiceItemsTableMap::DESCRIPTION, PluginInvoiceItemsTableMap::QTY, PluginInvoiceItemsTableMap::UNIT_PRICE, PluginInvoiceItemsTableMap::AMOUNT, ),
        self::TYPE_RAW_COLNAME   => array('ID', 'INVOICE_ID', 'TMP', 'NAME', 'DESCRIPTION', 'QTY', 'UNIT_PRICE', 'AMOUNT', ),
        self::TYPE_FIELDNAME     => array('id', 'invoice_id', 'tmp', 'name', 'description', 'qty', 'unit_price', 'amount', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'InvoiceId' => 1, 'Tmp' => 2, 'Name' => 3, 'Description' => 4, 'Qty' => 5, 'UnitPrice' => 6, 'Amount' => 7, ),
        self::TYPE_STUDLYPHPNAME => array('id' => 0, 'invoiceId' => 1, 'tmp' => 2, 'name' => 3, 'description' => 4, 'qty' => 5, 'unitPrice' => 6, 'amount' => 7, ),
        self::TYPE_COLNAME       => array(PluginInvoiceItemsTableMap::ID => 0, PluginInvoiceItemsTableMap::INVOICE_ID => 1, PluginInvoiceItemsTableMap::TMP => 2, PluginInvoiceItemsTableMap::NAME => 3, PluginInvoiceItemsTableMap::DESCRIPTION => 4, PluginInvoiceItemsTableMap::QTY => 5, PluginInvoiceItemsTableMap::UNIT_PRICE => 6, PluginInvoiceItemsTableMap::AMOUNT => 7, ),
        self::TYPE_RAW_COLNAME   => array('ID' => 0, 'INVOICE_ID' => 1, 'TMP' => 2, 'NAME' => 3, 'DESCRIPTION' => 4, 'QTY' => 5, 'UNIT_PRICE' => 6, 'AMOUNT' => 7, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'invoice_id' => 1, 'tmp' => 2, 'name' => 3, 'description' => 4, 'qty' => 5, 'unit_price' => 6, 'amount' => 7, ),
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
        $this->setName('plugin_invoice_items');
        $this->setPhpName('PluginInvoiceItems');
        $this->setClassName('\\HookCalendar\\Model\\PluginInvoiceItems');
        $this->setPackage('HookCalendar.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('ID', 'Id', 'INTEGER', true, 10, null);
        $this->addColumn('INVOICE_ID', 'InvoiceId', 'INTEGER', false, 10, null);
        $this->addColumn('TMP', 'Tmp', 'VARCHAR', false, 255, null);
        $this->addColumn('NAME', 'Name', 'VARCHAR', false, 255, null);
        $this->addColumn('DESCRIPTION', 'Description', 'VARCHAR', false, 255, null);
        $this->addColumn('QTY', 'Qty', 'DECIMAL', false, 9, null);
        $this->addColumn('UNIT_PRICE', 'UnitPrice', 'DECIMAL', false, 9, null);
        $this->addColumn('AMOUNT', 'Amount', 'DECIMAL', false, 9, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
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
        return $withPrefix ? PluginInvoiceItemsTableMap::CLASS_DEFAULT : PluginInvoiceItemsTableMap::OM_CLASS;
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
     * @return array (PluginInvoiceItems object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = PluginInvoiceItemsTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = PluginInvoiceItemsTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + PluginInvoiceItemsTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = PluginInvoiceItemsTableMap::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            PluginInvoiceItemsTableMap::addInstanceToPool($obj, $key);
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
            $key = PluginInvoiceItemsTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = PluginInvoiceItemsTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                PluginInvoiceItemsTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(PluginInvoiceItemsTableMap::ID);
            $criteria->addSelectColumn(PluginInvoiceItemsTableMap::INVOICE_ID);
            $criteria->addSelectColumn(PluginInvoiceItemsTableMap::TMP);
            $criteria->addSelectColumn(PluginInvoiceItemsTableMap::NAME);
            $criteria->addSelectColumn(PluginInvoiceItemsTableMap::DESCRIPTION);
            $criteria->addSelectColumn(PluginInvoiceItemsTableMap::QTY);
            $criteria->addSelectColumn(PluginInvoiceItemsTableMap::UNIT_PRICE);
            $criteria->addSelectColumn(PluginInvoiceItemsTableMap::AMOUNT);
        } else {
            $criteria->addSelectColumn($alias . '.ID');
            $criteria->addSelectColumn($alias . '.INVOICE_ID');
            $criteria->addSelectColumn($alias . '.TMP');
            $criteria->addSelectColumn($alias . '.NAME');
            $criteria->addSelectColumn($alias . '.DESCRIPTION');
            $criteria->addSelectColumn($alias . '.QTY');
            $criteria->addSelectColumn($alias . '.UNIT_PRICE');
            $criteria->addSelectColumn($alias . '.AMOUNT');
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
        return Propel::getServiceContainer()->getDatabaseMap(PluginInvoiceItemsTableMap::DATABASE_NAME)->getTable(PluginInvoiceItemsTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getServiceContainer()->getDatabaseMap(PluginInvoiceItemsTableMap::DATABASE_NAME);
      if (!$dbMap->hasTable(PluginInvoiceItemsTableMap::TABLE_NAME)) {
        $dbMap->addTableObject(new PluginInvoiceItemsTableMap());
      }
    }

    /**
     * Performs a DELETE on the database, given a PluginInvoiceItems or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or PluginInvoiceItems object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(PluginInvoiceItemsTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \HookCalendar\Model\PluginInvoiceItems) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(PluginInvoiceItemsTableMap::DATABASE_NAME);
            $criteria->add(PluginInvoiceItemsTableMap::ID, (array) $values, Criteria::IN);
        }

        $query = PluginInvoiceItemsQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) { PluginInvoiceItemsTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) { PluginInvoiceItemsTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the plugin_invoice_items table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return PluginInvoiceItemsQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a PluginInvoiceItems or Criteria object.
     *
     * @param mixed               $criteria Criteria or PluginInvoiceItems object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PluginInvoiceItemsTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from PluginInvoiceItems object
        }

        if ($criteria->containsKey(PluginInvoiceItemsTableMap::ID) && $criteria->keyContainsValue(PluginInvoiceItemsTableMap::ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.PluginInvoiceItemsTableMap::ID.')');
        }


        // Set the correct dbName
        $query = PluginInvoiceItemsQuery::create()->mergeWith($criteria);

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

} // PluginInvoiceItemsTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
PluginInvoiceItemsTableMap::buildTableMap();
