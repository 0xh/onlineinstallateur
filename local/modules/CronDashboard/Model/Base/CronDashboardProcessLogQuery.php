<?php

namespace CronDashboard\Model\Base;

use \Exception;
use \PDO;
use CronDashboard\Model\CronDashboardProcessLog as ChildCronDashboardProcessLog;
use CronDashboard\Model\CronDashboardProcessLogQuery as ChildCronDashboardProcessLogQuery;
use CronDashboard\Model\Map\CronDashboardProcessLogTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'cron_dashboard_process_log' table.
 *
 *
 *
 * @method     ChildCronDashboardProcessLogQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildCronDashboardProcessLogQuery orderByLinuxUser($order = Criteria::ASC) Order by the linux_user column
 * @method     ChildCronDashboardProcessLogQuery orderByLinuxPid($order = Criteria::ASC) Order by the linux_PID column
 * @method     ChildCronDashboardProcessLogQuery orderByProcessName($order = Criteria::ASC) Order by the process_name column
 * @method     ChildCronDashboardProcessLogQuery orderByCpu($order = Criteria::ASC) Order by the cpu column
 * @method     ChildCronDashboardProcessLogQuery orderByMem($order = Criteria::ASC) Order by the mem column
 * @method     ChildCronDashboardProcessLogQuery orderByVsz($order = Criteria::ASC) Order by the vsz column
 * @method     ChildCronDashboardProcessLogQuery orderByTty($order = Criteria::ASC) Order by the tty column
 * @method     ChildCronDashboardProcessLogQuery orderByStat($order = Criteria::ASC) Order by the stat column
 * @method     ChildCronDashboardProcessLogQuery orderByStart($order = Criteria::ASC) Order by the start column
 * @method     ChildCronDashboardProcessLogQuery orderByTime($order = Criteria::ASC) Order by the time column
 * @method     ChildCronDashboardProcessLogQuery orderByCommand($order = Criteria::ASC) Order by the command column
 * @method     ChildCronDashboardProcessLogQuery orderByTheliaUserName($order = Criteria::ASC) Order by the thelia_user_name column
 * @method     ChildCronDashboardProcessLogQuery orderByTheliaUserId($order = Criteria::ASC) Order by the thelia_user_id column
 * @method     ChildCronDashboardProcessLogQuery orderByActionTriggered($order = Criteria::ASC) Order by the action_triggered column
 * @method     ChildCronDashboardProcessLogQuery orderByTriggerTime($order = Criteria::ASC) Order by the trigger_time column
 * @method     ChildCronDashboardProcessLogQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildCronDashboardProcessLogQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method     ChildCronDashboardProcessLogQuery groupById() Group by the id column
 * @method     ChildCronDashboardProcessLogQuery groupByLinuxUser() Group by the linux_user column
 * @method     ChildCronDashboardProcessLogQuery groupByLinuxPid() Group by the linux_PID column
 * @method     ChildCronDashboardProcessLogQuery groupByProcessName() Group by the process_name column
 * @method     ChildCronDashboardProcessLogQuery groupByCpu() Group by the cpu column
 * @method     ChildCronDashboardProcessLogQuery groupByMem() Group by the mem column
 * @method     ChildCronDashboardProcessLogQuery groupByVsz() Group by the vsz column
 * @method     ChildCronDashboardProcessLogQuery groupByTty() Group by the tty column
 * @method     ChildCronDashboardProcessLogQuery groupByStat() Group by the stat column
 * @method     ChildCronDashboardProcessLogQuery groupByStart() Group by the start column
 * @method     ChildCronDashboardProcessLogQuery groupByTime() Group by the time column
 * @method     ChildCronDashboardProcessLogQuery groupByCommand() Group by the command column
 * @method     ChildCronDashboardProcessLogQuery groupByTheliaUserName() Group by the thelia_user_name column
 * @method     ChildCronDashboardProcessLogQuery groupByTheliaUserId() Group by the thelia_user_id column
 * @method     ChildCronDashboardProcessLogQuery groupByActionTriggered() Group by the action_triggered column
 * @method     ChildCronDashboardProcessLogQuery groupByTriggerTime() Group by the trigger_time column
 * @method     ChildCronDashboardProcessLogQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildCronDashboardProcessLogQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method     ChildCronDashboardProcessLogQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildCronDashboardProcessLogQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildCronDashboardProcessLogQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildCronDashboardProcessLog findOne(ConnectionInterface $con = null) Return the first ChildCronDashboardProcessLog matching the query
 * @method     ChildCronDashboardProcessLog findOneOrCreate(ConnectionInterface $con = null) Return the first ChildCronDashboardProcessLog matching the query, or a new ChildCronDashboardProcessLog object populated from the query conditions when no match is found
 *
 * @method     ChildCronDashboardProcessLog findOneById(int $id) Return the first ChildCronDashboardProcessLog filtered by the id column
 * @method     ChildCronDashboardProcessLog findOneByLinuxUser(string $linux_user) Return the first ChildCronDashboardProcessLog filtered by the linux_user column
 * @method     ChildCronDashboardProcessLog findOneByLinuxPid(int $linux_PID) Return the first ChildCronDashboardProcessLog filtered by the linux_PID column
 * @method     ChildCronDashboardProcessLog findOneByProcessName(string $process_name) Return the first ChildCronDashboardProcessLog filtered by the process_name column
 * @method     ChildCronDashboardProcessLog findOneByCpu(string $cpu) Return the first ChildCronDashboardProcessLog filtered by the cpu column
 * @method     ChildCronDashboardProcessLog findOneByMem(string $mem) Return the first ChildCronDashboardProcessLog filtered by the mem column
 * @method     ChildCronDashboardProcessLog findOneByVsz(string $vsz) Return the first ChildCronDashboardProcessLog filtered by the vsz column
 * @method     ChildCronDashboardProcessLog findOneByTty(string $tty) Return the first ChildCronDashboardProcessLog filtered by the tty column
 * @method     ChildCronDashboardProcessLog findOneByStat(string $stat) Return the first ChildCronDashboardProcessLog filtered by the stat column
 * @method     ChildCronDashboardProcessLog findOneByStart(string $start) Return the first ChildCronDashboardProcessLog filtered by the start column
 * @method     ChildCronDashboardProcessLog findOneByTime(string $time) Return the first ChildCronDashboardProcessLog filtered by the time column
 * @method     ChildCronDashboardProcessLog findOneByCommand(string $command) Return the first ChildCronDashboardProcessLog filtered by the command column
 * @method     ChildCronDashboardProcessLog findOneByTheliaUserName(string $thelia_user_name) Return the first ChildCronDashboardProcessLog filtered by the thelia_user_name column
 * @method     ChildCronDashboardProcessLog findOneByTheliaUserId(int $thelia_user_id) Return the first ChildCronDashboardProcessLog filtered by the thelia_user_id column
 * @method     ChildCronDashboardProcessLog findOneByActionTriggered(string $action_triggered) Return the first ChildCronDashboardProcessLog filtered by the action_triggered column
 * @method     ChildCronDashboardProcessLog findOneByTriggerTime(string $trigger_time) Return the first ChildCronDashboardProcessLog filtered by the trigger_time column
 * @method     ChildCronDashboardProcessLog findOneByCreatedAt(string $created_at) Return the first ChildCronDashboardProcessLog filtered by the created_at column
 * @method     ChildCronDashboardProcessLog findOneByUpdatedAt(string $updated_at) Return the first ChildCronDashboardProcessLog filtered by the updated_at column
 *
 * @method     array findById(int $id) Return ChildCronDashboardProcessLog objects filtered by the id column
 * @method     array findByLinuxUser(string $linux_user) Return ChildCronDashboardProcessLog objects filtered by the linux_user column
 * @method     array findByLinuxPid(int $linux_PID) Return ChildCronDashboardProcessLog objects filtered by the linux_PID column
 * @method     array findByProcessName(string $process_name) Return ChildCronDashboardProcessLog objects filtered by the process_name column
 * @method     array findByCpu(string $cpu) Return ChildCronDashboardProcessLog objects filtered by the cpu column
 * @method     array findByMem(string $mem) Return ChildCronDashboardProcessLog objects filtered by the mem column
 * @method     array findByVsz(string $vsz) Return ChildCronDashboardProcessLog objects filtered by the vsz column
 * @method     array findByTty(string $tty) Return ChildCronDashboardProcessLog objects filtered by the tty column
 * @method     array findByStat(string $stat) Return ChildCronDashboardProcessLog objects filtered by the stat column
 * @method     array findByStart(string $start) Return ChildCronDashboardProcessLog objects filtered by the start column
 * @method     array findByTime(string $time) Return ChildCronDashboardProcessLog objects filtered by the time column
 * @method     array findByCommand(string $command) Return ChildCronDashboardProcessLog objects filtered by the command column
 * @method     array findByTheliaUserName(string $thelia_user_name) Return ChildCronDashboardProcessLog objects filtered by the thelia_user_name column
 * @method     array findByTheliaUserId(int $thelia_user_id) Return ChildCronDashboardProcessLog objects filtered by the thelia_user_id column
 * @method     array findByActionTriggered(string $action_triggered) Return ChildCronDashboardProcessLog objects filtered by the action_triggered column
 * @method     array findByTriggerTime(string $trigger_time) Return ChildCronDashboardProcessLog objects filtered by the trigger_time column
 * @method     array findByCreatedAt(string $created_at) Return ChildCronDashboardProcessLog objects filtered by the created_at column
 * @method     array findByUpdatedAt(string $updated_at) Return ChildCronDashboardProcessLog objects filtered by the updated_at column
 *
 */
