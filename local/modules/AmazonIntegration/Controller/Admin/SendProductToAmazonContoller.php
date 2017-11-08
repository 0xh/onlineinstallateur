<?php
namespace AmazonIntegration\Controller\Admin;

use AmazonIntegration\AmazonIntegration;
use AmazonIntegration\Classes\API\src\MarketplaceWebService\Samples\SubmitFeedClass;
use AmazonIntegration\Model\AmazonProductsHf;
use AmazonIntegration\Model\AmazonProductsHfQuery;
use function Composer\Autoload\includeFile;
use Thelia\Controller\Admin\BaseAdminController;

class SendProductToAmazonContoller extends BaseAdminController
{
    
    public function addProductsToAmazon()
    {
        $prodToSend = array();
        $amazonMarketplaceId = (explode(";", $_GET["amazon_marketplace"]))[0];
        $amazonMarketplaceLocale = (explode(";", $_GET["amazon_marketplace"]))[1];
        $amazonCurrency = $_GET["amazon_currency"];
        
        $radioChecked = $_GET['radioChecked'] ? $this->getRadioChecked($_GET['radioChecked']) : array();
        
        foreach ($radioChecked as $rd)
        {
            $prodToSend[$rd] = array(
                        'ref' => $_GET['ref_'.$rd],
                        'ean' => $_GET['ean_'.$rd],
                        'quantity' => $_GET['quantity_'.$rd],
                        'price' => $_GET['price_'.$rd],
            );
        }
        
        $this->addProductAmazon($prodToSend, $amazonMarketplaceId, $amazonMarketplaceLocale);
        $this->updateQuantityProductAmazon($prodToSend, $amazonMarketplaceId, $amazonMarketplaceLocale);
        $this->updatePriceProductAmazon($prodToSend, $amazonCurrency, $amazonMarketplaceId, $amazonMarketplaceLocale);
        $this->addProdToHfTable($prodToSend, $amazonMarketplaceId, $amazonMarketplaceLocale);

       return $this->generateRedirect("/admin/module/amazonintegration", 303);
    }
    
    protected function addProdToHfTable($prods, $marketPlaceId, $marketPlaceLocale)
    {
        foreach ($prods as $key => $prod)
        {
            $query = AmazonProductsHfQuery::create()
                    ->filterByProductId($key)
                    ->findOneByMarketplaceId($marketPlaceId);
            
            if ($query == null)
            {
                $prodAmazon = new AmazonProductsHf();
                $prodAmazon->setProductId($key);
                $prodAmazon->setRef($prod['ref']);
                $prodAmazon->setEanCode($prod['ean']);
                //         $prodAmazon->setASIN($asin);
                $prodAmazon->setSKU($prod['ref']);
                $prodAmazon->setPrice($prod['price']);
                $prodAmazon->setQuantity($prod['quantity']);
                $prodAmazon->setMarketplaceId($marketPlaceId);
                $prodAmazon->setMarketplaceLocale($marketPlaceLocale);
                $prodAmazon->save();
                $prodAmazon->clear();
            }
            else 
            {
                $query->setQuantity($prod['quantity']);
                $query->setPrice($prod['price']);
                $query->save();
            }
                
        }
                
    }
    
    protected function getRadioChecked($string)
    {
        return explode(",", $string);
    }
    
    protected function addProductAmazon($prods, $amazonMarketplaceId, $amazonMarketplaceLocale, $feedType = "_POST_PRODUCT_DATA_")
    {
        $feed = '<?xml version="1.0" encoding="utf-8"?>
                <AmazonEnvelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="amzn-envelope.xsd">
            	<Header>
            		<DocumentVersion>1.01</DocumentVersion>
            		<MerchantIdentifier>' . AmazonIntegration::getConfigValue('MERCHANT_ID') . '</MerchantIdentifier>
            	</Header>
            	<MessageType>Product</MessageType>
            	<PurgeAndReplace>false</PurgeAndReplace>';
        
        $i = 1;
        foreach ($prods as $prod)
        {
            $feed .= ' 
            	<Message>
            		<MessageID>' . $i++ . '</MessageID>
            		<OperationType>Update</OperationType>
            		<Product>
            			<SKU>' . $prod['ref'] . '</SKU>
            			<StandardProductID>
            				<Type>EAN</Type>
            				<Value>' . $prod['ean'] . '</Value>
            			</StandardProductID>
            		</Product>
            	</Message>';
        }

        $feed .= '</AmazonEnvelope>';

        $test = new SubmitFeedClass($feed, $feedType, $amazonMarketplaceId, $amazonMarketplaceLocale);
        $test->invokeSubmitFeed();
//         var_dump($test);
//         die;
//         return $feed;
    }
    
    protected function updateQuantityProductAmazon($prods, $amazonMarketplaceId, $amazonMarketplaceLocale, $feedType = "_POST_INVENTORY_AVAILABILITY_DATA_")
    {
        $feed ='<?xml version="1.0" encoding="UTF-8"?>
            <AmazonEnvelope xsi:noNamespaceSchemaLocation="amzn-envelope.xsd" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
            	<Header>
            		<DocumentVersion>1.01</DocumentVersion>
            		<MerchantIdentifier>' . AmazonIntegration::getConfigValue('MERCHANT_ID') . '</MerchantIdentifier>
            	</Header>
            	<MessageType>Inventory</MessageType>
            	<PurgeAndReplace>false</PurgeAndReplace>';
        
        $i = 1;
        foreach ($prods as $prod)
        {
            $feed .= ' 
            	<Message>
            		<MessageID>' . $i++ . '</MessageID>
            		<OperationType>Update</OperationType>
            		<Inventory>
            			<SKU>' . $prod['ref'] . '</SKU>
            			<Quantity>' . $prod['quantity'] . '</Quantity>
            			<FulfillmentLatency>1</FulfillmentLatency>
            		</Inventory>
            	</Message>';
        }

        $feed .= '</AmazonEnvelope>';
        
        $test = new SubmitFeedClass($feed, $feedType, $amazonMarketplaceId, $amazonMarketplaceLocale);
        $test->invokeSubmitFeed();
//         die;
//         return $feed;
    }
    
    protected function updatePriceProductAmazon($prods, $amazonCurrency, $amazonMarketplaceId, $amazonMarketplaceLocale, $feedType = "_POST_PRODUCT_PRICING_DATA_")
    {
        $feed ='<?xml version="1.0" encoding="UTF-8"?>
            <AmazonEnvelope xsi:noNamespaceSchemaLocation="amzn-envelope.xsd" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
            	<Header>
            		<DocumentVersion>1.01</DocumentVersion> 
            		<MerchantIdentifier>' . AmazonIntegration::getConfigValue('MERCHANT_ID') . '</MerchantIdentifier> 
            	</Header> 
            	<MessageType>Price</MessageType>'; 

        $i = 1;
        foreach ($prods as $prod)
        {
            $feed .= ' 
            	<Message>
            		<MessageID>' . $i++ . '</MessageID> 
            		<Price>
            			<SKU>' . $prod['ref'] . '</SKU> 
            			<StandardPrice currency="' . $amazonCurrency . '">' . $prod['price'] . '</StandardPrice>
            		</Price> 
            	</Message> ';
        }
            	
        $feed .= '</AmazonEnvelope>';
        
        $test = new SubmitFeedClass($feed, $feedType, $amazonMarketplaceId, $amazonMarketplaceLocale);
        $test->invokeSubmitFeed();
//         die;
//         return $feed;
    }
}
