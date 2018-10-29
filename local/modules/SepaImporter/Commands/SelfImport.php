<?php

namespace SepaImporter\Commands;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Yaml\Exception\RuntimeException;
use Thelia\Command\ContainerAwareCommand;
use Thelia\Core\DependencyInjection\Compiler\RegisterSerializerPass;
use Thelia\Core\Serializer\Serializer\CSVSerializer;
use Thelia\Core\Serializer\SerializerManager;
use Thelia\Handler\ImportHandler;
use Thelia\Model\ImportQuery;
use Thelia\Model\Lang;
use Thelia\Model\LangQuery;
use Thelia\Tools\URL;
use const DS;
use const THELIA_LOCAL_DIR;

class SelfImport extends ContainerAwareCommand
{

    protected function configure()
    {
        $this
         ->setName("selfimport:start")
         ->setDescription("Script will start importing.");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("Running Command !");


        $UR = new URL();

//          $url = "https://netix.dl.sourceforge.net/project/fotohound/fotohound/fotohound-1.0.6/FotoHound-1.0.6.zip";
        // //        $url = "https://www.sht-gruppe.at/alleartikel.zip";

        $current_date = date("Y-m-d H:i:s");
        // $zip_name     = "import" . md5($current_date) . ".zip";
        // $zipFile      = THELIA_LOCAL_DIR . "sepa" . DS . "import" . DS . $zip_name;
        // $zipResource = fopen($zipFile, "w");
        // $ch          = curl_init();
        // curl_setopt($ch, CURLOPT_URL, $url);
        // curl_setopt($ch, CURLOPT_FAILONERROR, true);
        // curl_setopt($ch, CURLOPT_HEADER, 0);
        // curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        // curl_setopt($ch, CURLOPT_AUTOREFERER, true);
        // curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
        // curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        // curl_setopt($ch, CURLOPT_FILE, $zipResource);
        // $page        = curl_exec($ch);
        // if (!$page) {
        //     echo "Error :- " . curl_error($ch);
        // }
        // curl_close($ch);
        // $zip         = new ZipArchive;
        // $extractPath = THELIA_LOCAL_DIR . "sepa" . DS . "import";
        // if ($zip->open($zipFile) != "true") {
        //     echo "Error :- Unable to open the Zip File";
        // }
        // $zip->extractTo($extractPath);
        // $zip->close();

        $dir = THELIA_LOCAL_DIR . "sepa" . DS . "import" . "/wwwroot/";
        if (is_dir($dir)) {
            if ($dh = opendir($dir)) {
                while (($file = readdir($dh)) !== false) {
                    if ($file !== "." && $file !== "..") {

//                        $doc        = new DOMDocument();
//                        $doc->load($dir . $file);
//                        $products = $doc->getElementsByTagName("produkt");
//
//
//                        foreach ($products as $product) {
//                            var_dump($product); die;
//                            $arrValue = explode("\n", $product->nodeValue);
//                            unset($arrValue[0]);
//                            unset($arrValue[count($arrValue)]);
//                            $arrKey   = [
//                             "megabildnr", "matchcode", "zeile1", "zeile2", "ausschreibungstext",
//                             "bruttopreis","warengruppe", "warengruppetext", "versandfaehig"
//                            ];
//                            $data     = array_combine($arrKey, $arrValue);
//                            unset($data);

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

                        $importEvent = $importHandler->import($import, $filePath, $lang);

                        echo "Import done.";
                    }
                }
            }
            closedir($dh);
        }


        //            unlink($zipFile);
    }

//    public function parseToArray(SimpleXMLElement $parent)
//    {
//        $array = array();
//
//        foreach ($parent as $name => $element) {
//            ($node = & $array[$name]) && (1 === count($node) ? $node = array($node) : 1) && $node = & $node[];
//            $node = $element->count() ? $this->parseToArray($element) : trim($element);
//        }
//        return $array;
//    }
}
