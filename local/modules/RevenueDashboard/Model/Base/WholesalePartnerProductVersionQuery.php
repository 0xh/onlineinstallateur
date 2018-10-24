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
use RevenueDashboard\Model\WholesalePartnerProductVersion as ChildWholesalePartnerProductVersion;
use RevenueDashboard\Model\WholesalePartnerProductVersionQuery as ChildWholesalePartnerProductVersionQuery;
use RevenueDashboard\Model\Map\WholesalePartnerProductVersionTableMap;

/**
 * Base class that represents a query for the 'wholesale_partner_product_version' table.
 *
 * 
 *
 * @method     ChildWholesalePartnerProductVersionQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildWholesalePartnerProductVersionQuery orderByPartnerId($order = Criteria::ASC) Order by the partner_id column
 * @method     ChildWholesalePartnerProductVersionQuery orderByProductId($order = Criteria::ASC) Order by the product_id column
 * @method     ChildWholesalePartnerProductVersionQuery orderByPartnerProdRef($order = Criteria::ASC) Order by the partner_product_ref column
 * @method     ChildWholesalePartnerProductVersionQuery orderByPrice($order = Criteria::ASC) Order by the price column
 * @method     ChildWholesalePartnerProductVersionQuery orderByPackageSize($order = Criteria::ASC) Order by the package_size column
 * @method     ChildWholesalePartnerProductVersionQuery orderByDeliveryCost($order = Criteria::ASC) Order by the delivery_cost column
 * @method     ChildWholesalePartnerProductVersionQuery orderByDiscount($order = Criteria::ASC) Order by the discount column
 * @method     ChildWholesalePartnerProductVersionQuery orderByDiscountDescription($order = Criteria::ASC) Order by the discount_description column
 * @method     ChildWholesalePartnerProductVersionQuery orderByProfileWebsite($order = Criteria::ASC) Order by the profile_website column
 * @method     ChildWholesalePartnerProductVersionQuery orderByPosition($order = Criteria::ASC) Order by the position column
 * @method     ChildWholesalePartnerProductVersionQuery orderByDepartment($order = Criteria::ASC) Order by the department column
 * @method     ChildWholesalePartnerProductVersionQuery orderByComment($order = Criteria::ASC) Order by the comment column
 * @method     ChildWholesalePartnerProductVersionQuery orderByValidUntil($order = Criteria::ASC) Order by the valid_until column
 * @method     ChildWholesalePartnerProductVersionQuery orderByVersion($order = Criteria::ASC) Order by the version column
 * @method     ChildWholesalePartnerProductVersionQuery orderByVersionCreatedBy($order = Criteria::ASC) Order by the version_created_by column
 * @method     ChildWholesalePartnerProductVersionQuery orderByProductIdVersion($order = Criteria::ASC) Order by the product_id_version column
 *
 * @method     ChildWholesalePartnerProductVersionQuery groupById() Group by the id column
 * @method     ChildWholesalePartnerProductVersionQuery groupByPartnerId() Group by the partner_id column
 * @method     ChildWholesalePartnerProductVersionQuery groupByProductId() Group by the product_id column
 * @method     ChildWholesalePartnerProductVersionQuery groupByPartnerProdRef() Group by the partner_product_ref column
 * @method     ChildWholesalePartnerProductVersionQuery groupByPrice() Group by the price column
 * @method     ChildWholesalePartnerProductVersionQuery groupByPackageSize() Group by the package_size column
 * @method     ChildWholesalePartnerProductVersionQuery groupByDeliveryCost() Group by the delivery_cost column
 * @method     ChildWholesalePartnerProductVersionQuery groupByDiscount() Group by the discount column
 * @method     ChildWholesalePartnerProductVersionQuery groupByDiscountDescription() Group by the discount_description column
 * @method     ChildWholesalePartnerProductVersionQuery groupByProfileWebsite() Group by the profile_website column
 * @method     ChildWholesalePartnerProductVersionQuery groupByPosition() Group by the position column
 * @method     ChildWholesalePartnerProductVersionQuery groupByDepartment() Group by the department column
 * @method     ChildWholesalePartnerProductVersionQuery groupByComment() Group by the comment column
 * @method     ChildWholesalePartnerProductVersionQuery groupByValidUntil() Group by the valid_until column
 * @method     ChildWholesalePartnerProductVersionQuery groupByVersion() Group by the version column
 * @method     ChildWholesalePartnerProductVersionQuery groupByVersionCreatedBy() Group by the version_created_by column
 * @method     ChildWholesalePartnerProductVersionQuery groupByProductIdVersion() Group by the product_id_version column
 *
 * @method     ChildWholesalePartnerProductVersionQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildWholesalePartnerProductVersionQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildWholesalePartnerProductVersionQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildWholesalePartnerProductVersionQuery leftJoinWholesalePartnerProduct($relationAlias = null) Adds a LEFT JOIN clause to the query using the WholesalePartnerProduct relation
 * @method     ChildWholesalePartnerProductVersionQuery rightJoinWholesalePartnerProduct($relationAlias = null) Adds a RIGHT JOIN clause to the query using the WholesalePartnerProduct relation
 * @method     ChildWholesalePartnerProductVersionQuery innerJoinWholesalePartnerProduct($relationAlias = null) Adds a INNER JOIN clause to the query using the WholesalePartnerProduct relation
 *
 * @method     ChildWholesalePartnerProductVersion findOne(ConnectionInterface $con = null) Return the first ChildWholesalePartnerProductVersion matching the query
 * @method     ChildWholesalePartnerProductVersion findOneOrCreate(ConnectionInterface $con = null) Return the first ChildWholesalePartnerProductVersion matching the query, or a new ChildWholesalePartnerProductVersion object populated from the query conditions when no match is found
 *
 * @method     ChildWholesalePartnerProductVersion findOneById(int $id) Return the first ChildWholesalePartnerProductVersion filtered by the id column
 * @method     ChildWholesalePartnerProductVersion findOneByPartnerId(int $partner_id) Return the first ChildWholesalePartnerProductVersion filtered by the partner_id column
 * @method     ChildWholesalePartnerProductVersion findOneByProductId(int $product_id) Return the first ChildWholesalePartnerProductVersion filtered by the product_id column
 * @method     ChildWholesalePartnerProductVersion findOneByPartnerProdRef(string $partner_product_ref) Return the first ChildWholesalePartnerProductVersion filtered by the partner_product_ref column
 * @method     ChildWholesalePartnerProductVersion findOneByPrice(string $price) Return the first ChildWholesalePartnerProductVersion filtered by the price column
 * @method     ChildWholesalePartnerProductVersion findOneByPackageSize(int $package_size) Return the first ChildWholesalePartnerProductVersion filtered by the package_size column
 * @method     ChildWholesalePartnerProductVersion findOneByDeliveryCost(string $delivery_cost) Return the first ChildWholesalePartnerProductVersion filtered by the delivery_cost column
 * @method     ChildWholesalePartnerProductVersion findOneByDiscount(string $discount) Return the first ChildWholesalePartnerProductVersion filtered by the discount column
 * @method     ChildWholesalePartnerProductVersion findOneByDiscountDescription(string $discount_description) Return the first ChildWholesalePartnerProductVersion filtered by the discount_description column
 * @method     ChildWholesalePartnerProductVersion findOneByProfileWebsite(string $profile_website) Return the first ChildWholesalePartnerProductVersion filtered by the profile_website column
 * @method     ChildWholesalePartnerProductVersion findOneByPosition(string $position) Return the first ChildWholesalePartnerProductVersion filtered by the position column
 * @method     ChildWholesalePartnerProductVersion findOneByDepartment(string $department) Return the first ChildWholesalePartnerProductVersion filtered by the department column
 * @method     ChildWholesalePartnerProductVersion findOneByComment(string $comment) Return the first ChildWholesalePartnerProductVersion filtered by the comment column
 * @method     ChildWholesalePartnerProductVersion findOneByValidUntil(string $valid_until) Return the first ChildWholesalePartnerProductVersion filtered by the valid_until column
 * @method     ChildWholesalePartnerProductVersion findOneByVersion(int $version) Return the first ChildWholesalePartnerProductVersion filtered by the version column
 * @method     ChildWholesalePartnerProductVersion findOneByVersionCreatedBy(string $version_created_by) Return the first ChildWholesalePartnerProductVersion filtered by the version_created_by column
 * @method     ChildWholesalePartnerProductVersion findOneByProductIdVersion(int $product_id_version) Return the first ChildWholesalePartnerProductVersion filtered by the product_id_version column
 *
 * @method     array findById(int $id) Return ChildWholesalePartnerProductVersion objects filtered by the id column
 * @method     array findByPartnerId(int $partner_id) Return ChildWholesalePartnerProductVersion objects filtered by the partner_id column
 * @method     array findByProductId(int $product_id) Return ChildWholesalePartnerProductVersion objects filtered by the product_id column
 * @method     array findByPartnerProdRef(string $partner_product_ref) Return ChildWholesalePartnerProductVersion objects filtered by the partner_product_ref column
 * @method     array findByPrice(string $price) Return ChildWholesalePartnerProductVersion objects filtered by the price column
 * @method     array findByPackageSize(int $package_size) Return ChildWholesalePartnerProductVersion objects filtered by the package_size column
 * @method     array findByDeliveryCost(string $delivery_cost) Return ChildWholesalePartnerProductVersion objects filtered by the delivery_cost column
 * @method     array findByDiscount(string $discount) Return ChildWholesalePartnerProductVersion objects filtered by the discount column
 * @method     array findByDiscountDescription(string $discount_description) Return ChildWholesalePartnerProductVersion objects filtered by the discount_description column
 * @method     array findByProfileWebsite(string $profile_website) Return ChildWholesalePartnerProductVersion objects filtered by the profile_website column
 * @method     array findByPosition(string $position) Return ChildWholesalePartnerProductVersion objects filtered by the position column
 * @method     array findByDepartment(string $department) Return ChildWholesalePartnerProductVersion objects filtered by the department column
 * @method     array findByComment(string $comment) Return ChildWholesalePartnerProductVersion objects filtered by the comment column
 * @method     array findByValidUntil(string $valid_until) Return ChildWholesalePartnerProductVersion objects filtered by the valid_until column
 * @method     array findByVersion(int $version) Return ChildWholesalePartnerProductVersion objects filtered by the version column
 * @method     array findByVersionCreatedBy(string $version_created_by) Return ChildWholesalePartnerProductVersion objects filtered by the version_created_by column
 * @method     array findByProductIdVersion(int $product_id_version) Return ChildWholesalePartnerProductVersion objects filtered by the product_id_version column
 *
 */
