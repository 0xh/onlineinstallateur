<?php

namespace AmazonIntegration\Model\Map;

use AmazonIntegration\Model\AmazonFinancialEventGroup;
use AmazonIntegration\Model\AmazonFinancialEventGroupQuery;
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
 * This class defines the structure of the 'amazon_financial_event_group' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class AmazonFinancialEventGroupTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;
    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'AmazonIntegration.Model.Map.AmazonFinancialEventGroupTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'thelia';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'amazon_financial_event_group';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\AmazonIntegration\\Model\\AmazonFinancialEventGroup';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'AmazonIntegration.Model.AmazonFinancialEventGroup';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 12;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 12;

    /**
     * the column name for the ID field
     */
    const ID = 'amazon_financial_event_group.ID';

    /**
     * the column name for the FINANCIALEVENTGROUPID field
     */
    const FINANCIALEVENTGROUPID = 'amazon_financial_event_group.FINANCIALEVENTGROUPID';

    /**
     * the column name for the PROCESSINGSTATUS field
     */
    const PROCESSINGSTATUS = 'amazon_financial_event_group.PROCESSINGSTATUS';

    /**
     * the column name for the FUNDTRANSFERSTATUS field
     */
    const FUNDTRANSFERSTATUS = 'amazon_financial_event_group.FUNDTRANSFERSTATUS';

    /**
     * the column name for the ORIGINALTOTAL field
     */
    const ORIGINALTOTAL = 'amazon_financial_event_group.ORIGINALTOTAL';

    /**
     * the column name for the CONVERTEDTOTAL field
     */
    const CONVERTEDTOTAL = 'amazon_financial_event_group.CONVERTEDTOTAL';

    /**
     * the column name for the FUNDTRANSFERDATE field
     */
    const FUNDTRANSFERDATE = 'amazon_financial_event_group.FUNDTRANSFERDATE';

    /**
     * the column name for the TRACEID field
     */
    const TRACEID = 'amazon_financial_event_group.TRACEID';

    /**
     * the column name for the ACCOUNTTAIL field
     */
    const ACCOUNTTAIL = 'amazon_financial_event_group.ACCOUNTTAIL';

    /**
     * the column name for the BEGINNINGBALANCE field
     */
    const BEGINNINGBALANCE = 'amazon_financial_event_group.BEGINNINGBALANCE';

    /**
     * the column name for the FINANCIALEVENTGROUPSTART field
     */
    const FINANCIALEVENTGROUPSTART = 'amazon_financial_event_group.FINANCIALEVENTGROUPSTART';

    /**
     * the column name for the FINANCIALEVENTGROUPEND field
     */
    const FINANCIALEVENTGROUPEND = 'amazon_financial_event_group.FINANCIALEVENTGROUPEND';

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
        self::TYPE_PHPNAME       => array('Id', 'FinancialEventGroupId', 'ProcessingStatus', 'FundTransferStatus', 'OriginalTotal', 'ConvertedTotal', 'FundTransferDate', 'TraceId', 'AccountTail', 'BeginningBalance', 'FinancialEventGroupStart', 'FinancialEventGroupEnd', ),
        self::TYPE_STUDLYPHPNAME => array('id', 'financialEventGroupId', 'processingStatus', 'fundTransferStatus', 'originalTotal', 'convertedTotal', 'fundTransferDate', 'traceId', 'accountTail', 'beginningBalance', 'financialEventGroupStart', 'financialEventGroupEnd', ),
        self::TYPE_COLNAME       => array(AmazonFinancialEventGroupTableMap::ID, AmazonFinancialEventGroupTableMap::FINANCIALEVENTGROUPID, AmazonFinancialEventGroupTableMap::PROCESSINGSTATUS, AmazonFinancialEventGroupTableMap::FUNDTRANSFERSTATUS, AmazonFinancialEventGroupTableMap::ORIGINALTOTAL, AmazonFinancialEventGroupTableMap::CONVERTEDTOTAL, AmazonFinancialEventGroupTableMap::FUNDTRANSFERDATE, AmazonFinancialEventGroupTableMap::TRACEID, AmazonFinancialEventGroupTableMap::ACCOUNTTAIL, AmazonFinancialEventGroupTableMap::BEGINNINGBALANCE, AmazonFinancialEventGroupTableMap::FINANCIALEVENTGROUPSTART, AmazonFinancialEventGroupTableMap::FINANCIALEVENTGROUPEND, ),
        self::TYPE_RAW_COLNAME   => array('ID', 'FINANCIALEVENTGROUPID', 'PROCESSINGSTATUS', 'FUNDTRANSFERSTATUS', 'ORIGINALTOTAL', 'CONVERTEDTOTAL', 'FUNDTRANSFERDATE', 'TRACEID', 'ACCOUNTTAIL', 'BEGINNINGBALANCE', 'FINANCIALEVENTGROUPSTART', 'FINANCIALEVENTGROUPEND', ),
        self::TYPE_FIELDNAME     => array('id', 'financialEventGroupId', 'processingStatus', 'fundTransferStatus', 'originalTotal', 'convertedTotal', 'fundTransferDate', 'traceId', 'accountTail', 'beginningBalance', 'financialEventGroupStart', 'financialEventGroupEnd', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'FinancialEventGroupId' => 1, 'ProcessingStatus' => 2, 'FundTransferStatus' => 3, 'OriginalTotal' => 4, 'ConvertedTotal' => 5, 'FundTransferDate' => 6, 'TraceId' => 7, 'AccountTail' => 8, 'BeginningBalance' => 9, 'FinancialEventGroupStart' => 10, 'FinancialEventGroupEnd' => 11, ),
        self::TYPE_STUDLYPHPNAME => array('id' => 0, 'financialEventGroupId' => 1, 'processingStatus' => 2, 'fundTransferStatus' => 3, 'originalTotal' => 4, 'convertedTotal' => 5, 'fundTransferDate' => 6, 'traceId' => 7, 'accountTail' => 8, 'beginningBalance' => 9, 'financialEventGroupStart' => 10, 'financialEventGroupEnd' => 11, ),
        self::TYPE_COLNAME       => array(AmazonFinancialEventGroupTableMap::ID => 0, AmazonFinancialEventGroupTableMap::FINANCIALEVENTGROUPID => 1, AmazonFinancialEventGroupTableMap::PROCESSINGSTATUS => 2, AmazonFinancialEventGroupTableMap::FUNDTRANSFERSTATUS => 3, AmazonFinancialEventGroupTableMap::ORIGINALTOTAL => 4, AmazonFinancialEventGroupTableMap::CONVERTEDTOTAL => 5, AmazonFinancialEventGroupTableMap::FUNDTRANSFERDATE => 6, AmazonFinancialEventGroupTableMap::TRACEID => 7, AmazonFinancialEventGroupTableMap::ACCOUNTTAIL => 8, AmazonFinancialEventGroupTableMap::BEGINNINGBALANCE => 9, AmazonFinancialEventGroupTableMap::FINANCIALEVENTGROUPSTART => 10, AmazonFinancialEventGroupTableMap::FINANCIALEVENTGROUPEND => 11, ),
        self::TYPE_RAW_COLNAME   => array('ID' => 0, 'FINANCIALEVENTGROUPID' => 1, 'PROCESSINGSTATUS' => 2, 'FUNDTRANSFERSTATUS' => 3, 'ORIGINALTOTAL' => 4, 'CONVERTEDTOTAL' => 5, 'FUNDTRANSFERDATE' => 6, 'TRACEID' => 7, 'ACCOUNTTAIL' => 8, 'BEGINNINGBALANCE' => 9, 'FINANCIALEVENTGROUPSTART' => 10, 'FINANCIALEVENTGROUPEND' => 11, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'financialEventGroupId' => 1, 'processingStatus' => 2, 'fundTransferStatus' => 3, 'originalTotal' => 4, 'convertedTotal' => 5, 'fundTransferDate' => 6, 'traceId' => 7, 'accountTail' => 8, 'beginningBalance' => 9, 'financialEventGroupStart' => 10, 'financialEventGroupEnd' => 11, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, )
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
        $this->setName('amazon_financial_event_group');
        $this->setPhpName('AmazonFinancialEventGroup');
        $this->setClassName('\\AmazonIntegration\\Model\\AmazonFinancialEventGroup');
        $this->setPackage('AmazonIntegration.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('FINANCIALEVENTGROUPID', 'FinancialEventGroupId', 'VARCHAR', false, 45, null);
        $this->addColumn('PROCESSINGSTATUS', 'ProcessingStatus', 'VARCHAR', false, 45, null);
        $this->addColumn('FUNDTRANSFERSTATUS', 'FundTransferStatus', 'VARCHAR', false, 45, null);
        $this->addColumn('ORIGINALTOTAL', 'OriginalTotal', 'DECIMAL', false, 16, 0);
        $this->addColumn('CONVERTEDTOTAL', 'ConvertedTotal', 'DECIMAL', false, 16, 0);
        $this->addColumn('FUNDTRANSFERDATE', 'FundTransferDate', 'TIMESTAMP', false, null, null);
        $this->addColumn('TRACEID', 'TraceId', 'VARCHAR', false, 45, null);
        $this->addColumn('ACCOUNTTAIL', 'AccountTail', 'VARCHAR', false, 45, null);
        $this->addColumn('BEGINNINGBALANCE', 'BeginningBalance', 'DECIMAL', false, 16, 0);
        $this->addColumn('FINANCIALEVENTGROUPSTART', 'FinancialEventGroupStart', 'TIMESTAMP', false, null, null);
        $this->addColumn('FINANCIALEVENTGROUPEND', 'FinancialEventGroupEnd', 'TIMESTAMP', false, null, null);
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
        return $withPrefix ? AmazonFinancialEventGroupTableMap::CLASS_DEFAULT : AmazonFinancialEventGroupTableMap::OM_CLASS;
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
     * @return array (AmazonFinancialEventGroup object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = AmazonFinancialEventGroupTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = AmazonFinancialEventGroupTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + AmazonFinancialEventGroupTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = AmazonFinancialEventGroupTableMap::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            AmazonFinancialEventGroupTableMap::addInstanceToPool($obj, $key);
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
            $key = AmazonFinancialEventGroupTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = AmazonFinancialEventGroupTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                AmazonFinancialEventGroupTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(AmazonFinancialEventGroupTableMap::ID);
            $criteria->addSelectColumn(AmazonFinancialEventGroupTableMap::FINANCIALEVENTGROUPID);
            $criteria->addSelectColumn(AmazonFinancialEventGroupTableMap::PROCESSINGSTATUS);
            $criteria->addSelectColumn(AmazonFinancialEventGroupTableMap::FUNDTRANSFERSTATUS);
            $criteria->addSelectColumn(AmazonFinancialEventGroupTableMap::ORIGINALTOTAL);
            $criteria->addSelectColumn(AmazonFinancialEventGroupTableMap::CONVERTEDTOTAL);
            $criteria->addSelectColumn(AmazonFinancialEventGroupTableMap::FUNDTRANSFERDATE);
            $criteria->addSelectColumn(AmazonFinancialEventGroupTableMap::TRACEID);
            $criteria->addSelectColumn(AmazonFinancialEventGroupTableMap::ACCOUNTTAIL);
            $criteria->addSelectColumn(AmazonFinancialEventGroupTableMap::BEGINNINGBALANCE);
            $criteria->addSelectColumn(AmazonFinancialEventGroupTableMap::FINANCIALEVENTGROUPSTART);
            $criteria->addSelectColumn(AmazonFinancialEventGroupTableMap::FINANCIALEVENTGROUPEND);
        } else {
            $criteria->addSelectColumn($alias . '.ID');
            $criteria->addSelectColumn($alias . '.FINANCIALEVENTGROUPID');
            $criteria->addSelectColumn($alias . '.PROCESSINGSTATUS');
            $criteria->addSelectColumn($alias . '.FUNDTRANSFERSTATUS');
            $criteria->addSelectColumn($alias . '.ORIGINALTOTAL');
            $criteria->addSelectColumn($alias . '.CONVERTEDTOTAL');
            $criteria->addSelectColumn($alias . '.FUNDTRANSFERDATE');
            $criteria->addSelectColumn($alias . '.TRACEID');
            $criteria->addSelectColumn($alias . '.ACCOUNTTAIL');
            $criteria->addSelectColumn($alias . '.BEGINNINGBALANCE');
            $criteria->addSelectColumn($alias . '.FINANCIALEVENTGROUPSTART');
            $criteria->addSelectColumn($alias . '.FINANCIALEVENTGROUPEND');
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
        return Propel::getServiceContainer()->getDatabaseMap(AmazonFinancialEventGroupTableMap::DATABASE_NAME)->getTable(AmazonFinancialEventGroupTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getServiceContainer()->getDatabaseMap(AmazonFinancialEventGroupTableMap::DATABASE_NAME);
      if (!$dbMap->hasTable(AmazonFinancialEventGroupTableMap::TABLE_NAME)) {
        $dbMap->addTableObject(new AmazonFinancialEventGroupTableMap());
      }
    }

    /**
     * Performs a DELETE on the database, given a AmazonFinancialEventGroup or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or AmazonFinancialEventGroup object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(AmazonFinancialEventGroupTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \AmazonIntegration\Model\AmazonFinancialEventGroup) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(AmazonFinancialEventGroupTableMap::DATABASE_NAME);
            $criteria->add(AmazonFinancialEventGroupTableMap::ID, (array) $values, Criteria::IN);
        }

        $query = AmazonFinancialEventGroupQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) { AmazonFinancialEventGroupTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) { AmazonFinancialEventGroupTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the amazon_financial_event_group table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return AmazonFinancialEventGroupQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a AmazonFinancialEventGroup or Criteria object.
     *
     * @param mixed               $criteria Criteria or AmazonFinancialEventGroup object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(AmazonFinancialEventGroupTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from AmazonFinancialEventGroup object
        }

        if ($criteria->containsKey(AmazonFinancialEventGroupTableMap::ID) && $criteria->keyContainsValue(AmazonFinancialEventGroupTableMap::ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.AmazonFinancialEventGroupTableMap::ID.')');
        }


        // Set the correct dbName
        $query = AmazonFinancialEventGroupQuery::create()->mergeWith($criteria);

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

} // AmazonFinancialEventGroupTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
AmazonFinancialEventGroupTableMap::buildTableMap();
