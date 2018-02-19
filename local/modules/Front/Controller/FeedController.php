<?php
/*************************************************************************************/
/*      This file is part of the Thelia package.                                     */
/*                                                                                   */
/*      Copyright (c) OpenStudio                                                     */
/*      email : dev@thelia.net                                                       */
/*      web : http://www.thelia.net                                                  */
/*                                                                                   */
/*      For the full copyright and license information, please view the LICENSE.txt  */
/*      file that was distributed with this source code.                             */
/*************************************************************************************/


namespace Front\Controller;

use Doctrine\Common\Cache\FilesystemCache;
use Thelia\Controller\Front\BaseFrontController;
use Thelia\Core\HttpFoundation\Request;
use Thelia\Core\HttpFoundation\Response;
use Thelia\Model\BrandQuery;
use Thelia\Model\FolderQuery;
use Thelia\Model\CategoryQuery;
use Thelia\Model\ConfigQuery;
use Thelia\Model\Lang;
use Thelia\Model\LangQuery;
use Thelia\Log\Tlog;
use Thelia\Controller\Admin\ExportController;
use Thelia\Core\DependencyInjection\Compiler\RegisterSerializerPass;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Thelia\Model\ExportQuery;
use Faker\Test\Provider\TestableLorem;

/**
 * Controller uses to generate RSS Feeds
 *
 * A default cache of 2 hours is used to avoid attack. You can flush cache if you have `ADMIN` role and pass flush=1 in
 * query string parameter.
 *
 * @package Front\Controller
 * @author Julien Chanséaume <jchanseaume@openstudio.fr>
 */
class FeedController extends BaseFrontController {


    /**
     * Folder name for feeds cache
     */
    const FEED_CACHE_DIR = "feeds";

    /**
     * Key prefix for feed cache
     */

