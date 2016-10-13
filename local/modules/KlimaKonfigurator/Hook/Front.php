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

class Front extends BaseHook{

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
		// foreach raum KB build a querry
		//$this->getRequest()
		header ( 'klimabedarftotal:' . $klimabedarftotal/1000 );
		
		$log = Tlog::getInstance ();

		$klima_ergebnisse = "";
		
		$raum_nr = 1;
		foreach($klimaBedarfRooms as $klimaBedarf){
			//$candidates = ProductQuery::create();
			$candidatesQuery = $this->getInnenGeraetFuerKlimaBedarf($klimaBedarf);
			$candidates = $candidatesQuery->find();
			$log->debug(" klimabedarf für ".$raum_nr." ".$klimaBedarf);
			
			$found_candidate = null;
			foreach($candidates as $candidate){
				
				
				if($found_candidate == null)
					$found_candidate = $candidate;
			}
			
			$log->debug(" candidate für ".$raum_nr." product id ".$found_candidate->getId());
			//$found_candidate = new Product();
			if($found_candidate != null)
				$klima_ergebnisse .= $this->render('klima_product-suggestion.html',
						array('SET_ID' => $found_candidate->getId(),
						      'ROOMLABEL' => 'RAUM '.$raum_nr.' '.$klimaBedarf,
							  'WIDTH' => '300',
							  'HEIGHT' => '230',
								'hasQuickView' => 'false'
				));
			$raum_nr += 1;
			$found_candidate = null;
		};
		
		//$event->add($klima_ergebnisse);
		$content = $this->render('klimakonfigurator-suggestion-multiroom.html',array('KLIMA_ERGEBNISSE' => $klima_ergebnisse));
		$event->add($content);
		/*
		$content = $this->render('klimakonfigurator-suggestions.html');
		$event->add($content);*/
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
		
		return $search;
	}

    public function onMainNavbarPrimary(HookRenderEvent $event)
    {
    	$content = $this->render('main-navbar-primary.html');
    	$event->add($content);
    }
}