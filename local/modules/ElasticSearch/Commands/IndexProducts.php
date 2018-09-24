<?php

/* * ********************************************************************************** */
/*      This file is part of the Thelia package.                                     */
/*                                                                                   */
/*      Copyright (c) OpenStudio                                                     */
/*      email : dev@thelia.net                                                       */
/*      web : http://www.thelia.net                                                  */
/*                                                                                   */
/*      For the full copyright and license information, please view the LICENSE.txt  */
/*      file that was distributed with this source code.                             */
/* * ********************************************************************************** */

namespace ElasticSearch\Commands;

use ElasticSearch\Controller\Front\ElasticConnection;
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
use Faker\Provider\DateTime;
use Propel\Runtime\ActiveQuery\ModelCriteria;

class IndexProducts extends ProductQuery
{

    public function indexAllProducts($lang, $locale = null)
    {
        print_r("--> Index language: " . strtoupper($lang) . " <--\n   ");
        sleep(2);
        $log = Tlog::getInstance();

        $currency                    = CurrencyModel::getDefaultCurrency();
        $defaultCurrencySuffix       = '_default_currency';
        $priceToCompareAsSQL         = '';
        $isPSELeftJoinList           = [
         ];
        $isProductPriceFirstLeftJoin = [
         ];
        $joiningTable                = "global";
        $list                        = ProductQuery::create();
        $list->addJoin(ProductTableMap::ID, ProductI18nTableMap::ID)
         ->addJoin(ProductTableMap::ID, ProductSaleElementsTableMap::PRODUCT_ID)
         ->addJoin(ProductTableMap::ID, ProductCategoryTableMap::PRODUCT_ID)
         ->addJoin(ProductCategoryTableMap::CATEGORY_ID, CategoryI18nTableMap::ID)
         ->addJoin(ProductSaleElementsTableMap::ID, ProductPriceTableMap::PRODUCT_SALE_ELEMENTS_ID)
         ->addJoin(ProductI18nTableMap::ID, ProductImageTableMap::PRODUCT_ID)
         ->addJoin(ProductTableMap::BRAND_ID, BrandI18nTableMap::ID)
         ->where(ProductI18nTableMap::LOCALE . "='" . $locale . "'" .
          " and " . CategoryI18nTableMap::LOCALE . "='" . $locale . "'" .
          " and " . BrandI18nTableMap::LOCALE . "='" . $locale . "'" .
          " and " . ProductImageTableMap::POSITION . " = 1 " .
          " and " . ProductTableMap::VISIBLE . " = 1 ")
         ->withColumn('product.id', 'product_id')
         ->withColumn('`product`.`extern_id`', 'external_id')
         ->withColumn('`product_sale_elements`.`ean_code`', 'ean_code')
         ->withColumn('`product`.`ref`', "ref")
         ->withColumn('`product`.`brand_id`', "brand_id")
         ->withColumn('`brand_i18n`.`title`', "brand_name")
         ->withColumn('`product_category`.`category_id`', 'category_id')
         ->withColumn('`category_i18n`.`title`', "category_name")
         ->withColumn('`product_i18n`.`title`', "product_title")
         ->withColumn('`product_i18n`.`description`', "product_description")
         ->withColumn('`product_price`.`price`', "product_price")
         ->withColumn('`product_price`.`promo_price`', "product_promo_price")
         ->withColumn('`product_price`.`listen_price`', "product_listen_price")
         ->withColumn('`product_image`.`file`', "image")
         ->withColumn('`product`.`created_at`', "created_at")
         ->withColumn('`product`.`updated_at`', "update_at")
         ->withColumn('`product_sale_elements`.`promo`', "is_promo")
         ->withColumn('`category_i18n`.`locale`', "locale")
         ->withColumn('`product`.`visible`', "visible")
        ;

        print_r("Total item to be indexed: " . $list->count() . "\n");
        sleep(5);

        if ($list !== null) {

            $elasticsearch = new ElasticConnection();
            $i             = 0;
            foreach ($list as $item) {
                $arrFeautures = array();
                try {
                    $query_features = ProductQuery::create();
                    $query_features->addJoin(ProductTableMap::ID, FeatureProductTableMap::PRODUCT_ID)
                     ->addJoin(FeatureProductTableMap::FEATURE_ID, FeatureI18nTableMap::ID)
                     ->where(FeatureI18nTableMap::LOCALE . "='de_DE'" .
                      " and " . ProductTableMap::ID . "=" . $item->getVirtualColumn("product_id")
                     )
                     ->withColumn('`feature_i18n`.`title`', "feature_title")
                     ->withColumn('`feature_i18n`.`description`', "feature_desc")
                     ->setFormatter(ModelCriteria::FORMAT_ON_DEMAND)
                     ->find()

                    ;
                } catch (Exception $e) {
                    $log->error($e);
                }
                if ($query_features !== null) {
                    foreach ($query_features as $feature) {
                        $arrFeautures[] = array(
                         "feature_title" => (string) $feature->getVirtualColumn('feature_title'),
                         "feature_desc"  => (string) $feature->getVirtualColumn('feature_desc')
                        );
                        $i++;
                    }
                } else {
                    $arrFeautures[] = array();
                    $i++;
                }

                print_r("Index item with id:" . $item->getVirtualColumn('product_id') . "  ---- ");
                $result = array(
                 'product_id'                => $item->getVirtualColumn("product_id"),
                 'product_title'             => $item->getVirtualColumn("product_title"),
                 'product_description'       => $item->getVirtualColumn("product_description"),
                 "categories"                => array(
                  'category_name' => $item->getVirtualColumn("category_name"),
                  'category_id'   => $item->getVirtualColumn("category_id"),
                 ),
                 "brands"                    => array(
                  'brand_name' => $item->getVirtualColumn("brand_name"),
                  'brand_id'   => $item->getVirtualColumn("brand_id"),
                 ),
                 'product_price'             => (float) $item->getVirtualColumn("product_price"),
                 'product_promo_price'       => (float) $item->getVirtualColumn("product_promo_price"),
                 'product_taxed_price'       => (float) ((float) $item->getVirtualColumn("product_price") * 1.20),
                 'product_promo_taxed_price' => (float) ((float) $item->getVirtualColumn("product_promo_price") * 1.20),
                 'product_listen_price'      => (float) $item->getVirtualColumn("product_listen_price"),
                 'image'                     => (string) $item->getVirtualColumn("image"),
                 'is_promo'                  => (int) $item->getVirtualColumn("image") <> NULL ? (int) $item->getVirtualColumn("image") : 0,
                 'is_active'                 => 1,
                 'created_at'                => $item->getVirtualColumn("created_at") <> NULL ? date("Y-m-d H:m:s",
                                                                                                     strtotime((string) $item->getVirtualColumn("created_at"))) : date("Y-m-d H:m:s",
                                                                                                                                                                       strtotime((string) $item->getVirtualColumn("update_at"))),
                 'update_at'                 => date("Y-m-d H:m:s",
                                                     strtotime((string) $item->getVirtualColumn("update_at"))),
                 'feature'                   => $arrFeautures,
                 "locale"                    => (string) $item->getVirtualColumn("locale"),
                 "country_taxes"             => 20
                );

                $params = [
                 'index' => 'product_' . $lang,
                 'type'  => 'default',
                 'body'  => json_encode($result)
                ];


                try {
                    $objElasticIndexConnection = $elasticsearch::getConnection();
                    $respones                  = $objElasticIndexConnection->index($params);
                    print($respones['result'] . "\n");
                } catch (Exception $e) {
                    $log->error($e);
                }
            }
        }
    }

    public function deleteAllDocumentsFromIndex($lang, $locale = null)
    {
        $elasticsearch             = new ElasticConnection();
        $objElasticIndexConnection = $elasticsearch::getConnection();


        $json    = '{
    "query": {
      "match_all": {}
    }
  }';
        $params  = [
         'index' => 'product_' . $lang,
         'type'  => "default",
         'body'  => $json,
        ];
        $respons = $objElasticIndexConnection->deleteByQuery($params);
        print_r("Deleted document:" . $respons['total'] . "\n");
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
