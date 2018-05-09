<?php

namespace PageBuilder\Model\Map;

use PageBuilder\Model\PageBuilderElementVersion;
use PageBuilder\Model\PageBuilderElementVersionQuery;
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
 * This class defines the structure of the 'page_builder_element_version' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class PageBuilderElementVersionTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;
    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'PageBuilder.Model.Map.PageBuilderElementVersionTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'thelia';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'page_builder_element_version';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\PageBuilder\\Model\\PageBuilderElementVersion';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'PageBuilder.Model.PageBuilderElementVersion';

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
    const ID = 'page_builder_element_version.ID';

    /**
     * the column name for the PAGE_BUILDER_ID field
     */
    const PAGE_BUILDER_ID = 'page_builder_element_version.PAGE_BUILDER_ID';

    /**
     * the column name for the VISIBLE field
     */
    const VISIBLE = 'page_builder_element_version.VISIBLE';

    /**
     * the column name for the POSITION field
     */
    const POSITION = 'page_builder_element_version.POSITION';

    /**
     * the column name for the TEMPLATE_NAME field
     */
    const TEMPLATE_NAME = 'page_builder_element_version.TEMPLATE_NAME';

    /**
     * the column name for the CREATED_AT field
     */
    const CREATED_AT = 'page_builder_element_version.CREATED_AT';

    /**
     * the column name for the UPDATED_AT field
     */
    const UPDATED_AT = 'page_builder_element_version.UPDATED_AT';

    /**
     * the column name for the VERSION field
     */
    const VERSION = 'page_builder_element_version.VERSION';

    /**
     * the column name for the VERSION_CREATED_AT field
     */
    const VERSION_CREATED_AT = 'page_builder_element_version.VERSION_CREATED_AT';

    /**
     * the column name for the VERSION_CREATED_BY field
     */
    const VERSION_CREATED_BY = 'page_builder_element_version.VERSION_CREATED_BY';

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
        self::TYPE_PHPNAME       => array('Id', 'PageBuilderId', 'Visible', 'Position', 'TemplateName', 'CreatedAt', 'UpdatedAt', 'Version', 'VersionCreatedAt', 'VersionCreatedBy', ),
        self::TYPE_STUDLYPHPNAME => array('id', 'pageBuilderId', 'visible', 'position', 'templateName', 'createdAt', 'updatedAt', 'version', 'versionCreatedAt', 'versionCreatedBy', ),
        self::TYPE_COLNAME       => array(PageBuilderElementVersionTableMap::ID, PageBuilderElementVersionTableMap::PAGE_BUILDER_ID, PageBuilderElementVersionTableMap::VISIBLE, PageBuilderElementVersionTableMap::POSITION, PageBuilderElementVersionTableMap::TEMPLATE_NAME, PageBuilderElementVersionTableMap::CREATED_AT, PageBuilderElementVersionTableMap::UPDATED_AT, PageBuilderElementVersionTableMap::VERSION, PageBuilderElementVersionTableMap::VERSION_CREATED_AT, PageBuilderElementVersionTableMap::VERSION_CREATED_BY, ),
        self::TYPE_RAW_COLNAME   => array('ID', 'PAGE_BUILDER_ID', 'VISIBLE', 'POSITION', 'TEMPLATE_NAME', 'CREATED_AT', 'UPDATED_AT', 'VERSION', 'VERSION_CREATED_AT', 'VERSION_CREATED_BY', ),
        self::TYPE_FIELDNAME     => array('id', 'page_builder_id', 'visible', 'position', 'template_name', 'created_at', 'updated_at', 'version', 'version_created_at', 'version_created_by', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'PageBuilderId' => 1, 'Visible' => 2, 'Position' => 3, 'TemplateName' => 4, 'CreatedAt' => 5, 'UpdatedAt' => 6, 'Version' => 7, 'VersionCreatedAt' => 8, 'VersionCreatedBy' => 9, ),
        self::TYPE_STUDLYPHPNAME => array('id' => 0, 'pageBuilderId' => 1, 'visible' => 2, 'position' => 3, 'templateName' => 4, 'createdAt' => 5, 'updatedAt' => 6, 'version' => 7, 'versionCreatedAt' => 8, 'versionCreatedBy' => 9, ),
        self::TYPE_COLNAME       => array(PageBuilderElementVersionTableMap::ID => 0, PageBuilderElementVersionTableMap::PAGE_BUILDER_ID => 1, PageBuilderElementVersionTableMap::VISIBLE => 2, PageBuilderElementVersionTableMap::POSITION => 3, PageBuilderElementVersionTableMap::TEMPLATE_NAME => 4, PageBuilderElementVersionTableMap::CREATED_AT => 5, PageBuilderElementVersionTableMap::UPDATED_AT => 6, PageBuilderElementVersionTableMap::VERSION => 7, PageBuilderElementVersionTableMap::VERSION_CREATED_AT => 8, PageBuilderElementVersionTableMap::VERSION_CREATED_BY => 9, ),
        self::TYPE_RAW_COLNAME   => array('ID' => 0, 'PAGE_BUILDER_ID' => 1, 'VISIBLE' => 2, 'POSITION' => 3, 'TEMPLATE_NAME' => 4, 'CREATED_AT' => 5, 'UPDATED_AT' => 6, 'VERSION' => 7, 'VERSION_CREATED_AT' => 8, 'VERSION_CREATED_BY' => 9, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'page_builder_id' => 1, 'visible' => 2, 'position' => 3, 'template_name' => 4, 'created_at' => 5, 'updated_at' => 6, 'version' => 7, 'version_created_at' => 8, 'version_created_by' => 9, ),
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
        $this->setName('page_builder_element_version');
        $this->setPhpName('PageBuilderElementVersion');
        $this->setClassName('\\PageBuilder\\Model\\PageBuilderElementVersion');
        $this->setPackage('PageBuilder.Model');
        $this->setUseIdGenerator(false);
        // columns
        $this->addForeignPrimaryKey('ID', 'Id', 'INTEGER' , 'page_builder_element', 'ID', true, null, null);
        $this->addColumn('PAGE_BUILDER_ID', 'PageBuilderId', 'INTEGER', true, null, null);
        $this->addColumn('VISIBLE', 'Visible', 'TINYINT', true, null, null);
        $this->addColumn('POSITION', 'Position', 'INTEGER', false, null, null);
        $this->addColumn('TEMPLATE_NAME', 'TemplateName', 'VARCHAR', false, 255, null);
        $this->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('UPDATED_AT', 'UpdatedAt', 'TIMESTAMP', false, null, null);
        $this->addPrimaryKey('VERSION', 'Version', 'INTEGER', true, null, 0);
        $this->addColumn('VERSION_CREATED_AT', 'VersionCreatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('VERSION_CREATED_BY', 'VersionCreatedBy', 'VARCHAR', false, 100, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('PageBuilderElement', '\\PageBuilder\\Model\\PageBuilderElement', RelationMap::MANY_TO_ONE, array('id' => 'id', ), 'CASCADE', null);
    } // buildRelations()

    /**
     * Adds an object to the instance pool.
     *
     * Propel keeps cached copies of objects in an instance pool when they are retrieved
     * from the database. In some cases you may need to explicitly add objects
     * to the cache in order to ensure that the same objects are always returned by find*()
     * and findPk*() calls.
     *
     * @param \PageBuilder\Model\PageBuilderElementVersion $obj A \PageBuilder\Model\PageBuilderElementVersion object.
     * @param string $key             (optional) key to use for instance map (for performance boost if key was already calculated externally).
     */
    public static function addInstanceToPool($obj, $key = null)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if (null === $key) {
                $key = serialize(array((string) $obj->getId(), (string) $obj->getVersion()));
            } // if key === null
            self::$instances[$key] = $obj;
        }
    }

    /**
     * Removes an object from the instance pool.
     *
     * Propel keeps cached copies of objects in an instance pool when they are retrieved
     * from the database.  In some cases -- especially when you override doDelete
     * methods in your stub classes -- you may need to explicitly remove objects
     * from the cache in order to prevent returning objects that no longer exist.
     *
     * @param mixed $value A \PageBuilder\Model\PageBuilderElementVersion object or a primary key value.
     */
    public static function removeInstanceFromPool($value)
    {
        if (Propel::isInstancePoolingEnabled() && null !== $value) {
            if (is_object($value) && $value instanceof \PageBuilder\Model\PageBuilderElementVersion) {
                $key = serialize(array((string) $value->getId(), (string) $value->getVersion()));

            } elseif (is_array($value) && count($value) === 2) {
                // assume we've been passed a primary key";
                $key = serialize(array((string) $value[0], (string) $value[1]));
            } elseif ($value instanceof Criteria) {
                self::$instances = [];

                return;
            } else {
                $e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or \PageBuilder\Model\PageBuilderElementVersion object; got " . (is_object($value) ? get_class($value) . ' object.' : var_export($value, true)));
                throw $e;
            }

            unset(self::$instances[$key]);
        }
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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] === null && $row[TableMap::TYPE_NUM == $indexType ? 7 + $offset : static::translateFieldName('Version', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return serialize(array((string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)], (string) $row[TableMap::TYPE_NUM == $indexType ? 7 + $offset : static::translateFieldName('Version', TableMap::TYPE_PHPNAME, $indexType)]));
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

            return $pks;
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
        return $withPrefix ? PageBuilderElementVersionTableMap::CLASS_DEFAULT : PageBuilderElementVersionTableMap::OM_CLASS;
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
     * @return array (PageBuilderElementVersion object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = PageBuilderElementVersionTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = PageBuilderElementVersionTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + PageBuilderElementVersionTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = PageBuilderElementVersionTableMap::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            PageBuilderElementVersionTableMap::addInstanceToPool($obj, $key);
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
            $key = PageBuilderElementVersionTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = PageBuilderElementVersionTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                PageBuilderElementVersionTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(PageBuilderElementVersionTableMap::ID);
            $criteria->addSelectColumn(PageBuilderElementVersionTableMap::PAGE_BUILDER_ID);
            $criteria->addSelectColumn(PageBuilderElementVersionTableMap::VISIBLE);
            $criteria->addSelectColumn(PageBuilderElementVersionTableMap::POSITION);
            $criteria->addSelectColumn(PageBuilderElementVersionTableMap::TEMPLATE_NAME);
            $criteria->addSelectColumn(PageBuilderElementVersionTableMap::CREATED_AT);
            $criteria->addSelectColumn(PageBuilderElementVersionTableMap::UPDATED_AT);
            $criteria->addSelectColumn(PageBuilderElementVersionTableMap::VERSION);
            $criteria->addSelectColumn(PageBuilderElementVersionTableMap::VERSION_CREATED_AT);
            $criteria->addSelectColumn(PageBuilderElementVersionTableMap::VERSION_CREATED_BY);
        } else {
            $criteria->addSelectColumn($alias . '.ID');
            $criteria->addSelectColumn($alias . '.PAGE_BUILDER_ID');
            $criteria->addSelectColumn($alias . '.VISIBLE');
            $criteria->addSelectColumn($alias . '.POSITION');
            $criteria->addSelectColumn($alias . '.TEMPLATE_NAME');
            $criteria->addSelectColumn($alias . '.CREATED_AT');
            $criteria->addSelectColumn($alias . '.UPDATED_AT');
            $criteria->addSelectColumn($alias . '.VERSION');
            $criteria->addSelectColumn($alias . '.VERSION_CREATED_AT');
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
        return Propel::getServiceContainer()->getDatabaseMap(PageBuilderElementVersionTableMap::DATABASE_NAME)->getTable(PageBuilderElementVersionTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getServiceContainer()->getDatabaseMap(PageBuilderElementVersionTableMap::DATABASE_NAME);
      if (!$dbMap->hasTable(PageBuilderElementVersionTableMap::TABLE_NAME)) {
        $dbMap->addTableObject(new PageBuilderElementVersionTableMap());
      }
    }

    /**
     * Performs a DELETE on the database, given a PageBuilderElementVersion or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or PageBuilderElementVersion object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(PageBuilderElementVersionTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \PageBuilder\Model\PageBuilderElementVersion) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(PageBuilderElementVersionTableMap::DATABASE_NAME);
            // primary key is composite; we therefore, expect
            // the primary key passed to be an array of pkey values
            if (count($values) == count($values, COUNT_RECURSIVE)) {
                // array is not multi-dimensional
                $values = array($values);
            }
            foreach ($values as $value) {
                $criterion = $criteria->getNewCriterion(PageBuilderElementVersionTableMap::ID, $value[0]);
                $criterion->addAnd($criteria->getNewCriterion(PageBuilderElementVersionTableMap::VERSION, $value[1]));
                $criteria->addOr($criterion);
            }
        }

        $query = PageBuilderElementVersionQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) { PageBuilderElementVersionTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) { PageBuilderElementVersionTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the page_builder_element_version table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return PageBuilderElementVersionQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a PageBuilderElementVersion or Criteria object.
     *
     * @param mixed               $criteria Criteria or PageBuilderElementVersion object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PageBuilderElementVersionTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from PageBuilderElementVersion object
        }


        // Set the correct dbName
        $query = PageBuilderElementVersionQuery::create()->mergeWith($criteria);

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

} // PageBuilderElementVersionTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
PageBuilderElementVersionTableMap::buildTableMap();
