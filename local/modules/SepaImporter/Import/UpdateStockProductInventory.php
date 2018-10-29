<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace SepaImporter\Import;

use MultipleFullfilmentCenters\Model\FulfilmentCenterProducts;
use MultipleFullfilmentCenters\Model\FulfilmentCenterProductsQuery;
use Thelia\ImportExport\Import\AbstractImport;
use Thelia\Log\Tlog;
use Thelia\Model\ProductQuery;
use Thelia\Model\ProductSaleElementsQuery;

/**
 * Description of ImportStockProductInventory
 *
 * @author Catana Florin
 */
class UpdateStockProductInventory extends AbstractImport {

    const USE_FULFILMENT_CENTER = true;

    protected $mandatoryColumns = [
        'megabildnr', //ref
        'verfuegbarkeit' //stock
    ];
    protected $importedRows = 0;
    protected $hanH = "HG";
    protected $han = "HAN";
    protected $gro = "G";
    protected $lau = "ROC";
    protected $upo = "UPO";
    protected $klu = "KL";
    protected $dan = "DF";
    protected $honvtl = "HONVTL";
    protected $vai = "VA";
    protected $refSearch = "";

    public function importData(array $data) {

        $centerId = isset($_REQUEST["fulfilment_center"]) ? $_REQUEST["fulfilment_center"] : 0;

        $this->refSearch = "";

        $ref = $data["megabildnr"];
        $stock = $data["verfuegbarkeit"];

        if (substr($ref, 0, strlen($this->hanH)) === $this->hanH) {
            $this->convertRefToHanHRef($ref);
        }

        if (substr($ref, 0, strlen($this->han)) === $this->han) {
            $this->convertRefToHanRef($ref);
        }

        if (substr($ref, 0, strlen($this->gro)) === $this->gro) {
            $this->convertRefToGroRef($ref);
        }

        if (substr($ref, 0, strlen($this->lau)) === $this->lau) {
            $this->convertRefToLauRef($ref);
        }

        if (substr($ref, 0, strlen($this->upo)) === $this->upo) {
            $this->convertRefToUpoRef($ref);
        }

        if (substr($ref, 0, strlen($this->klu)) === $this->klu) {
            $this->convertRefToKluRef($ref);
        }

        if (substr($ref, 0, strlen($this->dan)) === $this->dan) {
            $this->convertRefToDanRef($ref);
        }

        if (substr($ref, 0, strlen($this->honvtl)) === $this->honvtl) {
            $this->convertRefToHonvtlRef($ref);
        }

        if (substr($ref, 0, strlen($this->vai)) === $this->vai) {
            $this->convertRefToVaiRef($ref);
        }

        if ($this->refSearch) {
            if ($centerId == 0) {
                $this->updatePSE($this->refSearch, $stock);
            } else {
                $this->updateOrInsertFulfilmentCenter($this->refSearch, $centerId, $stock);
            }
        }

        parent::setImportedRows($this->importedRows);
    }

    protected function updateOrInsertFulfilmentCenter($ref, $centerId, $stock) {
        $productQuery = ProductQuery::create();
        $productQuery = $productQuery->findOneByRef($ref);

        if ($productQuery) {
            $idProd = $productQuery->getId();

            $centerQuery = FulfilmentCenterProductsQuery::create();
            $centerQuery = $centerQuery->filterBy("FulfilmentCenterId", $centerId)
                    ->findOneByProductId($idProd);

            if ($centerQuery) {
                $this->importedRows++;
                $oldStok = $centerQuery->getProductStock();
                $centerQuery->setProductStock($stock);
                $centerQuery->save();
                Tlog::getInstance()->info("Stock for ref_id = " . $ref . " was " . $oldStok . " now is: " . $stock . "(center_id = " . $centerId . ")");
            } else {
                $this->importedRows++;
                $newProdInCenter = new FulfilmentCenterProducts();
                $newProdInCenter->setFulfilmentCenterId($centerId);
                $newProdInCenter->setProductId($idProd);
                $newProdInCenter->setProductStock($stock);
                $newProdInCenter->save();
                Tlog::getInstance()->info("Ref_id  = " . $ref . " was added with stock = " . $stock . "(center_id = " . $centerId . ")");
            }
        }
    }

    protected function updatePSE($ref, $stock) {
        $productQuery = ProductSaleElementsQuery::create();
        $productSaleElement = $productQuery->findOneByRef($ref);

        if ($productSaleElement) {
            $this->importedRows++;
            $oldStok = $productSaleElement->getQuantity();
            $productSaleElement->setQuantity($stock);
            $productSaleElement->save();
            Tlog::getInstance()->info("Stock for ref_id = " . $ref . " was " . $oldStok . " now is: " . $stock);
        }
    }

    protected function replaceRef($ref, $search, $replace, $limit = 1) {
        return preg_replace("/" . $search . "/", $replace, $ref, $limit);
    }

    protected function addZeroToRef($ref) {
        while (strlen($ref) < 11) {
            $ref .= "0";
        }
        return $ref;
    }

    protected function convertRefToHanHRef($ref) {
        $ref = $this->replaceRef($ref, $this->hanH, "HAN");
        $ref = $this->addZeroToRef($ref);
        $this->refSearch = $ref;
    }

    protected function convertRefToHanRef($ref) {
        $ref = $this->addZeroToRef($ref);
        $this->refSearch = $ref;
    }

    protected function convertRefToGroRef($ref) {
        $ref = $this->replaceRef($ref, $this->gro, "GRO");
        $ref = $this->addZeroToRef($ref);
        $this->refSearch = $ref;
    }

    protected function convertRefToLauRef($ref) {
        $ref = $this->replaceRef($ref, $this->lau, "LAU");
        $this->refSearch = $ref;
    }

    protected function convertRefToUpoRef($ref) {
//        $ref = $this->replaceRef($ref, $this->upo, "UPO");
        $this->refSearch = $ref;
    }

    protected function convertRefToKluRef($ref) {
        $ref = $this->replaceRef($ref, $this->klu, "KLU");
        $this->refSearch = $ref;
    }

    protected function convertRefToDanRef($ref) {
        $ref = $this->replaceRef($ref, $this->dan, "DAN");
        $this->refSearch = $ref;
    }

    protected function convertRefToHonvtlRef($ref) {
//        $ref = $this->replaceRef($ref, $this->honvtl, "HONVTL");
        $this->refSearch = $ref;
    }

    protected function convertRefToVaiRef($ref) {
        $ref = $this->replaceRef($ref, $this->vai, "VAI");
        $this->refSearch = $ref;
    }

}