    /**
     * render the RSS feed
     *
     * @param $context string   The context of the feed : catalog, content. default: catalog
     * @param $lang string      The lang of the feed : fr_FR, en_US, ... default: default language of the site
     * @param $id string        The id of the parent element. The id of the main parent category for catalog context.
     *                          The id of the content folder for content context
     * @return Response
     * @throws \RuntimeException
     */
    //TODO generate error pages and not only pageNotFound
    public function generateAction($context, $lang, $id)
    {
    	$max_time = ini_get("max_execution_time");
    	ini_set('max_execution_time', 30000);
    	
        /** @var Request $request */
        $request = $this->getRequest();

        /** @var String $context */
        if ("" === $context){
            $context = "catalog";
        } else if (! in_array($context, array("catalog", "content", "brand")) ){
            $this->pageNotFound();
        }

        /** @var String $locale */
        if ("" !== $lang) {
            if (! $this->checkLang($lang)){
                $this->pageNotFound();
            }
        } else {
            try{
                $lang = Lang::getDefaultLanguage();
                $lang = $lang->getLocale();
            } catch (\RuntimeException $ex){
                // @todo generate error page
                throw new \RuntimeException("No default language is defined. Please define one.");
            }
        }
        //find language in db
        if (null === $lang = LangQuery::create()->findOneByLocale($lang)){
            $this->pageNotFound();
        }
        $lang = $lang->getId();

        // check if element exists and is visible
        if ("" !== $id){
            if (false === $this->checkId($context, $id)){
                $this->pageNotFound();
            }
        }

        $flush = $request->query->get("flush", "");
        $format = $request->query->get("format","xml");
        $platform = $request->query->get("platform","idealo");

        // check if feed already in cache
        $cacheContent = false;

        $cacheDir = $this->getCacheDir();
        $cacheKey = "feeds" . $lang . $context . $id . $format . $platform;
        $cacheExpire = 386400;//intval(ConfigQuery::read("feed_ttl", '7200')) ?: 7200;
        
        $cacheDriver = new FilesystemCache($cacheDir);
        // if admin is NOT logged in and the flush is NOT set then use cached version 
        if (!($this->checkAdmin() && "" !== $flush)){
            $cacheContent = $cacheDriver->fetch($cacheKey);
        } else {
            $cacheDriver->delete($cacheKey);
        }
        
        $response = new Response();
        
        if (false === $cacheContent){
            $contentType = "";
            
            if ($format == "csv"){
                $exportDBReference = "thelia.export.".$context.".".$platform;//ex: thelia.export.catalog.idealo
                
                //get export Object from DB based on reference
                $exportDBObject = ExportQuery::create()->findOneByRef($exportDBReference);
                
                if($exportDBObject === null)
                    $this->pageNotFound();
 
                //get the service for the thelia export handler
                /** @var \Thelia\Handler\ExportHandler $exportHandler */
                $exportHandler = $this->container->get('thelia.export.handler');
                $export = $exportHandler->getExport($exportDBObject->getId());//8 = catalog.idealo
                
                if ($export === null)
                    return $this->pageNotFound();
                
                /** @var \Thelia\Core\Serializer\SerializerManager $serializerManager */
                $serializerManager = $this->container->get(RegisterSerializerPass::MANAGER_SERVICE_ID);
                /** @var \Thelia\Core\Serializer\Serializer\CSVSerializer $serializer */
                $serializer = $serializerManager->get("thelia.csv");//
                if($platform == "preisroboterde")
                    $serializer->setDelimiter("|");
                
                $lang = (new LangQuery)->findPk($lang);
                $exportEvent = $exportHandler->export(
                    $export,$serializer,null, $lang,false,false, null);
                
                /** $var \Thelia\Core\Archiver\ArchiverInterface $archiver */
                $archiver = $exportEvent->getArchiver();
                if ($archiver !== null) {
                    $contentType = $exportEvent->getArchiver()->getMimeType();
                    $fileExt = $exportEvent->getArchiver()->getExtension();
                }
                else {
                    /** @var \Thelia\Core\Serializer\SerializerInterface $serializer */
                    $serializer = $exportEvent->getSerializer();
                    $contentType = $serializer->getMimeType();
                    $fileExt = $serializer->getExtension();
                }
                ob_start();
                $fileSize = readfile($exportEvent->getFilePath());
                $cacheContent = ob_get_clean();
                $cacheContent = mb_convert_encoding($cacheContent,'UTF-8', 'auto'); 
                
                $contentDisposition = sprintf(
                    '%s; filename="%s.%s"',
                    ResponseHeaderBag::DISPOSITION_ATTACHMENT,
                    "export_".$platform,
                    $format);
               
              //  $response->headers->set('Content-Disposition' , $contentDisposition);
            }
            else{
                // render the view
                $cacheContent = $this->renderRaw(
                    "feed-google",
                    array(
                        "_context_" => $context,
                        "_lang_"    => $lang,
                        "_id_"      => $id));
                
            }
            $cacheDriver->save($cacheKey, $cacheContent, $cacheExpire);  
        };
        
        if($format == "csv"){
            $contentType = 'application/rss+xml';
        }
        else{
            $contentType = 'application/rss+xml';
        }
 
        $response->setContent($cacheContent);
        $response->headers->set('Content-Type', $contentType);
        //return new BinaryFileResponse($cacheContent, 200, $header, false);
        
        ini_set('max_execution_time', $max_time); 
        return $response;
    }


    /**
     * get the cache directory for feeds
     *
     * @return mixed|string
     */
    protected function getCacheDir()
    {
        $cacheDir = $this->container->getParameter("kernel.cache_dir");
        $cacheDir = rtrim($cacheDir, '/');
        $cacheDir .= '/' . self::FEED_CACHE_DIR . '/';
        return $cacheDir;
    }

    /**
     * Check if current user has ADMIN role
     *
     * @return bool
     */
    protected function checkAdmin(){
        return $this->getSecurityContext()->hasAdminUser();
    }


    /**
     * Check if a lang is used
     *
     * @param $lang string  The lang code. e.g.: fr
     * @return bool         true if the language is used, otherwise false
     */
    private function checkLang($lang)
    {
        // load locals
        $lang = LangQuery::create()
            ->findOneByLocale($lang);

        return (null !== $lang);
    }


    /**
     * Check if the element exists and is visible
     *
     * @param $context string   catalog or content
     * @param $id string        id of the element
     * @return bool
     */
    private function checkId($context, $id)
    {
        $ret = false;
        if (is_numeric($id)){
            if ("catalog" === $context){
                $cat = CategoryQuery::create()->findPk($id);
                $ret = (null !== $cat && $cat->getVisible());
            } elseif ("brand" === $context) {
                $brand = BrandQuery::create()->findPk($id);
                $ret = (null !== $brand && $brand->getVisible());
            } else {
                $folder = FolderQuery::create()->findPk($id);
                $ret = (null !== $folder && $folder->getVisible());
            }
        }
        return $ret;
    }
}