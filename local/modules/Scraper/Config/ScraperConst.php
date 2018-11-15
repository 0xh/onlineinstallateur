<?php

namespace Scraper\Config;

/**
 * Description of ScraperConst
 *
 * @author Catana Florin
 */
class ScraperConst
{

    const SCRAPER_COOKIE_DIR = THELIA_LOCAL_DIR . "modules" . DS . "Scraper" . DS . "Cookies" . DS;
    const SCRAPER_IMAGES_DIR = THELIA_LOCAL_DIR . "modules" . DS . "Scraper" . DS . "Images" . DS;
    const SCRAPER_VIDEO_DIR  = THELIA_LOCAL_DIR . "modules" . DS . "Scraper" . DS . "Video" . DS;
    const SCRAPER_ARHIVE_DIR = THELIA_LOCAL_DIR . "modules" . DS . "Scraper" . DS . "Arhive" . DS;
    const SCRAPER_LOG_DIR    = THELIA_LOCAL_DIR . "modules" . DS . "Scraper" . DS . "Log" . DS;
    const HDOM_TYPE_ELEMENT  = 1;
    const HDOM_TYPE_COMMENT  = 2;
    const HDOM_TYPE_TEXT     = 3;
    const HDOM_TYPE_ENDTAG   = 4;
    const HDOM_TYPE_ROOT     = 5;
    const HDOM_TYPE_UNKNOWN  = 6;
    const HDOM_QUOTE_DOUBLE  = 0;
    const HDOM_QUOTE_SINGLE  = 1;
    const HDOM_QUOTE_NO      = 3;
    const HDOM_INFO_BEGIN    = 0;
    const HDOM_INFO_END      = 1;
    const HDOM_INFO_QUOTE    = 2;
    const HDOM_INFO_SPACE    = 3;
    const HDOM_INFO_TEXT     = 4;
    const HDOM_INFO_INNER    = 5;
    const HDOM_INFO_OUTER    = 6;
    const HDOM_INFO_ENDSPACE = 7;
    const SCRAPER_REUTER  = "Reuter";
    const SCRAPER_SKYBAD  = "Skybad";
    const SCRAPER_MEGABAD = "Megabad";

}
