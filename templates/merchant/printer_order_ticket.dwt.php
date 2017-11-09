<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-merchant.dwt.php"} -->
<!-- {block name="footer"} -->
<script type="text/javascript">
//     ecjia.merchant.printer.init();
</script>
<!-- {/block} -->
<!-- {block name="home-content"} -->
<div class="page-header">
	<div class="pull-left">
		<h2><!-- {if $ur_here}{$ur_here}{/if} --></h2>
  	</div>
  	<div class="clearfix"></div>
</div>

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
  					<div class="panel-body panel-body-small">
						
					</div>
            	</div>
        	</div>
        </div>
    </div>
</div>
<!-- {/block} -->
