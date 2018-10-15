<?php

namespace ElasticSearch\Controller\Front;

use ElasticSearch\Controller\Front\ElasticConnection;
use Thelia\Controller\Front\BaseFrontController;
use Propel\Runtime\Util\PropelModelPager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Thelia\Core\HttpFoundation\Request;
use Thelia\Core\Security\SecurityContext;
use Thelia\Core\Template\Element\BaseLoop;
use Thelia\Core\Template\Element\LoopResult;
use TheliaSmarty\Template\AbstractSmartyPlugin;
use TheliaSmarty\Template\SmartyPluginDescriptor;
use Thelia\Core\Template\Element\Exception\ElementNotFoundException;
use Thelia\Core\Template\Element\Exception\InvalidElementException;
use Thelia\Core\Translation\Translator;
use Thelia\Core\Template\Element\SearchLoopInterface;

class ElasticSearchController extends BaseFrontController
{

    public function showResults()
    {
        $end   = $this->getRequest()->get('page') <> NULL ? $this->getRequest()->get('page') : 1;
        $limit = $this->getRequest()->get('limit') <> NULL ? $this->getRequest()->get('limit') : 24;
        $order = $this->getRequest()->get('order') <> NULL ? $this->getRequest()->get('order') : "alpha";
        $page  = $this->getRequest()->get('page') <> NULL ? $this->getRequest()->get('page') : 1;


        $start   = $page > 1 ? ($page * $limit) : 0;
        $search  = new ElasticConnection();
        $results = $search->fullTextSearch($this->getRequest()->get('q'), $start, $end, $limit, $order);
        if ($results == NULL || count($results) == 1) {
            $results[] = "no results where found!!";
        } else {

            $results['start']        = $start;
            $results['end']          = $end;
            $results['limit']        = $limit;
            $results['order']        = $order;
            $results['current_page'] = $page;
        }

        return $this->render("search_results_page",
                             array(
          "RESULTS" => $results,
          "PAGES"   => ceil($results['total'] / $limit)));
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
