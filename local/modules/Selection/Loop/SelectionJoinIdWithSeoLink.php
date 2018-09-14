<?php

namespace Selection\Loop;

use Propel\Runtime\ActiveQuery\Criteria;
use Thelia\Core\Template\Element\PropelSearchLoopInterface;
use Thelia\Core\Template\Element\BaseLoop;
use Thelia\Core\Template\Element\BaseI18nLoop;
use Thelia\Core\Template\Element\LoopResult;
use Thelia\Core\Template\Element\LoopResultRow;
use Thelia\Core\Template\Loop\Argument\Argument;
use Thelia\Core\Template\Loop\Argument\ArgumentCollection;
use Thelia\Model\RewritingUrlQuery;

class SelectionJoinIdWithSeoLink extends BaseI18nLoop  implements PropelSearchLoopInterface 
{
	protected function getArgDefinitions()
    {
        return new ArgumentCollection(
            Argument::createAnyTypeArgument('rewrite_uri')
        );
    }

    /**
     * @return \Propel\Runtime\ActiveQuery\ModelCriteria|SelectionContentQuery
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function buildModelCriteria()
    {

        $search = RewritingUrlQuery::create()
            	->filterByUrl( substr($this->getRewriteUri(), 1) )
            	->filterByViewLocale('de_DE');
                
        return $search;
    }

    /**
     * @param LoopResult $loopResult
     * @return LoopResult
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function parseResults(LoopResult $loopResult)
    {

        foreach ($loopResult->getResultDataCollection() as $content) {

            /** @var SelectionContent $content */
            $loopResultRow = new LoopResultRow($content);
            $loopResultRow
                ->set("SELECTION_ID", $content->getViewId());
         
            $loopResult->addRow($loopResultRow);
        }

        return $loopResult;
    }
}