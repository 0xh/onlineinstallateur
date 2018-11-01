<?php

namespace OrderCredit\Model\Base;

use \Exception;
use \PDO;
use OrderCredit\Model\OrderCredit as ChildOrderCredit;
use OrderCredit\Model\OrderCreditQuery as ChildOrderCreditQuery;
use OrderCredit\Model\Map\OrderCreditTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'order_credit' table.
 *
 * 
 *
 * @method     ChildOrderCreditQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildOrderCreditQuery orderByOrderCreditId($order = Criteria::ASC) Order by the order_credit_id column
 * @method     ChildOrderCreditQuery orderByOrderCreditRef($order = Criteria::ASC) Order by the order_credit_ref column
 * @method     ChildOrderCreditQuery orderByOrderId($order = Criteria::ASC) Order by the order_id column
 * @method     ChildOrderCreditQuery orderByOrderRef($order = Criteria::ASC) Order by the order_ref column
 * @method     ChildOrderCreditQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildOrderCreditQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method     ChildOrderCreditQuery groupById() Group by the id column
 * @method     ChildOrderCreditQuery groupByOrderCreditId() Group by the order_credit_id column
 * @method     ChildOrderCreditQuery groupByOrderCreditRef() Group by the order_credit_ref column
 * @method     ChildOrderCreditQuery groupByOrderId() Group by the order_id column
 * @method     ChildOrderCreditQuery groupByOrderRef() Group by the order_ref column
 * @method     ChildOrderCreditQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildOrderCreditQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method     ChildOrderCreditQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildOrderCreditQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildOrderCreditQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildOrderCredit findOne(ConnectionInterface $con = null) Return the first ChildOrderCredit matching the query
 * @method     ChildOrderCredit findOneOrCreate(ConnectionInterface $con = null) Return the first ChildOrderCredit matching the query, or a new ChildOrderCredit object populated from the query conditions when no match is found
 *
 * @method     ChildOrderCredit findOneById(int $id) Return the first ChildOrderCredit filtered by the id column
 * @method     ChildOrderCredit findOneByOrderCreditId(int $order_credit_id) Return the first ChildOrderCredit filtered by the order_credit_id column
 * @method     ChildOrderCredit findOneByOrderCreditRef(string $order_credit_ref) Return the first ChildOrderCredit filtered by the order_credit_ref column
 * @method     ChildOrderCredit findOneByOrderId(int $order_id) Return the first ChildOrderCredit filtered by the order_id column
 * @method     ChildOrderCredit findOneByOrderRef(string $order_ref) Return the first ChildOrderCredit filtered by the order_ref column
 * @method     ChildOrderCredit findOneByCreatedAt(string $created_at) Return the first ChildOrderCredit filtered by the created_at column
 * @method     ChildOrderCredit findOneByUpdatedAt(string $updated_at) Return the first ChildOrderCredit filtered by the updated_at column
 *
 * @method     array findById(int $id) Return ChildOrderCredit objects filtered by the id column
 * @method     array findByOrderCreditId(int $order_credit_id) Return ChildOrderCredit objects filtered by the order_credit_id column
 * @method     array findByOrderCreditRef(string $order_credit_ref) Return ChildOrderCredit objects filtered by the order_credit_ref column
 * @method     array findByOrderId(int $order_id) Return ChildOrderCredit objects filtered by the order_id column
 * @method     array findByOrderRef(string $order_ref) Return ChildOrderCredit objects filtered by the order_ref column
 * @method     array findByCreatedAt(string $created_at) Return ChildOrderCredit objects filtered by the created_at column
 * @method     array findByUpdatedAt(string $updated_at) Return ChildOrderCredit objects filtered by the updated_at column
 *
 */
abstract class OrderCreditQuery extends ModelCriteria
{
    
