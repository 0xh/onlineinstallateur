<?php

namespace RevenueDashboard\Form;

use RevenueDashboard\RevenueDashboard;
use Symfony\Component\Validator\Constraints\NotBlank;
use Thelia\Form\BaseForm;

class PartnerProductForm extends BaseForm {

    protected function buildForm() {
        $this->formBuilder
                ->add("id", "text", [
                    'constraints' => [
                    ],
                    'label' => $this->translator->trans('id', [], RevenueDashboard::DOMAIN_NAME)
                ])
                ->add("product_id", "text", [
                    'constraints' => [
                        new NotBlank()
                    ],
                    'label' => $this->translator->trans('Product id', [], RevenueDashboard::DOMAIN_NAME)
                ])
                ->add("partner_id", "text", [
                    'constraints' => [
                        new NotBlank()
                    ],
                    'label' => $this->translator->trans('Partner id', [], RevenueDashboard::DOMAIN_NAME)
                ])
                ->add("price", "text", [
                    'constraints' => [
                        new NotBlank()
                    ],
                    'label' => $this->translator->trans('Price', [], RevenueDashboard::DOMAIN_NAME)
                ])
                ->add("package_size", "text", [
                    'constraints' => [
                        new NotBlank()
                    ],
                    'label' => $this->translator->trans('Package size', [], RevenueDashboard::DOMAIN_NAME)
                ])
                ->add("delivery_cost", "text", [
                    'constraints' => [
                        new NotBlank()
                    ],
                    'label' => $this->translator->trans('Delivery cost', [], RevenueDashboard::DOMAIN_NAME)
                ])
                ->add("discount", "text", [
                    'constraints' => [
                        new NotBlank()
                    ],
                    'label' => $this->translator->trans('Discount', [], RevenueDashboard::DOMAIN_NAME)
                ])
                ->add("discount_description", "text", [
                    'constraints' => [
                        new NotBlank()
                    ],
                    'label' => $this->translator->trans('Discount description', [], RevenueDashboard::DOMAIN_NAME)
                ])
                ->add("profile_website", "text", [
                    'constraints' => [
                        new NotBlank()
                    ],
                    'label' => $this->translator->trans('Profile website', [], RevenueDashboard::DOMAIN_NAME)
                ])
                ->add("position","text", [
                    'constraints' => [
                        new NotBlank()
                    ],
                    'label' => $this->translator->trans('Position', [], RevenueDashboard::DOMAIN_NAME)
                ])
                ->add("department", "text", [
                    'constraints' => [
                        new NotBlank()
                    ],
                    'label' => $this->translator->trans('Department', [], RevenueDashboard::DOMAIN_NAME)
                ])
                ->add("comment", "text", [
                    'constraints' => [
                        new NotBlank()
                    ],
                    'label' => $this->translator->trans('Comment', [], RevenueDashboard::DOMAIN_NAME)
                ])
                ->add("valid_until", "text", [
                    'constraints' => [
                        new NotBlank()
                    ],
                    'label' => $this->translator->trans('Valid until', [], RevenueDashboard::DOMAIN_NAME)
                ])
        ;
    }

    public function getName() {
        return "partnerproductform";
    }

}
