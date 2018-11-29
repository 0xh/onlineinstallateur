<?php

namespace SepaImporter\Handler;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\File\File;
use Thelia\Core\Archiver\ArchiverInterface;
use Thelia\Core\Archiver\ArchiverManager;
use Thelia\Core\Event\ImportEvent;
use Thelia\Core\Event\TheliaEvents;
use Thelia\Core\Serializer\SerializerInterface;
use Thelia\Core\Serializer\SerializerManager;
use Thelia\Core\Translation\Translator;
use Thelia\Form\Exception\FormValidationException;
use Thelia\ImportExport\Import\AbstractImport;
use Thelia\Model\Import;
use Thelia\Model\ImportCategoryQuery;
use Thelia\Model\ImportQuery;
use Thelia\Model\Lang;
use Thelia\Handler\ImportHandler;

/**
 * Class SepaImportHandler
 * @author Emanuel Plopu
 */
class SepaImportHandler extends ImportHandler
{

    public $start_idx, $stop_idx;

    /**
     * Process import
     *
     * @param \Thelia\ImportExport\Import\AbstractImport  $import     An import
     * @param \Thelia\Core\Serializer\SerializerInterface $serializer A serializer interface
     *
     * @return array List of errors
     */
    protected function processImport(AbstractImport $import, SerializerInterface $serializer)
    {
        $errors = [];

        $import->setData($serializer->unserialize($import->getFile()->openFile('r')));

        foreach ($import as $idx => $data) {

            if ($idx >= $this->start_idx && $idx <= $this->stop_idx) {
                $import->checkMandatoryColumns($data);
                echo $idx . ' ';
                $error = $import->importData($data);
                if ($error !== null) {
                    $errors[] = $error;
                }
            } else {
                if ($idx % 1000 == 0)
                    if ($idx < $this->start_idx || $this->stop_idx)
                        echo "skiped " . $idx . " lines \n";
            }
        }

        return $errors;
    }

}
