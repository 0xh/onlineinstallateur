<?php

namespace RevenueDashboard\Model\Base;

use \Exception;
use \PDO;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;
use RevenueDashboard\Model\OrderProductRevenue as ChildOrderProductRevenue;
use RevenueDashboard\Model\OrderProductRevenueQuery as ChildOrderProductRevenueQuery;
use RevenueDashboard\Model\Map\OrderProductRevenueTableMap;

/**
 * Base class that represents a query for the 'order_product_revenue' table.
 *
 * 
 *
 * @method     ChildOrderProductRevenueQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildOrderProductRevenueQuery orderByOrderId($order = Criteria::ASC) Order by the order_id column
 * @method     ChildOrderProductRevenueQuery orderByProductRef($order = Criteria::ASC) Order by the product_ref column
 * @method     ChildOrderProductRevenueQuery orderByPrice($order = Criteria::ASC) Order by the price column
 * @method     ChildOrderProductRevenueQuery orderByPurchasePrice($order = Criteria::ASC) Order by the purchase_price column
 * @method     ChildOrderProductRevenueQuery orderByPartnerId($order = Criteria::ASC) Order by the partner_id column
 *
 * @method     ChildOrderProductRevenueQuery groupById() Group by the id column
 * @method     ChildOrderProductRevenueQuery groupByOrderId() Group by the order_id column
 * @method     ChildOrderProductRevenueQuery groupByProductRef() Group by the product_ref column
 * @method     ChildOrderProductRevenueQuery groupByPrice() Group by the price column
 * @method     ChildOrderProductRevenueQuery groupByPurchasePrice() Group by the purchase_price column
 * @method     ChildOrderProductRevenueQuery groupByPartnerId() Group by the partner_id column
 *
 * @method     ChildOrderProductRevenueQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildOrderProductRevenueQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildOrderProductRevenueQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildOrderProductRevenue findOne(ConnectionInterface $con = null) Return the first ChildOrderProductRevenue matching the query
 * @method     ChildOrderProductRevenue findOneOrCreate(ConnectionInterface $con = null) Return the first ChildOrderProductRevenue matching the query, or a new ChildOrderProductRevenue object populated from the query conditions when no match is found
 *
 * @method     ChildOrderProductRevenue findOneById(int $id) Return the first ChildOrderProductRevenue filtered by the id column
 * @method     ChildOrderProductRevenue findOneByOrderId(int $order_id) Return the first ChildOrderProductRevenue filtered by the order_id column
 * @method     ChildOrderProductRevenue findOneByProductRef(string $product_ref) Return the first ChildOrderProductRevenue filtered by the product_ref column
 * @method     ChildOrderProductRevenue findOneByPrice(string $price) Return the first ChildOrderProductRevenue filtered by the price column
 * @method     ChildOrderProductRevenue findOneByPurchasePrice(string $purchase_price) Return the first ChildOrderProductRevenue filtered by the purchase_price column
 * @method     ChildOrderProductRevenue findOneByPartnerId(int $partner_id) Return the first ChildOrderProductRevenue filtered by the partner_id column
 *
 * @method     array findById(int $id) Return ChildOrderProductRevenue objects filtered by the id column
 * @method     array findByOrderId(int $order_id) Return ChildOrderProductRevenue objects filtered by the order_id column
 * @method     array findByProductRef(string $product_ref) Return ChildOrderProductRevenue objects filtered by the product_ref column
 * @method     array findByPrice(string $price) Return ChildOrderProductRevenue objects filtered by the price column
 * @method     array findByPurchasePrice(string $purchase_price) Return ChildOrderProductRevenue objects filtered by the purchase_price column
 * @method     array findByPartnerId(int $partner_id) Return ChildOrderProductRevenue objects filtered by the partner_id column
 *
 */
abstract class OrderProductRevenueQuery extends ModelCriteria
{
    
