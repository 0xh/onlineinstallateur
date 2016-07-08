<?php

/*************************************************************************************/
/* This file is part of the Thelia package. */
/* */
/* Copyright (c) OpenStudio */
/* email : dev@thelia.net */
/* web : http://www.thelia.net */
/* */
/* For the full copyright and license information, please view the LICENSE.txt */
/* file that was distributed with this source code. */
/**
 * **********************************************************************************
 */
namespace HookKonfigurator\Loop;

use Propel\Runtime\ActiveQuery\Criteria;
use Thelia\Core\Template\Element\BaseI18nLoop;
use Thelia\Core\Template\Element\LoopResult;
use Thelia\Core\Template\Element\LoopResultRow;
use Thelia\Core\Template\Element\PropelSearchLoopInterface;
use Thelia\Core\Template\Element\SearchLoopInterface;
use Thelia\Core\Template\Loop\Argument\Argument;
use Thelia\Core\Template\Loop\Argument\ArgumentCollection;
use Thelia\Log\Tlog;
use Thelia\Model\ProductQuery;
use HookKonfigurator\Model\HfproductsQuery;
use Thelia\Model\Product;
use Thelia\Model\ProductI18n;
use Thelia\Model\ProductImage;
use Thelia\Model\Brand;
use HookKonfigurator\Model\VendorsQuery;
use HookKonfigurator\Model\Vendors;
use HookKonfigurator\Model\Hfproducts;
use Thelia\Model\BrandI18nQuery;
use Thelia\Model\ProductDocument;
use Thelia\Model\ProductDocumentI18n;
use HookKonfigurator\Model\ProductHeizung as ModelProductHeizung;
use Propel\Runtime\ActiveQuery\Join;
use HookKonfigurator\Model\Map\ProductHeizungTableMap;
use Thelia\Model\Map\ProductTableMap;
use HookKonfigurator\Model\Konfiguratoreinstellung;
use HookKonfigurator\Model\Montage;
use HookKonfigurator\Model\ConstraintsQuery;
use HookKonfigurator\Model\MontageConstraints;
use HookKonfigurator\Model\Constraints;
use HookKonfigurator\Model\Map\ProductHeizungMontageTableMap;
use HookKonfigurator\Model\MontageQuery;
use HookKonfigurator\Model\HeizungkonfiguratorUserdatenQuery;
use Thelia\Model\Map\SaleTableMap;
use Thelia\Model\Map\ProductSaleElementsTableMap;
use Thelia\Model\Map\ProductPriceTableMap;
use Thelia\Model\CurrencyQuery;
use HookKonfigurator\Model\HeizungkonfiguratorUserdaten;
use HookKonfigurator\Model\HeizungkonfiguratorImage;
use Symfony\Component\HttpFoundation\FileBag;
use HookKonfigurator\Model\Customer;

/**
 *
 * ProductHeizung loop
 *
 * Class ProductHeizung
 *
 * @package HookKonfigurator\Loop
 * @author Emanuel Plopu <emanuel.plopu@sepa.at>
 */
class ProductHeizung extends BaseI18nLoop implements PropelSearchLoopInterface, SearchLoopInterface {
	protected $timestampable = true;
	protected $versionable = true;
	
	/**
	 *
	 * @return ArgumentCollection
	 */
	protected function getArgDefinitions() {
		return new ArgumentCollection ( 
				Argument::createFloatTypeArgument ( 'power' ),
				Argument::createIntTypeArgument('currency'));
	}
	public function getSearchIn() {
		return [ 
				"ref",
				"title" 
		];
	}
	
