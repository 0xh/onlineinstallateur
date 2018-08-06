<?php

namespace LocalPickup\Form;

use LocalPickup\LocalPickup;
use Thelia\Core\Translation\Translator;
use Thelia\Form\BaseForm;

class AddPickupLocationForm extends BaseForm {

    protected function buildForm() {
        $this->formBuilder
                ->add("id", "text", array(
                    'label' => Translator::getInstance()->trans("Id", array(), LocalPickup::DOMAIN_NAME),
                    'label_attr' => array("for" => "id")
                ))
                ->add("address", "text", array(
                    'label' => Translator::getInstance()->trans("Address", array(), LocalPickup::DOMAIN_NAME),
                    'label_attr' => array("for" => "address")
                ))
                ->add("gps_lat", "text", array(
                    'label' => Translator::getInstance()->trans("Lat", array(), LocalPickup::DOMAIN_NAME),
                    'label_attr' => array("for" => "gps_lat")
                ))
                ->add("gps_long", "text", array(
                    'label' => Translator::getInstance()->trans("Long", array(), LocalPickup::DOMAIN_NAME),
                    'label_attr' => array("for" => "gps_long")
                ))
                ->add("hint", "text", array(
                    'label' => Translator::getInstance()->trans("Hint", array(), LocalPickup::DOMAIN_NAME),
                    'label_attr' => array("for" => "hint")
        ));
    }

    public function getName() {
        return "addpickuplocationform";
    }

}
