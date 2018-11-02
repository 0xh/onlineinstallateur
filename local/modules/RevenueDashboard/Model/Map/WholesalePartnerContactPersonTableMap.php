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
use RevenueDashboard\Model\WholesalePartnerContactPerson;
use RevenueDashboard\Model\WholesalePartnerContactPersonQuery;


/**
 * This class defines the structure of the 'wholesale_partner_contact_person' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class WholesalePartnerContactPersonTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;
    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'RevenueDashboard.Model.Map.WholesalePartnerContactPersonTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'thelia';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'wholesale_partner_contact_person';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\RevenueDashboard\\Model\\WholesalePartnerContactPerson';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'RevenueDashboard.Model.WholesalePartnerContactPerson';

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
    const ID = 'wholesale_partner_contact_person.ID';

    /**
     * the column name for the TITLE field
     */
    const TITLE = 'wholesale_partner_contact_person.TITLE';

    /**
     * the column name for the FIRSTNAME field
     */
    const FIRSTNAME = 'wholesale_partner_contact_person.FIRSTNAME';

    /**
     * the column name for the LASTNAME field
     */
    const LASTNAME = 'wholesale_partner_contact_person.LASTNAME';

    /**
     * the column name for the TELEFON field
     */
    const TELEFON = 'wholesale_partner_contact_person.TELEFON';

    /**
     * the column name for the EMAIL field
     */
    const EMAIL = 'wholesale_partner_contact_person.EMAIL';

    /**
     * the column name for the PROFILE_WEBSITE field
     */
    const PROFILE_WEBSITE = 'wholesale_partner_contact_person.PROFILE_WEBSITE';

    /**
     * the column name for the POSITION field
     */
    const POSITION = 'wholesale_partner_contact_person.POSITION';

    /**
     * the column name for the DEPARTMENT field
     */
    const DEPARTMENT = 'wholesale_partner_contact_person.DEPARTMENT';

    /**
     * the column name for the COMMENT field
     */
    const COMMENT = 'wholesale_partner_contact_person.COMMENT';

    /**
     * the column name for the VERSION field
     */
    const VERSION = 'wholesale_partner_contact_person.VERSION';

    /**
     * the column name for the VERSION_CREATED_BY field
     */
    const VERSION_CREATED_BY = 'wholesale_partner_contact_person.VERSION_CREATED_BY';

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
        self::TYPE_COLNAME       => array(WholesalePartnerContactPersonTableMap::ID, WholesalePartnerContactPersonTableMap::TITLE, WholesalePartnerContactPersonTableMap::FIRSTNAME, WholesalePartnerContactPersonTableMap::LASTNAME, WholesalePartnerContactPersonTableMap::TELEFON, WholesalePartnerContactPersonTableMap::EMAIL, WholesalePartnerContactPersonTableMap::PROFILE_WEBSITE, WholesalePartnerContactPersonTableMap::POSITION, WholesalePartnerContactPersonTableMap::DEPARTMENT, WholesalePartnerContactPersonTableMap::COMMENT, WholesalePartnerContactPersonTableMap::VERSION, WholesalePartnerContactPersonTableMap::VERSION_CREATED_BY, ),
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
        self::TYPE_COLNAME       => array(WholesalePartnerContactPersonTableMap::ID => 0, WholesalePartnerContactPersonTableMap::TITLE => 1, WholesalePartnerContactPersonTableMap::FIRSTNAME => 2, WholesalePartnerContactPersonTableMap::LASTNAME => 3, WholesalePartnerContactPersonTableMap::TELEFON => 4, WholesalePartnerContactPersonTableMap::EMAIL => 5, WholesalePartnerContactPersonTableMap::PROFILE_WEBSITE => 6, WholesalePartnerContactPersonTableMap::POSITION => 7, WholesalePartnerContactPersonTableMap::DEPARTMENT => 8, WholesalePartnerContactPersonTableMap::COMMENT => 9, WholesalePartnerContactPersonTableMap::VERSION => 10, WholesalePartnerContactPersonTableMap::VERSION_CREATED_BY => 11, ),
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
        $this->setName('wholesale_partner_contact_person');
        $this->setPhpName('WholesalePartnerContactPerson');
        $this->setClassName('\\RevenueDashboard\\Model\\WholesalePartnerContactPerson');
        $this->setPackage('RevenueDashboard.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('TITLE', 'Title', 'INTEGER', 'customer_title', 'ID', true, null, null);
        $this->addColumn('FIRSTNAME', 'Firstname', 'VARCHAR', false, 255, null);
        $this->addColumn('LASTNAME', 'Lastname', 'VARCHAR', false, 255, null);
        $this->addColumn('TELEFON', 'Telefon', 'VARCHAR', false, 255, null);
        $this->addColumn('EMAIL', 'Email', 'VARCHAR', false, 255, null);
        $this->addColumn('PROFILE_WEBSITE', 'ProfileWebsite', 'VARCHAR', false, 255, null);
        $this->addColumn('POSITION', 'Position', 'VARCHAR', false, 255, null);
        $this->addColumn('DEPARTMENT', 'Department', 'VARCHAR', false, 255, null);
        $this->addColumn('COMMENT', 'Comment', 'VARCHAR', false, 255, null);
        $this->addColumn('VERSION', 'Version', 'INTEGER', false, null, 0);
        $this->addColumn('VERSION_CREATED_BY', 'VersionCreatedBy', 'VARCHAR', false, 100, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('CustomerTitle', '\\Thelia\\Model\\CustomerTitle', RelationMap::MANY_TO_ONE, array('title' => 'id', ), 'RESTRICT', 'RESTRICT');
        $this->addRelation('WholesalePartnerContactPersonVersion', '\\RevenueDashboard\\Model\\WholesalePartnerContactPersonVersion', RelationMap::ONE_TO_MANY, array('id' => 'id', ), 'CASCADE', null, 'WholesalePartnerContactPersonVersions');
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
            'versionable' => array('version_column' => 'version', 'version_table' => '', 'log_created_at' => 'false', 'log_created_by' => 'true', 'log_comment' => 'false', 'version_created_at_column' => 'version_created_at', 'version_created_by_column' => 'version_created_by', 'version_comment_column' => 'version_comment', ),
        );
    } // getBehaviors()
    /**
     * Method to invalidate the instance pool of all tables related to wholesale_partner_contact_person     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
        // Invalidate objects in ".$this->getClassNameFromBuilder($joinedTableTableMapBuilder)." instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
                WholesalePartnerContactPersonVersionTableMap::clearInstancePool();
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
        return $withPrefix ? WholesalePartnerContactPersonTableMap::CLASS_DEFAULT : WholesalePartnerContactPersonTableMap::OM_CLASS;
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
     * @return array (WholesalePartnerContactPerson object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = WholesalePartnerContactPersonTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = WholesalePartnerContactPersonTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + WholesalePartnerContactPersonTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = WholesalePartnerContactPersonTableMap::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            WholesalePartnerContactPersonTableMap::addInstanceToPool($obj, $key);
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
            $key = WholesalePartnerContactPersonTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = WholesalePartnerContactPersonTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                WholesalePartnerContactPersonTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(WholesalePartnerContactPersonTableMap::ID);
            $criteria->addSelectColumn(WholesalePartnerContactPersonTableMap::TITLE);
            $criteria->addSelectColumn(WholesalePartnerContactPersonTableMap::FIRSTNAME);
            $criteria->addSelectColumn(WholesalePartnerContactPersonTableMap::LASTNAME);
            $criteria->addSelectColumn(WholesalePartnerContactPersonTableMap::TELEFON);
            $criteria->addSelectColumn(WholesalePartnerContactPersonTableMap::EMAIL);
            $criteria->addSelectColumn(WholesalePartnerContactPersonTableMap::PROFILE_WEBSITE);
            $criteria->addSelectColumn(WholesalePartnerContactPersonTableMap::POSITION);
            $criteria->addSelectColumn(WholesalePartnerContactPersonTableMap::DEPARTMENT);
            $criteria->addSelectColumn(WholesalePartnerContactPersonTableMap::COMMENT);
            $criteria->addSelectColumn(WholesalePartnerContactPersonTableMap::VERSION);
            $criteria->addSelectColumn(WholesalePartnerContactPersonTableMap::VERSION_CREATED_BY);
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
        return Propel::getServiceContainer()->getDatabaseMap(WholesalePartnerContactPersonTableMap::DATABASE_NAME)->getTable(WholesalePartnerContactPersonTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getServiceContainer()->getDatabaseMap(WholesalePartnerContactPersonTableMap::DATABASE_NAME);
      if (!$dbMap->hasTable(WholesalePartnerContactPersonTableMap::TABLE_NAME)) {
        $dbMap->addTableObject(new WholesalePartnerContactPersonTableMap());
      }
    }

    /**
     * Performs a DELETE on the database, given a WholesalePartnerContactPerson or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or WholesalePartnerContactPerson object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(WholesalePartnerContactPersonTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \RevenueDashboard\Model\WholesalePartnerContactPerson) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(WholesalePartnerContactPersonTableMap::DATABASE_NAME);
            $criteria->add(WholesalePartnerContactPersonTableMap::ID, (array) $values, Criteria::IN);
        }

        $query = WholesalePartnerContactPersonQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) { WholesalePartnerContactPersonTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) { WholesalePartnerContactPersonTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the wholesale_partner_contact_person table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return WholesalePartnerContactPersonQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a WholesalePartnerContactPerson or Criteria object.
     *
     * @param mixed               $criteria Criteria or WholesalePartnerContactPerson object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(WholesalePartnerContactPersonTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from WholesalePartnerContactPerson object
        }

        if ($criteria->containsKey(WholesalePartnerContactPersonTableMap::ID) && $criteria->keyContainsValue(WholesalePartnerContactPersonTableMap::ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.WholesalePartnerContactPersonTableMap::ID.')');
        }


        // Set the correct dbName
        $query = WholesalePartnerContactPersonQuery::create()->mergeWith($criteria);

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

} // WholesalePartnerContactPersonTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
WholesalePartnerContactPersonTableMap::buildTableMap();
