<?php
namespace Selection\Controller;

use Selection\Model\SelectionI18nQuery;
use Thelia\Controller\Admin\BaseAdminController;

class SelectionController extends BaseAdminController
{
    /**
     * Show the default template : selectionList
     *
     * @return \Thelia\Core\HttpFoundation\Response
     */
    public function viewAction()
    {
        return $this->render("selectionlist");
    }

    /**
     * @return \Thelia\Core\HttpFoundation\Response
     * @throws \Exception
     */
    public function updateAction()
    {
        $selectionID = $this->getRequest()->get('selectionId');
        $response = array();

        try {
            $selection = SelectionI18nQuery::create()
                ->filterById($selectionID)
                ->findOne();

            if ($selection !== null) {
                $id          = $selection->getId();
                $title       = $selection->getTitle();
                $summary     = $selection->getChapo();
                $header = $selection->getHeader();
                $footer = $selection->getFooter();
                $conclusion  = $selection->getPostscriptum();
                $locale = $this->getRequest()->getSession()->get('thelia.current.lang')->getLocale();

                $response = [
                    'id'          => $id,
                    'title'       => $title,
                    'summary'     => $summary,
                    'header' => $header,
                    'footer' => $footer,
                    'conclusion'  => $conclusion,
                ];
                $selectionSeo = new SelectionUpdateController();
                $selectionSeo->updateAction(
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

        return $this->render("selection-edit", $response);
    }
}
