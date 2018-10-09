<?php

namespace ElasticSearch\Controller\Front;

use Elasticsearch\ClientBuilder;

class ElasticConnection
{

    private static $_instance = null;
    private $host;
    private $port;
    private $schema;
    private $user;
    private $pass;
    private static $objConnection;

    #setters

    public function setHost($var)
    {
        $this->host = $var;
    }

    public function setPort($var)
    {
        $this->port = $var;
    }

    public function setUser($var)
    {
        $this->user = $var;
    }

    public function setPass($var)
    {
        $this->pass = $var;
    }

    public function setSchema($var)
    {
        return $this->schema = $var;
    }

    #getters

    public function getHost()
    {
        return $this->host;
    }

    public function getPort()
    {
        return $this->port;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function getPass()
    {
        return $this->pass;
    }

    public function getSchema()
    {
        return $this->schema;
    }

    public function __construct($params = NULL)
    {
        if (is_array($params)) {
            $this->setHost($params['host']);
            $this->setPort($params['port']);
            $this->setSchema($params['schema']);
            $this->setUser($params['user']);
            $this->setPass($params['pass']);
            self::connectToElastic($params);
        } else {
            $this->setHost("185.164.5.11");
            $this->setPort("9200");
            $this->setSchema("http");
            $this->setUser("admin");
            $this->setPass("Aa123456");
        }
        self::connectToElastic(array(
         "host"   => $this->getHost(),
         "port"   => $this->getPort(),
         "schema" => $this->getSchema(),
         "user"   => $this->getUser(),
         "pass"   => $this->getPass()
         )
        );
    }

    public static function connectToElastic($config)
    {
        $defaultHandler = ClientBuilder::defaultHandler();
        $connectionPool = '\Elasticsearch\ConnectionPool\StaticNoPingConnectionPool';
        $serializer     = '\Elasticsearch\Serializers\SmartSerializer';
        $_instance      = ClientBuilder::create()
         ->setHosts($config)
         ->setHandler($defaultHandler)
         ->setConnectionPool($connectionPool)
         ->setSerializer($serializer)
         ->build();
        self::setConnection($_instance);
        return $_instance;
    }

    public static function getConnectionInstance()
    {
        if (isset(self::$objConnection)) {
            return self::$objConnection;
        } else {
            return self::connectToElastic();
        }
    }

    public static function setConnection($con)
    {
        self::$objConnection = $con;
    }

    public static function getConnection()
    {
        return self::$objConnection;
    }

    public function searchByProductId($id = null)
    {
        $objConnection::getConnection();
        if (null !== $id) {
            $json = '{
            "query": {
               "match": {
                 "product_id": "' . $id . '"
               }
              }
          }';
        } else {
            $json = $this->matchAll();
        }
        $params = [
         'index' => 'product_de',
         'type'  => 'default',
         'body'  => $json
        ];

        $result = $objElasticSearchConnection->search($params);
        return $result;
    }

    public function searchByCategoryId($id = null)
    {
        $objConnection::getConnection();
        if (null !== $id) {
            $json = '{
            "query": {
               "match": {
                 "category_id": "' . $id . '"
               }
              }
          }';
        } else {
            $json = $this->matchAll();
        }


