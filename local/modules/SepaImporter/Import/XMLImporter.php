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

class XMLImporter extends AbstractImport
{
    /* @var Tlog $log */

    protected static $logger;
    protected $is_error_filecreated = FALSE;
    protected $mandatoryColumns     = [];

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

        $log->debug("XML PRODUCT IMPORT");
        foreach ($row as $key => $value) {
            if ($value) {
                $log->debug($key . ': ' . $value);
            }
        }

        //declare global variables
        $locale              = 'de_DE';
        $productQuerry       = ProductQuery::create();
        $productQuerry->clear();
        $productExists       = null;
        $brandRefComponent   = null;
        $categoryComponent   = null;
        $brandRefId          = null;
        $refBuild            = null;
        $wholesaleProduct    = null;
        $matchingSuccessful  = FALSE;
        $price_import        = FALSE;
        $brutto_price_import = null;


        //USED
        $brand_import               = $this->rowHasField($row, "lieferantenname");
        $category_import            = $this->rowHasField($row, "warengruppetext");
        $brutto_price_import        = (float) str_replace(',', '.', $this->rowHasField($row, "bruttopreis")) * 116 / 100;
        $netto_price_import         = (float) str_replace(',', '.', $this->rowHasField($row, "nettopreis")) * 116 / 100;
        $material_number_import     = $this->rowHasField($row, "werknr");
        $stock_import               = $this->rowHasField($row, "versandfaehig");
        $product_title_import       = $this->rowHasField($row, "zeile1") . " " . $this->rowHasField($row, "zeile1");
        $ean_code_import            = $this->rowHasField($row, "ean");
        $product_picture_link       = $this->rowHasField($row, "produktbild");
        $product_description_import = $this->rowHasField($row, "ausschreibungstext");
        $partner_product_ref        = $this->rowHasField($row, "matchcode");


        echo 'XMLImporter ' . $partner_product_ref . "\n";
        //Insanity check
        if ($stock_import == null) {
            $stock_import = $this->rowHasField($row, "verf.Menge");
            $log->debug("Import menge is for updating from csv not xml." . $stock_import);
        }

        if ($material_number_import == null) {
            $log->debug("There's no Material number. This is bad!");
        }

        if ($ean_code_import == null) {
            $log->debug("There's no ean_code_import !");
        }

        if ($product_description_import == null) {
            $log->debug("There's no product_description_import !");
        }
        if ($category_import == null) {
            $log->debug("There's no category_import !");
        }
        if ($product_picture_link == null) {
            $log->debug("There's no product_picture_link !");
        }
        if ($product_title_import == null) {
            $log->debug("There's no product_title_import !");
        }
        if ($stock_import == null) {
            $log->debug("There's no stock_import !");
        }
        if ($brand_import == null) {
            $log->debug("There's no brand_import !");
        }

        if ($partner_product_ref) {
            $wholesaleProduct = WholesalePartnerProductQuery::create()
             ->findOneByPartnerProdRef($partner_product_ref);
        } else {
            $log->debug("NO matchcode! ");
        }



        if ($wholesaleProduct && $partner_product_ref) {
            $wPId = $wholesaleProduct->getProductId();
            $log->debug("After WPPQ, found product by partner ref, will update stock: " . $wPId);
            $log->debug("After WPPQ , before brand create! WPP id: " . $wPId);
        } else {
            $log->debug("No match found for partner_product_ref ");
        }


        //Brand and category check
        $eventBrandDispatcher = $this->getContainer()->get('event_dispatcher');
        $createBrandEvent     = new RevenueDashboardBrandEvent();
        $createBrandEvent->setBrand_extern($brand_import);
        $eventBrandDispatcher->dispatch(RevenueDashboardBrandEvents::FINDBRAND, $createBrandEvent);

        if ($createBrandEvent->getBrandMatch() != null) {
            $brandRefComponent = $createBrandEvent->getBrandMatch()->getBrandCode();
            $brandRefId        = $createBrandEvent->getBrandMatch()->getBrandIntern();
            $log->debug("Brand check event results " . " Brand is: " . $brandRefComponent . " Brand code is: " . $brandRefId . " Future REF is : " . $brandRefComponent . $material_number_import);
        } else {
            $errors .= "Brand name not found in database, table wholesale_partner_brand_matching " . $brand_import . PHP_EOL;
            $log->debug("Brand not found!");
        }

