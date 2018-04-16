<?php

namespace RevenueDashboard\Form;

use RevenueDashboard\RevenueDashboard;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Thelia\Form\BaseForm;

class PartnerContactForm extends BaseForm {

    protected function buildForm() {
        $this->formBuilder
                ->add("id", "text", [
                    'constraints' => [
                    ],
                    'label' => $this->translator->trans('id', [], RevenueDashboard::DOMAIN_NAME)
                ])
                ->add("title", "text", [
                    'constraints' => [
                        new NotBlank()
                    ],
                    'label' => $this->translator->trans('Title', [], RevenueDashboard::DOMAIN_NAME)
                ])
                ->add("firstname", "text", [
                    'constraints' => [
                        new NotBlank()
                    ],
                    'label' => $this->translator->trans('First name', [], RevenueDashboard::DOMAIN_NAME)
                ])
                ->add("lastname", "text", [
                    'constraints' => [
                        new NotBlank()
                    ],
                    'label' => $this->translator->trans('Last name', [], RevenueDashboard::DOMAIN_NAME)
                ])
                ->add("telefon", "text", [
                    'constraints' => [
                        new NotBlank()
                    ],
                    'label' => $this->translator->trans('Telefon', [], RevenueDashboard::DOMAIN_NAME)
                ])
                ->add("email", "text", [
                    'constraints' => array(
                        new NotBlank(),
                        new Email()
                        ),
                    'label' => $this->translator->trans('Email', [], RevenueDashboard::DOMAIN_NAME)
                ])
                ->add("profile_website", "text", [
                    'constraints' => [
                        new NotBlank()
                    ],
                    'label' => $this->translator->trans('Profile/Website', [], RevenueDashboard::DOMAIN_NAME)
                ])
                ->add("position", "text", [
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
        ;
    }

    public function getName() {
        return "partnercontactform";
    }

}
