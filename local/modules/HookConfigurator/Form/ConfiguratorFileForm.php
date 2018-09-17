<?php

namespace HookConfigurator\Form;

use HookConfigurator\Controller\Front\ConfiguratorController;
use Thelia\Core\Translation\Translator;
use Thelia\Form\BaseForm;

class ConfiguratorFileForm extends BaseForm {

    protected function buildForm() {
        $this->formBuilder->add(
                'configurator_name', 'file', self::elementFormFile());
    }

    public static function elementFormFile() {
        return array(
            "name" => "photo",
            "type" => "file",
            'multiple' => true,
            "required" => false,
            "label" => "Sie können Beilage/ Pläne hinzufügen",
            "label_attr" => array("for" => "configurator_name"),
            "attr" => array("placeholder" => "(Dateigröße max. 2 MB, erlaubtes Dateiformat: PDF,DOC, JPG)", 'multiple' => 'multiple')
        );
    }

    public function getName() {
        return 'form_configurator_file_type';
    }

}
