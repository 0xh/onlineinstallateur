<?php

namespace HookAdminCrawlerDashboard\Model\Base;

use \Exception;
use \PDO;
use HookAdminCrawlerDashboard\Model\CrawlerProductListing as ChildCrawlerProductListing;
use HookAdminCrawlerDashboard\Model\CrawlerProductListingQuery as ChildCrawlerProductListingQuery;
use HookAdminCrawlerDashboard\Model\Map\CrawlerProductListingTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'crawler_product_listing' table.
 *
 * 
 *
 * @method     ChildCrawlerProductListingQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildCrawlerProductListingQuery orderByProductBaseId($order = Criteria::ASC) Order by the product_base_id column
 * @method     ChildCrawlerProductListingQuery orderByHfPosition($order = Criteria::ASC) Order by the hf_position column
 * @method     ChildCrawlerProductListingQuery orderByHfPrice($order = Criteria::ASC) Order by the hf_price column
 * @method     ChildCrawlerProductListingQuery orderByFirstPosition($order = Criteria::ASC) Order by the first_position column
 * @method     ChildCrawlerProductListingQuery orderByFirstPrice($order = Criteria::ASC) Order by the first_price column
 * @method     ChildCrawlerProductListingQuery orderByPlatform($order = Criteria::ASC) Order by the platform column
 * @method     ChildCrawlerProductListingQuery orderByLinkPlatformProductPage($order = Criteria::ASC) Order by the link_platform_product_page column
 * @method     ChildCrawlerProductListingQuery orderByLinkHfProduct($order = Criteria::ASC) Order by the link_hf_product column
 * @method     ChildCrawlerProductListingQuery orderByLinkFirstProduct($order = Criteria::ASC) Order by the link_first_product column
 * @method     ChildCrawlerProductListingQuery orderByPlatformProductId($order = Criteria::ASC) Order by the platform_product_id column
 * @method     ChildCrawlerProductListingQuery orderByHfProductStock($order = Criteria::ASC) Order by the hf_product_stock column
 * @method     ChildCrawlerProductListingQuery orderByHfProductStockOrder($order = Criteria::ASC) Order by the hf_product_stock_order column
 * @method     ChildCrawlerProductListingQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildCrawlerProductListingQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 * @method     ChildCrawlerProductListingQuery orderByVersion($order = Criteria::ASC) Order by the version column
 * @method     ChildCrawlerProductListingQuery orderByVersionCreatedAt($order = Criteria::ASC) Order by the version_created_at column
 * @method     ChildCrawlerProductListingQuery orderByVersionCreatedBy($order = Criteria::ASC) Order by the version_created_by column
 *
 * @method     ChildCrawlerProductListingQuery groupById() Group by the id column
 * @method     ChildCrawlerProductListingQuery groupByProductBaseId() Group by the product_base_id column
 * @method     ChildCrawlerProductListingQuery groupByHfPosition() Group by the hf_position column
 * @method     ChildCrawlerProductListingQuery groupByHfPrice() Group by the hf_price column
 * @method     ChildCrawlerProductListingQuery groupByFirstPosition() Group by the first_position column
 * @method     ChildCrawlerProductListingQuery groupByFirstPrice() Group by the first_price column
 * @method     ChildCrawlerProductListingQuery groupByPlatform() Group by the platform column
 * @method     ChildCrawlerProductListingQuery groupByLinkPlatformProductPage() Group by the link_platform_product_page column
 * @method     ChildCrawlerProductListingQuery groupByLinkHfProduct() Group by the link_hf_product column
 * @method     ChildCrawlerProductListingQuery groupByLinkFirstProduct() Group by the link_first_product column
 * @method     ChildCrawlerProductListingQuery groupByPlatformProductId() Group by the platform_product_id column
 * @method     ChildCrawlerProductListingQuery groupByHfProductStock() Group by the hf_product_stock column
 * @method     ChildCrawlerProductListingQuery groupByHfProductStockOrder() Group by the hf_product_stock_order column
 * @method     ChildCrawlerProductListingQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildCrawlerProductListingQuery groupByUpdatedAt() Group by the updated_at column
 * @method     ChildCrawlerProductListingQuery groupByVersion() Group by the version column
 * @method     ChildCrawlerProductListingQuery groupByVersionCreatedAt() Group by the version_created_at column
 * @method     ChildCrawlerProductListingQuery groupByVersionCreatedBy() Group by the version_created_by column
 *
 * @method     ChildCrawlerProductListingQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildCrawlerProductListingQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildCrawlerProductListingQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildCrawlerProductListingQuery leftJoinCrawlerProductBase($relationAlias = null) Adds a LEFT JOIN clause to the query using the CrawlerProductBase relation
 * @method     ChildCrawlerProductListingQuery rightJoinCrawlerProductBase($relationAlias = null) Adds a RIGHT JOIN clause to the query using the CrawlerProductBase relation
 * @method     ChildCrawlerProductListingQuery innerJoinCrawlerProductBase($relationAlias = null) Adds a INNER JOIN clause to the query using the CrawlerProductBase relation
 *
 * @method     ChildCrawlerProductListingQuery leftJoinCrawlerProductListingVersion($relationAlias = null) Adds a LEFT JOIN clause to the query using the CrawlerProductListingVersion relation
 * @method     ChildCrawlerProductListingQuery rightJoinCrawlerProductListingVersion($relationAlias = null) Adds a RIGHT JOIN clause to the query using the CrawlerProductListingVersion relation
 * @method     ChildCrawlerProductListingQuery innerJoinCrawlerProductListingVersion($relationAlias = null) Adds a INNER JOIN clause to the query using the CrawlerProductListingVersion relation
 *
 * @method     ChildCrawlerProductListing findOne(ConnectionInterface $con = null) Return the first ChildCrawlerProductListing matching the query
 * @method     ChildCrawlerProductListing findOneOrCreate(ConnectionInterface $con = null) Return the first ChildCrawlerProductListing matching the query, or a new ChildCrawlerProductListing object populated from the query conditions when no match is found
 *
 * @method     ChildCrawlerProductListing findOneById(int $id) Return the first ChildCrawlerProductListing filtered by the id column
 * @method     ChildCrawlerProductListing findOneByProductBaseId(int $product_base_id) Return the first ChildCrawlerProductListing filtered by the product_base_id column
 * @method     ChildCrawlerProductListing findOneByHfPosition(int $hf_position) Return the first ChildCrawlerProductListing filtered by the hf_position column
 * @method     ChildCrawlerProductListing findOneByHfPrice(string $hf_price) Return the first ChildCrawlerProductListing filtered by the hf_price column
 * @method     ChildCrawlerProductListing findOneByFirstPosition(int $first_position) Return the first ChildCrawlerProductListing filtered by the first_position column
 * @method     ChildCrawlerProductListing findOneByFirstPrice(string $first_price) Return the first ChildCrawlerProductListing filtered by the first_price column
 * @method     ChildCrawlerProductListing findOneByPlatform(string $platform) Return the first ChildCrawlerProductListing filtered by the platform column
 * @method     ChildCrawlerProductListing findOneByLinkPlatformProductPage(string $link_platform_product_page) Return the first ChildCrawlerProductListing filtered by the link_platform_product_page column
 * @method     ChildCrawlerProductListing findOneByLinkHfProduct(string $link_hf_product) Return the first ChildCrawlerProductListing filtered by the link_hf_product column
 * @method     ChildCrawlerProductListing findOneByLinkFirstProduct(string $link_first_product) Return the first ChildCrawlerProductListing filtered by the link_first_product column
 * @method     ChildCrawlerProductListing findOneByPlatformProductId(string $platform_product_id) Return the first ChildCrawlerProductListing filtered by the platform_product_id column
 * @method     ChildCrawlerProductListing findOneByHfProductStock(int $hf_product_stock) Return the first ChildCrawlerProductListing filtered by the hf_product_stock column
 * @method     ChildCrawlerProductListing findOneByHfProductStockOrder(int $hf_product_stock_order) Return the first ChildCrawlerProductListing filtered by the hf_product_stock_order column
 * @method     ChildCrawlerProductListing findOneByCreatedAt(string $created_at) Return the first ChildCrawlerProductListing filtered by the created_at column
 * @method     ChildCrawlerProductListing findOneByUpdatedAt(string $updated_at) Return the first ChildCrawlerProductListing filtered by the updated_at column
 * @method     ChildCrawlerProductListing findOneByVersion(int $version) Return the first ChildCrawlerProductListing filtered by the version column
 * @method     ChildCrawlerProductListing findOneByVersionCreatedAt(string $version_created_at) Return the first ChildCrawlerProductListing filtered by the version_created_at column
 * @method     ChildCrawlerProductListing findOneByVersionCreatedBy(string $version_created_by) Return the first ChildCrawlerProductListing filtered by the version_created_by column
 *
 * @method     array findById(int $id) Return ChildCrawlerProductListing objects filtered by the id column
 * @method     array findByProductBaseId(int $product_base_id) Return ChildCrawlerProductListing objects filtered by the product_base_id column
 * @method     array findByHfPosition(int $hf_position) Return ChildCrawlerProductListing objects filtered by the hf_position column
 * @method     array findByHfPrice(string $hf_price) Return ChildCrawlerProductListing objects filtered by the hf_price column
 * @method     array findByFirstPosition(int $first_position) Return ChildCrawlerProductListing objects filtered by the first_position column
 * @method     array findByFirstPrice(string $first_price) Return ChildCrawlerProductListing objects filtered by the first_price column
 * @method     array findByPlatform(string $platform) Return ChildCrawlerProductListing objects filtered by the platform column
 * @method     array findByLinkPlatformProductPage(string $link_platform_product_page) Return ChildCrawlerProductListing objects filtered by the link_platform_product_page column
 * @method     array findByLinkHfProduct(string $link_hf_product) Return ChildCrawlerProductListing objects filtered by the link_hf_product column
 * @method     array findByLinkFirstProduct(string $link_first_product) Return ChildCrawlerProductListing objects filtered by the link_first_product column
 * @method     array findByPlatformProductId(string $platform_product_id) Return ChildCrawlerProductListing objects filtered by the platform_product_id column
 * @method     array findByHfProductStock(int $hf_product_stock) Return ChildCrawlerProductListing objects filtered by the hf_product_stock column
 * @method     array findByHfProductStockOrder(int $hf_product_stock_order) Return ChildCrawlerProductListing objects filtered by the hf_product_stock_order column
 * @method     array findByCreatedAt(string $created_at) Return ChildCrawlerProductListing objects filtered by the created_at column
 * @method     array findByUpdatedAt(string $updated_at) Return ChildCrawlerProductListing objects filtered by the updated_at column
 * @method     array findByVersion(int $version) Return ChildCrawlerProductListing objects filtered by the version column
 * @method     array findByVersionCreatedAt(string $version_created_at) Return ChildCrawlerProductListing objects filtered by the version_created_at column
 * @method     array findByVersionCreatedBy(string $version_created_by) Return ChildCrawlerProductListing objects filtered by the version_created_by column
 *
 */
