<?php

namespace Base;

use \CrawlerProductBaseVersion as ChildCrawlerProductBaseVersion;
use \CrawlerProductBaseVersionQuery as ChildCrawlerProductBaseVersionQuery;
use \Exception;
use \PDO;
use Map\CrawlerProductBaseVersionTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'crawler_product_base_version' table.
 *
 * 
 *
 * @method     ChildCrawlerProductBaseVersionQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildCrawlerProductBaseVersionQuery orderByProductId($order = Criteria::ASC) Order by the product_id column
 * @method     ChildCrawlerProductBaseVersionQuery orderByActive($order = Criteria::ASC) Order by the active column
 * @method     ChildCrawlerProductBaseVersionQuery orderByActionRequired($order = Criteria::ASC) Order by the action_required column
 * @method     ChildCrawlerProductBaseVersionQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildCrawlerProductBaseVersionQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 * @method     ChildCrawlerProductBaseVersionQuery orderByVersion($order = Criteria::ASC) Order by the version column
 * @method     ChildCrawlerProductBaseVersionQuery orderByVersionCreatedBy($order = Criteria::ASC) Order by the version_created_by column
 * @method     ChildCrawlerProductBaseVersionQuery orderByProductIdVersion($order = Criteria::ASC) Order by the product_id_version column
 * @method     ChildCrawlerProductBaseVersionQuery orderByCrawlerProductListingIds($order = Criteria::ASC) Order by the crawler_product_listing_ids column
 * @method     ChildCrawlerProductBaseVersionQuery orderByCrawlerProductListingVersions($order = Criteria::ASC) Order by the crawler_product_listing_versions column
 *
 * @method     ChildCrawlerProductBaseVersionQuery groupById() Group by the id column
 * @method     ChildCrawlerProductBaseVersionQuery groupByProductId() Group by the product_id column
 * @method     ChildCrawlerProductBaseVersionQuery groupByActive() Group by the active column
 * @method     ChildCrawlerProductBaseVersionQuery groupByActionRequired() Group by the action_required column
 * @method     ChildCrawlerProductBaseVersionQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildCrawlerProductBaseVersionQuery groupByUpdatedAt() Group by the updated_at column
 * @method     ChildCrawlerProductBaseVersionQuery groupByVersion() Group by the version column
 * @method     ChildCrawlerProductBaseVersionQuery groupByVersionCreatedBy() Group by the version_created_by column
 * @method     ChildCrawlerProductBaseVersionQuery groupByProductIdVersion() Group by the product_id_version column
 * @method     ChildCrawlerProductBaseVersionQuery groupByCrawlerProductListingIds() Group by the crawler_product_listing_ids column
 * @method     ChildCrawlerProductBaseVersionQuery groupByCrawlerProductListingVersions() Group by the crawler_product_listing_versions column
 *
 * @method     ChildCrawlerProductBaseVersionQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildCrawlerProductBaseVersionQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildCrawlerProductBaseVersionQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildCrawlerProductBaseVersionQuery leftJoinCrawlerProductBase($relationAlias = null) Adds a LEFT JOIN clause to the query using the CrawlerProductBase relation
 * @method     ChildCrawlerProductBaseVersionQuery rightJoinCrawlerProductBase($relationAlias = null) Adds a RIGHT JOIN clause to the query using the CrawlerProductBase relation
 * @method     ChildCrawlerProductBaseVersionQuery innerJoinCrawlerProductBase($relationAlias = null) Adds a INNER JOIN clause to the query using the CrawlerProductBase relation
 *
 * @method     ChildCrawlerProductBaseVersion findOne(ConnectionInterface $con = null) Return the first ChildCrawlerProductBaseVersion matching the query
 * @method     ChildCrawlerProductBaseVersion findOneOrCreate(ConnectionInterface $con = null) Return the first ChildCrawlerProductBaseVersion matching the query, or a new ChildCrawlerProductBaseVersion object populated from the query conditions when no match is found
 *
 * @method     ChildCrawlerProductBaseVersion findOneById(int $id) Return the first ChildCrawlerProductBaseVersion filtered by the id column
 * @method     ChildCrawlerProductBaseVersion findOneByProductId(int $product_id) Return the first ChildCrawlerProductBaseVersion filtered by the product_id column
 * @method     ChildCrawlerProductBaseVersion findOneByActive(int $active) Return the first ChildCrawlerProductBaseVersion filtered by the active column
 * @method     ChildCrawlerProductBaseVersion findOneByActionRequired(int $action_required) Return the first ChildCrawlerProductBaseVersion filtered by the action_required column
 * @method     ChildCrawlerProductBaseVersion findOneByCreatedAt(string $created_at) Return the first ChildCrawlerProductBaseVersion filtered by the created_at column
 * @method     ChildCrawlerProductBaseVersion findOneByUpdatedAt(string $updated_at) Return the first ChildCrawlerProductBaseVersion filtered by the updated_at column
 * @method     ChildCrawlerProductBaseVersion findOneByVersion(int $version) Return the first ChildCrawlerProductBaseVersion filtered by the version column
 * @method     ChildCrawlerProductBaseVersion findOneByVersionCreatedBy(string $version_created_by) Return the first ChildCrawlerProductBaseVersion filtered by the version_created_by column
 * @method     ChildCrawlerProductBaseVersion findOneByProductIdVersion(int $product_id_version) Return the first ChildCrawlerProductBaseVersion filtered by the product_id_version column
 * @method     ChildCrawlerProductBaseVersion findOneByCrawlerProductListingIds(array $crawler_product_listing_ids) Return the first ChildCrawlerProductBaseVersion filtered by the crawler_product_listing_ids column
 * @method     ChildCrawlerProductBaseVersion findOneByCrawlerProductListingVersions(array $crawler_product_listing_versions) Return the first ChildCrawlerProductBaseVersion filtered by the crawler_product_listing_versions column
 *
 * @method     array findById(int $id) Return ChildCrawlerProductBaseVersion objects filtered by the id column
 * @method     array findByProductId(int $product_id) Return ChildCrawlerProductBaseVersion objects filtered by the product_id column
 * @method     array findByActive(int $active) Return ChildCrawlerProductBaseVersion objects filtered by the active column
 * @method     array findByActionRequired(int $action_required) Return ChildCrawlerProductBaseVersion objects filtered by the action_required column
 * @method     array findByCreatedAt(string $created_at) Return ChildCrawlerProductBaseVersion objects filtered by the created_at column
 * @method     array findByUpdatedAt(string $updated_at) Return ChildCrawlerProductBaseVersion objects filtered by the updated_at column
 * @method     array findByVersion(int $version) Return ChildCrawlerProductBaseVersion objects filtered by the version column
 * @method     array findByVersionCreatedBy(string $version_created_by) Return ChildCrawlerProductBaseVersion objects filtered by the version_created_by column
 * @method     array findByProductIdVersion(int $product_id_version) Return ChildCrawlerProductBaseVersion objects filtered by the product_id_version column
 * @method     array findByCrawlerProductListingIds(array $crawler_product_listing_ids) Return ChildCrawlerProductBaseVersion objects filtered by the crawler_product_listing_ids column
 * @method     array findByCrawlerProductListingVersions(array $crawler_product_listing_versions) Return ChildCrawlerProductBaseVersion objects filtered by the crawler_product_listing_versions column
 *
 */
