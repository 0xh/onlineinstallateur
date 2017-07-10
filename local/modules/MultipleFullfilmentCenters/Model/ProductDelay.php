<?php

namespace MultipleFullfilmentCenters\Model;

use MultipleFullfilmentCenters\MultipleFullfilmentCenters;
use MultipleFullfilmentCenters\Model\Base\ProductDelay as BaseProductDelay;

class ProductDelay extends BaseProductDelay
{

    public function getDefaultValue()
    {
    	$this->setDeliveryDelayMin(MultipleFullfilmentCenters::getConfigValue("delivery_min", 1))
        ->setDeliveryDelayMax(MultipleFullfilmentCenters::getConfigValue("delivery_max", 1))
            ->setRestockDelayMin(MultipleFullfilmentCenters::getConfigValue("restock_min", 1))
            ->setRestockDelayMax(MultipleFullfilmentCenters::getConfigValue("restock_max", 1))
            ->setDeliveryDateStart(null)
            ->setDeliveryType(null);
        return $this;
    }
}