	/**
	 *
	 * @param ProductQuery $search        	
	 * @param
	 *        	$searchTerm
	 * @param
	 *        	$searchIn
	 * @param
	 *        	$searchCriteria
	 */
	public function doSearch(&$search, $searchTerm, $searchIn, $searchCriteria) {
		$search->_and ();
		foreach ( $searchIn as $index => $searchInElement ) {
			if ($index > 0) {
				$search->_or ();
			}
			switch ($searchInElement) {
				case "ref" :
					$search->filterByRef ( $searchTerm, $searchCriteria );
					break;
				case "title" :
					$search->where ( "CASE WHEN NOT ISNULL(`requested_locale_i18n`.ID) THEN `requested_locale_i18n`.`TITLE` ELSE `default_locale_i18n`.`TITLE` END " . $searchCriteria . " ?", $searchTerm, \PDO::PARAM_STR );
					break;
			}
		}
	}
	public function parseResults(LoopResult $loopResult) {
		// $complex = $this->getComplex();
		
		// if (true === $complex) {
		// return $this->parseComplexResults($loopResult);
		// } else {
		// return $loopResult;
		return $this->parseSimpleResults ( $loopResult );
		// }
	}
	public function parseSimpleResults(LoopResult $loopResult) {
		$log = Tlog::getInstance ();
		$log->error ( "loop result number " . count ( $loopResult->getResultDataCollection () ) );
		
		/** @var \Thelia\Core\Security\SecurityContext $securityContext */
		$securityContext = $this->container->get ( 'thelia.securityContext' );

		/** @var \Thelia\Model\Product $product */
		foreach ( $loopResult->getResultDataCollection () as $product ) {
			
			$loopResultRow = new LoopResultRow ( $product );
			
            // Find previous and next product, in the default category.
            $default_category_id = $product->getDefaultCategoryId();

            $loopResultRow
                ->set("PRODUCT_SALE_ELEMENT", $product->getVirtualColumn('pse_id'))
                ->set("PSE_COUNT", $product->getVirtualColumn('pse_count'))
                ->set("QUANTITY", $product->getVirtualColumn('quantity'))
            ;
           //   	$log->debug ( "prod ".$product->getId()." pse count ".$product->getVirtualColumn('pse_count')." quantity ".$product->getVirtualColumn('quantity'));
			$this->addOutputFields ( $loopResultRow, $product );
			
			$loopResult->addRow ( $this->associateValues ( $loopResultRow, $product, $default_category_id ) );
		}
		
		return $loopResult;
	}
	
