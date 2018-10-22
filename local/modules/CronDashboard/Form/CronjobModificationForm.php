<?php

namespace CronDashboard\Form;

use CronDashboard\CronDashboard;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Constraints\NotBlank;
use Thelia\Form\BaseForm;

class CronjobModificationForm extends BaseForm {

    protected function buildForm() {
        $this->formBuilder
            ->add("title", "text", [
                'constraints' => [
                    new NotBlank()
                ],
                'label' => $this->translator->trans('Title', [], CronDashboard::DOMAIN_NAME)
            ])               
            ->add("command", "text", [
                'constraints' => [
                    new NotBlank()
                ],
                'label' => $this->translator->trans('Cron Command', [], CronDashboard::DOMAIN_NAME)
            ])
            ->add("position", "text", [
                'label' => $this->translator->trans('Position', [], CronDashboard::DOMAIN_NAME)
            ])
        ;
    }

    public function getName() {
        return "cronjobdashbordModificationForm";
    }

}
