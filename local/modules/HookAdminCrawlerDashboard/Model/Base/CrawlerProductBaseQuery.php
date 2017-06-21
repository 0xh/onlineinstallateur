<?php

namespace Base;

use \CrawlerProductBase as ChildCrawlerProductBase;
use \CrawlerProductBaseQuery as ChildCrawlerProductBaseQuery;
use \Exception;
use \PDO;
use Map\CrawlerProductBaseTableMap;
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
 * Base class that represents a query for the 'crawler_product_base' table.
 *
 * 
 *
 * @method     ChildCrawlerProductBaseQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildCrawlerProductBaseQuery orderByProductId($order = Criteria::ASC) Order by the product_id column
 * @method     ChildCrawlerProductBaseQuery orderByActive($order = Criteria::ASC) Order by the active column
 * @method     ChildCrawlerProductBaseQuery orderByActionRequired($order = Criteria::ASC) Order by the action_required column
 * @method     ChildCrawlerProductBaseQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildCrawlerProductBaseQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 * @method     ChildCrawlerProductBaseQuery orderByVersion($order = Criteria::ASC) Order by the version column
 * @method     ChildCrawlerProductBaseQuery orderByVersionCreatedBy($order = Criteria::ASC) Order by the version_created_by column
 *
 * @method     ChildCrawlerProductBaseQuery groupById() Group by the id column
 * @method     ChildCrawlerProductBaseQuery groupByProductId() Group by the product_id column
 * @method     ChildCrawlerProductBaseQuery groupByActive() Group by the active column
 * @method     ChildCrawlerProductBaseQuery groupByActionRequired() Group by the action_required column
 * @method     ChildCrawlerProductBaseQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildCrawlerProductBaseQuery groupByUpdatedAt() Group by the updated_at column
 * @method     ChildCrawlerProductBaseQuery groupByVersion() Group by the version column
 * @method     ChildCrawlerProductBaseQuery groupByVersionCreatedBy() Group by the version_created_by column
 *
 * @method     ChildCrawlerProductBaseQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildCrawlerProductBaseQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildCrawlerProductBaseQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildCrawlerProductBaseQuery leftJoinProduct($relationAlias = null) Adds a LEFT JOIN clause to the query using the Product relation
 * @method     ChildCrawlerProductBaseQuery rightJoinProduct($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Product relation
 * @method     ChildCrawlerProductBaseQuery innerJoinProduct($relationAlias = null) Adds a INNER JOIN clause to the query using the Product relation
 *
 * @method     ChildCrawlerProductBaseQuery leftJoinCrawlerProductListing($relationAlias = null) Adds a LEFT JOIN clause to the query using the CrawlerProductListing relation
 * @method     ChildCrawlerProductBaseQuery rightJoinCrawlerProductListing($relationAlias = null) Adds a RIGHT JOIN clause to the query using the CrawlerProductListing relation
 * @method     ChildCrawlerProductBaseQuery innerJoinCrawlerProductListing($relationAlias = null) Adds a INNER JOIN clause to the query using the CrawlerProductListing relation
 *
 * @method     ChildCrawlerProductBaseQuery leftJoinCrawlerProductBaseVersion($relationAlias = null) Adds a LEFT JOIN clause to the query using the CrawlerProductBaseVersion relation
 * @method     ChildCrawlerProductBaseQuery rightJoinCrawlerProductBaseVersion($relationAlias = null) Adds a RIGHT JOIN clause to the query using the CrawlerProductBaseVersion relation
 * @method     ChildCrawlerProductBaseQuery innerJoinCrawlerProductBaseVersion($relationAlias = null) Adds a INNER JOIN clause to the query using the CrawlerProductBaseVersion relation
 *
 * @method     ChildCrawlerProductBase findOne(ConnectionInterface $con = null) Return the first ChildCrawlerProductBase matching the query
 * @method     ChildCrawlerProductBase findOneOrCreate(ConnectionInterface $con = null) Return the first ChildCrawlerProductBase matching the query, or a new ChildCrawlerProductBase object populated from the query conditions when no match is found
 *
 * @method     ChildCrawlerProductBase findOneById(int $id) Return the first ChildCrawlerProductBase filtered by the id column
 * @method     ChildCrawlerProductBase findOneByProductId(int $product_id) Return the first ChildCrawlerProductBase filtered by the product_id column
 * @method     ChildCrawlerProductBase findOneByActive(int $active) Return the first ChildCrawlerProductBase filtered by the active column
 * @method     ChildCrawlerProductBase findOneByActionRequired(int $action_required) Return the first ChildCrawlerProductBase filtered by the action_required column
 * @method     ChildCrawlerProductBase findOneByCreatedAt(string $created_at) Return the first ChildCrawlerProductBase filtered by the created_at column
 * @method     ChildCrawlerProductBase findOneByUpdatedAt(string $updated_at) Return the first ChildCrawlerProductBase filtered by the updated_at column
 * @method     ChildCrawlerProductBase findOneByVersion(int $version) Return the first ChildCrawlerProductBase filtered by the version column
 * @method     ChildCrawlerProductBase findOneByVersionCreatedBy(string $version_created_by) Return the first ChildCrawlerProductBase filtered by the version_created_by column
 *
 * @method     array findById(int $id) Return ChildCrawlerProductBase objects filtered by the id column
 * @method     array findByProductId(int $product_id) Return ChildCrawlerProductBase objects filtered by the product_id column
 * @method     array findByActive(int $active) Return ChildCrawlerProductBase objects filtered by the active column
 * @method     array findByActionRequired(int $action_required) Return ChildCrawlerProductBase objects filtered by the action_required column
 * @method     array findByCreatedAt(string $created_at) Return ChildCrawlerProductBase objects filtered by the created_at column
 * @method     array findByUpdatedAt(string $updated_at) Return ChildCrawlerProductBase objects filtered by the updated_at column
 * @method     array findByVersion(int $version) Return ChildCrawlerProductBase objects filtered by the version column
 * @method     array findByVersionCreatedBy(string $version_created_by) Return ChildCrawlerProductBase objects filtered by the version_created_by column
 *
 */
abstract class CrawlerProductBaseQuery extends ModelCriteria
{
    
    // versionable behavior
    
    /**
     * Whether the versioning is enabled
     */
    static $isVersioningEnabled = true;

    /**
     * Initializes internal state of \Base\CrawlerProductBaseQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'thelia', $modelName = '\\CrawlerProductBase', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildCrawlerProductBaseQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildCrawlerProductBaseQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \CrawlerProductBaseQuery) {
            return $criteria;
        }
        $query = new \CrawlerProductBaseQuery();
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
     * @return ChildCrawlerProductBase|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = CrawlerProductBaseTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(CrawlerProductBaseTableMap::DATABASE_NAME);
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
     * @return   ChildCrawlerProductBase A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ID, PRODUCT_ID, ACTIVE, ACTION_REQUIRED, CREATED_AT, UPDATED_AT, VERSION, VERSION_CREATED_BY FROM crawler_product_base WHERE ID = :p0';
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
            $obj = new ChildCrawlerProductBase();
            $obj->hydrate($row);
            CrawlerProductBaseTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildCrawlerProductBase|array|mixed the result, formatted by the current formatter
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
     * @return ChildCrawlerProductBaseQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(CrawlerProductBaseTableMap::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildCrawlerProductBaseQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(CrawlerProductBaseTableMap::ID, $keys, Criteria::IN);
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
     * @return ChildCrawlerProductBaseQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(CrawlerProductBaseTableMap::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(CrawlerProductBaseTableMap::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CrawlerProductBaseTableMap::ID, $id, $comparison);
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
     * @return ChildCrawlerProductBaseQuery The current query, for fluid interface
     */
    public function filterByProductId($productId = null, $comparison = null)
    {
        if (is_array($productId)) {
            $useMinMax = false;
            if (isset($productId['min'])) {
                $this->addUsingAlias(CrawlerProductBaseTableMap::PRODUCT_ID, $productId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($productId['max'])) {
                $this->addUsingAlias(CrawlerProductBaseTableMap::PRODUCT_ID, $productId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CrawlerProductBaseTableMap::PRODUCT_ID, $productId, $comparison);
    }

    /**
     * Filter the query on the active column
     *
     * Example usage:
     * <code>
     * $query->filterByActive(1234); // WHERE active = 1234
     * $query->filterByActive(array(12, 34)); // WHERE active IN (12, 34)
     * $query->filterByActive(array('min' => 12)); // WHERE active > 12
     * </code>
     *
     * @param     mixed $active The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCrawlerProductBaseQuery The current query, for fluid interface
     */
    public function filterByActive($active = null, $comparison = null)
    {
        if (is_array($active)) {
            $useMinMax = false;
            if (isset($active['min'])) {
                $this->addUsingAlias(CrawlerProductBaseTableMap::ACTIVE, $active['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($active['max'])) {
                $this->addUsingAlias(CrawlerProductBaseTableMap::ACTIVE, $active['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CrawlerProductBaseTableMap::ACTIVE, $active, $comparison);
    }

    /**
     * Filter the query on the action_required column
     *
     * Example usage:
     * <code>
     * $query->filterByActionRequired(1234); // WHERE action_required = 1234
     * $query->filterByActionRequired(array(12, 34)); // WHERE action_required IN (12, 34)
     * $query->filterByActionRequired(array('min' => 12)); // WHERE action_required > 12
     * </code>
     *
     * @param     mixed $actionRequired The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCrawlerProductBaseQuery The current query, for fluid interface
     */
    public function filterByActionRequired($actionRequired = null, $comparison = null)
    {
        if (is_array($actionRequired)) {
            $useMinMax = false;
            if (isset($actionRequired['min'])) {
                $this->addUsingAlias(CrawlerProductBaseTableMap::ACTION_REQUIRED, $actionRequired['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($actionRequired['max'])) {
                $this->addUsingAlias(CrawlerProductBaseTableMap::ACTION_REQUIRED, $actionRequired['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CrawlerProductBaseTableMap::ACTION_REQUIRED, $actionRequired, $comparison);
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
     * @return ChildCrawlerProductBaseQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(CrawlerProductBaseTableMap::CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(CrawlerProductBaseTableMap::CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CrawlerProductBaseTableMap::CREATED_AT, $createdAt, $comparison);
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
     * @return ChildCrawlerProductBaseQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(CrawlerProductBaseTableMap::UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(CrawlerProductBaseTableMap::UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CrawlerProductBaseTableMap::UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Filter the query on the version column
     *
     * Example usage:
     * <code>
     * $query->filterByVersion(1234); // WHERE version = 1234
     * $query->filterByVersion(array(12, 34)); // WHERE version IN (12, 34)
     * $query->filterByVersion(array('min' => 12)); // WHERE version > 12
     * </code>
     *
     * @param     mixed $version The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCrawlerProductBaseQuery The current query, for fluid interface
     */
    public function filterByVersion($version = null, $comparison = null)
    {
        if (is_array($version)) {
            $useMinMax = false;
            if (isset($version['min'])) {
                $this->addUsingAlias(CrawlerProductBaseTableMap::VERSION, $version['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($version['max'])) {
                $this->addUsingAlias(CrawlerProductBaseTableMap::VERSION, $version['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CrawlerProductBaseTableMap::VERSION, $version, $comparison);
    }

    /**
     * Filter the query on the version_created_by column
     *
     * Example usage:
     * <code>
     * $query->filterByVersionCreatedBy('fooValue');   // WHERE version_created_by = 'fooValue'
     * $query->filterByVersionCreatedBy('%fooValue%'); // WHERE version_created_by LIKE '%fooValue%'
     * </code>
     *
     * @param     string $versionCreatedBy The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCrawlerProductBaseQuery The current query, for fluid interface
     */
    public function filterByVersionCreatedBy($versionCreatedBy = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($versionCreatedBy)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $versionCreatedBy)) {
                $versionCreatedBy = str_replace('*', '%', $versionCreatedBy);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(CrawlerProductBaseTableMap::VERSION_CREATED_BY, $versionCreatedBy, $comparison);
    }

    /**
     * Filter the query by a related \Thelia\Model\Product object
     *
     * @param \Thelia\Model\Product|ObjectCollection $product The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCrawlerProductBaseQuery The current query, for fluid interface
     */
    public function filterByProduct($product, $comparison = null)
    {
        if ($product instanceof \Thelia\Model\Product) {
            return $this
                ->addUsingAlias(CrawlerProductBaseTableMap::PRODUCT_ID, $product->getId(), $comparison);
        } elseif ($product instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(CrawlerProductBaseTableMap::PRODUCT_ID, $product->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return ChildCrawlerProductBaseQuery The current query, for fluid interface
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
     * Filter the query by a related \CrawlerProductListing object
     *
     * @param \CrawlerProductListing|ObjectCollection $crawlerProductListing  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCrawlerProductBaseQuery The current query, for fluid interface
     */
    public function filterByCrawlerProductListing($crawlerProductListing, $comparison = null)
    {
        if ($crawlerProductListing instanceof \CrawlerProductListing) {
            return $this
                ->addUsingAlias(CrawlerProductBaseTableMap::ID, $crawlerProductListing->getProductBaseId(), $comparison);
        } elseif ($crawlerProductListing instanceof ObjectCollection) {
            return $this
                ->useCrawlerProductListingQuery()
                ->filterByPrimaryKeys($crawlerProductListing->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByCrawlerProductListing() only accepts arguments of type \CrawlerProductListing or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the CrawlerProductListing relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildCrawlerProductBaseQuery The current query, for fluid interface
     */
    public function joinCrawlerProductListing($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('CrawlerProductListing');

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
            $this->addJoinObject($join, 'CrawlerProductListing');
        }

        return $this;
    }

    /**
     * Use the CrawlerProductListing relation CrawlerProductListing object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \CrawlerProductListingQuery A secondary query class using the current class as primary query
     */
    public function useCrawlerProductListingQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinCrawlerProductListing($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'CrawlerProductListing', '\CrawlerProductListingQuery');
    }

    /**
     * Filter the query by a related \CrawlerProductBaseVersion object
     *
     * @param \CrawlerProductBaseVersion|ObjectCollection $crawlerProductBaseVersion  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCrawlerProductBaseQuery The current query, for fluid interface
     */
    public function filterByCrawlerProductBaseVersion($crawlerProductBaseVersion, $comparison = null)
    {
        if ($crawlerProductBaseVersion instanceof \CrawlerProductBaseVersion) {
            return $this
                ->addUsingAlias(CrawlerProductBaseTableMap::ID, $crawlerProductBaseVersion->getId(), $comparison);
        } elseif ($crawlerProductBaseVersion instanceof ObjectCollection) {
            return $this
                ->useCrawlerProductBaseVersionQuery()
                ->filterByPrimaryKeys($crawlerProductBaseVersion->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByCrawlerProductBaseVersion() only accepts arguments of type \CrawlerProductBaseVersion or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the CrawlerProductBaseVersion relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildCrawlerProductBaseQuery The current query, for fluid interface
     */
    public function joinCrawlerProductBaseVersion($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('CrawlerProductBaseVersion');

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
            $this->addJoinObject($join, 'CrawlerProductBaseVersion');
        }

        return $this;
    }

    /**
     * Use the CrawlerProductBaseVersion relation CrawlerProductBaseVersion object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \CrawlerProductBaseVersionQuery A secondary query class using the current class as primary query
     */
    public function useCrawlerProductBaseVersionQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinCrawlerProductBaseVersion($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'CrawlerProductBaseVersion', '\CrawlerProductBaseVersionQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildCrawlerProductBase $crawlerProductBase Object to remove from the list of results
     *
     * @return ChildCrawlerProductBaseQuery The current query, for fluid interface
     */
    public function prune($crawlerProductBase = null)
    {
        if ($crawlerProductBase) {
            $this->addUsingAlias(CrawlerProductBaseTableMap::ID, $crawlerProductBase->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the crawler_product_base table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CrawlerProductBaseTableMap::DATABASE_NAME);
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
            CrawlerProductBaseTableMap::clearInstancePool();
            CrawlerProductBaseTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildCrawlerProductBase or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildCrawlerProductBase object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(CrawlerProductBaseTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(CrawlerProductBaseTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            

        CrawlerProductBaseTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            CrawlerProductBaseTableMap::clearRelatedInstancePool();
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
     * @return     ChildCrawlerProductBaseQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(CrawlerProductBaseTableMap::UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }
    
    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     ChildCrawlerProductBaseQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(CrawlerProductBaseTableMap::CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }
    
    /**
     * Order by update date desc
     *
     * @return     ChildCrawlerProductBaseQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(CrawlerProductBaseTableMap::UPDATED_AT);
    }
    
    /**
     * Order by update date asc
     *
     * @return     ChildCrawlerProductBaseQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(CrawlerProductBaseTableMap::UPDATED_AT);
    }
    
    /**
     * Order by create date desc
     *
     * @return     ChildCrawlerProductBaseQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(CrawlerProductBaseTableMap::CREATED_AT);
    }
    
    /**
     * Order by create date asc
     *
     * @return     ChildCrawlerProductBaseQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(CrawlerProductBaseTableMap::CREATED_AT);
    }

    // versionable behavior
    
    /**
     * Checks whether versioning is enabled
     *
     * @return boolean
     */
    static public function isVersioningEnabled()
    {
        return self::$isVersioningEnabled;
    }
    
    /**
     * Enables versioning
     */
    static public function enableVersioning()
    {
        self::$isVersioningEnabled = true;
    }
    
    /**
     * Disables versioning
     */
    static public function disableVersioning()
    {
        self::$isVersioningEnabled = false;
    }

} // CrawlerProductBaseQuery
