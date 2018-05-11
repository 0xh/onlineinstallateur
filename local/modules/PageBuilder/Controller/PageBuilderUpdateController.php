<?php

namespace PageBuilder\Controller;

use DateTime;
use Exception;
use PageBuilder\Event\PageBuilderEvent;
use PageBuilder\Event\PageBuilderEvents;
use PageBuilder\Form\PageBuilderCreateForm;
use PageBuilder\Form\PageBuilderUpdateForm;
use PageBuilder\Model\PageBuilder as PageBuilderModel;
use PageBuilder\Model\PageBuilderContentQuery;
use PageBuilder\Model\PageBuilderI18nQuery;
use PageBuilder\Model\PageBuilderProductQuery;
use PageBuilder\Model\PageBuilderQuery;
use PageBuilder\PageBuilder;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\Exception\PropelException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response as Response2;
use Thelia\Controller\Admin\AbstractSeoCrudController;
use Thelia\Core\Event\UpdatePositionEvent;
use Thelia\Core\HttpFoundation\Response;
use Thelia\Core\Security\AccessManager;
use Thelia\Core\Security\Resource\AdminResources;
use Thelia\Tools\URL;

class PageBuilderUpdateController extends AbstractSeoCrudController {

    protected $currentRouter = PageBuilder::ROUTER;

    /**
     * Save content of the pageBuilder
     *
     * @return Response2|Response
     * @throws PropelException
     */
    public function savePageBuilder() {

        $form = new PageBuilderUpdateForm($this->getRequest());

        $validForm = $this->validateForm($form);
        $data = $validForm->getData();

        $pageBuilderID = $data['page_builder_id'];
        $pageBuilderTitle = $data['page_builder_title'];
        $pageBuilderChapo = $data['page_builder_chapo'];
        $pageBuilderHeader = $data['page_builder_header'];
        $pageBuilderFooter = $data['page_builder_footer'];
        $pageBuilderPostscriptum = $data['page_builder_postscriptum'];

        $lang = $this->getRequest()->getSession()->get('thelia.current.lang');

        $aPageBuilder = PageBuilderI18nQuery::create()
                ->filterById($pageBuilderID)
                ->filterByLocale($lang->getLocale())
                ->findOne();

        $aPageBuilder
                ->setTitle($pageBuilderTitle)
                ->setChapo($pageBuilderChapo)
                ->setHeader($pageBuilderHeader)
                ->setFooter($pageBuilderFooter)
                ->setPostscriptum($pageBuilderPostscriptum);

        $aPageBuilder->save();

        if ($validForm->get('save_and_close')->isClicked()) {
            return $this->render("electionlist");
        }


        return $this->generateRedirectFromRoute('page_builder.update', [], ['pageBuilderId' => $pageBuilderID], null);
    }

    public function createPageBuilder() {
        $form = new PageBuilderCreateForm($this->getRequest());

        $validForm = $this->validateForm($form);
        $data = $validForm->getData();

        $pageBuilderTitle = $data['page_builder_title'];
        $pageBuilderChapo = $data['page_builder_chapo'];
        $pageBuilderHeader = $data['page_builder_header'];
        $pageBuilderFooter = $data['page_builder_footer'];
        $pageBuilderPostscriptum = $data['page_builder_postscriptum'];

        $lang = $this->getRequest()->getSession()->get('thelia.current.lang');


        /* ------------------------- Add in PageBuilder table */
        $pageBuilder = new PageBuilderModel();
        $lastPageBuilder = PageBuilderQuery::create()->orderByPosition(Criteria::DESC)->findOne();

        $date = new DateTime();

        if (null !== $lastPageBuilder) {
            $position = $lastPageBuilder->getPosition() + 1;
        } else {
            $position = 1;
        }

        try {
            $pageBuilder
                    ->setCreatedAt($date->format('Y-m-d H:i:s'))
                    ->setUpdatedAt($date->format('Y-m-d H:i:s'))
                    ->setVisible(1)
                    ->setPosition($position)
                    ->setLocale($lang->getLocale())
                    ->setTitle($pageBuilderTitle)
                    ->setChapo($pageBuilderChapo)
                    ->setHeader($pageBuilderHeader)
                    ->setFooter($pageBuilderFooter)
                    ->setPostscriptum($pageBuilderPostscriptum);

            $pageBuilder->save();

            $m = [
                'message' => 'PageBuilder : ' . $pageBuilderTitle . ' has been created and has #'
                . $pageBuilder->getId() . ' as reference'
            ];
        } catch (Exception $e) {
            $m = ['message' => $e->getMessage()];
        }


        return $this->render("pageBuilderlist", $m);
    }

