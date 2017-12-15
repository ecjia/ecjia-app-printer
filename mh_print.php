<?php
//
//    ______         ______           __         __         ______
//   /\  ___\       /\  ___\         /\_\       /\_\       /\  __ \
//   \/\  __\       \/\ \____        \/\_\      \/\_\      \/\ \_\ \
//    \/\_____\      \/\_____\     /\_\/\_\      \/\_\      \/\_\ \_\
//     \/_____/       \/_____/     \/__\/_/       \/_/       \/_/ /_/
//
//   上海商创网络科技有限公司
//
//  ---------------------------------------------------------------------------------
//
//   一、协议的许可和权利
//
//    1. 您可以在完全遵守本协议的基础上，将本软件应用于商业用途；
//    2. 您可以在协议规定的约束和限制范围内修改本产品源代码或界面风格以适应您的要求；
//    3. 您拥有使用本产品中的全部内容资料、商品信息及其他信息的所有权，并独立承担与其内容相关的
//       法律义务；
//    4. 获得商业授权之后，您可以将本软件应用于商业用途，自授权时刻起，在技术支持期限内拥有通过
//       指定的方式获得指定范围内的技术支持服务；
//
//   二、协议的约束和限制
//
//    1. 未获商业授权之前，禁止将本软件用于商业用途（包括但不限于企业法人经营的产品、经营性产品
//       以及以盈利为目的或实现盈利产品）；
//    2. 未获商业授权之前，禁止在本产品的整体或在任何部分基础上发展任何派生版本、修改版本或第三
//       方版本用于重新开发；
//    3. 如果您未能遵守本协议的条款，您的授权将被终止，所被许可的权利将被收回并承担相应法律责任；
//
//   三、有限担保和免责声明
//
//    1. 本软件及所附带的文件是作为不提供任何明确的或隐含的赔偿或担保的形式提供的；
//    2. 用户出于自愿而使用本软件，您必须了解使用本软件的风险，在尚未获得商业授权之前，我们不承
//       诺提供任何形式的技术支持、使用担保，也不承担任何因使用本软件而产生问题的相关责任；
//    3. 上海商创网络科技有限公司不对使用本产品构建的商城中的内容信息承担责任，但在不侵犯用户隐
//       私信息的前提下，保留以任何方式获取用户信息及商品信息的权利；
//
//   有关本产品最终用户授权协议、商业授权与技术服务的详细内容，均由上海商创网络科技有限公司独家
//   提供。上海商创网络科技有限公司拥有在不事先通知的情况下，修改授权协议的权力，修改后的协议对
//   改变之日起的新授权用户生效。电子文本形式的授权协议如同双方书面签署的协议一样，具有完全的和
//   等同的法律效力。您一旦开始修改、安装或使用本产品，即被视为完全理解并接受本协议的各项条款，
//   在享有上述条款授予的权力的同时，受到相关的约束和限制。协议许可范围以外的行为，将直接违反本
//   授权协议并构成侵权，我们有权随时终止授权，责令停止损害，并保留追究相关责任的权力。
//
//  ---------------------------------------------------------------------------------
//
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 小票机管理
 */
class mh_print extends ecjia_merchant
{
    public function __construct()
    {
        parent::__construct();

        RC_Loader::load_app_func('global');
        assign_adminlog_content();

        //全局JS和CSS
        RC_Script::enqueue_script('jquery-form');
        RC_Script::enqueue_script('smoke');
        RC_Style::enqueue_style('uniform-aristo');

        RC_Script::enqueue_script('bootstrap-editable-script', dirname(RC_App::app_dir_url(__FILE__)) . '/merchant/statics/assets/bootstrap-fileupload/bootstrap-fileupload.js', array());
        RC_Style::enqueue_style('bootstrap-fileupload', dirname(RC_App::app_dir_url(__FILE__)) . '/merchant/statics/assets/bootstrap-fileupload/bootstrap-fileupload.css', array(), false, false);

        RC_Script::enqueue_script('ecjia-mh-editable-js');
        RC_Style::enqueue_style('ecjia-mh-editable-css');

        RC_Script::enqueue_script('jquery.toggle.buttons', RC_Uri::admin_url('statics/lib/toggle_buttons/jquery.toggle.buttons.js'));
        RC_Style::enqueue_style('bootstrap-toggle-buttons', RC_Uri::admin_url('statics/lib/toggle_buttons/bootstrap-toggle-buttons.css'));

        RC_Style::enqueue_style('fontello', RC_Uri::admin_url('statics/lib/fontello/css/fontello.css'));

        RC_Style::enqueue_style('nouislider', RC_App::apps_url('statics/css/jquery.nouislider.css', __FILE__), array());
        RC_Script::enqueue_script('nouislider', RC_App::apps_url('statics/js/jquery.nouislider.min.js', __FILE__), array(), false, false);

        RC_Style::enqueue_style('merchant_printer', RC_App::apps_url('statics/css/merchant_printer.css', __FILE__), array());
        RC_Style::enqueue_style('printer', RC_App::apps_url('statics/css/printer.css', __FILE__), array());
        RC_Script::enqueue_script('mh_printer', RC_App::apps_url('statics/js/mh_printer.js', __FILE__), array(), false, false);
    }

