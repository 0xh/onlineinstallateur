<?php

namespace Selection\Action;

use Exception;
use InvalidArgumentException;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Propel;
use RuntimeException;
use Selection\Event\FeatureSelectionCreateEvent;
use Selection\Event\FeatureSelectionDeleteEvent;
use Selection\Event\FeatureSelectionUpdateEvent;
use Selection\Event\SelectionEvent;
use Selection\Event\SelectionEvents;
use Selection\Model\Base\SelectionProductQuery;
use Selection\Model\Map\SelectionTableMap;
use Selection\Model\Selection;
use Selection\Model\SelectionContainerAssociatedSelection;
use Selection\Model\SelectionContainerAssociatedSelectionQuery;
use Selection\Model\SelectionFeatures;
use Selection\Model\SelectionFeaturesQuery;
use Selection\Model\SelectionQuery;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Thelia\Action\BaseAction;
use Thelia\Core\Event\Feature\FeatureAvDeleteEvent;
use Thelia\Core\Event\Feature\FeatureAvUpdateEvent;
use Thelia\Core\Event\UpdatePositionEvent;
use Thelia\Core\Event\UpdateSeoEvent;
use Thelia\Log\Tlog;
use Thelia\Model\FeatureAv;
use Thelia\Model\FeatureAvI18nQuery;
use function class_uses;

class SelectionAction extends BaseAction implements EventSubscriberInterface
{

    /** @var EventDispatcherInterface */
    protected $eventDispatcher;

    /**
     * @param SelectionEvent $event
     * @throws Exception
     */
    public function create(SelectionEvent $event)
    {
        $this->createOrUpdate($event, new Selection());
    }

    /**
     * @param SelectionEvent $event
     * @throws Exception
     */
    public function update(SelectionEvent $event)
    {
        $model = $this->getSelection($event);

        $this->createOrUpdate($event, $model);
    }

    /**
     * @param UpdateSeoEvent $event
     * @param $eventName
     * @param EventDispatcherInterface $dispatcher
     * @return mixed
     */
    public function updateSeo(
    UpdateSeoEvent $event,
    /** @noinspection PhpUnusedParameterInspection  */ $eventName, EventDispatcherInterface $dispatcher)
    {
        return $this->genericUpdateSeo(SelectionQuery::create(), $event, $dispatcher);
    }

