<?php

namespace PageBuilder\Loop;

use PageBuilder\Model\Map\PageBuilderTableMap;
use PageBuilder\Model\PageBuilder;
use PageBuilder\Model\PageBuilderElementQuery;
use PageBuilder\Model\PageBuilderI18nQuery;
use PageBuilder\Model\PageBuilderQuery;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\Join;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Exception\PropelException;
use Thelia\Core\Template\Element\BaseI18nLoop;
use Thelia\Core\Template\Element\LoopResult;
use Thelia\Core\Template\Element\LoopResultRow;
use Thelia\Core\Template\Element\PropelSearchLoopInterface;
use Thelia\Core\Template\Loop\Argument\Argument;
use Thelia\Core\Template\Loop\Argument\ArgumentCollection;
use Thelia\Model\Map\RewritingUrlTableMap;
use Thelia\Type\BooleanOrBothType;

/**
 * Class PageBuilderElementLoop
 *
 * @package Thelia\Core\Template\Loop
 *
 * {@inheritdoc}
 * @method int[] getExclude()
 * @method int[] getId()
 * @method string getTitle()
 * @method int[] getPosition()
 * @method bool|string getVisible()
 */
class PageBuilderElementLoop extends BaseI18nLoop implements PropelSearchLoopInterface {

    public $countable = true;
    public $timestampable = false;
    public $versionable = false;

    /*     * *
     * @return ArgumentCollection
     */

    protected function getArgDefinitions() {
        return new ArgumentCollection(
                Argument::createIntTypeArgument('page_builder_id')
        );
    }

    /**
     * @return ModelCriteria|PageBuilderQuery
     * @throws PropelException
     */
    public function buildModelCriteria() {

        $search = PageBuilderElementQuery::create()
                ->orderByPosition()
                ->addJoin(\PageBuilder\Model\Map\PageBuilderElementTableMap::ID, \PageBuilder\Model\Map\PageBuilderElementI18nTableMap::ID)
                ->withColumn(\PageBuilder\Model\Map\PageBuilderElementI18nTableMap::VARIABLES, 'variables' )
                ->where(\PageBuilder\Model\Map\PageBuilderElementTableMap::PAGE_BUILDER_ID . "=" . $this->getPageBuilderId());

        return $search;
    }

    /**
     * @param LoopResult $loopResult
     *
     * @return LoopResult
     */
    public function parseResults(LoopResult $loopResult) {
        foreach ($loopResult->getResultDataCollection() as $pageBuilderElement) {

            $loopResultRow = new LoopResultRow($pageBuilderElement);

            $loopResultRow
                    ->set("ELEMENT_ID", $pageBuilderElement->getId())
                    ->set("PAGE_BUILDER_ID", $pageBuilderElement->getPageBuilderId())
                    ->set("VISIBLE", $pageBuilderElement->getVisible())
                    ->set("POSITION", $pageBuilderElement->getPosition())
                    ->set("TEMPLATE_NAME", $pageBuilderElement->getTemplateName())
                    ->set("VARIABLES", $pageBuilderElement->getVirtualColumn("variables"));
            $loopResult->addRow($loopResultRow);
        }
        
        return $loopResult;
    }

}
