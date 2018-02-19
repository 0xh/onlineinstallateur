var jQuery_1_8_2 = jQuery_1_8_2 || $.noConflict();
(function ($, undefined) {
	$(function () {
		var $frmLoginAdmin = $("#frmLoginAdmin"),
			$frmForgotAdmin = $("#frmForgotAdmin"),
			$frmUpdateProfile = $("#frmUpdateProfile"),
			$dialogDeleteAvatar = $("#dialogDeleteAvatar"),
			multiselect = ($.fn.multiselect !== undefined),
			dialog = ($.fn.dialog !== undefined),
			datepicker = ($.fn.datepicker !== undefined),
			validate = ($.fn.validate !== undefined);
		
		if ($frmLoginAdmin.length > 0 && validate) {
			$frmLoginAdmin.validate({
				rules: {
					login_email: {
						required: true,
						email: true
					},
					login_password: "required"
				},
				errorPlacement: function (error, element) {
					error.insertAfter(element.parent());
				},
				onkeyup: false,
				errorClass: "err",
				wrapper: "em"
			});
		}
		
		if ($frmForgotAdmin.length > 0 && validate) {
			$frmForgotAdmin.validate({
				rules: {
					forgot_email: {
						required: true,
						email: true
					}
				},
				errorPlacement: function (error, element) {
					error.insertAfter(element.parent());
				},
				onkeyup: false,
				errorClass: "err",
				wrapper: "em"
			});
		}
		
		if ($frmUpdateProfile.length > 0 && validate) {
			$frmUpdateProfile.validate({
				rules: {
					"email": {
						required: true,
						email: true,
						remote: "index.php?controller=pjAdminEmployees&action=pjActionCheckEmail"
					},
					"password": "required",
					"phone": "required"
				},
				messages: {
					"email": {
						remote: myLabel.email_taken
					}
				},
				errorPlacement: function (error, element) {
					error.insertAfter(element.parent());
				},
				onkeyup: false,
				errorClass: "err",
				wrapper: "em"
			});
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
		
		$("#content").on("click", ".btnDeleteAvatar", function () {
			if ($dialogDeleteAvatar.length > 0 && dialog) {
				$dialogDeleteAvatar.dialog("open");
			}
		});
		
		if ($dialogDeleteAvatar.length > 0 && dialog) {
			$dialogDeleteAvatar.dialog({
				modal: true,
				autoOpen: false,
				resizable: false,
				draggable: false,
				buttons: {
					"Yes": function () {
						$.post("index.php?controller=pjAdminEmployees&action=pjActionDeleteAvatar").done(function(data) {
							
							if (data.status == "OK") {
								$(".boxAvatar").html("").hide();
								$(".boxNoAvatar").show();
							}
							
							$dialogDeleteAvatar.dialog("close");
						});
					},
					"No": function () {
						$(this).dialog("close");
					}
				}
			});
		}
		
		$(document).on("focusin", ".datepick", function (e) {
			var $this = $(this);
			$this.datepicker({
				monthNames: myLabel.monthNames,
				dayNamesMin: myLabel.dayNamesMin,
				firstDay: $this.attr("rel"),
				dateFormat: $this.attr("rev"),
				onSelect: function (dateText, inst) {
					var month = inst.selectedMonth + 1,
						day = inst.selectedDay;
					if (month.toString().length === 1) {
						month = "0" + month;
					}
					if (day.toString().length === 1) {
						day = "0" + day;
					}
					window.location.href = 'index.php?controller=pjAdmin&action=pjActionIndex&date=' + [inst.selectedYear, month, day].join("-");
				}
			});
		}).on("click", ".pj-form-field-icon-date", function (e) {
			var $dp = $(this).parent().siblings("input[type='text']");
			if ($dp.hasClass("hasDatepicker")) {
				$dp.datepicker("show");
			} else {
				$dp.trigger("focusin").datepicker("show");
			}
		});
		
	});
})(jQuery_1_8_2);