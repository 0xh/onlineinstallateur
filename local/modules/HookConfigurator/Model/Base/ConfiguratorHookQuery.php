<?php

namespace HookConfigurator\Model\Base;

use \Exception;
use \PDO;
use HookConfigurator\Model\ConfiguratorHook as ChildConfiguratorHook;
use HookConfigurator\Model\ConfiguratorHookQuery as ChildConfiguratorHookQuery;
use HookConfigurator\Model\Map\ConfiguratorHookTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;
use Thelia\Model\Hook;

/**
 * Base class that represents a query for the 'configurator_hook' table.
 *
 * 
 *
 * @method     ChildConfiguratorHookQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildConfiguratorHookQuery orderByConfiguratorId($order = Criteria::ASC) Order by the configurator_id column
 * @method     ChildConfiguratorHookQuery orderByHookId($order = Criteria::ASC) Order by the hook_id column
 * @method     ChildConfiguratorHookQuery orderByHookCode($order = Criteria::ASC) Order by the hook_code column
 *
 * @method     ChildConfiguratorHookQuery groupById() Group by the id column
 * @method     ChildConfiguratorHookQuery groupByConfiguratorId() Group by the configurator_id column
 * @method     ChildConfiguratorHookQuery groupByHookId() Group by the hook_id column
 * @method     ChildConfiguratorHookQuery groupByHookCode() Group by the hook_code column
 *
 * @method     ChildConfiguratorHookQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildConfiguratorHookQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildConfiguratorHookQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildConfiguratorHookQuery leftJoinConfigurator($relationAlias = null) Adds a LEFT JOIN clause to the query using the Configurator relation
 * @method     ChildConfiguratorHookQuery rightJoinConfigurator($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Configurator relation
 * @method     ChildConfiguratorHookQuery innerJoinConfigurator($relationAlias = null) Adds a INNER JOIN clause to the query using the Configurator relation
 *
 * @method     ChildConfiguratorHookQuery leftJoinHook($relationAlias = null) Adds a LEFT JOIN clause to the query using the Hook relation
 * @method     ChildConfiguratorHookQuery rightJoinHook($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Hook relation
 * @method     ChildConfiguratorHookQuery innerJoinHook($relationAlias = null) Adds a INNER JOIN clause to the query using the Hook relation
 *
 * @method     ChildConfiguratorHook findOne(ConnectionInterface $con = null) Return the first ChildConfiguratorHook matching the query
 * @method     ChildConfiguratorHook findOneOrCreate(ConnectionInterface $con = null) Return the first ChildConfiguratorHook matching the query, or a new ChildConfiguratorHook object populated from the query conditions when no match is found
 *
 * @method     ChildConfiguratorHook findOneById(int $id) Return the first ChildConfiguratorHook filtered by the id column
 * @method     ChildConfiguratorHook findOneByConfiguratorId(int $configurator_id) Return the first ChildConfiguratorHook filtered by the configurator_id column
 * @method     ChildConfiguratorHook findOneByHookId(int $hook_id) Return the first ChildConfiguratorHook filtered by the hook_id column
 * @method     ChildConfiguratorHook findOneByHookCode(string $hook_code) Return the first ChildConfiguratorHook filtered by the hook_code column
 *
 * @method     array findById(int $id) Return ChildConfiguratorHook objects filtered by the id column
 * @method     array findByConfiguratorId(int $configurator_id) Return ChildConfiguratorHook objects filtered by the configurator_id column
 * @method     array findByHookId(int $hook_id) Return ChildConfiguratorHook objects filtered by the hook_id column
 * @method     array findByHookCode(string $hook_code) Return ChildConfiguratorHook objects filtered by the hook_code column
 *
 */
abstract class ConfiguratorHookQuery extends ModelCriteria
{
    
