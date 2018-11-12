<?php

namespace CronDashboard\Form;

use CronDashboard\CronDashboard;
use Thelia\Form\BaseForm;

class CronjobProcessUpdate extends BaseForm {

    protected function buildForm() {
        $this->formBuilder;
    }

    public function getName() {
        return "cronjobprocessupdate";
    }
}