    /**
     * 小票机管理
     */
    public function init()
    {
        $this->admin_priv('merchant_printer_manage');

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here('小票打印设置'));

        $this->assign('ur_here', '小票打印设置');
        $this->assign('add_url', RC_Uri::url('printer/mh_print/add', array('store_id' => $_SESSION['store_id'])));

        $printer_list = RC_DB::table('printer_machine')->where('store_id', $_SESSION['store_id'])->orderBy('id', 'asc')->get();
        $this->assign('list', $printer_list);

        $statics_url = RC_App::apps_url('statics/', __FILE__);
        $this->assign('statics_url', $statics_url);
        $this->assign('type', 'printer_manage');

        $this->display('printer_list.dwt');
    }

    public function view()
    {
        $this->admin_priv('merchant_printer_manage');

        $id   = intval($_GET['id']);
        $info = RC_DB::table('printer_machine')->where('store_id', $_SESSION['store_id'])->where('id', $id)->first();
        if (empty($info)) {
            return $this->showmessage('该小票机不存在', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        if (!empty($info['machine_logo'])) {
            $info['machine_logo'] = RC_Upload::upload_url($info['machine_logo']);
        }
        if (!empty($info['machine_key'])) {
        	$len = strlen($info['machine_key']);
        	$info['machine_key_star'] = substr_replace($info['machine_key'], str_repeat('*', $len), 0, $len);
        }
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here('查看小票机'));

        $this->assign('action_link', array('href' => RC_Uri::url('printer/mh_print/init'), 'text' => '小票机管理'));
        $this->assign('ur_here', '查看小票机');
        $this->assign('info', $info);

        $statics_url = RC_App::apps_url('statics/', __FILE__);
        $this->assign('statics_url', $statics_url);
        $this->assign('control_url', RC_Uri::url('printer/mh_print/voice_control', array('id' => $id)));

        $count = $this->get_print_count();
        $this->assign('count', $count);

        $this->display('printer_view.dwt');
    }

    public function cancel()
    {
        $this->admin_priv('merchant_printer_update', ecjia::MSGTYPE_JSON);
        $id = !empty($_GET['id']) ? intval($_GET['id']) : 0;

        $data = RC_DB::table('printer_machine')->where('store_id', $_SESSION['store_id'])->where('id', $id)->first();
        $rs = ecjia_printer::cancelAll($data['machine_code']);
        if (is_ecjia_error($rs)) {
        	return $this->showmessage($rs->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        $this->showmessage('取消成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('printer/mh_print/view', array('id' => $id))));
    }

    public function close()
    {
        $this->admin_priv('merchant_printer_update', ecjia::MSGTYPE_JSON);

        $id = !empty($_GET['id']) ? intval($_GET['id']) : 0;

        $data = RC_DB::table('printer_machine')->where('store_id', $_SESSION['store_id'])->where('id', $id)->first();
        
        $rs = ecjia_printer::shutdown($data['machine_code']);
        if (is_ecjia_error($rs)) {
        	return $this->showmessage($rs->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        
        RC_DB::table('printer_machine')->where('store_id', $_SESSION['store_id'])->where('id', $id)->update(array('online_status' => 0));
        $this->showmessage('关闭成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('printer/mh_print/view', array('id' => $id))));
    }
    
    //重启
    public function restart()
    {
    	$this->admin_priv('merchant_printer_update', ecjia::MSGTYPE_JSON);
    	 
    	$id = !empty($_GET['id']) ? intval($_GET['id']) : 0;
    	 
    	$data = RC_DB::table('printer_machine')->where('store_id', $_SESSION['store_id'])->where('id', $id)->first();
    	$rs = ecjia_printer::restart($data['machine_code']);
    	if (is_ecjia_error($rs)) {
    		return $this->showmessage($rs->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    	}
    	 
    	RC_DB::table('printer_machine')->where('store_id', $store_id)->where('id', $id)->update(array('online_status' => 1));
    	$this->showmessage('重启成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('printer/mh_print/view', array('id' => $id))));
    }
    
    public function voice_control()
    {
        $this->admin_priv('merchant_printer_update', ecjia::MSGTYPE_JSON);
	
        $action = trim($_POST['action']);
        $id    = !empty($_GET['id']) ? intval($_GET['id']) : 0;
        $type  = isset($_POST['type']) ? trim($_POST['type']) : '';
        $voice = isset($_POST['voice']) ? intval($_POST['voice']) : 0;

        $info = RC_DB::table('printer_machine')->where('store_id', $_SESSION['store_id'])->where('id', $id)->first();
        if ($action == 'edit_type') {
        	$response_type = $type == 'buzzer' ? 'horn' : 'buzzer';
        	$voice = $info['voice'];
        } else {
        	$response_type = $info['voice_type'];
        }
        $rs = ecjia_printer::setSound($info['machine_code'], $response_type, $voice);
        if (is_ecjia_error($rs)) {
        	return $this->showmessage($rs->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        
        if ($action == 'edit_type') {
            $type = $type == 'buzzer' ? 'horn' : 'buzzer';
            RC_DB::table('printer_machine')->where('store_id', $_SESSION['store_id'])->where('id', $id)->update(array('voice_type' => $type));
            $this->showmessage('响铃类型修改成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
        } else {
            RC_DB::table('printer_machine')->where('store_id', $_SESSION['store_id'])->where('id', $id)->update(array('voice' => $voice));
            $this->showmessage('音量修改成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
        }
    }

    public function record_list()
    {
        $this->admin_priv('merchant_printer_manage');

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here('小票打印设置'));
        $this->assign('ur_here', '小票打印设置');

        $record_list = $this->get_record_list();
        $this->assign('record_list', $record_list);
        $this->assign('type', 'printer_record');

        $this->display('printer_record_list.dwt');
    }
    
    //打印测试
    public function printer_test()
    {
    	$this->admin_priv('merchant_printer_update', ecjia::MSGTYPE_JSON);
    
    	$id = !empty($_POST['id']) ? intval($_POST['id']) : 0;
    
    	$content = !empty($_POST['content']) ? strip_tags($_POST['content']) : '';
    	if (empty($content)) {
    		return $this->showmessage('请输入要打印的内容', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    	}
    	$print_number = !empty($_POST['print_number']) ? (intval($_POST['print_number']) > 9 ? 9 : intval($_POST['print_number'])) : 1;
    
    	$data = RC_DB::table('printer_machine')->where('store_id', $_SESSION['store_id'])->where('id', $id)->first();
    	$order_sn = date('YmdHis') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
    
    	$content = "<MN>$print_number</MN>".$content;
    	$rs = ecjia_printer::printSend($data['machine_code'], $content, $order_sn);
    	if (is_ecjia_error($rs)) {
    		return $this->showmessage($rs->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    	}
    	return $this->showmessage('测试打印成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('printer/mh_print/view', array('id' => $id))));
    }

    //小票模板打印
    public function print_order_ticker()
    {
        $this->admin_priv('merchant_printer_update', ecjia::MSGTYPE_JSON);
        $type  = trim($_POST['type']);
        
        $info = RC_DB::table('printer_template')->where('store_id', $_SESSION['store_id'])->where('template_code', $type)->first();
        if (!empty($info)) {
        	$number = $info['print_number'];
        	$tail_content = $info['tail_content'];
        } else {
        	$number = 1;
        	$tail_content = '';
        }
        
        $array = array('print_buy_orders', 'print_takeaway_orders', 'print_store_orders', 'print_quickpay_orders');
        if (!in_array($type, $array)) {
            return $this->showmessage('该小票类型不存在', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('pjaxurl' => RC_Uri::url('printer/mh_print/order_ticket', array('type' => 'normal'))));
        }
        $store_info = RC_DB::table('store_franchisee')->where('store_id', $_SESSION['store_id'])->first();
        $contact_mobile = RC_DB::table('merchants_config')->where('store_id', $_SESSION['store_id'])->where('code', 'shop_kf_mobile')->pluck('value');

        $data = with(new Ecjia\App\Printer\EventFactory)->event($type)->getDemoValues();
        
        $content = '';
        if ($number > 1) {
        	$content = "<MN>".$number."</MN>";
        }
        if ($type == 'print_buy_orders') {
        	
$content .= "<FS><center>".$store_info['merchants_name']."</center></FS>\r";
if (!empty($contact_mobile)) {
$content .= "<FS><center>".$contact_mobile."</center></FS>\r";	
}
$content .= "订单编号：".$data['order_sn']."
流水编号：".$data['order_trade_no']."
会员账号：".$data['user_name']."
下单时间：".$data['purchase_time']."\r";
if (!empty($data['goods_lists'])) {
$content .= "--------------------------------";
$content .= "<table><tr><td>商品</td><td>数量</td><td>单价</td></tr>";

foreach ($data['goods_lists'] as $k => $v) {
$content .= "<tr><td>".$v['goods_name']."</td><td>".$v['goods_number']."</td><td>".$v['goods_amount']."</td></tr>";
}
$content .= "<tr><td> </td><td> </td><td>总价：".$data['goods_subtotal']."</td></tr></table>";
}

$content .= "--------------------------------
积分抵扣：".$data['integral_money']."  获得积分：".$data['integral_give']."
积分余额：".$data['integral_balance']."
应收金额：".$data['receivables']."
支付宝：".$data['payment']."
--------------------------------
满减满折：".$data['favourable_discount']."
红包折扣：".$data['bonus_discount']."
分头舍去：".$data['rounding']."
实收金额：".$data['order_amount']."  找零金额：".$data['give_change']."
备注内容：".$data['order_remarks']."\r";

        } else if ($type == 'print_takeaway_orders') {
        	
$content .= "<FS><center>".$store_info['merchants_name']."</center></FS>\r";
if (!empty($contact_mobile)) {
$content .= "<FS><center>".$contact_mobile."</center></FS>\r";	
}
$content .= "<FB><center>".$data['payment']."（".$data['pay_status']."）</center></FB>
订单编号：".$data['order_sn']."
流水编号：".$data['order_trade_no']."
下单时间：".$data['purchase_time']."
期望送达时间：".$data['expect_shipping_time']."\r";
if (!empty($data['goods_lists'])) {
$content .= "------------ 商品名 ------------<table><tr><td>商品</td><td>数量</td><td>单价</td></tr>";
foreach ($data['goods_lists'] as $k => $v) {
$content .= "<tr><td>".$v['goods_name']."</td><td>".$v['goods_number']."</td><td>".$v['goods_amount']."</td></tr>";
}
$content .= "<tr><td> </td><td> </td><td>总价：".$data['goods_subtotal']."</td></tr></table>";
}
$content .= "------------- 其他 -------------
积分抵扣：".$data['integral_money']."  获得积分：".$data['integral_give']."
积分余额：".$data['integral_balance']."
应收金额：".$data['receivables']."
微信支付：".$data['wechat_pay']."
--------------------------------
满减满折：".$data['favourable_discount']."
红包折扣：".$data['bonus_discount']."
分头舍去：".$data['rounding']."
实收金额：".$data['order_amount']."
--------------------------------
备注内容：".$data['order_remarks']."
地址：".$data['consignee_address']."
姓名：".$data['consignee_name']."
手机号：".$data['consignee_mobile']."\r";

        } else if ($type == 'print_store_orders') {
        	
$content .= "<FS><center>".$store_info['merchants_name']."</center></FS>\r";
if (!empty($contact_mobile)) {
	$content .= "<FS><center>".$contact_mobile."</center></FS>\r";
}
$content .= "收银员：".$data['cashier']."
订单编号：".$data['order_sn']."
流水编号：".$data['order_trade_no']."
下单时间：".$data['purchase_time']."
商家地址：".$data['merchant_address']."\r";
if (!empty($data['goods_lists'])) {
$content .= "--------------------------------<table><tr><td>商品</td><td>数量</td><td>单价</td></tr>";
foreach ($data['goods_lists'] as $k => $v) {
$content .= "<tr><td>".$v['goods_name']."</td><td>".$v['goods_number']."</td><td>".$v['goods_amount']."</td></tr>";
}
$content .= "<tr><td> </td><td> </td><td>总价：".$data['goods_subtotal']."</td></tr></table>";
}
$content .= "--------------------------------
优惠金额：".$data['discount_amount']."
应收金额：".$data['receivables']."
支付宝：".$data['payment']."
分头舍去：".$data['rounding']."
实收金额：".$data['order_amount']."\r";

        } else if ($type == 'print_quickpay_orders') {
        	
$content .= "<FS><center>".$store_info['merchants_name']."</center></FS>\r";
if (!empty($contact_mobile)) {
	$content .= "<FS><center>".$contact_mobile."</center></FS>\r";
}
$content .= "订单编号：".$data['order_sn']."
流水编号：".$data['order_trade_no']."
会员账号：".$data['user_name']."
买单时间：".$data['purchase_time']."
商家地址：".$data['merchant_address']."\r
----------- 在线买单 -----------
优惠活动：".$data['favourable_activity']."
--------------------------------
应收金额：".$data['receivables']."
优惠金额：".$data['discount_amount']."
支付宝：".$data['payment']."
实收金额：".$data['order_amount']."\r";
       		
        };
        
        $content .= "\r<QR>". $data['order_sn'] ."</QR>\r";
        if (!empty($tail_content)) {
        	$tail_content = str_replace('<br/>', "\r", $tail_content);
        	$content .= "--------------------------------".$tail_content;
        }
        
        $info = RC_DB::table('printer_machine')->where('store_id', $_SESSION['store_id'])->first();
        $order_sn = date('YmdHis') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
        
        $rs = ecjia_printer::printSend($info['machine_code'], $content, $order_sn);
        if (is_ecjia_error($rs)) {
        	return $this->showmessage($rs->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
  		return $this->showmessage('测试打印已发送', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('printer/mh_print/order_ticket', array('type' => $type))));
    }

    public function reprint()
    {
        $this->admin_priv('merchant_printer_update', ecjia::MSGTYPE_JSON);

    }

    public function edit_machine_name()
    {
        $this->admin_priv('merchant_printer_update', ecjia::MSGTYPE_JSON);

        $id           = !empty($_POST['pk']) ? intval($_POST['pk']) : 0;
        $machine_name = !empty($_POST['value']) ? trim($_POST['value']) : '';
        if (empty($machine_name)) {
            return $this->showmessage('请输入小票机名称', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        RC_DB::table('printer_machine')->where('id', $id)->update(array('machine_name' => $machine_name));

        ecjia_merchant::admin_log($machine_name, 'edit', 'machine_name');
        $this->showmessage('小票机名称修改成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
    }

    public function edit_machine_mobile()
    {
        $this->admin_priv('merchant_printer_update', ecjia::MSGTYPE_JSON);

        $id             = !empty($_POST['pk']) ? intval($_POST['pk']) : 0;
        $machine_mobile = !empty($_POST['value']) ? trim($_POST['value']) : '';
        if (empty($machine_mobile)) {
            return $this->showmessage('请输入手机卡号', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        RC_DB::table('printer_machine')->where('id', $id)->update(array('machine_mobile' => $machine_mobile));
        $this->showmessage('手机卡号修改成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
    }

    public function upload_logo()
    {
        $this->admin_priv('merchant_printer_update', ecjia::MSGTYPE_JSON);

        $id = !empty($_POST['id']) ? intval($_POST['id']) : 0;

        $file_name = '';
        /* 处理上传的LOGO图片 */
        if ((isset($_FILES['machine_logo']['error']) && $_FILES['machine_logo']['error'] == 0) || (!isset($_FILES['machine_logo']['error']) && isset($_FILES['machine_logo']['tmp_name']) && $_FILES['machine_logo']['tmp_name'] != 'none')) {
            $upload     = RC_Upload::uploader('image', array('save_path' => 'data/printer', 'auto_sub_dirs' => false));
            $image_info = $upload->upload($_FILES['machine_logo']);

            if (!empty($image_info)) {
                $file_name = $upload->get_position($image_info);
            } else {
                return $this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
        }

        $info = RC_DB::table('printer_machine')->where('store_id', $_SESSION['store_id'])->where('id', $id)->first();
        if (!empty($file_name)) {
        	$rs = ecjia_printer::setIcon($info['machine_code'], RC_Upload::upload_url($file_name));
        	if (is_ecjia_error($rs)) {
        		return $this->showmessage($rs->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        	}
            //删除旧logo
            if (!empty($info['machine_logo'])) {
                $disk = RC_Filesystem::disk();
                $disk->delete(RC_Upload::upload_path() . $info['machine_logo']);
            }
        } else {
            $file_name = $info['machine_logo'];
        }

        ecjia_merchant::admin_log($info['machine_logo'], 'edit', 'machine_logo');
        RC_DB::table('printer_machine')->where('store_id', $_SESSION['store_id'])->where('id', $id)->update(array('machine_logo' => $file_name));
        $this->showmessage('上传成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('printer/mh_print/view', array('id' => $id))));
    }

    public function del_file()
    {
        $this->admin_priv('merchant_printer_update', ecjia::MSGTYPE_JSON);

        $id = !empty($_GET['id']) ? intval($_GET['id']) : 0;

        $info = RC_DB::table('printer_machine')->where('store_id', $_SESSION['store_id'])->where('id', $id)->first();
        if (!empty($info['machine_logo'])) {
        	$rs = ecjia_printer::deleteIcon($info['machine_code']);
        	if (is_ecjia_error($rs)) {
        		return $this->showmessage($rs->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        	}
            $disk = RC_Filesystem::disk();
            $disk->delete(RC_Upload::upload_path() . $info['machine_logo']);
        }

        RC_DB::table('printer_machine')->where('store_id', $_SESSION['store_id'])->where('id', $id)->update(array('machine_logo' => ''));
        ecjia_merchant::admin_log($info['machine_logo'], 'remove', 'machine_logo');
        $this->showmessage('删除成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('printer/mh_print/view', array('id' => $id))));
    }

    public function order_ticket()
    {
        $this->admin_priv('merchant_printer_manage');

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here('小票打印设置'));
        $this->assign('ur_here', '小票打印设置');

        $type  = trim($_GET['type']);
        $array = array('print_buy_orders', 'print_takeaway_orders', 'print_store_orders', 'print_quickpay_orders');
        if (!in_array($type, $array)) {
            return $this->showmessage('该小票类型不存在', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('pjaxurl' => RC_Uri::url('printer/mh_print/order_ticket', array('type' => 'normal'))));
        }
        $template_subject = '普通订单小票';
        if ($type == 'print_takeaway_orders') {
        	$template_subject = '外卖订单小票';
        } elseif ($type == 'print_store_orders') {
        	$template_subject = '到店购物小票';
        } elseif ($type == 'print_quickpay_orders') {
        	$template_subject = '优惠买单小票';
        }
        $this->assign('template_subject', $template_subject);
        $this->assign('type', $type);
        
        $store  = RC_DB::table('store_franchisee')->where('store_id', $_SESSION['store_id'])->first();
        $config = RC_DB::table('merchants_config')->where('store_id', $_SESSION['store_id'])->where('code', 'shop_logo')->first();
        if (!empty($config['value'])) {
            $store['shop_logo'] = RC_Upload::upload_url($config['value']);
        } else {
            $store['shop_logo'] = RC_App::apps_url('statics/images/merchant_logo.png', __FILE__);
        }
        $this->assign('store', $store);
        $this->assign('form_action', RC_Uri::url('printer/mh_print/insert_template'));
        $this->assign('print_order_ticker', RC_Uri::url('printer/mh_print/print_order_ticker'));
        
        $info = RC_DB::table('printer_template')->where('store_id', $_SESSION['store_id'])->where('template_code', $type)->first();
        $this->assign('info', $info);
        
        $demo_values = with(new Ecjia\App\Printer\EventFactory)->event($type)->getDemoValues();
        $this->assign('data', $demo_values);
        
        $contact_mobile = RC_DB::table('merchants_config')->where('store_id', $_SESSION['store_id'])->where('code', 'shop_kf_mobile')->pluck('value');
        $this->assign('contact_mobile', $contact_mobile);
        
        $this->display('printer_order_ticket.dwt');
    }

    public function insert_template()
    {
        $this->admin_priv('merchant_printer_update', ecjia::MSGTYPE_JSON);
        
        $template_subject = !empty($_POST['template_subject']) 	? trim($_POST['template_subject']) 	: '';
        $template_code 	  = !empty($_POST['template_code']) 	? trim($_POST['template_code']) 	: '';
        $print_number 	  = !empty($_POST['print_number']) 		? (intval($_POST['print_number']) > 9 ? 9 : intval($_POST['print_number'])) : 1;
        $status           = !empty($_POST['status'])			? intval($_POST['status']) 			: 0;
        $auto_print       = !empty($_POST['auto_print'])		? intval($_POST['auto_print']) 		: 0;
		$tail_content     = !empty($_POST['tail_content'])		? $_POST['tail_content']			: '';
		
		$data = array(
			'template_subject' 	=> $template_subject,
			'template_code' 	=> $template_code,
			'print_number' 		=> $print_number,
			'status' 			=> $status,
			'auto_print' 		=> $auto_print,
			'tail_content' 		=> $tail_content,
			'last_modify'		=> RC_Time::gmtime()
		);
		
		$info = RC_DB::table('printer_template')->where('store_id', $_SESSION['store_id'])->where('template_code', $template_code)->first();
		if (!empty($info)) {
			ecjia_merchant::admin_log($template_subject, 'edit', 'printer_template');
			RC_DB::table('printer_template')->where('store_id', $_SESSION['store_id'])->where('id', $info['id'])->update($data);
		} else {
			$data['store_id'] = $_SESSION['store_id'];
			$data['add_time'] = RC_Time::gmtime();
			RC_DB::table('printer_template')->insert($data);
			ecjia_merchant::admin_log($template_subject, 'add', 'printer_template');
		}
		$this->showmessage('保存成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('printer/mh_print/order_ticket', array('type' => $template_code))));
    }

    private function get_record_list()
    {
        $db_printer_view = RC_DB::table('printer_printlist as p')
            ->leftJoin('printer_machine as m', RC_DB::raw('p.machine_code'), '=', RC_DB::raw('m.machine_code'))
            ->where(RC_DB::raw('p.store_id'), $_SESSION['store_id']);

        $count = $db_printer_view->count();
        $page  = new ecjia_merchant_page($count, 10, 5);
        $data  = $db_printer_view->selectRaw('p.*, m.machine_name')->take(10)->skip($page->start_id - 1)->orderBy('id', 'desc')->get();

        return array('item' => $data, 'page' => $page->show(2), 'desc' => $page->page_desc());
    }

    private function get_print_count()
    {
        $week_start_time     = RC_Time::local_mktime(0, 0, 0, RC_Time::local_date("m"), RC_Time::local_date("d") - RC_Time::local_date("w") + 1, RC_Time::local_date("Y"));
        $count['week_count'] = RC_DB::table('printer_printlist')
            ->where('store_id', $_SESSION['store_id'])
            ->where('machine_code', $info['machine_code'])
            ->where('status', 1)
            ->where('print_time', '>', $week_start_time)
            ->where('print_time', '<', RC_Time::gmtime())
            ->SUM('print_count');

        $now                        = RC_Time::gmtime();
        $start                      = RC_Time::local_mktime(0, 0, 0, RC_Time::local_date("m", $now), RC_Time::local_date("d", $now), RC_Time::local_date("Y", $now));
        $count['today_print_count'] = RC_DB::table('printer_printlist')
            ->where('store_id', $_SESSION['store_id'])
            ->where('machine_code', $info['machine_code'])
            ->where('status', 1)
            ->where('print_time', '>', $start)
            ->where('print_time', '<', RC_Time::gmtime())
            ->SUM('print_count');
        $count['today_unprint_count'] = RC_DB::table('printer_printlist')
            ->where('store_id', $_SESSION['store_id'])
            ->where('machine_code', $info['machine_code'])
            ->where('status', '!=', 1)
            ->where('print_time', '>', $start)
            ->where('print_time', '<', RC_Time::gmtime())
            ->SUM('print_count');

        return $count;
    }
}

//end