<?php

namespace HookConfigurator\Model\Base;

use \Exception;
use \PDO;
use HookConfigurator\Model\ConfiguratorI18n as ChildConfiguratorI18n;
use HookConfigurator\Model\ConfiguratorI18nQuery as ChildConfiguratorI18nQuery;
use HookConfigurator\Model\Map\ConfiguratorI18nTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'configurator_i18n' table.
 *
 * 
 *
 * @method     ChildConfiguratorI18nQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildConfiguratorI18nQuery orderByLocale($order = Criteria::ASC) Order by the locale column
 * @method     ChildConfiguratorI18nQuery orderByVisible($order = Criteria::ASC) Order by the visible column
 * @method     ChildConfiguratorI18nQuery orderByType($order = Criteria::ASC) Order by the type column
 * @method     ChildConfiguratorI18nQuery orderByParameters($order = Criteria::ASC) Order by the parameters column
 *
 * @method     ChildConfiguratorI18nQuery groupById() Group by the id column
 * @method     ChildConfiguratorI18nQuery groupByLocale() Group by the locale column
 * @method     ChildConfiguratorI18nQuery groupByVisible() Group by the visible column
 * @method     ChildConfiguratorI18nQuery groupByType() Group by the type column
 * @method     ChildConfiguratorI18nQuery groupByParameters() Group by the parameters column
 *
 * @method     ChildConfiguratorI18nQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildConfiguratorI18nQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildConfiguratorI18nQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildConfiguratorI18nQuery leftJoinConfigurator($relationAlias = null) Adds a LEFT JOIN clause to the query using the Configurator relation
 * @method     ChildConfiguratorI18nQuery rightJoinConfigurator($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Configurator relation
 * @method     ChildConfiguratorI18nQuery innerJoinConfigurator($relationAlias = null) Adds a INNER JOIN clause to the query using the Configurator relation
 *
 * @method     ChildConfiguratorI18n findOne(ConnectionInterface $con = null) Return the first ChildConfiguratorI18n matching the query
 * @method     ChildConfiguratorI18n findOneOrCreate(ConnectionInterface $con = null) Return the first ChildConfiguratorI18n matching the query, or a new ChildConfiguratorI18n object populated from the query conditions when no match is found
 *
 * @method     ChildConfiguratorI18n findOneById(int $id) Return the first ChildConfiguratorI18n filtered by the id column
 * @method     ChildConfiguratorI18n findOneByLocale(string $locale) Return the first ChildConfiguratorI18n filtered by the locale column
 * @method     ChildConfiguratorI18n findOneByVisible(int $visible) Return the first ChildConfiguratorI18n filtered by the visible column
 * @method     ChildConfiguratorI18n findOneByType(string $type) Return the first ChildConfiguratorI18n filtered by the type column
 * @method     ChildConfiguratorI18n findOneByParameters(string $parameters) Return the first ChildConfiguratorI18n filtered by the parameters column
 *
 * @method     array findById(int $id) Return ChildConfiguratorI18n objects filtered by the id column
 * @method     array findByLocale(string $locale) Return ChildConfiguratorI18n objects filtered by the locale column
 * @method     array findByVisible(int $visible) Return ChildConfiguratorI18n objects filtered by the visible column
 * @method     array findByType(string $type) Return ChildConfiguratorI18n objects filtered by the type column
 * @method     array findByParameters(string $parameters) Return ChildConfiguratorI18n objects filtered by the parameters column
 *
 */
abstract class ConfiguratorI18nQuery extends ModelCriteria
{
    
    /**
     * Initializes internal state of \HookConfigurator\Model\Base\ConfiguratorI18nQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'thelia', $modelName = '\\HookConfigurator\\Model\\ConfiguratorI18n', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildConfiguratorI18nQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildConfiguratorI18nQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \HookConfigurator\Model\ConfiguratorI18nQuery) {
            return $criteria;
        }
        $query = new \HookConfigurator\Model\ConfiguratorI18nQuery();
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
     * @param array[$id, $locale] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildConfiguratorI18n|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ConfiguratorI18nTableMap::getInstanceFromPool(serialize(array((string) $key[0], (string) $key[1]))))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ConfiguratorI18nTableMap::DATABASE_NAME);
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
     * @return   ChildConfiguratorI18n A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ID, LOCALE, VISIBLE, TYPE, PARAMETERS FROM configurator_i18n WHERE ID = :p0 AND LOCALE = :p1';
        try {
            $stmt = $con->prepare($sql);            
            $stmt->bindValue(':p0', $key[0], PDO::PARAM_INT);            
            $stmt->bindValue(':p1', $key[1], PDO::PARAM_STR);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            $obj = new ChildConfiguratorI18n();
            $obj->hydrate($row);
            ConfiguratorI18nTableMap::addInstanceToPool($obj, serialize(array((string) $key[0], (string) $key[1])));
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
     * @return ChildConfiguratorI18n|array|mixed the result, formatted by the current formatter
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
     * @return ChildConfiguratorI18nQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(ConfiguratorI18nTableMap::ID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(ConfiguratorI18nTableMap::LOCALE, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildConfiguratorI18nQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(ConfiguratorI18nTableMap::ID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(ConfiguratorI18nTableMap::LOCALE, $key[1], Criteria::EQUAL);
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
     * @see       filterByConfigurator()
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildConfiguratorI18nQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(ConfiguratorI18nTableMap::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(ConfiguratorI18nTableMap::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ConfiguratorI18nTableMap::ID, $id, $comparison);
    }

    /**
     * Filter the query on the locale column
     *
     * Example usage:
     * <code>
     * $query->filterByLocale('fooValue');   // WHERE locale = 'fooValue'
     * $query->filterByLocale('%fooValue%'); // WHERE locale LIKE '%fooValue%'
     * </code>
     *
     * @param     string $locale The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildConfiguratorI18nQuery The current query, for fluid interface
     */
    public function filterByLocale($locale = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($locale)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $locale)) {
                $locale = str_replace('*', '%', $locale);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ConfiguratorI18nTableMap::LOCALE, $locale, $comparison);
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
     * @return ChildConfiguratorI18nQuery The current query, for fluid interface
     */
    public function filterByVisible($visible = null, $comparison = null)
    {
        if (is_array($visible)) {
            $useMinMax = false;
            if (isset($visible['min'])) {
                $this->addUsingAlias(ConfiguratorI18nTableMap::VISIBLE, $visible['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($visible['max'])) {
                $this->addUsingAlias(ConfiguratorI18nTableMap::VISIBLE, $visible['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ConfiguratorI18nTableMap::VISIBLE, $visible, $comparison);
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
     * @return ChildConfiguratorI18nQuery The current query, for fluid interface
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

        return $this->addUsingAlias(ConfiguratorI18nTableMap::TYPE, $type, $comparison);
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
     * @return ChildConfiguratorI18nQuery The current query, for fluid interface
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

        return $this->addUsingAlias(ConfiguratorI18nTableMap::PARAMETERS, $parameters, $comparison);
    }

    /**
     * Filter the query by a related \HookConfigurator\Model\Configurator object
     *
     * @param \HookConfigurator\Model\Configurator|ObjectCollection $configurator The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildConfiguratorI18nQuery The current query, for fluid interface
     */
    public function filterByConfigurator($configurator, $comparison = null)
    {
        if ($configurator instanceof \HookConfigurator\Model\Configurator) {
            return $this
                ->addUsingAlias(ConfiguratorI18nTableMap::ID, $configurator->getId(), $comparison);
        } elseif ($configurator instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ConfiguratorI18nTableMap::ID, $configurator->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return ChildConfiguratorI18nQuery The current query, for fluid interface
     */
    public function joinConfigurator($relationAlias = null, $joinType = 'LEFT JOIN')
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
    public function useConfiguratorQuery($relationAlias = null, $joinType = 'LEFT JOIN')
    {
        return $this
            ->joinConfigurator($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Configurator', '\HookConfigurator\Model\ConfiguratorQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildConfiguratorI18n $configuratorI18n Object to remove from the list of results
     *
     * @return ChildConfiguratorI18nQuery The current query, for fluid interface
     */
    public function prune($configuratorI18n = null)
    {
        if ($configuratorI18n) {
            $this->addCond('pruneCond0', $this->getAliasedColName(ConfiguratorI18nTableMap::ID), $configuratorI18n->getId(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(ConfiguratorI18nTableMap::LOCALE), $configuratorI18n->getLocale(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the configurator_i18n table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ConfiguratorI18nTableMap::DATABASE_NAME);
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
            ConfiguratorI18nTableMap::clearInstancePool();
            ConfiguratorI18nTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildConfiguratorI18n or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildConfiguratorI18n object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(ConfiguratorI18nTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ConfiguratorI18nTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            

        ConfiguratorI18nTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            ConfiguratorI18nTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

} // ConfiguratorI18nQuery
