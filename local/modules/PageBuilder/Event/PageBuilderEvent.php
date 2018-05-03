<?php

namespace PageBuilder\Event;

use PageBuilder\Model\PageBuilder;
use Thelia\Core\Event\ActionEvent;

class PageBuilderEvent extends ActionEvent
{

    /*---- GENERAL parts */
    protected $id;
    protected $title;
    protected $chapo;
    protected $header;
    protected $footer;
    protected $postscriptum;

    /*---- SEO parts */
    protected $url;
    protected $meta_title;
    protected $meta_description;
    protected $meta_keywords;

    /*---- LOCAL parts */
    protected $locale;
    protected $currentLocale;

    /** @var PageBuilder $pageBuilder  */
    protected $pageBuilder;

    /*----------------------------- General parts */
    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    public function getChapo()
    {
        return $this->chapo;
    }

    public function setChapo($chapo)
    {
        $this->chapo = $chapo;

        return $this;
    }

    public function getHeader()
    {
        return $this->header;
    }

    public function setHeader($header)
    {
        $this->header = $header;

        return $this;
    }

    public function getFooter()
    {
        return $this->footer;
    }

    public function setFooter($footer)
    {
        $this->footer = $footer;

        return $this;
    }

    public function getPostscriptum()
    {
        return $this->postscriptum;
    }

    public function setPostscriptum($postscriptum)
    {
        $this->postscriptum = $postscriptum;

        return $this;
    }

    public function getLocale()
    {
        return $this->locale;
    }

    public function setLocale($locale)
    {
        $this->locale = $locale;
        return $this;
    }


    /*----------------------------- SEO EVENT PARTS */
    public function getUrl()
    {
        return $this->url;
    }

    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    public function getMetaTitle()
    {
        return $this->meta_title;
    }

    public function setMetaTitle($meta_title)
    {
        $this->meta_title = $meta_title;

        return $this;
    }

    public function getMetaDescription()
    {
        return $this->meta_description;
    }

    public function setMetaDescription($meta_description)
    {
        $this->meta_description = $meta_description;

        return $this;
    }

    public function getMetaKeywords()
    {
        return $this->meta_keywords;
    }

    public function setMetaKeywords($meta_keywords)
    {
        $this->meta_keywords = $meta_keywords;

        return $this;
    }

    /*----------------------------- PageBuilder object Parts*/
    public function __construct(PageBuilder $pageBuilder = null)
    {
        $this->pageBuilder = $pageBuilder;
    }

    public function getPageBuilder()
    {
        return $this->pageBuilder;
    }

    public function setPageBuilder($pageBuilder)
    {
        $this->pageBuilder = $pageBuilder;

        return $this;
    }

    public function hasPageBuilder()
    {

        return ! is_null($this->pageBuilder);
    }
}
