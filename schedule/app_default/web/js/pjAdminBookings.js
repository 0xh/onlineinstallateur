var jQuery_1_8_2 = jQuery_1_8_2 || $.noConflict();
(function ($, undefined) {
	$(function () {
		"use strict";
		var validator, $frmBooking,
			$frmCreateBooking = $("#frmCreateBooking"),
			$frmUpdateBooking = $("#frmUpdateBooking"),
			$dialogItemDelete = $("#dialogItemDelete"),
			$dialogItemAdd = $("#dialogItemAdd"),
			$dialogItemEmail = $("#dialogItemEmail"),
			$dialogItemSms = $("#dialogItemSms"),
			$tabs = $("#tabs"),
			tabs = ($.fn.tabs !== undefined),
			dialog = ($.fn.dialog !== undefined),
			spinner = ($.fn.spinner !== undefined),
			validate = ($.fn.validate !== undefined),
			datagrid = ($.fn.datagrid !== undefined),
			datepicker = ($.fn.datepicker !== undefined);
		
		function getBookingItems(booking_id, tmp_hash) {
			$.get("index.php?controller=pjAdminBookings&action=pjActionItemGet", {
				"booking_id": booking_id,
				"tmp_hash": tmp_hash
			}).done(function (data) {
				$("#boxBookingItems").html(data);
				if (data.indexOf("pj-table") >= 0)
				{
					$("#boxBookingItems").parent().find("em").remove();
				}
			});
		}
		
		if ($tabs.length > 0 && tabs) {
			$tabs.tabs();
		}
		
		if ($frmCreateBooking.length > 0 && validate) {
			$frmCreateBooking.validate({
				rules: {
					"uuid": {
						remote: "index.php?controller=pjAdminBookings&action=pjActionCheckUID"
					},
					"booking_items":{
						required: function(e){
							if($('#boxBookingItems').find('.pj-table').length > 0){
								return false;
							}else{
								return true;
							}
						}
					}
				},
				messages: {
					"uuid": {
						remote: myLabel.uuid_used
					},
					"booking_items":{
						required: myLabel.services_required
					}
				},
				errorPlacement: function (error, element) {
					if(element.attr('name') == 'booking_items')
					{
						error.insertAfter(element);
					}else{
						error.insertAfter(element.parent());
					}
				},
				onkeyup: false,
				errorClass: "err",
				wrapper: "em",
				ignore: ".ignore",
				invalidHandler: function (event, validator) {
				    if (validator.numberOfInvalids()) {
				    	var index = $(validator.errorList[0].element, this).closest("div[id^='tabs-']").index();
				    	if ($tabs.length > 0 && tabs && index !== -1) {
				    		$tabs.tabs().tabs("option", "active", index-1);
				    	}
				    }
				}
			});
			$frmBooking = $frmCreateBooking;
			
			if($frmCreateBooking.find("input[name='bs_id']").length > 0)
			{
				getBookingItems.call(null, null, $frmCreateBooking.find("input[name='tmp_hash']").val());
			}
		}
		
		if ($frmUpdateBooking.length > 0) {
			
			$frmUpdateBooking.on("click", ".btnCreateInvoice", function () {
				$("#frmCreateInvoice").trigger("submit");
			});
			
			if (validate) {
				$frmUpdateBooking.validate({
					rules: {
						"uuid": {
							remote: "index.php?controller=pjAdminBookings&action=pjActionCheckUID&id=" + $frmUpdateBooking.find("input[name='id']").val()
						},
						"booking_items":{
							required: function(e){
								if($('#boxBookingItems').find('.pj-table').length > 0){
									return false;
								}else{
									return true;
								}
							}
						}
					},
					messages: {
						"uuid": {
							remote: myLabel.uuid_used
						},
						"booking_items":{
							required: myLabel.services_required
						}
					},
					errorPlacement: function (error, element) {
						if(element.attr('name') == 'booking_items')
						{
							error.insertAfter(element);
						}else{
							error.insertAfter(element.parent());
						}
					},
					onkeyup: false,
					errorClass: "err",
					wrapper: "em",
					ignore: ".ignore",
					invalidHandler: function (event, validator) {
					    if (validator.numberOfInvalids()) {
					    	var index = $(validator.errorList[0].element, this).closest("div[id^='tabs-']").index();
					    	if ($tabs.length > 0 && tabs && index !== -1) {
					    		$tabs.tabs().tabs("option", "active", index-1);
					    	}
					    }
					}
				});
			}
			$frmBooking = $frmUpdateBooking;
			
			getBookingItems.call(null, $frmUpdateBooking.find("input[name='id']").val());
		}
		
		function formatDateTime(str) {
			if (str === null || str.length === 0) {
				return myLabel.empty_datetime;
			}
			
			if (str === '0000-00-00 00:00:00') {
				return myLabel.invalid_datetime;
			}
			
			if (str.match(/\d{4}-\d{2}-\d{2}\s\d{2}:\d{2}:\d{2}/) !== null) {
				var x = str.split(" "),
					date = x[0],
					time = x[1],
					dx = date.split("-"),
					tx = time.split(":"),
					y = dx[0],
					m = parseInt(dx[1], 10) - 1,
					d = dx[2],
					hh = tx[0],
					mm = tx[1],
					ss = tx[2];
				return $.datagrid.formatDate(new Date(y, m, d, hh, mm, ss), pjGrid.jsDateFormat + ", hh:mm");
			}
		}
		
		function formatServices(str, obj) {
			var tmp,
				arr = [];
			for (var i = 0, iCnt = obj.items.length; i < iCnt; i++) {
				tmp = obj.items[i].split("~.~");
				arr.push([tmp[2], '<a href="index.php?controller=pjAdminBookings&action=pjActionUpdate&id='+obj.id+'">'+tmp[1] + '</a>'].join("<br/>"));
			}
			
			return arr.join("<br />");
		}
		
		function formatClient (str, obj) {
			return [obj.c_name, 
			        (obj.c_email && obj.c_email.length > 0 ? ['<br><a href="mailto:', obj.c_email, '">', obj.c_email, '</a>'].join('') : ''), 
			        (obj.c_phone && obj.c_phone.length > 0 ? ['<br>', obj.c_phone].join('') : '')
			        ].join("");
		}
		
		function formatDefault (str) {
			return myLabel[str] || str;
		}
		
		function formatId (str) {
			return ['<a href="index.php?controller=pjInvoice&action=pjActionUpdate&id=', str, '">#', str, '</a>'].join("");
		}
		
		function formatTotal(val, obj) {
			return obj.total_formated;
		}
		
		if ($("#grid").length > 0 && datagrid) {
			
			var options = {
				buttons: [{type: "edit", url: "index.php?controller=pjAdminBookings&action=pjActionUpdate&id={:id}"},
				          {type: "delete", url: "index.php?controller=pjAdminBookings&action=pjActionDeleteBooking&id={:id}"}
				          ],
				columns: [{text: myLabel.services, type: "text", sortable: true, editable: false, renderer: formatServices, width: 230},
				          {text: myLabel.customer, type: "text", sortable: true, editable: false, renderer: formatClient},
				          {text: myLabel.total, type: "text", sortable: true, editable: false, align: "right", renderer: formatTotal},
				          {text: myLabel.status, type: "select", sortable: true, editable: true, width: 100, options: [
				                                                                                     {label: myLabel.confirmed, value: 'confirmed'},
				                                                                                     {label: myLabel.pending, value: 'pending'},
				                                                                                     {label: myLabel.cancelled, value: 'cancelled'}
				                                                                                     ], applyClass: "pj-status"}],
				dataUrl: "index.php?controller=pjAdminBookings&action=pjActionGetBooking",
				dataType: "json",
				fields: ['id', 'c_name', 'booking_total', 'booking_status'],
				paginator: {
					actions: [
					   {text: myLabel.delete_selected, url: "index.php?controller=pjAdminBookings&action=pjActionDeleteBookingBulk", render: true, confirmation: myLabel.delete_confirmation}
					],
					gotoPage: true,
					paginate: true,
					total: true,
					rowCount: true
				},
				saveUrl: "index.php?controller=pjAdminBookings&action=pjActionSaveBooking&id={:id}",
				select: {
					field: "id",
					name: "record[]"
				}
			};
			
			var cache = {},
				m1 = window.location.href.match(/&booking_status=(\w+)/),
				m2 = window.location.href.match(/&employee_id=(\d+)/);
			if (m1 !== null) {
				options.cache = $.extend(cache, {"booking_status" : m1[1]});
			}
			if (m2 !== null) {
				options.cache = $.extend(cache, {"employee_id" : m2[1]});
			}
			
			var $grid = $("#grid").datagrid(options);
		}
		
		if ($("#grid_invoices").length > 0 && datagrid) {
			var $grid_invoices = $("#grid_invoices").datagrid({
				buttons: [{type: "edit", url: "index.php?controller=pjInvoice&action=pjActionUpdate&id={:id}", title: "Edit"},
				          {type: "delete", url: "index.php?controller=pjInvoice&action=pjActionDelete&id={:id}", title: "Delete"}],
				columns: [
				    {text: myLabel.num, type: "text", sortable: true, editable: false, renderer: formatId},
				    {text: myLabel.order_id, type: "text", sortable: true, editable: false},
				    {text: myLabel.issue_date, type: "date", sortable: true, editable: false, renderer: $.datagrid._formatDate, dateFormat: pjGrid.jsDateFormat},
				    {text: myLabel.due_date, type: "date", sortable: true, editable: false, renderer: $.datagrid._formatDate, dateFormat: pjGrid.jsDateFormat},
				    {text: myLabel.created, type: "text", sortable: true, editable: false, renderer: formatDateTime},
				    {text: myLabel.status, type: "text", sortable: true, editable: false, renderer: formatDefault},	
				    {text: myLabel.total, type: "text", sortable: true, editable: false, align: "right", renderer: formatTotal}
				],
				dataUrl: "index.php?controller=pjInvoice&action=pjActionGetInvoices&q=" + $frmUpdateBooking.find("input[name='uuid']").val(),
				dataType: "json",
				fields: ['id', 'order_id', 'issue_date', 'due_date', 'created', 'status', 'total'],
				paginator: {
					actions: [
					   {text: myLabel.delete_title, url: "index.php?controller=pjInvoice&action=pjActionDeleteBulk", render: true, confirmation: myLabel.delete_body}
					],
					gotoPage: true,
					paginate: true,
					total: true,
					rowCount: true
				},
				select: {
					field: "id",
					name: "record[]"
				}
			});
		}
		
		$("#content").on("click", ".item-add", function (e) {
			if (e && e.preventDefault) {
				e.preventDefault();
			}
			if ($dialogItemAdd.length > 0 && dialog) {
				$dialogItemAdd.dialog("open");
			}
			return false;
		}).on("click", ".item-delete", function (e) {
			if (e && e.preventDefault) {
				e.preventDefault();
			}
			if ($dialogItemDelete.length > 0 && dialog) {
				$dialogItemDelete.data("id", $(this).data("id")).dialog("open");
			}
			return false;
		}).on("click", ".item-email", function (e) {
			if (e && e.preventDefault) {
				e.preventDefault();
			}
			if ($dialogItemEmail.length > 0 && dialog) {
				$dialogItemEmail.data("id", $(this).data("id")).dialog("open");
			}
			return false;
		}).on("click", ".item-sms", function (e) {
			if (e && e.preventDefault) {
				e.preventDefault();
			}
			if ($dialogItemSms.length > 0 && dialog) {
				$dialogItemSms.data("id", $(this).data("id")).dialog("open");
			}
			return false;
		}).on("click", ".order-calc", function () {
			var $this = $(this),
				$form = $this.closest("form");
			$.post("index.php?controller=pjAdminBookings&action=pjActionGetPrice", $form.serialize()).done(function (data) {
				if (data.status == 'OK') {
					$form.find("#booking_price").val(data.data.price.toFixed(2));
					$form.find("#booking_deposit").val(data.data.deposit.toFixed(2));
					$form.find("#booking_tax").val(data.data.tax.toFixed(2));
					$form.find("#booking_total").val(data.data.total.toFixed(2));
				}
			});
		}).on("change", "#payment_method", function () {
			if ($("option:selected", this).val() == 'creditcard') {
				$(".erCC").show();
			} else {
				$(".erCC").hide();
			}
		}).on("change", "#export_period", function (e) {
			var period = $(this).val();
			if(period == 'last')
			{
				$('#last_label').show();
				$('#next_label').hide();
			}else{
				$('#last_label').hide();
				$('#next_label').show();
			}
		}).on("click", "#file", function (e) {
			$('#tsSubmitButton').val(myLabel.btn_export);
			$('.tsFeedContainer').hide();
			$('.tsPassowrdContainer').hide();
		}).on("click", "#feed", function (e) {
			$('.tsPassowrdContainer').show();
			$('#tsSubmitButton').val(myLabel.btn_get_url);
		}).on("focus", "#bookings_feed", function (e) {
			$(this).select();
		});
		
		$(document).on("focusin", ".datepick", function (e) {
			var $this = $(this);
			$this.datepicker({
				monthNames: myLabel.monthNames,
				dayNamesMin: myLabel.dayNamesMin,
				firstDay: $this.attr("rel"),
				dateFormat: $this.attr("rev")
			});
		}).on("click", ".btn-all", function (e) {
			if (e && e.preventDefault) {
				e.preventDefault();
			}
			$(this).addClass("pj-button-active").siblings(".pj-button").removeClass("pj-button-active");
			var content = $grid.datagrid("option", "content"),
				cache = $grid.datagrid("option", "cache");
			$.extend(cache, {
				booking_status: "",
				q: ""
			});
			$grid.datagrid("option", "cache", cache);
			$grid.datagrid("load", "index.php?controller=pjAdminBookings&action=pjActionGetBooking", "id", "DESC", content.page, content.rowCount);
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
			obj.booking_status = "";
			obj[$this.data("column")] = $this.data("value");
			$.extend(cache, obj);
			$grid.datagrid("option", "cache", cache);
			$grid.datagrid("load", "index.php?controller=pjAdminBookings&action=pjActionGetBooking", "id", "DESC", content.page, content.rowCount);
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
			$grid.datagrid("load", "index.php?controller=pjAdminBookings&action=pjActionGetBooking", "id", "DESC", content.page, content.rowCount);
			return false;
		}).on("click", ".pj-form-field-icon-date", function (e) {
			var $dp = $(this).parent().siblings("input[type='text']");
			if ($dp.hasClass("hasDatepicker")) {
				$dp.datepicker("show");
			} else {
				$dp.trigger("focusin").datepicker("show");
			}
		}).on("click", ".pj-button-detailed, .pj-button-detailed-arrow", function (e) {
			e.stopPropagation();
			$(".pj-form-filter-advanced").slideToggle();
		}).on("submit", ".frm-filter-advanced", function (e) {
			if (e && e.preventDefault) {
				e.preventDefault();
			}
			var obj = {},
				$this = $(this),
				arr = $this.serializeArray(),
				content = $grid.datagrid("option", "content"),
				cache = $grid.datagrid("option", "cache");
			for (var i = 0, iCnt = arr.length; i < iCnt; i++) {
				obj[arr[i].name] = arr[i].value;
			}
			cache.q = "";
			$.extend(cache, obj);
			$grid.datagrid("option", "cache", cache);
			$grid.datagrid("load", "index.php?controller=pjAdminBookings&action=pjActionGetBooking", "id", "DESC", content.page, content.rowCount);
			return false;
		}).on("reset", ".frm-filter-advanced", function (e) {
			if (e && e.preventDefault) {
				e.preventDefault();
			}
			$(".pj-button-detailed").trigger("click");
			return false;
		}).on("click.as", ".asSlotAvailable", function (e) {	
			
			var $this = $(this),
				$form = $this.closest("form");
			
			if ($this.hasClass("asSlotSelected")) {
				$this.removeClass("asSlotSelected");
				
				$form.find("input[name='employee_id']").val("");
				$form.find("input[name='start_ts']").val("");
				$form.find("input[name='end_ts']").val("");
				
				$form.find(".data").text("---");
			} else {
				$form.find(".asSlotBlock").removeClass("asSlotSelected");
				$this.addClass("asSlotSelected");
				
				$form.find("input[name='employee_id']").val($this.data("employee_id"));
				$form.find("input[name='start_ts']").val($this.data("start_ts"));
				$form.find("input[name='end_ts']").val($this.data("end_ts"));
				
				$form.find(".bStartTime .data").text($this.text());
				$form.find(".bEndTime .data").text($this.data("end"));
				$form.find(".bEmployee .data").text($this.closest(".asElement").find(".asEmployeeName").text());
			}
		}).on("click", ".apClientName", function (e) {
			if (e && e.preventDefault) {
				e.preventDefault();
			}
			$tabs.tabs().tabs("option", "active", 1);
			return false;
		});
		
		function onChange() {
			var $el = $(this),
				$form = $el.closest("form"),
				service_id = $form.find("select[name='service_id']").find("option:selected").val(),
				selector = "input[name='employee_id'], input[name='start_ts'], input[name='end_ts']",
				$dialog = $form.parent(),
				$details = $form.find(".item_details");
			
			if (parseInt(service_id, 10) > 0) {
				$form.find(selector).removeClass("ignore");
				$form.find(".bStartTime, .bEndTime, .bEmployee").show();
			} else {
				$form.find(selector).addClass("ignore");
				$form.find(".bStartTime, .bEndTime, .bEmployee").hide();
			}
			$form.find(selector).val("");
			$form.find(".data").text("---");
			
			$.get("index.php?controller=pjAdminBookings&action=pjActionGetService", {
				"id": service_id,
				"date": $form.find("input[name='date']").val()
			}).done(function (data) {
				$details.html(data).show();
				$dialog.dialog("option", "position", "center");
			});
		}

		var aiOpts = {
			rules: {
				"date": "required",
				"service_id": {
					required: true,
					digits: true
				},
				"employee_id": {
					required: true,
					digits: true
				},
				"start_ts": {
					required: true,
					digits: true
				},
				"end_ts": {
					required: true,
					digits: true
				}
			},
			ignore: ".ignore"
		};
		
		if ($dialogItemAdd.length > 0 && dialog) {
			$dialogItemAdd.dialog({
				modal: true,
				resizable: false,
				draggable: false,
				autoOpen: false,
				width: 600,
				open: function () {
					$dialogItemAdd.html("");
					$.get("index.php?controller=pjAdminBookings&action=pjActionItemAdd", $frmBooking.find("input[name='id'], input[name='tmp_hash'], #date_from, #hour_from, #minute_from, #date_to, #hour_to, #minute_to").serialize()).done(function (data) {
						$dialogItemAdd.html(data);
						validator = $dialogItemAdd.find("form").validate(aiOpts);
						$dialogItemAdd.dialog("option", "position", "center");
					});
				},
				buttons: (function () {
					var buttons = {};
					buttons[asApp.locale.button.add] = function () {
						var $this = $(this);
						if (validator.form()) {
							$.post("index.php?controller=pjAdminBookings&action=pjActionItemAdd", $dialogItemAdd.find("form").serialize()).done(function (data) {
								getBookingItems.call(null, $frmBooking.find("input[name='id']").val(), $frmBooking.find("input[name='tmp_hash']").val());
								$this.dialog("close");
							});
						}
					};
					buttons[asApp.locale.button.cancel] = function () {
						$dialogItemAdd.dialog("close");
					};
					
					return buttons;
				})()
			}).on("change", "select[name='service_id'], input[name='date']", onChange);
		}
		
		if ($dialogItemDelete.length > 0 && dialog) {
			$dialogItemDelete.dialog({
				modal: true,
				resizable: false,
				draggable: false,
				autoOpen: false,
				buttons: (function () {
					var buttons = {};
					buttons[asApp.locale.button.delete] = function () {
						var $this = $(this);
						$.post("index.php?controller=pjAdminBookings&action=pjActionItemDelete", {
							"id": $this.data("id")
						}).done(function (data) {
							getBookingItems.call(null, $frmBooking.find("input[name='id']").val(), $frmBooking.find("input[name='tmp_hash']").val());
							$this.dialog("close");
						});
					};
					buttons[asApp.locale.button.cancel] = function () {
						$dialogItemDelete.dialog("close");
					};
					
					return buttons;
				})()
			});
		}
		
		if ($dialogItemEmail.length > 0 && dialog) {
			$dialogItemEmail.dialog({
				modal: true,
				resizable: false,
				draggable: false,
				autoOpen: false,
				width: 640,
				open: function () {
					$dialogItemEmail.html("");
					$.get("index.php?controller=pjAdminBookings&action=pjActionItemEmail", {
						"id": $dialogItemEmail.data("id")
					}).done(function (data) {
						$dialogItemEmail.html(data);
						validator = $dialogItemEmail.find("form").validate({
							errorPlacement: function (error, element) {
								error.insertAfter(element.parent());
							},
							errorClass: "error_clean"
						});
						$dialogItemEmail.dialog("option", "position", "center");
					});
				},
				buttons: (function () {
					var buttons = {};
					buttons[asApp.locale.button.send] = function () {
						if (validator.form()) {
							$.post("index.php?controller=pjAdminBookings&action=pjActionItemEmail", $dialogItemEmail.find("form").serialize()).done(function (data) {
								$dialogItemEmail.dialog("close");
							});
						}
					};
					buttons[asApp.locale.button.cancel] = function () {
						$dialogItemEmail.dialog("close");
					};
					
					return buttons;
				})()
			});
		}
		
		if ($dialogItemSms.length > 0 && dialog) {
			$dialogItemSms.dialog({
				modal: true,
				resizable: false,
				draggable: false,
				autoOpen: false,
				width: 640,
				open: function () {
					$dialogItemSms.html("");
					$.get("index.php?controller=pjAdminBookings&action=pjActionItemSms", {
						"id": $dialogItemSms.data("id")
					}).done(function (data) {
						$dialogItemSms.html(data);
						validator = $dialogItemSms.find("form").validate({
							errorPlacement: function (error, element) {
								error.insertAfter(element.parent());
							},
							errorClass: "error_clean"
						});
						$dialogItemSms.dialog("option", "position", "center");
					});
				},
				buttons: (function () {
					var buttons = {};
					buttons[asApp.locale.button.send] = function () {
						if (validator.form()) {
							$.post("index.php?controller=pjAdminBookings&action=pjActionItemSms", $dialogItemSms.find("form").serialize()).done(function (data) {
								$dialogItemSms.dialog("close");
							});
						}
					};
					buttons[asApp.locale.button.cancel] = function () {
						$dialogItemSms.dialog("close");
					};
					
					return buttons;
				})()
			});
		}
	});
})(jQuery_1_8_2);