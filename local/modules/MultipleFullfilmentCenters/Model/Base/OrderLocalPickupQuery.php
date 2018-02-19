<?php

namespace MultipleFullfilmentCenters\Model\Base;

use \Exception;
use \PDO;
use MultipleFullfilmentCenters\Model\OrderLocalPickup as ChildOrderLocalPickup;
use MultipleFullfilmentCenters\Model\OrderLocalPickupQuery as ChildOrderLocalPickupQuery;
use MultipleFullfilmentCenters\Model\Map\OrderLocalPickupTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'order_local_pickup' table.
 *
 * 
 *
 * @method     ChildOrderLocalPickupQuery orderByOrderId($order = Criteria::ASC) Order by the order_id column
 * @method     ChildOrderLocalPickupQuery orderByCartId($order = Criteria::ASC) Order by the cart_id column
 * @method     ChildOrderLocalPickupQuery orderByProductId($order = Criteria::ASC) Order by the product_id column
 * @method     ChildOrderLocalPickupQuery orderByFulfilmentCenterId($order = Criteria::ASC) Order by the fulfilment_center_id column
 * @method     ChildOrderLocalPickupQuery orderByQuantity($order = Criteria::ASC) Order by the quantity column
 *
 * @method     ChildOrderLocalPickupQuery groupByOrderId() Group by the order_id column
 * @method     ChildOrderLocalPickupQuery groupByCartId() Group by the cart_id column
 * @method     ChildOrderLocalPickupQuery groupByProductId() Group by the product_id column
 * @method     ChildOrderLocalPickupQuery groupByFulfilmentCenterId() Group by the fulfilment_center_id column
 * @method     ChildOrderLocalPickupQuery groupByQuantity() Group by the quantity column
 *
 * @method     ChildOrderLocalPickupQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildOrderLocalPickupQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildOrderLocalPickupQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildOrderLocalPickupQuery leftJoinFulfilmentCenter($relationAlias = null) Adds a LEFT JOIN clause to the query using the FulfilmentCenter relation
 * @method     ChildOrderLocalPickupQuery rightJoinFulfilmentCenter($relationAlias = null) Adds a RIGHT JOIN clause to the query using the FulfilmentCenter relation
 * @method     ChildOrderLocalPickupQuery innerJoinFulfilmentCenter($relationAlias = null) Adds a INNER JOIN clause to the query using the FulfilmentCenter relation
 *
 * @method     ChildOrderLocalPickupQuery leftJoinOrder($relationAlias = null) Adds a LEFT JOIN clause to the query using the Order relation
 * @method     ChildOrderLocalPickupQuery rightJoinOrder($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Order relation
 * @method     ChildOrderLocalPickupQuery innerJoinOrder($relationAlias = null) Adds a INNER JOIN clause to the query using the Order relation
 *
 * @method     ChildOrderLocalPickupQuery leftJoinProduct($relationAlias = null) Adds a LEFT JOIN clause to the query using the Product relation
 * @method     ChildOrderLocalPickupQuery rightJoinProduct($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Product relation
 * @method     ChildOrderLocalPickupQuery innerJoinProduct($relationAlias = null) Adds a INNER JOIN clause to the query using the Product relation
 *
 * @method     ChildOrderLocalPickup findOne(ConnectionInterface $con = null) Return the first ChildOrderLocalPickup matching the query
 * @method     ChildOrderLocalPickup findOneOrCreate(ConnectionInterface $con = null) Return the first ChildOrderLocalPickup matching the query, or a new ChildOrderLocalPickup object populated from the query conditions when no match is found
 *
 * @method     ChildOrderLocalPickup findOneByOrderId(int $order_id) Return the first ChildOrderLocalPickup filtered by the order_id column
 * @method     ChildOrderLocalPickup findOneByCartId(int $cart_id) Return the first ChildOrderLocalPickup filtered by the cart_id column
 * @method     ChildOrderLocalPickup findOneByProductId(int $product_id) Return the first ChildOrderLocalPickup filtered by the product_id column
 * @method     ChildOrderLocalPickup findOneByFulfilmentCenterId(int $fulfilment_center_id) Return the first ChildOrderLocalPickup filtered by the fulfilment_center_id column
 * @method     ChildOrderLocalPickup findOneByQuantity(int $quantity) Return the first ChildOrderLocalPickup filtered by the quantity column
 *
 * @method     array findByOrderId(int $order_id) Return ChildOrderLocalPickup objects filtered by the order_id column
 * @method     array findByCartId(int $cart_id) Return ChildOrderLocalPickup objects filtered by the cart_id column
 * @method     array findByProductId(int $product_id) Return ChildOrderLocalPickup objects filtered by the product_id column
 * @method     array findByFulfilmentCenterId(int $fulfilment_center_id) Return ChildOrderLocalPickup objects filtered by the fulfilment_center_id column
 * @method     array findByQuantity(int $quantity) Return ChildOrderLocalPickup objects filtered by the quantity column
 *
 */
abstract class OrderLocalPickupQuery extends ModelCriteria
{
    
    /**
     * Initializes internal state of \MultipleFullfilmentCenters\Model\Base\OrderLocalPickupQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'thelia', $modelName = '\\MultipleFullfilmentCenters\\Model\\OrderLocalPickup', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildOrderLocalPickupQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildOrderLocalPickupQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \MultipleFullfilmentCenters\Model\OrderLocalPickupQuery) {
            return $criteria;
        }
        $query = new \MultipleFullfilmentCenters\Model\OrderLocalPickupQuery();
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
     * @param array[$cart_id, $product_id] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildOrderLocalPickup|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = OrderLocalPickupTableMap::getInstanceFromPool(serialize(array((string) $key[0], (string) $key[1]))))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(OrderLocalPickupTableMap::DATABASE_NAME);
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
     * @return   ChildOrderLocalPickup A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ORDER_ID, CART_ID, PRODUCT_ID, FULFILMENT_CENTER_ID, QUANTITY FROM order_local_pickup WHERE CART_ID = :p0 AND PRODUCT_ID = :p1';
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
            $obj = new ChildOrderLocalPickup();
            $obj->hydrate($row);
            OrderLocalPickupTableMap::addInstanceToPool($obj, serialize(array((string) $key[0], (string) $key[1])));
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
     * @return ChildOrderLocalPickup|array|mixed the result, formatted by the current formatter
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
     * @return ChildOrderLocalPickupQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(OrderLocalPickupTableMap::CART_ID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(OrderLocalPickupTableMap::PRODUCT_ID, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildOrderLocalPickupQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(OrderLocalPickupTableMap::CART_ID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(OrderLocalPickupTableMap::PRODUCT_ID, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $this->addOr($cton0);
        }

        return $this;
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
     * @return ChildOrderLocalPickupQuery The current query, for fluid interface
     */
    public function filterByOrderId($orderId = null, $comparison = null)
    {
        if (is_array($orderId)) {
            $useMinMax = false;
            if (isset($orderId['min'])) {
                $this->addUsingAlias(OrderLocalPickupTableMap::ORDER_ID, $orderId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($orderId['max'])) {
                $this->addUsingAlias(OrderLocalPickupTableMap::ORDER_ID, $orderId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OrderLocalPickupTableMap::ORDER_ID, $orderId, $comparison);
    }

    /**
     * Filter the query on the cart_id column
     *
     * Example usage:
     * <code>
     * $query->filterByCartId(1234); // WHERE cart_id = 1234
     * $query->filterByCartId(array(12, 34)); // WHERE cart_id IN (12, 34)
     * $query->filterByCartId(array('min' => 12)); // WHERE cart_id > 12
     * </code>
     *
     * @param     mixed $cartId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildOrderLocalPickupQuery The current query, for fluid interface
     */
    public function filterByCartId($cartId = null, $comparison = null)
    {
        if (is_array($cartId)) {
            $useMinMax = false;
            if (isset($cartId['min'])) {
                $this->addUsingAlias(OrderLocalPickupTableMap::CART_ID, $cartId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($cartId['max'])) {
                $this->addUsingAlias(OrderLocalPickupTableMap::CART_ID, $cartId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OrderLocalPickupTableMap::CART_ID, $cartId, $comparison);
    }

    /**
     * Filter the query on the product_id column
     *
     * Example usage:
     * <code>
     * $query->filterByProductId(1234); // WHERE product_id = 1234
     * $query->filterByProductId(array(12, 34)); // WHERE product_id IN (12, 34)
     * $query->filterByProductId(array('min' => 12)); // WHERE product_id > 12
     * </code>
     *
     * @see       filterByProduct()
     *
     * @param     mixed $productId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildOrderLocalPickupQuery The current query, for fluid interface
     */
    public function filterByProductId($productId = null, $comparison = null)
    {
        if (is_array($productId)) {
            $useMinMax = false;
            if (isset($productId['min'])) {
                $this->addUsingAlias(OrderLocalPickupTableMap::PRODUCT_ID, $productId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($productId['max'])) {
                $this->addUsingAlias(OrderLocalPickupTableMap::PRODUCT_ID, $productId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OrderLocalPickupTableMap::PRODUCT_ID, $productId, $comparison);
    }

    /**
     * Filter the query on the fulfilment_center_id column
     *
     * Example usage:
     * <code>
     * $query->filterByFulfilmentCenterId(1234); // WHERE fulfilment_center_id = 1234
     * $query->filterByFulfilmentCenterId(array(12, 34)); // WHERE fulfilment_center_id IN (12, 34)
     * $query->filterByFulfilmentCenterId(array('min' => 12)); // WHERE fulfilment_center_id > 12
     * </code>
     *
     * @see       filterByFulfilmentCenter()
     *
     * @param     mixed $fulfilmentCenterId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildOrderLocalPickupQuery The current query, for fluid interface
     */
    public function filterByFulfilmentCenterId($fulfilmentCenterId = null, $comparison = null)
    {
        if (is_array($fulfilmentCenterId)) {
            $useMinMax = false;
            if (isset($fulfilmentCenterId['min'])) {
                $this->addUsingAlias(OrderLocalPickupTableMap::FULFILMENT_CENTER_ID, $fulfilmentCenterId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($fulfilmentCenterId['max'])) {
                $this->addUsingAlias(OrderLocalPickupTableMap::FULFILMENT_CENTER_ID, $fulfilmentCenterId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OrderLocalPickupTableMap::FULFILMENT_CENTER_ID, $fulfilmentCenterId, $comparison);
    }

    /**
     * Filter the query on the quantity column
     *
     * Example usage:
     * <code>
     * $query->filterByQuantity(1234); // WHERE quantity = 1234
     * $query->filterByQuantity(array(12, 34)); // WHERE quantity IN (12, 34)
     * $query->filterByQuantity(array('min' => 12)); // WHERE quantity > 12
     * </code>
     *
     * @param     mixed $quantity The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildOrderLocalPickupQuery The current query, for fluid interface
     */
    public function filterByQuantity($quantity = null, $comparison = null)
    {
        if (is_array($quantity)) {
            $useMinMax = false;
            if (isset($quantity['min'])) {
                $this->addUsingAlias(OrderLocalPickupTableMap::QUANTITY, $quantity['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($quantity['max'])) {
                $this->addUsingAlias(OrderLocalPickupTableMap::QUANTITY, $quantity['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OrderLocalPickupTableMap::QUANTITY, $quantity, $comparison);
    }

    /**
     * Filter the query by a related \MultipleFullfilmentCenters\Model\FulfilmentCenter object
     *
     * @param \MultipleFullfilmentCenters\Model\FulfilmentCenter|ObjectCollection $fulfilmentCenter The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildOrderLocalPickupQuery The current query, for fluid interface
     */
    public function filterByFulfilmentCenter($fulfilmentCenter, $comparison = null)
    {
        if ($fulfilmentCenter instanceof \MultipleFullfilmentCenters\Model\FulfilmentCenter) {
            return $this
                ->addUsingAlias(OrderLocalPickupTableMap::FULFILMENT_CENTER_ID, $fulfilmentCenter->getId(), $comparison);
        } elseif ($fulfilmentCenter instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(OrderLocalPickupTableMap::FULFILMENT_CENTER_ID, $fulfilmentCenter->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByFulfilmentCenter() only accepts arguments of type \MultipleFullfilmentCenters\Model\FulfilmentCenter or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the FulfilmentCenter relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildOrderLocalPickupQuery The current query, for fluid interface
     */
    public function joinFulfilmentCenter($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('FulfilmentCenter');

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
            $this->addJoinObject($join, 'FulfilmentCenter');
        }

        return $this;
    }

    /**
     * Use the FulfilmentCenter relation FulfilmentCenter object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \MultipleFullfilmentCenters\Model\FulfilmentCenterQuery A secondary query class using the current class as primary query
     */
    public function useFulfilmentCenterQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinFulfilmentCenter($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'FulfilmentCenter', '\MultipleFullfilmentCenters\Model\FulfilmentCenterQuery');
    }

    /**
     * Filter the query by a related \MultipleFullfilmentCenters\Model\Order object
     *
     * @param \MultipleFullfilmentCenters\Model\Order|ObjectCollection $order The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildOrderLocalPickupQuery The current query, for fluid interface
     */
    public function filterByOrder($order, $comparison = null)
    {
        if ($order instanceof \Propel\Model\Order) {
            return $this
                ->addUsingAlias(OrderLocalPickupTableMap::ORDER_ID, $order->getId(), $comparison);
        } elseif ($order instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(OrderLocalPickupTableMap::ORDER_ID, $order->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByOrder() only accepts arguments of type \MultipleFullfilmentCenters\Model\Order or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Order relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildOrderLocalPickupQuery The current query, for fluid interface
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
     * @return   \MultipleFullfilmentCenters\Model\OrderQuery A secondary query class using the current class as primary query
     */
    public function useOrderQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinOrder($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Order', '\MultipleFullfilmentCenters\Model\OrderQuery');
    }

    /**
     * Filter the query by a related \MultipleFullfilmentCenters\Model\Product object
     *
     * @param \MultipleFullfilmentCenters\Model\Product|ObjectCollection $product The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildOrderLocalPickupQuery The current query, for fluid interface
     */
    public function filterByProduct($product, $comparison = null)
    {
        if ($product instanceof \MultipleFullfilmentCenters\Model\Product) {
            return $this
                ->addUsingAlias(OrderLocalPickupTableMap::PRODUCT_ID, $product->getId(), $comparison);
        } elseif ($product instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(OrderLocalPickupTableMap::PRODUCT_ID, $product->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByProduct() only accepts arguments of type \MultipleFullfilmentCenters\Model\Product or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Product relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildOrderLocalPickupQuery The current query, for fluid interface
     */
    public function joinProduct($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Product');

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
            $this->addJoinObject($join, 'Product');
        }

        return $this;
    }

    /**
     * Use the Product relation Product object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \MultipleFullfilmentCenters\Model\ProductQuery A secondary query class using the current class as primary query
     */
    public function useProductQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinProduct($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Product', '\MultipleFullfilmentCenters\Model\ProductQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildOrderLocalPickup $orderLocalPickup Object to remove from the list of results
     *
     * @return ChildOrderLocalPickupQuery The current query, for fluid interface
     */
    public function prune($orderLocalPickup = null)
    {
        if ($orderLocalPickup) {
            $this->addCond('pruneCond0', $this->getAliasedColName(OrderLocalPickupTableMap::CART_ID), $orderLocalPickup->getCartId(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(OrderLocalPickupTableMap::PRODUCT_ID), $orderLocalPickup->getProductId(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the order_local_pickup table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(OrderLocalPickupTableMap::DATABASE_NAME);
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
            OrderLocalPickupTableMap::clearInstancePool();
            OrderLocalPickupTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildOrderLocalPickup or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildOrderLocalPickup object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(OrderLocalPickupTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(OrderLocalPickupTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            

        OrderLocalPickupTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            OrderLocalPickupTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

} // OrderLocalPickupQuery
