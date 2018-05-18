<?php

namespace RevenueDashboard\Model\Base;

use \Exception;
use \PDO;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;
use RevenueDashboard\Model\OrderRevenue as ChildOrderRevenue;
use RevenueDashboard\Model\OrderRevenueQuery as ChildOrderRevenueQuery;
use RevenueDashboard\Model\Map\OrderRevenueTableMap;

/**
 * Base class that represents a query for the 'order_revenue' table.
 *
 * 
 *
 * @method     ChildOrderRevenueQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildOrderRevenueQuery orderByOrderId($order = Criteria::ASC) Order by the order_id column
 * @method     ChildOrderRevenueQuery orderByDeliveryCost($order = Criteria::ASC) Order by the delivery_cost column
 * @method     ChildOrderRevenueQuery orderByDeliveryMethod($order = Criteria::ASC) Order by the delivery_method column
 * @method     ChildOrderRevenueQuery orderByPartnerId($order = Criteria::ASC) Order by the partner_id column
 * @method     ChildOrderRevenueQuery orderByPaymentProcessorCost($order = Criteria::ASC) Order by the payment_processor_cost column
 * @method     ChildOrderRevenueQuery orderByPrice($order = Criteria::ASC) Order by the price column
 * @method     ChildOrderRevenueQuery orderByQuantity($order = Criteria::ASC) Order by the quantity column
 * @method     ChildOrderRevenueQuery orderByPurchasePrice($order = Criteria::ASC) Order by the purchase_price column
 * @method     ChildOrderRevenueQuery orderByTotalPurchasePrice($order = Criteria::ASC) Order by the total_purchase_price column
 * @method     ChildOrderRevenueQuery orderByRevenue($order = Criteria::ASC) Order by the revenue column
 * @method     ChildOrderRevenueQuery orderByComment($order = Criteria::ASC) Order by the comment column
 *
 * @method     ChildOrderRevenueQuery groupById() Group by the id column
 * @method     ChildOrderRevenueQuery groupByOrderId() Group by the order_id column
 * @method     ChildOrderRevenueQuery groupByDeliveryCost() Group by the delivery_cost column
 * @method     ChildOrderRevenueQuery groupByDeliveryMethod() Group by the delivery_method column
 * @method     ChildOrderRevenueQuery groupByPartnerId() Group by the partner_id column
 * @method     ChildOrderRevenueQuery groupByPaymentProcessorCost() Group by the payment_processor_cost column
 * @method     ChildOrderRevenueQuery groupByPrice() Group by the price column
 * @method     ChildOrderRevenueQuery groupByQuantity() Group by the quantity column
 * @method     ChildOrderRevenueQuery groupByPurchasePrice() Group by the purchase_price column
 * @method     ChildOrderRevenueQuery groupByTotalPurchasePrice() Group by the total_purchase_price column
 * @method     ChildOrderRevenueQuery groupByRevenue() Group by the revenue column
 * @method     ChildOrderRevenueQuery groupByComment() Group by the comment column
 *
 * @method     ChildOrderRevenueQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildOrderRevenueQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildOrderRevenueQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildOrderRevenue findOne(ConnectionInterface $con = null) Return the first ChildOrderRevenue matching the query
 * @method     ChildOrderRevenue findOneOrCreate(ConnectionInterface $con = null) Return the first ChildOrderRevenue matching the query, or a new ChildOrderRevenue object populated from the query conditions when no match is found
 *
 * @method     ChildOrderRevenue findOneById(int $id) Return the first ChildOrderRevenue filtered by the id column
 * @method     ChildOrderRevenue findOneByOrderId(int $order_id) Return the first ChildOrderRevenue filtered by the order_id column
 * @method     ChildOrderRevenue findOneByDeliveryCost(string $delivery_cost) Return the first ChildOrderRevenue filtered by the delivery_cost column
 * @method     ChildOrderRevenue findOneByDeliveryMethod(string $delivery_method) Return the first ChildOrderRevenue filtered by the delivery_method column
 * @method     ChildOrderRevenue findOneByPartnerId(int $partner_id) Return the first ChildOrderRevenue filtered by the partner_id column
 * @method     ChildOrderRevenue findOneByPaymentProcessorCost(string $payment_processor_cost) Return the first ChildOrderRevenue filtered by the payment_processor_cost column
 * @method     ChildOrderRevenue findOneByPrice(string $price) Return the first ChildOrderRevenue filtered by the price column
 * @method     ChildOrderRevenue findOneByQuantity(int $quantity) Return the first ChildOrderRevenue filtered by the quantity column
 * @method     ChildOrderRevenue findOneByPurchasePrice(string $purchase_price) Return the first ChildOrderRevenue filtered by the purchase_price column
 * @method     ChildOrderRevenue findOneByTotalPurchasePrice(string $total_purchase_price) Return the first ChildOrderRevenue filtered by the total_purchase_price column
 * @method     ChildOrderRevenue findOneByRevenue(string $revenue) Return the first ChildOrderRevenue filtered by the revenue column
 * @method     ChildOrderRevenue findOneByComment(string $comment) Return the first ChildOrderRevenue filtered by the comment column
 *
 * @method     array findById(int $id) Return ChildOrderRevenue objects filtered by the id column
 * @method     array findByOrderId(int $order_id) Return ChildOrderRevenue objects filtered by the order_id column
 * @method     array findByDeliveryCost(string $delivery_cost) Return ChildOrderRevenue objects filtered by the delivery_cost column
 * @method     array findByDeliveryMethod(string $delivery_method) Return ChildOrderRevenue objects filtered by the delivery_method column
 * @method     array findByPartnerId(int $partner_id) Return ChildOrderRevenue objects filtered by the partner_id column
 * @method     array findByPaymentProcessorCost(string $payment_processor_cost) Return ChildOrderRevenue objects filtered by the payment_processor_cost column
 * @method     array findByPrice(string $price) Return ChildOrderRevenue objects filtered by the price column
 * @method     array findByQuantity(int $quantity) Return ChildOrderRevenue objects filtered by the quantity column
 * @method     array findByPurchasePrice(string $purchase_price) Return ChildOrderRevenue objects filtered by the purchase_price column
 * @method     array findByTotalPurchasePrice(string $total_purchase_price) Return ChildOrderRevenue objects filtered by the total_purchase_price column
 * @method     array findByRevenue(string $revenue) Return ChildOrderRevenue objects filtered by the revenue column
 * @method     array findByComment(string $comment) Return ChildOrderRevenue objects filtered by the comment column
 *
 */