    /**
     * Initializes internal state of \OrderCredit\Model\Base\OrderCreditQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'thelia', $modelName = '\\OrderCredit\\Model\\OrderCredit', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildOrderCreditQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildOrderCreditQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \OrderCredit\Model\OrderCreditQuery) {
            return $criteria;
        }
        $query = new \OrderCredit\Model\OrderCreditQuery();
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
     * @return ChildOrderCredit|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = OrderCreditTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(OrderCreditTableMap::DATABASE_NAME);
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
     * @return   ChildOrderCredit A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ID, ORDER_CREDIT_ID, ORDER_CREDIT_REF, ORDER_ID, ORDER_REF, CREATED_AT, UPDATED_AT FROM order_credit WHERE ID = :p0';
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
            $obj = new ChildOrderCredit();
            $obj->hydrate($row);
            OrderCreditTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildOrderCredit|array|mixed the result, formatted by the current formatter
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
     * @return ChildOrderCreditQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(OrderCreditTableMap::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildOrderCreditQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(OrderCreditTableMap::ID, $keys, Criteria::IN);
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
     * @return ChildOrderCreditQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(OrderCreditTableMap::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(OrderCreditTableMap::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OrderCreditTableMap::ID, $id, $comparison);
    }

    /**
     * Filter the query on the order_credit_id column
     *
     * Example usage:
     * <code>
     * $query->filterByOrderCreditId(1234); // WHERE order_credit_id = 1234
     * $query->filterByOrderCreditId(array(12, 34)); // WHERE order_credit_id IN (12, 34)
     * $query->filterByOrderCreditId(array('min' => 12)); // WHERE order_credit_id > 12
     * </code>
     *
     * @param     mixed $orderCreditId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildOrderCreditQuery The current query, for fluid interface
     */
    public function filterByOrderCreditId($orderCreditId = null, $comparison = null)
    {
        if (is_array($orderCreditId)) {
            $useMinMax = false;
            if (isset($orderCreditId['min'])) {
                $this->addUsingAlias(OrderCreditTableMap::ORDER_CREDIT_ID, $orderCreditId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($orderCreditId['max'])) {
                $this->addUsingAlias(OrderCreditTableMap::ORDER_CREDIT_ID, $orderCreditId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OrderCreditTableMap::ORDER_CREDIT_ID, $orderCreditId, $comparison);
    }

    /**
     * Filter the query on the order_credit_ref column
     *
     * Example usage:
     * <code>
     * $query->filterByOrderCreditRef('fooValue');   // WHERE order_credit_ref = 'fooValue'
     * $query->filterByOrderCreditRef('%fooValue%'); // WHERE order_credit_ref LIKE '%fooValue%'
     * </code>
     *
     * @param     string $orderCreditRef The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildOrderCreditQuery The current query, for fluid interface
     */
    public function filterByOrderCreditRef($orderCreditRef = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($orderCreditRef)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $orderCreditRef)) {
                $orderCreditRef = str_replace('*', '%', $orderCreditRef);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(OrderCreditTableMap::ORDER_CREDIT_REF, $orderCreditRef, $comparison);
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
     * @return ChildOrderCreditQuery The current query, for fluid interface
     */
    public function filterByOrderId($orderId = null, $comparison = null)
    {
        if (is_array($orderId)) {
            $useMinMax = false;
            if (isset($orderId['min'])) {
                $this->addUsingAlias(OrderCreditTableMap::ORDER_ID, $orderId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($orderId['max'])) {
                $this->addUsingAlias(OrderCreditTableMap::ORDER_ID, $orderId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OrderCreditTableMap::ORDER_ID, $orderId, $comparison);
    }

    /**
     * Filter the query on the order_ref column
     *
     * Example usage:
     * <code>
     * $query->filterByOrderRef('fooValue');   // WHERE order_ref = 'fooValue'
     * $query->filterByOrderRef('%fooValue%'); // WHERE order_ref LIKE '%fooValue%'
     * </code>
     *
     * @param     string $orderRef The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildOrderCreditQuery The current query, for fluid interface
     */
    public function filterByOrderRef($orderRef = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($orderRef)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $orderRef)) {
                $orderRef = str_replace('*', '%', $orderRef);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(OrderCreditTableMap::ORDER_REF, $orderRef, $comparison);
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
     * @return ChildOrderCreditQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(OrderCreditTableMap::CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(OrderCreditTableMap::CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OrderCreditTableMap::CREATED_AT, $createdAt, $comparison);
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
     * @return ChildOrderCreditQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(OrderCreditTableMap::UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(OrderCreditTableMap::UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OrderCreditTableMap::UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildOrderCredit $orderCredit Object to remove from the list of results
     *
     * @return ChildOrderCreditQuery The current query, for fluid interface
     */
    public function prune($orderCredit = null)
    {
        if ($orderCredit) {
            $this->addUsingAlias(OrderCreditTableMap::ID, $orderCredit->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the order_credit table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(OrderCreditTableMap::DATABASE_NAME);
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
            OrderCreditTableMap::clearInstancePool();
            OrderCreditTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildOrderCredit or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildOrderCredit object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(OrderCreditTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(OrderCreditTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            

        OrderCreditTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            OrderCreditTableMap::clearRelatedInstancePool();
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
     * @return     ChildOrderCreditQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(OrderCreditTableMap::UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }
    
    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     ChildOrderCreditQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(OrderCreditTableMap::CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }
    
    /**
     * Order by update date desc
     *
     * @return     ChildOrderCreditQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(OrderCreditTableMap::UPDATED_AT);
    }
    
    /**
     * Order by update date asc
     *
     * @return     ChildOrderCreditQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(OrderCreditTableMap::UPDATED_AT);
    }
    
    /**
     * Order by create date desc
     *
     * @return     ChildOrderCreditQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(OrderCreditTableMap::CREATED_AT);
    }
    
    /**
     * Order by create date asc
     *
     * @return     ChildOrderCreditQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(OrderCreditTableMap::CREATED_AT);
    }

} // OrderCreditQuery
