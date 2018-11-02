<?php

namespace RevenueDashboard\Model\Base;

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
use RevenueDashboard\Model\WholesalePartnerVersion as ChildWholesalePartnerVersion;
use RevenueDashboard\Model\WholesalePartnerVersionQuery as ChildWholesalePartnerVersionQuery;
use RevenueDashboard\Model\Map\WholesalePartnerVersionTableMap;

/**
 * Base class that represents a query for the 'wholesale_partner_version' table.
 *
 *
 *
 * @method     ChildWholesalePartnerVersionQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildWholesalePartnerVersionQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method     ChildWholesalePartnerVersionQuery orderByDescription($order = Criteria::ASC) Order by the description column
 * @method     ChildWholesalePartnerVersionQuery orderByComment($order = Criteria::ASC) Order by the comment column
 * @method     ChildWholesalePartnerVersionQuery orderByPriority($order = Criteria::ASC) Order by the priority column
 * @method     ChildWholesalePartnerVersionQuery orderByAddress($order = Criteria::ASC) Order by the address column
 * @method     ChildWholesalePartnerVersionQuery orderByDepositAddress($order = Criteria::ASC) Order by the deposit_address column
 * @method     ChildWholesalePartnerVersionQuery orderByContactPerson($order = Criteria::ASC) Order by the contact_person column
 * @method     ChildWholesalePartnerVersionQuery orderByDeliveryTypes($order = Criteria::ASC) Order by the delivery_types column
 * @method     ChildWholesalePartnerVersionQuery orderByReturnPolicy($order = Criteria::ASC) Order by the return_policy column
 * @method     ChildWholesalePartnerVersionQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildWholesalePartnerVersionQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 * @method     ChildWholesalePartnerVersionQuery orderByVersion($order = Criteria::ASC) Order by the version column
 * @method     ChildWholesalePartnerVersionQuery orderByVersionCreatedBy($order = Criteria::ASC) Order by the version_created_by column
 *
 * @method     ChildWholesalePartnerVersionQuery groupById() Group by the id column
 * @method     ChildWholesalePartnerVersionQuery groupByName() Group by the name column
 * @method     ChildWholesalePartnerVersionQuery groupByDescription() Group by the description column
 * @method     ChildWholesalePartnerVersionQuery groupByComment() Group by the comment column
 * @method     ChildWholesalePartnerVersionQuery groupByPriority() Group by the priority column
 * @method     ChildWholesalePartnerVersionQuery groupByAddress() Group by the address column
 * @method     ChildWholesalePartnerVersionQuery groupByDepositAddress() Group by the deposit_address column
 * @method     ChildWholesalePartnerVersionQuery groupByContactPerson() Group by the contact_person column
 * @method     ChildWholesalePartnerVersionQuery groupByDeliveryTypes() Group by the delivery_types column
 * @method     ChildWholesalePartnerVersionQuery groupByReturnPolicy() Group by the return_policy column
 * @method     ChildWholesalePartnerVersionQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildWholesalePartnerVersionQuery groupByUpdatedAt() Group by the updated_at column
 * @method     ChildWholesalePartnerVersionQuery groupByVersion() Group by the version column
 * @method     ChildWholesalePartnerVersionQuery groupByVersionCreatedBy() Group by the version_created_by column
 *
 * @method     ChildWholesalePartnerVersionQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildWholesalePartnerVersionQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildWholesalePartnerVersionQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildWholesalePartnerVersionQuery leftJoinWholesalePartner($relationAlias = null) Adds a LEFT JOIN clause to the query using the WholesalePartner relation
 * @method     ChildWholesalePartnerVersionQuery rightJoinWholesalePartner($relationAlias = null) Adds a RIGHT JOIN clause to the query using the WholesalePartner relation
 * @method     ChildWholesalePartnerVersionQuery innerJoinWholesalePartner($relationAlias = null) Adds a INNER JOIN clause to the query using the WholesalePartner relation
 *
 * @method     ChildWholesalePartnerVersion findOne(ConnectionInterface $con = null) Return the first ChildWholesalePartnerVersion matching the query
 * @method     ChildWholesalePartnerVersion findOneOrCreate(ConnectionInterface $con = null) Return the first ChildWholesalePartnerVersion matching the query, or a new ChildWholesalePartnerVersion object populated from the query conditions when no match is found
 *
 * @method     ChildWholesalePartnerVersion findOneById(int $id) Return the first ChildWholesalePartnerVersion filtered by the id column
 * @method     ChildWholesalePartnerVersion findOneByName(string $name) Return the first ChildWholesalePartnerVersion filtered by the name column
 * @method     ChildWholesalePartnerVersion findOneByDescription(string $description) Return the first ChildWholesalePartnerVersion filtered by the description column
 * @method     ChildWholesalePartnerVersion findOneByComment(string $comment) Return the first ChildWholesalePartnerVersion filtered by the comment column
 * @method     ChildWholesalePartnerVersion findOneByPriority(int $priority) Return the first ChildWholesalePartnerVersion filtered by the priority column
 * @method     ChildWholesalePartnerVersion findOneByAddress(string $address) Return the first ChildWholesalePartnerVersion filtered by the address column
 * @method     ChildWholesalePartnerVersion findOneByDepositAddress(string $deposit_address) Return the first ChildWholesalePartnerVersion filtered by the deposit_address column
 * @method     ChildWholesalePartnerVersion findOneByContactPerson(string $contact_person) Return the first ChildWholesalePartnerVersion filtered by the contact_person column
 * @method     ChildWholesalePartnerVersion findOneByDeliveryTypes(string $delivery_types) Return the first ChildWholesalePartnerVersion filtered by the delivery_types column
 * @method     ChildWholesalePartnerVersion findOneByReturnPolicy(string $return_policy) Return the first ChildWholesalePartnerVersion filtered by the return_policy column
 * @method     ChildWholesalePartnerVersion findOneByCreatedAt(string $created_at) Return the first ChildWholesalePartnerVersion filtered by the created_at column
 * @method     ChildWholesalePartnerVersion findOneByUpdatedAt(string $updated_at) Return the first ChildWholesalePartnerVersion filtered by the updated_at column
 * @method     ChildWholesalePartnerVersion findOneByVersion(int $version) Return the first ChildWholesalePartnerVersion filtered by the version column
 * @method     ChildWholesalePartnerVersion findOneByVersionCreatedBy(string $version_created_by) Return the first ChildWholesalePartnerVersion filtered by the version_created_by column
 *
 * @method     array findById(int $id) Return ChildWholesalePartnerVersion objects filtered by the id column
 * @method     array findByName(string $name) Return ChildWholesalePartnerVersion objects filtered by the name column
 * @method     array findByDescription(string $description) Return ChildWholesalePartnerVersion objects filtered by the description column
 * @method     array findByComment(string $comment) Return ChildWholesalePartnerVersion objects filtered by the comment column
 * @method     array findByPriority(int $priority) Return ChildWholesalePartnerVersion objects filtered by the priority column
 * @method     array findByAddress(string $address) Return ChildWholesalePartnerVersion objects filtered by the address column
 * @method     array findByDepositAddress(string $deposit_address) Return ChildWholesalePartnerVersion objects filtered by the deposit_address column
 * @method     array findByContactPerson(string $contact_person) Return ChildWholesalePartnerVersion objects filtered by the contact_person column
 * @method     array findByDeliveryTypes(string $delivery_types) Return ChildWholesalePartnerVersion objects filtered by the delivery_types column
 * @method     array findByReturnPolicy(string $return_policy) Return ChildWholesalePartnerVersion objects filtered by the return_policy column
 * @method     array findByCreatedAt(string $created_at) Return ChildWholesalePartnerVersion objects filtered by the created_at column
 * @method     array findByUpdatedAt(string $updated_at) Return ChildWholesalePartnerVersion objects filtered by the updated_at column
 * @method     array findByVersion(int $version) Return ChildWholesalePartnerVersion objects filtered by the version column
 * @method     array findByVersionCreatedBy(string $version_created_by) Return ChildWholesalePartnerVersion objects filtered by the version_created_by column
 *
 */
