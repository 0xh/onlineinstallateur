<?php

namespace LocalPickup\Model\Base;

use \Exception;
use \PDO;
use LocalPickup\Model\LocalPickup as ChildLocalPickup;
use LocalPickup\Model\LocalPickupQuery as ChildLocalPickupQuery;
use LocalPickup\Model\Map\LocalPickupTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'local_pickup' table.
 *
 * 
 *
 * @method     ChildLocalPickupQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildLocalPickupQuery orderByAddress($order = Criteria::ASC) Order by the address column
 * @method     ChildLocalPickupQuery orderByGpsLat($order = Criteria::ASC) Order by the gps_lat column
 * @method     ChildLocalPickupQuery orderByGpsLong($order = Criteria::ASC) Order by the gps_long column
 * @method     ChildLocalPickupQuery orderByhint($order = Criteria::ASC) Order by the hint column
 * @method     ChildLocalPickupQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildLocalPickupQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method     ChildLocalPickupQuery groupById() Group by the id column
 * @method     ChildLocalPickupQuery groupByAddress() Group by the address column
 * @method     ChildLocalPickupQuery groupByGpsLat() Group by the gps_lat column
 * @method     ChildLocalPickupQuery groupByGpsLong() Group by the gps_long column
 * @method     ChildLocalPickupQuery groupByhint() Group by the hint column
 * @method     ChildLocalPickupQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildLocalPickupQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method     ChildLocalPickupQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildLocalPickupQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildLocalPickupQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildLocalPickupQuery leftJoinOrderLocalPickupAddress($relationAlias = null) Adds a LEFT JOIN clause to the query using the OrderLocalPickupAddress relation
 * @method     ChildLocalPickupQuery rightJoinOrderLocalPickupAddress($relationAlias = null) Adds a RIGHT JOIN clause to the query using the OrderLocalPickupAddress relation
 * @method     ChildLocalPickupQuery innerJoinOrderLocalPickupAddress($relationAlias = null) Adds a INNER JOIN clause to the query using the OrderLocalPickupAddress relation
 *
 * @method     ChildLocalPickup findOne(ConnectionInterface $con = null) Return the first ChildLocalPickup matching the query
 * @method     ChildLocalPickup findOneOrCreate(ConnectionInterface $con = null) Return the first ChildLocalPickup matching the query, or a new ChildLocalPickup object populated from the query conditions when no match is found
 *
 * @method     ChildLocalPickup findOneById(int $id) Return the first ChildLocalPickup filtered by the id column
 * @method     ChildLocalPickup findOneByAddress(string $address) Return the first ChildLocalPickup filtered by the address column
 * @method     ChildLocalPickup findOneByGpsLat(string $gps_lat) Return the first ChildLocalPickup filtered by the gps_lat column
 * @method     ChildLocalPickup findOneByGpsLong(string $gps_long) Return the first ChildLocalPickup filtered by the gps_long column
 * @method     ChildLocalPickup findOneByhint(string $hint) Return the first ChildLocalPickup filtered by the hint column
 * @method     ChildLocalPickup findOneByCreatedAt(string $created_at) Return the first ChildLocalPickup filtered by the created_at column
 * @method     ChildLocalPickup findOneByUpdatedAt(string $updated_at) Return the first ChildLocalPickup filtered by the updated_at column
 *
 * @method     array findById(int $id) Return ChildLocalPickup objects filtered by the id column
 * @method     array findByAddress(string $address) Return ChildLocalPickup objects filtered by the address column
 * @method     array findByGpsLat(string $gps_lat) Return ChildLocalPickup objects filtered by the gps_lat column
 * @method     array findByGpsLong(string $gps_long) Return ChildLocalPickup objects filtered by the gps_long column
 * @method     array findByhint(string $hint) Return ChildLocalPickup objects filtered by the hint column
 * @method     array findByCreatedAt(string $created_at) Return ChildLocalPickup objects filtered by the created_at column
 * @method     array findByUpdatedAt(string $updated_at) Return ChildLocalPickup objects filtered by the updated_at column
 *
 */
abstract class LocalPickupQuery extends ModelCriteria
{
    
