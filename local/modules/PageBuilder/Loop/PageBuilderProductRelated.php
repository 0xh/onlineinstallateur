<?php

namespace PageBuilder\Loop;

use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\Join;
use PageBuilder\Model\Map\PageBuilderContentTableMap;
use PageBuilder\Model\PageBuilderProduct;
use PageBuilder\Model\PageBuilderProductQuery;
use Thelia\Core\Template\Element\BaseLoop;
use Thelia\Core\Template\Element\LoopResult;
use Thelia\Core\Template\Element\LoopResultRow;
use Thelia\Core\Template\Element\PropelSearchLoopInterface;
use Thelia\Core\Template\Loop\Argument\Argument;
use Thelia\Core\Template\Loop\Argument\ArgumentCollection;
use Thelia\Model\Map\ProductI18nTableMap;

/**
 * Class PageBuilderProductRelated
 *
 * @package Thelia\Core\Template\Loop
 *
 * {@inheritdoc}
 * @method int[] getProductId()
 * @method int[] getPageBuilderId()
 * @method string getProductTitle()
 * @method int[] getPosition()
 */
class PageBuilderProductRelated extends BaseLoop implements PropelSearchLoopInterface
{
    public $countable = true;
    public $timestampable = false;
    public $versionable = false;

    protected function getArgDefinitions()
    {
        return new ArgumentCollection(
            Argument::createIntListTypeArgument('product_id'),
            Argument::createAnyTypeArgument('product_title'),
            Argument::createIntListTypeArgument('page_builder_id'),
            Argument::createIntListTypeArgument('position')
        );
    }

    /**
     * @return \Propel\Runtime\ActiveQuery\ModelCriteria|PageBuilderProductQuery
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function buildModelCriteria()
    {
        $search = PageBuilderProductQuery::create();

        
        if (null !== $product_id = $this->getProductID()) {
            $search->filterByProductId($product_id, Criteria::IN);
        }


        if (null !== $page_builder_id = $this->getPageBuilderId()) {
            $search->filterByPageBuilderId($page_builder_id, Criteria::IN);
        }

        if (null !== $position = $this->getPosition()) {
            $search->filterByPosition($position, Criteria::IN);
        }

        if (null !== $product_title = $this->getProductTitle()) {
            $join = new Join(
                ProductI18nTableMap::ID,
                PageBuilderContentTableMap::CONTENT_ID,
                Criteria::INNER_JOIN
            );
            $search->addJoinObject($join, 'search')
                ->addJoinCondition('search', ProductI18nTableMap::TITLE."=". $product_title);
        }
        return $search->orderByPosition(Criteria::ASC);
    }

    /**
     * @param LoopResult $loopResult
     * @return LoopResult
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function parseResults(LoopResult $loopResult)
    {

        foreach ($loopResult->getResultDataCollection() as $product) {

            /** @var PageBuilderProduct $product */
            $loopResultRow = new LoopResultRow($product);
            $lang = $this->request->getSession()->get('thelia.current.lang');
            $loopResultRow
                ->set("PRODUCT_ID", $product->getProductId())
                ->set("PRODUCT_TITLE", $product->getProduct()->getTitle())
                ->set("POSITION", $product->getPosition())
                ->set("page_builder_id", $product->getPageBuilderId());

            $loopResult->addRow($loopResultRow);
        }
        return $loopResult;
    }
}
