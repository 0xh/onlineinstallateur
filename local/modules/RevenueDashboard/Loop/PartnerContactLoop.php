<?php

namespace RevenueDashboard\Loop;

use Propel\Runtime\ActiveQuery\Criteria;
use RevenueDashboard\Model\Map\WholesalePartnerContactPersonTableMap;
use RevenueDashboard\Model\WholesalePartnerContactPersonQuery;
use Thelia\Core\Template\Element\BaseI18nLoop;
use Thelia\Core\Template\Element\LoopResult;
use Thelia\Core\Template\Element\LoopResultRow;
use Thelia\Core\Template\Element\PropelSearchLoopInterface;
use Thelia\Core\Template\Loop\Argument\ArgumentCollection;
use Thelia\Log\Tlog;
use Thelia\Model\Map\CustomerTitleI18nTableMap;

/**
 * PartnerContactLoop
 *
 * Class PartnerContactLoop
 */
class PartnerContactLoop extends BaseI18nLoop implements PropelSearchLoopInterface {

    /**
     *
     * @return ArgumentCollection
     */
    protected function getArgDefinitions() {
        return new ArgumentCollection();
    }

    public function parseResults(LoopResult $loopResult) {
        $log = Tlog::getInstance();
        $log->err("listingresults " . $loopResult->getCount());
        /** @var \RevenueDashboard\Model\PartnerContactLoop $listing */
        foreach ($loopResult->getResultDataCollection() as $listing) {
            $loopResultRow = new LoopResultRow($listing);
            $loopResultRow->set("id", $listing->getId())
                    ->set("title", $listing->getTitle())
                    ->set("titleName", $listing->getVirtualColumn("longName"))
                    ->set("firstname", $listing->getFirstname())
                    ->set("lastname", $listing->getLastname())
                    ->set("telefon", $listing->getTelefon())
                    ->set("email", $listing->getEmail())
                    ->set("profile_website", $listing->getProfileWebsite())
                    ->set("position", $listing->getPosition())
                    ->set("department", $listing->getDepartment())
                    ->set("comment", $listing->getComment());

            $loopResult->addRow($loopResultRow);
        }

        return $loopResult;
    }

    public function buildModelCriteria() {

        $query = WholesalePartnerContactPersonQuery::create()
                ->addJoin(WholesalePartnerContactPersonTableMap::TITLE, CustomerTitleI18nTableMap::ID, Criteria::INNER_JOIN)
                ->withColumn(CustomerTitleI18nTableMap::LONG, 'longName' )
                ->where(CustomerTitleI18nTableMap::LOCALE . " = 'en_US'" );

        if ($this->getCurrentRequest()->get("id")) {
            $query = $query->where(WholesalePartnerContactPersonTableMap::ID . " = " . $this->getCurrentRequest()->get("id"));
        }
        else {
            $query = $query->where(1);
        }
        
        
//                    $this->configureI18nProcessing($query, ['TITLE', 'CHAPO', 'DESCRIPTION', 'POSTSCRIPTUM','FAQ','FAQ_COL2', 'META_TITLE', 'META_DESCRIPTION', 'META_KEYWORDS']);

            
//        echo '<pre>';
//        var_dump($this->locale);
//        die;

        
        return $query;
    }

}
