<?php
namespace ComparisonPlatformExporter\Export;

use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\Join;
use Thelia\ImportExport\Export\AbstractExport;
use Thelia\Model\ProductSaleElementsQuery;
use Thelia\Model\Map\ProductI18nTableMap;
use Thelia\Model\Map\ProductSaleElementsTableMap;
use Thelia\Model\Map\ProductTableMap;

/**
 * Class TriworxProductExport
 *
 * @author Alis Stranici <alis.stranici@sepa.at>
 */
class TriworxProductExport extends AbstractExport
{
	const FILE_NAME = 'triworx_export';
	
	protected $orderAndAliases = [
			ProductSaleElementsTableMap::EAN_CODE => 'EAN',
			'product_i18nTITLE' => 'Title',
			'productREF' => 'Ref',
			'productEXTERN_ID' => 'ExternId'
	];
	
	public function applyOrderAndAliases(array $data)
	{
		if ($this->orderAndAliases === null) {
			return $data;
		}
			
		$processedData = [];
			
		foreach ($this->orderAndAliases as $key => $value) {
			if (is_integer($key)) {
				$fieldName = $value;
				$fieldAlias = $value;
			} else {
				$fieldName = $key;
				$fieldAlias = $value;
			}
				
			$processedData[$fieldAlias] = null;
			if (array_key_exists($fieldName, $data)) {
				$processedData[$fieldAlias] = $data[$fieldName];
			}
		}
			
		return $processedData;
	}

	protected function getData()
	{
		$locale = $this->language->getLocale();
		
		$productJoin = new Join(ProductTableMap::ID, ProductI18nTableMap::ID, Criteria::LEFT_JOIN);
		
		$query = ProductSaleElementsQuery::create()
		->addSelfSelectColumns()
		->useProductQuery()
		->where(ProductTableMap::VISIBLE." = ?","1") 
		->addJoinObject($productJoin, 'product_join')
		->addJoinCondition('product_join', ProductI18nTableMap::LOCALE . ' = ?', $locale, null, \PDO::PARAM_STR)
		->withColumn(ProductI18nTableMap::TITLE)
		->withColumn(ProductTableMap::EXTERN_ID)
		->withColumn(ProductTableMap::REF)
		->endUse()
		->orderBy(ProductSaleElementsTableMap::ID)
		->groupBy(ProductSaleElementsTableMap::ID) 
		//->where('`product_sale_elements`.EAN_CODE ', Criteria::ISNOTNULL)
		;
		
		return $query;
	}
}
