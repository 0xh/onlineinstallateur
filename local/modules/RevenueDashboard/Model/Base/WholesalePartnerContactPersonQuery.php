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
use RevenueDashboard\Model\WholesalePartnerContactPerson as ChildWholesalePartnerContactPerson;
use RevenueDashboard\Model\WholesalePartnerContactPersonQuery as ChildWholesalePartnerContactPersonQuery;
use RevenueDashboard\Model\Map\WholesalePartnerContactPersonTableMap;
use Thelia\Model\CustomerTitle;

/**
 * Base class that represents a query for the 'wholesale_partner_contact_person' table.
 *
 * 
 *
 * @method     ChildWholesalePartnerContactPersonQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildWholesalePartnerContactPersonQuery orderByTitle($order = Criteria::ASC) Order by the title column
 * @method     ChildWholesalePartnerContactPersonQuery orderByFirstname($order = Criteria::ASC) Order by the firstname column
 * @method     ChildWholesalePartnerContactPersonQuery orderByLastname($order = Criteria::ASC) Order by the lastname column
 * @method     ChildWholesalePartnerContactPersonQuery orderByTelefon($order = Criteria::ASC) Order by the telefon column
 * @method     ChildWholesalePartnerContactPersonQuery orderByEmail($order = Criteria::ASC) Order by the email column
 * @method     ChildWholesalePartnerContactPersonQuery orderByProfileWebsite($order = Criteria::ASC) Order by the profile_website column
 * @method     ChildWholesalePartnerContactPersonQuery orderByPosition($order = Criteria::ASC) Order by the position column
 * @method     ChildWholesalePartnerContactPersonQuery orderByDepartment($order = Criteria::ASC) Order by the department column
 * @method     ChildWholesalePartnerContactPersonQuery orderByComment($order = Criteria::ASC) Order by the comment column
 * @method     ChildWholesalePartnerContactPersonQuery orderByVersion($order = Criteria::ASC) Order by the version column
 * @method     ChildWholesalePartnerContactPersonQuery orderByVersionCreatedBy($order = Criteria::ASC) Order by the version_created_by column
 *
 * @method     ChildWholesalePartnerContactPersonQuery groupById() Group by the id column
 * @method     ChildWholesalePartnerContactPersonQuery groupByTitle() Group by the title column
 * @method     ChildWholesalePartnerContactPersonQuery groupByFirstname() Group by the firstname column
 * @method     ChildWholesalePartnerContactPersonQuery groupByLastname() Group by the lastname column
 * @method     ChildWholesalePartnerContactPersonQuery groupByTelefon() Group by the telefon column
 * @method     ChildWholesalePartnerContactPersonQuery groupByEmail() Group by the email column
 * @method     ChildWholesalePartnerContactPersonQuery groupByProfileWebsite() Group by the profile_website column
 * @method     ChildWholesalePartnerContactPersonQuery groupByPosition() Group by the position column
 * @method     ChildWholesalePartnerContactPersonQuery groupByDepartment() Group by the department column
 * @method     ChildWholesalePartnerContactPersonQuery groupByComment() Group by the comment column
 * @method     ChildWholesalePartnerContactPersonQuery groupByVersion() Group by the version column
 * @method     ChildWholesalePartnerContactPersonQuery groupByVersionCreatedBy() Group by the version_created_by column
 *
 * @method     ChildWholesalePartnerContactPersonQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildWholesalePartnerContactPersonQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildWholesalePartnerContactPersonQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildWholesalePartnerContactPersonQuery leftJoinCustomerTitle($relationAlias = null) Adds a LEFT JOIN clause to the query using the CustomerTitle relation
 * @method     ChildWholesalePartnerContactPersonQuery rightJoinCustomerTitle($relationAlias = null) Adds a RIGHT JOIN clause to the query using the CustomerTitle relation
 * @method     ChildWholesalePartnerContactPersonQuery innerJoinCustomerTitle($relationAlias = null) Adds a INNER JOIN clause to the query using the CustomerTitle relation
 *
 * @method     ChildWholesalePartnerContactPersonQuery leftJoinWholesalePartnerContactPersonVersion($relationAlias = null) Adds a LEFT JOIN clause to the query using the WholesalePartnerContactPersonVersion relation
 * @method     ChildWholesalePartnerContactPersonQuery rightJoinWholesalePartnerContactPersonVersion($relationAlias = null) Adds a RIGHT JOIN clause to the query using the WholesalePartnerContactPersonVersion relation
 * @method     ChildWholesalePartnerContactPersonQuery innerJoinWholesalePartnerContactPersonVersion($relationAlias = null) Adds a INNER JOIN clause to the query using the WholesalePartnerContactPersonVersion relation
 *
 * @method     ChildWholesalePartnerContactPerson findOne(ConnectionInterface $con = null) Return the first ChildWholesalePartnerContactPerson matching the query
 * @method     ChildWholesalePartnerContactPerson findOneOrCreate(ConnectionInterface $con = null) Return the first ChildWholesalePartnerContactPerson matching the query, or a new ChildWholesalePartnerContactPerson object populated from the query conditions when no match is found
 *
 * @method     ChildWholesalePartnerContactPerson findOneById(int $id) Return the first ChildWholesalePartnerContactPerson filtered by the id column
 * @method     ChildWholesalePartnerContactPerson findOneByTitle(int $title) Return the first ChildWholesalePartnerContactPerson filtered by the title column
 * @method     ChildWholesalePartnerContactPerson findOneByFirstname(string $firstname) Return the first ChildWholesalePartnerContactPerson filtered by the firstname column
 * @method     ChildWholesalePartnerContactPerson findOneByLastname(string $lastname) Return the first ChildWholesalePartnerContactPerson filtered by the lastname column
 * @method     ChildWholesalePartnerContactPerson findOneByTelefon(string $telefon) Return the first ChildWholesalePartnerContactPerson filtered by the telefon column
 * @method     ChildWholesalePartnerContactPerson findOneByEmail(string $email) Return the first ChildWholesalePartnerContactPerson filtered by the email column
 * @method     ChildWholesalePartnerContactPerson findOneByProfileWebsite(string $profile_website) Return the first ChildWholesalePartnerContactPerson filtered by the profile_website column
 * @method     ChildWholesalePartnerContactPerson findOneByPosition(string $position) Return the first ChildWholesalePartnerContactPerson filtered by the position column
 * @method     ChildWholesalePartnerContactPerson findOneByDepartment(string $department) Return the first ChildWholesalePartnerContactPerson filtered by the department column
 * @method     ChildWholesalePartnerContactPerson findOneByComment(string $comment) Return the first ChildWholesalePartnerContactPerson filtered by the comment column
 * @method     ChildWholesalePartnerContactPerson findOneByVersion(int $version) Return the first ChildWholesalePartnerContactPerson filtered by the version column
 * @method     ChildWholesalePartnerContactPerson findOneByVersionCreatedBy(string $version_created_by) Return the first ChildWholesalePartnerContactPerson filtered by the version_created_by column
 *
 * @method     array findById(int $id) Return ChildWholesalePartnerContactPerson objects filtered by the id column
 * @method     array findByTitle(int $title) Return ChildWholesalePartnerContactPerson objects filtered by the title column
 * @method     array findByFirstname(string $firstname) Return ChildWholesalePartnerContactPerson objects filtered by the firstname column
 * @method     array findByLastname(string $lastname) Return ChildWholesalePartnerContactPerson objects filtered by the lastname column
 * @method     array findByTelefon(string $telefon) Return ChildWholesalePartnerContactPerson objects filtered by the telefon column
 * @method     array findByEmail(string $email) Return ChildWholesalePartnerContactPerson objects filtered by the email column
 * @method     array findByProfileWebsite(string $profile_website) Return ChildWholesalePartnerContactPerson objects filtered by the profile_website column
 * @method     array findByPosition(string $position) Return ChildWholesalePartnerContactPerson objects filtered by the position column
 * @method     array findByDepartment(string $department) Return ChildWholesalePartnerContactPerson objects filtered by the department column
 * @method     array findByComment(string $comment) Return ChildWholesalePartnerContactPerson objects filtered by the comment column
 * @method     array findByVersion(int $version) Return ChildWholesalePartnerContactPerson objects filtered by the version column
 * @method     array findByVersionCreatedBy(string $version_created_by) Return ChildWholesalePartnerContactPerson objects filtered by the version_created_by column
 *
 */
