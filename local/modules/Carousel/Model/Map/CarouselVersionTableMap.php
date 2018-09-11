<?php

namespace Carousel\Model\Map;

use Carousel\Model\CarouselVersion;
use Carousel\Model\CarouselVersionQuery;
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
 * This class defines the structure of the 'carousel_version' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class CarouselVersionTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;
    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'Carousel.Model.Map.CarouselVersionTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'thelia';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'carousel_version';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Carousel\\Model\\CarouselVersion';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Carousel.Model.CarouselVersion';

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
    const ID = 'carousel_version.ID';

    /**
     * the column name for the CAROUSEL_ID field
     */
    const CAROUSEL_ID = 'carousel_version.CAROUSEL_ID';

    /**
     * the column name for the VISIBLE field
     */
    const VISIBLE = 'carousel_version.VISIBLE';

    /**
     * the column name for the FILE field
     */
    const FILE = 'carousel_version.FILE';

    /**
     * the column name for the POSITION field
     */
    const POSITION = 'carousel_version.POSITION';

    /**
     * the column name for the URL field
     */
    const URL = 'carousel_version.URL';

    /**
     * the column name for the CREATED_AT field
     */
    const CREATED_AT = 'carousel_version.CREATED_AT';

    /**
     * the column name for the UPDATED_AT field
     */
    const UPDATED_AT = 'carousel_version.UPDATED_AT';

    /**
     * the column name for the VERSION field
     */
    const VERSION = 'carousel_version.VERSION';

    /**
     * the column name for the VERSION_CREATED_AT field
     */
    const VERSION_CREATED_AT = 'carousel_version.VERSION_CREATED_AT';

    /**
     * the column name for the VERSION_CREATED_BY field
     */
    const VERSION_CREATED_BY = 'carousel_version.VERSION_CREATED_BY';

    /**
     * the column name for the CAROUSEL_ID_VERSION field
     */
    const CAROUSEL_ID_VERSION = 'carousel_version.CAROUSEL_ID_VERSION';

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
        self::TYPE_PHPNAME       => array('Id', 'CarouselId', 'Visible', 'File', 'Position', 'Url', 'CreatedAt', 'UpdatedAt', 'Version', 'VersionCreatedAt', 'VersionCreatedBy', 'CarouselIdVersion', ),
        self::TYPE_STUDLYPHPNAME => array('id', 'carouselId', 'visible', 'file', 'position', 'url', 'createdAt', 'updatedAt', 'version', 'versionCreatedAt', 'versionCreatedBy', 'carouselIdVersion', ),
        self::TYPE_COLNAME       => array(CarouselVersionTableMap::ID, CarouselVersionTableMap::CAROUSEL_ID, CarouselVersionTableMap::VISIBLE, CarouselVersionTableMap::FILE, CarouselVersionTableMap::POSITION, CarouselVersionTableMap::URL, CarouselVersionTableMap::CREATED_AT, CarouselVersionTableMap::UPDATED_AT, CarouselVersionTableMap::VERSION, CarouselVersionTableMap::VERSION_CREATED_AT, CarouselVersionTableMap::VERSION_CREATED_BY, CarouselVersionTableMap::CAROUSEL_ID_VERSION, ),
        self::TYPE_RAW_COLNAME   => array('ID', 'CAROUSEL_ID', 'VISIBLE', 'FILE', 'POSITION', 'URL', 'CREATED_AT', 'UPDATED_AT', 'VERSION', 'VERSION_CREATED_AT', 'VERSION_CREATED_BY', 'CAROUSEL_ID_VERSION', ),
        self::TYPE_FIELDNAME     => array('id', 'carousel_id', 'visible', 'file', 'position', 'url', 'created_at', 'updated_at', 'version', 'version_created_at', 'version_created_by', 'carousel_id_version', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'CarouselId' => 1, 'Visible' => 2, 'File' => 3, 'Position' => 4, 'Url' => 5, 'CreatedAt' => 6, 'UpdatedAt' => 7, 'Version' => 8, 'VersionCreatedAt' => 9, 'VersionCreatedBy' => 10, 'CarouselIdVersion' => 11, ),
        self::TYPE_STUDLYPHPNAME => array('id' => 0, 'carouselId' => 1, 'visible' => 2, 'file' => 3, 'position' => 4, 'url' => 5, 'createdAt' => 6, 'updatedAt' => 7, 'version' => 8, 'versionCreatedAt' => 9, 'versionCreatedBy' => 10, 'carouselIdVersion' => 11, ),
        self::TYPE_COLNAME       => array(CarouselVersionTableMap::ID => 0, CarouselVersionTableMap::CAROUSEL_ID => 1, CarouselVersionTableMap::VISIBLE => 2, CarouselVersionTableMap::FILE => 3, CarouselVersionTableMap::POSITION => 4, CarouselVersionTableMap::URL => 5, CarouselVersionTableMap::CREATED_AT => 6, CarouselVersionTableMap::UPDATED_AT => 7, CarouselVersionTableMap::VERSION => 8, CarouselVersionTableMap::VERSION_CREATED_AT => 9, CarouselVersionTableMap::VERSION_CREATED_BY => 10, CarouselVersionTableMap::CAROUSEL_ID_VERSION => 11, ),
        self::TYPE_RAW_COLNAME   => array('ID' => 0, 'CAROUSEL_ID' => 1, 'VISIBLE' => 2, 'FILE' => 3, 'POSITION' => 4, 'URL' => 5, 'CREATED_AT' => 6, 'UPDATED_AT' => 7, 'VERSION' => 8, 'VERSION_CREATED_AT' => 9, 'VERSION_CREATED_BY' => 10, 'CAROUSEL_ID_VERSION' => 11, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'carousel_id' => 1, 'visible' => 2, 'file' => 3, 'position' => 4, 'url' => 5, 'created_at' => 6, 'updated_at' => 7, 'version' => 8, 'version_created_at' => 9, 'version_created_by' => 10, 'carousel_id_version' => 11, ),
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
        $this->setName('carousel_version');
        $this->setPhpName('CarouselVersion');
        $this->setClassName('\\Carousel\\Model\\CarouselVersion');
        $this->setPackage('Carousel.Model');
        $this->setUseIdGenerator(false);
        // columns
        $this->addForeignPrimaryKey('ID', 'Id', 'INTEGER' , 'carousel', 'ID', true, null, null);
        $this->addColumn('CAROUSEL_ID', 'CarouselId', 'INTEGER', true, null, null);
        $this->addColumn('VISIBLE', 'Visible', 'TINYINT', true, null, 1);
        $this->addColumn('FILE', 'File', 'VARCHAR', false, 255, null);
        $this->addColumn('POSITION', 'Position', 'INTEGER', false, null, null);
        $this->addColumn('URL', 'Url', 'VARCHAR', false, 255, null);
        $this->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('UPDATED_AT', 'UpdatedAt', 'TIMESTAMP', false, null, null);
        $this->addPrimaryKey('VERSION', 'Version', 'INTEGER', true, null, 0);
        $this->addColumn('VERSION_CREATED_AT', 'VersionCreatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('VERSION_CREATED_BY', 'VersionCreatedBy', 'VARCHAR', false, 100, null);
        $this->addColumn('CAROUSEL_ID_VERSION', 'CarouselIdVersion', 'INTEGER', false, null, 0);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Carousel', '\\Carousel\\Model\\Carousel', RelationMap::MANY_TO_ONE, array('id' => 'id', ), 'CASCADE', null);
    } // buildRelations()

    /**
     * Adds an object to the instance pool.
     *
     * Propel keeps cached copies of objects in an instance pool when they are retrieved
     * from the database. In some cases you may need to explicitly add objects
     * to the cache in order to ensure that the same objects are always returned by find*()
     * and findPk*() calls.
     *
     * @param \Carousel\Model\CarouselVersion $obj A \Carousel\Model\CarouselVersion object.
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
     * @param mixed $value A \Carousel\Model\CarouselVersion object or a primary key value.
     */
    public static function removeInstanceFromPool($value)
    {
        if (Propel::isInstancePoolingEnabled() && null !== $value) {
            if (is_object($value) && $value instanceof \Carousel\Model\CarouselVersion) {
                $key = serialize(array((string) $value->getId(), (string) $value->getVersion()));

            } elseif (is_array($value) && count($value) === 2) {
                // assume we've been passed a primary key";
                $key = serialize(array((string) $value[0], (string) $value[1]));
            } elseif ($value instanceof Criteria) {
                self::$instances = [];

                return;
            } else {
                $e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or \Carousel\Model\CarouselVersion object; got " . (is_object($value) ? get_class($value) . ' object.' : var_export($value, true)));
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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] === null && $row[TableMap::TYPE_NUM == $indexType ? 8 + $offset : static::translateFieldName('Version', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return serialize(array((string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)], (string) $row[TableMap::TYPE_NUM == $indexType ? 8 + $offset : static::translateFieldName('Version', TableMap::TYPE_PHPNAME, $indexType)]));
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
        return $withPrefix ? CarouselVersionTableMap::CLASS_DEFAULT : CarouselVersionTableMap::OM_CLASS;
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
     * @return array (CarouselVersion object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = CarouselVersionTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = CarouselVersionTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + CarouselVersionTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = CarouselVersionTableMap::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            CarouselVersionTableMap::addInstanceToPool($obj, $key);
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
            $key = CarouselVersionTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = CarouselVersionTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                CarouselVersionTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(CarouselVersionTableMap::ID);
            $criteria->addSelectColumn(CarouselVersionTableMap::CAROUSEL_ID);
            $criteria->addSelectColumn(CarouselVersionTableMap::VISIBLE);
            $criteria->addSelectColumn(CarouselVersionTableMap::FILE);
            $criteria->addSelectColumn(CarouselVersionTableMap::POSITION);
            $criteria->addSelectColumn(CarouselVersionTableMap::URL);
            $criteria->addSelectColumn(CarouselVersionTableMap::CREATED_AT);
            $criteria->addSelectColumn(CarouselVersionTableMap::UPDATED_AT);
            $criteria->addSelectColumn(CarouselVersionTableMap::VERSION);
            $criteria->addSelectColumn(CarouselVersionTableMap::VERSION_CREATED_AT);
            $criteria->addSelectColumn(CarouselVersionTableMap::VERSION_CREATED_BY);
            $criteria->addSelectColumn(CarouselVersionTableMap::CAROUSEL_ID_VERSION);
        } else {
            $criteria->addSelectColumn($alias . '.ID');
            $criteria->addSelectColumn($alias . '.CAROUSEL_ID');
            $criteria->addSelectColumn($alias . '.VISIBLE');
            $criteria->addSelectColumn($alias . '.FILE');
            $criteria->addSelectColumn($alias . '.POSITION');
            $criteria->addSelectColumn($alias . '.URL');
            $criteria->addSelectColumn($alias . '.CREATED_AT');
            $criteria->addSelectColumn($alias . '.UPDATED_AT');
            $criteria->addSelectColumn($alias . '.VERSION');
            $criteria->addSelectColumn($alias . '.VERSION_CREATED_AT');
            $criteria->addSelectColumn($alias . '.VERSION_CREATED_BY');
            $criteria->addSelectColumn($alias . '.CAROUSEL_ID_VERSION');
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
        return Propel::getServiceContainer()->getDatabaseMap(CarouselVersionTableMap::DATABASE_NAME)->getTable(CarouselVersionTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getServiceContainer()->getDatabaseMap(CarouselVersionTableMap::DATABASE_NAME);
      if (!$dbMap->hasTable(CarouselVersionTableMap::TABLE_NAME)) {
        $dbMap->addTableObject(new CarouselVersionTableMap());
      }
    }

    /**
     * Performs a DELETE on the database, given a CarouselVersion or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or CarouselVersion object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(CarouselVersionTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Carousel\Model\CarouselVersion) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(CarouselVersionTableMap::DATABASE_NAME);
            // primary key is composite; we therefore, expect
            // the primary key passed to be an array of pkey values
            if (count($values) == count($values, COUNT_RECURSIVE)) {
                // array is not multi-dimensional
                $values = array($values);
            }
            foreach ($values as $value) {
                $criterion = $criteria->getNewCriterion(CarouselVersionTableMap::ID, $value[0]);
                $criterion->addAnd($criteria->getNewCriterion(CarouselVersionTableMap::VERSION, $value[1]));
                $criteria->addOr($criterion);
            }
        }

        $query = CarouselVersionQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) { CarouselVersionTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) { CarouselVersionTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the carousel_version table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return CarouselVersionQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a CarouselVersion or Criteria object.
     *
     * @param mixed               $criteria Criteria or CarouselVersion object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CarouselVersionTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from CarouselVersion object
        }


        // Set the correct dbName
        $query = CarouselVersionQuery::create()->mergeWith($criteria);

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

} // CarouselVersionTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
CarouselVersionTableMap::buildTableMap();
