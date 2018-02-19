<?php

namespace HookKonfigurator\Import;

use Thelia\Core\FileFormat\Formatting\FormatterData;
use Thelia\Core\FileFormat\FormatType;
use Thelia\ImportExport\Import\ImportHandler;
use Thelia\Model\ProductSaleElementsQuery;
use Thelia\Log\Tlog;
use Thelia\Model\ProductQuery;
use HookKonfigurator\Model\ConstraintsQuery;
use Thelia\Model\ProductI18n;
use Thelia\Model\Product;
use HookKonfigurator\Model\Montage;
use HookKonfigurator\Model\MontageConstraints;
use HookKonfigurator\Model\Constraints;
use Thelia\Model\ProductImage;

/**
 * Class SanitaryImport
 * @package HookKonfigurator\Import
 * @author Emanuel Plopu <emanuel.plopu@sepa.at>
 */
class SanitaryImport extends ImportHandler
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
        $log->debug(" sanitary_import ");
        

        $productQuerry = ProductQuery::create ();
        
        
        $currentDate = date ( "Y-m-d H:i:s" );
        $heizungCategoryId = 11;
        
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
            $category = utf8_encode($row["kategorie"]);
            $services = utf8_encode($row["services"]);
            $dokumente = utf8_encode($row["dokumente"]);
            $hersteller_produkt_url = utf8_encode($row["hersteller_produkt_url"]);
            $farbe = utf8_encode($row["farbe"]);
            $reuter_megabad_aktion = utf8_encode(str_replace(",", ".", $row["reuter_megabad_aktion"]));
            
            $anzahl_von_bilder = $row["anzahl_von_bilder"];
            $gewicht = str_replace(",", ".", $row["gewicht"]);
            $preis = str_replace(".", "", $row["preis"]);
            $preis = str_replace(",", ".", $preis);
            if($preis == "NULL") $preis = 0;
            $gc_ek = $row["gc_ek"];

            //check for existing services
            $productQuerry->clear ();
            $productExists = count ( $productQuerry->findByRef ( $sht_id ) );
            
                    if ($productExists == 0) // product_numbers must be unique
            {
            	$log->debug ( " product_sanitary is new " );
            	$productThelia = new Product ();
            	$productThelia->setRef ( $sht_id ); // must be unique
            	$productThelia->setVisible ( 0 );
            	
            	$productThelia->setCreatedAt ( $currentDate );
            	$productThelia->setUpdatedAt ( $currentDate );
            	$productThelia->setVersion ( 1 );
            	$productThelia->setVersionCreatedAt ( $currentDate );
            	$productThelia->setVersionCreatedBy ( "importer.1" );
            	$productThelia->create ( $heizungCategoryId, $preis, 1, 1, 'NULL', 20 );
            	$log->debug ( " sanitary is add as product " );
            	
            	// product description
            	$locale = "en_US";
            	$productI18n = new ProductI18n ();
            	$productI18n->setProduct ( $productThelia );
            	$productI18n->setLocale ( $locale );
            	$productI18n->setTitle ( $produkt_name );
            	$productI18n->setDescription ( $detaillierte_beschreibung );
            	$productI18n->setChapo ( $zusammengefaste_beschreibung );
            	$productI18n->setPostscriptum ( $produkt_merkmale );
            	$productI18n->save ();
            	$log->debug ( " product_i18n ".$locale." is added ".$productI18n->__toString() );
            	$productThelia->addProductI18n ( $productI18n );
            	
            	$locale = "de_DE";
            	$productI18n = new ProductI18n ();
            	$productI18n->setProduct ( $productThelia );
            	$productI18n->setLocale ( $locale );
            	$productI18n->setTitle ( $produkt_name );
            	$productI18n->setDescription ( $detaillierte_beschreibung );
            	$productI18n->setChapo ( $zusammengefaste_beschreibung );
            	$productI18n->setPostscriptum ( $produkt_merkmale );
            	$productI18n->save ();
            	$log->debug ( " product_i18n ".$locale." is added ".$productI18n->__toString() );
            	$productThelia->addProductI18n ( $productI18n );
            	/*$log->debug(" images ".$anzahl_von_bilder);
            	for($image_index = 0; $image_index < $anzahl_von_bilder; $image_index++){
            		$image_save_path = 'C:\Development\programs\xampp\htdocs\heizfabrik\local\media\images\product\\';
            		$image_origin_path = 'C:\Development\programs\xampp\htdocs\heizfabrik\import\media\\';
            		
            		
            	$product_image_url = $image_origin_path.$bild_name_wurzel;
            	if($product_image_url){
            		// product image
            		$product_image_url = $product_image_url."_".$image_index;
            		$image_name = 'PROD_' . $productThelia->getRef()."_".$image_index.'.jpg';
            
            		try{
            			$image_from_server =@file_get_contents ( $product_image_url );
            		}
            		catch (Exception $e) {
            			$log->debug ("ProductImageException :".$e->getMessage());
            		}
            	
            		if($image_from_server){
            			file_put_contents ( $image_save_path . $image_name, $image_from_server );
            	
            			$product_image = new ProductImage ();
            			$product_image->setProduct ( $productThelia );
            			$product_image->setVisible ( 1 );
            			$product_image->setCreatedAt ( $currentDate );
            			$product_image->setUpdatedAt ( $currentDate );
            			$product_image->setFile ( $image_name );
            			$product_image->save ();
            	
            			$productThelia->addProductImage ( $product_image );
            		}
            	}
            	}*/

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
        		"detaillierte_beschreibung","zusammengefaste_beschreibung","produkt_merkmale","services","dokumente",
        		"hersteller_produkt_url","gewicht","farbe","kategorie","reuter_megabad_aktion","reuter_megabad_preis","preis","gc_ek"];
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
