<?php

namespace HookKonfigurator\Model\Map;

use HookKonfigurator\Model\MontageConstraints;
use HookKonfigurator\Model\MontageConstraintsQuery;
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
 * This class defines the structure of the 'montage_constraints' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class MontageConstraintsTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;
    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'HookKonfigurator.Model.Map.MontageConstraintsTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'montage_constraints';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\HookKonfigurator\\Model\\MontageConstraints';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'HookKonfigurator.Model.MontageConstraints';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 4;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 4;

    /**
     * the column name for the ID field
     */
    const ID = 'montage_constraints.ID';

    /**
     * the column name for the MONTAGE_ID field
     */
    const MONTAGE_ID = 'montage_constraints.MONTAGE_ID';

    /**
     * the column name for the CONSTRAINTS_ID field
     */
    const CONSTRAINTS_ID = 'montage_constraints.CONSTRAINTS_ID';

    /**
     * the column name for the CONSTRAINT_VALUE field
     */
    const CONSTRAINT_VALUE = 'montage_constraints.CONSTRAINT_VALUE';

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
        self::TYPE_PHPNAME       => array('Id', 'MontageId', 'ConstraintsId', 'ConstraintValue', ),
        self::TYPE_STUDLYPHPNAME => array('id', 'montageId', 'constraintsId', 'constraintValue', ),
        self::TYPE_COLNAME       => array(MontageConstraintsTableMap::ID, MontageConstraintsTableMap::MONTAGE_ID, MontageConstraintsTableMap::CONSTRAINTS_ID, MontageConstraintsTableMap::CONSTRAINT_VALUE, ),
        self::TYPE_RAW_COLNAME   => array('ID', 'MONTAGE_ID', 'CONSTRAINTS_ID', 'CONSTRAINT_VALUE', ),
        self::TYPE_FIELDNAME     => array('id', 'montage_id', 'constraints_id', 'constraint_value', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'MontageId' => 1, 'ConstraintsId' => 2, 'ConstraintValue' => 3, ),
        self::TYPE_STUDLYPHPNAME => array('id' => 0, 'montageId' => 1, 'constraintsId' => 2, 'constraintValue' => 3, ),
        self::TYPE_COLNAME       => array(MontageConstraintsTableMap::ID => 0, MontageConstraintsTableMap::MONTAGE_ID => 1, MontageConstraintsTableMap::CONSTRAINTS_ID => 2, MontageConstraintsTableMap::CONSTRAINT_VALUE => 3, ),
        self::TYPE_RAW_COLNAME   => array('ID' => 0, 'MONTAGE_ID' => 1, 'CONSTRAINTS_ID' => 2, 'CONSTRAINT_VALUE' => 3, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'montage_id' => 1, 'constraints_id' => 2, 'constraint_value' => 3, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, )
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
        $this->setName('montage_constraints');
        $this->setPhpName('MontageConstraints');
        $this->setClassName('\\HookKonfigurator\\Model\\MontageConstraints');
        $this->setPackage('HookKonfigurator.Model');
        $this->setUseIdGenerator(false);
        // columns
        $this->addForeignPrimaryKey('ID', 'Id', 'INTEGER' , 'constraints', 'ID', true, null, null);
        $this->addForeignPrimaryKey('ID', 'Id', 'INTEGER' , 'montage', 'ID', true, null, null);
        $this->addColumn('MONTAGE_ID', 'MontageId', 'INTEGER', true, null, null);
        $this->addColumn('CONSTRAINTS_ID', 'ConstraintsId', 'INTEGER', true, null, null);
        $this->addColumn('CONSTRAINT_VALUE', 'ConstraintValue', 'DECIMAL', false, 16, 0);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Constraints', '\\HookKonfigurator\\Model\\Constraints', RelationMap::MANY_TO_ONE, array('id' => 'id', ), null, null);
        $this->addRelation('Montage', '\\HookKonfigurator\\Model\\Montage', RelationMap::MANY_TO_ONE, array('id' => 'id', ), null, null);
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
        return $withPrefix ? MontageConstraintsTableMap::CLASS_DEFAULT : MontageConstraintsTableMap::OM_CLASS;
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
     * @return array (MontageConstraints object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = MontageConstraintsTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = MontageConstraintsTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + MontageConstraintsTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = MontageConstraintsTableMap::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            MontageConstraintsTableMap::addInstanceToPool($obj, $key);
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
            $key = MontageConstraintsTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = MontageConstraintsTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                MontageConstraintsTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(MontageConstraintsTableMap::ID);
            $criteria->addSelectColumn(MontageConstraintsTableMap::MONTAGE_ID);
            $criteria->addSelectColumn(MontageConstraintsTableMap::CONSTRAINTS_ID);
            $criteria->addSelectColumn(MontageConstraintsTableMap::CONSTRAINT_VALUE);
        } else {
            $criteria->addSelectColumn($alias . '.ID');
            $criteria->addSelectColumn($alias . '.MONTAGE_ID');
            $criteria->addSelectColumn($alias . '.CONSTRAINTS_ID');
            $criteria->addSelectColumn($alias . '.CONSTRAINT_VALUE');
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
        return Propel::getServiceContainer()->getDatabaseMap(MontageConstraintsTableMap::DATABASE_NAME)->getTable(MontageConstraintsTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getServiceContainer()->getDatabaseMap(MontageConstraintsTableMap::DATABASE_NAME);
      if (!$dbMap->hasTable(MontageConstraintsTableMap::TABLE_NAME)) {
        $dbMap->addTableObject(new MontageConstraintsTableMap());
      }
    }

    /**
     * Performs a DELETE on the database, given a MontageConstraints or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or MontageConstraints object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(MontageConstraintsTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \HookKonfigurator\Model\MontageConstraints) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(MontageConstraintsTableMap::DATABASE_NAME);
            $criteria->add(MontageConstraintsTableMap::ID, (array) $values, Criteria::IN);
        }

        $query = MontageConstraintsQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) { MontageConstraintsTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) { MontageConstraintsTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the montage_constraints table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return MontageConstraintsQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a MontageConstraints or Criteria object.
     *
     * @param mixed               $criteria Criteria or MontageConstraints object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(MontageConstraintsTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from MontageConstraints object
        }


        // Set the correct dbName
        $query = MontageConstraintsQuery::create()->mergeWith($criteria);

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

} // MontageConstraintsTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
MontageConstraintsTableMap::buildTableMap();
