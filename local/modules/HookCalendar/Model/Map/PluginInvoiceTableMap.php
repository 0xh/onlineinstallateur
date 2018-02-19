<?php

namespace HookCalendar\Model\Map;

use HookCalendar\Model\PluginInvoice;
use HookCalendar\Model\PluginInvoiceQuery;
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
 * This class defines the structure of the 'plugin_invoice' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class PluginInvoiceTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;
    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'HookCalendar.Model.Map.PluginInvoiceTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'thelia';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'plugin_invoice';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\HookCalendar\\Model\\PluginInvoice';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'HookCalendar.Model.PluginInvoice';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 67;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 67;

    /**
     * the column name for the ID field
     */
    const ID = 'plugin_invoice.ID';

    /**
     * the column name for the UUID field
     */
    const UUID = 'plugin_invoice.UUID';

    /**
     * the column name for the ORDER_ID field
     */
    const ORDER_ID = 'plugin_invoice.ORDER_ID';

    /**
     * the column name for the FOREIGN_ID field
     */
    const FOREIGN_ID = 'plugin_invoice.FOREIGN_ID';

    /**
     * the column name for the ISSUE_DATE field
     */
    const ISSUE_DATE = 'plugin_invoice.ISSUE_DATE';

    /**
     * the column name for the DUE_DATE field
     */
    const DUE_DATE = 'plugin_invoice.DUE_DATE';

    /**
     * the column name for the CREATED field
     */
    const CREATED = 'plugin_invoice.CREATED';

    /**
     * the column name for the MODIFIED field
     */
    const MODIFIED = 'plugin_invoice.MODIFIED';

    /**
     * the column name for the STATUS field
     */
    const STATUS = 'plugin_invoice.STATUS';

    /**
     * the column name for the PAYMENT_METHOD field
     */
    const PAYMENT_METHOD = 'plugin_invoice.PAYMENT_METHOD';

    /**
     * the column name for the CC_TYPE field
     */
    const CC_TYPE = 'plugin_invoice.CC_TYPE';

    /**
     * the column name for the CC_NUM field
     */
    const CC_NUM = 'plugin_invoice.CC_NUM';

    /**
     * the column name for the CC_EXP_MONTH field
     */
    const CC_EXP_MONTH = 'plugin_invoice.CC_EXP_MONTH';

    /**
     * the column name for the CC_EXP_YEAR field
     */
    const CC_EXP_YEAR = 'plugin_invoice.CC_EXP_YEAR';

    /**
     * the column name for the CC_CODE field
     */
    const CC_CODE = 'plugin_invoice.CC_CODE';

    /**
     * the column name for the TXN_ID field
     */
    const TXN_ID = 'plugin_invoice.TXN_ID';

    /**
     * the column name for the PROCESSED_ON field
     */
    const PROCESSED_ON = 'plugin_invoice.PROCESSED_ON';

    /**
     * the column name for the SUBTOTAL field
     */
    const SUBTOTAL = 'plugin_invoice.SUBTOTAL';

    /**
     * the column name for the DISCOUNT field
     */
    const DISCOUNT = 'plugin_invoice.DISCOUNT';

    /**
     * the column name for the TAX field
     */
    const TAX = 'plugin_invoice.TAX';

    /**
     * the column name for the SHIPPING field
     */
    const SHIPPING = 'plugin_invoice.SHIPPING';

    /**
     * the column name for the TOTAL field
     */
    const TOTAL = 'plugin_invoice.TOTAL';

    /**
     * the column name for the PAID_DEPOSIT field
     */
    const PAID_DEPOSIT = 'plugin_invoice.PAID_DEPOSIT';

    /**
     * the column name for the AMOUNT_DUE field
     */
    const AMOUNT_DUE = 'plugin_invoice.AMOUNT_DUE';

    /**
     * the column name for the CURRENCY field
     */
    const CURRENCY = 'plugin_invoice.CURRENCY';

    /**
     * the column name for the NOTES field
     */
    const NOTES = 'plugin_invoice.NOTES';

    /**
     * the column name for the Y_LOGO field
     */
    const Y_LOGO = 'plugin_invoice.Y_LOGO';

    /**
     * the column name for the Y_COMPANY field
     */
    const Y_COMPANY = 'plugin_invoice.Y_COMPANY';

    /**
     * the column name for the Y_NAME field
     */
    const Y_NAME = 'plugin_invoice.Y_NAME';

    /**
     * the column name for the Y_STREET_ADDRESS field
     */
    const Y_STREET_ADDRESS = 'plugin_invoice.Y_STREET_ADDRESS';

    /**
     * the column name for the Y_COUNTRY field
     */
    const Y_COUNTRY = 'plugin_invoice.Y_COUNTRY';

    /**
     * the column name for the Y_CITY field
     */
    const Y_CITY = 'plugin_invoice.Y_CITY';

    /**
     * the column name for the Y_STATE field
     */
    const Y_STATE = 'plugin_invoice.Y_STATE';

    /**
     * the column name for the Y_ZIP field
     */
    const Y_ZIP = 'plugin_invoice.Y_ZIP';

    /**
     * the column name for the Y_PHONE field
     */
    const Y_PHONE = 'plugin_invoice.Y_PHONE';

    /**
     * the column name for the Y_FAX field
     */
    const Y_FAX = 'plugin_invoice.Y_FAX';

    /**
     * the column name for the Y_EMAIL field
     */
    const Y_EMAIL = 'plugin_invoice.Y_EMAIL';

    /**
     * the column name for the Y_URL field
     */
    const Y_URL = 'plugin_invoice.Y_URL';

    /**
     * the column name for the B_BILLING_ADDRESS field
     */
    const B_BILLING_ADDRESS = 'plugin_invoice.B_BILLING_ADDRESS';

    /**
     * the column name for the B_COMPANY field
     */
    const B_COMPANY = 'plugin_invoice.B_COMPANY';

    /**
     * the column name for the B_NAME field
     */
    const B_NAME = 'plugin_invoice.B_NAME';

    /**
     * the column name for the B_ADDRESS field
     */
    const B_ADDRESS = 'plugin_invoice.B_ADDRESS';

    /**
     * the column name for the B_STREET_ADDRESS field
     */
    const B_STREET_ADDRESS = 'plugin_invoice.B_STREET_ADDRESS';

    /**
     * the column name for the B_COUNTRY field
     */
    const B_COUNTRY = 'plugin_invoice.B_COUNTRY';

    /**
     * the column name for the B_CITY field
     */
    const B_CITY = 'plugin_invoice.B_CITY';

    /**
     * the column name for the B_STATE field
     */
    const B_STATE = 'plugin_invoice.B_STATE';

    /**
     * the column name for the B_ZIP field
     */
    const B_ZIP = 'plugin_invoice.B_ZIP';

    /**
     * the column name for the B_PHONE field
     */
    const B_PHONE = 'plugin_invoice.B_PHONE';

    /**
     * the column name for the B_FAX field
     */
    const B_FAX = 'plugin_invoice.B_FAX';

    /**
     * the column name for the B_EMAIL field
     */
    const B_EMAIL = 'plugin_invoice.B_EMAIL';

    /**
     * the column name for the B_URL field
     */
    const B_URL = 'plugin_invoice.B_URL';

    /**
     * the column name for the S_SHIPPING_ADDRESS field
     */
    const S_SHIPPING_ADDRESS = 'plugin_invoice.S_SHIPPING_ADDRESS';

    /**
     * the column name for the S_COMPANY field
     */
    const S_COMPANY = 'plugin_invoice.S_COMPANY';

    /**
     * the column name for the S_NAME field
     */
    const S_NAME = 'plugin_invoice.S_NAME';

    /**
     * the column name for the S_ADDRESS field
     */
    const S_ADDRESS = 'plugin_invoice.S_ADDRESS';

    /**
     * the column name for the S_STREET_ADDRESS field
     */
    const S_STREET_ADDRESS = 'plugin_invoice.S_STREET_ADDRESS';

    /**
     * the column name for the S_COUNTRY field
     */
    const S_COUNTRY = 'plugin_invoice.S_COUNTRY';

    /**
     * the column name for the S_CITY field
     */
    const S_CITY = 'plugin_invoice.S_CITY';

    /**
     * the column name for the S_STATE field
     */
    const S_STATE = 'plugin_invoice.S_STATE';

    /**
     * the column name for the S_ZIP field
     */
    const S_ZIP = 'plugin_invoice.S_ZIP';

    /**
     * the column name for the S_PHONE field
     */
    const S_PHONE = 'plugin_invoice.S_PHONE';

    /**
     * the column name for the S_FAX field
     */
    const S_FAX = 'plugin_invoice.S_FAX';

    /**
     * the column name for the S_EMAIL field
     */
    const S_EMAIL = 'plugin_invoice.S_EMAIL';

    /**
     * the column name for the S_URL field
     */
    const S_URL = 'plugin_invoice.S_URL';

    /**
     * the column name for the S_DATE field
     */
    const S_DATE = 'plugin_invoice.S_DATE';

    /**
     * the column name for the S_TERMS field
     */
    const S_TERMS = 'plugin_invoice.S_TERMS';

    /**
     * the column name for the S_IS_SHIPPED field
     */
    const S_IS_SHIPPED = 'plugin_invoice.S_IS_SHIPPED';

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
        self::TYPE_PHPNAME       => array('Id', 'Uuid', 'OrderId', 'ForeignId', 'IssueDate', 'DueDate', 'Created', 'Modified', 'Status', 'PaymentMethod', 'CcType', 'CcNum', 'CcExpMonth', 'CcExpYear', 'CcCode', 'TxnId', 'ProcessedOn', 'Subtotal', 'Discount', 'Tax', 'Shipping', 'Total', 'PaidDeposit', 'AmountDue', 'Currency', 'Notes', 'YLogo', 'YCompany', 'YName', 'YStreetAddress', 'YCountry', 'YCity', 'YState', 'YZip', 'YPhone', 'YFax', 'YEmail', 'YUrl', 'BBillingAddress', 'BCompany', 'BName', 'BAddress', 'BStreetAddress', 'BCountry', 'BCity', 'BState', 'BZip', 'BPhone', 'BFax', 'BEmail', 'BUrl', 'SShippingAddress', 'SCompany', 'SName', 'SAddress', 'SStreetAddress', 'SCountry', 'SCity', 'SState', 'SZip', 'SPhone', 'SFax', 'SEmail', 'SUrl', 'SDate', 'STerms', 'SIsShipped', ),
        self::TYPE_STUDLYPHPNAME => array('id', 'uuid', 'orderId', 'foreignId', 'issueDate', 'dueDate', 'created', 'modified', 'status', 'paymentMethod', 'ccType', 'ccNum', 'ccExpMonth', 'ccExpYear', 'ccCode', 'txnId', 'processedOn', 'subtotal', 'discount', 'tax', 'shipping', 'total', 'paidDeposit', 'amountDue', 'currency', 'notes', 'yLogo', 'yCompany', 'yName', 'yStreetAddress', 'yCountry', 'yCity', 'yState', 'yZip', 'yPhone', 'yFax', 'yEmail', 'yUrl', 'bBillingAddress', 'bCompany', 'bName', 'bAddress', 'bStreetAddress', 'bCountry', 'bCity', 'bState', 'bZip', 'bPhone', 'bFax', 'bEmail', 'bUrl', 'sShippingAddress', 'sCompany', 'sName', 'sAddress', 'sStreetAddress', 'sCountry', 'sCity', 'sState', 'sZip', 'sPhone', 'sFax', 'sEmail', 'sUrl', 'sDate', 'sTerms', 'sIsShipped', ),
        self::TYPE_COLNAME       => array(PluginInvoiceTableMap::ID, PluginInvoiceTableMap::UUID, PluginInvoiceTableMap::ORDER_ID, PluginInvoiceTableMap::FOREIGN_ID, PluginInvoiceTableMap::ISSUE_DATE, PluginInvoiceTableMap::DUE_DATE, PluginInvoiceTableMap::CREATED, PluginInvoiceTableMap::MODIFIED, PluginInvoiceTableMap::STATUS, PluginInvoiceTableMap::PAYMENT_METHOD, PluginInvoiceTableMap::CC_TYPE, PluginInvoiceTableMap::CC_NUM, PluginInvoiceTableMap::CC_EXP_MONTH, PluginInvoiceTableMap::CC_EXP_YEAR, PluginInvoiceTableMap::CC_CODE, PluginInvoiceTableMap::TXN_ID, PluginInvoiceTableMap::PROCESSED_ON, PluginInvoiceTableMap::SUBTOTAL, PluginInvoiceTableMap::DISCOUNT, PluginInvoiceTableMap::TAX, PluginInvoiceTableMap::SHIPPING, PluginInvoiceTableMap::TOTAL, PluginInvoiceTableMap::PAID_DEPOSIT, PluginInvoiceTableMap::AMOUNT_DUE, PluginInvoiceTableMap::CURRENCY, PluginInvoiceTableMap::NOTES, PluginInvoiceTableMap::Y_LOGO, PluginInvoiceTableMap::Y_COMPANY, PluginInvoiceTableMap::Y_NAME, PluginInvoiceTableMap::Y_STREET_ADDRESS, PluginInvoiceTableMap::Y_COUNTRY, PluginInvoiceTableMap::Y_CITY, PluginInvoiceTableMap::Y_STATE, PluginInvoiceTableMap::Y_ZIP, PluginInvoiceTableMap::Y_PHONE, PluginInvoiceTableMap::Y_FAX, PluginInvoiceTableMap::Y_EMAIL, PluginInvoiceTableMap::Y_URL, PluginInvoiceTableMap::B_BILLING_ADDRESS, PluginInvoiceTableMap::B_COMPANY, PluginInvoiceTableMap::B_NAME, PluginInvoiceTableMap::B_ADDRESS, PluginInvoiceTableMap::B_STREET_ADDRESS, PluginInvoiceTableMap::B_COUNTRY, PluginInvoiceTableMap::B_CITY, PluginInvoiceTableMap::B_STATE, PluginInvoiceTableMap::B_ZIP, PluginInvoiceTableMap::B_PHONE, PluginInvoiceTableMap::B_FAX, PluginInvoiceTableMap::B_EMAIL, PluginInvoiceTableMap::B_URL, PluginInvoiceTableMap::S_SHIPPING_ADDRESS, PluginInvoiceTableMap::S_COMPANY, PluginInvoiceTableMap::S_NAME, PluginInvoiceTableMap::S_ADDRESS, PluginInvoiceTableMap::S_STREET_ADDRESS, PluginInvoiceTableMap::S_COUNTRY, PluginInvoiceTableMap::S_CITY, PluginInvoiceTableMap::S_STATE, PluginInvoiceTableMap::S_ZIP, PluginInvoiceTableMap::S_PHONE, PluginInvoiceTableMap::S_FAX, PluginInvoiceTableMap::S_EMAIL, PluginInvoiceTableMap::S_URL, PluginInvoiceTableMap::S_DATE, PluginInvoiceTableMap::S_TERMS, PluginInvoiceTableMap::S_IS_SHIPPED, ),
        self::TYPE_RAW_COLNAME   => array('ID', 'UUID', 'ORDER_ID', 'FOREIGN_ID', 'ISSUE_DATE', 'DUE_DATE', 'CREATED', 'MODIFIED', 'STATUS', 'PAYMENT_METHOD', 'CC_TYPE', 'CC_NUM', 'CC_EXP_MONTH', 'CC_EXP_YEAR', 'CC_CODE', 'TXN_ID', 'PROCESSED_ON', 'SUBTOTAL', 'DISCOUNT', 'TAX', 'SHIPPING', 'TOTAL', 'PAID_DEPOSIT', 'AMOUNT_DUE', 'CURRENCY', 'NOTES', 'Y_LOGO', 'Y_COMPANY', 'Y_NAME', 'Y_STREET_ADDRESS', 'Y_COUNTRY', 'Y_CITY', 'Y_STATE', 'Y_ZIP', 'Y_PHONE', 'Y_FAX', 'Y_EMAIL', 'Y_URL', 'B_BILLING_ADDRESS', 'B_COMPANY', 'B_NAME', 'B_ADDRESS', 'B_STREET_ADDRESS', 'B_COUNTRY', 'B_CITY', 'B_STATE', 'B_ZIP', 'B_PHONE', 'B_FAX', 'B_EMAIL', 'B_URL', 'S_SHIPPING_ADDRESS', 'S_COMPANY', 'S_NAME', 'S_ADDRESS', 'S_STREET_ADDRESS', 'S_COUNTRY', 'S_CITY', 'S_STATE', 'S_ZIP', 'S_PHONE', 'S_FAX', 'S_EMAIL', 'S_URL', 'S_DATE', 'S_TERMS', 'S_IS_SHIPPED', ),
        self::TYPE_FIELDNAME     => array('id', 'uuid', 'order_id', 'foreign_id', 'issue_date', 'due_date', 'created', 'modified', 'status', 'payment_method', 'cc_type', 'cc_num', 'cc_exp_month', 'cc_exp_year', 'cc_code', 'txn_id', 'processed_on', 'subtotal', 'discount', 'tax', 'shipping', 'total', 'paid_deposit', 'amount_due', 'currency', 'notes', 'y_logo', 'y_company', 'y_name', 'y_street_address', 'y_country', 'y_city', 'y_state', 'y_zip', 'y_phone', 'y_fax', 'y_email', 'y_url', 'b_billing_address', 'b_company', 'b_name', 'b_address', 'b_street_address', 'b_country', 'b_city', 'b_state', 'b_zip', 'b_phone', 'b_fax', 'b_email', 'b_url', 's_shipping_address', 's_company', 's_name', 's_address', 's_street_address', 's_country', 's_city', 's_state', 's_zip', 's_phone', 's_fax', 's_email', 's_url', 's_date', 's_terms', 's_is_shipped', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 59, 60, 61, 62, 63, 64, 65, 66, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'Uuid' => 1, 'OrderId' => 2, 'ForeignId' => 3, 'IssueDate' => 4, 'DueDate' => 5, 'Created' => 6, 'Modified' => 7, 'Status' => 8, 'PaymentMethod' => 9, 'CcType' => 10, 'CcNum' => 11, 'CcExpMonth' => 12, 'CcExpYear' => 13, 'CcCode' => 14, 'TxnId' => 15, 'ProcessedOn' => 16, 'Subtotal' => 17, 'Discount' => 18, 'Tax' => 19, 'Shipping' => 20, 'Total' => 21, 'PaidDeposit' => 22, 'AmountDue' => 23, 'Currency' => 24, 'Notes' => 25, 'YLogo' => 26, 'YCompany' => 27, 'YName' => 28, 'YStreetAddress' => 29, 'YCountry' => 30, 'YCity' => 31, 'YState' => 32, 'YZip' => 33, 'YPhone' => 34, 'YFax' => 35, 'YEmail' => 36, 'YUrl' => 37, 'BBillingAddress' => 38, 'BCompany' => 39, 'BName' => 40, 'BAddress' => 41, 'BStreetAddress' => 42, 'BCountry' => 43, 'BCity' => 44, 'BState' => 45, 'BZip' => 46, 'BPhone' => 47, 'BFax' => 48, 'BEmail' => 49, 'BUrl' => 50, 'SShippingAddress' => 51, 'SCompany' => 52, 'SName' => 53, 'SAddress' => 54, 'SStreetAddress' => 55, 'SCountry' => 56, 'SCity' => 57, 'SState' => 58, 'SZip' => 59, 'SPhone' => 60, 'SFax' => 61, 'SEmail' => 62, 'SUrl' => 63, 'SDate' => 64, 'STerms' => 65, 'SIsShipped' => 66, ),
        self::TYPE_STUDLYPHPNAME => array('id' => 0, 'uuid' => 1, 'orderId' => 2, 'foreignId' => 3, 'issueDate' => 4, 'dueDate' => 5, 'created' => 6, 'modified' => 7, 'status' => 8, 'paymentMethod' => 9, 'ccType' => 10, 'ccNum' => 11, 'ccExpMonth' => 12, 'ccExpYear' => 13, 'ccCode' => 14, 'txnId' => 15, 'processedOn' => 16, 'subtotal' => 17, 'discount' => 18, 'tax' => 19, 'shipping' => 20, 'total' => 21, 'paidDeposit' => 22, 'amountDue' => 23, 'currency' => 24, 'notes' => 25, 'yLogo' => 26, 'yCompany' => 27, 'yName' => 28, 'yStreetAddress' => 29, 'yCountry' => 30, 'yCity' => 31, 'yState' => 32, 'yZip' => 33, 'yPhone' => 34, 'yFax' => 35, 'yEmail' => 36, 'yUrl' => 37, 'bBillingAddress' => 38, 'bCompany' => 39, 'bName' => 40, 'bAddress' => 41, 'bStreetAddress' => 42, 'bCountry' => 43, 'bCity' => 44, 'bState' => 45, 'bZip' => 46, 'bPhone' => 47, 'bFax' => 48, 'bEmail' => 49, 'bUrl' => 50, 'sShippingAddress' => 51, 'sCompany' => 52, 'sName' => 53, 'sAddress' => 54, 'sStreetAddress' => 55, 'sCountry' => 56, 'sCity' => 57, 'sState' => 58, 'sZip' => 59, 'sPhone' => 60, 'sFax' => 61, 'sEmail' => 62, 'sUrl' => 63, 'sDate' => 64, 'sTerms' => 65, 'sIsShipped' => 66, ),
        self::TYPE_COLNAME       => array(PluginInvoiceTableMap::ID => 0, PluginInvoiceTableMap::UUID => 1, PluginInvoiceTableMap::ORDER_ID => 2, PluginInvoiceTableMap::FOREIGN_ID => 3, PluginInvoiceTableMap::ISSUE_DATE => 4, PluginInvoiceTableMap::DUE_DATE => 5, PluginInvoiceTableMap::CREATED => 6, PluginInvoiceTableMap::MODIFIED => 7, PluginInvoiceTableMap::STATUS => 8, PluginInvoiceTableMap::PAYMENT_METHOD => 9, PluginInvoiceTableMap::CC_TYPE => 10, PluginInvoiceTableMap::CC_NUM => 11, PluginInvoiceTableMap::CC_EXP_MONTH => 12, PluginInvoiceTableMap::CC_EXP_YEAR => 13, PluginInvoiceTableMap::CC_CODE => 14, PluginInvoiceTableMap::TXN_ID => 15, PluginInvoiceTableMap::PROCESSED_ON => 16, PluginInvoiceTableMap::SUBTOTAL => 17, PluginInvoiceTableMap::DISCOUNT => 18, PluginInvoiceTableMap::TAX => 19, PluginInvoiceTableMap::SHIPPING => 20, PluginInvoiceTableMap::TOTAL => 21, PluginInvoiceTableMap::PAID_DEPOSIT => 22, PluginInvoiceTableMap::AMOUNT_DUE => 23, PluginInvoiceTableMap::CURRENCY => 24, PluginInvoiceTableMap::NOTES => 25, PluginInvoiceTableMap::Y_LOGO => 26, PluginInvoiceTableMap::Y_COMPANY => 27, PluginInvoiceTableMap::Y_NAME => 28, PluginInvoiceTableMap::Y_STREET_ADDRESS => 29, PluginInvoiceTableMap::Y_COUNTRY => 30, PluginInvoiceTableMap::Y_CITY => 31, PluginInvoiceTableMap::Y_STATE => 32, PluginInvoiceTableMap::Y_ZIP => 33, PluginInvoiceTableMap::Y_PHONE => 34, PluginInvoiceTableMap::Y_FAX => 35, PluginInvoiceTableMap::Y_EMAIL => 36, PluginInvoiceTableMap::Y_URL => 37, PluginInvoiceTableMap::B_BILLING_ADDRESS => 38, PluginInvoiceTableMap::B_COMPANY => 39, PluginInvoiceTableMap::B_NAME => 40, PluginInvoiceTableMap::B_ADDRESS => 41, PluginInvoiceTableMap::B_STREET_ADDRESS => 42, PluginInvoiceTableMap::B_COUNTRY => 43, PluginInvoiceTableMap::B_CITY => 44, PluginInvoiceTableMap::B_STATE => 45, PluginInvoiceTableMap::B_ZIP => 46, PluginInvoiceTableMap::B_PHONE => 47, PluginInvoiceTableMap::B_FAX => 48, PluginInvoiceTableMap::B_EMAIL => 49, PluginInvoiceTableMap::B_URL => 50, PluginInvoiceTableMap::S_SHIPPING_ADDRESS => 51, PluginInvoiceTableMap::S_COMPANY => 52, PluginInvoiceTableMap::S_NAME => 53, PluginInvoiceTableMap::S_ADDRESS => 54, PluginInvoiceTableMap::S_STREET_ADDRESS => 55, PluginInvoiceTableMap::S_COUNTRY => 56, PluginInvoiceTableMap::S_CITY => 57, PluginInvoiceTableMap::S_STATE => 58, PluginInvoiceTableMap::S_ZIP => 59, PluginInvoiceTableMap::S_PHONE => 60, PluginInvoiceTableMap::S_FAX => 61, PluginInvoiceTableMap::S_EMAIL => 62, PluginInvoiceTableMap::S_URL => 63, PluginInvoiceTableMap::S_DATE => 64, PluginInvoiceTableMap::S_TERMS => 65, PluginInvoiceTableMap::S_IS_SHIPPED => 66, ),
        self::TYPE_RAW_COLNAME   => array('ID' => 0, 'UUID' => 1, 'ORDER_ID' => 2, 'FOREIGN_ID' => 3, 'ISSUE_DATE' => 4, 'DUE_DATE' => 5, 'CREATED' => 6, 'MODIFIED' => 7, 'STATUS' => 8, 'PAYMENT_METHOD' => 9, 'CC_TYPE' => 10, 'CC_NUM' => 11, 'CC_EXP_MONTH' => 12, 'CC_EXP_YEAR' => 13, 'CC_CODE' => 14, 'TXN_ID' => 15, 'PROCESSED_ON' => 16, 'SUBTOTAL' => 17, 'DISCOUNT' => 18, 'TAX' => 19, 'SHIPPING' => 20, 'TOTAL' => 21, 'PAID_DEPOSIT' => 22, 'AMOUNT_DUE' => 23, 'CURRENCY' => 24, 'NOTES' => 25, 'Y_LOGO' => 26, 'Y_COMPANY' => 27, 'Y_NAME' => 28, 'Y_STREET_ADDRESS' => 29, 'Y_COUNTRY' => 30, 'Y_CITY' => 31, 'Y_STATE' => 32, 'Y_ZIP' => 33, 'Y_PHONE' => 34, 'Y_FAX' => 35, 'Y_EMAIL' => 36, 'Y_URL' => 37, 'B_BILLING_ADDRESS' => 38, 'B_COMPANY' => 39, 'B_NAME' => 40, 'B_ADDRESS' => 41, 'B_STREET_ADDRESS' => 42, 'B_COUNTRY' => 43, 'B_CITY' => 44, 'B_STATE' => 45, 'B_ZIP' => 46, 'B_PHONE' => 47, 'B_FAX' => 48, 'B_EMAIL' => 49, 'B_URL' => 50, 'S_SHIPPING_ADDRESS' => 51, 'S_COMPANY' => 52, 'S_NAME' => 53, 'S_ADDRESS' => 54, 'S_STREET_ADDRESS' => 55, 'S_COUNTRY' => 56, 'S_CITY' => 57, 'S_STATE' => 58, 'S_ZIP' => 59, 'S_PHONE' => 60, 'S_FAX' => 61, 'S_EMAIL' => 62, 'S_URL' => 63, 'S_DATE' => 64, 'S_TERMS' => 65, 'S_IS_SHIPPED' => 66, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'uuid' => 1, 'order_id' => 2, 'foreign_id' => 3, 'issue_date' => 4, 'due_date' => 5, 'created' => 6, 'modified' => 7, 'status' => 8, 'payment_method' => 9, 'cc_type' => 10, 'cc_num' => 11, 'cc_exp_month' => 12, 'cc_exp_year' => 13, 'cc_code' => 14, 'txn_id' => 15, 'processed_on' => 16, 'subtotal' => 17, 'discount' => 18, 'tax' => 19, 'shipping' => 20, 'total' => 21, 'paid_deposit' => 22, 'amount_due' => 23, 'currency' => 24, 'notes' => 25, 'y_logo' => 26, 'y_company' => 27, 'y_name' => 28, 'y_street_address' => 29, 'y_country' => 30, 'y_city' => 31, 'y_state' => 32, 'y_zip' => 33, 'y_phone' => 34, 'y_fax' => 35, 'y_email' => 36, 'y_url' => 37, 'b_billing_address' => 38, 'b_company' => 39, 'b_name' => 40, 'b_address' => 41, 'b_street_address' => 42, 'b_country' => 43, 'b_city' => 44, 'b_state' => 45, 'b_zip' => 46, 'b_phone' => 47, 'b_fax' => 48, 'b_email' => 49, 'b_url' => 50, 's_shipping_address' => 51, 's_company' => 52, 's_name' => 53, 's_address' => 54, 's_street_address' => 55, 's_country' => 56, 's_city' => 57, 's_state' => 58, 's_zip' => 59, 's_phone' => 60, 's_fax' => 61, 's_email' => 62, 's_url' => 63, 's_date' => 64, 's_terms' => 65, 's_is_shipped' => 66, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 59, 60, 61, 62, 63, 64, 65, 66, )
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
        $this->setName('plugin_invoice');
        $this->setPhpName('PluginInvoice');
        $this->setClassName('\\HookCalendar\\Model\\PluginInvoice');
        $this->setPackage('HookCalendar.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('ID', 'Id', 'INTEGER', true, 10, null);
        $this->addColumn('UUID', 'Uuid', 'VARCHAR', false, 12, null);
        $this->addColumn('ORDER_ID', 'OrderId', 'VARCHAR', false, 12, null);
        $this->addColumn('FOREIGN_ID', 'ForeignId', 'INTEGER', false, 10, null);
        $this->addColumn('ISSUE_DATE', 'IssueDate', 'DATE', false, null, null);
        $this->addColumn('DUE_DATE', 'DueDate', 'DATE', false, null, null);
        $this->addColumn('CREATED', 'Created', 'TIMESTAMP', false, null, null);
        $this->addColumn('MODIFIED', 'Modified', 'TIMESTAMP', false, null, null);
        $this->addColumn('STATUS', 'Status', 'CHAR', false, null, null);
        $this->addColumn('PAYMENT_METHOD', 'PaymentMethod', 'CHAR', false, null, null);
        $this->addColumn('CC_TYPE', 'CcType', 'BLOB', false, null, null);
        $this->addColumn('CC_NUM', 'CcNum', 'BLOB', false, null, null);
        $this->addColumn('CC_EXP_MONTH', 'CcExpMonth', 'BLOB', false, null, null);
        $this->addColumn('CC_EXP_YEAR', 'CcExpYear', 'BLOB', false, null, null);
        $this->addColumn('CC_CODE', 'CcCode', 'BLOB', false, null, null);
        $this->addColumn('TXN_ID', 'TxnId', 'VARCHAR', false, 255, null);
        $this->addColumn('PROCESSED_ON', 'ProcessedOn', 'TIMESTAMP', false, null, null);
        $this->addColumn('SUBTOTAL', 'Subtotal', 'DECIMAL', false, 9, null);
        $this->addColumn('DISCOUNT', 'Discount', 'DECIMAL', false, 9, null);
        $this->addColumn('TAX', 'Tax', 'DECIMAL', false, 9, null);
        $this->addColumn('SHIPPING', 'Shipping', 'DECIMAL', false, 9, null);
        $this->addColumn('TOTAL', 'Total', 'DECIMAL', false, 9, null);
        $this->addColumn('PAID_DEPOSIT', 'PaidDeposit', 'DECIMAL', false, 9, null);
        $this->addColumn('AMOUNT_DUE', 'AmountDue', 'DECIMAL', false, 9, null);
        $this->addColumn('CURRENCY', 'Currency', 'VARCHAR', false, 255, null);
        $this->addColumn('NOTES', 'Notes', 'LONGVARCHAR', false, null, null);
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
        $this->addColumn('B_BILLING_ADDRESS', 'BBillingAddress', 'VARCHAR', false, 255, null);
        $this->addColumn('B_COMPANY', 'BCompany', 'VARCHAR', false, 255, null);
        $this->addColumn('B_NAME', 'BName', 'VARCHAR', false, 255, null);
        $this->addColumn('B_ADDRESS', 'BAddress', 'VARCHAR', false, 255, null);
        $this->addColumn('B_STREET_ADDRESS', 'BStreetAddress', 'VARCHAR', false, 255, null);
        $this->addColumn('B_COUNTRY', 'BCountry', 'INTEGER', false, 10, null);
        $this->addColumn('B_CITY', 'BCity', 'VARCHAR', false, 255, null);
        $this->addColumn('B_STATE', 'BState', 'VARCHAR', false, 255, null);
        $this->addColumn('B_ZIP', 'BZip', 'VARCHAR', false, 255, null);
        $this->addColumn('B_PHONE', 'BPhone', 'VARCHAR', false, 255, null);
        $this->addColumn('B_FAX', 'BFax', 'VARCHAR', false, 255, null);
        $this->addColumn('B_EMAIL', 'BEmail', 'VARCHAR', false, 255, null);
        $this->addColumn('B_URL', 'BUrl', 'VARCHAR', false, 255, null);
        $this->addColumn('S_SHIPPING_ADDRESS', 'SShippingAddress', 'VARCHAR', false, 255, null);
        $this->addColumn('S_COMPANY', 'SCompany', 'VARCHAR', false, 255, null);
        $this->addColumn('S_NAME', 'SName', 'VARCHAR', false, 255, null);
        $this->addColumn('S_ADDRESS', 'SAddress', 'VARCHAR', false, 255, null);
        $this->addColumn('S_STREET_ADDRESS', 'SStreetAddress', 'VARCHAR', false, 255, null);
        $this->addColumn('S_COUNTRY', 'SCountry', 'INTEGER', false, 10, null);
        $this->addColumn('S_CITY', 'SCity', 'VARCHAR', false, 255, null);
        $this->addColumn('S_STATE', 'SState', 'VARCHAR', false, 255, null);
        $this->addColumn('S_ZIP', 'SZip', 'VARCHAR', false, 255, null);
        $this->addColumn('S_PHONE', 'SPhone', 'VARCHAR', false, 255, null);
        $this->addColumn('S_FAX', 'SFax', 'VARCHAR', false, 255, null);
        $this->addColumn('S_EMAIL', 'SEmail', 'VARCHAR', false, 255, null);
        $this->addColumn('S_URL', 'SUrl', 'VARCHAR', false, 255, null);
        $this->addColumn('S_DATE', 'SDate', 'DATE', false, null, null);
        $this->addColumn('S_TERMS', 'STerms', 'LONGVARCHAR', false, null, null);
        $this->addColumn('S_IS_SHIPPED', 'SIsShipped', 'BOOLEAN', false, 1, false);
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
        return $withPrefix ? PluginInvoiceTableMap::CLASS_DEFAULT : PluginInvoiceTableMap::OM_CLASS;
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
     * @return array (PluginInvoice object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = PluginInvoiceTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = PluginInvoiceTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + PluginInvoiceTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = PluginInvoiceTableMap::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            PluginInvoiceTableMap::addInstanceToPool($obj, $key);
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
            $key = PluginInvoiceTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = PluginInvoiceTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                PluginInvoiceTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(PluginInvoiceTableMap::ID);
            $criteria->addSelectColumn(PluginInvoiceTableMap::UUID);
            $criteria->addSelectColumn(PluginInvoiceTableMap::ORDER_ID);
            $criteria->addSelectColumn(PluginInvoiceTableMap::FOREIGN_ID);
            $criteria->addSelectColumn(PluginInvoiceTableMap::ISSUE_DATE);
            $criteria->addSelectColumn(PluginInvoiceTableMap::DUE_DATE);
            $criteria->addSelectColumn(PluginInvoiceTableMap::CREATED);
            $criteria->addSelectColumn(PluginInvoiceTableMap::MODIFIED);
            $criteria->addSelectColumn(PluginInvoiceTableMap::STATUS);
            $criteria->addSelectColumn(PluginInvoiceTableMap::PAYMENT_METHOD);
            $criteria->addSelectColumn(PluginInvoiceTableMap::CC_TYPE);
            $criteria->addSelectColumn(PluginInvoiceTableMap::CC_NUM);
            $criteria->addSelectColumn(PluginInvoiceTableMap::CC_EXP_MONTH);
            $criteria->addSelectColumn(PluginInvoiceTableMap::CC_EXP_YEAR);
            $criteria->addSelectColumn(PluginInvoiceTableMap::CC_CODE);
            $criteria->addSelectColumn(PluginInvoiceTableMap::TXN_ID);
            $criteria->addSelectColumn(PluginInvoiceTableMap::PROCESSED_ON);
            $criteria->addSelectColumn(PluginInvoiceTableMap::SUBTOTAL);
            $criteria->addSelectColumn(PluginInvoiceTableMap::DISCOUNT);
            $criteria->addSelectColumn(PluginInvoiceTableMap::TAX);
            $criteria->addSelectColumn(PluginInvoiceTableMap::SHIPPING);
            $criteria->addSelectColumn(PluginInvoiceTableMap::TOTAL);
            $criteria->addSelectColumn(PluginInvoiceTableMap::PAID_DEPOSIT);
            $criteria->addSelectColumn(PluginInvoiceTableMap::AMOUNT_DUE);
            $criteria->addSelectColumn(PluginInvoiceTableMap::CURRENCY);
            $criteria->addSelectColumn(PluginInvoiceTableMap::NOTES);
            $criteria->addSelectColumn(PluginInvoiceTableMap::Y_LOGO);
            $criteria->addSelectColumn(PluginInvoiceTableMap::Y_COMPANY);
            $criteria->addSelectColumn(PluginInvoiceTableMap::Y_NAME);
            $criteria->addSelectColumn(PluginInvoiceTableMap::Y_STREET_ADDRESS);
            $criteria->addSelectColumn(PluginInvoiceTableMap::Y_COUNTRY);
            $criteria->addSelectColumn(PluginInvoiceTableMap::Y_CITY);
            $criteria->addSelectColumn(PluginInvoiceTableMap::Y_STATE);
            $criteria->addSelectColumn(PluginInvoiceTableMap::Y_ZIP);
            $criteria->addSelectColumn(PluginInvoiceTableMap::Y_PHONE);
            $criteria->addSelectColumn(PluginInvoiceTableMap::Y_FAX);
            $criteria->addSelectColumn(PluginInvoiceTableMap::Y_EMAIL);
            $criteria->addSelectColumn(PluginInvoiceTableMap::Y_URL);
            $criteria->addSelectColumn(PluginInvoiceTableMap::B_BILLING_ADDRESS);
            $criteria->addSelectColumn(PluginInvoiceTableMap::B_COMPANY);
            $criteria->addSelectColumn(PluginInvoiceTableMap::B_NAME);
            $criteria->addSelectColumn(PluginInvoiceTableMap::B_ADDRESS);
            $criteria->addSelectColumn(PluginInvoiceTableMap::B_STREET_ADDRESS);
            $criteria->addSelectColumn(PluginInvoiceTableMap::B_COUNTRY);
            $criteria->addSelectColumn(PluginInvoiceTableMap::B_CITY);
            $criteria->addSelectColumn(PluginInvoiceTableMap::B_STATE);
            $criteria->addSelectColumn(PluginInvoiceTableMap::B_ZIP);
            $criteria->addSelectColumn(PluginInvoiceTableMap::B_PHONE);
            $criteria->addSelectColumn(PluginInvoiceTableMap::B_FAX);
            $criteria->addSelectColumn(PluginInvoiceTableMap::B_EMAIL);
            $criteria->addSelectColumn(PluginInvoiceTableMap::B_URL);
            $criteria->addSelectColumn(PluginInvoiceTableMap::S_SHIPPING_ADDRESS);
            $criteria->addSelectColumn(PluginInvoiceTableMap::S_COMPANY);
            $criteria->addSelectColumn(PluginInvoiceTableMap::S_NAME);
            $criteria->addSelectColumn(PluginInvoiceTableMap::S_ADDRESS);
            $criteria->addSelectColumn(PluginInvoiceTableMap::S_STREET_ADDRESS);
            $criteria->addSelectColumn(PluginInvoiceTableMap::S_COUNTRY);
            $criteria->addSelectColumn(PluginInvoiceTableMap::S_CITY);
            $criteria->addSelectColumn(PluginInvoiceTableMap::S_STATE);
            $criteria->addSelectColumn(PluginInvoiceTableMap::S_ZIP);
            $criteria->addSelectColumn(PluginInvoiceTableMap::S_PHONE);
            $criteria->addSelectColumn(PluginInvoiceTableMap::S_FAX);
            $criteria->addSelectColumn(PluginInvoiceTableMap::S_EMAIL);
            $criteria->addSelectColumn(PluginInvoiceTableMap::S_URL);
            $criteria->addSelectColumn(PluginInvoiceTableMap::S_DATE);
            $criteria->addSelectColumn(PluginInvoiceTableMap::S_TERMS);
            $criteria->addSelectColumn(PluginInvoiceTableMap::S_IS_SHIPPED);
        } else {
            $criteria->addSelectColumn($alias . '.ID');
            $criteria->addSelectColumn($alias . '.UUID');
            $criteria->addSelectColumn($alias . '.ORDER_ID');
            $criteria->addSelectColumn($alias . '.FOREIGN_ID');
            $criteria->addSelectColumn($alias . '.ISSUE_DATE');
            $criteria->addSelectColumn($alias . '.DUE_DATE');
            $criteria->addSelectColumn($alias . '.CREATED');
            $criteria->addSelectColumn($alias . '.MODIFIED');
            $criteria->addSelectColumn($alias . '.STATUS');
            $criteria->addSelectColumn($alias . '.PAYMENT_METHOD');
            $criteria->addSelectColumn($alias . '.CC_TYPE');
            $criteria->addSelectColumn($alias . '.CC_NUM');
            $criteria->addSelectColumn($alias . '.CC_EXP_MONTH');
            $criteria->addSelectColumn($alias . '.CC_EXP_YEAR');
            $criteria->addSelectColumn($alias . '.CC_CODE');
            $criteria->addSelectColumn($alias . '.TXN_ID');
            $criteria->addSelectColumn($alias . '.PROCESSED_ON');
            $criteria->addSelectColumn($alias . '.SUBTOTAL');
            $criteria->addSelectColumn($alias . '.DISCOUNT');
            $criteria->addSelectColumn($alias . '.TAX');
            $criteria->addSelectColumn($alias . '.SHIPPING');
            $criteria->addSelectColumn($alias . '.TOTAL');
            $criteria->addSelectColumn($alias . '.PAID_DEPOSIT');
            $criteria->addSelectColumn($alias . '.AMOUNT_DUE');
            $criteria->addSelectColumn($alias . '.CURRENCY');
            $criteria->addSelectColumn($alias . '.NOTES');
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
            $criteria->addSelectColumn($alias . '.B_BILLING_ADDRESS');
            $criteria->addSelectColumn($alias . '.B_COMPANY');
            $criteria->addSelectColumn($alias . '.B_NAME');
            $criteria->addSelectColumn($alias . '.B_ADDRESS');
            $criteria->addSelectColumn($alias . '.B_STREET_ADDRESS');
            $criteria->addSelectColumn($alias . '.B_COUNTRY');
            $criteria->addSelectColumn($alias . '.B_CITY');
            $criteria->addSelectColumn($alias . '.B_STATE');
            $criteria->addSelectColumn($alias . '.B_ZIP');
            $criteria->addSelectColumn($alias . '.B_PHONE');
            $criteria->addSelectColumn($alias . '.B_FAX');
            $criteria->addSelectColumn($alias . '.B_EMAIL');
            $criteria->addSelectColumn($alias . '.B_URL');
            $criteria->addSelectColumn($alias . '.S_SHIPPING_ADDRESS');
            $criteria->addSelectColumn($alias . '.S_COMPANY');
            $criteria->addSelectColumn($alias . '.S_NAME');
            $criteria->addSelectColumn($alias . '.S_ADDRESS');
            $criteria->addSelectColumn($alias . '.S_STREET_ADDRESS');
            $criteria->addSelectColumn($alias . '.S_COUNTRY');
            $criteria->addSelectColumn($alias . '.S_CITY');
            $criteria->addSelectColumn($alias . '.S_STATE');
            $criteria->addSelectColumn($alias . '.S_ZIP');
            $criteria->addSelectColumn($alias . '.S_PHONE');
            $criteria->addSelectColumn($alias . '.S_FAX');
            $criteria->addSelectColumn($alias . '.S_EMAIL');
            $criteria->addSelectColumn($alias . '.S_URL');
            $criteria->addSelectColumn($alias . '.S_DATE');
            $criteria->addSelectColumn($alias . '.S_TERMS');
            $criteria->addSelectColumn($alias . '.S_IS_SHIPPED');
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
        return Propel::getServiceContainer()->getDatabaseMap(PluginInvoiceTableMap::DATABASE_NAME)->getTable(PluginInvoiceTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getServiceContainer()->getDatabaseMap(PluginInvoiceTableMap::DATABASE_NAME);
      if (!$dbMap->hasTable(PluginInvoiceTableMap::TABLE_NAME)) {
        $dbMap->addTableObject(new PluginInvoiceTableMap());
      }
    }

    /**
     * Performs a DELETE on the database, given a PluginInvoice or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or PluginInvoice object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(PluginInvoiceTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \HookCalendar\Model\PluginInvoice) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(PluginInvoiceTableMap::DATABASE_NAME);
            $criteria->add(PluginInvoiceTableMap::ID, (array) $values, Criteria::IN);
        }

        $query = PluginInvoiceQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) { PluginInvoiceTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) { PluginInvoiceTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the plugin_invoice table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return PluginInvoiceQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a PluginInvoice or Criteria object.
     *
     * @param mixed               $criteria Criteria or PluginInvoice object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PluginInvoiceTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from PluginInvoice object
        }

        if ($criteria->containsKey(PluginInvoiceTableMap::ID) && $criteria->keyContainsValue(PluginInvoiceTableMap::ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.PluginInvoiceTableMap::ID.')');
        }


        // Set the correct dbName
        $query = PluginInvoiceQuery::create()->mergeWith($criteria);

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

} // PluginInvoiceTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
PluginInvoiceTableMap::buildTableMap();
