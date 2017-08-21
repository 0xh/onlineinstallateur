<?php

namespace HookAdminCrawlerDashboard\Controller\Crawler;
use HookAdminCrawlerDashboard\Controller\Crawler\Crawler;

class IdealoCrawler extends Crawler implements CrawlerInterface{
	
	/**
	 * {@inheritDoc}
	 * @see CrawlerInterface::init()
	 */
	public function init_crawler() {
		
		//base configuration
		$this->setPlatformName("Idealo");
		$this->setServiceLinks("https://www.idealo.at/", "preisvergleich/MainSearchProductCategory.html?q=");
		$this->setProductPlatformIdMarker('"product_ids":[', '],"product_names');
		$this->setHausfabrikOfferMarker("hausfabrik");
		
		//productPage
		$this->setProductPath('preisvergleich/OffersOfProduct/');
		$this->setProductExternalLinkMarker('button--leadout expand" href="','" data-after');
		$this->setProductResultMarker('li class="productOffers-listItem row', "productOffers-listItemOfferLink");
		//$this->setPriceResultMarker('€�&nbsp;', "&lt;/a&gt;&lt;br&gt;");
		$this->setPriceResultMarker('price=', '&amp');
		$this->setPositionResultMarker('&quot;id&quot;: &quot;offer.price&quot;, &quot;params&quot; : [&quot;&quot;, &quot;','&quot;',0);
		
		$this->setRequest('
<script id="tagManagerDataLayer">
var utag_data = [{"site_tld":"at","page_type":"MAIN_SEARCH_PRODUCT_CATEGORY","site_currency":"EUR","page_levels":["Suche"],"self_product_category_id":100,"product_ids":[991820],"product_names":["Grohe Costa UP-Ventil Oberbau (19808)"],"product_category_ids":[18931]}];
</script>

<body id="offersofproduct" data-app-context="">
<noscript>
&lt;iframe src="//www.googletagmanager.com/ns.html?id=GTM-PDXTT2" height="0" width="0" style="display:none;visibility:hidden"&gt;&lt;/iframe&gt;
</noscript>
<script id="googleTagManager">
(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({"gtm.start":
new Date().getTime(),event:"gtm.js"});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!="dataLayer"?"&l="+l:"";j.async=true;j.src=
"//www.googletagmanager.com/gtm.js?id="+i+dl+"";f.parentNode.insertBefore(j,f);
})(window,document,"script","utag_data","GTM-PDXTT2");
</script>
<div class="page-wrapper">
<div class="main-section">
<header class="pageHeader-wrapper">
<div class="pageHeader-top">
<div class="pageHeader-logo">
<a class="pageHeader-logoLink" href="/">
<img src="//cdn.idealo.com/ipc/95351d/rwd/img/logo-idealo.svg" width="125" height="38" alt="idealo - �sterreichs gro�er Preisvergleich">
</a>
</div>
</div>
<div class="pageHeader-bottom">
<div class="row">
<div class="pageHeader-category">
<a class="toolbar-categoryLink" href="/preisvergleich/Sitemap.html">
<span class="toolbar-categoryLinkHamburger">
<span class="toolbar-categoryLinkHamburgerBox">
<span class="toolbar-categoryLinkHamburgerBoxInner"></span>
</span>
</span>
<span class="toolbar-categoryLinkTitle">Kategorien</span>
</a>
</div>
<div class="pageHeader-search">
<div class="search" itemscope="" itemtype="http://schema.org/WebSite">
<meta itemprop="url" content="https://www.idealo.at/">
<form class="search-form" action="/preisvergleich/MainSearchProductCategory.html" method="get" itemprop="potentialAction" itemscope="" itemtype="http://schema.org/SearchAction">
<meta itemprop="target" content="https://www.idealo.at/preisvergleich/MainSearchProductCategory.html?q={q}">
<input itemprop="query-input" class="search-formInput" name="q" value="" placeholder="Ich suche..." type="text" autocapitalize="off" autocomplete="off" autocorrect="off" spellcheck="false" data-search="" data-suggest="{
&quot;i18nCategoriesSearchTerms&quot; : &quot;Kategorien und Suchbegriffe&quot;,
&quot;i18nProducts&quot; : &quot;Produkte&quot;,
&quot;i18nResults&quot; : &quot;Ergebnisse&quot;,
&quot;i18nManufacturer&quot; : &quot;Hersteller&quot;,
&quot;i18nNoResults&quot; : &quot;Leider nichts gefunden&quot;,
&quot;i18nQueries&quot; : &quot;Suchanfragen&quot;,
&quot;i18nShop&quot; : &quot;Shops&quot;,
&quot;i18nShowResults&quot; : &quot;Alle Ergebnisse anzeigen&quot;,
&quot;siteId&quot; : 2
}">
<button class="search-formButton icon-search" title="Suchen" type="submit"></button>
</form>
</div>
</div>
<div class="pageHeader-login">
<a class="myIdealo-link" href="/preisvergleich/merkzettel">
<div class="myIdealo-linkIcon">
<span class="myIdealo-linkIconClose icon-cancel-thin"></span>
<span class="myIdealo-linkIconBookmark icon-bookmarked"></span>
</div>
<span class="myIdealo-linkTitle">Merkzettel</span>
</a>
</div>
</div>
</div>
</header>
<div class="row hide-for-medium-down">
<div class="small-12 columns">
<div class="breadcrumb" data-breadcrumb="" itemscope="" itemtype="http://schema.org/BreadcrumbList">
<span class="breadcrumb-home">
<a class="breadcrumb-link breadcrumb-link--home icon-home" data-type="home" href="/"></a>
</span>
<span class="breadcrumb-leaf" itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
<span class="breadcrumb-leafSeparator icon icon-arrow-right-thin"></span>
<a class="breadcrumb-link breadcrumb-link--leaf" itemscope="" itemtype="http://schema.org/Thing" itemprop="item" data-type="product_subcategory" rel="" href="/preisvergleich/SubProductCategory/3686.html">
<span class="breadcrumb-linkText" itemprop="name">Heimwerken &amp; Garten</span>
</a>
<meta itemprop="position" content="1">
</span>
<span class="breadcrumb-leaf" itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
<span class="breadcrumb-leafSeparator icon icon-arrow-right-thin"></span>
<a class="breadcrumb-link breadcrumb-link--leaf" itemscope="" itemtype="http://schema.org/Thing" itemprop="item" data-type="product_subcategory" rel="" href="/preisvergleich/SubProductCategory/12953.html">
<span class="breadcrumb-linkText" itemprop="name">Sanit�r &amp; Armaturen</span>
</a>
<meta itemprop="position" content="2">
</span>
<span class="breadcrumb-leaf" itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
<span class="breadcrumb-leafSeparator icon icon-arrow-right-thin"></span>
<a class="breadcrumb-link breadcrumb-link--leaf" itemscope="" itemtype="http://schema.org/Thing" itemprop="item" data-type="product_subcategory" rel="" href="/preisvergleich/SubProductCategory/11312.html">
<span class="breadcrumb-linkText" itemprop="name">Badarmaturen</span>
</a>
<meta itemprop="position" content="3">
</span>
<span class="breadcrumb-leaf" itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
<span class="breadcrumb-leafSeparator icon icon-arrow-right-thin"></span>
<a class="breadcrumb-link breadcrumb-link--leaf" itemscope="" itemtype="http://schema.org/Thing" itemprop="item" data-type="product_category" rel="" href="/preisvergleich/ProductCategory/18928.html">
<span class="breadcrumb-linkText" itemprop="name">Wannenarmaturen</span>
</a>
<meta itemprop="position" content="4">
</span>
</div>
</div>
</div>
<main class="pageContent-wrapper">
<script type="application/ld+json">
{"@context":"http://schema.org","@type":"ProductModel","aggregateRating":{"@type":"AggregateRating","ratingValue":0.0,"reviewCount":0},"name":"Grohe Grohtherm 3000 C Thermostat (19468000)","offers":{"@type":"AggregateOffer","lowPrice":189.95,"priceCurrency":"EUR","offerCount":18},"manufacturer":{"@type":"Organization","name":"Grohe"},"image":"http://cdn.idealo.com/folder/Product/2317/5/2317555/s2_produktbild_klein/grohe-grohtherm-3000-c-thermostat-19468000.png","isRelatedTo":[{"@type":"Product","url":"/preisvergleich/OffersOfProduct/4882506_-logis-71400000-hansgrohe.html"},{"@type":"Product","url":"/preisvergleich/OffersOfProduct/1005582_-uno-einhebel-wannenmischer-aufputz-chrom-38400-axor.html"},{"@type":"Product","url":"/preisvergleich/OffersOfProduct/2693163_-supernova-einhandbatterie-fuer-up-36015730-dornbracht.html"},{"@type":"Product","url":"/preisvergleich/OffersOfProduct/4843597_-grandera-wannenbatterie-23317ig0-grohe.html"},{"@type":"Product","url":"/preisvergleich/OffersOfProduct/1840082_-plan-einhebel-wannenmischer-up-54972-keuco.html"},{"@type":"Product","url":"/preisvergleich/OffersOfProduct/4843585_-grandera-wannenbatterie-19920000-grohe.html"},{"@type":"Product","url":"/preisvergleich/OffersOfProduct/4968515_-plan-blue-einhebelmischer-up-keuco.html"},{"@type":"Product","url":"/preisvergleich/OffersOfProduct/3958132_-grohtherm-2000-34174001-grohe.html"},{"@type":"Product","url":"/preisvergleich/OffersOfProduct/4843275_-essence-33628001-grohe.html"},{"@type":"Product","url":"/preisvergleich/OffersOfProduct/4843269_-essence-23491001-grohe.html"},{"@type":"Product","url":"/preisvergleich/OffersOfProduct/3932904_-concetto-32211001-grohe.html"},{"@type":"Product","url":"/preisvergleich/OffersOfProduct/2378518_-zenta-38670-kludi.html"},{"@type":"Product","url":"/preisvergleich/OffersOfProduct/4944765_-objekta-wannen-einhandmischer-326530575-kludi.html"},{"@type":"Product","url":"/preisvergleich/OffersOfProduct/2340841_-zenta-38660-kludi.html"},{"@type":"Product","url":"/preisvergleich/OffersOfProduct/4952996_-e2-wannen-einhandmischer-up-496500575-kludi.html"},{"@type":"Product","url":"/preisvergleich/OffersOfProduct/4949306_-metris-einhebel-wannenmischer-up-31454000-hansgrohe.html"},{"@type":"Product","url":"/preisvergleich/OffersOfProduct/1731833_-focus-e-chrom-31945000-hansgrohe.html"}],"isVariantOf":{"@type":"Product","url":"https://www.idealo.at/preisvergleich/OffersOfProduct/2317555_-grohtherm-3000-c-thermostat-19468000-grohe.html"}}
</script>
<div class="hide" data-addisplay="{
&quot;countryCode&quot;: &quot;at&quot;,
&quot;slot&quot; : {
&quot;man&quot;: &quot;Grohe&quot;,
&quot;pt&quot;: &quot;OffersOfProduct&quot;,
&quot;cat&quot;: &quot;18928&quot;,
&quot;lvl1&quot;: &quot;100&quot;,
&quot;lvl2&quot;: &quot;3686&quot;,
&quot;lvl3&quot;: &quot;12953&quot;,
&quot;lvl4&quot;: &quot;11312&quot;,
&quot;lvl5&quot;: &quot;18928&quot;
}
}">&nbsp;</div>
<div class="hide" data-recentproducts="{&quot;emptyText&quot;:&quot;Du hast noch keine Produkte angeschaut&quot;,&quot;id&quot;:2317555,&quot;idType&quot;:&quot;PRODUCT&quot;,&quot;productName&quot;:&quot;Grohe Grohtherm 3000 C Thermostat (19468000)&quot;,&quot;productUrl&quot;:&quot;/preisvergleich/OffersOfProduct/2317555_-grohtherm-3000-c-thermostat-19468000-grohe.html&quot;,&quot;productImage&quot;:&quot;//cdn.idealo.com/folder/Product/2317/5/2317555/s2_produktbild_mittelgross/grohe-grohtherm-3000-c-thermostat-19468000.png&quot;}">&nbsp;</div>
<div class="oopStage" data-wt="oopStage">
<div class="row row-24">
<div class="oopStage-gallery small-9 large-4 xlarge-6 columns">
<!-- TODO: add class to set 75% width when there is a leadoutbox -->
<div id="gallery" class="royalSlider rsIpc withLeadoutBox rsHor rsWithThumbs rsWithThumbsVer" data-tagmanager-id="gallery" style="height: 241.667px;"><div class="rsOverflow" style="width: 238px; height: 194px;"><div class="rsContainer" style="transition-duration: 0s; transform: translate3d(0px, 0px, 0px);"><div style="left: 0px;" class="rsSlide "><img class="rsImg rsMainSlideImage" src="//cdn.idealo.com/folder/Product/2317/5/2317555/s2_produktbild_gross/grohe-grohtherm-3000-c-thermostat-19468000.png" style="visibility: visible; opacity: 1; transition: opacity 400ms ease-in-out; width: 224px; height: 186px; margin-left: 7px; margin-top: 4px;"></div><div style="left: 268px;" class="rsSlide "><img class="rsImg rsMainSlideImage" src="//cdn.idealo.com/folder/Product/2317/5/2317555/s2_produktbild_gross_1/grohe-grohtherm-3000-c-thermostat-19468000.png" style="width: 224px; height: 186px; margin-left: 7px; margin-top: 4px;"></div></div><div class="rsFullscreenBtn"><div class="rsFullscreenIcn"></div></div><div class="rsArrow rsArrowLeft rsArrowDisabled" style="display: block;"><div class="rsArrowIcn"></div></div><div class="rsArrow rsArrowRight" style="display: block;"><div class="rsArrowIcn"></div></div></div><div class="rsNav rsThumbs rsThumbsVer"><div class="rsThumbsContainer" style="transition-property: -webkit-transform; transform: translate3d(0px, 55.5px, 0px); height: 88px;"><div style="margin-bottom:4px;" class="rsNavItem rsThumb rsNavSelected"><div class="rsTmb ">
<img data-rsvideo="" src="//cdn.idealo.com/folder/Product/2317/5/2317555/s2_produktbild_klein/grohe-grohtherm-3000-c-thermostat-19468000.png" alt="Grohe Grohtherm 3000 C Thermostat (19468000)">
</div></div><div style="margin-bottom:4px;" class="rsNavItem rsThumb"><div class="rsTmb ">
<img data-rsvideo="" src="//cdn.idealo.com/folder/Product/2317/5/2317555/s2_produktbild_klein_1/grohe-grohtherm-3000-c-thermostat-19468000.png" alt="Grohe Grohtherm 3000 C Thermostat (19468000)">
</div></div></div><div class="rsThumbsArrow rsThumbsArrowLeft rsThumbsArrowDisabled"><div class="rsThumbsArrowIcn"></div></div><div class="rsThumbsArrow rsThumbsArrowRight rsThumbsArrowDisabled"><div class="rsThumbsArrowIcn"></div></div></div><div class="rsSlideCount">1/2</div></div>
<span class="rsBackBtn-overlay-close rsBackBtn-overlay-close--topLeft rsBackBtn">
<span class="rsBackBtn-overlay-closeInner icon-arrow-left-thin">
Zur�ck
</span>
</span>
<div class="leadoutbox hide">
<div class="leadoutbox-title">
Grohe Grohtherm 3000 C Thermostat (19468000)
</div>
<div class="leadoutbox-price">
<div class="leadoutbox-priceLabel">G�nstigster Preis</div>
<a target="_blank" data-wt-click="{&quot;id&quot;: &quot;leadout&quot;, &quot;params&quot; : [&quot;&quot;,&quot;&quot;,&quot;gallery.leadoutbox.price&quot;]}" data-checkout="false" href="/preisvergleich/Relocate/7733253093.html?categoryId=18928&amp;price=189.95&amp;productid=2317555&amp;sid=23026&amp;type=offer&amp;pos=-2" class="leadoutbox-priceAmount" rel="nofollow">�&nbsp;189,95
</a>
<span>zzgl. Versand</span>
<div class="leadoutbox-priceBase"></div>
</div>
<a target="_blank" data-wt-click="{&quot;id&quot;: &quot;leadout&quot;, &quot;params&quot; : [&quot;&quot;,&quot;&quot;,&quot;gallery.leadoutbox.button&quot;]}" data-checkout="false" href="/preisvergleich/Relocate/7733253093.html?categoryId=18928&amp;price=189.95&amp;productid=2317555&amp;sid=23026&amp;type=offer&amp;pos=-2" class="button button--leadout expand" rel="nofollow">Zum Shop</a>
<div class="leadoutbox-shop">Shop:
<a target="_blank" data-wt-click="{&quot;id&quot;: &quot;leadout&quot;, &quot;params&quot; : [&quot;&quot;,&quot;&quot;,&quot;gallery.leadoutbox.shopname&quot;]}" data-checkout="false" href="/preisvergleich/Relocate/7733253093.html?categoryId=18928&amp;price=189.95&amp;productid=2317555&amp;sid=23026&amp;type=offer&amp;pos=-2" rel="nofollow">ssd-armaturenshop.de
</a>
</div>
<div data-wt-click="{&quot;id&quot;: &quot;gallery.close.show_offers&quot;}" class="button button--transparent expand leadoutbox-moreOffersLink">Weitere Angebote anzeigen</div>
</div>
<div class="show-for-xlarge-up">
<div class="oopStage-actionFavourites tooltip" data-tooltip="Produkt merken" data-wishlist-button="{&quot;markedOnWishList&quot;:false,&quot;action&quot;:&quot;/preisvergleich/merkzettel/P/2317555/&quot;,&quot;labelIsOnWishList&quot;:&quot;Gemerkt&quot;,&quot;labelIsNotOnWishList&quot;:&quot;Merken&quot;,&quot;hoverLabelForActiveWishlistButton&quot;:&quot;Produkt in �Mein idealo� gemerkt&quot;,&quot;hoverLabelForInactiveWishlistButton&quot;:&quot;Produkt merken&quot;}">
<span class="addToWishListButton oopStage-actionFavouritesIcon icon-bookmark"></span>
</div>
</div>
<div class="favouritesWrapper">
<div class="oopStage-actionFavourites tooltip" data-tooltip="Produkt merken" data-wishlist-button="{&quot;markedOnWishList&quot;:false,&quot;action&quot;:&quot;/preisvergleich/merkzettel/P/2317555/&quot;,&quot;labelIsOnWishList&quot;:&quot;Gemerkt&quot;,&quot;labelIsNotOnWishList&quot;:&quot;Merken&quot;,&quot;hoverLabelForActiveWishlistButton&quot;:&quot;Produkt in �Mein idealo� gemerkt&quot;,&quot;hoverLabelForInactiveWishlistButton&quot;:&quot;Produkt merken&quot;}">
<span class="addToWishListButton oopStage-actionFavouritesIcon icon-bookmark"></span>
</div>
</div>
</div>
<div class="oopStage-sidebar small-3 large-2 large-push-6 hide-for-xlarge-up columns text-center">
<div class="oopStage-action">
<div class="oopStage-actionFavourites tooltip" data-tooltip="Produkt merken" data-wishlist-button="{&quot;markedOnWishList&quot;:false,&quot;action&quot;:&quot;/preisvergleich/merkzettel/P/2317555/&quot;,&quot;labelIsOnWishList&quot;:&quot;Gemerkt&quot;,&quot;labelIsNotOnWishList&quot;:&quot;Merken&quot;,&quot;hoverLabelForActiveWishlistButton&quot;:&quot;Produkt in �Mein idealo� gemerkt&quot;,&quot;hoverLabelForInactiveWishlistButton&quot;:&quot;Produkt merken&quot;}">
<span class="addToWishListButton oopStage-actionFavouritesIcon icon-bookmark"></span>
</div>
<div class="oopStage-actionPricechart show-for-large-down" data-overlay="{
&quot;closeCaption&quot; : &quot;zur�ck &quot;,
&quot;contentLoadBy&quot; : &quot;ajax&quot;,
&quot;contentLoad&quot; : &quot;/pricechart/2317555&quot;,
&quot;contentPaddingBottom&quot; : &quot;50px&quot;,
&quot;contentPaddingTop&quot; : &quot;50px&quot;,
&quot;triggerCloseEvent&quot; : &quot;closeOverlay&quot;,
&quot;triggerOnOpen&quot; : &quot;pricechart-open&quot;,
&quot;webtrekkPrefix&quot; : &quot;pricechart&quot;
}">
<span class="oopStage-actionPricechartIcon icon-pricechart">
<span class="show-for-xlarge-up hide">
Preisentwicklung
</span>
</span>
</div>
<div class="oopStage-actionPricewatcher button--pricewatcher" data-overlay="{
&quot;closeCaption&quot;: &quot;zur�ck&quot;,
&quot;contentLoad&quot; : &quot;/mvc/RwdAddWatchedProduct/2317555&quot;,
&quot;contentLoadBy&quot;: &quot;ajax&quot;,
&quot;forceOpen&quot;: &quot;true&quot;,
&quot;triggerCloseEvent&quot;: &quot;closeOverlay&quot;,
&quot;triggerOnOpen&quot;: &quot;pricewatcher-open&quot;,
&quot;webtrekkPrefix&quot; : &quot;pricewatcher&quot;
}">
<span class="oopStage-actionPricewatcherIcon icon-pricewatcher">
<span class="oopStage-actionPricewatcherTitle hide show-for-xlarge-up">
Preiswecker
</span>
</span>
</div>
</div>
</div>
<div class="oopStage-details small-12 large-6 large-pull-2 xlarge-12 xlarge-pull-0 columns left">
<h1 class="oopStage-title">
Grohe Grohtherm 3000 C Thermostat (19468000)
</h1>
<div class="oopStage-metaInfo row table" data-oop-stage="">
<a data-scrolling-anchor="" href="#offerList" data-wt-click="{&quot;id&quot;:&quot;oop.productstage.pricerange&quot;}" class="oopStage-priceRange table-row">
<span class="table-cell oopStage-priceRangeOffers">18 Angebote:</span>
<span class="table-cell oopStage-priceRangePrice">�&nbsp;189,95 � �&nbsp;262,83</span>
</a>
<div class="table-row">
<a class="oopStage-metaInfoItemAction table-cell oopStage-metaInfoItemActionLabel oopStage-metaInfoItemRatingLabel" data-scrolling-anchor="" href="#Meinungen">
0 Produktmeinungen:
</a>
<a class="oopStage-metaInfoItemAction oopStage-metaInfoItemActionLabel oopStage-metaInfoItemActionWriteReview table-cell" href="#" data-overlay="{
"closeCaption": "Zur�ck",
"contentLoad": "/mvc/RwdProductOpinion/product/2317555",
"contentLoadBy": "ajax",
"contentPaddingLeft": "1rem",
"contentPaddingRight": "1rem",
"eventsOn": "click",
"webtrekkPrefix": "writereview",
"triggerOnOpen": "writeReviewOpen"
}">
Produktmeinung auf idealo verfassen
</a>
</div>
</div>
<div class="oopStage-productInfo row" data-oop-stage="">
<div class="oopStage-productInfoTop small-12 collapse-both columns truncate">
<span class="oopStage-productInfoTopItemWrapper truncate">
<span class="oopStage-productInfoTopItem">
<a href="/preisvergleich/ProductCategory/18928F1748515.html" rel="" data-wt-click="{"id" : "oop.stage.product.category.link.click"}">
Einhand-Wannenbatterie</a>
</span>
<span class="oopStage-productInfoTopItem">
Chrom
</span>
<span class="oopStage-productInfoTopItem">
Bedienungshebel
</span>
<span class="oopStage-productInfoTopItem">
Wandmontage
</span>
<span class="oopStage-productInfoTopItemWrapperDatasheetLink">
<div class="oopStage-productInfoBottomDatasheet" data-overlay="{
&quot;closeCaption&quot; : &quot;zur�ck&quot;,
&quot;contentLoad&quot; : &quot;.datasheet&quot;,
&quot;contentLoadBy&quot; : &quot;selector&quot;,
&quot;titleCaption&quot; : &quot;Datenblatt&quot;,
&quot;titleSize&quot; : &quot;xlarge&quot;,
&quot;titleAlign&quot; : &quot;left&quot;,
&quot;triggerOnClose&quot; : &quot;datasheet-close&quot;,
&quot;triggerOnOpen&quot; : &quot;datasheet-open&quot;
}" data-wt="datasheet">
<a href="#Datenblatt" data-overlay-title="Datenblatt">
Produktdatenblatt
</a>
</div>
</span>
</span>
<div class="hide oopStage-productInfoTopItemWrapperDatasheetLinkBelow" data-show-on-ellipsis="{
&quot;truncatedWrapperClass&quot; : &quot;oopStage-productInfoTopItemWrapper&quot;
}">
<div class="oopStage-productInfoBottomDatasheet" data-overlay="{
&quot;closeCaption&quot; : &quot;zur�ck&quot;,
&quot;contentLoad&quot; : &quot;.datasheet&quot;,
&quot;contentLoadBy&quot; : &quot;selector&quot;,
&quot;titleCaption&quot; : &quot;Datenblatt&quot;,
&quot;titleSize&quot; : &quot;xlarge&quot;,
&quot;titleAlign&quot; : &quot;left&quot;,
&quot;triggerOnClose&quot; : &quot;datasheet-close&quot;,
&quot;triggerOnOpen&quot; : &quot;datasheet-open&quot;
}" data-wt="datasheet">
<a href="#Datenblatt" data-overlay-title="Datenblatt">
Produktdatenblatt
</a>
</div>
</div>
</div>
<div class="oopStage-productInfoBottom small-12 collapse-both columns">
<a class="oopStage-productInfoBottomReadMore hidden-for-large-up hide" data-show-on-ellipsis="{&quot;truncatedWrapperClass&quot; : &quot;oopStage-productInfoTop&quot;,
&quot;singleLineTruncation&quot; : true}" href="#moreMainDetails">
mehr anzeigen
</a>
<span class="hidden-for-large-up">
<div class="oopStage-productInfoBottomDatasheet" data-overlay="{
&quot;closeCaption&quot; : &quot;zur�ck&quot;,
&quot;contentLoad&quot; : &quot;.datasheet&quot;,
&quot;contentLoadBy&quot; : &quot;selector&quot;,
&quot;titleCaption&quot; : &quot;Datenblatt&quot;,
&quot;titleSize&quot; : &quot;xlarge&quot;,
&quot;titleAlign&quot; : &quot;left&quot;,
&quot;triggerOnClose&quot; : &quot;datasheet-close&quot;,
&quot;triggerOnOpen&quot; : &quot;datasheet-open&quot;
}" data-wt="datasheet">
<a href="#Datenblatt" data-overlay-title="Datenblatt">
Produktdatenblatt
</a>
</div>
</span>
</div>
<div class="oopStage-productInfoButtons hide show-for-xlarge-up small-12 collapse-both columns">
<div class="oopStage-actionPricechart show-for-large-down" data-overlay="{
&quot;closeCaption&quot; : &quot;zur�ck &quot;,
&quot;contentLoadBy&quot; : &quot;ajax&quot;,
&quot;contentLoad&quot; : &quot;/pricechart/2317555&quot;,
&quot;contentPaddingBottom&quot; : &quot;50px&quot;,
&quot;contentPaddingTop&quot; : &quot;50px&quot;,
&quot;triggerCloseEvent&quot; : &quot;closeOverlay&quot;,
&quot;triggerOnOpen&quot; : &quot;pricechart-open&quot;,
&quot;webtrekkPrefix&quot; : &quot;pricechart&quot;
}">
<span class="oopStage-actionPricechartIcon icon-pricechart">
<span class="show-for-xlarge-up hide">
Preisentwicklung
</span>
</span>
</div>
</div>
</div>
</div>
<div class="xlarge-6 columns show-for-xlarge-up newPriceChart--small" data-label-today="heute" data-label-yesterday="" data-stage-pricechart="{&quot;rel&quot;:&quot;self&quot;,&quot;href&quot;:&quot;https://www.idealo.at/priceChartApi/2317555?period=P3M&quot;}" style="visibility: visible;">
<div class="newPriceChart--smallHead">
<span class="newPriceChart--smallHeadTitle">Preisentwicklung</span>
<ul class="newPriceChart--smallHeadLinks">
<li>
3M
</li>
<li>
<a data-overlay="{ &quot;triggerOnOpenParams&quot; : 2, &quot;closeCaption&quot; : &quot;zur�ck &quot;,
&quot;contentLoadBy&quot; : &quot;ajax&quot;,
&quot;contentLoad&quot; : &quot;/pricechart/2317555&quot;,
&quot;contentPaddingBottom&quot; : &quot;50px&quot;,
&quot;contentPaddingTop&quot; : &quot;50px&quot;,
&quot;triggerCloseEvent&quot; : &quot;closeOverlay&quot;,
&quot;triggerOnOpen&quot; : &quot;pricechart-open&quot;,
&quot;webtrekkPrefix&quot; : &quot;pricechart&quot;}">
6M
</a>
</li>
<li>
<a data-overlay="{ &quot;triggerOnOpenParams&quot; : 3, &quot;closeCaption&quot; : &quot;zur�ck &quot;,
&quot;contentLoadBy&quot; : &quot;ajax&quot;,
&quot;contentLoad&quot; : &quot;/pricechart/2317555&quot;,
&quot;contentPaddingBottom&quot; : &quot;50px&quot;,
&quot;contentPaddingTop&quot; : &quot;50px&quot;,
&quot;triggerCloseEvent&quot; : &quot;closeOverlay&quot;,
&quot;triggerOnOpen&quot; : &quot;pricechart-open&quot;,
&quot;webtrekkPrefix&quot; : &quot;pricechart&quot;}">
1J
</a>
</li>
</ul>
</div>
<div class="newPriceChart-smallWrapper">
<a data-overlay="{&quot;closeCaption&quot; : &quot;zur�ck &quot;,
&quot;contentLoadBy&quot; : &quot;ajax&quot;,
&quot;contentLoad&quot; : &quot;/pricechart/2317555&quot;,
&quot;contentPaddingBottom&quot; : &quot;50px&quot;,
&quot;contentPaddingTop&quot; : &quot;50px&quot;,
&quot;triggerCloseEvent&quot; : &quot;closeOverlay&quot;,
&quot;triggerOnOpen&quot; : &quot;pricechart-open&quot;,
&quot;webtrekkPrefix&quot; : &quot;pricechart&quot;}" class="newPriceChart--smallCanvasLink"><iframe class="chartjs-hidden-iframe" tabindex="-1" style="display: block; overflow: hidden; border: 0px; margin: 0px; top: 0px; left: 0px; bottom: 0px; right: 0px; height: 100%; width: 100%; position: absolute; pointer-events: none; z-index: -1;"></iframe>
<canvas class="newPriceChart--smallCanvas" id="ipc-stage-price-chart" width="362" height="243" style="display: block; height: 195px; width: 290px;"></canvas>
<div id="chartjs-tooltip" class="center" style="left: 198px; text-align: right; opacity: 1; top: 0px; padding: 3px 5px;"><p>� 189,95</p><span class="chartjs-tooltip-key" style="background:rgba(0, 0, 0, 0.01)"></span>heute</div></a>
</div>
<div class="oopStage-actionPricewatcher button--pricewatcher" data-overlay="{
&quot;closeCaption&quot;: &quot;zur�ck&quot;,
&quot;contentLoad&quot; : &quot;/mvc/RwdAddWatchedProduct/2317555&quot;,
&quot;contentLoadBy&quot;: &quot;ajax&quot;,
&quot;forceOpen&quot;: &quot;true&quot;,
&quot;triggerCloseEvent&quot;: &quot;closeOverlay&quot;,
&quot;triggerOnOpen&quot;: &quot;pricewatcher-open&quot;,
&quot;webtrekkPrefix&quot; : &quot;pricewatcher&quot;
}">
<span class="oopStage-actionPricewatcherIcon icon-pricewatcher">
<span class="oopStage-actionPricewatcherTitle hide show-for-xlarge-up">
Preiswecker
</span>
</span>
</div>
</div>
</div>
<div class="row row-24">
<div class="small-12 large-8 large-offset-4 xlarge-24 columns">
</div>
</div>
</div>
<div class="row">
<div class="oopMarginal show-for-xxlarge-up columns xxlarge-3">
<div data-oop-lastseen="">
<div class="oopMarginal-wrapper oopMarginal-lastseen">
<h2 class="oopMarginal-wrapperTitle">
Zuletzt angesehen
</h2>
<a href="/preisvergleich/OffersOfProduct/5151982_-grohtherm-3000-cosmopolitan-34630000-grohe.html" title="Grohe Grohtherm 3000 Cosmopolitan (34630000)" onclick="wt.sendinfo({ linkId: "lastseenproducts.click.product" });"><img width="65" height="54" src="//cdn.idealo.com/folder/Product/5151/9/5151982/s2_produktbild_mittelgross/grohe-grohtherm-3000-cosmopolitan-34630000.png" alt="Grohe Grohtherm 3000 Cosmopolitan (34630000)"></a><a href="/preisvergleich/OffersOfProduct/1005582_-uno-einhebel-wannenmischer-aufputz-chrom-38400-axor.html" title="Axor Uno Einhebel-Wannenmischer Aufputz (Chrom, 38400)" onclick="wt.sendinfo({ linkId: "lastseenproducts.click.product" });"><img width="65" height="54" src="//cdn.idealo.com/folder/Product/1005/5/1005582/s2_produktbild_mittelgross/axor-uno-einhebel-wannenmischer-aufputz-chrom-38400.png" alt="Axor Uno Einhebel-Wannenmischer Aufputz (Chrom, 38400)"></a></div>
</div>
<div class="oopToptenproducts" data-ajax-html="{ &quot;url&quot; : &quot;aHR0cHM6Ly93d3cuaWRlYWxvLmF0L2ZyYWdtZW50L3RvcHRlbnByb2R1Y3RzL3Byb2R1Y3RzLzIzMTc1NTU=&quot;, &quot;wtEvents&quot; : [{ &quot;elementSelector&quot;: &quot;li a&quot;, &quot;eventId&quot;: &quot;oop.top10&quot;}] }"><div class="oopMarginal-wrapper">
<h2 class="oopMarginal-wrapperTitle">
Top 3 Produkte
<br>
<span class="oopMarginal-wrapperTitleSub">Wannenarmaturen</span>
</h2>
<ol class="oopMarginal-wrapperList ordered">
<li class="oopMarginal-wrapperListItem">
<a class="oopMarginal-wrapperListItemLink" href="/preisvergleich/OffersOfProduct/2378530_-zenta-wannenfuell-und-brausearmatur-kludi.html" rel="">
Kludi Zenta Wannenf�ll- und Brausearmatur
</a>
</li>
<li class="oopMarginal-wrapperListItem">
<a class="oopMarginal-wrapperListItemLink" href="/preisvergleich/OffersOfProduct/2378518_-zenta-38670-kludi.html" rel="">
Kludi Zenta (38670)
</a>
</li>
<li class="oopMarginal-wrapperListItem">
<a class="oopMarginal-wrapperListItemLink" href="/preisvergleich/OffersOfProduct/2340841_-zenta-38660-kludi.html" rel="">
Kludi Zenta (38660)
</a>
</li>
</ol>
</div>
</div>
<div class="oopMarginal-recommendations" data-ajax-html="{ &quot;url&quot; : &quot;aHR0cHM6Ly93d3cuaWRlYWxvLmF0L2ZyYWdtZW50L3JlY29tbWVuZGF0aW9ucy9wcm9kdWN0cy8yMzE3NTU1&quot;, &quot;wtEvents&quot; : [{ &quot;elementSelector&quot;: &quot;li a&quot;, &quot;eventId&quot;: &quot;oop.recommender&quot;}] }"><div class="oopMarginal-wrapper">
<h2 class="oopMarginal-wrapperTitle">
Zurzeit beliebt auf idealo
</h2>
<ul>
<li>
<a href="/preisvergleich/OffersOfProduct/4845422_-grohtherm-1000-brausethermostat-34151003-grohe.html" rel="">
<img width="45" height="37" src="//cdn.idealo.com/folder/Product/4845/4/4845422/s2_produktbild_klein/grohe-grohtherm-1000-brausethermostat-34151003.png" alt="Grohe Grohtherm 1000 Brausethermostat (34151003)">
<div>Grohe Grohtherm 1000 Brausethermostat (34151003)</div>
</a>
</li>
<li>
<a href="/preisvergleich/OffersOfProduct/4843956_-grohtherm-1000-34215002-grohe.html" rel="">
<img width="45" height="37" src="//cdn.idealo.com/folder/Product/4843/9/4843956/s2_produktbild_klein/grohe-grohtherm-1000-34215002.png" alt="Grohe Grohtherm 1000 (34215002)">
<div>Grohe Grohtherm 1000 (34215002)</div>
</a>
</li>
<li>
<a href="/preisvergleich/OffersOfProduct/3041802_-subway-2-0-9m68s1-villeroy-boch.html" rel="">
<img width="45" height="37" src="//cdn.idealo.com/folder/Product/3041/8/3041802/s2_produktbild_klein/villeroy-boch-subway-2-0-9m68s1.png" alt="Villeroy &amp; Boch Subway 2.0 (9M68S1)">
<div>Villeroy &amp; Boch Subway 2.0 (9M68S1)</div>
</a>
</li>
<li>
<a href="/preisvergleich/OffersOfProduct/1963012_-omnia-architectura-190-x-90-cm-ba199ara2v-villeroy-boch.html" rel="">
<img width="45" height="37" src="//cdn.idealo.com/folder/Product/1963/0/1963012/s2_produktbild_klein/villeroy-boch-omnia-architectura-190-x-90-cm-ba199ara2v.png" alt="Villeroy &amp; Boch Omnia Architectura 190 x 90 cm (BA199ARA2V)">
<div>Villeroy &amp; Boch Omnia Architectura 190 x 90 cm (BA199ARA2V)</div>
</a>
</li>
<li>
<a href="/preisvergleich/OffersOfProduct/3207026_-grohtherm-3000-c-19567-grohe.html" rel="">
<img width="45" height="37" src="//cdn.idealo.com/folder/Product/3469/0/3469000/s2_produktbild_klein/grohe-grohtherm-3000-c-chrom-19567000.png" alt="Grohe Grohtherm 3000 C (19567)">
<div>Grohe Grohtherm 3000 C (19567)</div>
</a>
</li>
</ul>
</div>
</div>
</div>
<div class="productOffers columns xxlarge-9" id="offerList">
<div class="productOffers-header row row-24" data-translations="{&quot;price_comparison&quot;:&quot;Preisvergleich&quot;,&quot;load_offers&quot;:&quot;Weitere Angebote anzeigen&quot;,&quot;load_offers_state&quot;:&quot;l�dt ...&quot;,&quot;sort_total_price&quot;:&quot;Inkl. Versandkosten&quot;,&quot;filter_available&quot;:&quot;Nur sofort lieferbar&quot;,&quot;filter_free_return&quot;:&quot;Nur ohne R�cksendekosten&quot;,&quot;offers&quot;:&quot;Angebote&quot;,&quot;no_offers&quot;:&quot;Es wurden leider keine Angebote gefunden&quot;,&quot;used_offers&quot;:&quot;Gebrauchte Angebote&quot;}" data-used-offers-requested="false" data-offerlist="">
<div class="columns small-6 large-4 xlarge-6 productOffers-headerContainer">
<h2 class="productOffers-headerTitle">Preisvergleich</h2>
</div>
<div class="columns large-5 xlarge-14 show-for-large-up">
<form class="productOffers-sort" action="/" method="post">
<div class="productOffers-sort-wrapper collapse-both">
<label class="productOffers-sortText" for="product-offers-sort">Inkl. Versandkosten</label>
<fieldset class="switch tiny round">
<input id="product-offers-sort" type="checkbox" data-rel="totalPrice" style="transition-duration: 0s;">
<label class="productOffers-sortLabel" for="product-offers-sort" aria-label="Inkl. Versandkosten"></label>
</fieldset>
</div>
<div class="productOffers-sort-wrapper collapse-both show-for-xxlarge-up">
<label class="productOffers-sortText" for="product-offers-filter-available">Nur sofort lieferbar</label>
<fieldset class="switch tiny round">
<input id="product-offers-filter-available" type="checkbox" data-rel="available" style="transition-duration: 0s;">
<label class="productOffers-sortLabel" for="product-offers-filter-available" aria-label="Nur sofort lieferbar"></label>
</fieldset>
</div>
<div class="productOffers-sort-wrapper collapse-both show-for-xxlarge-up">
<label class="productOffers-sortText" for="product-offers-filter-freereturn">Nur ohne R�cksendekosten</label>
<fieldset class="switch tiny round">
<input id="product-offers-filter-freereturn" type="checkbox" data-rel="freereturn" style="transition-duration: 0s;">
<label class="productOffers-sortLabel" for="product-offers-filter-freereturn" aria-label="Nur ohne R�cksendekosten"></label>
</fieldset>
</div>
</form>
</div>
<div class="columns small-6 large-3 xlarge-4">
</div>
<div class="columns small-12 hide-for-large-up">
<form class="productOffers-sort" action="/" method="post">
<div class="productOffers-sort-wrapper collapse-both">
<label class="productOffers-sortText" for="product-offers-sort">Inkl. Versandkosten</label>
<fieldset class="switch tiny round">
<input id="product-offers-sort-small" type="checkbox" data-rel="totalPrice" style="transition-duration: 0s;">
<label class="productOffers-sortLabel" for="product-offers-sort-small" aria-label="Inkl. Versandkosten"></label>
</fieldset>
</div>
</form>
</div>
<div id="ad-banner-skyscraper" title="Anzeige"></div>
</div>
<div>
<div>
<ul class="productOffers-list" data-import-time="Daten vom 23.06.2017&nbsp;09:08">
<li class="productOffers-listItem row row-24" data-tm="{&quot;spr&quot;:&quot;e__&quot;}">
<div class="small-12 xlarge-6 columns productOffers-listItemTitleWrapper" data-offerlist-column="title">
<a class="productOffers-listItemTitle" data-wt-click="{&quot;id&quot;: &quot;offer.title&quot;, &quot;params&quot; : [&quot;&quot;, &quot;1&quot;, &quot;&quot;, &quot;&quot;]}" href="/preisvergleich/Relocate/7733253093.html?categoryId=18928&amp;pos=1&amp;price=189.95&amp;productid=2317555&amp;sid=23026&amp;type=offer" target="_blank" rel="nofollow">
<span class="productOffers-listItemTitleInner">
Grohe 19468000 THM-Wan�nen�batt. Grohtherm 3000 C
</span>
</a>
</div>
<div class="productOffers-listItemOffer small-6 large-4 xlarge-7 columns" data-offerlist-column="price">
<a class="productOffers-listItemOfferPrice" data-wt-click="{&quot;id&quot;: &quot;offer.price&quot;, &quot;params&quot; : [&quot;&quot;, &quot;1&quot;, &quot;&quot;, &quot;&quot;, &quot;new&quot;]}" href="/preisvergleich/Relocate/7733253093.html?categoryId=18928&amp;pos=1&amp;price=189.95&amp;productid=2317555&amp;sid=23026&amp;type=offer" rel="nofollow" target="_blank">
�&nbsp;189,95
</a><br>
<div class="productOffers-listItemOfferShippingDetails hide-for-large-down">
<div class="table-row">
<div class="table-cell productOffers-listItemOfferShippingDetailsLeftBefore">
</div>
<div class="table-cell productOffers-listItemOfferShippingDetailsLeft" title="�&nbsp;199,95 inkl. Versand">
�&nbsp;199,95 inkl. Versand
</div>
<div class="table-cell productOffers-listItemOfferShippingDetailsRight">
<span class="productOffers-listItemOfferShippingDetailsRightItem" title="Vorkasse">
<a rel="nofollow" target="_blank" href="/preisvergleich/Relocate/7733253093.html?categoryId=18928&amp;pos=1&amp;price=189.95&amp;productid=2317555&amp;sid=23026&amp;type=offer" data-wt-click="{&quot;id&quot;: &quot;leadout.oop.paymenticon&quot;}">
<span>
Vorkasse
</span>
</a>
</span>
</div>
</div>
<div class="table-row">
<div class="table-cell productOffers-listItemOfferShippingDetailsLeftBefore">
</div>
<div class="table-cell productOffers-listItemOfferShippingDetailsLeft" title="�&nbsp;224,95 inkl. Versand">
�&nbsp;224,95 inkl. Versand
</div>
<div class="table-cell productOffers-listItemOfferShippingDetailsRight">
<span class="productOffers-listItemOfferShippingDetailsRightItem" title="Nachnahme">
<a rel="nofollow" target="_blank" href="/preisvergleich/Relocate/7733253093.html?categoryId=18928&amp;pos=1&amp;price=189.95&amp;productid=2317555&amp;sid=23026&amp;type=offer" data-wt-click="{&quot;id&quot;: &quot;leadout.oop.paymenticon&quot;}">
<span>
Nachnahme
</span>
</a>
</span>
</div>
</div>
</div>
<span class="productOffers-listItemOfferShipping show-for-large-only" data-wt-click="{&quot;id&quot;: &quot;offer.shippingcosts&quot;, &quot;params&quot; : [&quot;&quot;, &quot;1&quot;, &quot;&quot;, &quot;&quot;]}" data-overlay="{
&quot;closeCaption&quot; : &quot;zur�ck&quot;,
&quot;contentLoad&quot; : &quot;/overlay/product/2317555/offer/7733253093/index/0&quot;,
&quot;contentLoadBy&quot; : &quot;ajax&quot;,
&quot;contentPaddingLeft&quot; : &quot;1rem&quot;,
&quot;contentPaddingRight&quot; : &quot;1rem&quot;,
&quot;eventsOn&quot; : &quot;click&quot;,
&quot;titleCaption&quot; : &quot;Angebotsdetails&quot;,
&quot;titleAlign&quot; : &quot;left&quot;,
&quot;titleSize&quot; : &quot;xlarge&quot;,
&quot;triggerOnClose&quot; : &quot;offer-close&quot;,
&quot;triggerOnOpen&quot; : &quot;offer-open&quot;,
&quot;triggerOpenEvent&quot; : &quot;offer_7733253093&quot;
}">
Versandkosten: ab �&nbsp;10,00
</span>
<div class="productOffers-listItemOfferDetailsMobile table hide-for-large-up">
<div class="table-row">
<div class="productOffers-listItemOfferDetails table-cell" data-overlay="{
&quot;closeCaption&quot; : &quot;zur�ck&quot;,
&quot;contentLoad&quot; : &quot;/overlay/product/2317555/offer/7733253093/index/0&quot;,
&quot;contentLoadBy&quot; : &quot;ajax&quot;,
&quot;contentPaddingLeft&quot; : &quot;1rem&quot;,
&quot;contentPaddingRight&quot; : &quot;1rem&quot;,
&quot;eventsOn&quot; : &quot;click&quot;,
&quot;titleCaption&quot; : &quot;Angebotsdetails&quot;,
&quot;titleAlign&quot; : &quot;left&quot;,
&quot;titleSize&quot; : &quot;xlarge&quot;,
&quot;triggerOnClose&quot; : &quot;offer-close&quot;,
&quot;triggerOnOpen&quot; : &quot;offer-open&quot;,
&quot;triggerOpenEvent&quot; : &quot;offer_7733253093&quot;
}">
Details
</div>
<div class="productOffers-listItemOfferDelivery delivery delivery--medium icon-delivery table-cell" data-wt-click="{&quot;id&quot;: &quot;offer.delivery&quot;, &quot;params&quot; : [&quot;&quot;, &quot;1&quot;, &quot;&quot;, &quot;&quot;, &quot;new&quot;]}" data-overlay="{
&quot;closeCaption&quot; : &quot;zur�ck&quot;,
&quot;contentLoad&quot; : &quot;/overlay/product/2317555/offer/7733253093/index/0&quot;,
&quot;contentLoadBy&quot; : &quot;ajax&quot;,
&quot;contentPaddingLeft&quot; : &quot;1rem&quot;,
&quot;contentPaddingRight&quot; : &quot;1rem&quot;,
&quot;eventsOn&quot; : &quot;click&quot;,
&quot;titleCaption&quot; : &quot;Angebotsdetails&quot;,
&quot;titleAlign&quot; : &quot;left&quot;,
&quot;titleSize&quot; : &quot;xlarge&quot;,
&quot;triggerOnClose&quot; : &quot;offer-close&quot;,
&quot;triggerOnOpen&quot; : &quot;offer-open&quot;,
&quot;triggerOpenEvent&quot; : &quot;offer_7733253093&quot;
}">
</div>
</div>
</div>
</div>
<div class="hide-for-medium-down large-2 xlarge-4 columns productOffers-listItemOfferDeliveryBlock va-middle-xlarge-up" data-offerlist-column="delivery">
<div class="table-cell" data-overlay="{
&quot;closeCaption&quot; : &quot;zur�ck&quot;,
&quot;contentLoad&quot; : &quot;/overlay/product/2317555/offer/7733253093/index/0&quot;,
&quot;contentLoadBy&quot; : &quot;ajax&quot;,
&quot;contentPaddingLeft&quot; : &quot;1rem&quot;,
&quot;contentPaddingRight&quot; : &quot;1rem&quot;,
&quot;eventsOn&quot; : &quot;click&quot;,
&quot;titleCaption&quot; : &quot;Angebotsdetails&quot;,
&quot;titleAlign&quot; : &quot;left&quot;,
&quot;titleSize&quot; : &quot;xlarge&quot;,
&quot;triggerOnClose&quot; : &quot;offer-close&quot;,
&quot;triggerOnOpen&quot; : &quot;offer-open&quot;,
&quot;triggerOpenEvent&quot; : &quot;offer_7733253093&quot;
}">
<div class="table">
<div class="table-row" data-wt-click="{&quot;id&quot;: &quot;offer.details.layer&quot;, &quot;params&quot; : [&quot;&quot;,&quot;1&quot;,&quot;oop.offerlist.delivery&quot;]}">
<div class="table-cell va-top productOffers-listItemOfferDeliveryIconWrapper">
<span class="productOffers-listItemOfferDelivery delivery delivery--circle medium" data-wt-click="{&quot;id&quot;: &quot;offer.delivery&quot;, &quot;params&quot; : [&quot;&quot;, &quot;1&quot;, &quot;&quot;, &quot;&quot;, &quot;new&quot;]}">
</span>
<span class="productOffers-listItemOfferDelivery delivery delivery--medium icon-delivery hide-for-xlarge-up" data-wt-click="{&quot;id&quot;: &quot;offer.delivery&quot;, &quot;params&quot; : [&quot;&quot;, &quot;1&quot;, &quot;&quot;, &quot;&quot;, &quot;new&quot;]}">
</span>
</div>
<div class="table-cell">
<p class="productOffers-listItemOfferDeliveryStatus">4 Werk�ta�ge</p>
<div class="productOffers-listItemOfferDeliveryProviderWrapper">
<span class="productOffers-listItemOfferGreyBadge productOffers-listItemOfferDeliveryProvider">DHL</span>
<span class="productOffers-listItemOfferGreyBadge productOffers-listItemOfferDeliveryProvider">GLS</span>
</div>
</div>
</div>
</div>
</div>
</div>
<div class="small-6 large-3 xlarge-3 columns xlarge-text-left large-text-center small-text-right productOffers-listItemOfferShopBlock va-middle-xlarge-up" data-offerlist-column="shop">
<div class="productOffers-listItemOfferLogo">
<a class="productOffers-listItemOfferLogoLink" data-checkout="false" data-shop-name="ssd-armaturenshop.de - Shop aus Klinga / Gemeinde Parthenstein" href="/preisvergleich/Relocate/7733253093.html?categoryId=18928&amp;pos=1&amp;price=189.95&amp;productid=2317555&amp;sid=23026&amp;type=offer" rel="nofollow" target="_blank">
<img class="productOffers-listItemOfferLogoShop hide" data-wt-click="{&quot;id&quot;: &quot;offer.shoplogo&quot;, &quot;params&quot; : [&quot;&quot;, &quot;1&quot;, &quot;&quot;, &quot;&quot;, &quot;new&quot;]}" src="//cdn.idealo.com/folder/Shop/23/0/23026/s2_shop_160x60.png" data-shop-logo="//cdn.idealo.com/folder/Shop/23/0/23026/s2_shop_160x60.png" data-shop-logo-fallback="//cdn.idealo.com/folder/Shop/23/0/23026/s2_shop.gif" alt="ssd-armaturenshop.de - Shop aus Klinga / Gemeinde Parthenstein" width="80" height="30" style="display: inline-block;">
<noscript>
&lt;img class="productOffers-listItemOfferLogoShop noborder"
src="//cdn.idealo.com/folder/Shop/23/0/23026/s2_shop.gif"
alt="ssd-armaturenshop.de"
width="80" height="30"&gt;
</noscript>
</a>
</div>
<a class="productOffers-listItemOfferShopBlockRatingLink" href="https://www.idealo.at/preisvergleich/Shop/23026.html">
<div class="rating-wrapper">
<div class="table">
<div class="table-row">
<div class="table-cell rating-starsContainer">
<div class="rating-stars rating-stars--small">
<div class="rating-starsWrapper-90">
<img class="rating-starsImage rating-stars--default" src="//cdn.idealo.com/ipc/95351d/rwd/img/spacer.png" alt="*">
</div>
</div>
</div>
</div>
</div>
</div>
</a>
<a class="productOffers-listItemOfferRatingstext" href="https://www.idealo.at/preisvergleich/Shop/23026.html">
173 Meinungen
</a>
</div>
<div class="productOffers-listItemOfferCtaHolder large-3 xlarge-4 columns va-middle-xlarge-up " data-offerlist-column="checkoutleadoutbuttons">
<ul class="productOffers-listItemOfferCta">
<li>
<a class="productOffers-listItemOfferCtaLeadout button button--leadout expand" href="/preisvergleich/Relocate/7733253093.html?categoryId=18928&amp;pos=1&amp;price=189.95&amp;productid=2317555&amp;sid=23026&amp;type=offer" data-after="Zum Shop" data-shop-name="ssd-armaturenshop.de" rel="nofollow" target="_blank">
<img class="btn-cta-shop" src="//cdn.idealo.com/ipc/95351d/pics/buttons/btn_placeholder.gif" alt="Grohe Grohtherm 3000 C Thermostat (19468000) kaufen: g�nstige Wannenarmaturen bei ssd-armaturenshop.de">
</a>
</li>
</ul>
</div>
<a class="productOffers-listItemOfferLink" href="/preisvergleich/Relocate/7733253093.html?categoryId=18928&amp;pos=1&amp;price=189.95&amp;productid=2317555&amp;sid=23026&amp;type=offer" data-checkout="false" data-shop-name="ssd-armaturenshop.de" rel="nofollow" target="_blank">
</a>
</li>
<li class="productOffers-listItem row row-24" data-tm="{&quot;spr&quot;:&quot;e__&quot;}">
<div class="small-12 xlarge-6 columns productOffers-listItemTitleWrapper" data-offerlist-column="title">
<a class="productOffers-listItemTitle" data-wt-click="{&quot;id&quot;: &quot;offer.title&quot;, &quot;params&quot; : [&quot;&quot;, &quot;2&quot;, &quot;&quot;, &quot;&quot;]}" href="/preisvergleich/Relocate/6568182724.html?categoryId=18928&amp;pos=2&amp;price=191.86&amp;productid=2317555&amp;sid=243191&amp;type=offer" target="_blank" rel="nofollow">
<span class="productOffers-listItemTitleInner">
Grohe Grohtherm 3000 Cos�mo�po�li�tan Ther�mo�stat, 2 Ver�brau�cher, runde Rosette, Farbe: Chrom
</span>
</a>
</div>
<div class="productOffers-listItemOffer small-6 large-4 xlarge-7 columns" data-offerlist-column="price">
<a class="productOffers-listItemOfferPrice" data-wt-click="{&quot;id&quot;: &quot;offer.price&quot;, &quot;params&quot; : [&quot;&quot;, &quot;2&quot;, &quot;&quot;, &quot;&quot;, &quot;new&quot;]}" href="/preisvergleich/Relocate/6568182724.html?categoryId=18928&amp;pos=2&amp;price=191.86&amp;productid=2317555&amp;sid=243191&amp;type=offer" rel="nofollow" target="_blank">
�&nbsp;191,86
</a><br>
<div class="productOffers-listItemOfferShippingDetails hide-for-large-down">
<div class="table-row">
<div class="table-cell productOffers-listItemOfferShippingDetailsLeftBefore">
</div>
<div class="table-cell productOffers-listItemOfferShippingDetailsLeft" title="�&nbsp;218,42 inkl. Versand">
�&nbsp;218,42 inkl. Versand
</div>
<div class="table-cell productOffers-listItemOfferShippingDetailsRight">
<span class="productOffers-listItemOfferShippingDetailsRightItem" title="PayPal">
<a rel="nofollow" target="_blank" href="/preisvergleich/Relocate/6568182724.html?categoryId=18928&amp;pos=2&amp;price=191.86&amp;productid=2317555&amp;sid=243191&amp;type=offer" data-wt-click="{&quot;id&quot;: &quot;leadout.oop.paymenticon&quot;}">
<span>
<img width="45" height="13" class="offerImage" src="//cdn.idealo.com/ipc/95351d/rwd/img/payment-icons/2x/paypal.png" alt="PayPal" title="PayPal">
</span>
</a>
</span>
<span class="productOffers-listItemOfferShippingDetailsRightItem" title="Lastschrift">
<a rel="nofollow" target="_blank" href="/preisvergleich/Relocate/6568182724.html?categoryId=18928&amp;pos=2&amp;price=191.86&amp;productid=2317555&amp;sid=243191&amp;type=offer" data-wt-click="{&quot;id&quot;: &quot;leadout.oop.paymenticon&quot;}">
<span>
Lastschrift
</span>
</a>
</span>
<span class="productOffers-listItemOfferShippingDetailsRightItem" title="Vorkasse">
<a rel="nofollow" target="_blank" href="/preisvergleich/Relocate/6568182724.html?categoryId=18928&amp;pos=2&amp;price=191.86&amp;productid=2317555&amp;sid=243191&amp;type=offer" data-wt-click="{&quot;id&quot;: &quot;leadout.oop.paymenticon&quot;}">
<span>
Vorkasse
</span>
</a>
</span>
</div>
</div>
</div>
<span class="productOffers-listItemOfferShipping show-for-large-only" data-wt-click="{&quot;id&quot;: &quot;offer.shippingcosts&quot;, &quot;params&quot; : [&quot;&quot;, &quot;2&quot;, &quot;&quot;, &quot;&quot;]}" data-overlay="{
&quot;closeCaption&quot; : &quot;zur�ck&quot;,
&quot;contentLoad&quot; : &quot;/overlay/product/2317555/offer/6568182724/index/1&quot;,
&quot;contentLoadBy&quot; : &quot;ajax&quot;,
&quot;contentPaddingLeft&quot; : &quot;1rem&quot;,
&quot;contentPaddingRight&quot; : &quot;1rem&quot;,
&quot;eventsOn&quot; : &quot;click&quot;,
&quot;titleCaption&quot; : &quot;Angebotsdetails&quot;,
&quot;titleAlign&quot; : &quot;left&quot;,
&quot;titleSize&quot; : &quot;xlarge&quot;,
&quot;triggerOnClose&quot; : &quot;offer-close&quot;,
&quot;triggerOnOpen&quot; : &quot;offer-open&quot;,
&quot;triggerOpenEvent&quot; : &quot;offer_6568182724&quot;
}">
Versandkosten: ab �&nbsp;26,56
</span>
<div class="productOffers-listItemOfferDetailsMobile table hide-for-large-up">
<div class="table-row">
<div class="productOffers-listItemOfferDetails table-cell" data-overlay="{
&quot;closeCaption&quot; : &quot;zur�ck&quot;,
&quot;contentLoad&quot; : &quot;/overlay/product/2317555/offer/6568182724/index/1&quot;,
&quot;contentLoadBy&quot; : &quot;ajax&quot;,
&quot;contentPaddingLeft&quot; : &quot;1rem&quot;,
&quot;contentPaddingRight&quot; : &quot;1rem&quot;,
&quot;eventsOn&quot; : &quot;click&quot;,
&quot;titleCaption&quot; : &quot;Angebotsdetails&quot;,
&quot;titleAlign&quot; : &quot;left&quot;,
&quot;titleSize&quot; : &quot;xlarge&quot;,
&quot;triggerOnClose&quot; : &quot;offer-close&quot;,
&quot;triggerOnOpen&quot; : &quot;offer-open&quot;,
&quot;triggerOpenEvent&quot; : &quot;offer_6568182724&quot;
}">
Details
</div>
<div class="productOffers-listItemOfferDelivery delivery delivery--long icon-delivery table-cell" data-wt-click="{&quot;id&quot;: &quot;offer.delivery&quot;, &quot;params&quot; : [&quot;&quot;, &quot;2&quot;, &quot;&quot;, &quot;&quot;, &quot;new&quot;]}" data-overlay="{
&quot;closeCaption&quot; : &quot;zur�ck&quot;,
&quot;contentLoad&quot; : &quot;/overlay/product/2317555/offer/6568182724/index/1&quot;,
&quot;contentLoadBy&quot; : &quot;ajax&quot;,
&quot;contentPaddingLeft&quot; : &quot;1rem&quot;,
&quot;contentPaddingRight&quot; : &quot;1rem&quot;,
&quot;eventsOn&quot; : &quot;click&quot;,
&quot;titleCaption&quot; : &quot;Angebotsdetails&quot;,
&quot;titleAlign&quot; : &quot;left&quot;,
&quot;titleSize&quot; : &quot;xlarge&quot;,
&quot;triggerOnClose&quot; : &quot;offer-close&quot;,
&quot;triggerOnOpen&quot; : &quot;offer-open&quot;,
&quot;triggerOpenEvent&quot; : &quot;offer_6568182724&quot;
}">
</div>
</div>
</div>
</div>
<div class="hide-for-medium-down large-2 xlarge-4 columns productOffers-listItemOfferDeliveryBlock va-middle-xlarge-up" data-offerlist-column="delivery">
<div class="table-cell" data-overlay="{
&quot;closeCaption&quot; : &quot;zur�ck&quot;,
&quot;contentLoad&quot; : &quot;/overlay/product/2317555/offer/6568182724/index/1&quot;,
&quot;contentLoadBy&quot; : &quot;ajax&quot;,
&quot;contentPaddingLeft&quot; : &quot;1rem&quot;,
&quot;contentPaddingRight&quot; : &quot;1rem&quot;,
&quot;eventsOn&quot; : &quot;click&quot;,
&quot;titleCaption&quot; : &quot;Angebotsdetails&quot;,
&quot;titleAlign&quot; : &quot;left&quot;,
&quot;titleSize&quot; : &quot;xlarge&quot;,
&quot;triggerOnClose&quot; : &quot;offer-close&quot;,
&quot;triggerOnOpen&quot; : &quot;offer-open&quot;,
&quot;triggerOpenEvent&quot; : &quot;offer_6568182724&quot;
}">
<div class="table">
<div class="table-row" data-wt-click="{&quot;id&quot;: &quot;offer.details.layer&quot;, &quot;params&quot; : [&quot;&quot;,&quot;2&quot;,&quot;oop.offerlist.delivery&quot;]}">
<div class="table-cell va-top productOffers-listItemOfferDeliveryIconWrapper">
<span class="productOffers-listItemOfferDelivery delivery delivery--circle long" data-wt-click="{&quot;id&quot;: &quot;offer.delivery&quot;, &quot;params&quot; : [&quot;&quot;, &quot;2&quot;, &quot;&quot;, &quot;&quot;, &quot;new&quot;]}">
</span>
<span class="productOffers-listItemOfferDelivery delivery delivery--long icon-delivery hide-for-xlarge-up" data-wt-click="{&quot;id&quot;: &quot;offer.delivery&quot;, &quot;params&quot; : [&quot;&quot;, &quot;2&quot;, &quot;&quot;, &quot;&quot;, &quot;new&quot;]}">
</span>
</div>
<div class="table-cell">
<p class="productOffers-listItemOfferDeliveryStatus">1-2 Wochen</p>
<div class="productOffers-listItemOfferDeliveryProviderWrapper">
<span class="productOffers-listItemOfferGreyBadge productOffers-listItemOfferDeliveryProvider">UPS</span>
<span class="productOffers-listItemOfferGreyBadge productOffers-listItemOfferDeliveryProvider">Spedition</span>
</div>
</div>
</div>
</div>
</div>
</div>
<div class="small-6 large-3 xlarge-3 columns xlarge-text-left large-text-center small-text-right productOffers-listItemOfferShopBlock va-middle-xlarge-up" data-offerlist-column="shop">
<div class="productOffers-listItemOfferLogo">
<a class="productOffers-listItemOfferLogoLink" data-checkout="false" data-shop-name="shkshop.com - Shop aus Lahr" href="/preisvergleich/Relocate/6568182724.html?categoryId=18928&amp;pos=2&amp;price=191.86&amp;productid=2317555&amp;sid=243191&amp;type=offer" rel="nofollow" target="_blank">
<img class="productOffers-listItemOfferLogoShop hide" data-wt-click="{&quot;id&quot;: &quot;offer.shoplogo&quot;, &quot;params&quot; : [&quot;&quot;, &quot;2&quot;, &quot;&quot;, &quot;&quot;, &quot;new&quot;]}" src="//cdn.idealo.com/folder/Shop/243/1/243191/s2_shop_160x60.png" data-shop-logo="//cdn.idealo.com/folder/Shop/243/1/243191/s2_shop_160x60.png" data-shop-logo-fallback="//cdn.idealo.com/folder/Shop/243/1/243191/s2_shop.gif" alt="shkshop.com - Shop aus Lahr" width="80" height="30" style="display: inline-block;">
<noscript>
&lt;img class="productOffers-listItemOfferLogoShop noborder"
src="//cdn.idealo.com/folder/Shop/243/1/243191/s2_shop.gif"
alt="shkshop.com"
width="80" height="30"&gt;
</noscript>
</a>
</div>
<a class="productOffers-listItemOfferShopBlockRatingLink" href="https://www.idealo.at/preisvergleich/Shop/243191.html">
<div class="rating-wrapper">
<div class="table">
<div class="table-row">
<div class="table-cell rating-starsContainer">
<div class="rating-stars rating-stars--small">
<div class="rating-starsWrapper-100">
<img class="rating-starsImage rating-stars--default" src="//cdn.idealo.com/ipc/95351d/rwd/img/spacer.png" alt="*">
</div>
</div>
</div>
</div>
</div>
</div>
</a>
<a class="productOffers-listItemOfferRatingstext" href="https://www.idealo.at/preisvergleich/Shop/243191.html">
351 Meinungen
</a>
</div>
<div class="productOffers-listItemOfferCtaHolder large-3 xlarge-4 columns va-middle-xlarge-up " data-offerlist-column="checkoutleadoutbuttons">
<ul class="productOffers-listItemOfferCta">
<li>
<a class="productOffers-listItemOfferCtaLeadout button button--leadout expand" href="/preisvergleich/Relocate/6568182724.html?categoryId=18928&amp;pos=2&amp;price=191.86&amp;productid=2317555&amp;sid=243191&amp;type=offer" data-after="Zum Shop" data-shop-name="shkshop.com" rel="nofollow" target="_blank">
<img class="btn-cta-shop" src="//cdn.idealo.com/ipc/95351d/pics/buttons/btn_placeholder.gif" alt="Grohe 19468 bestellen: preiswerte Wannenarmaturen bei shkshop.com">
</a>
</li>
</ul>
</div>
<a class="productOffers-listItemOfferLink" href="/preisvergleich/Relocate/6568182724.html?categoryId=18928&amp;pos=2&amp;price=191.86&amp;productid=2317555&amp;sid=243191&amp;type=offer" data-checkout="false" data-shop-name="shkshop.com" rel="nofollow" target="_blank">
</a>
</li>
<li class="productOffers-listItem row row-24" data-tm="{&quot;spr&quot;:&quot;cad&quot;}">
<div class="small-12 xlarge-6 columns productOffers-listItemTitleWrapper" data-offerlist-column="title">
<a class="productOffers-listItemTitle" data-wt-click="{&quot;id&quot;: &quot;offer.title&quot;, &quot;params&quot; : [&quot;&quot;, &quot;3&quot;, &quot;&quot;, &quot;&quot;]}" href="/preisvergleich/Relocate/8087883224.html?categoryId=18928&amp;pos=3&amp;price=196.40&amp;productid=2317555&amp;sid=309362&amp;type=offer" target="_blank" rel="nofollow">
<span class="productOffers-listItemTitleInner">
Grohe Grohtherm 3000 Cos�mo�po�li�tan Thermostat mit in�te�grier�ter 2-Wege- Um�stel�lung, chrom 19468000
</span>
</a>
</div>
<div class="productOffers-listItemOffer small-6 large-4 xlarge-7 columns" data-offerlist-column="price">
<a class="productOffers-listItemOfferPrice" data-wt-click="{&quot;id&quot;: &quot;offer.price&quot;, &quot;params&quot; : [&quot;&quot;, &quot;3&quot;, &quot;&quot;, &quot;&quot;, &quot;new&quot;]}" href="/preisvergleich/Relocate/8087883224.html?categoryId=18928&amp;pos=3&amp;price=196.40&amp;productid=2317555&amp;sid=309362&amp;type=offer" rel="nofollow" target="_blank">
�&nbsp;196,40
</a><br>
<div class="productOffers-listItemOfferShippingDetails hide-for-large-down">
<div class="table-row">
<div class="table-cell productOffers-listItemOfferShippingDetailsLeftBefore">
</div>
<div class="table-cell productOffers-listItemOfferShippingDetailsLeft" title="�&nbsp;196,40 inkl. Versand">
�&nbsp;196,40 inkl. Versand
</div>
<div class="table-cell productOffers-listItemOfferShippingDetailsRight">
<span class="productOffers-listItemOfferShippingDetailsRightItem" title="PayPal">
<a rel="nofollow" target="_blank" href="/preisvergleich/Relocate/8087883224.html?categoryId=18928&amp;pos=3&amp;price=196.40&amp;productid=2317555&amp;sid=309362&amp;type=offer" data-wt-click="{&quot;id&quot;: &quot;leadout.oop.paymenticon&quot;}">
<span>
<img width="45" height="13" class="offerImage" src="//cdn.idealo.com/ipc/95351d/rwd/img/payment-icons/2x/paypal.png" alt="PayPal" title="PayPal">
</span>
</a>
</span>
<span class="productOffers-listItemOfferShippingDetailsRightItem" title="Visa">
<a rel="nofollow" target="_blank" href="/preisvergleich/Relocate/8087883224.html?categoryId=18928&amp;pos=3&amp;price=196.40&amp;productid=2317555&amp;sid=309362&amp;type=offer" data-wt-click="{&quot;id&quot;: &quot;leadout.oop.paymenticon&quot;}">
<span>
<img width="45" height="13" class="offerImage" src="//cdn.idealo.com/ipc/95351d/rwd/img/payment-icons/2x/visa.png" alt="Visa" title="Visa">
</span>
</a>
</span>
<span class="productOffers-listItemOfferShippingDetailsRightItem" title="MasterCard">
<a rel="nofollow" target="_blank" href="/preisvergleich/Relocate/8087883224.html?categoryId=18928&amp;pos=3&amp;price=196.40&amp;productid=2317555&amp;sid=309362&amp;type=offer" data-wt-click="{&quot;id&quot;: &quot;leadout.oop.paymenticon&quot;}">
<span>
<img width="45" height="13" class="offerImage" src="//cdn.idealo.com/ipc/95351d/rwd/img/payment-icons/2x/mastercard.png" alt="MasterCard" title="MasterCard">
</span>
</a>
</span>
<span class="productOffers-listItemOfferShippingDetailsRightItem" title="American Express">
<a rel="nofollow" target="_blank" href="/preisvergleich/Relocate/8087883224.html?categoryId=18928&amp;pos=3&amp;price=196.40&amp;productid=2317555&amp;sid=309362&amp;type=offer" data-wt-click="{&quot;id&quot;: &quot;leadout.oop.paymenticon&quot;}">
<span>
<img width="45" height="13" class="offerImage" src="//cdn.idealo.com/ipc/95351d/rwd/img/payment-icons/2x/american-express.png" alt="American Express" title="American Express">
</span>
</a>
</span>
<span class="productOffers-listItemOfferShippingDetailsRightItem" title="Vorkasse">
<a rel="nofollow" target="_blank" href="/preisvergleich/Relocate/8087883224.html?categoryId=18928&amp;pos=3&amp;price=196.40&amp;productid=2317555&amp;sid=309362&amp;type=offer" data-wt-click="{&quot;id&quot;: &quot;leadout.oop.paymenticon&quot;}">
<span>
Vorkasse
</span>
</a>
</span>
<span class="productOffers-listItemOfferShippingDetailsRightItem" title="Sofort�berweisung">
<a rel="nofollow" target="_blank" href="/preisvergleich/Relocate/8087883224.html?categoryId=18928&amp;pos=3&amp;price=196.40&amp;productid=2317555&amp;sid=309362&amp;type=offer" data-wt-click="{&quot;id&quot;: &quot;leadout.oop.paymenticon&quot;}">
<span>
<img width="45" height="13" class="offerImage" src="//cdn.idealo.com/ipc/95351d/rwd/img/payment-icons/2x/sofort.png" alt="Sofort�berweisung" title="Sofort�berweisung">
</span>
</a>
</span>
</div>
</div>
</div>
<span class="productOffers-listItemOfferShipping show-for-large-only" data-wt-click="{&quot;id&quot;: &quot;offer.shippingcosts&quot;, &quot;params&quot; : [&quot;&quot;, &quot;3&quot;, &quot;&quot;, &quot;&quot;]}" data-overlay="{
&quot;closeCaption&quot; : &quot;zur�ck&quot;,
&quot;contentLoad&quot; : &quot;/overlay/product/2317555/offer/8087883224/index/2&quot;,
&quot;contentLoadBy&quot; : &quot;ajax&quot;,
&quot;contentPaddingLeft&quot; : &quot;1rem&quot;,
&quot;contentPaddingRight&quot; : &quot;1rem&quot;,
&quot;eventsOn&quot; : &quot;click&quot;,
&quot;titleCaption&quot; : &quot;Angebotsdetails&quot;,
&quot;titleAlign&quot; : &quot;left&quot;,
&quot;titleSize&quot; : &quot;xlarge&quot;,
&quot;triggerOnClose&quot; : &quot;offer-close&quot;,
&quot;triggerOnOpen&quot; : &quot;offer-open&quot;,
&quot;triggerOpenEvent&quot; : &quot;offer_8087883224&quot;
}">
Versandkosten: ab �&nbsp;0,00
</span>
<div class="productOffers-listItemOfferDetailsMobile table hide-for-large-up">
<div class="table-row">
<div class="productOffers-listItemOfferDetails table-cell" data-overlay="{
&quot;closeCaption&quot; : &quot;zur�ck&quot;,
&quot;contentLoad&quot; : &quot;/overlay/product/2317555/offer/8087883224/index/2&quot;,
&quot;contentLoadBy&quot; : &quot;ajax&quot;,
&quot;contentPaddingLeft&quot; : &quot;1rem&quot;,
&quot;contentPaddingRight&quot; : &quot;1rem&quot;,
&quot;eventsOn&quot; : &quot;click&quot;,
&quot;titleCaption&quot; : &quot;Angebotsdetails&quot;,
&quot;titleAlign&quot; : &quot;left&quot;,
&quot;titleSize&quot; : &quot;xlarge&quot;,
&quot;triggerOnClose&quot; : &quot;offer-close&quot;,
&quot;triggerOnOpen&quot; : &quot;offer-open&quot;,
&quot;triggerOpenEvent&quot; : &quot;offer_8087883224&quot;
}">
Details
</div>
<div class="productOffers-listItemOfferDelivery delivery delivery--short icon-delivery table-cell" data-wt-click="{&quot;id&quot;: &quot;offer.delivery&quot;, &quot;params&quot; : [&quot;&quot;, &quot;3&quot;, &quot;&quot;, &quot;&quot;, &quot;new&quot;]}" data-overlay="{
&quot;closeCaption&quot; : &quot;zur�ck&quot;,
&quot;contentLoad&quot; : &quot;/overlay/product/2317555/offer/8087883224/index/2&quot;,
&quot;contentLoadBy&quot; : &quot;ajax&quot;,
&quot;contentPaddingLeft&quot; : &quot;1rem&quot;,
&quot;contentPaddingRight&quot; : &quot;1rem&quot;,
&quot;eventsOn&quot; : &quot;click&quot;,
&quot;titleCaption&quot; : &quot;Angebotsdetails&quot;,
&quot;titleAlign&quot; : &quot;left&quot;,
&quot;titleSize&quot; : &quot;xlarge&quot;,
&quot;triggerOnClose&quot; : &quot;offer-close&quot;,
&quot;triggerOnOpen&quot; : &quot;offer-open&quot;,
&quot;triggerOpenEvent&quot; : &quot;offer_8087883224&quot;
}">
</div>
</div>
</div>
</div>
<div class="hide-for-medium-down large-2 xlarge-4 columns productOffers-listItemOfferDeliveryBlock va-middle-xlarge-up" data-offerlist-column="delivery">
<div class="table-cell" data-overlay="{
&quot;closeCaption&quot; : &quot;zur�ck&quot;,
&quot;contentLoad&quot; : &quot;/overlay/product/2317555/offer/8087883224/index/2&quot;,
&quot;contentLoadBy&quot; : &quot;ajax&quot;,
&quot;contentPaddingLeft&quot; : &quot;1rem&quot;,
&quot;contentPaddingRight&quot; : &quot;1rem&quot;,
&quot;eventsOn&quot; : &quot;click&quot;,
&quot;titleCaption&quot; : &quot;Angebotsdetails&quot;,
&quot;titleAlign&quot; : &quot;left&quot;,
&quot;titleSize&quot; : &quot;xlarge&quot;,
&quot;triggerOnClose&quot; : &quot;offer-close&quot;,
&quot;triggerOnOpen&quot; : &quot;offer-open&quot;,
&quot;triggerOpenEvent&quot; : &quot;offer_8087883224&quot;
}">
<div class="table">
<div class="table-row" data-wt-click="{&quot;id&quot;: &quot;offer.details.layer&quot;, &quot;params&quot; : [&quot;&quot;,&quot;3&quot;,&quot;oop.offerlist.delivery&quot;]}">
<div class="table-cell va-top productOffers-listItemOfferDeliveryIconWrapper">
<span class="productOffers-listItemOfferDelivery delivery delivery--circle short" data-wt-click="{&quot;id&quot;: &quot;offer.delivery&quot;, &quot;params&quot; : [&quot;&quot;, &quot;3&quot;, &quot;&quot;, &quot;&quot;, &quot;new&quot;]}">
</span>
<span class="productOffers-listItemOfferDelivery delivery delivery--short icon-delivery hide-for-xlarge-up" data-wt-click="{&quot;id&quot;: &quot;offer.delivery&quot;, &quot;params&quot; : [&quot;&quot;, &quot;3&quot;, &quot;&quot;, &quot;&quot;, &quot;new&quot;]}">
</span>
</div>
<div class="table-cell">
<p class="productOffers-listItemOfferDeliveryStatus">1-3 Werk�ta�gen</p>
<div class="productOffers-listItemOfferDeliveryProviderWrapper">
<span class="productOffers-listItemOfferGreyBadge productOffers-listItemOfferDeliveryProvider">�sterreichische Post</span>
</div>
</div>
</div>
</div>
</div>
</div>
<div class="small-6 large-3 xlarge-3 columns xlarge-text-left large-text-center small-text-right productOffers-listItemOfferShopBlock va-middle-xlarge-up" data-offerlist-column="shop">
<div class="productOffers-listItemOfferLogo">
<a class="productOffers-listItemOfferLogoLink" data-checkout="false" data-shop-name="baedermaxx.at - Shop aus Saalfelden" href="/preisvergleich/Relocate/8087883224.html?categoryId=18928&amp;pos=3&amp;price=196.40&amp;productid=2317555&amp;sid=309362&amp;type=offer" rel="nofollow" target="_blank">
<img class="productOffers-listItemOfferLogoShop hide" data-wt-click="{&quot;id&quot;: &quot;offer.shoplogo&quot;, &quot;params&quot; : [&quot;&quot;, &quot;3&quot;, &quot;&quot;, &quot;&quot;, &quot;new&quot;]}" src="//cdn.idealo.com/folder/Shop/309/3/309362/s2_shop_160x60.png" data-shop-logo="//cdn.idealo.com/folder/Shop/309/3/309362/s2_shop_160x60.png" data-shop-logo-fallback="//cdn.idealo.com/folder/Shop/309/3/309362/s2_shop.gif" alt="baedermaxx.at - Shop aus Saalfelden" width="80" height="30" style="display: inline-block;">
<noscript>
&lt;img class="productOffers-listItemOfferLogoShop noborder"
src="//cdn.idealo.com/folder/Shop/309/3/309362/s2_shop.gif"
alt="baedermaxx.at"
width="80" height="30"&gt;
</noscript>
</a>
</div>
<a class="productOffers-listItemOfferShopBlockRatingLink" href="https://www.idealo.at/preisvergleich/Shop/309362.html">
<div class="rating-wrapper">
<div class="table">
<div class="table-row">
<div class="table-cell rating-starsContainer">
<div class="rating-stars rating-stars--small">
<div class="rating-starsWrapper-100">
<img class="rating-starsImage rating-stars--default" src="//cdn.idealo.com/ipc/95351d/rwd/img/spacer.png" alt="*">
</div>
</div>
</div>
</div>
</div>
</div>
</a>
<a class="productOffers-listItemOfferRatingstext" href="https://www.idealo.at/preisvergleich/Shop/309362.html">
13 Meinungen
</a>
</div>
<div class="productOffers-listItemOfferCtaHolder large-3 xlarge-4 columns va-middle-xlarge-up " data-offerlist-column="checkoutleadoutbuttons">
<ul class="productOffers-listItemOfferCta">
<li>
<a class="productOffers-listItemOfferCtaLeadout button button--leadout expand" href="/preisvergleich/Relocate/8087883224.html?categoryId=18928&amp;pos=3&amp;price=196.40&amp;productid=2317555&amp;sid=309362&amp;type=offer" data-after="Zum Shop" data-shop-name="baedermaxx.at" rel="nofollow" target="_blank">
<img class="btn-cta-shop" src="//cdn.idealo.com/ipc/95351d/pics/buttons/btn_placeholder.gif" alt="Grohe Grohtherm 3000 Wannenbatterie versand: billige Wannenarmaturen bei baedermaxx.at">
</a>
</li>
</ul>
</div>
<a class="productOffers-listItemOfferLink" href="/preisvergleich/Relocate/8087883224.html?categoryId=18928&amp;pos=3&amp;price=196.40&amp;productid=2317555&amp;sid=309362&amp;type=offer" data-checkout="false" data-shop-name="baedermaxx.at" rel="nofollow" target="_blank">
</a>
</li>
<li class="productOffers-listItem row row-24" data-tm="{&quot;spr&quot;:&quot;dad&quot;}">
<div class="small-12 xlarge-6 columns productOffers-listItemTitleWrapper" data-offerlist-column="title">
<a class="productOffers-listItemTitle" data-wt-click="{&quot;id&quot;: &quot;offer.title&quot;, &quot;params&quot; : [&quot;&quot;, &quot;4&quot;, &quot;&quot;, &quot;&quot;]}" href="/preisvergleich/Relocate/9501069376.html?categoryId=18928&amp;pos=4&amp;price=198.40&amp;productid=2317555&amp;sid=312899&amp;type=offer" target="_blank" rel="nofollow">
<span class="productOffers-listItemTitleInner">
Grohe Grohtherm 3000 Cos�mo�po�li�tan Thermostat mit in�te�grier�ter 2-We�ge-Um�stel�lung
</span>
</a>
</div>
<div class="productOffers-listItemOffer small-6 large-4 xlarge-7 columns" data-offerlist-column="price">
<a class="productOffers-listItemOfferPrice" data-wt-click="{&quot;id&quot;: &quot;offer.price&quot;, &quot;params&quot; : [&quot;&quot;, &quot;4&quot;, &quot;&quot;, &quot;&quot;, &quot;new&quot;]}" href="/preisvergleich/Relocate/9501069376.html?categoryId=18928&amp;pos=4&amp;price=198.40&amp;productid=2317555&amp;sid=312899&amp;type=offer" rel="nofollow" target="_blank">
�&nbsp;198,40
</a><br>
<div class="productOffers-listItemOfferShippingDetails hide-for-large-down">
<div class="table-row">
<div class="table-cell productOffers-listItemOfferShippingDetailsLeftBefore">
</div>
<div class="table-cell productOffers-listItemOfferShippingDetailsLeft" title="�&nbsp;198,40 inkl. Versand">
�&nbsp;198,40 inkl. Versand
</div>
<div class="table-cell productOffers-listItemOfferShippingDetailsRight">
<span class="productOffers-listItemOfferShippingDetailsRightItem" title="PayPal">
<a rel="nofollow" target="_blank" href="/preisvergleich/Relocate/9501069376.html?categoryId=18928&amp;pos=4&amp;price=198.40&amp;productid=2317555&amp;sid=312899&amp;type=offer" data-wt-click="{&quot;id&quot;: &quot;leadout.oop.paymenticon&quot;}">
<span>
<img width="45" height="13" class="offerImage" src="//cdn.idealo.com/ipc/95351d/rwd/img/payment-icons/2x/paypal.png" alt="PayPal" title="PayPal">
</span>
</a>
</span>
<span class="productOffers-listItemOfferShippingDetailsRightItem" title="Visa">
<a rel="nofollow" target="_blank" href="/preisvergleich/Relocate/9501069376.html?categoryId=18928&amp;pos=4&amp;price=198.40&amp;productid=2317555&amp;sid=312899&amp;type=offer" data-wt-click="{&quot;id&quot;: &quot;leadout.oop.paymenticon&quot;}">
<span>
<img width="45" height="13" class="offerImage" src="//cdn.idealo.com/ipc/95351d/rwd/img/payment-icons/2x/visa.png" alt="Visa" title="Visa">
</span>
</a>
</span>
<span class="productOffers-listItemOfferShippingDetailsRightItem" title="MasterCard">
<a rel="nofollow" target="_blank" href="/preisvergleich/Relocate/9501069376.html?categoryId=18928&amp;pos=4&amp;price=198.40&amp;productid=2317555&amp;sid=312899&amp;type=offer" data-wt-click="{&quot;id&quot;: &quot;leadout.oop.paymenticon&quot;}">
<span>
<img width="45" height="13" class="offerImage" src="//cdn.idealo.com/ipc/95351d/rwd/img/payment-icons/2x/mastercard.png" alt="MasterCard" title="MasterCard">
</span>
</a>
</span>
<span class="productOffers-listItemOfferShippingDetailsRightItem" title="American Express">
<a rel="nofollow" target="_blank" href="/preisvergleich/Relocate/9501069376.html?categoryId=18928&amp;pos=4&amp;price=198.40&amp;productid=2317555&amp;sid=312899&amp;type=offer" data-wt-click="{&quot;id&quot;: &quot;leadout.oop.paymenticon&quot;}">
<span>
<img width="45" height="13" class="offerImage" src="//cdn.idealo.com/ipc/95351d/rwd/img/payment-icons/2x/american-express.png" alt="American Express" title="American Express">
</span>
</a>
</span>
<span class="productOffers-listItemOfferShippingDetailsRightItem" title="Nachnahme">
<a rel="nofollow" target="_blank" href="/preisvergleich/Relocate/9501069376.html?categoryId=18928&amp;pos=4&amp;price=198.40&amp;productid=2317555&amp;sid=312899&amp;type=offer" data-wt-click="{&quot;id&quot;: &quot;leadout.oop.paymenticon&quot;}">
<span>
Nachnahme
</span>
</a>
</span>
</div>
</div>
</div>
<span class="productOffers-listItemOfferShipping show-for-large-only" data-wt-click="{&quot;id&quot;: &quot;offer.shippingcosts&quot;, &quot;params&quot; : [&quot;&quot;, &quot;4&quot;, &quot;&quot;, &quot;&quot;]}" data-overlay="{
&quot;closeCaption&quot; : &quot;zur�ck&quot;,
&quot;contentLoad&quot; : &quot;/overlay/product/2317555/offer/9501069376/index/3&quot;,
&quot;contentLoadBy&quot; : &quot;ajax&quot;,
&quot;contentPaddingLeft&quot; : &quot;1rem&quot;,
&quot;contentPaddingRight&quot; : &quot;1rem&quot;,
&quot;eventsOn&quot; : &quot;click&quot;,
&quot;titleCaption&quot; : &quot;Angebotsdetails&quot;,
&quot;titleAlign&quot; : &quot;left&quot;,
&quot;titleSize&quot; : &quot;xlarge&quot;,
&quot;triggerOnClose&quot; : &quot;offer-close&quot;,
&quot;triggerOnOpen&quot; : &quot;offer-open&quot;,
&quot;triggerOpenEvent&quot; : &quot;offer_9501069376&quot;
}">
Versandkosten: ab �&nbsp;0,00
</span>
<div class="productOffers-listItemOfferDetailsMobile table hide-for-large-up">
<div class="table-row">
<div class="productOffers-listItemOfferDetails table-cell" data-overlay="{
&quot;closeCaption&quot; : &quot;zur�ck&quot;,
&quot;contentLoad&quot; : &quot;/overlay/product/2317555/offer/9501069376/index/3&quot;,
&quot;contentLoadBy&quot; : &quot;ajax&quot;,
&quot;contentPaddingLeft&quot; : &quot;1rem&quot;,
&quot;contentPaddingRight&quot; : &quot;1rem&quot;,
&quot;eventsOn&quot; : &quot;click&quot;,
&quot;titleCaption&quot; : &quot;Angebotsdetails&quot;,
&quot;titleAlign&quot; : &quot;left&quot;,
&quot;titleSize&quot; : &quot;xlarge&quot;,
&quot;triggerOnClose&quot; : &quot;offer-close&quot;,
&quot;triggerOnOpen&quot; : &quot;offer-open&quot;,
&quot;triggerOpenEvent&quot; : &quot;offer_9501069376&quot;
}">
Details
</div>
<div class="productOffers-listItemOfferDelivery delivery delivery--short icon-delivery table-cell" data-wt-click="{&quot;id&quot;: &quot;offer.delivery&quot;, &quot;params&quot; : [&quot;&quot;, &quot;4&quot;, &quot;&quot;, &quot;&quot;, &quot;new&quot;]}" data-overlay="{
&quot;closeCaption&quot; : &quot;zur�ck&quot;,
&quot;contentLoad&quot; : &quot;/overlay/product/2317555/offer/9501069376/index/3&quot;,
&quot;contentLoadBy&quot; : &quot;ajax&quot;,
&quot;contentPaddingLeft&quot; : &quot;1rem&quot;,
&quot;contentPaddingRight&quot; : &quot;1rem&quot;,
&quot;eventsOn&quot; : &quot;click&quot;,
&quot;titleCaption&quot; : &quot;Angebotsdetails&quot;,
&quot;titleAlign&quot; : &quot;left&quot;,
&quot;titleSize&quot; : &quot;xlarge&quot;,
&quot;triggerOnClose&quot; : &quot;offer-close&quot;,
&quot;triggerOnOpen&quot; : &quot;offer-open&quot;,
&quot;triggerOpenEvent&quot; : &quot;offer_9501069376&quot;
}">
</div>
</div>
</div>
</div>
<div class="hide-for-medium-down large-2 xlarge-4 columns productOffers-listItemOfferDeliveryBlock va-middle-xlarge-up" data-offerlist-column="delivery">
<div class="table-cell" data-overlay="{
&quot;closeCaption&quot; : &quot;zur�ck&quot;,
&quot;contentLoad&quot; : &quot;/overlay/product/2317555/offer/9501069376/index/3&quot;,
&quot;contentLoadBy&quot; : &quot;ajax&quot;,
&quot;contentPaddingLeft&quot; : &quot;1rem&quot;,
&quot;contentPaddingRight&quot; : &quot;1rem&quot;,
&quot;eventsOn&quot; : &quot;click&quot;,
&quot;titleCaption&quot; : &quot;Angebotsdetails&quot;,
&quot;titleAlign&quot; : &quot;left&quot;,
&quot;titleSize&quot; : &quot;xlarge&quot;,
&quot;triggerOnClose&quot; : &quot;offer-close&quot;,
&quot;triggerOnOpen&quot; : &quot;offer-open&quot;,
&quot;triggerOpenEvent&quot; : &quot;offer_9501069376&quot;
}">
<div class="table">
<div class="table-row" data-wt-click="{&quot;id&quot;: &quot;offer.details.layer&quot;, &quot;params&quot; : [&quot;&quot;,&quot;4&quot;,&quot;oop.offerlist.delivery&quot;]}">
<div class="table-cell va-top productOffers-listItemOfferDeliveryIconWrapper">
<span class="productOffers-listItemOfferDelivery delivery delivery--circle short" data-wt-click="{&quot;id&quot;: &quot;offer.delivery&quot;, &quot;params&quot; : [&quot;&quot;, &quot;4&quot;, &quot;&quot;, &quot;&quot;, &quot;new&quot;]}">
</span>
<span class="productOffers-listItemOfferDelivery delivery delivery--short icon-delivery hide-for-xlarge-up" data-wt-click="{&quot;id&quot;: &quot;offer.delivery&quot;, &quot;params&quot; : [&quot;&quot;, &quot;4&quot;, &quot;&quot;, &quot;&quot;, &quot;new&quot;]}">
</span>
</div>
<div class="table-cell">
<p class="productOffers-listItemOfferDeliveryStatus">2-3 Ar�beits�ta�gen</p>
</div>
</div>
</div>
</div>
</div>
<div class="small-6 large-3 xlarge-3 columns xlarge-text-left large-text-center small-text-right productOffers-listItemOfferShopBlock va-middle-xlarge-up" data-offerlist-column="shop">
<div class="productOffers-listItemOfferLogo">
<a class="productOffers-listItemOfferLogoLink" data-checkout="false" data-shop-name="hausfabrik.at - Shop aus Wien" href="/preisvergleich/Relocate/9501069376.html?categoryId=18928&amp;pos=4&amp;price=198.40&amp;productid=2317555&amp;sid=312899&amp;type=offer" rel="nofollow" target="_blank">
<img class="productOffers-listItemOfferLogoShop hide" data-wt-click="{&quot;id&quot;: &quot;offer.shoplogo&quot;, &quot;params&quot; : [&quot;&quot;, &quot;4&quot;, &quot;&quot;, &quot;&quot;, &quot;new&quot;]}" src="//cdn.idealo.com/folder/Shop/312/8/312899/s2_shop_160x60.png" data-shop-logo="//cdn.idealo.com/folder/Shop/312/8/312899/s2_shop_160x60.png" data-shop-logo-fallback="//cdn.idealo.com/folder/Shop/312/8/312899/s2_shop.gif" alt="hausfabrik.at - Shop aus Wien" width="80" height="30" style="display: inline-block;">
<noscript>
&lt;img class="productOffers-listItemOfferLogoShop noborder"
src="//cdn.idealo.com/folder/Shop/312/8/312899/s2_shop.gif"
alt="hausfabrik.at"
width="80" height="30"&gt;
</noscript>
</a>
</div>
<a class="hide show-for-large-up productOffers-listItemOfferRatingstext" href="https://www.idealo.at/preisvergleich/Shop/312899.html#NeueBewertung">
Shop-Meinung schreiben
</a>
</div>
<div class="productOffers-listItemOfferCtaHolder large-3 xlarge-4 columns va-middle-xlarge-up " data-offerlist-column="checkoutleadoutbuttons">
<ul class="productOffers-listItemOfferCta">
<li>
<a class="productOffers-listItemOfferCtaLeadout button button--leadout expand" href="/preisvergleich/Relocate/9501069376.html?categoryId=18928&amp;pos=4&amp;price=198.40&amp;productid=2317555&amp;sid=312899&amp;type=offer" data-after="Zum Shop" data-shop-name="hausfabrik.at" rel="nofollow" target="_blank">
<img class="btn-cta-shop" src="//cdn.idealo.com/ipc/95351d/pics/buttons/btn_placeholder.gif" alt="Grohe Grohtherm 3000 Cosmopolitan 19468 kaufen: g�nstige Wannenarmaturen bei hausfabrik.at">
</a>
</li>
</ul>
</div>
<a class="productOffers-listItemOfferLink" href="/preisvergleich/Relocate/9501069376.html?categoryId=18928&amp;pos=4&amp;price=198.40&amp;productid=2317555&amp;sid=312899&amp;type=offer" data-checkout="false" data-shop-name="hausfabrik.at" rel="nofollow" target="_blank">
</a>
</li>
<li class="productOffers-listItem row row-24" data-tm="{&quot;spr&quot;:&quot;e__&quot;}">
<div class="small-12 xlarge-6 columns productOffers-listItemTitleWrapper" data-offerlist-column="title">
<a class="productOffers-listItemTitle" data-wt-click="{&quot;id&quot;: &quot;offer.title&quot;, &quot;params&quot; : [&quot;&quot;, &quot;5&quot;, &quot;&quot;, &quot;&quot;]}" href="/preisvergleich/Relocate/519094132.html?categoryId=18928&amp;pos=5&amp;price=205.93&amp;productid=2317555&amp;sid=276684&amp;type=offer" target="_blank" rel="nofollow">
<span class="productOffers-listItemTitleInner">
Grohe Grohtherm 3000 Cos�mo�po�li�tan Ther�mo�stat-Wan�nen�bat�te�rie Fertigset chrom 19468000
</span>
</a>
</div>
<div class="productOffers-listItemOffer small-6 large-4 xlarge-7 columns" data-offerlist-column="price">
<a class="productOffers-listItemOfferPrice" data-wt-click="{&quot;id&quot;: &quot;offer.price&quot;, &quot;params&quot; : [&quot;&quot;, &quot;5&quot;, &quot;&quot;, &quot;&quot;, &quot;new&quot;]}" href="/preisvergleich/Relocate/519094132.html?categoryId=18928&amp;pos=5&amp;price=205.93&amp;productid=2317555&amp;sid=276684&amp;type=offer" rel="nofollow" target="_blank">
�&nbsp;205,93
</a><br>
<div class="productOffers-listItemOfferShippingDetails hide-for-large-down">
<div class="table-row">
<div class="table-cell productOffers-listItemOfferShippingDetailsLeftBefore">
</div>
<div class="table-cell productOffers-listItemOfferShippingDetailsLeft" title="�&nbsp;226,16 inkl. Versand">
�&nbsp;226,16 inkl. Versand
</div>
<div class="table-cell productOffers-listItemOfferShippingDetailsRight">
<span class="productOffers-listItemOfferShippingDetailsRightItem" title="Visa">
<a rel="nofollow" target="_blank" href="/preisvergleich/Relocate/519094132.html?categoryId=18928&amp;pos=5&amp;price=205.93&amp;productid=2317555&amp;sid=276684&amp;type=offer" data-wt-click="{&quot;id&quot;: &quot;leadout.oop.paymenticon&quot;}">
<span>
<img width="45" height="13" class="offerImage" src="//cdn.idealo.com/ipc/95351d/rwd/img/payment-icons/2x/visa.png" alt="Visa" title="Visa">
</span>
</a>
</span>
<span class="productOffers-listItemOfferShippingDetailsRightItem" title="MasterCard">
<a rel="nofollow" target="_blank" href="/preisvergleich/Relocate/519094132.html?categoryId=18928&amp;pos=5&amp;price=205.93&amp;productid=2317555&amp;sid=276684&amp;type=offer" data-wt-click="{&quot;id&quot;: &quot;leadout.oop.paymenticon&quot;}">
<span>
<img width="45" height="13" class="offerImage" src="//cdn.idealo.com/ipc/95351d/rwd/img/payment-icons/2x/mastercard.png" alt="MasterCard" title="MasterCard">
</span>
</a>
</span>
</div>
</div>
<div class="table-row">
<div class="table-cell productOffers-listItemOfferShippingDetailsLeftBefore">
</div>
<div class="table-cell productOffers-listItemOfferShippingDetailsLeft" title="�&nbsp;221,73 inkl. Versand">
�&nbsp;221,73 inkl. Versand
</div>
<div class="table-cell productOffers-listItemOfferShippingDetailsRight">
<span class="productOffers-listItemOfferShippingDetailsRightItem" title="Vorkasse">
<a rel="nofollow" target="_blank" href="/preisvergleich/Relocate/519094132.html?categoryId=18928&amp;pos=5&amp;price=205.93&amp;productid=2317555&amp;sid=276684&amp;type=offer" data-wt-click="{&quot;id&quot;: &quot;leadout.oop.paymenticon&quot;}">
<span>
Vorkasse
</span>
</a>
</span>
</div>
</div>
</div>
<span class="productOffers-listItemOfferShipping show-for-large-only" data-wt-click="{&quot;id&quot;: &quot;offer.shippingcosts&quot;, &quot;params&quot; : [&quot;&quot;, &quot;5&quot;, &quot;&quot;, &quot;&quot;]}" data-overlay="{
&quot;closeCaption&quot; : &quot;zur�ck&quot;,
&quot;contentLoad&quot; : &quot;/overlay/product/2317555/offer/519094132/index/4&quot;,
&quot;contentLoadBy&quot; : &quot;ajax&quot;,
&quot;contentPaddingLeft&quot; : &quot;1rem&quot;,
&quot;contentPaddingRight&quot; : &quot;1rem&quot;,
&quot;eventsOn&quot; : &quot;click&quot;,
&quot;titleCaption&quot; : &quot;Angebotsdetails&quot;,
&quot;titleAlign&quot; : &quot;left&quot;,
&quot;titleSize&quot; : &quot;xlarge&quot;,
&quot;triggerOnClose&quot; : &quot;offer-close&quot;,
&quot;triggerOnOpen&quot; : &quot;offer-open&quot;,
&quot;triggerOpenEvent&quot; : &quot;offer_519094132&quot;
}">
Versandkosten: ab �&nbsp;15,80
</span>
<div class="productOffers-listItemOfferDetailsMobile table hide-for-large-up">
<div class="table-row">
<div class="productOffers-listItemOfferDetails table-cell" data-overlay="{
&quot;closeCaption&quot; : &quot;zur�ck&quot;,
&quot;contentLoad&quot; : &quot;/overlay/product/2317555/offer/519094132/index/4&quot;,
&quot;contentLoadBy&quot; : &quot;ajax&quot;,
&quot;contentPaddingLeft&quot; : &quot;1rem&quot;,
&quot;contentPaddingRight&quot; : &quot;1rem&quot;,
&quot;eventsOn&quot; : &quot;click&quot;,
&quot;titleCaption&quot; : &quot;Angebotsdetails&quot;,
&quot;titleAlign&quot; : &quot;left&quot;,
&quot;titleSize&quot; : &quot;xlarge&quot;,
&quot;triggerOnClose&quot; : &quot;offer-close&quot;,
&quot;triggerOnOpen&quot; : &quot;offer-open&quot;,
&quot;triggerOpenEvent&quot; : &quot;offer_519094132&quot;
}">
Details
</div>
<div class="productOffers-listItemOfferDelivery delivery delivery--short icon-delivery table-cell" data-wt-click="{&quot;id&quot;: &quot;offer.delivery&quot;, &quot;params&quot; : [&quot;&quot;, &quot;5&quot;, &quot;&quot;, &quot;&quot;, &quot;new&quot;]}" data-overlay="{
&quot;closeCaption&quot; : &quot;zur�ck&quot;,
&quot;contentLoad&quot; : &quot;/overlay/product/2317555/offer/519094132/index/4&quot;,
&quot;contentLoadBy&quot; : &quot;ajax&quot;,
&quot;contentPaddingLeft&quot; : &quot;1rem&quot;,
&quot;contentPaddingRight&quot; : &quot;1rem&quot;,
&quot;eventsOn&quot; : &quot;click&quot;,
&quot;titleCaption&quot; : &quot;Angebotsdetails&quot;,
&quot;titleAlign&quot; : &quot;left&quot;,
&quot;titleSize&quot; : &quot;xlarge&quot;,
&quot;triggerOnClose&quot; : &quot;offer-close&quot;,
&quot;triggerOnOpen&quot; : &quot;offer-open&quot;,
&quot;triggerOpenEvent&quot; : &quot;offer_519094132&quot;
}">
</div>
</div>
</div>
</div>
<div class="hide-for-medium-down large-2 xlarge-4 columns productOffers-listItemOfferDeliveryBlock va-middle-xlarge-up" data-offerlist-column="delivery">
<div class="table-cell" data-overlay="{
&quot;closeCaption&quot; : &quot;zur�ck&quot;,
&quot;contentLoad&quot; : &quot;/overlay/product/2317555/offer/519094132/index/4&quot;,
&quot;contentLoadBy&quot; : &quot;ajax&quot;,
&quot;contentPaddingLeft&quot; : &quot;1rem&quot;,
&quot;contentPaddingRight&quot; : &quot;1rem&quot;,
&quot;eventsOn&quot; : &quot;click&quot;,
&quot;titleCaption&quot; : &quot;Angebotsdetails&quot;,
&quot;titleAlign&quot; : &quot;left&quot;,
&quot;titleSize&quot; : &quot;xlarge&quot;,
&quot;triggerOnClose&quot; : &quot;offer-close&quot;,
&quot;triggerOnOpen&quot; : &quot;offer-open&quot;,
&quot;triggerOpenEvent&quot; : &quot;offer_519094132&quot;
}">
<div class="table">
<div class="table-row" data-wt-click="{&quot;id&quot;: &quot;offer.details.layer&quot;, &quot;params&quot; : [&quot;&quot;,&quot;5&quot;,&quot;oop.offerlist.delivery&quot;]}">
<div class="table-cell va-top productOffers-listItemOfferDeliveryIconWrapper">
<span class="productOffers-listItemOfferDelivery delivery delivery--circle short" data-wt-click="{&quot;id&quot;: &quot;offer.delivery&quot;, &quot;params&quot; : [&quot;&quot;, &quot;5&quot;, &quot;&quot;, &quot;&quot;, &quot;new&quot;]}">
</span>
<span class="productOffers-listItemOfferDelivery delivery delivery--short icon-delivery hide-for-xlarge-up" data-wt-click="{&quot;id&quot;: &quot;offer.delivery&quot;, &quot;params&quot; : [&quot;&quot;, &quot;5&quot;, &quot;&quot;, &quot;&quot;, &quot;new&quot;]}">
</span>
</div>
<div class="table-cell">
<p class="productOffers-listItemOfferDeliveryStatus">Sofort ver�sand�fer�tig</p>
<div class="productOffers-listItemOfferDeliveryProviderWrapper">
<span class="productOffers-listItemOfferGreyBadge productOffers-listItemOfferDeliveryProvider">DHL</span>
</div>
</div>
</div>
</div>
</div>
</div>
<div class="small-6 large-3 xlarge-3 columns xlarge-text-left large-text-center small-text-right productOffers-listItemOfferShopBlock va-middle-xlarge-up" data-offerlist-column="shop">
<div class="productOffers-listItemOfferLogo">
<a class="productOffers-listItemOfferLogoLink" data-checkout="false" data-shop-name="emero.de - Shop aus D�sseldorf" href="/preisvergleich/Relocate/519094132.html?categoryId=18928&amp;pos=5&amp;price=205.93&amp;productid=2317555&amp;sid=276684&amp;type=offer" rel="nofollow" target="_blank">
<img class="productOffers-listItemOfferLogoShop hide" data-wt-click="{&quot;id&quot;: &quot;offer.shoplogo&quot;, &quot;params&quot; : [&quot;&quot;, &quot;5&quot;, &quot;&quot;, &quot;&quot;, &quot;new&quot;]}" src="//cdn.idealo.com/folder/Shop/276/6/276684/s2_shop_160x60.png" data-shop-logo="//cdn.idealo.com/folder/Shop/276/6/276684/s2_shop_160x60.png" data-shop-logo-fallback="//cdn.idealo.com/folder/Shop/276/6/276684/s2_shop.gif" alt="emero.de - Shop aus D�sseldorf" width="80" height="30" style="display: inline-block;">
<noscript>
&lt;img class="productOffers-listItemOfferLogoShop noborder"
src="//cdn.idealo.com/folder/Shop/276/6/276684/s2_shop.gif"
alt="emero.de"
width="80" height="30"&gt;
</noscript>
</a>
</div>
<a class="productOffers-listItemOfferShopBlockRatingLink" href="https://www.idealo.at/preisvergleich/Shop/276684.html">
<div class="rating-wrapper">
<div class="table">
<div class="table-row">
<div class="table-cell rating-starsContainer">
<div class="rating-stars rating-stars--small">
<div class="rating-starsWrapper-60">
<img class="rating-starsImage rating-stars--default" src="//cdn.idealo.com/ipc/95351d/rwd/img/spacer.png" alt="*">
</div>
</div>
</div>
</div>
</div>
</div>
</a>
<a class="productOffers-listItemOfferRatingstext" href="https://www.idealo.at/preisvergleich/Shop/276684.html">
133 Meinungen
</a>
</div>
<div class="productOffers-listItemOfferCtaHolder large-3 xlarge-4 columns va-middle-xlarge-up " data-offerlist-column="checkoutleadoutbuttons">
<ul class="productOffers-listItemOfferCta">
<li>
<a class="productOffers-listItemOfferCtaLeadout button button--leadout expand" href="/preisvergleich/Relocate/519094132.html?categoryId=18928&amp;pos=5&amp;price=205.93&amp;productid=2317555&amp;sid=276684&amp;type=offer" data-after="Zum Shop" data-shop-name="emero.de" rel="nofollow" target="_blank">
<img class="btn-cta-shop" src="//cdn.idealo.com/ipc/95351d/pics/buttons/btn_placeholder.gif" alt="Grohe Grohtherm 3000 Cosmopolitan Thermostat 19468 bestellen: preiswerte Wannenarmaturen bei emero.de">
</a>
</li>
</ul>
</div>
<a class="productOffers-listItemOfferLink" href="/preisvergleich/Relocate/519094132.html?categoryId=18928&amp;pos=5&amp;price=205.93&amp;productid=2317555&amp;sid=276684&amp;type=offer" data-checkout="false" data-shop-name="emero.de" rel="nofollow" target="_blank">
</a>
</li>
<li class="productOffers-listItem row row-24" data-tm="{&quot;spr&quot;:&quot;ead&quot;}">
<div class="small-12 xlarge-6 columns productOffers-listItemTitleWrapper" data-offerlist-column="title">
<a class="productOffers-listItemTitle" data-wt-click="{&quot;id&quot;: &quot;offer.title&quot;, &quot;params&quot; : [&quot;&quot;, &quot;6&quot;, &quot;&quot;, &quot;&quot;]}" href="/preisvergleich/Relocate/7641085868.html?categoryId=18928&amp;pos=6&amp;price=206.56&amp;productid=2317555&amp;sid=279747&amp;type=offer" target="_blank" rel="nofollow">
<span class="productOffers-listItemTitleInner">
Grohe Grohtherm 3000 Braus�ether�mo�stat 19468000 Cos�mo�po�li�tan, Unterputz Ther�mo�stat, chrom
</span>
</a>
</div>
<div class="productOffers-listItemOffer small-6 large-4 xlarge-7 columns" data-offerlist-column="price">
<a class="productOffers-listItemOfferPrice" data-wt-click="{&quot;id&quot;: &quot;offer.price&quot;, &quot;params&quot; : [&quot;&quot;, &quot;6&quot;, &quot;&quot;, &quot;&quot;, &quot;new&quot;]}" href="/preisvergleich/Relocate/7641085868.html?categoryId=18928&amp;pos=6&amp;price=206.56&amp;productid=2317555&amp;sid=279747&amp;type=offer" rel="nofollow" target="_blank">
�&nbsp;206,56
</a><br>
<div class="productOffers-listItemOfferShippingDetails hide-for-large-down">
<div class="table-row">
<div class="table-cell productOffers-listItemOfferShippingDetailsLeftBefore">
</div>
<div class="table-cell productOffers-listItemOfferShippingDetailsLeft" title="�&nbsp;222,85 inkl. Versand">
�&nbsp;222,85 inkl. Versand
</div>
<div class="table-cell productOffers-listItemOfferShippingDetailsRight">
<span class="productOffers-listItemOfferShippingDetailsRightItem" title="PayPal">
<a rel="nofollow" target="_blank" href="/preisvergleich/Relocate/7641085868.html?categoryId=18928&amp;pos=6&amp;price=206.56&amp;productid=2317555&amp;sid=279747&amp;type=offer" data-wt-click="{&quot;id&quot;: &quot;leadout.oop.paymenticon&quot;}">
<span>
<img width="45" height="13" class="offerImage" src="//cdn.idealo.com/ipc/95351d/rwd/img/payment-icons/2x/paypal.png" alt="PayPal" title="PayPal">
</span>
</a>
</span>
<span class="productOffers-listItemOfferShippingDetailsRightItem" title="Lastschrift">
<a rel="nofollow" target="_blank" href="/preisvergleich/Relocate/7641085868.html?categoryId=18928&amp;pos=6&amp;price=206.56&amp;productid=2317555&amp;sid=279747&amp;type=offer" data-wt-click="{&quot;id&quot;: &quot;leadout.oop.paymenticon&quot;}">
<span>
Lastschrift
</span>
</a>
</span>
</div>
</div>
<div class="table-row">
<div class="table-cell productOffers-listItemOfferShippingDetailsLeftBefore">
</div>
<div class="table-cell productOffers-listItemOfferShippingDetailsLeft" title="�&nbsp;223,95 inkl. Versand">
�&nbsp;223,95 inkl. Versand
</div>
<div class="table-cell productOffers-listItemOfferShippingDetailsRight">
<span class="productOffers-listItemOfferShippingDetailsRightItem" title="Visa">
<a rel="nofollow" target="_blank" href="/preisvergleich/Relocate/7641085868.html?categoryId=18928&amp;pos=6&amp;price=206.56&amp;productid=2317555&amp;sid=279747&amp;type=offer" data-wt-click="{&quot;id&quot;: &quot;leadout.oop.paymenticon&quot;}">
<span>
<img width="45" height="13" class="offerImage" src="//cdn.idealo.com/ipc/95351d/rwd/img/payment-icons/2x/visa.png" alt="Visa" title="Visa">
</span>
</a>
</span>
<span class="productOffers-listItemOfferShippingDetailsRightItem" title="MasterCard">
<a rel="nofollow" target="_blank" href="/preisvergleich/Relocate/7641085868.html?categoryId=18928&amp;pos=6&amp;price=206.56&amp;productid=2317555&amp;sid=279747&amp;type=offer" data-wt-click="{&quot;id&quot;: &quot;leadout.oop.paymenticon&quot;}">
<span>
<img width="45" height="13" class="offerImage" src="//cdn.idealo.com/ipc/95351d/rwd/img/payment-icons/2x/mastercard.png" alt="MasterCard" title="MasterCard">
</span>
</a>
</span>
</div>
</div>
<div class="table-row">
<div class="table-cell productOffers-listItemOfferShippingDetailsLeftBefore">
</div>
<div class="table-cell productOffers-listItemOfferShippingDetailsLeft" title="�&nbsp;219,56 inkl. Versand">
�&nbsp;219,56 inkl. Versand
</div>
<div class="table-cell productOffers-listItemOfferShippingDetailsRight">
<span class="productOffers-listItemOfferShippingDetailsRightItem" title="Vorkasse">
<a rel="nofollow" target="_blank" href="/preisvergleich/Relocate/7641085868.html?categoryId=18928&amp;pos=6&amp;price=206.56&amp;productid=2317555&amp;sid=279747&amp;type=offer" data-wt-click="{&quot;id&quot;: &quot;leadout.oop.paymenticon&quot;}">
<span>
Vorkasse
</span>
</a>
</span>
</div>
</div>
<div class="table-row">
<div class="table-cell productOffers-listItemOfferShippingDetailsLeftBefore">
</div>
<div class="table-cell productOffers-listItemOfferShippingDetailsLeft" title="�&nbsp;221,76 inkl. Versand">
�&nbsp;221,76 inkl. Versand
</div>
<div class="table-cell productOffers-listItemOfferShippingDetailsRight">
<span class="productOffers-listItemOfferShippingDetailsRightItem" title="Sofort�berweisung">
<a rel="nofollow" target="_blank" href="/preisvergleich/Relocate/7641085868.html?categoryId=18928&amp;pos=6&amp;price=206.56&amp;productid=2317555&amp;sid=279747&amp;type=offer" data-wt-click="{&quot;id&quot;: &quot;leadout.oop.paymenticon&quot;}">
<span>
<img width="45" height="13" class="offerImage" src="//cdn.idealo.com/ipc/95351d/rwd/img/payment-icons/2x/sofort.png" alt="Sofort�berweisung" title="Sofort�berweisung">
</span>
</a>
</span>
</div>
</div>
</div>
<span class="productOffers-listItemOfferShipping show-for-large-only" data-wt-click="{&quot;id&quot;: &quot;offer.shippingcosts&quot;, &quot;params&quot; : [&quot;&quot;, &quot;6&quot;, &quot;&quot;, &quot;&quot;]}" data-overlay="{
&quot;closeCaption&quot; : &quot;zur�ck&quot;,
&quot;contentLoad&quot; : &quot;/overlay/product/2317555/offer/7641085868/index/5&quot;,
&quot;contentLoadBy&quot; : &quot;ajax&quot;,
&quot;contentPaddingLeft&quot; : &quot;1rem&quot;,
&quot;contentPaddingRight&quot; : &quot;1rem&quot;,
&quot;eventsOn&quot; : &quot;click&quot;,
&quot;titleCaption&quot; : &quot;Angebotsdetails&quot;,
&quot;titleAlign&quot; : &quot;left&quot;,
&quot;titleSize&quot; : &quot;xlarge&quot;,
&quot;triggerOnClose&quot; : &quot;offer-close&quot;,
&quot;triggerOnOpen&quot; : &quot;offer-open&quot;,
&quot;triggerOpenEvent&quot; : &quot;offer_7641085868&quot;
}">
Versandkosten: ab �&nbsp;13,00
</span>
<div class="productOffers-listItemOfferDetailsMobile table hide-for-large-up">
<div class="table-row">
<div class="productOffers-listItemOfferDetails table-cell" data-overlay="{
&quot;closeCaption&quot; : &quot;zur�ck&quot;,
&quot;contentLoad&quot; : &quot;/overlay/product/2317555/offer/7641085868/index/5&quot;,
&quot;contentLoadBy&quot; : &quot;ajax&quot;,
&quot;contentPaddingLeft&quot; : &quot;1rem&quot;,
&quot;contentPaddingRight&quot; : &quot;1rem&quot;,
&quot;eventsOn&quot; : &quot;click&quot;,
&quot;titleCaption&quot; : &quot;Angebotsdetails&quot;,
&quot;titleAlign&quot; : &quot;left&quot;,
&quot;titleSize&quot; : &quot;xlarge&quot;,
&quot;triggerOnClose&quot; : &quot;offer-close&quot;,
&quot;triggerOnOpen&quot; : &quot;offer-open&quot;,
&quot;triggerOpenEvent&quot; : &quot;offer_7641085868&quot;
}">
Details
</div>
<div class="productOffers-listItemOfferDelivery delivery delivery--short icon-delivery table-cell" data-wt-click="{&quot;id&quot;: &quot;offer.delivery&quot;, &quot;params&quot; : [&quot;&quot;, &quot;6&quot;, &quot;&quot;, &quot;&quot;, &quot;new&quot;]}" data-overlay="{
&quot;closeCaption&quot; : &quot;zur�ck&quot;,
&quot;contentLoad&quot; : &quot;/overlay/product/2317555/offer/7641085868/index/5&quot;,
&quot;contentLoadBy&quot; : &quot;ajax&quot;,
&quot;contentPaddingLeft&quot; : &quot;1rem&quot;,
&quot;contentPaddingRight&quot; : &quot;1rem&quot;,
&quot;eventsOn&quot; : &quot;click&quot;,
&quot;titleCaption&quot; : &quot;Angebotsdetails&quot;,
&quot;titleAlign&quot; : &quot;left&quot;,
&quot;titleSize&quot; : &quot;xlarge&quot;,
&quot;triggerOnClose&quot; : &quot;offer-close&quot;,
&quot;triggerOnOpen&quot; : &quot;offer-open&quot;,
&quot;triggerOpenEvent&quot; : &quot;offer_7641085868&quot;
}">
</div>
</div>
</div>
</div>
<div class="hide-for-medium-down large-2 xlarge-4 columns productOffers-listItemOfferDeliveryBlock va-middle-xlarge-up" data-offerlist-column="delivery">
<div class="table-cell" data-overlay="{
&quot;closeCaption&quot; : &quot;zur�ck&quot;,
&quot;contentLoad&quot; : &quot;/overlay/product/2317555/offer/7641085868/index/5&quot;,
&quot;contentLoadBy&quot; : &quot;ajax&quot;,
&quot;contentPaddingLeft&quot; : &quot;1rem&quot;,
&quot;contentPaddingRight&quot; : &quot;1rem&quot;,
&quot;eventsOn&quot; : &quot;click&quot;,
&quot;titleCaption&quot; : &quot;Angebotsdetails&quot;,
&quot;titleAlign&quot; : &quot;left&quot;,
&quot;titleSize&quot; : &quot;xlarge&quot;,
&quot;triggerOnClose&quot; : &quot;offer-close&quot;,
&quot;triggerOnOpen&quot; : &quot;offer-open&quot;,
&quot;triggerOpenEvent&quot; : &quot;offer_7641085868&quot;
}">
<div class="table">
<div class="table-row" data-wt-click="{&quot;id&quot;: &quot;offer.details.layer&quot;, &quot;params&quot; : [&quot;&quot;,&quot;6&quot;,&quot;oop.offerlist.delivery&quot;]}">
<div class="table-cell va-top productOffers-listItemOfferDeliveryIconWrapper">
<span class="productOffers-listItemOfferDelivery delivery delivery--circle short" data-wt-click="{&quot;id&quot;: &quot;offer.delivery&quot;, &quot;params&quot; : [&quot;&quot;, &quot;6&quot;, &quot;&quot;, &quot;&quot;, &quot;new&quot;]}">
</span>
<span class="productOffers-listItemOfferDelivery delivery delivery--short icon-delivery hide-for-xlarge-up" data-wt-click="{&quot;id&quot;: &quot;offer.delivery&quot;, &quot;params&quot; : [&quot;&quot;, &quot;6&quot;, &quot;&quot;, &quot;&quot;, &quot;new&quot;]}">
</span>
</div>
<div class="table-cell">
<p class="productOffers-listItemOfferDeliveryStatus">1-3 Werk�ta�ge</p>
</div>
</div>
</div>
</div>
</div>
<div class="small-6 large-3 xlarge-3 columns xlarge-text-left large-text-center small-text-right productOffers-listItemOfferShopBlock va-middle-xlarge-up" data-offerlist-column="shop">
<div class="productOffers-listItemOfferLogo">
<a class="productOffers-listItemOfferLogoLink" data-checkout="false" data-shop-name="skybad.de - Shop aus Aachen" href="/preisvergleich/Relocate/7641085868.html?categoryId=18928&amp;pos=6&amp;price=206.56&amp;productid=2317555&amp;sid=279747&amp;type=offer" rel="nofollow" target="_blank">
<img class="productOffers-listItemOfferLogoShop hide" data-wt-click="{&quot;id&quot;: &quot;offer.shoplogo&quot;, &quot;params&quot; : [&quot;&quot;, &quot;6&quot;, &quot;&quot;, &quot;&quot;, &quot;new&quot;]}" src="//cdn.idealo.com/folder/Shop/279/7/279747/s2_shop_160x60.png" data-shop-logo="//cdn.idealo.com/folder/Shop/279/7/279747/s2_shop_160x60.png" data-shop-logo-fallback="//cdn.idealo.com/folder/Shop/279/7/279747/s2_shop.gif" alt="skybad.de - Shop aus Aachen" width="80" height="30" style="display: inline-block;">
<noscript>
&lt;img class="productOffers-listItemOfferLogoShop noborder"
src="//cdn.idealo.com/folder/Shop/279/7/279747/s2_shop.gif"
alt="skybad.de"
width="80" height="30"&gt;
</noscript>
</a>
</div>
<a class="productOffers-listItemOfferShopBlockRatingLink" href="https://www.idealo.at/preisvergleich/Shop/279747.html">
<div class="rating-wrapper">
<div class="table">
<div class="table-row">
<div class="table-cell rating-starsContainer">
<div class="rating-stars rating-stars--small">
<div class="rating-starsWrapper-90">
<img class="rating-starsImage rating-stars--default" src="//cdn.idealo.com/ipc/95351d/rwd/img/spacer.png" alt="*">
</div>
</div>
</div>
</div>
</div>
</div>
</a>
<a class="productOffers-listItemOfferRatingstext" href="https://www.idealo.at/preisvergleich/Shop/279747.html">
33 Meinungen
</a>
</div>
<div class="productOffers-listItemOfferCtaHolder large-3 xlarge-4 columns va-middle-xlarge-up " data-offerlist-column="checkoutleadoutbuttons">
<ul class="productOffers-listItemOfferCta">
<li>
<a class="productOffers-listItemOfferCtaLeadout button button--leadout expand" href="/preisvergleich/Relocate/7641085868.html?categoryId=18928&amp;pos=6&amp;price=206.56&amp;productid=2317555&amp;sid=279747&amp;type=offer" data-after="Zum Shop" data-shop-name="skybad.de" rel="nofollow" target="_blank">
<img class="btn-cta-shop" src="//cdn.idealo.com/ipc/95351d/pics/buttons/btn_placeholder.gif" alt="Grohe Grohtherm 3000 Cosmopolitan Wannenbatterie versand: billige Wannenarmaturen bei skybad.de">
</a>
</li>
</ul>
</div>
<a class="productOffers-listItemOfferLink" href="/preisvergleich/Relocate/7641085868.html?categoryId=18928&amp;pos=6&amp;price=206.56&amp;productid=2317555&amp;sid=279747&amp;type=offer" data-checkout="false" data-shop-name="skybad.de" rel="nofollow" target="_blank">
</a>
</li>
<li class="productOffers-listItem row row-24" data-tm="{&quot;spr&quot;:&quot;e__&quot;}">
<div class="small-12 xlarge-6 columns productOffers-listItemTitleWrapper" data-offerlist-column="title">
<a class="productOffers-listItemTitle" data-wt-click="{&quot;id&quot;: &quot;offer.title&quot;, &quot;params&quot; : [&quot;&quot;, &quot;7&quot;, &quot;&quot;, &quot;&quot;]}" href="/preisvergleich/Relocate/4771931268.html?categoryId=18928&amp;pos=7&amp;price=208.22&amp;productid=2317555&amp;sid=26395&amp;type=offer" target="_blank" rel="nofollow">
<span class="productOffers-listItemTitleInner">
Grohe Grohtherm 3000 Cos�mo�po�li�tan Ther�mo�stat-Wan�nen�bat�te�rie Grohtherm 3000 ohne Grund�k�r�per chrom 19468000
</span>
</a>
</div>
<div class="productOffers-listItemOffer small-6 large-4 xlarge-7 columns" data-offerlist-column="price">
<a class="productOffers-listItemOfferPrice" data-wt-click="{&quot;id&quot;: &quot;offer.price&quot;, &quot;params&quot; : [&quot;&quot;, &quot;7&quot;, &quot;&quot;, &quot;&quot;, &quot;new&quot;]}" href="/preisvergleich/Relocate/4771931268.html?categoryId=18928&amp;pos=7&amp;price=208.22&amp;productid=2317555&amp;sid=26395&amp;type=offer" rel="nofollow" target="_blank">
�&nbsp;208,22
</a><br>
<div class="productOffers-listItemOfferShippingDetails hide-for-large-down">
<div class="table-row">
<div class="table-cell productOffers-listItemOfferShippingDetailsLeftBefore">
</div>
<div class="table-cell productOffers-listItemOfferShippingDetailsLeft" title="�&nbsp;223,21 inkl. Versand">
�&nbsp;223,21 inkl. Versand
</div>
<div class="table-cell productOffers-listItemOfferShippingDetailsRight">
<span class="productOffers-listItemOfferShippingDetailsRightItem" title="Visa">
<a rel="nofollow" target="_blank" href="/preisvergleich/Relocate/4771931268.html?categoryId=18928&amp;pos=7&amp;price=208.22&amp;productid=2317555&amp;sid=26395&amp;type=offer" data-wt-click="{&quot;id&quot;: &quot;leadout.oop.paymenticon&quot;}">
<span>
<img width="45" height="13" class="offerImage" src="//cdn.idealo.com/ipc/95351d/rwd/img/payment-icons/2x/visa.png" alt="Visa" title="Visa">
</span>
</a>
</span>
<span class="productOffers-listItemOfferShippingDetailsRightItem" title="MasterCard">
<a rel="nofollow" target="_blank" href="/preisvergleich/Relocate/4771931268.html?categoryId=18928&amp;pos=7&amp;price=208.22&amp;productid=2317555&amp;sid=26395&amp;type=offer" data-wt-click="{&quot;id&quot;: &quot;leadout.oop.paymenticon&quot;}">
<span>
<img width="45" height="13" class="offerImage" src="//cdn.idealo.com/ipc/95351d/rwd/img/payment-icons/2x/mastercard.png" alt="MasterCard" title="MasterCard">
</span>
</a>
</span>
<span class="productOffers-listItemOfferShippingDetailsRightItem" title="Vorkasse">
<a rel="nofollow" target="_blank" href="/preisvergleich/Relocate/4771931268.html?categoryId=18928&amp;pos=7&amp;price=208.22&amp;productid=2317555&amp;sid=26395&amp;type=offer" data-wt-click="{&quot;id&quot;: &quot;leadout.oop.paymenticon&quot;}">
<span>
Vorkasse
</span>
</a>
</span>
</div>
</div>
</div>
<span class="productOffers-listItemOfferShipping show-for-large-only" data-wt-click="{&quot;id&quot;: &quot;offer.shippingcosts&quot;, &quot;params&quot; : [&quot;&quot;, &quot;7&quot;, &quot;&quot;, &quot;&quot;]}" data-overlay="{
&quot;closeCaption&quot; : &quot;zur�ck&quot;,
&quot;contentLoad&quot; : &quot;/overlay/product/2317555/offer/4771931268/index/6&quot;,
&quot;contentLoadBy&quot; : &quot;ajax&quot;,
&quot;contentPaddingLeft&quot; : &quot;1rem&quot;,
&quot;contentPaddingRight&quot; : &quot;1rem&quot;,
&quot;eventsOn&quot; : &quot;click&quot;,
&quot;titleCaption&quot; : &quot;Angebotsdetails&quot;,
&quot;titleAlign&quot; : &quot;left&quot;,
&quot;titleSize&quot; : &quot;xlarge&quot;,
&quot;triggerOnClose&quot; : &quot;offer-close&quot;,
&quot;triggerOnOpen&quot; : &quot;offer-open&quot;,
&quot;triggerOpenEvent&quot; : &quot;offer_4771931268&quot;
}">
Versandkosten: ab �&nbsp;14,99
</span>
<div class="productOffers-listItemOfferDetailsMobile table hide-for-large-up">
<div class="table-row">
<div class="productOffers-listItemOfferDetails table-cell" data-overlay="{
&quot;closeCaption&quot; : &quot;zur�ck&quot;,
&quot;contentLoad&quot; : &quot;/overlay/product/2317555/offer/4771931268/index/6&quot;,
&quot;contentLoadBy&quot; : &quot;ajax&quot;,
&quot;contentPaddingLeft&quot; : &quot;1rem&quot;,
&quot;contentPaddingRight&quot; : &quot;1rem&quot;,
&quot;eventsOn&quot; : &quot;click&quot;,
&quot;titleCaption&quot; : &quot;Angebotsdetails&quot;,
&quot;titleAlign&quot; : &quot;left&quot;,
&quot;titleSize&quot; : &quot;xlarge&quot;,
&quot;triggerOnClose&quot; : &quot;offer-close&quot;,
&quot;triggerOnOpen&quot; : &quot;offer-open&quot;,
&quot;triggerOpenEvent&quot; : &quot;offer_4771931268&quot;
}">
Details
</div>
<div class="productOffers-listItemOfferDelivery delivery delivery--short icon-delivery table-cell" data-wt-click="{&quot;id&quot;: &quot;offer.delivery&quot;, &quot;params&quot; : [&quot;&quot;, &quot;7&quot;, &quot;&quot;, &quot;&quot;, &quot;new&quot;]}" data-overlay="{
&quot;closeCaption&quot; : &quot;zur�ck&quot;,
&quot;contentLoad&quot; : &quot;/overlay/product/2317555/offer/4771931268/index/6&quot;,
&quot;contentLoadBy&quot; : &quot;ajax&quot;,
&quot;contentPaddingLeft&quot; : &quot;1rem&quot;,
&quot;contentPaddingRight&quot; : &quot;1rem&quot;,
&quot;eventsOn&quot; : &quot;click&quot;,
&quot;titleCaption&quot; : &quot;Angebotsdetails&quot;,
&quot;titleAlign&quot; : &quot;left&quot;,
&quot;titleSize&quot; : &quot;xlarge&quot;,
&quot;triggerOnClose&quot; : &quot;offer-close&quot;,
&quot;triggerOnOpen&quot; : &quot;offer-open&quot;,
&quot;triggerOpenEvent&quot; : &quot;offer_4771931268&quot;
}">
</div>
</div>
</div>
</div>
<div class="hide-for-medium-down large-2 xlarge-4 columns productOffers-listItemOfferDeliveryBlock va-middle-xlarge-up" data-offerlist-column="delivery">
<div class="table-cell" data-overlay="{
&quot;closeCaption&quot; : &quot;zur�ck&quot;,
&quot;contentLoad&quot; : &quot;/overlay/product/2317555/offer/4771931268/index/6&quot;,
&quot;contentLoadBy&quot; : &quot;ajax&quot;,
&quot;contentPaddingLeft&quot; : &quot;1rem&quot;,
&quot;contentPaddingRight&quot; : &quot;1rem&quot;,
&quot;eventsOn&quot; : &quot;click&quot;,
&quot;titleCaption&quot; : &quot;Angebotsdetails&quot;,
&quot;titleAlign&quot; : &quot;left&quot;,
&quot;titleSize&quot; : &quot;xlarge&quot;,
&quot;triggerOnClose&quot; : &quot;offer-close&quot;,
&quot;triggerOnOpen&quot; : &quot;offer-open&quot;,
&quot;triggerOpenEvent&quot; : &quot;offer_4771931268&quot;
}">
<div class="table">
<div class="table-row" data-wt-click="{&quot;id&quot;: &quot;offer.details.layer&quot;, &quot;params&quot; : [&quot;&quot;,&quot;7&quot;,&quot;oop.offerlist.delivery&quot;]}">
<div class="table-cell va-top productOffers-listItemOfferDeliveryIconWrapper">
<span class="productOffers-listItemOfferDelivery delivery delivery--circle short" data-wt-click="{&quot;id&quot;: &quot;offer.delivery&quot;, &quot;params&quot; : [&quot;&quot;, &quot;7&quot;, &quot;&quot;, &quot;&quot;, &quot;new&quot;]}">
</span>
<span class="productOffers-listItemOfferDelivery delivery delivery--short icon-delivery hide-for-xlarge-up" data-wt-click="{&quot;id&quot;: &quot;offer.delivery&quot;, &quot;params&quot; : [&quot;&quot;, &quot;7&quot;, &quot;&quot;, &quot;&quot;, &quot;new&quot;]}">
</span>
</div>
<div class="table-cell">
<p class="productOffers-listItemOfferDeliveryStatus">Sofort ver�sand�fer�tig</p>
</div>
</div>
</div>
</div>
</div>
<div class="small-6 large-3 xlarge-3 columns xlarge-text-left large-text-center small-text-right productOffers-listItemOfferShopBlock va-middle-xlarge-up" data-offerlist-column="shop">
<div class="productOffers-listItemOfferLogo">
<a class="productOffers-listItemOfferLogoLink" data-checkout="false" data-shop-name="megabad.com - Shop aus K�ln" href="/preisvergleich/Relocate/4771931268.html?categoryId=18928&amp;pos=7&amp;price=208.22&amp;productid=2317555&amp;sid=26395&amp;type=offer" rel="nofollow" target="_blank">
<img class="productOffers-listItemOfferLogoShop hide" data-wt-click="{&quot;id&quot;: &quot;offer.shoplogo&quot;, &quot;params&quot; : [&quot;&quot;, &quot;7&quot;, &quot;&quot;, &quot;&quot;, &quot;new&quot;]}" src="//cdn.idealo.com/folder/Shop/26/3/26395/s2_shop_160x60.png" data-shop-logo="//cdn.idealo.com/folder/Shop/26/3/26395/s2_shop_160x60.png" data-shop-logo-fallback="//cdn.idealo.com/folder/Shop/26/3/26395/s2_shop.gif" alt="megabad.com - Shop aus K�ln" width="80" height="30" style="display: inline-block;">
<noscript>
&lt;img class="productOffers-listItemOfferLogoShop noborder"
src="//cdn.idealo.com/folder/Shop/26/3/26395/s2_shop.gif"
alt="megabad.com"
width="80" height="30"&gt;
</noscript>
</a>
</div>
<a class="productOffers-listItemOfferShopBlockRatingLink" href="https://www.idealo.at/preisvergleich/Shop/26395.html">
<div class="rating-wrapper">
<div class="table">
<div class="table-row">
<div class="table-cell rating-starsContainer">
<div class="rating-stars rating-stars--small">
<div class="rating-starsWrapper-70">
<img class="rating-starsImage rating-stars--default" src="//cdn.idealo.com/ipc/95351d/rwd/img/spacer.png" alt="*">
</div>
</div>
</div>
</div>
</div>
</div>
</a>
<a class="productOffers-listItemOfferRatingstext" href="https://www.idealo.at/preisvergleich/Shop/26395.html">
154 Meinungen
</a>
</div>
<div class="productOffers-listItemOfferCtaHolder large-3 xlarge-4 columns va-middle-xlarge-up " data-offerlist-column="checkoutleadoutbuttons">
<ul class="productOffers-listItemOfferCta">
<li>
<a class="productOffers-listItemOfferCtaLeadout button button--leadout expand" href="/preisvergleich/Relocate/4771931268.html?categoryId=18928&amp;pos=7&amp;price=208.22&amp;productid=2317555&amp;sid=26395&amp;type=offer" data-after="Zum Shop" data-shop-name="megabad.com" rel="nofollow" target="_blank">
<img class="btn-cta-shop" src="//cdn.idealo.com/ipc/95351d/pics/buttons/btn_placeholder.gif" alt="Grohe 19468000 kaufen: g�nstige Wannenarmaturen bei megabad.com">
</a>
</li>
</ul>
</div>
<a class="productOffers-listItemOfferLink" href="/preisvergleich/Relocate/4771931268.html?categoryId=18928&amp;pos=7&amp;price=208.22&amp;productid=2317555&amp;sid=26395&amp;type=offer" data-checkout="false" data-shop-name="megabad.com" rel="nofollow" target="_blank">
</a>
</li>
<li class="productOffers-listItem row row-24" data-tm="{&quot;spr&quot;:&quot;e__&quot;}">
<div class="small-12 xlarge-6 columns productOffers-listItemTitleWrapper" data-offerlist-column="title">
<a class="productOffers-listItemTitle" data-wt-click="{&quot;id&quot;: &quot;offer.title&quot;, &quot;params&quot; : [&quot;&quot;, &quot;8&quot;, &quot;&quot;, &quot;&quot;]}" href="/preisvergleich/Relocate/7685121923.html?categoryId=18928&amp;pos=8&amp;price=209.38&amp;productid=2317555&amp;sid=303954&amp;type=offer" target="_blank" rel="nofollow">
<span class="productOffers-listItemTitleInner">
Grohe Grohtherm 3000 Braus�ether�mo�stat 19468000 Cos�mo�po�li�tan, Unterputz Ther�mo�stat, chrom
</span>
</a>
</div>
<div class="productOffers-listItemOffer small-6 large-4 xlarge-7 columns" data-offerlist-column="price">
<a class="productOffers-listItemOfferPrice" data-wt-click="{&quot;id&quot;: &quot;offer.price&quot;, &quot;params&quot; : [&quot;&quot;, &quot;8&quot;, &quot;&quot;, &quot;&quot;, &quot;new&quot;]}" href="/preisvergleich/Relocate/7685121923.html?categoryId=18928&amp;pos=8&amp;price=209.38&amp;productid=2317555&amp;sid=303954&amp;type=offer" rel="nofollow" target="_blank">
�&nbsp;209,38
</a><br>
<div class="productOffers-listItemOfferShippingDetails hide-for-large-down">
<div class="table-row">
<div class="table-cell productOffers-listItemOfferShippingDetailsLeftBefore">
</div>
<div class="table-cell productOffers-listItemOfferShippingDetailsLeft" title="�&nbsp;225,72 inkl. Versand">
�&nbsp;225,72 inkl. Versand
</div>
<div class="table-cell productOffers-listItemOfferShippingDetailsRight">
<span class="productOffers-listItemOfferShippingDetailsRightItem" title="PayPal">
<a rel="nofollow" target="_blank" href="/preisvergleich/Relocate/7685121923.html?categoryId=18928&amp;pos=8&amp;price=209.38&amp;productid=2317555&amp;sid=303954&amp;type=offer" data-wt-click="{&quot;id&quot;: &quot;leadout.oop.paymenticon&quot;}">
<span>
<img width="45" height="13" class="offerImage" src="//cdn.idealo.com/ipc/95351d/rwd/img/payment-icons/2x/paypal.png" alt="PayPal" title="PayPal">
</span>
</a>
</span>
</div>
</div>
<div class="table-row">
<div class="table-cell productOffers-listItemOfferShippingDetailsLeftBefore">
</div>
<div class="table-cell productOffers-listItemOfferShippingDetailsLeft" title="�&nbsp;226,83 inkl. Versand">
�&nbsp;226,83 inkl. Versand
</div>
<div class="table-cell productOffers-listItemOfferShippingDetailsRight">
<span class="productOffers-listItemOfferShippingDetailsRightItem" title="Visa">
<a rel="nofollow" target="_blank" href="/preisvergleich/Relocate/7685121923.html?categoryId=18928&amp;pos=8&amp;price=209.38&amp;productid=2317555&amp;sid=303954&amp;type=offer" data-wt-click="{&quot;id&quot;: &quot;leadout.oop.paymenticon&quot;}">
<span>
<img width="45" height="13" class="offerImage" src="//cdn.idealo.com/ipc/95351d/rwd/img/payment-icons/2x/visa.png" alt="Visa" title="Visa">
</span>
</a>
</span>
<span class="productOffers-listItemOfferShippingDetailsRightItem" title="MasterCard">
<a rel="nofollow" target="_blank" href="/preisvergleich/Relocate/7685121923.html?categoryId=18928&amp;pos=8&amp;price=209.38&amp;productid=2317555&amp;sid=303954&amp;type=offer" data-wt-click="{&quot;id&quot;: &quot;leadout.oop.paymenticon&quot;}">
<span>
<img width="45" height="13" class="offerImage" src="//cdn.idealo.com/ipc/95351d/rwd/img/payment-icons/2x/mastercard.png" alt="MasterCard" title="MasterCard">
</span>
</a>
</span>
</div>
</div>
<div class="table-row">
<div class="table-cell productOffers-listItemOfferShippingDetailsLeftBefore">
</div>
<div class="table-cell productOffers-listItemOfferShippingDetailsLeft" title="�&nbsp;222,38 inkl. Versand">
�&nbsp;222,38 inkl. Versand
</div>
<div class="table-cell productOffers-listItemOfferShippingDetailsRight">
<span class="productOffers-listItemOfferShippingDetailsRightItem" title="Vorkasse">
<a rel="nofollow" target="_blank" href="/preisvergleich/Relocate/7685121923.html?categoryId=18928&amp;pos=8&amp;price=209.38&amp;productid=2317555&amp;sid=303954&amp;type=offer" data-wt-click="{&quot;id&quot;: &quot;leadout.oop.paymenticon&quot;}">
<span>
Vorkasse
</span>
</a>
</span>
</div>
</div>
<div class="table-row">
<div class="table-cell productOffers-listItemOfferShippingDetailsLeftBefore">
</div>
<div class="table-cell productOffers-listItemOfferShippingDetailsLeft" title="�&nbsp;224,60 inkl. Versand">
�&nbsp;224,60 inkl. Versand
</div>
<div class="table-cell productOffers-listItemOfferShippingDetailsRight">
<span class="productOffers-listItemOfferShippingDetailsRightItem" title="Sofort�berweisung">
<a rel="nofollow" target="_blank" href="/preisvergleich/Relocate/7685121923.html?categoryId=18928&amp;pos=8&amp;price=209.38&amp;productid=2317555&amp;sid=303954&amp;type=offer" data-wt-click="{&quot;id&quot;: &quot;leadout.oop.paymenticon&quot;}">
<span>
<img width="45" height="13" class="offerImage" src="//cdn.idealo.com/ipc/95351d/rwd/img/payment-icons/2x/sofort.png" alt="Sofort�berweisung" title="Sofort�berweisung">
</span>
</a>
</span>
</div>
</div>
</div>
<span class="productOffers-listItemOfferShipping show-for-large-only" data-wt-click="{&quot;id&quot;: &quot;offer.shippingcosts&quot;, &quot;params&quot; : [&quot;&quot;, &quot;8&quot;, &quot;&quot;, &quot;&quot;]}" data-overlay="{
&quot;closeCaption&quot; : &quot;zur�ck&quot;,
&quot;contentLoad&quot; : &quot;/overlay/product/2317555/offer/7685121923/index/7&quot;,
&quot;contentLoadBy&quot; : &quot;ajax&quot;,
&quot;contentPaddingLeft&quot; : &quot;1rem&quot;,
&quot;contentPaddingRight&quot; : &quot;1rem&quot;,
&quot;eventsOn&quot; : &quot;click&quot;,
&quot;titleCaption&quot; : &quot;Angebotsdetails&quot;,
&quot;titleAlign&quot; : &quot;left&quot;,
&quot;titleSize&quot; : &quot;xlarge&quot;,
&quot;triggerOnClose&quot; : &quot;offer-close&quot;,
&quot;triggerOnOpen&quot; : &quot;offer-open&quot;,
&quot;triggerOpenEvent&quot; : &quot;offer_7685121923&quot;
}">
Versandkosten: ab �&nbsp;13,00
</span>
<div class="productOffers-listItemOfferDetailsMobile table hide-for-large-up">
<div class="table-row">
<div class="productOffers-listItemOfferDetails table-cell" data-overlay="{
&quot;closeCaption&quot; : &quot;zur�ck&quot;,
&quot;contentLoad&quot; : &quot;/overlay/product/2317555/offer/7685121923/index/7&quot;,
&quot;contentLoadBy&quot; : &quot;ajax&quot;,
&quot;contentPaddingLeft&quot; : &quot;1rem&quot;,
&quot;contentPaddingRight&quot; : &quot;1rem&quot;,
&quot;eventsOn&quot; : &quot;click&quot;,
&quot;titleCaption&quot; : &quot;Angebotsdetails&quot;,
&quot;titleAlign&quot; : &quot;left&quot;,
&quot;titleSize&quot; : &quot;xlarge&quot;,
&quot;triggerOnClose&quot; : &quot;offer-close&quot;,
&quot;triggerOnOpen&quot; : &quot;offer-open&quot;,
&quot;triggerOpenEvent&quot; : &quot;offer_7685121923&quot;
}">
Details
</div>
<div class="productOffers-listItemOfferDelivery delivery delivery--short icon-delivery table-cell" data-wt-click="{&quot;id&quot;: &quot;offer.delivery&quot;, &quot;params&quot; : [&quot;&quot;, &quot;8&quot;, &quot;&quot;, &quot;&quot;, &quot;new&quot;]}" data-overlay="{
&quot;closeCaption&quot; : &quot;zur�ck&quot;,
&quot;contentLoad&quot; : &quot;/overlay/product/2317555/offer/7685121923/index/7&quot;,
&quot;contentLoadBy&quot; : &quot;ajax&quot;,
&quot;contentPaddingLeft&quot; : &quot;1rem&quot;,
&quot;contentPaddingRight&quot; : &quot;1rem&quot;,
&quot;eventsOn&quot; : &quot;click&quot;,
&quot;titleCaption&quot; : &quot;Angebotsdetails&quot;,
&quot;titleAlign&quot; : &quot;left&quot;,
&quot;titleSize&quot; : &quot;xlarge&quot;,
&quot;triggerOnClose&quot; : &quot;offer-close&quot;,
&quot;triggerOnOpen&quot; : &quot;offer-open&quot;,
&quot;triggerOpenEvent&quot; : &quot;offer_7685121923&quot;
}">
</div>
</div>
</div>
</div>
<div class="hide-for-medium-down large-2 xlarge-4 columns productOffers-listItemOfferDeliveryBlock va-middle-xlarge-up" data-offerlist-column="delivery">
<div class="table-cell" data-overlay="{
&quot;closeCaption&quot; : &quot;zur�ck&quot;,
&quot;contentLoad&quot; : &quot;/overlay/product/2317555/offer/7685121923/index/7&quot;,
&quot;contentLoadBy&quot; : &quot;ajax&quot;,
&quot;contentPaddingLeft&quot; : &quot;1rem&quot;,
&quot;contentPaddingRight&quot; : &quot;1rem&quot;,
&quot;eventsOn&quot; : &quot;click&quot;,
&quot;titleCaption&quot; : &quot;Angebotsdetails&quot;,
&quot;titleAlign&quot; : &quot;left&quot;,
&quot;titleSize&quot; : &quot;xlarge&quot;,
&quot;triggerOnClose&quot; : &quot;offer-close&quot;,
&quot;triggerOnOpen&quot; : &quot;offer-open&quot;,
&quot;triggerOpenEvent&quot; : &quot;offer_7685121923&quot;
}">
<div class="table">
<div class="table-row" data-wt-click="{&quot;id&quot;: &quot;offer.details.layer&quot;, &quot;params&quot; : [&quot;&quot;,&quot;8&quot;,&quot;oop.offerlist.delivery&quot;]}">
<div class="table-cell va-top productOffers-listItemOfferDeliveryIconWrapper">
<span class="productOffers-listItemOfferDelivery delivery delivery--circle short" data-wt-click="{&quot;id&quot;: &quot;offer.delivery&quot;, &quot;params&quot; : [&quot;&quot;, &quot;8&quot;, &quot;&quot;, &quot;&quot;, &quot;new&quot;]}">
</span>
<span class="productOffers-listItemOfferDelivery delivery delivery--short icon-delivery hide-for-xlarge-up" data-wt-click="{&quot;id&quot;: &quot;offer.delivery&quot;, &quot;params&quot; : [&quot;&quot;, &quot;8&quot;, &quot;&quot;, &quot;&quot;, &quot;new&quot;]}">
</span>
</div>
<div class="table-cell">
<p class="productOffers-listItemOfferDeliveryStatus">1-3 Werk�ta�ge</p>
</div>
</div>
</div>
</div>
</div>
<div class="small-6 large-3 xlarge-3 columns xlarge-text-left large-text-center small-text-right productOffers-listItemOfferShopBlock va-middle-xlarge-up" data-offerlist-column="shop">
<div class="productOffers-listItemOfferLogo">
<a class="productOffers-listItemOfferLogoLink" data-checkout="false" data-shop-name="obadis.com - Shop aus H�ckelhoven" href="/preisvergleich/Relocate/7685121923.html?categoryId=18928&amp;pos=8&amp;price=209.38&amp;productid=2317555&amp;sid=303954&amp;type=offer" rel="nofollow" target="_blank">
<img class="productOffers-listItemOfferLogoShop hide" data-wt-click="{&quot;id&quot;: &quot;offer.shoplogo&quot;, &quot;params&quot; : [&quot;&quot;, &quot;8&quot;, &quot;&quot;, &quot;&quot;, &quot;new&quot;]}" src="//cdn.idealo.com/folder/Shop/303/9/303954/s2_shop_160x60.png" data-shop-logo="//cdn.idealo.com/folder/Shop/303/9/303954/s2_shop_160x60.png" data-shop-logo-fallback="//cdn.idealo.com/folder/Shop/303/9/303954/s2_shop.gif" alt="obadis.com - Shop aus H�ckelhoven" width="80" height="30" style="display: inline-block;">
<noscript>
&lt;img class="productOffers-listItemOfferLogoShop noborder"
src="//cdn.idealo.com/folder/Shop/303/9/303954/s2_shop.gif"
alt="obadis.com"
width="80" height="30"&gt;
</noscript>
</a>
</div>
<a class="productOffers-listItemOfferShopBlockRatingLink" href="https://www.idealo.at/preisvergleich/Shop/303954.html">
<div class="rating-wrapper">
<div class="table">
<div class="table-row">
<div class="table-cell rating-starsContainer">
<div class="rating-stars rating-stars--small">
<div class="rating-starsWrapper-90">
<img class="rating-starsImage rating-stars--default" src="//cdn.idealo.com/ipc/95351d/rwd/img/spacer.png" alt="*">
</div>
</div>
</div>
</div>
</div>
</div>
</a>
<a class="productOffers-listItemOfferRatingstext" href="https://www.idealo.at/preisvergleich/Shop/303954.html">
10 Meinungen
</a>
</div>
<div class="productOffers-listItemOfferCtaHolder large-3 xlarge-4 columns va-middle-xlarge-up " data-offerlist-column="checkoutleadoutbuttons">
<ul class="productOffers-listItemOfferCta">
<li>
<a class="productOffers-listItemOfferCtaLeadout button button--leadout expand" href="/preisvergleich/Relocate/7685121923.html?categoryId=18928&amp;pos=8&amp;price=209.38&amp;productid=2317555&amp;sid=303954&amp;type=offer" data-after="Zum Shop" data-shop-name="obadis.com" rel="nofollow" target="_blank">
<img class="btn-cta-shop" src="//cdn.idealo.com/ipc/95351d/pics/buttons/btn_placeholder.gif" alt="Grohe Grohtherm 3000 C Thermostat (19468000) bestellen: preiswerte Wannenarmaturen bei obadis.com">
</a>
</li>
</ul>
</div>
<a class="productOffers-listItemOfferLink" href="/preisvergleich/Relocate/7685121923.html?categoryId=18928&amp;pos=8&amp;price=209.38&amp;productid=2317555&amp;sid=303954&amp;type=offer" data-checkout="false" data-shop-name="obadis.com" rel="nofollow" target="_blank">
</a>
</li>
<li class="productOffers-listItem row row-24" data-tm="{&quot;spr&quot;:&quot;adfc&quot;}">
<div class="small-12 xlarge-6 columns productOffers-listItemTitleWrapper" data-offerlist-column="title">
<a class="productOffers-listItemTitle" data-wt-click="{&quot;id&quot;: &quot;offer.title&quot;, &quot;params&quot; : [&quot;&quot;, &quot;9&quot;, &quot;&quot;, &quot;&quot;]}" href="/preisvergleich/Relocate/7316941702.html?categoryId=18928&amp;pos=9&amp;price=210.13&amp;productid=2317555&amp;sid=4640&amp;type=offer" target="_blank" rel="nofollow">
<span class="productOffers-listItemTitleInner">
GROHE Grohtherm 3000 Cos�mo�po�li�tan Armatur mit 2-We�ge-Um�stel�lung (Wanne oder Dusche mit mehr als 1 Brause) f�r GROHE Rapido T Un�ter�putz-Ther�mo�stat 19468000
</span>
</a>
</div>
<div class="productOffers-listItemOffer small-6 large-4 xlarge-7 columns" data-offerlist-column="price">
<a class="productOffers-listItemOfferPrice" data-wt-click="{&quot;id&quot;: &quot;offer.price&quot;, &quot;params&quot; : [&quot;&quot;, &quot;9&quot;, &quot;&quot;, &quot;&quot;, &quot;new&quot;]}" href="/preisvergleich/Relocate/7316941702.html?categoryId=18928&amp;pos=9&amp;price=210.13&amp;productid=2317555&amp;sid=4640&amp;type=offer" rel="nofollow" target="_blank">
�&nbsp;210,13
</a><br>
<span class="productOffers-listItemOfferShipping show-for-large-up" data-wt-click="{&quot;id&quot;: &quot;offer.shippingcosts&quot;, &quot;params&quot; : [&quot;&quot;, &quot;9&quot;, &quot;&quot;, &quot;&quot;]}" data-overlay="{
&quot;closeCaption&quot; : &quot;zur�ck&quot;,
&quot;contentLoad&quot; : &quot;/overlay/product/2317555/offer/7316941702/index/8&quot;,
&quot;contentLoadBy&quot; : &quot;ajax&quot;,
&quot;contentPaddingLeft&quot; : &quot;1rem&quot;,
&quot;contentPaddingRight&quot; : &quot;1rem&quot;,
&quot;eventsOn&quot; : &quot;click&quot;,
&quot;titleCaption&quot; : &quot;Angebotsdetails&quot;,
&quot;titleAlign&quot; : &quot;left&quot;,
&quot;titleSize&quot; : &quot;xlarge&quot;,
&quot;triggerOnClose&quot; : &quot;offer-close&quot;,
&quot;triggerOnOpen&quot; : &quot;offer-open&quot;,
&quot;triggerOpenEvent&quot; : &quot;offer_7316941702&quot;
}">
Versand- &amp; Zahlungsinformationen
</span>
<div class="productOffers-listItemOfferDetailsMobile table hide-for-large-up">
<div class="table-row">
<div class="productOffers-listItemOfferDetails table-cell" data-overlay="{
&quot;closeCaption&quot; : &quot;zur�ck&quot;,
&quot;contentLoad&quot; : &quot;/overlay/product/2317555/offer/7316941702/index/8&quot;,
&quot;contentLoadBy&quot; : &quot;ajax&quot;,
&quot;contentPaddingLeft&quot; : &quot;1rem&quot;,
&quot;contentPaddingRight&quot; : &quot;1rem&quot;,
&quot;eventsOn&quot; : &quot;click&quot;,
&quot;titleCaption&quot; : &quot;Angebotsdetails&quot;,
&quot;titleAlign&quot; : &quot;left&quot;,
&quot;titleSize&quot; : &quot;xlarge&quot;,
&quot;triggerOnClose&quot; : &quot;offer-close&quot;,
&quot;triggerOnOpen&quot; : &quot;offer-open&quot;,
&quot;triggerOpenEvent&quot; : &quot;offer_7316941702&quot;
}">
Details
</div>
<div class="productOffers-listItemOfferDelivery delivery delivery--long icon-delivery table-cell" data-wt-click="{&quot;id&quot;: &quot;offer.delivery&quot;, &quot;params&quot; : [&quot;&quot;, &quot;9&quot;, &quot;&quot;, &quot;&quot;, &quot;new&quot;]}" data-overlay="{
&quot;closeCaption&quot; : &quot;zur�ck&quot;,
&quot;contentLoad&quot; : &quot;/overlay/product/2317555/offer/7316941702/index/8&quot;,
&quot;contentLoadBy&quot; : &quot;ajax&quot;,
&quot;contentPaddingLeft&quot; : &quot;1rem&quot;,
&quot;contentPaddingRight&quot; : &quot;1rem&quot;,
&quot;eventsOn&quot; : &quot;click&quot;,
&quot;titleCaption&quot; : &quot;Angebotsdetails&quot;,
&quot;titleAlign&quot; : &quot;left&quot;,
&quot;titleSize&quot; : &quot;xlarge&quot;,
&quot;triggerOnClose&quot; : &quot;offer-close&quot;,
&quot;triggerOnOpen&quot; : &quot;offer-open&quot;,
&quot;triggerOpenEvent&quot; : &quot;offer_7316941702&quot;
}">
</div>
</div>
</div>
</div>
<div class="hide-for-medium-down large-2 xlarge-4 columns productOffers-listItemOfferDeliveryBlock va-middle-xlarge-up" data-offerlist-column="delivery">
<div class="table-cell" data-overlay="{
&quot;closeCaption&quot; : &quot;zur�ck&quot;,
&quot;contentLoad&quot; : &quot;/overlay/product/2317555/offer/7316941702/index/8&quot;,
&quot;contentLoadBy&quot; : &quot;ajax&quot;,
&quot;contentPaddingLeft&quot; : &quot;1rem&quot;,
&quot;contentPaddingRight&quot; : &quot;1rem&quot;,
&quot;eventsOn&quot; : &quot;click&quot;,
&quot;titleCaption&quot; : &quot;Angebotsdetails&quot;,
&quot;titleAlign&quot; : &quot;left&quot;,
&quot;titleSize&quot; : &quot;xlarge&quot;,
&quot;triggerOnClose&quot; : &quot;offer-close&quot;,
&quot;triggerOnOpen&quot; : &quot;offer-open&quot;,
&quot;triggerOpenEvent&quot; : &quot;offer_7316941702&quot;
}">
<div class="table">
<div class="table-row" data-wt-click="{&quot;id&quot;: &quot;offer.details.layer&quot;, &quot;params&quot; : [&quot;&quot;,&quot;9&quot;,&quot;oop.offerlist.delivery&quot;]}">
<div class="table-cell va-top productOffers-listItemOfferDeliveryIconWrapper">
<span class="productOffers-listItemOfferDelivery delivery delivery--circle long" data-wt-click="{&quot;id&quot;: &quot;offer.delivery&quot;, &quot;params&quot; : [&quot;&quot;, &quot;9&quot;, &quot;&quot;, &quot;&quot;, &quot;new&quot;]}">
</span>
<span class="productOffers-listItemOfferDelivery delivery delivery--long icon-delivery hide-for-xlarge-up" data-wt-click="{&quot;id&quot;: &quot;offer.delivery&quot;, &quot;params&quot; : [&quot;&quot;, &quot;9&quot;, &quot;&quot;, &quot;&quot;, &quot;new&quot;]}">
</span>
</div>
<div class="table-cell">
<p class="productOffers-listItemOfferDeliveryStatus">Ge�w�hn�lich ver�sand�fer�tig in 1 bis 2 Mo�na�ten.</p>
<div class="productOffers-listItemOfferDeliveryProviderWrapper">
<span class="productOffers-listItemOfferGreyBadge productOffers-listItemOfferDeliveryProvider">DHL</span>
</div>
</div>
</div>
</div>
</div>
</div>
<div class="small-6 large-3 xlarge-3 columns xlarge-text-left large-text-center small-text-right productOffers-listItemOfferShopBlock va-middle-xlarge-up" data-offerlist-column="shop">
<div class="productOffers-listItemOfferLogo">
<a class="productOffers-listItemOfferLogoLink" data-checkout="false" data-shop-name="Amazon - Shop aus M�nchen" href="/preisvergleich/Relocate/7316941702.html?categoryId=18928&amp;pos=9&amp;price=210.13&amp;productid=2317555&amp;sid=4640&amp;type=offer" rel="nofollow" target="_blank">
<img class="productOffers-listItemOfferLogoShop hide" data-wt-click="{&quot;id&quot;: &quot;offer.shoplogo&quot;, &quot;params&quot; : [&quot;&quot;, &quot;9&quot;, &quot;&quot;, &quot;&quot;, &quot;new&quot;]}" src="//cdn.idealo.com/folder/Shop/4/6/4640/s2_shop_160x60.png" data-shop-logo="//cdn.idealo.com/folder/Shop/4/6/4640/s2_shop_160x60.png" data-shop-logo-fallback="//cdn.idealo.com/folder/Shop/4/6/4640/s2_shop.gif" alt="Amazon - Shop aus M�nchen" width="80" height="30" style="display: inline-block;">
<noscript>
&lt;img class="productOffers-listItemOfferLogoShop noborder"
src="//cdn.idealo.com/folder/Shop/4/6/4640/s2_shop.gif"
alt="Amazon"
width="80" height="30"&gt;
</noscript>
</a>
</div>
<a class="productOffers-listItemOfferShopBlockRatingLink" href="https://www.idealo.at/preisvergleich/Shop/4640.html">
<div class="rating-wrapper">
<div class="table">
<div class="table-row">
<div class="table-cell rating-starsContainer">
<div class="rating-stars rating-stars--small">
<div class="rating-starsWrapper-50">
<img class="rating-starsImage rating-stars--default" src="//cdn.idealo.com/ipc/95351d/rwd/img/spacer.png" alt="*">
</div>
</div>
</div>
</div>
</div>
</div>
</a>
<a class="productOffers-listItemOfferRatingstext" href="https://www.idealo.at/preisvergleich/Shop/4640.html">
1.106 Meinungen
</a>
</div>
<div class="productOffers-listItemOfferCtaHolder large-3 xlarge-4 columns va-middle-xlarge-up " data-offerlist-column="checkoutleadoutbuttons">
<ul class="productOffers-listItemOfferCta">
<li>
<a class="productOffers-listItemOfferCtaLeadout button button--leadout expand" href="/preisvergleich/Relocate/7316941702.html?categoryId=18928&amp;pos=9&amp;price=210.13&amp;productid=2317555&amp;sid=4640&amp;type=offer" data-after="Zum Shop" data-shop-name="Amazon" rel="nofollow" target="_blank">
<img class="btn-cta-shop" src="//cdn.idealo.com/ipc/95351d/pics/buttons/btn_placeholder.gif" alt="Grohe 19468 versand: billige Wannenarmaturen bei Amazon">
</a>
</li>
</ul>
</div>
<a class="productOffers-listItemOfferLink" href="/preisvergleich/Relocate/7316941702.html?categoryId=18928&amp;pos=9&amp;price=210.13&amp;productid=2317555&amp;sid=4640&amp;type=offer" data-checkout="false" data-shop-name="Amazon" rel="nofollow" target="_blank">
</a>
</li>
<li class="productOffers-listItem row row-24" data-tm="{&quot;spr&quot;:&quot;dad&quot;}">
<div class="small-12 xlarge-6 columns productOffers-listItemTitleWrapper" data-offerlist-column="title">
<a class="productOffers-listItemTitle" data-wt-click="{&quot;id&quot;: &quot;offer.title&quot;, &quot;params&quot; : [&quot;&quot;, &quot;10&quot;, &quot;&quot;, &quot;&quot;]}" href="/preisvergleich/Relocate/9202484042.html?categoryId=18928&amp;pos=10&amp;price=217.30&amp;productid=2317555&amp;sid=10281&amp;type=offer" target="_blank" rel="nofollow">
<span class="productOffers-listItemTitleInner">
Grohe Grohtherm 3000 Cos�mo�po�li�tan Ther�mo�stat, chrom, mit in�te�grier�ter 2-We�ge-Um�stel�lung (19468000)
</span>
</a>
</div>
<div class="productOffers-listItemOffer small-6 large-4 xlarge-7 columns" data-offerlist-column="price">
<a class="productOffers-listItemOfferPrice" data-wt-click="{&quot;id&quot;: &quot;offer.price&quot;, &quot;params&quot; : [&quot;&quot;, &quot;10&quot;, &quot;&quot;, &quot;&quot;, &quot;new&quot;]}" href="/preisvergleich/Relocate/9202484042.html?categoryId=18928&amp;pos=10&amp;price=217.30&amp;productid=2317555&amp;sid=10281&amp;type=offer" rel="nofollow" target="_blank">
�&nbsp;217,30
</a><br>
<div class="productOffers-listItemOfferShippingDetails hide-for-large-down">
<div class="table-row">
<div class="table-cell productOffers-listItemOfferShippingDetailsLeftBefore">
</div>
<div class="table-cell productOffers-listItemOfferShippingDetailsLeft" title="�&nbsp;233,96 inkl. Versand">
�&nbsp;233,96 inkl. Versand
</div>
<div class="table-cell productOffers-listItemOfferShippingDetailsRight">
<span class="productOffers-listItemOfferShippingDetailsRightItem" title="PayPal">
<a rel="nofollow" target="_blank" href="/preisvergleich/Relocate/9202484042.html?categoryId=18928&amp;pos=10&amp;price=217.30&amp;productid=2317555&amp;sid=10281&amp;type=offer" data-wt-click="{&quot;id&quot;: &quot;leadout.oop.paymenticon&quot;}">
<span>
<img width="45" height="13" class="offerImage" src="//cdn.idealo.com/ipc/95351d/rwd/img/payment-icons/2x/paypal.png" alt="PayPal" title="PayPal">
</span>
</a>
</span>
</div>
</div>
<div class="table-row">
<div class="table-cell productOffers-listItemOfferShippingDetailsLeftBefore">
</div>
<div class="table-cell productOffers-listItemOfferShippingDetailsLeft" title="�&nbsp;233,24 inkl. Versand">
�&nbsp;233,24 inkl. Versand
</div>
<div class="table-cell productOffers-listItemOfferShippingDetailsRight">
<span class="productOffers-listItemOfferShippingDetailsRightItem" title="Visa">
<a rel="nofollow" target="_blank" href="/preisvergleich/Relocate/9202484042.html?categoryId=18928&amp;pos=10&amp;price=217.30&amp;productid=2317555&amp;sid=10281&amp;type=offer" data-wt-click="{&quot;id&quot;: &quot;leadout.oop.paymenticon&quot;}">
<span>
<img width="45" height="13" class="offerImage" src="//cdn.idealo.com/ipc/95351d/rwd/img/payment-icons/2x/visa.png" alt="Visa" title="Visa">
</span>
</a>
</span>
<span class="productOffers-listItemOfferShippingDetailsRightItem" title="MasterCard">
<a rel="nofollow" target="_blank" href="/preisvergleich/Relocate/9202484042.html?categoryId=18928&amp;pos=10&amp;price=217.30&amp;productid=2317555&amp;sid=10281&amp;type=offer" data-wt-click="{&quot;id&quot;: &quot;leadout.oop.paymenticon&quot;}">
<span>
<img width="45" height="13" class="offerImage" src="//cdn.idealo.com/ipc/95351d/rwd/img/payment-icons/2x/mastercard.png" alt="MasterCard" title="MasterCard">
</span>
</a>
</span>
</div>
</div>
<div class="table-row">
<div class="table-cell productOffers-listItemOfferShippingDetailsLeftBefore">
</div>
<div class="table-cell productOffers-listItemOfferShippingDetailsLeft" title="�&nbsp;230,25 inkl. Versand">
�&nbsp;230,25 inkl. Versand
</div>
<div class="table-cell productOffers-listItemOfferShippingDetailsRight">
<span class="productOffers-listItemOfferShippingDetailsRightItem" title="Vorkasse">
<a rel="nofollow" target="_blank" href="/preisvergleich/Relocate/9202484042.html?categoryId=18928&amp;pos=10&amp;price=217.30&amp;productid=2317555&amp;sid=10281&amp;type=offer" data-wt-click="{&quot;id&quot;: &quot;leadout.oop.paymenticon&quot;}">
<span>
Vorkasse
</span>
</a>
</span>
</div>
</div>
</div>
<span class="productOffers-listItemOfferShipping show-for-large-only" data-wt-click="{&quot;id&quot;: &quot;offer.shippingcosts&quot;, &quot;params&quot; : [&quot;&quot;, &quot;10&quot;, &quot;&quot;, &quot;&quot;]}" data-overlay="{
&quot;closeCaption&quot; : &quot;zur�ck&quot;,
&quot;contentLoad&quot; : &quot;/overlay/product/2317555/offer/9202484042/index/9&quot;,
&quot;contentLoadBy&quot; : &quot;ajax&quot;,
&quot;contentPaddingLeft&quot; : &quot;1rem&quot;,
&quot;contentPaddingRight&quot; : &quot;1rem&quot;,
&quot;eventsOn&quot; : &quot;click&quot;,
&quot;titleCaption&quot; : &quot;Angebotsdetails&quot;,
&quot;titleAlign&quot; : &quot;left&quot;,
&quot;titleSize&quot; : &quot;xlarge&quot;,
&quot;triggerOnClose&quot; : &quot;offer-close&quot;,
&quot;triggerOnOpen&quot; : &quot;offer-open&quot;,
&quot;triggerOpenEvent&quot; : &quot;offer_9202484042&quot;
}">
Versandkosten: ab �&nbsp;12,95
</span>
<div class="productOffers-listItemOfferDetailsMobile table hide-for-large-up">
<div class="table-row">
<div class="productOffers-listItemOfferDetails table-cell" data-overlay="{
&quot;closeCaption&quot; : &quot;zur�ck&quot;,
&quot;contentLoad&quot; : &quot;/overlay/product/2317555/offer/9202484042/index/9&quot;,
&quot;contentLoadBy&quot; : &quot;ajax&quot;,
&quot;contentPaddingLeft&quot; : &quot;1rem&quot;,
&quot;contentPaddingRight&quot; : &quot;1rem&quot;,
&quot;eventsOn&quot; : &quot;click&quot;,
&quot;titleCaption&quot; : &quot;Angebotsdetails&quot;,
&quot;titleAlign&quot; : &quot;left&quot;,
&quot;titleSize&quot; : &quot;xlarge&quot;,
&quot;triggerOnClose&quot; : &quot;offer-close&quot;,
&quot;triggerOnOpen&quot; : &quot;offer-open&quot;,
&quot;triggerOpenEvent&quot; : &quot;offer_9202484042&quot;
}">
Details
</div>
<div class="productOffers-listItemOfferDelivery delivery delivery--short icon-delivery table-cell" data-wt-click="{&quot;id&quot;: &quot;offer.delivery&quot;, &quot;params&quot; : [&quot;&quot;, &quot;10&quot;, &quot;&quot;, &quot;&quot;, &quot;new&quot;]}" data-overlay="{
&quot;closeCaption&quot; : &quot;zur�ck&quot;,
&quot;contentLoad&quot; : &quot;/overlay/product/2317555/offer/9202484042/index/9&quot;,
&quot;contentLoadBy&quot; : &quot;ajax&quot;,
&quot;contentPaddingLeft&quot; : &quot;1rem&quot;,
&quot;contentPaddingRight&quot; : &quot;1rem&quot;,
&quot;eventsOn&quot; : &quot;click&quot;,
&quot;titleCaption&quot; : &quot;Angebotsdetails&quot;,
&quot;titleAlign&quot; : &quot;left&quot;,
&quot;titleSize&quot; : &quot;xlarge&quot;,
&quot;triggerOnClose&quot; : &quot;offer-close&quot;,
&quot;triggerOnOpen&quot; : &quot;offer-open&quot;,
&quot;triggerOpenEvent&quot; : &quot;offer_9202484042&quot;
}">
</div>
</div>
</div>
</div>
<div class="hide-for-medium-down large-2 xlarge-4 columns productOffers-listItemOfferDeliveryBlock va-middle-xlarge-up" data-offerlist-column="delivery">
<div class="table-cell" data-overlay="{
&quot;closeCaption&quot; : &quot;zur�ck&quot;,
&quot;contentLoad&quot; : &quot;/overlay/product/2317555/offer/9202484042/index/9&quot;,
&quot;contentLoadBy&quot; : &quot;ajax&quot;,
&quot;contentPaddingLeft&quot; : &quot;1rem&quot;,
&quot;contentPaddingRight&quot; : &quot;1rem&quot;,
&quot;eventsOn&quot; : &quot;click&quot;,
&quot;titleCaption&quot; : &quot;Angebotsdetails&quot;,
&quot;titleAlign&quot; : &quot;left&quot;,
&quot;titleSize&quot; : &quot;xlarge&quot;,
&quot;triggerOnClose&quot; : &quot;offer-close&quot;,
&quot;triggerOnOpen&quot; : &quot;offer-open&quot;,
&quot;triggerOpenEvent&quot; : &quot;offer_9202484042&quot;
}">
<div class="table">
<div class="table-row" data-wt-click="{&quot;id&quot;: &quot;offer.details.layer&quot;, &quot;params&quot; : [&quot;&quot;,&quot;10&quot;,&quot;oop.offerlist.delivery&quot;]}">
<div class="table-cell va-top productOffers-listItemOfferDeliveryIconWrapper">
<span class="productOffers-listItemOfferDelivery delivery delivery--circle short" data-wt-click="{&quot;id&quot;: &quot;offer.delivery&quot;, &quot;params&quot; : [&quot;&quot;, &quot;10&quot;, &quot;&quot;, &quot;&quot;, &quot;new&quot;]}">
</span>
<span class="productOffers-listItemOfferDelivery delivery delivery--short icon-delivery hide-for-xlarge-up" data-wt-click="{&quot;id&quot;: &quot;offer.delivery&quot;, &quot;params&quot; : [&quot;&quot;, &quot;10&quot;, &quot;&quot;, &quot;&quot;, &quot;new&quot;]}">
</span>
</div>
<div class="table-cell">
<p class="productOffers-listItemOfferDeliveryStatus">so�fort, ist auf Lager. Lie�fer�zeit: 1-2 Werk�ta�ge</p>
<div class="productOffers-listItemOfferDeliveryProviderWrapper">
<span class="productOffers-listItemOfferGreyBadge productOffers-listItemOfferDeliveryProvider">UPS</span>
<span class="productOffers-listItemOfferGreyBadge productOffers-listItemOfferDeliveryProvider">Spedition</span>
</div>
</div>
</div>
</div>
</div>
</div>
<div class="small-6 large-3 xlarge-3 columns xlarge-text-left large-text-center small-text-right productOffers-listItemOfferShopBlock va-middle-xlarge-up" data-offerlist-column="shop">
<div class="productOffers-listItemOfferLogo">
<a class="productOffers-listItemOfferLogoLink" data-checkout="false" data-shop-name="elektroshopwagner.de - Shop aus Nidda" href="/preisvergleich/Relocate/9202484042.html?categoryId=18928&amp;pos=10&amp;price=217.30&amp;productid=2317555&amp;sid=10281&amp;type=offer" rel="nofollow" target="_blank">
<img class="productOffers-listItemOfferLogoShop hide" data-wt-click="{&quot;id&quot;: &quot;offer.shoplogo&quot;, &quot;params&quot; : [&quot;&quot;, &quot;10&quot;, &quot;&quot;, &quot;&quot;, &quot;new&quot;]}" src="//cdn.idealo.com/folder/Shop/10/2/10281/s2_shop_160x60.png" data-shop-logo="//cdn.idealo.com/folder/Shop/10/2/10281/s2_shop_160x60.png" data-shop-logo-fallback="//cdn.idealo.com/folder/Shop/10/2/10281/s2_shop.gif" alt="elektroshopwagner.de - Shop aus Nidda" width="80" height="30" style="display: inline-block;">
<noscript>
&lt;img class="productOffers-listItemOfferLogoShop noborder"
src="//cdn.idealo.com/folder/Shop/10/2/10281/s2_shop.gif"
alt="elektroshopwagner.de"
width="80" height="30"&gt;
</noscript>
</a>
</div>
<a class="productOffers-listItemOfferShopBlockRatingLink" href="https://www.idealo.at/preisvergleich/Shop/10281.html">
<div class="rating-wrapper">
<div class="table">
<div class="table-row">
<div class="table-cell rating-starsContainer">
<div class="rating-stars rating-stars--small">
<div class="rating-starsWrapper-100">
<img class="rating-starsImage rating-stars--default" src="//cdn.idealo.com/ipc/95351d/rwd/img/spacer.png" alt="*">
</div>
</div>
</div>
</div>
</div>
</div>
</a>
<a class="productOffers-listItemOfferRatingstext" href="https://www.idealo.at/preisvergleich/Shop/10281.html">
17.462 Meinungen
</a>
</div>
<div class="productOffers-listItemOfferCtaHolder large-3 xlarge-4 columns va-middle-xlarge-up " data-offerlist-column="checkoutleadoutbuttons">
<ul class="productOffers-listItemOfferCta">
<li>
<a class="productOffers-listItemOfferCtaLeadout button button--leadout expand" href="/preisvergleich/Relocate/9202484042.html?categoryId=18928&amp;pos=10&amp;price=217.30&amp;productid=2317555&amp;sid=10281&amp;type=offer" data-after="Zum Shop" data-shop-name="elektroshopwagner.de" rel="nofollow" target="_blank">
<img class="btn-cta-shop" src="//cdn.idealo.com/ipc/95351d/pics/buttons/btn_placeholder.gif" alt="Grohe Grohtherm 3000 Wannenbatterie kaufen: g�nstige Wannenarmaturen bei elektroshopwagner.de">
</a>
</li>
</ul>
</div>
<a class="productOffers-listItemOfferLink" href="/preisvergleich/Relocate/9202484042.html?categoryId=18928&amp;pos=10&amp;price=217.30&amp;productid=2317555&amp;sid=10281&amp;type=offer" data-checkout="false" data-shop-name="elektroshopwagner.de" rel="nofollow" target="_blank">
</a>
</li>
<li class="productOffers-listItem row row-24" data-tm="{&quot;spr&quot;:&quot;ead&quot;}">
<div class="small-12 xlarge-6 columns productOffers-listItemTitleWrapper" data-offerlist-column="title">
<a class="productOffers-listItemTitle" data-wt-click="{&quot;id&quot;: &quot;offer.title&quot;, &quot;params&quot; : [&quot;&quot;, &quot;11&quot;, &quot;&quot;, &quot;&quot;]}" href="/preisvergleich/Relocate/4914452745.html?categoryId=18928&amp;pos=11&amp;price=219.00&amp;productid=2317555&amp;sid=287080&amp;type=offer" target="_blank" rel="nofollow">
<span class="productOffers-listItemTitleInner">
Ther�mo�statar�ma�tur Grohe Grohtherm 3000 C mit in�te�grier�ter 2-We�ge-Um�stel�lung f�r Wanne oder Dusche mit mehr als einer Brause 19468000 chrom
</span>
</a>
</div>
<div class="productOffers-listItemOffer small-6 large-4 xlarge-7 columns" data-offerlist-column="price">
<a class="productOffers-listItemOfferPrice" data-wt-click="{&quot;id&quot;: &quot;offer.price&quot;, &quot;params&quot; : [&quot;&quot;, &quot;11&quot;, &quot;&quot;, &quot;&quot;, &quot;new&quot;]}" href="/preisvergleich/Relocate/4914452745.html?categoryId=18928&amp;pos=11&amp;price=219.00&amp;productid=2317555&amp;sid=287080&amp;type=offer" rel="nofollow" target="_blank">
�&nbsp;219,00
</a><br>
<div class="productOffers-listItemOfferShippingDetails hide-for-large-down">
<div class="table-row">
<div class="table-cell productOffers-listItemOfferShippingDetailsLeftBefore">
</div>
<div class="table-cell productOffers-listItemOfferShippingDetailsLeft" title="�&nbsp;223,95 inkl. Versand">
�&nbsp;223,95 inkl. Versand
</div>
<div class="table-cell productOffers-listItemOfferShippingDetailsRight">
<span class="productOffers-listItemOfferShippingDetailsRightItem" title="PayPal">
<a rel="nofollow" target="_blank" href="/preisvergleich/Relocate/4914452745.html?categoryId=18928&amp;pos=11&amp;price=219.00&amp;productid=2317555&amp;sid=287080&amp;type=offer" data-wt-click="{&quot;id&quot;: &quot;leadout.oop.paymenticon&quot;}">
<span>
<img width="45" height="13" class="offerImage" src="//cdn.idealo.com/ipc/95351d/rwd/img/payment-icons/2x/paypal.png" alt="PayPal" title="PayPal">
</span>
</a>
</span>
<span class="productOffers-listItemOfferShippingDetailsRightItem" title="Visa">
<a rel="nofollow" target="_blank" href="/preisvergleich/Relocate/4914452745.html?categoryId=18928&amp;pos=11&amp;price=219.00&amp;productid=2317555&amp;sid=287080&amp;type=offer" data-wt-click="{&quot;id&quot;: &quot;leadout.oop.paymenticon&quot;}">
<span>
<img width="45" height="13" class="offerImage" src="//cdn.idealo.com/ipc/95351d/rwd/img/payment-icons/2x/visa.png" alt="Visa" title="Visa">
</span>
</a>
</span>
<span class="productOffers-listItemOfferShippingDetailsRightItem" title="MasterCard">
<a rel="nofollow" target="_blank" href="/preisvergleich/Relocate/4914452745.html?categoryId=18928&amp;pos=11&amp;price=219.00&amp;productid=2317555&amp;sid=287080&amp;type=offer" data-wt-click="{&quot;id&quot;: &quot;leadout.oop.paymenticon&quot;}">
<span>
<img width="45" height="13" class="offerImage" src="//cdn.idealo.com/ipc/95351d/rwd/img/payment-icons/2x/mastercard.png" alt="MasterCard" title="MasterCard">
</span>
</a>
</span>
<span class="productOffers-listItemOfferShippingDetailsRightItem" title="Vorkasse">
<a rel="nofollow" target="_blank" href="/preisvergleich/Relocate/4914452745.html?categoryId=18928&amp;pos=11&amp;price=219.00&amp;productid=2317555&amp;sid=287080&amp;type=offer" data-wt-click="{&quot;id&quot;: &quot;leadout.oop.paymenticon&quot;}">
<span>
Vorkasse
</span>
</a>
</span>
<span class="productOffers-listItemOfferShippingDetailsRightItem" title="Sofort�berweisung">
<a rel="nofollow" target="_blank" href="/preisvergleich/Relocate/4914452745.html?categoryId=18928&amp;pos=11&amp;price=219.00&amp;productid=2317555&amp;sid=287080&amp;type=offer" data-wt-click="{&quot;id&quot;: &quot;leadout.oop.paymenticon&quot;}">
<span>
<img width="45" height="13" class="offerImage" src="//cdn.idealo.com/ipc/95351d/rwd/img/payment-icons/2x/sofort.png" alt="Sofort�berweisung" title="Sofort�berweisung">
</span>
</a>
</span>
</div>
</div>
</div>
<span class="productOffers-listItemOfferShipping show-for-large-only" data-wt-click="{&quot;id&quot;: &quot;offer.shippingcosts&quot;, &quot;params&quot; : [&quot;&quot;, &quot;11&quot;, &quot;&quot;, &quot;&quot;]}" data-overlay="{
&quot;closeCaption&quot; : &quot;zur�ck&quot;,
&quot;contentLoad&quot; : &quot;/overlay/product/2317555/offer/4914452745/index/10&quot;,
&quot;contentLoadBy&quot; : &quot;ajax&quot;,
&quot;contentPaddingLeft&quot; : &quot;1rem&quot;,
&quot;contentPaddingRight&quot; : &quot;1rem&quot;,
&quot;eventsOn&quot; : &quot;click&quot;,
&quot;titleCaption&quot; : &quot;Angebotsdetails&quot;,
&quot;titleAlign&quot; : &quot;left&quot;,
&quot;titleSize&quot; : &quot;xlarge&quot;,
&quot;triggerOnClose&quot; : &quot;offer-close&quot;,
&quot;triggerOnOpen&quot; : &quot;offer-open&quot;,
&quot;triggerOpenEvent&quot; : &quot;offer_4914452745&quot;
}">
Versandkosten: ab �&nbsp;4,95
</span>
<div class="productOffers-listItemOfferDetailsMobile table hide-for-large-up">
<div class="table-row">
<div class="productOffers-listItemOfferDetails table-cell" data-overlay="{
&quot;closeCaption&quot; : &quot;zur�ck&quot;,
&quot;contentLoad&quot; : &quot;/overlay/product/2317555/offer/4914452745/index/10&quot;,
&quot;contentLoadBy&quot; : &quot;ajax&quot;,
&quot;contentPaddingLeft&quot; : &quot;1rem&quot;,
&quot;contentPaddingRight&quot; : &quot;1rem&quot;,
&quot;eventsOn&quot; : &quot;click&quot;,
&quot;titleCaption&quot; : &quot;Angebotsdetails&quot;,
&quot;titleAlign&quot; : &quot;left&quot;,
&quot;titleSize&quot; : &quot;xlarge&quot;,
&quot;triggerOnClose&quot; : &quot;offer-close&quot;,
&quot;triggerOnOpen&quot; : &quot;offer-open&quot;,
&quot;triggerOpenEvent&quot; : &quot;offer_4914452745&quot;
}">
Details
</div>
<div class="productOffers-listItemOfferDelivery delivery delivery--medium icon-delivery table-cell" data-wt-click="{&quot;id&quot;: &quot;offer.delivery&quot;, &quot;params&quot; : [&quot;&quot;, &quot;11&quot;, &quot;&quot;, &quot;&quot;, &quot;new&quot;]}" data-overlay="{
&quot;closeCaption&quot; : &quot;zur�ck&quot;,
&quot;contentLoad&quot; : &quot;/overlay/product/2317555/offer/4914452745/index/10&quot;,
&quot;contentLoadBy&quot; : &quot;ajax&quot;,
&quot;contentPaddingLeft&quot; : &quot;1rem&quot;,
&quot;contentPaddingRight&quot; : &quot;1rem&quot;,
&quot;eventsOn&quot; : &quot;click&quot;,
&quot;titleCaption&quot; : &quot;Angebotsdetails&quot;,
&quot;titleAlign&quot; : &quot;left&quot;,
&quot;titleSize&quot; : &quot;xlarge&quot;,
&quot;triggerOnClose&quot; : &quot;offer-close&quot;,
&quot;triggerOnOpen&quot; : &quot;offer-open&quot;,
&quot;triggerOpenEvent&quot; : &quot;offer_4914452745&quot;
}">
</div>
</div>
</div>
</div>
<div class="hide-for-medium-down large-2 xlarge-4 columns productOffers-listItemOfferDeliveryBlock va-middle-xlarge-up" data-offerlist-column="delivery">
<div class="table-cell" data-overlay="{
&quot;closeCaption&quot; : &quot;zur�ck&quot;,
&quot;contentLoad&quot; : &quot;/overlay/product/2317555/offer/4914452745/index/10&quot;,
&quot;contentLoadBy&quot; : &quot;ajax&quot;,
&quot;contentPaddingLeft&quot; : &quot;1rem&quot;,
&quot;contentPaddingRight&quot; : &quot;1rem&quot;,
&quot;eventsOn&quot; : &quot;click&quot;,
&quot;titleCaption&quot; : &quot;Angebotsdetails&quot;,
&quot;titleAlign&quot; : &quot;left&quot;,
&quot;titleSize&quot; : &quot;xlarge&quot;,
&quot;triggerOnClose&quot; : &quot;offer-close&quot;,
&quot;triggerOnOpen&quot; : &quot;offer-open&quot;,
&quot;triggerOpenEvent&quot; : &quot;offer_4914452745&quot;
}">
<div class="table">
<div class="table-row" data-wt-click="{&quot;id&quot;: &quot;offer.details.layer&quot;, &quot;params&quot; : [&quot;&quot;,&quot;11&quot;,&quot;oop.offerlist.delivery&quot;]}">
<div class="table-cell va-top productOffers-listItemOfferDeliveryIconWrapper">
<span class="productOffers-listItemOfferDelivery delivery delivery--circle medium" data-wt-click="{&quot;id&quot;: &quot;offer.delivery&quot;, &quot;params&quot; : [&quot;&quot;, &quot;11&quot;, &quot;&quot;, &quot;&quot;, &quot;new&quot;]}">
</span>
<span class="productOffers-listItemOfferDelivery delivery delivery--medium icon-delivery hide-for-xlarge-up" data-wt-click="{&quot;id&quot;: &quot;offer.delivery&quot;, &quot;params&quot; : [&quot;&quot;, &quot;11&quot;, &quot;&quot;, &quot;&quot;, &quot;new&quot;]}">
</span>
</div>
<div class="table-cell">
<p class="productOffers-listItemOfferDeliveryStatus">ca. 5 Werk�ta�ge</p>
</div>
</div>
</div>
</div>
</div>
<div class="small-6 large-3 xlarge-3 columns xlarge-text-left large-text-center small-text-right productOffers-listItemOfferShopBlock va-middle-xlarge-up" data-offerlist-column="shop">
<div class="productOffers-listItemOfferLogo">
<a class="productOffers-listItemOfferLogoLink" data-checkout="false" data-shop-name="hornbach.at - Shop aus Wiener Neudorf" href="/preisvergleich/Relocate/4914452745.html?categoryId=18928&amp;pos=11&amp;price=219.00&amp;productid=2317555&amp;sid=287080&amp;type=offer" rel="nofollow" target="_blank">
<img class="productOffers-listItemOfferLogoShop hide" data-wt-click="{&quot;id&quot;: &quot;offer.shoplogo&quot;, &quot;params&quot; : [&quot;&quot;, &quot;11&quot;, &quot;&quot;, &quot;&quot;, &quot;new&quot;]}" src="//cdn.idealo.com/folder/Shop/287/0/287080/s2_shop_160x60.png" data-shop-logo="//cdn.idealo.com/folder/Shop/287/0/287080/s2_shop_160x60.png" data-shop-logo-fallback="//cdn.idealo.com/folder/Shop/287/0/287080/s2_shop.gif" alt="hornbach.at - Shop aus Wiener Neudorf" width="80" height="30" style="display: inline-block;">
<noscript>
&lt;img class="productOffers-listItemOfferLogoShop noborder"
src="//cdn.idealo.com/folder/Shop/287/0/287080/s2_shop.gif"
alt="hornbach.at"
width="80" height="30"&gt;
</noscript>
</a>
</div>
<a class="productOffers-listItemOfferShopBlockRatingLink" href="https://www.idealo.at/preisvergleich/Shop/287080.html">
<div class="rating-wrapper">
<div class="table">
<div class="table-row">
<div class="table-cell rating-starsContainer">
<div class="rating-stars rating-stars--small">
<div class="rating-starsWrapper-50">
<img class="rating-starsImage rating-stars--default" src="//cdn.idealo.com/ipc/95351d/rwd/img/spacer.png" alt="*">
</div>
</div>
</div>
</div>
</div>
</div>
</a>
<a class="productOffers-listItemOfferRatingstext" href="https://www.idealo.at/preisvergleich/Shop/287080.html">
6 Meinungen
</a>
</div>
<div class="productOffers-listItemOfferCtaHolder large-3 xlarge-4 columns va-middle-xlarge-up " data-offerlist-column="checkoutleadoutbuttons">
<ul class="productOffers-listItemOfferCta">
<li>
<a class="productOffers-listItemOfferCtaLeadout button button--leadout expand" href="/preisvergleich/Relocate/4914452745.html?categoryId=18928&amp;pos=11&amp;price=219.00&amp;productid=2317555&amp;sid=287080&amp;type=offer" data-after="Zum Shop" data-shop-name="hornbach.at" rel="nofollow" target="_blank">
<img class="btn-cta-shop" src="//cdn.idealo.com/ipc/95351d/pics/buttons/btn_placeholder.gif" alt="Grohe Grohtherm 3000 Cosmopolitan 19468 bestellen: preiswerte Wannenarmaturen bei hornbach.at">
</a>
</li>
</ul>
</div>
<a class="productOffers-listItemOfferLink" href="/preisvergleich/Relocate/4914452745.html?categoryId=18928&amp;pos=11&amp;price=219.00&amp;productid=2317555&amp;sid=287080&amp;type=offer" data-checkout="false" data-shop-name="hornbach.at" rel="nofollow" target="_blank">
</a>
</li>
<li class="productOffers-listItem row row-24" data-tm="{&quot;spr&quot;:&quot;e__&quot;}">
<div class="small-12 xlarge-6 columns productOffers-listItemTitleWrapper" data-offerlist-column="title">
<a class="productOffers-listItemTitle" data-wt-click="{&quot;id&quot;: &quot;offer.title&quot;, &quot;params&quot; : [&quot;&quot;, &quot;12&quot;, &quot;&quot;, &quot;&quot;]}" href="/preisvergleich/Relocate/1827033891.html?categoryId=18928&amp;pos=12&amp;price=219.83&amp;productid=2317555&amp;sid=24268&amp;type=offer" target="_blank" rel="nofollow">
<span class="productOffers-listItemTitleInner">
Grohe Grohtherm 3000 C - Thermostat mit in�te�grier�ter 2-We�ge-Um�stel�lung chrom
</span>
</a>
</div>
<div class="productOffers-listItemOffer small-6 large-4 xlarge-7 columns" data-offerlist-column="price">
<a class="productOffers-listItemOfferPrice" data-wt-click="{&quot;id&quot;: &quot;offer.price&quot;, &quot;params&quot; : [&quot;&quot;, &quot;12&quot;, &quot;&quot;, &quot;&quot;, &quot;new&quot;]}" href="/preisvergleich/Relocate/1827033891.html?categoryId=18928&amp;pos=12&amp;price=219.83&amp;productid=2317555&amp;sid=24268&amp;type=offer" rel="nofollow" target="_blank">
�&nbsp;219,83
</a><br>
<span class="productOffers-listItemOfferShipping show-for-large-up" data-wt-click="{&quot;id&quot;: &quot;offer.shippingcosts&quot;, &quot;params&quot; : [&quot;&quot;, &quot;12&quot;, &quot;&quot;, &quot;&quot;]}" data-overlay="{
&quot;closeCaption&quot; : &quot;zur�ck&quot;,
&quot;contentLoad&quot; : &quot;/overlay/product/2317555/offer/1827033891/index/11&quot;,
&quot;contentLoadBy&quot; : &quot;ajax&quot;,
&quot;contentPaddingLeft&quot; : &quot;1rem&quot;,
&quot;contentPaddingRight&quot; : &quot;1rem&quot;,
&quot;eventsOn&quot; : &quot;click&quot;,
&quot;titleCaption&quot; : &quot;Angebotsdetails&quot;,
&quot;titleAlign&quot; : &quot;left&quot;,
&quot;titleSize&quot; : &quot;xlarge&quot;,
&quot;triggerOnClose&quot; : &quot;offer-close&quot;,
&quot;triggerOnOpen&quot; : &quot;offer-open&quot;,
&quot;triggerOpenEvent&quot; : &quot;offer_1827033891&quot;
}">
Versand- &amp; Zahlungsinformationen
</span>
<div class="productOffers-listItemOfferDetailsMobile table hide-for-large-up">
<div class="table-row">
<div class="productOffers-listItemOfferDetails table-cell" data-overlay="{
&quot;closeCaption&quot; : &quot;zur�ck&quot;,
&quot;contentLoad&quot; : &quot;/overlay/product/2317555/offer/1827033891/index/11&quot;,
&quot;contentLoadBy&quot; : &quot;ajax&quot;,
&quot;contentPaddingLeft&quot; : &quot;1rem&quot;,
&quot;contentPaddingRight&quot; : &quot;1rem&quot;,
&quot;eventsOn&quot; : &quot;click&quot;,
&quot;titleCaption&quot; : &quot;Angebotsdetails&quot;,
&quot;titleAlign&quot; : &quot;left&quot;,
&quot;titleSize&quot; : &quot;xlarge&quot;,
&quot;triggerOnClose&quot; : &quot;offer-close&quot;,
&quot;triggerOnOpen&quot; : &quot;offer-open&quot;,
&quot;triggerOpenEvent&quot; : &quot;offer_1827033891&quot;
}">
Details
</div>
<div class="productOffers-listItemOfferDelivery delivery delivery--short icon-delivery table-cell" data-wt-click="{&quot;id&quot;: &quot;offer.delivery&quot;, &quot;params&quot; : [&quot;&quot;, &quot;12&quot;, &quot;&quot;, &quot;&quot;, &quot;new&quot;]}" data-overlay="{
&quot;closeCaption&quot; : &quot;zur�ck&quot;,
&quot;contentLoad&quot; : &quot;/overlay/product/2317555/offer/1827033891/index/11&quot;,
&quot;contentLoadBy&quot; : &quot;ajax&quot;,
&quot;contentPaddingLeft&quot; : &quot;1rem&quot;,
&quot;contentPaddingRight&quot; : &quot;1rem&quot;,
&quot;eventsOn&quot; : &quot;click&quot;,
&quot;titleCaption&quot; : &quot;Angebotsdetails&quot;,
&quot;titleAlign&quot; : &quot;left&quot;,
&quot;titleSize&quot; : &quot;xlarge&quot;,
&quot;triggerOnClose&quot; : &quot;offer-close&quot;,
&quot;triggerOnOpen&quot; : &quot;offer-open&quot;,
&quot;triggerOpenEvent&quot; : &quot;offer_1827033891&quot;
}">
</div>
</div>
</div>
</div>
<div class="hide-for-medium-down large-2 xlarge-4 columns productOffers-listItemOfferDeliveryBlock va-middle-xlarge-up" data-offerlist-column="delivery">
<div class="table-cell" data-overlay="{
&quot;closeCaption&quot; : &quot;zur�ck&quot;,
&quot;contentLoad&quot; : &quot;/overlay/product/2317555/offer/1827033891/index/11&quot;,
&quot;contentLoadBy&quot; : &quot;ajax&quot;,
&quot;contentPaddingLeft&quot; : &quot;1rem&quot;,
&quot;contentPaddingRight&quot; : &quot;1rem&quot;,
&quot;eventsOn&quot; : &quot;click&quot;,
&quot;titleCaption&quot; : &quot;Angebotsdetails&quot;,
&quot;titleAlign&quot; : &quot;left&quot;,
&quot;titleSize&quot; : &quot;xlarge&quot;,
&quot;triggerOnClose&quot; : &quot;offer-close&quot;,
&quot;triggerOnOpen&quot; : &quot;offer-open&quot;,
&quot;triggerOpenEvent&quot; : &quot;offer_1827033891&quot;
}">
<div class="table">
<div class="table-row" data-wt-click="{&quot;id&quot;: &quot;offer.details.layer&quot;, &quot;params&quot; : [&quot;&quot;,&quot;12&quot;,&quot;oop.offerlist.delivery&quot;]}">
<div class="table-cell va-top productOffers-listItemOfferDeliveryIconWrapper">
<span class="productOffers-listItemOfferDelivery delivery delivery--circle short" data-wt-click="{&quot;id&quot;: &quot;offer.delivery&quot;, &quot;params&quot; : [&quot;&quot;, &quot;12&quot;, &quot;&quot;, &quot;&quot;, &quot;new&quot;]}">
</span>
<span class="productOffers-listItemOfferDelivery delivery delivery--short icon-delivery hide-for-xlarge-up" data-wt-click="{&quot;id&quot;: &quot;offer.delivery&quot;, &quot;params&quot; : [&quot;&quot;, &quot;12&quot;, &quot;&quot;, &quot;&quot;, &quot;new&quot;]}">
</span>
</div>
<div class="table-cell">
<p class="productOffers-listItemOfferDeliveryStatus">ca. 1-3 Tage</p>
<div class="productOffers-listItemOfferDeliveryProviderWrapper">
<span class="productOffers-listItemOfferGreyBadge productOffers-listItemOfferDeliveryProvider">DHL</span>
</div>
</div>
</div>
</div>
</div>
</div>
<div class="small-6 large-3 xlarge-3 columns xlarge-text-left large-text-center small-text-right productOffers-listItemOfferShopBlock va-middle-xlarge-up" data-offerlist-column="shop">
<div class="productOffers-listItemOfferLogo">
<a class="productOffers-listItemOfferLogoLink" data-checkout="false" data-shop-name="xtwostore.de - Shop aus Hungen" href="/preisvergleich/Relocate/1827033891.html?categoryId=18928&amp;pos=12&amp;price=219.83&amp;productid=2317555&amp;sid=24268&amp;type=offer" rel="nofollow" target="_blank">
<img class="productOffers-listItemOfferLogoShop hide" data-wt-click="{&quot;id&quot;: &quot;offer.shoplogo&quot;, &quot;params&quot; : [&quot;&quot;, &quot;12&quot;, &quot;&quot;, &quot;&quot;, &quot;new&quot;]}" src="//cdn.idealo.com/folder/Shop/24/2/24268/s2_shop_160x60.png" data-shop-logo="//cdn.idealo.com/folder/Shop/24/2/24268/s2_shop_160x60.png" data-shop-logo-fallback="//cdn.idealo.com/folder/Shop/24/2/24268/s2_shop.gif" alt="xtwostore.de - Shop aus Hungen" width="80" height="30" style="display: inline-block;">
<noscript>
&lt;img class="productOffers-listItemOfferLogoShop noborder"
src="//cdn.idealo.com/folder/Shop/24/2/24268/s2_shop.gif"
alt="xtwostore.de"
width="80" height="30"&gt;
</noscript>
</a>
</div>
<a class="productOffers-listItemOfferShopBlockRatingLink" href="https://www.idealo.at/preisvergleich/Shop/24268.html">
<div class="rating-wrapper">
<div class="table">
<div class="table-row">
<div class="table-cell rating-starsContainer">
<div class="rating-stars rating-stars--small">
<div class="rating-starsWrapper-90">
<img class="rating-starsImage rating-stars--default" src="//cdn.idealo.com/ipc/95351d/rwd/img/spacer.png" alt="*">
</div>
</div>
</div>
</div>
</div>
</div>
</a>
<a class="productOffers-listItemOfferRatingstext" href="https://www.idealo.at/preisvergleich/Shop/24268.html">
497 Meinungen
</a>
</div>
<div class="productOffers-listItemOfferCtaHolder large-3 xlarge-4 columns va-middle-xlarge-up " data-offerlist-column="checkoutleadoutbuttons">
<ul class="productOffers-listItemOfferCta">
<li>
<a class="productOffers-listItemOfferCtaLeadout button button--leadout expand" href="/preisvergleich/Relocate/1827033891.html?categoryId=18928&amp;pos=12&amp;price=219.83&amp;productid=2317555&amp;sid=24268&amp;type=offer" data-after="Zum Shop" data-shop-name="xtwostore.de" rel="nofollow" target="_blank">
<img class="btn-cta-shop" src="//cdn.idealo.com/ipc/95351d/pics/buttons/btn_placeholder.gif" alt="Grohe Grohtherm 3000 Cosmopolitan Thermostat 19468 versand: billige Wannenarmaturen bei xtwostore.de">
</a>
</li>
</ul>
</div>
<a class="productOffers-listItemOfferLink" href="/preisvergleich/Relocate/1827033891.html?categoryId=18928&amp;pos=12&amp;price=219.83&amp;productid=2317555&amp;sid=24268&amp;type=offer" data-checkout="false" data-shop-name="xtwostore.de" rel="nofollow" target="_blank">
</a>
</li>
<li class="productOffers-listItem row row-24" data-tm="{&quot;spr&quot;:&quot;bfd&quot;}">
<div class="small-12 xlarge-6 columns productOffers-listItemTitleWrapper" data-offerlist-column="title">
<a class="productOffers-listItemTitle" data-wt-click="{&quot;id&quot;: &quot;offer.title&quot;, &quot;params&quot; : [&quot;&quot;, &quot;13&quot;, &quot;&quot;, &quot;&quot;]}" href="/preisvergleich/Relocate/9202674019.html?categoryId=18928&amp;pos=13&amp;price=224.39&amp;productid=2317555&amp;sid=34245&amp;type=offer" target="_blank" rel="nofollow">
<span class="productOffers-listItemTitleInner">
Grohe Grohtherm 3000 Cos�mo�po�li�tan Ther�mo�stat, chrom, mit in�te�grier�ter 2-We�ge-Um�stel�lung (19468000)
</span>
</a>
</div>
<div class="productOffers-listItemOffer small-6 large-4 xlarge-7 columns" data-offerlist-column="price">
<a class="productOffers-listItemOfferPrice" data-wt-click="{&quot;id&quot;: &quot;offer.price&quot;, &quot;params&quot; : [&quot;&quot;, &quot;13&quot;, &quot;&quot;, &quot;&quot;, &quot;new&quot;]}" href="/preisvergleich/Relocate/9202674019.html?categoryId=18928&amp;pos=13&amp;price=224.39&amp;productid=2317555&amp;sid=34245&amp;type=offer" rel="nofollow" target="_blank">
�&nbsp;224,39
</a><br>
<div class="productOffers-listItemOfferShippingDetails hide-for-large-down">
<div class="table-row">
<div class="table-cell productOffers-listItemOfferShippingDetailsLeftBefore">
</div>
<div class="table-cell productOffers-listItemOfferShippingDetailsLeft" title="�&nbsp;243,99 inkl. Versand">
�&nbsp;243,99 inkl. Versand
</div>
<div class="table-cell productOffers-listItemOfferShippingDetailsRight">
<span class="productOffers-listItemOfferShippingDetailsRightItem" title="Visa">
<a rel="nofollow" target="_blank" href="/preisvergleich/Relocate/9202674019.html?categoryId=18928&amp;pos=13&amp;price=224.39&amp;productid=2317555&amp;sid=34245&amp;type=offer" data-wt-click="{&quot;id&quot;: &quot;leadout.oop.paymenticon&quot;}">
<span>
<img width="45" height="13" class="offerImage" src="//cdn.idealo.com/ipc/95351d/rwd/img/payment-icons/2x/visa.png" alt="Visa" title="Visa">
</span>
</a>
</span>
<span class="productOffers-listItemOfferShippingDetailsRightItem" title="MasterCard">
<a rel="nofollow" target="_blank" href="/preisvergleich/Relocate/9202674019.html?categoryId=18928&amp;pos=13&amp;price=224.39&amp;productid=2317555&amp;sid=34245&amp;type=offer" data-wt-click="{&quot;id&quot;: &quot;leadout.oop.paymenticon&quot;}">
<span>
<img width="45" height="13" class="offerImage" src="//cdn.idealo.com/ipc/95351d/rwd/img/payment-icons/2x/mastercard.png" alt="MasterCard" title="MasterCard">
</span>
</a>
</span>
</div>
</div>
<div class="table-row">
<div class="table-cell productOffers-listItemOfferShippingDetailsLeftBefore">
</div>
<div class="table-cell productOffers-listItemOfferShippingDetailsLeft" title="�&nbsp;237,34 inkl. Versand">
�&nbsp;237,34 inkl. Versand
</div>
<div class="table-cell productOffers-listItemOfferShippingDetailsRight">
<span class="productOffers-listItemOfferShippingDetailsRightItem" title="Vorkasse">
<a rel="nofollow" target="_blank" href="/preisvergleich/Relocate/9202674019.html?categoryId=18928&amp;pos=13&amp;price=224.39&amp;productid=2317555&amp;sid=34245&amp;type=offer" data-wt-click="{&quot;id&quot;: &quot;leadout.oop.paymenticon&quot;}">
<span>
Vorkasse
</span>
</a>
</span>
</div>
</div>
<div class="table-row">
<div class="table-cell productOffers-listItemOfferShippingDetailsLeftBefore">
</div>
<div class="table-cell productOffers-listItemOfferShippingDetailsLeft" title="�&nbsp;241,29 inkl. Versand">
�&nbsp;241,29 inkl. Versand
</div>
<div class="table-cell productOffers-listItemOfferShippingDetailsRight">
<span class="productOffers-listItemOfferShippingDetailsRightItem" title="Nachnahme">
<a rel="nofollow" target="_blank" href="/preisvergleich/Relocate/9202674019.html?categoryId=18928&amp;pos=13&amp;price=224.39&amp;productid=2317555&amp;sid=34245&amp;type=offer" data-wt-click="{&quot;id&quot;: &quot;leadout.oop.paymenticon&quot;}">
<span>
Nachnahme
</span>
</a>
</span>
</div>
</div>
</div>
<span class="productOffers-listItemOfferShipping show-for-large-only" data-wt-click="{&quot;id&quot;: &quot;offer.shippingcosts&quot;, &quot;params&quot; : [&quot;&quot;, &quot;13&quot;, &quot;&quot;, &quot;&quot;]}" data-overlay="{
&quot;closeCaption&quot; : &quot;zur�ck&quot;,
&quot;contentLoad&quot; : &quot;/overlay/product/2317555/offer/9202674019/index/12&quot;,
&quot;contentLoadBy&quot; : &quot;ajax&quot;,
&quot;contentPaddingLeft&quot; : &quot;1rem&quot;,
&quot;contentPaddingRight&quot; : &quot;1rem&quot;,
&quot;eventsOn&quot; : &quot;click&quot;,
&quot;titleCaption&quot; : &quot;Angebotsdetails&quot;,
&quot;titleAlign&quot; : &quot;left&quot;,
&quot;titleSize&quot; : &quot;xlarge&quot;,
&quot;triggerOnClose&quot; : &quot;offer-close&quot;,
&quot;triggerOnOpen&quot; : &quot;offer-open&quot;,
&quot;triggerOpenEvent&quot; : &quot;offer_9202674019&quot;
}">
Versandkosten: ab �&nbsp;12,95
</span>
<div class="productOffers-listItemOfferDetailsMobile table hide-for-large-up">
<div class="table-row">
<div class="productOffers-listItemOfferDetails table-cell" data-overlay="{
&quot;closeCaption&quot; : &quot;zur�ck&quot;,
&quot;contentLoad&quot; : &quot;/overlay/product/2317555/offer/9202674019/index/12&quot;,
&quot;contentLoadBy&quot; : &quot;ajax&quot;,
&quot;contentPaddingLeft&quot; : &quot;1rem&quot;,
&quot;contentPaddingRight&quot; : &quot;1rem&quot;,
&quot;eventsOn&quot; : &quot;click&quot;,
&quot;titleCaption&quot; : &quot;Angebotsdetails&quot;,
&quot;titleAlign&quot; : &quot;left&quot;,
&quot;titleSize&quot; : &quot;xlarge&quot;,
&quot;triggerOnClose&quot; : &quot;offer-close&quot;,
&quot;triggerOnOpen&quot; : &quot;offer-open&quot;,
&quot;triggerOpenEvent&quot; : &quot;offer_9202674019&quot;
}">
Details
</div>
<div class="productOffers-listItemOfferDelivery delivery delivery--short icon-delivery table-cell" data-wt-click="{&quot;id&quot;: &quot;offer.delivery&quot;, &quot;params&quot; : [&quot;&quot;, &quot;13&quot;, &quot;&quot;, &quot;&quot;, &quot;new&quot;]}" data-overlay="{
&quot;closeCaption&quot; : &quot;zur�ck&quot;,
&quot;contentLoad&quot; : &quot;/overlay/product/2317555/offer/9202674019/index/12&quot;,
&quot;contentLoadBy&quot; : &quot;ajax&quot;,
&quot;contentPaddingLeft&quot; : &quot;1rem&quot;,
&quot;contentPaddingRight&quot; : &quot;1rem&quot;,
&quot;eventsOn&quot; : &quot;click&quot;,
&quot;titleCaption&quot; : &quot;Angebotsdetails&quot;,
&quot;titleAlign&quot; : &quot;left&quot;,
&quot;titleSize&quot; : &quot;xlarge&quot;,
&quot;triggerOnClose&quot; : &quot;offer-close&quot;,
&quot;triggerOnOpen&quot; : &quot;offer-open&quot;,
&quot;triggerOpenEvent&quot; : &quot;offer_9202674019&quot;
}">
</div>
</div>
</div>
</div>
<div class="hide-for-medium-down large-2 xlarge-4 columns productOffers-listItemOfferDeliveryBlock va-middle-xlarge-up" data-offerlist-column="delivery">
<div class="table-cell" data-overlay="{
&quot;closeCaption&quot; : &quot;zur�ck&quot;,
&quot;contentLoad&quot; : &quot;/overlay/product/2317555/offer/9202674019/index/12&quot;,
&quot;contentLoadBy&quot; : &quot;ajax&quot;,
&quot;contentPaddingLeft&quot; : &quot;1rem&quot;,
&quot;contentPaddingRight&quot; : &quot;1rem&quot;,
&quot;eventsOn&quot; : &quot;click&quot;,
&quot;titleCaption&quot; : &quot;Angebotsdetails&quot;,
&quot;titleAlign&quot; : &quot;left&quot;,
&quot;titleSize&quot; : &quot;xlarge&quot;,
&quot;triggerOnClose&quot; : &quot;offer-close&quot;,
&quot;triggerOnOpen&quot; : &quot;offer-open&quot;,
&quot;triggerOpenEvent&quot; : &quot;offer_9202674019&quot;
}">
<div class="table">
<div class="table-row" data-wt-click="{&quot;id&quot;: &quot;offer.details.layer&quot;, &quot;params&quot; : [&quot;&quot;,&quot;13&quot;,&quot;oop.offerlist.delivery&quot;]}">
<div class="table-cell va-top productOffers-listItemOfferDeliveryIconWrapper">
<span class="productOffers-listItemOfferDelivery delivery delivery--circle short" data-wt-click="{&quot;id&quot;: &quot;offer.delivery&quot;, &quot;params&quot; : [&quot;&quot;, &quot;13&quot;, &quot;&quot;, &quot;&quot;, &quot;new&quot;]}">
</span>
<span class="productOffers-listItemOfferDelivery delivery delivery--short icon-delivery hide-for-xlarge-up" data-wt-click="{&quot;id&quot;: &quot;offer.delivery&quot;, &quot;params&quot; : [&quot;&quot;, &quot;13&quot;, &quot;&quot;, &quot;&quot;, &quot;new&quot;]}">
</span>
</div>
<div class="table-cell">
<p class="productOffers-listItemOfferDeliveryStatus">so�fort, ist auf Lager. Lie�fer�zeit: 2-3 Werk�ta�ge</p>
</div>
</div>
</div>
</div>
</div>
<div class="small-6 large-3 xlarge-3 columns xlarge-text-left large-text-center small-text-right productOffers-listItemOfferShopBlock va-middle-xlarge-up" data-offerlist-column="shop">
<div class="productOffers-listItemOfferLogo">
<a class="productOffers-listItemOfferLogoLink" data-checkout="false" data-shop-name="amailo.at - Shop aus Mistelbach" href="/preisvergleich/Relocate/9202674019.html?categoryId=18928&amp;pos=13&amp;price=224.39&amp;productid=2317555&amp;sid=34245&amp;type=offer" rel="nofollow" target="_blank">
<img class="productOffers-listItemOfferLogoShop hide" data-wt-click="{&quot;id&quot;: &quot;offer.shoplogo&quot;, &quot;params&quot; : [&quot;&quot;, &quot;13&quot;, &quot;&quot;, &quot;&quot;, &quot;new&quot;]}" src="//cdn.idealo.com/folder/Shop/34/2/34245/s2_shop_160x60.png" data-shop-logo="//cdn.idealo.com/folder/Shop/34/2/34245/s2_shop_160x60.png" data-shop-logo-fallback="//cdn.idealo.com/folder/Shop/34/2/34245/s2_shop.gif" alt="amailo.at - Shop aus Mistelbach" width="80" height="30" style="display: inline-block;">
<noscript>
&lt;img class="productOffers-listItemOfferLogoShop noborder"
src="//cdn.idealo.com/folder/Shop/34/2/34245/s2_shop.gif"
alt="amailo.at"
width="80" height="30"&gt;
</noscript>
</a>
</div>
<a class="productOffers-listItemOfferShopBlockRatingLink" href="https://www.idealo.at/preisvergleich/Shop/34245.html">
<div class="rating-wrapper">
<div class="table">
<div class="table-row">
<div class="table-cell rating-starsContainer">
<div class="rating-stars rating-stars--small">
<div class="rating-starsWrapper-90">
<img class="rating-starsImage rating-stars--default" src="//cdn.idealo.com/ipc/95351d/rwd/img/spacer.png" alt="*">
</div>
</div>
</div>
</div>
</div>
</div>
</a>
<a class="productOffers-listItemOfferRatingstext" href="https://www.idealo.at/preisvergleich/Shop/34245.html">
293 Meinungen
</a>
</div>
<div class="productOffers-listItemOfferCtaHolder large-3 xlarge-4 columns va-middle-xlarge-up " data-offerlist-column="checkoutleadoutbuttons">
<ul class="productOffers-listItemOfferCta">
<li>
<a class="productOffers-listItemOfferCtaLeadout button button--leadout expand" href="/preisvergleich/Relocate/9202674019.html?categoryId=18928&amp;pos=13&amp;price=224.39&amp;productid=2317555&amp;sid=34245&amp;type=offer" data-after="Zum Shop" data-shop-name="amailo.at" rel="nofollow" target="_blank">
<img class="btn-cta-shop" src="//cdn.idealo.com/ipc/95351d/pics/buttons/btn_placeholder.gif" alt="Grohe Grohtherm 3000 Cosmopolitan Wannenbatterie kaufen: g�nstige Wannenarmaturen bei amailo.at">
</a>
</li>
</ul>
</div>
<a class="productOffers-listItemOfferLink" href="/preisvergleich/Relocate/9202674019.html?categoryId=18928&amp;pos=13&amp;price=224.39&amp;productid=2317555&amp;sid=34245&amp;type=offer" data-checkout="false" data-shop-name="amailo.at" rel="nofollow" target="_blank">
</a>
</li>
<li class="productOffers-listItem row row-24" data-tm="{&quot;spr&quot;:&quot;e__&quot;}">
<div class="small-12 xlarge-6 columns productOffers-listItemTitleWrapper" data-offerlist-column="title">
<a class="productOffers-listItemTitle" data-wt-click="{&quot;id&quot;: &quot;offer.title&quot;, &quot;params&quot; : [&quot;&quot;, &quot;14&quot;, &quot;&quot;, &quot;&quot;]}" href="/preisvergleich/Relocate/410395250.html?categoryId=18928&amp;pos=14&amp;price=225.17&amp;productid=2317555&amp;sid=26754&amp;type=offer" target="_blank" rel="nofollow">
<span class="productOffers-listItemTitleInner">
Grohe Grohtherm 3000 Cos�mo�po�li�tan Ther�mo�stat-Wan�nen�bat�te�rie Fertigset chrom 19468000
</span>
</a>
</div>
<div class="productOffers-listItemOffer small-6 large-4 xlarge-7 columns" data-offerlist-column="price">
<a class="productOffers-listItemOfferPrice" data-wt-click="{&quot;id&quot;: &quot;offer.price&quot;, &quot;params&quot; : [&quot;&quot;, &quot;14&quot;, &quot;&quot;, &quot;&quot;, &quot;new&quot;]}" href="/preisvergleich/Relocate/410395250.html?categoryId=18928&amp;pos=14&amp;price=225.17&amp;productid=2317555&amp;sid=26754&amp;type=offer" rel="nofollow" target="_blank">
�&nbsp;225,17
</a><br>
<div class="productOffers-listItemOfferShippingDetails hide-for-large-down">
<div class="table-row">
<div class="table-cell productOffers-listItemOfferShippingDetailsLeftBefore">
</div>
<div class="table-cell productOffers-listItemOfferShippingDetailsLeft" title="�&nbsp;248,95 inkl. Versand">
�&nbsp;248,95 inkl. Versand
</div>
<div class="table-cell productOffers-listItemOfferShippingDetailsRight">
<span class="productOffers-listItemOfferShippingDetailsRightItem" title="Visa">
<a rel="nofollow" target="_blank" href="/preisvergleich/Relocate/410395250.html?categoryId=18928&amp;pos=14&amp;price=225.17&amp;productid=2317555&amp;sid=26754&amp;type=offer" data-wt-click="{&quot;id&quot;: &quot;leadout.oop.paymenticon&quot;}">
<span>
<img width="45" height="13" class="offerImage" src="//cdn.idealo.com/ipc/95351d/rwd/img/payment-icons/2x/visa.png" alt="Visa" title="Visa">
</span>
</a>
</span>
<span class="productOffers-listItemOfferShippingDetailsRightItem" title="MasterCard">
<a rel="nofollow" target="_blank" href="/preisvergleich/Relocate/410395250.html?categoryId=18928&amp;pos=14&amp;price=225.17&amp;productid=2317555&amp;sid=26754&amp;type=offer" data-wt-click="{&quot;id&quot;: &quot;leadout.oop.paymenticon&quot;}">
<span>
<img width="45" height="13" class="offerImage" src="//cdn.idealo.com/ipc/95351d/rwd/img/payment-icons/2x/mastercard.png" alt="MasterCard" title="MasterCard">
</span>
</a>
</span>
</div>
</div>
<div class="table-row">
<div class="table-cell productOffers-listItemOfferShippingDetailsLeftBefore">
</div>
<div class="table-cell productOffers-listItemOfferShippingDetailsLeft" title="�&nbsp;244,07 inkl. Versand">
�&nbsp;244,07 inkl. Versand
</div>
<div class="table-cell productOffers-listItemOfferShippingDetailsRight">
<span class="productOffers-listItemOfferShippingDetailsRightItem" title="Vorkasse">
<a rel="nofollow" target="_blank" href="/preisvergleich/Relocate/410395250.html?categoryId=18928&amp;pos=14&amp;price=225.17&amp;productid=2317555&amp;sid=26754&amp;type=offer" data-wt-click="{&quot;id&quot;: &quot;leadout.oop.paymenticon&quot;}">
<span>
Vorkasse
</span>
</a>
</span>
</div>
</div>
</div>
<span class="productOffers-listItemOfferShipping show-for-large-only" data-wt-click="{&quot;id&quot;: &quot;offer.shippingcosts&quot;, &quot;params&quot; : [&quot;&quot;, &quot;14&quot;, &quot;&quot;, &quot;&quot;]}" data-overlay="{
&quot;closeCaption&quot; : &quot;zur�ck&quot;,
&quot;contentLoad&quot; : &quot;/overlay/product/2317555/offer/410395250/index/13&quot;,
&quot;contentLoadBy&quot; : &quot;ajax&quot;,
&quot;contentPaddingLeft&quot; : &quot;1rem&quot;,
&quot;contentPaddingRight&quot; : &quot;1rem&quot;,
&quot;eventsOn&quot; : &quot;click&quot;,
&quot;titleCaption&quot; : &quot;Angebotsdetails&quot;,
&quot;titleAlign&quot; : &quot;left&quot;,
&quot;titleSize&quot; : &quot;xlarge&quot;,
&quot;triggerOnClose&quot; : &quot;offer-close&quot;,
&quot;triggerOnOpen&quot; : &quot;offer-open&quot;,
&quot;triggerOpenEvent&quot; : &quot;offer_410395250&quot;
}">
Versandkosten: ab �&nbsp;18,90
</span>
<div class="productOffers-listItemOfferDetailsMobile table hide-for-large-up">
<div class="table-row">
<div class="productOffers-listItemOfferDetails table-cell" data-overlay="{
&quot;closeCaption&quot; : &quot;zur�ck&quot;,
&quot;contentLoad&quot; : &quot;/overlay/product/2317555/offer/410395250/index/13&quot;,
&quot;contentLoadBy&quot; : &quot;ajax&quot;,
&quot;contentPaddingLeft&quot; : &quot;1rem&quot;,
&quot;contentPaddingRight&quot; : &quot;1rem&quot;,
&quot;eventsOn&quot; : &quot;click&quot;,
&quot;titleCaption&quot; : &quot;Angebotsdetails&quot;,
&quot;titleAlign&quot; : &quot;left&quot;,
&quot;titleSize&quot; : &quot;xlarge&quot;,
&quot;triggerOnClose&quot; : &quot;offer-close&quot;,
&quot;triggerOnOpen&quot; : &quot;offer-open&quot;,
&quot;triggerOpenEvent&quot; : &quot;offer_410395250&quot;
}">
Details
</div>
<div class="productOffers-listItemOfferDelivery delivery delivery--short icon-delivery table-cell" data-wt-click="{&quot;id&quot;: &quot;offer.delivery&quot;, &quot;params&quot; : [&quot;&quot;, &quot;14&quot;, &quot;&quot;, &quot;&quot;, &quot;new&quot;]}" data-overlay="{
&quot;closeCaption&quot; : &quot;zur�ck&quot;,
&quot;contentLoad&quot; : &quot;/overlay/product/2317555/offer/410395250/index/13&quot;,
&quot;contentLoadBy&quot; : &quot;ajax&quot;,
&quot;contentPaddingLeft&quot; : &quot;1rem&quot;,
&quot;contentPaddingRight&quot; : &quot;1rem&quot;,
&quot;eventsOn&quot; : &quot;click&quot;,
&quot;titleCaption&quot; : &quot;Angebotsdetails&quot;,
&quot;titleAlign&quot; : &quot;left&quot;,
&quot;titleSize&quot; : &quot;xlarge&quot;,
&quot;triggerOnClose&quot; : &quot;offer-close&quot;,
&quot;triggerOnOpen&quot; : &quot;offer-open&quot;,
&quot;triggerOpenEvent&quot; : &quot;offer_410395250&quot;
}">
</div>
</div>
</div>
</div>
<div class="hide-for-medium-down large-2 xlarge-4 columns productOffers-listItemOfferDeliveryBlock va-middle-xlarge-up" data-offerlist-column="delivery">
<div class="table-cell" data-overlay="{
&quot;closeCaption&quot; : &quot;zur�ck&quot;,
&quot;contentLoad&quot; : &quot;/overlay/product/2317555/offer/410395250/index/13&quot;,
&quot;contentLoadBy&quot; : &quot;ajax&quot;,
&quot;contentPaddingLeft&quot; : &quot;1rem&quot;,
&quot;contentPaddingRight&quot; : &quot;1rem&quot;,
&quot;eventsOn&quot; : &quot;click&quot;,
&quot;titleCaption&quot; : &quot;Angebotsdetails&quot;,
&quot;titleAlign&quot; : &quot;left&quot;,
&quot;titleSize&quot; : &quot;xlarge&quot;,
&quot;triggerOnClose&quot; : &quot;offer-close&quot;,
&quot;triggerOnOpen&quot; : &quot;offer-open&quot;,
&quot;triggerOpenEvent&quot; : &quot;offer_410395250&quot;
}">
<div class="table">
<div class="table-row" data-wt-click="{&quot;id&quot;: &quot;offer.details.layer&quot;, &quot;params&quot; : [&quot;&quot;,&quot;14&quot;,&quot;oop.offerlist.delivery&quot;]}">
<div class="table-cell va-top productOffers-listItemOfferDeliveryIconWrapper">
<span class="productOffers-listItemOfferDelivery delivery delivery--circle short" data-wt-click="{&quot;id&quot;: &quot;offer.delivery&quot;, &quot;params&quot; : [&quot;&quot;, &quot;14&quot;, &quot;&quot;, &quot;&quot;, &quot;new&quot;]}">
</span>
<span class="productOffers-listItemOfferDelivery delivery delivery--short icon-delivery hide-for-xlarge-up" data-wt-click="{&quot;id&quot;: &quot;offer.delivery&quot;, &quot;params&quot; : [&quot;&quot;, &quot;14&quot;, &quot;&quot;, &quot;&quot;, &quot;new&quot;]}">
</span>
</div>
<div class="table-cell">
<p class="productOffers-listItemOfferDeliveryStatus">ca. 2-3 Tage</p>
<div class="productOffers-listItemOfferDeliveryProviderWrapper">
<span class="productOffers-listItemOfferGreyBadge productOffers-listItemOfferDeliveryProvider">DHL</span>
<span class="productOffers-listItemOfferGreyBadge productOffers-listItemOfferDeliveryProvider">UPS</span>
<span class="productOffers-listItemOfferGreyBadge productOffers-listItemOfferDeliveryProvider">Spedition</span>
</div>
</div>
</div>
</div>
</div>
</div>
<div class="small-6 large-3 xlarge-3 columns xlarge-text-left large-text-center small-text-right productOffers-listItemOfferShopBlock va-middle-xlarge-up" data-offerlist-column="shop">
<div class="productOffers-listItemOfferLogo">
<a class="productOffers-listItemOfferLogoLink" data-checkout="false" data-shop-name="reuter.de - Shop aus Viersen" href="/preisvergleich/Relocate/410395250.html?categoryId=18928&amp;pos=14&amp;price=225.17&amp;productid=2317555&amp;sid=26754&amp;type=offer" rel="nofollow" target="_blank">
<img class="productOffers-listItemOfferLogoShop hide" data-wt-click="{&quot;id&quot;: &quot;offer.shoplogo&quot;, &quot;params&quot; : [&quot;&quot;, &quot;14&quot;, &quot;&quot;, &quot;&quot;, &quot;new&quot;]}" src="//cdn.idealo.com/folder/Shop/26/7/26754/s2_shop_160x60.png" data-shop-logo="//cdn.idealo.com/folder/Shop/26/7/26754/s2_shop_160x60.png" data-shop-logo-fallback="//cdn.idealo.com/folder/Shop/26/7/26754/s2_shop.gif" alt="reuter.de - Shop aus Viersen" width="80" height="30" style="display: inline-block;">
<noscript>
&lt;img class="productOffers-listItemOfferLogoShop noborder"
src="//cdn.idealo.com/folder/Shop/26/7/26754/s2_shop.gif"
alt="reuter.de"
width="80" height="30"&gt;
</noscript>
</a>
</div>
<a class="productOffers-listItemOfferShopBlockRatingLink" href="https://www.idealo.at/preisvergleich/Shop/26754.html">
<div class="rating-wrapper">
<div class="table">
<div class="table-row">
<div class="table-cell rating-starsContainer">
<div class="rating-stars rating-stars--small">
<div class="rating-starsWrapper-50">
<img class="rating-starsImage rating-stars--default" src="//cdn.idealo.com/ipc/95351d/rwd/img/spacer.png" alt="*">
</div>
</div>
</div>
</div>
</div>
</div>
</a>
<a class="productOffers-listItemOfferRatingstext" href="https://www.idealo.at/preisvergleich/Shop/26754.html">
55 Meinungen
</a>
</div>
<div class="productOffers-listItemOfferCtaHolder large-3 xlarge-4 columns va-middle-xlarge-up " data-offerlist-column="checkoutleadoutbuttons">
<ul class="productOffers-listItemOfferCta">
<li>
<a class="productOffers-listItemOfferCtaLeadout button button--leadout expand" href="/preisvergleich/Relocate/410395250.html?categoryId=18928&amp;pos=14&amp;price=225.17&amp;productid=2317555&amp;sid=26754&amp;type=offer" data-after="Zum Shop" data-shop-name="reuter.de" rel="nofollow" target="_blank">
<img class="btn-cta-shop" src="//cdn.idealo.com/ipc/95351d/pics/buttons/btn_placeholder.gif" alt="Grohe 19468000 bestellen: preiswerte Wannenarmaturen bei reuter.de">
</a>
</li>
</ul>
</div>
<a class="productOffers-listItemOfferLink" href="/preisvergleich/Relocate/410395250.html?categoryId=18928&amp;pos=14&amp;price=225.17&amp;productid=2317555&amp;sid=26754&amp;type=offer" data-checkout="false" data-shop-name="reuter.de" rel="nofollow" target="_blank">
</a>
</li>
<li class="productOffers-listItem row row-24" data-hyperlinks="[{&quot;rel&quot;:&quot;self&quot;,&quot;href&quot;:&quot;https://www.idealo.at/OfferList/product/2317555/start/15/sort/default?includeFilters=0&amp;excludeFilters=2062&quot;},{&quot;rel&quot;:&quot;totalPrice&quot;,&quot;href&quot;:&quot;https://www.idealo.at/OfferList/product/2317555/start/0/sort/btpb?includeFilters=0&amp;excludeFilters=2062&quot;},{&quot;rel&quot;:&quot;loadMore&quot;,&quot;href&quot;:&quot;https://www.idealo.at/OfferList/product/2317555/start/15/sort/default?includeFilters=0&amp;excludeFilters=2062&quot;},{&quot;rel&quot;:&quot;available&quot;,&quot;href&quot;:&quot;https://www.idealo.at/OfferList/product/2317555/start/0/sort/default?includeFilters=64&amp;excludeFilters=2062&quot;},{&quot;rel&quot;:&quot;freereturn&quot;,&quot;href&quot;:&quot;https://www.idealo.at/OfferList/product/2317555/start/0/sort/default?includeFilters=262144&amp;excludeFilters=2062&quot;},{&quot;rel&quot;:&quot;switchCondition&quot;,&quot;href&quot;:&quot;/preisvergleich/OffersOfProduct/2317555E2060J2_-grohtherm-3000-c-thermostat-19468000-grohe.html&quot;}]" data-total-offer-count="18" data-tm="{&quot;spr&quot;:&quot;dd_&quot;}">
<div class="small-12 xlarge-6 columns productOffers-listItemTitleWrapper" data-offerlist-column="title">
<a class="productOffers-listItemTitle" data-wt-click="{&quot;id&quot;: &quot;offer.title&quot;, &quot;params&quot; : [&quot;&quot;, &quot;15&quot;, &quot;&quot;, &quot;&quot;]}" href="/preisvergleich/Relocate/7429944516.html?categoryId=18928&amp;pos=15&amp;price=229.90&amp;productid=2317555&amp;sid=303152&amp;type=offer" target="_blank" rel="nofollow">
<span class="productOffers-listItemTitleInner">
GROHE Grohtherm 3000 C Thermostat 2-We�ge-Um�stel�lung Fer�tig�mon�ta�ge�set Unterputz chrom 19468000
</span>
</a>
</div>
<div class="productOffers-listItemOffer small-6 large-4 xlarge-7 columns" data-offerlist-column="price">
<a class="productOffers-listItemOfferPrice" data-wt-click="{&quot;id&quot;: &quot;offer.price&quot;, &quot;params&quot; : [&quot;&quot;, &quot;15&quot;, &quot;&quot;, &quot;&quot;, &quot;new&quot;]}" href="/preisvergleich/Relocate/7429944516.html?categoryId=18928&amp;pos=15&amp;price=229.90&amp;productid=2317555&amp;sid=303152&amp;type=offer" rel="nofollow" target="_blank">
�&nbsp;229,90
</a><br>
<div class="productOffers-listItemOfferShippingDetails hide-for-large-down">
<div class="table-row">
<div class="table-cell productOffers-listItemOfferShippingDetailsLeftBefore">
</div>
<div class="table-cell productOffers-listItemOfferShippingDetailsLeft" title="�&nbsp;249,17 inkl. Versand">
�&nbsp;249,17 inkl. Versand
</div>
<div class="table-cell productOffers-listItemOfferShippingDetailsRight">
<span class="productOffers-listItemOfferShippingDetailsRightItem" title="PayPal">
<a rel="nofollow" target="_blank" href="/preisvergleich/Relocate/7429944516.html?categoryId=18928&amp;pos=15&amp;price=229.90&amp;productid=2317555&amp;sid=303152&amp;type=offer" data-wt-click="{&quot;id&quot;: &quot;leadout.oop.paymenticon&quot;}">
<span>
<img width="45" height="13" class="offerImage" src="//cdn.idealo.com/ipc/95351d/rwd/img/payment-icons/2x/paypal.png" alt="PayPal" title="PayPal">
</span>
</a>
</span>
</div>
</div>
<div class="table-row">
<div class="table-cell productOffers-listItemOfferShippingDetailsLeftBefore">
</div>
<div class="table-cell productOffers-listItemOfferShippingDetailsLeft" title="�&nbsp;244,80 inkl. Versand">
�&nbsp;244,80 inkl. Versand
</div>
<div class="table-cell productOffers-listItemOfferShippingDetailsRight">
<span class="productOffers-listItemOfferShippingDetailsRightItem" title="Vorkasse">
<a rel="nofollow" target="_blank" href="/preisvergleich/Relocate/7429944516.html?categoryId=18928&amp;pos=15&amp;price=229.90&amp;productid=2317555&amp;sid=303152&amp;type=offer" data-wt-click="{&quot;id&quot;: &quot;leadout.oop.paymenticon&quot;}">
<span>
Vorkasse
</span>
</a>
</span>
</div>
</div>
</div>
<span class="productOffers-listItemOfferShipping show-for-large-only" data-wt-click="{&quot;id&quot;: &quot;offer.shippingcosts&quot;, &quot;params&quot; : [&quot;&quot;, &quot;15&quot;, &quot;&quot;, &quot;&quot;]}" data-overlay="{
&quot;closeCaption&quot; : &quot;zur�ck&quot;,
&quot;contentLoad&quot; : &quot;/overlay/product/2317555/offer/7429944516/index/14&quot;,
&quot;contentLoadBy&quot; : &quot;ajax&quot;,
&quot;contentPaddingLeft&quot; : &quot;1rem&quot;,
&quot;contentPaddingRight&quot; : &quot;1rem&quot;,
&quot;eventsOn&quot; : &quot;click&quot;,
&quot;titleCaption&quot; : &quot;Angebotsdetails&quot;,
&quot;titleAlign&quot; : &quot;left&quot;,
&quot;titleSize&quot; : &quot;xlarge&quot;,
&quot;triggerOnClose&quot; : &quot;offer-close&quot;,
&quot;triggerOnOpen&quot; : &quot;offer-open&quot;,
&quot;triggerOpenEvent&quot; : &quot;offer_7429944516&quot;
}">
Versandkosten: ab �&nbsp;14,90
</span>
<div class="productOffers-listItemOfferDetailsMobile table hide-for-large-up">
<div class="table-row">
<div class="productOffers-listItemOfferDetails table-cell" data-overlay="{
&quot;closeCaption&quot; : &quot;zur�ck&quot;,
&quot;contentLoad&quot; : &quot;/overlay/product/2317555/offer/7429944516/index/14&quot;,
&quot;contentLoadBy&quot; : &quot;ajax&quot;,
&quot;contentPaddingLeft&quot; : &quot;1rem&quot;,
&quot;contentPaddingRight&quot; : &quot;1rem&quot;,
&quot;eventsOn&quot; : &quot;click&quot;,
&quot;titleCaption&quot; : &quot;Angebotsdetails&quot;,
&quot;titleAlign&quot; : &quot;left&quot;,
&quot;titleSize&quot; : &quot;xlarge&quot;,
&quot;triggerOnClose&quot; : &quot;offer-close&quot;,
&quot;triggerOnOpen&quot; : &quot;offer-open&quot;,
&quot;triggerOpenEvent&quot; : &quot;offer_7429944516&quot;
}">
Details
</div>
<div class="productOffers-listItemOfferDelivery delivery delivery--short icon-delivery table-cell" data-wt-click="{&quot;id&quot;: &quot;offer.delivery&quot;, &quot;params&quot; : [&quot;&quot;, &quot;15&quot;, &quot;&quot;, &quot;&quot;, &quot;new&quot;]}" data-overlay="{
&quot;closeCaption&quot; : &quot;zur�ck&quot;,
&quot;contentLoad&quot; : &quot;/overlay/product/2317555/offer/7429944516/index/14&quot;,
&quot;contentLoadBy&quot; : &quot;ajax&quot;,
&quot;contentPaddingLeft&quot; : &quot;1rem&quot;,
&quot;contentPaddingRight&quot; : &quot;1rem&quot;,
&quot;eventsOn&quot; : &quot;click&quot;,
&quot;titleCaption&quot; : &quot;Angebotsdetails&quot;,
&quot;titleAlign&quot; : &quot;left&quot;,
&quot;titleSize&quot; : &quot;xlarge&quot;,
&quot;triggerOnClose&quot; : &quot;offer-close&quot;,
&quot;triggerOnOpen&quot; : &quot;offer-open&quot;,
&quot;triggerOpenEvent&quot; : &quot;offer_7429944516&quot;
}">
</div>
</div>
</div>
</div>
<div class="hide-for-medium-down large-2 xlarge-4 columns productOffers-listItemOfferDeliveryBlock va-middle-xlarge-up" data-offerlist-column="delivery">
<div class="table-cell" data-overlay="{
&quot;closeCaption&quot; : &quot;zur�ck&quot;,
&quot;contentLoad&quot; : &quot;/overlay/product/2317555/offer/7429944516/index/14&quot;,
&quot;contentLoadBy&quot; : &quot;ajax&quot;,
&quot;contentPaddingLeft&quot; : &quot;1rem&quot;,
&quot;contentPaddingRight&quot; : &quot;1rem&quot;,
&quot;eventsOn&quot; : &quot;click&quot;,
&quot;titleCaption&quot; : &quot;Angebotsdetails&quot;,
&quot;titleAlign&quot; : &quot;left&quot;,
&quot;titleSize&quot; : &quot;xlarge&quot;,
&quot;triggerOnClose&quot; : &quot;offer-close&quot;,
&quot;triggerOnOpen&quot; : &quot;offer-open&quot;,
&quot;triggerOpenEvent&quot; : &quot;offer_7429944516&quot;
}">
<div class="table">
<div class="table-row" data-wt-click="{&quot;id&quot;: &quot;offer.details.layer&quot;, &quot;params&quot; : [&quot;&quot;,&quot;15&quot;,&quot;oop.offerlist.delivery&quot;]}">
<div class="table-cell va-top productOffers-listItemOfferDeliveryIconWrapper">
<span class="productOffers-listItemOfferDelivery delivery delivery--circle short" data-wt-click="{&quot;id&quot;: &quot;offer.delivery&quot;, &quot;params&quot; : [&quot;&quot;, &quot;15&quot;, &quot;&quot;, &quot;&quot;, &quot;new&quot;]}">
</span>
<span class="productOffers-listItemOfferDelivery delivery delivery--short icon-delivery hide-for-xlarge-up" data-wt-click="{&quot;id&quot;: &quot;offer.delivery&quot;, &quot;params&quot; : [&quot;&quot;, &quot;15&quot;, &quot;&quot;, &quot;&quot;, &quot;new&quot;]}">
</span>
</div>
<div class="table-cell">
<p class="productOffers-listItemOfferDeliveryStatus">La�ger�wa�re, 1-2 Tage</p>
<div class="productOffers-listItemOfferDeliveryProviderWrapper">
<span class="productOffers-listItemOfferGreyBadge productOffers-listItemOfferDeliveryProvider">DHL</span>
<span class="productOffers-listItemOfferGreyBadge productOffers-listItemOfferDeliveryProvider">Spedition</span>
</div>
</div>
</div>
</div>
</div>
</div>
<div class="small-6 large-3 xlarge-3 columns xlarge-text-left large-text-center small-text-right productOffers-listItemOfferShopBlock va-middle-xlarge-up" data-offerlist-column="shop">
<div class="productOffers-listItemOfferLogo">
<a class="productOffers-listItemOfferLogoLink" data-checkout="false" data-shop-name="sanundo.de - Shop aus Reichst�dt" href="/preisvergleich/Relocate/7429944516.html?categoryId=18928&amp;pos=15&amp;price=229.90&amp;productid=2317555&amp;sid=303152&amp;type=offer" rel="nofollow" target="_blank">
<img class="productOffers-listItemOfferLogoShop hide" data-wt-click="{&quot;id&quot;: &quot;offer.shoplogo&quot;, &quot;params&quot; : [&quot;&quot;, &quot;15&quot;, &quot;&quot;, &quot;&quot;, &quot;new&quot;]}" src="//cdn.idealo.com/folder/Shop/303/1/303152/s2_shop_160x60.png" data-shop-logo="//cdn.idealo.com/folder/Shop/303/1/303152/s2_shop_160x60.png" data-shop-logo-fallback="//cdn.idealo.com/folder/Shop/303/1/303152/s2_shop.gif" alt="sanundo.de - Shop aus Reichst�dt" width="80" height="30" style="display: inline-block;">
<noscript>
&lt;img class="productOffers-listItemOfferLogoShop noborder"
src="//cdn.idealo.com/folder/Shop/303/1/303152/s2_shop.gif"
alt="sanundo.de"
width="80" height="30"&gt;
</noscript>
</a>
</div>
<a class="productOffers-listItemOfferShopBlockRatingLink" href="https://www.idealo.at/preisvergleich/Shop/303152.html">
<div class="rating-wrapper">
<div class="table">
<div class="table-row">
<div class="table-cell rating-starsContainer">
<div class="rating-stars rating-stars--small">
<div class="rating-starsWrapper-80">
<img class="rating-starsImage rating-stars--default" src="//cdn.idealo.com/ipc/95351d/rwd/img/spacer.png" alt="*">
</div>
</div>
</div>
</div>
</div>
</div>
</a>
<a class="productOffers-listItemOfferRatingstext" href="https://www.idealo.at/preisvergleich/Shop/303152.html">
4 Meinungen
</a>
</div>
<div class="productOffers-listItemOfferCtaHolder large-3 xlarge-4 columns va-middle-xlarge-up " data-offerlist-column="checkoutleadoutbuttons">
<ul class="productOffers-listItemOfferCta">
<li>
<a class="productOffers-listItemOfferCtaLeadout button button--leadout expand" href="/preisvergleich/Relocate/7429944516.html?categoryId=18928&amp;pos=15&amp;price=229.90&amp;productid=2317555&amp;sid=303152&amp;type=offer" data-after="Zum Shop" data-shop-name="sanundo.de" rel="nofollow" target="_blank">
<img class="btn-cta-shop" src="//cdn.idealo.com/ipc/95351d/pics/buttons/btn_placeholder.gif" alt="Grohe Grohtherm 3000 C Thermostat (19468000) versand: billige Wannenarmaturen bei sanundo.de">
</a>
</li>
</ul>
</div>
<a class="productOffers-listItemOfferLink" href="/preisvergleich/Relocate/7429944516.html?categoryId=18928&amp;pos=15&amp;price=229.90&amp;productid=2317555&amp;sid=303152&amp;type=offer" data-checkout="false" data-shop-name="sanundo.de" rel="nofollow" target="_blank">
</a>
</li>
<li class="productOffers-listItemImportTime row row-24"><span class="small-12 columns">Daten vom 23.06.2017&nbsp;09:08*</span></li><li class="productOffers-listItemLoadMore row row-24"><div class="collapse-both text-center small-12 columns"><button class="productOffers-listLoadMore button-ghost button-ghost--blue">Weitere Angebote anzeigen</button></div></li></ul>
<div class="pagination row">
<div class="collapse-both text-right small-4 columns">
&nbsp;
</div>
<div class="collapse-both text-center small-4 columns">
<span class="pagination-identifier">
1&nbsp;/&nbsp;2
</span>
</div>
<div class="collapse-both small-4 columns">
<a class="pagination-next icon-arrow-right" href="/preisvergleich/OffersOfProduct/2317555I-1-15_-grohtherm-3000-c-thermostat-19468000-grohe.html#Angebote">&nbsp;</a>
</div>
</div>
</div>
<div class="row">
<div class="small-12 column reportError-link hide text-right" data-overlay="{
&quot;closeCaption&quot; : &quot;Zur�ck&quot;,
&quot;contentLoad&quot; : &quot;/mvc/RwdReportError/product/2317555&quot;,
&quot;contentLoadBy&quot; : &quot;ajax&quot;,
&quot;contentPaddingLeft&quot; : &quot;1rem&quot;,
&quot;contentPaddingRight&quot; : &quot;1rem&quot;,
&quot;eventsOn&quot; : &quot;click&quot;,
&quot;webtrekkPrefix&quot; : &quot;reporterror&quot;,
&quot;titleCaption&quot; : &quot;Fehler melden&quot;,
&quot;titleSize&quot; : &quot;xlarge&quot;,
&quot;titleAlign&quot; : &quot;left&quot;,
&quot;triggerOnOpen&quot; : &quot;reportErrorOpen&quot;
}" style="bottom: 215.5px;">
Fehler melden
</div>
</div>
</div>
</div>
</div>
<section class="stage stage--alternatives">
<div class="row">
<div class="small-12 columns">
<h2 class="stage-title">
Das k�nnte Dich auch interessieren
</h2>
</div>
<div class="slider small-12 columns">
<div class="carousel carousel--alternatives swiper-container carousel--init swiper-container-horizontal" data-carousel="{
&quot;id&quot; : &quot;alternative-products&quot;,
&quot;webtrekkPrefix&quot; : &quot;list.alternative_products&quot;
}" id="alternative-products">
<div class="swiper-wrapper">
<div class="carousel-slide swiper-slide swiper-slide-active" style="width: 242px; margin-right: 10px;">
<a class="carousel-slideLink" href="/preisvergleich/OffersOfProduct/4882506_-logis-71400000-hansgrohe.html" rel="">
<div class="carousel-slideImageWrapper">
<img class="carousel-slideImage" src="//cdn.idealo.com/folder/Product/4882/5/4882506/s2_produktbild_mittel/hansgrohe-logis-71400000.png" data-src="//cdn.idealo.com/folder/Product/4882/5/4882506/s2_produktbild_mittel/hansgrohe-logis-71400000.png" alt="Hansgrohe Logis (71400000)" width="120" height="100">
<noscript>
&lt;img
class="carousel-slideImage"
src="//cdn.idealo.com/folder/Product/4882/5/4882506/s2_produktbild_mittel/hansgrohe-logis-71400000.png"
alt="Hansgrohe Logis (71400000)"
width="120"
height="100"&gt;
</noscript>
</div>
<span class="carousel-slideTitle">
Hansgrohe Logis (71400000)
</span>
</a>
</div>
<div class="carousel-slide swiper-slide swiper-slide-next" style="width: 242px; margin-right: 10px;">
<a class="carousel-slideLink" href="/preisvergleich/OffersOfProduct/1005582_-uno-einhebel-wannenmischer-aufputz-chrom-38400-axor.html" rel="">
<div class="carousel-slideImageWrapper">
<img class="carousel-slideImage" src="//cdn.idealo.com/folder/Product/1005/5/1005582/s2_produktbild_mittel/axor-uno-einhebel-wannenmischer-aufputz-chrom-38400.png" data-src="//cdn.idealo.com/folder/Product/1005/5/1005582/s2_produktbild_mittel/axor-uno-einhebel-wannenmischer-aufputz-chrom-38400.png" alt="Axor Uno Einhebel-Wannenmischer Aufputz (Chrom, 38400)" width="120" height="100">
<noscript>
&lt;img
class="carousel-slideImage"
src="//cdn.idealo.com/folder/Product/1005/5/1005582/s2_produktbild_mittel/axor-uno-einhebel-wannenmischer-aufputz-chrom-38400.png"
alt="Axor Uno Einhebel-Wannenmischer Aufputz (Chrom, 38400)"
width="120"
height="100"&gt;
</noscript>
</div>
<span class="carousel-slideTitle">
Axor Uno Einhebel-Wannenmischer Aufputz (Chrom, 38400)
</span>
</a>
</div>
<div class="carousel-slide swiper-slide" style="width: 242px; margin-right: 10px;">
<a class="carousel-slideLink" href="/preisvergleich/OffersOfProduct/2693163_-supernova-einhandbatterie-fuer-up-36015730-dornbracht.html" rel="">
<div class="carousel-slideImageWrapper">
<img class="carousel-slideImage" src="//cdn.idealo.com/images/product-get/2693163/s2/produktbild_mittel/dornbracht-supernova-einhandbatterie-fuer-up-36015730.jpg" data-src="//cdn.idealo.com/images/product-get/2693163/s2/produktbild_mittel/dornbracht-supernova-einhandbatterie-fuer-up-36015730.jpg" alt="Dornbracht Supernova Einhandbatterie f�r UP (36015730)" width="120" height="100">
<noscript>
&lt;img
class="carousel-slideImage"
src="//cdn.idealo.com/images/product-get/2693163/s2/produktbild_mittel/dornbracht-supernova-einhandbatterie-fuer-up-36015730.jpg"
alt="Dornbracht Supernova Einhandbatterie f�r UP (36015730)"
width="120"
height="100"&gt;
</noscript>
</div>
<span class="carousel-slideTitle">
Dornbracht Supernova Einhandbatterie f�r UP (36015730)
</span>
</a>
</div>
<div class="carousel-slide swiper-slide" style="width: 242px; margin-right: 10px;">
<a class="carousel-slideLink" href="/preisvergleich/OffersOfProduct/4843597_-grandera-wannenbatterie-23317ig0-grohe.html" rel="">
<div class="carousel-slideImageWrapper">
<img class="carousel-slideImage" src="//cdn.idealo.com/folder/Product/4843/5/4843597/s2_produktbild_mittel/grohe-grandera-wannenbatterie-23317ig0.png" data-src="//cdn.idealo.com/folder/Product/4843/5/4843597/s2_produktbild_mittel/grohe-grandera-wannenbatterie-23317ig0.png" alt="Grohe Grandera Wannenbatterie (23317IG0)" width="120" height="100">
<noscript>
&lt;img
class="carousel-slideImage"
src="//cdn.idealo.com/folder/Product/4843/5/4843597/s2_produktbild_mittel/grohe-grandera-wannenbatterie-23317ig0.png"
alt="Grohe Grandera Wannenbatterie (23317IG0)"
width="120"
height="100"&gt;
</noscript>
</div>
<span class="carousel-slideTitle">
Grohe Grandera Wannenbatterie (23317IG0)
</span>
</a>
</div>
<div class="carousel-slide swiper-slide" style="width: 242px; margin-right: 10px;">
<a class="carousel-slideLink" href="/preisvergleich/OffersOfProduct/1840082_-plan-einhebel-wannenmischer-up-54972-keuco.html" rel="">
<div class="carousel-slideImageWrapper">
<img class="carousel-slideImage" src="//cdn.idealo.com/folder/Product/3449/9/3449929/s2_produktbild_mittel/keuco-plan-einhebel-wannenmischer-up-edelstahl-54972070101.png" data-src="//cdn.idealo.com/folder/Product/3449/9/3449929/s2_produktbild_mittel/keuco-plan-einhebel-wannenmischer-up-edelstahl-54972070101.png" alt="Keuco Plan Einhebel Wannenmischer UP (54972)" width="120" height="100">
<noscript>
&lt;img
class="carousel-slideImage"
src="//cdn.idealo.com/folder/Product/3449/9/3449929/s2_produktbild_mittel/keuco-plan-einhebel-wannenmischer-up-edelstahl-54972070101.png"
alt="Keuco Plan Einhebel Wannenmischer UP (54972)"
width="120"
height="100"&gt;
</noscript>
</div>
<span class="carousel-slideTitle">
Keuco Plan Einhebel Wannenmischer UP (54972)
</span>
</a>
</div>
<div class="carousel-slide swiper-slide" style="width: 242px; margin-right: 10px;">
<a class="carousel-slideLink" href="/preisvergleich/OffersOfProduct/4843585_-grandera-wannenbatterie-19920000-grohe.html" rel="">
<div class="carousel-slideImageWrapper">
<img class="carousel-slideImage carousel-slideImageFallback" src="//cdn.idealo.com/ipc/95351d/rwd/img/ajax-loader-grey.gif" data-src="//cdn.idealo.com/folder/Product/4843/5/4843585/s2_produktbild_mittel/grohe-grandera-wannenbatterie-19920000.png" alt="Grohe Grandera Wannenbatterie (19920000)" width="120" height="100">
<noscript>
&lt;img
class="carousel-slideImage"
src="//cdn.idealo.com/folder/Product/4843/5/4843585/s2_produktbild_mittel/grohe-grandera-wannenbatterie-19920000.png"
alt="Grohe Grandera Wannenbatterie (19920000)"
width="120"
height="100"&gt;
</noscript>
</div>
<span class="carousel-slideTitle">
Grohe Grandera Wannenbatterie (19920000)
</span>
</a>
</div>
<div class="carousel-slide swiper-slide" style="width: 242px; margin-right: 10px;">
<a class="carousel-slideLink" href="/preisvergleich/OffersOfProduct/4968515_-plan-blue-einhebelmischer-up-keuco.html" rel="">
<div class="carousel-slideImageWrapper">
<img class="carousel-slideImage carousel-slideImageFallback" src="//cdn.idealo.com/ipc/95351d/rwd/img/ajax-loader-grey.gif" data-src="//cdn.idealo.com/folder/Product/4968/5/4968515/s2_produktbild_mittel/keuco-plan-blue-einhebelmischer-up.png" alt="Keuco Plan Blue Einhebelmischer UP" width="120" height="100">
<noscript>
&lt;img
class="carousel-slideImage"
src="//cdn.idealo.com/folder/Product/4968/5/4968515/s2_produktbild_mittel/keuco-plan-blue-einhebelmischer-up.png"
alt="Keuco Plan Blue Einhebelmischer UP"
width="120"
height="100"&gt;
</noscript>
</div>
<span class="carousel-slideTitle">
Keuco Plan Blue Einhebelmischer UP
</span>
</a>
</div>
<div class="carousel-slide swiper-slide" style="width: 242px; margin-right: 10px;">
<a class="carousel-slideLink" href="/preisvergleich/OffersOfProduct/3958132_-grohtherm-2000-34174001-grohe.html" rel="">
<div class="carousel-slideImageWrapper">
<img class="carousel-slideImage carousel-slideImageFallback" src="//cdn.idealo.com/ipc/95351d/rwd/img/ajax-loader-grey.gif" data-src="//cdn.idealo.com/folder/Product/3958/1/3958132/s2_produktbild_mittel/grohe-grohtherm-2000-34174001.png" alt="Grohe Grohtherm 2000 (34174001)" width="120" height="100">
<noscript>
&lt;img
class="carousel-slideImage"
src="//cdn.idealo.com/folder/Product/3958/1/3958132/s2_produktbild_mittel/grohe-grohtherm-2000-34174001.png"
alt="Grohe Grohtherm 2000 (34174001)"
width="120"
height="100"&gt;
</noscript>
</div>
<span class="carousel-slideTitle">
Grohe Grohtherm 2000 (34174001)
</span>
</a>
</div>
<div class="carousel-slide swiper-slide" style="width: 242px; margin-right: 10px;">
<a class="carousel-slideLink" href="/preisvergleich/OffersOfProduct/4843275_-essence-33628001-grohe.html" rel="">
<div class="carousel-slideImageWrapper">
<img class="carousel-slideImage carousel-slideImageFallback" src="//cdn.idealo.com/ipc/95351d/rwd/img/ajax-loader-grey.gif" data-src="//cdn.idealo.com/folder/Product/4843/2/4843275/s2_produktbild_mittel/grohe-essence-33628001.png" alt="Grohe Essence (33628001)" width="120" height="100">
<noscript>
&lt;img
class="carousel-slideImage"
src="//cdn.idealo.com/folder/Product/4843/2/4843275/s2_produktbild_mittel/grohe-essence-33628001.png"
alt="Grohe Essence (33628001)"
width="120"
height="100"&gt;
</noscript>
</div>
<span class="carousel-slideTitle">
Grohe Essence (33628001)
</span>
</a>
</div>
<div class="carousel-slide swiper-slide" style="width: 242px; margin-right: 10px;">
<a class="carousel-slideLink" href="/preisvergleich/OffersOfProduct/4843269_-essence-23491001-grohe.html" rel="">
<div class="carousel-slideImageWrapper">
<img class="carousel-slideImage carousel-slideImageFallback" src="//cdn.idealo.com/ipc/95351d/rwd/img/ajax-loader-grey.gif" data-src="//cdn.idealo.com/folder/Product/4843/2/4843269/s2_produktbild_mittel/grohe-essence-23491001.png" alt="Grohe Essence (23491001)" width="120" height="100">
<noscript>
&lt;img
class="carousel-slideImage"
src="//cdn.idealo.com/folder/Product/4843/2/4843269/s2_produktbild_mittel/grohe-essence-23491001.png"
alt="Grohe Essence (23491001)"
width="120"
height="100"&gt;
</noscript>
</div>
<span class="carousel-slideTitle">
Grohe Essence (23491001)
</span>
</a>
</div>
<div class="carousel-slide swiper-slide" style="width: 242px; margin-right: 10px;">
<a class="carousel-slideLink" href="/preisvergleich/OffersOfProduct/3932904_-concetto-32211001-grohe.html" rel="">
<div class="carousel-slideImageWrapper">
<img class="carousel-slideImage carousel-slideImageFallback" src="//cdn.idealo.com/ipc/95351d/rwd/img/ajax-loader-grey.gif" data-src="//cdn.idealo.com/folder/Product/3932/9/3932904/s2_produktbild_mittel/grohe-concetto-32211001.png" alt="Grohe Concetto (32211001)" width="120" height="100">
<noscript>
&lt;img
class="carousel-slideImage"
src="//cdn.idealo.com/folder/Product/3932/9/3932904/s2_produktbild_mittel/grohe-concetto-32211001.png"
alt="Grohe Concetto (32211001)"
width="120"
height="100"&gt;
</noscript>
</div>
<span class="carousel-slideTitle">
Grohe Concetto (32211001)
</span>
</a>
</div>
<div class="carousel-slide swiper-slide" style="width: 242px; margin-right: 10px;">
<a class="carousel-slideLink" href="/preisvergleich/OffersOfProduct/2378518_-zenta-38670-kludi.html" rel="">
<div class="carousel-slideImageWrapper">
<img class="carousel-slideImage carousel-slideImageFallback" src="//cdn.idealo.com/ipc/95351d/rwd/img/ajax-loader-grey.gif" data-src="//cdn.idealo.com/folder/Product/4925/3/4925378/s2_produktbild_mittel/kludi-zenta-weiss-386709175.png" alt="Kludi Zenta (38670)" width="120" height="100">
<noscript>
&lt;img
class="carousel-slideImage"
src="//cdn.idealo.com/folder/Product/4925/3/4925378/s2_produktbild_mittel/kludi-zenta-weiss-386709175.png"
alt="Kludi Zenta (38670)"
width="120"
height="100"&gt;
</noscript>
</div>
<span class="carousel-slideTitle">
Kludi Zenta (38670)
</span>
</a>
</div>
<div class="carousel-slide swiper-slide" style="width: 242px; margin-right: 10px;">
<a class="carousel-slideLink" href="/preisvergleich/OffersOfProduct/4944765_-objekta-wannen-einhandmischer-326530575-kludi.html" rel="">
<div class="carousel-slideImageWrapper">
<img class="carousel-slideImage carousel-slideImageFallback" src="//cdn.idealo.com/ipc/95351d/rwd/img/ajax-loader-grey.gif" data-src="//cdn.idealo.com/folder/Product/4944/7/4944765/s2_produktbild_mittel/kludi-objekta-wannen-einhandmischer-326530575.png" alt="Kludi Objekta Wannen-Einhandmischer (326530575)" width="120" height="100">
<noscript>
&lt;img
class="carousel-slideImage"
src="//cdn.idealo.com/folder/Product/4944/7/4944765/s2_produktbild_mittel/kludi-objekta-wannen-einhandmischer-326530575.png"
alt="Kludi Objekta Wannen-Einhandmischer (326530575)"
width="120"
height="100"&gt;
</noscript>
</div>
<span class="carousel-slideTitle">
Kludi Objekta Wannen-Einhandmischer (326530575)
</span>
</a>
</div>
<div class="carousel-slide swiper-slide" style="width: 242px; margin-right: 10px;">
<a class="carousel-slideLink" href="/preisvergleich/OffersOfProduct/2340841_-zenta-38660-kludi.html" rel="">
<div class="carousel-slideImageWrapper">
<img class="carousel-slideImage carousel-slideImageFallback" src="//cdn.idealo.com/ipc/95351d/rwd/img/ajax-loader-grey.gif" data-src="//cdn.idealo.com/folder/Product/3450/0/3450060/s2_produktbild_mittel/kludi-zenta-weiss-386609175.png" alt="Kludi Zenta (38660)" width="120" height="100">
<noscript>
&lt;img
class="carousel-slideImage"
src="//cdn.idealo.com/folder/Product/3450/0/3450060/s2_produktbild_mittel/kludi-zenta-weiss-386609175.png"
alt="Kludi Zenta (38660)"
width="120"
height="100"&gt;
</noscript>
</div>
<span class="carousel-slideTitle">
Kludi Zenta (38660)
</span>
</a>
</div>
<div class="carousel-slide swiper-slide" style="width: 242px; margin-right: 10px;">
<a class="carousel-slideLink" href="/preisvergleich/OffersOfProduct/4952996_-e2-wannen-einhandmischer-up-496500575-kludi.html" rel="">
<div class="carousel-slideImageWrapper">
<img class="carousel-slideImage carousel-slideImageFallback" src="//cdn.idealo.com/ipc/95351d/rwd/img/ajax-loader-grey.gif" data-src="//cdn.idealo.com/folder/Product/4952/9/4952996/s2_produktbild_mittel/kludi-e2-wannen-einhandmischer-up-496500575.png" alt="Kludi E2 Wannen-Einhandmischer UP (496500575)" width="120" height="100">
<noscript>
&lt;img
class="carousel-slideImage"
src="//cdn.idealo.com/folder/Product/4952/9/4952996/s2_produktbild_mittel/kludi-e2-wannen-einhandmischer-up-496500575.png"
alt="Kludi E2 Wannen-Einhandmischer UP (496500575)"
width="120"
height="100"&gt;
</noscript>
</div>
<span class="carousel-slideTitle">
Kludi E2 Wannen-Einhandmischer UP (496500575)
</span>
</a>
</div>
<div class="carousel-slide swiper-slide" style="width: 242px; margin-right: 10px;">
<a class="carousel-slideLink" href="/preisvergleich/OffersOfProduct/4949306_-metris-einhebel-wannenmischer-up-31454000-hansgrohe.html" rel="">
<div class="carousel-slideImageWrapper">
<img class="carousel-slideImage carousel-slideImageFallback" src="//cdn.idealo.com/ipc/95351d/rwd/img/ajax-loader-grey.gif" data-src="//cdn.idealo.com/folder/Product/4949/3/4949306/s2_produktbild_mittel/hansgrohe-metris-einhebel-wannenmischer-up-31454000.png" alt="Hansgrohe Metris Einhebel-Wannenmischer UP (31454000)" width="120" height="100">
<noscript>
&lt;img
class="carousel-slideImage"
src="//cdn.idealo.com/folder/Product/4949/3/4949306/s2_produktbild_mittel/hansgrohe-metris-einhebel-wannenmischer-up-31454000.png"
alt="Hansgrohe Metris Einhebel-Wannenmischer UP (31454000)"
width="120"
height="100"&gt;
</noscript>
</div>
<span class="carousel-slideTitle">
Hansgrohe Metris Einhebel-Wannenmischer UP (31454000)
</span>
</a>
</div>
<div class="carousel-slide swiper-slide" style="width: 242px; margin-right: 10px;">
<a class="carousel-slideLink" href="/preisvergleich/OffersOfProduct/1731833_-focus-e-chrom-31945000-hansgrohe.html" rel="">
<div class="carousel-slideImageWrapper">
<img class="carousel-slideImage carousel-slideImageFallback" src="//cdn.idealo.com/ipc/95351d/rwd/img/ajax-loader-grey.gif" data-src="//cdn.idealo.com/folder/Product/1731/8/1731833/s2_produktbild_mittel/hansgrohe-focus-e-chrom-31945000.png" alt="Hansgrohe Focus E� (Chrom, 31945000)" width="120" height="100">
<noscript>
&lt;img
class="carousel-slideImage"
src="//cdn.idealo.com/folder/Product/1731/8/1731833/s2_produktbild_mittel/hansgrohe-focus-e-chrom-31945000.png"
alt="Hansgrohe Focus E� (Chrom, 31945000)"
width="120"
height="100"&gt;
</noscript>
</div>
<span class="carousel-slideTitle">
Hansgrohe Focus E� (Chrom, 31945000)
</span>
</a>
</div>
</div>
<span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span></div><button class="carousel-navigationButton icon-arrow-right-thin carousel-navigationButton--next" type="button" aria-disabled="false" tabindex="0" role="button" aria-label="Next slide"></button><button class="carousel-navigationButton icon-arrow-left-thin carousel-navigationButton--prev carousel-navigationButton--disabled" type="button" aria-disabled="true" tabindex="0" role="button" aria-label="Previous slide"></button>
</div>
</div>
</section>
<div class="productFurtherTags row">
<div class="small-12 columns">
<div class="productFurtherTags-title">Weitere Produkte zu den Stichworten:</div>
<a class="productFurtherTags-tag" href="/preisvergleich/ProductCategory/18928F1744539.html" rel="" data-wt-click="{"id" : "list.alternative_categories.click"}">
Grohe Grohtherm
</a>
<a class="productFurtherTags-tag" href="https://www.idealo.at/preisvergleich/Hersteller/59762.html" rel="" data-wt-click="{"id" : "list.alternative_categories.click"}">
Grohe
</a>
<a class="productFurtherTags-tag" href="/preisvergleich/ProductCategory/18928F1744730.html" rel="" data-wt-click="{"id" : "list.alternative_categories.click"}">
217 Grohe Wannenarmaturen
</a>
<a class="productFurtherTags-tag" href="/preisvergleich/ProductCategory/18928F1744730-1748515.html" rel="" data-wt-click="{"id" : "list.alternative_categories.click"}">
123 Grohe Einhand-Wannenbatterien
</a>
</div>
</div>
<div id="Datenblatt" class="datasheet">
<ul class="datasheet-list">
<li class="datasheet-listItem datasheet-listItem--properties row">
<span class="datasheet-listItemKey small-6 columns">
Marke
</span>
<span class="datasheet-listItemValue small-6 columns">
Grohe
</span>
</li>
<li class="datasheet-listItem datasheet-listItem--properties row">
<span class="datasheet-listItemKey small-6 columns">
Produktart
</span>
<span class="datasheet-listItemValue small-6 columns">
Einhand-Wannenbatterie
</span>
</li>
<li class="datasheet-listItem datasheet-listItem--properties row">
<span class="datasheet-listItemKey small-6 columns">
Serie
</span>
<span class="datasheet-listItemValue small-6 columns">
Grohe Grohtherm
</span>
</li>
<li class="datasheet-listItem datasheet-listItem--group row">
Oberfl�che &amp; Design
</li>
<li class="datasheet-listItem datasheet-listItem--properties row">
<span class="datasheet-listItemKey small-6 columns">
Oberfl�chendekor
</span>
<span class="datasheet-listItemValue small-6 columns">
Chrom
</span>
</li>
<li class="datasheet-listItem datasheet-listItem--group row">
Bedienung &amp; Funktionen
</li>
<li class="datasheet-listItem datasheet-listItem--properties row">
<span class="datasheet-listItemKey small-6 columns">
Bedienungsart
</span>
<span class="datasheet-listItemValue small-6 columns">
Bedienungshebel
</span>
</li>
<li class="datasheet-listItem datasheet-listItem--group row">
Montage
</li>
<li class="datasheet-listItem datasheet-listItem--properties row">
<span class="datasheet-listItemKey small-6 columns">
Montage
</span>
<span class="datasheet-listItemValue small-6 columns">
Wandmontage, Unterputzmontage
</span>
</li>
<li class="datasheet-listItem datasheet-listItem--group row">
Ausstattung
</li>
<li class="datasheet-listItem datasheet-listItem--properties row">
<span class="datasheet-listItemKey small-6 columns">
Ausstattung
</span>
<span class="datasheet-listItemValue small-6 columns">
mit Temperaturbegrenzer
</span>
</li>
<li class="datasheet-listItem datasheet-listItem--group row">
Weitere Eigenschaften
</li>
<li class="datasheet-listItem datasheet-listItem--properties row">
<span class="datasheet-listItemKey small-6 columns">
Info
</span>
<span class="datasheet-listItemValue small-6 columns">
Aquadimmer mit Mehrfachfunktion: Absperrung und Mengenregulierung / Umstellung f�r 2 Abg�nge / Wandrosette mit verdeckter Rosetten- und Schaftabdichtung / Fertigmontageset f�r Unterputz-Einbauk�rper (35 500 000)
</span>
</li>
</ul>
</div>
<div id="Meinungen" class="hide productReviews productReviews-writeReview row">
<h2 class="productReviews-title small-12 columns">
Kundenmeinungen auf idealo
</h2>
<div class="small-12 columns">
<p class="productReviews-writeReviewText">
Verfasse die erste Meinung.<br>
</p>
<button class="writeReview button-ghost button-ghost--blue" data-overlay="{
&quot;closeCaption&quot; : &quot;Zur�ck&quot;,
&quot;contentLoad&quot; : &quot;/mvc/RwdProductOpinion/product/2317555&quot;,
&quot;contentLoadBy&quot; : &quot;ajax&quot;,
&quot;contentPaddingLeft&quot; : &quot;1rem&quot;,
&quot;contentPaddingRight&quot; : &quot;1rem&quot;,
&quot;eventsOn&quot; : &quot;click&quot;,
&quot;webtrekkPrefix&quot; : &quot;writereview&quot;,
&quot;triggerOnOpen&quot; : &quot;writeReviewOpen&quot;
}">
Produktmeinung auf idealo verfassen
</button>
</div>
</div>
<div class="row">
<div class="small-12 columns">
<div id="ad-banner-wide" title="Anzeige" style="" data-google-query-id="CPiI_pe909QCFZGPGwodGSkGYg"><div id="google_ads_iframe_/2603892/IPC-Super-at_0__container__" style="border: 0pt none;"><iframe id="google_ads_iframe_/2603892/IPC-Super-at_0" title="3rd party ad content" name="google_ads_iframe_/2603892/IPC-Super-at_0" width="728" height="90" scrolling="no" marginwidth="0" marginheight="0" frameborder="0" srcdoc="" style="border: 0px; vertical-align: bottom;"></iframe></div></div>
</div>
</div>
<div id="WishListFullOverlayTemplate" class="wishlist-full-overlay hide" data-overlay="
{
&quot;titleSize&quot;: &quot;large&quot;,
&quot;contentLoad&quot;: &quot;#WishListFullOverlayTemplate&quot;,
&quot;contentLoadBy&quot;: &quot;selector&quot;,
&quot;contentPaddingLeft&quot;: &quot;1rem&quot;,
&quot;contentPaddingTop&quot;: &quot;2.5rem&quot;,
&quot;contentPaddingRight&quot;: &quot;1rem&quot;,
&quot;contentPaddingBottom&quot;: &quot;2rem&quot;,
&quot;isAlwaysModal&quot;: true,
&quot;webtrekkPrefix&quot;: &quot;favourites.full-layer-sso&quot;,
&quot;triggerOpenEvent&quot;: &quot;IpcWishlistFullEvent&quot;,
&quot;triggerCloseEvent&quot;: &quot;closeOverlay&quot;
}
">
<div class="row">
<div class="column small-12">
<div class="statusHeader">Merkzettel voll</div>
</div>
</div>
<div class="row">
<div class="column small-12">
<p class="mb-12">Zurzeit kann der idealo Merkzettel leider nur 24 Produkte aufnehmen.<br>
Bitte l�sche Produkte von Deinem Merkzettel, um neue Produkte hinzuf�gen zu k�nnen.</p>
</div>
</div>
<div class="row dialogButtons">
<div class="column small-12 large-6">
<a id="backToWishListNoSso" href="/merkzettel" class="button expand" data-wt-click="{&quot;id&quot;: &quot;favourites.full-layer.gotowishlist&quot;}">Zum Merkzettel</a>
</div>
<div class="column small-12 large-6">
<a id="closeDialogButtonNoSso" class="button expand cancel" data-wt-click="{&quot;id&quot;: &quot;favourites.full-layer.cancel&quot;}" onclick="$(document).trigger("closeOverlay")">Schlie�en</a>
</div>
</div>
</div>
<div id="WishListDisabledOverlayTemplate" class="hide" data-overlay="
{
&quot;titleSize&quot;: &quot;large&quot;,
&quot;contentLoad&quot;: &quot;#WishListDisabledOverlayTemplate&quot;,
&quot;contentLoadBy&quot;: &quot;selector&quot;,
&quot;contentPaddingLeft&quot;: &quot;1rem&quot;,
&quot;contentPaddingTop&quot;: &quot;3rem&quot;,
&quot;contentPaddingRight&quot;: &quot;1rem&quot;,
&quot;contentPaddingBottom&quot;: &quot;2rem&quot;,
&quot;isAlwaysModal&quot;: true,
&quot;webtrekkPrefix&quot;: &quot;favourites.disabled-layer&quot;,
&quot;triggerOpenEvent&quot;: &quot;IpcWishlistServiceDisabledEvent&quot;,
&quot;triggerCloseEvent&quot;: &quot;closeOverlay&quot;
}
">
<div class="row wishlistOverlay">
<div class="column small-12 large-4 text-center">
<img class="wishlistOverlay-image" src="//cdn.idealo.com/ipc/95351d/rwd/img/hard_hat_owl.png" alt="">
</div>
<div class="column small-12 large-8">
<div class="wishlistOverlay-headline">Es ist ein Problem aufgetreten.</div>
<p class="wishlistOverlay-message">Wir arbeiten an einer L�sung.<br>
Versuche es bitte sp�ter noch einmal.</p>
</div>
</div>
</div>
</main>
<footer class="pageFooter-wrapper">
<div class="pageFooter-bottom">
<div class="text-center row">
<div class="small-12 columns">
<div class="pageFooter-app">
<p class="pageFooter-appTitle">
Bringe den idealo Preisvergleich auf Dein Smartphone!
</p>
<div class="pageFooter-appBadge">
<a class="pageFooter-appBadgeLink" data-wt="footer.idealoapp.ios" href="//app.adjust.com/bahtt2" target="_blank">
<img class="pageFooter-appBadgeLinkImage pageFooter-appBadgeLinkImage--ios" src="//cdn.idealo.com/ipc/95351d/rwd/img/logo-appstore.png" alt="Bringe den idealo Preisvergleich auf Dein Smartphone! | Apple App Store" height="80" width="270">
</a>
<a class="pageFooter-appBadgeLink" data-wt="footer.idealoapp.android" href="//app.adjust.com/rq3jc9" target="_blank">
<img class="pageFooter-appBadgeLinkImage pageFooter-appBadgeLinkImage--android" src="//cdn.idealo.com/ipc/95351d/rwd/img/logo-playstore.png" alt="Bringe den idealo Preisvergleich auf Dein Smartphone! | Google Play" height="80" width="270">
</a>
</div>
</div>
<div class="pageFooter-gtac small-12 columns">
<a class="pageFooter-gtacLink pageFooter-link" data-wt="footer.privacypolicy" href="/preisvergleich/Datenschutz.html">
Datenschutz
</a>
<a class="pageFooter-gtacLink pageFooter-link" data-wt="footer.terms" href="/preisvergleich/AGB.html">
Impressum / AGB
</a>
</div>
<p class="pageFooter-disclaimer small-12 columns">
<a class="pageFooter-disclaimerLink pageFooter-link" data-wt="footer.disclaimer" href="/preisvergleich/hinweis.html" target="_blank">
* Alle Preisangaben in Euro inkl. MwSt, ggf. zzgl. Versand. Zwischenzeitliche �nderung der Preise, Rangfolge, Lieferzeit und -kosten m�glich.
</a>
</p>
</div>
</div>
</div>
</footer>
</div>
</div>
<nav class="categoryNavigation" data-category-navigation="{
&quot;$i18n&quot; : {
&quot;back&quot; : &quot;Kategorien&quot;,
&quot;close&quot; : &quot;Alle Kategorien&quot;,
&quot;more&quot; : &quot;mehr&quot;
}
}" data-sitemap-url="/mvc/onDemandCategoryNavigation/18928">
<div class="categoryNavigation-header clearfix">
<span class="categoryNavigation-headerClose icon-cancel-thin">
Kategorien
</span>
<span class="categoryNavigation-headerBack icon-arrow-left-thin">
Alle Kategorien
</span>
<span class="categoryNavigation-headerSearch icon-search right"></span>
</div>
<div class="categoryNavigation-wrapper row clearfix">
<div class="categoryNavigation-main">
<ul class="categoryNavigation-list categoryNavigation-list--main">
<li class="categoryNavigation-listItem categoryNavigation-listItem--active">
<a class="categoryNavigation-listItemLink" href="/preisvergleich/SubProductCategory/3686.html" rel="">
Heimwerken &amp; Garten
</a>
<ul class="categoryNavigation-list categoryNavigation-list--sub categoryNavigation-list--subShow row">
<li class="categoryNavigation-listItem">
<a class="categoryNavigation-listItemLink" href="/preisvergleich/SubProductCategory/6812.html" rel="">
Werkzeuge
</a>
</li>
<li class="categoryNavigation-listItem">
<a class="categoryNavigation-listItemLink" href="/preisvergleich/SubProductCategory/9612.html" rel="">
Garten
</a>
</li>
<li class="categoryNavigation-listItem">
<a class="categoryNavigation-listItemLink" href="/preisvergleich/SubProductCategory/12977.html" rel="">
Heizen &amp; L�ften
</a>
</li>
<li class="categoryNavigation-listItem">
<a class="categoryNavigation-listItemLink" href="/preisvergleich/SubProductCategory/18933.html" rel="">
Schwimmbecken &amp; Pooltechnik
</a>
</li>
<li class="categoryNavigation-listItem">
<a class="categoryNavigation-listItemLink" href="/preisvergleich/SubProductCategory/12852.html" rel="">
Sicherheitstechnik
</a>
</li>
<li class="categoryNavigation-listItem">
<a class="categoryNavigation-listItemLink" href="/preisvergleich/SubProductCategory/12953.html" rel="">
Sanit�r &amp; Armaturen
</a>
</li>
<li class="categoryNavigation-listItem">
<a class="categoryNavigation-listItemLink" href="/preisvergleich/SubProductCategory/12954.html" rel="">
Elektrik
</a>
</li>
<li class="categoryNavigation-listItem">
<a class="categoryNavigation-listItemLink" href="/preisvergleich/SubProductCategory/12972.html" rel="">
Malern &amp; Renovieren
</a>
</li>
<li class="categoryNavigation-listItem">
<a class="categoryNavigation-listItemLink" href="/preisvergleich/SubProductCategory/9845.html" rel="">
Baubedarf
</a>
</li>
<li class="categoryNavigation-listItem">
<a class="categoryNavigation-listItemLink" href="/preisvergleich/SubProductCategory/9176.html" rel="">
Gartenm�bel
</a>
</li>
<li class="categoryNavigation-listItem">
<a class="categoryNavigation-listItemLink" href="/preisvergleich/ProductCategory/7773.html" rel="">
Rasenm�her
</a>
</li>
<li class="categoryNavigation-listItem">
<a class="categoryNavigation-listItemLink" href="/preisvergleich/ProductCategory/3687.html" rel="">
Akkuschrauber
</a>
</li>
<li class="categoryNavigation-listItem">
<a class="categoryNavigation-listItemLink" href="/preisvergleich/ProductCategory/9652.html" rel="">
Hochdruckreiniger
</a>
</li>
<li class="categoryNavigation-listItem">
<a class="categoryNavigation-listItemLink" href="/preisvergleich/ProductCategory/3706.html" rel="">
Schleifmaschinen
</a>
</li>
<li class="categoryNavigation-listItem">
<a class="categoryNavigation-listItemLink" href="/preisvergleich/ProductCategory/3748.html" rel="">
Motors�gen
</a>
</li>
<li class="categoryNavigation-listItem">
<a class="categoryNavigation-listItemLink" href="/preisvergleich/ProductCategory/11572.html" rel="">
Sp�len
</a>
</li>
<li class="categoryNavigation-listItem">
<a class="categoryNavigation-listItemLink" href="/preisvergleich/ProductCategory/15397.html" rel="">
Bohrmaschinen
</a>
</li>
<li class="categoryNavigation-listItem">
<a class="categoryNavigation-listItemLink" href="/preisvergleich/SubProductCategory/18241.html" rel="">
Erneuerbare Energien
</a>
</li>
<li class="categoryNavigation-listItem">
<a class="categoryNavigation-listItemLink" href="/preisvergleich/ProductCategory/11932.html" rel="">
K�chenarmaturen
</a>
</li>
<li class="categoryNavigation-listItem">
<a class="categoryNavigation-listItemLink" href="/preisvergleich/ProductCategory/11294.html" rel="">
Kamine &amp; �fen
</a>
</li>
<li class="categoryNavigation-listItem">
<a class="categoryNavigation-listItemLink" href="/preisvergleich/ProductCategory/18565.html" rel="">
Werkstatteinrichtung
</a>
</li>
<li class="categoryNavigation-listItem">
<a class="categoryNavigation-listItemLink" href="/preisvergleich/ProductCategory/12832.html" rel="">
Elektroinstallation
</a>
</li>
<li class="categoryNavigation-listItem">
<a class="categoryNavigation-listItemLink" href="/preisvergleich/ProductCategory/11532.html" rel="">
Vertikutierer
</a>
</li>
<li class="categoryNavigation-listItem">
<a class="categoryNavigation-listItemLink" href="/preisvergleich/ProductCategory/12875.html" rel="">
�berwachungskameras
</a>
</li>
<li class="categoryNavigation-listItem">
<a class="categoryNavigation-listItemLink" href="/preisvergleich/SubProductCategory/23595.html" rel="">
Messtechnik
</a>
</li>
<li class="categoryNavigation-listItem">
<a class="categoryNavigation-listItemLink" href="/preisvergleich/ProductCategory/25795.html" rel="">
Smarthome-Zentralen
</a>
</li>
<li class="categoryNavigation-listItem">
<a class="categoryNavigation-listItemLink" href="/preisvergleich/ProductCategory/19144.html" rel="">
Kettens�gen
</a>
</li>
<li class="categoryNavigation-listItem">
<a class="categoryNavigation-listItemLink" href="/preisvergleich/ProductCategory/13752.html" rel="">
Messger�te
</a>
</li>
<li class="categoryNavigation-listItem">
<a class="categoryNavigation-listItemLink" href="/preisvergleich/ProductCategory/17515.html" rel="">
WCs
</a>
</li>
<li class="categoryNavigation-listItem">
<a class="categoryNavigation-listItemLink" href="/preisvergleich/ProductCategory/12872.html" rel="">
Rauchmelder
</a>
</li>
<li class="categoryNavigation-listItem">
<a class="categoryNavigation-listItemLink" href="/preisvergleich/ProductCategory/21737.html" rel="">
Gartenst�hle
</a>
</li>
<li class="categoryNavigation-listItem">
<a class="categoryNavigation-listItemLink" href="/preisvergleich/ProductCategory/13013.html" rel="">
Gartenlampen
</a>
</li>
<li class="categoryNavigation-listItem">
<a class="categoryNavigation-listItemLink" href="/preisvergleich/ProductCategory/13472.html" rel="">
Gartenh�user
</a>
</li>
<li class="categoryNavigation-listItem">
<a class="categoryNavigation-listItemLink" href="/preisvergleich/ProductCategory/18926.html" rel="">
Duscharmaturen
</a>
</li>
<li class="categoryNavigation-listItem">
<a class="categoryNavigation-listItemLink" href="/preisvergleich/ProductCategory/21738.html" rel="">
Gartentische
</a>
</li>
<li class="categoryNavigation-listItem categoryNavigation-listItem--more">
<a class="categoryNavigation-listItemLink" href="/preisvergleich/AlleTestProdukte/18928.html" rel="">
Wannenarmaturen im Test
</a>
</li>
</ul>
</li>
</ul>
</div>
<div class="categoryNavigation-sub">
</div>
</div>
</nav>
<script src="//cdn.idealo.com/ipc/95351d/rwd/dist/js/ipc.js"></script>
<script>
if (typeof webtrekkV3 !== "undefined") {
var webtrekkConfig = {"trackId":"864254837657645","trackDomain":"idealo01.webtrekk.net","domain":"REGEXP:(.*\\.)?www1?\\.idealo\\.(de|at|es|co.uk|in)","cookie":"1","mediaCode":"wt_mc","contentId":"","executePluginFunction":"wt_frequencyanalysis"},
wtCustomParameter = {"2":"18","9":"numberOfBestTotalPriceOffers:1","11":"2"},
wtCustomParameterLastSeen = "numberOfLastSeenProducts:" +
(navigator.cookieEnabled && localStorage.getItem("recentProducts") ? JSON.parse(localStorage.getItem("recentProducts")).length : 0);
wt = new webtrekkV3({"linkTrack":"standard","form":"","contentId":"at.pv.heimwerken_und_garten.sanitaer_und_armaturen.badarmaturen.wannenarmaturen.oop"});
wt.contentGroup = {"1":"at","2":"pv","3":"heimwerken_und_garten","4":"sanitaer_und_armaturen","5":"badarmaturen","7":"wannenarmaturen","10":"oop"};
wt.customSessionParameter = {"1":"oop_by_opensearch:B,oop_rwd_de_2:A,pcat_by_opensearch_de:B,rwd_filter_sidebar:A,search_dk_boost:A,unified_header:A","2":"false","5":"oop_by_opensearch:B;oop_rwd_de_2:A;pcat_by_opensearch_de:B;rwd_filter_sidebar:A;search_dk_boost:A;unified_header:A"};
wt.cookieEidTimeout = 24; // in month
// Update Promobox customParameter according to Promobox visibility
wt.customParameter = $(".oopStage-promoboxOuter").is(":visible") ? wtCustomParameter :
function() { delete wtCustomParameter[10]; return wtCustomParameter; }();
/*TODO: remove when done with SOOP-102*/
wt.customParameter[9] = wt.customParameter[9] ? wt.customParameter[9] + ";" + wtCustomParameterLastSeen : wtCustomParameterLastSeen;
wt.sendinfo();
} else {
wt = { sendinfo: function(){} }; // prevent wt errors if webtrekk is not available
$.publish("track.error.debug", new Error("Webtrekk is blocked"));
}
</script>
<noscript>
&lt;img class="hide" src="//idealo01.webtrekk.net/864254837657645/wt.pl?p=322,at.pv.heimwerken_und_garten.sanitaer_und_armaturen.badarmaturen.wannenarmaturen.oop" width="1" height="1" alt=""&gt;
</noscript>
<script src="//cdn.idealo.com/ipc/95351d/rwd/dist/js/ipc-rum.js" data-rum="{&quot;site&quot;:&quot;www.idealo.at&quot;,&quot;target&quot;:&quot;//l.idealo.com/api/stats&quot;,&quot;distribution&quot;:&quot;10&quot;,&quot;cycle&quot;:&quot;7&quot;,&quot;page_template&quot;:&quot;OffersOfProduct&quot;}"></script>
<img class="hide" src="/preisvergleich/sp.html?ts=1498204095901" width="1" height="1" alt="">


