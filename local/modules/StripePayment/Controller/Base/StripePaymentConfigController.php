<?php
/**
* This class has been generated by TheliaStudio
* For more information, see https://github.com/thelia-modules/TheliaStudio
*/

namespace StripePayment\Controller\Base;

use StripePayment\StripePayment;
use Thelia\Controller\Admin\BaseAdminController;
use Thelia\Form\Exception\FormValidationException;
use Thelia\Core\Security\Resource\AdminResources;
use Thelia\Core\Security\AccessManager;
use StripePayment\Model\Config\StripePaymentConfigValue;

/**
 * Class StripePaymentConfigController
 * @package StripePayment\Controller\Base
 * @author TheliaStudio
 */
class StripePaymentConfigController extends BaseAdminController
{
    public function defaultAction()
    {
        if (null !== $response = $this->checkAuth([AdminResources::MODULE], ["stripepayment"], AccessManager::VIEW)) {
            return $response;
        }

        return $this->render("stripepayment-configuration");
    }

    public function saveAction()
    {
        if (null !== $response = $this->checkAuth([AdminResources::MODULE], ["stripepayment"], AccessManager::UPDATE)) {
            return $response;
        }

        $baseForm = $this->createForm("stripepayment.configuration");

        $errorMessage = null;

        try {
            $form = $this->validateForm($baseForm);
            $data = $form->getData();

            StripePayment::setConfigValue(StripePaymentConfigValue::ENABLED, is_bool($data["enabled"]) ? (int) ($data["enabled"]) : $data["enabled"]);
            StripePayment::setConfigValue(StripePaymentConfigValue::SECRET_KEY, is_bool($data["secret_key"]) ? (int) ($data["secret_key"]) : $data["secret_key"]);
            StripePayment::setConfigValue(StripePaymentConfigValue::PUBLISHABLE_KEY, is_bool($data["publishable_key"]) ? (int) ($data["publishable_key"]) : $data["publishable_key"]);
        } catch (FormValidationException $ex) {
            // Invalid data entered
            $errorMessage = $this->createStandardFormValidationErrorMessage($ex);
        } catch (\Exception $ex) {
            // Any other error
            $errorMessage = $this->getTranslator()->trans('Sorry, an error occurred: %err', ['%err' => $ex->getMessage()], [], StripePayment::MESSAGE_DOMAIN);
        }

        if (null !== $errorMessage) {
            // Mark the form as with error
            $baseForm->setErrorMessage($errorMessage);

            // Send the form and the error to the parser
            $this->getParserContext()
                ->addForm($baseForm)
                ->setGeneralError($errorMessage)
            ;
        } else {
            $this->getParserContext()
                ->set("success", true)
            ;
        }

        return $this->defaultAction();
    }
}
