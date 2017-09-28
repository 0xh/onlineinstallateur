<?php

namespace OfferCreation\Model\Base;

use \Exception;
use \PDO;
use OfferCreation\Model\Offer as ChildOffer;
use OfferCreation\Model\OfferQuery as ChildOfferQuery;
use OfferCreation\Model\Map\OfferTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'offer' table.
 *
 *
 *
 * @method     ChildOfferQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildOfferQuery orderByRef($order = Criteria::ASC) Order by the ref column
 * @method     ChildOfferQuery orderByOrderId($order = Criteria::ASC) Order by the order_id column
 * @method     ChildOfferQuery orderByOrderRef($order = Criteria::ASC) Order by the order_ref column
 * @method     ChildOfferQuery orderByCustomerId($order = Criteria::ASC) Order by the customer_id column
 * @method     ChildOfferQuery orderByEmployeeId($order = Criteria::ASC) Order by the employee_id column
 * @method     ChildOfferQuery orderByInvoiceOrderAddressId($order = Criteria::ASC) Order by the invoice_order_address_id column
 * @method     ChildOfferQuery orderByDeliveryOrderAddressId($order = Criteria::ASC) Order by the delivery_order_address_id column
 * @method     ChildOfferQuery orderByInvoiceDate($order = Criteria::ASC) Order by the invoice_date column
 * @method     ChildOfferQuery orderByCurrencyId($order = Criteria::ASC) Order by the currency_id column
 * @method     ChildOfferQuery orderByCurrencyRate($order = Criteria::ASC) Order by the currency_rate column
 * @method     ChildOfferQuery orderByTransactionRef($order = Criteria::ASC) Order by the transaction_ref column
 * @method     ChildOfferQuery orderByDeliveryRef($order = Criteria::ASC) Order by the delivery_ref column
 * @method     ChildOfferQuery orderByInvoiceRef($order = Criteria::ASC) Order by the invoice_ref column
 * @method     ChildOfferQuery orderByDiscount($order = Criteria::ASC) Order by the discount column
 * @method     ChildOfferQuery orderByPostage($order = Criteria::ASC) Order by the postage column
 * @method     ChildOfferQuery orderByPostageTax($order = Criteria::ASC) Order by the postage_tax column
 * @method     ChildOfferQuery orderByPostageTaxRuleTitle($order = Criteria::ASC) Order by the postage_tax_rule_title column
 * @method     ChildOfferQuery orderByPaymentModuleId($order = Criteria::ASC) Order by the payment_module_id column
 * @method     ChildOfferQuery orderByDeliveryModuleId($order = Criteria::ASC) Order by the delivery_module_id column
 * @method     ChildOfferQuery orderByStatusId($order = Criteria::ASC) Order by the status_id column
 * @method     ChildOfferQuery orderByLangId($order = Criteria::ASC) Order by the lang_id column
 * @method     ChildOfferQuery orderByCartId($order = Criteria::ASC) Order by the cart_id column
 * @method     ChildOfferQuery orderByNoteEmployee($order = Criteria::ASC) Order by the note_employee column
 * @method     ChildOfferQuery orderByChatId($order = Criteria::ASC) Order by the chat_id column
 * @method     ChildOfferQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildOfferQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 * @method     ChildOfferQuery orderByVersion($order = Criteria::ASC) Order by the version column
 * @method     ChildOfferQuery orderByVersionCreatedAt($order = Criteria::ASC) Order by the version_created_at column
 * @method     ChildOfferQuery orderByVersionCreatedBy($order = Criteria::ASC) Order by the version_created_by column
 *
 * @method     ChildOfferQuery groupById() Group by the id column
 * @method     ChildOfferQuery groupByRef() Group by the ref column
 * @method     ChildOfferQuery groupByOrderId() Group by the order_id column
 * @method     ChildOfferQuery groupByOrderRef() Group by the order_ref column
 * @method     ChildOfferQuery groupByCustomerId() Group by the customer_id column
 * @method     ChildOfferQuery groupByEmployeeId() Group by the employee_id column
 * @method     ChildOfferQuery groupByInvoiceOrderAddressId() Group by the invoice_order_address_id column
 * @method     ChildOfferQuery groupByDeliveryOrderAddressId() Group by the delivery_order_address_id column
 * @method     ChildOfferQuery groupByInvoiceDate() Group by the invoice_date column
 * @method     ChildOfferQuery groupByCurrencyId() Group by the currency_id column
 * @method     ChildOfferQuery groupByCurrencyRate() Group by the currency_rate column
 * @method     ChildOfferQuery groupByTransactionRef() Group by the transaction_ref column
 * @method     ChildOfferQuery groupByDeliveryRef() Group by the delivery_ref column
 * @method     ChildOfferQuery groupByInvoiceRef() Group by the invoice_ref column
 * @method     ChildOfferQuery groupByDiscount() Group by the discount column
 * @method     ChildOfferQuery groupByPostage() Group by the postage column
 * @method     ChildOfferQuery groupByPostageTax() Group by the postage_tax column
 * @method     ChildOfferQuery groupByPostageTaxRuleTitle() Group by the postage_tax_rule_title column
 * @method     ChildOfferQuery groupByPaymentModuleId() Group by the payment_module_id column
 * @method     ChildOfferQuery groupByDeliveryModuleId() Group by the delivery_module_id column
 * @method     ChildOfferQuery groupByStatusId() Group by the status_id column
 * @method     ChildOfferQuery groupByLangId() Group by the lang_id column
 * @method     ChildOfferQuery groupByCartId() Group by the cart_id column
 * @method     ChildOfferQuery groupByNoteEmployee() Group by the note_employee column
 * @method     ChildOfferQuery groupByChatId() Group by the chat_id column
 * @method     ChildOfferQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildOfferQuery groupByUpdatedAt() Group by the updated_at column
 * @method     ChildOfferQuery groupByVersion() Group by the version column
 * @method     ChildOfferQuery groupByVersionCreatedAt() Group by the version_created_at column
 * @method     ChildOfferQuery groupByVersionCreatedBy() Group by the version_created_by column
 *
 * @method     ChildOfferQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildOfferQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildOfferQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildOfferQuery leftJoinOfferChat($relationAlias = null) Adds a LEFT JOIN clause to the query using the OfferChat relation
 * @method     ChildOfferQuery rightJoinOfferChat($relationAlias = null) Adds a RIGHT JOIN clause to the query using the OfferChat relation
 * @method     ChildOfferQuery innerJoinOfferChat($relationAlias = null) Adds a INNER JOIN clause to the query using the OfferChat relation
 *
 * @method     ChildOfferQuery leftJoinCurrency($relationAlias = null) Adds a LEFT JOIN clause to the query using the Currency relation
 * @method     ChildOfferQuery rightJoinCurrency($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Currency relation
 * @method     ChildOfferQuery innerJoinCurrency($relationAlias = null) Adds a INNER JOIN clause to the query using the Currency relation
 *
 * @method     ChildOfferQuery leftJoinCustomer($relationAlias = null) Adds a LEFT JOIN clause to the query using the Customer relation
 * @method     ChildOfferQuery rightJoinCustomer($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Customer relation
 * @method     ChildOfferQuery innerJoinCustomer($relationAlias = null) Adds a INNER JOIN clause to the query using the Customer relation
 *
 * @method     ChildOfferQuery leftJoinModuleRelatedByDeliveryModuleId($relationAlias = null) Adds a LEFT JOIN clause to the query using the ModuleRelatedByDeliveryModuleId relation
 * @method     ChildOfferQuery rightJoinModuleRelatedByDeliveryModuleId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ModuleRelatedByDeliveryModuleId relation
 * @method     ChildOfferQuery innerJoinModuleRelatedByDeliveryModuleId($relationAlias = null) Adds a INNER JOIN clause to the query using the ModuleRelatedByDeliveryModuleId relation
 *
 * @method     ChildOfferQuery leftJoinOrderAddressRelatedByDeliveryOrderAddressId($relationAlias = null) Adds a LEFT JOIN clause to the query using the OrderAddressRelatedByDeliveryOrderAddressId relation
 * @method     ChildOfferQuery rightJoinOrderAddressRelatedByDeliveryOrderAddressId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the OrderAddressRelatedByDeliveryOrderAddressId relation
 * @method     ChildOfferQuery innerJoinOrderAddressRelatedByDeliveryOrderAddressId($relationAlias = null) Adds a INNER JOIN clause to the query using the OrderAddressRelatedByDeliveryOrderAddressId relation
 *
 * @method     ChildOfferQuery leftJoinAdmin($relationAlias = null) Adds a LEFT JOIN clause to the query using the Admin relation
 * @method     ChildOfferQuery rightJoinAdmin($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Admin relation
 * @method     ChildOfferQuery innerJoinAdmin($relationAlias = null) Adds a INNER JOIN clause to the query using the Admin relation
 *
 * @method     ChildOfferQuery leftJoinOrderAddressRelatedByInvoiceOrderAddressId($relationAlias = null) Adds a LEFT JOIN clause to the query using the OrderAddressRelatedByInvoiceOrderAddressId relation
 * @method     ChildOfferQuery rightJoinOrderAddressRelatedByInvoiceOrderAddressId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the OrderAddressRelatedByInvoiceOrderAddressId relation
 * @method     ChildOfferQuery innerJoinOrderAddressRelatedByInvoiceOrderAddressId($relationAlias = null) Adds a INNER JOIN clause to the query using the OrderAddressRelatedByInvoiceOrderAddressId relation
 *
 * @method     ChildOfferQuery leftJoinLang($relationAlias = null) Adds a LEFT JOIN clause to the query using the Lang relation
 * @method     ChildOfferQuery rightJoinLang($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Lang relation
 * @method     ChildOfferQuery innerJoinLang($relationAlias = null) Adds a INNER JOIN clause to the query using the Lang relation
 *
 * @method     ChildOfferQuery leftJoinOrderRelatedByOrderId($relationAlias = null) Adds a LEFT JOIN clause to the query using the OrderRelatedByOrderId relation
 * @method     ChildOfferQuery rightJoinOrderRelatedByOrderId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the OrderRelatedByOrderId relation
 * @method     ChildOfferQuery innerJoinOrderRelatedByOrderId($relationAlias = null) Adds a INNER JOIN clause to the query using the OrderRelatedByOrderId relation
 *
 * @method     ChildOfferQuery leftJoinOrderRelatedByOrderRef($relationAlias = null) Adds a LEFT JOIN clause to the query using the OrderRelatedByOrderRef relation
 * @method     ChildOfferQuery rightJoinOrderRelatedByOrderRef($relationAlias = null) Adds a RIGHT JOIN clause to the query using the OrderRelatedByOrderRef relation
 * @method     ChildOfferQuery innerJoinOrderRelatedByOrderRef($relationAlias = null) Adds a INNER JOIN clause to the query using the OrderRelatedByOrderRef relation
 *
 * @method     ChildOfferQuery leftJoinModuleRelatedByPaymentModuleId($relationAlias = null) Adds a LEFT JOIN clause to the query using the ModuleRelatedByPaymentModuleId relation
 * @method     ChildOfferQuery rightJoinModuleRelatedByPaymentModuleId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ModuleRelatedByPaymentModuleId relation
 * @method     ChildOfferQuery innerJoinModuleRelatedByPaymentModuleId($relationAlias = null) Adds a INNER JOIN clause to the query using the ModuleRelatedByPaymentModuleId relation
 *
 * @method     ChildOfferQuery leftJoinOrderStatus($relationAlias = null) Adds a LEFT JOIN clause to the query using the OrderStatus relation
 * @method     ChildOfferQuery rightJoinOrderStatus($relationAlias = null) Adds a RIGHT JOIN clause to the query using the OrderStatus relation
 * @method     ChildOfferQuery innerJoinOrderStatus($relationAlias = null) Adds a INNER JOIN clause to the query using the OrderStatus relation
 *
 * @method     ChildOfferQuery leftJoinOfferProduct($relationAlias = null) Adds a LEFT JOIN clause to the query using the OfferProduct relation
 * @method     ChildOfferQuery rightJoinOfferProduct($relationAlias = null) Adds a RIGHT JOIN clause to the query using the OfferProduct relation
 * @method     ChildOfferQuery innerJoinOfferProduct($relationAlias = null) Adds a INNER JOIN clause to the query using the OfferProduct relation
 *
 * @method     ChildOfferQuery leftJoinOfferVersion($relationAlias = null) Adds a LEFT JOIN clause to the query using the OfferVersion relation
 * @method     ChildOfferQuery rightJoinOfferVersion($relationAlias = null) Adds a RIGHT JOIN clause to the query using the OfferVersion relation
 * @method     ChildOfferQuery innerJoinOfferVersion($relationAlias = null) Adds a INNER JOIN clause to the query using the OfferVersion relation
 *
 * @method     ChildOffer findOne(ConnectionInterface $con = null) Return the first ChildOffer matching the query
 * @method     ChildOffer findOneOrCreate(ConnectionInterface $con = null) Return the first ChildOffer matching the query, or a new ChildOffer object populated from the query conditions when no match is found
 *
 * @method     ChildOffer findOneById(int $id) Return the first ChildOffer filtered by the id column
 * @method     ChildOffer findOneByRef(string $ref) Return the first ChildOffer filtered by the ref column
 * @method     ChildOffer findOneByOrderId(int $order_id) Return the first ChildOffer filtered by the order_id column
 * @method     ChildOffer findOneByOrderRef(string $order_ref) Return the first ChildOffer filtered by the order_ref column
 * @method     ChildOffer findOneByCustomerId(int $customer_id) Return the first ChildOffer filtered by the customer_id column
 * @method     ChildOffer findOneByEmployeeId(int $employee_id) Return the first ChildOffer filtered by the employee_id column
 * @method     ChildOffer findOneByInvoiceOrderAddressId(int $invoice_order_address_id) Return the first ChildOffer filtered by the invoice_order_address_id column
 * @method     ChildOffer findOneByDeliveryOrderAddressId(int $delivery_order_address_id) Return the first ChildOffer filtered by the delivery_order_address_id column
 * @method     ChildOffer findOneByInvoiceDate(string $invoice_date) Return the first ChildOffer filtered by the invoice_date column
 * @method     ChildOffer findOneByCurrencyId(int $currency_id) Return the first ChildOffer filtered by the currency_id column
 * @method     ChildOffer findOneByCurrencyRate(double $currency_rate) Return the first ChildOffer filtered by the currency_rate column
 * @method     ChildOffer findOneByTransactionRef(string $transaction_ref) Return the first ChildOffer filtered by the transaction_ref column
 * @method     ChildOffer findOneByDeliveryRef(string $delivery_ref) Return the first ChildOffer filtered by the delivery_ref column
 * @method     ChildOffer findOneByInvoiceRef(string $invoice_ref) Return the first ChildOffer filtered by the invoice_ref column
 * @method     ChildOffer findOneByDiscount(string $discount) Return the first ChildOffer filtered by the discount column
 * @method     ChildOffer findOneByPostage(string $postage) Return the first ChildOffer filtered by the postage column
 * @method     ChildOffer findOneByPostageTax(string $postage_tax) Return the first ChildOffer filtered by the postage_tax column
 * @method     ChildOffer findOneByPostageTaxRuleTitle(string $postage_tax_rule_title) Return the first ChildOffer filtered by the postage_tax_rule_title column
 * @method     ChildOffer findOneByPaymentModuleId(int $payment_module_id) Return the first ChildOffer filtered by the payment_module_id column
 * @method     ChildOffer findOneByDeliveryModuleId(int $delivery_module_id) Return the first ChildOffer filtered by the delivery_module_id column
 * @method     ChildOffer findOneByStatusId(int $status_id) Return the first ChildOffer filtered by the status_id column
 * @method     ChildOffer findOneByLangId(int $lang_id) Return the first ChildOffer filtered by the lang_id column
 * @method     ChildOffer findOneByCartId(int $cart_id) Return the first ChildOffer filtered by the cart_id column
 * @method     ChildOffer findOneByNoteEmployee(string $note_employee) Return the first ChildOffer filtered by the note_employee column
 * @method     ChildOffer findOneByChatId(int $chat_id) Return the first ChildOffer filtered by the chat_id column
 * @method     ChildOffer findOneByCreatedAt(string $created_at) Return the first ChildOffer filtered by the created_at column
 * @method     ChildOffer findOneByUpdatedAt(string $updated_at) Return the first ChildOffer filtered by the updated_at column
 * @method     ChildOffer findOneByVersion(int $version) Return the first ChildOffer filtered by the version column
 * @method     ChildOffer findOneByVersionCreatedAt(string $version_created_at) Return the first ChildOffer filtered by the version_created_at column
 * @method     ChildOffer findOneByVersionCreatedBy(string $version_created_by) Return the first ChildOffer filtered by the version_created_by column
 *
 * @method     array findById(int $id) Return ChildOffer objects filtered by the id column
 * @method     array findByRef(string $ref) Return ChildOffer objects filtered by the ref column
 * @method     array findByOrderId(int $order_id) Return ChildOffer objects filtered by the order_id column
 * @method     array findByOrderRef(string $order_ref) Return ChildOffer objects filtered by the order_ref column
 * @method     array findByCustomerId(int $customer_id) Return ChildOffer objects filtered by the customer_id column
 * @method     array findByEmployeeId(int $employee_id) Return ChildOffer objects filtered by the employee_id column
 * @method     array findByInvoiceOrderAddressId(int $invoice_order_address_id) Return ChildOffer objects filtered by the invoice_order_address_id column
 * @method     array findByDeliveryOrderAddressId(int $delivery_order_address_id) Return ChildOffer objects filtered by the delivery_order_address_id column
 * @method     array findByInvoiceDate(string $invoice_date) Return ChildOffer objects filtered by the invoice_date column
 * @method     array findByCurrencyId(int $currency_id) Return ChildOffer objects filtered by the currency_id column
 * @method     array findByCurrencyRate(double $currency_rate) Return ChildOffer objects filtered by the currency_rate column
 * @method     array findByTransactionRef(string $transaction_ref) Return ChildOffer objects filtered by the transaction_ref column
 * @method     array findByDeliveryRef(string $delivery_ref) Return ChildOffer objects filtered by the delivery_ref column
 * @method     array findByInvoiceRef(string $invoice_ref) Return ChildOffer objects filtered by the invoice_ref column
 * @method     array findByDiscount(string $discount) Return ChildOffer objects filtered by the discount column
 * @method     array findByPostage(string $postage) Return ChildOffer objects filtered by the postage column
 * @method     array findByPostageTax(string $postage_tax) Return ChildOffer objects filtered by the postage_tax column
 * @method     array findByPostageTaxRuleTitle(string $postage_tax_rule_title) Return ChildOffer objects filtered by the postage_tax_rule_title column
 * @method     array findByPaymentModuleId(int $payment_module_id) Return ChildOffer objects filtered by the payment_module_id column
 * @method     array findByDeliveryModuleId(int $delivery_module_id) Return ChildOffer objects filtered by the delivery_module_id column
 * @method     array findByStatusId(int $status_id) Return ChildOffer objects filtered by the status_id column
 * @method     array findByLangId(int $lang_id) Return ChildOffer objects filtered by the lang_id column
 * @method     array findByCartId(int $cart_id) Return ChildOffer objects filtered by the cart_id column
 * @method     array findByNoteEmployee(string $note_employee) Return ChildOffer objects filtered by the note_employee column
 * @method     array findByChatId(int $chat_id) Return ChildOffer objects filtered by the chat_id column
 * @method     array findByCreatedAt(string $created_at) Return ChildOffer objects filtered by the created_at column
 * @method     array findByUpdatedAt(string $updated_at) Return ChildOffer objects filtered by the updated_at column
 * @method     array findByVersion(int $version) Return ChildOffer objects filtered by the version column
 * @method     array findByVersionCreatedAt(string $version_created_at) Return ChildOffer objects filtered by the version_created_at column
 * @method     array findByVersionCreatedBy(string $version_created_by) Return ChildOffer objects filtered by the version_created_by column
 *
 */
abstract class OfferQuery extends ModelCriteria
{
	
	// versionable behavior
	
	/**
	 * Whether the versioning is enabled
	 */
	static $isVersioningEnabled = true;
	
	/**
	 * Initializes internal state of \OfferCreation\Model\Base\OfferQuery object.
	 *
	 * @param     string $dbName The database name
	 * @param     string $modelName The phpName of a model, e.g. 'Book'
	 * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
	 */
	public function __construct($dbName = 'thelia', $modelName = '\\OfferCreation\\Model\\Offer', $modelAlias = null)
	{
		parent::__construct($dbName, $modelName, $modelAlias);
	}
	
	/**
	 * Returns a new ChildOfferQuery object.
	 *
	 * @param     string $modelAlias The alias of a model in the query
	 * @param     Criteria $criteria Optional Criteria to build the query from
	 *
	 * @return ChildOfferQuery
	 */
	public static function create($modelAlias = null, $criteria = null)
	{
		if ($criteria instanceof \OfferCreation\Model\OfferQuery) {
			return $criteria;
		}
		$query = new \OfferCreation\Model\OfferQuery();
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
	 * @return ChildOffer|array|mixed the result, formatted by the current formatter
	 */
	public function findPk($key, $con = null)
	{
		if ($key === null) {
			return null;
		}
		if ((null !== ($obj = OfferTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
			// the object is already in the instance pool
			return $obj;
		}
		if ($con === null) {
			$con = Propel::getServiceContainer()->getReadConnection(OfferTableMap::DATABASE_NAME);
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
	 * @return   ChildOffer A model object, or null if the key is not found
	 */
	protected function findPkSimple($key, $con)
	{
		$sql = 'SELECT ID, REF, ORDER_ID, ORDER_REF, CUSTOMER_ID, EMPLOYEE_ID, INVOICE_ORDER_ADDRESS_ID, DELIVERY_ORDER_ADDRESS_ID, INVOICE_DATE, CURRENCY_ID, CURRENCY_RATE, TRANSACTION_REF, DELIVERY_REF, INVOICE_REF, DISCOUNT, POSTAGE, POSTAGE_TAX, POSTAGE_TAX_RULE_TITLE, PAYMENT_MODULE_ID, DELIVERY_MODULE_ID, STATUS_ID, LANG_ID, CART_ID, NOTE_EMPLOYEE, CHAT_ID, CREATED_AT, UPDATED_AT, VERSION, VERSION_CREATED_AT, VERSION_CREATED_BY FROM offer WHERE ID = :p0';
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
			$obj = new ChildOffer();
			$obj->hydrate($row);
			OfferTableMap::addInstanceToPool($obj, (string) $key);
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
	 * @return ChildOffer|array|mixed the result, formatted by the current formatter
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
	 * @return ChildOfferQuery The current query, for fluid interface
	 */
	public function filterByPrimaryKey($key)
	{
		
		return $this->addUsingAlias(OfferTableMap::ID, $key, Criteria::EQUAL);
	}
	
	/**
	 * Filter the query by a list of primary keys
	 *
	 * @param     array $keys The list of primary key to use for the query
	 *
	 * @return ChildOfferQuery The current query, for fluid interface
	 */
	public function filterByPrimaryKeys($keys)
	{
		
		return $this->addUsingAlias(OfferTableMap::ID, $keys, Criteria::IN);
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
	 * @return ChildOfferQuery The current query, for fluid interface
	 */
	public function filterById($id = null, $comparison = null)
	{
		if (is_array($id)) {
			$useMinMax = false;
			if (isset($id['min'])) {
				$this->addUsingAlias(OfferTableMap::ID, $id['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($id['max'])) {
				$this->addUsingAlias(OfferTableMap::ID, $id['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		
		return $this->addUsingAlias(OfferTableMap::ID, $id, $comparison);
	}
	
	/**
	 * Filter the query on the ref column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByRef('fooValue');   // WHERE ref = 'fooValue'
	 * $query->filterByRef('%fooValue%'); // WHERE ref LIKE '%fooValue%'
	 * </code>
	 *
	 * @param     string $ref The value to use as filter.
	 *              Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return ChildOfferQuery The current query, for fluid interface
	 */
	public function filterByRef($ref = null, $comparison = null)
	{
		if (null === $comparison) {
			if (is_array($ref)) {
				$comparison = Criteria::IN;
			} elseif (preg_match('/[\%\*]/', $ref)) {
				$ref = str_replace('*', '%', $ref);
				$comparison = Criteria::LIKE;
			}
		}
		
		return $this->addUsingAlias(OfferTableMap::REF, $ref, $comparison);
	}
	
	/**
	 * Filter the query on the order_id column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByOrderId(1234); // WHERE order_id = 1234
	 * $query->filterByOrderId(array(12, 34)); // WHERE order_id IN (12, 34)
	 * $query->filterByOrderId(array('min' => 12)); // WHERE order_id > 12
	 * </code>
	 *
	 * @see       filterByOrderRelatedByOrderId()
	 *
	 * @param     mixed $orderId The value to use as filter.
	 *              Use scalar values for equality.
	 *              Use array values for in_array() equivalent.
	 *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return ChildOfferQuery The current query, for fluid interface
	 */
	public function filterByOrderId($orderId = null, $comparison = null)
	{
		if (is_array($orderId)) {
			$useMinMax = false;
			if (isset($orderId['min'])) {
				$this->addUsingAlias(OfferTableMap::ORDER_ID, $orderId['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($orderId['max'])) {
				$this->addUsingAlias(OfferTableMap::ORDER_ID, $orderId['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		
		return $this->addUsingAlias(OfferTableMap::ORDER_ID, $orderId, $comparison);
	}
	
	/**
	 * Filter the query on the order_ref column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByOrderRef('fooValue');   // WHERE order_ref = 'fooValue'
	 * $query->filterByOrderRef('%fooValue%'); // WHERE order_ref LIKE '%fooValue%'
	 * </code>
	 *
	 * @param     string $orderRef The value to use as filter.
	 *              Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return ChildOfferQuery The current query, for fluid interface
	 */
	public function filterByOrderRef($orderRef = null, $comparison = null)
	{
		if (null === $comparison) {
			if (is_array($orderRef)) {
				$comparison = Criteria::IN;
			} elseif (preg_match('/[\%\*]/', $orderRef)) {
				$orderRef = str_replace('*', '%', $orderRef);
				$comparison = Criteria::LIKE;
			}
		}
		
		return $this->addUsingAlias(OfferTableMap::ORDER_REF, $orderRef, $comparison);
	}
	
	/**
	 * Filter the query on the customer_id column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByCustomerId(1234); // WHERE customer_id = 1234
	 * $query->filterByCustomerId(array(12, 34)); // WHERE customer_id IN (12, 34)
	 * $query->filterByCustomerId(array('min' => 12)); // WHERE customer_id > 12
	 * </code>
	 *
	 * @see       filterByCustomer()
	 *
	 * @param     mixed $customerId The value to use as filter.
	 *              Use scalar values for equality.
	 *              Use array values for in_array() equivalent.
	 *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return ChildOfferQuery The current query, for fluid interface
	 */
	public function filterByCustomerId($customerId = null, $comparison = null)
	{
		if (is_array($customerId)) {
			$useMinMax = false;
			if (isset($customerId['min'])) {
				$this->addUsingAlias(OfferTableMap::CUSTOMER_ID, $customerId['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($customerId['max'])) {
				$this->addUsingAlias(OfferTableMap::CUSTOMER_ID, $customerId['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		
		return $this->addUsingAlias(OfferTableMap::CUSTOMER_ID, $customerId, $comparison);
	}
	
	/**
	 * Filter the query on the employee_id column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByEmployeeId(1234); // WHERE employee_id = 1234
	 * $query->filterByEmployeeId(array(12, 34)); // WHERE employee_id IN (12, 34)
	 * $query->filterByEmployeeId(array('min' => 12)); // WHERE employee_id > 12
	 * </code>
	 *
	 * @see       filterByAdmin()
	 *
	 * @param     mixed $employeeId The value to use as filter.
	 *              Use scalar values for equality.
	 *              Use array values for in_array() equivalent.
	 *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return ChildOfferQuery The current query, for fluid interface
	 */
	public function filterByEmployeeId($employeeId = null, $comparison = null)
	{
		if (is_array($employeeId)) {
			$useMinMax = false;
			if (isset($employeeId['min'])) {
				$this->addUsingAlias(OfferTableMap::EMPLOYEE_ID, $employeeId['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($employeeId['max'])) {
				$this->addUsingAlias(OfferTableMap::EMPLOYEE_ID, $employeeId['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		
		return $this->addUsingAlias(OfferTableMap::EMPLOYEE_ID, $employeeId, $comparison);
	}
	
	/**
	 * Filter the query on the invoice_order_address_id column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByInvoiceOrderAddressId(1234); // WHERE invoice_order_address_id = 1234
	 * $query->filterByInvoiceOrderAddressId(array(12, 34)); // WHERE invoice_order_address_id IN (12, 34)
	 * $query->filterByInvoiceOrderAddressId(array('min' => 12)); // WHERE invoice_order_address_id > 12
	 * </code>
	 *
	 * @see       filterByOrderAddressRelatedByInvoiceOrderAddressId()
	 *
	 * @param     mixed $invoiceOrderAddressId The value to use as filter.
	 *              Use scalar values for equality.
	 *              Use array values for in_array() equivalent.
	 *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return ChildOfferQuery The current query, for fluid interface
	 */
	public function filterByInvoiceOrderAddressId($invoiceOrderAddressId = null, $comparison = null)
	{
		if (is_array($invoiceOrderAddressId)) {
			$useMinMax = false;
			if (isset($invoiceOrderAddressId['min'])) {
				$this->addUsingAlias(OfferTableMap::INVOICE_ORDER_ADDRESS_ID, $invoiceOrderAddressId['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($invoiceOrderAddressId['max'])) {
				$this->addUsingAlias(OfferTableMap::INVOICE_ORDER_ADDRESS_ID, $invoiceOrderAddressId['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		
		return $this->addUsingAlias(OfferTableMap::INVOICE_ORDER_ADDRESS_ID, $invoiceOrderAddressId, $comparison);
	}
	
	/**
	 * Filter the query on the delivery_order_address_id column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByDeliveryOrderAddressId(1234); // WHERE delivery_order_address_id = 1234
	 * $query->filterByDeliveryOrderAddressId(array(12, 34)); // WHERE delivery_order_address_id IN (12, 34)
	 * $query->filterByDeliveryOrderAddressId(array('min' => 12)); // WHERE delivery_order_address_id > 12
	 * </code>
	 *
	 * @see       filterByOrderAddressRelatedByDeliveryOrderAddressId()
	 *
	 * @param     mixed $deliveryOrderAddressId The value to use as filter.
	 *              Use scalar values for equality.
	 *              Use array values for in_array() equivalent.
	 *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return ChildOfferQuery The current query, for fluid interface
	 */
	public function filterByDeliveryOrderAddressId($deliveryOrderAddressId = null, $comparison = null)
	{
		if (is_array($deliveryOrderAddressId)) {
			$useMinMax = false;
			if (isset($deliveryOrderAddressId['min'])) {
				$this->addUsingAlias(OfferTableMap::DELIVERY_ORDER_ADDRESS_ID, $deliveryOrderAddressId['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($deliveryOrderAddressId['max'])) {
				$this->addUsingAlias(OfferTableMap::DELIVERY_ORDER_ADDRESS_ID, $deliveryOrderAddressId['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		
		return $this->addUsingAlias(OfferTableMap::DELIVERY_ORDER_ADDRESS_ID, $deliveryOrderAddressId, $comparison);
	}
	
	/**
	 * Filter the query on the invoice_date column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByInvoiceDate('2011-03-14'); // WHERE invoice_date = '2011-03-14'
	 * $query->filterByInvoiceDate('now'); // WHERE invoice_date = '2011-03-14'
	 * $query->filterByInvoiceDate(array('max' => 'yesterday')); // WHERE invoice_date > '2011-03-13'
	 * </code>
	 *
	 * @param     mixed $invoiceDate The value to use as filter.
	 *              Values can be integers (unix timestamps), DateTime objects, or strings.
	 *              Empty strings are treated as NULL.
	 *              Use scalar values for equality.
	 *              Use array values for in_array() equivalent.
	 *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return ChildOfferQuery The current query, for fluid interface
	 */
	public function filterByInvoiceDate($invoiceDate = null, $comparison = null)
	{
		if (is_array($invoiceDate)) {
			$useMinMax = false;
			if (isset($invoiceDate['min'])) {
				$this->addUsingAlias(OfferTableMap::INVOICE_DATE, $invoiceDate['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($invoiceDate['max'])) {
				$this->addUsingAlias(OfferTableMap::INVOICE_DATE, $invoiceDate['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		
		return $this->addUsingAlias(OfferTableMap::INVOICE_DATE, $invoiceDate, $comparison);
	}
	
	/**
	 * Filter the query on the currency_id column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByCurrencyId(1234); // WHERE currency_id = 1234
	 * $query->filterByCurrencyId(array(12, 34)); // WHERE currency_id IN (12, 34)
	 * $query->filterByCurrencyId(array('min' => 12)); // WHERE currency_id > 12
	 * </code>
	 *
	 * @see       filterByCurrency()
	 *
	 * @param     mixed $currencyId The value to use as filter.
	 *              Use scalar values for equality.
	 *              Use array values for in_array() equivalent.
	 *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return ChildOfferQuery The current query, for fluid interface
	 */
	public function filterByCurrencyId($currencyId = null, $comparison = null)
	{
		if (is_array($currencyId)) {
			$useMinMax = false;
			if (isset($currencyId['min'])) {
				$this->addUsingAlias(OfferTableMap::CURRENCY_ID, $currencyId['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($currencyId['max'])) {
				$this->addUsingAlias(OfferTableMap::CURRENCY_ID, $currencyId['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		
		return $this->addUsingAlias(OfferTableMap::CURRENCY_ID, $currencyId, $comparison);
	}
	
	/**
	 * Filter the query on the currency_rate column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByCurrencyRate(1234); // WHERE currency_rate = 1234
	 * $query->filterByCurrencyRate(array(12, 34)); // WHERE currency_rate IN (12, 34)
	 * $query->filterByCurrencyRate(array('min' => 12)); // WHERE currency_rate > 12
	 * </code>
	 *
	 * @param     mixed $currencyRate The value to use as filter.
	 *              Use scalar values for equality.
	 *              Use array values for in_array() equivalent.
	 *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return ChildOfferQuery The current query, for fluid interface
	 */
	public function filterByCurrencyRate($currencyRate = null, $comparison = null)
	{
		if (is_array($currencyRate)) {
			$useMinMax = false;
			if (isset($currencyRate['min'])) {
				$this->addUsingAlias(OfferTableMap::CURRENCY_RATE, $currencyRate['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($currencyRate['max'])) {
				$this->addUsingAlias(OfferTableMap::CURRENCY_RATE, $currencyRate['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		
		return $this->addUsingAlias(OfferTableMap::CURRENCY_RATE, $currencyRate, $comparison);
	}
	
	/**
	 * Filter the query on the transaction_ref column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByTransactionRef('fooValue');   // WHERE transaction_ref = 'fooValue'
	 * $query->filterByTransactionRef('%fooValue%'); // WHERE transaction_ref LIKE '%fooValue%'
	 * </code>
	 *
	 * @param     string $transactionRef The value to use as filter.
	 *              Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return ChildOfferQuery The current query, for fluid interface
	 */
	public function filterByTransactionRef($transactionRef = null, $comparison = null)
	{
		if (null === $comparison) {
			if (is_array($transactionRef)) {
				$comparison = Criteria::IN;
			} elseif (preg_match('/[\%\*]/', $transactionRef)) {
				$transactionRef = str_replace('*', '%', $transactionRef);
				$comparison = Criteria::LIKE;
			}
		}
		
		return $this->addUsingAlias(OfferTableMap::TRANSACTION_REF, $transactionRef, $comparison);
	}
	
	/**
	 * Filter the query on the delivery_ref column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByDeliveryRef('fooValue');   // WHERE delivery_ref = 'fooValue'
	 * $query->filterByDeliveryRef('%fooValue%'); // WHERE delivery_ref LIKE '%fooValue%'
	 * </code>
	 *
	 * @param     string $deliveryRef The value to use as filter.
	 *              Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return ChildOfferQuery The current query, for fluid interface
	 */
	public function filterByDeliveryRef($deliveryRef = null, $comparison = null)
	{
		if (null === $comparison) {
			if (is_array($deliveryRef)) {
				$comparison = Criteria::IN;
			} elseif (preg_match('/[\%\*]/', $deliveryRef)) {
				$deliveryRef = str_replace('*', '%', $deliveryRef);
				$comparison = Criteria::LIKE;
			}
		}
		
		return $this->addUsingAlias(OfferTableMap::DELIVERY_REF, $deliveryRef, $comparison);
	}
	
	/**
	 * Filter the query on the invoice_ref column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByInvoiceRef('fooValue');   // WHERE invoice_ref = 'fooValue'
	 * $query->filterByInvoiceRef('%fooValue%'); // WHERE invoice_ref LIKE '%fooValue%'
	 * </code>
	 *
	 * @param     string $invoiceRef The value to use as filter.
	 *              Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return ChildOfferQuery The current query, for fluid interface
	 */
	public function filterByInvoiceRef($invoiceRef = null, $comparison = null)
	{
		if (null === $comparison) {
			if (is_array($invoiceRef)) {
				$comparison = Criteria::IN;
			} elseif (preg_match('/[\%\*]/', $invoiceRef)) {
				$invoiceRef = str_replace('*', '%', $invoiceRef);
				$comparison = Criteria::LIKE;
			}
		}
		
		return $this->addUsingAlias(OfferTableMap::INVOICE_REF, $invoiceRef, $comparison);
	}
	
	/**
	 * Filter the query on the discount column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByDiscount(1234); // WHERE discount = 1234
	 * $query->filterByDiscount(array(12, 34)); // WHERE discount IN (12, 34)
	 * $query->filterByDiscount(array('min' => 12)); // WHERE discount > 12
	 * </code>
	 *
	 * @param     mixed $discount The value to use as filter.
	 *              Use scalar values for equality.
	 *              Use array values for in_array() equivalent.
	 *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return ChildOfferQuery The current query, for fluid interface
	 */
	public function filterByDiscount($discount = null, $comparison = null)
	{
		if (is_array($discount)) {
			$useMinMax = false;
			if (isset($discount['min'])) {
				$this->addUsingAlias(OfferTableMap::DISCOUNT, $discount['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($discount['max'])) {
				$this->addUsingAlias(OfferTableMap::DISCOUNT, $discount['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		
		return $this->addUsingAlias(OfferTableMap::DISCOUNT, $discount, $comparison);
	}
	
	/**
	 * Filter the query on the postage column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByPostage(1234); // WHERE postage = 1234
	 * $query->filterByPostage(array(12, 34)); // WHERE postage IN (12, 34)
	 * $query->filterByPostage(array('min' => 12)); // WHERE postage > 12
	 * </code>
	 *
	 * @param     mixed $postage The value to use as filter.
	 *              Use scalar values for equality.
	 *              Use array values for in_array() equivalent.
	 *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return ChildOfferQuery The current query, for fluid interface
	 */
	public function filterByPostage($postage = null, $comparison = null)
	{
		if (is_array($postage)) {
			$useMinMax = false;
			if (isset($postage['min'])) {
				$this->addUsingAlias(OfferTableMap::POSTAGE, $postage['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($postage['max'])) {
				$this->addUsingAlias(OfferTableMap::POSTAGE, $postage['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		
		return $this->addUsingAlias(OfferTableMap::POSTAGE, $postage, $comparison);
	}
	
	/**
	 * Filter the query on the postage_tax column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByPostageTax(1234); // WHERE postage_tax = 1234
	 * $query->filterByPostageTax(array(12, 34)); // WHERE postage_tax IN (12, 34)
	 * $query->filterByPostageTax(array('min' => 12)); // WHERE postage_tax > 12
	 * </code>
	 *
	 * @param     mixed $postageTax The value to use as filter.
	 *              Use scalar values for equality.
	 *              Use array values for in_array() equivalent.
	 *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return ChildOfferQuery The current query, for fluid interface
	 */
	public function filterByPostageTax($postageTax = null, $comparison = null)
	{
		if (is_array($postageTax)) {
			$useMinMax = false;
			if (isset($postageTax['min'])) {
				$this->addUsingAlias(OfferTableMap::POSTAGE_TAX, $postageTax['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($postageTax['max'])) {
				$this->addUsingAlias(OfferTableMap::POSTAGE_TAX, $postageTax['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		
		return $this->addUsingAlias(OfferTableMap::POSTAGE_TAX, $postageTax, $comparison);
	}
	
	/**
	 * Filter the query on the postage_tax_rule_title column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByPostageTaxRuleTitle('fooValue');   // WHERE postage_tax_rule_title = 'fooValue'
	 * $query->filterByPostageTaxRuleTitle('%fooValue%'); // WHERE postage_tax_rule_title LIKE '%fooValue%'
	 * </code>
	 *
	 * @param     string $postageTaxRuleTitle The value to use as filter.
	 *              Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return ChildOfferQuery The current query, for fluid interface
	 */
	public function filterByPostageTaxRuleTitle($postageTaxRuleTitle = null, $comparison = null)
	{
		if (null === $comparison) {
			if (is_array($postageTaxRuleTitle)) {
				$comparison = Criteria::IN;
			} elseif (preg_match('/[\%\*]/', $postageTaxRuleTitle)) {
				$postageTaxRuleTitle = str_replace('*', '%', $postageTaxRuleTitle);
				$comparison = Criteria::LIKE;
			}
		}
		
		return $this->addUsingAlias(OfferTableMap::POSTAGE_TAX_RULE_TITLE, $postageTaxRuleTitle, $comparison);
	}
	
	/**
	 * Filter the query on the payment_module_id column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByPaymentModuleId(1234); // WHERE payment_module_id = 1234
	 * $query->filterByPaymentModuleId(array(12, 34)); // WHERE payment_module_id IN (12, 34)
	 * $query->filterByPaymentModuleId(array('min' => 12)); // WHERE payment_module_id > 12
	 * </code>
	 *
	 * @see       filterByModuleRelatedByPaymentModuleId()
	 *
	 * @param     mixed $paymentModuleId The value to use as filter.
	 *              Use scalar values for equality.
	 *              Use array values for in_array() equivalent.
	 *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return ChildOfferQuery The current query, for fluid interface
	 */
	public function filterByPaymentModuleId($paymentModuleId = null, $comparison = null)
	{
		if (is_array($paymentModuleId)) {
			$useMinMax = false;
			if (isset($paymentModuleId['min'])) {
				$this->addUsingAlias(OfferTableMap::PAYMENT_MODULE_ID, $paymentModuleId['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($paymentModuleId['max'])) {
				$this->addUsingAlias(OfferTableMap::PAYMENT_MODULE_ID, $paymentModuleId['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		
		return $this->addUsingAlias(OfferTableMap::PAYMENT_MODULE_ID, $paymentModuleId, $comparison);
	}
	
	/**
	 * Filter the query on the delivery_module_id column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByDeliveryModuleId(1234); // WHERE delivery_module_id = 1234
	 * $query->filterByDeliveryModuleId(array(12, 34)); // WHERE delivery_module_id IN (12, 34)
	 * $query->filterByDeliveryModuleId(array('min' => 12)); // WHERE delivery_module_id > 12
	 * </code>
	 *
	 * @see       filterByModuleRelatedByDeliveryModuleId()
	 *
	 * @param     mixed $deliveryModuleId The value to use as filter.
	 *              Use scalar values for equality.
	 *              Use array values for in_array() equivalent.
	 *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return ChildOfferQuery The current query, for fluid interface
	 */
	public function filterByDeliveryModuleId($deliveryModuleId = null, $comparison = null)
	{
		if (is_array($deliveryModuleId)) {
			$useMinMax = false;
			if (isset($deliveryModuleId['min'])) {
				$this->addUsingAlias(OfferTableMap::DELIVERY_MODULE_ID, $deliveryModuleId['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($deliveryModuleId['max'])) {
				$this->addUsingAlias(OfferTableMap::DELIVERY_MODULE_ID, $deliveryModuleId['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		
		return $this->addUsingAlias(OfferTableMap::DELIVERY_MODULE_ID, $deliveryModuleId, $comparison);
	}
	
	/**
	 * Filter the query on the status_id column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByStatusId(1234); // WHERE status_id = 1234
	 * $query->filterByStatusId(array(12, 34)); // WHERE status_id IN (12, 34)
	 * $query->filterByStatusId(array('min' => 12)); // WHERE status_id > 12
	 * </code>
	 *
	 * @see       filterByOrderStatus()
	 *
	 * @param     mixed $statusId The value to use as filter.
	 *              Use scalar values for equality.
	 *              Use array values for in_array() equivalent.
	 *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return ChildOfferQuery The current query, for fluid interface
	 */
	public function filterByStatusId($statusId = null, $comparison = null)
	{
		if (is_array($statusId)) {
			$useMinMax = false;
			if (isset($statusId['min'])) {
				$this->addUsingAlias(OfferTableMap::STATUS_ID, $statusId['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($statusId['max'])) {
				$this->addUsingAlias(OfferTableMap::STATUS_ID, $statusId['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		
		return $this->addUsingAlias(OfferTableMap::STATUS_ID, $statusId, $comparison);
	}
	
	/**
	 * Filter the query on the lang_id column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByLangId(1234); // WHERE lang_id = 1234
	 * $query->filterByLangId(array(12, 34)); // WHERE lang_id IN (12, 34)
	 * $query->filterByLangId(array('min' => 12)); // WHERE lang_id > 12
	 * </code>
	 *
	 * @see       filterByLang()
	 *
	 * @param     mixed $langId The value to use as filter.
	 *              Use scalar values for equality.
	 *              Use array values for in_array() equivalent.
	 *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return ChildOfferQuery The current query, for fluid interface
	 */
	public function filterByLangId($langId = null, $comparison = null)
	{
		if (is_array($langId)) {
			$useMinMax = false;
			if (isset($langId['min'])) {
				$this->addUsingAlias(OfferTableMap::LANG_ID, $langId['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($langId['max'])) {
				$this->addUsingAlias(OfferTableMap::LANG_ID, $langId['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		
		return $this->addUsingAlias(OfferTableMap::LANG_ID, $langId, $comparison);
	}
	
	/**
	 * Filter the query on the cart_id column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByCartId(1234); // WHERE cart_id = 1234
	 * $query->filterByCartId(array(12, 34)); // WHERE cart_id IN (12, 34)
	 * $query->filterByCartId(array('min' => 12)); // WHERE cart_id > 12
	 * </code>
	 *
	 * @param     mixed $cartId The value to use as filter.
	 *              Use scalar values for equality.
	 *              Use array values for in_array() equivalent.
	 *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return ChildOfferQuery The current query, for fluid interface
	 */
	public function filterByCartId($cartId = null, $comparison = null)
	{
		if (is_array($cartId)) {
			$useMinMax = false;
			if (isset($cartId['min'])) {
				$this->addUsingAlias(OfferTableMap::CART_ID, $cartId['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($cartId['max'])) {
				$this->addUsingAlias(OfferTableMap::CART_ID, $cartId['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		
		return $this->addUsingAlias(OfferTableMap::CART_ID, $cartId, $comparison);
	}
	
	/**
	 * Filter the query on the note_employee column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByNoteEmployee('fooValue');   // WHERE note_employee = 'fooValue'
	 * $query->filterByNoteEmployee('%fooValue%'); // WHERE note_employee LIKE '%fooValue%'
	 * </code>
	 *
	 * @param     string $noteEmployee The value to use as filter.
	 *              Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return ChildOfferQuery The current query, for fluid interface
	 */
	public function filterByNoteEmployee($noteEmployee = null, $comparison = null)
	{
		if (null === $comparison) {
			if (is_array($noteEmployee)) {
				$comparison = Criteria::IN;
			} elseif (preg_match('/[\%\*]/', $noteEmployee)) {
				$noteEmployee = str_replace('*', '%', $noteEmployee);
				$comparison = Criteria::LIKE;
			}
		}
		
		return $this->addUsingAlias(OfferTableMap::NOTE_EMPLOYEE, $noteEmployee, $comparison);
	}
	
	/**
	 * Filter the query on the chat_id column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByChatId(1234); // WHERE chat_id = 1234
	 * $query->filterByChatId(array(12, 34)); // WHERE chat_id IN (12, 34)
	 * $query->filterByChatId(array('min' => 12)); // WHERE chat_id > 12
	 * </code>
	 *
	 * @see       filterByOfferChat()
	 *
	 * @param     mixed $chatId The value to use as filter.
	 *              Use scalar values for equality.
	 *              Use array values for in_array() equivalent.
	 *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return ChildOfferQuery The current query, for fluid interface
	 */
	public function filterByChatId($chatId = null, $comparison = null)
	{
		if (is_array($chatId)) {
			$useMinMax = false;
			if (isset($chatId['min'])) {
				$this->addUsingAlias(OfferTableMap::CHAT_ID, $chatId['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($chatId['max'])) {
				$this->addUsingAlias(OfferTableMap::CHAT_ID, $chatId['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		
		return $this->addUsingAlias(OfferTableMap::CHAT_ID, $chatId, $comparison);
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
	 * @return ChildOfferQuery The current query, for fluid interface
	 */
	public function filterByCreatedAt($createdAt = null, $comparison = null)
	{
		if (is_array($createdAt)) {
			$useMinMax = false;
			if (isset($createdAt['min'])) {
				$this->addUsingAlias(OfferTableMap::CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($createdAt['max'])) {
				$this->addUsingAlias(OfferTableMap::CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		
		return $this->addUsingAlias(OfferTableMap::CREATED_AT, $createdAt, $comparison);
	}
	
	/**
	 * Filter the query on the updated_at column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByUpdatedAt('2011-03-14'); // WHERE updated_at = '2011-03-14'
	 * $query->filterByUpdatedAt('now'); // WHERE updated_at = '2011-03-14'
	 * $query->filterByUpdatedAt(array('max' => 'yesterday')); // WHERE updated_at > '2011-03-13'
	 * </code>
	 *
	 * @param     mixed $updatedAt The value to use as filter.
	 *              Values can be integers (unix timestamps), DateTime objects, or strings.
	 *              Empty strings are treated as NULL.
	 *              Use scalar values for equality.
	 *              Use array values for in_array() equivalent.
	 *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return ChildOfferQuery The current query, for fluid interface
	 */
	public function filterByUpdatedAt($updatedAt = null, $comparison = null)
	{
		if (is_array($updatedAt)) {
			$useMinMax = false;
			if (isset($updatedAt['min'])) {
				$this->addUsingAlias(OfferTableMap::UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($updatedAt['max'])) {
				$this->addUsingAlias(OfferTableMap::UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		
		return $this->addUsingAlias(OfferTableMap::UPDATED_AT, $updatedAt, $comparison);
	}
	
	/**
	 * Filter the query on the version column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByVersion(1234); // WHERE version = 1234
	 * $query->filterByVersion(array(12, 34)); // WHERE version IN (12, 34)
	 * $query->filterByVersion(array('min' => 12)); // WHERE version > 12
	 * </code>
	 *
	 * @param     mixed $version The value to use as filter.
	 *              Use scalar values for equality.
	 *              Use array values for in_array() equivalent.
	 *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return ChildOfferQuery The current query, for fluid interface
	 */
	public function filterByVersion($version = null, $comparison = null)
	{
		if (is_array($version)) {
			$useMinMax = false;
			if (isset($version['min'])) {
				$this->addUsingAlias(OfferTableMap::VERSION, $version['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($version['max'])) {
				$this->addUsingAlias(OfferTableMap::VERSION, $version['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		
		return $this->addUsingAlias(OfferTableMap::VERSION, $version, $comparison);
	}
	
	/**
	 * Filter the query on the version_created_at column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByVersionCreatedAt('2011-03-14'); // WHERE version_created_at = '2011-03-14'
	 * $query->filterByVersionCreatedAt('now'); // WHERE version_created_at = '2011-03-14'
	 * $query->filterByVersionCreatedAt(array('max' => 'yesterday')); // WHERE version_created_at > '2011-03-13'
	 * </code>
	 *
	 * @param     mixed $versionCreatedAt The value to use as filter.
	 *              Values can be integers (unix timestamps), DateTime objects, or strings.
	 *              Empty strings are treated as NULL.
	 *              Use scalar values for equality.
	 *              Use array values for in_array() equivalent.
	 *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return ChildOfferQuery The current query, for fluid interface
	 */
	public function filterByVersionCreatedAt($versionCreatedAt = null, $comparison = null)
	{
		if (is_array($versionCreatedAt)) {
			$useMinMax = false;
			if (isset($versionCreatedAt['min'])) {
				$this->addUsingAlias(OfferTableMap::VERSION_CREATED_AT, $versionCreatedAt['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($versionCreatedAt['max'])) {
				$this->addUsingAlias(OfferTableMap::VERSION_CREATED_AT, $versionCreatedAt['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		
		return $this->addUsingAlias(OfferTableMap::VERSION_CREATED_AT, $versionCreatedAt, $comparison);
	}
	
	/**
	 * Filter the query on the version_created_by column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByVersionCreatedBy('fooValue');   // WHERE version_created_by = 'fooValue'
	 * $query->filterByVersionCreatedBy('%fooValue%'); // WHERE version_created_by LIKE '%fooValue%'
	 * </code>
	 *
	 * @param     string $versionCreatedBy The value to use as filter.
	 *              Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return ChildOfferQuery The current query, for fluid interface
	 */
	public function filterByVersionCreatedBy($versionCreatedBy = null, $comparison = null)
	{
		if (null === $comparison) {
			if (is_array($versionCreatedBy)) {
				$comparison = Criteria::IN;
			} elseif (preg_match('/[\%\*]/', $versionCreatedBy)) {
				$versionCreatedBy = str_replace('*', '%', $versionCreatedBy);
				$comparison = Criteria::LIKE;
			}
		}
		
		return $this->addUsingAlias(OfferTableMap::VERSION_CREATED_BY, $versionCreatedBy, $comparison);
	}
	
	/**
	 * Filter the query by a related \OfferCreation\Model\OfferChat object
	 *
	 * @param \OfferCreation\Model\OfferChat|ObjectCollection $offerChat The related object(s) to use as filter
	 * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return ChildOfferQuery The current query, for fluid interface
	 */
	public function filterByOfferChat($offerChat, $comparison = null)
	{
		if ($offerChat instanceof \OfferCreation\Model\OfferChat) {
			return $this
			->addUsingAlias(OfferTableMap::CHAT_ID, $offerChat->getId(), $comparison);
		} elseif ($offerChat instanceof ObjectCollection) {
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
			
			return $this
			->addUsingAlias(OfferTableMap::CHAT_ID, $offerChat->toKeyValue('PrimaryKey', 'Id'), $comparison);
		} else {
			throw new PropelException('filterByOfferChat() only accepts arguments of type \OfferCreation\Model\OfferChat or Collection');
		}
	}
	
	/**
	 * Adds a JOIN clause to the query using the OfferChat relation
	 *
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return ChildOfferQuery The current query, for fluid interface
	 */
	public function joinOfferChat($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('OfferChat');
		
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
			$this->addJoinObject($join, 'OfferChat');
		}
		
		return $this;
	}
	
	/**
	 * Use the OfferChat relation OfferChat object
	 *
	 * @see useQuery()
	 *
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return   \OfferCreation\Model\OfferChatQuery A secondary query class using the current class as primary query
	 */
	public function useOfferChatQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
	{
		return $this
		->joinOfferChat($relationAlias, $joinType)
		->useQuery($relationAlias ? $relationAlias : 'OfferChat', '\OfferCreation\Model\OfferChatQuery');
	}
	
	/**
	 * Filter the query by a related \OfferCreation\Model\Currency object
	 *
	 * @param \OfferCreation\Model\Currency|ObjectCollection $currency The related object(s) to use as filter
	 * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return ChildOfferQuery The current query, for fluid interface
	 */
	public function filterByCurrency($currency, $comparison = null)
	{
		if ($currency instanceof \OfferCreation\Model\Currency) {
			return $this
			->addUsingAlias(OfferTableMap::CURRENCY_ID, $currency->getId(), $comparison);
		} elseif ($currency instanceof ObjectCollection) {
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
			
			return $this
			->addUsingAlias(OfferTableMap::CURRENCY_ID, $currency->toKeyValue('PrimaryKey', 'Id'), $comparison);
		} else {
			throw new PropelException('filterByCurrency() only accepts arguments of type \OfferCreation\Model\Currency or Collection');
		}
	}
	
	/**
	 * Adds a JOIN clause to the query using the Currency relation
	 *
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return ChildOfferQuery The current query, for fluid interface
	 */
	public function joinCurrency($relationAlias = null, $joinType = Criteria::INNER_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('Currency');
		
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
			$this->addJoinObject($join, 'Currency');
		}
		
		return $this;
	}
	
	/**
	 * Use the Currency relation Currency object
	 *
	 * @see useQuery()
	 *
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return   \OfferCreation\Model\CurrencyQuery A secondary query class using the current class as primary query
	 */
	public function useCurrencyQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
	{
		return $this
		->joinCurrency($relationAlias, $joinType)
		->useQuery($relationAlias ? $relationAlias : 'Currency', '\OfferCreation\Model\CurrencyQuery');
	}
	
	/**
	 * Filter the query by a related \OfferCreation\Model\Customer object
	 *
	 * @param \OfferCreation\Model\Customer|ObjectCollection $customer The related object(s) to use as filter
	 * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return ChildOfferQuery The current query, for fluid interface
	 */
	public function filterByCustomer($customer, $comparison = null)
	{
		if ($customer instanceof \OfferCreation\Model\Customer) {
			return $this
			->addUsingAlias(OfferTableMap::CUSTOMER_ID, $customer->getId(), $comparison);
		} elseif ($customer instanceof ObjectCollection) {
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
			
			return $this
			->addUsingAlias(OfferTableMap::CUSTOMER_ID, $customer->toKeyValue('PrimaryKey', 'Id'), $comparison);
		} else {
			throw new PropelException('filterByCustomer() only accepts arguments of type \OfferCreation\Model\Customer or Collection');
		}
	}
	
	/**
	 * Adds a JOIN clause to the query using the Customer relation
	 *
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return ChildOfferQuery The current query, for fluid interface
	 */
	public function joinCustomer($relationAlias = null, $joinType = Criteria::INNER_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('Customer');
		
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
			$this->addJoinObject($join, 'Customer');
		}
		
		return $this;
	}
	
	/**
	 * Use the Customer relation Customer object
	 *
	 * @see useQuery()
	 *
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return   \OfferCreation\Model\CustomerQuery A secondary query class using the current class as primary query
	 */
	public function useCustomerQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
	{
		return $this
		->joinCustomer($relationAlias, $joinType)
		->useQuery($relationAlias ? $relationAlias : 'Customer', '\OfferCreation\Model\CustomerQuery');
	}
	
	/**
	 * Filter the query by a related \OfferCreation\Model\Module object
	 *
	 * @param \OfferCreation\Model\Module|ObjectCollection $module The related object(s) to use as filter
	 * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return ChildOfferQuery The current query, for fluid interface
	 */
	public function filterByModuleRelatedByDeliveryModuleId($module, $comparison = null)
	{
		if ($module instanceof \OfferCreation\Model\Module) {
			return $this
			->addUsingAlias(OfferTableMap::DELIVERY_MODULE_ID, $module->getId(), $comparison);
		} elseif ($module instanceof ObjectCollection) {
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
			
			return $this
			->addUsingAlias(OfferTableMap::DELIVERY_MODULE_ID, $module->toKeyValue('PrimaryKey', 'Id'), $comparison);
		} else {
			throw new PropelException('filterByModuleRelatedByDeliveryModuleId() only accepts arguments of type \OfferCreation\Model\Module or Collection');
		}
	}
	
	/**
	 * Adds a JOIN clause to the query using the ModuleRelatedByDeliveryModuleId relation
	 *
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return ChildOfferQuery The current query, for fluid interface
	 */
	public function joinModuleRelatedByDeliveryModuleId($relationAlias = null, $joinType = Criteria::INNER_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('ModuleRelatedByDeliveryModuleId');
		
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
			$this->addJoinObject($join, 'ModuleRelatedByDeliveryModuleId');
		}
		
		return $this;
	}
	
	/**
	 * Use the ModuleRelatedByDeliveryModuleId relation Module object
	 *
	 * @see useQuery()
	 *
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return   \OfferCreation\Model\ModuleQuery A secondary query class using the current class as primary query
	 */
	public function useModuleRelatedByDeliveryModuleIdQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
	{
		return $this
		->joinModuleRelatedByDeliveryModuleId($relationAlias, $joinType)
		->useQuery($relationAlias ? $relationAlias : 'ModuleRelatedByDeliveryModuleId', '\OfferCreation\Model\ModuleQuery');
	}
	
	/**
	 * Filter the query by a related \OfferCreation\Model\OrderAddress object
	 *
	 * @param \OfferCreation\Model\OrderAddress|ObjectCollection $orderAddress The related object(s) to use as filter
	 * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return ChildOfferQuery The current query, for fluid interface
	 */
	public function filterByOrderAddressRelatedByDeliveryOrderAddressId($orderAddress, $comparison = null)
	{
		if ($orderAddress instanceof \OfferCreation\Model\OrderAddress) {
			return $this
			->addUsingAlias(OfferTableMap::DELIVERY_ORDER_ADDRESS_ID, $orderAddress->getId(), $comparison);
		} elseif ($orderAddress instanceof ObjectCollection) {
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
			
			return $this
			->addUsingAlias(OfferTableMap::DELIVERY_ORDER_ADDRESS_ID, $orderAddress->toKeyValue('PrimaryKey', 'Id'), $comparison);
		} else {
			throw new PropelException('filterByOrderAddressRelatedByDeliveryOrderAddressId() only accepts arguments of type \OfferCreation\Model\OrderAddress or Collection');
		}
	}
	
	/**
	 * Adds a JOIN clause to the query using the OrderAddressRelatedByDeliveryOrderAddressId relation
	 *
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return ChildOfferQuery The current query, for fluid interface
	 */
	public function joinOrderAddressRelatedByDeliveryOrderAddressId($relationAlias = null, $joinType = Criteria::INNER_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('OrderAddressRelatedByDeliveryOrderAddressId');
		
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
			$this->addJoinObject($join, 'OrderAddressRelatedByDeliveryOrderAddressId');
		}
		
		return $this;
	}
	
	/**
	 * Use the OrderAddressRelatedByDeliveryOrderAddressId relation OrderAddress object
	 *
	 * @see useQuery()
	 *
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return   \OfferCreation\Model\OrderAddressQuery A secondary query class using the current class as primary query
	 */
	public function useOrderAddressRelatedByDeliveryOrderAddressIdQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
	{
		return $this
		->joinOrderAddressRelatedByDeliveryOrderAddressId($relationAlias, $joinType)
		->useQuery($relationAlias ? $relationAlias : 'OrderAddressRelatedByDeliveryOrderAddressId', '\OfferCreation\Model\OrderAddressQuery');
	}
	
	/**
	 * Filter the query by a related \OfferCreation\Model\Admin object
	 *
	 * @param \OfferCreation\Model\Admin|ObjectCollection $admin The related object(s) to use as filter
	 * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return ChildOfferQuery The current query, for fluid interface
	 */
	public function filterByAdmin($admin, $comparison = null)
	{
		if ($admin instanceof \OfferCreation\Model\Admin) {
			return $this
			->addUsingAlias(OfferTableMap::EMPLOYEE_ID, $admin->getId(), $comparison);
		} elseif ($admin instanceof ObjectCollection) {
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
			
			return $this
			->addUsingAlias(OfferTableMap::EMPLOYEE_ID, $admin->toKeyValue('PrimaryKey', 'Id'), $comparison);
		} else {
			throw new PropelException('filterByAdmin() only accepts arguments of type \OfferCreation\Model\Admin or Collection');
		}
	}
	
	/**
	 * Adds a JOIN clause to the query using the Admin relation
	 *
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return ChildOfferQuery The current query, for fluid interface
	 */
	public function joinAdmin($relationAlias = null, $joinType = Criteria::INNER_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('Admin');
		
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
			$this->addJoinObject($join, 'Admin');
		}
		
		return $this;
	}
	
	/**
	 * Use the Admin relation Admin object
	 *
	 * @see useQuery()
	 *
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return   \OfferCreation\Model\AdminQuery A secondary query class using the current class as primary query
	 */
	public function useAdminQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
	{
		return $this
		->joinAdmin($relationAlias, $joinType)
		->useQuery($relationAlias ? $relationAlias : 'Admin', '\OfferCreation\Model\AdminQuery');
	}
	
	/**
	 * Filter the query by a related \OfferCreation\Model\OrderAddress object
	 *
	 * @param \OfferCreation\Model\OrderAddress|ObjectCollection $orderAddress The related object(s) to use as filter
	 * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return ChildOfferQuery The current query, for fluid interface
	 */
	public function filterByOrderAddressRelatedByInvoiceOrderAddressId($orderAddress, $comparison = null)
	{
		if ($orderAddress instanceof \OfferCreation\Model\OrderAddress) {
			return $this
			->addUsingAlias(OfferTableMap::INVOICE_ORDER_ADDRESS_ID, $orderAddress->getId(), $comparison);
		} elseif ($orderAddress instanceof ObjectCollection) {
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
			
			return $this
			->addUsingAlias(OfferTableMap::INVOICE_ORDER_ADDRESS_ID, $orderAddress->toKeyValue('PrimaryKey', 'Id'), $comparison);
		} else {
			throw new PropelException('filterByOrderAddressRelatedByInvoiceOrderAddressId() only accepts arguments of type \OfferCreation\Model\OrderAddress or Collection');
		}
	}
	
	/**
	 * Adds a JOIN clause to the query using the OrderAddressRelatedByInvoiceOrderAddressId relation
	 *
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return ChildOfferQuery The current query, for fluid interface
	 */
	public function joinOrderAddressRelatedByInvoiceOrderAddressId($relationAlias = null, $joinType = Criteria::INNER_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('OrderAddressRelatedByInvoiceOrderAddressId');
		
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
			$this->addJoinObject($join, 'OrderAddressRelatedByInvoiceOrderAddressId');
		}
		
		return $this;
	}
	
	/**
	 * Use the OrderAddressRelatedByInvoiceOrderAddressId relation OrderAddress object
	 *
	 * @see useQuery()
	 *
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return   \OfferCreation\Model\OrderAddressQuery A secondary query class using the current class as primary query
	 */
	public function useOrderAddressRelatedByInvoiceOrderAddressIdQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
	{
		return $this
		->joinOrderAddressRelatedByInvoiceOrderAddressId($relationAlias, $joinType)
		->useQuery($relationAlias ? $relationAlias : 'OrderAddressRelatedByInvoiceOrderAddressId', '\OfferCreation\Model\OrderAddressQuery');
	}
	
	/**
	 * Filter the query by a related \OfferCreation\Model\Lang object
	 *
	 * @param \OfferCreation\Model\Lang|ObjectCollection $lang The related object(s) to use as filter
	 * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return ChildOfferQuery The current query, for fluid interface
	 */
	public function filterByLang($lang, $comparison = null)
	{
		if ($lang instanceof \OfferCreation\Model\Lang) {
			return $this
			->addUsingAlias(OfferTableMap::LANG_ID, $lang->getId(), $comparison);
		} elseif ($lang instanceof ObjectCollection) {
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
			
			return $this
			->addUsingAlias(OfferTableMap::LANG_ID, $lang->toKeyValue('PrimaryKey', 'Id'), $comparison);
		} else {
			throw new PropelException('filterByLang() only accepts arguments of type \OfferCreation\Model\Lang or Collection');
		}
	}
	
	/**
	 * Adds a JOIN clause to the query using the Lang relation
	 *
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return ChildOfferQuery The current query, for fluid interface
	 */
	public function joinLang($relationAlias = null, $joinType = Criteria::INNER_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('Lang');
		
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
			$this->addJoinObject($join, 'Lang');
		}
		
		return $this;
	}
	
	/**
	 * Use the Lang relation Lang object
	 *
	 * @see useQuery()
	 *
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return   \OfferCreation\Model\LangQuery A secondary query class using the current class as primary query
	 */
	public function useLangQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
	{
		return $this
		->joinLang($relationAlias, $joinType)
		->useQuery($relationAlias ? $relationAlias : 'Lang', '\OfferCreation\Model\LangQuery');
	}
	
	/**
	 * Filter the query by a related \OfferCreation\Model\Order object
	 *
	 * @param \OfferCreation\Model\Order|ObjectCollection $order The related object(s) to use as filter
	 * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return ChildOfferQuery The current query, for fluid interface
	 */
	public function filterByOrderRelatedByOrderId($order, $comparison = null)
	{
		if ($order instanceof \OfferCreation\Model\Order) {
			return $this
			->addUsingAlias(OfferTableMap::ORDER_ID, $order->getId(), $comparison);
		} elseif ($order instanceof ObjectCollection) {
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
			
			return $this
			->addUsingAlias(OfferTableMap::ORDER_ID, $order->toKeyValue('PrimaryKey', 'Id'), $comparison);
		} else {
			throw new PropelException('filterByOrderRelatedByOrderId() only accepts arguments of type \OfferCreation\Model\Order or Collection');
		}
	}
	
	/**
	 * Adds a JOIN clause to the query using the OrderRelatedByOrderId relation
	 *
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return ChildOfferQuery The current query, for fluid interface
	 */
	public function joinOrderRelatedByOrderId($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('OrderRelatedByOrderId');
		
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
			$this->addJoinObject($join, 'OrderRelatedByOrderId');
		}
		
		return $this;
	}
	
	/**
	 * Use the OrderRelatedByOrderId relation Order object
	 *
	 * @see useQuery()
	 *
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return   \OfferCreation\Model\OrderQuery A secondary query class using the current class as primary query
	 */
	public function useOrderRelatedByOrderIdQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
	{
		return $this
		->joinOrderRelatedByOrderId($relationAlias, $joinType)
		->useQuery($relationAlias ? $relationAlias : 'OrderRelatedByOrderId', '\OfferCreation\Model\OrderQuery');
	}
	
	/**
	 * Filter the query by a related \OfferCreation\Model\Order object
	 *
	 * @param \OfferCreation\Model\Order|ObjectCollection $order The related object(s) to use as filter
	 * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return ChildOfferQuery The current query, for fluid interface
	 */
	public function filterByOrderRelatedByOrderRef($order, $comparison = null)
	{
		if ($order instanceof \OfferCreation\Model\Order) {
			return $this
			->addUsingAlias(OfferTableMap::ORDER_REF, $order->getRef(), $comparison);
		} elseif ($order instanceof ObjectCollection) {
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
			
			return $this
			->addUsingAlias(OfferTableMap::ORDER_REF, $order->toKeyValue('PrimaryKey', 'Ref'), $comparison);
		} else {
			throw new PropelException('filterByOrderRelatedByOrderRef() only accepts arguments of type \OfferCreation\Model\Order or Collection');
		}
	}
	
	/**
	 * Adds a JOIN clause to the query using the OrderRelatedByOrderRef relation
	 *
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return ChildOfferQuery The current query, for fluid interface
	 */
	public function joinOrderRelatedByOrderRef($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('OrderRelatedByOrderRef');
		
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
			$this->addJoinObject($join, 'OrderRelatedByOrderRef');
		}
		
		return $this;
	}
	
	/**
	 * Use the OrderRelatedByOrderRef relation Order object
	 *
	 * @see useQuery()
	 *
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return   \OfferCreation\Model\OrderQuery A secondary query class using the current class as primary query
	 */
	public function useOrderRelatedByOrderRefQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
	{
		return $this
		->joinOrderRelatedByOrderRef($relationAlias, $joinType)
		->useQuery($relationAlias ? $relationAlias : 'OrderRelatedByOrderRef', '\OfferCreation\Model\OrderQuery');
	}
	
	/**
	 * Filter the query by a related \OfferCreation\Model\Module object
	 *
	 * @param \OfferCreation\Model\Module|ObjectCollection $module The related object(s) to use as filter
	 * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return ChildOfferQuery The current query, for fluid interface
	 */
	public function filterByModuleRelatedByPaymentModuleId($module, $comparison = null)
	{
		if ($module instanceof \OfferCreation\Model\Module) {
			return $this
			->addUsingAlias(OfferTableMap::PAYMENT_MODULE_ID, $module->getId(), $comparison);
		} elseif ($module instanceof ObjectCollection) {
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
			
			return $this
			->addUsingAlias(OfferTableMap::PAYMENT_MODULE_ID, $module->toKeyValue('PrimaryKey', 'Id'), $comparison);
		} else {
			throw new PropelException('filterByModuleRelatedByPaymentModuleId() only accepts arguments of type \OfferCreation\Model\Module or Collection');
		}
	}
	
	/**
	 * Adds a JOIN clause to the query using the ModuleRelatedByPaymentModuleId relation
	 *
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return ChildOfferQuery The current query, for fluid interface
	 */
	public function joinModuleRelatedByPaymentModuleId($relationAlias = null, $joinType = Criteria::INNER_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('ModuleRelatedByPaymentModuleId');
		
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
			$this->addJoinObject($join, 'ModuleRelatedByPaymentModuleId');
		}
		
		return $this;
	}
	
	/**
	 * Use the ModuleRelatedByPaymentModuleId relation Module object
	 *
	 * @see useQuery()
	 *
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return   \OfferCreation\Model\ModuleQuery A secondary query class using the current class as primary query
	 */
	public function useModuleRelatedByPaymentModuleIdQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
	{
		return $this
		->joinModuleRelatedByPaymentModuleId($relationAlias, $joinType)
		->useQuery($relationAlias ? $relationAlias : 'ModuleRelatedByPaymentModuleId', '\OfferCreation\Model\ModuleQuery');
	}
	
	/**
	 * Filter the query by a related \OfferCreation\Model\OrderStatus object
	 *
	 * @param \OfferCreation\Model\OrderStatus|ObjectCollection $orderStatus The related object(s) to use as filter
	 * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return ChildOfferQuery The current query, for fluid interface
	 */
	public function filterByOrderStatus($orderStatus, $comparison = null)
	{
		if ($orderStatus instanceof \OfferCreation\Model\OrderStatus) {
			return $this
			->addUsingAlias(OfferTableMap::STATUS_ID, $orderStatus->getId(), $comparison);
		} elseif ($orderStatus instanceof ObjectCollection) {
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
			
			return $this
			->addUsingAlias(OfferTableMap::STATUS_ID, $orderStatus->toKeyValue('PrimaryKey', 'Id'), $comparison);
		} else {
			throw new PropelException('filterByOrderStatus() only accepts arguments of type \OfferCreation\Model\OrderStatus or Collection');
		}
	}
	
	/**
	 * Adds a JOIN clause to the query using the OrderStatus relation
	 *
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return ChildOfferQuery The current query, for fluid interface
	 */
	public function joinOrderStatus($relationAlias = null, $joinType = Criteria::INNER_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('OrderStatus');
		
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
			$this->addJoinObject($join, 'OrderStatus');
		}
		
		return $this;
	}
	
	/**
	 * Use the OrderStatus relation OrderStatus object
	 *
	 * @see useQuery()
	 *
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return   \OfferCreation\Model\OrderStatusQuery A secondary query class using the current class as primary query
	 */
	public function useOrderStatusQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
	{
		return $this
		->joinOrderStatus($relationAlias, $joinType)
		->useQuery($relationAlias ? $relationAlias : 'OrderStatus', '\OfferCreation\Model\OrderStatusQuery');
	}
	
	/**
	 * Filter the query by a related \OfferCreation\Model\OfferProduct object
	 *
	 * @param \OfferCreation\Model\OfferProduct|ObjectCollection $offerProduct  the related object to use as filter
	 * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return ChildOfferQuery The current query, for fluid interface
	 */
	public function filterByOfferProduct($offerProduct, $comparison = null)
	{
		if ($offerProduct instanceof \OfferCreation\Model\OfferProduct) {
			return $this
			->addUsingAlias(OfferTableMap::ID, $offerProduct->getOfferId(), $comparison);
		} elseif ($offerProduct instanceof ObjectCollection) {
			return $this
			->useOfferProductQuery()
			->filterByPrimaryKeys($offerProduct->getPrimaryKeys())
			->endUse();
		} else {
			throw new PropelException('filterByOfferProduct() only accepts arguments of type \OfferCreation\Model\OfferProduct or Collection');
		}
	}
	
	/**
	 * Adds a JOIN clause to the query using the OfferProduct relation
	 *
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return ChildOfferQuery The current query, for fluid interface
	 */
	public function joinOfferProduct($relationAlias = null, $joinType = Criteria::INNER_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('OfferProduct');
		
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
			$this->addJoinObject($join, 'OfferProduct');
		}
		
		return $this;
	}
	
	/**
	 * Use the OfferProduct relation OfferProduct object
	 *
	 * @see useQuery()
	 *
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return   \OfferCreation\Model\OfferProductQuery A secondary query class using the current class as primary query
	 */
	public function useOfferProductQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
	{
		return $this
		->joinOfferProduct($relationAlias, $joinType)
		->useQuery($relationAlias ? $relationAlias : 'OfferProduct', '\OfferCreation\Model\OfferProductQuery');
	}
	
	/**
	 * Filter the query by a related \OfferCreation\Model\OfferVersion object
	 *
	 * @param \OfferCreation\Model\OfferVersion|ObjectCollection $offerVersion  the related object to use as filter
	 * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return ChildOfferQuery The current query, for fluid interface
	 */
	public function filterByOfferVersion($offerVersion, $comparison = null)
	{
		if ($offerVersion instanceof \OfferCreation\Model\OfferVersion) {
			return $this
			->addUsingAlias(OfferTableMap::ID, $offerVersion->getId(), $comparison);
		} elseif ($offerVersion instanceof ObjectCollection) {
			return $this
			->useOfferVersionQuery()
			->filterByPrimaryKeys($offerVersion->getPrimaryKeys())
			->endUse();
		} else {
			throw new PropelException('filterByOfferVersion() only accepts arguments of type \OfferCreation\Model\OfferVersion or Collection');
		}
	}
	
	/**
	 * Adds a JOIN clause to the query using the OfferVersion relation
	 *
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return ChildOfferQuery The current query, for fluid interface
	 */
	public function joinOfferVersion($relationAlias = null, $joinType = Criteria::INNER_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('OfferVersion');
		
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
			$this->addJoinObject($join, 'OfferVersion');
		}
		
		return $this;
	}
	
	/**
	 * Use the OfferVersion relation OfferVersion object
	 *
	 * @see useQuery()
	 *
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return   \OfferCreation\Model\OfferVersionQuery A secondary query class using the current class as primary query
	 */
	public function useOfferVersionQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
	{
		return $this
		->joinOfferVersion($relationAlias, $joinType)
		->useQuery($relationAlias ? $relationAlias : 'OfferVersion', '\OfferCreation\Model\OfferVersionQuery');
	}
	
	/**
	 * Exclude object from result
	 *
	 * @param   ChildOffer $offer Object to remove from the list of results
	 *
	 * @return ChildOfferQuery The current query, for fluid interface
	 */
	public function prune($offer = null)
	{
		if ($offer) {
			$this->addUsingAlias(OfferTableMap::ID, $offer->getId(), Criteria::NOT_EQUAL);
		}
		
		return $this;
	}
	
	/**
	 * Deletes all rows from the offer table.
	 *
	 * @param ConnectionInterface $con the connection to use
	 * @return int The number of affected rows (if supported by underlying database driver).
	 */
	public function doDeleteAll(ConnectionInterface $con = null)
	{
		if (null === $con) {
			$con = Propel::getServiceContainer()->getWriteConnection(OfferTableMap::DATABASE_NAME);
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
					OfferTableMap::clearInstancePool();
					OfferTableMap::clearRelatedInstancePool();
					
					$con->commit();
		} catch (PropelException $e) {
			$con->rollBack();
			throw $e;
		}
		
		return $affectedRows;
	}
	
	/**
	 * Performs a DELETE on the database, given a ChildOffer or Criteria object OR a primary key value.
	 *
	 * @param mixed               $values Criteria or ChildOffer object or primary key or array of primary keys
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
			$con = Propel::getServiceContainer()->getWriteConnection(OfferTableMap::DATABASE_NAME);
		}
		
		$criteria = $this;
		
		// Set the correct dbName
		$criteria->setDbName(OfferTableMap::DATABASE_NAME);
		
		$affectedRows = 0; // initialize var to track total num of affected rows
		
		try {
			// use transaction because $criteria could contain info
			// for more than one table or we could emulating ON DELETE CASCADE, etc.
			$con->beginTransaction();
			
			
			OfferTableMap::removeInstanceFromPool($criteria);
			
			$affectedRows += ModelCriteria::delete($con);
			OfferTableMap::clearRelatedInstancePool();
			$con->commit();
			
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollBack();
			throw $e;
		}
	}
	
	// timestampable behavior
	
	/**
	 * Filter by the latest updated
	 *
	 * @param      int $nbDays Maximum age of the latest update in days
	 *
	 * @return     ChildOfferQuery The current query, for fluid interface
	 */
	public function recentlyUpdated($nbDays = 7)
	{
		return $this->addUsingAlias(OfferTableMap::UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
	}
	
	/**
	 * Filter by the latest created
	 *
	 * @param      int $nbDays Maximum age of in days
	 *
	 * @return     ChildOfferQuery The current query, for fluid interface
	 */
	public function recentlyCreated($nbDays = 7)
	{
		return $this->addUsingAlias(OfferTableMap::CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
	}
	
	/**
	 * Order by update date desc
	 *
	 * @return     ChildOfferQuery The current query, for fluid interface
	 */
	public function lastUpdatedFirst()
	{
		return $this->addDescendingOrderByColumn(OfferTableMap::UPDATED_AT);
	}
	
	/**
	 * Order by update date asc
	 *
	 * @return     ChildOfferQuery The current query, for fluid interface
	 */
	public function firstUpdatedFirst()
	{
		return $this->addAscendingOrderByColumn(OfferTableMap::UPDATED_AT);
	}
	
	/**
	 * Order by create date desc
	 *
	 * @return     ChildOfferQuery The current query, for fluid interface
	 */
	public function lastCreatedFirst()
	{
		return $this->addDescendingOrderByColumn(OfferTableMap::CREATED_AT);
	}
	
	/**
	 * Order by create date asc
	 *
	 * @return     ChildOfferQuery The current query, for fluid interface
	 */
	public function firstCreatedFirst()
	{
		return $this->addAscendingOrderByColumn(OfferTableMap::CREATED_AT);
	}
	
	// versionable behavior
	
	/**
	 * Checks whether versioning is enabled
	 *
	 * @return boolean
	 */
	static public function isVersioningEnabled()
	{
		return self::$isVersioningEnabled;
	}
	
	/**
	 * Enables versioning
	 */
	static public function enableVersioning()
	{
		self::$isVersioningEnabled = true;
	}
	
	/**
	 * Disables versioning
	 */
	static public function disableVersioning()
	{
		self::$isVersioningEnabled = false;
	}
	
} // OfferQuery