abstract class CrawlerProductBaseVersionQuery extends ModelCriteria
{
    
    /**
     * Initializes internal state of \Base\CrawlerProductBaseVersionQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'thelia', $modelName = '\\CrawlerProductBaseVersion', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildCrawlerProductBaseVersionQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildCrawlerProductBaseVersionQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \CrawlerProductBaseVersionQuery) {
            return $criteria;
        }
        $query = new \CrawlerProductBaseVersionQuery();
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
     * $obj = $c->findPk(array(12, 34), $con);
     * </code>
     *
     * @param array[$id, $version] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildCrawlerProductBaseVersion|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = CrawlerProductBaseVersionTableMap::getInstanceFromPool(serialize(array((string) $key[0], (string) $key[1]))))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(CrawlerProductBaseVersionTableMap::DATABASE_NAME);
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
     * @return   ChildCrawlerProductBaseVersion A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ID, PRODUCT_ID, ACTIVE, ACTION_REQUIRED, CREATED_AT, UPDATED_AT, VERSION, VERSION_CREATED_BY, PRODUCT_ID_VERSION, CRAWLER_PRODUCT_LISTING_IDS, CRAWLER_PRODUCT_LISTING_VERSIONS FROM crawler_product_base_version WHERE ID = :p0 AND VERSION = :p1';
        try {
            $stmt = $con->prepare($sql);            
            $stmt->bindValue(':p0', $key[0], PDO::PARAM_INT);            
            $stmt->bindValue(':p1', $key[1], PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            $obj = new ChildCrawlerProductBaseVersion();
            $obj->hydrate($row);
            CrawlerProductBaseVersionTableMap::addInstanceToPool($obj, serialize(array((string) $key[0], (string) $key[1])));
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
     * @return ChildCrawlerProductBaseVersion|array|mixed the result, formatted by the current formatter
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
     * $objs = $c->findPks(array(array(12, 56), array(832, 123), array(123, 456)), $con);
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
     * @return ChildCrawlerProductBaseVersionQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(CrawlerProductBaseVersionTableMap::ID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(CrawlerProductBaseVersionTableMap::VERSION, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildCrawlerProductBaseVersionQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(CrawlerProductBaseVersionTableMap::ID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(CrawlerProductBaseVersionTableMap::VERSION, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $this->addOr($cton0);
        }

        return $this;
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
     * @see       filterByCrawlerProductBase()
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCrawlerProductBaseVersionQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(CrawlerProductBaseVersionTableMap::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(CrawlerProductBaseVersionTableMap::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CrawlerProductBaseVersionTableMap::ID, $id, $comparison);
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
     * @param     mixed $productId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCrawlerProductBaseVersionQuery The current query, for fluid interface
     */
    public function filterByProductId($productId = null, $comparison = null)
    {
        if (is_array($productId)) {
            $useMinMax = false;
            if (isset($productId['min'])) {
                $this->addUsingAlias(CrawlerProductBaseVersionTableMap::PRODUCT_ID, $productId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($productId['max'])) {
                $this->addUsingAlias(CrawlerProductBaseVersionTableMap::PRODUCT_ID, $productId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CrawlerProductBaseVersionTableMap::PRODUCT_ID, $productId, $comparison);
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
     * @return ChildCrawlerProductBaseVersionQuery The current query, for fluid interface
     */
    public function filterByActive($active = null, $comparison = null)
    {
        if (is_array($active)) {
            $useMinMax = false;
            if (isset($active['min'])) {
                $this->addUsingAlias(CrawlerProductBaseVersionTableMap::ACTIVE, $active['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($active['max'])) {
                $this->addUsingAlias(CrawlerProductBaseVersionTableMap::ACTIVE, $active['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CrawlerProductBaseVersionTableMap::ACTIVE, $active, $comparison);
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
     * @return ChildCrawlerProductBaseVersionQuery The current query, for fluid interface
     */
    public function filterByActionRequired($actionRequired = null, $comparison = null)
    {
        if (is_array($actionRequired)) {
            $useMinMax = false;
            if (isset($actionRequired['min'])) {
                $this->addUsingAlias(CrawlerProductBaseVersionTableMap::ACTION_REQUIRED, $actionRequired['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($actionRequired['max'])) {
                $this->addUsingAlias(CrawlerProductBaseVersionTableMap::ACTION_REQUIRED, $actionRequired['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CrawlerProductBaseVersionTableMap::ACTION_REQUIRED, $actionRequired, $comparison);
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
     * @return ChildCrawlerProductBaseVersionQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(CrawlerProductBaseVersionTableMap::CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(CrawlerProductBaseVersionTableMap::CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CrawlerProductBaseVersionTableMap::CREATED_AT, $createdAt, $comparison);
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
     * @return ChildCrawlerProductBaseVersionQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(CrawlerProductBaseVersionTableMap::UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(CrawlerProductBaseVersionTableMap::UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CrawlerProductBaseVersionTableMap::UPDATED_AT, $updatedAt, $comparison);
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
     * @return ChildCrawlerProductBaseVersionQuery The current query, for fluid interface
     */
    public function filterByVersion($version = null, $comparison = null)
    {
        if (is_array($version)) {
            $useMinMax = false;
            if (isset($version['min'])) {
                $this->addUsingAlias(CrawlerProductBaseVersionTableMap::VERSION, $version['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($version['max'])) {
                $this->addUsingAlias(CrawlerProductBaseVersionTableMap::VERSION, $version['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CrawlerProductBaseVersionTableMap::VERSION, $version, $comparison);
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
     * @return ChildCrawlerProductBaseVersionQuery The current query, for fluid interface
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

        return $this->addUsingAlias(CrawlerProductBaseVersionTableMap::VERSION_CREATED_BY, $versionCreatedBy, $comparison);
    }

    /**
     * Filter the query on the product_id_version column
     *
     * Example usage:
     * <code>
     * $query->filterByProductIdVersion(1234); // WHERE product_id_version = 1234
     * $query->filterByProductIdVersion(array(12, 34)); // WHERE product_id_version IN (12, 34)
     * $query->filterByProductIdVersion(array('min' => 12)); // WHERE product_id_version > 12
     * </code>
     *
     * @param     mixed $productIdVersion The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCrawlerProductBaseVersionQuery The current query, for fluid interface
     */
    public function filterByProductIdVersion($productIdVersion = null, $comparison = null)
    {
        if (is_array($productIdVersion)) {
            $useMinMax = false;
            if (isset($productIdVersion['min'])) {
                $this->addUsingAlias(CrawlerProductBaseVersionTableMap::PRODUCT_ID_VERSION, $productIdVersion['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($productIdVersion['max'])) {
                $this->addUsingAlias(CrawlerProductBaseVersionTableMap::PRODUCT_ID_VERSION, $productIdVersion['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CrawlerProductBaseVersionTableMap::PRODUCT_ID_VERSION, $productIdVersion, $comparison);
    }

    /**
     * Filter the query on the crawler_product_listing_ids column
     *
     * @param     array $crawlerProductListingIds The values to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCrawlerProductBaseVersionQuery The current query, for fluid interface
     */
    public function filterByCrawlerProductListingIds($crawlerProductListingIds = null, $comparison = null)
    {
        $key = $this->getAliasedColName(CrawlerProductBaseVersionTableMap::CRAWLER_PRODUCT_LISTING_IDS);
        if (null === $comparison || $comparison == Criteria::CONTAINS_ALL) {
            foreach ($crawlerProductListingIds as $value) {
                $value = '%| ' . $value . ' |%';
                if ($this->containsKey($key)) {
                    $this->addAnd($key, $value, Criteria::LIKE);
                } else {
                    $this->add($key, $value, Criteria::LIKE);
                }
            }

            return $this;
        } elseif ($comparison == Criteria::CONTAINS_SOME) {
            foreach ($crawlerProductListingIds as $value) {
                $value = '%| ' . $value . ' |%';
                if ($this->containsKey($key)) {
                    $this->addOr($key, $value, Criteria::LIKE);
                } else {
                    $this->add($key, $value, Criteria::LIKE);
                }
            }

            return $this;
        } elseif ($comparison == Criteria::CONTAINS_NONE) {
            foreach ($crawlerProductListingIds as $value) {
                $value = '%| ' . $value . ' |%';
                if ($this->containsKey($key)) {
                    $this->addAnd($key, $value, Criteria::NOT_LIKE);
                } else {
                    $this->add($key, $value, Criteria::NOT_LIKE);
                }
            }
            $this->addOr($key, null, Criteria::ISNULL);

            return $this;
        }

        return $this->addUsingAlias(CrawlerProductBaseVersionTableMap::CRAWLER_PRODUCT_LISTING_IDS, $crawlerProductListingIds, $comparison);
    }

    /**
     * Filter the query on the crawler_product_listing_ids column
     * @param     mixed $crawlerProductListingIds The value to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::CONTAINS_ALL
     *
     * @return ChildCrawlerProductBaseVersionQuery The current query, for fluid interface
     */
    public function filterByCrawlerProductListingId($crawlerProductListingIds = null, $comparison = null)
    {
        if (null === $comparison || $comparison == Criteria::CONTAINS_ALL) {
            if (is_scalar($crawlerProductListingIds)) {
                $crawlerProductListingIds = '%| ' . $crawlerProductListingIds . ' |%';
                $comparison = Criteria::LIKE;
            }
        } elseif ($comparison == Criteria::CONTAINS_NONE) {
            $crawlerProductListingIds = '%| ' . $crawlerProductListingIds . ' |%';
            $comparison = Criteria::NOT_LIKE;
            $key = $this->getAliasedColName(CrawlerProductBaseVersionTableMap::CRAWLER_PRODUCT_LISTING_IDS);
            if ($this->containsKey($key)) {
                $this->addAnd($key, $crawlerProductListingIds, $comparison);
            } else {
                $this->addAnd($key, $crawlerProductListingIds, $comparison);
            }
            $this->addOr($key, null, Criteria::ISNULL);

            return $this;
        }

        return $this->addUsingAlias(CrawlerProductBaseVersionTableMap::CRAWLER_PRODUCT_LISTING_IDS, $crawlerProductListingIds, $comparison);
    }

    /**
     * Filter the query on the crawler_product_listing_versions column
     *
     * @param     array $crawlerProductListingVersions The values to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCrawlerProductBaseVersionQuery The current query, for fluid interface
     */
    public function filterByCrawlerProductListingVersions($crawlerProductListingVersions = null, $comparison = null)
    {
        $key = $this->getAliasedColName(CrawlerProductBaseVersionTableMap::CRAWLER_PRODUCT_LISTING_VERSIONS);
        if (null === $comparison || $comparison == Criteria::CONTAINS_ALL) {
            foreach ($crawlerProductListingVersions as $value) {
                $value = '%| ' . $value . ' |%';
                if ($this->containsKey($key)) {
                    $this->addAnd($key, $value, Criteria::LIKE);
                } else {
                    $this->add($key, $value, Criteria::LIKE);
                }
            }

            return $this;
        } elseif ($comparison == Criteria::CONTAINS_SOME) {
            foreach ($crawlerProductListingVersions as $value) {
                $value = '%| ' . $value . ' |%';
                if ($this->containsKey($key)) {
                    $this->addOr($key, $value, Criteria::LIKE);
                } else {
                    $this->add($key, $value, Criteria::LIKE);
                }
            }

            return $this;
        } elseif ($comparison == Criteria::CONTAINS_NONE) {
            foreach ($crawlerProductListingVersions as $value) {
                $value = '%| ' . $value . ' |%';
                if ($this->containsKey($key)) {
                    $this->addAnd($key, $value, Criteria::NOT_LIKE);
                } else {
                    $this->add($key, $value, Criteria::NOT_LIKE);
                }
            }
            $this->addOr($key, null, Criteria::ISNULL);

            return $this;
        }

        return $this->addUsingAlias(CrawlerProductBaseVersionTableMap::CRAWLER_PRODUCT_LISTING_VERSIONS, $crawlerProductListingVersions, $comparison);
    }

    /**
     * Filter the query on the crawler_product_listing_versions column
     * @param     mixed $crawlerProductListingVersions The value to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::CONTAINS_ALL
     *
     * @return ChildCrawlerProductBaseVersionQuery The current query, for fluid interface
     */
    public function filterByCrawlerProductListingVersion($crawlerProductListingVersions = null, $comparison = null)
    {
        if (null === $comparison || $comparison == Criteria::CONTAINS_ALL) {
            if (is_scalar($crawlerProductListingVersions)) {
                $crawlerProductListingVersions = '%| ' . $crawlerProductListingVersions . ' |%';
                $comparison = Criteria::LIKE;
            }
        } elseif ($comparison == Criteria::CONTAINS_NONE) {
            $crawlerProductListingVersions = '%| ' . $crawlerProductListingVersions . ' |%';
            $comparison = Criteria::NOT_LIKE;
            $key = $this->getAliasedColName(CrawlerProductBaseVersionTableMap::CRAWLER_PRODUCT_LISTING_VERSIONS);
            if ($this->containsKey($key)) {
                $this->addAnd($key, $crawlerProductListingVersions, $comparison);
            } else {
                $this->addAnd($key, $crawlerProductListingVersions, $comparison);
            }
            $this->addOr($key, null, Criteria::ISNULL);

            return $this;
        }

        return $this->addUsingAlias(CrawlerProductBaseVersionTableMap::CRAWLER_PRODUCT_LISTING_VERSIONS, $crawlerProductListingVersions, $comparison);
    }

    /**
     * Filter the query by a related \CrawlerProductBase object
     *
     * @param \CrawlerProductBase|ObjectCollection $crawlerProductBase The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCrawlerProductBaseVersionQuery The current query, for fluid interface
     */
    public function filterByCrawlerProductBase($crawlerProductBase, $comparison = null)
    {
        if ($crawlerProductBase instanceof \CrawlerProductBase) {
            return $this
                ->addUsingAlias(CrawlerProductBaseVersionTableMap::ID, $crawlerProductBase->getId(), $comparison);
        } elseif ($crawlerProductBase instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(CrawlerProductBaseVersionTableMap::ID, $crawlerProductBase->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByCrawlerProductBase() only accepts arguments of type \CrawlerProductBase or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the CrawlerProductBase relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildCrawlerProductBaseVersionQuery The current query, for fluid interface
     */
    public function joinCrawlerProductBase($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('CrawlerProductBase');

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
            $this->addJoinObject($join, 'CrawlerProductBase');
        }

        return $this;
    }

    /**
     * Use the CrawlerProductBase relation CrawlerProductBase object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \CrawlerProductBaseQuery A secondary query class using the current class as primary query
     */
    public function useCrawlerProductBaseQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinCrawlerProductBase($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'CrawlerProductBase', '\CrawlerProductBaseQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildCrawlerProductBaseVersion $crawlerProductBaseVersion Object to remove from the list of results
     *
     * @return ChildCrawlerProductBaseVersionQuery The current query, for fluid interface
     */
    public function prune($crawlerProductBaseVersion = null)
    {
        if ($crawlerProductBaseVersion) {
            $this->addCond('pruneCond0', $this->getAliasedColName(CrawlerProductBaseVersionTableMap::ID), $crawlerProductBaseVersion->getId(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(CrawlerProductBaseVersionTableMap::VERSION), $crawlerProductBaseVersion->getVersion(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the crawler_product_base_version table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CrawlerProductBaseVersionTableMap::DATABASE_NAME);
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
            CrawlerProductBaseVersionTableMap::clearInstancePool();
            CrawlerProductBaseVersionTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildCrawlerProductBaseVersion or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildCrawlerProductBaseVersion object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(CrawlerProductBaseVersionTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(CrawlerProductBaseVersionTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            

        CrawlerProductBaseVersionTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            CrawlerProductBaseVersionTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

} // CrawlerProductBaseVersionQuery
