<?php
namespace AmazonIntegration\Controller\Admin;

use Thelia\Controller\Admin\BaseAdminController;
use Thelia\Model\ModuleConfigQuery;
use AmazonIntegration\AmazonIntegration;
use function Composer\Autoload\includeFile;

class AmazonIntegrationContoller extends BaseAdminController
{

    public function viewAction()
    {
        
        include __DIR__.'\..\..\Classes\API\src\MarketplaceWebServiceOrders\Samples\ListOrdersSample.php';
        
//         echo "***********************************";
//         echo "<pre>";
//         var_dump($orders);
//         die('GATA');
        
        return $this->render("AmazonIntegrationTemplate", array("orders" => $orders));
    }
}
