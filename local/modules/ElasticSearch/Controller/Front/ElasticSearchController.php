<?php

namespace ElasticSearch\Controller\Front;

use ElasticSearch\Controller\Front\ElasticConnection;
use Thelia\Controller\Front\BaseFrontController;

class ElasticSearchController extends BaseFrontController
{
   
    public function showResults( $results = NULL ){
        $objElasticConnection = new ElasticConnection();
        $objElasticSearchConnection = $objElasticConnection::getConnection();
        // $result=$this->fullTextSearch("Waschtischarmaturen");
        // $result=$this->searchByProductId(3781);
        // 
        $result=$this->searchByCategoryId(33);
        
         if ($results == NULL) {
             $results[]="no results where found!!";
         }
       return $this->render("search_results_page");
    }
}
 