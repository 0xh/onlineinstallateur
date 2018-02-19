<?php
namespace GeneralImportExport\Export;

use Propel\Runtime\ActiveQuery\Criteria;
use Thelia\ImportExport\Export\AbstractExport;
use Thelia\Model\Map\CountryI18nTableMap;
use Thelia\Model\Map\CurrencyTableMap;
use Thelia\Model\Map\CustomerTableMap;
use Thelia\Model\Map\CustomerTitleI18nTableMap;
use Thelia\Model\Map\OrderCouponTableMap;
use Thelia\Model\Map\OrderProductTableMap;
use Thelia\Model\Map\OrderProductTaxTableMap;
use Thelia\Model\Map\OrderStatusI18nTableMap;
use Thelia\Model\Map\OrderStatusTableMap;
use Thelia\Model\Map\OrderTableMap;
use Thelia\Model\Order;
use Thelia\Model\OrderQuery;
use Thelia\Tools\I18n;
use Thelia\Log\Tlog;

/**
 * Class BilligerProductExport
 * 
 * @author Emanuel Plopu <emanuel.plopu@sepa.at>
 */
class BMDOrderExport extends AbstractExport
{

    const FILE_NAME = 'order_bmd';
   // konto;gkto;belegnr;extbelegnr;betrag;steuer;mwst;buchdat;belegdat;bucod;text;zziel;skontopz;skontotage;steucod;ebkennz;symbol 
    protected $orderAndAliases = [
    		'customer_REF' => 'konto',
    		OrderTableMap::CREATED_AT => 'gkto',
    		OrderTableMap::REF=> 'belegnr',
    		OrderTableMap::DISCOUNT => 'extbelegnr',
    		'order_TOTAL_WITH_DISCOUNT_AND_POSTAGE'=> 'betrag',
    		OrderTableMap::POSTAGE => 'steuer',
    		'order_TOTAL_TTC' => 'mwst',
    		OrderTableMap::INVOICE_DATE=> 'buchdat',
    		OrderTableMap::DELIVERY_MODULE_ID=> 'belegdat',
    		'delivery_module_TITLE' => 'bucod',
    		'customer_Lastname' => 'text',
    		'payment_module_TITLE' => 'zziel',
    		OrderTableMap::INVOICE_REF => 'skontopz',
    		'order_status_TITLE' => 'skontotage',
    		'delivery_address_TITLE' => 'steucod',
    		'delivery_address_COMPANY' => 'ebkennz',
    		'delivery_address_FIRSTNAME' => 'symbol',
    ];

    /**
     * Apply order and aliases on data
     *
     * @param array $data
     *            Raw data
     *            
     * @return array Ordered and aliased data
     */
    public function applyOrderAndAliases(array $data)
    {
        if ($this->orderAndAliases === null) {
            return $data;
        }
        
        $processedData = [];
        
        foreach ($this->orderAndAliases as $key => $value) {
            if (is_integer($key)) {
                $fieldName = $value;
                $fieldAlias = $value;
            } else {
                $fieldName = $key;
                $fieldAlias = $value;
            }
            
            $processedData[$fieldAlias] = null;
            if (array_key_exists($fieldName, $data)) {
                $processedData[$fieldAlias] = $data[$fieldName];
            }
        }
        
        $orderSource = substr($processedData['belegnr'],0,3);
        switch($orderSource){
        	case "ORD":{
        		$processedData['konto']="201599";
        		$processedData['belegnr']="1".substr($processedData['belegnr'],3);
        	}break;
        	case "ADE":{
        		$processedData['konto']="202699";
        		$processedData['belegnr']="2".substr($processedData['belegnr'],3);
        	}break;
        	case "AIT":{
        		$processedData['konto']="202799";
        		$processedData['belegnr']="3".substr($processedData['belegnr'],3);
        	}break;
        	case "AFR":{
        		$processedData['konto']="202899";
        		$processedData['belegnr']="4".substr($processedData['belegnr'],3);
        	}break;
        	case "AES":{
        		$processedData['konto']="202999";
        		$processedData['belegnr']="5".substr($processedData['belegnr'],3);
        	}break;
        	case "AUK":{
        		$processedData['konto']="203099";
        		$processedData['belegnr']="6".substr($processedData['belegnr'],3);
        	}break;
        }
        
		$processedData['gkto'] = "4000";
		$processedData['extbelegnr'] = "";
		
		$betrag = round($processedData['betrag'],2);
		$processedData['steuer'] = round(-($betrag/1.2)*0.2,2);
		$processedData['betrag'] = round($betrag + $processedData['steuer'],2);
		
		$status = $processedData['skontotage'];
		if($status == "Zurückerstattet") {
			$processedData['steuer'] = -$processedData['steuer'];
			$processedData['betrag'] = $processedData['betrag'];
		}
			

		$processedData['mwst'] = "20";
		
		$invoiceDate = date("d.m.Y", strtotime($processedData['buchdat']));	
		$processedData['buchdat'] = $invoiceDate;
		$processedData['belegdat'] = $processedData['buchdat'];
		
		if($processedData['text'] == "canceled")
			$processedData['text'] = "Gutschrift";
			
		$processedData['text'] =mb_convert_encoding ($processedData['text'],"WINDOWS-1252");
		Tlog::getInstance()->error($processedData['text']);
		
		$processedData['bucod'] = "1";
		$processedData['zziel'] = "";
		$processedData['skontopz'] = "";
		$processedData['skontotage'] = "";
		$processedData['steucod'] = "3";
		$processedData['ebkennz'] = "";
		$processedData['symbol'] = "AR";
        
        return $processedData;
    }
    
