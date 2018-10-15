<?php

namespace HookConfigurator\Controller\Admin;

use HookConfigurator\Form\ConfiguratorChoiceForm;
use HookConfigurator\Form\ConfiguratorFileForm;
use HookConfigurator\Form\ConfiguratorRangeForm;
use HookConfigurator\Form\ConfiguratorTextareaForm;
use HookConfigurator\Form\ConfiguratorTextForm;
use HookConfigurator\HookConfigurator;
use HookConfigurator\Model\Configurator;
use HookConfigurator\Model\ConfiguratorElements;
use HookConfigurator\Model\ConfiguratorElementsQuery;
use HookConfigurator\Model\ConfiguratorEmailQuery;
use HookConfigurator\Model\ConfiguratorHook;
use HookConfigurator\Model\ConfiguratorHookQuery;
use HookConfigurator\Model\ConfiguratorQuery;
use Symfony\Component\Serializer\Exception\Exception;
use Thelia\Controller\Admin\BaseAdminController;
use Thelia\Core\Security\AccessManager;
use Thelia\Core\Security\Resource\AdminResources;
use Thelia\Core\Thelia;
use Thelia\Form\Exception\FormValidationException;
use Thelia\Model\ModuleHookQuery;
use Thelia\Model\ModuleQuery;
use Thelia\Tools\URL;
use Thelia\Tools\Version\Version;

/**
 * Description of ConfigController
 *
 * @author Catana Florin
 */
class ConfigController extends BaseAdminController {

    public function addConfigurator() {

        if (null !== $response = $this->checkAuth(AdminResources::MODULE, 'HookConfigurator', AccessManager::UPDATE)) {
            return $response;
        }

        $configurator = $this->createForm("hookconfig.form.configurator.list");

        try {
            $form = $this->validateForm($configurator, "POST");
            $data = $form->getData();

            $this->addNewListConfigurator($data);

            $url = '/admin/module/HookConfigurator';
            return $this->generateRedirect(URL::getInstance()->absoluteUrl($url));
        } catch (FormValidationException $ex) {
            $error_msg = $this->createStandardFormValidationErrorMessage($ex);
        } catch (Exception $ex) {
            $error_msg = $ex->getMessage();
        }

        $this->setupFormErrorContext($this->getTranslator()
                        ->trans("Configuration", [], HookConfigurator::DOMAIN_NAME), $error_msg, $configurator, $ex);

        // Before 2.2, the errored form is not stored in session
        if (Version::test(Thelia::THELIA_VERSION, '2.2', false, "<")) {
            return $this->render('module-configure', [
                        'module_code' => 'HookConfigurator'
            ]);
        } else {
            return $this->generateRedirect(URL::getInstance()->absoluteUrl('/admin/module/HookConfigurator'));
        }
    }

    public function editHookIdConfigurator() {

        if (null !== $response = $this->checkAuth(AdminResources::MODULE, 'HookConfigurator', AccessManager::UPDATE)) {
            return $response;
        }

        $configurator = $this->createForm("hookconfig.form.configurator.hook");

        try {
            $form = $this->validateForm($configurator, "POST");
            $data = $form->getData();
            $idConfigurator = ConfiguratorQuery::create()
                    ->findOneById($data['configurator_id']);

            if ($idConfigurator) {
                $hookConfigurator = ConfiguratorHookQuery::create()
                        ->findOneById($this->getRequest()->request->get("hook_key_id"));

                $oldHookId = $hookConfigurator->getHookId();

                $hookConfigurator->setConfiguratorId($idConfigurator->getId());
                $hookConfigurator->setHookCode($data["hook_code"]);
                $hookConfigurator->setHookId($data["hook_id"]);
                $hookConfigurator->save();

                $module = ModuleQuery::create()
                        ->findOneByCode("HookConfigurator");
                $moduleId = $module->getId();
                $hookId = $data["hook_id"];

                $this->saveModuleHook($moduleId, $hookId, $oldHookId);
            }

            $url = '/admin/module/HookConfigurator';
            return $this->generateRedirect(URL::getInstance()->absoluteUrl($url));
        } catch (FormValidationException $ex) {
            $error_msg = $this->createStandardFormValidationErrorMessage($ex);
        } catch (Exception $ex) {
            $error_msg = $ex->getMessage();
        }

        $this->setupFormErrorContext($this->getTranslator()
                        ->trans("Configuration", [], HookConfigurator::DOMAIN_NAME), $error_msg, $configurator, $ex);

        // Before 2.2, the errored form is not stored in session
        if (Version::test(Thelia::THELIA_VERSION, '2.2', false, "<")) {
            return $this->render('module-configure', [
                        'module_code' => 'HookConfigurator'
            ]);
        } else {
            return $this->generateRedirect(URL::getInstance()->absoluteUrl('/admin/module/HookConfigurator'));
        }
    }