<script type="text/javascript" id="">!function(b,e,f,g,a,c,d){b.fbq||(a=b.fbq=function(){a.callMethod?a.callMethod.apply(a,arguments):a.queue.push(arguments)},b._fbq||(b._fbq=a),a.push=a,a.loaded=!0,a.version="2.0",a.queue=[],c=e.createElement(f),c.async=!0,c.src=g,d=e.getElementsByTagName(f)[0],d.parentNode.insertBefore(c,d))}(window,document,"script","//connect.facebook.net/en_US/fbevents.js");fbq("init","1766534123558093");fbq("track","PageView");</script><script type="text/javascript" id="">!function(b,c,d,a){b.twq||(a=b.twq=function(){a.exe?a.exe.apply(a,arguments):a.queue.push(arguments)},a.version="1",a.queue=[],t=c.createElement(d),t.async=!0,t.src="//static.ads-twitter.com/uwt.js",s=c.getElementsByTagName(d)[0],s.parentNode.insertBefore(t,s))}(window,document,"script");twq("init","undefined");twq("track","PageView");</script><script type="text/javascript" id="">twq("track","ViewContent",{content_category:"Heimwerken \x26 Garten \x3e Sanit�r \x26 Armaturen \x3e Badarmaturen \x3e Wannenarmaturen",content_ids:google_tag_manager["GTM-PDXTT2"].macro("gtm85"),content_name:"Grohe Grohtherm 3000 C Thermostat (19468000)",content_type:"product"});</script><script type="text/javascript" id="">hj("trigger","z_product_category_id_"+google_tag_manager["GTM-PDXTT2"].macro("gtm89")[0]);</script><script type="text/javascript" id="">var isUserLoggedIn=google_tag_manager["GTM-PDXTT2"].macro("gtm91")?"z_user_logged_in_true":"z_user_logged_in_false";hj("trigger",isUserLoggedIn);</script><script type="text/javascript" id="">google_tag_manager["GTM-PDXTT2"].macro("gtm93").forEach(function(a){hj("trigger","z_optimizely_variant_"+a)});</script><script type="text/javascript" id="">google_tag_manager["GTM-PDXTT2"].macro("gtm95").forEach(function(a){hj("tagRecording",["z_optimizely_variant_"+a])});</script><script type="text/javascript" id="">hj("tagRecording",["z_product_category_id_"+google_tag_manager["GTM-PDXTT2"].macro("gtm97")[0]]);</script><script type="text/javascript" id="">(function(){var a=google_tag_manager["GTM-PDXTT2"].macro("gtm99")?"z_user_logged_in_true":"z_user_logged_in_false";hj("tagRecording",[a])})();</script><script type="text/javascript" id="">"undefined"!==typeof hj&&(hj("tagRecording",["page_oop"]),hj("trigger","page_oop"));</script><iframe name="_hjRemoteVarsFrame" title="_hjRemoteVarsFrame" id="_hjRemoteVarsFrame" src="https://vars.hotjar.com/rcj-99d43ead6bdf30da8ed5ffcb4f17100c.html" style="display: none !important; width: 1px !important; height: 1px !important; opacity: 0 !important; pointer-events: none !important;"></iframe><script type="text/javascript" id="">fbq("track","ViewContent",{content_category:"Heimwerken \x26 Garten \x3e Sanit�r \x26 Armaturen \x3e Badarmaturen \x3e Wannenarmaturen",content_ids:google_tag_manager["GTM-PDXTT2"].macro("gtm169"),content_name:google_tag_manager["GTM-PDXTT2"].macro("gtm170"),content_type:"product"});</script><div id="ads"></div><script src="https://analytics.twitter.com/i/adsct?p_id=Twitter&amp;p_user_id=0&amp;txn_id=undefined&amp;events=%5B%5B%22pageview%22%2Cnull%5D%5D&amp;tw_sale_amount=0&amp;tw_order_quantity=0&amp;tw_iframe_status=0&amp;tpx_cb=twttr.conversion.loadPixels" type="text/javascript"></script><script src="https://analytics.twitter.com/i/adsct?p_id=Twitter&amp;p_user_id=0&amp;txn_id=undefined&amp;tw_product_id=2317555&amp;events=%5B%5B%22viewcontent%22%2C%7B%22content_category%22%3A%22Heimwerken%20%26%20Garten%20%3E%20Sanit%C3%A4r%20%26%20Armaturen%20%3E%20Badarmaturen%20%3E%20Wannenarmaturen%22%2C%22content_ids%22%3A%5B%222317555%22%5D%2C%22content_name%22%3A%22Grohe%20Grohtherm%203000%20C%20Thermostat%20(19468000)%22%2C%22content_type%22%3A%22product%22%7D%5D%5D&amp;tw_sale_amount=0&amp;tw_order_quantity=0&amp;tw_iframe_status=0&amp;tpx_cb=twttr.conversion.loadPixels" type="text/javascript"></script><div id="criteo-tags-div" style="display: none;"><iframe height="0" width="0" src="//dis.eu.criteo.com/dis/dis.aspx?p=30744&amp;cb=65234798192&amp;ref=https%3A%2F%2Fwww.idealo.at%2Fpreisvergleich%2FOffersOfProduct%2F2317555_-grohtherm-3000-c-thermostat-19468000-grohe.html&amp;sc_r=1536x864&amp;sc_d=24" style="display: none;"></iframe><script async="true" type="text/javascript" src="https://sslwidget.criteo.com/event?a=30744&amp;v=4.1.0&amp;p0=e%3Dce%26m%3D%255B%255D&amp;p1=e%3Dexd%26site_type%3Dd&amp;p2=e%3Dvc%26id%3D1953786785%26p%3D%255Bi%25253D2317555%252526pr%25253D1%252526q%25253D1%255D&amp;p3=e%3Ddis&amp;adce=1"></script><iframe height="0" width="0" src="//dis.eu.criteo.com/dis/dis.aspx?p=30744&amp;cb=43187321217&amp;ref=https%3A%2F%2Fwww.idealo.at%2Fpreisvergleich%2FOffersOfProduct%2F2317555_-grohtherm-3000-c-thermostat-19468000-grohe.html&amp;sc_r=1536x864&amp;sc_d=24" style="display: none;"></iframe><script async="true" type="text/javascript" src="https://sslwidget.criteo.com/event?a=30744&amp;v=4.1.0&amp;p0=e%3Dce%26m%3D%255B%255D&amp;p1=e%3Dexd%26site_type%3Dd&amp;p2=e%3Dvc%26id%3D1447932847%26p%3D%255Bi%25253D2317555%252526pr%25253D1%252526q%25253D1%255D&amp;p3=e%3Ddis&amp;adce=1"></script><iframe height="0" width="0" src="//dis.eu.criteo.com/dis/dis.aspx?p=30744&amp;cb=82627385050&amp;ref=https%3A%2F%2Fwww.idealo.at%2Fpreisvergleich%2FOffersOfProduct%2F2317555_-grohtherm-3000-c-thermostat-19468000-grohe.html&amp;sc_r=1536x864&amp;sc_d=24" style="display: none;"></iframe></div><script type="text/javascript" id="">(function(){var c=google_tag_manager[google_tag_manager["GTM-PDXTT2"].macro("gtm227")];try{var b=window.performance.timing,a=b.domComplete-b.navigationStart,b="",b=1E3>a?"0-1 seconds":2E3>a?"1-2 seconds":3E3>a?"2-3 seconds":4E3>a?"3-4 seconds":5E3>a?"4-5 seconds":6E3>a?"5-6 seconds":1E4>a?"6-10 seconds":"10+ seconds";c.dataLayer.set("pageLoadBucket",b);c.dataLayer.set("pageLoadTime",a/1E3);c.onHtmlSuccess(228)}catch(d){console.log(d),c.onHtmlFailure(228)}})();</script><iframe id="google_osd_static_frame_7408670158112" name="google_osd_static_frame" style="display: none; width: 0px; height: 0px;"></iframe><script type="text/javascript" id="">fbq("track","Purchase",{content_category:"Heimwerken \x26 Garten \x3e Sanit�r \x26 Armaturen \x3e Badarmaturen \x3e Wannenarmaturen",content_ids:google_tag_manager["GTM-PDXTT2"].macro("gtm349"),content_name:"Grohe Grohtherm 3000 C Thermostat (19468000)",content_type:"product",value:google_tag_manager["GTM-PDXTT2"].macro("gtm353"),currency:"EUR"});</script><script type="text/javascript" id="">twq("track","Purchase",{value:"525",currency:"EUR",content_ids:google_tag_manager["GTM-PDXTT2"].macro("gtm358"),content_category:"Heimwerken \x26 Garten \x3e Sanit�r \x26 Armaturen \x3e Badarmaturen \x3e Wannenarmaturen",content_name:"Grohe Grohtherm 3000 C Thermostat (19468000)",content_type:"product"});</script><script type="text/javascript" id="">(function(optimizely){var eventName="offer.price.leadout".indexOf("leadout")!==-1?"oop_leadout_universal":"oop_checkout_start_universal";optimizely.push(["trackEvent",eventName])})(window.optimizely||[]);</script>
<script src="https://analytics.twitter.com/i/adsct?p_id=Twitter&amp;p_user_id=0&amp;txn_id=undefined&amp;tw_sale_amount=525&amp;tw_product_id=2317555&amp;events=%5B%5B%22purchase%22%2C%7B%22value%22%3A%22525%22%2C%22currency%22%3A%22EUR%22%2C%22content_ids%22%3A%5B%222317555%22%5D%2C%22content_category%22%3A%22Heimwerken%20%26%20Garten%20%3E%20Sanit%C3%A4r%20%26%20Armaturen%20%3E%20Badarmaturen%20%3E%20Wannenarmaturen%22%2C%22content_name%22%3A%22Grohe%20Grohtherm%203000%20C%20Thermostat%20(19468000)%22%2C%22content_type%22%3A%22product%22%7D%5D%5D&amp;tw_order_quantity=0&amp;tw_iframe_status=0&amp;tpx_cb=twttr.conversion.loadPixels" type="text/javascript"></script><script type="text/javascript" id="">fbq("track","Purchase",{content_category:"Heimwerken \x26 Garten \x3e Sanit�r \x26 Armaturen \x3e Badarmaturen \x3e Wannenarmaturen",content_ids:google_tag_manager["GTM-PDXTT2"].macro("gtm472"),content_name:"Grohe Grohtherm 3000 C Thermostat (19468000)",content_type:"product",value:google_tag_manager["GTM-PDXTT2"].macro("gtm476"),currency:"EUR"});</script><script type="text/javascript" id="">twq("track","Purchase",{value:"600",currency:"EUR",content_ids:google_tag_manager["GTM-PDXTT2"].macro("gtm481"),content_category:"Heimwerken \x26 Garten \x3e Sanit�r \x26 Armaturen \x3e Badarmaturen \x3e Wannenarmaturen",content_name:"Grohe Grohtherm 3000 C Thermostat (19468000)",content_type:"product"});</script><script type="text/javascript" id="">(function(optimizely){var eventName="offer.title.leadout".indexOf("leadout")!==-1?"oop_leadout_universal":"oop_checkout_start_universal";optimizely.push(["trackEvent",eventName])})(window.optimizely||[]);</script>
<script src="https://analytics.twitter.com/i/adsct?p_id=Twitter&amp;p_user_id=0&amp;txn_id=undefined&amp;tw_sale_amount=600&amp;tw_product_id=2317555&amp;events=%5B%5B%22purchase%22%2C%7B%22value%22%3A%22600%22%2C%22currency%22%3A%22EUR%22%2C%22content_ids%22%3A%5B%222317555%22%5D%2C%22content_category%22%3A%22Heimwerken%20%26%20Garten%20%3E%20Sanit%C3%A4r%20%26%20Armaturen%20%3E%20Badarmaturen%20%3E%20Wannenarmaturen%22%2C%22content_name%22%3A%22Grohe%20Grohtherm%203000%20C%20Thermostat%20(19468000)%22%2C%22content_type%22%3A%22product%22%7D%5D%5D&amp;tw_order_quantity=0&amp;tw_iframe_status=0&amp;tpx_cb=twttr.conversion.loadPixels" type="text/javascript"></script></body>
');
	}
	
	
}