<?php

namespace Selection\Model\Base;

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
use Selection\Model\SelectionContainerImageI18n as ChildSelectionContainerImageI18n;
use Selection\Model\SelectionContainerImageI18nQuery as ChildSelectionContainerImageI18nQuery;
use Selection\Model\Map\SelectionContainerImageI18nTableMap;

/**
 * Base class that represents a query for the 'selection_container_image_i18n' table.
 *
 * 
 *
 * @method     ChildSelectionContainerImageI18nQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildSelectionContainerImageI18nQuery orderByLocale($order = Criteria::ASC) Order by the locale column
 * @method     ChildSelectionContainerImageI18nQuery orderByTitle($order = Criteria::ASC) Order by the title column
 * @method     ChildSelectionContainerImageI18nQuery orderByDescription($order = Criteria::ASC) Order by the description column
 * @method     ChildSelectionContainerImageI18nQuery orderByChapo($order = Criteria::ASC) Order by the chapo column
 * @method     ChildSelectionContainerImageI18nQuery orderByPostscriptum($order = Criteria::ASC) Order by the postscriptum column
 *
 * @method     ChildSelectionContainerImageI18nQuery groupById() Group by the id column
 * @method     ChildSelectionContainerImageI18nQuery groupByLocale() Group by the locale column
 * @method     ChildSelectionContainerImageI18nQuery groupByTitle() Group by the title column
 * @method     ChildSelectionContainerImageI18nQuery groupByDescription() Group by the description column
 * @method     ChildSelectionContainerImageI18nQuery groupByChapo() Group by the chapo column
 * @method     ChildSelectionContainerImageI18nQuery groupByPostscriptum() Group by the postscriptum column
 *
 * @method     ChildSelectionContainerImageI18nQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildSelectionContainerImageI18nQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildSelectionContainerImageI18nQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildSelectionContainerImageI18nQuery leftJoinSelectionContainerImage($relationAlias = null) Adds a LEFT JOIN clause to the query using the SelectionContainerImage relation
 * @method     ChildSelectionContainerImageI18nQuery rightJoinSelectionContainerImage($relationAlias = null) Adds a RIGHT JOIN clause to the query using the SelectionContainerImage relation
 * @method     ChildSelectionContainerImageI18nQuery innerJoinSelectionContainerImage($relationAlias = null) Adds a INNER JOIN clause to the query using the SelectionContainerImage relation
 *
 * @method     ChildSelectionContainerImageI18n findOne(ConnectionInterface $con = null) Return the first ChildSelectionContainerImageI18n matching the query
 * @method     ChildSelectionContainerImageI18n findOneOrCreate(ConnectionInterface $con = null) Return the first ChildSelectionContainerImageI18n matching the query, or a new ChildSelectionContainerImageI18n object populated from the query conditions when no match is found
 *
 * @method     ChildSelectionContainerImageI18n findOneById(int $id) Return the first ChildSelectionContainerImageI18n filtered by the id column
 * @method     ChildSelectionContainerImageI18n findOneByLocale(string $locale) Return the first ChildSelectionContainerImageI18n filtered by the locale column
 * @method     ChildSelectionContainerImageI18n findOneByTitle(string $title) Return the first ChildSelectionContainerImageI18n filtered by the title column
 * @method     ChildSelectionContainerImageI18n findOneByDescription(string $description) Return the first ChildSelectionContainerImageI18n filtered by the description column
 * @method     ChildSelectionContainerImageI18n findOneByChapo(string $chapo) Return the first ChildSelectionContainerImageI18n filtered by the chapo column
 * @method     ChildSelectionContainerImageI18n findOneByPostscriptum(string $postscriptum) Return the first ChildSelectionContainerImageI18n filtered by the postscriptum column
 *
 * @method     array findById(int $id) Return ChildSelectionContainerImageI18n objects filtered by the id column
 * @method     array findByLocale(string $locale) Return ChildSelectionContainerImageI18n objects filtered by the locale column
 * @method     array findByTitle(string $title) Return ChildSelectionContainerImageI18n objects filtered by the title column
 * @method     array findByDescription(string $description) Return ChildSelectionContainerImageI18n objects filtered by the description column
 * @method     array findByChapo(string $chapo) Return ChildSelectionContainerImageI18n objects filtered by the chapo column
 * @method     array findByPostscriptum(string $postscriptum) Return ChildSelectionContainerImageI18n objects filtered by the postscriptum column
 *
 */
abstract class SelectionContainerImageI18nQuery extends ModelCriteria
{
    
