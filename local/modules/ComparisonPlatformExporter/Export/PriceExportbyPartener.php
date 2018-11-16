<?php

namespace ComparisonPlatformExporter\Export;

use Doctrine\Common\Collections\Criteria;
use HookAdminCrawlerDashboard\Model\CrawlerProductListingQuery;
use HookAdminCrawlerDashboard\Model\Map\CrawlerProductBaseTableMap;
use HookAdminCrawlerDashboard\Model\Map\CrawlerProductListingTableMap;
use RevenueDashboard\Model\Map\WholesalePartnerProductTableMap;
use Thelia\ImportExport\Export\AbstractExport;

/**
 * Class TriworxProductExport
 *
 * @author Lucian Criste <lucian.criste@sepa.at>
 */
class PriceExportbyPartener extends AbstractExport
{

//    const USE_EXPORT_FROM_PARTNER = true;
    const FILE_NAME                  = 'product_price';
    const USE_EXPORT_FROM_PARTNER    = true;

    protected $orderAndAliases = [
      'mach_code' => "Partner_product_ref",
     'Amazon'=> 'Amazon',
     'Google' => 'Google',
     'Reuter' => 'Reuter',
     'Skybad' => 'Skybad',
     'Megabad' => 'Megabad',

    ];

    public function applyOrderAndAliases(array $data)
    {
        if ($this->orderAndAliases === null) {
            return $data;
        }

        $processedData = [];

        foreach ($this->orderAndAliases as $key => $value) {
            if (is_integer($key)) {
                $fieldName  = $value;
                $fieldAlias = $value;
            } else {
                $fieldName  = $key;
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
        ini_set('max_execution_time', 3000);
        
        $query = CrawlerProductListingQuery::create()              
            ->addJoin(CrawlerProductListingTableMap::PRODUCT_BASE_ID , CrawlerProductBaseTableMap::ID )
            ->addJoin(CrawlerProductBaseTableMap::PRODUCT_ID , WholesalePartnerProductTableMap::PRODUCT_ID)
            ->withColumn(WholesalePartnerProductTableMap::PARTNER_PRODUCT_REF, 'mach_code')          
            ->withColumn('(CASE WHEN '.CrawlerProductListingTableMap::PLATFORM.'= "Amazon" then first_price else 0 end)', 'Amazon')
            ->withColumn('(CASE WHEN '.CrawlerProductListingTableMap::PLATFORM.'= "Google" then first_price else 0 end)', 'Google')
            ->withColumn('(CASE WHEN '.CrawlerProductListingTableMap::PLATFORM.'= "Reuter" then first_price else 0 end)', 'Reuter')
            ->withColumn('(CASE WHEN '.CrawlerProductListingTableMap::PLATFORM.'= "Skybad" then first_price else 0 end)', 'Skybad')
            ->where(WholesalePartnerProductTableMap::PARTNER_PRODUCT_REF .'<>""' )
            ->orderByProductBaseId(Criteria::ASC)
         ;
        
        var_dump($query->toString()); die;
        return $query;
    }

}
