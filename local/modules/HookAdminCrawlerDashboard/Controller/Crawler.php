<?php

namespace HookAdminCrawlerDashboard\Controller;

use Thelia\Log\Tlog;

/**
 * Class Crawler
 * @package HookAdminCrawlerDashboard\Controller
 * @author Emanuel Plopu <emanuel.plopu@sepa.at>
 */
class Crawler 
{
	const TAG = "crawler";
	private $cookiefile;
	private $debug = false;
	private $sampleData = false;
	
	private $baseUrl ="https://geizhals.at/";
	private $searchPath ="?fs=";
	private $notFoundMarker = "";
	private $productResultStartMarker = "offer offer--shortly";
	private $productResultEndMarker = "</div>";
	private $productPriceStartMarker = 'gh_price">&euro; ';
	private $productPriceEndMarker = "</span>";
	private $hausfabrikOfferStartMarker = "";
	private $hausfabrikOfferEndMarker = "";
	private $sslCertificate = THELIA_CONF_DIR."key".DS."cacert.pem";
	
	private $userAgents = array(1 => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_3) AppleWebKit/601.4.4 (KHTML, like Gecko) Version/9.0.3 Safari/601.4.4',
			2 => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2767.4 Safari/537.36',
			3 => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36',
			4 => 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:40.0) Gecko/20100101 Firefox/40.1',
			5 => 'Mozilla/5.0 (Windows NT 6.3; rv:36.0) Gecko/20100101 Firefox/36.0',
			6 => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10; rv:33.0) Gecko/20100101 Firefox/33.0',
			7 => 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2228.0 Safari/537.36',
			8 => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2227.1 Safari/537.36',
			9 => 'Opera/9.80 (X11; Linux i686; Ubuntu/14.10) Presto/2.12.388 Version/12.16',
			10 => 'Opera/12.80 (Windows NT 5.1; U; en) Presto/2.10.289 Version/12.02',
			11 => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_3) AppleWebKit/537.75.14 (KHTML, like Gecko) Version/7.0.3 Safari/7046A194A',
			12 => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_6_8) AppleWebKit/537.13+ (KHTML, like Gecko) Version/5.1.7 Safari/534.57.2'
	);
	
	
	public function setServiceLinks($baseUrl,$searchPath){
		$this->baseUrl = $baseUrl;
		$this->searchPath = $searchPath;
	}
	
	public function setProductResultMarker($start,$end){
		$this->productResultEndMarker = $start;
		$this->productResultEndMarker = $end;
	}
	
	public function setPriceResultMarker($start,$end){
		$this->productPriceStartMarker = $start;
		$this->productPriceEndMarker = $end;
	}
	
	public function setSSLCertificateFile($certificate){
		$this->sslCertificate = $certificate;
	}
	
	public function setHausfabrikOfferMarker($start,$end){
		$this->hausfabrikOfferStartMarker = $start;
		$this->hausfabrikOfferEndMarker = $end;
	}
	
	public function init($debugMode, $sampleData){
		$this->debug = $debugMode;
		$this->sampleData = $sampleData;
	}
	
	private function setChannelOptions($channel){
		curl_setopt( $channel, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $channel, CURLOPT_AUTOREFERER, true );
		curl_setopt( $channel, CURLOPT_FOLLOWLOCATION, true );
		curl_setopt( $channel, CURLOPT_COOKIEJAR, $this->cookiefile);
		curl_setopt( $channel, CURLOPT_COOKIEFILE, $this->cookiefile);
		curl_setopt( $channel, CURLOPT_USERAGENT, $this->userAgents[rand(1,12)]);
		curl_setopt( $channel, CURLOPT_CAINFO, THELIA_CONF_DIR."key".DS."cacert.pem");
		return $channel;
	}
	
	public function searchByEANCode($ean_code){
		if(!$this->sampleData){
			$url = $this->baseUrl.$this->searchPath.$ean_code;
			$channel = curl_init($url);
			$channel = $this->setChannelOptions($channel);
			$this->request = curl_exec($channel);
		}
		
		return $this->request;
	}
	
	public function getFirstProduct($request){
		Tlog::getInstance()->error(sprintf(self::TAG.' message "%s"',$this->productResultStartMarker));

		$removeBeforePart = explode($this->productResultStartMarker, $this->request);
		
		$removeAfterPart = explode($this->productResultEndMarker, $removeBeforePart[1]);
		//,'error'=>curl_error ( $ch1 )
		return $removeAfterPart[0];
	}
	
	public function getProductPrice($productResult){
		$removeBeforePart = explode($this->productPriceStartMarker, $productResult);
		$removeAfterPart = explode($this->productPriceEndMarker, $removeBeforePart[1]);
		
		return $removeAfterPart[0];
	}
	
   public function getHausfabrikOfferPosition($request){
   	//count 
   	return 1;
   }
	
	
	
	
	
	
	
	
	private $request = '<!DOCTYPE HTML><html lang="de"><head>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>19468000 GROHE Grohtherm 3000 Cosmopolitan Wandarmatur spiegelnder Glanz und viel Funktion Dieses runde spiegelnd sch&ouml;ne Bedienelement passt zu allen GROHE Cosmopolitan Badserien. Mit den zylindrischen Griffen regeln Sie bequem Wassertemperatur und -menge. Nach Bedarf wechseln Sie mit dem integrierten AquaDimmer zwischen Wannenzulauf und Brause oder zwischen Kopf- und Handbrause. Die SafeStop Taste verhindert dabei ein versehentliches Einstellen zu hei&szlig;er Wassertemperaturen. G&ouml;nnen Sie sich ... Preisvergleich &#124; Geizhals &Ouml;sterreich</title>
<meta name="description" content="Preisvergleich, Bewertungen f&uuml;r 19468000 GROHE Grohtherm 3000 Cosmopolitan Wandarmatur spiegelnder Glanz und viel Funktion Dieses runde spiegelnd sch&ouml;ne Bedienelement passt zu allen GROHE Cosmopolitan Badserien. Mit den zylindrischen Griffen regeln Sie bequem Wassertemperatur und -menge. Nach Bedarf wechseln Sie mit dem integrierten AquaDimmer zwischen Wannenzulauf und Brause oder zwischen Kopf- und Handbrause. Die SafeStop Taste verhindert dabei ein versehentliches Einstellen zu hei&szlig;er Wassertemperaturen. G&ouml;nnen Sie sich ... (&Ouml;sterreich)">
			
<style>html {margin: 0;}</style>
<!--[if lt IE 9]>
<script src="///b/js/html5-els.js"></script>
<!--[if (IE 7)|(IE 8)]>
<link rel="stylesheet" href="///b/icomoon/ie7/ie7.css">
<script src="///b/icomoon/ie7/ie7.js"></script>
<![endif]-->
<link rel=stylesheet type="text/css" href="///gsa/_e9b8589b0a/geizhals_pak.css">
<script>var _gh_storage={isMobile:false}; var _gh_pre = {}; _gh_pre.addLoadEvent = function(fn){if(window.addEventListener){window.addEventListener("load", fn, false);} else if(window.attachEvent){window.attachEvent("onload", fn);}}; function gh_addLoadEvent(f) {_gh_pre.addLoadEvent(f);}</script><script src="///gsa/_e9b8589b0a/js/gh_std.js" async="true"></script>
<script type="text/javascript">
var googletag = googletag || {};
googletag.cmd = googletag.cmd || [];
(function() {
var gads = document.createElement("script");
gads.async = true;
gads.type = "text/javascript";
var useSSL = "https:" == document.location.protocol;
gads.src = (useSSL ? "https:" : "http:") +
"//www.googletagservices.com/tag/js/gpt.js";
var node = document.getElementsByTagName("script")[0];
node.parentNode.insertBefore(gads, node);
})();
			
googletag.cmd.push(function() {
    googletag.pubads().collapseEmptyDivs(true);
});
</script>
<script type="text/javascript" src="//libs.de.coremetrics.com/eluminate.js"></script><script type="text/javascript">CM_DDX.headScripts = false; cmSetClientID("51730000|geizhals.at", true, "data.de.coremetrics.com", "geizhals.at");</script>
<link rel="SHORTCUT ICON" HREF="///b/geizhals-favicon.ico">
<link rel="search" type="application/opensearchdescription+xml" title="Suche auf Geizhals.at" href="/xmlsux"/>
<meta http-equiv="P3P" content="CP="NOI CURa ADMa DEVa TAIa OUR BUS IND UNI COM NAV INT"">
<meta name="robots" content="NOINDEX, FOLLOW"><!-- geizhals.at=gh_at 023321;93 z9hE1qa5m8wYdyzXelnzJ-fFiDs -->
<link rel="canonical" href="https://geizhals.at/146767602" />
</head><!-- starttrans -->
<body id="ghbody" class="">
			
<div id="gh_wrap" class="">
    <div id="gh_main">
<script type="text/javascript">
    _gh_pre.addLoadEvent(function(){_gh.do_focus(1,0);});
