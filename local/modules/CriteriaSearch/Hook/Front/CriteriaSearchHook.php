<?php


namespace CriteriaSearch\Hook\Front;

use CriteriaSearch\CriteriaSearch;
use CriteriaSearch\Handler\CriteriaSearchHandler;
use CriteriaSearch\Model\CriteriaSearchCategoryTaxRuleQuery;
use Propel\Runtime\ActiveQuery\Criteria;
use Thelia\Core\Event\Hook\HookRenderEvent;
use Thelia\Core\Hook\BaseHook;
use Thelia\Model\ProductPriceQuery;
use Thelia\Log\Tlog;
use Thelia\Model\ProductCategoryQuery;
use Thelia\Model\CategoryQuery;
use HookCalendar\Model\Category;

class CriteriaSearchHook extends BaseHook
{
    /** @var CriteriaSearchHandler $criteriaSearchHandler */
    protected $criteriaSearchHandler;

    public function __construct(CriteriaSearchHandler $criteriaSearchHandler)
    {
        /** @var CriteriaSearchHandler $criteriaHandler */
        $this->criteriaSearchHandler = $criteriaSearchHandler;
    }

    public function onCriteriaSearchSearchCss(HookRenderEvent $event)
    {
        $event->add($this->render(
            'criteria-search/search-css.html'
        ));
    }

    public function onCriteriaSearchSearchPage(HookRenderEvent $event)
    {
        $request = $this->getRequest();

        $params['category_id'] = $event->getArgument('category_id');

        $categorieTaxeRule = CriteriaSearchCategoryTaxRuleQuery::create()
            ->findOneByCategoryId($params['category_id']);

        //Enable price filter only if a tax rule is chosen for this category
        if (null !== $categorieTaxeRule && null !== $categorieTaxeRule->getTaxRuleId()) {
            $params['price_filter'] = CriteriaSearch::getConfigValue('price_filter');
        }

        $params['brand_filter'] = CriteriaSearch::getConfigValue('brand_filter');
        $params['new_filter'] = CriteriaSearch::getConfigValue('new_filter');
        $params['promo_filter'] = CriteriaSearch::getConfigValue('promo_filter');
        $params['stock_filter'] = CriteriaSearch::getConfigValue('stock_filter');

        $this->criteriaSearchHandler->getLoopParamsFromQuery($params, $request);
        
       

        if (null !== $params['category_id']) {
        	
        	$subcategories = CategoryQuery::create()->findAllChild($params['category_id'],99);
        	$log = Tlog::getInstance ();
        	
        	$categories_array=array();
        	array_push($categories_array,$params['category_id']);
        	if($subcategories != null){
        		
        		foreach ($subcategories as $subcategory)
        			array_push($categories_array,$subcategory->getId());
        			
        		
        	$log->info("criteriasearch categories ".implode(" ",$categories_array));
        	}
        	
            $categoryProductMaxPrice = ProductPriceQuery::create()
                ->useProductSaleElementsQuery()
                    ->useProductQuery()
                        ->useProductCategoryQuery()
                            ->filterByCategoryId($categories_array)
                        ->endUse()
                    ->endUse()
                ->endUse()
                ->select('price')
                ->orderBy('price', Criteria::DESC)
            ->limit(1)
            ->findOne();

            
            
            
            $params['max_price_filter'] = ceil($categoryProductMaxPrice/10)*10;
            
            $log->info("criteriasearch max_price_filter ".$categoryProductMaxPrice);

            if ( $params['max_price_filter']>0) {
                $params['value_price_filter'] = [];

                $priceSlice = $params['max_price_filter']/4;

                for ($i = 0; $i <=  $params['max_price_filter']; $i = $i+$priceSlice) {
                    $params['value_price_filter'][] = $i;
                }
            }
        }

        $event->add($this->render(
            'criteria-search/search-page.html',
            $params
        ));
    }

    public function onCriteriaSearchSearchJs(HookRenderEvent $event)
    {
        $event->add($this->render(
            'criteria-search/search-js.html'
        ));
    }
}
