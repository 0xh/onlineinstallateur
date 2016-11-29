<!doctype html>
<!--



Copyright (c) SEPA ENGINEERING
email : office@sepa.at
web : http://www.hausfabrik.at

/// templates/frontOffice/default
-->

{* Declare assets directory, relative to template base directory *}
{declare_assets directory='assets/dist'}
{* Set the default translation domain, that will be used by {intl} when the 'd' parameter is not set *}
{default_translation_domain domain='fo.default'}

{* -- Define some stuff for Smarty ------------------------------------------ *}
{config_load file='variables.conf'}
{block name="init"}{/block}
{block name="no-return-functions"}{/block}
{assign var="store_name" value={config key="store_name"}}
{assign var="store_description" value={config key="store_description"}}
{assign var="lang_code" value={lang attr="code"}}
{assign var="lang_locale" value={lang attr="locale"}}
{if not $store_name}{assign var="store_name" value={intl l='Thelia V2'}}{/if}
{if not $store_description}{assign var="store_description" value={$store_name}}{/if}

{* paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither *}
<!--[if lt IE 7 ]><html class="no-js oldie ie6" lang="{$lang_code}"> <![endif]-->
<!--[if IE 7 ]><html class="no-js oldie ie7" lang="{$lang_code}"> <![endif]-->
<!--[if IE 8 ]><html class="no-js oldie ie8" lang="{$lang_code}"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="{$lang_code}" class="no-js"> <!--<![endif]-->
<head>
    {hook name="main.head-top"}
    {* Test if javascript is enabled *}
    <script>(function(H) { H.className=H.className.replace(/\bno-js\b/,'js') } )(document.documentElement);</script>

    <meta charset="utf-8">

    {* Page Title *}
    <title>{block name="page-title"}{strip}{if $page_title}{$page_title}{elseif $breadcrumbs}{foreach from=$breadcrumbs|array_reverse item=breadcrumb}{$breadcrumb.title|unescape} - {/foreach}{$store_name}{else}{$store_name}{/if}{/strip}{/block}</title>

    {* Meta Tags *}
    <meta name="generator" content="{intl l='Thelia V2'}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    {block name="meta"}
        <meta name="description" content="{if $page_description}{$page_description}{else}{$store_description|strip|truncate:500}{/if}">
    {/block}

    {stylesheets file='assets/dist/css/thelia.min.css'}
        <link rel="stylesheet" href="{$asset_url}">
    {/stylesheets}
    {stylesheets file='assets/dist/css/minnu.css'}
        <link rel="stylesheet" href="{$asset_url}">
    {/stylesheets}
    {*
     If you want to generate the CSS assets on the fly, just replace the stylesheet inclusion above by the following.
     Then, in your back-office, go to Configuration -> System Variables and set process_assets to 1.
     Now, when you're accessing the front office in developpement mode (index_dev.php)  the CSS is recompiled when a
     change in the source files is detected.

     See http://doc.thelia.net/en/documentation/templates/assets.html#activate-automatic-assets-generation for details.

    {stylesheets file='assets/src/less/thelia.less' filters='less'}
        <link rel="stylesheet" href="{$asset_url}">
    {/stylesheets}

    *}

    {hook name="main.stylesheet"}

    {block name="stylesheet"}{/block}

    {* Favicon *}
    <link rel="shortcut icon" type="image/x-icon" href="{image file='assets/dist/img/favicon.ico'}">
    <link rel="icon" type="image/png" href="{image file='assets/dist/img/favicon.png'}" />

    {* Feeds *}
    <link rel="alternate" type="application/rss+xml" title="{intl l='All products'}" href="{url path="/feed/catalog/%lang" lang=$lang_locale}" />
    <link rel="alternate" type="application/rss+xml" title="{intl l='All contents'}" href="{url path="/feed/content/%lang" lang=$lang_locale}" />
    <link rel="alternate" type="application/rss+xml" title="{intl l='All brands'}"   href="{url path="/feed/brand/%lang" lang=$lang_locale}" />
    {block name="feeds"}{/block}

    {* HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries *}
    <!--[if lt IE 9]>
    <script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>
    {javascripts file="assets/dist/js/vendors/html5shiv.min.js"}
        <script>window.html5 || document.write('<script src="{$asset_url}"><\/script>');</script>
    {/javascripts}

    <script src="//cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.js"></script>
    {javascripts file="assets/dist/js/vendors/respond.min.js"}
        <script>window.respond || document.write('<script src="{$asset_url}"><\/script>');</script>
    {/javascripts}
    <![endif]-->
   <script src="{javascript file='assets/dist/js/vendors/modernizr.custom.js'}"></script>

   <script src="{javascript file='assets/dist/js/vendors/dropzone.js'}"></script>
{literal}
    <!-- Start Alexa Certify Javascript -->
