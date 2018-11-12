<?php

namespace CronDashboard\Form;

use CronDashboard\CronDashboard;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Constraints\NotBlank;
use Thelia\Form\BaseForm;

class CronDashboardModuleConfigure extends BaseForm {

    protected function buildForm() {
        $this->formBuilder
            ->add("process_name", "text", [
                'constraints' => [
                ],
                'label' => $this->translator->trans('Process Name', [], CronDashboard::DOMAIN_NAME)
            ])
            ->add("server_location", "text", [
                'constraints' => [
                    new NotBlank()
                ],
                'label' => $this->translator->trans('Server Location', [], CronDashboard::DOMAIN_NAME)
            ])
        ;
    }

    public function getName() {
        return "crondashboardmoduleconfigure";
    }
}