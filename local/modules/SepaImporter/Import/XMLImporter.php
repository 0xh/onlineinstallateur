<?php

namespace SepaImporter\Import;

use Propel\Runtime\ActiveQuery\ModelCriteria;
use RevenueDashboard\Events\RevenueDashboardBrandEvent;
use RevenueDashboard\Events\RevenueDashboardBrandEvents;
use RevenueDashboard\Events\RevenueDashboardCategoryEvent;
use RevenueDashboard\Events\RevenueDashboardCategoryEvents;
use RevenueDashboard\Model\WholesalePartnerProduct;
use Symfony\Component\Serializer\Exception\Exception;
use Thelia\Core\Event\Product\ProductCreateEvent;
use Thelia\Core\Event\Product\ProductUpdateEvent;
use Thelia\Core\Event\ProductSaleElement\ProductSaleElementUpdateEvent;
use Thelia\Core\Event\TheliaEvents;
use Thelia\ImportExport\Import\AbstractImport;
use Thelia\Log\Tlog;
use Thelia\Model\Base\ProductQuery;
use Thelia\Model\ProductSaleElements;
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

class XMLImporter extends AbstractImport
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
        $time_start = microtime(true);
        $errors     = null;

        $log      = $this->getLogger();
        $max_time = ini_get("max_execution_time");
        ini_set('max_execution_time', 60000);
        $i        = 0;

        $log->debug("STARTED");

        $log->debug("XML PRODUCT IMPORT");
        foreach ($row as $key => $value) {
            if ($value) {
                $log->debug($key . ': ' . $value);
            }
        }

        $productQuerry      = ProductQuery::create();
        $productQuerry->clear();
        $productExists      = null;
        $brandRefComponent  = null;
        $categoryComponent  = null;
        $brandRefId         = null;
        $matchingSuccessful = FALSE;
        $refBuild           = null;


        //USED
        $brand_import               = $this->rowHasField($row, "lieferantenname");
        $category_import            = $this->rowHasField($row, "warengruppetext");
        $brutto_price_import        = $this->rowHasField($row, "bruttopreis") * 116 / 100;
        $netto_price_import         = $this->rowHasField($row, "nettopreis") * 116 / 100;
        $material_number_import     = $this->rowHasField($row, "werknr");
        $stock_import               = $this->rowHasField($row, "versandfaehig");
        $product_title_import       = $this->rowHasField($row, "zeile1") . " " . $this->rowHasField($row, "zeile1");
        $ean_code_import            = $this->rowHasField($row, "ean");
        $product_picture_link       = $this->rowHasField($row, "produktbild");
        $product_description_import = $this->rowHasField($row, "ausschreibungstext");

        //NOT USED
