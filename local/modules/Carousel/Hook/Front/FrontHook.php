<?php

namespace Carousel\Hook\Front;

use Carousel\Model\CarouselQuery;
use Carousel\Model\CarouselHookQuery;
use Carousel\Model\CarouselNameQuery;
use Carousel\Controller\Front\ConfigController;
use Thelia\Core\Event\Hook\HookRenderEvent;
use Thelia\Core\Hook\BaseHook;
use Thelia\Log\Tlog;

class FrontHook extends BaseHook
{

    public function onPageRenderCarouselTemplate(HookRenderEvent $event)
    {
        $id = $event->getArgument("carousel_id");

        $carousel = CarouselNameQuery::create()
         ->findOneById($id);


        $event->add($this->render($carousel->getTemplate(), array("carousel_id" => $id)));
    }

    public function displayCarouselOnHook(HookRenderEvent $event)
    {
        $carouselIDs = self::getIdHook($event->getCode());

        foreach ($carouselIDs as $carouselID) {

            $this->getSession()->set("getIdHook", $carouselID);

            $carousel = $this->getCarouselName($carouselID);

            $carousel_id = CarouselNameQuery::create()
             ->findOneById($carousel);

            $event->add($this->render($carousel->getTemplate(), array("carousel_id" => $carouselID)));
        }
    }

    public static function getIdHook($code)
    {
        $idHook = CarouselHookQuery::create()
         ->findByHookCode($code);

        $ids = array();
        foreach ($idHook as $value) {
            array_push($ids, $value->getCarouselId());
        }
        return $ids;
    }

    protected function getCarouselName($id)
    {
        $carouselName = CarouselNameQuery::create()
         ->findOneById($id);
        return $carouselName;
    }

}
