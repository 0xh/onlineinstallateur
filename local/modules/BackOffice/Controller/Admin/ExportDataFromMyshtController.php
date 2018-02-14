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
    protected $csvFile = THELIA_LOCAL_DIR . "config" . DS . "cookies" . DS . "temp" . DS . "exportCsvDataMysht.csv";
    protected $imageLocation = THELIA_LOCAL_DIR . "config" . DS . "cookies" . DS . "temp" . DS . "images" . DS;
    protected $imageZip = THELIA_LOCAL_DIR . "config" . DS . "cookies" . DS . "temp" . DS . "images.zip";

    public function export() {

        if ($this->getRequest()->get("idartikels")) {
            $this->logout();
            $idartikels = explode(',', $this->getRequest()->get("idartikels"));

            foreach ($idartikels as $idartikel) {
                $artnr = $this->getArtNr(trim($idartikel));
                if ($artnr === FALSE) {
                    $this->logout();
                    $this->login();
                    $artnr = $this->getArtNr($idartikel);
                }
                if (!is_array($artnr)) {
                    $this->getImage($artnr);
                }
            }

            $zip = new ZipArchive;
            $zip->open($this->imageZip, ZipArchive::CREATE);
            $files = scandir($this->imageLocation);

            foreach ($files as $file) {
                if ($file != "." && $file != "..")
                    $zip->addFile($this->imageLocation . $file, $file);
            }
            $zip->close();

            $this->exportToCsv();
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

    protected function getArtNr($idartikel) {

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://www.mysht.at/21069_DE.json?q=$idartikel",
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

            if ($response["data"]) {
                $this->setLogger()->error("getArtNr - idartikel = $idartikel response: " . json_encode($response));
                array_push($this->info, array("idartikel" => $idartikel, "MegabildNr" => $response["data"][0]["MegabildNr"], "Lieferantename" => $response["data"][0]["Lieferantename"],
                    "title" => $response["data"][0]["Zeile1"],
                    "description" => $response["data"][0]["Zeile2"] . " " . $response["data"][0]["agzeile1"],
                    "stock" => $response["data"][0]["SAPLiefermenge"] ? $response["data"][0]["SAPLiefermenge"] : 0,
                    "price" => $response["data"][0]["aktpreis"]));
                return $response["data"][0]["MegabildNr"];
            } else {
                $this->setLogger()->error("getArtNr - idartikel = $idartikel servererror: " . json_encode($response));
                return array(0 => $response["servererror"]);
            }
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

        $imageFile = $this->imageLocation . $artnr . ".jpg";

        $saveImage = fopen($imageFile, 'w');
        fwrite($saveImage, $response);
        fclose($saveImage);
    }

    public function setLogger() {
        if (self::$logger == null) {
            self::$logger = Tlog::getNewInstance();

            $logFilePath = THELIA_LOG_DIR . DS . "update-stock-mysht.txt";

            self::$logger->setPrefix("#DATE #HOUR: ");
            self::$logger->setDestinations("\\Thelia\\Log\\Destination\\TlogDestinationRotatingFile");
            self::$logger->setConfig("\\Thelia\\Log\\Destination\\TlogDestinationRotatingFile", 0, $logFilePath);
            self::$logger->setLevel(Tlog::ERROR);
        }
        return self::$logger;
    }

    public function logout() {
        @unlink($this->cookiefile);
    }

    function exportToCsv() {
        $fp = fopen($this->csvFile, 'w');

        $fields = array("idartikel", "MegabildNr", "Lieferantename", "title", "description", "stock", "price");
        fputcsv($fp, $fields);

        foreach ($this->info as $fields) {
            fputcsv($fp, $fields);
        }

        fclose($fp);
    }

    function downloadCsv() {

        if (null !== $response = $this->checkAuth(AdminResources::MODULE, 'atos', AccessManager::UPDATE)) {
            return $response;
        }

        return Response::create(@file_get_contents($this->csvFile), 200, array(
                    'Content-type' => "text/plain",
                    'Content-Disposition' => sprintf('Attachment;filename=export-csv-data-mysht.csv')
        ));
    }

    function downloadImages() {

        if (null !== $response = $this->checkAuth(AdminResources::MODULE, 'atos', AccessManager::UPDATE)) {
            return $response;
        }

        return Response::create(@file_get_contents($this->imageZip), 200, array(
                    'Content-type' => "text/plain",
                    'Content-Disposition' => sprintf('Attachment;filename=imagesMysht.zip')
        ));
    }

}