abstract class WholesalePartnerProductVersionQuery extends ModelCriteria
{
    
    /**
     * Initializes internal state of \RevenueDashboard\Model\Base\WholesalePartnerProductVersionQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'thelia', $modelName = '\\RevenueDashboard\\Model\\WholesalePartnerProductVersion', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildWholesalePartnerProductVersionQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildWholesalePartnerProductVersionQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \RevenueDashboard\Model\WholesalePartnerProductVersionQuery) {
            return $criteria;
        }
        $query = new \RevenueDashboard\Model\WholesalePartnerProductVersionQuery();
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
     * @return ChildWholesalePartnerProductVersion|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = WholesalePartnerProductVersionTableMap::getInstanceFromPool(serialize(array((string) $key[0], (string) $key[1]))))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(WholesalePartnerProductVersionTableMap::DATABASE_NAME);
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
     * @return   ChildWholesalePartnerProductVersion A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ID, PARTNER_ID, PRODUCT_ID, PARTNER_PRODUCT_REF, PRICE, PACKAGE_SIZE, DELIVERY_COST, DISCOUNT, DISCOUNT_DESCRIPTION, PROFILE_WEBSITE, POSITION, DEPARTMENT, COMMENT, VALID_UNTIL, VERSION, VERSION_CREATED_BY, PRODUCT_ID_VERSION FROM wholesale_partner_product_version WHERE ID = :p0 AND VERSION = :p1';
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
            $obj = new ChildWholesalePartnerProductVersion();
            $obj->hydrate($row);
            WholesalePartnerProductVersionTableMap::addInstanceToPool($obj, serialize(array((string) $key[0], (string) $key[1])));
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
     * @return ChildWholesalePartnerProductVersion|array|mixed the result, formatted by the current formatter
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
     * @return ChildWholesalePartnerProductVersionQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(WholesalePartnerProductVersionTableMap::ID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(WholesalePartnerProductVersionTableMap::VERSION, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildWholesalePartnerProductVersionQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(WholesalePartnerProductVersionTableMap::ID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(WholesalePartnerProductVersionTableMap::VERSION, $key[1], Criteria::EQUAL);
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
     * @see       filterByWholesalePartnerProduct()
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildWholesalePartnerProductVersionQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(WholesalePartnerProductVersionTableMap::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(WholesalePartnerProductVersionTableMap::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(WholesalePartnerProductVersionTableMap::ID, $id, $comparison);
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
     * @return ChildWholesalePartnerProductVersionQuery The current query, for fluid interface
     */
    public function filterByPartnerId($partnerId = null, $comparison = null)
    {
        if (is_array($partnerId)) {
            $useMinMax = false;
            if (isset($partnerId['min'])) {
                $this->addUsingAlias(WholesalePartnerProductVersionTableMap::PARTNER_ID, $partnerId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($partnerId['max'])) {
                $this->addUsingAlias(WholesalePartnerProductVersionTableMap::PARTNER_ID, $partnerId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(WholesalePartnerProductVersionTableMap::PARTNER_ID, $partnerId, $comparison);
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
     * @return ChildWholesalePartnerProductVersionQuery The current query, for fluid interface
     */
    public function filterByProductId($productId = null, $comparison = null)
    {
        if (is_array($productId)) {
            $useMinMax = false;
            if (isset($productId['min'])) {
                $this->addUsingAlias(WholesalePartnerProductVersionTableMap::PRODUCT_ID, $productId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($productId['max'])) {
                $this->addUsingAlias(WholesalePartnerProductVersionTableMap::PRODUCT_ID, $productId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(WholesalePartnerProductVersionTableMap::PRODUCT_ID, $productId, $comparison);
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
     * @return ChildWholesalePartnerProductVersionQuery The current query, for fluid interface
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

        return $this->addUsingAlias(WholesalePartnerProductVersionTableMap::PARTNER_PRODUCT_REF, $partnerProdRef, $comparison);
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
     * @return ChildWholesalePartnerProductVersionQuery The current query, for fluid interface
     */
    public function filterByPrice($price = null, $comparison = null)
    {
        if (is_array($price)) {
            $useMinMax = false;
            if (isset($price['min'])) {
                $this->addUsingAlias(WholesalePartnerProductVersionTableMap::PRICE, $price['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($price['max'])) {
                $this->addUsingAlias(WholesalePartnerProductVersionTableMap::PRICE, $price['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(WholesalePartnerProductVersionTableMap::PRICE, $price, $comparison);
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
     * @return ChildWholesalePartnerProductVersionQuery The current query, for fluid interface
     */
    public function filterByPackageSize($packageSize = null, $comparison = null)
    {
        if (is_array($packageSize)) {
            $useMinMax = false;
            if (isset($packageSize['min'])) {
                $this->addUsingAlias(WholesalePartnerProductVersionTableMap::PACKAGE_SIZE, $packageSize['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($packageSize['max'])) {
                $this->addUsingAlias(WholesalePartnerProductVersionTableMap::PACKAGE_SIZE, $packageSize['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(WholesalePartnerProductVersionTableMap::PACKAGE_SIZE, $packageSize, $comparison);
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
     * @return ChildWholesalePartnerProductVersionQuery The current query, for fluid interface
     */
    public function filterByDeliveryCost($deliveryCost = null, $comparison = null)
    {
        if (is_array($deliveryCost)) {
            $useMinMax = false;
            if (isset($deliveryCost['min'])) {
                $this->addUsingAlias(WholesalePartnerProductVersionTableMap::DELIVERY_COST, $deliveryCost['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($deliveryCost['max'])) {
                $this->addUsingAlias(WholesalePartnerProductVersionTableMap::DELIVERY_COST, $deliveryCost['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(WholesalePartnerProductVersionTableMap::DELIVERY_COST, $deliveryCost, $comparison);
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
     * @return ChildWholesalePartnerProductVersionQuery The current query, for fluid interface
     */
    public function filterByDiscount($discount = null, $comparison = null)
    {
        if (is_array($discount)) {
            $useMinMax = false;
            if (isset($discount['min'])) {
                $this->addUsingAlias(WholesalePartnerProductVersionTableMap::DISCOUNT, $discount['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($discount['max'])) {
                $this->addUsingAlias(WholesalePartnerProductVersionTableMap::DISCOUNT, $discount['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(WholesalePartnerProductVersionTableMap::DISCOUNT, $discount, $comparison);
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
     * @return ChildWholesalePartnerProductVersionQuery The current query, for fluid interface
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

        return $this->addUsingAlias(WholesalePartnerProductVersionTableMap::DISCOUNT_DESCRIPTION, $discountDescription, $comparison);
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
     * @return ChildWholesalePartnerProductVersionQuery The current query, for fluid interface
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

        return $this->addUsingAlias(WholesalePartnerProductVersionTableMap::PROFILE_WEBSITE, $profileWebsite, $comparison);
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
     * @return ChildWholesalePartnerProductVersionQuery The current query, for fluid interface
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

        return $this->addUsingAlias(WholesalePartnerProductVersionTableMap::POSITION, $position, $comparison);
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
     * @return ChildWholesalePartnerProductVersionQuery The current query, for fluid interface
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

        return $this->addUsingAlias(WholesalePartnerProductVersionTableMap::DEPARTMENT, $department, $comparison);
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
     * @return ChildWholesalePartnerProductVersionQuery The current query, for fluid interface
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

        return $this->addUsingAlias(WholesalePartnerProductVersionTableMap::COMMENT, $comment, $comparison);
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
     * @return ChildWholesalePartnerProductVersionQuery The current query, for fluid interface
     */
    public function filterByValidUntil($validUntil = null, $comparison = null)
    {
        if (is_array($validUntil)) {
            $useMinMax = false;
            if (isset($validUntil['min'])) {
                $this->addUsingAlias(WholesalePartnerProductVersionTableMap::VALID_UNTIL, $validUntil['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($validUntil['max'])) {
                $this->addUsingAlias(WholesalePartnerProductVersionTableMap::VALID_UNTIL, $validUntil['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(WholesalePartnerProductVersionTableMap::VALID_UNTIL, $validUntil, $comparison);
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
     * @return ChildWholesalePartnerProductVersionQuery The current query, for fluid interface
     */
    public function filterByVersion($version = null, $comparison = null)
    {
        if (is_array($version)) {
            $useMinMax = false;
            if (isset($version['min'])) {
                $this->addUsingAlias(WholesalePartnerProductVersionTableMap::VERSION, $version['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($version['max'])) {
                $this->addUsingAlias(WholesalePartnerProductVersionTableMap::VERSION, $version['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(WholesalePartnerProductVersionTableMap::VERSION, $version, $comparison);
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
     * @return ChildWholesalePartnerProductVersionQuery The current query, for fluid interface
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

        return $this->addUsingAlias(WholesalePartnerProductVersionTableMap::VERSION_CREATED_BY, $versionCreatedBy, $comparison);
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
     * @return ChildWholesalePartnerProductVersionQuery The current query, for fluid interface
     */
    public function filterByProductIdVersion($productIdVersion = null, $comparison = null)
    {
        if (is_array($productIdVersion)) {
            $useMinMax = false;
            if (isset($productIdVersion['min'])) {
                $this->addUsingAlias(WholesalePartnerProductVersionTableMap::PRODUCT_ID_VERSION, $productIdVersion['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($productIdVersion['max'])) {
                $this->addUsingAlias(WholesalePartnerProductVersionTableMap::PRODUCT_ID_VERSION, $productIdVersion['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(WholesalePartnerProductVersionTableMap::PRODUCT_ID_VERSION, $productIdVersion, $comparison);
    }

    /**
     * Filter the query by a related \RevenueDashboard\Model\WholesalePartnerProduct object
     *
     * @param \RevenueDashboard\Model\WholesalePartnerProduct|ObjectCollection $wholesalePartnerProduct The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildWholesalePartnerProductVersionQuery The current query, for fluid interface
     */
    public function filterByWholesalePartnerProduct($wholesalePartnerProduct, $comparison = null)
    {
        if ($wholesalePartnerProduct instanceof \RevenueDashboard\Model\WholesalePartnerProduct) {
            return $this
                ->addUsingAlias(WholesalePartnerProductVersionTableMap::ID, $wholesalePartnerProduct->getId(), $comparison);
        } elseif ($wholesalePartnerProduct instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(WholesalePartnerProductVersionTableMap::ID, $wholesalePartnerProduct->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByWholesalePartnerProduct() only accepts arguments of type \RevenueDashboard\Model\WholesalePartnerProduct or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the WholesalePartnerProduct relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildWholesalePartnerProductVersionQuery The current query, for fluid interface
     */
    public function joinWholesalePartnerProduct($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('WholesalePartnerProduct');

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
            $this->addJoinObject($join, 'WholesalePartnerProduct');
        }

        return $this;
    }

    /**
     * Use the WholesalePartnerProduct relation WholesalePartnerProduct object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \RevenueDashboard\Model\WholesalePartnerProductQuery A secondary query class using the current class as primary query
     */
    public function useWholesalePartnerProductQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinWholesalePartnerProduct($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'WholesalePartnerProduct', '\RevenueDashboard\Model\WholesalePartnerProductQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildWholesalePartnerProductVersion $wholesalePartnerProductVersion Object to remove from the list of results
     *
     * @return ChildWholesalePartnerProductVersionQuery The current query, for fluid interface
     */
    public function prune($wholesalePartnerProductVersion = null)
    {
        if ($wholesalePartnerProductVersion) {
            $this->addCond('pruneCond0', $this->getAliasedColName(WholesalePartnerProductVersionTableMap::ID), $wholesalePartnerProductVersion->getId(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(WholesalePartnerProductVersionTableMap::VERSION), $wholesalePartnerProductVersion->getVersion(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the wholesale_partner_product_version table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(WholesalePartnerProductVersionTableMap::DATABASE_NAME);
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
            WholesalePartnerProductVersionTableMap::clearInstancePool();
            WholesalePartnerProductVersionTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildWholesalePartnerProductVersion or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildWholesalePartnerProductVersion object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(WholesalePartnerProductVersionTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(WholesalePartnerProductVersionTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            

        WholesalePartnerProductVersionTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            WholesalePartnerProductVersionTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

} // WholesalePartnerProductVersionQuery
