<?php
namespace AmazonIntegration\Loop;

use Thelia\Core\Template\Element\BaseI18nLoop;
use Thelia\Core\Template\Element\LoopResult;
use Thelia\Core\Template\Element\LoopResultRow;
use Thelia\Core\Template\Element\PropelSearchLoopInterface;
use Thelia\Core\Template\Loop\Argument\ArgumentCollection;
use Thelia\Log\Tlog;
use Thelia\Model\BrandI18nQuery;
use Thelia\Model\Map\BrandI18nTableMap;

/**
 * BrandLoop
 *
 * Class BrandLoop
 */
class BrandLoop extends BaseI18nLoop implements PropelSearchLoopInterface
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
        /** @var \AmazonIntegration\Loop\BrandLoop $listing */
        
        foreach ($loopResult->getResultDataCollection() as $listing) {
            $loopResultRow = new LoopResultRow($listing);
            $loopResultRow->set("id", $listing->getId())
                ->set("title", $listing->getTitle());
            
            $loopResult->addRow($loopResultRow); 
        }
        return $loopResult;
    }

    public function buildModelCriteria()
    {
        $query = BrandI18nQuery::create()
                ->where(BrandI18nTableMap::LOCALE.' = ?', 'de_DE', \PDO::PARAM_STR)
                ->orderByTitle();
        
        return $query;
    }
}
