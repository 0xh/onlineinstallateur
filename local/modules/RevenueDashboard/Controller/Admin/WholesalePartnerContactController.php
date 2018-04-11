<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace RevenueDashboard\Controller\Admin;

use Exception;
use RevenueDashboard\RevenueDashboard;
use Thelia\Controller\Admin\BaseAdminController;
use Thelia\Core\Security\AccessManager;
use Thelia\Core\Security\Resource\AdminResources;
use Thelia\Core\Thelia;
use Thelia\Form\Exception\FormValidationException;
use Thelia\Tools\URL;
use Thelia\Tools\Version\Version;

/**
 * Description of WholesalePartnerContactController
 *
 * @author Catana Florin
 */
class WholesalePartnerContactController extends BaseAdminController {

    public function viewPartnerContact() {
        return $this->render("partner-contact");
    }

    public function viewPartnerContactId() {
        return $this->render("partner-contact");
    }

    public function blockJs() {
        return $this->render("js");
    }

    public function deletePartnerContact() {

        try {
            $partnerContact = $this->createForm("revenue.partner.contact.form");
            $form = $this->validateForm($partnerContact, "POST");
            $data = $form->getData();

            $this->actionDeletePartnerContact($data["id"]);

            return $this->render("partner-contact");
        } catch (FormValidationException $ex) {
            $error_msg = $this->createStandardFormValidationErrorMessage($ex);
        } catch (Exception $ex) {
            $error_msg = $ex->getMessage();
        }
        $this->setupFormErrorContext($this->getTranslator()
                        ->trans("Configuration", [], RevenueDashboard::DOMAIN_NAME), $error_msg, $partnerContact, $ex);
        return $this->render("partner-contact");
    }

    public function editPartnerContact() {

        try {
            $partner = $this->createForm("revenue.partner.contact.form");
            $form = $this->validateForm($partner, "POST");
            $data = $form->getData();

            if ($this->getRequest()->get("save_mode") == "edit-partner-contact") {
                $this->actionEditPartnerContact($data);
                return $this->generateRedirect(URL::getInstance()->absoluteUrl("/admin/module/revenue-wholesale-partner-contact"));
            }

            return $this->render("edit-partner-contact", $data);
        } catch (FormValidationException $ex) {
            $error_msg = $this->createStandardFormValidationErrorMessage($ex);
        } catch (Exception $ex) {
            $error_msg = $ex->getMessage();
        }
        $this->setupFormErrorContext($this->getTranslator()
                        ->trans("Configuration", [], RevenueDashboard::DOMAIN_NAME), $error_msg, $partner, $ex);
        
        return $this->render("edit-partner-contact");
    }

    public function addPartnerContact() {
        if (null !== $response = $this->checkAuth(AdminResources::MODULE, 'RevenueDashboard', AccessManager::UPDATE)) {
            return $response;
        }

        $formMarketplace = $this->createForm("revenue.partner.contact.form");

        try {
            $form = $this->validateForm($formMarketplace, "POST");

            $data = $form->getData();

            $this->addNewPartnerContact($data);

            $url = '/admin/module/revenue-wholesale-partner-contact';

            return $this->generateRedirect(URL::getInstance()->absoluteUrl($url));
        } catch (FormValidationException $ex) {
            $error_msg = $this->createStandardFormValidationErrorMessage($ex);
        } catch (Exception $ex) {
            $error_msg = $ex->getMessage();
        }

        $this->setupFormErrorContext($this->getTranslator()
                        ->trans("Configuration", [], RevenueDashboard::DOMAIN_NAME), $error_msg, $formMarketplace, $ex);

        // Before 2.2, the errored form is not stored in session
        if (Version::test(Thelia::THELIA_VERSION, '2.2', false, "<")) {
            return $this->render('module-configure', [
                        'module_code' => 'RevenueDashboard'
            ]);
        } else {
            return $this->generateRedirect(URL::getInstance()->absoluteUrl('/admin/module/revenue-wholesale-partner-contact'));
        }
    }

    protected function addNewPartnerContact($data) {
        $newPartnerContact = new \RevenueDashboard\Model\WholesalePartnerContactPerson();
        $newPartnerContact->setTitle($data["title"]);
        $newPartnerContact->setFirstname($data["firstname"]);
        $newPartnerContact->setLastname($data["lastname"]);
        $newPartnerContact->setTelefon($data["telefon"]);
        $newPartnerContact->setEmail($data["email"]);
        $newPartnerContact->setProfileWebsite($data["profile_website"]);
        $newPartnerContact->setPosition($data["position"]);
        $newPartnerContact->setDepartment($data["department"]);
        $newPartnerContact->setComment($data["comment"]);
        $newPartnerContact->setVersionCreatedBy($this->getSecurityContext()->getAdminUser()->getUsername());
        $newPartnerContact->save();
    }

    protected function actionDeletePartnerContact($id) {
        $partner = \RevenueDashboard\Model\WholesalePartnerContactPersonQuery::create();
        $partner = $partner->findOneById($id);

        if ($partner) {
            $partner->delete();
        }
    }

    protected function actionEditPartnerContact($data) {
        $newPartnerContact = \RevenueDashboard\Model\WholesalePartnerContactPersonQuery::create();
        $newPartnerContact = $newPartnerContact->findOneById($data["id"]);

        if ($newPartnerContact) {
            $newPartnerContact->setTitle($data["title"]);
            $newPartnerContact->setFirstname($data["firstname"]);
            $newPartnerContact->setLastname($data["lastname"]);
            $newPartnerContact->setTelefon($data["telefon"]);
            $newPartnerContact->setEmail($data["email"]);
            $newPartnerContact->setProfileWebsite($data["profile_website"]);
            $newPartnerContact->setPosition($data["position"]);
            $newPartnerContact->setDepartment($data["department"]);
            $newPartnerContact->setComment($data["comment"]);
            $newPartnerContact->setVersionCreatedBy($this->getSecurityContext()->getAdminUser()->getUsername());
            $newPartnerContact->save();
        }
    }

}
