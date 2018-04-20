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
use Thelia\Model\ProductQuery;
use Propel\Runtime\ActiveQuery\ModelCriteria as MCriteria;
use Propel\Runtime\ActiveQuery\Criteria;
use Thelia\Core\Event\FeatureProduct\FeatureProductDeleteEvent;
use Thelia\Core\Event\FeatureProduct\FeatureProductUpdateEvent;
use Thelia\Core\Event\MetaData\MetaDataCreateOrUpdateEvent;
use Thelia\Core\Event\MetaData\MetaDataDeleteEvent;
use Thelia\Core\Event\Product\ProductAddAccessoryEvent;
use Thelia\Core\Event\Product\ProductAddCategoryEvent;
use Thelia\Core\Event\Product\ProductAddContentEvent;
use Thelia\Core\Event\Product\ProductCloneEvent;
use Thelia\Core\Event\Product\ProductCombinationGenerationEvent;
use Thelia\Core\Event\Product\ProductCreateEvent;
use Thelia\Core\Event\Product\ProductDeleteAccessoryEvent;
use Thelia\Core\Event\Product\ProductDeleteCategoryEvent;
use Thelia\Core\Event\Product\ProductDeleteContentEvent;
use Thelia\Core\Event\Product\ProductDeleteEvent;
use Thelia\Core\Event\Product\ProductEvent;
use Thelia\Core\Event\Product\ProductSetTemplateEvent;
use Thelia\Core\Event\Product\ProductToggleVisibilityEvent;
use Thelia\Core\Event\Product\ProductUpdateEvent;
use Thelia\Core\Event\ProductSaleElement\ProductSaleElementCreateEvent;
use Thelia\Core\Event\ProductSaleElement\ProductSaleElementDeleteEvent;
use Thelia\Core\Event\ProductSaleElement\ProductSaleElementUpdateEvent;
use Thelia\Core\Event\TheliaEvents;
use Thelia\Core\Event\UpdatePositionEvent;
use Thelia\Core\HttpFoundation\JsonResponse;
use Thelia\Core\HttpFoundation\Response;
use Thelia\Core\Security\AccessManager;
use Thelia\Core\Security\Resource\AdminResources;
use Thelia\Core\Template\Loop\Document;
use Thelia\Core\Template\Loop\Image;
use Thelia\Form\BaseForm;
use Thelia\Form\Definition\AdminForm;
use Thelia\Form\Exception\FormValidationException;
use Thelia\Form\ProductModificationForm;
use Thelia\Model\AccessoryQuery;
use Thelia\Model\AttributeAv;
use Thelia\Model\AttributeAvQuery;
use Thelia\Model\AttributeQuery;
use Thelia\Model\CategoryQuery;
use Thelia\Model\Content;
use Thelia\Model\ContentQuery;
use Thelia\Model\Country;
use Thelia\Model\Currency;
use Thelia\Model\CurrencyQuery;
use Thelia\Model\Feature;
use Thelia\Model\FeatureProductQuery;
use Thelia\Model\FeatureQuery;
use Thelia\Model\FeatureTemplateQuery;
use Thelia\Model\FolderQuery;
use Thelia\Model\MetaData;
use Thelia\Model\MetaDataQuery;
use Thelia\Model\Product;
use Thelia\Model\ProductAssociatedContentQuery;
use Thelia\Model\ProductDocument;
use Thelia\Model\ProductDocumentQuery;
use Thelia\Model\ProductImageQuery;
use Thelia\Model\ProductPrice;
use Thelia\Model\ProductPriceQuery;
use Thelia\Model\ProductSaleElements as ProductSaleElementsModel;
use Thelia\Model\ProductSaleElementsProductDocument;
use Thelia\Model\ProductSaleElementsProductDocumentQuery;
use Thelia\Model\ProductSaleElementsProductImage;
use Thelia\Model\ProductSaleElementsProductImageQuery;
use Thelia\Model\ProductSaleElementsQuery;
use Thelia\Model\TaxRuleQuery;
use Thelia\TaxEngine\Calculator;
use Thelia\Type\BooleanOrBothType;
use Thelia\Model\FeatureProduct;


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
class IndexProducts extends ProductQuery
// class IndexProducts  extends BaseI18nLoop
{
    
      public function __construct($dbName = 'thelia', $modelName = '\\Thelia\\Model\\Product', $modelAlias = null)
    {
            parent::__construct($dbName, $modelName, $modelAlias);
    }


    public function getAllProducts() {

        $log = Tlog::getInstance();


        $list = ProductQuery::create()
               ->setFormatter(MCriteria::FORMAT_ON_DEMAND)
               ->find();

            if ($list !== null) {
                               foreach ($list as $item) {
                    $result[] = array('id' => $item->getId(), 'title' => $item->getTitle());
                }
            }
            var_dump(count($result));die;
        
    }
    

}



