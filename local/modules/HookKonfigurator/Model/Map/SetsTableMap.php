<?php

namespace HookKonfigurator\Model\Map;

use HookKonfigurator\Model\Sets;
use HookKonfigurator\Model\SetsQuery;
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
 * This class defines the structure of the 'sets' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class SetsTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;
    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'HookKonfigurator.Model.Map.SetsTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'thelia';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'sets';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\HookKonfigurator\\Model\\Sets';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'HookKonfigurator.Model.Sets';

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
     * the column name for the PRODUCT_ID field
     */
    const PRODUCT_ID = 'sets.PRODUCT_ID';

    /**
     * the column name for the PRIORITY field
     */
    const PRIORITY = 'sets.PRIORITY';

    /**
     * the column name for the EFFICIENCY field
     */
    const EFFICIENCY = 'sets.EFFICIENCY';

    /**
     * the column name for the POWER field
     */
    const POWER = 'sets.POWER';

    /**
     * the column name for the COMPOSED_IMAGE field
     */
    const COMPOSED_IMAGE = 'sets.COMPOSED_IMAGE';

    /**
     * the column name for the STORAGE field
     */
    const STORAGE = 'sets.STORAGE';

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
        self::TYPE_PHPNAME       => array('ProductId', 'Priority', 'Efficiency', 'Power', 'ComposedImage', 'Storage', ),
        self::TYPE_STUDLYPHPNAME => array('productId', 'priority', 'efficiency', 'power', 'composedImage', 'storage', ),
        self::TYPE_COLNAME       => array(SetsTableMap::PRODUCT_ID, SetsTableMap::PRIORITY, SetsTableMap::EFFICIENCY, SetsTableMap::POWER, SetsTableMap::COMPOSED_IMAGE, SetsTableMap::STORAGE, ),
        self::TYPE_RAW_COLNAME   => array('PRODUCT_ID', 'PRIORITY', 'EFFICIENCY', 'POWER', 'COMPOSED_IMAGE', 'STORAGE', ),
        self::TYPE_FIELDNAME     => array('product_id', 'priority', 'efficiency', 'power', 'composed_image', 'storage', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('ProductId' => 0, 'Priority' => 1, 'Efficiency' => 2, 'Power' => 3, 'ComposedImage' => 4, 'Storage' => 5, ),
        self::TYPE_STUDLYPHPNAME => array('productId' => 0, 'priority' => 1, 'efficiency' => 2, 'power' => 3, 'composedImage' => 4, 'storage' => 5, ),
        self::TYPE_COLNAME       => array(SetsTableMap::PRODUCT_ID => 0, SetsTableMap::PRIORITY => 1, SetsTableMap::EFFICIENCY => 2, SetsTableMap::POWER => 3, SetsTableMap::COMPOSED_IMAGE => 4, SetsTableMap::STORAGE => 5, ),
        self::TYPE_RAW_COLNAME   => array('PRODUCT_ID' => 0, 'PRIORITY' => 1, 'EFFICIENCY' => 2, 'POWER' => 3, 'COMPOSED_IMAGE' => 4, 'STORAGE' => 5, ),
        self::TYPE_FIELDNAME     => array('product_id' => 0, 'priority' => 1, 'efficiency' => 2, 'power' => 3, 'composed_image' => 4, 'storage' => 5, ),
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
        $this->setName('sets');
        $this->setPhpName('Sets');
        $this->setClassName('\\HookKonfigurator\\Model\\Sets');
        $this->setPackage('HookKonfigurator.Model');
        $this->setUseIdGenerator(false);
        // columns
        $this->addForeignPrimaryKey('PRODUCT_ID', 'ProductId', 'INTEGER' , 'product', 'ID', true, null, null);
        $this->addColumn('PRIORITY', 'Priority', 'INTEGER', false, null, 0);
        $this->addColumn('EFFICIENCY', 'Efficiency', 'INTEGER', false, null, 0);
        $this->addColumn('POWER', 'Power', 'INTEGER', false, null, 0);
        $this->addColumn('COMPOSED_IMAGE', 'ComposedImage', 'VARCHAR', false, 255, null);
        $this->addColumn('STORAGE', 'Storage', 'INTEGER', false, null, 0);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Product', '\\HookKonfigurator\\Model\\Product', RelationMap::MANY_TO_ONE, array('product_id' => 'id', ), 'CASCADE', null);
        $this->addRelation('SetMontage', '\\HookKonfigurator\\Model\\SetMontage', RelationMap::ONE_TO_ONE, array('product_id' => 'id', ), null, null);
        $this->addRelation('SetProducts', '\\HookKonfigurator\\Model\\SetProducts', RelationMap::ONE_TO_ONE, array('product_id' => 'id', ), null, null);
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
        return $withPrefix ? SetsTableMap::CLASS_DEFAULT : SetsTableMap::OM_CLASS;
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
     * @return array (Sets object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = SetsTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = SetsTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + SetsTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = SetsTableMap::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            SetsTableMap::addInstanceToPool($obj, $key);
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
            $key = SetsTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = SetsTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                SetsTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(SetsTableMap::PRODUCT_ID);
            $criteria->addSelectColumn(SetsTableMap::PRIORITY);
            $criteria->addSelectColumn(SetsTableMap::EFFICIENCY);
            $criteria->addSelectColumn(SetsTableMap::POWER);
            $criteria->addSelectColumn(SetsTableMap::COMPOSED_IMAGE);
            $criteria->addSelectColumn(SetsTableMap::STORAGE);
        } else {
            $criteria->addSelectColumn($alias . '.PRODUCT_ID');
            $criteria->addSelectColumn($alias . '.PRIORITY');
            $criteria->addSelectColumn($alias . '.EFFICIENCY');
            $criteria->addSelectColumn($alias . '.POWER');
            $criteria->addSelectColumn($alias . '.COMPOSED_IMAGE');
            $criteria->addSelectColumn($alias . '.STORAGE');
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
        return Propel::getServiceContainer()->getDatabaseMap(SetsTableMap::DATABASE_NAME)->getTable(SetsTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getServiceContainer()->getDatabaseMap(SetsTableMap::DATABASE_NAME);
      if (!$dbMap->hasTable(SetsTableMap::TABLE_NAME)) {
        $dbMap->addTableObject(new SetsTableMap());
      }
    }

    /**
     * Performs a DELETE on the database, given a Sets or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Sets object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(SetsTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \HookKonfigurator\Model\Sets) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(SetsTableMap::DATABASE_NAME);
            $criteria->add(SetsTableMap::PRODUCT_ID, (array) $values, Criteria::IN);
        }

        $query = SetsQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) { SetsTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) { SetsTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the sets table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return SetsQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Sets or Criteria object.
     *
     * @param mixed               $criteria Criteria or Sets object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SetsTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Sets object
        }


        // Set the correct dbName
        $query = SetsQuery::create()->mergeWith($criteria);

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

} // SetsTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
SetsTableMap::buildTableMap();
