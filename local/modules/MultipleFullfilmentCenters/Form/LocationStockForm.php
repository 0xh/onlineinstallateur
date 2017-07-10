<?php


namespace MultipleFullfilmentCenters\Form;

use MultipleFullfilmentCenters\MultipleFullfilmentCenters;
use MultipleFullfilmentCenters\Model\FulfilmentCenterQuery;
use Thelia\Core\Translation\Translator;
use Thelia\Form\BaseForm;
use DeliveryDelay\DeliveryDelay;
use Thelia\Log\Tlog;

class LocationStockForm extends BaseForm
{

    protected function buildForm()
    {  
        $request = $this->getRequest();
        $productId = $request->get("product_id");
        
        $fulfilmentCenters = FulfilmentCenterQuery::create()->find();
      //  Tlog::getInstance()->error("locationstock ".$productData->__toString());  

        $this->formBuilder
	        ->add("id", "text", array(
	        		'label'=>Translator::getInstance()->trans("Id", array(), DeliveryDelay::DOMAIN_NAME),
	        		'label_attr'=>array("for"=>"id")
	        ))
            ->add("location_stock", "text", array(
            	'data'=>$productId,
                'label'=>Translator::getInstance()->trans("Fulfiment center", array(), DeliveryDelay::DOMAIN_NAME),
                'label_attr'=>array("for"=>"location_stock")
            ))
            ->add("product_stock", "text", array(
            	//'data'=>$fulfilmentCenters,
                'label'=>Translator::getInstance()->trans("Product stock", array(), DeliveryDelay::DOMAIN_NAME),
                'label_attr'=>array("for"=>"product_stock")
            ))
        ;
    }
    
    public function getName()
    {
        return "locationstockform";
    }
}
