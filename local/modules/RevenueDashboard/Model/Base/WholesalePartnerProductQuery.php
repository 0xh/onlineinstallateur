<?php

namespace RevenueDashboard\Model\Base;

use \Exception;
use \PDO;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;
use RevenueDashboard\Model\WholesalePartnerProduct as ChildWholesalePartnerProduct;
use RevenueDashboard\Model\WholesalePartnerProductQuery as ChildWholesalePartnerProductQuery;
use RevenueDashboard\Model\Map\WholesalePartnerProductTableMap;
use Thelia\Model\Product;

/**
 * Base class that represents a query for the 'wholesale_partner_product' table.
 *
 *
 *
 * @method     ChildWholesalePartnerProductQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildWholesalePartnerProductQuery orderByPartnerId($order = Criteria::ASC) Order by the partner_id column
 * @method     ChildWholesalePartnerProductQuery orderByProductId($order = Criteria::ASC) Order by the product_id column
 * @method     ChildWholesalePartnerProductQuery orderByPartnerProdRef($order = Criteria::ASC) Order by the partner_product_ref column
 * @method     ChildWholesalePartnerProductQuery orderByPrice($order = Criteria::ASC) Order by the price column
 * @method     ChildWholesalePartnerProductQuery orderByPackageSize($order = Criteria::ASC) Order by the package_size column
 * @method     ChildWholesalePartnerProductQuery orderByDeliveryCost($order = Criteria::ASC) Order by the delivery_cost column
 * @method     ChildWholesalePartnerProductQuery orderByDiscount($order = Criteria::ASC) Order by the discount column
 * @method     ChildWholesalePartnerProductQuery orderByDiscountDescription($order = Criteria::ASC) Order by the discount_description column
 * @method     ChildWholesalePartnerProductQuery orderByProfileWebsite($order = Criteria::ASC) Order by the profile_website column
 * @method     ChildWholesalePartnerProductQuery orderByPosition($order = Criteria::ASC) Order by the position column
 * @method     ChildWholesalePartnerProductQuery orderByDepartment($order = Criteria::ASC) Order by the department column
 * @method     ChildWholesalePartnerProductQuery orderByComment($order = Criteria::ASC) Order by the comment column
 * @method     ChildWholesalePartnerProductQuery orderByValidUntil($order = Criteria::ASC) Order by the valid_until column
 * @method     ChildWholesalePartnerProductQuery orderByVersion($order = Criteria::ASC) Order by the version column
 * @method     ChildWholesalePartnerProductQuery orderByVersionCreatedBy($order = Criteria::ASC) Order by the version_created_by column
 *
 * @method     ChildWholesalePartnerProductQuery groupById() Group by the id column
 * @method     ChildWholesalePartnerProductQuery groupByPartnerId() Group by the partner_id column
 * @method     ChildWholesalePartnerProductQuery groupByProductId() Group by the product_id column
 * @method     ChildWholesalePartnerProductQuery groupByPartnerProdRef() Group by the partner_product_ref column
 * @method     ChildWholesalePartnerProductQuery groupByPrice() Group by the price column
 * @method     ChildWholesalePartnerProductQuery groupByPackageSize() Group by the package_size column
 * @method     ChildWholesalePartnerProductQuery groupByDeliveryCost() Group by the delivery_cost column
 * @method     ChildWholesalePartnerProductQuery groupByDiscount() Group by the discount column
 * @method     ChildWholesalePartnerProductQuery groupByDiscountDescription() Group by the discount_description column
 * @method     ChildWholesalePartnerProductQuery groupByProfileWebsite() Group by the profile_website column
 * @method     ChildWholesalePartnerProductQuery groupByPosition() Group by the position column
 * @method     ChildWholesalePartnerProductQuery groupByDepartment() Group by the department column
 * @method     ChildWholesalePartnerProductQuery groupByComment() Group by the comment column
 * @method     ChildWholesalePartnerProductQuery groupByValidUntil() Group by the valid_until column
 * @method     ChildWholesalePartnerProductQuery groupByVersion() Group by the version column
 * @method     ChildWholesalePartnerProductQuery groupByVersionCreatedBy() Group by the version_created_by column
 *
 * @method     ChildWholesalePartnerProductQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildWholesalePartnerProductQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildWholesalePartnerProductQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildWholesalePartnerProductQuery leftJoinProduct($relationAlias = null) Adds a LEFT JOIN clause to the query using the Product relation
 * @method     ChildWholesalePartnerProductQuery rightJoinProduct($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Product relation
 * @method     ChildWholesalePartnerProductQuery innerJoinProduct($relationAlias = null) Adds a INNER JOIN clause to the query using the Product relation
 *
 * @method     ChildWholesalePartnerProductQuery leftJoinWholesalePartnerProductVersion($relationAlias = null) Adds a LEFT JOIN clause to the query using the WholesalePartnerProductVersion relation
 * @method     ChildWholesalePartnerProductQuery rightJoinWholesalePartnerProductVersion($relationAlias = null) Adds a RIGHT JOIN clause to the query using the WholesalePartnerProductVersion relation
 * @method     ChildWholesalePartnerProductQuery innerJoinWholesalePartnerProductVersion($relationAlias = null) Adds a INNER JOIN clause to the query using the WholesalePartnerProductVersion relation
 *
 * @method     ChildWholesalePartnerProduct findOne(ConnectionInterface $con = null) Return the first ChildWholesalePartnerProduct matching the query
 * @method     ChildWholesalePartnerProduct findOneOrCreate(ConnectionInterface $con = null) Return the first ChildWholesalePartnerProduct matching the query, or a new ChildWholesalePartnerProduct object populated from the query conditions when no match is found
 *
 * @method     ChildWholesalePartnerProduct findOneById(int $id) Return the first ChildWholesalePartnerProduct filtered by the id column
 * @method     ChildWholesalePartnerProduct findOneByPartnerId(int $partner_id) Return the first ChildWholesalePartnerProduct filtered by the partner_id column
 * @method     ChildWholesalePartnerProduct findOneByProductId(int $product_id) Return the first ChildWholesalePartnerProduct filtered by the product_id column
 * @method     ChildWholesalePartnerProduct findOneByPartnerProdRef(string $partner_product_ref) Return the first ChildWholesalePartnerProduct filtered by the partner_product_ref column
 * @method     ChildWholesalePartnerProduct findOneByPrice(string $price) Return the first ChildWholesalePartnerProduct filtered by the price column
 * @method     ChildWholesalePartnerProduct findOneByPackageSize(int $package_size) Return the first ChildWholesalePartnerProduct filtered by the package_size column
 * @method     ChildWholesalePartnerProduct findOneByDeliveryCost(string $delivery_cost) Return the first ChildWholesalePartnerProduct filtered by the delivery_cost column
 * @method     ChildWholesalePartnerProduct findOneByDiscount(string $discount) Return the first ChildWholesalePartnerProduct filtered by the discount column
 * @method     ChildWholesalePartnerProduct findOneByDiscountDescription(string $discount_description) Return the first ChildWholesalePartnerProduct filtered by the discount_description column
 * @method     ChildWholesalePartnerProduct findOneByProfileWebsite(string $profile_website) Return the first ChildWholesalePartnerProduct filtered by the profile_website column
 * @method     ChildWholesalePartnerProduct findOneByPosition(string $position) Return the first ChildWholesalePartnerProduct filtered by the position column
 * @method     ChildWholesalePartnerProduct findOneByDepartment(string $department) Return the first ChildWholesalePartnerProduct filtered by the department column
 * @method     ChildWholesalePartnerProduct findOneByComment(string $comment) Return the first ChildWholesalePartnerProduct filtered by the comment column
 * @method     ChildWholesalePartnerProduct findOneByValidUntil(string $valid_until) Return the first ChildWholesalePartnerProduct filtered by the valid_until column
 * @method     ChildWholesalePartnerProduct findOneByVersion(int $version) Return the first ChildWholesalePartnerProduct filtered by the version column
 * @method     ChildWholesalePartnerProduct findOneByVersionCreatedBy(string $version_created_by) Return the first ChildWholesalePartnerProduct filtered by the version_created_by column
 *
 * @method     array findById(int $id) Return ChildWholesalePartnerProduct objects filtered by the id column
 * @method     array findByPartnerId(int $partner_id) Return ChildWholesalePartnerProduct objects filtered by the partner_id column
 * @method     array findByProductId(int $product_id) Return ChildWholesalePartnerProduct objects filtered by the product_id column
 * @method     array findByPartnerProdRef(string $partner_product_ref) Return ChildWholesalePartnerProduct objects filtered by the partner_product_ref column
 * @method     array findByPrice(string $price) Return ChildWholesalePartnerProduct objects filtered by the price column
 * @method     array findByPackageSize(int $package_size) Return ChildWholesalePartnerProduct objects filtered by the package_size column
 * @method     array findByDeliveryCost(string $delivery_cost) Return ChildWholesalePartnerProduct objects filtered by the delivery_cost column
 * @method     array findByDiscount(string $discount) Return ChildWholesalePartnerProduct objects filtered by the discount column
 * @method     array findByDiscountDescription(string $discount_description) Return ChildWholesalePartnerProduct objects filtered by the discount_description column
 * @method     array findByProfileWebsite(string $profile_website) Return ChildWholesalePartnerProduct objects filtered by the profile_website column
 * @method     array findByPosition(string $position) Return ChildWholesalePartnerProduct objects filtered by the position column
 * @method     array findByDepartment(string $department) Return ChildWholesalePartnerProduct objects filtered by the department column
 * @method     array findByComment(string $comment) Return ChildWholesalePartnerProduct objects filtered by the comment column
 * @method     array findByValidUntil(string $valid_until) Return ChildWholesalePartnerProduct objects filtered by the valid_until column
 * @method     array findByVersion(int $version) Return ChildWholesalePartnerProduct objects filtered by the version column
 * @method     array findByVersionCreatedBy(string $version_created_by) Return ChildWholesalePartnerProduct objects filtered by the version_created_by column
 *
 */
