<?php

namespace Carousel\Model\Base;

use \Exception;
use \PDO;
use Carousel\Model\CarouselVersion as ChildCarouselVersion;
use Carousel\Model\CarouselVersionQuery as ChildCarouselVersionQuery;
use Carousel\Model\Map\CarouselVersionTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'carousel_version' table.
 *
 * 
 *
 * @method     ChildCarouselVersionQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildCarouselVersionQuery orderByCarouselId($order = Criteria::ASC) Order by the carousel_id column
 * @method     ChildCarouselVersionQuery orderByVisible($order = Criteria::ASC) Order by the visible column
 * @method     ChildCarouselVersionQuery orderByFile($order = Criteria::ASC) Order by the file column
 * @method     ChildCarouselVersionQuery orderByPosition($order = Criteria::ASC) Order by the position column
 * @method     ChildCarouselVersionQuery orderByUrl($order = Criteria::ASC) Order by the url column
 * @method     ChildCarouselVersionQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildCarouselVersionQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 * @method     ChildCarouselVersionQuery orderByVersion($order = Criteria::ASC) Order by the version column
 * @method     ChildCarouselVersionQuery orderByVersionCreatedAt($order = Criteria::ASC) Order by the version_created_at column
 * @method     ChildCarouselVersionQuery orderByVersionCreatedBy($order = Criteria::ASC) Order by the version_created_by column
 * @method     ChildCarouselVersionQuery orderByCarouselIdVersion($order = Criteria::ASC) Order by the carousel_id_version column
 *
 * @method     ChildCarouselVersionQuery groupById() Group by the id column
 * @method     ChildCarouselVersionQuery groupByCarouselId() Group by the carousel_id column
 * @method     ChildCarouselVersionQuery groupByVisible() Group by the visible column
 * @method     ChildCarouselVersionQuery groupByFile() Group by the file column
 * @method     ChildCarouselVersionQuery groupByPosition() Group by the position column
 * @method     ChildCarouselVersionQuery groupByUrl() Group by the url column
 * @method     ChildCarouselVersionQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildCarouselVersionQuery groupByUpdatedAt() Group by the updated_at column
 * @method     ChildCarouselVersionQuery groupByVersion() Group by the version column
 * @method     ChildCarouselVersionQuery groupByVersionCreatedAt() Group by the version_created_at column
 * @method     ChildCarouselVersionQuery groupByVersionCreatedBy() Group by the version_created_by column
 * @method     ChildCarouselVersionQuery groupByCarouselIdVersion() Group by the carousel_id_version column
 *
 * @method     ChildCarouselVersionQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildCarouselVersionQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildCarouselVersionQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildCarouselVersionQuery leftJoinCarousel($relationAlias = null) Adds a LEFT JOIN clause to the query using the Carousel relation
 * @method     ChildCarouselVersionQuery rightJoinCarousel($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Carousel relation
 * @method     ChildCarouselVersionQuery innerJoinCarousel($relationAlias = null) Adds a INNER JOIN clause to the query using the Carousel relation
 *
 * @method     ChildCarouselVersion findOne(ConnectionInterface $con = null) Return the first ChildCarouselVersion matching the query
 * @method     ChildCarouselVersion findOneOrCreate(ConnectionInterface $con = null) Return the first ChildCarouselVersion matching the query, or a new ChildCarouselVersion object populated from the query conditions when no match is found
 *
 * @method     ChildCarouselVersion findOneById(int $id) Return the first ChildCarouselVersion filtered by the id column
 * @method     ChildCarouselVersion findOneByCarouselId(int $carousel_id) Return the first ChildCarouselVersion filtered by the carousel_id column
 * @method     ChildCarouselVersion findOneByVisible(int $visible) Return the first ChildCarouselVersion filtered by the visible column
 * @method     ChildCarouselVersion findOneByFile(string $file) Return the first ChildCarouselVersion filtered by the file column
 * @method     ChildCarouselVersion findOneByPosition(int $position) Return the first ChildCarouselVersion filtered by the position column
 * @method     ChildCarouselVersion findOneByUrl(string $url) Return the first ChildCarouselVersion filtered by the url column
 * @method     ChildCarouselVersion findOneByCreatedAt(string $created_at) Return the first ChildCarouselVersion filtered by the created_at column
 * @method     ChildCarouselVersion findOneByUpdatedAt(string $updated_at) Return the first ChildCarouselVersion filtered by the updated_at column
 * @method     ChildCarouselVersion findOneByVersion(int $version) Return the first ChildCarouselVersion filtered by the version column
 * @method     ChildCarouselVersion findOneByVersionCreatedAt(string $version_created_at) Return the first ChildCarouselVersion filtered by the version_created_at column
 * @method     ChildCarouselVersion findOneByVersionCreatedBy(string $version_created_by) Return the first ChildCarouselVersion filtered by the version_created_by column
 * @method     ChildCarouselVersion findOneByCarouselIdVersion(int $carousel_id_version) Return the first ChildCarouselVersion filtered by the carousel_id_version column
 *
 * @method     array findById(int $id) Return ChildCarouselVersion objects filtered by the id column
 * @method     array findByCarouselId(int $carousel_id) Return ChildCarouselVersion objects filtered by the carousel_id column
 * @method     array findByVisible(int $visible) Return ChildCarouselVersion objects filtered by the visible column
 * @method     array findByFile(string $file) Return ChildCarouselVersion objects filtered by the file column
 * @method     array findByPosition(int $position) Return ChildCarouselVersion objects filtered by the position column
 * @method     array findByUrl(string $url) Return ChildCarouselVersion objects filtered by the url column
 * @method     array findByCreatedAt(string $created_at) Return ChildCarouselVersion objects filtered by the created_at column
 * @method     array findByUpdatedAt(string $updated_at) Return ChildCarouselVersion objects filtered by the updated_at column
 * @method     array findByVersion(int $version) Return ChildCarouselVersion objects filtered by the version column
 * @method     array findByVersionCreatedAt(string $version_created_at) Return ChildCarouselVersion objects filtered by the version_created_at column
 * @method     array findByVersionCreatedBy(string $version_created_by) Return ChildCarouselVersion objects filtered by the version_created_by column
 * @method     array findByCarouselIdVersion(int $carousel_id_version) Return ChildCarouselVersion objects filtered by the carousel_id_version column
 *
 */
abstract class CarouselVersionQuery extends ModelCriteria
{
    
    /**
     * Initializes internal state of \Carousel\Model\Base\CarouselVersionQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'thelia', $modelName = '\\Carousel\\Model\\CarouselVersion', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildCarouselVersionQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildCarouselVersionQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \Carousel\Model\CarouselVersionQuery) {
            return $criteria;
        }
        $query = new \Carousel\Model\CarouselVersionQuery();
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
     * $obj = $c->findPk(array(12, 34), $con);
     * </code>
     *
     * @param array[$id, $version] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildCarouselVersion|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = CarouselVersionTableMap::getInstanceFromPool(serialize(array((string) $key[0], (string) $key[1]))))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(CarouselVersionTableMap::DATABASE_NAME);
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
     * @return   ChildCarouselVersion A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ID, CAROUSEL_ID, VISIBLE, FILE, POSITION, URL, CREATED_AT, UPDATED_AT, VERSION, VERSION_CREATED_AT, VERSION_CREATED_BY, CAROUSEL_ID_VERSION FROM carousel_version WHERE ID = :p0 AND VERSION = :p1';
        try {
            $stmt = $con->prepare($sql);            
            $stmt->bindValue(':p0', $key[0], PDO::PARAM_INT);            
            $stmt->bindValue(':p1', $key[1], PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            $obj = new ChildCarouselVersion();
            $obj->hydrate($row);
            CarouselVersionTableMap::addInstanceToPool($obj, serialize(array((string) $key[0], (string) $key[1])));
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
     * @return ChildCarouselVersion|array|mixed the result, formatted by the current formatter
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
     * $objs = $c->findPks(array(array(12, 56), array(832, 123), array(123, 456)), $con);
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
     * @return ChildCarouselVersionQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(CarouselVersionTableMap::ID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(CarouselVersionTableMap::VERSION, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildCarouselVersionQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(CarouselVersionTableMap::ID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(CarouselVersionTableMap::VERSION, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $this->addOr($cton0);
        }

        return $this;
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
     * @see       filterByCarousel()
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCarouselVersionQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(CarouselVersionTableMap::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(CarouselVersionTableMap::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CarouselVersionTableMap::ID, $id, $comparison);
    }

    /**
     * Filter the query on the carousel_id column
     *
     * Example usage:
     * <code>
     * $query->filterByCarouselId(1234); // WHERE carousel_id = 1234
     * $query->filterByCarouselId(array(12, 34)); // WHERE carousel_id IN (12, 34)
     * $query->filterByCarouselId(array('min' => 12)); // WHERE carousel_id > 12
     * </code>
     *
     * @param     mixed $carouselId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCarouselVersionQuery The current query, for fluid interface
     */
    public function filterByCarouselId($carouselId = null, $comparison = null)
    {
        if (is_array($carouselId)) {
            $useMinMax = false;
            if (isset($carouselId['min'])) {
                $this->addUsingAlias(CarouselVersionTableMap::CAROUSEL_ID, $carouselId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($carouselId['max'])) {
                $this->addUsingAlias(CarouselVersionTableMap::CAROUSEL_ID, $carouselId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CarouselVersionTableMap::CAROUSEL_ID, $carouselId, $comparison);
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
     * @return ChildCarouselVersionQuery The current query, for fluid interface
     */
    public function filterByVisible($visible = null, $comparison = null)
    {
        if (is_array($visible)) {
            $useMinMax = false;
            if (isset($visible['min'])) {
                $this->addUsingAlias(CarouselVersionTableMap::VISIBLE, $visible['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($visible['max'])) {
                $this->addUsingAlias(CarouselVersionTableMap::VISIBLE, $visible['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CarouselVersionTableMap::VISIBLE, $visible, $comparison);
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
     * @return ChildCarouselVersionQuery The current query, for fluid interface
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

        return $this->addUsingAlias(CarouselVersionTableMap::FILE, $file, $comparison);
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
     * @return ChildCarouselVersionQuery The current query, for fluid interface
     */
    public function filterByPosition($position = null, $comparison = null)
    {
        if (is_array($position)) {
            $useMinMax = false;
            if (isset($position['min'])) {
                $this->addUsingAlias(CarouselVersionTableMap::POSITION, $position['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($position['max'])) {
                $this->addUsingAlias(CarouselVersionTableMap::POSITION, $position['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CarouselVersionTableMap::POSITION, $position, $comparison);
    }

    /**
     * Filter the query on the url column
     *
     * Example usage:
     * <code>
     * $query->filterByUrl('fooValue');   // WHERE url = 'fooValue'
     * $query->filterByUrl('%fooValue%'); // WHERE url LIKE '%fooValue%'
     * </code>
     *
     * @param     string $url The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCarouselVersionQuery The current query, for fluid interface
     */
    public function filterByUrl($url = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($url)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $url)) {
                $url = str_replace('*', '%', $url);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(CarouselVersionTableMap::URL, $url, $comparison);
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
     * @return ChildCarouselVersionQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(CarouselVersionTableMap::CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(CarouselVersionTableMap::CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CarouselVersionTableMap::CREATED_AT, $createdAt, $comparison);
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
     * @return ChildCarouselVersionQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(CarouselVersionTableMap::UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(CarouselVersionTableMap::UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CarouselVersionTableMap::UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Filter the query on the version column
     *
     * Example usage:
     * <code>
     * $query->filterByVersion(1234); // WHERE version = 1234
     * $query->filterByVersion(array(12, 34)); // WHERE version IN (12, 34)
     * $query->filterByVersion(array('min' => 12)); // WHERE version > 12
     * </code>
     *
     * @param     mixed $version The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCarouselVersionQuery The current query, for fluid interface
     */
    public function filterByVersion($version = null, $comparison = null)
    {
        if (is_array($version)) {
            $useMinMax = false;
            if (isset($version['min'])) {
                $this->addUsingAlias(CarouselVersionTableMap::VERSION, $version['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($version['max'])) {
                $this->addUsingAlias(CarouselVersionTableMap::VERSION, $version['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CarouselVersionTableMap::VERSION, $version, $comparison);
    }

    /**
     * Filter the query on the version_created_at column
     *
     * Example usage:
     * <code>
     * $query->filterByVersionCreatedAt('2011-03-14'); // WHERE version_created_at = '2011-03-14'
     * $query->filterByVersionCreatedAt('now'); // WHERE version_created_at = '2011-03-14'
     * $query->filterByVersionCreatedAt(array('max' => 'yesterday')); // WHERE version_created_at > '2011-03-13'
     * </code>
     *
     * @param     mixed $versionCreatedAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCarouselVersionQuery The current query, for fluid interface
     */
    public function filterByVersionCreatedAt($versionCreatedAt = null, $comparison = null)
    {
        if (is_array($versionCreatedAt)) {
            $useMinMax = false;
            if (isset($versionCreatedAt['min'])) {
                $this->addUsingAlias(CarouselVersionTableMap::VERSION_CREATED_AT, $versionCreatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($versionCreatedAt['max'])) {
                $this->addUsingAlias(CarouselVersionTableMap::VERSION_CREATED_AT, $versionCreatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CarouselVersionTableMap::VERSION_CREATED_AT, $versionCreatedAt, $comparison);
    }

    /**
     * Filter the query on the version_created_by column
     *
     * Example usage:
     * <code>
     * $query->filterByVersionCreatedBy('fooValue');   // WHERE version_created_by = 'fooValue'
     * $query->filterByVersionCreatedBy('%fooValue%'); // WHERE version_created_by LIKE '%fooValue%'
     * </code>
     *
     * @param     string $versionCreatedBy The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCarouselVersionQuery The current query, for fluid interface
     */
    public function filterByVersionCreatedBy($versionCreatedBy = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($versionCreatedBy)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $versionCreatedBy)) {
                $versionCreatedBy = str_replace('*', '%', $versionCreatedBy);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(CarouselVersionTableMap::VERSION_CREATED_BY, $versionCreatedBy, $comparison);
    }

    /**
     * Filter the query on the carousel_id_version column
     *
     * Example usage:
     * <code>
     * $query->filterByCarouselIdVersion(1234); // WHERE carousel_id_version = 1234
     * $query->filterByCarouselIdVersion(array(12, 34)); // WHERE carousel_id_version IN (12, 34)
     * $query->filterByCarouselIdVersion(array('min' => 12)); // WHERE carousel_id_version > 12
     * </code>
     *
     * @param     mixed $carouselIdVersion The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCarouselVersionQuery The current query, for fluid interface
     */
    public function filterByCarouselIdVersion($carouselIdVersion = null, $comparison = null)
    {
        if (is_array($carouselIdVersion)) {
            $useMinMax = false;
            if (isset($carouselIdVersion['min'])) {
                $this->addUsingAlias(CarouselVersionTableMap::CAROUSEL_ID_VERSION, $carouselIdVersion['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($carouselIdVersion['max'])) {
                $this->addUsingAlias(CarouselVersionTableMap::CAROUSEL_ID_VERSION, $carouselIdVersion['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CarouselVersionTableMap::CAROUSEL_ID_VERSION, $carouselIdVersion, $comparison);
    }

    /**
     * Filter the query by a related \Carousel\Model\Carousel object
     *
     * @param \Carousel\Model\Carousel|ObjectCollection $carousel The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCarouselVersionQuery The current query, for fluid interface
     */
    public function filterByCarousel($carousel, $comparison = null)
    {
        if ($carousel instanceof \Carousel\Model\Carousel) {
            return $this
                ->addUsingAlias(CarouselVersionTableMap::ID, $carousel->getId(), $comparison);
        } elseif ($carousel instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(CarouselVersionTableMap::ID, $carousel->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByCarousel() only accepts arguments of type \Carousel\Model\Carousel or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Carousel relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildCarouselVersionQuery The current query, for fluid interface
     */
    public function joinCarousel($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Carousel');

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
            $this->addJoinObject($join, 'Carousel');
        }

        return $this;
    }

    /**
     * Use the Carousel relation Carousel object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Carousel\Model\CarouselQuery A secondary query class using the current class as primary query
     */
    public function useCarouselQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinCarousel($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Carousel', '\Carousel\Model\CarouselQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildCarouselVersion $carouselVersion Object to remove from the list of results
     *
     * @return ChildCarouselVersionQuery The current query, for fluid interface
     */
    public function prune($carouselVersion = null)
    {
        if ($carouselVersion) {
            $this->addCond('pruneCond0', $this->getAliasedColName(CarouselVersionTableMap::ID), $carouselVersion->getId(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(CarouselVersionTableMap::VERSION), $carouselVersion->getVersion(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the carousel_version table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CarouselVersionTableMap::DATABASE_NAME);
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
            CarouselVersionTableMap::clearInstancePool();
            CarouselVersionTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildCarouselVersion or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildCarouselVersion object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(CarouselVersionTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(CarouselVersionTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            

        CarouselVersionTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            CarouselVersionTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

} // CarouselVersionQuery