    public function current()
    {
    	do {
    		$order = parent::current();
    		
    		$getNext = false;
    		if ($this->rangeDate !== null
    				&& (
    						$order[OrderTableMap::CREATED_AT] < $this->rangeDate['start']
    						|| $order[OrderTableMap::CREATED_AT] > $this->rangeDate['end']
    						)
    				|| (strpos($order[OrderTableMap::REF],"ORD") !== false || strpos($order[OrderTableMap::REF],"OFR") !== false)
    				|| (strpos($order[OrderTableMap::STATUS_ID],"5") !== false)
    				) {
    					
    					$this->next();
    					$getNext = true;
    				}
    	} while ($getNext && $this->valid());
    	
    	$locale = $this->language->getLocale();
    	
    	$query = OrderQuery::create()
    	->useCurrencyQuery()
    	->addAsColumn('currency_CODE', CurrencyTableMap::CODE)
    	->endUse()
    	->useCustomerQuery()
    	->addAsColumn('customer_REF', CustomerTableMap::REF)
    	->addAsColumn('customer_Lastname',CustomerTableMap::LASTNAME)
    	->endUse()
    	->useOrderProductQuery()
    	->useOrderProductTaxQuery(null, Criteria::LEFT_JOIN)
    	->addAsColumn(
    			'product_TAX',
    			'IF('.OrderProductTableMap::WAS_IN_PROMO.','.
    			'SUM('.OrderProductTaxTableMap::PROMO_AMOUNT.'),'.
    			'SUM('.OrderProductTaxTableMap::AMOUNT.')'.
    			')'
    			)
    			->addAsColumn('tax_TITLE', OrderProductTableMap::TAX_RULE_TITLE)
    			->endUse()
    			->addAsColumn('product_TITLE', OrderProductTableMap::TITLE)
    			->addAsColumn(
    					'product_PRICE',
    					'IF('.OrderProductTableMap::WAS_IN_PROMO.','.
    					OrderProductTableMap::PROMO_PRICE .','.
    					OrderProductTableMap::PRICE .
    					')'
    					)
    					->addAsColumn('product_QUANTITY', OrderProductTableMap::QUANTITY)
    					->addAsColumn('product_WAS_IN_PROMO', OrderProductTableMap::WAS_IN_PROMO)
    					->groupById()
    					->endUse()
    					->orderById()
    					->groupById()
    					->useOrderCouponQuery(null, Criteria::LEFT_JOIN)
    					->addAsColumn('coupon_COUPONS', 'GROUP_CONCAT('.OrderCouponTableMap::TITLE.')')
    					->groupBy(OrderCouponTableMap::ORDER_ID)
    					->endUse()
    					->useModuleRelatedByPaymentModuleIdQuery('payment_module')
    					->addAsColumn('payment_module_TITLE', '`payment_module`.CODE')
    					->endUse()
    					->useModuleRelatedByDeliveryModuleIdQuery('delivery_module')
    					->addAsColumn('delivery_module_TITLE', '`delivery_module`.CODE')
    					->endUse()
    					->useOrderAddressRelatedByDeliveryOrderAddressIdQuery('delivery_address_join')
    					->useCustomerTitleQuery('delivery_address_customer_title_join')
    					->useCustomerTitleI18nQuery('delivery_address_customer_title_i18n_join')
    					->addAsColumn('delivery_address_TITLE', '`delivery_address_customer_title_i18n_join`.SHORT')
    					->endUse()
    					->endUse()
    					->useCountryQuery('delivery_address_country_join')
    					->useCountryI18nQuery('delivery_address_country_i18n_join')
    					->addAsColumn('delivery_address_country_TITLE', '`delivery_address_country_i18n_join`.TITLE')
    					->endUse()
    					->addAsColumn('delivery_address_COMPANY', '`delivery_address_join`.COMPANY')
    					->addAsColumn('delivery_address_FIRSTNAME', '`delivery_address_join`.FIRSTNAME')
    					->addAsColumn('delivery_address_LASTNAME', '`delivery_address_join`.LASTNAME')
    					->addAsColumn('delivery_address_ADDRESS1', '`delivery_address_join`.ADDRESS1')
    					->addAsColumn('delivery_address_ADDRESS2', '`delivery_address_join`.ADDRESS2')
    					->addAsColumn('delivery_address_ADDRESS3', '`delivery_address_join`.ADDRESS3')
    					->addAsColumn('delivery_address_ZIPCODE', '`delivery_address_join`.ZIPCODE')
    					->addAsColumn('delivery_address_CITY', '`delivery_address_join`.CITY')
    					->addAsColumn('delivery_address_PHONE', '`delivery_address_join`.PHONE')
    					->endUse()
    					->endUse()
    					->useOrderAddressRelatedByInvoiceOrderAddressIdQuery('invoice_address_join')
    					->useCustomerTitleQuery('invoice_address_customer_title_join')
    					->useCustomerTitleI18nQuery('invoice_address_customer_title_i18n_join')
    					->addAsColumn('invoice_address_TITLE', '`invoice_address_customer_title_i18n_join`.SHORT')
    					->endUse()
    					->endUse()
    					->useCountryQuery('invoice_address_country_join')
    					->useCountryI18nQuery('invoice_address_country_i18n_join')
    					->addAsColumn('invoice_address_country_TITLE', '`invoice_address_country_i18n_join`.TITLE')
    					->endUse()
    					->endUse()
    					->addAsColumn('invoice_address_COMPANY', '`invoice_address_join`.COMPANY')
    					->addAsColumn('invoice_address_FIRSTNAME', '`invoice_address_join`.FIRSTNAME')
    					->addAsColumn('invoice_address_LASTNAME', '`invoice_address_join`.LASTNAME')
    					->addAsColumn('invoice_address_ADDRESS1', '`invoice_address_join`.ADDRESS1')
    					->addAsColumn('invoice_address_ADDRESS2', '`invoice_address_join`.ADDRESS2')
    					->addAsColumn('invoice_address_ADDRESS3', '`invoice_address_join`.ADDRESS3')
    					->addAsColumn('invoice_address_ZIPCODE', '`invoice_address_join`.ZIPCODE')
    					->addAsColumn('invoice_address_CITY', '`invoice_address_join`.CITY')
    					->addAsColumn('invoice_address_PHONE', '`invoice_address_join`.PHONE')
    					->endUse()
    					->useOrderStatusQuery()
    					->useOrderStatusI18nQuery()
    					->addAsColumn('order_status_TITLE', OrderStatusI18nTableMap::TITLE)
    					->endUse()
    					->endUse()
    					->select([
    							OrderTableMap::REF,
    							OrderTableMap::INVOICE_DATE,
    							'customer_REF',
    							'product_TITLE',
    							'product_PRICE',
    							'product_TAX',
    							'tax_TITLE',
    							// PRODUCT_TTC_PRICE
    							'product_QUANTITY',
    							'product_WAS_IN_PROMO',
    							// ORDER_TOTAL_TTC
    							OrderTableMap::DISCOUNT,
    							'coupon_COUPONS',
    							// TOTAL_WITH_DISCOUNT
    							OrderTableMap::POSTAGE,
    							// total ttc +postage
    							'payment_module_TITLE',
    							OrderTableMap::INVOICE_REF,
    							OrderTableMap::DELIVERY_REF,
    							'delivery_module_TITLE',
    							'delivery_address_TITLE',
    							'delivery_address_COMPANY',
    							'delivery_address_FIRSTNAME',
    							'delivery_address_LASTNAME',
    							'delivery_address_ADDRESS1',
    							'delivery_address_ADDRESS2',
    							'delivery_address_ADDRESS3',
    							'delivery_address_ZIPCODE',
    							'delivery_address_CITY',
    							'delivery_address_country_TITLE',
    							'delivery_address_PHONE',
    							'invoice_address_TITLE',
    							'invoice_address_COMPANY',
    							'invoice_address_FIRSTNAME',
    							'invoice_address_LASTNAME',
    							'invoice_address_ADDRESS1',
    							'invoice_address_ADDRESS2',
    							'invoice_address_ADDRESS3',
    							'invoice_address_ZIPCODE',
    							'invoice_address_CITY',
    							'invoice_address_country_TITLE',
    							'invoice_address_PHONE',
    							'order_status_TITLE',
    							'currency_CODE',
    							OrderTableMap::CREATED_AT,
    					])
    					->orderByCreatedAt(Criteria::DESC)
    					;
    					
    					I18n::addI18nCondition(
    							$query,
    							CustomerTitleI18nTableMap::TABLE_NAME,
    							'`delivery_address_customer_title_join`.ID',
    							CustomerTitleI18nTableMap::ID,
    							'`delivery_address_customer_title_i18n_join`.LOCALE',
    							$locale
    							);
    					
    					I18n::addI18nCondition(
    							$query,
    							CustomerTitleI18nTableMap::TABLE_NAME,
    							'`invoice_address_customer_title_join`.ID',
    							CustomerTitleI18nTableMap::ID,
    							'`invoice_address_customer_title_i18n_join`.LOCALE',
    							$locale
    							);
    					
    					I18n::addI18nCondition(
    							$query,
    							CountryI18nTableMap::TABLE_NAME,
    							'`delivery_address_country_join`.ID',
    							CountryI18nTableMap::ID,
    							'`delivery_address_country_i18n_join`.LOCALE',
    							$locale
    							);
    					
    					I18n::addI18nCondition(
    							$query,
    							CountryI18nTableMap::TABLE_NAME,
    							'`invoice_address_country_join`.ID',
    							CountryI18nTableMap::ID,
    							'`invoice_address_country_i18n_join`.LOCALE',
    							$locale
    							);
    					
    					I18n::addI18nCondition(
    							$query,
    							OrderStatusI18nTableMap::TABLE_NAME,
    							OrderStatusI18nTableMap::ID,
    							OrderStatusTableMap::ID,
    							OrderStatusI18nTableMap::LOCALE,
    							$locale
    							);
    					
    					$data = $query
    					->filterById($order[OrderTableMap::ID])
    					->findOne();
    					
    					$order = (new Order)
    					->setId($order[OrderTableMap::ID])
    					;
    					$order->setNew(false);
    					
    					$tax = 0;
    					$data['order_TOTAL_TTC'] = $order->getTotalAmount($tax, false, false);
    					$data['order_TOTAL_WITH_DISCOUNT'] = $order->getTotalAmount($tax, false, true);
    					$data['order_TOTAL_WITH_DISCOUNT_AND_POSTAGE'] = $order->getTotalAmount($tax, true, true);
    					
    					return $data;
    }
    
    protected function getData()
    {
    	return new OrderQuery;
    }
}
