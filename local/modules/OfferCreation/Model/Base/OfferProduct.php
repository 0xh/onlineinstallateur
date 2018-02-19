<?php

namespace OfferCreation\Model\Base;

use \DateTime;
use \Exception;
use \PDO;
use OfferCreation\Model\Offer as ChildOffer;
use OfferCreation\Model\OfferProduct as ChildOfferProduct;
use OfferCreation\Model\OfferProductQuery as ChildOfferProductQuery;
use OfferCreation\Model\OfferProductTax as ChildOfferProductTax;
use OfferCreation\Model\OfferProductTaxQuery as ChildOfferProductTaxQuery;
use OfferCreation\Model\OfferQuery as ChildOfferQuery;
use OfferCreation\Model\Map\OfferProductTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;
use Propel\Runtime\Util\PropelDateTime;

abstract class OfferProduct implements ActiveRecordInterface
{
	/**
	 * TableMap class name
	 */
	const TABLE_MAP = '\\OfferCreation\\Model\\Map\\OfferProductTableMap';
	
	
	/**
	 * attribute to determine if this object has previously been saved.
	 * @var boolean
	 */
	protected $new = true;
	
	/**
	 * attribute to determine whether this object has been deleted.
	 * @var boolean
	 */
	protected $deleted = false;
	
	/**
	 * The columns that have been modified in current object.
	 * Tracking modified columns allows us to only update modified columns.
	 * @var array
	 */
	protected $modifiedColumns = array();
	
	/**
	 * The (virtual) columns that are added at runtime
	 * The formatters can add supplementary columns based on a resultset
	 * @var array
	 */
	protected $virtualColumns = array();
	
	/**
	 * The value for the id field.
	 * @var        int
	 */
	protected $id;
	
	/**
	 * The value for the offer_id field.
	 * @var        int
	 */
	protected $offer_id;
	
	/**
	 * The value for the product_ref field.
	 * @var        string
	 */
	protected $product_ref;
	
	/**
	 * The value for the product_sale_elements_ref field.
	 * @var        string
	 */
	protected $product_sale_elements_ref;
	
	/**
	 * The value for the product_sale_elements_id field.
	 * @var        int
	 */
	protected $product_sale_elements_id;
	
	/**
	 * The value for the title field.
	 * @var        string
	 */
	protected $title;
	
	/**
	 * The value for the chapo field.
	 * @var        string
	 */
	protected $chapo;
	
	/**
	 * The value for the description field.
	 * @var        string
	 */
	protected $description;
	
	/**
	 * The value for the postscriptum field.
	 * @var        string
	 */
	protected $postscriptum;
	
	/**
	 * The value for the quantity field.
	 * @var        double
	 */
	protected $quantity;
	
	/**
	 * The value for the price field.
	 * Note: this column has a database default value of: '0.000000'
	 * @var        string
	 */
	protected $price;
	
	/**
	 * The value for the promo_price field.
	 * Note: this column has a database default value of: '0.000000'
	 * @var        string
	 */
	protected $promo_price;
	
	/**
	 * The value for the was_new field.
	 * @var        int
	 */
	protected $was_new;
	
	/**
	 * The value for the was_in_promo field.
	 * @var        int
	 */
	protected $was_in_promo;
	
	/**
	 * The value for the weight field.
	 * @var        string
	 */
	protected $weight;
	
	/**
	 * The value for the ean_code field.
	 * @var        string
	 */
	protected $ean_code;
	
	/**
	 * The value for the tax_rule_title field.
	 * @var        string
	 */
	protected $tax_rule_title;
	
	/**
	 * The value for the tax_rule_description field.
	 * @var        string
	 */
	protected $tax_rule_description;
	
	/**
	 * The value for the parent field.
	 * @var        int
	 */
	protected $parent;
	
	/**
	 * The value for the virtual field.
	 * Note: this column has a database default value of: 0
	 * @var        int
	 */
	protected $virtual;
	
	/**
	 * The value for the virtual_document field.
	 * @var        string
	 */
	protected $virtual_document;
	
	/**
	 * The value for the created_at field.
	 * @var        string
	 */
	protected $created_at;
	
	/**
	 * The value for the updated_at field.
	 * @var        string
	 */
	protected $updated_at;
	
	/**
	 * @var        Offer
	 */
	protected $aOffer;
	
	/**
	 * @var        ObjectCollection|ChildOfferProductTax[] Collection to store aggregation of ChildOfferProductTax objects.
	 */
	protected $collOfferProductTaxes;
	protected $collOfferProductTaxesPartial;
	
	/**
	 * Flag to prevent endless save loop, if this object is referenced
	 * by another object which falls in this transaction.
	 *
	 * @var boolean
	 */
	protected $alreadyInSave = false;
	
	/**
	 * An array of objects scheduled for deletion.
	 * @var ObjectCollection
	 */
	protected $offerProductTaxesScheduledForDeletion = null;
	
	/**
	 * Applies default values to this object.
	 * This method should be called from the object's constructor (or
	 * equivalent initialization method).
	 * @see __construct()
	 */
	public function applyDefaultValues()
	{
		$this->price = '0.000000';
		$this->promo_price = '0.000000';
		$this->virtual = 0;
	}
	
	/**
	 * Initializes internal state of OfferCreation\Model\Base\OfferProduct object.
	 * @see applyDefaults()
	 */
	public function __construct()
	{
		$this->applyDefaultValues();
	}
	
	/**
	 * Returns whether the object has been modified.
	 *
	 * @return boolean True if the object has been modified.
	 */
	public function isModified()
	{
		return !!$this->modifiedColumns;
	}
	
	/**
	 * Has specified column been modified?
	 *
	 * @param  string  $col column fully qualified name (TableMap::TYPE_COLNAME), e.g. Book::AUTHOR_ID
	 * @return boolean True if $col has been modified.
	 */
	public function isColumnModified($col)
	{
		return $this->modifiedColumns && isset($this->modifiedColumns[$col]);
	}
	
	/**
	 * Get the columns that have been modified in this object.
	 * @return array A unique list of the modified column names for this object.
	 */
	public function getModifiedColumns()
	{
		return $this->modifiedColumns ? array_keys($this->modifiedColumns) : [];
	}
	
	/**
	 * Returns whether the object has ever been saved.  This will
	 * be false, if the object was retrieved from storage or was created
	 * and then saved.
	 *
	 * @return boolean true, if the object has never been persisted.
	 */
	public function isNew()
	{
		return $this->new;
	}
	
	/**
	 * Setter for the isNew attribute.  This method will be called
	 * by Propel-generated children and objects.
	 *
	 * @param boolean $b the state of the object.
	 */
	public function setNew($b)
	{
		$this->new = (Boolean) $b;
	}
	
	/**
	 * Whether this object has been deleted.
	 * @return boolean The deleted state of this object.
	 */
	public function isDeleted()
	{
		return $this->deleted;
	}
	
	/**
	 * Specify whether this object has been deleted.
	 * @param  boolean $b The deleted state of this object.
	 * @return void
	 */
	public function setDeleted($b)
	{
		$this->deleted = (Boolean) $b;
	}
	
	/**
	 * Sets the modified state for the object to be false.
	 * @param  string $col If supplied, only the specified column is reset.
	 * @return void
	 */
	public function resetModified($col = null)
	{
		if (null !== $col) {
			if (isset($this->modifiedColumns[$col])) {
				unset($this->modifiedColumns[$col]);
			}
		} else {
			$this->modifiedColumns = array();
		}
	}
	
	/**
	 * Compares this with another <code>OfferProduct</code> instance.  If
	 * <code>obj</code> is an instance of <code>OfferProduct</code>, delegates to
	 * <code>equals(OfferProduct)</code>.  Otherwise, returns <code>false</code>.
	 *
	 * @param  mixed   $obj The object to compare to.
	 * @return boolean Whether equal to the object specified.
	 */
	public function equals($obj)
	{
		$thisclazz = get_class($this);
		if (!is_object($obj) || !($obj instanceof $thisclazz)) {
			return false;
		}
		
		if ($this === $obj) {
			return true;
		}
		
		if (null === $this->getPrimaryKey()
				|| null === $obj->getPrimaryKey())  {
					return false;
				}
				
				return $this->getPrimaryKey() === $obj->getPrimaryKey();
	}
	
	/**
	 * If the primary key is not null, return the hashcode of the
	 * primary key. Otherwise, return the hash code of the object.
	 *
	 * @return int Hashcode
	 */
	public function hashCode()
	{
		if (null !== $this->getPrimaryKey()) {
			return crc32(serialize($this->getPrimaryKey()));
		}
		
		return crc32(serialize(clone $this));
	}
	
	/**
	 * Get the associative array of the virtual columns in this object
	 *
	 * @return array
	 */
	public function getVirtualColumns()
	{
		return $this->virtualColumns;
	}
	
	/**
	 * Checks the existence of a virtual column in this object
	 *
	 * @param  string  $name The virtual column name
	 * @return boolean
	 */
	public function hasVirtualColumn($name)
	{
		return array_key_exists($name, $this->virtualColumns);
	}
	
	/**
	 * Get the value of a virtual column in this object
	 *
	 * @param  string $name The virtual column name
	 * @return mixed
	 *
	 * @throws PropelException
	 */
	public function getVirtualColumn($name)
	{
		if (!$this->hasVirtualColumn($name)) {
			throw new PropelException(sprintf('Cannot get value of inexistent virtual column %s.', $name));
		}
		
		return $this->virtualColumns[$name];
	}
	
	/**
	 * Set the value of a virtual column in this object
	 *
	 * @param string $name  The virtual column name
	 * @param mixed  $value The value to give to the virtual column
	 *
	 * @return OfferProduct The current object, for fluid interface
	 */
	public function setVirtualColumn($name, $value)
	{
		$this->virtualColumns[$name] = $value;
		
		return $this;
	}
	
	/**
	 * Logs a message using Propel::log().
	 *
	 * @param  string  $msg
	 * @param  int     $priority One of the Propel::LOG_* logging levels
	 * @return boolean
	 */
	protected function log($msg, $priority = Propel::LOG_INFO)
	{
		return Propel::log(get_class($this) . ': ' . $msg, $priority);
	}
	
