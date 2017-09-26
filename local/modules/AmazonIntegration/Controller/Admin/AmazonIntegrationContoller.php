<?php
namespace AmazonIntegration\Controller\Admin;

use Thelia\Controller\Admin\BaseAdminController;
use function Composer\Autoload\includeFile;

class AmazonIntegrationContoller extends BaseAdminController
{

    public function viewAction()
    {
        echo "<pre>";
        include 'API\src\MarketplaceWebServiceOrders\Samples\ListOrderItemsSample.php';
        
        // include 'API\src\MarketplaceWebServiceOrders\Samples\GetOrderSample.php';
        // include 'API\src\MarketplaceWebServiceOrders\Samples\ListOrdersSample.php';
        die('GATA');
        
        return $this->render("AmazonIntegrationTemplate");
    }
}
