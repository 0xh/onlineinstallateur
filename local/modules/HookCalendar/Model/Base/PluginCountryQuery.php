<?php

namespace HookCalendar\Model\Base;

use \Exception;
use \PDO;
use HookCalendar\Model\PluginCountry as ChildPluginCountry;
use HookCalendar\Model\PluginCountryQuery as ChildPluginCountryQuery;
use HookCalendar\Model\Map\PluginCountryTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'plugin_country' table.
 *
 *
 *
 * @method     ChildPluginCountryQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildPluginCountryQuery orderByAlpha2($order = Criteria::ASC) Order by the alpha_2 column
 * @method     ChildPluginCountryQuery orderByAlpha3($order = Criteria::ASC) Order by the alpha_3 column
 * @method     ChildPluginCountryQuery orderByStatus($order = Criteria::ASC) Order by the status column
 *
 * @method     ChildPluginCountryQuery groupById() Group by the id column
 * @method     ChildPluginCountryQuery groupByAlpha2() Group by the alpha_2 column
 * @method     ChildPluginCountryQuery groupByAlpha3() Group by the alpha_3 column
 * @method     ChildPluginCountryQuery groupByStatus() Group by the status column
 *
 * @method     ChildPluginCountryQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildPluginCountryQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildPluginCountryQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildPluginCountry findOne(ConnectionInterface $con = null) Return the first ChildPluginCountry matching the query
 * @method     ChildPluginCountry findOneOrCreate(ConnectionInterface $con = null) Return the first ChildPluginCountry matching the query, or a new ChildPluginCountry object populated from the query conditions when no match is found
 *
 * @method     ChildPluginCountry findOneById(int $id) Return the first ChildPluginCountry filtered by the id column
 * @method     ChildPluginCountry findOneByAlpha2(string $alpha_2) Return the first ChildPluginCountry filtered by the alpha_2 column
 * @method     ChildPluginCountry findOneByAlpha3(string $alpha_3) Return the first ChildPluginCountry filtered by the alpha_3 column
 * @method     ChildPluginCountry findOneByStatus(string $status) Return the first ChildPluginCountry filtered by the status column
 *
 * @method     array findById(int $id) Return ChildPluginCountry objects filtered by the id column
 * @method     array findByAlpha2(string $alpha_2) Return ChildPluginCountry objects filtered by the alpha_2 column
 * @method     array findByAlpha3(string $alpha_3) Return ChildPluginCountry objects filtered by the alpha_3 column
 * @method     array findByStatus(string $status) Return ChildPluginCountry objects filtered by the status column
 *
 */
abstract class PluginCountryQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \HookCalendar\Model\Base\PluginCountryQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'thelia', $modelName = '\\HookCalendar\\Model\\PluginCountry', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildPluginCountryQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildPluginCountryQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \HookCalendar\Model\PluginCountryQuery) {
            return $criteria;
        }
        $query = new \HookCalendar\Model\PluginCountryQuery();
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
     * @return ChildPluginCountry|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = PluginCountryTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(PluginCountryTableMap::DATABASE_NAME);
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
     * @return   ChildPluginCountry A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ID, ALPHA_2, ALPHA_3, STATUS FROM plugin_country WHERE ID = :p0';
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
            $obj = new ChildPluginCountry();
            $obj->hydrate($row);
            PluginCountryTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildPluginCountry|array|mixed the result, formatted by the current formatter
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
     * @return ChildPluginCountryQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(PluginCountryTableMap::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildPluginCountryQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(PluginCountryTableMap::ID, $keys, Criteria::IN);
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
     * @return ChildPluginCountryQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(PluginCountryTableMap::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(PluginCountryTableMap::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PluginCountryTableMap::ID, $id, $comparison);
    }

    /**
     * Filter the query on the alpha_2 column
     *
     * Example usage:
     * <code>
     * $query->filterByAlpha2('fooValue');   // WHERE alpha_2 = 'fooValue'
     * $query->filterByAlpha2('%fooValue%'); // WHERE alpha_2 LIKE '%fooValue%'
     * </code>
     *
     * @param     string $alpha2 The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginCountryQuery The current query, for fluid interface
     */
    public function filterByAlpha2($alpha2 = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($alpha2)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $alpha2)) {
                $alpha2 = str_replace('*', '%', $alpha2);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PluginCountryTableMap::ALPHA_2, $alpha2, $comparison);
    }

    /**
     * Filter the query on the alpha_3 column
     *
     * Example usage:
     * <code>
     * $query->filterByAlpha3('fooValue');   // WHERE alpha_3 = 'fooValue'
     * $query->filterByAlpha3('%fooValue%'); // WHERE alpha_3 LIKE '%fooValue%'
     * </code>
     *
     * @param     string $alpha3 The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginCountryQuery The current query, for fluid interface
     */
    public function filterByAlpha3($alpha3 = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($alpha3)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $alpha3)) {
                $alpha3 = str_replace('*', '%', $alpha3);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PluginCountryTableMap::ALPHA_3, $alpha3, $comparison);
    }

    /**
     * Filter the query on the status column
     *
     * Example usage:
     * <code>
     * $query->filterByStatus('fooValue');   // WHERE status = 'fooValue'
     * $query->filterByStatus('%fooValue%'); // WHERE status LIKE '%fooValue%'
     * </code>
     *
     * @param     string $status The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginCountryQuery The current query, for fluid interface
     */
    public function filterByStatus($status = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($status)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $status)) {
                $status = str_replace('*', '%', $status);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PluginCountryTableMap::STATUS, $status, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildPluginCountry $pluginCountry Object to remove from the list of results
     *
     * @return ChildPluginCountryQuery The current query, for fluid interface
     */
    public function prune($pluginCountry = null)
    {
        if ($pluginCountry) {
            $this->addUsingAlias(PluginCountryTableMap::ID, $pluginCountry->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the plugin_country table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PluginCountryTableMap::DATABASE_NAME);
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
            PluginCountryTableMap::clearInstancePool();
            PluginCountryTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildPluginCountry or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildPluginCountry object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(PluginCountryTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(PluginCountryTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();


        PluginCountryTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            PluginCountryTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

} // PluginCountryQuery
