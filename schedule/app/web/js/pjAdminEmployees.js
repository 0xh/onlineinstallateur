var jQuery_1_8_2 = jQuery_1_8_2 || $.noConflict();
(function ($, undefined) {
	$(function () {
		"use strict";
		var $frmCreateEmployee = $("#frmCreateEmployee"),
			$frmUpdateEmployee = $("#frmUpdateEmployee"),
			$dialogDeleteAvatar = $("#dialogDeleteAvatar"),
			multiselect = ($.fn.multiselect !== undefined),
			dialog = ($.fn.dialog !== undefined),
			datagrid = ($.fn.datagrid !== undefined),
			vOpts;
		
		vOpts = {
			rules: {
				email: {
					required: true,
					email: true,
					remote: "index.php?controller=pjAdminEmployees&action=pjActionCheckEmail"
				}
			},
			messages: {
				email: {
					remote: myLabel.email_taken
				}
			},
			errorPlacement: function (error, element) {
				error.insertAfter(element.parent());
			},
			onkeyup: false,
			errorClass: "err",
			wrapper: "em"
		};
		
		if ($frmCreateEmployee.length > 0) {
			$frmCreateEmployee.validate(vOpts);
		}
		if ($frmUpdateEmployee.length > 0) {
			vOpts.rules.email.remote = vOpts.rules.email.remote + "&id=" + $frmUpdateEmployee.find("input[name='id']").val();
			$frmUpdateEmployee.validate(vOpts);
		}
		
		if (multiselect) {
			$("select[name^='service_id']").multiselect({
				checkAllText: myLabel.checkAllText,
				uncheckAllText: myLabel.uncheckAllText,
				noneSelectedText: myLabel.noneSelectedText,
				selectedText: '# ' + myLabel.selectedText,
				show: ['fade', 250],
				hide: ['fade', 250]
			});
		}
		
		function formatAvatar(path, obj) {
			var src = 'app/web/img/backend/professional.gif';
			if (path !== null && path.length > 0) {
				src = path;
			}
			return ['<a href="index.php?controller=pjAdminEmployees&action=pjActionUpdate&id=', obj.id, '"><img src="', src, '" alt="" class="as-avatar" /></a>'].join('');
		}
		function formatEmail(email, obj) {
			return email + '<br/>' + obj.phone;
		}
		if ($("#grid").length > 0 && datagrid) {
			
			var options = {
				buttons: [{type: "edit", url: "index.php?controller=pjAdminEmployees&action=pjActionUpdate&id={:id}"},
				          {type: "delete", url: "index.php?controller=pjAdminEmployees&action=pjActionDeleteEmployee&id={:id}"},
				          {type: "menu", url: "#", text: myLabel.menu, items: [
				                {text: myLabel.view_bookings, url: "index.php?controller=pjAdminBookings&action=pjActionIndex&employee_id={:id}"}, 
				                {text: myLabel.working_time, url: "index.php?controller=pjAdminTime&action=pjActionIndex&type=employee&foreign_id={:id}"}
				             ]
				          }
				          ],
				columns: [{text: myLabel.avatar, type: "text", sortable: true, editable: false, width: 75, renderer: formatAvatar},
				          {text: myLabel.name, type: "text", sortable: true, editable: true, width: 125, editableWidth: 110},
				          {text: myLabel.emailphone, type: "text", sortable: true, editable: false, width: 205, renderer: formatEmail},
				          {text: myLabel.services, type: "text", sortable: true, editable: false, align: "center", width: 70},
				          {text: myLabel.status, type: "select", sortable: true, editable: true, options: [
						                                                                                     {label: myLabel.active, value: 1}, 
						                                                                                     {label: myLabel.inactive, value: 0}
						                                                                                     ], applyClass: "pj-status"}],
				dataUrl: "index.php?controller=pjAdminEmployees&action=pjActionGetEmployee",
				dataType: "json",
				fields: ['avatar', 'name', 'email', 'services', 'is_active'],
				paginator: {
					actions: [
					   {text: myLabel.delete_selected, url: "index.php?controller=pjAdminEmployees&action=pjActionDeleteEmployeeBulk", render: true, confirmation: myLabel.delete_confirmation}
					],
					gotoPage: true,
					paginate: true,
					total: true,
					rowCount: true
				},
				saveUrl: "index.php?controller=pjAdminEmployees&action=pjActionSaveEmployee&id={:id}",
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
		
		$("#content").on("click", ".btnDeleteAvatar", function () {
			if ($dialogDeleteAvatar.length > 0 && dialog) {
				$dialogDeleteAvatar.data("id", $frmUpdateEmployee.find("input[name='id']").val()).dialog("open");
			}
		});
		
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
			$grid.datagrid("load", "index.php?controller=pjAdminEmployees&action=pjActionGetEmployee", "name", "ASC", content.page, content.rowCount);
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
			$grid.datagrid("load", "index.php?controller=pjAdminEmployees&action=pjActionGetEmployee", "name", "ASC", content.page, content.rowCount);
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
			$grid.datagrid("load", "index.php?controller=pjAdminEmployees&action=pjActionGetEmployee", "id", "ASC", content.page, content.rowCount);
			return false;
		});
		
		if ($dialogDeleteAvatar.length > 0 && dialog) {
			$dialogDeleteAvatar.dialog({
				modal: true,
				autoOpen: false,
				resizable: false,
				draggable: false,
				buttons: (function () {
					var buttons = {};
					buttons[asApp.locale.button.yes] = function () {
						$.post("index.php?controller=pjAdminEmployees&action=pjActionDeleteAvatar", {
							"id": $dialogDeleteAvatar.data("id")
						}).done(function(data) {
							
							if (data.status == "OK") {
								$(".boxAvatar").html("").hide();
								$(".boxNoAvatar").show();
							}
							
							$dialogDeleteAvatar.dialog("close");
						});
					};
					buttons[asApp.locale.button.no] = function () {
						$dialogDeleteAvatar.dialog("close");
					};
					
					return buttons;
				})()
			});
		}
	});
})(jQuery_1_8_2);