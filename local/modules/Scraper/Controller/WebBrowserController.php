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
//        var_dump($this->logFile);
        $this->init();
        $r = $this->getPage("https://ro.yahoo.com/?p=us");
        $r = ' <div id="gigi" class="Pos(a) End(0) T(0) W(30px) Mstart(12px) Mend(2px) Ta(end)">
<ul class="js-stream-side-buttons js-stream-actions js-stream-tumblr-actions js-stream-dislike-disabled">
    

<li class="ActionLike D(ib) O(n) Mt(4px) Mstart(-1px) Lh(20px)">
        
<a class="js-stream-like-button rapid-noclick-resp rapidnofollow Td(n) O(n) C($c_icon)  P(14px)" role="button" tabindex="0"   data-ylk="cpos:7;cposy:7;bpos:1;pos:1;imgt:ss;g:22b21599-e250-36a8-8b1e-59cb974ac2ef;ct:1;pkgt:orphan_img;grpt:singlestory;r:P0f00000000D96618;ccode:p_ro_ro_lmo4uh;t4:ctrl;elm:btn;elmt:op;itc:1;rspns:op;slk:like;"><b aria-live="polite" class="ActionTooltip Pos(a) Whs(n) Bd($bdr) Bdc($bdr_darkgrey) Bdrs(3px) Bgc(#fff) Bxsh($menuShadow) Lh(14px) End(-40px) rtl_End(58px) Py(7px) js-stream-like-button>Start(50%) js-stream-like-button:h>Start(a)">Apreciați acest subiect</b><i class="Icon-Fp2 IconTumblrHeartOutline Fz(21px) "></i></a>
        
</li>
';
        var_dump($this->parse_selector($r));
//        var_dump(html_entity_decode($r));
        $this->close();
//        self::setLogger()->error("Error response #: ");
//        $this->setLogger()->error("Error response #: ");
        die;
    }
    
    protected function parse_selector($selector_string) {
        // pattern of CSS selectors, modified from mootools
        $pattern = "/([\w-:\*]*)(?:\#([\w-]+)|\.([\w-]+))?(?:\[@?(!?[\w-]+)(?:([!*^$]?=)[\"']?(.*?)[\"']?)?\])?([\/, ]+)/is";
        $pattern = "/([\w-:\*]*)/is";
        preg_match_all($pattern, trim($selector_string).' ', $matches, PREG_SET_ORDER);
        $selectors = array();
        $result = array();
//        var_dump($matches);
//die;
        foreach ($matches as $m) {
            $m[0] = trim($m[0]);
            if ($m[0]==='' || $m[0]==='/' || $m[0]==='//') continue;
            // for borwser grnreated xpath
            if ($m[1]==='tbody') continue;

            list($tag, $key, $val, $exp, $no_key) = array($m[1], null, null, '=', false);
            if(!empty($m[2])) {$key='id'; $val=$m[2];}
            if(!empty($m[3])) {$key='class'; $val=$m[3];}
            if(!empty($m[4])) {$key=$m[4];}
            if(!empty($m[5])) {$exp=$m[5];}
            if(!empty($m[6])) {$val=$m[6];}

            // convert to lowercase
//            if ($this->dom->lowercase) {$tag=strtolower($tag); $key=strtolower($key);}
            //elements that do NOT have the specified attribute
            if (isset($key[0]) && $key[0]==='!') {$key=substr($key, 1); $no_key=true;}

            $result[] = array($tag, $key, $val, $exp, $no_key);
//            if (trim($m[7])===',') {
//                $selectors[] = $result;
//                $result = array();
//            }
        }
        if (count($result)>0)
            $selectors[] = $result;
        return $selectors;
    }

    /*
     * $urlLogin: link to login
     * $fields: array with user, pass, version, .... params for login
     */

    public function login($urlLogin, $fields) {

        $this->cookiefile .= "cookie" . $this->date . ".txt";

        curl_setopt_array($this->curl, array(
            CURLOPT_URL => $urlLogin,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_NOBODY => FALSE,
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $fields,
            CURLOPT_COOKIEFILE => $this->cookiefile,
            CURLOPT_COOKIEJAR => $this->cookiefile
        ));

        $response = curl_exec($this->curl);
        $err = curl_error($this->curl);

        $this->close();

        if ($err) {
            $this->setLogger()->error("Error response #: " . $err);
        } else {
            $this->setLogger()->error("Success response #: " . $response);
        }
    }

    public function getPage($url, $fields = null) {

        curl_setopt_array($this->curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_NOBODY => FALSE,
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $fields,
            CURLOPT_COOKIEFILE => $this->cookiefile,
            CURLOPT_COOKIEJAR => $this->cookiefile
        ));

        $response = curl_exec($this->curl);
        $err = curl_error($this->curl);

        $this->close();

        if ($err) {
            $this->setLogger()->error("Error response #: " . $err);
        } else {
            $this->setLogger()->error("Success response #: " . $response);
        }
        
        return $response;
    }

    public function logout() {
        @unlink($this->cookiefile);
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
