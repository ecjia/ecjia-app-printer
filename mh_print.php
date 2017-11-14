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
 * 打印机管理
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
     * 打印机管理
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
            return $this->showmessage('该打印机不存在', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        if (!empty($info['printer_logo'])) {
            $info['printer_logo'] = RC_Upload::upload_url($info['printer_logo']);
        }
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here('查看打印机'));

        $this->assign('action_link', array('href' => RC_Uri::url('printer/mh_print/init'), 'text' => '打印机管理'));
        $this->assign('ur_here', '查看打印机');
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

        $this->showmessage('取消成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('printer/mh_print/view', array('id' => $id))));
    }

    public function close()
    {
        $this->admin_priv('merchant_printer_update', ecjia::MSGTYPE_JSON);

        $id = !empty($_GET['id']) ? intval($_GET['id']) : 0;

        RC_DB::table('printer_machine')->where('store_id', $_SESSION['store_id'])->where('id', $id)->update(array('online_status' => 0));
        $this->showmessage('关闭成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('printer/mh_print/view', array('id' => $id))));
    }

    public function voice_control()
    {
        $this->admin_priv('merchant_printer_update', ecjia::MSGTYPE_JSON);

        $id    = !empty($_GET['id']) ? intval($_GET['id']) : 0;
        $type  = isset($_POST['type']) ? trim($_POST['type']) : '';
        $voice = isset($_POST['voice']) ? intval($_POST['voice']) : 0;

        if (!empty($type)) {
            $type = $type == 'buzzer' ? 'horn' : 'buzzer';
            RC_DB::table('printer_machine')->where('store_id', $_SESSION['store_id'])->where('id', $id)->update(array('voice_type' => $type));
            $this->showmessage('响铃类型修改成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('printer/mh_print/view', array('id' => $id))));
        } else if (!empty($voice)) {
            RC_DB::table('printer_machine')->where('store_id', $_SESSION['store_id'])->where('id', $id)->update(array('voice' => $voice));
            $this->showmessage('音量修改成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('printer/mh_print/view', array('id' => $id))));
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
    
    public function print_test() {
    	$this->admin_priv('merchant_printer_update', ecjia::MSGTYPE_JSON);
    	$type = trim($_POST['id']);
    	$array = array('normal', 'take_out', 'store_buy', 'pay_bill');
    	if (!in_array($type, $array)) {
    		return $this->showmessage('该小票类型不存在', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('pjaxurl' => RC_Uri::url('printer/mh_print/order_ticket', array('type' => 'normal'))));
    	}
    	if ($type == 'normal') {
    		$content = "<FS><center>华联超市</center></FS>
<FS><center>4000-000-000</center></FS>
订单编号：********\r
流水编号：********\r
会员账号：********\r
下单时间：0000-00-00 00:00:00
<center>--------------------------------</center>
<table><tr><td>商品</td><td>数量</td><td>单价</td></tr><tr><td>***</td><td>***</td><td>***</td></tr><tr><td></td><td>0</td><td>0</td></tr></table><FS><right>总价：0.00</right></FS>
<center>--------------------------------</center>
积分抵扣：-0.00  获得积分：0.00\r
积分余额：0.00\r
应收金额：0.00\r
支付宝：0.00
<center>--------------------------------</center>
满减满折：-0.00\r
红包折扣：-0.00\r
分头舍去：-0.00\r
实收金额：0.00  找零金额：0.00
<center>--------------------------------</center>
备注内容：* * * * * * * * * *\r
* * * * * * * * * *
<center>请妥善保管好购物凭证</center>
<center>谢谢惠顾欢迎下次光临</center><right>页1</right>"; 	
    		
		} else if ($type == 'take_out') {
    		$content = "<FS><center>华联超市</center></FS>
<FS><center>4000-000-000</center></FS>
<FB><center>微信支付（已支付）</center></FB>
订单编号：********\r
流水编号：********\r
下单时间：0000-00-00 00:00:00\r
期望送达时间：0000-00-00 00:00:00
<center>----------- 商品名 -------------</center>
<table><tr><td>商品</td><td>数量</td><td>单价</td></tr><tr><td>***</td><td>***</td><td>***</td></tr><tr><td></td><td>0</td><td>0</td></tr></table><FS><right>总价：0.00</right></FS>
<center>-------------- 其他 ------------</center>
积分抵扣：-0.00  获得积分：0.00\r
积分余额：0.00\r
应收金额：0.00\r
微信支付：0.00
<center>--------------------------------</center>
满减满折：-0.00\r
红包折扣：-0.00\r
分头舍去：-0.00
<center>--------------------------------</center>
备注内容：* * * * * * * * * *\r
* * * * * * * * * *\r
地址：上海市普陀区中山北路\r
3553号301室\r
姓名：张三\r
手机号：15000000000";
    		
    	} else if ($type == 'store_buy') {
		$content = "<FS><center>华联超市</center></FS>
<FS><center>4000-000-000</center></FS>
收银员：********\r
订单编号：********\r
流水编号：********\r
下单时间：0000-00-00 00:00:00\r
商家地址：上海市普陀区中山北路
<center>--------------------------------</center>
<table><tr><td>商品</td><td>数量</td><td>单价</td></tr><tr><td>***</td><td>***</td><td>***</td></tr><tr><td></td><td>0</td><td>0</td></tr></table><FS><right>总价：0.00</right></FS>
<center>--------------------------------</center>
优惠金额：0.00\r
应收金额：0.00\r
支付宝：0.00\r
分头舍去：-0.00\r
实收金额：0.00";
		
    	} else if ($type == 'pay_bill') {
		$content = "<FS><center>华联超市</center></FS>
<FS><center>4000-000-000</center></FS>
订单编号：********\r
流水编号：********\r
会员账号：********\r				
买单时间：0000-00-00 00:00:00\r
商家地址：上海市普陀区中山北路
<center>----------- 在线买单 -----------</center>
优惠活动：满多少减多少
<center>--------------------------------</center>
应收金额：-0.00\r
优惠金额：-0.00\r
支付宝：0.00\r
实收金额：0.00";
    	};
    	$res = Ecjia\App\Printer\YLY\YLYOpenApiClient::printIndex('4004525345', '7bc6a6fe2e314ad9b144de26b5231e69', $content, Royalcms\Component\Uuid\Uuid::generate(), SYS_TIME);
    	$result = json_decode($res, true);
    	if ($result['error'] != 0) {
    		return $this->showmessage($result['error_description'], ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    	}
    	return $this->showmessage('测试打印成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('printer/mh_print/order_ticket', array('type' => $type))));
    }
    
    public function printer_test() {
    	$this->admin_priv('merchant_printer_update', ecjia::MSGTYPE_JSON);
    	 
    	$id       = !empty($_POST['id']) ? intval($_POST['id']) : 0;
    	 
    	$content = !empty($_POST['content']) ?  strip_tags($_POST['content']): '';
    	if (empty($content)) {
    		return $this->showmessage('请输入要打印的内容', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    	}
    	$res = Ecjia\App\Printer\YLY\YLYOpenApiClient::printIndex('4004525345', '7bc6a6fe2e314ad9b144de26b5231e69', $content, Royalcms\Component\Uuid\Uuid::generate(), SYS_TIME);
    	$result = json_decode($res, true);
    	if ($result['error'] != 0) {
    		return $this->showmessage($result['error_description'], ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    	}
    	return $this->showmessage('测试打印成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('printer/mh_print/view', array('id' => $id))));
    }

    public function reprint()
    {
        $this->admin_priv('merchant_printer_update', ecjia::MSGTYPE_JSON);

    }

    public function edit_printer_name()
    {
        $this->admin_priv('merchant_printer_update', ecjia::MSGTYPE_JSON);

        $id           = !empty($_POST['pk']) ? intval($_POST['pk']) : 0;
        $printer_name = !empty($_POST['value']) ? trim($_POST['value']) : '';
        if (empty($printer_name)) {
            return $this->showmessage('请输入打印机名称', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        RC_DB::table('printer_machine')->where('id', $id)->update(array('printer_name' => $printer_name));

        ecjia_merchant::admin_log($printer_name, 'edit', 'printer_name');
        $this->showmessage('打印机名称修改成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
    }

    public function edit_printer_mobile()
    {
        $this->admin_priv('merchant_printer_update', ecjia::MSGTYPE_JSON);

        $id             = !empty($_POST['pk']) ? intval($_POST['pk']) : 0;
        $printer_mobile = !empty($_POST['value']) ? trim($_POST['value']) : '';
        if (empty($printer_mobile)) {
            return $this->showmessage('请输入手机卡号', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        RC_DB::table('printer_machine')->where('id', $id)->update(array('printer_mobile' => $printer_mobile));
        $this->showmessage('手机卡号修改成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
    }

    public function upload_logo()
    {
        $this->admin_priv('merchant_printer_update', ecjia::MSGTYPE_JSON);

        $id = !empty($_POST['id']) ? intval($_POST['id']) : 0;

        $file_name = '';
        /* 处理上传的LOGO图片 */
        if ((isset($_FILES['printer_logo']['error']) && $_FILES['printer_logo']['error'] == 0) || (!isset($_FILES['printer_logo']['error']) && isset($_FILES['printer_logo']['tmp_name']) && $_FILES['printer_logo']['tmp_name'] != 'none')) {
            $upload     = RC_Upload::uploader('image', array('save_path' => 'data/printer', 'auto_sub_dirs' => false));
            $image_info = $upload->upload($_FILES['printer_logo']);

            if (!empty($image_info)) {
                $file_name = $upload->get_position($image_info);
            } else {
                return $this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
        }

        $info = RC_DB::table('printer_machine')->where('store_id', $_SESSION['store_id'])->where('id', $id)->first();
        if (!empty($file_name)) {
            //删除旧logo
            if (!empty($info['printer_logo'])) {
                $disk = RC_Filesystem::disk();
                $disk->delete(RC_Upload::upload_path() . $info['printer_logo']);
            }
        } else {
            $file_name = $info['printer_logo'];
        }

        ecjia_merchant::admin_log($info['printer_logo'], 'edit', 'printer_logo');
        RC_DB::table('printer_machine')->where('store_id', $_SESSION['store_id'])->where('id', $id)->update(array('printer_logo' => $file_name));
        $this->showmessage('上传成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('printer/mh_print/view', array('id' => $id))));
    }

    public function del_file()
    {
        $this->admin_priv('merchant_printer_update', ecjia::MSGTYPE_JSON);

        $id = !empty($_GET['id']) ? intval($_GET['id']) : 0;

        $info = RC_DB::table('printer_machine')->where('store_id', $_SESSION['store_id'])->where('id', $id)->first();
        if (!empty($info['printer_logo'])) {
            $disk = RC_Filesystem::disk();
            $disk->delete(RC_Upload::upload_path() . $info['printer_logo']);
        }

        RC_DB::table('printer_machine')->where('store_id', $_SESSION['store_id'])->where('id', $id)->update(array('printer_logo' => ''));
        ecjia_merchant::admin_log($info['printer_logo'], 'remove', 'printer_logo');
        $this->showmessage('删除成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('printer/mh_print/view', array('id' => $id))));
    }

    public function order_ticket()
    {
        $this->admin_priv('merchant_printer_manage');

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here('小票打印设置'));
        $this->assign('ur_here', '小票打印设置');

        $type  = trim($_GET['type']);
        $array = array('normal', 'take_out', 'store_buy', 'pay_bill');
        if (!in_array($type, $array)) {
            return $this->showmessage('该小票类型不存在', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('pjaxurl' => RC_Uri::url('printer/mh_print/order_ticket', array('type' => 'normal'))));
        }
        $store  = RC_DB::table('store_franchisee')->where('store_id', $_SESSION['store_id'])->first();
        $config = RC_DB::table('merchants_config')->where('store_id', $_SESSION['store_id'])->where('code', 'shop_logo')->first();
        if (!empty($config['value'])) {
            $store['shop_logo'] = RC_Upload::upload_url($config['value']);
        } else {
            $store['shop_logo'] = RC_App::apps_url('statics/images/merchant_logo.png', __FILE__);
        }
        $this->assign('store', $store);
        $this->assign('form_action', RC_Uri::url('printer/mh_print/insert_template'));
        $this->assign('print_test', RC_Uri::url('printer/mh_print/print_test'));
        
        $this->display('printer_order_ticket.dwt');
    }

    public function insert_template()
    {
        $this->admin_priv('merchant_printer_update', ecjia::MSGTYPE_JSON);

    }

    public function print_order()
    {

    }

    private function get_record_list()
    {
        $db_printer_view = RC_DB::table('printer_printlist as p')
            ->leftJoin('printer_machine as m', RC_DB::raw('p.printer_code'), '=', RC_DB::raw('m.printer_code'))
            ->where(RC_DB::raw('p.store_id'), $_SESSION['store_id']);

        $count = $db_printer_view->count();
        $page  = new ecjia_merchant_page($count, 10, 5);
        $data  = $db_printer_view->selectRaw('p.*, m.printer_name')->take(10)->skip($page->start_id - 1)->orderBy('id', 'desc')->get();

        return array('item' => $data, 'page' => $page->show(2), 'desc' => $page->page_desc());
    }

    private function get_print_count()
    {
        $week_start_time     = RC_Time::local_mktime(0, 0, 0, RC_Time::local_date("m"), RC_Time::local_date("d") - RC_Time::local_date("w") + 1, RC_Time::local_date("Y"));
        $count['week_count'] = RC_DB::table('printer_printlist')
            ->where('store_id', $_SESSION['store_id'])
            ->where('printer_code', $info['printer_code'])
            ->where('status', 1)
            ->where('print_time', '>', $week_start_time)
            ->where('print_time', '<', RC_Time::gmtime())
            ->SUM('print_count');

        $now                        = RC_Time::gmtime();
        $start                      = RC_Time::local_mktime(0, 0, 0, RC_Time::local_date("m", $now), RC_Time::local_date("d", $now), RC_Time::local_date("Y", $now));
        $count['today_print_count'] = RC_DB::table('printer_printlist')
            ->where('store_id', $_SESSION['store_id'])
            ->where('printer_code', $info['printer_code'])
            ->where('status', 1)
            ->where('print_time', '>', $start)
            ->where('print_time', '<', RC_Time::gmtime())
            ->SUM('print_count');
        $count['today_unprint_count'] = RC_DB::table('printer_printlist')
            ->where('store_id', $_SESSION['store_id'])
            ->where('printer_code', $info['printer_code'])
            ->where('status', '!=', 1)
            ->where('print_time', '>', $start)
            ->where('print_time', '<', RC_Time::gmtime())
            ->SUM('print_count');

        return $count;
    }
}

//end
