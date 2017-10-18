<?php
namespace GeneralImportExport\Import;
use Thelia\Core\Event\TheliaEvents;
use Thelia\Core\Event\Feature\FeatureAvCreateEvent;
use Thelia\Core\Event\FeatureProduct\FeatureProductUpdateEvent;
use Thelia\ImportExport\Import\AbstractImport;
use Thelia\Log\Tlog;
use Thelia\Model\Feature;
use Thelia\Model\FeatureAvI18nQuery;
use Thelia\Model\FeatureAvQuery;
use Thelia\Model\FeatureI18nQuery;
use Thelia\Model\FeatureProductQuery;
use Thelia\Model\FeatureQuery;
use Thelia\Model\ProductSaleElementsQuery;
use Thelia\Model\TemplateQuery;
use Thelia\Model\Map\FeatureProductTableMap;
use Thelia\Model\ProductQuery;

class ProductImport extends AbstractImport{
	protected $mandatoryColumns = [
			'materialnummer',
			'EAN',
			'Brand',
			'Template'
	];
	public function importData(array $data)
	{
		$errors  = null;
		
		//Tlog::getInstance()->info("START");
		//--------------------VARIABLEN--------------------
		$artikelnr = $data['materialnummer'];
		$EAN_code = $data['EAN'];
		$brand = $data['Brand'];
		$template = $data['Template'];
		if(isset($data['Reference']) && $data['Reference']) {
			$productRef = $data['Reference']; 
		}
		else {
			$sub = substr($brand,0,3);
			$productRef = $sub.$artikelnr;
		}
		//--------------------END VARIABLEN ---------------
		$product_features = array_slice($data,4,count($data)-1);

		/** @var EventDispatcherInterface $eventDispatcher */
		$eventDispatcher = $this->getContainer()->get('event_dispatcher');
		
		//SEARCH EAN
		$product_sale_query = new ProductSaleElementsQuery();
		$find_ean = $product_sale_query->findOneByEanCode($EAN_code);
		//SEARCH REF
		$product_sale_query2 = new ProductSaleElementsQuery();
		$find_ref = $product_sale_query2->findOneByRef($productRef);
		
		if ($EAN_code == null || $EAN_code == 'NULL' || $EAN_code == '')//EAN gibts nicht
		{
			Tlog::getInstance()->info("EAN is null");
			if ($find_ref != null){
				//$find_ref->setEanCode($EAN_code);
				//$errors .= "EAN ".$EAN_code." zu ProductREF: ".$find_ref->getRef()." hinzugefügt";
				//$find_ref->save();
				
				$product_id= $find_ref->getProductId();
				$this->import($product_features, $product_id, $template, $eventDispatcher);
			}
			else{//GIBTS BEIDES NICHT DANN EXISTIERT DAS PRODUCT NICHT (neu erstellen könnte hier sein)!
				$errors .= "Produkt mit EAN ".$EAN_code." existiert noch nicht im System";
			}
			
		}
		else if ($find_ean != null)//UPDATEN 
		{
			$product_id= $find_ean->getProductId();
			
			Tlog::getInstance()->info("EAN is !null");
			
			$this->import($product_features, $product_id, $template, $eventDispatcher);
	
		}
		//$errors .= "Es wurden ".$counter." Features erstellt";
		return $errors;
	}
	
