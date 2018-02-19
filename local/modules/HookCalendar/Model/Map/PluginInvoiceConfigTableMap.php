<?php

namespace HookCalendar\Model\Map;

use HookCalendar\Model\PluginInvoiceConfig;
use HookCalendar\Model\PluginInvoiceConfigQuery;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;


/**
 * This class defines the structure of the 'plugin_invoice_config' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class PluginInvoiceConfigTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;
    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'HookCalendar.Model.Map.PluginInvoiceConfigTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'thelia';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'plugin_invoice_config';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\HookCalendar\\Model\\PluginInvoiceConfig';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'HookCalendar.Model.PluginInvoiceConfig';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 46;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 46;

    /**
     * the column name for the ID field
     */
    const ID = 'plugin_invoice_config.ID';

    /**
     * the column name for the Y_LOGO field
     */
    const Y_LOGO = 'plugin_invoice_config.Y_LOGO';

    /**
     * the column name for the Y_COMPANY field
     */
    const Y_COMPANY = 'plugin_invoice_config.Y_COMPANY';

    /**
     * the column name for the Y_NAME field
     */
    const Y_NAME = 'plugin_invoice_config.Y_NAME';

    /**
     * the column name for the Y_STREET_ADDRESS field
     */
    const Y_STREET_ADDRESS = 'plugin_invoice_config.Y_STREET_ADDRESS';

    /**
     * the column name for the Y_COUNTRY field
     */
    const Y_COUNTRY = 'plugin_invoice_config.Y_COUNTRY';

    /**
     * the column name for the Y_CITY field
     */
    const Y_CITY = 'plugin_invoice_config.Y_CITY';

    /**
     * the column name for the Y_STATE field
     */
    const Y_STATE = 'plugin_invoice_config.Y_STATE';

    /**
     * the column name for the Y_ZIP field
     */
    const Y_ZIP = 'plugin_invoice_config.Y_ZIP';

    /**
     * the column name for the Y_PHONE field
     */
    const Y_PHONE = 'plugin_invoice_config.Y_PHONE';

    /**
     * the column name for the Y_FAX field
     */
    const Y_FAX = 'plugin_invoice_config.Y_FAX';

    /**
     * the column name for the Y_EMAIL field
     */
    const Y_EMAIL = 'plugin_invoice_config.Y_EMAIL';

    /**
     * the column name for the Y_URL field
     */
    const Y_URL = 'plugin_invoice_config.Y_URL';

    /**
     * the column name for the Y_TEMPLATE field
     */
    const Y_TEMPLATE = 'plugin_invoice_config.Y_TEMPLATE';

    /**
     * the column name for the P_ACCEPT_PAYMENTS field
     */
    const P_ACCEPT_PAYMENTS = 'plugin_invoice_config.P_ACCEPT_PAYMENTS';

    /**
     * the column name for the P_ACCEPT_PAYPAL field
     */
    const P_ACCEPT_PAYPAL = 'plugin_invoice_config.P_ACCEPT_PAYPAL';

    /**
     * the column name for the P_ACCEPT_AUTHORIZE field
     */
    const P_ACCEPT_AUTHORIZE = 'plugin_invoice_config.P_ACCEPT_AUTHORIZE';

    /**
     * the column name for the P_ACCEPT_CREDITCARD field
     */
    const P_ACCEPT_CREDITCARD = 'plugin_invoice_config.P_ACCEPT_CREDITCARD';

    /**
     * the column name for the P_ACCEPT_CASH field
     */
    const P_ACCEPT_CASH = 'plugin_invoice_config.P_ACCEPT_CASH';

    /**
     * the column name for the P_ACCEPT_BANK field
     */
    const P_ACCEPT_BANK = 'plugin_invoice_config.P_ACCEPT_BANK';

    /**
     * the column name for the P_PAYPAL_ADDRESS field
     */
    const P_PAYPAL_ADDRESS = 'plugin_invoice_config.P_PAYPAL_ADDRESS';

    /**
     * the column name for the P_AUTHORIZE_TZ field
     */
    const P_AUTHORIZE_TZ = 'plugin_invoice_config.P_AUTHORIZE_TZ';

    /**
     * the column name for the P_AUTHORIZE_KEY field
     */
    const P_AUTHORIZE_KEY = 'plugin_invoice_config.P_AUTHORIZE_KEY';

    /**
     * the column name for the P_AUTHORIZE_MID field
     */
    const P_AUTHORIZE_MID = 'plugin_invoice_config.P_AUTHORIZE_MID';

    /**
     * the column name for the P_AUTHORIZE_HASH field
     */
    const P_AUTHORIZE_HASH = 'plugin_invoice_config.P_AUTHORIZE_HASH';

    /**
     * the column name for the P_BANK_ACCOUNT field
     */
    const P_BANK_ACCOUNT = 'plugin_invoice_config.P_BANK_ACCOUNT';

    /**
     * the column name for the SI_INCLUDE field
     */
    const SI_INCLUDE = 'plugin_invoice_config.SI_INCLUDE';

    /**
     * the column name for the SI_SHIPPING_ADDRESS field
     */
    const SI_SHIPPING_ADDRESS = 'plugin_invoice_config.SI_SHIPPING_ADDRESS';

    /**
     * the column name for the SI_COMPANY field
     */
    const SI_COMPANY = 'plugin_invoice_config.SI_COMPANY';

    /**
     * the column name for the SI_NAME field
     */
    const SI_NAME = 'plugin_invoice_config.SI_NAME';

    /**
     * the column name for the SI_ADDRESS field
     */
    const SI_ADDRESS = 'plugin_invoice_config.SI_ADDRESS';

    /**
     * the column name for the SI_STREET_ADDRESS field
     */
    const SI_STREET_ADDRESS = 'plugin_invoice_config.SI_STREET_ADDRESS';

    /**
     * the column name for the SI_CITY field
     */
    const SI_CITY = 'plugin_invoice_config.SI_CITY';

    /**
     * the column name for the SI_STATE field
     */
    const SI_STATE = 'plugin_invoice_config.SI_STATE';

    /**
     * the column name for the SI_ZIP field
     */
    const SI_ZIP = 'plugin_invoice_config.SI_ZIP';

    /**
     * the column name for the SI_PHONE field
     */
    const SI_PHONE = 'plugin_invoice_config.SI_PHONE';

    /**
     * the column name for the SI_FAX field
     */
    const SI_FAX = 'plugin_invoice_config.SI_FAX';

    /**
     * the column name for the SI_EMAIL field
     */
    const SI_EMAIL = 'plugin_invoice_config.SI_EMAIL';

    /**
     * the column name for the SI_URL field
     */
    const SI_URL = 'plugin_invoice_config.SI_URL';

    /**
     * the column name for the SI_DATE field
     */
    const SI_DATE = 'plugin_invoice_config.SI_DATE';

    /**
     * the column name for the SI_TERMS field
     */
    const SI_TERMS = 'plugin_invoice_config.SI_TERMS';

    /**
     * the column name for the SI_IS_SHIPPED field
     */
    const SI_IS_SHIPPED = 'plugin_invoice_config.SI_IS_SHIPPED';

    /**
     * the column name for the SI_SHIPPING field
     */
    const SI_SHIPPING = 'plugin_invoice_config.SI_SHIPPING';

    /**
     * the column name for the O_BOOKING_URL field
     */
    const O_BOOKING_URL = 'plugin_invoice_config.O_BOOKING_URL';

    /**
     * the column name for the O_QTY_IS_INT field
     */
    const O_QTY_IS_INT = 'plugin_invoice_config.O_QTY_IS_INT';

    /**
     * the column name for the O_USE_QTY_UNIT_PRICE field
     */
    const O_USE_QTY_UNIT_PRICE = 'plugin_invoice_config.O_USE_QTY_UNIT_PRICE';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('Id', 'YLogo', 'YCompany', 'YName', 'YStreetAddress', 'YCountry', 'YCity', 'YState', 'YZip', 'YPhone', 'YFax', 'YEmail', 'YUrl', 'YTemplate', 'PAcceptPayments', 'PAcceptPaypal', 'PAcceptAuthorize', 'PAcceptCreditcard', 'PAcceptCash', 'PAcceptBank', 'PPaypalAddress', 'PAuthorizeTz', 'PAuthorizeKey', 'PAuthorizeMid', 'PAuthorizeHash', 'PBankAccount', 'SiInclude', 'SiShippingAddress', 'SiCompany', 'SiName', 'SiAddress', 'SiStreetAddress', 'SiCity', 'SiState', 'SiZip', 'SiPhone', 'SiFax', 'SiEmail', 'SiUrl', 'SiDate', 'SiTerms', 'SiIsShipped', 'SiShipping', 'OBookingUrl', 'OQtyIsInt', 'OUseQtyUnitPrice', ),
        self::TYPE_STUDLYPHPNAME => array('id', 'yLogo', 'yCompany', 'yName', 'yStreetAddress', 'yCountry', 'yCity', 'yState', 'yZip', 'yPhone', 'yFax', 'yEmail', 'yUrl', 'yTemplate', 'pAcceptPayments', 'pAcceptPaypal', 'pAcceptAuthorize', 'pAcceptCreditcard', 'pAcceptCash', 'pAcceptBank', 'pPaypalAddress', 'pAuthorizeTz', 'pAuthorizeKey', 'pAuthorizeMid', 'pAuthorizeHash', 'pBankAccount', 'siInclude', 'siShippingAddress', 'siCompany', 'siName', 'siAddress', 'siStreetAddress', 'siCity', 'siState', 'siZip', 'siPhone', 'siFax', 'siEmail', 'siUrl', 'siDate', 'siTerms', 'siIsShipped', 'siShipping', 'oBookingUrl', 'oQtyIsInt', 'oUseQtyUnitPrice', ),
        self::TYPE_COLNAME       => array(PluginInvoiceConfigTableMap::ID, PluginInvoiceConfigTableMap::Y_LOGO, PluginInvoiceConfigTableMap::Y_COMPANY, PluginInvoiceConfigTableMap::Y_NAME, PluginInvoiceConfigTableMap::Y_STREET_ADDRESS, PluginInvoiceConfigTableMap::Y_COUNTRY, PluginInvoiceConfigTableMap::Y_CITY, PluginInvoiceConfigTableMap::Y_STATE, PluginInvoiceConfigTableMap::Y_ZIP, PluginInvoiceConfigTableMap::Y_PHONE, PluginInvoiceConfigTableMap::Y_FAX, PluginInvoiceConfigTableMap::Y_EMAIL, PluginInvoiceConfigTableMap::Y_URL, PluginInvoiceConfigTableMap::Y_TEMPLATE, PluginInvoiceConfigTableMap::P_ACCEPT_PAYMENTS, PluginInvoiceConfigTableMap::P_ACCEPT_PAYPAL, PluginInvoiceConfigTableMap::P_ACCEPT_AUTHORIZE, PluginInvoiceConfigTableMap::P_ACCEPT_CREDITCARD, PluginInvoiceConfigTableMap::P_ACCEPT_CASH, PluginInvoiceConfigTableMap::P_ACCEPT_BANK, PluginInvoiceConfigTableMap::P_PAYPAL_ADDRESS, PluginInvoiceConfigTableMap::P_AUTHORIZE_TZ, PluginInvoiceConfigTableMap::P_AUTHORIZE_KEY, PluginInvoiceConfigTableMap::P_AUTHORIZE_MID, PluginInvoiceConfigTableMap::P_AUTHORIZE_HASH, PluginInvoiceConfigTableMap::P_BANK_ACCOUNT, PluginInvoiceConfigTableMap::SI_INCLUDE, PluginInvoiceConfigTableMap::SI_SHIPPING_ADDRESS, PluginInvoiceConfigTableMap::SI_COMPANY, PluginInvoiceConfigTableMap::SI_NAME, PluginInvoiceConfigTableMap::SI_ADDRESS, PluginInvoiceConfigTableMap::SI_STREET_ADDRESS, PluginInvoiceConfigTableMap::SI_CITY, PluginInvoiceConfigTableMap::SI_STATE, PluginInvoiceConfigTableMap::SI_ZIP, PluginInvoiceConfigTableMap::SI_PHONE, PluginInvoiceConfigTableMap::SI_FAX, PluginInvoiceConfigTableMap::SI_EMAIL, PluginInvoiceConfigTableMap::SI_URL, PluginInvoiceConfigTableMap::SI_DATE, PluginInvoiceConfigTableMap::SI_TERMS, PluginInvoiceConfigTableMap::SI_IS_SHIPPED, PluginInvoiceConfigTableMap::SI_SHIPPING, PluginInvoiceConfigTableMap::O_BOOKING_URL, PluginInvoiceConfigTableMap::O_QTY_IS_INT, PluginInvoiceConfigTableMap::O_USE_QTY_UNIT_PRICE, ),
        self::TYPE_RAW_COLNAME   => array('ID', 'Y_LOGO', 'Y_COMPANY', 'Y_NAME', 'Y_STREET_ADDRESS', 'Y_COUNTRY', 'Y_CITY', 'Y_STATE', 'Y_ZIP', 'Y_PHONE', 'Y_FAX', 'Y_EMAIL', 'Y_URL', 'Y_TEMPLATE', 'P_ACCEPT_PAYMENTS', 'P_ACCEPT_PAYPAL', 'P_ACCEPT_AUTHORIZE', 'P_ACCEPT_CREDITCARD', 'P_ACCEPT_CASH', 'P_ACCEPT_BANK', 'P_PAYPAL_ADDRESS', 'P_AUTHORIZE_TZ', 'P_AUTHORIZE_KEY', 'P_AUTHORIZE_MID', 'P_AUTHORIZE_HASH', 'P_BANK_ACCOUNT', 'SI_INCLUDE', 'SI_SHIPPING_ADDRESS', 'SI_COMPANY', 'SI_NAME', 'SI_ADDRESS', 'SI_STREET_ADDRESS', 'SI_CITY', 'SI_STATE', 'SI_ZIP', 'SI_PHONE', 'SI_FAX', 'SI_EMAIL', 'SI_URL', 'SI_DATE', 'SI_TERMS', 'SI_IS_SHIPPED', 'SI_SHIPPING', 'O_BOOKING_URL', 'O_QTY_IS_INT', 'O_USE_QTY_UNIT_PRICE', ),
        self::TYPE_FIELDNAME     => array('id', 'y_logo', 'y_company', 'y_name', 'y_street_address', 'y_country', 'y_city', 'y_state', 'y_zip', 'y_phone', 'y_fax', 'y_email', 'y_url', 'y_template', 'p_accept_payments', 'p_accept_paypal', 'p_accept_authorize', 'p_accept_creditcard', 'p_accept_cash', 'p_accept_bank', 'p_paypal_address', 'p_authorize_tz', 'p_authorize_key', 'p_authorize_mid', 'p_authorize_hash', 'p_bank_account', 'si_include', 'si_shipping_address', 'si_company', 'si_name', 'si_address', 'si_street_address', 'si_city', 'si_state', 'si_zip', 'si_phone', 'si_fax', 'si_email', 'si_url', 'si_date', 'si_terms', 'si_is_shipped', 'si_shipping', 'o_booking_url', 'o_qty_is_int', 'o_use_qty_unit_price', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'YLogo' => 1, 'YCompany' => 2, 'YName' => 3, 'YStreetAddress' => 4, 'YCountry' => 5, 'YCity' => 6, 'YState' => 7, 'YZip' => 8, 'YPhone' => 9, 'YFax' => 10, 'YEmail' => 11, 'YUrl' => 12, 'YTemplate' => 13, 'PAcceptPayments' => 14, 'PAcceptPaypal' => 15, 'PAcceptAuthorize' => 16, 'PAcceptCreditcard' => 17, 'PAcceptCash' => 18, 'PAcceptBank' => 19, 'PPaypalAddress' => 20, 'PAuthorizeTz' => 21, 'PAuthorizeKey' => 22, 'PAuthorizeMid' => 23, 'PAuthorizeHash' => 24, 'PBankAccount' => 25, 'SiInclude' => 26, 'SiShippingAddress' => 27, 'SiCompany' => 28, 'SiName' => 29, 'SiAddress' => 30, 'SiStreetAddress' => 31, 'SiCity' => 32, 'SiState' => 33, 'SiZip' => 34, 'SiPhone' => 35, 'SiFax' => 36, 'SiEmail' => 37, 'SiUrl' => 38, 'SiDate' => 39, 'SiTerms' => 40, 'SiIsShipped' => 41, 'SiShipping' => 42, 'OBookingUrl' => 43, 'OQtyIsInt' => 44, 'OUseQtyUnitPrice' => 45, ),
        self::TYPE_STUDLYPHPNAME => array('id' => 0, 'yLogo' => 1, 'yCompany' => 2, 'yName' => 3, 'yStreetAddress' => 4, 'yCountry' => 5, 'yCity' => 6, 'yState' => 7, 'yZip' => 8, 'yPhone' => 9, 'yFax' => 10, 'yEmail' => 11, 'yUrl' => 12, 'yTemplate' => 13, 'pAcceptPayments' => 14, 'pAcceptPaypal' => 15, 'pAcceptAuthorize' => 16, 'pAcceptCreditcard' => 17, 'pAcceptCash' => 18, 'pAcceptBank' => 19, 'pPaypalAddress' => 20, 'pAuthorizeTz' => 21, 'pAuthorizeKey' => 22, 'pAuthorizeMid' => 23, 'pAuthorizeHash' => 24, 'pBankAccount' => 25, 'siInclude' => 26, 'siShippingAddress' => 27, 'siCompany' => 28, 'siName' => 29, 'siAddress' => 30, 'siStreetAddress' => 31, 'siCity' => 32, 'siState' => 33, 'siZip' => 34, 'siPhone' => 35, 'siFax' => 36, 'siEmail' => 37, 'siUrl' => 38, 'siDate' => 39, 'siTerms' => 40, 'siIsShipped' => 41, 'siShipping' => 42, 'oBookingUrl' => 43, 'oQtyIsInt' => 44, 'oUseQtyUnitPrice' => 45, ),
        self::TYPE_COLNAME       => array(PluginInvoiceConfigTableMap::ID => 0, PluginInvoiceConfigTableMap::Y_LOGO => 1, PluginInvoiceConfigTableMap::Y_COMPANY => 2, PluginInvoiceConfigTableMap::Y_NAME => 3, PluginInvoiceConfigTableMap::Y_STREET_ADDRESS => 4, PluginInvoiceConfigTableMap::Y_COUNTRY => 5, PluginInvoiceConfigTableMap::Y_CITY => 6, PluginInvoiceConfigTableMap::Y_STATE => 7, PluginInvoiceConfigTableMap::Y_ZIP => 8, PluginInvoiceConfigTableMap::Y_PHONE => 9, PluginInvoiceConfigTableMap::Y_FAX => 10, PluginInvoiceConfigTableMap::Y_EMAIL => 11, PluginInvoiceConfigTableMap::Y_URL => 12, PluginInvoiceConfigTableMap::Y_TEMPLATE => 13, PluginInvoiceConfigTableMap::P_ACCEPT_PAYMENTS => 14, PluginInvoiceConfigTableMap::P_ACCEPT_PAYPAL => 15, PluginInvoiceConfigTableMap::P_ACCEPT_AUTHORIZE => 16, PluginInvoiceConfigTableMap::P_ACCEPT_CREDITCARD => 17, PluginInvoiceConfigTableMap::P_ACCEPT_CASH => 18, PluginInvoiceConfigTableMap::P_ACCEPT_BANK => 19, PluginInvoiceConfigTableMap::P_PAYPAL_ADDRESS => 20, PluginInvoiceConfigTableMap::P_AUTHORIZE_TZ => 21, PluginInvoiceConfigTableMap::P_AUTHORIZE_KEY => 22, PluginInvoiceConfigTableMap::P_AUTHORIZE_MID => 23, PluginInvoiceConfigTableMap::P_AUTHORIZE_HASH => 24, PluginInvoiceConfigTableMap::P_BANK_ACCOUNT => 25, PluginInvoiceConfigTableMap::SI_INCLUDE => 26, PluginInvoiceConfigTableMap::SI_SHIPPING_ADDRESS => 27, PluginInvoiceConfigTableMap::SI_COMPANY => 28, PluginInvoiceConfigTableMap::SI_NAME => 29, PluginInvoiceConfigTableMap::SI_ADDRESS => 30, PluginInvoiceConfigTableMap::SI_STREET_ADDRESS => 31, PluginInvoiceConfigTableMap::SI_CITY => 32, PluginInvoiceConfigTableMap::SI_STATE => 33, PluginInvoiceConfigTableMap::SI_ZIP => 34, PluginInvoiceConfigTableMap::SI_PHONE => 35, PluginInvoiceConfigTableMap::SI_FAX => 36, PluginInvoiceConfigTableMap::SI_EMAIL => 37, PluginInvoiceConfigTableMap::SI_URL => 38, PluginInvoiceConfigTableMap::SI_DATE => 39, PluginInvoiceConfigTableMap::SI_TERMS => 40, PluginInvoiceConfigTableMap::SI_IS_SHIPPED => 41, PluginInvoiceConfigTableMap::SI_SHIPPING => 42, PluginInvoiceConfigTableMap::O_BOOKING_URL => 43, PluginInvoiceConfigTableMap::O_QTY_IS_INT => 44, PluginInvoiceConfigTableMap::O_USE_QTY_UNIT_PRICE => 45, ),
        self::TYPE_RAW_COLNAME   => array('ID' => 0, 'Y_LOGO' => 1, 'Y_COMPANY' => 2, 'Y_NAME' => 3, 'Y_STREET_ADDRESS' => 4, 'Y_COUNTRY' => 5, 'Y_CITY' => 6, 'Y_STATE' => 7, 'Y_ZIP' => 8, 'Y_PHONE' => 9, 'Y_FAX' => 10, 'Y_EMAIL' => 11, 'Y_URL' => 12, 'Y_TEMPLATE' => 13, 'P_ACCEPT_PAYMENTS' => 14, 'P_ACCEPT_PAYPAL' => 15, 'P_ACCEPT_AUTHORIZE' => 16, 'P_ACCEPT_CREDITCARD' => 17, 'P_ACCEPT_CASH' => 18, 'P_ACCEPT_BANK' => 19, 'P_PAYPAL_ADDRESS' => 20, 'P_AUTHORIZE_TZ' => 21, 'P_AUTHORIZE_KEY' => 22, 'P_AUTHORIZE_MID' => 23, 'P_AUTHORIZE_HASH' => 24, 'P_BANK_ACCOUNT' => 25, 'SI_INCLUDE' => 26, 'SI_SHIPPING_ADDRESS' => 27, 'SI_COMPANY' => 28, 'SI_NAME' => 29, 'SI_ADDRESS' => 30, 'SI_STREET_ADDRESS' => 31, 'SI_CITY' => 32, 'SI_STATE' => 33, 'SI_ZIP' => 34, 'SI_PHONE' => 35, 'SI_FAX' => 36, 'SI_EMAIL' => 37, 'SI_URL' => 38, 'SI_DATE' => 39, 'SI_TERMS' => 40, 'SI_IS_SHIPPED' => 41, 'SI_SHIPPING' => 42, 'O_BOOKING_URL' => 43, 'O_QTY_IS_INT' => 44, 'O_USE_QTY_UNIT_PRICE' => 45, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'y_logo' => 1, 'y_company' => 2, 'y_name' => 3, 'y_street_address' => 4, 'y_country' => 5, 'y_city' => 6, 'y_state' => 7, 'y_zip' => 8, 'y_phone' => 9, 'y_fax' => 10, 'y_email' => 11, 'y_url' => 12, 'y_template' => 13, 'p_accept_payments' => 14, 'p_accept_paypal' => 15, 'p_accept_authorize' => 16, 'p_accept_creditcard' => 17, 'p_accept_cash' => 18, 'p_accept_bank' => 19, 'p_paypal_address' => 20, 'p_authorize_tz' => 21, 'p_authorize_key' => 22, 'p_authorize_mid' => 23, 'p_authorize_hash' => 24, 'p_bank_account' => 25, 'si_include' => 26, 'si_shipping_address' => 27, 'si_company' => 28, 'si_name' => 29, 'si_address' => 30, 'si_street_address' => 31, 'si_city' => 32, 'si_state' => 33, 'si_zip' => 34, 'si_phone' => 35, 'si_fax' => 36, 'si_email' => 37, 'si_url' => 38, 'si_date' => 39, 'si_terms' => 40, 'si_is_shipped' => 41, 'si_shipping' => 42, 'o_booking_url' => 43, 'o_qty_is_int' => 44, 'o_use_qty_unit_price' => 45, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, )
    );

    /**
     * Initialize the table attributes and columns
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('plugin_invoice_config');
        $this->setPhpName('PluginInvoiceConfig');
        $this->setClassName('\\HookCalendar\\Model\\PluginInvoiceConfig');
        $this->setPackage('HookCalendar.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('ID', 'Id', 'INTEGER', true, 10, null);
        $this->addColumn('Y_LOGO', 'YLogo', 'VARCHAR', false, 255, null);
        $this->addColumn('Y_COMPANY', 'YCompany', 'VARCHAR', false, 255, null);
        $this->addColumn('Y_NAME', 'YName', 'VARCHAR', false, 255, null);
        $this->addColumn('Y_STREET_ADDRESS', 'YStreetAddress', 'VARCHAR', false, 255, null);
        $this->addColumn('Y_COUNTRY', 'YCountry', 'INTEGER', false, 10, null);
        $this->addColumn('Y_CITY', 'YCity', 'VARCHAR', false, 255, null);
        $this->addColumn('Y_STATE', 'YState', 'VARCHAR', false, 255, null);
        $this->addColumn('Y_ZIP', 'YZip', 'VARCHAR', false, 255, null);
        $this->addColumn('Y_PHONE', 'YPhone', 'VARCHAR', false, 255, null);
        $this->addColumn('Y_FAX', 'YFax', 'VARCHAR', false, 255, null);
        $this->addColumn('Y_EMAIL', 'YEmail', 'VARCHAR', false, 255, null);
        $this->addColumn('Y_URL', 'YUrl', 'VARCHAR', false, 255, null);
        $this->addColumn('Y_TEMPLATE', 'YTemplate', 'LONGVARCHAR', false, null, null);
        $this->addColumn('P_ACCEPT_PAYMENTS', 'PAcceptPayments', 'BOOLEAN', false, 1, false);
        $this->addColumn('P_ACCEPT_PAYPAL', 'PAcceptPaypal', 'BOOLEAN', false, 1, false);
        $this->addColumn('P_ACCEPT_AUTHORIZE', 'PAcceptAuthorize', 'BOOLEAN', false, 1, false);
        $this->addColumn('P_ACCEPT_CREDITCARD', 'PAcceptCreditcard', 'BOOLEAN', false, 1, false);
        $this->addColumn('P_ACCEPT_CASH', 'PAcceptCash', 'BOOLEAN', false, 1, false);
        $this->addColumn('P_ACCEPT_BANK', 'PAcceptBank', 'BOOLEAN', false, 1, false);
        $this->addColumn('P_PAYPAL_ADDRESS', 'PPaypalAddress', 'VARCHAR', false, 255, null);
        $this->addColumn('P_AUTHORIZE_TZ', 'PAuthorizeTz', 'VARCHAR', false, 255, null);
        $this->addColumn('P_AUTHORIZE_KEY', 'PAuthorizeKey', 'VARCHAR', false, 255, null);
        $this->addColumn('P_AUTHORIZE_MID', 'PAuthorizeMid', 'VARCHAR', false, 255, null);
        $this->addColumn('P_AUTHORIZE_HASH', 'PAuthorizeHash', 'VARCHAR', false, 255, null);
        $this->addColumn('P_BANK_ACCOUNT', 'PBankAccount', 'VARCHAR', false, 255, null);
        $this->addColumn('SI_INCLUDE', 'SiInclude', 'BOOLEAN', false, 1, false);
        $this->addColumn('SI_SHIPPING_ADDRESS', 'SiShippingAddress', 'BOOLEAN', false, 1, false);
        $this->addColumn('SI_COMPANY', 'SiCompany', 'BOOLEAN', false, 1, false);
        $this->addColumn('SI_NAME', 'SiName', 'BOOLEAN', false, 1, false);
        $this->addColumn('SI_ADDRESS', 'SiAddress', 'BOOLEAN', false, 1, false);
        $this->addColumn('SI_STREET_ADDRESS', 'SiStreetAddress', 'BOOLEAN', false, 1, false);
        $this->addColumn('SI_CITY', 'SiCity', 'BOOLEAN', false, 1, false);
        $this->addColumn('SI_STATE', 'SiState', 'BOOLEAN', false, 1, false);
        $this->addColumn('SI_ZIP', 'SiZip', 'BOOLEAN', false, 1, false);
        $this->addColumn('SI_PHONE', 'SiPhone', 'BOOLEAN', false, 1, false);
        $this->addColumn('SI_FAX', 'SiFax', 'BOOLEAN', false, 1, false);
        $this->addColumn('SI_EMAIL', 'SiEmail', 'BOOLEAN', false, 1, false);
        $this->addColumn('SI_URL', 'SiUrl', 'BOOLEAN', false, 1, false);
        $this->addColumn('SI_DATE', 'SiDate', 'BOOLEAN', false, 1, false);
        $this->addColumn('SI_TERMS', 'SiTerms', 'BOOLEAN', false, 1, false);
        $this->addColumn('SI_IS_SHIPPED', 'SiIsShipped', 'BOOLEAN', false, 1, false);
        $this->addColumn('SI_SHIPPING', 'SiShipping', 'BOOLEAN', false, 1, false);
        $this->addColumn('O_BOOKING_URL', 'OBookingUrl', 'VARCHAR', false, 255, null);
        $this->addColumn('O_QTY_IS_INT', 'OQtyIsInt', 'BOOLEAN', false, 1, false);
        $this->addColumn('O_USE_QTY_UNIT_PRICE', 'OUseQtyUnitPrice', 'BOOLEAN', false, 1, true);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
    } // buildRelations()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     */
    public static function getPrimaryKeyHashFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        // If the PK cannot be derived from the row, return NULL.
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {

            return (int) $row[
                            $indexType == TableMap::TYPE_NUM
                            ? 0 + $offset
                            : self::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)
                        ];
    }

    /**
     * The class that the tableMap will make instances of.
     *
     * If $withPrefix is true, the returned path
     * uses a dot-path notation which is translated into a path
     * relative to a location on the PHP include_path.
     * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
     *
     * @param boolean $withPrefix Whether or not to return the path with the class name
     * @return string path.to.ClassName
     */
    public static function getOMClass($withPrefix = true)
    {
        return $withPrefix ? PluginInvoiceConfigTableMap::CLASS_DEFAULT : PluginInvoiceConfigTableMap::OM_CLASS;
    }

    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param array  $row       row returned by DataFetcher->fetch().
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                 One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     * @return array (PluginInvoiceConfig object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = PluginInvoiceConfigTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = PluginInvoiceConfigTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + PluginInvoiceConfigTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = PluginInvoiceConfigTableMap::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            PluginInvoiceConfigTableMap::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @param DataFetcherInterface $dataFetcher
     * @return array
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function populateObjects(DataFetcherInterface $dataFetcher)
    {
        $results = array();

        // set the class once to avoid overhead in the loop
        $cls = static::getOMClass(false);
        // populate the object(s)
        while ($row = $dataFetcher->fetch()) {
            $key = PluginInvoiceConfigTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = PluginInvoiceConfigTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                PluginInvoiceConfigTableMap::addInstanceToPool($obj, $key);
            } // if key exists
        }

        return $results;
    }
    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param Criteria $criteria object containing the columns to add.
     * @param string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(PluginInvoiceConfigTableMap::ID);
            $criteria->addSelectColumn(PluginInvoiceConfigTableMap::Y_LOGO);
            $criteria->addSelectColumn(PluginInvoiceConfigTableMap::Y_COMPANY);
            $criteria->addSelectColumn(PluginInvoiceConfigTableMap::Y_NAME);
            $criteria->addSelectColumn(PluginInvoiceConfigTableMap::Y_STREET_ADDRESS);
            $criteria->addSelectColumn(PluginInvoiceConfigTableMap::Y_COUNTRY);
            $criteria->addSelectColumn(PluginInvoiceConfigTableMap::Y_CITY);
            $criteria->addSelectColumn(PluginInvoiceConfigTableMap::Y_STATE);
            $criteria->addSelectColumn(PluginInvoiceConfigTableMap::Y_ZIP);
            $criteria->addSelectColumn(PluginInvoiceConfigTableMap::Y_PHONE);
            $criteria->addSelectColumn(PluginInvoiceConfigTableMap::Y_FAX);
            $criteria->addSelectColumn(PluginInvoiceConfigTableMap::Y_EMAIL);
            $criteria->addSelectColumn(PluginInvoiceConfigTableMap::Y_URL);
            $criteria->addSelectColumn(PluginInvoiceConfigTableMap::Y_TEMPLATE);
            $criteria->addSelectColumn(PluginInvoiceConfigTableMap::P_ACCEPT_PAYMENTS);
            $criteria->addSelectColumn(PluginInvoiceConfigTableMap::P_ACCEPT_PAYPAL);
            $criteria->addSelectColumn(PluginInvoiceConfigTableMap::P_ACCEPT_AUTHORIZE);
            $criteria->addSelectColumn(PluginInvoiceConfigTableMap::P_ACCEPT_CREDITCARD);
            $criteria->addSelectColumn(PluginInvoiceConfigTableMap::P_ACCEPT_CASH);
            $criteria->addSelectColumn(PluginInvoiceConfigTableMap::P_ACCEPT_BANK);
            $criteria->addSelectColumn(PluginInvoiceConfigTableMap::P_PAYPAL_ADDRESS);
            $criteria->addSelectColumn(PluginInvoiceConfigTableMap::P_AUTHORIZE_TZ);
            $criteria->addSelectColumn(PluginInvoiceConfigTableMap::P_AUTHORIZE_KEY);
            $criteria->addSelectColumn(PluginInvoiceConfigTableMap::P_AUTHORIZE_MID);
            $criteria->addSelectColumn(PluginInvoiceConfigTableMap::P_AUTHORIZE_HASH);
            $criteria->addSelectColumn(PluginInvoiceConfigTableMap::P_BANK_ACCOUNT);
            $criteria->addSelectColumn(PluginInvoiceConfigTableMap::SI_INCLUDE);
            $criteria->addSelectColumn(PluginInvoiceConfigTableMap::SI_SHIPPING_ADDRESS);
            $criteria->addSelectColumn(PluginInvoiceConfigTableMap::SI_COMPANY);
            $criteria->addSelectColumn(PluginInvoiceConfigTableMap::SI_NAME);
            $criteria->addSelectColumn(PluginInvoiceConfigTableMap::SI_ADDRESS);
            $criteria->addSelectColumn(PluginInvoiceConfigTableMap::SI_STREET_ADDRESS);
            $criteria->addSelectColumn(PluginInvoiceConfigTableMap::SI_CITY);
            $criteria->addSelectColumn(PluginInvoiceConfigTableMap::SI_STATE);
            $criteria->addSelectColumn(PluginInvoiceConfigTableMap::SI_ZIP);
            $criteria->addSelectColumn(PluginInvoiceConfigTableMap::SI_PHONE);
            $criteria->addSelectColumn(PluginInvoiceConfigTableMap::SI_FAX);
            $criteria->addSelectColumn(PluginInvoiceConfigTableMap::SI_EMAIL);
            $criteria->addSelectColumn(PluginInvoiceConfigTableMap::SI_URL);
            $criteria->addSelectColumn(PluginInvoiceConfigTableMap::SI_DATE);
            $criteria->addSelectColumn(PluginInvoiceConfigTableMap::SI_TERMS);
            $criteria->addSelectColumn(PluginInvoiceConfigTableMap::SI_IS_SHIPPED);
            $criteria->addSelectColumn(PluginInvoiceConfigTableMap::SI_SHIPPING);
            $criteria->addSelectColumn(PluginInvoiceConfigTableMap::O_BOOKING_URL);
            $criteria->addSelectColumn(PluginInvoiceConfigTableMap::O_QTY_IS_INT);
            $criteria->addSelectColumn(PluginInvoiceConfigTableMap::O_USE_QTY_UNIT_PRICE);
        } else {
            $criteria->addSelectColumn($alias . '.ID');
            $criteria->addSelectColumn($alias . '.Y_LOGO');
            $criteria->addSelectColumn($alias . '.Y_COMPANY');
            $criteria->addSelectColumn($alias . '.Y_NAME');
            $criteria->addSelectColumn($alias . '.Y_STREET_ADDRESS');
            $criteria->addSelectColumn($alias . '.Y_COUNTRY');
            $criteria->addSelectColumn($alias . '.Y_CITY');
            $criteria->addSelectColumn($alias . '.Y_STATE');
            $criteria->addSelectColumn($alias . '.Y_ZIP');
            $criteria->addSelectColumn($alias . '.Y_PHONE');
            $criteria->addSelectColumn($alias . '.Y_FAX');
            $criteria->addSelectColumn($alias . '.Y_EMAIL');
            $criteria->addSelectColumn($alias . '.Y_URL');
            $criteria->addSelectColumn($alias . '.Y_TEMPLATE');
            $criteria->addSelectColumn($alias . '.P_ACCEPT_PAYMENTS');
            $criteria->addSelectColumn($alias . '.P_ACCEPT_PAYPAL');
            $criteria->addSelectColumn($alias . '.P_ACCEPT_AUTHORIZE');
            $criteria->addSelectColumn($alias . '.P_ACCEPT_CREDITCARD');
            $criteria->addSelectColumn($alias . '.P_ACCEPT_CASH');
            $criteria->addSelectColumn($alias . '.P_ACCEPT_BANK');
            $criteria->addSelectColumn($alias . '.P_PAYPAL_ADDRESS');
            $criteria->addSelectColumn($alias . '.P_AUTHORIZE_TZ');
            $criteria->addSelectColumn($alias . '.P_AUTHORIZE_KEY');
            $criteria->addSelectColumn($alias . '.P_AUTHORIZE_MID');
            $criteria->addSelectColumn($alias . '.P_AUTHORIZE_HASH');
            $criteria->addSelectColumn($alias . '.P_BANK_ACCOUNT');
            $criteria->addSelectColumn($alias . '.SI_INCLUDE');
            $criteria->addSelectColumn($alias . '.SI_SHIPPING_ADDRESS');
            $criteria->addSelectColumn($alias . '.SI_COMPANY');
            $criteria->addSelectColumn($alias . '.SI_NAME');
            $criteria->addSelectColumn($alias . '.SI_ADDRESS');
            $criteria->addSelectColumn($alias . '.SI_STREET_ADDRESS');
            $criteria->addSelectColumn($alias . '.SI_CITY');
            $criteria->addSelectColumn($alias . '.SI_STATE');
            $criteria->addSelectColumn($alias . '.SI_ZIP');
            $criteria->addSelectColumn($alias . '.SI_PHONE');
            $criteria->addSelectColumn($alias . '.SI_FAX');
            $criteria->addSelectColumn($alias . '.SI_EMAIL');
            $criteria->addSelectColumn($alias . '.SI_URL');
            $criteria->addSelectColumn($alias . '.SI_DATE');
            $criteria->addSelectColumn($alias . '.SI_TERMS');
            $criteria->addSelectColumn($alias . '.SI_IS_SHIPPED');
            $criteria->addSelectColumn($alias . '.SI_SHIPPING');
            $criteria->addSelectColumn($alias . '.O_BOOKING_URL');
            $criteria->addSelectColumn($alias . '.O_QTY_IS_INT');
            $criteria->addSelectColumn($alias . '.O_USE_QTY_UNIT_PRICE');
        }
    }

    /**
     * Returns the TableMap related to this object.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getServiceContainer()->getDatabaseMap(PluginInvoiceConfigTableMap::DATABASE_NAME)->getTable(PluginInvoiceConfigTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getServiceContainer()->getDatabaseMap(PluginInvoiceConfigTableMap::DATABASE_NAME);
      if (!$dbMap->hasTable(PluginInvoiceConfigTableMap::TABLE_NAME)) {
        $dbMap->addTableObject(new PluginInvoiceConfigTableMap());
      }
    }

    /**
     * Performs a DELETE on the database, given a PluginInvoiceConfig or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or PluginInvoiceConfig object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PluginInvoiceConfigTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \HookCalendar\Model\PluginInvoiceConfig) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(PluginInvoiceConfigTableMap::DATABASE_NAME);
            $criteria->add(PluginInvoiceConfigTableMap::ID, (array) $values, Criteria::IN);
        }

        $query = PluginInvoiceConfigQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) { PluginInvoiceConfigTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) { PluginInvoiceConfigTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the plugin_invoice_config table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return PluginInvoiceConfigQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a PluginInvoiceConfig or Criteria object.
     *
     * @param mixed               $criteria Criteria or PluginInvoiceConfig object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PluginInvoiceConfigTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from PluginInvoiceConfig object
        }

        if ($criteria->containsKey(PluginInvoiceConfigTableMap::ID) && $criteria->keyContainsValue(PluginInvoiceConfigTableMap::ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.PluginInvoiceConfigTableMap::ID.')');
        }


        // Set the correct dbName
        $query = PluginInvoiceConfigQuery::create()->mergeWith($criteria);

        try {
            // use transaction because $criteria could contain info
            // for more than one table (I guess, conceivably)
            $con->beginTransaction();
            $pk = $query->doInsert($con);
            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $pk;
    }

} // PluginInvoiceConfigTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
PluginInvoiceConfigTableMap::buildTableMap();
