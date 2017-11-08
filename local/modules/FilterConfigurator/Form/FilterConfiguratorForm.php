<?php

namespace FilterConfigurator\Form;

use Symfony\Component\Validator\Constraints;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Thelia\Form\AttributeAvCreationForm;
use Thelia\Core\Translation\Translator;
use Symfony\Component\Validator\Constraints\NotBlank;

class FilterConfiguratorForm extends AttributeAvCreationForm
{
    protected function buildForm()
    {
        	$this->formBuilder->add(
        			"id", 
        			"hidden", array(
                    "constraints" => array(
                        new GreaterThan(
                            array('value' => 0)
                        ),
                    ),
            ));

    
            $this->formBuilder->add(
            		'locale',
            		'hidden',
            		[
            				'constraints' => [ new NotBlank() ],
            				'required'    => true,
            		]
            		);
            
            
            $this->formBuilder->add(
            		'title',
            		'text',
            		[
            				'constraints' => [ new NotBlank() ],
            				'required'    => true,
            				'label'       => Translator::getInstance()->trans('Title'),
            				'label_attr'  => [
            						'for' => 'title_field',
            				],
            				'attr' => [
            						'placeholder' => Translator::getInstance()->trans('A descriptive title'),
            				]
            		]
            		);
            
            
            
            $this->formBuilder->add(
            		'chapo',
            		'textarea',
            		[
            				'constraints' => [ ],
            				'required'    => false,
            				'label'       => Translator::getInstance()->trans('Summary'),
            				'label_attr'  => [
            						'for'         => 'summary_field',
            						'help'        => Translator::getInstance()->trans('A short description, used when a summary or an introduction is required'),
            				],
            				'attr' => [
            						'rows'        => 3,
            						'placeholder' => Translator::getInstance()->trans('Short description text'),
            				]
            		]
            		);
            
            
            
            $this->formBuilder->add(
            		'description',
            		'textarea',
            		[
            				'constraints' => [ ],
            				'required'    => false,
            				'label'       => Translator::getInstance()->trans('Detailed description'),
            				'label_attr'  => [
            						'for'  => 'detailed_description_field',
            						'help' => Translator::getInstance()->trans('The detailed description.'),
            				],
            				'attr' => [
            						'rows' => 10,
            				]
            		]
            		);
    }

    public function getName()
    {
        return "filter_configurator_form";
    }
}
