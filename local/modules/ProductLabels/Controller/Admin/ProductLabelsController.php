<?php

namespace ProductLabels\Controller\Admin;

use Thelia\Controller\Admin\BaseAdminController;
use Thelia\Core\Event\TheliaEvents;
use Thelia\Core\Event\PdfEvent;
use Thelia\Log\Tlog;
use Thelia\Model\ProductQuery;
use Exception;

class ProductLabelsController extends BaseAdminController
{
    public function generateLabelsTabAction($product_id){
        
        return $this->render('product-labels',
            array("product_id" => $product_id));
    }
    
    public function generateLabelsPdf($product_id, $size) { 
        if($product_id == "") {
            return $this->errorPage("Product id is missing ");
        }
        
        $product = ProductQuery::create()->findOneById($product_id);
        if($product == null) {
            return $this->errorPage("Couldn't find product for id ".$product_id);
        }
        
        $product_variables = array("id"=>$product_id);
        $product_variables["title"] = $product->getTitle();
        $product_variables["ref"] = $product->getRef();
        $pse = $product->getProductSaleElementss () [0];
        if($pse != null) {
            $ean_code = $pse->getEanCode();
            $product_variables["ean"] = $ean_code;
            
            if($ean_code != null) {
                $barcode = new Barcode($ean_code, 4);
                $save_path = THELIA_TEMPLATE_DIR . "backOffice" . DS . "default" . DS . "assets" . DS . "img" . DS . $ean_code.".png";
                Tlog::getInstance()->error(" productlabel image location ".$save_path);
                try
                {
                $fp = fopen($save_path, 'w');
                if ( !$fp ) {
                    throw new Exception('File open failed.');
                } 
                fclose($fp);
                }
                catch ( Exception $e ) {
                };
                
                $isSaved = imagepng($barcode->image(), $save_path);
                if( $isSaved ) {
                    $barcode_file = "assets" . DS ."img". DS .$ean_code.".png";
                    $product_variables["barcode_file"] = $barcode_file;
                }
                else {
                    Tlog::getInstance()->error(" productlabel image location not saved ".$save_path);
                }
                
            }
            
            $price = $pse->getProductPrices () [0]->getPrice() * 1.2;
            $product_variables["price"] = $price;
        }
        
        $brand = $product->getBrand();
        if($brand != null) {
            $product_variables["brand"] = $brand->getTitle();
        }
        
        $labelTemplate = "large_template";
        switch($size) {
            case 'A4': {
                $labelTemplate = 'large_template';
            };break;
            case 'A5': {
                $labelTemplate = 'medium_template';
            };break;
            case 'A6': {
                $labelTemplate = 'small_template';
            };break;
        }
        
        $html = $this->render($labelTemplate,
            array("product" => $product_variables));
        
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
