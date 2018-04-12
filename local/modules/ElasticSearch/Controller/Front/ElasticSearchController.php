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

   public function searchByProductId($id = null){
      $objElasticConnection = new ElasticConnection();
      $objElasticSearchConnection = $objElasticConnection::getConnection();
      if(null !== $id) {
            $json = '{
            "query": {
               "match": {
                 "product_id": "'.$id.'"
               }
              }
          }';
      } else {
         $json = $this->matchAll();
      }
          $params = [
              'index' => 'product',
              'type' => 'default',
              'body' => $json
          ];

          $result = $objElasticSearchConnection->search($params);
          echo "<pre>";
          var_dump($result['hits']["hits"][0]["_source"]); die;
          return  $result["_source"];
          
        }   


     public function searchByCategoryId($id = null){
      $objElasticConnection = new ElasticConnection();
      $objElasticSearchConnection = $objElasticConnection::getConnection();
        if (null !== $id) {
            $json = '{
            "query": {
               "match": {
                 "category_id": "'.$id.'"
               }
              }
          }';
        } else {
             $json = $this->matchAll();
        }


          $params = [
              'index' => 'product',
              'type' => 'default',
              'body' => $json
          ];
          $result = $objElasticSearchConnection->search($params);
          echo "<pre>";
          var_dump($result["hits"]); die;
          return  $result["_source"];
          
        }   
        
        
      public function searchByCategoryId( $name = null){
            $objElasticConnection = new ElasticConnection();
            $objElasticSearchConnection = $objElasticConnection::getConnection();
            if (NULL !== $name) {
                    $json = '{
                    "query": {
                       "match": {
                         "category_name": "'.$name.'"
                       }
                      }
                  }';
            } else {
                
                $json = $this->matchAll();
            }
            
            $params = [
                'index' => 'product',
                'type' => 'default',
                'body' => $json
            ];
            $result = $objElasticSearchConnection->search($params);
            echo "<pre>";
            var_dump($result["hits"]); die;
            return  $result["_source"];
            
        }
        
    
    public function fullTextSearch($text = null){
       $objElasticConnection = new ElasticConnection();
       $objElasticSearchConnection = $objElasticConnection::getConnection();
      
            $json = '{
             "query": 
               { 
                 "match": 
                 { 
                   "random_text": "'.$text.'"
                 } 
               } 
          }';
          $params = [
              'index' => 'product',
              'type' => 'default',
              'body' => $json
          ];
          echo "<pre>";
          var_dump($params);
          $result = $objElasticSearchConnection->search($params);
          echo "<pre>";
          var_dump($result); die;
          return  $result["_source"];
          
        } 


    public function orderByPriceAsc() {

            $json = '{
                "sort" : [
                { "product_listen_price" : {"order" : "asc"}},
                "_score"
                ],
                "query" : {
                          "match_all" : {}
              
              }
            }';
             $params = [
              'index' => 'product',
              'type' => 'default',
              'body' => $json
          ];
           $result = $objElasticSearchConnection->search($params);
           return $result;
    }



    public function orderByPriceDesc() {

            $json = '{
                "sort" : [
                { "product_listen_price" : {"order" : "desc"}},
                "_score"
                ],
                "query" : {
                          "match_all" : {}
              
              }
            }';
             $params = [
              'index' => 'product',
              'type' => 'default',
              'body' => $json
          ];
           $result = $objElasticSearchConnection->search($params);
           return $result;
    }
    
    
    public function matchAll() {
        
        $json ='
        "query" : {
                  "match_all" : {}
         }';
        
        return $json;
        
        
    }
}
 