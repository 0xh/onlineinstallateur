<?php
/*************************************************************************************/
/*      This file is part of the Thelia package.                                     */
/*                                                                                   */
/*      Copyright (c) OpenStudio                                                     */
/*      email : dev@thelia.net                                                       */
/*      web : http://www.thelia.net                                                  */
/*                                                                                   */
/*      For the full copyright and license information, please view the LICENSE.txt  */
/*      file that was distributed with this source code.                             */
/*************************************************************************************/

namespace Thelia\Core\Event\ProductSaleElement;

use Thelia\Model\Product;

class ProductSaleElementUpdateEvent extends ProductSaleElementEvent
{
    /** @var int */
    protected $product_sale_element_id;

    /** @var Product */
    protected $product;

    /** @var string */
    protected $reference;

    /** @var float */
    protected $price;
    
    /** @var float */
    protected $listen_price;
    
    /** @var float */
    protected $ek_preis_gc;
    
    /** @var float */
    protected $ek_preis_sht;
    
    /** @var float */
    protected $ek_preis_oag;
    
    /** @var float */
    protected $ek_preis_holter;
    
    /** @var float */
    protected $ek_preis_odorfer;
    
    /** @var float */
    protected $preis_reuter;
    
    /** @var float */
    protected $vergleich_ek;
    
    /** @var float */
    protected $aufschlag;

    /** @var int */
    protected $currency_id;

    /** @var float */
    protected $weight;

    /** @var float */
    protected $quantity;

    /** @var float */
    protected $sale_price;

    /** @var int */
    protected $onsale;

    /** @var int */
    protected $isnew;

    /** @var bool */
    protected $isdefault;

    /** @var string */
    protected $ean_code;

    /** @var int */
    protected $tax_rule_id;

    /** @var int */
    protected $from_default_currency;

    /**
     * ProductSaleElementUpdateEvent constructor.
     * @param Product $product
     * @param int $product_sale_element_id
     */
    public function __construct(Product $product, $product_sale_element_id)
    {
        parent::__construct();

        $this->setProduct($product);

        $this->setProductSaleElementId($product_sale_element_id);
    }

    /**
     * @return int
     */
    public function getProductSaleElementId()
    {
        return $this->product_sale_element_id;
    }

    /**
     * @param int $product_sale_element_id
     * @return $this
     */
    public function setProductSaleElementId($product_sale_element_id)
    {
        $this->product_sale_element_id = $product_sale_element_id;

        return $this;
    }

    /**
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param float $price
     * @return $this
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return int
     */
    public function getCurrencyId()
    {
        return $this->currency_id;
    }

    /**
     * @param int $currency_id
     * @return $this
     */
    public function setCurrencyId($currency_id)
    {
        $this->currency_id = $currency_id;

        return $this;
    }

    /**
     * @return float
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * @param float $weight
     * @return $this
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;

        return $this;
    }

    /**
     * @return float
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param float $quantity
     * @return $this
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * @return float
     */
    public function getSalePrice()
    {
        return $this->sale_price;
    }

    /**
     * @param float $sale_price
     * @return $this
     */
    public function setSalePrice($sale_price)
    {
        $this->sale_price = $sale_price;

        return $this;
    }

    /**
     * @return int
     */
    public function getOnsale()
    {
        return $this->onsale;
    }

    /**
     * @param int $onsale
     * @return $this
     */
    public function setOnsale($onsale)
    {
        $this->onsale = $onsale;

        return $this;
    }

    /**
     * @return int
     */
    public function getIsnew()
    {
        return $this->isnew;
    }

    /**
     * @param int $isnew
     * @return $this
     */
    public function setIsnew($isnew)
    {
        $this->isnew = $isnew;

        return $this;
    }

    /**
     * @return string
     */
    public function getEanCode()
    {
        return $this->ean_code;
    }

    /**
     * @param string $ean_code
     * @return $this
     */
    public function setEanCode($ean_code)
    {
        $this->ean_code = $ean_code;

        return $this;
    }

    /**
     * @return bool
     */
    public function getIsdefault()
    {
        return $this->isdefault;
    }