	/**
	 * Populate the current object from a string, using a given parser format
	 * <code>
	 * $book = new Book();
	 * $book->importFrom('JSON', '{"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
	 * </code>
	 *
	 * @param mixed $parser A AbstractParser instance,
	 *                       or a format name ('XML', 'YAML', 'JSON', 'CSV')
	 * @param string $data The source data to import from
	 *
	 * @return OfferProduct The current object, for fluid interface
	 */
	public function importFrom($parser, $data)
	{
		if (!$parser instanceof AbstractParser) {
			$parser = AbstractParser::getParser($parser);
		}
		
		$this->fromArray($parser->toArray($data), TableMap::TYPE_PHPNAME);
		
		return $this;
	}
	
	/**
	 * Export the current object properties to a string, using a given parser format
	 * <code>
	 * $book = BookQuery::create()->findPk(9012);
	 * echo $book->exportTo('JSON');
	 *  => {"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
	 * </code>
	 *
	 * @param  mixed   $parser                 A AbstractParser instance, or a format name ('XML', 'YAML', 'JSON', 'CSV')
	 * @param  boolean $includeLazyLoadColumns (optional) Whether to include lazy load(ed) columns. Defaults to TRUE.
	 * @return string  The exported data
	 */
	public function exportTo($parser, $includeLazyLoadColumns = true)
	{
		if (!$parser instanceof AbstractParser) {
			$parser = AbstractParser::getParser($parser);
		}
		
		return $parser->fromArray($this->toArray(TableMap::TYPE_PHPNAME, $includeLazyLoadColumns, array(), true));
	}
	
	/**
	 * Clean up internal collections prior to serializing
	 * Avoids recursive loops that turn into segmentation faults when serializing
	 */
	public function __sleep()
	{
		$this->clearAllReferences();
		
		return array_keys(get_object_vars($this));
	}
	
	/**
	 * Get the [id] column value.
	 *
	 * @return   int
	 */
	public function getId()
	{
		
		return $this->id;
	}
	
	/**
	 * Get the [offer_id] column value.
	 *
	 * @return   int
	 */
	public function getOfferId()
	{
		
		return $this->offer_id;
	}
	
	/**
	 * Get the [product_ref] column value.
	 *
	 * @return   string
	 */
	public function getProductRef()
	{
		
		return $this->product_ref;
	}
	
	/**
	 * Get the [product_sale_elements_ref] column value.
	 *
	 * @return   string
	 */
	public function getProductSaleElementsRef()
	{
		
		return $this->product_sale_elements_ref;
	}
	
	/**
	 * Get the [product_sale_elements_id] column value.
	 *
	 * @return   int
	 */
	public function getProductSaleElementsId()
	{
		
		return $this->product_sale_elements_id;
	}
	
	/**
	 * Get the [title] column value.
	 *
	 * @return   string
	 */
	public function getTitle()
	{
		
		return $this->title;
	}
	
	/**
	 * Get the [chapo] column value.
	 *
	 * @return   string
	 */
	public function getChapo()
	{
		
		return $this->chapo;
	}
	
	/**
	 * Get the [description] column value.
	 *
	 * @return   string
	 */
	public function getDescription()
	{
		
		return $this->description;
	}
	
	/**
	 * Get the [postscriptum] column value.
	 *
	 * @return   string
	 */
	public function getPostscriptum()
	{
		
		return $this->postscriptum;
	}
	
	/**
	 * Get the [quantity] column value.
	 *
	 * @return   double
	 */
	public function getQuantity()
	{
		
		return $this->quantity;
	}
	
	/**
	 * Get the [price] column value.
	 *
	 * @return   string
	 */
	public function getPrice()
	{
		
		return $this->price;
	}
	
	/**
	 * Get the [promo_price] column value.
	 *
	 * @return   string
	 */
	public function getPromoPrice()
	{
		
		return $this->promo_price;
	}
	
	/**
	 * Get the [was_new] column value.
	 *
	 * @return   int
	 */
	public function getWasNew()
	{
		
		return $this->was_new;
	}
	
	/**
	 * Get the [was_in_promo] column value.
	 *
	 * @return   int
	 */
	public function getWasInPromo()
	{
		
		return $this->was_in_promo;
	}
	
	/**
	 * Get the [weight] column value.
	 *
	 * @return   string
	 */
	public function getWeight()
	{
		
		return $this->weight;
	}
	
	/**
	 * Get the [ean_code] column value.
	 *
	 * @return   string
	 */
	public function getEanCode()
	{
		
		return $this->ean_code;
	}
	
	/**
	 * Get the [tax_rule_title] column value.
	 *
	 * @return   string
	 */
	public function getTaxRuleTitle()
	{
		
		return $this->tax_rule_title;
	}
	
	/**
	 * Get the [tax_rule_description] column value.
	 *
	 * @return   string
	 */
	public function getTaxRuleDescription()
	{
		
		return $this->tax_rule_description;
	}
	
	/**
	 * Get the [parent] column value.
	 *
	 * @return   int
	 */
	public function getParent()
	{
		
		return $this->parent;
	}
	
	/**
	 * Get the [virtual] column value.
	 *
	 * @return   int
	 */
	public function getVirtual()
	{
		
		return $this->virtual;
	}
	
	/**
	 * Get the [virtual_document] column value.
	 *
	 * @return   string
	 */
	public function getVirtualDocument()
	{
		
		return $this->virtual_document;
	}
	
	/**
	 * Get the [optionally formatted] temporal [created_at] column value.
	 *
	 *
	 * @param      string $format The date/time format string (either date()-style or strftime()-style).
	 *                            If format is NULL, then the raw \DateTime object will be returned.
	 *
	 * @return mixed Formatted date/time value as string or \DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
	 *
	 * @throws PropelException - if unable to parse/validate the date/time value.
	 */
	public function getCreatedAt($format = NULL)
	{
		if ($format === null) {
			return $this->created_at;
		} else {
			return $this->created_at instanceof \DateTime ? $this->created_at->format($format) : null;
		}
	}
	
	/**
	 * Get the [optionally formatted] temporal [updated_at] column value.
	 *
	 *
	 * @param      string $format The date/time format string (either date()-style or strftime()-style).
	 *                            If format is NULL, then the raw \DateTime object will be returned.
	 *
	 * @return mixed Formatted date/time value as string or \DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
	 *
	 * @throws PropelException - if unable to parse/validate the date/time value.
	 */
	public function getUpdatedAt($format = NULL)
	{
		if ($format === null) {
			return $this->updated_at;
		} else {
			return $this->updated_at instanceof \DateTime ? $this->updated_at->format($format) : null;
		}
	}
	