    /**
     * Initializes internal state of \Selection\Model\Base\SelectionContainerImageI18nQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'thelia', $modelName = '\\Selection\\Model\\SelectionContainerImageI18n', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildSelectionContainerImageI18nQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildSelectionContainerImageI18nQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \Selection\Model\SelectionContainerImageI18nQuery) {
            return $criteria;
        }
        $query = new \Selection\Model\SelectionContainerImageI18nQuery();
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
     * @return ChildSelectionContainerImageI18n|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = SelectionContainerImageI18nTableMap::getInstanceFromPool(serialize(array((string) $key[0], (string) $key[1]))))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(SelectionContainerImageI18nTableMap::DATABASE_NAME);
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
     * @return   ChildSelectionContainerImageI18n A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ID, LOCALE, TITLE, DESCRIPTION, CHAPO, POSTSCRIPTUM FROM selection_container_image_i18n WHERE ID = :p0 AND LOCALE = :p1';
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
            $obj = new ChildSelectionContainerImageI18n();
            $obj->hydrate($row);
            SelectionContainerImageI18nTableMap::addInstanceToPool($obj, serialize(array((string) $key[0], (string) $key[1])));
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
     * @return ChildSelectionContainerImageI18n|array|mixed the result, formatted by the current formatter
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
     * @return ChildSelectionContainerImageI18nQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(SelectionContainerImageI18nTableMap::ID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(SelectionContainerImageI18nTableMap::LOCALE, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildSelectionContainerImageI18nQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(SelectionContainerImageI18nTableMap::ID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(SelectionContainerImageI18nTableMap::LOCALE, $key[1], Criteria::EQUAL);
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
     * @see       filterBySelectionContainerImage()
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSelectionContainerImageI18nQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(SelectionContainerImageI18nTableMap::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(SelectionContainerImageI18nTableMap::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SelectionContainerImageI18nTableMap::ID, $id, $comparison);
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
     * @return ChildSelectionContainerImageI18nQuery The current query, for fluid interface
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

        return $this->addUsingAlias(SelectionContainerImageI18nTableMap::LOCALE, $locale, $comparison);
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
     * @return ChildSelectionContainerImageI18nQuery The current query, for fluid interface
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

        return $this->addUsingAlias(SelectionContainerImageI18nTableMap::TITLE, $title, $comparison);
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
     * @return ChildSelectionContainerImageI18nQuery The current query, for fluid interface
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

        return $this->addUsingAlias(SelectionContainerImageI18nTableMap::DESCRIPTION, $description, $comparison);
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
     * @return ChildSelectionContainerImageI18nQuery The current query, for fluid interface
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

        return $this->addUsingAlias(SelectionContainerImageI18nTableMap::CHAPO, $chapo, $comparison);
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
     * @return ChildSelectionContainerImageI18nQuery The current query, for fluid interface
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

        return $this->addUsingAlias(SelectionContainerImageI18nTableMap::POSTSCRIPTUM, $postscriptum, $comparison);
    }

    /**
     * Filter the query by a related \Selection\Model\SelectionContainerImage object
     *
     * @param \Selection\Model\SelectionContainerImage|ObjectCollection $selectionContainerImage The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSelectionContainerImageI18nQuery The current query, for fluid interface
     */
    public function filterBySelectionContainerImage($selectionContainerImage, $comparison = null)
    {
        if ($selectionContainerImage instanceof \Selection\Model\SelectionContainerImage) {
            return $this
                ->addUsingAlias(SelectionContainerImageI18nTableMap::ID, $selectionContainerImage->getId(), $comparison);
        } elseif ($selectionContainerImage instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(SelectionContainerImageI18nTableMap::ID, $selectionContainerImage->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterBySelectionContainerImage() only accepts arguments of type \Selection\Model\SelectionContainerImage or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the SelectionContainerImage relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildSelectionContainerImageI18nQuery The current query, for fluid interface
     */
    public function joinSelectionContainerImage($relationAlias = null, $joinType = 'LEFT JOIN')
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('SelectionContainerImage');

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
            $this->addJoinObject($join, 'SelectionContainerImage');
        }

        return $this;
    }

    /**
     * Use the SelectionContainerImage relation SelectionContainerImage object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Selection\Model\SelectionContainerImageQuery A secondary query class using the current class as primary query
     */
    public function useSelectionContainerImageQuery($relationAlias = null, $joinType = 'LEFT JOIN')
    {
        return $this
            ->joinSelectionContainerImage($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'SelectionContainerImage', '\Selection\Model\SelectionContainerImageQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildSelectionContainerImageI18n $selectionContainerImageI18n Object to remove from the list of results
     *
     * @return ChildSelectionContainerImageI18nQuery The current query, for fluid interface
     */
    public function prune($selectionContainerImageI18n = null)
    {
        if ($selectionContainerImageI18n) {
            $this->addCond('pruneCond0', $this->getAliasedColName(SelectionContainerImageI18nTableMap::ID), $selectionContainerImageI18n->getId(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(SelectionContainerImageI18nTableMap::LOCALE), $selectionContainerImageI18n->getLocale(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the selection_container_image_i18n table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SelectionContainerImageI18nTableMap::DATABASE_NAME);
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
            SelectionContainerImageI18nTableMap::clearInstancePool();
            SelectionContainerImageI18nTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildSelectionContainerImageI18n or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildSelectionContainerImageI18n object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(SelectionContainerImageI18nTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(SelectionContainerImageI18nTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            

        SelectionContainerImageI18nTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            SelectionContainerImageI18nTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

} // SelectionContainerImageI18nQuery
