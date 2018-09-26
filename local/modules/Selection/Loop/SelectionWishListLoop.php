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

        foreach ($loopResult->getResultDataCollection() as $wishlist) {

            $loopResultRow = new LoopResultRow($wishlist);

            $loopResultRow
             ->set("SELECTION_WISHLIST_SELECTION_LIST", $wishlist)
//             ->set("SELECTION_WISHLIST_COUNT", $count)
            ;

            $loopResult->addRow($loopResultRow);
        }

        return $loopResult;
    }

}
