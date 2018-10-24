<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace HookConfigurator\Form;

use HookConfigurator\HookConfigurator;
use Symfony\Component\Validator\Constraints\NotBlank;
use Thelia\Form\BaseForm;

/**
 * Description of ConfiguratorListForm
 *
 * @author Catana Florin
 */
class ConfiguratorListForm extends BaseForm {

    protected function buildForm() {

        $this->formBuilder->add("configurator_name", "text", [
            'constraints' => [
                new NotBlank()
            ],
            'label' => $this->translator->trans('Lista name ', [], HookConfigurator::DOMAIN_NAME),
        ]);
    }

    /**
     *
     * @return string the name of your form. This name must be unique
     */
    public function getName() {
        return "configurator_list_form";
    }

}
