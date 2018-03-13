<?php

namespace StripePayment\EventListeners;

use StripePayment\Classes\StripePaymentException;
use StripePayment\Classes\StripePaymentLog;
use StripePayment\StripePayment;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Router;
use Thelia\Core\Event\Order\OrderEvent;
use Thelia\Core\Event\TheliaEvents;
use Thelia\Core\Event\TheliaFormEvent;
use Thelia\Core\HttpKernel\Exception\RedirectException;
use Thelia\Core\Template\ParserInterface;
use Thelia\Core\Translation\Translator;
use Thelia\Log\Tlog;
use Thelia\Mailer\MailerFactory;
use Thelia\Model\ConfigQuery;
use Thelia\Model\Order as OrderModel;
use Thelia\Model\OrderStatusQuery;
use Thelia\Tools\URL;
use Thelia\Model\ModuleQuery;

/**
 * Class StripePaymentEventListener
 * @package StripePayment\EventListeners
 * @author Etienne Perriere - OpenStudio <eperriere@openstudio.fr>
 */
class StripePaymentEventListener implements EventSubscriberInterface
{
    /** @var Request  */
    protected $request;

    /** @var Router  */
    protected $router;

    /** @var ParserInterface */
    protected $parser;

    /** @var MailerFactory */
    protected $mailer;

    function __construct(Request $request, Router $router, ParserInterface $parser, MailerFactory $mailer)
    {
        $this->request = $request;
        $this->router = $router;
        $this->parser = $parser;
        $this->mailer = $mailer;
    }

    public static function getSubscribedEvents()
    {
    	return array(
    			TheliaEvents::FORM_AFTER_BUILD . ".thelia_order_payment" => array("addStripeInput", 128),
    			TheliaEvents::ORDER_SET_PAYMENT_MODULE => array("getStripeTokenAndAmount", 128),
    			TheliaEvents::ORDER_PAY => array("stripePayment", 128),
    	);    	
    }

    /**
     * @return \Thelia\Mailer\MailerFactory
     */
    public function getMailer()
    {
        return $this->mailer;
    }

    /**
     * Add stripe_token & stripe_amount inputs to invoice form
     * @param TheliaFormEvent $event
     */
    public function addStripeInput(TheliaFormEvent $event)
    {
        $event->getForm()->getFormBuilder()
            ->add(
                'stripe_token',
                'text',
                ["required" => true]
            )
            ->add(
                'stripe_amount',
                'integer',
                ["required" => true]
            );
    }

    /**
     * Get token created by Stripe and order amount from the form & save them in session
     */
    public function getStripeTokenAndAmount()
    {
        // Get Stripe token
        $this->request->getSession()->set(
            'stripeToken',
            $this->request->get('thelia_order_payment')['stripe_token']
        );

        // Get order amount
        $this->request->getSession()->set(
            'stripeAmount',
            $this->request->get('thelia_order_payment')['stripe_amount']
        );
    }

    /**
     * returns the StripePayment module code
     */
    public function getStripeCode()
    {
        return "StripePayment";
    }    

