<?php

namespace HookCalendar\Model\Base;

use \Exception;
use \PDO;
use HookCalendar\Model\PluginInvoiceItems as ChildPluginInvoiceItems;
use HookCalendar\Model\PluginInvoiceItemsQuery as ChildPluginInvoiceItemsQuery;
use HookCalendar\Model\Map\PluginInvoiceItemsTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'plugin_invoice_items' table.
 *
 *
 *
 * @method     ChildPluginInvoiceItemsQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildPluginInvoiceItemsQuery orderByInvoiceId($order = Criteria::ASC) Order by the invoice_id column
 * @method     ChildPluginInvoiceItemsQuery orderByTmp($order = Criteria::ASC) Order by the tmp column
 * @method     ChildPluginInvoiceItemsQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method     ChildPluginInvoiceItemsQuery orderByDescription($order = Criteria::ASC) Order by the description column
 * @method     ChildPluginInvoiceItemsQuery orderByQty($order = Criteria::ASC) Order by the qty column
 * @method     ChildPluginInvoiceItemsQuery orderByUnitPrice($order = Criteria::ASC) Order by the unit_price column
 * @method     ChildPluginInvoiceItemsQuery orderByAmount($order = Criteria::ASC) Order by the amount column
 *
 * @method     ChildPluginInvoiceItemsQuery groupById() Group by the id column
 * @method     ChildPluginInvoiceItemsQuery groupByInvoiceId() Group by the invoice_id column
 * @method     ChildPluginInvoiceItemsQuery groupByTmp() Group by the tmp column
 * @method     ChildPluginInvoiceItemsQuery groupByName() Group by the name column
 * @method     ChildPluginInvoiceItemsQuery groupByDescription() Group by the description column
 * @method     ChildPluginInvoiceItemsQuery groupByQty() Group by the qty column
 * @method     ChildPluginInvoiceItemsQuery groupByUnitPrice() Group by the unit_price column
 * @method     ChildPluginInvoiceItemsQuery groupByAmount() Group by the amount column
 *
 * @method     ChildPluginInvoiceItemsQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildPluginInvoiceItemsQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildPluginInvoiceItemsQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildPluginInvoiceItems findOne(ConnectionInterface $con = null) Return the first ChildPluginInvoiceItems matching the query
 * @method     ChildPluginInvoiceItems findOneOrCreate(ConnectionInterface $con = null) Return the first ChildPluginInvoiceItems matching the query, or a new ChildPluginInvoiceItems object populated from the query conditions when no match is found
 *
 * @method     ChildPluginInvoiceItems findOneById(int $id) Return the first ChildPluginInvoiceItems filtered by the id column
 * @method     ChildPluginInvoiceItems findOneByInvoiceId(int $invoice_id) Return the first ChildPluginInvoiceItems filtered by the invoice_id column
 * @method     ChildPluginInvoiceItems findOneByTmp(string $tmp) Return the first ChildPluginInvoiceItems filtered by the tmp column
 * @method     ChildPluginInvoiceItems findOneByName(string $name) Return the first ChildPluginInvoiceItems filtered by the name column
 * @method     ChildPluginInvoiceItems findOneByDescription(string $description) Return the first ChildPluginInvoiceItems filtered by the description column
 * @method     ChildPluginInvoiceItems findOneByQty(string $qty) Return the first ChildPluginInvoiceItems filtered by the qty column
 * @method     ChildPluginInvoiceItems findOneByUnitPrice(string $unit_price) Return the first ChildPluginInvoiceItems filtered by the unit_price column
 * @method     ChildPluginInvoiceItems findOneByAmount(string $amount) Return the first ChildPluginInvoiceItems filtered by the amount column
 *
 * @method     array findById(int $id) Return ChildPluginInvoiceItems objects filtered by the id column
 * @method     array findByInvoiceId(int $invoice_id) Return ChildPluginInvoiceItems objects filtered by the invoice_id column
 * @method     array findByTmp(string $tmp) Return ChildPluginInvoiceItems objects filtered by the tmp column
 * @method     array findByName(string $name) Return ChildPluginInvoiceItems objects filtered by the name column
 * @method     array findByDescription(string $description) Return ChildPluginInvoiceItems objects filtered by the description column
 * @method     array findByQty(string $qty) Return ChildPluginInvoiceItems objects filtered by the qty column
 * @method     array findByUnitPrice(string $unit_price) Return ChildPluginInvoiceItems objects filtered by the unit_price column
 * @method     array findByAmount(string $amount) Return ChildPluginInvoiceItems objects filtered by the amount column
 *
 */
