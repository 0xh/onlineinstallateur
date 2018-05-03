<?php

namespace PageBuilder\Model\Base;

use \Exception;
use \PDO;
use PageBuilder\Model\PageBuilderI18n as ChildPageBuilderI18n;
use PageBuilder\Model\PageBuilderI18nQuery as ChildPageBuilderI18nQuery;
use PageBuilder\Model\Map\PageBuilderI18nTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'page_builder_i18n' table.
 *
 * 
 *
 * @method     ChildPageBuilderI18nQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildPageBuilderI18nQuery orderByLocale($order = Criteria::ASC) Order by the locale column
 * @method     ChildPageBuilderI18nQuery orderByTitle($order = Criteria::ASC) Order by the title column
 * @method     ChildPageBuilderI18nQuery orderByHeader($order = Criteria::ASC) Order by the header column
 * @method     ChildPageBuilderI18nQuery orderByFooter($order = Criteria::ASC) Order by the footer column
 * @method     ChildPageBuilderI18nQuery orderByChapo($order = Criteria::ASC) Order by the chapo column
 * @method     ChildPageBuilderI18nQuery orderByPostscriptum($order = Criteria::ASC) Order by the postscriptum column
 * @method     ChildPageBuilderI18nQuery orderByMetaTitle($order = Criteria::ASC) Order by the meta_title column
 * @method     ChildPageBuilderI18nQuery orderByMetaDescription($order = Criteria::ASC) Order by the meta_description column
 * @method     ChildPageBuilderI18nQuery orderByMetaKeywords($order = Criteria::ASC) Order by the meta_keywords column
 *
 * @method     ChildPageBuilderI18nQuery groupById() Group by the id column
 * @method     ChildPageBuilderI18nQuery groupByLocale() Group by the locale column
 * @method     ChildPageBuilderI18nQuery groupByTitle() Group by the title column
 * @method     ChildPageBuilderI18nQuery groupByHeader() Group by the header column
 * @method     ChildPageBuilderI18nQuery groupByFooter() Group by the footer column
 * @method     ChildPageBuilderI18nQuery groupByChapo() Group by the chapo column
 * @method     ChildPageBuilderI18nQuery groupByPostscriptum() Group by the postscriptum column
 * @method     ChildPageBuilderI18nQuery groupByMetaTitle() Group by the meta_title column
 * @method     ChildPageBuilderI18nQuery groupByMetaDescription() Group by the meta_description column
 * @method     ChildPageBuilderI18nQuery groupByMetaKeywords() Group by the meta_keywords column
 *
 * @method     ChildPageBuilderI18nQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildPageBuilderI18nQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildPageBuilderI18nQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildPageBuilderI18nQuery leftJoinPageBuilder($relationAlias = null) Adds a LEFT JOIN clause to the query using the PageBuilder relation
 * @method     ChildPageBuilderI18nQuery rightJoinPageBuilder($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PageBuilder relation
 * @method     ChildPageBuilderI18nQuery innerJoinPageBuilder($relationAlias = null) Adds a INNER JOIN clause to the query using the PageBuilder relation
 *
 * @method     ChildPageBuilderI18n findOne(ConnectionInterface $con = null) Return the first ChildPageBuilderI18n matching the query
 * @method     ChildPageBuilderI18n findOneOrCreate(ConnectionInterface $con = null) Return the first ChildPageBuilderI18n matching the query, or a new ChildPageBuilderI18n object populated from the query conditions when no match is found
 *
 * @method     ChildPageBuilderI18n findOneById(int $id) Return the first ChildPageBuilderI18n filtered by the id column
 * @method     ChildPageBuilderI18n findOneByLocale(string $locale) Return the first ChildPageBuilderI18n filtered by the locale column
 * @method     ChildPageBuilderI18n findOneByTitle(string $title) Return the first ChildPageBuilderI18n filtered by the title column
 * @method     ChildPageBuilderI18n findOneByHeader(string $header) Return the first ChildPageBuilderI18n filtered by the header column
 * @method     ChildPageBuilderI18n findOneByFooter(string $footer) Return the first ChildPageBuilderI18n filtered by the footer column
 * @method     ChildPageBuilderI18n findOneByChapo(string $chapo) Return the first ChildPageBuilderI18n filtered by the chapo column
 * @method     ChildPageBuilderI18n findOneByPostscriptum(string $postscriptum) Return the first ChildPageBuilderI18n filtered by the postscriptum column
 * @method     ChildPageBuilderI18n findOneByMetaTitle(string $meta_title) Return the first ChildPageBuilderI18n filtered by the meta_title column
 * @method     ChildPageBuilderI18n findOneByMetaDescription(string $meta_description) Return the first ChildPageBuilderI18n filtered by the meta_description column
 * @method     ChildPageBuilderI18n findOneByMetaKeywords(string $meta_keywords) Return the first ChildPageBuilderI18n filtered by the meta_keywords column
 *
 * @method     array findById(int $id) Return ChildPageBuilderI18n objects filtered by the id column
 * @method     array findByLocale(string $locale) Return ChildPageBuilderI18n objects filtered by the locale column
 * @method     array findByTitle(string $title) Return ChildPageBuilderI18n objects filtered by the title column
 * @method     array findByHeader(string $header) Return ChildPageBuilderI18n objects filtered by the header column
 * @method     array findByFooter(string $footer) Return ChildPageBuilderI18n objects filtered by the footer column
 * @method     array findByChapo(string $chapo) Return ChildPageBuilderI18n objects filtered by the chapo column
 * @method     array findByPostscriptum(string $postscriptum) Return ChildPageBuilderI18n objects filtered by the postscriptum column
 * @method     array findByMetaTitle(string $meta_title) Return ChildPageBuilderI18n objects filtered by the meta_title column
 * @method     array findByMetaDescription(string $meta_description) Return ChildPageBuilderI18n objects filtered by the meta_description column
 * @method     array findByMetaKeywords(string $meta_keywords) Return ChildPageBuilderI18n objects filtered by the meta_keywords column
 *
 */
abstract class PageBuilderI18nQuery extends ModelCriteria
{
    
    /**
     * Initializes internal state of \PageBuilder\Model\Base\PageBuilderI18nQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'thelia', $modelName = '\\PageBuilder\\Model\\PageBuilderI18n', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildPageBuilderI18nQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildPageBuilderI18nQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \PageBuilder\Model\PageBuilderI18nQuery) {
            return $criteria;
        }
        $query = new \PageBuilder\Model\PageBuilderI18nQuery();
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
     * @param array[$id, $locale] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildPageBuilderI18n|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = PageBuilderI18nTableMap::getInstanceFromPool(serialize(array((string) $key[0], (string) $key[1]))))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(PageBuilderI18nTableMap::DATABASE_NAME);
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
     * @return   ChildPageBuilderI18n A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ID, LOCALE, TITLE, HEADER, FOOTER, CHAPO, POSTSCRIPTUM, META_TITLE, META_DESCRIPTION, META_KEYWORDS FROM page_builder_i18n WHERE ID = :p0 AND LOCALE = :p1';
        try {
            $stmt = $con->prepare($sql);            
            $stmt->bindValue(':p0', $key[0], PDO::PARAM_INT);            
            $stmt->bindValue(':p1', $key[1], PDO::PARAM_STR);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            $obj = new ChildPageBuilderI18n();
            $obj->hydrate($row);
            PageBuilderI18nTableMap::addInstanceToPool($obj, serialize(array((string) $key[0], (string) $key[1])));
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
     * @return ChildPageBuilderI18n|array|mixed the result, formatted by the current formatter
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
     * @return ChildPageBuilderI18nQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(PageBuilderI18nTableMap::ID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(PageBuilderI18nTableMap::LOCALE, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildPageBuilderI18nQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(PageBuilderI18nTableMap::ID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(PageBuilderI18nTableMap::LOCALE, $key[1], Criteria::EQUAL);
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
     * @see       filterByPageBuilder()
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPageBuilderI18nQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(PageBuilderI18nTableMap::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(PageBuilderI18nTableMap::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PageBuilderI18nTableMap::ID, $id, $comparison);
    }

    /**
     * Filter the query on the locale column
     *
     * Example usage:
     * <code>
     * $query->filterByLocale('fooValue');   // WHERE locale = 'fooValue'
     * $query->filterByLocale('%fooValue%'); // WHERE locale LIKE '%fooValue%'
     * </code>
     *
     * @param     string $locale The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPageBuilderI18nQuery The current query, for fluid interface
     */
    public function filterByLocale($locale = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($locale)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $locale)) {
                $locale = str_replace('*', '%', $locale);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PageBuilderI18nTableMap::LOCALE, $locale, $comparison);
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
     * @return ChildPageBuilderI18nQuery The current query, for fluid interface
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

        return $this->addUsingAlias(PageBuilderI18nTableMap::TITLE, $title, $comparison);
    }

    /**
     * Filter the query on the header column
     *
     * Example usage:
     * <code>
     * $query->filterByHeader('fooValue');   // WHERE header = 'fooValue'
     * $query->filterByHeader('%fooValue%'); // WHERE header LIKE '%fooValue%'
     * </code>
     *
     * @param     string $header The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPageBuilderI18nQuery The current query, for fluid interface
     */
    public function filterByHeader($header = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($header)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $header)) {
                $header = str_replace('*', '%', $header);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PageBuilderI18nTableMap::HEADER, $header, $comparison);
    }

    /**
     * Filter the query on the footer column
     *
     * Example usage:
     * <code>
     * $query->filterByFooter('fooValue');   // WHERE footer = 'fooValue'
     * $query->filterByFooter('%fooValue%'); // WHERE footer LIKE '%fooValue%'
     * </code>
     *
     * @param     string $footer The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPageBuilderI18nQuery The current query, for fluid interface
     */
    public function filterByFooter($footer = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($footer)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $footer)) {
                $footer = str_replace('*', '%', $footer);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PageBuilderI18nTableMap::FOOTER, $footer, $comparison);
    }

    /**
     * Filter the query on the chapo column
     *
     * Example usage:
     * <code>
     * $query->filterByChapo('fooValue');   // WHERE chapo = 'fooValue'
     * $query->filterByChapo('%fooValue%'); // WHERE chapo LIKE '%fooValue%'
     * </code>
     *
     * @param     string $chapo The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPageBuilderI18nQuery The current query, for fluid interface
     */
    public function filterByChapo($chapo = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($chapo)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $chapo)) {
                $chapo = str_replace('*', '%', $chapo);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PageBuilderI18nTableMap::CHAPO, $chapo, $comparison);
    }

    /**
     * Filter the query on the postscriptum column
     *
     * Example usage:
     * <code>
     * $query->filterByPostscriptum('fooValue');   // WHERE postscriptum = 'fooValue'
     * $query->filterByPostscriptum('%fooValue%'); // WHERE postscriptum LIKE '%fooValue%'
     * </code>
     *
     * @param     string $postscriptum The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPageBuilderI18nQuery The current query, for fluid interface
     */
    public function filterByPostscriptum($postscriptum = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($postscriptum)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $postscriptum)) {
                $postscriptum = str_replace('*', '%', $postscriptum);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PageBuilderI18nTableMap::POSTSCRIPTUM, $postscriptum, $comparison);
    }

    /**
     * Filter the query on the meta_title column
     *
     * Example usage:
     * <code>
     * $query->filterByMetaTitle('fooValue');   // WHERE meta_title = 'fooValue'
     * $query->filterByMetaTitle('%fooValue%'); // WHERE meta_title LIKE '%fooValue%'
     * </code>
     *
     * @param     string $metaTitle The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPageBuilderI18nQuery The current query, for fluid interface
     */
    public function filterByMetaTitle($metaTitle = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($metaTitle)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $metaTitle)) {
                $metaTitle = str_replace('*', '%', $metaTitle);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PageBuilderI18nTableMap::META_TITLE, $metaTitle, $comparison);
    }

    /**
     * Filter the query on the meta_description column
     *
     * Example usage:
     * <code>
     * $query->filterByMetaDescription('fooValue');   // WHERE meta_description = 'fooValue'
     * $query->filterByMetaDescription('%fooValue%'); // WHERE meta_description LIKE '%fooValue%'
     * </code>
     *
     * @param     string $metaDescription The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPageBuilderI18nQuery The current query, for fluid interface
     */
    public function filterByMetaDescription($metaDescription = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($metaDescription)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $metaDescription)) {
                $metaDescription = str_replace('*', '%', $metaDescription);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PageBuilderI18nTableMap::META_DESCRIPTION, $metaDescription, $comparison);
    }

    /**
     * Filter the query on the meta_keywords column
     *
     * Example usage:
     * <code>
     * $query->filterByMetaKeywords('fooValue');   // WHERE meta_keywords = 'fooValue'
     * $query->filterByMetaKeywords('%fooValue%'); // WHERE meta_keywords LIKE '%fooValue%'
     * </code>
     *
     * @param     string $metaKeywords The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPageBuilderI18nQuery The current query, for fluid interface
     */
    public function filterByMetaKeywords($metaKeywords = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($metaKeywords)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $metaKeywords)) {
                $metaKeywords = str_replace('*', '%', $metaKeywords);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PageBuilderI18nTableMap::META_KEYWORDS, $metaKeywords, $comparison);
    }

    /**
     * Filter the query by a related \PageBuilder\Model\PageBuilder object
     *
     * @param \PageBuilder\Model\PageBuilder|ObjectCollection $pageBuilder The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPageBuilderI18nQuery The current query, for fluid interface
     */
    public function filterByPageBuilder($pageBuilder, $comparison = null)
    {
        if ($pageBuilder instanceof \PageBuilder\Model\PageBuilder) {
            return $this
                ->addUsingAlias(PageBuilderI18nTableMap::ID, $pageBuilder->getId(), $comparison);
        } elseif ($pageBuilder instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(PageBuilderI18nTableMap::ID, $pageBuilder->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return ChildPageBuilderI18nQuery The current query, for fluid interface
     */
    public function joinPageBuilder($relationAlias = null, $joinType = 'LEFT JOIN')
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
    public function usePageBuilderQuery($relationAlias = null, $joinType = 'LEFT JOIN')
    {
        return $this
            ->joinPageBuilder($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'PageBuilder', '\PageBuilder\Model\PageBuilderQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildPageBuilderI18n $pageBuilderI18n Object to remove from the list of results
     *
     * @return ChildPageBuilderI18nQuery The current query, for fluid interface
     */
    public function prune($pageBuilderI18n = null)
    {
        if ($pageBuilderI18n) {
            $this->addCond('pruneCond0', $this->getAliasedColName(PageBuilderI18nTableMap::ID), $pageBuilderI18n->getId(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(PageBuilderI18nTableMap::LOCALE), $pageBuilderI18n->getLocale(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the page_builder_i18n table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PageBuilderI18nTableMap::DATABASE_NAME);
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
            PageBuilderI18nTableMap::clearInstancePool();
            PageBuilderI18nTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildPageBuilderI18n or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildPageBuilderI18n object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(PageBuilderI18nTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(PageBuilderI18nTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            

        PageBuilderI18nTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            PageBuilderI18nTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

} // PageBuilderI18nQuery
