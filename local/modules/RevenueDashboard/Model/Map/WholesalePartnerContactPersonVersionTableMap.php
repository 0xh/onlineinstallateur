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
use RevenueDashboard\Model\WholesalePartnerContactPersonVersion;
use RevenueDashboard\Model\WholesalePartnerContactPersonVersionQuery;


/**
 * This class defines the structure of the 'wholesale_partner_contact_person_version' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class WholesalePartnerContactPersonVersionTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;
    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'RevenueDashboard.Model.Map.WholesalePartnerContactPersonVersionTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'thelia';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'wholesale_partner_contact_person_version';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\RevenueDashboard\\Model\\WholesalePartnerContactPersonVersion';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'RevenueDashboard.Model.WholesalePartnerContactPersonVersion';

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
    const ID = 'wholesale_partner_contact_person_version.ID';

    /**
     * the column name for the TITLE field
     */
    const TITLE = 'wholesale_partner_contact_person_version.TITLE';

    /**
     * the column name for the FIRSTNAME field
     */
    const FIRSTNAME = 'wholesale_partner_contact_person_version.FIRSTNAME';

    /**
     * the column name for the LASTNAME field
     */
    const LASTNAME = 'wholesale_partner_contact_person_version.LASTNAME';

    /**
     * the column name for the TELEFON field
     */
    const TELEFON = 'wholesale_partner_contact_person_version.TELEFON';

    /**
     * the column name for the EMAIL field
     */
    const EMAIL = 'wholesale_partner_contact_person_version.EMAIL';

    /**
     * the column name for the PROFILE_WEBSITE field
     */
    const PROFILE_WEBSITE = 'wholesale_partner_contact_person_version.PROFILE_WEBSITE';

    /**
     * the column name for the POSITION field
     */
    const POSITION = 'wholesale_partner_contact_person_version.POSITION';

    /**
     * the column name for the DEPARTMENT field
     */
    const DEPARTMENT = 'wholesale_partner_contact_person_version.DEPARTMENT';

    /**
     * the column name for the COMMENT field
     */
    const COMMENT = 'wholesale_partner_contact_person_version.COMMENT';

    /**
     * the column name for the VERSION field
     */
    const VERSION = 'wholesale_partner_contact_person_version.VERSION';

    /**
     * the column name for the VERSION_CREATED_BY field
     */
    const VERSION_CREATED_BY = 'wholesale_partner_contact_person_version.VERSION_CREATED_BY';

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
        self::TYPE_PHPNAME       => array('Id', 'Title', 'Firstname', 'Lastname', 'Telefon', 'Email', 'ProfileWebsite', 'Position', 'Department', 'Comment', 'Version', 'VersionCreatedBy', ),
        self::TYPE_STUDLYPHPNAME => array('id', 'title', 'firstname', 'lastname', 'telefon', 'email', 'profileWebsite', 'position', 'department', 'comment', 'version', 'versionCreatedBy', ),
        self::TYPE_COLNAME       => array(WholesalePartnerContactPersonVersionTableMap::ID, WholesalePartnerContactPersonVersionTableMap::TITLE, WholesalePartnerContactPersonVersionTableMap::FIRSTNAME, WholesalePartnerContactPersonVersionTableMap::LASTNAME, WholesalePartnerContactPersonVersionTableMap::TELEFON, WholesalePartnerContactPersonVersionTableMap::EMAIL, WholesalePartnerContactPersonVersionTableMap::PROFILE_WEBSITE, WholesalePartnerContactPersonVersionTableMap::POSITION, WholesalePartnerContactPersonVersionTableMap::DEPARTMENT, WholesalePartnerContactPersonVersionTableMap::COMMENT, WholesalePartnerContactPersonVersionTableMap::VERSION, WholesalePartnerContactPersonVersionTableMap::VERSION_CREATED_BY, ),
        self::TYPE_RAW_COLNAME   => array('ID', 'TITLE', 'FIRSTNAME', 'LASTNAME', 'TELEFON', 'EMAIL', 'PROFILE_WEBSITE', 'POSITION', 'DEPARTMENT', 'COMMENT', 'VERSION', 'VERSION_CREATED_BY', ),
        self::TYPE_FIELDNAME     => array('id', 'title', 'firstname', 'lastname', 'telefon', 'email', 'profile_website', 'position', 'department', 'comment', 'version', 'version_created_by', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'Title' => 1, 'Firstname' => 2, 'Lastname' => 3, 'Telefon' => 4, 'Email' => 5, 'ProfileWebsite' => 6, 'Position' => 7, 'Department' => 8, 'Comment' => 9, 'Version' => 10, 'VersionCreatedBy' => 11, ),
        self::TYPE_STUDLYPHPNAME => array('id' => 0, 'title' => 1, 'firstname' => 2, 'lastname' => 3, 'telefon' => 4, 'email' => 5, 'profileWebsite' => 6, 'position' => 7, 'department' => 8, 'comment' => 9, 'version' => 10, 'versionCreatedBy' => 11, ),
        self::TYPE_COLNAME       => array(WholesalePartnerContactPersonVersionTableMap::ID => 0, WholesalePartnerContactPersonVersionTableMap::TITLE => 1, WholesalePartnerContactPersonVersionTableMap::FIRSTNAME => 2, WholesalePartnerContactPersonVersionTableMap::LASTNAME => 3, WholesalePartnerContactPersonVersionTableMap::TELEFON => 4, WholesalePartnerContactPersonVersionTableMap::EMAIL => 5, WholesalePartnerContactPersonVersionTableMap::PROFILE_WEBSITE => 6, WholesalePartnerContactPersonVersionTableMap::POSITION => 7, WholesalePartnerContactPersonVersionTableMap::DEPARTMENT => 8, WholesalePartnerContactPersonVersionTableMap::COMMENT => 9, WholesalePartnerContactPersonVersionTableMap::VERSION => 10, WholesalePartnerContactPersonVersionTableMap::VERSION_CREATED_BY => 11, ),
        self::TYPE_RAW_COLNAME   => array('ID' => 0, 'TITLE' => 1, 'FIRSTNAME' => 2, 'LASTNAME' => 3, 'TELEFON' => 4, 'EMAIL' => 5, 'PROFILE_WEBSITE' => 6, 'POSITION' => 7, 'DEPARTMENT' => 8, 'COMMENT' => 9, 'VERSION' => 10, 'VERSION_CREATED_BY' => 11, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'title' => 1, 'firstname' => 2, 'lastname' => 3, 'telefon' => 4, 'email' => 5, 'profile_website' => 6, 'position' => 7, 'department' => 8, 'comment' => 9, 'version' => 10, 'version_created_by' => 11, ),
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
        $this->setName('wholesale_partner_contact_person_version');
        $this->setPhpName('WholesalePartnerContactPersonVersion');
        $this->setClassName('\\RevenueDashboard\\Model\\WholesalePartnerContactPersonVersion');
        $this->setPackage('RevenueDashboard.Model');
        $this->setUseIdGenerator(false);
        // columns
        $this->addForeignPrimaryKey('ID', 'Id', 'INTEGER' , 'wholesale_partner_contact_person', 'ID', true, null, null);
        $this->addColumn('TITLE', 'Title', 'INTEGER', true, null, null);
        $this->addColumn('FIRSTNAME', 'Firstname', 'VARCHAR', false, 255, null);
        $this->addColumn('LASTNAME', 'Lastname', 'VARCHAR', false, 255, null);
        $this->addColumn('TELEFON', 'Telefon', 'VARCHAR', false, 255, null);
        $this->addColumn('EMAIL', 'Email', 'VARCHAR', false, 255, null);
        $this->addColumn('PROFILE_WEBSITE', 'ProfileWebsite', 'VARCHAR', false, 255, null);
        $this->addColumn('POSITION', 'Position', 'VARCHAR', false, 255, null);
        $this->addColumn('DEPARTMENT', 'Department', 'VARCHAR', false, 255, null);
        $this->addColumn('COMMENT', 'Comment', 'VARCHAR', false, 255, null);
        $this->addPrimaryKey('VERSION', 'Version', 'INTEGER', true, null, 0);
        $this->addColumn('VERSION_CREATED_BY', 'VersionCreatedBy', 'VARCHAR', false, 100, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('WholesalePartnerContactPerson', '\\RevenueDashboard\\Model\\WholesalePartnerContactPerson', RelationMap::MANY_TO_ONE, array('id' => 'id', ), 'CASCADE', null);
    } // buildRelations()

    /**
     * Adds an object to the instance pool.
     *
     * Propel keeps cached copies of objects in an instance pool when they are retrieved
     * from the database. In some cases you may need to explicitly add objects
     * to the cache in order to ensure that the same objects are always returned by find*()
     * and findPk*() calls.
     *
     * @param \RevenueDashboard\Model\WholesalePartnerContactPersonVersion $obj A \RevenueDashboard\Model\WholesalePartnerContactPersonVersion object.
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
     * @param mixed $value A \RevenueDashboard\Model\WholesalePartnerContactPersonVersion object or a primary key value.
     */
    public static function removeInstanceFromPool($value)
    {
        if (Propel::isInstancePoolingEnabled() && null !== $value) {
            if (is_object($value) && $value instanceof \RevenueDashboard\Model\WholesalePartnerContactPersonVersion) {
                $key = serialize(array((string) $value->getId(), (string) $value->getVersion()));

            } elseif (is_array($value) && count($value) === 2) {
                // assume we've been passed a primary key";
                $key = serialize(array((string) $value[0], (string) $value[1]));
            } elseif ($value instanceof Criteria) {
                self::$instances = [];

                return;
            } else {
                $e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or \RevenueDashboard\Model\WholesalePartnerContactPersonVersion object; got " . (is_object($value) ? get_class($value) . ' object.' : var_export($value, true)));
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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] === null && $row[TableMap::TYPE_NUM == $indexType ? 10 + $offset : static::translateFieldName('Version', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return serialize(array((string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)], (string) $row[TableMap::TYPE_NUM == $indexType ? 10 + $offset : static::translateFieldName('Version', TableMap::TYPE_PHPNAME, $indexType)]));
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
        return $withPrefix ? WholesalePartnerContactPersonVersionTableMap::CLASS_DEFAULT : WholesalePartnerContactPersonVersionTableMap::OM_CLASS;
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
     * @return array (WholesalePartnerContactPersonVersion object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = WholesalePartnerContactPersonVersionTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = WholesalePartnerContactPersonVersionTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + WholesalePartnerContactPersonVersionTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = WholesalePartnerContactPersonVersionTableMap::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            WholesalePartnerContactPersonVersionTableMap::addInstanceToPool($obj, $key);
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
            $key = WholesalePartnerContactPersonVersionTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = WholesalePartnerContactPersonVersionTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                WholesalePartnerContactPersonVersionTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(WholesalePartnerContactPersonVersionTableMap::ID);
            $criteria->addSelectColumn(WholesalePartnerContactPersonVersionTableMap::TITLE);
            $criteria->addSelectColumn(WholesalePartnerContactPersonVersionTableMap::FIRSTNAME);
            $criteria->addSelectColumn(WholesalePartnerContactPersonVersionTableMap::LASTNAME);
            $criteria->addSelectColumn(WholesalePartnerContactPersonVersionTableMap::TELEFON);
            $criteria->addSelectColumn(WholesalePartnerContactPersonVersionTableMap::EMAIL);
            $criteria->addSelectColumn(WholesalePartnerContactPersonVersionTableMap::PROFILE_WEBSITE);
            $criteria->addSelectColumn(WholesalePartnerContactPersonVersionTableMap::POSITION);
            $criteria->addSelectColumn(WholesalePartnerContactPersonVersionTableMap::DEPARTMENT);
            $criteria->addSelectColumn(WholesalePartnerContactPersonVersionTableMap::COMMENT);
            $criteria->addSelectColumn(WholesalePartnerContactPersonVersionTableMap::VERSION);
            $criteria->addSelectColumn(WholesalePartnerContactPersonVersionTableMap::VERSION_CREATED_BY);
        } else {
            $criteria->addSelectColumn($alias . '.ID');
            $criteria->addSelectColumn($alias . '.TITLE');
            $criteria->addSelectColumn($alias . '.FIRSTNAME');
            $criteria->addSelectColumn($alias . '.LASTNAME');
            $criteria->addSelectColumn($alias . '.TELEFON');
            $criteria->addSelectColumn($alias . '.EMAIL');
            $criteria->addSelectColumn($alias . '.PROFILE_WEBSITE');
            $criteria->addSelectColumn($alias . '.POSITION');
            $criteria->addSelectColumn($alias . '.DEPARTMENT');
            $criteria->addSelectColumn($alias . '.COMMENT');
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
        return Propel::getServiceContainer()->getDatabaseMap(WholesalePartnerContactPersonVersionTableMap::DATABASE_NAME)->getTable(WholesalePartnerContactPersonVersionTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getServiceContainer()->getDatabaseMap(WholesalePartnerContactPersonVersionTableMap::DATABASE_NAME);
      if (!$dbMap->hasTable(WholesalePartnerContactPersonVersionTableMap::TABLE_NAME)) {
        $dbMap->addTableObject(new WholesalePartnerContactPersonVersionTableMap());
      }
    }

    /**
     * Performs a DELETE on the database, given a WholesalePartnerContactPersonVersion or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or WholesalePartnerContactPersonVersion object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(WholesalePartnerContactPersonVersionTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \RevenueDashboard\Model\WholesalePartnerContactPersonVersion) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(WholesalePartnerContactPersonVersionTableMap::DATABASE_NAME);
            // primary key is composite; we therefore, expect
            // the primary key passed to be an array of pkey values
            if (count($values) == count($values, COUNT_RECURSIVE)) {
                // array is not multi-dimensional
                $values = array($values);
            }
            foreach ($values as $value) {
                $criterion = $criteria->getNewCriterion(WholesalePartnerContactPersonVersionTableMap::ID, $value[0]);
                $criterion->addAnd($criteria->getNewCriterion(WholesalePartnerContactPersonVersionTableMap::VERSION, $value[1]));
                $criteria->addOr($criterion);
            }
        }

        $query = WholesalePartnerContactPersonVersionQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) { WholesalePartnerContactPersonVersionTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) { WholesalePartnerContactPersonVersionTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the wholesale_partner_contact_person_version table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return WholesalePartnerContactPersonVersionQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a WholesalePartnerContactPersonVersion or Criteria object.
     *
     * @param mixed               $criteria Criteria or WholesalePartnerContactPersonVersion object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(WholesalePartnerContactPersonVersionTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from WholesalePartnerContactPersonVersion object
        }


        // Set the correct dbName
        $query = WholesalePartnerContactPersonVersionQuery::create()->mergeWith($criteria);

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

} // WholesalePartnerContactPersonVersionTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
WholesalePartnerContactPersonVersionTableMap::buildTableMap();
