<?php

namespace PageBuilder\Model\Base;

use \Exception;
use \PDO;
use PageBuilder\Model\PageBuilder as ChildPageBuilder;
use PageBuilder\Model\PageBuilderI18nQuery as ChildPageBuilderI18nQuery;
use PageBuilder\Model\PageBuilderQuery as ChildPageBuilderQuery;
use PageBuilder\Model\Map\PageBuilderTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'page_builder' table.
 *
 * 
 *
 * @method     ChildPageBuilderQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildPageBuilderQuery orderByVisible($order = Criteria::ASC) Order by the visible column
 * @method     ChildPageBuilderQuery orderByPosition($order = Criteria::ASC) Order by the position column
 * @method     ChildPageBuilderQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildPageBuilderQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method     ChildPageBuilderQuery groupById() Group by the id column
 * @method     ChildPageBuilderQuery groupByVisible() Group by the visible column
 * @method     ChildPageBuilderQuery groupByPosition() Group by the position column
 * @method     ChildPageBuilderQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildPageBuilderQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method     ChildPageBuilderQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildPageBuilderQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildPageBuilderQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildPageBuilderQuery leftJoinPageBuilderProduct($relationAlias = null) Adds a LEFT JOIN clause to the query using the PageBuilderProduct relation
 * @method     ChildPageBuilderQuery rightJoinPageBuilderProduct($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PageBuilderProduct relation
 * @method     ChildPageBuilderQuery innerJoinPageBuilderProduct($relationAlias = null) Adds a INNER JOIN clause to the query using the PageBuilderProduct relation
 *
 * @method     ChildPageBuilderQuery leftJoinPageBuilderContent($relationAlias = null) Adds a LEFT JOIN clause to the query using the PageBuilderContent relation
 * @method     ChildPageBuilderQuery rightJoinPageBuilderContent($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PageBuilderContent relation
 * @method     ChildPageBuilderQuery innerJoinPageBuilderContent($relationAlias = null) Adds a INNER JOIN clause to the query using the PageBuilderContent relation
 *
 * @method     ChildPageBuilderQuery leftJoinPageBuilderImage($relationAlias = null) Adds a LEFT JOIN clause to the query using the PageBuilderImage relation
 * @method     ChildPageBuilderQuery rightJoinPageBuilderImage($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PageBuilderImage relation
 * @method     ChildPageBuilderQuery innerJoinPageBuilderImage($relationAlias = null) Adds a INNER JOIN clause to the query using the PageBuilderImage relation
 *
 * @method     ChildPageBuilderQuery leftJoinPageBuilderElement($relationAlias = null) Adds a LEFT JOIN clause to the query using the PageBuilderElement relation
 * @method     ChildPageBuilderQuery rightJoinPageBuilderElement($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PageBuilderElement relation
 * @method     ChildPageBuilderQuery innerJoinPageBuilderElement($relationAlias = null) Adds a INNER JOIN clause to the query using the PageBuilderElement relation
 *
 * @method     ChildPageBuilderQuery leftJoinPageBuilderI18n($relationAlias = null) Adds a LEFT JOIN clause to the query using the PageBuilderI18n relation
 * @method     ChildPageBuilderQuery rightJoinPageBuilderI18n($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PageBuilderI18n relation
 * @method     ChildPageBuilderQuery innerJoinPageBuilderI18n($relationAlias = null) Adds a INNER JOIN clause to the query using the PageBuilderI18n relation
 *
 * @method     ChildPageBuilder findOne(ConnectionInterface $con = null) Return the first ChildPageBuilder matching the query
 * @method     ChildPageBuilder findOneOrCreate(ConnectionInterface $con = null) Return the first ChildPageBuilder matching the query, or a new ChildPageBuilder object populated from the query conditions when no match is found
 *
 * @method     ChildPageBuilder findOneById(int $id) Return the first ChildPageBuilder filtered by the id column
 * @method     ChildPageBuilder findOneByVisible(int $visible) Return the first ChildPageBuilder filtered by the visible column
 * @method     ChildPageBuilder findOneByPosition(int $position) Return the first ChildPageBuilder filtered by the position column
 * @method     ChildPageBuilder findOneByCreatedAt(string $created_at) Return the first ChildPageBuilder filtered by the created_at column
 * @method     ChildPageBuilder findOneByUpdatedAt(string $updated_at) Return the first ChildPageBuilder filtered by the updated_at column
 *
 * @method     array findById(int $id) Return ChildPageBuilder objects filtered by the id column
 * @method     array findByVisible(int $visible) Return ChildPageBuilder objects filtered by the visible column
 * @method     array findByPosition(int $position) Return ChildPageBuilder objects filtered by the position column
 * @method     array findByCreatedAt(string $created_at) Return ChildPageBuilder objects filtered by the created_at column
 * @method     array findByUpdatedAt(string $updated_at) Return ChildPageBuilder objects filtered by the updated_at column
 *
 */
abstract class PageBuilderQuery extends ModelCriteria
{
    
    /**
     * Initializes internal state of \PageBuilder\Model\Base\PageBuilderQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'thelia', $modelName = '\\PageBuilder\\Model\\PageBuilder', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildPageBuilderQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildPageBuilderQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \PageBuilder\Model\PageBuilderQuery) {
            return $criteria;
        }
        $query = new \PageBuilder\Model\PageBuilderQuery();
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
     * @return ChildPageBuilder|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = PageBuilderTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(PageBuilderTableMap::DATABASE_NAME);
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
     * @return   ChildPageBuilder A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ID, VISIBLE, POSITION, CREATED_AT, UPDATED_AT FROM page_builder WHERE ID = :p0';
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
            $obj = new ChildPageBuilder();
            $obj->hydrate($row);
            PageBuilderTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildPageBuilder|array|mixed the result, formatted by the current formatter
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
     * @return ChildPageBuilderQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(PageBuilderTableMap::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildPageBuilderQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(PageBuilderTableMap::ID, $keys, Criteria::IN);
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
     * @return ChildPageBuilderQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(PageBuilderTableMap::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(PageBuilderTableMap::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PageBuilderTableMap::ID, $id, $comparison);
    }

    /**
     * Filter the query on the visible column
     *
     * Example usage:
     * <code>
     * $query->filterByVisible(1234); // WHERE visible = 1234
     * $query->filterByVisible(array(12, 34)); // WHERE visible IN (12, 34)
     * $query->filterByVisible(array('min' => 12)); // WHERE visible > 12
     * </code>
     *
     * @param     mixed $visible The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPageBuilderQuery The current query, for fluid interface
     */
    public function filterByVisible($visible = null, $comparison = null)
    {
        if (is_array($visible)) {
            $useMinMax = false;
            if (isset($visible['min'])) {
                $this->addUsingAlias(PageBuilderTableMap::VISIBLE, $visible['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($visible['max'])) {
                $this->addUsingAlias(PageBuilderTableMap::VISIBLE, $visible['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PageBuilderTableMap::VISIBLE, $visible, $comparison);
    }

    /**
     * Filter the query on the position column
     *
     * Example usage:
     * <code>
     * $query->filterByPosition(1234); // WHERE position = 1234
     * $query->filterByPosition(array(12, 34)); // WHERE position IN (12, 34)
     * $query->filterByPosition(array('min' => 12)); // WHERE position > 12
     * </code>
     *
     * @param     mixed $position The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPageBuilderQuery The current query, for fluid interface
     */
    public function filterByPosition($position = null, $comparison = null)
    {
        if (is_array($position)) {
            $useMinMax = false;
            if (isset($position['min'])) {
                $this->addUsingAlias(PageBuilderTableMap::POSITION, $position['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($position['max'])) {
                $this->addUsingAlias(PageBuilderTableMap::POSITION, $position['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PageBuilderTableMap::POSITION, $position, $comparison);
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
     * @return ChildPageBuilderQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(PageBuilderTableMap::CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(PageBuilderTableMap::CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PageBuilderTableMap::CREATED_AT, $createdAt, $comparison);
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
     * @return ChildPageBuilderQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(PageBuilderTableMap::UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(PageBuilderTableMap::UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PageBuilderTableMap::UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Filter the query by a related \PageBuilder\Model\PageBuilderProduct object
     *
     * @param \PageBuilder\Model\PageBuilderProduct|ObjectCollection $pageBuilderProduct  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPageBuilderQuery The current query, for fluid interface
     */
    public function filterByPageBuilderProduct($pageBuilderProduct, $comparison = null)
    {
        if ($pageBuilderProduct instanceof \PageBuilder\Model\PageBuilderProduct) {
            return $this
                ->addUsingAlias(PageBuilderTableMap::ID, $pageBuilderProduct->getPageBuilderId(), $comparison);
        } elseif ($pageBuilderProduct instanceof ObjectCollection) {
            return $this
                ->usePageBuilderProductQuery()
                ->filterByPrimaryKeys($pageBuilderProduct->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPageBuilderProduct() only accepts arguments of type \PageBuilder\Model\PageBuilderProduct or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the PageBuilderProduct relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildPageBuilderQuery The current query, for fluid interface
     */
    public function joinPageBuilderProduct($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('PageBuilderProduct');

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
            $this->addJoinObject($join, 'PageBuilderProduct');
        }

        return $this;
    }

    /**
     * Use the PageBuilderProduct relation PageBuilderProduct object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \PageBuilder\Model\PageBuilderProductQuery A secondary query class using the current class as primary query
     */
    public function usePageBuilderProductQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPageBuilderProduct($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'PageBuilderProduct', '\PageBuilder\Model\PageBuilderProductQuery');
    }

    /**
     * Filter the query by a related \PageBuilder\Model\PageBuilderContent object
     *
     * @param \PageBuilder\Model\PageBuilderContent|ObjectCollection $pageBuilderContent  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPageBuilderQuery The current query, for fluid interface
     */
    public function filterByPageBuilderContent($pageBuilderContent, $comparison = null)
    {
        if ($pageBuilderContent instanceof \PageBuilder\Model\PageBuilderContent) {
            return $this
                ->addUsingAlias(PageBuilderTableMap::ID, $pageBuilderContent->getPageBuilderId(), $comparison);
        } elseif ($pageBuilderContent instanceof ObjectCollection) {
            return $this
                ->usePageBuilderContentQuery()
                ->filterByPrimaryKeys($pageBuilderContent->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPageBuilderContent() only accepts arguments of type \PageBuilder\Model\PageBuilderContent or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the PageBuilderContent relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildPageBuilderQuery The current query, for fluid interface
     */
    public function joinPageBuilderContent($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('PageBuilderContent');

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
            $this->addJoinObject($join, 'PageBuilderContent');
        }

        return $this;
    }

    /**
     * Use the PageBuilderContent relation PageBuilderContent object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \PageBuilder\Model\PageBuilderContentQuery A secondary query class using the current class as primary query
     */
    public function usePageBuilderContentQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPageBuilderContent($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'PageBuilderContent', '\PageBuilder\Model\PageBuilderContentQuery');
    }

    /**
     * Filter the query by a related \PageBuilder\Model\PageBuilderImage object
     *
     * @param \PageBuilder\Model\PageBuilderImage|ObjectCollection $pageBuilderImage  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPageBuilderQuery The current query, for fluid interface
     */
    public function filterByPageBuilderImage($pageBuilderImage, $comparison = null)
    {
        if ($pageBuilderImage instanceof \PageBuilder\Model\PageBuilderImage) {
            return $this
                ->addUsingAlias(PageBuilderTableMap::ID, $pageBuilderImage->getPageBuilderId(), $comparison);
        } elseif ($pageBuilderImage instanceof ObjectCollection) {
            return $this
                ->usePageBuilderImageQuery()
                ->filterByPrimaryKeys($pageBuilderImage->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPageBuilderImage() only accepts arguments of type \PageBuilder\Model\PageBuilderImage or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the PageBuilderImage relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildPageBuilderQuery The current query, for fluid interface
     */
    public function joinPageBuilderImage($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('PageBuilderImage');

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
            $this->addJoinObject($join, 'PageBuilderImage');
        }

        return $this;
    }

    /**
     * Use the PageBuilderImage relation PageBuilderImage object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \PageBuilder\Model\PageBuilderImageQuery A secondary query class using the current class as primary query
     */
    public function usePageBuilderImageQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPageBuilderImage($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'PageBuilderImage', '\PageBuilder\Model\PageBuilderImageQuery');
    }

    /**
     * Filter the query by a related \PageBuilder\Model\PageBuilderElement object
     *
     * @param \PageBuilder\Model\PageBuilderElement|ObjectCollection $pageBuilderElement  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPageBuilderQuery The current query, for fluid interface
     */
    public function filterByPageBuilderElement($pageBuilderElement, $comparison = null)
    {
        if ($pageBuilderElement instanceof \PageBuilder\Model\PageBuilderElement) {
            return $this
                ->addUsingAlias(PageBuilderTableMap::ID, $pageBuilderElement->getPageBuilderId(), $comparison);
        } elseif ($pageBuilderElement instanceof ObjectCollection) {
            return $this
                ->usePageBuilderElementQuery()
                ->filterByPrimaryKeys($pageBuilderElement->getPrimaryKeys())
                ->endUse();
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
     * @return ChildPageBuilderQuery The current query, for fluid interface
     */
    public function joinPageBuilderElement($relationAlias = null, $joinType = Criteria::INNER_JOIN)
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
    public function usePageBuilderElementQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPageBuilderElement($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'PageBuilderElement', '\PageBuilder\Model\PageBuilderElementQuery');
    }

    /**
     * Filter the query by a related \PageBuilder\Model\PageBuilderI18n object
     *
     * @param \PageBuilder\Model\PageBuilderI18n|ObjectCollection $pageBuilderI18n  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPageBuilderQuery The current query, for fluid interface
     */
    public function filterByPageBuilderI18n($pageBuilderI18n, $comparison = null)
    {
        if ($pageBuilderI18n instanceof \PageBuilder\Model\PageBuilderI18n) {
            return $this
                ->addUsingAlias(PageBuilderTableMap::ID, $pageBuilderI18n->getId(), $comparison);
        } elseif ($pageBuilderI18n instanceof ObjectCollection) {
            return $this
                ->usePageBuilderI18nQuery()
                ->filterByPrimaryKeys($pageBuilderI18n->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPageBuilderI18n() only accepts arguments of type \PageBuilder\Model\PageBuilderI18n or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the PageBuilderI18n relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildPageBuilderQuery The current query, for fluid interface
     */
    public function joinPageBuilderI18n($relationAlias = null, $joinType = 'LEFT JOIN')
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('PageBuilderI18n');

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
            $this->addJoinObject($join, 'PageBuilderI18n');
        }

        return $this;
    }

    /**
     * Use the PageBuilderI18n relation PageBuilderI18n object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \PageBuilder\Model\PageBuilderI18nQuery A secondary query class using the current class as primary query
     */
    public function usePageBuilderI18nQuery($relationAlias = null, $joinType = 'LEFT JOIN')
    {
        return $this
            ->joinPageBuilderI18n($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'PageBuilderI18n', '\PageBuilder\Model\PageBuilderI18nQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildPageBuilder $pageBuilder Object to remove from the list of results
     *
     * @return ChildPageBuilderQuery The current query, for fluid interface
     */
    public function prune($pageBuilder = null)
    {
        if ($pageBuilder) {
            $this->addUsingAlias(PageBuilderTableMap::ID, $pageBuilder->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the page_builder table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PageBuilderTableMap::DATABASE_NAME);
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
            PageBuilderTableMap::clearInstancePool();
            PageBuilderTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildPageBuilder or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildPageBuilder object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(PageBuilderTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(PageBuilderTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            

        PageBuilderTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            PageBuilderTableMap::clearRelatedInstancePool();
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
     * @return     ChildPageBuilderQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(PageBuilderTableMap::UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }
    
    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     ChildPageBuilderQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(PageBuilderTableMap::CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }
    
    /**
     * Order by update date desc
     *
     * @return     ChildPageBuilderQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(PageBuilderTableMap::UPDATED_AT);
    }
    
    /**
     * Order by update date asc
     *
     * @return     ChildPageBuilderQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(PageBuilderTableMap::UPDATED_AT);
    }
    
    /**
     * Order by create date desc
     *
     * @return     ChildPageBuilderQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(PageBuilderTableMap::CREATED_AT);
    }
    
    /**
     * Order by create date asc
     *
     * @return     ChildPageBuilderQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(PageBuilderTableMap::CREATED_AT);
    }

    // i18n behavior
    
    /**
     * Adds a JOIN clause to the query using the i18n relation
     *
     * @param     string $locale Locale to use for the join condition, e.g. 'fr_FR'
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'. Defaults to left join.
     *
     * @return    ChildPageBuilderQuery The current query, for fluid interface
     */
    public function joinI18n($locale = 'en_US', $relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $relationName = $relationAlias ? $relationAlias : 'PageBuilderI18n';
    
        return $this
            ->joinPageBuilderI18n($relationAlias, $joinType)
            ->addJoinCondition($relationName, $relationName . '.Locale = ?', $locale);
    }
    
    /**
     * Adds a JOIN clause to the query and hydrates the related I18n object.
     * Shortcut for $c->joinI18n($locale)->with()
     *
     * @param     string $locale Locale to use for the join condition, e.g. 'fr_FR'
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'. Defaults to left join.
     *
     * @return    ChildPageBuilderQuery The current query, for fluid interface
     */
    public function joinWithI18n($locale = 'en_US', $joinType = Criteria::LEFT_JOIN)
    {
        $this
            ->joinI18n($locale, null, $joinType)
            ->with('PageBuilderI18n');
        $this->with['PageBuilderI18n']->setIsWithOneToMany(false);
    
        return $this;
    }
    
    /**
     * Use the I18n relation query object
     *
     * @see       useQuery()
     *
     * @param     string $locale Locale to use for the join condition, e.g. 'fr_FR'
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'. Defaults to left join.
     *
     * @return    ChildPageBuilderI18nQuery A secondary query class using the current class as primary query
     */
    public function useI18nQuery($locale = 'en_US', $relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinI18n($locale, $relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'PageBuilderI18n', '\PageBuilder\Model\PageBuilderI18nQuery');
    }

} // PageBuilderQuery
