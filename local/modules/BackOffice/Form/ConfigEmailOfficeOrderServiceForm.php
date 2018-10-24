<?php

namespace BackOffice\Form;

use Thelia\Core\Translation\Translator;
use Thelia\Form\AttributeAvCreationForm;

class ConfigEmailOfficeOrderServiceForm extends AttributeAvCreationForm
{

    protected function buildForm()
    {
        $this->formBuilder->add(
         'office_email_order_service', 'email', [
         'constraints' => [],
         'required'    => true,
         'label'       => Translator::getInstance()->trans('Office email address order service'),
         'label_attr'  => [
          'for'  => 'summary_field',
          'help' => Translator::getInstance()->trans('This is the office email address, the order services will be sent here.'),
         ],
         'attr'        => [
          'rows'        => 3,
          'placeholder' => Translator::getInstance()->trans('email for order service'),
         ]
         ]
        );
    }

    public function getName()
    {
        return "email_office_order_service_form";
    }

}