</script>
<div id=gh_hdr>
			
    <div id=gh_hdr_toplogo>
        <a href="./" target=_top title="Geizhals" onclick="_gh.cm.event("header_click","2", "Logo", "0");"><img src="///b/gh_logo_top.png" alt="Zum Preisvergleich"></a>
    </div>
    <div id=hdr_right>
        <div id=gh_hdr_toplinks>
            <a class=gh_toplinks
       href="./?o=1"
			
			
			
       onclick="_gh.cm.event("header_click","2", "Wunschlisten", "0");">Wunschlisten</a> &middot; <a class=gh_toplinks
       href="https://forum.geizhals.at/"
			
			
			
       onclick="_gh.cm.event("header_click","2", "Forum", "0");">Forum</a> &middot; <a class=gh_toplinks
       href="https://geizhalsblog.wordpress.com"
         rel="nofollow"
			
			
       onclick="_gh.cm.event("header_click","2", "Blog", "0");">Blog</a> &middot; <a class=gh_toplinks
       href="https://geizhals.at/kleinanzeigen/"
			
			
			
       onclick="_gh.cm.event("header_click","2", "Kleinanzeigen", "0");">Kleinanzeigen</a> &middot; <a class=gh_toplinks
       href="./?cat=top100"
			
			
			
       onclick="_gh.cm.event("header_click","2", "Top-100", "0");">Top-100</a> &middot; <a class=gh_toplinks
       href="./?trends"
			
			
			
       onclick="_gh.cm.event("header_click","2", "Trends", "0");">Trends</a> &middot; <a class=gh_toplinks
       href="./?bpnew=2"
			
			
			
       onclick="_gh.cm.event("header_click","2", "Neue Bestpreise", "0");">Neue Bestpreise</a> &middot; <a class=gh_toplinks
       href="./?hlist"
         rel="nofollow"
			
			
       onclick="_gh.cm.event("header_click","2", "H&auml;ndlerliste", "0");">H&auml;ndlerliste</a> &middot; <a class=gh_toplinks
       href="./?help"
			
			
			
       onclick="_gh.cm.event("header_click","2", "Hilfe", "0");">Hilfe</a> &middot;
<a href="./?conf" rel="nofollow" onclick="_gh.cm.event("header_click","2", "Einstellungen", "0");"><img width=16 height=16 src=///b/cog2.png style="vertical-align: middle" alt="Einstellungen"></a> &middot;    <a class=gh_toplinks
       href="https://forum.geizhals.at/login.jsp?from=https://geizhals.at"
         rel="nofollow"
			
         id="gh__login-trigger"
       onclick="_gh.cm.event("header_click","2", "Login/Registrierung", "0");">Login/Registrierung</a>
    <script type="text/javascript">
    (function(){
        window._gh_storage.login={
            language: "de",
            pagename: "Geizhals",
            fbid: "187516274649278",
            clientId: "geizhals.at",
            autofocus: true,
            reset: {
                userId: "",
                resetToken: ""
            }
        };
        var loginEl = document.getElementById("gh__login-trigger");
        var prematureClick = function(e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            window._gh_storage.clickedLogin = true;
            return false;
        };
        var autotrigger = false;
			
        loginEl.addEventListener("click", prematureClick);
        _gh_pre.addLoadEvent(function() {
            loginEl.removeEventListener("click", prematureClick);
            if(autotrigger || window._gh_storage.clickedLogin) _gh.loginInject.inject();
            loginEl.addEventListener("click", _gh.loginInject.triggerInject.bind(_gh.loginInject));
        });
    })();
</script>    &nbsp;<img src=///b/ds_fb2.png width=15 height=15 alt="Facebook Connect" title="Facebook Connect" style="vertical-align: middle">
        </div>
        <div id=gh_center_search>
            <form method=get action="./" name=sform accept-charset="iso-8859-1" id=gh_searchform>
                <div class=gh_srch_wrp>
                    <input  id=fs
        data-acs="acses?lang=de&amp;loc=at&amp;k="
        placeholder="Suche ..."
        type=text
        name=fs
        accesskey=q
        value=""
     size=35 class=gh_searchfld
			
>
<script>_gh_pre.addLoadEvent(function(){var t=_gh.ref_arg("fs"); var v=document.forms["gh_searchform"].elements["fs"]; if (t && !v.value) v.value=t;})</script>
                    <div id="gh_srch_ctrls">
                        <span class="gh_scat_wrp">
                        <select
         class=gh_searchkat
        name="in"
        onchange="_gh.cm.event("search_in_category","2", event.target.value, "0");">
    <option value="">in allen Kategorien</option>        <option value="1"        >in Hardware</option>        <option value="2"        >in Software</option>        <option value="3"        >in Games</option>        <option value="4"        >in Video/Foto/TV</option>        <option value="5"        >in Telefon &amp; Co</option>        <option value="6"        >in Audio/HIFI</option>        <option value="7"        >in Filme</option>        <option value="8"        >in Haushalt</option>        <option value="9"        >in Sport &amp; Freizeit</option>        <option value="10"        >in Drogerie</option>        <option value="11"        >in Auto &amp; Motorrad</option>        <option value="12"        >in Spielzeug &amp; Modellbau</option>        <option value="13"        >in Baumarkt &amp; Garten</option></select>
                        </span>
                        <button type=submit
			
        class=gh_searchbt
        id="gh_suchen_bt_i"
        title="Suchen"
        value="&nbsp;"
        onclick="_gh.cm.event("header_click","2", "start_search_click", "0");">
</button>
                    </div>
                    <div id=acbox><h3 id=act1></h3><ul id=acl1></ul><h3 id=act2></h3><ul id=acl2></ul><h3 id=act3></h3><ul id=acl3></ul><div id=fs_more></div></div>
<script>
    _gh_pre.addLoadEvent(function(){
        document.getElementById("fs").setAttribute("autocomplete","off");
        _gh.ghac.init("de");
    });
</script>
                    <div class=clr></div>
                </div>
                <div id="searchtype"></div>
            </form>
        </div>
    </div>
    <div class=clr></div>
    <div id=gh_hdr_tabs>
    <nav>
        <ul id=gh_tabs>                <li class="gh_tabs">
                    <a class=gh_tabs
                       href="./?m=1"
                       title="Notebooks Tablets Systeme Monitore Grafikkarten CPUs Festplatten"
                       onclick="_gh.cm.event("topnav_click","2", "Hardware", "0");">Hardware</a>
                </li>
                            <li class="gh_tabs">
                    <a class=gh_tabs
                       href="./?m=2"
                       title="Betriebssysteme Windows Office AntiVirus Internet Security"
                       onclick="_gh.cm.event("topnav_click","2", "Software", "0");">Software</a>
                </li>
                            <li class="gh_tabs">
                    <a class=gh_tabs
                       href="./?m=3"
                       title="PS4 Xbox One 1st Person Nintendo WiiU 3DS"
                       onclick="_gh.cm.event("topnav_click","2", "Games", "0");">Games</a>
                </li>
                            <li class="gh_tabs">
                    <a class=gh_tabs
                       href="./?m=4"
                       title="Fernseher Kameras Camcorder Receiver SAT Beamer"
                       onclick="_gh.cm.event("topnav_click","2", "Video/Foto/TV", "0");">Video/Foto/TV</a>
                </li>
                            <li class="gh_tabs">
                    <a class=gh_tabs
                       href="./?m=5"
                       title="Smartphones Handys H&uuml;llen Festnetztelefone Smartwatches Freisprecheinrichtungen"
                       onclick="_gh.cm.event("topnav_click","2", "Telefon &amp; Co", "0");">Telefon &amp; Co</a>
                </li>
                            <li class="gh_tabs">
                    <a class=gh_tabs
                       href="./?m=6"
                       title="Portable Lautsprecher Receiver Kopfh&ouml;rer Headsets Surroundsysteme Kompaktanlagen"
                       onclick="_gh.cm.event("topnav_click","2", "Audio/HIFI", "0");">Audio/HIFI</a>
                </li>
                            <li class="gh_tabs">
                    <a class=gh_tabs
                       href="./?m=7"
                       title="Blu-ray DVD 3D Action Kom&ouml;die Spielfilme "
                       onclick="_gh.cm.event("topnav_click","2", "Filme", "0");">Filme</a>
                </li>
                            <li class="gh_tabs">
                    <a class=gh_tabs
                       href="./?m=8"
                       title="K&uuml;hlschr&auml;nke Geschirrsp&uuml;ler Waschmaschinen Staubsauger LEDs Baby"
                       onclick="_gh.cm.event("topnav_click","2", "Haushalt", "0");">Haushalt</a>
                </li>
                            <li class="gh_tabs">
                    <a class=gh_tabs
                       href="./?m=9"
                       title="Funktionsbekleidung Outdoor Fahrr&auml;der Fu&szlig;ball Rucks&auml;cke Snowboard Ski"
                       onclick="_gh.cm.event("topnav_click","2", "Sport &amp; Freizeit", "0");">Sport &amp; Freizeit</a>
                </li>
                            <li class="gh_tabs">
                    <a class=gh_tabs
                       href="./?m=10"
                       title="Zahnb&uuml;rsten Rasierer Parf&uuml;ms Make-Up Medikation Kondome Kontaktlinsen"
                       onclick="_gh.cm.event("topnav_click","2", "Drogerie", "0");">Drogerie</a>
                </li>
                            <li class="gh_tabs">
                    <a class=gh_tabs
                       href="./?m=11"
                       title="Reifen Autokamera Navigation Lautsprecher Dachboxen Helme Transportsysteme"
                       onclick="_gh.cm.event("topnav_click","2", "Auto &amp; Motorrad", "0");">Auto &amp; Motorrad</a>
                </li>
                            <li class="gh_tabs">
                    <a class=gh_tabs
                       href="./?m=12"
                       title="Quadrocopter Lego Playmobil Kinderfahrzeuge Gesellschaftsspiele"
                       onclick="_gh.cm.event("topnav_click","2", "Spielzeug &amp; Modellbau", "0");">Spielzeug &amp; Modellbau</a>
                </li>
                            <li class="gh_tabs">
                    <a class=gh_tabs
                       href="./?m=13"
                       title="Werkzeug Garten Griller Home-Automation"
                       onclick="_gh.cm.event("topnav_click","2", "Baumarkt &amp; Garten", "0");">Baumarkt &amp; Garten</a>
                </li>
                    </ul>
    </nav>
