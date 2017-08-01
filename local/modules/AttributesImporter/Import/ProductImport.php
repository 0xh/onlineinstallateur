<?php
namespace AttributesImporter\Import;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Thelia\Core\Event\TheliaEvents;
use Thelia\Core\Event\UpdateSeoEvent;
use Thelia\ImportExport\Import\AbstractImport;
use Thelia\Model\ProductQuery;
use Thelia\Core\Translation\Translator;
use Thelia\Core\Event\FeatureProduct\FeatureProductEvent;
use Thelia\Core\Event\FeatureProduct\FeatureProductUpdateEvent;
use Thelia\Model\FeatureQuery;
use Thelia\Model\Feature;
use Thelia\Model\FeatureProduct;
use Thelia\Core\Event\Feature\FeatureUpdateEvent;
use Thelia\Log\Tlog;
use Thelia\Model\FeatureProductQuery;
use Thelia\Model\Product;
use Thelia\Core\Event\Product\ProductUpdateEvent;
use Thelia\Core\Event\Feature\FeatureAvUpdateEvent;
use Thelia\Core\Event\Product\ProductCreateEvent;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Count;
use Thelia\Model\FeatureI18nQuery;
use Thelia\Core\Event\Feature\FeatureCreateEvent;
use Thelia\Model\FeatureAvQuery;
use Thelia\Model\FeatureAvI18nQuery;
use Thelia\Model\FeatureAvI18n;
use Doctrine\Common\Collections\Criteria;
use Thelia\Model\Map\FeatureAvTableMap;
use Thelia\Core\Event\Feature\FeatureAvCreateEvent;
use Assetic\Exception\Exception;
use Thelia\Model\Map\FeatureProductTableMap;
use Thelia\Action\FeatureAv;
use Thelia\Action\ProductSaleElement;
use Thelia\Model\ProductSaleElementsQuery;
use Thelia\Model\FeatureI18n;
use Thelia\Core\Event\ProductSaleElement\ProductSaleElementEvent;