    private function addNewListConfigurator($data) {
        $newListConfigurator = new Configurator();
        $newListConfigurator->setName($data["configurator_name"]);
        $newListConfigurator->save();
    }

    protected function saveModuleHook($moduleId, $hookId, $oldHookId) {

        $query = ModuleHookQuery::create()
                ->filterByModuleId($moduleId)
                ->findOneByHookId($oldHookId);

        if ($query) {
            $query->delete();
        }

        if ($hookId) {
            $moduleHook = new \Thelia\Model\ModuleHook();
            $moduleHook->setModuleId($moduleId);
            $moduleHook->setHookId($hookId);
            $moduleHook->setClassname("front.configurator");
            $moduleHook->setMethod("displayFormSlider");
            $moduleHook->setActive(1);
            $moduleHook->setHookActive(1);
            $moduleHook->setModuleActive(1);
            $moduleHook->setPosition(1);
            $moduleHook->setTemplates("");
            $moduleHook->save();
        }
    }

    public function deleteHookIdConfigurator($id) {

        $hookConfigurator = ConfiguratorHookQuery::create()
                ->findOneById($id);

        if ($hookConfigurator) {

            $module = ModuleQuery::create()
                    ->findOneByCode("HookConfigurator");
            $moduleId = $module->getId();

            $query = ModuleHookQuery::create()
                    ->filterByModuleId($moduleId)
                    ->findOneByHookId($hookConfigurator->getHookId());

            if ($query) {
                $query->delete();
            }

            $hookConfigurator->delete();
        }

        return $this->generateRedirect(URL::getInstance()->absoluteUrl('/admin/module/HookConfigurator'));
    }

    public function addNewElementInConfigurator($id, $type) {
        $element = ConfiguratorQuery::create()
                ->findOneById($id);

        $newElement = new ConfiguratorElements();
        $newElement->setConfiguratorId($element->getId());
        $newElement->setVisible(1);
        $newElement->setType(strpos($type, "choice") ? "choice" : $type);

        $newElement->setParameters(json_encode($this->getParameters($type)));

        $newElement->save();

        return $this->generateRedirect(URL::getInstance()->absoluteUrl("/admin/module/configurator-edit-page/$id"));
    }

    public function addNewHookIdConfigurator() {
        $newHook = new ConfiguratorHook();
        $newHook->save();

        return $this->generateRedirect(URL::getInstance()->absoluteUrl("/admin/module/HookConfigurator"));
    }

    public function getParameters($type) {
        switch ($type) {
            case "simplechoice":
                return ConfiguratorChoiceForm::elementFormChoice();
                break;
            case "simplechoicemultiple":
                return ConfiguratorChoiceForm::elementFormChoice(0, TRUE);
                break;
            case "imagechoice":
                return ConfiguratorChoiceForm::elementFormChoice(1);
                break;
            case "imagechoicemultiple":
                return ConfiguratorChoiceForm::elementFormChoice(1, TRUE);
                break;
            case "text":
                return ConfiguratorTextForm::elementFormText();
                break;
            case "range":
                return ConfiguratorRangeForm::elementFormText();
                break;
            case "textarea":
                return ConfiguratorTextareaForm::elementFormTextarea();
                break;
            case "file":
                return ConfiguratorFileForm::elementFormFile();
                break;
            default:
                continue;
                break;
        }
    }

    public function editPageConfigurator($id) {

        return $this->render("page-configurator", array("configuratorId" => $id));
    }

    public function addNewAnswer($id, $idElement) {
        $element = ConfiguratorElementsQuery::create()
                ->findOneById($idElement);

        $params = json_decode($element->getParameters(), true);
        $params['name'] = $idElement;

        array_push($params['attr']['answer']['values'], array("value" => count($params['attr']['answer']['values']) + 1, "text" => "", "data_icon" => $params['attr']['answer']['values'][1]['data_icon']));

        $element->setParameters(json_encode($params));
        $element->save();

        return $this->generateRedirect(URL::getInstance()->absoluteUrl("/admin/module/configurator-edit-page/$id"));
    }

