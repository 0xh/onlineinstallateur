<?php

namespace HookCalendar\Model\Base;

use \Exception;
use \PDO;
use HookCalendar\Model\PluginPaypal as ChildPluginPaypal;
use HookCalendar\Model\PluginPaypalQuery as ChildPluginPaypalQuery;
use HookCalendar\Model\Map\PluginPaypalTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'plugin_paypal' table.
 *
 *
 *
 * @method     ChildPluginPaypalQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildPluginPaypalQuery orderByForeignId($order = Criteria::ASC) Order by the foreign_id column
 * @method     ChildPluginPaypalQuery orderBySubscrId($order = Criteria::ASC) Order by the subscr_id column
 * @method     ChildPluginPaypalQuery orderByTxnId($order = Criteria::ASC) Order by the txn_id column
 * @method     ChildPluginPaypalQuery orderByTxnType($order = Criteria::ASC) Order by the txn_type column
 * @method     ChildPluginPaypalQuery orderByMcGross($order = Criteria::ASC) Order by the mc_gross column
 * @method     ChildPluginPaypalQuery orderByMcCurrency($order = Criteria::ASC) Order by the mc_currency column
 * @method     ChildPluginPaypalQuery orderByPayerEmail($order = Criteria::ASC) Order by the payer_email column
 * @method     ChildPluginPaypalQuery orderByDt($order = Criteria::ASC) Order by the dt column
 *
 * @method     ChildPluginPaypalQuery groupById() Group by the id column
 * @method     ChildPluginPaypalQuery groupByForeignId() Group by the foreign_id column
 * @method     ChildPluginPaypalQuery groupBySubscrId() Group by the subscr_id column
 * @method     ChildPluginPaypalQuery groupByTxnId() Group by the txn_id column
 * @method     ChildPluginPaypalQuery groupByTxnType() Group by the txn_type column
 * @method     ChildPluginPaypalQuery groupByMcGross() Group by the mc_gross column
 * @method     ChildPluginPaypalQuery groupByMcCurrency() Group by the mc_currency column
 * @method     ChildPluginPaypalQuery groupByPayerEmail() Group by the payer_email column
 * @method     ChildPluginPaypalQuery groupByDt() Group by the dt column
 *
 * @method     ChildPluginPaypalQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildPluginPaypalQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildPluginPaypalQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildPluginPaypal findOne(ConnectionInterface $con = null) Return the first ChildPluginPaypal matching the query
 * @method     ChildPluginPaypal findOneOrCreate(ConnectionInterface $con = null) Return the first ChildPluginPaypal matching the query, or a new ChildPluginPaypal object populated from the query conditions when no match is found
 *
 * @method     ChildPluginPaypal findOneById(int $id) Return the first ChildPluginPaypal filtered by the id column
 * @method     ChildPluginPaypal findOneByForeignId(int $foreign_id) Return the first ChildPluginPaypal filtered by the foreign_id column
 * @method     ChildPluginPaypal findOneBySubscrId(string $subscr_id) Return the first ChildPluginPaypal filtered by the subscr_id column
 * @method     ChildPluginPaypal findOneByTxnId(string $txn_id) Return the first ChildPluginPaypal filtered by the txn_id column
 * @method     ChildPluginPaypal findOneByTxnType(string $txn_type) Return the first ChildPluginPaypal filtered by the txn_type column
 * @method     ChildPluginPaypal findOneByMcGross(string $mc_gross) Return the first ChildPluginPaypal filtered by the mc_gross column
 * @method     ChildPluginPaypal findOneByMcCurrency(string $mc_currency) Return the first ChildPluginPaypal filtered by the mc_currency column
 * @method     ChildPluginPaypal findOneByPayerEmail(string $payer_email) Return the first ChildPluginPaypal filtered by the payer_email column
 * @method     ChildPluginPaypal findOneByDt(string $dt) Return the first ChildPluginPaypal filtered by the dt column
 *
 * @method     array findById(int $id) Return ChildPluginPaypal objects filtered by the id column
 * @method     array findByForeignId(int $foreign_id) Return ChildPluginPaypal objects filtered by the foreign_id column
 * @method     array findBySubscrId(string $subscr_id) Return ChildPluginPaypal objects filtered by the subscr_id column
 * @method     array findByTxnId(string $txn_id) Return ChildPluginPaypal objects filtered by the txn_id column
 * @method     array findByTxnType(string $txn_type) Return ChildPluginPaypal objects filtered by the txn_type column
 * @method     array findByMcGross(string $mc_gross) Return ChildPluginPaypal objects filtered by the mc_gross column
 * @method     array findByMcCurrency(string $mc_currency) Return ChildPluginPaypal objects filtered by the mc_currency column
 * @method     array findByPayerEmail(string $payer_email) Return ChildPluginPaypal objects filtered by the payer_email column
 * @method     array findByDt(string $dt) Return ChildPluginPaypal objects filtered by the dt column
 *
 */
