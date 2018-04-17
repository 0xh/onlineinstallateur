<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace BackOffice\Controller\Front;

use MultipleFullfilmentCenters\Model\FulfilmentCenterProducts;
use MultipleFullfilmentCenters\Model\FulfilmentCenterProductsQuery;
use MultipleFullfilmentCenters\Model\FulfilmentCenterQuery;
use MultipleFullfilmentCenters\Model\Map\FulfilmentCenterProductsTableMap;
use Thelia\Controller\Front\BaseFrontController;
use Thelia\Log\Tlog;
use Thelia\Model\Map\ProductTableMap;
use Thelia\Model\ProductQuery;
use const DS;
use const THELIA_LOCAL_DIR;
use const THELIA_LOG_DIR;

/**
 * Description of MyshtUpdateStockController
 *
 * @author Catana Florin
 */
class MyshtUpdateStockController extends BaseFrontController {
    /* @var Tlog $log */

    protected static $logger;
//    protected $username = "nmbures";
//    protected $password = "nsht123";
    protected $username = "hausf";
    protected $password = "My21Sht";
    protected $version = "2017";
    protected $cookiefile = THELIA_LOCAL_DIR . "config" . DS . "cookies" . DS . "myshtcookie.txt";
    protected $logFilePath = THELIA_LOG_DIR . DS . "update-stock-mysht_";

    public function updateStockMysht() {

        $date = date('m.d.Y_H.i.s', time());        
        $this->logFilePath = $this->logFilePath . $date . ".txt";

        $this->logout();

        $prods = $this->getProductsExternId();
        $idCenter = $this->getIdFulfilmentCenterMysht();

        foreach ($prods as $prod) {
            $idartikel = $prod["idartikel"];

            $artnr = $this->getArtNr($idartikel);
            if ($artnr === FALSE) {
                $this->logout();
                $this->login();
                $artnr = $this->getArtNr($idartikel);
            }

            $stock = 0;
            if (!is_array($artnr)) {
                $stock = $this->getStock($artnr, $idartikel);

                $this->setLogger()->error("stock =  $stock # ");
                echo 'stock = ' . $stock . " ";
            } else {
                $this->setLogger()->error("error = # " . $artnr[0]);
            }

            $this->updateStockForMysht($idCenter, $prod["prodid"], $stock);
        }

//        $idartikel = 15074400;//3
//        $idartikel = 2766300; //14
//        $idartikel = 32663001;//7
//        $idartikel = 6958652;//error 1

        $this->logout();

        die("end");
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
                return $response["data"][0]["MegabildNr"];
            } else {
                $this->setLogger()->error("getArtNr - idartikel = $idartikel servererror: " . json_encode($response));
                return array(0 => $response["servererror"]);
            }
        }
    }

    protected function getStock($artnr, $idartikel) {
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
            $this->setLogger()->error("getStock - cURL Error #: " . $err);
        } else {
            $response = json_decode($response, true);

            if ($response["status"] == "NOSESSION") {
                $this->setLogger()->error("status = NOSESSION #: logout -> login ");
                $this->logout();
                $this->login();
                $this->getStock($artnr, $idartikel);
            }

            if (isset($response["sofort"])) {
                $this->setLogger()->error("getStock - idartikel = $idartikel response #: stock = " . $response["sofort"] . ". " . json_encode($response));
                return $response["sofort"];
            } else {
                $this->setLogger()->error("getStock - idartikel = $idartikel #: stock = 0. " . json_encode($response));
                return 0;
            }
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

    function getProductsExternId() {
        $prods = ProductQuery::create()
                ->where(ProductTableMap::EXTERN_ID . " IS NOT NULL and " . ProductTableMap::VISIBLE . " = 1");
        $arrayProds = array();
        foreach ($prods as $prod) {
            array_push($arrayProds, array("idartikel" => substr($prod->getRef(), 3), "prodid" => $prod->getId()));
        }

        return $arrayProds;
    }

    function getIdFulfilmentCenterMysht() {
        
        //every time, id for mysht MUST BE 3
        $id = FulfilmentCenterQuery::create()
                ->findOneById(3);

        if ($id) {
            return $id->getId();
        } else {
            die("FulfilmentCenterMysht not exist!");
        }
    }

    function updateStockForMysht($idCenter, $prodId, $stock) {
        $prod = FulfilmentCenterProductsQuery::create()
                ->where(FulfilmentCenterProductsTableMap::FULFILMENT_CENTER_ID . " = " . $idCenter)
                ->findOneByProductId($prodId);

        if ($prod) {
            $prod->setProductStock($stock);
            $prod->save();
        } else {
            $this->addProdInFulfilmentCenterMysht($idCenter, $prodId, $stock);
        }
    }

    function addProdInFulfilmentCenterMysht($idCenter, $prodId, $stock) {
        $prod = new FulfilmentCenterProducts();
        $prod->setFulfilmentCenterId($idCenter);
        $prod->setProductId($prodId);
        $prod->setProductStock($stock);
        $prod->save();
    }

}
