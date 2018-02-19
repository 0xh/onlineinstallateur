<?php
namespace HookScraper\Controller;

//use Symfony\Component\Form\Form;
//use Symfony\Component\HttpFoundation\RedirectResponse;
use Thelia\Controller\Admin\BaseAdminController;
//use Thelia\Core\Event\File\FileCreateOrUpdateEvent;
use Thelia\Core\Event\TheliaEvents;
use Thelia\Core\Security\AccessManager;
use Thelia\Core\Security\Resource\AdminResources;
use Thelia\Form\Exception\FormValidationException;
//use Thelia\Model\Lang;
//use Thelia\Model\LangQuery;
//use Thelia\Tools\URL;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Thelia\Log\Tlog;
use Thelia\Core\HttpFoundation\Response;
use Thelia\Model\ProductQuery;
use Thelia\Model\Product;
use Thelia\Model\ProductI18n;
use Thelia\Model\ProductImage;
use Thelia\Model\BrandI18nQuery;

/**
 * Class HookScraperController
 * @package HookScraper\Controller
 * @author emanuel plopu <emanuel.plopu@sepa.at>
 */
class HookScraperController extends BaseAdminController
{
	private $cookiefile;
    private $request;
    
    /** @var Tlog $log */
    protected static $logger;
	
	public function scrapeSearch(Request $request){
		
		$this->init();
		
		$this->request = $request;
		
		if ($request->isXmlHttpRequest ()) {
			
			$response = new Response();
			$loginResponse = $this->login();
			echo $loginResponse;
			
			$responsePage =$this->getResults($request->request->get("product_gc_id"));//search results
			
			$bruttoPrice = $this->getBruttoPrice($responsePage);
			
			$GCProductKey = $this->getGCProductKey($responsePage);//first result product key
				
			$productDetails = $this->getGCProductDetails($GCProductKey, 1);
			$productDetails = $this->parseGCProductDetails($productDetails,$bruttoPrice,$request->request->get("brand_id"),$request->request->get("category_id"),0);
		
			$response->setContent($productDetails);
				
			return $response;
		}
		else
			return new JsonResponse ( array ('stuff' => 'more stuff') ); // $productsQuerry->__toString()	
	}
	
	public function scrapeImportedProduct($extern_id,$brand_id,$category_id){
		$responsePage =$this->getResults($extern_id);//search results
			
		$bruttoPrice = $this->getBruttoPrice($responsePage);
			
		$GCProductKey = $this->getGCProductKey($responsePage);//first result product key
		
		$productDetails = $this->getGCProductDetails($GCProductKey, 0);
		$productDetails = $this->parseGCProductDetails($productDetails,$bruttoPrice,$brand_id,$category_id,0);
		
	}
	
