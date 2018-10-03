<?php

namespace SepaImporter\Import;

use Propel\Runtime\ActiveQuery\ModelCriteria;
use RevenueDashboard\Model\Base\WholesalePartnerProduct;
use SepaImporter\Model\SepaimporterBrandMapping;
use SepaImporter\Model\SepaimporterBrandMappingQuery;
use Thelia\Core\Event\Product\ProductCreateEvent;
use Thelia\Core\Event\Product\ProductUpdateEvent;
use Thelia\Core\Event\ProductSaleElement\ProductSaleElementUpdateEvent;
use Thelia\Core\Event\TheliaEvents;
use Thelia\ImportExport\Import\AbstractImport;
use Thelia\Log\Tlog;
use Thelia\Model\Base\ProductQuery;
use Thelia\Model\Base\ProductSaleElementsQuery;
use Thelia\Model\BrandQuery;

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

/**
 * Class ProductPricesImport
 * @author Benjamin Perche <bperche@openstudio.fr>
 */
class XMLImporter extends AbstractImport
{
    /* @var Tlog $log */

    protected static $logger;
    protected $mandatoryColumns = [
//     'Ref'
    ];
    protected $hanH             = "HG";
    protected $han              = "HAN";
    protected $gro              = "G";
    protected $lau              = "ROC";
    protected $upo              = "UPO";
    protected $klu              = "KL";
    protected $dan              = "DF";
    protected $honvtl           = "HONVTL";
    protected $vai              = "VA";
    protected $refSearch        = "";

    public function rowHasField($row, $field)
    {
        if (isset($row[$field])) {
            return utf8_encode($row[$field]);
        }
        return null;
    }