abstract class PluginInvoiceItemsQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \HookCalendar\Model\Base\PluginInvoiceItemsQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'thelia', $modelName = '\\HookCalendar\\Model\\PluginInvoiceItems', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildPluginInvoiceItemsQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildPluginInvoiceItemsQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \HookCalendar\Model\PluginInvoiceItemsQuery) {
            return $criteria;
        }
        $query = new \HookCalendar\Model\PluginInvoiceItemsQuery();
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
     * @return ChildPluginInvoiceItems|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = PluginInvoiceItemsTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(PluginInvoiceItemsTableMap::DATABASE_NAME);
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
     * @return   ChildPluginInvoiceItems A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ID, INVOICE_ID, TMP, NAME, DESCRIPTION, QTY, UNIT_PRICE, AMOUNT FROM plugin_invoice_items WHERE ID = :p0';
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
            $obj = new ChildPluginInvoiceItems();
            $obj->hydrate($row);
            PluginInvoiceItemsTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildPluginInvoiceItems|array|mixed the result, formatted by the current formatter
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
     * @return ChildPluginInvoiceItemsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(PluginInvoiceItemsTableMap::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildPluginInvoiceItemsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(PluginInvoiceItemsTableMap::ID, $keys, Criteria::IN);
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
     * @return ChildPluginInvoiceItemsQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(PluginInvoiceItemsTableMap::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(PluginInvoiceItemsTableMap::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PluginInvoiceItemsTableMap::ID, $id, $comparison);
    }

    /**
     * Filter the query on the invoice_id column
     *
     * Example usage:
     * <code>
     * $query->filterByInvoiceId(1234); // WHERE invoice_id = 1234
     * $query->filterByInvoiceId(array(12, 34)); // WHERE invoice_id IN (12, 34)
     * $query->filterByInvoiceId(array('min' => 12)); // WHERE invoice_id > 12
     * </code>
     *
     * @param     mixed $invoiceId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceItemsQuery The current query, for fluid interface
     */
    public function filterByInvoiceId($invoiceId = null, $comparison = null)
    {
        if (is_array($invoiceId)) {
            $useMinMax = false;
            if (isset($invoiceId['min'])) {
                $this->addUsingAlias(PluginInvoiceItemsTableMap::INVOICE_ID, $invoiceId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($invoiceId['max'])) {
                $this->addUsingAlias(PluginInvoiceItemsTableMap::INVOICE_ID, $invoiceId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PluginInvoiceItemsTableMap::INVOICE_ID, $invoiceId, $comparison);
    }

    /**
     * Filter the query on the tmp column
     *
     * Example usage:
     * <code>
     * $query->filterByTmp('fooValue');   // WHERE tmp = 'fooValue'
     * $query->filterByTmp('%fooValue%'); // WHERE tmp LIKE '%fooValue%'
     * </code>
     *
     * @param     string $tmp The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceItemsQuery The current query, for fluid interface
     */
    public function filterByTmp($tmp = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($tmp)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $tmp)) {
                $tmp = str_replace('*', '%', $tmp);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PluginInvoiceItemsTableMap::TMP, $tmp, $comparison);
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
     * @return ChildPluginInvoiceItemsQuery The current query, for fluid interface
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

        return $this->addUsingAlias(PluginInvoiceItemsTableMap::NAME, $name, $comparison);
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
     * @return ChildPluginInvoiceItemsQuery The current query, for fluid interface
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

        return $this->addUsingAlias(PluginInvoiceItemsTableMap::DESCRIPTION, $description, $comparison);
    }

    /**
     * Filter the query on the qty column
     *
     * Example usage:
     * <code>
     * $query->filterByQty(1234); // WHERE qty = 1234
     * $query->filterByQty(array(12, 34)); // WHERE qty IN (12, 34)
     * $query->filterByQty(array('min' => 12)); // WHERE qty > 12
     * </code>
     *
     * @param     mixed $qty The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceItemsQuery The current query, for fluid interface
     */
    public function filterByQty($qty = null, $comparison = null)
    {
        if (is_array($qty)) {
            $useMinMax = false;
            if (isset($qty['min'])) {
                $this->addUsingAlias(PluginInvoiceItemsTableMap::QTY, $qty['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($qty['max'])) {
                $this->addUsingAlias(PluginInvoiceItemsTableMap::QTY, $qty['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PluginInvoiceItemsTableMap::QTY, $qty, $comparison);
    }

    /**
     * Filter the query on the unit_price column
     *
     * Example usage:
     * <code>
     * $query->filterByUnitPrice(1234); // WHERE unit_price = 1234
     * $query->filterByUnitPrice(array(12, 34)); // WHERE unit_price IN (12, 34)
     * $query->filterByUnitPrice(array('min' => 12)); // WHERE unit_price > 12
     * </code>
     *
     * @param     mixed $unitPrice The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceItemsQuery The current query, for fluid interface
     */
    public function filterByUnitPrice($unitPrice = null, $comparison = null)
    {
        if (is_array($unitPrice)) {
            $useMinMax = false;
            if (isset($unitPrice['min'])) {
                $this->addUsingAlias(PluginInvoiceItemsTableMap::UNIT_PRICE, $unitPrice['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($unitPrice['max'])) {
                $this->addUsingAlias(PluginInvoiceItemsTableMap::UNIT_PRICE, $unitPrice['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PluginInvoiceItemsTableMap::UNIT_PRICE, $unitPrice, $comparison);
    }

    /**
     * Filter the query on the amount column
     *
     * Example usage:
     * <code>
     * $query->filterByAmount(1234); // WHERE amount = 1234
     * $query->filterByAmount(array(12, 34)); // WHERE amount IN (12, 34)
     * $query->filterByAmount(array('min' => 12)); // WHERE amount > 12
     * </code>
     *
     * @param     mixed $amount The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceItemsQuery The current query, for fluid interface
     */
    public function filterByAmount($amount = null, $comparison = null)
    {
        if (is_array($amount)) {
            $useMinMax = false;
            if (isset($amount['min'])) {
                $this->addUsingAlias(PluginInvoiceItemsTableMap::AMOUNT, $amount['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($amount['max'])) {
                $this->addUsingAlias(PluginInvoiceItemsTableMap::AMOUNT, $amount['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PluginInvoiceItemsTableMap::AMOUNT, $amount, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildPluginInvoiceItems $pluginInvoiceItems Object to remove from the list of results
     *
     * @return ChildPluginInvoiceItemsQuery The current query, for fluid interface
     */
    public function prune($pluginInvoiceItems = null)
    {
        if ($pluginInvoiceItems) {
            $this->addUsingAlias(PluginInvoiceItemsTableMap::ID, $pluginInvoiceItems->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the plugin_invoice_items table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PluginInvoiceItemsTableMap::DATABASE_NAME);
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
            PluginInvoiceItemsTableMap::clearInstancePool();
            PluginInvoiceItemsTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildPluginInvoiceItems or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildPluginInvoiceItems object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(PluginInvoiceItemsTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(PluginInvoiceItemsTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();


        PluginInvoiceItemsTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            PluginInvoiceItemsTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

} // PluginInvoiceItemsQuery
