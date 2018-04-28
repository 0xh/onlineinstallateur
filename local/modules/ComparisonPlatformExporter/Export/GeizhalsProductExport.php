<?php
namespace ComparisonPlatformExporter\Export;


use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\Join;
use Thelia\Core\Event\TheliaEvents;
use Thelia\Core\Event\Image\ImageEvent;
use Thelia\ImportExport\Export\AbstractExport;
use Thelia\Model\ConfigQuery;
use Thelia\Model\ProductSaleElementsQuery;
use Thelia\Model\RewritingUrlQuery;
use Thelia\Model\Map\BrandI18nTableMap;
use Thelia\Model\Map\CategoryI18nTableMap;
use Thelia\Model\Map\ProductCategoryTableMap;
use Thelia\Model\Map\ProductI18nTableMap;
use Thelia\Model\Map\ProductImageTableMap;
use Thelia\Model\Map\ProductPriceTableMap;
use Thelia\Model\Map\ProductSaleElementsTableMap;
use Thelia\Model\Map\ProductTableMap;
use Thelia\Log\Tlog;

/**
 * Class GeizhalsProductExport
 *
 * @author Emanuel Plopu <emanuel.plopu@sepa.at>
 */
class GeizhalsProductExport extends AbstractExport
{
    
    const FILE_NAME = 'catalog_geizhals';
    
    private $url_site;
    private $baseSourceFilePath = null;
    private $locale;
    
    protected $orderAndAliases = [
        'product_i18nTITLE' => 'Bezeichnung',
        'brand_i18nTITLE' => 'Hersteller',
        'productREF' => 'Herstellernummer',
        'product_pricePRICE' => 'Preis',
        ProductSaleElementsTableMap::EAN_CODE => 'EAN',
        ProductTableMap::VISIBLE => 'Deeplink',
        'productID' => 'Artikelnummer',
        'product_pricePROMO_PRICE' => 'Spezialpreis',
        'product_priceLISTEN_PRICE' => 'Streichpreis',
        ProductSaleElementsTableMap::PROMO => 'Promo',
        'product_imageFILE' => 'Produkt_BILD',
        'category_i18nTITLE' => 'Produktgruppe',
        ProductSaleElementsTableMap::QUANTITY => 'Verfügbarkeit'
    ];
    
    /**
     * Apply order and aliases on data
     *
     * @param array $data
     *            Raw data
     *
     * @return array Ordered and aliased data
     */
    public function applyOrderAndAliases(array $data)
    {
        //$data['category_i18nTITLE'] = CommonExport::getCategoryHierarchy($data['productID']);
        
        if ($this->orderAndAliases === null) {
            return $data;
        }
        // Tlog::getInstance()->error($data['productID']);
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
        
        $processedData['Produktgruppe'] = CommonExport::getCategoryHierarchy($data['productID']);
        if ($this->url_site == null)
            $this->url_site = ConfigQuery::read('url_site');
            
            $rewriteUrl = RewritingUrlQuery::create()
            ->filterByView('product')
            ->filterByViewId($data['productID'])
            ->filterByViewLocale($this->locale)
            ->filterByRedirected(null)
            ->findOne();
            
            $processedData['Deeplink'] = $this->url_site . "/" . $rewriteUrl->getUrl();
            $processedData['Produkt_BILD'] = $this->url_site . "/cache/images/product/" . $processedData['Produkt_BILD'];
            
            if ($processedData['Verfügbarkeit'] > 100)
                $processedData['Verfügbarkeit'] = "Lagernd ";
                else
                    $processedData['Verfügbarkeit'] = "2-3 Arbeitstagen";
                    $processedData['Versand AT'] = "0";
                    $processedData['Preis'] = number_format((float) ($processedData['Preis'] * 1.2), 2, '.', '');
                    
                    if ($processedData['Promo'] == 0)
                        $processedData['Spezialpreis'] = "";
                        
                        unset( $processedData['Promo']);
                        return $processedData;
    }
    