	public function init(){
		set_time_limit (0);
		$log = Tlog::getInstance ();
		$log->debug ( "-- hookscraper " );
		$this->getLogger()->error("scraper init");
		$this->cookiefile = dirname(__FILE__) . '/cookie.txt';
	}
	
	
	public function parseGCProductDetails($productJson,$bruttoPrice,$brand_id,$category_id,$info = 1){
	//$productJson = '{"d":{"__type":"GcOnline.getProductDetailsReturn","Variant":"01","Supplier":"HOMO01","RunNumber":209,"ProductNumber":"CMT907","Key1":"LG","Key2":"J","Key3":"100","Key4":"CMT907","CustomerProductNumber":"","GTIN":"","SupplierProductNumber":"CMT907A1066","Description1":"Honeywell Raumthermostat programmierbar","Description2":"f.Einzelraum- und Zonenregelung digital","DTN":"Der CM907 bietet eine automatische Zeit-\u003cbr /\u003eund Temperatursteuerung in Villen und A\u003cbr /\u003epartments. Er kann in vielfältiger Weise\u003cbr /\u003ezur Raumtemperatur-Regelung von einzeln\u003cbr /\u003een Räumen oder Zonen in Verbindung mit Z\u003cbr /\u003eirkulationspumpen, Thermoantrieben, Zone\u003cbr /\u003enventilen und Elektroerhitzern (\u0026lt;8A) ein\u003cbr /\u003egesetzt werden. In einfachen Fällen ist\u003cbr /\u003esogar die Ansteuerung von kleinen Wärmee\u003cbr /\u003erzeugern mit Ölbrennern oder Gasbrennern\u003cbr /\u003edenkbar. Der CM907 besitzt für die schn\u003cbr /\u003eelle und einfache Installation einen Mon\u003cbr /\u003etagesockel mit Kabelkanälen und Ausbrüch\u003cbr /\u003een.\u003cbr /\u003eMerkmale:\u003cbr /\u003eDynamische Texte in des LCD-Anzeige gebe\u003cbr /\u003en zusätzliche Informationen für den Benu\u003cbr /\u003etzer und Installateur.\u003cbr /\u003eLCD-Hinterleuchtung für bessere Anzeige.\u003cbr /\u003e\u003cbr /\u003eEEPROM speichert das Anwendungsprogramm\u003cbr /\u003ebei Batteriewechsel und dauerhaft.\u003cbr /\u003eInstallateur-Einstellbetrieb erlaubt zus\u003cbr /\u003eätzliche Einstellungen nur durch den Ins\u003cbr /\u003etallateur, um die Anforderungen des Nutz\u003cbr /\u003eers zu erfüllen.\u003cbr /\u003eDiagnosebetrieb zum Auffinden von Fehler\u003cbr /\u003en.\u003cbr /\u003eAbmessungen: 133 x 89 x 26 mm (B x H x T\u003cbr /\u003e)\u003cbr /\u003eBatterien: 2 x 1,5 V IEC LR6 (AA) Alkali\u003cbr /\u003ene Zellen / Min. 2 Jahre\u003cbr /\u003eBelastung: 230 Vac, 50...60 Hz, 0,5...8\u003cbr /\u003eA (Ohm), 24 Vac, 50...60 Hz, 0,5...8 A (\u003cbr /\u003eOhm)\u003cbr /\u003eTemp.-Einstellbereich: Programm: 5...35\u003cbr /\u003eGradC in 0,5 Grad C Schritten\u003cbr /\u003e\u003cbr /\u003e\u003cbr /\u003e\u003cbr /\u003e\u003cbr /\u003e\u003cbr /\u003e\u003cbr /\u003e\u003cbr /\u003e\u003cbr /\u003e\u003cbr /\u003e\u003cbr /\u003e","GrosPrice":"160,50","GrosCurrency":"EUR","NetPrice":"","NetCurrency":"","Unit":"Stück","UnitCode":"ST","PriceUnit":"Per 1","PackageUnit1":"Karton","PackageUnit2":"","PackageUnit3":"","PackageUnit4":"","PackageUnit5":"","PackageUnitFactor1":50.000,"PackageUnitFactor2":0.000,"PackageUnitFactor3":0.000,"PackageUnitFactor4":0.000,"PackageUnitFactor5":0.000,"HintText":"","DiscountGroup":"N3AA","DiscountGroupText":"Centra Regelungen und Mischer C1-C6/C10-C11","DecimalsAllowed":false,"OX_SupplierProductNumber":"CMT907A1066","OX_GTIN":"5025121389846","OX_Supplier":"HOMO01","OX_ModelNumber":"","NF_Variant":"","NF_Supplier":"","NF_RunNumber":0,"NF_ProductNumber":"","NF_Desription1":"","NF_Desription2":"","ALT_Variant":"","ALT_Supplier":"","ALT_RunNumber":0,"ALT_ProductNumber":"","ALT_Desription1":"","ALT_Desription2":"","MeasurementUnit":"Honeywell Raumthermostat programmierbar","ProductType":"1","MarkOrderStock":"L","MFVCentralStock":"","CentralStock":"","ShortCutIGNM":"HY","CaptionProductNumber":"Artikelnummer","CaptionCustomerProductNumber":"Kundeneigene Artikelnummer","CaptionGTIN":"GTIN","CaptionSupplierProductNumber":"Hersteller Artikelnummer","CaptionDescription1":"Bezeichnung 1","CaptionDescription2":"Bezeichnung 2","CaptionDTN":"Langtext","CaptionGrosPrice":"Bruttopreis","CaptionGrosCurrency":"Währung","CaptionUnit":"Mengeneinheit","CaptionPriceUnit":"Preiseinheit","CaptionPackageUnit":"Verpackungseinheit","CaptionPkgUnitFactor":"Verpackungsfaktor","CaptionHinttext":"Hinweis","CaptionNetPrice":"Nettopreis","CaptionNetCurrency":"Währung Nettopreis","CaptionDiscountGroup":"Rabattgruppe","CaptionDiscountGrpText":"Rabattgruppen Beschreibung","TabPictures":"\u003ctable\u003e\u003ctr style=\u0027height:160px;\u0027\u003e\u003ctd class=\u0027dtvtd\u0027 \u003e\u003ctable\u003e\u003ctr\u003e\u003ctd\u003e\u003ca id=\u0027multimedia01HOMO012090\u0027 href=\u0027images/data/AbleX/ProductMedia/at/Mediadata_Archiv/1838/2205/104/104936/jpg/0/.converted_1496/converted_1496_hyb_0368w.jpg.jpg\u0027 rel=\u0027lightbox[01:HOMO01:209]\u0027 title=\u0027Fotorealistisches Bild in Farbe\u0027 class=\u0027fancybox\u0027\u003e\u003cimg id=\u0027multimedia01HOMO012090_img\u0027 src=\u0027images/data/AbleX/ProductMedia/at/Mediadata_Archiv/1838/2205/104/104936/jpg/0/.converted_120/converted_120_hyb_0368w.jpg.jpg\u0027 max-width=\u0027100\u0027 max-height=\u0027100\u0027alt=\u0027Fotorealistisches Bild in Farbe\u0027 \u003e\u003c/img\u003e\u003c/a\u003e\u003c/td\u003e\u003c/tr\u003e\u003ctr\u003e\u003ctd align=\u0027center\u0027\u003e\u003ca id=\u0027multimedia01HOMO012090_l\u0027 href=\u0027images/data/AbleX/ProductMedia/at/Mediadata_Archiv/1838/2205/104/104936/jpg/0/.converted_1496/converted_1496_hyb_0368w.jpg.jpg\u0027 rel=\u0027lightbox2[01:HOMO01:209]\u0027 class=\u0027fancybox jqmlink\u0027 data-id=\u00271\u0027 \u003eFotorealistisches Bild in Farbe\u003c/a\u003e\u003c/td\u003e\u003c/tr\u003e\u003c/table\u003e\u003c/td\u003e\u003ctd style=\u0027width:10px;\u0027\u003e\u003c/td\u003e\u003ctd class=\u0027dtvtd\u0027 \u003e\u003ctable\u003e\u003ctr\u003e\u003ctd\u003e\u003ca id=\u0027multimedia01HOMO012091\u0027 href=\u0027images/data/AbleX/ProductMedia/at/Mediadata_Archiv/1838/2205/104/104936/jpg/0/.converted_1496/converted_1496_hys_0369s.jpg.jpg\u0027 rel=\u0027lightbox[01:HOMO01:209]\u0027 title=\u0027Fotorealistisches Schwarz-Weiß-Bild\u0027 class=\u0027fancybox\u0027\u003e\u003cimg id=\u0027multimedia01HOMO012091_img\u0027 src=\u0027images/data/AbleX/ProductMedia/at/Mediadata_Archiv/1838/2205/104/104936/jpg/0/.converted_120/converted_120_hys_0369s.jpg.jpg\u0027 max-width=\u0027100\u0027 max-height=\u0027100\u0027alt=\u0027Fotorealistisches Schwarz-Weiß-Bild\u0027 \u003e\u003c/img\u003e\u003c/a\u003e\u003c/td\u003e\u003c/tr\u003e\u003ctr\u003e\u003ctd align=\u0027center\u0027\u003e\u003ca id=\u0027multimedia01HOMO012091_l\u0027 href=\u0027images/data/AbleX/ProductMedia/at/Mediadata_Archiv/1838/2205/104/104936/jpg/0/.converted_1496/converted_1496_hys_0369s.jpg.jpg\u0027 rel=\u0027lightbox2[01:HOMO01:209]\u0027 class=\u0027fancybox jqmlink\u0027 data-id=\u00272\u0027 \u003eFotorealistisches Schwarz-Weiß-Bild\u003c/a\u003e\u003c/td\u003e\u003c/tr\u003e\u003c/table\u003e\u003c/td\u003e\u003ctd style=\u0027width:10px;\u0027\u003e\u003c/td\u003e\u003c/tr\u003e\u003c/table\u003e","TabPicturePriceList":"\u003ctable\u003e\u003ctr\u003e\u003ctd class=\u0027dxmVerticalMenu jqBPLItem\u0027 style=\u0027cursor:pointer;padding:5px;\u0027\u003eHeizung 852\u003c/td\u003e\u003ctd class=\u0027hidden jqBPLLink\u0027\u003eimages/data/ZENTRAL/Inst_CG/BPL/HTML5/A/ebooks/AT_Heizung/index.html#page/852\u003c/td\u003e\u003c/tr\u003e\u003c/table\u003e","TabOthers":"","Tab3D":"","ShowMultimedia":true,"ShowNet":false,"ShowDTN":true,"ShowStock":false,"ShowBPL":true,"ShowJumbo":false,"ShowNRF":false,"ShowOxomi":false,"MultimediaItems":null,"Attributes":null,"IsAbleX":true,"IsUnlimited":false,"UnlimitedHint":null}}';

	    
		$log = Tlog::getInstance ();
		$log->debug(" gc_scrapper ");
		$productQuerry = ProductQuery::create ();
		//$brandI18nQuerry = BrandI18nQuery::create();
		
		$response = "";
		$jsonResponse = json_decode($productJson, true);

		$product = $jsonResponse["d"];
		
		
		//product - ref, category, price, weight, quantity
		//gc_id -hf ref 
		$response .= "Brutto price: ".$bruttoPrice ." <br>";
		
		$productNumber = $product["ProductNumber"];
		$response .= "ProductNumber: ".$productNumber ." <br>";
		
		$supplierProductNumber = $product["SupplierProductNumber"];
		$response .= "SupplierProductNumber: ".$supplierProductNumber ." <br>";
		
		//product description - locale,title,description,short,post
		$title = $product["Description1"]." ".$product["Description2"];
		$response .= "Title: ".$title ." <br>";
		
		$description = $product["DTN"];
		$description  = str_replace("<br />"," ", $description);
		$response .= "Description: <br><br>".$description ."<br><br>";
		
		//chapo
		$short = $product["Description1"]." ".$product["Description2"];
		$response .= "Summary: ".$short ." <br>";
		
		//post - abmessungen
		$productPriceRequest = [];
		$productPriceRequest['Variant'] = $product['Variant'];
		$productPriceRequest['Supplier'] = $product['Supplier'];
		$productPriceRequest['RunNumber'] = $product['RunNumber'];
		$productPriceRequest['Key1'] = $product['Key1'];
		$productPriceRequest['Key2'] = $product['Key2'];
		$productPriceRequest['Key3'] = $product['Key3'];
		$productPriceRequest['Key4'] = $product['Key4'];
		$productPriceRequest['Unit'] = $product['Unit'];
		$productPriceRequest['DiscountGroup'] = $product['DiscountGroup'];
		$productPriceRequest['ProductType'] = $product['ProductType'];
		$productPriceRequest['MarkStockOrder'] = $product['MarkOrderStock'];
		$productPriceRequest['MFVCentralStock'] = $product['MFVCentralStock'];
		$productPriceRequest['CentralStock'] = $product['CentralStock'];
		$productPriceRequest['NFVariant'] = $product['NF_Variant'];
		$productPriceRequest['NFSupplier'] = $product['NF_Supplier'];
		$productPriceRequest['NFRunNumber'] = $product['NF_RunNumber'];
		$productPriceRequest['ALTVariant'] = $product['ALT_Variant'];
		$productPriceRequest['ALTSupplier'] = $product['ALT_Supplier'];
		$productPriceRequest['ALTRunNumber'] = $product['ALT_RunNumber'];
			
		//price
		$productPriceAndStock = $this->getGCProductPrice($productPriceRequest);
		$productPriceAndStock = $this->parseGCProductPrice($productPriceAndStock);

		$response .= "Price: ".$productPriceAndStock ." <br>";
		
		$currentDate = date ( "Y-m-d H:i:s" );

		$productCategoryID = 10;
		if($category_id != null)
		$productCategoryID = $category_id;
		
		$productExists = count ( $productQuerry->findByRef ( $productNumber ) );
		
		if ($productExists == 0) // product_numbers must be unique
		{
			$log->debug ( " gc_imported_product is new " );
			
			$productThelia = new Product ();
			$productThelia->setRef ( $productNumber ); // must be unique
			$productThelia->setExternId($productNumber);
			$productThelia->setVisible ( 1 );
			if($brand_id != null && $brand_id != "")
			$productThelia->setBrandId($brand_id);
			else $productThelia->setBrandId(1);
			$productThelia->setCreatedAt ( $currentDate );
			$productThelia->setUpdatedAt ( $currentDate );
			$productThelia->setVersion ( 1 );
			$productThelia->setVersionCreatedAt ( $currentDate );
			$productThelia->setVersionCreatedBy ( "scraper.gc.1" );
			$productThelia->create ( $productCategoryID, $productPriceAndStock, 1, 1, 'NULL', 20 );
			
			$productThelia->getProductSaleElementss()[0]->getProductPrices()[0]->setListenPrice($bruttoPrice)->save();
			
			$log->debug ( " gc_imported_product is add as product " );
			$this->getLogger()->error(" added GC_ID ".$productNumber." brand ".$brand_id." category ".$category_id);
			
			// product description
			$locale = "en_US";
			$productI18n = new ProductI18n ();
			$productI18n->setProduct ( $productThelia );
			$productI18n->setLocale ( $locale );
			$productI18n->setTitle ( $title );
			$productI18n->setDescription ( $description );
			$productI18n->setChapo ( $short );
			$productI18n->setPostscriptum ( "" );
			$productI18n->save ();
			$log->debug ( " product_i18n ".$locale." is added ".$productI18n->__toString() );
			$productThelia->addProductI18n ( $productI18n );
			 
			$locale = "de_DE";
			$productI18n = new ProductI18n ();
			$productI18n->setProduct ( $productThelia );
			$productI18n->setLocale ( $locale );
			$productI18n->setTitle ( $title );
			$productI18n->setDescription ( $description );
			$productI18n->setChapo ( $short );
			$productI18n->setPostscriptum ( "" );
			$productI18n->save ();
			$log->debug ( " product_i18n ".$locale." is added ".$productI18n->__toString() );
			$productThelia->addProductI18n ( $productI18n );

			
			$media_dir = explode("local",dirname(__FILE__));
			$media_dir = $media_dir[0]."local".DIRECTORY_SEPARATOR."media".DIRECTORY_SEPARATOR."images".DIRECTORY_SEPARATOR."product";
			
			$pictureTable = $product['TabPictures'];
			//$response .= "images: <br>".$pictureTable ." <br>";
			
			$pictureLayoutArray = explode("<tr><td>",$pictureTable);
			
			for($i = 1;$i<count($pictureLayoutArray);$i++){
				$splitPictureLayout = explode("href='",$pictureLayoutArray[$i]);
				$removePictureEnding = explode("' rel='",$splitPictureLayout[1]);
				$pictureName = explode("/",$removePictureEnding[0]);
				$escapePictureSpaces = str_replace(" ","%20",$removePictureEnding[0]);
				$response .= 'images2: <img src=http://www.gconlineplus.at/'.$escapePictureSpaces .' style="width:400px;height:400px;">'.$pictureName[count($pictureName)-1].' <br>'.$media_dir.'<br><br>';
				//	heizfabrik\local\media\images\product
					
					
				$image_save_path = $media_dir .DIRECTORY_SEPARATOR;
					
					
				$product_image_url = "http://www.gconlineplus.at/".$escapePictureSpaces;
				$log->info(" gc_scrapper ".$product_image_url."");
				if($product_image_url){
					// product image
					//$product_image_url = $product_image_url."_".$image_index;
					//$image_name = 'PROD_' . $productThelia->getRef()."_".$image_index.'.jpg';
						
					try{
						$image_from_server =@file_get_contents ( $product_image_url );
					}
					catch (Exception $e) {
						$log->debug ("ProductImageException :".$e->getMessage());
					}
						
					if($image_from_server){
						file_put_contents ( $image_save_path .$productNumber."_".$i.".jpg", $image_from_server );
						
						 $product_image = new ProductImage ();
						 $product_image->setProduct ( $productThelia );
						 $product_image->setVisible ( 1 );
						 $product_image->setCreatedAt ( $currentDate );
						 $product_image->setUpdatedAt ( $currentDate );
						 $product_image->setFile ( $productNumber."_".$i.".jpg" );
						 $product_image->save ();
			
						 $productThelia->addProductImage ( $product_image );
					}
				}
			}
		}
		else{
			$log->debug ( " ref number already in the database");
			$this->getLogger()->error("ref number already in the database".$productNumber);
		}
			
		
		
		$media_dir = explode("local",dirname(__FILE__));
		$media_dir = $media_dir[0]."local".DIRECTORY_SEPARATOR."media".DIRECTORY_SEPARATOR."images".DIRECTORY_SEPARATOR."product";
		
		$pictureTable = $product['TabPictures'];
		//$response .= "images: <br>".$pictureTable ." <br>";
			
		$pictureLayoutArray = explode("<tr><td>",$pictureTable);
			
		for($i = 1;$i<count($pictureLayoutArray);$i++){
			$splitPictureLayout = explode("href='",$pictureLayoutArray[$i]);
			$removePictureEnding = explode("' rel='",$splitPictureLayout[1]);
			$pictureName = explode("/",$removePictureEnding[0]);
			$escapePictureSpaces = str_replace(" ","%20",$removePictureEnding[0]);
			$response .= 'images2: <img src=http://www.gconlineplus.at/'.$escapePictureSpaces .' style="width:200px;height:200px;">'.$pictureName[count($pictureName)-1].' <br>'.$media_dir.'<br><br>';
			//	heizfabrik\local\media\images\product
				
			/*
			$image_save_path = $media_dir .DIRECTORY_SEPARATOR;
				
				
			$product_image_url = "http://www.gconlineplus.at/".$removePictureEnding[0];
			if($product_image_url){
				// product image
				//$product_image_url = $product_image_url."_".$image_index;
				//$image_name = 'PROD_' . $productThelia->getRef()."_".$image_index.'.jpg';
		
				try{
					$image_from_server =@file_get_contents ( $product_image_url );
				}
				catch (Exception $e) {
					$log->debug ("ProductImageException :".$e->getMessage());
				}
		
				if($image_from_server){
					file_put_contents ( $image_save_path .$productNumber."_".$i.".jpg", $image_from_server );
		
					$product_image = new ProductImage ();
					$product_image->setProduct ( $productThelia );
					$product_image->setVisible ( 1 );
					$product_image->setCreatedAt ( $currentDate );
					$product_image->setUpdatedAt ( $currentDate );
					$product_image->setFile ( $productNumber."_".$i.".jpg" );
					$product_image->save ();
						
					$productThelia->addProductImage ( $product_image );
				}
			}
			*/
		} 
		
		
		
		
		/*
		$zusammengefaste_beschreibung = $product["Beschreibung"];
		$response .= "Kurze beschreibung: ".$zusammengefaste_beschreibung." <br>";
		
		//price
		$preis = 0;
		$preisField = $product["Bruttopreis"];
		$preisEnd = strpos($preisField," EUR");
		if($preisEnd>0)
			$preis = substr($preisField,0,$preisEnd);
			$response .= "bruttopreis: ".$preis." <br>";
		
			//quantity
			$quantity = 0;
			$quantityField = $product["Lagertext"];
			$quantityStart = strpos($quantityField,"Der Bestand beträgt ")+strlen("Der Bestand beträgt ");
			if($quantityStart>0)
				$quantity = substr($quantityField,$quantityStart,strlen($quantityField)-strpos($quantityField," Stück")-strlen(" Stück"));
				$response .= "Menge: ".$quantity." <br>";
		*/
				//$response+= $firstProduct;
				//brand
				
				//product description - locale,title,description,short,post
				//product heizung grade,power,efficiency,warmwater,storage,energy carrier
		return $response;
	}
	
