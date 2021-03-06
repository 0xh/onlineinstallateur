<?php

namespace CronDashboard\Model\Base;

use \Exception;
use \PDO;
use CronDashboard\Model\CronJobs as ChildCronJobs;
use CronDashboard\Model\CronJobsQuery as ChildCronJobsQuery;
use CronDashboard\Model\Map\CronJobsTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'cron_jobs' table.
 *
 *
 *
 * @method     ChildCronJobsQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildCronJobsQuery orderByVisible($order = Criteria::ASC) Order by the visible column
 * @method     ChildCronJobsQuery orderByTitle($order = Criteria::ASC) Order by the title column
 * @method     ChildCronJobsQuery orderByCommand($order = Criteria::ASC) Order by the command column
 * @method     ChildCronJobsQuery orderBySchedule($order = Criteria::ASC) Order by the schedule column
 * @method     ChildCronJobsQuery orderByRunflag($order = Criteria::ASC) Order by the runflag column
 * @method     ChildCronJobsQuery orderByLastrun($order = Criteria::ASC) Order by the lastrun column
 * @method     ChildCronJobsQuery orderByNextrun($order = Criteria::ASC) Order by the nextrun column
 * @method     ChildCronJobsQuery orderByPosition($order = Criteria::ASC) Order by the position column
 * @method     ChildCronJobsQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildCronJobsQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method     ChildCronJobsQuery groupById() Group by the id column
 * @method     ChildCronJobsQuery groupByVisible() Group by the visible column
 * @method     ChildCronJobsQuery groupByTitle() Group by the title column
 * @method     ChildCronJobsQuery groupByCommand() Group by the command column
 * @method     ChildCronJobsQuery groupBySchedule() Group by the schedule column
 * @method     ChildCronJobsQuery groupByRunflag() Group by the runflag column
 * @method     ChildCronJobsQuery groupByLastrun() Group by the lastrun column
 * @method     ChildCronJobsQuery groupByNextrun() Group by the nextrun column
 * @method     ChildCronJobsQuery groupByPosition() Group by the position column
 * @method     ChildCronJobsQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildCronJobsQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method     ChildCronJobsQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildCronJobsQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildCronJobsQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildCronJobs findOne(ConnectionInterface $con = null) Return the first ChildCronJobs matching the query
 * @method     ChildCronJobs findOneOrCreate(ConnectionInterface $con = null) Return the first ChildCronJobs matching the query, or a new ChildCronJobs object populated from the query conditions when no match is found
 *
 * @method     ChildCronJobs findOneById(int $id) Return the first ChildCronJobs filtered by the id column
 * @method     ChildCronJobs findOneByVisible(int $visible) Return the first ChildCronJobs filtered by the visible column
 * @method     ChildCronJobs findOneByTitle(string $title) Return the first ChildCronJobs filtered by the title column
 * @method     ChildCronJobs findOneByCommand(string $command) Return the first ChildCronJobs filtered by the command column
 * @method     ChildCronJobs findOneBySchedule(string $schedule) Return the first ChildCronJobs filtered by the schedule column
 * @method     ChildCronJobs findOneByRunflag(int $runflag) Return the first ChildCronJobs filtered by the runflag column
 * @method     ChildCronJobs findOneByLastrun(string $lastrun) Return the first ChildCronJobs filtered by the lastrun column
 * @method     ChildCronJobs findOneByNextrun(string $nextrun) Return the first ChildCronJobs filtered by the nextrun column
 * @method     ChildCronJobs findOneByPosition(int $position) Return the first ChildCronJobs filtered by the position column
 * @method     ChildCronJobs findOneByCreatedAt(string $created_at) Return the first ChildCronJobs filtered by the created_at column
 * @method     ChildCronJobs findOneByUpdatedAt(string $updated_at) Return the first ChildCronJobs filtered by the updated_at column
 *
 * @method     array findById(int $id) Return ChildCronJobs objects filtered by the id column
 * @method     array findByVisible(int $visible) Return ChildCronJobs objects filtered by the visible column
 * @method     array findByTitle(string $title) Return ChildCronJobs objects filtered by the title column
 * @method     array findByCommand(string $command) Return ChildCronJobs objects filtered by the command column
 * @method     array findBySchedule(string $schedule) Return ChildCronJobs objects filtered by the schedule column
 * @method     array findByRunflag(int $runflag) Return ChildCronJobs objects filtered by the runflag column
 * @method     array findByLastrun(string $lastrun) Return ChildCronJobs objects filtered by the lastrun column
 * @method     array findByNextrun(string $nextrun) Return ChildCronJobs objects filtered by the nextrun column
 * @method     array findByPosition(int $position) Return ChildCronJobs objects filtered by the position column
 * @method     array findByCreatedAt(string $created_at) Return ChildCronJobs objects filtered by the created_at column
 * @method     array findByUpdatedAt(string $updated_at) Return ChildCronJobs objects filtered by the updated_at column
 *
 */