	/**
	 *
	 * @param LoopResultRow $loopResultRow
	 *        	the current result row
	 * @param \Thelia\Model\Product $product        	
	 * @param
	 *        	$default_category_id
	 * @return mixed
	 */
	private function associateValues($loopResultRow, $product, $default_category_id) {
		$log = Tlog::getInstance ();
		$log->debug ( " innerjoinprod " .$product->getUrl ( $this->locale ) );
		$log->debug ( " URLpath " . implode ( "|", $product->getVirtualColumns () ) );
	//	$montage = MontageQuery::create()->findById($product->getVirtualColumn('montage_id'));
		
		$loopResultRow
		->set ( "ID", $product->getId () )
		->set ( "REF", $product->getRef () )
		->set ( "LOCALE", "de_DE"  )
		->set ( "URL", $product->getUrl ("de_DE" ) )
		->set ( "POSITION", $product->getPosition () )
		->set ( "VIRTUAL", $product->getVirtual () ? "1" : "0" )
		->set ( "VISIBLE", $product->getVisible () ? "1" : "0" )
		->set ( "TEMPLATE", $product->getTemplateId () )
		->set ( "DEFAULT_CATEGORY", $default_category_id )
		->set ( "TAX_RULE_ID", $product->getTaxRuleId () )
		->set ( "BRAND_ID", $product->getBrandId () ?: 0 )
		->set ( "TITLE", $product->getTitle () )// $product->getTitle())
		->set ( "BEST_TAXED_PRICE", $product->getProductSaleElementss () [0]->getProductPrices () [0]->getPrice ()*1.2 )
		//->set ( "CHAPO",  ) // $product->getProductI18ns()[0]->getChapo())
		->set ( "DESCRIPTION", $product->getDescription())
		->set ( "POWER", $product->getVirtualColumn ( 'power' ) )
		->set ( "GRADE", $product->getVirtualColumn ( 'grade' ))
		->set ( "WARMWATER", $product->getVirtualColumn ( 'warm_water' )? "Yes" : "No")
		->set ( "MONTAGE", 250)//$product->getVirtualColumn('montage_id'))
		->set ( "MONTAGETEXT", "asdas")//$montage->__toString())
		;
		
		return $loopResultRow;
	}

	
	public function buildModelCriteria() {
		// $this->import_product_heizung_from_hfproducts();
		//$this->import_montage_from_csv ();
		//debug
        $log = Tlog::getInstance ();
       
        $request = $this->getCurrentRequest();
		
        $currentCustomer = $this->securityContext->getCustomerUser();
        if($currentCustomer == null)
        	$currentCustomer	= 0;//$this->getCurrentRequest()->getSession()->getId();
        	else $currentCustomer = $currentCustomer->getId();
        
        	$log->error(" create userdatenquery ".$currentCustomer);
        	
        $userdata = new HeizungkonfiguratorUserdaten();
        $userdata->setBrennstoffMomentan($request->request->get('konfigurator')['brennstoff_momentan'])
    	->setBrennstoffZukunft($request->request->get('konfigurator')['brennstoff_zukunft'])
    	->setGebaeudeart($request->request->get('konfigurator')['gebaeudeart'])
    	->setPersonenAnzahl($request->request->get('konfigurator')['personen_anzahl'])
    	->setBestehendeGeraetWarmwasser($request->request->get('konfigurator')['bestehendes_geraet_mit_warmwasser'])
    	->setBestehendeGeraetKw($request->request->get('konfigurator')['bestehendes_geraet_kw'])
    	->setBaujahr($request->request->get('konfigurator')['baujahr'])
    	->setGebaeudelage($request->request->get('konfigurator')['lage_des_gebaeudes'])
    	->setWindlage($request->request->get('konfigurator')['windlage_des_gebaudes'])
    	->setAnzahlAussenwaende($request->request->get('konfigurator')['anzahl_aussenwaende'])
    	->setVerglasteFenster($request->request->get('konfigurator')['fenster'])
    	->setWohnraumtemperatur($request->request->get('konfigurator')['wohnraumtemperatur'])
    	->setAussentemperatur($request->request->get('konfigurator')['aussentemperatur'])
    	->setWaermedaemmung($request->request->get('konfigurator')['waermedaemmung'])
    	->setHeizflaeche($request->request->get('konfigurator')['flaeche'])
    	->setAnmerkungen($request->request->get('konfigurator')['anmerkungen'])
    	->setCreatedAt(date ( "Y-m-d H:i:s" ))
    	->setUserId($currentCustomer)
    	->setVersion("1.0")
    	

        ->save();
        
        $log->error(" create userdatenquery ".$userdata);
        //get images
        $files = new FileBag();
        $files = $request->files;
   
        $media_dir = explode("local",dirname(__FILE__));
        $media_dir = $media_dir[0]."local".DIRECTORY_SEPARATOR."media".DIRECTORY_SEPARATOR."images".DIRECTORY_SEPARATOR."heizungskonfiguratorimages";
       
        $image_save_path = $media_dir .DIRECTORY_SEPARATOR;
        
        $log->error(" userdatenquery ".dirname(__FILE__)." ".$image_save_path." ");
        
        $i = 0;
        if($files->get("file")!=NULL)
        foreach ($files->get("file") as $image){
        	if($image != null){
        		$new_image_name = $image->getClientOriginalName();
        		$image->move( $image_save_path ,$new_image_name);
        		
        		$newImage = new HeizungkonfiguratorImage();
        		$newImage->setHeizungkonfiguratorUserdaten($userdata)
        		->setFile($new_image_name)
        		->setVisible(1)
        		->setPosition($i)
        		->setCreatedAt(date ( "Y-m-d H:i:s" ))
        		->setUpdatedAt(date ( "Y-m-d H:i:s" ))
        		->save();
        		$i++;
                $userdata->addHeizungkonfiguratorImage($newImage);
        	}
        		 
        	
        }
        
        $log->error(" create userdatenquery ".$newImage);

		// there has to be some better way to convert request parameters into an entity
		
		$konfigurator = new Konfiguratoreinstellung ();
		$konfigurator->populateKonfiguratorFromRequest ( $request );
		$waermebedarf = $konfigurator->calculateWaermebedarf () / 1000;
		header ( 'waermebedarf:' . $waermebedarf );
		$brennstoff = $konfigurator->getBrennstoffZukunft();
		
		
		//$log = Tlog::getInstance ();
		$log->error(" building modelCriteria for ".ProductHeizungTableMap::TABLE_NAME." ".$this->getCurrentRequest()->attributes->get('category_id'));
		//$this->request->attributes->get('category_id')
		$search = ProductQuery::create ();
		/*
		//product sale element
		$currencyId = $this->getCurrency();
		if (null !== $currencyId) {
			$currency = CurrencyQuery::create()->findOneById($currencyId);
			if (null === $currency) {
				throw new \InvalidArgumentException('Cannot find currency id: `' . $currency . '` in product_sale_elements loop');
			}
		} else {
			$currency = $this->request->getSession()->getCurrency();
		}*/
		
		$search->innerJoinProductSaleElements('pse');
		$search->addJoinCondition('pse', '`pse`.IS_DEFAULT=1');
		
		$search->innerJoinProductSaleElements('pse_count');
		
		$search->withColumn('`pse`.ID', 'pse_id');
		$search->withColumn('`pse`.QUANTITY', 'quantity');
		$search->withColumn('COUNT(`pse_count`.ID)', 'pse_count');
		
		$search->groupBy(ProductTableMap::ID);
		
		// $log->debug("productsuggestionpower ".$waermebedarf." request ".$request->__toString()." waermebedarf ".$waermebedarf);
		
		$heizungJoin = new Join ();
		$heizungJoin->addExplicitCondition ( ProductTableMap::TABLE_NAME, 'ID', null, ProductHeizungTableMap::TABLE_NAME, 'PRODUCT_ID', 'hz' );
		$heizungJoin->setJoinType ( Criteria::LEFT_JOIN );

		$search
		->addJoinObject ( $heizungJoin, 'HeizungProduct' )
		->withColumn ( '`hz`.grade', 'grade' )
		->withColumn ( '`hz`.power', 'power' )
		->withColumn ( '`hz`.energy_efficiency', 'energy_efficiency' )
		->withColumn ( '`hz`.priority', 'priority' )
		->withColumn ( '`hz`.warm_water', 'warm_water' )
		->withColumn ( '`hz`.energy_carrier', 'energy_carrier' )
		->withColumn ( '`hz`.storage_capacity', 'storage_capacity' )
		->condition  ( 'same_product_id', 'product.id = `hz`.product_id' )
		->setJoinCondition ( 'HeizungProduct', 'same_product_id' )
		->condition ( 'power_larger_then', 'power >= ?', $waermebedarf - 1, \PDO::PARAM_INT )
		->condition ( 'power_smaller_then', 'power <= ?', $waermebedarf + 4, \PDO::PARAM_INT );
		
		$brennstoff_name = "";


		/*TODO filter based on energycarrier*/
        

		if($brennstoff == 5)
			$search
			->condition('brennstoff_zukunft', 'energy_carrier > ?',$brennstoff-1,\PDO::PARAM_INT)
			->where ( array ('power_larger_then','power_smaller_then','brennstoff_zukunft' ), Criteria::LOGICAL_AND ); // power_condition
		else 
			$search
            ->condition('brennstoff_zukunft', 'energy_carrier = ?',$brennstoff,\PDO::PARAM_INT)
			->where ( array ('power_larger_then','power_smaller_then','brennstoff_zukunft' ), Criteria::LOGICAL_AND );			

		//if ($visible !== Type\BooleanOrBothType::ANY) {
			$search->filterByVisible(1);
		//}
/*
		$servicesJoin = new Join();
		$servicesJoin->addExplicitCondition ( ProductTableMap::TABLE_NAME, 'ID', null, ProductHeizungMontageTableMap::TABLE_NAME, 'PRODUCT_HEIZUNG_ID', 'hzm' );
		$servicesJoin->setJoinType ( Criteria::LEFT_JOIN );
		
		$search
		->addJoinObject ( $servicesJoin, 'HeizungProductMontage' )
		->withColumn ( '`hzm`.montage_id', 'montage_id' )
		->condition ( 'same_heizung_id', 'product.id = `hzm`.product_heizung_id' )
		->setJoinCondition ( 'HeizungProductMontage', 'same_heizung_id' );
		*/
			
		/*
		$priceJoin = new Join();
		$priceJoin->addExplicitCondition(ProductSaleElementsTableMap::TABLE_NAME, 'ID', 'pse', ProductPriceTableMap::TABLE_NAME, 'PRODUCT_SALE_ELEMENTS_ID', 'price');
		$priceJoin->setJoinType(Criteria::LEFT_JOIN);
		
		$search->addJoinObject($priceJoin, 'price_join')
		->addJoinCondition('price_join', '`price`.`currency_id` = ?', $currency->getId(), null, \PDO::PARAM_INT);
		*/
		
		return $search;
	}
}
