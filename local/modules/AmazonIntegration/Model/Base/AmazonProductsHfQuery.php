<?php

namespace AmazonIntegration\Model\Base;

use \Exception;
use \PDO;
use AmazonIntegration\Model\AmazonProductsHf as ChildAmazonProductsHf;
use AmazonIntegration\Model\AmazonProductsHfQuery as ChildAmazonProductsHfQuery;
use AmazonIntegration\Model\Map\AmazonProductsHfTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'amazon_products_hf' table.
 *
 * 
 *
 * @method     ChildAmazonProductsHfQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildAmazonProductsHfQuery orderByProductId($order = Criteria::ASC) Order by the product_id column
 * @method     ChildAmazonProductsHfQuery orderByRef($order = Criteria::ASC) Order by the ref column
 * @method     ChildAmazonProductsHfQuery orderByEanCode($order = Criteria::ASC) Order by the ean_code column
 * @method     ChildAmazonProductsHfQuery orderByASIN($order = Criteria::ASC) Order by the ASIN column
 * @method     ChildAmazonProductsHfQuery orderBySKU($order = Criteria::ASC) Order by the SKU column
 * @method     ChildAmazonProductsHfQuery orderByPrice($order = Criteria::ASC) Order by the price column
 * @method     ChildAmazonProductsHfQuery orderByQuantity($order = Criteria::ASC) Order by the quantity column
 * @method     ChildAmazonProductsHfQuery orderByMarketplaceId($order = Criteria::ASC) Order by the marketplace_id column
 * @method     ChildAmazonProductsHfQuery orderByMarketplaceLocale($order = Criteria::ASC) Order by the marketplace_locale column
 * @method     ChildAmazonProductsHfQuery orderByCurrency($order = Criteria::ASC) Order by the currency column
 *
 * @method     ChildAmazonProductsHfQuery groupById() Group by the id column
 * @method     ChildAmazonProductsHfQuery groupByProductId() Group by the product_id column
 * @method     ChildAmazonProductsHfQuery groupByRef() Group by the ref column
 * @method     ChildAmazonProductsHfQuery groupByEanCode() Group by the ean_code column
 * @method     ChildAmazonProductsHfQuery groupByASIN() Group by the ASIN column
 * @method     ChildAmazonProductsHfQuery groupBySKU() Group by the SKU column
 * @method     ChildAmazonProductsHfQuery groupByPrice() Group by the price column
 * @method     ChildAmazonProductsHfQuery groupByQuantity() Group by the quantity column
 * @method     ChildAmazonProductsHfQuery groupByMarketplaceId() Group by the marketplace_id column
 * @method     ChildAmazonProductsHfQuery groupByMarketplaceLocale() Group by the marketplace_locale column
 * @method     ChildAmazonProductsHfQuery groupByCurrency() Group by the currency column
 *
 * @method     ChildAmazonProductsHfQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildAmazonProductsHfQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildAmazonProductsHfQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildAmazonProductsHf findOne(ConnectionInterface $con = null) Return the first ChildAmazonProductsHf matching the query
 * @method     ChildAmazonProductsHf findOneOrCreate(ConnectionInterface $con = null) Return the first ChildAmazonProductsHf matching the query, or a new ChildAmazonProductsHf object populated from the query conditions when no match is found
 *
 * @method     ChildAmazonProductsHf findOneById(int $id) Return the first ChildAmazonProductsHf filtered by the id column
 * @method     ChildAmazonProductsHf findOneByProductId(int $product_id) Return the first ChildAmazonProductsHf filtered by the product_id column
 * @method     ChildAmazonProductsHf findOneByRef(string $ref) Return the first ChildAmazonProductsHf filtered by the ref column
 * @method     ChildAmazonProductsHf findOneByEanCode(string $ean_code) Return the first ChildAmazonProductsHf filtered by the ean_code column
 * @method     ChildAmazonProductsHf findOneByASIN(string $ASIN) Return the first ChildAmazonProductsHf filtered by the ASIN column
 * @method     ChildAmazonProductsHf findOneBySKU(string $SKU) Return the first ChildAmazonProductsHf filtered by the SKU column
 * @method     ChildAmazonProductsHf findOneByPrice(string $price) Return the first ChildAmazonProductsHf filtered by the price column
 * @method     ChildAmazonProductsHf findOneByQuantity(int $quantity) Return the first ChildAmazonProductsHf filtered by the quantity column
 * @method     ChildAmazonProductsHf findOneByMarketplaceId(string $marketplace_id) Return the first ChildAmazonProductsHf filtered by the marketplace_id column
 * @method     ChildAmazonProductsHf findOneByMarketplaceLocale(string $marketplace_locale) Return the first ChildAmazonProductsHf filtered by the marketplace_locale column
 * @method     ChildAmazonProductsHf findOneByCurrency(string $currency) Return the first ChildAmazonProductsHf filtered by the currency column
 *
 * @method     array findById(int $id) Return ChildAmazonProductsHf objects filtered by the id column
 * @method     array findByProductId(int $product_id) Return ChildAmazonProductsHf objects filtered by the product_id column
 * @method     array findByRef(string $ref) Return ChildAmazonProductsHf objects filtered by the ref column
 * @method     array findByEanCode(string $ean_code) Return ChildAmazonProductsHf objects filtered by the ean_code column
 * @method     array findByASIN(string $ASIN) Return ChildAmazonProductsHf objects filtered by the ASIN column
 * @method     array findBySKU(string $SKU) Return ChildAmazonProductsHf objects filtered by the SKU column
 * @method     array findByPrice(string $price) Return ChildAmazonProductsHf objects filtered by the price column
 * @method     array findByQuantity(int $quantity) Return ChildAmazonProductsHf objects filtered by the quantity column
 * @method     array findByMarketplaceId(string $marketplace_id) Return ChildAmazonProductsHf objects filtered by the marketplace_id column
 * @method     array findByMarketplaceLocale(string $marketplace_locale) Return ChildAmazonProductsHf objects filtered by the marketplace_locale column
 * @method     array findByCurrency(string $currency) Return ChildAmazonProductsHf objects filtered by the currency column
 *
 */
