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
use RevenueDashboard\Model\WholesalePartnerCategoryMatching as ChildWholesalePartnerCategoryMatching;
use RevenueDashboard\Model\WholesalePartnerCategoryMatchingQuery as ChildWholesalePartnerCategoryMatchingQuery;
use RevenueDashboard\Model\Map\WholesalePartnerCategoryMatchingTableMap;
use Thelia\Model\Category;

/**
 * Base class that represents a query for the 'wholesale_partner_category_matching' table.
 *
 *
 *
 * @method     ChildWholesalePartnerCategoryMatchingQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildWholesalePartnerCategoryMatchingQuery orderByCategoryInternId($order = Criteria::ASC) Order by the category_intern_id column
 * @method     ChildWholesalePartnerCategoryMatchingQuery orderByCategoryInternName($order = Criteria::ASC) Order by the category_intern_name column
 * @method     ChildWholesalePartnerCategoryMatchingQuery orderByCategoryExternId($order = Criteria::ASC) Order by the category_extern_id column
 * @method     ChildWholesalePartnerCategoryMatchingQuery orderByCategoryExternName($order = Criteria::ASC) Order by the category_extern_name column
 * @method     ChildWholesalePartnerCategoryMatchingQuery orderByPartnerId($order = Criteria::ASC) Order by the partner_id column
 * @method     ChildWholesalePartnerCategoryMatchingQuery orderByCategoryCode($order = Criteria::ASC) Order by the category_id column
 *
 * @method     ChildWholesalePartnerCategoryMatchingQuery groupById() Group by the id column
 * @method     ChildWholesalePartnerCategoryMatchingQuery groupByCategoryInternId() Group by the category_intern_id column
 * @method     ChildWholesalePartnerCategoryMatchingQuery groupByCategoryInternName() Group by the category_intern_name column
 * @method     ChildWholesalePartnerCategoryMatchingQuery groupByCategoryExternId() Group by the category_extern_id column
 * @method     ChildWholesalePartnerCategoryMatchingQuery groupByCategoryExternName() Group by the category_extern_name column
 * @method     ChildWholesalePartnerCategoryMatchingQuery groupByPartnerId() Group by the partner_id column
 * @method     ChildWholesalePartnerCategoryMatchingQuery groupByCategoryCode() Group by the category_id column
 *
 * @method     ChildWholesalePartnerCategoryMatchingQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildWholesalePartnerCategoryMatchingQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildWholesalePartnerCategoryMatchingQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildWholesalePartnerCategoryMatchingQuery leftJoinCategory($relationAlias = null) Adds a LEFT JOIN clause to the query using the Category relation
 * @method     ChildWholesalePartnerCategoryMatchingQuery rightJoinCategory($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Category relation
 * @method     ChildWholesalePartnerCategoryMatchingQuery innerJoinCategory($relationAlias = null) Adds a INNER JOIN clause to the query using the Category relation
 *
 * @method     ChildWholesalePartnerCategoryMatching findOne(ConnectionInterface $con = null) Return the first ChildWholesalePartnerCategoryMatching matching the query
 * @method     ChildWholesalePartnerCategoryMatching findOneOrCreate(ConnectionInterface $con = null) Return the first ChildWholesalePartnerCategoryMatching matching the query, or a new ChildWholesalePartnerCategoryMatching object populated from the query conditions when no match is found
 *
 * @method     ChildWholesalePartnerCategoryMatching findOneById(int $id) Return the first ChildWholesalePartnerCategoryMatching filtered by the id column
 * @method     ChildWholesalePartnerCategoryMatching findOneByCategoryInternId(int $category_intern_id) Return the first ChildWholesalePartnerCategoryMatching filtered by the category_intern_id column
 * @method     ChildWholesalePartnerCategoryMatching findOneByCategoryInternName(string $category_intern_name) Return the first ChildWholesalePartnerCategoryMatching filtered by the category_intern_name column
 * @method     ChildWholesalePartnerCategoryMatching findOneByCategoryExternId(string $category_extern_id) Return the first ChildWholesalePartnerCategoryMatching filtered by the category_extern_id column
 * @method     ChildWholesalePartnerCategoryMatching findOneByCategoryExternName(string $category_extern_name) Return the first ChildWholesalePartnerCategoryMatching filtered by the category_extern_name column
 * @method     ChildWholesalePartnerCategoryMatching findOneByPartnerId(int $partner_id) Return the first ChildWholesalePartnerCategoryMatching filtered by the partner_id column
 * @method     ChildWholesalePartnerCategoryMatching findOneByCategoryCode(string $category_id) Return the first ChildWholesalePartnerCategoryMatching filtered by the category_id column
 *
 * @method     array findById(int $id) Return ChildWholesalePartnerCategoryMatching objects filtered by the id column
 * @method     array findByCategoryInternId(int $category_intern_id) Return ChildWholesalePartnerCategoryMatching objects filtered by the category_intern_id column
 * @method     array findByCategoryInternName(string $category_intern_name) Return ChildWholesalePartnerCategoryMatching objects filtered by the category_intern_name column
 * @method     array findByCategoryExternId(string $category_extern_id) Return ChildWholesalePartnerCategoryMatching objects filtered by the category_extern_id column
 * @method     array findByCategoryExternName(string $category_extern_name) Return ChildWholesalePartnerCategoryMatching objects filtered by the category_extern_name column
 * @method     array findByPartnerId(int $partner_id) Return ChildWholesalePartnerCategoryMatching objects filtered by the partner_id column
 * @method     array findByCategoryCode(string $category_id) Return ChildWholesalePartnerCategoryMatching objects filtered by the category_id column
 *
 */
abstract class WholesalePartnerCategoryMatchingQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \RevenueDashboard\Model\Base\WholesalePartnerCategoryMatchingQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'thelia', $modelName = '\\RevenueDashboard\\Model\\WholesalePartnerCategoryMatching', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildWholesalePartnerCategoryMatchingQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildWholesalePartnerCategoryMatchingQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \RevenueDashboard\Model\WholesalePartnerCategoryMatchingQuery) {
            return $criteria;
        }
        $query = new \RevenueDashboard\Model\WholesalePartnerCategoryMatchingQuery();
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
     * @return ChildWholesalePartnerCategoryMatching|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = WholesalePartnerCategoryMatchingTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(WholesalePartnerCategoryMatchingTableMap::DATABASE_NAME);
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
     * @return   ChildWholesalePartnerCategoryMatching A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ID, CATEGORY_INTERN_ID, CATEGORY_INTERN_NAME, CATEGORY_EXTERN_ID, CATEGORY_EXTERN_NAME, PARTNER_ID, CATEGORY_ID FROM wholesale_partner_category_matching WHERE ID = :p0';
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
            $obj = new ChildWholesalePartnerCategoryMatching();
            $obj->hydrate($row);
            WholesalePartnerCategoryMatchingTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildWholesalePartnerCategoryMatching|array|mixed the result, formatted by the current formatter
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
     * @return ChildWholesalePartnerCategoryMatchingQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(WholesalePartnerCategoryMatchingTableMap::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildWholesalePartnerCategoryMatchingQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(WholesalePartnerCategoryMatchingTableMap::ID, $keys, Criteria::IN);
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
     * @return ChildWholesalePartnerCategoryMatchingQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(WholesalePartnerCategoryMatchingTableMap::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(WholesalePartnerCategoryMatchingTableMap::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(WholesalePartnerCategoryMatchingTableMap::ID, $id, $comparison);
    }

    /**
     * Filter the query on the category_intern_id column
     *
     * Example usage:
     * <code>
     * $query->filterByCategoryInternId(1234); // WHERE category_intern_id = 1234
     * $query->filterByCategoryInternId(array(12, 34)); // WHERE category_intern_id IN (12, 34)
     * $query->filterByCategoryInternId(array('min' => 12)); // WHERE category_intern_id > 12
     * </code>
     *
     * @see       filterByCategory()
     *
     * @param     mixed $categoryInternId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildWholesalePartnerCategoryMatchingQuery The current query, for fluid interface
     */
    public function filterByCategoryInternId($categoryInternId = null, $comparison = null)
    {
        if (is_array($categoryInternId)) {
            $useMinMax = false;
            if (isset($categoryInternId['min'])) {
                $this->addUsingAlias(WholesalePartnerCategoryMatchingTableMap::CATEGORY_INTERN_ID, $categoryInternId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($categoryInternId['max'])) {
                $this->addUsingAlias(WholesalePartnerCategoryMatchingTableMap::CATEGORY_INTERN_ID, $categoryInternId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(WholesalePartnerCategoryMatchingTableMap::CATEGORY_INTERN_ID, $categoryInternId, $comparison);
    }

    /**
     * Filter the query on the category_intern_name column
     *
     * Example usage:
     * <code>
     * $query->filterByCategoryInternName('fooValue');   // WHERE category_intern_name = 'fooValue'
     * $query->filterByCategoryInternName('%fooValue%'); // WHERE category_intern_name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $categoryInternName The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildWholesalePartnerCategoryMatchingQuery The current query, for fluid interface
     */
    public function filterByCategoryInternName($categoryInternName = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($categoryInternName)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $categoryInternName)) {
                $categoryInternName = str_replace('*', '%', $categoryInternName);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(WholesalePartnerCategoryMatchingTableMap::CATEGORY_INTERN_NAME, $categoryInternName, $comparison);
    }

    /**
     * Filter the query on the category_extern_id column
     *
     * Example usage:
     * <code>
     * $query->filterByCategoryExternId('fooValue');   // WHERE category_extern_id = 'fooValue'
     * $query->filterByCategoryExternId('%fooValue%'); // WHERE category_extern_id LIKE '%fooValue%'
     * </code>
     *
     * @param     string $categoryExternId The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildWholesalePartnerCategoryMatchingQuery The current query, for fluid interface
     */
    public function filterByCategoryExternId($categoryExternId = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($categoryExternId)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $categoryExternId)) {
                $categoryExternId = str_replace('*', '%', $categoryExternId);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(WholesalePartnerCategoryMatchingTableMap::CATEGORY_EXTERN_ID, $categoryExternId, $comparison);
    }

    /**
     * Filter the query on the category_extern_name column
     *
     * Example usage:
     * <code>
     * $query->filterByCategoryExternName('fooValue');   // WHERE category_extern_name = 'fooValue'
     * $query->filterByCategoryExternName('%fooValue%'); // WHERE category_extern_name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $categoryExternName The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildWholesalePartnerCategoryMatchingQuery The current query, for fluid interface
     */
    public function filterByCategoryExternName($categoryExternName = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($categoryExternName)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $categoryExternName)) {
                $categoryExternName = str_replace('*', '%', $categoryExternName);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(WholesalePartnerCategoryMatchingTableMap::CATEGORY_EXTERN_NAME, $categoryExternName, $comparison);
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
     * @return ChildWholesalePartnerCategoryMatchingQuery The current query, for fluid interface
     */
    public function filterByPartnerId($partnerId = null, $comparison = null)
    {
        if (is_array($partnerId)) {
            $useMinMax = false;
            if (isset($partnerId['min'])) {
                $this->addUsingAlias(WholesalePartnerCategoryMatchingTableMap::PARTNER_ID, $partnerId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($partnerId['max'])) {
                $this->addUsingAlias(WholesalePartnerCategoryMatchingTableMap::PARTNER_ID, $partnerId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(WholesalePartnerCategoryMatchingTableMap::PARTNER_ID, $partnerId, $comparison);
    }

    /**
     * Filter the query on the category_id column
     *
     * Example usage:
     * <code>
     * $query->filterByCategoryCode('fooValue');   // WHERE category_id = 'fooValue'
     * $query->filterByCategoryCode('%fooValue%'); // WHERE category_id LIKE '%fooValue%'
     * </code>
     *
     * @param     string $categoryCode The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildWholesalePartnerCategoryMatchingQuery The current query, for fluid interface
     */
    public function filterByCategoryCode($categoryCode = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($categoryCode)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $categoryCode)) {
                $categoryCode = str_replace('*', '%', $categoryCode);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(WholesalePartnerCategoryMatchingTableMap::CATEGORY_ID, $categoryCode, $comparison);
    }

    /**
     * Filter the query by a related \Thelia\Model\Category object
     *
     * @param \Thelia\Model\Category|ObjectCollection $category The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildWholesalePartnerCategoryMatchingQuery The current query, for fluid interface
     */
    public function filterByCategory($category, $comparison = null)
    {
        if ($category instanceof \Thelia\Model\Category) {
            return $this
                ->addUsingAlias(WholesalePartnerCategoryMatchingTableMap::CATEGORY_INTERN_ID, $category->getId(), $comparison);
        } elseif ($category instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(WholesalePartnerCategoryMatchingTableMap::CATEGORY_INTERN_ID, $category->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByCategory() only accepts arguments of type \Thelia\Model\Category or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Category relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildWholesalePartnerCategoryMatchingQuery The current query, for fluid interface
     */
    public function joinCategory($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Category');

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
            $this->addJoinObject($join, 'Category');
        }

        return $this;
    }

    /**
     * Use the Category relation Category object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Thelia\Model\CategoryQuery A secondary query class using the current class as primary query
     */
    public function useCategoryQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinCategory($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Category', '\Thelia\Model\CategoryQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildWholesalePartnerCategoryMatching $wholesalePartnerCategoryMatching Object to remove from the list of results
     *
     * @return ChildWholesalePartnerCategoryMatchingQuery The current query, for fluid interface
     */
    public function prune($wholesalePartnerCategoryMatching = null)
    {
        if ($wholesalePartnerCategoryMatching) {
            $this->addUsingAlias(WholesalePartnerCategoryMatchingTableMap::ID, $wholesalePartnerCategoryMatching->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the wholesale_partner_category_matching table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(WholesalePartnerCategoryMatchingTableMap::DATABASE_NAME);
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
            WholesalePartnerCategoryMatchingTableMap::clearInstancePool();
            WholesalePartnerCategoryMatchingTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildWholesalePartnerCategoryMatching or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildWholesalePartnerCategoryMatching object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(WholesalePartnerCategoryMatchingTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(WholesalePartnerCategoryMatchingTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();


        WholesalePartnerCategoryMatchingTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            WholesalePartnerCategoryMatchingTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

} // WholesalePartnerCategoryMatchingQuery