abstract class PluginPaypalQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \HookCalendar\Model\Base\PluginPaypalQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'thelia', $modelName = '\\HookCalendar\\Model\\PluginPaypal', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildPluginPaypalQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildPluginPaypalQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \HookCalendar\Model\PluginPaypalQuery) {
            return $criteria;
        }
        $query = new \HookCalendar\Model\PluginPaypalQuery();
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
     * @return ChildPluginPaypal|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = PluginPaypalTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(PluginPaypalTableMap::DATABASE_NAME);
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
     * @return   ChildPluginPaypal A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ID, FOREIGN_ID, SUBSCR_ID, TXN_ID, TXN_TYPE, MC_GROSS, MC_CURRENCY, PAYER_EMAIL, DT FROM plugin_paypal WHERE ID = :p0';
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
            $obj = new ChildPluginPaypal();
            $obj->hydrate($row);
            PluginPaypalTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildPluginPaypal|array|mixed the result, formatted by the current formatter
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
     * @return ChildPluginPaypalQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(PluginPaypalTableMap::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildPluginPaypalQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(PluginPaypalTableMap::ID, $keys, Criteria::IN);
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
     * @return ChildPluginPaypalQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(PluginPaypalTableMap::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(PluginPaypalTableMap::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PluginPaypalTableMap::ID, $id, $comparison);
    }

    /**
     * Filter the query on the foreign_id column
     *
     * Example usage:
     * <code>
     * $query->filterByForeignId(1234); // WHERE foreign_id = 1234
     * $query->filterByForeignId(array(12, 34)); // WHERE foreign_id IN (12, 34)
     * $query->filterByForeignId(array('min' => 12)); // WHERE foreign_id > 12
     * </code>
     *
     * @param     mixed $foreignId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginPaypalQuery The current query, for fluid interface
     */
    public function filterByForeignId($foreignId = null, $comparison = null)
    {
        if (is_array($foreignId)) {
            $useMinMax = false;
            if (isset($foreignId['min'])) {
                $this->addUsingAlias(PluginPaypalTableMap::FOREIGN_ID, $foreignId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($foreignId['max'])) {
                $this->addUsingAlias(PluginPaypalTableMap::FOREIGN_ID, $foreignId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PluginPaypalTableMap::FOREIGN_ID, $foreignId, $comparison);
    }

    /**
     * Filter the query on the subscr_id column
     *
     * Example usage:
     * <code>
     * $query->filterBySubscrId('fooValue');   // WHERE subscr_id = 'fooValue'
     * $query->filterBySubscrId('%fooValue%'); // WHERE subscr_id LIKE '%fooValue%'
     * </code>
     *
     * @param     string $subscrId The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginPaypalQuery The current query, for fluid interface
     */
    public function filterBySubscrId($subscrId = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($subscrId)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $subscrId)) {
                $subscrId = str_replace('*', '%', $subscrId);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PluginPaypalTableMap::SUBSCR_ID, $subscrId, $comparison);
    }

    /**
     * Filter the query on the txn_id column
     *
     * Example usage:
     * <code>
     * $query->filterByTxnId('fooValue');   // WHERE txn_id = 'fooValue'
     * $query->filterByTxnId('%fooValue%'); // WHERE txn_id LIKE '%fooValue%'
     * </code>
     *
     * @param     string $txnId The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginPaypalQuery The current query, for fluid interface
     */
    public function filterByTxnId($txnId = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($txnId)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $txnId)) {
                $txnId = str_replace('*', '%', $txnId);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PluginPaypalTableMap::TXN_ID, $txnId, $comparison);
    }

    /**
     * Filter the query on the txn_type column
     *
     * Example usage:
     * <code>
     * $query->filterByTxnType('fooValue');   // WHERE txn_type = 'fooValue'
     * $query->filterByTxnType('%fooValue%'); // WHERE txn_type LIKE '%fooValue%'
     * </code>
     *
     * @param     string $txnType The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginPaypalQuery The current query, for fluid interface
     */
    public function filterByTxnType($txnType = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($txnType)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $txnType)) {
                $txnType = str_replace('*', '%', $txnType);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PluginPaypalTableMap::TXN_TYPE, $txnType, $comparison);
    }

    /**
     * Filter the query on the mc_gross column
     *
     * Example usage:
     * <code>
     * $query->filterByMcGross(1234); // WHERE mc_gross = 1234
     * $query->filterByMcGross(array(12, 34)); // WHERE mc_gross IN (12, 34)
     * $query->filterByMcGross(array('min' => 12)); // WHERE mc_gross > 12
     * </code>
     *
     * @param     mixed $mcGross The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginPaypalQuery The current query, for fluid interface
     */
    public function filterByMcGross($mcGross = null, $comparison = null)
    {
        if (is_array($mcGross)) {
            $useMinMax = false;
            if (isset($mcGross['min'])) {
                $this->addUsingAlias(PluginPaypalTableMap::MC_GROSS, $mcGross['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($mcGross['max'])) {
                $this->addUsingAlias(PluginPaypalTableMap::MC_GROSS, $mcGross['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PluginPaypalTableMap::MC_GROSS, $mcGross, $comparison);
    }

    /**
     * Filter the query on the mc_currency column
     *
     * Example usage:
     * <code>
     * $query->filterByMcCurrency('fooValue');   // WHERE mc_currency = 'fooValue'
     * $query->filterByMcCurrency('%fooValue%'); // WHERE mc_currency LIKE '%fooValue%'
     * </code>
     *
     * @param     string $mcCurrency The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginPaypalQuery The current query, for fluid interface
     */
    public function filterByMcCurrency($mcCurrency = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($mcCurrency)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $mcCurrency)) {
                $mcCurrency = str_replace('*', '%', $mcCurrency);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PluginPaypalTableMap::MC_CURRENCY, $mcCurrency, $comparison);
    }

    /**
     * Filter the query on the payer_email column
     *
     * Example usage:
     * <code>
     * $query->filterByPayerEmail('fooValue');   // WHERE payer_email = 'fooValue'
     * $query->filterByPayerEmail('%fooValue%'); // WHERE payer_email LIKE '%fooValue%'
     * </code>
     *
     * @param     string $payerEmail The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginPaypalQuery The current query, for fluid interface
     */
    public function filterByPayerEmail($payerEmail = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($payerEmail)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $payerEmail)) {
                $payerEmail = str_replace('*', '%', $payerEmail);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PluginPaypalTableMap::PAYER_EMAIL, $payerEmail, $comparison);
    }

    /**
     * Filter the query on the dt column
     *
     * Example usage:
     * <code>
     * $query->filterByDt('2011-03-14'); // WHERE dt = '2011-03-14'
     * $query->filterByDt('now'); // WHERE dt = '2011-03-14'
     * $query->filterByDt(array('max' => 'yesterday')); // WHERE dt > '2011-03-13'
     * </code>
     *
     * @param     mixed $dt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginPaypalQuery The current query, for fluid interface
     */
    public function filterByDt($dt = null, $comparison = null)
    {
        if (is_array($dt)) {
            $useMinMax = false;
            if (isset($dt['min'])) {
                $this->addUsingAlias(PluginPaypalTableMap::DT, $dt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dt['max'])) {
                $this->addUsingAlias(PluginPaypalTableMap::DT, $dt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PluginPaypalTableMap::DT, $dt, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildPluginPaypal $pluginPaypal Object to remove from the list of results
     *
     * @return ChildPluginPaypalQuery The current query, for fluid interface
     */
    public function prune($pluginPaypal = null)
    {
        if ($pluginPaypal) {
            $this->addUsingAlias(PluginPaypalTableMap::ID, $pluginPaypal->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the plugin_paypal table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PluginPaypalTableMap::DATABASE_NAME);
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
            PluginPaypalTableMap::clearInstancePool();
            PluginPaypalTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildPluginPaypal or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildPluginPaypal object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(PluginPaypalTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(PluginPaypalTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();


        PluginPaypalTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            PluginPaypalTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

} // PluginPaypalQuery
