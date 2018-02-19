<?php

namespace OfferCreation\Model\Base;

use \Exception;
use \PDO;
use OfferCreation\Model\OfferProduct as ChildOfferProduct;
use OfferCreation\Model\OfferProductQuery as ChildOfferProductQuery;
use OfferCreation\Model\Map\OfferProductTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'offer_product' table.
 *
 * 
 *
 * @method     ChildOfferProductQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildOfferProductQuery orderByOfferId($order = Criteria::ASC) Order by the offer_id column
 * @method     ChildOfferProductQuery orderByProductRef($order = Criteria::ASC) Order by the product_ref column
 * @method     ChildOfferProductQuery orderByProductSaleElementsRef($order = Criteria::ASC) Order by the product_sale_elements_ref column
 * @method     ChildOfferProductQuery orderByProductSaleElementsId($order = Criteria::ASC) Order by the product_sale_elements_id column
 * @method     ChildOfferProductQuery orderByTitle($order = Criteria::ASC) Order by the title column
 * @method     ChildOfferProductQuery orderByChapo($order = Criteria::ASC) Order by the chapo column
 * @method     ChildOfferProductQuery orderByDescription($order = Criteria::ASC) Order by the description column
 * @method     ChildOfferProductQuery orderByPostscriptum($order = Criteria::ASC) Order by the postscriptum column
 * @method     ChildOfferProductQuery orderByQuantity($order = Criteria::ASC) Order by the quantity column
 * @method     ChildOfferProductQuery orderByPrice($order = Criteria::ASC) Order by the price column
 * @method     ChildOfferProductQuery orderByPromoPrice($order = Criteria::ASC) Order by the promo_price column
 * @method     ChildOfferProductQuery orderByWasNew($order = Criteria::ASC) Order by the was_new column
 * @method     ChildOfferProductQuery orderByWasInPromo($order = Criteria::ASC) Order by the was_in_promo column
 * @method     ChildOfferProductQuery orderByWeight($order = Criteria::ASC) Order by the weight column
 * @method     ChildOfferProductQuery orderByEanCode($order = Criteria::ASC) Order by the ean_code column
 * @method     ChildOfferProductQuery orderByTaxRuleTitle($order = Criteria::ASC) Order by the tax_rule_title column
 * @method     ChildOfferProductQuery orderByTaxRuleDescription($order = Criteria::ASC) Order by the tax_rule_description column
 * @method     ChildOfferProductQuery orderByParent($order = Criteria::ASC) Order by the parent column
 * @method     ChildOfferProductQuery orderByVirtual($order = Criteria::ASC) Order by the virtual column
 * @method     ChildOfferProductQuery orderByVirtualDocument($order = Criteria::ASC) Order by the virtual_document column
 * @method     ChildOfferProductQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildOfferProductQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method     ChildOfferProductQuery groupById() Group by the id column
 * @method     ChildOfferProductQuery groupByOfferId() Group by the offer_id column
 * @method     ChildOfferProductQuery groupByProductRef() Group by the product_ref column
 * @method     ChildOfferProductQuery groupByProductSaleElementsRef() Group by the product_sale_elements_ref column
 * @method     ChildOfferProductQuery groupByProductSaleElementsId() Group by the product_sale_elements_id column
 * @method     ChildOfferProductQuery groupByTitle() Group by the title column
 * @method     ChildOfferProductQuery groupByChapo() Group by the chapo column
 * @method     ChildOfferProductQuery groupByDescription() Group by the description column
 * @method     ChildOfferProductQuery groupByPostscriptum() Group by the postscriptum column
 * @method     ChildOfferProductQuery groupByQuantity() Group by the quantity column
 * @method     ChildOfferProductQuery groupByPrice() Group by the price column
 * @method     ChildOfferProductQuery groupByPromoPrice() Group by the promo_price column
 * @method     ChildOfferProductQuery groupByWasNew() Group by the was_new column
 * @method     ChildOfferProductQuery groupByWasInPromo() Group by the was_in_promo column
 * @method     ChildOfferProductQuery groupByWeight() Group by the weight column
 * @method     ChildOfferProductQuery groupByEanCode() Group by the ean_code column
 * @method     ChildOfferProductQuery groupByTaxRuleTitle() Group by the tax_rule_title column
 * @method     ChildOfferProductQuery groupByTaxRuleDescription() Group by the tax_rule_description column
 * @method     ChildOfferProductQuery groupByParent() Group by the parent column
 * @method     ChildOfferProductQuery groupByVirtual() Group by the virtual column
 * @method     ChildOfferProductQuery groupByVirtualDocument() Group by the virtual_document column
 * @method     ChildOfferProductQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildOfferProductQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method     ChildOfferProductQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildOfferProductQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildOfferProductQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildOfferProductQuery leftJoinOffer($relationAlias = null) Adds a LEFT JOIN clause to the query using the Offer relation
 * @method     ChildOfferProductQuery rightJoinOffer($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Offer relation
 * @method     ChildOfferProductQuery innerJoinOffer($relationAlias = null) Adds a INNER JOIN clause to the query using the Offer relation
 *
 * @method     ChildOfferProductQuery leftJoinOfferProductTax($relationAlias = null) Adds a LEFT JOIN clause to the query using the OfferProductTax relation
 * @method     ChildOfferProductQuery rightJoinOfferProductTax($relationAlias = null) Adds a RIGHT JOIN clause to the query using the OfferProductTax relation
 * @method     ChildOfferProductQuery innerJoinOfferProductTax($relationAlias = null) Adds a INNER JOIN clause to the query using the OfferProductTax relation
 *
 * @method     ChildOfferProduct findOne(ConnectionInterface $con = null) Return the first ChildOfferProduct matching the query
 * @method     ChildOfferProduct findOneOrCreate(ConnectionInterface $con = null) Return the first ChildOfferProduct matching the query, or a new ChildOfferProduct object populated from the query conditions when no match is found
 *
 * @method     ChildOfferProduct findOneById(int $id) Return the first ChildOfferProduct filtered by the id column
 * @method     ChildOfferProduct findOneByOfferId(int $offer_id) Return the first ChildOfferProduct filtered by the offer_id column
 * @method     ChildOfferProduct findOneByProductRef(string $product_ref) Return the first ChildOfferProduct filtered by the product_ref column
 * @method     ChildOfferProduct findOneByProductSaleElementsRef(string $product_sale_elements_ref) Return the first ChildOfferProduct filtered by the product_sale_elements_ref column
 * @method     ChildOfferProduct findOneByProductSaleElementsId(int $product_sale_elements_id) Return the first ChildOfferProduct filtered by the product_sale_elements_id column
 * @method     ChildOfferProduct findOneByTitle(string $title) Return the first ChildOfferProduct filtered by the title column
 * @method     ChildOfferProduct findOneByChapo(string $chapo) Return the first ChildOfferProduct filtered by the chapo column
 * @method     ChildOfferProduct findOneByDescription(string $description) Return the first ChildOfferProduct filtered by the description column
 * @method     ChildOfferProduct findOneByPostscriptum(string $postscriptum) Return the first ChildOfferProduct filtered by the postscriptum column
 * @method     ChildOfferProduct findOneByQuantity(double $quantity) Return the first ChildOfferProduct filtered by the quantity column
 * @method     ChildOfferProduct findOneByPrice(string $price) Return the first ChildOfferProduct filtered by the price column
 * @method     ChildOfferProduct findOneByPromoPrice(string $promo_price) Return the first ChildOfferProduct filtered by the promo_price column
 * @method     ChildOfferProduct findOneByWasNew(int $was_new) Return the first ChildOfferProduct filtered by the was_new column
 * @method     ChildOfferProduct findOneByWasInPromo(int $was_in_promo) Return the first ChildOfferProduct filtered by the was_in_promo column
 * @method     ChildOfferProduct findOneByWeight(string $weight) Return the first ChildOfferProduct filtered by the weight column
 * @method     ChildOfferProduct findOneByEanCode(string $ean_code) Return the first ChildOfferProduct filtered by the ean_code column
 * @method     ChildOfferProduct findOneByTaxRuleTitle(string $tax_rule_title) Return the first ChildOfferProduct filtered by the tax_rule_title column
 * @method     ChildOfferProduct findOneByTaxRuleDescription(string $tax_rule_description) Return the first ChildOfferProduct filtered by the tax_rule_description column
 * @method     ChildOfferProduct findOneByParent(int $parent) Return the first ChildOfferProduct filtered by the parent column
 * @method     ChildOfferProduct findOneByVirtual(int $virtual) Return the first ChildOfferProduct filtered by the virtual column
 * @method     ChildOfferProduct findOneByVirtualDocument(string $virtual_document) Return the first ChildOfferProduct filtered by the virtual_document column
 * @method     ChildOfferProduct findOneByCreatedAt(string $created_at) Return the first ChildOfferProduct filtered by the created_at column
 * @method     ChildOfferProduct findOneByUpdatedAt(string $updated_at) Return the first ChildOfferProduct filtered by the updated_at column
 *
 * @method     array findById(int $id) Return ChildOfferProduct objects filtered by the id column
 * @method     array findByOfferId(int $offer_id) Return ChildOfferProduct objects filtered by the offer_id column
 * @method     array findByProductRef(string $product_ref) Return ChildOfferProduct objects filtered by the product_ref column
 * @method     array findByProductSaleElementsRef(string $product_sale_elements_ref) Return ChildOfferProduct objects filtered by the product_sale_elements_ref column
 * @method     array findByProductSaleElementsId(int $product_sale_elements_id) Return ChildOfferProduct objects filtered by the product_sale_elements_id column
 * @method     array findByTitle(string $title) Return ChildOfferProduct objects filtered by the title column
 * @method     array findByChapo(string $chapo) Return ChildOfferProduct objects filtered by the chapo column
 * @method     array findByDescription(string $description) Return ChildOfferProduct objects filtered by the description column
 * @method     array findByPostscriptum(string $postscriptum) Return ChildOfferProduct objects filtered by the postscriptum column
 * @method     array findByQuantity(double $quantity) Return ChildOfferProduct objects filtered by the quantity column
 * @method     array findByPrice(string $price) Return ChildOfferProduct objects filtered by the price column
 * @method     array findByPromoPrice(string $promo_price) Return ChildOfferProduct objects filtered by the promo_price column
 * @method     array findByWasNew(int $was_new) Return ChildOfferProduct objects filtered by the was_new column
 * @method     array findByWasInPromo(int $was_in_promo) Return ChildOfferProduct objects filtered by the was_in_promo column
 * @method     array findByWeight(string $weight) Return ChildOfferProduct objects filtered by the weight column
 * @method     array findByEanCode(string $ean_code) Return ChildOfferProduct objects filtered by the ean_code column
 * @method     array findByTaxRuleTitle(string $tax_rule_title) Return ChildOfferProduct objects filtered by the tax_rule_title column
 * @method     array findByTaxRuleDescription(string $tax_rule_description) Return ChildOfferProduct objects filtered by the tax_rule_description column
 * @method     array findByParent(int $parent) Return ChildOfferProduct objects filtered by the parent column
 * @method     array findByVirtual(int $virtual) Return ChildOfferProduct objects filtered by the virtual column
 * @method     array findByVirtualDocument(string $virtual_document) Return ChildOfferProduct objects filtered by the virtual_document column
 * @method     array findByCreatedAt(string $created_at) Return ChildOfferProduct objects filtered by the created_at column
 * @method     array findByUpdatedAt(string $updated_at) Return ChildOfferProduct objects filtered by the updated_at column
 *
 */
abstract class OfferProductQuery extends ModelCriteria
{
    
    /**
     * Initializes internal state of \OfferCreation\Model\Base\OfferProductQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'thelia', $modelName = '\\OfferCreation\\Model\\OfferProduct', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildOfferProductQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildOfferProductQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \OfferCreation\Model\OfferProductQuery) {
            return $criteria;
        }
        $query = new \OfferCreation\Model\OfferProductQuery();
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
     * @return ChildOfferProduct|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = OfferProductTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(OfferProductTableMap::DATABASE_NAME);
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
     * @return   ChildOfferProduct A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ID, OFFER_ID, PRODUCT_REF, PRODUCT_SALE_ELEMENTS_REF, PRODUCT_SALE_ELEMENTS_ID, TITLE, CHAPO, DESCRIPTION, POSTSCRIPTUM, QUANTITY, PRICE, PROMO_PRICE, WAS_NEW, WAS_IN_PROMO, WEIGHT, EAN_CODE, TAX_RULE_TITLE, TAX_RULE_DESCRIPTION, PARENT, VIRTUAL, VIRTUAL_DOCUMENT, CREATED_AT, UPDATED_AT FROM offer_product WHERE ID = :p0';
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
            $obj = new ChildOfferProduct();
            $obj->hydrate($row);
            OfferProductTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildOfferProduct|array|mixed the result, formatted by the current formatter
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
     * @return ChildOfferProductQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(OfferProductTableMap::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildOfferProductQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(OfferProductTableMap::ID, $keys, Criteria::IN);
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
     * @return ChildOfferProductQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(OfferProductTableMap::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(OfferProductTableMap::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OfferProductTableMap::ID, $id, $comparison);
    }

    /**
     * Filter the query on the offer_id column
     *
     * Example usage:
     * <code>
     * $query->filterByOfferId(1234); // WHERE offer_id = 1234
     * $query->filterByOfferId(array(12, 34)); // WHERE offer_id IN (12, 34)
     * $query->filterByOfferId(array('min' => 12)); // WHERE offer_id > 12
     * </code>
     *
     * @see       filterByOffer()
     *
     * @param     mixed $offerId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildOfferProductQuery The current query, for fluid interface
     */
    public function filterByOfferId($offerId = null, $comparison = null)
    {
        if (is_array($offerId)) {
            $useMinMax = false;
            if (isset($offerId['min'])) {
                $this->addUsingAlias(OfferProductTableMap::OFFER_ID, $offerId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($offerId['max'])) {
                $this->addUsingAlias(OfferProductTableMap::OFFER_ID, $offerId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OfferProductTableMap::OFFER_ID, $offerId, $comparison);
    }

    /**
     * Filter the query on the product_ref column
     *
     * Example usage:
     * <code>
     * $query->filterByProductRef('fooValue');   // WHERE product_ref = 'fooValue'
     * $query->filterByProductRef('%fooValue%'); // WHERE product_ref LIKE '%fooValue%'
     * </code>
     *
     * @param     string $productRef The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildOfferProductQuery The current query, for fluid interface
     */
    public function filterByProductRef($productRef = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($productRef)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $productRef)) {
                $productRef = str_replace('*', '%', $productRef);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(OfferProductTableMap::PRODUCT_REF, $productRef, $comparison);
    }

    /**
     * Filter the query on the product_sale_elements_ref column
     *
     * Example usage:
     * <code>
     * $query->filterByProductSaleElementsRef('fooValue');   // WHERE product_sale_elements_ref = 'fooValue'
     * $query->filterByProductSaleElementsRef('%fooValue%'); // WHERE product_sale_elements_ref LIKE '%fooValue%'
     * </code>
     *
     * @param     string $productSaleElementsRef The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildOfferProductQuery The current query, for fluid interface
     */
    public function filterByProductSaleElementsRef($productSaleElementsRef = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($productSaleElementsRef)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $productSaleElementsRef)) {
                $productSaleElementsRef = str_replace('*', '%', $productSaleElementsRef);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(OfferProductTableMap::PRODUCT_SALE_ELEMENTS_REF, $productSaleElementsRef, $comparison);
    }

    /**
     * Filter the query on the product_sale_elements_id column
     *
     * Example usage:
     * <code>
     * $query->filterByProductSaleElementsId(1234); // WHERE product_sale_elements_id = 1234
     * $query->filterByProductSaleElementsId(array(12, 34)); // WHERE product_sale_elements_id IN (12, 34)
     * $query->filterByProductSaleElementsId(array('min' => 12)); // WHERE product_sale_elements_id > 12
     * </code>
     *
     * @param     mixed $productSaleElementsId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildOfferProductQuery The current query, for fluid interface
     */
    public function filterByProductSaleElementsId($productSaleElementsId = null, $comparison = null)
    {
        if (is_array($productSaleElementsId)) {
            $useMinMax = false;
            if (isset($productSaleElementsId['min'])) {
                $this->addUsingAlias(OfferProductTableMap::PRODUCT_SALE_ELEMENTS_ID, $productSaleElementsId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($productSaleElementsId['max'])) {
                $this->addUsingAlias(OfferProductTableMap::PRODUCT_SALE_ELEMENTS_ID, $productSaleElementsId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OfferProductTableMap::PRODUCT_SALE_ELEMENTS_ID, $productSaleElementsId, $comparison);
    }

    /**
     * Filter the query on the title column
     *
     * Example usage:
     * <code>
     * $query->filterByTitle('fooValue');   // WHERE title = 'fooValue'
     * $query->filterByTitle('%fooValue%'); // WHERE title LIKE '%fooValue%'
     * </code>
     *
     * @param     string $title The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildOfferProductQuery The current query, for fluid interface
     */
    public function filterByTitle($title = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($title)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $title)) {
                $title = str_replace('*', '%', $title);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(OfferProductTableMap::TITLE, $title, $comparison);
    }

    /**
     * Filter the query on the chapo column
     *
     * Example usage:
     * <code>
     * $query->filterByChapo('fooValue');   // WHERE chapo = 'fooValue'
     * $query->filterByChapo('%fooValue%'); // WHERE chapo LIKE '%fooValue%'
     * </code>
     *
     * @param     string $chapo The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildOfferProductQuery The current query, for fluid interface
     */
    public function filterByChapo($chapo = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($chapo)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $chapo)) {
                $chapo = str_replace('*', '%', $chapo);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(OfferProductTableMap::CHAPO, $chapo, $comparison);
    }

    /**
     * Filter the query on the description column
     *
     * Example usage:
     * <code>
     * $query->filterByDescription('fooValue');   // WHERE description = 'fooValue'
     * $query->filterByDescription('%fooValue%'); // WHERE description LIKE '%fooValue%'
     * </code>
     *
     * @param     string $description The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildOfferProductQuery The current query, for fluid interface
     */
    public function filterByDescription($description = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($description)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $description)) {
                $description = str_replace('*', '%', $description);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(OfferProductTableMap::DESCRIPTION, $description, $comparison);
    }

    /**
     * Filter the query on the postscriptum column
     *
     * Example usage:
     * <code>
     * $query->filterByPostscriptum('fooValue');   // WHERE postscriptum = 'fooValue'
     * $query->filterByPostscriptum('%fooValue%'); // WHERE postscriptum LIKE '%fooValue%'
     * </code>
     *
     * @param     string $postscriptum The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildOfferProductQuery The current query, for fluid interface
     */
    public function filterByPostscriptum($postscriptum = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($postscriptum)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $postscriptum)) {
                $postscriptum = str_replace('*', '%', $postscriptum);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(OfferProductTableMap::POSTSCRIPTUM, $postscriptum, $comparison);
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
     * @return ChildOfferProductQuery The current query, for fluid interface
     */
    public function filterByQuantity($quantity = null, $comparison = null)
    {
        if (is_array($quantity)) {
            $useMinMax = false;
            if (isset($quantity['min'])) {
                $this->addUsingAlias(OfferProductTableMap::QUANTITY, $quantity['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($quantity['max'])) {
                $this->addUsingAlias(OfferProductTableMap::QUANTITY, $quantity['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OfferProductTableMap::QUANTITY, $quantity, $comparison);
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
     * @return ChildOfferProductQuery The current query, for fluid interface
     */
    public function filterByPrice($price = null, $comparison = null)
    {
        if (is_array($price)) {
            $useMinMax = false;
            if (isset($price['min'])) {
                $this->addUsingAlias(OfferProductTableMap::PRICE, $price['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($price['max'])) {
                $this->addUsingAlias(OfferProductTableMap::PRICE, $price['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OfferProductTableMap::PRICE, $price, $comparison);
    }

    /**
     * Filter the query on the promo_price column
     *
     * Example usage:
     * <code>
     * $query->filterByPromoPrice(1234); // WHERE promo_price = 1234
     * $query->filterByPromoPrice(array(12, 34)); // WHERE promo_price IN (12, 34)
     * $query->filterByPromoPrice(array('min' => 12)); // WHERE promo_price > 12
     * </code>
     *
     * @param     mixed $promoPrice The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildOfferProductQuery The current query, for fluid interface
     */
    public function filterByPromoPrice($promoPrice = null, $comparison = null)
    {
        if (is_array($promoPrice)) {
            $useMinMax = false;
            if (isset($promoPrice['min'])) {
                $this->addUsingAlias(OfferProductTableMap::PROMO_PRICE, $promoPrice['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($promoPrice['max'])) {
                $this->addUsingAlias(OfferProductTableMap::PROMO_PRICE, $promoPrice['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OfferProductTableMap::PROMO_PRICE, $promoPrice, $comparison);
    }

    /**
     * Filter the query on the was_new column
     *
     * Example usage:
     * <code>
     * $query->filterByWasNew(1234); // WHERE was_new = 1234
     * $query->filterByWasNew(array(12, 34)); // WHERE was_new IN (12, 34)
     * $query->filterByWasNew(array('min' => 12)); // WHERE was_new > 12
     * </code>
     *
     * @param     mixed $wasNew The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildOfferProductQuery The current query, for fluid interface
     */
    public function filterByWasNew($wasNew = null, $comparison = null)
    {
        if (is_array($wasNew)) {
            $useMinMax = false;
            if (isset($wasNew['min'])) {
                $this->addUsingAlias(OfferProductTableMap::WAS_NEW, $wasNew['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($wasNew['max'])) {
                $this->addUsingAlias(OfferProductTableMap::WAS_NEW, $wasNew['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OfferProductTableMap::WAS_NEW, $wasNew, $comparison);
    }

    /**
     * Filter the query on the was_in_promo column
     *
     * Example usage:
     * <code>
     * $query->filterByWasInPromo(1234); // WHERE was_in_promo = 1234
     * $query->filterByWasInPromo(array(12, 34)); // WHERE was_in_promo IN (12, 34)
     * $query->filterByWasInPromo(array('min' => 12)); // WHERE was_in_promo > 12
     * </code>
     *
     * @param     mixed $wasInPromo The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildOfferProductQuery The current query, for fluid interface
     */
    public function filterByWasInPromo($wasInPromo = null, $comparison = null)
    {
        if (is_array($wasInPromo)) {
            $useMinMax = false;
            if (isset($wasInPromo['min'])) {
                $this->addUsingAlias(OfferProductTableMap::WAS_IN_PROMO, $wasInPromo['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($wasInPromo['max'])) {
                $this->addUsingAlias(OfferProductTableMap::WAS_IN_PROMO, $wasInPromo['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OfferProductTableMap::WAS_IN_PROMO, $wasInPromo, $comparison);
    }

    /**
     * Filter the query on the weight column
     *
     * Example usage:
     * <code>
     * $query->filterByWeight('fooValue');   // WHERE weight = 'fooValue'
     * $query->filterByWeight('%fooValue%'); // WHERE weight LIKE '%fooValue%'
     * </code>
     *
     * @param     string $weight The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildOfferProductQuery The current query, for fluid interface
     */
    public function filterByWeight($weight = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($weight)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $weight)) {
                $weight = str_replace('*', '%', $weight);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(OfferProductTableMap::WEIGHT, $weight, $comparison);
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
     * @return ChildOfferProductQuery The current query, for fluid interface
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

        return $this->addUsingAlias(OfferProductTableMap::EAN_CODE, $eanCode, $comparison);
    }

    /**
     * Filter the query on the tax_rule_title column
     *
     * Example usage:
     * <code>
     * $query->filterByTaxRuleTitle('fooValue');   // WHERE tax_rule_title = 'fooValue'
     * $query->filterByTaxRuleTitle('%fooValue%'); // WHERE tax_rule_title LIKE '%fooValue%'
     * </code>
     *
     * @param     string $taxRuleTitle The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildOfferProductQuery The current query, for fluid interface
     */
    public function filterByTaxRuleTitle($taxRuleTitle = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($taxRuleTitle)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $taxRuleTitle)) {
                $taxRuleTitle = str_replace('*', '%', $taxRuleTitle);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(OfferProductTableMap::TAX_RULE_TITLE, $taxRuleTitle, $comparison);
    }

    /**
     * Filter the query on the tax_rule_description column
     *
     * Example usage:
     * <code>
     * $query->filterByTaxRuleDescription('fooValue');   // WHERE tax_rule_description = 'fooValue'
     * $query->filterByTaxRuleDescription('%fooValue%'); // WHERE tax_rule_description LIKE '%fooValue%'
     * </code>
     *
     * @param     string $taxRuleDescription The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildOfferProductQuery The current query, for fluid interface
     */
    public function filterByTaxRuleDescription($taxRuleDescription = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($taxRuleDescription)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $taxRuleDescription)) {
                $taxRuleDescription = str_replace('*', '%', $taxRuleDescription);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(OfferProductTableMap::TAX_RULE_DESCRIPTION, $taxRuleDescription, $comparison);
    }

    /**
     * Filter the query on the parent column
     *
     * Example usage:
     * <code>
     * $query->filterByParent(1234); // WHERE parent = 1234
     * $query->filterByParent(array(12, 34)); // WHERE parent IN (12, 34)
     * $query->filterByParent(array('min' => 12)); // WHERE parent > 12
     * </code>
     *
     * @param     mixed $parent The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildOfferProductQuery The current query, for fluid interface
     */
    public function filterByParent($parent = null, $comparison = null)
    {
        if (is_array($parent)) {
            $useMinMax = false;
            if (isset($parent['min'])) {
                $this->addUsingAlias(OfferProductTableMap::PARENT, $parent['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($parent['max'])) {
                $this->addUsingAlias(OfferProductTableMap::PARENT, $parent['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OfferProductTableMap::PARENT, $parent, $comparison);
    }

    /**
     * Filter the query on the virtual column
     *
     * Example usage:
     * <code>
     * $query->filterByVirtual(1234); // WHERE virtual = 1234
     * $query->filterByVirtual(array(12, 34)); // WHERE virtual IN (12, 34)
     * $query->filterByVirtual(array('min' => 12)); // WHERE virtual > 12
     * </code>
     *
     * @param     mixed $virtual The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildOfferProductQuery The current query, for fluid interface
     */
    public function filterByVirtual($virtual = null, $comparison = null)
    {
        if (is_array($virtual)) {
            $useMinMax = false;
            if (isset($virtual['min'])) {
                $this->addUsingAlias(OfferProductTableMap::VIRTUAL, $virtual['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($virtual['max'])) {
                $this->addUsingAlias(OfferProductTableMap::VIRTUAL, $virtual['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OfferProductTableMap::VIRTUAL, $virtual, $comparison);
    }

    /**
     * Filter the query on the virtual_document column
     *
     * Example usage:
     * <code>
     * $query->filterByVirtualDocument('fooValue');   // WHERE virtual_document = 'fooValue'
     * $query->filterByVirtualDocument('%fooValue%'); // WHERE virtual_document LIKE '%fooValue%'
     * </code>
     *
     * @param     string $virtualDocument The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildOfferProductQuery The current query, for fluid interface
     */
    public function filterByVirtualDocument($virtualDocument = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($virtualDocument)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $virtualDocument)) {
                $virtualDocument = str_replace('*', '%', $virtualDocument);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(OfferProductTableMap::VIRTUAL_DOCUMENT, $virtualDocument, $comparison);
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
     * @return ChildOfferProductQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(OfferProductTableMap::CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(OfferProductTableMap::CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OfferProductTableMap::CREATED_AT, $createdAt, $comparison);
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
     * @return ChildOfferProductQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(OfferProductTableMap::UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(OfferProductTableMap::UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OfferProductTableMap::UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Filter the query by a related \OfferCreation\Model\Offer object
     *
     * @param \OfferCreation\Model\Offer|ObjectCollection $offer The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildOfferProductQuery The current query, for fluid interface
     */
    public function filterByOffer($offer, $comparison = null)
    {
        if ($offer instanceof \OfferCreation\Model\Offer) {
            return $this
                ->addUsingAlias(OfferProductTableMap::OFFER_ID, $offer->getId(), $comparison);
        } elseif ($offer instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(OfferProductTableMap::OFFER_ID, $offer->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByOffer() only accepts arguments of type \OfferCreation\Model\Offer or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Offer relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildOfferProductQuery The current query, for fluid interface
     */
    public function joinOffer($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Offer');

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
            $this->addJoinObject($join, 'Offer');
        }

        return $this;
    }

    /**
     * Use the Offer relation Offer object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \OfferCreation\Model\OfferQuery A secondary query class using the current class as primary query
     */
    public function useOfferQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinOffer($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Offer', '\OfferCreation\Model\OfferQuery');
    }

    /**
     * Filter the query by a related \OfferCreation\Model\OfferProductTax object
     *
     * @param \OfferCreation\Model\OfferProductTax|ObjectCollection $offerProductTax  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildOfferProductQuery The current query, for fluid interface
     */
    public function filterByOfferProductTax($offerProductTax, $comparison = null)
    {
        if ($offerProductTax instanceof \OfferCreation\Model\OfferProductTax) {
            return $this
                ->addUsingAlias(OfferProductTableMap::ID, $offerProductTax->getOfferProductId(), $comparison);
        } elseif ($offerProductTax instanceof ObjectCollection) {
            return $this
                ->useOfferProductTaxQuery()
                ->filterByPrimaryKeys($offerProductTax->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByOfferProductTax() only accepts arguments of type \OfferCreation\Model\OfferProductTax or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the OfferProductTax relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildOfferProductQuery The current query, for fluid interface
     */
    public function joinOfferProductTax($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('OfferProductTax');

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
            $this->addJoinObject($join, 'OfferProductTax');
        }

        return $this;
    }

    /**
     * Use the OfferProductTax relation OfferProductTax object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \OfferCreation\Model\OfferProductTaxQuery A secondary query class using the current class as primary query
     */
    public function useOfferProductTaxQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinOfferProductTax($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'OfferProductTax', '\OfferCreation\Model\OfferProductTaxQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildOfferProduct $offerProduct Object to remove from the list of results
     *
     * @return ChildOfferProductQuery The current query, for fluid interface
     */
    public function prune($offerProduct = null)
    {
        if ($offerProduct) {
            $this->addUsingAlias(OfferProductTableMap::ID, $offerProduct->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the offer_product table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(OfferProductTableMap::DATABASE_NAME);
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
            OfferProductTableMap::clearInstancePool();
            OfferProductTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildOfferProduct or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildOfferProduct object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(OfferProductTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(OfferProductTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            

        OfferProductTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            OfferProductTableMap::clearRelatedInstancePool();
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
     * @return     ChildOfferProductQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(OfferProductTableMap::UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }
    
    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     ChildOfferProductQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(OfferProductTableMap::CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }
    
    /**
     * Order by update date desc
     *
     * @return     ChildOfferProductQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(OfferProductTableMap::UPDATED_AT);
    }
    
    /**
     * Order by update date asc
     *
     * @return     ChildOfferProductQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(OfferProductTableMap::UPDATED_AT);
    }
    
    /**
     * Order by create date desc
     *
     * @return     ChildOfferProductQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(OfferProductTableMap::CREATED_AT);
    }
    
    /**
     * Order by create date asc
     *
     * @return     ChildOfferProductQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(OfferProductTableMap::CREATED_AT);
    }

} // OfferProductQuery
