<?php
namespace AmazonIntegration\Loop;

use Thelia\Core\Template\Element\BaseI18nLoop;
use Thelia\Core\Template\Element\LoopResult;
use Thelia\Core\Template\Element\LoopResultRow;
use Thelia\Core\Template\Element\PropelSearchLoopInterface;
use Thelia\Core\Template\Loop\Argument\ArgumentCollection;
use Thelia\Log\Tlog;
use Thelia\Model\ModuleConfigQuery;
use Thelia\Model\Map\ModuleConfigTableMap;

/**
 * AmazonIntegrationMarketPlaceIdLoop loop
 *
 * Class AmazonIntegrationMarketPlaceIdLoop
 */
class AmazonIntegrationMarketPlaceIdLoop extends BaseI18nLoop implements PropelSearchLoopInterface
{

    protected $timestampable = true;

    protected $versionable = true;

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
        /** @var \AmazonIntegration\Model\AmazonIntegrationListing $listing */
        
        foreach ($loopResult->getResultDataCollection() as $listing) {
            
            $loopResultRow = new LoopResultRow($listing);
            $loopResultRow->set("id", $listing->getId())
                ->set("marketPlaceName", ltrim($listing->getName(), 'MARKETPLACE_'))
                ->set("marketPlaceValue", $listing->getValue());
            
            $loopResult->setVersioned(false);
            $loopResult->addRow($loopResultRow);
        }
        
        return $loopResult;
    }

    public function buildModelCriteria()
    {
        $query = ModuleConfigQuery::create()
                ->where(ModuleConfigTableMap::NAME." like 'MARKETPLACE_%'");

        return $query;
    }
}
