<?php

namespace SepaImporter\Import;

use Propel\Runtime\ActiveQuery\ModelCriteria;
use RevenueDashboard\Events\RevenueDashboardBrandEvent;
use RevenueDashboard\Events\RevenueDashboardBrandEvents;
use RevenueDashboard\Events\RevenueDashboardCategoryEvent;
use RevenueDashboard\Events\RevenueDashboardCategoryEvents;
use RevenueDashboard\Model\WholesalePartnerProduct;
use RevenueDashboard\Model\WholesalePartnerProductQuery;
use Symfony\Component\Serializer\Exception\Exception;
use Thelia\Core\Event\Product\ProductCreateEvent;
use Thelia\Core\Event\Product\ProductUpdateEvent;
use Thelia\Core\Event\ProductSaleElement\ProductSaleElementUpdateEvent;
use Thelia\Core\Event\TheliaEvents;
use Thelia\ImportExport\Import\AbstractImport;
use Thelia\Log\Tlog;
use Thelia\Model\Base\ProductQuery;
use Thelia\Model\Base\ProductSaleElementsQuery;
use Thelia\Model\ProductImage;
use Thelia\Model\ProductImageI18n;
use Thelia\Model\ProductPriceQuery;
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

class ShtStockImporter extends AbstractImport
{
    /* @var Tlog $log */

    protected static $logger;
    protected $is_error_filecreated = FALSE;

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

        $log->debug("SHT STOCK IMPORT");
        foreach ($row as $key => $value) {
            if ($value) {
                $log->debug($key . ': ' . $value);
            }
        }

        //declare global variables
        $locale                         = 'de_DE';
        $productExists                  = null;
        $brandRefComponent              = null;
        $categoryComponent              = null;
        $brandRefId                     = null;
        $refBuild                       = null;
        $wholesaleProduct               = null;
        $matchingSuccessful             = FALSE;
        $stockImport                    = FALSE;
        $price_import                   = FALSE;
        $partner_product_ref_price_list = null;
        $brutto_price_import            = null;


        //USED
        $partner_product_ref            = $this->rowHasField($row, "matchcode");
        $stock_import                   = $this->rowHasField($row, "verf.Menge");
        //Insanity check
        if ($stock_import == null) {
            $log->debug("There's no stock_import !");
        }

        if ($partner_product_ref) {
            $wholesaleProduct = WholesalePartnerProductQuery::create()
             ->findOneByPartnerProdRef($partner_product_ref);
        } else {
            $log->debug("NO matchcode! ");
        }

        if ($wholesaleProduct && $partner_product_ref) {
            $wPId        = $wholesaleProduct->getProductId();
            $log->debug("After WPPQ, found product by partner ref, will update stock: " . $wPId);
            $stockImport = TRUE;
            $log->debug("After WPPQ , before brand create! WPP id: " . $wPId);
        } else {
            $log->debug("No match found for partner_product_ref ");
        }

        if ($stockImport) {
            $time_before_update           = microtime(true);
            $execution_time_before_update = round(($time_before_update - $time_start) * 1000);
            $log->debug("Starting stock update.");
            $log->debug("Exec-time before product update " . $execution_time_before_update . " ms.");

            $newProdId = $wholesaleProduct->getProductId();

            echo "Modifying stock " . $newProdId . "\n";

            $product    = ProductQuery::create()
             ->findOneById($newProdId);
            $product_id = $product->getId();
            $log->debug("Product already in database, found match for WPP_id: " . $wholesaleProduct->getId() . "for product id: " . $product_id . " and ref: " . $product->getRef() . PHP_EOL);

            $productPse = ProductSaleElementsQuery::create()
             ->findOneByProductId($product_id);

            $pse_id = $productPse->getId();
            $log->debug("In WPID MATCH, pse_id: " . $pse_id);

            $productPseImport = $productPse;
            $productPseImport->setQuantity($stock_import)
             ->save();

            $log->debug("Modified quantity, new quantity: " . $productPseImport->getQuantity());

            $time_after_update           = microtime(true);
            $execution_time_after_update = round(($time_after_update - $time_start) * 1000);
            $log->debug("Exec-time after product update " . $execution_time_after_update . " ms.");
        } else {
            $log->debug("NO match");
            $errors .= " Product ref not found! " . $refBuild . "." . PHP_EOL;
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
            $logFilePath  = THELIA_LOG_DIR . DS . "log-sht-stock-importer.txt";
            self::$logger->setPrefix("#LEVEL: #DATE #HOUR: ");
            self::$logger->setDestinations("\\Thelia\\Log\\Destination\\TlogDestinationRotatingFile");
            self::$logger->setConfig("\\Thelia\\Log\\Destination\\TlogDestinationRotatingFile", 0, $logFilePath);
            self::$logger->setLevel(Tlog::DEBUG);
        }
        return self::$logger;
    }

}
