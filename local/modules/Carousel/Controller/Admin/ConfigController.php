<?php

namespace Carousel\Controller\Admin;

use Carousel\Model\CarouselNameQuery;
use Carousel\Model\CarouselHookQuery;
use HookConfigurator\HookConfigurator;
use Thelia\Controller\Admin\BaseAdminController;
use Thelia\Core\Security\AccessManager;
use Thelia\Core\Security\Resource\AdminResources;
use Thelia\Core\Thelia;
use Thelia\Form\Exception\FormValidationException;
use Thelia\Tools\URL;
use Thelia\Tools\Version\Version;

/**
 * Description of ConfigController
 *
 * @author Catana Florin
 */
class ConfigController extends BaseAdminController
{

    public function editHookIdCarousel()
    {

        if (null !== $response = $this->checkAuth(AdminResources::MODULE, 'Carousel', AccessManager::UPDATE)) {
            return $response;
        }

        $carousel = $this->createForm("carousel.hook.form");

        try {
            $form = $this->validateForm($carousel, "POST");
            $data = $form->getData();


            $idCarousel = CarouselNameQuery::create()
             ->findOneById($data['carousel_id']);


            if ($idCarousel) {
                $hookCarousel = \Carousel\Model\CarouselHookQuery::create()
                 ->findOneById($this->getRequest()->request->get("hook_key_id"));

                $oldHookId = $hookCarousel->getHookId();

                $hookCarousel->setCarouselId($idCarousel->getId());
                $hookCarousel->setHookCode($data["hook_code"]);
                $hookCarousel->setHookId($data["hook_id"]);
                $hookCarousel->save();

                $passCarouselId = $idCarousel->getTemplate();

                $module = \Thelia\Model\ModuleQuery::create()
                 ->findOneByCode("Carousel");

                $moduleId = $module->getId();
                $hookId   = $data["hook_id"];

                $this->saveModuleHook($moduleId, $hookId, $oldHookId, $passCarouselId);
            }

            $url = '/admin/module/Carousel';
            return $this->generateRedirect(URL::getInstance()->absoluteUrl($url));
        } catch (FormValidationException $ex) {
            $error_msg = $this->createStandardFormValidationErrorMessage($ex);
        } catch (Exception $ex) {
            $error_msg = $ex->getMessage();
        }

        $this->setupFormErrorContext($this->getTranslator()
          ->trans("Carouseling", [], HookConfigurator::DOMAIN_NAME), $error_msg, $carousel, $ex);

        if (Version::test(Thelia::THELIA_VERSION, '2.2', false, "<")) {
            return $this->render('module-configure', [
              'module_code' => 'Carousel'
            ]);
        } else {
            return $this->generateRedirect(URL::getInstance()->absoluteUrl('/admin/module/Carousel'));
        }
    }

    protected function saveModuleHook($moduleId, $hookId, $oldHookId, $passCarouselId)
    {

        $query = \Thelia\Model\ModuleHookQuery::create()
         ->filterByModuleId($moduleId)
         ->findOneByHookId($oldHookId);

        if ($query) {
            $query->delete();
        }

        $position = \Thelia\Model\ModuleHookQuery::create()
         ->orderByPosition('desc')
         ->findOne();

        $position = $position->getPosition();

        \Thelia\Log\Tlog::getInstance()->err("GETTING POS " . $position);


        if ($hookId) {
            $moduleHook = new \Thelia\Model\ModuleHook();
            $moduleHook->setModuleId($moduleId);
            $moduleHook->setHookId($hookId);
            $moduleHook->setClassname("carousel.hook.front");
            $moduleHook->setMethod("displayCarouselOnHook");
            $moduleHook->setActive(1);
            $moduleHook->setHookActive(1);
            $moduleHook->setModuleActive(1);
            $moduleHook->setPosition($position + 1);
            $moduleHook->setTemplates("");
            $moduleHook->save();
        }
    }

    public function deleteHookIdCarousel($id)
    {

        $hookCarousel = CarouselHookQuery::create()
         ->findOneById($id);

        if ($hookCarousel) {

            $module = \Thelia\Model\ModuleQuery::create()
             ->findOneByCode("Carousel");

            $moduleId = $module->getId();

            $query = \Thelia\Model\ModuleHookQuery::create()
             ->filterByModuleId($moduleId)
             ->findOneByHookId($hookCarousel->getHookId());

            if ($query) {
                $query->delete();
            }

            $hookCarousel->delete();
        }

        return $this->generateRedirect(URL::getInstance()->absoluteUrl('/admin/module/Carousel'));
    }

    public function addNewHookIdCarousel()
    {
        $newHook = new \Carousel\Model\CarouselHook();
        $newHook->save();

        return $this->generateRedirect(URL::getInstance()->absoluteUrl("/admin/module/Carousel"));
    }

}