abstract class CronJobsQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \CronDashboard\Model\Base\CronJobsQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'thelia', $modelName = '\\CronDashboard\\Model\\CronJobs', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildCronJobsQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildCronJobsQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \CronDashboard\Model\CronJobsQuery) {
            return $criteria;
        }
        $query = new \CronDashboard\Model\CronJobsQuery();
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
     * @return ChildCronJobs|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = CronJobsTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(CronJobsTableMap::DATABASE_NAME);
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
     * @return   ChildCronJobs A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ID, VISIBLE, TITLE, COMMAND, SCHEDULE, RUNFLAG, LASTRUN, NEXTRUN, POSITION, CREATED_AT, UPDATED_AT FROM cron_jobs WHERE ID = :p0';
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
            $obj = new ChildCronJobs();
            $obj->hydrate($row);
            CronJobsTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildCronJobs|array|mixed the result, formatted by the current formatter
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
     * @return ChildCronJobsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(CronJobsTableMap::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildCronJobsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(CronJobsTableMap::ID, $keys, Criteria::IN);
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
     * @return ChildCronJobsQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(CronJobsTableMap::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(CronJobsTableMap::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CronJobsTableMap::ID, $id, $comparison);
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
     * @return ChildCronJobsQuery The current query, for fluid interface
     */
    public function filterByVisible($visible = null, $comparison = null)
    {
        if (is_array($visible)) {
            $useMinMax = false;
            if (isset($visible['min'])) {
                $this->addUsingAlias(CronJobsTableMap::VISIBLE, $visible['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($visible['max'])) {
                $this->addUsingAlias(CronJobsTableMap::VISIBLE, $visible['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CronJobsTableMap::VISIBLE, $visible, $comparison);
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
     * @return ChildCronJobsQuery The current query, for fluid interface
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

        return $this->addUsingAlias(CronJobsTableMap::TITLE, $title, $comparison);
    }

    /**
     * Filter the query on the command column
     *
     * Example usage:
     * <code>
     * $query->filterByCommand('fooValue');   // WHERE command = 'fooValue'
     * $query->filterByCommand('%fooValue%'); // WHERE command LIKE '%fooValue%'
     * </code>
     *
     * @param     string $command The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCronJobsQuery The current query, for fluid interface
     */
    public function filterByCommand($command = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($command)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $command)) {
                $command = str_replace('*', '%', $command);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(CronJobsTableMap::COMMAND, $command, $comparison);
    }

    /**
     * Filter the query on the schedule column
     *
     * Example usage:
     * <code>
     * $query->filterBySchedule('fooValue');   // WHERE schedule = 'fooValue'
     * $query->filterBySchedule('%fooValue%'); // WHERE schedule LIKE '%fooValue%'
     * </code>
     *
     * @param     string $schedule The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCronJobsQuery The current query, for fluid interface
     */
    public function filterBySchedule($schedule = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($schedule)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $schedule)) {
                $schedule = str_replace('*', '%', $schedule);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(CronJobsTableMap::SCHEDULE, $schedule, $comparison);
    }

    /**
     * Filter the query on the runflag column
     *
     * Example usage:
     * <code>
     * $query->filterByRunflag(1234); // WHERE runflag = 1234
     * $query->filterByRunflag(array(12, 34)); // WHERE runflag IN (12, 34)
     * $query->filterByRunflag(array('min' => 12)); // WHERE runflag > 12
     * </code>
     *
     * @param     mixed $runflag The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCronJobsQuery The current query, for fluid interface
     */
    public function filterByRunflag($runflag = null, $comparison = null)
    {
        if (is_array($runflag)) {
            $useMinMax = false;
            if (isset($runflag['min'])) {
                $this->addUsingAlias(CronJobsTableMap::RUNFLAG, $runflag['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($runflag['max'])) {
                $this->addUsingAlias(CronJobsTableMap::RUNFLAG, $runflag['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CronJobsTableMap::RUNFLAG, $runflag, $comparison);
    }

    /**
     * Filter the query on the lastrun column
     *
     * Example usage:
     * <code>
     * $query->filterByLastrun('2011-03-14'); // WHERE lastrun = '2011-03-14'
     * $query->filterByLastrun('now'); // WHERE lastrun = '2011-03-14'
     * $query->filterByLastrun(array('max' => 'yesterday')); // WHERE lastrun > '2011-03-13'
     * </code>
     *
     * @param     mixed $lastrun The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCronJobsQuery The current query, for fluid interface
     */
    public function filterByLastrun($lastrun = null, $comparison = null)
    {
        if (is_array($lastrun)) {
            $useMinMax = false;
            if (isset($lastrun['min'])) {
                $this->addUsingAlias(CronJobsTableMap::LASTRUN, $lastrun['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($lastrun['max'])) {
                $this->addUsingAlias(CronJobsTableMap::LASTRUN, $lastrun['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CronJobsTableMap::LASTRUN, $lastrun, $comparison);
    }

    /**
     * Filter the query on the nextrun column
     *
     * Example usage:
     * <code>
     * $query->filterByNextrun('2011-03-14'); // WHERE nextrun = '2011-03-14'
     * $query->filterByNextrun('now'); // WHERE nextrun = '2011-03-14'
     * $query->filterByNextrun(array('max' => 'yesterday')); // WHERE nextrun > '2011-03-13'
     * </code>
     *
     * @param     mixed $nextrun The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCronJobsQuery The current query, for fluid interface
     */
    public function filterByNextrun($nextrun = null, $comparison = null)
    {
        if (is_array($nextrun)) {
            $useMinMax = false;
            if (isset($nextrun['min'])) {
                $this->addUsingAlias(CronJobsTableMap::NEXTRUN, $nextrun['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($nextrun['max'])) {
                $this->addUsingAlias(CronJobsTableMap::NEXTRUN, $nextrun['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CronJobsTableMap::NEXTRUN, $nextrun, $comparison);
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
     * @return ChildCronJobsQuery The current query, for fluid interface
     */
    public function filterByPosition($position = null, $comparison = null)
    {
        if (is_array($position)) {
            $useMinMax = false;
            if (isset($position['min'])) {
                $this->addUsingAlias(CronJobsTableMap::POSITION, $position['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($position['max'])) {
                $this->addUsingAlias(CronJobsTableMap::POSITION, $position['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CronJobsTableMap::POSITION, $position, $comparison);
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
     * @return ChildCronJobsQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(CronJobsTableMap::CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(CronJobsTableMap::CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CronJobsTableMap::CREATED_AT, $createdAt, $comparison);
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
     * @return ChildCronJobsQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(CronJobsTableMap::UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(CronJobsTableMap::UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CronJobsTableMap::UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildCronJobs $cronJobs Object to remove from the list of results
     *
     * @return ChildCronJobsQuery The current query, for fluid interface
     */
    public function prune($cronJobs = null)
    {
        if ($cronJobs) {
            $this->addUsingAlias(CronJobsTableMap::ID, $cronJobs->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the cron_jobs table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CronJobsTableMap::DATABASE_NAME);
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
            CronJobsTableMap::clearInstancePool();
            CronJobsTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildCronJobs or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildCronJobs object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(CronJobsTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(CronJobsTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();


        CronJobsTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            CronJobsTableMap::clearRelatedInstancePool();
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
     * @return     ChildCronJobsQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(CronJobsTableMap::UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     ChildCronJobsQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(CronJobsTableMap::CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     ChildCronJobsQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(CronJobsTableMap::UPDATED_AT);
    }

    /**
     * Order by update date asc
     *
     * @return     ChildCronJobsQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(CronJobsTableMap::UPDATED_AT);
    }

    /**
     * Order by create date desc
     *
     * @return     ChildCronJobsQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(CronJobsTableMap::CREATED_AT);
    }

    /**
     * Order by create date asc
     *
     * @return     ChildCronJobsQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(CronJobsTableMap::CREATED_AT);
    }

} // CronJobsQuery
