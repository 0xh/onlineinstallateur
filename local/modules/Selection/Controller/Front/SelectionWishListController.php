<?php
namespace Selection\Controller\Front;

use Selection\Event\SelectionWishListEvents;
use Selection\Model\SelectionWishListQuery;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Thelia\Controller\Front\BaseFrontController;

/**
 *
 * SelectionWishList management controller
 *
 * @author 
 */

class SelectionWishListController extends BaseFrontController
{

    const SESSION_NAME = 'SelectionWishList';

    /**
     * Add a selection to wishlist
     * @param $selectionId
     */
    public function addSelection($selectionId, $json = 0)
    {
        $status = 'NOTLOGGED';
        $session = $this->getSession()->get(self::SESSION_NAME);

        if ($session == null) {
            $session = array();
        }

        // Save selection into session
        if (!in_array($selectionId, $session)) {
            $session[] = $selectionId;
        }

        // If a customer is logged in
        if ($customer = $this->getSecurityContext()->getCustomerUser()) {
            $customerId = $customer->getId();

            // Create array of selection realy in wishlist
            $wish = SelectionWishListQuery::create()->findByCustomerId($customerId);
            $wishArray = array();
            foreach ($wish as $data) {
                $wishArray[] = $data->getSelectionId();
            }

            // If customer hasn't selection in his wishlist
            if (null === SelectionWishListQuery::getExistingObject($customerId, $selectionId)) {
                $data = array('selection_id' => $selectionId, 'user_id' => $customerId);

                // Add selection to wishlist
                $event = $this->createEventInstance($data);
                $this->dispatch(SelectionWishListEvents::SELECTION_WISHLIST_ADD_SELECTION, $event);

                // Merge session & database wishlist
                $session = array_unique(array_merge($wishArray, $session));
                $status = 'ADD';
            } else {
                $status = 'DUPLICATE';
            }

        }

        $this->getSession()->set(self::SESSION_NAME, $session);

        if ($json == 1) {
            return new JsonResponse($status);
        }
        return $this->generateRedirect($this->getSession()->getReturnToUrl(), 301);

    }

    /**
     * Remove a selection from wishlist
     * @param $selectionId
     * @return Response
     */
    public function removeSelection($selectionId)
    {

        $session = $this->getSession()->get(self::SESSION_NAME);

        // If session isn't empty and selection is in session
        if (!empty($session) && in_array($selectionId, $session)) {
            // Remove selection from session
            $key = array_search($selectionId, $session);
            unset($session[$key]);

            // Set new session values
            $this->getSession()->set(self::SESSION_NAME, $session);
        }

        // If a customer is logged in
        if ($customer = $this->getSecurityContext()->getCustomerUser()) {
            $customerId = $customer->getId();

            // If customer has selection in his wishlist
            if (null !== $selectionWishList = SelectionWishListQuery::getExistingObject($customerId, $selectionId)) {

                $data = array('selection_id' => $selectionId, 'user_id' => $customerId);

                // Remove selection from wishlist
                $event = $this->createEventInstance($data);
                $event->setSelectionWishList($selectionWishList->getId());

                $this->dispatch(SelectionWishListEvents::SELECTION_WISHLIST_REMOVE_SELECTION, $event);
            }
        }

        return $this->generateRedirect($this->getSession()->getReturnToUrl(), 301);

    }

    /**
     * Clear wishlist completly
     * @return Response
     */
    public function clear()
    {
        // Clear session of wishlist
        $this->getSession()->remove(self::SESSION_NAME);

        // If customer is logged in
        if ($customer = $this->getSecurityContext()->getCustomerUser()) {
            $customerId = $customer->getId();

            // If the customer has a wishlist
            if (null !== $selectionWishList = SelectionWishListQuery::create()->findOneByCustomerId($customerId)) {
                $data = array('selection_id' => null, 'user_id' => $customerId);

                // Clear his wishlist
                $event = $this->createEventInstance($data);
                $event->setUserId($customerId);

                $this->dispatch(SelectionWishListEvents::SELECTION_WISHLIST_CLEAR, $event);
            }
        }

        return $this->generateRedirect($this->getSession()->getReturnToUrl(), 301);
    }

    /**
     * @param $data
     * @return SelectionWishListEvents
     */
    private function createEventInstance($data)
    {

        $selectionWishListEvent = new SelectionWishListEvents(
            $data['selection_id'], $data['user_id']
        );

        return $selectionWishListEvent;
    }
    
    public function displaySelections()
    {
    	return $this->render("wish-list");
    }

}
