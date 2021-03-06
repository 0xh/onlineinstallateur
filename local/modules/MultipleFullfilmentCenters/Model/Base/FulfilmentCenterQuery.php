<?php

namespace MultipleFullfilmentCenters\Model\Base;

use \Exception;
use \PDO;
use MultipleFullfilmentCenters\Model\FulfilmentCenter as ChildFulfilmentCenter;
use MultipleFullfilmentCenters\Model\FulfilmentCenterQuery as ChildFulfilmentCenterQuery;
use MultipleFullfilmentCenters\Model\Map\FulfilmentCenterTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'fulfilment_center' table.
 *
 * 
 *
 * @method     ChildFulfilmentCenterQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildFulfilmentCenterQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method     ChildFulfilmentCenterQuery orderByAddress($order = Criteria::ASC) Order by the address column
 * @method     ChildFulfilmentCenterQuery orderByGpsLat($order = Criteria::ASC) Order by the gps_lat column
 * @method     ChildFulfilmentCenterQuery orderByGpsLong($order = Criteria::ASC) Order by the gps_long column
 * @method     ChildFulfilmentCenterQuery orderByStockLimit($order = Criteria::ASC) Order by the stock_limit column
 * @method     ChildFulfilmentCenterQuery orderByDeliveryCost($order = Criteria::ASC) Order by the delivery_cost column
 * @method     ChildFulfilmentCenterQuery orderByDeliveryMethod($order = Criteria::ASC) Order by the delivery_method column
 *
 * @method     ChildFulfilmentCenterQuery groupById() Group by the id column
 * @method     ChildFulfilmentCenterQuery groupByName() Group by the name column
 * @method     ChildFulfilmentCenterQuery groupByAddress() Group by the address column
 * @method     ChildFulfilmentCenterQuery groupByGpsLat() Group by the gps_lat column
 * @method     ChildFulfilmentCenterQuery groupByGpsLong() Group by the gps_long column
 * @method     ChildFulfilmentCenterQuery groupByStockLimit() Group by the stock_limit column
 * @method     ChildFulfilmentCenterQuery groupByDeliveryCost() Group by the delivery_cost column
 * @method     ChildFulfilmentCenterQuery groupByDeliveryMethod() Group by the delivery_method column
 *
 * @method     ChildFulfilmentCenterQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildFulfilmentCenterQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildFulfilmentCenterQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildFulfilmentCenterQuery leftJoinFulfilmentCenterProducts($relationAlias = null) Adds a LEFT JOIN clause to the query using the FulfilmentCenterProducts relation
 * @method     ChildFulfilmentCenterQuery rightJoinFulfilmentCenterProducts($relationAlias = null) Adds a RIGHT JOIN clause to the query using the FulfilmentCenterProducts relation
 * @method     ChildFulfilmentCenterQuery innerJoinFulfilmentCenterProducts($relationAlias = null) Adds a INNER JOIN clause to the query using the FulfilmentCenterProducts relation
 *
 * @method     ChildFulfilmentCenterQuery leftJoinOrderLocalPickup($relationAlias = null) Adds a LEFT JOIN clause to the query using the OrderLocalPickup relation
 * @method     ChildFulfilmentCenterQuery rightJoinOrderLocalPickup($relationAlias = null) Adds a RIGHT JOIN clause to the query using the OrderLocalPickup relation
 * @method     ChildFulfilmentCenterQuery innerJoinOrderLocalPickup($relationAlias = null) Adds a INNER JOIN clause to the query using the OrderLocalPickup relation
 *
 * @method     ChildFulfilmentCenter findOne(ConnectionInterface $con = null) Return the first ChildFulfilmentCenter matching the query
 * @method     ChildFulfilmentCenter findOneOrCreate(ConnectionInterface $con = null) Return the first ChildFulfilmentCenter matching the query, or a new ChildFulfilmentCenter object populated from the query conditions when no match is found
 *
 * @method     ChildFulfilmentCenter findOneById(int $id) Return the first ChildFulfilmentCenter filtered by the id column
 * @method     ChildFulfilmentCenter findOneByName(string $name) Return the first ChildFulfilmentCenter filtered by the name column
 * @method     ChildFulfilmentCenter findOneByAddress(string $address) Return the first ChildFulfilmentCenter filtered by the address column
 * @method     ChildFulfilmentCenter findOneByGpsLat(string $gps_lat) Return the first ChildFulfilmentCenter filtered by the gps_lat column
 * @method     ChildFulfilmentCenter findOneByGpsLong(string $gps_long) Return the first ChildFulfilmentCenter filtered by the gps_long column
 * @method     ChildFulfilmentCenter findOneByStockLimit(int $stock_limit) Return the first ChildFulfilmentCenter filtered by the stock_limit column
 * @method     ChildFulfilmentCenter findOneByDeliveryCost(string $delivery_cost) Return the first ChildFulfilmentCenter filtered by the delivery_cost column
 * @method     ChildFulfilmentCenter findOneByDeliveryMethod(string $delivery_method) Return the first ChildFulfilmentCenter filtered by the delivery_method column
 *
 * @method     array findById(int $id) Return ChildFulfilmentCenter objects filtered by the id column
 * @method     array findByName(string $name) Return ChildFulfilmentCenter objects filtered by the name column
 * @method     array findByAddress(string $address) Return ChildFulfilmentCenter objects filtered by the address column
 * @method     array findByGpsLat(string $gps_lat) Return ChildFulfilmentCenter objects filtered by the gps_lat column
 * @method     array findByGpsLong(string $gps_long) Return ChildFulfilmentCenter objects filtered by the gps_long column
 * @method     array findByStockLimit(int $stock_limit) Return ChildFulfilmentCenter objects filtered by the stock_limit column
 * @method     array findByDeliveryCost(string $delivery_cost) Return ChildFulfilmentCenter objects filtered by the delivery_cost column
 * @method     array findByDeliveryMethod(string $delivery_method) Return ChildFulfilmentCenter objects filtered by the delivery_method column
 *
 */
