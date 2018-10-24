<?php

namespace Selection\Model\Map;

use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;
use Selection\Model\SelectionFeatures;
use Selection\Model\SelectionFeaturesQuery;


/**
 * This class defines the structure of the 'selection_features' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class SelectionFeaturesTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;
    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'Selection.Model.Map.SelectionFeaturesTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'thelia';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'selection_features';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Selection\\Model\\SelectionFeatures';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Selection.Model.SelectionFeatures';

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
    const ID = 'selection_features.ID';

    /**
     * the column name for the FEATURE_ID field
     */
    const FEATURE_ID = 'selection_features.FEATURE_ID';

    /**
     * the column name for the SELECTION_ID field
     */
    const SELECTION_ID = 'selection_features.SELECTION_ID';

    /**
     * the column name for the FEATURE_AV_ID field
     */
    const FEATURE_AV_ID = 'selection_features.FEATURE_AV_ID';

    /**
     * the column name for the FREETEXT_VALUE field
     */
    const FREETEXT_VALUE = 'selection_features.FREETEXT_VALUE';

    /**
     * the column name for the POSITION field
     */
    const POSITION = 'selection_features.POSITION';

    /**
     * the column name for the CREATED_AT field
     */
    const CREATED_AT = 'selection_features.CREATED_AT';

    /**
     * the column name for the UPDATED_AT field
     */
    const UPDATED_AT = 'selection_features.UPDATED_AT';

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
        self::TYPE_PHPNAME       => array('Id', 'FeatureId', 'SelectionId', 'FeatureAvId', 'FreetextValue', 'Position', 'CreatedAt', 'UpdatedAt', ),
        self::TYPE_STUDLYPHPNAME => array('id', 'featureId', 'selectionId', 'featureAvId', 'freetextValue', 'position', 'createdAt', 'updatedAt', ),
        self::TYPE_COLNAME       => array(SelectionFeaturesTableMap::ID, SelectionFeaturesTableMap::FEATURE_ID, SelectionFeaturesTableMap::SELECTION_ID, SelectionFeaturesTableMap::FEATURE_AV_ID, SelectionFeaturesTableMap::FREETEXT_VALUE, SelectionFeaturesTableMap::POSITION, SelectionFeaturesTableMap::CREATED_AT, SelectionFeaturesTableMap::UPDATED_AT, ),
        self::TYPE_RAW_COLNAME   => array('ID', 'FEATURE_ID', 'SELECTION_ID', 'FEATURE_AV_ID', 'FREETEXT_VALUE', 'POSITION', 'CREATED_AT', 'UPDATED_AT', ),
        self::TYPE_FIELDNAME     => array('id', 'feature_id', 'selection_id', 'feature_av_id', 'freetext_value', 'position', 'created_at', 'updated_at', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'FeatureId' => 1, 'SelectionId' => 2, 'FeatureAvId' => 3, 'FreetextValue' => 4, 'Position' => 5, 'CreatedAt' => 6, 'UpdatedAt' => 7, ),
        self::TYPE_STUDLYPHPNAME => array('id' => 0, 'featureId' => 1, 'selectionId' => 2, 'featureAvId' => 3, 'freetextValue' => 4, 'position' => 5, 'createdAt' => 6, 'updatedAt' => 7, ),
        self::TYPE_COLNAME       => array(SelectionFeaturesTableMap::ID => 0, SelectionFeaturesTableMap::FEATURE_ID => 1, SelectionFeaturesTableMap::SELECTION_ID => 2, SelectionFeaturesTableMap::FEATURE_AV_ID => 3, SelectionFeaturesTableMap::FREETEXT_VALUE => 4, SelectionFeaturesTableMap::POSITION => 5, SelectionFeaturesTableMap::CREATED_AT => 6, SelectionFeaturesTableMap::UPDATED_AT => 7, ),
        self::TYPE_RAW_COLNAME   => array('ID' => 0, 'FEATURE_ID' => 1, 'SELECTION_ID' => 2, 'FEATURE_AV_ID' => 3, 'FREETEXT_VALUE' => 4, 'POSITION' => 5, 'CREATED_AT' => 6, 'UPDATED_AT' => 7, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'feature_id' => 1, 'selection_id' => 2, 'feature_av_id' => 3, 'freetext_value' => 4, 'position' => 5, 'created_at' => 6, 'updated_at' => 7, ),
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
        $this->setName('selection_features');
        $this->setPhpName('SelectionFeatures');
        $this->setClassName('\\Selection\\Model\\SelectionFeatures');
        $this->setPackage('Selection.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('FEATURE_ID', 'FeatureId', 'INTEGER', 'feature', 'ID', true, null, null);
        $this->addColumn('SELECTION_ID', 'SelectionId', 'INTEGER', true, null, null);
        $this->addForeignKey('FEATURE_AV_ID', 'FeatureAvId', 'INTEGER', 'feature_av', 'ID', true, null, null);
        $this->addForeignKey('FEATURE_AV_ID', 'FeatureAvId', 'INTEGER', 'feature_av_i18n', 'ID', true, null, null);
        $this->addColumn('FREETEXT_VALUE', 'FreetextValue', 'LONGVARCHAR', true, null, null);
        $this->addColumn('POSITION', 'Position', 'INTEGER', false, null, null);
        $this->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('UPDATED_AT', 'UpdatedAt', 'TIMESTAMP', false, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Feature', '\\Thelia\\Model\\Feature', RelationMap::MANY_TO_ONE, array('feature_id' => 'id', ), 'CASCADE', 'RESTRICT');
        $this->addRelation('FeatureAv', '\\Thelia\\Model\\FeatureAv', RelationMap::MANY_TO_ONE, array('feature_av_id' => 'id', ), 'CASCADE', 'RESTRICT');
        $this->addRelation('FeatureAvI18n', '\\Thelia\\Model\\FeatureAvI18n', RelationMap::MANY_TO_ONE, array('feature_av_id' => 'id', ), 'CASCADE', 'RESTRICT');
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
        );
    } // getBehaviors()

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
        return $withPrefix ? SelectionFeaturesTableMap::CLASS_DEFAULT : SelectionFeaturesTableMap::OM_CLASS;
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
     * @return array (SelectionFeatures object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = SelectionFeaturesTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = SelectionFeaturesTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + SelectionFeaturesTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = SelectionFeaturesTableMap::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            SelectionFeaturesTableMap::addInstanceToPool($obj, $key);
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
            $key = SelectionFeaturesTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = SelectionFeaturesTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                SelectionFeaturesTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(SelectionFeaturesTableMap::ID);
            $criteria->addSelectColumn(SelectionFeaturesTableMap::FEATURE_ID);
            $criteria->addSelectColumn(SelectionFeaturesTableMap::SELECTION_ID);
            $criteria->addSelectColumn(SelectionFeaturesTableMap::FEATURE_AV_ID);
            $criteria->addSelectColumn(SelectionFeaturesTableMap::FREETEXT_VALUE);
            $criteria->addSelectColumn(SelectionFeaturesTableMap::POSITION);
            $criteria->addSelectColumn(SelectionFeaturesTableMap::CREATED_AT);
            $criteria->addSelectColumn(SelectionFeaturesTableMap::UPDATED_AT);
        } else {
            $criteria->addSelectColumn($alias . '.ID');
            $criteria->addSelectColumn($alias . '.FEATURE_ID');
            $criteria->addSelectColumn($alias . '.SELECTION_ID');
            $criteria->addSelectColumn($alias . '.FEATURE_AV_ID');
            $criteria->addSelectColumn($alias . '.FREETEXT_VALUE');
            $criteria->addSelectColumn($alias . '.POSITION');
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
        return Propel::getServiceContainer()->getDatabaseMap(SelectionFeaturesTableMap::DATABASE_NAME)->getTable(SelectionFeaturesTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getServiceContainer()->getDatabaseMap(SelectionFeaturesTableMap::DATABASE_NAME);
      if (!$dbMap->hasTable(SelectionFeaturesTableMap::TABLE_NAME)) {
        $dbMap->addTableObject(new SelectionFeaturesTableMap());
      }
    }

    /**
     * Performs a DELETE on the database, given a SelectionFeatures or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or SelectionFeatures object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(SelectionFeaturesTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Selection\Model\SelectionFeatures) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(SelectionFeaturesTableMap::DATABASE_NAME);
            $criteria->add(SelectionFeaturesTableMap::ID, (array) $values, Criteria::IN);
        }

        $query = SelectionFeaturesQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) { SelectionFeaturesTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) { SelectionFeaturesTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the selection_features table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return SelectionFeaturesQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a SelectionFeatures or Criteria object.
     *
     * @param mixed               $criteria Criteria or SelectionFeatures object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SelectionFeaturesTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from SelectionFeatures object
        }

        if ($criteria->containsKey(SelectionFeaturesTableMap::ID) && $criteria->keyContainsValue(SelectionFeaturesTableMap::ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.SelectionFeaturesTableMap::ID.')');
        }


        // Set the correct dbName
        $query = SelectionFeaturesQuery::create()->mergeWith($criteria);

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

} // SelectionFeaturesTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
SelectionFeaturesTableMap::buildTableMap();
