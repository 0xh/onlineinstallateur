<?php

namespace HookAdminCrawlerDashboard\Controller;

use Doctrine\Common\Cache\FilesystemCache;
use HookAdminCrawlerDashboard\HookAdminCrawlerDashboard;
use Thelia\Controller\Admin\BaseAdminController;
use Thelia\Core\Security\AccessManager;
use Thelia\Model\ConfigQuery;
use Thelia\Model\CustomerQuery;
use Thelia\Model\OrderQuery;
use Thelia\Log\Tlog;

/**
 * Class CrawlerController
 * @package HookAdminCrawlerDashboard\Controller
 * @author Emanuel Plopu <emanuel.plopu@sepa.at>
 */
class CrawlerController extends BaseAdminController
{
    /**
     * Folder name for stats cache
     */
    const STATS_CACHE_DIR = "stats";

    /**
     * Key prefix for stats cache
     */
    const STATS_CACHE_KEY = "stats";

    const RESOURCE_CODE = "admin.crawler";
    


    public function loadDataAjaxAction()
    {
    	$crawler = new Crawler();
    	$crawler->setServiceLinks("https://geizhals.at/", "?fs=");
    	$crawler->setFirstResult("offer offer--shortly", "</div>");
    	$crawler->setPriceResult('gh_price">&euro; ', "</span>");
    	
    	$firstProduct = $crawler->findFirstProduct("4005176847981");
    	
    	/*
    	//init
    	$ch1 = curl_init("https://geizhals.at/?fs=4005176847981&in=");

    	
    //	$result1 = curl_exec($ch1); 
    	//curl_close ( $ch1 );
    	
    	$searchPathBase="https://geizhals.at/?fs=";//https://geizhals.at/?fs=4005176847981
    	$searchPathProduct=$searchPathBase."4005176847982";
    	
    	$ch1 = curl_init($searchPathProduct);
    	
    	$result1 = curl_exec($ch1); 
    	
    	
    	//Tlog::getInstance()->error("returnall".$result1);
    	
    	//get first result
    	$goToDivClass = explode($this->resultClass, $result1);
    	$firstResult = explode($this->resultClassClosing, $goToDivClass[1]);
    	*/
    	//get price from first result
    	
    	return $this->jsonResponse(json_encode(array('result'=>"|".$crawler->productPrice($firstProduct)."|",'cookies'=>$this->cookiefile)));
    }
    
    
    
    
}
