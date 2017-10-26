<?php

namespace AmazonIntegration\Model\Base;

use \Exception;
use \PDO;
use AmazonIntegration\Model\ProductAmazon as ChildProductAmazon;
use AmazonIntegration\Model\ProductAmazonQuery as ChildProductAmazonQuery;
use AmazonIntegration\Model\Map\ProductAmazonTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'product_amazon' table.
 *
 * 
 *
 * @method     ChildProductAmazonQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildProductAmazonQuery orderByProductId($order = Criteria::ASC) Order by the product_id column
 * @method     ChildProductAmazonQuery orderByRef($order = Criteria::ASC) Order by the ref column
 * @method     ChildProductAmazonQuery orderByEanCode($order = Criteria::ASC) Order by the ean_code column
 * @method     ChildProductAmazonQuery orderByASIN($order = Criteria::ASC) Order by the ASIN column
 * @method     ChildProductAmazonQuery orderByRanking($order = Criteria::ASC) Order by the ranking column
 * @method     ChildProductAmazonQuery orderByAmazonCategoryId($order = Criteria::ASC) Order by the amazon_category_id column
 * @method     ChildProductAmazonQuery orderByLowestPrice($order = Criteria::ASC) Order by the lowest_price column
 * @method     ChildProductAmazonQuery orderByListPrice($order = Criteria::ASC) Order by the list_price column
 *
 * @method     ChildProductAmazonQuery groupById() Group by the id column
 * @method     ChildProductAmazonQuery groupByProductId() Group by the product_id column
 * @method     ChildProductAmazonQuery groupByRef() Group by the ref column
 * @method     ChildProductAmazonQuery groupByEanCode() Group by the ean_code column
 * @method     ChildProductAmazonQuery groupByASIN() Group by the ASIN column
 * @method     ChildProductAmazonQuery groupByRanking() Group by the ranking column
 * @method     ChildProductAmazonQuery groupByAmazonCategoryId() Group by the amazon_category_id column
 * @method     ChildProductAmazonQuery groupByLowestPrice() Group by the lowest_price column
 * @method     ChildProductAmazonQuery groupByListPrice() Group by the list_price column
 *
 * @method     ChildProductAmazonQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildProductAmazonQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildProductAmazonQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildProductAmazon findOne(ConnectionInterface $con = null) Return the first ChildProductAmazon matching the query
 * @method     ChildProductAmazon findOneOrCreate(ConnectionInterface $con = null) Return the first ChildProductAmazon matching the query, or a new ChildProductAmazon object populated from the query conditions when no match is found
 *
 * @method     ChildProductAmazon findOneById(int $id) Return the first ChildProductAmazon filtered by the id column
 * @method     ChildProductAmazon findOneByProductId(int $product_id) Return the first ChildProductAmazon filtered by the product_id column
 * @method     ChildProductAmazon findOneByRef(string $ref) Return the first ChildProductAmazon filtered by the ref column
 * @method     ChildProductAmazon findOneByEanCode(string $ean_code) Return the first ChildProductAmazon filtered by the ean_code column
 * @method     ChildProductAmazon findOneByASIN(string $ASIN) Return the first ChildProductAmazon filtered by the ASIN column
 * @method     ChildProductAmazon findOneByRanking(int $ranking) Return the first ChildProductAmazon filtered by the ranking column
 * @method     ChildProductAmazon findOneByAmazonCategoryId(string $amazon_category_id) Return the first ChildProductAmazon filtered by the amazon_category_id column
 * @method     ChildProductAmazon findOneByLowestPrice(string $lowest_price) Return the first ChildProductAmazon filtered by the lowest_price column
 * @method     ChildProductAmazon findOneByListPrice(string $list_price) Return the first ChildProductAmazon filtered by the list_price column
 *
 * @method     array findById(int $id) Return ChildProductAmazon objects filtered by the id column
 * @method     array findByProductId(int $product_id) Return ChildProductAmazon objects filtered by the product_id column
 * @method     array findByRef(string $ref) Return ChildProductAmazon objects filtered by the ref column
 * @method     array findByEanCode(string $ean_code) Return ChildProductAmazon objects filtered by the ean_code column
 * @method     array findByASIN(string $ASIN) Return ChildProductAmazon objects filtered by the ASIN column
 * @method     array findByRanking(int $ranking) Return ChildProductAmazon objects filtered by the ranking column
 * @method     array findByAmazonCategoryId(string $amazon_category_id) Return ChildProductAmazon objects filtered by the amazon_category_id column
 * @method     array findByLowestPrice(string $lowest_price) Return ChildProductAmazon objects filtered by the lowest_price column
 * @method     array findByListPrice(string $list_price) Return ChildProductAmazon objects filtered by the list_price column
 *
 */
abstract class ProductAmazonQuery extends ModelCriteria
{
    
