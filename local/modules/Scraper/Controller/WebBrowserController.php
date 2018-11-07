<?php

namespace Scraper\Controller;

use Scraper\Config\ScraperConst;
use Thelia\Controller\Admin\BaseAdminController;
use Thelia\Log\Tlog;
use Thelia\Log\Destination\TlogDestinationRotatingFile;

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
        //$this->test_product_info('https://www.skybad.de/catalogsearch/result/?q=','38528001','POST','.product-image-col','href','.product-image','alt');
        //$this->test_product_info('https://www.reuter.de/katalogsuche/?q=','26187000','GET','.c-product-tile__link','href','.product-image','data-caption');
        $this->test_product_info('https://search.epoq.de/inbound-servletapi/getSearchResult?full&callback=jQuery331038174002391130446_1537445518039&_bIsAjax=1&session-ro=1&tenantId=megabad&sessionId=9e4a1f79729e5aa479a2e546289f169e&orderBy=&order=desc&limit=24&offset=0&locakey=de&style=compact&format=json&nrf=&query=26187000&_=1537445518040','','GET','.img-square','href','.img-responsive','alt');
        
        die("end");
    }
    
    
    
    public function test_product_info($searchBase,$searchQuerry,$requestType,$resultSelector,$resultAttributeName,$productSelector,$productAttributeName){
        var_dump('Searching '.$searchBase.' for '.$searchQuerry);
        $productPageLinks = $this->test_product_search($searchBase.$searchQuerry,$requestType,$resultSelector,$resultAttributeName);
        var_dump($productPageLinks);
        
        if($productPageLinks != NULL) {
            foreach ($productPageLinks as $value) {
                $productInfo = $this->test_product_search($value,$requestType,$productSelector,$productAttributeName);
                var_dump($productInfo);
            }
        }
        else var_dump("No product Info");
  
    }
    
    public function test_product_search($searchUrl,$requestType,$resultSelector,$attributeName){
        var_dump('SearchUrl '.$searchUrl. " selector ".$resultSelector." attribute ".$attributeName);
        $searchPageResult = $this->getPage($searchUrl,$requestType);
        
        $html = new SimpleHtmlDomController();
        $html->load($searchPageResult);
        $productResults = $html->find($resultSelector);
        $productCollector = null;

        if($productResults != null ) {//&& empty($productResults) != FALSE
            /** @var SimpleHtmlDomNodeController $value */
            foreach ($productResults as $value) {
                   //var_dump($value->getAttribute($attributeName));
                $productUrl = $value->getAttribute($attributeName);
                if($productUrl[0] == '/')
                    $productUrl = "https://www.reuter.de".$productUrl;
                    $productCollector[] = $productUrl;
            } 
        }
        else {
            var_dump("No products found");
            var_dump($searchPageResult);
        }
        
        return $productCollector;
    }
    
    public function test_old() {

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

        $curlOptions = array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_NOBODY => FALSE,
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            // CURLOPT_CUSTOMREQUEST => $typeRequest,
            //CURLOPT_POSTFIELDS => $fields,
            CURLOPT_COOKIEFILE => $this->cookiefile,
            CURLOPT_COOKIEJAR => $this->cookiefile
        );
        if($fields != null) 
            $curlOptions[] = [CURLOPT_POSTFIELDS => $fields];
        if($typeRequest == 'POST')
            $curlOptions[] = [CURLOPT_CUSTOMREQUEST => $typeRequest];
        curl_setopt_array($this->curl, $curlOptions);

        $response = curl_exec($this->curl);
        $err = curl_error($this->curl);

        if ($err) {
            $this->setLogger()->error("Error response #: " . $err);
        } else {
           // $this->setLogger()->error("Success response #: " . $response);
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
            self::$logger->setConfig("\\Thelia\\Log\\Destination\\TlogDestinationRotatingFile", TlogDestinationRotatingFile::MAX_FILE_SIZE_KB_DEFAULT, "1");
            self::$logger->setConfig("\\Thelia\\Log\\Destination\\TlogDestinationRotatingFile", TlogDestinationRotatingFile::MAX_FILE_COUNT_DEFAULT, "100");
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
