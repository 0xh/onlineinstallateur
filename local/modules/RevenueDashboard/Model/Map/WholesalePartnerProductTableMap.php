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
use RevenueDashboard\Model\WholesalePartnerProduct;
use RevenueDashboard\Model\WholesalePartnerProductQuery;


/**
 * This class defines the structure of the 'wholesale_partner_product' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class WholesalePartnerProductTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;
    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'RevenueDashboard.Model.Map.WholesalePartnerProductTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'thelia';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'wholesale_partner_product';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\RevenueDashboard\\Model\\WholesalePartnerProduct';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'RevenueDashboard.Model.WholesalePartnerProduct';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 16;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 16;

    /**
     * the column name for the ID field
     */
    const ID = 'wholesale_partner_product.ID';

    /**
     * the column name for the PARTNER_ID field
     */
    const PARTNER_ID = 'wholesale_partner_product.PARTNER_ID';

    /**
     * the column name for the PRODUCT_ID field
     */
    const PRODUCT_ID = 'wholesale_partner_product.PRODUCT_ID';

    /**
     * the column name for the PARTNER_PRODUCT_REF field
     */
    const PARTNER_PRODUCT_REF = 'wholesale_partner_product.PARTNER_PRODUCT_REF';

    /**
     * the column name for the PRICE field
     */
    const PRICE = 'wholesale_partner_product.PRICE';

    /**
     * the column name for the PACKAGE_SIZE field
     */
    const PACKAGE_SIZE = 'wholesale_partner_product.PACKAGE_SIZE';

    /**
     * the column name for the DELIVERY_COST field
     */
    const DELIVERY_COST = 'wholesale_partner_product.DELIVERY_COST';

    /**
     * the column name for the DISCOUNT field
     */
    const DISCOUNT = 'wholesale_partner_product.DISCOUNT';

    /**
     * the column name for the DISCOUNT_DESCRIPTION field
     */
    const DISCOUNT_DESCRIPTION = 'wholesale_partner_product.DISCOUNT_DESCRIPTION';

    /**
     * the column name for the PROFILE_WEBSITE field
     */
    const PROFILE_WEBSITE = 'wholesale_partner_product.PROFILE_WEBSITE';

    /**
     * the column name for the POSITION field
     */
    const POSITION = 'wholesale_partner_product.POSITION';

    /**
     * the column name for the DEPARTMENT field
     */
    const DEPARTMENT = 'wholesale_partner_product.DEPARTMENT';

    /**
     * the column name for the COMMENT field
     */
    const COMMENT = 'wholesale_partner_product.COMMENT';

    /**
     * the column name for the VALID_UNTIL field
     */
    const VALID_UNTIL = 'wholesale_partner_product.VALID_UNTIL';

    /**
     * the column name for the VERSION field
     */
    const VERSION = 'wholesale_partner_product.VERSION';

    /**
     * the column name for the VERSION_CREATED_BY field
     */
    const VERSION_CREATED_BY = 'wholesale_partner_product.VERSION_CREATED_BY';

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
        self::TYPE_PHPNAME       => array('Id', 'PartnerId', 'ProductId', 'PartnerProdRef', 'Price', 'PackageSize', 'DeliveryCost', 'Discount', 'DiscountDescription', 'ProfileWebsite', 'Position', 'Department', 'Comment', 'ValidUntil', 'Version', 'VersionCreatedBy', ),
        self::TYPE_STUDLYPHPNAME => array('id', 'partnerId', 'productId', 'partnerProdRef', 'price', 'packageSize', 'deliveryCost', 'discount', 'discountDescription', 'profileWebsite', 'position', 'department', 'comment', 'validUntil', 'version', 'versionCreatedBy', ),
        self::TYPE_COLNAME       => array(WholesalePartnerProductTableMap::ID, WholesalePartnerProductTableMap::PARTNER_ID, WholesalePartnerProductTableMap::PRODUCT_ID, WholesalePartnerProductTableMap::PARTNER_PRODUCT_REF, WholesalePartnerProductTableMap::PRICE, WholesalePartnerProductTableMap::PACKAGE_SIZE, WholesalePartnerProductTableMap::DELIVERY_COST, WholesalePartnerProductTableMap::DISCOUNT, WholesalePartnerProductTableMap::DISCOUNT_DESCRIPTION, WholesalePartnerProductTableMap::PROFILE_WEBSITE, WholesalePartnerProductTableMap::POSITION, WholesalePartnerProductTableMap::DEPARTMENT, WholesalePartnerProductTableMap::COMMENT, WholesalePartnerProductTableMap::VALID_UNTIL, WholesalePartnerProductTableMap::VERSION, WholesalePartnerProductTableMap::VERSION_CREATED_BY, ),
        self::TYPE_RAW_COLNAME   => array('ID', 'PARTNER_ID', 'PRODUCT_ID', 'PARTNER_PRODUCT_REF', 'PRICE', 'PACKAGE_SIZE', 'DELIVERY_COST', 'DISCOUNT', 'DISCOUNT_DESCRIPTION', 'PROFILE_WEBSITE', 'POSITION', 'DEPARTMENT', 'COMMENT', 'VALID_UNTIL', 'VERSION', 'VERSION_CREATED_BY', ),
        self::TYPE_FIELDNAME     => array('id', 'partner_id', 'product_id', 'partner_product_ref', 'price', 'package_size', 'delivery_cost', 'discount', 'discount_description', 'profile_website', 'position', 'department', 'comment', 'valid_until', 'version', 'version_created_by', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'PartnerId' => 1, 'ProductId' => 2, 'PartnerProdRef' => 3, 'Price' => 4, 'PackageSize' => 5, 'DeliveryCost' => 6, 'Discount' => 7, 'DiscountDescription' => 8, 'ProfileWebsite' => 9, 'Position' => 10, 'Department' => 11, 'Comment' => 12, 'ValidUntil' => 13, 'Version' => 14, 'VersionCreatedBy' => 15, ),
        self::TYPE_STUDLYPHPNAME => array('id' => 0, 'partnerId' => 1, 'productId' => 2, 'partnerProdRef' => 3, 'price' => 4, 'packageSize' => 5, 'deliveryCost' => 6, 'discount' => 7, 'discountDescription' => 8, 'profileWebsite' => 9, 'position' => 10, 'department' => 11, 'comment' => 12, 'validUntil' => 13, 'version' => 14, 'versionCreatedBy' => 15, ),
        self::TYPE_COLNAME       => array(WholesalePartnerProductTableMap::ID => 0, WholesalePartnerProductTableMap::PARTNER_ID => 1, WholesalePartnerProductTableMap::PRODUCT_ID => 2, WholesalePartnerProductTableMap::PARTNER_PRODUCT_REF => 3, WholesalePartnerProductTableMap::PRICE => 4, WholesalePartnerProductTableMap::PACKAGE_SIZE => 5, WholesalePartnerProductTableMap::DELIVERY_COST => 6, WholesalePartnerProductTableMap::DISCOUNT => 7, WholesalePartnerProductTableMap::DISCOUNT_DESCRIPTION => 8, WholesalePartnerProductTableMap::PROFILE_WEBSITE => 9, WholesalePartnerProductTableMap::POSITION => 10, WholesalePartnerProductTableMap::DEPARTMENT => 11, WholesalePartnerProductTableMap::COMMENT => 12, WholesalePartnerProductTableMap::VALID_UNTIL => 13, WholesalePartnerProductTableMap::VERSION => 14, WholesalePartnerProductTableMap::VERSION_CREATED_BY => 15, ),
        self::TYPE_RAW_COLNAME   => array('ID' => 0, 'PARTNER_ID' => 1, 'PRODUCT_ID' => 2, 'PARTNER_PRODUCT_REF' => 3, 'PRICE' => 4, 'PACKAGE_SIZE' => 5, 'DELIVERY_COST' => 6, 'DISCOUNT' => 7, 'DISCOUNT_DESCRIPTION' => 8, 'PROFILE_WEBSITE' => 9, 'POSITION' => 10, 'DEPARTMENT' => 11, 'COMMENT' => 12, 'VALID_UNTIL' => 13, 'VERSION' => 14, 'VERSION_CREATED_BY' => 15, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'partner_id' => 1, 'product_id' => 2, 'partner_product_ref' => 3, 'price' => 4, 'package_size' => 5, 'delivery_cost' => 6, 'discount' => 7, 'discount_description' => 8, 'profile_website' => 9, 'position' => 10, 'department' => 11, 'comment' => 12, 'valid_until' => 13, 'version' => 14, 'version_created_by' => 15, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, )
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
        $this->setName('wholesale_partner_product');
        $this->setPhpName('WholesalePartnerProduct');
        $this->setClassName('\\RevenueDashboard\\Model\\WholesalePartnerProduct');
        $this->setPackage('RevenueDashboard.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('PARTNER_ID', 'PartnerId', 'INTEGER', false, null, null);
        $this->addForeignKey('PRODUCT_ID', 'ProductId', 'INTEGER', 'product', 'ID', false, null, null);
        $this->addColumn('PARTNER_PRODUCT_REF', 'PartnerProdRef', 'VARCHAR', false, 255, null);
        $this->addColumn('PRICE', 'Price', 'DECIMAL', false, 16, 0);
        $this->addColumn('PACKAGE_SIZE', 'PackageSize', 'INTEGER', false, null, null);
        $this->addColumn('DELIVERY_COST', 'DeliveryCost', 'DECIMAL', false, 16, 0);
        $this->addColumn('DISCOUNT', 'Discount', 'DECIMAL', false, 16, 0);
        $this->addColumn('DISCOUNT_DESCRIPTION', 'DiscountDescription', 'VARCHAR', false, 255, null);
        $this->addColumn('PROFILE_WEBSITE', 'ProfileWebsite', 'VARCHAR', false, 255, null);
        $this->addColumn('POSITION', 'Position', 'VARCHAR', false, 255, null);
        $this->addColumn('DEPARTMENT', 'Department', 'VARCHAR', false, 255, null);
        $this->addColumn('COMMENT', 'Comment', 'VARCHAR', false, 255, null);
        $this->addColumn('VALID_UNTIL', 'ValidUntil', 'TIMESTAMP', false, null, null);
        $this->addColumn('VERSION', 'Version', 'INTEGER', false, null, 0);
        $this->addColumn('VERSION_CREATED_BY', 'VersionCreatedBy', 'VARCHAR', false, 100, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Product', '\\Thelia\\Model\\Product', RelationMap::MANY_TO_ONE, array('product_id' => 'id', ), 'CASCADE', null);
        $this->addRelation('WholesalePartnerProductVersion', '\\RevenueDashboard\\Model\\WholesalePartnerProductVersion', RelationMap::ONE_TO_MANY, array('id' => 'id', ), 'CASCADE', null, 'WholesalePartnerProductVersions');
    } // buildRelations()

    /**
     *
     * Gets the list of behaviors registered for this table
     *
     * @return array Associative array (name => parameters) of behaviors
     */
    public function getBehaviors()
    {
        return array(
            'versionable' => array('version_column' => 'version', 'version_table' => '', 'log_created_at' => 'false', 'log_created_by' => 'true', 'log_comment' => 'false', 'version_created_at_column' => 'version_created_at', 'version_created_by_column' => 'version_created_by', 'version_comment_column' => 'version_comment', 'log_valid_until' => 'valid_until', ),
        );
    } // getBehaviors()
    /**
     * Method to invalidate the instance pool of all tables related to wholesale_partner_product     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
        // Invalidate objects in ".$this->getClassNameFromBuilder($joinedTableTableMapBuilder)." instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
                WholesalePartnerProductVersionTableMap::clearInstancePool();
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
        return $withPrefix ? WholesalePartnerProductTableMap::CLASS_DEFAULT : WholesalePartnerProductTableMap::OM_CLASS;
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
     * @return array (WholesalePartnerProduct object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = WholesalePartnerProductTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = WholesalePartnerProductTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + WholesalePartnerProductTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = WholesalePartnerProductTableMap::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            WholesalePartnerProductTableMap::addInstanceToPool($obj, $key);
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
            $key = WholesalePartnerProductTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = WholesalePartnerProductTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                WholesalePartnerProductTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(WholesalePartnerProductTableMap::ID);
            $criteria->addSelectColumn(WholesalePartnerProductTableMap::PARTNER_ID);
            $criteria->addSelectColumn(WholesalePartnerProductTableMap::PRODUCT_ID);
            $criteria->addSelectColumn(WholesalePartnerProductTableMap::PARTNER_PRODUCT_REF);
            $criteria->addSelectColumn(WholesalePartnerProductTableMap::PRICE);
            $criteria->addSelectColumn(WholesalePartnerProductTableMap::PACKAGE_SIZE);
            $criteria->addSelectColumn(WholesalePartnerProductTableMap::DELIVERY_COST);
            $criteria->addSelectColumn(WholesalePartnerProductTableMap::DISCOUNT);
            $criteria->addSelectColumn(WholesalePartnerProductTableMap::DISCOUNT_DESCRIPTION);
            $criteria->addSelectColumn(WholesalePartnerProductTableMap::PROFILE_WEBSITE);
            $criteria->addSelectColumn(WholesalePartnerProductTableMap::POSITION);
            $criteria->addSelectColumn(WholesalePartnerProductTableMap::DEPARTMENT);
            $criteria->addSelectColumn(WholesalePartnerProductTableMap::COMMENT);
            $criteria->addSelectColumn(WholesalePartnerProductTableMap::VALID_UNTIL);
            $criteria->addSelectColumn(WholesalePartnerProductTableMap::VERSION);
            $criteria->addSelectColumn(WholesalePartnerProductTableMap::VERSION_CREATED_BY);
        } else {
            $criteria->addSelectColumn($alias . '.ID');
            $criteria->addSelectColumn($alias . '.PARTNER_ID');
            $criteria->addSelectColumn($alias . '.PRODUCT_ID');
            $criteria->addSelectColumn($alias . '.PARTNER_PRODUCT_REF');
            $criteria->addSelectColumn($alias . '.PRICE');
            $criteria->addSelectColumn($alias . '.PACKAGE_SIZE');
            $criteria->addSelectColumn($alias . '.DELIVERY_COST');
            $criteria->addSelectColumn($alias . '.DISCOUNT');
            $criteria->addSelectColumn($alias . '.DISCOUNT_DESCRIPTION');
            $criteria->addSelectColumn($alias . '.PROFILE_WEBSITE');
            $criteria->addSelectColumn($alias . '.POSITION');
            $criteria->addSelectColumn($alias . '.DEPARTMENT');
            $criteria->addSelectColumn($alias . '.COMMENT');
            $criteria->addSelectColumn($alias . '.VALID_UNTIL');
            $criteria->addSelectColumn($alias . '.VERSION');
            $criteria->addSelectColumn($alias . '.VERSION_CREATED_BY');
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
        return Propel::getServiceContainer()->getDatabaseMap(WholesalePartnerProductTableMap::DATABASE_NAME)->getTable(WholesalePartnerProductTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getServiceContainer()->getDatabaseMap(WholesalePartnerProductTableMap::DATABASE_NAME);
      if (!$dbMap->hasTable(WholesalePartnerProductTableMap::TABLE_NAME)) {
        $dbMap->addTableObject(new WholesalePartnerProductTableMap());
      }
    }

    /**
     * Performs a DELETE on the database, given a WholesalePartnerProduct or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or WholesalePartnerProduct object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(WholesalePartnerProductTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \RevenueDashboard\Model\WholesalePartnerProduct) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(WholesalePartnerProductTableMap::DATABASE_NAME);
            $criteria->add(WholesalePartnerProductTableMap::ID, (array) $values, Criteria::IN);
        }

        $query = WholesalePartnerProductQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) { WholesalePartnerProductTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) { WholesalePartnerProductTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the wholesale_partner_product table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return WholesalePartnerProductQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a WholesalePartnerProduct or Criteria object.
     *
     * @param mixed               $criteria Criteria or WholesalePartnerProduct object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(WholesalePartnerProductTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from WholesalePartnerProduct object
        }

        if ($criteria->containsKey(WholesalePartnerProductTableMap::ID) && $criteria->keyContainsValue(WholesalePartnerProductTableMap::ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.WholesalePartnerProductTableMap::ID.')');
        }


        // Set the correct dbName
        $query = WholesalePartnerProductQuery::create()->mergeWith($criteria);

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

} // WholesalePartnerProductTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
WholesalePartnerProductTableMap::buildTableMap();
