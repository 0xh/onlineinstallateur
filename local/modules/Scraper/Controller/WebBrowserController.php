<?php

namespace Scraper\Controller;

use Scraper\Config\ScraperConst;
use Thelia\Controller\Admin\BaseAdminController;
use Thelia\Log\Tlog;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of WebBrowserController
 *
 * @author Catana Florin
 */
class WebBrowserController extends BaseAdminController {
    /*
     * @var Tlog $logger 
     */

    protected static $logger;
    private $logFile = ScraperConst::SCRAPER_LOG_DIR;
    private $zipFile = ScraperConst::SCRAPER_ARHIVE_DIR;
    private $imageFile = ScraperConst::SCRAPER_IMAGES_DIR;
    private $videoFile = ScraperConst::SCRAPER_VIDEO_DIR;
    private $curl;
    private $cookiefile = ScraperConst::SCRAPER_COOKIE_DIR;

    /*
     * date/time when to create the files
     */
    private $date;

    /*
     * $nameLogFile: name log file without extension
     * $nameZipFile: name zip file
     * $nameImageFile: name image file
     * $nameVideoFile: name video file
     */

    function __construct($nameLogFile = "scraper-log", $nameZipFile = null, $nameImageFile = null, $nameVideoFile = null) {

        $this->date = date('_m.d.Y_H.i.s', time());

        $this->setLogFile($nameLogFile . $this->date . ".txt");

        if ($nameZipFile) {
            $this->setZipFile($nameZipFile . $this->date . ".zip");
        }

        if ($nameImageFile) {
            $this->setZipFile($nameImageFile . $this->date . ".jpg");
        }

        if ($nameVideoFile) {
            $this->setZipFile($nameVideoFile . $this->date . ".avi");
        }
    }

    public function test() {

        echo '<pre>';
        $this->init();
//        $r = $this->getPage("https://ro.yahoo.com/?p=us");
        $urlLogin = "https://www.mysht.at/21057_DE";
        $fields = array("username" => "hausf", "password" => "My21Sht", "version" => "2017");
        $this->login($urlLogin, $fields);
        $r = $this->getPage("https://www.mysht.at/myprofishop/suchergebnis?meintensie=&q=30079000");
        $r = $this->getPage("https://www.mysht.at/myprofishop/suchergebnis?meintensie=&q=G28794");
//        $r = $this->getPage("https://www.mysht.at/21069_DE.json?q=G30079");
//

        $html = new SimpleHtmlDomController();
        $html->load($r);
//        var_dump($html);
        $rows = $html->find('link');
        foreach ($rows as $value) {
            var_dump($value->attr);
            var_dump($value->_);
//            if ($value->attr["href"] == "https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css") {
//                var_dump($value);
//            }
            //nodes
            //parent
            //attr
        }
        $this->close();
        $this->logout();
        die("end");
    }

    /*
     * $urlLogin: link to login
     * $fields: array with user, pass, version, .... params for login
     */

    public function login($urlLogin, $fields, $typeRequest = "POST") {

        $this->cookiefile .= "cookie" . $this->date . ".txt";

        curl_setopt_array($this->curl, array(
            CURLOPT_URL => $urlLogin,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_NOBODY => FALSE,
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $typeRequest,
            CURLOPT_POSTFIELDS => $fields,
            CURLOPT_COOKIEFILE => $this->cookiefile,
            CURLOPT_COOKIEJAR => $this->cookiefile
        ));

        $response = curl_exec($this->curl);
        $err = curl_error($this->curl);

        if ($err) {
            $this->setLogger()->error("Error response #: " . $err);
        } else {
            $this->setLogger()->error("Success response #: " . $response);
        }
    }

    public function getPage($url, $fields = null, $typeRequest = "POST") {

        curl_setopt_array($this->curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_NOBODY => FALSE,
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $typeRequest,
            CURLOPT_POSTFIELDS => $fields,
            CURLOPT_COOKIEFILE => $this->cookiefile,
            CURLOPT_COOKIEJAR => $this->cookiefile
        ));

        $response = curl_exec($this->curl);
        $err = curl_error($this->curl);

        if ($err) {
            $this->setLogger()->error("Error response #: " . $err);
        } else {
            $this->setLogger()->error("Success response #: " . $response);
        }

        return $response;
    }

    public function logout() {
        if (!unlink($this->cookiefile)) {
            $this->setLogger()->error("Error deleting #: " . $this->cookiefile);
        } else {
            $this->setLogger()->error("Success deleted: " . $this->cookiefile);
        }
    }

    public function init() {
        $this->curl = curl_init();
    }

    public function close() {
        @curl_close($this->curl);
    }

    /*
     * set logger in file logFile
     */

    public function setLogger() {
        if (self::$logger == null) {
            self::$logger = Tlog::getNewInstance();

            self::$logger->setPrefix("#DATE #HOUR: ");
            self::$logger->setDestinations("\\Thelia\\Log\\Destination\\TlogDestinationRotatingFile");
            self::$logger->setConfig("\\Thelia\\Log\\Destination\\TlogDestinationRotatingFile", 0, $this->getLogFile());
            self::$logger->setLevel(Tlog::ERROR);
        }
        return self::$logger;
    }

    function getLogFile() {
        return $this->logFile;
    }

    function setLogFile($logFile) {
        $this->logFile .= $logFile;
    }

    function getZipFile() {
        return $this->zipFile;
    }

    function getImageFile() {
        return $this->imageFile;
    }

    function getVideoFile() {
        return $this->videoFile;
    }

    function setZipFile($zipFile) {
        $this->zipFile .= $zipFile;
    }

    function setImageFile($imageFile) {
        $this->imageFile .= $imageFile;
    }

    function setVideoFile($videoFile) {
        $this->videoFile .= $videoFile;
    }

}
