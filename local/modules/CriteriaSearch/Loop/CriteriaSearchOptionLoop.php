<?php


namespace CriteriaSearch\Loop;

use Thelia\Core\Template\Element\BaseI18nLoop;
use Thelia\Core\Template\Element\PropelSearchLoopInterface;
use Thelia\Core\Template\Element\LoopResult;
use Thelia\Core\Template\Loop\Argument\Argument;
use Thelia\Core\Template\Element\LoopResultRow;
use CriteriaSearch\Model\CriteriaSearchCategoryOptionsQuery;
use Thelia\Core\Template\Loop\Argument\ArgumentCollection;

class CriteriaSearchOptionLoop extends BaseI18nLoop implements PropelSearchLoopInterface
{
    protected function getArgDefinitions()
    {
        return new ArgumentCollection(
            Argument::createIntTypeArgument("category")
        );
    }
        
    public function buildModelCriteria()
    {
        /** @var CriteriaSearchCategoryOptionsQuery $query */
        $query = CriteriaSearchCategoryOptionsQuery::create()
        ->filterByCategoryId($this->getCategory());

        return $query;
    }


    /**
     * @param LoopResult $loopResult
     *
     * @return LoopResult
     */
    public function parseResults(LoopResult $loopResult)
    {
        /** @var CriteriaSearchCategoryOptions $feature */
        foreach ($loopResult->getResultDataCollection() as $option) {
            $loopResultRow = new LoopResultRow($option);
            $loopResultRow->set("ID", $option->getId())
            ->set("OPTION", $option->getOption())
            ->set('SEARCHABLE', $option->getSearchable());
            
            $loopResult->addRow($loopResultRow);
        }
        
        return $loopResult;
    }
}
