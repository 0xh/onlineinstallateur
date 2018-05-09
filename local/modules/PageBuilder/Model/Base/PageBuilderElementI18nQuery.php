<?php

namespace PageBuilder\Model\Base;

use \Exception;
use \PDO;
use PageBuilder\Model\PageBuilderElementI18n as ChildPageBuilderElementI18n;
use PageBuilder\Model\PageBuilderElementI18nQuery as ChildPageBuilderElementI18nQuery;
use PageBuilder\Model\Map\PageBuilderElementI18nTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'page_builder_element_i18n' table.
 *
 * 
 *
 * @method     ChildPageBuilderElementI18nQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildPageBuilderElementI18nQuery orderByLocale($order = Criteria::ASC) Order by the locale column
 * @method     ChildPageBuilderElementI18nQuery orderByVariables($order = Criteria::ASC) Order by the variables column
 *
 * @method     ChildPageBuilderElementI18nQuery groupById() Group by the id column
 * @method     ChildPageBuilderElementI18nQuery groupByLocale() Group by the locale column
 * @method     ChildPageBuilderElementI18nQuery groupByVariables() Group by the variables column
 *
 * @method     ChildPageBuilderElementI18nQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildPageBuilderElementI18nQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildPageBuilderElementI18nQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildPageBuilderElementI18nQuery leftJoinPageBuilderElement($relationAlias = null) Adds a LEFT JOIN clause to the query using the PageBuilderElement relation
 * @method     ChildPageBuilderElementI18nQuery rightJoinPageBuilderElement($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PageBuilderElement relation
 * @method     ChildPageBuilderElementI18nQuery innerJoinPageBuilderElement($relationAlias = null) Adds a INNER JOIN clause to the query using the PageBuilderElement relation
 *
 * @method     ChildPageBuilderElementI18n findOne(ConnectionInterface $con = null) Return the first ChildPageBuilderElementI18n matching the query
 * @method     ChildPageBuilderElementI18n findOneOrCreate(ConnectionInterface $con = null) Return the first ChildPageBuilderElementI18n matching the query, or a new ChildPageBuilderElementI18n object populated from the query conditions when no match is found
 *
 * @method     ChildPageBuilderElementI18n findOneById(int $id) Return the first ChildPageBuilderElementI18n filtered by the id column
 * @method     ChildPageBuilderElementI18n findOneByLocale(string $locale) Return the first ChildPageBuilderElementI18n filtered by the locale column
 * @method     ChildPageBuilderElementI18n findOneByVariables(string $variables) Return the first ChildPageBuilderElementI18n filtered by the variables column
 *
 * @method     array findById(int $id) Return ChildPageBuilderElementI18n objects filtered by the id column
 * @method     array findByLocale(string $locale) Return ChildPageBuilderElementI18n objects filtered by the locale column
 * @method     array findByVariables(string $variables) Return ChildPageBuilderElementI18n objects filtered by the variables column
 *
 */
abstract class PageBuilderElementI18nQuery extends ModelCriteria
{
    
    /**
     * Initializes internal state of \PageBuilder\Model\Base\PageBuilderElementI18nQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'thelia', $modelName = '\\PageBuilder\\Model\\PageBuilderElementI18n', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildPageBuilderElementI18nQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildPageBuilderElementI18nQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \PageBuilder\Model\PageBuilderElementI18nQuery) {
            return $criteria;
        }
        $query = new \PageBuilder\Model\PageBuilderElementI18nQuery();
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
     * @param array[$id, $locale] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildPageBuilderElementI18n|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = PageBuilderElementI18nTableMap::getInstanceFromPool(serialize(array((string) $key[0], (string) $key[1]))))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(PageBuilderElementI18nTableMap::DATABASE_NAME);
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
     * @return   ChildPageBuilderElementI18n A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ID, LOCALE, VARIABLES FROM page_builder_element_i18n WHERE ID = :p0 AND LOCALE = :p1';
        try {
            $stmt = $con->prepare($sql);            
            $stmt->bindValue(':p0', $key[0], PDO::PARAM_INT);            
            $stmt->bindValue(':p1', $key[1], PDO::PARAM_STR);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            $obj = new ChildPageBuilderElementI18n();
            $obj->hydrate($row);
            PageBuilderElementI18nTableMap::addInstanceToPool($obj, serialize(array((string) $key[0], (string) $key[1])));
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
     * @return ChildPageBuilderElementI18n|array|mixed the result, formatted by the current formatter
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
     * @return ChildPageBuilderElementI18nQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(PageBuilderElementI18nTableMap::ID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(PageBuilderElementI18nTableMap::LOCALE, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildPageBuilderElementI18nQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(PageBuilderElementI18nTableMap::ID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(PageBuilderElementI18nTableMap::LOCALE, $key[1], Criteria::EQUAL);
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
     * @see       filterByPageBuilderElement()
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPageBuilderElementI18nQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(PageBuilderElementI18nTableMap::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(PageBuilderElementI18nTableMap::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PageBuilderElementI18nTableMap::ID, $id, $comparison);
    }

    /**
     * Filter the query on the locale column
     *
     * Example usage:
     * <code>
     * $query->filterByLocale('fooValue');   // WHERE locale = 'fooValue'
     * $query->filterByLocale('%fooValue%'); // WHERE locale LIKE '%fooValue%'
     * </code>
     *
     * @param     string $locale The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPageBuilderElementI18nQuery The current query, for fluid interface
     */
    public function filterByLocale($locale = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($locale)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $locale)) {
                $locale = str_replace('*', '%', $locale);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PageBuilderElementI18nTableMap::LOCALE, $locale, $comparison);
    }

    /**
     * Filter the query on the variables column
     *
     * Example usage:
     * <code>
     * $query->filterByVariables('fooValue');   // WHERE variables = 'fooValue'
     * $query->filterByVariables('%fooValue%'); // WHERE variables LIKE '%fooValue%'
     * </code>
     *
     * @param     string $variables The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPageBuilderElementI18nQuery The current query, for fluid interface
     */
    public function filterByVariables($variables = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($variables)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $variables)) {
                $variables = str_replace('*', '%', $variables);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PageBuilderElementI18nTableMap::VARIABLES, $variables, $comparison);
    }

    /**
     * Filter the query by a related \PageBuilder\Model\PageBuilderElement object
     *
     * @param \PageBuilder\Model\PageBuilderElement|ObjectCollection $pageBuilderElement The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPageBuilderElementI18nQuery The current query, for fluid interface
     */
    public function filterByPageBuilderElement($pageBuilderElement, $comparison = null)
    {
        if ($pageBuilderElement instanceof \PageBuilder\Model\PageBuilderElement) {
            return $this
                ->addUsingAlias(PageBuilderElementI18nTableMap::ID, $pageBuilderElement->getId(), $comparison);
        } elseif ($pageBuilderElement instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(PageBuilderElementI18nTableMap::ID, $pageBuilderElement->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByPageBuilderElement() only accepts arguments of type \PageBuilder\Model\PageBuilderElement or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the PageBuilderElement relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildPageBuilderElementI18nQuery The current query, for fluid interface
     */
    public function joinPageBuilderElement($relationAlias = null, $joinType = 'LEFT JOIN')
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('PageBuilderElement');

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
            $this->addJoinObject($join, 'PageBuilderElement');
        }

        return $this;
    }

    /**
     * Use the PageBuilderElement relation PageBuilderElement object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \PageBuilder\Model\PageBuilderElementQuery A secondary query class using the current class as primary query
     */
    public function usePageBuilderElementQuery($relationAlias = null, $joinType = 'LEFT JOIN')
    {
        return $this
            ->joinPageBuilderElement($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'PageBuilderElement', '\PageBuilder\Model\PageBuilderElementQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildPageBuilderElementI18n $pageBuilderElementI18n Object to remove from the list of results
     *
     * @return ChildPageBuilderElementI18nQuery The current query, for fluid interface
     */
    public function prune($pageBuilderElementI18n = null)
    {
        if ($pageBuilderElementI18n) {
            $this->addCond('pruneCond0', $this->getAliasedColName(PageBuilderElementI18nTableMap::ID), $pageBuilderElementI18n->getId(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(PageBuilderElementI18nTableMap::LOCALE), $pageBuilderElementI18n->getLocale(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the page_builder_element_i18n table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PageBuilderElementI18nTableMap::DATABASE_NAME);
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
            PageBuilderElementI18nTableMap::clearInstancePool();
            PageBuilderElementI18nTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildPageBuilderElementI18n or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildPageBuilderElementI18n object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(PageBuilderElementI18nTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(PageBuilderElementI18nTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            

        PageBuilderElementI18nTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            PageBuilderElementI18nTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

} // PageBuilderElementI18nQuery
