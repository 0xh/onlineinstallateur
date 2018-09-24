<?php

namespace LocalPickup\Hook\Front;

use Thelia\Core\Event\Hook\HookRenderEvent;
use Thelia\Core\Hook\BaseHook;
use Thelia\Log\Tlog;

class LocationStockEditHookLocalPickup extends BaseHook {

    public function orderLocationAddressLocalPickup(HookRenderEvent $event) {
        $orderId = $event->getArgument("orderid");
        Tlog::getInstance()->error("Intra in metoda AdressFront " . $orderId . " 1 ");
        $event->add($this->render('product-location-address.html', array("orderId" => $orderId)));
    }

    public function orderLocationAddressBackLocalPickup(HookRenderEvent $event) {
        $orderId = $event->getArgument("orderid");
        Tlog::getInstance()->error("Intra in metoda AdressFront " . $orderId . " 1 ");
        $event->add($this->render('product-location-addressBack.html', array("orderId" => $orderId)));
    }

    public function orderLocationAddressEmailLocalPickup(HookRenderEvent $event) {
        $orderId = $event->getArgument("orderid");
        Tlog::getInstance()->error("Intra in metoda AddressEmail " . $orderId . " 1 ");
        $event->add($this->render('product-location-address-email.html', array("orderId" => $orderId)));
    }

    public function orderLocationAddressPdfLocalPickup(HookRenderEvent $event) {

        $orderId = $event->getArgument("orderid");
        Tlog::getInstance()->error("Intra in metoda AddressPDF " . $orderId . " 1 ");
        $event->add($this->render('product-location-address-pdf.html', array("orderId" => $orderId)));
    }

}
