var jQuery_1_8_2 = jQuery_1_8_2 || $.noConflict();
(function ($, undefined) {
	$(function () {
		"use strict";
		var $frmCreateService = $("#frmCreateService"),
			$frmUpdateService = $("#frmUpdateService"),
			$dialogDeleteImage = $("#dialogDeleteImage"),
			multiselect = ($.fn.multiselect !== undefined),
			dialog = ($.fn.dialog !== undefined),
			spinner = ($.fn.spinner !== undefined),
			datagrid = ($.fn.datagrid !== undefined),
			tipsy = ($.fn.tipsy !== undefined);
		
		if (tipsy) {
			$(".listing-tip").tipsy({
				offset: 1,
				opacity: 1,
				html: true,
				gravity: "nw",
				className: "tipsy-listing"
			});
		}
		
		if ($frmCreateService.length > 0) {
			$frmCreateService.validate({
				rules:{
					"price":{
						positiveNumber: true
					},
					"length":{
						positiveNumber: true
					},
					"before":{
						positiveNumber: true
					},
					"after":{
						positiveNumber: true
					}
				},
				errorPlacement: function (error, element) {
					var name = element.attr('name');
					if(name == 'length' || name == 'before' || name=='after')
					{
						error.insertAfter(element.parent().parent());
					}else{
						error.insertAfter(element.parent());
					}
				},
				onkeyup: false,
				errorClass: "err",
				wrapper: "em"
			});
			$.validator.addMethod('positiveNumber',
			    function (value) { 
			        return Number(value) >= 0;
			    }, 
			    myLabel.positiveNumber
			);
		}
		if ($frmUpdateService.length > 0) {
			$frmUpdateService.validate({
				rules:{
					"price":{
						positiveNumber: true
					},
					"length":{
						positiveNumber: true
					},
					"before":{
						positiveNumber: true
					},
					"after":{
						positiveNumber: true
					}
				},
				errorPlacement: function (error, element) {
					var name = element.attr('name');
					if(name == 'length' || name == 'before' || name=='after')
					{
						error.insertAfter(element.parent().parent());
					}else{
						error.insertAfter(element.parent());
					}
				},
				onkeyup: false,
				errorClass: "err",
				wrapper: "em"
			});
			$.validator.addMethod('positiveNumber',
			    function (value) { 
			        return Number(value) >= 0;
			    }, 
			    myLabel.positiveNumber
			);
		}
		
		if (multiselect) {
			$("select[name^='employee_id']").multiselect({
				checkAllText: myLabel.checkAllText,
				uncheckAllText: myLabel.uncheckAllText,
				noneSelectedText: myLabel.noneSelectedText,
				selectedText: '# ' + myLabel.selectedText,
				show: ['fade', 250],
				hide: ['fade', 250]
			});
		}
		
		if (spinner) {
			$(".spinner").spinner({
				"min": 0,
				"step": 1,
				stop: function(event, ui) {
					var total = 0,
						len_gth = parseInt($("#length").val(), 10),
						before = parseInt($("#before").val(), 10),
						after = parseInt($("#after").val(), 10);
					if (!isNaN(len_gth)) {
						total += len_gth;
					}
					if (!isNaN(before)) {
						total += before;
					}
					if (!isNaN(after)) {
						total += after;
					}
					$("#total").val(total);
					$("#print_total").text(total);
				}
			});
		}
		
		function formatPrice(str, obj) {
			return obj.price_format;
		}
		
		if ($("#grid").length > 0 && datagrid) {
			
			var options = {
				buttons: [{type: "edit", url: "index.php?controller=pjAdminServices&action=pjActionUpdate&id={:id}"},
				          {type: "delete", url: "index.php?controller=pjAdminServices&action=pjActionDeleteService&id={:id}"}
				          ],
				columns: [{text: myLabel.name, type: "text", sortable: true, editable: true, width: 125},
				          {text: myLabel.employees, type: "text", sortable: true, editable: false, align: "center"},
				          {text: myLabel.price, type: "text", sortable: true, editable: true, renderer: formatPrice, align: "right", width: 60, editableWidth: 60},
				          {text: myLabel.len, type: "spinner", min: 0, step: 1, sortable: true, editable: true, editableWidth: 50, align: "center"},
				          {text: myLabel.total, type: "text", sortable: true, editable: false, align: "center"},
				          {text: myLabel.status, type: "select", sortable: true, editable: true, options: [
						                                                                                     {label: myLabel.active, value: 1}, 
						                                                                                     {label: myLabel.inactive, value: 0}
						                                                                                     ], applyClass: "pj-status"}],
				dataUrl: "index.php?controller=pjAdminServices&action=pjActionGetService",
				dataType: "json",
				fields: ['name', 'employees', 'price', 'length', 'total', 'is_active'],
				paginator: {
					actions: [
					   {text: myLabel.delete_selected, url: "index.php?controller=pjAdminServices&action=pjActionDeleteServiceBulk", render: true, confirmation: myLabel.delete_confirmation}
					],
					gotoPage: true,
					paginate: true,
					total: true,
					rowCount: true
				},
				saveUrl: "index.php?controller=pjAdminServices&action=pjActionSaveService&id={:id}",
				select: {
					field: "id",
					name: "record[]"
				}
			};
			
			var m = window.location.href.match(/&is_active=(\d+)/);
			if (m !== null) {
				options.cache = {"is_active" : m[1]};
			}
			
			var $grid = $("#grid").datagrid(options);
		}
		
		$(document).on("click", ".btn-all", function (e) {
			if (e && e.preventDefault) {
				e.preventDefault();
			}
			$(this).addClass("pj-button-active").siblings(".pj-button").removeClass("pj-button-active");
			var content = $grid.datagrid("option", "content"),
				cache = $grid.datagrid("option", "cache");
			$.extend(cache, {
				is_active: "",
				q: ""
			});
			$grid.datagrid("option", "cache", cache);
			$grid.datagrid("load", "index.php?controller=pjAdminServices&action=pjActionGetService", "name", "ASC", content.page, content.rowCount);
			return false;
		}).on("click", ".btn-filter", function (e) {
			if (e && e.preventDefault) {
				e.preventDefault();
			}
			var $this = $(this),
				content = $grid.datagrid("option", "content"),
				cache = $grid.datagrid("option", "cache"),
				obj = {};
			$this.addClass("pj-button-active").siblings(".pj-button").removeClass("pj-button-active");
			obj.is_active = "";
			obj[$this.data("column")] = $this.data("value");
			$.extend(cache, obj);
			$grid.datagrid("option", "cache", cache);
			$grid.datagrid("load", "index.php?controller=pjAdminServices&action=pjActionGetService", "name", "ASC", content.page, content.rowCount);
			return false;
		}).on("submit", ".frm-filter", function (e) {
			if (e && e.preventDefault) {
				e.preventDefault();
			}
			var $this = $(this),
				content = $grid.datagrid("option", "content"),
				cache = $grid.datagrid("option", "cache");
			$.extend(cache, {
				q: $this.find("input[name='q']").val()
			});
			$grid.datagrid("option", "cache", cache);
			$grid.datagrid("load", "index.php?controller=pjAdminServices&action=pjActionGetService", "id", "ASC", content.page, content.rowCount);
			return false;
		});
		$("#content").on("click", ".btnDeleteImage", function () {
			if ($dialogDeleteImage.length > 0 && dialog) {
				$dialogDeleteImage.data("id", $frmUpdateService.find("input[name='id']").val()).dialog("open");
			}
		});
		if ($dialogDeleteImage.length > 0 && dialog) {
			$dialogDeleteImage.dialog({
				modal: true,
				autoOpen: false,
				resizable: false,
				draggable: false,
				buttons: (function () {
					var buttons = {};
					buttons[asApp.locale.button.yes] = function () {
						$.post("index.php?controller=pjAdminServices&action=pjActionDeleteImage", {
							"id": $dialogDeleteImage.data("id")
						}).done(function(data) {
							
							if (data.status == "OK") {
								$(".boxImage").html("").hide();
								$(".boxNoImage").show();
							}
							
							$dialogDeleteImage.dialog("close");
						});
					};
					buttons[asApp.locale.button.no] = function () {
						$dialogDeleteImage.dialog("close");
					};
					
					return buttons;
				})()
			});
		}
	});
})(jQuery_1_8_2);