<?php

namespace OfferCreation\Model\Base;

use \Exception;
use \PDO;
use OfferCreation\Model\OfferProductTax as ChildOfferProductTax;
use OfferCreation\Model\OfferProductTaxQuery as ChildOfferProductTaxQuery;
use OfferCreation\Model\Map\OfferProductTaxTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'offer_product_tax' table.
 *
 * 
 *
 * @method     ChildOfferProductTaxQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildOfferProductTaxQuery orderByOfferProductId($order = Criteria::ASC) Order by the offer_product_id column
 * @method     ChildOfferProductTaxQuery orderByTitle($order = Criteria::ASC) Order by the title column
 * @method     ChildOfferProductTaxQuery orderByDescription($order = Criteria::ASC) Order by the description column
 * @method     ChildOfferProductTaxQuery orderByAmount($order = Criteria::ASC) Order by the amount column
 * @method     ChildOfferProductTaxQuery orderByPromoAmount($order = Criteria::ASC) Order by the promo_amount column
 * @method     ChildOfferProductTaxQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildOfferProductTaxQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method     ChildOfferProductTaxQuery groupById() Group by the id column
 * @method     ChildOfferProductTaxQuery groupByOfferProductId() Group by the offer_product_id column
 * @method     ChildOfferProductTaxQuery groupByTitle() Group by the title column
 * @method     ChildOfferProductTaxQuery groupByDescription() Group by the description column
 * @method     ChildOfferProductTaxQuery groupByAmount() Group by the amount column
 * @method     ChildOfferProductTaxQuery groupByPromoAmount() Group by the promo_amount column
 * @method     ChildOfferProductTaxQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildOfferProductTaxQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method     ChildOfferProductTaxQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildOfferProductTaxQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildOfferProductTaxQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildOfferProductTaxQuery leftJoinOfferProduct($relationAlias = null) Adds a LEFT JOIN clause to the query using the OfferProduct relation
 * @method     ChildOfferProductTaxQuery rightJoinOfferProduct($relationAlias = null) Adds a RIGHT JOIN clause to the query using the OfferProduct relation
 * @method     ChildOfferProductTaxQuery innerJoinOfferProduct($relationAlias = null) Adds a INNER JOIN clause to the query using the OfferProduct relation
 *
 * @method     ChildOfferProductTax findOne(ConnectionInterface $con = null) Return the first ChildOfferProductTax matching the query
 * @method     ChildOfferProductTax findOneOrCreate(ConnectionInterface $con = null) Return the first ChildOfferProductTax matching the query, or a new ChildOfferProductTax object populated from the query conditions when no match is found
 *
 * @method     ChildOfferProductTax findOneById(int $id) Return the first ChildOfferProductTax filtered by the id column
 * @method     ChildOfferProductTax findOneByOfferProductId(int $offer_product_id) Return the first ChildOfferProductTax filtered by the offer_product_id column
 * @method     ChildOfferProductTax findOneByTitle(string $title) Return the first ChildOfferProductTax filtered by the title column
 * @method     ChildOfferProductTax findOneByDescription(string $description) Return the first ChildOfferProductTax filtered by the description column
 * @method     ChildOfferProductTax findOneByAmount(string $amount) Return the first ChildOfferProductTax filtered by the amount column
 * @method     ChildOfferProductTax findOneByPromoAmount(string $promo_amount) Return the first ChildOfferProductTax filtered by the promo_amount column
 * @method     ChildOfferProductTax findOneByCreatedAt(string $created_at) Return the first ChildOfferProductTax filtered by the created_at column
 * @method     ChildOfferProductTax findOneByUpdatedAt(string $updated_at) Return the first ChildOfferProductTax filtered by the updated_at column
 *
 * @method     array findById(int $id) Return ChildOfferProductTax objects filtered by the id column
 * @method     array findByOfferProductId(int $offer_product_id) Return ChildOfferProductTax objects filtered by the offer_product_id column
 * @method     array findByTitle(string $title) Return ChildOfferProductTax objects filtered by the title column
 * @method     array findByDescription(string $description) Return ChildOfferProductTax objects filtered by the description column
 * @method     array findByAmount(string $amount) Return ChildOfferProductTax objects filtered by the amount column
 * @method     array findByPromoAmount(string $promo_amount) Return ChildOfferProductTax objects filtered by the promo_amount column
 * @method     array findByCreatedAt(string $created_at) Return ChildOfferProductTax objects filtered by the created_at column
 * @method     array findByUpdatedAt(string $updated_at) Return ChildOfferProductTax objects filtered by the updated_at column
 *
 */
