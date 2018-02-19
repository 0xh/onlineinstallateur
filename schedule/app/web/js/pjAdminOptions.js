var jQuery_1_8_2 = jQuery_1_8_2 || $.noConflict();
(function ($, undefined) {
	$(function () {
		"use strict";
		var $frmOptConfirmation = $("#frmOptConfirmation"),
			$tabs = $("#tabs"),
			tabs = ($.fn.tabs !== undefined);

		if ($tabs.length > 0 && tabs) {
			$tabs.tabs();
		}
		
		$(".field-int").spinner({
			min: 0
		});
		if ($frmOptConfirmation.length > 0) 
		{
			tinymce.init({
			    selector: "textarea.mceEditor",
			    theme: "modern",
			    width: 540,
			    height: 350,
			    plugins: [
					        "advlist autolink lists link image charmap print preview anchor",
					        "searchreplace visualblocks code fullscreen",
					        "insertdatetime media table contextmenu paste"
					    ],
				toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
			 });
			var value = $('#email_notify').val();
			$('#' + value + 'Box').show();
		}
		
		function reDrawCode() {
			var code = $("#hidden_code").text(),
				opt = $("select[name='install_option']").find("option:selected").val(),
				tab = opt != 'both' ? "&tab=" + opt : "";
			
			$('.pjAsInstallPreview').attr('data-tab', opt);
			
			$("#install_code").text(code.replace(/&action=pjActionLoadJS/g, function(match) {
	            return ["&action=pjActionLoad", tab].join("");
	        }));
		}
		
		$("#content").on("focus", ".textarea_install", function (e) {
			var $this = $(this);
			$this.select();
			$this.mouseup(function() {
				$this.unbind("mouseup");
				return false;
			});
		}).on("keyup", "#uri_page", function (e) {
			var tmpl = $("#hidden_htaccess").text(),
				tmpl_remote = $("#hidden_htaccess_remote").text(),
				index = this.value.indexOf("?");
			$("#install_htaccess").text(tmpl.replace('::URI_PAGE::', index >= 0 ? this.value.substring(0, index) : this.value));
			$("#install_htaccess_remote").text(tmpl_remote.replace('::URI_PAGE::', index >= 0 ? this.value.substring(0, index) : this.value));
		}).on("change", "select[name='value-enum-o_send_email']", function (e) {
			switch ($("option:selected", this).val()) {
			case 'mail|smtp::mail':
				$(".boxSmtp").hide();
				break;
			case 'mail|smtp::smtp':
				$(".boxSmtp").show();
				break;
			}
		}).on("change", "input[name='value-bool-o_allow_paypal']", function (e) {
			if ($(this).is(":checked")) {
				$(".boxPaypal").show();
			} else {
				$(".boxPaypal").hide();
			}
		}).on("change", "input[name='value-bool-o_allow_authorize']", function (e) {
			if ($(this).is(":checked")) {
				$(".boxAuthorize").show();
			} else {
				$(".boxAuthorize").hide();
			}
		}).on("change", "input[name='value-bool-o_allow_bank']", function (e) {
			if ($(this).is(":checked")) {
				$(".boxBank").show();
			} else {
				$(".boxBank").hide();
			}
		}).on("change", "#email_notify", function (e) {
			var value = $(this).val();
			$('.notifyBox').hide();
			$('#' + value + 'Box').show();
		}).on("change", "select[name='install_option']", function (e) {
			reDrawCode.call(null);
		}).on("click", ".pj-use-theme", function (e) {
			var theme = $(this).attr('data-theme');
			$('.pj-loader').css('display', 'block');
			$.ajax({
				type: "GET",
				async: false,
				url: 'index.php?controller=pjAdminOptions&action=pjActionUpdateTheme&theme=' + theme,
				success: function (data) {
					$('.theme-holder').html(data);
					$('.pj-loader').css('display', 'none');
				}
			});
		}).on("click", ".pjAsInstallPreview", function (e) {
			var tab = $(this).attr('data-tab');
			window.open("preview.php?tab=" + tab);
		});
	});
})(jQuery_1_8_2);