        $eventCategoryDispatcher = $this->getContainer()->get('event_dispatcher');
        $createCategoryEvent     = new RevenueDashboardCategoryEvent();
        $createCategoryEvent->setExtern_name($category_import);
        $eventCategoryDispatcher->dispatch(RevenueDashboardCategoryEvents::FINDCATEGORY, $createCategoryEvent);

        if ($createCategoryEvent->getCategoryMatch() != null) {
            $categoryComponent = $createCategoryEvent->getCategoryMatch()->getCategoryInternId();
            $log->debug("Category check event results, category id: " . $categoryComponent);
        } else {
            $errors .= " Category name not found in database, table wholesale_partner_category_matching " . $category_import . PHP_EOL;
            $log->debug("Category not found!");
        }

        //If both checks (brand and category have a match)
        if ($brandRefComponent != null && $categoryComponent != null) {
            $refBuild           = $brandRefComponent . $material_number_import;
            $matchingSuccessful = TRUE;
            $log->debug("Full ref: " . $refBuild);
        } else {
            echo ' brand ' . $brandRefComponent . " category " . $categoryComponent . " not found\n";
        }

        $foundExistingfProduct = $productQuerry->findOneByRef($refBuild);
        $foundProductCount     = count($foundExistingfProduct);

        if ($refBuild && $foundProductCount > 0) {
            if ($wholesaleProduct) {
                echo "WPP found " . $wholesaleProduct->getId() . " " . $wholesaleProduct->getPartnerProdRef() . " \n";
            } else {
                $productQuerry->clear();
                $foundProduct = $productQuerry->findOneByRef($refBuild)->getId();

                $wpp = new WholesalePartnerProduct();
                $wpp->setPartnerProdRef($partner_product_ref)
                 ->setProductId($foundProduct)
                 ->setPrice($netto_price_import)
                 ->setPartnerId(1)
                 ->setVersionCreatedBy("Xml_importer")
                 ->save();
                $log->debug("New wholesale partner product price: " . $wpp->getPrice());
            }
        }



