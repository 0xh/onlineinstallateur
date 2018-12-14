<?php

namespace LocalPickup\Loop;

use LocalPickup\Model\OrderLocalPickupAddress;
use Thelia\Core\Template\Element\BaseI18nLoop;
use Thelia\Core\Template\Element\LoopResult;
use Thelia\Core\Template\Element\LoopResultRow;
use Thelia\Core\Template\Element\PropelSearchLoopInterface;
use Thelia\Core\Template\Loop\Argument\ArgumentCollection;
use Thelia\Log\Tlog;
use LocalPickup\Model\OrderLocalPickupAddressQuery;
use Thelia\Core\Template\Loop\Argument\Argument;

class LocalPickupAddressLoop extends BaseI18nLoop implements PropelSearchLoopInterface
{

    public $countable     = true;
    public $timestampable = false;
    public $versionable   = false;

    protected function getArgDefinitions()
    {
        return new ArgumentCollection(
         Argument::createIntTypeArgument("order_id"), Argument::createIntTypeArgument("cart_id")
        );
    }

    public function buildModelCriteria()
    {

        $cartId      = $this->getCartId();
        $orderId     = $this->getOrderId();
        $forceReturn = $this->getForceReturn();

        Tlog::getInstance()->debug("buildModelCriteria LocalPickupAddressLoop " . $cart . $orderId);

        $query = OrderLocalPickupAddressQuery::create()
         ->addSelfSelectColumns()
         ->useLocalPickupQuery()
         ->withColumn('`local_pickup`.ADDRESS', 'address')
         ->withColumn('`local_pickup`.HINT', 'hint')
         ->endUse();


        if ($cartId != null) {
            $query->filterByLocalPickupCartId($cartId);
        }

        if ($orderId != null) {
            $query->filterByOrderId($orderId);
        }

        if ($cartId == null && $orderId == null && $forceReturn == false) {
            return null;
        }


        return $query;
    }

    /**
     * @param LoopResult $loopResult
     *
     * @return LoopResult
     */
    public function parseResults(LoopResult $loopResult)
    {
        /** @var LocalPickup\Model\OrderLocalPickupAddress $localPickupAddress */
        Tlog::getInstance()->error("PRE-FOR");
        foreach ($loopResult->getResultDataCollection() as $localPickupAddress) {
            $row = new LoopResultRow($localPickupAddress);

            $row
             ->set("ADDRESS", $localPickupAddress->getVirtualColumn('address'))
             ->set("HINT", $localPickupAddress->getVirtualColumn('hint'))
             ->set("CARTID", $localPickupAddress->getLocalPickupCartId());
            Tlog::getInstance()->error("parseResult LocalPickupAddressLoop" . $localPickupAddress->getLocalPickupCartId() . " " . $localPickupAddress);
            $loopResult->addRow($row);
        }
        Tlog::getInstance()->error("AfterFor");
        return $loopResult;
    }

}