</div>
</div><script type="text/javascript">googletag.cmd.push(function() {
var ghwidth = window.document.body.offsetWidth;
googletag.defineSlot("/6514/www.geizhals.at"+(window._gh_top_category_path || "/unsortierter-artikel"), [[320,50]], "div-gpt-ad-appendix").addService(googletag.pubads());
if (ghwidth > 600) {googletag.defineSlot("/6514/www.geizhals.at"+(window._gh_top_category_path || "/unsortierter-artikel"), [[180,150]], "div-gpt-ad-leftrect").addService(googletag.pubads());
}if (ghwidth > 1200) {googletag.defineSlot("/6514/www.geizhals.at"+(window._gh_top_category_path || "/unsortierter-artikel"), [[728,90],[970,90]], "div-gpt-ad-top").addService(googletag.pubads());
} else if (ghwidth > 960) {googletag.defineSlot("/6514/www.geizhals.at"+(window._gh_top_category_path || "/unsortierter-artikel"), [[728,90]], "div-gpt-ad-top").addService(googletag.pubads());
}googletag.pubads().enableSingleRequest();googletag.enableServices();
if(window._gh_gpa_price_range) {
    googletag.pubads().setTargeting("preis",window._gh_gpa_price_range);
}
googletag.pubads().addEventListener("slotRenderEnded", function(event) {
    if (!event.isEmpty) {
		document.getElementById(event.slot.getSlotElementId()).className += " gh-ad__loaded";
	}
});
});</script>
<div id=gh_statline>
    <span id=gh_flags_search>            <img width=32 height=22 class=mid src="///b/austria.gif" alt="&Ouml;sterreich (aktiv)" title="Angebote verf&uuml;gbar in &Ouml;sterreich (aktiv)">                    <a href="//geizhals.eu/146767602" onclick="_gh.cm.event("flag_click","2", "EU", "0");">            <img width=32 height=22 class=mid src="///b/eu_bev.gif" alt="EU" title="Alle Angebote">            </a>                    <a href="//geizhals.de/146767602" onclick="_gh.cm.event("flag_click","2", "Deutschland", "0");">            <img width=32 height=22 class=mid src="///b/germany_bev.gif" alt="Deutschland" title="Angebote verf&uuml;gbar in Deutschland">            </a>            </span>
    <span id=gh_brcr><span itemscope itemtype="http://schema.org/BreadcrumbList">
<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
<meta itemprop="position" content="1" />
<a class="gh_statline" itemprop="item" href="./" onclick="_gh.cm.event("breadcrumb_top_click","2", "", "0");" ><span itemprop="name">Geizhals (&Ouml;sterreich)</span></a>
</span> &raquo;
<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
<meta itemprop="position" content="2" />
<meta itemprop="name" content="Unsortierter Artikel" />Unsortierter Artikel
</span></span></span>    <div class=clr></div>
</div><!-- top-end -->
			
			
<div id=gh_leftnav>
<style>
.subitem { margin-left: 1em; }
.sidebar_link { font-weight: bold; }
</style>
<nav>
<ul class=ghnav>
<li class="ghnavi">
    <a href="./?m=1" class="n" title="Zeige Unterkategorien der Kategorie Hardware">Hardware</a>
</li>
<li class="ghnavi">
    <a href="./?m=2" class="n" title="Zeige Unterkategorien der Kategorie Software">Software</a>
</li>
<li class="ghnavi">
    <a href="./?m=3" class="n" title="Zeige Unterkategorien der Kategorie Games">Games</a>
</li>
<li class="ghnavi">
    <a href="./?m=4" class="n" title="Zeige Unterkategorien der Kategorie Video/Foto/TV">Video/Foto/TV</a>
</li>
<li class="ghnavi">
    <a href="./?m=5" class="n" title="Zeige Unterkategorien der Kategorie Telefon &amp; Co">Telefon &amp; Co</a>
</li>
<li class="ghnavi">
    <a href="./?m=6" class="n" title="Zeige Unterkategorien der Kategorie Audio/HIFI">Audio/HIFI</a>
</li>
<li class="ghnavi">
    <a href="./?m=7" class="n" title="Zeige Unterkategorien der Kategorie Filme">Filme</a>
</li>
<li class="ghnavi">
    <a href="./?m=8" class="n" title="Zeige Unterkategorien der Kategorie Haushalt">Haushalt</a>
</li>
<li class="ghnavi">
    <a href="./?m=9" class="n" title="Zeige Unterkategorien der Kategorie Sport &amp; Freizeit">Sport &amp; Freizeit</a>
</li>
<li class="ghnavi">
    <a href="./?m=10" class="n" title="Zeige Unterkategorien der Kategorie Drogerie">Drogerie</a>
</li>
<li class="ghnavi">
    <a href="./?m=11" class="n" title="Zeige Unterkategorien der Kategorie Auto &amp; Motorrad">Auto &amp; Motorrad</a>
</li>
<li class="ghnavi">
    <a href="./?m=12" class="n" title="Zeige Unterkategorien der Kategorie Spielzeug &amp; Modellbau">Spielzeug &amp; Modellbau</a>
</li>
<li class="ghnavi">
    <a href="./?m=13" class="n" title="Zeige Unterkategorien der Kategorie Baumarkt &amp; Garten">Baumarkt &amp; Garten</a>
</li>
</ul>
</nav>
			
    <div class="nl_box"><br/>
        <b>Newsletter</b><br/>
        (<a href="//unternehmen.geizhals.at/about/de/info/kontakt-und-impressum/#newsletter" target="_blank">Mehr dar&uuml;ber...</a>)
        <form method=post  onsubmit="return _gh.nl_submit(this.form)">
            <input type=hidden name=newsletter_registration value=1>
            <input type=email name=email id="nl_email" placeholder=E-Mail class="emailInput" required>
            <input type=submit value=anmelden class="submit">
        </form>
        <span id="pleaseFill">Bitte eine g&uuml;ltige E-Mail-Adresse eingeben.</span>
    </div>
			
<div class=gh_stat_nav>Letzte Aktualisierung: <nobr>14.06.2017, 15:50</nobr></div>
<div class="gha_leftnav">
    <div id="div-gpt-ad-leftrect">
        <script type="text/javascript">
            gh_addLoadEvent(function() {_gh.stickyAd.init();});
            googletag.cmd.push(function() { googletag.display("div-gpt-ad-leftrect"); });
        </script>
    </div>
</div>
			
			
</div>
<div id=gh_content_wrapper>
    <!-- templated v5 -->
			
			
        <div id="div-gpt-ad-top" class="gha_lead">
        <script type="text/javascript">
            window._gh_gpa_price_range = [] ;
            googletag.cmd.push(function() {
                googletag.display("div-gpt-ad-top");
            });
        </script>
        <span class="gh-ad__disclaimer">Werbung</span><span class="gh-ad__close" onclick="_gh.closeStickyBottomAd(event)"></span>
    </div>
			
			
    <div id="gh_artbox" itemscope itemtype="http://schema.org/Product">
        <link itemprop="url" href="146767602" />
			
			
			
<a name="art"></a>
			
			
    <a NAME="146767602"></a>
    <b itemprop="name">19468000 GROHE Grohtherm 3000 Cosmopolitan Wandarmatur spiegelnder Glanz und viel Funktion Dieses runde spiegelnd sch&ouml;ne Bedienelement passt zu allen GROHE Cosmopolitan Badserien. Mit den zylindrischen Griffen regeln Sie bequem Wassertemperatur und -menge. Nach Bedarf wechseln Sie mit dem integrierten AquaDimmer zwischen Wannenzulauf und Brause oder zwischen Kopf- und Handbrause. Die SafeStop Taste verhindert dabei ein versehentliches Einstellen zu hei&szlig;er Wassertemperaturen. G&ouml;nnen Sie sich ...</b>
			
			
			
    <br>
			
<div class="clr npm"></div>
			
			
			
			
    <div style="clear: left; float:left" id="gh_proddesc_left">
			
			
        <div id=gh_prod_misc_controls>
			
                <form method=post accept-charset="iso-8859-1" action="146767602" id="gh_wl_save_form">
                    <nobr><input type="hidden" name="a" value="146767602"  /><input type="hidden" name="merke" value="146767602"  /></nobr>
                    <select name="wl"  class="minibutt" id="gh_wl_save_select" style="width: 150px">
