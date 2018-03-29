<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace BackOffice\Controller\Admin;

use Thelia\Controller\Admin\BaseAdminController;
use Thelia\Core\HttpFoundation\Response;
use Thelia\Core\Security\AccessManager;
use Thelia\Core\Security\Resource\AdminResources;
use Thelia\Log\Tlog;
use ZipArchive;
use const DS;
use const THELIA_LOCAL_DIR;
use const THELIA_LOG_DIR;

/**
 * Description of ExportDataFromMyshtController
 *
 * @author Catana Florin
 */
class ExportDataFromMyshtController extends BaseAdminController {
    /* @var Tlog $log */

    protected static $logger;
//    protected $username = "nmbures";
//    protected $password = "nsht123";
    protected $username = "hausf";
    protected $password = "My21Sht";
    protected $version = "2017";
    protected $info = [];
    protected $cookiefile = THELIA_LOCAL_DIR . "config" . DS . "cookies" . DS . "myshtcookieexport.txt";
    protected $csvFileLocation = THELIA_LOCAL_DIR . "config" . DS . "cookies" . DS . "temp" . DS;
    protected $csvFilename = "";
    protected $imageLocation = THELIA_LOCAL_DIR . "config" . DS . "cookies" . DS . "temp" . DS;
    protected $imageZip = "";

    const MYSHT_CSV_FILE = 'exportCsvDataMysht';
    const MYSHT_IMAGES_FILE = 'exportImageDataMysht'; 

    protected $logFilePath = THELIA_LOG_DIR . DS . "export-data-from-mysht";

    public function exportAllProducts(){
        $max_time = ini_get("max_execution_time");
        ini_set('max_execution_time', 0);
        /** @var Session $session */
        $session = $this->getRequest()->getSession();
        $date = date('m.d.Y.h.i.s.a', time());
        $this->logFilePath = $this->logFilePath . $date . ".txt";
        $this->csvFilename = $this->csvFileLocation . self::MYSHT_CSV_FILE . $date . ".csv";
        $this->imageLocation = $this->imageLocation . $date;
        if (!file_exists($this->imageLocation)) {
            mkdir($this->imageLocation, 0777, true);
        }
        
        $this->imageZip = $this->imageLocation . self::MYSHT_IMAGES_FILE . $date . ".zip";
        $this->imageLocation = $this->imageLocation . DS;
        $session->set(self::MYSHT_CSV_FILE, $this->csvFilename);
        $session->set(self::MYSHT_IMAGES_FILE, $this->imageZip);
        $this->initCsvFile($this->csvFilename);
        $this->logout();
        $idartikels = $this->getProductsRefWitoutBrand();
        
        $files = scandir($this->imageLocation);
        foreach ($files as $file) {
            @unlink($this->imageLocation . $file);
        }
        
        foreach ($idartikels as $idartikel) {
            $artnr = $this->getArtNr(trim($idartikel), true);
            if ($artnr === FALSE) {
                $this->logout();
                $this->login();
                $artnr = $this->getArtNr($idartikel, true);
            }
            if (!is_array($artnr)) {
                $this->getImage($artnr);
            }
        }
        
        @unlink($this->imageZip);
        $zip = new ZipArchive;
        $zip->open($this->imageZip, ZipArchive::CREATE);
        $files = scandir($this->imageLocation);
        
        foreach ($files as $file) {
            if ($file != "." && $file != "..")
                $zip->addFile($this->imageLocation . $file, $file);
        }
        $zip->close();
        
        
        $this->logout();
        
        ini_set('max_execution_time', $max_time);
        return $this->render("export-data-mysht");
    }
    
