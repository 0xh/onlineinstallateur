<?php


namespace MultipleFullfilmentCenters\Form;
use MultipleFullfilmentCenters\MultipleFullfilmentCenters;
use Thelia\Core\Translation\Translator;
use Thelia\Form\BaseForm;

class AddLocationForm extends BaseForm
{

    protected function buildForm()
    {
        $this->formBuilder
            ->add("id", "text", array(
                'label'=>Translator::getInstance()->trans("Id", array(), MultipleFullfilmentCenters::DOMAIN_NAME),
                'label_attr'=>array("for"=>"id")
            ))
            ->add("name", "text", array(
                'label'=>Translator::getInstance()->trans("Name", array(), MultipleFullfilmentCenters::DOMAIN_NAME),
                'label_attr'=>array("for"=>"name")
            ))
            ->add("address", "text", array(
                'label'=>Translator::getInstance()->trans("Address", array(), MultipleFullfilmentCenters::DOMAIN_NAME),
                'label_attr'=>array("for"=>"address")
            ))
            ->add("gps_lat", "text", array(
            	'label'=>Translator::getInstance()->trans("Lat", array(), MultipleFullfilmentCenters::DOMAIN_NAME),
            	'label_attr'=>array("for"=>"gps_lat")
            ))
            ->add("gps_long", "text", array(
            	'label'=>Translator::getInstance()->trans("Long", array(), MultipleFullfilmentCenters::DOMAIN_NAME),
            	'label_attr'=>array("for"=>"gps_long")
            ))
            ->add("stock_limit", "text", array(
            	'label'=>Translator::getInstance()->trans("Stock", array(), MultipleFullfilmentCenters::DOMAIN_NAME),
            	'label_attr'=>array("for"=>"stock_limit")
            ));
    }
    
    public function getName()
    {
        return "addlocationform";
    }
}