abstract class AmazonProductsHfQuery extends ModelCriteria
{
    
    /**
     * Initializes internal state of \AmazonIntegration\Model\Base\AmazonProductsHfQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'thelia', $modelName = '\\AmazonIntegration\\Model\\AmazonProductsHf', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildAmazonProductsHfQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildAmazonProductsHfQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \AmazonIntegration\Model\AmazonProductsHfQuery) {
            return $criteria;
        }
        $query = new \AmazonIntegration\Model\AmazonProductsHfQuery();
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
     * @return ChildAmazonProductsHf|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = AmazonProductsHfTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(AmazonProductsHfTableMap::DATABASE_NAME);
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
     * @return   ChildAmazonProductsHf A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ID, PRODUCT_ID, REF, EAN_CODE, ASIN, SKU, PRICE, QUANTITY, MARKETPLACE_ID, MARKETPLACE_LOCALE, CURRENCY FROM amazon_products_hf WHERE ID = :p0';
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
            $obj = new ChildAmazonProductsHf();
            $obj->hydrate($row);
            AmazonProductsHfTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildAmazonProductsHf|array|mixed the result, formatted by the current formatter
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
     * @return ChildAmazonProductsHfQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(AmazonProductsHfTableMap::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildAmazonProductsHfQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(AmazonProductsHfTableMap::ID, $keys, Criteria::IN);
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
     * @return ChildAmazonProductsHfQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(AmazonProductsHfTableMap::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(AmazonProductsHfTableMap::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AmazonProductsHfTableMap::ID, $id, $comparison);
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
     * @return ChildAmazonProductsHfQuery The current query, for fluid interface
     */
    public function filterByProductId($productId = null, $comparison = null)
    {
        if (is_array($productId)) {
            $useMinMax = false;
            if (isset($productId['min'])) {
                $this->addUsingAlias(AmazonProductsHfTableMap::PRODUCT_ID, $productId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($productId['max'])) {
                $this->addUsingAlias(AmazonProductsHfTableMap::PRODUCT_ID, $productId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AmazonProductsHfTableMap::PRODUCT_ID, $productId, $comparison);
    }

    /**
     * Filter the query on the ref column
     *
     * Example usage:
     * <code>
     * $query->filterByRef('fooValue');   // WHERE ref = 'fooValue'
     * $query->filterByRef('%fooValue%'); // WHERE ref LIKE '%fooValue%'
     * </code>
     *
     * @param     string $ref The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonProductsHfQuery The current query, for fluid interface
     */
    public function filterByRef($ref = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($ref)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $ref)) {
                $ref = str_replace('*', '%', $ref);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AmazonProductsHfTableMap::REF, $ref, $comparison);
    }

    /**
     * Filter the query on the ean_code column
     *
     * Example usage:
     * <code>
     * $query->filterByEanCode('fooValue');   // WHERE ean_code = 'fooValue'
     * $query->filterByEanCode('%fooValue%'); // WHERE ean_code LIKE '%fooValue%'
     * </code>
     *
     * @param     string $eanCode The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonProductsHfQuery The current query, for fluid interface
     */
    public function filterByEanCode($eanCode = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($eanCode)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $eanCode)) {
                $eanCode = str_replace('*', '%', $eanCode);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AmazonProductsHfTableMap::EAN_CODE, $eanCode, $comparison);
    }

    /**
     * Filter the query on the ASIN column
     *
     * Example usage:
     * <code>
     * $query->filterByASIN('fooValue');   // WHERE ASIN = 'fooValue'
     * $query->filterByASIN('%fooValue%'); // WHERE ASIN LIKE '%fooValue%'
     * </code>
     *
     * @param     string $aSIN The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonProductsHfQuery The current query, for fluid interface
     */
    public function filterByASIN($aSIN = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($aSIN)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $aSIN)) {
                $aSIN = str_replace('*', '%', $aSIN);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AmazonProductsHfTableMap::ASIN, $aSIN, $comparison);
    }

    /**
     * Filter the query on the SKU column
     *
     * Example usage:
     * <code>
     * $query->filterBySKU('fooValue');   // WHERE SKU = 'fooValue'
     * $query->filterBySKU('%fooValue%'); // WHERE SKU LIKE '%fooValue%'
     * </code>
     *
     * @param     string $sKU The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonProductsHfQuery The current query, for fluid interface
     */
    public function filterBySKU($sKU = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($sKU)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $sKU)) {
                $sKU = str_replace('*', '%', $sKU);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AmazonProductsHfTableMap::SKU, $sKU, $comparison);
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
     * @return ChildAmazonProductsHfQuery The current query, for fluid interface
     */
    public function filterByPrice($price = null, $comparison = null)
    {
        if (is_array($price)) {
            $useMinMax = false;
            if (isset($price['min'])) {
                $this->addUsingAlias(AmazonProductsHfTableMap::PRICE, $price['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($price['max'])) {
                $this->addUsingAlias(AmazonProductsHfTableMap::PRICE, $price['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AmazonProductsHfTableMap::PRICE, $price, $comparison);
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
     * @return ChildAmazonProductsHfQuery The current query, for fluid interface
     */
    public function filterByQuantity($quantity = null, $comparison = null)
    {
        if (is_array($quantity)) {
            $useMinMax = false;
            if (isset($quantity['min'])) {
                $this->addUsingAlias(AmazonProductsHfTableMap::QUANTITY, $quantity['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($quantity['max'])) {
                $this->addUsingAlias(AmazonProductsHfTableMap::QUANTITY, $quantity['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AmazonProductsHfTableMap::QUANTITY, $quantity, $comparison);
    }

    /**
     * Filter the query on the marketplace_id column
     *
     * Example usage:
     * <code>
     * $query->filterByMarketplaceId('fooValue');   // WHERE marketplace_id = 'fooValue'
     * $query->filterByMarketplaceId('%fooValue%'); // WHERE marketplace_id LIKE '%fooValue%'
     * </code>
     *
     * @param     string $marketplaceId The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonProductsHfQuery The current query, for fluid interface
     */
    public function filterByMarketplaceId($marketplaceId = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($marketplaceId)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $marketplaceId)) {
                $marketplaceId = str_replace('*', '%', $marketplaceId);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AmazonProductsHfTableMap::MARKETPLACE_ID, $marketplaceId, $comparison);
    }

    /**
     * Filter the query on the marketplace_locale column
     *
     * Example usage:
     * <code>
     * $query->filterByMarketplaceLocale('fooValue');   // WHERE marketplace_locale = 'fooValue'
     * $query->filterByMarketplaceLocale('%fooValue%'); // WHERE marketplace_locale LIKE '%fooValue%'
     * </code>
     *
     * @param     string $marketplaceLocale The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonProductsHfQuery The current query, for fluid interface
     */
    public function filterByMarketplaceLocale($marketplaceLocale = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($marketplaceLocale)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $marketplaceLocale)) {
                $marketplaceLocale = str_replace('*', '%', $marketplaceLocale);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AmazonProductsHfTableMap::MARKETPLACE_LOCALE, $marketplaceLocale, $comparison);
    }

    /**
     * Filter the query on the currency column
     *
     * Example usage:
     * <code>
     * $query->filterByCurrency('fooValue');   // WHERE currency = 'fooValue'
     * $query->filterByCurrency('%fooValue%'); // WHERE currency LIKE '%fooValue%'
     * </code>
     *
     * @param     string $currency The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonProductsHfQuery The current query, for fluid interface
     */
    public function filterByCurrency($currency = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($currency)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $currency)) {
                $currency = str_replace('*', '%', $currency);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AmazonProductsHfTableMap::CURRENCY, $currency, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildAmazonProductsHf $amazonProductsHf Object to remove from the list of results
     *
     * @return ChildAmazonProductsHfQuery The current query, for fluid interface
     */
    public function prune($amazonProductsHf = null)
    {
        if ($amazonProductsHf) {
            $this->addUsingAlias(AmazonProductsHfTableMap::ID, $amazonProductsHf->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the amazon_products_hf table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(AmazonProductsHfTableMap::DATABASE_NAME);
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
            AmazonProductsHfTableMap::clearInstancePool();
            AmazonProductsHfTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildAmazonProductsHf or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildAmazonProductsHf object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(AmazonProductsHfTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(AmazonProductsHfTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            

        AmazonProductsHfTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            AmazonProductsHfTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

} // AmazonProductsHfQuery
