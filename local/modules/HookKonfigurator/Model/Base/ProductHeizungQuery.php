<?php

namespace HookKonfigurator\Model\Base;

use \Exception;
use \PDO;
use HookKonfigurator\Model\ProductHeizung as ChildProductHeizung;
use HookKonfigurator\Model\ProductHeizungQuery as ChildProductHeizungQuery;
use HookKonfigurator\Model\Map\ProductHeizungTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'product_heizung' table.
 *
 *
 *
 * @method     ChildProductHeizungQuery orderByProductId($order = Criteria::ASC) Order by the product_id column
 * @method     ChildProductHeizungQuery orderByGrade($order = Criteria::ASC) Order by the grade column
 * @method     ChildProductHeizungQuery orderByPower($order = Criteria::ASC) Order by the power column
 * @method     ChildProductHeizungQuery orderByEnergyEfficiency($order = Criteria::ASC) Order by the energy_efficiency column
 * @method     ChildProductHeizungQuery orderByPriority($order = Criteria::ASC) Order by the priority column
 * @method     ChildProductHeizungQuery orderByWarmWater($order = Criteria::ASC) Order by the warm_water column
 * @method     ChildProductHeizungQuery orderByEnergyCarrier($order = Criteria::ASC) Order by the energy_carrier column
 * @method     ChildProductHeizungQuery orderByStorageCapacity($order = Criteria::ASC) Order by the storage_capacity column
 *
 * @method     ChildProductHeizungQuery groupByProductId() Group by the product_id column
 * @method     ChildProductHeizungQuery groupByGrade() Group by the grade column
 * @method     ChildProductHeizungQuery groupByPower() Group by the power column
 * @method     ChildProductHeizungQuery groupByEnergyEfficiency() Group by the energy_efficiency column
 * @method     ChildProductHeizungQuery groupByPriority() Group by the priority column
 * @method     ChildProductHeizungQuery groupByWarmWater() Group by the warm_water column
 * @method     ChildProductHeizungQuery groupByEnergyCarrier() Group by the energy_carrier column
 * @method     ChildProductHeizungQuery groupByStorageCapacity() Group by the storage_capacity column
 *
 * @method     ChildProductHeizungQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildProductHeizungQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildProductHeizungQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildProductHeizungQuery leftJoinProduct($relationAlias = null) Adds a LEFT JOIN clause to the query using the Product relation
 * @method     ChildProductHeizungQuery rightJoinProduct($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Product relation
 * @method     ChildProductHeizungQuery innerJoinProduct($relationAlias = null) Adds a INNER JOIN clause to the query using the Product relation
 *
 * @method     ChildProductHeizungQuery leftJoinProductHeizungMontage($relationAlias = null) Adds a LEFT JOIN clause to the query using the ProductHeizungMontage relation
 * @method     ChildProductHeizungQuery rightJoinProductHeizungMontage($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ProductHeizungMontage relation
 * @method     ChildProductHeizungQuery innerJoinProductHeizungMontage($relationAlias = null) Adds a INNER JOIN clause to the query using the ProductHeizungMontage relation
 *
 * @method     ChildProductHeizungQuery leftJoinSetProducts($relationAlias = null) Adds a LEFT JOIN clause to the query using the SetProducts relation
 * @method     ChildProductHeizungQuery rightJoinSetProducts($relationAlias = null) Adds a RIGHT JOIN clause to the query using the SetProducts relation
 * @method     ChildProductHeizungQuery innerJoinSetProducts($relationAlias = null) Adds a INNER JOIN clause to the query using the SetProducts relation
 *
 * @method     ChildProductHeizung findOne(ConnectionInterface $con = null) Return the first ChildProductHeizung matching the query
 * @method     ChildProductHeizung findOneOrCreate(ConnectionInterface $con = null) Return the first ChildProductHeizung matching the query, or a new ChildProductHeizung object populated from the query conditions when no match is found
 *
 * @method     ChildProductHeizung findOneByProductId(int $product_id) Return the first ChildProductHeizung filtered by the product_id column
 * @method     ChildProductHeizung findOneByGrade(string $grade) Return the first ChildProductHeizung filtered by the grade column
 * @method     ChildProductHeizung findOneByPower(int $power) Return the first ChildProductHeizung filtered by the power column
 * @method     ChildProductHeizung findOneByEnergyEfficiency(int $energy_efficiency) Return the first ChildProductHeizung filtered by the energy_efficiency column
 * @method     ChildProductHeizung findOneByPriority(int $priority) Return the first ChildProductHeizung filtered by the priority column
 * @method     ChildProductHeizung findOneByWarmWater(boolean $warm_water) Return the first ChildProductHeizung filtered by the warm_water column
 * @method     ChildProductHeizung findOneByEnergyCarrier(string $energy_carrier) Return the first ChildProductHeizung filtered by the energy_carrier column
 * @method     ChildProductHeizung findOneByStorageCapacity(int $storage_capacity) Return the first ChildProductHeizung filtered by the storage_capacity column
 *
 * @method     array findByProductId(int $product_id) Return ChildProductHeizung objects filtered by the product_id column
 * @method     array findByGrade(string $grade) Return ChildProductHeizung objects filtered by the grade column
 * @method     array findByPower(int $power) Return ChildProductHeizung objects filtered by the power column
 * @method     array findByEnergyEfficiency(int $energy_efficiency) Return ChildProductHeizung objects filtered by the energy_efficiency column
 * @method     array findByPriority(int $priority) Return ChildProductHeizung objects filtered by the priority column
 * @method     array findByWarmWater(boolean $warm_water) Return ChildProductHeizung objects filtered by the warm_water column
 * @method     array findByEnergyCarrier(string $energy_carrier) Return ChildProductHeizung objects filtered by the energy_carrier column
 * @method     array findByStorageCapacity(int $storage_capacity) Return ChildProductHeizung objects filtered by the storage_capacity column
 *
 */
abstract class ProductHeizungQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \HookKonfigurator\Model\Base\ProductHeizungQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'thelia', $modelName = '\\HookKonfigurator\\Model\\ProductHeizung', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildProductHeizungQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildProductHeizungQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \HookKonfigurator\Model\ProductHeizungQuery) {
            return $criteria;
        }
        $query = new \HookKonfigurator\Model\ProductHeizungQuery();
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
     * @return ChildProductHeizung|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ProductHeizungTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ProductHeizungTableMap::DATABASE_NAME);
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
     * @return   ChildProductHeizung A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT PRODUCT_ID, GRADE, POWER, ENERGY_EFFICIENCY, PRIORITY, WARM_WATER, ENERGY_CARRIER, STORAGE_CAPACITY FROM product_heizung WHERE PRODUCT_ID = :p0';
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
            $obj = new ChildProductHeizung();
            $obj->hydrate($row);
            ProductHeizungTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildProductHeizung|array|mixed the result, formatted by the current formatter
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
     * @return ChildProductHeizungQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ProductHeizungTableMap::PRODUCT_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildProductHeizungQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ProductHeizungTableMap::PRODUCT_ID, $keys, Criteria::IN);
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
     * @return ChildProductHeizungQuery The current query, for fluid interface
     */
    public function filterByProductId($productId = null, $comparison = null)
    {
        if (is_array($productId)) {
            $useMinMax = false;
            if (isset($productId['min'])) {
                $this->addUsingAlias(ProductHeizungTableMap::PRODUCT_ID, $productId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($productId['max'])) {
                $this->addUsingAlias(ProductHeizungTableMap::PRODUCT_ID, $productId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProductHeizungTableMap::PRODUCT_ID, $productId, $comparison);
    }

    /**
     * Filter the query on the grade column
     *
     * Example usage:
     * <code>
     * $query->filterByGrade('fooValue');   // WHERE grade = 'fooValue'
     * $query->filterByGrade('%fooValue%'); // WHERE grade LIKE '%fooValue%'
     * </code>
     *
     * @param     string $grade The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildProductHeizungQuery The current query, for fluid interface
     */
    public function filterByGrade($grade = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($grade)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $grade)) {
                $grade = str_replace('*', '%', $grade);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ProductHeizungTableMap::GRADE, $grade, $comparison);
    }

    /**
     * Filter the query on the power column
     *
     * Example usage:
     * <code>
     * $query->filterByPower(1234); // WHERE power = 1234
     * $query->filterByPower(array(12, 34)); // WHERE power IN (12, 34)
     * $query->filterByPower(array('min' => 12)); // WHERE power > 12
     * </code>
     *
     * @param     mixed $power The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildProductHeizungQuery The current query, for fluid interface
     */
    public function filterByPower($power = null, $comparison = null)
    {
        if (is_array($power)) {
            $useMinMax = false;
            if (isset($power['min'])) {
                $this->addUsingAlias(ProductHeizungTableMap::POWER, $power['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($power['max'])) {
                $this->addUsingAlias(ProductHeizungTableMap::POWER, $power['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProductHeizungTableMap::POWER, $power, $comparison);
    }

    /**
     * Filter the query on the energy_efficiency column
     *
     * Example usage:
     * <code>
     * $query->filterByEnergyEfficiency(1234); // WHERE energy_efficiency = 1234
     * $query->filterByEnergyEfficiency(array(12, 34)); // WHERE energy_efficiency IN (12, 34)
     * $query->filterByEnergyEfficiency(array('min' => 12)); // WHERE energy_efficiency > 12
     * </code>
     *
     * @param     mixed $energyEfficiency The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildProductHeizungQuery The current query, for fluid interface
     */
    public function filterByEnergyEfficiency($energyEfficiency = null, $comparison = null)
    {
        if (is_array($energyEfficiency)) {
            $useMinMax = false;
            if (isset($energyEfficiency['min'])) {
                $this->addUsingAlias(ProductHeizungTableMap::ENERGY_EFFICIENCY, $energyEfficiency['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($energyEfficiency['max'])) {
                $this->addUsingAlias(ProductHeizungTableMap::ENERGY_EFFICIENCY, $energyEfficiency['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProductHeizungTableMap::ENERGY_EFFICIENCY, $energyEfficiency, $comparison);
    }

    /**
     * Filter the query on the priority column
     *
     * Example usage:
     * <code>
     * $query->filterByPriority(1234); // WHERE priority = 1234
     * $query->filterByPriority(array(12, 34)); // WHERE priority IN (12, 34)
     * $query->filterByPriority(array('min' => 12)); // WHERE priority > 12
     * </code>
     *
     * @param     mixed $priority The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildProductHeizungQuery The current query, for fluid interface
     */
    public function filterByPriority($priority = null, $comparison = null)
    {
        if (is_array($priority)) {
            $useMinMax = false;
            if (isset($priority['min'])) {
                $this->addUsingAlias(ProductHeizungTableMap::PRIORITY, $priority['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($priority['max'])) {
                $this->addUsingAlias(ProductHeizungTableMap::PRIORITY, $priority['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProductHeizungTableMap::PRIORITY, $priority, $comparison);
    }

    /**
     * Filter the query on the warm_water column
     *
     * Example usage:
     * <code>
     * $query->filterByWarmWater(true); // WHERE warm_water = true
     * $query->filterByWarmWater('yes'); // WHERE warm_water = true
     * </code>
     *
     * @param     boolean|string $warmWater The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildProductHeizungQuery The current query, for fluid interface
     */
    public function filterByWarmWater($warmWater = null, $comparison = null)
    {
        if (is_string($warmWater)) {
            $warm_water = in_array(strtolower($warmWater), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(ProductHeizungTableMap::WARM_WATER, $warmWater, $comparison);
    }

    /**
     * Filter the query on the energy_carrier column
     *
     * Example usage:
     * <code>
     * $query->filterByEnergyCarrier('fooValue');   // WHERE energy_carrier = 'fooValue'
     * $query->filterByEnergyCarrier('%fooValue%'); // WHERE energy_carrier LIKE '%fooValue%'
     * </code>
     *
     * @param     string $energyCarrier The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildProductHeizungQuery The current query, for fluid interface
     */
    public function filterByEnergyCarrier($energyCarrier = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($energyCarrier)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $energyCarrier)) {
                $energyCarrier = str_replace('*', '%', $energyCarrier);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ProductHeizungTableMap::ENERGY_CARRIER, $energyCarrier, $comparison);
    }

    /**
     * Filter the query on the storage_capacity column
     *
     * Example usage:
     * <code>
     * $query->filterByStorageCapacity(1234); // WHERE storage_capacity = 1234
     * $query->filterByStorageCapacity(array(12, 34)); // WHERE storage_capacity IN (12, 34)
     * $query->filterByStorageCapacity(array('min' => 12)); // WHERE storage_capacity > 12
     * </code>
     *
     * @param     mixed $storageCapacity The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildProductHeizungQuery The current query, for fluid interface
     */
    public function filterByStorageCapacity($storageCapacity = null, $comparison = null)
    {
        if (is_array($storageCapacity)) {
            $useMinMax = false;
            if (isset($storageCapacity['min'])) {
                $this->addUsingAlias(ProductHeizungTableMap::STORAGE_CAPACITY, $storageCapacity['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($storageCapacity['max'])) {
                $this->addUsingAlias(ProductHeizungTableMap::STORAGE_CAPACITY, $storageCapacity['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProductHeizungTableMap::STORAGE_CAPACITY, $storageCapacity, $comparison);
    }

    /**
     * Filter the query by a related \HookKonfigurator\Model\Product object
     *
     * @param \HookKonfigurator\Model\Product|ObjectCollection $product The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildProductHeizungQuery The current query, for fluid interface
     */
    public function filterByProduct($product, $comparison = null)
    {
        if ($product instanceof \HookKonfigurator\Model\Product) {
            return $this
                ->addUsingAlias(ProductHeizungTableMap::PRODUCT_ID, $product->getId(), $comparison);
        } elseif ($product instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ProductHeizungTableMap::PRODUCT_ID, $product->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByProduct() only accepts arguments of type \HookKonfigurator\Model\Product or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Product relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildProductHeizungQuery The current query, for fluid interface
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
     * @return   \HookKonfigurator\Model\ProductQuery A secondary query class using the current class as primary query
     */
    public function useProductQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinProduct($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Product', '\HookKonfigurator\Model\ProductQuery');
    }

    /**
     * Filter the query by a related \HookKonfigurator\Model\ProductHeizungMontage object
     *
     * @param \HookKonfigurator\Model\ProductHeizungMontage|ObjectCollection $productHeizungMontage  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildProductHeizungQuery The current query, for fluid interface
     */
    public function filterByProductHeizungMontage($productHeizungMontage, $comparison = null)
    {
        if ($productHeizungMontage instanceof \HookKonfigurator\Model\ProductHeizungMontage) {
            return $this
                ->addUsingAlias(ProductHeizungTableMap::PRODUCT_ID, $productHeizungMontage->getId(), $comparison);
        } elseif ($productHeizungMontage instanceof ObjectCollection) {
            return $this
                ->useProductHeizungMontageQuery()
                ->filterByPrimaryKeys($productHeizungMontage->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByProductHeizungMontage() only accepts arguments of type \HookKonfigurator\Model\ProductHeizungMontage or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ProductHeizungMontage relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildProductHeizungQuery The current query, for fluid interface
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
     * @return   \HookKonfigurator\Model\ProductHeizungMontageQuery A secondary query class using the current class as primary query
     */
    public function useProductHeizungMontageQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinProductHeizungMontage($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ProductHeizungMontage', '\HookKonfigurator\Model\ProductHeizungMontageQuery');
    }

    /**
     * Filter the query by a related \HookKonfigurator\Model\SetProducts object
     *
     * @param \HookKonfigurator\Model\SetProducts|ObjectCollection $setProducts  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildProductHeizungQuery The current query, for fluid interface
     */
    public function filterBySetProducts($setProducts, $comparison = null)
    {
        if ($setProducts instanceof \HookKonfigurator\Model\SetProducts) {
            return $this
                ->addUsingAlias(ProductHeizungTableMap::PRODUCT_ID, $setProducts->getId(), $comparison);
        } elseif ($setProducts instanceof ObjectCollection) {
            return $this
                ->useSetProductsQuery()
                ->filterByPrimaryKeys($setProducts->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterBySetProducts() only accepts arguments of type \HookKonfigurator\Model\SetProducts or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the SetProducts relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildProductHeizungQuery The current query, for fluid interface
     */
    public function joinSetProducts($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('SetProducts');

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
            $this->addJoinObject($join, 'SetProducts');
        }

        return $this;
    }

    /**
     * Use the SetProducts relation SetProducts object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \HookKonfigurator\Model\SetProductsQuery A secondary query class using the current class as primary query
     */
    public function useSetProductsQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinSetProducts($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'SetProducts', '\HookKonfigurator\Model\SetProductsQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildProductHeizung $productHeizung Object to remove from the list of results
     *
     * @return ChildProductHeizungQuery The current query, for fluid interface
     */
    public function prune($productHeizung = null)
    {
        if ($productHeizung) {
            $this->addUsingAlias(ProductHeizungTableMap::PRODUCT_ID, $productHeizung->getProductId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the product_heizung table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ProductHeizungTableMap::DATABASE_NAME);
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
            ProductHeizungTableMap::clearInstancePool();
            ProductHeizungTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildProductHeizung or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildProductHeizung object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(ProductHeizungTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ProductHeizungTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();


        ProductHeizungTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            ProductHeizungTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

} // ProductHeizungQuery
