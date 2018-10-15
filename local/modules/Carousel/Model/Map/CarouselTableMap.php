<?php

namespace Carousel\Model\Map;

use Carousel\Model\Carousel;
use Carousel\Model\CarouselQuery;
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
 * This class defines the structure of the 'carousel' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class CarouselTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;
    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'Carousel.Model.Map.CarouselTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'thelia';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'carousel';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Carousel\\Model\\Carousel';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Carousel.Model.Carousel';

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
    const ID = 'carousel.ID';

    /**
     * the column name for the CAROUSEL_ID field
     */
    const CAROUSEL_ID = 'carousel.CAROUSEL_ID';

    /**
     * the column name for the VISIBLE field
     */
    const VISIBLE = 'carousel.VISIBLE';

    /**
     * the column name for the FILE field
     */
    const FILE = 'carousel.FILE';

    /**
     * the column name for the POSITION field
     */
    const POSITION = 'carousel.POSITION';

    /**
     * the column name for the URL field
     */
    const URL = 'carousel.URL';

    /**
     * the column name for the CREATED_AT field
     */
    const CREATED_AT = 'carousel.CREATED_AT';

    /**
     * the column name for the UPDATED_AT field
     */
    const UPDATED_AT = 'carousel.UPDATED_AT';

    /**
     * the column name for the VERSION field
     */
    const VERSION = 'carousel.VERSION';

    /**
     * the column name for the VERSION_CREATED_AT field
     */
    const VERSION_CREATED_AT = 'carousel.VERSION_CREATED_AT';

    /**
     * the column name for the VERSION_CREATED_BY field
     */
    const VERSION_CREATED_BY = 'carousel.VERSION_CREATED_BY';

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
        self::TYPE_PHPNAME       => array('Id', 'CarouselId', 'Visible', 'File', 'Position', 'Url', 'CreatedAt', 'UpdatedAt', 'Version', 'VersionCreatedAt', 'VersionCreatedBy', ),
        self::TYPE_STUDLYPHPNAME => array('id', 'carouselId', 'visible', 'file', 'position', 'url', 'createdAt', 'updatedAt', 'version', 'versionCreatedAt', 'versionCreatedBy', ),
        self::TYPE_COLNAME       => array(CarouselTableMap::ID, CarouselTableMap::CAROUSEL_ID, CarouselTableMap::VISIBLE, CarouselTableMap::FILE, CarouselTableMap::POSITION, CarouselTableMap::URL, CarouselTableMap::CREATED_AT, CarouselTableMap::UPDATED_AT, CarouselTableMap::VERSION, CarouselTableMap::VERSION_CREATED_AT, CarouselTableMap::VERSION_CREATED_BY, ),
        self::TYPE_RAW_COLNAME   => array('ID', 'CAROUSEL_ID', 'VISIBLE', 'FILE', 'POSITION', 'URL', 'CREATED_AT', 'UPDATED_AT', 'VERSION', 'VERSION_CREATED_AT', 'VERSION_CREATED_BY', ),
        self::TYPE_FIELDNAME     => array('id', 'carousel_id', 'visible', 'file', 'position', 'url', 'created_at', 'updated_at', 'version', 'version_created_at', 'version_created_by', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'CarouselId' => 1, 'Visible' => 2, 'File' => 3, 'Position' => 4, 'Url' => 5, 'CreatedAt' => 6, 'UpdatedAt' => 7, 'Version' => 8, 'VersionCreatedAt' => 9, 'VersionCreatedBy' => 10, ),
        self::TYPE_STUDLYPHPNAME => array('id' => 0, 'carouselId' => 1, 'visible' => 2, 'file' => 3, 'position' => 4, 'url' => 5, 'createdAt' => 6, 'updatedAt' => 7, 'version' => 8, 'versionCreatedAt' => 9, 'versionCreatedBy' => 10, ),
        self::TYPE_COLNAME       => array(CarouselTableMap::ID => 0, CarouselTableMap::CAROUSEL_ID => 1, CarouselTableMap::VISIBLE => 2, CarouselTableMap::FILE => 3, CarouselTableMap::POSITION => 4, CarouselTableMap::URL => 5, CarouselTableMap::CREATED_AT => 6, CarouselTableMap::UPDATED_AT => 7, CarouselTableMap::VERSION => 8, CarouselTableMap::VERSION_CREATED_AT => 9, CarouselTableMap::VERSION_CREATED_BY => 10, ),
        self::TYPE_RAW_COLNAME   => array('ID' => 0, 'CAROUSEL_ID' => 1, 'VISIBLE' => 2, 'FILE' => 3, 'POSITION' => 4, 'URL' => 5, 'CREATED_AT' => 6, 'UPDATED_AT' => 7, 'VERSION' => 8, 'VERSION_CREATED_AT' => 9, 'VERSION_CREATED_BY' => 10, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'carousel_id' => 1, 'visible' => 2, 'file' => 3, 'position' => 4, 'url' => 5, 'created_at' => 6, 'updated_at' => 7, 'version' => 8, 'version_created_at' => 9, 'version_created_by' => 10, ),
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
        $this->setName('carousel');
        $this->setPhpName('Carousel');
        $this->setClassName('\\Carousel\\Model\\Carousel');
        $this->setPackage('Carousel.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('CAROUSEL_ID', 'CarouselId', 'INTEGER', 'carousel_name', 'ID', true, null, null);
        $this->addColumn('VISIBLE', 'Visible', 'TINYINT', true, null, 1);
        $this->addColumn('FILE', 'File', 'VARCHAR', false, 255, null);
        $this->addColumn('POSITION', 'Position', 'INTEGER', false, null, null);
        $this->addColumn('URL', 'Url', 'VARCHAR', false, 255, null);
        $this->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('UPDATED_AT', 'UpdatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('VERSION', 'Version', 'INTEGER', false, null, 0);
        $this->addColumn('VERSION_CREATED_AT', 'VersionCreatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('VERSION_CREATED_BY', 'VersionCreatedBy', 'VARCHAR', false, 100, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('CarouselName', '\\Carousel\\Model\\CarouselName', RelationMap::MANY_TO_ONE, array('carousel_id' => 'id', ), 'CASCADE', null);
        $this->addRelation('CarouselI18n', '\\Carousel\\Model\\CarouselI18n', RelationMap::ONE_TO_MANY, array('id' => 'id', ), 'CASCADE', null, 'CarouselI18ns');
        $this->addRelation('CarouselVersion', '\\Carousel\\Model\\CarouselVersion', RelationMap::ONE_TO_MANY, array('id' => 'id', ), 'CASCADE', null, 'CarouselVersions');
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
            'i18n' => array('i18n_table' => '%TABLE%_i18n', 'i18n_phpname' => '%PHPNAME%I18n', 'i18n_columns' => 'alt, title, description, chapo, postscriptum', 'locale_column' => 'locale', 'locale_length' => '5', 'default_locale' => '', 'locale_alias' => '', ),
            'versionable' => array('version_column' => 'version', 'version_table' => '', 'log_created_at' => 'true', 'log_created_by' => 'true', 'log_comment' => 'false', 'version_created_at_column' => 'version_created_at', 'version_created_by_column' => 'version_created_by', 'version_comment_column' => 'version_comment', ),
        );
    } // getBehaviors()
    /**
     * Method to invalidate the instance pool of all tables related to carousel     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
        // Invalidate objects in ".$this->getClassNameFromBuilder($joinedTableTableMapBuilder)." instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
                CarouselI18nTableMap::clearInstancePool();
                CarouselVersionTableMap::clearInstancePool();
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
        return $withPrefix ? CarouselTableMap::CLASS_DEFAULT : CarouselTableMap::OM_CLASS;
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
     * @return array (Carousel object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = CarouselTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = CarouselTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + CarouselTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = CarouselTableMap::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            CarouselTableMap::addInstanceToPool($obj, $key);
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
            $key = CarouselTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = CarouselTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                CarouselTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(CarouselTableMap::ID);
            $criteria->addSelectColumn(CarouselTableMap::CAROUSEL_ID);
            $criteria->addSelectColumn(CarouselTableMap::VISIBLE);
            $criteria->addSelectColumn(CarouselTableMap::FILE);
            $criteria->addSelectColumn(CarouselTableMap::POSITION);
            $criteria->addSelectColumn(CarouselTableMap::URL);
            $criteria->addSelectColumn(CarouselTableMap::CREATED_AT);
            $criteria->addSelectColumn(CarouselTableMap::UPDATED_AT);
            $criteria->addSelectColumn(CarouselTableMap::VERSION);
            $criteria->addSelectColumn(CarouselTableMap::VERSION_CREATED_AT);
            $criteria->addSelectColumn(CarouselTableMap::VERSION_CREATED_BY);
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
        return Propel::getServiceContainer()->getDatabaseMap(CarouselTableMap::DATABASE_NAME)->getTable(CarouselTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getServiceContainer()->getDatabaseMap(CarouselTableMap::DATABASE_NAME);
      if (!$dbMap->hasTable(CarouselTableMap::TABLE_NAME)) {
        $dbMap->addTableObject(new CarouselTableMap());
      }
    }

    /**
     * Performs a DELETE on the database, given a Carousel or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Carousel object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(CarouselTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Carousel\Model\Carousel) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(CarouselTableMap::DATABASE_NAME);
            $criteria->add(CarouselTableMap::ID, (array) $values, Criteria::IN);
        }

        $query = CarouselQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) { CarouselTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) { CarouselTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the carousel table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return CarouselQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Carousel or Criteria object.
     *
     * @param mixed               $criteria Criteria or Carousel object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CarouselTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Carousel object
        }

        if ($criteria->containsKey(CarouselTableMap::ID) && $criteria->keyContainsValue(CarouselTableMap::ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.CarouselTableMap::ID.')');
        }


        // Set the correct dbName
        $query = CarouselQuery::create()->mergeWith($criteria);

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

} // CarouselTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
CarouselTableMap::buildTableMap();
