<?php

namespace Scraper\Controller\Scrapers;

use HookAdminCrawlerDashboard\Model\CrawlerProductBase;
use HookAdminCrawlerDashboard\Model\CrawlerProductBaseQuery;
use HookAdminCrawlerDashboard\Model\CrawlerProductListing;
use HookAdminCrawlerDashboard\Model\CrawlerProductListingQuery;
use Thelia\Controller\Admin\BaseAdminController;
use Thelia\Model\Map\BrandI18nTableMap;
use Thelia\Model\Map\ProductTableMap;
use Thelia\Model\ProductQuery;
use const DS;
use const THELIA_LOCAL_DIR;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Common
 *
 * @author Catana Florin
 */
class Common extends BaseAdminController
{

    public static function getProductsExternId($online, $startid, $stopid)
    {
        $collectionProducts = null;
        $productQuery       = ProductQuery::create()
         ->addJoin(ProductTableMap::BRAND_ID, BrandI18nTableMap::ID)
         ->withColumn(BrandI18nTableMap::TITLE, 'TITLE')
         ->where(BrandI18nTableMap::LOCALE . " = 'de_DE'");

        $upperLimit = "";

        if ($stopid)
            $upperLimit = " and " . ProductTableMap::ID . " <= " . $stopid;

        if ($online) {
            $collectionProducts = $productQuery->where(ProductTableMap::VISIBLE . " = '1' and " . ProductTableMap::ID . " >= " . $startid . $upperLimit);
        } else {
            $collectionProducts = $productQuery->where(ProductTableMap::ID . " > " . $startid . $upperLimit);
        }

        $arrayProducts = array();
        foreach ($collectionProducts as $product) {
            array_push($arrayProducts, array("extern_id" => substr($product->getRef(), 3), "prod_id"   => $product->getId(),
             "brand"     => strtoupper($product->getVirtualColumn("TITLE"))));
        }

        return $arrayProducts;
    }

    public static function saveInCrawlerProductListing($product_id, $platform, $first_price = 0,
                                                       $version = "scraper.1.2")
    {
        if ($product_id == null || $product_id == "") {
            return null;
        }
        $crawlerProductBase = CrawlerProductBaseQuery::create()
         ->findOneByProductId($product_id);
        if (!$first_price || $first_price == null || $first_price == "")
            $first_price        = 0;

        if ($crawlerProductBase) {
            $crawlerProductBaseId = $crawlerProductBase->getId();
        } else {
            $crawlerProductBase   = new CrawlerProductBase();
            $crawlerProductBase->setProductId($product_id);
            $crawlerProductBase->setActive(1);
            $crawlerProductBase->save();
            $crawlerProductBaseId = $crawlerProductBase->getId();
        }

        $crawlerProductListing = CrawlerProductListingQuery::create()
         ->filterByPlatform($platform)
         ->findOneByProductBaseId($crawlerProductBaseId);

        if ($crawlerProductListing) {
            $crawlerProductListing->setFirstPrice($first_price)
             ->setVersionCreatedBy($version)
             ->save();
        } else {
            $crawlerProductListing = new CrawlerProductListing();
            $crawlerProductListing->setProductBaseId($crawlerProductBaseId)
             ->setFirstPosition(1)
             ->setFirstPrice($first_price)
             ->setPlatform($platform)
             ->setVersionCreatedBy($version)
             ->save();
        }

        return $crawlerProductListing->getId();
    }

    public static function fetchfromFTP($local_folder, $filename)
    {
        $server_file = $filename;
        $local_file  = THELIA_LOCAL_DIR . "sepa" . DS . "import" . DS . $local_folder . DS . $server_file;

        $ftp_user   = "mmai1018";
        $ftp_pass   = "PreiCra!2018";
        $ftp_server = "ftp.sht-net.at";
        $ftp_conn   = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
        $login      = ftp_login($ftp_conn, $ftp_user, $ftp_pass);
        ftp_pasv($ftp_conn, true) or die("Cannot switch to passive mode");

        ftp_chdir($ftp_conn, "/preiscrawler");
        if (ftp_get($ftp_conn, $local_file, $server_file, FTP_ASCII)) {
            echo "Successfully written to $local_file. \n";
        } else {
            echo "Error downloading $server_file.";
        }
        ftp_close($ftp_conn);


        return $local_file;
    }

}
