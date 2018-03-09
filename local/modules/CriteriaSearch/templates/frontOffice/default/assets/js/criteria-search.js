jQuery(function($){

///////////// KONFIGURATOR MOBILE ///////////////
    if (window.jQuery) {
        // jQuery is loaded  
        function createMobileMenu(){
            $( ".category-head" ).each(function( index ) {
                $('<div class="mobileFilterItem">'+
                    '<button class="btn btn-primary col-lg-12 col-md-12 col-sm-12 col-xs-12" type="button" data-toggle="collapse" data-target="#mobile'+
                        $( this ).attr('data-feature')+
                        '" aria-expanded="false" aria-controls="mobile'+$( this ).attr('data-feature')+'">'+
                        $( this ).text() +
                    '</button>'+
                    '<div class="collapse" id="mobile'+$( this ).attr('data-feature')+'">'+
                        '<div class="card card-block">'+
                            '<div class="tab-content col-md-12 options_collection">'+
                                $('#'+$( this ).attr('data-feature')).html()+
                            '</div>'+
                        '</div>'+
                    '</div>'+
                '</div>').appendTo('#mobileFilter');
            });

             $("#mobileFilter .mobileFilterItem .options_collection .filter-option .checkbox-box .checkbox :checkbox").each(function( index ) {
                $( this).attr("id", "mobile-"+$( this).attr("id")); 
            });

            $("#mobileFilter .mobileFilterItem .options_collection .filter-option .checkbox-box .checkbox label").each(function( index ) {
                $( this ).attr("for", "mobile-"+$( this).attr("for")); 
            });
        }

        function checkWidth() {
            var windowWidth = window.innerWidth;
            if (windowWidth < 992) {
                if( $( ".mobile_filter_row #mobileFilter" ).children().length == 0){
                    createMobileMenu();
                    if ($('.mobileFilterItem').length == 0) {
                        $('#mobileButtonKonfigurator').hide();
                    }
                }
                $(".filter_row").hide();
                $(".mobile_filter_row").show();
            } else {
                $(".filter_row").show();
                $(".mobile_filter_row").hide();
            }
        }

        checkWidth();

        $(window).resize(checkWidth);
    }
//////////// END KONFIGURATOR MOBILE ////////////

    if ( $("#price-filter").length ) {
        $("#price-filter").slider({}).on('slideStop', function(e) {
            $("input[name=price_min]").val(e.value[0]);
            $("input[name=price_max]").val(e.value[1]);
            updateUrl();
            displaySearchProductList();
        });
    }

    $(".select-search").multiselect({
        nonSelectedText: $("#nonSelectedText").html(),
        allSelectedText: $("#allSelectedText").html(),
        nSelectedText: $("#nSelectedText").html()
    });

    var criteria = getURLParameter('criteria');
    var search_form = $('#criteria-search-form');

    if (criteria == "true") {
        fillForm(false);
    }

    var searchTimer = null;

    $('.input-search').on('change', function(e) {
        if($(this).attr('id') != undefined) {
            
            //Old Event Listener parrent
            var check = $(this).parents('.options-container').find('input[type=checkbox]:checked').length;

            //New Event Listener parrent
            //var check = $(this).parents('.checkbox-box').find('input[type=checkbox]:checked').length;
            if(check)
                $("ul.category-container li.main-category a.category-head." + $(this).attr('mainitem') + " span").addClass('active');
            else
                $("ul.category-container li.main-category a.category-head." + $(this).attr('mainitem') + " span").removeClass('active');
        }
                
        if (searchTimer !== null) {
            clearTimeout(searchTimer)
        }

        searchTimer = setTimeout(function() {
            $('input[name=page]').val(1);
            updateUrl();

            displaySearchProductList();
        }, 500, this);
    });

    $('.criteria-pagination').on('click', function(e) {
        $('input[name=page]').val($(this).data('page'));
        $("html, body").animate({ scrollTop: 0 }, "slow");

        displaySearchProductList();

        updateUrl();
    });


    function emptyForm() {
        $('.select-search').multiselect('deselectAll', false).multiselect('updateButtonText');
        $('.input-search').each(function(){ this.checked = false; });
    }

    function fillForm(displayProduct) { 
        
        $.ajax({
            url : "/criteria/page/info/search"+window.location.search,
            type: "GET"
        }).done(function(data) {
            $.each(data.multiCheckBox, function(k, v) {
                if($('#'+k).length) {
                    $('#' + k).multiselect('select', v);
                } else {
                    $.each(v, function(k2, v2){
                        $('#'+k+'-'+v2).each(function(){ this.checked = true; });
                    });
                }
            });

            $.each(data.simpleCheckBox, function(k, v) {
                $('#'+v).each(function(){ this.checked = true; });
            });

            
            $( ".checkbox-box" ).each(function( ) { 
                var check = $(this).find('input[type=checkbox]:checked').length;
                
                if(check)
                    $('.category-head.feature-'+$(this).attr('id')+' span').addClass('active');
            });
            
            if (displayProduct) {
                displaySearchProductList();
            }
        });
    }


    function displaySearchProductList() {

        $.ajax({
            url: "/criteria/render/search/",
            type: "GET",
            data: search_form.serialize()
        }).done(function(data) {
            $(".products-content:first").html(data);
            $(".amount").html($("#total-search-results").html());

            $('.criteria-pagination').on('click', function(e) {
                $('input[name=page]').val($(this).data('page'));
                $("html, body").animate({ scrollTop: 0 }, "slow");

                displaySearchProductList();

                updateUrl();
            });

            if ($('.toolbar').length > 0) {
                var $toolbar = $('.toolbar'),
                    $filterBtns = $('[data-toggle="filter"]', $toolbar),
                    $productList = $('.products-list');

                $filterBtns.each(function () {
                    var $btn = $(this);

                    $btn.on('click', function () {

                        $filterBtns.removeClass('active');
                        $btn.addClass('active');

                        var filter = $btn.data('filter');

                        if ($productList.hasClass('grid')) {
                            $productList.removeClass('grid').addClass(filter);
                        }

                        if ($productList.hasClass('list')) {
                            $productList.removeClass('list').addClass(filter);
                        }
                    });
                });
            }
        });
    }

    function updateUrl() {
        $.ajax({
            url : "/criteria/url/search/",
            type: "GET",
            data: search_form.serialize()
        }).done(function(data) {
            history.pushState({}, "search", data.url);
        });
    }

    if (typeof History.Adapter !== 'undefined') {
        History.Adapter.bind(window,'statechange',function(e){
            emptyForm();
            fillForm(true);
        });
    }

    function getURLParameter(name) {
        return decodeURIComponent((new RegExp('[?|&]' + name + '=' + '([^&;]+?)(&|#|;|$)').exec(location.search)||[,""])[1].replace(/\+/g, '%20'))||null
    }
    
    // configurator
    $('.nav-tabs li a').click(function() {
        
        if($(this).hasClass( "active" )) { 
             $(".tab-content " + $(this).attr('href')).removeClass('active').removeClass('in');
             $(this).removeClass('active').removeClass('in');
        }
        else {
              $(".tab-content .tab-pane").removeClass("active");
              $(".tab-content " + $(this).attr('href')).addClass("active").addClass("in");
              $('.main-category .category-head').removeClass('active');
              $(this).addClass('active')
        }
          
    });
});