<?php

namespace FilterConfigurator\Model\Base;

use \Exception;
use \PDO;
use FilterConfigurator\Model\FilterConfiguratorImage as ChildFilterConfiguratorImage;
use FilterConfigurator\Model\FilterConfiguratorImageQuery as ChildFilterConfiguratorImageQuery;
use FilterConfigurator\Model\Map\FilterConfiguratorImageTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'filterconfigurator_configurator_image' table.
 *
 * 
 *
 * @method     ChildFilterConfiguratorImageQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildFilterConfiguratorImageQuery orderByConfiguratorId($order = Criteria::ASC) Order by the configurator_id column
 * @method     ChildFilterConfiguratorImageQuery orderByFile($order = Criteria::ASC) Order by the file column
 * @method     ChildFilterConfiguratorImageQuery orderByVisible($order = Criteria::ASC) Order by the visible column
 * @method     ChildFilterConfiguratorImageQuery orderByPosition($order = Criteria::ASC) Order by the position column
 * @method     ChildFilterConfiguratorImageQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildFilterConfiguratorImageQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method     ChildFilterConfiguratorImageQuery groupById() Group by the id column
 * @method     ChildFilterConfiguratorImageQuery groupByConfiguratorId() Group by the configurator_id column
 * @method     ChildFilterConfiguratorImageQuery groupByFile() Group by the file column
 * @method     ChildFilterConfiguratorImageQuery groupByVisible() Group by the visible column
 * @method     ChildFilterConfiguratorImageQuery groupByPosition() Group by the position column
 * @method     ChildFilterConfiguratorImageQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildFilterConfiguratorImageQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method     ChildFilterConfiguratorImageQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildFilterConfiguratorImageQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildFilterConfiguratorImageQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildFilterConfiguratorImageQuery leftJoinFilterConfigurator($relationAlias = null) Adds a LEFT JOIN clause to the query using the FilterConfigurator relation
 * @method     ChildFilterConfiguratorImageQuery rightJoinFilterConfigurator($relationAlias = null) Adds a RIGHT JOIN clause to the query using the FilterConfigurator relation
 * @method     ChildFilterConfiguratorImageQuery innerJoinFilterConfigurator($relationAlias = null) Adds a INNER JOIN clause to the query using the FilterConfigurator relation
 *
 * @method     ChildFilterConfiguratorImageQuery leftJoinFilterConfiguratorImageI18n($relationAlias = null) Adds a LEFT JOIN clause to the query using the FilterConfiguratorImageI18n relation
 * @method     ChildFilterConfiguratorImageQuery rightJoinFilterConfiguratorImageI18n($relationAlias = null) Adds a RIGHT JOIN clause to the query using the FilterConfiguratorImageI18n relation
 * @method     ChildFilterConfiguratorImageQuery innerJoinFilterConfiguratorImageI18n($relationAlias = null) Adds a INNER JOIN clause to the query using the FilterConfiguratorImageI18n relation
 *
 * @method     ChildFilterConfiguratorImage findOne(ConnectionInterface $con = null) Return the first ChildFilterConfiguratorImage matching the query
 * @method     ChildFilterConfiguratorImage findOneOrCreate(ConnectionInterface $con = null) Return the first ChildFilterConfiguratorImage matching the query, or a new ChildFilterConfiguratorImage object populated from the query conditions when no match is found
 *
 * @method     ChildFilterConfiguratorImage findOneById(int $id) Return the first ChildFilterConfiguratorImage filtered by the id column
 * @method     ChildFilterConfiguratorImage findOneByConfiguratorId(int $configurator_id) Return the first ChildFilterConfiguratorImage filtered by the configurator_id column
 * @method     ChildFilterConfiguratorImage findOneByFile(string $file) Return the first ChildFilterConfiguratorImage filtered by the file column
 * @method     ChildFilterConfiguratorImage findOneByVisible(int $visible) Return the first ChildFilterConfiguratorImage filtered by the visible column
 * @method     ChildFilterConfiguratorImage findOneByPosition(int $position) Return the first ChildFilterConfiguratorImage filtered by the position column
 * @method     ChildFilterConfiguratorImage findOneByCreatedAt(string $created_at) Return the first ChildFilterConfiguratorImage filtered by the created_at column
 * @method     ChildFilterConfiguratorImage findOneByUpdatedAt(string $updated_at) Return the first ChildFilterConfiguratorImage filtered by the updated_at column
 *
 * @method     array findById(int $id) Return ChildFilterConfiguratorImage objects filtered by the id column
 * @method     array findByConfiguratorId(int $configurator_id) Return ChildFilterConfiguratorImage objects filtered by the configurator_id column
 * @method     array findByFile(string $file) Return ChildFilterConfiguratorImage objects filtered by the file column
 * @method     array findByVisible(int $visible) Return ChildFilterConfiguratorImage objects filtered by the visible column
 * @method     array findByPosition(int $position) Return ChildFilterConfiguratorImage objects filtered by the position column
 * @method     array findByCreatedAt(string $created_at) Return ChildFilterConfiguratorImage objects filtered by the created_at column
 * @method     array findByUpdatedAt(string $updated_at) Return ChildFilterConfiguratorImage objects filtered by the updated_at column
 *
 */
