// JavaScript Document
;(function (app, $) {
    app.printer = {
        init: function () {
        	 app.printer.form();
        	 app.printer.toggleButton();
        	 app.printer.slider();
        	 app.printer.remove_logo();
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
                        	 $('#uploadLogo').modal('hide');
                             ecjia.merchant.showmessage(data);
                         }
                     });
                 }
             }
             var options = $.extend(ecjia.merchant.defaultOptions.validate, option);
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
                   		ecjia.merchant.showmessage(data);
                   	});
                },  
            });
        },
        
        slider: function() {
        	var voiceSlider = document.getElementById('voice-slider');
        	if (voiceSlider != null) {
	        	var v = parseInt($('.voice_value').html());
	            noUiSlider.create(voiceSlider, {
	                start: v,
	                step: 1,
	                range: {
	                    'min': 0,
	                    'max': 3
	                }
	            });
	            voiceSlider.noUiSlider.on('change', function ( values, handle ) {
	            	var url = $('.info-toggle-button').attr('data-url');
	            	if (values[handle] < 1 && v == 1) {
	            		voiceSlider.noUiSlider.set(1);
	            		return false;
	            	} else if (values[handle] < 1) {
	                    var info = {
	                    	'voice': 1
	                    }
	                   	$.post(url, info, function(data) {
	                   		ecjia.merchant.showmessage(data);
	                   		if (data.state == 'success') {
	                   			voiceSlider.noUiSlider.set(1);
	                   			$('.voice_value').html(1);
	                   		}
	                   	});
	                } else {
	                	var voice = parseInt(values[handle]);
	                    var info = {
	                      'voice': voice
	                    }
	                   	$.post(url, info, function(data) {
	                   		ecjia.merchant.showmessage(data);
	                   		if (data.state == 'success') {
	                   			$('.voice_value').html(voice);
	                   		}
	                   	});
	                }
	            });
        	}
        },
        
        remove_logo: function() {
        	$('.remove_logo').off('click').on('click', function() {
        		$('#uploadLogo').modal('hide');
        	});
        }
    };  
})(ecjia.merchant, jQuery);
 
// end