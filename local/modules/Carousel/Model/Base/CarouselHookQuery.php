<?php

namespace Carousel\Model\Base;

use \Exception;
use \PDO;
use Carousel\Model\CarouselHook as ChildCarouselHook;
use Carousel\Model\CarouselHookQuery as ChildCarouselHookQuery;
use Carousel\Model\Map\CarouselHookTableMap;
use Carousel\Model\Thelia\Model\Hook;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'carousel_hook' table.
 *
 * 
 *
 * @method     ChildCarouselHookQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildCarouselHookQuery orderByCarouselId($order = Criteria::ASC) Order by the carousel_id column
 * @method     ChildCarouselHookQuery orderByHookId($order = Criteria::ASC) Order by the hook_id column
 * @method     ChildCarouselHookQuery orderByHookCode($order = Criteria::ASC) Order by the hook_code column
 *
 * @method     ChildCarouselHookQuery groupById() Group by the id column
 * @method     ChildCarouselHookQuery groupByCarouselId() Group by the carousel_id column
 * @method     ChildCarouselHookQuery groupByHookId() Group by the hook_id column
 * @method     ChildCarouselHookQuery groupByHookCode() Group by the hook_code column
 *
 * @method     ChildCarouselHookQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildCarouselHookQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildCarouselHookQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildCarouselHookQuery leftJoinCarouselName($relationAlias = null) Adds a LEFT JOIN clause to the query using the CarouselName relation
 * @method     ChildCarouselHookQuery rightJoinCarouselName($relationAlias = null) Adds a RIGHT JOIN clause to the query using the CarouselName relation
 * @method     ChildCarouselHookQuery innerJoinCarouselName($relationAlias = null) Adds a INNER JOIN clause to the query using the CarouselName relation
 *
 * @method     ChildCarouselHookQuery leftJoinHook($relationAlias = null) Adds a LEFT JOIN clause to the query using the Hook relation
 * @method     ChildCarouselHookQuery rightJoinHook($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Hook relation
 * @method     ChildCarouselHookQuery innerJoinHook($relationAlias = null) Adds a INNER JOIN clause to the query using the Hook relation
 *
 * @method     ChildCarouselHook findOne(ConnectionInterface $con = null) Return the first ChildCarouselHook matching the query
 * @method     ChildCarouselHook findOneOrCreate(ConnectionInterface $con = null) Return the first ChildCarouselHook matching the query, or a new ChildCarouselHook object populated from the query conditions when no match is found
 *
 * @method     ChildCarouselHook findOneById(int $id) Return the first ChildCarouselHook filtered by the id column
 * @method     ChildCarouselHook findOneByCarouselId(int $carousel_id) Return the first ChildCarouselHook filtered by the carousel_id column
 * @method     ChildCarouselHook findOneByHookId(int $hook_id) Return the first ChildCarouselHook filtered by the hook_id column
 * @method     ChildCarouselHook findOneByHookCode(string $hook_code) Return the first ChildCarouselHook filtered by the hook_code column
 *
 * @method     array findById(int $id) Return ChildCarouselHook objects filtered by the id column
 * @method     array findByCarouselId(int $carousel_id) Return ChildCarouselHook objects filtered by the carousel_id column
 * @method     array findByHookId(int $hook_id) Return ChildCarouselHook objects filtered by the hook_id column
 * @method     array findByHookCode(string $hook_code) Return ChildCarouselHook objects filtered by the hook_code column
 *
 */
abstract class CarouselHookQuery extends ModelCriteria
{
    
    /**
     * Initializes internal state of \Carousel\Model\Base\CarouselHookQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'thelia', $modelName = '\\Carousel\\Model\\CarouselHook', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildCarouselHookQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildCarouselHookQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \Carousel\Model\CarouselHookQuery) {
            return $criteria;
        }
        $query = new \Carousel\Model\CarouselHookQuery();
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
     * @return ChildCarouselHook|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = CarouselHookTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(CarouselHookTableMap::DATABASE_NAME);
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
     * @return   ChildCarouselHook A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ID, CAROUSEL_ID, HOOK_ID, HOOK_CODE FROM carousel_hook WHERE ID = :p0';
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
            $obj = new ChildCarouselHook();
            $obj->hydrate($row);
            CarouselHookTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildCarouselHook|array|mixed the result, formatted by the current formatter
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
     * @return ChildCarouselHookQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(CarouselHookTableMap::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildCarouselHookQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(CarouselHookTableMap::ID, $keys, Criteria::IN);
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
     * @return ChildCarouselHookQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(CarouselHookTableMap::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(CarouselHookTableMap::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CarouselHookTableMap::ID, $id, $comparison);
    }

    /**
     * Filter the query on the carousel_id column
     *
     * Example usage:
     * <code>
     * $query->filterByCarouselId(1234); // WHERE carousel_id = 1234
     * $query->filterByCarouselId(array(12, 34)); // WHERE carousel_id IN (12, 34)
     * $query->filterByCarouselId(array('min' => 12)); // WHERE carousel_id > 12
     * </code>
     *
     * @see       filterByCarouselName()
     *
     * @param     mixed $carouselId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCarouselHookQuery The current query, for fluid interface
     */
    public function filterByCarouselId($carouselId = null, $comparison = null)
    {
        if (is_array($carouselId)) {
            $useMinMax = false;
            if (isset($carouselId['min'])) {
                $this->addUsingAlias(CarouselHookTableMap::CAROUSEL_ID, $carouselId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($carouselId['max'])) {
                $this->addUsingAlias(CarouselHookTableMap::CAROUSEL_ID, $carouselId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CarouselHookTableMap::CAROUSEL_ID, $carouselId, $comparison);
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
     * @return ChildCarouselHookQuery The current query, for fluid interface
     */
    public function filterByHookId($hookId = null, $comparison = null)
    {
        if (is_array($hookId)) {
            $useMinMax = false;
            if (isset($hookId['min'])) {
                $this->addUsingAlias(CarouselHookTableMap::HOOK_ID, $hookId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($hookId['max'])) {
                $this->addUsingAlias(CarouselHookTableMap::HOOK_ID, $hookId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CarouselHookTableMap::HOOK_ID, $hookId, $comparison);
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
     * @return ChildCarouselHookQuery The current query, for fluid interface
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

        return $this->addUsingAlias(CarouselHookTableMap::HOOK_CODE, $hookCode, $comparison);
    }

    /**
     * Filter the query by a related \Carousel\Model\CarouselName object
     *
     * @param \Carousel\Model\CarouselName|ObjectCollection $carouselName The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCarouselHookQuery The current query, for fluid interface
     */
    public function filterByCarouselName($carouselName, $comparison = null)
    {
        if ($carouselName instanceof \Carousel\Model\CarouselName) {
            return $this
                ->addUsingAlias(CarouselHookTableMap::CAROUSEL_ID, $carouselName->getId(), $comparison);
        } elseif ($carouselName instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(CarouselHookTableMap::CAROUSEL_ID, $carouselName->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByCarouselName() only accepts arguments of type \Carousel\Model\CarouselName or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the CarouselName relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildCarouselHookQuery The current query, for fluid interface
     */
    public function joinCarouselName($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('CarouselName');

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
            $this->addJoinObject($join, 'CarouselName');
        }

        return $this;
    }

    /**
     * Use the CarouselName relation CarouselName object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Carousel\Model\CarouselNameQuery A secondary query class using the current class as primary query
     */
    public function useCarouselNameQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinCarouselName($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'CarouselName', '\Carousel\Model\CarouselNameQuery');
    }

    /**
     * Filter the query by a related \Carousel\Model\Thelia\Model\Hook object
     *
     * @param \Carousel\Model\Thelia\Model\Hook|ObjectCollection $hook The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCarouselHookQuery The current query, for fluid interface
     */
    public function filterByHook($hook, $comparison = null)
    {
        if ($hook instanceof \Carousel\Model\Thelia\Model\Hook) {
            return $this
                ->addUsingAlias(CarouselHookTableMap::HOOK_ID, $hook->getId(), $comparison);
        } elseif ($hook instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(CarouselHookTableMap::HOOK_ID, $hook->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByHook() only accepts arguments of type \Carousel\Model\Thelia\Model\Hook or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Hook relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildCarouselHookQuery The current query, for fluid interface
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
     * @return   \Carousel\Model\Thelia\Model\HookQuery A secondary query class using the current class as primary query
     */
    public function useHookQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinHook($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Hook', '\Carousel\Model\Thelia\Model\HookQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildCarouselHook $carouselHook Object to remove from the list of results
     *
     * @return ChildCarouselHookQuery The current query, for fluid interface
     */
    public function prune($carouselHook = null)
    {
        if ($carouselHook) {
            $this->addUsingAlias(CarouselHookTableMap::ID, $carouselHook->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the carousel_hook table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CarouselHookTableMap::DATABASE_NAME);
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
            CarouselHookTableMap::clearInstancePool();
            CarouselHookTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildCarouselHook or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildCarouselHook object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(CarouselHookTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(CarouselHookTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            

        CarouselHookTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            CarouselHookTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

} // CarouselHookQuery
