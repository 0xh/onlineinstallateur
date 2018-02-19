<?php

namespace Thelia\Model;

use Thelia\Model\Base\OrderStatus as BaseOrderStatus;

class OrderStatus extends BaseOrderStatus
{
    const CODE_NOT_PAID = "not_paid";
    const CODE_PAID = "paid";
    const CODE_PROCESSING = "processing";
    const CODE_SENT = "sent";
    const CODE_CANCELED = "canceled";
    const CODE_REFUNDED = "refunded";
    const CODE_SERVICE = "service";
    const CODE_COMPLETED = "completed";
    const CODE_OFFER = "offer";
    const CODE_REFUNDED_TEST = "Refunded_test";

}
