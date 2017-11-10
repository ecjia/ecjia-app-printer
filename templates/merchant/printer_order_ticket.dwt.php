<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-merchant.dwt.php"} -->
<!-- {block name="footer"} -->
<script type="text/javascript">
    ecjia.merchant.printer.init();
</script>
<!-- {/block} -->
<!-- {block name="home-content"} -->
<div class="page-header">
	<div class="pull-left">
		<h2><!-- {if $ur_here}{$ur_here}{/if} --></h2>
  	</div>
  	<div class="clearfix"></div>
</div>
<style media="screen" type="text/css">

</style>
<div class="row">
    <div class="col-lg-12">
        <div class="panel">
            <div class="panel-body">
                <div class="col-lg-3">
                    <div class="setting-group">
                        <span class="setting-group-title"><i class="fa fa-gear"></i> 小票打印设置</span>
                        <ul class="nav nav-list m_t10 change">
                        	<li class="nav-list-title">打印机管理</li>
                        	<li><a class="setting-group-item data-pjax {if $type eq 'printer_manage'}llv-active{/if}" href='{url path="printer/mh_print/init"}'>打印机管理</a></li>
                        	<li><a class="setting-group-item data-pjax m_t5 {if $type eq 'printer_record'}llv-active{/if}" href='{url path="printer/mh_print/record_list"}'>打印记录</a></li>
                        </ul>
                        <ul class="nav nav-list m_t10 change">
                        	<li class="nav-list-title">小票分类模版</li>
                        	<li><a class="setting-group-item data-pjax {if $smarty.get.type eq 'normal'}llv-active{/if}" href='{url path="printer/mh_print/order_ticket" args="type=normal"}'>普通订单小票</a></li>
                        	<li><a class="setting-group-item data-pjax m_t5 {if $smarty.get.type eq 'take_out'}llv-active{/if}" href='{url path="printer/mh_print/order_ticket" args="type=take_out"}'>外卖订单小票</a></li>
                        	<li><a class="setting-group-item data-pjax m_t5 {if $smarty.get.type eq 'store_buy'}llv-active{/if}" href='{url path="printer/mh_print/order_ticket" args="type=store_buy"}'>到店购物小票</a></li>
                        	<li><a class="setting-group-item data-pjax m_t5 {if $smarty.get.type eq 'pay_bill'}llv-active{/if}" href='{url path="printer/mh_print/order_ticket" args="type=pay_bill"}'>优惠买单小票</a></li>
                        </ul>
                    </div>
                </div>
                
                <div class="col-lg-9">
                	<h3 class="page-header">
                    	<div class="pull-left">打印机自定义设置</div>
						<div class="clearfix"></div>
  					</h3>
  					<div class="row m_t20">
						<div class="col-lg-6">
							<!-- {if $smarty.get.type eq 'normal'} -->
								<!-- #BeginLibraryItem "/library/normal.lbi" --><!-- #EndLibraryItem -->
							<!-- {else if $smarty.get.type eq 'take_out'} -->
								<!-- #BeginLibraryItem "/library/take_out.lbi" --><!-- #EndLibraryItem -->
							<!-- {else if $smarty.get.type eq 'store_buy'} -->
								<!-- #BeginLibraryItem "/library/store_buy.lbi" --><!-- #EndLibraryItem -->
							<!-- {else if $smarty.get.type eq 'pay_bill'} -->
								<!-- #BeginLibraryItem "/library/pay_bill.lbi" --><!-- #EndLibraryItem -->
							<!-- {/if} -->
						</div>
						<div class="col-lg-6">
							<div class="ticket_form">
								<form class="form-horizontal ticket_form" name="theForm" method="post" action="{$form_action}">
				                 	<div class="form-group">
			                            <label class="control-label col-lg-5">{t}模版名称{/t}</label>
			                            <div class="col-lg-7">普通订单小票</div>
			                        </div>
			                       	<div class="form-group">
			                            <label class="control-label col-lg-5">{t}模版代号{/t}</label>
			                            <div class="col-lg-7">模版001</div>
			                        </div>
			                        <div class="form-group">
			                            <label class="control-label col-lg-5">{t}打印数量{/t}</label>
			                            <div class="col-lg-7">
			                            	<input class="form-control" type="number" value="1" min="1" max="9" name="print_count">
			                            	<span class="help-block">默认设置为1份，最多可设置9份</span>
			                            </div>
			                        </div>
			                        <div class="form-group">
			                            <label class="control-label col-lg-5">{t}是否启用此模版{/t}</label>
			                            <div class="col-lg-7">
			                            	<div class="template-toggle-button">
								                <input class="nouniform" name="status" type="checkbox" {if $info.status eq 1}checked{/if} value="1"/>
								            </div>
			                            </div>
			                        </div>
			                        <div class="form-group">
			                            <label class="control-label col-lg-5">{t}是否开启自动打印{/t}</label>
			                            <div class="col-lg-7">
			                            	<div class="template-toggle-button">
								                <input class="nouniform" name="auto_print" type="checkbox" {if $info.auto_print eq 1}checked{/if} value="1"/>
								            </div>
			                            </div>
			                        </div>
			                        
			                        <div class="form-group m_b0">
			                            <label class="control-label col-lg-5">{t}自定义尾部信息{/t}</label>
			                            <div class="col-lg-12 m_t10">
			                            	<textarea class="form-control tail_textarea" name="tail_content"></textarea>
			                            	<span class="help-block">如需换行，可在输入框中使用"<xmp><br/></xmp>"字符</span>
			                            </div>
			                        </div>
			                        
			                        <div class="form-group">
			                        	<div class="col-lg-12">
			                                <input class="btn btn-info" type="submit" value="保存打印模版">
			                                <a class="btn btn-info m_l10" href="javascript:;">打印测试</a>
			                            </div>
			                        </div>
			                  	</form>
							</div>
						</div>
					</div>
            	</div>
        	</div>
        </div>
    </div>
</div>
<!-- {/block} -->
