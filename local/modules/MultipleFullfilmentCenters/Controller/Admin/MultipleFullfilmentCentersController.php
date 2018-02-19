<?php


namespace MultipleFullfilmentCenters\Controller\Admin;

use Thelia\Controller\Admin\BaseAdminController;
use Thelia\Core\Security\AccessManager;
use Thelia\Core\Security\Resource\AdminResources;

class MultipleFullfilmentCentersController extends BaseAdminController
{
    public function viewAction()
    {
        if (null !== $response = $this->checkAuth(array(AdminResources::MODULE), array('MultipleFullfilmentCenters'), AccessManager::VIEW)) {
            return $response;
        }

        return $this->render("location-stock/configuration");
    }

}
