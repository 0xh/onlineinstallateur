<?php


namespace MultipleFullfilmentCenters\Handler;


use MultipleFullfilmentCenters\MultipleFullfilmentCenters;
use MultipleFullfilmentCenters\Model\ProductDelay;
use MultipleFullfilmentCenters\Model\ProductDelayQuery;
use MultipleFullfilmentCenters\Model\UndeliverableDateQuery;

use MultipleFullfilmentCenters\Model\FulfilmentCenter;
use MultipleFullfilmentCenters\Model\FulfilmentCenterProducts;
use MultipleFullfilmentCenters\Model\FulfilmentCenterQuery;
use MultipleFullfilmentCenters\Model\FulfilmentCenterProductsQuery;
 
use Thelia\Log\Tlog;
use Thelia\Model\Product;
use Thelia\Model\ProductQuery;
use Thelia\Model\ProductSaleElements;
use DeliveryDelay\DeliveryDelay;
use MultipleFullfilmentCenters\Model\Map\FulfilmentCenterTableMap;

class LocationStockHandler
{
	protected static $logger;
	/**
	 * @param $productId
	 * @return array
	 */
	 public function getStockLocationsForProduct($productId)
	 {
	 	
		$stock = FulfilmentCenterProductsQuery::create()
		//->useFulfilmentCenterQuery()
			//->addAsColumn("CenterName", FulfilmentCenterTableMap::NAME)
			//->withColumn('`fulfilment_center`.NAME','CenterName')
			//->withColumn(FulfilmentCenterTableMap::TABLE_NAME."name",'CenterName')
		//->endUse()
		->filterByProductId($productId)
		->find();
		
		foreach ($stock as $i => $value) {
			$stockProduct[$i]["id"] = $stock[$i]->getId();
			$stockProduct[$i]["fulfilmentCenterId"] = $stock[$i]->getFulfilmentCenterId();
			$stockProduct[$i]["productId"] = $stock[$i]->getProductId();
			$stockProduct[$i]["productStock"] = $stock[$i]->getProductStock();
			$stockProduct[$i]["incomingStock"] = $stock[$i]->getIncomingStock();
			$stockProduct[$i]["outgoingStock"] = $stock[$i]->getOutgoingStock();
		//	$stockProduct[$i]["fulfilmentCenterName"] = $stock[$i]->getVirtualColumn('CenterName');
		}
		return $stockProduct;
	}
	 
    /**
     * @param $productId
     * @return array
     */
    public function getDelayForProduct($productId)
    {
        $delay = ProductDelayQuery::create()
            ->filterByProductId($productId)
            ->findOneOrCreate();

        $defaultDelay = (new ProductDelay())->getDefaultValue();

        $product = ProductQuery::create()
            ->findOneById($productId);

        if (!$product) {
            return null;
        }

        $quantity = $this->productHasQuantity($product);

        if (true === $quantity) {
            $delayMin = $delay->getDeliveryDelayMin() ? $delay->getDeliveryDelayMin() : $defaultDelay->getDeliveryDelayMin();
            $delayMax = $delay->getDeliveryDelayMax() ? $delay->getDeliveryDelayMax() : $defaultDelay->getDeliveryDelayMax();
        } else {
            $delayMin = $delay->getRestockDelayMin() ? $delay->getRestockDelayMin() : $defaultDelay->getRestockDelayMin();
            $delayMax = $delay->getRestockDelayMax() ? $delay->getRestockDelayMax() : $defaultDelay->getRestockDelayMax();
        }

        $startDate = date("Y-m-d");
        $delivery["deliveryDateStart"] = null;

        if (null !== $delay->getDeliveryDateStart() && time() < strtotime($delay->getDeliveryDateStart())) {
            $startDate = $delivery["deliveryDateStart"] = $delay->getDeliveryDateStart();
        }

        $delivery["deliveryType"] = $delay->getDeliveryType();

        $delivery["deliveryMin"] = $this->computeDeliveryDate($startDate, $delayMin);
        $delivery["deliveryMax"] = $this->computeDeliveryDate($startDate, $delayMax);

        return $delivery;
    }

    public function computeDeliveryDate($startDate, $delay) {
        $date = $startDate;

        while ($delay > 0) {
            $date = date("Y-m-d", strtotime($date . ' +1 day'));
            //If the date is deliverable decrease the delay
            if ($this->checkIsDeliverableDate($date)) {
                $delay--;
            }
        }

        return $date;
    }

    public function checkIsDeliverableDate($date)
    {
        //If config say exclude weekend and the date is on weekend return false
    	if (MultipleFullfilmentCenters::getConfigValue("exclude_weekend") && date("N", strtotime($date)) > 5) {
            return false;
        }

        // Check if the date is manually excluded
        $undeliverableDates = UndeliverableDateQuery::create()
            ->filterByActive(true)
            ->select("date")
            ->find()
            ->toArray();

        if (in_array(date("m-d", strtotime($date)), $undeliverableDates)) {
            return false;
        }

        // Check if easter day is excluded
        if (MultipleFullfilmentCenters::getConfigValue("exclude_easter_day") && true === $this->isEasterDay($date)) {
            return false;
        }

        // Check if easter day based holidays are excluded
        if (MultipleFullfilmentCenters::getConfigValue("exclude_easter_day_based_holidays") && true === $this->isEasterBasedHoliday($date)) {
            return false;
        }

        return true;
    }

    public function isEasterDay($date)
    {
        $easterDay = date("Y-m-d", easter_date(date("Y")));
        if ($easterDay === $date) {
            return true;
        }
        return false;
    }

    public function isEasterBasedHoliday($date)
    {
        if ($date === null) {
            $date = time();
        }

        $date = strtotime($date);

        $year = date('Y', $date);

        $easterDate  = easter_date($year);
        $easterDay   = date('j', $easterDate);
        $easterMonth = date('n', $easterDate);
        $easterYear   = date('Y', $easterDate);

        $easterHolidays = [
            mktime(0, 0, 0, $easterMonth, $easterDay + 1,  $easterYear),
            mktime(0, 0, 0, $easterMonth, $easterDay + 39, $easterYear),
            mktime(0, 0, 0, $easterMonth, $easterDay + 50, $easterYear)
        ];

        if (in_array($date, $easterHolidays)) {
            return true;
        }

        return false;
    }

    public function productHasQuantity(Product $product)
    {
        /** @var ProductSaleElements $productSaleElements */
        foreach ($product->getProductSaleElementss() as $productSaleElements) {
            if ($productSaleElements->getQuantity() > 0) {
                return true;
            }
            return false;
        }
    }
}
