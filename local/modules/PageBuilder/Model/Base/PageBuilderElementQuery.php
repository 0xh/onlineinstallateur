<?php

namespace PageBuilder\Model\Base;

use \Exception;
use \PDO;
use PageBuilder\Model\PageBuilderElement as ChildPageBuilderElement;
use PageBuilder\Model\PageBuilderElementI18nQuery as ChildPageBuilderElementI18nQuery;
use PageBuilder\Model\PageBuilderElementQuery as ChildPageBuilderElementQuery;
use PageBuilder\Model\Map\PageBuilderElementTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'page_builder_element' table.
 *
 * 
 *
 * @method     ChildPageBuilderElementQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildPageBuilderElementQuery orderByPageBuilderId($order = Criteria::ASC) Order by the page_builder_id column
 * @method     ChildPageBuilderElementQuery orderByVisible($order = Criteria::ASC) Order by the visible column
 * @method     ChildPageBuilderElementQuery orderByPosition($order = Criteria::ASC) Order by the position column
 * @method     ChildPageBuilderElementQuery orderByTemplateName($order = Criteria::ASC) Order by the template_name column
 * @method     ChildPageBuilderElementQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildPageBuilderElementQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 * @method     ChildPageBuilderElementQuery orderByVersion($order = Criteria::ASC) Order by the version column
 * @method     ChildPageBuilderElementQuery orderByVersionCreatedAt($order = Criteria::ASC) Order by the version_created_at column
 * @method     ChildPageBuilderElementQuery orderByVersionCreatedBy($order = Criteria::ASC) Order by the version_created_by column
 *
 * @method     ChildPageBuilderElementQuery groupById() Group by the id column
 * @method     ChildPageBuilderElementQuery groupByPageBuilderId() Group by the page_builder_id column
 * @method     ChildPageBuilderElementQuery groupByVisible() Group by the visible column
 * @method     ChildPageBuilderElementQuery groupByPosition() Group by the position column
 * @method     ChildPageBuilderElementQuery groupByTemplateName() Group by the template_name column
 * @method     ChildPageBuilderElementQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildPageBuilderElementQuery groupByUpdatedAt() Group by the updated_at column
 * @method     ChildPageBuilderElementQuery groupByVersion() Group by the version column
 * @method     ChildPageBuilderElementQuery groupByVersionCreatedAt() Group by the version_created_at column
 * @method     ChildPageBuilderElementQuery groupByVersionCreatedBy() Group by the version_created_by column
 *
 * @method     ChildPageBuilderElementQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildPageBuilderElementQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildPageBuilderElementQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildPageBuilderElementQuery leftJoinPageBuilder($relationAlias = null) Adds a LEFT JOIN clause to the query using the PageBuilder relation
 * @method     ChildPageBuilderElementQuery rightJoinPageBuilder($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PageBuilder relation
 * @method     ChildPageBuilderElementQuery innerJoinPageBuilder($relationAlias = null) Adds a INNER JOIN clause to the query using the PageBuilder relation
 *
 * @method     ChildPageBuilderElementQuery leftJoinPageBuilderElementI18n($relationAlias = null) Adds a LEFT JOIN clause to the query using the PageBuilderElementI18n relation
 * @method     ChildPageBuilderElementQuery rightJoinPageBuilderElementI18n($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PageBuilderElementI18n relation
 * @method     ChildPageBuilderElementQuery innerJoinPageBuilderElementI18n($relationAlias = null) Adds a INNER JOIN clause to the query using the PageBuilderElementI18n relation
 *
 * @method     ChildPageBuilderElementQuery leftJoinPageBuilderElementVersion($relationAlias = null) Adds a LEFT JOIN clause to the query using the PageBuilderElementVersion relation
 * @method     ChildPageBuilderElementQuery rightJoinPageBuilderElementVersion($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PageBuilderElementVersion relation
 * @method     ChildPageBuilderElementQuery innerJoinPageBuilderElementVersion($relationAlias = null) Adds a INNER JOIN clause to the query using the PageBuilderElementVersion relation
 *
 * @method     ChildPageBuilderElement findOne(ConnectionInterface $con = null) Return the first ChildPageBuilderElement matching the query
 * @method     ChildPageBuilderElement findOneOrCreate(ConnectionInterface $con = null) Return the first ChildPageBuilderElement matching the query, or a new ChildPageBuilderElement object populated from the query conditions when no match is found
 *
 * @method     ChildPageBuilderElement findOneById(int $id) Return the first ChildPageBuilderElement filtered by the id column
 * @method     ChildPageBuilderElement findOneByPageBuilderId(int $page_builder_id) Return the first ChildPageBuilderElement filtered by the page_builder_id column
 * @method     ChildPageBuilderElement findOneByVisible(int $visible) Return the first ChildPageBuilderElement filtered by the visible column
 * @method     ChildPageBuilderElement findOneByPosition(int $position) Return the first ChildPageBuilderElement filtered by the position column
 * @method     ChildPageBuilderElement findOneByTemplateName(string $template_name) Return the first ChildPageBuilderElement filtered by the template_name column
 * @method     ChildPageBuilderElement findOneByCreatedAt(string $created_at) Return the first ChildPageBuilderElement filtered by the created_at column
 * @method     ChildPageBuilderElement findOneByUpdatedAt(string $updated_at) Return the first ChildPageBuilderElement filtered by the updated_at column
 * @method     ChildPageBuilderElement findOneByVersion(int $version) Return the first ChildPageBuilderElement filtered by the version column
 * @method     ChildPageBuilderElement findOneByVersionCreatedAt(string $version_created_at) Return the first ChildPageBuilderElement filtered by the version_created_at column
 * @method     ChildPageBuilderElement findOneByVersionCreatedBy(string $version_created_by) Return the first ChildPageBuilderElement filtered by the version_created_by column
 *
 * @method     array findById(int $id) Return ChildPageBuilderElement objects filtered by the id column
 * @method     array findByPageBuilderId(int $page_builder_id) Return ChildPageBuilderElement objects filtered by the page_builder_id column
 * @method     array findByVisible(int $visible) Return ChildPageBuilderElement objects filtered by the visible column
 * @method     array findByPosition(int $position) Return ChildPageBuilderElement objects filtered by the position column
 * @method     array findByTemplateName(string $template_name) Return ChildPageBuilderElement objects filtered by the template_name column
 * @method     array findByCreatedAt(string $created_at) Return ChildPageBuilderElement objects filtered by the created_at column
 * @method     array findByUpdatedAt(string $updated_at) Return ChildPageBuilderElement objects filtered by the updated_at column
 * @method     array findByVersion(int $version) Return ChildPageBuilderElement objects filtered by the version column
 * @method     array findByVersionCreatedAt(string $version_created_at) Return ChildPageBuilderElement objects filtered by the version_created_at column
 * @method     array findByVersionCreatedBy(string $version_created_by) Return ChildPageBuilderElement objects filtered by the version_created_by column
 *
 */
abstract class PageBuilderElementQuery extends ModelCriteria
{
    
    // versionable behavior
    
    /**
     * Whether the versioning is enabled
     */
    static $isVersioningEnabled = true;

    /**
     * Initializes internal state of \PageBuilder\Model\Base\PageBuilderElementQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'thelia', $modelName = '\\PageBuilder\\Model\\PageBuilderElement', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildPageBuilderElementQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildPageBuilderElementQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \PageBuilder\Model\PageBuilderElementQuery) {
            return $criteria;
        }
        $query = new \PageBuilder\Model\PageBuilderElementQuery();
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
     * @return ChildPageBuilderElement|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = PageBuilderElementTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(PageBuilderElementTableMap::DATABASE_NAME);
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
     * @return   ChildPageBuilderElement A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ID, PAGE_BUILDER_ID, VISIBLE, POSITION, TEMPLATE_NAME, CREATED_AT, UPDATED_AT, VERSION, VERSION_CREATED_AT, VERSION_CREATED_BY FROM page_builder_element WHERE ID = :p0';
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
            $obj = new ChildPageBuilderElement();
            $obj->hydrate($row);
            PageBuilderElementTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildPageBuilderElement|array|mixed the result, formatted by the current formatter
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
     * @return ChildPageBuilderElementQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(PageBuilderElementTableMap::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildPageBuilderElementQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(PageBuilderElementTableMap::ID, $keys, Criteria::IN);
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
     * @return ChildPageBuilderElementQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(PageBuilderElementTableMap::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(PageBuilderElementTableMap::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PageBuilderElementTableMap::ID, $id, $comparison);
    }

    /**
     * Filter the query on the page_builder_id column
     *
     * Example usage:
     * <code>
     * $query->filterByPageBuilderId(1234); // WHERE page_builder_id = 1234
     * $query->filterByPageBuilderId(array(12, 34)); // WHERE page_builder_id IN (12, 34)
     * $query->filterByPageBuilderId(array('min' => 12)); // WHERE page_builder_id > 12
     * </code>
     *
     * @see       filterByPageBuilder()
     *
     * @param     mixed $pageBuilderId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPageBuilderElementQuery The current query, for fluid interface
     */
    public function filterByPageBuilderId($pageBuilderId = null, $comparison = null)
    {
        if (is_array($pageBuilderId)) {
            $useMinMax = false;
            if (isset($pageBuilderId['min'])) {
                $this->addUsingAlias(PageBuilderElementTableMap::PAGE_BUILDER_ID, $pageBuilderId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($pageBuilderId['max'])) {
                $this->addUsingAlias(PageBuilderElementTableMap::PAGE_BUILDER_ID, $pageBuilderId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PageBuilderElementTableMap::PAGE_BUILDER_ID, $pageBuilderId, $comparison);
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
     * @return ChildPageBuilderElementQuery The current query, for fluid interface
     */
    public function filterByVisible($visible = null, $comparison = null)
    {
        if (is_array($visible)) {
            $useMinMax = false;
            if (isset($visible['min'])) {
                $this->addUsingAlias(PageBuilderElementTableMap::VISIBLE, $visible['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($visible['max'])) {
                $this->addUsingAlias(PageBuilderElementTableMap::VISIBLE, $visible['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PageBuilderElementTableMap::VISIBLE, $visible, $comparison);
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
     * @return ChildPageBuilderElementQuery The current query, for fluid interface
     */
    public function filterByPosition($position = null, $comparison = null)
    {
        if (is_array($position)) {
            $useMinMax = false;
            if (isset($position['min'])) {
                $this->addUsingAlias(PageBuilderElementTableMap::POSITION, $position['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($position['max'])) {
                $this->addUsingAlias(PageBuilderElementTableMap::POSITION, $position['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PageBuilderElementTableMap::POSITION, $position, $comparison);
    }

    /**
     * Filter the query on the template_name column
     *
     * Example usage:
     * <code>
     * $query->filterByTemplateName('fooValue');   // WHERE template_name = 'fooValue'
     * $query->filterByTemplateName('%fooValue%'); // WHERE template_name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $templateName The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPageBuilderElementQuery The current query, for fluid interface
     */
    public function filterByTemplateName($templateName = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($templateName)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $templateName)) {
                $templateName = str_replace('*', '%', $templateName);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PageBuilderElementTableMap::TEMPLATE_NAME, $templateName, $comparison);
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
     * @return ChildPageBuilderElementQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(PageBuilderElementTableMap::CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(PageBuilderElementTableMap::CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PageBuilderElementTableMap::CREATED_AT, $createdAt, $comparison);
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
     * @return ChildPageBuilderElementQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(PageBuilderElementTableMap::UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(PageBuilderElementTableMap::UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PageBuilderElementTableMap::UPDATED_AT, $updatedAt, $comparison);
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
     * @return ChildPageBuilderElementQuery The current query, for fluid interface
     */
    public function filterByVersion($version = null, $comparison = null)
    {
        if (is_array($version)) {
            $useMinMax = false;
            if (isset($version['min'])) {
                $this->addUsingAlias(PageBuilderElementTableMap::VERSION, $version['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($version['max'])) {
                $this->addUsingAlias(PageBuilderElementTableMap::VERSION, $version['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PageBuilderElementTableMap::VERSION, $version, $comparison);
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
     * @return ChildPageBuilderElementQuery The current query, for fluid interface
     */
    public function filterByVersionCreatedAt($versionCreatedAt = null, $comparison = null)
    {
        if (is_array($versionCreatedAt)) {
            $useMinMax = false;
            if (isset($versionCreatedAt['min'])) {
                $this->addUsingAlias(PageBuilderElementTableMap::VERSION_CREATED_AT, $versionCreatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($versionCreatedAt['max'])) {
                $this->addUsingAlias(PageBuilderElementTableMap::VERSION_CREATED_AT, $versionCreatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PageBuilderElementTableMap::VERSION_CREATED_AT, $versionCreatedAt, $comparison);
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
     * @return ChildPageBuilderElementQuery The current query, for fluid interface
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

        return $this->addUsingAlias(PageBuilderElementTableMap::VERSION_CREATED_BY, $versionCreatedBy, $comparison);
    }

    /**
     * Filter the query by a related \PageBuilder\Model\PageBuilder object
     *
     * @param \PageBuilder\Model\PageBuilder|ObjectCollection $pageBuilder The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPageBuilderElementQuery The current query, for fluid interface
     */
    public function filterByPageBuilder($pageBuilder, $comparison = null)
    {
        if ($pageBuilder instanceof \PageBuilder\Model\PageBuilder) {
            return $this
                ->addUsingAlias(PageBuilderElementTableMap::PAGE_BUILDER_ID, $pageBuilder->getId(), $comparison);
        } elseif ($pageBuilder instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(PageBuilderElementTableMap::PAGE_BUILDER_ID, $pageBuilder->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByPageBuilder() only accepts arguments of type \PageBuilder\Model\PageBuilder or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the PageBuilder relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildPageBuilderElementQuery The current query, for fluid interface
     */
    public function joinPageBuilder($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('PageBuilder');

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
            $this->addJoinObject($join, 'PageBuilder');
        }

        return $this;
    }

    /**
     * Use the PageBuilder relation PageBuilder object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \PageBuilder\Model\PageBuilderQuery A secondary query class using the current class as primary query
     */
    public function usePageBuilderQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPageBuilder($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'PageBuilder', '\PageBuilder\Model\PageBuilderQuery');
    }

    /**
     * Filter the query by a related \PageBuilder\Model\PageBuilderElementI18n object
     *
     * @param \PageBuilder\Model\PageBuilderElementI18n|ObjectCollection $pageBuilderElementI18n  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPageBuilderElementQuery The current query, for fluid interface
     */
    public function filterByPageBuilderElementI18n($pageBuilderElementI18n, $comparison = null)
    {
        if ($pageBuilderElementI18n instanceof \PageBuilder\Model\PageBuilderElementI18n) {
            return $this
                ->addUsingAlias(PageBuilderElementTableMap::ID, $pageBuilderElementI18n->getId(), $comparison);
        } elseif ($pageBuilderElementI18n instanceof ObjectCollection) {
            return $this
                ->usePageBuilderElementI18nQuery()
                ->filterByPrimaryKeys($pageBuilderElementI18n->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPageBuilderElementI18n() only accepts arguments of type \PageBuilder\Model\PageBuilderElementI18n or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the PageBuilderElementI18n relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildPageBuilderElementQuery The current query, for fluid interface
     */
    public function joinPageBuilderElementI18n($relationAlias = null, $joinType = 'LEFT JOIN')
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('PageBuilderElementI18n');

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
            $this->addJoinObject($join, 'PageBuilderElementI18n');
        }

        return $this;
    }

    /**
     * Use the PageBuilderElementI18n relation PageBuilderElementI18n object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \PageBuilder\Model\PageBuilderElementI18nQuery A secondary query class using the current class as primary query
     */
    public function usePageBuilderElementI18nQuery($relationAlias = null, $joinType = 'LEFT JOIN')
    {
        return $this
            ->joinPageBuilderElementI18n($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'PageBuilderElementI18n', '\PageBuilder\Model\PageBuilderElementI18nQuery');
    }

    /**
     * Filter the query by a related \PageBuilder\Model\PageBuilderElementVersion object
     *
     * @param \PageBuilder\Model\PageBuilderElementVersion|ObjectCollection $pageBuilderElementVersion  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPageBuilderElementQuery The current query, for fluid interface
     */
    public function filterByPageBuilderElementVersion($pageBuilderElementVersion, $comparison = null)
    {
        if ($pageBuilderElementVersion instanceof \PageBuilder\Model\PageBuilderElementVersion) {
            return $this
                ->addUsingAlias(PageBuilderElementTableMap::ID, $pageBuilderElementVersion->getId(), $comparison);
        } elseif ($pageBuilderElementVersion instanceof ObjectCollection) {
            return $this
                ->usePageBuilderElementVersionQuery()
                ->filterByPrimaryKeys($pageBuilderElementVersion->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPageBuilderElementVersion() only accepts arguments of type \PageBuilder\Model\PageBuilderElementVersion or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the PageBuilderElementVersion relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildPageBuilderElementQuery The current query, for fluid interface
     */
    public function joinPageBuilderElementVersion($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('PageBuilderElementVersion');

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
            $this->addJoinObject($join, 'PageBuilderElementVersion');
        }

        return $this;
    }

    /**
     * Use the PageBuilderElementVersion relation PageBuilderElementVersion object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \PageBuilder\Model\PageBuilderElementVersionQuery A secondary query class using the current class as primary query
     */
    public function usePageBuilderElementVersionQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPageBuilderElementVersion($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'PageBuilderElementVersion', '\PageBuilder\Model\PageBuilderElementVersionQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildPageBuilderElement $pageBuilderElement Object to remove from the list of results
     *
     * @return ChildPageBuilderElementQuery The current query, for fluid interface
     */
    public function prune($pageBuilderElement = null)
    {
        if ($pageBuilderElement) {
            $this->addUsingAlias(PageBuilderElementTableMap::ID, $pageBuilderElement->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the page_builder_element table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PageBuilderElementTableMap::DATABASE_NAME);
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
            PageBuilderElementTableMap::clearInstancePool();
            PageBuilderElementTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildPageBuilderElement or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildPageBuilderElement object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(PageBuilderElementTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(PageBuilderElementTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            

        PageBuilderElementTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            PageBuilderElementTableMap::clearRelatedInstancePool();
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
     * @return     ChildPageBuilderElementQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(PageBuilderElementTableMap::UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }
    
    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     ChildPageBuilderElementQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(PageBuilderElementTableMap::CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }
    
    /**
     * Order by update date desc
     *
     * @return     ChildPageBuilderElementQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(PageBuilderElementTableMap::UPDATED_AT);
    }
    
    /**
     * Order by update date asc
     *
     * @return     ChildPageBuilderElementQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(PageBuilderElementTableMap::UPDATED_AT);
    }
    
    /**
     * Order by create date desc
     *
     * @return     ChildPageBuilderElementQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(PageBuilderElementTableMap::CREATED_AT);
    }
    
    /**
     * Order by create date asc
     *
     * @return     ChildPageBuilderElementQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(PageBuilderElementTableMap::CREATED_AT);
    }

    // i18n behavior
    
    /**
     * Adds a JOIN clause to the query using the i18n relation
     *
     * @param     string $locale Locale to use for the join condition, e.g. 'fr_FR'
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'. Defaults to left join.
     *
     * @return    ChildPageBuilderElementQuery The current query, for fluid interface
     */
    public function joinI18n($locale = 'en_US', $relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $relationName = $relationAlias ? $relationAlias : 'PageBuilderElementI18n';
    
        return $this
            ->joinPageBuilderElementI18n($relationAlias, $joinType)
            ->addJoinCondition($relationName, $relationName . '.Locale = ?', $locale);
    }
    
    /**
     * Adds a JOIN clause to the query and hydrates the related I18n object.
     * Shortcut for $c->joinI18n($locale)->with()
     *
     * @param     string $locale Locale to use for the join condition, e.g. 'fr_FR'
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'. Defaults to left join.
     *
     * @return    ChildPageBuilderElementQuery The current query, for fluid interface
     */
    public function joinWithI18n($locale = 'en_US', $joinType = Criteria::LEFT_JOIN)
    {
        $this
            ->joinI18n($locale, null, $joinType)
            ->with('PageBuilderElementI18n');
        $this->with['PageBuilderElementI18n']->setIsWithOneToMany(false);
    
        return $this;
    }
    
    /**
     * Use the I18n relation query object
     *
     * @see       useQuery()
     *
     * @param     string $locale Locale to use for the join condition, e.g. 'fr_FR'
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'. Defaults to left join.
     *
     * @return    ChildPageBuilderElementI18nQuery A secondary query class using the current class as primary query
     */
    public function useI18nQuery($locale = 'en_US', $relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinI18n($locale, $relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'PageBuilderElementI18n', '\PageBuilder\Model\PageBuilderElementI18nQuery');
    }

    // versionable behavior
    
    /**
     * Checks whether versioning is enabled
     *
     * @return boolean
     */
    static public function isVersioningEnabled()
    {
        return self::$isVersioningEnabled;
    }
    
    /**
     * Enables versioning
     */
    static public function enableVersioning()
    {
        self::$isVersioningEnabled = true;
    }
    
    /**
     * Disables versioning
     */
    static public function disableVersioning()
    {
        self::$isVersioningEnabled = false;
    }

} // PageBuilderElementQuery
