<?php

namespace BackOffice\Listener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Thelia\Action\BaseAction;
use Thelia\Core\Event\Order\OrderEvent;
use Thelia\Core\Event\TheliaEvents;
use Thelia\Mailer\MailerFactory;
use Thelia\Model\ConfigQuery;

class BackOfficeListener extends BaseAction implements EventSubscriberInterface {

  //  protected $request;
	
   /** @var MailerFactory  */
    protected $mailer;

    public function __construct(MailerFactory $mailer )
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

            $messageParameters = array(
                'order_id' => $event->getOrder()->getId()
            );

            $this->mailer->sendEmailMessage(
                    'pickup_order', 
                    [ConfigQuery::getStoreEmail() => ConfigQuery::getStoreName()], 
                    [$event->getOrder()->getCustomer()->getEmail() => $event->getOrder()->getCustomer()->getFirstname() . " " . $event->getOrder()->getCustomer()->getLastname()], 
                    $messageParameters
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