    /**
     * @param bool $isdefault
     * @return $this
     */
    public function setIsdefault($isdefault)
    {
        $this->isdefault = $isdefault;

        return $this;
    }

    /**
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * @param string $reference
     * @return $this
     */
    public function setReference($reference)
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * @return Product
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @param Product $product
     * @return $this
     */
    public function setProduct($product)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * @return int
     */
    public function getTaxRuleId()
    {
        return $this->tax_rule_id;
    }

    /**
     * @param int $tax_rule_id
     * @return $this
     */
    public function setTaxRuleId($tax_rule_id)
    {
        $this->tax_rule_id = $tax_rule_id;

        return $this;
    }

    /**
     * @return int
     */
    public function getFromDefaultCurrency()
    {
        return $this->from_default_currency;
    }

    /**
     * @param int $from_default_currency
     * @return $this
     */
    public function setFromDefaultCurrency($from_default_currency)
    {
        $this->from_default_currency = $from_default_currency;

        return $this;
    }
    
    /**
     * @return float
     */
	public function getListenPrice() {
		return $this->listen_price;
	}
	
	/**
	 * @param int $listen_price
	 * @return $this
	 */
	public function setListenPrice($listen_price) {
		$this->listen_price = $listen_price;
		return $this;
	}
	
	/**
	 * @return float
	 */
	public function getEkPreisGc() {
		return $this->ek_preis_gc;
	}
	
	/**
	 * @param int $ek_preis_gc
	 * @return $this
	 */
	public function setEkPreisGc($ek_preis_gc) {
		$this->ek_preis_gc = $ek_preis_gc;
		return $this;
	}
	
	/**
	 * @return float
	 */
	public function getEkPreisSht() {
		return $this->ek_preis_sht;
	}
	
	/**
	 * @param int $ek_preis_sht
	 * @return $this
	 */
	public function setEkPreisSht($ek_preis_sht) {
		$this->ek_preis_sht = $ek_preis_sht;
		return $this;
	}
	
	/**
	 * @return float
	 */
	public function getEkPreisOag() {
		return $this->ek_preis_oag;
	}
	
	/**
	 * @param int $ek_preis_oag
	 * @return $this
	 */
	public function setEkPreisOag($ek_preis_oag) {
		$this->ek_preis_oag = $ek_preis_oag;
		return $this;
	}
	
	/**
	 * @return float
	 */
	public function getEkPreisHolter() {
		return $this->ek_preis_holter;
	}
	
	/**
	 * @param int $ek_preis_holter
	 * @return $this
	 */
	public function setEkPreisHolter($ek_preis_holter) {
		$this->ek_preis_holter = $ek_preis_holter;
		return $this;
	}
	
	/**
	 * @return float
	 */
	public function getEkPreisOdorfer() {
		return $this->ek_preis_odorfer;
	}
	
	/**
	 * @param int $ek_preis_odorfer
	 * @return $this
	 */
	public function setEkPreisOdorfer($ek_preis_odorfer) {
		$this->ek_preis_odorfer = $ek_preis_odorfer;
		return $this;
	}
	
	/**
	 * @return float
	 */
	public function getPreisReuter() {
		return $this->preis_reuter;
	}
	
	/**
	 * @param int $preis_reuter
	 * @return $this
	 */
	public function setPreisReuter($preis_reuter) {
		$this->preis_reuter = $preis_reuter;
		return $this;
	}
	
	/**
	 * @return float
	 */
	public function getVergleichEk() {
		return $this->vergleich_ek;
	}
	
	/**
	 * @param int $vergleich_ek
	 * @return $this
	 */
	public function setVergleichEk($vergleich_ek) {
		$this->vergleich_ek = $vergleich_ek;
		return $this;
	}
	
	/**
	 * @return float
	 */
	public function getAufschlag() {
		return $this->aufschlag;
	}
	
	/**
	 * @param int $aufschlag
	 * @return $this
	 */
	public function setAufschlag($aufschlag) {
		$this->aufschlag = $aufschlag;
		return $this;
	} 
}
