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

    public function rowHasField($row, $field)
    {
        if (isset($row[$field])) {
            return $row[$field];
        }
        return null;
    }

    public function importData(array $row)
    {
        $errors = null;

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

        $log->debug("After variable initialisation, before brand create!");

        $eventBrandDispatcher = $this->getContainer()->get('event_dispatcher');
        $createBrandEvent     = new RevenueDashboardBrandEvent();
        $createBrandEvent->setBrand_extern($this->rowHasField($row, "lieferantenname"));
        $eventBrandDispatcher->dispatch(RevenueDashboardBrandEvents::FINDBRAND, $createBrandEvent);

        if ($createBrandEvent->getBrandMatch() != null) {
            $brandRefComponent = $createBrandEvent->getBrandMatch()->getBrandCode();
            $brandRefId        = $createBrandEvent->getBrandMatch()->getBrandIntern();
        } else {
            $errors .= "Brand name not found in database, table wholesale_partner_brand_matching " . $this->rowHasField($row, "lieferantenname" . "\n");
        }

        $log->debug("After brand check event. Brand check event results: " . $brandRefComponent . $brandRefId);

        $log->debug("Before category check event");

        $eventCategoryDispatcher = $this->getContainer()->get('event_dispatcher');
        $createCategoryEvent     = new RevenueDashboardCategoryEvent();
        $createCategoryEvent->setExtern_name($this->rowHasField($row, "warengruppetext"));
        $eventBrandDispatcher->dispatch(RevenueDashboardCategoryEvents::FINDCATEGORY, $createCategoryEvent);

        if ($createCategoryEvent->getCategoryMatch() != null) {
            $categoryComponent = $createCategoryEvent->getCategoryMatch()->getCategoryInternId();
        } else {
            $errors .= " Category name not found in database, table wholesale_partner_category_matching " . $this->rowHasField($row, "warengruppetext" . "\n");
        }

        $log->debug("After category check event. Brand check event results: " . $categoryComponent);




        if ($brandRefComponent != null && $categoryComponent != null) {
            $refBuild           = $brandRefComponent . $this->rowHasField($row, "werknr");
            $matchingSuccessful = TRUE;
            $log->debug("After Ref Build: " . $refBuild . " Product Exists?: " . $productExists);
        }

        $productExists = count($productQuerry->findByRef($refBuild));




        if ($productExists == 0 && $matchingSuccessful) {
            $log->debug("Before Product create event, in IF clause");
            $eventDispatcher = $this->getContainer()->get('event_dispatcher');
            $createEvent     = new ProductCreateEvent();
            $locale          = "de_DE";

            $createEvent
             ->setBasePrice(($this->rowHasField($row, "nettopreis")) * 116 / 100)
             ->setBaseQuantity($this->rowHasField($row, "versandfaehig"))
             ->setRef($refBuild)
             ->setTitle($this->rowHasField($row, "zeile1") . " " . $this->rowHasField($row, "zeile1"))
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

            $product_id = $product->getId();

            $productPse = ProductSaleElementsQuery::create()
             ->filterByProductId($product_id)
             ->withColumn('product_sale_elements.id', 'pse_id')
             ->setFormatter(ModelCriteria::FORMAT_ON_DEMAND)
             ->findOne();

            $pse_id = $productPse->getId();

            $updatePse = new ProductSaleElementUpdateEvent($product, $pse_id);

            $log->debug("After Update PSE");

            $ean_code = ($this->rowHasField($row, "ean"));

            $log->debug($ean_code + " EAN CODE " + $pse_id + "PSE ID");

            if ($this->rowHasField($row, "nettopreis") != null) {
                $updatePse->setPrice(($this->rowHasField($row, "nettopreis")) * 116 / 100);
            }
            if ($this->rowHasField($row, "bruttopreis") != null) {
                $updatePse->setListenPrice(($this->rowHasField($row, "bruttopreis")) * 116 / 100);
            }

            $updatePse->setEanCode($ean_code)
             ->setReference($refBuild)
             ->setSalePrice(0)
             ->setTaxRuleId(1)
             ->setQuantity($this->rowHasField($row, "versandfaehig"))
             ->setOnsale(0)
             ->setIsdefault(1)
             ->setCurrencyId(1);

            $eventDispatcher->dispatch(TheliaEvents::PRODUCT_UPDATE_PRODUCT_SALE_ELEMENT, $updatePse);

            $log->debug("After PSE dispatch");

            //Product Update Event pentru description si poate altele daca o sa mai fie nevoie
            $eventProductUpdateDispatcher = $this->getContainer()->get('event_dispatcher');



            $updateEvent = new ProductUpdateEvent($product_id);

            $updateEvent
             ->setDescription(($this->rowHasField($row, "ausschreibungstext")))
             ->setLocale($locale)
             ->setBasePrice(($this->rowHasField($row, "nettopreis")) * 116 / 100)
             ->setBaseQuantity($this->rowHasField($row, "versandfaehig"))
             ->setQuantity($this->rowHasField($row, "versandfaehig"))
             ->setRef($refBuild)
             ->setTitle($this->rowHasField($row, "zeile1") . " " . $this->rowHasField($row, "zeile1"))
             ->setLocale($locale)
             ->setDefaultCategory($categoryComponent)
             ->setTaxRuleId(1)
             ->setTemplateId(1)
             ->setBrandId($brandRefId);

            $log->debug("After set descrip" . $updateEvent->getDescription() . " " . $product_id);
            $eventProductUpdateDispatcher->dispatch(TheliaEvents::PRODUCT_UPDATE, $updateEvent);

            //REVENUE DASHBOARD -- ii foarte complex facut dar nu-i folosit deloc deci ar trebui populat

            $revenueDash = new WholesalePartnerProduct();

            if ($this->rowHasField($row, "nettopreis") != null) {
                $revenueDash->setPrice(($this->rowHasField($row, "nettopreis")) * 116 / 100);
            }


            //save images

            $log->debug("Save images part");

            $image_path  = THELIA_LOCAL_DIR . "media" . DS . "images" . DS . "product" . DS;
            $image_name  = 'PROD_' . preg_replace("/[^a-zA-Z0-9.]/", "", $refBuild) . ".jpg";
            $currentDate = date("Y-m-d H:i:s");

            $log->debug("generic_product_import image");

            try {
                $log->debug("Importing from Mysht picture");
                $image_from_server = @file_get_contents($this->rowHasField($row, "produktbild"));
            } catch (Exception $e) {
                $log->debug("ProductImageException :" . $e->getMessage());
            }

            if ($image_from_server) {
                $log->debug(" generic_product_import image saved to " . $image_path);
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
            }
        } else {
            $errors .= " Product already in database " . $refBuild . ".";
            $log->debug("Product Already exists (else loop).");
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
