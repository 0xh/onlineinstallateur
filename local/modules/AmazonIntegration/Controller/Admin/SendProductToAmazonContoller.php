<?php
namespace AmazonIntegration\Controller\Admin;

use function Composer\Autoload\includeFile;
use Thelia\Controller\Admin\BaseAdminController;

class SendProductToAmazonContoller extends BaseAdminController
{
    
    public function addProductsToAmazon()
    {
        echo "<pre>"; 
    	
        var_dump($_GET);
        $radioChecked = $_GET['radioChecked'] ? $this->getRadioChecked($_GET['radioChecked']) : array();
        
        var_dump($radioChecked);
        foreach ($radioChecked as $rd)
        {
            var_dump($_GET['ref_'.$rd]);
            var_dump($_GET['ean_'.$rd]);
            var_dump($_GET['quantity_'.$rd]);
        }
        die;
    }
    
    protected function getRadioChecked($string)
    {
        return explode(",", $string);
    }
    
    protected function addProductAmazon()
    {
        $feed ='
            <?xml version="1.0" encoding="UTF-8"?>
            <AmazonEnvelope xsi:noNamespaceSchemaLocation="amzn-envelope.xsd" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
            	<Header>
            		<DocumentVersion>1.01</DocumentVersion>
            		<MerchantIdentifier>A3M3A89MAL04LF</MerchantIdentifier>
            	</Header>
            	<MessageType>Product</MessageType>
            	<PurgeAndReplace>false</PurgeAndReplace>
            	<Message>
            		<MessageID>1</MessageID>
            		<OperationType>Update</OperationType>
            		<Product>
            			<SKU>ASVG23218</SKU>
            			<StandardProductID>
            				<Type>EAN</Type>
            				<Value>4005176908972</Value>
            			</StandardProductID>
            		</Product>
            	</Message>
            </AmazonEnvelope>
            ';

        return $feed;
    }
    
    protected function updateQuantityProductAmazon()
    {
        $feed ='
            <?xml version="1.0" encoding="UTF-8"?>
            <AmazonEnvelope xsi:noNamespaceSchemaLocation="amzn-envelope.xsd" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
            	<Header>
            		<DocumentVersion>1.01</DocumentVersion>
            		<MerchantIdentifier>A3M3A89MAL04LF</MerchantIdentifier>
            	</Header>
            	<MessageType>Inventory</MessageType>
            	<PurgeAndReplace>false</PurgeAndReplace>
            	<Message>
            		<MessageID>1</MessageID>
            		<OperationType>Update</OperationType>
            		<Inventory>
            			<SKU>ASVG23218</SKU>
            			<Quantity>4</Quantity>
            			<FulfillmentLatency>1</FulfillmentLatency>
            		</Inventory>
            	</Message>
            </AmazonEnvelope>
            ';
        
        return $feed;
    }
    
    protected function updatePriceProductAmazon()
    {
        $feed ='
            <?xml version="1.0" encoding="UTF-8"?>
            <AmazonEnvelope xsi:noNamespaceSchemaLocation="amzn-envelope.xsd" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
            	<Header>
            		<DocumentVersion>1.01</DocumentVersion> 
            		<MerchantIdentifier>M_SELLER_354577</MerchantIdentifier> 
            	</Header> 
            	<MessageType>Price</MessageType> 
            	<Message>
            		<MessageID>1</MessageID> 
            		<Price>
            			<SKU>ASUSVNA1</SKU> 
            			<StandardPrice currency="USD">10.99</StandardPrice>
            		</Price> 
            	</Message> 
            </AmazonEnvelope>
            ';
        
        return $feed;
    }
}
