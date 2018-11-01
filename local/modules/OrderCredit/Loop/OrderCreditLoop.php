<?php

namespace OrderCredit\Loop;

use OrderCredit\Model\OrderCreditQuery;
use Thelia\Core\Template\Element\BaseI18nLoop;
use Thelia\Core\Template\Element\LoopResult;
use Thelia\Core\Template\Element\LoopResultRow;
use Thelia\Core\Template\Element\PropelSearchLoopInterface;
use Thelia\Core\Template\Loop\Argument\Argument;
use Thelia\Core\Template\Loop\Argument\ArgumentCollection;

/**
 * OrderCreditLoop
 *
 * Class OrderCreditLoop
 */
class OrderCreditLoop extends BaseI18nLoop implements PropelSearchLoopInterface
{

    /**
     *
     * @return ArgumentCollection
     */
    protected function getArgDefinitions()
    {
        return new ArgumentCollection(
         Argument::createIntTypeArgument('order_id'));
    }

    public function parseResults(LoopResult $loopResult)
    {
        /** @var \RevenueDashboard\Model\OrderCreditLoop $listing */
        foreach ($loopResult->getResultDataCollection() as $listing) {
            $loopResultRow = new LoopResultRow($listing);
            $loopResultRow->set("id", $listing->getId())
             ->set("order_id", $listing->getOrderId())
             ->set("order_ref", $listing->getOrderRef())
             ->set("order_credit_id", $listing->getOrderCreditId())
             ->set("order_credit_ref", $listing->getOrderCreditRef());

            $loopResult->addRow($loopResultRow);
        }

        return $loopResult;
    }

    public function buildModelCriteria()
    {
        $query = OrderCreditQuery::create()
         ->filterByOrderId($this->getOrderId());

        return $query;
    }

}