abstract class CronDashboardProcessLogQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \CronDashboard\Model\Base\CronDashboardProcessLogQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'thelia', $modelName = '\\CronDashboard\\Model\\CronDashboardProcessLog', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildCronDashboardProcessLogQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildCronDashboardProcessLogQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \CronDashboard\Model\CronDashboardProcessLogQuery) {
            return $criteria;
        }
        $query = new \CronDashboard\Model\CronDashboardProcessLogQuery();
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
     * @return ChildCronDashboardProcessLog|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = CronDashboardProcessLogTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(CronDashboardProcessLogTableMap::DATABASE_NAME);
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
     * @return   ChildCronDashboardProcessLog A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ID, LINUX_USER, LINUX_PID, PROCESS_NAME, CPU, MEM, VSZ, TTY, STAT, START, TIME, COMMAND, THELIA_USER_NAME, THELIA_USER_ID, ACTION_TRIGGERED, TRIGGER_TIME, CREATED_AT, UPDATED_AT FROM cron_dashboard_process_log WHERE ID = :p0';
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
            $obj = new ChildCronDashboardProcessLog();
            $obj->hydrate($row);
            CronDashboardProcessLogTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildCronDashboardProcessLog|array|mixed the result, formatted by the current formatter
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
     * @return ChildCronDashboardProcessLogQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(CronDashboardProcessLogTableMap::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildCronDashboardProcessLogQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(CronDashboardProcessLogTableMap::ID, $keys, Criteria::IN);
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
     * @return ChildCronDashboardProcessLogQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(CronDashboardProcessLogTableMap::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(CronDashboardProcessLogTableMap::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CronDashboardProcessLogTableMap::ID, $id, $comparison);
    }

    /**
     * Filter the query on the linux_user column
     *
     * Example usage:
     * <code>
     * $query->filterByLinuxUser('fooValue');   // WHERE linux_user = 'fooValue'
     * $query->filterByLinuxUser('%fooValue%'); // WHERE linux_user LIKE '%fooValue%'
     * </code>
     *
     * @param     string $linuxUser The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCronDashboardProcessLogQuery The current query, for fluid interface
     */
    public function filterByLinuxUser($linuxUser = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($linuxUser)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $linuxUser)) {
                $linuxUser = str_replace('*', '%', $linuxUser);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(CronDashboardProcessLogTableMap::LINUX_USER, $linuxUser, $comparison);
    }

    /**
     * Filter the query on the linux_PID column
     *
     * Example usage:
     * <code>
     * $query->filterByLinuxPid(1234); // WHERE linux_PID = 1234
     * $query->filterByLinuxPid(array(12, 34)); // WHERE linux_PID IN (12, 34)
     * $query->filterByLinuxPid(array('min' => 12)); // WHERE linux_PID > 12
     * </code>
     *
     * @param     mixed $linuxPid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCronDashboardProcessLogQuery The current query, for fluid interface
     */
    public function filterByLinuxPid($linuxPid = null, $comparison = null)
    {
        if (is_array($linuxPid)) {
            $useMinMax = false;
            if (isset($linuxPid['min'])) {
                $this->addUsingAlias(CronDashboardProcessLogTableMap::LINUX_PID, $linuxPid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($linuxPid['max'])) {
                $this->addUsingAlias(CronDashboardProcessLogTableMap::LINUX_PID, $linuxPid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CronDashboardProcessLogTableMap::LINUX_PID, $linuxPid, $comparison);
    }

    /**
     * Filter the query on the process_name column
     *
     * Example usage:
     * <code>
     * $query->filterByProcessName('fooValue');   // WHERE process_name = 'fooValue'
     * $query->filterByProcessName('%fooValue%'); // WHERE process_name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $processName The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCronDashboardProcessLogQuery The current query, for fluid interface
     */
    public function filterByProcessName($processName = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($processName)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $processName)) {
                $processName = str_replace('*', '%', $processName);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(CronDashboardProcessLogTableMap::PROCESS_NAME, $processName, $comparison);
    }

    /**
     * Filter the query on the cpu column
     *
     * Example usage:
     * <code>
     * $query->filterByCpu('fooValue');   // WHERE cpu = 'fooValue'
     * $query->filterByCpu('%fooValue%'); // WHERE cpu LIKE '%fooValue%'
     * </code>
     *
     * @param     string $cpu The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCronDashboardProcessLogQuery The current query, for fluid interface
     */
    public function filterByCpu($cpu = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($cpu)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $cpu)) {
                $cpu = str_replace('*', '%', $cpu);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(CronDashboardProcessLogTableMap::CPU, $cpu, $comparison);
    }

    /**
     * Filter the query on the mem column
     *
     * Example usage:
     * <code>
     * $query->filterByMem('fooValue');   // WHERE mem = 'fooValue'
     * $query->filterByMem('%fooValue%'); // WHERE mem LIKE '%fooValue%'
     * </code>
     *
     * @param     string $mem The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCronDashboardProcessLogQuery The current query, for fluid interface
     */
    public function filterByMem($mem = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($mem)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $mem)) {
                $mem = str_replace('*', '%', $mem);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(CronDashboardProcessLogTableMap::MEM, $mem, $comparison);
    }

    /**
     * Filter the query on the vsz column
     *
     * Example usage:
     * <code>
     * $query->filterByVsz('fooValue');   // WHERE vsz = 'fooValue'
     * $query->filterByVsz('%fooValue%'); // WHERE vsz LIKE '%fooValue%'
     * </code>
     *
     * @param     string $vsz The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCronDashboardProcessLogQuery The current query, for fluid interface
     */
    public function filterByVsz($vsz = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($vsz)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $vsz)) {
                $vsz = str_replace('*', '%', $vsz);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(CronDashboardProcessLogTableMap::VSZ, $vsz, $comparison);
    }

    /**
     * Filter the query on the tty column
     *
     * Example usage:
     * <code>
     * $query->filterByTty('fooValue');   // WHERE tty = 'fooValue'
     * $query->filterByTty('%fooValue%'); // WHERE tty LIKE '%fooValue%'
     * </code>
     *
     * @param     string $tty The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCronDashboardProcessLogQuery The current query, for fluid interface
     */
    public function filterByTty($tty = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($tty)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $tty)) {
                $tty = str_replace('*', '%', $tty);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(CronDashboardProcessLogTableMap::TTY, $tty, $comparison);
    }

    /**
     * Filter the query on the stat column
     *
     * Example usage:
     * <code>
     * $query->filterByStat('fooValue');   // WHERE stat = 'fooValue'
     * $query->filterByStat('%fooValue%'); // WHERE stat LIKE '%fooValue%'
     * </code>
     *
     * @param     string $stat The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCronDashboardProcessLogQuery The current query, for fluid interface
     */
    public function filterByStat($stat = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($stat)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $stat)) {
                $stat = str_replace('*', '%', $stat);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(CronDashboardProcessLogTableMap::STAT, $stat, $comparison);
    }

    /**
     * Filter the query on the start column
     *
     * Example usage:
     * <code>
     * $query->filterByStart('fooValue');   // WHERE start = 'fooValue'
     * $query->filterByStart('%fooValue%'); // WHERE start LIKE '%fooValue%'
     * </code>
     *
     * @param     string $start The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCronDashboardProcessLogQuery The current query, for fluid interface
     */
    public function filterByStart($start = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($start)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $start)) {
                $start = str_replace('*', '%', $start);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(CronDashboardProcessLogTableMap::START, $start, $comparison);
    }

    /**
     * Filter the query on the time column
     *
     * Example usage:
     * <code>
     * $query->filterByTime('fooValue');   // WHERE time = 'fooValue'
     * $query->filterByTime('%fooValue%'); // WHERE time LIKE '%fooValue%'
     * </code>
     *
     * @param     string $time The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCronDashboardProcessLogQuery The current query, for fluid interface
     */
    public function filterByTime($time = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($time)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $time)) {
                $time = str_replace('*', '%', $time);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(CronDashboardProcessLogTableMap::TIME, $time, $comparison);
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
     * @return ChildCronDashboardProcessLogQuery The current query, for fluid interface
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

        return $this->addUsingAlias(CronDashboardProcessLogTableMap::COMMAND, $command, $comparison);
    }

    /**
     * Filter the query on the thelia_user_name column
     *
     * Example usage:
     * <code>
     * $query->filterByTheliaUserName('fooValue');   // WHERE thelia_user_name = 'fooValue'
     * $query->filterByTheliaUserName('%fooValue%'); // WHERE thelia_user_name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $theliaUserName The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCronDashboardProcessLogQuery The current query, for fluid interface
     */
    public function filterByTheliaUserName($theliaUserName = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($theliaUserName)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $theliaUserName)) {
                $theliaUserName = str_replace('*', '%', $theliaUserName);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(CronDashboardProcessLogTableMap::THELIA_USER_NAME, $theliaUserName, $comparison);
    }

    /**
     * Filter the query on the thelia_user_id column
     *
     * Example usage:
     * <code>
     * $query->filterByTheliaUserId(1234); // WHERE thelia_user_id = 1234
     * $query->filterByTheliaUserId(array(12, 34)); // WHERE thelia_user_id IN (12, 34)
     * $query->filterByTheliaUserId(array('min' => 12)); // WHERE thelia_user_id > 12
     * </code>
     *
     * @param     mixed $theliaUserId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCronDashboardProcessLogQuery The current query, for fluid interface
     */
    public function filterByTheliaUserId($theliaUserId = null, $comparison = null)
    {
        if (is_array($theliaUserId)) {
            $useMinMax = false;
            if (isset($theliaUserId['min'])) {
                $this->addUsingAlias(CronDashboardProcessLogTableMap::THELIA_USER_ID, $theliaUserId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($theliaUserId['max'])) {
                $this->addUsingAlias(CronDashboardProcessLogTableMap::THELIA_USER_ID, $theliaUserId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CronDashboardProcessLogTableMap::THELIA_USER_ID, $theliaUserId, $comparison);
    }

    /**
     * Filter the query on the action_triggered column
     *
     * Example usage:
     * <code>
     * $query->filterByActionTriggered('fooValue');   // WHERE action_triggered = 'fooValue'
     * $query->filterByActionTriggered('%fooValue%'); // WHERE action_triggered LIKE '%fooValue%'
     * </code>
     *
     * @param     string $actionTriggered The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCronDashboardProcessLogQuery The current query, for fluid interface
     */
    public function filterByActionTriggered($actionTriggered = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($actionTriggered)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $actionTriggered)) {
                $actionTriggered = str_replace('*', '%', $actionTriggered);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(CronDashboardProcessLogTableMap::ACTION_TRIGGERED, $actionTriggered, $comparison);
    }

    /**
     * Filter the query on the trigger_time column
     *
     * Example usage:
     * <code>
     * $query->filterByTriggerTime('2011-03-14'); // WHERE trigger_time = '2011-03-14'
     * $query->filterByTriggerTime('now'); // WHERE trigger_time = '2011-03-14'
     * $query->filterByTriggerTime(array('max' => 'yesterday')); // WHERE trigger_time > '2011-03-13'
     * </code>
     *
     * @param     mixed $triggerTime The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCronDashboardProcessLogQuery The current query, for fluid interface
     */
    public function filterByTriggerTime($triggerTime = null, $comparison = null)
    {
        if (is_array($triggerTime)) {
            $useMinMax = false;
            if (isset($triggerTime['min'])) {
                $this->addUsingAlias(CronDashboardProcessLogTableMap::TRIGGER_TIME, $triggerTime['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($triggerTime['max'])) {
                $this->addUsingAlias(CronDashboardProcessLogTableMap::TRIGGER_TIME, $triggerTime['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CronDashboardProcessLogTableMap::TRIGGER_TIME, $triggerTime, $comparison);
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
     * @return ChildCronDashboardProcessLogQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(CronDashboardProcessLogTableMap::CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(CronDashboardProcessLogTableMap::CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CronDashboardProcessLogTableMap::CREATED_AT, $createdAt, $comparison);
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
     * @return ChildCronDashboardProcessLogQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(CronDashboardProcessLogTableMap::UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(CronDashboardProcessLogTableMap::UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CronDashboardProcessLogTableMap::UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildCronDashboardProcessLog $cronDashboardProcessLog Object to remove from the list of results
     *
     * @return ChildCronDashboardProcessLogQuery The current query, for fluid interface
     */
    public function prune($cronDashboardProcessLog = null)
    {
        if ($cronDashboardProcessLog) {
            $this->addUsingAlias(CronDashboardProcessLogTableMap::ID, $cronDashboardProcessLog->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the cron_dashboard_process_log table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CronDashboardProcessLogTableMap::DATABASE_NAME);
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
            CronDashboardProcessLogTableMap::clearInstancePool();
            CronDashboardProcessLogTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildCronDashboardProcessLog or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildCronDashboardProcessLog object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(CronDashboardProcessLogTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(CronDashboardProcessLogTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();


        CronDashboardProcessLogTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            CronDashboardProcessLogTableMap::clearRelatedInstancePool();
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
     * @return     ChildCronDashboardProcessLogQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(CronDashboardProcessLogTableMap::UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     ChildCronDashboardProcessLogQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(CronDashboardProcessLogTableMap::CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     ChildCronDashboardProcessLogQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(CronDashboardProcessLogTableMap::UPDATED_AT);
    }

    /**
     * Order by update date asc
     *
     * @return     ChildCronDashboardProcessLogQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(CronDashboardProcessLogTableMap::UPDATED_AT);
    }

    /**
     * Order by create date desc
     *
     * @return     ChildCronDashboardProcessLogQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(CronDashboardProcessLogTableMap::CREATED_AT);
    }

    /**
     * Order by create date asc
     *
     * @return     ChildCronDashboardProcessLogQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(CronDashboardProcessLogTableMap::CREATED_AT);
    }

} // CronDashboardProcessLogQuery
