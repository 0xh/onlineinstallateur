<?php

namespace RevenueDashboard\Model\Base;

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
use RevenueDashboard\Model\WholesalePartnerBrandMatching as ChildWholesalePartnerBrandMatching;
use RevenueDashboard\Model\WholesalePartnerBrandMatchingQuery as ChildWholesalePartnerBrandMatchingQuery;
use RevenueDashboard\Model\Map\WholesalePartnerBrandMatchingTableMap;
use Thelia\Model\Brand;

/**
 * Base class that represents a query for the 'wholesale_partner_brand_matching' table.
 *
 * 
 *
 * @method     ChildWholesalePartnerBrandMatchingQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildWholesalePartnerBrandMatchingQuery orderByBrandIntern($order = Criteria::ASC) Order by the brand_intern column
 * @method     ChildWholesalePartnerBrandMatchingQuery orderByBrandExtern($order = Criteria::ASC) Order by the brand_extern column
 * @method     ChildWholesalePartnerBrandMatchingQuery orderByPartnerId($order = Criteria::ASC) Order by the partner_id column
 * @method     ChildWholesalePartnerBrandMatchingQuery orderByBrandCode($order = Criteria::ASC) Order by the brand_code column
 *
 * @method     ChildWholesalePartnerBrandMatchingQuery groupById() Group by the id column
 * @method     ChildWholesalePartnerBrandMatchingQuery groupByBrandIntern() Group by the brand_intern column
 * @method     ChildWholesalePartnerBrandMatchingQuery groupByBrandExtern() Group by the brand_extern column
 * @method     ChildWholesalePartnerBrandMatchingQuery groupByPartnerId() Group by the partner_id column
 * @method     ChildWholesalePartnerBrandMatchingQuery groupByBrandCode() Group by the brand_code column
 *
 * @method     ChildWholesalePartnerBrandMatchingQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildWholesalePartnerBrandMatchingQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildWholesalePartnerBrandMatchingQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildWholesalePartnerBrandMatchingQuery leftJoinBrand($relationAlias = null) Adds a LEFT JOIN clause to the query using the Brand relation
 * @method     ChildWholesalePartnerBrandMatchingQuery rightJoinBrand($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Brand relation
 * @method     ChildWholesalePartnerBrandMatchingQuery innerJoinBrand($relationAlias = null) Adds a INNER JOIN clause to the query using the Brand relation
 *
 * @method     ChildWholesalePartnerBrandMatching findOne(ConnectionInterface $con = null) Return the first ChildWholesalePartnerBrandMatching matching the query
 * @method     ChildWholesalePartnerBrandMatching findOneOrCreate(ConnectionInterface $con = null) Return the first ChildWholesalePartnerBrandMatching matching the query, or a new ChildWholesalePartnerBrandMatching object populated from the query conditions when no match is found
 *
 * @method     ChildWholesalePartnerBrandMatching findOneById(int $id) Return the first ChildWholesalePartnerBrandMatching filtered by the id column
 * @method     ChildWholesalePartnerBrandMatching findOneByBrandIntern(int $brand_intern) Return the first ChildWholesalePartnerBrandMatching filtered by the brand_intern column
 * @method     ChildWholesalePartnerBrandMatching findOneByBrandExtern(string $brand_extern) Return the first ChildWholesalePartnerBrandMatching filtered by the brand_extern column
 * @method     ChildWholesalePartnerBrandMatching findOneByPartnerId(int $partner_id) Return the first ChildWholesalePartnerBrandMatching filtered by the partner_id column
 * @method     ChildWholesalePartnerBrandMatching findOneByBrandCode(string $brand_code) Return the first ChildWholesalePartnerBrandMatching filtered by the brand_code column
 *
 * @method     array findById(int $id) Return ChildWholesalePartnerBrandMatching objects filtered by the id column
 * @method     array findByBrandIntern(int $brand_intern) Return ChildWholesalePartnerBrandMatching objects filtered by the brand_intern column
 * @method     array findByBrandExtern(string $brand_extern) Return ChildWholesalePartnerBrandMatching objects filtered by the brand_extern column
 * @method     array findByPartnerId(int $partner_id) Return ChildWholesalePartnerBrandMatching objects filtered by the partner_id column
 * @method     array findByBrandCode(string $brand_code) Return ChildWholesalePartnerBrandMatching objects filtered by the brand_code column
 *
 */
