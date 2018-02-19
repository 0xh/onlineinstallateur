<?php

namespace OfferCreation\Model\Map;

use OfferCreation\Model\OfferVersion;
use OfferCreation\Model\OfferVersionQuery;
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
 * This class defines the structure of the 'offer_version' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class OfferVersionTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;
    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'OfferCreation.Model.Map.OfferVersionTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'thelia';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'offer_version';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\OfferCreation\\Model\\OfferVersion';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'OfferCreation.Model.OfferVersion';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 31;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 31;

    /**
     * the column name for the ID field
     */
    const ID = 'offer_version.ID';

    /**
     * the column name for the REF field
     */
    const REF = 'offer_version.REF';

    /**
     * the column name for the ORDER_ID field
     */
    const ORDER_ID = 'offer_version.ORDER_ID';

    /**
     * the column name for the ORDER_REF field
     */
    const ORDER_REF = 'offer_version.ORDER_REF';

    /**
     * the column name for the CUSTOMER_ID field
     */
    const CUSTOMER_ID = 'offer_version.CUSTOMER_ID';

    /**
     * the column name for the EMPLOYEE_ID field
     */
    const EMPLOYEE_ID = 'offer_version.EMPLOYEE_ID';

    /**
     * the column name for the INVOICE_ORDER_ADDRESS_ID field
     */
    const INVOICE_ORDER_ADDRESS_ID = 'offer_version.INVOICE_ORDER_ADDRESS_ID';

    /**
     * the column name for the DELIVERY_ORDER_ADDRESS_ID field
     */
    const DELIVERY_ORDER_ADDRESS_ID = 'offer_version.DELIVERY_ORDER_ADDRESS_ID';

    /**
     * the column name for the INVOICE_DATE field
     */
    const INVOICE_DATE = 'offer_version.INVOICE_DATE';

    /**
     * the column name for the CURRENCY_ID field
     */
    const CURRENCY_ID = 'offer_version.CURRENCY_ID';

    /**
     * the column name for the CURRENCY_RATE field
     */
    const CURRENCY_RATE = 'offer_version.CURRENCY_RATE';

    /**
     * the column name for the TRANSACTION_REF field
     */
    const TRANSACTION_REF = 'offer_version.TRANSACTION_REF';

    /**
     * the column name for the DELIVERY_REF field
     */
    const DELIVERY_REF = 'offer_version.DELIVERY_REF';

    /**
     * the column name for the INVOICE_REF field
     */
    const INVOICE_REF = 'offer_version.INVOICE_REF';

    /**
     * the column name for the DISCOUNT field
     */
    const DISCOUNT = 'offer_version.DISCOUNT';

    /**
     * the column name for the POSTAGE field
     */
    const POSTAGE = 'offer_version.POSTAGE';

    /**
     * the column name for the POSTAGE_TAX field
     */
    const POSTAGE_TAX = 'offer_version.POSTAGE_TAX';

    /**
     * the column name for the POSTAGE_TAX_RULE_TITLE field
     */
    const POSTAGE_TAX_RULE_TITLE = 'offer_version.POSTAGE_TAX_RULE_TITLE';

    /**
     * the column name for the PAYMENT_MODULE_ID field
     */
    const PAYMENT_MODULE_ID = 'offer_version.PAYMENT_MODULE_ID';

    /**
     * the column name for the DELIVERY_MODULE_ID field
     */
    const DELIVERY_MODULE_ID = 'offer_version.DELIVERY_MODULE_ID';

    /**
     * the column name for the STATUS_ID field
     */
    const STATUS_ID = 'offer_version.STATUS_ID';

    /**
     * the column name for the LANG_ID field
     */
    const LANG_ID = 'offer_version.LANG_ID';

    /**
     * the column name for the CART_ID field
     */
    const CART_ID = 'offer_version.CART_ID';

    /**
     * the column name for the CREATED_AT field
     */
    const CREATED_AT = 'offer_version.CREATED_AT';

    /**
     * the column name for the UPDATED_AT field
     */
    const UPDATED_AT = 'offer_version.UPDATED_AT';

    /**
     * the column name for the VERSION field
     */
    const VERSION = 'offer_version.VERSION';

    /**
     * the column name for the VERSION_CREATED_AT field
     */
    const VERSION_CREATED_AT = 'offer_version.VERSION_CREATED_AT';

    /**
     * the column name for the VERSION_CREATED_BY field
     */
    const VERSION_CREATED_BY = 'offer_version.VERSION_CREATED_BY';

    /**
     * the column name for the NOTE_EMPLOYEE field
     */
    const NOTE_EMPLOYEE = 'offer_version.NOTE_EMPLOYEE';

    /**
     * the column name for the CHAT_ID field
     */
    const CHAT_ID = 'offer_version.CHAT_ID';

    /**
     * the column name for the CUSTOMER_ID_VERSION field
     */
    const CUSTOMER_ID_VERSION = 'offer_version.CUSTOMER_ID_VERSION';

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
        self::TYPE_PHPNAME       => array('Id', 'Ref', 'OrderId', 'OrderRef', 'CustomerId', 'EmployeeId', 'InvoiceOrderAddressId', 'DeliveryOrderAddressId', 'InvoiceDate', 'CurrencyId', 'CurrencyRate', 'TransactionRef', 'DeliveryRef', 'InvoiceRef', 'Discount', 'Postage', 'PostageTax', 'PostageTaxRuleTitle', 'PaymentModuleId', 'DeliveryModuleId', 'StatusId', 'LangId', 'CartId', 'CreatedAt', 'UpdatedAt', 'Version', 'VersionCreatedAt', 'VersionCreatedBy', 'NoteEmployee', 'ChatId', 'CustomerIdVersion', ),
        self::TYPE_STUDLYPHPNAME => array('id', 'ref', 'orderId', 'orderRef', 'customerId', 'employeeId', 'invoiceOrderAddressId', 'deliveryOrderAddressId', 'invoiceDate', 'currencyId', 'currencyRate', 'transactionRef', 'deliveryRef', 'invoiceRef', 'discount', 'postage', 'postageTax', 'postageTaxRuleTitle', 'paymentModuleId', 'deliveryModuleId', 'statusId', 'langId', 'cartId', 'createdAt', 'updatedAt', 'version', 'versionCreatedAt', 'versionCreatedBy', 'noteEmployee', 'chatId', 'customerIdVersion', ),
        self::TYPE_COLNAME       => array(OfferVersionTableMap::ID, OfferVersionTableMap::REF, OfferVersionTableMap::ORDER_ID, OfferVersionTableMap::ORDER_REF, OfferVersionTableMap::CUSTOMER_ID, OfferVersionTableMap::EMPLOYEE_ID, OfferVersionTableMap::INVOICE_ORDER_ADDRESS_ID, OfferVersionTableMap::DELIVERY_ORDER_ADDRESS_ID, OfferVersionTableMap::INVOICE_DATE, OfferVersionTableMap::CURRENCY_ID, OfferVersionTableMap::CURRENCY_RATE, OfferVersionTableMap::TRANSACTION_REF, OfferVersionTableMap::DELIVERY_REF, OfferVersionTableMap::INVOICE_REF, OfferVersionTableMap::DISCOUNT, OfferVersionTableMap::POSTAGE, OfferVersionTableMap::POSTAGE_TAX, OfferVersionTableMap::POSTAGE_TAX_RULE_TITLE, OfferVersionTableMap::PAYMENT_MODULE_ID, OfferVersionTableMap::DELIVERY_MODULE_ID, OfferVersionTableMap::STATUS_ID, OfferVersionTableMap::LANG_ID, OfferVersionTableMap::CART_ID, OfferVersionTableMap::CREATED_AT, OfferVersionTableMap::UPDATED_AT, OfferVersionTableMap::VERSION, OfferVersionTableMap::VERSION_CREATED_AT, OfferVersionTableMap::VERSION_CREATED_BY, OfferVersionTableMap::NOTE_EMPLOYEE, OfferVersionTableMap::CHAT_ID, OfferVersionTableMap::CUSTOMER_ID_VERSION, ),
        self::TYPE_RAW_COLNAME   => array('ID', 'REF', 'ORDER_ID', 'ORDER_REF', 'CUSTOMER_ID', 'EMPLOYEE_ID', 'INVOICE_ORDER_ADDRESS_ID', 'DELIVERY_ORDER_ADDRESS_ID', 'INVOICE_DATE', 'CURRENCY_ID', 'CURRENCY_RATE', 'TRANSACTION_REF', 'DELIVERY_REF', 'INVOICE_REF', 'DISCOUNT', 'POSTAGE', 'POSTAGE_TAX', 'POSTAGE_TAX_RULE_TITLE', 'PAYMENT_MODULE_ID', 'DELIVERY_MODULE_ID', 'STATUS_ID', 'LANG_ID', 'CART_ID', 'CREATED_AT', 'UPDATED_AT', 'VERSION', 'VERSION_CREATED_AT', 'VERSION_CREATED_BY', 'NOTE_EMPLOYEE', 'CHAT_ID', 'CUSTOMER_ID_VERSION', ),
        self::TYPE_FIELDNAME     => array('id', 'ref', 'order_id', 'order_ref', 'customer_id', 'employee_id', 'invoice_order_address_id', 'delivery_order_address_id', 'invoice_date', 'currency_id', 'currency_rate', 'transaction_ref', 'delivery_ref', 'invoice_ref', 'discount', 'postage', 'postage_tax', 'postage_tax_rule_title', 'payment_module_id', 'delivery_module_id', 'status_id', 'lang_id', 'cart_id', 'created_at', 'updated_at', 'version', 'version_created_at', 'version_created_by', 'note_employee', 'chat_id', 'customer_id_version', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'Ref' => 1, 'OrderId' => 2, 'OrderRef' => 3, 'CustomerId' => 4, 'EmployeeId' => 5, 'InvoiceOrderAddressId' => 6, 'DeliveryOrderAddressId' => 7, 'InvoiceDate' => 8, 'CurrencyId' => 9, 'CurrencyRate' => 10, 'TransactionRef' => 11, 'DeliveryRef' => 12, 'InvoiceRef' => 13, 'Discount' => 14, 'Postage' => 15, 'PostageTax' => 16, 'PostageTaxRuleTitle' => 17, 'PaymentModuleId' => 18, 'DeliveryModuleId' => 19, 'StatusId' => 20, 'LangId' => 21, 'CartId' => 22, 'CreatedAt' => 23, 'UpdatedAt' => 24, 'Version' => 25, 'VersionCreatedAt' => 26, 'VersionCreatedBy' => 27, 'NoteEmployee' => 28, 'ChatId' => 29, 'CustomerIdVersion' => 30, ),
        self::TYPE_STUDLYPHPNAME => array('id' => 0, 'ref' => 1, 'orderId' => 2, 'orderRef' => 3, 'customerId' => 4, 'employeeId' => 5, 'invoiceOrderAddressId' => 6, 'deliveryOrderAddressId' => 7, 'invoiceDate' => 8, 'currencyId' => 9, 'currencyRate' => 10, 'transactionRef' => 11, 'deliveryRef' => 12, 'invoiceRef' => 13, 'discount' => 14, 'postage' => 15, 'postageTax' => 16, 'postageTaxRuleTitle' => 17, 'paymentModuleId' => 18, 'deliveryModuleId' => 19, 'statusId' => 20, 'langId' => 21, 'cartId' => 22, 'createdAt' => 23, 'updatedAt' => 24, 'version' => 25, 'versionCreatedAt' => 26, 'versionCreatedBy' => 27, 'noteEmployee' => 28, 'chatId' => 29, 'customerIdVersion' => 30, ),
        self::TYPE_COLNAME       => array(OfferVersionTableMap::ID => 0, OfferVersionTableMap::REF => 1, OfferVersionTableMap::ORDER_ID => 2, OfferVersionTableMap::ORDER_REF => 3, OfferVersionTableMap::CUSTOMER_ID => 4, OfferVersionTableMap::EMPLOYEE_ID => 5, OfferVersionTableMap::INVOICE_ORDER_ADDRESS_ID => 6, OfferVersionTableMap::DELIVERY_ORDER_ADDRESS_ID => 7, OfferVersionTableMap::INVOICE_DATE => 8, OfferVersionTableMap::CURRENCY_ID => 9, OfferVersionTableMap::CURRENCY_RATE => 10, OfferVersionTableMap::TRANSACTION_REF => 11, OfferVersionTableMap::DELIVERY_REF => 12, OfferVersionTableMap::INVOICE_REF => 13, OfferVersionTableMap::DISCOUNT => 14, OfferVersionTableMap::POSTAGE => 15, OfferVersionTableMap::POSTAGE_TAX => 16, OfferVersionTableMap::POSTAGE_TAX_RULE_TITLE => 17, OfferVersionTableMap::PAYMENT_MODULE_ID => 18, OfferVersionTableMap::DELIVERY_MODULE_ID => 19, OfferVersionTableMap::STATUS_ID => 20, OfferVersionTableMap::LANG_ID => 21, OfferVersionTableMap::CART_ID => 22, OfferVersionTableMap::CREATED_AT => 23, OfferVersionTableMap::UPDATED_AT => 24, OfferVersionTableMap::VERSION => 25, OfferVersionTableMap::VERSION_CREATED_AT => 26, OfferVersionTableMap::VERSION_CREATED_BY => 27, OfferVersionTableMap::NOTE_EMPLOYEE => 28, OfferVersionTableMap::CHAT_ID => 29, OfferVersionTableMap::CUSTOMER_ID_VERSION => 30, ),
        self::TYPE_RAW_COLNAME   => array('ID' => 0, 'REF' => 1, 'ORDER_ID' => 2, 'ORDER_REF' => 3, 'CUSTOMER_ID' => 4, 'EMPLOYEE_ID' => 5, 'INVOICE_ORDER_ADDRESS_ID' => 6, 'DELIVERY_ORDER_ADDRESS_ID' => 7, 'INVOICE_DATE' => 8, 'CURRENCY_ID' => 9, 'CURRENCY_RATE' => 10, 'TRANSACTION_REF' => 11, 'DELIVERY_REF' => 12, 'INVOICE_REF' => 13, 'DISCOUNT' => 14, 'POSTAGE' => 15, 'POSTAGE_TAX' => 16, 'POSTAGE_TAX_RULE_TITLE' => 17, 'PAYMENT_MODULE_ID' => 18, 'DELIVERY_MODULE_ID' => 19, 'STATUS_ID' => 20, 'LANG_ID' => 21, 'CART_ID' => 22, 'CREATED_AT' => 23, 'UPDATED_AT' => 24, 'VERSION' => 25, 'VERSION_CREATED_AT' => 26, 'VERSION_CREATED_BY' => 27, 'NOTE_EMPLOYEE' => 28, 'CHAT_ID' => 29, 'CUSTOMER_ID_VERSION' => 30, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'ref' => 1, 'order_id' => 2, 'order_ref' => 3, 'customer_id' => 4, 'employee_id' => 5, 'invoice_order_address_id' => 6, 'delivery_order_address_id' => 7, 'invoice_date' => 8, 'currency_id' => 9, 'currency_rate' => 10, 'transaction_ref' => 11, 'delivery_ref' => 12, 'invoice_ref' => 13, 'discount' => 14, 'postage' => 15, 'postage_tax' => 16, 'postage_tax_rule_title' => 17, 'payment_module_id' => 18, 'delivery_module_id' => 19, 'status_id' => 20, 'lang_id' => 21, 'cart_id' => 22, 'created_at' => 23, 'updated_at' => 24, 'version' => 25, 'version_created_at' => 26, 'version_created_by' => 27, 'note_employee' => 28, 'chat_id' => 29, 'customer_id_version' => 30, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, )
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
        $this->setName('offer_version');
        $this->setPhpName('OfferVersion');
        $this->setClassName('\\OfferCreation\\Model\\OfferVersion');
        $this->setPackage('OfferCreation.Model');
        $this->setUseIdGenerator(false);
        // columns
        $this->addForeignPrimaryKey('ID', 'Id', 'INTEGER' , 'offer', 'ID', true, null, null);
        $this->addColumn('REF', 'Ref', 'VARCHAR', false, 45, null);
        $this->addColumn('ORDER_ID', 'OrderId', 'INTEGER', false, null, null);
        $this->addColumn('ORDER_REF', 'OrderRef', 'VARCHAR', false, 45, null);
        $this->addColumn('CUSTOMER_ID', 'CustomerId', 'INTEGER', true, null, null);
        $this->addColumn('EMPLOYEE_ID', 'EmployeeId', 'INTEGER', true, null, null);
        $this->addColumn('INVOICE_ORDER_ADDRESS_ID', 'InvoiceOrderAddressId', 'INTEGER', true, null, null);
        $this->addColumn('DELIVERY_ORDER_ADDRESS_ID', 'DeliveryOrderAddressId', 'INTEGER', true, null, null);
        $this->addColumn('INVOICE_DATE', 'InvoiceDate', 'TIMESTAMP', false, null, null);
        $this->addColumn('CURRENCY_ID', 'CurrencyId', 'INTEGER', true, null, null);
        $this->addColumn('CURRENCY_RATE', 'CurrencyRate', 'FLOAT', true, null, null);
        $this->addColumn('TRANSACTION_REF', 'TransactionRef', 'VARCHAR', false, 100, null);
        $this->addColumn('DELIVERY_REF', 'DeliveryRef', 'VARCHAR', false, 100, null);
        $this->addColumn('INVOICE_REF', 'InvoiceRef', 'VARCHAR', false, 100, null);
        $this->addColumn('DISCOUNT', 'Discount', 'DECIMAL', false, 16, 0);
        $this->addColumn('POSTAGE', 'Postage', 'DECIMAL', true, 16, 0);
        $this->addColumn('POSTAGE_TAX', 'PostageTax', 'DECIMAL', true, 16, 0);
        $this->addColumn('POSTAGE_TAX_RULE_TITLE', 'PostageTaxRuleTitle', 'VARCHAR', false, 255, null);
        $this->addColumn('PAYMENT_MODULE_ID', 'PaymentModuleId', 'INTEGER', true, null, null);
        $this->addColumn('DELIVERY_MODULE_ID', 'DeliveryModuleId', 'INTEGER', true, null, null);
        $this->addColumn('STATUS_ID', 'StatusId', 'INTEGER', true, null, null);
        $this->addColumn('LANG_ID', 'LangId', 'INTEGER', true, null, null);
        $this->addColumn('CART_ID', 'CartId', 'INTEGER', true, null, null);
        $this->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('UPDATED_AT', 'UpdatedAt', 'TIMESTAMP', false, null, null);
        $this->addPrimaryKey('VERSION', 'Version', 'INTEGER', true, null, 0);
        $this->addColumn('VERSION_CREATED_AT', 'VersionCreatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('VERSION_CREATED_BY', 'VersionCreatedBy', 'VARCHAR', false, 100, null);
        $this->addColumn('NOTE_EMPLOYEE', 'NoteEmployee', 'CLOB', false, null, null);
        $this->addColumn('CHAT_ID', 'ChatId', 'INTEGER', false, null, null);
        $this->addColumn('CUSTOMER_ID_VERSION', 'CustomerIdVersion', 'INTEGER', false, null, 0);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Offer', '\\OfferCreation\\Model\\Offer', RelationMap::MANY_TO_ONE, array('id' => 'id', ), 'CASCADE', null);
    } // buildRelations()

    /**
     * Adds an object to the instance pool.
     *
     * Propel keeps cached copies of objects in an instance pool when they are retrieved
     * from the database. In some cases you may need to explicitly add objects
     * to the cache in order to ensure that the same objects are always returned by find*()
     * and findPk*() calls.
     *
     * @param \OfferCreation\Model\OfferVersion $obj A \OfferCreation\Model\OfferVersion object.
     * @param string $key             (optional) key to use for instance map (for performance boost if key was already calculated externally).
     */
    public static function addInstanceToPool($obj, $key = null)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if (null === $key) {
                $key = serialize(array((string) $obj->getId(), (string) $obj->getVersion()));
            } // if key === null
            self::$instances[$key] = $obj;
        }
    }

    /**
     * Removes an object from the instance pool.
     *
     * Propel keeps cached copies of objects in an instance pool when they are retrieved
     * from the database.  In some cases -- especially when you override doDelete
     * methods in your stub classes -- you may need to explicitly remove objects
     * from the cache in order to prevent returning objects that no longer exist.
     *
     * @param mixed $value A \OfferCreation\Model\OfferVersion object or a primary key value.
     */
    public static function removeInstanceFromPool($value)
    {
        if (Propel::isInstancePoolingEnabled() && null !== $value) {
            if (is_object($value) && $value instanceof \OfferCreation\Model\OfferVersion) {
                $key = serialize(array((string) $value->getId(), (string) $value->getVersion()));

            } elseif (is_array($value) && count($value) === 2) {
                // assume we've been passed a primary key";
                $key = serialize(array((string) $value[0], (string) $value[1]));
            } elseif ($value instanceof Criteria) {
                self::$instances = [];

                return;
            } else {
                $e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or \OfferCreation\Model\OfferVersion object; got " . (is_object($value) ? get_class($value) . ' object.' : var_export($value, true)));
                throw $e;
            }

            unset(self::$instances[$key]);
        }
    }

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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] === null && $row[TableMap::TYPE_NUM == $indexType ? 25 + $offset : static::translateFieldName('Version', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return serialize(array((string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)], (string) $row[TableMap::TYPE_NUM == $indexType ? 25 + $offset : static::translateFieldName('Version', TableMap::TYPE_PHPNAME, $indexType)]));
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

            return $pks;
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
        return $withPrefix ? OfferVersionTableMap::CLASS_DEFAULT : OfferVersionTableMap::OM_CLASS;
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
     * @return array (OfferVersion object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = OfferVersionTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = OfferVersionTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + OfferVersionTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = OfferVersionTableMap::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            OfferVersionTableMap::addInstanceToPool($obj, $key);
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
            $key = OfferVersionTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = OfferVersionTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                OfferVersionTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(OfferVersionTableMap::ID);
            $criteria->addSelectColumn(OfferVersionTableMap::REF);
            $criteria->addSelectColumn(OfferVersionTableMap::ORDER_ID);
            $criteria->addSelectColumn(OfferVersionTableMap::ORDER_REF);
            $criteria->addSelectColumn(OfferVersionTableMap::CUSTOMER_ID);
            $criteria->addSelectColumn(OfferVersionTableMap::EMPLOYEE_ID);
            $criteria->addSelectColumn(OfferVersionTableMap::INVOICE_ORDER_ADDRESS_ID);
            $criteria->addSelectColumn(OfferVersionTableMap::DELIVERY_ORDER_ADDRESS_ID);
            $criteria->addSelectColumn(OfferVersionTableMap::INVOICE_DATE);
            $criteria->addSelectColumn(OfferVersionTableMap::CURRENCY_ID);
            $criteria->addSelectColumn(OfferVersionTableMap::CURRENCY_RATE);
            $criteria->addSelectColumn(OfferVersionTableMap::TRANSACTION_REF);
            $criteria->addSelectColumn(OfferVersionTableMap::DELIVERY_REF);
            $criteria->addSelectColumn(OfferVersionTableMap::INVOICE_REF);
            $criteria->addSelectColumn(OfferVersionTableMap::DISCOUNT);
            $criteria->addSelectColumn(OfferVersionTableMap::POSTAGE);
            $criteria->addSelectColumn(OfferVersionTableMap::POSTAGE_TAX);
            $criteria->addSelectColumn(OfferVersionTableMap::POSTAGE_TAX_RULE_TITLE);
            $criteria->addSelectColumn(OfferVersionTableMap::PAYMENT_MODULE_ID);
            $criteria->addSelectColumn(OfferVersionTableMap::DELIVERY_MODULE_ID);
            $criteria->addSelectColumn(OfferVersionTableMap::STATUS_ID);
            $criteria->addSelectColumn(OfferVersionTableMap::LANG_ID);
            $criteria->addSelectColumn(OfferVersionTableMap::CART_ID);
            $criteria->addSelectColumn(OfferVersionTableMap::CREATED_AT);
            $criteria->addSelectColumn(OfferVersionTableMap::UPDATED_AT);
            $criteria->addSelectColumn(OfferVersionTableMap::VERSION);
            $criteria->addSelectColumn(OfferVersionTableMap::VERSION_CREATED_AT);
            $criteria->addSelectColumn(OfferVersionTableMap::VERSION_CREATED_BY);
            $criteria->addSelectColumn(OfferVersionTableMap::NOTE_EMPLOYEE);
            $criteria->addSelectColumn(OfferVersionTableMap::CHAT_ID);
            $criteria->addSelectColumn(OfferVersionTableMap::CUSTOMER_ID_VERSION);
        } else {
            $criteria->addSelectColumn($alias . '.ID');
            $criteria->addSelectColumn($alias . '.REF');
            $criteria->addSelectColumn($alias . '.ORDER_ID');
            $criteria->addSelectColumn($alias . '.ORDER_REF');
            $criteria->addSelectColumn($alias . '.CUSTOMER_ID');
            $criteria->addSelectColumn($alias . '.EMPLOYEE_ID');
            $criteria->addSelectColumn($alias . '.INVOICE_ORDER_ADDRESS_ID');
            $criteria->addSelectColumn($alias . '.DELIVERY_ORDER_ADDRESS_ID');
            $criteria->addSelectColumn($alias . '.INVOICE_DATE');
            $criteria->addSelectColumn($alias . '.CURRENCY_ID');
            $criteria->addSelectColumn($alias . '.CURRENCY_RATE');
            $criteria->addSelectColumn($alias . '.TRANSACTION_REF');
            $criteria->addSelectColumn($alias . '.DELIVERY_REF');
            $criteria->addSelectColumn($alias . '.INVOICE_REF');
            $criteria->addSelectColumn($alias . '.DISCOUNT');
            $criteria->addSelectColumn($alias . '.POSTAGE');
            $criteria->addSelectColumn($alias . '.POSTAGE_TAX');
            $criteria->addSelectColumn($alias . '.POSTAGE_TAX_RULE_TITLE');
            $criteria->addSelectColumn($alias . '.PAYMENT_MODULE_ID');
            $criteria->addSelectColumn($alias . '.DELIVERY_MODULE_ID');
            $criteria->addSelectColumn($alias . '.STATUS_ID');
            $criteria->addSelectColumn($alias . '.LANG_ID');
            $criteria->addSelectColumn($alias . '.CART_ID');
            $criteria->addSelectColumn($alias . '.CREATED_AT');
            $criteria->addSelectColumn($alias . '.UPDATED_AT');
            $criteria->addSelectColumn($alias . '.VERSION');
            $criteria->addSelectColumn($alias . '.VERSION_CREATED_AT');
            $criteria->addSelectColumn($alias . '.VERSION_CREATED_BY');
            $criteria->addSelectColumn($alias . '.NOTE_EMPLOYEE');
            $criteria->addSelectColumn($alias . '.CHAT_ID');
            $criteria->addSelectColumn($alias . '.CUSTOMER_ID_VERSION');
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
        return Propel::getServiceContainer()->getDatabaseMap(OfferVersionTableMap::DATABASE_NAME)->getTable(OfferVersionTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getServiceContainer()->getDatabaseMap(OfferVersionTableMap::DATABASE_NAME);
      if (!$dbMap->hasTable(OfferVersionTableMap::TABLE_NAME)) {
        $dbMap->addTableObject(new OfferVersionTableMap());
      }
    }

    /**
     * Performs a DELETE on the database, given a OfferVersion or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or OfferVersion object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(OfferVersionTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \OfferCreation\Model\OfferVersion) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(OfferVersionTableMap::DATABASE_NAME);
            // primary key is composite; we therefore, expect
            // the primary key passed to be an array of pkey values
            if (count($values) == count($values, COUNT_RECURSIVE)) {
                // array is not multi-dimensional
                $values = array($values);
            }
            foreach ($values as $value) {
                $criterion = $criteria->getNewCriterion(OfferVersionTableMap::ID, $value[0]);
                $criterion->addAnd($criteria->getNewCriterion(OfferVersionTableMap::VERSION, $value[1]));
                $criteria->addOr($criterion);
            }
        }

        $query = OfferVersionQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) { OfferVersionTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) { OfferVersionTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the offer_version table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return OfferVersionQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a OfferVersion or Criteria object.
     *
     * @param mixed               $criteria Criteria or OfferVersion object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(OfferVersionTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from OfferVersion object
        }


        // Set the correct dbName
        $query = OfferVersionQuery::create()->mergeWith($criteria);

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

} // OfferVersionTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
OfferVersionTableMap::buildTableMap();
