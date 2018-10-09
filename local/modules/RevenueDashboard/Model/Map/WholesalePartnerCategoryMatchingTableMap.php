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
use RevenueDashboard\Model\WholesalePartnerCategoryMatching;
use RevenueDashboard\Model\WholesalePartnerCategoryMatchingQuery;


/**
 * This class defines the structure of the 'wholesale_partner_category_matching' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class WholesalePartnerCategoryMatchingTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;
    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'RevenueDashboard.Model.Map.WholesalePartnerCategoryMatchingTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'thelia';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'wholesale_partner_category_matching';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\RevenueDashboard\\Model\\WholesalePartnerCategoryMatching';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'RevenueDashboard.Model.WholesalePartnerCategoryMatching';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 7;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 7;

    /**
     * the column name for the ID field
     */
    const ID = 'wholesale_partner_category_matching.ID';

    /**
     * the column name for the CATEGORY_INTERN_ID field
     */
    const CATEGORY_INTERN_ID = 'wholesale_partner_category_matching.CATEGORY_INTERN_ID';

    /**
     * the column name for the CATEGORY_INTERN_NAME field
     */
    const CATEGORY_INTERN_NAME = 'wholesale_partner_category_matching.CATEGORY_INTERN_NAME';

    /**
     * the column name for the CATEGORY_EXTERN_ID field
     */
    const CATEGORY_EXTERN_ID = 'wholesale_partner_category_matching.CATEGORY_EXTERN_ID';

    /**
     * the column name for the CATEGORY_EXTERN_NAME field
     */
    const CATEGORY_EXTERN_NAME = 'wholesale_partner_category_matching.CATEGORY_EXTERN_NAME';

    /**
     * the column name for the PARTNER_ID field
     */
    const PARTNER_ID = 'wholesale_partner_category_matching.PARTNER_ID';

    /**
     * the column name for the CATEGORY_ID field
     */
    const CATEGORY_ID = 'wholesale_partner_category_matching.CATEGORY_ID';

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
        self::TYPE_PHPNAME       => array('Id', 'CategoryInternId', 'CategoryInternName', 'CategoryExternId', 'CategoryExternName', 'PartnerId', 'CategoryCode', ),
        self::TYPE_STUDLYPHPNAME => array('id', 'categoryInternId', 'categoryInternName', 'categoryExternId', 'categoryExternName', 'partnerId', 'categoryCode', ),
        self::TYPE_COLNAME       => array(WholesalePartnerCategoryMatchingTableMap::ID, WholesalePartnerCategoryMatchingTableMap::CATEGORY_INTERN_ID, WholesalePartnerCategoryMatchingTableMap::CATEGORY_INTERN_NAME, WholesalePartnerCategoryMatchingTableMap::CATEGORY_EXTERN_ID, WholesalePartnerCategoryMatchingTableMap::CATEGORY_EXTERN_NAME, WholesalePartnerCategoryMatchingTableMap::PARTNER_ID, WholesalePartnerCategoryMatchingTableMap::CATEGORY_ID, ),
        self::TYPE_RAW_COLNAME   => array('ID', 'CATEGORY_INTERN_ID', 'CATEGORY_INTERN_NAME', 'CATEGORY_EXTERN_ID', 'CATEGORY_EXTERN_NAME', 'PARTNER_ID', 'CATEGORY_ID', ),
        self::TYPE_FIELDNAME     => array('id', 'category_intern_id', 'category_intern_name', 'category_extern_id', 'category_extern_name', 'partner_id', 'category_id', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'CategoryInternId' => 1, 'CategoryInternName' => 2, 'CategoryExternId' => 3, 'CategoryExternName' => 4, 'PartnerId' => 5, 'CategoryCode' => 6, ),
        self::TYPE_STUDLYPHPNAME => array('id' => 0, 'categoryInternId' => 1, 'categoryInternName' => 2, 'categoryExternId' => 3, 'categoryExternName' => 4, 'partnerId' => 5, 'categoryCode' => 6, ),
        self::TYPE_COLNAME       => array(WholesalePartnerCategoryMatchingTableMap::ID => 0, WholesalePartnerCategoryMatchingTableMap::CATEGORY_INTERN_ID => 1, WholesalePartnerCategoryMatchingTableMap::CATEGORY_INTERN_NAME => 2, WholesalePartnerCategoryMatchingTableMap::CATEGORY_EXTERN_ID => 3, WholesalePartnerCategoryMatchingTableMap::CATEGORY_EXTERN_NAME => 4, WholesalePartnerCategoryMatchingTableMap::PARTNER_ID => 5, WholesalePartnerCategoryMatchingTableMap::CATEGORY_ID => 6, ),
        self::TYPE_RAW_COLNAME   => array('ID' => 0, 'CATEGORY_INTERN_ID' => 1, 'CATEGORY_INTERN_NAME' => 2, 'CATEGORY_EXTERN_ID' => 3, 'CATEGORY_EXTERN_NAME' => 4, 'PARTNER_ID' => 5, 'CATEGORY_ID' => 6, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'category_intern_id' => 1, 'category_intern_name' => 2, 'category_extern_id' => 3, 'category_extern_name' => 4, 'partner_id' => 5, 'category_id' => 6, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, )
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
        $this->setName('wholesale_partner_category_matching');
        $this->setPhpName('WholesalePartnerCategoryMatching');
        $this->setClassName('\\RevenueDashboard\\Model\\WholesalePartnerCategoryMatching');
        $this->setPackage('RevenueDashboard.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('CATEGORY_INTERN_ID', 'CategoryInternId', 'INTEGER', 'category', 'ID', false, null, null);
        $this->addColumn('CATEGORY_INTERN_NAME', 'CategoryInternName', 'VARCHAR', false, 45, null);
        $this->addColumn('CATEGORY_EXTERN_ID', 'CategoryExternId', 'VARCHAR', false, 45, null);
        $this->addColumn('CATEGORY_EXTERN_NAME', 'CategoryExternName', 'VARCHAR', false, 45, null);
        $this->addColumn('PARTNER_ID', 'PartnerId', 'INTEGER', false, null, null);
        $this->addColumn('CATEGORY_ID', 'CategoryCode', 'VARCHAR', false, 45, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Category', '\\Thelia\\Model\\Category', RelationMap::MANY_TO_ONE, array('category_intern_id' => 'id', ), 'CASCADE', null);
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
        return $withPrefix ? WholesalePartnerCategoryMatchingTableMap::CLASS_DEFAULT : WholesalePartnerCategoryMatchingTableMap::OM_CLASS;
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
     * @return array (WholesalePartnerCategoryMatching object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = WholesalePartnerCategoryMatchingTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = WholesalePartnerCategoryMatchingTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + WholesalePartnerCategoryMatchingTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = WholesalePartnerCategoryMatchingTableMap::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            WholesalePartnerCategoryMatchingTableMap::addInstanceToPool($obj, $key);
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
            $key = WholesalePartnerCategoryMatchingTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = WholesalePartnerCategoryMatchingTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                WholesalePartnerCategoryMatchingTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(WholesalePartnerCategoryMatchingTableMap::ID);
            $criteria->addSelectColumn(WholesalePartnerCategoryMatchingTableMap::CATEGORY_INTERN_ID);
            $criteria->addSelectColumn(WholesalePartnerCategoryMatchingTableMap::CATEGORY_INTERN_NAME);
            $criteria->addSelectColumn(WholesalePartnerCategoryMatchingTableMap::CATEGORY_EXTERN_ID);
            $criteria->addSelectColumn(WholesalePartnerCategoryMatchingTableMap::CATEGORY_EXTERN_NAME);
            $criteria->addSelectColumn(WholesalePartnerCategoryMatchingTableMap::PARTNER_ID);
            $criteria->addSelectColumn(WholesalePartnerCategoryMatchingTableMap::CATEGORY_ID);
        } else {
            $criteria->addSelectColumn($alias . '.ID');
            $criteria->addSelectColumn($alias . '.CATEGORY_INTERN_ID');
            $criteria->addSelectColumn($alias . '.CATEGORY_INTERN_NAME');
            $criteria->addSelectColumn($alias . '.CATEGORY_EXTERN_ID');
            $criteria->addSelectColumn($alias . '.CATEGORY_EXTERN_NAME');
            $criteria->addSelectColumn($alias . '.PARTNER_ID');
            $criteria->addSelectColumn($alias . '.CATEGORY_ID');
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
        return Propel::getServiceContainer()->getDatabaseMap(WholesalePartnerCategoryMatchingTableMap::DATABASE_NAME)->getTable(WholesalePartnerCategoryMatchingTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getServiceContainer()->getDatabaseMap(WholesalePartnerCategoryMatchingTableMap::DATABASE_NAME);
      if (!$dbMap->hasTable(WholesalePartnerCategoryMatchingTableMap::TABLE_NAME)) {
        $dbMap->addTableObject(new WholesalePartnerCategoryMatchingTableMap());
      }
    }

    /**
     * Performs a DELETE on the database, given a WholesalePartnerCategoryMatching or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or WholesalePartnerCategoryMatching object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(WholesalePartnerCategoryMatchingTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \RevenueDashboard\Model\WholesalePartnerCategoryMatching) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(WholesalePartnerCategoryMatchingTableMap::DATABASE_NAME);
            $criteria->add(WholesalePartnerCategoryMatchingTableMap::ID, (array) $values, Criteria::IN);
        }

        $query = WholesalePartnerCategoryMatchingQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) { WholesalePartnerCategoryMatchingTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) { WholesalePartnerCategoryMatchingTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the wholesale_partner_category_matching table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return WholesalePartnerCategoryMatchingQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a WholesalePartnerCategoryMatching or Criteria object.
     *
     * @param mixed               $criteria Criteria or WholesalePartnerCategoryMatching object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(WholesalePartnerCategoryMatchingTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from WholesalePartnerCategoryMatching object
        }

        if ($criteria->containsKey(WholesalePartnerCategoryMatchingTableMap::ID) && $criteria->keyContainsValue(WholesalePartnerCategoryMatchingTableMap::ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.WholesalePartnerCategoryMatchingTableMap::ID.')');
        }


        // Set the correct dbName
        $query = WholesalePartnerCategoryMatchingQuery::create()->mergeWith($criteria);

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

} // WholesalePartnerCategoryMatchingTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
WholesalePartnerCategoryMatchingTableMap::buildTableMap();
