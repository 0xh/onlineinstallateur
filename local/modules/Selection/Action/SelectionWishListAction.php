<?php

namespace Selection\Action;

use Propel\Runtime\Exception\PropelException;
use Selection\Event\SelectionWishListEvents;
use Selection\Model\SelectionWishList;
use Selection\Model\SelectionWishListQuery;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 *
 * WishList class where all actions are managed
 *
 * Class WishList
 * @package WishList\Action
 * @author Michaël Espeche <mespeche@openstudio.fr>
 */
class SelectionWishListAction implements EventSubscriberInterface
{

    /**
     * Add a product to wishlist
     * @param  SelectionWishListEvents                            $event
     * @throws Exception
     * @throws PropelException
     */
    public function addSelection(SelectionWishListEvents $event)
    {
        $addSelectionToWishList = new SelectionWishList();

        $addSelectionToWishList
         ->setSelectionId($event->getSelectionId())
         ->setCustomerId($event->getUserId())
         ->save();
    }

    /**
     * Remove product from wishlist
     * @param  SelectionWishListEvents                            $event
     * @throws Exception
     * @throws PropelException
     */
    public function removeSelection(SelectionWishListEvents $event)
    {
        if (null !== $wishList = SelectionWishListQuery::create()->findPk($event->getSelectionWishList())) {

            $wishList->delete();

            $event->setSelectionWishList($wishList);
        }
    }

    /**
     * Clear wishlist completly
     * @param  SelectionWishListEvents                            $event
     * @throws Exception
     * @throws PropelException
     */
    public function clear(SelectionWishListEvents $event)
    {
        if (null !== $wishList = SelectionWishListQuery::create()->findOneByCustomerId($event->getUserId())) {
            SelectionWishListQuery::create()->filterByCustomerId($event->getUserId())->delete();
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
    public static function getSubscribedEvents()
    {
        return array(
         SelectionWishListEvents::SELECTION_WISHLIST_ADD_SELECTION    => array('addSelection', 128),
         SelectionWishListEvents::SELECTION_WISHLIST_REMOVE_SELECTION => array('removeSelection', 128),
         SelectionWishListEvents::SELECTION_WISHLIST_CLEAR            => array('clear', 128)
        );
    }

}
