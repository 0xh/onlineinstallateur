<?php

namespace Carousel\Loop;

use Carousel\Model\CarouselHookQuery;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Exception\PropelException;
use Thelia\Core\Template\Element\BaseI18nLoop;
use Thelia\Core\Template\Element\LoopResult;
use Thelia\Core\Template\Element\LoopResultRow;
use Thelia\Core\Template\Element\PropelSearchLoopInterface;
use Thelia\Core\Template\Loop\Argument\ArgumentCollection;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ConfiguratorHookLoop
 *
 * @author Catana Florin
 */
class CarouselHookLoop extends BaseI18nLoop implements PropelSearchLoopInterface
{

    public $countable     = true;
    public $timestampable = false;
    public $versionable   = false;

    /*     * *
     * @return ArgumentCollection
     */

    protected function getArgDefinitions()
    {
        return new ArgumentCollection();
    }

    /**
     * @return ModelCriteria|PageBuilderQuery
     * @throws PropelException
     */
    public function buildModelCriteria()
    {

        $configuratorList = CarouselHookQuery::create();

        return $configuratorList;
    }

    /**
     * @param LoopResult $loopResult
     *
     * @return LoopResult
     */
    public function parseResults(LoopResult $loopResult)
    {
        foreach ($loopResult->getResultDataCollection() as $carousel) {

            /** @var PageBuilder $pageBuilder */
            $loopResultRow = new LoopResultRow($carousel);

            $loopResultRow
             ->set("id", $carousel->getId())
             ->set("hook_code", $carousel->getHookCode())
             ->set("hook_id", $carousel->getHookId())
             ->set("carousel_id", $carousel->getCarouselId());
            
            \Thelia\Log\Tlog::getInstance()->err($loopResultRow);

            $loopResult->addRow($loopResultRow);
        }
        return $loopResult;
    }

}