    /**
     * Initializes internal state of \AmazonIntegration\Model\Base\ProductAmazonQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'thelia', $modelName = '\\AmazonIntegration\\Model\\ProductAmazon', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildProductAmazonQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildProductAmazonQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \AmazonIntegration\Model\ProductAmazonQuery) {
            return $criteria;
        }
        $query = new \AmazonIntegration\Model\ProductAmazonQuery();
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
     * @return ChildProductAmazon|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ProductAmazonTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ProductAmazonTableMap::DATABASE_NAME);
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
     * @return   ChildProductAmazon A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ID, PRODUCT_ID, REF, EAN_CODE, ASIN, RANKING, AMAZON_CATEGORY_ID, LOWEST_PRICE, LIST_PRICE FROM product_amazon WHERE ID = :p0';
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
            $obj = new ChildProductAmazon();
            $obj->hydrate($row);
            ProductAmazonTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildProductAmazon|array|mixed the result, formatted by the current formatter
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
     * @return ChildProductAmazonQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ProductAmazonTableMap::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildProductAmazonQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ProductAmazonTableMap::ID, $keys, Criteria::IN);
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
     * @return ChildProductAmazonQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(ProductAmazonTableMap::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(ProductAmazonTableMap::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProductAmazonTableMap::ID, $id, $comparison);
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
     * @return ChildProductAmazonQuery The current query, for fluid interface
     */
    public function filterByProductId($productId = null, $comparison = null)
    {
        if (is_array($productId)) {
            $useMinMax = false;
            if (isset($productId['min'])) {
                $this->addUsingAlias(ProductAmazonTableMap::PRODUCT_ID, $productId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($productId['max'])) {
                $this->addUsingAlias(ProductAmazonTableMap::PRODUCT_ID, $productId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProductAmazonTableMap::PRODUCT_ID, $productId, $comparison);
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
     * @return ChildProductAmazonQuery The current query, for fluid interface
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

        return $this->addUsingAlias(ProductAmazonTableMap::REF, $ref, $comparison);
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
     * @return ChildProductAmazonQuery The current query, for fluid interface
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

        return $this->addUsingAlias(ProductAmazonTableMap::EAN_CODE, $eanCode, $comparison);
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
     * @return ChildProductAmazonQuery The current query, for fluid interface
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

        return $this->addUsingAlias(ProductAmazonTableMap::ASIN, $aSIN, $comparison);
    }

    /**
     * Filter the query on the ranking column
     *
     * Example usage:
     * <code>
     * $query->filterByRanking(1234); // WHERE ranking = 1234
     * $query->filterByRanking(array(12, 34)); // WHERE ranking IN (12, 34)
     * $query->filterByRanking(array('min' => 12)); // WHERE ranking > 12
     * </code>
     *
     * @param     mixed $ranking The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildProductAmazonQuery The current query, for fluid interface
     */
    public function filterByRanking($ranking = null, $comparison = null)
    {
        if (is_array($ranking)) {
            $useMinMax = false;
            if (isset($ranking['min'])) {
                $this->addUsingAlias(ProductAmazonTableMap::RANKING, $ranking['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($ranking['max'])) {
                $this->addUsingAlias(ProductAmazonTableMap::RANKING, $ranking['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProductAmazonTableMap::RANKING, $ranking, $comparison);
    }

    /**
     * Filter the query on the amazon_category_id column
     *
     * Example usage:
     * <code>
     * $query->filterByAmazonCategoryId('fooValue');   // WHERE amazon_category_id = 'fooValue'
     * $query->filterByAmazonCategoryId('%fooValue%'); // WHERE amazon_category_id LIKE '%fooValue%'
     * </code>
     *
     * @param     string $amazonCategoryId The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildProductAmazonQuery The current query, for fluid interface
     */
    public function filterByAmazonCategoryId($amazonCategoryId = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($amazonCategoryId)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $amazonCategoryId)) {
                $amazonCategoryId = str_replace('*', '%', $amazonCategoryId);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ProductAmazonTableMap::AMAZON_CATEGORY_ID, $amazonCategoryId, $comparison);
    }

    /**
     * Filter the query on the lowest_price column
     *
     * Example usage:
     * <code>
     * $query->filterByLowestPrice('fooValue');   // WHERE lowest_price = 'fooValue'
     * $query->filterByLowestPrice('%fooValue%'); // WHERE lowest_price LIKE '%fooValue%'
     * </code>
     *
     * @param     string $lowestPrice The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildProductAmazonQuery The current query, for fluid interface
     */
    public function filterByLowestPrice($lowestPrice = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($lowestPrice)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $lowestPrice)) {
                $lowestPrice = str_replace('*', '%', $lowestPrice);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ProductAmazonTableMap::LOWEST_PRICE, $lowestPrice, $comparison);
    }

    /**
     * Filter the query on the list_price column
     *
     * Example usage:
     * <code>
     * $query->filterByListPrice('fooValue');   // WHERE list_price = 'fooValue'
     * $query->filterByListPrice('%fooValue%'); // WHERE list_price LIKE '%fooValue%'
     * </code>
     *
     * @param     string $listPrice The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildProductAmazonQuery The current query, for fluid interface
     */
    public function filterByListPrice($listPrice = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($listPrice)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $listPrice)) {
                $listPrice = str_replace('*', '%', $listPrice);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ProductAmazonTableMap::LIST_PRICE, $listPrice, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildProductAmazon $productAmazon Object to remove from the list of results
     *
     * @return ChildProductAmazonQuery The current query, for fluid interface
     */
    public function prune($productAmazon = null)
    {
        if ($productAmazon) {
            $this->addUsingAlias(ProductAmazonTableMap::ID, $productAmazon->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the product_amazon table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ProductAmazonTableMap::DATABASE_NAME);
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
            ProductAmazonTableMap::clearInstancePool();
            ProductAmazonTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildProductAmazon or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildProductAmazon object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(ProductAmazonTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ProductAmazonTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            

        ProductAmazonTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            ProductAmazonTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

} // ProductAmazonQuery