abstract class WholesalePartnerContactPersonQuery extends ModelCriteria
{
    
    // versionable behavior
    
    /**
     * Whether the versioning is enabled
     */
    static $isVersioningEnabled = true;

    /**
     * Initializes internal state of \RevenueDashboard\Model\Base\WholesalePartnerContactPersonQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'thelia', $modelName = '\\RevenueDashboard\\Model\\WholesalePartnerContactPerson', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildWholesalePartnerContactPersonQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildWholesalePartnerContactPersonQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \RevenueDashboard\Model\WholesalePartnerContactPersonQuery) {
            return $criteria;
        }
        $query = new \RevenueDashboard\Model\WholesalePartnerContactPersonQuery();
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
     * @return ChildWholesalePartnerContactPerson|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = WholesalePartnerContactPersonTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(WholesalePartnerContactPersonTableMap::DATABASE_NAME);
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
     * @return   ChildWholesalePartnerContactPerson A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ID, TITLE, FIRSTNAME, LASTNAME, TELEFON, EMAIL, PROFILE_WEBSITE, POSITION, DEPARTMENT, COMMENT, VERSION, VERSION_CREATED_BY FROM wholesale_partner_contact_person WHERE ID = :p0';
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
            $obj = new ChildWholesalePartnerContactPerson();
            $obj->hydrate($row);
            WholesalePartnerContactPersonTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildWholesalePartnerContactPerson|array|mixed the result, formatted by the current formatter
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
     * @return ChildWholesalePartnerContactPersonQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(WholesalePartnerContactPersonTableMap::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildWholesalePartnerContactPersonQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(WholesalePartnerContactPersonTableMap::ID, $keys, Criteria::IN);
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
     * @return ChildWholesalePartnerContactPersonQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(WholesalePartnerContactPersonTableMap::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(WholesalePartnerContactPersonTableMap::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(WholesalePartnerContactPersonTableMap::ID, $id, $comparison);
    }

    /**
     * Filter the query on the title column
     *
     * Example usage:
     * <code>
     * $query->filterByTitle(1234); // WHERE title = 1234
     * $query->filterByTitle(array(12, 34)); // WHERE title IN (12, 34)
     * $query->filterByTitle(array('min' => 12)); // WHERE title > 12
     * </code>
     *
     * @see       filterByCustomerTitle()
     *
     * @param     mixed $title The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildWholesalePartnerContactPersonQuery The current query, for fluid interface
     */
    public function filterByTitle($title = null, $comparison = null)
    {
        if (is_array($title)) {
            $useMinMax = false;
            if (isset($title['min'])) {
                $this->addUsingAlias(WholesalePartnerContactPersonTableMap::TITLE, $title['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($title['max'])) {
                $this->addUsingAlias(WholesalePartnerContactPersonTableMap::TITLE, $title['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(WholesalePartnerContactPersonTableMap::TITLE, $title, $comparison);
    }

    /**
     * Filter the query on the firstname column
     *
     * Example usage:
     * <code>
     * $query->filterByFirstname('fooValue');   // WHERE firstname = 'fooValue'
     * $query->filterByFirstname('%fooValue%'); // WHERE firstname LIKE '%fooValue%'
     * </code>
     *
     * @param     string $firstname The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildWholesalePartnerContactPersonQuery The current query, for fluid interface
     */
    public function filterByFirstname($firstname = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($firstname)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $firstname)) {
                $firstname = str_replace('*', '%', $firstname);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(WholesalePartnerContactPersonTableMap::FIRSTNAME, $firstname, $comparison);
    }

    /**
     * Filter the query on the lastname column
     *
     * Example usage:
     * <code>
     * $query->filterByLastname('fooValue');   // WHERE lastname = 'fooValue'
     * $query->filterByLastname('%fooValue%'); // WHERE lastname LIKE '%fooValue%'
     * </code>
     *
     * @param     string $lastname The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildWholesalePartnerContactPersonQuery The current query, for fluid interface
     */
    public function filterByLastname($lastname = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($lastname)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $lastname)) {
                $lastname = str_replace('*', '%', $lastname);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(WholesalePartnerContactPersonTableMap::LASTNAME, $lastname, $comparison);
    }

    /**
     * Filter the query on the telefon column
     *
     * Example usage:
     * <code>
     * $query->filterByTelefon('fooValue');   // WHERE telefon = 'fooValue'
     * $query->filterByTelefon('%fooValue%'); // WHERE telefon LIKE '%fooValue%'
     * </code>
     *
     * @param     string $telefon The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildWholesalePartnerContactPersonQuery The current query, for fluid interface
     */
    public function filterByTelefon($telefon = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($telefon)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $telefon)) {
                $telefon = str_replace('*', '%', $telefon);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(WholesalePartnerContactPersonTableMap::TELEFON, $telefon, $comparison);
    }

    /**
     * Filter the query on the email column
     *
     * Example usage:
     * <code>
     * $query->filterByEmail('fooValue');   // WHERE email = 'fooValue'
     * $query->filterByEmail('%fooValue%'); // WHERE email LIKE '%fooValue%'
     * </code>
     *
     * @param     string $email The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildWholesalePartnerContactPersonQuery The current query, for fluid interface
     */
    public function filterByEmail($email = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($email)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $email)) {
                $email = str_replace('*', '%', $email);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(WholesalePartnerContactPersonTableMap::EMAIL, $email, $comparison);
    }

    /**
     * Filter the query on the profile_website column
     *
     * Example usage:
     * <code>
     * $query->filterByProfileWebsite('fooValue');   // WHERE profile_website = 'fooValue'
     * $query->filterByProfileWebsite('%fooValue%'); // WHERE profile_website LIKE '%fooValue%'
     * </code>
     *
     * @param     string $profileWebsite The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildWholesalePartnerContactPersonQuery The current query, for fluid interface
     */
    public function filterByProfileWebsite($profileWebsite = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($profileWebsite)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $profileWebsite)) {
                $profileWebsite = str_replace('*', '%', $profileWebsite);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(WholesalePartnerContactPersonTableMap::PROFILE_WEBSITE, $profileWebsite, $comparison);
    }

    /**
     * Filter the query on the position column
     *
     * Example usage:
     * <code>
     * $query->filterByPosition('fooValue');   // WHERE position = 'fooValue'
     * $query->filterByPosition('%fooValue%'); // WHERE position LIKE '%fooValue%'
     * </code>
     *
     * @param     string $position The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildWholesalePartnerContactPersonQuery The current query, for fluid interface
     */
    public function filterByPosition($position = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($position)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $position)) {
                $position = str_replace('*', '%', $position);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(WholesalePartnerContactPersonTableMap::POSITION, $position, $comparison);
    }

