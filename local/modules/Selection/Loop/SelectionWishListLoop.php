<?php

namespace Selection\Loop;

use Propel\Runtime\ActiveQuery\Criteria;
use Selection\Controller\Front\SelectionWishListController;
use Selection\Model\SelectionWishListQuery;
use Thelia\Core\Template\Element\ArraySearchLoopInterface;
use Thelia\Core\Template\Element\BaseLoop;
use Thelia\Core\Template\Element\LoopResult;
use Thelia\Core\Template\Element\LoopResultRow;
use Thelia\Core\Template\Loop\Argument\ArgumentCollection;

/**
 *
 * SelectionWishListLoop loop
 *
 *
 * Class SelectionWishListLoop
 * @package Selection\Loop
 */
class SelectionWishListLoop extends BaseLoop implements ArraySearchLoopInterface
{

    protected $timestampable = false;

    protected function getArgDefinitions()
    {
        return new ArgumentCollection();
    }

    /**
     * Return array of search results
     * @return array|mixed|null
     */
    public function buildArray()
    {
        $search = null;

        if ($this->securityContext->hasCustomerUser()) {
            $customer   = $this->securityContext->getCustomerUser();
            $customerId = $customer->getId();
        }

        if ($customerId != null) {
            $wishList = SelectionWishListQuery::create()->filterByCustomerId($customerId, Criteria::IN);

            $wishArray = array();
            foreach ($wishList as $data) {
                $wishArray[] = $data->getSelectionId();
            }

            if ($session = $this->request->getSession()->get(SelectionWishListController::SESSION_NAME)) {
                $search = array_unique(array_merge($wishArray, $session));
            }
        } else {
            $search = $this->request->getSession()->get(SelectionWishListController::SESSION_NAME);
        }

        return $search;
    }

    /**
     * @param LoopResult $loopResult
     *
     * @return LoopResult
     */
    public function parseResults(LoopResult $loopResult)
    {

        $selectionIds = array();
        foreach ($loopResult->getResultDataCollection() as $wishlist) {
            $selectionIds[] = $wishlist;
        }
        
        if (!empty($selectionIds)) {
            $count = count($selectionIds);
            $selectionIdsList = implode(',', $selectionIds);
            
            $loopResultRow = new LoopResultRow($wishlist);
            $loopResultRow
            ->set("SELECTION_WISHLIST_SELECTION_LIST", $selectionIds)
            ->set("SELECTION_WISHLIST_COUNT", $count)
            ;
            
            $loopResult->addRow($loopResultRow);
        }

        return $loopResult;
    }

}
