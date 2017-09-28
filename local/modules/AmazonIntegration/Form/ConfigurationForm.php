<?php
/*************************************************************************************/
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
namespace AmazonIntegration\Form;

use Symfony\Component\Validator\Constraints\NotBlank;
use Thelia\Form\BaseForm;
use AmazonIntegration\AmazonIntegration;

/**
 * Class ConfigureAmazonIntegration
 *
 * @package AmazonIntegration\Form
 * @author Thelia <info@thelia.net>
 */
class ConfigurationForm extends BaseForm
{

    protected function buildForm()
    {
        $this->formBuilder->add("AWS_ACCESS_KEY_ID", "text", [
            'constraints' => [
                new NotBlank()
            ],
            'label' => $this->translator->trans('AWS ACCESS KEY ID', [], AmazonIntegration::DOMAIN_NAME)
        ])
            ->add("AWS_SECRET_ACCESS_KEY", "text", [
            'constraints' => [
                new NotBlank()
            ],
            'label' => $this->translator->trans('AWS SECRET ACCESS KEY', [], AmazonIntegration::DOMAIN_NAME)
        ])
            ->add("APPLICATION_NAME", "text", [
            'constraints' => [
                new NotBlank()
            ],
            'label' => $this->translator->trans('APPLICATION NAME', [], AmazonIntegration::DOMAIN_NAME)
        ])
            ->add("APPLICATION_VERSION", "text", [
            'constraints' => [
                new NotBlank()
            ],
            'label' => $this->translator->trans('APPLICATION VERSION', [], AmazonIntegration::DOMAIN_NAME)
        ])
            ->add("MERCHANT_ID", "text", [
            'constraints' => [
                new NotBlank()
            ],
            'label' => $this->translator->trans('MERCHANT ID', [], AmazonIntegration::DOMAIN_NAME)
        ])
            ->add("MARKETPLACE_ID", "text", [
            'constraints' => [
                new NotBlank()
            ],
            'label' => $this->translator->trans('MARKETPLACE ID', [], AmazonIntegration::DOMAIN_NAME)
        ]);
    }

    /**
     *
     * @return string the name of your form. This name must be unique
     */
    public function getName()
    {
        return "configureamazonintegrationform";
    }
}
