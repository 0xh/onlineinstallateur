<?php

namespace MultipleFullfilmentCenters\Model\Base;

use \Exception;
use \PDO;
use MultipleFullfilmentCenters\Model\FulfilmentCenterProducts as ChildFulfilmentCenterProducts;
use MultipleFullfilmentCenters\Model\FulfilmentCenterProductsQuery as ChildFulfilmentCenterProductsQuery;
use MultipleFullfilmentCenters\Model\Map\FulfilmentCenterProductsTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;
use Thelia\Model\Product;

/**
 * Base class that represents a query for the 'fulfilment_center_products' table.
 *
 * 
 *
 * @method     ChildFulfilmentCenterProductsQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildFulfilmentCenterProductsQuery orderByFulfilmentCenterId($order = Criteria::ASC) Order by the fulfilment_center_id column
 * @method     ChildFulfilmentCenterProductsQuery orderByProductId($order = Criteria::ASC) Order by the product_id column
 * @method     ChildFulfilmentCenterProductsQuery orderByProductStock($order = Criteria::ASC) Order by the product_stock column
 * @method     ChildFulfilmentCenterProductsQuery orderByIncomingStock($order = Criteria::ASC) Order by the incoming_stock column
 * @method     ChildFulfilmentCenterProductsQuery orderByOutgoingStock($order = Criteria::ASC) Order by the outgoing_stock column
 *
 * @method     ChildFulfilmentCenterProductsQuery groupById() Group by the id column
 * @method     ChildFulfilmentCenterProductsQuery groupByFulfilmentCenterId() Group by the fulfilment_center_id column
 * @method     ChildFulfilmentCenterProductsQuery groupByProductId() Group by the product_id column
 * @method     ChildFulfilmentCenterProductsQuery groupByProductStock() Group by the product_stock column
 * @method     ChildFulfilmentCenterProductsQuery groupByIncomingStock() Group by the incoming_stock column
 * @method     ChildFulfilmentCenterProductsQuery groupByOutgoingStock() Group by the outgoing_stock column
 *
 * @method     ChildFulfilmentCenterProductsQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildFulfilmentCenterProductsQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildFulfilmentCenterProductsQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildFulfilmentCenterProductsQuery leftJoinFulfilmentCenter($relationAlias = null) Adds a LEFT JOIN clause to the query using the FulfilmentCenter relation
 * @method     ChildFulfilmentCenterProductsQuery rightJoinFulfilmentCenter($relationAlias = null) Adds a RIGHT JOIN clause to the query using the FulfilmentCenter relation
 * @method     ChildFulfilmentCenterProductsQuery innerJoinFulfilmentCenter($relationAlias = null) Adds a INNER JOIN clause to the query using the FulfilmentCenter relation
 *
 * @method     ChildFulfilmentCenterProductsQuery leftJoinProduct($relationAlias = null) Adds a LEFT JOIN clause to the query using the Product relation
 * @method     ChildFulfilmentCenterProductsQuery rightJoinProduct($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Product relation
 * @method     ChildFulfilmentCenterProductsQuery innerJoinProduct($relationAlias = null) Adds a INNER JOIN clause to the query using the Product relation
 *
 * @method     ChildFulfilmentCenterProducts findOne(ConnectionInterface $con = null) Return the first ChildFulfilmentCenterProducts matching the query
 * @method     ChildFulfilmentCenterProducts findOneOrCreate(ConnectionInterface $con = null) Return the first ChildFulfilmentCenterProducts matching the query, or a new ChildFulfilmentCenterProducts object populated from the query conditions when no match is found
 *
 * @method     ChildFulfilmentCenterProducts findOneById(int $id) Return the first ChildFulfilmentCenterProducts filtered by the id column
 * @method     ChildFulfilmentCenterProducts findOneByFulfilmentCenterId(int $fulfilment_center_id) Return the first ChildFulfilmentCenterProducts filtered by the fulfilment_center_id column
 * @method     ChildFulfilmentCenterProducts findOneByProductId(int $product_id) Return the first ChildFulfilmentCenterProducts filtered by the product_id column
 * @method     ChildFulfilmentCenterProducts findOneByProductStock(int $product_stock) Return the first ChildFulfilmentCenterProducts filtered by the product_stock column
 * @method     ChildFulfilmentCenterProducts findOneByIncomingStock(int $incoming_stock) Return the first ChildFulfilmentCenterProducts filtered by the incoming_stock column
 * @method     ChildFulfilmentCenterProducts findOneByOutgoingStock(int $outgoing_stock) Return the first ChildFulfilmentCenterProducts filtered by the outgoing_stock column
 *
 * @method     array findById(int $id) Return ChildFulfilmentCenterProducts objects filtered by the id column
 * @method     array findByFulfilmentCenterId(int $fulfilment_center_id) Return ChildFulfilmentCenterProducts objects filtered by the fulfilment_center_id column
 * @method     array findByProductId(int $product_id) Return ChildFulfilmentCenterProducts objects filtered by the product_id column
 * @method     array findByProductStock(int $product_stock) Return ChildFulfilmentCenterProducts objects filtered by the product_stock column
 * @method     array findByIncomingStock(int $incoming_stock) Return ChildFulfilmentCenterProducts objects filtered by the incoming_stock column
 * @method     array findByOutgoingStock(int $outgoing_stock) Return ChildFulfilmentCenterProducts objects filtered by the outgoing_stock column
 *
 */
