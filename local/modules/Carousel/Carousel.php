<?php

/* * ********************************************************************************** */
/*      This file is part of the Thelia package.                                     */
/*                                                                                   */
/*      Copyright (c) OpenStudio                                                     */
/*      email : dev@thelia.net                                                       */
/*      web : http://www.thelia.net                                                  */
/*                                                                                   */
/*      For the full copyright and license information, please view the LICENSE.txt  */
/*      file that was distributed with this source code.                             */
/* * ********************************************************************************** */

namespace Carousel;

use Propel\Runtime\Connection\ConnectionInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Thelia\Install\Database;
use Thelia\Model\ConfigQuery;
use Thelia\Model\Country;
use Thelia\Model\ModuleQuery;
use Thelia\Model\AreaDeliveryModuleQuery;
use Thelia\Module\BaseModule;
use Thelia\Core\Template\TemplateDefinition;
use Thelia\Log\Tlog;

/**
 * Class Carousel
 * @package Carousel
 * @author Franck Allimant <franck@cqfdev.fr>
 */
class Carousel extends BaseModule
{

    /** @var string */
    const DOMAIN_NAME = 'carousel';

    /**
     * @param ConnectionInterface $con
     */
    public function preActivation(ConnectionInterface $con = null)
    {
//        if (! $this->getConfigValue('is_initialized', false)) {
        $database = new Database($con);
        Tlog::getInstance()->err("pre-activation running");
        $database->insertSql(null, array(__DIR__ . '/Config/thelia.sql'));

        $this->setConfigValue('is_initialized', true);
//        }

        return true;
    }

    public function destroy(ConnectionInterface $con = null, $deleteModuleData = false)
    {
        $database = new Database($con);

        $database->insertSql(null, array(__DIR__ . '/Config/sql/destroy.sql'));
    }

    public function getUploadDir()
    {
        $uploadDir = ConfigQuery::read('images_library_path');

        if ($uploadDir === null) {
            $uploadDir = THELIA_LOCAL_DIR . 'media' . DS . 'images';
        } else {
            $uploadDir = THELIA_ROOT . $uploadDir;
        }

        return $uploadDir . DS . Carousel::DOMAIN_NAME;
    }

    /**
     * @param string $currentVersion
     * @param string $newVersion
     * @param ConnectionInterface $con
     * @author Thomas Arnaud <tarnaud@openstudio.fr>
     */
    public function update($currentVersion, $newVersion, ConnectionInterface $con = null)
    {
        $uploadDir  = $this->getUploadDir();
        $fileSystem = new Filesystem();

        if (!$fileSystem->exists($uploadDir) && $fileSystem->exists(__DIR__ . DS . 'media' . DS . 'carousel')) {
            $finder = new Finder();
            $finder->files()->in(__DIR__ . DS . 'media' . DS . 'carousel');

            $fileSystem->mkdir($uploadDir);

            /** @var SplFileInfo $file */
            foreach ($finder as $file) {
                copy($file, $uploadDir . DS . $file->getRelativePathname());
            }
            $fileSystem->remove(__DIR__ . DS . 'media');
        }
    }

    public function getHooks()
    {
        return array(
         array(
          "type"        => TemplateDefinition::FRONT_OFFICE,
          "code"        => "carousel-placement",
          "title"       => array(
           "fr_FR" => "Carousel hook",
           "en_US" => "Carousel hook",
           "de_DE" => "Carousel hook",
          ),
          "description" => array(
           "fr_FR" => "Hook for displaying Carousel hook",
           "en_US" => "Hook for displaying Carousel hook",
           "de_DE" => "Hook for displaying Carousel hook",
          ),
          "active"      => true
         ),
         array(
          "type"        => TemplateDefinition::FRONT_OFFICE,
          "code"        => "carousel-hook-placement",
          "title"       => array(
           "en_US" => "Carousel Placement hook",
           "de_DE" => "Carousel Ergebnisse hook",
          ),
          "description" => array(
           "en_US" => "",
           "de_DE" => "",
          ),
          "chapo"       => array(
           "en_US" => "",
           "de_DE" => "",
          ),
          "block"       => false,
          "active"      => true
         )
         )
        ;
    }

}
