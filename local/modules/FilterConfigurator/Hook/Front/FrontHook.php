<?php

namespace FilterConfigurator\Hook\Front;

use FilterConfigurator\Model\FilterConfiguratorHookQuery;
use Thelia\Core\Event\Hook\HookRenderEvent;
use Thelia\Core\Hook\BaseHook;

class FrontHook extends BaseHook
{

    public function configuratorDescription(HookRenderEvent $event)
    {
        $params["category_id"] = $event->getArgument('category_id');

        $event->add($this->render(
          'configurator-details.html', $params
        ));
    }

    public function configuratorFilters(HookRenderEvent $event)
    {
        $params["category_id"] = $event->getArgument('category_id');
        $params["categories"]  = $event->getArgument('categories');

        $event->add($this->render(
          'configurator-filters.html', $params
        ));
    }

    public function configuratorFiltersSelection(HookRenderEvent $event)
    {


        $id = self::getIdForFilterConfigurator($event->getCode());

        $event->add($this->render(
          'configurator-filters-selection.html', array("filter_configurator_id" => $id)
        ));
    }

    public static function getIdForFilterConfigurator($code)
    {
        $idForFilterConfigurator = FilterConfiguratorHookQuery::create()
         ->findOneByHookCode($code);

        return $idForFilterConfigurator->getFilterConfiguratorId();
    }

    public function onMainJs(HookRenderEvent $event)
    {
        $event->add($this->addJS('assets/dist/js/filter-configurator.js'));
    }

    public function onMainCss(HookRenderEvent $event)
    {
        $event->add($this->addCSS('assets/dist/css/filter-configurator.css'));
    }

}
