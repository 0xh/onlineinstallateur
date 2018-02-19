<?php

namespace HookCalendar\Model\Base;

use \Exception;
use \PDO;
use HookCalendar\Model\PluginLocaleLanguages as ChildPluginLocaleLanguages;
use HookCalendar\Model\PluginLocaleLanguagesQuery as ChildPluginLocaleLanguagesQuery;
use HookCalendar\Model\Map\PluginLocaleLanguagesTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'plugin_locale_languages' table.
 *
 *
 *
 * @method     ChildPluginLocaleLanguagesQuery orderByIso($order = Criteria::ASC) Order by the iso column
 * @method     ChildPluginLocaleLanguagesQuery orderByTitle($order = Criteria::ASC) Order by the title column
 * @method     ChildPluginLocaleLanguagesQuery orderByFile($order = Criteria::ASC) Order by the file column
 *
 * @method     ChildPluginLocaleLanguagesQuery groupByIso() Group by the iso column
 * @method     ChildPluginLocaleLanguagesQuery groupByTitle() Group by the title column
 * @method     ChildPluginLocaleLanguagesQuery groupByFile() Group by the file column
 *
 * @method     ChildPluginLocaleLanguagesQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildPluginLocaleLanguagesQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildPluginLocaleLanguagesQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildPluginLocaleLanguages findOne(ConnectionInterface $con = null) Return the first ChildPluginLocaleLanguages matching the query
 * @method     ChildPluginLocaleLanguages findOneOrCreate(ConnectionInterface $con = null) Return the first ChildPluginLocaleLanguages matching the query, or a new ChildPluginLocaleLanguages object populated from the query conditions when no match is found
 *
 * @method     ChildPluginLocaleLanguages findOneByIso(string $iso) Return the first ChildPluginLocaleLanguages filtered by the iso column
 * @method     ChildPluginLocaleLanguages findOneByTitle(string $title) Return the first ChildPluginLocaleLanguages filtered by the title column
 * @method     ChildPluginLocaleLanguages findOneByFile(string $file) Return the first ChildPluginLocaleLanguages filtered by the file column
 *
 * @method     array findByIso(string $iso) Return ChildPluginLocaleLanguages objects filtered by the iso column
 * @method     array findByTitle(string $title) Return ChildPluginLocaleLanguages objects filtered by the title column
 * @method     array findByFile(string $file) Return ChildPluginLocaleLanguages objects filtered by the file column
 *
 */
abstract class PluginLocaleLanguagesQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \HookCalendar\Model\Base\PluginLocaleLanguagesQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'thelia', $modelName = '\\HookCalendar\\Model\\PluginLocaleLanguages', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildPluginLocaleLanguagesQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildPluginLocaleLanguagesQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \HookCalendar\Model\PluginLocaleLanguagesQuery) {
            return $criteria;
        }
        $query = new \HookCalendar\Model\PluginLocaleLanguagesQuery();
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
     * @return ChildPluginLocaleLanguages|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = PluginLocaleLanguagesTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(PluginLocaleLanguagesTableMap::DATABASE_NAME);
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
     * @return   ChildPluginLocaleLanguages A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ISO, TITLE, FILE FROM plugin_locale_languages WHERE ISO = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_STR);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            $obj = new ChildPluginLocaleLanguages();
            $obj->hydrate($row);
            PluginLocaleLanguagesTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildPluginLocaleLanguages|array|mixed the result, formatted by the current formatter
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
     * @return ChildPluginLocaleLanguagesQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(PluginLocaleLanguagesTableMap::ISO, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildPluginLocaleLanguagesQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(PluginLocaleLanguagesTableMap::ISO, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the iso column
     *
     * Example usage:
     * <code>
     * $query->filterByIso('fooValue');   // WHERE iso = 'fooValue'
     * $query->filterByIso('%fooValue%'); // WHERE iso LIKE '%fooValue%'
     * </code>
     *
     * @param     string $iso The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginLocaleLanguagesQuery The current query, for fluid interface
     */
    public function filterByIso($iso = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($iso)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $iso)) {
                $iso = str_replace('*', '%', $iso);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PluginLocaleLanguagesTableMap::ISO, $iso, $comparison);
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
     * @return ChildPluginLocaleLanguagesQuery The current query, for fluid interface
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

        return $this->addUsingAlias(PluginLocaleLanguagesTableMap::TITLE, $title, $comparison);
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
     * @return ChildPluginLocaleLanguagesQuery The current query, for fluid interface
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

        return $this->addUsingAlias(PluginLocaleLanguagesTableMap::FILE, $file, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildPluginLocaleLanguages $pluginLocaleLanguages Object to remove from the list of results
     *
     * @return ChildPluginLocaleLanguagesQuery The current query, for fluid interface
     */
    public function prune($pluginLocaleLanguages = null)
    {
        if ($pluginLocaleLanguages) {
            $this->addUsingAlias(PluginLocaleLanguagesTableMap::ISO, $pluginLocaleLanguages->getIso(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the plugin_locale_languages table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PluginLocaleLanguagesTableMap::DATABASE_NAME);
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
            PluginLocaleLanguagesTableMap::clearInstancePool();
            PluginLocaleLanguagesTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildPluginLocaleLanguages or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildPluginLocaleLanguages object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(PluginLocaleLanguagesTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(PluginLocaleLanguagesTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();


        PluginLocaleLanguagesTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            PluginLocaleLanguagesTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

} // PluginLocaleLanguagesQuery
