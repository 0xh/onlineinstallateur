<?php

namespace AmazonIntegration\Controller\Admin;

use AmazonIntegration\Model\AmazonProductsHf;
use AmazonIntegration\Model\Base\AmazonProductsHfQuery;
use Exception;
use Thelia\Controller\Admin\BaseAdminController;
use Thelia\Log\Tlog;
use Thelia\Model\Map\ModuleConfigTableMap;
use Thelia\Model\ModuleConfigQuery;
use Thelia\Model\ProductQuery;
use const DS;
use const THELIA_LOG_DIR;
use function invokeGetReport;
use function invokeGetReportList;
use function invokeRequestReport;

class GetProductsFromAmazonController extends BaseAdminController
{

    static $logger;
    static $locale;

    public function getAllProductsFromAmazon($locale)
    {

        self::$locale = $locale;

        $market = $this->getConfigValueMarketPlace($locale);
        if (!$market) {
            die("Locale = $locale not exist!");
        }

        $this->getLogger()->error($locale);

        switch ($locale) {
            case "de":
                $serviceUrl    = 'https://mws.amazonservices.de';
                $marketplaceid = $market['value'];
                break;
            case "it":
                $serviceUrl    = 'https://mws.amazonservices.it';
                $marketplaceid = $market['value'];
                break;
            case "fr":
                $serviceUrl    = 'https://mws.amazonservices.fr';
                $marketplaceid = $market['value'];
                break;
            case "es":
                $serviceUrl    = 'https://mws.amazonservices.es';
                $marketplaceid = $market['value'];
                break;
            case "uk":
                $serviceUrl    = 'https://mws.amazonservices.co.uk';
                $marketplaceid = $market['value'];
                break;
            default:
                $serviceUrl    = '';
                $marketplaceid = '';
        }

        $this->getLogger()->error("serviceUrl " . $serviceUrl);
        $this->getLogger()->error("marketplaceid " . $marketplaceid);

        try {
            include_once __DIR__ . '/../../Classes/API/src/MarketplaceWebServiceOrders/Samples/RequestReportSample.php';
            $reportRequestId = invokeRequestReport($service, $request);
            sleep(1);

            sleep(50);
            include_once __DIR__ . '/../../Classes/API/src/MarketplaceWebServiceOrders/Samples/GetReportListSample.php';
            $reportId = invokeGetReportList($service, $request);
            sleep(2);

            include_once __DIR__ . '/../../Classes/API/src/MarketplaceWebServiceOrders/Samples/GetReportSample.php';
            $prods = invokeGetReport($service, $request, $serviceUrl);

            $this->addProdToHfTable($prods, $marketplaceid, $market['name']);
        } catch (Exception $ex) {
            $this->getLogger()->error($ex->getMessage());
            $this->getLogger()->error($ex->getCode());
        }
        
        $this->getLogger()->error("......END......");
        die('end.');
    }

    protected function getConfigValueMarketPlace($locale)
    {
        $marketPlace = ModuleConfigQuery::create()
         ->where(ModuleConfigTableMap::NAME . " like 'MARKETPLACE_%." . $locale . "'");

        foreach ($marketPlace as $market) {
            $marketName = explode("_", $market->getName());
            return array("name" => $marketName[1], "value" => $market->getValue());
        }

        return FALSE;
    }

    protected function addProdToHfTable($prods, $marketPlaceId, $marketPlaceLocale, $amazonCurrency = 'EUR')
    {
        foreach ($prods as $prod) {
            $prodId = $this->getProdIdByRef($prod['sku']);

            if ($prodId) {
                $query = AmazonProductsHfQuery::create()
                 ->filterByProductId($prodId)
                 ->findOneByMarketplaceId($marketPlaceId);

                if ($query == null) {
                    $prodAmazon = new AmazonProductsHf();
                    $prodAmazon->setProductId($prodId);
                    $prodAmazon->setRef($prod['sku']);
//                $prodAmazon->setEanCode($prod['ean']);
                    $prodAmazon->setASIN($prod['asin']);
                    $prodAmazon->setSKU($prod['sku']);
                    $prodAmazon->setPrice($prod['price']);
                    $prodAmazon->setQuantity($prod['quantity']);
                    $prodAmazon->setMarketplaceId($marketPlaceId);
                    $prodAmazon->setMarketplaceLocale($marketPlaceLocale);
                    $prodAmazon->setCurrency($amazonCurrency);
                    $prodAmazon->save();
                    $prodAmazon->clear();
                } else {
                    $query->setQuantity($prod['quantity']);
                    $query->setPrice($prod['price']);
                    $query->setCurrency($amazonCurrency);
                    $query->save();
                }
            } else {
                $this->getLogger()->error($prod['pr'] . " ==== idAmazon = " . $prod['idAmazon'] . " ref = " . $prod['sku'] . " asin = " . $prod['asin'] . " quantity = " . $prod['quantity'] . " not exist!");
                echo "<pre>";
                var_dump($prod['pr'] . " ==== idAmazon = " . $prod['idAmazon'] . " ref = " . $prod['sku'] . " asin = " . $prod['asin'] . " quantity = " . $prod['quantity'] . " not exist!");
            }
        }
    }

    protected function getProdIdByRef($ref)
    {
        $query = ProductQuery::create()
         ->findOneByRef($ref);

        if ($query) {
            return $query->getId();
        }

        return FALSE;
    }

    public function getLogger()
    {
        if (self::$logger == null) {
            self::$logger = Tlog::getNewInstance();

            $logFilePath = THELIA_LOG_DIR . DS . "get-products-from-amazon_" . self::$locale . "_" . date("Y-m-d_H.i.s") . ".txt";

            self::$logger->setPrefix("#DATE #HOUR: ");
            self::$logger->setDestinations("\\Thelia\\Log\\Destination\\TlogDestinationRotatingFile");
            self::$logger->setConfig("\\Thelia\\Log\\Destination\\TlogDestinationRotatingFile", 0, $logFilePath);
            self::$logger->setLevel(Tlog::ERROR);
        }
        return self::$logger;
    }

}