    public function deletePageBuilder() {
        $pageBuilderID = $this->getRequest()->get('page_builder_ID');


        try {
            $pageBuilder = PageBuilderQuery::create()
                    ->findOneById($pageBuilderID);
            if (null !== $pageBuilder) {
                $pageBuilder->delete();
                $m = ['message' => "PageBuilder #" . $pageBuilderID . " has been deleted."];
            } else {
                $m = ['message' => "PageBuilder #" . $pageBuilderID . " doesn't exists so we can't delete it."];
            }
        } catch (Exception $e) {
            $m = ['message' => $e->getMessage()];
        }

        return $this->render("pageBuilderlist", $m);
    }

    public function deleteRelatedProduct() {
        $pageBuilderID = $this->getRequest()->get('pageBuilderID');
        $productID = $this->getRequest()->get('productID');

        try {
            $pageBuilder = PageBuilderProductQuery::create()
                    ->filterByProductId($productID)
                    ->findOneByPageBuilderId($pageBuilderID);
            if (null !== $pageBuilder) {
                $pageBuilder->delete();
                $m = ['message' => "Product #" . $productID . " related to #" . $pageBuilderID . " has been deleted."];
            } else {
                $m = ['message' => "Product #" . $productID . " related to #"
                    . $pageBuilderID . " doesn't exists so we can't delete it."];
            }
        } catch (Exception $e) {
            $m = ['message' => $e->getMessage()];
        }

        return $this->generateRedirectFromRoute('page_builder.update', [], ['pageBuilderId' => $pageBuilderID], null);
    }

    public function deleteRelatedContent() {
        $pageBuilderID = $this->getRequest()->get('pageBuilderID');
        $contentID = $this->getRequest()->get('contentID');

        try {
            $pageBuilder = PageBuilderContentQuery::create()
                    ->filterByContentId($contentID)
                    ->findOneByPageBuilderId($pageBuilderID);
            if (null !== $pageBuilder) {
                $pageBuilder->delete();
                $m = ['message' => "Product #" . $contentID . " related to #" . $pageBuilderID . " has been deleted."];
            } else {
                $m = ['message' => "Product #" . $contentID . " related to #"
                    . $pageBuilderID . " doesn't exists so we can't delete it."];
            }
        } catch (Exception $e) {
            $m = ['message' => $e->getMessage()];
        }

        return $this->generateRedirectFromRoute('page_builder.update', [], ['pageBuilderId' => $pageBuilderID], null);
    }

    /* --------------------------    Part Controller SEO */

    public function __construct() {
        parent::__construct(
                'pageBuilder', 'page_builder_id', 'order', AdminResources::MODULE, PageBuilderEvents::PAGE_BUILDER_CREATE, PageBuilderEvents::PAGE_BUILDER_UPDATE, PageBuilderEvents::PAGE_BUILDER_DELETE, null, PageBuilderEvents::RELATED_PRODUCT_UPDATE_POSITION, PageBuilderEvents::PAGE_BUILDER_UPDATE_SEO, 'PageBuilder'
        );
    }

    protected function getCreationForm() {
        return $this->createForm('admin.page_builder.update');
    }

    protected function getUpdateForm($data = array()) {
        if (!is_array($data)) {
            $data = array();
        }
        
        return $this->createForm('admin.page_builder.update', 'form', $data);
    }

    protected function hydrateObjectForm($object) {
        $this->hydrateSeoForm($object);

        $data = array(
            'page_builder_id' => $object->getId(),
            'id' => $object->getId(),
            'locale' => $object->getLocale(),
            'page_builder_title' => $object->getTitle(),
            'page_builder_chapo' => $object->getChapo(),
            'page_builder_header' => $object->getHeader(),
            'page_builder_footer' => $object->getFooter(),
            'page_builder_postscriptum' => $object->getPostscriptum(),
            'current_id' => $object->getId(),            
        );

        return $this->getUpdateForm($data);
    }

