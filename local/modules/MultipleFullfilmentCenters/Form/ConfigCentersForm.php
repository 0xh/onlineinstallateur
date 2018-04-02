<?php

namespace MultipleFullfilmentCenters\Form;
use MultipleFullfilmentCenters\MultipleFullfilmentCenters;
use Thelia\Core\Translation\Translator;
use Thelia\Form\BaseForm;
use Symfony\Component\Validator\Constraints\NotBlank;

class ConfigCentersForm extends BaseForm
{
    protected function buildForm()
    {
        $this->formBuilder
	        ->add("fulfilment_center_default", "text", [
	        		'constraints' => [
	        				new NotBlank()
	        		],
	                'label'=>Translator::getInstance()->trans("Default/virtual fulfilment center id", array(), MultipleFullfilmentCenters::DOMAIN_NAME)
	        ])
	        ->add("fulfilment_center_reserve", "text", [
	        		'constraints' => [
	        				new NotBlank()
	        		],
	                'label'=>Translator::getInstance()->trans("Fulfilment center id used for reservation", array(), MultipleFullfilmentCenters::DOMAIN_NAME)
	        ]);
    }
    
    public function getName()
    {
        return "centersconfigform";
    }
}
