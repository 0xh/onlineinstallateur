<?php

namespace AmazonIntegration\Model\Base;

use \Exception;
use \PDO;
use AmazonIntegration\Model\AmazonFinancialEventGroup as ChildAmazonFinancialEventGroup;
use AmazonIntegration\Model\AmazonFinancialEventGroupQuery as ChildAmazonFinancialEventGroupQuery;
use AmazonIntegration\Model\Map\AmazonFinancialEventGroupTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'amazon_financial_event_group' table.
 *
 * 
 *
 * @method     ChildAmazonFinancialEventGroupQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildAmazonFinancialEventGroupQuery orderByFinancialEventGroupId($order = Criteria::ASC) Order by the financialEventGroupId column
 * @method     ChildAmazonFinancialEventGroupQuery orderByProcessingStatus($order = Criteria::ASC) Order by the processingStatus column
 * @method     ChildAmazonFinancialEventGroupQuery orderByFundTransferStatus($order = Criteria::ASC) Order by the fundTransferStatus column
 * @method     ChildAmazonFinancialEventGroupQuery orderByOriginalTotal($order = Criteria::ASC) Order by the originalTotal column
 * @method     ChildAmazonFinancialEventGroupQuery orderByConvertedTotal($order = Criteria::ASC) Order by the convertedTotal column
 * @method     ChildAmazonFinancialEventGroupQuery orderByFundTransferDate($order = Criteria::ASC) Order by the fundTransferDate column
 * @method     ChildAmazonFinancialEventGroupQuery orderByTraceId($order = Criteria::ASC) Order by the traceId column
 * @method     ChildAmazonFinancialEventGroupQuery orderByAccountTail($order = Criteria::ASC) Order by the accountTail column
 * @method     ChildAmazonFinancialEventGroupQuery orderByBeginningBalance($order = Criteria::ASC) Order by the beginningBalance column
 * @method     ChildAmazonFinancialEventGroupQuery orderByFinancialEventGroupStart($order = Criteria::ASC) Order by the financialEventGroupStart column
 * @method     ChildAmazonFinancialEventGroupQuery orderByFinancialEventGroupEnd($order = Criteria::ASC) Order by the financialEventGroupEnd column
 *
 * @method     ChildAmazonFinancialEventGroupQuery groupById() Group by the id column
 * @method     ChildAmazonFinancialEventGroupQuery groupByFinancialEventGroupId() Group by the financialEventGroupId column
 * @method     ChildAmazonFinancialEventGroupQuery groupByProcessingStatus() Group by the processingStatus column
 * @method     ChildAmazonFinancialEventGroupQuery groupByFundTransferStatus() Group by the fundTransferStatus column
 * @method     ChildAmazonFinancialEventGroupQuery groupByOriginalTotal() Group by the originalTotal column
 * @method     ChildAmazonFinancialEventGroupQuery groupByConvertedTotal() Group by the convertedTotal column
 * @method     ChildAmazonFinancialEventGroupQuery groupByFundTransferDate() Group by the fundTransferDate column
 * @method     ChildAmazonFinancialEventGroupQuery groupByTraceId() Group by the traceId column
 * @method     ChildAmazonFinancialEventGroupQuery groupByAccountTail() Group by the accountTail column
 * @method     ChildAmazonFinancialEventGroupQuery groupByBeginningBalance() Group by the beginningBalance column
 * @method     ChildAmazonFinancialEventGroupQuery groupByFinancialEventGroupStart() Group by the financialEventGroupStart column
 * @method     ChildAmazonFinancialEventGroupQuery groupByFinancialEventGroupEnd() Group by the financialEventGroupEnd column
 *
 * @method     ChildAmazonFinancialEventGroupQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildAmazonFinancialEventGroupQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildAmazonFinancialEventGroupQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildAmazonFinancialEventGroup findOne(ConnectionInterface $con = null) Return the first ChildAmazonFinancialEventGroup matching the query
 * @method     ChildAmazonFinancialEventGroup findOneOrCreate(ConnectionInterface $con = null) Return the first ChildAmazonFinancialEventGroup matching the query, or a new ChildAmazonFinancialEventGroup object populated from the query conditions when no match is found
 *
 * @method     ChildAmazonFinancialEventGroup findOneById(int $id) Return the first ChildAmazonFinancialEventGroup filtered by the id column
 * @method     ChildAmazonFinancialEventGroup findOneByFinancialEventGroupId(string $financialEventGroupId) Return the first ChildAmazonFinancialEventGroup filtered by the financialEventGroupId column
 * @method     ChildAmazonFinancialEventGroup findOneByProcessingStatus(string $processingStatus) Return the first ChildAmazonFinancialEventGroup filtered by the processingStatus column
 * @method     ChildAmazonFinancialEventGroup findOneByFundTransferStatus(string $fundTransferStatus) Return the first ChildAmazonFinancialEventGroup filtered by the fundTransferStatus column
 * @method     ChildAmazonFinancialEventGroup findOneByOriginalTotal(string $originalTotal) Return the first ChildAmazonFinancialEventGroup filtered by the originalTotal column
 * @method     ChildAmazonFinancialEventGroup findOneByConvertedTotal(string $convertedTotal) Return the first ChildAmazonFinancialEventGroup filtered by the convertedTotal column
 * @method     ChildAmazonFinancialEventGroup findOneByFundTransferDate(string $fundTransferDate) Return the first ChildAmazonFinancialEventGroup filtered by the fundTransferDate column
 * @method     ChildAmazonFinancialEventGroup findOneByTraceId(string $traceId) Return the first ChildAmazonFinancialEventGroup filtered by the traceId column
 * @method     ChildAmazonFinancialEventGroup findOneByAccountTail(string $accountTail) Return the first ChildAmazonFinancialEventGroup filtered by the accountTail column
 * @method     ChildAmazonFinancialEventGroup findOneByBeginningBalance(string $beginningBalance) Return the first ChildAmazonFinancialEventGroup filtered by the beginningBalance column
 * @method     ChildAmazonFinancialEventGroup findOneByFinancialEventGroupStart(string $financialEventGroupStart) Return the first ChildAmazonFinancialEventGroup filtered by the financialEventGroupStart column
 * @method     ChildAmazonFinancialEventGroup findOneByFinancialEventGroupEnd(string $financialEventGroupEnd) Return the first ChildAmazonFinancialEventGroup filtered by the financialEventGroupEnd column
 *
 * @method     array findById(int $id) Return ChildAmazonFinancialEventGroup objects filtered by the id column
 * @method     array findByFinancialEventGroupId(string $financialEventGroupId) Return ChildAmazonFinancialEventGroup objects filtered by the financialEventGroupId column
 * @method     array findByProcessingStatus(string $processingStatus) Return ChildAmazonFinancialEventGroup objects filtered by the processingStatus column
 * @method     array findByFundTransferStatus(string $fundTransferStatus) Return ChildAmazonFinancialEventGroup objects filtered by the fundTransferStatus column
 * @method     array findByOriginalTotal(string $originalTotal) Return ChildAmazonFinancialEventGroup objects filtered by the originalTotal column
 * @method     array findByConvertedTotal(string $convertedTotal) Return ChildAmazonFinancialEventGroup objects filtered by the convertedTotal column
 * @method     array findByFundTransferDate(string $fundTransferDate) Return ChildAmazonFinancialEventGroup objects filtered by the fundTransferDate column
 * @method     array findByTraceId(string $traceId) Return ChildAmazonFinancialEventGroup objects filtered by the traceId column
 * @method     array findByAccountTail(string $accountTail) Return ChildAmazonFinancialEventGroup objects filtered by the accountTail column
 * @method     array findByBeginningBalance(string $beginningBalance) Return ChildAmazonFinancialEventGroup objects filtered by the beginningBalance column
 * @method     array findByFinancialEventGroupStart(string $financialEventGroupStart) Return ChildAmazonFinancialEventGroup objects filtered by the financialEventGroupStart column
 * @method     array findByFinancialEventGroupEnd(string $financialEventGroupEnd) Return ChildAmazonFinancialEventGroup objects filtered by the financialEventGroupEnd column
 *
 */
