<?php

namespace HookConfigurator\Form;

use HookConfigurator\Controller\Front\ConfiguratorController;
use Thelia\Core\Translation\Translator;
use Thelia\Form\BaseForm;

class ConfiguratorTextareaForm extends BaseForm {

    protected function buildForm() {
        $this->formBuilder->add(
                'configurator_name', 'textarea', self::elementFormTextarea());
    }

    public static function elementFormTextarea() {
        return array(
            "name" => "name_textarea",
            "type" => "textarea",
            "required" => false,
            "label" => "Sonstige:",
            "label_attr" => array("for" => "name_textarea"),
            "attr" => array(
                "placeholder" => ""
            ),
        );
    }

    public function getName() {
        return 'form_configurator_textarea_type';
    }

}
