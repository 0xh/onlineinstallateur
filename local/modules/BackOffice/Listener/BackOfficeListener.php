<?php

namespace BackOffice\Listener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Thelia\Action\BaseAction;
use Thelia\Core\Event\Order\OrderEvent;
use Thelia\Core\Event\TheliaEvents;
use Thelia\Mailer\MailerFactory;
use Thelia\Model\ConfigQuery;

class BackOfficeListener extends BaseAction implements EventSubscriberInterface
{

    /** @var MailerFactory  */
    protected $mailer;

    public function __construct(MailerFactory $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * Send email to the customer when the orders status changes to pickup
     * 
     * @param  OrderEvent $event
     */
    public function sendEmailPickupStatusOrder(OrderEvent $event)
    {

        if ($event->getOrder()->getStatusId() == 11) {

            $order = $event->getOrder();

            $this->mailer->sendEmailToCustomer(
             'pickup_order', $order->getCustomer(), [
             'order_id'  => $order->getId(),
             'order_ref' => $order->getRef()
             ]
            );
        } else {
            return;
        }
    }

    public function sendEmailOrderService(OrderEvent $event)
    {

        if ($event->getOrder()->getStatusId() == 7) {

            $order = $event->getOrder();

            $messageParameters = array(
             'office_email_order_service' => "office_email_order_service",
             'order_id'                   => $order->getId(),
             'order_ref'                  => $order->getRef()
            );

            $this->mailer->sendEmailMessage(
             'order_service', [ConfigQuery::getStoreEmail() => ConfigQuery::getStoreName()]
             , [ConfigQuery::read('office_email_order_service') => ConfigQuery::read('office_email_order_service')]
             , $messageParameters
            );
        } else {
            return;
        }
    }

    public static function getSubscribedEvents()
    {
        return array(
         TheliaEvents::ORDER_UPDATE_STATUS => array("sendEmailPickupStatusOrder", 128),
         TheliaEvents::ORDER_UPDATE_STATUS => array("sendEmailOrderService", 128)
        );
    }

}
