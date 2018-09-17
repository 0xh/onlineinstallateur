<?php

namespace HookConfigurator\Model\Base;

use \Exception;
use \PDO;
use HookConfigurator\Model\ConfiguratorEmail as ChildConfiguratorEmail;
use HookConfigurator\Model\ConfiguratorEmailQuery as ChildConfiguratorEmailQuery;
use HookConfigurator\Model\Map\ConfiguratorEmailTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'configurator_email' table.
 *
 * 
 *
 * @method     ChildConfiguratorEmailQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildConfiguratorEmailQuery orderByWithSearchResult($order = Criteria::ASC) Order by the with_search_result column
 * @method     ChildConfiguratorEmailQuery orderByIdCategorySearch($order = Criteria::ASC) Order by the id_category_search column
 * @method     ChildConfiguratorEmailQuery orderByVisibleFormContact($order = Criteria::ASC) Order by the visible_form_contact column
 * @method     ChildConfiguratorEmailQuery orderByRequiredVorname($order = Criteria::ASC) Order by the required_vorname column
 * @method     ChildConfiguratorEmailQuery orderByVisibleVorname($order = Criteria::ASC) Order by the visible_vorname column
 * @method     ChildConfiguratorEmailQuery orderByRequiredNachname($order = Criteria::ASC) Order by the required_nachname column
 * @method     ChildConfiguratorEmailQuery orderByVisibleNachname($order = Criteria::ASC) Order by the visible_nachname column
 * @method     ChildConfiguratorEmailQuery orderByRequiredStr($order = Criteria::ASC) Order by the required_str column
 * @method     ChildConfiguratorEmailQuery orderByVisibleStr($order = Criteria::ASC) Order by the visible_str column
 * @method     ChildConfiguratorEmailQuery orderByRequiredPlz($order = Criteria::ASC) Order by the required_plz column
 * @method     ChildConfiguratorEmailQuery orderByVisiblePlz($order = Criteria::ASC) Order by the visible_plz column
 * @method     ChildConfiguratorEmailQuery orderByRequiredOrt($order = Criteria::ASC) Order by the required_ort column
 * @method     ChildConfiguratorEmailQuery orderByVisibleOrt($order = Criteria::ASC) Order by the visible_ort column
 * @method     ChildConfiguratorEmailQuery orderByRequiredTelefon($order = Criteria::ASC) Order by the required_telefon column
 * @method     ChildConfiguratorEmailQuery orderByVisibleTelefon($order = Criteria::ASC) Order by the visible_telefon column
 * @method     ChildConfiguratorEmailQuery orderByRequiredEmail($order = Criteria::ASC) Order by the required_email column
 * @method     ChildConfiguratorEmailQuery orderByVisibleEmail($order = Criteria::ASC) Order by the visible_email column
 * @method     ChildConfiguratorEmailQuery orderByRequiredTerms($order = Criteria::ASC) Order by the required_terms column
 * @method     ChildConfiguratorEmailQuery orderByVisibleTerms($order = Criteria::ASC) Order by the visible_terms column
 * @method     ChildConfiguratorEmailQuery orderByRequiredSend($order = Criteria::ASC) Order by the required_send column
 * @method     ChildConfiguratorEmailQuery orderByVisibleSend($order = Criteria::ASC) Order by the visible_send column
 * @method     ChildConfiguratorEmailQuery orderBySendEmail($order = Criteria::ASC) Order by the send_email column
 * @method     ChildConfiguratorEmailQuery orderByTemplateEmailNameCustomer($order = Criteria::ASC) Order by the template_email_name_customer column
 * @method     ChildConfiguratorEmailQuery orderByTemplateEmailNameAdmin($order = Criteria::ASC) Order by the template_email_name_admin column
 * @method     ChildConfiguratorEmailQuery orderByTemplateRedirectSearch($order = Criteria::ASC) Order by the template_redirect_search column
 *
 * @method     ChildConfiguratorEmailQuery groupById() Group by the id column
 * @method     ChildConfiguratorEmailQuery groupByWithSearchResult() Group by the with_search_result column
 * @method     ChildConfiguratorEmailQuery groupByIdCategorySearch() Group by the id_category_search column
 * @method     ChildConfiguratorEmailQuery groupByVisibleFormContact() Group by the visible_form_contact column
 * @method     ChildConfiguratorEmailQuery groupByRequiredVorname() Group by the required_vorname column
 * @method     ChildConfiguratorEmailQuery groupByVisibleVorname() Group by the visible_vorname column
 * @method     ChildConfiguratorEmailQuery groupByRequiredNachname() Group by the required_nachname column
 * @method     ChildConfiguratorEmailQuery groupByVisibleNachname() Group by the visible_nachname column
 * @method     ChildConfiguratorEmailQuery groupByRequiredStr() Group by the required_str column
 * @method     ChildConfiguratorEmailQuery groupByVisibleStr() Group by the visible_str column
 * @method     ChildConfiguratorEmailQuery groupByRequiredPlz() Group by the required_plz column
 * @method     ChildConfiguratorEmailQuery groupByVisiblePlz() Group by the visible_plz column
 * @method     ChildConfiguratorEmailQuery groupByRequiredOrt() Group by the required_ort column
 * @method     ChildConfiguratorEmailQuery groupByVisibleOrt() Group by the visible_ort column
 * @method     ChildConfiguratorEmailQuery groupByRequiredTelefon() Group by the required_telefon column
 * @method     ChildConfiguratorEmailQuery groupByVisibleTelefon() Group by the visible_telefon column
 * @method     ChildConfiguratorEmailQuery groupByRequiredEmail() Group by the required_email column
 * @method     ChildConfiguratorEmailQuery groupByVisibleEmail() Group by the visible_email column
 * @method     ChildConfiguratorEmailQuery groupByRequiredTerms() Group by the required_terms column
 * @method     ChildConfiguratorEmailQuery groupByVisibleTerms() Group by the visible_terms column
 * @method     ChildConfiguratorEmailQuery groupByRequiredSend() Group by the required_send column
 * @method     ChildConfiguratorEmailQuery groupByVisibleSend() Group by the visible_send column
 * @method     ChildConfiguratorEmailQuery groupBySendEmail() Group by the send_email column
 * @method     ChildConfiguratorEmailQuery groupByTemplateEmailNameCustomer() Group by the template_email_name_customer column
 * @method     ChildConfiguratorEmailQuery groupByTemplateEmailNameAdmin() Group by the template_email_name_admin column
 * @method     ChildConfiguratorEmailQuery groupByTemplateRedirectSearch() Group by the template_redirect_search column
 *
 * @method     ChildConfiguratorEmailQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildConfiguratorEmailQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildConfiguratorEmailQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildConfiguratorEmail findOne(ConnectionInterface $con = null) Return the first ChildConfiguratorEmail matching the query
 * @method     ChildConfiguratorEmail findOneOrCreate(ConnectionInterface $con = null) Return the first ChildConfiguratorEmail matching the query, or a new ChildConfiguratorEmail object populated from the query conditions when no match is found
 *
 * @method     ChildConfiguratorEmail findOneById(int $id) Return the first ChildConfiguratorEmail filtered by the id column
 * @method     ChildConfiguratorEmail findOneByWithSearchResult(int $with_search_result) Return the first ChildConfiguratorEmail filtered by the with_search_result column
 * @method     ChildConfiguratorEmail findOneByIdCategorySearch(int $id_category_search) Return the first ChildConfiguratorEmail filtered by the id_category_search column
 * @method     ChildConfiguratorEmail findOneByVisibleFormContact(int $visible_form_contact) Return the first ChildConfiguratorEmail filtered by the visible_form_contact column
 * @method     ChildConfiguratorEmail findOneByRequiredVorname(int $required_vorname) Return the first ChildConfiguratorEmail filtered by the required_vorname column
 * @method     ChildConfiguratorEmail findOneByVisibleVorname(int $visible_vorname) Return the first ChildConfiguratorEmail filtered by the visible_vorname column
 * @method     ChildConfiguratorEmail findOneByRequiredNachname(int $required_nachname) Return the first ChildConfiguratorEmail filtered by the required_nachname column
 * @method     ChildConfiguratorEmail findOneByVisibleNachname(int $visible_nachname) Return the first ChildConfiguratorEmail filtered by the visible_nachname column
 * @method     ChildConfiguratorEmail findOneByRequiredStr(int $required_str) Return the first ChildConfiguratorEmail filtered by the required_str column
 * @method     ChildConfiguratorEmail findOneByVisibleStr(int $visible_str) Return the first ChildConfiguratorEmail filtered by the visible_str column
 * @method     ChildConfiguratorEmail findOneByRequiredPlz(int $required_plz) Return the first ChildConfiguratorEmail filtered by the required_plz column
 * @method     ChildConfiguratorEmail findOneByVisiblePlz(int $visible_plz) Return the first ChildConfiguratorEmail filtered by the visible_plz column
 * @method     ChildConfiguratorEmail findOneByRequiredOrt(int $required_ort) Return the first ChildConfiguratorEmail filtered by the required_ort column
 * @method     ChildConfiguratorEmail findOneByVisibleOrt(int $visible_ort) Return the first ChildConfiguratorEmail filtered by the visible_ort column
 * @method     ChildConfiguratorEmail findOneByRequiredTelefon(int $required_telefon) Return the first ChildConfiguratorEmail filtered by the required_telefon column
 * @method     ChildConfiguratorEmail findOneByVisibleTelefon(int $visible_telefon) Return the first ChildConfiguratorEmail filtered by the visible_telefon column
 * @method     ChildConfiguratorEmail findOneByRequiredEmail(int $required_email) Return the first ChildConfiguratorEmail filtered by the required_email column
 * @method     ChildConfiguratorEmail findOneByVisibleEmail(int $visible_email) Return the first ChildConfiguratorEmail filtered by the visible_email column
 * @method     ChildConfiguratorEmail findOneByRequiredTerms(int $required_terms) Return the first ChildConfiguratorEmail filtered by the required_terms column
 * @method     ChildConfiguratorEmail findOneByVisibleTerms(int $visible_terms) Return the first ChildConfiguratorEmail filtered by the visible_terms column
 * @method     ChildConfiguratorEmail findOneByRequiredSend(int $required_send) Return the first ChildConfiguratorEmail filtered by the required_send column
 * @method     ChildConfiguratorEmail findOneByVisibleSend(int $visible_send) Return the first ChildConfiguratorEmail filtered by the visible_send column
 * @method     ChildConfiguratorEmail findOneBySendEmail(int $send_email) Return the first ChildConfiguratorEmail filtered by the send_email column
 * @method     ChildConfiguratorEmail findOneByTemplateEmailNameCustomer(string $template_email_name_customer) Return the first ChildConfiguratorEmail filtered by the template_email_name_customer column
 * @method     ChildConfiguratorEmail findOneByTemplateEmailNameAdmin(string $template_email_name_admin) Return the first ChildConfiguratorEmail filtered by the template_email_name_admin column
 * @method     ChildConfiguratorEmail findOneByTemplateRedirectSearch(string $template_redirect_search) Return the first ChildConfiguratorEmail filtered by the template_redirect_search column
 *
 * @method     array findById(int $id) Return ChildConfiguratorEmail objects filtered by the id column
 * @method     array findByWithSearchResult(int $with_search_result) Return ChildConfiguratorEmail objects filtered by the with_search_result column
 * @method     array findByIdCategorySearch(int $id_category_search) Return ChildConfiguratorEmail objects filtered by the id_category_search column
 * @method     array findByVisibleFormContact(int $visible_form_contact) Return ChildConfiguratorEmail objects filtered by the visible_form_contact column
 * @method     array findByRequiredVorname(int $required_vorname) Return ChildConfiguratorEmail objects filtered by the required_vorname column
 * @method     array findByVisibleVorname(int $visible_vorname) Return ChildConfiguratorEmail objects filtered by the visible_vorname column
 * @method     array findByRequiredNachname(int $required_nachname) Return ChildConfiguratorEmail objects filtered by the required_nachname column
 * @method     array findByVisibleNachname(int $visible_nachname) Return ChildConfiguratorEmail objects filtered by the visible_nachname column
 * @method     array findByRequiredStr(int $required_str) Return ChildConfiguratorEmail objects filtered by the required_str column
 * @method     array findByVisibleStr(int $visible_str) Return ChildConfiguratorEmail objects filtered by the visible_str column
 * @method     array findByRequiredPlz(int $required_plz) Return ChildConfiguratorEmail objects filtered by the required_plz column
 * @method     array findByVisiblePlz(int $visible_plz) Return ChildConfiguratorEmail objects filtered by the visible_plz column
 * @method     array findByRequiredOrt(int $required_ort) Return ChildConfiguratorEmail objects filtered by the required_ort column
 * @method     array findByVisibleOrt(int $visible_ort) Return ChildConfiguratorEmail objects filtered by the visible_ort column
 * @method     array findByRequiredTelefon(int $required_telefon) Return ChildConfiguratorEmail objects filtered by the required_telefon column
 * @method     array findByVisibleTelefon(int $visible_telefon) Return ChildConfiguratorEmail objects filtered by the visible_telefon column
 * @method     array findByRequiredEmail(int $required_email) Return ChildConfiguratorEmail objects filtered by the required_email column
 * @method     array findByVisibleEmail(int $visible_email) Return ChildConfiguratorEmail objects filtered by the visible_email column
 * @method     array findByRequiredTerms(int $required_terms) Return ChildConfiguratorEmail objects filtered by the required_terms column
 * @method     array findByVisibleTerms(int $visible_terms) Return ChildConfiguratorEmail objects filtered by the visible_terms column
 * @method     array findByRequiredSend(int $required_send) Return ChildConfiguratorEmail objects filtered by the required_send column
 * @method     array findByVisibleSend(int $visible_send) Return ChildConfiguratorEmail objects filtered by the visible_send column
 * @method     array findBySendEmail(int $send_email) Return ChildConfiguratorEmail objects filtered by the send_email column
 * @method     array findByTemplateEmailNameCustomer(string $template_email_name_customer) Return ChildConfiguratorEmail objects filtered by the template_email_name_customer column
 * @method     array findByTemplateEmailNameAdmin(string $template_email_name_admin) Return ChildConfiguratorEmail objects filtered by the template_email_name_admin column
 * @method     array findByTemplateRedirectSearch(string $template_redirect_search) Return ChildConfiguratorEmail objects filtered by the template_redirect_search column
 *
 */
