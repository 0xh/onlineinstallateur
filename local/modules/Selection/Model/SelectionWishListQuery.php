<?php

namespace Selection\Model;

use Selection\Model\Base\SelectionWishListQuery as BaseSelectionWishListQuery;

/**
 * Skeleton subclass for performing query and update operations on the 'selection_wish_list' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class SelectionWishListQuery extends BaseSelectionWishListQuery
{

    public static function getExistingObject($customerId, $selectionId)
    {
        return self::create()
          ->filterByCustomerId($customerId)
          ->filterBySelectionId($selectionId)
          ->findOne();
    }

}

// SelectionWishListQuery