	public function parseGCProductPrice($productPriceResponse){
		/*
		{"d":{"__type":"GcOnline.ProductDetailsSet","TabPictures":"","TabOthers":"","Tab3D":"","TabPicturePriceList":"",
		"FollowUpSymbol":"","FollowUpText":"","AlternateSymbol":"","AlternateText":"",
		"Stocks":[{"Number":"0","Name":"Wiener Neudorf Zentrallager","Symbol":"images/shared/gruen.gif",
		"Address":"GC Gebäudetechnik KG\u003cbr\u003e- Neue Halle -\u003cbr\u003e\u003cbr\u003eIZ-NÖ-Süd, Straße 10\u003cbr\u003e2355 Wiener Neudorf",
		"StockTooltip":"Der Artikel ist im Lager verfügbar. Der Bestand beträgt 42 Stück."},
		
		{"Number":"1","Name":"ABEX Traun","Symbol":"images/shared/gruen.gif","Address":"Steiner Haustechnik KG\u003cbr\u003e** Lagerergänzung **\u003cbr\u003e\u003cbr\u003eBäckerfeldstraße 15-17\u003cbr\u003e4050 Traun","StockTooltip":"Der Artikel ist im Lager verfügbar. Der Bestand beträgt 2 Stück."},
		{"Number":"2","Name":"ABEX Linz","Symbol":"images/shared/gruen.gif","Address":"Weyland Haustechnik KG\u003cbr\u003e- ABEX Linz -\u003cbr\u003e\u003cbr\u003eFreistädterstr. 401\u003cbr\u003e4040 Linz","StockTooltip":"Der Artikel ist im Lager verfügbar. Der Bestand beträgt 2 Stück."},
		{"Number":"3","Name":"ABEX Steyr","Symbol":"images/shared/gruen.gif","Address":"Abex Steyr\u003cbr\u003e\u003cbr\u003e\u003cbr\u003eRennbahnweg 2-4\u003cbr\u003e4400 Steyr","StockTooltip":"Der Artikel ist im Lager verfügbar. Der Bestand beträgt 5 Stück."},
		{"Number":"4","Name":"Bergheim/Sbg. Zentrallager","Symbol":"images/shared/gruen.gif","Address":"Steiner Haustechnik KG\u003cbr\u003e\u003cbr\u003e\u003cbr\u003eHandelszentrum 4\u003cbr\u003e5101 Bergheim","StockTooltip":"Der Artikel ist im Lager verfügbar. Der Bestand beträgt 19 Stück."},
		{"Number":"5","Name":"Schärding Zentrallager","Symbol":"images/shared/gruen.gif","Address":"Weyland Haustechnik KG\u003cbr\u003e\u003cbr\u003e\u003cbr\u003eHaid 26\u003cbr\u003e4780 Schärding","StockTooltip":"Der Artikel ist im Lager verfügbar. Der Bestand beträgt 41 Stück."},
		{"Number":"6","Name":"Bergheim/Sbg. Zentrallager","Symbol":"images/shared/gelb.gif","Address":"Bergheim/Sbg. Zentrallager\u003cbr\u003e\u003cbr\u003e\u003cbr\u003eHandelszentrum 4\u003cbr\u003e5101 Bergheim","StockTooltip":"Zentrallager Bergheim verfügbar"},
		{"Number":"7","Name":"Schärding Zentrallager","Symbol":"images/shared/gelb.gif","Address":"Schärding Zentrallager\u003cbr\u003e\u003cbr\u003e\u003cbr\u003eHaid 26\u003cbr\u003e4780 Schärding","StockTooltip":"Zentrallager Schärding verfügbar"},
		{"Number":"8","Name":"Wiener Neudorf Zentrallager","Symbol":"images/shared/gelb.gif","Address":"Wiener Neudorf Zentrallager\u003cbr\u003e- Neue Halle -\u003cbr\u003e\u003cbr\u003eIZ-NÖ-Süd, Straße 10\u003cbr\u003e2355 Wiener Neudorf","StockTooltip":"Zentrallager Wr. Neudorf verfügbar"}],
		"Parts":[],"Prices":[{"Text":"Nettopreis","Value":"87,80","Currency":"EUR"},{"Text":"Total:","Value":"87,80","Currency":"EUR"}]}}
		*/
		$jsonResponse = json_decode($productPriceResponse, true);
		$d = $jsonResponse['d'];
		$prices = $d['Prices'];
		
		if(is_array($prices)){
			reset($prices);
			//echo "price ".$prices[0]['Value']."<br>";
			return $prices[0]['Value'];
		}
		return 0;
	}
	
