<?php

/* * ********************************************************************************** */
/* */
/* Thelia */
/* */
/* Copyright (c) OpenStudio */
/* email : info@thelia.net */
/* web : http://www.thelia.net */
/* */
/* This program is free software; you can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 3 of the License */
/* */
/* This program is distributed in the hope that it will be useful, */
/* but WITHOUT ANY WARRANTY; without even the implied warranty of */
/* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the */
/* GNU General Public License for more details. */
/* */
/* You should have received a copy of the GNU General Public License */
/* along with this program. If not, see <http://www.gnu.org/licenses/>. */
/* */
/**
 * **********************************************************************************
 */

namespace RevenueDashboard\Form;

use RevenueDashboard\RevenueDashboard;
use Symfony\Component\Validator\Constraints\NotBlank;
use Thelia\Form\BaseForm;

/**
 * Class ConfigureRevenueDashboard
 *
 * @package RevenueDashboard\Form
 * @author Thelia <info@thelia.net>
 */
class ConfigurationForm extends BaseForm {

    protected function buildForm() {
        $modules = \RevenueDashboard\Controller\Admin\ConfigurationController::getActiveModulePayment();

        foreach ($modules as $module) {
            $this->formBuilder->add("cost_module_" . $module[0], "text", [
                        'constraints' => [
                            new NotBlank()
                        ],
                        'label' => $this->translator->trans('Cost for module ' . $module[1], [], RevenueDashboard::DOMAIN_NAME)
                    ])
                    ->add("cost_transaction_module_" . $module[0], "text", [
                        'constraints' => [
                            new NotBlank()
                        ],
                        'label' => $this->translator->trans('Cost transaction for module ' . $module[1], [], RevenueDashboard::DOMAIN_NAME)
            ]);
        }
    }

    /**
     *
     * @return string the name of your form. This name must be unique
     */
    public function getName() {
        return "configurerevenue";
    }
}
