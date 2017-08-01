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

class ProductFeature extends AbstractImport{
	protected $mandatoryColumns = [
			'id',
			'product_id',
			'feature_id',
			'feature_av_id',
			'free_text_value' // 1 = true , Null = false
	];
	public function importData(array $data)
	{
		/** @var EventDispatcherInterface $eventDispatcher */
		$eventDispatcher = $this->getContainer()->get('event_dispatcher');
		
		
		$Wert = $data['feature_av_id'];
		$ProductQuery = ProductQuery::create();
	    $Product = $ProductQuery->findOneById($data['product_id']);
	    if ($Product !== null)
	    {
	    	Tlog::getInstance()->info("ProdID".$data['product_id']);
	    	Tlog::getInstance()->info("FeatID".$data['feature_id']);
	    	Tlog::getInstance()->info("FeatAVID".$data['feature_av_id']);
	    	
	    	$productfeatureupdate = new FeatureProductUpdateEvent($data['product_id'],$data['feature_id'],$data['feature_av_id'],false);
	    	Tlog::getInstance()->info("new event vcreated");
	    	
	    	if ($data['free_text_value']==1){
	    	
	    		$productfeatureupdate -> setIsTextValue(true);
	    		$productfeatureupdate -> setLocale("de_DE");
	    	
	    	}
	    	else{

	    		Tlog::getInstance()->info("False"."saved");
	    		
	    	}
	    	$eventDispatcher->dispatch(TheliaEvents::PRODUCT_FEATURE_UPDATE_VALUE, $productfeatureupdate);
	    }
	    	
	}
		
		//Tlog::getInstance()->error("attributeimport ".$newFeature->__toString());
	
}