    public function export() {

        if ($this->getRequest()->get("idartikels")) {
            /** @var Session $session */
            $session = $this->getRequest()->getSession();
            $date = date('m.d.Y.h.i.s.a', time());
            $this->logFilePath = $this->logFilePath . $date . ".txt";
            $this->csvFilename = $this->csvFileLocation . self::MYSHT_CSV_FILE . $date . ".csv";
            $this->imageLocation = $this->imageLocation . $date;
            if (!file_exists($this->imageLocation)) {
                mkdir($this->imageLocation, 0777, true);
            }
            $this->imageLocation = $this->imageLocation . DS;
            $this->imageZip = $this->imageLocation . self::MYSHT_IMAGES_FILE . $date . ".zip";
            $session->set(self::MYSHT_CSV_FILE, $this->csvFilename);
            $session->set(self::MYSHT_IMAGES_FILE, $this->imageZip);
            $this->initCsvFile($this->csvFilename);
            $this->logout();
            $idartikels = explode(',', $this->getRequest()->get("idartikels"));

            $files = scandir($this->imageLocation);
            foreach ($files as $file) {
                @unlink($this->imageLocation . $file);
            }

            foreach ($idartikels as $idartikel) {
                $artnr = $this->getArtNr(trim($idartikel), false);
                if ($artnr === FALSE) {
                    $this->logout();
                    $this->login();
                    $artnr = $this->getArtNr($idartikel, false);
                }
                if (!is_array($artnr)) {
                    $this->getImage($artnr);
                }
            }

            @unlink($this->imageZip);
            $zip = new ZipArchive;
            $zip->open($this->imageZip, ZipArchive::CREATE);
            $files = scandir($this->imageLocation);

            foreach ($files as $file) {
                if ($file != "." && $file != "..")
                    $zip->addFile($this->imageLocation . $file, $file);
            }
            $zip->close();


            $this->logout();
        }

        return $this->render("export-data-mysht");
    }

