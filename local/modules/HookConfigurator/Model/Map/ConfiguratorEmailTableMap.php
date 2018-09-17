<?php

namespace HookConfigurator\Model\Map;

use HookConfigurator\Model\ConfiguratorEmail;
use HookConfigurator\Model\ConfiguratorEmailQuery;
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
 * This class defines the structure of the 'configurator_email' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class ConfiguratorEmailTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;
    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'HookConfigurator.Model.Map.ConfiguratorEmailTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'thelia';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'configurator_email';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\HookConfigurator\\Model\\ConfiguratorEmail';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'HookConfigurator.Model.ConfiguratorEmail';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 26;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 26;

    /**
     * the column name for the ID field
     */
    const ID = 'configurator_email.ID';

    /**
     * the column name for the WITH_SEARCH_RESULT field
     */
    const WITH_SEARCH_RESULT = 'configurator_email.WITH_SEARCH_RESULT';

    /**
     * the column name for the ID_CATEGORY_SEARCH field
     */
    const ID_CATEGORY_SEARCH = 'configurator_email.ID_CATEGORY_SEARCH';

    /**
     * the column name for the VISIBLE_FORM_CONTACT field
     */
    const VISIBLE_FORM_CONTACT = 'configurator_email.VISIBLE_FORM_CONTACT';

    /**
     * the column name for the REQUIRED_VORNAME field
     */
    const REQUIRED_VORNAME = 'configurator_email.REQUIRED_VORNAME';

    /**
     * the column name for the VISIBLE_VORNAME field
     */
    const VISIBLE_VORNAME = 'configurator_email.VISIBLE_VORNAME';

    /**
     * the column name for the REQUIRED_NACHNAME field
     */
    const REQUIRED_NACHNAME = 'configurator_email.REQUIRED_NACHNAME';

    /**
     * the column name for the VISIBLE_NACHNAME field
     */
    const VISIBLE_NACHNAME = 'configurator_email.VISIBLE_NACHNAME';

    /**
     * the column name for the REQUIRED_STR field
     */
    const REQUIRED_STR = 'configurator_email.REQUIRED_STR';

    /**
     * the column name for the VISIBLE_STR field
     */
    const VISIBLE_STR = 'configurator_email.VISIBLE_STR';

    /**
     * the column name for the REQUIRED_PLZ field
     */
    const REQUIRED_PLZ = 'configurator_email.REQUIRED_PLZ';

    /**
     * the column name for the VISIBLE_PLZ field
     */
    const VISIBLE_PLZ = 'configurator_email.VISIBLE_PLZ';

    /**
     * the column name for the REQUIRED_ORT field
     */
    const REQUIRED_ORT = 'configurator_email.REQUIRED_ORT';

    /**
     * the column name for the VISIBLE_ORT field
     */
    const VISIBLE_ORT = 'configurator_email.VISIBLE_ORT';

    /**
     * the column name for the REQUIRED_TELEFON field
     */
    const REQUIRED_TELEFON = 'configurator_email.REQUIRED_TELEFON';

    /**
     * the column name for the VISIBLE_TELEFON field
     */
    const VISIBLE_TELEFON = 'configurator_email.VISIBLE_TELEFON';

    /**
     * the column name for the REQUIRED_EMAIL field
     */
    const REQUIRED_EMAIL = 'configurator_email.REQUIRED_EMAIL';

    /**
     * the column name for the VISIBLE_EMAIL field
     */
    const VISIBLE_EMAIL = 'configurator_email.VISIBLE_EMAIL';

    /**
     * the column name for the REQUIRED_TERMS field
     */
    const REQUIRED_TERMS = 'configurator_email.REQUIRED_TERMS';

    /**
     * the column name for the VISIBLE_TERMS field
     */
    const VISIBLE_TERMS = 'configurator_email.VISIBLE_TERMS';

    /**
     * the column name for the REQUIRED_SEND field
     */
    const REQUIRED_SEND = 'configurator_email.REQUIRED_SEND';

    /**
     * the column name for the VISIBLE_SEND field
     */
    const VISIBLE_SEND = 'configurator_email.VISIBLE_SEND';

    /**
     * the column name for the SEND_EMAIL field
     */
    const SEND_EMAIL = 'configurator_email.SEND_EMAIL';

    /**
     * the column name for the TEMPLATE_EMAIL_NAME_CUSTOMER field
     */
    const TEMPLATE_EMAIL_NAME_CUSTOMER = 'configurator_email.TEMPLATE_EMAIL_NAME_CUSTOMER';

    /**
     * the column name for the TEMPLATE_EMAIL_NAME_ADMIN field
     */
    const TEMPLATE_EMAIL_NAME_ADMIN = 'configurator_email.TEMPLATE_EMAIL_NAME_ADMIN';

    /**
     * the column name for the TEMPLATE_REDIRECT_SEARCH field
     */
    const TEMPLATE_REDIRECT_SEARCH = 'configurator_email.TEMPLATE_REDIRECT_SEARCH';

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
        self::TYPE_PHPNAME       => array('Id', 'WithSearchResult', 'IdCategorySearch', 'VisibleFormContact', 'RequiredVorname', 'VisibleVorname', 'RequiredNachname', 'VisibleNachname', 'RequiredStr', 'VisibleStr', 'RequiredPlz', 'VisiblePlz', 'RequiredOrt', 'VisibleOrt', 'RequiredTelefon', 'VisibleTelefon', 'RequiredEmail', 'VisibleEmail', 'RequiredTerms', 'VisibleTerms', 'RequiredSend', 'VisibleSend', 'SendEmail', 'TemplateEmailNameCustomer', 'TemplateEmailNameAdmin', 'TemplateRedirectSearch', ),
        self::TYPE_STUDLYPHPNAME => array('id', 'withSearchResult', 'idCategorySearch', 'visibleFormContact', 'requiredVorname', 'visibleVorname', 'requiredNachname', 'visibleNachname', 'requiredStr', 'visibleStr', 'requiredPlz', 'visiblePlz', 'requiredOrt', 'visibleOrt', 'requiredTelefon', 'visibleTelefon', 'requiredEmail', 'visibleEmail', 'requiredTerms', 'visibleTerms', 'requiredSend', 'visibleSend', 'sendEmail', 'templateEmailNameCustomer', 'templateEmailNameAdmin', 'templateRedirectSearch', ),
        self::TYPE_COLNAME       => array(ConfiguratorEmailTableMap::ID, ConfiguratorEmailTableMap::WITH_SEARCH_RESULT, ConfiguratorEmailTableMap::ID_CATEGORY_SEARCH, ConfiguratorEmailTableMap::VISIBLE_FORM_CONTACT, ConfiguratorEmailTableMap::REQUIRED_VORNAME, ConfiguratorEmailTableMap::VISIBLE_VORNAME, ConfiguratorEmailTableMap::REQUIRED_NACHNAME, ConfiguratorEmailTableMap::VISIBLE_NACHNAME, ConfiguratorEmailTableMap::REQUIRED_STR, ConfiguratorEmailTableMap::VISIBLE_STR, ConfiguratorEmailTableMap::REQUIRED_PLZ, ConfiguratorEmailTableMap::VISIBLE_PLZ, ConfiguratorEmailTableMap::REQUIRED_ORT, ConfiguratorEmailTableMap::VISIBLE_ORT, ConfiguratorEmailTableMap::REQUIRED_TELEFON, ConfiguratorEmailTableMap::VISIBLE_TELEFON, ConfiguratorEmailTableMap::REQUIRED_EMAIL, ConfiguratorEmailTableMap::VISIBLE_EMAIL, ConfiguratorEmailTableMap::REQUIRED_TERMS, ConfiguratorEmailTableMap::VISIBLE_TERMS, ConfiguratorEmailTableMap::REQUIRED_SEND, ConfiguratorEmailTableMap::VISIBLE_SEND, ConfiguratorEmailTableMap::SEND_EMAIL, ConfiguratorEmailTableMap::TEMPLATE_EMAIL_NAME_CUSTOMER, ConfiguratorEmailTableMap::TEMPLATE_EMAIL_NAME_ADMIN, ConfiguratorEmailTableMap::TEMPLATE_REDIRECT_SEARCH, ),
        self::TYPE_RAW_COLNAME   => array('ID', 'WITH_SEARCH_RESULT', 'ID_CATEGORY_SEARCH', 'VISIBLE_FORM_CONTACT', 'REQUIRED_VORNAME', 'VISIBLE_VORNAME', 'REQUIRED_NACHNAME', 'VISIBLE_NACHNAME', 'REQUIRED_STR', 'VISIBLE_STR', 'REQUIRED_PLZ', 'VISIBLE_PLZ', 'REQUIRED_ORT', 'VISIBLE_ORT', 'REQUIRED_TELEFON', 'VISIBLE_TELEFON', 'REQUIRED_EMAIL', 'VISIBLE_EMAIL', 'REQUIRED_TERMS', 'VISIBLE_TERMS', 'REQUIRED_SEND', 'VISIBLE_SEND', 'SEND_EMAIL', 'TEMPLATE_EMAIL_NAME_CUSTOMER', 'TEMPLATE_EMAIL_NAME_ADMIN', 'TEMPLATE_REDIRECT_SEARCH', ),
        self::TYPE_FIELDNAME     => array('id', 'with_search_result', 'id_category_search', 'visible_form_contact', 'required_vorname', 'visible_vorname', 'required_nachname', 'visible_nachname', 'required_str', 'visible_str', 'required_plz', 'visible_plz', 'required_ort', 'visible_ort', 'required_telefon', 'visible_telefon', 'required_email', 'visible_email', 'required_terms', 'visible_terms', 'required_send', 'visible_send', 'send_email', 'template_email_name_customer', 'template_email_name_admin', 'template_redirect_search', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'WithSearchResult' => 1, 'IdCategorySearch' => 2, 'VisibleFormContact' => 3, 'RequiredVorname' => 4, 'VisibleVorname' => 5, 'RequiredNachname' => 6, 'VisibleNachname' => 7, 'RequiredStr' => 8, 'VisibleStr' => 9, 'RequiredPlz' => 10, 'VisiblePlz' => 11, 'RequiredOrt' => 12, 'VisibleOrt' => 13, 'RequiredTelefon' => 14, 'VisibleTelefon' => 15, 'RequiredEmail' => 16, 'VisibleEmail' => 17, 'RequiredTerms' => 18, 'VisibleTerms' => 19, 'RequiredSend' => 20, 'VisibleSend' => 21, 'SendEmail' => 22, 'TemplateEmailNameCustomer' => 23, 'TemplateEmailNameAdmin' => 24, 'TemplateRedirectSearch' => 25, ),
        self::TYPE_STUDLYPHPNAME => array('id' => 0, 'withSearchResult' => 1, 'idCategorySearch' => 2, 'visibleFormContact' => 3, 'requiredVorname' => 4, 'visibleVorname' => 5, 'requiredNachname' => 6, 'visibleNachname' => 7, 'requiredStr' => 8, 'visibleStr' => 9, 'requiredPlz' => 10, 'visiblePlz' => 11, 'requiredOrt' => 12, 'visibleOrt' => 13, 'requiredTelefon' => 14, 'visibleTelefon' => 15, 'requiredEmail' => 16, 'visibleEmail' => 17, 'requiredTerms' => 18, 'visibleTerms' => 19, 'requiredSend' => 20, 'visibleSend' => 21, 'sendEmail' => 22, 'templateEmailNameCustomer' => 23, 'templateEmailNameAdmin' => 24, 'templateRedirectSearch' => 25, ),
        self::TYPE_COLNAME       => array(ConfiguratorEmailTableMap::ID => 0, ConfiguratorEmailTableMap::WITH_SEARCH_RESULT => 1, ConfiguratorEmailTableMap::ID_CATEGORY_SEARCH => 2, ConfiguratorEmailTableMap::VISIBLE_FORM_CONTACT => 3, ConfiguratorEmailTableMap::REQUIRED_VORNAME => 4, ConfiguratorEmailTableMap::VISIBLE_VORNAME => 5, ConfiguratorEmailTableMap::REQUIRED_NACHNAME => 6, ConfiguratorEmailTableMap::VISIBLE_NACHNAME => 7, ConfiguratorEmailTableMap::REQUIRED_STR => 8, ConfiguratorEmailTableMap::VISIBLE_STR => 9, ConfiguratorEmailTableMap::REQUIRED_PLZ => 10, ConfiguratorEmailTableMap::VISIBLE_PLZ => 11, ConfiguratorEmailTableMap::REQUIRED_ORT => 12, ConfiguratorEmailTableMap::VISIBLE_ORT => 13, ConfiguratorEmailTableMap::REQUIRED_TELEFON => 14, ConfiguratorEmailTableMap::VISIBLE_TELEFON => 15, ConfiguratorEmailTableMap::REQUIRED_EMAIL => 16, ConfiguratorEmailTableMap::VISIBLE_EMAIL => 17, ConfiguratorEmailTableMap::REQUIRED_TERMS => 18, ConfiguratorEmailTableMap::VISIBLE_TERMS => 19, ConfiguratorEmailTableMap::REQUIRED_SEND => 20, ConfiguratorEmailTableMap::VISIBLE_SEND => 21, ConfiguratorEmailTableMap::SEND_EMAIL => 22, ConfiguratorEmailTableMap::TEMPLATE_EMAIL_NAME_CUSTOMER => 23, ConfiguratorEmailTableMap::TEMPLATE_EMAIL_NAME_ADMIN => 24, ConfiguratorEmailTableMap::TEMPLATE_REDIRECT_SEARCH => 25, ),
        self::TYPE_RAW_COLNAME   => array('ID' => 0, 'WITH_SEARCH_RESULT' => 1, 'ID_CATEGORY_SEARCH' => 2, 'VISIBLE_FORM_CONTACT' => 3, 'REQUIRED_VORNAME' => 4, 'VISIBLE_VORNAME' => 5, 'REQUIRED_NACHNAME' => 6, 'VISIBLE_NACHNAME' => 7, 'REQUIRED_STR' => 8, 'VISIBLE_STR' => 9, 'REQUIRED_PLZ' => 10, 'VISIBLE_PLZ' => 11, 'REQUIRED_ORT' => 12, 'VISIBLE_ORT' => 13, 'REQUIRED_TELEFON' => 14, 'VISIBLE_TELEFON' => 15, 'REQUIRED_EMAIL' => 16, 'VISIBLE_EMAIL' => 17, 'REQUIRED_TERMS' => 18, 'VISIBLE_TERMS' => 19, 'REQUIRED_SEND' => 20, 'VISIBLE_SEND' => 21, 'SEND_EMAIL' => 22, 'TEMPLATE_EMAIL_NAME_CUSTOMER' => 23, 'TEMPLATE_EMAIL_NAME_ADMIN' => 24, 'TEMPLATE_REDIRECT_SEARCH' => 25, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'with_search_result' => 1, 'id_category_search' => 2, 'visible_form_contact' => 3, 'required_vorname' => 4, 'visible_vorname' => 5, 'required_nachname' => 6, 'visible_nachname' => 7, 'required_str' => 8, 'visible_str' => 9, 'required_plz' => 10, 'visible_plz' => 11, 'required_ort' => 12, 'visible_ort' => 13, 'required_telefon' => 14, 'visible_telefon' => 15, 'required_email' => 16, 'visible_email' => 17, 'required_terms' => 18, 'visible_terms' => 19, 'required_send' => 20, 'visible_send' => 21, 'send_email' => 22, 'template_email_name_customer' => 23, 'template_email_name_admin' => 24, 'template_redirect_search' => 25, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, )
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
        $this->setName('configurator_email');
        $this->setPhpName('ConfiguratorEmail');
        $this->setClassName('\\HookConfigurator\\Model\\ConfiguratorEmail');
        $this->setPackage('HookConfigurator.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('WITH_SEARCH_RESULT', 'WithSearchResult', 'TINYINT', true, null, 0);
        $this->addColumn('ID_CATEGORY_SEARCH', 'IdCategorySearch', 'INTEGER', true, null, 1);
        $this->addColumn('VISIBLE_FORM_CONTACT', 'VisibleFormContact', 'TINYINT', true, null, 1);
        $this->addColumn('REQUIRED_VORNAME', 'RequiredVorname', 'TINYINT', true, null, 1);
        $this->addColumn('VISIBLE_VORNAME', 'VisibleVorname', 'TINYINT', true, null, 1);
        $this->addColumn('REQUIRED_NACHNAME', 'RequiredNachname', 'TINYINT', true, null, 1);
        $this->addColumn('VISIBLE_NACHNAME', 'VisibleNachname', 'TINYINT', true, null, 1);
        $this->addColumn('REQUIRED_STR', 'RequiredStr', 'TINYINT', true, null, 1);
        $this->addColumn('VISIBLE_STR', 'VisibleStr', 'TINYINT', true, null, 1);
        $this->addColumn('REQUIRED_PLZ', 'RequiredPlz', 'TINYINT', true, null, 1);
        $this->addColumn('VISIBLE_PLZ', 'VisiblePlz', 'TINYINT', true, null, 1);
        $this->addColumn('REQUIRED_ORT', 'RequiredOrt', 'TINYINT', true, null, 1);
        $this->addColumn('VISIBLE_ORT', 'VisibleOrt', 'TINYINT', true, null, 1);
        $this->addColumn('REQUIRED_TELEFON', 'RequiredTelefon', 'TINYINT', true, null, 1);
        $this->addColumn('VISIBLE_TELEFON', 'VisibleTelefon', 'TINYINT', true, null, 1);
        $this->addColumn('REQUIRED_EMAIL', 'RequiredEmail', 'TINYINT', true, null, 1);
        $this->addColumn('VISIBLE_EMAIL', 'VisibleEmail', 'TINYINT', true, null, 1);
        $this->addColumn('REQUIRED_TERMS', 'RequiredTerms', 'TINYINT', true, null, 1);
        $this->addColumn('VISIBLE_TERMS', 'VisibleTerms', 'TINYINT', true, null, 1);
        $this->addColumn('REQUIRED_SEND', 'RequiredSend', 'TINYINT', true, null, 1);
        $this->addColumn('VISIBLE_SEND', 'VisibleSend', 'TINYINT', true, null, 1);
        $this->addColumn('SEND_EMAIL', 'SendEmail', 'TINYINT', true, null, 1);
        $this->addColumn('TEMPLATE_EMAIL_NAME_CUSTOMER', 'TemplateEmailNameCustomer', 'VARCHAR', false, 255, null);
        $this->addColumn('TEMPLATE_EMAIL_NAME_ADMIN', 'TemplateEmailNameAdmin', 'VARCHAR', false, 255, null);
        $this->addColumn('TEMPLATE_REDIRECT_SEARCH', 'TemplateRedirectSearch', 'VARCHAR', false, 255, null);
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
        return $withPrefix ? ConfiguratorEmailTableMap::CLASS_DEFAULT : ConfiguratorEmailTableMap::OM_CLASS;
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
     * @return array (ConfiguratorEmail object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = ConfiguratorEmailTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = ConfiguratorEmailTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + ConfiguratorEmailTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = ConfiguratorEmailTableMap::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            ConfiguratorEmailTableMap::addInstanceToPool($obj, $key);
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
            $key = ConfiguratorEmailTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = ConfiguratorEmailTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                ConfiguratorEmailTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(ConfiguratorEmailTableMap::ID);
            $criteria->addSelectColumn(ConfiguratorEmailTableMap::WITH_SEARCH_RESULT);
            $criteria->addSelectColumn(ConfiguratorEmailTableMap::ID_CATEGORY_SEARCH);
            $criteria->addSelectColumn(ConfiguratorEmailTableMap::VISIBLE_FORM_CONTACT);
            $criteria->addSelectColumn(ConfiguratorEmailTableMap::REQUIRED_VORNAME);
            $criteria->addSelectColumn(ConfiguratorEmailTableMap::VISIBLE_VORNAME);
            $criteria->addSelectColumn(ConfiguratorEmailTableMap::REQUIRED_NACHNAME);
            $criteria->addSelectColumn(ConfiguratorEmailTableMap::VISIBLE_NACHNAME);
            $criteria->addSelectColumn(ConfiguratorEmailTableMap::REQUIRED_STR);
            $criteria->addSelectColumn(ConfiguratorEmailTableMap::VISIBLE_STR);
            $criteria->addSelectColumn(ConfiguratorEmailTableMap::REQUIRED_PLZ);
            $criteria->addSelectColumn(ConfiguratorEmailTableMap::VISIBLE_PLZ);
            $criteria->addSelectColumn(ConfiguratorEmailTableMap::REQUIRED_ORT);
            $criteria->addSelectColumn(ConfiguratorEmailTableMap::VISIBLE_ORT);
            $criteria->addSelectColumn(ConfiguratorEmailTableMap::REQUIRED_TELEFON);
            $criteria->addSelectColumn(ConfiguratorEmailTableMap::VISIBLE_TELEFON);
            $criteria->addSelectColumn(ConfiguratorEmailTableMap::REQUIRED_EMAIL);
            $criteria->addSelectColumn(ConfiguratorEmailTableMap::VISIBLE_EMAIL);
            $criteria->addSelectColumn(ConfiguratorEmailTableMap::REQUIRED_TERMS);
            $criteria->addSelectColumn(ConfiguratorEmailTableMap::VISIBLE_TERMS);
            $criteria->addSelectColumn(ConfiguratorEmailTableMap::REQUIRED_SEND);
            $criteria->addSelectColumn(ConfiguratorEmailTableMap::VISIBLE_SEND);
            $criteria->addSelectColumn(ConfiguratorEmailTableMap::SEND_EMAIL);
            $criteria->addSelectColumn(ConfiguratorEmailTableMap::TEMPLATE_EMAIL_NAME_CUSTOMER);
            $criteria->addSelectColumn(ConfiguratorEmailTableMap::TEMPLATE_EMAIL_NAME_ADMIN);
            $criteria->addSelectColumn(ConfiguratorEmailTableMap::TEMPLATE_REDIRECT_SEARCH);
        } else {
            $criteria->addSelectColumn($alias . '.ID');
            $criteria->addSelectColumn($alias . '.WITH_SEARCH_RESULT');
            $criteria->addSelectColumn($alias . '.ID_CATEGORY_SEARCH');
            $criteria->addSelectColumn($alias . '.VISIBLE_FORM_CONTACT');
            $criteria->addSelectColumn($alias . '.REQUIRED_VORNAME');
            $criteria->addSelectColumn($alias . '.VISIBLE_VORNAME');
            $criteria->addSelectColumn($alias . '.REQUIRED_NACHNAME');
            $criteria->addSelectColumn($alias . '.VISIBLE_NACHNAME');
            $criteria->addSelectColumn($alias . '.REQUIRED_STR');
            $criteria->addSelectColumn($alias . '.VISIBLE_STR');
            $criteria->addSelectColumn($alias . '.REQUIRED_PLZ');
            $criteria->addSelectColumn($alias . '.VISIBLE_PLZ');
            $criteria->addSelectColumn($alias . '.REQUIRED_ORT');
            $criteria->addSelectColumn($alias . '.VISIBLE_ORT');
            $criteria->addSelectColumn($alias . '.REQUIRED_TELEFON');
            $criteria->addSelectColumn($alias . '.VISIBLE_TELEFON');
            $criteria->addSelectColumn($alias . '.REQUIRED_EMAIL');
            $criteria->addSelectColumn($alias . '.VISIBLE_EMAIL');
            $criteria->addSelectColumn($alias . '.REQUIRED_TERMS');
            $criteria->addSelectColumn($alias . '.VISIBLE_TERMS');
            $criteria->addSelectColumn($alias . '.REQUIRED_SEND');
            $criteria->addSelectColumn($alias . '.VISIBLE_SEND');
            $criteria->addSelectColumn($alias . '.SEND_EMAIL');
            $criteria->addSelectColumn($alias . '.TEMPLATE_EMAIL_NAME_CUSTOMER');
            $criteria->addSelectColumn($alias . '.TEMPLATE_EMAIL_NAME_ADMIN');
            $criteria->addSelectColumn($alias . '.TEMPLATE_REDIRECT_SEARCH');
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
        return Propel::getServiceContainer()->getDatabaseMap(ConfiguratorEmailTableMap::DATABASE_NAME)->getTable(ConfiguratorEmailTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getServiceContainer()->getDatabaseMap(ConfiguratorEmailTableMap::DATABASE_NAME);
      if (!$dbMap->hasTable(ConfiguratorEmailTableMap::TABLE_NAME)) {
        $dbMap->addTableObject(new ConfiguratorEmailTableMap());
      }
    }

    /**
     * Performs a DELETE on the database, given a ConfiguratorEmail or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ConfiguratorEmail object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(ConfiguratorEmailTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \HookConfigurator\Model\ConfiguratorEmail) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(ConfiguratorEmailTableMap::DATABASE_NAME);
            $criteria->add(ConfiguratorEmailTableMap::ID, (array) $values, Criteria::IN);
        }

        $query = ConfiguratorEmailQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) { ConfiguratorEmailTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) { ConfiguratorEmailTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the configurator_email table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return ConfiguratorEmailQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a ConfiguratorEmail or Criteria object.
     *
     * @param mixed               $criteria Criteria or ConfiguratorEmail object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ConfiguratorEmailTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from ConfiguratorEmail object
        }

        if ($criteria->containsKey(ConfiguratorEmailTableMap::ID) && $criteria->keyContainsValue(ConfiguratorEmailTableMap::ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.ConfiguratorEmailTableMap::ID.')');
        }


        // Set the correct dbName
        $query = ConfiguratorEmailQuery::create()->mergeWith($criteria);

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

} // ConfiguratorEmailTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
ConfiguratorEmailTableMap::buildTableMap();
