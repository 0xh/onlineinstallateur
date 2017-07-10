<?php

namespace MultipleFullfilmentCenters\Model\Map;

use MultipleFullfilmentCenters\Model\Product;
use MultipleFullfilmentCenters\Model\ProductQuery;
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
 * This class defines the structure of the 'product' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class ProductTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;
    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'MultipleFullfilmentCenters.Model.Map.ProductTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'thelia';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'product';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\MultipleFullfilmentCenters\\Model\\Product';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'MultipleFullfilmentCenters.Model.Product';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 10;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 10;

    /**
     * the column name for the ID field
     */
    const ID = 'product.ID';

    /**
     * the column name for the TAX_RULE_ID field
     */
    const TAX_RULE_ID = 'product.TAX_RULE_ID';

    /**
     * the column name for the REF field
     */
    const REF = 'product.REF';

    /**
     * the column name for the VISIBLE field
     */
    const VISIBLE = 'product.VISIBLE';

    /**
     * the column name for the POSITION field
     */
    const POSITION = 'product.POSITION';

    /**
     * the column name for the TEMPLATE_ID field
     */
    const TEMPLATE_ID = 'product.TEMPLATE_ID';

    /**
     * the column name for the BRAND_ID field
     */
    const BRAND_ID = 'product.BRAND_ID';

    /**
     * the column name for the VIRTUAL field
     */
    const VIRTUAL = 'product.VIRTUAL';

    /**
     * the column name for the CREATED_AT field
     */
    const CREATED_AT = 'product.CREATED_AT';

    /**
     * the column name for the UPDATED_AT field
     */
    const UPDATED_AT = 'product.UPDATED_AT';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    // i18n behavior
    
    /**
     * The default locale to use for translations.
     *
     * @var string
     */
    const DEFAULT_LOCALE = 'en_US';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('Id', 'TaxRuleId', 'Ref', 'Visible', 'Position', 'TemplateId', 'BrandId', 'Virtual', 'CreatedAt', 'UpdatedAt', ),
        self::TYPE_STUDLYPHPNAME => array('id', 'taxRuleId', 'ref', 'visible', 'position', 'templateId', 'brandId', 'virtual', 'createdAt', 'updatedAt', ),
        self::TYPE_COLNAME       => array(ProductTableMap::ID, ProductTableMap::TAX_RULE_ID, ProductTableMap::REF, ProductTableMap::VISIBLE, ProductTableMap::POSITION, ProductTableMap::TEMPLATE_ID, ProductTableMap::BRAND_ID, ProductTableMap::VIRTUAL, ProductTableMap::CREATED_AT, ProductTableMap::UPDATED_AT, ),
        self::TYPE_RAW_COLNAME   => array('ID', 'TAX_RULE_ID', 'REF', 'VISIBLE', 'POSITION', 'TEMPLATE_ID', 'BRAND_ID', 'VIRTUAL', 'CREATED_AT', 'UPDATED_AT', ),
        self::TYPE_FIELDNAME     => array('id', 'tax_rule_id', 'ref', 'visible', 'position', 'template_id', 'brand_id', 'virtual', 'created_at', 'updated_at', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'TaxRuleId' => 1, 'Ref' => 2, 'Visible' => 3, 'Position' => 4, 'TemplateId' => 5, 'BrandId' => 6, 'Virtual' => 7, 'CreatedAt' => 8, 'UpdatedAt' => 9, ),
        self::TYPE_STUDLYPHPNAME => array('id' => 0, 'taxRuleId' => 1, 'ref' => 2, 'visible' => 3, 'position' => 4, 'templateId' => 5, 'brandId' => 6, 'virtual' => 7, 'createdAt' => 8, 'updatedAt' => 9, ),
        self::TYPE_COLNAME       => array(ProductTableMap::ID => 0, ProductTableMap::TAX_RULE_ID => 1, ProductTableMap::REF => 2, ProductTableMap::VISIBLE => 3, ProductTableMap::POSITION => 4, ProductTableMap::TEMPLATE_ID => 5, ProductTableMap::BRAND_ID => 6, ProductTableMap::VIRTUAL => 7, ProductTableMap::CREATED_AT => 8, ProductTableMap::UPDATED_AT => 9, ),
        self::TYPE_RAW_COLNAME   => array('ID' => 0, 'TAX_RULE_ID' => 1, 'REF' => 2, 'VISIBLE' => 3, 'POSITION' => 4, 'TEMPLATE_ID' => 5, 'BRAND_ID' => 6, 'VIRTUAL' => 7, 'CREATED_AT' => 8, 'UPDATED_AT' => 9, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'tax_rule_id' => 1, 'ref' => 2, 'visible' => 3, 'position' => 4, 'template_id' => 5, 'brand_id' => 6, 'virtual' => 7, 'created_at' => 8, 'updated_at' => 9, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, )
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
        $this->setName('product');
        $this->setPhpName('Product');
        $this->setClassName('\\MultipleFullfilmentCenters\\Model\\Product');
        $this->setPackage('MultipleFullfilmentCenters.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('TAX_RULE_ID', 'TaxRuleId', 'INTEGER', false, null, null);
        $this->addColumn('REF', 'Ref', 'VARCHAR', true, 255, null);
        $this->addColumn('VISIBLE', 'Visible', 'TINYINT', true, null, 0);
        $this->addColumn('POSITION', 'Position', 'INTEGER', true, null, 0);
        $this->addColumn('TEMPLATE_ID', 'TemplateId', 'INTEGER', false, null, null);
        $this->addColumn('BRAND_ID', 'BrandId', 'INTEGER', false, null, null);
        $this->addColumn('VIRTUAL', 'Virtual', 'TINYINT', true, null, 0);
        $this->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('UPDATED_AT', 'UpdatedAt', 'TIMESTAMP', false, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('FulfilmentCenterProducts', '\\MultipleFullfilmentCenters\\Model\\FulfilmentCenterProducts', RelationMap::ONE_TO_MANY, array('id' => 'product_id', ), 'CASCADE', 'CASCADE', 'FulfilmentCenterProductss');
        $this->addRelation('ProductI18n', '\\MultipleFullfilmentCenters\\Model\\ProductI18n', RelationMap::ONE_TO_MANY, array('id' => 'id', ), 'CASCADE', null, 'ProductI18ns');
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
            'timestampable' => array('create_column' => 'created_at', 'update_column' => 'updated_at', ),
            'i18n' => array('i18n_table' => '%TABLE%_i18n', 'i18n_phpname' => '%PHPNAME%I18n', 'i18n_columns' => 'title, description, chapo, postscriptum, meta_title, meta_description, meta_keywords', 'locale_column' => 'locale', 'locale_length' => '5', 'default_locale' => '', 'locale_alias' => '', ),
        );
    } // getBehaviors()
    /**
     * Method to invalidate the instance pool of all tables related to product     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
        // Invalidate objects in ".$this->getClassNameFromBuilder($joinedTableTableMapBuilder)." instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
                FulfilmentCenterProductsTableMap::clearInstancePool();
                ProductI18nTableMap::clearInstancePool();
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
        return $withPrefix ? ProductTableMap::CLASS_DEFAULT : ProductTableMap::OM_CLASS;
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
     * @return array (Product object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = ProductTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = ProductTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + ProductTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = ProductTableMap::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            ProductTableMap::addInstanceToPool($obj, $key);
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
            $key = ProductTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = ProductTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                ProductTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(ProductTableMap::ID);
            $criteria->addSelectColumn(ProductTableMap::TAX_RULE_ID);
            $criteria->addSelectColumn(ProductTableMap::REF);
            $criteria->addSelectColumn(ProductTableMap::VISIBLE);
            $criteria->addSelectColumn(ProductTableMap::POSITION);
            $criteria->addSelectColumn(ProductTableMap::TEMPLATE_ID);
            $criteria->addSelectColumn(ProductTableMap::BRAND_ID);
            $criteria->addSelectColumn(ProductTableMap::VIRTUAL);
            $criteria->addSelectColumn(ProductTableMap::CREATED_AT);
            $criteria->addSelectColumn(ProductTableMap::UPDATED_AT);
        } else {
            $criteria->addSelectColumn($alias . '.ID');
            $criteria->addSelectColumn($alias . '.TAX_RULE_ID');
            $criteria->addSelectColumn($alias . '.REF');
            $criteria->addSelectColumn($alias . '.VISIBLE');
            $criteria->addSelectColumn($alias . '.POSITION');
            $criteria->addSelectColumn($alias . '.TEMPLATE_ID');
            $criteria->addSelectColumn($alias . '.BRAND_ID');
            $criteria->addSelectColumn($alias . '.VIRTUAL');
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
        return Propel::getServiceContainer()->getDatabaseMap(ProductTableMap::DATABASE_NAME)->getTable(ProductTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getServiceContainer()->getDatabaseMap(ProductTableMap::DATABASE_NAME);
      if (!$dbMap->hasTable(ProductTableMap::TABLE_NAME)) {
        $dbMap->addTableObject(new ProductTableMap());
      }
    }

    /**
     * Performs a DELETE on the database, given a Product or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Product object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(ProductTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \MultipleFullfilmentCenters\Model\Product) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(ProductTableMap::DATABASE_NAME);
            $criteria->add(ProductTableMap::ID, (array) $values, Criteria::IN);
        }

        $query = ProductQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) { ProductTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) { ProductTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the product table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return ProductQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Product or Criteria object.
     *
     * @param mixed               $criteria Criteria or Product object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ProductTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Product object
        }

        if ($criteria->containsKey(ProductTableMap::ID) && $criteria->keyContainsValue(ProductTableMap::ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.ProductTableMap::ID.')');
        }


        // Set the correct dbName
        $query = ProductQuery::create()->mergeWith($criteria);

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

} // ProductTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
ProductTableMap::buildTableMap();
