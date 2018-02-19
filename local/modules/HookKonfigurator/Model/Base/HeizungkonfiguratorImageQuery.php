<?php

namespace HookKonfigurator\Model\Base;

use \Exception;
use \PDO;
use HookKonfigurator\Model\HeizungkonfiguratorImage as ChildHeizungkonfiguratorImage;
use HookKonfigurator\Model\HeizungkonfiguratorImageQuery as ChildHeizungkonfiguratorImageQuery;
use HookKonfigurator\Model\Map\HeizungkonfiguratorImageTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'heizungkonfigurator_image' table.
 *
 * 
 *
 * @method     ChildHeizungkonfiguratorImageQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildHeizungkonfiguratorImageQuery orderByHeizunkskonfiguratorId($order = Criteria::ASC) Order by the heizunkskonfigurator_id column
 * @method     ChildHeizungkonfiguratorImageQuery orderByFile($order = Criteria::ASC) Order by the file column
 * @method     ChildHeizungkonfiguratorImageQuery orderByVisible($order = Criteria::ASC) Order by the visible column
 * @method     ChildHeizungkonfiguratorImageQuery orderByPosition($order = Criteria::ASC) Order by the position column
 * @method     ChildHeizungkonfiguratorImageQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildHeizungkonfiguratorImageQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method     ChildHeizungkonfiguratorImageQuery groupById() Group by the id column
 * @method     ChildHeizungkonfiguratorImageQuery groupByHeizunkskonfiguratorId() Group by the heizunkskonfigurator_id column
 * @method     ChildHeizungkonfiguratorImageQuery groupByFile() Group by the file column
 * @method     ChildHeizungkonfiguratorImageQuery groupByVisible() Group by the visible column
 * @method     ChildHeizungkonfiguratorImageQuery groupByPosition() Group by the position column
 * @method     ChildHeizungkonfiguratorImageQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildHeizungkonfiguratorImageQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method     ChildHeizungkonfiguratorImageQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildHeizungkonfiguratorImageQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildHeizungkonfiguratorImageQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildHeizungkonfiguratorImageQuery leftJoinHeizungkonfiguratorUserdaten($relationAlias = null) Adds a LEFT JOIN clause to the query using the HeizungkonfiguratorUserdaten relation
 * @method     ChildHeizungkonfiguratorImageQuery rightJoinHeizungkonfiguratorUserdaten($relationAlias = null) Adds a RIGHT JOIN clause to the query using the HeizungkonfiguratorUserdaten relation
 * @method     ChildHeizungkonfiguratorImageQuery innerJoinHeizungkonfiguratorUserdaten($relationAlias = null) Adds a INNER JOIN clause to the query using the HeizungkonfiguratorUserdaten relation
 *
 * @method     ChildHeizungkonfiguratorImage findOne(ConnectionInterface $con = null) Return the first ChildHeizungkonfiguratorImage matching the query
 * @method     ChildHeizungkonfiguratorImage findOneOrCreate(ConnectionInterface $con = null) Return the first ChildHeizungkonfiguratorImage matching the query, or a new ChildHeizungkonfiguratorImage object populated from the query conditions when no match is found
 *
 * @method     ChildHeizungkonfiguratorImage findOneById(int $id) Return the first ChildHeizungkonfiguratorImage filtered by the id column
 * @method     ChildHeizungkonfiguratorImage findOneByHeizunkskonfiguratorId(int $heizunkskonfigurator_id) Return the first ChildHeizungkonfiguratorImage filtered by the heizunkskonfigurator_id column
 * @method     ChildHeizungkonfiguratorImage findOneByFile(string $file) Return the first ChildHeizungkonfiguratorImage filtered by the file column
 * @method     ChildHeizungkonfiguratorImage findOneByVisible(int $visible) Return the first ChildHeizungkonfiguratorImage filtered by the visible column
 * @method     ChildHeizungkonfiguratorImage findOneByPosition(int $position) Return the first ChildHeizungkonfiguratorImage filtered by the position column
 * @method     ChildHeizungkonfiguratorImage findOneByCreatedAt(string $created_at) Return the first ChildHeizungkonfiguratorImage filtered by the created_at column
 * @method     ChildHeizungkonfiguratorImage findOneByUpdatedAt(string $updated_at) Return the first ChildHeizungkonfiguratorImage filtered by the updated_at column
 *
 * @method     array findById(int $id) Return ChildHeizungkonfiguratorImage objects filtered by the id column
 * @method     array findByHeizunkskonfiguratorId(int $heizunkskonfigurator_id) Return ChildHeizungkonfiguratorImage objects filtered by the heizunkskonfigurator_id column
 * @method     array findByFile(string $file) Return ChildHeizungkonfiguratorImage objects filtered by the file column
 * @method     array findByVisible(int $visible) Return ChildHeizungkonfiguratorImage objects filtered by the visible column
 * @method     array findByPosition(int $position) Return ChildHeizungkonfiguratorImage objects filtered by the position column
 * @method     array findByCreatedAt(string $created_at) Return ChildHeizungkonfiguratorImage objects filtered by the created_at column
 * @method     array findByUpdatedAt(string $updated_at) Return ChildHeizungkonfiguratorImage objects filtered by the updated_at column
 *
 */