        $params = [
         'index' => 'product_de',
         'type'  => 'default',
         'body'  => $json
        ];
        $result = $objElasticSearchConnection->search($params);
        return $result;
    }

    public function searchByCategoryName($name = null)
    {
        $objElasticConnection       = new ElasticConnection();
        $objElasticSearchConnection = $objElasticConnection::getConnection();
        if (NULL !== $name) {
            $json = '{
                    "query": {
                       "match": {
                         "category_name": "' . $name . '"
                       }
                      }
                  }';
        } else {

            $json = $this->matchAll();
        }

        $params = [
         'index' => 'product_de',
         'type'  => 'default',
         'body'  => $json
        ];
        $result = $objElasticSearchConnection->search($params);
        return $result;
    }

    public function fullTextSearch($text = null, $start, $end, $limit, $order = null)
    {
        $text                       = strtolower($text);
        $field                      = null;
        $objElasticConnection       = new ElasticConnection();
        $objElasticSearchConnection = $objElasticConnection::getConnection();
        if ($order == null) {
            $order = 'desc';
        }
        switch ($order) {
            case 'alpha':
                $order_by = "asc";
                $json     = '{
                "sort" : [
                    {"product_title": {"order":"' . $order_by . '"}},
                    "_score"
                ],
                "from" : "' . $start . '","size":"' . $limit . '",
                "query": ' . $this->querySearchJson($text) . '
                }';
                break;
            case 'alpha_reverse':
                $order_by = "desc";
                $json     = '{
                "sort" : [
                    {"product_title": {"order":"' . $order_by . '"}},
                    "_score"
                ],
                 "from" : "' . $start . '","size":"' . $limit . '",
                 "query": ' . $this->querySearchJson($text) . '

                }';
                break;
            case 'min_price':
                $field    = "product_taxed_price";
                $order_by = "asc";

                $json = '{
                    "sort" : [
                        {"' . $field . '": {"order":"' . $order_by . '"}}
                    ],
                     "from" : "' . $start . '","size":"' . $limit . '",
                     "query":  ' . $this->querySearchJson($text) . '
                 }';

                break;
            case 'max_price':
                $field    = "product_taxed_price";
                $order_by = "desc";
                $json     = '{
                    "sort" : [
                        {"' . $field . '": {"order":"' . $order_by . '"}}
                    ],
                     "from" : "' . $start . '","size":"' . $limit . '",
                     "query":  ' . $this->querySearchJson($text) . '
                }';
                break;
            default:
                $json     = '{
                    "sort" : [
                        {"created_at": {"order":"desc"}},
                        "_score"
                    ],
                     "from" : "' . $start . '","size":"' . $limit . '",
                     "query":  ' . $this->querySearchJson($text) . '                     
                }';
                break;
        }

        if ($field == NULL) {
            $field = "product_title";
        }


        $params = [
         'index' => 'product_de',
         'type'  => 'default',
         'body'  => ($text == NULL || $text == "") ? $this->matchAll($field, $order_by) : $json
        ];

        $result                          = $objElasticSearchConnection->search($params);
        $result['hits']['hits']['total'] = $result['hits']['total'];

        if ($result['hits']['total'] == 0) {
            $params                          = [
             'index' => 'product_de',
             'type'  => 'default',
             'body'  => ($text == NULL || $text == "") ? $this->matchAll($field, $order_by) : 
                                                         $this->matchQuery($text,$limit,$start)
            ];
            
            $result                          = $objElasticSearchConnection->search($params);
            $result['hits']['hits']['total'] = $result['hits']['total'];
        }

        return $result['hits']['hits'];
    }

    public function orderByPriceAsc()
    {

        $json = '
                "sort" : [
                { "product_taxed_price" : {"order" : "asc"}},
                "_score"
                ]';
        return $json;
    }

    public function orderByPriceDesc()
    {

        $json = '
                "sort" : [
                { "product_taxed_price" : {"order" : "desc"}},
                "_score"
                ]';

        return $json;
    }

    public function matchAll($field, $order_by)
    {

        $json = '{
          "sort" : [
                    {"' . $field . '": {"order":"' . $order_by . '"}},
                    "_score"
                ],
        "query" : {
                  "match_all" : {}
         }
       }';

        return $json;
    }

    public function querySearchJson($text)
    {
        return '{
                "bool": {
                  "should": [
                    {
                      "regexp": {
                        "product_title": {
                          "value": ".*' . $text . '+*"
                        }
                      }
                    },
                    {
                      "regexp": {
                        "product_description": {
                          "value": ".*' . $text . '.*"
                        }
                      }
                    },
                    {
                      "regexp": {
                        "brand_name": {
                          "value": ".*' . $text . '.*"
                        }
                      }
                    },
                    {
                      "regexp": {
                        "category_name": {
                          "value": ".*' . $text . '.*"
                        }
                      }
                    },
                    {
                      "regexp": {
                        "feature_title": {
                          "value": ".*' . $text . '.*"
                        }
                      }
                    },
                    {
                      "regexp": {
                        "feature_desc": {
                          "value": ".*' . $text . '.*"
                        }
                      }
                    }
                  ]
                }
              }';
    }

    public function matchQuery($text,$limit, $start)
    {
        $json = '
             {
              "sort": [
                {
                  "product_title": {
                    "order": "desc"
                  }
                }
              ], 
               "from" : "' . $start . '","size":"' . $limit . '",
                "query": {
                    "match_phrase" : {
                        "product_title" : {
                            "query" : "'.$text.'",
                            "analyzer" : "word_join_analyzer"
                        }
                    }
                }               
            }
              ';
        return $json;
    }
    
    
    public function mulitMatchQuery($text,$limit, $start)
    {
        $json = '
             {
              "sort": [
                {
                  "product_title": {
                    "order": "desc"
                  }
                }
              ], 
               "from" : "' . $start . '","size":"' . $limit . '",
                "query": {
                    "multi_match" : {                        
                            "query" : "'.$text.'",
                            "fields" : ["product_title", "product_description"]
                        }
                }
                
            }
              ';
        return $json;
    }

}
