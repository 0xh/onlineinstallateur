<?php

namespace HookConfigurator\Form;

use Thelia\Core\Translation\Translator;
use Thelia\Form\BaseForm;

class ConfiguratorHook extends BaseForm {

    public function getName() {
        return 'hookconfig_hook';
    }

    protected function buildForm() {

        $this->formBuilder
                ->add("configurator_id", "number", ['label' => Translator::getInstance()->trans("Configurator ID for hook")])
                ->add("hook_code", "text", ['attr' => ['readonly' => 'readonly']])
                ->add("hook_id", "number");
    }

}