abstract class ConfiguratorEmailQuery extends ModelCriteria
{
    
    /**
     * Initializes internal state of \HookConfigurator\Model\Base\ConfiguratorEmailQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'thelia', $modelName = '\\HookConfigurator\\Model\\ConfiguratorEmail', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildConfiguratorEmailQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildConfiguratorEmailQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \HookConfigurator\Model\ConfiguratorEmailQuery) {
            return $criteria;
        }
        $query = new \HookConfigurator\Model\ConfiguratorEmailQuery();
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
     * @return ChildConfiguratorEmail|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ConfiguratorEmailTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ConfiguratorEmailTableMap::DATABASE_NAME);
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
     * @return   ChildConfiguratorEmail A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ID, WITH_SEARCH_RESULT, ID_CATEGORY_SEARCH, VISIBLE_FORM_CONTACT, REQUIRED_VORNAME, VISIBLE_VORNAME, REQUIRED_NACHNAME, VISIBLE_NACHNAME, REQUIRED_STR, VISIBLE_STR, REQUIRED_PLZ, VISIBLE_PLZ, REQUIRED_ORT, VISIBLE_ORT, REQUIRED_TELEFON, VISIBLE_TELEFON, REQUIRED_EMAIL, VISIBLE_EMAIL, REQUIRED_TERMS, VISIBLE_TERMS, REQUIRED_SEND, VISIBLE_SEND, SEND_EMAIL, TEMPLATE_EMAIL_NAME_CUSTOMER, TEMPLATE_EMAIL_NAME_ADMIN, TEMPLATE_REDIRECT_SEARCH FROM configurator_email WHERE ID = :p0';
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
            $obj = new ChildConfiguratorEmail();
            $obj->hydrate($row);
            ConfiguratorEmailTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildConfiguratorEmail|array|mixed the result, formatted by the current formatter
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
     * @return ChildConfiguratorEmailQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ConfiguratorEmailTableMap::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildConfiguratorEmailQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ConfiguratorEmailTableMap::ID, $keys, Criteria::IN);
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
     * @return ChildConfiguratorEmailQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(ConfiguratorEmailTableMap::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(ConfiguratorEmailTableMap::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ConfiguratorEmailTableMap::ID, $id, $comparison);
    }

    /**
     * Filter the query on the with_search_result column
     *
     * Example usage:
     * <code>
     * $query->filterByWithSearchResult(1234); // WHERE with_search_result = 1234
     * $query->filterByWithSearchResult(array(12, 34)); // WHERE with_search_result IN (12, 34)
     * $query->filterByWithSearchResult(array('min' => 12)); // WHERE with_search_result > 12
     * </code>
     *
     * @param     mixed $withSearchResult The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildConfiguratorEmailQuery The current query, for fluid interface
     */
    public function filterByWithSearchResult($withSearchResult = null, $comparison = null)
    {
        if (is_array($withSearchResult)) {
            $useMinMax = false;
            if (isset($withSearchResult['min'])) {
                $this->addUsingAlias(ConfiguratorEmailTableMap::WITH_SEARCH_RESULT, $withSearchResult['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($withSearchResult['max'])) {
                $this->addUsingAlias(ConfiguratorEmailTableMap::WITH_SEARCH_RESULT, $withSearchResult['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ConfiguratorEmailTableMap::WITH_SEARCH_RESULT, $withSearchResult, $comparison);
    }

    /**
     * Filter the query on the id_category_search column
     *
     * Example usage:
     * <code>
     * $query->filterByIdCategorySearch(1234); // WHERE id_category_search = 1234
     * $query->filterByIdCategorySearch(array(12, 34)); // WHERE id_category_search IN (12, 34)
     * $query->filterByIdCategorySearch(array('min' => 12)); // WHERE id_category_search > 12
     * </code>
     *
     * @param     mixed $idCategorySearch The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildConfiguratorEmailQuery The current query, for fluid interface
     */
    public function filterByIdCategorySearch($idCategorySearch = null, $comparison = null)
    {
        if (is_array($idCategorySearch)) {
            $useMinMax = false;
            if (isset($idCategorySearch['min'])) {
                $this->addUsingAlias(ConfiguratorEmailTableMap::ID_CATEGORY_SEARCH, $idCategorySearch['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idCategorySearch['max'])) {
                $this->addUsingAlias(ConfiguratorEmailTableMap::ID_CATEGORY_SEARCH, $idCategorySearch['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ConfiguratorEmailTableMap::ID_CATEGORY_SEARCH, $idCategorySearch, $comparison);
    }

    /**
     * Filter the query on the visible_form_contact column
     *
     * Example usage:
     * <code>
     * $query->filterByVisibleFormContact(1234); // WHERE visible_form_contact = 1234
     * $query->filterByVisibleFormContact(array(12, 34)); // WHERE visible_form_contact IN (12, 34)
     * $query->filterByVisibleFormContact(array('min' => 12)); // WHERE visible_form_contact > 12
     * </code>
     *
     * @param     mixed $visibleFormContact The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildConfiguratorEmailQuery The current query, for fluid interface
     */
    public function filterByVisibleFormContact($visibleFormContact = null, $comparison = null)
    {
        if (is_array($visibleFormContact)) {
            $useMinMax = false;
            if (isset($visibleFormContact['min'])) {
                $this->addUsingAlias(ConfiguratorEmailTableMap::VISIBLE_FORM_CONTACT, $visibleFormContact['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($visibleFormContact['max'])) {
                $this->addUsingAlias(ConfiguratorEmailTableMap::VISIBLE_FORM_CONTACT, $visibleFormContact['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ConfiguratorEmailTableMap::VISIBLE_FORM_CONTACT, $visibleFormContact, $comparison);
    }

    /**
     * Filter the query on the required_vorname column
     *
     * Example usage:
     * <code>
     * $query->filterByRequiredVorname(1234); // WHERE required_vorname = 1234
     * $query->filterByRequiredVorname(array(12, 34)); // WHERE required_vorname IN (12, 34)
     * $query->filterByRequiredVorname(array('min' => 12)); // WHERE required_vorname > 12
     * </code>
     *
     * @param     mixed $requiredVorname The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildConfiguratorEmailQuery The current query, for fluid interface
     */
    public function filterByRequiredVorname($requiredVorname = null, $comparison = null)
    {
        if (is_array($requiredVorname)) {
            $useMinMax = false;
            if (isset($requiredVorname['min'])) {
                $this->addUsingAlias(ConfiguratorEmailTableMap::REQUIRED_VORNAME, $requiredVorname['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($requiredVorname['max'])) {
                $this->addUsingAlias(ConfiguratorEmailTableMap::REQUIRED_VORNAME, $requiredVorname['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ConfiguratorEmailTableMap::REQUIRED_VORNAME, $requiredVorname, $comparison);
    }

    /**
     * Filter the query on the visible_vorname column
     *
     * Example usage:
     * <code>
     * $query->filterByVisibleVorname(1234); // WHERE visible_vorname = 1234
     * $query->filterByVisibleVorname(array(12, 34)); // WHERE visible_vorname IN (12, 34)
     * $query->filterByVisibleVorname(array('min' => 12)); // WHERE visible_vorname > 12
     * </code>
     *
     * @param     mixed $visibleVorname The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildConfiguratorEmailQuery The current query, for fluid interface
     */
    public function filterByVisibleVorname($visibleVorname = null, $comparison = null)
    {
        if (is_array($visibleVorname)) {
            $useMinMax = false;
            if (isset($visibleVorname['min'])) {
                $this->addUsingAlias(ConfiguratorEmailTableMap::VISIBLE_VORNAME, $visibleVorname['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($visibleVorname['max'])) {
                $this->addUsingAlias(ConfiguratorEmailTableMap::VISIBLE_VORNAME, $visibleVorname['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ConfiguratorEmailTableMap::VISIBLE_VORNAME, $visibleVorname, $comparison);
    }

    /**
     * Filter the query on the required_nachname column
     *
     * Example usage:
     * <code>
     * $query->filterByRequiredNachname(1234); // WHERE required_nachname = 1234
     * $query->filterByRequiredNachname(array(12, 34)); // WHERE required_nachname IN (12, 34)
     * $query->filterByRequiredNachname(array('min' => 12)); // WHERE required_nachname > 12
     * </code>
     *
     * @param     mixed $requiredNachname The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildConfiguratorEmailQuery The current query, for fluid interface
     */
    public function filterByRequiredNachname($requiredNachname = null, $comparison = null)
    {
        if (is_array($requiredNachname)) {
            $useMinMax = false;
            if (isset($requiredNachname['min'])) {
                $this->addUsingAlias(ConfiguratorEmailTableMap::REQUIRED_NACHNAME, $requiredNachname['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($requiredNachname['max'])) {
                $this->addUsingAlias(ConfiguratorEmailTableMap::REQUIRED_NACHNAME, $requiredNachname['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ConfiguratorEmailTableMap::REQUIRED_NACHNAME, $requiredNachname, $comparison);
    }

    /**
     * Filter the query on the visible_nachname column
     *
     * Example usage:
     * <code>
     * $query->filterByVisibleNachname(1234); // WHERE visible_nachname = 1234
     * $query->filterByVisibleNachname(array(12, 34)); // WHERE visible_nachname IN (12, 34)
     * $query->filterByVisibleNachname(array('min' => 12)); // WHERE visible_nachname > 12
     * </code>
     *
     * @param     mixed $visibleNachname The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildConfiguratorEmailQuery The current query, for fluid interface
     */
    public function filterByVisibleNachname($visibleNachname = null, $comparison = null)
    {
        if (is_array($visibleNachname)) {
            $useMinMax = false;
            if (isset($visibleNachname['min'])) {
                $this->addUsingAlias(ConfiguratorEmailTableMap::VISIBLE_NACHNAME, $visibleNachname['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($visibleNachname['max'])) {
                $this->addUsingAlias(ConfiguratorEmailTableMap::VISIBLE_NACHNAME, $visibleNachname['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ConfiguratorEmailTableMap::VISIBLE_NACHNAME, $visibleNachname, $comparison);
    }

    /**
     * Filter the query on the required_str column
     *
     * Example usage:
     * <code>
     * $query->filterByRequiredStr(1234); // WHERE required_str = 1234
     * $query->filterByRequiredStr(array(12, 34)); // WHERE required_str IN (12, 34)
     * $query->filterByRequiredStr(array('min' => 12)); // WHERE required_str > 12
     * </code>
     *
     * @param     mixed $requiredStr The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildConfiguratorEmailQuery The current query, for fluid interface
     */
    public function filterByRequiredStr($requiredStr = null, $comparison = null)
    {
        if (is_array($requiredStr)) {
            $useMinMax = false;
            if (isset($requiredStr['min'])) {
                $this->addUsingAlias(ConfiguratorEmailTableMap::REQUIRED_STR, $requiredStr['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($requiredStr['max'])) {
                $this->addUsingAlias(ConfiguratorEmailTableMap::REQUIRED_STR, $requiredStr['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ConfiguratorEmailTableMap::REQUIRED_STR, $requiredStr, $comparison);
    }

    /**
     * Filter the query on the visible_str column
     *
     * Example usage:
     * <code>
     * $query->filterByVisibleStr(1234); // WHERE visible_str = 1234
     * $query->filterByVisibleStr(array(12, 34)); // WHERE visible_str IN (12, 34)
     * $query->filterByVisibleStr(array('min' => 12)); // WHERE visible_str > 12
     * </code>
     *
     * @param     mixed $visibleStr The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildConfiguratorEmailQuery The current query, for fluid interface
     */
    public function filterByVisibleStr($visibleStr = null, $comparison = null)
    {
        if (is_array($visibleStr)) {
            $useMinMax = false;
            if (isset($visibleStr['min'])) {
                $this->addUsingAlias(ConfiguratorEmailTableMap::VISIBLE_STR, $visibleStr['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($visibleStr['max'])) {
                $this->addUsingAlias(ConfiguratorEmailTableMap::VISIBLE_STR, $visibleStr['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ConfiguratorEmailTableMap::VISIBLE_STR, $visibleStr, $comparison);
    }

    /**
     * Filter the query on the required_plz column
     *
     * Example usage:
     * <code>
     * $query->filterByRequiredPlz(1234); // WHERE required_plz = 1234
     * $query->filterByRequiredPlz(array(12, 34)); // WHERE required_plz IN (12, 34)
     * $query->filterByRequiredPlz(array('min' => 12)); // WHERE required_plz > 12
     * </code>
     *
     * @param     mixed $requiredPlz The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildConfiguratorEmailQuery The current query, for fluid interface
     */
    public function filterByRequiredPlz($requiredPlz = null, $comparison = null)
    {
        if (is_array($requiredPlz)) {
            $useMinMax = false;
            if (isset($requiredPlz['min'])) {
                $this->addUsingAlias(ConfiguratorEmailTableMap::REQUIRED_PLZ, $requiredPlz['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($requiredPlz['max'])) {
                $this->addUsingAlias(ConfiguratorEmailTableMap::REQUIRED_PLZ, $requiredPlz['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ConfiguratorEmailTableMap::REQUIRED_PLZ, $requiredPlz, $comparison);
    }

    /**
     * Filter the query on the visible_plz column
     *
     * Example usage:
     * <code>
     * $query->filterByVisiblePlz(1234); // WHERE visible_plz = 1234
     * $query->filterByVisiblePlz(array(12, 34)); // WHERE visible_plz IN (12, 34)
     * $query->filterByVisiblePlz(array('min' => 12)); // WHERE visible_plz > 12
     * </code>
     *
     * @param     mixed $visiblePlz The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildConfiguratorEmailQuery The current query, for fluid interface
     */
    public function filterByVisiblePlz($visiblePlz = null, $comparison = null)
    {
        if (is_array($visiblePlz)) {
            $useMinMax = false;
            if (isset($visiblePlz['min'])) {
                $this->addUsingAlias(ConfiguratorEmailTableMap::VISIBLE_PLZ, $visiblePlz['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($visiblePlz['max'])) {
                $this->addUsingAlias(ConfiguratorEmailTableMap::VISIBLE_PLZ, $visiblePlz['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ConfiguratorEmailTableMap::VISIBLE_PLZ, $visiblePlz, $comparison);
    }

    /**
     * Filter the query on the required_ort column
     *
     * Example usage:
     * <code>
     * $query->filterByRequiredOrt(1234); // WHERE required_ort = 1234
     * $query->filterByRequiredOrt(array(12, 34)); // WHERE required_ort IN (12, 34)
     * $query->filterByRequiredOrt(array('min' => 12)); // WHERE required_ort > 12
     * </code>
     *
     * @param     mixed $requiredOrt The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildConfiguratorEmailQuery The current query, for fluid interface
     */
    public function filterByRequiredOrt($requiredOrt = null, $comparison = null)
    {
        if (is_array($requiredOrt)) {
            $useMinMax = false;
            if (isset($requiredOrt['min'])) {
                $this->addUsingAlias(ConfiguratorEmailTableMap::REQUIRED_ORT, $requiredOrt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($requiredOrt['max'])) {
                $this->addUsingAlias(ConfiguratorEmailTableMap::REQUIRED_ORT, $requiredOrt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ConfiguratorEmailTableMap::REQUIRED_ORT, $requiredOrt, $comparison);
    }

    /**
     * Filter the query on the visible_ort column
     *
     * Example usage:
     * <code>
     * $query->filterByVisibleOrt(1234); // WHERE visible_ort = 1234
     * $query->filterByVisibleOrt(array(12, 34)); // WHERE visible_ort IN (12, 34)
     * $query->filterByVisibleOrt(array('min' => 12)); // WHERE visible_ort > 12
     * </code>
     *
     * @param     mixed $visibleOrt The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildConfiguratorEmailQuery The current query, for fluid interface
     */
    public function filterByVisibleOrt($visibleOrt = null, $comparison = null)
    {
        if (is_array($visibleOrt)) {
            $useMinMax = false;
            if (isset($visibleOrt['min'])) {
                $this->addUsingAlias(ConfiguratorEmailTableMap::VISIBLE_ORT, $visibleOrt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($visibleOrt['max'])) {
                $this->addUsingAlias(ConfiguratorEmailTableMap::VISIBLE_ORT, $visibleOrt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ConfiguratorEmailTableMap::VISIBLE_ORT, $visibleOrt, $comparison);
    }

    /**
     * Filter the query on the required_telefon column
     *
     * Example usage:
     * <code>
     * $query->filterByRequiredTelefon(1234); // WHERE required_telefon = 1234
     * $query->filterByRequiredTelefon(array(12, 34)); // WHERE required_telefon IN (12, 34)
     * $query->filterByRequiredTelefon(array('min' => 12)); // WHERE required_telefon > 12
     * </code>
     *
     * @param     mixed $requiredTelefon The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildConfiguratorEmailQuery The current query, for fluid interface
     */
    public function filterByRequiredTelefon($requiredTelefon = null, $comparison = null)
    {
        if (is_array($requiredTelefon)) {
            $useMinMax = false;
            if (isset($requiredTelefon['min'])) {
                $this->addUsingAlias(ConfiguratorEmailTableMap::REQUIRED_TELEFON, $requiredTelefon['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($requiredTelefon['max'])) {
                $this->addUsingAlias(ConfiguratorEmailTableMap::REQUIRED_TELEFON, $requiredTelefon['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ConfiguratorEmailTableMap::REQUIRED_TELEFON, $requiredTelefon, $comparison);
    }

    /**
     * Filter the query on the visible_telefon column
     *
     * Example usage:
     * <code>
     * $query->filterByVisibleTelefon(1234); // WHERE visible_telefon = 1234
     * $query->filterByVisibleTelefon(array(12, 34)); // WHERE visible_telefon IN (12, 34)
     * $query->filterByVisibleTelefon(array('min' => 12)); // WHERE visible_telefon > 12
     * </code>
     *
     * @param     mixed $visibleTelefon The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildConfiguratorEmailQuery The current query, for fluid interface
     */
    public function filterByVisibleTelefon($visibleTelefon = null, $comparison = null)
    {
        if (is_array($visibleTelefon)) {
            $useMinMax = false;
            if (isset($visibleTelefon['min'])) {
                $this->addUsingAlias(ConfiguratorEmailTableMap::VISIBLE_TELEFON, $visibleTelefon['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($visibleTelefon['max'])) {
                $this->addUsingAlias(ConfiguratorEmailTableMap::VISIBLE_TELEFON, $visibleTelefon['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ConfiguratorEmailTableMap::VISIBLE_TELEFON, $visibleTelefon, $comparison);
    }

    /**
     * Filter the query on the required_email column
     *
     * Example usage:
     * <code>
     * $query->filterByRequiredEmail(1234); // WHERE required_email = 1234
     * $query->filterByRequiredEmail(array(12, 34)); // WHERE required_email IN (12, 34)
     * $query->filterByRequiredEmail(array('min' => 12)); // WHERE required_email > 12
     * </code>
     *
     * @param     mixed $requiredEmail The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildConfiguratorEmailQuery The current query, for fluid interface
     */
    public function filterByRequiredEmail($requiredEmail = null, $comparison = null)
    {
        if (is_array($requiredEmail)) {
            $useMinMax = false;
            if (isset($requiredEmail['min'])) {
                $this->addUsingAlias(ConfiguratorEmailTableMap::REQUIRED_EMAIL, $requiredEmail['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($requiredEmail['max'])) {
                $this->addUsingAlias(ConfiguratorEmailTableMap::REQUIRED_EMAIL, $requiredEmail['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ConfiguratorEmailTableMap::REQUIRED_EMAIL, $requiredEmail, $comparison);
    }

    /**
     * Filter the query on the visible_email column
     *
     * Example usage:
     * <code>
     * $query->filterByVisibleEmail(1234); // WHERE visible_email = 1234
     * $query->filterByVisibleEmail(array(12, 34)); // WHERE visible_email IN (12, 34)
     * $query->filterByVisibleEmail(array('min' => 12)); // WHERE visible_email > 12
     * </code>
     *
     * @param     mixed $visibleEmail The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildConfiguratorEmailQuery The current query, for fluid interface
     */
    public function filterByVisibleEmail($visibleEmail = null, $comparison = null)
    {
        if (is_array($visibleEmail)) {
            $useMinMax = false;
            if (isset($visibleEmail['min'])) {
                $this->addUsingAlias(ConfiguratorEmailTableMap::VISIBLE_EMAIL, $visibleEmail['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($visibleEmail['max'])) {
                $this->addUsingAlias(ConfiguratorEmailTableMap::VISIBLE_EMAIL, $visibleEmail['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ConfiguratorEmailTableMap::VISIBLE_EMAIL, $visibleEmail, $comparison);
    }

    /**
     * Filter the query on the required_terms column
     *
     * Example usage:
     * <code>
     * $query->filterByRequiredTerms(1234); // WHERE required_terms = 1234
     * $query->filterByRequiredTerms(array(12, 34)); // WHERE required_terms IN (12, 34)
     * $query->filterByRequiredTerms(array('min' => 12)); // WHERE required_terms > 12
     * </code>
     *
     * @param     mixed $requiredTerms The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildConfiguratorEmailQuery The current query, for fluid interface
     */
    public function filterByRequiredTerms($requiredTerms = null, $comparison = null)
    {
        if (is_array($requiredTerms)) {
            $useMinMax = false;
            if (isset($requiredTerms['min'])) {
                $this->addUsingAlias(ConfiguratorEmailTableMap::REQUIRED_TERMS, $requiredTerms['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($requiredTerms['max'])) {
                $this->addUsingAlias(ConfiguratorEmailTableMap::REQUIRED_TERMS, $requiredTerms['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ConfiguratorEmailTableMap::REQUIRED_TERMS, $requiredTerms, $comparison);
    }

    /**
     * Filter the query on the visible_terms column
     *
     * Example usage:
     * <code>
     * $query->filterByVisibleTerms(1234); // WHERE visible_terms = 1234
     * $query->filterByVisibleTerms(array(12, 34)); // WHERE visible_terms IN (12, 34)
     * $query->filterByVisibleTerms(array('min' => 12)); // WHERE visible_terms > 12
     * </code>
     *
     * @param     mixed $visibleTerms The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildConfiguratorEmailQuery The current query, for fluid interface
     */
    public function filterByVisibleTerms($visibleTerms = null, $comparison = null)
    {
        if (is_array($visibleTerms)) {
            $useMinMax = false;
            if (isset($visibleTerms['min'])) {
                $this->addUsingAlias(ConfiguratorEmailTableMap::VISIBLE_TERMS, $visibleTerms['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($visibleTerms['max'])) {
                $this->addUsingAlias(ConfiguratorEmailTableMap::VISIBLE_TERMS, $visibleTerms['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ConfiguratorEmailTableMap::VISIBLE_TERMS, $visibleTerms, $comparison);
    }

    /**
     * Filter the query on the required_send column
     *
     * Example usage:
     * <code>
     * $query->filterByRequiredSend(1234); // WHERE required_send = 1234
     * $query->filterByRequiredSend(array(12, 34)); // WHERE required_send IN (12, 34)
     * $query->filterByRequiredSend(array('min' => 12)); // WHERE required_send > 12
     * </code>
     *
     * @param     mixed $requiredSend The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildConfiguratorEmailQuery The current query, for fluid interface
     */
    public function filterByRequiredSend($requiredSend = null, $comparison = null)
    {
        if (is_array($requiredSend)) {
            $useMinMax = false;
            if (isset($requiredSend['min'])) {
                $this->addUsingAlias(ConfiguratorEmailTableMap::REQUIRED_SEND, $requiredSend['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($requiredSend['max'])) {
                $this->addUsingAlias(ConfiguratorEmailTableMap::REQUIRED_SEND, $requiredSend['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ConfiguratorEmailTableMap::REQUIRED_SEND, $requiredSend, $comparison);
    }

    /**
     * Filter the query on the visible_send column
     *
     * Example usage:
     * <code>
     * $query->filterByVisibleSend(1234); // WHERE visible_send = 1234
     * $query->filterByVisibleSend(array(12, 34)); // WHERE visible_send IN (12, 34)
     * $query->filterByVisibleSend(array('min' => 12)); // WHERE visible_send > 12
     * </code>
     *
     * @param     mixed $visibleSend The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildConfiguratorEmailQuery The current query, for fluid interface
     */
    public function filterByVisibleSend($visibleSend = null, $comparison = null)
    {
        if (is_array($visibleSend)) {
            $useMinMax = false;
            if (isset($visibleSend['min'])) {
                $this->addUsingAlias(ConfiguratorEmailTableMap::VISIBLE_SEND, $visibleSend['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($visibleSend['max'])) {
                $this->addUsingAlias(ConfiguratorEmailTableMap::VISIBLE_SEND, $visibleSend['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ConfiguratorEmailTableMap::VISIBLE_SEND, $visibleSend, $comparison);
    }

    /**
     * Filter the query on the send_email column
     *
     * Example usage:
     * <code>
     * $query->filterBySendEmail(1234); // WHERE send_email = 1234
     * $query->filterBySendEmail(array(12, 34)); // WHERE send_email IN (12, 34)
     * $query->filterBySendEmail(array('min' => 12)); // WHERE send_email > 12
     * </code>
     *
     * @param     mixed $sendEmail The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildConfiguratorEmailQuery The current query, for fluid interface
     */
    public function filterBySendEmail($sendEmail = null, $comparison = null)
    {
        if (is_array($sendEmail)) {
            $useMinMax = false;
            if (isset($sendEmail['min'])) {
                $this->addUsingAlias(ConfiguratorEmailTableMap::SEND_EMAIL, $sendEmail['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($sendEmail['max'])) {
                $this->addUsingAlias(ConfiguratorEmailTableMap::SEND_EMAIL, $sendEmail['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ConfiguratorEmailTableMap::SEND_EMAIL, $sendEmail, $comparison);
    }

    /**
     * Filter the query on the template_email_name_customer column
     *
     * Example usage:
     * <code>
     * $query->filterByTemplateEmailNameCustomer('fooValue');   // WHERE template_email_name_customer = 'fooValue'
     * $query->filterByTemplateEmailNameCustomer('%fooValue%'); // WHERE template_email_name_customer LIKE '%fooValue%'
     * </code>
     *
     * @param     string $templateEmailNameCustomer The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildConfiguratorEmailQuery The current query, for fluid interface
     */
    public function filterByTemplateEmailNameCustomer($templateEmailNameCustomer = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($templateEmailNameCustomer)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $templateEmailNameCustomer)) {
                $templateEmailNameCustomer = str_replace('*', '%', $templateEmailNameCustomer);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ConfiguratorEmailTableMap::TEMPLATE_EMAIL_NAME_CUSTOMER, $templateEmailNameCustomer, $comparison);
    }

    /**
     * Filter the query on the template_email_name_admin column
     *
     * Example usage:
     * <code>
     * $query->filterByTemplateEmailNameAdmin('fooValue');   // WHERE template_email_name_admin = 'fooValue'
     * $query->filterByTemplateEmailNameAdmin('%fooValue%'); // WHERE template_email_name_admin LIKE '%fooValue%'
     * </code>
     *
     * @param     string $templateEmailNameAdmin The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildConfiguratorEmailQuery The current query, for fluid interface
     */
    public function filterByTemplateEmailNameAdmin($templateEmailNameAdmin = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($templateEmailNameAdmin)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $templateEmailNameAdmin)) {
                $templateEmailNameAdmin = str_replace('*', '%', $templateEmailNameAdmin);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ConfiguratorEmailTableMap::TEMPLATE_EMAIL_NAME_ADMIN, $templateEmailNameAdmin, $comparison);
    }

    /**
     * Filter the query on the template_redirect_search column
     *
     * Example usage:
     * <code>
     * $query->filterByTemplateRedirectSearch('fooValue');   // WHERE template_redirect_search = 'fooValue'
     * $query->filterByTemplateRedirectSearch('%fooValue%'); // WHERE template_redirect_search LIKE '%fooValue%'
     * </code>
     *
     * @param     string $templateRedirectSearch The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildConfiguratorEmailQuery The current query, for fluid interface
     */
    public function filterByTemplateRedirectSearch($templateRedirectSearch = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($templateRedirectSearch)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $templateRedirectSearch)) {
                $templateRedirectSearch = str_replace('*', '%', $templateRedirectSearch);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ConfiguratorEmailTableMap::TEMPLATE_REDIRECT_SEARCH, $templateRedirectSearch, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildConfiguratorEmail $configuratorEmail Object to remove from the list of results
     *
     * @return ChildConfiguratorEmailQuery The current query, for fluid interface
     */
    public function prune($configuratorEmail = null)
    {
        if ($configuratorEmail) {
            $this->addUsingAlias(ConfiguratorEmailTableMap::ID, $configuratorEmail->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the configurator_email table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ConfiguratorEmailTableMap::DATABASE_NAME);
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
            ConfiguratorEmailTableMap::clearInstancePool();
            ConfiguratorEmailTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildConfiguratorEmail or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildConfiguratorEmail object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(ConfiguratorEmailTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ConfiguratorEmailTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            

        ConfiguratorEmailTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            ConfiguratorEmailTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

} // ConfiguratorEmailQuery
