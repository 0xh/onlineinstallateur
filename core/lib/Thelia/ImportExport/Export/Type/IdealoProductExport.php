<?php

namespace Thelia\ImportExport\Export\Type;

use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\Join;
use Thelia\ImportExport\Export\AbstractExport;
use Thelia\Model\Map\AttributeAvI18nTableMap;
use Thelia\Model\Map\AttributeAvTableMap;
use Thelia\Model\Map\CurrencyTableMap;
use Thelia\Model\Map\ProductI18nTableMap;
use Thelia\Model\Map\ProductPriceTableMap;
use Thelia\Model\Map\ProductSaleElementsTableMap;
use Thelia\Model\Map\ProductTableMap;
use Thelia\Model\Map\TaxRuleI18nTableMap;
use Thelia\Model\Map\TaxRuleTableMap;
use Thelia\Model\ProductSaleElementsQuery;
use Thelia\Model\Map\BrandI18nTableMap;
use Thelia\Model\Map\ProductCategoryTableMap;
use Thelia\Model\Map\CategoryI18nTableMap;
use Thelia\Model\Map\RewritingUrlTableMap;
use Thelia\Model\Product;

/**
 * Class IdealoProductExport
 * @author Emanuel Plopu <emanuel.plopu@sepa.at>
 */
class IdealoProductExport extends AbstractExport
{
    const FILE_NAME = 'product_idealo';
    
    protected $orderAndAliases = [
    		'productID' => 'Artikelnummer',
    		ProductSaleElementsTableMap::EAN_CODE => 'EAN',
    		'productREF' => 'Herstellerartikelnummern',
    		'brand_i18nTITLE' => 'Marke/Anbieter',
    		'product_i18nTITLE' => 'Produktname',    		
    		'product_pricePRICE' => 'Preis',
    		'product_pricePROMO_PRICE' => 'Spezialpreis',
    		'product_priceLISTEN_PRICE' => 'Streichpreis',
    		ProductSaleElementsTableMap::PROMO => 'Promo',
    		'productVISIBLE' => 'Lieferzeit',
    		'product_URL' => 'Produkt_URL'
    ];
    
    protected function getData()
    {
    	$locale = $this->language->getLocale();
    
    	$urlJoin = new Join(ProductTableMap::ID, RewritingUrlTableMap::VIEW_ID, Criteria::LEFT_JOIN);
    	$productJoin = new Join(ProductTableMap::ID, ProductI18nTableMap::ID, Criteria::LEFT_JOIN);
    	$attributeAvJoin = new Join(AttributeAvTableMap::ID, AttributeAvI18nTableMap::ID, Criteria::LEFT_JOIN);
    	$brandJoin = new Join(ProductTableMap::ID, BrandI18nTableMap::ID, Criteria::LEFT_JOIN);
    	$categoryJoin = new Join(ProductCategoryTableMap::CATEGORY_ID, CategoryI18nTableMap::ID, Criteria::LEFT_JOIN);
    
    	$query = ProductSaleElementsQuery::create()
    	->addSelfSelectColumns()
    	->useProductPriceQuery()
    	->useCurrencyQuery()
    	->withColumn(CurrencyTableMap::CODE)
    	->endUse()
    	->withColumn(ProductPriceTableMap::PRICE)
    	->withColumn(ProductPriceTableMap::PROMO_PRICE)
    	->withColumn(ProductPriceTableMap::LISTEN_PRICE)
    	->endUse()
    	->useProductQuery()
    	->addJoinObject($productJoin, 'product_join')
    	->addJoinCondition(
    			'product_join',
    			ProductI18nTableMap::LOCALE . ' = ?',
    			$locale,
    			null,
    			\PDO::PARAM_STR
    			)
    			->withColumn(ProductI18nTableMap::TITLE)
    			->withColumn(ProductTableMap::ID)
    			->withColumn(ProductTableMap::REF)
    			->withColumn(ProductTableMap::VISIBLE)
    			
    			->addJoinObject($urlJoin, 'rewriting_url_join')
    			->addJoinCondition(
    					'rewriting_url_join',
    					RewritingUrlTableMap::VIEW_LOCALE . ' = ?',
    					$locale,
    					null,
    					\PDO::PARAM_STR
    					)
    					->addJoinCondition(
    							'rewriting_url_join',
    							RewritingUrlTableMap::VIEW . ' = ?',
    							(new Product())->getRewrittenUrlViewName(),
    							null,
    							\PDO::PARAM_STR
    							)
    							->addJoinCondition('rewriting_url_join', 'ISNULL(' . RewritingUrlTableMap::REDIRECTED . ')')
    							->addJoinObject($productJoin, 'product_join')
    							->addJoinCondition('product_join', ProductI18nTableMap::LOCALE . ' = ?', $locale, null, \PDO::PARAM_STR)
    			
    			->addJoinObject($brandJoin, 'brand_join')
    			->addJoinCondition(
    					'brand_join',
    					BrandI18nTableMap::LOCALE . ' = ?',
    					$locale,
    					null,
    					\PDO::PARAM_STR
    					)
    					->withColumn(BrandI18nTableMap::TITLE)
    
    					->useProductCategoryQuery()
    					->addJoinObject($categoryJoin, 'category_join')
    					->addJoinCondition(
    							'category_join',
    							CategoryI18nTableMap::LOCALE . ' = ?',
    							$locale,
    							null,
    							\PDO::PARAM_STR
    							)
    							->withColumn(CategoryI18nTableMap::TITLE)
    							->endUse()
    							->endUse()
    
    							->useAttributeCombinationQuery(null, Criteria::LEFT_JOIN)
    							->useAttributeAvQuery(null, Criteria::LEFT_JOIN)
    							->addJoinObject($attributeAvJoin, 'attribute_av_join')
    							->addJoinCondition(
    									'attribute_av_join',
    									AttributeAvI18nTableMap::LOCALE . ' = ?',
    									$locale,
    									null,
    									\PDO::PARAM_STR
    									)
    									->addAsColumn(
    											'attribute_av_i18n_ATTRIBUTES',
    											'GROUP_CONCAT(DISTINCT ' . AttributeAvI18nTableMap::TITLE . ')'
    											)
    											->endUse()
    											->endUse()
    											->orderBy(ProductSaleElementsTableMap::ID)
    											->groupBy(ProductSaleElementsTableMap::ID)
    											;
    
    											return $query;
    }
    }
