<?php


namespace MultipleFullfilmentCenters\Form;
use MultipleFullfilmentCenters\MultipleFullfilmentCenters;
use DeliveryDelay\DeliveryDelay;
use Thelia\Core\Translation\Translator;
use Thelia\Form\BaseForm;

class AddLocationForm extends BaseForm
{

    protected function buildForm()
    {
        $this->formBuilder
            ->add("id", "text", array(
                'label'=>Translator::getInstance()->trans("Id", array(), DeliveryDelay::DOMAIN_NAME),
                'label_attr'=>array("for"=>"id")
            ))
            ->add("name", "text", array(
                'label'=>Translator::getInstance()->trans("Name", array(), DeliveryDelay::DOMAIN_NAME),
                'label_attr'=>array("for"=>"name")
            ))
            ->add("address", "text", array(
                'label'=>Translator::getInstance()->trans("Address", array(), DeliveryDelay::DOMAIN_NAME),
                'label_attr'=>array("for"=>"address")
            ))
            ->add("gps_lat", "text", array(
            		'label'=>Translator::getInstance()->trans("Lat", array(), DeliveryDelay::DOMAIN_NAME),
            		'label_attr'=>array("for"=>"gps_lat")
            ))
            ->add("gps_long", "text", array(
            		'label'=>Translator::getInstance()->trans("Long", array(), DeliveryDelay::DOMAIN_NAME),
            		'label_attr'=>array("for"=>"gps_long")
            ))
            ->add("stock_limit", "text", array(
            		'label'=>Translator::getInstance()->trans("Stock", array(), DeliveryDelay::DOMAIN_NAME),
            		'label_attr'=>array("for"=>"stock_limit")
            ))
        ;
    }
    
    public function getName()
    {
        return "addlocationform";
    }
}
