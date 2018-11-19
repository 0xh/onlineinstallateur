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

    public static function saveInCrawlerProductListing($product_id, $platform, $first_price = 0)
    {
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
             ->setVersionCreatedBy("scraper.1.2")
             ->save();
        } else {
            $crawlerProductListing = new CrawlerProductListing();
            $crawlerProductListing->setProductBaseId($crawlerProductBaseId)
             ->setFirstPosition(1)
             ->setFirstPrice($first_price)
             ->setPlatform($platform)
             ->setVersionCreatedBy("scraper.1.2")
             ->save();
        }

        return $crawlerProductListing->getId();
    }

}