<option title="Wunschliste zum Speichern ausw&auml;hlen" disabled="disabled" value="-">--- Wunschliste w&auml;hlen: ---</option>
<option title="Meine Wunschliste" value="WL">Meine Wunschliste</option>
</select><input type=hidden name=csrf value="DB685132-5108-11E7-ABFB-8F0EC32C3D63">
			
                    <input type="submit" class="gh_wl_save_bt" id="gh_wl_save_bt_i" value=" speichern "
                           onclick="_gh.cm.event("saved_to_wishlist","2", window.ghPageTypeCM, "0");_gh.ghp_show("ghp_wishlist",event);return _gh.postToURL("146767602", {a:"146767602",merke:"146767602",wl:document.getElementById("gh_wl_save_select").options[document.getElementById("gh_wl_save_select").selectedIndex].value,csrf:"DB685132-5108-11E7-ABFB-8F0EC32C3D63"},"post","ghp_wishlist_hidden");"></nobr>
                </form>
			
            <img src="///b/maill.png" height=12 align=absmiddle alt="[Produktempfehlung]"> <a rel=nofollow href=mailto:?subject=Produktempfehlung&amp;body=Dieses%20Produkt%20k%C3%B6nnte%20f%C3%BCr%20dich%20interessant%20sein%3A%0A%0A19468000%20GROHE%20Grohtherm%203000%20Cosmopolitan%20Wandarmatur%20spiegelnder%20Glanz%20und%20viel%20Funktion%20Dieses%20runde%20spiegelnd%20sch%C3%B6ne%20Bedienelement%20passt%20zu%20allen%20GROHE%20Cosmopolitan%20Badserien.%20Mit%20den%20zylindrischen%20Griffen%20regeln%20Sie%20bequem%20Wassertemperatur%20und%20-menge.%20Nach%20Bedarf%20wechseln%20Sie%20mit%20dem%20integrierten%20AquaDimmer%20zwischen%20Wannenzulauf%20und%20Brause%20oder%20zwischen%20Kopf-%20und%20Handbrause.%20Die%20SafeStop%20Taste%20verhindert%20dabei%20ein%20versehentliches%20Einstellen%20zu%20hei%C3%9Fer%20Wassertemperaturen.%20G%C3%B6nnen%20Sie%20sich%20...%20um%20EUR%20196%2C40%0AURL%3A%20https%3A%2F%2Fgeizhals.at%2F146767602 onclick="_gh.cm.event("product_recommend", "2", window.ghPageTypeCM, "0");">Produkt empfehlen</a><br>
			
			
            <img border=0 src="///b/av2/bugg.png" width=11 height=12 align="absmiddle">&nbsp;<a href="./?report=146767602" rel="nofollow" onclick="_gh.cm.event("reporterror_click", "1", window.ghPageTypeCM, "0"); return _gh.ghp_show("ghp_reperror",event);">Fehler&nbsp;melden</a>
			
			
                <div id=ghp_tnx style="display:none; z-index:99999;">Danke!</div>
<div id="ghp_reperror" style="display: none; z-index:99999;">
    <div class=ghp_h>
        <div class="ghp_h__caption">Fehler melden</div>
        <div id="ghp__action-close" class="ghp_h__action" onclick="this.parentNode.parentNode.style.display="none";">
            <img id=ghp_cancel src="///b/cancel_bw.png" width=16 height=16 alt="[x]" align=right class="ghp_h__image">
        </div>
        <script type="text/javascript">_gh_storage.skipScrollLock=true;_gh_pre.addLoadEvent(function(){if(document.body.offsetHeight > 740) document.getElementById("ghp__action-close").classList.remove("gh-lockable")})</script>
    </div>
    <div class=ghp_m>
        <iframe name="ghp_hidden" src="about:blank" style="display:none;"></iframe>
        <form method="post" accept-charset="iso-8859-1" action="./" enctype="multipart/form-data">
    <input type="hidden" name="report" value="146767602">
    <input type="hidden" name="rep_url" value="https://geizhals.at/146767602">
    <input type="hidden" name="rep_name" value="19468000 GROHE Grohtherm 3000 Cosmopolitan Wandarmatur spiegelnder Glanz und viel Funktion Dieses runde spiegelnd sch&ouml;ne Bedienelement passt zu allen GROHE Cosmopolitan Badserien. Mit den zylindrischen Griffen regeln Sie bequem Wassertemperatur und -menge. Nach Bedarf wechseln Sie mit dem integrierten AquaDimmer zwischen Wannenzulauf und Brause oder zwischen Kopf- und Handbrause. Die SafeStop Taste verhindert dabei ein versehentliches Einstellen zu hei&szlig;er Wassertemperaturen. G&ouml;nnen Sie sich ...">
    <input id="foo" name="rep_message" tabindex="-1">
    <b>Produkt: 19468000 GROHE Grohtherm 3000 Cosmopolitan Wandarmatur spiegelnder Glanz und viel Funktion Dieses runde spiegelnd sch&ouml;ne Bedienelement passt zu allen GROHE Cosmopolitan Badserien. Mit den zylindrischen Griffen regeln Sie bequem Wassertemperatur und -menge. Nach Bedarf wechseln Sie mit dem integrierten AquaDimmer zwischen Wannenzulauf und Brause oder zwischen Kopf- und Handbrause. Die SafeStop Taste verhindert dabei ein versehentliches Einstellen zu hei&szlig;er Wassertemperaturen. G&ouml;nnen Sie sich ...</b>
    <p style="margin-top: 10px;">
        <textarea id="reperror_t" accept-charset="UTF-8" wrap=hard name=error cols=80 rows=10 class=s placeholder="Bitte erkl&auml;ren Sie uns kurz, welchen Fehler Sie gefunden haben (z.B. falscher Preis bei einem H&auml;ndler, falsche Produktdaten oder Produktbild, etc.)" autofocus onfocus="_gh.ghp_bind_focus(event);"></textarea>
    </p>
    <p class=s>
        Ihre Mail-Adresse f&uuml;r R&uuml;ckfragen (optional):
    </p>
    <p class=x>
        <input id=reperror_m name=replyto class=s size=80 type=email>
    </p>
    <p>
        <div id="pleaseFill">Bitte geben Sie einen Grund f&uuml;r die Fehlermeldung an!</div>
        <input type="submit" onclick="return _gh.ghp_submit(this.form)" id="error_submit" name="report_send" value="Abschicken ">
    </p>
</form>
    </div>
</div>
			
			
        </div>
    </div>
    <div style="text-align:center; float:left; " id="gh_proddesc_right">
			
			
			
                <div align=center>
                    <img class=large_resize src="https://images-eu.ssl-images-amazon.com/images/I/41KLfg9eYJL.jpg" alt="via Amazon Partnerprogramm" title="via Amazon Partnerprogramm">
                    <br>
                    <span class=p_comment>Bild via Amazon Partnerprogramm</span>
                </div>
			
			
			
    </div>
    <div style="float:left" id="gh_artstuff">
			
			
	    <div id="div-gpt-ad-appendix" class="gha_appendix">
        <script type="text/javascript">
            window._gh_gpa_price_range = [] ;
            googletag.cmd.push(function() {
                googletag.display("div-gpt-ad-appendix");
            });
        </script>
			
    </div>
			
    </div>
			
<div style="clear:both"></div>
			
			
			
    </div>
    <div style="clear:both"></div>
			
			
			
			
			
			
<a name=ang></a>
<div id="gh_afilterbox" class="gh_gradient0">
    <a name="filterform"></a>
    <form name="filter" id="gh_filterform" method="get" accept-charset="iso-8859-1" action="./146767602#filterform">
        <div class="gh_afilterbox_sec gh_afilterbox_sec_dlvry">
            <h3 class="gh_afilterbox_h">Bezugsart</h3>
            <ul class="gh_reset">
                <li class="gh_reset dlvryfltr">
                    <input class="mid fll" id="t_alle" type="radio" name="t" value="alle"  CHECKED onclick="_gh.cm.event("productpage_showall","2", window.ghPageTypeCM, "0");document.filter.submit()">
                    <div class="radiotext">
                        <label for="t_alle" class="mid">alle Angebote</label>
                    </div>
                </li>
                <li class="gh_reset dlvryfltr">
                    <input class="mid fll" id="t_abholung" type="radio" name="t" value="a"  onclick="_gh.cm.event("productpage_by_distance","2", window.ghPageTypeCM, "0");document.filter.submit()">
                    <div class=radiotext>
                        <label for="t_abholung" class="mid">nur Abholung in der N&auml;he von:</label><br><div class="nowrp">
    <input class="mid gh_input_txt" id="plz_txt" name="plz" size="18" value="" onFocus="javascript:document.filter.t_abholung.checked=true;" title="Postleitzahl oder Ort, optional"><div title="aktueller Standort" id="geobtn1" class="mid gh_input_bt gh_loc_bt gh_attach_right" style="display:none"></div>