abstract class CrawlerProductListingQuery extends ModelCriteria
{
    
    // versionable behavior
    
    /**
     * Whether the versioning is enabled
     */
    static $isVersioningEnabled = true;

    /**
     * Initializes internal state of \HookAdminCrawlerDashboard\Model\Base\CrawlerProductListingQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'thelia', $modelName = '\\HookAdminCrawlerDashboard\\Model\\CrawlerProductListing', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildCrawlerProductListingQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildCrawlerProductListingQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \HookAdminCrawlerDashboard\Model\CrawlerProductListingQuery) {
            return $criteria;
        }
        $query = new \HookAdminCrawlerDashboard\Model\CrawlerProductListingQuery();
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
     * @return ChildCrawlerProductListing|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = CrawlerProductListingTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(CrawlerProductListingTableMap::DATABASE_NAME);
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
     * @return   ChildCrawlerProductListing A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ID, PRODUCT_BASE_ID, HF_POSITION, HF_PRICE, FIRST_POSITION, FIRST_PRICE, PLATFORM, LINK_PLATFORM_PRODUCT_PAGE, LINK_HF_PRODUCT, LINK_FIRST_PRODUCT, PLATFORM_PRODUCT_ID, HF_PRODUCT_STOCK, HF_PRODUCT_STOCK_ORDER, CREATED_AT, UPDATED_AT, VERSION, VERSION_CREATED_AT, VERSION_CREATED_BY FROM crawler_product_listing WHERE ID = :p0';
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
            $obj = new ChildCrawlerProductListing();
            $obj->hydrate($row);
            CrawlerProductListingTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildCrawlerProductListing|array|mixed the result, formatted by the current formatter
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
     * @return ChildCrawlerProductListingQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(CrawlerProductListingTableMap::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildCrawlerProductListingQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(CrawlerProductListingTableMap::ID, $keys, Criteria::IN);
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
     * @return ChildCrawlerProductListingQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(CrawlerProductListingTableMap::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(CrawlerProductListingTableMap::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CrawlerProductListingTableMap::ID, $id, $comparison);
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
     * @see       filterByCrawlerProductBase()
     *
     * @param     mixed $productBaseId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCrawlerProductListingQuery The current query, for fluid interface
     */
    public function filterByProductBaseId($productBaseId = null, $comparison = null)
    {
        if (is_array($productBaseId)) {
            $useMinMax = false;
            if (isset($productBaseId['min'])) {
                $this->addUsingAlias(CrawlerProductListingTableMap::PRODUCT_BASE_ID, $productBaseId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($productBaseId['max'])) {
                $this->addUsingAlias(CrawlerProductListingTableMap::PRODUCT_BASE_ID, $productBaseId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CrawlerProductListingTableMap::PRODUCT_BASE_ID, $productBaseId, $comparison);
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
     * @return ChildCrawlerProductListingQuery The current query, for fluid interface
     */
    public function filterByHfPosition($hfPosition = null, $comparison = null)
    {
        if (is_array($hfPosition)) {
            $useMinMax = false;
            if (isset($hfPosition['min'])) {
                $this->addUsingAlias(CrawlerProductListingTableMap::HF_POSITION, $hfPosition['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($hfPosition['max'])) {
                $this->addUsingAlias(CrawlerProductListingTableMap::HF_POSITION, $hfPosition['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CrawlerProductListingTableMap::HF_POSITION, $hfPosition, $comparison);
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
     * @return ChildCrawlerProductListingQuery The current query, for fluid interface
     */
    public function filterByHfPrice($hfPrice = null, $comparison = null)
    {
        if (is_array($hfPrice)) {
            $useMinMax = false;
            if (isset($hfPrice['min'])) {
                $this->addUsingAlias(CrawlerProductListingTableMap::HF_PRICE, $hfPrice['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($hfPrice['max'])) {
                $this->addUsingAlias(CrawlerProductListingTableMap::HF_PRICE, $hfPrice['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CrawlerProductListingTableMap::HF_PRICE, $hfPrice, $comparison);
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
     * @return ChildCrawlerProductListingQuery The current query, for fluid interface
     */
    public function filterByFirstPosition($firstPosition = null, $comparison = null)
    {
        if (is_array($firstPosition)) {
            $useMinMax = false;
            if (isset($firstPosition['min'])) {
                $this->addUsingAlias(CrawlerProductListingTableMap::FIRST_POSITION, $firstPosition['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($firstPosition['max'])) {
                $this->addUsingAlias(CrawlerProductListingTableMap::FIRST_POSITION, $firstPosition['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CrawlerProductListingTableMap::FIRST_POSITION, $firstPosition, $comparison);
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
     * @return ChildCrawlerProductListingQuery The current query, for fluid interface
     */
    public function filterByFirstPrice($firstPrice = null, $comparison = null)
    {
        if (is_array($firstPrice)) {
            $useMinMax = false;
            if (isset($firstPrice['min'])) {
                $this->addUsingAlias(CrawlerProductListingTableMap::FIRST_PRICE, $firstPrice['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($firstPrice['max'])) {
                $this->addUsingAlias(CrawlerProductListingTableMap::FIRST_PRICE, $firstPrice['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CrawlerProductListingTableMap::FIRST_PRICE, $firstPrice, $comparison);
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
     * @return ChildCrawlerProductListingQuery The current query, for fluid interface
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

        return $this->addUsingAlias(CrawlerProductListingTableMap::PLATFORM, $platform, $comparison);
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
     * @return ChildCrawlerProductListingQuery The current query, for fluid interface
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

        return $this->addUsingAlias(CrawlerProductListingTableMap::LINK_PLATFORM_PRODUCT_PAGE, $linkPlatformProductPage, $comparison);
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
     * @return ChildCrawlerProductListingQuery The current query, for fluid interface
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

        return $this->addUsingAlias(CrawlerProductListingTableMap::LINK_HF_PRODUCT, $linkHfProduct, $comparison);
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
     * @return ChildCrawlerProductListingQuery The current query, for fluid interface
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

        return $this->addUsingAlias(CrawlerProductListingTableMap::LINK_FIRST_PRODUCT, $linkFirstProduct, $comparison);
    }

    /**
     * Filter the query on the platform_product_id column
     *
     * Example usage:
     * <code>
     * $query->filterByPlatformProductId('fooValue');   // WHERE platform_product_id = 'fooValue'
     * $query->filterByPlatformProductId('%fooValue%'); // WHERE platform_product_id LIKE '%fooValue%'
     * </code>
     *
     * @param     string $platformProductId The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCrawlerProductListingQuery The current query, for fluid interface
     */
    public function filterByPlatformProductId($platformProductId = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($platformProductId)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $platformProductId)) {
                $platformProductId = str_replace('*', '%', $platformProductId);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(CrawlerProductListingTableMap::PLATFORM_PRODUCT_ID, $platformProductId, $comparison);
    }

    /**
     * Filter the query on the hf_product_stock column
     *
     * Example usage:
     * <code>
     * $query->filterByHfProductStock(1234); // WHERE hf_product_stock = 1234
     * $query->filterByHfProductStock(array(12, 34)); // WHERE hf_product_stock IN (12, 34)
     * $query->filterByHfProductStock(array('min' => 12)); // WHERE hf_product_stock > 12
     * </code>
     *
     * @param     mixed $hfProductStock The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCrawlerProductListingQuery The current query, for fluid interface
     */
    public function filterByHfProductStock($hfProductStock = null, $comparison = null)
    {
        if (is_array($hfProductStock)) {
            $useMinMax = false;
            if (isset($hfProductStock['min'])) {
                $this->addUsingAlias(CrawlerProductListingTableMap::HF_PRODUCT_STOCK, $hfProductStock['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($hfProductStock['max'])) {
                $this->addUsingAlias(CrawlerProductListingTableMap::HF_PRODUCT_STOCK, $hfProductStock['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CrawlerProductListingTableMap::HF_PRODUCT_STOCK, $hfProductStock, $comparison);
    }

    /**
     * Filter the query on the hf_product_stock_order column
     *
     * Example usage:
     * <code>
     * $query->filterByHfProductStockOrder(1234); // WHERE hf_product_stock_order = 1234
     * $query->filterByHfProductStockOrder(array(12, 34)); // WHERE hf_product_stock_order IN (12, 34)
     * $query->filterByHfProductStockOrder(array('min' => 12)); // WHERE hf_product_stock_order > 12
     * </code>
     *
     * @param     mixed $hfProductStockOrder The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCrawlerProductListingQuery The current query, for fluid interface
     */
    public function filterByHfProductStockOrder($hfProductStockOrder = null, $comparison = null)
    {
        if (is_array($hfProductStockOrder)) {
            $useMinMax = false;
            if (isset($hfProductStockOrder['min'])) {
                $this->addUsingAlias(CrawlerProductListingTableMap::HF_PRODUCT_STOCK_ORDER, $hfProductStockOrder['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($hfProductStockOrder['max'])) {
                $this->addUsingAlias(CrawlerProductListingTableMap::HF_PRODUCT_STOCK_ORDER, $hfProductStockOrder['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CrawlerProductListingTableMap::HF_PRODUCT_STOCK_ORDER, $hfProductStockOrder, $comparison);
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
     * @return ChildCrawlerProductListingQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(CrawlerProductListingTableMap::CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(CrawlerProductListingTableMap::CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CrawlerProductListingTableMap::CREATED_AT, $createdAt, $comparison);
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
     * @return ChildCrawlerProductListingQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(CrawlerProductListingTableMap::UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(CrawlerProductListingTableMap::UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CrawlerProductListingTableMap::UPDATED_AT, $updatedAt, $comparison);
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
     * @return ChildCrawlerProductListingQuery The current query, for fluid interface
     */
    public function filterByVersion($version = null, $comparison = null)
    {
        if (is_array($version)) {
            $useMinMax = false;
            if (isset($version['min'])) {
                $this->addUsingAlias(CrawlerProductListingTableMap::VERSION, $version['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($version['max'])) {
                $this->addUsingAlias(CrawlerProductListingTableMap::VERSION, $version['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CrawlerProductListingTableMap::VERSION, $version, $comparison);
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
     * @return ChildCrawlerProductListingQuery The current query, for fluid interface
     */
    public function filterByVersionCreatedAt($versionCreatedAt = null, $comparison = null)
    {
        if (is_array($versionCreatedAt)) {
            $useMinMax = false;
            if (isset($versionCreatedAt['min'])) {
                $this->addUsingAlias(CrawlerProductListingTableMap::VERSION_CREATED_AT, $versionCreatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($versionCreatedAt['max'])) {
                $this->addUsingAlias(CrawlerProductListingTableMap::VERSION_CREATED_AT, $versionCreatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CrawlerProductListingTableMap::VERSION_CREATED_AT, $versionCreatedAt, $comparison);
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
     * @return ChildCrawlerProductListingQuery The current query, for fluid interface
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

        return $this->addUsingAlias(CrawlerProductListingTableMap::VERSION_CREATED_BY, $versionCreatedBy, $comparison);
    }

    /**
     * Filter the query by a related \HookAdminCrawlerDashboard\Model\CrawlerProductBase object
     *
     * @param \HookAdminCrawlerDashboard\Model\CrawlerProductBase|ObjectCollection $crawlerProductBase The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCrawlerProductListingQuery The current query, for fluid interface
     */
    public function filterByCrawlerProductBase($crawlerProductBase, $comparison = null)
    {
        if ($crawlerProductBase instanceof \HookAdminCrawlerDashboard\Model\CrawlerProductBase) {
            return $this
                ->addUsingAlias(CrawlerProductListingTableMap::PRODUCT_BASE_ID, $crawlerProductBase->getId(), $comparison);
        } elseif ($crawlerProductBase instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(CrawlerProductListingTableMap::PRODUCT_BASE_ID, $crawlerProductBase->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByCrawlerProductBase() only accepts arguments of type \HookAdminCrawlerDashboard\Model\CrawlerProductBase or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the CrawlerProductBase relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildCrawlerProductListingQuery The current query, for fluid interface
     */
    public function joinCrawlerProductBase($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
     * @return   \HookAdminCrawlerDashboard\Model\CrawlerProductBaseQuery A secondary query class using the current class as primary query
     */
    public function useCrawlerProductBaseQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinCrawlerProductBase($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'CrawlerProductBase', '\HookAdminCrawlerDashboard\Model\CrawlerProductBaseQuery');
    }

    /**
     * Filter the query by a related \HookAdminCrawlerDashboard\Model\CrawlerProductListingVersion object
     *
     * @param \HookAdminCrawlerDashboard\Model\CrawlerProductListingVersion|ObjectCollection $crawlerProductListingVersion  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCrawlerProductListingQuery The current query, for fluid interface
     */
    public function filterByCrawlerProductListingVersion($crawlerProductListingVersion, $comparison = null)
    {
        if ($crawlerProductListingVersion instanceof \HookAdminCrawlerDashboard\Model\CrawlerProductListingVersion) {
            return $this
                ->addUsingAlias(CrawlerProductListingTableMap::ID, $crawlerProductListingVersion->getId(), $comparison);
        } elseif ($crawlerProductListingVersion instanceof ObjectCollection) {
            return $this
                ->useCrawlerProductListingVersionQuery()
                ->filterByPrimaryKeys($crawlerProductListingVersion->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByCrawlerProductListingVersion() only accepts arguments of type \HookAdminCrawlerDashboard\Model\CrawlerProductListingVersion or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the CrawlerProductListingVersion relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildCrawlerProductListingQuery The current query, for fluid interface
     */
    public function joinCrawlerProductListingVersion($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('CrawlerProductListingVersion');

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
            $this->addJoinObject($join, 'CrawlerProductListingVersion');
        }

        return $this;
    }

    /**
     * Use the CrawlerProductListingVersion relation CrawlerProductListingVersion object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \HookAdminCrawlerDashboard\Model\CrawlerProductListingVersionQuery A secondary query class using the current class as primary query
     */
    public function useCrawlerProductListingVersionQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinCrawlerProductListingVersion($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'CrawlerProductListingVersion', '\HookAdminCrawlerDashboard\Model\CrawlerProductListingVersionQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildCrawlerProductListing $crawlerProductListing Object to remove from the list of results
     *
     * @return ChildCrawlerProductListingQuery The current query, for fluid interface
     */
    public function prune($crawlerProductListing = null)
    {
        if ($crawlerProductListing) {
            $this->addUsingAlias(CrawlerProductListingTableMap::ID, $crawlerProductListing->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the crawler_product_listing table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CrawlerProductListingTableMap::DATABASE_NAME);
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
            CrawlerProductListingTableMap::clearInstancePool();
            CrawlerProductListingTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildCrawlerProductListing or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildCrawlerProductListing object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(CrawlerProductListingTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(CrawlerProductListingTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            

        CrawlerProductListingTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            CrawlerProductListingTableMap::clearRelatedInstancePool();
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
     * @return     ChildCrawlerProductListingQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(CrawlerProductListingTableMap::UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }
    
    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     ChildCrawlerProductListingQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(CrawlerProductListingTableMap::CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }
    
    /**
     * Order by update date desc
     *
     * @return     ChildCrawlerProductListingQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(CrawlerProductListingTableMap::UPDATED_AT);
    }
    
    /**
     * Order by update date asc
     *
     * @return     ChildCrawlerProductListingQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(CrawlerProductListingTableMap::UPDATED_AT);
    }
    
    /**
     * Order by create date desc
     *
     * @return     ChildCrawlerProductListingQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(CrawlerProductListingTableMap::CREATED_AT);
    }
    
    /**
     * Order by create date asc
     *
     * @return     ChildCrawlerProductListingQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(CrawlerProductListingTableMap::CREATED_AT);
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

} // CrawlerProductListingQuery
