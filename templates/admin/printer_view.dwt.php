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
        <a class="data-pjax btn plus_or_reply" id="sticky_a" href='{url path="printer/admin/view" args="id={$info.id}&store_id={$info.store_id}"}'>刷新打印机状态</a>
    </h3>
</div>

<div class="row-fluid">
    <div class="span12">
		<div class="box basic_info">
			<div class="title">基本信息</div>
			<div class="info_content">
				<div class="info_left">
					<img src="{$statics_url}images/click_upload.png" />
					<div class="left_bottom">
						<img class="close_img" src="{$statics_url}images/close.png" />
						<img class="refresh_img" src="{$statics_url}images/refresh.png" />
					</div>
				</div>
				
				<div class="info_right">
					<div class="name">{$info.printer_name}</div>
					<div class="right-item">终端编号：{$info.printer_code}</div>
					<div class="right-item">终端密钥：{$info.printer_key}</div>
					<div class="right-item">手机卡号：{$info.printer_mobile}</div>
					<div class="right-item">打印机型：{$info.version}</div>
					<div class="right-item">添加时间：{RC_Time::local_date('Y-m-d H:i:s', $info['add_time'])}</div>
				</div>
				
				<div class="info_status">
					{if $info.online_status eq 1}
        			<span class="status">在线</span>
        			{else if $info.online_status eq 2}
        			<span class="status error">离线</span>
        			{else if $info.online_status eq 0}
        			<span class="status error">缺纸</span>
        			{/if}
				</div>
			</div>
		</div>
		
		<div class="box voice_handle">
			<div class="title">声音调节</div>
			<div class="info_content">
				<div class="voice_type">
					<span class="label_type">响铃类型</span>
		            <div class="info-toggle-button" data-url="{$control_url}">
		                <input class="nouniform" name="voice_type" type="checkbox" {if $info.voice_type eq 'buzzer'}checked{/if} value="{$info.voice_type}"/>
		            </div>
	            </div>
				<div class="voice-item">音量调节<span>{$info.voice}</span></div>
			</div>
		</div>
		
		<div class="box printer_control">
			<div class="title">打印控制</div>
			<div class="info_content">
				<a class="btn btn-info" data-toggle="ajaxremove" data-msg="您确定要取消所有未打印吗？" href='{RC_Uri::url("printer/admin/cancel", "id={$info.id}&store_id={$info.store_id}")}'>取消所有未打印</a>
				<div class="help-block">取消后，此台打印机设备将不再打印剩下的所有订单</div>
			</div>
		</div>
		
		<div class="box print_stats">
			<div class="title">打印统计</div>
			<div class="stats_content">
				<div class="stats-item">
					<div class="item-li"><img src="{$statics_url}images/week_print.png" /></div>
					<div class="item-li count">2000</div>
					<div class="item-li name">周打印量</div>
				</div>
				<div class="stats-item">
					<div class="item-li"><img src="{$statics_url}images/today_print.png" /></div>
					<div class="item-li count">420</div>
					<div class="item-li name">今日打印量</div>
				</div>
				<div class="stats-item">
					<div class="item-li"><img src="{$statics_url}images/unprint.png" /></div>
					<div class="item-li count">160</div>
					<div class="item-li name">今日未打印量</div>
				</div>
			</div>
		</div>
    </div>
</div>
<!-- {/block} -->