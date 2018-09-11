<?php

namespace Carousel\Loop;

use Carousel\Model\CarouselNameQuery;
use Thelia\Core\Template\Element\BaseI18nLoop;
use Thelia\Core\Template\Element\LoopResult;
use Thelia\Core\Template\Element\LoopResultRow;
use Thelia\Core\Template\Element\PropelSearchLoopInterface;
use Thelia\Core\Template\Loop\Argument\ArgumentCollection;

/**
 * CarouselListLoop
 *
 * Class CarouselListLoop
 */
class CarouselListLoop extends BaseI18nLoop implements PropelSearchLoopInterface
{

    /**
     *
     * @return ArgumentCollection
     */
    protected function getArgDefinitions()
    {
        return new ArgumentCollection();
    }

    public function parseResults(LoopResult $loopResult)
    {

        /** @var \Carousel\Model\CarouselListLoop $listing */
        foreach ($loopResult->getResultDataCollection() as $listing) {
            $loopResultRow = new LoopResultRow($listing);
            $loopResultRow->set("id", $listing->getId())
             ->set("name", $listing->getName())
             ->set("template", $listing->getTemplate());
            $loopResult->addRow($loopResultRow);
        }
        return $loopResult;
    }

    public function buildModelCriteria()
    {
        $query = CarouselNameQuery::create();

        return $query;
    }

}
