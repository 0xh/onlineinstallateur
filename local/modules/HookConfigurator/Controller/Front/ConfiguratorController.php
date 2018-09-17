<?php

namespace HookConfigurator\Controller\Front;

use HookConfigurator\Model\ConfiguratorElementsQuery;
use HookConfigurator\Model\ConfiguratorEmailQuery;
use HookConfigurator\Model\ConfiguratorQuery;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Serializer\Exception\Exception;
use Thelia\Controller\Front\BaseFrontController;
use Thelia\Mailer\MailerFactory;
use Thelia\Model\ConfigQuery;
use Thelia\Model\Customer;
use Thelia\Model\CustomerQuery;
use Thelia\Model\FeatureI18nQuery;
use Thelia\Model\Map\FeatureAvI18nTableMap;
use Thelia\Model\Map\FeatureAvTableMap;
use Thelia\Model\Map\FeatureI18nTableMap;
use Thelia\Model\ProductQuery;
use Thelia\Tools\URL;
use const THELIA_ROOT;

class ConfiguratorController extends BaseFrontController {

    public function viewConfigurator($configurator) {

        $config = ConfiguratorQuery::create()
                ->findOneByName($configurator);

        $this->getSession()->set("cat", $configurator);

        if ($config) {
            $configId = $config->getId();
            $image = json_decode($config->getParameters(), true);
            $image = $image['image'];

            $elements = self::getConfiguratorElements($configId);
            $this->getSession()->set("configurator", $configurator);
            $this->getSession()->set("configuratorID", $configId);

            return $this->render(
                            'form-for-routing', array("arrElements" => $elements, "background_image" => $image, "configurator" => $configurator, "contactArr" => self::getConfiguratorContact(), "fromHook" => 0)
            );
        }

        return $this->generateRedirect(URL::getInstance()->absoluteUrl("/"));
    }

    public static function getConfiguratorElements($configId) {

        $elements = ConfiguratorElementsQuery::create()
                ->setFormatter(ModelCriteria::FORMAT_ON_DEMAND)
                ->filterByVisible(1)
                ->findByConfiguratorId($configId);

        $arrElements = array();
        foreach ($elements as $value) {
            $params = json_decode($value->getParameters(), true);
            $params['type'] = $value->getType();
            if (isset($params['attr']['answer'])) {
                $params['answer'] = $params['attr']['answer'];
            }

            array_push($arrElements, $params);
        }

        return $arrElements;
    }

    public static function getConfiguratorContact() {

        $contact = ConfiguratorEmailQuery::create()
                ->setFormatter(ModelCriteria::FORMAT_ON_DEMAND)
                ->findOne();

        $contactArr = array();

        $contactArr["visible_form_contact"] = $contact->getVisibleFormContact();
        $contactArr["id_category_search"] = $contact->getIdCategorySearch();
        $contactArr["required_vorname"] = $contact->getRequiredVorname();
        $contactArr["visible_vorname"] = $contact->getVisibleVorname();
        $contactArr["required_nachname"] = $contact->getRequiredNachname();
        $contactArr["visible_nachname"] = $contact->getVisibleNachname();
        $contactArr["required_str"] = $contact->getRequiredStr();
        $contactArr["visible_str"] = $contact->getVisiblePlz();
        $contactArr["required_plz"] = $contact->getRequiredPlz();
        $contactArr["visible_plz"] = $contact->getVisiblePlz();
        $contactArr["required_ort"] = $contact->getRequiredOrt();
        $contactArr["visible_ort"] = $contact->getVisibleOrt();
        $contactArr["required_telefon"] = $contact->getRequiredTelefon();
        $contactArr["visible_telefon"] = $contact->getVisibleTelefon();
        $contactArr["required_email"] = $contact->getRequiredEmail();
        $contactArr["visible_email"] = $contact->getVisibleEmail();
        $contactArr["required_terms"] = $contact->getRequiredTerms();
        $contactArr["visible_terms"] = $contact->getVisibleTerms();
        $contactArr["required_send"] = $contact->getRequiredSend();
        $contactArr["visible_send"] = $contact->getVisibleSend();
        $contactArr["send_email"] = $contact->getSendEmail();

        return $contactArr;
    }

    public function viewActionHome() {
        return true;
    }

    public function viewAction() {
        return $this->render("formOrg", array("arrElements" => $this->getConfiguratorElements($this->getSession()->get("configuratorID"))));
    }

