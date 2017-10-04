<?php
namespace AmazonIntegration\Controller\Admin;

use Thelia\Controller\Admin\BaseAdminController;
use Thelia\Model\ModuleConfigQuery;
use Thelia\Model\ProductSaleElements;
use AmazonIntegration\AmazonIntegration;
use function Composer\Autoload\includeFile;
use Thelia\Model\ProductSaleElementsQuery;
use AmazonIntegration\Model\ProductAmazon;
use AmazonIntegration\Model\ProductAmazonQuery;

class AmazonIntegrationContoller extends BaseAdminController
{

    public function blockJs()
    {
        return $this->render("AmazonIntegrationTemplate-js");
    }

    public function viewAction()
    {
//         echo "<pre>";
        // include __DIR__.'\..\..\Classes\API\src\MarketplaceWebServiceOrders\Samples\GetServiceStatusSample.php';
        
        include __DIR__.'\..\..\Classes\API\src\MarketplaceWebServiceOrders\Samples\ListOrdersSample.php';
        
        // include __DIR__.'\..\..\Classes\API\src\MarketplaceWebServiceOrders\Samples\ListOrdersByNextTokenSample.php';
        
//         $productSaleElements = new ProductSaleElementsQuery();
//         $eanArray = array();
        
//         $prods = $productSaleElements->findByEanCode("*");
//         foreach ($prods as $value) {           
//             if ($value->getEanCode()) {                
//                 array_push($eanArray, array("eanCode" => $value->getEanCode(), "productId" => $value->getProductId(), "ref" => $value->getRef()));
//             }
//         }
        
//         ini_set('max_execution_time', 3000);
        
//         include __DIR__ . '\..\..\Classes\API\src\MarketplaceWebServiceOrders\Samples\GetMatchingProductForIdSample.php';
        
//         die("GATA");
        
//         include __DIR__.'\..\..\Classes\API\src\MarketplaceWebServiceOrders\Samples\ListOrderItemsSample.php';

        return $this->render("AmazonIntegrationTemplate", array(
            "orders" => $orders
        ));
    }

    public function serviceAction()
    {
        include __DIR__ . '\..\..\Classes\API\src\MarketplaceWebServiceOrders\Samples\GetServiceStatusSample.php';
        
        echo json_encode($orders);
        die();
    }
}