    public function importData(array $row)
    {
        $errors = null;

        //PRODUCT CREATE EVENT care introduce produsul prima data in DB, ca si stand-alone product.
        //Aici daca vrem sa facem update probabil ar trebui si-un loop pe products care sa vada daca exista in lista iar daca nu exista, sa le puna offline
        //Aici ar fi buna o legatura/tabela sa vedem care produs vine de la care vendor asa ca sa facem un Querry pe toate product_id-urile din tabela aia
        //care sa puna produsele offline daca nu exista in xml-ul current.
        //Nu stiu exact cum sa fac iteratia 1:1 inca dar stiu ca trebuie extra tabele sa tinem informatia cu de unde vine produsul.

        $productQuerry   = ProductQuery::create();
        $productQuerry->clear();
//        $productExists = count($productQuerry->findByRef($this->rowHasField($row, "megabildnr")));
//
//        if ($productExists == 0) {
        // @var EventDispatcherInterface $eventDispatcher
        $eventDispatcher = $this->getContainer()->get('event_dispatcher');

        $createEvent = new ProductCreateEvent();

        $locale = "de_DE";

        Tlog::getInstance()->err("inainte de dollar create event si adding.");

        $createEvent
         ->setBasePrice(($this->rowHasField($row, "nettopreis")) * 116 / 100)
         ->setBaseQuantity($this->rowHasField($row, "versandfaehig"))
         ->setRef($this->rowHasField($row, "megabildnr"))
         ->setTitle($this->rowHasField($row, "zeile1") + $this->rowHasField($row, "zeile1"))
         ->setLocale($locale)
         ->setDefaultCategory(11)
         ->setCurrencyId(1);


        $eventDispatcher->dispatch(TheliaEvents::PRODUCT_CREATE, $createEvent);
//         } else
//            {
//
//         }
        //AICI SE TERMINA IF-ul cu IF PRODUCT EXISTS CA DUPAIA TOT CE-I DUPA SA FIE EVENT TRIGGERED SI SA-SI DEA UPDATE.

        Tlog::getInstance()->err("Dupa create event.");

        Tlog::getInstance()->err("Dupa event dispatcher");

        $product = ProductQuery::create()
         ->filterByRef($createEvent->getProduct()->getRef())
         ->withColumn('product.id', 'product_id')
         ->setFormatter(ModelCriteria::FORMAT_ON_DEMAND)
         ->findOne();

        $product_id = $product->getId();

        //Product Update Event pentru description si poate altele daca o sa mai fie nevoie
        $updateEvent = new ProductUpdateEvent($product_id);

        //Din pacate nu toate au asta deci trebuie sa vedem cum facem, indiferent de algere, as prefera o metoda prin care fetch-uim descrierea de undeva si o punem
        //intr-o structura ca aia pe care o facusem eu dinamica in excel, banuisc ca cu un pic de timp si de ajutor as putea sa o replicate-uiesc si in PHP ceea ce ar
        //insemna ca basically o sa pot sa fac o descriere cu toate elementele de UX, gen title bolduit, produktmerkale cu bullet points, eu zic ca orice proces dezvoltam
        //pentru import ar trebui sa fie asa facut, ne-ar scuti de multa munca pe long-term.
        $updateEvent->setDescription(($this->rowHasField($row, "ausschreibungstext")));

        Tlog::getInstance()->err("Dupa set descrip");


        //Product PSE update pentru PSE table content (inclusiv price chiar daca-i tehnic tablea diferita, aici exista eventul pt ea)+EAN
        //Daca inteleg cum functioneaza si ii truly un update event, ar trebui sa update-uiasca elementele nu sa creeze unele noi, atunci asta ar rezolva problema cu
        //price-updates, tot timpul cand s-ar face cron job-ul de rulat XML-ul
        $productPse = ProductSaleElementsQuery::create()
         ->filterByProductId($product_id)
         ->withColumn('product_sale_elements.id', 'pse_id')
         ->setFormatter(ModelCriteria::FORMAT_ON_DEMAND)
         ->findOne();

        $pse_id = $productPse->getId();

        $updatePse = new ProductSaleElementUpdateEvent($product, $pse_id);

        $ean_code = ($this->rowHasField($row, "ean"));

//        Tlog::getInstance()->error($ean_code + " EAN CODE " + $pse_id + "PSE ID" + var_dump($updatePse) + " Update PSE ");

        $updatePse->setEanCode($ean_code)
         ->setListenPrice($this->rowHasField($row, "bruttopreis") * 116 / 100)
         ->setPrice(($this->rowHasField($row, "nettopreis")) * 116 / 100)
         ->setReference($this->rowHasField($row, "megabildnr"))
         ->setCurrencyId(1);

        $eventDispatcher->dispatch(TheliaEvents::PRODUCT_UPDATE_PRODUCT_SALE_ELEMENT, $updatePse);

        Tlog::getInstance()->err("Dupa PSE");

        //REVENUE DASHBOARD -- ii foarte complex facut dar nu-i folosit deloc deci ar trebui populat

        $revenueDash = WholesalePartnerProduct::create();
        $revenueDash->setPrice();





        /* how to determine Source Name? Hardcoded in importer until we have more than 1 supplier? and then add a general hint/feature/info to the importer when importing
         * a dropdown meniu in the template for example where you select an option and pass it as a method argument or adding a  certain tag inside the XML but then we would
         * need to require that from every supplier.
         */
        $eventBrand = $this->rowHasField($row, "lieferantennam");

        $brand_new = SepaimporterBrandMappingQuery::create()
         ->findOneBySourceBrandName($eventBrand);

        $brand_old = SepaimporterBrandMappingQuery::create()
         ->findOneBySourceBrandName($eventBrand)
         ->getId();

        $source        = "mysht";
        $productQuerry = ProductQuery::create();

        $productForBrand = $productQuerry
         ->findOneByRef($this->rowHasField($row, "megabildnr"));

        if (!$brand_new) {
            $brandAdd = new SepaimporterBrandMapping();
            $brandAdd->setSourceBrandName($eventBrand)
             ->setSourceName($source);
        } else {
            $brand = BrandQuery::create()->findOneById($brand_old);
            $productForBrand->setBrand($brand);
        }
        //Cum vad eu aici ar fi ideal sa mai fie inca o coloana in tabla cu perscurtarea, care sa fie dupaia bagata cu werknummer care practic dupaia sa determine reful
        //dupa ce-i determinata prescurtarea din tablea, practic o sa se ia werknummerul din xml, se face join cu prescurtarea, se verifica daca exista la noi deja si
        //in principiu asta ar fi un check destul de bun pentru a verifica daca exista produse. In functie de scala la care urcam, ar fi ideal sa putem sa avem o structura
        //in DB cat mai ok dpdv modularitate, deci la new vendors sa


        Tlog::getInstance()->err("Dupa set brand!");

        //Category
        //La category daca am primi de la ei o structura de categorii cu nume si Id-uri (Warengruppe/WarrengruppeText) am putea sa incercam sa facem ceva sort of mapping
        //nu stiu cum s-ar face in php dar eventual un regex facut care sa faca matching intre ele, problema ar fi cand ar aparea noi vendori. Categorile mi se
        //par problematice pentru ca basically fiecare vendor foloseste ce vrea, cum vrea, ceea ce inseamna ca noi ar trebui sa avem mapping pe toti vendorii mari
        //partea buna ii ca dupa ce gasim o logica pe care sa o facem, fie ca e pe baza EAN-ului sau Werk-nr-ului comparat cu o alta platforma, gen amazon
        //ceva solutii de automatizare ar trebui sa se poata face numa ca trebui sa vedem exact ce ar merita si ce nu, dpdv timp si cum s-ar putea face ca eu nu am
        //knowledge-ul asa de vast.
//
//        $this->refSearch = $createEvent->getRef();
//
//        if (substr($ref, 0, strlen($this->hanH)) === $this->hanH) {
//            $this->convertRefToHanHRef($ref);
//        }
//
//        if (substr($ref, 0, strlen($this->han)) === $this->han) {
//            $this->convertRefToHanRef($ref);
//        }
//
//        if (substr($ref, 0, strlen($this->gro)) === $this->gro) {
//            $this->convertRefToGroRef($ref);
//        }
//
//        if (substr($ref, 0, strlen($this->lau)) === $this->lau) {
//            $this->convertRefToLauRef($ref);
//        }
//
//        if (substr($ref, 0, strlen($this->upo)) === $this->upo) {
//            $this->convertRefToUpoRef($ref);
//        }
//
//        if (substr($ref, 0, strlen($this->klu)) === $this->klu) {
//            $this->convertRefToKluRef($ref);
//        }
//
//        if (substr($ref, 0, strlen($this->dan)) === $this->dan) {
//            $this->convertRefToDanRef($ref);
//        }
//
//        if (substr($ref, 0, strlen($this->honvtl)) === $this->honvtl) {
//            $this->convertRefToHonvtlRef($ref);
//        }
//
//        if (substr($ref, 0, strlen($this->vai)) === $this->vai) {
//            $this->convertRefToVaiRef($ref);
//        }
//
//        return $errors;
//    }
//
//    protected function convertRefToHanHRef($ref)
//    {
//        $ref             = $this->replaceRef($ref, $this->hanH, "HAN");
//        $ref             = $this->addZeroToRef($ref);
//        $this->refSearch = $ref;
//    }
//
//    protected function convertRefToHanRef($ref)
//    {
//        $ref             = $this->addZeroToRef($ref);
//        $this->refSearch = $ref;
//    }
//
//    protected function convertRefToGroRef($ref)
//    {
//        $ref             = $this->replaceRef($ref, $this->gro, "GRO");
//        $ref             = $this->addZeroToRef($ref);
//        $this->refSearch = $ref;
//    }
//
//    protected function convertRefToLauRef($ref)
//    {
//        $ref             = $this->replaceRef($ref, $this->lau, "LAU");
//        $this->refSearch = $ref;
//    }
//
//    protected function convertRefToUpoRef($ref)
//    {
////        $ref = $this->replaceRef($ref, $this->upo, "UPO");
//        $this->refSearch = $ref;
//    }
//
//    protected function convertRefToKluRef($ref)
//    {
//        $ref             = $this->replaceRef($ref, $this->klu, "KLU");
//        $this->refSearch = $ref;
//    }
//
//    protected function convertRefToDanRef($ref)
//    {
//        $ref             = $this->replaceRef($ref, $this->dan, "DAN");
//        $this->refSearch = $ref;
//    }
//
//    protected function convertRefToHonvtlRef($ref)
//    {
////        $ref = $this->replaceRef($ref, $this->honvtl, "HONVTL");
//        $this->refSearch = $ref;
//    }
//
//    protected function convertRefToVaiRef($ref)
//    {
//        $ref             = $this->replaceRef($ref, $this->vai, "VAI");
//        $this->refSearch = $ref;
//    }
//
//
//
//        $log      = $this->getLogger();
//        $max_time = ini_get("max_execution_time");
//        ini_set('max_execution_time', 60000);
//        $i        = 0;
//
//        $log->debug("XML PRODUCT IMPORT");
//        foreach ($row as $key => $value) {
//            if ($value) {
//                $log->debug($key . ': ' . $value);
//            }
//        }
//
//        $this->checkMandatoryColumns($row);
//        //$produkt_id = $this->rowHasField($row, "Produkt_id");
//        $extern_id              = $this->rowHasField($row, "Extern_id");
//        $ref                    = $this->rowHasField($row, "Ref");
//        $marke_id               = $this->rowHasField($row, "Marke_id");
//        $kategorie_id           = $this->rowHasField($row, "Kategorie_id");
//        $produkt_titel          = $this->rowHasField($row, "Produkt_titel");
//        $kurze_beschreibung     = $this->rowHasField($row, "Kurze_beschreibung");
//        $beschreibung           = $this->rowHasField($row, "Beschreibung");
//        $postscriptum           = $this->rowHasField($row, "Postscriptum");
//        $meta_titel             = $this->rowHasField($row, "Meta_titel");
//        $meta_beschreibung      = $this->rowHasField($row, "Meta_beschreibung");
//        $meta_keywords          = $this->rowHasField($row, "Meta_keywords");
//        $menge                  = $this->rowHasField($row, "Menge");
//        $fulfilment_center      = $this->rowHasField($row, "Fulfilment_center");
//        $ist_in_Angebot         = $this->rowHasField($row, "Ist_in_Angebot");
//        $ist_neu                = $this->rowHasField($row, "Ist_neu");
//        $ist_online             = $this->rowHasField($row, "Ist_online");
//        $gewicht                = $this->rowHasField($row, "Gewicht");
//        $EAN_code               = trim($this->rowHasField($row, "EAN_code"));
//        //$bild_name = $this->rowHasField($row, "Bild_name");
//        $bild_titel             = $this->rowHasField($row, "Bild_titel");
//        $bild_beschreibung      = $this->rowHasField($row, "Bild_beschreibung");
//        $bild_kurz_beschreibung = $this->rowHasField($row, "Bild_kurz_beschreibung");
//        $bild_postscriptum      = $this->rowHasField($row, "Bild_postscriptum");
//        $bild_file              = $this->rowHasField($row, "Bild_file");
//        $price                  = $this->rowHasField($row, "Price");
//        $promo_price            = $this->rowHasField($row, "Promo_price");
//        $listen_price           = $this->rowHasField($row, "Listen_price");
//        $ek_preis_sht           = $this->rowHasField($row, "Ek_preis_sht");
//        $ek_preis_gc            = $this->rowHasField($row, "Ek_preis_gc");
//        $ek_preis_oag           = $this->rowHasField($row, "Ek_preis_oag");
//        $ek_preis_holter        = $this->rowHasField($row, "Ek_preis_holter");
//        $preis_reuter           = $this->rowHasField($row, "Preis_reuter");
//        $vergleich_ek           = $this->rowHasField($row, "Vergleich_ek");
//        $aufschlag              = $this->rowHasField($row, "Aufschlag");
//        $template_id            = $this->rowHasField($row, "Template_id");
//        $help                   = $this->rowHasField($row, "Help");
//
//        // check if price has the correct format
//        $decimals = LangQuery::create()
//         ->select('decimals')
//         ->filterByVisible(1)
//         ->findOne();
//
//        if ($price != null) {
//            $errors .= $this->isPriceFormat($price, $decimals, $ref, $errors);
//        }
//
//        if ($promo_price != null) {
//            $errors .= $this->isPriceFormat($promo_price, $decimals, $ref, $errors);
//        }
//
//        if ($listen_price != null) {
//            $errors .= $this->isPriceFormat($listen_price, $decimals, $ref, $errors);
//        }
//
//        if ($ek_preis_sht != null) {
//            $errors .= $this->isPriceFormat($ek_preis_sht, $decimals, $ref, $errors);
//        }
//
//        if ($ek_preis_gc != null) {
//            $errors .= $this->isPriceFormat($ek_preis_gc, $decimals, $ref, $errors);
//        }
//
//        if ($ek_preis_oag != null) {
//            $errors .= $this->isPriceFormat($ek_preis_oag, $decimals, $ref, $errors);
//        }
//
//        if ($ek_preis_holter != null) {
//            $errors .= $this->isPriceFormat($ek_preis_holter, $decimals, $ref, $errors);
//        }
//
//        if ($preis_reuter != null) {
//            $errors .= $this->isPriceFormat($preis_reuter, $decimals, $ref, $errors);
//        }
//
//        // check if EAN has a correct format
//        if ($EAN_code != null) {
//            if (!ctype_digit($EAN_code)) {
//                $log->debug('The ean code ' . $EAN_code . ' from the product ' . $ref . ' isn\'t correct.');
//                $errors .= '<br>The ean code ' . $EAN_code . ' from the product ' . $ref . ' isn\'t correct.';
//            }
//        }
//
//        // check if brand id, category id, template id exists in DB
//        $brand = BrandQuery::create()->findOneById($marke_id);
//
//        if (!$brand) {
//            $log->debug('The brand id ' . $marke_id . ' from the product ' . $ref . ' does not exist in database.');
//            $errors .= '<br>The brand id ' . $marke_id . ' from the product ' . $ref . ' does not exist in database.';
//        }
//
//        $category = CategoryQuery::create()->findOneById($kategorie_id);
//
//        if (!$category) {
//            $log->debug('The category id ' . $kategorie_id . ' from the product ' . $ref . ' does not exist in database.');
//            $errors .= '<br>The category id ' . $kategorie_id . ' from the product ' . $ref . ' does not exist in database.';
//        }
//
//        if ($template_id != null) {
//            $template = TemplateQuery::create()->findOneById($template_id);
//
//            if (!$template) {
//                $log->debug('The template id ' . $template_id . ' from the product ' . $ref . ' does not exist in database.');
//                $errors .= '<br>The template id ' . $template_id . ' from the product ' . $ref . ' does not exist in database.';
//            }
//        }
//
//        if ($fulfilment_center != null) {
//            $fulfilment_center_db = FulfilmentCenterQuery::create()->findOneById($fulfilment_center);
//
//            if (!$fulfilment_center_db) {
//                $log->debug('The fulfilment center with id ' . $fulfilment_center . ' does not exist in database.');
//                $errors .= '<br>The fulfilment center with id ' . $fulfilment_center . ' does not exist in database.';
//            }
//        }
//
//        if (!file_exists(THELIA_LOCAL_DIR . "media" . DS . "images" . DS . "importer" . DS . $bild_file)) {
//            $log->debug('The image ' . $bild_file . ' from the product ' . $ref . ' is not in importer folder');
//            $errors .= '<br>The image ' . $bild_file . ' from the product ' . $ref . ' is not in importer folder';
//        }
//
//
//        //check for existing services
//        $productQuerry->clear();
//        $productExists = count($productQuerry->findByRef($ref));
//        if ($errors == null) {
//            if ($productExists == 0) { // product_numbers must be unique
//                $log->debug(" generic_product is new ");
//                //save product info
//                $productThelia = new Product ();
//                $productThelia->setRef($ref); // must be unique
//                $productThelia->setVisible(0);
//                if ($marke_id != null)
//                    $productThelia->setBrandId($marke_id);
//
//                if ($extern_id != null)
//                    $productThelia->setExternId($extern_id);
//
//                $productThelia->setCreatedAt($currentDate);
//                $productThelia->setUpdatedAt($currentDate);
//                $productThelia->setVersion(1);
//                $productThelia->setVersionCreatedAt($currentDate);
//                $productThelia->setVersionCreatedBy("importer.4");
//
//                if ($template_id != null) {
//                    $productThelia->setTemplateId($template_id);
//                } else {
//                    $productThelia->setTemplateId(1);
//                }
//
//                if ($ist_online != null)
//                    $productThelia->setVisible($ist_online);
//
//                $gewicht = isset($gewicht) ? $gewicht : 'NULL';
//                $price   = isset($price) ? $price : 'NULL';
//
//                $productThelia->create($kategorie_id, $price, 1, 1, $gewicht, 10);
//
//                $mod = new Module();
//                $mod->getActivate();
//
//                if (Common::getActiveModule("AmazonIntegration") == 1) {
//                    $log->debug("AMAZON IMAGES - BEFORE get images from Amazon in Generic product import");
//                    // get info from amazon
//                    $amazonAPI  = new AmazonAWSController();
//                    $infoAmazon = $amazonAPI->getProductInfoFromAmazon($EAN_code);
//
//                    $this->saveImageFromAmazon($log, $productThelia, $EAN_code, $infoAmazon);
//                    $this->saveFeaturesColorFromAmazon($log, $productThelia, $EAN_code, $infoAmazon);
//                    $this->saveFeaturesHeightFromAmazon($log, $productThelia, $EAN_code, $infoAmazon);
//                    $this->saveFeaturesLengthFromAmazon($log, $productThelia, $EAN_code, $infoAmazon);
//                    $this->saveFeaturesWidthFromAmazon($log, $productThelia, $EAN_code, $infoAmazon);
//                }
//
//                // product description en_US
//                $productI18n = new ProductI18n ();
//                $productI18n->setProduct($productThelia);
//                $productI18n->setLocale("en_US");
//
//                if ($produkt_titel != null)
//                    $productI18n->setTitle($produkt_titel);
//
//                if ($beschreibung != null)
//                    $productI18n->setDescription($beschreibung);
//
//                if (Common::getActiveModule("AmazonIntegration") == 1) {
//                    if ($infoAmazon['description'] && (strlen($infoAmazon['description']) > strlen($beschreibung))) {
//                        $productI18n->setDescription(utf8_encode($infoAmazon['description']));
//                    }
//                }
//
//                if ($kurze_beschreibung != null)
//                    $productI18n->setChapo($kurze_beschreibung);
//
//                if ($postscriptum != null)
//                    $productI18n->setPostscriptum($postscriptum);
//
//                if ($meta_titel != null)
//                    $productI18n->setMetaTitle($meta_titel);
//
//                if ($meta_beschreibung != null)
//                    $productI18n->setMetaDescription($meta_beschreibung);
//
//                if ($meta_keywords != null)
//                    $productI18n->setMetaKeywords($meta_keywords);
//
//                $productI18n->save();
//                //$log->debug ( " product_i18n en_US is added ".$productI18n->__toString() );
//                $productThelia->addProductI18n($productI18n);
//
//                // product description de_DE
//                $productI18n = new ProductI18n ();
//                $productI18n->setProduct($productThelia);
//                $productI18n->setLocale("de_DE");
//                if ($produkt_titel != null)
//                    $productI18n->setTitle($produkt_titel);
//
//                if ($beschreibung != null)
//                    $productI18n->setDescription($beschreibung);
//
//                if (Common::getActiveModule("AmazonIntegration") == 1) {
//                    if ($infoAmazon['description'] && (strlen($infoAmazon['description']) > strlen($beschreibung))) {
//                        $productI18n->setDescription(utf8_encode($infoAmazon['description']));
//                    }
//                }
//
//                if ($kurze_beschreibung != null)
//                    $productI18n->setChapo($kurze_beschreibung);
//
//                if ($postscriptum != null)
//                    $productI18n->setPostscriptum($postscriptum);
//
//                if ($meta_titel != null)
//                    $productI18n->setMetaTitle($meta_titel);
//
//                if ($meta_beschreibung != null)
//                    $productI18n->setMetaDescription($meta_beschreibung);
//
//                if ($meta_keywords != null)
//                    $productI18n->setMetaKeywords($meta_keywords);
//
//                $productI18n->save();
//                //  $log->debug ( " generic_product_import product_i18n de_DE is added ".$productI18n->__toString() );
//                $productThelia->addProductI18n($productI18n);
//
//                // find product sale element
//                $pse = ProductSaleElementsQuery::create()->findOneByProductId($productThelia->getId());
//
//                if ($pse != null) {
//
//                    //$log->debug ( " generic_product_import pse found ".$pse->__toString() );
//                    $currency = Currency::getDefaultCurrency();
//                    $price    = ProductPriceQuery::create()
//                     ->filterByProductSaleElementsId($pse->getId())
//                     ->findOneByCurrencyId($currency->getId());
//                } else {
//                    $pse = new ProductSaleElements();
//                    $pse->setProduct($productThelia);
//                }
//
//                $pse->setRef($ref);
//
//                if ($menge != null) {
//                    if ($fulfilment_center != null) {
//                        $fcp = new FulfilmentCenterProducts();
//                        $fcp->setFulfilmentCenterId($fulfilment_center);
//                        $fcp->setProductId($productThelia->getId());
//                        $fcp->setProductStock($menge);
//                        $fcp->save();
//
//                        $pse->setQuantity($menge);
//                    } else {
//                        $pse->setQuantity($menge);
//                    }
//                }
//
//                if ($ist_in_Angebot != null)
//                    $pse->setPromo($ist_in_Angebot);
//
//                if ($ist_neu != null)
//                    $pse->setNewness($ist_neu);
//
//                if ($gewicht != null)
//                    $pse->setWeight($gewicht);
//
//                if (Common::getActiveModule("AmazonIntegration") == 1) {
//                    if ($gewicht == null && $infoAmazon['weight']) {
//                        $pse->setWeight($infoAmazon['weight']);
//                    }
//                }
//
//                if ($EAN_code != null)
//                    $pse->setEanCode($EAN_code);
//
//                $pse->save();
//
//                //save price
//                if ($price === null) {
//                    $price = new ProductPrice();
//                    $price->setProductSaleElements($pse);
//                    $price->setCurrency($currency);
//                } else
//                    $log->debug(" generic_product_import price found");
//                //$log->debug ( " generic_product_import price found ".$price->__toString() );
//
//                if ($promo_price != null)
//                    $price->setPromoPrice($promo_price);
//
//                if ($listen_price != null)
//                    $price->setListenPrice($listen_price);
//
//                if ($ek_preis_sht != null)
//                    $price->setEkPreisSht($ek_preis_sht);
//
//                if ($ek_preis_gc != null)
//                    $price->setEkPreisGc($ek_preis_gc);
//
//                if ($ek_preis_oag != null)
//                    $price->setEkPreisOag($ek_preis_oag);
//
//                if ($ek_preis_holter != null)
//                    $price->setEkPreisHolter($ek_preis_holter);
//
//                if ($preis_reuter != null)
//                    $price->setPreisReuter($preis_reuter);
//
//                if ($vergleich_ek != null)
//                    $price->setVergleichEk($vergleich_ek);
//
//                if ($aufschlag != null)
//                    $price->setAufschlag($aufschlag);
//
//                $price->save();
//                $log->debug(" generic_product_import price saved");
//
//                //save images
//                $image_path = THELIA_LOCAL_DIR . "media" . DS . "images" . DS . "product" . DS;
//                $image_name = 'PROD_' . preg_replace("/[^a-zA-Z0-9.]/", "", $bild_file);
//
//                $log->debug(" generic_product_import image");
//
//                try {
//                    $log->debug(" generic_product_import image from " . THELIA_LOCAL_DIR . "media" . DS . "images" . DS . "importer" . DS . $bild_file);
//                    $image_from_server = @file_get_contents(THELIA_LOCAL_DIR . "media" . DS . "images" . DS . "importer" . DS . $bild_file);
//                } catch (Exception $e) {
//                    $log->debug("ProductImageException :" . $e->getMessage());
//                }
//
//                if ($image_from_server) {
//                    $log->debug(" generic_product_import image saved to " . $image_path);
//                    file_put_contents($image_path . $image_name, $image_from_server);
//
//                    $product_image = new ProductImage ();
//                    $product_image->setProduct($productThelia);
//                    $product_image->setVisible(1);
//                    $product_image->setCreatedAt($currentDate);
//                    $product_image->setUpdatedAt($currentDate);
//                    $product_image->setFile($image_name);
//                    $product_image->save();
//
//                    $product_image_i18n = new ProductImageI18n();
//                    $product_image_i18n->setProductImage($product_image);
//                    $product_image_i18n->setTitle($bild_titel);
//                    $product_image_i18n->setDescription($bild_beschreibung);
//                    $product_image_i18n->setChapo($bild_kurz_beschreibung);
//                    $product_image_i18n->setPostscriptum($bild_postscriptum);
//                    $product_image_i18n->setLocale("de_DE");
//                    $product_image_i18n->save();
//
//                    $productThelia->addProductImage($product_image);
//                }
//            } else {
//                $errors .= "Product reference number " . $ref . " is already in the database ";
//                $log->debug(" ref number already in the database '" . $ref . "'");
//            }
//        }
//
//        ini_set('max_execution_time', $max_time);
//        if ($errors == null) {
//            $this->importedRows++;
//        }
//
//        // create csv with wrong rows
//        elseif (!$productExists) {
//
//            foreach ($row as $key => $value) {
//                $listHeader[] = $key;
//            }
//
//            $current_date  = date("Y-m-d H:i:s");
//            $csv_file_name = 'product_import_' . md5($current_date) . '.csv';
//
//            $session = $this->container->get('request_stack')->getCurrentRequest()->getSession();
//            $session->set('csvFileName', $csv_file_name);
//
//            $filepath = THELIA_LOCAL_DIR . "sepa" . DS . "import" . DS . $csv_file_name;
//
//            if (file_exists($filepath)) {
//                $fp = fopen($filepath, 'a');
//                fputcsv($fp, $row);
//            } else {
//                $fp = fopen($filepath, 'w');
//                fputcsv($fp, $listHeader);
//                fputcsv($fp, $row);
//            }
//
//            rewind($fp);
//            fclose($fp);
//        }
//
//    public function getLogger()
//    {
//        if (self::$logger == null) {
//            self::$logger = Tlog::getNewInstance();
//            $logFilePath  = THELIA_LOG_DIR . DS . "log-generic-importer.txt";
//            self::$logger->setPrefix("#LEVEL: #DATE #HOUR: ");
//            self::$logger->setDestinations("\\Thelia\\Log\\Destination\\TlogDestinationRotatingFile");
//            self::$logger->setConfig("\\Thelia\\Log\\Destination\\TlogDestinationRotatingFile", 0, $logFilePath);
//            self::$logger->setLevel(Tlog::DEBUG);
//        }
//        return self::$logger;
//    }
//
//    public function saveImageFromAmazon($log, &$productThelia, $EAN_code, $infoAmazon)
//    {
//        $log->debug("AMAZON IMAGES - get images from Amazon in Generic product import");
//        $currentDate = date("Y-m-d H:i:s");
//        // save images from Amazon
//        if ($infoAmazon['images']) {
//            foreach ($infoAmazon['images'] as $imageAmazon) {
//                $product_image      = new ProductImage ();
//                $product_image->setProduct($productThelia);
//                $product_image->setVisible(1);
//                $product_image->setCreatedAt($currentDate);
//                $product_image->setUpdatedAt($currentDate);
//                $product_image->setFile($imageAmazon['file_name']);
//                $product_image->save();
//                $product_image_i18n = new ProductImageI18n();
//                $product_image_i18n->setProductImage($product_image);
//                $product_image_i18n->setTitle($imageAmazon['title']);
//                $product_image_i18n->setDescription($imageAmazon['title']);
//                $product_image_i18n->setLocale("de_DE");
//                $product_image_i18n->save();
//                $productThelia->addProductImage($product_image);
//                $log->debug("AMAZON IMAGES -  file was inserted in DB " . $imageAmazon['file_name']);
//            }
//        } else {
//            $log->debug("AMAZON IMAGES - no images for this product " . $EAN_code);
//        }
//    }
//
//    public function saveFeaturesColorFromAmazon($log, $productThelia, $EAN_code, $infoAmazon)
//    {
//        // save features from Amazon: color, height, length, width
//        if ($infoAmazon['color']) {
//            $fav         = new FeatureAv();
//            $fav->setFeatureId(21)->save();
//            // feature en_US
//            $fav_i18n    = new FeatureAvI18n();
//            $fav_i18n->setId($fav->getId())
//             ->setLocale('en_US')
//             ->setTitle($infoAmazon['color'])
//             ->save();
//            // feature de_DE
//            $fav_i18n    = new FeatureAvI18n();
//            $fav_i18n->setId($fav->getId())
//             ->setLocale('de_DE')
//             ->setTitle($infoAmazon['color'])
//             ->save();
//            // feature product
//            $fav_product = new FeatureProduct();
//            $fav_product
//             ->setProductId($productThelia->getId())
//             ->setFeatureId(21)
//             ->setFeatureAvId($fav->getId())
//             ->setFreeTextValue(1)
//             ->save();
//            $log->debug("AMAZON - product " . $EAN_code . " - saved color");
//        }
//    }
//
//    public function saveFeaturesHeightFromAmazon($log, $productThelia, $EAN_code, $infoAmazon)
//    {
//        if ($infoAmazon['height']) {
//            $fav         = new FeatureAv();
//            $fav->setFeatureId(17)->save();
//            // feature en_US
//            $fav_i18n    = new FeatureAvI18n();
//            $fav_i18n->setId($fav->getId())
//             ->setLocale('en_US')
//             ->setTitle($infoAmazon['height'])
//             ->save();
//            // feature de_DE
//            $fav_i18n    = new FeatureAvI18n();
//            $fav_i18n->setId($fav->getId())
//             ->setLocale('de_DE')
//             ->setTitle($infoAmazon['height'])
//             ->save();
//            // feature product
//            $fav_product = new FeatureProduct();
//            $fav_product
//             ->setProductId($productThelia->getId())
//             ->setFeatureId(17)
//             ->setFeatureAvId($fav->getId())
//             ->setFreeTextValue(1)
//             ->save();
//            $log->debug("AMAZON - product " . $EAN_code . " - saved height");
//        }
//    }
//
//    public function saveFeaturesLengthFromAmazon($log, $productThelia, $EAN_code, $infoAmazon)
//    {
//        if ($infoAmazon['length']) {
//            $fav         = new FeatureAv();
//            $fav->setFeatureId(65)->save();
//            // feature en_US
//            $fav_i18n    = new FeatureAvI18n();
//            $fav_i18n->setId($fav->getId())
//             ->setLocale('en_US')
//             ->setTitle($infoAmazon['length'])
//             ->save();
//            // feature de_DE
//            $fav_i18n    = new FeatureAvI18n();
//            $fav_i18n->setId($fav->getId())
//             ->setLocale('de_DE')
//             ->setTitle($infoAmazon['length'])
//             ->save();
//            // feature product
//            $fav_product = new FeatureProduct();
//            $fav_product
//             ->setProductId($productThelia->getId())
//             ->setFeatureId(65)
//             ->setFeatureAvId($fav->getId())
//             ->setFreeTextValue(1)
//             ->save();
//            $log->debug("AMAZON - product " . $EAN_code . " - saved length");
//        }
//    }
//
//    public function saveFeaturesWidthFromAmazon($log, $productThelia, $EAN_code, $infoAmazon)
//    {
//        if ($infoAmazon['width']) {
//            $fav         = new FeatureAv();
//            $fav->setFeatureId(88)->save();
//            // feature en_US
//            $fav_i18n    = new FeatureAvI18n();
//            $fav_i18n->setId($fav->getId())
//             ->setLocale('en_US')
//             ->setTitle($infoAmazon['width'])
//             ->save();
//            // feature de_DE
//            $fav_i18n    = new FeatureAvI18n();
//            $fav_i18n->setId($fav->getId())
//             ->setLocale('de_DE')
//             ->setTitle($infoAmazon['width'])
//             ->save();
//            // feature product
//            $fav_product = new FeatureProduct();
//            $fav_product
//             ->setProductId($productThelia->getId())
//             ->setFeatureId(88)
//             ->setFeatureAvId($fav->getId())
//             ->setFreeTextValue(1)
//             ->save();
//            $log->debug("AMAZON - product " . $EAN_code . " - saved width");
//        }
//    }
//
//    public function isPriceFormat($number, $decimals, $ref, $errors)
//    {
//
//        $log = $this->getLogger();
//
//        if (!is_numeric($number)) {
//            $log->debug('The price ' . $number . ' from the product ' . $ref . ' isn\'t numeric');
//            $errors .= '<br>The price ' . $number . ' from the product ' . $ref . ' isn\'t numeric';
//        } else {
//
//            $parts        = explode(".", $number);
//            $num_decimals = strlen($parts[1]);
//
//            if ($num_decimals != $decimals) {
//                $log->debug('The price ' . $number . ' from the product ' . $ref . ' has no ' . $decimals . ' decimals.');
//                $errors .= '<br>The price ' . $number . ' from the product ' . $ref . ' has no ' . $decimals . ' decimals.';
//            }
//        }
//
    }

}
