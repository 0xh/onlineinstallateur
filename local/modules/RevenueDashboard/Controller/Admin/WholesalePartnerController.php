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
 * Description of WholesalePartnerController
 *
 * @author Catana Florin
 */
class WholesalePartnerController extends BaseAdminController {

    public function viewPartner() {
        return $this->render("partner");
    }

    public function deletePartner() {

        try {
            $partner = $this->createForm("revenue.partner.form");
            $form = $this->validateForm($partner, "POST");
            $data = $form->getData();

            $this->actionDeletePartner($data["id"]);

            return $this->render("partner");
        } catch (FormValidationException $ex) {
            $error_msg = $this->createStandardFormValidationErrorMessage($ex);
        } catch (Exception $ex) {
            $error_msg = $ex->getMessage();
        }
        $this->setupFormErrorContext($this->getTranslator()
                        ->trans("Configuration", [], RevenueDashboard::DOMAIN_NAME), $error_msg, $partner, $ex);
        return $this->render("partner");
    }

    public function editPartner() {

        try {
            $partner = $this->createForm("revenue.partner.form");
            $form = $this->validateForm($partner, "POST");
            $data = $form->getData();

            if ($this->getRequest()->get("save_mode") == "edit-partner") {
                $this->actionEditPartner($data);
                return $this->generateRedirect(URL::getInstance()->absoluteUrl("/admin/module/revenue-wholesale-partner"));
            }

            return $this->render("edit-partner", $data);
        } catch (FormValidationException $ex) {
            $error_msg = $this->createStandardFormValidationErrorMessage($ex);
        } catch (Exception $ex) {
            $error_msg = $ex->getMessage();
        }
        $this->setupFormErrorContext($this->getTranslator()
                        ->trans("Configuration", [], RevenueDashboard::DOMAIN_NAME), $error_msg, $partner, $ex);
        return $this->render("partner");
    }

    public function addPartner() {
        if (null !== $response = $this->checkAuth(AdminResources::MODULE, 'RevenueDashboard', AccessManager::UPDATE)) {
            return $response;
        }

        $formMarketplace = $this->createForm("revenue.partner.form");

        try {
            $form = $this->validateForm($formMarketplace, "POST");

            $data = $form->getData();
            $this->addNewPartner($data);
            $url = '/admin/module/revenue-wholesale-partner';
            
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
            return $this->generateRedirect(URL::getInstance()->absoluteUrl('/admin/module/revenue-wholesale-partner'));
        }
    }

    protected function addNewPartner($data) {
        $newPartner = new \RevenueDashboard\Model\WholesalePartner();
        $newPartner->setName($data["partnerName"]);
        $newPartner->setDescription($data["description"]);
        $newPartner->setComment($data["comment"]);
        $newPartner->setPriority($data["priority"]);
        $newPartner->setAddress($data["address"]);
        $newPartner->setDepositAddress($data["deposit_address"]);
        $newPartner->setContactPerson($data["contact_person"]);
        $newPartner->setDeliveryTypes($data["delivery_types"]);
        $newPartner->setReturnPolicy($data["return_policy"]);
        $newPartner->setVersionCreatedBy($this->getSecurityContext()->getAdminUser()->getUsername());
        $newPartner->save();
    }

    protected function actionDeletePartner($id) {
        $partner = \RevenueDashboard\Model\WholesalePartnerQuery::create();
        $partner = $partner->findOneById($id);

        if ($partner) {
            $partner->delete();
        }
    }

    protected function actionEditPartner($data) {
        $partner = \RevenueDashboard\Model\WholesalePartnerQuery::create();
        $partner = $partner->findOneById($data["id"]);

        if ($partner) {
            $partner->setName($data["partnerName"]);
            $partner->setDescription($data["description"]);
            $partner->setComment($data["comment"]);
            $partner->setPriority($data["priority"]);
            $partner->setAddress($data["address"]);
            $partner->setDepositAddress($data["deposit_address"]);
            $partner->setContactPerson($data["contact_person"]);
            $partner->setDeliveryTypes($data["delivery_types"]);
            $partner->setReturnPolicy($data["return_policy"]);
            $partner->setVersionCreatedBy($this->getSecurityContext()->getAdminUser()->getUsername());
            $partner->save();
        }
    }

}
