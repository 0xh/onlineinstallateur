<?php

namespace PageBuilder\Loop;

use PageBuilder\Model\Map\PageBuilderTableMap;
use PageBuilder\Model\PageBuilder;
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
 * Class PageBuilderLoop
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
class PageBuilderLoop extends BaseI18nLoop implements PropelSearchLoopInterface {

    public $countable = true;
    public $timestampable = false;
    public $versionable = false;

    /*     * *
     * @return ArgumentCollection
     */

    protected function getArgDefinitions() {
        return new ArgumentCollection(
                Argument::createIntListTypeArgument('id'), Argument::createBooleanOrBothTypeArgument('visible', true), Argument::createAnyTypeArgument('title'), Argument::createIntListTypeArgument('position'), Argument::createIntListTypeArgument('exclude')
        );
    }

    /**
     * @return ModelCriteria|PageBuilderQuery
     * @throws PropelException
     */
    public function buildModelCriteria() {
        $search = PageBuilderQuery::create();

        /* manage translations */
        $this->configureI18nProcessing($search, array('TITLE', 'CHAPO', 'HEADER', 'FOOTER', 'POSTSCRIPTUM',));

        if (null !== $exclude = $this->getExclude()) {
            $search->filterById($exclude, Criteria::NOT_IN);
        }

        if (null !== $id = $this->getId()) {
            $search->filterById($id, Criteria::IN);
        }

        if (null !== $position = $this->getPosition()) {
            $search->filterByPosition($position, Criteria::IN);
        }


        if (null !== $title = $this->getTitle()) {
            //find all page that match exactly this title and find with all locales.
            $search2 = PageBuilderI18nQuery::create()
                    ->filterByTitle($title, Criteria::LIKE)
                    ->select('id')
                    ->find();

            if ($search2) {
                $search->filterById(
                        $search2, Criteria::IN
                );
            }
        }

        $visible = $this->getVisible();
        if (BooleanOrBothType::ANY !== $visible) {
            $search->filterByVisible($visible ? 1 : 0);
        }

        $search->orderByPosition(Criteria::ASC);

        return $search;
    }

    /**
     * @param LoopResult $loopResult
     *
     * @return LoopResult
     */
    public function parseResults(LoopResult $loopResult) {
        foreach ($loopResult->getResultDataCollection() as $pageBuilder) {

            /** @var PageBuilder $pageBuilder */
            $loopResultRow = new LoopResultRow($pageBuilder);
//            echo '<pre>';
//            var_dump($pageBuilder->getUrl("de_DE"));
            $pageBuilder->getUrl();
//            die;
            $loopResultRow
                    ->set("PAGE_BUILDER_ID", $pageBuilder->getId())
//                ->set("PAGE_BUILDER_URL", "en_US") // $this->getReturnUrl() ? $pageBuilder->getUrl($this->locale) : null)
                    ->set("PAGE_BUILDER_URL", $this->getReturnUrl() ? $pageBuilder->getUrl($this->locale) : null)
                    ->set("PAGE_BUILDER_TITLE", $pageBuilder->geti18n_TITLE())
                    ->set("PAGE_BUILDER_POSITION", $pageBuilder->getPosition())
                    ->set("PAGE_BUILDER_VISIBLE", $pageBuilder->getVisible())
                    ->set("PAGE_BUILDER_HEADER", $pageBuilder->geti18n_HEADER())
                    ->set("PAGE_BUILDER_FOOTER", $pageBuilder->geti18n_FOOTER())
                    ->set("PAGE_BUILDER_POSTSCRIPTUM", $pageBuilder->geti18n_POSTSCRIPTUM())
                    ->set("PAGE_BUILDER_CHAPO", $pageBuilder->geti18n_CHAPO());
            $loopResult->addRow($loopResultRow);
        }
        return $loopResult;
    }

}
