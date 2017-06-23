<?php

namespace Base;

use \CrawlerProductListingVersion as ChildCrawlerProductListingVersion;
use \CrawlerProductListingVersionQuery as ChildCrawlerProductListingVersionQuery;
use \Exception;
use \PDO;
use Map\CrawlerProductListingVersionTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'crawler_product_listing_version' table.
 *
 * 
 *
 * @method     ChildCrawlerProductListingVersionQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildCrawlerProductListingVersionQuery orderByProductBaseId($order = Criteria::ASC) Order by the product_base_id column
 * @method     ChildCrawlerProductListingVersionQuery orderByHfPosition($order = Criteria::ASC) Order by the hf_position column
 * @method     ChildCrawlerProductListingVersionQuery orderByHfPrice($order = Criteria::ASC) Order by the hf_price column
 * @method     ChildCrawlerProductListingVersionQuery orderByFirstPosition($order = Criteria::ASC) Order by the first_position column
 * @method     ChildCrawlerProductListingVersionQuery orderByFirstPrice($order = Criteria::ASC) Order by the first_price column
 * @method     ChildCrawlerProductListingVersionQuery orderByPlatform($order = Criteria::ASC) Order by the platform column
 * @method     ChildCrawlerProductListingVersionQuery orderByLinkPlatformProductPage($order = Criteria::ASC) Order by the link_platform_product_page column
 * @method     ChildCrawlerProductListingVersionQuery orderByLinkHfProduct($order = Criteria::ASC) Order by the link_hf_product column
 * @method     ChildCrawlerProductListingVersionQuery orderByLinkFirstProduct($order = Criteria::ASC) Order by the link_first_product column
 * @method     ChildCrawlerProductListingVersionQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildCrawlerProductListingVersionQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 * @method     ChildCrawlerProductListingVersionQuery orderByVersion($order = Criteria::ASC) Order by the version column
 * @method     ChildCrawlerProductListingVersionQuery orderByVersionCreatedAt($order = Criteria::ASC) Order by the version_created_at column
 * @method     ChildCrawlerProductListingVersionQuery orderByVersionCreatedBy($order = Criteria::ASC) Order by the version_created_by column
 * @method     ChildCrawlerProductListingVersionQuery orderByProductBaseIdVersion($order = Criteria::ASC) Order by the product_base_id_version column
 *
 * @method     ChildCrawlerProductListingVersionQuery groupById() Group by the id column
 * @method     ChildCrawlerProductListingVersionQuery groupByProductBaseId() Group by the product_base_id column
 * @method     ChildCrawlerProductListingVersionQuery groupByHfPosition() Group by the hf_position column
 * @method     ChildCrawlerProductListingVersionQuery groupByHfPrice() Group by the hf_price column
 * @method     ChildCrawlerProductListingVersionQuery groupByFirstPosition() Group by the first_position column
 * @method     ChildCrawlerProductListingVersionQuery groupByFirstPrice() Group by the first_price column
 * @method     ChildCrawlerProductListingVersionQuery groupByPlatform() Group by the platform column
 * @method     ChildCrawlerProductListingVersionQuery groupByLinkPlatformProductPage() Group by the link_platform_product_page column
 * @method     ChildCrawlerProductListingVersionQuery groupByLinkHfProduct() Group by the link_hf_product column
 * @method     ChildCrawlerProductListingVersionQuery groupByLinkFirstProduct() Group by the link_first_product column
 * @method     ChildCrawlerProductListingVersionQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildCrawlerProductListingVersionQuery groupByUpdatedAt() Group by the updated_at column
 * @method     ChildCrawlerProductListingVersionQuery groupByVersion() Group by the version column
 * @method     ChildCrawlerProductListingVersionQuery groupByVersionCreatedAt() Group by the version_created_at column
 * @method     ChildCrawlerProductListingVersionQuery groupByVersionCreatedBy() Group by the version_created_by column
 * @method     ChildCrawlerProductListingVersionQuery groupByProductBaseIdVersion() Group by the product_base_id_version column
 *
 * @method     ChildCrawlerProductListingVersionQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildCrawlerProductListingVersionQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildCrawlerProductListingVersionQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildCrawlerProductListingVersionQuery leftJoinCrawlerProductListing($relationAlias = null) Adds a LEFT JOIN clause to the query using the CrawlerProductListing relation
 * @method     ChildCrawlerProductListingVersionQuery rightJoinCrawlerProductListing($relationAlias = null) Adds a RIGHT JOIN clause to the query using the CrawlerProductListing relation
 * @method     ChildCrawlerProductListingVersionQuery innerJoinCrawlerProductListing($relationAlias = null) Adds a INNER JOIN clause to the query using the CrawlerProductListing relation
 *
 * @method     ChildCrawlerProductListingVersion findOne(ConnectionInterface $con = null) Return the first ChildCrawlerProductListingVersion matching the query
 * @method     ChildCrawlerProductListingVersion findOneOrCreate(ConnectionInterface $con = null) Return the first ChildCrawlerProductListingVersion matching the query, or a new ChildCrawlerProductListingVersion object populated from the query conditions when no match is found
 *
 * @method     ChildCrawlerProductListingVersion findOneById(int $id) Return the first ChildCrawlerProductListingVersion filtered by the id column
 * @method     ChildCrawlerProductListingVersion findOneByProductBaseId(int $product_base_id) Return the first ChildCrawlerProductListingVersion filtered by the product_base_id column
 * @method     ChildCrawlerProductListingVersion findOneByHfPosition(int $hf_position) Return the first ChildCrawlerProductListingVersion filtered by the hf_position column
 * @method     ChildCrawlerProductListingVersion findOneByHfPrice(string $hf_price) Return the first ChildCrawlerProductListingVersion filtered by the hf_price column
 * @method     ChildCrawlerProductListingVersion findOneByFirstPosition(int $first_position) Return the first ChildCrawlerProductListingVersion filtered by the first_position column
 * @method     ChildCrawlerProductListingVersion findOneByFirstPrice(string $first_price) Return the first ChildCrawlerProductListingVersion filtered by the first_price column
 * @method     ChildCrawlerProductListingVersion findOneByPlatform(string $platform) Return the first ChildCrawlerProductListingVersion filtered by the platform column
 * @method     ChildCrawlerProductListingVersion findOneByLinkPlatformProductPage(string $link_platform_product_page) Return the first ChildCrawlerProductListingVersion filtered by the link_platform_product_page column
 * @method     ChildCrawlerProductListingVersion findOneByLinkHfProduct(string $link_hf_product) Return the first ChildCrawlerProductListingVersion filtered by the link_hf_product column
 * @method     ChildCrawlerProductListingVersion findOneByLinkFirstProduct(string $link_first_product) Return the first ChildCrawlerProductListingVersion filtered by the link_first_product column
 * @method     ChildCrawlerProductListingVersion findOneByCreatedAt(string $created_at) Return the first ChildCrawlerProductListingVersion filtered by the created_at column
 * @method     ChildCrawlerProductListingVersion findOneByUpdatedAt(string $updated_at) Return the first ChildCrawlerProductListingVersion filtered by the updated_at column
 * @method     ChildCrawlerProductListingVersion findOneByVersion(int $version) Return the first ChildCrawlerProductListingVersion filtered by the version column
 * @method     ChildCrawlerProductListingVersion findOneByVersionCreatedAt(string $version_created_at) Return the first ChildCrawlerProductListingVersion filtered by the version_created_at column
 * @method     ChildCrawlerProductListingVersion findOneByVersionCreatedBy(string $version_created_by) Return the first ChildCrawlerProductListingVersion filtered by the version_created_by column
 * @method     ChildCrawlerProductListingVersion findOneByProductBaseIdVersion(int $product_base_id_version) Return the first ChildCrawlerProductListingVersion filtered by the product_base_id_version column
 *
 * @method     array findById(int $id) Return ChildCrawlerProductListingVersion objects filtered by the id column
 * @method     array findByProductBaseId(int $product_base_id) Return ChildCrawlerProductListingVersion objects filtered by the product_base_id column
 * @method     array findByHfPosition(int $hf_position) Return ChildCrawlerProductListingVersion objects filtered by the hf_position column
 * @method     array findByHfPrice(string $hf_price) Return ChildCrawlerProductListingVersion objects filtered by the hf_price column
 * @method     array findByFirstPosition(int $first_position) Return ChildCrawlerProductListingVersion objects filtered by the first_position column
 * @method     array findByFirstPrice(string $first_price) Return ChildCrawlerProductListingVersion objects filtered by the first_price column
 * @method     array findByPlatform(string $platform) Return ChildCrawlerProductListingVersion objects filtered by the platform column
 * @method     array findByLinkPlatformProductPage(string $link_platform_product_page) Return ChildCrawlerProductListingVersion objects filtered by the link_platform_product_page column
 * @method     array findByLinkHfProduct(string $link_hf_product) Return ChildCrawlerProductListingVersion objects filtered by the link_hf_product column
 * @method     array findByLinkFirstProduct(string $link_first_product) Return ChildCrawlerProductListingVersion objects filtered by the link_first_product column
 * @method     array findByCreatedAt(string $created_at) Return ChildCrawlerProductListingVersion objects filtered by the created_at column
 * @method     array findByUpdatedAt(string $updated_at) Return ChildCrawlerProductListingVersion objects filtered by the updated_at column
 * @method     array findByVersion(int $version) Return ChildCrawlerProductListingVersion objects filtered by the version column
 * @method     array findByVersionCreatedAt(string $version_created_at) Return ChildCrawlerProductListingVersion objects filtered by the version_created_at column
 * @method     array findByVersionCreatedBy(string $version_created_by) Return ChildCrawlerProductListingVersion objects filtered by the version_created_by column
 * @method     array findByProductBaseIdVersion(int $product_base_id_version) Return ChildCrawlerProductListingVersion objects filtered by the product_base_id_version column
 *
 */
