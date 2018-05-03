<?php
namespace PageBuilder\Controller;

use PageBuilder\Model\PageBuilderI18nQuery;
use Thelia\Controller\Admin\BaseAdminController;

class PageBuilderController extends BaseAdminController
{
    /**
     * Show the default template : pageBuilderList
     *
     * @return \Thelia\Core\HttpFoundation\Response
     */
    public function viewAction()
    {
        return $this->render("pageBuilderlist");
    }

    /**
     * @return \Thelia\Core\HttpFoundation\Response
     * @throws \Exception
     */
    public function updateAction()
    {
        $pageBuilderID = $this->getRequest()->get('pageBuilderId');
        $response = array();

        try {
            $pageBuilder = PageBuilderI18nQuery::create()
                ->filterById($pageBuilderID)
                ->findOne();

            if ($pageBuilder !== null) {
                $id          = $pageBuilder->getId();
                $title       = $pageBuilder->getTitle();
                $summary     = $pageBuilder->getChapo();
                $header = $pageBuilder->getHeader();
                $footer = $pageBuilder->getFooter();
                $conclusion  = $pageBuilder->getPostscriptum();
                $locale = $this->getRequest()->getSession()->get('thelia.current.lang')->getLocale();

                $response = [
                    'id'          => $id,
                    'title'       => $title,
                    'summary'     => $summary,
                    'header' => $header,
                    'footer' => $footer,
                    'conclusion'  => $conclusion,
                ];
                $pageBuilderSeo = new PageBuilderUpdateController();
                $pageBuilderSeo->updateAction(
                    $id,
                    $locale = $this->getRequest()
                                    ->getSession()
                                    ->get('thelia.current.lang')
                                    ->getLocale()
                );
            }
        } catch (\Exception $ex) {
            throw $ex;
        }

        return $this->render("pageBuilder-edit", $response);
    }
}
