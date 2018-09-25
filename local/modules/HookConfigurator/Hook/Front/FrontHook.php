<?php

namespace HookConfigurator\Hook\Front;

use HookConfigurator\Controller\Front\ConfiguratorController;
use HookConfigurator\Model\ConfiguratorHookQuery;
use HookConfigurator\Model\ConfiguratorQuery;
use Thelia\Core\Event\Hook\HookRenderEvent;
use Thelia\Core\Hook\BaseHook;

class FrontHook extends BaseHook {

    public function displayFormSlider(HookRenderEvent $event) {

        $configuratorIDs = self::getIdHook($event->getCode());

        foreach ($configuratorIDs as $configuratorID) {
            $this->getSession()->set("getIdHook", $configuratorID);

            $configurator = $this->getConfiguratorName($configuratorID);

            $image = json_decode($configurator->getParameters(), true);
            $image = $image['image'];

            $event->add($this->render(
                            'form.html', array("arrElements" => ConfiguratorController::getConfiguratorElements($configuratorID), "background_image" => $image, "contactArr" => ConfiguratorController::getConfiguratorContact(), "configurator" => $configurator->getName(), "fromHook" => 1)
            ));
        }
    }

    public function displayResults(HookRenderEvent $event) {
        $category = $event->getArgument("category");
        $event->add($this->render(
                        'home-body.html', array("category" => $category)
        ));
    }

    public function onMainJs(HookRenderEvent $event) {
        $event->add($this->addJS('assets/dist/js/configurator.js'));
        $event->add($this->addJS('assets/dist/js/dropzone.js'));
    }

    public function onMainCss(HookRenderEvent $event) {
        $event->add($this->addCSS('assets/dist/css/configurator.css'));
        $event->add($this->addCSS('assets/dist/css/dropzone.css'));
    }

    public static function getIdHook($code) {
        $idHook = ConfiguratorHookQuery::create()
                ->findByHookCode($code);

        $ids = array();
        foreach ($idHook as $value) {
            array_push($ids, $value->getConfiguratorId());
        }

        return $ids;
    }

    protected function getConfiguratorName($id) {
        $configName = ConfiguratorQuery::create()
                ->findOneById($id);

        return $configName;
    }

}
