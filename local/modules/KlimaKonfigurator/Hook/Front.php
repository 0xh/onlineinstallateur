<?php

namespace KlimaKonfigurator\Hook;

use Thelia\Core\Event\Hook\HookRenderEvent;
use Thelia\Core\Hook\BaseHook;
use KlimaKonfigurator\Model\KlimaKonfiguratorEinstellungen;
use Thelia\Model\ProductQuery;
use Thelia\Model\Map\ProductTableMap;
use Propel\Runtime\ActiveQuery\Join;
use HookKonfigurator\Model\Map\SetsTableMap;
use Propel\Runtime\ActiveQuery\Criteria;
use Thelia\Model\Map\ProductCategoryTableMap;
use Thelia\Log\Tlog;
use Thelia\Model\Product;
use HookKonfigurator\Model\Sets;
use HookKonfigurator\Model\SetsQuery;

class Front extends BaseHook{
	private $maxPowerDevice = null;

    public function onMainHeadBottom(HookRenderEvent $event)
    {
        $content = $this->addCSS('assets/css/styles.css');
        $event->add($content);
	}
	
	public function onKlimaKonfiguratorSuggestions(HookRenderEvent $event)
	{
		// pass form data to einstellungen
		$klimaKonfiguratorEinstellungen = new KlimaKonfiguratorEinstellungen();
		$klimaKonfiguratorEinstellungen->populateKonfiguratorFromRequest($this->getRequest());
		
		$klimabedarftotal = $klimaKonfiguratorEinstellungen->calculateKlimaBedarfMultipleRooms();
		$klimaBedarfRooms = $klimaKonfiguratorEinstellungen->getKlimabedarfRaum();
		$raumAnzahl = count($klimaBedarfRooms);
		// foreach raum KB build a querry
		//$this->getRequest()
		header ( 'klimabedarftotal:' . $klimabedarftotal/1000 );
		
		$log = Tlog::getInstance ();

		

		
		//aussengerät für den gesamte klimabedarf
		
		$candidatesQuery = $this->getAussenGeraetFuerKlimaBedarf($klimabedarftotal, $raumAnzahl);
		$candidates = $candidatesQuery->find();
		
		foreach($candidates as $candidate){
			$klima_ergebnisse = "";
			$products_cost = 0;
			$service_quantity = 0;
			$innengeraet_id = null;
				
			//aussengerät
			$ergebniss = $this->render('klima_product-suggestion.html',
					array('SET_ID' => $candidate->getId(),
							'ROOMNUMBER' => 'Außen',
							'WIDTH' => '300',
							'HEIGHT' => '230',
							'hasQuickView' => 'false',
							'PRODUCT_QUANTITY' => 1,
					));
			$log->debug(" aussen klimabedarf candidate ".$ergebniss);
			
			$klima_ergebnisse .= $ergebniss;
			$service_quantity +=1;
			//$found_candidate = new Product();
			$products_cost += 1*ProductQuery::create()->findOneById($candidate->getId())->getProductSaleElementss()[0]->getProductPrices()[0]->getPrice();
			$log->debug("aussen candidate für  product id ".$candidate->getId()." serviceq ".$service_quantity);
		
			//$candidate = new Product();
			//innengerät
			$innengeraet_id = $candidate->getVirtualColumn('composed_image');
			$ergebniss = $this->render('klima_product-suggestion.html',
					array('SET_ID' => $innengeraet_id,
							'ROOMNUMBER' => 'Innen',
							'WIDTH' => '300',
							'HEIGHT' => '230',
							'hasQuickView' => 'false',
							'PRODUCT_QUANTITY' => $raumAnzahl,
					));
			$log->debug("innen klimabedarf candidate ".$innengeraet_id." rooms ".$raumAnzahl);
			$klima_ergebnisse .= $ergebniss;
			$service_quantity +=$raumAnzahl;
			//$found_candidate = new Product();
			$products_cost += $raumAnzahl*ProductQuery::create()->findOneById($innengeraet_id)->getProductSaleElementss()[0]->getProductPrices()[0]->getPrice();
			$log->debug("innen candidate für  product id ".$innengeraet_id." serviceq ".$service_quantity);
			
			
			
			//generate html response
			$content = $this->render('klimakonfigurator-suggestion-multiroom.html',
					array('KLIMA_ERGEBNISSE' => $klima_ergebnisse,
							'SERVICE' => "2311",
							'SERVICE_QUANTITY' => $service_quantity,
							'SERVICEMATERIAL' => "3452",
							'PRODUCTS_COST' => $products_cost,
							'ROOMNUMBER' => 1,
					));
			$event->add($content);
		}
		
		/*
		$raum_nr = 1;
		foreach($klimaBedarfRooms as $klimaBedarf){
			// find devices with klimabedarf larger than necessary
			$candidatesQuery = $this->getInnenGeraetFuerKlimaBedarf($klimaBedarf);
			$candidates = $candidatesQuery->find();
			$log->debug(" klimabedarf für ".$raum_nr." ".$klimaBedarf);
			
			$found_candidate = null;
			$device_quantity = 1;
			//TODO choose one device
			foreach($candidates as $candidate){
				
				
				if($found_candidate == null)
					$found_candidate = $candidate;
			}
			
			
			// if no one device is enough find largest and multiply until klimabedarf is covered
			if($found_candidate == null)
			if($this->maxPowerDevice == null){
				$maxQuery = SetsQuery::create()->withColumn('MAX(power)')->find();
				$maxValue = 0;
				if($maxQuery != null)
					$maxValue = $maxQuery[0]->getVirtualColumn('MAXpower');
				if($maxValue != 0){
					$this->maxPowerDevice = $this->getInnenGeraetFuerKlimaBedarf($maxValue)->find()[0];
					$found_candidate = $this->maxPowerDevice;
					$device_quantity = ceil($klimaBedarf/$maxValue);
				}
			}
			else 
			{
				$found_candidate = $this->maxPowerDevice;
				$device_quantity = ceil($klimaBedarf/$this->maxPowerDevice->getPower());
			}
			
			if($found_candidate != null){
				$log->debug(" klimabedarf candidate ".$found_candidate->getId()." ".$device_quantity);
				$klima_ergebnisse .= $this->render('klima_product-suggestion.html',
						array('SET_ID' => $found_candidate->getId(),
						      'ROOMNUMBER' => $raum_nr,
							  'WIDTH' => '300',
							  'HEIGHT' => '230',
							  'hasQuickView' => 'false',
							  'PRODUCT_QUANTITY' => $device_quantity,
				));
				$log->debug(" klimabedarf candidate ".$klima_ergebnisse);
				$service_quantity += $device_quantity;
				//$found_candidate = new Product();
				$products_cost += $device_quantity*ProductQuery::create()->findOneById($found_candidate->getId())->getProductSaleElementss()[0]->getProductPrices()[0]->getPrice();
				$log->debug(" candidate für ".$raum_nr." product id ".$found_candidate->getId()." serviceq ".$service_quantity);
			}
			
			$raum_nr += 1;
			$found_candidate = null;
		};
		
		//$event->add($klima_ergebnisse);
		$content = $this->render('klimakonfigurator-suggestion-multiroom.html',
				array('KLIMA_ERGEBNISSE' => $klima_ergebnisse,
					  'SERVICE' => "2311",
					  'SERVICE_QUANTITY' => $service_quantity,
					  'SERVICEMATERIAL' => "3452",
					  'PRODUCTS_COST' => $products_cost,
					  'ROOMNUMBER' => $raum_nr,
				));
		$event->add($content);
		*/
		/*
		$content = $this->render('klimakonfigurator-suggestions.html');
		$event->add($content);*/
	}
	
	
	private function getAussenGeraetFuerKlimaBedarf($klimabedarf,$raumAnzahl){
	
		$set_category = 25;//$this->getCategory();
	
		$search = ProductQuery::create();
	
		//join pse
		$search->innerJoinProductSaleElements('pse');
		$search->addJoinCondition('pse', '`pse`.IS_DEFAULT=1');
	
		$search->innerJoinProductSaleElements('pse_count');
	
		$search->withColumn('`pse`.ID', 'pse_id');
		$search->withColumn('`pse`.QUANTITY', 'quantity');
		$search->withColumn('COUNT(`pse_count`.ID)', 'pse_count');
	
		$search->groupBy(ProductTableMap::ID);
	
		//join with sets
		$setsJoin = new Join ();
		$setsJoin->addExplicitCondition ( ProductTableMap::TABLE_NAME, 'ID', null, SetsTableMap::TABLE_NAME, 'PRODUCT_ID', 's' );
		$setsJoin->setJoinType ( Criteria::LEFT_JOIN );
	
		$search
		->addJoinObject ( $setsJoin, 'SetsJoin' )
		->withColumn ( '`s`.product_id', 'set_id' )
		->withColumn ( '`s`.priority', 'priority' )
		->withColumn ( '`s`.efficiency', 'efficiency' )
		->withColumn ( '`s`.power', 'power' )
		->withColumn ( '`s`.composed_image', 'composed_image' )
		->withColumn ( '`s`.storage', 'storage' )
		->condition ( 'prod_set_id', 'product.id = `s`.product_id' )
		->setJoinCondition ( 'SetsJoin', 'prod_set_id' );
	
		//join with categories
		$categoryJoin = new Join ();
		$categoryJoin->addExplicitCondition ( ProductTableMap::TABLE_NAME, 'ID', null, ProductCategoryTableMap::TABLE_NAME, 'PRODUCT_ID', 'pc' );
		$categoryJoin->setJoinType ( Criteria::LEFT_JOIN );
	
		$search
		->addJoinObject ( $categoryJoin, 'ProductCategory' )
		->withColumn ( '`pc`.category_id', 'category_id' )
		->condition ( 'prod_cat_id', 'product.id = `pc`.product_id' )
		->setJoinCondition ( 'ProductCategory', 'prod_cat_id' );
	
		$search
		->condition ( 'power_larger_then', 'power >= ?', $klimabedarf, \PDO::PARAM_INT )
		->condition ( 'number_of_rooms', 'storage >= ?',$raumAnzahl, \PDO::PARAM_INT)
		->where ( array ('power_larger_then','number_of_rooms' ), Criteria::LOGICAL_AND );
		//->orderBy('priority',Criteria::DESC);
	
		return $search;
	}
	
