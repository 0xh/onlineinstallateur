<?php
/*************************************************************************************/
/*      This file is part of the Thelia package.                                     */
/*                                                                                   */
/*      Copyright (c) OpenStudio                                                     */
/*      email : dev@thelia.net                                                       */
/*      web : http://www.thelia.net                                                  */
/*                                                                                   */
/*      For the full copyright and license information, please view the LICENSE.txt  */
/*      file that was distributed with this source code.                             */
/*************************************************************************************/

namespace Thelia\ImportExport\Import\Type;

use Thelia\Core\Translation\Translator;
use Thelia\ImportExport\Import\AbstractImport;
use Thelia\Model\ProductSaleElementsQuery;

/**
 * Class ProductSaleElementImport
 * @author Emanuel Plopu <emanuel.plopu@sepa.at>
 */
class ProductSaleElementImport extends AbstractImport
{
    protected $mandatoryColumns = [
        'Id',
    	'Product_id'
    ];

    public function importData(array $data)
    {
        $pse = ProductSaleElementsQuery::create()->findPk($data['Id']);

        if ($pse === null) {
            return Translator::getInstance()->trans(
                'The product sale element id %id doesn\'t exist',
                [
                    '%id' => $data['Id']
                ]
            );
        } else {
            if (isset($data['Quantity']) && !empty($data['Quantity'])) {
                $pse->setQuantity($data['Quantity']);
            }

            if (isset($data['Sale']) && !empty($data['Sale'])) {
            	$pse->setPromo($data['Sale']);
            }
            
            if (isset($data['New']) && !empty($data['New'])) {
            	$pse->setNewness($data['New']);
            }
            
            if (isset($data['Weight']) && !empty($data['Weight'])) {
            	$pse->setWeight($data['Weight']);
            }
            
            if (isset($data['Ean_code']) && !empty($data['Ean_code'])) {
                $pse->setEanCode($data['Ean_code']);
            }

            $pse->save();
            $this->importedRows++;
        }

        return null;
    }
}