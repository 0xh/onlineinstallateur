<?php

namespace OfferCreation\Model\Map;

use OfferCreation\Model\OfferProductTax;
use OfferCreation\Model\OfferProductTaxQuery;
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
 * This class defines the structure of the 'offer_product_tax' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class OfferProductTaxTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;
    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'OfferCreation.Model.Map.OfferProductTaxTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'thelia';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'offer_product_tax';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\OfferCreation\\Model\\OfferProductTax';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'OfferCreation.Model.OfferProductTax';

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
    const ID = 'offer_product_tax.ID';

    /**
     * the column name for the OFFER_PRODUCT_ID field
     */
    const OFFER_PRODUCT_ID = 'offer_product_tax.OFFER_PRODUCT_ID';

    /**
     * the column name for the TITLE field
     */
    const TITLE = 'offer_product_tax.TITLE';

    /**
     * the column name for the DESCRIPTION field
     */
    const DESCRIPTION = 'offer_product_tax.DESCRIPTION';

    /**
     * the column name for the AMOUNT field
     */
    const AMOUNT = 'offer_product_tax.AMOUNT';

    /**
     * the column name for the PROMO_AMOUNT field
     */
    const PROMO_AMOUNT = 'offer_product_tax.PROMO_AMOUNT';

    /**
     * the column name for the CREATED_AT field
     */
    const CREATED_AT = 'offer_product_tax.CREATED_AT';

    /**
     * the column name for the UPDATED_AT field
     */
    const UPDATED_AT = 'offer_product_tax.UPDATED_AT';

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
        self::TYPE_PHPNAME       => array('Id', 'OfferProductId', 'Title', 'Description', 'Amount', 'PromoAmount', 'CreatedAt', 'UpdatedAt', ),
        self::TYPE_STUDLYPHPNAME => array('id', 'offerProductId', 'title', 'description', 'amount', 'promoAmount', 'createdAt', 'updatedAt', ),
        self::TYPE_COLNAME       => array(OfferProductTaxTableMap::ID, OfferProductTaxTableMap::OFFER_PRODUCT_ID, OfferProductTaxTableMap::TITLE, OfferProductTaxTableMap::DESCRIPTION, OfferProductTaxTableMap::AMOUNT, OfferProductTaxTableMap::PROMO_AMOUNT, OfferProductTaxTableMap::CREATED_AT, OfferProductTaxTableMap::UPDATED_AT, ),
        self::TYPE_RAW_COLNAME   => array('ID', 'OFFER_PRODUCT_ID', 'TITLE', 'DESCRIPTION', 'AMOUNT', 'PROMO_AMOUNT', 'CREATED_AT', 'UPDATED_AT', ),
        self::TYPE_FIELDNAME     => array('id', 'offer_product_id', 'title', 'description', 'amount', 'promo_amount', 'created_at', 'updated_at', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'OfferProductId' => 1, 'Title' => 2, 'Description' => 3, 'Amount' => 4, 'PromoAmount' => 5, 'CreatedAt' => 6, 'UpdatedAt' => 7, ),
        self::TYPE_STUDLYPHPNAME => array('id' => 0, 'offerProductId' => 1, 'title' => 2, 'description' => 3, 'amount' => 4, 'promoAmount' => 5, 'createdAt' => 6, 'updatedAt' => 7, ),
        self::TYPE_COLNAME       => array(OfferProductTaxTableMap::ID => 0, OfferProductTaxTableMap::OFFER_PRODUCT_ID => 1, OfferProductTaxTableMap::TITLE => 2, OfferProductTaxTableMap::DESCRIPTION => 3, OfferProductTaxTableMap::AMOUNT => 4, OfferProductTaxTableMap::PROMO_AMOUNT => 5, OfferProductTaxTableMap::CREATED_AT => 6, OfferProductTaxTableMap::UPDATED_AT => 7, ),
        self::TYPE_RAW_COLNAME   => array('ID' => 0, 'OFFER_PRODUCT_ID' => 1, 'TITLE' => 2, 'DESCRIPTION' => 3, 'AMOUNT' => 4, 'PROMO_AMOUNT' => 5, 'CREATED_AT' => 6, 'UPDATED_AT' => 7, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'offer_product_id' => 1, 'title' => 2, 'description' => 3, 'amount' => 4, 'promo_amount' => 5, 'created_at' => 6, 'updated_at' => 7, ),
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
        $this->setName('offer_product_tax');
        $this->setPhpName('OfferProductTax');
        $this->setClassName('\\OfferCreation\\Model\\OfferProductTax');
        $this->setPackage('OfferCreation.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('OFFER_PRODUCT_ID', 'OfferProductId', 'INTEGER', 'offer_product', 'ID', true, null, null);
        $this->addColumn('TITLE', 'Title', 'VARCHAR', true, 255, null);
        $this->addColumn('DESCRIPTION', 'Description', 'CLOB', false, null, null);
        $this->addColumn('AMOUNT', 'Amount', 'DECIMAL', true, 16, 0);
        $this->addColumn('PROMO_AMOUNT', 'PromoAmount', 'DECIMAL', false, 16, 0);
        $this->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('UPDATED_AT', 'UpdatedAt', 'TIMESTAMP', false, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('OfferProduct', '\\OfferCreation\\Model\\OfferProduct', RelationMap::MANY_TO_ONE, array('offer_product_id' => 'id', ), 'CASCADE', null);
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
        return $withPrefix ? OfferProductTaxTableMap::CLASS_DEFAULT : OfferProductTaxTableMap::OM_CLASS;
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
     * @return array (OfferProductTax object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = OfferProductTaxTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = OfferProductTaxTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + OfferProductTaxTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = OfferProductTaxTableMap::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            OfferProductTaxTableMap::addInstanceToPool($obj, $key);
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
            $key = OfferProductTaxTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = OfferProductTaxTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                OfferProductTaxTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(OfferProductTaxTableMap::ID);
            $criteria->addSelectColumn(OfferProductTaxTableMap::OFFER_PRODUCT_ID);
            $criteria->addSelectColumn(OfferProductTaxTableMap::TITLE);
            $criteria->addSelectColumn(OfferProductTaxTableMap::DESCRIPTION);
            $criteria->addSelectColumn(OfferProductTaxTableMap::AMOUNT);
            $criteria->addSelectColumn(OfferProductTaxTableMap::PROMO_AMOUNT);
            $criteria->addSelectColumn(OfferProductTaxTableMap::CREATED_AT);
            $criteria->addSelectColumn(OfferProductTaxTableMap::UPDATED_AT);
        } else {
            $criteria->addSelectColumn($alias . '.ID');
            $criteria->addSelectColumn($alias . '.OFFER_PRODUCT_ID');
            $criteria->addSelectColumn($alias . '.TITLE');
            $criteria->addSelectColumn($alias . '.DESCRIPTION');
            $criteria->addSelectColumn($alias . '.AMOUNT');
            $criteria->addSelectColumn($alias . '.PROMO_AMOUNT');
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
        return Propel::getServiceContainer()->getDatabaseMap(OfferProductTaxTableMap::DATABASE_NAME)->getTable(OfferProductTaxTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getServiceContainer()->getDatabaseMap(OfferProductTaxTableMap::DATABASE_NAME);
      if (!$dbMap->hasTable(OfferProductTaxTableMap::TABLE_NAME)) {
        $dbMap->addTableObject(new OfferProductTaxTableMap());
      }
    }

    /**
     * Performs a DELETE on the database, given a OfferProductTax or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or OfferProductTax object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(OfferProductTaxTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \OfferCreation\Model\OfferProductTax) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(OfferProductTaxTableMap::DATABASE_NAME);
            $criteria->add(OfferProductTaxTableMap::ID, (array) $values, Criteria::IN);
        }

        $query = OfferProductTaxQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) { OfferProductTaxTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) { OfferProductTaxTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the offer_product_tax table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return OfferProductTaxQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a OfferProductTax or Criteria object.
     *
     * @param mixed               $criteria Criteria or OfferProductTax object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(OfferProductTaxTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from OfferProductTax object
        }

        if ($criteria->containsKey(OfferProductTaxTableMap::ID) && $criteria->keyContainsValue(OfferProductTaxTableMap::ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.OfferProductTaxTableMap::ID.')');
        }


        // Set the correct dbName
        $query = OfferProductTaxQuery::create()->mergeWith($criteria);

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

} // OfferProductTaxTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
OfferProductTaxTableMap::buildTableMap();
