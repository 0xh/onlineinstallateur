<?php

namespace SepaImporter\Commands;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Yaml\Exception\RuntimeException;
use Thelia\Command\ContainerAwareCommand;
use Thelia\Handler\ImportHandler;
use Thelia\Model\ImportQuery;
use Thelia\Model\Lang;
use Thelia\Model\LangQuery;
use Thelia\Tools\URL;
use DOMDocument;
use const DS;
use const THELIA_LOCAL_DIR;

class ImportETCMySht extends ContainerAwareCommand
{

    protected function configure()
    {
        $this
         ->setName("importShtPrice:start")
         ->setDescription("Starting mySht ETC import!\n");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("Command started! \n");
        $time_end = microtime(true);

        $UR = new URL();

        $local_file = $this->fetchfromFTP();

        $newFile = THELIA_LOCAL_DIR . "sepa" . DS . "import" . DS . "Artikelliste1.csv";

        $output = $this->formatFileForImport($local_file, $newFile);

        $this->importCall($output);
    }

    private function replaceDelimiters($file)
    {
        $delimiters = array('|', ';', '^', "\t");
        $delimiter  = ',';

        $str = file_get_contents($file);
        $str = str_replace($delimiters, $delimiter, $str);
        file_put_contents($file, $str);
    }

    private function formatFileForImport($output, $newFile)
    {
        $fp = fopen($newFile, "a+");
        fclose($fp);

        $row    = 1;
        if (($handle = fopen($output, "r+")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $num = count($data);
                if ($row == 1) {
                    $data[0] = "KEY" . ",";
                    $data[1] = "matchcode" . ",";
                    $data[2] = "Lieferantenartikel" . ",";
                    $data[2] = "EAN" . ",";
                    $data[2] = "Bezeichnung";
                    array_push($data, PHP_EOL);
                    file_put_contents($newFile, $data, FILE_APPEND);
                } else {
                    $data[0] = $data[0] . ", ";
                    $data[1] = intval($data[1]) . ", ";
                    $data[2] = $data[2];
                    $data[3] = $data[3];
                    $data[4] = $data[4];
                    array_push($data, PHP_EOL);

                    file_put_contents($newFile, $data, FILE_APPEND);
                }
                $row++;
            }
            fclose($handle);
        }
        return $newFile;
    }

    private function importCall($output)
    {
        $importDBReference = "thelia.import.from.xml"; //ex: thelia.export.catalog.idealo
        $importDBObject    = ImportQuery::create()->findOneByRef($importDBReference);

        if ($importDBObject === null)
            $this->pageNotFound();

        /** @var ImportHandler $importHandler */
        $importHandler = $this->getContainer()->get('thelia.import.handler');
        $import        = $importHandler->getImport($importDBObject->getId());

        $lang = "";

        /** @var String $locale */
        if ("" !== $lang) {
            if (!$this->checkLang($lang)) {
                $this->pageNotFound();
            }
        } else {
            try {
                $lang = Lang::getDefaultLanguage();
                $lang = $lang->getLocale();
            } catch (RuntimeException $ex) {
                throw new RuntimeException("No default language is defined. Please define one.");
            }
        }
        if (null === $lang = LangQuery::create()->findOneByLocale($lang)) {
            $this->pageNotFound();
        }
        $lang = $lang->getId();

        $lang = (new LangQuery)->findPk($lang);

        $filePath = new File($output);

        echo "Eveything in order, starting import. \n";

        $importEvent = $importHandler->import($import, $filePath, $lang);

        $execution_time = round(($time_end - $time_start) * 1000);
        echo "Import done. Total duration was: " . $execution_time;
    }

    private function fetchfromFTP()
    {

        $server_file = "Artikelliste.csv";
        $local_file  = THELIA_LOCAL_DIR . "sepa" . DS . "import" . DS . $server_file;


        return $local_file;
    }

}
