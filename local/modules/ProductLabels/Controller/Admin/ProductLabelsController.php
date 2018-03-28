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
    	
    	$barcode = new Barcode("1349875921348", 4);
    	$image = imagepng($barcode->image(), THELIA_WEB_DIR . DS . "assets" . DS . "backOffice" . DS . "default" . DS . "template-assets" . DS . "assets" . DS . "img" . DS . "barcode.png");
    	$product = ProductQuery::create()->findOneById($product_id);
    	$price = $product->getProductSaleElementss () [0]->getProductPrices () [0]->getPrice ();
    	
    	$html = $this->render('product-labels',
    			array("product" =>
    					array("id"=>$product_id,
    							"title" => $product->getTitle(),
    							"price" => $price,
    							"brand" => $product->getBrand()->getTitle(),
    							"listen_price" => "999",
    							"ref" => $product->getRef()
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
