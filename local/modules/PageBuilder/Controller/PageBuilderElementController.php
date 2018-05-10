<?php

namespace PageBuilder\Controller;

use PageBuilder\Model\Map\PageBuilderElementTableMap;
use PageBuilder\Model\PageBuilderElement;
use PageBuilder\Model\PageBuilderElementI18nQuery;
use PageBuilder\Model\PageBuilderElementQuery;
use PageBuilder\Model\PageBuilderI18nQuery;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Thelia\Controller\Admin\BaseAdminController;
use Thelia\Tools\URL;

class PageBuilderElementController extends BaseAdminController {

    public function addNewElement($tplType, $pageBuilderID) {
        $count = $this->countElementPageElement($pageBuilderID);
        $request = $this->getRequest()->request;

        $json = array();

        foreach ($request as $key => $t) {
            if ($t) {
                $json[$key] = "";
            }
        }

        $data["page_builder_id"] = $pageBuilderID;
        $data["position"] = $count + 1;
        $data["visible"] = 1;
        $data["locale"] = "en_US";
        $data["template_name"] = $tplType;
        $data["variables"] = json_encode($json);

        $this->addPageBuilderElement($data);

        return new RedirectResponse(
                URL::getInstance()->absoluteUrl(
                        "/admin/page-builder/update/" . $pageBuilderID
                )
        );
    }

    protected function countElementPageElement($pageBuilderID) {
        $query = PageBuilderElementQuery::create();
        $query->where(PageBuilderElementTableMap::PAGE_BUILDER_ID . "=" . $pageBuilderID);
        return $query->count();
    }

    protected function addPageBuilderElement($data) {
        $query = new PageBuilderElement();
        $query->setPageBuilderId($data["page_builder_id"])
                ->setPosition($data["position"])
                ->setVisible($data["visible"])
                ->setLocale($data["locale"])
                ->setTemplateName($data["template_name"])
                ->setVariables($data["variables"]);
        $query->save();
    }

    public function updateElement($pageBuilderID, $elementId) {
        $query = PageBuilderElementI18nQuery::create()
                ->findOneById($elementId);

        $json = array();
        $request = $this->getRequest()->request;
        foreach ($request as $key => $t) {
            $json[$key] = $t;
        }
        $query->setVariables(json_encode($json));
        $query->save();

        return new RedirectResponse(
                URL::getInstance()->absoluteUrl(
                        "/admin/page-builder/update/" . $pageBuilderID
                )
        );
    }

    public function deleteElement($pageBuilderID, $elementId) {
        $query = PageBuilderElementI18nQuery::create()
                ->findOneById($elementId);

        $query->delete();

        return new RedirectResponse(
                URL::getInstance()->absoluteUrl(
                        "/admin/page-builder/update/" . $pageBuilderID
                )
        );
    }

}
