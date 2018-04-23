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

namespace ElasticSearch\Commands;

use Thelia\Log\Tlog;
use Thelia\Model\Base\ProductQuery as ProductQuery;
use Thelia\Model\Currency as CurrencyModel;
use Thelia\Model\Map\BrandI18nTableMap;
use Thelia\Model\Map\CategoryI18nTableMap;
use Thelia\Model\Map\FeatureI18nTableMap;
use Thelia\Model\Map\FeatureProductTableMap;
use Thelia\Model\Map\ProductCategoryTableMap;
use Thelia\Model\Map\ProductI18nTableMap;
use Thelia\Model\Map\ProductImageTableMap;
use Thelia\Model\Map\ProductPriceTableMap;
use Thelia\Model\Map\ProductSaleElementsTableMap;
use Thelia\Model\Map\ProductTableMap;
use ElasticSearch\Controller\Front\ElasticConnection;

class IndexProducts extends ProductQuery
{
    public function getAllProducts($locale = null) {
        print_r("Reindex language: ".$locale."\n");
        $log = Tlog::getInstance();

        $currency = CurrencyModel::getDefaultCurrency();
        $defaultCurrencySuffix = '_default_currency';
        $priceToCompareAsSQL = '';
        $isPSELeftJoinList = [];
        $isProductPriceFirstLeftJoin = [];
        $joiningTable = "global";
        $list = ProductQuery::create();
        $list->addJoin(ProductTableMap::ID, ProductI18nTableMap::ID)
             
             ->addJoin(ProductTableMap::ID, ProductSaleElementsTableMap::PRODUCT_ID)
             
             ->addJoin(ProductTableMap::ID, ProductCategoryTableMap::PRODUCT_ID)
             ->addJoin(ProductCategoryTableMap::CATEGORY_ID, CategoryI18nTableMap::ID)
             ->addJoin(ProductSaleElementsTableMap::ID, ProductPriceTableMap::PRODUCT_SALE_ELEMENTS_ID)
             ->addJoin(ProductI18nTableMap::ID, ProductImageTableMap::PRODUCT_ID)
             ->addJoin(ProductTableMap::BRAND_ID, BrandI18nTableMap::ID)                
             // ->addJoin(ProductTableMap::ID, RewritingUrlTableMap::VIEW_ID, Criteria::LEFT_JOIN)
             ->addJoin(ProductTableMap::ID, FeatureProductTableMap::PRODUCT_ID)                
             ->addJoin(FeatureProductTableMap::FEATURE_ID, FeatureI18nTableMap::ID)
             ->where(ProductI18nTableMap::LOCALE . "='de_DE'".
                     " and " .   CategoryI18nTableMap::LOCALE ."='de_DE'" .
                     " and " .  BrandI18nTableMap::LOCALE ."='de_DE'" .
                     " and " .  FeatureI18nTableMap::LOCALE ."='de_DE'" .
                     " and " .  ProductImageTableMap::POSITION ." = 1 ")
            ->withColumn ( 'product.id' , 'product_id' )
             ->withColumn ( '`product`.`extern_id`' , 'external_id')
             ->withColumn ( '`product_sale_elements`.`ean_code`' , 'ean_code')
            ->withColumn ( '`product`.`ref`' ,"ref")
             ->withColumn ( '`product`.`brand_id`' ,"brand_id")
             ->withColumn ( '`brand_i18n`.`title`' ,"brand_name")
             ->withColumn ( '`product_category`.`category_id`','category_id')
             ->withColumn ( '`category_i18n`.`title`' ,"category_name")
             ->withColumn ( '`product_i18n`.`title`' ,"product_title")
            ->withColumn ( '`product_i18n`.`description`' ,"product_description")
             ->withColumn ( '`product_price`.`price`' ,"product_price")
             ->withColumn ( '`product_price`.`promo_price`' ,"product_promo_price")
             ->withColumn ( '`product_price`.`listen_price`' ,"product_listen_price")
             ->withColumn ( '`product_image`.`file`' ,"image")
             ->withColumn ( '`product`.`created_at`' ,"created_at")
             ->withColumn ( '`product`.`updated_at`' ,"update_at")
             ->withColumn ( '`feature_i18n`.`title`' ,"feature_title")
             ->withColumn ( '`feature_i18n`.`description`' ,"feature_desc")            
              ;


            if ($list !== null) {

                $elasticsearch =  new Elasticsearch();
                foreach ($list as $item) {
                 $result = array(
                                'id' => $item->getId(), 
                                'product_title' => $item->getTitle() ,
                                'product_description'=> $item->getDescription(),
                                'categories' => array(
                                    'category_name'=> $item->getVirtualColumns("category_name"),
                                    'category_id'=> $item->getVirtualColumns("category_id")
                                ),
                                "brands"=> array(
                                    'brand_name'=> $item->getVirtualColumns("brand_name"),
                                    'brand_id'=> $item->getVirtualColumns("brand_id")
                                ),
                                "product_price" =>  $item->getVirtualColumns("product_price"),
                                "product_promo_price"=> $item->getVirtualColumns("product_promo_price"),
                                "product_listen_price"=> $item->getVirtualColumns("product_listen_price"),
                                "image"=> $item->getVirtualColumns("image"),
                                "created_at"=> $item->getVirtualColumns("created_at"),
                                "update_at" =>  $item->getVirtualColumns("update_at"),
                                "feature_title"=>  $item->getVirtualColumns("feature_title"),
                                "feature_desc"=>  $item->getVirtualColumns("feature_desc")
                            );

                        $json = json_encode($result);

                        $respones =   $elasticsearch->index($json_encode);

                        print_r($respones); die;

                }
            }

            var_dump($result[1]);
            var_dump(count($result));die;
        
    }
    
    protected function getDefaultCategoryId($product)
    {
        $defaultCategoryId = null;
        if ((bool) $product->getVirtualColumn('is_default_category')) {
            $defaultCategoryId = $product->getVirtualColumn('default_category_id');
        } else {
            $defaultCategoryId = $product->getDefaultCategoryId();
        }
        return $defaultCategoryId;
    }
    


}



