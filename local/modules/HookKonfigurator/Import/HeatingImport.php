<?php

namespace HookKonfigurator\Import;

use Thelia\Core\FileFormat\Formatting\FormatterData;
use Thelia\Core\FileFormat\FormatType;
use Thelia\ImportExport\Import\ImportHandler;
use Thelia\Model\ProductSaleElementsQuery;
use Thelia\Log\Tlog;
use Thelia\Model\BrandI18nQuery;
use Thelia\Model\ProductQuery;
use Thelia\Model\Product;
use Thelia\Model\ProductI18n;
use HookKonfigurator\Model\ProductHeizung;

/**
 * Class HeatingImport
 * @package HookKonfigurator\Import
 * @author Emanuel Plopu <emanuel.plopu@sepa.at>
 */
class HeatingImport extends ImportHandler
{
    /**
     * @param \Thelia\Core\FileFormat\Formatting\FormatterData
     * @return string|array error messages
     *
     * The method does the import routine from a FormatterData
     */
    public function retrieveFromFormatterData(FormatterData $data)
    {
        $errors = [];
        $log = Tlog::getInstance ();
        $log->debug(" product_heizung_import ");
        

        $brandI18nQuerry = BrandI18nQuery::create ();
        $productQuerry = ProductQuery::create ();
        
        
        $currentDate = date ( "Y-m-d H:i:s" );
        $heizungCategoryId = 10;
        
        $i = 0;

        while (null !== $row = $data->popRow()) {
			
        	$log->debug(" importing_product_heizung ".$i.implode(" ",$row));
            $this->checkMandatoryColumns($row);
            
            $sht_id = utf8_encode($row["sht_id"]);
            $bild_name_wurzel = utf8_encode($row["bild_name_wurzel"]);
            
            $marke = utf8_encode($row["marke"]);
            $produkt_name = utf8_encode($row["produkt_name"]);
            $detaillierte_beschreibung = utf8_encode($row["detaillierte_beschreibung"]);
            $zusammengefaste_beschreibung = utf8_encode($row["zusammengefaste_beschreibung"]);
            $produkt_merkmale = utf8_encode($row["produkt_merkmale"]);
            $category = utf8_encode($row["category"]);
            $energie_träger = utf8_encode($row["energie_träger"]);
            $services = utf8_encode($row["services"]);
            $dokumente = utf8_encode($row["dokumente"]);
            $hersteller_produkt_url = utf8_encode($row["hersteller_produkt_url"]);
            
            $anzahl_von_bilder = $row["anzahl_von_bilder"];
            $wärmeleistung = $row["wärmeleistung"];
            $wasserwärmeleistung = $row["wasserwärmeleistung"];
            $energieeffizienz_heizung = $row["energieeffizienz_heizung"];
            $effizienz_classe = $row["effizienz_classe"];
            $speicherkapazität = $row["speicherkapazität"];
            $gewicht = $row["gewicht"];
            $preis = $row["preis"];
            $gc_ek = $row["gc_ek"];

            //check for existing services
            $productQuerry->clear ();
            $productExists = count ( $productQuerry->findByRef ( $sht_id ) );
            
            if ($productExists == 0) // product_numbers must be unique
            {
            	$log->debug ( " product_heizung is new " );
            	$productThelia = new Product ();
            	$productThelia->setRef ( $sht_id ); // must be unique
            	$productThelia->setVisible ( 0 );
            	
            	$productThelia->setCreatedAt ( $currentDate );
            	$productThelia->setUpdatedAt ( $currentDate );
            	$productThelia->setVersion ( 1 );
            	$productThelia->setVersionCreatedAt ( $currentDate );
            	$productThelia->setVersionCreatedBy ( "importer.1" );
            	$productThelia->create ( $heizungCategoryId, $preis, 1, 1, 'NULL', 20 );
            	$log->debug ( " service is add as product " );
            	
            	// product description
            	$productI18n = new ProductI18n ();
            	$productI18n->setProduct ( $productThelia );
            	$productI18n->setLocale ( "en_US" );
            	$productI18n->setTitle ( $produkt_name );
            	$productI18n->setDescription ( $detaillierte_beschreibung );
            	$productI18n->setChapo ( $zusammengefaste_beschreibung );
            	$productI18n->setPostscriptum ( $produkt_merkmale );
            	$productI18n->save ();
            	$log->debug ( " product_i18n is added ".$productI18n->__toString() );
            	$productThelia->addProductI18n ( $productI18n );
            	
            	$product_heizung = new ProductHeizung();
            	$product_heizung->setProductId ( $productThelia->getId () );
				$product_heizung->setGrade ( $effizienz_classe );
				$product_heizung->setPower ( $wärmeleistung );
				$product_heizung->setEnergyEfficiency ( $energieeffizienz_heizung );
						
						if ($wasserwärmeleistung == "NULL")
							$product_heizung->setWarmWater ( 0 );
						else
							$product_heizung->setWarmWater ( 1 );
						$product_heizung->setStorageCapacity ( $speicherkapazität );
						$product_heizung->setEnergyCarrier($energie_träger);
						$product_heizung->save ();
            }
            else             
            {
            	$errors[] = $this->translator->trans( "Product reference number %ref is already in the database ",
            				["%ref" => $row["sht_id"]] );
            	$log->debug ( " ref number already in the database '" . $sht_id . "'" );
            	}    	
        $this->importedRows++;
        
        $i++;
        }

        return $errors;
    }

    protected function getMandatoryColumns()
    {
        return ["product_id", "sht_id","hersteller_produkt_nummer","bild_name_wurzel","anzahl_von_bilder","marke","produkt_name",
        		"detaillierte_beschreibung","zusammengefaste_beschreibung","produkt_merkmale","category","wärmeleistung",
        		"wasserwärmeleistung","energieeffizienz_heizung","energieeffizienz_wasser","effizienz_classe","speicherkapazität",
        		"energie_träger","services","dokumente","hersteller_produkt_url","gewicht","preis","gc_ek"];
    }

    /**
     * @return string|array
     *
     * Define all the type of import/formatters that this can handle
     * return a string if it handle a single type ( specific exports ),
     * or an array if multiple.
     *
     * Thelia types are defined in \Thelia\Core\FileFormat\FormatType
     *
     * example:
     * return array(
     *     FormatType::TABLE,
     *     FormatType::UNBOUNDED,
     * );
     */
    public function getHandledTypes()
    {
        return array(
            FormatType::TABLE,
            FormatType::UNBOUNDED,
        );
    }
}
