<?php

namespace Scraper\Controller\Scrapers;

use HookAdminCrawlerDashboard\Model\CrawlerProductBase;
use HookAdminCrawlerDashboard\Model\CrawlerProductBaseQuery;
use HookAdminCrawlerDashboard\Model\CrawlerProductListing;
use HookAdminCrawlerDashboard\Model\CrawlerProductListingQuery;
use Thelia\Controller\Admin\BaseAdminController;
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

    public static function getProductsExternId($online, $startid,$stopid)
    {
        $collectionProducts = null;
        $productQuery      = ProductQuery::create();
        $upperLimit = "";
        
        if($stopid)
            $upperLimit = " and " . ProductTableMap::ID . " <= ".$stopid;
            
        if($online){
            $collectionProducts = $productQuery->where(ProductTableMap::VISIBLE . " = 1 and " . ProductTableMap::ID . " >= ".$startid . $upperLimit);
        }
        else {
            $collectionProducts = $productQuery->where(ProductTableMap::ID . " > ".$startid . $upperLimit);
        }
            
        $arrayProducts = array();
        foreach ($collectionProducts as $product) {
            array_push($arrayProducts, array("extern_id" => substr($product->getRef(), 3), "prod_id" => $product->getId()));
        }

        return $arrayProducts;
    }

    public static function saveInCrawlerProductListing($product_id, $platform, $first_price)
    {
        $crawlerProductBase = CrawlerProductBaseQuery::create()
         ->findOneByProductId($product_id);

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
            $crawlerProductListing->setFirstPrice($first_price);
            $crawlerProductListing->save();
        } else {
            $crawlerProductListing = new CrawlerProductListing();
            $crawlerProductListing->setProductBaseId($crawlerProductBaseId);
            $crawlerProductListing->setFirstPosition(1);
            $crawlerProductListing->setFirstPrice($first_price);
            $crawlerProductListing->setPlatform($platform);
            $crawlerProductListing->save();
        }
        
        return $crawlerProductListing->getId();
    }

}
