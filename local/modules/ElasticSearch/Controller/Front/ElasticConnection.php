<?php
namespace ElasticSearch\Controller\Front;
use Elasticsearch\ClientBuilder;


class  ElasticConnection {
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
        return $this->host;}
    
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
        if (is_array($params)){
            $this->setHost($params['host']);
            $this->setPort($params['port']);
            $this->setSchema($params['schema']);
            $this->setUser($params['user']);
            $this->setPass($params['pass']);
            self::connectToElastic($params);
        } else {
            $this->setHost("elasticsearch");
            $this->setPort("9200");
            $this->setSchema("http");
            $this->setUser("admin");
            $this->setPass("Aa123456");
        }        
        self::connectToElastic(array(
                        "host" => $this->getHost(),
                        "port" => $this->getPort(),
                        "schema" => $this->getSchema(),
                        "user" => $this->getUser(),
                        "pass" => $this->getPass()
                        )
                );
    }

 
    public static function connectToElastic($config){
        $_instance = ClientBuilder::create()
               ->setHosts($config)
               ->build();
       self::setConnection($_instance);
        return $_instance;
    }
    
   public static function getConnectionInstance(){
       if( isset(self::$objConnection)){
           return self::$objConnection;
       }else{
           return self::connectToElastic();
       }
   }
    
   public static function setConnection($con) {
       self::$objConnection = $con;
   }
   
   public static function getConnection(){
       return self::$objConnection;
   }
   
  
    
}