	public function import($product_features, $product_id, $template, $eventDispatcher) 
	{
		Tlog::getInstance()->info("product id".$product_id);
		
		// update template id in product table
		$product = ProductQuery::create()
			->filterById($product_id)
			->findOne();
		
		if(!$product->getTemplateId()) {
			if(!$template)
				$template = 1;
			
			$product->setTemplateId($template)
				->save();
		}
		
		foreach ($product_features as $key => $value)
		{
			
			if ($value!=null){//Wenn das Feld leer ist muss kein Feature zum Product geadded werden
				$feature_i18n_query= FeatureI18nQuery::create();
				$get_feature = $feature_i18n_query->findOneByTitle($key);
				if($get_feature==null){//Feature gibt es noch nicht -> Createn --------------------------------------
					//---Set Template
					$feature_template_query = TemplateQuery::create();
					$found = $feature_template_query->findOneById($template);
					$new_feature = new Feature();
					$new_feature->setLocale("de_DE");
					$new_feature->setTitle($key);
					$new_feature->addTemplate($found);
					$new_feature->save();
					//---Set Template
					Tlog::getInstance()->info("SAVED K:".$key." V:".$value);
					$feature_update_event = new FeatureProductUpdateEvent($product_id, $new_feature->getId(), $value,true); //PRoduct ID <<<<<<<<<<<<<<<<<<
					$feature_update_event
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
					Tlog::getInstance()->info("count is free text ".count($is_free_text));
					
					if (count($is_free_text)<=1){	
						//IST FREETEXT
						Tlog::getInstance()->info("count is free text <=1");
						//---Set Template
						$featurequery = new FeatureQuery();
						$get = $featurequery->findOneById($feature_id);
						$feature_template_query = TemplateQuery::create();
						$found = $feature_template_query->findOneById($template);
						$get ->addTemplate($found);
						//---Set Template
						$feature_update_event_free_text = new FeatureProductUpdateEvent($product_id, $feature_id, $value,true);
						$feature_update_event_free_text
						->setLocale("de_DE");
						//->setFeatureValue($value);
						$eventDispatcher->dispatch(TheliaEvents::PRODUCT_FEATURE_UPDATE_VALUE,$feature_update_event_free_text);
						Tlog::getInstance()->info("SAAVED K:".$key." V:".$value);
					}
					
					if(count($is_free_text)>1) {
						//IST KEIN FREETEXT
						Tlog::getInstance()->info("count is free text >1");
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
						
						Tlog::getInstance()->info("H1 Getav".$ergebnis);
						
						if ($ergebnis == "{  }")//feature av gibt es NICHT
						{
							$av_create_event = new FeatureAvCreateEvent();
							$av_create_event
							->setLocale("de_DE")
							->setFeatureId($feature_id)
							->setTitle($value)
							;
							$eventDispatcher->dispatch(TheliaEvents::FEATURE_AV_CREATE, $av_create_event);
							
							$f18q = new FeatureAvI18nQuery();
							$find_one = $f18q->findOneByTitle($value);
							Tlog::getInstance()->info("H1 Getav".$find_one->getId()." ".$value."".$feature_id);
							
							$update_product_feature = new FeatureProductUpdateEvent($product_id, $feature_id,$find_one->getId() ,false); //Product ID<<<<<<<<<<<<<
							$update_product_feature->setLocale("de_DE");
							$eventDispatcher->dispatch(TheliaEvents::PRODUCT_FEATURE_UPDATE_VALUE, $update_product_feature);
						}
						else //Feature AV gibt es
						{
							Tlog::getInstance()->info("H1 Ergebnis: ".$ergebnis);
							$feature_av_id=1;
							/** @var Feature $featureav */
							foreach($ergebnis as $featureav){
								$feature_av_id = $featureav->getId();
								
								Tlog::getInstance()->info("H1 id".$feature_av_id);
								break;
							}
							//---Set Template
							$featurequery = new FeatureQuery();
							$get = $featurequery->findOneById($feature_id);
							$feature_template_query = TemplateQuery::create();
							$found = $feature_template_query->findOneById($template);
							$get ->addTemplate($found);
							//---Set Template
							Tlog::getInstance()->info("H1 KEINFREE K:".$key. " V:". $value." Fid:".$feature_id."AVid:".$feature_av_id);
							$update_product_feature = new FeatureProductUpdateEvent($product_id, $feature_id, $feature_av_id,false); //Product ID<<<<<<<<<<<<<
							$update_product_feature->setLocale("de_DE");
							$eventDispatcher->dispatch(TheliaEvents::PRODUCT_FEATURE_UPDATE_VALUE, $update_product_feature);
						}
					}
				}
			}
		}
		
	}
	
}