    /**
     * Send data to Stripe, save token, change order status & get response
     * @param OrderEvent $event
     * @throws \Exception
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function stripePayment(OrderEvent $event)
    {
        $order = $event->getPlacedOrder();
        $stripeModule = ModuleQuery::create()->findOneByCode($this->getStripeCode());
        if ($order->getPaymentModuleId() !== $stripeModule->getId()) {
            return;
        }
        
        $logMessage = null;
        $userMessage = null;

        \Stripe\Stripe::setApiKey(StripePayment::getConfigValue('secret_key'));

        try {

            // Check order amount
            $this->checkOrderAmount($order);

            // Create the charge on Stripe's servers - this will charge the user's card
            $this->stripeCharge($order);

            // Save Stripe token into order transaction reference
            $this->saveStripeToken($order);

            // Set 'paid' status to the order
            $this->changeOrderStatus($event);

            // Send payment confirmation mail
            $this->sendConfirmationMail($order);

        } catch(\Stripe\Error\Card $e) {
            // The card has been declined
            // FIXME Translate message here
            $logMessage = sprintf(
                'Error paying order %d with Stripe. Card declined. Message: %s',
                $order->getId(),
                $e->getMessage()
            );

            $userMessage = Translator::getInstance()
                ->trans(
                    'Your card has been declined.',
                    [],
                    StripePayment::MESSAGE_DOMAIN
                );
        } catch (\Stripe\Error\RateLimit $e) {
            // Too many requests made to the API too quickly
            $logMessage = sprintf(
                'Error paying order %d with Stripe. Too many requests. Message: %s',
                $order->getId(),
                $e->getMessage()
            );

            $userMessage = Translator::getInstance()
                ->trans(
                    'Too many requests too quickly.',
                    [],
                    StripePayment::MESSAGE_DOMAIN
                );
        } catch (\Stripe\Error\InvalidRequest $e) {
            // Invalid parameters were supplied to Stripe's API
            $logMessage = sprintf(
                'Error paying order %d with Stripe. Invalid parameters. Message: %s',
                $order->getId(),
                $e->getMessage()
            );

            $userMessage = Translator::getInstance()
                ->trans(
                    'Invalid parameters were supplied to Stripe.',
                    [],
                    StripePayment::MESSAGE_DOMAIN
                );
        } catch (\Stripe\Error\Authentication $e) {
            // Authentication with Stripe's API failed
            // (maybe you changed API keys recently)
            $logMessage = sprintf(
                'Error paying order %d with Stripe. Authentication failed: API key changed? Message: %s',
                $order->getId(),
                $e->getMessage()
            );

            $userMessage = Translator::getInstance()
                ->trans(
                    'Authentication with Stripe failed. Please contact administrators.',
                    [],
                    StripePayment::MESSAGE_DOMAIN
                );
        } catch (\Stripe\Error\ApiConnection $e) {
            // Network communication with Stripe failed
            $logMessage = sprintf(
                'Error paying order %d with Stripe. Network communication failed. Message: %s',
                $order->getId(),
                $e->getMessage()
            );

            $userMessage = Translator::getInstance()
                ->trans(
                    'Network communication failed.',
                    [],
                    StripePayment::MESSAGE_DOMAIN
                );
        } catch (\Stripe\Error\Base $e) {
            // Display a very generic error to the user
            $logMessage = sprintf(
                'Error paying order %d with Stripe. Message: %s',
                $order->getId(),
                $e->getMessage()
            );

            $userMessage = Translator::getInstance()
                ->trans(
                    'An error occurred with Stripe.',
                    [],
                    StripePayment::MESSAGE_DOMAIN
                );
        } catch (StripePaymentException $e) {
            // Amount shown to the user by Stripe & order amount are not equal
            $logMessage = sprintf(
                'Error paying order %d with Stripe. Amounts are different. Message: %s',
                $order->getId(),
                $e->getMessage()
            );

            $userMessage = $e->getMessage();
        } catch (\Exception $e) {
            // Something else happened, completely unrelated to Stripe
            $logMessage = sprintf(
                'Error paying order %d with Stripe but maybe unrelated with it. Message: %s',
                $order->getId(),
                $e->getMessage()
            );

            $userMessage = Translator::getInstance()
                ->trans(
                    'An error occurred during payment.',
                    [],
                    StripePayment::MESSAGE_DOMAIN
                );
        }

        if ($logMessage !== NULL) {
            (new StripePaymentLog())->logText($logMessage);

            $this->redirectToFailurePage(
                $order->getId(),
                $userMessage
            );
        }
    }

    /**
     * Check if the amount displayed by Stripe and the order amount are the same
     * (in case once Stripe popup is displayed, the customer adds or removes a product from another tab)
     * @param OrderModel $order
     * @throws StripePaymentException
     */
    public function checkOrderAmount(OrderModel $order)
    {
        $stripeAmount = $this->request->getSession()->get('stripeAmount');
        $orderAmount = $order->getTotalAmount() * 100;
        Tlog::getInstance()->error(" stripe amounttotal stripe ".$stripeAmount." order ".$orderAmount);
        if (strval($stripeAmount) != strval($orderAmount)) {
            throw new StripePaymentException(Translator::getInstance()
                ->trans(
                    'The payment mean does not have the same amount as your cart. Please reload and try again.',
                    [],
                    StripePayment::MESSAGE_DOMAIN
                )
            );
        }
    }