abstract class OfferProductTaxQuery extends ModelCriteria
{
    
    /**
     * Initializes internal state of \OfferCreation\Model\Base\OfferProductTaxQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'thelia', $modelName = '\\OfferCreation\\Model\\OfferProductTax', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildOfferProductTaxQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildOfferProductTaxQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \OfferCreation\Model\OfferProductTaxQuery) {
            return $criteria;
        }
        $query = new \OfferCreation\Model\OfferProductTaxQuery();
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
     * @return ChildOfferProductTax|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = OfferProductTaxTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(OfferProductTaxTableMap::DATABASE_NAME);
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
     * @return   ChildOfferProductTax A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ID, OFFER_PRODUCT_ID, TITLE, DESCRIPTION, AMOUNT, PROMO_AMOUNT, CREATED_AT, UPDATED_AT FROM offer_product_tax WHERE ID = :p0';
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
            $obj = new ChildOfferProductTax();
            $obj->hydrate($row);
            OfferProductTaxTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildOfferProductTax|array|mixed the result, formatted by the current formatter
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
     * @return ChildOfferProductTaxQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(OfferProductTaxTableMap::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildOfferProductTaxQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(OfferProductTaxTableMap::ID, $keys, Criteria::IN);
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
     * @return ChildOfferProductTaxQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(OfferProductTaxTableMap::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(OfferProductTaxTableMap::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OfferProductTaxTableMap::ID, $id, $comparison);
    }

    /**
     * Filter the query on the offer_product_id column
     *
     * Example usage:
     * <code>
     * $query->filterByOfferProductId(1234); // WHERE offer_product_id = 1234
     * $query->filterByOfferProductId(array(12, 34)); // WHERE offer_product_id IN (12, 34)
     * $query->filterByOfferProductId(array('min' => 12)); // WHERE offer_product_id > 12
     * </code>
     *
     * @see       filterByOfferProduct()
     *
     * @param     mixed $offerProductId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildOfferProductTaxQuery The current query, for fluid interface
     */
    public function filterByOfferProductId($offerProductId = null, $comparison = null)
    {
        if (is_array($offerProductId)) {
            $useMinMax = false;
            if (isset($offerProductId['min'])) {
                $this->addUsingAlias(OfferProductTaxTableMap::OFFER_PRODUCT_ID, $offerProductId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($offerProductId['max'])) {
                $this->addUsingAlias(OfferProductTaxTableMap::OFFER_PRODUCT_ID, $offerProductId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OfferProductTaxTableMap::OFFER_PRODUCT_ID, $offerProductId, $comparison);
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
     * @return ChildOfferProductTaxQuery The current query, for fluid interface
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

        return $this->addUsingAlias(OfferProductTaxTableMap::TITLE, $title, $comparison);
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
     * @return ChildOfferProductTaxQuery The current query, for fluid interface
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

        return $this->addUsingAlias(OfferProductTaxTableMap::DESCRIPTION, $description, $comparison);
    }

    /**
     * Filter the query on the amount column
     *
     * Example usage:
     * <code>
     * $query->filterByAmount(1234); // WHERE amount = 1234
     * $query->filterByAmount(array(12, 34)); // WHERE amount IN (12, 34)
     * $query->filterByAmount(array('min' => 12)); // WHERE amount > 12
     * </code>
     *
     * @param     mixed $amount The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildOfferProductTaxQuery The current query, for fluid interface
     */
    public function filterByAmount($amount = null, $comparison = null)
    {
        if (is_array($amount)) {
            $useMinMax = false;
            if (isset($amount['min'])) {
                $this->addUsingAlias(OfferProductTaxTableMap::AMOUNT, $amount['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($amount['max'])) {
                $this->addUsingAlias(OfferProductTaxTableMap::AMOUNT, $amount['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OfferProductTaxTableMap::AMOUNT, $amount, $comparison);
    }

    /**
     * Filter the query on the promo_amount column
     *
     * Example usage:
     * <code>
     * $query->filterByPromoAmount(1234); // WHERE promo_amount = 1234
     * $query->filterByPromoAmount(array(12, 34)); // WHERE promo_amount IN (12, 34)
     * $query->filterByPromoAmount(array('min' => 12)); // WHERE promo_amount > 12
     * </code>
     *
     * @param     mixed $promoAmount The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildOfferProductTaxQuery The current query, for fluid interface
     */
    public function filterByPromoAmount($promoAmount = null, $comparison = null)
    {
        if (is_array($promoAmount)) {
            $useMinMax = false;
            if (isset($promoAmount['min'])) {
                $this->addUsingAlias(OfferProductTaxTableMap::PROMO_AMOUNT, $promoAmount['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($promoAmount['max'])) {
                $this->addUsingAlias(OfferProductTaxTableMap::PROMO_AMOUNT, $promoAmount['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OfferProductTaxTableMap::PROMO_AMOUNT, $promoAmount, $comparison);
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
     * @return ChildOfferProductTaxQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(OfferProductTaxTableMap::CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(OfferProductTaxTableMap::CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OfferProductTaxTableMap::CREATED_AT, $createdAt, $comparison);
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
     * @return ChildOfferProductTaxQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(OfferProductTaxTableMap::UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(OfferProductTaxTableMap::UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OfferProductTaxTableMap::UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Filter the query by a related \OfferCreation\Model\OfferProduct object
     *
     * @param \OfferCreation\Model\OfferProduct|ObjectCollection $offerProduct The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildOfferProductTaxQuery The current query, for fluid interface
     */
    public function filterByOfferProduct($offerProduct, $comparison = null)
    {
        if ($offerProduct instanceof \OfferCreation\Model\OfferProduct) {
            return $this
                ->addUsingAlias(OfferProductTaxTableMap::OFFER_PRODUCT_ID, $offerProduct->getId(), $comparison);
        } elseif ($offerProduct instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(OfferProductTaxTableMap::OFFER_PRODUCT_ID, $offerProduct->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByOfferProduct() only accepts arguments of type \OfferCreation\Model\OfferProduct or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the OfferProduct relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildOfferProductTaxQuery The current query, for fluid interface
     */
    public function joinOfferProduct($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('OfferProduct');

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
            $this->addJoinObject($join, 'OfferProduct');
        }

        return $this;
    }

    /**
     * Use the OfferProduct relation OfferProduct object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \OfferCreation\Model\OfferProductQuery A secondary query class using the current class as primary query
     */
    public function useOfferProductQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinOfferProduct($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'OfferProduct', '\OfferCreation\Model\OfferProductQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildOfferProductTax $offerProductTax Object to remove from the list of results
     *
     * @return ChildOfferProductTaxQuery The current query, for fluid interface
     */
    public function prune($offerProductTax = null)
    {
        if ($offerProductTax) {
            $this->addUsingAlias(OfferProductTaxTableMap::ID, $offerProductTax->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the offer_product_tax table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(OfferProductTaxTableMap::DATABASE_NAME);
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
            OfferProductTaxTableMap::clearInstancePool();
            OfferProductTaxTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildOfferProductTax or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildOfferProductTax object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(OfferProductTaxTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(OfferProductTaxTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            

        OfferProductTaxTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            OfferProductTaxTableMap::clearRelatedInstancePool();
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
     * @return     ChildOfferProductTaxQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(OfferProductTaxTableMap::UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }
    
    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     ChildOfferProductTaxQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(OfferProductTaxTableMap::CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }
    
    /**
     * Order by update date desc
     *
     * @return     ChildOfferProductTaxQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(OfferProductTaxTableMap::UPDATED_AT);
    }
    
    /**
     * Order by update date asc
     *
     * @return     ChildOfferProductTaxQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(OfferProductTaxTableMap::UPDATED_AT);
    }
    
    /**
     * Order by create date desc
     *
     * @return     ChildOfferProductTaxQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(OfferProductTaxTableMap::CREATED_AT);
    }
    
    /**
     * Order by create date asc
     *
     * @return     ChildOfferProductTaxQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(OfferProductTaxTableMap::CREATED_AT);
    }

} // OfferProductTaxQuery
