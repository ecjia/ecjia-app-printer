// JavaScript Document
;(function (app, $) {
    app.printer = {
        init: function () {
        	 app.printer.form();
        	 app.printer.toggleButton();
        	 app.printer.slider();
        	 app.printer.remove_logo();
        	 app.printer.testForm();
        	 app.printer.toggle_view();
        },
        
        form: function () {
        	 var option = {
                 rules: {
                	 machine_code: {
                         required: true
                     },
                     machine_key: {
                         required: true
                     }
                 },
                 messages: {
                	 machine_code: {
                         required: "请输入终端编号"
                     },
                     machine_key: {
                         required: "请输入终端密钥"
                     }
                 },
                 submitHandler: function () {
                	 $('#uploadLogo').modal('hide');
                     $("form[name='theForm']").ajaxSubmit({
                         dataType: "json",
                         success: function (data) {
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
                    	'type': type,
                    	'action': 'edit_type'
                    }
                   	$.post(url, info, function(data) {
                   		ecjia.merchant.showmessage(data);
                   	});
                },  
            });
			$('.template-toggle-button').toggleButtons({
				label: {  
					disabled: "否", 
                	enabled: "是" 
                },  
                style: {
                    enabled: "info",
                    disabled: "success"
                },
            });
			
        	$('.view_key').off('click').on('click', function() {
        		var $this = $(this),
        			key = $this.attr('data-key'),
        			value = $this.attr('data-value'),
        			i = $this.children('i').attr('class');

        		if (i == 'fontello-icon-eye') {
        			$this.parent().find('.machine_key').html(value);
        			$this.children('i').attr('class', 'fontello-icon-eye-off')
        		} else {
        			$this.parent().find('.machine_key').html(key);
        			$this.children('i').attr('class', 'fontello-icon-eye')
        		}
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
	            	var v = parseInt($('.voice_value').html());
	            	$('.voice-slider-handle').attr("disabled", true);
	            	var url = $('.info-toggle-button').attr('data-url');
                	var voice = parseInt(values[handle]);
                	if (v == voice) {
                		$('.voice-slider-handle').attr("disabled", false);
                		return false;
                	}
                    var info = {
                      'voice': voice,
                      'action': 'edit_voice'
                    }
                   	$.post(url, info, function(data) {
                   		$('.voice-slider-handle').attr("disabled", false);
                   		ecjia.merchant.showmessage(data);
                   		if (data.state == 'success') {
                   			$('.voice_value').html(voice);
                   		}
                   	});
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
                            ecjia.merchant.showmessage(data);
                        }
                    });
                }
            }
            var options = $.extend(ecjia.merchant.defaultOptions.validate, option);
            $("form[name='testForm']").validate(options);
            
            $('.print_test').off('click').on('click', function() {
        		var type = $(this).attr('data-type'); 
        		var number = $('input[name="print_count"]').val();
        		var tail_content = $('input[name="tail_content"]').val();
        		var url = $(this).attr('data-url');
        		var info = {
        			type: type,
        			number: number,
        			tail_content: tail_content
        		}
        		$.post(url, info, function(data){
        			ecjia.merchant.showmessage(data);
        		});
        	});
       },
       
       toggle_view: function() {
           $('.toggle_view').off('click').on('click', function (e) {
               e.preventDefault();
               var $this = $(this);
               var url = $this.attr('href');
               $.post(url, function (data) {
            	   ecjia.merchant.showmessage(data);
               }, 'json');
           });
       }
    };  
})(ecjia.merchant, jQuery);
 
// end