abstract class FulfilmentCenterQuery extends ModelCriteria
{
    
    /**
     * Initializes internal state of \MultipleFullfilmentCenters\Model\Base\FulfilmentCenterQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'thelia', $modelName = '\\MultipleFullfilmentCenters\\Model\\FulfilmentCenter', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildFulfilmentCenterQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildFulfilmentCenterQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \MultipleFullfilmentCenters\Model\FulfilmentCenterQuery) {
            return $criteria;
        }
        $query = new \MultipleFullfilmentCenters\Model\FulfilmentCenterQuery();
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
     * @return ChildFulfilmentCenter|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = FulfilmentCenterTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(FulfilmentCenterTableMap::DATABASE_NAME);
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
     * @return   ChildFulfilmentCenter A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ID, NAME, ADDRESS, GPS_LAT, GPS_LONG, STOCK_LIMIT, DELIVERY_COST, DELIVERY_METHOD FROM fulfilment_center WHERE ID = :p0';
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
            $obj = new ChildFulfilmentCenter();
            $obj->hydrate($row);
            FulfilmentCenterTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildFulfilmentCenter|array|mixed the result, formatted by the current formatter
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
     * @return ChildFulfilmentCenterQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(FulfilmentCenterTableMap::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildFulfilmentCenterQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(FulfilmentCenterTableMap::ID, $keys, Criteria::IN);
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
     * @return ChildFulfilmentCenterQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(FulfilmentCenterTableMap::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(FulfilmentCenterTableMap::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FulfilmentCenterTableMap::ID, $id, $comparison);
    }

    /**
     * Filter the query on the name column
     *
     * Example usage:
     * <code>
     * $query->filterByName('fooValue');   // WHERE name = 'fooValue'
     * $query->filterByName('%fooValue%'); // WHERE name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $name The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildFulfilmentCenterQuery The current query, for fluid interface
     */
    public function filterByName($name = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $name)) {
                $name = str_replace('*', '%', $name);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(FulfilmentCenterTableMap::NAME, $name, $comparison);
    }

    /**
     * Filter the query on the address column
     *
     * Example usage:
     * <code>
     * $query->filterByAddress('fooValue');   // WHERE address = 'fooValue'
     * $query->filterByAddress('%fooValue%'); // WHERE address LIKE '%fooValue%'
     * </code>
     *
     * @param     string $address The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildFulfilmentCenterQuery The current query, for fluid interface
     */
    public function filterByAddress($address = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($address)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $address)) {
                $address = str_replace('*', '%', $address);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(FulfilmentCenterTableMap::ADDRESS, $address, $comparison);
    }

    /**
     * Filter the query on the gps_lat column
     *
     * Example usage:
     * <code>
     * $query->filterByGpsLat(1234); // WHERE gps_lat = 1234
     * $query->filterByGpsLat(array(12, 34)); // WHERE gps_lat IN (12, 34)
     * $query->filterByGpsLat(array('min' => 12)); // WHERE gps_lat > 12
     * </code>
     *
     * @param     mixed $gpsLat The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildFulfilmentCenterQuery The current query, for fluid interface
     */
    public function filterByGpsLat($gpsLat = null, $comparison = null)
    {
        if (is_array($gpsLat)) {
            $useMinMax = false;
            if (isset($gpsLat['min'])) {
                $this->addUsingAlias(FulfilmentCenterTableMap::GPS_LAT, $gpsLat['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($gpsLat['max'])) {
                $this->addUsingAlias(FulfilmentCenterTableMap::GPS_LAT, $gpsLat['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FulfilmentCenterTableMap::GPS_LAT, $gpsLat, $comparison);
    }

    /**
     * Filter the query on the gps_long column
     *
     * Example usage:
     * <code>
     * $query->filterByGpsLong(1234); // WHERE gps_long = 1234
     * $query->filterByGpsLong(array(12, 34)); // WHERE gps_long IN (12, 34)
     * $query->filterByGpsLong(array('min' => 12)); // WHERE gps_long > 12
     * </code>
     *
     * @param     mixed $gpsLong The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildFulfilmentCenterQuery The current query, for fluid interface
     */
    public function filterByGpsLong($gpsLong = null, $comparison = null)
    {
        if (is_array($gpsLong)) {
            $useMinMax = false;
            if (isset($gpsLong['min'])) {
                $this->addUsingAlias(FulfilmentCenterTableMap::GPS_LONG, $gpsLong['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($gpsLong['max'])) {
                $this->addUsingAlias(FulfilmentCenterTableMap::GPS_LONG, $gpsLong['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FulfilmentCenterTableMap::GPS_LONG, $gpsLong, $comparison);
    }

    /**
     * Filter the query on the stock_limit column
     *
     * Example usage:
     * <code>
     * $query->filterByStockLimit(1234); // WHERE stock_limit = 1234
     * $query->filterByStockLimit(array(12, 34)); // WHERE stock_limit IN (12, 34)
     * $query->filterByStockLimit(array('min' => 12)); // WHERE stock_limit > 12
     * </code>
     *
     * @param     mixed $stockLimit The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildFulfilmentCenterQuery The current query, for fluid interface
     */
    public function filterByStockLimit($stockLimit = null, $comparison = null)
    {
        if (is_array($stockLimit)) {
            $useMinMax = false;
            if (isset($stockLimit['min'])) {
                $this->addUsingAlias(FulfilmentCenterTableMap::STOCK_LIMIT, $stockLimit['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($stockLimit['max'])) {
                $this->addUsingAlias(FulfilmentCenterTableMap::STOCK_LIMIT, $stockLimit['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FulfilmentCenterTableMap::STOCK_LIMIT, $stockLimit, $comparison);
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
     * @return ChildFulfilmentCenterQuery The current query, for fluid interface
     */
    public function filterByDeliveryCost($deliveryCost = null, $comparison = null)
    {
        if (is_array($deliveryCost)) {
            $useMinMax = false;
            if (isset($deliveryCost['min'])) {
                $this->addUsingAlias(FulfilmentCenterTableMap::DELIVERY_COST, $deliveryCost['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($deliveryCost['max'])) {
                $this->addUsingAlias(FulfilmentCenterTableMap::DELIVERY_COST, $deliveryCost['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FulfilmentCenterTableMap::DELIVERY_COST, $deliveryCost, $comparison);
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
     * @return ChildFulfilmentCenterQuery The current query, for fluid interface
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

        return $this->addUsingAlias(FulfilmentCenterTableMap::DELIVERY_METHOD, $deliveryMethod, $comparison);
    }

    /**
     * Filter the query by a related \MultipleFullfilmentCenters\Model\FulfilmentCenterProducts object
     *
     * @param \MultipleFullfilmentCenters\Model\FulfilmentCenterProducts|ObjectCollection $fulfilmentCenterProducts  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildFulfilmentCenterQuery The current query, for fluid interface
     */
    public function filterByFulfilmentCenterProducts($fulfilmentCenterProducts, $comparison = null)
    {
        if ($fulfilmentCenterProducts instanceof \MultipleFullfilmentCenters\Model\FulfilmentCenterProducts) {
            return $this
                ->addUsingAlias(FulfilmentCenterTableMap::ID, $fulfilmentCenterProducts->getFulfilmentCenterId(), $comparison);
        } elseif ($fulfilmentCenterProducts instanceof ObjectCollection) {
            return $this
                ->useFulfilmentCenterProductsQuery()
                ->filterByPrimaryKeys($fulfilmentCenterProducts->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByFulfilmentCenterProducts() only accepts arguments of type \MultipleFullfilmentCenters\Model\FulfilmentCenterProducts or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the FulfilmentCenterProducts relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildFulfilmentCenterQuery The current query, for fluid interface
     */
    public function joinFulfilmentCenterProducts($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('FulfilmentCenterProducts');

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
            $this->addJoinObject($join, 'FulfilmentCenterProducts');
        }

        return $this;
    }

    /**
     * Use the FulfilmentCenterProducts relation FulfilmentCenterProducts object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \MultipleFullfilmentCenters\Model\FulfilmentCenterProductsQuery A secondary query class using the current class as primary query
     */
    public function useFulfilmentCenterProductsQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinFulfilmentCenterProducts($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'FulfilmentCenterProducts', '\MultipleFullfilmentCenters\Model\FulfilmentCenterProductsQuery');
    }

    /**
     * Filter the query by a related \MultipleFullfilmentCenters\Model\OrderLocalPickup object
     *
     * @param \MultipleFullfilmentCenters\Model\OrderLocalPickup|ObjectCollection $orderLocalPickup  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildFulfilmentCenterQuery The current query, for fluid interface
     */
    public function filterByOrderLocalPickup($orderLocalPickup, $comparison = null)
    {
        if ($orderLocalPickup instanceof \MultipleFullfilmentCenters\Model\OrderLocalPickup) {
            return $this
                ->addUsingAlias(FulfilmentCenterTableMap::ID, $orderLocalPickup->getFulfilmentCenterId(), $comparison);
        } elseif ($orderLocalPickup instanceof ObjectCollection) {
            return $this
                ->useOrderLocalPickupQuery()
                ->filterByPrimaryKeys($orderLocalPickup->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByOrderLocalPickup() only accepts arguments of type \MultipleFullfilmentCenters\Model\OrderLocalPickup or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the OrderLocalPickup relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildFulfilmentCenterQuery The current query, for fluid interface
     */
    public function joinOrderLocalPickup($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('OrderLocalPickup');

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
            $this->addJoinObject($join, 'OrderLocalPickup');
        }

        return $this;
    }

    /**
     * Use the OrderLocalPickup relation OrderLocalPickup object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \MultipleFullfilmentCenters\Model\OrderLocalPickupQuery A secondary query class using the current class as primary query
     */
    public function useOrderLocalPickupQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinOrderLocalPickup($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'OrderLocalPickup', '\MultipleFullfilmentCenters\Model\OrderLocalPickupQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildFulfilmentCenter $fulfilmentCenter Object to remove from the list of results
     *
     * @return ChildFulfilmentCenterQuery The current query, for fluid interface
     */
    public function prune($fulfilmentCenter = null)
    {
        if ($fulfilmentCenter) {
            $this->addUsingAlias(FulfilmentCenterTableMap::ID, $fulfilmentCenter->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the fulfilment_center table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(FulfilmentCenterTableMap::DATABASE_NAME);
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
            FulfilmentCenterTableMap::clearInstancePool();
            FulfilmentCenterTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildFulfilmentCenter or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildFulfilmentCenter object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(FulfilmentCenterTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(FulfilmentCenterTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            

        FulfilmentCenterTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            FulfilmentCenterTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

} // FulfilmentCenterQuery
