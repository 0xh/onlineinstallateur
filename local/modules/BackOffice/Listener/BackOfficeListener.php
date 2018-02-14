<?php

namespace BackOffice\Listener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Thelia\Action\BaseAction;
use Thelia\Core\Event\Order\OrderEvent;
use Thelia\Core\Event\TheliaEvents;
use Thelia\Core\HttpFoundation\Request;
use Thelia\Mailer\MailerFactory;

class BackOfficeListener extends BaseAction implements EventSubscriberInterface {

    protected $request;

    public function __construct(Request $request) {
        $this->request = $request;
    }

    /**
     * Send email to the customer when the orders status changes to pickup
     * 
     * @param  OrderEvent $event
     */
    public function sendEmailPickupStatusOrder(OrderEvent $event) {

        if ($event->getOrder()->getStatusId() == 11) {

            $messageParameters = array(
                'order_id' => $event->getOrder()->getId()
            );

            $parser = $this->getParser($this->getTemplateHelper()->getActiveMailTemplate());
            $mailer = new MailerFactory($this->getDispatcher(), $parser);

            $mailer->sendEmailMessage(
                    'pickup_order', 
                    [ConfigQuery::getStoreEmail() => ConfigQuery::getStoreName()], 
                    [$event->getOrder()->getCustomer()->getEmail() => $event->getOrder()->getCustomer()->getFirstname() . " " . $event->getOrder()->getCustomer()->getLastname()], 
                    $messageParameters
            );
        } else {
            return;
        }
    }

    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     *  * The method name to call (priority defaults to 0)
     *  * An array composed of the method name to call and the priority
     *  * An array of arrays composed of the method names to call and respective
     *    priorities, or 0 if unset
     *
     * For instance:
     *
     *  * array('eventName' => 'methodName')
     *  * array('eventName' => array('methodName', $priority))
     *  * array('eventName' => array(array('methodName1', $priority), array('methodName2'))
     *
     * @return array The event names to listen to
     *
     * @api
     */
    public static function getSubscribedEvents() {
        return array(
            TheliaEvents::ORDER_UPDATE_STATUS => array("sendEmailPickupStatusOrder", 128),
        );
    }

}