<script type="text/javascript">
_atrk_opts = { atrk_acct:"bt9Bn1QolK107i", domain:"hausfabrik.at",dynamic: true};
(function() { var as = document.createElement('script'); as.type = 'text/javascript'; as.async = true; as.src = "https://d31qbv1cthcecs.cloudfront.net/atrk.js"; var s = document.getElementsByTagName('script')[0];s.parentNode.insertBefore(as, s); })();
</script>
<noscript><img src="https://d5nxst8fruw4z.cloudfront.net/atrk.gif?account=bt9Bn1QolK107i" style="display:none" height="1" width="1" alt="" /></noscript>
<!-- End Alexa Certify Javascript -->
{/literal}

   
    <!--Start of Zopim Live Chat Script-->
     {literal} 
<script type="text/javascript">
window.$zopim||(function(d,s){var z=$zopim=function(c){z._.push(c)},$=z.s=
d.createElement(s),e=d.getElementsByTagName(s)[0];z.set=function(o){z.set.
_.push(o)};z._=[];z.set._=[];$.async=!0;$.setAttribute("charset","utf-8");
$.src="//v2.zopim.com/?3xaJNLlpfnXxE25TpnCVCaE9w7UtIkge";z.t=+new Date;$.
type="text/javascript";e.parentNode.insertBefore($,e)})(document,"script");
</script>
<script>
$zopim(function(){
          $zopim.livechat.prechatForm.setGreetings("welcome");
    });
</script>
<!--End of Zopim Live Chat Script-->
    
    
    
   <!-- Facebook Pixel Code -->
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window,document,'script',
'https://connect.facebook.net/en_US/fbevents.js');

 fbq('init', '1710133262638327'); 
fbq('track', 'PageView');
</script>
<noscript>
 <img height="1" width="1" 
src="https://www.facebook.com/tr?id=1710133262638327&ev=PageView
&noscript=1"/>
</noscript>
<!-- End Facebook Pixel Code -->
    
    
<!-- Begin Cookie Consent plugin by Silktide - http://silktide.com/cookieconsent -->
<script type="text/javascript">
    window.cookieconsent_options = {"message":"Diese Seite verwendet Cookies.Für eine uneingeschränkte Nutzung der Webseite werden Cookies benötigt. Bitte stimmen Sie der Verwendung von Cookies zu, um alle Funktionen der Webseite nutzen zu können. Detaillierte Informationen über den Einsatz von Cookies auf dieser Webseite erhalten Sie in unserer Datenschutzerklärung.","dismiss":"OK","learnMore":"Mehr erfahren","link":"http://www.hausfabrik.at/datenschutz.html","theme":"cookies"};
</script>
{/literal} 
 <script src="{javascript file='assets/dist/js/vendors/cookieconsent.min.js'}"></script>


<!-- End Cookie Consent plugin -->
   
    {hook name="main.head-bottom"}