abstract class CrawlerProductListingVersionQuery extends ModelCriteria
{
    
    /**
     * Initializes internal state of \Base\CrawlerProductListingVersionQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'thelia', $modelName = '\\CrawlerProductListingVersion', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildCrawlerProductListingVersionQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildCrawlerProductListingVersionQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \CrawlerProductListingVersionQuery) {
            return $criteria;
        }
        $query = new \CrawlerProductListingVersionQuery();
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
     * @return ChildCrawlerProductListingVersion|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = CrawlerProductListingVersionTableMap::getInstanceFromPool(serialize(array((string) $key[0], (string) $key[1]))))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(CrawlerProductListingVersionTableMap::DATABASE_NAME);
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
     * @return   ChildCrawlerProductListingVersion A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ID, PRODUCT_BASE_ID, HF_POSITION, HF_PRICE, FIRST_POSITION, FIRST_PRICE, PLATFORM, LINK_PLATFORM_PRODUCT_PAGE, LINK_HF_PRODUCT, LINK_FIRST_PRODUCT, CREATED_AT, UPDATED_AT, VERSION, VERSION_CREATED_AT, VERSION_CREATED_BY, PRODUCT_BASE_ID_VERSION FROM crawler_product_listing_version WHERE ID = :p0 AND VERSION = :p1';
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
            $obj = new ChildCrawlerProductListingVersion();
            $obj->hydrate($row);
            CrawlerProductListingVersionTableMap::addInstanceToPool($obj, serialize(array((string) $key[0], (string) $key[1])));
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
     * @return ChildCrawlerProductListingVersion|array|mixed the result, formatted by the current formatter
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
     * @return ChildCrawlerProductListingVersionQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(CrawlerProductListingVersionTableMap::ID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(CrawlerProductListingVersionTableMap::VERSION, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildCrawlerProductListingVersionQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(CrawlerProductListingVersionTableMap::ID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(CrawlerProductListingVersionTableMap::VERSION, $key[1], Criteria::EQUAL);
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
     * @see       filterByCrawlerProductListing()
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCrawlerProductListingVersionQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(CrawlerProductListingVersionTableMap::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(CrawlerProductListingVersionTableMap::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CrawlerProductListingVersionTableMap::ID, $id, $comparison);
    }

    /**
     * Filter the query on the product_base_id column
     *
     * Example usage:
     * <code>
     * $query->filterByProductBaseId(1234); // WHERE product_base_id = 1234
     * $query->filterByProductBaseId(array(12, 34)); // WHERE product_base_id IN (12, 34)
     * $query->filterByProductBaseId(array('min' => 12)); // WHERE product_base_id > 12
     * </code>
     *
     * @param     mixed $productBaseId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCrawlerProductListingVersionQuery The current query, for fluid interface
     */
    public function filterByProductBaseId($productBaseId = null, $comparison = null)
    {
        if (is_array($productBaseId)) {
            $useMinMax = false;
            if (isset($productBaseId['min'])) {
                $this->addUsingAlias(CrawlerProductListingVersionTableMap::PRODUCT_BASE_ID, $productBaseId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($productBaseId['max'])) {
                $this->addUsingAlias(CrawlerProductListingVersionTableMap::PRODUCT_BASE_ID, $productBaseId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CrawlerProductListingVersionTableMap::PRODUCT_BASE_ID, $productBaseId, $comparison);
    }

    /**
     * Filter the query on the hf_position column
     *
     * Example usage:
     * <code>
     * $query->filterByHfPosition(1234); // WHERE hf_position = 1234
     * $query->filterByHfPosition(array(12, 34)); // WHERE hf_position IN (12, 34)
     * $query->filterByHfPosition(array('min' => 12)); // WHERE hf_position > 12
     * </code>
     *
     * @param     mixed $hfPosition The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCrawlerProductListingVersionQuery The current query, for fluid interface
     */
    public function filterByHfPosition($hfPosition = null, $comparison = null)
    {
        if (is_array($hfPosition)) {
            $useMinMax = false;
            if (isset($hfPosition['min'])) {
                $this->addUsingAlias(CrawlerProductListingVersionTableMap::HF_POSITION, $hfPosition['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($hfPosition['max'])) {
                $this->addUsingAlias(CrawlerProductListingVersionTableMap::HF_POSITION, $hfPosition['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CrawlerProductListingVersionTableMap::HF_POSITION, $hfPosition, $comparison);
    }

    /**
     * Filter the query on the hf_price column
     *
     * Example usage:
     * <code>
     * $query->filterByHfPrice(1234); // WHERE hf_price = 1234
     * $query->filterByHfPrice(array(12, 34)); // WHERE hf_price IN (12, 34)
     * $query->filterByHfPrice(array('min' => 12)); // WHERE hf_price > 12
     * </code>
     *
     * @param     mixed $hfPrice The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCrawlerProductListingVersionQuery The current query, for fluid interface
     */
    public function filterByHfPrice($hfPrice = null, $comparison = null)
    {
        if (is_array($hfPrice)) {
            $useMinMax = false;
            if (isset($hfPrice['min'])) {
                $this->addUsingAlias(CrawlerProductListingVersionTableMap::HF_PRICE, $hfPrice['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($hfPrice['max'])) {
                $this->addUsingAlias(CrawlerProductListingVersionTableMap::HF_PRICE, $hfPrice['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CrawlerProductListingVersionTableMap::HF_PRICE, $hfPrice, $comparison);
    }

    /**
     * Filter the query on the first_position column
     *
     * Example usage:
     * <code>
     * $query->filterByFirstPosition(1234); // WHERE first_position = 1234
     * $query->filterByFirstPosition(array(12, 34)); // WHERE first_position IN (12, 34)
     * $query->filterByFirstPosition(array('min' => 12)); // WHERE first_position > 12
     * </code>
     *
     * @param     mixed $firstPosition The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCrawlerProductListingVersionQuery The current query, for fluid interface
     */
    public function filterByFirstPosition($firstPosition = null, $comparison = null)
    {
        if (is_array($firstPosition)) {
            $useMinMax = false;
            if (isset($firstPosition['min'])) {
                $this->addUsingAlias(CrawlerProductListingVersionTableMap::FIRST_POSITION, $firstPosition['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($firstPosition['max'])) {
                $this->addUsingAlias(CrawlerProductListingVersionTableMap::FIRST_POSITION, $firstPosition['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CrawlerProductListingVersionTableMap::FIRST_POSITION, $firstPosition, $comparison);
    }

    /**
     * Filter the query on the first_price column
     *
     * Example usage:
     * <code>
     * $query->filterByFirstPrice(1234); // WHERE first_price = 1234
     * $query->filterByFirstPrice(array(12, 34)); // WHERE first_price IN (12, 34)
     * $query->filterByFirstPrice(array('min' => 12)); // WHERE first_price > 12
     * </code>
     *
     * @param     mixed $firstPrice The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCrawlerProductListingVersionQuery The current query, for fluid interface
     */
    public function filterByFirstPrice($firstPrice = null, $comparison = null)
    {
        if (is_array($firstPrice)) {
            $useMinMax = false;
            if (isset($firstPrice['min'])) {
                $this->addUsingAlias(CrawlerProductListingVersionTableMap::FIRST_PRICE, $firstPrice['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($firstPrice['max'])) {
                $this->addUsingAlias(CrawlerProductListingVersionTableMap::FIRST_PRICE, $firstPrice['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CrawlerProductListingVersionTableMap::FIRST_PRICE, $firstPrice, $comparison);
    }

    /**
     * Filter the query on the platform column
     *
     * Example usage:
     * <code>
     * $query->filterByPlatform('fooValue');   // WHERE platform = 'fooValue'
     * $query->filterByPlatform('%fooValue%'); // WHERE platform LIKE '%fooValue%'
     * </code>
     *
     * @param     string $platform The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCrawlerProductListingVersionQuery The current query, for fluid interface
     */
    public function filterByPlatform($platform = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($platform)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $platform)) {
                $platform = str_replace('*', '%', $platform);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(CrawlerProductListingVersionTableMap::PLATFORM, $platform, $comparison);
    }

    /**
     * Filter the query on the link_platform_product_page column
     *
     * Example usage:
     * <code>
     * $query->filterByLinkPlatformProductPage('fooValue');   // WHERE link_platform_product_page = 'fooValue'
     * $query->filterByLinkPlatformProductPage('%fooValue%'); // WHERE link_platform_product_page LIKE '%fooValue%'
     * </code>
     *
     * @param     string $linkPlatformProductPage The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCrawlerProductListingVersionQuery The current query, for fluid interface
     */
    public function filterByLinkPlatformProductPage($linkPlatformProductPage = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($linkPlatformProductPage)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $linkPlatformProductPage)) {
                $linkPlatformProductPage = str_replace('*', '%', $linkPlatformProductPage);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(CrawlerProductListingVersionTableMap::LINK_PLATFORM_PRODUCT_PAGE, $linkPlatformProductPage, $comparison);
    }

    /**
     * Filter the query on the link_hf_product column
     *
     * Example usage:
     * <code>
     * $query->filterByLinkHfProduct('fooValue');   // WHERE link_hf_product = 'fooValue'
     * $query->filterByLinkHfProduct('%fooValue%'); // WHERE link_hf_product LIKE '%fooValue%'
     * </code>
     *
     * @param     string $linkHfProduct The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCrawlerProductListingVersionQuery The current query, for fluid interface
     */
    public function filterByLinkHfProduct($linkHfProduct = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($linkHfProduct)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $linkHfProduct)) {
                $linkHfProduct = str_replace('*', '%', $linkHfProduct);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(CrawlerProductListingVersionTableMap::LINK_HF_PRODUCT, $linkHfProduct, $comparison);
    }

    /**
     * Filter the query on the link_first_product column
     *
     * Example usage:
     * <code>
     * $query->filterByLinkFirstProduct('fooValue');   // WHERE link_first_product = 'fooValue'
     * $query->filterByLinkFirstProduct('%fooValue%'); // WHERE link_first_product LIKE '%fooValue%'
     * </code>
     *
     * @param     string $linkFirstProduct The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCrawlerProductListingVersionQuery The current query, for fluid interface
     */
    public function filterByLinkFirstProduct($linkFirstProduct = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($linkFirstProduct)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $linkFirstProduct)) {
                $linkFirstProduct = str_replace('*', '%', $linkFirstProduct);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(CrawlerProductListingVersionTableMap::LINK_FIRST_PRODUCT, $linkFirstProduct, $comparison);
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
     * @return ChildCrawlerProductListingVersionQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(CrawlerProductListingVersionTableMap::CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(CrawlerProductListingVersionTableMap::CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CrawlerProductListingVersionTableMap::CREATED_AT, $createdAt, $comparison);
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
     * @return ChildCrawlerProductListingVersionQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(CrawlerProductListingVersionTableMap::UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(CrawlerProductListingVersionTableMap::UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CrawlerProductListingVersionTableMap::UPDATED_AT, $updatedAt, $comparison);
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
     * @return ChildCrawlerProductListingVersionQuery The current query, for fluid interface
     */
    public function filterByVersion($version = null, $comparison = null)
    {
        if (is_array($version)) {
            $useMinMax = false;
            if (isset($version['min'])) {
                $this->addUsingAlias(CrawlerProductListingVersionTableMap::VERSION, $version['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($version['max'])) {
                $this->addUsingAlias(CrawlerProductListingVersionTableMap::VERSION, $version['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CrawlerProductListingVersionTableMap::VERSION, $version, $comparison);
    }

    /**
     * Filter the query on the version_created_at column
     *
     * Example usage:
     * <code>
     * $query->filterByVersionCreatedAt('2011-03-14'); // WHERE version_created_at = '2011-03-14'
     * $query->filterByVersionCreatedAt('now'); // WHERE version_created_at = '2011-03-14'
     * $query->filterByVersionCreatedAt(array('max' => 'yesterday')); // WHERE version_created_at > '2011-03-13'
     * </code>
     *
     * @param     mixed $versionCreatedAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCrawlerProductListingVersionQuery The current query, for fluid interface
     */
    public function filterByVersionCreatedAt($versionCreatedAt = null, $comparison = null)
    {
        if (is_array($versionCreatedAt)) {
            $useMinMax = false;
            if (isset($versionCreatedAt['min'])) {
                $this->addUsingAlias(CrawlerProductListingVersionTableMap::VERSION_CREATED_AT, $versionCreatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($versionCreatedAt['max'])) {
                $this->addUsingAlias(CrawlerProductListingVersionTableMap::VERSION_CREATED_AT, $versionCreatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CrawlerProductListingVersionTableMap::VERSION_CREATED_AT, $versionCreatedAt, $comparison);
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
     * @return ChildCrawlerProductListingVersionQuery The current query, for fluid interface
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

        return $this->addUsingAlias(CrawlerProductListingVersionTableMap::VERSION_CREATED_BY, $versionCreatedBy, $comparison);
    }

    /**
     * Filter the query on the product_base_id_version column
     *
     * Example usage:
     * <code>
     * $query->filterByProductBaseIdVersion(1234); // WHERE product_base_id_version = 1234
     * $query->filterByProductBaseIdVersion(array(12, 34)); // WHERE product_base_id_version IN (12, 34)
     * $query->filterByProductBaseIdVersion(array('min' => 12)); // WHERE product_base_id_version > 12
     * </code>
     *
     * @param     mixed $productBaseIdVersion The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCrawlerProductListingVersionQuery The current query, for fluid interface
     */
    public function filterByProductBaseIdVersion($productBaseIdVersion = null, $comparison = null)
    {
        if (is_array($productBaseIdVersion)) {
            $useMinMax = false;
            if (isset($productBaseIdVersion['min'])) {
                $this->addUsingAlias(CrawlerProductListingVersionTableMap::PRODUCT_BASE_ID_VERSION, $productBaseIdVersion['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($productBaseIdVersion['max'])) {
                $this->addUsingAlias(CrawlerProductListingVersionTableMap::PRODUCT_BASE_ID_VERSION, $productBaseIdVersion['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CrawlerProductListingVersionTableMap::PRODUCT_BASE_ID_VERSION, $productBaseIdVersion, $comparison);
    }

    /**
     * Filter the query by a related \CrawlerProductListing object
     *
     * @param \CrawlerProductListing|ObjectCollection $crawlerProductListing The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCrawlerProductListingVersionQuery The current query, for fluid interface
     */
    public function filterByCrawlerProductListing($crawlerProductListing, $comparison = null)
    {
        if ($crawlerProductListing instanceof \CrawlerProductListing) {
            return $this
                ->addUsingAlias(CrawlerProductListingVersionTableMap::ID, $crawlerProductListing->getId(), $comparison);
        } elseif ($crawlerProductListing instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(CrawlerProductListingVersionTableMap::ID, $crawlerProductListing->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return ChildCrawlerProductListingVersionQuery The current query, for fluid interface
     */
    public function joinCrawlerProductListing($relationAlias = null, $joinType = Criteria::INNER_JOIN)
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
    public function useCrawlerProductListingQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinCrawlerProductListing($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'CrawlerProductListing', '\CrawlerProductListingQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildCrawlerProductListingVersion $crawlerProductListingVersion Object to remove from the list of results
     *
     * @return ChildCrawlerProductListingVersionQuery The current query, for fluid interface
     */
    public function prune($crawlerProductListingVersion = null)
    {
        if ($crawlerProductListingVersion) {
            $this->addCond('pruneCond0', $this->getAliasedColName(CrawlerProductListingVersionTableMap::ID), $crawlerProductListingVersion->getId(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(CrawlerProductListingVersionTableMap::VERSION), $crawlerProductListingVersion->getVersion(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the crawler_product_listing_version table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CrawlerProductListingVersionTableMap::DATABASE_NAME);
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
            CrawlerProductListingVersionTableMap::clearInstancePool();
            CrawlerProductListingVersionTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildCrawlerProductListingVersion or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildCrawlerProductListingVersion object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(CrawlerProductListingVersionTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(CrawlerProductListingVersionTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            

        CrawlerProductListingVersionTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            CrawlerProductListingVersionTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

} // CrawlerProductListingVersionQuery