    public function saveElement() {

        $element = ConfiguratorElementsQuery::create()
                ->findOneById($this->getRequest()->request->get("elementId"));

        $params = json_decode($element->getParameters(), true);
        if ($params["type"] != "file") {
            $params['name'] = $this->getRequest()->request->get("elementId");
        }

        $answers = array();

        if (isset($params['attr']['answer'])) {
            $answers = $params['attr']['answer']['values'];
        }

        if ($params["type"] === "range") {
            $params["attr"]["min"] = $this->getRequest()->request->get("min_val");
            $params["attr"]["max"] = $this->getRequest()->request->get("max_val");
        }

        $params['attr']["data_icon"] = $this->getRequest()->request->get("data_icon");

        foreach ($answers as $key => $value) {
            $params['attr']['answer']['values'][$key]['text'] = $this->getRequest()->request->get($value["value"]);
            $image = $this->getRequest()->request->get("data_icon_" . $key);

            if (strpos($image, 'img')) {
                $image = strip_tags($image, '<img>');
                $image = explode("\"", $image);
                $image = $image[3];
                $params['attr']['image'] = 1;
            }

            if ($image) {
                $params['attr']['answer']['values'][$key]["data_icon"] = $image;
            }
        }

        $params['required'] = $this->getRequest()->request->get("required") ? true : false;
        $params['attr']['placeholder'] = $this->getRequest()->request->get("placeholder");
        $params['label'] = $this->getRequest()->request->get("question");
        $params['label_attr']['for'] = $params['name'];

        $element->setParameters(json_encode($params));
        $element->setVisible($this->getRequest()->request->get("visible") ? 1 : 0);
        $element->setQuestion($this->getRequest()->request->get("question"));
        $element->save();

        return $this->generateRedirect(URL::getInstance()->absoluteUrl("/admin/module/configurator-edit-page/" . $element->getConfiguratorId()));
    }