    protected function login() {

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://www.mysht.at/21057_DE",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_NOBODY => FALSE,
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => array("username" => $this->username, "password" => $this->password, "version" => $this->version),
            CURLOPT_COOKIEFILE => $this->cookiefile,
            CURLOPT_COOKIEJAR => $this->cookiefile
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            $this->setLogger()->error("login - cURL Error #: " . $err);
        } else {
            $this->setLogger()->error("login - #: " . $response);
        }
    }

    protected function getArtNr($idartikel,$removeBrand) {
        
        $curl = curl_init();
        $searchIdArtikel = $idartikel;
        if ($removeBrand)
            $searchIdArtikel = substr($idartikel,3);

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://www.mysht.at/21069_DE.json?q=$searchIdArtikel",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "content-type: application/x-www-form-urlencoded",
            ),
            CURLOPT_COOKIEFILE => $this->cookiefile,
            CURLOPT_COOKIEJAR => $this->cookiefile,
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);
        if ($err) {
            $this->setLogger()->error("getArtNr - cURL Error #: " . $err);
        } else {
            $response = json_decode($response, true);

            if (isset($response["error"]) && $response["error"] == "nichtangemeldet") {
                $this->setLogger()->error("getArtNr - idartikel = $idartikel 'nichtangemeldet' # " . json_encode($response));
                return FALSE;
            }

            if (isset($response["data"]) && $response["data"]) {
                $this->setLogger()->error("getArtNr - idartikel = $idartikel response: " . json_encode($response));

                $resNettoRabatt = $this->getNettoRabatt($response["data"][0]["MegabildNr"], $idartikel);

                $arrayData = array("idartikel" => $idartikel, "MegabildNr" => $response["data"][0]["MegabildNr"], "Lieferantename" => $response["data"][0]["Lieferantename"],
                    "title" => $response["data"][0]["Zeile1"],
                    "description" => $response["data"][0]["Zeile2"] . " " . $response["data"][0]["agzeile1"],
                    "stock" => $response["data"][0]["SAPLiefermenge"] ? $response["data"][0]["SAPLiefermenge"] : 0,
                    "rabatt" => $resNettoRabatt["rabatt"],
                    "purchase_price" => $resNettoRabatt["netto"],
                    "price" => $response["data"][0]["aktpreis"]);

                $this->exportToCsv($this->csvFilename, $arrayData);
                return $response["data"][0]["MegabildNr"];
            } else {
                $this->setLogger()->error("getArtNr - idartikel = $idartikel servererror: " . json_encode($response));
                return array(0 => @$response["servererror"]);
            }
        }
    }

    protected function getNettoRabatt($artnr, $idartikel) {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://www.mysht.at/21051_DE",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => array("username" => $this->username, "password" => $this->password, "version" => $this->version, "artnr" => $artnr),
            CURLOPT_COOKIEFILE => $this->cookiefile,
            CURLOPT_COOKIEJAR => $this->cookiefile,
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            $this->setLogger()->error("getRabatt - cURL Error #: " . $err);
        } else {
            $response = json_decode($response, true);

            if ($response["status"] == "NOSESSION") {
                $this->setLogger()->error("status = NOSESSION #: logout -> login ");
                $this->logout();
                $this->login();
                $this->getNettoRabatt($artnr, $idartikel);
            }

            $netto = 0;
            $rabatt = 0;
            if (isset($response["rabatt"])) {
                $this->setLogger()->error("getRabatt - idartikel = $idartikel response #: rabatt = " . $response["rabatt"] . ". " . json_encode($response));
                $rabatt = $response["rabatt"];
            } else {
                $this->setLogger()->error("getRabatt - idartikel = $idartikel #: rabatt = 0. " . json_encode($response));
            }

            if (isset($response["netto"])) {
                $this->setLogger()->error("getnetto - idartikel = $idartikel response #: netto = " . $response["netto"] . ". " . json_encode($response));
                $netto = $response["netto"];
            } else {
                $this->setLogger()->error("getnetto - idartikel = $idartikel #: netto = 0. " . json_encode($response));
            }

            return array("netto" => $netto, "rabatt" => $rabatt);
        }
    }

    protected function getImage($artnr) {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://www.mysht.at/1478_DE.htm?nurartnr=$artnr&size=g",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_COOKIEFILE => $this->cookiefile,
            CURLOPT_COOKIEJAR => $this->cookiefile,
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        $artnr = preg_replace('/[^a-zA-Z0-9_ -]/s', '', $artnr);
        if (strlen($response) > 43) {
            $imageFile = $this->imageLocation . $artnr . ".jpg";

            $saveImage = @fopen($imageFile, 'w');
            @fwrite($saveImage, $response);
            @fclose($saveImage);
        }
    }

    public function setLogger() {
        if (self::$logger == null) {
            self::$logger = Tlog::getNewInstance();

            self::$logger->setPrefix("#DATE #HOUR: ");
            self::$logger->setDestinations("\\Thelia\\Log\\Destination\\TlogDestinationRotatingFile");
            self::$logger->setConfig("\\Thelia\\Log\\Destination\\TlogDestinationRotatingFile", 0, $this->logFilePath);
            self::$logger->setLevel(Tlog::ERROR);
        }
        return self::$logger;
    }

    public function logout() {
        @unlink($this->cookiefile);
    }

    function initCsvFile($file) {
        $fp = fopen($file, 'w');
        $fields = array("idartikel", "MegabildNr", "Lieferantename", "title", "description", "stock", "discount", "purchase_price", "price");
        fputcsv($fp, $fields);
        fclose($fp);
    }

    function exportToCsv($csvFile, $arrayData) {
        $fp = fopen($csvFile, 'a');
        fputcsv($fp, $arrayData);
        fclose($fp);
    }

    function downloadCsv() {

        if (null !== $response = $this->checkAuth(AdminResources::MODULE, 'atos', AccessManager::UPDATE)) {
            return $response;
        }
        $session = $this->getRequest()->getSession();
        if ($session->has(self::MYSHT_CSV_FILE) == true) {
            $file = $session->get(self::MYSHT_CSV_FILE);
            $filePath = explode(DS, $file);
            $filename = $filePath[sizeof($filePath) - 1];
            return Response::create(@file_get_contents($file), 200, array(
                        'Content-type' => "text/plain",
                        'Content-Disposition' => sprintf("Attachment;filename=" . $filename)
            ));
        } else {
            return $this->errorPage($this->getTranslator()->trans("No csv file has been found"), 403);
        }
    }

    function downloadImages() {

        if (null !== $response = $this->checkAuth(AdminResources::MODULE, 'atos', AccessManager::UPDATE)) {
            return $response;
        }
        $session = $this->getRequest()->getSession();
        if ($session->has(self::MYSHT_IMAGES_FILE) == true) {
            $file = $session->get(self::MYSHT_IMAGES_FILE);
            $filePath = explode(DS, $file);
            $filename = $filePath[sizeof($filePath) - 1];
            return Response::create(@file_get_contents($file), 200, array(
                        'Content-type' => "text/plain",
                        'Content-Disposition' => sprintf('Attachment;filename='.$filename)
            ));
        } else {
            return $this->errorPage($this->getTranslator()->trans("No images.zip file has been found"), 403);
        }
    }

}
