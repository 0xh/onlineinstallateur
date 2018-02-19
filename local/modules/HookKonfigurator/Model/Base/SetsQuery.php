<?php

namespace HookKonfigurator\Model\Base;

use \Exception;
use \PDO;
use HookKonfigurator\Model\Sets as ChildSets;
use HookKonfigurator\Model\SetsQuery as ChildSetsQuery;
use HookKonfigurator\Model\Map\SetsTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'sets' table.
 *
 *
 *
 * @method     ChildSetsQuery orderByProductId($order = Criteria::ASC) Order by the product_id column
 * @method     ChildSetsQuery orderByPriority($order = Criteria::ASC) Order by the priority column
 * @method     ChildSetsQuery orderByEfficiency($order = Criteria::ASC) Order by the efficiency column
 * @method     ChildSetsQuery orderByPower($order = Criteria::ASC) Order by the power column
 * @method     ChildSetsQuery orderByComposedImage($order = Criteria::ASC) Order by the composed_image column
 * @method     ChildSetsQuery orderByStorage($order = Criteria::ASC) Order by the storage column
 *
 * @method     ChildSetsQuery groupByProductId() Group by the product_id column
 * @method     ChildSetsQuery groupByPriority() Group by the priority column
 * @method     ChildSetsQuery groupByEfficiency() Group by the efficiency column
 * @method     ChildSetsQuery groupByPower() Group by the power column
 * @method     ChildSetsQuery groupByComposedImage() Group by the composed_image column
 * @method     ChildSetsQuery groupByStorage() Group by the storage column
 *
 * @method     ChildSetsQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildSetsQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildSetsQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildSetsQuery leftJoinProduct($relationAlias = null) Adds a LEFT JOIN clause to the query using the Product relation
 * @method     ChildSetsQuery rightJoinProduct($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Product relation
 * @method     ChildSetsQuery innerJoinProduct($relationAlias = null) Adds a INNER JOIN clause to the query using the Product relation
 *
 * @method     ChildSetsQuery leftJoinSetMontage($relationAlias = null) Adds a LEFT JOIN clause to the query using the SetMontage relation
 * @method     ChildSetsQuery rightJoinSetMontage($relationAlias = null) Adds a RIGHT JOIN clause to the query using the SetMontage relation
 * @method     ChildSetsQuery innerJoinSetMontage($relationAlias = null) Adds a INNER JOIN clause to the query using the SetMontage relation
 *
 * @method     ChildSetsQuery leftJoinSetProducts($relationAlias = null) Adds a LEFT JOIN clause to the query using the SetProducts relation
 * @method     ChildSetsQuery rightJoinSetProducts($relationAlias = null) Adds a RIGHT JOIN clause to the query using the SetProducts relation
 * @method     ChildSetsQuery innerJoinSetProducts($relationAlias = null) Adds a INNER JOIN clause to the query using the SetProducts relation
 *
 * @method     ChildSets findOne(ConnectionInterface $con = null) Return the first ChildSets matching the query
 * @method     ChildSets findOneOrCreate(ConnectionInterface $con = null) Return the first ChildSets matching the query, or a new ChildSets object populated from the query conditions when no match is found
 *
 * @method     ChildSets findOneByProductId(int $product_id) Return the first ChildSets filtered by the product_id column
 * @method     ChildSets findOneByPriority(int $priority) Return the first ChildSets filtered by the priority column
 * @method     ChildSets findOneByEfficiency(int $efficiency) Return the first ChildSets filtered by the efficiency column
 * @method     ChildSets findOneByPower(int $power) Return the first ChildSets filtered by the power column
 * @method     ChildSets findOneByComposedImage(string $composed_image) Return the first ChildSets filtered by the composed_image column
 * @method     ChildSets findOneByStorage(int $storage) Return the first ChildSets filtered by the storage column
 *
 * @method     array findByProductId(int $product_id) Return ChildSets objects filtered by the product_id column
 * @method     array findByPriority(int $priority) Return ChildSets objects filtered by the priority column
 * @method     array findByEfficiency(int $efficiency) Return ChildSets objects filtered by the efficiency column
 * @method     array findByPower(int $power) Return ChildSets objects filtered by the power column
 * @method     array findByComposedImage(string $composed_image) Return ChildSets objects filtered by the composed_image column
 * @method     array findByStorage(int $storage) Return ChildSets objects filtered by the storage column
 *
 */
abstract class SetsQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \HookKonfigurator\Model\Base\SetsQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'thelia', $modelName = '\\HookKonfigurator\\Model\\Sets', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildSetsQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildSetsQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \HookKonfigurator\Model\SetsQuery) {
            return $criteria;
        }
        $query = new \HookKonfigurator\Model\SetsQuery();
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
     * @return ChildSets|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = SetsTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(SetsTableMap::DATABASE_NAME);
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
     * @return   ChildSets A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT PRODUCT_ID, PRIORITY, EFFICIENCY, POWER, COMPOSED_IMAGE, STORAGE FROM sets WHERE PRODUCT_ID = :p0';
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
            $obj = new ChildSets();
            $obj->hydrate($row);
            SetsTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildSets|array|mixed the result, formatted by the current formatter
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
     * @return ChildSetsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(SetsTableMap::PRODUCT_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildSetsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(SetsTableMap::PRODUCT_ID, $keys, Criteria::IN);
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
     * @return ChildSetsQuery The current query, for fluid interface
     */
    public function filterByProductId($productId = null, $comparison = null)
    {
        if (is_array($productId)) {
            $useMinMax = false;
            if (isset($productId['min'])) {
                $this->addUsingAlias(SetsTableMap::PRODUCT_ID, $productId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($productId['max'])) {
                $this->addUsingAlias(SetsTableMap::PRODUCT_ID, $productId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SetsTableMap::PRODUCT_ID, $productId, $comparison);
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
     * @return ChildSetsQuery The current query, for fluid interface
     */
    public function filterByPriority($priority = null, $comparison = null)
    {
        if (is_array($priority)) {
            $useMinMax = false;
            if (isset($priority['min'])) {
                $this->addUsingAlias(SetsTableMap::PRIORITY, $priority['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($priority['max'])) {
                $this->addUsingAlias(SetsTableMap::PRIORITY, $priority['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SetsTableMap::PRIORITY, $priority, $comparison);
    }

    /**
     * Filter the query on the efficiency column
     *
     * Example usage:
     * <code>
     * $query->filterByEfficiency(1234); // WHERE efficiency = 1234
     * $query->filterByEfficiency(array(12, 34)); // WHERE efficiency IN (12, 34)
     * $query->filterByEfficiency(array('min' => 12)); // WHERE efficiency > 12
     * </code>
     *
     * @param     mixed $efficiency The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSetsQuery The current query, for fluid interface
     */
    public function filterByEfficiency($efficiency = null, $comparison = null)
    {
        if (is_array($efficiency)) {
            $useMinMax = false;
            if (isset($efficiency['min'])) {
                $this->addUsingAlias(SetsTableMap::EFFICIENCY, $efficiency['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($efficiency['max'])) {
                $this->addUsingAlias(SetsTableMap::EFFICIENCY, $efficiency['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SetsTableMap::EFFICIENCY, $efficiency, $comparison);
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
     * @return ChildSetsQuery The current query, for fluid interface
     */
    public function filterByPower($power = null, $comparison = null)
    {
        if (is_array($power)) {
            $useMinMax = false;
            if (isset($power['min'])) {
                $this->addUsingAlias(SetsTableMap::POWER, $power['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($power['max'])) {
                $this->addUsingAlias(SetsTableMap::POWER, $power['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SetsTableMap::POWER, $power, $comparison);
    }

    /**
     * Filter the query on the composed_image column
     *
     * Example usage:
     * <code>
     * $query->filterByComposedImage('fooValue');   // WHERE composed_image = 'fooValue'
     * $query->filterByComposedImage('%fooValue%'); // WHERE composed_image LIKE '%fooValue%'
     * </code>
     *
     * @param     string $composedImage The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSetsQuery The current query, for fluid interface
     */
    public function filterByComposedImage($composedImage = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($composedImage)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $composedImage)) {
                $composedImage = str_replace('*', '%', $composedImage);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SetsTableMap::COMPOSED_IMAGE, $composedImage, $comparison);
    }

    /**
     * Filter the query on the storage column
     *
     * Example usage:
     * <code>
     * $query->filterByStorage(1234); // WHERE storage = 1234
     * $query->filterByStorage(array(12, 34)); // WHERE storage IN (12, 34)
     * $query->filterByStorage(array('min' => 12)); // WHERE storage > 12
     * </code>
     *
     * @param     mixed $storage The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSetsQuery The current query, for fluid interface
     */
    public function filterByStorage($storage = null, $comparison = null)
    {
        if (is_array($storage)) {
            $useMinMax = false;
            if (isset($storage['min'])) {
                $this->addUsingAlias(SetsTableMap::STORAGE, $storage['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($storage['max'])) {
                $this->addUsingAlias(SetsTableMap::STORAGE, $storage['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SetsTableMap::STORAGE, $storage, $comparison);
    }

    /**
     * Filter the query by a related \HookKonfigurator\Model\Product object
     *
     * @param \HookKonfigurator\Model\Product|ObjectCollection $product The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSetsQuery The current query, for fluid interface
     */
    public function filterByProduct($product, $comparison = null)
    {
        if ($product instanceof \HookKonfigurator\Model\Product) {
            return $this
                ->addUsingAlias(SetsTableMap::PRODUCT_ID, $product->getId(), $comparison);
        } elseif ($product instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(SetsTableMap::PRODUCT_ID, $product->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return ChildSetsQuery The current query, for fluid interface
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
     * Filter the query by a related \HookKonfigurator\Model\SetMontage object
     *
     * @param \HookKonfigurator\Model\SetMontage|ObjectCollection $setMontage  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSetsQuery The current query, for fluid interface
     */
    public function filterBySetMontage($setMontage, $comparison = null)
    {
        if ($setMontage instanceof \HookKonfigurator\Model\SetMontage) {
            return $this
                ->addUsingAlias(SetsTableMap::PRODUCT_ID, $setMontage->getId(), $comparison);
        } elseif ($setMontage instanceof ObjectCollection) {
            return $this
                ->useSetMontageQuery()
                ->filterByPrimaryKeys($setMontage->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterBySetMontage() only accepts arguments of type \HookKonfigurator\Model\SetMontage or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the SetMontage relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildSetsQuery The current query, for fluid interface
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
     * @return   \HookKonfigurator\Model\SetMontageQuery A secondary query class using the current class as primary query
     */
    public function useSetMontageQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinSetMontage($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'SetMontage', '\HookKonfigurator\Model\SetMontageQuery');
    }

    /**
     * Filter the query by a related \HookKonfigurator\Model\SetProducts object
     *
     * @param \HookKonfigurator\Model\SetProducts|ObjectCollection $setProducts  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSetsQuery The current query, for fluid interface
     */
    public function filterBySetProducts($setProducts, $comparison = null)
    {
        if ($setProducts instanceof \HookKonfigurator\Model\SetProducts) {
            return $this
                ->addUsingAlias(SetsTableMap::PRODUCT_ID, $setProducts->getId(), $comparison);
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
     * @return ChildSetsQuery The current query, for fluid interface
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
     * @param   ChildSets $sets Object to remove from the list of results
     *
     * @return ChildSetsQuery The current query, for fluid interface
     */
    public function prune($sets = null)
    {
        if ($sets) {
            $this->addUsingAlias(SetsTableMap::PRODUCT_ID, $sets->getProductId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the sets table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SetsTableMap::DATABASE_NAME);
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
            SetsTableMap::clearInstancePool();
            SetsTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildSets or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildSets object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(SetsTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(SetsTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();


        SetsTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            SetsTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

} // SetsQuery
