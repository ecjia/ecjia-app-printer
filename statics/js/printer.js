// JavaScript Document
;(function (app, $) {
    app.printer = {
        init: function () {
        	 app.printer.form();
        	 app.printer.toggleButton();
        },
        
        form: function () {
        	 var option = {
                 rules: {
                	 printer_code: {
                         required: true
                     },
                     printer_key: {
                         required: true
                     }
                 },
                 messages: {
                	 printer_code: {
                         required: "请输入终端编号"
                     },
                     printer_key: {
                         required: "请输入终端密钥"
                     }
                 },
                 submitHandler: function () {
                     $("form[name='theForm']").ajaxSubmit({
                         dataType: "json",
                         success: function (data) {
                             ecjia.admin.showmessage(data);
                         }
                     });
                 }
             }
             var options = $.extend(ecjia.admin.defaultOptions.validate, option);
             $("form[name='theForm']").validate(options);
        },
        
        toggleButton: function() {
			$('.info-toggle-button').toggleButtons({
				label: {  
                     enabled: "蜂鸣器",  
                     disabled: "喇叭"  
                },  
                style: {
                    enabled: "info",
                    disabled: "success"
                },
                onChange: function($el, status, e) {  
                    var type = $('input[name="voice_type"]').val();
                    if (status && type == 'buzzer') {
                    	return false
                    } else if (!status && type == 'horn') {
                    	return false;
                    }
                    var url = $('.info-toggle-button').attr('data-url');
                    var info = {
                    	'type': type
                    }
                   	$.post(url, info, function(data) {
                   		ecjia.admin.showmessage(data);
                   	});
                },  
            });
        }
    };  
 
})(ecjia.admin, jQuery);
 
// end