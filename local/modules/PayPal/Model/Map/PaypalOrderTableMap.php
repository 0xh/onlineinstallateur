<?php

namespace PayPal\Model\Map;

use PayPal\Model\PaypalOrder;
use PayPal\Model\PaypalOrderQuery;
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
 * This class defines the structure of the 'paypal_order' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class PaypalOrderTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;
    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'PayPal.Model.Map.PaypalOrderTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'thelia';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'paypal_order';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\PayPal\\Model\\PaypalOrder';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'PayPal.Model.PaypalOrder';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 22;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 22;

    /**
     * the column name for the ID field
     */
    const ID = 'paypal_order.ID';

    /**
     * the column name for the PAYMENT_ID field
     */
    const PAYMENT_ID = 'paypal_order.PAYMENT_ID';

    /**
     * the column name for the AGREEMENT_ID field
     */
    const AGREEMENT_ID = 'paypal_order.AGREEMENT_ID';

    /**
     * the column name for the CREDIT_CARD_ID field
     */
    const CREDIT_CARD_ID = 'paypal_order.CREDIT_CARD_ID';

    /**
     * the column name for the STATE field
     */
    const STATE = 'paypal_order.STATE';

    /**
     * the column name for the AMOUNT field
     */
    const AMOUNT = 'paypal_order.AMOUNT';

    /**
     * the column name for the DESCRIPTION field
     */
    const DESCRIPTION = 'paypal_order.DESCRIPTION';

    /**
     * the column name for the PAYER_ID field
     */
    const PAYER_ID = 'paypal_order.PAYER_ID';

    /**
     * the column name for the TOKEN field
     */
    const TOKEN = 'paypal_order.TOKEN';

    /**
     * the column name for the PLANIFIED_TITLE field
     */
    const PLANIFIED_TITLE = 'paypal_order.PLANIFIED_TITLE';

    /**
     * the column name for the PLANIFIED_DESCRIPTION field
     */
    const PLANIFIED_DESCRIPTION = 'paypal_order.PLANIFIED_DESCRIPTION';

    /**
     * the column name for the PLANIFIED_FREQUENCY field
     */
    const PLANIFIED_FREQUENCY = 'paypal_order.PLANIFIED_FREQUENCY';

    /**
     * the column name for the PLANIFIED_FREQUENCY_INTERVAL field
     */
    const PLANIFIED_FREQUENCY_INTERVAL = 'paypal_order.PLANIFIED_FREQUENCY_INTERVAL';

    /**
     * the column name for the PLANIFIED_CYCLE field
     */
    const PLANIFIED_CYCLE = 'paypal_order.PLANIFIED_CYCLE';

    /**
     * the column name for the PLANIFIED_ACTUAL_CYCLE field
     */
    const PLANIFIED_ACTUAL_CYCLE = 'paypal_order.PLANIFIED_ACTUAL_CYCLE';

    /**
     * the column name for the PLANIFIED_MIN_AMOUNT field
     */
    const PLANIFIED_MIN_AMOUNT = 'paypal_order.PLANIFIED_MIN_AMOUNT';

    /**
     * the column name for the PLANIFIED_MAX_AMOUNT field
     */
    const PLANIFIED_MAX_AMOUNT = 'paypal_order.PLANIFIED_MAX_AMOUNT';

    /**
     * the column name for the CREATED_AT field
     */
    const CREATED_AT = 'paypal_order.CREATED_AT';

    /**
     * the column name for the UPDATED_AT field
     */
    const UPDATED_AT = 'paypal_order.UPDATED_AT';

    /**
     * the column name for the VERSION field
     */
    const VERSION = 'paypal_order.VERSION';

    /**
     * the column name for the VERSION_CREATED_AT field
     */
    const VERSION_CREATED_AT = 'paypal_order.VERSION_CREATED_AT';

    /**
     * the column name for the VERSION_CREATED_BY field
     */
    const VERSION_CREATED_BY = 'paypal_order.VERSION_CREATED_BY';

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
        self::TYPE_PHPNAME       => array('Id', 'PaymentId', 'AgreementId', 'CreditCardId', 'State', 'Amount', 'Description', 'PayerId', 'Token', 'PlanifiedTitle', 'PlanifiedDescription', 'PlanifiedFrequency', 'PlanifiedFrequencyInterval', 'PlanifiedCycle', 'PlanifiedActualCycle', 'PlanifiedMinAmount', 'PlanifiedMaxAmount', 'CreatedAt', 'UpdatedAt', 'Version', 'VersionCreatedAt', 'VersionCreatedBy', ),
        self::TYPE_STUDLYPHPNAME => array('id', 'paymentId', 'agreementId', 'creditCardId', 'state', 'amount', 'description', 'payerId', 'token', 'planifiedTitle', 'planifiedDescription', 'planifiedFrequency', 'planifiedFrequencyInterval', 'planifiedCycle', 'planifiedActualCycle', 'planifiedMinAmount', 'planifiedMaxAmount', 'createdAt', 'updatedAt', 'version', 'versionCreatedAt', 'versionCreatedBy', ),
        self::TYPE_COLNAME       => array(PaypalOrderTableMap::ID, PaypalOrderTableMap::PAYMENT_ID, PaypalOrderTableMap::AGREEMENT_ID, PaypalOrderTableMap::CREDIT_CARD_ID, PaypalOrderTableMap::STATE, PaypalOrderTableMap::AMOUNT, PaypalOrderTableMap::DESCRIPTION, PaypalOrderTableMap::PAYER_ID, PaypalOrderTableMap::TOKEN, PaypalOrderTableMap::PLANIFIED_TITLE, PaypalOrderTableMap::PLANIFIED_DESCRIPTION, PaypalOrderTableMap::PLANIFIED_FREQUENCY, PaypalOrderTableMap::PLANIFIED_FREQUENCY_INTERVAL, PaypalOrderTableMap::PLANIFIED_CYCLE, PaypalOrderTableMap::PLANIFIED_ACTUAL_CYCLE, PaypalOrderTableMap::PLANIFIED_MIN_AMOUNT, PaypalOrderTableMap::PLANIFIED_MAX_AMOUNT, PaypalOrderTableMap::CREATED_AT, PaypalOrderTableMap::UPDATED_AT, PaypalOrderTableMap::VERSION, PaypalOrderTableMap::VERSION_CREATED_AT, PaypalOrderTableMap::VERSION_CREATED_BY, ),
        self::TYPE_RAW_COLNAME   => array('ID', 'PAYMENT_ID', 'AGREEMENT_ID', 'CREDIT_CARD_ID', 'STATE', 'AMOUNT', 'DESCRIPTION', 'PAYER_ID', 'TOKEN', 'PLANIFIED_TITLE', 'PLANIFIED_DESCRIPTION', 'PLANIFIED_FREQUENCY', 'PLANIFIED_FREQUENCY_INTERVAL', 'PLANIFIED_CYCLE', 'PLANIFIED_ACTUAL_CYCLE', 'PLANIFIED_MIN_AMOUNT', 'PLANIFIED_MAX_AMOUNT', 'CREATED_AT', 'UPDATED_AT', 'VERSION', 'VERSION_CREATED_AT', 'VERSION_CREATED_BY', ),
        self::TYPE_FIELDNAME     => array('id', 'payment_id', 'agreement_id', 'credit_card_id', 'state', 'amount', 'description', 'payer_id', 'token', 'planified_title', 'planified_description', 'planified_frequency', 'planified_frequency_interval', 'planified_cycle', 'planified_actual_cycle', 'planified_min_amount', 'planified_max_amount', 'created_at', 'updated_at', 'version', 'version_created_at', 'version_created_by', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'PaymentId' => 1, 'AgreementId' => 2, 'CreditCardId' => 3, 'State' => 4, 'Amount' => 5, 'Description' => 6, 'PayerId' => 7, 'Token' => 8, 'PlanifiedTitle' => 9, 'PlanifiedDescription' => 10, 'PlanifiedFrequency' => 11, 'PlanifiedFrequencyInterval' => 12, 'PlanifiedCycle' => 13, 'PlanifiedActualCycle' => 14, 'PlanifiedMinAmount' => 15, 'PlanifiedMaxAmount' => 16, 'CreatedAt' => 17, 'UpdatedAt' => 18, 'Version' => 19, 'VersionCreatedAt' => 20, 'VersionCreatedBy' => 21, ),
        self::TYPE_STUDLYPHPNAME => array('id' => 0, 'paymentId' => 1, 'agreementId' => 2, 'creditCardId' => 3, 'state' => 4, 'amount' => 5, 'description' => 6, 'payerId' => 7, 'token' => 8, 'planifiedTitle' => 9, 'planifiedDescription' => 10, 'planifiedFrequency' => 11, 'planifiedFrequencyInterval' => 12, 'planifiedCycle' => 13, 'planifiedActualCycle' => 14, 'planifiedMinAmount' => 15, 'planifiedMaxAmount' => 16, 'createdAt' => 17, 'updatedAt' => 18, 'version' => 19, 'versionCreatedAt' => 20, 'versionCreatedBy' => 21, ),
        self::TYPE_COLNAME       => array(PaypalOrderTableMap::ID => 0, PaypalOrderTableMap::PAYMENT_ID => 1, PaypalOrderTableMap::AGREEMENT_ID => 2, PaypalOrderTableMap::CREDIT_CARD_ID => 3, PaypalOrderTableMap::STATE => 4, PaypalOrderTableMap::AMOUNT => 5, PaypalOrderTableMap::DESCRIPTION => 6, PaypalOrderTableMap::PAYER_ID => 7, PaypalOrderTableMap::TOKEN => 8, PaypalOrderTableMap::PLANIFIED_TITLE => 9, PaypalOrderTableMap::PLANIFIED_DESCRIPTION => 10, PaypalOrderTableMap::PLANIFIED_FREQUENCY => 11, PaypalOrderTableMap::PLANIFIED_FREQUENCY_INTERVAL => 12, PaypalOrderTableMap::PLANIFIED_CYCLE => 13, PaypalOrderTableMap::PLANIFIED_ACTUAL_CYCLE => 14, PaypalOrderTableMap::PLANIFIED_MIN_AMOUNT => 15, PaypalOrderTableMap::PLANIFIED_MAX_AMOUNT => 16, PaypalOrderTableMap::CREATED_AT => 17, PaypalOrderTableMap::UPDATED_AT => 18, PaypalOrderTableMap::VERSION => 19, PaypalOrderTableMap::VERSION_CREATED_AT => 20, PaypalOrderTableMap::VERSION_CREATED_BY => 21, ),
        self::TYPE_RAW_COLNAME   => array('ID' => 0, 'PAYMENT_ID' => 1, 'AGREEMENT_ID' => 2, 'CREDIT_CARD_ID' => 3, 'STATE' => 4, 'AMOUNT' => 5, 'DESCRIPTION' => 6, 'PAYER_ID' => 7, 'TOKEN' => 8, 'PLANIFIED_TITLE' => 9, 'PLANIFIED_DESCRIPTION' => 10, 'PLANIFIED_FREQUENCY' => 11, 'PLANIFIED_FREQUENCY_INTERVAL' => 12, 'PLANIFIED_CYCLE' => 13, 'PLANIFIED_ACTUAL_CYCLE' => 14, 'PLANIFIED_MIN_AMOUNT' => 15, 'PLANIFIED_MAX_AMOUNT' => 16, 'CREATED_AT' => 17, 'UPDATED_AT' => 18, 'VERSION' => 19, 'VERSION_CREATED_AT' => 20, 'VERSION_CREATED_BY' => 21, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'payment_id' => 1, 'agreement_id' => 2, 'credit_card_id' => 3, 'state' => 4, 'amount' => 5, 'description' => 6, 'payer_id' => 7, 'token' => 8, 'planified_title' => 9, 'planified_description' => 10, 'planified_frequency' => 11, 'planified_frequency_interval' => 12, 'planified_cycle' => 13, 'planified_actual_cycle' => 14, 'planified_min_amount' => 15, 'planified_max_amount' => 16, 'created_at' => 17, 'updated_at' => 18, 'version' => 19, 'version_created_at' => 20, 'version_created_by' => 21, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, )
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
        $this->setName('paypal_order');
        $this->setPhpName('PaypalOrder');
        $this->setClassName('\\PayPal\\Model\\PaypalOrder');
        $this->setPackage('PayPal.Model');
        $this->setUseIdGenerator(false);
        // columns
        $this->addForeignPrimaryKey('ID', 'Id', 'INTEGER' , 'order', 'ID', true, null, null);
        $this->addColumn('PAYMENT_ID', 'PaymentId', 'VARCHAR', false, 50, null);
        $this->addColumn('AGREEMENT_ID', 'AgreementId', 'VARCHAR', false, 255, null);
        $this->addColumn('CREDIT_CARD_ID', 'CreditCardId', 'VARCHAR', false, 40, null);
        $this->addColumn('STATE', 'State', 'VARCHAR', false, 20, null);
        $this->addColumn('AMOUNT', 'Amount', 'DECIMAL', false, 16, 0);
        $this->addColumn('DESCRIPTION', 'Description', 'CLOB', false, null, null);
        $this->addColumn('PAYER_ID', 'PayerId', 'VARCHAR', false, 255, null);
        $this->addColumn('TOKEN', 'Token', 'VARCHAR', false, 255, null);
        $this->addColumn('PLANIFIED_TITLE', 'PlanifiedTitle', 'VARCHAR', true, 255, null);
        $this->addColumn('PLANIFIED_DESCRIPTION', 'PlanifiedDescription', 'CLOB', false, null, null);
        $this->addColumn('PLANIFIED_FREQUENCY', 'PlanifiedFrequency', 'VARCHAR', true, 255, null);
        $this->addColumn('PLANIFIED_FREQUENCY_INTERVAL', 'PlanifiedFrequencyInterval', 'INTEGER', true, null, null);
        $this->addColumn('PLANIFIED_CYCLE', 'PlanifiedCycle', 'INTEGER', true, null, null);
        $this->addColumn('PLANIFIED_ACTUAL_CYCLE', 'PlanifiedActualCycle', 'INTEGER', true, null, 0);
        $this->addColumn('PLANIFIED_MIN_AMOUNT', 'PlanifiedMinAmount', 'DECIMAL', false, 16, 0);
        $this->addColumn('PLANIFIED_MAX_AMOUNT', 'PlanifiedMaxAmount', 'DECIMAL', false, 16, 0);
        $this->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('UPDATED_AT', 'UpdatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('VERSION', 'Version', 'INTEGER', false, null, 0);
        $this->addColumn('VERSION_CREATED_AT', 'VersionCreatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('VERSION_CREATED_BY', 'VersionCreatedBy', 'VARCHAR', false, 100, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Order', '\\Thelia\\Model\\Order', RelationMap::MANY_TO_ONE, array('id' => 'id', ), 'CASCADE', 'RESTRICT');
        $this->addRelation('PaypalPlan', '\\PayPal\\Model\\PaypalPlan', RelationMap::ONE_TO_MANY, array('id' => 'paypal_order_id', ), 'CASCADE', 'RESTRICT', 'PaypalPlans');
        $this->addRelation('PaypalOrderVersion', '\\PayPal\\Model\\PaypalOrderVersion', RelationMap::ONE_TO_MANY, array('id' => 'id', ), 'CASCADE', null, 'PaypalOrderVersions');
    } // buildRelations()

    /**
     *
     * Gets the list of behaviors registered for this table
     *
     * @return array Associative array (name => parameters) of behaviors
     */
    public function getBehaviors()
    {
        return array(
            'timestampable' => array('create_column' => 'created_at', 'update_column' => 'updated_at', ),
            'versionable' => array('version_column' => 'version', 'version_table' => '', 'log_created_at' => 'true', 'log_created_by' => 'true', 'log_comment' => 'false', 'version_created_at_column' => 'version_created_at', 'version_created_by_column' => 'version_created_by', 'version_comment_column' => 'version_comment', ),
        );
    } // getBehaviors()
    /**
     * Method to invalidate the instance pool of all tables related to paypal_order     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
        // Invalidate objects in ".$this->getClassNameFromBuilder($joinedTableTableMapBuilder)." instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
                PaypalPlanTableMap::clearInstancePool();
                PaypalOrderVersionTableMap::clearInstancePool();
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
        return $withPrefix ? PaypalOrderTableMap::CLASS_DEFAULT : PaypalOrderTableMap::OM_CLASS;
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
     * @return array (PaypalOrder object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = PaypalOrderTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = PaypalOrderTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + PaypalOrderTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = PaypalOrderTableMap::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            PaypalOrderTableMap::addInstanceToPool($obj, $key);
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
            $key = PaypalOrderTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = PaypalOrderTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                PaypalOrderTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(PaypalOrderTableMap::ID);
            $criteria->addSelectColumn(PaypalOrderTableMap::PAYMENT_ID);
            $criteria->addSelectColumn(PaypalOrderTableMap::AGREEMENT_ID);
            $criteria->addSelectColumn(PaypalOrderTableMap::CREDIT_CARD_ID);
            $criteria->addSelectColumn(PaypalOrderTableMap::STATE);
            $criteria->addSelectColumn(PaypalOrderTableMap::AMOUNT);
            $criteria->addSelectColumn(PaypalOrderTableMap::DESCRIPTION);
            $criteria->addSelectColumn(PaypalOrderTableMap::PAYER_ID);
            $criteria->addSelectColumn(PaypalOrderTableMap::TOKEN);
            $criteria->addSelectColumn(PaypalOrderTableMap::PLANIFIED_TITLE);
            $criteria->addSelectColumn(PaypalOrderTableMap::PLANIFIED_DESCRIPTION);
            $criteria->addSelectColumn(PaypalOrderTableMap::PLANIFIED_FREQUENCY);
            $criteria->addSelectColumn(PaypalOrderTableMap::PLANIFIED_FREQUENCY_INTERVAL);
            $criteria->addSelectColumn(PaypalOrderTableMap::PLANIFIED_CYCLE);
            $criteria->addSelectColumn(PaypalOrderTableMap::PLANIFIED_ACTUAL_CYCLE);
            $criteria->addSelectColumn(PaypalOrderTableMap::PLANIFIED_MIN_AMOUNT);
            $criteria->addSelectColumn(PaypalOrderTableMap::PLANIFIED_MAX_AMOUNT);
            $criteria->addSelectColumn(PaypalOrderTableMap::CREATED_AT);
            $criteria->addSelectColumn(PaypalOrderTableMap::UPDATED_AT);
            $criteria->addSelectColumn(PaypalOrderTableMap::VERSION);
            $criteria->addSelectColumn(PaypalOrderTableMap::VERSION_CREATED_AT);
            $criteria->addSelectColumn(PaypalOrderTableMap::VERSION_CREATED_BY);
        } else {
            $criteria->addSelectColumn($alias . '.ID');
            $criteria->addSelectColumn($alias . '.PAYMENT_ID');
            $criteria->addSelectColumn($alias . '.AGREEMENT_ID');
            $criteria->addSelectColumn($alias . '.CREDIT_CARD_ID');
            $criteria->addSelectColumn($alias . '.STATE');
            $criteria->addSelectColumn($alias . '.AMOUNT');
            $criteria->addSelectColumn($alias . '.DESCRIPTION');
            $criteria->addSelectColumn($alias . '.PAYER_ID');
            $criteria->addSelectColumn($alias . '.TOKEN');
            $criteria->addSelectColumn($alias . '.PLANIFIED_TITLE');
            $criteria->addSelectColumn($alias . '.PLANIFIED_DESCRIPTION');
            $criteria->addSelectColumn($alias . '.PLANIFIED_FREQUENCY');
            $criteria->addSelectColumn($alias . '.PLANIFIED_FREQUENCY_INTERVAL');
            $criteria->addSelectColumn($alias . '.PLANIFIED_CYCLE');
            $criteria->addSelectColumn($alias . '.PLANIFIED_ACTUAL_CYCLE');
            $criteria->addSelectColumn($alias . '.PLANIFIED_MIN_AMOUNT');
            $criteria->addSelectColumn($alias . '.PLANIFIED_MAX_AMOUNT');
            $criteria->addSelectColumn($alias . '.CREATED_AT');
            $criteria->addSelectColumn($alias . '.UPDATED_AT');
            $criteria->addSelectColumn($alias . '.VERSION');
            $criteria->addSelectColumn($alias . '.VERSION_CREATED_AT');
            $criteria->addSelectColumn($alias . '.VERSION_CREATED_BY');
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
        return Propel::getServiceContainer()->getDatabaseMap(PaypalOrderTableMap::DATABASE_NAME)->getTable(PaypalOrderTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getServiceContainer()->getDatabaseMap(PaypalOrderTableMap::DATABASE_NAME);
      if (!$dbMap->hasTable(PaypalOrderTableMap::TABLE_NAME)) {
        $dbMap->addTableObject(new PaypalOrderTableMap());
      }
    }

    /**
     * Performs a DELETE on the database, given a PaypalOrder or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or PaypalOrder object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(PaypalOrderTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \PayPal\Model\PaypalOrder) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(PaypalOrderTableMap::DATABASE_NAME);
            $criteria->add(PaypalOrderTableMap::ID, (array) $values, Criteria::IN);
        }

        $query = PaypalOrderQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) { PaypalOrderTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) { PaypalOrderTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the paypal_order table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return PaypalOrderQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a PaypalOrder or Criteria object.
     *
     * @param mixed               $criteria Criteria or PaypalOrder object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PaypalOrderTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from PaypalOrder object
        }


        // Set the correct dbName
        $query = PaypalOrderQuery::create()->mergeWith($criteria);

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

} // PaypalOrderTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
PaypalOrderTableMap::buildTableMap();
