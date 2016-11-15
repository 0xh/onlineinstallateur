<?php
/*************************************************************************************/
/*      This file is part of the Thelia package.                                     */
/*                                                                                   */
/*      Copyright (c) OpenStudio                                                     */
/*      email : dev@thelia.net                                                       */
/*      web : http://www.thelia.net                                                  */
/*                                                                                   */
/*      For the full copyright and license information, please view the LICENSE.txt  */
/*      file that was distributed with this source code.                             */
/*************************************************************************************/

namespace HookToolbar\Controller;

use Thelia\Controller\Admin\BaseAdminController;
use Thelia\Core\Event\Cache\CacheEvent;
use Thelia\Core\Event\TheliaEvents;
use Thelia\Core\Security\AccessManager;
use Thelia\Core\Security\Resource\AdminResources;
use Thelia\Model\ConfigQuery;

/**
 * @author Franck Allimant <franck@cqfdev.fr>
 */
class ToolbarController extends BaseAdminController
{
    protected function doFlushCache($dir) {

        if (null !== $result = $this->checkAuth(AdminResources::ADVANCED_CONFIGURATION, [], AccessManager::UPDATE)) {
            return $result;
        }

        $event = new CacheEvent($dir);

        $this->dispatch(TheliaEvents::CACHE_CLEAR, $event);

        return null;
    }

    public function flushInternalAction()
    {
       return $this->doFlushCache($this->container->getParameter("kernel.cache_dir"));
    }

    public function flushAssetsAction()
    {
        return $this->doFlushCache(THELIA_WEB_DIR . "assets");
    }

    public function flushImagesAndDocumentsAction()
    {
        $this->doFlushCache(THELIA_WEB_DIR . ConfigQuery::read('image_cache_dir_from_web_root', 'cache'));

        return $this->doFlushCache(THELIA_WEB_DIR . ConfigQuery::read('document_cache_dir_from_web_root', 'cache'));
    }
}