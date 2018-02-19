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
use Thelia\ImportExport\Import\AbstractImport;
use HookScraper\Controller\HookScraperController;
use Thelia\Model\ProductPriceQuery;
use Thelia\Model\ProductPrice;

/**
 * Class UpdateProducts
 * @package HookKonfigurator\Import
 * @author Emanuel Plopu <emanuel.plopu@sepa.at>
 */
class UpdateProducts extends AbstractImport
{
	public $scraper,$productQuerry,$priceQuerry,$productSaleElementQuerry;
	
	
	protected $mandatoryColumns = [
			'extern_id'
	];
	
	public function importData(array $data)
	{
		$errors = null;
		if($this->scraper == null)
		{
			$this->scraper = new HookScraperController();
			$this->scraper->init();
			$this->scraper->login(1);
			$this->productQuerry = ProductQuery::create();
			$this->priceQuerry = ProductPriceQuery::create();
			$this->productSaleElementQuerry = ProductSaleElementsQuery::create();
		}
		
		$responsePage =$this->scraper->getResults($data["extern_id"]);

		
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
			
    		$product_id = $this->productQuerry->findOneByExternId($data["extern_id"]);
    		$product_sale = "";
    		if($product_id != null){
    			$product_sale = $this->productSaleElementQuerry->findOneByProductId($product_id->getId());
    				if($product_sale != null){
    					$product_price = $this->priceQuerry->findOneByProductSaleElementsId($product_sale->getId());
    					echo $product_sale;
    					$product_price->setListenPrice($preis);
    					$product_price->save();
    				}
    		}
    		else
    			$errors =" ".$data["extern_id"]." not found in db";

    		$this->importedRows++;
    		
		return $errors;
	}

}
