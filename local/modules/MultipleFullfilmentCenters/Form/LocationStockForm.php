<?php


namespace MultipleFullfilmentCenters\Form;

use MultipleFullfilmentCenters\MultipleFullfilmentCenters;
use MultipleFullfilmentCenters\Model\FulfilmentCenterQuery;
use Thelia\Core\Translation\Translator;
use Thelia\Form\BaseForm;

class LocationStockForm extends BaseForm
{

    protected function buildForm()
    {  
        $request = $this->getRequest();
        $productId = $request->get("product_id");
        
        $fulfilmentCenters = FulfilmentCenterQuery::create()->find();

        $this->formBuilder
	        ->add("id", "text", array(
	        	'label'=>Translator::getInstance()->trans("Id", array(), MultipleFullfilmentCenters::DOMAIN_NAME),
	        	'label_attr'=>array("for"=>"id")
	        ))
            ->add("location_stock", "text", array(
                'label'=>Translator::getInstance()->trans("Fulfiment center", array(), MultipleFullfilmentCenters::DOMAIN_NAME),
                'label_attr'=>array("for"=>"location_stock")
            ))
            ->add("product_stock", "text", array(
                'label'=>Translator::getInstance()->trans("Product stock", array(), MultipleFullfilmentCenters::DOMAIN_NAME),
                'label_attr'=>array("for"=>"product_stock")
            ))
            ->add("product_id", "text", array(
            	'data'=>$productId,
            	'label'=>Translator::getInstance()->trans("Product id", array(), MultipleFullfilmentCenters::DOMAIN_NAME),
            	'label_attr'=>array("for"=>"product_id")
            ));
    }
    
    public function getName()
    {
        return "locationstockform";
    }
}
