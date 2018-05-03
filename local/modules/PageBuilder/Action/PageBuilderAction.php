<?php

namespace PageBuilder\Action;

use Propel\Runtime\Propel;
use PageBuilder\Event\PageBuilderEvent;
use PageBuilder\Event\PageBuilderEvents;
use PageBuilder\Model\Map\PageBuilderTableMap;
use PageBuilder\Model\PageBuilder;
use PageBuilder\Model\PageBuilderQuery;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Thelia\Action\BaseAction;
use Thelia\Core\Event\UpdateSeoEvent;
use Thelia\Core\Event\UpdatePositionEvent;
use PageBuilder\Model\Base\PageBuilderProductQuery;

class PageBuilderAction extends BaseAction implements EventSubscriberInterface
{
    /** @var EventDispatcherInterface */
    protected $eventDispatcher;

    public function create(PageBuilderEvent $event)
    {
        $this->createOrUpdate($event, new PageBuilder());
    }

    public function update(PageBuilderEvent $event)
    {
        $model = $this->getPageBuilder($event);

        $this->createOrUpdate($event, $model);
    }

    public function updateSeo(UpdateSeoEvent $event, $eventName, EventDispatcherInterface $dispatcher)
    {
        return $this->genericUpdateSeo(PageBuilderQuery::create(), $event, $dispatcher);
    }

    public function delete(PageBuilderEvent $event)
    {
        $this->getPageBuilder($event)->delete();
    }

    protected function getPageBuilder(PageBuilderEvent $event)
    {
        $model = PageBuilderQuery::create()
            ->findPk($event->getId());

        if (null === $model) {
            throw new \RuntimeException(sprintf(
                "PageBuilder id '%d' doesn't exist",
                $event->getId()
            ));
        }
        return $model;
    }


    protected function createOrUpdate($event, PageBuilder $model)
    {
        $con = Propel::getConnection(PageBuilderTableMap::DATABASE_NAME);
        $con->beginTransaction();
        try {
            if (null !== $locale = $event->getLocale()) {
                $model->setLocale($locale);
            }
            if (null !== $id = $event->getId()) {
                $model->setId($id);
            }

            if (null !== $title = $event->getTitle()) {
                $model->setTitle($title);
            }

            if (null !== $chapo = $event->getChapo()) {
                $model->setChapo($chapo);
            }

            if (null !== $header = $event->getHeader()) {
                $model->setHeader($header);
            }

            if (null !== $footer = $event->getFooter()) {
                $model->setFooter($footer);
            }

            if (null !== $postscriptum = $event->getPostscriptum()) {
                $model->setPostscriptum($postscriptum);
            }

            $model->save();

            $event->setPageBuilder($model);

            $con->commit();
        } catch (\Exception $e) {
            $con->rollBack();

            throw $e;
        }
    }

    /**
     * @param PageBuilderEvent $event
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function toggleVisibility(PageBuilderEvent $event)
    {
        $pageBuilder = $event->getPageBuilder();

        $pageBuilder
            ->setVisible($pageBuilder->getVisible() ? false : true)
            ->save()
        ;

        $event->setPageBuilder($pageBuilder);
    }

    /**
     * Changes position, selecting absolute or relative change.
     *
     * @param UpdatePositionEvent $event
     * @param $eventName
     * @param EventDispatcherInterface $dispatcher
     */
    public function updatePosition(UpdatePositionEvent $event, $eventName, EventDispatcherInterface $dispatcher)
    {
        $this->genericUpdateDelegatePosition(
            PageBuilderProductQuery::create()
                ->filterByProductId($event->getObjectId())
                ->filterByPageBuilderId($event->getReferrerId()),
            $event,
            $dispatcher
        );
    }

    public static function getSubscribedEvents()
    {
        return array(
            PageBuilderEvents::PAGE_BUILDER_CREATE                   => array("create", 128),
            PageBuilderEvents::PAGE_BUILDER_UPDATE                   => array("update", 128),
            PageBuilderEvents::PAGE_BUILDER_DELETE                   => array("delete", 128),
            PageBuilderEvents::PAGE_BUILDER_UPDATE_SEO               => array("updateSeo", 128),
            PageBuilderEvents::PAGE_BUILDER_TOGGLE_VISIBILITY        => array("toggleVisibility", 128),
            PageBuilderEvents::RELATED_PRODUCT_UPDATE_POSITION    => array("updatePosition", 128),
        );
    }
}