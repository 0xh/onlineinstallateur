<?php

namespace MultipleFullfilmentCenters\Model\Base;

use \Exception;
use \PDO;
use MultipleFullfilmentCenters\Model\FulfilmentCenterOrder as ChildFulfilmentCenterOrder;
use MultipleFullfilmentCenters\Model\FulfilmentCenterOrderQuery as ChildFulfilmentCenterOrderQuery;
use MultipleFullfilmentCenters\Model\Map\FulfilmentCenterOrderTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'fulfilment_center_order' table.
 *
 * 
 *
 * @method     ChildFulfilmentCenterOrderQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildFulfilmentCenterOrderQuery orderByCenterId($order = Criteria::ASC) Order by the center_id column
 * @method     ChildFulfilmentCenterOrderQuery orderByOrderId($order = Criteria::ASC) Order by the order_id column
 *
 * @method     ChildFulfilmentCenterOrderQuery groupById() Group by the id column
 * @method     ChildFulfilmentCenterOrderQuery groupByCenterId() Group by the center_id column
 * @method     ChildFulfilmentCenterOrderQuery groupByOrderId() Group by the order_id column
 *
 * @method     ChildFulfilmentCenterOrderQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildFulfilmentCenterOrderQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildFulfilmentCenterOrderQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildFulfilmentCenterOrder findOne(ConnectionInterface $con = null) Return the first ChildFulfilmentCenterOrder matching the query
 * @method     ChildFulfilmentCenterOrder findOneOrCreate(ConnectionInterface $con = null) Return the first ChildFulfilmentCenterOrder matching the query, or a new ChildFulfilmentCenterOrder object populated from the query conditions when no match is found
 *
 * @method     ChildFulfilmentCenterOrder findOneById(int $id) Return the first ChildFulfilmentCenterOrder filtered by the id column
 * @method     ChildFulfilmentCenterOrder findOneByCenterId(int $center_id) Return the first ChildFulfilmentCenterOrder filtered by the center_id column
 * @method     ChildFulfilmentCenterOrder findOneByOrderId(int $order_id) Return the first ChildFulfilmentCenterOrder filtered by the order_id column
 *
 * @method     array findById(int $id) Return ChildFulfilmentCenterOrder objects filtered by the id column
 * @method     array findByCenterId(int $center_id) Return ChildFulfilmentCenterOrder objects filtered by the center_id column
 * @method     array findByOrderId(int $order_id) Return ChildFulfilmentCenterOrder objects filtered by the order_id column
 *
 */
abstract class FulfilmentCenterOrderQuery extends ModelCriteria
{
    
    /**
     * Initializes internal state of \MultipleFullfilmentCenters\Model\Base\FulfilmentCenterOrderQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'thelia', $modelName = '\\MultipleFullfilmentCenters\\Model\\FulfilmentCenterOrder', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildFulfilmentCenterOrderQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildFulfilmentCenterOrderQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \MultipleFullfilmentCenters\Model\FulfilmentCenterOrderQuery) {
            return $criteria;
        }
        $query = new \MultipleFullfilmentCenters\Model\FulfilmentCenterOrderQuery();
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
     * @return ChildFulfilmentCenterOrder|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = FulfilmentCenterOrderTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(FulfilmentCenterOrderTableMap::DATABASE_NAME);
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
     * @return   ChildFulfilmentCenterOrder A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ID, CENTER_ID, ORDER_ID FROM fulfilment_center_order WHERE ID = :p0';
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
            $obj = new ChildFulfilmentCenterOrder();
            $obj->hydrate($row);
            FulfilmentCenterOrderTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildFulfilmentCenterOrder|array|mixed the result, formatted by the current formatter
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
     * @return ChildFulfilmentCenterOrderQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(FulfilmentCenterOrderTableMap::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildFulfilmentCenterOrderQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(FulfilmentCenterOrderTableMap::ID, $keys, Criteria::IN);
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
     * @return ChildFulfilmentCenterOrderQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(FulfilmentCenterOrderTableMap::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(FulfilmentCenterOrderTableMap::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FulfilmentCenterOrderTableMap::ID, $id, $comparison);
    }

    /**
     * Filter the query on the center_id column
     *
     * Example usage:
     * <code>
     * $query->filterByCenterId(1234); // WHERE center_id = 1234
     * $query->filterByCenterId(array(12, 34)); // WHERE center_id IN (12, 34)
     * $query->filterByCenterId(array('min' => 12)); // WHERE center_id > 12
     * </code>
     *
     * @param     mixed $centerId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildFulfilmentCenterOrderQuery The current query, for fluid interface
     */
    public function filterByCenterId($centerId = null, $comparison = null)
    {
        if (is_array($centerId)) {
            $useMinMax = false;
            if (isset($centerId['min'])) {
                $this->addUsingAlias(FulfilmentCenterOrderTableMap::CENTER_ID, $centerId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($centerId['max'])) {
                $this->addUsingAlias(FulfilmentCenterOrderTableMap::CENTER_ID, $centerId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FulfilmentCenterOrderTableMap::CENTER_ID, $centerId, $comparison);
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
     * @return ChildFulfilmentCenterOrderQuery The current query, for fluid interface
     */
    public function filterByOrderId($orderId = null, $comparison = null)
    {
        if (is_array($orderId)) {
            $useMinMax = false;
            if (isset($orderId['min'])) {
                $this->addUsingAlias(FulfilmentCenterOrderTableMap::ORDER_ID, $orderId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($orderId['max'])) {
                $this->addUsingAlias(FulfilmentCenterOrderTableMap::ORDER_ID, $orderId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FulfilmentCenterOrderTableMap::ORDER_ID, $orderId, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildFulfilmentCenterOrder $fulfilmentCenterOrder Object to remove from the list of results
     *
     * @return ChildFulfilmentCenterOrderQuery The current query, for fluid interface
     */
    public function prune($fulfilmentCenterOrder = null)
    {
        if ($fulfilmentCenterOrder) {
            $this->addUsingAlias(FulfilmentCenterOrderTableMap::ID, $fulfilmentCenterOrder->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the fulfilment_center_order table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(FulfilmentCenterOrderTableMap::DATABASE_NAME);
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
            FulfilmentCenterOrderTableMap::clearInstancePool();
            FulfilmentCenterOrderTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildFulfilmentCenterOrder or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildFulfilmentCenterOrder object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(FulfilmentCenterOrderTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(FulfilmentCenterOrderTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            

        FulfilmentCenterOrderTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            FulfilmentCenterOrderTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

} // FulfilmentCenterOrderQuery
