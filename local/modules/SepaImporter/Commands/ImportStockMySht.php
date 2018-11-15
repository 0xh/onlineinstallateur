<?php

namespace SepaImporter\Commands;

use Symfony\Component\Console\Input\InputArgument;
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
use const DS;
use const THELIA_LOCAL_DIR;

class ImportStockMySht extends ContainerAwareCommand
{

    protected function configure()
    {
        $this
         ->setName("importShtStock:start")
         ->setDescription("Starting mySht stock import!\n")
         ->addArgument(
             'startline', InputArgument::REQUIRED, 'Specify file start line')
         ->addArgument(
             'stopline',  InputArgument::REQUIRED, 'Specify file stop line');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("Command started! \n");
        $startline = $input->getArgument('startline');
        $stopline = $input->getArgument('stopline');
        $UR = new URL();

        $local_file = $this->fetchfromFTP();

        if (file_exists(THELIA_LOCAL_DIR . "sepa" . DS . "import" . DS . "Artikelverfuegbarkeit1.csv")) {
            echo "File already existed, deleting \n";
            unlink(THELIA_LOCAL_DIR . "sepa" . DS . "import" . DS . "Artikelverfuegbarkeit1.csv");
        }

        $newFile = THELIA_LOCAL_DIR . "sepa" . DS . "import" . DS . "Artikelverfuegbarkeit1.csv";

        if ($local_file != null) {
            $output = $this->formatFileForImport($local_file, $newFile, $startline, $stopline);
        }

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

    private function formatFileForImport($output, $newFile, $startline, $stopline)
    {
        $fp = fopen($newFile, "a+");
        fclose($fp);

        $row    = 1;
        if (($handle = fopen($output, "r+")) !== FALSE) {

            while (($data = fgetcsv($handle, 10000, ";")) !== FALSE) {
                $num = count($data);
                if ($row == 1) {
                    $data[0] = "KEY" . ",";
                    $data[1] = "verf.Menge" . ",";
                    $data[2] = "matchcode";
                    array_push($data, PHP_EOL);
                    file_put_contents($newFile, $data, FILE_APPEND);
                } else if($row >= $startline && $row <= $stopline){
                    $data[0] = $data[0] . ",";
                    $data[1] = intval($data[1]) . ",";
                    $data[2] = $data[2];
                    array_push($data, PHP_EOL);

                    file_put_contents($newFile, $data, FILE_APPEND);
                }
                $row++;
                if($row % 1000 == 0 )
                    if($row >= $startline && $row <= $stopline)
                            echo "formated ".$row." lines \n";
                        else
                            echo "skiped ".$row." lines \n";
            }
            fclose($handle);
        }
        return $newFile;
    }

    private function importCall($output)
    {
        $importDBReference = "thelia.import.sht.stock"; //ex: thelia.export.catalog.idealo
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

        $server_file = "Artikelverfuegbarkeit.csv";
        $local_file  = THELIA_LOCAL_DIR . "sepa" . DS . "import" . DS . $server_file;

        $ftp_user   = "mmai1018";
        $ftp_pass   = "PreiCra!2018";
        $ftp_server = "ftp.sht-net.at";
        $ftp_conn   = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
        $login      = ftp_login($ftp_conn, $ftp_user, $ftp_pass);
        ftp_pasv($ftp_conn, true) or die("Cannot switch to passive mode");

        ftp_chdir($ftp_conn, "/preiscrawler");
        if (ftp_get($ftp_conn, $local_file, $server_file, FTP_ASCII)) {
            echo "Successfully written to $local_file. \n";
        } else {
            echo "Error downloading $server_file.";
        }
        ftp_close($ftp_conn);


        return $local_file;
    }

}
