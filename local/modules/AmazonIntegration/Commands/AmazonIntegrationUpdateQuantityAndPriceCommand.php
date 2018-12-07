<?php

namespace AmazonIntegration\Commands;

use AmazonIntegration\Controller\Admin\SendProductToAmazonContoller;
use AmazonIntegration\Model\Map\AmazonProductsHfTableMap;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Thelia\Command\ContainerAwareCommand;
use Thelia\Model\Map\ModuleConfigTableMap;
use Thelia\Model\Map\ProductPriceTableMap;
use Thelia\Model\Map\ProductSaleElementsTableMap;
use Thelia\Model\ModuleConfigQuery;
use Thelia\Model\ProductSaleElementsQuery;

class AmazonIntegrationUpdateQuantityAndPriceCommand extends ContainerAwareCommand
{

    protected function configure()
    {
//        php Thelia amazonUpdateQuantityAndPrice amazon.de EUR

        $this
         ->setName("amazonUpdateQuantityAndPrice")
         ->setDescription("Amazon update Quantity and Price")
         ->addArgument(
          'marketPlaceLocale', InputArgument::REQUIRED, 'Specify marketPlaceLocale (eg. amazon.de)')
         ->addArgument(
          'currency', InputArgument::REQUIRED, 'Specify currency (eg. EUR)')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $amazonMarketplaceLocale = $input->getArgument('marketPlaceLocale');
        $prods                   = $this->getProductsQuantityAndPrice($amazonMarketplaceLocale);
        $marketPlaceId           = $this->getIdMarketPlace($amazonMarketplaceLocale);
        $amazonCurrency          = $input->getArgument('currency');

        $updateProd = new SendProductToAmazonContoller();
        $updateProd->addProdToHfTable($prods, $marketPlaceId, $amazonMarketplaceLocale, $amazonCurrency);
        $updateProd->updatePriceProductAmazon($prods, $amazonCurrency, $marketPlaceId, $amazonMarketplaceLocale);
        sleep(2);
        $updateProd->updateQuantityProductAmazon($prods, $marketPlaceId, $amazonMarketplaceLocale);
        sleep(2);

        echo "End updateProductsQuantityAndPrice \n";
    }

    protected function getProductsQuantityAndPrice($marketPlaceLocale)
    {
        $prods = ProductSaleElementsQuery::create()
         ->addJoin(ProductSaleElementsTableMap::ID, ProductPriceTableMap::PRODUCT_SALE_ELEMENTS_ID)
         ->addJoin(ProductSaleElementsTableMap::PRODUCT_ID, AmazonProductsHfTableMap::PRODUCT_ID)
         ->withColumn(ProductPriceTableMap::PRICE, 'price')
         ->where(AmazonProductsHfTableMap::MARKETPLACE_LOCALE . "='" . $marketPlaceLocale . "'");

        $prodsArr = array();
        foreach ($prods as $value) {
            $prodsArr[$value->getProductId()] = array(
             "id"       => $value->getProductId(),
             "ref"      => $value->getRef(),
             "quantity" => $value->getQuantity(),
             "price"    => $value->getVirtualColumn("price")
            );
        }

        return $prodsArr;
    }

    protected function getIdMarketPlace($marketPlaceLocale)
    {
        $marketPlace = ModuleConfigQuery::create()
         ->where(ModuleConfigTableMap::NAME . " like 'MARKETPLACE_" . $marketPlaceLocale . "'");

        foreach ($marketPlace as $market) {
            return $market->getValue();
        }

        return FALSE;
    }

}
