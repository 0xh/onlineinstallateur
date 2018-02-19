<?php

namespace HookKonfigurator\Model\Base;

use \Exception;
use \PDO;
use HookKonfigurator\Model\SetMontage as ChildSetMontage;
use HookKonfigurator\Model\SetMontageQuery as ChildSetMontageQuery;
use HookKonfigurator\Model\Map\SetMontageTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'set_montage' table.
 *
 * 
 *
 * @method     ChildSetMontageQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildSetMontageQuery orderBySetId($order = Criteria::ASC) Order by the set_id column
 * @method     ChildSetMontageQuery orderByMontageId($order = Criteria::ASC) Order by the montage_id column
 * @method     ChildSetMontageQuery orderByNumberOfMontageUnits($order = Criteria::ASC) Order by the number_of_montage_units column
 *
 * @method     ChildSetMontageQuery groupById() Group by the id column
 * @method     ChildSetMontageQuery groupBySetId() Group by the set_id column
 * @method     ChildSetMontageQuery groupByMontageId() Group by the montage_id column
 * @method     ChildSetMontageQuery groupByNumberOfMontageUnits() Group by the number_of_montage_units column
 *
 * @method     ChildSetMontageQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildSetMontageQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildSetMontageQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildSetMontageQuery leftJoinMontage($relationAlias = null) Adds a LEFT JOIN clause to the query using the Montage relation
 * @method     ChildSetMontageQuery rightJoinMontage($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Montage relation
 * @method     ChildSetMontageQuery innerJoinMontage($relationAlias = null) Adds a INNER JOIN clause to the query using the Montage relation
 *
 * @method     ChildSetMontageQuery leftJoinSets($relationAlias = null) Adds a LEFT JOIN clause to the query using the Sets relation
 * @method     ChildSetMontageQuery rightJoinSets($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Sets relation
 * @method     ChildSetMontageQuery innerJoinSets($relationAlias = null) Adds a INNER JOIN clause to the query using the Sets relation
 *
 * @method     ChildSetMontage findOne(ConnectionInterface $con = null) Return the first ChildSetMontage matching the query
 * @method     ChildSetMontage findOneOrCreate(ConnectionInterface $con = null) Return the first ChildSetMontage matching the query, or a new ChildSetMontage object populated from the query conditions when no match is found
 *
 * @method     ChildSetMontage findOneById(int $id) Return the first ChildSetMontage filtered by the id column
 * @method     ChildSetMontage findOneBySetId(int $set_id) Return the first ChildSetMontage filtered by the set_id column
 * @method     ChildSetMontage findOneByMontageId(int $montage_id) Return the first ChildSetMontage filtered by the montage_id column
 * @method     ChildSetMontage findOneByNumberOfMontageUnits(int $number_of_montage_units) Return the first ChildSetMontage filtered by the number_of_montage_units column
 *
 * @method     array findById(int $id) Return ChildSetMontage objects filtered by the id column
 * @method     array findBySetId(int $set_id) Return ChildSetMontage objects filtered by the set_id column
 * @method     array findByMontageId(int $montage_id) Return ChildSetMontage objects filtered by the montage_id column
 * @method     array findByNumberOfMontageUnits(int $number_of_montage_units) Return ChildSetMontage objects filtered by the number_of_montage_units column
 *
 */
abstract class SetMontageQuery extends ModelCriteria
{
    
    /**
     * Initializes internal state of \HookKonfigurator\Model\Base\SetMontageQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'thelia', $modelName = '\\HookKonfigurator\\Model\\SetMontage', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildSetMontageQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildSetMontageQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \HookKonfigurator\Model\SetMontageQuery) {
            return $criteria;
        }
        $query = new \HookKonfigurator\Model\SetMontageQuery();
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
     * @return ChildSetMontage|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = SetMontageTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(SetMontageTableMap::DATABASE_NAME);
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
     * @return   ChildSetMontage A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ID, SET_ID, MONTAGE_ID, NUMBER_OF_MONTAGE_UNITS FROM set_montage WHERE ID = :p0';
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
            $obj = new ChildSetMontage();
            $obj->hydrate($row);
            SetMontageTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildSetMontage|array|mixed the result, formatted by the current formatter
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
     * @return ChildSetMontageQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(SetMontageTableMap::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildSetMontageQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(SetMontageTableMap::ID, $keys, Criteria::IN);
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
     * @return ChildSetMontageQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(SetMontageTableMap::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(SetMontageTableMap::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SetMontageTableMap::ID, $id, $comparison);
    }

    /**
     * Filter the query on the set_id column
     *
     * Example usage:
     * <code>
     * $query->filterBySetId(1234); // WHERE set_id = 1234
     * $query->filterBySetId(array(12, 34)); // WHERE set_id IN (12, 34)
     * $query->filterBySetId(array('min' => 12)); // WHERE set_id > 12
     * </code>
     *
     * @see       filterBySets()
     *
     * @param     mixed $setId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSetMontageQuery The current query, for fluid interface
     */
    public function filterBySetId($setId = null, $comparison = null)
    {
        if (is_array($setId)) {
            $useMinMax = false;
            if (isset($setId['min'])) {
                $this->addUsingAlias(SetMontageTableMap::SET_ID, $setId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($setId['max'])) {
                $this->addUsingAlias(SetMontageTableMap::SET_ID, $setId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SetMontageTableMap::SET_ID, $setId, $comparison);
    }

    /**
     * Filter the query on the montage_id column
     *
     * Example usage:
     * <code>
     * $query->filterByMontageId(1234); // WHERE montage_id = 1234
     * $query->filterByMontageId(array(12, 34)); // WHERE montage_id IN (12, 34)
     * $query->filterByMontageId(array('min' => 12)); // WHERE montage_id > 12
     * </code>
     *
     * @see       filterByMontage()
     *
     * @param     mixed $montageId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSetMontageQuery The current query, for fluid interface
     */
    public function filterByMontageId($montageId = null, $comparison = null)
    {
        if (is_array($montageId)) {
            $useMinMax = false;
            if (isset($montageId['min'])) {
                $this->addUsingAlias(SetMontageTableMap::MONTAGE_ID, $montageId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($montageId['max'])) {
                $this->addUsingAlias(SetMontageTableMap::MONTAGE_ID, $montageId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SetMontageTableMap::MONTAGE_ID, $montageId, $comparison);
    }

    /**
     * Filter the query on the number_of_montage_units column
     *
     * Example usage:
     * <code>
     * $query->filterByNumberOfMontageUnits(1234); // WHERE number_of_montage_units = 1234
     * $query->filterByNumberOfMontageUnits(array(12, 34)); // WHERE number_of_montage_units IN (12, 34)
     * $query->filterByNumberOfMontageUnits(array('min' => 12)); // WHERE number_of_montage_units > 12
     * </code>
     *
     * @param     mixed $numberOfMontageUnits The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSetMontageQuery The current query, for fluid interface
     */
    public function filterByNumberOfMontageUnits($numberOfMontageUnits = null, $comparison = null)
    {
        if (is_array($numberOfMontageUnits)) {
            $useMinMax = false;
            if (isset($numberOfMontageUnits['min'])) {
                $this->addUsingAlias(SetMontageTableMap::NUMBER_OF_MONTAGE_UNITS, $numberOfMontageUnits['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($numberOfMontageUnits['max'])) {
                $this->addUsingAlias(SetMontageTableMap::NUMBER_OF_MONTAGE_UNITS, $numberOfMontageUnits['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SetMontageTableMap::NUMBER_OF_MONTAGE_UNITS, $numberOfMontageUnits, $comparison);
    }

    /**
     * Filter the query by a related \HookKonfigurator\Model\Montage object
     *
     * @param \HookKonfigurator\Model\Montage|ObjectCollection $montage The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSetMontageQuery The current query, for fluid interface
     */
    public function filterByMontage($montage, $comparison = null)
    {
        if ($montage instanceof \HookKonfigurator\Model\Montage) {
            return $this
                ->addUsingAlias(SetMontageTableMap::MONTAGE_ID, $montage->getId(), $comparison);
        } elseif ($montage instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(SetMontageTableMap::MONTAGE_ID, $montage->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByMontage() only accepts arguments of type \HookKonfigurator\Model\Montage or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Montage relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildSetMontageQuery The current query, for fluid interface
     */
    public function joinMontage($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Montage');

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
            $this->addJoinObject($join, 'Montage');
        }

        return $this;
    }

    /**
     * Use the Montage relation Montage object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \HookKonfigurator\Model\MontageQuery A secondary query class using the current class as primary query
     */
    public function useMontageQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinMontage($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Montage', '\HookKonfigurator\Model\MontageQuery');
    }

    /**
     * Filter the query by a related \HookKonfigurator\Model\Sets object
     *
     * @param \HookKonfigurator\Model\Sets|ObjectCollection $sets The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSetMontageQuery The current query, for fluid interface
     */
    public function filterBySets($sets, $comparison = null)
    {
        if ($sets instanceof \HookKonfigurator\Model\Sets) {
            return $this
                ->addUsingAlias(SetMontageTableMap::SET_ID, $sets->getProductId(), $comparison);
        } elseif ($sets instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(SetMontageTableMap::SET_ID, $sets->toKeyValue('PrimaryKey', 'ProductId'), $comparison);
        } else {
            throw new PropelException('filterBySets() only accepts arguments of type \HookKonfigurator\Model\Sets or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Sets relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildSetMontageQuery The current query, for fluid interface
     */
    public function joinSets($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Sets');

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
            $this->addJoinObject($join, 'Sets');
        }

        return $this;
    }

    /**
     * Use the Sets relation Sets object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \HookKonfigurator\Model\SetsQuery A secondary query class using the current class as primary query
     */
    public function useSetsQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinSets($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Sets', '\HookKonfigurator\Model\SetsQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildSetMontage $setMontage Object to remove from the list of results
     *
     * @return ChildSetMontageQuery The current query, for fluid interface
     */
    public function prune($setMontage = null)
    {
        if ($setMontage) {
            $this->addUsingAlias(SetMontageTableMap::ID, $setMontage->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the set_montage table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SetMontageTableMap::DATABASE_NAME);
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
            SetMontageTableMap::clearInstancePool();
            SetMontageTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildSetMontage or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildSetMontage object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(SetMontageTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(SetMontageTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            

        SetMontageTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            SetMontageTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

} // SetMontageQuery
