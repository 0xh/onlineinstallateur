<?php

namespace PageBuilder\Model;

use PageBuilder\Model\Base\PageBuilder as BasePageBuilder;
use Thelia\Model\Tools\ModelEventDispatcherTrait;
use Thelia\Model\Tools\PositionManagementTrait;
use Thelia\Model\Tools\UrlRewritingTrait;

class PageBuilder extends BasePageBuilder
{
    use UrlRewritingTrait;
    use ModelEventDispatcherTrait;
    use PositionManagementTrait;
    public function getRewrittenUrlViewName()
    {
        return 'page_builder';
    }

}
