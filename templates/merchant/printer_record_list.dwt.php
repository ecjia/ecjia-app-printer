<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-merchant.dwt.php"} -->
<!-- {block name="footer"} -->
<script type="text/javascript">
//     ecjia.admin.printer.init();
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
                        	<li><a class="setting-group-item data-pjax" href='{url path="printer/mh_print/init"}'>普通订单小票</a></li>
                        	<li><a class="setting-group-item data-pjax m_t5" href='{url path="printer/mh_print/record_list"}'>外卖订单小票</a></li>
                        	<li><a class="setting-group-item data-pjax m_t5" href='{url path="printer/mh_print/record_list"}'>到店购物小票</a></li>
                        	<li><a class="setting-group-item data-pjax m_t5" href='{url path="printer/mh_print/record_list"}'>优惠买单小票</a></li>
                        </ul>
                    </div>
                </div>
                
                <div class="col-lg-9">
                	<h3 class="page-header">
                    	<div class="pull-left">打印记录</div>
						<div class="clearfix"></div>
  					</h3>
  								<div class="panel-body panel-body-small">
				<section class="panel">
					<table class="table table-striped table-hover table-hide-edit ecjiaf-tlf">
						<thead>
							<tr>
                                <th class="w100">订单编号</th>
                                <th class="w120">打印机名称</th>
                                <th class="w150">内容</th>
                                <th class="w120">打印时间</th>
                                <th class="w60">打印状态</th>
                            </tr>
						</thead>
						<tbody>
			            	<!-- {foreach from=$record_list.item item=list} -->
                            <tr>
                                <td class="hide-edit-area">
                                	{$list.order_sn}
                                	<div class="edit-list">
                                		<a class="data-pjax" href="javascript:;">重新打印</a>
                                	</div>
                                </td>
                                <td>{$list.printer_name}</td>
                                <td>{$list.content}</td>
                                <td>{RC_Time::local_date('Y-m-d H:i:s', $list['print_time'])}</td>
                                <td>
                                	{if $list.status eq 0}
                                	待打印
                                	{else if $list.status eq 1}
                                	打印完成
                                	{else if $list.status eq 2}
                                	打印异常
                                	{else if $list.status eq 3}
                                	取消打印
                                	{/if}
                                </td>
                            </tr>
                            <!-- {foreachelse} -->
                            <tr><td class="no-records" colspan="5">{lang key='system::system.no_records'}</td></tr>
                            <!-- {/foreach} -->
						</tbody>
					</table>
				</section>
			</div>
            	</div>
        	</div>
        </div>
    </div>
</div>
<!-- {/block} -->
