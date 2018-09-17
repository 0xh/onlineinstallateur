<?php

namespace HookConfigurator\Hook\Admin;

use HookConfigurator\HookConfigurator;
use Thelia\Core\Event\Hook\HookRenderBlockEvent;
use Thelia\Core\Event\Hook\HookRenderEvent;
use Thelia\Core\Hook\BaseHook;
use Thelia\Tools\URL;
use const DS;
use const THELIA_LOG_DIR;

class HookManager extends BaseHook {

    const MAX_TRACE_SIZE_IN_BYTES = 40000;

    public function onModuleConfigure(HookRenderEvent $event) {
        $logFilePath = THELIA_LOG_DIR . DS . "log-configurator.txt";
        $traces = @file_get_contents($logFilePath);
        if (false === $traces) {
            $traces = $this->translator->trans("The log file doesn't exists yet.", [], HookConfigurator::DOMAIN_NAME);
        } elseif (empty($traces)) {
            $traces = $this->translator->trans("The log file is empty.", [], HookConfigurator::DOMAIN_NAME);
        } else {
            if (strlen($traces) > self::MAX_TRACE_SIZE_IN_BYTES) {
                $traces = substr($traces, strlen($traces) - self::MAX_TRACE_SIZE_IN_BYTES);
                // Cut a first line break;
                if (false !== $lineBreakPos = strpos($traces, "\n")) {
                    $traces = substr($traces, $lineBreakPos + 1);
                }
                $traces = $this->translator->trans(
                                "(Previous log is in %file file.)\n", ['%file' => sprintf("log" . DS . "%s.log", HookConfigurator::DOMAIN_NAME)], HookConfigurator::DOMAIN_NAME
                        ) . $traces;
            }
        }

        $event->add(
                $this->render('module-configuration.html')
        );
    }

    public function onMainJs(HookRenderEvent $event) {
        $event->add($this->addJS('assets/js/configurator-back.js'));
    }

    public function onMainCss(HookRenderEvent $event) {
        $event->add($this->addCSS('assets/css/configurator-back.css'));
    }

    public function onMainTopMenuTools(HookRenderBlockEvent $event) {
        $event->add([
            'id' => 'tools_menu_hook_configurator',
            'class' => '',
            'url' => URL::getInstance()->absoluteUrl('/admin/module/HookConfigurator'),
            'title' => $this->trans('Edit configurator', [], HookConfigurator::DOMAIN_NAME)
        ]);
    }

}
