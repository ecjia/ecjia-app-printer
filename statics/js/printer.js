// JavaScript Document
;(function (app, $) {
    app.printer = {
        init: function () {
        	 app.printer.form();
        	 app.printer.toggleButton();
        	 app.printer.slider();
        	 app.printer.remove_logo();
        	 app.printer.testForm();
        },
        
        form: function () {
        	$('.view_key').off('click').on('click', function() {
        		var $this = $(this),
        			key = $this.attr('data-key'),
        			value = $this.attr('data-value'),
        			i = $this.children('i').attr('class');

        		if (i == 'fontello-icon-eye') {
        			$this.parent().find('.printer_key').html(value);
        			$this.children('i').attr('class', 'fontello-icon-eye-off')
        		} else {
        			$this.parent().find('.printer_key').html(key);
        			$this.children('i').attr('class', 'fontello-icon-eye')
        		}
        	});
        	
        	$('.toggle-printer-button').toggleButtons({
				label: {  
                     enabled: "开启",  
                     disabled: "关闭"  
                },  
                style: {
                    enabled: "info",
                    disabled: "success"
                }
            });
        	var option = {
				 rules: {
					 printer_code: {
				         required: true
				     },
				     printer_key: {
				         required: true
				     },
				     app_key: {
				         required: true
				     },
				     app_secret: {
				         required: true
				     },
				 },
                 messages: {
                	 printer_code: {
                         required: "请输入终端编号"
                     },
                     printer_key: {
                         required: "请输入终端密钥"
                     },
                     app_key: {
                         required: "请输入App Key"
                     },
                     app_secret: {
                         required: "请输入App Secret"
                     }
                 },
                 submitHandler: function () {
                	 $('#uploadLogo').modal('hide');
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
	                   		ecjia.admin.showmessage(data);
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
	                   		ecjia.admin.showmessage(data);
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
        },
        
        testForm: function () {
        	var option = {
       			 submitHandler: function () {
       				$('#testPrint').modal('hide');
                    $("form[name='testForm']").ajaxSubmit({
                        dataType: "json",
                        success: function (data) {
                            ecjia.admin.showmessage(data);
                        }
                    });
                }
            }
            var options = $.extend(ecjia.admin.defaultOptions.validate, option);
            $("form[name='testForm']").validate(options);
       },
    };  
})(ecjia.admin, jQuery);
 
// end