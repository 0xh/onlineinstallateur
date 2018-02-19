<?php

namespace HookKonfigurator\Model\Base;

use \Exception;
use \PDO;
use HookKonfigurator\Model\HeizungkonfiguratorAngebot as ChildHeizungkonfiguratorAngebot;
use HookKonfigurator\Model\HeizungkonfiguratorAngebotQuery as ChildHeizungkonfiguratorAngebotQuery;
use HookKonfigurator\Model\Map\HeizungkonfiguratorAngebotTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'heizungkonfigurator_angebot' table.
 *
 *
 *
 * @method     ChildHeizungkonfiguratorAngebotQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildHeizungkonfiguratorAngebotQuery orderByUserId($order = Criteria::ASC) Order by the user_id column
 * @method     ChildHeizungkonfiguratorAngebotQuery orderByPlanHeizung($order = Criteria::ASC) Order by the plan_heizung column
 * @method     ChildHeizungkonfiguratorAngebotQuery orderByBrennstoffZukunft($order = Criteria::ASC) Order by the brennstoff_zukunft column
 * @method     ChildHeizungkonfiguratorAngebotQuery orderByGebaeudeart($order = Criteria::ASC) Order by the gebaeudeart column
 * @method     ChildHeizungkonfiguratorAngebotQuery orderByBaujahr($order = Criteria::ASC) Order by the baujahr column
 * @method     ChildHeizungkonfiguratorAngebotQuery orderByBuildingEtagen($order = Criteria::ASC) Order by the building_etagen column
 * @method     ChildHeizungkonfiguratorAngebotQuery orderByFlaeche($order = Criteria::ASC) Order by the flaeche column
 * @method     ChildHeizungkonfiguratorAngebotQuery orderByPersonenAnzahl($order = Criteria::ASC) Order by the personen_anzahl column
 * @method     ChildHeizungkonfiguratorAngebotQuery orderByWohnraumtemperatur($order = Criteria::ASC) Order by the wohnraumtemperatur column
 * @method     ChildHeizungkonfiguratorAngebotQuery orderByAussentemperatur($order = Criteria::ASC) Order by the aussentemperatur column
 * @method     ChildHeizungkonfiguratorAngebotQuery orderByWaermedaemmung($order = Criteria::ASC) Order by the waermedaemmung column
 * @method     ChildHeizungkonfiguratorAngebotQuery orderByVerglasteFenster($order = Criteria::ASC) Order by the verglaste_fenster column
 * @method     ChildHeizungkonfiguratorAngebotQuery orderByDachDaemmung($order = Criteria::ASC) Order by the dach_daemmung column
 * @method     ChildHeizungkonfiguratorAngebotQuery orderByGebaeudelage($order = Criteria::ASC) Order by the gebaeudelage column
 * @method     ChildHeizungkonfiguratorAngebotQuery orderByWindlage($order = Criteria::ASC) Order by the windlage column
 * @method     ChildHeizungkonfiguratorAngebotQuery orderByAnzahlAussenwaende($order = Criteria::ASC) Order by the anzahl_aussenwaende column
 * @method     ChildHeizungkonfiguratorAngebotQuery orderByAbgasfuehrung($order = Criteria::ASC) Order by the abgasfuehrung column
 * @method     ChildHeizungkonfiguratorAngebotQuery orderByHeizungsmethode($order = Criteria::ASC) Order by the heizungsmethode column
 * @method     ChildHeizungkonfiguratorAngebotQuery orderByWarmwasserversorgung($order = Criteria::ASC) Order by the warmwasserversorgung column
 * @method     ChildHeizungkonfiguratorAngebotQuery orderByWasserabfluss($order = Criteria::ASC) Order by the wasserabfluss column
 * @method     ChildHeizungkonfiguratorAngebotQuery orderBySolaranlage($order = Criteria::ASC) Order by the solaranlage column
 * @method     ChildHeizungkonfiguratorAngebotQuery orderBySolaranlageextra($order = Criteria::ASC) Order by the solaranlageextra column
 * @method     ChildHeizungkonfiguratorAngebotQuery orderByPhotovoltaik($order = Criteria::ASC) Order by the photovoltaik column
 * @method     ChildHeizungkonfiguratorAngebotQuery orderByAnmerkungen($order = Criteria::ASC) Order by the anmerkungen column
 * @method     ChildHeizungkonfiguratorAngebotQuery orderByVersion($order = Criteria::ASC) Order by the version column
 * @method     ChildHeizungkonfiguratorAngebotQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 *
 * @method     ChildHeizungkonfiguratorAngebotQuery groupById() Group by the id column
 * @method     ChildHeizungkonfiguratorAngebotQuery groupByUserId() Group by the user_id column
 * @method     ChildHeizungkonfiguratorAngebotQuery groupByPlanHeizung() Group by the plan_heizung column
 * @method     ChildHeizungkonfiguratorAngebotQuery groupByBrennstoffZukunft() Group by the brennstoff_zukunft column
 * @method     ChildHeizungkonfiguratorAngebotQuery groupByGebaeudeart() Group by the gebaeudeart column
 * @method     ChildHeizungkonfiguratorAngebotQuery groupByBaujahr() Group by the baujahr column
 * @method     ChildHeizungkonfiguratorAngebotQuery groupByBuildingEtagen() Group by the building_etagen column
 * @method     ChildHeizungkonfiguratorAngebotQuery groupByFlaeche() Group by the flaeche column
 * @method     ChildHeizungkonfiguratorAngebotQuery groupByPersonenAnzahl() Group by the personen_anzahl column
 * @method     ChildHeizungkonfiguratorAngebotQuery groupByWohnraumtemperatur() Group by the wohnraumtemperatur column
 * @method     ChildHeizungkonfiguratorAngebotQuery groupByAussentemperatur() Group by the aussentemperatur column
 * @method     ChildHeizungkonfiguratorAngebotQuery groupByWaermedaemmung() Group by the waermedaemmung column
 * @method     ChildHeizungkonfiguratorAngebotQuery groupByVerglasteFenster() Group by the verglaste_fenster column
 * @method     ChildHeizungkonfiguratorAngebotQuery groupByDachDaemmung() Group by the dach_daemmung column
 * @method     ChildHeizungkonfiguratorAngebotQuery groupByGebaeudelage() Group by the gebaeudelage column
 * @method     ChildHeizungkonfiguratorAngebotQuery groupByWindlage() Group by the windlage column
 * @method     ChildHeizungkonfiguratorAngebotQuery groupByAnzahlAussenwaende() Group by the anzahl_aussenwaende column
 * @method     ChildHeizungkonfiguratorAngebotQuery groupByAbgasfuehrung() Group by the abgasfuehrung column
 * @method     ChildHeizungkonfiguratorAngebotQuery groupByHeizungsmethode() Group by the heizungsmethode column
 * @method     ChildHeizungkonfiguratorAngebotQuery groupByWarmwasserversorgung() Group by the warmwasserversorgung column
 * @method     ChildHeizungkonfiguratorAngebotQuery groupByWasserabfluss() Group by the wasserabfluss column
 * @method     ChildHeizungkonfiguratorAngebotQuery groupBySolaranlage() Group by the solaranlage column
 * @method     ChildHeizungkonfiguratorAngebotQuery groupBySolaranlageextra() Group by the solaranlageextra column
 * @method     ChildHeizungkonfiguratorAngebotQuery groupByPhotovoltaik() Group by the photovoltaik column
 * @method     ChildHeizungkonfiguratorAngebotQuery groupByAnmerkungen() Group by the anmerkungen column
 * @method     ChildHeizungkonfiguratorAngebotQuery groupByVersion() Group by the version column
 * @method     ChildHeizungkonfiguratorAngebotQuery groupByCreatedAt() Group by the created_at column
 *
 * @method     ChildHeizungkonfiguratorAngebotQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildHeizungkonfiguratorAngebotQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildHeizungkonfiguratorAngebotQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildHeizungkonfiguratorAngebot findOne(ConnectionInterface $con = null) Return the first ChildHeizungkonfiguratorAngebot matching the query
 * @method     ChildHeizungkonfiguratorAngebot findOneOrCreate(ConnectionInterface $con = null) Return the first ChildHeizungkonfiguratorAngebot matching the query, or a new ChildHeizungkonfiguratorAngebot object populated from the query conditions when no match is found
 *
 * @method     ChildHeizungkonfiguratorAngebot findOneById(int $id) Return the first ChildHeizungkonfiguratorAngebot filtered by the id column
 * @method     ChildHeizungkonfiguratorAngebot findOneByUserId(int $user_id) Return the first ChildHeizungkonfiguratorAngebot filtered by the user_id column
 * @method     ChildHeizungkonfiguratorAngebot findOneByPlanHeizung(string $plan_heizung) Return the first ChildHeizungkonfiguratorAngebot filtered by the plan_heizung column
 * @method     ChildHeizungkonfiguratorAngebot findOneByBrennstoffZukunft(string $brennstoff_zukunft) Return the first ChildHeizungkonfiguratorAngebot filtered by the brennstoff_zukunft column
 * @method     ChildHeizungkonfiguratorAngebot findOneByGebaeudeart(string $gebaeudeart) Return the first ChildHeizungkonfiguratorAngebot filtered by the gebaeudeart column
 * @method     ChildHeizungkonfiguratorAngebot findOneByBaujahr(int $baujahr) Return the first ChildHeizungkonfiguratorAngebot filtered by the baujahr column
 * @method     ChildHeizungkonfiguratorAngebot findOneByBuildingEtagen(int $building_etagen) Return the first ChildHeizungkonfiguratorAngebot filtered by the building_etagen column
 * @method     ChildHeizungkonfiguratorAngebot findOneByFlaeche(int $flaeche) Return the first ChildHeizungkonfiguratorAngebot filtered by the flaeche column
 * @method     ChildHeizungkonfiguratorAngebot findOneByPersonenAnzahl(int $personen_anzahl) Return the first ChildHeizungkonfiguratorAngebot filtered by the personen_anzahl column
 * @method     ChildHeizungkonfiguratorAngebot findOneByWohnraumtemperatur(int $wohnraumtemperatur) Return the first ChildHeizungkonfiguratorAngebot filtered by the wohnraumtemperatur column
 * @method     ChildHeizungkonfiguratorAngebot findOneByAussentemperatur(int $aussentemperatur) Return the first ChildHeizungkonfiguratorAngebot filtered by the aussentemperatur column
 * @method     ChildHeizungkonfiguratorAngebot findOneByWaermedaemmung(string $waermedaemmung) Return the first ChildHeizungkonfiguratorAngebot filtered by the waermedaemmung column
 * @method     ChildHeizungkonfiguratorAngebot findOneByVerglasteFenster(string $verglaste_fenster) Return the first ChildHeizungkonfiguratorAngebot filtered by the verglaste_fenster column
 * @method     ChildHeizungkonfiguratorAngebot findOneByDachDaemmung(string $dach_daemmung) Return the first ChildHeizungkonfiguratorAngebot filtered by the dach_daemmung column
 * @method     ChildHeizungkonfiguratorAngebot findOneByGebaeudelage(string $gebaeudelage) Return the first ChildHeizungkonfiguratorAngebot filtered by the gebaeudelage column
 * @method     ChildHeizungkonfiguratorAngebot findOneByWindlage(string $windlage) Return the first ChildHeizungkonfiguratorAngebot filtered by the windlage column
 * @method     ChildHeizungkonfiguratorAngebot findOneByAnzahlAussenwaende(int $anzahl_aussenwaende) Return the first ChildHeizungkonfiguratorAngebot filtered by the anzahl_aussenwaende column
 * @method     ChildHeizungkonfiguratorAngebot findOneByAbgasfuehrung(string $abgasfuehrung) Return the first ChildHeizungkonfiguratorAngebot filtered by the abgasfuehrung column
 * @method     ChildHeizungkonfiguratorAngebot findOneByHeizungsmethode(string $heizungsmethode) Return the first ChildHeizungkonfiguratorAngebot filtered by the heizungsmethode column
 * @method     ChildHeizungkonfiguratorAngebot findOneByWarmwasserversorgung(string $warmwasserversorgung) Return the first ChildHeizungkonfiguratorAngebot filtered by the warmwasserversorgung column
 * @method     ChildHeizungkonfiguratorAngebot findOneByWasserabfluss(string $wasserabfluss) Return the first ChildHeizungkonfiguratorAngebot filtered by the wasserabfluss column
 * @method     ChildHeizungkonfiguratorAngebot findOneBySolaranlage(string $solaranlage) Return the first ChildHeizungkonfiguratorAngebot filtered by the solaranlage column
 * @method     ChildHeizungkonfiguratorAngebot findOneBySolaranlageextra(string $solaranlageextra) Return the first ChildHeizungkonfiguratorAngebot filtered by the solaranlageextra column
 * @method     ChildHeizungkonfiguratorAngebot findOneByPhotovoltaik(string $photovoltaik) Return the first ChildHeizungkonfiguratorAngebot filtered by the photovoltaik column
 * @method     ChildHeizungkonfiguratorAngebot findOneByAnmerkungen(string $anmerkungen) Return the first ChildHeizungkonfiguratorAngebot filtered by the anmerkungen column
 * @method     ChildHeizungkonfiguratorAngebot findOneByVersion(string $version) Return the first ChildHeizungkonfiguratorAngebot filtered by the version column
 * @method     ChildHeizungkonfiguratorAngebot findOneByCreatedAt(string $created_at) Return the first ChildHeizungkonfiguratorAngebot filtered by the created_at column
 *
 * @method     array findById(int $id) Return ChildHeizungkonfiguratorAngebot objects filtered by the id column
 * @method     array findByUserId(int $user_id) Return ChildHeizungkonfiguratorAngebot objects filtered by the user_id column
 * @method     array findByPlanHeizung(string $plan_heizung) Return ChildHeizungkonfiguratorAngebot objects filtered by the plan_heizung column
 * @method     array findByBrennstoffZukunft(string $brennstoff_zukunft) Return ChildHeizungkonfiguratorAngebot objects filtered by the brennstoff_zukunft column
 * @method     array findByGebaeudeart(string $gebaeudeart) Return ChildHeizungkonfiguratorAngebot objects filtered by the gebaeudeart column
 * @method     array findByBaujahr(int $baujahr) Return ChildHeizungkonfiguratorAngebot objects filtered by the baujahr column
 * @method     array findByBuildingEtagen(int $building_etagen) Return ChildHeizungkonfiguratorAngebot objects filtered by the building_etagen column
 * @method     array findByFlaeche(int $flaeche) Return ChildHeizungkonfiguratorAngebot objects filtered by the flaeche column
 * @method     array findByPersonenAnzahl(int $personen_anzahl) Return ChildHeizungkonfiguratorAngebot objects filtered by the personen_anzahl column
 * @method     array findByWohnraumtemperatur(int $wohnraumtemperatur) Return ChildHeizungkonfiguratorAngebot objects filtered by the wohnraumtemperatur column
 * @method     array findByAussentemperatur(int $aussentemperatur) Return ChildHeizungkonfiguratorAngebot objects filtered by the aussentemperatur column
 * @method     array findByWaermedaemmung(string $waermedaemmung) Return ChildHeizungkonfiguratorAngebot objects filtered by the waermedaemmung column
 * @method     array findByVerglasteFenster(string $verglaste_fenster) Return ChildHeizungkonfiguratorAngebot objects filtered by the verglaste_fenster column
 * @method     array findByDachDaemmung(string $dach_daemmung) Return ChildHeizungkonfiguratorAngebot objects filtered by the dach_daemmung column
 * @method     array findByGebaeudelage(string $gebaeudelage) Return ChildHeizungkonfiguratorAngebot objects filtered by the gebaeudelage column
 * @method     array findByWindlage(string $windlage) Return ChildHeizungkonfiguratorAngebot objects filtered by the windlage column
 * @method     array findByAnzahlAussenwaende(int $anzahl_aussenwaende) Return ChildHeizungkonfiguratorAngebot objects filtered by the anzahl_aussenwaende column
 * @method     array findByAbgasfuehrung(string $abgasfuehrung) Return ChildHeizungkonfiguratorAngebot objects filtered by the abgasfuehrung column
 * @method     array findByHeizungsmethode(string $heizungsmethode) Return ChildHeizungkonfiguratorAngebot objects filtered by the heizungsmethode column
 * @method     array findByWarmwasserversorgung(string $warmwasserversorgung) Return ChildHeizungkonfiguratorAngebot objects filtered by the warmwasserversorgung column
 * @method     array findByWasserabfluss(string $wasserabfluss) Return ChildHeizungkonfiguratorAngebot objects filtered by the wasserabfluss column
 * @method     array findBySolaranlage(string $solaranlage) Return ChildHeizungkonfiguratorAngebot objects filtered by the solaranlage column
 * @method     array findBySolaranlageextra(string $solaranlageextra) Return ChildHeizungkonfiguratorAngebot objects filtered by the solaranlageextra column
 * @method     array findByPhotovoltaik(string $photovoltaik) Return ChildHeizungkonfiguratorAngebot objects filtered by the photovoltaik column
 * @method     array findByAnmerkungen(string $anmerkungen) Return ChildHeizungkonfiguratorAngebot objects filtered by the anmerkungen column
 * @method     array findByVersion(string $version) Return ChildHeizungkonfiguratorAngebot objects filtered by the version column
 * @method     array findByCreatedAt(string $created_at) Return ChildHeizungkonfiguratorAngebot objects filtered by the created_at column
 *
 */
abstract class HeizungkonfiguratorAngebotQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \HookKonfigurator\Model\Base\HeizungkonfiguratorAngebotQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'thelia', $modelName = '\\HookKonfigurator\\Model\\HeizungkonfiguratorAngebot', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildHeizungkonfiguratorAngebotQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildHeizungkonfiguratorAngebotQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \HookKonfigurator\Model\HeizungkonfiguratorAngebotQuery) {
            return $criteria;
        }
        $query = new \HookKonfigurator\Model\HeizungkonfiguratorAngebotQuery();
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
     * @return ChildHeizungkonfiguratorAngebot|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = HeizungkonfiguratorAngebotTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(HeizungkonfiguratorAngebotTableMap::DATABASE_NAME);
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
     * @return   ChildHeizungkonfiguratorAngebot A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ID, USER_ID, PLAN_HEIZUNG, BRENNSTOFF_ZUKUNFT, GEBAEUDEART, BAUJAHR, BUILDING_ETAGEN, FLAECHE, PERSONEN_ANZAHL, WOHNRAUMTEMPERATUR, AUSSENTEMPERATUR, WAERMEDAEMMUNG, VERGLASTE_FENSTER, DACH_DAEMMUNG, GEBAEUDELAGE, WINDLAGE, ANZAHL_AUSSENWAENDE, ABGASFUEHRUNG, HEIZUNGSMETHODE, WARMWASSERVERSORGUNG, WASSERABFLUSS, SOLARANLAGE, SOLARANLAGEEXTRA, PHOTOVOLTAIK, ANMERKUNGEN, VERSION, CREATED_AT FROM heizungkonfigurator_angebot WHERE ID = :p0';
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
            $obj = new ChildHeizungkonfiguratorAngebot();
            $obj->hydrate($row);
            HeizungkonfiguratorAngebotTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildHeizungkonfiguratorAngebot|array|mixed the result, formatted by the current formatter
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
     * @return ChildHeizungkonfiguratorAngebotQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(HeizungkonfiguratorAngebotTableMap::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildHeizungkonfiguratorAngebotQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(HeizungkonfiguratorAngebotTableMap::ID, $keys, Criteria::IN);
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
     * @return ChildHeizungkonfiguratorAngebotQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(HeizungkonfiguratorAngebotTableMap::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(HeizungkonfiguratorAngebotTableMap::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(HeizungkonfiguratorAngebotTableMap::ID, $id, $comparison);
    }

    /**
     * Filter the query on the user_id column
     *
     * Example usage:
     * <code>
     * $query->filterByUserId(1234); // WHERE user_id = 1234
     * $query->filterByUserId(array(12, 34)); // WHERE user_id IN (12, 34)
     * $query->filterByUserId(array('min' => 12)); // WHERE user_id > 12
     * </code>
     *
     * @param     mixed $userId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildHeizungkonfiguratorAngebotQuery The current query, for fluid interface
     */
    public function filterByUserId($userId = null, $comparison = null)
    {
        if (is_array($userId)) {
            $useMinMax = false;
            if (isset($userId['min'])) {
                $this->addUsingAlias(HeizungkonfiguratorAngebotTableMap::USER_ID, $userId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($userId['max'])) {
                $this->addUsingAlias(HeizungkonfiguratorAngebotTableMap::USER_ID, $userId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(HeizungkonfiguratorAngebotTableMap::USER_ID, $userId, $comparison);
    }

    /**
     * Filter the query on the plan_heizung column
     *
     * Example usage:
     * <code>
     * $query->filterByPlanHeizung('fooValue');   // WHERE plan_heizung = 'fooValue'
     * $query->filterByPlanHeizung('%fooValue%'); // WHERE plan_heizung LIKE '%fooValue%'
     * </code>
     *
     * @param     string $planHeizung The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildHeizungkonfiguratorAngebotQuery The current query, for fluid interface
     */
    public function filterByPlanHeizung($planHeizung = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($planHeizung)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $planHeizung)) {
                $planHeizung = str_replace('*', '%', $planHeizung);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(HeizungkonfiguratorAngebotTableMap::PLAN_HEIZUNG, $planHeizung, $comparison);
    }

    /**
     * Filter the query on the brennstoff_zukunft column
     *
     * Example usage:
     * <code>
     * $query->filterByBrennstoffZukunft('fooValue');   // WHERE brennstoff_zukunft = 'fooValue'
     * $query->filterByBrennstoffZukunft('%fooValue%'); // WHERE brennstoff_zukunft LIKE '%fooValue%'
     * </code>
     *
     * @param     string $brennstoffZukunft The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildHeizungkonfiguratorAngebotQuery The current query, for fluid interface
     */
    public function filterByBrennstoffZukunft($brennstoffZukunft = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($brennstoffZukunft)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $brennstoffZukunft)) {
                $brennstoffZukunft = str_replace('*', '%', $brennstoffZukunft);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(HeizungkonfiguratorAngebotTableMap::BRENNSTOFF_ZUKUNFT, $brennstoffZukunft, $comparison);
    }

    /**
     * Filter the query on the gebaeudeart column
     *
     * Example usage:
     * <code>
     * $query->filterByGebaeudeart('fooValue');   // WHERE gebaeudeart = 'fooValue'
     * $query->filterByGebaeudeart('%fooValue%'); // WHERE gebaeudeart LIKE '%fooValue%'
     * </code>
     *
     * @param     string $gebaeudeart The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildHeizungkonfiguratorAngebotQuery The current query, for fluid interface
     */
    public function filterByGebaeudeart($gebaeudeart = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($gebaeudeart)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $gebaeudeart)) {
                $gebaeudeart = str_replace('*', '%', $gebaeudeart);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(HeizungkonfiguratorAngebotTableMap::GEBAEUDEART, $gebaeudeart, $comparison);
    }

    /**
     * Filter the query on the baujahr column
     *
     * Example usage:
     * <code>
     * $query->filterByBaujahr(1234); // WHERE baujahr = 1234
     * $query->filterByBaujahr(array(12, 34)); // WHERE baujahr IN (12, 34)
     * $query->filterByBaujahr(array('min' => 12)); // WHERE baujahr > 12
     * </code>
     *
     * @param     mixed $baujahr The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildHeizungkonfiguratorAngebotQuery The current query, for fluid interface
     */
    public function filterByBaujahr($baujahr = null, $comparison = null)
    {
        if (is_array($baujahr)) {
            $useMinMax = false;
            if (isset($baujahr['min'])) {
                $this->addUsingAlias(HeizungkonfiguratorAngebotTableMap::BAUJAHR, $baujahr['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($baujahr['max'])) {
                $this->addUsingAlias(HeizungkonfiguratorAngebotTableMap::BAUJAHR, $baujahr['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(HeizungkonfiguratorAngebotTableMap::BAUJAHR, $baujahr, $comparison);
    }

    /**
     * Filter the query on the building_etagen column
     *
     * Example usage:
     * <code>
     * $query->filterByBuildingEtagen(1234); // WHERE building_etagen = 1234
     * $query->filterByBuildingEtagen(array(12, 34)); // WHERE building_etagen IN (12, 34)
     * $query->filterByBuildingEtagen(array('min' => 12)); // WHERE building_etagen > 12
     * </code>
     *
     * @param     mixed $buildingEtagen The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildHeizungkonfiguratorAngebotQuery The current query, for fluid interface
     */
    public function filterByBuildingEtagen($buildingEtagen = null, $comparison = null)
    {
        if (is_array($buildingEtagen)) {
            $useMinMax = false;
            if (isset($buildingEtagen['min'])) {
                $this->addUsingAlias(HeizungkonfiguratorAngebotTableMap::BUILDING_ETAGEN, $buildingEtagen['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($buildingEtagen['max'])) {
                $this->addUsingAlias(HeizungkonfiguratorAngebotTableMap::BUILDING_ETAGEN, $buildingEtagen['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(HeizungkonfiguratorAngebotTableMap::BUILDING_ETAGEN, $buildingEtagen, $comparison);
    }

    /**
     * Filter the query on the flaeche column
     *
     * Example usage:
     * <code>
     * $query->filterByFlaeche(1234); // WHERE flaeche = 1234
     * $query->filterByFlaeche(array(12, 34)); // WHERE flaeche IN (12, 34)
     * $query->filterByFlaeche(array('min' => 12)); // WHERE flaeche > 12
     * </code>
     *
     * @param     mixed $flaeche The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildHeizungkonfiguratorAngebotQuery The current query, for fluid interface
     */
    public function filterByFlaeche($flaeche = null, $comparison = null)
    {
        if (is_array($flaeche)) {
            $useMinMax = false;
            if (isset($flaeche['min'])) {
                $this->addUsingAlias(HeizungkonfiguratorAngebotTableMap::FLAECHE, $flaeche['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($flaeche['max'])) {
                $this->addUsingAlias(HeizungkonfiguratorAngebotTableMap::FLAECHE, $flaeche['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(HeizungkonfiguratorAngebotTableMap::FLAECHE, $flaeche, $comparison);
    }

    /**
     * Filter the query on the personen_anzahl column
     *
     * Example usage:
     * <code>
     * $query->filterByPersonenAnzahl(1234); // WHERE personen_anzahl = 1234
     * $query->filterByPersonenAnzahl(array(12, 34)); // WHERE personen_anzahl IN (12, 34)
     * $query->filterByPersonenAnzahl(array('min' => 12)); // WHERE personen_anzahl > 12
     * </code>
     *
     * @param     mixed $personenAnzahl The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildHeizungkonfiguratorAngebotQuery The current query, for fluid interface
     */
    public function filterByPersonenAnzahl($personenAnzahl = null, $comparison = null)
    {
        if (is_array($personenAnzahl)) {
            $useMinMax = false;
            if (isset($personenAnzahl['min'])) {
                $this->addUsingAlias(HeizungkonfiguratorAngebotTableMap::PERSONEN_ANZAHL, $personenAnzahl['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($personenAnzahl['max'])) {
                $this->addUsingAlias(HeizungkonfiguratorAngebotTableMap::PERSONEN_ANZAHL, $personenAnzahl['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(HeizungkonfiguratorAngebotTableMap::PERSONEN_ANZAHL, $personenAnzahl, $comparison);
    }

    /**
     * Filter the query on the wohnraumtemperatur column
     *
     * Example usage:
     * <code>
     * $query->filterByWohnraumtemperatur(1234); // WHERE wohnraumtemperatur = 1234
     * $query->filterByWohnraumtemperatur(array(12, 34)); // WHERE wohnraumtemperatur IN (12, 34)
     * $query->filterByWohnraumtemperatur(array('min' => 12)); // WHERE wohnraumtemperatur > 12
     * </code>
     *
     * @param     mixed $wohnraumtemperatur The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildHeizungkonfiguratorAngebotQuery The current query, for fluid interface
     */
    public function filterByWohnraumtemperatur($wohnraumtemperatur = null, $comparison = null)
    {
        if (is_array($wohnraumtemperatur)) {
            $useMinMax = false;
            if (isset($wohnraumtemperatur['min'])) {
                $this->addUsingAlias(HeizungkonfiguratorAngebotTableMap::WOHNRAUMTEMPERATUR, $wohnraumtemperatur['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($wohnraumtemperatur['max'])) {
                $this->addUsingAlias(HeizungkonfiguratorAngebotTableMap::WOHNRAUMTEMPERATUR, $wohnraumtemperatur['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(HeizungkonfiguratorAngebotTableMap::WOHNRAUMTEMPERATUR, $wohnraumtemperatur, $comparison);
    }

    /**
     * Filter the query on the aussentemperatur column
     *
     * Example usage:
     * <code>
     * $query->filterByAussentemperatur(1234); // WHERE aussentemperatur = 1234
     * $query->filterByAussentemperatur(array(12, 34)); // WHERE aussentemperatur IN (12, 34)
     * $query->filterByAussentemperatur(array('min' => 12)); // WHERE aussentemperatur > 12
     * </code>
     *
     * @param     mixed $aussentemperatur The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildHeizungkonfiguratorAngebotQuery The current query, for fluid interface
     */
    public function filterByAussentemperatur($aussentemperatur = null, $comparison = null)
    {
        if (is_array($aussentemperatur)) {
            $useMinMax = false;
            if (isset($aussentemperatur['min'])) {
                $this->addUsingAlias(HeizungkonfiguratorAngebotTableMap::AUSSENTEMPERATUR, $aussentemperatur['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($aussentemperatur['max'])) {
                $this->addUsingAlias(HeizungkonfiguratorAngebotTableMap::AUSSENTEMPERATUR, $aussentemperatur['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(HeizungkonfiguratorAngebotTableMap::AUSSENTEMPERATUR, $aussentemperatur, $comparison);
    }

    /**
     * Filter the query on the waermedaemmung column
     *
     * Example usage:
     * <code>
     * $query->filterByWaermedaemmung('fooValue');   // WHERE waermedaemmung = 'fooValue'
     * $query->filterByWaermedaemmung('%fooValue%'); // WHERE waermedaemmung LIKE '%fooValue%'
     * </code>
     *
     * @param     string $waermedaemmung The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildHeizungkonfiguratorAngebotQuery The current query, for fluid interface
     */
    public function filterByWaermedaemmung($waermedaemmung = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($waermedaemmung)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $waermedaemmung)) {
                $waermedaemmung = str_replace('*', '%', $waermedaemmung);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(HeizungkonfiguratorAngebotTableMap::WAERMEDAEMMUNG, $waermedaemmung, $comparison);
    }

    /**
     * Filter the query on the verglaste_fenster column
     *
     * Example usage:
     * <code>
     * $query->filterByVerglasteFenster('fooValue');   // WHERE verglaste_fenster = 'fooValue'
     * $query->filterByVerglasteFenster('%fooValue%'); // WHERE verglaste_fenster LIKE '%fooValue%'
     * </code>
     *
     * @param     string $verglasteFenster The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildHeizungkonfiguratorAngebotQuery The current query, for fluid interface
     */
    public function filterByVerglasteFenster($verglasteFenster = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($verglasteFenster)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $verglasteFenster)) {
                $verglasteFenster = str_replace('*', '%', $verglasteFenster);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(HeizungkonfiguratorAngebotTableMap::VERGLASTE_FENSTER, $verglasteFenster, $comparison);
    }

    /**
     * Filter the query on the dach_daemmung column
     *
     * Example usage:
     * <code>
     * $query->filterByDachDaemmung('fooValue');   // WHERE dach_daemmung = 'fooValue'
     * $query->filterByDachDaemmung('%fooValue%'); // WHERE dach_daemmung LIKE '%fooValue%'
     * </code>
     *
     * @param     string $dachDaemmung The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildHeizungkonfiguratorAngebotQuery The current query, for fluid interface
     */
    public function filterByDachDaemmung($dachDaemmung = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($dachDaemmung)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $dachDaemmung)) {
                $dachDaemmung = str_replace('*', '%', $dachDaemmung);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(HeizungkonfiguratorAngebotTableMap::DACH_DAEMMUNG, $dachDaemmung, $comparison);
    }

    /**
     * Filter the query on the gebaeudelage column
     *
     * Example usage:
     * <code>
     * $query->filterByGebaeudelage('fooValue');   // WHERE gebaeudelage = 'fooValue'
     * $query->filterByGebaeudelage('%fooValue%'); // WHERE gebaeudelage LIKE '%fooValue%'
     * </code>
     *
     * @param     string $gebaeudelage The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildHeizungkonfiguratorAngebotQuery The current query, for fluid interface
     */
    public function filterByGebaeudelage($gebaeudelage = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($gebaeudelage)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $gebaeudelage)) {
                $gebaeudelage = str_replace('*', '%', $gebaeudelage);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(HeizungkonfiguratorAngebotTableMap::GEBAEUDELAGE, $gebaeudelage, $comparison);
    }

    /**
     * Filter the query on the windlage column
     *
     * Example usage:
     * <code>
     * $query->filterByWindlage('fooValue');   // WHERE windlage = 'fooValue'
     * $query->filterByWindlage('%fooValue%'); // WHERE windlage LIKE '%fooValue%'
     * </code>
     *
     * @param     string $windlage The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildHeizungkonfiguratorAngebotQuery The current query, for fluid interface
     */
    public function filterByWindlage($windlage = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($windlage)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $windlage)) {
                $windlage = str_replace('*', '%', $windlage);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(HeizungkonfiguratorAngebotTableMap::WINDLAGE, $windlage, $comparison);
    }

    /**
     * Filter the query on the anzahl_aussenwaende column
     *
     * Example usage:
     * <code>
     * $query->filterByAnzahlAussenwaende(1234); // WHERE anzahl_aussenwaende = 1234
     * $query->filterByAnzahlAussenwaende(array(12, 34)); // WHERE anzahl_aussenwaende IN (12, 34)
     * $query->filterByAnzahlAussenwaende(array('min' => 12)); // WHERE anzahl_aussenwaende > 12
     * </code>
     *
     * @param     mixed $anzahlAussenwaende The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildHeizungkonfiguratorAngebotQuery The current query, for fluid interface
     */
    public function filterByAnzahlAussenwaende($anzahlAussenwaende = null, $comparison = null)
    {
        if (is_array($anzahlAussenwaende)) {
            $useMinMax = false;
            if (isset($anzahlAussenwaende['min'])) {
                $this->addUsingAlias(HeizungkonfiguratorAngebotTableMap::ANZAHL_AUSSENWAENDE, $anzahlAussenwaende['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($anzahlAussenwaende['max'])) {
                $this->addUsingAlias(HeizungkonfiguratorAngebotTableMap::ANZAHL_AUSSENWAENDE, $anzahlAussenwaende['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(HeizungkonfiguratorAngebotTableMap::ANZAHL_AUSSENWAENDE, $anzahlAussenwaende, $comparison);
    }

    /**
     * Filter the query on the abgasfuehrung column
     *
     * Example usage:
     * <code>
     * $query->filterByAbgasfuehrung('fooValue');   // WHERE abgasfuehrung = 'fooValue'
     * $query->filterByAbgasfuehrung('%fooValue%'); // WHERE abgasfuehrung LIKE '%fooValue%'
     * </code>
     *
     * @param     string $abgasfuehrung The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildHeizungkonfiguratorAngebotQuery The current query, for fluid interface
     */
    public function filterByAbgasfuehrung($abgasfuehrung = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($abgasfuehrung)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $abgasfuehrung)) {
                $abgasfuehrung = str_replace('*', '%', $abgasfuehrung);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(HeizungkonfiguratorAngebotTableMap::ABGASFUEHRUNG, $abgasfuehrung, $comparison);
    }

    /**
     * Filter the query on the heizungsmethode column
     *
     * Example usage:
     * <code>
     * $query->filterByHeizungsmethode('fooValue');   // WHERE heizungsmethode = 'fooValue'
     * $query->filterByHeizungsmethode('%fooValue%'); // WHERE heizungsmethode LIKE '%fooValue%'
     * </code>
     *
     * @param     string $heizungsmethode The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildHeizungkonfiguratorAngebotQuery The current query, for fluid interface
     */
    public function filterByHeizungsmethode($heizungsmethode = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($heizungsmethode)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $heizungsmethode)) {
                $heizungsmethode = str_replace('*', '%', $heizungsmethode);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(HeizungkonfiguratorAngebotTableMap::HEIZUNGSMETHODE, $heizungsmethode, $comparison);
    }

    /**
     * Filter the query on the warmwasserversorgung column
     *
     * Example usage:
     * <code>
     * $query->filterByWarmwasserversorgung('fooValue');   // WHERE warmwasserversorgung = 'fooValue'
     * $query->filterByWarmwasserversorgung('%fooValue%'); // WHERE warmwasserversorgung LIKE '%fooValue%'
     * </code>
     *
     * @param     string $warmwasserversorgung The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildHeizungkonfiguratorAngebotQuery The current query, for fluid interface
     */
    public function filterByWarmwasserversorgung($warmwasserversorgung = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($warmwasserversorgung)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $warmwasserversorgung)) {
                $warmwasserversorgung = str_replace('*', '%', $warmwasserversorgung);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(HeizungkonfiguratorAngebotTableMap::WARMWASSERVERSORGUNG, $warmwasserversorgung, $comparison);
    }

    /**
     * Filter the query on the wasserabfluss column
     *
     * Example usage:
     * <code>
     * $query->filterByWasserabfluss('fooValue');   // WHERE wasserabfluss = 'fooValue'
     * $query->filterByWasserabfluss('%fooValue%'); // WHERE wasserabfluss LIKE '%fooValue%'
     * </code>
     *
     * @param     string $wasserabfluss The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildHeizungkonfiguratorAngebotQuery The current query, for fluid interface
     */
    public function filterByWasserabfluss($wasserabfluss = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($wasserabfluss)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $wasserabfluss)) {
                $wasserabfluss = str_replace('*', '%', $wasserabfluss);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(HeizungkonfiguratorAngebotTableMap::WASSERABFLUSS, $wasserabfluss, $comparison);
    }

    /**
     * Filter the query on the solaranlage column
     *
     * Example usage:
     * <code>
     * $query->filterBySolaranlage('fooValue');   // WHERE solaranlage = 'fooValue'
     * $query->filterBySolaranlage('%fooValue%'); // WHERE solaranlage LIKE '%fooValue%'
     * </code>
     *
     * @param     string $solaranlage The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildHeizungkonfiguratorAngebotQuery The current query, for fluid interface
     */
    public function filterBySolaranlage($solaranlage = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($solaranlage)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $solaranlage)) {
                $solaranlage = str_replace('*', '%', $solaranlage);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(HeizungkonfiguratorAngebotTableMap::SOLARANLAGE, $solaranlage, $comparison);
    }

    /**
     * Filter the query on the solaranlageextra column
     *
     * Example usage:
     * <code>
     * $query->filterBySolaranlageextra('fooValue');   // WHERE solaranlageextra = 'fooValue'
     * $query->filterBySolaranlageextra('%fooValue%'); // WHERE solaranlageextra LIKE '%fooValue%'
     * </code>
     *
     * @param     string $solaranlageextra The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildHeizungkonfiguratorAngebotQuery The current query, for fluid interface
     */
    public function filterBySolaranlageextra($solaranlageextra = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($solaranlageextra)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $solaranlageextra)) {
                $solaranlageextra = str_replace('*', '%', $solaranlageextra);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(HeizungkonfiguratorAngebotTableMap::SOLARANLAGEEXTRA, $solaranlageextra, $comparison);
    }

    /**
     * Filter the query on the photovoltaik column
     *
     * Example usage:
     * <code>
     * $query->filterByPhotovoltaik('fooValue');   // WHERE photovoltaik = 'fooValue'
     * $query->filterByPhotovoltaik('%fooValue%'); // WHERE photovoltaik LIKE '%fooValue%'
     * </code>
     *
     * @param     string $photovoltaik The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildHeizungkonfiguratorAngebotQuery The current query, for fluid interface
     */
    public function filterByPhotovoltaik($photovoltaik = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($photovoltaik)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $photovoltaik)) {
                $photovoltaik = str_replace('*', '%', $photovoltaik);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(HeizungkonfiguratorAngebotTableMap::PHOTOVOLTAIK, $photovoltaik, $comparison);
    }

    /**
     * Filter the query on the anmerkungen column
     *
     * Example usage:
     * <code>
     * $query->filterByAnmerkungen('fooValue');   // WHERE anmerkungen = 'fooValue'
     * $query->filterByAnmerkungen('%fooValue%'); // WHERE anmerkungen LIKE '%fooValue%'
     * </code>
     *
     * @param     string $anmerkungen The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildHeizungkonfiguratorAngebotQuery The current query, for fluid interface
     */
    public function filterByAnmerkungen($anmerkungen = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($anmerkungen)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $anmerkungen)) {
                $anmerkungen = str_replace('*', '%', $anmerkungen);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(HeizungkonfiguratorAngebotTableMap::ANMERKUNGEN, $anmerkungen, $comparison);
    }

    /**
     * Filter the query on the version column
     *
     * Example usage:
     * <code>
     * $query->filterByVersion('fooValue');   // WHERE version = 'fooValue'
     * $query->filterByVersion('%fooValue%'); // WHERE version LIKE '%fooValue%'
     * </code>
     *
     * @param     string $version The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildHeizungkonfiguratorAngebotQuery The current query, for fluid interface
     */
    public function filterByVersion($version = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($version)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $version)) {
                $version = str_replace('*', '%', $version);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(HeizungkonfiguratorAngebotTableMap::VERSION, $version, $comparison);
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
     * @return ChildHeizungkonfiguratorAngebotQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(HeizungkonfiguratorAngebotTableMap::CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(HeizungkonfiguratorAngebotTableMap::CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(HeizungkonfiguratorAngebotTableMap::CREATED_AT, $createdAt, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildHeizungkonfiguratorAngebot $heizungkonfiguratorAngebot Object to remove from the list of results
     *
     * @return ChildHeizungkonfiguratorAngebotQuery The current query, for fluid interface
     */
    public function prune($heizungkonfiguratorAngebot = null)
    {
        if ($heizungkonfiguratorAngebot) {
            $this->addUsingAlias(HeizungkonfiguratorAngebotTableMap::ID, $heizungkonfiguratorAngebot->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the heizungkonfigurator_angebot table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(HeizungkonfiguratorAngebotTableMap::DATABASE_NAME);
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
            HeizungkonfiguratorAngebotTableMap::clearInstancePool();
            HeizungkonfiguratorAngebotTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildHeizungkonfiguratorAngebot or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildHeizungkonfiguratorAngebot object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(HeizungkonfiguratorAngebotTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(HeizungkonfiguratorAngebotTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();


        HeizungkonfiguratorAngebotTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            HeizungkonfiguratorAngebotTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

} // HeizungkonfiguratorAngebotQuery
