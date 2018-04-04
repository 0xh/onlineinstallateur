<?php

namespace ElasticSearch\Controller\Front;

use ElasticSearch\Controller\Front\ElasticConnection;
use Thelia\Controller\Front\BaseFrontController;

class ElasticSearchController extends BaseFrontController
{
   
    public function showResults( $results = NULL ){
        $objElasticConnection = new ElasticConnection();
        $objElasticSearchConnection = $objElasticConnection::getConnection();
         if ($results == NULL) {
             $results[]="no results where found!!";
         }
       return $this->render("search_results_page");
    }
}
