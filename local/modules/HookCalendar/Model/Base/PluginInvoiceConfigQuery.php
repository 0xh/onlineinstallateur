<?php

namespace HookCalendar\Model\Base;

use \Exception;
use \PDO;
use HookCalendar\Model\PluginInvoiceConfig as ChildPluginInvoiceConfig;
use HookCalendar\Model\PluginInvoiceConfigQuery as ChildPluginInvoiceConfigQuery;
use HookCalendar\Model\Map\PluginInvoiceConfigTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'plugin_invoice_config' table.
 *
 *
 *
 * @method     ChildPluginInvoiceConfigQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildPluginInvoiceConfigQuery orderByYLogo($order = Criteria::ASC) Order by the y_logo column
 * @method     ChildPluginInvoiceConfigQuery orderByYCompany($order = Criteria::ASC) Order by the y_company column
 * @method     ChildPluginInvoiceConfigQuery orderByYName($order = Criteria::ASC) Order by the y_name column
 * @method     ChildPluginInvoiceConfigQuery orderByYStreetAddress($order = Criteria::ASC) Order by the y_street_address column
 * @method     ChildPluginInvoiceConfigQuery orderByYCountry($order = Criteria::ASC) Order by the y_country column
 * @method     ChildPluginInvoiceConfigQuery orderByYCity($order = Criteria::ASC) Order by the y_city column
 * @method     ChildPluginInvoiceConfigQuery orderByYState($order = Criteria::ASC) Order by the y_state column
 * @method     ChildPluginInvoiceConfigQuery orderByYZip($order = Criteria::ASC) Order by the y_zip column
 * @method     ChildPluginInvoiceConfigQuery orderByYPhone($order = Criteria::ASC) Order by the y_phone column
 * @method     ChildPluginInvoiceConfigQuery orderByYFax($order = Criteria::ASC) Order by the y_fax column
 * @method     ChildPluginInvoiceConfigQuery orderByYEmail($order = Criteria::ASC) Order by the y_email column
 * @method     ChildPluginInvoiceConfigQuery orderByYUrl($order = Criteria::ASC) Order by the y_url column
 * @method     ChildPluginInvoiceConfigQuery orderByYTemplate($order = Criteria::ASC) Order by the y_template column
 * @method     ChildPluginInvoiceConfigQuery orderByPAcceptPayments($order = Criteria::ASC) Order by the p_accept_payments column
 * @method     ChildPluginInvoiceConfigQuery orderByPAcceptPaypal($order = Criteria::ASC) Order by the p_accept_paypal column
 * @method     ChildPluginInvoiceConfigQuery orderByPAcceptAuthorize($order = Criteria::ASC) Order by the p_accept_authorize column
 * @method     ChildPluginInvoiceConfigQuery orderByPAcceptCreditcard($order = Criteria::ASC) Order by the p_accept_creditcard column
 * @method     ChildPluginInvoiceConfigQuery orderByPAcceptCash($order = Criteria::ASC) Order by the p_accept_cash column
 * @method     ChildPluginInvoiceConfigQuery orderByPAcceptBank($order = Criteria::ASC) Order by the p_accept_bank column
 * @method     ChildPluginInvoiceConfigQuery orderByPPaypalAddress($order = Criteria::ASC) Order by the p_paypal_address column
 * @method     ChildPluginInvoiceConfigQuery orderByPAuthorizeTz($order = Criteria::ASC) Order by the p_authorize_tz column
 * @method     ChildPluginInvoiceConfigQuery orderByPAuthorizeKey($order = Criteria::ASC) Order by the p_authorize_key column
 * @method     ChildPluginInvoiceConfigQuery orderByPAuthorizeMid($order = Criteria::ASC) Order by the p_authorize_mid column
 * @method     ChildPluginInvoiceConfigQuery orderByPAuthorizeHash($order = Criteria::ASC) Order by the p_authorize_hash column
 * @method     ChildPluginInvoiceConfigQuery orderByPBankAccount($order = Criteria::ASC) Order by the p_bank_account column
 * @method     ChildPluginInvoiceConfigQuery orderBySiInclude($order = Criteria::ASC) Order by the si_include column
 * @method     ChildPluginInvoiceConfigQuery orderBySiShippingAddress($order = Criteria::ASC) Order by the si_shipping_address column
 * @method     ChildPluginInvoiceConfigQuery orderBySiCompany($order = Criteria::ASC) Order by the si_company column
 * @method     ChildPluginInvoiceConfigQuery orderBySiName($order = Criteria::ASC) Order by the si_name column
 * @method     ChildPluginInvoiceConfigQuery orderBySiAddress($order = Criteria::ASC) Order by the si_address column
 * @method     ChildPluginInvoiceConfigQuery orderBySiStreetAddress($order = Criteria::ASC) Order by the si_street_address column
 * @method     ChildPluginInvoiceConfigQuery orderBySiCity($order = Criteria::ASC) Order by the si_city column
 * @method     ChildPluginInvoiceConfigQuery orderBySiState($order = Criteria::ASC) Order by the si_state column
 * @method     ChildPluginInvoiceConfigQuery orderBySiZip($order = Criteria::ASC) Order by the si_zip column
 * @method     ChildPluginInvoiceConfigQuery orderBySiPhone($order = Criteria::ASC) Order by the si_phone column
 * @method     ChildPluginInvoiceConfigQuery orderBySiFax($order = Criteria::ASC) Order by the si_fax column
 * @method     ChildPluginInvoiceConfigQuery orderBySiEmail($order = Criteria::ASC) Order by the si_email column
 * @method     ChildPluginInvoiceConfigQuery orderBySiUrl($order = Criteria::ASC) Order by the si_url column
 * @method     ChildPluginInvoiceConfigQuery orderBySiDate($order = Criteria::ASC) Order by the si_date column
 * @method     ChildPluginInvoiceConfigQuery orderBySiTerms($order = Criteria::ASC) Order by the si_terms column
 * @method     ChildPluginInvoiceConfigQuery orderBySiIsShipped($order = Criteria::ASC) Order by the si_is_shipped column
 * @method     ChildPluginInvoiceConfigQuery orderBySiShipping($order = Criteria::ASC) Order by the si_shipping column
 * @method     ChildPluginInvoiceConfigQuery orderByOBookingUrl($order = Criteria::ASC) Order by the o_booking_url column
 * @method     ChildPluginInvoiceConfigQuery orderByOQtyIsInt($order = Criteria::ASC) Order by the o_qty_is_int column
 * @method     ChildPluginInvoiceConfigQuery orderByOUseQtyUnitPrice($order = Criteria::ASC) Order by the o_use_qty_unit_price column
 *
 * @method     ChildPluginInvoiceConfigQuery groupById() Group by the id column
 * @method     ChildPluginInvoiceConfigQuery groupByYLogo() Group by the y_logo column
 * @method     ChildPluginInvoiceConfigQuery groupByYCompany() Group by the y_company column
 * @method     ChildPluginInvoiceConfigQuery groupByYName() Group by the y_name column
 * @method     ChildPluginInvoiceConfigQuery groupByYStreetAddress() Group by the y_street_address column
 * @method     ChildPluginInvoiceConfigQuery groupByYCountry() Group by the y_country column
 * @method     ChildPluginInvoiceConfigQuery groupByYCity() Group by the y_city column
 * @method     ChildPluginInvoiceConfigQuery groupByYState() Group by the y_state column
 * @method     ChildPluginInvoiceConfigQuery groupByYZip() Group by the y_zip column
 * @method     ChildPluginInvoiceConfigQuery groupByYPhone() Group by the y_phone column
 * @method     ChildPluginInvoiceConfigQuery groupByYFax() Group by the y_fax column
 * @method     ChildPluginInvoiceConfigQuery groupByYEmail() Group by the y_email column
 * @method     ChildPluginInvoiceConfigQuery groupByYUrl() Group by the y_url column
 * @method     ChildPluginInvoiceConfigQuery groupByYTemplate() Group by the y_template column
 * @method     ChildPluginInvoiceConfigQuery groupByPAcceptPayments() Group by the p_accept_payments column
 * @method     ChildPluginInvoiceConfigQuery groupByPAcceptPaypal() Group by the p_accept_paypal column
 * @method     ChildPluginInvoiceConfigQuery groupByPAcceptAuthorize() Group by the p_accept_authorize column
 * @method     ChildPluginInvoiceConfigQuery groupByPAcceptCreditcard() Group by the p_accept_creditcard column
 * @method     ChildPluginInvoiceConfigQuery groupByPAcceptCash() Group by the p_accept_cash column
 * @method     ChildPluginInvoiceConfigQuery groupByPAcceptBank() Group by the p_accept_bank column
 * @method     ChildPluginInvoiceConfigQuery groupByPPaypalAddress() Group by the p_paypal_address column
 * @method     ChildPluginInvoiceConfigQuery groupByPAuthorizeTz() Group by the p_authorize_tz column
 * @method     ChildPluginInvoiceConfigQuery groupByPAuthorizeKey() Group by the p_authorize_key column
 * @method     ChildPluginInvoiceConfigQuery groupByPAuthorizeMid() Group by the p_authorize_mid column
 * @method     ChildPluginInvoiceConfigQuery groupByPAuthorizeHash() Group by the p_authorize_hash column
 * @method     ChildPluginInvoiceConfigQuery groupByPBankAccount() Group by the p_bank_account column
 * @method     ChildPluginInvoiceConfigQuery groupBySiInclude() Group by the si_include column
 * @method     ChildPluginInvoiceConfigQuery groupBySiShippingAddress() Group by the si_shipping_address column
 * @method     ChildPluginInvoiceConfigQuery groupBySiCompany() Group by the si_company column
 * @method     ChildPluginInvoiceConfigQuery groupBySiName() Group by the si_name column
 * @method     ChildPluginInvoiceConfigQuery groupBySiAddress() Group by the si_address column
 * @method     ChildPluginInvoiceConfigQuery groupBySiStreetAddress() Group by the si_street_address column
 * @method     ChildPluginInvoiceConfigQuery groupBySiCity() Group by the si_city column
 * @method     ChildPluginInvoiceConfigQuery groupBySiState() Group by the si_state column
 * @method     ChildPluginInvoiceConfigQuery groupBySiZip() Group by the si_zip column
 * @method     ChildPluginInvoiceConfigQuery groupBySiPhone() Group by the si_phone column
 * @method     ChildPluginInvoiceConfigQuery groupBySiFax() Group by the si_fax column
 * @method     ChildPluginInvoiceConfigQuery groupBySiEmail() Group by the si_email column
 * @method     ChildPluginInvoiceConfigQuery groupBySiUrl() Group by the si_url column
 * @method     ChildPluginInvoiceConfigQuery groupBySiDate() Group by the si_date column
 * @method     ChildPluginInvoiceConfigQuery groupBySiTerms() Group by the si_terms column
 * @method     ChildPluginInvoiceConfigQuery groupBySiIsShipped() Group by the si_is_shipped column
 * @method     ChildPluginInvoiceConfigQuery groupBySiShipping() Group by the si_shipping column
 * @method     ChildPluginInvoiceConfigQuery groupByOBookingUrl() Group by the o_booking_url column
 * @method     ChildPluginInvoiceConfigQuery groupByOQtyIsInt() Group by the o_qty_is_int column
 * @method     ChildPluginInvoiceConfigQuery groupByOUseQtyUnitPrice() Group by the o_use_qty_unit_price column
 *
 * @method     ChildPluginInvoiceConfigQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildPluginInvoiceConfigQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildPluginInvoiceConfigQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildPluginInvoiceConfig findOne(ConnectionInterface $con = null) Return the first ChildPluginInvoiceConfig matching the query
 * @method     ChildPluginInvoiceConfig findOneOrCreate(ConnectionInterface $con = null) Return the first ChildPluginInvoiceConfig matching the query, or a new ChildPluginInvoiceConfig object populated from the query conditions when no match is found
 *
 * @method     ChildPluginInvoiceConfig findOneById(int $id) Return the first ChildPluginInvoiceConfig filtered by the id column
 * @method     ChildPluginInvoiceConfig findOneByYLogo(string $y_logo) Return the first ChildPluginInvoiceConfig filtered by the y_logo column
 * @method     ChildPluginInvoiceConfig findOneByYCompany(string $y_company) Return the first ChildPluginInvoiceConfig filtered by the y_company column
 * @method     ChildPluginInvoiceConfig findOneByYName(string $y_name) Return the first ChildPluginInvoiceConfig filtered by the y_name column
 * @method     ChildPluginInvoiceConfig findOneByYStreetAddress(string $y_street_address) Return the first ChildPluginInvoiceConfig filtered by the y_street_address column
 * @method     ChildPluginInvoiceConfig findOneByYCountry(int $y_country) Return the first ChildPluginInvoiceConfig filtered by the y_country column
 * @method     ChildPluginInvoiceConfig findOneByYCity(string $y_city) Return the first ChildPluginInvoiceConfig filtered by the y_city column
 * @method     ChildPluginInvoiceConfig findOneByYState(string $y_state) Return the first ChildPluginInvoiceConfig filtered by the y_state column
 * @method     ChildPluginInvoiceConfig findOneByYZip(string $y_zip) Return the first ChildPluginInvoiceConfig filtered by the y_zip column
 * @method     ChildPluginInvoiceConfig findOneByYPhone(string $y_phone) Return the first ChildPluginInvoiceConfig filtered by the y_phone column
 * @method     ChildPluginInvoiceConfig findOneByYFax(string $y_fax) Return the first ChildPluginInvoiceConfig filtered by the y_fax column
 * @method     ChildPluginInvoiceConfig findOneByYEmail(string $y_email) Return the first ChildPluginInvoiceConfig filtered by the y_email column
 * @method     ChildPluginInvoiceConfig findOneByYUrl(string $y_url) Return the first ChildPluginInvoiceConfig filtered by the y_url column
 * @method     ChildPluginInvoiceConfig findOneByYTemplate(string $y_template) Return the first ChildPluginInvoiceConfig filtered by the y_template column
 * @method     ChildPluginInvoiceConfig findOneByPAcceptPayments(boolean $p_accept_payments) Return the first ChildPluginInvoiceConfig filtered by the p_accept_payments column
 * @method     ChildPluginInvoiceConfig findOneByPAcceptPaypal(boolean $p_accept_paypal) Return the first ChildPluginInvoiceConfig filtered by the p_accept_paypal column
 * @method     ChildPluginInvoiceConfig findOneByPAcceptAuthorize(boolean $p_accept_authorize) Return the first ChildPluginInvoiceConfig filtered by the p_accept_authorize column
 * @method     ChildPluginInvoiceConfig findOneByPAcceptCreditcard(boolean $p_accept_creditcard) Return the first ChildPluginInvoiceConfig filtered by the p_accept_creditcard column
 * @method     ChildPluginInvoiceConfig findOneByPAcceptCash(boolean $p_accept_cash) Return the first ChildPluginInvoiceConfig filtered by the p_accept_cash column
 * @method     ChildPluginInvoiceConfig findOneByPAcceptBank(boolean $p_accept_bank) Return the first ChildPluginInvoiceConfig filtered by the p_accept_bank column
 * @method     ChildPluginInvoiceConfig findOneByPPaypalAddress(string $p_paypal_address) Return the first ChildPluginInvoiceConfig filtered by the p_paypal_address column
 * @method     ChildPluginInvoiceConfig findOneByPAuthorizeTz(string $p_authorize_tz) Return the first ChildPluginInvoiceConfig filtered by the p_authorize_tz column
 * @method     ChildPluginInvoiceConfig findOneByPAuthorizeKey(string $p_authorize_key) Return the first ChildPluginInvoiceConfig filtered by the p_authorize_key column
 * @method     ChildPluginInvoiceConfig findOneByPAuthorizeMid(string $p_authorize_mid) Return the first ChildPluginInvoiceConfig filtered by the p_authorize_mid column
 * @method     ChildPluginInvoiceConfig findOneByPAuthorizeHash(string $p_authorize_hash) Return the first ChildPluginInvoiceConfig filtered by the p_authorize_hash column
 * @method     ChildPluginInvoiceConfig findOneByPBankAccount(string $p_bank_account) Return the first ChildPluginInvoiceConfig filtered by the p_bank_account column
 * @method     ChildPluginInvoiceConfig findOneBySiInclude(boolean $si_include) Return the first ChildPluginInvoiceConfig filtered by the si_include column
 * @method     ChildPluginInvoiceConfig findOneBySiShippingAddress(boolean $si_shipping_address) Return the first ChildPluginInvoiceConfig filtered by the si_shipping_address column
 * @method     ChildPluginInvoiceConfig findOneBySiCompany(boolean $si_company) Return the first ChildPluginInvoiceConfig filtered by the si_company column
 * @method     ChildPluginInvoiceConfig findOneBySiName(boolean $si_name) Return the first ChildPluginInvoiceConfig filtered by the si_name column
 * @method     ChildPluginInvoiceConfig findOneBySiAddress(boolean $si_address) Return the first ChildPluginInvoiceConfig filtered by the si_address column
 * @method     ChildPluginInvoiceConfig findOneBySiStreetAddress(boolean $si_street_address) Return the first ChildPluginInvoiceConfig filtered by the si_street_address column
 * @method     ChildPluginInvoiceConfig findOneBySiCity(boolean $si_city) Return the first ChildPluginInvoiceConfig filtered by the si_city column
 * @method     ChildPluginInvoiceConfig findOneBySiState(boolean $si_state) Return the first ChildPluginInvoiceConfig filtered by the si_state column
 * @method     ChildPluginInvoiceConfig findOneBySiZip(boolean $si_zip) Return the first ChildPluginInvoiceConfig filtered by the si_zip column
 * @method     ChildPluginInvoiceConfig findOneBySiPhone(boolean $si_phone) Return the first ChildPluginInvoiceConfig filtered by the si_phone column
 * @method     ChildPluginInvoiceConfig findOneBySiFax(boolean $si_fax) Return the first ChildPluginInvoiceConfig filtered by the si_fax column
 * @method     ChildPluginInvoiceConfig findOneBySiEmail(boolean $si_email) Return the first ChildPluginInvoiceConfig filtered by the si_email column
 * @method     ChildPluginInvoiceConfig findOneBySiUrl(boolean $si_url) Return the first ChildPluginInvoiceConfig filtered by the si_url column
 * @method     ChildPluginInvoiceConfig findOneBySiDate(boolean $si_date) Return the first ChildPluginInvoiceConfig filtered by the si_date column
 * @method     ChildPluginInvoiceConfig findOneBySiTerms(boolean $si_terms) Return the first ChildPluginInvoiceConfig filtered by the si_terms column
 * @method     ChildPluginInvoiceConfig findOneBySiIsShipped(boolean $si_is_shipped) Return the first ChildPluginInvoiceConfig filtered by the si_is_shipped column
 * @method     ChildPluginInvoiceConfig findOneBySiShipping(boolean $si_shipping) Return the first ChildPluginInvoiceConfig filtered by the si_shipping column
 * @method     ChildPluginInvoiceConfig findOneByOBookingUrl(string $o_booking_url) Return the first ChildPluginInvoiceConfig filtered by the o_booking_url column
 * @method     ChildPluginInvoiceConfig findOneByOQtyIsInt(boolean $o_qty_is_int) Return the first ChildPluginInvoiceConfig filtered by the o_qty_is_int column
 * @method     ChildPluginInvoiceConfig findOneByOUseQtyUnitPrice(boolean $o_use_qty_unit_price) Return the first ChildPluginInvoiceConfig filtered by the o_use_qty_unit_price column
 *
 * @method     array findById(int $id) Return ChildPluginInvoiceConfig objects filtered by the id column
 * @method     array findByYLogo(string $y_logo) Return ChildPluginInvoiceConfig objects filtered by the y_logo column
 * @method     array findByYCompany(string $y_company) Return ChildPluginInvoiceConfig objects filtered by the y_company column
 * @method     array findByYName(string $y_name) Return ChildPluginInvoiceConfig objects filtered by the y_name column
 * @method     array findByYStreetAddress(string $y_street_address) Return ChildPluginInvoiceConfig objects filtered by the y_street_address column
 * @method     array findByYCountry(int $y_country) Return ChildPluginInvoiceConfig objects filtered by the y_country column
 * @method     array findByYCity(string $y_city) Return ChildPluginInvoiceConfig objects filtered by the y_city column
 * @method     array findByYState(string $y_state) Return ChildPluginInvoiceConfig objects filtered by the y_state column
 * @method     array findByYZip(string $y_zip) Return ChildPluginInvoiceConfig objects filtered by the y_zip column
 * @method     array findByYPhone(string $y_phone) Return ChildPluginInvoiceConfig objects filtered by the y_phone column
 * @method     array findByYFax(string $y_fax) Return ChildPluginInvoiceConfig objects filtered by the y_fax column
 * @method     array findByYEmail(string $y_email) Return ChildPluginInvoiceConfig objects filtered by the y_email column
 * @method     array findByYUrl(string $y_url) Return ChildPluginInvoiceConfig objects filtered by the y_url column
 * @method     array findByYTemplate(string $y_template) Return ChildPluginInvoiceConfig objects filtered by the y_template column
 * @method     array findByPAcceptPayments(boolean $p_accept_payments) Return ChildPluginInvoiceConfig objects filtered by the p_accept_payments column
 * @method     array findByPAcceptPaypal(boolean $p_accept_paypal) Return ChildPluginInvoiceConfig objects filtered by the p_accept_paypal column
 * @method     array findByPAcceptAuthorize(boolean $p_accept_authorize) Return ChildPluginInvoiceConfig objects filtered by the p_accept_authorize column
 * @method     array findByPAcceptCreditcard(boolean $p_accept_creditcard) Return ChildPluginInvoiceConfig objects filtered by the p_accept_creditcard column
 * @method     array findByPAcceptCash(boolean $p_accept_cash) Return ChildPluginInvoiceConfig objects filtered by the p_accept_cash column
 * @method     array findByPAcceptBank(boolean $p_accept_bank) Return ChildPluginInvoiceConfig objects filtered by the p_accept_bank column
 * @method     array findByPPaypalAddress(string $p_paypal_address) Return ChildPluginInvoiceConfig objects filtered by the p_paypal_address column
 * @method     array findByPAuthorizeTz(string $p_authorize_tz) Return ChildPluginInvoiceConfig objects filtered by the p_authorize_tz column
 * @method     array findByPAuthorizeKey(string $p_authorize_key) Return ChildPluginInvoiceConfig objects filtered by the p_authorize_key column
 * @method     array findByPAuthorizeMid(string $p_authorize_mid) Return ChildPluginInvoiceConfig objects filtered by the p_authorize_mid column
 * @method     array findByPAuthorizeHash(string $p_authorize_hash) Return ChildPluginInvoiceConfig objects filtered by the p_authorize_hash column
 * @method     array findByPBankAccount(string $p_bank_account) Return ChildPluginInvoiceConfig objects filtered by the p_bank_account column
 * @method     array findBySiInclude(boolean $si_include) Return ChildPluginInvoiceConfig objects filtered by the si_include column
 * @method     array findBySiShippingAddress(boolean $si_shipping_address) Return ChildPluginInvoiceConfig objects filtered by the si_shipping_address column
 * @method     array findBySiCompany(boolean $si_company) Return ChildPluginInvoiceConfig objects filtered by the si_company column
 * @method     array findBySiName(boolean $si_name) Return ChildPluginInvoiceConfig objects filtered by the si_name column
 * @method     array findBySiAddress(boolean $si_address) Return ChildPluginInvoiceConfig objects filtered by the si_address column
 * @method     array findBySiStreetAddress(boolean $si_street_address) Return ChildPluginInvoiceConfig objects filtered by the si_street_address column
 * @method     array findBySiCity(boolean $si_city) Return ChildPluginInvoiceConfig objects filtered by the si_city column
 * @method     array findBySiState(boolean $si_state) Return ChildPluginInvoiceConfig objects filtered by the si_state column
 * @method     array findBySiZip(boolean $si_zip) Return ChildPluginInvoiceConfig objects filtered by the si_zip column
 * @method     array findBySiPhone(boolean $si_phone) Return ChildPluginInvoiceConfig objects filtered by the si_phone column
 * @method     array findBySiFax(boolean $si_fax) Return ChildPluginInvoiceConfig objects filtered by the si_fax column
 * @method     array findBySiEmail(boolean $si_email) Return ChildPluginInvoiceConfig objects filtered by the si_email column
 * @method     array findBySiUrl(boolean $si_url) Return ChildPluginInvoiceConfig objects filtered by the si_url column
 * @method     array findBySiDate(boolean $si_date) Return ChildPluginInvoiceConfig objects filtered by the si_date column
 * @method     array findBySiTerms(boolean $si_terms) Return ChildPluginInvoiceConfig objects filtered by the si_terms column
 * @method     array findBySiIsShipped(boolean $si_is_shipped) Return ChildPluginInvoiceConfig objects filtered by the si_is_shipped column
 * @method     array findBySiShipping(boolean $si_shipping) Return ChildPluginInvoiceConfig objects filtered by the si_shipping column
 * @method     array findByOBookingUrl(string $o_booking_url) Return ChildPluginInvoiceConfig objects filtered by the o_booking_url column
 * @method     array findByOQtyIsInt(boolean $o_qty_is_int) Return ChildPluginInvoiceConfig objects filtered by the o_qty_is_int column
 * @method     array findByOUseQtyUnitPrice(boolean $o_use_qty_unit_price) Return ChildPluginInvoiceConfig objects filtered by the o_use_qty_unit_price column
 *
 */
