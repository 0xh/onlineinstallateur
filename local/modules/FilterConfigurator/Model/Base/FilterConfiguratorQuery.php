<?php

namespace FilterConfigurator\Model\Base;

use \Exception;
use \PDO;
use FilterConfigurator\Model\FilterConfigurator as ChildFilterConfigurator;
use FilterConfigurator\Model\FilterConfiguratorQuery as ChildFilterConfiguratorQuery;
use FilterConfigurator\Model\Map\FilterConfiguratorTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;
use Thelia\Model\Category;

/**
 * Base class that represents a query for the 'filterconfigurator_configurator' table.
 *
 * 
 *
 * @method     ChildFilterConfiguratorQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildFilterConfiguratorQuery orderByCategoryId($order = Criteria::ASC) Order by the category_id column
 * @method     ChildFilterConfiguratorQuery orderByVisible($order = Criteria::ASC) Order by the visible column
 * @method     ChildFilterConfiguratorQuery orderByPosition($order = Criteria::ASC) Order by the position column
 * @method     ChildFilterConfiguratorQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildFilterConfiguratorQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method     ChildFilterConfiguratorQuery groupById() Group by the id column
 * @method     ChildFilterConfiguratorQuery groupByCategoryId() Group by the category_id column
 * @method     ChildFilterConfiguratorQuery groupByVisible() Group by the visible column
 * @method     ChildFilterConfiguratorQuery groupByPosition() Group by the position column
 * @method     ChildFilterConfiguratorQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildFilterConfiguratorQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method     ChildFilterConfiguratorQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildFilterConfiguratorQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildFilterConfiguratorQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildFilterConfiguratorQuery leftJoinCategory($relationAlias = null) Adds a LEFT JOIN clause to the query using the Category relation
 * @method     ChildFilterConfiguratorQuery rightJoinCategory($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Category relation
 * @method     ChildFilterConfiguratorQuery innerJoinCategory($relationAlias = null) Adds a INNER JOIN clause to the query using the Category relation
 *
 * @method     ChildFilterConfiguratorQuery leftJoinFilterConfiguratorHook($relationAlias = null) Adds a LEFT JOIN clause to the query using the FilterConfiguratorHook relation
 * @method     ChildFilterConfiguratorQuery rightJoinFilterConfiguratorHook($relationAlias = null) Adds a RIGHT JOIN clause to the query using the FilterConfiguratorHook relation
 * @method     ChildFilterConfiguratorQuery innerJoinFilterConfiguratorHook($relationAlias = null) Adds a INNER JOIN clause to the query using the FilterConfiguratorHook relation
 *
 * @method     ChildFilterConfiguratorQuery leftJoinFilterConfiguratorI18n($relationAlias = null) Adds a LEFT JOIN clause to the query using the FilterConfiguratorI18n relation
 * @method     ChildFilterConfiguratorQuery rightJoinFilterConfiguratorI18n($relationAlias = null) Adds a RIGHT JOIN clause to the query using the FilterConfiguratorI18n relation
 * @method     ChildFilterConfiguratorQuery innerJoinFilterConfiguratorI18n($relationAlias = null) Adds a INNER JOIN clause to the query using the FilterConfiguratorI18n relation
 *
 * @method     ChildFilterConfiguratorQuery leftJoinFilterConfiguratorImage($relationAlias = null) Adds a LEFT JOIN clause to the query using the FilterConfiguratorImage relation
 * @method     ChildFilterConfiguratorQuery rightJoinFilterConfiguratorImage($relationAlias = null) Adds a RIGHT JOIN clause to the query using the FilterConfiguratorImage relation
 * @method     ChildFilterConfiguratorQuery innerJoinFilterConfiguratorImage($relationAlias = null) Adds a INNER JOIN clause to the query using the FilterConfiguratorImage relation
 *
 * @method     ChildFilterConfiguratorQuery leftJoinFilterConfiguratorFeatures($relationAlias = null) Adds a LEFT JOIN clause to the query using the FilterConfiguratorFeatures relation
 * @method     ChildFilterConfiguratorQuery rightJoinFilterConfiguratorFeatures($relationAlias = null) Adds a RIGHT JOIN clause to the query using the FilterConfiguratorFeatures relation
 * @method     ChildFilterConfiguratorQuery innerJoinFilterConfiguratorFeatures($relationAlias = null) Adds a INNER JOIN clause to the query using the FilterConfiguratorFeatures relation
 *
 * @method     ChildFilterConfigurator findOne(ConnectionInterface $con = null) Return the first ChildFilterConfigurator matching the query
 * @method     ChildFilterConfigurator findOneOrCreate(ConnectionInterface $con = null) Return the first ChildFilterConfigurator matching the query, or a new ChildFilterConfigurator object populated from the query conditions when no match is found
 *
 * @method     ChildFilterConfigurator findOneById(int $id) Return the first ChildFilterConfigurator filtered by the id column
 * @method     ChildFilterConfigurator findOneByCategoryId(int $category_id) Return the first ChildFilterConfigurator filtered by the category_id column
 * @method     ChildFilterConfigurator findOneByVisible(int $visible) Return the first ChildFilterConfigurator filtered by the visible column
 * @method     ChildFilterConfigurator findOneByPosition(int $position) Return the first ChildFilterConfigurator filtered by the position column
 * @method     ChildFilterConfigurator findOneByCreatedAt(string $created_at) Return the first ChildFilterConfigurator filtered by the created_at column
 * @method     ChildFilterConfigurator findOneByUpdatedAt(string $updated_at) Return the first ChildFilterConfigurator filtered by the updated_at column
 *
 * @method     array findById(int $id) Return ChildFilterConfigurator objects filtered by the id column
 * @method     array findByCategoryId(int $category_id) Return ChildFilterConfigurator objects filtered by the category_id column
 * @method     array findByVisible(int $visible) Return ChildFilterConfigurator objects filtered by the visible column
 * @method     array findByPosition(int $position) Return ChildFilterConfigurator objects filtered by the position column
 * @method     array findByCreatedAt(string $created_at) Return ChildFilterConfigurator objects filtered by the created_at column
 * @method     array findByUpdatedAt(string $updated_at) Return ChildFilterConfigurator objects filtered by the updated_at column
 *
 */