</div>
<script defer="defer">
    if (navigator.geolocation) {
    document.getElementById("geobtn1").style.display = "inline-block";
    document.getElementById("geobtn1").onclick = function() {
        _gh.cm.event("productpage_current_position", "2", window.ghPageTypeCM, "0");
        navigator.geolocation.getCurrentPosition(function (pos){
            document.getElementById("plz_txt").value = pos.coords.latitude + "," + pos.coords.longitude;
            document.getElementById("plz_txt").focus();
            if(document.filter.t_abholung) {
                document.filter.t_abholung.checked=true;
            }
        },function (){});
        return false
    }
}
</script>
                    </div>
                </li>
                <li class="gh_reset dlvryfltr">
                    <input class="mid fll" id="t_versand" type="radio" name="t" value="v"  onclick="_gh.cm.event("productpage_with_deliverycosts","2", window.ghPageTypeCM, "0");document.filter.submit()">
                    <div class=radiotext>
                        <label for="t_versand" class="mid">Inklusive Versand </label><br>
                        <div class=nowrp>
                            <span class=mid>per</span>
                            <select name="va" onchange="_gh.cm.event("productpage_payment","2", event.target.value, "0");document.filter.t_versand.checked=true; document.filter.submit()" class="mid gh_input_select">
                                <option value="b"    SELECTED>g&uuml;nstigste Variante</option>
                                <option value="cod" >Nachnahme</option>
                                <option value="cc"  >Kreditkarte</option>
                                <option value="pa"  >Vorkasse</option>
                                <option value="pp"  >PayPal</option>
			
                            </select>
                            <span class=mid>nach</span>
                            <select name=vl onchange="_gh.cm.event("productpage_destination","2", event.target.value, "0");document.filter.t_versand.checked=true; document.filter.submit()" class="mid gh_input_select">
                                <option value="de" >Deutschland</option>
                                <option value="at"  SELECTED >&Ouml;sterreich</option>
                                <option value="uk" >UK</option>
                                <option value="pl" >Polen</option>
                            </select>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
        <div class="gh_afilterbox_sec gh_afilterbox_sec_cntry">
            <h3 class="gh_afilterbox_h">Angebote aus</h3>
            <ul class="gh_reset">
			
                <li class="gh_reset gh_countryItem">
                    <label class="cntryfltr">
                        <input class="mid" name="hloc" value="at" checked="checked" type="checkbox" onclick="_gh.cm.event("productpage_from_country","2", event.target.value, "0");_gh.frm_fltr(this, "filter")">                            <img class="mid gh_flag" src="///b/flags/at-18x12.png" alt="&Ouml;sterreich">                        <span class="mid">&Ouml;sterreich</span>
                    </label>
                </li>
			
                <li class="gh_reset gh_countryItem">
                    <label class="cntryfltr">
                        <input class="mid" name="hloc" value="de" type="checkbox" onclick="_gh.cm.event("productpage_from_country","2", event.target.value, "0");_gh.frm_fltr(this, "filter")">                            <img class="mid gh_flag" src="///b/flags/de-18x12.png" alt="Deutschland">                        <span class="mid">Deutschland</span>
                    </label>
                </li>
			
                <li class="gh_reset gh_countryItem">
                    <label class="cntryfltr">
                        <input class="mid" name="hloc" value="pl" type="checkbox" onclick="_gh.cm.event("productpage_from_country","2", event.target.value, "0");_gh.frm_fltr(this, "filter")">                            <img class="mid gh_flag" src="///b/flags/pl-18x12.png" alt="Polen">                        <span class="mid">Polen</span>
                    </label>
                </li>
			
                <li class="gh_reset gh_countryItem">
                    <label class="cntryfltr">
                        <input class="mid" name="hloc" value="uk" type="checkbox" onclick="_gh.cm.event("productpage_from_country","2", event.target.value, "0");_gh.frm_fltr(this, "filter")">                            <img class="mid gh_flag" src="///b/flags/uk-18x12.png" alt="UK">                        <span class="mid">UK</span>
                    </label>
                </li>
			
                <li class="gh_reset gh_countryItem">
                    <label class="cntryfltr">
                        <input class="mid" name="hloc" value="eu" type="checkbox" onclick="_gh.cm.event("productpage_from_country","2", event.target.value, "0");_gh.frm_fltr(this, "filter")">                        <span class="mid">allen  L&auml;ndern</span>
                    </label>
                </li>
			
            </ul>
        </div>
			
        <div class="gh_afilterbox_sec gh_afilterbox_sec_available">
            <h3 class="gh_afilterbox_h">Verf&uuml;gbarkeit</h3>
            <ul class="gh_reset">
                <li class="gh_reset av_sel av_e">
                    <input onclick="_gh.cm.event("productpage_availibility_change","2", "ANY", "0");document.filter.submit()" id="v_e" class="mid" type="radio" name="v" value="e"  CHECKED  class="mid">
                    <label for="v_e" class="mid">
                        beliebige Verf&uuml;gbarkeit
                    </label>
                </li>
                <li class="gh_reset av_sel av_l">
                    <input onclick="_gh.cm.event("productpage_availibility_change","2", "IN_STOCK", "0");document.filter.submit()" id="v_l" class="mid" type="radio" name="v" value="l"  class="mid" title="Der Artikel ist physisch beim H&auml;ndler vorr&auml;tig und kann sofort geliefert werden">
                    <label for="v_l" class="mid">
                        lagernd beim H&auml;ndler
                    </label>
                </li>
                <li class="gh_reset av_sel av_k">
                    <input onclick="_gh.cm.event("productpage_availibility_change","2", "SHORT_NOTICE", "0");document.filter.submit()" id="v_k" class="mid" type="radio" name="v" value="k"  class="mid" title="Der Artikel ist nicht beim H&auml;ndler vorr&auml;tig, kann jedoch kurzfristig geliefert werden">
                    <label for="v_k" class="mid">
                        kurzfristig lieferbar (bis 4 Werktage)
                    </label>
                </li>
            </ul>
            <noscript>
                <button type="submit">aktualisieren</button>
            </noscript>
        </div>
			
    </form>
    <div class="clr"></div>
			
</div>
			
            <a id="productlist"></a>    <form accept-charset="iso-8859-1" action="./146767602#filterform" method="get" name="filterbox" class="productpage__pagination"><div class="blaettern" id="paginator__blaettern">
</div>
    </form>    <div class="offerlist" id="lazy-loaded__list">
			
        <div class="tr1 offerlist__header">
            <div class="lh1 offer__price">
                <a class="menulink0" title="Bitte beachten Sie die Hinweise zur Preisdarstellung am Ende der Seite" href="#preishinw">Preis <sup>*</sup></a>
            </div>
            <div class="lh1 offer__merchant">Anbieter</div>
            <div class="lh1 offer__merchant-rating only--desktop">H&auml;ndler-<br />Bewertung</div>
            <div class="lh1 offer__delivery">
                Verf&uuml;gbarkeit
                <a href="#versandhinw" class="offer__delivery-header" title="Versandkosten sind, sofern nicht anders angegeben, Versandkosten nach &Ouml;sterreich">Versand<sup>**</sup></a>
            </div>
            <div class="lh1 offer__details">Artikelbezeichnung des H&auml;ndlers</div>
        </div>
			
			
    <div class="offer offer--shortly" id="offer__0">
        <div class="offer__price"  id="offer__price-0"><span class="gh_price">&euro; 196,40</span>            <div class="offer__clickout"><a rel="nofollow" target="_blank" onClick="javascript:cmCreateConversionEventTag("offer_click","2","/outprice/B%E4dermaxx", "196.4");" class=offer_bt href="/redir.cgi?h=baedermaxx-at&amp;loc=https%3A%2F%2Fwww.baedermaxx.at%2Fbad%2Fbadarmaturen%2Fwannen-duscharmaturen%2F9643%2Fgrohe-grohtherm-3000-cosmopolitan-thermostat-mit-integrierter-2-wege-umstellung-chrom-19468000&amp;ghaID=146767602&amp;key=4f4722ccd2b2882880b7481c17d728bb">zum Angebot</a>            </div>
            <div class="offer__payment-options">                                <img src="///b/mastercard_t.png"
                                     alt="MasterCard"
                                     title="MasterCard"
                                     class="offer__payment-icon"
                                     width="20"
                                     height="12"  />                                <img src="///b/paypal_gh.png"
                                     alt="PayPal"
                                     title="PayPal"
                                     class="offer__payment-icon"
                                     width="41"
                                     height="12"  />                                <img src="///b/sof_ueb.png"
                                     alt="sofort&uuml;berweisung.de"
                                     title="sofort&uuml;berweisung.de"
                                     class="offer__payment-icon"
                                     width="37"
                                     height="14"  />                                <img src="///b/visa_t.png"
                                     alt="VISA"
                                     title="VISA"
                                     class="offer__payment-icon"
                                     width="20"
                                     height="12"  />            </div>
        </div>
        <div class="offer__merchant">            <img class="mid gh_flag offer__merchant-flag"
                 src="///b/flags/at-18x12.png"
                 alt="[AT]"><a rel=" nofollow"
   class="merchant"
   target="_blank"
			
        onClick="_gh.cm.event("offer_click","2","/outprice/B&auml;dermaxx", "196.4");"
			
			
			
    href="/redir.cgi?h=baedermaxx-at&amp;loc=https%3A%2F%2Fwww.baedermaxx.at%2Fbad%2Fbadarmaturen%2Fwannen-duscharmaturen%2F9643%2Fgrohe-grohtherm-3000-cosmopolitan-thermostat-mit-integrierter-2-wege-umstellung-chrom-19468000&amp;ghaID=146767602&amp;key=4f4722ccd2b2882880b7481c17d728bb"
    class="gh_offerlist__offerurl ntd ">
			
    <span class="merchant__logo-caption">
			
        <span class=notrans>
        B&auml;dermaxx
			
			
        </span>
			
    </span>