</head>
<body class="{block name="body-class"}{/block}" itemscope itemtype="http://schema.org/WebPage">
    {hook name="main.body-top"}

    <!-- Accessibility -->
    <a class="sr-only" href="#content">{intl l="Skip to content"}</a>

    <div class="page" role="document">

        <div class="header-container" itemscope itemtype="http://schema.org/WPHeader">
            {hook name="main.header-top"}
            <div class="navbar navbar-default navbar-secondary" itemscope itemtype="http://schema.org/SiteNavigationElement">
                <!--div style="border-bottom:solid 0px; height:30px;background:#e8e8e8; color:#8D8D8D; text-align:center">
                    <div class="container">
                    <div class="col-sm-4"><span class="shopicon shop-lieferung  fa-flip-horizontal" style="font-size:25px; line-height:30px;vertical-align: middle; padding:3px 3px 3px 3px"></span>30 Tage Rückgabegarantie</div>
                    <div class="col-sm-4"><span class="shopicon shop-lieferung  fa-flip-horizontal" style="font-size:25px; line-height:30px;vertical-align: middle; padding:3px 3px 3px 3px"></span>15€ Neukundengutschein</div>
                    <div class="col-sm-4"><span class="shopicon shop-lieferung  fa-flip-horizontal" style="font-size:25px; line-height:30px;vertical-align: middle; padding:3px 3px 3px 3px"></span>Versandkostenfrei</div>
                        </div>
                </div-->
                <div class="container">
                
                    
                    <div class="navbar-header">
                        
                        <!-- .navbar-toggle is used as the toggle for collapsed navbar content -->
                        <!-- button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".nav-secondary">
                            <span class="sr-only">{intl l="Toggle navigation"}</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button-->
                        <a class="navbar-brand visible-xs" href="{navigate to="index"}">
                            <img src="{image file='assets/dist/img/logo.png'}" style="max-width:100px;" alt="{$store_name}">
                            <h3>IHR ONLINE INSTALLATEUR</h3>
                        </a>
                    </div>

                    {ifhook rel="main.navbar-secondary"}
                        {* Place everything within .nav-collapse to hide it until above 768px *}
                        <nav class="nav-secondary" role="navigation" aria-label="{intl l="Secondary Navigation"}"><!-- add class="navbar-collapse collapse" for mobile menu  -->
                            {hook name="main.navbar-secondary"}
                        </nav>
                    {/ifhook}
                </div>
            </div>
			
			<header class="container" role="banner">
                <h1 class="logo  hidden-xs col-sm-4" >
                        <a href="{navigate to="index"}" title="{$store_name}">
                            <img src="{image file='assets/dist/img/logo.png'}" style="max-width:200px" alt="{$store_name}">
                             <h1 class="slogan">IHR ONLINE INSTALLATEUR</h1>
                        </a> 
                </h1>
                           
                <!--div class="col-sm-4 zertifikat-logos">
               <img src={image file='assets/dist/img/installateur_fachbetrieb-logo.png'} style="width:80px">
                <img src={image file='assets/dist/img/shk_innung.png'}  style="width:80px">       
                </div-->
                
                <div class="hotline" itemscope itemtype="http://schema.org/Store">
               
                    <div class="hotline-icon"> <span></span></div>
                    <div class="hotline-text">
                    <h3 itemprop="telephone" content="0800/022573">0800/022573</h3>
                    <small itemprop="openingHours" content="Mo,Tu,We,Th 08:00-20:00, Fr:08:00-17:00"> Mo-Do:&nbsp; 8-20 Uhr<br>
                        Fr:  8-17 Uhr</small>
                    </div>               
                </div>
                <div style="clear:both"></div>
                <!--div class="events">
                    <div class="col-sm-1">
                    <h1 style="font-size:1.5em">BLACK FRIDAY</h1>
                        <h5>Tolle Angebote<br>
                       </h5>
                    </div>
                    <div class="col-sm-3">
                        <a href="/hansgrohe-handbrause-croma-select-s-multi-weiss-chrom-m.3-strahlarten-26800400-1.html"><img src="{image file='assets/dist/img/blackfriday/duschkopf.png'}"  alt="Hansgrohe Handbrause Raindance Select E120"> </a>
                    </div>
                     <div class="col-sm-3">
                       <a href="/Vaillant-Raumthermostat-calorMatic-250-0020170569-de.html"> <img src="{image file='assets/dist/img/blackfriday/thermostat.png'}"  alt="Vaillant Raumthermostat calorMatic 250"> </a>
                    </div>
                    <div class="col-sm-3">
                       <a href="/danfoss-link-starterkit.html"> <img src="{image file='assets/dist/img/blackfriday/danfosslink.png'}"  alt="Danfoss Link Starterkit"> </a>
                    </div>
                    <div class="col-sm-2">
                        <a href="/ap-brause-thermostat-grohtherm-2000-neu-o.-brausegarnitur-m.-rv-verchromt.html"><img src="{image file='assets/dist/img/blackfriday/brausengarnitur.png'}"  alt="AP-Brause-Thermostat Grohtherm 2000 NEU o. Brausegarnitur mit Halterungsbügel"> </a>
                    </div>
                </div-->
                <div class="header row">

                    
                    {hook name="main.navbar-primary"}
                </div>
            </header><!-- /.header -->
			
			

            {hook name="main.header-bottom"}
        </div><!-- /.header-container -->

        <main class="main-container" role="main">
            <div class="container">
                {hook name="main.content-top"}
                {block name="breadcrumb"}{include file="misc/breadcrumb.tpl"}{/block}
                <div id="content">{block name="main-content"}{/block}</div>
                {hook name="main.content-bottom"}
            </div><!-- /.container -->
        </main><!-- /.main-container -->
        

 
        
      <section class="footer-block">
                    <div class="container">
                        <div class="col col-sm-12 lieferungbedienungen">
                                <h6><strong>Alle Preise inkl. 20% MwSt.,<a href="/versandkosten.html"> zzgl. Versandkosten</a></strong></h6>  *unverbindliche Preisangabe der Hersteller<br>
                               <small><sup>1)</sup>Alle Lieferungen innerhalb Österreichs werden Versandkostenfrei geliefert  <!--Ab 300 EUR Warenwert versenden wir generell in einer Lieferung versandkostenfrei in folgende Länder : Österreich--> </small><br>
                            	<small><sup>2)</sup>Produkte welche nicht von uns bezogen wurden können nur nach Rücksprache montiert werden.</small><br>
                            	<small><sup>3)</sup>Das Angebot bezieht sich auf Ihre Angaben, und beinhaltet nur das Produkt ohne Montagematerial</small><br>
                        	<small>Produktabbildung kann abweichen</small><br>
                            <small>Die Ergebnisse aus dem Konfigurator haben keinen Anspruch auf Vollständigkeit der Produkte und Pakete.</small><br>
                            <small>Wenn Sie aber ein Angebot benötigen welches genau auf Sie zugeschnitten ist, füllen Sie bitte das Formular <a href="heizungskonfigurator-angebot"> <span style="color:#74A027;">NEUE HEIZUNG</span></a> aus.</small><br>
                            
                            <br>
                           
                    </div>
      </section>
            
            
        <section class="footer-container" itemscope itemtype="http://schema.org/WPFooter">
                            
            {ifhook rel="main.footer-top"}
                <section class="footer-block">
                    <div class="container">

                        
                        <div class="blocks row">
                            {hook name="main.footer-top"}
                        </div>
                    </div>
                </section>
            {/ifhook}
            {elsehook rel="main.footer-top"}
                
                <section class="footer-banner">
                    
                    <div class="container">

                        <div class="banner row banner-col-3">
                            <a href="versandkosten.html">
                                <div class="col col-sm-4">
                                <span class="shopicon shop-lieferung highlightcolor fa-flip-horizontal"></span>
                                <div><strong>{intl l="VERSANDKOSTEN UND LIEFERBEDINGUNGEN"}</strong></div> <div><br><small>{intl l="Der Versand der Ware ist innerhalb Österreichs Kostenlos! Die Standartlieferung erfolgt innerhalb von 1-3 Werktagen."}</small></div>
                                </div>
                            </a>
                            <div class="col col-sm-4">
                                <span class="shopicon shop-bezahlung highlightcolor"></span>
                                <div><strong>{intl l="BEZAHLUNG"} </strong></div><div><br><small>{intl l="Folgende Zahlungsmethoden stehen Ihnen zur Auswahl:"}</small></div>
                                <div>
                                    <img src="{image file='assets/dist/img/paymentsystems/paypal.png'}" alt="paypal"/>
                                    <img src="{image file='assets/dist/img/paymentsystems/sofort.png'}" alt="sofort"/>
                                    <img src="{image file='assets/dist/img/paymentsystems/nachnahme.jpg'}" alt="nachnahme"/>
                                </div>
                                <div>
                                    <img src="{image file='assets/dist/img/paymentsystems/visa.png'}" alt="visa"/>
                                    <img src="{image file='assets/dist/img/paymentsystems/mastercard.png'}" alt="mastercard"/>
                                    <img src="{image file='assets/dist/img/paymentsystems/amex.png'}" alt="amex"/>
                                </div>
                            </div>
                            <a href="contact">
                                <div class="col col-sm-4">
                                <span class="shopicon shop-kontakt highlightcolor"></span>
                                <div>
                                    <strong>{intl l="SUPPORT"} </strong>
                                </div>
                                <div itemscope itemtype="http://schema.org/Store">
                                    <h3 itemprop="telephone" content="0800/022573"><strong>{intl l="0800/022573"}</strong></h3>
                                    <span itemprop="openingHours" content="Mo,Tu,We,Th 08:00-20:00, Fr:08:00-17:00">
                                    <h5>Mo-Do: &nbsp;8-20 Uhr</h5>
                                    <h5>Fr:&nbsp; 8-17 Uhr</h5>
                                    </span>
                                </div>
                            </div>
                                </a>
                        </div>
                        
                        
                         
                    </div>
                   
                </section><!-- /.footer-banner -->
            {/elsehook}

