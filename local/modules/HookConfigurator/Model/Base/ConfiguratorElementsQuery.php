<?php

namespace HookConfigurator\Model\Base;

use \Exception;
use \PDO;
use HookConfigurator\Model\ConfiguratorElements as ChildConfiguratorElements;
use HookConfigurator\Model\ConfiguratorElementsQuery as ChildConfiguratorElementsQuery;
use HookConfigurator\Model\Map\ConfiguratorElementsTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'configurator_elements' table.
 *
 * 
 *
 * @method     ChildConfiguratorElementsQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildConfiguratorElementsQuery orderByConfiguratorId($order = Criteria::ASC) Order by the configurator_id column
 * @method     ChildConfiguratorElementsQuery orderByVisible($order = Criteria::ASC) Order by the visible column
 * @method     ChildConfiguratorElementsQuery orderByQuestion($order = Criteria::ASC) Order by the question column
 * @method     ChildConfiguratorElementsQuery orderByType($order = Criteria::ASC) Order by the type column
 * @method     ChildConfiguratorElementsQuery orderByParameters($order = Criteria::ASC) Order by the parameters column
 *
 * @method     ChildConfiguratorElementsQuery groupById() Group by the id column
 * @method     ChildConfiguratorElementsQuery groupByConfiguratorId() Group by the configurator_id column
 * @method     ChildConfiguratorElementsQuery groupByVisible() Group by the visible column
 * @method     ChildConfiguratorElementsQuery groupByQuestion() Group by the question column
 * @method     ChildConfiguratorElementsQuery groupByType() Group by the type column
 * @method     ChildConfiguratorElementsQuery groupByParameters() Group by the parameters column
 *
 * @method     ChildConfiguratorElementsQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildConfiguratorElementsQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildConfiguratorElementsQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildConfiguratorElementsQuery leftJoinConfigurator($relationAlias = null) Adds a LEFT JOIN clause to the query using the Configurator relation
 * @method     ChildConfiguratorElementsQuery rightJoinConfigurator($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Configurator relation
 * @method     ChildConfiguratorElementsQuery innerJoinConfigurator($relationAlias = null) Adds a INNER JOIN clause to the query using the Configurator relation
 *
 * @method     ChildConfiguratorElements findOne(ConnectionInterface $con = null) Return the first ChildConfiguratorElements matching the query
 * @method     ChildConfiguratorElements findOneOrCreate(ConnectionInterface $con = null) Return the first ChildConfiguratorElements matching the query, or a new ChildConfiguratorElements object populated from the query conditions when no match is found
 *
 * @method     ChildConfiguratorElements findOneById(int $id) Return the first ChildConfiguratorElements filtered by the id column
 * @method     ChildConfiguratorElements findOneByConfiguratorId(int $configurator_id) Return the first ChildConfiguratorElements filtered by the configurator_id column
 * @method     ChildConfiguratorElements findOneByVisible(int $visible) Return the first ChildConfiguratorElements filtered by the visible column
 * @method     ChildConfiguratorElements findOneByQuestion(string $question) Return the first ChildConfiguratorElements filtered by the question column
 * @method     ChildConfiguratorElements findOneByType(string $type) Return the first ChildConfiguratorElements filtered by the type column
 * @method     ChildConfiguratorElements findOneByParameters(string $parameters) Return the first ChildConfiguratorElements filtered by the parameters column
 *
 * @method     array findById(int $id) Return ChildConfiguratorElements objects filtered by the id column
 * @method     array findByConfiguratorId(int $configurator_id) Return ChildConfiguratorElements objects filtered by the configurator_id column
 * @method     array findByVisible(int $visible) Return ChildConfiguratorElements objects filtered by the visible column
 * @method     array findByQuestion(string $question) Return ChildConfiguratorElements objects filtered by the question column
 * @method     array findByType(string $type) Return ChildConfiguratorElements objects filtered by the type column
 * @method     array findByParameters(string $parameters) Return ChildConfiguratorElements objects filtered by the parameters column
 *
 */
abstract class ConfiguratorElementsQuery extends ModelCriteria
{
    
    /**
     * Initializes internal state of \HookConfigurator\Model\Base\ConfiguratorElementsQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'thelia', $modelName = '\\HookConfigurator\\Model\\ConfiguratorElements', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildConfiguratorElementsQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildConfiguratorElementsQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \HookConfigurator\Model\ConfiguratorElementsQuery) {
            return $criteria;
        }
        $query = new \HookConfigurator\Model\ConfiguratorElementsQuery();
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
     * $obj = $c->findPk(array(12, 34), $con);
     * </code>
     *
     * @param array[$id, $configurator_id] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildConfiguratorElements|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ConfiguratorElementsTableMap::getInstanceFromPool(serialize(array((string) $key[0], (string) $key[1]))))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ConfiguratorElementsTableMap::DATABASE_NAME);
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
     * @return   ChildConfiguratorElements A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ID, CONFIGURATOR_ID, VISIBLE, QUESTION, TYPE, PARAMETERS FROM configurator_elements WHERE ID = :p0 AND CONFIGURATOR_ID = :p1';
        try {
            $stmt = $con->prepare($sql);            
            $stmt->bindValue(':p0', $key[0], PDO::PARAM_INT);            
            $stmt->bindValue(':p1', $key[1], PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            $obj = new ChildConfiguratorElements();
            $obj->hydrate($row);
            ConfiguratorElementsTableMap::addInstanceToPool($obj, serialize(array((string) $key[0], (string) $key[1])));
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
     * @return ChildConfiguratorElements|array|mixed the result, formatted by the current formatter
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
     * $objs = $c->findPks(array(array(12, 56), array(832, 123), array(123, 456)), $con);
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
     * @return ChildConfiguratorElementsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(ConfiguratorElementsTableMap::ID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(ConfiguratorElementsTableMap::CONFIGURATOR_ID, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildConfiguratorElementsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(ConfiguratorElementsTableMap::ID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(ConfiguratorElementsTableMap::CONFIGURATOR_ID, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $this->addOr($cton0);
        }

        return $this;
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
     * @return ChildConfiguratorElementsQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(ConfiguratorElementsTableMap::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(ConfiguratorElementsTableMap::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ConfiguratorElementsTableMap::ID, $id, $comparison);
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
     * @see       filterByConfigurator()
     *
     * @param     mixed $configuratorId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildConfiguratorElementsQuery The current query, for fluid interface
     */
    public function filterByConfiguratorId($configuratorId = null, $comparison = null)
    {
        if (is_array($configuratorId)) {
            $useMinMax = false;
            if (isset($configuratorId['min'])) {
                $this->addUsingAlias(ConfiguratorElementsTableMap::CONFIGURATOR_ID, $configuratorId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($configuratorId['max'])) {
                $this->addUsingAlias(ConfiguratorElementsTableMap::CONFIGURATOR_ID, $configuratorId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ConfiguratorElementsTableMap::CONFIGURATOR_ID, $configuratorId, $comparison);
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
     * @return ChildConfiguratorElementsQuery The current query, for fluid interface
     */
    public function filterByVisible($visible = null, $comparison = null)
    {
        if (is_array($visible)) {
            $useMinMax = false;
            if (isset($visible['min'])) {
                $this->addUsingAlias(ConfiguratorElementsTableMap::VISIBLE, $visible['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($visible['max'])) {
                $this->addUsingAlias(ConfiguratorElementsTableMap::VISIBLE, $visible['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ConfiguratorElementsTableMap::VISIBLE, $visible, $comparison);
    }

    /**
     * Filter the query on the question column
     *
     * Example usage:
     * <code>
     * $query->filterByQuestion('fooValue');   // WHERE question = 'fooValue'
     * $query->filterByQuestion('%fooValue%'); // WHERE question LIKE '%fooValue%'
     * </code>
     *
     * @param     string $question The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildConfiguratorElementsQuery The current query, for fluid interface
     */
    public function filterByQuestion($question = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($question)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $question)) {
                $question = str_replace('*', '%', $question);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ConfiguratorElementsTableMap::QUESTION, $question, $comparison);
    }

    /**
     * Filter the query on the type column
     *
     * Example usage:
     * <code>
     * $query->filterByType('fooValue');   // WHERE type = 'fooValue'
     * $query->filterByType('%fooValue%'); // WHERE type LIKE '%fooValue%'
     * </code>
     *
     * @param     string $type The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildConfiguratorElementsQuery The current query, for fluid interface
     */
    public function filterByType($type = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($type)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $type)) {
                $type = str_replace('*', '%', $type);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ConfiguratorElementsTableMap::TYPE, $type, $comparison);
    }

    /**
     * Filter the query on the parameters column
     *
     * Example usage:
     * <code>
     * $query->filterByParameters('fooValue');   // WHERE parameters = 'fooValue'
     * $query->filterByParameters('%fooValue%'); // WHERE parameters LIKE '%fooValue%'
     * </code>
     *
     * @param     string $parameters The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildConfiguratorElementsQuery The current query, for fluid interface
     */
    public function filterByParameters($parameters = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($parameters)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $parameters)) {
                $parameters = str_replace('*', '%', $parameters);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ConfiguratorElementsTableMap::PARAMETERS, $parameters, $comparison);
    }

    /**
     * Filter the query by a related \HookConfigurator\Model\Configurator object
     *
     * @param \HookConfigurator\Model\Configurator|ObjectCollection $configurator The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildConfiguratorElementsQuery The current query, for fluid interface
     */
    public function filterByConfigurator($configurator, $comparison = null)
    {
        if ($configurator instanceof \HookConfigurator\Model\Configurator) {
            return $this
                ->addUsingAlias(ConfiguratorElementsTableMap::CONFIGURATOR_ID, $configurator->getId(), $comparison);
        } elseif ($configurator instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ConfiguratorElementsTableMap::CONFIGURATOR_ID, $configurator->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByConfigurator() only accepts arguments of type \HookConfigurator\Model\Configurator or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Configurator relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildConfiguratorElementsQuery The current query, for fluid interface
     */
    public function joinConfigurator($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Configurator');

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
            $this->addJoinObject($join, 'Configurator');
        }

        return $this;
    }

    /**
     * Use the Configurator relation Configurator object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \HookConfigurator\Model\ConfiguratorQuery A secondary query class using the current class as primary query
     */
    public function useConfiguratorQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinConfigurator($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Configurator', '\HookConfigurator\Model\ConfiguratorQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildConfiguratorElements $configuratorElements Object to remove from the list of results
     *
     * @return ChildConfiguratorElementsQuery The current query, for fluid interface
     */
    public function prune($configuratorElements = null)
    {
        if ($configuratorElements) {
            $this->addCond('pruneCond0', $this->getAliasedColName(ConfiguratorElementsTableMap::ID), $configuratorElements->getId(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(ConfiguratorElementsTableMap::CONFIGURATOR_ID), $configuratorElements->getConfiguratorId(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the configurator_elements table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ConfiguratorElementsTableMap::DATABASE_NAME);
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
            ConfiguratorElementsTableMap::clearInstancePool();
            ConfiguratorElementsTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildConfiguratorElements or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildConfiguratorElements object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(ConfiguratorElementsTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ConfiguratorElementsTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            

        ConfiguratorElementsTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            ConfiguratorElementsTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

} // ConfiguratorElementsQuery
