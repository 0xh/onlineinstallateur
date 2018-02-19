<?php

namespace HookKonfigurator\Model\Base;

use \Exception;
use \PDO;
use HookKonfigurator\Model\HeizungkonfiguratorUserdaten as ChildHeizungkonfiguratorUserdaten;
use HookKonfigurator\Model\HeizungkonfiguratorUserdatenQuery as ChildHeizungkonfiguratorUserdatenQuery;
use HookKonfigurator\Model\Map\HeizungkonfiguratorUserdatenTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'heizungkonfigurator_userdaten' table.
 *
 *
 *
 * @method     ChildHeizungkonfiguratorUserdatenQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildHeizungkonfiguratorUserdatenQuery orderByUserId($order = Criteria::ASC) Order by the user_id column
 * @method     ChildHeizungkonfiguratorUserdatenQuery orderByBrennstoffMomentan($order = Criteria::ASC) Order by the brennstoff_momentan column
 * @method     ChildHeizungkonfiguratorUserdatenQuery orderByBrennstoffZukunft($order = Criteria::ASC) Order by the brennstoff_zukunft column
 * @method     ChildHeizungkonfiguratorUserdatenQuery orderByGebaeudeart($order = Criteria::ASC) Order by the gebaeudeart column
 * @method     ChildHeizungkonfiguratorUserdatenQuery orderByPersonenAnzahl($order = Criteria::ASC) Order by the personen_anzahl column
 * @method     ChildHeizungkonfiguratorUserdatenQuery orderByBestehendeGeraetWarmwasser($order = Criteria::ASC) Order by the bestehende_geraet_warmwasser column
 * @method     ChildHeizungkonfiguratorUserdatenQuery orderByBestehendeGeraetKw($order = Criteria::ASC) Order by the bestehende_geraet_kw column
 * @method     ChildHeizungkonfiguratorUserdatenQuery orderByBaujahr($order = Criteria::ASC) Order by the baujahr column
 * @method     ChildHeizungkonfiguratorUserdatenQuery orderByHeizflaeche($order = Criteria::ASC) Order by the heizflaeche column
 * @method     ChildHeizungkonfiguratorUserdatenQuery orderByWaermedaemmung($order = Criteria::ASC) Order by the waermedaemmung column
 * @method     ChildHeizungkonfiguratorUserdatenQuery orderByVerglasteFenster($order = Criteria::ASC) Order by the verglaste_fenster column
 * @method     ChildHeizungkonfiguratorUserdatenQuery orderByGebaeudelage($order = Criteria::ASC) Order by the gebaeudelage column
 * @method     ChildHeizungkonfiguratorUserdatenQuery orderByWindlage($order = Criteria::ASC) Order by the windlage column
 * @method     ChildHeizungkonfiguratorUserdatenQuery orderByAnzahlAussenwaende($order = Criteria::ASC) Order by the anzahl_aussenwaende column
 * @method     ChildHeizungkonfiguratorUserdatenQuery orderByWohnraumtemperatur($order = Criteria::ASC) Order by the wohnraumtemperatur column
 * @method     ChildHeizungkonfiguratorUserdatenQuery orderByAussentemperatur($order = Criteria::ASC) Order by the aussentemperatur column
 * @method     ChildHeizungkonfiguratorUserdatenQuery orderByAnmerkungen($order = Criteria::ASC) Order by the anmerkungen column
 * @method     ChildHeizungkonfiguratorUserdatenQuery orderByFotoId($order = Criteria::ASC) Order by the foto_id column
 * @method     ChildHeizungkonfiguratorUserdatenQuery orderByVersion($order = Criteria::ASC) Order by the version column
 * @method     ChildHeizungkonfiguratorUserdatenQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildHeizungkonfiguratorUserdatenQuery orderByEtagen($order = Criteria::ASC) Order by the etagen column
 * @method     ChildHeizungkonfiguratorUserdatenQuery orderByDachDaemmung($order = Criteria::ASC) Order by the dach_daemmung column
 * @method     ChildHeizungkonfiguratorUserdatenQuery orderByAbgasfuehrung($order = Criteria::ASC) Order by the abgasfuehrung column
 * @method     ChildHeizungkonfiguratorUserdatenQuery orderByWaermeabgabe($order = Criteria::ASC) Order by the waermeabgabe column
 * @method     ChildHeizungkonfiguratorUserdatenQuery orderByDuschwasser($order = Criteria::ASC) Order by the duschwasser column
 * @method     ChildHeizungkonfiguratorUserdatenQuery orderByWasserabfluss($order = Criteria::ASC) Order by the wasserabfluss column
 * @method     ChildHeizungkonfiguratorUserdatenQuery orderByWarmwasserversorgung($order = Criteria::ASC) Order by the warmwasserversorgung column
 * @method     ChildHeizungkonfiguratorUserdatenQuery orderByWarmwasserversorgungExtra($order = Criteria::ASC) Order by the warmwasserversorgung_extra column
 * @method     ChildHeizungkonfiguratorUserdatenQuery orderByWarmwasserversorgungExtraWaermepumpe($order = Criteria::ASC) Order by the warmwasserversorgung_extra_waermepumpe column
 *
 * @method     ChildHeizungkonfiguratorUserdatenQuery groupById() Group by the id column
 * @method     ChildHeizungkonfiguratorUserdatenQuery groupByUserId() Group by the user_id column
 * @method     ChildHeizungkonfiguratorUserdatenQuery groupByBrennstoffMomentan() Group by the brennstoff_momentan column
 * @method     ChildHeizungkonfiguratorUserdatenQuery groupByBrennstoffZukunft() Group by the brennstoff_zukunft column
 * @method     ChildHeizungkonfiguratorUserdatenQuery groupByGebaeudeart() Group by the gebaeudeart column
 * @method     ChildHeizungkonfiguratorUserdatenQuery groupByPersonenAnzahl() Group by the personen_anzahl column
 * @method     ChildHeizungkonfiguratorUserdatenQuery groupByBestehendeGeraetWarmwasser() Group by the bestehende_geraet_warmwasser column
 * @method     ChildHeizungkonfiguratorUserdatenQuery groupByBestehendeGeraetKw() Group by the bestehende_geraet_kw column
 * @method     ChildHeizungkonfiguratorUserdatenQuery groupByBaujahr() Group by the baujahr column
 * @method     ChildHeizungkonfiguratorUserdatenQuery groupByHeizflaeche() Group by the heizflaeche column
 * @method     ChildHeizungkonfiguratorUserdatenQuery groupByWaermedaemmung() Group by the waermedaemmung column
 * @method     ChildHeizungkonfiguratorUserdatenQuery groupByVerglasteFenster() Group by the verglaste_fenster column
 * @method     ChildHeizungkonfiguratorUserdatenQuery groupByGebaeudelage() Group by the gebaeudelage column
 * @method     ChildHeizungkonfiguratorUserdatenQuery groupByWindlage() Group by the windlage column
 * @method     ChildHeizungkonfiguratorUserdatenQuery groupByAnzahlAussenwaende() Group by the anzahl_aussenwaende column
 * @method     ChildHeizungkonfiguratorUserdatenQuery groupByWohnraumtemperatur() Group by the wohnraumtemperatur column
 * @method     ChildHeizungkonfiguratorUserdatenQuery groupByAussentemperatur() Group by the aussentemperatur column
 * @method     ChildHeizungkonfiguratorUserdatenQuery groupByAnmerkungen() Group by the anmerkungen column
 * @method     ChildHeizungkonfiguratorUserdatenQuery groupByFotoId() Group by the foto_id column
 * @method     ChildHeizungkonfiguratorUserdatenQuery groupByVersion() Group by the version column
 * @method     ChildHeizungkonfiguratorUserdatenQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildHeizungkonfiguratorUserdatenQuery groupByEtagen() Group by the etagen column
 * @method     ChildHeizungkonfiguratorUserdatenQuery groupByDachDaemmung() Group by the dach_daemmung column
 * @method     ChildHeizungkonfiguratorUserdatenQuery groupByAbgasfuehrung() Group by the abgasfuehrung column
 * @method     ChildHeizungkonfiguratorUserdatenQuery groupByWaermeabgabe() Group by the waermeabgabe column
 * @method     ChildHeizungkonfiguratorUserdatenQuery groupByDuschwasser() Group by the duschwasser column
 * @method     ChildHeizungkonfiguratorUserdatenQuery groupByWasserabfluss() Group by the wasserabfluss column
 * @method     ChildHeizungkonfiguratorUserdatenQuery groupByWarmwasserversorgung() Group by the warmwasserversorgung column
 * @method     ChildHeizungkonfiguratorUserdatenQuery groupByWarmwasserversorgungExtra() Group by the warmwasserversorgung_extra column
 * @method     ChildHeizungkonfiguratorUserdatenQuery groupByWarmwasserversorgungExtraWaermepumpe() Group by the warmwasserversorgung_extra_waermepumpe column
 *
 * @method     ChildHeizungkonfiguratorUserdatenQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildHeizungkonfiguratorUserdatenQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildHeizungkonfiguratorUserdatenQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildHeizungkonfiguratorUserdatenQuery leftJoinHeizungkonfiguratorImage($relationAlias = null) Adds a LEFT JOIN clause to the query using the HeizungkonfiguratorImage relation
 * @method     ChildHeizungkonfiguratorUserdatenQuery rightJoinHeizungkonfiguratorImage($relationAlias = null) Adds a RIGHT JOIN clause to the query using the HeizungkonfiguratorImage relation
 * @method     ChildHeizungkonfiguratorUserdatenQuery innerJoinHeizungkonfiguratorImage($relationAlias = null) Adds a INNER JOIN clause to the query using the HeizungkonfiguratorImage relation
 *
 * @method     ChildHeizungkonfiguratorUserdaten findOne(ConnectionInterface $con = null) Return the first ChildHeizungkonfiguratorUserdaten matching the query
 * @method     ChildHeizungkonfiguratorUserdaten findOneOrCreate(ConnectionInterface $con = null) Return the first ChildHeizungkonfiguratorUserdaten matching the query, or a new ChildHeizungkonfiguratorUserdaten object populated from the query conditions when no match is found
 *
 * @method     ChildHeizungkonfiguratorUserdaten findOneById(int $id) Return the first ChildHeizungkonfiguratorUserdaten filtered by the id column
 * @method     ChildHeizungkonfiguratorUserdaten findOneByUserId(int $user_id) Return the first ChildHeizungkonfiguratorUserdaten filtered by the user_id column
 * @method     ChildHeizungkonfiguratorUserdaten findOneByBrennstoffMomentan(string $brennstoff_momentan) Return the first ChildHeizungkonfiguratorUserdaten filtered by the brennstoff_momentan column
 * @method     ChildHeizungkonfiguratorUserdaten findOneByBrennstoffZukunft(string $brennstoff_zukunft) Return the first ChildHeizungkonfiguratorUserdaten filtered by the brennstoff_zukunft column
 * @method     ChildHeizungkonfiguratorUserdaten findOneByGebaeudeart(string $gebaeudeart) Return the first ChildHeizungkonfiguratorUserdaten filtered by the gebaeudeart column
 * @method     ChildHeizungkonfiguratorUserdaten findOneByPersonenAnzahl(int $personen_anzahl) Return the first ChildHeizungkonfiguratorUserdaten filtered by the personen_anzahl column
 * @method     ChildHeizungkonfiguratorUserdaten findOneByBestehendeGeraetWarmwasser(string $bestehende_geraet_warmwasser) Return the first ChildHeizungkonfiguratorUserdaten filtered by the bestehende_geraet_warmwasser column
 * @method     ChildHeizungkonfiguratorUserdaten findOneByBestehendeGeraetKw(int $bestehende_geraet_kw) Return the first ChildHeizungkonfiguratorUserdaten filtered by the bestehende_geraet_kw column
 * @method     ChildHeizungkonfiguratorUserdaten findOneByBaujahr(int $baujahr) Return the first ChildHeizungkonfiguratorUserdaten filtered by the baujahr column
 * @method     ChildHeizungkonfiguratorUserdaten findOneByHeizflaeche(int $heizflaeche) Return the first ChildHeizungkonfiguratorUserdaten filtered by the heizflaeche column
 * @method     ChildHeizungkonfiguratorUserdaten findOneByWaermedaemmung(string $waermedaemmung) Return the first ChildHeizungkonfiguratorUserdaten filtered by the waermedaemmung column
 * @method     ChildHeizungkonfiguratorUserdaten findOneByVerglasteFenster(string $verglaste_fenster) Return the first ChildHeizungkonfiguratorUserdaten filtered by the verglaste_fenster column
 * @method     ChildHeizungkonfiguratorUserdaten findOneByGebaeudelage(string $gebaeudelage) Return the first ChildHeizungkonfiguratorUserdaten filtered by the gebaeudelage column
 * @method     ChildHeizungkonfiguratorUserdaten findOneByWindlage(string $windlage) Return the first ChildHeizungkonfiguratorUserdaten filtered by the windlage column
 * @method     ChildHeizungkonfiguratorUserdaten findOneByAnzahlAussenwaende(int $anzahl_aussenwaende) Return the first ChildHeizungkonfiguratorUserdaten filtered by the anzahl_aussenwaende column
 * @method     ChildHeizungkonfiguratorUserdaten findOneByWohnraumtemperatur(int $wohnraumtemperatur) Return the first ChildHeizungkonfiguratorUserdaten filtered by the wohnraumtemperatur column
 * @method     ChildHeizungkonfiguratorUserdaten findOneByAussentemperatur(int $aussentemperatur) Return the first ChildHeizungkonfiguratorUserdaten filtered by the aussentemperatur column
 * @method     ChildHeizungkonfiguratorUserdaten findOneByAnmerkungen(string $anmerkungen) Return the first ChildHeizungkonfiguratorUserdaten filtered by the anmerkungen column
 * @method     ChildHeizungkonfiguratorUserdaten findOneByFotoId(int $foto_id) Return the first ChildHeizungkonfiguratorUserdaten filtered by the foto_id column
 * @method     ChildHeizungkonfiguratorUserdaten findOneByVersion(string $version) Return the first ChildHeizungkonfiguratorUserdaten filtered by the version column
 * @method     ChildHeizungkonfiguratorUserdaten findOneByCreatedAt(string $created_at) Return the first ChildHeizungkonfiguratorUserdaten filtered by the created_at column
 * @method     ChildHeizungkonfiguratorUserdaten findOneByEtagen(int $etagen) Return the first ChildHeizungkonfiguratorUserdaten filtered by the etagen column
 * @method     ChildHeizungkonfiguratorUserdaten findOneByDachDaemmung(string $dach_daemmung) Return the first ChildHeizungkonfiguratorUserdaten filtered by the dach_daemmung column
 * @method     ChildHeizungkonfiguratorUserdaten findOneByAbgasfuehrung(string $abgasfuehrung) Return the first ChildHeizungkonfiguratorUserdaten filtered by the abgasfuehrung column
 * @method     ChildHeizungkonfiguratorUserdaten findOneByWaermeabgabe(string $waermeabgabe) Return the first ChildHeizungkonfiguratorUserdaten filtered by the waermeabgabe column
 * @method     ChildHeizungkonfiguratorUserdaten findOneByDuschwasser(string $duschwasser) Return the first ChildHeizungkonfiguratorUserdaten filtered by the duschwasser column
 * @method     ChildHeizungkonfiguratorUserdaten findOneByWasserabfluss(string $wasserabfluss) Return the first ChildHeizungkonfiguratorUserdaten filtered by the wasserabfluss column
 * @method     ChildHeizungkonfiguratorUserdaten findOneByWarmwasserversorgung(string $warmwasserversorgung) Return the first ChildHeizungkonfiguratorUserdaten filtered by the warmwasserversorgung column
 * @method     ChildHeizungkonfiguratorUserdaten findOneByWarmwasserversorgungExtra(string $warmwasserversorgung_extra) Return the first ChildHeizungkonfiguratorUserdaten filtered by the warmwasserversorgung_extra column
 * @method     ChildHeizungkonfiguratorUserdaten findOneByWarmwasserversorgungExtraWaermepumpe(string $warmwasserversorgung_extra_waermepumpe) Return the first ChildHeizungkonfiguratorUserdaten filtered by the warmwasserversorgung_extra_waermepumpe column
 *
 * @method     array findById(int $id) Return ChildHeizungkonfiguratorUserdaten objects filtered by the id column
 * @method     array findByUserId(int $user_id) Return ChildHeizungkonfiguratorUserdaten objects filtered by the user_id column
 * @method     array findByBrennstoffMomentan(string $brennstoff_momentan) Return ChildHeizungkonfiguratorUserdaten objects filtered by the brennstoff_momentan column
 * @method     array findByBrennstoffZukunft(string $brennstoff_zukunft) Return ChildHeizungkonfiguratorUserdaten objects filtered by the brennstoff_zukunft column
 * @method     array findByGebaeudeart(string $gebaeudeart) Return ChildHeizungkonfiguratorUserdaten objects filtered by the gebaeudeart column
 * @method     array findByPersonenAnzahl(int $personen_anzahl) Return ChildHeizungkonfiguratorUserdaten objects filtered by the personen_anzahl column
 * @method     array findByBestehendeGeraetWarmwasser(string $bestehende_geraet_warmwasser) Return ChildHeizungkonfiguratorUserdaten objects filtered by the bestehende_geraet_warmwasser column
 * @method     array findByBestehendeGeraetKw(int $bestehende_geraet_kw) Return ChildHeizungkonfiguratorUserdaten objects filtered by the bestehende_geraet_kw column
 * @method     array findByBaujahr(int $baujahr) Return ChildHeizungkonfiguratorUserdaten objects filtered by the baujahr column
 * @method     array findByHeizflaeche(int $heizflaeche) Return ChildHeizungkonfiguratorUserdaten objects filtered by the heizflaeche column
 * @method     array findByWaermedaemmung(string $waermedaemmung) Return ChildHeizungkonfiguratorUserdaten objects filtered by the waermedaemmung column
 * @method     array findByVerglasteFenster(string $verglaste_fenster) Return ChildHeizungkonfiguratorUserdaten objects filtered by the verglaste_fenster column
 * @method     array findByGebaeudelage(string $gebaeudelage) Return ChildHeizungkonfiguratorUserdaten objects filtered by the gebaeudelage column
 * @method     array findByWindlage(string $windlage) Return ChildHeizungkonfiguratorUserdaten objects filtered by the windlage column
 * @method     array findByAnzahlAussenwaende(int $anzahl_aussenwaende) Return ChildHeizungkonfiguratorUserdaten objects filtered by the anzahl_aussenwaende column
 * @method     array findByWohnraumtemperatur(int $wohnraumtemperatur) Return ChildHeizungkonfiguratorUserdaten objects filtered by the wohnraumtemperatur column
 * @method     array findByAussentemperatur(int $aussentemperatur) Return ChildHeizungkonfiguratorUserdaten objects filtered by the aussentemperatur column
 * @method     array findByAnmerkungen(string $anmerkungen) Return ChildHeizungkonfiguratorUserdaten objects filtered by the anmerkungen column
 * @method     array findByFotoId(int $foto_id) Return ChildHeizungkonfiguratorUserdaten objects filtered by the foto_id column
 * @method     array findByVersion(string $version) Return ChildHeizungkonfiguratorUserdaten objects filtered by the version column
 * @method     array findByCreatedAt(string $created_at) Return ChildHeizungkonfiguratorUserdaten objects filtered by the created_at column
 * @method     array findByEtagen(int $etagen) Return ChildHeizungkonfiguratorUserdaten objects filtered by the etagen column
 * @method     array findByDachDaemmung(string $dach_daemmung) Return ChildHeizungkonfiguratorUserdaten objects filtered by the dach_daemmung column
 * @method     array findByAbgasfuehrung(string $abgasfuehrung) Return ChildHeizungkonfiguratorUserdaten objects filtered by the abgasfuehrung column
 * @method     array findByWaermeabgabe(string $waermeabgabe) Return ChildHeizungkonfiguratorUserdaten objects filtered by the waermeabgabe column
 * @method     array findByDuschwasser(string $duschwasser) Return ChildHeizungkonfiguratorUserdaten objects filtered by the duschwasser column
 * @method     array findByWasserabfluss(string $wasserabfluss) Return ChildHeizungkonfiguratorUserdaten objects filtered by the wasserabfluss column
 * @method     array findByWarmwasserversorgung(string $warmwasserversorgung) Return ChildHeizungkonfiguratorUserdaten objects filtered by the warmwasserversorgung column
 * @method     array findByWarmwasserversorgungExtra(string $warmwasserversorgung_extra) Return ChildHeizungkonfiguratorUserdaten objects filtered by the warmwasserversorgung_extra column
 * @method     array findByWarmwasserversorgungExtraWaermepumpe(string $warmwasserversorgung_extra_waermepumpe) Return ChildHeizungkonfiguratorUserdaten objects filtered by the warmwasserversorgung_extra_waermepumpe column
 *
 */
abstract class HeizungkonfiguratorUserdatenQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \HookKonfigurator\Model\Base\HeizungkonfiguratorUserdatenQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'thelia', $modelName = '\\HookKonfigurator\\Model\\HeizungkonfiguratorUserdaten', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildHeizungkonfiguratorUserdatenQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildHeizungkonfiguratorUserdatenQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \HookKonfigurator\Model\HeizungkonfiguratorUserdatenQuery) {
            return $criteria;
        }
        $query = new \HookKonfigurator\Model\HeizungkonfiguratorUserdatenQuery();
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
     * @return ChildHeizungkonfiguratorUserdaten|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = HeizungkonfiguratorUserdatenTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(HeizungkonfiguratorUserdatenTableMap::DATABASE_NAME);
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
     * @return   ChildHeizungkonfiguratorUserdaten A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ID, USER_ID, BRENNSTOFF_MOMENTAN, BRENNSTOFF_ZUKUNFT, GEBAEUDEART, PERSONEN_ANZAHL, BESTEHENDE_GERAET_WARMWASSER, BESTEHENDE_GERAET_KW, BAUJAHR, HEIZFLAECHE, WAERMEDAEMMUNG, VERGLASTE_FENSTER, GEBAEUDELAGE, WINDLAGE, ANZAHL_AUSSENWAENDE, WOHNRAUMTEMPERATUR, AUSSENTEMPERATUR, ANMERKUNGEN, FOTO_ID, VERSION, CREATED_AT, ETAGEN, DACH_DAEMMUNG, ABGASFUEHRUNG, WAERMEABGABE, DUSCHWASSER, WASSERABFLUSS, WARMWASSERVERSORGUNG, WARMWASSERVERSORGUNG_EXTRA, WARMWASSERVERSORGUNG_EXTRA_WAERMEPUMPE FROM heizungkonfigurator_userdaten WHERE ID = :p0';
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
            $obj = new ChildHeizungkonfiguratorUserdaten();
            $obj->hydrate($row);
            HeizungkonfiguratorUserdatenTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildHeizungkonfiguratorUserdaten|array|mixed the result, formatted by the current formatter
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
     * @return ChildHeizungkonfiguratorUserdatenQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(HeizungkonfiguratorUserdatenTableMap::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildHeizungkonfiguratorUserdatenQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(HeizungkonfiguratorUserdatenTableMap::ID, $keys, Criteria::IN);
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
     * @return ChildHeizungkonfiguratorUserdatenQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(HeizungkonfiguratorUserdatenTableMap::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(HeizungkonfiguratorUserdatenTableMap::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(HeizungkonfiguratorUserdatenTableMap::ID, $id, $comparison);
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
     * @return ChildHeizungkonfiguratorUserdatenQuery The current query, for fluid interface
     */
    public function filterByUserId($userId = null, $comparison = null)
    {
        if (is_array($userId)) {
            $useMinMax = false;
            if (isset($userId['min'])) {
                $this->addUsingAlias(HeizungkonfiguratorUserdatenTableMap::USER_ID, $userId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($userId['max'])) {
                $this->addUsingAlias(HeizungkonfiguratorUserdatenTableMap::USER_ID, $userId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(HeizungkonfiguratorUserdatenTableMap::USER_ID, $userId, $comparison);
    }

    /**
     * Filter the query on the brennstoff_momentan column
     *
     * Example usage:
     * <code>
     * $query->filterByBrennstoffMomentan('fooValue');   // WHERE brennstoff_momentan = 'fooValue'
     * $query->filterByBrennstoffMomentan('%fooValue%'); // WHERE brennstoff_momentan LIKE '%fooValue%'
     * </code>
     *
     * @param     string $brennstoffMomentan The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildHeizungkonfiguratorUserdatenQuery The current query, for fluid interface
     */
    public function filterByBrennstoffMomentan($brennstoffMomentan = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($brennstoffMomentan)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $brennstoffMomentan)) {
                $brennstoffMomentan = str_replace('*', '%', $brennstoffMomentan);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(HeizungkonfiguratorUserdatenTableMap::BRENNSTOFF_MOMENTAN, $brennstoffMomentan, $comparison);
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
     * @return ChildHeizungkonfiguratorUserdatenQuery The current query, for fluid interface
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

        return $this->addUsingAlias(HeizungkonfiguratorUserdatenTableMap::BRENNSTOFF_ZUKUNFT, $brennstoffZukunft, $comparison);
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
     * @return ChildHeizungkonfiguratorUserdatenQuery The current query, for fluid interface
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

        return $this->addUsingAlias(HeizungkonfiguratorUserdatenTableMap::GEBAEUDEART, $gebaeudeart, $comparison);
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
     * @return ChildHeizungkonfiguratorUserdatenQuery The current query, for fluid interface
     */
    public function filterByPersonenAnzahl($personenAnzahl = null, $comparison = null)
    {
        if (is_array($personenAnzahl)) {
            $useMinMax = false;
            if (isset($personenAnzahl['min'])) {
                $this->addUsingAlias(HeizungkonfiguratorUserdatenTableMap::PERSONEN_ANZAHL, $personenAnzahl['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($personenAnzahl['max'])) {
                $this->addUsingAlias(HeizungkonfiguratorUserdatenTableMap::PERSONEN_ANZAHL, $personenAnzahl['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(HeizungkonfiguratorUserdatenTableMap::PERSONEN_ANZAHL, $personenAnzahl, $comparison);
    }

    /**
     * Filter the query on the bestehende_geraet_warmwasser column
     *
     * Example usage:
     * <code>
     * $query->filterByBestehendeGeraetWarmwasser('fooValue');   // WHERE bestehende_geraet_warmwasser = 'fooValue'
     * $query->filterByBestehendeGeraetWarmwasser('%fooValue%'); // WHERE bestehende_geraet_warmwasser LIKE '%fooValue%'
     * </code>
     *
     * @param     string $bestehendeGeraetWarmwasser The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildHeizungkonfiguratorUserdatenQuery The current query, for fluid interface
     */
    public function filterByBestehendeGeraetWarmwasser($bestehendeGeraetWarmwasser = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($bestehendeGeraetWarmwasser)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $bestehendeGeraetWarmwasser)) {
                $bestehendeGeraetWarmwasser = str_replace('*', '%', $bestehendeGeraetWarmwasser);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(HeizungkonfiguratorUserdatenTableMap::BESTEHENDE_GERAET_WARMWASSER, $bestehendeGeraetWarmwasser, $comparison);
    }

    /**
     * Filter the query on the bestehende_geraet_kw column
     *
     * Example usage:
     * <code>
     * $query->filterByBestehendeGeraetKw(1234); // WHERE bestehende_geraet_kw = 1234
     * $query->filterByBestehendeGeraetKw(array(12, 34)); // WHERE bestehende_geraet_kw IN (12, 34)
     * $query->filterByBestehendeGeraetKw(array('min' => 12)); // WHERE bestehende_geraet_kw > 12
     * </code>
     *
     * @param     mixed $bestehendeGeraetKw The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildHeizungkonfiguratorUserdatenQuery The current query, for fluid interface
     */
    public function filterByBestehendeGeraetKw($bestehendeGeraetKw = null, $comparison = null)
    {
        if (is_array($bestehendeGeraetKw)) {
            $useMinMax = false;
            if (isset($bestehendeGeraetKw['min'])) {
                $this->addUsingAlias(HeizungkonfiguratorUserdatenTableMap::BESTEHENDE_GERAET_KW, $bestehendeGeraetKw['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($bestehendeGeraetKw['max'])) {
                $this->addUsingAlias(HeizungkonfiguratorUserdatenTableMap::BESTEHENDE_GERAET_KW, $bestehendeGeraetKw['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(HeizungkonfiguratorUserdatenTableMap::BESTEHENDE_GERAET_KW, $bestehendeGeraetKw, $comparison);
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
     * @return ChildHeizungkonfiguratorUserdatenQuery The current query, for fluid interface
     */
    public function filterByBaujahr($baujahr = null, $comparison = null)
    {
        if (is_array($baujahr)) {
            $useMinMax = false;
            if (isset($baujahr['min'])) {
                $this->addUsingAlias(HeizungkonfiguratorUserdatenTableMap::BAUJAHR, $baujahr['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($baujahr['max'])) {
                $this->addUsingAlias(HeizungkonfiguratorUserdatenTableMap::BAUJAHR, $baujahr['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(HeizungkonfiguratorUserdatenTableMap::BAUJAHR, $baujahr, $comparison);
    }

    /**
     * Filter the query on the heizflaeche column
     *
     * Example usage:
     * <code>
     * $query->filterByHeizflaeche(1234); // WHERE heizflaeche = 1234
     * $query->filterByHeizflaeche(array(12, 34)); // WHERE heizflaeche IN (12, 34)
     * $query->filterByHeizflaeche(array('min' => 12)); // WHERE heizflaeche > 12
     * </code>
     *
     * @param     mixed $heizflaeche The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildHeizungkonfiguratorUserdatenQuery The current query, for fluid interface
     */
    public function filterByHeizflaeche($heizflaeche = null, $comparison = null)
    {
        if (is_array($heizflaeche)) {
            $useMinMax = false;
            if (isset($heizflaeche['min'])) {
                $this->addUsingAlias(HeizungkonfiguratorUserdatenTableMap::HEIZFLAECHE, $heizflaeche['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($heizflaeche['max'])) {
                $this->addUsingAlias(HeizungkonfiguratorUserdatenTableMap::HEIZFLAECHE, $heizflaeche['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(HeizungkonfiguratorUserdatenTableMap::HEIZFLAECHE, $heizflaeche, $comparison);
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
     * @return ChildHeizungkonfiguratorUserdatenQuery The current query, for fluid interface
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

        return $this->addUsingAlias(HeizungkonfiguratorUserdatenTableMap::WAERMEDAEMMUNG, $waermedaemmung, $comparison);
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
     * @return ChildHeizungkonfiguratorUserdatenQuery The current query, for fluid interface
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

        return $this->addUsingAlias(HeizungkonfiguratorUserdatenTableMap::VERGLASTE_FENSTER, $verglasteFenster, $comparison);
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
     * @return ChildHeizungkonfiguratorUserdatenQuery The current query, for fluid interface
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

        return $this->addUsingAlias(HeizungkonfiguratorUserdatenTableMap::GEBAEUDELAGE, $gebaeudelage, $comparison);
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
     * @return ChildHeizungkonfiguratorUserdatenQuery The current query, for fluid interface
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

        return $this->addUsingAlias(HeizungkonfiguratorUserdatenTableMap::WINDLAGE, $windlage, $comparison);
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
     * @return ChildHeizungkonfiguratorUserdatenQuery The current query, for fluid interface
     */
    public function filterByAnzahlAussenwaende($anzahlAussenwaende = null, $comparison = null)
    {
        if (is_array($anzahlAussenwaende)) {
            $useMinMax = false;
            if (isset($anzahlAussenwaende['min'])) {
                $this->addUsingAlias(HeizungkonfiguratorUserdatenTableMap::ANZAHL_AUSSENWAENDE, $anzahlAussenwaende['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($anzahlAussenwaende['max'])) {
                $this->addUsingAlias(HeizungkonfiguratorUserdatenTableMap::ANZAHL_AUSSENWAENDE, $anzahlAussenwaende['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(HeizungkonfiguratorUserdatenTableMap::ANZAHL_AUSSENWAENDE, $anzahlAussenwaende, $comparison);
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
     * @return ChildHeizungkonfiguratorUserdatenQuery The current query, for fluid interface
     */
    public function filterByWohnraumtemperatur($wohnraumtemperatur = null, $comparison = null)
    {
        if (is_array($wohnraumtemperatur)) {
            $useMinMax = false;
            if (isset($wohnraumtemperatur['min'])) {
                $this->addUsingAlias(HeizungkonfiguratorUserdatenTableMap::WOHNRAUMTEMPERATUR, $wohnraumtemperatur['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($wohnraumtemperatur['max'])) {
                $this->addUsingAlias(HeizungkonfiguratorUserdatenTableMap::WOHNRAUMTEMPERATUR, $wohnraumtemperatur['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(HeizungkonfiguratorUserdatenTableMap::WOHNRAUMTEMPERATUR, $wohnraumtemperatur, $comparison);
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
     * @return ChildHeizungkonfiguratorUserdatenQuery The current query, for fluid interface
     */
    public function filterByAussentemperatur($aussentemperatur = null, $comparison = null)
    {
        if (is_array($aussentemperatur)) {
            $useMinMax = false;
            if (isset($aussentemperatur['min'])) {
                $this->addUsingAlias(HeizungkonfiguratorUserdatenTableMap::AUSSENTEMPERATUR, $aussentemperatur['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($aussentemperatur['max'])) {
                $this->addUsingAlias(HeizungkonfiguratorUserdatenTableMap::AUSSENTEMPERATUR, $aussentemperatur['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(HeizungkonfiguratorUserdatenTableMap::AUSSENTEMPERATUR, $aussentemperatur, $comparison);
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
     * @return ChildHeizungkonfiguratorUserdatenQuery The current query, for fluid interface
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

        return $this->addUsingAlias(HeizungkonfiguratorUserdatenTableMap::ANMERKUNGEN, $anmerkungen, $comparison);
    }

    /**
     * Filter the query on the foto_id column
     *
     * Example usage:
     * <code>
     * $query->filterByFotoId(1234); // WHERE foto_id = 1234
     * $query->filterByFotoId(array(12, 34)); // WHERE foto_id IN (12, 34)
     * $query->filterByFotoId(array('min' => 12)); // WHERE foto_id > 12
     * </code>
     *
     * @param     mixed $fotoId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildHeizungkonfiguratorUserdatenQuery The current query, for fluid interface
     */
    public function filterByFotoId($fotoId = null, $comparison = null)
    {
        if (is_array($fotoId)) {
            $useMinMax = false;
            if (isset($fotoId['min'])) {
                $this->addUsingAlias(HeizungkonfiguratorUserdatenTableMap::FOTO_ID, $fotoId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($fotoId['max'])) {
                $this->addUsingAlias(HeizungkonfiguratorUserdatenTableMap::FOTO_ID, $fotoId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(HeizungkonfiguratorUserdatenTableMap::FOTO_ID, $fotoId, $comparison);
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
     * @return ChildHeizungkonfiguratorUserdatenQuery The current query, for fluid interface
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

        return $this->addUsingAlias(HeizungkonfiguratorUserdatenTableMap::VERSION, $version, $comparison);
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
     * @return ChildHeizungkonfiguratorUserdatenQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(HeizungkonfiguratorUserdatenTableMap::CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(HeizungkonfiguratorUserdatenTableMap::CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(HeizungkonfiguratorUserdatenTableMap::CREATED_AT, $createdAt, $comparison);
    }

    /**
     * Filter the query on the etagen column
     *
     * Example usage:
     * <code>
     * $query->filterByEtagen(1234); // WHERE etagen = 1234
     * $query->filterByEtagen(array(12, 34)); // WHERE etagen IN (12, 34)
     * $query->filterByEtagen(array('min' => 12)); // WHERE etagen > 12
     * </code>
     *
     * @param     mixed $etagen The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildHeizungkonfiguratorUserdatenQuery The current query, for fluid interface
     */
    public function filterByEtagen($etagen = null, $comparison = null)
    {
        if (is_array($etagen)) {
            $useMinMax = false;
            if (isset($etagen['min'])) {
                $this->addUsingAlias(HeizungkonfiguratorUserdatenTableMap::ETAGEN, $etagen['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($etagen['max'])) {
                $this->addUsingAlias(HeizungkonfiguratorUserdatenTableMap::ETAGEN, $etagen['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(HeizungkonfiguratorUserdatenTableMap::ETAGEN, $etagen, $comparison);
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
     * @return ChildHeizungkonfiguratorUserdatenQuery The current query, for fluid interface
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

        return $this->addUsingAlias(HeizungkonfiguratorUserdatenTableMap::DACH_DAEMMUNG, $dachDaemmung, $comparison);
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
     * @return ChildHeizungkonfiguratorUserdatenQuery The current query, for fluid interface
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

        return $this->addUsingAlias(HeizungkonfiguratorUserdatenTableMap::ABGASFUEHRUNG, $abgasfuehrung, $comparison);
    }

    /**
     * Filter the query on the waermeabgabe column
     *
     * Example usage:
     * <code>
     * $query->filterByWaermeabgabe('fooValue');   // WHERE waermeabgabe = 'fooValue'
     * $query->filterByWaermeabgabe('%fooValue%'); // WHERE waermeabgabe LIKE '%fooValue%'
     * </code>
     *
     * @param     string $waermeabgabe The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildHeizungkonfiguratorUserdatenQuery The current query, for fluid interface
     */
    public function filterByWaermeabgabe($waermeabgabe = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($waermeabgabe)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $waermeabgabe)) {
                $waermeabgabe = str_replace('*', '%', $waermeabgabe);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(HeizungkonfiguratorUserdatenTableMap::WAERMEABGABE, $waermeabgabe, $comparison);
    }

    /**
     * Filter the query on the duschwasser column
     *
     * Example usage:
     * <code>
     * $query->filterByDuschwasser('fooValue');   // WHERE duschwasser = 'fooValue'
     * $query->filterByDuschwasser('%fooValue%'); // WHERE duschwasser LIKE '%fooValue%'
     * </code>
     *
     * @param     string $duschwasser The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildHeizungkonfiguratorUserdatenQuery The current query, for fluid interface
     */
    public function filterByDuschwasser($duschwasser = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($duschwasser)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $duschwasser)) {
                $duschwasser = str_replace('*', '%', $duschwasser);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(HeizungkonfiguratorUserdatenTableMap::DUSCHWASSER, $duschwasser, $comparison);
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
     * @return ChildHeizungkonfiguratorUserdatenQuery The current query, for fluid interface
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

        return $this->addUsingAlias(HeizungkonfiguratorUserdatenTableMap::WASSERABFLUSS, $wasserabfluss, $comparison);
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
     * @return ChildHeizungkonfiguratorUserdatenQuery The current query, for fluid interface
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

        return $this->addUsingAlias(HeizungkonfiguratorUserdatenTableMap::WARMWASSERVERSORGUNG, $warmwasserversorgung, $comparison);
    }

    /**
     * Filter the query on the warmwasserversorgung_extra column
     *
     * Example usage:
     * <code>
     * $query->filterByWarmwasserversorgungExtra('fooValue');   // WHERE warmwasserversorgung_extra = 'fooValue'
     * $query->filterByWarmwasserversorgungExtra('%fooValue%'); // WHERE warmwasserversorgung_extra LIKE '%fooValue%'
     * </code>
     *
     * @param     string $warmwasserversorgungExtra The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildHeizungkonfiguratorUserdatenQuery The current query, for fluid interface
     */
    public function filterByWarmwasserversorgungExtra($warmwasserversorgungExtra = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($warmwasserversorgungExtra)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $warmwasserversorgungExtra)) {
                $warmwasserversorgungExtra = str_replace('*', '%', $warmwasserversorgungExtra);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(HeizungkonfiguratorUserdatenTableMap::WARMWASSERVERSORGUNG_EXTRA, $warmwasserversorgungExtra, $comparison);
    }

    /**
     * Filter the query on the warmwasserversorgung_extra_waermepumpe column
     *
     * Example usage:
     * <code>
     * $query->filterByWarmwasserversorgungExtraWaermepumpe('fooValue');   // WHERE warmwasserversorgung_extra_waermepumpe = 'fooValue'
     * $query->filterByWarmwasserversorgungExtraWaermepumpe('%fooValue%'); // WHERE warmwasserversorgung_extra_waermepumpe LIKE '%fooValue%'
     * </code>
     *
     * @param     string $warmwasserversorgungExtraWaermepumpe The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildHeizungkonfiguratorUserdatenQuery The current query, for fluid interface
     */
    public function filterByWarmwasserversorgungExtraWaermepumpe($warmwasserversorgungExtraWaermepumpe = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($warmwasserversorgungExtraWaermepumpe)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $warmwasserversorgungExtraWaermepumpe)) {
                $warmwasserversorgungExtraWaermepumpe = str_replace('*', '%', $warmwasserversorgungExtraWaermepumpe);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(HeizungkonfiguratorUserdatenTableMap::WARMWASSERVERSORGUNG_EXTRA_WAERMEPUMPE, $warmwasserversorgungExtraWaermepumpe, $comparison);
    }

    /**
     * Filter the query by a related \HookKonfigurator\Model\HeizungkonfiguratorImage object
     *
     * @param \HookKonfigurator\Model\HeizungkonfiguratorImage|ObjectCollection $heizungkonfiguratorImage  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildHeizungkonfiguratorUserdatenQuery The current query, for fluid interface
     */
    public function filterByHeizungkonfiguratorImage($heizungkonfiguratorImage, $comparison = null)
    {
        if ($heizungkonfiguratorImage instanceof \HookKonfigurator\Model\HeizungkonfiguratorImage) {
            return $this
                ->addUsingAlias(HeizungkonfiguratorUserdatenTableMap::ID, $heizungkonfiguratorImage->getHeizunkskonfiguratorId(), $comparison);
        } elseif ($heizungkonfiguratorImage instanceof ObjectCollection) {
            return $this
                ->useHeizungkonfiguratorImageQuery()
                ->filterByPrimaryKeys($heizungkonfiguratorImage->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByHeizungkonfiguratorImage() only accepts arguments of type \HookKonfigurator\Model\HeizungkonfiguratorImage or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the HeizungkonfiguratorImage relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildHeizungkonfiguratorUserdatenQuery The current query, for fluid interface
     */
    public function joinHeizungkonfiguratorImage($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('HeizungkonfiguratorImage');

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
            $this->addJoinObject($join, 'HeizungkonfiguratorImage');
        }

        return $this;
    }

    /**
     * Use the HeizungkonfiguratorImage relation HeizungkonfiguratorImage object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \HookKonfigurator\Model\HeizungkonfiguratorImageQuery A secondary query class using the current class as primary query
     */
    public function useHeizungkonfiguratorImageQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinHeizungkonfiguratorImage($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'HeizungkonfiguratorImage', '\HookKonfigurator\Model\HeizungkonfiguratorImageQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildHeizungkonfiguratorUserdaten $heizungkonfiguratorUserdaten Object to remove from the list of results
     *
     * @return ChildHeizungkonfiguratorUserdatenQuery The current query, for fluid interface
     */
    public function prune($heizungkonfiguratorUserdaten = null)
    {
        if ($heizungkonfiguratorUserdaten) {
            $this->addUsingAlias(HeizungkonfiguratorUserdatenTableMap::ID, $heizungkonfiguratorUserdaten->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the heizungkonfigurator_userdaten table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(HeizungkonfiguratorUserdatenTableMap::DATABASE_NAME);
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
            HeizungkonfiguratorUserdatenTableMap::clearInstancePool();
            HeizungkonfiguratorUserdatenTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildHeizungkonfiguratorUserdaten or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildHeizungkonfiguratorUserdaten object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(HeizungkonfiguratorUserdatenTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(HeizungkonfiguratorUserdatenTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();


        HeizungkonfiguratorUserdatenTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            HeizungkonfiguratorUserdatenTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

} // HeizungkonfiguratorUserdatenQuery