abstract class FilterConfiguratorQuery extends ModelCriteria
{
    
    /**
     * Initializes internal state of \FilterConfigurator\Model\Base\FilterConfiguratorQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'thelia', $modelName = '\\FilterConfigurator\\Model\\FilterConfigurator', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildFilterConfiguratorQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildFilterConfiguratorQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \FilterConfigurator\Model\FilterConfiguratorQuery) {
            return $criteria;
        }
        $query = new \FilterConfigurator\Model\FilterConfiguratorQuery();
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
     * @return ChildFilterConfigurator|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = FilterConfiguratorTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(FilterConfiguratorTableMap::DATABASE_NAME);
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
     * @return   ChildFilterConfigurator A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ID, CATEGORY_ID, VISIBLE, POSITION, CREATED_AT, UPDATED_AT FROM filterconfigurator_configurator WHERE ID = :p0';
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
            $obj = new ChildFilterConfigurator();
            $obj->hydrate($row);
            FilterConfiguratorTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildFilterConfigurator|array|mixed the result, formatted by the current formatter
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
     * @return ChildFilterConfiguratorQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(FilterConfiguratorTableMap::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildFilterConfiguratorQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(FilterConfiguratorTableMap::ID, $keys, Criteria::IN);
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
     * @return ChildFilterConfiguratorQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(FilterConfiguratorTableMap::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(FilterConfiguratorTableMap::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FilterConfiguratorTableMap::ID, $id, $comparison);
    }

    /**
     * Filter the query on the category_id column
     *
     * Example usage:
     * <code>
     * $query->filterByCategoryId(1234); // WHERE category_id = 1234
     * $query->filterByCategoryId(array(12, 34)); // WHERE category_id IN (12, 34)
     * $query->filterByCategoryId(array('min' => 12)); // WHERE category_id > 12
     * </code>
     *
     * @see       filterByCategory()
     *
     * @param     mixed $categoryId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildFilterConfiguratorQuery The current query, for fluid interface
     */
    public function filterByCategoryId($categoryId = null, $comparison = null)
    {
        if (is_array($categoryId)) {
            $useMinMax = false;
            if (isset($categoryId['min'])) {
                $this->addUsingAlias(FilterConfiguratorTableMap::CATEGORY_ID, $categoryId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($categoryId['max'])) {
                $this->addUsingAlias(FilterConfiguratorTableMap::CATEGORY_ID, $categoryId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FilterConfiguratorTableMap::CATEGORY_ID, $categoryId, $comparison);
    }

    /**
     * Filter the query on the visible column
     *
     * Example usage:
     * <code>
     * $query->filterByVisible(1234); // WHERE visible = 1234
     * $query->filterByVisible(array(12, 34)); // WHERE visible IN (12, 34)
     * $query->filterByVisible(array('min' => 12)); // WHERE visible > 12
     * </code>
     *
     * @param     mixed $visible The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildFilterConfiguratorQuery The current query, for fluid interface
     */
    public function filterByVisible($visible = null, $comparison = null)
    {
        if (is_array($visible)) {
            $useMinMax = false;
            if (isset($visible['min'])) {
                $this->addUsingAlias(FilterConfiguratorTableMap::VISIBLE, $visible['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($visible['max'])) {
                $this->addUsingAlias(FilterConfiguratorTableMap::VISIBLE, $visible['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FilterConfiguratorTableMap::VISIBLE, $visible, $comparison);
    }

    /**
     * Filter the query on the position column
     *
     * Example usage:
     * <code>
     * $query->filterByPosition(1234); // WHERE position = 1234
     * $query->filterByPosition(array(12, 34)); // WHERE position IN (12, 34)
     * $query->filterByPosition(array('min' => 12)); // WHERE position > 12
     * </code>
     *
     * @param     mixed $position The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildFilterConfiguratorQuery The current query, for fluid interface
     */
    public function filterByPosition($position = null, $comparison = null)
    {
        if (is_array($position)) {
            $useMinMax = false;
            if (isset($position['min'])) {
                $this->addUsingAlias(FilterConfiguratorTableMap::POSITION, $position['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($position['max'])) {
                $this->addUsingAlias(FilterConfiguratorTableMap::POSITION, $position['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FilterConfiguratorTableMap::POSITION, $position, $comparison);
    }

    /**
     * Filter the query on the created_at column
     *
     * Example usage:
     * <code>
     * $query->filterByCreatedAt('2011-03-14'); // WHERE created_at = '2011-03-14'
     * $query->filterByCreatedAt('now'); // WHERE created_at = '2011-03-14'
     * $query->filterByCreatedAt(array('max' => 'yesterday')); // WHERE created_at > '2011-03-13'
     * </code>
     *
     * @param     mixed $createdAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildFilterConfiguratorQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(FilterConfiguratorTableMap::CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(FilterConfiguratorTableMap::CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FilterConfiguratorTableMap::CREATED_AT, $createdAt, $comparison);
    }

    /**
     * Filter the query on the updated_at column
     *
     * Example usage:
     * <code>
     * $query->filterByUpdatedAt('2011-03-14'); // WHERE updated_at = '2011-03-14'
     * $query->filterByUpdatedAt('now'); // WHERE updated_at = '2011-03-14'
     * $query->filterByUpdatedAt(array('max' => 'yesterday')); // WHERE updated_at > '2011-03-13'
     * </code>
     *
     * @param     mixed $updatedAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildFilterConfiguratorQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(FilterConfiguratorTableMap::UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(FilterConfiguratorTableMap::UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FilterConfiguratorTableMap::UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Filter the query by a related \Thelia\Model\Category object
     *
     * @param \Thelia\Model\Category|ObjectCollection $category The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildFilterConfiguratorQuery The current query, for fluid interface
     */
    public function filterByCategory($category, $comparison = null)
    {
        if ($category instanceof \Thelia\Model\Category) {
            return $this
                ->addUsingAlias(FilterConfiguratorTableMap::CATEGORY_ID, $category->getId(), $comparison);
        } elseif ($category instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(FilterConfiguratorTableMap::CATEGORY_ID, $category->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return ChildFilterConfiguratorQuery The current query, for fluid interface
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
     * Filter the query by a related \FilterConfigurator\Model\FilterConfiguratorHook object
     *
     * @param \FilterConfigurator\Model\FilterConfiguratorHook|ObjectCollection $filterConfiguratorHook  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildFilterConfiguratorQuery The current query, for fluid interface
     */
    public function filterByFilterConfiguratorHook($filterConfiguratorHook, $comparison = null)
    {
        if ($filterConfiguratorHook instanceof \FilterConfigurator\Model\FilterConfiguratorHook) {
            return $this
                ->addUsingAlias(FilterConfiguratorTableMap::ID, $filterConfiguratorHook->getFilterConfiguratorId(), $comparison);
        } elseif ($filterConfiguratorHook instanceof ObjectCollection) {
            return $this
                ->useFilterConfiguratorHookQuery()
                ->filterByPrimaryKeys($filterConfiguratorHook->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByFilterConfiguratorHook() only accepts arguments of type \FilterConfigurator\Model\FilterConfiguratorHook or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the FilterConfiguratorHook relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildFilterConfiguratorQuery The current query, for fluid interface
     */
    public function joinFilterConfiguratorHook($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('FilterConfiguratorHook');

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
            $this->addJoinObject($join, 'FilterConfiguratorHook');
        }

        return $this;
    }

    /**
     * Use the FilterConfiguratorHook relation FilterConfiguratorHook object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \FilterConfigurator\Model\FilterConfiguratorHookQuery A secondary query class using the current class as primary query
     */
    public function useFilterConfiguratorHookQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinFilterConfiguratorHook($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'FilterConfiguratorHook', '\FilterConfigurator\Model\FilterConfiguratorHookQuery');
    }

    /**
     * Filter the query by a related \FilterConfigurator\Model\FilterConfiguratorI18n object
     *
     * @param \FilterConfigurator\Model\FilterConfiguratorI18n|ObjectCollection $filterConfiguratorI18n  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildFilterConfiguratorQuery The current query, for fluid interface
     */
    public function filterByFilterConfiguratorI18n($filterConfiguratorI18n, $comparison = null)
    {
        if ($filterConfiguratorI18n instanceof \FilterConfigurator\Model\FilterConfiguratorI18n) {
            return $this
                ->addUsingAlias(FilterConfiguratorTableMap::ID, $filterConfiguratorI18n->getId(), $comparison);
        } elseif ($filterConfiguratorI18n instanceof ObjectCollection) {
            return $this
                ->useFilterConfiguratorI18nQuery()
                ->filterByPrimaryKeys($filterConfiguratorI18n->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByFilterConfiguratorI18n() only accepts arguments of type \FilterConfigurator\Model\FilterConfiguratorI18n or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the FilterConfiguratorI18n relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildFilterConfiguratorQuery The current query, for fluid interface
     */
    public function joinFilterConfiguratorI18n($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('FilterConfiguratorI18n');

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
            $this->addJoinObject($join, 'FilterConfiguratorI18n');
        }

        return $this;
    }

    /**
     * Use the FilterConfiguratorI18n relation FilterConfiguratorI18n object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \FilterConfigurator\Model\FilterConfiguratorI18nQuery A secondary query class using the current class as primary query
     */
    public function useFilterConfiguratorI18nQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinFilterConfiguratorI18n($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'FilterConfiguratorI18n', '\FilterConfigurator\Model\FilterConfiguratorI18nQuery');
    }

    /**
     * Filter the query by a related \FilterConfigurator\Model\FilterConfiguratorImage object
     *
     * @param \FilterConfigurator\Model\FilterConfiguratorImage|ObjectCollection $filterConfiguratorImage  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildFilterConfiguratorQuery The current query, for fluid interface
     */
    public function filterByFilterConfiguratorImage($filterConfiguratorImage, $comparison = null)
    {
        if ($filterConfiguratorImage instanceof \FilterConfigurator\Model\FilterConfiguratorImage) {
            return $this
                ->addUsingAlias(FilterConfiguratorTableMap::ID, $filterConfiguratorImage->getConfiguratorId(), $comparison);
        } elseif ($filterConfiguratorImage instanceof ObjectCollection) {
            return $this
                ->useFilterConfiguratorImageQuery()
                ->filterByPrimaryKeys($filterConfiguratorImage->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByFilterConfiguratorImage() only accepts arguments of type \FilterConfigurator\Model\FilterConfiguratorImage or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the FilterConfiguratorImage relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildFilterConfiguratorQuery The current query, for fluid interface
     */
    public function joinFilterConfiguratorImage($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('FilterConfiguratorImage');

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
            $this->addJoinObject($join, 'FilterConfiguratorImage');
        }

        return $this;
    }

    /**
     * Use the FilterConfiguratorImage relation FilterConfiguratorImage object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \FilterConfigurator\Model\FilterConfiguratorImageQuery A secondary query class using the current class as primary query
     */
    public function useFilterConfiguratorImageQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinFilterConfiguratorImage($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'FilterConfiguratorImage', '\FilterConfigurator\Model\FilterConfiguratorImageQuery');
    }

    /**
     * Filter the query by a related \FilterConfigurator\Model\FilterConfiguratorFeatures object
     *
     * @param \FilterConfigurator\Model\FilterConfiguratorFeatures|ObjectCollection $filterConfiguratorFeatures  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildFilterConfiguratorQuery The current query, for fluid interface
     */
    public function filterByFilterConfiguratorFeatures($filterConfiguratorFeatures, $comparison = null)
    {
        if ($filterConfiguratorFeatures instanceof \FilterConfigurator\Model\FilterConfiguratorFeatures) {
            return $this
                ->addUsingAlias(FilterConfiguratorTableMap::ID, $filterConfiguratorFeatures->getConfiguratorId(), $comparison);
        } elseif ($filterConfiguratorFeatures instanceof ObjectCollection) {
            return $this
                ->useFilterConfiguratorFeaturesQuery()
                ->filterByPrimaryKeys($filterConfiguratorFeatures->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByFilterConfiguratorFeatures() only accepts arguments of type \FilterConfigurator\Model\FilterConfiguratorFeatures or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the FilterConfiguratorFeatures relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildFilterConfiguratorQuery The current query, for fluid interface
     */
    public function joinFilterConfiguratorFeatures($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('FilterConfiguratorFeatures');

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
            $this->addJoinObject($join, 'FilterConfiguratorFeatures');
        }

        return $this;
    }

    /**
     * Use the FilterConfiguratorFeatures relation FilterConfiguratorFeatures object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \FilterConfigurator\Model\FilterConfiguratorFeaturesQuery A secondary query class using the current class as primary query
     */
    public function useFilterConfiguratorFeaturesQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinFilterConfiguratorFeatures($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'FilterConfiguratorFeatures', '\FilterConfigurator\Model\FilterConfiguratorFeaturesQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildFilterConfigurator $filterConfigurator Object to remove from the list of results
     *
     * @return ChildFilterConfiguratorQuery The current query, for fluid interface
     */
    public function prune($filterConfigurator = null)
    {
        if ($filterConfigurator) {
            $this->addUsingAlias(FilterConfiguratorTableMap::ID, $filterConfigurator->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the filterconfigurator_configurator table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(FilterConfiguratorTableMap::DATABASE_NAME);
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
            FilterConfiguratorTableMap::clearInstancePool();
            FilterConfiguratorTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildFilterConfigurator or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildFilterConfigurator object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(FilterConfiguratorTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(FilterConfiguratorTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            

        FilterConfiguratorTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            FilterConfiguratorTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

    // timestampable behavior
    
    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     ChildFilterConfiguratorQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(FilterConfiguratorTableMap::UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }
    
    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     ChildFilterConfiguratorQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(FilterConfiguratorTableMap::CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }
    
    /**
     * Order by update date desc
     *
     * @return     ChildFilterConfiguratorQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(FilterConfiguratorTableMap::UPDATED_AT);
    }
    
    /**
     * Order by update date asc
     *
     * @return     ChildFilterConfiguratorQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(FilterConfiguratorTableMap::UPDATED_AT);
    }
    
    /**
     * Order by create date desc
     *
     * @return     ChildFilterConfiguratorQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(FilterConfiguratorTableMap::CREATED_AT);
    }
    
    /**
     * Order by create date asc
     *
     * @return     ChildFilterConfiguratorQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(FilterConfiguratorTableMap::CREATED_AT);
    }

} // FilterConfiguratorQuery
