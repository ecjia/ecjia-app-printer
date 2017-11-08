<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->
<!-- {block name="footer"} -->
<script type="text/javascript">
    ecjia.admin.printer.init();
</script>
<!-- {/block} -->
<!-- {block name="main_content"} -->
<div>
    <h3 class="heading">
        <!-- {if $ur_here}{$ur_here}{/if} -->
        <!-- {if $action_link} -->
        <a class="data-pjax btn plus_or_reply" id="sticky_a" href="{$action_link.href}"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
        <!-- {/if} -->
    </h3>
</div>

<div class="row-fluid">
    <div class="span3">
        <!-- {ecjia:hook id=display_admin_store_menus} -->
    </div>
    <div class="span9">
 		<div class="panel-body panel-body-small">
 			<section class="panel">
                <table class="table table-striped table-advance table-hover">
                    <thead>
                        <tr>
                            <th class="w100">订单编号</th>
                            <th class="w120">打印机名称</th>
                            <th class="w150">内容</th>
                            <th class="w100">打印时间</th>
                            <th class="w50">打印状态</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- {foreach from=$record_list.item item=list} -->
                        <tr>
                            <td>{$list.order_sn}</td>
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
                <!-- {$record_list.page} -->
            </section>
		</div>
    </div>
</div>
<!-- {/block} -->