{ifhook rel="main.footer-body"}

                    
                    <div class="container">
                        <div class="blocks row">
<div class="seo-text">
                            <div class="col-sm-6">
                            <h5>Die Hausfabrik ist Ihr verlässlicher Partner in den Bereichen Heizung, Klima und Sanitär. </h5>
                                    <small>
                                    In unserem Shop finden Sie eine große Auswahl an Produkten von Vaillant, Junkers, Grohe, Laufen und vielen mehr zu Bestpreisen, um Ihre Heizungs- und Klimaprojekte zu realisieren. Auch für Bad und WC gibt es ein großes Angebot an Armaturen, Duschköpfen und Toiletten.
Unsere Installateure stehen Ihnen für eine Vielzahl an Serviceleistungen zur Verfügung. Mieten Sie sich einen Installateur für eine Montage, Austausch, Inbetriebnahme oder für eine Wartung Ihrer Heizungstherme.</small> </div>
<div class="col-sm-6">
<h5>Warum sollten Sie einen Installateur der Hausfabrik beauftragen?</h5>
<small>Einen guten Installateur zu finden, kann sich schwierig gestalten. Unser Team verfügt über 40 Jahre Erfahrung und übt die Services mit Leidenschaft aus, unabhängig davon ob es sich dabei um eine Thermenwartung oder um eine Installation der neuen Heizung  handelt. Bei unseren Serviceleistungen und Angeboten gibt es keine versteckten Kosten. Sie erhalten ein unverbindliches Angebot und wir stehen Ihnen immer für Fragen oder Anregungen zur Verfügung.
Qualität zum Bestpreis - Damit Sie sich in Ihrem zu Hause wohl fühlen können.</small><br><br><br>
                                    </div>
                        </div>
                            <hr>
                            {hookblock name="main.footer-body"  fields="id,class,title,content"}
                            {forhook rel="main.footer-body"}
                                <div class="col col-sm-4">
                                    <section {if $id} id="{$id}"{/if} class="block {if $class} block-{$class}{/if}">
                                        <div class="block-heading"><h3 class="block-title">{$title}</h3></div>
                                        <div class="block-content">
                                            {$content nofilter}
                                        </div>
                                    </section>
                                </div>
                            {/forhook}
                            {/hookblock}
                        </div>
                    </div>
                     
                </section>
            {/ifhook}

            
            {ifhook rel="main.footer-bottom"}
                <footer class="footer-info" role="contentinfo">
                    <div class="container">
                        <div class="info row">
                            <div class="col-lg-9">
                                {hook name="main.footer-bottom"}
                            </div>
                            <div class="col-lg-3">
                                <section class="copyright">{intl l="Copyright"} &copy; <time datetime="{'Y-m-d'|date}">{'Y'|date}</time> <a href="http://www.hausfabrik.at" rel="external">HAUSFABRIK</a></section>
                            </div>
                        </div>
                    </div>
                </footer>
            {/ifhook}
            {elsehook rel="main.footer-bottom"}
                <footer class="footer-info" role="contentinfo">
                    <div class="container">
                        <div class="info row">
                            
                            
                            </div>
                            <nav class="nav-footer col-lg-9" role="navigation">
                                <ul class="list-unstyled list-inline">
                                	<li><a href="/presse.html">Presse</a></li>
                                	<li><a href="faq">Häufig gestellte Fragen (FAQ)</a></li>
                                    <li><a href="/agb.html">AGB</a></li>
                                    <li><a href="/datenschutz.html">Datenschutz</a></li>
                                    <li><a href="/impressum">Impressum</a></li>
                                    <li><a href="/widerrufsrecht.html">Widerrufsrecht</a></li>
                                    <li><a href="/wir-ueber-uns.html">Über uns</a></li>
                               		<!--li><a href="widerruf">Widerrufsrerklärung</a></li--> 
                                    <!--li><a href="faq">Häufig gestellte Fragen (FAQ)</a></li-->
                                </ul>
                                <!--ul class="list-unstyled list-inline">
                                    {$folder_information={config key="information_folder_id"}}
                                    {if $folder_information}
                                        {loop name="footer_links" type="content" folder=$folder_information}
                                            <li><a href="{$URL nofilter}">{$TITLE}</a></li>
                                        {/loop}
                                    {/if}
                                    <li><a href="{url path="/contact"}">{intl l="Contact Us"}</a></li>
                                </ul-->
                            </nav>
                            
                            <section class="copyright col-lg-3">{intl l="Copyright"} &copy; <time datetime="{'Y-m-d'|date}">{'Y'|date}</time> <a href="http://hausfabrik.at" rel="external">HAUSFABRIK</a></section>
                        </div>
                    </div>
                </footer><!-- /.footer-info -->
            {/elsehook}

        </section><!-- /.footer-container -->

    </div><!-- /.page -->
	
	<!--<div class="sehrgut"><img src={image file='assets/dist/img/sehrgut.png'}></div>-->

    {block name="before-javascript-include"}{/block}
    <!-- JavaScript -->

    <!-- Jquery -->
    <!--[if lt IE 9]><script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script> <![endif]-->
    <!--[if (gte IE 9)|!(IE)]><!--><script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script><!--<![endif]-->
    {javascripts file="assets/dist/js/vendors/jquery.min.js"}
        <script>window.jQuery || document.write('<script src="{$asset_url}"><\/script>');</script>
    {/javascripts}

    <script src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.13.1/jquery.validate.min.js"></script>
    {* do no try to load messages_en, as this file does not exists *}
    {if $lang_code != 'en'}
        <script src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.13.1/localization/messages_{$lang_code}.js"></script>
    {/if}

    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    {javascripts file="assets/dist/js/vendors/bootstrap.min.js"}
        <script>if(typeof($.fn.modal) === 'undefined') { document.write('<script src="{$asset_url}"><\/script>'); }</script>
    {/javascripts}

    {javascripts file="assets/dist/js/vendors/bootbox.js"}
        <script src="{$asset_url}"></script>
    {/javascripts}

    {hook name="main.after-javascript-include"}
   

    {block name="after-javascript-include"}{/block}

    {hook name="main.javascript-initialization"}
    <script>
       // fix path for addCartMessage
       // if you use '/' in your URL rewriting, the cart message is not displayed
       // addCartMessageUrl is used in thelia.js to update the mini-cart content
       var addCartMessageUrl = "{url path='ajax/addCartMessage'}";
    </script>
    {block name="javascript-initialization"}{/block}

    <!-- Custom scripts -->
    <script src="{javascript file='assets/dist/js/thelia.min.js'}"></script>
    {literal}
    <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-78676875-1', 'auto');
  ga('send', 'pageview');

