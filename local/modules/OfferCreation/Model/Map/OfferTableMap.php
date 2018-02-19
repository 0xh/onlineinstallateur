<?php

namespace OfferCreation\Model\Map;

use OfferCreation\Model\Offer;
use OfferCreation\Model\OfferQuery;
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
 * This class defines the structure of the 'offer' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class OfferTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;
    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'OfferCreation.Model.Map.OfferTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'thelia';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'offer';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\OfferCreation\\Model\\Offer';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'OfferCreation.Model.Offer';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 30;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 30;

    /**
     * the column name for the ID field
     */
    const ID = 'offer.ID';

    /**
     * the column name for the REF field
     */
    const REF = 'offer.REF';

    /**
     * the column name for the ORDER_ID field
     */
    const ORDER_ID = 'offer.ORDER_ID';

    /**
     * the column name for the ORDER_REF field
     */
    const ORDER_REF = 'offer.ORDER_REF';

    /**
     * the column name for the CUSTOMER_ID field
     */
    const CUSTOMER_ID = 'offer.CUSTOMER_ID';

    /**
     * the column name for the EMPLOYEE_ID field
     */
    const EMPLOYEE_ID = 'offer.EMPLOYEE_ID';

    /**
     * the column name for the INVOICE_ORDER_ADDRESS_ID field
     */
    const INVOICE_ORDER_ADDRESS_ID = 'offer.INVOICE_ORDER_ADDRESS_ID';

    /**
     * the column name for the DELIVERY_ORDER_ADDRESS_ID field
     */
    const DELIVERY_ORDER_ADDRESS_ID = 'offer.DELIVERY_ORDER_ADDRESS_ID';

    /**
     * the column name for the INVOICE_DATE field
     */
    const INVOICE_DATE = 'offer.INVOICE_DATE';

    /**
     * the column name for the CURRENCY_ID field
     */
    const CURRENCY_ID = 'offer.CURRENCY_ID';

    /**
     * the column name for the CURRENCY_RATE field
     */
    const CURRENCY_RATE = 'offer.CURRENCY_RATE';

    /**
     * the column name for the TRANSACTION_REF field
     */
    const TRANSACTION_REF = 'offer.TRANSACTION_REF';

    /**
     * the column name for the DELIVERY_REF field
     */
    const DELIVERY_REF = 'offer.DELIVERY_REF';

    /**
     * the column name for the INVOICE_REF field
     */
    const INVOICE_REF = 'offer.INVOICE_REF';

    /**
     * the column name for the DISCOUNT field
     */
    const DISCOUNT = 'offer.DISCOUNT';

    /**
     * the column name for the POSTAGE field
     */
    const POSTAGE = 'offer.POSTAGE';

    /**
     * the column name for the POSTAGE_TAX field
     */
    const POSTAGE_TAX = 'offer.POSTAGE_TAX';

    /**
     * the column name for the POSTAGE_TAX_RULE_TITLE field
     */
    const POSTAGE_TAX_RULE_TITLE = 'offer.POSTAGE_TAX_RULE_TITLE';

    /**
     * the column name for the PAYMENT_MODULE_ID field
     */
    const PAYMENT_MODULE_ID = 'offer.PAYMENT_MODULE_ID';

    /**
     * the column name for the DELIVERY_MODULE_ID field
     */
    const DELIVERY_MODULE_ID = 'offer.DELIVERY_MODULE_ID';

    /**
     * the column name for the STATUS_ID field
     */
    const STATUS_ID = 'offer.STATUS_ID';

    /**
     * the column name for the LANG_ID field
     */
    const LANG_ID = 'offer.LANG_ID';

    /**
     * the column name for the CART_ID field
     */
    const CART_ID = 'offer.CART_ID';

    /**
     * the column name for the CREATED_AT field
     */
    const CREATED_AT = 'offer.CREATED_AT';

    /**
     * the column name for the UPDATED_AT field
     */
    const UPDATED_AT = 'offer.UPDATED_AT';

    /**
     * the column name for the VERSION field
     */
    const VERSION = 'offer.VERSION';

    /**
     * the column name for the VERSION_CREATED_AT field
     */
    const VERSION_CREATED_AT = 'offer.VERSION_CREATED_AT';

    /**
     * the column name for the VERSION_CREATED_BY field
     */
    const VERSION_CREATED_BY = 'offer.VERSION_CREATED_BY';

    /**
     * the column name for the NOTE_EMPLOYEE field
     */
    const NOTE_EMPLOYEE = 'offer.NOTE_EMPLOYEE';

    /**
     * the column name for the CHAT_ID field
     */
    const CHAT_ID = 'offer.CHAT_ID';

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
        self::TYPE_PHPNAME       => array('Id', 'Ref', 'OrderId', 'OrderRef', 'CustomerId', 'EmployeeId', 'InvoiceOrderAddressId', 'DeliveryOrderAddressId', 'InvoiceDate', 'CurrencyId', 'CurrencyRate', 'TransactionRef', 'DeliveryRef', 'InvoiceRef', 'Discount', 'Postage', 'PostageTax', 'PostageTaxRuleTitle', 'PaymentModuleId', 'DeliveryModuleId', 'StatusId', 'LangId', 'CartId', 'CreatedAt', 'UpdatedAt', 'Version', 'VersionCreatedAt', 'VersionCreatedBy', 'NoteEmployee', 'ChatId', ),
        self::TYPE_STUDLYPHPNAME => array('id', 'ref', 'orderId', 'orderRef', 'customerId', 'employeeId', 'invoiceOrderAddressId', 'deliveryOrderAddressId', 'invoiceDate', 'currencyId', 'currencyRate', 'transactionRef', 'deliveryRef', 'invoiceRef', 'discount', 'postage', 'postageTax', 'postageTaxRuleTitle', 'paymentModuleId', 'deliveryModuleId', 'statusId', 'langId', 'cartId', 'createdAt', 'updatedAt', 'version', 'versionCreatedAt', 'versionCreatedBy', 'noteEmployee', 'chatId', ),
        self::TYPE_COLNAME       => array(OfferTableMap::ID, OfferTableMap::REF, OfferTableMap::ORDER_ID, OfferTableMap::ORDER_REF, OfferTableMap::CUSTOMER_ID, OfferTableMap::EMPLOYEE_ID, OfferTableMap::INVOICE_ORDER_ADDRESS_ID, OfferTableMap::DELIVERY_ORDER_ADDRESS_ID, OfferTableMap::INVOICE_DATE, OfferTableMap::CURRENCY_ID, OfferTableMap::CURRENCY_RATE, OfferTableMap::TRANSACTION_REF, OfferTableMap::DELIVERY_REF, OfferTableMap::INVOICE_REF, OfferTableMap::DISCOUNT, OfferTableMap::POSTAGE, OfferTableMap::POSTAGE_TAX, OfferTableMap::POSTAGE_TAX_RULE_TITLE, OfferTableMap::PAYMENT_MODULE_ID, OfferTableMap::DELIVERY_MODULE_ID, OfferTableMap::STATUS_ID, OfferTableMap::LANG_ID, OfferTableMap::CART_ID, OfferTableMap::CREATED_AT, OfferTableMap::UPDATED_AT, OfferTableMap::VERSION, OfferTableMap::VERSION_CREATED_AT, OfferTableMap::VERSION_CREATED_BY, OfferTableMap::NOTE_EMPLOYEE, OfferTableMap::CHAT_ID, ),
        self::TYPE_RAW_COLNAME   => array('ID', 'REF', 'ORDER_ID', 'ORDER_REF', 'CUSTOMER_ID', 'EMPLOYEE_ID', 'INVOICE_ORDER_ADDRESS_ID', 'DELIVERY_ORDER_ADDRESS_ID', 'INVOICE_DATE', 'CURRENCY_ID', 'CURRENCY_RATE', 'TRANSACTION_REF', 'DELIVERY_REF', 'INVOICE_REF', 'DISCOUNT', 'POSTAGE', 'POSTAGE_TAX', 'POSTAGE_TAX_RULE_TITLE', 'PAYMENT_MODULE_ID', 'DELIVERY_MODULE_ID', 'STATUS_ID', 'LANG_ID', 'CART_ID', 'CREATED_AT', 'UPDATED_AT', 'VERSION', 'VERSION_CREATED_AT', 'VERSION_CREATED_BY', 'NOTE_EMPLOYEE', 'CHAT_ID', ),
        self::TYPE_FIELDNAME     => array('id', 'ref', 'order_id', 'order_ref', 'customer_id', 'employee_id', 'invoice_order_address_id', 'delivery_order_address_id', 'invoice_date', 'currency_id', 'currency_rate', 'transaction_ref', 'delivery_ref', 'invoice_ref', 'discount', 'postage', 'postage_tax', 'postage_tax_rule_title', 'payment_module_id', 'delivery_module_id', 'status_id', 'lang_id', 'cart_id', 'created_at', 'updated_at', 'version', 'version_created_at', 'version_created_by', 'note_employee', 'chat_id', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'Ref' => 1, 'OrderId' => 2, 'OrderRef' => 3, 'CustomerId' => 4, 'EmployeeId' => 5, 'InvoiceOrderAddressId' => 6, 'DeliveryOrderAddressId' => 7, 'InvoiceDate' => 8, 'CurrencyId' => 9, 'CurrencyRate' => 10, 'TransactionRef' => 11, 'DeliveryRef' => 12, 'InvoiceRef' => 13, 'Discount' => 14, 'Postage' => 15, 'PostageTax' => 16, 'PostageTaxRuleTitle' => 17, 'PaymentModuleId' => 18, 'DeliveryModuleId' => 19, 'StatusId' => 20, 'LangId' => 21, 'CartId' => 22, 'CreatedAt' => 23, 'UpdatedAt' => 24, 'Version' => 25, 'VersionCreatedAt' => 26, 'VersionCreatedBy' => 27, 'NoteEmployee' => 28, 'ChatId' => 29, ),
        self::TYPE_STUDLYPHPNAME => array('id' => 0, 'ref' => 1, 'orderId' => 2, 'orderRef' => 3, 'customerId' => 4, 'employeeId' => 5, 'invoiceOrderAddressId' => 6, 'deliveryOrderAddressId' => 7, 'invoiceDate' => 8, 'currencyId' => 9, 'currencyRate' => 10, 'transactionRef' => 11, 'deliveryRef' => 12, 'invoiceRef' => 13, 'discount' => 14, 'postage' => 15, 'postageTax' => 16, 'postageTaxRuleTitle' => 17, 'paymentModuleId' => 18, 'deliveryModuleId' => 19, 'statusId' => 20, 'langId' => 21, 'cartId' => 22, 'createdAt' => 23, 'updatedAt' => 24, 'version' => 25, 'versionCreatedAt' => 26, 'versionCreatedBy' => 27, 'noteEmployee' => 28, 'chatId' => 29, ),
        self::TYPE_COLNAME       => array(OfferTableMap::ID => 0, OfferTableMap::REF => 1, OfferTableMap::ORDER_ID => 2, OfferTableMap::ORDER_REF => 3, OfferTableMap::CUSTOMER_ID => 4, OfferTableMap::EMPLOYEE_ID => 5, OfferTableMap::INVOICE_ORDER_ADDRESS_ID => 6, OfferTableMap::DELIVERY_ORDER_ADDRESS_ID => 7, OfferTableMap::INVOICE_DATE => 8, OfferTableMap::CURRENCY_ID => 9, OfferTableMap::CURRENCY_RATE => 10, OfferTableMap::TRANSACTION_REF => 11, OfferTableMap::DELIVERY_REF => 12, OfferTableMap::INVOICE_REF => 13, OfferTableMap::DISCOUNT => 14, OfferTableMap::POSTAGE => 15, OfferTableMap::POSTAGE_TAX => 16, OfferTableMap::POSTAGE_TAX_RULE_TITLE => 17, OfferTableMap::PAYMENT_MODULE_ID => 18, OfferTableMap::DELIVERY_MODULE_ID => 19, OfferTableMap::STATUS_ID => 20, OfferTableMap::LANG_ID => 21, OfferTableMap::CART_ID => 22, OfferTableMap::CREATED_AT => 23, OfferTableMap::UPDATED_AT => 24, OfferTableMap::VERSION => 25, OfferTableMap::VERSION_CREATED_AT => 26, OfferTableMap::VERSION_CREATED_BY => 27, OfferTableMap::NOTE_EMPLOYEE => 28, OfferTableMap::CHAT_ID => 29, ),
        self::TYPE_RAW_COLNAME   => array('ID' => 0, 'REF' => 1, 'ORDER_ID' => 2, 'ORDER_REF' => 3, 'CUSTOMER_ID' => 4, 'EMPLOYEE_ID' => 5, 'INVOICE_ORDER_ADDRESS_ID' => 6, 'DELIVERY_ORDER_ADDRESS_ID' => 7, 'INVOICE_DATE' => 8, 'CURRENCY_ID' => 9, 'CURRENCY_RATE' => 10, 'TRANSACTION_REF' => 11, 'DELIVERY_REF' => 12, 'INVOICE_REF' => 13, 'DISCOUNT' => 14, 'POSTAGE' => 15, 'POSTAGE_TAX' => 16, 'POSTAGE_TAX_RULE_TITLE' => 17, 'PAYMENT_MODULE_ID' => 18, 'DELIVERY_MODULE_ID' => 19, 'STATUS_ID' => 20, 'LANG_ID' => 21, 'CART_ID' => 22, 'CREATED_AT' => 23, 'UPDATED_AT' => 24, 'VERSION' => 25, 'VERSION_CREATED_AT' => 26, 'VERSION_CREATED_BY' => 27, 'NOTE_EMPLOYEE' => 28, 'CHAT_ID' => 29, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'ref' => 1, 'order_id' => 2, 'order_ref' => 3, 'customer_id' => 4, 'employee_id' => 5, 'invoice_order_address_id' => 6, 'delivery_order_address_id' => 7, 'invoice_date' => 8, 'currency_id' => 9, 'currency_rate' => 10, 'transaction_ref' => 11, 'delivery_ref' => 12, 'invoice_ref' => 13, 'discount' => 14, 'postage' => 15, 'postage_tax' => 16, 'postage_tax_rule_title' => 17, 'payment_module_id' => 18, 'delivery_module_id' => 19, 'status_id' => 20, 'lang_id' => 21, 'cart_id' => 22, 'created_at' => 23, 'updated_at' => 24, 'version' => 25, 'version_created_at' => 26, 'version_created_by' => 27, 'note_employee' => 28, 'chat_id' => 29, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, )
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
        $this->setName('offer');
        $this->setPhpName('Offer');
        $this->setClassName('\\OfferCreation\\Model\\Offer');
        $this->setPackage('OfferCreation.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('REF', 'Ref', 'VARCHAR', false, 45, null);
        $this->addForeignKey('ORDER_ID', 'OrderId', 'INTEGER', 'order', 'ID', false, null, null);
        $this->addForeignKey('ORDER_REF', 'OrderRef', 'VARCHAR', 'order', 'REF', false, 45, null);
        $this->addForeignKey('CUSTOMER_ID', 'CustomerId', 'INTEGER', 'customer', 'ID', true, null, null);
        $this->addForeignKey('EMPLOYEE_ID', 'EmployeeId', 'INTEGER', 'admin', 'ID', true, null, null);
        $this->addForeignKey('INVOICE_ORDER_ADDRESS_ID', 'InvoiceOrderAddressId', 'INTEGER', 'order_address', 'ID', true, null, null);
        $this->addForeignKey('DELIVERY_ORDER_ADDRESS_ID', 'DeliveryOrderAddressId', 'INTEGER', 'order_address', 'ID', true, null, null);
        $this->addColumn('INVOICE_DATE', 'InvoiceDate', 'TIMESTAMP', false, null, null);
        $this->addForeignKey('CURRENCY_ID', 'CurrencyId', 'INTEGER', 'currency', 'ID', true, null, null);
        $this->addColumn('CURRENCY_RATE', 'CurrencyRate', 'FLOAT', true, null, null);
        $this->addColumn('TRANSACTION_REF', 'TransactionRef', 'VARCHAR', false, 100, null);
        $this->addColumn('DELIVERY_REF', 'DeliveryRef', 'VARCHAR', false, 100, null);
        $this->addColumn('INVOICE_REF', 'InvoiceRef', 'VARCHAR', false, 100, null);
        $this->addColumn('DISCOUNT', 'Discount', 'DECIMAL', false, 16, 0);
        $this->addColumn('POSTAGE', 'Postage', 'DECIMAL', true, 16, 0);
        $this->addColumn('POSTAGE_TAX', 'PostageTax', 'DECIMAL', true, 16, 0);
        $this->addColumn('POSTAGE_TAX_RULE_TITLE', 'PostageTaxRuleTitle', 'VARCHAR', false, 255, null);
        $this->addForeignKey('PAYMENT_MODULE_ID', 'PaymentModuleId', 'INTEGER', 'module', 'ID', true, null, null);
        $this->addForeignKey('DELIVERY_MODULE_ID', 'DeliveryModuleId', 'INTEGER', 'module', 'ID', true, null, null);
        $this->addForeignKey('STATUS_ID', 'StatusId', 'INTEGER', 'order_status', 'ID', true, null, null);
        $this->addForeignKey('LANG_ID', 'LangId', 'INTEGER', 'lang', 'ID', true, null, null);
        $this->addColumn('CART_ID', 'CartId', 'INTEGER', true, null, null);
        $this->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('UPDATED_AT', 'UpdatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('VERSION', 'Version', 'INTEGER', false, null, 0);
        $this->addColumn('VERSION_CREATED_AT', 'VersionCreatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('VERSION_CREATED_BY', 'VersionCreatedBy', 'VARCHAR', false, 100, null);
        $this->addColumn('NOTE_EMPLOYEE', 'NoteEmployee', 'CLOB', false, null, null);
        $this->addForeignKey('CHAT_ID', 'ChatId', 'INTEGER', 'offer_chat', 'ID', false, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('OfferChat', '\\OfferCreation\\Model\\OfferChat', RelationMap::MANY_TO_ONE, array('chat_id' => 'id', ), 'CASCADE', null);
        $this->addRelation('Currency', '\\Thelia\\Model\\Currency', RelationMap::MANY_TO_ONE, array('currency_id' => 'id', ), null, null);
        $this->addRelation('Customer', '\\Thelia\\Model\\Customer', RelationMap::MANY_TO_ONE, array('customer_id' => 'id', ), null, null);
        $this->addRelation('ModuleRelatedByDeliveryModuleId', '\\Thelia\\Model\\Module', RelationMap::MANY_TO_ONE, array('delivery_module_id' => 'id', ), null, null);
        $this->addRelation('OrderAddressRelatedByDeliveryOrderAddressId', '\\Thelia\\Model\\OrderAddress', RelationMap::MANY_TO_ONE, array('delivery_order_address_id' => 'id', ), null, null);
        $this->addRelation('Admin', '\\Thelia\\Model\\Admin', RelationMap::MANY_TO_ONE, array('employee_id' => 'id', ), null, null);
        $this->addRelation('OrderAddressRelatedByInvoiceOrderAddressId', '\\Thelia\\Model\\OrderAddress', RelationMap::MANY_TO_ONE, array('invoice_order_address_id' => 'id', ), null, null);
        $this->addRelation('Lang', '\\Thelia\\Model\\Lang', RelationMap::MANY_TO_ONE, array('lang_id' => 'id', ), null, null);
        $this->addRelation('OrderRelatedByOrderId', '\\Thelia\\Model\\Order', RelationMap::MANY_TO_ONE, array('order_id' => 'id', ), 'CASCADE', null);
        $this->addRelation('OrderRelatedByOrderRef', '\\Thelia\\Model\\Order', RelationMap::MANY_TO_ONE, array('order_ref' => 'ref', ), 'CASCADE', null);
        $this->addRelation('ModuleRelatedByPaymentModuleId', '\\Thelia\\Model\\Module', RelationMap::MANY_TO_ONE, array('payment_module_id' => 'id', ), null, null);
        $this->addRelation('OfferProduct', '\\OfferCreation\\Model\\OfferProduct', RelationMap::ONE_TO_MANY, array('id' => 'offer_id', ), 'CASCADE', null, 'OfferProducts');
        $this->addRelation('OfferVersion', '\\OfferCreation\\Model\\OfferVersion', RelationMap::ONE_TO_MANY, array('id' => 'id', ), 'CASCADE', null, 'OfferVersions');
    } // buildRelations()
    /**
     * Method to invalidate the instance pool of all tables related to offer     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
        // Invalidate objects in ".$this->getClassNameFromBuilder($joinedTableTableMapBuilder)." instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
                OfferProductTableMap::clearInstancePool();
                OfferVersionTableMap::clearInstancePool();
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
        return $withPrefix ? OfferTableMap::CLASS_DEFAULT : OfferTableMap::OM_CLASS;
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
     * @return array (Offer object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = OfferTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = OfferTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + OfferTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = OfferTableMap::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            OfferTableMap::addInstanceToPool($obj, $key);
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
            $key = OfferTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = OfferTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                OfferTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(OfferTableMap::ID);
            $criteria->addSelectColumn(OfferTableMap::REF);
            $criteria->addSelectColumn(OfferTableMap::ORDER_ID);
            $criteria->addSelectColumn(OfferTableMap::ORDER_REF);
            $criteria->addSelectColumn(OfferTableMap::CUSTOMER_ID);
            $criteria->addSelectColumn(OfferTableMap::EMPLOYEE_ID);
            $criteria->addSelectColumn(OfferTableMap::INVOICE_ORDER_ADDRESS_ID);
            $criteria->addSelectColumn(OfferTableMap::DELIVERY_ORDER_ADDRESS_ID);
            $criteria->addSelectColumn(OfferTableMap::INVOICE_DATE);
            $criteria->addSelectColumn(OfferTableMap::CURRENCY_ID);
            $criteria->addSelectColumn(OfferTableMap::CURRENCY_RATE);
            $criteria->addSelectColumn(OfferTableMap::TRANSACTION_REF);
            $criteria->addSelectColumn(OfferTableMap::DELIVERY_REF);
            $criteria->addSelectColumn(OfferTableMap::INVOICE_REF);
            $criteria->addSelectColumn(OfferTableMap::DISCOUNT);
            $criteria->addSelectColumn(OfferTableMap::POSTAGE);
            $criteria->addSelectColumn(OfferTableMap::POSTAGE_TAX);
            $criteria->addSelectColumn(OfferTableMap::POSTAGE_TAX_RULE_TITLE);
            $criteria->addSelectColumn(OfferTableMap::PAYMENT_MODULE_ID);
            $criteria->addSelectColumn(OfferTableMap::DELIVERY_MODULE_ID);
            $criteria->addSelectColumn(OfferTableMap::STATUS_ID);
            $criteria->addSelectColumn(OfferTableMap::LANG_ID);
            $criteria->addSelectColumn(OfferTableMap::CART_ID);
            $criteria->addSelectColumn(OfferTableMap::CREATED_AT);
            $criteria->addSelectColumn(OfferTableMap::UPDATED_AT);
            $criteria->addSelectColumn(OfferTableMap::VERSION);
            $criteria->addSelectColumn(OfferTableMap::VERSION_CREATED_AT);
            $criteria->addSelectColumn(OfferTableMap::VERSION_CREATED_BY);
            $criteria->addSelectColumn(OfferTableMap::NOTE_EMPLOYEE);
            $criteria->addSelectColumn(OfferTableMap::CHAT_ID);
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
        return Propel::getServiceContainer()->getDatabaseMap(OfferTableMap::DATABASE_NAME)->getTable(OfferTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getServiceContainer()->getDatabaseMap(OfferTableMap::DATABASE_NAME);
      if (!$dbMap->hasTable(OfferTableMap::TABLE_NAME)) {
        $dbMap->addTableObject(new OfferTableMap());
      }
    }

    /**
     * Performs a DELETE on the database, given a Offer or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Offer object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(OfferTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \OfferCreation\Model\Offer) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(OfferTableMap::DATABASE_NAME);
            $criteria->add(OfferTableMap::ID, (array) $values, Criteria::IN);
        }

        $query = OfferQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) { OfferTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) { OfferTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the offer table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return OfferQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Offer or Criteria object.
     *
     * @param mixed               $criteria Criteria or Offer object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(OfferTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Offer object
        }

        if ($criteria->containsKey(OfferTableMap::ID) && $criteria->keyContainsValue(OfferTableMap::ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.OfferTableMap::ID.')');
        }


        // Set the correct dbName
        $query = OfferQuery::create()->mergeWith($criteria);

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

} // OfferTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
OfferTableMap::buildTableMap();
