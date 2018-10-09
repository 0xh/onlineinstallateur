<?php

namespace Selection\Smarty\Plugins;

use Selection\Controller\Front\SelectionWishListController;
use Selection\Model\SelectionWishListQuery;
use Thelia\Core\HttpFoundation\Request;
use TheliaSmarty\Template\AbstractSmartyPlugin;
use TheliaSmarty\Template\SmartyPluginDescriptor;

class SelectionWishList extends AbstractSmartyPlugin
{

    protected $request = null;
    protected $userId = null;

    public function __construct(Request $request)
    {
        $this->request = $request;

        if (null !== $session = $this->request->getSession()) {
            if (null !== $session->getCustomerUser()) {
                $this->userId = $session->getCustomerUser()->getId();
            }
        }
    }

    /**
     * Check if product is in wishlist
     * @param $params
     * @return bool
     */
    public function inSelectionWishList($params)
    {
        $ret = false;

        if (isset($params['selection_id'])) {
            $wishListAssociationExist = SelectionWishListQuery::getExistingObject($this->userId, $params['selection_id']);
            $session = $this->request->getSession()->get(SelectionWishListController::SESSION_NAME);

            if (null !== $wishListAssociationExist || (!empty($session) && in_array($params['selection_id'], $session))) {
                $ret = true;
            }
        }

        return $ret;
    }

    /**
     * Check if product if realy into database wishlist
     * @param $params
     * @return bool
     */
    public function inSavedInSelectionWishList($params)
    {
        $ret = false;

        if (isset($params['selection_id'])) {

            $wishListAssociationExist = SelectionWishListQuery::getExistingObject($this->userId, $params['selection_id']);

            if (null !== $wishListAssociationExist) {
                $ret = true;
            }
        }

        return $ret;
    }

    /**
     * @return an array of SmartyPluginDescriptor
     */
    public function getPluginDescriptors()
    {
        return array(
            new SmartyPluginDescriptor("function", "in_wishlist_selection", $this, "inSelectionWishList"),
            new SmartyPluginDescriptor("function", "is_saved_in_wishlist_selection", $this, "inSavedInSelectionWishList")
        );
    }
}
