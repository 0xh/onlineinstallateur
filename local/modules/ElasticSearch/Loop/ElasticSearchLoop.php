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


namespace ElasticSearch\Loop;

use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\Join;
use Thelia\Core\Template\Element\BaseI18nLoop;
use Thelia\Core\Template\Element\LoopResult;
use Thelia\Core\Template\Element\LoopResultRow;
use Thelia\Core\Template\Element\PropelSearchLoopInterface;
use Thelia\Core\Template\Element\SearchLoopInterface;
use Thelia\Core\Template\Loop\Argument\Argument;
use Thelia\Core\Template\Loop\Argument\ArgumentCollection;
use Thelia\Exception\TaxEngineException;
use Thelia\Log\Tlog;
use Thelia\Model\CategoryQuery;
use Thelia\Model\ConfigQuery;
use Thelia\Model\CurrencyQuery;
use Thelia\Model\Currency as CurrencyModel;
use Thelia\Model\Map\ProductPriceTableMap;
use Thelia\Model\Map\ProductSaleElementsTableMap;
use Thelia\Model\Map\ProductTableMap;
use Thelia\Model\Map\SaleTableMap;
use Thelia\Model\ProductCategoryQuery;
use Thelia\Model\ProductQuery;
use Thelia\Model\Product as ProductModel;
use Thelia\Type;
use Thelia\Type\TypeCollection;
use ElasticSearch\Controller\Front\ElasticSearchController;
Use ElasticSearch\Controller\Front\ElasticConnection;

/**
 *
 * Product loop
 *
 * Class Product
 * @package Thelia\Core\Template\Loop
 * @author Etienne Roudeix <eroudeix@openstudio.fr>
 *
 * {@inheritdoc}
 * @method int[] getId()
 * @method bool getComplex()
 * @method string[] getRef()
 * @method int[] getCategory()
 * @method int[] getBrand()
 * @method int[] getSale()
 * @method int[] getCategoryDefault()
 * @method int[] getContent()
 * @method bool getNew()
 * @method bool getPromo()
 * @method float getMinPrice()
 * @method float getMaxPrice()
 * @method int getMinStock()
 * @method float getMinWeight()
 * @method float getMaxWeight()
 * @method bool getWithPrevNextInfo()
 * @method bool|string getWithPrevNextVisible()
 * @method bool getCurrent()
 * @method bool getCurrentCategory()
 * @method bool getDepth()
 * @method bool|string getVirtual()
 * @method bool|string getVisible()
 * @method int getCurrency()
 * @method string getTitle()
 * @method bool hasEan()
 * @method string[] getOrder()
 * @method int[] getExclude()
 * @method int[] getExcludeCategory()
 * @method int[] getFeatureAvailability()
 * @method string[] getFeatureValues()
 * @method string[] getAttributeNonStrictMatch()
 */
class ElasticSearchLoop extends BaseI18nLoop implements PropelSearchLoopInterface 
{
    

    /**
     * @return ArgumentCollection
     */
    protected function getArgDefinitions()
    {
        return new ArgumentCollection();
    }

    public function parseResults(LoopResult $loopResult)
    {
        $search = new ElasticConnection();
    // echo "<pre>";var_dump($loopResult);die("debug");
        foreach ($search->fullTextSearch($this->request->get("q"), 0, 10, 10) as $product) {

            $price=$product["_source"]["product_price"];
        //     $promoPrice = 1;
        //     $taxedPrice= 0;
        //     $taxedPromoPrice =0 ;
                $loopResultRow = new LoopResult();
                    echo "<pre>";var_dump($loopResultRow);die("debug");


        //     $loopResultRows
        //         ->set("WEIGHT", $product["_source"]['weight'])
        //         ->set("ID", $product["_source"]['id'])
        //         ->set("QUANTITY", $product["_source"]['quantity'])
        //         ->set("EAN_CODE", $product["_source"]['ean_code'])
        //         ->set("BEST_PRICE", $product["_source"]['is_promo'] ? $promoPrice : $price)
        //         ->set("BEST_PRICE_TAX", $taxedPrice - $product["_source"]['is_promo'] ? $taxedPromoPrice - $promoPrice : $taxedPrice - $price)
        //         ->set("BEST_TAXED_PRICE", $product["_source"]['is_promo'] ? $taxedPromoPrice : $taxedPric)
        //         ->set("PRICE", $price)
        //         ->set("PRICE_TAX", $taxedPrice - $price)
        //         ->set("TAXED_PRICE", $taxedPrice)
        //         ->set("PROMO_PRICE", $promoPrice)
        //         ->set("PROMO_PRICE_TAX", $taxedPromoPrice - $promoPrice)
        //         ->set("TAXED_PROMO_PRICE", $taxedPromoPrice)
        //         ->set("IS_PROMO", $product["_source"]['is_promo'])
        //         ->set("IS_NEW", $product["_source"]['is_new'])
        //         ->set("PRODUCT_SALE_ELEMENT", $product["_source"]['pse_id'])
        //         ->set("PSE_COUNT", $product["_source"]['pse_count'])
        //         ->set("LISTEN_PRICE",$product["_source"]['listen_price']);
            $loopResult->addRow($loopResultRow);
            $results[] = $product["_source"];
        }

        // echo "<pre>";var_dump($loopResult);die("debug");
        return $results;
    }

   
   

    public function buildModelCriteria()
    {
        $search =  ProductQuery::create()->limit(1);
        return $search;
    }
}
