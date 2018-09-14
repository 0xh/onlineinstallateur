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
use Selection\Model\Selection;
use Selection\Model\SelectionI18nQuery;
use Selection\Model\SelectionQuery;
use Selection\Model\SelectionProductQuery;

class SelectionProductTotal extends BaseI18nLoop  implements PropelSearchLoopInterface {

	protected function getArgDefinitions()
    {
        return new ArgumentCollection(
            Argument::createAnyTypeArgument('selection_id')
        );
    }

    /**
     * @return \Propel\Runtime\ActiveQuery\ModelCriteria|SelectionContentQuery
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function buildModelCriteria()
    {
    	$search = SelectionProductQuery::create()
            	->filterBySelectionId( 1 );

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

      		$loopResultRow = new LoopResultRow($content);
            $loopResultRow
                ->set("SELECTION_PRODUCT_ID", $content->getProductId());

            $loopResult->addRow($loopResultRow);
        }
       return $loopResult;
    }
}