abstract class OrderRevenueQuery extends ModelCriteria
{
    
    /**
     * Initializes internal state of \RevenueDashboard\Model\Base\OrderRevenueQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'thelia', $modelName = '\\RevenueDashboard\\Model\\OrderRevenue', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildOrderRevenueQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildOrderRevenueQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \RevenueDashboard\Model\OrderRevenueQuery) {
            return $criteria;
        }
        $query = new \RevenueDashboard\Model\OrderRevenueQuery();
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
     * @return ChildOrderRevenue|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = OrderRevenueTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(OrderRevenueTableMap::DATABASE_NAME);
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
     * @return   ChildOrderRevenue A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ID, ORDER_ID, DELIVERY_COST, DELIVERY_METHOD, PARTNER_ID, PAYMENT_PROCESSOR_COST, PRICE, QUANTITY, PURCHASE_PRICE, TOTAL_PURCHASE_PRICE, REVENUE, COMMENT FROM order_revenue WHERE ID = :p0';
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
            $obj = new ChildOrderRevenue();
            $obj->hydrate($row);
            OrderRevenueTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildOrderRevenue|array|mixed the result, formatted by the current formatter
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
     * @return ChildOrderRevenueQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(OrderRevenueTableMap::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildOrderRevenueQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(OrderRevenueTableMap::ID, $keys, Criteria::IN);
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
     * @return ChildOrderRevenueQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(OrderRevenueTableMap::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(OrderRevenueTableMap::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OrderRevenueTableMap::ID, $id, $comparison);
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
     * @param     mixed $orderId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildOrderRevenueQuery The current query, for fluid interface
     */
    public function filterByOrderId($orderId = null, $comparison = null)
    {
        if (is_array($orderId)) {
            $useMinMax = false;
            if (isset($orderId['min'])) {
                $this->addUsingAlias(OrderRevenueTableMap::ORDER_ID, $orderId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($orderId['max'])) {
                $this->addUsingAlias(OrderRevenueTableMap::ORDER_ID, $orderId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OrderRevenueTableMap::ORDER_ID, $orderId, $comparison);
    }

    /**
     * Filter the query on the delivery_cost column
     *
     * Example usage:
     * <code>
     * $query->filterByDeliveryCost(1234); // WHERE delivery_cost = 1234
     * $query->filterByDeliveryCost(array(12, 34)); // WHERE delivery_cost IN (12, 34)
     * $query->filterByDeliveryCost(array('min' => 12)); // WHERE delivery_cost > 12
     * </code>
     *
     * @param     mixed $deliveryCost The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildOrderRevenueQuery The current query, for fluid interface
     */
    public function filterByDeliveryCost($deliveryCost = null, $comparison = null)
    {
        if (is_array($deliveryCost)) {
            $useMinMax = false;
            if (isset($deliveryCost['min'])) {
                $this->addUsingAlias(OrderRevenueTableMap::DELIVERY_COST, $deliveryCost['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($deliveryCost['max'])) {
                $this->addUsingAlias(OrderRevenueTableMap::DELIVERY_COST, $deliveryCost['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OrderRevenueTableMap::DELIVERY_COST, $deliveryCost, $comparison);
    }

    /**
     * Filter the query on the delivery_method column
     *
     * Example usage:
     * <code>
     * $query->filterByDeliveryMethod('fooValue');   // WHERE delivery_method = 'fooValue'
     * $query->filterByDeliveryMethod('%fooValue%'); // WHERE delivery_method LIKE '%fooValue%'
     * </code>
     *
     * @param     string $deliveryMethod The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildOrderRevenueQuery The current query, for fluid interface
     */
    public function filterByDeliveryMethod($deliveryMethod = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($deliveryMethod)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $deliveryMethod)) {
                $deliveryMethod = str_replace('*', '%', $deliveryMethod);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(OrderRevenueTableMap::DELIVERY_METHOD, $deliveryMethod, $comparison);
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
     * @return ChildOrderRevenueQuery The current query, for fluid interface
     */
    public function filterByPartnerId($partnerId = null, $comparison = null)
    {
        if (is_array($partnerId)) {
            $useMinMax = false;
            if (isset($partnerId['min'])) {
                $this->addUsingAlias(OrderRevenueTableMap::PARTNER_ID, $partnerId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($partnerId['max'])) {
                $this->addUsingAlias(OrderRevenueTableMap::PARTNER_ID, $partnerId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OrderRevenueTableMap::PARTNER_ID, $partnerId, $comparison);
    }

    /**
     * Filter the query on the payment_processor_cost column
     *
     * Example usage:
     * <code>
     * $query->filterByPaymentProcessorCost(1234); // WHERE payment_processor_cost = 1234
     * $query->filterByPaymentProcessorCost(array(12, 34)); // WHERE payment_processor_cost IN (12, 34)
     * $query->filterByPaymentProcessorCost(array('min' => 12)); // WHERE payment_processor_cost > 12
     * </code>
     *
     * @param     mixed $paymentProcessorCost The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildOrderRevenueQuery The current query, for fluid interface
     */
    public function filterByPaymentProcessorCost($paymentProcessorCost = null, $comparison = null)
    {
        if (is_array($paymentProcessorCost)) {
            $useMinMax = false;
            if (isset($paymentProcessorCost['min'])) {
                $this->addUsingAlias(OrderRevenueTableMap::PAYMENT_PROCESSOR_COST, $paymentProcessorCost['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($paymentProcessorCost['max'])) {
                $this->addUsingAlias(OrderRevenueTableMap::PAYMENT_PROCESSOR_COST, $paymentProcessorCost['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OrderRevenueTableMap::PAYMENT_PROCESSOR_COST, $paymentProcessorCost, $comparison);
    }

    /**
     * Filter the query on the price column
     *
     * Example usage:
     * <code>
     * $query->filterByPrice(1234); // WHERE price = 1234
     * $query->filterByPrice(array(12, 34)); // WHERE price IN (12, 34)
     * $query->filterByPrice(array('min' => 12)); // WHERE price > 12
     * </code>
     *
     * @param     mixed $price The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildOrderRevenueQuery The current query, for fluid interface
     */
    public function filterByPrice($price = null, $comparison = null)
    {
        if (is_array($price)) {
            $useMinMax = false;
            if (isset($price['min'])) {
                $this->addUsingAlias(OrderRevenueTableMap::PRICE, $price['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($price['max'])) {
                $this->addUsingAlias(OrderRevenueTableMap::PRICE, $price['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OrderRevenueTableMap::PRICE, $price, $comparison);
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
     * @return ChildOrderRevenueQuery The current query, for fluid interface
     */
    public function filterByQuantity($quantity = null, $comparison = null)
    {
        if (is_array($quantity)) {
            $useMinMax = false;
            if (isset($quantity['min'])) {
                $this->addUsingAlias(OrderRevenueTableMap::QUANTITY, $quantity['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($quantity['max'])) {
                $this->addUsingAlias(OrderRevenueTableMap::QUANTITY, $quantity['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OrderRevenueTableMap::QUANTITY, $quantity, $comparison);
    }

    /**
     * Filter the query on the purchase_price column
     *
     * Example usage:
     * <code>
     * $query->filterByPurchasePrice(1234); // WHERE purchase_price = 1234
     * $query->filterByPurchasePrice(array(12, 34)); // WHERE purchase_price IN (12, 34)
     * $query->filterByPurchasePrice(array('min' => 12)); // WHERE purchase_price > 12
     * </code>
     *
     * @param     mixed $purchasePrice The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildOrderRevenueQuery The current query, for fluid interface
     */
    public function filterByPurchasePrice($purchasePrice = null, $comparison = null)
    {
        if (is_array($purchasePrice)) {
            $useMinMax = false;
            if (isset($purchasePrice['min'])) {
                $this->addUsingAlias(OrderRevenueTableMap::PURCHASE_PRICE, $purchasePrice['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($purchasePrice['max'])) {
                $this->addUsingAlias(OrderRevenueTableMap::PURCHASE_PRICE, $purchasePrice['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OrderRevenueTableMap::PURCHASE_PRICE, $purchasePrice, $comparison);
    }

    /**
     * Filter the query on the total_purchase_price column
     *
     * Example usage:
     * <code>
     * $query->filterByTotalPurchasePrice(1234); // WHERE total_purchase_price = 1234
     * $query->filterByTotalPurchasePrice(array(12, 34)); // WHERE total_purchase_price IN (12, 34)
     * $query->filterByTotalPurchasePrice(array('min' => 12)); // WHERE total_purchase_price > 12
     * </code>
     *
     * @param     mixed $totalPurchasePrice The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildOrderRevenueQuery The current query, for fluid interface
     */
    public function filterByTotalPurchasePrice($totalPurchasePrice = null, $comparison = null)
    {
        if (is_array($totalPurchasePrice)) {
            $useMinMax = false;
            if (isset($totalPurchasePrice['min'])) {
                $this->addUsingAlias(OrderRevenueTableMap::TOTAL_PURCHASE_PRICE, $totalPurchasePrice['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($totalPurchasePrice['max'])) {
                $this->addUsingAlias(OrderRevenueTableMap::TOTAL_PURCHASE_PRICE, $totalPurchasePrice['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OrderRevenueTableMap::TOTAL_PURCHASE_PRICE, $totalPurchasePrice, $comparison);
    }

    /**
     * Filter the query on the revenue column
     *
     * Example usage:
     * <code>
     * $query->filterByRevenue(1234); // WHERE revenue = 1234
     * $query->filterByRevenue(array(12, 34)); // WHERE revenue IN (12, 34)
     * $query->filterByRevenue(array('min' => 12)); // WHERE revenue > 12
     * </code>
     *
     * @param     mixed $revenue The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildOrderRevenueQuery The current query, for fluid interface
     */
    public function filterByRevenue($revenue = null, $comparison = null)
    {
        if (is_array($revenue)) {
            $useMinMax = false;
            if (isset($revenue['min'])) {
                $this->addUsingAlias(OrderRevenueTableMap::REVENUE, $revenue['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($revenue['max'])) {
                $this->addUsingAlias(OrderRevenueTableMap::REVENUE, $revenue['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OrderRevenueTableMap::REVENUE, $revenue, $comparison);
    }

    /**
     * Filter the query on the comment column
     *
     * Example usage:
     * <code>
     * $query->filterByComment('fooValue');   // WHERE comment = 'fooValue'
     * $query->filterByComment('%fooValue%'); // WHERE comment LIKE '%fooValue%'
     * </code>
     *
     * @param     string $comment The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildOrderRevenueQuery The current query, for fluid interface
     */
    public function filterByComment($comment = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($comment)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $comment)) {
                $comment = str_replace('*', '%', $comment);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(OrderRevenueTableMap::COMMENT, $comment, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildOrderRevenue $orderRevenue Object to remove from the list of results
     *
     * @return ChildOrderRevenueQuery The current query, for fluid interface
     */
    public function prune($orderRevenue = null)
    {
        if ($orderRevenue) {
            $this->addUsingAlias(OrderRevenueTableMap::ID, $orderRevenue->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the order_revenue table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(OrderRevenueTableMap::DATABASE_NAME);
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
            OrderRevenueTableMap::clearInstancePool();
            OrderRevenueTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildOrderRevenue or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildOrderRevenue object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(OrderRevenueTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(OrderRevenueTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            

        OrderRevenueTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            OrderRevenueTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

} // OrderRevenueQuery
