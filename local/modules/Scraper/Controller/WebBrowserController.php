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
    private $cookiefile = ScraperConst::SCRAPER_COOKIE_DIR . DS . "cookie.txt";
    private $userAgents = array(1 => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_3) AppleWebKit/601.4.4 (KHTML, like Gecko) Version/9.0.3 Safari/601.4.4',
        2 => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2767.4 Safari/537.36',
        3 => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36',
        4 => 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:40.0) Gecko/20100101 Firefox/40.1',
        5 => 'Mozilla/5.0 (Windows NT 6.3; rv:36.0) Gecko/20100101 Firefox/36.0',
        6 => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10; rv:33.0) Gecko/20100101 Firefox/33.0',
        7 => 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2228.0 Safari/537.36',
        8 => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2227.1 Safari/537.36',
        9 => 'Opera/9.80 (X11; Linux i686; Ubuntu/14.10) Presto/2.12.388 Version/12.16',
        10 => 'Opera/12.80 (Windows NT 5.1; U; en) Presto/2.10.289 Version/12.02',
        11 => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_3) AppleWebKit/537.75.14 (KHTML, like Gecko) Version/7.0.3 Safari/7046A194A',
        12 => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_6_8) AppleWebKit/537.13+ (KHTML, like Gecko) Version/5.1.7 Safari/534.57.2',
        13 => 'Mozilla/5.0 (iPhone; CPU iPhone OS 7_2_1 like Mac OS X; en-US) AppleWebKit/534.11.7 (KHTML, like Gecko) Version/4.0.5 Mobile/8B114 Safari/6534.11.7',
        14 => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3608.4 Safari/537.36',
        15 => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/68.0.3440.106 Safari/537.36',
        16 => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.99 Safari/537.36',
        17 => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:61.0) Gecko/20100101 Firefox/61.0',
        18 => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_6) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/11.1.2 Safari/605.1.15',
        19 => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/64.0.3282.140 Safari/537.36 Edge/17.17134',
        20 => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/12.0 Safari/605.1.15',
        21 => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_6) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/12.0 Safari/605.1.15',
        22 => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36',
        23 => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.77 Safari/537.36',
        24 => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.67 Safari/537.36',
        25 => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36',
    );

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

        $this->setLogFile($nameLogFile . DS . "log-".$this->date . ".txt");

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
            CURLOPT_COOKIEJAR => $this->cookiefile,
            CURLOPT_USERAGENT, $this->userAgents[rand(1,25)],
            CURLOPT_FOLLOWLOCATION, true,
            CURLOPT_CAINFO, THELIA_CONF_DIR."key".DS."cacert-2018-10-17.pem"
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
            CURLOPT_COOKIEJAR => $this->cookiefile,
            CURLOPT_USERAGENT, $this->userAgents[rand(1,25)],
            CURLOPT_FOLLOWLOCATION, true,
            CURLOPT_CAINFO, THELIA_CONF_DIR."key".DS."cacert-2018-10-17.pem"
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
