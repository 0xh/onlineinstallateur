<?php

namespace RevenueDashboard\Form;

use RevenueDashboard\RevenueDashboard;
use Symfony\Component\Validator\Constraints\NotBlank;
use Thelia\Form\BaseForm;

class PartnerForm extends BaseForm {

    protected function buildForm() {
        $this->formBuilder
                ->add("id", "text", [
                    'constraints' => [
                    ],
                    'label' => $this->translator->trans('id', [], RevenueDashboard::DOMAIN_NAME)
                ])
                ->add("partnerName", "text", [
                    'constraints' => [
                        new NotBlank()
                    ],
                    'label' => $this->translator->trans('Name', [], RevenueDashboard::DOMAIN_NAME)
                ])
                ->add("description", "text", [
                    'constraints' => [
                        new NotBlank()
                    ],
                    'label' => $this->translator->trans('Description', [], RevenueDashboard::DOMAIN_NAME)
                ])
                ->add("comment", "text", [
                    'constraints' => [
                        new NotBlank()
                    ],
                    'label' => $this->translator->trans('Comment', [], RevenueDashboard::DOMAIN_NAME)
                ])
                ->add("priority", "text", [
                    'constraints' => [
                        new NotBlank()
                    ],
                    'label' => $this->translator->trans('Priority', [], RevenueDashboard::DOMAIN_NAME)
                ])
                ->add("address", "text", [
                    'constraints' => [
                        new NotBlank()
                    ],
                    'label' => $this->translator->trans('Address', [], RevenueDashboard::DOMAIN_NAME)
                ])
                ->add("deposit_address", "text", [
                    'constraints' => [
                        new NotBlank()
                    ],
                    'label' => $this->translator->trans('Deposit address', [], RevenueDashboard::DOMAIN_NAME)
                ])
                ->add("contact_person", "text", [
                    'constraints' => [
                        new NotBlank()
                    ],
                    'label' => $this->translator->trans('Contact person', [], RevenueDashboard::DOMAIN_NAME)
                ])
                ->add("delivery_types","text", [
                    'constraints' => [
                        new NotBlank()
                    ],
                    'label' => $this->translator->trans('Delivery type', [], RevenueDashboard::DOMAIN_NAME)
                ])
                ->add("return_policy", "text", [
                    'constraints' => [
                        new NotBlank()
                    ],
                    'label' => $this->translator->trans('Return policy', [], RevenueDashboard::DOMAIN_NAME)
                ])
        ;
    }

    public function getName() {
        return "partnerform";
    }

}
