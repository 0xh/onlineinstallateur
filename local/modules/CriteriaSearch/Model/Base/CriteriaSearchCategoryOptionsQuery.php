<?php

namespace CriteriaSearch\Model\Base;

use \Exception;
use \PDO;
use CriteriaSearch\Model\CriteriaSearchCategoryOptions as ChildCriteriaSearchCategoryOptions;
use CriteriaSearch\Model\CriteriaSearchCategoryOptionsQuery as ChildCriteriaSearchCategoryOptionsQuery;
use CriteriaSearch\Model\Map\CriteriaSearchCategoryOptionsTableMap;
use CriteriaSearch\Model\Thelia\Model\Category;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'criteria_search_category_options' table.
 *
 * 
 *
 * @method     ChildCriteriaSearchCategoryOptionsQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildCriteriaSearchCategoryOptionsQuery orderByCategoryId($order = Criteria::ASC) Order by the category_id column
 * @method     ChildCriteriaSearchCategoryOptionsQuery orderByOption($order = Criteria::ASC) Order by the option column
 * @method     ChildCriteriaSearchCategoryOptionsQuery orderBySearchable($order = Criteria::ASC) Order by the searchable column
 *
 * @method     ChildCriteriaSearchCategoryOptionsQuery groupById() Group by the id column
 * @method     ChildCriteriaSearchCategoryOptionsQuery groupByCategoryId() Group by the category_id column
 * @method     ChildCriteriaSearchCategoryOptionsQuery groupByOption() Group by the option column
 * @method     ChildCriteriaSearchCategoryOptionsQuery groupBySearchable() Group by the searchable column
 *
 * @method     ChildCriteriaSearchCategoryOptionsQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildCriteriaSearchCategoryOptionsQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildCriteriaSearchCategoryOptionsQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildCriteriaSearchCategoryOptionsQuery leftJoinCategory($relationAlias = null) Adds a LEFT JOIN clause to the query using the Category relation
 * @method     ChildCriteriaSearchCategoryOptionsQuery rightJoinCategory($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Category relation
 * @method     ChildCriteriaSearchCategoryOptionsQuery innerJoinCategory($relationAlias = null) Adds a INNER JOIN clause to the query using the Category relation
 *
 * @method     ChildCriteriaSearchCategoryOptions findOne(ConnectionInterface $con = null) Return the first ChildCriteriaSearchCategoryOptions matching the query
 * @method     ChildCriteriaSearchCategoryOptions findOneOrCreate(ConnectionInterface $con = null) Return the first ChildCriteriaSearchCategoryOptions matching the query, or a new ChildCriteriaSearchCategoryOptions object populated from the query conditions when no match is found
 *
 * @method     ChildCriteriaSearchCategoryOptions findOneById(int $id) Return the first ChildCriteriaSearchCategoryOptions filtered by the id column
 * @method     ChildCriteriaSearchCategoryOptions findOneByCategoryId(int $category_id) Return the first ChildCriteriaSearchCategoryOptions filtered by the category_id column
 * @method     ChildCriteriaSearchCategoryOptions findOneByOption(int $option) Return the first ChildCriteriaSearchCategoryOptions filtered by the option column
 * @method     ChildCriteriaSearchCategoryOptions findOneBySearchable(boolean $searchable) Return the first ChildCriteriaSearchCategoryOptions filtered by the searchable column
 *
 * @method     array findById(int $id) Return ChildCriteriaSearchCategoryOptions objects filtered by the id column
 * @method     array findByCategoryId(int $category_id) Return ChildCriteriaSearchCategoryOptions objects filtered by the category_id column
 * @method     array findByOption(int $option) Return ChildCriteriaSearchCategoryOptions objects filtered by the option column
 * @method     array findBySearchable(boolean $searchable) Return ChildCriteriaSearchCategoryOptions objects filtered by the searchable column
 *
 */
abstract class CriteriaSearchCategoryOptionsQuery extends ModelCriteria
{
    
    /**
     * Initializes internal state of \CriteriaSearch\Model\Base\CriteriaSearchCategoryOptionsQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'thelia', $modelName = '\\CriteriaSearch\\Model\\CriteriaSearchCategoryOptions', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildCriteriaSearchCategoryOptionsQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildCriteriaSearchCategoryOptionsQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \CriteriaSearch\Model\CriteriaSearchCategoryOptionsQuery) {
            return $criteria;
        }
        $query = new \CriteriaSearch\Model\CriteriaSearchCategoryOptionsQuery();
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
     * @return ChildCriteriaSearchCategoryOptions|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = CriteriaSearchCategoryOptionsTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(CriteriaSearchCategoryOptionsTableMap::DATABASE_NAME);
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
     * @return   ChildCriteriaSearchCategoryOptions A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ID, CATEGORY_ID, OPTION, SEARCHABLE FROM criteria_search_category_options WHERE ID = :p0';
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
            $obj = new ChildCriteriaSearchCategoryOptions();
            $obj->hydrate($row);
            CriteriaSearchCategoryOptionsTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildCriteriaSearchCategoryOptions|array|mixed the result, formatted by the current formatter
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
     * @return ChildCriteriaSearchCategoryOptionsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(CriteriaSearchCategoryOptionsTableMap::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildCriteriaSearchCategoryOptionsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(CriteriaSearchCategoryOptionsTableMap::ID, $keys, Criteria::IN);
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
     * @return ChildCriteriaSearchCategoryOptionsQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(CriteriaSearchCategoryOptionsTableMap::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(CriteriaSearchCategoryOptionsTableMap::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CriteriaSearchCategoryOptionsTableMap::ID, $id, $comparison);
    }

    /**
     * Filter the query on the category_id column
     *
     * Example usage:
     * <code>
     * $query->filterByCategoryId(1234); // WHERE category_id = 1234
     * $query->filterByCategoryId(array(12, 34)); // WHERE category_id IN (12, 34)
     * $query->filterByCategoryId(array('min' => 12)); // WHERE category_id > 12
     * </code>
     *
     * @see       filterByCategory()
     *
     * @param     mixed $categoryId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCriteriaSearchCategoryOptionsQuery The current query, for fluid interface
     */
    public function filterByCategoryId($categoryId = null, $comparison = null)
    {
        if (is_array($categoryId)) {
            $useMinMax = false;
            if (isset($categoryId['min'])) {
                $this->addUsingAlias(CriteriaSearchCategoryOptionsTableMap::CATEGORY_ID, $categoryId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($categoryId['max'])) {
                $this->addUsingAlias(CriteriaSearchCategoryOptionsTableMap::CATEGORY_ID, $categoryId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CriteriaSearchCategoryOptionsTableMap::CATEGORY_ID, $categoryId, $comparison);
    }

    /**
     * Filter the query on the option column
     *
     * Example usage:
     * <code>
     * $query->filterByOption(1234); // WHERE option = 1234
     * $query->filterByOption(array(12, 34)); // WHERE option IN (12, 34)
     * $query->filterByOption(array('min' => 12)); // WHERE option > 12
     * </code>
     *
     * @param     mixed $option The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCriteriaSearchCategoryOptionsQuery The current query, for fluid interface
     */
    public function filterByOption($option = null, $comparison = null)
    {
        if (is_array($option)) {
            $useMinMax = false;
            if (isset($option['min'])) {
                $this->addUsingAlias(CriteriaSearchCategoryOptionsTableMap::OPTION, $option['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($option['max'])) {
                $this->addUsingAlias(CriteriaSearchCategoryOptionsTableMap::OPTION, $option['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CriteriaSearchCategoryOptionsTableMap::OPTION, $option, $comparison);
    }

    /**
     * Filter the query on the searchable column
     *
     * Example usage:
     * <code>
     * $query->filterBySearchable(true); // WHERE searchable = true
     * $query->filterBySearchable('yes'); // WHERE searchable = true
     * </code>
     *
     * @param     boolean|string $searchable The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCriteriaSearchCategoryOptionsQuery The current query, for fluid interface
     */
    public function filterBySearchable($searchable = null, $comparison = null)
    {
        if (is_string($searchable)) {
            $searchable = in_array(strtolower($searchable), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(CriteriaSearchCategoryOptionsTableMap::SEARCHABLE, $searchable, $comparison);
    }

    /**
     * Filter the query by a related \CriteriaSearch\Model\Thelia\Model\Category object
     *
     * @param \CriteriaSearch\Model\Thelia\Model\Category|ObjectCollection $category The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCriteriaSearchCategoryOptionsQuery The current query, for fluid interface
     */
    public function filterByCategory($category, $comparison = null)
    {
        if ($category instanceof \CriteriaSearch\Model\Thelia\Model\Category) {
            return $this
                ->addUsingAlias(CriteriaSearchCategoryOptionsTableMap::CATEGORY_ID, $category->getId(), $comparison);
        } elseif ($category instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(CriteriaSearchCategoryOptionsTableMap::CATEGORY_ID, $category->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByCategory() only accepts arguments of type \CriteriaSearch\Model\Thelia\Model\Category or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Category relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildCriteriaSearchCategoryOptionsQuery The current query, for fluid interface
     */
    public function joinCategory($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Category');

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
            $this->addJoinObject($join, 'Category');
        }

        return $this;
    }

    /**
     * Use the Category relation Category object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \CriteriaSearch\Model\Thelia\Model\CategoryQuery A secondary query class using the current class as primary query
     */
    public function useCategoryQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinCategory($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Category', '\CriteriaSearch\Model\Thelia\Model\CategoryQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildCriteriaSearchCategoryOptions $criteriaSearchCategoryOptions Object to remove from the list of results
     *
     * @return ChildCriteriaSearchCategoryOptionsQuery The current query, for fluid interface
     */
    public function prune($criteriaSearchCategoryOptions = null)
    {
        if ($criteriaSearchCategoryOptions) {
            $this->addUsingAlias(CriteriaSearchCategoryOptionsTableMap::ID, $criteriaSearchCategoryOptions->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the criteria_search_category_options table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CriteriaSearchCategoryOptionsTableMap::DATABASE_NAME);
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
            CriteriaSearchCategoryOptionsTableMap::clearInstancePool();
            CriteriaSearchCategoryOptionsTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildCriteriaSearchCategoryOptions or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildCriteriaSearchCategoryOptions object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(CriteriaSearchCategoryOptionsTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(CriteriaSearchCategoryOptionsTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            

        CriteriaSearchCategoryOptionsTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            CriteriaSearchCategoryOptionsTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

} // CriteriaSearchCategoryOptionsQuery
