<?php

/* * ********************************************************************************** */
/*      This file is part of the Thelia package.                                     */
/*                                                                                   */
/*      Copyright (c) OpenStudio                                                     */
/*      email : dev@thelia.net                                                       */
/*      web : http://www.thelia.net                                                  */
/*                                                                                   */
/*      For the full copyright and license information, please view the LICENSE.txt  */
/*      file that was distributed with this source code.                             */
/* * ********************************************************************************** */

namespace Carousel\Controller;

use Carousel\Model\Carousel;
use Carousel\Model\CarouselName;
use Carousel\Model\CarouselNameQuery;
use Carousel\Model\CarouselQuery;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Thelia\Controller\Admin\BaseAdminController;
use Thelia\Core\Event\File\FileCreateOrUpdateEvent;
use Thelia\Core\Event\TheliaEvents;
use Thelia\Core\Security\AccessManager;
use Thelia\Core\Security\Resource\AdminResources;
use Thelia\Form\Exception\FormValidationException;
use Thelia\Log\Tlog;
use Thelia\Model\Lang;
use Thelia\Model\LangQuery;
use Thelia\Tools\URL;

/**
 * Class ConfigurationController
 * @package Carousel\Controller
 * @author manuel raynaud <mraynaud@openstudio.fr>
 */
class ConfigurationController extends BaseAdminController
{

    public function uploadImage($carouselId)
    {
        if (null !== $response = $this->checkAuth(AdminResources::MODULE, ['carousel'], AccessManager::CREATE)) {
            return $response;
        }


        $request       = $this->getRequest();
        $form          = $this->createForm('carousel.image');
        $error_message = null;

        try {
            $this->validateForm($form);

            /** @var UploadedFile $fileBeingUploaded */
            $fileBeingUploaded = $request->files->get(sprintf('%s[file]', $form->getName()), null, true);

            $fileModel = new Carousel();
            $fileModel->setCarouselId($carouselId);

            $fileCreateOrUpdateEvent = new FileCreateOrUpdateEvent(1);
            $fileCreateOrUpdateEvent->setModel($fileModel);
            $fileCreateOrUpdateEvent->setUploadedFile($fileBeingUploaded);

            $this->dispatch(
             TheliaEvents::IMAGE_SAVE, $fileCreateOrUpdateEvent
            );

            // Compensate issue #1005
            $langs = LangQuery::create()->find();

            /** @var Lang $lang */
            foreach ($langs as $lang) {
                $fileCreateOrUpdateEvent->getModel()->setLocale($lang->getLocale())->setTitle('')->save();
            }

            $response = $this->redirectToConfigurationPage($carouselId);
        } catch (FormValidationException $e) {
            $error_message = $this->createStandardFormValidationErrorMessage($e);
        }

        if (null !== $error_message) {
            $this->setupFormErrorContext(
             'carousel upload', $error_message, $form
            );


            $response = $this->render(
             "module-configure", [
             'module_code' => 'Carousel'
             ]
            );
        }

        return $response;
    }

    /**
     * @param Form $form
     * @param string $fieldName
     * @param int $id
     * @return string
     */
    protected function getFormFieldValue($form, $fieldName, $id)
    {
        $value = $form->get(sprintf('%s%d', $fieldName, $id))->getData();

        return $value;
    }
    
    protected function getFormFieldCarouselName($form, $fieldName)
    {
        $value = $form->get(sprintf('%s%d', $fieldName))->getData();

        return $value;
    }

    public function updateAction($carouselId)
    {
        if (null !== $response = $this->checkAuth(AdminResources::MODULE, ['carousel'], AccessManager::UPDATE)) {
            return $response;
        }

        Tlog::getInstance()->err("In update action");
        $form = $this->createForm('carousel.update');

        $error_message = null;

        try {
            $updateForm = $this->validateForm($form);

            $carousels = CarouselQuery::create()
             ->filterByCarouselId($carouselId)
             ->findAllByPosition();

            $locale = $this->getCurrentEditionLocale();

            /** @var Carousel $carousel */
            foreach ($carousels as $carousel) {
                $id = $carousel->getId();

                $carousel
                 ->setPosition($this->getFormFieldValue($updateForm, 'position', $id))
                 ->setUrl($this->getFormFieldValue($updateForm, 'url', $id))
                 ->setLocale($locale)
                 ->setTitle($this->getFormFieldValue($updateForm, 'title', $id))
                 ->setAlt($this->getFormFieldValue($updateForm, 'alt', $id))
                 ->setChapo($this->getFormFieldValue($updateForm, 'chapo', $id))
                 ->setDescription($this->getFormFieldValue($updateForm, 'description', $id))
                 ->setPostscriptum($this->getFormFieldValue($updateForm, 'postscriptum', $id))
                 ->setVisible($this->getFormFieldValue($updateForm, 'visible', $id))
                 ->save();
            }

            Tlog::getInstance()->err("In foreach" . $carousel);
            Tlog::getInstance()->err("Dupa foreach in try");
            $response = $this->redirectToConfigurationPage($carouselId);
        } catch (FormValidationException $e) {
            $error_message = $this->createStandardFormValidationErrorMessage($e);
        }


        if (null !== $error_message) {
            $this->setupFormErrorContext(
             'carousel upload', $error_message, $form
            );

            $response = $this->render("module-configure", ['module_code' => 'Carousel']);
        }
        Tlog::getInstance()->err("dupa if null ");

        return $response;
    }

