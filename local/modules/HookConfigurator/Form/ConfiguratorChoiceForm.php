<?php

namespace HookConfigurator\Form;

use HookConfigurator\Controller\Front\ConfiguratorController;
use Thelia\Core\Translation\Translator;
use Thelia\Form\BaseForm;

class ConfiguratorChoiceForm extends BaseForm {

    protected function buildForm() {
        $this->formBuilder->add(
                'configurator_name', 'choice', self::elementFormChoice());
    }

    public static function elementFormChoice($image = 0, $multiple = false) {
        return array(
            "name" => "name_choice",
            "type" => "choice",
            "required" => false,
            "multiple" => $multiple,
            "label" => Translator::getInstance()->trans('Response'),
            "label_attr" => array("for" => "configurator_name"),
            "attr" => array(
                "image" => $image,
                "placeholder" => "",
                "answer" => array(
                    "type" => "choices",
                    "values" => array(
                        1 => array("value" => 1,
                            "text" => "", "data_icon" => "&#xf108;")
                    )
                ),
                
            )
        );
    }

    public function getName() {
        return 'form_configurator_choice_type';
    }

}
