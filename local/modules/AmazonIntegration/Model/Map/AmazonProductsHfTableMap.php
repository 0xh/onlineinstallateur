<?php

namespace AmazonIntegration\Model\Map;

use AmazonIntegration\Model\AmazonProductsHf;
use AmazonIntegration\Model\AmazonProductsHfQuery;
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
 * This class defines the structure of the 'amazon_products_hf' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class AmazonProductsHfTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;
    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'AmazonIntegration.Model.Map.AmazonProductsHfTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'thelia';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'amazon_products_hf';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\AmazonIntegration\\Model\\AmazonProductsHf';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'AmazonIntegration.Model.AmazonProductsHf';

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
    const ID = 'amazon_products_hf.ID';

    /**
     * the column name for the PRODUCT_ID field
     */
    const PRODUCT_ID = 'amazon_products_hf.PRODUCT_ID';

    /**
     * the column name for the REF field
     */
    const REF = 'amazon_products_hf.REF';

    /**
     * the column name for the EAN_CODE field
     */
    const EAN_CODE = 'amazon_products_hf.EAN_CODE';

    /**
     * the column name for the ASIN field
     */
    const ASIN = 'amazon_products_hf.ASIN';

    /**
     * the column name for the SKU field
     */
    const SKU = 'amazon_products_hf.SKU';

    /**
     * the column name for the PRICE field
     */
    const PRICE = 'amazon_products_hf.PRICE';

    /**
     * the column name for the QUANTITY field
     */
    const QUANTITY = 'amazon_products_hf.QUANTITY';

    /**
     * the column name for the MARKETPLACE_ID field
     */
    const MARKETPLACE_ID = 'amazon_products_hf.MARKETPLACE_ID';

    /**
     * the column name for the MARKETPLACE_LOCALE field
     */
    const MARKETPLACE_LOCALE = 'amazon_products_hf.MARKETPLACE_LOCALE';

    /**
     * the column name for the CURRENCY field
     */
    const CURRENCY = 'amazon_products_hf.CURRENCY';

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
        self::TYPE_PHPNAME       => array('Id', 'ProductId', 'Ref', 'EanCode', 'ASIN', 'SKU', 'Price', 'Quantity', 'MarketplaceId', 'MarketplaceLocale', 'Currency', ),
        self::TYPE_STUDLYPHPNAME => array('id', 'productId', 'ref', 'eanCode', 'aSIN', 'sKU', 'price', 'quantity', 'marketplaceId', 'marketplaceLocale', 'currency', ),
        self::TYPE_COLNAME       => array(AmazonProductsHfTableMap::ID, AmazonProductsHfTableMap::PRODUCT_ID, AmazonProductsHfTableMap::REF, AmazonProductsHfTableMap::EAN_CODE, AmazonProductsHfTableMap::ASIN, AmazonProductsHfTableMap::SKU, AmazonProductsHfTableMap::PRICE, AmazonProductsHfTableMap::QUANTITY, AmazonProductsHfTableMap::MARKETPLACE_ID, AmazonProductsHfTableMap::MARKETPLACE_LOCALE, AmazonProductsHfTableMap::CURRENCY, ),
        self::TYPE_RAW_COLNAME   => array('ID', 'PRODUCT_ID', 'REF', 'EAN_CODE', 'ASIN', 'SKU', 'PRICE', 'QUANTITY', 'MARKETPLACE_ID', 'MARKETPLACE_LOCALE', 'CURRENCY', ),
        self::TYPE_FIELDNAME     => array('id', 'product_id', 'ref', 'ean_code', 'ASIN', 'SKU', 'price', 'quantity', 'marketplace_id', 'marketplace_locale', 'currency', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'ProductId' => 1, 'Ref' => 2, 'EanCode' => 3, 'ASIN' => 4, 'SKU' => 5, 'Price' => 6, 'Quantity' => 7, 'MarketplaceId' => 8, 'MarketplaceLocale' => 9, 'Currency' => 10, ),
        self::TYPE_STUDLYPHPNAME => array('id' => 0, 'productId' => 1, 'ref' => 2, 'eanCode' => 3, 'aSIN' => 4, 'sKU' => 5, 'price' => 6, 'quantity' => 7, 'marketplaceId' => 8, 'marketplaceLocale' => 9, 'currency' => 10, ),
        self::TYPE_COLNAME       => array(AmazonProductsHfTableMap::ID => 0, AmazonProductsHfTableMap::PRODUCT_ID => 1, AmazonProductsHfTableMap::REF => 2, AmazonProductsHfTableMap::EAN_CODE => 3, AmazonProductsHfTableMap::ASIN => 4, AmazonProductsHfTableMap::SKU => 5, AmazonProductsHfTableMap::PRICE => 6, AmazonProductsHfTableMap::QUANTITY => 7, AmazonProductsHfTableMap::MARKETPLACE_ID => 8, AmazonProductsHfTableMap::MARKETPLACE_LOCALE => 9, AmazonProductsHfTableMap::CURRENCY => 10, ),
        self::TYPE_RAW_COLNAME   => array('ID' => 0, 'PRODUCT_ID' => 1, 'REF' => 2, 'EAN_CODE' => 3, 'ASIN' => 4, 'SKU' => 5, 'PRICE' => 6, 'QUANTITY' => 7, 'MARKETPLACE_ID' => 8, 'MARKETPLACE_LOCALE' => 9, 'CURRENCY' => 10, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'product_id' => 1, 'ref' => 2, 'ean_code' => 3, 'ASIN' => 4, 'SKU' => 5, 'price' => 6, 'quantity' => 7, 'marketplace_id' => 8, 'marketplace_locale' => 9, 'currency' => 10, ),
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
        $this->setName('amazon_products_hf');
        $this->setPhpName('AmazonProductsHf');
        $this->setClassName('\\AmazonIntegration\\Model\\AmazonProductsHf');
        $this->setPackage('AmazonIntegration.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('PRODUCT_ID', 'ProductId', 'INTEGER', false, null, null);
        $this->addColumn('REF', 'Ref', 'VARCHAR', false, 255, null);
        $this->addColumn('EAN_CODE', 'EanCode', 'VARCHAR', false, 255, null);
        $this->addColumn('ASIN', 'ASIN', 'VARCHAR', false, 255, null);
        $this->addColumn('SKU', 'SKU', 'VARCHAR', false, 255, null);
        $this->addColumn('PRICE', 'Price', 'DECIMAL', false, 16, 0);
        $this->addColumn('QUANTITY', 'Quantity', 'INTEGER', false, null, 1);
        $this->addColumn('MARKETPLACE_ID', 'MarketplaceId', 'VARCHAR', false, 255, null);
        $this->addColumn('MARKETPLACE_LOCALE', 'MarketplaceLocale', 'VARCHAR', false, 255, null);
        $this->addColumn('CURRENCY', 'Currency', 'VARCHAR', false, 10, null);
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
        return $withPrefix ? AmazonProductsHfTableMap::CLASS_DEFAULT : AmazonProductsHfTableMap::OM_CLASS;
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
     * @return array (AmazonProductsHf object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = AmazonProductsHfTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = AmazonProductsHfTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + AmazonProductsHfTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = AmazonProductsHfTableMap::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            AmazonProductsHfTableMap::addInstanceToPool($obj, $key);
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
            $key = AmazonProductsHfTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = AmazonProductsHfTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                AmazonProductsHfTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(AmazonProductsHfTableMap::ID);
            $criteria->addSelectColumn(AmazonProductsHfTableMap::PRODUCT_ID);
            $criteria->addSelectColumn(AmazonProductsHfTableMap::REF);
            $criteria->addSelectColumn(AmazonProductsHfTableMap::EAN_CODE);
            $criteria->addSelectColumn(AmazonProductsHfTableMap::ASIN);
            $criteria->addSelectColumn(AmazonProductsHfTableMap::SKU);
            $criteria->addSelectColumn(AmazonProductsHfTableMap::PRICE);
            $criteria->addSelectColumn(AmazonProductsHfTableMap::QUANTITY);
            $criteria->addSelectColumn(AmazonProductsHfTableMap::MARKETPLACE_ID);
            $criteria->addSelectColumn(AmazonProductsHfTableMap::MARKETPLACE_LOCALE);
            $criteria->addSelectColumn(AmazonProductsHfTableMap::CURRENCY);
        } else {
            $criteria->addSelectColumn($alias . '.ID');
            $criteria->addSelectColumn($alias . '.PRODUCT_ID');
            $criteria->addSelectColumn($alias . '.REF');
            $criteria->addSelectColumn($alias . '.EAN_CODE');
            $criteria->addSelectColumn($alias . '.ASIN');
            $criteria->addSelectColumn($alias . '.SKU');
            $criteria->addSelectColumn($alias . '.PRICE');
            $criteria->addSelectColumn($alias . '.QUANTITY');
            $criteria->addSelectColumn($alias . '.MARKETPLACE_ID');
            $criteria->addSelectColumn($alias . '.MARKETPLACE_LOCALE');
            $criteria->addSelectColumn($alias . '.CURRENCY');
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
        return Propel::getServiceContainer()->getDatabaseMap(AmazonProductsHfTableMap::DATABASE_NAME)->getTable(AmazonProductsHfTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getServiceContainer()->getDatabaseMap(AmazonProductsHfTableMap::DATABASE_NAME);
      if (!$dbMap->hasTable(AmazonProductsHfTableMap::TABLE_NAME)) {
        $dbMap->addTableObject(new AmazonProductsHfTableMap());
      }
    }

    /**
     * Performs a DELETE on the database, given a AmazonProductsHf or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or AmazonProductsHf object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(AmazonProductsHfTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \AmazonIntegration\Model\AmazonProductsHf) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(AmazonProductsHfTableMap::DATABASE_NAME);
            $criteria->add(AmazonProductsHfTableMap::ID, (array) $values, Criteria::IN);
        }

        $query = AmazonProductsHfQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) { AmazonProductsHfTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) { AmazonProductsHfTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the amazon_products_hf table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return AmazonProductsHfQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a AmazonProductsHf or Criteria object.
     *
     * @param mixed               $criteria Criteria or AmazonProductsHf object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(AmazonProductsHfTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from AmazonProductsHf object
        }

        if ($criteria->containsKey(AmazonProductsHfTableMap::ID) && $criteria->keyContainsValue(AmazonProductsHfTableMap::ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.AmazonProductsHfTableMap::ID.')');
        }


        // Set the correct dbName
        $query = AmazonProductsHfQuery::create()->mergeWith($criteria);

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

} // AmazonProductsHfTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
AmazonProductsHfTableMap::buildTableMap();
