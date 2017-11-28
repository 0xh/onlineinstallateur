<?php

namespace FilterConfigurator\Model\Base;

use \Exception;
use \PDO;
use FilterConfigurator\Model\Configurator as ChildConfigurator;
use FilterConfigurator\Model\ConfiguratorQuery as ChildConfiguratorQuery;
use FilterConfigurator\Model\Map\ConfiguratorTableMap;
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
 * Base class that represents a query for the 'configurator' table.
 *
 * 
 *
 * @method     ChildConfiguratorQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildConfiguratorQuery orderByCategoryId($order = Criteria::ASC) Order by the category_id column
 * @method     ChildConfiguratorQuery orderByVisible($order = Criteria::ASC) Order by the visible column
 * @method     ChildConfiguratorQuery orderByPosition($order = Criteria::ASC) Order by the position column
 * @method     ChildConfiguratorQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildConfiguratorQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method     ChildConfiguratorQuery groupById() Group by the id column
 * @method     ChildConfiguratorQuery groupByCategoryId() Group by the category_id column
 * @method     ChildConfiguratorQuery groupByVisible() Group by the visible column
 * @method     ChildConfiguratorQuery groupByPosition() Group by the position column
 * @method     ChildConfiguratorQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildConfiguratorQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method     ChildConfiguratorQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildConfiguratorQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildConfiguratorQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildConfiguratorQuery leftJoinCategory($relationAlias = null) Adds a LEFT JOIN clause to the query using the Category relation
 * @method     ChildConfiguratorQuery rightJoinCategory($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Category relation
 * @method     ChildConfiguratorQuery innerJoinCategory($relationAlias = null) Adds a INNER JOIN clause to the query using the Category relation
 *
 * @method     ChildConfiguratorQuery leftJoinConfiguratorI18n($relationAlias = null) Adds a LEFT JOIN clause to the query using the ConfiguratorI18n relation
 * @method     ChildConfiguratorQuery rightJoinConfiguratorI18n($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ConfiguratorI18n relation
 * @method     ChildConfiguratorQuery innerJoinConfiguratorI18n($relationAlias = null) Adds a INNER JOIN clause to the query using the ConfiguratorI18n relation
 *
 * @method     ChildConfiguratorQuery leftJoinConfiguratorImage($relationAlias = null) Adds a LEFT JOIN clause to the query using the ConfiguratorImage relation
 * @method     ChildConfiguratorQuery rightJoinConfiguratorImage($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ConfiguratorImage relation
 * @method     ChildConfiguratorQuery innerJoinConfiguratorImage($relationAlias = null) Adds a INNER JOIN clause to the query using the ConfiguratorImage relation
 *
 * @method     ChildConfiguratorQuery leftJoinConfiguratorFeatures($relationAlias = null) Adds a LEFT JOIN clause to the query using the ConfiguratorFeatures relation
 * @method     ChildConfiguratorQuery rightJoinConfiguratorFeatures($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ConfiguratorFeatures relation
 * @method     ChildConfiguratorQuery innerJoinConfiguratorFeatures($relationAlias = null) Adds a INNER JOIN clause to the query using the ConfiguratorFeatures relation
 *
 * @method     ChildConfigurator findOne(ConnectionInterface $con = null) Return the first ChildConfigurator matching the query
 * @method     ChildConfigurator findOneOrCreate(ConnectionInterface $con = null) Return the first ChildConfigurator matching the query, or a new ChildConfigurator object populated from the query conditions when no match is found
 *
 * @method     ChildConfigurator findOneById(int $id) Return the first ChildConfigurator filtered by the id column
 * @method     ChildConfigurator findOneByCategoryId(int $category_id) Return the first ChildConfigurator filtered by the category_id column
 * @method     ChildConfigurator findOneByVisible(int $visible) Return the first ChildConfigurator filtered by the visible column
 * @method     ChildConfigurator findOneByPosition(int $position) Return the first ChildConfigurator filtered by the position column
 * @method     ChildConfigurator findOneByCreatedAt(string $created_at) Return the first ChildConfigurator filtered by the created_at column
 * @method     ChildConfigurator findOneByUpdatedAt(string $updated_at) Return the first ChildConfigurator filtered by the updated_at column
 *
 * @method     array findById(int $id) Return ChildConfigurator objects filtered by the id column
 * @method     array findByCategoryId(int $category_id) Return ChildConfigurator objects filtered by the category_id column
 * @method     array findByVisible(int $visible) Return ChildConfigurator objects filtered by the visible column
 * @method     array findByPosition(int $position) Return ChildConfigurator objects filtered by the position column
 * @method     array findByCreatedAt(string $created_at) Return ChildConfigurator objects filtered by the created_at column
 * @method     array findByUpdatedAt(string $updated_at) Return ChildConfigurator objects filtered by the updated_at column
 *
 */
abstract class ConfiguratorQuery extends ModelCriteria
{
    
    /**
     * Initializes internal state of \FilterConfigurator\Model\Base\ConfiguratorQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'thelia', $modelName = '\\FilterConfigurator\\Model\\Configurator', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildConfiguratorQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildConfiguratorQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \FilterConfigurator\Model\ConfiguratorQuery) {
            return $criteria;
        }
        $query = new \FilterConfigurator\Model\ConfiguratorQuery();
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
     * @return ChildConfigurator|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ConfiguratorTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ConfiguratorTableMap::DATABASE_NAME);
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
     * @return   ChildConfigurator A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ID, CATEGORY_ID, VISIBLE, POSITION, CREATED_AT, UPDATED_AT FROM configurator WHERE ID = :p0';
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
            $obj = new ChildConfigurator();
            $obj->hydrate($row);
            ConfiguratorTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildConfigurator|array|mixed the result, formatted by the current formatter
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
     * @return ChildConfiguratorQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ConfiguratorTableMap::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildConfiguratorQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ConfiguratorTableMap::ID, $keys, Criteria::IN);
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
     * @return ChildConfiguratorQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(ConfiguratorTableMap::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(ConfiguratorTableMap::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ConfiguratorTableMap::ID, $id, $comparison);
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
     * @return ChildConfiguratorQuery The current query, for fluid interface
     */
    public function filterByCategoryId($categoryId = null, $comparison = null)
    {
        if (is_array($categoryId)) {
            $useMinMax = false;
            if (isset($categoryId['min'])) {
                $this->addUsingAlias(ConfiguratorTableMap::CATEGORY_ID, $categoryId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($categoryId['max'])) {
                $this->addUsingAlias(ConfiguratorTableMap::CATEGORY_ID, $categoryId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ConfiguratorTableMap::CATEGORY_ID, $categoryId, $comparison);
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
     * @return ChildConfiguratorQuery The current query, for fluid interface
     */
    public function filterByVisible($visible = null, $comparison = null)
    {
        if (is_array($visible)) {
            $useMinMax = false;
            if (isset($visible['min'])) {
                $this->addUsingAlias(ConfiguratorTableMap::VISIBLE, $visible['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($visible['max'])) {
                $this->addUsingAlias(ConfiguratorTableMap::VISIBLE, $visible['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ConfiguratorTableMap::VISIBLE, $visible, $comparison);
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
     * @return ChildConfiguratorQuery The current query, for fluid interface
     */
    public function filterByPosition($position = null, $comparison = null)
    {
        if (is_array($position)) {
            $useMinMax = false;
            if (isset($position['min'])) {
                $this->addUsingAlias(ConfiguratorTableMap::POSITION, $position['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($position['max'])) {
                $this->addUsingAlias(ConfiguratorTableMap::POSITION, $position['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ConfiguratorTableMap::POSITION, $position, $comparison);
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
     * @return ChildConfiguratorQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(ConfiguratorTableMap::CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(ConfiguratorTableMap::CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ConfiguratorTableMap::CREATED_AT, $createdAt, $comparison);
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
     * @return ChildConfiguratorQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(ConfiguratorTableMap::UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(ConfiguratorTableMap::UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ConfiguratorTableMap::UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Filter the query by a related \Thelia\Model\Category object
     *
     * @param \Thelia\Model\Category|ObjectCollection $category The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildConfiguratorQuery The current query, for fluid interface
     */
    public function filterByCategory($category, $comparison = null)
    {
        if ($category instanceof \Thelia\Model\Category) {
            return $this
                ->addUsingAlias(ConfiguratorTableMap::CATEGORY_ID, $category->getId(), $comparison);
        } elseif ($category instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ConfiguratorTableMap::CATEGORY_ID, $category->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return ChildConfiguratorQuery The current query, for fluid interface
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
     * Filter the query by a related \FilterConfigurator\Model\ConfiguratorI18n object
     *
     * @param \FilterConfigurator\Model\ConfiguratorI18n|ObjectCollection $configuratorI18n  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildConfiguratorQuery The current query, for fluid interface
     */
    public function filterByConfiguratorI18n($configuratorI18n, $comparison = null)
    {
        if ($configuratorI18n instanceof \FilterConfigurator\Model\ConfiguratorI18n) {
            return $this
                ->addUsingAlias(ConfiguratorTableMap::ID, $configuratorI18n->getId(), $comparison);
        } elseif ($configuratorI18n instanceof ObjectCollection) {
            return $this
                ->useConfiguratorI18nQuery()
                ->filterByPrimaryKeys($configuratorI18n->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByConfiguratorI18n() only accepts arguments of type \FilterConfigurator\Model\ConfiguratorI18n or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ConfiguratorI18n relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildConfiguratorQuery The current query, for fluid interface
     */
    public function joinConfiguratorI18n($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ConfiguratorI18n');

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
            $this->addJoinObject($join, 'ConfiguratorI18n');
        }

        return $this;
    }

    /**
     * Use the ConfiguratorI18n relation ConfiguratorI18n object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \FilterConfigurator\Model\ConfiguratorI18nQuery A secondary query class using the current class as primary query
     */
    public function useConfiguratorI18nQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinConfiguratorI18n($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ConfiguratorI18n', '\FilterConfigurator\Model\ConfiguratorI18nQuery');
    }

    /**
     * Filter the query by a related \FilterConfigurator\Model\ConfiguratorImage object
     *
     * @param \FilterConfigurator\Model\ConfiguratorImage|ObjectCollection $configuratorImage  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildConfiguratorQuery The current query, for fluid interface
     */
    public function filterByConfiguratorImage($configuratorImage, $comparison = null)
    {
        if ($configuratorImage instanceof \FilterConfigurator\Model\ConfiguratorImage) {
            return $this
                ->addUsingAlias(ConfiguratorTableMap::ID, $configuratorImage->getConfiguratorId(), $comparison);
        } elseif ($configuratorImage instanceof ObjectCollection) {
            return $this
                ->useConfiguratorImageQuery()
                ->filterByPrimaryKeys($configuratorImage->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByConfiguratorImage() only accepts arguments of type \FilterConfigurator\Model\ConfiguratorImage or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ConfiguratorImage relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildConfiguratorQuery The current query, for fluid interface
     */
    public function joinConfiguratorImage($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ConfiguratorImage');

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
            $this->addJoinObject($join, 'ConfiguratorImage');
        }

        return $this;
    }

    /**
     * Use the ConfiguratorImage relation ConfiguratorImage object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \FilterConfigurator\Model\ConfiguratorImageQuery A secondary query class using the current class as primary query
     */
    public function useConfiguratorImageQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinConfiguratorImage($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ConfiguratorImage', '\FilterConfigurator\Model\ConfiguratorImageQuery');
    }

    /**
     * Filter the query by a related \FilterConfigurator\Model\ConfiguratorFeatures object
     *
     * @param \FilterConfigurator\Model\ConfiguratorFeatures|ObjectCollection $configuratorFeatures  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildConfiguratorQuery The current query, for fluid interface
     */
    public function filterByConfiguratorFeatures($configuratorFeatures, $comparison = null)
    {
        if ($configuratorFeatures instanceof \FilterConfigurator\Model\ConfiguratorFeatures) {
            return $this
                ->addUsingAlias(ConfiguratorTableMap::ID, $configuratorFeatures->getConfiguratorId(), $comparison);
        } elseif ($configuratorFeatures instanceof ObjectCollection) {
            return $this
                ->useConfiguratorFeaturesQuery()
                ->filterByPrimaryKeys($configuratorFeatures->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByConfiguratorFeatures() only accepts arguments of type \FilterConfigurator\Model\ConfiguratorFeatures or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ConfiguratorFeatures relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildConfiguratorQuery The current query, for fluid interface
     */
    public function joinConfiguratorFeatures($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ConfiguratorFeatures');

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
            $this->addJoinObject($join, 'ConfiguratorFeatures');
        }

        return $this;
    }

    /**
     * Use the ConfiguratorFeatures relation ConfiguratorFeatures object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \FilterConfigurator\Model\ConfiguratorFeaturesQuery A secondary query class using the current class as primary query
     */
    public function useConfiguratorFeaturesQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinConfiguratorFeatures($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ConfiguratorFeatures', '\FilterConfigurator\Model\ConfiguratorFeaturesQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildConfigurator $configurator Object to remove from the list of results
     *
     * @return ChildConfiguratorQuery The current query, for fluid interface
     */
    public function prune($configurator = null)
    {
        if ($configurator) {
            $this->addUsingAlias(ConfiguratorTableMap::ID, $configurator->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the configurator table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ConfiguratorTableMap::DATABASE_NAME);
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
            ConfiguratorTableMap::clearInstancePool();
            ConfiguratorTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildConfigurator or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildConfigurator object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(ConfiguratorTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ConfiguratorTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            

        ConfiguratorTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            ConfiguratorTableMap::clearRelatedInstancePool();
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
     * @return     ChildConfiguratorQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(ConfiguratorTableMap::UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }
    
    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     ChildConfiguratorQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(ConfiguratorTableMap::CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }
    
    /**
     * Order by update date desc
     *
     * @return     ChildConfiguratorQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(ConfiguratorTableMap::UPDATED_AT);
    }
    
    /**
     * Order by update date asc
     *
     * @return     ChildConfiguratorQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(ConfiguratorTableMap::UPDATED_AT);
    }
    
    /**
     * Order by create date desc
     *
     * @return     ChildConfiguratorQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(ConfiguratorTableMap::CREATED_AT);
    }
    
    /**
     * Order by create date asc
     *
     * @return     ChildConfiguratorQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(ConfiguratorTableMap::CREATED_AT);
    }

} // ConfiguratorQuery