    public function getConfiguratorData() {

        $errorMessage = null;
        $form = $this->createForm("hookconfig.form.configure");

        try {
            $data = $this->validateForm($form)->getData();

            $new_image_path = THELIA_ROOT . "/web/configurator";
            $imagesHTML = "";

            if ($this->getRequest()->files->get("file")) {
                $images = $this->getRequest()->files->get("file");

                foreach ($images as $img) {
                    if ($img != null) {
                        $new_image_name = $img->getClientOriginalName();
                        $img->move($new_image_path, $new_image_name);
                        $imagesHTML .= '<img src="' . ConfigQuery::getConfiguredShopUrl() . '/configurator/' . $new_image_name . '">';
                    }
                }
            }

            $messageParameters['questions'] = array();
            $i = 0;
            foreach ($data as $question => $choice) {
                foreach ($this->getConfiguratorElements($this->getSession()->get("configuratorID")) as $field) {
                    if ($field['name'] == $question) {
                        if (NULL == $choice) {
                            continue;
                        }

                        switch ($field['type']) {
                            case "choice":
                                if (is_array($choice)) {
                                    foreach ($choice as $key => $value) {
                                        if ($field['answer']['values'][$value]['text'] != NULL) {
                                            $messageParameters['questions'][$i] = array(
                                                "question" => $field['label'],
                                                "answer" => $field['answer']['values'][$value]['text'],
                                                "type_of" => $field['type'],
                                            );
                                        }
                                        $i++;
                                    }
                                } else {
                                    if ($field['answer']['values'][$choice]['text'] != NULL) {
                                        $messageParameters['questions'][$i] = array(
                                            "question" => $field['label'],
                                            "answer" => $field['answer']['values'][$choice]['text'],
                                            "type_of" => $field['type'],
                                        );
                                    }
                                    $i++;
                                }
                                break;

                            case "text":
                                if ($choice != NULL) {
                                    $messageParameters['questions'][$i] = array(
                                        "question" => $field['label'],
                                        "answer" => $choice,
                                        "type_of" => $field['type']
                                    );
                                }
                                $i++;
                                break;

                            case "range":
                                if ($choice != NULL) {
                                    $messageParameters['questions'][$i] = array(
                                        "question" => $field['label'],
                                        "answer" => $choice,
                                        "type_of" => $field['type']
                                    );
                                }
                                $i++;
                                break;

                            case "textarea":
                                if ($choice != NULL) {
                                    $messageParameters['questions'][$i] = array(
                                        "question" => $field['label'],
                                        "answer" => $choice,
                                        "type_of" => $field['type']
                                    );
                                }
                                $i++;
                                break;
                            default:
                                $i++;
                                continue;
                                break;
                        }
                    }
                }
            }

            $messageParameters += array(
                'customer_last_name' => $data['nachname'],
                'customer_first_name' => $data['vorname'],
                'telefon_number' => $data['telefon'],
                'email' => $data['email'],
                'imagesHTML' => $imagesHTML
            );

            $sendEmail = self::getConfiguratorContact();
            $sendEmail = $sendEmail["send_email"];

            if ($sendEmail) {
                $this->saveCustomerData($messageParameters);
                $this->sendEmailToCustomer($messageParameters);
                $this->sendEmailToAdminOffice($messageParameters);
            }

            if ($this->isSearchResult()) {
                if ($this->getRedirectTemplateSearch()) {
                    $url = $this->getRedirectTemplateSearch() . $this->buildRedirectURL($messageParameters);
                } else {
                    $url = "/configurator/" . $this->buildRedirectURL($messageParameters);
                }
            } else {
                $url = "/configurator/" . $this->getSession()->get("configurator");
            }

            return RedirectResponse::create(URL::getInstance()->absoluteUrl($url));
        } catch (Exception $ex) {
// Any other error
            $errorMessage = ('Error  message form' . $ex->getMessage());
        }

        if (null !== $errorMessage) {
// Mark the form as with error
            $form->setErrorMessage($errorMessage);

// Send the form and the error to the parser
            $this->getParserContext()
                    ->addForm($form)
                    ->setGeneralError($errorMessage)
            ;
        }
    }

    protected function isSearchResult() {
        $query = ConfiguratorEmailQuery::create()
                ->findOne();

        return $query->getWithSearchResult();
    }

    protected function getRedirectTemplateSearch() {
        $query = ConfiguratorEmailQuery::create()
                ->findOne();

        return $query->getTemplateRedirectSearch();
    }

    public function sendEmailToCustomer($messageParameters) {

        $parser = $this->getParser($this->getTemplateHelper()->getActiveMailTemplate());
        $mailer = new MailerFactory($this->getDispatcher(), $parser);

        $mailer->sendEmailMessage(
                $this->getTemplateEmailNameCustomer(), [ConfigQuery::getStoreEmail() => ConfigQuery::getStoreName()], [$messageParameters['email'] => $messageParameters['email']], $messageParameters
        );
    }

    public function sendEmailToAdminOffice($messageParameters) {

        $parser = $this->getParser($this->getTemplateHelper()->getActiveMailTemplate());
        $mailer = new MailerFactory($this->getDispatcher(), $parser);

        $mailer->sendEmailMessage(
                $this->getTemplateEmailNameAdmin(), [ConfigQuery::getStoreEmail() => ConfigQuery::getStoreName()], [ConfigQuery::getStoreEmail() => ConfigQuery::getStoreName()], $messageParameters
        );
    }

    public function saveCustomerData($data) {
        $customer_check = CustomerQuery::create()
                ->findOneByEmail($data['email']);
        if (NULL == $customer_check) {
            $new_customer = new Customer();
            $new_customer->setTitleId(1)
                    ->setFirstname($data['customer_first_name'])
                    ->setLastname($data['customer_last_name'])
                    ->setEmail($data['email'])
                    ->save();
        }
    }

