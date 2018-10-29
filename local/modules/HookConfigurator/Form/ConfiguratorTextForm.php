<?php

namespace HookConfigurator\Form;

use Thelia\Form\BaseForm;

class ConfiguratorTextForm extends BaseForm {

    protected function buildForm() {
        $this->formBuilder->add(
                'configurator_name', 'text', self::elementFormText());
    }

    public static function elementFormText() {
        return array(
            "name" => "name_text",
            "type" => "text",
            "label" => "label",
            "required" => true,
            "attr" => array(
                "placeholder" => "",
                "answer_type" => "text"
            ),
            "label_attr" => array(
                "for" => 'name_text',
            ),
        );
    }

    public function getName() {
        return 'form_configurator_text_type';
    }

}
