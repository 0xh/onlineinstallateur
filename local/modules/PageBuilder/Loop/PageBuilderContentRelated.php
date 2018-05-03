<?php

namespace PageBuilder\Loop;

use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\Join;
use PageBuilder\Model\Map\PageBuilderContentTableMap;
use PageBuilder\Model\PageBuilderContent;
use PageBuilder\Model\PageBuilderContentQuery;
use Thelia\Core\Template\Element\BaseLoop;
use Thelia\Core\Template\Element\LoopResult;
use Thelia\Core\Template\Element\LoopResultRow;
use Thelia\Core\Template\Element\PropelSearchLoopInterface;
use Thelia\Core\Template\Loop\Argument\Argument;
use Thelia\Core\Template\Loop\Argument\ArgumentCollection;
use Thelia\Model\Map\ContentI18nTableMap;

class PageBuilderContentRelated extends BaseLoop implements PropelSearchLoopInterface
{
    public $countable = true;
    public $timestampable = false;
    public $versionable = false;

    protected function getArgDefinitions()
    {
        return new ArgumentCollection(
            Argument::createIntListTypeArgument('content_id'),
            Argument::createIntListTypeArgument('page_builder_id'),
            Argument::createAnyTypeArgument('content_title'),
            Argument::createIntListTypeArgument('position')
        );
    }

    /**
     * @return \Propel\Runtime\ActiveQuery\ModelCriteria|PageBuilderContentQuery
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function buildModelCriteria()
    {
        $search = PageBuilderContentQuery::create();


        if (null !== $content_id = $this->getContentId()) {
            $search->filterByContentId($content_id, Criteria::IN);
        }

        if (null !== $position = $this->getPosition()) {
            $search->filterByPosition($position, Criteria::IN);
        }
        if (null !== $page_builder_id = $this->getPageBuilderId()) {
            $search->filterByPageBuilderId($page_builder_id, Criteria::IN);
        }

        if (null !== $content_title = $this->getContentTitle()) {
            $join = new Join(
                ContentI18nTableMap::ID,
                PageBuilderContentTableMap::CONTENT_ID,
                Criteria::INNER_JOIN
            );
            $search->addJoinObject($join, 'search')
                ->addJoinCondition('search', ContentI18nTableMap::TITLE."=". $content_title);
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

        foreach ($loopResult->getResultDataCollection() as $content) {

            /** @var PageBuilderContent $content */
            $loopResultRow = new LoopResultRow($content);
            $lang = $this->request->getSession()->get('thelia.current.lang');
            $loopResultRow
                ->set("CONTENT_ID", $content->getContentId())
                ->set("CONTENT_TITLE", $content->getContent()->getTitle())
                ->set("POSITION", $content->getPosition())
                ->set("page_builder_id", $content->getPageBuilderId());


            $loopResult->addRow($loopResultRow);
        }

        return $loopResult;
    }
}
