<?php

namespace Selection\Model\Base;

use \Exception;
use \PDO;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;
use Selection\Model\SelectionFeatures as ChildSelectionFeatures;
use Selection\Model\SelectionFeaturesQuery as ChildSelectionFeaturesQuery;
use Selection\Model\Map\SelectionFeaturesTableMap;
use Thelia\Model\Feature;
use Thelia\Model\FeatureAv;
use Thelia\Model\FeatureAvI18n;

/**
 * Base class that represents a query for the 'selection_features' table.
 *
 * 
 *
 * @method     ChildSelectionFeaturesQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildSelectionFeaturesQuery orderByFeatureId($order = Criteria::ASC) Order by the feature_id column
 * @method     ChildSelectionFeaturesQuery orderBySelectionId($order = Criteria::ASC) Order by the selection_id column
 * @method     ChildSelectionFeaturesQuery orderByFeatureAvId($order = Criteria::ASC) Order by the feature_av_id column
 * @method     ChildSelectionFeaturesQuery orderByFreetextValue($order = Criteria::ASC) Order by the freetext_value column
 * @method     ChildSelectionFeaturesQuery orderByPosition($order = Criteria::ASC) Order by the position column
 * @method     ChildSelectionFeaturesQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildSelectionFeaturesQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method     ChildSelectionFeaturesQuery groupById() Group by the id column
 * @method     ChildSelectionFeaturesQuery groupByFeatureId() Group by the feature_id column
 * @method     ChildSelectionFeaturesQuery groupBySelectionId() Group by the selection_id column
 * @method     ChildSelectionFeaturesQuery groupByFeatureAvId() Group by the feature_av_id column
 * @method     ChildSelectionFeaturesQuery groupByFreetextValue() Group by the freetext_value column
 * @method     ChildSelectionFeaturesQuery groupByPosition() Group by the position column
 * @method     ChildSelectionFeaturesQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildSelectionFeaturesQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method     ChildSelectionFeaturesQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildSelectionFeaturesQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildSelectionFeaturesQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildSelectionFeaturesQuery leftJoinFeature($relationAlias = null) Adds a LEFT JOIN clause to the query using the Feature relation
 * @method     ChildSelectionFeaturesQuery rightJoinFeature($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Feature relation
 * @method     ChildSelectionFeaturesQuery innerJoinFeature($relationAlias = null) Adds a INNER JOIN clause to the query using the Feature relation
 *
 * @method     ChildSelectionFeaturesQuery leftJoinFeatureAv($relationAlias = null) Adds a LEFT JOIN clause to the query using the FeatureAv relation
 * @method     ChildSelectionFeaturesQuery rightJoinFeatureAv($relationAlias = null) Adds a RIGHT JOIN clause to the query using the FeatureAv relation
 * @method     ChildSelectionFeaturesQuery innerJoinFeatureAv($relationAlias = null) Adds a INNER JOIN clause to the query using the FeatureAv relation
 *
 * @method     ChildSelectionFeaturesQuery leftJoinFeatureAvI18n($relationAlias = null) Adds a LEFT JOIN clause to the query using the FeatureAvI18n relation
 * @method     ChildSelectionFeaturesQuery rightJoinFeatureAvI18n($relationAlias = null) Adds a RIGHT JOIN clause to the query using the FeatureAvI18n relation
 * @method     ChildSelectionFeaturesQuery innerJoinFeatureAvI18n($relationAlias = null) Adds a INNER JOIN clause to the query using the FeatureAvI18n relation
 *
 * @method     ChildSelectionFeatures findOne(ConnectionInterface $con = null) Return the first ChildSelectionFeatures matching the query
 * @method     ChildSelectionFeatures findOneOrCreate(ConnectionInterface $con = null) Return the first ChildSelectionFeatures matching the query, or a new ChildSelectionFeatures object populated from the query conditions when no match is found
 *
 * @method     ChildSelectionFeatures findOneById(int $id) Return the first ChildSelectionFeatures filtered by the id column
 * @method     ChildSelectionFeatures findOneByFeatureId(int $feature_id) Return the first ChildSelectionFeatures filtered by the feature_id column
 * @method     ChildSelectionFeatures findOneBySelectionId(int $selection_id) Return the first ChildSelectionFeatures filtered by the selection_id column
 * @method     ChildSelectionFeatures findOneByFeatureAvId(int $feature_av_id) Return the first ChildSelectionFeatures filtered by the feature_av_id column
 * @method     ChildSelectionFeatures findOneByFreetextValue(string $freetext_value) Return the first ChildSelectionFeatures filtered by the freetext_value column
 * @method     ChildSelectionFeatures findOneByPosition(int $position) Return the first ChildSelectionFeatures filtered by the position column
 * @method     ChildSelectionFeatures findOneByCreatedAt(string $created_at) Return the first ChildSelectionFeatures filtered by the created_at column
 * @method     ChildSelectionFeatures findOneByUpdatedAt(string $updated_at) Return the first ChildSelectionFeatures filtered by the updated_at column
 *
 * @method     array findById(int $id) Return ChildSelectionFeatures objects filtered by the id column
 * @method     array findByFeatureId(int $feature_id) Return ChildSelectionFeatures objects filtered by the feature_id column
 * @method     array findBySelectionId(int $selection_id) Return ChildSelectionFeatures objects filtered by the selection_id column
 * @method     array findByFeatureAvId(int $feature_av_id) Return ChildSelectionFeatures objects filtered by the feature_av_id column
 * @method     array findByFreetextValue(string $freetext_value) Return ChildSelectionFeatures objects filtered by the freetext_value column
 * @method     array findByPosition(int $position) Return ChildSelectionFeatures objects filtered by the position column
 * @method     array findByCreatedAt(string $created_at) Return ChildSelectionFeatures objects filtered by the created_at column
 * @method     array findByUpdatedAt(string $updated_at) Return ChildSelectionFeatures objects filtered by the updated_at column
 *
 */
