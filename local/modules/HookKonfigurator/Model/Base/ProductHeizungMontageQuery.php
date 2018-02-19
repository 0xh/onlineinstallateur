<?php

namespace HookKonfigurator\Model\Base;

use \Exception;
use \PDO;
use HookKonfigurator\Model\ProductHeizungMontage as ChildProductHeizungMontage;
use HookKonfigurator\Model\ProductHeizungMontageQuery as ChildProductHeizungMontageQuery;
use HookKonfigurator\Model\Map\ProductHeizungMontageTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'product_heizung_montage' table.
 *
 * 
 *
 * @method     ChildProductHeizungMontageQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildProductHeizungMontageQuery orderByProductHeizungId($order = Criteria::ASC) Order by the product_heizung_id column
 * @method     ChildProductHeizungMontageQuery orderByMontageId($order = Criteria::ASC) Order by the montage_id column
 *
 * @method     ChildProductHeizungMontageQuery groupById() Group by the id column
 * @method     ChildProductHeizungMontageQuery groupByProductHeizungId() Group by the product_heizung_id column
 * @method     ChildProductHeizungMontageQuery groupByMontageId() Group by the montage_id column
 *
 * @method     ChildProductHeizungMontageQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildProductHeizungMontageQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildProductHeizungMontageQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildProductHeizungMontageQuery leftJoinMontage($relationAlias = null) Adds a LEFT JOIN clause to the query using the Montage relation
 * @method     ChildProductHeizungMontageQuery rightJoinMontage($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Montage relation
 * @method     ChildProductHeizungMontageQuery innerJoinMontage($relationAlias = null) Adds a INNER JOIN clause to the query using the Montage relation
 *
 * @method     ChildProductHeizungMontageQuery leftJoinProductHeizung($relationAlias = null) Adds a LEFT JOIN clause to the query using the ProductHeizung relation
 * @method     ChildProductHeizungMontageQuery rightJoinProductHeizung($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ProductHeizung relation
 * @method     ChildProductHeizungMontageQuery innerJoinProductHeizung($relationAlias = null) Adds a INNER JOIN clause to the query using the ProductHeizung relation
 *
 * @method     ChildProductHeizungMontage findOne(ConnectionInterface $con = null) Return the first ChildProductHeizungMontage matching the query
 * @method     ChildProductHeizungMontage findOneOrCreate(ConnectionInterface $con = null) Return the first ChildProductHeizungMontage matching the query, or a new ChildProductHeizungMontage object populated from the query conditions when no match is found
 *
 * @method     ChildProductHeizungMontage findOneById(int $id) Return the first ChildProductHeizungMontage filtered by the id column
 * @method     ChildProductHeizungMontage findOneByProductHeizungId(int $product_heizung_id) Return the first ChildProductHeizungMontage filtered by the product_heizung_id column
 * @method     ChildProductHeizungMontage findOneByMontageId(int $montage_id) Return the first ChildProductHeizungMontage filtered by the montage_id column
 *
 * @method     array findById(int $id) Return ChildProductHeizungMontage objects filtered by the id column
 * @method     array findByProductHeizungId(int $product_heizung_id) Return ChildProductHeizungMontage objects filtered by the product_heizung_id column
 * @method     array findByMontageId(int $montage_id) Return ChildProductHeizungMontage objects filtered by the montage_id column
 *
 */
abstract class ProductHeizungMontageQuery extends ModelCriteria
{
    
    /**
     * Initializes internal state of \HookKonfigurator\Model\Base\ProductHeizungMontageQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'thelia', $modelName = '\\HookKonfigurator\\Model\\ProductHeizungMontage', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildProductHeizungMontageQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildProductHeizungMontageQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \HookKonfigurator\Model\ProductHeizungMontageQuery) {
            return $criteria;
        }
        $query = new \HookKonfigurator\Model\ProductHeizungMontageQuery();
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
     * @return ChildProductHeizungMontage|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ProductHeizungMontageTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ProductHeizungMontageTableMap::DATABASE_NAME);
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
     * @return   ChildProductHeizungMontage A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ID, PRODUCT_HEIZUNG_ID, MONTAGE_ID FROM product_heizung_montage WHERE ID = :p0';
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
            $obj = new ChildProductHeizungMontage();
            $obj->hydrate($row);
            ProductHeizungMontageTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildProductHeizungMontage|array|mixed the result, formatted by the current formatter
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
     * @return ChildProductHeizungMontageQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ProductHeizungMontageTableMap::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildProductHeizungMontageQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ProductHeizungMontageTableMap::ID, $keys, Criteria::IN);
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
     * @return ChildProductHeizungMontageQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(ProductHeizungMontageTableMap::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(ProductHeizungMontageTableMap::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProductHeizungMontageTableMap::ID, $id, $comparison);
    }

    /**
     * Filter the query on the product_heizung_id column
     *
     * Example usage:
     * <code>
     * $query->filterByProductHeizungId(1234); // WHERE product_heizung_id = 1234
     * $query->filterByProductHeizungId(array(12, 34)); // WHERE product_heizung_id IN (12, 34)
     * $query->filterByProductHeizungId(array('min' => 12)); // WHERE product_heizung_id > 12
     * </code>
     *
     * @see       filterByProductHeizung()
     *
     * @param     mixed $productHeizungId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildProductHeizungMontageQuery The current query, for fluid interface
     */
    public function filterByProductHeizungId($productHeizungId = null, $comparison = null)
    {
        if (is_array($productHeizungId)) {
            $useMinMax = false;
            if (isset($productHeizungId['min'])) {
                $this->addUsingAlias(ProductHeizungMontageTableMap::PRODUCT_HEIZUNG_ID, $productHeizungId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($productHeizungId['max'])) {
                $this->addUsingAlias(ProductHeizungMontageTableMap::PRODUCT_HEIZUNG_ID, $productHeizungId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProductHeizungMontageTableMap::PRODUCT_HEIZUNG_ID, $productHeizungId, $comparison);
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
     * @return ChildProductHeizungMontageQuery The current query, for fluid interface
     */
    public function filterByMontageId($montageId = null, $comparison = null)
    {
        if (is_array($montageId)) {
            $useMinMax = false;
            if (isset($montageId['min'])) {
                $this->addUsingAlias(ProductHeizungMontageTableMap::MONTAGE_ID, $montageId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($montageId['max'])) {
                $this->addUsingAlias(ProductHeizungMontageTableMap::MONTAGE_ID, $montageId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProductHeizungMontageTableMap::MONTAGE_ID, $montageId, $comparison);
    }

    /**
     * Filter the query by a related \HookKonfigurator\Model\Montage object
     *
     * @param \HookKonfigurator\Model\Montage|ObjectCollection $montage The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildProductHeizungMontageQuery The current query, for fluid interface
     */
    public function filterByMontage($montage, $comparison = null)
    {
        if ($montage instanceof \HookKonfigurator\Model\Montage) {
            return $this
                ->addUsingAlias(ProductHeizungMontageTableMap::MONTAGE_ID, $montage->getId(), $comparison);
        } elseif ($montage instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ProductHeizungMontageTableMap::MONTAGE_ID, $montage->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return ChildProductHeizungMontageQuery The current query, for fluid interface
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
     * Filter the query by a related \HookKonfigurator\Model\ProductHeizung object
     *
     * @param \HookKonfigurator\Model\ProductHeizung|ObjectCollection $productHeizung The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildProductHeizungMontageQuery The current query, for fluid interface
     */
    public function filterByProductHeizung($productHeizung, $comparison = null)
    {
        if ($productHeizung instanceof \HookKonfigurator\Model\ProductHeizung) {
            return $this
                ->addUsingAlias(ProductHeizungMontageTableMap::PRODUCT_HEIZUNG_ID, $productHeizung->getProductId(), $comparison);
        } elseif ($productHeizung instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ProductHeizungMontageTableMap::PRODUCT_HEIZUNG_ID, $productHeizung->toKeyValue('PrimaryKey', 'ProductId'), $comparison);
        } else {
            throw new PropelException('filterByProductHeizung() only accepts arguments of type \HookKonfigurator\Model\ProductHeizung or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ProductHeizung relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildProductHeizungMontageQuery The current query, for fluid interface
     */
    public function joinProductHeizung($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ProductHeizung');

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
            $this->addJoinObject($join, 'ProductHeizung');
        }

        return $this;
    }

    /**
     * Use the ProductHeizung relation ProductHeizung object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \HookKonfigurator\Model\ProductHeizungQuery A secondary query class using the current class as primary query
     */
    public function useProductHeizungQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinProductHeizung($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ProductHeizung', '\HookKonfigurator\Model\ProductHeizungQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildProductHeizungMontage $productHeizungMontage Object to remove from the list of results
     *
     * @return ChildProductHeizungMontageQuery The current query, for fluid interface
     */
    public function prune($productHeizungMontage = null)
    {
        if ($productHeizungMontage) {
            $this->addUsingAlias(ProductHeizungMontageTableMap::ID, $productHeizungMontage->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the product_heizung_montage table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ProductHeizungMontageTableMap::DATABASE_NAME);
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
            ProductHeizungMontageTableMap::clearInstancePool();
            ProductHeizungMontageTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildProductHeizungMontage or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildProductHeizungMontage object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(ProductHeizungMontageTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ProductHeizungMontageTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            

        ProductHeizungMontageTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            ProductHeizungMontageTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

} // ProductHeizungMontageQuery
