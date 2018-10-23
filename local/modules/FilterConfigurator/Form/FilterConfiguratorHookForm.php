<?php

namespace FilterConfigurator\Form;

use Thelia\Core\Translation\Translator;
use Thelia\Form\BaseForm;

class FilterConfiguratorHookForm extends BaseForm
{

    public function getName()
    {
        return 'filter_hookconfig_hook';
    }

    protected function buildForm()
    {
        $this->formBuilder
         ->add("filter_configurator_id", "number", ['label' => Translator::getInstance()->trans("Filter configurator ID for hook")])
         ->add("hook_code", "text", ['attr' => ['readonly' => 'readonly']])
         ->add("hook_id", "number");
    }

}