abstract class AmazonFinancialEventGroupQuery extends ModelCriteria
{
    
    /**
     * Initializes internal state of \AmazonIntegration\Model\Base\AmazonFinancialEventGroupQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'thelia', $modelName = '\\AmazonIntegration\\Model\\AmazonFinancialEventGroup', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildAmazonFinancialEventGroupQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildAmazonFinancialEventGroupQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \AmazonIntegration\Model\AmazonFinancialEventGroupQuery) {
            return $criteria;
        }
        $query = new \AmazonIntegration\Model\AmazonFinancialEventGroupQuery();
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
     * @return ChildAmazonFinancialEventGroup|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = AmazonFinancialEventGroupTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(AmazonFinancialEventGroupTableMap::DATABASE_NAME);
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
     * @return   ChildAmazonFinancialEventGroup A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ID, FINANCIALEVENTGROUPID, PROCESSINGSTATUS, FUNDTRANSFERSTATUS, ORIGINALTOTAL, CONVERTEDTOTAL, FUNDTRANSFERDATE, TRACEID, ACCOUNTTAIL, BEGINNINGBALANCE, FINANCIALEVENTGROUPSTART, FINANCIALEVENTGROUPEND FROM amazon_financial_event_group WHERE ID = :p0';
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
            $obj = new ChildAmazonFinancialEventGroup();
            $obj->hydrate($row);
            AmazonFinancialEventGroupTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildAmazonFinancialEventGroup|array|mixed the result, formatted by the current formatter
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
     * @return ChildAmazonFinancialEventGroupQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(AmazonFinancialEventGroupTableMap::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildAmazonFinancialEventGroupQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(AmazonFinancialEventGroupTableMap::ID, $keys, Criteria::IN);
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
     * @return ChildAmazonFinancialEventGroupQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(AmazonFinancialEventGroupTableMap::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(AmazonFinancialEventGroupTableMap::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AmazonFinancialEventGroupTableMap::ID, $id, $comparison);
    }

    /**
     * Filter the query on the financialEventGroupId column
     *
     * Example usage:
     * <code>
     * $query->filterByFinancialEventGroupId('fooValue');   // WHERE financialEventGroupId = 'fooValue'
     * $query->filterByFinancialEventGroupId('%fooValue%'); // WHERE financialEventGroupId LIKE '%fooValue%'
     * </code>
     *
     * @param     string $financialEventGroupId The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonFinancialEventGroupQuery The current query, for fluid interface
     */
    public function filterByFinancialEventGroupId($financialEventGroupId = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($financialEventGroupId)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $financialEventGroupId)) {
                $financialEventGroupId = str_replace('*', '%', $financialEventGroupId);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AmazonFinancialEventGroupTableMap::FINANCIALEVENTGROUPID, $financialEventGroupId, $comparison);
    }

    /**
     * Filter the query on the processingStatus column
     *
     * Example usage:
     * <code>
     * $query->filterByProcessingStatus('fooValue');   // WHERE processingStatus = 'fooValue'
     * $query->filterByProcessingStatus('%fooValue%'); // WHERE processingStatus LIKE '%fooValue%'
     * </code>
     *
     * @param     string $processingStatus The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonFinancialEventGroupQuery The current query, for fluid interface
     */
    public function filterByProcessingStatus($processingStatus = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($processingStatus)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $processingStatus)) {
                $processingStatus = str_replace('*', '%', $processingStatus);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AmazonFinancialEventGroupTableMap::PROCESSINGSTATUS, $processingStatus, $comparison);
    }

    /**
     * Filter the query on the fundTransferStatus column
     *
     * Example usage:
     * <code>
     * $query->filterByFundTransferStatus('fooValue');   // WHERE fundTransferStatus = 'fooValue'
     * $query->filterByFundTransferStatus('%fooValue%'); // WHERE fundTransferStatus LIKE '%fooValue%'
     * </code>
     *
     * @param     string $fundTransferStatus The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonFinancialEventGroupQuery The current query, for fluid interface
     */
    public function filterByFundTransferStatus($fundTransferStatus = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($fundTransferStatus)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $fundTransferStatus)) {
                $fundTransferStatus = str_replace('*', '%', $fundTransferStatus);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AmazonFinancialEventGroupTableMap::FUNDTRANSFERSTATUS, $fundTransferStatus, $comparison);
    }

    /**
     * Filter the query on the originalTotal column
     *
     * Example usage:
     * <code>
     * $query->filterByOriginalTotal(1234); // WHERE originalTotal = 1234
     * $query->filterByOriginalTotal(array(12, 34)); // WHERE originalTotal IN (12, 34)
     * $query->filterByOriginalTotal(array('min' => 12)); // WHERE originalTotal > 12
     * </code>
     *
     * @param     mixed $originalTotal The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonFinancialEventGroupQuery The current query, for fluid interface
     */
    public function filterByOriginalTotal($originalTotal = null, $comparison = null)
    {
        if (is_array($originalTotal)) {
            $useMinMax = false;
            if (isset($originalTotal['min'])) {
                $this->addUsingAlias(AmazonFinancialEventGroupTableMap::ORIGINALTOTAL, $originalTotal['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($originalTotal['max'])) {
                $this->addUsingAlias(AmazonFinancialEventGroupTableMap::ORIGINALTOTAL, $originalTotal['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AmazonFinancialEventGroupTableMap::ORIGINALTOTAL, $originalTotal, $comparison);
    }

    /**
     * Filter the query on the convertedTotal column
     *
     * Example usage:
     * <code>
     * $query->filterByConvertedTotal(1234); // WHERE convertedTotal = 1234
     * $query->filterByConvertedTotal(array(12, 34)); // WHERE convertedTotal IN (12, 34)
     * $query->filterByConvertedTotal(array('min' => 12)); // WHERE convertedTotal > 12
     * </code>
     *
     * @param     mixed $convertedTotal The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonFinancialEventGroupQuery The current query, for fluid interface
     */
    public function filterByConvertedTotal($convertedTotal = null, $comparison = null)
    {
        if (is_array($convertedTotal)) {
            $useMinMax = false;
            if (isset($convertedTotal['min'])) {
                $this->addUsingAlias(AmazonFinancialEventGroupTableMap::CONVERTEDTOTAL, $convertedTotal['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($convertedTotal['max'])) {
                $this->addUsingAlias(AmazonFinancialEventGroupTableMap::CONVERTEDTOTAL, $convertedTotal['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AmazonFinancialEventGroupTableMap::CONVERTEDTOTAL, $convertedTotal, $comparison);
    }

    /**
     * Filter the query on the fundTransferDate column
     *
     * Example usage:
     * <code>
     * $query->filterByFundTransferDate('2011-03-14'); // WHERE fundTransferDate = '2011-03-14'
     * $query->filterByFundTransferDate('now'); // WHERE fundTransferDate = '2011-03-14'
     * $query->filterByFundTransferDate(array('max' => 'yesterday')); // WHERE fundTransferDate > '2011-03-13'
     * </code>
     *
     * @param     mixed $fundTransferDate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonFinancialEventGroupQuery The current query, for fluid interface
     */
    public function filterByFundTransferDate($fundTransferDate = null, $comparison = null)
    {
        if (is_array($fundTransferDate)) {
            $useMinMax = false;
            if (isset($fundTransferDate['min'])) {
                $this->addUsingAlias(AmazonFinancialEventGroupTableMap::FUNDTRANSFERDATE, $fundTransferDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($fundTransferDate['max'])) {
                $this->addUsingAlias(AmazonFinancialEventGroupTableMap::FUNDTRANSFERDATE, $fundTransferDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AmazonFinancialEventGroupTableMap::FUNDTRANSFERDATE, $fundTransferDate, $comparison);
    }

    /**
     * Filter the query on the traceId column
     *
     * Example usage:
     * <code>
     * $query->filterByTraceId('fooValue');   // WHERE traceId = 'fooValue'
     * $query->filterByTraceId('%fooValue%'); // WHERE traceId LIKE '%fooValue%'
     * </code>
     *
     * @param     string $traceId The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonFinancialEventGroupQuery The current query, for fluid interface
     */
    public function filterByTraceId($traceId = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($traceId)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $traceId)) {
                $traceId = str_replace('*', '%', $traceId);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AmazonFinancialEventGroupTableMap::TRACEID, $traceId, $comparison);
    }

    /**
     * Filter the query on the accountTail column
     *
     * Example usage:
     * <code>
     * $query->filterByAccountTail('fooValue');   // WHERE accountTail = 'fooValue'
     * $query->filterByAccountTail('%fooValue%'); // WHERE accountTail LIKE '%fooValue%'
     * </code>
     *
     * @param     string $accountTail The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonFinancialEventGroupQuery The current query, for fluid interface
     */
    public function filterByAccountTail($accountTail = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($accountTail)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $accountTail)) {
                $accountTail = str_replace('*', '%', $accountTail);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AmazonFinancialEventGroupTableMap::ACCOUNTTAIL, $accountTail, $comparison);
    }

    /**
     * Filter the query on the beginningBalance column
     *
     * Example usage:
     * <code>
     * $query->filterByBeginningBalance(1234); // WHERE beginningBalance = 1234
     * $query->filterByBeginningBalance(array(12, 34)); // WHERE beginningBalance IN (12, 34)
     * $query->filterByBeginningBalance(array('min' => 12)); // WHERE beginningBalance > 12
     * </code>
     *
     * @param     mixed $beginningBalance The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonFinancialEventGroupQuery The current query, for fluid interface
     */
    public function filterByBeginningBalance($beginningBalance = null, $comparison = null)
    {
        if (is_array($beginningBalance)) {
            $useMinMax = false;
            if (isset($beginningBalance['min'])) {
                $this->addUsingAlias(AmazonFinancialEventGroupTableMap::BEGINNINGBALANCE, $beginningBalance['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($beginningBalance['max'])) {
                $this->addUsingAlias(AmazonFinancialEventGroupTableMap::BEGINNINGBALANCE, $beginningBalance['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AmazonFinancialEventGroupTableMap::BEGINNINGBALANCE, $beginningBalance, $comparison);
    }

    /**
     * Filter the query on the financialEventGroupStart column
     *
     * Example usage:
     * <code>
     * $query->filterByFinancialEventGroupStart('2011-03-14'); // WHERE financialEventGroupStart = '2011-03-14'
     * $query->filterByFinancialEventGroupStart('now'); // WHERE financialEventGroupStart = '2011-03-14'
     * $query->filterByFinancialEventGroupStart(array('max' => 'yesterday')); // WHERE financialEventGroupStart > '2011-03-13'
     * </code>
     *
     * @param     mixed $financialEventGroupStart The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonFinancialEventGroupQuery The current query, for fluid interface
     */
    public function filterByFinancialEventGroupStart($financialEventGroupStart = null, $comparison = null)
    {
        if (is_array($financialEventGroupStart)) {
            $useMinMax = false;
            if (isset($financialEventGroupStart['min'])) {
                $this->addUsingAlias(AmazonFinancialEventGroupTableMap::FINANCIALEVENTGROUPSTART, $financialEventGroupStart['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($financialEventGroupStart['max'])) {
                $this->addUsingAlias(AmazonFinancialEventGroupTableMap::FINANCIALEVENTGROUPSTART, $financialEventGroupStart['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AmazonFinancialEventGroupTableMap::FINANCIALEVENTGROUPSTART, $financialEventGroupStart, $comparison);
    }

    /**
     * Filter the query on the financialEventGroupEnd column
     *
     * Example usage:
     * <code>
     * $query->filterByFinancialEventGroupEnd('2011-03-14'); // WHERE financialEventGroupEnd = '2011-03-14'
     * $query->filterByFinancialEventGroupEnd('now'); // WHERE financialEventGroupEnd = '2011-03-14'
     * $query->filterByFinancialEventGroupEnd(array('max' => 'yesterday')); // WHERE financialEventGroupEnd > '2011-03-13'
     * </code>
     *
     * @param     mixed $financialEventGroupEnd The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmazonFinancialEventGroupQuery The current query, for fluid interface
     */
    public function filterByFinancialEventGroupEnd($financialEventGroupEnd = null, $comparison = null)
    {
        if (is_array($financialEventGroupEnd)) {
            $useMinMax = false;
            if (isset($financialEventGroupEnd['min'])) {
                $this->addUsingAlias(AmazonFinancialEventGroupTableMap::FINANCIALEVENTGROUPEND, $financialEventGroupEnd['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($financialEventGroupEnd['max'])) {
                $this->addUsingAlias(AmazonFinancialEventGroupTableMap::FINANCIALEVENTGROUPEND, $financialEventGroupEnd['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AmazonFinancialEventGroupTableMap::FINANCIALEVENTGROUPEND, $financialEventGroupEnd, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildAmazonFinancialEventGroup $amazonFinancialEventGroup Object to remove from the list of results
     *
     * @return ChildAmazonFinancialEventGroupQuery The current query, for fluid interface
     */
    public function prune($amazonFinancialEventGroup = null)
    {
        if ($amazonFinancialEventGroup) {
            $this->addUsingAlias(AmazonFinancialEventGroupTableMap::ID, $amazonFinancialEventGroup->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the amazon_financial_event_group table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(AmazonFinancialEventGroupTableMap::DATABASE_NAME);
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
            AmazonFinancialEventGroupTableMap::clearInstancePool();
            AmazonFinancialEventGroupTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildAmazonFinancialEventGroup or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildAmazonFinancialEventGroup object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(AmazonFinancialEventGroupTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(AmazonFinancialEventGroupTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            

        AmazonFinancialEventGroupTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            AmazonFinancialEventGroupTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

} // AmazonFinancialEventGroupQuery
