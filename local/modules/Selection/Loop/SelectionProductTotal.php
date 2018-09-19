<?php

namespace Selection\Loop;

use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Exception\PropelException;
use Selection\Model\Map\SelectionProductTableMap;
use Selection\Model\SelectionContentQuery;
use Selection\Model\SelectionProductQuery;
use Thelia\Core\Template\Element\BaseI18nLoop;
use Thelia\Core\Template\Element\LoopResult;
use Thelia\Core\Template\Element\LoopResultRow;
use Thelia\Core\Template\Element\PropelSearchLoopInterface;
use Thelia\Core\Template\Loop\Argument\Argument;
use Thelia\Core\Template\Loop\Argument\ArgumentCollection;
use Thelia\Model\Map\ProductI18nTableMap;
use Thelia\Model\Map\ProductPriceTableMap;
use Thelia\Model\Map\ProductSaleElementsTableMap;

class SelectionProductTotal extends BaseI18nLoop implements PropelSearchLoopInterface
{

    protected function getArgDefinitions()
    {
        return new ArgumentCollection(
         Argument::createAnyTypeArgument('selection_id')
        );
    }

    /**
     * @return ModelCriteria|SelectionContentQuery
     * @throws PropelException
     */
    public function buildModelCriteria()
    {
        $search = SelectionProductQuery::create()
         ->setFormatter(ModelCriteria::FORMAT_ON_DEMAND)
         ->addJoin(SelectionProductTableMap::PRODUCT_ID, ProductI18nTableMap::ID)
//                ->addJoin(ProductSaleElementsTableMap::PRODUCT_ID, SelectionProductTableMap::PRODUCT_ID)
         ->addJoin(ProductI18nTableMap::ID, ProductSaleElementsTableMap::PRODUCT_ID)
         ->addJoin(ProductSaleElementsTableMap::ID, ProductPriceTableMap::PRODUCT_SALE_ELEMENTS_ID)
         ->withColumn(ProductI18nTableMap::TITLE, "title")
         ->withColumn(ProductSaleElementsTableMap::ID, "product_sale_elements_id")
         ->withColumn(ProductPriceTableMap::PRICE, "price")
         ->filterBySelectionId($this->getSelectionId())
         ->where(ProductI18nTableMap::LOCALE . '=' . '"de_DE" ');

        return $search;
    }

    /**
     * @param LoopResult $loopResult
     * @return LoopResult
     * @throws PropelException
     */
    public function parseResults(LoopResult $loopResult)
    {
        foreach ($loopResult->getResultDataCollection() as $content) {

            $loopResultRow = new LoopResultRow($content);
            $loopResultRow
             ->set("SELECTION_PRODUCT_ID", $content->getProductId())
             ->set("SELECTION_PRODUCT_PRICE", $content->getPrice())
             ->set("product_sale_elements_id", $content->getVirtualColumn("product_sale_elements_id"))
             ->set("SELECTION_PRODUCT_TITLE", $content->getTitle());

            $loopResult->addRow($loopResultRow);
        }
        return $loopResult;
    }

}
