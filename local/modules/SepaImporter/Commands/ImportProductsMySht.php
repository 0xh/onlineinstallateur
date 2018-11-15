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
use ZipArchive;
use const DS;
use const THELIA_LOCAL_DIR;

class ImportProductsMySht extends ContainerAwareCommand
{

    protected function configure()
    {
        $this
         ->setName("importShtProducts:start")
         ->setDescription("Starting mySht stock import!\n");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("Command started\n !");


        $UR = new URL();

        $url = "https://www.sht-gruppe.at/alleartikel.zip";

        $current_date = date("Y-m-d H:i:s");
        $zip_name     = "import" . md5($current_date) . ".zip";
        $zipFile      = THELIA_LOCAL_DIR . "sepa" . DS . "import" . DS . "ShtProducts" . DS . $zip_name;
        $zipResource  = fopen($zipFile, "w");
        $ch           = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FAILONERROR, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_AUTOREFERER, true);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_FILE, $zipResource);
        $page         = curl_exec($ch);
        if (!$page) {
            echo "Error :- " . curl_error($ch);
        }
        curl_close($ch);
        $zip         = new ZipArchive;
        $extractPath = THELIA_LOCAL_DIR . "sepa" . DS . "import" . DS . "ShtProducts";
        if ($zip->open($zipFile) != "true") {
            echo "Error :- Unable to open the Zip File";
        }
        $zip->extractTo($extractPath);
        $zip->close();

        echo"Zip fetched and extracted. \n";

        $dir = THELIA_LOCAL_DIR . "sepa" . DS . "import" . DS. "ShtProducts" . DS . "wwwroot" . DS;
        if (is_dir($dir)) {
            if ($dh = opendir($dir)) {
                while (($file = readdir($dh)) !== false) {
                    if ($file !== "." && $file !== "..") {
                        echo "opening folder, getting file " . $file . "\n";
                        echo $dir.$file."\n";
                        $importDBReference = "thelia.import.from.xml"; //ex: thelia.export.catalog.idealo
                        //get export Object from DB based on reference
                        $importDBObject    = ImportQuery::create()->findOneByRef($importDBReference);

                        if ($importDBObject === null)
                            $this->pageNotFound();

                        //get the service for the thelia import handler
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
                                // @todo generate error page
                                throw new RuntimeException("No default language is defined. Please define one.");
                            }
                        }
                        //find language in db
                        if (null === $lang = LangQuery::create()->findOneByLocale($lang)) {
                            $this->pageNotFound();
                        }
                        $lang = $lang->getId();

                        $lang = (new LangQuery)->findPk($lang);

                        $filePath = new File($dir . $file);

                        echo "Eveything in order, starting import. \n";

                        $importEvent = $importHandler->import($import, $filePath, $lang);

                        echo "Import done.";
                    }
                }
            }
            closedir($dh);
        }
        echo "Zip operations completed, deleting archive! ";
        unlink($zipFile);
    }

}
