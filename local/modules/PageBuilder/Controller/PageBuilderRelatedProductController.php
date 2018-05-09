<?php

namespace PageBuilder\Controller;

use PageBuilder\Model\Map\PageBuilderProductTableMap;
use PageBuilder\Model\PageBuilderProduct;
use PageBuilder\Model\PageBuilderProductQuery;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\Join;
use Propel\Runtime\Exception\PropelException;
use Thelia\Controller\Admin\BaseAdminController;
use Thelia\Core\Event\Loop\LoopExtendsBuildModelCriteriaEvent;
use Thelia\Core\HttpFoundation\Response;
use Thelia\Model\Map\ProductTableMap;
use Thelia\Model\Product;
use Thelia\Model\ProductCategory;
use Thelia\Model\ProductCategoryQuery;
use Thelia\Model\ProductQuery;

class PageBuilderRelatedProductController extends BaseAdminController
{

    /**
     * Return product which they are related to a category id in a select.
     *
     * @return Response
     */
    public function getProductRelated()
    {
        
        $categoryID = $this->getRequest()->get('categoryID');

        $lang = $this->getRequest()->getSession()->get('thelia.current.lang');
        $productCategory = ProductCategoryQuery::create();

        $result = array();

        if ($categoryID !== null) {
            $productCategory->filterByCategoryId($categoryID)
                ->find();
            if ($productCategory !== null) {
                /** @var ProductCategory $item */
                foreach ($productCategory as $item) {
                    $product = ProductQuery::create()
                        ->filterById($item->getProductId())
                        ->findOne();

                    if (null !== $product) {
                        $result[] = [
                            'id' => $product->getId(),
                            'title' => $product->getTranslation($lang->getLocale())->getTitle()
                        ];
                    }
                }
            }
        }
        return $this->jsonResponse(json_encode($result));
    }

    /**
     * Add product to the current pageBuilder
     *
     * @return Response
     * @throws PropelException
     */
    public function addProductRelated()
    {
        $productID = $this->getRequest()->get('productID');
        $pageBuilderID = $this->getRequest()->get('pageBuilderID');
        $lang = $this->getRequest()->getSession()->get('thelia.current.lang');

        $productRelated = new PageBuilderProduct();

        if ($productID !== null) {
            $PageBuilderProduit = PageBuilderProductQuery::create()
                ->filterByProductId($productID)
                ->filterByPageBuilderId($pageBuilderID)
                ->findOne();

            if (is_null($PageBuilderProduit)) {
                //Insert in the table PageBuilder_product
                $productRelated->setPageBuilderId($pageBuilderID);
                $productRelated->setProductId($productID);

                $position = PageBuilderProductQuery::create()
                    ->filterByPageBuilderId($pageBuilderID)
                    ->orderByPosition(Criteria::DESC)
                    ->select('position')
                    ->findOne();

                if (null === $position) {
                    $productRelated->setPosition(1);
                } else {
                    $productRelated->setPosition($position + 1);
                }
                $productRelated->save();
            }
            /** @var  Product $search */
            /** @var  LoopExtendsBuildModelCriteriaEvent $event */
            $search = ProductQuery::create();
            $pageBuilderProductRelated = new Join(
                ProductTableMap::ID,
                PageBuilderProductTableMap::PRODUCT_ID,
                Criteria::INNER_JOIN
            );
            $search->addJoinObject($pageBuilderProductRelated, 'pageBuilderProductRelated');
            $search->addJoinCondition(
                'pageBuilderProductRelated',
                PageBuilderProductTableMap::PAGE_BUILDER_ID.' = '.$pageBuilderID
            );
            $search->find();

            $result = array();
            /** @var Product $row */
            foreach ($search as $row) {
                $pageBuilderProductPos = PageBuilderProductQuery::create()
                    ->filterByPageBuilderId($pageBuilderID)
                    ->filterByProductId($row->getId())
                    ->findOne();

                $result = [
                    'id' => $row->getId() ,
                    'title' => $row->getTranslation($lang->getLocale())->getTitle(),
                    'position' => $pageBuilderProductPos->getPosition(),
                ];
            }
        }
        
        return $this->render('related/productRelated', ['page_builder_id' => $pageBuilderID]);
    }

    /**
     * Show product related to a pageBuilder
     *
     * @param null $p
     * @return array|Response
     * @throws PropelException
     */
    public function showProduct($p = null)
    {

        $pageBuilderID = $this->getRequest()->get('pageBuilderID');
        $lang = $this->getRequest()->getSession()->get('thelia.current.lang');
        
        /** @var  Product $search */
        /** @var  LoopExtendsBuildModelCriteriaEvent $event */
        $search = ProductQuery::create();
        $pageBuilderProductRelated = new Join(
            ProductTableMap::ID,
            PageBuilderProductTableMap::PRODUCT_ID,
            Criteria::INNER_JOIN
        );
        $search->addJoinObject($pageBuilderProductRelated, 'pageBuilderProductRelated');
        $search->addJoinCondition(
            'pageBuilderProductRelated',
            PageBuilderProductTableMap::PAGE_BUILDER_ID.' = '.$pageBuilderID
        );
        $search->find();

        $result = array();
        /** @var Product $row */
        foreach ($search as $row) {
            $pageBuilderProductPos = PageBuilderProductQuery::create()
                ->filterByPageBuilderId($pageBuilderID)
                ->filterByProductId($row->getId())
                ->findOne();

            $result = [
                            'id' => $row->getId() ,
                            'title' => $row->getTranslation($lang->getLocale())->getTitle(),
                            'position' => $pageBuilderProductPos->getPosition(),
                        ];
        }

        if ($p === null) {
            return $this->render('related/productRelated', ['page_builder_id' => $pageBuilderID]);
        } else {
            return $result;
        }
    }
}
