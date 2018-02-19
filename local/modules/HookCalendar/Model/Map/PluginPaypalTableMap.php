<?php

namespace HookCalendar\Model\Map;

use HookCalendar\Model\PluginPaypal;
use HookCalendar\Model\PluginPaypalQuery;
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
 * This class defines the structure of the 'plugin_paypal' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class PluginPaypalTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;
    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'HookCalendar.Model.Map.PluginPaypalTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'thelia';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'plugin_paypal';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\HookCalendar\\Model\\PluginPaypal';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'HookCalendar.Model.PluginPaypal';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 9;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 9;

    /**
     * the column name for the ID field
     */
    const ID = 'plugin_paypal.ID';

    /**
     * the column name for the FOREIGN_ID field
     */
    const FOREIGN_ID = 'plugin_paypal.FOREIGN_ID';

    /**
     * the column name for the SUBSCR_ID field
     */
    const SUBSCR_ID = 'plugin_paypal.SUBSCR_ID';

    /**
     * the column name for the TXN_ID field
     */
    const TXN_ID = 'plugin_paypal.TXN_ID';

    /**
     * the column name for the TXN_TYPE field
     */
    const TXN_TYPE = 'plugin_paypal.TXN_TYPE';

    /**
     * the column name for the MC_GROSS field
     */
    const MC_GROSS = 'plugin_paypal.MC_GROSS';

    /**
     * the column name for the MC_CURRENCY field
     */
    const MC_CURRENCY = 'plugin_paypal.MC_CURRENCY';

    /**
     * the column name for the PAYER_EMAIL field
     */
    const PAYER_EMAIL = 'plugin_paypal.PAYER_EMAIL';

    /**
     * the column name for the DT field
     */
    const DT = 'plugin_paypal.DT';

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
        self::TYPE_PHPNAME       => array('Id', 'ForeignId', 'SubscrId', 'TxnId', 'TxnType', 'McGross', 'McCurrency', 'PayerEmail', 'Dt', ),
        self::TYPE_STUDLYPHPNAME => array('id', 'foreignId', 'subscrId', 'txnId', 'txnType', 'mcGross', 'mcCurrency', 'payerEmail', 'dt', ),
        self::TYPE_COLNAME       => array(PluginPaypalTableMap::ID, PluginPaypalTableMap::FOREIGN_ID, PluginPaypalTableMap::SUBSCR_ID, PluginPaypalTableMap::TXN_ID, PluginPaypalTableMap::TXN_TYPE, PluginPaypalTableMap::MC_GROSS, PluginPaypalTableMap::MC_CURRENCY, PluginPaypalTableMap::PAYER_EMAIL, PluginPaypalTableMap::DT, ),
        self::TYPE_RAW_COLNAME   => array('ID', 'FOREIGN_ID', 'SUBSCR_ID', 'TXN_ID', 'TXN_TYPE', 'MC_GROSS', 'MC_CURRENCY', 'PAYER_EMAIL', 'DT', ),
        self::TYPE_FIELDNAME     => array('id', 'foreign_id', 'subscr_id', 'txn_id', 'txn_type', 'mc_gross', 'mc_currency', 'payer_email', 'dt', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'ForeignId' => 1, 'SubscrId' => 2, 'TxnId' => 3, 'TxnType' => 4, 'McGross' => 5, 'McCurrency' => 6, 'PayerEmail' => 7, 'Dt' => 8, ),
        self::TYPE_STUDLYPHPNAME => array('id' => 0, 'foreignId' => 1, 'subscrId' => 2, 'txnId' => 3, 'txnType' => 4, 'mcGross' => 5, 'mcCurrency' => 6, 'payerEmail' => 7, 'dt' => 8, ),
        self::TYPE_COLNAME       => array(PluginPaypalTableMap::ID => 0, PluginPaypalTableMap::FOREIGN_ID => 1, PluginPaypalTableMap::SUBSCR_ID => 2, PluginPaypalTableMap::TXN_ID => 3, PluginPaypalTableMap::TXN_TYPE => 4, PluginPaypalTableMap::MC_GROSS => 5, PluginPaypalTableMap::MC_CURRENCY => 6, PluginPaypalTableMap::PAYER_EMAIL => 7, PluginPaypalTableMap::DT => 8, ),
        self::TYPE_RAW_COLNAME   => array('ID' => 0, 'FOREIGN_ID' => 1, 'SUBSCR_ID' => 2, 'TXN_ID' => 3, 'TXN_TYPE' => 4, 'MC_GROSS' => 5, 'MC_CURRENCY' => 6, 'PAYER_EMAIL' => 7, 'DT' => 8, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'foreign_id' => 1, 'subscr_id' => 2, 'txn_id' => 3, 'txn_type' => 4, 'mc_gross' => 5, 'mc_currency' => 6, 'payer_email' => 7, 'dt' => 8, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, )
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
        $this->setName('plugin_paypal');
        $this->setPhpName('PluginPaypal');
        $this->setClassName('\\HookCalendar\\Model\\PluginPaypal');
        $this->setPackage('HookCalendar.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('ID', 'Id', 'INTEGER', true, 10, null);
        $this->addColumn('FOREIGN_ID', 'ForeignId', 'INTEGER', false, 10, null);
        $this->addColumn('SUBSCR_ID', 'SubscrId', 'VARCHAR', false, 25, null);
        $this->addColumn('TXN_ID', 'TxnId', 'VARCHAR', false, 25, null);
        $this->addColumn('TXN_TYPE', 'TxnType', 'VARCHAR', false, 50, null);
        $this->addColumn('MC_GROSS', 'McGross', 'DECIMAL', false, 9, null);
        $this->addColumn('MC_CURRENCY', 'McCurrency', 'VARCHAR', false, 3, null);
        $this->addColumn('PAYER_EMAIL', 'PayerEmail', 'VARCHAR', false, 255, null);
        $this->addColumn('DT', 'Dt', 'TIMESTAMP', false, null, null);
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
        return $withPrefix ? PluginPaypalTableMap::CLASS_DEFAULT : PluginPaypalTableMap::OM_CLASS;
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
     * @return array (PluginPaypal object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = PluginPaypalTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = PluginPaypalTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + PluginPaypalTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = PluginPaypalTableMap::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            PluginPaypalTableMap::addInstanceToPool($obj, $key);
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
            $key = PluginPaypalTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = PluginPaypalTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                PluginPaypalTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(PluginPaypalTableMap::ID);
            $criteria->addSelectColumn(PluginPaypalTableMap::FOREIGN_ID);
            $criteria->addSelectColumn(PluginPaypalTableMap::SUBSCR_ID);
            $criteria->addSelectColumn(PluginPaypalTableMap::TXN_ID);
            $criteria->addSelectColumn(PluginPaypalTableMap::TXN_TYPE);
            $criteria->addSelectColumn(PluginPaypalTableMap::MC_GROSS);
            $criteria->addSelectColumn(PluginPaypalTableMap::MC_CURRENCY);
            $criteria->addSelectColumn(PluginPaypalTableMap::PAYER_EMAIL);
            $criteria->addSelectColumn(PluginPaypalTableMap::DT);
        } else {
            $criteria->addSelectColumn($alias . '.ID');
            $criteria->addSelectColumn($alias . '.FOREIGN_ID');
            $criteria->addSelectColumn($alias . '.SUBSCR_ID');
            $criteria->addSelectColumn($alias . '.TXN_ID');
            $criteria->addSelectColumn($alias . '.TXN_TYPE');
            $criteria->addSelectColumn($alias . '.MC_GROSS');
            $criteria->addSelectColumn($alias . '.MC_CURRENCY');
            $criteria->addSelectColumn($alias . '.PAYER_EMAIL');
            $criteria->addSelectColumn($alias . '.DT');
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
        return Propel::getServiceContainer()->getDatabaseMap(PluginPaypalTableMap::DATABASE_NAME)->getTable(PluginPaypalTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getServiceContainer()->getDatabaseMap(PluginPaypalTableMap::DATABASE_NAME);
      if (!$dbMap->hasTable(PluginPaypalTableMap::TABLE_NAME)) {
        $dbMap->addTableObject(new PluginPaypalTableMap());
      }
    }

    /**
     * Performs a DELETE on the database, given a PluginPaypal or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or PluginPaypal object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(PluginPaypalTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \HookCalendar\Model\PluginPaypal) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(PluginPaypalTableMap::DATABASE_NAME);
            $criteria->add(PluginPaypalTableMap::ID, (array) $values, Criteria::IN);
        }

        $query = PluginPaypalQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) { PluginPaypalTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) { PluginPaypalTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the plugin_paypal table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return PluginPaypalQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a PluginPaypal or Criteria object.
     *
     * @param mixed               $criteria Criteria or PluginPaypal object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PluginPaypalTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from PluginPaypal object
        }

        if ($criteria->containsKey(PluginPaypalTableMap::ID) && $criteria->keyContainsValue(PluginPaypalTableMap::ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.PluginPaypalTableMap::ID.')');
        }


        // Set the correct dbName
        $query = PluginPaypalQuery::create()->mergeWith($criteria);

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

} // PluginPaypalTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
PluginPaypalTableMap::buildTableMap();
