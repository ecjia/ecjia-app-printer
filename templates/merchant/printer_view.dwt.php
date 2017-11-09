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
  	<div class="pull-right">
		<a class="btn btn-primary data-pjax plus_or_reply" id="sticky_a" href='{url path="printer/mh_print/view" args="id={$info.id}"}'>刷新打印机状态</a>
  		{if $action_link}
		<a href="{$action_link.href}" class="btn btn-primary data-pjax">
			<i class="fa fa-reply"></i> {$action_link.text}
		</a>
		{/if}
  	</div>
  	<div class="clearfix"></div>
</div>

<div class="row">
    <div class="col-lg-12">
		<div class="printer_box  basic_info">
			<div class="title">基本信息</div>
			<div class="info_content">
				<div class="info_left">
					<a data-toggle="modal" href="#uploadLogo"><img class="printer_logo" src="{if $info.printer_logo}{$info.printer_logo}{else}{$statics_url}images/click_upload.png{/if}" /></a>
					<div class="left_bottom">
						<a data-toggle="ajaxremove" data-msg="您确定要关闭该打印机吗？" href='{RC_Uri::url("printer/mh_print/close", "id={$info.id}")}'>
							<img class="close_img" src="{$statics_url}images/close.png" />
						</a>
						<a class="data-pjax" href='{url path="printer/mh_print/view" args="id={$info.id}"}'>
							<img class="refresh_img" src="{$statics_url}images/refresh.png" />
						</a>
					</div>
				</div>
				
				<div class="info_right">
					<span class="name cursor_pointer merchant_printer" data-trigger="editable" data-url="{RC_Uri::url('printer/mh_print/edit_printer_name')}" data-name="edit_printer_name" data-pk="{$info.id}" data-title="请输入打印机名称">{$info.printer_name}</span>
					<div class="right-item">终端编号：{$info.printer_code}</div>
					<div class="right-item">终端密钥：{$info.printer_key}</div>
					<div class="right-item">手机卡号：<span class="cursor_pointer" data-trigger="editable" data-url="{RC_Uri::url('printer/mh_print/edit_printer_mobile')}" data-name="edit_printer_mobile" data-pk="{$info.id}" data-title="请输入手机卡号">{$info.printer_mobile}</span></div>
					<div class="right-item">打印机型：{$info.version}</div>
					<div class="right-item">添加时间：{RC_Time::local_date('Y-m-d H:i:s', $info['add_time'])}</div>
				</div>
				
				<div class="info_status">
					{if $info.online_status eq 1}
        			<span class="status">在线</span>
        			{else if $info.online_status eq 2}
        			<span class="status error">缺纸</span>
        			{else if $info.online_status eq 0}
        			<span class="status error">离线</span>
        			{/if}
				</div>
			</div>
		</div>
		
		<div class="printer_box voice_handle">
			<div class="title">声音调节</div>
			<div class="info_content">
				<div class="voice_type">
					<span class="label_type">响铃类型</span>
		            <div class="info-toggle-button" data-url="{$control_url}">
		                <input class="nouniform" name="voice_type" type="checkbox" {if $info.voice_type eq 'buzzer'}checked{/if} value="{$info.voice_type}"/>
		            </div>
	            </div>
				<div class="voice-item">音量调节<span class="voice_value">{$info.voice}</span></div>
				<div id="voice-slider"></div>
			</div>
		</div>
		
		<div class="printer_box printer_control">
			<div class="title">打印控制</div>
			<div class="info_content">
				<a class="btn btn-primary" data-toggle="ajaxremove" data-msg="您确定要取消所有未打印吗？" href='{RC_Uri::url("printer/mh_print/cancel", "id={$info.id}")}'>取消所有未打印</a>
				<div class="help-block">取消后，此台打印机设备将不再打印剩下的所有订单</div>
			</div>
		</div>
		
		<div class="printer_box print_stats">
			<div class="title">打印统计</div>
			<div class="stats_content">
				<div class="stats-item">
					<div class="item-li"><img src="{$statics_url}images/week_print.png" /></div>
					<div class="item-li count">{$count.week_count}</div>
					<div class="item-li name">本周打印量</div>
				</div>
				<div class="stats-item">
					<div class="item-li"><img src="{$statics_url}images/today_print.png" /></div>
					<div class="item-li count">{$count.today_print_count}</div>
					<div class="item-li name">今日打印量</div>
				</div>
				<div class="stats-item">
					<div class="item-li"><img src="{$statics_url}images/unprint.png" /></div>
					<div class="item-li count">{$count.today_unprint_count}</div>
					<div class="item-li name">今日未打印量</div>
				</div>
			</div>
		</div>
    </div>
</div>


										

<div class="modal fade" id="uploadLogo">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button class="close" data-dismiss="modal">×</button>
				<h3>上传打印LOGO</h3>
			</div>
			<div class="modal-body form-horizontal">
				<form class="form-horizontal" method="post" name="theForm" action="{url path='printer/mh_print/upload_logo'}">
					<div class="form-group">
						<label class="control-label col-lg-3">{t}上传LOGO：{/t}</label>
						<div class="col-lg-6">
							<div class="fileupload fileupload-{if $info.printer_logo}exists{else}new{/if}" data-provides="fileupload">
		                        {if $info.printer_logo}
		                        <div class="fileupload-{if $info.printer_logo}exists{else}new{/if} thumbnail" style="max-width: 60px;">
		                            <img src="{$info.printer_logo}" style="width:50px; height:50px;"/>
		                        </div>
		                        {/if}
		                        <div class="fileupload-preview fileupload-{if $info.printer_logo}new{else}exists{/if} thumbnail" style="max-width: 60px;max-height: 60px;line-height: 10px;"></div>
		                        <span class="btn btn-primary btn-file btn-sm">
		                            <span class="fileupload-new"><i class="fa fa-paper-clip"></i>浏览</span>
		                            <span class="fileupload-exists"> 修改</span>
		                            <input type="file" class="default" name="printer_logo" />
		                        </span>
		                        <a class="btn btn-danger btn-sm fileupload-exists {if $info.printer_logo}remove_logo{/if}" {if $info.printer_logo}data-toggle="ajaxremove" data-msg="您确定要删除该打印机logo吗？"{else}data-dismiss="fileupload"{/if} data-href='{url path='printer/mh_print/del_file' args="id={$info.id}"}' >删除</a>
		                    </div>
		                    <span class="help-block">推荐图片宽高：350px 文件大小：40kb</span>
						</div>
					</div>
					<div class="form-group t_c">
						<button class="btn btn-primary" type="submit">{t}确定{/t}</button>
						<input type="hidden" name="id" value="{$info.id}"/>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
	
<!-- {/block} -->