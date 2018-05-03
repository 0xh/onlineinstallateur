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

namespace PageBuilder;

use Propel\Runtime\Connection\ConnectionInterface;
use PageBuilder\Model\PageBuilderImageQuery;
use PageBuilder\Model\PageBuilderContentQuery;
use PageBuilder\Model\PageBuilderProductQuery;
use PageBuilder\Model\PageBuilderQuery;
use Symfony\Component\Finder\Finder;
use Thelia\Install\Database;
use Thelia\Model\Resource;
use Thelia\Model\ResourceQuery;
use Thelia\Module\BaseModule;

class PageBuilder extends BaseModule
{
    /** @var string */
    const DOMAIN_NAME = 'pagebuilder';
    const ROUTER = 'router.page_builder';

    const RESOURCES_PAGE_BUILDER = 'admin.page_builder';
    const CONFIG_ALLOW_PROFILE_ID = 'admin_profile_id';

    public function preActivation(ConnectionInterface $con = null)
    {
        $injectSql = false;

        try {
            $item = PageBuilderQuery::create()->findOne();
        } catch (\Exception $ex) {
            // The table does not exist
            $injectSql = true;
        }

        if (true === $injectSql) {
            $database = new Database($con);
            $database->insertSql(null, [__DIR__ . '/Config/thelia.sql']);
        }


        return true;
    }

    public function postActivation(ConnectionInterface $con = null)
    {
        try {
            PageBuilderQuery::create()->findOne();
            PageBuilderProductQuery::create()->findOne();
            PageBuilderImageQuery::create()->findOne();
            PageBuilderContentQuery::create()->findOne();
        } catch (\Exception $e) {
            $database = new Database($con);
            $database->insertSql(null, [__DIR__ . '/Config/thelia.sql']);
        }

        $this->addRessource(self::RESOURCES_PAGE_BUILDER);

        //Initialize the module_config
        self::setConfigValue(self::CONFIG_ALLOW_PROFILE_ID, '');
    }

    public function destroy(ConnectionInterface $con = null, $deleteModuleData = false)
    {
        $database = new Database($con);
        $database->insertSql(null, [__DIR__ . '/Config/destroy.sql']);
    }

    public function update($currentVersion, $newVersion, ConnectionInterface $con = null)
    {
        $finder = Finder::create()
            ->name('*.sql')
            ->depth(0)
            ->sortByName()
            ->in(__DIR__ . DS . 'Config' . DS . 'update');

        $database = new Database($con);

        /** @var \SplFileInfo $file */
        foreach ($finder as $file) {
            if (version_compare($currentVersion, $file->getBasename('.sql'), '<')) {
                $database->insertSql(null, $file->getPathname());
            }
        }
    }

    protected function addRessource($code)
    {
        if (null === ResourceQuery::create()->findOneByCode($code)) {
            $resource = new Resource();
            $resource->setCode($code);
            $resource->setTitle($code);
            $resource->save();
        }
    }
}
