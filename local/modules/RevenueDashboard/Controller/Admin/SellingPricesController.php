<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace RevenueDashboard\Controller\Admin;

use Exception;
use RevenueDashboard\RevenueDashboard;
use Thelia\Controller\Admin\BaseAdminController;
use Thelia\Core\Security\AccessManager;
use Thelia\Core\Security\Resource\AdminResources;
use Thelia\Core\Thelia;
use Thelia\Form\Exception\FormValidationException;
use Thelia\Tools\URL;
use Thelia\Tools\Version\Version;

/**
 * Description of SellingPricesController
 *
 * @author Catana Florin
 */
class SellingPricesController extends BaseAdminController
{

    public function viewSellingPrices()
    {
        return $this->render("selling-prices");
    }

    public function getProducts()
    {

        $products = \Thelia\Model\ProductQuery::create()
         ->limit(10)
         ->addJoin(\Thelia\Model\Map\ProductTableMap::ID, \Thelia\Model\Map\ProductI18nTableMap::ID)
         ->withColumn(\Thelia\Model\Map\ProductI18nTableMap::TITLE, 'productName')
         ->where(\Thelia\Model\Map\ProductI18nTableMap::LOCALE . " = 'en_US'");

        $prods = array();
        foreach ($products as $prd) {
            array_push($prods, $prd->getId() . ";" . $prd->getTitle());
            break;
        }

        print_r($prods);
//        echo '<pre>';
//        var_dump($prods);
        die;
    }

}
