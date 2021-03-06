<?php

namespace SepaImporter\Import;

use RevenueDashboard\Model\WholesalePartnerProductQuery;
use Thelia\ImportExport\Import\AbstractImport;
use Thelia\Log\Tlog;
use Thelia\Model\ProductPriceQuery;
use Thelia\Model\ProductQuery;
use Thelia\Model\ProductSaleElementsQuery;
use Thelia\Model\ProductSaleElements;
use const DS;
use const THELIA_LOCAL_DIR;
use const THELIA_LOG_DIR;

/* * ********************************************************************************** */
/*      This file is part of the Thelia package.                                     */
/*                                                                                   */
/*      Copyright (c) OpenStudio                                                     */
/*      email : dev@thelia.net                                                       */
/*      web : http://www.thelia.net                                                  */
/*                                                                                   */
/*      For the full copyright and license information, please view the LICENSE.txt  */
/*      file that was distributed with this source code.                             */
/* * ********************************************************************************** */

class ShtPriceImporter extends AbstractImport
{
    /* @var Tlog $log */

    protected static $logger;
    protected $is_error_filecreated = FALSE;
    private $match_threshold        = 100;
    private $no_match_count         = 0;
    private $total_parsed           = 0;

    public function rowHasField($row, $field)
    {
        if (isset($row[$field])) {
            return $row[$field];
        }
        return null;
    }

    public function importData(array $row)
    {

//logging intialise
        $time_start = microtime(true);
        $errors     = null;

        $log      = $this->getLogger();
        $max_time = ini_get("max_execution_time");
        ini_set('max_execution_time', 60000);
        $i        = 0;

        $log->debug("STARTED");

        $log->debug("SHT PRICE IMPORT");
        foreach ($row as $key => $value) {
            if ($value) {
                $log->debug($key . ': ' . $value);
            }
        }

        //declare global variables
        $locale                         = 'de_DE';
        $wholesaleProduct               = null;
        $price_import                   = FALSE;
        $partner_product_ref_price_list = null;
        $brutto_price_import            = null;


        //USED
        $partner_product_ref_price_list = $this->rowHasField($row, "MATNR");
        $netto_price_from_list          = str_replace(',', '.', $this->rowHasField($row, "YE49_plus_7"));
        $price_from_separate_list       = $netto_price_from_list * 120 / 100;

        //Insanity check
        if ($partner_product_ref_price_list) {
            $wholesaleProduct = WholesalePartnerProductQuery::create()
             ->findOneByPartnerProdRef($partner_product_ref_price_list);
        } else {
            $log->debug("NO matchcode! ");
        }

        if ($wholesaleProduct && $price_from_separate_list) {
            $log->debug("Starting price update.");
            $newProdId = $wholesaleProduct->getProductId();

            $product = ProductQuery::create()
             ->findOneById($newProdId);
            if ($product == null) {
                echo 'product is null ' . $newProdId . "\n";
            }
            $product_id = $product->getId();
            $log->debug("Product already in database, found match for WPP_id: " . $wholesaleProduct->getId() . "for product id: " . $product_id . " and ref: " . $product->getRef() . PHP_EOL);

            $productPse = ProductSaleElementsQuery::create()
             ->findOneByProductId($product_id);

            if ($productPse == null) {
                $productPse = new ProductSaleElements();
                $productPse->setProduct($product)
                 ->save();
            }

            if ($productPse == null) {
                echo 'pse is null' . $product . "\n";
            }
            $pse_id = $productPse->getId();
            $log->debug("Pse Id from PSE query is: " . $pse_id);

            $priceQ = ProductPriceQuery::create()
             ->filterByProductSaleElementsId($pse_id)
             ->findOneByCurrencyId(1);

            $log->debug("Price found: " . $priceQ->getProductSaleElementsId() . " Product Price Was: " . $priceQ->getPrice() . " Product Listen Price was: " . $priceQ->getListenPrice());

            $newListen           = $price_from_separate_list * 120 / 100;
            $brutto_price_import = $priceQ->getListenPrice();

            if ($brutto_price_import < $newListen) {
                $brutto_price_import = $newListen;
            }

            $priceQ->setPrice($price_from_separate_list)
             ->setListenPrice($brutto_price_import)
             ->save();
            echo "modifying pseid:" . $priceQ->getProductSaleElementsId()
            . " old:" . $priceQ->getPrice() . " listen:" . $priceQ->getListenPrice()
            . " new:" . $price_from_separate_list . " listen:" . $brutto_price_import . "\n";
            if ($wholesaleProduct) {
                $wholesaleProduct
                 ->setPrice($netto_price_from_list)
                 ->setPartnerId(1)
                 ->setVersionCreatedBy("Xml_importer")
                 ->save();
                $log->debug("New wholesale partner product price: " . $wholesaleProduct->getPrice());
                echo "New wholesale partner product price: " . $wholesaleProduct->getPrice();
            }
            $log->debug("Price from list: " . $price_from_separate_list . " Price from list listen: " . $brutto_price_import);

            $log->debug("Product modified: " . $priceQ->getProductSaleElementsId() . " Product Price is: " . $priceQ->getPrice() . " Product Listen Price is: " . $priceQ->getListenPrice());
        } else {
            if ($this->no_match_count == $this->match_threshold) {
                $this->total_parsed   = $this->total_parsed + $this->no_match_count;
                echo ("NO match " . $this->total_parsed . " \n");
                $log->debug("NO match");
                $this->no_match_count = 0;
            } else {
                $this->no_match_count++;
            }
        }

        ini_set('max_execution_time', $max_time);

        if ($errors == null) {
            $this->importedRows++;
        }
        // create csv with wrong rows
        else {

            $current_date  = date("Y-m-d H:i:s");
            $csv_file_name = 'product_import_errors_' . md5($current_date) . '.txt';

            $filepath = THELIA_LOCAL_DIR . "sepa" . DS . "import" . DS . $csv_file_name;

            if (file_exists($filepath)) {
                $fp = fopen($filepath, 'a');
                fwrite($fp, $errors . PHP_EOL);
            } else {
                $fp = fopen($filepath, 'w');
                fwrite($fp, $errors . PHP_EOL);
            }

            rewind($fp);
            fclose($fp);

            if ($this->is_error_filecreated == FALSE) {
                $errors                     = "<br><br><p>Download the CSV with the products which were not imported</p><input type=\"button\" value=\"Download\" onclick=\"window.location = ' / admin / import / full - product - import / download - csv / " . $csv_file_name . "

            ';
                \"><br>" . $errors;
                $this->is_error_filecreated = TRUE;
            }
        }

        $time_end       = microtime(true);
        $execution_time = round(($time_end - $time_start) * 1000);
        $log->debug("Import duration was: " . $execution_time . " ms." . PHP_EOL);
        return $errors;
    }

    public function getLogger()
    {
        if (self::$logger == null) {
            self::$logger = Tlog::getNewInstance();
            $logFilePath  = THELIA_LOG_DIR . DS . "log-sht-price-importer.txt";
            self::$logger->setPrefix("#LEVEL: #DATE #HOUR: ");
            self::$logger->setDestinations("\\Thelia\\Log\\Destination\\TlogDestinationRotatingFile");
            self::$logger->setConfig("\\Thelia\\Log\\Destination\\TlogDestinationRotatingFile", 0, $logFilePath);
            self::$logger->setLevel(Tlog::DEBUG);
        }
        return self::$logger;
    }

}
