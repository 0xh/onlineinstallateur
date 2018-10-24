<?php

namespace Selection\Event;

use Thelia\Core\Event\ActionEvent;

/**
 *
 * This class contains all SelectionWishList events identifiers used by SelectionWishList Core
 *
 * @author Michaël Espeche <mespeche@openstudio.fr>
 */
class SelectionWishListEvents extends ActionEvent
{

    const SELECTION_WISHLIST_ADD_SELECTION           = 'selection.whishList.action.addSelection';
    const SELECTION_BEFORE_WISHLIST_ADD_SELECTION    = 'selection.whishList.action.beforeAddSelection';
    const SELECTION_AFTER_WISHLIST_ADD_SELECTION     = 'selection.whishList.action.afterAddSelection';
    const SELECTION_WISHLIST_REMOVE_SELECTION        = 'selection.whishList.action.removeSelection';
    const SELECTION_BEFORE_WISHLIST_REMOVE_SELECTION = 'selection.whishList.action.beforeRemoveSelection';
    const SELECTION_AFTER_WISHLIST_REMOVE_SELECTION  = 'selection.whishList.action.afterRemoveSelection';
    const SELECTION_WISHLIST_CLEAR                   = 'selection.whishList.action.clear';

    protected $userId;
    protected $selectionId;
    protected $selectionWishList;

    public function __construct($selectionId = null, $userId)
    {
        $this->selectionId = $selectionId;
        $this->userId      = $userId;
    }

    /**
     * @param mixed $selectionId
     */
    public function setSelectionId($selectionId)
    {
        $this->selectionId = $selectionId;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSelectionId()
    {
        return $this->selectionId;
    }

    /**
     * @param mixed $userId
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param mixed $selectionWishList
     */
    public function setSelectionWishList($selectionWishList)
    {
        $this->selectionWishList = $selectionWishList;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSelectionWishList()
    {
        return $this->selectionWishList;
    }

    /**
     * check if selectionWishList exists
     *
     * @return bool
     */
    public function hasSelectionWishList()
    {
        return null !== $this->selectionWishList;
    }

}
