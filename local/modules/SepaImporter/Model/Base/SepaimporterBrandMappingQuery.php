<?php

namespace SepaImporter\Model\Base;

use \Exception;
use \PDO;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;
use SepaImporter\Model\SepaimporterBrandMapping as ChildSepaimporterBrandMapping;
use SepaImporter\Model\SepaimporterBrandMappingQuery as ChildSepaimporterBrandMappingQuery;
use SepaImporter\Model\Map\SepaimporterBrandMappingTableMap;
use Thelia\Model\Brand;

/**
 * Base class that represents a query for the 'sepaimporter_brand_mapping' table.
 *
 * 
 *
 * @method     ChildSepaimporterBrandMappingQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildSepaimporterBrandMappingQuery orderByBrandId($order = Criteria::ASC) Order by the brand_id column
 * @method     ChildSepaimporterBrandMappingQuery orderBySourceBrandName($order = Criteria::ASC) Order by the source_brand_name column
 * @method     ChildSepaimporterBrandMappingQuery orderBySourceName($order = Criteria::ASC) Order by the source_name column
 *
 * @method     ChildSepaimporterBrandMappingQuery groupById() Group by the id column
 * @method     ChildSepaimporterBrandMappingQuery groupByBrandId() Group by the brand_id column
 * @method     ChildSepaimporterBrandMappingQuery groupBySourceBrandName() Group by the source_brand_name column
 * @method     ChildSepaimporterBrandMappingQuery groupBySourceName() Group by the source_name column
 *
 * @method     ChildSepaimporterBrandMappingQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildSepaimporterBrandMappingQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildSepaimporterBrandMappingQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildSepaimporterBrandMappingQuery leftJoinBrand($relationAlias = null) Adds a LEFT JOIN clause to the query using the Brand relation
 * @method     ChildSepaimporterBrandMappingQuery rightJoinBrand($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Brand relation
 * @method     ChildSepaimporterBrandMappingQuery innerJoinBrand($relationAlias = null) Adds a INNER JOIN clause to the query using the Brand relation
 *
 * @method     ChildSepaimporterBrandMapping findOne(ConnectionInterface $con = null) Return the first ChildSepaimporterBrandMapping matching the query
 * @method     ChildSepaimporterBrandMapping findOneOrCreate(ConnectionInterface $con = null) Return the first ChildSepaimporterBrandMapping matching the query, or a new ChildSepaimporterBrandMapping object populated from the query conditions when no match is found
 *
 * @method     ChildSepaimporterBrandMapping findOneById(int $id) Return the first ChildSepaimporterBrandMapping filtered by the id column
 * @method     ChildSepaimporterBrandMapping findOneByBrandId(int $brand_id) Return the first ChildSepaimporterBrandMapping filtered by the brand_id column
 * @method     ChildSepaimporterBrandMapping findOneBySourceBrandName(string $source_brand_name) Return the first ChildSepaimporterBrandMapping filtered by the source_brand_name column
 * @method     ChildSepaimporterBrandMapping findOneBySourceName(string $source_name) Return the first ChildSepaimporterBrandMapping filtered by the source_name column
 *
 * @method     array findById(int $id) Return ChildSepaimporterBrandMapping objects filtered by the id column
 * @method     array findByBrandId(int $brand_id) Return ChildSepaimporterBrandMapping objects filtered by the brand_id column
 * @method     array findBySourceBrandName(string $source_brand_name) Return ChildSepaimporterBrandMapping objects filtered by the source_brand_name column
 * @method     array findBySourceName(string $source_name) Return ChildSepaimporterBrandMapping objects filtered by the source_name column
 *
 */
abstract class SepaimporterBrandMappingQuery extends ModelCriteria
{
    
