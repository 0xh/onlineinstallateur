<?php

namespace Thelia\Model;

use ErrorException;
use Propel\Runtime\Connection\ConnectionInterface;
use Thelia\Core\Translation\Translator;
use Thelia\ImportExport\Import\AbstractImport;
use Thelia\Model\Base\Import as BaseImport;
use Thelia\Model\Tools\ModelEventDispatcherTrait;
use Thelia\Model\Tools\PositionManagementTrait;

class Import extends BaseImport
{
    use PositionManagementTrait;
    use ModelEventDispatcherTrait;
    
    protected static $cache;

    public function getHandleClassInstance()
    {
        $class = $this->getHandleClass();

        if ($class[0] !== '\\') {
            $class = '\\' . $class;
        }

        if (!class_exists($class)) {
            $this->delete();

            throw new ErrorException(
                Translator::getInstance()->trans(
                    'The class "%class" doesn\'t exist',
                    [
                        '%class' => $class
                    ]
                )
            );
        }

        $instance = new $class();

        if (!$instance instanceof AbstractImport) {
            $this->delete();

            throw new ErrorException(
                Translator::getInstance()->trans(
                    'The class "%class" must extend %baseClass',
                    [
                        '%class' => $class,
                        '%baseClass' => 'Thelia\\ImportExport\\Export\\AbstractImport',
                    ]
                )
            );
        }

        return $instance;
    }

    /**
     * {@inheritDoc}
     */
    public function preInsert(ConnectionInterface $con = null)
    {
        $this->setPosition($this->getNextPosition());

        return true;
    }

    public function addCriteriaToPositionQuery($query)
    {
        $query->filterByImportCategoryId($this->getImportCategoryId());
    }
    
    public function useFulfilmentCenter()
    {
        if (static::$cache === null) {
            static::$cache = $this->getHandleClassInstance();
        }

        return static::$cache->useFulfilmentCenter();
    }
}
