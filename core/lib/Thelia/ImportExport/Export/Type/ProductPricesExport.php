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
use Thelia\Model\ProductSaleElementsQuery;
use Thelia\Model\ProductQuery;
use Thelia\Model\ProductCategoryQuery;
use Thelia\Model\Map\ProductCategoryTableMap;
use Thelia\Model\Map\BrandI18nTableMap;
use Thelia\Model\Map\BrandTableMap;
use Thelia\Model\BrandI18n;
use Thelia\Model\Map\CategoryI18nTableMap;
use HookCalendar\Model\Base\ProductCategory;
use Thelia\Model\Map\CategoryTableMap;

/**
 * Class ProductPricesExport
 * @package Thelia\ImportExport\Export\Type
 * @author Benjamin Perche <bperche@openstudio.fr>
 * @author Jérôme Billiras <jbilliras@openstudio.fr>
 * @contributor Thomas Arnaud <tarnaud@openstudio.fr>
 */
class ProductPricesExport extends AbstractExport
{
    const FILE_NAME = 'product_price';

    protected $orderAndAliases = [
        ProductSaleElementsTableMap::ID => 'product_sale_id',
        'productID' => 'Product_id',
        'product_i18nTITLE' => 'Title',
        'attribute_av_i18n_ATTRIBUTES' => 'Attributes',
        ProductSaleElementsTableMap::EAN_CODE => 'Ean',
        'product_pricePRICE' => 'Price',
        'product_pricePROMO_PRICE' => 'Promo_price',
        'currencyCODE' => 'Currency',
        ProductSaleElementsTableMap::PROMO => 'Promo',
    	'productVISIBLE' => 'Online/offline',
    	'productREF' => 'Ref_nr',
    	'product_priceLISTEN_PRICE' => 'Listenpreis',
    	'weight' => 'Gewicht',
    	'brand_i18nTITLE' => 'Marke/Anbieter',
    	'category_i18nTITLE' => 'Standart Produkt Kategorie'
    ];

    protected function getData()
    {
        $locale = $this->language->getLocale();

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
