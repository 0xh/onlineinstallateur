<?php

namespace HookCalendar\Model\Map;

use HookCalendar\Model\BookingsServices;
use HookCalendar\Model\BookingsServicesQuery;
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
 * This class defines the structure of the 'bookings_services' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class BookingsServicesTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;
    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'HookCalendar.Model.Map.BookingsServicesTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'thelia';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'bookings_services';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\HookCalendar\\Model\\BookingsServices';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'HookCalendar.Model.BookingsServices';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 15;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 15;

    /**
     * the column name for the ID field
     */
    const ID = 'bookings_services.ID';

    /**
     * the column name for the TMP_HASH field
     */
    const TMP_HASH = 'bookings_services.TMP_HASH';

    /**
     * the column name for the BOOKING_ID field
     */
    const BOOKING_ID = 'bookings_services.BOOKING_ID';

    /**
     * the column name for the CUSTOMER_ID field
     */
    const CUSTOMER_ID = 'bookings_services.CUSTOMER_ID';

    /**
     * the column name for the CART_ITEM_ID field
     */
    const CART_ITEM_ID = 'bookings_services.CART_ITEM_ID';

    /**
     * the column name for the SERVICE_ID field
     */
    const SERVICE_ID = 'bookings_services.SERVICE_ID';

    /**
     * the column name for the EMPLOYEE_ID field
     */
    const EMPLOYEE_ID = 'bookings_services.EMPLOYEE_ID';

    /**
     * the column name for the DATE field
     */
    const DATE = 'bookings_services.DATE';

    /**
     * the column name for the START field
     */
    const START = 'bookings_services.START';

    /**
     * the column name for the START_TS field
     */
    const START_TS = 'bookings_services.START_TS';

    /**
     * the column name for the STOP_TS field
     */
    const STOP_TS = 'bookings_services.STOP_TS';

    /**
     * the column name for the REMINDER_EMAIL field
     */
    const REMINDER_EMAIL = 'bookings_services.REMINDER_EMAIL';

    /**
     * the column name for the REMINDER_SMS field
     */
    const REMINDER_SMS = 'bookings_services.REMINDER_SMS';

    /**
     * the column name for the CREATED_AT field
     */
    const CREATED_AT = 'bookings_services.CREATED_AT';

    /**
     * the column name for the UPDATED_AT field
     */
    const UPDATED_AT = 'bookings_services.UPDATED_AT';

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
        self::TYPE_PHPNAME       => array('Id', 'TmpHash', 'BookingId', 'CustomerId', 'CartItemId', 'ServiceId', 'EmployeeId', 'Date', 'Start', 'StartTs', 'StopTs', 'ReminderEmail', 'ReminderSms', 'CreatedAt', 'UpdatedAt', ),
        self::TYPE_STUDLYPHPNAME => array('id', 'tmpHash', 'bookingId', 'customerId', 'cartItemId', 'serviceId', 'employeeId', 'date', 'start', 'startTs', 'stopTs', 'reminderEmail', 'reminderSms', 'createdAt', 'updatedAt', ),
        self::TYPE_COLNAME       => array(BookingsServicesTableMap::ID, BookingsServicesTableMap::TMP_HASH, BookingsServicesTableMap::BOOKING_ID, BookingsServicesTableMap::CUSTOMER_ID, BookingsServicesTableMap::CART_ITEM_ID, BookingsServicesTableMap::SERVICE_ID, BookingsServicesTableMap::EMPLOYEE_ID, BookingsServicesTableMap::DATE, BookingsServicesTableMap::START, BookingsServicesTableMap::START_TS, BookingsServicesTableMap::STOP_TS, BookingsServicesTableMap::REMINDER_EMAIL, BookingsServicesTableMap::REMINDER_SMS, BookingsServicesTableMap::CREATED_AT, BookingsServicesTableMap::UPDATED_AT, ),
        self::TYPE_RAW_COLNAME   => array('ID', 'TMP_HASH', 'BOOKING_ID', 'CUSTOMER_ID', 'CART_ITEM_ID', 'SERVICE_ID', 'EMPLOYEE_ID', 'DATE', 'START', 'START_TS', 'STOP_TS', 'REMINDER_EMAIL', 'REMINDER_SMS', 'CREATED_AT', 'UPDATED_AT', ),
        self::TYPE_FIELDNAME     => array('id', 'tmp_hash', 'booking_id', 'customer_id', 'cart_item_id', 'service_id', 'employee_id', 'date', 'start', 'start_ts', 'stop_ts', 'reminder_email', 'reminder_sms', 'created_at', 'updated_at', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'TmpHash' => 1, 'BookingId' => 2, 'CustomerId' => 3, 'CartItemId' => 4, 'ServiceId' => 5, 'EmployeeId' => 6, 'Date' => 7, 'Start' => 8, 'StartTs' => 9, 'StopTs' => 10, 'ReminderEmail' => 11, 'ReminderSms' => 12, 'CreatedAt' => 13, 'UpdatedAt' => 14, ),
        self::TYPE_STUDLYPHPNAME => array('id' => 0, 'tmpHash' => 1, 'bookingId' => 2, 'customerId' => 3, 'cartItemId' => 4, 'serviceId' => 5, 'employeeId' => 6, 'date' => 7, 'start' => 8, 'startTs' => 9, 'stopTs' => 10, 'reminderEmail' => 11, 'reminderSms' => 12, 'createdAt' => 13, 'updatedAt' => 14, ),
        self::TYPE_COLNAME       => array(BookingsServicesTableMap::ID => 0, BookingsServicesTableMap::TMP_HASH => 1, BookingsServicesTableMap::BOOKING_ID => 2, BookingsServicesTableMap::CUSTOMER_ID => 3, BookingsServicesTableMap::CART_ITEM_ID => 4, BookingsServicesTableMap::SERVICE_ID => 5, BookingsServicesTableMap::EMPLOYEE_ID => 6, BookingsServicesTableMap::DATE => 7, BookingsServicesTableMap::START => 8, BookingsServicesTableMap::START_TS => 9, BookingsServicesTableMap::STOP_TS => 10, BookingsServicesTableMap::REMINDER_EMAIL => 11, BookingsServicesTableMap::REMINDER_SMS => 12, BookingsServicesTableMap::CREATED_AT => 13, BookingsServicesTableMap::UPDATED_AT => 14, ),
        self::TYPE_RAW_COLNAME   => array('ID' => 0, 'TMP_HASH' => 1, 'BOOKING_ID' => 2, 'CUSTOMER_ID' => 3, 'CART_ITEM_ID' => 4, 'SERVICE_ID' => 5, 'EMPLOYEE_ID' => 6, 'DATE' => 7, 'START' => 8, 'START_TS' => 9, 'STOP_TS' => 10, 'REMINDER_EMAIL' => 11, 'REMINDER_SMS' => 12, 'CREATED_AT' => 13, 'UPDATED_AT' => 14, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'tmp_hash' => 1, 'booking_id' => 2, 'customer_id' => 3, 'cart_item_id' => 4, 'service_id' => 5, 'employee_id' => 6, 'date' => 7, 'start' => 8, 'start_ts' => 9, 'stop_ts' => 10, 'reminder_email' => 11, 'reminder_sms' => 12, 'created_at' => 13, 'updated_at' => 14, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, )
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
        $this->setName('bookings_services');
        $this->setPhpName('BookingsServices');
        $this->setClassName('\\HookCalendar\\Model\\BookingsServices');
        $this->setPackage('HookCalendar.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('TMP_HASH', 'TmpHash', 'VARCHAR', false, 32, null);
        $this->addColumn('BOOKING_ID', 'BookingId', 'INTEGER', false, null, null);
        $this->addColumn('CUSTOMER_ID', 'CustomerId', 'INTEGER', false, null, null);
        $this->addColumn('CART_ITEM_ID', 'CartItemId', 'INTEGER', false, null, null);
        $this->addColumn('SERVICE_ID', 'ServiceId', 'INTEGER', false, null, null);
        $this->addColumn('EMPLOYEE_ID', 'EmployeeId', 'INTEGER', false, null, null);
        $this->addColumn('DATE', 'Date', 'DATE', false, null, null);
        $this->addColumn('START', 'Start', 'TIME', false, null, null);
        $this->addColumn('START_TS', 'StartTs', 'INTEGER', false, null, null);
        $this->addColumn('STOP_TS', 'StopTs', 'INTEGER', false, null, null);
        $this->addColumn('REMINDER_EMAIL', 'ReminderEmail', 'BOOLEAN', false, 1, false);
        $this->addColumn('REMINDER_SMS', 'ReminderSms', 'BOOLEAN', false, 1, false);
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
        return $withPrefix ? BookingsServicesTableMap::CLASS_DEFAULT : BookingsServicesTableMap::OM_CLASS;
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
     * @return array (BookingsServices object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = BookingsServicesTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = BookingsServicesTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + BookingsServicesTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = BookingsServicesTableMap::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            BookingsServicesTableMap::addInstanceToPool($obj, $key);
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
            $key = BookingsServicesTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = BookingsServicesTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                BookingsServicesTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(BookingsServicesTableMap::ID);
            $criteria->addSelectColumn(BookingsServicesTableMap::TMP_HASH);
            $criteria->addSelectColumn(BookingsServicesTableMap::BOOKING_ID);
            $criteria->addSelectColumn(BookingsServicesTableMap::CUSTOMER_ID);
            $criteria->addSelectColumn(BookingsServicesTableMap::CART_ITEM_ID);
            $criteria->addSelectColumn(BookingsServicesTableMap::SERVICE_ID);
            $criteria->addSelectColumn(BookingsServicesTableMap::EMPLOYEE_ID);
            $criteria->addSelectColumn(BookingsServicesTableMap::DATE);
            $criteria->addSelectColumn(BookingsServicesTableMap::START);
            $criteria->addSelectColumn(BookingsServicesTableMap::START_TS);
            $criteria->addSelectColumn(BookingsServicesTableMap::STOP_TS);
            $criteria->addSelectColumn(BookingsServicesTableMap::REMINDER_EMAIL);
            $criteria->addSelectColumn(BookingsServicesTableMap::REMINDER_SMS);
            $criteria->addSelectColumn(BookingsServicesTableMap::CREATED_AT);
            $criteria->addSelectColumn(BookingsServicesTableMap::UPDATED_AT);
        } else {
            $criteria->addSelectColumn($alias . '.ID');
            $criteria->addSelectColumn($alias . '.TMP_HASH');
            $criteria->addSelectColumn($alias . '.BOOKING_ID');
            $criteria->addSelectColumn($alias . '.CUSTOMER_ID');
            $criteria->addSelectColumn($alias . '.CART_ITEM_ID');
            $criteria->addSelectColumn($alias . '.SERVICE_ID');
            $criteria->addSelectColumn($alias . '.EMPLOYEE_ID');
            $criteria->addSelectColumn($alias . '.DATE');
            $criteria->addSelectColumn($alias . '.START');
            $criteria->addSelectColumn($alias . '.START_TS');
            $criteria->addSelectColumn($alias . '.STOP_TS');
            $criteria->addSelectColumn($alias . '.REMINDER_EMAIL');
            $criteria->addSelectColumn($alias . '.REMINDER_SMS');
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
        return Propel::getServiceContainer()->getDatabaseMap(BookingsServicesTableMap::DATABASE_NAME)->getTable(BookingsServicesTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getServiceContainer()->getDatabaseMap(BookingsServicesTableMap::DATABASE_NAME);
      if (!$dbMap->hasTable(BookingsServicesTableMap::TABLE_NAME)) {
        $dbMap->addTableObject(new BookingsServicesTableMap());
      }
    }

    /**
     * Performs a DELETE on the database, given a BookingsServices or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or BookingsServices object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(BookingsServicesTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \HookCalendar\Model\BookingsServices) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(BookingsServicesTableMap::DATABASE_NAME);
            $criteria->add(BookingsServicesTableMap::ID, (array) $values, Criteria::IN);
        }

        $query = BookingsServicesQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) { BookingsServicesTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) { BookingsServicesTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the bookings_services table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return BookingsServicesQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a BookingsServices or Criteria object.
     *
     * @param mixed               $criteria Criteria or BookingsServices object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(BookingsServicesTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from BookingsServices object
        }

        if ($criteria->containsKey(BookingsServicesTableMap::ID) && $criteria->keyContainsValue(BookingsServicesTableMap::ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.BookingsServicesTableMap::ID.')');
        }


        // Set the correct dbName
        $query = BookingsServicesQuery::create()->mergeWith($criteria);

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

} // BookingsServicesTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
BookingsServicesTableMap::buildTableMap();