</script>
    {/literal}

    {hook name="main.body-bottom"}
    {literal}
    <script type="text/javascript">
  (function () { 
    var _tsid = 'X4697574E7CAA9A55A32AFAD36E190BEF'; 
    _tsConfig = { 
      'yOffset': '0', /* offset from page bottom */
      'variant': 'reviews', /* text, default, small, reviews, custom, custom_reviews */
      'customElementId': '', /* required for variants custom and custom_reviews */
      'trustcardDirection': '', /* for custom variants: topRight, topLeft, bottomRight, bottomLeft */
      'customBadgeWidth': '', /* for custom variants: 40 - 90 (in pixels) */
      'customBadgeHeight': '', /* for custom variants: 40 - 90 (in pixels) */
      'disableResponsive': 'false', /* deactivate responsive behaviour */
      'disableTrustbadge': 'false', /* deactivate trustbadge */
      'trustCardTrigger': 'mouseenter', /* set to 'click' if you want the trustcard to be opened on click instead */
      'customCheckoutElementId': 'customCheckoutDiv' 
    };
    var _ts = document.createElement('script');
    _ts.type = 'text/javascript'; 
    _ts.charset = 'utf-8'; 
    _ts.async = true; 
    _ts.src = '//widgets.trustedshops.com/js/' + _tsid + '.js'; 
    var __ts = document.getElementsByTagName('script')[0];
    __ts.parentNode.insertBefore(_ts, __ts);
  })();
</script>
{/literal}
</body>
</html>
