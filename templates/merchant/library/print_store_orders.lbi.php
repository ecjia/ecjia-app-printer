<div class="ticket_box">
	<div class="ticket_box_header">
		<div class="store_logo"><img src="{$store.shop_logo}" /></div>
		<div class="store_name">{$store.merchants_name}</div>
		<div class="store_mobile">{$store.contact_mobile}</div>
	</div>
	<div class="ticket_content">
		<div class="ticket-item">收银员：{$data.cashier}</div>
		<div class="ticket-item">订单编号：{$data.order_sn}</div>
		<div class="ticket-item">流水编号：{$data.order_trade_no}</div>
		<div class="ticket-item">下单时间：{$data.purchase_time}</div>
		<div class="ticket-item">商家地址：{$data.merchant_address}</div>
	</div>
	<div class="ticket_content">
		<ul>
			<li>商品</li>
			<li>数量</li>
			<li>单价</li>
		</ul>
		<!-- {foreach from=$data.goods_lists item=list} -->
		<p>{$list.goods_name}</p>
		<ul>
			<li>&nbsp;</li>
			<li>{$list.goods_number}</li>
			<li>{$list.goods_amount}</li>
		</ul>
		<!-- {/foreach} -->
		<span class="total">总计：{$data.goods_subtotal}</span>
	</div>	
	<div class="ticket_content no_dashed">
		<div class="ticket-item">优惠金额：{$data.discount_amount}</div>
		<div class="ticket-item">应收金额：{$data.receivables}</div>
		<div class="ticket-item">支付宝：{$data.payment}</div>
		<div class="ticket-item">分头舍去：{$data.rounding}</div>
		<div class="ticket-item">实收金额：{$data.order_amount}</div>
	</div>
	{if $info.tail_content}
		{$info.tail_content}
	{/if}							
</div>