abstract class FilterConfiguratorImageQuery extends ModelCriteria
{
    
    /**
     * Initializes internal state of \FilterConfigurator\Model\Base\FilterConfiguratorImageQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'thelia', $modelName = '\\FilterConfigurator\\Model\\FilterConfiguratorImage', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildFilterConfiguratorImageQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildFilterConfiguratorImageQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \FilterConfigurator\Model\FilterConfiguratorImageQuery) {
            return $criteria;
        }
        $query = new \FilterConfigurator\Model\FilterConfiguratorImageQuery();
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
     * @return ChildFilterConfiguratorImage|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = FilterConfiguratorImageTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(FilterConfiguratorImageTableMap::DATABASE_NAME);
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
     * @return   ChildFilterConfiguratorImage A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ID, CONFIGURATOR_ID, FILE, VISIBLE, POSITION, CREATED_AT, UPDATED_AT FROM filterconfigurator_configurator_image WHERE ID = :p0';
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
            $obj = new ChildFilterConfiguratorImage();
            $obj->hydrate($row);
            FilterConfiguratorImageTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildFilterConfiguratorImage|array|mixed the result, formatted by the current formatter
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
     * @return ChildFilterConfiguratorImageQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(FilterConfiguratorImageTableMap::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildFilterConfiguratorImageQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(FilterConfiguratorImageTableMap::ID, $keys, Criteria::IN);
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
     * @return ChildFilterConfiguratorImageQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(FilterConfiguratorImageTableMap::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(FilterConfiguratorImageTableMap::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FilterConfiguratorImageTableMap::ID, $id, $comparison);
    }

    /**
     * Filter the query on the configurator_id column
     *
     * Example usage:
     * <code>
     * $query->filterByConfiguratorId(1234); // WHERE configurator_id = 1234
     * $query->filterByConfiguratorId(array(12, 34)); // WHERE configurator_id IN (12, 34)
     * $query->filterByConfiguratorId(array('min' => 12)); // WHERE configurator_id > 12
     * </code>
     *
     * @see       filterByFilterConfigurator()
     *
     * @param     mixed $configuratorId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildFilterConfiguratorImageQuery The current query, for fluid interface
     */
    public function filterByConfiguratorId($configuratorId = null, $comparison = null)
    {
        if (is_array($configuratorId)) {
            $useMinMax = false;
            if (isset($configuratorId['min'])) {
                $this->addUsingAlias(FilterConfiguratorImageTableMap::CONFIGURATOR_ID, $configuratorId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($configuratorId['max'])) {
                $this->addUsingAlias(FilterConfiguratorImageTableMap::CONFIGURATOR_ID, $configuratorId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FilterConfiguratorImageTableMap::CONFIGURATOR_ID, $configuratorId, $comparison);
    }

    /**
     * Filter the query on the file column
     *
     * Example usage:
     * <code>
     * $query->filterByFile('fooValue');   // WHERE file = 'fooValue'
     * $query->filterByFile('%fooValue%'); // WHERE file LIKE '%fooValue%'
     * </code>
     *
     * @param     string $file The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildFilterConfiguratorImageQuery The current query, for fluid interface
     */
    public function filterByFile($file = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($file)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $file)) {
                $file = str_replace('*', '%', $file);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(FilterConfiguratorImageTableMap::FILE, $file, $comparison);
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
     * @return ChildFilterConfiguratorImageQuery The current query, for fluid interface
     */
    public function filterByVisible($visible = null, $comparison = null)
    {
        if (is_array($visible)) {
            $useMinMax = false;
            if (isset($visible['min'])) {
                $this->addUsingAlias(FilterConfiguratorImageTableMap::VISIBLE, $visible['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($visible['max'])) {
                $this->addUsingAlias(FilterConfiguratorImageTableMap::VISIBLE, $visible['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FilterConfiguratorImageTableMap::VISIBLE, $visible, $comparison);
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
     * @return ChildFilterConfiguratorImageQuery The current query, for fluid interface
     */
    public function filterByPosition($position = null, $comparison = null)
    {
        if (is_array($position)) {
            $useMinMax = false;
            if (isset($position['min'])) {
                $this->addUsingAlias(FilterConfiguratorImageTableMap::POSITION, $position['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($position['max'])) {
                $this->addUsingAlias(FilterConfiguratorImageTableMap::POSITION, $position['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FilterConfiguratorImageTableMap::POSITION, $position, $comparison);
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
     * @return ChildFilterConfiguratorImageQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(FilterConfiguratorImageTableMap::CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(FilterConfiguratorImageTableMap::CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FilterConfiguratorImageTableMap::CREATED_AT, $createdAt, $comparison);
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
     * @return ChildFilterConfiguratorImageQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(FilterConfiguratorImageTableMap::UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(FilterConfiguratorImageTableMap::UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FilterConfiguratorImageTableMap::UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Filter the query by a related \FilterConfigurator\Model\FilterConfigurator object
     *
     * @param \FilterConfigurator\Model\FilterConfigurator|ObjectCollection $filterConfigurator The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildFilterConfiguratorImageQuery The current query, for fluid interface
     */
    public function filterByFilterConfigurator($filterConfigurator, $comparison = null)
    {
        if ($filterConfigurator instanceof \FilterConfigurator\Model\FilterConfigurator) {
            return $this
                ->addUsingAlias(FilterConfiguratorImageTableMap::CONFIGURATOR_ID, $filterConfigurator->getId(), $comparison);
        } elseif ($filterConfigurator instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(FilterConfiguratorImageTableMap::CONFIGURATOR_ID, $filterConfigurator->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByFilterConfigurator() only accepts arguments of type \FilterConfigurator\Model\FilterConfigurator or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the FilterConfigurator relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildFilterConfiguratorImageQuery The current query, for fluid interface
     */
    public function joinFilterConfigurator($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('FilterConfigurator');

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
            $this->addJoinObject($join, 'FilterConfigurator');
        }

        return $this;
    }

    /**
     * Use the FilterConfigurator relation FilterConfigurator object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \FilterConfigurator\Model\FilterConfiguratorQuery A secondary query class using the current class as primary query
     */
    public function useFilterConfiguratorQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinFilterConfigurator($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'FilterConfigurator', '\FilterConfigurator\Model\FilterConfiguratorQuery');
    }

    /**
     * Filter the query by a related \FilterConfigurator\Model\FilterConfiguratorImageI18n object
     *
     * @param \FilterConfigurator\Model\FilterConfiguratorImageI18n|ObjectCollection $filterConfiguratorImageI18n  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildFilterConfiguratorImageQuery The current query, for fluid interface
     */
    public function filterByFilterConfiguratorImageI18n($filterConfiguratorImageI18n, $comparison = null)
    {
        if ($filterConfiguratorImageI18n instanceof \FilterConfigurator\Model\FilterConfiguratorImageI18n) {
            return $this
                ->addUsingAlias(FilterConfiguratorImageTableMap::ID, $filterConfiguratorImageI18n->getId(), $comparison);
        } elseif ($filterConfiguratorImageI18n instanceof ObjectCollection) {
            return $this
                ->useFilterConfiguratorImageI18nQuery()
                ->filterByPrimaryKeys($filterConfiguratorImageI18n->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByFilterConfiguratorImageI18n() only accepts arguments of type \FilterConfigurator\Model\FilterConfiguratorImageI18n or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the FilterConfiguratorImageI18n relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildFilterConfiguratorImageQuery The current query, for fluid interface
     */
    public function joinFilterConfiguratorImageI18n($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('FilterConfiguratorImageI18n');

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
            $this->addJoinObject($join, 'FilterConfiguratorImageI18n');
        }

        return $this;
    }

    /**
     * Use the FilterConfiguratorImageI18n relation FilterConfiguratorImageI18n object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \FilterConfigurator\Model\FilterConfiguratorImageI18nQuery A secondary query class using the current class as primary query
     */
    public function useFilterConfiguratorImageI18nQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinFilterConfiguratorImageI18n($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'FilterConfiguratorImageI18n', '\FilterConfigurator\Model\FilterConfiguratorImageI18nQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildFilterConfiguratorImage $filterConfiguratorImage Object to remove from the list of results
     *
     * @return ChildFilterConfiguratorImageQuery The current query, for fluid interface
     */
    public function prune($filterConfiguratorImage = null)
    {
        if ($filterConfiguratorImage) {
            $this->addUsingAlias(FilterConfiguratorImageTableMap::ID, $filterConfiguratorImage->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the filterconfigurator_configurator_image table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(FilterConfiguratorImageTableMap::DATABASE_NAME);
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
            FilterConfiguratorImageTableMap::clearInstancePool();
            FilterConfiguratorImageTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildFilterConfiguratorImage or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildFilterConfiguratorImage object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(FilterConfiguratorImageTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(FilterConfiguratorImageTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            

        FilterConfiguratorImageTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            FilterConfiguratorImageTableMap::clearRelatedInstancePool();
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
     * @return     ChildFilterConfiguratorImageQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(FilterConfiguratorImageTableMap::UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }
    
    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     ChildFilterConfiguratorImageQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(FilterConfiguratorImageTableMap::CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }
    
    /**
     * Order by update date desc
     *
     * @return     ChildFilterConfiguratorImageQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(FilterConfiguratorImageTableMap::UPDATED_AT);
    }
    
    /**
     * Order by update date asc
     *
     * @return     ChildFilterConfiguratorImageQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(FilterConfiguratorImageTableMap::UPDATED_AT);
    }
    
    /**
     * Order by create date desc
     *
     * @return     ChildFilterConfiguratorImageQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(FilterConfiguratorImageTableMap::CREATED_AT);
    }
    
    /**
     * Order by create date asc
     *
     * @return     ChildFilterConfiguratorImageQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(FilterConfiguratorImageTableMap::CREATED_AT);
    }

} // FilterConfiguratorImageQuery
