<?php

namespace BackOffice\Listener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Thelia\Action\BaseAction;
use Thelia\Core\Event\Order\OrderEvent;
use Thelia\Core\Event\TheliaEvents;
use Thelia\Mailer\MailerFactory;

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
                'pickup_order',
                $order->getCustomer(),
                [
                    'order_id' => $order->getId()
                ]
            );
        } else { 
            return;
        }
    }

    public static function getSubscribedEvents() 
    {
        return array(
            TheliaEvents::ORDER_UPDATE_STATUS => array("sendEmailPickupStatusOrder", 128),
        );
    }

}