	/**
	 * Set the value of [id] column.
	 *
	 * @param      int $v new value
	 * @return   \OfferCreation\Model\OfferProduct The current object (for fluent API support)
	 */
	public function setId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}
		
		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[OfferProductTableMap::ID] = true;
		}
		
		
		return $this;
	} // setId()
	
	/**
	 * Set the value of [offer_id] column.
	 *
	 * @param      int $v new value
	 * @return   \OfferCreation\Model\OfferProduct The current object (for fluent API support)
	 */
	public function setOfferId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}
		
		if ($this->offer_id !== $v) {
			$this->offer_id = $v;
			$this->modifiedColumns[OfferProductTableMap::OFFER_ID] = true;
		}
		
		if ($this->aOffer !== null && $this->aOffer->getId() !== $v) {
			$this->aOffer = null;
		}
		
		
		return $this;
	} // setOfferId()
	
	/**
	 * Set the value of [product_ref] column.
	 *
	 * @param      string $v new value
	 * @return   \OfferCreation\Model\OfferProduct The current object (for fluent API support)
	 */
	public function setProductRef($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}
		
		if ($this->product_ref !== $v) {
			$this->product_ref = $v;
			$this->modifiedColumns[OfferProductTableMap::PRODUCT_REF] = true;
		}
		
		
		return $this;
	} // setProductRef()
	
	/**
	 * Set the value of [product_sale_elements_ref] column.
	 *
	 * @param      string $v new value
	 * @return   \OfferCreation\Model\OfferProduct The current object (for fluent API support)
	 */
	public function setProductSaleElementsRef($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}
		
		if ($this->product_sale_elements_ref !== $v) {
			$this->product_sale_elements_ref = $v;
			$this->modifiedColumns[OfferProductTableMap::PRODUCT_SALE_ELEMENTS_REF] = true;
		}
		
		
		return $this;
	} // setProductSaleElementsRef()
	
	/**
	 * Set the value of [product_sale_elements_id] column.
	 *
	 * @param      int $v new value
	 * @return   \OfferCreation\Model\OfferProduct The current object (for fluent API support)
	 */
	public function setProductSaleElementsId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}
		
		if ($this->product_sale_elements_id !== $v) {
			$this->product_sale_elements_id = $v;
			$this->modifiedColumns[OfferProductTableMap::PRODUCT_SALE_ELEMENTS_ID] = true;
		}
		
		
		return $this;
	} // setProductSaleElementsId()
	
	/**
	 * Set the value of [title] column.
	 *
	 * @param      string $v new value
	 * @return   \OfferCreation\Model\OfferProduct The current object (for fluent API support)
	 */
	public function setTitle($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}
		
		if ($this->title !== $v) {
			$this->title = $v;
			$this->modifiedColumns[OfferProductTableMap::TITLE] = true;
		}
		
		
		return $this;
	} // setTitle()
	
	/**
	 * Set the value of [chapo] column.
	 *
	 * @param      string $v new value
	 * @return   \OfferCreation\Model\OfferProduct The current object (for fluent API support)
	 */
	public function setChapo($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}
		
		if ($this->chapo !== $v) {
			$this->chapo = $v;
			$this->modifiedColumns[OfferProductTableMap::CHAPO] = true;
		}
		
		
		return $this;
	} // setChapo()
	
	/**
	 * Set the value of [description] column.
	 *
	 * @param      string $v new value
	 * @return   \OfferCreation\Model\OfferProduct The current object (for fluent API support)
	 */
	public function setDescription($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}
		
		if ($this->description !== $v) {
			$this->description = $v;
			$this->modifiedColumns[OfferProductTableMap::DESCRIPTION] = true;
		}
		
		
		return $this;
	} // setDescription()
	
	/**
	 * Set the value of [postscriptum] column.
	 *
	 * @param      string $v new value
	 * @return   \OfferCreation\Model\OfferProduct The current object (for fluent API support)
	 */
	public function setPostscriptum($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}
		
		if ($this->postscriptum !== $v) {
			$this->postscriptum = $v;
			$this->modifiedColumns[OfferProductTableMap::POSTSCRIPTUM] = true;
		}
		
		
		return $this;
	} // setPostscriptum()
	
	/**
	 * Set the value of [quantity] column.
	 *
	 * @param      double $v new value
	 * @return   \OfferCreation\Model\OfferProduct The current object (for fluent API support)
	 */
	public function setQuantity($v)
	{
		if ($v !== null) {
			$v = (double) $v;
		}
		
		if ($this->quantity !== $v) {
			$this->quantity = $v;
			$this->modifiedColumns[OfferProductTableMap::QUANTITY] = true;
		}
		
		
		return $this;
	} // setQuantity()
	
	/**
	 * Set the value of [price] column.
	 *
	 * @param      string $v new value
	 * @return   \OfferCreation\Model\OfferProduct The current object (for fluent API support)
	 */
	public function setPrice($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}
		
		if ($this->price !== $v) {
			$this->price = $v;
			$this->modifiedColumns[OfferProductTableMap::PRICE] = true;
		}
		
		
		return $this;
	} // setPrice()
	
	/**
	 * Set the value of [promo_price] column.
	 *
	 * @param      string $v new value
	 * @return   \OfferCreation\Model\OfferProduct The current object (for fluent API support)
	 */
	public function setPromoPrice($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}
		
		if ($this->promo_price !== $v) {
			$this->promo_price = $v;
			$this->modifiedColumns[OfferProductTableMap::PROMO_PRICE] = true;
		}
		
		
		return $this;
	} // setPromoPrice()
	
	/**
	 * Set the value of [was_new] column.
	 *
	 * @param      int $v new value
	 * @return   \OfferCreation\Model\OfferProduct The current object (for fluent API support)
	 */
	public function setWasNew($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}
		
		if ($this->was_new !== $v) {
			$this->was_new = $v;
			$this->modifiedColumns[OfferProductTableMap::WAS_NEW] = true;
		}
		
		
		return $this;
	} // setWasNew()
	
	/**
	 * Set the value of [was_in_promo] column.
	 *
	 * @param      int $v new value
	 * @return   \OfferCreation\Model\OfferProduct The current object (for fluent API support)
	 */
	public function setWasInPromo($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}
		
		if ($this->was_in_promo !== $v) {
			$this->was_in_promo = $v;
			$this->modifiedColumns[OfferProductTableMap::WAS_IN_PROMO] = true;
		}
		
		
		return $this;
	} // setWasInPromo()
	
	/**
	 * Set the value of [weight] column.
	 *
	 * @param      string $v new value
	 * @return   \OfferCreation\Model\OfferProduct The current object (for fluent API support)
	 */
	public function setWeight($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}
		
		if ($this->weight !== $v) {
			$this->weight = $v;
			$this->modifiedColumns[OfferProductTableMap::WEIGHT] = true;
		}
		
		
		return $this;
	} // setWeight()
	
	/**
	 * Set the value of [ean_code] column.
	 *
	 * @param      string $v new value
	 * @return   \OfferCreation\Model\OfferProduct The current object (for fluent API support)
	 */
	public function setEanCode($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}
		
		if ($this->ean_code !== $v) {
			$this->ean_code = $v;
			$this->modifiedColumns[OfferProductTableMap::EAN_CODE] = true;
		}
		
		
		return $this;
	} // setEanCode()
	
	/**
	 * Set the value of [tax_rule_title] column.
	 *
	 * @param      string $v new value
	 * @return   \OfferCreation\Model\OfferProduct The current object (for fluent API support)
	 */
	public function setTaxRuleTitle($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}
		
		if ($this->tax_rule_title !== $v) {
			$this->tax_rule_title = $v;
			$this->modifiedColumns[OfferProductTableMap::TAX_RULE_TITLE] = true;
		}
		
		
		return $this;
	} // setTaxRuleTitle()
	
	/**
	 * Set the value of [tax_rule_description] column.
	 *
	 * @param      string $v new value
	 * @return   \OfferCreation\Model\OfferProduct The current object (for fluent API support)
	 */
	public function setTaxRuleDescription($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}
		
		if ($this->tax_rule_description !== $v) {
			$this->tax_rule_description = $v;
			$this->modifiedColumns[OfferProductTableMap::TAX_RULE_DESCRIPTION] = true;
		}
		
		
		return $this;
	} // setTaxRuleDescription()
	
	/**
	 * Set the value of [parent] column.
	 *
	 * @param      int $v new value
	 * @return   \OfferCreation\Model\OfferProduct The current object (for fluent API support)
	 */
	public function setParent($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}
		
		if ($this->parent !== $v) {
			$this->parent = $v;
			$this->modifiedColumns[OfferProductTableMap::PARENT] = true;
		}
		
		
		return $this;
	} // setParent()
	
	/**
	 * Set the value of [virtual] column.
	 *
	 * @param      int $v new value
	 * @return   \OfferCreation\Model\OfferProduct The current object (for fluent API support)
	 */
	public function setVirtual($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}
		
		if ($this->virtual !== $v) {
			$this->virtual = $v;
			$this->modifiedColumns[OfferProductTableMap::VIRTUAL] = true;
		}
		
		
		return $this;
	} // setVirtual()
	
	/**
	 * Set the value of [virtual_document] column.
	 *
	 * @param      string $v new value
	 * @return   \OfferCreation\Model\OfferProduct The current object (for fluent API support)
	 */
	public function setVirtualDocument($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}
		
		if ($this->virtual_document !== $v) {
			$this->virtual_document = $v;
			$this->modifiedColumns[OfferProductTableMap::VIRTUAL_DOCUMENT] = true;
		}
		
		
		return $this;
	} // setVirtualDocument()
	
	/**
	 * Sets the value of [created_at] column to a normalized version of the date/time value specified.
	 *
	 * @param      mixed $v string, integer (timestamp), or \DateTime value.
	 *               Empty strings are treated as NULL.
	 * @return   \OfferCreation\Model\OfferProduct The current object (for fluent API support)
	 */
	public function setCreatedAt($v)
	{
		$dt = PropelDateTime::newInstance($v, null, '\DateTime');
		if ($this->created_at !== null || $dt !== null) {
			if ($dt !== $this->created_at) {
				$this->created_at = $dt;
				$this->modifiedColumns[OfferProductTableMap::CREATED_AT] = true;
			}
		} // if either are not null
		
		
		return $this;
	} // setCreatedAt()
	
	/**
	 * Sets the value of [updated_at] column to a normalized version of the date/time value specified.
	 *
	 * @param      mixed $v string, integer (timestamp), or \DateTime value.
	 *               Empty strings are treated as NULL.
	 * @return   \OfferCreation\Model\OfferProduct The current object (for fluent API support)
	 */
	public function setUpdatedAt($v)
	{
		$dt = PropelDateTime::newInstance($v, null, '\DateTime');
		if ($this->updated_at !== null || $dt !== null) {
			if ($dt !== $this->updated_at) {
				$this->updated_at = $dt;
				$this->modifiedColumns[OfferProductTableMap::UPDATED_AT] = true;
			}
		} // if either are not null
		
		
		return $this;
	} // setUpdatedAt()
	
	/**
	 * Indicates whether the columns in this object are only set to default values.
	 *
	 * This method can be used in conjunction with isModified() to indicate whether an object is both
	 * modified _and_ has some values set which are non-default.
	 *
	 * @return boolean Whether the columns in this object are only been set with default values.
	 */
	public function hasOnlyDefaultValues()
	{
		if ($this->price !== '0.000000') {
			return false;
		}
		
		if ($this->promo_price !== '0.000000') {
			return false;
		}
		
		if ($this->virtual !== 0) {
			return false;
		}
		
		// otherwise, everything was equal, so return TRUE
		return true;
	} // hasOnlyDefaultValues()
	
	/**
	 * Hydrates (populates) the object variables with values from the database resultset.
	 *
	 * An offset (0-based "start column") is specified so that objects can be hydrated
	 * with a subset of the columns in the resultset rows.  This is needed, for example,
	 * for results of JOIN queries where the resultset row includes columns from two or
	 * more tables.
	 *
	 * @param array   $row       The row returned by DataFetcher->fetch().
	 * @param int     $startcol  0-based offset column which indicates which restultset column to start with.
	 * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
	 * @param string  $indexType The index type of $row. Mostly DataFetcher->getIndexType().
	 One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
	 *                            TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
	 *
	 * @return int             next starting column
	 * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
	 */
	public function hydrate($row, $startcol = 0, $rehydrate = false, $indexType = TableMap::TYPE_NUM)
	{
		try {
			
			
			$col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : OfferProductTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
			$this->id = (null !== $col) ? (int) $col : null;
			
			$col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : OfferProductTableMap::translateFieldName('OfferId', TableMap::TYPE_PHPNAME, $indexType)];
			$this->offer_id = (null !== $col) ? (int) $col : null;
			
			$col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : OfferProductTableMap::translateFieldName('ProductRef', TableMap::TYPE_PHPNAME, $indexType)];
			$this->product_ref = (null !== $col) ? (string) $col : null;
			
			$col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : OfferProductTableMap::translateFieldName('ProductSaleElementsRef', TableMap::TYPE_PHPNAME, $indexType)];
			$this->product_sale_elements_ref = (null !== $col) ? (string) $col : null;
			
			$col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : OfferProductTableMap::translateFieldName('ProductSaleElementsId', TableMap::TYPE_PHPNAME, $indexType)];
			$this->product_sale_elements_id = (null !== $col) ? (int) $col : null;
			
			$col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : OfferProductTableMap::translateFieldName('Title', TableMap::TYPE_PHPNAME, $indexType)];
			$this->title = (null !== $col) ? (string) $col : null;
			
			$col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : OfferProductTableMap::translateFieldName('Chapo', TableMap::TYPE_PHPNAME, $indexType)];
			$this->chapo = (null !== $col) ? (string) $col : null;
			
			$col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : OfferProductTableMap::translateFieldName('Description', TableMap::TYPE_PHPNAME, $indexType)];
			$this->description = (null !== $col) ? (string) $col : null;
			
			$col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : OfferProductTableMap::translateFieldName('Postscriptum', TableMap::TYPE_PHPNAME, $indexType)];
			$this->postscriptum = (null !== $col) ? (string) $col : null;
			
			$col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : OfferProductTableMap::translateFieldName('Quantity', TableMap::TYPE_PHPNAME, $indexType)];
			$this->quantity = (null !== $col) ? (double) $col : null;
			
			$col = $row[TableMap::TYPE_NUM == $indexType ? 10 + $startcol : OfferProductTableMap::translateFieldName('Price', TableMap::TYPE_PHPNAME, $indexType)];
			$this->price = (null !== $col) ? (string) $col : null;
			
			$col = $row[TableMap::TYPE_NUM == $indexType ? 11 + $startcol : OfferProductTableMap::translateFieldName('PromoPrice', TableMap::TYPE_PHPNAME, $indexType)];
			$this->promo_price = (null !== $col) ? (string) $col : null;
			
			$col = $row[TableMap::TYPE_NUM == $indexType ? 12 + $startcol : OfferProductTableMap::translateFieldName('WasNew', TableMap::TYPE_PHPNAME, $indexType)];
			$this->was_new = (null !== $col) ? (int) $col : null;
			
			$col = $row[TableMap::TYPE_NUM == $indexType ? 13 + $startcol : OfferProductTableMap::translateFieldName('WasInPromo', TableMap::TYPE_PHPNAME, $indexType)];
			$this->was_in_promo = (null !== $col) ? (int) $col : null;
			
			$col = $row[TableMap::TYPE_NUM == $indexType ? 14 + $startcol : OfferProductTableMap::translateFieldName('Weight', TableMap::TYPE_PHPNAME, $indexType)];
			$this->weight = (null !== $col) ? (string) $col : null;
			
			$col = $row[TableMap::TYPE_NUM == $indexType ? 15 + $startcol : OfferProductTableMap::translateFieldName('EanCode', TableMap::TYPE_PHPNAME, $indexType)];
			$this->ean_code = (null !== $col) ? (string) $col : null;
			
			$col = $row[TableMap::TYPE_NUM == $indexType ? 16 + $startcol : OfferProductTableMap::translateFieldName('TaxRuleTitle', TableMap::TYPE_PHPNAME, $indexType)];
			$this->tax_rule_title = (null !== $col) ? (string) $col : null;
			
			$col = $row[TableMap::TYPE_NUM == $indexType ? 17 + $startcol : OfferProductTableMap::translateFieldName('TaxRuleDescription', TableMap::TYPE_PHPNAME, $indexType)];
			$this->tax_rule_description = (null !== $col) ? (string) $col : null;
			
			$col = $row[TableMap::TYPE_NUM == $indexType ? 18 + $startcol : OfferProductTableMap::translateFieldName('Parent', TableMap::TYPE_PHPNAME, $indexType)];
			$this->parent = (null !== $col) ? (int) $col : null;
			
			$col = $row[TableMap::TYPE_NUM == $indexType ? 19 + $startcol : OfferProductTableMap::translateFieldName('Virtual', TableMap::TYPE_PHPNAME, $indexType)];
			$this->virtual = (null !== $col) ? (int) $col : null;
			
			$col = $row[TableMap::TYPE_NUM == $indexType ? 20 + $startcol : OfferProductTableMap::translateFieldName('VirtualDocument', TableMap::TYPE_PHPNAME, $indexType)];
			$this->virtual_document = (null !== $col) ? (string) $col : null;
			
			$col = $row[TableMap::TYPE_NUM == $indexType ? 21 + $startcol : OfferProductTableMap::translateFieldName('CreatedAt', TableMap::TYPE_PHPNAME, $indexType)];
			if ($col === '0000-00-00 00:00:00') {
				$col = null;
			}
			$this->created_at = (null !== $col) ? PropelDateTime::newInstance($col, null, '\DateTime') : null;
			
			$col = $row[TableMap::TYPE_NUM == $indexType ? 22 + $startcol : OfferProductTableMap::translateFieldName('UpdatedAt', TableMap::TYPE_PHPNAME, $indexType)];
			if ($col === '0000-00-00 00:00:00') {
				$col = null;
			}
			$this->updated_at = (null !== $col) ? PropelDateTime::newInstance($col, null, '\DateTime') : null;
			$this->resetModified();
			
			$this->setNew(false);
			
			if ($rehydrate) {
				$this->ensureConsistency();
			}
			
			return $startcol + 23; // 23 = OfferProductTableMap::NUM_HYDRATE_COLUMNS.
			
		} catch (Exception $e) {
			throw new PropelException("Error populating \OfferCreation\Model\OfferProduct object", 0, $e);
		}
	}
	
	/**
	 * Checks and repairs the internal consistency of the object.
	 *
	 * This method is executed after an already-instantiated object is re-hydrated
	 * from the database.  It exists to check any foreign keys to make sure that
	 * the objects related to the current object are correct based on foreign key.
	 *
	 * You can override this method in the stub class, but you should always invoke
	 * the base method from the overridden method (i.e. parent::ensureConsistency()),
	 * in case your model changes.
	 *
	 * @throws PropelException
	 */
	public function ensureConsistency()
	{
		if ($this->aOffer !== null && $this->offer_id !== $this->aOffer->getId()) {
			$this->aOffer = null;
		}
	} // ensureConsistency
	
	/**
	 * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
	 *
	 * This will only work if the object has been saved and has a valid primary key set.
	 *
	 * @param      boolean $deep (optional) Whether to also de-associated any related objects.
	 * @param      ConnectionInterface $con (optional) The ConnectionInterface connection to use.
	 * @return void
	 * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
	 */
	public function reload($deep = false, ConnectionInterface $con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("Cannot reload a deleted object.");
		}
		
		if ($this->isNew()) {
			throw new PropelException("Cannot reload an unsaved object.");
		}
		
		if ($con === null) {
			$con = Propel::getServiceContainer()->getReadConnection(OfferProductTableMap::DATABASE_NAME);
		}
		
		// We don't need to alter the object instance pool; we're just modifying this instance
		// already in the pool.
		
		$dataFetcher = ChildOfferProductQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
		$row = $dataFetcher->fetch();
		$dataFetcher->close();
		if (!$row) {
			throw new PropelException('Cannot find matching row in the database to reload object values.');
		}
		$this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate
		
		if ($deep) {  // also de-associate any related objects?
			
			$this->aOffer = null;
			$this->collOfferProductTaxes = null;
			
		} // if (deep)
	}
	
	/**
	 * Removes this object from datastore and sets delete attribute.
	 *
	 * @param      ConnectionInterface $con
	 * @return void
	 * @throws PropelException
	 * @see OfferProduct::setDeleted()
	 * @see OfferProduct::isDeleted()
	 */
	public function delete(ConnectionInterface $con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}
		
		if ($con === null) {
			$con = Propel::getServiceContainer()->getWriteConnection(OfferProductTableMap::DATABASE_NAME);
		}
		
		$con->beginTransaction();
		try {
			$deleteQuery = ChildOfferProductQuery::create()
			->filterByPrimaryKey($this->getPrimaryKey());
			$ret = $this->preDelete($con);
			if ($ret) {
				$deleteQuery->delete($con);
				$this->postDelete($con);
				$con->commit();
				$this->setDeleted(true);
			} else {
				$con->commit();
			}
		} catch (Exception $e) {
			$con->rollBack();
			throw $e;
		}
	}
	
	/**
	 * Persists this object to the database.
	 *
	 * If the object is new, it inserts it; otherwise an update is performed.
	 * All modified related objects will also be persisted in the doSave()
	 * method.  This method wraps all precipitate database operations in a
	 * single transaction.
	 *
	 * @param      ConnectionInterface $con
	 * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
	 * @throws PropelException
	 * @see doSave()
	 */
	public function save(ConnectionInterface $con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}
		
		if ($con === null) {
			$con = Propel::getServiceContainer()->getWriteConnection(OfferProductTableMap::DATABASE_NAME);
		}
		
		$con->beginTransaction();
		$isInsert = $this->isNew();
		try {
			$ret = $this->preSave($con);
			if ($isInsert) {
				$ret = $ret && $this->preInsert($con);
				// timestampable behavior
				if (!$this->isColumnModified(OfferProductTableMap::CREATED_AT)) {
					$this->setCreatedAt(time());
				}
				if (!$this->isColumnModified(OfferProductTableMap::UPDATED_AT)) {
					$this->setUpdatedAt(time());
				}
			} else {
				$ret = $ret && $this->preUpdate($con);
				// timestampable behavior
				if ($this->isModified() && !$this->isColumnModified(OfferProductTableMap::UPDATED_AT)) {
					$this->setUpdatedAt(time());
				}
			}
			if ($ret) {
				$affectedRows = $this->doSave($con);
				if ($isInsert) {
					$this->postInsert($con);
				} else {
					$this->postUpdate($con);
				}
				$this->postSave($con);
				OfferProductTableMap::addInstanceToPool($this);
			} else {
				$affectedRows = 0;
			}
			$con->commit();
			
			return $affectedRows;
		} catch (Exception $e) {
			$con->rollBack();
			throw $e;
		}
	}
	
	/**
	 * Performs the work of inserting or updating the row in the database.
	 *
	 * If the object is new, it inserts it; otherwise an update is performed.
	 * All related objects are also updated in this method.
	 *
	 * @param      ConnectionInterface $con
	 * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
	 * @throws PropelException
	 * @see save()
	 */
	protected function doSave(ConnectionInterface $con)
	{
		$affectedRows = 0; // initialize var to track total num of affected rows
		if (!$this->alreadyInSave) {
			$this->alreadyInSave = true;
			
			// We call the save method on the following object(s) if they
			// were passed to this object by their corresponding set
			// method.  This object relates to these object(s) by a
			// foreign key reference.
			
			if ($this->aOffer !== null) {
				if ($this->aOffer->isModified() || $this->aOffer->isNew()) {
					$affectedRows += $this->aOffer->save($con);
				}
				$this->setOffer($this->aOffer);
			}
			
			if ($this->isNew() || $this->isModified()) {
				// persist changes
				if ($this->isNew()) {
					$this->doInsert($con);
				} else {
					$this->doUpdate($con);
				}
				$affectedRows += 1;
				$this->resetModified();
			}
			
			if ($this->offerProductTaxesScheduledForDeletion !== null) {
				if (!$this->offerProductTaxesScheduledForDeletion->isEmpty()) {
					\OfferCreation\Model\OfferProductTaxQuery::create()
					->filterByPrimaryKeys($this->offerProductTaxesScheduledForDeletion->getPrimaryKeys(false))
					->delete($con);
					$this->offerProductTaxesScheduledForDeletion = null;
				}
			}
			
			if ($this->collOfferProductTaxes !== null) {
				foreach ($this->collOfferProductTaxes as $referrerFK) {
					if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}
			
			$this->alreadyInSave = false;
			
		}
		
		return $affectedRows;
	} // doSave()
	
	/**
	 * Insert the row in the database.
	 *
	 * @param      ConnectionInterface $con
	 *
	 * @throws PropelException
	 * @see doSave()
	 */
	protected function doInsert(ConnectionInterface $con)
	{
		$modifiedColumns = array();
		$index = 0;
		
		$this->modifiedColumns[OfferProductTableMap::ID] = true;
		if (null !== $this->id) {
			throw new PropelException('Cannot insert a value for auto-increment primary key (' . OfferProductTableMap::ID . ')');
		}
		
		// check the columns in natural order for more readable SQL queries
		if ($this->isColumnModified(OfferProductTableMap::ID)) {
			$modifiedColumns[':p' . $index++]  = 'ID';
		}
		if ($this->isColumnModified(OfferProductTableMap::OFFER_ID)) {
			$modifiedColumns[':p' . $index++]  = 'OFFER_ID';
		}
		if ($this->isColumnModified(OfferProductTableMap::PRODUCT_REF)) {
			$modifiedColumns[':p' . $index++]  = 'PRODUCT_REF';
		}
		if ($this->isColumnModified(OfferProductTableMap::PRODUCT_SALE_ELEMENTS_REF)) {
			$modifiedColumns[':p' . $index++]  = 'PRODUCT_SALE_ELEMENTS_REF';
		}
		if ($this->isColumnModified(OfferProductTableMap::PRODUCT_SALE_ELEMENTS_ID)) {
			$modifiedColumns[':p' . $index++]  = 'PRODUCT_SALE_ELEMENTS_ID';
		}
		if ($this->isColumnModified(OfferProductTableMap::TITLE)) {
			$modifiedColumns[':p' . $index++]  = 'TITLE';
		}
		if ($this->isColumnModified(OfferProductTableMap::CHAPO)) {
			$modifiedColumns[':p' . $index++]  = 'CHAPO';
		}
		if ($this->isColumnModified(OfferProductTableMap::DESCRIPTION)) {
			$modifiedColumns[':p' . $index++]  = 'DESCRIPTION';
		}
		if ($this->isColumnModified(OfferProductTableMap::POSTSCRIPTUM)) {
			$modifiedColumns[':p' . $index++]  = 'POSTSCRIPTUM';
		}
		if ($this->isColumnModified(OfferProductTableMap::QUANTITY)) {
			$modifiedColumns[':p' . $index++]  = 'QUANTITY';
		}
		if ($this->isColumnModified(OfferProductTableMap::PRICE)) {
			$modifiedColumns[':p' . $index++]  = 'PRICE';
		}
		if ($this->isColumnModified(OfferProductTableMap::PROMO_PRICE)) {
			$modifiedColumns[':p' . $index++]  = 'PROMO_PRICE';
		}
		if ($this->isColumnModified(OfferProductTableMap::WAS_NEW)) {
			$modifiedColumns[':p' . $index++]  = 'WAS_NEW';
		}
		if ($this->isColumnModified(OfferProductTableMap::WAS_IN_PROMO)) {
			$modifiedColumns[':p' . $index++]  = 'WAS_IN_PROMO';
		}
		if ($this->isColumnModified(OfferProductTableMap::WEIGHT)) {
			$modifiedColumns[':p' . $index++]  = 'WEIGHT';
		}
		if ($this->isColumnModified(OfferProductTableMap::EAN_CODE)) {
			$modifiedColumns[':p' . $index++]  = 'EAN_CODE';
		}
		if ($this->isColumnModified(OfferProductTableMap::TAX_RULE_TITLE)) {
			$modifiedColumns[':p' . $index++]  = 'TAX_RULE_TITLE';
		}
		if ($this->isColumnModified(OfferProductTableMap::TAX_RULE_DESCRIPTION)) {
			$modifiedColumns[':p' . $index++]  = 'TAX_RULE_DESCRIPTION';
		}
		if ($this->isColumnModified(OfferProductTableMap::PARENT)) {
			$modifiedColumns[':p' . $index++]  = 'PARENT';
		}
		if ($this->isColumnModified(OfferProductTableMap::VIRTUAL)) {
			$modifiedColumns[':p' . $index++]  = 'VIRTUAL';
		}
		if ($this->isColumnModified(OfferProductTableMap::VIRTUAL_DOCUMENT)) {
			$modifiedColumns[':p' . $index++]  = 'VIRTUAL_DOCUMENT';
		}
		if ($this->isColumnModified(OfferProductTableMap::CREATED_AT)) {
			$modifiedColumns[':p' . $index++]  = 'CREATED_AT';
		}
		if ($this->isColumnModified(OfferProductTableMap::UPDATED_AT)) {
			$modifiedColumns[':p' . $index++]  = 'UPDATED_AT';
		}
		
		$sql = sprintf(
				'INSERT INTO offer_product (%s) VALUES (%s)',
				implode(', ', $modifiedColumns),
				implode(', ', array_keys($modifiedColumns))
				);
		
		try {
			$stmt = $con->prepare($sql);
			foreach ($modifiedColumns as $identifier => $columnName) {
				switch ($columnName) {
					case 'ID':
						$stmt->bindValue($identifier, $this->id, PDO::PARAM_INT);
						break;
					case 'OFFER_ID':
						$stmt->bindValue($identifier, $this->offer_id, PDO::PARAM_INT);
						break;
					case 'PRODUCT_REF':
						$stmt->bindValue($identifier, $this->product_ref, PDO::PARAM_STR);
						break;
					case 'PRODUCT_SALE_ELEMENTS_REF':
						$stmt->bindValue($identifier, $this->product_sale_elements_ref, PDO::PARAM_STR);
						break;
					case 'PRODUCT_SALE_ELEMENTS_ID':
						$stmt->bindValue($identifier, $this->product_sale_elements_id, PDO::PARAM_INT);
						break;
					case 'TITLE':
						$stmt->bindValue($identifier, $this->title, PDO::PARAM_STR);
						break;
					case 'CHAPO':
						$stmt->bindValue($identifier, $this->chapo, PDO::PARAM_STR);
						break;
					case 'DESCRIPTION':
						$stmt->bindValue($identifier, $this->description, PDO::PARAM_STR);
						break;
					case 'POSTSCRIPTUM':
						$stmt->bindValue($identifier, $this->postscriptum, PDO::PARAM_STR);
						break;
					case 'QUANTITY':
						$stmt->bindValue($identifier, $this->quantity, PDO::PARAM_STR);
						break;
					case 'PRICE':
						$stmt->bindValue($identifier, $this->price, PDO::PARAM_STR);
						break;
					case 'PROMO_PRICE':
						$stmt->bindValue($identifier, $this->promo_price, PDO::PARAM_STR);
						break;
					case 'WAS_NEW':
						$stmt->bindValue($identifier, $this->was_new, PDO::PARAM_INT);
						break;
					case 'WAS_IN_PROMO':
						$stmt->bindValue($identifier, $this->was_in_promo, PDO::PARAM_INT);
						break;
					case 'WEIGHT':
						$stmt->bindValue($identifier, $this->weight, PDO::PARAM_STR);
						break;
					case 'EAN_CODE':
						$stmt->bindValue($identifier, $this->ean_code, PDO::PARAM_STR);
						break;
					case 'TAX_RULE_TITLE':
						$stmt->bindValue($identifier, $this->tax_rule_title, PDO::PARAM_STR);
						break;
					case 'TAX_RULE_DESCRIPTION':
						$stmt->bindValue($identifier, $this->tax_rule_description, PDO::PARAM_STR);
						break;
					case 'PARENT':
						$stmt->bindValue($identifier, $this->parent, PDO::PARAM_INT);
						break;
					case 'VIRTUAL':
						$stmt->bindValue($identifier, $this->virtual, PDO::PARAM_INT);
						break;
					case 'VIRTUAL_DOCUMENT':
						$stmt->bindValue($identifier, $this->virtual_document, PDO::PARAM_STR);
						break;
					case 'CREATED_AT':
						$stmt->bindValue($identifier, $this->created_at ? $this->created_at->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
						break;
					case 'UPDATED_AT':
						$stmt->bindValue($identifier, $this->updated_at ? $this->updated_at->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
						break;
				}
			}
			$stmt->execute();
		} catch (Exception $e) {
			Propel::log($e->getMessage(), Propel::LOG_ERR);
			throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
		}
		
		try {
			$pk = $con->lastInsertId();
		} catch (Exception $e) {
			throw new PropelException('Unable to get autoincrement id.', 0, $e);
		}
		$this->setId($pk);
		
		$this->setNew(false);
	}
	
	/**
	 * Update the row in the database.
	 *
	 * @param      ConnectionInterface $con
	 *
	 * @return Integer Number of updated rows
	 * @see doSave()
	 */
	protected function doUpdate(ConnectionInterface $con)
	{
		$selectCriteria = $this->buildPkeyCriteria();
		$valuesCriteria = $this->buildCriteria();
		
		return $selectCriteria->doUpdate($valuesCriteria, $con);
	}
	
	/**
	 * Retrieves a field from the object by name passed in as a string.
	 *
	 * @param      string $name name
	 * @param      string $type The type of fieldname the $name is of:
	 *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
	 *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
	 *                     Defaults to TableMap::TYPE_PHPNAME.
	 * @return mixed Value of field.
	 */
	public function getByName($name, $type = TableMap::TYPE_PHPNAME)
	{
		$pos = OfferProductTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
		$field = $this->getByPosition($pos);
		
		return $field;
	}
	
	/**
	 * Retrieves a field from the object by Position as specified in the xml schema.
	 * Zero-based.
	 *
	 * @param      int $pos position in xml schema
	 * @return mixed Value of field at $pos
	 */
	public function getByPosition($pos)
	{
		switch ($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getOfferId();
				break;
			case 2:
				return $this->getProductRef();
				break;
			case 3:
				return $this->getProductSaleElementsRef();
				break;
			case 4:
				return $this->getProductSaleElementsId();
				break;
			case 5:
				return $this->getTitle();
				break;
			case 6:
				return $this->getChapo();
				break;
			case 7:
				return $this->getDescription();
				break;
			case 8:
				return $this->getPostscriptum();
				break;
			case 9:
				return $this->getQuantity();
				break;
			case 10:
				return $this->getPrice();
				break;
			case 11:
				return $this->getPromoPrice();
				break;
			case 12:
				return $this->getWasNew();
				break;
			case 13:
				return $this->getWasInPromo();
				break;
			case 14:
				return $this->getWeight();
				break;
			case 15:
				return $this->getEanCode();
				break;
			case 16:
				return $this->getTaxRuleTitle();
				break;
			case 17:
				return $this->getTaxRuleDescription();
				break;
			case 18:
				return $this->getParent();
				break;
			case 19:
				return $this->getVirtual();
				break;
			case 20:
				return $this->getVirtualDocument();
				break;
			case 21:
				return $this->getCreatedAt();
				break;
			case 22:
				return $this->getUpdatedAt();
				break;
			default:
				return null;
				break;
		} // switch()
	}
	
	/**
	 * Exports the object as an array.
	 *
	 * You can specify the key type of the array by passing one of the class
	 * type constants.
	 *
	 * @param     string  $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME,
	 *                    TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
	 *                    Defaults to TableMap::TYPE_PHPNAME.
	 * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to TRUE.
	 * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
	 * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
	 *
	 * @return array an associative array containing the field names (as keys) and field values
	 */
	public function toArray($keyType = TableMap::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
	{
		if (isset($alreadyDumpedObjects['OfferProduct'][$this->getPrimaryKey()])) {
			return '*RECURSION*';
		}
		$alreadyDumpedObjects['OfferProduct'][$this->getPrimaryKey()] = true;
		$keys = OfferProductTableMap::getFieldNames($keyType);
		$result = array(
				$keys[0] => $this->getId(),
				$keys[1] => $this->getOfferId(),
				$keys[2] => $this->getProductRef(),
				$keys[3] => $this->getProductSaleElementsRef(),
				$keys[4] => $this->getProductSaleElementsId(),
				$keys[5] => $this->getTitle(),
				$keys[6] => $this->getChapo(),
				$keys[7] => $this->getDescription(),
				$keys[8] => $this->getPostscriptum(),
				$keys[9] => $this->getQuantity(),
				$keys[10] => $this->getPrice(),
				$keys[11] => $this->getPromoPrice(),
				$keys[12] => $this->getWasNew(),
				$keys[13] => $this->getWasInPromo(),
				$keys[14] => $this->getWeight(),
				$keys[15] => $this->getEanCode(),
				$keys[16] => $this->getTaxRuleTitle(),
				$keys[17] => $this->getTaxRuleDescription(),
				$keys[18] => $this->getParent(),
				$keys[19] => $this->getVirtual(),
				$keys[20] => $this->getVirtualDocument(),
				$keys[21] => $this->getCreatedAt(),
				$keys[22] => $this->getUpdatedAt(),
		);
		$virtualColumns = $this->virtualColumns;
		foreach ($virtualColumns as $key => $virtualColumn) {
			$result[$key] = $virtualColumn;
		}
		
		if ($includeForeignObjects) {
			if (null !== $this->aOffer) {
				$result['Offer'] = $this->aOffer->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
			}
			if (null !== $this->collOfferProductTaxes) {
				$result['OfferProductTaxes'] = $this->collOfferProductTaxes->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
			}
		}
		
		return $result;
	}
	
	/**
	 * Sets a field from the object by name passed in as a string.
	 *
	 * @param      string $name
	 * @param      mixed  $value field value
	 * @param      string $type The type of fieldname the $name is of:
	 *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
	 *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
	 *                     Defaults to TableMap::TYPE_PHPNAME.
	 * @return void
	 */
	public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
	{
		$pos = OfferProductTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
		
		return $this->setByPosition($pos, $value);
	}
	
	/**
	 * Sets a field from the object by Position as specified in the xml schema.
	 * Zero-based.
	 *
	 * @param      int $pos position in xml schema
	 * @param      mixed $value field value
	 * @return void
	 */
	public function setByPosition($pos, $value)
	{
		switch ($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setOfferId($value);
				break;
			case 2:
				$this->setProductRef($value);
				break;
			case 3:
				$this->setProductSaleElementsRef($value);
				break;
			case 4:
				$this->setProductSaleElementsId($value);
				break;
			case 5:
				$this->setTitle($value);
				break;
			case 6:
				$this->setChapo($value);
				break;
			case 7:
				$this->setDescription($value);
				break;
			case 8:
				$this->setPostscriptum($value);
				break;
			case 9:
				$this->setQuantity($value);
				break;
			case 10:
				$this->setPrice($value);
				break;
			case 11:
				$this->setPromoPrice($value);
				break;
			case 12:
				$this->setWasNew($value);
				break;
			case 13:
				$this->setWasInPromo($value);
				break;
			case 14:
				$this->setWeight($value);
				break;
			case 15:
				$this->setEanCode($value);
				break;
			case 16:
				$this->setTaxRuleTitle($value);
				break;
			case 17:
				$this->setTaxRuleDescription($value);
				break;
			case 18:
				$this->setParent($value);
				break;
			case 19:
				$this->setVirtual($value);
				break;
			case 20:
				$this->setVirtualDocument($value);
				break;
			case 21:
				$this->setCreatedAt($value);
				break;
			case 22:
				$this->setUpdatedAt($value);
				break;
		} // switch()
	}
	
	/**
	 * Populates the object using an array.
	 *
	 * This is particularly useful when populating an object from one of the
	 * request arrays (e.g. $_POST).  This method goes through the column
	 * names, checking to see whether a matching key exists in populated
	 * array. If so the setByName() method is called for that column.
	 *
	 * You can specify the key type of the array by additionally passing one
	 * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME,
	 * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
	 * The default key type is the column's TableMap::TYPE_PHPNAME.
	 *
	 * @param      array  $arr     An array to populate the object from.
	 * @param      string $keyType The type of keys the array uses.
	 * @return void
	 */
	public function fromArray($arr, $keyType = TableMap::TYPE_PHPNAME)
	{
		$keys = OfferProductTableMap::getFieldNames($keyType);
		
		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setOfferId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setProductRef($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setProductSaleElementsRef($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setProductSaleElementsId($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setTitle($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setChapo($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setDescription($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setPostscriptum($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setQuantity($arr[$keys[9]]);
		if (array_key_exists($keys[10], $arr)) $this->setPrice($arr[$keys[10]]);
		if (array_key_exists($keys[11], $arr)) $this->setPromoPrice($arr[$keys[11]]);
		if (array_key_exists($keys[12], $arr)) $this->setWasNew($arr[$keys[12]]);
		if (array_key_exists($keys[13], $arr)) $this->setWasInPromo($arr[$keys[13]]);
		if (array_key_exists($keys[14], $arr)) $this->setWeight($arr[$keys[14]]);
		if (array_key_exists($keys[15], $arr)) $this->setEanCode($arr[$keys[15]]);
		if (array_key_exists($keys[16], $arr)) $this->setTaxRuleTitle($arr[$keys[16]]);
		if (array_key_exists($keys[17], $arr)) $this->setTaxRuleDescription($arr[$keys[17]]);
		if (array_key_exists($keys[18], $arr)) $this->setParent($arr[$keys[18]]);
		if (array_key_exists($keys[19], $arr)) $this->setVirtual($arr[$keys[19]]);
		if (array_key_exists($keys[20], $arr)) $this->setVirtualDocument($arr[$keys[20]]);
		if (array_key_exists($keys[21], $arr)) $this->setCreatedAt($arr[$keys[21]]);
		if (array_key_exists($keys[22], $arr)) $this->setUpdatedAt($arr[$keys[22]]);
	}
	
	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(OfferProductTableMap::DATABASE_NAME);
		
		if ($this->isColumnModified(OfferProductTableMap::ID)) $criteria->add(OfferProductTableMap::ID, $this->id);
		if ($this->isColumnModified(OfferProductTableMap::OFFER_ID)) $criteria->add(OfferProductTableMap::OFFER_ID, $this->offer_id);
		if ($this->isColumnModified(OfferProductTableMap::PRODUCT_REF)) $criteria->add(OfferProductTableMap::PRODUCT_REF, $this->product_ref);
		if ($this->isColumnModified(OfferProductTableMap::PRODUCT_SALE_ELEMENTS_REF)) $criteria->add(OfferProductTableMap::PRODUCT_SALE_ELEMENTS_REF, $this->product_sale_elements_ref);
		if ($this->isColumnModified(OfferProductTableMap::PRODUCT_SALE_ELEMENTS_ID)) $criteria->add(OfferProductTableMap::PRODUCT_SALE_ELEMENTS_ID, $this->product_sale_elements_id);
		if ($this->isColumnModified(OfferProductTableMap::TITLE)) $criteria->add(OfferProductTableMap::TITLE, $this->title);
		if ($this->isColumnModified(OfferProductTableMap::CHAPO)) $criteria->add(OfferProductTableMap::CHAPO, $this->chapo);
		if ($this->isColumnModified(OfferProductTableMap::DESCRIPTION)) $criteria->add(OfferProductTableMap::DESCRIPTION, $this->description);
		if ($this->isColumnModified(OfferProductTableMap::POSTSCRIPTUM)) $criteria->add(OfferProductTableMap::POSTSCRIPTUM, $this->postscriptum);
		if ($this->isColumnModified(OfferProductTableMap::QUANTITY)) $criteria->add(OfferProductTableMap::QUANTITY, $this->quantity);
		if ($this->isColumnModified(OfferProductTableMap::PRICE)) $criteria->add(OfferProductTableMap::PRICE, $this->price);
		if ($this->isColumnModified(OfferProductTableMap::PROMO_PRICE)) $criteria->add(OfferProductTableMap::PROMO_PRICE, $this->promo_price);
		if ($this->isColumnModified(OfferProductTableMap::WAS_NEW)) $criteria->add(OfferProductTableMap::WAS_NEW, $this->was_new);
		if ($this->isColumnModified(OfferProductTableMap::WAS_IN_PROMO)) $criteria->add(OfferProductTableMap::WAS_IN_PROMO, $this->was_in_promo);
		if ($this->isColumnModified(OfferProductTableMap::WEIGHT)) $criteria->add(OfferProductTableMap::WEIGHT, $this->weight);
		if ($this->isColumnModified(OfferProductTableMap::EAN_CODE)) $criteria->add(OfferProductTableMap::EAN_CODE, $this->ean_code);
		if ($this->isColumnModified(OfferProductTableMap::TAX_RULE_TITLE)) $criteria->add(OfferProductTableMap::TAX_RULE_TITLE, $this->tax_rule_title);
		if ($this->isColumnModified(OfferProductTableMap::TAX_RULE_DESCRIPTION)) $criteria->add(OfferProductTableMap::TAX_RULE_DESCRIPTION, $this->tax_rule_description);
		if ($this->isColumnModified(OfferProductTableMap::PARENT)) $criteria->add(OfferProductTableMap::PARENT, $this->parent);
		if ($this->isColumnModified(OfferProductTableMap::VIRTUAL)) $criteria->add(OfferProductTableMap::VIRTUAL, $this->virtual);
		if ($this->isColumnModified(OfferProductTableMap::VIRTUAL_DOCUMENT)) $criteria->add(OfferProductTableMap::VIRTUAL_DOCUMENT, $this->virtual_document);
		if ($this->isColumnModified(OfferProductTableMap::CREATED_AT)) $criteria->add(OfferProductTableMap::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(OfferProductTableMap::UPDATED_AT)) $criteria->add(OfferProductTableMap::UPDATED_AT, $this->updated_at);
		
		return $criteria;
	}
	
	/**
	 * Builds a Criteria object containing the primary key for this object.
	 *
	 * Unlike buildCriteria() this method includes the primary key values regardless
	 * of whether or not they have been modified.
	 *
	 * @return Criteria The Criteria object containing value(s) for primary key(s).
	 */
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(OfferProductTableMap::DATABASE_NAME);
		$criteria->add(OfferProductTableMap::ID, $this->id);
		
		return $criteria;
	}
	
	/**
	 * Returns the primary key for this object (row).
	 * @return   int
	 */
	public function getPrimaryKey()
	{
		return $this->getId();
	}
	
	/**
	 * Generic method to set the primary key (id column).
	 *
	 * @param       int $key Primary key.
	 * @return void
	 */
	public function setPrimaryKey($key)
	{
		$this->setId($key);
	}
	
	/**
	 * Returns true if the primary key for this object is null.
	 * @return boolean
	 */
	public function isPrimaryKeyNull()
	{
		
		return null === $this->getId();
	}
	
	/**
	 * Sets contents of passed object to values from current object.
	 *
	 * If desired, this method can also make copies of all associated (fkey referrers)
	 * objects.
	 *
	 * @param      object $copyObj An object of \OfferCreation\Model\OfferProduct (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
	 * @throws PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
	{
		$copyObj->setOfferId($this->getOfferId());
		$copyObj->setProductRef($this->getProductRef());
		$copyObj->setProductSaleElementsRef($this->getProductSaleElementsRef());
		$copyObj->setProductSaleElementsId($this->getProductSaleElementsId());
		$copyObj->setTitle($this->getTitle());
		$copyObj->setChapo($this->getChapo());
		$copyObj->setDescription($this->getDescription());
		$copyObj->setPostscriptum($this->getPostscriptum());
		$copyObj->setQuantity($this->getQuantity());
		$copyObj->setPrice($this->getPrice());
		$copyObj->setPromoPrice($this->getPromoPrice());
		$copyObj->setWasNew($this->getWasNew());
		$copyObj->setWasInPromo($this->getWasInPromo());
		$copyObj->setWeight($this->getWeight());
		$copyObj->setEanCode($this->getEanCode());
		$copyObj->setTaxRuleTitle($this->getTaxRuleTitle());
		$copyObj->setTaxRuleDescription($this->getTaxRuleDescription());
		$copyObj->setParent($this->getParent());
		$copyObj->setVirtual($this->getVirtual());
		$copyObj->setVirtualDocument($this->getVirtualDocument());
		$copyObj->setCreatedAt($this->getCreatedAt());
		$copyObj->setUpdatedAt($this->getUpdatedAt());
		
		if ($deepCopy) {
			// important: temporarily setNew(false) because this affects the behavior of
			// the getter/setter methods for fkey referrer objects.
			$copyObj->setNew(false);
			
			foreach ($this->getOfferProductTaxes() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addOfferProductTax($relObj->copy($deepCopy));
				}
			}
			
		} // if ($deepCopy)
		
		if ($makeNew) {
			$copyObj->setNew(true);
			$copyObj->setId(NULL); // this is a auto-increment column, so set to default value
		}
	}
	
	/**
	 * Makes a copy of this object that will be inserted as a new row in table when saved.
	 * It creates a new object filling in the simple attributes, but skipping any primary
	 * keys that are defined for the table.
	 *
	 * If desired, this method can also make copies of all associated (fkey referrers)
	 * objects.
	 *
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @return                 \OfferCreation\Model\OfferProduct Clone of current object.
	 * @throws PropelException
	 */
	public function copy($deepCopy = false)
	{
		// we use get_class(), because this might be a subclass
		$clazz = get_class($this);
		$copyObj = new $clazz();
		$this->copyInto($copyObj, $deepCopy);
		
		return $copyObj;
	}
	
	/**
	 * Declares an association between this object and a ChildOffer object.
	 *
	 * @param                  ChildOffer $v
	 * @return                 \OfferCreation\Model\OfferProduct The current object (for fluent API support)
	 * @throws PropelException
	 */
	public function setOffer(ChildOffer $v = null)
	{
		if ($v === null) {
			$this->setOfferId(NULL);
		} else {
			$this->setOfferId($v->getId());
		}
		
		$this->aOffer = $v;
		
		// Add binding for other direction of this n:n relationship.
		// If this object has already been added to the ChildOffer object, it will not be re-added.
		if ($v !== null) {
			$v->addOfferProduct($this);
		}
		
		
		return $this;
	}
	
	
	/**
	 * Get the associated ChildOffer object
	 *
	 * @param      ConnectionInterface $con Optional Connection object.
	 * @return                 ChildOffer The associated ChildOffer object.
	 * @throws PropelException
	 */
	public function getOffer(ConnectionInterface $con = null)
	{
		if ($this->aOffer === null && ($this->offer_id !== null)) {
			$this->aOffer = ChildOfferQuery::create()->findPk($this->offer_id, $con);
			/* The following can be used additionally to
			 guarantee the related object contains a reference
			 to this object.  This level of coupling may, however, be
			 undesirable since it could result in an only partially populated collection
			 in the referenced object.
			 $this->aOffer->addOfferProducts($this);
			 */
		}
		
		return $this->aOffer;
	}
	
	
	/**
	 * Initializes a collection based on the name of a relation.
	 * Avoids crafting an 'init[$relationName]s' method name
	 * that wouldn't work when StandardEnglishPluralizer is used.
	 *
	 * @param      string $relationName The name of the relation to initialize
	 * @return void
	 */
	public function initRelation($relationName)
	{
		if ('OfferProductTax' == $relationName) {
			return $this->initOfferProductTaxes();
		}
	}
	
	/**
	 * Clears out the collOfferProductTaxes collection
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return void
	 * @see        addOfferProductTaxes()
	 */
	public function clearOfferProductTaxes()
	{
		$this->collOfferProductTaxes = null; // important to set this to NULL since that means it is uninitialized
	}
	
	/**
	 * Reset is the collOfferProductTaxes collection loaded partially.
	 */
	public function resetPartialOfferProductTaxes($v = true)
	{
		$this->collOfferProductTaxesPartial = $v;
	}
	
	/**
	 * Initializes the collOfferProductTaxes collection.
	 *
	 * By default this just sets the collOfferProductTaxes collection to an empty array (like clearcollOfferProductTaxes());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @param      boolean $overrideExisting If set to true, the method call initializes
	 *                                        the collection even if it is not empty
	 *
	 * @return void
	 */
	public function initOfferProductTaxes($overrideExisting = true)
	{
		if (null !== $this->collOfferProductTaxes && !$overrideExisting) {
			return;
		}
		$this->collOfferProductTaxes = new ObjectCollection();
		$this->collOfferProductTaxes->setModel('\OfferCreation\Model\OfferProductTax');
	}
	
	/**
	 * Gets an array of ChildOfferProductTax objects which contain a foreign key that references this object.
	 *
	 * If the $criteria is not null, it is used to always fetch the results from the database.
	 * Otherwise the results are fetched from the database the first time, then cached.
	 * Next time the same method is called without $criteria, the cached collection is returned.
	 * If this ChildOfferProduct is new, it will return
	 * an empty collection or the current collection; the criteria is ignored on a new object.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      ConnectionInterface $con optional connection object
	 * @return Collection|ChildOfferProductTax[] List of ChildOfferProductTax objects
	 * @throws PropelException
	 */
	public function getOfferProductTaxes($criteria = null, ConnectionInterface $con = null)
	{
		$partial = $this->collOfferProductTaxesPartial && !$this->isNew();
		if (null === $this->collOfferProductTaxes || null !== $criteria  || $partial) {
			if ($this->isNew() && null === $this->collOfferProductTaxes) {
				// return empty collection
				$this->initOfferProductTaxes();
			} else {
				$collOfferProductTaxes = ChildOfferProductTaxQuery::create(null, $criteria)
				->filterByOfferProduct($this)
				->find($con);
				
				if (null !== $criteria) {
					if (false !== $this->collOfferProductTaxesPartial && count($collOfferProductTaxes)) {
						$this->initOfferProductTaxes(false);
						
						foreach ($collOfferProductTaxes as $obj) {
							if (false == $this->collOfferProductTaxes->contains($obj)) {
								$this->collOfferProductTaxes->append($obj);
							}
						}
						
						$this->collOfferProductTaxesPartial = true;
					}
					
					reset($collOfferProductTaxes);
					
					return $collOfferProductTaxes;
				}
				
				if ($partial && $this->collOfferProductTaxes) {
					foreach ($this->collOfferProductTaxes as $obj) {
						if ($obj->isNew()) {
							$collOfferProductTaxes[] = $obj;
						}
					}
				}
				
				$this->collOfferProductTaxes = $collOfferProductTaxes;
				$this->collOfferProductTaxesPartial = false;
			}
		}
		
		return $this->collOfferProductTaxes;
	}
	
	/**
	 * Sets a collection of OfferProductTax objects related by a one-to-many relationship
	 * to the current object.
	 * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
	 * and new objects from the given Propel collection.
	 *
	 * @param      Collection $offerProductTaxes A Propel collection.
	 * @param      ConnectionInterface $con Optional connection object
	 * @return   ChildOfferProduct The current object (for fluent API support)
	 */
	public function setOfferProductTaxes(Collection $offerProductTaxes, ConnectionInterface $con = null)
	{
		$offerProductTaxesToDelete = $this->getOfferProductTaxes(new Criteria(), $con)->diff($offerProductTaxes);
		
		
		$this->offerProductTaxesScheduledForDeletion = $offerProductTaxesToDelete;
		
		foreach ($offerProductTaxesToDelete as $offerProductTaxRemoved) {
			$offerProductTaxRemoved->setOfferProduct(null);
		}
		
		$this->collOfferProductTaxes = null;
		foreach ($offerProductTaxes as $offerProductTax) {
			$this->addOfferProductTax($offerProductTax);
		}
		
		$this->collOfferProductTaxes = $offerProductTaxes;
		$this->collOfferProductTaxesPartial = false;
		
		return $this;
	}
	
	/**
	 * Returns the number of related OfferProductTax objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      ConnectionInterface $con
	 * @return int             Count of related OfferProductTax objects.
	 * @throws PropelException
	 */
	public function countOfferProductTaxes(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
	{
		$partial = $this->collOfferProductTaxesPartial && !$this->isNew();
		if (null === $this->collOfferProductTaxes || null !== $criteria || $partial) {
			if ($this->isNew() && null === $this->collOfferProductTaxes) {
				return 0;
			}
			
			if ($partial && !$criteria) {
				return count($this->getOfferProductTaxes());
			}
			
			$query = ChildOfferProductTaxQuery::create(null, $criteria);
			if ($distinct) {
				$query->distinct();
			}
			
			return $query
			->filterByOfferProduct($this)
			->count($con);
		}
		
		return count($this->collOfferProductTaxes);
	}
	
	/**
	 * Method called to associate a ChildOfferProductTax object to this object
	 * through the ChildOfferProductTax foreign key attribute.
	 *
	 * @param    ChildOfferProductTax $l ChildOfferProductTax
	 * @return   \OfferCreation\Model\OfferProduct The current object (for fluent API support)
	 */
	public function addOfferProductTax(ChildOfferProductTax $l)
	{
		if ($this->collOfferProductTaxes === null) {
			$this->initOfferProductTaxes();
			$this->collOfferProductTaxesPartial = true;
		}
		
		if (!in_array($l, $this->collOfferProductTaxes->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
			$this->doAddOfferProductTax($l);
		}
		
		return $this;
	}
	
	/**
	 * @param OfferProductTax $offerProductTax The offerProductTax object to add.
	 */
	protected function doAddOfferProductTax($offerProductTax)
	{
		$this->collOfferProductTaxes[]= $offerProductTax;
		$offerProductTax->setOfferProduct($this);
	}
	
	/**
	 * @param  OfferProductTax $offerProductTax The offerProductTax object to remove.
	 * @return ChildOfferProduct The current object (for fluent API support)
	 */
	public function removeOfferProductTax($offerProductTax)
	{
		if ($this->getOfferProductTaxes()->contains($offerProductTax)) {
			$this->collOfferProductTaxes->remove($this->collOfferProductTaxes->search($offerProductTax));
			if (null === $this->offerProductTaxesScheduledForDeletion) {
				$this->offerProductTaxesScheduledForDeletion = clone $this->collOfferProductTaxes;
				$this->offerProductTaxesScheduledForDeletion->clear();
			}
			$this->offerProductTaxesScheduledForDeletion[]= clone $offerProductTax;
			$offerProductTax->setOfferProduct(null);
		}
		
		return $this;
	}
	
	/**
	 * Clears the current object and sets all attributes to their default values
	 */
	public function clear()
	{
		$this->id = null;
		$this->offer_id = null;
		$this->product_ref = null;
		$this->product_sale_elements_ref = null;
		$this->product_sale_elements_id = null;
		$this->title = null;
		$this->chapo = null;
		$this->description = null;
		$this->postscriptum = null;
		$this->quantity = null;
		$this->price = null;
		$this->promo_price = null;
		$this->was_new = null;
		$this->was_in_promo = null;
		$this->weight = null;
		$this->ean_code = null;
		$this->tax_rule_title = null;
		$this->tax_rule_description = null;
		$this->parent = null;
		$this->virtual = null;
		$this->virtual_document = null;
		$this->created_at = null;
		$this->updated_at = null;
		$this->alreadyInSave = false;
		$this->clearAllReferences();
		$this->applyDefaultValues();
		$this->resetModified();
		$this->setNew(true);
		$this->setDeleted(false);
	}
	
	/**
	 * Resets all references to other model objects or collections of model objects.
	 *
	 * This method is a user-space workaround for PHP's inability to garbage collect
	 * objects with circular references (even in PHP 5.3). This is currently necessary
	 * when using Propel in certain daemon or large-volume/high-memory operations.
	 *
	 * @param      boolean $deep Whether to also clear the references on all referrer objects.
	 */
	public function clearAllReferences($deep = false)
	{
		if ($deep) {
			if ($this->collOfferProductTaxes) {
				foreach ($this->collOfferProductTaxes as $o) {
					$o->clearAllReferences($deep);
				}
			}
		} // if ($deep)
		
		$this->collOfferProductTaxes = null;
		$this->aOffer = null;
	}
	
	/**
	 * Return the string representation of this object
	 *
	 * @return string
	 */
	public function __toString()
	{
		return (string) $this->exportTo(OfferProductTableMap::DEFAULT_STRING_FORMAT);
	}
	
	// timestampable behavior
	
	/**
	 * Mark the current object so that the update date doesn't get updated during next save
	 *
	 * @return     ChildOfferProduct The current object (for fluent API support)
	 */
	public function keepUpdateDateUnchanged()
	{
		$this->modifiedColumns[OfferProductTableMap::UPDATED_AT] = true;
		
		return $this;
	}
	
	/**
	 * Code to be run before persisting the object
	 * @param  ConnectionInterface $con
	 * @return boolean
	 */
	public function preSave(ConnectionInterface $con = null)
	{
		return true;
	}
	
	/**
	 * Code to be run after persisting the object
	 * @param ConnectionInterface $con
	 */
	public function postSave(ConnectionInterface $con = null)
	{
		
	}
	
	/**
	 * Code to be run before inserting to database
	 * @param  ConnectionInterface $con
	 * @return boolean
	 */
	public function preInsert(ConnectionInterface $con = null)
	{
		return true;
	}
	
	/**
	 * Code to be run after inserting to database
	 * @param ConnectionInterface $con
	 */
	public function postInsert(ConnectionInterface $con = null)
	{
		
	}
	
	/**
	 * Code to be run before updating the object in database
	 * @param  ConnectionInterface $con
	 * @return boolean
	 */
	public function preUpdate(ConnectionInterface $con = null)
	{
		return true;
	}
	
	/**
	 * Code to be run after updating the object in database
	 * @param ConnectionInterface $con
	 */
	public function postUpdate(ConnectionInterface $con = null)
	{
		
	}
	
	/**
	 * Code to be run before deleting the object in database
	 * @param  ConnectionInterface $con
	 * @return boolean
	 */
	public function preDelete(ConnectionInterface $con = null)
	{
		return true;
	}
	
	/**
	 * Code to be run after deleting the object in database
	 * @param ConnectionInterface $con
	 */
	public function postDelete(ConnectionInterface $con = null)
	{
		
	}
	
	
	/**
	 * Derived method to catches calls to undefined methods.
	 *
	 * Provides magic import/export method support (fromXML()/toXML(), fromYAML()/toYAML(), etc.).
	 * Allows to define default __call() behavior if you overwrite __call()
	 *
	 * @param string $name
	 * @param mixed  $params
	 *
	 * @return array|string
	 */
	public function __call($name, $params)
	{
		if (0 === strpos($name, 'get')) {
			$virtualColumn = substr($name, 3);
			if ($this->hasVirtualColumn($virtualColumn)) {
				return $this->getVirtualColumn($virtualColumn);
			}
			
			$virtualColumn = lcfirst($virtualColumn);
			if ($this->hasVirtualColumn($virtualColumn)) {
				return $this->getVirtualColumn($virtualColumn);
			}
		}
		
		if (0 === strpos($name, 'from')) {
			$format = substr($name, 4);
			
			return $this->importFrom($format, reset($params));
		}
		
		if (0 === strpos($name, 'to')) {
			$format = substr($name, 2);
			$includeLazyLoadColumns = isset($params[0]) ? $params[0] : true;
			
			return $this->exportTo($format, $includeLazyLoadColumns);
		}
		
		throw new BadMethodCallException(sprintf('Call to undefined method: %s.', $name));
	}
	
}
