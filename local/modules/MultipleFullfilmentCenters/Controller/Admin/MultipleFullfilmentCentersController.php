<?php


namespace MultipleFullfilmentCenters\Controller\Admin;

use MultipleFullfilmentCenters\MultipleFullfilmentCenters;
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

        $params['fulfilment_center_default'] = MultipleFullfilmentCenters::getConfigValue('fulfilment_center_default');
        $params['fulfilment_center_reserve'] = MultipleFullfilmentCenters::getConfigValue('fulfilment_center_reserve');
        
        return $this->render(
        		"location-stock/configuration",
        		$params);
    }

}
