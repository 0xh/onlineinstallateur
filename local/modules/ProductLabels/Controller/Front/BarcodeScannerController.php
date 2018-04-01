<?php
namespace ProductLabels\Controller\Front;

use Thelia\Controller\Front\BaseFrontController;

/**
 * Class BarcodeScannerController
 * @package ProductLabels\Controller\Front
 * @author emanuel plopu <emanuel.plopu@sepa.at>
 */
class BarcodeScannerController extends BaseFrontController{
    
    
    public function scanBarcode(){
        return $this->render('barcodescanner');
    }
}
