<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Scraper\Controller;

use Thelia\Core\HttpFoundation\Response;
use Thelia\Core\Security\AccessManager;
use Thelia\Core\Security\Resource\AdminResources;

/**
 * Description of OptionsController
 *
 * @author Catana Florin
 */
class OptionsController {

    //put your code here
    //zip
    //export

    function initCsvFile($file) {
        $fp = fopen($file, 'w');
        $fields = array("idartikel", "MegabildNr", "Lieferantename", "title", "description", "stock", "price");
        fputcsv($fp, $fields);
        fclose($fp);
    }

    function exportToCsv($csvFile, $arrayData) {
        $fp = fopen($csvFile, 'a');
        fputcsv($fp, $arrayData);
        fclose($fp);
    }

    function downloadCsv() {

        if (null !== $response = $this->checkAuth(AdminResources::MODULE, 'atos', AccessManager::UPDATE)) {
            return $response;
        }
        $session = $this->getRequest()->getSession();
        if ($session->has(self::MYSHT_CSV_FILE) == true) {
            $file = $session->get(self::MYSHT_CSV_FILE);
            $filePath = explode(DS, $file);
            $filename = $filePath[sizeof($filePath) - 1];
            return Response::create(@file_get_contents($file), 200, array(
                        'Content-type' => "text/plain",
                        'Content-Disposition' => sprintf("Attachment;filename=" . $filename)
            ));
        } else {
            return $this->errorPage($this->getTranslator()->trans("No csv file has been found"), 403);
        }
    }

    function downloadImages() {

        if (null !== $response = $this->checkAuth(AdminResources::MODULE, 'atos', AccessManager::UPDATE)) {
            return $response;
        }

        if (@file_get_contents($this->imageZip)) {
            return Response::create(@file_get_contents($this->imageZip), 200, array(
                        'Content-type' => "text/plain",
                        'Content-Disposition' => sprintf('Attachment;filename=imagesMysht.zip')
            ));
        } else {
            return $this->errorPage($this->getTranslator()->trans("No images.zip file has been found"), 403);
        }
    }

}
