<?php
namespace AmazonIntegration\Loop;

use Thelia\Core\Template\Element\BaseI18nLoop;
use Thelia\Core\Template\Element\LoopResult;
use Thelia\Core\Template\Element\LoopResultRow;
use Thelia\Core\Template\Element\PropelSearchLoopInterface;
use Thelia\Core\Template\Loop\Argument\ArgumentCollection;
use Thelia\Log\Tlog;
use Thelia\Model\CurrencyQuery;

/**
 * CurrencyLoop
 *
 * Class CurrencyLoop
 */
class CurrencyLoop extends BaseI18nLoop implements PropelSearchLoopInterface
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
        $log = Tlog::getInstance();
        $log->err("listingresults " . $loopResult->getCount());
        /** @var \AmazonIntegration\Loop\CurrencyLoop $listing */
        
        foreach ($loopResult->getResultDataCollection() as $listing) {
            $loopResultRow = new LoopResultRow($listing);
            $loopResultRow->set("id", $listing->getId())
                ->set("code", $listing->getCode())
                ->set("symbol", $listing->getSymbol());
            
            $loopResult->addRow($loopResultRow); 
        }
        return $loopResult;
    }

    public function buildModelCriteria()
    {
        $query = CurrencyQuery::create()
                ->orderById();
        
        return $query;
    }
}