    protected function getCreationEvent($formData) {
        $event = new PageBuilderEvent();

        $event->setId($formData['page_builder_id']);
        $event->setTitle($formData['page_builder_title']);
        $event->setChapo($formData['page_builder_chapo']);
        $event->setHeader($formData['page_builder_header']);
        $event->setFooter($formData['page_builder_footer']);
        $event->setPostscriptum($formData['page_builder_postscriptum']);

        return $event;
    }

    protected function getUpdateEvent($formData) {
        $pageBuilder = PageBuilderQuery::create()->findPk($formData['page_builder_id']);
        $event = new PageBuilderEvent($pageBuilder);

        $event->setId($formData['page_builder_id']);
        $event->setTitle($formData['page_builder_title']);
        $event->setChapo($formData['page_builder_chapo']);
        $event->setHeader($formData['page_builder_header']);
        $event->setFooter($formData['page_builder_footer']);
        $event->setPostscriptum($formData['page_builder_postscriptum']);
        $event->setLocale($this->getRequest()->getSession()->get('thelia.current.lang')->getLocale());
        return $event;
    }

    protected function getDeleteEvent() {
        $event = new PageBuilderEvent();

        $event->setId($this->getRequest()->request->get('page_builder_id'));

        return $event;
    }

    protected function eventContainsObject($event) {
        return $event->hasPageBuilder();
    }

    protected function getObjectFromEvent($event) {
        return $event->getPageBuilder();
    }

    protected function getExistingObject() {
        $pageBuilder = PageBuilderQuery::create()
                ->findPk($this->getRequest()->get('pageBuilderId', 0));

        if (null !== $pageBuilder) {
            $pageBuilder->setLocale($this->getCurrentEditionLocale());
        }

        return $pageBuilder;
    }

    protected function getObjectLabel($object) {
        return '';
    }

    protected function getObjectId($object) {
        return $object->getId();
    }

    protected function renderListTemplate($currentOrder) {
        $this->getParser()
                ->assign("order", $currentOrder);

        return $this->render('pageBuilderlist');
    }

    protected function renderEditionTemplate() {
        $this->getParserContext()
                ->set(
                        'page_builder_id', $this->getRequest()->get('pageBuilderId'))
                ->set(
                        'html_files', $this->getHtmlFiles()
        );

        return $this->render('pageBuilder-edit');
    }

    protected function redirectToEditionTemplate() {
        $id = $this->getRequest()->get('pageBuilder_id');

        return new RedirectResponse(
                URL::getInstance()->absoluteUrl(
                        "/admin/page-builder/update/" . $id
                )
        );
    }

    protected function redirectToListTemplate() {
        return new RedirectResponse(
                URL::getInstance()->absoluteUrl("/admin/PageBuilder")
        );
    }

    /**
     * Online status toggle product
     */
    public function setToggleVisibilityAction() {
        // Check current user authorization
        if (null !== $response = $this->checkAuth($this->resourceCode, array(), AccessManager::UPDATE)) {
            return $response;
        }

        $event = new PageBuilderEvent($this->getExistingObject());

        try {
            $this->dispatch(PageBuilderEvents::PAGE_BUILDER_TOGGLE_VISIBILITY, $event);
        } catch (Exception $ex) {
            // Any error
            return $this->errorPage($ex);
        }

        // Ajax response -> no action
        return $this->nullResponse();
    }

    protected function createUpdatePositionEvent($positionChangeMode, $positionValue) {
        return new UpdatePositionEvent(
                $this->getRequest()->get('product_id', null), $positionChangeMode, $positionValue, $this->getRequest()->get('page_builder_id', null)
        );
    }

    protected function performAdditionalUpdatePositionAction($positionEvent) {
        $pageBuilderID = $this->getRequest()->get('page_builder_id');

        return $this->generateRedirectFromRoute('page_builder.update', [], ['pageBuilderId' => $pageBuilderID], null);
    }

    public function getHtmlFiles() {
        $location = scandir($_SERVER['DOCUMENT_ROOT'] . "/../templates/frontOffice/default/page-builder/");
        $files = array_diff($location, array(".", ".."));

        return $files;
    }

}
