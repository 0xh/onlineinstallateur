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
 * Description of WholesalePartnerProductController
 *
 * @author Catana Florin
 */
class WholesalePartnerProductController extends BaseAdminController {

    public function viewPartnerProduct() {
        return $this->render("partner-product");
    }

    public function deletePartnerProduct() {

        try {
            $partner = $this->createForm("revenue.partner.product.form");
            $form = $this->validateForm($partner, "POST");
            $data = $form->getData();

            $this->actionDeletePartnerProduct($data["id"]);

            return $this->render("partner-product");
        } catch (FormValidationException $ex) {
            $error_msg = $this->createStandardFormValidationErrorMessage($ex);
        } catch (Exception $ex) {
            $error_msg = $ex->getMessage();
        }
        $this->setupFormErrorContext($this->getTranslator()
                        ->trans("Configuration", [], RevenueDashboard::DOMAIN_NAME), $error_msg, $partner, $ex);
        return $this->render("partner-product");
    }

    public function editPartnerProduct() {

        try {
            $partner = $this->createForm("revenue.partner.product.form");
            $form = $this->validateForm($partner, "POST");
            $data = $form->getData();

            if ($this->getRequest()->get("save_mode") == "edit-partner-product") {
                $this->actionEditPartnerProduct($data);
                return $this->generateRedirect(URL::getInstance()->absoluteUrl("/admin/module/revenue-wholesale-partner-product"));
            }

            return $this->render("edit-partner-product", $data);
        } catch (FormValidationException $ex) {
            $error_msg = $this->createStandardFormValidationErrorMessage($ex);
        } catch (Exception $ex) {
            $error_msg = $ex->getMessage();
        }
        $this->setupFormErrorContext($this->getTranslator()
                        ->trans("Configuration", [], RevenueDashboard::DOMAIN_NAME), $error_msg, $partner, $ex);
        return $this->render("partner-product");
    }

    public function addPartnerProduct() {
        if (null !== $response = $this->checkAuth(AdminResources::MODULE, 'RevenueDashboard', AccessManager::UPDATE)) {
            return $response;
        }

        $formMarketplace = $this->createForm("revenue.partner.product.form");

        try {
            $form = $this->validateForm($formMarketplace, "POST");

            $data = $form->getData();

            $this->addNewPartnerProduct($data);

            $url = '/admin/module/revenue-wholesale-partner-product';

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
            return $this->generateRedirect(URL::getInstance()->absoluteUrl('/admin/module/revenue-wholesale-partner-product'));
        }
    }

    protected function addNewPartnerProduct($data) {
        $newPartnerProduct = new \RevenueDashboard\Model\WholesalePartnerProduct();
        $newPartnerProduct->setProductId($data["product_id"]);
        $newPartnerProduct->setPartnerId($data["partner_id"]);
        $newPartnerProduct->setPrice($data["price"]);
        $newPartnerProduct->setPackageSize($data["package_size"]);
        $newPartnerProduct->setDeliveryCost($data["delivery_cost"]);
        $newPartnerProduct->setDiscount($data["discount"]);
        $newPartnerProduct->setDiscountDescription($data["discount_description"]);
        $newPartnerProduct->setProfileWebsite($data["profile_website"]);
        $newPartnerProduct->setPosition($data["position"]);
        $newPartnerProduct->setDepartment($data["department"]);
        $newPartnerProduct->setComment($data["comment"]);
        $newPartnerProduct->setValidUntil($data["valid_until"]);
        $newPartnerProduct->setVersionCreatedBy($this->getSecurityContext()->getAdminUser()->getUsername());
        $newPartnerProduct->save();
    }

    protected function actionDeletePartnerProduct($id) {
        $partner = \RevenueDashboard\Model\WholesalePartnerProductQuery::create();
        $partner = $partner->findOneById($id);

        if ($partner) {
            $partner->delete();
        }
    }

    protected function actionEditPartnerProduct($data) {
        $newPartnerProduct = \RevenueDashboard\Model\WholesalePartnerProductQuery::create();
        $newPartnerProduct = $newPartnerProduct->findOneById($data["id"]);

        if ($newPartnerProduct) {
            $newPartnerProduct->setProductId($data["product_id"]);
            $newPartnerProduct->setPartnerId($data["partner_id"]);
            $newPartnerProduct->setPrice($data["price"]);
            $newPartnerProduct->setPackageSize($data["package_size"]);
            $newPartnerProduct->setDeliveryCost($data["delivery_cost"]);
            $newPartnerProduct->setDiscount($data["discount"]);
            $newPartnerProduct->setDiscountDescription($data["discount_description"]);
            $newPartnerProduct->setProfileWebsite($data["profile_website"]);
            $newPartnerProduct->setPosition($data["position"]);
            $newPartnerProduct->setDepartment($data["department"]);
            $newPartnerProduct->setComment($data["comment"]);
            $newPartnerProduct->setValidUntil($data["valid_until"]);
            $newPartnerProduct->setVersionCreatedBy($this->getSecurityContext()->getAdminUser()->getUsername());
            $newPartnerProduct->save();
        }
    }

    public function getProducts() {

        $products = \Thelia\Model\ProductQuery::create()
                ->limit(10)
                ->addJoin(\Thelia\Model\Map\ProductTableMap::ID, \Thelia\Model\Map\ProductI18nTableMap::ID)
                ->withColumn(\Thelia\Model\Map\ProductI18nTableMap::TITLE, 'productName')
                ->where(\Thelia\Model\Map\ProductI18nTableMap::LOCALE . " = 'en_US'");

        $prods = array();
        foreach ($products as $prd) {
            array_push($prods, $prd->getId() .";". $prd->getTitle());
            break;
        }
        
        print_r($prods);
//        echo '<pre>';
//        var_dump($prods);
        die;
    }

}
