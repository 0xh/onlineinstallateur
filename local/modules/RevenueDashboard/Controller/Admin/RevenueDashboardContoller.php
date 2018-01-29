<?php

namespace RevenueDashboard\Controller\Admin;

use Thelia\Controller\Admin\BaseAdminController;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RevenueDashboardContoller
 *
 * @author Catana Florin
 */
class RevenueDashboardContoller extends BaseAdminController {

    public function viewAction() {
        return $this->render("revenue-dashboard");
    }

}