class ProductImport extends AbstractImport{
	protected $mandatoryColumns = [
			'materialnummer',
			'EAN',
			'Brand',
			'farbe',
			'size basin',//Waschbeckengröße
			'number of shower sprays',
			'number of holes',
			'size cartridge',//Größe Kartusche
			'flow rate limitation at 3 bar',//Durchflussmenge limitiert auf 3 Bar
			'material',
			'shower hose length',//Länge Duschschlauch
			'temperature limiter', //Temperaturlimit
			'outside diameter shower',//Dusche Außendurchmesser
			'projection',//Auslauf
			'battery typ dangerous goods', //Batterie art, Gefahrengüter
			'material of handle',//
			'kind of spout',//Art des Wasserstrahls
			'waste- and overflow technic'//
	];
	public function importData(array $data)
	{
		$errors  = null;
		
		//Tlog::getInstance()->info("START");
		//--------------------VARIABLEN--------------------
		$artikelnr = $data['materialnummer'];
		$EAN_code = $data['EAN'];
		$brand = $data['Brand'];
		//--------------------END VARIABLEN ---------------
		$product_features = array_slice($data,3,count($data)-1);

		/** @var EventDispatcherInterface $eventDispatcher */
		$eventDispatcher = $this->getContainer()->get('event_dispatcher');
		$sub = substr($brand,0,3);
		$connect = $sub.$artikelnr;
		//SEARCH EAN
		$product_sale_query = new ProductSaleElementsQuery();
		$find_ean = $product_sale_query->findOneByEanCode($EAN_code);
		//SEARCH REF
		$product_sale_query2 = new ProductSaleElementsQuery();
		$find_ref = $product_sale_query2->findOneByRef($connect);
		
		if ($find_ean == null)//EAN gibts nicht
		{
			if ($find_ref != null){//GIBS REF dann ean zu REF
				$find_ref->setEanCode($EAN_code);
				$errors .= "EAN ".$EAN_code." zu ProductREF: ".$find_ref->getRef()." hinzugefügt";
				$find_ref->save();
			}
			else{//GIBTS BEIDES NICHT DANN EXISTIERT DAS PRODUCT NICHT (neu erstellen könnte hier sein)!
				$errors .= "Produkt mit EAN ".$EAN_code." existiert noch nicht im System";
			}
			
		}
		if ($find_ean != null)//UPDATEN
		{
			$product_id= $find_ean->getProductId();
			foreach ($product_features as $key => $value)
			{
				
				if ($value!=""){//Wenn das Feld leer ist muss kein Feature zum Product geadded werden
					$feature_i18n_query= FeatureI18nQuery::create();
					$get_feature = $feature_i18n_query->findOneByTitle($key);
					if($get_feature==null){//Feature gibt es noch nicht -> Createn --------------------------------------
						
						$new_feature = new Feature();
						$new_feature->setLocale("de_DE");
						$new_feature->setTitle($key);
						$new_feature->save();
						
						$feature_update_event = new FeatureProductUpdateEvent($product_id, $new_feature->getId(), $value,true); //PRoduct ID <<<<<<<<<<<<<<<<<<
						$feature_update_event
							//->setFeatureValue($value)
							->setLocale("de_DE");
						$eventDispatcher->dispatch(TheliaEvents::PRODUCT_FEATURE_UPDATE_VALUE, $feature_update_event);
					}
					if($get_feature!=null){//Feature gibt es dann updaten
						$feature_id = $get_feature->getId();
						$feature_product_query = FeatureProductQuery::create();
						$is_free_text = $feature_product_query
							->filterByFeatureId($feature_id,\Propel\Runtime\ActiveQuery\Criteria::EQUAL)
							->where(FeatureProductTableMap::FREE_TEXT_VALUE.\Propel\Runtime\ActiveQuery\Criteria::ISNOTNULL)
						->find();
						
						if (count($is_free_text)<=1)//IST FREETEXT
						{
							$feature_update_event_free_text = new FeatureProductUpdateEvent($product_id, $feature_id, $value,true);
							$feature_update_event_free_text
								->setLocale("de_DE");
							//->setFeatureValue($value);
							$eventDispatcher->dispatch(TheliaEvents::PRODUCT_FEATURE_UPDATE_VALUE,$feature_update_event_free_text);
						}
						if(count($is_free_text)>1){//IST KEIN FREETEXT
							// GIBT ES DEN FEATURE WERT (feature_av)?
							$feature_av_query = FeatureAvQuery::create();
							$feature_av_query	
								->useFeatureQuery()
									->useFeatureI18nQuery()
										->filterByTitle($key,\Propel\Runtime\ActiveQuery\Criteria::EQUAL)
										->filterByLocale("de_DE",\Propel\Runtime\ActiveQuery\Criteria::EQUAL)
									->endUse()
								->endUse();
							
							$ergebnis =$feature_av_query	
								->useFeatureAvI18nQuery()
									->filterByTitle($value,\Propel\Runtime\ActiveQuery\Criteria::EQUAL)
									->filterByLocale("de_DE",\Propel\Runtime\ActiveQuery\Criteria::EQUAL) //filtern nach Sprache (eigentlich egal da selbe id aber mehr ergebnisse als gewünscht)
								->endUse()
							-> find();
							if ($ergebnis != "  " || $ergebnis != null) //Feature AV gibt es
							{
								$feature_av_id = 1;
								/** @var Feature $featureav */
								foreach($ergebnis as $featureav){
									Tlog::getInstance()->info("F1_FOREACH");
									$feature_av_id = $featureav->getId();
									break;
								}
								$update_product_feature = new FeatureProductUpdateEvent($product_id, $feature_id, $feature_av_id,false); //Product ID<<<<<<<<<<<<<
								$update_product_feature->setLocale("de_DE");
								$eventDispatcher->dispatch(TheliaEvents::PRODUCT_FEATURE_UPDATE_VALUE, $update_product_feature);
							}
							
							if ($ergebnis == "  " || $ergebnis == null)//feature av gibt es NICHT
							{
								$av_create_event = new FeatureAvCreateEvent();
								$av_create_event
									->setLocale("de_DE")
									->setFeatureId($feature_id)
									->setTitle($value)
								;
								$eventDispatcher->dispatch(TheliaEvents::FEATURE_AV_CREATE, $av_create_event);
							}
							
						}
					}
				}
			}
		}
		//$errors .= "Es wurden ".$counter." Features erstellt";
		return $errors;
	}
	
}