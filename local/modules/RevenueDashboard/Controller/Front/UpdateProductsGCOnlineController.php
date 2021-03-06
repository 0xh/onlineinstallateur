<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace RevenueDashboard\Controller\Front;

use RevenueDashboard\Model\Map\WholesalePartnerProductTableMap;
use RevenueDashboard\Model\WholesalePartnerProduct;
use RevenueDashboard\Model\WholesalePartnerProductQuery;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Thelia\Controller\Front\BaseFrontController;
use Thelia\Log\Tlog;
use Thelia\Model\Map\ProductTableMap;
use Thelia\Model\ProductQuery;

/**
 * Description of UpdateProductsController
 *
 * @author Catana Florin
 */
class UpdateProductsGCOnlineController extends BaseFrontController {
    /* @var Tlog $log */

//"NWING14C5", strPassword: "budget07"
    protected static $logger;
    protected $username = "nwing14c5";
    protected $password = "budget07";
    protected $version = "2017";
    protected $info = [];
    protected $cookiefile = THELIA_LOCAL_DIR . "config" . DS . "cookies" . DS . "myshtcookieexport.txt";
    protected $logFilePath = THELIA_LOG_DIR . DS . "revenue-data-from-mysht";

    public function updateOrInsertProductsGCOnline() {


        $this->login();

//        $prodsExternId = $this->getProductsExternId();
//
//        foreach ($prodsExternId as $prod) {
//            $idartikel = trim($prod["idartikel"]);
//            $prodId = $prod["prodid"];
//
//            $artnr = $this->getArtNr($idartikel, $idPartner, $prodId);
//            if ($artnr === FALSE) {
//                $this->logout();
//                $this->login();
//                $artnr = $this->getArtNr($idartikel, $idPartner, $prodId);
//            }
//        }
//
//        $this->logout();
//        
//        return $this->generateRedirect('/admin/module/revenue-wholesale-partner');
    }

    function updateStockForMysht($idPartner, $prodId, $price, $discount) {
        $prod = WholesalePartnerProductQuery::create()
                ->where(WholesalePartnerProductTableMap::PARTNER_ID . " = " . $idPartner)
                ->findOneByProductId($prodId);

        if ($prod) {
            $prod->setPrice($price);
            $prod->setDiscount($discount);
            $prod->save();
        } else {
            $this->addNewPartnerProduct($idPartner, $prodId, $price, $discount);
        }
    }

    protected function addNewPartnerProduct($idPartner, $prodId, $price, $discount) {
        $newPartnerProduct = new WholesalePartnerProduct();
        $newPartnerProduct->setProductId($prodId);
        $newPartnerProduct->setPartnerId($idPartner);
        $newPartnerProduct->setPrice($price);
        $newPartnerProduct->setPackageSize(1);
        $newPartnerProduct->setDeliveryCost(0);
        $newPartnerProduct->setDiscount($discount);
        $newPartnerProduct->setDiscountDescription("discount " . $discount);
        $newPartnerProduct->setProfileWebsite("www.mysht.at");
        $newPartnerProduct->setPosition(1);
        $newPartnerProduct->setDepartment("deposit");
        $newPartnerProduct->setComment("mysht");
//        $newPartnerProduct->setValidUntil();
        $newPartnerProduct->setVersionCreatedBy($this->getSecurityContext()->getAdminUser()->getUsername());
        $newPartnerProduct->save();
    }

    protected function login() {

        $curl = curl_init();

        $data = array("strUserName" => $this->username, "strPassword" => $this->password, "strLayout" => "GCAT", "strLanguage" => "EN");
        $data_string = json_encode($data);
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://www.gconlineplus.at/4.0.542/services/Account.asmx/Login",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_NOBODY => FALSE,
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
            ),
            CURLOPT_USERAGENT => "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3381.1 Safari/537.36",
            'Content-Length: ' . strlen($data_string),
            CURLOPT_POSTFIELDS => $data_string,
            CURLOPT_COOKIEFILE => $this->cookiefile,
            CURLOPT_COOKIEJAR => $this->cookiefile
        ));
//{strUserName: "NWING14C5", strPassword: "budget07", strLayout: "GCAT", strLanguage: "EN"}
        //searchTerms: "003L7612"

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        echo '<pre>';
        var_dump($response);
        $this->getProductNumber();
        die;
        if ($err) {
            $this->setLogger()->error("login - cURL Error #: " . $err);
        } else {
            $this->setLogger()->error("login - #: " . $response);
        }
    }

    protected function getProductNumber($searchTerms = "003L7612") {

        $curl = curl_init();
//        $data_string = "{\"lstProducts\":[{\"RunNumber\":58,\"Variant\":\"01\",\"Supplier\":\"DAOF01\",\"Productnumber\":\"DASVPV1620IG\"}],\"strStockId\":\"\",\"blnGetNetPrice\":true,\"blnGetGrosPrice\":true}";//json_encode(array("searchTerms" => $searchTerms));
//
//        curl_setopt_array($curl, array(
//            CURLOPT_URL => "https://www.gconlineplus.at/4.0.542/services/Products.asmx/getNetPricesAndStocksByProductKeyWithProductnumber?layout=GCAT&rand=9366882",
//            CURLOPT_RETURNTRANSFER => true,
//            CURLOPT_ENCODING => "",
//            CURLOPT_MAXREDIRS => 10,
//            CURLOPT_TIMEOUT => 30,
//            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//            CURLOPT_CUSTOMREQUEST => "POST",
//            CURLOPT_HTTPHEADER => array(
//                'Content-Type: application/json',
//            ),
//            CURLOPT_USERAGENT => "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3381.1 Safari/537.36",
//            'Content-Length: ' . strlen($data_string),
//            CURLOPT_POSTFIELDS => $data_string,
//            CURLOPT_COOKIEFILE => $this->cookiefile,
//            CURLOPT_COOKIEJAR => $this->cookiefile,
//        ));

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://www.gconlineplus.at/4.0.542/services/Products.asmx/getNetPricesAndStocksByProductKeyWithProductnumber?layout=GCAT&rand=2471516&crsfKey=ba36cb5434fbfb9ae87cbd42e6aceaa5&u=96f766c447951414e20ea931a080841f",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "{\"lstProducts\":[{\"RunNumber\":\"58\",\"Variant\":\"01\",\"Supplier\":\"DAOF01\",\"Productnumber\":\"DASVPV1620IG\"}],\"strStockId\":\"\",\"blnGetNetPrice\":true,\"blnGetGrosPrice\":true}",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "content-type: application/json",
                "postman-token: 4f079bc3-4860-c45f-2cd7-662c40cb3ae8"
            ),
            CURLOPT_USERAGENT => "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3381.1 Safari/537.36",
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);

        echo '<pre>';

        var_dump($response);
        die;

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

                $price = $response["data"][0]["aktpreis"];
                $discount = $resNettoRabatt["rabatt"];

                $this->updateStockForMysht($idPartner, $prodId, $price, $discount);
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

}
