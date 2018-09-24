<?php

namespace LocalPickup\Controller\Admin;

use Thelia\Controller\Admin\BaseAdminController;
use Thelia\Core\Security\AccessManager;
use Thelia\Core\Security\Resource\AdminResources;

class LocalPickupController extends BaseAdminController {

    public function viewAction() {
        if (null !== $response = $this->checkAuth(array(AdminResources::MODULE), array('LocalPickup'), AccessManager::VIEW)) {
            return $response;
        }
        //modified but commented for now
//        $params['local_pickup_default'] = LocalPickup::getConfigValue('local_pickup_default');
//        $params['local_pickup_reserve'] = LocalPickup::getConfigValue('local_pickup_reserve');

        return $this->render(
                        "location/configuration");
//        		$params);
    }

}