    public function buildRedirectURL($data) {
        $arrFeatures = array();
        foreach ($data['questions'] as $question_number => $context) {
            switch ($context['type_of']) {
                case "choice" :
                    $f_list = FeatureI18nQuery::create()
                            ->withColumn(FeatureI18nTableMap::ID, "f_id")
                            ->withColumn(FeatureAvTableMap::ID, "fv_id")
                            ->addJoin(FeatureI18nTableMap::ID, FeatureAvTableMap::FEATURE_ID)
                            ->addJoin(FeatureAvTableMap::ID, FeatureAvI18nTableMap::ID)
                            ->addCond('cond1', FeatureI18nTableMap::TITLE, $context['question'], Criteria::EQUAL)
                            ->addCond('cond2', FeatureAvI18nTableMap::TITLE, trim($context['answer']), Criteria::EQUAL)
                            ->where(array('cond1', 'cond2'), 'and')
                            ->find();
                    break;
                case "text" :
                    $f_list = FeatureI18nQuery::create()
                            ->withColumn(FeatureI18nTableMap::ID, "f_id")
                            ->withColumn(FeatureAvTableMap::ID, "fv_id")
                            ->withColumn('CAST(' . FeatureAvI18nTableMap::TITLE . ' AS UNSIGNED )', "fv_title")
                            ->addJoin(FeatureI18nTableMap::ID, FeatureAvTableMap::FEATURE_ID)
                            ->addJoin(FeatureAvTableMap::ID, FeatureAvI18nTableMap::ID)
                            ->addCond('cond1', FeatureI18nTableMap::TITLE, $context['question'], Criteria::EQUAL)
                            ->addCond('cond2', FeatureAvI18nTableMap::TITLE, $context['answer'], Criteria::LESS_EQUAL)
                            ->where(array('cond1', 'cond2'), 'and')
                            ->orderBy('fv_title')
                            ->find();
                    break;
                default :
                    continue;
                    break;
            }

            if ($f_list && $f_list->getData()[0]) {
                $arrFeatures[$f_list->getData()[0]->getVirtualColumn("f_id")] .= $f_list->getData()[0]->getVirtualColumn("fv_id") . "|";
            } else {
                continue;
            }
        }

        foreach ($arrFeatures as $key => $value) {
            $arrFeatures[$key] = $key . "_(" . rtrim($value, "|") . ")";
        }

        if ($this->getRedirectTemplateSearch()) {
            $url = "?criteria=true&features=" . implode(",", $arrFeatures) . "&show_pagination=1&limit=12&page=1&order=alpha";
        } else {
            $url = $this->getSession()->get("cat") . "?criteria=true&features=" . implode(",", $arrFeatures) . "&show_pagination=1&limit=12&page=1&order=alpha";
        }

        return $url;
    }

    public function requestProduct() {
        return $this->render('contactform', array("product_id" => $this->getRequest()->query->get('product_id', '3013')));
    }

    public function success() {
        $form = $this->createForm("hookconfig.form.contact");
        $data = $this->validateForm($form)->getData();
        $this->saveCustomerData($data);

        $product_id = $this->getRequest()->request->get('product_id');
        $product = ProductQuery::create()->findOneById($product_id);

        $messageParameters = array(
            'customer_last_name' => $data['nachname'],
            'customer_first_name' => $data['vorname'],
            'telefon_number' => $data['telefon'],
            'email' => $data['email'],
            'product_id' => $this->getRequest()->request->get('product_id'),
            'product_title' => $product->getTitle(),
                //   'product_image' => $product->getProductImages()->get
        );
        $this->sendOfferRequestToCustomer($messageParameters);
        $this->sendOfferRequestToAdminOffice($messageParameters);
    }

    public function sendOfferRequestToCustomer($messageParameters) {

        $parser = $this->getParser($this->getTemplateHelper()->getActiveMailTemplate());
        $mailer = new MailerFactory($this->getDispatcher(), $parser);

        $mailer->sendEmailMessage(
                'offer_customer', [ConfigQuery::getStoreEmail() => ConfigQuery::getStoreName()], [$messageParameters['email'] => $messageParameters['email']], $messageParameters
        );
    }

    public function sendOfferRequestToAdminOffice($messageParameters) {

        $parser = $this->getParser($this->getTemplateHelper()->getActiveMailTemplate());
        $mailer = new MailerFactory($this->getDispatcher(), $parser);

        $mailer->sendEmailMessage(
                'offer_office', [ConfigQuery::getStoreEmail() => ConfigQuery::getStoreName()], [ConfigQuery::getStoreEmail() => ConfigQuery::getStoreName()], $messageParameters
        );
    }

    protected function getTemplateEmailNameCustomer() {
        $tplName = ConfiguratorEmailQuery::create()
                ->findOne();

        return $tplName->getTemplateEmailNameCustomer();
    }

    protected function getTemplateEmailNameAdmin() {
        $tplName = ConfiguratorEmailQuery::create()
                ->findOne();

        return $tplName->getTemplateEmailNameAdmin();
    }

}
