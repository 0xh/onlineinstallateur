<?php

namespace HookConfigurator\Form;

use Thelia\Form\BaseForm;

class ConfiguratorRangeForm extends BaseForm {

    protected function buildForm() {
        $this->formBuilder->add(
                'configurator_name', 'range', self::elementFormText());
    }

    public static function elementFormText() {
        return array(
            "name" => "name_range",
            "type" => "range",
            "label" => "label",
            "required" => true,
            "attr" => array(
                'min' => 5,
                'max' => 50
            ),
            "label_attr" => array(
                "for" => 'name_range',
            ),
        );
    }

    public function getName() {
        return 'form_configurator_range_type';
    }

}
