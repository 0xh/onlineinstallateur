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

use RevenueDashboard\Model\WholesalePartnerBrandMatching;
use Thelia\Core\Event\ActionEvent;

class RevenueDashboardBrandEvent extends ActionEvent
{

    /** @var integer */
    protected $id;

    /** @var integer */
    protected $brand_intern;

    /** @var string */
    protected $brand_extern;

    /** @var integer */
    protected $partner_id;

    /** @var string */
    protected $brand_code;

    /** @var WholesalePartnerBrandMatching */
    protected $wholesalepartnerbrandmatching;

    function getBrandMatch(): WholesalePartnerBrandMatching
    {
        return $this->wholesalepartnerbrandmatching;
    }

    function setBrandMatch(WholesalePartnerBrandMatching $wholesalepartnerbrandmatching)
    {
        $this->wholesalepartnerbrandmatching = $wholesalepartnerbrandmatching;
    }

    function getId()
    {
        return $this->id;
    }

    function getBrand_intern()
    {
        return $this->brand_intern;
    }

    function getBrand_extern()
    {
        return $this->brand_extern;
    }

    function getPartner_id()
    {
        return $this->partner_id;
    }

    function getBrand_code()
    {
        return $this->brand_code;
    }

    function setId($id)
    {
        $this->id = $id;
    }

    function setBrand_intern($brand_intern)
    {
        $this->brand_intern = $brand_intern;
    }

    function setBrand_extern($brand_extern)
    {
        $this->brand_extern = $brand_extern;
    }

    function setPartner_id($partner_id)
    {
        $this->partner_id = $partner_id;
    }

    function setBrand_code($brand_code)
    {
        $this->brand_code = $brand_code;
    }

}
