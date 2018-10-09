<?php

/* * ********************************************************************************** */
/*      This file is part of the Thelia package.                                     */
/*                                                                                   */
/*      Copyright (c) OpenStudio                                                     */
/*      email : dev@thelia.net                                                       */
/*      web : http://www.thelia.net                                                  */
/*                                                                                   */
/*      For the full copyright and license information, please view the LICENSE.txt  */
/*      file that was distributed with this source code.                             */
/* * ********************************************************************************** */

namespace RevenueDashboard\Events;

use RevenueDashboard\Model\WholesalePartnerCategoryMatching;
use Thelia\Core\Event\ActionEvent;

class RevenueDashboardCategoryEvent extends ActionEvent
{

    /** @var integer */
    protected $id;

    /** @var integer */
    protected $intern_id;

    /** @var string */
    protected $intern_name;

    /** @var integer */
    protected $partner_id;

    /** @var integer */
    protected $extern_id;

    /** @var string */
    protected $extern_name;

    /** @var integer */
    protected $category_id;

    /** @var WholesalePartnerCategoryMatching */
    protected $wholesalepartnercategorymatching;

    function getId()
    {
        return $this->id;
    }

    function getIntern_id()
    {
        return $this->intern_id;
    }

    function getIntern_name()
    {
        return $this->intern_name;
    }

    function getPartner_id()
    {
        return $this->partner_id;
    }

    function getExtern_id()
    {
        return $this->extern_id;
    }

    function getExtern_name()
    {
        return $this->extern_name;
    }

    function getCategory_id()
    {
        return $this->category_id;
    }

    function getCategoryMatch()
    {
        return $this->wholesalepartnercategorymatching;
    }

    function setId($id)
    {
        $this->id = $id;
    }

    function setIntern_id($intern_id)
    {
        $this->intern_id = $intern_id;
    }

    function setIntern_name($intern_name)
    {
        $this->intern_name = $intern_name;
    }

    function setPartner_id($partner_id)
    {
        $this->partner_id = $partner_id;
    }

    function setExtern_id($extern_id)
    {
        $this->extern_id = $extern_id;
    }

    function setExtern_name($extern_name)
    {
        $this->extern_name = $extern_name;
    }

    function setCategory_id($category_id)
    {
        $this->category_id = $category_id;
    }

    function setCategoryMatch(WholesalePartnerCategoryMatching $wholesalepartnercategorymatching)
    {
        $this->wholesalepartnercategorymatching = $wholesalepartnercategorymatching;
        return $this->wholesalepartnercategorymatching = $wholesalepartnercategorymatching;
    }

}