    public function getImageUrl($safe_filename)
    {
        // Tlog::getInstance()->error("subdir ".$subdir." source_file ".$filename." safe ".sprintf("%s/%s-%s", $path, $hashed_options, $safe_filename));
        // $path = '/cache/';
        // $image = new Image($fileManager)
        // return URL::getInstance()->absoluteUrl(sprintf("%s/%s", $path, $safe_filename), null, URL::PATH_TO_FILE);
        $event = new ImageEvent();
        
        if ($this->baseSourceFilePath === null) {
            $this->baseSourceFilePath= THELIA_LOCAL_DIR . 'media' . DS . 'images';
        } else {
            $this->baseSourceFilePath= THELIA_ROOT . $this->baseSourceFilePath;
        }
        
        $sourceFilePath = sprintf('%s/%s/%s', $this->baseSourceFilePath, $this->objectType, $result->getFile());
        
        $event->setSourceFilepath($sourceFilePath);
        $event->setCacheSubdirectory($this->objectType);
        $this->dispatcher->dispatch(TheliaEvents::IMAGE_PROCESS, $event);
    }
    
    protected function getData()
    {
        $max_time = ini_get("max_execution_time");
        ini_set('max_execution_time', 300);
        
        $now = new \DateTime(null, new \DateTimeZone('Europe/Vienna'));
        Tlog::getInstance()->error("started geizhals query ".$now->format('Y-m-d H:i:s'));
        $this->locale = $this->language->getLocale();
        
        $productJoin = new Join(ProductTableMap::ID, ProductI18nTableMap::ID, Criteria::LEFT_JOIN);
        $brandJoin = new Join(ProductTableMap::BRAND_ID, BrandI18nTableMap::ID, Criteria::LEFT_JOIN);
        // $categoryJoin = new Join(ProductTableMap::ID, ProductCategoryTableMap::PRODUCT_ID, Criteria::LEFT_JOIN);
        $categoryJoin = new Join(ProductCategoryTableMap::CATEGORY_ID, CategoryI18nTableMap::ID, Criteria::LEFT_JOIN);
        $imageJoin = new Join(ProductTableMap::ID, ProductImageTableMap::PRODUCT_ID, Criteria::LEFT_JOIN);
        
        /** @var ProductSaleElementsQuery $query */
        $query = ProductSaleElementsQuery::create()->addSelfSelectColumns()
        ->useProductPriceQuery()
        ->withColumn(ProductPriceTableMap::PRICE)
        ->withColumn(ProductPriceTableMap::PROMO_PRICE)
        ->withColumn(ProductPriceTableMap::LISTEN_PRICE)
        ->endUse()
        ->useProductQuery()
        ->where(ProductTableMap::VISIBLE." = ?","1")
        ->useProductCategoryQuery()
        ->addJoinObject($categoryJoin, 'category_join')
        ->addJoinCondition('category_join', CategoryI18nTableMap::LOCALE . ' = ?', $this->locale, null, \PDO::PARAM_STR)
        ->withColumn(CategoryI18nTableMap::TITLE)
        ->endUse()
        ->addJoinObject($productJoin, 'product_join')
        ->addJoinCondition('product_join', ProductI18nTableMap::LOCALE . ' = ?', $this->locale, null, \PDO::PARAM_STR)
        ->withColumn(ProductI18nTableMap::TITLE)
        ->withColumn(ProductI18nTableMap::DESCRIPTION)
        ->withColumn(ProductTableMap::ID)
        ->withColumn(ProductTableMap::REF)
        ->withColumn(ProductTableMap::VISIBLE)
        ->addJoinObject($productJoin, 'product_join')
        ->addJoinCondition('product_join', ProductI18nTableMap::LOCALE . ' = ?', $this->locale, null, \PDO::PARAM_STR)
        ->addJoinObject($imageJoin, 'product_image_join')
        ->addJoinCondition('product_image_join', ProductImageTableMap::POSITION . '= ?', "1", null, \PDO::PARAM_INT)
        ->withColumn(ProductImageTableMap::FILE)
        ->addJoinObject($brandJoin, 'brand_join')
        ->addJoinCondition('brand_join', BrandI18nTableMap::LOCALE . ' = ?', $this->locale, null, \PDO::PARAM_STR)
        ->withColumn(BrandI18nTableMap::TITLE)
        ->endUse()
        ->orderBy(ProductSaleElementsTableMap::ID)
        ->groupBy(ProductSaleElementsTableMap::ID)
        ->where('`product_sale_elements`.EAN_CODE ', Criteria::ISNOTNULL);
        
        ini_set('max_execution_time', $max_time);
        
        return $query;
    }
}

