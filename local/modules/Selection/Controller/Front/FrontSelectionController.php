<?php

namespace Selection\Controller\Front;

use Thelia\Controller\Front\BaseFrontController;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FrontSelectionController
 *
 * @author Catana Florin
 */
class FrontSelectionController extends BaseFrontController {

    public function viewBadAnzeigen($selectionId) {

        return $this->render('bad-anzeigen', array("SELECTION_ID" => $selectionId));
    }

}