    /**
     * Initializes internal state of \SepaImporter\Model\Base\SepaimporterBrandMappingQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'thelia', $modelName = '\\SepaImporter\\Model\\SepaimporterBrandMapping', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildSepaimporterBrandMappingQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildSepaimporterBrandMappingQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \SepaImporter\Model\SepaimporterBrandMappingQuery) {
            return $criteria;
        }
        $query = new \SepaImporter\Model\SepaimporterBrandMappingQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildSepaimporterBrandMapping|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = SepaimporterBrandMappingTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(SepaimporterBrandMappingTableMap::DATABASE_NAME);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return   ChildSepaimporterBrandMapping A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ID, BRAND_ID, SOURCE_BRAND_NAME, SOURCE_NAME FROM sepaimporter_brand_mapping WHERE ID = :p0';
        try {
            $stmt = $con->prepare($sql);            
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            $obj = new ChildSepaimporterBrandMapping();
            $obj->hydrate($row);
            SepaimporterBrandMappingTableMap::addInstanceToPool($obj, (string) $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildSepaimporterBrandMapping|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return ChildSepaimporterBrandMappingQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(SepaimporterBrandMappingTableMap::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildSepaimporterBrandMappingQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(SepaimporterBrandMappingTableMap::ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id > 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSepaimporterBrandMappingQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(SepaimporterBrandMappingTableMap::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(SepaimporterBrandMappingTableMap::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SepaimporterBrandMappingTableMap::ID, $id, $comparison);
    }

    /**
     * Filter the query on the brand_id column
     *
     * Example usage:
     * <code>
     * $query->filterByBrandId(1234); // WHERE brand_id = 1234
     * $query->filterByBrandId(array(12, 34)); // WHERE brand_id IN (12, 34)
     * $query->filterByBrandId(array('min' => 12)); // WHERE brand_id > 12
     * </code>
     *
     * @see       filterByBrand()
     *
     * @param     mixed $brandId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSepaimporterBrandMappingQuery The current query, for fluid interface
     */
    public function filterByBrandId($brandId = null, $comparison = null)
    {
        if (is_array($brandId)) {
            $useMinMax = false;
            if (isset($brandId['min'])) {
                $this->addUsingAlias(SepaimporterBrandMappingTableMap::BRAND_ID, $brandId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($brandId['max'])) {
                $this->addUsingAlias(SepaimporterBrandMappingTableMap::BRAND_ID, $brandId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SepaimporterBrandMappingTableMap::BRAND_ID, $brandId, $comparison);
    }

    /**
     * Filter the query on the source_brand_name column
     *
     * Example usage:
     * <code>
     * $query->filterBySourceBrandName('fooValue');   // WHERE source_brand_name = 'fooValue'
     * $query->filterBySourceBrandName('%fooValue%'); // WHERE source_brand_name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $sourceBrandName The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSepaimporterBrandMappingQuery The current query, for fluid interface
     */
    public function filterBySourceBrandName($sourceBrandName = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($sourceBrandName)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $sourceBrandName)) {
                $sourceBrandName = str_replace('*', '%', $sourceBrandName);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SepaimporterBrandMappingTableMap::SOURCE_BRAND_NAME, $sourceBrandName, $comparison);
    }

    /**
     * Filter the query on the source_name column
     *
     * Example usage:
     * <code>
     * $query->filterBySourceName('fooValue');   // WHERE source_name = 'fooValue'
     * $query->filterBySourceName('%fooValue%'); // WHERE source_name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $sourceName The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSepaimporterBrandMappingQuery The current query, for fluid interface
     */
    public function filterBySourceName($sourceName = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($sourceName)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $sourceName)) {
                $sourceName = str_replace('*', '%', $sourceName);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SepaimporterBrandMappingTableMap::SOURCE_NAME, $sourceName, $comparison);
    }

    /**
     * Filter the query by a related \Thelia\Model\Brand object
     *
     * @param \Thelia\Model\Brand|ObjectCollection $brand The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSepaimporterBrandMappingQuery The current query, for fluid interface
     */
    public function filterByBrand($brand, $comparison = null)
    {
        if ($brand instanceof \Thelia\Model\Brand) {
            return $this
                ->addUsingAlias(SepaimporterBrandMappingTableMap::BRAND_ID, $brand->getId(), $comparison);
        } elseif ($brand instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(SepaimporterBrandMappingTableMap::BRAND_ID, $brand->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByBrand() only accepts arguments of type \Thelia\Model\Brand or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Brand relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildSepaimporterBrandMappingQuery The current query, for fluid interface
     */
    public function joinBrand($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Brand');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Brand');
        }

        return $this;
    }

    /**
     * Use the Brand relation Brand object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Thelia\Model\BrandQuery A secondary query class using the current class as primary query
     */
    public function useBrandQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinBrand($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Brand', '\Thelia\Model\BrandQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildSepaimporterBrandMapping $sepaimporterBrandMapping Object to remove from the list of results
     *
     * @return ChildSepaimporterBrandMappingQuery The current query, for fluid interface
     */
    public function prune($sepaimporterBrandMapping = null)
    {
        if ($sepaimporterBrandMapping) {
            $this->addUsingAlias(SepaimporterBrandMappingTableMap::ID, $sepaimporterBrandMapping->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the sepaimporter_brand_mapping table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SepaimporterBrandMappingTableMap::DATABASE_NAME);
        }
        $affectedRows = 0; // initialize var to track total num of affected rows
        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            SepaimporterBrandMappingTableMap::clearInstancePool();
            SepaimporterBrandMappingTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildSepaimporterBrandMapping or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildSepaimporterBrandMapping object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
     public function delete(ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SepaimporterBrandMappingTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(SepaimporterBrandMappingTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            

        SepaimporterBrandMappingTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            SepaimporterBrandMappingTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

} // SepaimporterBrandMappingQuery