    /**
     * Send data to Stripe API & get response
     * @param OrderModel $order
     * @return \Stripe\Charge
     */
    public function stripeCharge(OrderModel $order)
    {
        $stripeApiCustomer = \Stripe\Customer::create(
            [
                'email' => $order->getCustomer()->getEmail(),
                'card' =>  $this->request->getSession()->get('stripeToken')
            ]
        );

        $logResult = \Stripe\Charge::create(
            [
                'customer' => $stripeApiCustomer,
                'amount' => $order->getTotalAmount() * 100,
                'currency' => $order->getCurrency()->getCode()
            ]
        );

        try{
            $data = $logResult->jsonSerialize();

            $log_message = '';
            isset($data["id"])? $log_message .= ' Charge ID: '.$data["id"] : $log_message .= '';
            isset($data["balance_transaction"])? $log_message .= ' / Balance Transaction: '.$data["balance_transaction"] : $log_message .= '';
            isset($data["customer"])? $log_message .= ' / Stripe Customer: '.$data["customer"] : $log_message .= '';
            isset($data["outcome"]["seller_message"])? $log_message .= ' / Outcome- Seler message: '.$data["outcome"]["seller_message"] : $log_message .= '';
            isset($data["source"])? $log_message .= ' / Card Info: _Card_ID_'.$data["source"]["id"].' /Card_Brand:'.$data["source"]["brand"].' /User Name:'.$data["source"]["name"] : $log_message .= '';
            isset($data["status"])? $log_message .= ' / Status: '.$data["status"] : $log_message .= '';
            $logger = new StripePaymentLog();
            $logger->logTextInfo( $log_message );
        }
        catch (Exception $e){
            //Can't log the outcome
        }

    }

    /**
     * Save Stripe token as transaction reference
     * @param OrderModel $order
     */
    public function saveStripeToken(OrderModel $order)
    {
        $order
            ->setTransactionRef($this->request->getSession()->get('stripeToken'))
            ->save();
    }

    /**
     * Set paid status to the order
     * @param OrderEvent $orderEvent
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function changeOrderStatus(OrderEvent $orderEvent)
    {
        $paidStatusId = OrderStatusQuery::create()
            ->filterByCode('paid')
            ->select('ID')
            ->findOne();

        $event = new OrderEvent($orderEvent->getPlacedOrder());
        $event->setStatus($paidStatusId);
        $orderEvent->getDispatcher()->dispatch(TheliaEvents::ORDER_UPDATE_STATUS, $event);
    }

    /**
     * Send payment confirmation mail
     * @param OrderModel $order
     * @throws \Exception
     */
    public function sendConfirmationMail(OrderModel $order)
    {
        $storeName = ConfigQuery::read('store_name', false);
        $storeSite = ConfigQuery::read('url_site', false);
        $contactEmail = ConfigQuery::read('store_email', false);

        Tlog::getInstance()->info("Sending Stripe payment confirmation email from store contact e-mail $contactEmail");

        if ($contactEmail) {

            $this->getMailer()->sendEmailToCustomer(
                StripePayment::CONFIRMATION_MESSAGE_NAME,
                $order->getCustomer(),
                [
                    "order_ref" => $order->getRef(),
                    "store_name" => $storeName,
                    "store_url" => $storeSite
                ]
            );
        }
    }

    /**
     * Redirect with failure message
     * @param $orderId
     * @param $message
     */
    public function redirectToFailurePage($orderId, $message)
    {
        throw new RedirectException(
            URL::getInstance()->absoluteUrl(
                $this->router->generate(
                    'order.failed',
                    [
                        'order_id' => $orderId,
                        'message' => $message
                    ],
                    Router::ABSOLUTE_PATH
                )
            )
        );
    }
}