abstract class SelectionFeaturesQuery extends ModelCriteria
{
    
    /**
     * Initializes internal state of \Selection\Model\Base\SelectionFeaturesQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'thelia', $modelName = '\\Selection\\Model\\SelectionFeatures', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildSelectionFeaturesQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildSelectionFeaturesQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \Selection\Model\SelectionFeaturesQuery) {
            return $criteria;
        }
        $query = new \Selection\Model\SelectionFeaturesQuery();
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
     * @return ChildSelectionFeatures|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = SelectionFeaturesTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(SelectionFeaturesTableMap::DATABASE_NAME);
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
     * @return   ChildSelectionFeatures A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ID, FEATURE_ID, SELECTION_ID, FEATURE_AV_ID, FREETEXT_VALUE, POSITION, CREATED_AT, UPDATED_AT FROM selection_features WHERE ID = :p0';
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
            $obj = new ChildSelectionFeatures();
            $obj->hydrate($row);
            SelectionFeaturesTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildSelectionFeatures|array|mixed the result, formatted by the current formatter
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
     * @return ChildSelectionFeaturesQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(SelectionFeaturesTableMap::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildSelectionFeaturesQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(SelectionFeaturesTableMap::ID, $keys, Criteria::IN);
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
     * @return ChildSelectionFeaturesQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(SelectionFeaturesTableMap::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(SelectionFeaturesTableMap::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SelectionFeaturesTableMap::ID, $id, $comparison);
    }

    /**
     * Filter the query on the feature_id column
     *
     * Example usage:
     * <code>
     * $query->filterByFeatureId(1234); // WHERE feature_id = 1234
     * $query->filterByFeatureId(array(12, 34)); // WHERE feature_id IN (12, 34)
     * $query->filterByFeatureId(array('min' => 12)); // WHERE feature_id > 12
     * </code>
     *
     * @see       filterByFeature()
     *
     * @param     mixed $featureId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSelectionFeaturesQuery The current query, for fluid interface
     */
    public function filterByFeatureId($featureId = null, $comparison = null)
    {
        if (is_array($featureId)) {
            $useMinMax = false;
            if (isset($featureId['min'])) {
                $this->addUsingAlias(SelectionFeaturesTableMap::FEATURE_ID, $featureId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($featureId['max'])) {
                $this->addUsingAlias(SelectionFeaturesTableMap::FEATURE_ID, $featureId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SelectionFeaturesTableMap::FEATURE_ID, $featureId, $comparison);
    }

    /**
     * Filter the query on the selection_id column
     *
     * Example usage:
     * <code>
     * $query->filterBySelectionId(1234); // WHERE selection_id = 1234
     * $query->filterBySelectionId(array(12, 34)); // WHERE selection_id IN (12, 34)
     * $query->filterBySelectionId(array('min' => 12)); // WHERE selection_id > 12
     * </code>
     *
     * @param     mixed $selectionId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSelectionFeaturesQuery The current query, for fluid interface
     */
    public function filterBySelectionId($selectionId = null, $comparison = null)
    {
        if (is_array($selectionId)) {
            $useMinMax = false;
            if (isset($selectionId['min'])) {
                $this->addUsingAlias(SelectionFeaturesTableMap::SELECTION_ID, $selectionId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($selectionId['max'])) {
                $this->addUsingAlias(SelectionFeaturesTableMap::SELECTION_ID, $selectionId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SelectionFeaturesTableMap::SELECTION_ID, $selectionId, $comparison);
    }

    /**
     * Filter the query on the feature_av_id column
     *
     * Example usage:
     * <code>
     * $query->filterByFeatureAvId(1234); // WHERE feature_av_id = 1234
     * $query->filterByFeatureAvId(array(12, 34)); // WHERE feature_av_id IN (12, 34)
     * $query->filterByFeatureAvId(array('min' => 12)); // WHERE feature_av_id > 12
     * </code>
     *
     * @see       filterByFeatureAv()
     *
     * @see       filterByFeatureAvI18n()
     *
     * @param     mixed $featureAvId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSelectionFeaturesQuery The current query, for fluid interface
     */
    public function filterByFeatureAvId($featureAvId = null, $comparison = null)
    {
        if (is_array($featureAvId)) {
            $useMinMax = false;
            if (isset($featureAvId['min'])) {
                $this->addUsingAlias(SelectionFeaturesTableMap::FEATURE_AV_ID, $featureAvId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($featureAvId['max'])) {
                $this->addUsingAlias(SelectionFeaturesTableMap::FEATURE_AV_ID, $featureAvId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SelectionFeaturesTableMap::FEATURE_AV_ID, $featureAvId, $comparison);
    }

    /**
     * Filter the query on the freetext_value column
     *
     * Example usage:
     * <code>
     * $query->filterByFreetextValue('fooValue');   // WHERE freetext_value = 'fooValue'
     * $query->filterByFreetextValue('%fooValue%'); // WHERE freetext_value LIKE '%fooValue%'
     * </code>
     *
     * @param     string $freetextValue The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSelectionFeaturesQuery The current query, for fluid interface
     */
    public function filterByFreetextValue($freetextValue = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($freetextValue)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $freetextValue)) {
                $freetextValue = str_replace('*', '%', $freetextValue);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SelectionFeaturesTableMap::FREETEXT_VALUE, $freetextValue, $comparison);
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
     * @return ChildSelectionFeaturesQuery The current query, for fluid interface
     */
    public function filterByPosition($position = null, $comparison = null)
    {
        if (is_array($position)) {
            $useMinMax = false;
            if (isset($position['min'])) {
                $this->addUsingAlias(SelectionFeaturesTableMap::POSITION, $position['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($position['max'])) {
                $this->addUsingAlias(SelectionFeaturesTableMap::POSITION, $position['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SelectionFeaturesTableMap::POSITION, $position, $comparison);
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
     * @return ChildSelectionFeaturesQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(SelectionFeaturesTableMap::CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(SelectionFeaturesTableMap::CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SelectionFeaturesTableMap::CREATED_AT, $createdAt, $comparison);
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
     * @return ChildSelectionFeaturesQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(SelectionFeaturesTableMap::UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(SelectionFeaturesTableMap::UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SelectionFeaturesTableMap::UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Filter the query by a related \Thelia\Model\Feature object
     *
     * @param \Thelia\Model\Feature|ObjectCollection $feature The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSelectionFeaturesQuery The current query, for fluid interface
     */
    public function filterByFeature($feature, $comparison = null)
    {
        if ($feature instanceof \Thelia\Model\Feature) {
            return $this
                ->addUsingAlias(SelectionFeaturesTableMap::FEATURE_ID, $feature->getId(), $comparison);
        } elseif ($feature instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(SelectionFeaturesTableMap::FEATURE_ID, $feature->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByFeature() only accepts arguments of type \Thelia\Model\Feature or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Feature relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildSelectionFeaturesQuery The current query, for fluid interface
     */
    public function joinFeature($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Feature');

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
            $this->addJoinObject($join, 'Feature');
        }

        return $this;
    }

    /**
     * Use the Feature relation Feature object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Thelia\Model\FeatureQuery A secondary query class using the current class as primary query
     */
    public function useFeatureQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinFeature($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Feature', '\Thelia\Model\FeatureQuery');
    }

    /**
     * Filter the query by a related \Thelia\Model\FeatureAv object
     *
     * @param \Thelia\Model\FeatureAv|ObjectCollection $featureAv The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSelectionFeaturesQuery The current query, for fluid interface
     */
    public function filterByFeatureAv($featureAv, $comparison = null)
    {
        if ($featureAv instanceof \Thelia\Model\FeatureAv) {
            return $this
                ->addUsingAlias(SelectionFeaturesTableMap::FEATURE_AV_ID, $featureAv->getId(), $comparison);
        } elseif ($featureAv instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(SelectionFeaturesTableMap::FEATURE_AV_ID, $featureAv->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByFeatureAv() only accepts arguments of type \Thelia\Model\FeatureAv or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the FeatureAv relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildSelectionFeaturesQuery The current query, for fluid interface
     */
    public function joinFeatureAv($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('FeatureAv');

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
            $this->addJoinObject($join, 'FeatureAv');
        }

        return $this;
    }

    /**
     * Use the FeatureAv relation FeatureAv object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Thelia\Model\FeatureAvQuery A secondary query class using the current class as primary query
     */
    public function useFeatureAvQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinFeatureAv($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'FeatureAv', '\Thelia\Model\FeatureAvQuery');
    }

    /**
     * Filter the query by a related \Thelia\Model\FeatureAvI18n object
     *
     * @param \Thelia\Model\FeatureAvI18n|ObjectCollection $featureAvI18n The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSelectionFeaturesQuery The current query, for fluid interface
     */
    public function filterByFeatureAvI18n($featureAvI18n, $comparison = null)
    {
        if ($featureAvI18n instanceof \Thelia\Model\FeatureAvI18n) {
            return $this
                ->addUsingAlias(SelectionFeaturesTableMap::FEATURE_AV_ID, $featureAvI18n->getId(), $comparison);
        } elseif ($featureAvI18n instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(SelectionFeaturesTableMap::FEATURE_AV_ID, $featureAvI18n->toKeyValue('Id', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByFeatureAvI18n() only accepts arguments of type \Thelia\Model\FeatureAvI18n or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the FeatureAvI18n relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildSelectionFeaturesQuery The current query, for fluid interface
     */
    public function joinFeatureAvI18n($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('FeatureAvI18n');

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
            $this->addJoinObject($join, 'FeatureAvI18n');
        }

        return $this;
    }

    /**
     * Use the FeatureAvI18n relation FeatureAvI18n object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Thelia\Model\FeatureAvI18nQuery A secondary query class using the current class as primary query
     */
    public function useFeatureAvI18nQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinFeatureAvI18n($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'FeatureAvI18n', '\Thelia\Model\FeatureAvI18nQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildSelectionFeatures $selectionFeatures Object to remove from the list of results
     *
     * @return ChildSelectionFeaturesQuery The current query, for fluid interface
     */
    public function prune($selectionFeatures = null)
    {
        if ($selectionFeatures) {
            $this->addUsingAlias(SelectionFeaturesTableMap::ID, $selectionFeatures->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the selection_features table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SelectionFeaturesTableMap::DATABASE_NAME);
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
            SelectionFeaturesTableMap::clearInstancePool();
            SelectionFeaturesTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildSelectionFeatures or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildSelectionFeatures object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(SelectionFeaturesTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(SelectionFeaturesTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            

        SelectionFeaturesTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            SelectionFeaturesTableMap::clearRelatedInstancePool();
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
     * @return     ChildSelectionFeaturesQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(SelectionFeaturesTableMap::UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }
    
    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     ChildSelectionFeaturesQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(SelectionFeaturesTableMap::CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }
    
    /**
     * Order by update date desc
     *
     * @return     ChildSelectionFeaturesQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(SelectionFeaturesTableMap::UPDATED_AT);
    }
    
    /**
     * Order by update date asc
     *
     * @return     ChildSelectionFeaturesQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(SelectionFeaturesTableMap::UPDATED_AT);
    }
    
    /**
     * Order by create date desc
     *
     * @return     ChildSelectionFeaturesQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(SelectionFeaturesTableMap::CREATED_AT);
    }
    
    /**
     * Order by create date asc
     *
     * @return     ChildSelectionFeaturesQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(SelectionFeaturesTableMap::CREATED_AT);
    }

} // SelectionFeaturesQuery