</a>
            <div class="offer__merchant-link"></div>
            <div class="offer__merchant-info-links">                    <a href="./?qlink=B%E4dermaxx&subi=infos&kuerzel=baedermaxx-at">Infos</a>                <a rel="nofollow" href="/redir.cgi?h=baedermaxx-at&amp;loc=http%3A%2F%2Fwww.baedermaxx.at%2Fagb&amp;ghaID=146767602&amp;key=3c69c024dbae4a849f346ae22b0f67a9" target="_blank" onClick="_gh.cm.event("offer_click","2","/agb/B&auml;dermaxx", "0");">AGB</a>
			
            </div>
        </div>
        <div class="block-click offer__merchant-rating">
			
                <a href="./?sb=227245"><img border=0 valign=absmiddle vspace=2 width=15 height=15 src=///b/1_ani.gif alt="Note: 1,05" title="Note: 1,05 - Spitze!"></a><br><small>Note: 1,05</small><br><small><a href="./?sb=227245">4 Bewertungen</a></small>
			
        </div>
        <div class="offer__delivery">
            <div class="offer__delivery-time">1-3 Werktagen            </div>
            <div class="offer__delivery-payment">Vorkasse, Kreditkarte, PayPal, sofort&uuml;berweisung.de, Lastschrift <br><b><font color=red>GRATISVERSAND</font></b><br>(minus &euro;&nbsp;5,89 Rabatt bei Vorkasse).<br><br>Lieferung in weitere L&auml;nder auf Anfrage.<br>Abholung nach Online-Bestellung m&ouml;glich (A-5760 Saalfelden am Steinernen Meer)<br>            </div>
        </div>
        <div class="block-click offer__details">19468000 GROHE Grohtherm 3000 Cosmopolitan Wandarmatur spiegelnder Glanz und viel Funktion Dieses runde spiegelnd sch&ouml;ne Bedienelement passt zu allen GROHE Cosmopolitan Badserien. Mit den zylindrischen Griffen regeln Sie bequem Wassertemperatur und -menge. Nach Bedarf wechseln Sie mit dem integrierten AquaDimmer zwischen Wannenzulauf und Brause oder zwischen Kopf- und Handbrause. Die SafeStop Taste verhindert dabei ein versehentliches Einstellen zu hei&szlig;er Wassertemperaturen. G&ouml;nnen Sie sich ...            <div class="offer__disclaimer">                    <b>Preis vom: 14.06.2017, 15:46:06</b><br>                    (Preis kann jetzt h&ouml;her sein!)            </div>
                            <div class="offer__badges"><a href="/redir.cgi?h=guetezeichen&amp;loc=http%3A%2F%2Fwww.euro-label.com%2Fzertifizierte-shops%2Fzertifikat%2Findex.html%3Fmemberkey%3DWKO%26shopurl%3Dwww.baedermaxx.at&amp;key=b32187ff31478c80e3b01dc53f37697d" target=_blank rel="nofollow"><img alt="[&Ouml;sterreichisches e-Commerce G&uuml;tezeichen]" title="&Ouml;sterreichisches e-Commerce G&uuml;tezeichen" src="///b/ecg_logo.png" width=75 height=51 align=absmiddle></a>                 </div>        </div>
    </div>
			
    <div class="offer offer--available" id="offer__1">
        <div class="offer__price"  id="offer__price-1"><span class="gh_price">&euro; 210,57</span>            <div class="offer__clickout"><a rel="nofollow" target="_blank" onClick="javascript:cmCreateConversionEventTag("offer_click","2","/outprice/Amazon.at", "210.57");" class=offer_bt href="/redir.cgi?h=amazon-at&amp;loc=http%3A%2F%2Fwww.amazon.de%2Fdp%2FB001T7CIAI%3Fsmid%3DA3JWKAKR8XB7XF%26linkCode%3Ddf0%26creative%3D22502%26creativeASIN%3DB001T7CIAI%26childASIN%3DB001T7CIAI%26tag%3Dgeizhals1-21&amp;ghaID=146767602&amp;key=e71c84a511186fdbcac1047fc9276838">zum Angebot</a>            </div>
            <div class="offer__payment-options">                                <img src="///b/amex_s.png"
                                     alt="American Express"
                                     title="American Express"
                                     class="offer__payment-icon"
                                     width="17"
                                     height="12"  />                                <img src="///b/mastercard_t.png"
                                     alt="MasterCard"
                                     title="MasterCard"
                                     class="offer__payment-icon"
                                     width="20"
                                     height="12"  />                                <img src="///b/visa_t.png"
                                     alt="VISA"
                                     title="VISA"
                                     class="offer__payment-icon"
                                     width="20"
                                     height="12"  />            </div>
        </div>
        <div class="offer__merchant">            <img class="mid gh_flag offer__merchant-flag"
                 src="///b/flags/at-18x12.png"
                 alt="[AT]"><a rel=" nofollow"
   class="merchant"
   target="_blank"
			
        onClick="_gh.cm.event("offer_click","2","/outprice/Amazon.at", "210.57");"
			
			
			
    href="/redir.cgi?h=amazon-at&amp;loc=http%3A%2F%2Fwww.amazon.de%2Fdp%2FB001T7CIAI%3Fsmid%3DA3JWKAKR8XB7XF%26linkCode%3Ddf0%26creative%3D22502%26creativeASIN%3DB001T7CIAI%26childASIN%3DB001T7CIAI%26tag%3Dgeizhals1-21&amp;ghaID=146767602&amp;key=e71c84a511186fdbcac1047fc9276838"
    class="gh_offerlist__offerurl ntd ">
			
    <div class="merchant__logo-image">
        <img title="Amazon.at"
             src="///b/logos/5010.gif"
             alt="Amazon.at"
              width=&quot;90&quot; height=&quot;46&quot;
             class="gh_offerlist__merchant_logo hllnk flagl">
    </div>
			
    <span class="merchant__logo-caption">
			
        <span class=notrans>
        Amazon.at
			
			
        </span>
			
    </span>
</a>
            <div class="offer__merchant-link"><br>Hinweis: Firmensitz in Deutschland</div>
            <div class="offer__merchant-info-links">                    <a href="./?qlink=Amazon.at&subi=infos&kuerzel=amazon-at">Infos</a>                <a rel="nofollow" href="/redir.cgi?h=amazon-at&amp;loc=http%3A%2F%2Fwww.amazon.de%2Fexec%2Fobidos%2Fredirect%3Ftag%3Dgeizhals1-21%26path%3Dtg%2Fbrowse%2F-%2F505048&amp;ghaID=146767602&amp;key=087313066cb006f9f62bc9c1d3fbb632" target="_blank" onClick="_gh.cm.event("offer_click","2","/agb/Amazon.at", "0");">AGB</a>
			
            </div>
        </div>
        <div class="block-click offer__merchant-rating">
			
                <a href="./?sb=183"><img border=0 valign=absmiddle vspace=2 width=15 height=15 src=///b/3.gif alt="Note: 2,43" title="Note: 2,43"></a><br><small>Note: 2,43</small><br><small><a href="./?sb=183">2902 Bewertungen</a></small>
			
        </div>
        <div class="offer__delivery">
            <div class="offer__delivery-time">Gew&ouml;hnlich versandfertig in 24 Stunden            </div>
            <div class="offer__delivery-payment">Kreditkarte, Bankeinzug<br><font color="red"><b>GRATISVERSAND</b></font>.<br><br>            </div>
        </div>
        <div class="block-click offer__details">Grohe 19468000<br>GROHE Grohtherm 3000 Cosmopolitan Armatur mit 2-Wege-Umstellung (Wanne oder Dusche mit mehr als 1 Brause) f&uuml;r GROHE Rapido T Unterputz-Thermostat 19468000 (Heimwerken) (b001t7ciai)            <div class="offer__disclaimer">                    <b>Preis vom: 14.06.2017, 11:19:33</b><br>                    (Preis kann jetzt h&ouml;her sein!)            </div>
			
            <div class="offer__extra-info">                    ACHTUNG: die Preise auf der Amazon-Website enthalten die deutsche Mehrwertsteuer (19%).
                    Die hier angezeigten Preise entsprechen bereits den Preisen, die Kunden aus &Ouml;sterreich
                    bei einer Bestellung verrechnet werden!            </div>        </div>
    </div>
			
    <div class="offer offer--unavailable" id="offer__2">
        <div class="offer__price"  id="offer__price-2"><span class="gh_price">&euro; 219,--</span>            <div class="offer__clickout"><a rel="nofollow" target="_blank" onClick="javascript:cmCreateConversionEventTag("offer_click","2","/outprice/Hornbach%20%D6sterreich", "219");" class=offer_bt href="/redir.cgi?h=hornbachoesterreich-at&amp;loc=http%3A%2F%2Fclick.cptrack.de%2F%3Frd%3Dtrue%26k%3DdnqjLRF2uUVznKtjJ3dWedH4nq8ybpYRZm_v4URzjzI&amp;ghaID=146767602&amp;key=8081c76eb14a920aa6bfea501b826af3">zum Angebot</a>            </div>
            <div class="offer__payment-options">                                <img src="///b/mc_secure.png"
                                     alt="MasterCard SecureCode"
                                     title="MasterCard SecureCode"
                                     class="offer__payment-icon"
                                     width="40"
                                     height="12"  />                                <img src="///b/paypal_gh.png"
                                     alt="PayPal"
                                     title="PayPal"
                                     class="offer__payment-icon"
                                     width="41"
                                     height="12"  />                                <img src="///b/sof_ueb.png"
                                     alt="sofort&uuml;berweisung.de"
                                     title="sofort&uuml;berweisung.de"
                                     class="offer__payment-icon"
                                     width="37"
                                     height="14"  />                                <img src="///b/vb_visa.png"
                                     alt="Verified by VISA"
                                     title="Verified by VISA"
                                     class="offer__payment-icon"
                                     width="28"
                                     height="12"  />            </div>
        </div>
        <div class="offer__merchant">            <img class="mid gh_flag offer__merchant-flag"
                 src="///b/flags/at-18x12.png"
                 alt="[AT]"><a rel=" nofollow"
   class="merchant"
   target="_blank"
			
        onClick="_gh.cm.event("offer_click","2","/outprice/Hornbach &Ouml;sterreich", "219");"
			
			
			
    href="/redir.cgi?h=hornbachoesterreich-at&amp;loc=http%3A%2F%2Fclick.cptrack.de%2F%3Frd%3Dtrue%26k%3DdnqjLRF2uUVznKtjJ3dWedH4nq8ybpYRZm_v4URzjzI&amp;ghaID=146767602&amp;key=8081c76eb14a920aa6bfea501b826af3"
    class="gh_offerlist__offerurl ntd ">
			
    <div class="merchant__logo-image">
        <img title="Hornbach &Ouml;sterreich"
             src="///b/logos/176295.png"
             alt="Hornbach &Ouml;sterreich"
              width=&quot;90&quot; height=&quot;32&quot;
             class="gh_offerlist__merchant_logo hllnk flagl">
    </div>
			
    <span class="merchant__logo-caption">
			
        <span class=notrans>
        Hornbach &Ouml;sterreich
			
			
        </span>
			
    </span>