    public function saveConfiguratorContact() {

        $contact = ConfiguratorEmailQuery::create()
                ->findOne();

        if ($this->getRequest()->request->get("required_vorname")) {
            $contact->setRequiredVorname(1);
        } else {
            $contact->setRequiredVorname(0);
        }

        if ($this->getRequest()->request->get("visible_form_contact")) {
            $contact->setVisibleFormContact(1);
        } else {
            $contact->setVisibleFormContact(0);
        }

        if ($this->getRequest()->request->get("with_search_result")) {
            $contact->setWithSearchResult(1);
        } else {
            $contact->setWithSearchResult(0);
        }

        if ($this->getRequest()->request->get("id_category_search")) {
            $contact->setIdCategorySearch($this->getRequest()->request->get("id_category_search"));
        } else {
            $contact->setIdCategorySearch(1);
        }

        if ($this->getRequest()->request->get("visible_vorname")) {
            $contact->setVisibleVorname(1);
        } else {
            $contact->setVisibleVorname(0);
        }

        if ($this->getRequest()->request->get("required_nachname")) {
            $contact->setRequiredNachname(1);
        } else {
            $contact->setRequiredNachname(0);
        }

        if ($this->getRequest()->request->get("visible_nachname")) {
            $contact->setVisibleNachname(1);
        } else {
            $contact->setVisibleNachname(0);
        }

        if ($this->getRequest()->request->get("required_str")) {
            $contact->setRequiredStr(1);
        } else {
            $contact->setRequiredStr(0);
        }

        if ($this->getRequest()->request->get("visible_str")) {
            $contact->setVisibleStr(1);
        } else {
            $contact->setVisibleStr(0);
        }

        if ($this->getRequest()->request->get("required_plz")) {
            $contact->setRequiredPlz(1);
        } else {
            $contact->setRequiredPlz(0);
        }

        if ($this->getRequest()->request->get("visible_plz")) {
            $contact->setVisiblePlz(1);
        } else {
            $contact->setVisiblePlz(0);
        }

        if ($this->getRequest()->request->get("required_ort")) {
            $contact->setRequiredOrt(1);
        } else {
            $contact->setRequiredOrt(0);
        }

        if ($this->getRequest()->request->get("visible_ort")) {
            $contact->setVisibleOrt(1);
        } else {
            $contact->setVisibleOrt(0);
        }

        if ($this->getRequest()->request->get("required_telefon")) {
            $contact->setRequiredTelefon(1);
        } else {
            $contact->setRequiredTelefon(0);
        }

        if ($this->getRequest()->request->get("visible_telefon")) {
            $contact->setVisibleTelefon(1);
        } else {
            $contact->setVisibleTelefon(0);
        }

        if ($this->getRequest()->request->get("required_email")) {
            $contact->setRequiredEmail(1);
        } else {
            $contact->setRequiredEmail(0);
        }

        if ($this->getRequest()->request->get("visible_email")) {
            $contact->setVisibleEmail(1);
        } else {
            $contact->setVisibleEmail(0);
        }

        if ($this->getRequest()->request->get("required_terms")) {
            $contact->setRequiredTerms(1);
        } else {
            $contact->setRequiredTerms(0);
        }

        if ($this->getRequest()->request->get("visible_terms")) {
            $contact->setVisibleTerms(1);
        } else {
            $contact->setVisibleTerms(0);
        }

        if ($this->getRequest()->request->get("send_email")) {
            $contact->setSendEmail(1);
        } else {
            $contact->setSendEmail(0);
        }

        if ($this->getRequest()->request->get("template_email_name_customer")) {
            $contact->setTemplateEmailNameCustomer($this->getRequest()->request->get("template_email_name_customer"));
        } else {
            $contact->setTemplateEmailNameCustomer("");
        }

        if ($this->getRequest()->request->get("template_email_name_admin")) {
            $contact->setTemplateEmailNameAdmin($this->getRequest()->request->get("template_email_name_admin"));
        } else {
            $contact->setTemplateEmailNameAdmin("");
        }

        if ($this->getRequest()->request->get("template_redirect_search")) {
            $contact->setTemplateRedirectSearch($this->getRequest()->request->get("template_redirect_search"));
        } else {
            $contact->setTemplateRedirectSearch("");
        }

        $contact->save();

        return $this->generateRedirect(URL::getInstance()->absoluteUrl("/admin/module/HookConfigurator"));
    }

    public function deleteElement($idElement) {

        $element = ConfiguratorElementsQuery::create()
                ->findOneById($idElement);

        $configId = $element->getConfiguratorId();

        $element->delete();

        return $this->generateRedirect(URL::getInstance()->absoluteUrl("/admin/module/configurator-edit-page/" . $configId));
    }

    public function deleteAnswer($id, $idElement, $answer) {

        $element = ConfiguratorElementsQuery::create()
                ->findOneById($idElement);

        $params = json_decode($element->getParameters(), TRUE);
        unset($params['attr']['answer']['values'][$answer]);

        $answerArr = array();
        $i = 1;
        foreach ($params['attr']['answer']['values'] as $value) {
            $answerArr[$i] = array("value" => $i,
                "text" => $value["text"], "data_icon" => $value["data_icon"]);
            $i++;
        }

        $params['attr']['answer']['values'] = $answerArr;
        $element->setParameters(json_encode($params));
        $element->save();

        return $this->generateRedirect(URL::getInstance()->absoluteUrl("/admin/module/configurator-edit-page/" . $id));
    }

    public function deleteConfigurator($id) {

        $configurator = ConfiguratorQuery::create()
                ->findOneById($id);

        $configurator->delete();

        return $this->generateRedirect(URL::getInstance()->absoluteUrl("/admin/module/HookConfigurator"));
    }

    public function saveConfiguratorBackgroundImage() {

        $element = ConfiguratorQuery::create()
                ->findOneById($this->getRequest()->request->get("configurator_id"));

        $params = json_decode($element->getParameters(), TRUE);

        $image = $this->getRequest()->request->get("background_image");

        if (strpos($image, 'img')) {
            $image = strip_tags($image, '<img>');
            $image = explode("\"", $image);
            $image = $image[3];
            $params["image"] = $image;

            $element->setParameters(json_encode($params));
            $element->save();
        }

        return $this->generateRedirect(URL::getInstance()->absoluteUrl("/admin/module/HookConfigurator"));
    }

}
