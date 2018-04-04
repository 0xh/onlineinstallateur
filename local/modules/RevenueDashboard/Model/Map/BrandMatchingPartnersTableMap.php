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
use RevenueDashboard\Model\BrandMatchingPartners;
use RevenueDashboard\Model\BrandMatchingPartnersQuery;


/**
 * This class defines the structure of the 'brand_matching_partners' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class BrandMatchingPartnersTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;
    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'RevenueDashboard.Model.Map.BrandMatchingPartnersTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'thelia';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'brand_matching_partners';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\RevenueDashboard\\Model\\BrandMatchingPartners';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'RevenueDashboard.Model.BrandMatchingPartners';

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
     * the column name for the ID field
     */
    const ID = 'brand_matching_partners.ID';

    /**
     * the column name for the BRAND_INTERN field
     */
    const BRAND_INTERN = 'brand_matching_partners.BRAND_INTERN';

    /**
     * the column name for the BRAND_EXTERN field
     */
    const BRAND_EXTERN = 'brand_matching_partners.BRAND_EXTERN';

    /**
     * the column name for the PARTNER_ID field
     */
    const PARTNER_ID = 'brand_matching_partners.PARTNER_ID';

    /**
     * the column name for the BRAND_CODE field
     */
    const BRAND_CODE = 'brand_matching_partners.BRAND_CODE';

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
        self::TYPE_PHPNAME       => array('Id', 'BrandIntern', 'BrandExtern', 'PartnerId', 'BrandCode', ),
        self::TYPE_STUDLYPHPNAME => array('id', 'brandIntern', 'brandExtern', 'partnerId', 'brandCode', ),
        self::TYPE_COLNAME       => array(BrandMatchingPartnersTableMap::ID, BrandMatchingPartnersTableMap::BRAND_INTERN, BrandMatchingPartnersTableMap::BRAND_EXTERN, BrandMatchingPartnersTableMap::PARTNER_ID, BrandMatchingPartnersTableMap::BRAND_CODE, ),
        self::TYPE_RAW_COLNAME   => array('ID', 'BRAND_INTERN', 'BRAND_EXTERN', 'PARTNER_ID', 'BRAND_CODE', ),
        self::TYPE_FIELDNAME     => array('id', 'brand_intern', 'brand_extern', 'partner_id', 'brand_code', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'BrandIntern' => 1, 'BrandExtern' => 2, 'PartnerId' => 3, 'BrandCode' => 4, ),
        self::TYPE_STUDLYPHPNAME => array('id' => 0, 'brandIntern' => 1, 'brandExtern' => 2, 'partnerId' => 3, 'brandCode' => 4, ),
        self::TYPE_COLNAME       => array(BrandMatchingPartnersTableMap::ID => 0, BrandMatchingPartnersTableMap::BRAND_INTERN => 1, BrandMatchingPartnersTableMap::BRAND_EXTERN => 2, BrandMatchingPartnersTableMap::PARTNER_ID => 3, BrandMatchingPartnersTableMap::BRAND_CODE => 4, ),
        self::TYPE_RAW_COLNAME   => array('ID' => 0, 'BRAND_INTERN' => 1, 'BRAND_EXTERN' => 2, 'PARTNER_ID' => 3, 'BRAND_CODE' => 4, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'brand_intern' => 1, 'brand_extern' => 2, 'partner_id' => 3, 'brand_code' => 4, ),
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
        $this->setName('brand_matching_partners');
        $this->setPhpName('BrandMatchingPartners');
        $this->setClassName('\\RevenueDashboard\\Model\\BrandMatchingPartners');
        $this->setPackage('RevenueDashboard.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('BRAND_INTERN', 'BrandIntern', 'INTEGER', 'brand', 'ID', false, null, null);
        $this->addColumn('BRAND_EXTERN', 'BrandExtern', 'VARCHAR', false, 45, null);
        $this->addColumn('PARTNER_ID', 'PartnerId', 'INTEGER', false, null, null);
        $this->addColumn('BRAND_CODE', 'BrandCode', 'VARCHAR', false, 45, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Brand', '\\Thelia\\Model\\Brand', RelationMap::MANY_TO_ONE, array('brand_intern' => 'id', ), 'CASCADE', null);
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
        return $withPrefix ? BrandMatchingPartnersTableMap::CLASS_DEFAULT : BrandMatchingPartnersTableMap::OM_CLASS;
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
     * @return array (BrandMatchingPartners object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = BrandMatchingPartnersTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = BrandMatchingPartnersTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + BrandMatchingPartnersTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = BrandMatchingPartnersTableMap::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            BrandMatchingPartnersTableMap::addInstanceToPool($obj, $key);
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
            $key = BrandMatchingPartnersTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = BrandMatchingPartnersTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                BrandMatchingPartnersTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(BrandMatchingPartnersTableMap::ID);
            $criteria->addSelectColumn(BrandMatchingPartnersTableMap::BRAND_INTERN);
            $criteria->addSelectColumn(BrandMatchingPartnersTableMap::BRAND_EXTERN);
            $criteria->addSelectColumn(BrandMatchingPartnersTableMap::PARTNER_ID);
            $criteria->addSelectColumn(BrandMatchingPartnersTableMap::BRAND_CODE);
        } else {
            $criteria->addSelectColumn($alias . '.ID');
            $criteria->addSelectColumn($alias . '.BRAND_INTERN');
            $criteria->addSelectColumn($alias . '.BRAND_EXTERN');
            $criteria->addSelectColumn($alias . '.PARTNER_ID');
            $criteria->addSelectColumn($alias . '.BRAND_CODE');
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
        return Propel::getServiceContainer()->getDatabaseMap(BrandMatchingPartnersTableMap::DATABASE_NAME)->getTable(BrandMatchingPartnersTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getServiceContainer()->getDatabaseMap(BrandMatchingPartnersTableMap::DATABASE_NAME);
      if (!$dbMap->hasTable(BrandMatchingPartnersTableMap::TABLE_NAME)) {
        $dbMap->addTableObject(new BrandMatchingPartnersTableMap());
      }
    }

    /**
     * Performs a DELETE on the database, given a BrandMatchingPartners or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or BrandMatchingPartners object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(BrandMatchingPartnersTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \RevenueDashboard\Model\BrandMatchingPartners) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(BrandMatchingPartnersTableMap::DATABASE_NAME);
            $criteria->add(BrandMatchingPartnersTableMap::ID, (array) $values, Criteria::IN);
        }

        $query = BrandMatchingPartnersQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) { BrandMatchingPartnersTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) { BrandMatchingPartnersTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the brand_matching_partners table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return BrandMatchingPartnersQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a BrandMatchingPartners or Criteria object.
     *
     * @param mixed               $criteria Criteria or BrandMatchingPartners object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(BrandMatchingPartnersTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from BrandMatchingPartners object
        }

        if ($criteria->containsKey(BrandMatchingPartnersTableMap::ID) && $criteria->keyContainsValue(BrandMatchingPartnersTableMap::ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.BrandMatchingPartnersTableMap::ID.')');
        }


        // Set the correct dbName
        $query = BrandMatchingPartnersQuery::create()->mergeWith($criteria);

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

} // BrandMatchingPartnersTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
BrandMatchingPartnersTableMap::buildTableMap();
