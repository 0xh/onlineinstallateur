<?php

namespace FilterConfigurator\Form;

use Symfony\Component\Validator\Constraints;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Thelia\Form\AttributeAvCreationForm;
use Thelia\Form\StandardDescriptionFieldsTrait;

class AttributeAvModificationForm extends AttributeAvCreationForm
{
    use StandardDescriptionFieldsTrait;

    protected function buildForm()
    {
        $this->formBuilder
            ->add("id", "hidden", array(
                    "constraints" => array(
                        new GreaterThan(
                            array('value' => 0)
                        ),
                    ),
            ))
        ;

        // Add standard description fields
        $this->addStandardDescFields();
    }

    public function getName()
    {
        return "thelia_attribute_av_modification";
    }
}
