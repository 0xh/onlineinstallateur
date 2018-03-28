<?php


namespace ProductLabels\Controller\Admin;

use Thelia\Controller\Admin\BaseAdminController;
use Thelia\Core\Event\TheliaEvents;
use OfferCreation\Model\OfferQuery;
use OfferCreation\Model\OfferProductQuery;
use OfferCreation\Model\OfferProductTaxQuery;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Thelia\Tools\URL;
use Thelia\Core\Event\PdfEvent;
use Thelia\Core\Security\AccessManager;
use Thelia\Core\Security\Resource\AdminResources;
use Thelia\Log\Tlog;
use Thelia\Model\MessageQuery;
use Thelia\Exception\TheliaProcessException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Thelia\Model\ProductQuery;

class ProductLabelsController extends BaseAdminController
{
    public function generateLabelsTabAction($product_id){
        
        $product = ProductQuery::create()->findOneById($product_id);
        $pse = $product->getProductSaleElementss () [0];
        $ean_code = $pse->getEanCode();
        $barcode = new Barcode($ean_code, 4);
        $save_path = THELIA_TEMPLATE_DIR . "backOffice" . DS . "default" . DS . "assets" . DS . "img" . DS . $ean_code.".png";
        Tlog::getInstance()->error(" barcode_ean ".$ean_code. " " . $save_path);
        $image = imagepng($barcode->image(), $save_path);
    	$price = $pse->getProductPrices () [0]->getPrice ();
    	$barcode_file = "assets/img/".$ean_code.".png";
    	$html = $this->render('product-labels',
    			array("product" =>
    					array("id"=>$product_id,
    							"title" => $product->getTitle(),
    							"price" => $price,
    							"brand" => $product->getBrand()->getTitle(),
    							"listen_price" => "999",
    							"ref" => $product->getRef(),
    					        "ean" => $ean_code,
    					        "barcode_file" => $barcode_file
    					))
    	
    					//             )
    			);

    	try {
    		$pdfEvent = new PdfEvent($html->getContent());
    		 
    		$this->dispatch(TheliaEvents::GENERATE_PDF, $pdfEvent);
    		 
    		if ($pdfEvent->hasPdf()) {
    			return $this->pdfResponse($pdfEvent->getPdf(), $product->getRef(), 200, 1);
    		}
    	} catch (\Exception $e) {
    		Tlog::getInstance()->error(
    				sprintf(
    						'error during generating invoice pdf for order id : %d with message "%s"',
    						$product_id,
    						$e->getMessage()
    						)
    				);
    	}
    	 

    }
    
    


}