abstract class PluginInvoiceConfigQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \HookCalendar\Model\Base\PluginInvoiceConfigQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'thelia', $modelName = '\\HookCalendar\\Model\\PluginInvoiceConfig', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildPluginInvoiceConfigQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildPluginInvoiceConfigQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \HookCalendar\Model\PluginInvoiceConfigQuery) {
            return $criteria;
        }
        $query = new \HookCalendar\Model\PluginInvoiceConfigQuery();
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
     * @return ChildPluginInvoiceConfig|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = PluginInvoiceConfigTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(PluginInvoiceConfigTableMap::DATABASE_NAME);
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
     * @return   ChildPluginInvoiceConfig A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ID, Y_LOGO, Y_COMPANY, Y_NAME, Y_STREET_ADDRESS, Y_COUNTRY, Y_CITY, Y_STATE, Y_ZIP, Y_PHONE, Y_FAX, Y_EMAIL, Y_URL, Y_TEMPLATE, P_ACCEPT_PAYMENTS, P_ACCEPT_PAYPAL, P_ACCEPT_AUTHORIZE, P_ACCEPT_CREDITCARD, P_ACCEPT_CASH, P_ACCEPT_BANK, P_PAYPAL_ADDRESS, P_AUTHORIZE_TZ, P_AUTHORIZE_KEY, P_AUTHORIZE_MID, P_AUTHORIZE_HASH, P_BANK_ACCOUNT, SI_INCLUDE, SI_SHIPPING_ADDRESS, SI_COMPANY, SI_NAME, SI_ADDRESS, SI_STREET_ADDRESS, SI_CITY, SI_STATE, SI_ZIP, SI_PHONE, SI_FAX, SI_EMAIL, SI_URL, SI_DATE, SI_TERMS, SI_IS_SHIPPED, SI_SHIPPING, O_BOOKING_URL, O_QTY_IS_INT, O_USE_QTY_UNIT_PRICE FROM plugin_invoice_config WHERE ID = :p0';
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
            $obj = new ChildPluginInvoiceConfig();
            $obj->hydrate($row);
            PluginInvoiceConfigTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildPluginInvoiceConfig|array|mixed the result, formatted by the current formatter
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
     * @return ChildPluginInvoiceConfigQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(PluginInvoiceConfigTableMap::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildPluginInvoiceConfigQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(PluginInvoiceConfigTableMap::ID, $keys, Criteria::IN);
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
     * @return ChildPluginInvoiceConfigQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(PluginInvoiceConfigTableMap::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(PluginInvoiceConfigTableMap::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PluginInvoiceConfigTableMap::ID, $id, $comparison);
    }

    /**
     * Filter the query on the y_logo column
     *
     * Example usage:
     * <code>
     * $query->filterByYLogo('fooValue');   // WHERE y_logo = 'fooValue'
     * $query->filterByYLogo('%fooValue%'); // WHERE y_logo LIKE '%fooValue%'
     * </code>
     *
     * @param     string $yLogo The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceConfigQuery The current query, for fluid interface
     */
    public function filterByYLogo($yLogo = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($yLogo)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $yLogo)) {
                $yLogo = str_replace('*', '%', $yLogo);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PluginInvoiceConfigTableMap::Y_LOGO, $yLogo, $comparison);
    }

    /**
     * Filter the query on the y_company column
     *
     * Example usage:
     * <code>
     * $query->filterByYCompany('fooValue');   // WHERE y_company = 'fooValue'
     * $query->filterByYCompany('%fooValue%'); // WHERE y_company LIKE '%fooValue%'
     * </code>
     *
     * @param     string $yCompany The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceConfigQuery The current query, for fluid interface
     */
    public function filterByYCompany($yCompany = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($yCompany)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $yCompany)) {
                $yCompany = str_replace('*', '%', $yCompany);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PluginInvoiceConfigTableMap::Y_COMPANY, $yCompany, $comparison);
    }

    /**
     * Filter the query on the y_name column
     *
     * Example usage:
     * <code>
     * $query->filterByYName('fooValue');   // WHERE y_name = 'fooValue'
     * $query->filterByYName('%fooValue%'); // WHERE y_name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $yName The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceConfigQuery The current query, for fluid interface
     */
    public function filterByYName($yName = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($yName)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $yName)) {
                $yName = str_replace('*', '%', $yName);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PluginInvoiceConfigTableMap::Y_NAME, $yName, $comparison);
    }

    /**
     * Filter the query on the y_street_address column
     *
     * Example usage:
     * <code>
     * $query->filterByYStreetAddress('fooValue');   // WHERE y_street_address = 'fooValue'
     * $query->filterByYStreetAddress('%fooValue%'); // WHERE y_street_address LIKE '%fooValue%'
     * </code>
     *
     * @param     string $yStreetAddress The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceConfigQuery The current query, for fluid interface
     */
    public function filterByYStreetAddress($yStreetAddress = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($yStreetAddress)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $yStreetAddress)) {
                $yStreetAddress = str_replace('*', '%', $yStreetAddress);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PluginInvoiceConfigTableMap::Y_STREET_ADDRESS, $yStreetAddress, $comparison);
    }

    /**
     * Filter the query on the y_country column
     *
     * Example usage:
     * <code>
     * $query->filterByYCountry(1234); // WHERE y_country = 1234
     * $query->filterByYCountry(array(12, 34)); // WHERE y_country IN (12, 34)
     * $query->filterByYCountry(array('min' => 12)); // WHERE y_country > 12
     * </code>
     *
     * @param     mixed $yCountry The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceConfigQuery The current query, for fluid interface
     */
    public function filterByYCountry($yCountry = null, $comparison = null)
    {
        if (is_array($yCountry)) {
            $useMinMax = false;
            if (isset($yCountry['min'])) {
                $this->addUsingAlias(PluginInvoiceConfigTableMap::Y_COUNTRY, $yCountry['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($yCountry['max'])) {
                $this->addUsingAlias(PluginInvoiceConfigTableMap::Y_COUNTRY, $yCountry['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PluginInvoiceConfigTableMap::Y_COUNTRY, $yCountry, $comparison);
    }

    /**
     * Filter the query on the y_city column
     *
     * Example usage:
     * <code>
     * $query->filterByYCity('fooValue');   // WHERE y_city = 'fooValue'
     * $query->filterByYCity('%fooValue%'); // WHERE y_city LIKE '%fooValue%'
     * </code>
     *
     * @param     string $yCity The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceConfigQuery The current query, for fluid interface
     */
    public function filterByYCity($yCity = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($yCity)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $yCity)) {
                $yCity = str_replace('*', '%', $yCity);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PluginInvoiceConfigTableMap::Y_CITY, $yCity, $comparison);
    }

    /**
     * Filter the query on the y_state column
     *
     * Example usage:
     * <code>
     * $query->filterByYState('fooValue');   // WHERE y_state = 'fooValue'
     * $query->filterByYState('%fooValue%'); // WHERE y_state LIKE '%fooValue%'
     * </code>
     *
     * @param     string $yState The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceConfigQuery The current query, for fluid interface
     */
    public function filterByYState($yState = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($yState)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $yState)) {
                $yState = str_replace('*', '%', $yState);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PluginInvoiceConfigTableMap::Y_STATE, $yState, $comparison);
    }

    /**
     * Filter the query on the y_zip column
     *
     * Example usage:
     * <code>
     * $query->filterByYZip('fooValue');   // WHERE y_zip = 'fooValue'
     * $query->filterByYZip('%fooValue%'); // WHERE y_zip LIKE '%fooValue%'
     * </code>
     *
     * @param     string $yZip The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceConfigQuery The current query, for fluid interface
     */
    public function filterByYZip($yZip = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($yZip)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $yZip)) {
                $yZip = str_replace('*', '%', $yZip);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PluginInvoiceConfigTableMap::Y_ZIP, $yZip, $comparison);
    }

    /**
     * Filter the query on the y_phone column
     *
     * Example usage:
     * <code>
     * $query->filterByYPhone('fooValue');   // WHERE y_phone = 'fooValue'
     * $query->filterByYPhone('%fooValue%'); // WHERE y_phone LIKE '%fooValue%'
     * </code>
     *
     * @param     string $yPhone The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceConfigQuery The current query, for fluid interface
     */
    public function filterByYPhone($yPhone = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($yPhone)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $yPhone)) {
                $yPhone = str_replace('*', '%', $yPhone);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PluginInvoiceConfigTableMap::Y_PHONE, $yPhone, $comparison);
    }

    /**
     * Filter the query on the y_fax column
     *
     * Example usage:
     * <code>
     * $query->filterByYFax('fooValue');   // WHERE y_fax = 'fooValue'
     * $query->filterByYFax('%fooValue%'); // WHERE y_fax LIKE '%fooValue%'
     * </code>
     *
     * @param     string $yFax The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceConfigQuery The current query, for fluid interface
     */
    public function filterByYFax($yFax = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($yFax)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $yFax)) {
                $yFax = str_replace('*', '%', $yFax);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PluginInvoiceConfigTableMap::Y_FAX, $yFax, $comparison);
    }

    /**
     * Filter the query on the y_email column
     *
     * Example usage:
     * <code>
     * $query->filterByYEmail('fooValue');   // WHERE y_email = 'fooValue'
     * $query->filterByYEmail('%fooValue%'); // WHERE y_email LIKE '%fooValue%'
     * </code>
     *
     * @param     string $yEmail The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceConfigQuery The current query, for fluid interface
     */
    public function filterByYEmail($yEmail = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($yEmail)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $yEmail)) {
                $yEmail = str_replace('*', '%', $yEmail);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PluginInvoiceConfigTableMap::Y_EMAIL, $yEmail, $comparison);
    }

    /**
     * Filter the query on the y_url column
     *
     * Example usage:
     * <code>
     * $query->filterByYUrl('fooValue');   // WHERE y_url = 'fooValue'
     * $query->filterByYUrl('%fooValue%'); // WHERE y_url LIKE '%fooValue%'
     * </code>
     *
     * @param     string $yUrl The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceConfigQuery The current query, for fluid interface
     */
    public function filterByYUrl($yUrl = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($yUrl)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $yUrl)) {
                $yUrl = str_replace('*', '%', $yUrl);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PluginInvoiceConfigTableMap::Y_URL, $yUrl, $comparison);
    }

    /**
     * Filter the query on the y_template column
     *
     * Example usage:
     * <code>
     * $query->filterByYTemplate('fooValue');   // WHERE y_template = 'fooValue'
     * $query->filterByYTemplate('%fooValue%'); // WHERE y_template LIKE '%fooValue%'
     * </code>
     *
     * @param     string $yTemplate The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceConfigQuery The current query, for fluid interface
     */
    public function filterByYTemplate($yTemplate = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($yTemplate)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $yTemplate)) {
                $yTemplate = str_replace('*', '%', $yTemplate);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PluginInvoiceConfigTableMap::Y_TEMPLATE, $yTemplate, $comparison);
    }

    /**
     * Filter the query on the p_accept_payments column
     *
     * Example usage:
     * <code>
     * $query->filterByPAcceptPayments(true); // WHERE p_accept_payments = true
     * $query->filterByPAcceptPayments('yes'); // WHERE p_accept_payments = true
     * </code>
     *
     * @param     boolean|string $pAcceptPayments The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceConfigQuery The current query, for fluid interface
     */
    public function filterByPAcceptPayments($pAcceptPayments = null, $comparison = null)
    {
        if (is_string($pAcceptPayments)) {
            $p_accept_payments = in_array(strtolower($pAcceptPayments), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(PluginInvoiceConfigTableMap::P_ACCEPT_PAYMENTS, $pAcceptPayments, $comparison);
    }

    /**
     * Filter the query on the p_accept_paypal column
     *
     * Example usage:
     * <code>
     * $query->filterByPAcceptPaypal(true); // WHERE p_accept_paypal = true
     * $query->filterByPAcceptPaypal('yes'); // WHERE p_accept_paypal = true
     * </code>
     *
     * @param     boolean|string $pAcceptPaypal The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceConfigQuery The current query, for fluid interface
     */
    public function filterByPAcceptPaypal($pAcceptPaypal = null, $comparison = null)
    {
        if (is_string($pAcceptPaypal)) {
            $p_accept_paypal = in_array(strtolower($pAcceptPaypal), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(PluginInvoiceConfigTableMap::P_ACCEPT_PAYPAL, $pAcceptPaypal, $comparison);
    }

    /**
     * Filter the query on the p_accept_authorize column
     *
     * Example usage:
     * <code>
     * $query->filterByPAcceptAuthorize(true); // WHERE p_accept_authorize = true
     * $query->filterByPAcceptAuthorize('yes'); // WHERE p_accept_authorize = true
     * </code>
     *
     * @param     boolean|string $pAcceptAuthorize The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceConfigQuery The current query, for fluid interface
     */
    public function filterByPAcceptAuthorize($pAcceptAuthorize = null, $comparison = null)
    {
        if (is_string($pAcceptAuthorize)) {
            $p_accept_authorize = in_array(strtolower($pAcceptAuthorize), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(PluginInvoiceConfigTableMap::P_ACCEPT_AUTHORIZE, $pAcceptAuthorize, $comparison);
    }

    /**
     * Filter the query on the p_accept_creditcard column
     *
     * Example usage:
     * <code>
     * $query->filterByPAcceptCreditcard(true); // WHERE p_accept_creditcard = true
     * $query->filterByPAcceptCreditcard('yes'); // WHERE p_accept_creditcard = true
     * </code>
     *
     * @param     boolean|string $pAcceptCreditcard The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceConfigQuery The current query, for fluid interface
     */
    public function filterByPAcceptCreditcard($pAcceptCreditcard = null, $comparison = null)
    {
        if (is_string($pAcceptCreditcard)) {
            $p_accept_creditcard = in_array(strtolower($pAcceptCreditcard), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(PluginInvoiceConfigTableMap::P_ACCEPT_CREDITCARD, $pAcceptCreditcard, $comparison);
    }

    /**
     * Filter the query on the p_accept_cash column
     *
     * Example usage:
     * <code>
     * $query->filterByPAcceptCash(true); // WHERE p_accept_cash = true
     * $query->filterByPAcceptCash('yes'); // WHERE p_accept_cash = true
     * </code>
     *
     * @param     boolean|string $pAcceptCash The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceConfigQuery The current query, for fluid interface
     */
    public function filterByPAcceptCash($pAcceptCash = null, $comparison = null)
    {
        if (is_string($pAcceptCash)) {
            $p_accept_cash = in_array(strtolower($pAcceptCash), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(PluginInvoiceConfigTableMap::P_ACCEPT_CASH, $pAcceptCash, $comparison);
    }

    /**
     * Filter the query on the p_accept_bank column
     *
     * Example usage:
     * <code>
     * $query->filterByPAcceptBank(true); // WHERE p_accept_bank = true
     * $query->filterByPAcceptBank('yes'); // WHERE p_accept_bank = true
     * </code>
     *
     * @param     boolean|string $pAcceptBank The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceConfigQuery The current query, for fluid interface
     */
    public function filterByPAcceptBank($pAcceptBank = null, $comparison = null)
    {
        if (is_string($pAcceptBank)) {
            $p_accept_bank = in_array(strtolower($pAcceptBank), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(PluginInvoiceConfigTableMap::P_ACCEPT_BANK, $pAcceptBank, $comparison);
    }

    /**
     * Filter the query on the p_paypal_address column
     *
     * Example usage:
     * <code>
     * $query->filterByPPaypalAddress('fooValue');   // WHERE p_paypal_address = 'fooValue'
     * $query->filterByPPaypalAddress('%fooValue%'); // WHERE p_paypal_address LIKE '%fooValue%'
     * </code>
     *
     * @param     string $pPaypalAddress The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceConfigQuery The current query, for fluid interface
     */
    public function filterByPPaypalAddress($pPaypalAddress = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($pPaypalAddress)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $pPaypalAddress)) {
                $pPaypalAddress = str_replace('*', '%', $pPaypalAddress);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PluginInvoiceConfigTableMap::P_PAYPAL_ADDRESS, $pPaypalAddress, $comparison);
    }

    /**
     * Filter the query on the p_authorize_tz column
     *
     * Example usage:
     * <code>
     * $query->filterByPAuthorizeTz('fooValue');   // WHERE p_authorize_tz = 'fooValue'
     * $query->filterByPAuthorizeTz('%fooValue%'); // WHERE p_authorize_tz LIKE '%fooValue%'
     * </code>
     *
     * @param     string $pAuthorizeTz The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceConfigQuery The current query, for fluid interface
     */
    public function filterByPAuthorizeTz($pAuthorizeTz = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($pAuthorizeTz)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $pAuthorizeTz)) {
                $pAuthorizeTz = str_replace('*', '%', $pAuthorizeTz);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PluginInvoiceConfigTableMap::P_AUTHORIZE_TZ, $pAuthorizeTz, $comparison);
    }

    /**
     * Filter the query on the p_authorize_key column
     *
     * Example usage:
     * <code>
     * $query->filterByPAuthorizeKey('fooValue');   // WHERE p_authorize_key = 'fooValue'
     * $query->filterByPAuthorizeKey('%fooValue%'); // WHERE p_authorize_key LIKE '%fooValue%'
     * </code>
     *
     * @param     string $pAuthorizeKey The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceConfigQuery The current query, for fluid interface
     */
    public function filterByPAuthorizeKey($pAuthorizeKey = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($pAuthorizeKey)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $pAuthorizeKey)) {
                $pAuthorizeKey = str_replace('*', '%', $pAuthorizeKey);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PluginInvoiceConfigTableMap::P_AUTHORIZE_KEY, $pAuthorizeKey, $comparison);
    }

    /**
     * Filter the query on the p_authorize_mid column
     *
     * Example usage:
     * <code>
     * $query->filterByPAuthorizeMid('fooValue');   // WHERE p_authorize_mid = 'fooValue'
     * $query->filterByPAuthorizeMid('%fooValue%'); // WHERE p_authorize_mid LIKE '%fooValue%'
     * </code>
     *
     * @param     string $pAuthorizeMid The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceConfigQuery The current query, for fluid interface
     */
    public function filterByPAuthorizeMid($pAuthorizeMid = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($pAuthorizeMid)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $pAuthorizeMid)) {
                $pAuthorizeMid = str_replace('*', '%', $pAuthorizeMid);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PluginInvoiceConfigTableMap::P_AUTHORIZE_MID, $pAuthorizeMid, $comparison);
    }

    /**
     * Filter the query on the p_authorize_hash column
     *
     * Example usage:
     * <code>
     * $query->filterByPAuthorizeHash('fooValue');   // WHERE p_authorize_hash = 'fooValue'
     * $query->filterByPAuthorizeHash('%fooValue%'); // WHERE p_authorize_hash LIKE '%fooValue%'
     * </code>
     *
     * @param     string $pAuthorizeHash The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceConfigQuery The current query, for fluid interface
     */
    public function filterByPAuthorizeHash($pAuthorizeHash = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($pAuthorizeHash)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $pAuthorizeHash)) {
                $pAuthorizeHash = str_replace('*', '%', $pAuthorizeHash);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PluginInvoiceConfigTableMap::P_AUTHORIZE_HASH, $pAuthorizeHash, $comparison);
    }

    /**
     * Filter the query on the p_bank_account column
     *
     * Example usage:
     * <code>
     * $query->filterByPBankAccount('fooValue');   // WHERE p_bank_account = 'fooValue'
     * $query->filterByPBankAccount('%fooValue%'); // WHERE p_bank_account LIKE '%fooValue%'
     * </code>
     *
     * @param     string $pBankAccount The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceConfigQuery The current query, for fluid interface
     */
    public function filterByPBankAccount($pBankAccount = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($pBankAccount)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $pBankAccount)) {
                $pBankAccount = str_replace('*', '%', $pBankAccount);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PluginInvoiceConfigTableMap::P_BANK_ACCOUNT, $pBankAccount, $comparison);
    }

    /**
     * Filter the query on the si_include column
     *
     * Example usage:
     * <code>
     * $query->filterBySiInclude(true); // WHERE si_include = true
     * $query->filterBySiInclude('yes'); // WHERE si_include = true
     * </code>
     *
     * @param     boolean|string $siInclude The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceConfigQuery The current query, for fluid interface
     */
    public function filterBySiInclude($siInclude = null, $comparison = null)
    {
        if (is_string($siInclude)) {
            $si_include = in_array(strtolower($siInclude), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(PluginInvoiceConfigTableMap::SI_INCLUDE, $siInclude, $comparison);
    }

    /**
     * Filter the query on the si_shipping_address column
     *
     * Example usage:
     * <code>
     * $query->filterBySiShippingAddress(true); // WHERE si_shipping_address = true
     * $query->filterBySiShippingAddress('yes'); // WHERE si_shipping_address = true
     * </code>
     *
     * @param     boolean|string $siShippingAddress The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceConfigQuery The current query, for fluid interface
     */
    public function filterBySiShippingAddress($siShippingAddress = null, $comparison = null)
    {
        if (is_string($siShippingAddress)) {
            $si_shipping_address = in_array(strtolower($siShippingAddress), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(PluginInvoiceConfigTableMap::SI_SHIPPING_ADDRESS, $siShippingAddress, $comparison);
    }

    /**
     * Filter the query on the si_company column
     *
     * Example usage:
     * <code>
     * $query->filterBySiCompany(true); // WHERE si_company = true
     * $query->filterBySiCompany('yes'); // WHERE si_company = true
     * </code>
     *
     * @param     boolean|string $siCompany The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceConfigQuery The current query, for fluid interface
     */
    public function filterBySiCompany($siCompany = null, $comparison = null)
    {
        if (is_string($siCompany)) {
            $si_company = in_array(strtolower($siCompany), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(PluginInvoiceConfigTableMap::SI_COMPANY, $siCompany, $comparison);
    }

    /**
     * Filter the query on the si_name column
     *
     * Example usage:
     * <code>
     * $query->filterBySiName(true); // WHERE si_name = true
     * $query->filterBySiName('yes'); // WHERE si_name = true
     * </code>
     *
     * @param     boolean|string $siName The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceConfigQuery The current query, for fluid interface
     */
    public function filterBySiName($siName = null, $comparison = null)
    {
        if (is_string($siName)) {
            $si_name = in_array(strtolower($siName), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(PluginInvoiceConfigTableMap::SI_NAME, $siName, $comparison);
    }

    /**
     * Filter the query on the si_address column
     *
     * Example usage:
     * <code>
     * $query->filterBySiAddress(true); // WHERE si_address = true
     * $query->filterBySiAddress('yes'); // WHERE si_address = true
     * </code>
     *
     * @param     boolean|string $siAddress The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceConfigQuery The current query, for fluid interface
     */
    public function filterBySiAddress($siAddress = null, $comparison = null)
    {
        if (is_string($siAddress)) {
            $si_address = in_array(strtolower($siAddress), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(PluginInvoiceConfigTableMap::SI_ADDRESS, $siAddress, $comparison);
    }

    /**
     * Filter the query on the si_street_address column
     *
     * Example usage:
     * <code>
     * $query->filterBySiStreetAddress(true); // WHERE si_street_address = true
     * $query->filterBySiStreetAddress('yes'); // WHERE si_street_address = true
     * </code>
     *
     * @param     boolean|string $siStreetAddress The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceConfigQuery The current query, for fluid interface
     */
    public function filterBySiStreetAddress($siStreetAddress = null, $comparison = null)
    {
        if (is_string($siStreetAddress)) {
            $si_street_address = in_array(strtolower($siStreetAddress), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(PluginInvoiceConfigTableMap::SI_STREET_ADDRESS, $siStreetAddress, $comparison);
    }

    /**
     * Filter the query on the si_city column
     *
     * Example usage:
     * <code>
     * $query->filterBySiCity(true); // WHERE si_city = true
     * $query->filterBySiCity('yes'); // WHERE si_city = true
     * </code>
     *
     * @param     boolean|string $siCity The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceConfigQuery The current query, for fluid interface
     */
    public function filterBySiCity($siCity = null, $comparison = null)
    {
        if (is_string($siCity)) {
            $si_city = in_array(strtolower($siCity), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(PluginInvoiceConfigTableMap::SI_CITY, $siCity, $comparison);
    }

    /**
     * Filter the query on the si_state column
     *
     * Example usage:
     * <code>
     * $query->filterBySiState(true); // WHERE si_state = true
     * $query->filterBySiState('yes'); // WHERE si_state = true
     * </code>
     *
     * @param     boolean|string $siState The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceConfigQuery The current query, for fluid interface
     */
    public function filterBySiState($siState = null, $comparison = null)
    {
        if (is_string($siState)) {
            $si_state = in_array(strtolower($siState), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(PluginInvoiceConfigTableMap::SI_STATE, $siState, $comparison);
    }

    /**
     * Filter the query on the si_zip column
     *
     * Example usage:
     * <code>
     * $query->filterBySiZip(true); // WHERE si_zip = true
     * $query->filterBySiZip('yes'); // WHERE si_zip = true
     * </code>
     *
     * @param     boolean|string $siZip The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceConfigQuery The current query, for fluid interface
     */
    public function filterBySiZip($siZip = null, $comparison = null)
    {
        if (is_string($siZip)) {
            $si_zip = in_array(strtolower($siZip), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(PluginInvoiceConfigTableMap::SI_ZIP, $siZip, $comparison);
    }

    /**
     * Filter the query on the si_phone column
     *
     * Example usage:
     * <code>
     * $query->filterBySiPhone(true); // WHERE si_phone = true
     * $query->filterBySiPhone('yes'); // WHERE si_phone = true
     * </code>
     *
     * @param     boolean|string $siPhone The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceConfigQuery The current query, for fluid interface
     */
    public function filterBySiPhone($siPhone = null, $comparison = null)
    {
        if (is_string($siPhone)) {
            $si_phone = in_array(strtolower($siPhone), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(PluginInvoiceConfigTableMap::SI_PHONE, $siPhone, $comparison);
    }

    /**
     * Filter the query on the si_fax column
     *
     * Example usage:
     * <code>
     * $query->filterBySiFax(true); // WHERE si_fax = true
     * $query->filterBySiFax('yes'); // WHERE si_fax = true
     * </code>
     *
     * @param     boolean|string $siFax The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceConfigQuery The current query, for fluid interface
     */
    public function filterBySiFax($siFax = null, $comparison = null)
    {
        if (is_string($siFax)) {
            $si_fax = in_array(strtolower($siFax), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(PluginInvoiceConfigTableMap::SI_FAX, $siFax, $comparison);
    }

    /**
     * Filter the query on the si_email column
     *
     * Example usage:
     * <code>
     * $query->filterBySiEmail(true); // WHERE si_email = true
     * $query->filterBySiEmail('yes'); // WHERE si_email = true
     * </code>
     *
     * @param     boolean|string $siEmail The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceConfigQuery The current query, for fluid interface
     */
    public function filterBySiEmail($siEmail = null, $comparison = null)
    {
        if (is_string($siEmail)) {
            $si_email = in_array(strtolower($siEmail), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(PluginInvoiceConfigTableMap::SI_EMAIL, $siEmail, $comparison);
    }

    /**
     * Filter the query on the si_url column
     *
     * Example usage:
     * <code>
     * $query->filterBySiUrl(true); // WHERE si_url = true
     * $query->filterBySiUrl('yes'); // WHERE si_url = true
     * </code>
     *
     * @param     boolean|string $siUrl The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceConfigQuery The current query, for fluid interface
     */
    public function filterBySiUrl($siUrl = null, $comparison = null)
    {
        if (is_string($siUrl)) {
            $si_url = in_array(strtolower($siUrl), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(PluginInvoiceConfigTableMap::SI_URL, $siUrl, $comparison);
    }

    /**
     * Filter the query on the si_date column
     *
     * Example usage:
     * <code>
     * $query->filterBySiDate(true); // WHERE si_date = true
     * $query->filterBySiDate('yes'); // WHERE si_date = true
     * </code>
     *
     * @param     boolean|string $siDate The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceConfigQuery The current query, for fluid interface
     */
    public function filterBySiDate($siDate = null, $comparison = null)
    {
        if (is_string($siDate)) {
            $si_date = in_array(strtolower($siDate), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(PluginInvoiceConfigTableMap::SI_DATE, $siDate, $comparison);
    }

    /**
     * Filter the query on the si_terms column
     *
     * Example usage:
     * <code>
     * $query->filterBySiTerms(true); // WHERE si_terms = true
     * $query->filterBySiTerms('yes'); // WHERE si_terms = true
     * </code>
     *
     * @param     boolean|string $siTerms The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceConfigQuery The current query, for fluid interface
     */
    public function filterBySiTerms($siTerms = null, $comparison = null)
    {
        if (is_string($siTerms)) {
            $si_terms = in_array(strtolower($siTerms), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(PluginInvoiceConfigTableMap::SI_TERMS, $siTerms, $comparison);
    }

    /**
     * Filter the query on the si_is_shipped column
     *
     * Example usage:
     * <code>
     * $query->filterBySiIsShipped(true); // WHERE si_is_shipped = true
     * $query->filterBySiIsShipped('yes'); // WHERE si_is_shipped = true
     * </code>
     *
     * @param     boolean|string $siIsShipped The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceConfigQuery The current query, for fluid interface
     */
    public function filterBySiIsShipped($siIsShipped = null, $comparison = null)
    {
        if (is_string($siIsShipped)) {
            $si_is_shipped = in_array(strtolower($siIsShipped), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(PluginInvoiceConfigTableMap::SI_IS_SHIPPED, $siIsShipped, $comparison);
    }

    /**
     * Filter the query on the si_shipping column
     *
     * Example usage:
     * <code>
     * $query->filterBySiShipping(true); // WHERE si_shipping = true
     * $query->filterBySiShipping('yes'); // WHERE si_shipping = true
     * </code>
     *
     * @param     boolean|string $siShipping The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceConfigQuery The current query, for fluid interface
     */
    public function filterBySiShipping($siShipping = null, $comparison = null)
    {
        if (is_string($siShipping)) {
            $si_shipping = in_array(strtolower($siShipping), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(PluginInvoiceConfigTableMap::SI_SHIPPING, $siShipping, $comparison);
    }

    /**
     * Filter the query on the o_booking_url column
     *
     * Example usage:
     * <code>
     * $query->filterByOBookingUrl('fooValue');   // WHERE o_booking_url = 'fooValue'
     * $query->filterByOBookingUrl('%fooValue%'); // WHERE o_booking_url LIKE '%fooValue%'
     * </code>
     *
     * @param     string $oBookingUrl The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceConfigQuery The current query, for fluid interface
     */
    public function filterByOBookingUrl($oBookingUrl = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($oBookingUrl)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $oBookingUrl)) {
                $oBookingUrl = str_replace('*', '%', $oBookingUrl);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PluginInvoiceConfigTableMap::O_BOOKING_URL, $oBookingUrl, $comparison);
    }

    /**
     * Filter the query on the o_qty_is_int column
     *
     * Example usage:
     * <code>
     * $query->filterByOQtyIsInt(true); // WHERE o_qty_is_int = true
     * $query->filterByOQtyIsInt('yes'); // WHERE o_qty_is_int = true
     * </code>
     *
     * @param     boolean|string $oQtyIsInt The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceConfigQuery The current query, for fluid interface
     */
    public function filterByOQtyIsInt($oQtyIsInt = null, $comparison = null)
    {
        if (is_string($oQtyIsInt)) {
            $o_qty_is_int = in_array(strtolower($oQtyIsInt), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(PluginInvoiceConfigTableMap::O_QTY_IS_INT, $oQtyIsInt, $comparison);
    }

    /**
     * Filter the query on the o_use_qty_unit_price column
     *
     * Example usage:
     * <code>
     * $query->filterByOUseQtyUnitPrice(true); // WHERE o_use_qty_unit_price = true
     * $query->filterByOUseQtyUnitPrice('yes'); // WHERE o_use_qty_unit_price = true
     * </code>
     *
     * @param     boolean|string $oUseQtyUnitPrice The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceConfigQuery The current query, for fluid interface
     */
    public function filterByOUseQtyUnitPrice($oUseQtyUnitPrice = null, $comparison = null)
    {
        if (is_string($oUseQtyUnitPrice)) {
            $o_use_qty_unit_price = in_array(strtolower($oUseQtyUnitPrice), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(PluginInvoiceConfigTableMap::O_USE_QTY_UNIT_PRICE, $oUseQtyUnitPrice, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildPluginInvoiceConfig $pluginInvoiceConfig Object to remove from the list of results
     *
     * @return ChildPluginInvoiceConfigQuery The current query, for fluid interface
     */
    public function prune($pluginInvoiceConfig = null)
    {
        if ($pluginInvoiceConfig) {
            $this->addUsingAlias(PluginInvoiceConfigTableMap::ID, $pluginInvoiceConfig->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the plugin_invoice_config table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PluginInvoiceConfigTableMap::DATABASE_NAME);
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
            PluginInvoiceConfigTableMap::clearInstancePool();
            PluginInvoiceConfigTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildPluginInvoiceConfig or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildPluginInvoiceConfig object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(PluginInvoiceConfigTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(PluginInvoiceConfigTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();


        PluginInvoiceConfigTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            PluginInvoiceConfigTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

} // PluginInvoiceConfigQuery
