<?php

namespace HookKonfigurator\Model\Map;

use HookKonfigurator\Model\Montage;
use HookKonfigurator\Model\MontageQuery;
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
 * This class defines the structure of the 'montage' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class MontageTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;
    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'HookKonfigurator.Model.Map.MontageTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'thelia';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'montage';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\HookKonfigurator\\Model\\Montage';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'HookKonfigurator.Model.Montage';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 6;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 6;

    /**
     * the column name for the ID field
     */
    const ID = 'montage.ID';

    /**
     * the column name for the TYPE field
     */
    const TYPE = 'montage.TYPE';

    /**
     * the column name for the QUANTITY field
     */
    const QUANTITY = 'montage.QUANTITY';

    /**
     * the column name for the UNIT field
     */
    const UNIT = 'montage.UNIT';

    /**
     * the column name for the EXTRA_QUANTITY_PRICE field
     */
    const EXTRA_QUANTITY_PRICE = 'montage.EXTRA_QUANTITY_PRICE';

    /**
     * the column name for the DURATION field
     */
    const DURATION = 'montage.DURATION';

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
        self::TYPE_PHPNAME       => array('Id', 'Type', 'Quantity', 'Unit', 'ExtraQuantityPrice', 'Duration', ),
        self::TYPE_STUDLYPHPNAME => array('id', 'type', 'quantity', 'unit', 'extraQuantityPrice', 'duration', ),
        self::TYPE_COLNAME       => array(MontageTableMap::ID, MontageTableMap::TYPE, MontageTableMap::QUANTITY, MontageTableMap::UNIT, MontageTableMap::EXTRA_QUANTITY_PRICE, MontageTableMap::DURATION, ),
        self::TYPE_RAW_COLNAME   => array('ID', 'TYPE', 'QUANTITY', 'UNIT', 'EXTRA_QUANTITY_PRICE', 'DURATION', ),
        self::TYPE_FIELDNAME     => array('id', 'type', 'quantity', 'unit', 'extra_quantity_price', 'duration', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'Type' => 1, 'Quantity' => 2, 'Unit' => 3, 'ExtraQuantityPrice' => 4, 'Duration' => 5, ),
        self::TYPE_STUDLYPHPNAME => array('id' => 0, 'type' => 1, 'quantity' => 2, 'unit' => 3, 'extraQuantityPrice' => 4, 'duration' => 5, ),
        self::TYPE_COLNAME       => array(MontageTableMap::ID => 0, MontageTableMap::TYPE => 1, MontageTableMap::QUANTITY => 2, MontageTableMap::UNIT => 3, MontageTableMap::EXTRA_QUANTITY_PRICE => 4, MontageTableMap::DURATION => 5, ),
        self::TYPE_RAW_COLNAME   => array('ID' => 0, 'TYPE' => 1, 'QUANTITY' => 2, 'UNIT' => 3, 'EXTRA_QUANTITY_PRICE' => 4, 'DURATION' => 5, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'type' => 1, 'quantity' => 2, 'unit' => 3, 'extra_quantity_price' => 4, 'duration' => 5, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, )
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
        $this->setName('montage');
        $this->setPhpName('Montage');
        $this->setClassName('\\HookKonfigurator\\Model\\Montage');
        $this->setPackage('HookKonfigurator.Model');
        $this->setUseIdGenerator(false);
        // columns
        $this->addForeignPrimaryKey('ID', 'Id', 'INTEGER' , 'product', 'ID', true, null, null);
        $this->addColumn('TYPE', 'Type', 'VARCHAR', true, 255, 'montage');
        $this->addColumn('QUANTITY', 'Quantity', 'DECIMAL', false, 16, 0);
        $this->addColumn('UNIT', 'Unit', 'VARCHAR', false, 255, 'piece');
        $this->addColumn('EXTRA_QUANTITY_PRICE', 'ExtraQuantityPrice', 'DECIMAL', false, 16, null);
        $this->addColumn('DURATION', 'Duration', 'INTEGER', false, null, 0);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Product', '\\HookKonfigurator\\Model\\Product', RelationMap::MANY_TO_ONE, array('id' => 'id', ), 'CASCADE', null);
        $this->addRelation('MontageConstraints', '\\HookKonfigurator\\Model\\MontageConstraints', RelationMap::ONE_TO_ONE, array('id' => 'id', ), null, null);
        $this->addRelation('ProductHeizungMontage', '\\HookKonfigurator\\Model\\ProductHeizungMontage', RelationMap::ONE_TO_ONE, array('id' => 'id', ), null, null);
        $this->addRelation('SetMontage', '\\HookKonfigurator\\Model\\SetMontage', RelationMap::ONE_TO_ONE, array('id' => 'id', ), null, null);
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
        return $withPrefix ? MontageTableMap::CLASS_DEFAULT : MontageTableMap::OM_CLASS;
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
     * @return array (Montage object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = MontageTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = MontageTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + MontageTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = MontageTableMap::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            MontageTableMap::addInstanceToPool($obj, $key);
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
            $key = MontageTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = MontageTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                MontageTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(MontageTableMap::ID);
            $criteria->addSelectColumn(MontageTableMap::TYPE);
            $criteria->addSelectColumn(MontageTableMap::QUANTITY);
            $criteria->addSelectColumn(MontageTableMap::UNIT);
            $criteria->addSelectColumn(MontageTableMap::EXTRA_QUANTITY_PRICE);
            $criteria->addSelectColumn(MontageTableMap::DURATION);
        } else {
            $criteria->addSelectColumn($alias . '.ID');
            $criteria->addSelectColumn($alias . '.TYPE');
            $criteria->addSelectColumn($alias . '.QUANTITY');
            $criteria->addSelectColumn($alias . '.UNIT');
            $criteria->addSelectColumn($alias . '.EXTRA_QUANTITY_PRICE');
            $criteria->addSelectColumn($alias . '.DURATION');
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
        return Propel::getServiceContainer()->getDatabaseMap(MontageTableMap::DATABASE_NAME)->getTable(MontageTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getServiceContainer()->getDatabaseMap(MontageTableMap::DATABASE_NAME);
      if (!$dbMap->hasTable(MontageTableMap::TABLE_NAME)) {
        $dbMap->addTableObject(new MontageTableMap());
      }
    }

    /**
     * Performs a DELETE on the database, given a Montage or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Montage object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(MontageTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \HookKonfigurator\Model\Montage) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(MontageTableMap::DATABASE_NAME);
            $criteria->add(MontageTableMap::ID, (array) $values, Criteria::IN);
        }

        $query = MontageQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) { MontageTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) { MontageTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the montage table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return MontageQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Montage or Criteria object.
     *
     * @param mixed               $criteria Criteria or Montage object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(MontageTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Montage object
        }


        // Set the correct dbName
        $query = MontageQuery::create()->mergeWith($criteria);

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

} // MontageTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
MontageTableMap::buildTableMap();