        //creating a new product
        if ($foundProductCount == 0 && $matchingSuccessful) {
            $time_before_newProduct        = microtime(true);
            $execution_time_before_product = round(($time_before_newProduct - $time_start) * 1000);
            $log->debug("Exec-time before new product " . $execution_time_before_product . " ms.");

            $log->debug("Product does not exist, creating product! ");
            $eventDispatcher = $this->getContainer()->get('event_dispatcher');
            $createEvent     = new ProductCreateEvent();

            $createEvent
             ->setBasePrice($netto_price_import)
             ->setBaseQuantity($stock_import)
             ->setRef($refBuild)
             ->setTitle($product_title_import)
             ->setLocale($locale)
             ->setDefaultCategory($categoryComponent)
             ->setTaxRuleId(1)
             ->setTemplateId(1)
             ->setCurrencyId(1);

            $eventDispatcher->dispatch(TheliaEvents::PRODUCT_CREATE, $createEvent);

            $product = ProductQuery::create()
             ->filterByRef($createEvent->getProduct()->getRef())
             ->withColumn('product.id', 'product_id')
             ->setFormatter(ModelCriteria::FORMAT_ON_DEMAND)
             ->findOne();

            $log->debug("New Product Ref: " . $createEvent->getProduct()->getRef());
            $product_id = $product->getId();
            echo "Creating product: " . $product_id . "\n";
            $log->debug("New Product id: " . $product_id);

            $productPse = ProductSaleElementsQuery::create()
             ->filterByProductId($product_id)
             ->withColumn('product_sale_elements.id', 'pse_id')
             ->setFormatter(ModelCriteria::FORMAT_ON_DEMAND)
             ->findOne();

            $pse_id = $productPse->getId();

            $updatePse = new ProductSaleElementUpdateEvent($product, $pse_id);


            $log->debug("New Product Ref PSE ID: " . $pse_id);

            if ($netto_price_import != null) {
                $updatePse->setPrice($netto_price_import);
                $log->debug("New Product price :" . $updatePse->getPrice());
            }

            if ($brutto_price_import != null) {
                $updatePse->setListenPrice($brutto_price_import);
                $log->debug("New Product Listen price :" . $updatePse->getListenPrice());
            }

            if ($ean_code_import != null) {
                $updatePse->setEanCode($ean_code_import);
                $log->debug("New Product EAN :" . $updatePse->getEanCode());
            }

            $updatePse
             ->setReference($refBuild)
             ->setSalePrice(0)
             ->setTaxRuleId(1)
             ->setQuantity($stock_import)
             ->setOnsale(0)
             ->setIsdefault(1)
             ->setCurrencyId(1);

            $eventDispatcher->dispatch(TheliaEvents::PRODUCT_UPDATE_PRODUCT_SALE_ELEMENT, $updatePse);

            $eventProductUpdateDispatcher = $this->getContainer()->get('event_dispatcher');

            $updateEvent = new ProductUpdateEvent($product_id);

            $updateEvent
             ->setLocale($locale)
             ->setBasePrice($netto_price_import)
             ->setBaseQuantity($stock_import)
             ->setQuantity($stock_import)
             ->setRef($refBuild)
             ->setTitle($product_title_import)
             ->setLocale($locale)
             ->setDefaultCategory($categoryComponent)
             ->setTaxRuleId(1)
             ->setTemplateId(1)
             ->setBrandId($brandRefId);



            if ($product_description_import != null) {
                $updateEvent->setDescription($product_description_import);
                $log->debug("New Product descrip: " . $updateEvent->getDescription() . " on product_id: " . $product_id);
            }

            $eventProductUpdateDispatcher->dispatch(TheliaEvents::PRODUCT_UPDATE, $updateEvent);

            $image_path  = THELIA_LOCAL_DIR . "media" . DS . "images" . DS . "product" . DS;
            $image_name  = 'PROD_' . preg_replace("/[^a-zA-Z0-9.]/", "", $refBuild) . ".jpg";
            $currentDate = date("Y-m-d H:i:s");

            try {
                $log->debug("Importing from Mysht picture");
                $time_after_before_picture     = microtime(true);
                $execution_time_before_picture = round(($time_after_before_picture - $time_start) * 1000);
                $log->debug("Exec-time before picture " . $execution_time_before_picture . " ms.");
                $image_from_server             = @file_get_contents($product_picture_link);
            } catch (Exception $e) {
                $log->debug("ProductImageException :" . $e->getMessage());
            }

            if ($image_from_server) {
                $log->debug("New Product importing image saved to " . $image_path . $image_name);
                file_put_contents($image_path . $image_name, $image_from_server);

                $product_image = new ProductImage ();
                $product_image->setProduct($product);
                $product_image->setVisible(1);
                $product_image->setCreatedAt($currentDate);
                $product_image->setUpdatedAt($currentDate);
                $product_image->setFile($image_name);
                $product_image->save();


                $product_image_i18n = new ProductImageI18n();
                $product_image_i18n->setProductImage($product_image);
                $product_image_i18n->setTitle($refBuild);
                $product_image_i18n->setDescription($refBuild . "1");
                $product_image_i18n->setChapo($refBuild . "1");
                $product_image_i18n->setPostscriptum($refBuild . "1");
                $product_image_i18n->setLocale($locale);
                $product_image_i18n->save();

                $product->addProductImage($product_image);
            } else {
                $log->debug(" Image not saved.");
            }

            $time_after_newProduct        = microtime(true);
            $execution_time_after_product = round(($time_after_newProduct - $time_start) * 1000);
            $log->debug("Exec-time after new product " . $execution_time_after_product . " ms.");
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
            $logFilePath  = THELIA_LOG_DIR . DS . "log-sht-xml-importer.txt";
            self::$logger->setPrefix("#LEVEL: #DATE #HOUR: ");
            self::$logger->setDestinations("\\Thelia\\Log\\Destination\\TlogDestinationRotatingFile");
            self::$logger->setConfig("\\Thelia\\Log\\Destination\\TlogDestinationRotatingFile", 0, $logFilePath);
            self::$logger->setLevel(Tlog::DEBUG);
        }
        return self::$logger;
    }

}
