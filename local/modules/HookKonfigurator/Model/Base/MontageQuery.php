<?php

namespace HookKonfigurator\Model\Base;

use \Montage as ChildMontage;
use \MontageQuery as ChildMontageQuery;
use \Exception;
use \PDO;
use Map\MontageTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'montage' table.
 *
 * 
 *
 * @method     ChildMontageQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildMontageQuery orderByCalendarId($order = Criteria::ASC) Order by the calendar_id column
 * @method     ChildMontageQuery orderByType($order = Criteria::ASC) Order by the type column
 * @method     ChildMontageQuery orderByQuantity($order = Criteria::ASC) Order by the quantity column
 * @method     ChildMontageQuery orderByUnit($order = Criteria::ASC) Order by the unit column
 * @method     ChildMontageQuery orderByExtraQuantityPrice($order = Criteria::ASC) Order by the extra_quantity_price column
 * @method     ChildMontageQuery orderByDuration($order = Criteria::ASC) Order by the duration column
 *
 * @method     ChildMontageQuery groupById() Group by the id column
 * @method     ChildMontageQuery groupByCalendarId() Group by the calendar_id column
 * @method     ChildMontageQuery groupByType() Group by the type column
 * @method     ChildMontageQuery groupByQuantity() Group by the quantity column
 * @method     ChildMontageQuery groupByUnit() Group by the unit column
 * @method     ChildMontageQuery groupByExtraQuantityPrice() Group by the extra_quantity_price column
 * @method     ChildMontageQuery groupByDuration() Group by the duration column
 *
 * @method     ChildMontageQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildMontageQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildMontageQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildMontageQuery leftJoinProduct($relationAlias = null) Adds a LEFT JOIN clause to the query using the Product relation
 * @method     ChildMontageQuery rightJoinProduct($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Product relation
 * @method     ChildMontageQuery innerJoinProduct($relationAlias = null) Adds a INNER JOIN clause to the query using the Product relation
 *
 * @method     ChildMontageQuery leftJoinMontageConstraints($relationAlias = null) Adds a LEFT JOIN clause to the query using the MontageConstraints relation
 * @method     ChildMontageQuery rightJoinMontageConstraints($relationAlias = null) Adds a RIGHT JOIN clause to the query using the MontageConstraints relation
 * @method     ChildMontageQuery innerJoinMontageConstraints($relationAlias = null) Adds a INNER JOIN clause to the query using the MontageConstraints relation
 *
 * @method     ChildMontageQuery leftJoinProductHeizungMontage($relationAlias = null) Adds a LEFT JOIN clause to the query using the ProductHeizungMontage relation
 * @method     ChildMontageQuery rightJoinProductHeizungMontage($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ProductHeizungMontage relation
 * @method     ChildMontageQuery innerJoinProductHeizungMontage($relationAlias = null) Adds a INNER JOIN clause to the query using the ProductHeizungMontage relation
 *
 * @method     ChildMontageQuery leftJoinSetMontage($relationAlias = null) Adds a LEFT JOIN clause to the query using the SetMontage relation
 * @method     ChildMontageQuery rightJoinSetMontage($relationAlias = null) Adds a RIGHT JOIN clause to the query using the SetMontage relation
 * @method     ChildMontageQuery innerJoinSetMontage($relationAlias = null) Adds a INNER JOIN clause to the query using the SetMontage relation
 *
 * @method     ChildMontage findOne(ConnectionInterface $con = null) Return the first ChildMontage matching the query
 * @method     ChildMontage findOneOrCreate(ConnectionInterface $con = null) Return the first ChildMontage matching the query, or a new ChildMontage object populated from the query conditions when no match is found
 *
 * @method     ChildMontage findOneById(int $id) Return the first ChildMontage filtered by the id column
 * @method     ChildMontage findOneByCalendarId(int $calendar_id) Return the first ChildMontage filtered by the calendar_id column
 * @method     ChildMontage findOneByType(string $type) Return the first ChildMontage filtered by the type column
 * @method     ChildMontage findOneByQuantity(string $quantity) Return the first ChildMontage filtered by the quantity column
 * @method     ChildMontage findOneByUnit(string $unit) Return the first ChildMontage filtered by the unit column
 * @method     ChildMontage findOneByExtraQuantityPrice(string $extra_quantity_price) Return the first ChildMontage filtered by the extra_quantity_price column
 * @method     ChildMontage findOneByDuration(int $duration) Return the first ChildMontage filtered by the duration column
 *
 * @method     array findById(int $id) Return ChildMontage objects filtered by the id column
 * @method     array findByCalendarId(int $calendar_id) Return ChildMontage objects filtered by the calendar_id column
 * @method     array findByType(string $type) Return ChildMontage objects filtered by the type column
 * @method     array findByQuantity(string $quantity) Return ChildMontage objects filtered by the quantity column
 * @method     array findByUnit(string $unit) Return ChildMontage objects filtered by the unit column
 * @method     array findByExtraQuantityPrice(string $extra_quantity_price) Return ChildMontage objects filtered by the extra_quantity_price column
 * @method     array findByDuration(int $duration) Return ChildMontage objects filtered by the duration column
 *
 */
abstract class MontageQuery extends ModelCriteria
{
    
    /**
     * Initializes internal state of \Base\MontageQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'thelia', $modelName = '\\Montage', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildMontageQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildMontageQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \MontageQuery) {
            return $criteria;
        }
        $query = new \MontageQuery();
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
     * @return ChildMontage|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = MontageTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(MontageTableMap::DATABASE_NAME);
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
     * @return   ChildMontage A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ID, CALENDAR_ID, TYPE, QUANTITY, UNIT, EXTRA_QUANTITY_PRICE, DURATION FROM montage WHERE ID = :p0';
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
            $obj = new ChildMontage();
            $obj->hydrate($row);
            MontageTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildMontage|array|mixed the result, formatted by the current formatter
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
     * @return ChildMontageQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(MontageTableMap::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildMontageQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(MontageTableMap::ID, $keys, Criteria::IN);
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
     * @see       filterByProduct()
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildMontageQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(MontageTableMap::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(MontageTableMap::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MontageTableMap::ID, $id, $comparison);
    }

    /**
     * Filter the query on the calendar_id column
     *
     * Example usage:
     * <code>
     * $query->filterByCalendarId(1234); // WHERE calendar_id = 1234
     * $query->filterByCalendarId(array(12, 34)); // WHERE calendar_id IN (12, 34)
     * $query->filterByCalendarId(array('min' => 12)); // WHERE calendar_id > 12
     * </code>
     *
     * @param     mixed $calendarId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildMontageQuery The current query, for fluid interface
     */
    public function filterByCalendarId($calendarId = null, $comparison = null)
    {
        if (is_array($calendarId)) {
            $useMinMax = false;
            if (isset($calendarId['min'])) {
                $this->addUsingAlias(MontageTableMap::CALENDAR_ID, $calendarId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($calendarId['max'])) {
                $this->addUsingAlias(MontageTableMap::CALENDAR_ID, $calendarId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MontageTableMap::CALENDAR_ID, $calendarId, $comparison);
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
     * @return ChildMontageQuery The current query, for fluid interface
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

        return $this->addUsingAlias(MontageTableMap::TYPE, $type, $comparison);
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
     * @return ChildMontageQuery The current query, for fluid interface
     */
    public function filterByQuantity($quantity = null, $comparison = null)
    {
        if (is_array($quantity)) {
            $useMinMax = false;
            if (isset($quantity['min'])) {
                $this->addUsingAlias(MontageTableMap::QUANTITY, $quantity['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($quantity['max'])) {
                $this->addUsingAlias(MontageTableMap::QUANTITY, $quantity['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MontageTableMap::QUANTITY, $quantity, $comparison);
    }

    /**
     * Filter the query on the unit column
     *
     * Example usage:
     * <code>
     * $query->filterByUnit('fooValue');   // WHERE unit = 'fooValue'
     * $query->filterByUnit('%fooValue%'); // WHERE unit LIKE '%fooValue%'
     * </code>
     *
     * @param     string $unit The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildMontageQuery The current query, for fluid interface
     */
    public function filterByUnit($unit = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($unit)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $unit)) {
                $unit = str_replace('*', '%', $unit);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(MontageTableMap::UNIT, $unit, $comparison);
    }

    /**
     * Filter the query on the extra_quantity_price column
     *
     * Example usage:
     * <code>
     * $query->filterByExtraQuantityPrice(1234); // WHERE extra_quantity_price = 1234
     * $query->filterByExtraQuantityPrice(array(12, 34)); // WHERE extra_quantity_price IN (12, 34)
     * $query->filterByExtraQuantityPrice(array('min' => 12)); // WHERE extra_quantity_price > 12
     * </code>
     *
     * @param     mixed $extraQuantityPrice The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildMontageQuery The current query, for fluid interface
     */
    public function filterByExtraQuantityPrice($extraQuantityPrice = null, $comparison = null)
    {
        if (is_array($extraQuantityPrice)) {
            $useMinMax = false;
            if (isset($extraQuantityPrice['min'])) {
                $this->addUsingAlias(MontageTableMap::EXTRA_QUANTITY_PRICE, $extraQuantityPrice['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($extraQuantityPrice['max'])) {
                $this->addUsingAlias(MontageTableMap::EXTRA_QUANTITY_PRICE, $extraQuantityPrice['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MontageTableMap::EXTRA_QUANTITY_PRICE, $extraQuantityPrice, $comparison);
    }

    /**
     * Filter the query on the duration column
     *
     * Example usage:
     * <code>
     * $query->filterByDuration(1234); // WHERE duration = 1234
     * $query->filterByDuration(array(12, 34)); // WHERE duration IN (12, 34)
     * $query->filterByDuration(array('min' => 12)); // WHERE duration > 12
     * </code>
     *
     * @param     mixed $duration The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildMontageQuery The current query, for fluid interface
     */
    public function filterByDuration($duration = null, $comparison = null)
    {
        if (is_array($duration)) {
            $useMinMax = false;
            if (isset($duration['min'])) {
                $this->addUsingAlias(MontageTableMap::DURATION, $duration['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($duration['max'])) {
                $this->addUsingAlias(MontageTableMap::DURATION, $duration['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MontageTableMap::DURATION, $duration, $comparison);
    }

    /**
     * Filter the query by a related \Product object
     *
     * @param \Product|ObjectCollection $product The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildMontageQuery The current query, for fluid interface
     */
    public function filterByProduct($product, $comparison = null)
    {
        if ($product instanceof \Product) {
            return $this
                ->addUsingAlias(MontageTableMap::ID, $product->getId(), $comparison);
        } elseif ($product instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(MontageTableMap::ID, $product->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByProduct() only accepts arguments of type \Product or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Product relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildMontageQuery The current query, for fluid interface
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
     * @return   \ProductQuery A secondary query class using the current class as primary query
     */
    public function useProductQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinProduct($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Product', '\ProductQuery');
    }

    /**
     * Filter the query by a related \MontageConstraints object
     *
     * @param \MontageConstraints|ObjectCollection $montageConstraints  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildMontageQuery The current query, for fluid interface
     */
    public function filterByMontageConstraints($montageConstraints, $comparison = null)
    {
        if ($montageConstraints instanceof \MontageConstraints) {
            return $this
                ->addUsingAlias(MontageTableMap::ID, $montageConstraints->getMontageId(), $comparison);
        } elseif ($montageConstraints instanceof ObjectCollection) {
            return $this
                ->useMontageConstraintsQuery()
                ->filterByPrimaryKeys($montageConstraints->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByMontageConstraints() only accepts arguments of type \MontageConstraints or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the MontageConstraints relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildMontageQuery The current query, for fluid interface
     */
    public function joinMontageConstraints($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('MontageConstraints');

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
            $this->addJoinObject($join, 'MontageConstraints');
        }

        return $this;
    }

    /**
     * Use the MontageConstraints relation MontageConstraints object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \MontageConstraintsQuery A secondary query class using the current class as primary query
     */
    public function useMontageConstraintsQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinMontageConstraints($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'MontageConstraints', '\MontageConstraintsQuery');
    }

    /**
     * Filter the query by a related \ProductHeizungMontage object
     *
     * @param \ProductHeizungMontage|ObjectCollection $productHeizungMontage  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildMontageQuery The current query, for fluid interface
     */
    public function filterByProductHeizungMontage($productHeizungMontage, $comparison = null)
    {
        if ($productHeizungMontage instanceof \ProductHeizungMontage) {
            return $this
                ->addUsingAlias(MontageTableMap::ID, $productHeizungMontage->getMontageId(), $comparison);
        } elseif ($productHeizungMontage instanceof ObjectCollection) {
            return $this
                ->useProductHeizungMontageQuery()
                ->filterByPrimaryKeys($productHeizungMontage->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByProductHeizungMontage() only accepts arguments of type \ProductHeizungMontage or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ProductHeizungMontage relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildMontageQuery The current query, for fluid interface
     */
    public function joinProductHeizungMontage($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ProductHeizungMontage');

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
            $this->addJoinObject($join, 'ProductHeizungMontage');
        }

        return $this;
    }

    /**
     * Use the ProductHeizungMontage relation ProductHeizungMontage object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \ProductHeizungMontageQuery A secondary query class using the current class as primary query
     */
    public function useProductHeizungMontageQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinProductHeizungMontage($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ProductHeizungMontage', '\ProductHeizungMontageQuery');
    }

    /**
     * Filter the query by a related \SetMontage object
     *
     * @param \SetMontage|ObjectCollection $setMontage  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildMontageQuery The current query, for fluid interface
     */
    public function filterBySetMontage($setMontage, $comparison = null)
    {
        if ($setMontage instanceof \SetMontage) {
            return $this
                ->addUsingAlias(MontageTableMap::ID, $setMontage->getMontageId(), $comparison);
        } elseif ($setMontage instanceof ObjectCollection) {
            return $this
                ->useSetMontageQuery()
                ->filterByPrimaryKeys($setMontage->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterBySetMontage() only accepts arguments of type \SetMontage or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the SetMontage relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildMontageQuery The current query, for fluid interface
     */
    public function joinSetMontage($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('SetMontage');

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
            $this->addJoinObject($join, 'SetMontage');
        }

        return $this;
    }

    /**
     * Use the SetMontage relation SetMontage object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \SetMontageQuery A secondary query class using the current class as primary query
     */
    public function useSetMontageQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinSetMontage($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'SetMontage', '\SetMontageQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildMontage $montage Object to remove from the list of results
     *
     * @return ChildMontageQuery The current query, for fluid interface
     */
    public function prune($montage = null)
    {
        if ($montage) {
            $this->addUsingAlias(MontageTableMap::ID, $montage->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the montage table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(MontageTableMap::DATABASE_NAME);
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
            MontageTableMap::clearInstancePool();
            MontageTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildMontage or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildMontage object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(MontageTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(MontageTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            

        MontageTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            MontageTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

} // MontageQuery
