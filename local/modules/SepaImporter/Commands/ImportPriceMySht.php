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

class ImportPriceMySht extends ContainerAwareCommand
{

    protected function configure()
    {
        $this
         ->setName("importShtPrice:start")
         ->setDescription("Starting mySht price import!\n");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("Command started! \n");

        $UR = new URL();

        $local_file = $this->fetchfromFTP();

        if (file_exists(THELIA_LOCAL_DIR . "sepa" . DS . "import" . DS . "Mappe2new.csv")) {
            unlink(THELIA_LOCAL_DIR . "sepa" . DS . "import" . DS . "Mappe2new.csv");
            $output->writeln("File already existed, deleting \n");
        }

        $newFile = THELIA_LOCAL_DIR . "sepa" . DS . "import" . DS . "Mappe2new.csv";

        $output->writeln("formating input file \n");
        $importFile = $this->formatFileForImport($local_file, $newFile);
        $output->writeln("complete! \n");
        $this->importCall($importFile);
        $output->writeln("price import completed \n");
        unlink($newFile);
        unlink($output);
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
            while (($data = fgetcsv($handle, 10000, ",")) !== FALSE) {
                $num = count($data);
                if ($row == 1) {
                    $data[0] = "MATNR" . ",";
                    $data[1] = "YE49_plus_7";
                    array_push($data, PHP_EOL);
                    file_put_contents($newFile, $data, FILE_APPEND);
                } else {
                    $data[0] = $data[0] . ",";
                    $data[1] = $data[1];
                    array_push($data, PHP_EOL);

                    file_put_contents($newFile, $data, FILE_APPEND);
                }
                $row++;
                if($row % 1000 == 0 )
                    echo "formated ".$row." lines \n";
            }
            fclose($handle);
        }
        return $newFile;
    }

    private function importCall($output)
    {
        $importDBReference = "thelia.import.sht.price"; //ex: thelia.export.catalog.idealo
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

        echo "Import done.";
    }

    private function fetchfromFTP()
    {

        $server_file = "Mappe2.csv";
        $local_file  = THELIA_LOCAL_DIR . "sepa" . DS . "import" . DS . $server_file;

//        $ftp_user   = "mmai1018";
//        $ftp_pass   = "PreiCra!2018";
//        $ftp_server = "ftp.sht-net.at";
//        $ftp_conn   = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
//        $login      = ftp_login($ftp_conn, $ftp_user, $ftp_pass);
//        ftp_pasv($ftp_conn, true) or die("Cannot switch to passive mode");
//
//        ftp_chdir($ftp_conn, "/preiscrawler");
//        if (ftp_get($ftp_conn, $local_file, $server_file, FTP_ASCII)) {
//            echo "Successfully written to $local_file. \n";
//        } else {
//            echo "Error downloading $server_file.";
//        }
//        ftp_close($ftp_conn);

        return $local_file;
    }

}