//        $kurze_beschreibung = $this->rowHasField($row, "Kurze_beschreibung");
//        $postscriptum      = $this->rowHasField($row, "Postscriptum");
//        $meta_titel        = $this->rowHasField($row, "Meta_titel");
//        $meta_beschreibung = $this->rowHasField($row, "Meta_beschreibung");
//        $meta_keywords     = $this->rowHasField($row, "Meta_keywords");
//        $fulfilment_center = $this->rowHasField($row, "Fulfilment_center");
//        $ist_in_Angebot    = $this->rowHasField($row, "Ist_in_Angebot");
//        $ist_neu           = $this->rowHasField($row, "Ist_neu");
//        $ist_online        = $this->rowHasField($row, "Ist_online");
//        $gewicht           = $this->rowHasField($row, "Gewicht");
//        $bild_titel             = $this->rowHasField($row, "Bild_titel");
//        $bild_beschreibung      = $this->rowHasField($row, "Bild_beschreibung");
//        $bild_kurz_beschreibung = $this->rowHasField($row, "Bild_kurz_beschreibung");
//        $bild_postscriptum      = $this->rowHasField($row, "Bild_postscriptum");
//        $bild_file              = $this->rowHasField($row, "Bild_file");
//        $promo_price            = $this->rowHasField($row, "Promo_price");
//        $ek_preis_sht           = $this->rowHasField($row, "Ek_preis_sht");
//        $ek_preis_gc            = $this->rowHasField($row, "Ek_preis_gc");
//        $ek_preis_oag           = $this->rowHasField($row, "Ek_preis_oag");
//        $ek_preis_holter        = $this->rowHasField($row, "Ek_preis_holter");
//        $preis_reuter           = $this->rowHasField($row, "Preis_reuter");
//        $vergleich_ek           = $this->rowHasField($row, "Vergleich_ek");
//        $aufschlag              = $this->rowHasField($row, "Aufschlag");
//        $template_id            = $this->rowHasField($row, "Template_id");

        if ($material_number_import == null) {
            $log->debug("There's no Material number. This is bad!");
        }

        if ($brutto_price_import == null) {
            $log->debug("There's no BRUTTO PRICE! This is bad");
        }

        if ($netto_price_import == null) {
            $netto_price_import = $brutto_price_import;
            $log->debug("There's no NETTO PRICE!");
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

        $log->debug("After variable initialisation, before brand create!");

        $eventBrandDispatcher = $this->getContainer()->get('event_dispatcher');
        $createBrandEvent     = new RevenueDashboardBrandEvent();
        $createBrandEvent->setBrand_extern($brand_import);
        $eventBrandDispatcher->dispatch(RevenueDashboardBrandEvents::FINDBRAND, $createBrandEvent);

        if ($createBrandEvent->getBrandMatch() != null) {
            $brandRefComponent = $createBrandEvent->getBrandMatch()->getBrandCode();
            $brandRefId        = $createBrandEvent->getBrandMatch()->getBrandIntern();
        } else {
            $errors .= "Brand name not found in database, table wholesale_partner_brand_matching " . $brand_import . PHP_EOL;
        }

        $log->debug("After brand check event. Brand check event results: " . " Brand is: " . $brandRefComponent . " Brand code is: " . $brandRefId . " Future REF is : " . $brandRefComponent . $material_number_import);

        $log->debug("Before category check event");

        $eventCategoryDispatcher = $this->getContainer()->get('event_dispatcher');
        $createCategoryEvent     = new RevenueDashboardCategoryEvent();
        $createCategoryEvent->setExtern_name($category_import);
        $eventCategoryDispatcher->dispatch(RevenueDashboardCategoryEvents::FINDCATEGORY, $createCategoryEvent);

        if ($createCategoryEvent->getCategoryMatch() != null) {
            $categoryComponent = $createCategoryEvent->getCategoryMatch()->getCategoryInternId();
        } else {
            $errors .= " Category name not found in database, table wholesale_partner_category_matching " . $category_import . PHP_EOL;
        }

        $log->debug("After category check event. Brand check event results: " . " Category id is: " . $categoryComponent);

        if ($brandRefComponent != null && $categoryComponent != null) {
            $refBuild           = $brandRefComponent . $material_number_import;
            $matchingSuccessful = TRUE;
            $log->debug("After Ref Build: " . $refBuild . " Product Exists?: " . $productExists);
        }

        $productExists = count($productQuerry->findByRef($refBuild));
        $log->debug("Product Exists? " . $productExists);


        if ($productExists == 0 && $matchingSuccessful) {
            $log->debug("Product does not exist, creating product! ");
            $eventDispatcher = $this->getContainer()->get('event_dispatcher');
            $createEvent     = new ProductCreateEvent();
            $locale          = "de_DE";

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

            $log->debug("After Product create event dispatcher");

            $product = ProductQuery::create()
             ->filterByRef($createEvent->getProduct()->getRef())
             ->withColumn('product.id', 'product_id')
             ->setFormatter(ModelCriteria::FORMAT_ON_DEMAND)
             ->findOne();

            $log->debug($createEvent->getProduct()->getRef() . "GETREF");
            $product_id = $product->getId();
            $log->debug($product_id . "DASA");

            $productPse = ProductSaleElementsQuery::create()
             ->filterByProductId($product_id)
             ->withColumn('product_sale_elements.id', 'pse_id')
             ->setFormatter(ModelCriteria::FORMAT_ON_DEMAND)
             ->findOne();

//            $log->debug($productPse);
            $pse_id = $productPse->getId();

            $updatePse = new ProductSaleElementUpdateEvent($product, $pse_id);

            $log->debug("After Update PSE");
            $log->debug("EAN CODE:" . $ean_code_import);
            $log->debug("PSE ID: " . $pse_id);

            if ($netto_price_import != null) {
                $updatePse->setPrice($netto_price_import);
            }
            if ($brutto_price_import != null) {
                $updatePse->setListenPrice($brutto_price_import);
            }

            $updatePse->setEanCode($ean_code_import)
             ->setReference($refBuild)
             ->setSalePrice(0)
             ->setTaxRuleId(1)
             ->setQuantity($stock_import)
             ->setOnsale(0)
             ->setIsdefault(1)
             ->setCurrencyId(1);

            //eventurile pun pe NULL tot ce nu dai
            $eventDispatcher->dispatch(TheliaEvents::PRODUCT_UPDATE_PRODUCT_SALE_ELEMENT, $updatePse);

            $log->debug("After PSE dispatch");
            //Product Update Event pentru description si poate altele daca o sa mai fie nevoie
            $eventProductUpdateDispatcher = $this->getContainer()->get('event_dispatcher');

            $updateEvent = new ProductUpdateEvent($product_id);

            $updateEvent
             ->setDescription($product_description_import)
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

            $log->debug("After set descrip" . $updateEvent->getDescription() . " " . $product_id);
            $eventProductUpdateDispatcher->dispatch(TheliaEvents::PRODUCT_UPDATE, $updateEvent);

            //REVENUE DASHBOARD -- ii foarte complex facut dar nu-i folosit deloc deci ar trebui populat

            $revenueDash = new WholesalePartnerProduct();

            if ($netto_price_import != null) {
                $revenueDash->setPrice($netto_price_import);
            }


            //save images
            $log->debug("Save images part");

            $image_path  = THELIA_LOCAL_DIR . "media" . DS . "images" . DS . "product" . DS;
            $image_name  = 'PROD_' . preg_replace("/[^a-zA-Z0-9.]/", "", $refBuild) . ".jpg";
            $currentDate = date("Y-m-d H:i:s");

            try {
                $log->debug("Importing from Mysht picture");
                $image_from_server = @file_get_contents($product_picture_link);
            } catch (Exception $e) {
                $log->debug("ProductImageException :" . $e->getMessage());
            }

            if ($image_from_server) {
                $log->debug("Image saved. ");
                $log->debug("Importing image saved to " . $image_path . $image_name);
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
                $product_image_i18n->setLocale("de_DE");
                $product_image_i18n->save();

                $product->addProductImage($product_image);
            } else {
                $log->debug(" Image not saved.");
            }
        } else if ($matchingSuccessful) {
            $errors .= " Product already in database, Updating prices and quantity for Ref: " . $refBuild . "." . PHP_EOL;
            $log->debug("Product already exists. Updating!");

            $log->debug("REF IS: " . $refBuild);

            $product = ProductQuery::create()
             ->findOneByRef($refBuild);

            $product_id = $product->getId();
            $log->debug("Product id is: " . $product_id);

            $productPse = ProductSaleElementsQuery::create()
             ->findOneByProductId($product_id);

            $pse_id = $productPse->getId();
            $log->debug("Pse Id from PSE query is: " . $pse_id);

            $productPseImport = $productPse;
            $productPseImport->setQuantity($stock_import)
             ->save();

            $log->debug("Product Pse Is " . $productPse->getId() . " Prod quantity is: " . $productPseImport->getQuantity());


            $priceQ = ProductPriceQuery::create()
             ->filterByProductSaleElementsId($pse_id)
             ->findOneByCurrencyId(1);

            $log->debug("Price found: " . $priceQ->getProductSaleElementsId() . " Product Price Was: " . $priceQ->getPrice() . " Product Listen Price was: " . $priceQ->getListenPrice());

            $priceQ->setPrice($netto_price_import)
             ->setListenPrice($brutto_price_import)
             ->save();

            $log->debug("Product modified: " . $priceQ->getProductSaleElementsId() . " Product Price is: " . $priceQ->getPrice() . " Product Listen Price is: " . $priceQ->getListenPrice());
        } else {
            $log->debug("NO match");
            $errors .= " Product does not exist! " . $refBuild . "." . PHP_EOL;
        }

        ini_set('max_execution_time', $max_time);

        if ($errors == null) {
            $this->importedRows++;
        }        // create csv with wrong rows
        else {

            $current_date  = date("Y-m-d H:i:s");
            $csv_file_name = 'product_import_errors_' . md5($current_date) . '.txt';
//            $session = $this->container->get('request_stack')->getCurrentRequest()->getSession();
//            $session->set('csvFileName', $csv_file_name);

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
                $errors                     = "<br><br><p>Download the CSV with the products which were not imported</p><input type=\"button\" value=\"Download\" onclick=\"window.location = '/admin/import/full-product-import/download-csv/" . $csv_file_name . "';
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
            $logFilePath  = THELIA_LOG_DIR . DS . "log-generic-importer.txt";
            self::$logger->setPrefix("#LEVEL: #DATE #HOUR: ");
            self::$logger->setDestinations("\\Thelia\\Log\\Destination\\TlogDestinationRotatingFile");
            self::$logger->setConfig("\\Thelia\\Log\\Destination\\TlogDestinationRotatingFile", 0, $logFilePath);
            self::$logger->setLevel(Tlog::DEBUG);
        }
        return self::$logger;
    }

}