abstract class HeizungkonfiguratorImageQuery extends ModelCriteria
{
    
    /**
     * Initializes internal state of \HookKonfigurator\Model\Base\HeizungkonfiguratorImageQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'thelia', $modelName = '\\HookKonfigurator\\Model\\HeizungkonfiguratorImage', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildHeizungkonfiguratorImageQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildHeizungkonfiguratorImageQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \HookKonfigurator\Model\HeizungkonfiguratorImageQuery) {
            return $criteria;
        }
        $query = new \HookKonfigurator\Model\HeizungkonfiguratorImageQuery();
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
     * @return ChildHeizungkonfiguratorImage|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = HeizungkonfiguratorImageTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(HeizungkonfiguratorImageTableMap::DATABASE_NAME);
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
     * @return   ChildHeizungkonfiguratorImage A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ID, HEIZUNKSKONFIGURATOR_ID, FILE, VISIBLE, POSITION, CREATED_AT, UPDATED_AT FROM heizungkonfigurator_image WHERE ID = :p0';
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
            $obj = new ChildHeizungkonfiguratorImage();
            $obj->hydrate($row);
            HeizungkonfiguratorImageTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildHeizungkonfiguratorImage|array|mixed the result, formatted by the current formatter
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
     * @return ChildHeizungkonfiguratorImageQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(HeizungkonfiguratorImageTableMap::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildHeizungkonfiguratorImageQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(HeizungkonfiguratorImageTableMap::ID, $keys, Criteria::IN);
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
     * @return ChildHeizungkonfiguratorImageQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(HeizungkonfiguratorImageTableMap::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(HeizungkonfiguratorImageTableMap::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(HeizungkonfiguratorImageTableMap::ID, $id, $comparison);
    }

    /**
     * Filter the query on the heizunkskonfigurator_id column
     *
     * Example usage:
     * <code>
     * $query->filterByHeizunkskonfiguratorId(1234); // WHERE heizunkskonfigurator_id = 1234
     * $query->filterByHeizunkskonfiguratorId(array(12, 34)); // WHERE heizunkskonfigurator_id IN (12, 34)
     * $query->filterByHeizunkskonfiguratorId(array('min' => 12)); // WHERE heizunkskonfigurator_id > 12
     * </code>
     *
     * @see       filterByHeizungkonfiguratorUserdaten()
     *
     * @param     mixed $heizunkskonfiguratorId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildHeizungkonfiguratorImageQuery The current query, for fluid interface
     */
    public function filterByHeizunkskonfiguratorId($heizunkskonfiguratorId = null, $comparison = null)
    {
        if (is_array($heizunkskonfiguratorId)) {
            $useMinMax = false;
            if (isset($heizunkskonfiguratorId['min'])) {
                $this->addUsingAlias(HeizungkonfiguratorImageTableMap::HEIZUNKSKONFIGURATOR_ID, $heizunkskonfiguratorId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($heizunkskonfiguratorId['max'])) {
                $this->addUsingAlias(HeizungkonfiguratorImageTableMap::HEIZUNKSKONFIGURATOR_ID, $heizunkskonfiguratorId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(HeizungkonfiguratorImageTableMap::HEIZUNKSKONFIGURATOR_ID, $heizunkskonfiguratorId, $comparison);
    }

    /**
     * Filter the query on the file column
     *
     * Example usage:
     * <code>
     * $query->filterByFile('fooValue');   // WHERE file = 'fooValue'
     * $query->filterByFile('%fooValue%'); // WHERE file LIKE '%fooValue%'
     * </code>
     *
     * @param     string $file The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildHeizungkonfiguratorImageQuery The current query, for fluid interface
     */
    public function filterByFile($file = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($file)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $file)) {
                $file = str_replace('*', '%', $file);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(HeizungkonfiguratorImageTableMap::FILE, $file, $comparison);
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
     * @return ChildHeizungkonfiguratorImageQuery The current query, for fluid interface
     */
    public function filterByVisible($visible = null, $comparison = null)
    {
        if (is_array($visible)) {
            $useMinMax = false;
            if (isset($visible['min'])) {
                $this->addUsingAlias(HeizungkonfiguratorImageTableMap::VISIBLE, $visible['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($visible['max'])) {
                $this->addUsingAlias(HeizungkonfiguratorImageTableMap::VISIBLE, $visible['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(HeizungkonfiguratorImageTableMap::VISIBLE, $visible, $comparison);
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
     * @return ChildHeizungkonfiguratorImageQuery The current query, for fluid interface
     */
    public function filterByPosition($position = null, $comparison = null)
    {
        if (is_array($position)) {
            $useMinMax = false;
            if (isset($position['min'])) {
                $this->addUsingAlias(HeizungkonfiguratorImageTableMap::POSITION, $position['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($position['max'])) {
                $this->addUsingAlias(HeizungkonfiguratorImageTableMap::POSITION, $position['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(HeizungkonfiguratorImageTableMap::POSITION, $position, $comparison);
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
     * @return ChildHeizungkonfiguratorImageQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(HeizungkonfiguratorImageTableMap::CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(HeizungkonfiguratorImageTableMap::CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(HeizungkonfiguratorImageTableMap::CREATED_AT, $createdAt, $comparison);
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
     * @return ChildHeizungkonfiguratorImageQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(HeizungkonfiguratorImageTableMap::UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(HeizungkonfiguratorImageTableMap::UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(HeizungkonfiguratorImageTableMap::UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Filter the query by a related \HookKonfigurator\Model\HeizungkonfiguratorUserdaten object
     *
     * @param \HookKonfigurator\Model\HeizungkonfiguratorUserdaten|ObjectCollection $heizungkonfiguratorUserdaten The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildHeizungkonfiguratorImageQuery The current query, for fluid interface
     */
    public function filterByHeizungkonfiguratorUserdaten($heizungkonfiguratorUserdaten, $comparison = null)
    {
        if ($heizungkonfiguratorUserdaten instanceof \HookKonfigurator\Model\HeizungkonfiguratorUserdaten) {
            return $this
                ->addUsingAlias(HeizungkonfiguratorImageTableMap::HEIZUNKSKONFIGURATOR_ID, $heizungkonfiguratorUserdaten->getId(), $comparison);
        } elseif ($heizungkonfiguratorUserdaten instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(HeizungkonfiguratorImageTableMap::HEIZUNKSKONFIGURATOR_ID, $heizungkonfiguratorUserdaten->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByHeizungkonfiguratorUserdaten() only accepts arguments of type \HookKonfigurator\Model\HeizungkonfiguratorUserdaten or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the HeizungkonfiguratorUserdaten relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildHeizungkonfiguratorImageQuery The current query, for fluid interface
     */
    public function joinHeizungkonfiguratorUserdaten($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('HeizungkonfiguratorUserdaten');

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
            $this->addJoinObject($join, 'HeizungkonfiguratorUserdaten');
        }

        return $this;
    }

    /**
     * Use the HeizungkonfiguratorUserdaten relation HeizungkonfiguratorUserdaten object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \HookKonfigurator\Model\HeizungkonfiguratorUserdatenQuery A secondary query class using the current class as primary query
     */
    public function useHeizungkonfiguratorUserdatenQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinHeizungkonfiguratorUserdaten($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'HeizungkonfiguratorUserdaten', '\HookKonfigurator\Model\HeizungkonfiguratorUserdatenQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildHeizungkonfiguratorImage $heizungkonfiguratorImage Object to remove from the list of results
     *
     * @return ChildHeizungkonfiguratorImageQuery The current query, for fluid interface
     */
    public function prune($heizungkonfiguratorImage = null)
    {
        if ($heizungkonfiguratorImage) {
            $this->addUsingAlias(HeizungkonfiguratorImageTableMap::ID, $heizungkonfiguratorImage->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the heizungkonfigurator_image table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(HeizungkonfiguratorImageTableMap::DATABASE_NAME);
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
            HeizungkonfiguratorImageTableMap::clearInstancePool();
            HeizungkonfiguratorImageTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildHeizungkonfiguratorImage or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildHeizungkonfiguratorImage object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(HeizungkonfiguratorImageTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(HeizungkonfiguratorImageTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            

        HeizungkonfiguratorImageTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            HeizungkonfiguratorImageTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

} // HeizungkonfiguratorImageQuery
