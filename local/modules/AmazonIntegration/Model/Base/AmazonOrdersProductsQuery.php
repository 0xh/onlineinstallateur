<?php

namespace AmazonIntegration\Model\Base;

use \Exception;
use \PDO;
use AmazonIntegration\Model\AmazonOrdersProducts as ChildAmazonOrdersProducts;
use AmazonIntegration\Model\AmazonOrdersProductsQuery as ChildAmazonOrdersProductsQuery;
use AmazonIntegration\Model\Map\AmazonOrdersProductsTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'amazon_orders_products' table.
 *
 * 
 *
 * @method     ChildAmazonOrdersProductsQuery orderByAmazonOrderId($order = Criteria::ASC) Order by the amazon_order_id column
 * @method     ChildAmazonOrdersProductsQuery orderByProductId($order = Criteria::ASC) Order by the product_id column
 * @method     ChildAmazonOrdersProductsQuery orderByEanCode($order = Criteria::ASC) Order by the ean_code column
 * @method     ChildAmazonOrdersProductsQuery orderByASIN($order = Criteria::ASC) Order by the ASIN column
 *
 * @method     ChildAmazonOrdersProductsQuery groupByAmazonOrderId() Group by the amazon_order_id column
 * @method     ChildAmazonOrdersProductsQuery groupByProductId() Group by the product_id column
 * @method     ChildAmazonOrdersProductsQuery groupByEanCode() Group by the ean_code column
 * @method     ChildAmazonOrdersProductsQuery groupByASIN() Group by the ASIN column
 *
 * @method     ChildAmazonOrdersProductsQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildAmazonOrdersProductsQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildAmazonOrdersProductsQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildAmazonOrdersProducts findOne(ConnectionInterface $con = null) Return the first ChildAmazonOrdersProducts matching the query
 * @method     ChildAmazonOrdersProducts findOneOrCreate(ConnectionInterface $con = null) Return the first ChildAmazonOrdersProducts matching the query, or a new ChildAmazonOrdersProducts object populated from the query conditions when no match is found
 *
 * @method     ChildAmazonOrdersProducts findOneByAmazonOrderId(string $amazon_order_id) Return the first ChildAmazonOrdersProducts filtered by the amazon_order_id column
 * @method     ChildAmazonOrdersProducts findOneByProductId(int $product_id) Return the first ChildAmazonOrdersProducts filtered by the product_id column
 * @method     ChildAmazonOrdersProducts findOneByEanCode(string $ean_code) Return the first ChildAmazonOrdersProducts filtered by the ean_code column
 * @method     ChildAmazonOrdersProducts findOneByASIN(string $ASIN) Return the first ChildAmazonOrdersProducts filtered by the ASIN column
 *
 * @method     array findByAmazonOrderId(string $amazon_order_id) Return ChildAmazonOrdersProducts objects filtered by the amazon_order_id column
 * @method     array findByProductId(int $product_id) Return ChildAmazonOrdersProducts objects filtered by the product_id column
 * @method     array findByEanCode(string $ean_code) Return ChildAmazonOrdersProducts objects filtered by the ean_code column
 * @method     array findByASIN(string $ASIN) Return ChildAmazonOrdersProducts objects filtered by the ASIN column
 *
 */
abstract class AmazonOrdersProductsQuery extends ModelCriteria
{
    
    /**
     * Initializes internal state of \AmazonIntegration\Model\Base\AmazonOrdersProductsQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'thelia', $modelName = '\\AmazonIntegration\\Model\\AmazonOrdersProducts', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildAmazonOrdersProductsQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildAmazonOrdersProductsQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \AmazonIntegration\Model\AmazonOrdersProductsQuery) {
            return $criteria;
        }
        $query = new \AmazonIntegration\Model\AmazonOrdersProductsQuery();
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
     * @return ChildAmazonOrdersProducts|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = AmazonOrdersProductsTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(AmazonOrdersProductsTableMap::DATABASE_NAME);
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
     * @return   ChildAmazonOrdersProducts A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT AMAZON_ORDER_ID, PRODUCT_ID, EAN_CODE, ASIN FROM amazon_orders_products WHERE AMAZON_ORDER_ID = :p0';
        try {
            $stmt = $con->prepare($sql);            
            $stmt->bindValue(':p0', $key, PDO::PARAM_STR);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            $obj = new ChildAmazonOrdersProducts();
            $obj->hydrate($row);
            AmazonOrdersProductsTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildAmazonOrdersProducts|array|mixed the result, formatted by the current formatter
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
     * @return ChildAmazonOrdersProductsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(AmazonOrdersProductsTableMap::AMAZON_ORDER_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildAmazonOrdersProductsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(AmazonOrdersProductsTableMap::AMAZON_ORDER_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the amazon_order_id column
     *
     * Example usage:
     * <code>
     * $query->filterByAmazonOrderId('fooValue');   // WHERE amazon_order_id = 'fooValue'
     * $query->filterByAmazonOrderId('%fooValue%'); // WHERE amazon_order_id LIKE '%fooValue%'
     * </code>
     *
     * @param     string $amazonOrderId The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonOrdersProductsQuery The current query, for fluid interface
     */
    public function filterByAmazonOrderId($amazonOrderId = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($amazonOrderId)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $amazonOrderId)) {
                $amazonOrderId = str_replace('*', '%', $amazonOrderId);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AmazonOrdersProductsTableMap::AMAZON_ORDER_ID, $amazonOrderId, $comparison);
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
     * @return ChildAmazonOrdersProductsQuery The current query, for fluid interface
     */
    public function filterByProductId($productId = null, $comparison = null)
    {
        if (is_array($productId)) {
            $useMinMax = false;
            if (isset($productId['min'])) {
                $this->addUsingAlias(AmazonOrdersProductsTableMap::PRODUCT_ID, $productId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($productId['max'])) {
                $this->addUsingAlias(AmazonOrdersProductsTableMap::PRODUCT_ID, $productId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AmazonOrdersProductsTableMap::PRODUCT_ID, $productId, $comparison);
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
     * @return ChildAmazonOrdersProductsQuery The current query, for fluid interface
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

        return $this->addUsingAlias(AmazonOrdersProductsTableMap::EAN_CODE, $eanCode, $comparison);
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
     * @return ChildAmazonOrdersProductsQuery The current query, for fluid interface
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

        return $this->addUsingAlias(AmazonOrdersProductsTableMap::ASIN, $aSIN, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildAmazonOrdersProducts $amazonOrdersProducts Object to remove from the list of results
     *
     * @return ChildAmazonOrdersProductsQuery The current query, for fluid interface
     */
    public function prune($amazonOrdersProducts = null)
    {
        if ($amazonOrdersProducts) {
            $this->addUsingAlias(AmazonOrdersProductsTableMap::AMAZON_ORDER_ID, $amazonOrdersProducts->getAmazonOrderId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the amazon_orders_products table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(AmazonOrdersProductsTableMap::DATABASE_NAME);
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
            AmazonOrdersProductsTableMap::clearInstancePool();
            AmazonOrdersProductsTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildAmazonOrdersProducts or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildAmazonOrdersProducts object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(AmazonOrdersProductsTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(AmazonOrdersProductsTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            

        AmazonOrdersProductsTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            AmazonOrdersProductsTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

} // AmazonOrdersProductsQuery
