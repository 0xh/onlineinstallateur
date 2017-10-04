<?php
namespace AmazonIntegration\Controller\Admin;

use Thelia\Controller\Admin\BaseAdminController;
use Thelia\Model\ModuleConfigQuery;
use AmazonIntegration\AmazonIntegration;
use function Composer\Autoload\includeFile;

class AmazonIntegrationContoller extends BaseAdminController
{
    
    public function blockJs()
    {
        return $this->render("AmazonIntegrationTemplate-js");
    }

    public function viewAction()
    {
//         echo "<pre>";
//         include __DIR__.'\..\..\Classes\API\src\MarketplaceWebServiceOrders\Samples\GetServiceStatusSample.php';
        
        include __DIR__.'\..\..\Classes\API\src\MarketplaceWebServiceOrders\Samples\ListOrdersSample.php';
     
//         var_dump($orders);
//         die;
        
//         $orders = array();
        return $this->render("AmazonIntegrationTemplate", array("orders" => $orders));
    }
    
    public function serviceAction()
    {
        include __DIR__.'\..\..\Classes\API\src\MarketplaceWebServiceOrders\Samples\GetServiceStatusSample.php';
     
        echo json_encode($orders);
        die;
    }
}