    public function deleteAction($carouselId, $imageId)
    {
        if (null !== $response = $this->checkAuth(AdminResources::MODULE, ['carousel'], AccessManager::DELETE)) {
            return $response;
        }

        if ($imageId != "") {
            $carousel = CarouselQuery::create()
             ->filterByCarouselId($carouselId)
             ->findPk($imageId);

            if (null !== $carousel) {
                $carousel->delete();
            }
        }

        return $this->redirectToConfigurationPage($carouselId);
    }

    protected function redirectToConfigurationPage($carouselId)
    {
        return RedirectResponse::create(URL::getInstance()->absoluteUrl('/admin/module/carousel/view/' . $carouselId));
    }

    public function listAction()
    {
        return $this->render("list");
    }

    public function viewAction($carouselId)
    {
        Tlog::getInstance()->err("Viewing Template before");
        $carousel = CarouselQuery::create()
         ->findByCarouselId($carouselId);

        return $this->render("module_configuration", ['carouselId' => $carouselId]);
    }

//    public function viewTemplateAction($carouselTemplate) {
//         Tlog::getInstance()->err("Viewing Template before");
//        $carouselTemplate = CarouselNameQuery::create()
//                ->findByTemplate($carouselTemplate);
//
//        Tlog::getInstance()->err("Viewing Template");
//        return $this->render("$carouselTemplate");
//    }

    public function addNewCarouselName()
    {

        if (null !== $response = $this->checkAuth(AdminResources::MODULE, ['carousel'], AccessManager::CREATE)) {
            return $response;
        }

        Tlog::getInstance()->err("Add new carousel method");

        try {
            $carouselName = $this->createForm("carousel.name.form");
            $form         = $this->validateForm($carouselName, "POST");
            $data         = $form->getData();

            $crName = new CarouselName();
            $crName->setName($data["name"]);
            Tlog::getInstance()->err("Inainte de template" . $data["template"]);
            $crName->setTemplate($data["template"]);
            $crName->save();

            return $this->render("list");
        } catch (FormValidationException $ex) {
            $error_msg = $this->createStandardFormValidationErrorMessage($ex);
        } catch (Exception $ex) {
            $error_msg = $ex->getMessage();
        }


        Tlog::getInstance()->err("passed catch blocks");
        $this->setupFormErrorContext($this->getTranslator()
          ->trans("New carousel", [], \Carousel\Carousel::DOMAIN_NAME), $error_msg, $carouselName, $ex);


        return $this->render("list");
    }

    public function deleteCarouselName($carouselId)
    {

        if (null !== $response = $this->checkAuth(AdminResources::MODULE, ['carousel'], AccessManager::CREATE)) {
            return $response;
        }

        try {
            $crName = \Carousel\Model\CarouselNameQuery::create()
             ->findOneById($carouselId);
            $crName->delete();

            return $this->render("list");
        } catch (FormValidationException $ex) {
            $error_msg = $this->createStandardFormValidationErrorMessage($ex);
        } catch (Exception $ex) {
            $error_msg = $ex->getMessage();
        }

        $this->setupFormErrorContext($this->getTranslator()
          ->trans("Delete carousel", [], \Carousel\Carousel::DOMAIN_NAME), $error_msg);

        return $this->render("list");
    }
    
    public function updateCarouselName($carouselId){
        
        if (null !== $response = $this->checkAuth(AdminResources::MODULE, ['carousel'], AccessManager::UPDATE)) {
            return $response;
        }
        
        $carousel = CarouselNameQuery::create()
             ->findOneById($carouselId);
       
            $carousel
                 ->setTemplate($this->getRequest()->get("template-input"))
                 ->save();
      
        return RedirectResponse::create(URL::getInstance()->absoluteUrl('/admin/module/carousel/list'));
    }

}