    /**
     * Filter the query on the department column
     *
     * Example usage:
     * <code>
     * $query->filterByDepartment('fooValue');   // WHERE department = 'fooValue'
     * $query->filterByDepartment('%fooValue%'); // WHERE department LIKE '%fooValue%'
     * </code>
     *
     * @param     string $department The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildWholesalePartnerContactPersonQuery The current query, for fluid interface
     */
    public function filterByDepartment($department = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($department)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $department)) {
                $department = str_replace('*', '%', $department);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(WholesalePartnerContactPersonTableMap::DEPARTMENT, $department, $comparison);
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
     * @return ChildWholesalePartnerContactPersonQuery The current query, for fluid interface
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

        return $this->addUsingAlias(WholesalePartnerContactPersonTableMap::COMMENT, $comment, $comparison);
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
     * @return ChildWholesalePartnerContactPersonQuery The current query, for fluid interface
     */
    public function filterByVersion($version = null, $comparison = null)
    {
        if (is_array($version)) {
            $useMinMax = false;
            if (isset($version['min'])) {
                $this->addUsingAlias(WholesalePartnerContactPersonTableMap::VERSION, $version['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($version['max'])) {
                $this->addUsingAlias(WholesalePartnerContactPersonTableMap::VERSION, $version['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(WholesalePartnerContactPersonTableMap::VERSION, $version, $comparison);
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
     * @return ChildWholesalePartnerContactPersonQuery The current query, for fluid interface
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

        return $this->addUsingAlias(WholesalePartnerContactPersonTableMap::VERSION_CREATED_BY, $versionCreatedBy, $comparison);
    }

    /**
     * Filter the query by a related \Thelia\Model\CustomerTitle object
     *
     * @param \Thelia\Model\CustomerTitle|ObjectCollection $customerTitle The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildWholesalePartnerContactPersonQuery The current query, for fluid interface
     */
    public function filterByCustomerTitle($customerTitle, $comparison = null)
    {
        if ($customerTitle instanceof \Thelia\Model\CustomerTitle) {
            return $this
                ->addUsingAlias(WholesalePartnerContactPersonTableMap::TITLE, $customerTitle->getId(), $comparison);
        } elseif ($customerTitle instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(WholesalePartnerContactPersonTableMap::TITLE, $customerTitle->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByCustomerTitle() only accepts arguments of type \Thelia\Model\CustomerTitle or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the CustomerTitle relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildWholesalePartnerContactPersonQuery The current query, for fluid interface
     */
    public function joinCustomerTitle($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('CustomerTitle');

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
            $this->addJoinObject($join, 'CustomerTitle');
        }

        return $this;
    }

    /**
     * Use the CustomerTitle relation CustomerTitle object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Thelia\Model\CustomerTitleQuery A secondary query class using the current class as primary query
     */
    public function useCustomerTitleQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinCustomerTitle($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'CustomerTitle', '\Thelia\Model\CustomerTitleQuery');
    }

    /**
     * Filter the query by a related \RevenueDashboard\Model\WholesalePartnerContactPersonVersion object
     *
     * @param \RevenueDashboard\Model\WholesalePartnerContactPersonVersion|ObjectCollection $wholesalePartnerContactPersonVersion  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildWholesalePartnerContactPersonQuery The current query, for fluid interface
     */
    public function filterByWholesalePartnerContactPersonVersion($wholesalePartnerContactPersonVersion, $comparison = null)
    {
        if ($wholesalePartnerContactPersonVersion instanceof \RevenueDashboard\Model\WholesalePartnerContactPersonVersion) {
            return $this
                ->addUsingAlias(WholesalePartnerContactPersonTableMap::ID, $wholesalePartnerContactPersonVersion->getId(), $comparison);
        } elseif ($wholesalePartnerContactPersonVersion instanceof ObjectCollection) {
            return $this
                ->useWholesalePartnerContactPersonVersionQuery()
                ->filterByPrimaryKeys($wholesalePartnerContactPersonVersion->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByWholesalePartnerContactPersonVersion() only accepts arguments of type \RevenueDashboard\Model\WholesalePartnerContactPersonVersion or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the WholesalePartnerContactPersonVersion relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildWholesalePartnerContactPersonQuery The current query, for fluid interface
     */
    public function joinWholesalePartnerContactPersonVersion($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('WholesalePartnerContactPersonVersion');

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
            $this->addJoinObject($join, 'WholesalePartnerContactPersonVersion');
        }

        return $this;
    }

    /**
     * Use the WholesalePartnerContactPersonVersion relation WholesalePartnerContactPersonVersion object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \RevenueDashboard\Model\WholesalePartnerContactPersonVersionQuery A secondary query class using the current class as primary query
     */
    public function useWholesalePartnerContactPersonVersionQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinWholesalePartnerContactPersonVersion($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'WholesalePartnerContactPersonVersion', '\RevenueDashboard\Model\WholesalePartnerContactPersonVersionQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildWholesalePartnerContactPerson $wholesalePartnerContactPerson Object to remove from the list of results
     *
     * @return ChildWholesalePartnerContactPersonQuery The current query, for fluid interface
     */
    public function prune($wholesalePartnerContactPerson = null)
    {
        if ($wholesalePartnerContactPerson) {
            $this->addUsingAlias(WholesalePartnerContactPersonTableMap::ID, $wholesalePartnerContactPerson->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the wholesale_partner_contact_person table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(WholesalePartnerContactPersonTableMap::DATABASE_NAME);
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
            WholesalePartnerContactPersonTableMap::clearInstancePool();
            WholesalePartnerContactPersonTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildWholesalePartnerContactPerson or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildWholesalePartnerContactPerson object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(WholesalePartnerContactPersonTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(WholesalePartnerContactPersonTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            

        WholesalePartnerContactPersonTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            WholesalePartnerContactPersonTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
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

} // WholesalePartnerContactPersonQuery