    /**
     * Initializes internal state of \RevenueDashboard\Model\Base\OrderProductRevenueQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'thelia', $modelName = '\\RevenueDashboard\\Model\\OrderProductRevenue', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildOrderProductRevenueQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildOrderProductRevenueQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \RevenueDashboard\Model\OrderProductRevenueQuery) {
            return $criteria;
        }
        $query = new \RevenueDashboard\Model\OrderProductRevenueQuery();
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
     * @return ChildOrderProductRevenue|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = OrderProductRevenueTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(OrderProductRevenueTableMap::DATABASE_NAME);
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
     * @return   ChildOrderProductRevenue A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ID, ORDER_ID, PRODUCT_REF, PRICE, PURCHASE_PRICE, PARTNER_ID FROM order_product_revenue WHERE ID = :p0';
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
            $obj = new ChildOrderProductRevenue();
            $obj->hydrate($row);
            OrderProductRevenueTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildOrderProductRevenue|array|mixed the result, formatted by the current formatter
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
     * @return ChildOrderProductRevenueQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(OrderProductRevenueTableMap::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildOrderProductRevenueQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(OrderProductRevenueTableMap::ID, $keys, Criteria::IN);
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
     * @return ChildOrderProductRevenueQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(OrderProductRevenueTableMap::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(OrderProductRevenueTableMap::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OrderProductRevenueTableMap::ID, $id, $comparison);
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
     * @return ChildOrderProductRevenueQuery The current query, for fluid interface
     */
    public function filterByOrderId($orderId = null, $comparison = null)
    {
        if (is_array($orderId)) {
            $useMinMax = false;
            if (isset($orderId['min'])) {
                $this->addUsingAlias(OrderProductRevenueTableMap::ORDER_ID, $orderId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($orderId['max'])) {
                $this->addUsingAlias(OrderProductRevenueTableMap::ORDER_ID, $orderId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OrderProductRevenueTableMap::ORDER_ID, $orderId, $comparison);
    }

    /**
     * Filter the query on the product_ref column
     *
     * Example usage:
     * <code>
     * $query->filterByProductRef('fooValue');   // WHERE product_ref = 'fooValue'
     * $query->filterByProductRef('%fooValue%'); // WHERE product_ref LIKE '%fooValue%'
     * </code>
     *
     * @param     string $productRef The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildOrderProductRevenueQuery The current query, for fluid interface
     */
    public function filterByProductRef($productRef = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($productRef)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $productRef)) {
                $productRef = str_replace('*', '%', $productRef);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(OrderProductRevenueTableMap::PRODUCT_REF, $productRef, $comparison);
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
     * @return ChildOrderProductRevenueQuery The current query, for fluid interface
     */
    public function filterByPrice($price = null, $comparison = null)
    {
        if (is_array($price)) {
            $useMinMax = false;
            if (isset($price['min'])) {
                $this->addUsingAlias(OrderProductRevenueTableMap::PRICE, $price['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($price['max'])) {
                $this->addUsingAlias(OrderProductRevenueTableMap::PRICE, $price['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OrderProductRevenueTableMap::PRICE, $price, $comparison);
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
     * @return ChildOrderProductRevenueQuery The current query, for fluid interface
     */
    public function filterByPurchasePrice($purchasePrice = null, $comparison = null)
    {
        if (is_array($purchasePrice)) {
            $useMinMax = false;
            if (isset($purchasePrice['min'])) {
                $this->addUsingAlias(OrderProductRevenueTableMap::PURCHASE_PRICE, $purchasePrice['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($purchasePrice['max'])) {
                $this->addUsingAlias(OrderProductRevenueTableMap::PURCHASE_PRICE, $purchasePrice['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OrderProductRevenueTableMap::PURCHASE_PRICE, $purchasePrice, $comparison);
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
     * @return ChildOrderProductRevenueQuery The current query, for fluid interface
     */
    public function filterByPartnerId($partnerId = null, $comparison = null)
    {
        if (is_array($partnerId)) {
            $useMinMax = false;
            if (isset($partnerId['min'])) {
                $this->addUsingAlias(OrderProductRevenueTableMap::PARTNER_ID, $partnerId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($partnerId['max'])) {
                $this->addUsingAlias(OrderProductRevenueTableMap::PARTNER_ID, $partnerId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OrderProductRevenueTableMap::PARTNER_ID, $partnerId, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildOrderProductRevenue $orderProductRevenue Object to remove from the list of results
     *
     * @return ChildOrderProductRevenueQuery The current query, for fluid interface
     */
    public function prune($orderProductRevenue = null)
    {
        if ($orderProductRevenue) {
            $this->addUsingAlias(OrderProductRevenueTableMap::ID, $orderProductRevenue->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the order_product_revenue table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(OrderProductRevenueTableMap::DATABASE_NAME);
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
            OrderProductRevenueTableMap::clearInstancePool();
            OrderProductRevenueTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildOrderProductRevenue or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildOrderProductRevenue object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(OrderProductRevenueTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(OrderProductRevenueTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            

        OrderProductRevenueTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            OrderProductRevenueTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

} // OrderProductRevenueQuery
