<?php

namespace Scraper\Controller;

use Thelia\Controller\Admin\BaseAdminController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Thelia\Log\Tlog;
use Thelia\Core\HttpFoundation\Response;
use Scraper\Controller\Scrapers\Megabad;
use Scraper\Controller\Scrapers\Reuter;
use Scraper\Controller\Scrapers\Skybad;
use Scraper\Controller\Scrapers\Google;
use Scraper\Controller\Scrapers\Idealo;

/**
 * Class ScraperController
 * @package Scraper\Controller
 * @author emanuel plopu <emanuel.plopu@sepa.at>
 */
class ScraperController extends BaseAdminController
{

    /** @var Tlog $log */
    protected static $logger;

    private function scrapeProduct($platform, $searchObject)
    {
        /** @var \Scraper\Controller\Scrapers\PriceScraper */
        $scraperClass = null;
        $content      = "";
        switch ($platform) {
            case "Megabad":
                $scraperClass = new Megabad();
                break;
            case "Reuter":
                $scraperClass = new Reuter();
                break;
            case "Skybad":
                $scraperClass = new Skybad();
                break;
            case "Google":
                $scraperClass = new Google();
                break;
            case "Idealo":
                $scraperClass = new Idealo();
                break;
            default:
                echo "Platform " . $platform . " not supported, sample: Reuter \n";
        }
        $webBrowser = new WebBrowserController($platform);
        $webBrowser->init();
        $content    .= "Price :" . $scraperClass->getPriceForProduct($webBrowser, $searchObject);
        $content    .= ' <a href="' . $scraperClass->searchUrl . '">' . $platform . 'URL</a><br>';
        $webBrowser->close();
        return $content;
    }

    public function scrapeSearch(Request $request)
    {
        if ($request->isXmlHttpRequest()) {

            $response   = new Response();
            $productRef = $request->request->get("product_ref");
            $content    = "";

            $searchObject = array("extern_id" => $productRef, "prod_id" => "0");
            $content      = $this->scrapeProduct("Megabad", $searchObject);
            $content      .= $this->scrapeProduct("Reuter", $searchObject);
            $content      .= $this->scrapeProduct("Skybad", $searchObject);
            $content      .= $this->scrapeProduct("Google", $searchObject);
            // $content      .= $this->scrapeProduct("Idealo", $searchObject);

            $response->setContent($content);

            return $response;
        } else {
            return new JsonResponse("GET request not accepted");
        }
    }

    public function getLogger()
    {
        if (self::$logger == null) {
            self::$logger = Tlog::getNewInstance();

            $logFilePath = THELIA_LOG_DIR . DS . "Scraper" . DS . "log-product_scraper.txt";

            self::$logger->setPrefix("#LEVEL: #DATE #HOUR: ");
            self::$logger->setDestinations("\\Thelia\\Log\\Destination\\TlogDestinationRotatingFile");
            self::$logger->setConfig("\\Thelia\\Log\\Destination\\TlogDestinationRotatingFile", 0, $logFilePath);
            self::$logger->setLevel(Tlog::ERROR);
        }
        return self::$logger;
    }

}