abstract class WholesalePartnerBrandMatchingQuery extends ModelCriteria
{
    
    /**
     * Initializes internal state of \RevenueDashboard\Model\Base\WholesalePartnerBrandMatchingQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'thelia', $modelName = '\\RevenueDashboard\\Model\\WholesalePartnerBrandMatching', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildWholesalePartnerBrandMatchingQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildWholesalePartnerBrandMatchingQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \RevenueDashboard\Model\WholesalePartnerBrandMatchingQuery) {
            return $criteria;
        }
        $query = new \RevenueDashboard\Model\WholesalePartnerBrandMatchingQuery();
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
     * @return ChildWholesalePartnerBrandMatching|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = WholesalePartnerBrandMatchingTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(WholesalePartnerBrandMatchingTableMap::DATABASE_NAME);
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
     * @return   ChildWholesalePartnerBrandMatching A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ID, BRAND_INTERN, BRAND_EXTERN, PARTNER_ID, BRAND_CODE FROM wholesale_partner_brand_matching WHERE ID = :p0';
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
            $obj = new ChildWholesalePartnerBrandMatching();
            $obj->hydrate($row);
            WholesalePartnerBrandMatchingTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildWholesalePartnerBrandMatching|array|mixed the result, formatted by the current formatter
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
     * @return ChildWholesalePartnerBrandMatchingQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(WholesalePartnerBrandMatchingTableMap::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildWholesalePartnerBrandMatchingQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(WholesalePartnerBrandMatchingTableMap::ID, $keys, Criteria::IN);
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
     * @return ChildWholesalePartnerBrandMatchingQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(WholesalePartnerBrandMatchingTableMap::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(WholesalePartnerBrandMatchingTableMap::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(WholesalePartnerBrandMatchingTableMap::ID, $id, $comparison);
    }

    /**
     * Filter the query on the brand_intern column
     *
     * Example usage:
     * <code>
     * $query->filterByBrandIntern(1234); // WHERE brand_intern = 1234
     * $query->filterByBrandIntern(array(12, 34)); // WHERE brand_intern IN (12, 34)
     * $query->filterByBrandIntern(array('min' => 12)); // WHERE brand_intern > 12
     * </code>
     *
     * @see       filterByBrand()
     *
     * @param     mixed $brandIntern The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildWholesalePartnerBrandMatchingQuery The current query, for fluid interface
     */
    public function filterByBrandIntern($brandIntern = null, $comparison = null)
    {
        if (is_array($brandIntern)) {
            $useMinMax = false;
            if (isset($brandIntern['min'])) {
                $this->addUsingAlias(WholesalePartnerBrandMatchingTableMap::BRAND_INTERN, $brandIntern['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($brandIntern['max'])) {
                $this->addUsingAlias(WholesalePartnerBrandMatchingTableMap::BRAND_INTERN, $brandIntern['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(WholesalePartnerBrandMatchingTableMap::BRAND_INTERN, $brandIntern, $comparison);
    }

    /**
     * Filter the query on the brand_extern column
     *
     * Example usage:
     * <code>
     * $query->filterByBrandExtern('fooValue');   // WHERE brand_extern = 'fooValue'
     * $query->filterByBrandExtern('%fooValue%'); // WHERE brand_extern LIKE '%fooValue%'
     * </code>
     *
     * @param     string $brandExtern The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildWholesalePartnerBrandMatchingQuery The current query, for fluid interface
     */
    public function filterByBrandExtern($brandExtern = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($brandExtern)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $brandExtern)) {
                $brandExtern = str_replace('*', '%', $brandExtern);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(WholesalePartnerBrandMatchingTableMap::BRAND_EXTERN, $brandExtern, $comparison);
    }

    /**
     * Filter the query on the partner_id column
     *
     * Example usage:
     * <code>
     * $query->filterByPartnerId(1234); // WHERE partner_id = 1234
     * $query->filterByPartnerId(array(12, 34)); // WHERE partner_id IN (12, 34)
     * $query->filterByPartnerId(array('min' => 12)); // WHERE partner_id > 12
     * </code>
     *
     * @param     mixed $partnerId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildWholesalePartnerBrandMatchingQuery The current query, for fluid interface
     */
    public function filterByPartnerId($partnerId = null, $comparison = null)
    {
        if (is_array($partnerId)) {
            $useMinMax = false;
            if (isset($partnerId['min'])) {
                $this->addUsingAlias(WholesalePartnerBrandMatchingTableMap::PARTNER_ID, $partnerId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($partnerId['max'])) {
                $this->addUsingAlias(WholesalePartnerBrandMatchingTableMap::PARTNER_ID, $partnerId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(WholesalePartnerBrandMatchingTableMap::PARTNER_ID, $partnerId, $comparison);
    }

    /**
     * Filter the query on the brand_code column
     *
     * Example usage:
     * <code>
     * $query->filterByBrandCode('fooValue');   // WHERE brand_code = 'fooValue'
     * $query->filterByBrandCode('%fooValue%'); // WHERE brand_code LIKE '%fooValue%'
     * </code>
     *
     * @param     string $brandCode The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildWholesalePartnerBrandMatchingQuery The current query, for fluid interface
     */
    public function filterByBrandCode($brandCode = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($brandCode)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $brandCode)) {
                $brandCode = str_replace('*', '%', $brandCode);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(WholesalePartnerBrandMatchingTableMap::BRAND_CODE, $brandCode, $comparison);
    }

    /**
     * Filter the query by a related \Thelia\Model\Brand object
     *
     * @param \Thelia\Model\Brand|ObjectCollection $brand The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildWholesalePartnerBrandMatchingQuery The current query, for fluid interface
     */
    public function filterByBrand($brand, $comparison = null)
    {
        if ($brand instanceof \Thelia\Model\Brand) {
            return $this
                ->addUsingAlias(WholesalePartnerBrandMatchingTableMap::BRAND_INTERN, $brand->getId(), $comparison);
        } elseif ($brand instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(WholesalePartnerBrandMatchingTableMap::BRAND_INTERN, $brand->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return ChildWholesalePartnerBrandMatchingQuery The current query, for fluid interface
     */
    public function joinBrand($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
    public function useBrandQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinBrand($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Brand', '\Thelia\Model\BrandQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildWholesalePartnerBrandMatching $wholesalePartnerBrandMatching Object to remove from the list of results
     *
     * @return ChildWholesalePartnerBrandMatchingQuery The current query, for fluid interface
     */
    public function prune($wholesalePartnerBrandMatching = null)
    {
        if ($wholesalePartnerBrandMatching) {
            $this->addUsingAlias(WholesalePartnerBrandMatchingTableMap::ID, $wholesalePartnerBrandMatching->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the wholesale_partner_brand_matching table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(WholesalePartnerBrandMatchingTableMap::DATABASE_NAME);
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
            WholesalePartnerBrandMatchingTableMap::clearInstancePool();
            WholesalePartnerBrandMatchingTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildWholesalePartnerBrandMatching or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildWholesalePartnerBrandMatching object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(WholesalePartnerBrandMatchingTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(WholesalePartnerBrandMatchingTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            

        WholesalePartnerBrandMatchingTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            WholesalePartnerBrandMatchingTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

} // WholesalePartnerBrandMatchingQuery
