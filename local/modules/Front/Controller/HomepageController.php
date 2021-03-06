<?php

namespace Front\Controller;

use Front\Front;
use Symfony\Component\HttpFoundation\Request;
use Thelia\Controller\Front\BaseFrontController;

class HomepageController extends BaseFrontController {

    public function badezimmerAction(Request $request) {
        return $this->render("badezimmer");
    }

    public function heizungSetAction(Request $request) {
        return $this->render("heizungset");
    }

    public function soFunktioniertsAction(Request $request) {
        return $this->render("sofunktionierts");
    }

    public function viewKlimaanlageLandingAction(Request $request) {
        return $this->render("klimaset-landing");
    }

    public function blackfridayAction(Request $request) {
        return $this->render("blackfriday");
    }

    public function viewOutletLandingAction(Request $request) {
        return $this->render("outlet-landing");
    }

}
