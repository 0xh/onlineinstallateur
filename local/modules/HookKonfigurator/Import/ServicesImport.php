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

/**
 * Class ServiceImport
 * @package HookKonfigurator\Import
 * @author Emanuel Plopu <emanuel.plopu@sepa.at>
 */
class ServicesImport extends ImportHandler
{
    /**
     * @param \Thelia\Core\FileFormat\Formatting\FormatterData
     * @return string|array error messages
     *
     * The method does the import routine from a FormatterData
     */
    public function retrieveFromFormatterData(FormatterData $data)
    {
        $errors = [];
        $log = Tlog::getInstance ();
        $log->debug(" service_import ");
        
        $productQuerry = ProductQuery::create ();
        $constraintsQuerry = ConstraintsQuery::create ();
        
        $currentDate = date ( "Y-m-d H:i:s" );
        $serviceCategoryId = 12;
        
        $i = 0;
        
        while (null !== $row = $data->popRow()) {       
        	$log->debug( "importing_service ".$i.implode(" ",$row));

            $this->checkMandatoryColumns($row);
            
            // id ref name description type price quantity unit extra_quantity_price constraints_values constraints_names currency duration
            
            //excel saves csv as ansi, we need utf8
            $ref = utf8_encode($row["ref"]);
            $name = utf8_encode($row["name"]);
            $description = utf8_encode($row["description"]);
            $type = utf8_encode($row["type"]);
            $unit = utf8_encode($row["unit"]);
            $constraintsNames = utf8_encode($row["constraints_names"]);
            $constraintsValues = $row["constraints_values"];
            $quantity = $row["quantity"];
            
            //$log->debug ( " constraints " . $constraintsNames );
            //number format, change "," to "."
            $price = str_replace(",", ".", $row["price"]);
            $extra_quantity_price = str_replace(",", ".", $row["extra_quantity_price"]);
            $duration = $row["duration"];
            		
			//check for existing services
            $productQuerry->clear ();
            $productExists = count ( $productQuerry->findByRef ( $ref ) );
            
            if ($productExists == 0) // product_numbers must be unique
            	{
            		$log->debug ( " service is new " );
            	$productThelia = new Product ();
            	$productThelia->setRef ( $ref ); // must be unique
            	$productThelia->setVisible ( 0 );
            				
            	$productThelia->setCreatedAt ( $currentDate );
            	$productThelia->setUpdatedAt ( $currentDate );
            	$productThelia->setVersion ( 1 );
            	$productThelia->setVersionCreatedAt ( $currentDate );
            	$productThelia->setVersionCreatedBy ( "importer.1" );
            	$productThelia->create ( $serviceCategoryId, $price, 1, 1, 'NULL', 20 );
            	$log->debug ( " service is add as product " );
            	
            	// product description
            	$productI18n = new ProductI18n ();
            	$productI18n->setProduct ( $productThelia );
            	$productI18n->setLocale ( "en_US" );
            	$productI18n->setTitle ( $name );
            	$productI18n->setDescription ( $description );
            	$productI18n->setChapo ( " Zusammenfassung von " . $name );
            	$productI18n->setPostscriptum ( " Merkmalen von " . $name );
            	$productI18n->save ();
            	$log->debug ( " service i18n is added " );
            	$productThelia->addProductI18n ( $productI18n );
            				
            	$product_montage = new Montage ();
            	$product_montage->setId ( $productThelia->getId () );
            	$product_montage->setType ( $type );
            	
            	if(is_numeric($quantity))
            		$product_montage->setQuantity ( $quantity );
            		$product_montage->setUnit ( $unit );
            		
            	if(is_numeric($extra_quantity_price))
            		$product_montage->setExtraQuantityPrice ( $extra_quantity_price );
            	
            	$product_montage->setDuration ( $duration );
            	$log->debug ( "montageerror " . $product_montage->__toString () );
            	$product_montage->save ();
            						
            	$constraintsNamesArray = explode ( ";", $constraintsNames );
            	$constraintsValuesArray = explode ( ";", $constraintsValues );
            
            	for($i = 0; $i < sizeof ( $constraintsNamesArray ); $i ++){
            
            	if ($constraintsNamesArray [$i] != "NULL") {
            								
            		$montageConstraint = new MontageConstraints ();
            		$montageConstraint->setMontageId ( $product_montage->getId () );
            		$constraintValue = str_replace(",", ".", $constraintsValuesArray [$i]);
            		$montageConstraint->setConstraintValue ( $constraintValue );

            		$constraintsQuerry->clear ();
            		$constraints_result = $constraintsQuerry->findByName ( $constraintsNamesArray [$i] );
            		if(count($constraints_result)>0){ // old constraint
            				$log->debug(" found ".count($constraints_result));
            				$montageConstraint->setConstraintsId ( $constraints_result [0]->getId () );
            				}
            		else { // new constraint
            			$constraint = new Constraints ();
            			$constraint->setName ( $constraintsNamesArray [$i] );
            			$constraint->setDescription ( " description of constraint " . $constraintsNamesArray [$i] );
            			$log->debug(" constraintobj ".$constraint->__toString());
            			$constraint->save ();
            			$montageConstraint->setConstraintsId ( $constraint->getId () );
            			}	
            	 $montageConstraint->save();
            	}
            	}
            	}
            	else
            	{
            		$errors[] = $this->translator->trans( "Product reference number %ref is already in the database ",
            				["%ref" => $row["ref"]] );
            		$log->debug ( " ref number already in the database '" . $ref . "'" );
            	}
            
            						
         $this->importedRows++;

            /*
            $obj = ProductSaleElementsQuery::create()->findPk($row["id"]);

            if ($obj === null) {
                $errors[] = $this->translator->trans(
                    "The product sale element reference %id doesn't exist",
                    ["%id" => $row["id"]] );
            } else {
                $obj->setQuantity($row["stock"]);

                if (isset($row["ean"]) && !empty($row["ean"])) {
                    $obj->setEanCode($row["ean"]);
                }

                $obj->save();
                $this->importedRows++;
            }*/
        }

        return $errors;
    }

    protected function getMandatoryColumns()
    {
        return ["id", "ref","name","description","type","price","quantity","unit","extra_quantity_price","constraints_values","constraints_names","currency","duration"];
    }

    /**
     * @return string|array
     *
     * Define all the type of import/formatters that this can handle
     * return a string if it handle a single type ( specific exports ),
     * or an array if multiple.
     *
     * Thelia types are defined in \Thelia\Core\FileFormat\FormatType
     *
     * example:
     * return array(
     *     FormatType::TABLE,
     *     FormatType::UNBOUNDED,
     * );
     */
    public function getHandledTypes()
    {
        return array(
            FormatType::TABLE,
            FormatType::UNBOUNDED,
        );
    }
}