	private function getInnenGeraetFuerKlimaBedarf($klimabedarf){
		
		$set_category = 25;//$this->getCategory();

		$search = ProductQuery::create();
		
		//join pse
		$search->innerJoinProductSaleElements('pse');
		$search->addJoinCondition('pse', '`pse`.IS_DEFAULT=1');
		
		$search->innerJoinProductSaleElements('pse_count');
		
		$search->withColumn('`pse`.ID', 'pse_id');
		$search->withColumn('`pse`.QUANTITY', 'quantity');
		$search->withColumn('COUNT(`pse_count`.ID)', 'pse_count');
		
		$search->groupBy(ProductTableMap::ID);
		
		//join with sets
		$setsJoin = new Join ();
		$setsJoin->addExplicitCondition ( ProductTableMap::TABLE_NAME, 'ID', null, SetsTableMap::TABLE_NAME, 'PRODUCT_ID', 's' );
		$setsJoin->setJoinType ( Criteria::LEFT_JOIN );
		
		$search
		->addJoinObject ( $setsJoin, 'SetsJoin' )
		->withColumn ( '`s`.product_id', 'set_id' )
		->withColumn ( '`s`.priority', 'priority' )
		->withColumn ( '`s`.efficiency', 'efficiency' )
		->withColumn ( '`s`.power', 'power' )
		->withColumn ( '`s`.composed_image', 'composed_image' )
		->withColumn ( '`s`.storage', 'storage' )
		->condition ( 'prod_set_id', 'product.id = `s`.product_id' )
		->setJoinCondition ( 'SetsJoin', 'prod_set_id' );
		
		//join with categories
		$categoryJoin = new Join ();
		$categoryJoin->addExplicitCondition ( ProductTableMap::TABLE_NAME, 'ID', null, ProductCategoryTableMap::TABLE_NAME, 'PRODUCT_ID', 'pc' );
		$categoryJoin->setJoinType ( Criteria::LEFT_JOIN );
		
		$search
		->addJoinObject ( $categoryJoin, 'ProductCategory' )
		->withColumn ( '`pc`.category_id', 'category_id' )
		->condition ( 'prod_cat_id', 'product.id = `pc`.product_id' )
		->setJoinCondition ( 'ProductCategory', 'prod_cat_id' );
		
		$search
		->condition ( 'power_larger_then', 'power >= ?', $klimabedarf, \PDO::PARAM_INT )
		->where ( array ('power_larger_then' ), Criteria::LOGICAL_AND );
		//->orderBy('priority',Criteria::DESC);
		
		return $search;
	}

    public function onMainNavbarPrimary(HookRenderEvent $event)
    {
    	$content = $this->render('main-navbar-primary.html');
    	$event->add($content);
    }
}