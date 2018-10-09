<?php

namespace Selection\EventListener;

use Selection\Controller\Front\SelectionWishListController;
use Selection\Model\SelectionWishList;
use Selection\Model\SelectionWishListQuery;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Thelia\Core\Event\TheliaEvents;
use Thelia\Core\Security\SecurityContext;

class CustomerListener implements EventSubscriberInterface
{
    /** @var RequestStack */
    protected $requestStack;

    /** @var SecurityContext */
    protected $securityContext;

    public function __construct(RequestStack $requestStack, SecurityContext $securityContext)
    {
        $this->requestStack = $requestStack;
        $this->securityContext = $securityContext;
    }

    public function customerLogout(Event $event)
    {
        $this->requestStack->getCurrentRequest()->getSession()->set(SelectionWishListController::SESSION_NAME, []);
    }

    public function customerLogin(Event $event)
    {
        if ($this->securityContext->hasCustomerUser()) {
            $selectionIds = array_unique(
                array_merge(
                    is_array($this->requestStack->getCurrentRequest()->getSession()->get(SelectionWishListController::SESSION_NAME)) ?
                        $this->requestStack->getCurrentRequest()->getSession()->get(SelectionWishListController::SESSION_NAME) : [],
                    SelectionWishListQuery::create()->filterByCustomerId($this->securityContext->getCustomerUser()->getId())->select('selection_id')->find()->toArray()
                ), SORT_REGULAR
            );

            foreach ($selectionIds as $selectionId) {
                if (null === SelectionWishListQuery::create()
                        ->filterByCustomerId($this->securityContext->getCustomerUser()->getId())
                        ->filterBySelectionId($selectionId)
                        ->findOne()) {
                    (new SelectionWishList())
                        ->setCustomerId($this->securityContext->getCustomerUser()->getId())
                        ->setSelectionId($selectionId)
                        ->save();
                }
            }

            $this->requestStack->getCurrentRequest()->getSession()->set(SelectionWishListController::SESSION_NAME, $selectionIds);
        }
    }

    public static function getSubscribedEvents()
    {
        return array(
            TheliaEvents::CUSTOMER_LOGOUT => array("customerLogout", 128),
            TheliaEvents::CUSTOMER_LOGIN => array("customerLogin", 64)
        );
    }
}