</a>
            <div class="offer__merchant-link"><br>30 Tage R&uuml;ckgaberecht - auch im Markt</div>
            <div class="offer__merchant-info-links">                    <a href="./?qlink=Hornbach%20%D6sterreich&subi=infos&kuerzel=hornbachoesterreich-at">Infos</a>                <a rel="nofollow" href="/redir.cgi?h=hornbachoesterreich-at&amp;loc=http%3A%2F%2Fwww.hornbach.at%2Fcms%2Fde%2Fat%2Fagb.html&amp;ghaID=146767602&amp;key=44740e2c110cab380e5195393e78462e" target="_blank" onClick="_gh.cm.event("offer_click","2","/agb/Hornbach &Ouml;sterreich", "0");">AGB</a>
			
            </div>
        </div>
        <div class="block-click offer__merchant-rating">
			
                <a href="./?sb=123564"><img border=0 valign=absmiddle vspace=2 width=15 height=15 src=///b/1_ani.gif alt="Note: 1,11" title="Note: 1,11 - Spitze!"></a><br><small>Note: 1,11</small><br><small><a href="./?sb=123564">7 Bewertungen</a></small>
			
        </div>
        <div class="offer__delivery">
            <div class="offer__delivery-time">ca. 5 Werktage            </div>
            <div class="offer__delivery-payment">Vorkasse, Kreditkarte, PayPal, sofort&uuml;berweisung.de &euro;&nbsp;4,95.<br><br>Lieferung nur innerhalb &Ouml;sterreichs.<br>Abholung nach Online-Reservierung in den <a target=_blank href="./?qlink=Hornbach%20%D6sterreich&subi=infos&kuerzel=hornbachoesterreich-at">Filialen</a> m&ouml;glich.<br>            </div>
        </div>
        <div class="block-click offer__details">Thermostatarmatur Grohe Grohtherm 3000 C mit integrierter 2-Wege-Umstellung f&uuml;r Wanne oder Dusche mit mehr als einer Brause 19468000 chrom<br>(Art# 8283787)            <div class="offer__disclaimer">                    <b>Preis vom: 14.06.2017, 15:47:45</b><br>                    (Preis kann jetzt h&ouml;her sein!)            </div>
                            <div class="offer__badges"><a href="/redir.cgi?h=handelsverband&amp;loc=http%3A%2F%2Fwww.handelsverband.at%2F&amp;key=b0225363f2b900ef9f67d84756102023" target=_blank rel="nofollow"><img alt="[&quot;Trustmark Austria&quot; des &Ouml;sterreichischen Handelsverbandes]" title="&quot;Trustmark Austria&quot; des &Ouml;sterreichischen Handelsverbandes" src="///b/HV_Trustmark_rgb.png" width=60 height=60 align=absmiddle></a> <a href="/redir.cgi?h=guetezeichen&amp;loc=http%3A%2F%2Fwww.euro-label.com%2Fzertifizierte-shops%2Fzertifikat%2Findex.html%3Fmemberkey%3DWKO%26shopurl%3Dwww.hornbach.at&amp;key=9442457050b4d9df9acf6a7e5efa15fb" target=_blank rel="nofollow"><img alt="[&Ouml;sterreichisches e-Commerce G&uuml;tezeichen]" title="&Ouml;sterreichisches e-Commerce G&uuml;tezeichen" src="///b/ecg_logo.png" width=75 height=51 align=absmiddle></a>                 </div>        </div>
    </div>
			
    <div class="offer offer--available" id="offer__3">
        <div class="offer__price"  id="offer__price-3"><span class="gh_price">&euro; 224,39</span>            <div class="offer__clickout"><a rel="nofollow" target="_blank" onClick="javascript:cmCreateConversionEventTag("offer_click","2","/outprice/Amailo.at", "224.39");" class=offer_bt href="/redir.cgi?h=eurovend-de&amp;loc=https%3A%2F%2Fwww.amailo.at%2Fproduct_info.php%3Finfo%3Dp196332%26utm_campaign%3Dgeizhalsat_196332%26utm_source%3Dgeizhalsat%26utm_medium%3DCPC%26utm_content%3Dtextanzeige%26campaign%3Dgeizhalsat&amp;ghaID=146767602&amp;key=382c4a6e12e46659d26543622ebb14ed">zum Angebot</a>            </div>
            <div class="offer__payment-options">                                <img src="///b/mastercard_t.png"
                                     alt="MasterCard"
                                     title="MasterCard"
                                     class="offer__payment-icon"
                                     width="20"
                                     height="12"  />                                <img src="///b/mc_secure.png"
                                     alt="MasterCard SecureCode"
                                     title="MasterCard SecureCode"
                                     class="offer__payment-icon"
                                     width="40"
                                     height="12"  />                                <img src="///b/visa_t.png"
                                     alt="VISA"
                                     title="VISA"
                                     class="offer__payment-icon"
                                     width="20"
                                     height="12"  />                                <img src="///b/vb_visa.png"
                                     alt="Verified by VISA"
                                     title="Verified by VISA"
                                     class="offer__payment-icon"
                                     width="28"
                                     height="12"  />            </div>
        </div>
        <div class="offer__merchant">            <img class="mid gh_flag offer__merchant-flag"
                 src="///b/flags/at-18x12.png"
                 alt="[AT]"><a rel=" nofollow"
   class="merchant"
   target="_blank"
			
        onClick="_gh.cm.event("offer_click","2","/outprice/Amailo.at", "224.39");"
			
			
			
    href="/redir.cgi?h=eurovend-de&amp;loc=https%3A%2F%2Fwww.amailo.at%2Fproduct_info.php%3Finfo%3Dp196332%26utm_campaign%3Dgeizhalsat_196332%26utm_source%3Dgeizhalsat%26utm_medium%3DCPC%26utm_content%3Dtextanzeige%26campaign%3Dgeizhalsat&amp;ghaID=146767602&amp;key=382c4a6e12e46659d26543622ebb14ed"
    class="gh_offerlist__offerurl ntd ">
			
    <div class="merchant__logo-image">
        <img title="Amailo.at"
             src="///b/logos/Logo_Amailo_90x32_schwarz.png"
             alt="Amailo.at"
              width=&quot;90&quot; height=&quot;32&quot;
             class="gh_offerlist__merchant_logo hllnk flagl">
    </div>
			
    <span class="merchant__logo-caption">
			
        <span class=notrans>
        Amailo.at
			
			
        </span>
			
    </span>
</a>
            <div class="offer__merchant-link"><br>Hinweis: Versand aus Deutschland</div>
            <div class="offer__merchant-info-links">                    <a href="./?qlink=Amailo.at&subi=infos&kuerzel=eurovend-de">Infos</a>                <a rel="nofollow" href="/redir.cgi?h=eurovend-de&amp;loc=http%3A%2F%2Fwww.amailo.at%2Fshop_content.php%2FcoID%2F3%2Fcontent%2FUnsere-AGB&amp;ghaID=146767602&amp;key=96ff90561159768e46cd127e31c832af" target="_blank" onClick="_gh.cm.event("offer_click","2","/agb/Amailo.at", "0");">AGB</a>
			
            </div>
        </div>
        <div class="block-click offer__merchant-rating">
			
                <a href="./?sb=4747"><img border=0 valign=absmiddle vspace=2 width=15 height=15 src=///b/2.gif alt="Note: 1,68" title="Note: 1,68"></a><br><small>Note: 1,68</small><br><small><a href="./?sb=4747">555 Bewertungen</a></small>
			
        </div>
        <div class="offer__delivery">
            <div class="offer__delivery-time">auf Lager. Lieferzeit: 2-3 Werktage            </div>
            <div class="offer__delivery-payment">Vorkasse &euro;&nbsp;12,95.<br>Nachnahme &euro;&nbsp;16,90.<br>Kreditkarte &euro;&nbsp;19,60.<br><br>            </div>
        </div>
        <div class="block-click offer__details">Grohe Grohtherm 3000 Cosmopolitan Thermostat, chrom, mit integrierter 2-Wege-Umstellung (19468000)<br>Art# (196332) Wandarmatur: spiegelnder Glanz und viel Funktion Dieses runde, spiegelnd sch&ouml;ne Bedienelement passt zu allen GROHE Cosmopolitan Badserien. Mit den zylindrischen Griffen regeln Sie bequem Wassertempera            <div class="offer__disclaimer">                    <b>Preis vom: 14.06.2017, 15:46:33</b><br>                    (Preis kann jetzt h&ouml;her sein!)            </div>
                    </div>
    </div>    </div><div class="blaettern" id="paginator__blaettern">
</div>
<div class=gh_blatext>Alle Angaben ohne Gew&auml;hr. Die gelisteten Angebote sind keine verbindlichen Werbeaussagen der Anbieter!<br><br>
<a name="preishinw"></a><b class="disclaimer__star">*</b> Preise in Euro inkl. MwSt. zzgl. Verpackungs- und Versandkosten, sofern diese nicht bei der gew&auml;hlten Art der Darstellung hinzugerechnet wurden. Bitte beachten Sie die Lieferbedingungen und Versandspesen bei Online-Bestellungen. Bei Sortierung nach einer anderen als der Landesw&auml;hrung des H&auml;ndlers basiert die W&auml;hrungsumrechnung auf einem von uns ermittelten Tageskurs, der oft nicht mit dem im Shop verwendeten identisch ist. <a name=ps></a>Bitte bedenken Sie, dass die angef&uuml;hrten Preise periodisch erzeugte Momentaufnahmen darstellen und technisch bedingt teilweise veraltet sein k&ouml;nnen. Insbesondere sind Preiserh&ouml;hungen zwischen dem Zeitpunkt der Preis&uuml;bernahme durch uns und dem sp&auml;teren Besuch dieser Website m&ouml;glich, H&auml;ndler haben keine M&ouml;glichkeit die Darstellung der Preise direkt zu beeinflussen und sofortige &Auml;nderungen auf unserer Seite zu veranlassen. Ma&szlig;geblich f&uuml;r den Verkauf durch den H&auml;ndler ist der tats&auml;chliche Preis des Produkts, der zum Zeitpunkt des Kaufs auf der Website des Verk&auml;ufers steht.</div>
<p><div class=gh_blatext><a name="versandhinw"></a><b class="disclaimer__star">**</b> Hinweis zur Spalte "Versand": die angezeigten Versandkosten sind, sofern nicht anders angegeben, die Kosten f&uuml;r den Versand
			
			
    nach &Ouml;sterreich. Die nicht angef&uuml;hrten Kosten f&uuml;r weitere Versandl&auml;nder entnehmen Sie bitte der Website des H&auml;ndlers.
			
			
			
</p></div>
			
<script type="text/javascript">
        _gh_pre.addLoadEvent(function() {
			
        });
</script>
			
			
			
			
			
			
<script>
    var OEWA = {
        "s":"geizhals",
        "cp":"Service/Verzeichnisse/preisvergleich/at"
    };
    var oewaq = oewaq || [];
    oewaq.push(OEWA);
    (function() {
        var scr = document.createElement("script");
        scr.type = "text/javascript"; scr.async = true;
        scr.src = "//dispatcher.oewabox.at/oewa.js";
        var s = document.getElementsByTagName("script")[0];
        s.parentNode.insertBefore(scr, s);
    })();
</script>
<script type="text/javascript">
    cmCreatePageviewTag(" (id:146767602)","gh_at-cat-unsorted",undefined,undefined);
    window.ghPageTypeCM = "gh_at-cat-unsorted";
			
</script>
</div></div></div>
<div style="clear:both"></div>
<div id="ghfooter">
            <ul id="ghfooterpc">
                <h3 class="ghfootlh">Unsere Preisvergleiche:</h3>
			
			
                        <li>                                <img alt="&Ouml;sterreich" width=10 height=9 src="///b/at_s.gif">                            <a class=hl
                                href="//geizhals.at/"
                               onclick="_gh.cm.event("footer_click","2", "geizhals.at", "0");">geizhals.at</a>
			
                                (<a class=hl href="//geizhals.at/kleinanzeigen/" onclick="_gh.cm.event("footer_click","2", "kleinanzeigen", "0");">Kleinanzeigen</a>,
                                <a class=hl href="//forum.geizhals.at/" onclick="_gh.cm.event("footer_click","2", "forum", "0");">Forum</a>,
                                <a class=hl href="//gewinnspiel.geizhals.at/?f_gf=1" onclick="_gh.cm.event("footer_click","2", "gewinnspiel", "0");">Gewinnspiel</a>)
                        </li>
			
			
			
                        <li>                                <img alt="Deutschland" width=10 height=9 src="///b/lang_de.gif">                            <a class=hl
                                href="//geizhals.de/"
                               onclick="_gh.cm.event("footer_click","2", "geizhals.de", "0");">geizhals.de</a>
			
                        </li>
			
			
			
                        <li>                                <img alt="UK" width=10 height=9 src="///b/lang_en.gif">                            <a class=hl
                                href="//skinflint.co.uk/"
                               onclick="_gh.cm.event("footer_click","2", "skinflint.co.uk", "0");">skinflint.co.uk</a>
			
                        </li>
			
			
			
                        <li>                                <img alt="Polen" width=10 height=9 src="///b/pl_s.gif">                            <a class=hl
                                href="//cenowarka.pl/"
                               onclick="_gh.cm.event("footer_click","2", "cenowarka.pl", "0");">cenowarka.pl</a>
			
                        </li>
			
			
			
                        <li>                                <img alt="EU" width=10 height=9 src="///b/eu_s.gif">                            <a class=hl
                                href="//geizhals.eu/"
                               onclick="_gh.cm.event("footer_click","2", "geizhals.eu", "0");">geizhals.eu</a>
			
                        </li>
			
			
            </ul>
			
            <ul id="ghfootersites">
                <h3 class="ghfootlh">Andere Websites:</h3>
			
			
                        <li>                                <img alt="&Ouml;sterreich" width=10 height=9 src="///b/at_s.gif">                                <img alt="Deutschland" width=10 height=9 src="///b/lang_de.gif">                            <a class=hl
                                href="https://bepixelung.org/"
                               onclick="_gh.cm.event("footer_click","2", "bepixelung.org", "0");">bepixelung.org</a>
			
                        </li>
			
			
			
                        <li>                                <img alt="&Ouml;sterreich" width=10 height=9 src="///b/at_s.gif">                            <a class=hl
                                href="https://metashop.at/"
                               onclick="_gh.cm.event("footer_click","2", "metashop.at", "0");">metashop.at</a>
			
                        </li>
			
			
			
                        <li>                            <a class=hl                                rel="nofollow"
                                href="http://666k.com/"
                               onclick="_gh.cm.event("footer_click","2", "666k.com", "0");">666k.com</a>
			
                        </li>
			
			
            </ul>
			
            <ul id="ghfooterab">
                <h3 class="ghfootlh">&Uuml;ber uns:</h3>
			
			
                        <li>                            <a class=hl
                                href="//unternehmen.geizhals.at/about/de/info/kontakt-und-impressum/"
                               onclick="_gh.cm.event("footer_click","2", "Impressum", "0");">Impressum</a>
			
                        </li>
			
			
			
                        <li>                            <a class=hl
                                href="//unternehmen.geizhals.at/about/de/sales/"
                               onclick="_gh.cm.event("footer_click","2", "Informationen f&uuml;r H&auml;ndler", "0");">Informationen f&uuml;r H&auml;ndler</a>
			
                        </li>
			
			
			
                        <li>                            <a class=hl
                                href="//unternehmen.geizhals.at/about/de/werben/"
                               onclick="_gh.cm.event("footer_click","2", "Werbung schalten", "0");">Werbung schalten</a>
			
                        </li>
			
			
			
                        <li>                            <a class=hl
                                href="//unternehmen.geizhals.at/about/de/jobs/"
                               onclick="_gh.cm.event("footer_click","2", "Jobs", "0");">Jobs</a>
			
                        </li>
			
			
			
                        <li>                            <a class=hl
                                href="//unternehmen.geizhals.at/about/de/presse/"
                               onclick="_gh.cm.event("footer_click","2", "Presse", "0");">Presse</a>
			
                        </li>
			
                        <li><a class=hl rel="nofollow" href="https://www.facebook.com/geizhals.at" onclick="_gh.cm.event("footer_click","2", "facebook", "0");">Facebook</a>,
                            <a class=hl rel="nofollow" href="https://twitter.com/Geizhals" onclick="_gh.cm.event("footer_click","2", "twitter", "0");">Twitter</a></li>
			
			
            </ul>
			
        <div id="ghfootersitemap">
            Sitemap:                <a href="/smap/sitemap-de-01.html" class="hl">1</a> |                             <a href="/smap/sitemap-de-02.html" class="hl">2</a> |                             <a href="/smap/sitemap-de-03.html" class="hl">3</a> |                             <a href="/smap/sitemap-de-04.html" class="hl">4</a> |                             <a href="/smap/sitemap-de-05.html" class="hl">5</a> |                             <a href="/smap/sitemap-de-06.html" class="hl">6</a> |                             <a href="/smap/sitemap-de-07.html" class="hl">7</a> |                             <a href="/smap/sitemap-de-08.html" class="hl">8</a> |                             <a href="/smap/sitemap-de-09.html" class="hl">9</a> |                             <a href="/smap/sitemap-de-10.html" class="hl">10</a> |                             <a href="/smap/sitemap-de-11.html" class="hl">11</a> |                             <a href="/smap/sitemap-de-12.html" class="hl">12</a> |                             <a href="/smap/sitemap-de-13.html" class="hl">13</a> |                             <a href="/smap/sitemap-de-14.html" class="hl">14</a> |                             <a href="/smap/sitemap-de-15.html" class="hl">15</a> |                             <a href="/smap/sitemap-de-16.html" class="hl">16</a> |                             <a href="/smap/sitemap-de-17.html" class="hl">17</a> |                             <a href="/smap/sitemap-de-18.html" class="hl">18</a> |                             <a href="/smap/sitemap-de-19.html" class="hl">19</a> |                             <a href="/smap/sitemap-de-20.html" class="hl">20</a>
        </div>
        <div id="ghfootercop">
            Copyright &copy; 1997-2017 Preisvergleich Internet Services AG
        </div>
</div>
<div id="gh_login"></div>
<div id="fb-root"></div>
</body></html>';
	
}