    /**
     * Initializes internal state of \LocalPickup\Model\Base\LocalPickupQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'thelia', $modelName = '\\LocalPickup\\Model\\LocalPickup', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildLocalPickupQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildLocalPickupQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \LocalPickup\Model\LocalPickupQuery) {
            return $criteria;
        }
        $query = new \LocalPickup\Model\LocalPickupQuery();
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
     * @return ChildLocalPickup|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = LocalPickupTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(LocalPickupTableMap::DATABASE_NAME);
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
     * @return   ChildLocalPickup A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ID, ADDRESS, GPS_LAT, GPS_LONG, HINT, CREATED_AT, UPDATED_AT FROM local_pickup WHERE ID = :p0';
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
            $obj = new ChildLocalPickup();
            $obj->hydrate($row);
            LocalPickupTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildLocalPickup|array|mixed the result, formatted by the current formatter
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
     * @return ChildLocalPickupQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(LocalPickupTableMap::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildLocalPickupQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(LocalPickupTableMap::ID, $keys, Criteria::IN);
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
     * @return ChildLocalPickupQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(LocalPickupTableMap::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(LocalPickupTableMap::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(LocalPickupTableMap::ID, $id, $comparison);
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
     * @return ChildLocalPickupQuery The current query, for fluid interface
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

        return $this->addUsingAlias(LocalPickupTableMap::ADDRESS, $address, $comparison);
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
     * @return ChildLocalPickupQuery The current query, for fluid interface
     */
    public function filterByGpsLat($gpsLat = null, $comparison = null)
    {
        if (is_array($gpsLat)) {
            $useMinMax = false;
            if (isset($gpsLat['min'])) {
                $this->addUsingAlias(LocalPickupTableMap::GPS_LAT, $gpsLat['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($gpsLat['max'])) {
                $this->addUsingAlias(LocalPickupTableMap::GPS_LAT, $gpsLat['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(LocalPickupTableMap::GPS_LAT, $gpsLat, $comparison);
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
     * @return ChildLocalPickupQuery The current query, for fluid interface
     */
    public function filterByGpsLong($gpsLong = null, $comparison = null)
    {
        if (is_array($gpsLong)) {
            $useMinMax = false;
            if (isset($gpsLong['min'])) {
                $this->addUsingAlias(LocalPickupTableMap::GPS_LONG, $gpsLong['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($gpsLong['max'])) {
                $this->addUsingAlias(LocalPickupTableMap::GPS_LONG, $gpsLong['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(LocalPickupTableMap::GPS_LONG, $gpsLong, $comparison);
    }

    /**
     * Filter the query on the hint column
     *
     * Example usage:
     * <code>
     * $query->filterByhint('fooValue');   // WHERE hint = 'fooValue'
     * $query->filterByhint('%fooValue%'); // WHERE hint LIKE '%fooValue%'
     * </code>
     *
     * @param     string $hint The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildLocalPickupQuery The current query, for fluid interface
     */
    public function filterByhint($hint = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($hint)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $hint)) {
                $hint = str_replace('*', '%', $hint);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(LocalPickupTableMap::HINT, $hint, $comparison);
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
     * @return ChildLocalPickupQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(LocalPickupTableMap::CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(LocalPickupTableMap::CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(LocalPickupTableMap::CREATED_AT, $createdAt, $comparison);
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
     * @return ChildLocalPickupQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(LocalPickupTableMap::UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(LocalPickupTableMap::UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(LocalPickupTableMap::UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Filter the query by a related \LocalPickup\Model\OrderLocalPickupAddress object
     *
     * @param \LocalPickup\Model\OrderLocalPickupAddress|ObjectCollection $orderLocalPickupAddress  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildLocalPickupQuery The current query, for fluid interface
     */
    public function filterByOrderLocalPickupAddress($orderLocalPickupAddress, $comparison = null)
    {
        if ($orderLocalPickupAddress instanceof \LocalPickup\Model\OrderLocalPickupAddress) {
            return $this
                ->addUsingAlias(LocalPickupTableMap::ID, $orderLocalPickupAddress->getLocalPickupId(), $comparison);
        } elseif ($orderLocalPickupAddress instanceof ObjectCollection) {
            return $this
                ->useOrderLocalPickupAddressQuery()
                ->filterByPrimaryKeys($orderLocalPickupAddress->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByOrderLocalPickupAddress() only accepts arguments of type \LocalPickup\Model\OrderLocalPickupAddress or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the OrderLocalPickupAddress relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildLocalPickupQuery The current query, for fluid interface
     */
    public function joinOrderLocalPickupAddress($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('OrderLocalPickupAddress');

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
            $this->addJoinObject($join, 'OrderLocalPickupAddress');
        }

        return $this;
    }

    /**
     * Use the OrderLocalPickupAddress relation OrderLocalPickupAddress object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \LocalPickup\Model\OrderLocalPickupAddressQuery A secondary query class using the current class as primary query
     */
    public function useOrderLocalPickupAddressQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinOrderLocalPickupAddress($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'OrderLocalPickupAddress', '\LocalPickup\Model\OrderLocalPickupAddressQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildLocalPickup $localPickup Object to remove from the list of results
     *
     * @return ChildLocalPickupQuery The current query, for fluid interface
     */
    public function prune($localPickup = null)
    {
        if ($localPickup) {
            $this->addUsingAlias(LocalPickupTableMap::ID, $localPickup->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the local_pickup table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(LocalPickupTableMap::DATABASE_NAME);
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
            LocalPickupTableMap::clearInstancePool();
            LocalPickupTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildLocalPickup or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildLocalPickup object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(LocalPickupTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(LocalPickupTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            

        LocalPickupTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            LocalPickupTableMap::clearRelatedInstancePool();
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
     * @return     ChildLocalPickupQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(LocalPickupTableMap::UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }
    
    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     ChildLocalPickupQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(LocalPickupTableMap::CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }
    
    /**
     * Order by update date desc
     *
     * @return     ChildLocalPickupQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(LocalPickupTableMap::UPDATED_AT);
    }
    
    /**
     * Order by update date asc
     *
     * @return     ChildLocalPickupQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(LocalPickupTableMap::UPDATED_AT);
    }
    
    /**
     * Order by create date desc
     *
     * @return     ChildLocalPickupQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(LocalPickupTableMap::CREATED_AT);
    }
    
    /**
     * Order by create date asc
     *
     * @return     ChildLocalPickupQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(LocalPickupTableMap::CREATED_AT);
    }

} // LocalPickupQuery
