<?php

namespace HookImporter\Import;

use Thelia\Core\FileFormat\Formatting\FormatterData;
use Thelia\Core\FileFormat\FormatType;
use Thelia\ImportExport\Import\ImportHandler;
use Thelia\Model\ProductSaleElementsQuery;
use Thelia\Log\Tlog;
use Thelia\Model\BrandI18nQuery;
use Thelia\Model\ProductQuery;
use Thelia\Model\Product;
use Thelia\Model\ProductI18n;
use Thelia\Action\ProductSaleElement;
use Thelia\Model\Currency;
use Thelia\Model\ProductPriceQuery;
use Thelia\Model\ProductPrice;
use Thelia\Model\ProductSaleElements;
use Thelia\Model\ProductImage;

/**
 * Class HeatingImport
 * @package HookKonfigurator\Import
 * @author Emanuel Plopu <emanuel.plopu@sepa.at>
 */
class GenericProductImport extends ImportHandler
{
    /**
     * @param \Thelia\Core\FileFormat\Formatting\FormatterData
     * @return string|array error messages
     *
     * The method does the import routine from a FormatterData
     */
	
	public function rowHasField($row,$field){
		if(isset($row[$field])){
			 return utf8_encode($row[$field]);
		}
		return null;
		
	}
    public function retrieveFromFormatterData(FormatterData $data)
    {
        $errors = [];
        $log = Tlog::getInstance ();
        $log->debug(" generic_product_import ");
        

        $brandI18nQuerry = BrandI18nQuery::create ();
        $productQuerry = ProductQuery::create ();
        
        $currentDate = date ( "Y-m-d H:i:s" );
        
        $i = 0;

        while (null !== $row = $data->popRow()) {
			
        	$log->debug(" importing_product_heizung ".$i.implode(" ",$row));
            $this->checkMandatoryColumns($row);
            
            
            $produkt_id = $this->rowHasField($row, "Produkt_id");
            $extern_id = $this->rowHasField($row, "Extern_id");
            $ref = $this->rowHasField($row, "Ref");
            $marke_id = $this->rowHasField($row, "Marke_id");
            $kategorie_id = $this->rowHasField($row, "kategorie_id");
            $produkt_titel = $this->rowHasField($row, "Produkt_titel");
            $kurze_beschreibung = $this->rowHasField($row, "Kurze_beschreibung");
            $beschreibung = $this->rowHasField($row, "Beschreibung");
            $postscriptum = $this->rowHasField($row, "Postscriptum");
            $meta_titel  = $this->rowHasField($row, "Meta_titel");
            $meta_beschreibung = $this->rowHasField($row, "Meta_beschreibung");
            $meta_keywords = $this->rowHasField($row, "Meta_keywords");
            $menge = $this->rowHasField($row, "Menge");
            $ist_in_Angebot = $this->rowHasField($row, "Ist_in_Angebot");
            $ist_neu = $this->rowHasField($row, "Ist_neu");
            $gewicht = $this->rowHasField($row, "Gewicht");
            $EAN_code = $this->rowHasField($row, "EAN_code");
            $bild_name = $this->rowHasField($row, "Bild_name");
            $bild_titel = $this->rowHasField($row, "Bild_titel");
            $bild_beschreibung = $this->rowHasField($row, "Bild_beschreibung");
            $bild_kurz_beschreibung = $this->rowHasField($row, "Bild_kurz_beschreibung");
            $bild_postscriptum = $this->rowHasField($row, "Bild_postscriptum");
            $bild_file = $this->rowHasField($row, "Bild_file");
            $price = $this->rowHasField($row, "Price");
            $promo_price = $this->rowHasField($row, "Promo_price");
            $listen_price = $this->rowHasField($row, "Listen_price");
            $ek_preis_sht = $this->rowHasField($row, "Ek_preis_sht");
            $ek_preis_gc = $this->rowHasField($row, "Ek_preis_gc");
            $ek_preis_oag = $this->rowHasField($row, "Ek_preis_oag");
            $ek_preis_holter = $this->rowHasField($row, "Ek_preis_holter");
            $preis_reuter = $this->rowHasField($row, "Preis_reuter");
            $vergleich_ek = $this->rowHasField($row, "Vergleich_ek");
            $aufschlag = $this->rowHasField($row, "Aufschlag");
            

            //check for existing services
            $productQuerry->clear ();
            $productExists = count ( $productQuerry->findByRef ( $ref ) );
            
            if ($productExists == 0) // product_numbers must be unique
            {
            	$log->debug ( " generic_product is new " );
            	//save product info
            	$productThelia = new Product ();
            	$productThelia->setRef ( $ref ); // must be unique
            	$productThelia->setVisible ( 0 );
            	if($marke_id != null)
            		$productThelia->setBrandId($marke_id);
            	
            	if($extern_id != null)
            		$productThelia->setExternId($extern_id);
            	
            	$productThelia->setCreatedAt ( $currentDate );
            	$productThelia->setUpdatedAt ( $currentDate );
            	$productThelia->setVersion ( 1 );
            	$productThelia->setVersionCreatedAt ( $currentDate );
            	$productThelia->setVersionCreatedBy ( "importer.2" );
            	
            	if($gewicht == null)$gewicht = 'NULL';
            	if($price == null)$price = 'NULL';
            	$productThelia->create ( $kategorie_id, $price, 1, 1, $gewicht, 20 );
            	
            	// product description en_US
            	$productI18n = new ProductI18n ();
            	$productI18n->setProduct ( $productThelia );
            	$productI18n->setLocale ( "en_US" );
            	$productI18n->setTitle ( $produkt_titel );
            	$productI18n->setDescription ( $beschreibung );
            	$productI18n->setChapo ( $kurze_beschreibung );
            	$productI18n->setPostscriptum ( $postscriptum );
            	$productI18n->setMetaTitle( $meta_titel );
            	$productI18n->setMetaDescription( $meta_beschreibung );
            	$productI18n->setMetaKeywords( $meta_keywords );
            	$productI18n->save ();
            	$log->debug ( " product_i18n en_US is added ".$productI18n->__toString() );
            	$productThelia->addProductI18n ( $productI18n );
            	
            	// product description de_DE
            	$productI18n = new ProductI18n ();
            	$productI18n->setProduct ( $productThelia );
            	$productI18n->setLocale ( "de_DE" );
            	$productI18n->setTitle ( $produkt_titel );
            	$productI18n->setDescription ( $beschreibung );
            	$productI18n->setChapo ( $kurze_beschreibung );
            	$productI18n->setPostscriptum ( $postscriptum );
            	$productI18n->setMetaTitle( $meta_titel );
            	$productI18n->setMetaDescription( $meta_beschreibung );
            	$productI18n->setMetaKeywords( $meta_keywords );
            	$productI18n->save ();
            	$log->debug ( " product_i18n de_DE is added ".$productI18n->__toString() );
            	$productThelia->addProductI18n ( $productI18n );            	
            	
            	// find product sale element
				$pse = ProductSaleElementsQuery::create()->findOneByProductId( $productThelia->getId() );
				
				if($pse != null){
					
					$currency = Currency::getDefaultCurrency();
					$price = ProductPriceQuery::create()
					->filterByProductSaleElementsId( $pse->getId() )
					->findOneByCurrencyId( $currency->getId() );
				}
				else{
					$pse = new ProductSaleElements();
					$pse->setProduct($productThelia);
				}

				$pse->setRef($ref);
				
				if($menge != null)
				$pse->setQuantity($menge);
				
				if($ist_in_Angebot != null)
				$pse->setPromo($ist_in_Angebot);
				
				if($ist_neu != null)
				$pse->setNewness($ist_neu);
				
				if($gewicht != null)
				$pse->setWeight($gewicht);
				
				if($EAN_code != null)
				$pse->setEanCode($EAN_code);
				
				$pse->save();
				
				//save price
				if ($price === null) {
					$price = new ProductPrice();
					$price->setProductSaleElements($pse);
					$price->setCurrency($currency);
				}
					
				if($promo_price != null)
					$price->setPromoPrice($promo_price);
						
				if($listen_price != null)
					$price->setListenPrice($listen_price);
							
				if($ek_preis_sht != null)
					$price->setEkPreisSht($ek_preis_sht);
					
				if($ek_preis_gc != null)
					$price->setEkPreisGc($ek_preis_gc);
									
				if($ek_preis_oag != null)
					$price->setEkPreisOag($ek_preis_oag);
										
				if($ek_preis_holter != null)
					$price->setEkPreisHolter($ek_preis_holter);
										
				if($preis_reuter != null)
					$price->setPreisReuter($preis_reuter);
												
				if($vergleich_ek != null)
					$price->setVergleichEk($vergleich_ek);
													
				if($aufschlag != null)
					$price->setAufschlag($aufschlag);
														
				$price->save();
						

				//save images
				$image_path = THELIA_LOCAL_DIR;
				$image_name = 'PROD_' . preg_replace("/[^a-zA-Z0-9.]/", "", $bild_file) . '.jpg';
				
				try{
					$image_from_server =@file_get_contents ( THELIA_LOCAL_DIR.DS."importer".DS.$bild_file.'jpg' );
				}
				catch (Exception $e) {
					$log->debug ("ProductImageException :".$e->getMessage());
				}
				
				if($image_from_server){
					file_put_contents ( $image_path . $image_name, $image_from_server );
				
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
            
            else             
            {
            	$errors[] = $this->translator->trans( "Product reference number %ref is already in the database ",
            				["%ref" => $row["sht_id"]] );
            	$log->debug ( " ref number already in the database '" . $ref . "'" );
            	}    	
        $this->importedRows++;
        
        $i++;
        }

        return $errors;
    }

    protected function getMandatoryColumns()
    {
        return ["Ref"];
        /*
         "Produkt_id", "Extern_id", "Ref", "Marke_id", "Kategorie_id", "Produkt_titel", "Kurz_beschreibung", "Beschreibung", "Postscriptum",
        		"Meta_titel", "Meta_beschreibung", "Meta_keywords", "Menge", "Ist_in_Angebot", "Ist_neu", "Gewicht", "EAN_code", "Bild_name", 
        		"Bild_titel", "Bild_beschreibung", "Bild_kurz_beschreibung", "Bild_postscriptum", "Price", "Promo_price", "Listen_price",
        		"Ek_preis_sht", "Ek_preis_gc", "Ek_preis_oag", "Ek_preis_holter", "Preis_reuter", "Vergleich_ek", "Aufschlag"
         */
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