    /**
     * Initializes internal state of \HookConfigurator\Model\Base\ConfiguratorHookQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'thelia', $modelName = '\\HookConfigurator\\Model\\ConfiguratorHook', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildConfiguratorHookQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildConfiguratorHookQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \HookConfigurator\Model\ConfiguratorHookQuery) {
            return $criteria;
        }
        $query = new \HookConfigurator\Model\ConfiguratorHookQuery();
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
     * @return ChildConfiguratorHook|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ConfiguratorHookTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ConfiguratorHookTableMap::DATABASE_NAME);
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
     * @return   ChildConfiguratorHook A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ID, CONFIGURATOR_ID, HOOK_ID, HOOK_CODE FROM configurator_hook WHERE ID = :p0';
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
            $obj = new ChildConfiguratorHook();
            $obj->hydrate($row);
            ConfiguratorHookTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildConfiguratorHook|array|mixed the result, formatted by the current formatter
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
     * @return ChildConfiguratorHookQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ConfiguratorHookTableMap::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildConfiguratorHookQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ConfiguratorHookTableMap::ID, $keys, Criteria::IN);
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
     * @return ChildConfiguratorHookQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(ConfiguratorHookTableMap::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(ConfiguratorHookTableMap::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ConfiguratorHookTableMap::ID, $id, $comparison);
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
     * @return ChildConfiguratorHookQuery The current query, for fluid interface
     */
    public function filterByConfiguratorId($configuratorId = null, $comparison = null)
    {
        if (is_array($configuratorId)) {
            $useMinMax = false;
            if (isset($configuratorId['min'])) {
                $this->addUsingAlias(ConfiguratorHookTableMap::CONFIGURATOR_ID, $configuratorId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($configuratorId['max'])) {
                $this->addUsingAlias(ConfiguratorHookTableMap::CONFIGURATOR_ID, $configuratorId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ConfiguratorHookTableMap::CONFIGURATOR_ID, $configuratorId, $comparison);
    }

    /**
     * Filter the query on the hook_id column
     *
     * Example usage:
     * <code>
     * $query->filterByHookId(1234); // WHERE hook_id = 1234
     * $query->filterByHookId(array(12, 34)); // WHERE hook_id IN (12, 34)
     * $query->filterByHookId(array('min' => 12)); // WHERE hook_id > 12
     * </code>
     *
     * @see       filterByHook()
     *
     * @param     mixed $hookId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildConfiguratorHookQuery The current query, for fluid interface
     */
    public function filterByHookId($hookId = null, $comparison = null)
    {
        if (is_array($hookId)) {
            $useMinMax = false;
            if (isset($hookId['min'])) {
                $this->addUsingAlias(ConfiguratorHookTableMap::HOOK_ID, $hookId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($hookId['max'])) {
                $this->addUsingAlias(ConfiguratorHookTableMap::HOOK_ID, $hookId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ConfiguratorHookTableMap::HOOK_ID, $hookId, $comparison);
    }

    /**
     * Filter the query on the hook_code column
     *
     * Example usage:
     * <code>
     * $query->filterByHookCode('fooValue');   // WHERE hook_code = 'fooValue'
     * $query->filterByHookCode('%fooValue%'); // WHERE hook_code LIKE '%fooValue%'
     * </code>
     *
     * @param     string $hookCode The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildConfiguratorHookQuery The current query, for fluid interface
     */
    public function filterByHookCode($hookCode = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($hookCode)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $hookCode)) {
                $hookCode = str_replace('*', '%', $hookCode);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ConfiguratorHookTableMap::HOOK_CODE, $hookCode, $comparison);
    }

    /**
     * Filter the query by a related \HookConfigurator\Model\Configurator object
     *
     * @param \HookConfigurator\Model\Configurator|ObjectCollection $configurator The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildConfiguratorHookQuery The current query, for fluid interface
     */
    public function filterByConfigurator($configurator, $comparison = null)
    {
        if ($configurator instanceof \HookConfigurator\Model\Configurator) {
            return $this
                ->addUsingAlias(ConfiguratorHookTableMap::CONFIGURATOR_ID, $configurator->getId(), $comparison);
        } elseif ($configurator instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ConfiguratorHookTableMap::CONFIGURATOR_ID, $configurator->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return ChildConfiguratorHookQuery The current query, for fluid interface
     */
    public function joinConfigurator($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
    public function useConfiguratorQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinConfigurator($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Configurator', '\HookConfigurator\Model\ConfiguratorQuery');
    }

    /**
     * Filter the query by a related \Thelia\Model\Hook object
     *
     * @param \Thelia\Model\Hook|ObjectCollection $hook The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildConfiguratorHookQuery The current query, for fluid interface
     */
    public function filterByHook($hook, $comparison = null)
    {
        if ($hook instanceof \Thelia\Model\Hook) {
            return $this
                ->addUsingAlias(ConfiguratorHookTableMap::HOOK_ID, $hook->getId(), $comparison);
        } elseif ($hook instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ConfiguratorHookTableMap::HOOK_ID, $hook->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByHook() only accepts arguments of type \Thelia\Model\Hook or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Hook relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildConfiguratorHookQuery The current query, for fluid interface
     */
    public function joinHook($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Hook');

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
            $this->addJoinObject($join, 'Hook');
        }

        return $this;
    }

    /**
     * Use the Hook relation Hook object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Thelia\Model\HookQuery A secondary query class using the current class as primary query
     */
    public function useHookQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinHook($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Hook', '\Thelia\Model\HookQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildConfiguratorHook $configuratorHook Object to remove from the list of results
     *
     * @return ChildConfiguratorHookQuery The current query, for fluid interface
     */
    public function prune($configuratorHook = null)
    {
        if ($configuratorHook) {
            $this->addUsingAlias(ConfiguratorHookTableMap::ID, $configuratorHook->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the configurator_hook table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ConfiguratorHookTableMap::DATABASE_NAME);
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
            ConfiguratorHookTableMap::clearInstancePool();
            ConfiguratorHookTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildConfiguratorHook or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildConfiguratorHook object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(ConfiguratorHookTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ConfiguratorHookTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            

        ConfiguratorHookTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            ConfiguratorHookTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

} // ConfiguratorHookQuery