	public function getGCProductPrice($productDetails){
		// send login request
		//$ch1 = curl_init("localhost/scraper/form.php");
		$ch1 = curl_init("http://www.gconlineplus.at/ProductDetails2.aspx/getPricesAndStock");
		
		/*
		{'Variant': '01', 'Supplier' : 'HOMO01', 'RunNumber': 209, 
		'Key1': 'LG', 'Key2': 'J', 'Key3': '100', 'Key4': 'CMT907', 
		'Unit': 'Stück', 'DiscountGroup': 'N3AA', 'ProductType': '1', 'MarkStockOrder': 'L', 'MFVCentralStock': '', 
		'CentralStock': '', 'NFVariant': '', 'NFSupplier': '', 'NFRunNumber': 0, 'ALTVariant': '', 'ALTSupplier': '', 'ALTRunNumber': 0}
		*/
		
		$formFields = [];
		$formFields['Variant'] = $productDetails['Variant'];
		$formFields['Supplier'] = $productDetails['Supplier'];
		$formFields['RunNumber'] = $productDetails['RunNumber'];
		$formFields['Key1'] = $productDetails['Key1'];
		$formFields['Key2'] = $productDetails['Key2'];
		$formFields['Key3'] = $productDetails['Key3'];
		$formFields['Key4'] = $productDetails['Key4'];
		$formFields['Unit'] = $productDetails['Unit'];
		$formFields['DiscountGroup'] = $productDetails['DiscountGroup'];
		$formFields['ProductType'] = $productDetails['ProductType'];
		$formFields['MarkStockOrder'] = $productDetails['MarkStockOrder'];
		$formFields['MFVCentralStock'] = $productDetails['MFVCentralStock'];
		$formFields['CentralStock'] = $productDetails['CentralStock'];
		$formFields['NFVariant'] = $productDetails['NFVariant'];
		$formFields['NFSupplier'] = $productDetails['NFSupplier'];
		$formFields['NFRunNumber'] = $productDetails['NFRunNumber'];
		$formFields['ALTVariant'] = $productDetails['ALTVariant'];
		$formFields['ALTSupplier'] = $productDetails['ALTSupplier'];
		$formFields['ALTRunNumber'] = $productDetails['ALTRunNumber'];
		
		$searchParams_data = json_encode($formFields);
		
		curl_setopt($ch1, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch1, CURLOPT_COOKIEJAR, $this->cookiefile);
		curl_setopt($ch1, CURLOPT_COOKIEFILE, $this->cookiefile);
		curl_setopt($ch1, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2767.4 Safari/537.36");
		curl_setopt($ch1, CURLOPT_POST, 1);
		curl_setopt($ch1,CURLOPT_POSTFIELDS, $searchParams_data);
		curl_setopt($ch1, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch1, CURLOPT_HTTPHEADER, array(
				"Accept: application/json,text/javascript,*/*;q=0.01",
				"Accept-Encoding: deflate",
				"Content-Type: application/json;charset=UTF-8",
				"Content-Length: ".strlen($searchParams_data),
				"X-Requested-With: XMLHttpRequest"
		));
		
		$result1 = curl_exec($ch1);
		//$full_results .=$result1;
		//echo "got price and stock <br>";
		
		file_put_contents(dirname(__FILE__) .DIRECTORY_SEPARATOR."responses".DIRECTORY_SEPARATOR."scraper_price_and_stock.txt", $result1."\n\n");
		file_put_contents(dirname(__FILE__) .DIRECTORY_SEPARATOR."errors".DIRECTORY_SEPARATOR."scraper_error_price_and_stock.txt", curl_error($ch1)."\n\n");
		
		curl_close($ch1);	
		
		return $result1;
	}
	
	public function getGCProductDetails($GCProductKey,$info = 1){
		//$log = Tlog::getInstance ();
		//	http://www.gconlineplus.at/ProductResultList.aspx/SetSessionProductKeys
		//6th set product
		$ch1 = curl_init("http://www.gconlineplus.at/ProductResultList.aspx/SetSessionProductKeys");
		
		$searchParams = array();
		$searchParams['strValues'] = $GCProductKey;
		
		$searchParams_data = json_encode($searchParams);
		
		curl_setopt($ch1, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch1, CURLOPT_COOKIEJAR, $this->cookiefile);
		curl_setopt($ch1, CURLOPT_COOKIEFILE, $this->cookiefile);
		curl_setopt($ch1, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2767.4 Safari/537.36");
		curl_setopt($ch1, CURLOPT_POST, 1);
		curl_setopt($ch1,CURLOPT_POSTFIELDS, $searchParams_data);
		curl_setopt($ch1, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch1, CURLOPT_HTTPHEADER, array(
				"Accept: application/json,text/javascript,*/*;q=0.01",
				"Accept-Encoding: deflate",
				"Content-Type: application/json;charset=UTF-8",
				"Content-Length: ".strlen($searchParams_data),
				"X-Requested-With: XMLHttpRequest"
		));
		
		$result1 = curl_exec($ch1);
		//$response .= $result1;
		if($info)
		echo "Send request with the first result productKey:".$GCProductKey." <br>";
		
		file_put_contents(dirname(__FILE__) .DIRECTORY_SEPARATOR."posts".DIRECTORY_SEPARATOR."6scraper_post_product_key.txt", $searchParams_data."\n".strlen($searchParams_data)."\n\n");
		file_put_contents(dirname(__FILE__) .DIRECTORY_SEPARATOR."responses".DIRECTORY_SEPARATOR."6scraper_product_key.txt", $result1."\n\n");
		file_put_contents(dirname(__FILE__) .DIRECTORY_SEPARATOR."errors".DIRECTORY_SEPARATOR."6scraper_error_product_key.txt", curl_error($ch1)."\n\n");
		
		curl_close($ch1);
			
		 //   http://www.gconlineplus.at/ProductDetails2.aspx/getDetails
		 //7th request for product details
		 $ch1 = curl_init("http://www.gconlineplus.at/ProductDetails2.aspx/getDetails");
		 
		 $searchParams = array();
		 
		 $searchParams_data = json_encode($searchParams);
		
		 curl_setopt($ch1, CURLOPT_RETURNTRANSFER, 1);
		 curl_setopt($ch1, CURLOPT_COOKIEJAR, $this->cookiefile);
		 curl_setopt($ch1, CURLOPT_COOKIEFILE, $this->cookiefile);
		 curl_setopt($ch1, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2767.4 Safari/537.36");
		 curl_setopt($ch1, CURLOPT_POST, 1);
		 curl_setopt($ch1,CURLOPT_POSTFIELDS, "{}");
		 curl_setopt($ch1, CURLOPT_FOLLOWLOCATION, 1);
		 curl_setopt($ch1, CURLOPT_HTTPHEADER, array(
		 		"Accept: application/json,text/javascript,*/*;q=0.01",
		 		"Accept-Encoding: deflate",
		 		"Content-Type: application/json;charset=UTF-8",
		 		"Content-Length: ".strlen("{}"),
		 		"X-Requested-With: XMLHttpRequest"
		 ));
		 
		 $result1 = curl_exec($ch1);
		 //$response .= $result1;
		 //$full_results .=$result1;
		 //echo "Received product details json ".$searchParams_data." length ".strlen($searchParams_data)."<br>";
		
		 //echo $result1;
		 file_put_contents(dirname(__FILE__) .DIRECTORY_SEPARATOR."responses".DIRECTORY_SEPARATOR."7scraper_product_details.txt", $result1."\n\n");
		 file_put_contents(dirname(__FILE__) .DIRECTORY_SEPARATOR."errors".DIRECTORY_SEPARATOR."7scraper_error_product_details.txt", curl_error($ch1)."\n\n");
		
		 curl_close($ch1);
		// $result1 = preg_replace_callback("/\\\\u([a-f0-9]{4})/e", "iconv('UCS-4LE','UTF-8',pack('V', hexdec('U$1')))", $result1);
		 $result1 = preg_replace_callback('/\\\\u([0-9a-fA-F]{4})/', function ($match) {
		 	return mb_convert_encoding(pack('H*', $match[1]), 'UTF-8', 'UCS-2BE');
		 }, $result1);
		 
		 return $result1;
	}
	
	
	
	public function login($info = 1){

		//first request in order to get some cookies :P
		$ch1 = curl_init("http://www.gconlineplus.at");
		
		curl_setopt($ch1, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch1, CURLOPT_COOKIEJAR, $this->cookiefile);
		curl_setopt($ch1, CURLOPT_COOKIEFILE, $this->cookiefile);
		curl_setopt($ch1, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2767.4 Safari/537.36");
		
		$result1 = curl_exec($ch1);
		//$full_results .=$result1;
		
		//if cookies are still valid nwing should be in the page and no need to login
		if(strpos($result1,"nwing")>0)
			return true;
		
		if($info)
		echo "first request sent, received cookies <br>";
		
		file_put_contents(dirname(__FILE__) .DIRECTORY_SEPARATOR."responses".DIRECTORY_SEPARATOR."1scraper_first.txt", $result1."\n\n");
		file_put_contents(dirname(__FILE__) .DIRECTORY_SEPARATOR."errors".DIRECTORY_SEPARATOR."1scraper_error_first.txt", curl_error($ch1)."\n\n");
		
		curl_close($ch1);
		
		$formFields = array();
		
		$formFields['__EVENTTARGET'] = $this->get_input($result1,'id="__EVENTTARGET" value="');
		$formFields['__EVENTARGUMENT'] = $this->get_input($result1,'id="__EVENTARGUMENT" value="');
		$formFields['__EVENTSTATE'] = $this->get_input($result1,'id="__VIEWSTATE" value="');
		
		$formFields['__VIEWSTATEGENERATOR'] = $this->get_input($result1,'id="__VIEWSTATEGENERATOR" value="');
		$formFields['__EVENTVALIDATION'] = $this->get_input($result1,'id="__EVENTVALIDATION" value="');
		
		$formFields['txtUserName'] = 'NWING14C5';
		$formFields['txtPassword'] = 'budget07';
		
		
		//second in order to update some event data
		$ch1 = curl_init("http://www.gconlineplus.at/loginpanel.aspx");
		
		curl_setopt($ch1, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch1, CURLOPT_COOKIEJAR, $this->cookiefile);
		curl_setopt($ch1, CURLOPT_COOKIEFILE, $this->cookiefile);
		curl_setopt($ch1, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2767.4 Safari/537.36");
		
		$result1 = curl_exec($ch1);
		//$full_results .=$result1;
		
		if($info)
		echo "second request sent, received asp hidden fields <br>";
		
		//echo $result1;
		file_put_contents(dirname(__FILE__) .DIRECTORY_SEPARATOR."responses".DIRECTORY_SEPARATOR."2scraper_second.txt", $result1."\n\n");
		file_put_contents(dirname(__FILE__) .DIRECTORY_SEPARATOR."errors".DIRECTORY_SEPARATOR."2scraper_error_second.txt", curl_error($ch1)."\n\n");
		
		curl_close($ch1);
		
		$formFields = array();
		
		$formFields['__EVENTTARGET'] = $this->get_input($result1,'id="__EVENTTARGET" value="');
		$formFields['__EVENTARGUMENT'] = $this->get_input($result1,'id="__EVENTARGUMENT" value="');
		$formFields['__VIEWSTATE'] = $this->get_input($result1,'id="__VIEWSTATE" value="');
		
		$formFields['__VIEWSTATEGENERATOR'] = $this->get_input($result1,'id="__VIEWSTATEGENERATOR" value="');
		$formFields['__EVENTVALIDATION'] = $this->get_input($result1,'id="__EVENTVALIDATION" value="');
		
		$formFields['txtUserName'] = 'NWING14C5';
		$formFields['txtPassword'] = 'budget07';
		
		
		// send login request
		//$ch1 = curl_init("localhost/scraper/form.php");
		$ch1 = curl_init("http://www.gconlineplus.at/loginpanel.aspx");
		
		$fieldsString = "";
		//url-ify the data for the POST
		foreach($formFields as $key=>$value) { $fieldsString .= $key.'='.$value.'&'; }
		$fieldsString = rtrim($fieldsString, '&');
		
		//echo "<br> ".$fieldsString." <br>";
		curl_setopt($ch1, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch1, CURLOPT_COOKIEJAR, $this->cookiefile);
		curl_setopt($ch1, CURLOPT_COOKIEFILE, $this->cookiefile);
		curl_setopt($ch1, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2767.4 Safari/537.36");
		curl_setopt($ch1, CURLOPT_POST, 1);
		curl_setopt($ch1,CURLOPT_POSTFIELDS, $fieldsString);
		curl_setopt($ch1, CURLOPT_FOLLOWLOCATION, 1);

		
		$result1 = curl_exec($ch1);
		//$full_results .=$result1;
		
		if($info)
		echo "third request sent, user is logged in <br>";
		
		file_put_contents(dirname(__FILE__) .DIRECTORY_SEPARATOR."responses".DIRECTORY_SEPARATOR."3scraper_login.txt", $result1."\n\n");
		file_put_contents(dirname(__FILE__) .DIRECTORY_SEPARATOR."errors".DIRECTORY_SEPARATOR."3scraper_error_login.txt", curl_error($ch1)."\n\n");
		
		curl_close($ch1);	
	}
	
public function getResults($product_gc_id,$info = 1){
	
		//AEEHT100
	if($info)
	echo " Results for ".$product_gc_id."<br>";
	
	

// set search parameters
//$ch1 = curl_init("localhost/scraper/form.php");
$ch1 = curl_init("http://www.gconlineplus.at/FullTextSearch.aspx/SetSearchParmsFT");

$searchParams = array();
$searchParams['strSearchText'] = $product_gc_id;
$searchParams['strExcludeText'] = ' ';
$searchParams['blnSearchWithOr'] = false;
$searchParams['strDiscounts'] = '';
$searchParams['strDiscountText'] = '';
$searchParams['strFilterStock'] = '555104';
$searchParams['blnOnlyStock'] = false;
$searchParams['blnOnlyProductNumber'] = false;
$searchParams['blnOnlyManufacturerNo'] = false;

$searchParams_data = json_encode($searchParams); 

curl_setopt($ch1, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt($ch1, CURLOPT_COOKIEJAR, $this->cookiefile);
curl_setopt($ch1, CURLOPT_COOKIEFILE, $this->cookiefile);
curl_setopt($ch1, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2767.4 Safari/537.36");
curl_setopt($ch1, CURLOPT_POST, 1);
//curl_setopt($ch1, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch1,CURLOPT_POSTFIELDS, $searchParams_data);
curl_setopt($ch1, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch1, CURLOPT_HTTPHEADER, array(
 "Accept: application/json,text/javascript,*/*;q=0.01",
 "Accept-Encoding: deflate",
 "Content-Type: application/json;charset=UTF-8", 
 "Content-Length: ".strlen($searchParams_data),
 "X-Requested-With: XMLHttpRequest"
 ));

$result1 = curl_exec($ch1); 
//$full_results .=$result1;
//echo "Search parameters have been sent <br>";

file_put_contents(dirname(__FILE__) .DIRECTORY_SEPARATOR."posts".DIRECTORY_SEPARATOR."4scraper_post_search_parameters.txt", $searchParams_data."\n".strlen($searchParams_data)."\n\n");
file_put_contents(dirname(__FILE__) .DIRECTORY_SEPARATOR."responses".DIRECTORY_SEPARATOR."4scraper_search_parameters.txt", $result1."\n\n");
file_put_contents(dirname(__FILE__) .DIRECTORY_SEPARATOR."errors".DIRECTORY_SEPARATOR."4scraper_error_search_parameters.txt", curl_error($ch1)."\n\n");

curl_close($ch1);

// get search results
//$ch1 = curl_init("localhost/scraper/form.php");
$ch1 = curl_init("http://www.gconlineplus.at/ProductResultList.aspx/GetProducts");

$searchParams = array();
$searchParams['strOrder'] = 'Bestand';
$searchParams['strDirection'] = 'asc';
$searchParams['_search'] = false;
$searchParams['nd'] = 1466248084681;
$searchParams['rows'] = -1;
$searchParams['page'] = 1;
$searchParams['sidx'] = '';
$searchParams['sord'] = 'asc';

$searchParams_data = json_encode($searchParams); 

curl_setopt($ch1, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt($ch1, CURLOPT_COOKIEJAR, $this->cookiefile);
curl_setopt($ch1, CURLOPT_COOKIEFILE, $this->cookiefile);
curl_setopt($ch1, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2767.4 Safari/537.36");
curl_setopt($ch1, CURLOPT_POST, 1);
//curl_setopt($ch1, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch1,CURLOPT_POSTFIELDS, $searchParams_data);
curl_setopt($ch1, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch1, CURLOPT_HTTPHEADER, array(
 "Accept: application/json,text/javascript,*/*;q=0.01",
 "Accept-Encoding: deflate",
 "Content-Type: application/json;charset=UTF-8", 
 "Content-Length: ".strlen($searchParams_data),
 "X-Requested-With: XMLHttpRequest"
 ));



$result1 = curl_exec($ch1);
//$full_results .=$result1;
//echo "Got search response <br>";

file_put_contents(dirname(__FILE__) .DIRECTORY_SEPARATOR."posts".DIRECTORY_SEPARATOR."5scraper_post_search_products.txt", $searchParams_data."\n".strlen($searchParams_data)."\n\n");
file_put_contents(dirname(__FILE__) .DIRECTORY_SEPARATOR."responses".DIRECTORY_SEPARATOR."5scraper_search_products.txt", $result1."\n\n");
file_put_contents(dirname(__FILE__) .DIRECTORY_SEPARATOR."errors".DIRECTORY_SEPARATOR."5scraper_error_search_products.txt", curl_error($ch1)."\n\n");

curl_close($ch1);

 
//TODO make it a streaming response
	
return $result1;
		
}

public function getBruttoPrice($responsePage){
	 
	 
	$page = str_replace("\u003cbr /\u003e"," ",$responsePage);
	$jsonResponse = json_decode($page, true);
	$d = $jsonResponse["d"];
	 
	$rows = $d["rows"];
	$product = array_pop($rows);
	 
	$preis = 0;
	$preisField = $product["Bruttopreis"];
	$preisEnd = strpos($preisField,".00");
	if($preisEnd>0)
		$preis = substr($preisField,0,$preisEnd);
		 
		$preis = substr_replace($preis, ".", strlen($preis)-2, 0);
		return $preis;
}

	private function get_input($result, $target_string){
		$target_start = strpos($result, $target_string)+strlen($target_string);
	
		if ($target_start !== FALSE){
			$target_end = strpos($result,'" />',$target_start);
			$target_value = substr($result,$target_start,$target_end-$target_start);
			//echo $target_start." ".$target_end." |".$target_value."|<br>";
			return urlencode($target_value);
		}
	
	}
	
	public function getGCProductKey($pageResult){
		if (!is_null($pageResult)) {
			
			$jsonResponse = json_decode($pageResult, true);
			$d = $jsonResponse["d"];

			
			$rows = $d["rows"];
			if(is_array($rows)){
			reset($rows);
			$product = $rows[0];//first result
			$artikelNummer = $product["Artikelnummer"];
			$productKeys = explode("|",$artikelNummer);
			$productKey = $productKeys[1];
			return "WK:".$productKey;
			}
			else return null;
			/*
			//gc_id -hf ref
			$artikelField = $product["Artikelnummer"];
			$externId = substr($artikelField,strpos($artikelField,"WerksNr:")+strlen("WerksNr:"),-1);
			$response .= "WerksNr: ".$externId." <br>";*/
		}
	}

    
    public function GCproductPageImport($page){
    	
    	if (!is_null($page)) {
    		$page = str_replace("\u003cbr /\u003e"," ",$page);
    		$jsonResponse = json_decode($page, true);
    		
    		/*
    		 {"d":{"total":"1","page":"1",
    		 "records":null,
    		 "userdata":"0|False|True|10|1|1|1|False",
    		 "rows":[{"InfoImages":"",
    		 "Artikelnummer":"VVB801252PP|01:VARE01:69|WerksNr:303205|",
    		 "Werksnummer":null,"GTIN":null,
    		 "Bild":"images/shared/empty_image.gif",
    		 "Beschreibung":"Vaillant Verlängerung Brennwert\u003cbr /\u003eLuft-/Abgasführung, PP, 80/125, 2,0 m",
    		 "Bestand":"images/shared/gruen.gif",
    		 "Mengeneinheit":"Stück","VPE":"",
    		 "Bruttopreis":"14900.00 EUR\u003cbr /\u003ePer 1",
    		 "Preiseinheit":null,"Nettopreis":"9685.00 EUR\u003cbr /\u003ePer 1",
    		 "Lagertext":"Der Artikel ist im Lager verfügbar. Der Bestand beträgt 2 Stück.",
    		 "Variante":"01","Lieferant":"VARE01","LfdWeNr":"69",
    		 "NachkommastellenErlaubt":false,"ProductKey":"01:VARE01:69"}],"temp":null,"message":""}}*/
    		/*
    		 {"d":
    		 {"total":"1","page":"1",
    		 "records":null,
    		 "userdata":"0|False|True|10|2|2|1|False",
    		 "rows":[{"InfoImages":"",
    		 "Artikelnummer":"CMT907|01:HOMO01:209|WerksNr:CMT907A1066|",
    		 "Werksnummer":null,"GTIN":null,
    		 "Bild":"images/data/AbleX/ProductMedia/at/Mediadata_Archiv/1838/2205/104/104936/jpg/0/.converted_60/converted_60_hyb_0368w.jpg.jpg",
    		 "Beschreibung":"Honeywell Raumthermostat programmierbar\u003cbr /\u003ef.Einzelraum- und Zonenregelung digital",
    		 "Bestand":"images/shared/gruen.gif",
    		 "Mengeneinheit":"Stück","VPE":"50 Stück= Karton",
    		 "Bruttopreis":"160,50 EUR\u003cbr /\u003ePer 1",
    		 "Preiseinheit":null,"Nettopreis":"87,80 EUR\u003cbr /\u003ePer 1",
    		 "Lagertext":"Der Artikel ist im Lager verfügbar. Der Bestand beträgt 42 Stück.",
    		 "Variante":"01","Lieferant":"HOMO01","LfdWeNr":"209","NachkommastellenErlaubt":false,"ProductKey":"01:HOMO01:209"}
    		 ,
    		 
    		 {"InfoImages":"",
    		 "Artikelnummer":"F42010972001|01:HOMO01:996|WerksNr:F42010972001|",
    		 "Werksnummer":null,"GTIN":null,"Bild":"images/shared/empty_image.gif",
    		 "Beschreibung":"Honeywell F42010972 001 ext.Raumfühler\u003cbr /\u003ezu Raumthermosat CMT907A1066",
    		 "Bestand":"images/shared/rot.gif",
    		 "Mengeneinheit":"Stück","VPE":"",
    		 "Bruttopreis":"47,50 EUR\u003cbr /\u003ePer 1",
    		 "Preiseinheit":null,"Nettopreis":"33,25 EUR\u003cbr /\u003ePer 1",
    		 "Lagertext":"Die Ware ist aktuell nicht verfügbar und muss bestellt werden.",
    		 "Variante":"01","Lieferant":"HOMO01","LfdWeNr":"996","NachkommastellenErlaubt":false,"ProductKey":"01:HOMO01:996"}],
    		 "temp":null,"message":""}}*/
    		
    		$d = $jsonResponse["d"];
    		$response = " found ".$d["total"]." produkte <br>";
    		$rows = $d["rows"];
    		$product = array_pop($rows);
    		
    		//gc_id -hf ref
    		$artikelField = $product["Artikelnummer"];
    		$externId = substr($artikelField,strpos($artikelField,"WerksNr:")+strlen("WerksNr:"),-1);
    		$response .= "WerksNr: ".$externId." <br>";
    		
    		//chapo
    		$zusammengefaste_beschreibung = $product["Beschreibung"];
    		$response .= "Kurze beschreibung: ".$zusammengefaste_beschreibung." <br>";
    		
    		//price
    		$preis = 0;
    		$preisField = $product["Bruttopreis"];
    		$preisEnd = strpos($preisField," EUR");
    		if($preisEnd>0)
    			$preis = substr($preisField,0,$preisEnd);
    		$response .= "bruttopreis: ".$preis." <br>";
    		
    		//quantity
    		$quantity = 0;
   			$quantityField = $product["Lagertext"];
   			$quantityStart = strpos($quantityField,"Der Bestand beträgt ")+strlen("Der Bestand beträgt ");
    		if($quantityStart>0)
    			$quantity = substr($quantityField,$quantityStart,strlen($quantityField)-strpos($quantityField," Stück")-strlen(" Stück"));
    		$response .= "Menge: ".$quantity." <br>";
    				
    		//$response+= $firstProduct;
    		//brand
    		//product - ref, category, price, weight, quantity
    		//product description - locale,title,description,short,post
    		//product heizung grade,power,efficiency,warmwater,storage,energy carrier
    		

    		return $response;
    	}
    	
    	return "not a json";
    }

    protected function redirectToConfigurationPage()
    {
        return RedirectResponse::create(URL::getInstance()->absoluteUrl('/admin/module/Carousel'));
    }
    
    public function getLogger()
    {
    	if (self::$logger == null) {
    		self::$logger = Tlog::getNewInstance();
    
    		$logFilePath = THELIA_LOG_DIR . DS . "log-product_scraper.txt";
    
    		self::$logger->setPrefix("#LEVEL: #DATE #HOUR: ");
    		self::$logger->setDestinations("\\Thelia\\Log\\Destination\\TlogDestinationRotatingFile");
    		self::$logger->setConfig("\\Thelia\\Log\\Destination\\TlogDestinationRotatingFile", 0, $logFilePath);
    		self::$logger->setLevel(Tlog::ERROR);
    	}
    	return self::$logger;
    }
}