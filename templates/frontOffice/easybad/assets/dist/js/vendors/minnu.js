"use strict";
if (!("ontouchstart" in window) || (navigator.msMaxTouchPoints)) {
	(function ($, window, undefined) {
		var $allDropdowns = $();
		$.fn.dropdownHover = function (options) {
			$allDropdowns = $allDropdowns.add(this.parent());
			return this.each(function () {
				var $this = $(this),
					$parent = $this.parent(),
					defaults = {
						delay: 100,
						instantlyCloseOthers: true
					},
					data = {
						delay: $(this).data('delay'),
						instantlyCloseOthers: $(this).data('close-others')
					},
					showEvent = 'show.bs.dropdown',
					hideEvent = 'hide.bs.dropdown',
					// shownEvent  = 'shown.bs.dropdown',
					// hiddenEvent = 'hidden.bs.dropdown',
					settings = $.extend(true, {}, defaults, options, data),
					timeout;
				
				$parent.on({
					mouseenter:function (event){
						// so a neighbor can't open the dropdown
						if (!$parent.hasClass('open') && !$this.is(event.target)) {
							// stop this event, stop executing any code
							// in this callback but continue to propagate
							return true;
						}
						openDropdown(event);
					},mouseleave:function () {
						timeout = window.setTimeout(function () {
							$parent.removeClass('open');
							$this.trigger(hideEvent);
						}, settings.delay);
					},click:function(e){
						e.stopPropagation();
					}
				});
				
				$this.on({
					mouseenter:function(){
						if (!$parent.hasClass('open') && !$parent.is(event.target)) {
							return true;
						}
						openDropdown(event);
					}
				});
				
				// handle submenus
				$parent.find('.dropdown-submenu').each(function () {
					var $this = $(this);
					var subTimeout;
					$this.on({
						mouseenter:function () {
							window.clearTimeout(subTimeout);
							$this.children('.dropdown-menu').addClass("open");
							// always close submenu siblings instantly
							$this.siblings().children('.dropdown-menu').removeClass("open");
						},mouseleave:function () {
							var $submenu = $this.children('.dropdown-menu');
							subTimeout = window.setTimeout(function () {
								$this.children('.dropdown-menu').removeClass("open");
							}, settings.delay);
						}
					});
				});

				function openDropdown(event) {
					$allDropdowns.find(':focus').blur();
					if (settings.instantlyCloseOthers === true) $allDropdowns.removeClass('open');
					window.clearTimeout(timeout);
					$parent.addClass('open');
					$this.trigger(showEvent);
				}
			});
		};
		$(document).ready(function () {
			$('[data-hover="dropdown"]').dropdownHover();
			$('.minnu-tabs-control').find('li a').on({
				mouseenter:function(){
					if($(this).parent().parent().data("toggle")=="click") return false;
					$(this).parent().siblings().removeClass('active');
					$(this).parent().addClass('active');
					var id=$(this).data("target");
					$('.tab-pane').siblings().removeClass('active');
					$("#"+id).addClass('active');
				},click:function(){
					$(this).parent().siblings().removeClass('active');
					$(this).parent().addClass('active');
					var id=$(this).data("target");
					$('.tab-pane').siblings().removeClass('active');
					$("#"+id).addClass('active');
				}
			});
			$('.dropdown-menu').on({
				click:function(e){
					e.stopPropagation();
				}
			});
			$('.dropdown-submenu').on({
				click:function(){
					if($(this).children('.dropdown-menu').hasClass("open")==true){
						$(this).children('.dropdown-menu').removeClass("open");
						return false;
					}
					$(this).children('.dropdown-menu').addClass("open");
					// always close submenu siblings instantly
					$(this).siblings().children('.dropdown-menu').removeClass("open");
				}
			});
		});
	})(jQuery, this);
}else{
	$(document).ready(function () {
		$('.minnu-tabs-control').find('li a').on({
			click:function(){
				$(this).parent().siblings().removeClass('active');
				$(this).parent().addClass('active');
				var id=$(this).data("target");
				$('.tab-pane').siblings().removeClass('active');
				$("#"+id).addClass('active');
			}
		});
		$('.dropdown-menu').on({
			click:function(e){
				e.stopPropagation();
			}
		});
		$('.dropdown-submenu').on({
			click:function(){
				if($(this).children('.dropdown-menu').hasClass("open")==true){
					$(this).children('.dropdown-menu').removeClass("open");
					return false;
				}
				$(this).children('.dropdown-menu').addClass("open");
				// always close submenu siblings instantly
				$(this).siblings().children('.dropdown-menu').removeClass("open");
			}
		});
	});
}