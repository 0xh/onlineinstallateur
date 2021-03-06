<?php

namespace AmazonIntegration\Model\Base;

use \Exception;
use \PDO;
use AmazonIntegration\Model\AmazonProductCategory as ChildAmazonProductCategory;
use AmazonIntegration\Model\AmazonProductCategoryQuery as ChildAmazonProductCategoryQuery;
use AmazonIntegration\Model\Map\AmazonProductCategoryTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'amazon_product_category' table.
 *
 * 
 *
 * @method     ChildAmazonProductCategoryQuery orderByCategoryId($order = Criteria::ASC) Order by the category_id column
 * @method     ChildAmazonProductCategoryQuery orderByParentId($order = Criteria::ASC) Order by the parent_id column
 * @method     ChildAmazonProductCategoryQuery orderByName($order = Criteria::ASC) Order by the name column
 *
 * @method     ChildAmazonProductCategoryQuery groupByCategoryId() Group by the category_id column
 * @method     ChildAmazonProductCategoryQuery groupByParentId() Group by the parent_id column
 * @method     ChildAmazonProductCategoryQuery groupByName() Group by the name column
 *
 * @method     ChildAmazonProductCategoryQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildAmazonProductCategoryQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildAmazonProductCategoryQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildAmazonProductCategory findOne(ConnectionInterface $con = null) Return the first ChildAmazonProductCategory matching the query
 * @method     ChildAmazonProductCategory findOneOrCreate(ConnectionInterface $con = null) Return the first ChildAmazonProductCategory matching the query, or a new ChildAmazonProductCategory object populated from the query conditions when no match is found
 *
 * @method     ChildAmazonProductCategory findOneByCategoryId(string $category_id) Return the first ChildAmazonProductCategory filtered by the category_id column
 * @method     ChildAmazonProductCategory findOneByParentId(string $parent_id) Return the first ChildAmazonProductCategory filtered by the parent_id column
 * @method     ChildAmazonProductCategory findOneByName(string $name) Return the first ChildAmazonProductCategory filtered by the name column
 *
 * @method     array findByCategoryId(string $category_id) Return ChildAmazonProductCategory objects filtered by the category_id column
 * @method     array findByParentId(string $parent_id) Return ChildAmazonProductCategory objects filtered by the parent_id column
 * @method     array findByName(string $name) Return ChildAmazonProductCategory objects filtered by the name column
 *
 */
abstract class AmazonProductCategoryQuery extends ModelCriteria
{
    
    /**
     * Initializes internal state of \AmazonIntegration\Model\Base\AmazonProductCategoryQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'thelia', $modelName = '\\AmazonIntegration\\Model\\AmazonProductCategory', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildAmazonProductCategoryQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildAmazonProductCategoryQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \AmazonIntegration\Model\AmazonProductCategoryQuery) {
            return $criteria;
        }
        $query = new \AmazonIntegration\Model\AmazonProductCategoryQuery();
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
     * @return ChildAmazonProductCategory|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = AmazonProductCategoryTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(AmazonProductCategoryTableMap::DATABASE_NAME);
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
     * @return   ChildAmazonProductCategory A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT CATEGORY_ID, PARENT_ID, NAME FROM amazon_product_category WHERE CATEGORY_ID = :p0';
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
            $obj = new ChildAmazonProductCategory();
            $obj->hydrate($row);
            AmazonProductCategoryTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildAmazonProductCategory|array|mixed the result, formatted by the current formatter
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
     * @return ChildAmazonProductCategoryQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(AmazonProductCategoryTableMap::CATEGORY_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildAmazonProductCategoryQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(AmazonProductCategoryTableMap::CATEGORY_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the category_id column
     *
     * Example usage:
     * <code>
     * $query->filterByCategoryId('fooValue');   // WHERE category_id = 'fooValue'
     * $query->filterByCategoryId('%fooValue%'); // WHERE category_id LIKE '%fooValue%'
     * </code>
     *
     * @param     string $categoryId The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonProductCategoryQuery The current query, for fluid interface
     */
    public function filterByCategoryId($categoryId = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($categoryId)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $categoryId)) {
                $categoryId = str_replace('*', '%', $categoryId);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AmazonProductCategoryTableMap::CATEGORY_ID, $categoryId, $comparison);
    }

    /**
     * Filter the query on the parent_id column
     *
     * Example usage:
     * <code>
     * $query->filterByParentId('fooValue');   // WHERE parent_id = 'fooValue'
     * $query->filterByParentId('%fooValue%'); // WHERE parent_id LIKE '%fooValue%'
     * </code>
     *
     * @param     string $parentId The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonProductCategoryQuery The current query, for fluid interface
     */
    public function filterByParentId($parentId = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($parentId)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $parentId)) {
                $parentId = str_replace('*', '%', $parentId);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AmazonProductCategoryTableMap::PARENT_ID, $parentId, $comparison);
    }

    /**
     * Filter the query on the name column
     *
     * Example usage:
     * <code>
     * $query->filterByName('fooValue');   // WHERE name = 'fooValue'
     * $query->filterByName('%fooValue%'); // WHERE name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $name The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonProductCategoryQuery The current query, for fluid interface
     */
    public function filterByName($name = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $name)) {
                $name = str_replace('*', '%', $name);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AmazonProductCategoryTableMap::NAME, $name, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildAmazonProductCategory $amazonProductCategory Object to remove from the list of results
     *
     * @return ChildAmazonProductCategoryQuery The current query, for fluid interface
     */
    public function prune($amazonProductCategory = null)
    {
        if ($amazonProductCategory) {
            $this->addUsingAlias(AmazonProductCategoryTableMap::CATEGORY_ID, $amazonProductCategory->getCategoryId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the amazon_product_category table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(AmazonProductCategoryTableMap::DATABASE_NAME);
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
            AmazonProductCategoryTableMap::clearInstancePool();
            AmazonProductCategoryTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildAmazonProductCategory or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildAmazonProductCategory object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(AmazonProductCategoryTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(AmazonProductCategoryTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            

        AmazonProductCategoryTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            AmazonProductCategoryTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

} // AmazonProductCategoryQuery
