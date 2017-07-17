<?php
namespace MultipleFullfilmentCenters\Handler;

use MultipleFullfilmentCenters\MultipleFullfilmentCenters;
use MultipleFullfilmentCenters\Model\FulfilmentCenterProductsQuery;
use MultipleFullfilmentCenters\Model\Map\FulfilmentCenterTableMap;
use Propel\Runtime\ActiveQuery\Criteria;

class LocationStockHandler
{
	/**
	 * @param $productId
	 * @return array
	 */
	 public function getStockLocationsForProduct($productId)
	 {  
		$stock = FulfilmentCenterProductsQuery::create()
			->addSelfSelectColumns()
			->useFulfilmentCenterQuery()
			->withColumn(FulfilmentCenterTableMap::NAME,'CenterName')
			->endUse()
			->filterByProductId($productId)
			->where('`fulfilment_center_products`.PRODUCT_STOCK ',Criteria::ISNOTNULL)
			->find();

		foreach ($stock as $i => $value) {
			$stockProduct[$i]["id"] = $value->getId();
			$stockProduct[$i]["fulfilmentCenterId"] = $value->getFulfilmentCenterId();
			$stockProduct[$i]["productId"] = $value->getProductId();
			$stockProduct[$i]["productStock"] = $value->getProductStock();
			$stockProduct[$i]["incomingStock"] = $value->getIncomingStock();
			$stockProduct[$i]["outgoingStock"] = $value->getOutgoingStock();
			$stockProduct[$i]["fulfilmentCenterName"] = $value->getVirtualColumn('CenterName');
		}
		return $stockProduct;
	}

}
