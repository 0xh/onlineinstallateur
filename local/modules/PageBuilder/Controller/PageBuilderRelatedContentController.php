<?php

namespace PageBuilder\Controller;

use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\Join;
use PageBuilder\Model\Map\PageBuilderContentTableMap;
use PageBuilder\Model\PageBuilderContent;
use PageBuilder\Model\PageBuilderContentQuery;
use PageBuilder\PageBuilder;
use Thelia\Controller\Admin\BaseAdminController;
use Thelia\Model\Content;
use Thelia\Model\ContentFolder;
use Thelia\Model\ContentFolderQuery;
use Thelia\Model\ContentQuery;
use Thelia\Model\Map\ContentTableMap;

class PageBuilderRelatedContentController extends BaseAdminController
{
    protected $currentRouter = PageBuilder::ROUTER;

    /**
     * Return content id & title
     *
     * @return \Thelia\Core\HttpFoundation\Response
     */
    public function getContentRelated()
    {
        $folderId = $this->getRequest()->get('folderID');

        $contentCategory = ContentFolderQuery::create();
        $lang = $this->getRequest()->getSession()->get('thelia.current.lang');

        $result = array();

        if ($folderId !== null) {
            $contentCategory->filterByFolderId($folderId)->find();

            if ($contentCategory !== null) {
                /** @var ContentFolder $item */
                foreach ($contentCategory as $item) {
                    $content = ContentQuery::create()
                        ->filterById($item->getContentId())
                        ->findOne();

                    $result[] =
                        [
                            'id' => $content->getId(),
                            'title' => $content->getTranslation($lang->getLocale())->getTitle()
                        ];
                }
            }
        }
        return $this->jsonResponse(json_encode($result));
    }

    /**
     * Add content to current pageBuilder
     *
     * @return \Thelia\Core\HttpFoundation\Response
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function addContentRelated()
    {
        $contentId = $this->getRequest()->get('contentID');
        $pageBuilderID = $this->getRequest()->get('pageBuilderID');

        $contentRelated = new PageBuilderContent();

        if ($contentId !== null) {
            $PageBuilderContent = PageBuilderContentQuery::create()
                ->filterByPageBuilderId($pageBuilderID)
                ->filterByContentId($contentId)
                ->findOne();

            if (is_null($PageBuilderContent)) {
                $contentRelated->setPageBuilderId($pageBuilderID);
                $contentRelated->setContentId($contentId);

                $position = PageBuilderContentQuery::create()
                    ->filterByPageBuilderId($pageBuilderID)
                    ->orderByPosition(Criteria::DESC)
                    ->select('position')
                    ->findOne();
                if (null === $position) {
                    $contentRelated->setPosition(1);
                } else {
                    $contentRelated->setPosition($position+1);
                }
                $contentRelated->save();
            }

            $lang = $this->getRequest()->getSession()->get('thelia.current.lang');

            $search = ContentQuery::create();
            $pageBuilderContentRelated = new Join(
                ContentTableMap::ID,
                PageBuilderContentTableMap::CONTENT_ID,
                Criteria::INNER_JOIN
            );

            $search->addJoinObject($pageBuilderContentRelated, 'pageBuilderContentRelated');
            $search->addJoinCondition(
                'pageBuilderContentRelated',
                PageBuilderContentTableMap::PAGE_BUILDER_ID.'='.$pageBuilderID
            );
            $search->find();

            /** @var Content $row */
            foreach ($search as $row) {
                $pageBuilderContentPos = PageBuilderContentQuery::create()
                    ->filterByPageBuilderId($pageBuilderID)
                    ->filterByContentId($row->getId())
                    ->findOne();

                $result = [
                    'id' => $row->getId() ,
                    'title' => $row->getTranslation($lang->getLocale())->getTitle(),
                    'position' => $pageBuilderContentPos->getPosition()
                ];
            }
        }
        return $this->render('related/contentRelated', ['pageBuilder_id' => $pageBuilderID]);
    }

    /**
     * Show content related to a pageBuilder
     *
     * @param null $p
     * @return array|\Thelia\Core\HttpFoundation\Response
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function showContent($p = null)
    {
        $pageBuilderID = $this->getRequest()->get('pageBuilderID');
        $lang = $this->getRequest()->getSession()->get('thelia.current.lang');

        $search = ContentQuery::create();
        $pageBuilderContentRelated = new Join(
            ContentTableMap::ID,
            PageBuilderContentTableMap::CONTENT_ID,
            Criteria::INNER_JOIN
        );

        $search->addJoinObject($pageBuilderContentRelated, 'pageBuilderContentRelated');
        $search->addJoinCondition(
            'pageBuilderContentRelated',
            PageBuilderContentTableMap::PAGE_BUILDER_ID.'='.$pageBuilderID
        );
        $search->find();

        /** @var Content $row */
        foreach ($search as $row) {
            $pageBuilderContentPos = PageBuilderContentQuery::create()
                ->filterByPageBuilderId($pageBuilderID)
                ->filterByContentId($row->getId())
                ->findOne();

            $result = [
                'id' => $row->getId() ,
                'title' => $row->getTranslation($lang->getLocale())->getTitle(),
                'position' => $pageBuilderContentPos->getPosition()
            ];
        }

        if ($p === null) {
            return $this->render('related/contentRelated', ['pageBuilder_id' => $pageBuilderID]);
        } else {
            return $result;
        }
    }
}
