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
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Selection\Model\Base\SelectionQuery;
use Selection\Model\Map\SelectionFeaturesTableMap;
use Selection\Model\Map\SelectionI18nTableMap;
use Selection\Model\Map\SelectionImageTableMap;
use Selection\Model\Map\SelectionProductTableMap;
use Selection\Model\Map\SelectionTableMap;
use Selection\Model\SelectionI18nQuery;
use Symfony\Component\Serializer\Exception\Exception;
use Thelia\Log\Tlog;
use Thelia\Model\Base\ProductPriceQuery;
use Thelia\Model\Base\ProductQuery as ProductQuery;
use Thelia\Model\Currency as CurrencyModel;
use Thelia\Model\Map\FeatureI18nTableMap;
use Thelia\Model\Map\ProductPriceTableMap;
use Thelia\Model\Map\ProductSaleElementsTableMap;

class IndexSelection extends ProductQuery
{

    public function indexAllSelection($lang, $locale = null)
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


        $list = SelectionI18nQuery::create()
         ->addJoin(SelectionI18nTableMap::ID, SelectionTableMap::ID)
         ->addJoin(SelectionTableMap::ID, SelectionImageTableMap::SELECTION_ID)
         ->withColumn('selection.id', 'selection_id')
         ->withColumn('selection_i18n.title', 'selection_title')
         ->withColumn('selection_i18n.description', 'selection_description')
         ->withColumn('selection_image.file', 'selection_image')
         ->where("selection_i18n.locale = '" . $locale . "'")
         ->setFormatter(ModelCriteria::FORMAT_ON_DEMAND)
         ->find();

        print_r("Total selection to be indexed: " . $list->count() . "\n");
        sleep(5);

        if ($list->count() > 0) {
            $Elasticsearch = new ElasticConnection();
        } else {
            print_r("Total selection to be indexed:  0 , proces will stop !!!! \n");
        }

        $Elasticsearch = new ElasticConnection();

        foreach ($list as $item) {
            $objPrice = ProductPriceQuery::create()
             ->addJoin(ProductPriceTableMap::PRODUCT_SALE_ELEMENTS_ID, ProductSaleElementsTableMap::ID)
             ->addJoin(ProductSaleElementsTableMap::PRODUCT_ID, SelectionProductTableMap::PRODUCT_ID)
             ->withColumn("SUM(product_price.price)", "selection_price")
             ->addGroupByColumn(SelectionProductTableMap::SELECTION_ID)
             ->where('selection_product.selection_id =' . $item->getId())
             ->setFormatter(ModelCriteria::FORMAT_ON_DEMAND)
             ->find();
            foreach ($objPrice as $price) {
                $selection_price = $price->getVirtualColumn('selection_price');
            }

            $objSelection = SelectionQuery::create()
             ->filterById($item->getId())
             ->findOne();

            //feautures 

            $i            = 0;
            $arrFeautures = array();
            try {
                $query_features = SelectionQuery::create();
                $query_features->addJoin(SelectionTableMap::ID, SelectionFeaturesTableMap::SELECTION_ID)
                 ->addJoin(SelectionFeaturesTableMap::FEATURE_ID, FeatureI18nTableMap::ID)
                 ->where(FeatureI18nTableMap::LOCALE . "='" . $locale . "'" .
                  " and " . SelectionTableMap::ID . "=" . $item->getId()
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
            print_r("Index item with id:" . $item->getId() . "  ---- ");
            $result = ['product_id'          => $item->getVirtualColumn("selection_id"),
             'product_title'       => $item->getTitle("selection_title"),
             'product_description' => $item->getDescription("selection_description"),
             'product_price'       => $selection_price,
             'image'               => (string) $item->getVirtualColumn("selection_image"),
             'is_active'           => 1,
             'is_selection'        => 1,
             'created_at'          => $objSelection->getUpdatedAt()->format("Y-m-d H:m:s"),
             'update_at'           => $objSelection->getUpdatedAt()->format("Y-m-d H:m:s"),
             'feature'             => $arrFeautures,
             "locale"              => (string) $locale
            ];


            $params = [
             'index' => 'product_' . $lang,
             'type'  => 'default',
             'body'  => json_encode($result)
            ];


            try {
                $objElasticIndexConnection = $Elasticsearch::getConnection();
                $respones                  = $objElasticIndexConnection->index($params);
                print($respones['result'] . "\n");
            } catch (Exception $e) {
                $log->error($e);
            }
        }
    }

}