abstract class WholesalePartnerProductQuery extends ModelCriteria
{

    // versionable behavior

    /**
     * Whether the versioning is enabled
     */
    static $isVersioningEnabled = true;

    /**
     * Initializes internal state of \RevenueDashboard\Model\Base\WholesalePartnerProductQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'thelia', $modelName = '\\RevenueDashboard\\Model\\WholesalePartnerProduct', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildWholesalePartnerProductQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildWholesalePartnerProductQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \RevenueDashboard\Model\WholesalePartnerProductQuery) {
            return $criteria;
        }
        $query = new \RevenueDashboard\Model\WholesalePartnerProductQuery();
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
     * @return ChildWholesalePartnerProduct|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = WholesalePartnerProductTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(WholesalePartnerProductTableMap::DATABASE_NAME);
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
     * @return   ChildWholesalePartnerProduct A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ID, PARTNER_ID, PRODUCT_ID, PARTNER_PRODUCT_REF, PRICE, PACKAGE_SIZE, DELIVERY_COST, DISCOUNT, DISCOUNT_DESCRIPTION, PROFILE_WEBSITE, POSITION, DEPARTMENT, COMMENT, VALID_UNTIL, VERSION, VERSION_CREATED_BY FROM wholesale_partner_product WHERE ID = :p0';
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
            $obj = new ChildWholesalePartnerProduct();
            $obj->hydrate($row);
            WholesalePartnerProductTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildWholesalePartnerProduct|array|mixed the result, formatted by the current formatter
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
     * @return ChildWholesalePartnerProductQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(WholesalePartnerProductTableMap::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildWholesalePartnerProductQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(WholesalePartnerProductTableMap::ID, $keys, Criteria::IN);
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
     * @return ChildWholesalePartnerProductQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(WholesalePartnerProductTableMap::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(WholesalePartnerProductTableMap::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(WholesalePartnerProductTableMap::ID, $id, $comparison);
    }

    /**
     * Filter the query on the partner_id column
     *
     * Example usage:
     * <code>
     * $query->filterByPartnerId(1234); // WHERE partner_id = 1234
     * $query->filterByPartnerId(array(12, 34)); // WHERE partner_id IN (12, 34)
     * $query->filterByPartnerId(array('min' => 12)); // WHERE partner_id > 12
     * </code>
     *
     * @param     mixed $partnerId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildWholesalePartnerProductQuery The current query, for fluid interface
     */
    public function filterByPartnerId($partnerId = null, $comparison = null)
    {
        if (is_array($partnerId)) {
            $useMinMax = false;
            if (isset($partnerId['min'])) {
                $this->addUsingAlias(WholesalePartnerProductTableMap::PARTNER_ID, $partnerId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($partnerId['max'])) {
                $this->addUsingAlias(WholesalePartnerProductTableMap::PARTNER_ID, $partnerId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(WholesalePartnerProductTableMap::PARTNER_ID, $partnerId, $comparison);
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
     * @return ChildWholesalePartnerProductQuery The current query, for fluid interface
     */
    public function filterByProductId($productId = null, $comparison = null)
    {
        if (is_array($productId)) {
            $useMinMax = false;
            if (isset($productId['min'])) {
                $this->addUsingAlias(WholesalePartnerProductTableMap::PRODUCT_ID, $productId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($productId['max'])) {
                $this->addUsingAlias(WholesalePartnerProductTableMap::PRODUCT_ID, $productId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(WholesalePartnerProductTableMap::PRODUCT_ID, $productId, $comparison);
    }

    /**
     * Filter the query on the partner_product_ref column
     *
     * Example usage:
     * <code>
     * $query->filterByPartnerProdRef('fooValue');   // WHERE partner_product_ref = 'fooValue'
     * $query->filterByPartnerProdRef('%fooValue%'); // WHERE partner_product_ref LIKE '%fooValue%'
     * </code>
     *
     * @param     string $partnerProdRef The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildWholesalePartnerProductQuery The current query, for fluid interface
     */
    public function filterByPartnerProdRef($partnerProdRef = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($partnerProdRef)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $partnerProdRef)) {
                $partnerProdRef = str_replace('*', '%', $partnerProdRef);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(WholesalePartnerProductTableMap::PARTNER_PRODUCT_REF, $partnerProdRef, $comparison);
    }

    /**
     * Filter the query on the price column
     *
     * Example usage:
     * <code>
     * $query->filterByPrice(1234); // WHERE price = 1234
     * $query->filterByPrice(array(12, 34)); // WHERE price IN (12, 34)
     * $query->filterByPrice(array('min' => 12)); // WHERE price > 12
     * </code>
     *
     * @param     mixed $price The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildWholesalePartnerProductQuery The current query, for fluid interface
     */
    public function filterByPrice($price = null, $comparison = null)
    {
        if (is_array($price)) {
            $useMinMax = false;
            if (isset($price['min'])) {
                $this->addUsingAlias(WholesalePartnerProductTableMap::PRICE, $price['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($price['max'])) {
                $this->addUsingAlias(WholesalePartnerProductTableMap::PRICE, $price['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(WholesalePartnerProductTableMap::PRICE, $price, $comparison);
    }

    /**
     * Filter the query on the package_size column
     *
     * Example usage:
     * <code>
     * $query->filterByPackageSize(1234); // WHERE package_size = 1234
     * $query->filterByPackageSize(array(12, 34)); // WHERE package_size IN (12, 34)
     * $query->filterByPackageSize(array('min' => 12)); // WHERE package_size > 12
     * </code>
     *
     * @param     mixed $packageSize The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildWholesalePartnerProductQuery The current query, for fluid interface
     */
    public function filterByPackageSize($packageSize = null, $comparison = null)
    {
        if (is_array($packageSize)) {
            $useMinMax = false;
            if (isset($packageSize['min'])) {
                $this->addUsingAlias(WholesalePartnerProductTableMap::PACKAGE_SIZE, $packageSize['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($packageSize['max'])) {
                $this->addUsingAlias(WholesalePartnerProductTableMap::PACKAGE_SIZE, $packageSize['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(WholesalePartnerProductTableMap::PACKAGE_SIZE, $packageSize, $comparison);
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
     * @return ChildWholesalePartnerProductQuery The current query, for fluid interface
     */
    public function filterByDeliveryCost($deliveryCost = null, $comparison = null)
    {
        if (is_array($deliveryCost)) {
            $useMinMax = false;
            if (isset($deliveryCost['min'])) {
                $this->addUsingAlias(WholesalePartnerProductTableMap::DELIVERY_COST, $deliveryCost['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($deliveryCost['max'])) {
                $this->addUsingAlias(WholesalePartnerProductTableMap::DELIVERY_COST, $deliveryCost['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(WholesalePartnerProductTableMap::DELIVERY_COST, $deliveryCost, $comparison);
    }

    /**
     * Filter the query on the discount column
     *
     * Example usage:
     * <code>
     * $query->filterByDiscount(1234); // WHERE discount = 1234
     * $query->filterByDiscount(array(12, 34)); // WHERE discount IN (12, 34)
     * $query->filterByDiscount(array('min' => 12)); // WHERE discount > 12
     * </code>
     *
     * @param     mixed $discount The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildWholesalePartnerProductQuery The current query, for fluid interface
     */
    public function filterByDiscount($discount = null, $comparison = null)
    {
        if (is_array($discount)) {
            $useMinMax = false;
            if (isset($discount['min'])) {
                $this->addUsingAlias(WholesalePartnerProductTableMap::DISCOUNT, $discount['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($discount['max'])) {
                $this->addUsingAlias(WholesalePartnerProductTableMap::DISCOUNT, $discount['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(WholesalePartnerProductTableMap::DISCOUNT, $discount, $comparison);
    }

    /**
     * Filter the query on the discount_description column
     *
     * Example usage:
     * <code>
     * $query->filterByDiscountDescription('fooValue');   // WHERE discount_description = 'fooValue'
     * $query->filterByDiscountDescription('%fooValue%'); // WHERE discount_description LIKE '%fooValue%'
     * </code>
     *
     * @param     string $discountDescription The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildWholesalePartnerProductQuery The current query, for fluid interface
     */
    public function filterByDiscountDescription($discountDescription = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($discountDescription)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $discountDescription)) {
                $discountDescription = str_replace('*', '%', $discountDescription);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(WholesalePartnerProductTableMap::DISCOUNT_DESCRIPTION, $discountDescription, $comparison);
    }

    /**
     * Filter the query on the profile_website column
     *
     * Example usage:
     * <code>
     * $query->filterByProfileWebsite('fooValue');   // WHERE profile_website = 'fooValue'
     * $query->filterByProfileWebsite('%fooValue%'); // WHERE profile_website LIKE '%fooValue%'
     * </code>
     *
     * @param     string $profileWebsite The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildWholesalePartnerProductQuery The current query, for fluid interface
     */
    public function filterByProfileWebsite($profileWebsite = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($profileWebsite)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $profileWebsite)) {
                $profileWebsite = str_replace('*', '%', $profileWebsite);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(WholesalePartnerProductTableMap::PROFILE_WEBSITE, $profileWebsite, $comparison);
    }

    /**
     * Filter the query on the position column
     *
     * Example usage:
     * <code>
     * $query->filterByPosition('fooValue');   // WHERE position = 'fooValue'
     * $query->filterByPosition('%fooValue%'); // WHERE position LIKE '%fooValue%'
     * </code>
     *
     * @param     string $position The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildWholesalePartnerProductQuery The current query, for fluid interface
     */
    public function filterByPosition($position = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($position)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $position)) {
                $position = str_replace('*', '%', $position);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(WholesalePartnerProductTableMap::POSITION, $position, $comparison);
    }

    /**
     * Filter the query on the department column
     *
     * Example usage:
     * <code>
     * $query->filterByDepartment('fooValue');   // WHERE department = 'fooValue'
     * $query->filterByDepartment('%fooValue%'); // WHERE department LIKE '%fooValue%'
     * </code>
     *
     * @param     string $department The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildWholesalePartnerProductQuery The current query, for fluid interface
     */
    public function filterByDepartment($department = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($department)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $department)) {
                $department = str_replace('*', '%', $department);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(WholesalePartnerProductTableMap::DEPARTMENT, $department, $comparison);
    }

    /**
     * Filter the query on the comment column
     *
     * Example usage:
     * <code>
     * $query->filterByComment('fooValue');   // WHERE comment = 'fooValue'
     * $query->filterByComment('%fooValue%'); // WHERE comment LIKE '%fooValue%'
     * </code>
     *
     * @param     string $comment The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildWholesalePartnerProductQuery The current query, for fluid interface
     */
    public function filterByComment($comment = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($comment)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $comment)) {
                $comment = str_replace('*', '%', $comment);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(WholesalePartnerProductTableMap::COMMENT, $comment, $comparison);
    }

    /**
     * Filter the query on the valid_until column
     *
     * Example usage:
     * <code>
     * $query->filterByValidUntil('2011-03-14'); // WHERE valid_until = '2011-03-14'
     * $query->filterByValidUntil('now'); // WHERE valid_until = '2011-03-14'
     * $query->filterByValidUntil(array('max' => 'yesterday')); // WHERE valid_until > '2011-03-13'
     * </code>
     *
     * @param     mixed $validUntil The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildWholesalePartnerProductQuery The current query, for fluid interface
     */
    public function filterByValidUntil($validUntil = null, $comparison = null)
    {
        if (is_array($validUntil)) {
            $useMinMax = false;
            if (isset($validUntil['min'])) {
                $this->addUsingAlias(WholesalePartnerProductTableMap::VALID_UNTIL, $validUntil['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($validUntil['max'])) {
                $this->addUsingAlias(WholesalePartnerProductTableMap::VALID_UNTIL, $validUntil['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(WholesalePartnerProductTableMap::VALID_UNTIL, $validUntil, $comparison);
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
     * @return ChildWholesalePartnerProductQuery The current query, for fluid interface
     */
    public function filterByVersion($version = null, $comparison = null)
    {
        if (is_array($version)) {
            $useMinMax = false;
            if (isset($version['min'])) {
                $this->addUsingAlias(WholesalePartnerProductTableMap::VERSION, $version['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($version['max'])) {
                $this->addUsingAlias(WholesalePartnerProductTableMap::VERSION, $version['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(WholesalePartnerProductTableMap::VERSION, $version, $comparison);
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
     * @return ChildWholesalePartnerProductQuery The current query, for fluid interface
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

        return $this->addUsingAlias(WholesalePartnerProductTableMap::VERSION_CREATED_BY, $versionCreatedBy, $comparison);
    }

    /**
     * Filter the query by a related \Thelia\Model\Product object
     *
     * @param \Thelia\Model\Product|ObjectCollection $product The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildWholesalePartnerProductQuery The current query, for fluid interface
     */
    public function filterByProduct($product, $comparison = null)
    {
        if ($product instanceof \Thelia\Model\Product) {
            return $this
                ->addUsingAlias(WholesalePartnerProductTableMap::PRODUCT_ID, $product->getId(), $comparison);
        } elseif ($product instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(WholesalePartnerProductTableMap::PRODUCT_ID, $product->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return ChildWholesalePartnerProductQuery The current query, for fluid interface
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
     * Filter the query by a related \RevenueDashboard\Model\WholesalePartnerProductVersion object
     *
     * @param \RevenueDashboard\Model\WholesalePartnerProductVersion|ObjectCollection $wholesalePartnerProductVersion  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildWholesalePartnerProductQuery The current query, for fluid interface
     */
    public function filterByWholesalePartnerProductVersion($wholesalePartnerProductVersion, $comparison = null)
    {
        if ($wholesalePartnerProductVersion instanceof \RevenueDashboard\Model\WholesalePartnerProductVersion) {
            return $this
                ->addUsingAlias(WholesalePartnerProductTableMap::ID, $wholesalePartnerProductVersion->getId(), $comparison);
        } elseif ($wholesalePartnerProductVersion instanceof ObjectCollection) {
            return $this
                ->useWholesalePartnerProductVersionQuery()
                ->filterByPrimaryKeys($wholesalePartnerProductVersion->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByWholesalePartnerProductVersion() only accepts arguments of type \RevenueDashboard\Model\WholesalePartnerProductVersion or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the WholesalePartnerProductVersion relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildWholesalePartnerProductQuery The current query, for fluid interface
     */
    public function joinWholesalePartnerProductVersion($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('WholesalePartnerProductVersion');

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
            $this->addJoinObject($join, 'WholesalePartnerProductVersion');
        }

        return $this;
    }

    /**
     * Use the WholesalePartnerProductVersion relation WholesalePartnerProductVersion object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \RevenueDashboard\Model\WholesalePartnerProductVersionQuery A secondary query class using the current class as primary query
     */
    public function useWholesalePartnerProductVersionQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinWholesalePartnerProductVersion($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'WholesalePartnerProductVersion', '\RevenueDashboard\Model\WholesalePartnerProductVersionQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildWholesalePartnerProduct $wholesalePartnerProduct Object to remove from the list of results
     *
     * @return ChildWholesalePartnerProductQuery The current query, for fluid interface
     */
    public function prune($wholesalePartnerProduct = null)
    {
        if ($wholesalePartnerProduct) {
            $this->addUsingAlias(WholesalePartnerProductTableMap::ID, $wholesalePartnerProduct->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the wholesale_partner_product table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(WholesalePartnerProductTableMap::DATABASE_NAME);
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
            WholesalePartnerProductTableMap::clearInstancePool();
            WholesalePartnerProductTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildWholesalePartnerProduct or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildWholesalePartnerProduct object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(WholesalePartnerProductTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(WholesalePartnerProductTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();


        WholesalePartnerProductTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            WholesalePartnerProductTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
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

} // WholesalePartnerProductQuery