    /**
     * @param SelectionEvent $event
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function delete(SelectionEvent $event)
    {
        $this->getSelection($event)->delete();
    }

    protected function getSelection(SelectionEvent $event)
    {
        $model = SelectionQuery::create()
         ->findPk($event->getId());

        if (null === $model) {
            throw new RuntimeException(sprintf(
             "Selection id '%d' doesn't exist", $event->getId()
            ));
        }
        return $model;
    }

    /**
     * @param SelectionEvent $event
     * @param Selection $model
     * @throws Exception
     */
    protected function createOrUpdate(SelectionEvent $event, Selection $model)
    {
        $con = Propel::getConnection(SelectionTableMap::DATABASE_NAME);
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

            if (null !== $description = $event->getDescription()) {
                $model->setDescription($description);
            }

            if (null !== $postscriptum = $event->getPostscriptum()) {
                $model->setPostscriptum($postscriptum);
            }
            $model->save();

            $event->setSelection($model);

            $this->updateContainerAssociatedToSelection($event, $con);

            $con->commit();
        } catch (Exception $e) {
            $con->rollBack();
            Tlog::getInstance()->error($e->getMessage());
            throw $e;
        }
    }

    /**
     * @param SelectionEvent $event
     * @param ConnectionInterface $con
     * @throws \Propel\Runtime\Exception\PropelException
     */
    protected function updateContainerAssociatedToSelection(SelectionEvent $event, ConnectionInterface $con)
    {
        $associationQuery = SelectionContainerAssociatedSelectionQuery::create();
        $association      = $associationQuery->findOneBySelectionId($event->getId());
        $containerId      = $event->getContainerId();
        if (empty($association)) {
            if (empty($containerId)) {
                return;
            }
            $association = new SelectionContainerAssociatedSelection();
            $association->setSelectionId($event->getId());
        } else if ($association->getSelectionContainerId() === $containerId) {
            return;
        } else if (empty($containerId)) {
            $association->delete($con);
            return;
        }
        $association->setSelectionContainerId($containerId);
        $association->save($con);
    }

    /**
     * @param SelectionEvent $event
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function toggleVisibility(SelectionEvent $event)
    {
        $selection = $event->getSelection();

        $selection
         ->setVisible($selection->getVisible() ? false : true)
         ->save()
        ;

        $event->setSelection($selection);
    }

    /** @noinspection PhpUnusedParameterInspection */

    /**
     * Changes position, selecting absolute or relative change.
     *
     * @param UpdatePositionEvent $event
     * @param $eventName
     * @param EventDispatcherInterface $dispatcher
     */
    public function updateProductPosition(
    UpdatePositionEvent $event,
    /** @noinspection PhpUnusedParameterInspection  */
    $eventName,
    /** @noinspection PhpUnusedParameterInspection  */ EventDispatcherInterface $dispatcher
    )
    {
        $this->genericUpdateDelegatePosition(
         SelectionProductQuery::create()
          ->filterByProductId($event->getObjectId())
          ->filterBySelectionId($event->getReferrerId()), $event
        );
    }

    /**
     * @param UpdatePositionEvent $event
     * @param $eventName
     * @param EventDispatcherInterface $dispatcher
     */
    public function updatePosition(
    UpdatePositionEvent $event,
    /** @noinspection PhpUnusedParameterInspection */ $eventName, EventDispatcherInterface $dispatcher
    )
    {
        $modelCriteria = SelectionQuery::create()->filterById($event->getObjectId());
        $this->genericUpdateDelegatePosition(
         $modelCriteria, $event, $dispatcher
        );
    }

    protected function genericUpdateDelegatePosition(
    ModelCriteria $query, UpdatePositionEvent $event, EventDispatcherInterface $dispatcher = null
    )
    {

        if (null !== $object = $query->findOne()) {
            if (!isset(class_uses($object)['Thelia\Model\Tools\PositionManagementTrait'])) {
                throw new InvalidArgumentException("Your model does not implement the PositionManagementTrait trait");
            }

            if (!is_null($dispatcher)) {
                $object->setDispatcher($dispatcher);
            }

            $mode = $event->getMode();

            if ($mode == UpdatePositionEvent::POSITION_ABSOLUTE) {
                $object->changeAbsolutePosition($event->getPosition());
            } elseif ($mode == UpdatePositionEvent::POSITION_UP) {
                $object->movePositionUp();
            } elseif ($mode == UpdatePositionEvent::POSITION_DOWN) {
                $object->movePositionDown();
            }
        }
    }

    public function createSelectionFeautures(FeatureSelectionCreateEvent $event, $eventName,
                                             EventDispatcherInterface $dispatcher)
    {
        $feature = new SelectionFeatures();
        $feature->setDispatcher($dispatcher)
         ->setFeatureId($event->getFeautureId())
         ->setSelectionId($event->getSelectionId())
         ->setFeatureValue($event->getFeautureId())
         ->save();
        return true;
    }

    /**
     * Change a product feature
     *
     * @param FeatureAvUpdateEvent $event
     * @param $eventName
     * @param EventDispatcherInterface $dispatcher
     */
    public function updateSelectionFeautures(FeatureSelectionUpdateEvent $event, $eventName,
                                             EventDispatcherInterface $dispatcher)
    {


        $feature_av_id = $event->getFeatureValue();

        $feature = SelectionFeaturesQuery::create()
         ->filterBySelectionId($event->getSelectionId())
         ->filterByFeatureId($event->getFeatureId())
         ->findOne();


        if (null !== $feature) {
            if ($event->getIsTextValue()) {
                $this->updateFreeTextMapping($event, $feature->getFeatureAvId());
                $feature_av_id = $feature->getFeatureAvId();
            }

            $feature->setFeatureId($event->getFeatureId())
             ->setSelectionId($event->getSelectionId())
             ->setFeatureAvId($feature_av_id)
             ->setFreetextValue($event->getIsTextValue())
             ->save();
        } else {

            $feature = new SelectionFeatures();
            if ($event->getIsTextValue()) {
                $feature_av_id = $this->createFreeTextMapping($event);
            }
            $feature->setFeatureId($event->getFeatureId())
             ->setSelectionId($event->getSelectionId())
             ->setFeatureAvId($feature_av_id)
             ->setFreetextValue($event->getIsTextValue())
             ->setNew(true);
            $feature->save();
        }
    }

    /**
     * Delete a product feature entry
     *
     * @param FeatureAvDeleteEvent $event
     * @param $eventName
     * @param EventDispatcherInterface $dispatcher
     */
    public function deleteSelectionFeautures(FeatureSelectionDeleteEvent $event, $eventName,
                                             EventDispatcherInterface $dispatcher)
    {
        if (null !== ($feature = SelectionFeaturesQuery::create()->findPk($event->getSelectionId()))) {
            $feature->delete()
            ;
            $event->setFeatureId($feature);
        }
    }

    public function createFreeTextMapping(FeatureSelectionUpdateEvent $event, $feature_av_id = false)
    {
        $objFav = new FeatureAv();
        $objFav->setLocale($event->getLocale());
        $objFav->setFeatureId($event->getFeatureId());
        $objFav->setTitle($event->getFeatureValue());
        $objFav->save();
        return $objFav->getId();
    }

    public function updateFreeTextMapping(FeatureSelectionUpdateEvent $event, $feature_av_id)
    {

        $objFav = FeatureAvI18nQuery::create()
         ->filterById($feature_av_id)
         ->filterByLocale($event->getLocale())
         ->findOne();
        $objFav->setTitle($event->getFeatureValue())
         ->save();
    }

    public static function getSubscribedEvents()
    {
        return array(
         SelectionEvents::SELECTION_CREATE                => array(
          "create",
          128),
         SelectionEvents::SELECTION_UPDATE                => array(
          "update",
          128),
         SelectionEvents::SELECTION_DELETE                => array(
          "delete",
          128),
         SelectionEvents::SELECTION_UPDATE_SEO            => array(
          "updateSeo",
          128),
         SelectionEvents::SELECTION_UPDATE_POSITION       => array(
          "updatePosition",
          128),
         SelectionEvents::SELECTION_TOGGLE_VISIBILITY     => array(
          "toggleVisibility",
          128),
         SelectionEvents::RELATED_PRODUCT_UPDATE_POSITION => array(
          "updateProductPosition",
          128),
         SelectionEvents::SELECTION_FEATURE_DELETE_VALUE  => array(
          "deleteSelectionFeautures",
          128),
         SelectionEvents::SELECTION_FEATURE_UPDATE_VALUE  => array(
          "updateSelectionFeautures",
          128),
         SelectionEvents::SELECTION_FEATURE_CREATE_VALUE  => array(
          "createSelectionFeautures",
          128),
        );
    }

}