abstract class FulfilmentCenterProductsQuery extends ModelCriteria
{
    
    /**
     * Initializes internal state of \MultipleFullfilmentCenters\Model\Base\FulfilmentCenterProductsQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'thelia', $modelName = '\\MultipleFullfilmentCenters\\Model\\FulfilmentCenterProducts', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildFulfilmentCenterProductsQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildFulfilmentCenterProductsQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \MultipleFullfilmentCenters\Model\FulfilmentCenterProductsQuery) {
            return $criteria;
        }
        $query = new \MultipleFullfilmentCenters\Model\FulfilmentCenterProductsQuery();
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
     * @return ChildFulfilmentCenterProducts|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = FulfilmentCenterProductsTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(FulfilmentCenterProductsTableMap::DATABASE_NAME);
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
     * @return   ChildFulfilmentCenterProducts A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ID, FULFILMENT_CENTER_ID, PRODUCT_ID, PRODUCT_STOCK, INCOMING_STOCK, OUTGOING_STOCK FROM fulfilment_center_products WHERE ID = :p0';
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
            $obj = new ChildFulfilmentCenterProducts();
            $obj->hydrate($row);
            FulfilmentCenterProductsTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildFulfilmentCenterProducts|array|mixed the result, formatted by the current formatter
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
     * @return ChildFulfilmentCenterProductsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(FulfilmentCenterProductsTableMap::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildFulfilmentCenterProductsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(FulfilmentCenterProductsTableMap::ID, $keys, Criteria::IN);
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
     * @return ChildFulfilmentCenterProductsQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(FulfilmentCenterProductsTableMap::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(FulfilmentCenterProductsTableMap::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FulfilmentCenterProductsTableMap::ID, $id, $comparison);
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
     * @return ChildFulfilmentCenterProductsQuery The current query, for fluid interface
     */
    public function filterByFulfilmentCenterId($fulfilmentCenterId = null, $comparison = null)
    {
        if (is_array($fulfilmentCenterId)) {
            $useMinMax = false;
            if (isset($fulfilmentCenterId['min'])) {
                $this->addUsingAlias(FulfilmentCenterProductsTableMap::FULFILMENT_CENTER_ID, $fulfilmentCenterId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($fulfilmentCenterId['max'])) {
                $this->addUsingAlias(FulfilmentCenterProductsTableMap::FULFILMENT_CENTER_ID, $fulfilmentCenterId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FulfilmentCenterProductsTableMap::FULFILMENT_CENTER_ID, $fulfilmentCenterId, $comparison);
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
     * @return ChildFulfilmentCenterProductsQuery The current query, for fluid interface
     */
    public function filterByProductId($productId = null, $comparison = null)
    {
        if (is_array($productId)) {
            $useMinMax = false;
            if (isset($productId['min'])) {
                $this->addUsingAlias(FulfilmentCenterProductsTableMap::PRODUCT_ID, $productId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($productId['max'])) {
                $this->addUsingAlias(FulfilmentCenterProductsTableMap::PRODUCT_ID, $productId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FulfilmentCenterProductsTableMap::PRODUCT_ID, $productId, $comparison);
    }

    /**
     * Filter the query on the product_stock column
     *
     * Example usage:
     * <code>
     * $query->filterByProductStock(1234); // WHERE product_stock = 1234
     * $query->filterByProductStock(array(12, 34)); // WHERE product_stock IN (12, 34)
     * $query->filterByProductStock(array('min' => 12)); // WHERE product_stock > 12
     * </code>
     *
     * @param     mixed $productStock The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildFulfilmentCenterProductsQuery The current query, for fluid interface
     */
    public function filterByProductStock($productStock = null, $comparison = null)
    {
        if (is_array($productStock)) {
            $useMinMax = false;
            if (isset($productStock['min'])) {
                $this->addUsingAlias(FulfilmentCenterProductsTableMap::PRODUCT_STOCK, $productStock['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($productStock['max'])) {
                $this->addUsingAlias(FulfilmentCenterProductsTableMap::PRODUCT_STOCK, $productStock['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FulfilmentCenterProductsTableMap::PRODUCT_STOCK, $productStock, $comparison);
    }

    /**
     * Filter the query on the incoming_stock column
     *
     * Example usage:
     * <code>
     * $query->filterByIncomingStock(1234); // WHERE incoming_stock = 1234
     * $query->filterByIncomingStock(array(12, 34)); // WHERE incoming_stock IN (12, 34)
     * $query->filterByIncomingStock(array('min' => 12)); // WHERE incoming_stock > 12
     * </code>
     *
     * @param     mixed $incomingStock The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildFulfilmentCenterProductsQuery The current query, for fluid interface
     */
    public function filterByIncomingStock($incomingStock = null, $comparison = null)
    {
        if (is_array($incomingStock)) {
            $useMinMax = false;
            if (isset($incomingStock['min'])) {
                $this->addUsingAlias(FulfilmentCenterProductsTableMap::INCOMING_STOCK, $incomingStock['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($incomingStock['max'])) {
                $this->addUsingAlias(FulfilmentCenterProductsTableMap::INCOMING_STOCK, $incomingStock['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FulfilmentCenterProductsTableMap::INCOMING_STOCK, $incomingStock, $comparison);
    }

    /**
     * Filter the query on the outgoing_stock column
     *
     * Example usage:
     * <code>
     * $query->filterByOutgoingStock(1234); // WHERE outgoing_stock = 1234
     * $query->filterByOutgoingStock(array(12, 34)); // WHERE outgoing_stock IN (12, 34)
     * $query->filterByOutgoingStock(array('min' => 12)); // WHERE outgoing_stock > 12
     * </code>
     *
     * @param     mixed $outgoingStock The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildFulfilmentCenterProductsQuery The current query, for fluid interface
     */
    public function filterByOutgoingStock($outgoingStock = null, $comparison = null)
    {
        if (is_array($outgoingStock)) {
            $useMinMax = false;
            if (isset($outgoingStock['min'])) {
                $this->addUsingAlias(FulfilmentCenterProductsTableMap::OUTGOING_STOCK, $outgoingStock['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($outgoingStock['max'])) {
                $this->addUsingAlias(FulfilmentCenterProductsTableMap::OUTGOING_STOCK, $outgoingStock['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FulfilmentCenterProductsTableMap::OUTGOING_STOCK, $outgoingStock, $comparison);
    }

    /**
     * Filter the query by a related \MultipleFullfilmentCenters\Model\FulfilmentCenter object
     *
     * @param \MultipleFullfilmentCenters\Model\FulfilmentCenter|ObjectCollection $fulfilmentCenter The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildFulfilmentCenterProductsQuery The current query, for fluid interface
     */
    public function filterByFulfilmentCenter($fulfilmentCenter, $comparison = null)
    {
        if ($fulfilmentCenter instanceof \MultipleFullfilmentCenters\Model\FulfilmentCenter) {
            return $this
                ->addUsingAlias(FulfilmentCenterProductsTableMap::FULFILMENT_CENTER_ID, $fulfilmentCenter->getId(), $comparison);
        } elseif ($fulfilmentCenter instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(FulfilmentCenterProductsTableMap::FULFILMENT_CENTER_ID, $fulfilmentCenter->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return ChildFulfilmentCenterProductsQuery The current query, for fluid interface
     */
    public function joinFulfilmentCenter($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
    public function useFulfilmentCenterQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinFulfilmentCenter($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'FulfilmentCenter', '\MultipleFullfilmentCenters\Model\FulfilmentCenterQuery');
    }

    /**
     * Filter the query by a related \Thelia\Model\Product object
     *
     * @param \Thelia\Model\Product|ObjectCollection $product The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildFulfilmentCenterProductsQuery The current query, for fluid interface
     */
    public function filterByProduct($product, $comparison = null)
    {
        if ($product instanceof \Thelia\Model\Product) {
            return $this
                ->addUsingAlias(FulfilmentCenterProductsTableMap::PRODUCT_ID, $product->getId(), $comparison);
        } elseif ($product instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(FulfilmentCenterProductsTableMap::PRODUCT_ID, $product->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByProduct() only accepts arguments of type \Thelia\Model\Product or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Product relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildFulfilmentCenterProductsQuery The current query, for fluid interface
     */
    public function joinProduct($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
     * @return   \Thelia\Model\ProductQuery A secondary query class using the current class as primary query
     */
    public function useProductQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinProduct($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Product', '\Thelia\Model\ProductQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildFulfilmentCenterProducts $fulfilmentCenterProducts Object to remove from the list of results
     *
     * @return ChildFulfilmentCenterProductsQuery The current query, for fluid interface
     */
    public function prune($fulfilmentCenterProducts = null)
    {
        if ($fulfilmentCenterProducts) {
            $this->addUsingAlias(FulfilmentCenterProductsTableMap::ID, $fulfilmentCenterProducts->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the fulfilment_center_products table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(FulfilmentCenterProductsTableMap::DATABASE_NAME);
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
            FulfilmentCenterProductsTableMap::clearInstancePool();
            FulfilmentCenterProductsTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildFulfilmentCenterProducts or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildFulfilmentCenterProducts object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(FulfilmentCenterProductsTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(FulfilmentCenterProductsTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            

        FulfilmentCenterProductsTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            FulfilmentCenterProductsTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

} // FulfilmentCenterProductsQuery
