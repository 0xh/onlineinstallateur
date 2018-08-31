<?php

namespace LocalPickup\Model\Base;

use \Exception;
use \PDO;
use LocalPickup\Model\OrderLocalPickupAddress as ChildOrderLocalPickupAddress;
use LocalPickup\Model\OrderLocalPickupAddressQuery as ChildOrderLocalPickupAddressQuery;
use LocalPickup\Model\Map\OrderLocalPickupAddressTableMap;
use LocalPickup\Model\Thelia\Model\Order;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'order_local_pickup_address' table.
 *
 * 
 *
 * @method     ChildOrderLocalPickupAddressQuery orderByOrderId($order = Criteria::ASC) Order by the order_id column
 * @method     ChildOrderLocalPickupAddressQuery orderByLocalPickupCartId($order = Criteria::ASC) Order by the cart_id column
 * @method     ChildOrderLocalPickupAddressQuery orderByLocalPickupId($order = Criteria::ASC) Order by the local_pickup_id column
 *
 * @method     ChildOrderLocalPickupAddressQuery groupByOrderId() Group by the order_id column
 * @method     ChildOrderLocalPickupAddressQuery groupByLocalPickupCartId() Group by the cart_id column
 * @method     ChildOrderLocalPickupAddressQuery groupByLocalPickupId() Group by the local_pickup_id column
 *
 * @method     ChildOrderLocalPickupAddressQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildOrderLocalPickupAddressQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildOrderLocalPickupAddressQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildOrderLocalPickupAddressQuery leftJoinLocalPickup($relationAlias = null) Adds a LEFT JOIN clause to the query using the LocalPickup relation
 * @method     ChildOrderLocalPickupAddressQuery rightJoinLocalPickup($relationAlias = null) Adds a RIGHT JOIN clause to the query using the LocalPickup relation
 * @method     ChildOrderLocalPickupAddressQuery innerJoinLocalPickup($relationAlias = null) Adds a INNER JOIN clause to the query using the LocalPickup relation
 *
 * @method     ChildOrderLocalPickupAddressQuery leftJoinOrder($relationAlias = null) Adds a LEFT JOIN clause to the query using the Order relation
 * @method     ChildOrderLocalPickupAddressQuery rightJoinOrder($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Order relation
 * @method     ChildOrderLocalPickupAddressQuery innerJoinOrder($relationAlias = null) Adds a INNER JOIN clause to the query using the Order relation
 *
 * @method     ChildOrderLocalPickupAddress findOne(ConnectionInterface $con = null) Return the first ChildOrderLocalPickupAddress matching the query
 * @method     ChildOrderLocalPickupAddress findOneOrCreate(ConnectionInterface $con = null) Return the first ChildOrderLocalPickupAddress matching the query, or a new ChildOrderLocalPickupAddress object populated from the query conditions when no match is found
 *
 * @method     ChildOrderLocalPickupAddress findOneByOrderId(int $order_id) Return the first ChildOrderLocalPickupAddress filtered by the order_id column
 * @method     ChildOrderLocalPickupAddress findOneByLocalPickupCartId(int $cart_id) Return the first ChildOrderLocalPickupAddress filtered by the cart_id column
 * @method     ChildOrderLocalPickupAddress findOneByLocalPickupId(int $local_pickup_id) Return the first ChildOrderLocalPickupAddress filtered by the local_pickup_id column
 *
 * @method     array findByOrderId(int $order_id) Return ChildOrderLocalPickupAddress objects filtered by the order_id column
 * @method     array findByLocalPickupCartId(int $cart_id) Return ChildOrderLocalPickupAddress objects filtered by the cart_id column
 * @method     array findByLocalPickupId(int $local_pickup_id) Return ChildOrderLocalPickupAddress objects filtered by the local_pickup_id column
 *
 */
abstract class OrderLocalPickupAddressQuery extends ModelCriteria
{
    
    /**
     * Initializes internal state of \LocalPickup\Model\Base\OrderLocalPickupAddressQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'thelia', $modelName = '\\LocalPickup\\Model\\OrderLocalPickupAddress', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildOrderLocalPickupAddressQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildOrderLocalPickupAddressQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \LocalPickup\Model\OrderLocalPickupAddressQuery) {
            return $criteria;
        }
        $query = new \LocalPickup\Model\OrderLocalPickupAddressQuery();
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
     * @return ChildOrderLocalPickupAddress|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = OrderLocalPickupAddressTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(OrderLocalPickupAddressTableMap::DATABASE_NAME);
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
     * @return   ChildOrderLocalPickupAddress A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ORDER_ID, CART_ID, LOCAL_PICKUP_ID FROM order_local_pickup_address WHERE CART_ID = :p0';
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
            $obj = new ChildOrderLocalPickupAddress();
            $obj->hydrate($row);
            OrderLocalPickupAddressTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildOrderLocalPickupAddress|array|mixed the result, formatted by the current formatter
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
     * @return ChildOrderLocalPickupAddressQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(OrderLocalPickupAddressTableMap::CART_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildOrderLocalPickupAddressQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(OrderLocalPickupAddressTableMap::CART_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the order_id column
     *
     * Example usage:
     * <code>
     * $query->filterByOrderId(1234); // WHERE order_id = 1234
     * $query->filterByOrderId(array(12, 34)); // WHERE order_id IN (12, 34)
     * $query->filterByOrderId(array('min' => 12)); // WHERE order_id > 12
     * </code>
     *
     * @see       filterByOrder()
     *
     * @param     mixed $orderId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildOrderLocalPickupAddressQuery The current query, for fluid interface
     */
    public function filterByOrderId($orderId = null, $comparison = null)
    {
        if (is_array($orderId)) {
            $useMinMax = false;
            if (isset($orderId['min'])) {
                $this->addUsingAlias(OrderLocalPickupAddressTableMap::ORDER_ID, $orderId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($orderId['max'])) {
                $this->addUsingAlias(OrderLocalPickupAddressTableMap::ORDER_ID, $orderId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OrderLocalPickupAddressTableMap::ORDER_ID, $orderId, $comparison);
    }

    /**
     * Filter the query on the cart_id column
     *
     * Example usage:
     * <code>
     * $query->filterByLocalPickupCartId(1234); // WHERE cart_id = 1234
     * $query->filterByLocalPickupCartId(array(12, 34)); // WHERE cart_id IN (12, 34)
     * $query->filterByLocalPickupCartId(array('min' => 12)); // WHERE cart_id > 12
     * </code>
     *
     * @param     mixed $localPickupCartId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildOrderLocalPickupAddressQuery The current query, for fluid interface
     */
    public function filterByLocalPickupCartId($localPickupCartId = null, $comparison = null)
    {
        if (is_array($localPickupCartId)) {
            $useMinMax = false;
            if (isset($localPickupCartId['min'])) {
                $this->addUsingAlias(OrderLocalPickupAddressTableMap::CART_ID, $localPickupCartId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($localPickupCartId['max'])) {
                $this->addUsingAlias(OrderLocalPickupAddressTableMap::CART_ID, $localPickupCartId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OrderLocalPickupAddressTableMap::CART_ID, $localPickupCartId, $comparison);
    }

    /**
     * Filter the query on the local_pickup_id column
     *
     * Example usage:
     * <code>
     * $query->filterByLocalPickupId(1234); // WHERE local_pickup_id = 1234
     * $query->filterByLocalPickupId(array(12, 34)); // WHERE local_pickup_id IN (12, 34)
     * $query->filterByLocalPickupId(array('min' => 12)); // WHERE local_pickup_id > 12
     * </code>
     *
     * @see       filterByLocalPickup()
     *
     * @param     mixed $localPickupId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildOrderLocalPickupAddressQuery The current query, for fluid interface
     */
    public function filterByLocalPickupId($localPickupId = null, $comparison = null)
    {
        if (is_array($localPickupId)) {
            $useMinMax = false;
            if (isset($localPickupId['min'])) {
                $this->addUsingAlias(OrderLocalPickupAddressTableMap::LOCAL_PICKUP_ID, $localPickupId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($localPickupId['max'])) {
                $this->addUsingAlias(OrderLocalPickupAddressTableMap::LOCAL_PICKUP_ID, $localPickupId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OrderLocalPickupAddressTableMap::LOCAL_PICKUP_ID, $localPickupId, $comparison);
    }

    /**
     * Filter the query by a related \LocalPickup\Model\LocalPickup object
     *
     * @param \LocalPickup\Model\LocalPickup|ObjectCollection $localPickup The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildOrderLocalPickupAddressQuery The current query, for fluid interface
     */
    public function filterByLocalPickup($localPickup, $comparison = null)
    {
        if ($localPickup instanceof \LocalPickup\Model\LocalPickup) {
            return $this
                ->addUsingAlias(OrderLocalPickupAddressTableMap::LOCAL_PICKUP_ID, $localPickup->getId(), $comparison);
        } elseif ($localPickup instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(OrderLocalPickupAddressTableMap::LOCAL_PICKUP_ID, $localPickup->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByLocalPickup() only accepts arguments of type \LocalPickup\Model\LocalPickup or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the LocalPickup relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildOrderLocalPickupAddressQuery The current query, for fluid interface
     */
    public function joinLocalPickup($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('LocalPickup');

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
            $this->addJoinObject($join, 'LocalPickup');
        }

        return $this;
    }

    /**
     * Use the LocalPickup relation LocalPickup object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \LocalPickup\Model\LocalPickupQuery A secondary query class using the current class as primary query
     */
    public function useLocalPickupQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinLocalPickup($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'LocalPickup', '\LocalPickup\Model\LocalPickupQuery');
    }

    /**
     * Filter the query by a related \LocalPickup\Model\Thelia\Model\Order object
     *
     * @param \LocalPickup\Model\Thelia\Model\Order|ObjectCollection $order The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildOrderLocalPickupAddressQuery The current query, for fluid interface
     */
    public function filterByOrder($order, $comparison = null)
    {
        if ($order instanceof \LocalPickup\Model\Thelia\Model\Order) {
            return $this
                ->addUsingAlias(OrderLocalPickupAddressTableMap::ORDER_ID, $order->getId(), $comparison);
        } elseif ($order instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(OrderLocalPickupAddressTableMap::ORDER_ID, $order->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByOrder() only accepts arguments of type \LocalPickup\Model\Thelia\Model\Order or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Order relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildOrderLocalPickupAddressQuery The current query, for fluid interface
     */
    public function joinOrder($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Order');

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
            $this->addJoinObject($join, 'Order');
        }

        return $this;
    }

    /**
     * Use the Order relation Order object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \LocalPickup\Model\Thelia\Model\OrderQuery A secondary query class using the current class as primary query
     */
    public function useOrderQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinOrder($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Order', '\LocalPickup\Model\Thelia\Model\OrderQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildOrderLocalPickupAddress $orderLocalPickupAddress Object to remove from the list of results
     *
     * @return ChildOrderLocalPickupAddressQuery The current query, for fluid interface
     */
    public function prune($orderLocalPickupAddress = null)
    {
        if ($orderLocalPickupAddress) {
            $this->addUsingAlias(OrderLocalPickupAddressTableMap::CART_ID, $orderLocalPickupAddress->getLocalPickupCartId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the order_local_pickup_address table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(OrderLocalPickupAddressTableMap::DATABASE_NAME);
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
            OrderLocalPickupAddressTableMap::clearInstancePool();
            OrderLocalPickupAddressTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildOrderLocalPickupAddress or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildOrderLocalPickupAddress object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(OrderLocalPickupAddressTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(OrderLocalPickupAddressTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            

        OrderLocalPickupAddressTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            OrderLocalPickupAddressTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

} // OrderLocalPickupAddressQuery
