<?php

namespace HookConfigurator\Form;

use HookConfigurator\Controller\Front\ConfiguratorController;
use Thelia\Core\Translation\Translator;
use Thelia\Form\BaseForm;

class ConfiguratorWithHookForm extends BaseForm {

    static private $arrFields = array();
    private $formLabels;

    protected function buildForm() {

        $configuratorID = $this->getRequest()->getSession()->get("getIdHook");
        $elements = ConfiguratorController::getConfiguratorElements($configuratorID);

        foreach ($elements as $field) {
            switch ($field['type']) {
                case "choice":
                    $this->buildChoiseFormElement($field);
                    break;
                case "text":
                    $this->buildTextFormElement($field);
                    break;
                case "range":
                    $this->buildRangeFormElement($field);
                    break;
                case "textarea":
                    $this->buildTextareaFormElement($field);
                    break;
                case "file":
                    $this->buildFileUploadFormElement($field);
                    break;
                default:
                    continue;
                    break;
            }
        }

        $this->buildSubmitFormElement();
    }

    public function getName() {
        return 'hookconfig_form_configure';
    }

    private function setFiledsList(array $filed) {
        self::$arrFields = $filed;
    }

    public function getFiledsList() {
        return self::$arrFields;
    }

    private function setLabel($field, $choice, $label) {
        Translator::getInstance()->trans($label);
        if ($choice == null) {
            $this->formLabels[$field] = $label;
            return $this->formLabels[$field];
        } else {
            $this->formLabels[$field . $choice] = $label;
            return $this->formLabels[$field . $choice];
        }
    }

    private function buildRangeFormElement($element) {
        $this->formBuilder->add(
                $element['name'], $element['type'], array(
            "label" => Translator::getInstance()->trans($element['label']),
            "label_attr" => array(
                "for" => $element['label_attr'],
            )
        ));
        $this->setFiledsList(array("name" => $element['name'], "type" => $element['type']));
    }

    private function buildChoiseFormElement($element) {

        $numberOfChoices = count($element["answer"]["values"]);
        $choices = array();
        for ($choiceIndex = 1; $choiceIndex <= $numberOfChoices; $choiceIndex++) {
            $choices[$choiceIndex] = $this->setLabel($element["name"], $element["answer"]["values"][$choiceIndex]["value"], $element["answer"]["values"][$choiceIndex]["text"]);
        }

        $this->formBuilder->add(
                $element['name'], $element['type'], array(
            $element['answer']['type'] => $choices,
            "multiple" => $element['multiple'],
            "label" => Translator::getInstance()->trans($element['label']),
            "label_attr" => array(
                "for" => $element['label_attr']['for'],
            ),
        ));
    }

    private function buildTextFormElement($element) {
        $this->formBuilder->add(
                $element['name'], $element['type'], array(
            "label" => Translator::getInstance()->trans($element['label']),
            "label_attr" => array(
                "for" => $element['label_attr'],
            )
        ));
        $this->setFiledsList(array("name" => $element['name'], "type" => $element['type']));
    }

    private function buildTextareaFormElement($element) {
        $this->formBuilder->add(
                $element['name'], $element['type'], array(
            "label" => Translator::getInstance()->trans($element['label']),
            "label_attr" => array(
                "for" => $element['label_attr'],
            )
        ));
        $this->setFiledsList(array("name" => $element['name'], "type" => $element['type']));
    }

    private function buildFileUploadFormElement($element) {
        $this->formBuilder->add(
                $element['name'], $element['type'], array(
            "label" => Translator::getInstance()->trans($element['label']),
            "label_attr" => array(
                "for" => $element['label_attr'],
            ),
        ));
        $this->setFiledsList(array("name" => $element['name'], "type" => $element['type']));
    }

    private function buildSubmitFormElement() {

        $contact = ConfiguratorController::getConfiguratorContact();

        if ($contact["visible_vorname"]) {
            $this->formBuilder
                    ->add("vorname", "text", ['label' => Translator::getInstance()->trans("Vorname")]);
        }

        if ($contact["visible_nachname"]) {
            $this->formBuilder
                    ->add("nachname", "text", ['label' => Translator::getInstance()->trans("Nachname")]);
        }

        if ($contact["visible_str"]) {
            $this->formBuilder
                    ->add("str", "text", ['label' => Translator::getInstance()->trans("Straße")]);
        }

        if ($contact["visible_plz"]) {
            $this->formBuilder
                    ->add("plz", "text", ['label' => Translator::getInstance()->trans("Plz")]);
        }

        if ($contact["visible_ort"]) {
            $this->formBuilder
                    ->add("ort", "text", ['label' => Translator::getInstance()->trans("Ort")]);
        }

        if ($contact["visible_telefon"]) {
            $this->formBuilder
                    ->add("telefon", "text", ['label' => Translator::getInstance()->trans("Telefon")]);
        }

        if ($contact["visible_email"]) {
            $this->formBuilder
                    ->add("email", "email", ['label' => Translator::getInstance()->trans('Email')]);
        }

        if ($contact["visible_terms"]) {
            $this->formBuilder
                    ->add("terms", "checkbox", ['label' => Translator::getInstance()->trans('Terms')]);
        }

        if ($contact["visible_send"]) {
            $this->formBuilder
                    ->add('Send', "submit", ['label' => 'Submit']);
        }
    }

}