abstract class WholesalePartnerVersionQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \RevenueDashboard\Model\Base\WholesalePartnerVersionQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'thelia', $modelName = '\\RevenueDashboard\\Model\\WholesalePartnerVersion', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildWholesalePartnerVersionQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildWholesalePartnerVersionQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \RevenueDashboard\Model\WholesalePartnerVersionQuery) {
            return $criteria;
        }
        $query = new \RevenueDashboard\Model\WholesalePartnerVersionQuery();
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
     * @return ChildWholesalePartnerVersion|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = WholesalePartnerVersionTableMap::getInstanceFromPool(serialize(array((string) $key[0], (string) $key[1]))))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(WholesalePartnerVersionTableMap::DATABASE_NAME);
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
     * @return   ChildWholesalePartnerVersion A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ID, NAME, DESCRIPTION, COMMENT, PRIORITY, ADDRESS, DEPOSIT_ADDRESS, CONTACT_PERSON, DELIVERY_TYPES, RETURN_POLICY, CREATED_AT, UPDATED_AT, VERSION, VERSION_CREATED_BY FROM wholesale_partner_version WHERE ID = :p0 AND VERSION = :p1';
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
            $obj = new ChildWholesalePartnerVersion();
            $obj->hydrate($row);
            WholesalePartnerVersionTableMap::addInstanceToPool($obj, serialize(array((string) $key[0], (string) $key[1])));
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
     * @return ChildWholesalePartnerVersion|array|mixed the result, formatted by the current formatter
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
     * @return ChildWholesalePartnerVersionQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(WholesalePartnerVersionTableMap::ID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(WholesalePartnerVersionTableMap::VERSION, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildWholesalePartnerVersionQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(WholesalePartnerVersionTableMap::ID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(WholesalePartnerVersionTableMap::VERSION, $key[1], Criteria::EQUAL);
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
     * @see       filterByWholesalePartner()
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildWholesalePartnerVersionQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(WholesalePartnerVersionTableMap::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(WholesalePartnerVersionTableMap::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(WholesalePartnerVersionTableMap::ID, $id, $comparison);
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
     * @return ChildWholesalePartnerVersionQuery The current query, for fluid interface
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

        return $this->addUsingAlias(WholesalePartnerVersionTableMap::NAME, $name, $comparison);
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
     * @return ChildWholesalePartnerVersionQuery The current query, for fluid interface
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

        return $this->addUsingAlias(WholesalePartnerVersionTableMap::DESCRIPTION, $description, $comparison);
    }

    /**
     * Filter the query on the comment column
     *
     * Example usage:
     * <code>
     * $query->filterByComment('fooValue');   // WHERE comment = 'fooValue'
     * $query->filterByComment('%fooValue%'); // WHERE comment LIKE '%fooValue%'
     * </code>
     *
     * @param     string $comment The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildWholesalePartnerVersionQuery The current query, for fluid interface
     */
    public function filterByComment($comment = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($comment)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $comment)) {
                $comment = str_replace('*', '%', $comment);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(WholesalePartnerVersionTableMap::COMMENT, $comment, $comparison);
    }

    /**
     * Filter the query on the priority column
     *
     * Example usage:
     * <code>
     * $query->filterByPriority(1234); // WHERE priority = 1234
     * $query->filterByPriority(array(12, 34)); // WHERE priority IN (12, 34)
     * $query->filterByPriority(array('min' => 12)); // WHERE priority > 12
     * </code>
     *
     * @param     mixed $priority The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildWholesalePartnerVersionQuery The current query, for fluid interface
     */
    public function filterByPriority($priority = null, $comparison = null)
    {
        if (is_array($priority)) {
            $useMinMax = false;
            if (isset($priority['min'])) {
                $this->addUsingAlias(WholesalePartnerVersionTableMap::PRIORITY, $priority['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($priority['max'])) {
                $this->addUsingAlias(WholesalePartnerVersionTableMap::PRIORITY, $priority['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(WholesalePartnerVersionTableMap::PRIORITY, $priority, $comparison);
    }

    /**
     * Filter the query on the address column
     *
     * Example usage:
     * <code>
     * $query->filterByAddress('fooValue');   // WHERE address = 'fooValue'
     * $query->filterByAddress('%fooValue%'); // WHERE address LIKE '%fooValue%'
     * </code>
     *
     * @param     string $address The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildWholesalePartnerVersionQuery The current query, for fluid interface
     */
    public function filterByAddress($address = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($address)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $address)) {
                $address = str_replace('*', '%', $address);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(WholesalePartnerVersionTableMap::ADDRESS, $address, $comparison);
    }

    /**
     * Filter the query on the deposit_address column
     *
     * Example usage:
     * <code>
     * $query->filterByDepositAddress('fooValue');   // WHERE deposit_address = 'fooValue'
     * $query->filterByDepositAddress('%fooValue%'); // WHERE deposit_address LIKE '%fooValue%'
     * </code>
     *
     * @param     string $depositAddress The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildWholesalePartnerVersionQuery The current query, for fluid interface
     */
    public function filterByDepositAddress($depositAddress = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($depositAddress)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $depositAddress)) {
                $depositAddress = str_replace('*', '%', $depositAddress);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(WholesalePartnerVersionTableMap::DEPOSIT_ADDRESS, $depositAddress, $comparison);
    }

    /**
     * Filter the query on the contact_person column
     *
     * Example usage:
     * <code>
     * $query->filterByContactPerson('fooValue');   // WHERE contact_person = 'fooValue'
     * $query->filterByContactPerson('%fooValue%'); // WHERE contact_person LIKE '%fooValue%'
     * </code>
     *
     * @param     string $contactPerson The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildWholesalePartnerVersionQuery The current query, for fluid interface
     */
    public function filterByContactPerson($contactPerson = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($contactPerson)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $contactPerson)) {
                $contactPerson = str_replace('*', '%', $contactPerson);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(WholesalePartnerVersionTableMap::CONTACT_PERSON, $contactPerson, $comparison);
    }

    /**
     * Filter the query on the delivery_types column
     *
     * Example usage:
     * <code>
     * $query->filterByDeliveryTypes('fooValue');   // WHERE delivery_types = 'fooValue'
     * $query->filterByDeliveryTypes('%fooValue%'); // WHERE delivery_types LIKE '%fooValue%'
     * </code>
     *
     * @param     string $deliveryTypes The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildWholesalePartnerVersionQuery The current query, for fluid interface
     */
    public function filterByDeliveryTypes($deliveryTypes = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($deliveryTypes)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $deliveryTypes)) {
                $deliveryTypes = str_replace('*', '%', $deliveryTypes);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(WholesalePartnerVersionTableMap::DELIVERY_TYPES, $deliveryTypes, $comparison);
    }

    /**
     * Filter the query on the return_policy column
     *
     * Example usage:
     * <code>
     * $query->filterByReturnPolicy('fooValue');   // WHERE return_policy = 'fooValue'
     * $query->filterByReturnPolicy('%fooValue%'); // WHERE return_policy LIKE '%fooValue%'
     * </code>
     *
     * @param     string $returnPolicy The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildWholesalePartnerVersionQuery The current query, for fluid interface
     */
    public function filterByReturnPolicy($returnPolicy = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($returnPolicy)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $returnPolicy)) {
                $returnPolicy = str_replace('*', '%', $returnPolicy);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(WholesalePartnerVersionTableMap::RETURN_POLICY, $returnPolicy, $comparison);
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
     * @return ChildWholesalePartnerVersionQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(WholesalePartnerVersionTableMap::CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(WholesalePartnerVersionTableMap::CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(WholesalePartnerVersionTableMap::CREATED_AT, $createdAt, $comparison);
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
     * @return ChildWholesalePartnerVersionQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(WholesalePartnerVersionTableMap::UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(WholesalePartnerVersionTableMap::UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(WholesalePartnerVersionTableMap::UPDATED_AT, $updatedAt, $comparison);
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
     * @return ChildWholesalePartnerVersionQuery The current query, for fluid interface
     */
    public function filterByVersion($version = null, $comparison = null)
    {
        if (is_array($version)) {
            $useMinMax = false;
            if (isset($version['min'])) {
                $this->addUsingAlias(WholesalePartnerVersionTableMap::VERSION, $version['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($version['max'])) {
                $this->addUsingAlias(WholesalePartnerVersionTableMap::VERSION, $version['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(WholesalePartnerVersionTableMap::VERSION, $version, $comparison);
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
     * @return ChildWholesalePartnerVersionQuery The current query, for fluid interface
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

        return $this->addUsingAlias(WholesalePartnerVersionTableMap::VERSION_CREATED_BY, $versionCreatedBy, $comparison);
    }

    /**
     * Filter the query by a related \RevenueDashboard\Model\WholesalePartner object
     *
     * @param \RevenueDashboard\Model\WholesalePartner|ObjectCollection $wholesalePartner The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildWholesalePartnerVersionQuery The current query, for fluid interface
     */
    public function filterByWholesalePartner($wholesalePartner, $comparison = null)
    {
        if ($wholesalePartner instanceof \RevenueDashboard\Model\WholesalePartner) {
            return $this
                ->addUsingAlias(WholesalePartnerVersionTableMap::ID, $wholesalePartner->getId(), $comparison);
        } elseif ($wholesalePartner instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(WholesalePartnerVersionTableMap::ID, $wholesalePartner->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByWholesalePartner() only accepts arguments of type \RevenueDashboard\Model\WholesalePartner or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the WholesalePartner relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildWholesalePartnerVersionQuery The current query, for fluid interface
     */
    public function joinWholesalePartner($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('WholesalePartner');

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
            $this->addJoinObject($join, 'WholesalePartner');
        }

        return $this;
    }

    /**
     * Use the WholesalePartner relation WholesalePartner object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \RevenueDashboard\Model\WholesalePartnerQuery A secondary query class using the current class as primary query
     */
    public function useWholesalePartnerQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinWholesalePartner($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'WholesalePartner', '\RevenueDashboard\Model\WholesalePartnerQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildWholesalePartnerVersion $wholesalePartnerVersion Object to remove from the list of results
     *
     * @return ChildWholesalePartnerVersionQuery The current query, for fluid interface
     */
    public function prune($wholesalePartnerVersion = null)
    {
        if ($wholesalePartnerVersion) {
            $this->addCond('pruneCond0', $this->getAliasedColName(WholesalePartnerVersionTableMap::ID), $wholesalePartnerVersion->getId(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(WholesalePartnerVersionTableMap::VERSION), $wholesalePartnerVersion->getVersion(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the wholesale_partner_version table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(WholesalePartnerVersionTableMap::DATABASE_NAME);
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
            WholesalePartnerVersionTableMap::clearInstancePool();
            WholesalePartnerVersionTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildWholesalePartnerVersion or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildWholesalePartnerVersion object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(WholesalePartnerVersionTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(WholesalePartnerVersionTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();


        WholesalePartnerVersionTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            WholesalePartnerVersionTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

} // WholesalePartnerVersionQuery
